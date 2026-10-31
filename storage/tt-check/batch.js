// Usage: node batch.js <mode: base|new> <port> <outDir> [slug,slug,...]
// Runs the real tool test for every tools page in a real Chrome, then exercises the table
// (search, paging, rows-per-page, CSV + XLSX download) and records everything to JSON.
// mode "base" blocks tools-table.css/js so we get the OLD design for an A/B comparison.
const fs = require('fs');
const path = require('path');
const { execFileSync } = require('child_process');
const puppeteer = require('/Users/flake/.nvm/versions/node/v22.20.0/lib/node_modules/lighthouse/node_modules/puppeteer-core');

const [mode, port, outDir, only] = process.argv.slice(2);
const ALL = 'meta-title meta-description robots-meta canonical-url images url-slug robotstxt headings xml-sitemap schema og-tags twitter-tags favicon meta-viewport doctype http-status-code html-sitemap google-page-speed-insights google-lighthouse google-core-web-vitals mobile-friendliness gzip-compression html-compression css-compression js-compression css-caching-test js-caching-test page-size nested-tables frameset broken-links safe-browsing-test unsafe-cross-origin-links-test protocall-relative-resource-links-test content-security-policy-header-test x-frame-options-header-test hsts-header-test bad-content-type-test ssl-certificate-test directory-browsing-test'.split(' ');
const slugs = only ? only.split(',') : ALL;
const URLS = ['https://example.com', 'https://www.python.org'];
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
fs.mkdirSync(outDir, { recursive: true });

(async () => {
  const browser = await puppeteer.launch({
    executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
    headless: 'new',
    args: ['--no-sandbox', '--user-data-dir=/tmp/pt/profile-b-' + mode + process.pid],
    defaultViewport: { width: 1440, height: 1000 },
  });

  for (const slug of slugs) {
    const rec = { slug, mode, errors: [], notes: [] };
    const dl = path.join(outDir, 'dl-' + slug);
    fs.rmSync(dl, { recursive: true, force: true });
    fs.mkdirSync(dl, { recursive: true });
    const page = await browser.newPage();
    try {
      const client = await page.createCDPSession();
      await client.send('Browser.setDownloadBehavior', { behavior: 'allow', downloadPath: dl });
      await page.setRequestInterception(true);
      page.on('request', (req) => {
        const u = req.url();
        if (mode === 'base' && /tools-table\.(css|js)/.test(u)) return req.abort();
        // NOTE (test harness only): the app's Meta Description label posts to /test/description but the route is
        // /test/meta-description. Re-point it here so that tool's table can be exercised at all.
        if (/\/test\/description$/.test(u)) return req.continue({ url: u.replace('/test/description', '/test/meta-description') });
        req.continue();
      });
      page.on('pageerror', (e) => rec.errors.push('pageerror: ' + e.message));
      page.on('dialog', (d) => { rec.notes.push('dialog: ' + d.message()); d.dismiss(); });

      await page.goto(`http://127.0.0.1:${port}/tools/${slug}`, { waitUntil: 'domcontentloaded', timeout: 60000 });
      await page.waitForSelector('#startTestBulk', { timeout: 60000 });
      await sleep(800);
      await page.evaluate((u) => { document.querySelector('#urlValue').value = u.join('\n'); }, URLS);
      const t0 = Date.now();
      await page.click('#startTestBulk');
      try {
        await page.waitForSelector('.test_result_area table', { timeout: 170000 });
        rec.table = true;
      } catch (e) {
        rec.table = false;
        rec.notes.push('no table after 170s');
      }
      await sleep(2500);
      rec.seconds = Math.round((Date.now() - t0) / 1000);

      // anything the page itself reported (failed URLs etc.)
      rec.alerts = await page.evaluate(() => [...document.querySelectorAll('.alert, .failed-list, .invalid-feedback')].map((e) => e.textContent.trim().replace(/\s+/g, ' ').slice(0, 160)).filter(Boolean));

      if (rec.table) {
        Object.assign(rec, await page.evaluate(() => {
          const out = {};
          const tables = [...document.querySelectorAll('.test_result_area table')];
          out.tableCount = tables.length;
          out.tables = tables.map((t) => {
            let rows;
            try { rows = $(t).DataTable().rows().nodes().toArray(); } catch (e) { rows = [...t.querySelectorAll('tbody tr')]; }
            const vis = (el) => !el.classList.contains('d-none') && !el.classList.contains('hidden-element');
            return {
              id: t.id,
              headers: [...t.querySelectorAll('thead th')].filter(vis).map((th) => th.textContent.replace(/\s+/g, ' ').trim()),
              rows: rows.map((tr) => [...tr.children].filter(vis).map((td) => td.textContent.replace(/\s+/g, ' ').trim())),
              classes: rows.map((tr) => [...tr.children].filter(vis).map((td) => (td.className || '').replace(/\s+/g, ' ').trim())),
            };
          });
          out.pagination = (document.querySelector('#pagination-info') || {}).textContent || null;
          out.pills = document.querySelectorAll('.test_result_area .tpt-pill').length;
          out.badTextOverflow = [...document.querySelectorAll('.test_result_area table tbody td')].filter((td) => td.offsetParent && td.scrollWidth > td.clientWidth + 2).length;
          return out;
        }));

        // ---- interactions -------------------------------------------------------------------
        const inter = {};
        const visibleRows = () => page.evaluate(() => [...document.querySelectorAll('.test_result_area table:not(.d-none) tbody tr')].filter((r) => r.offsetParent).length);
        inter.rowsBefore = await visibleRows();
        if (await page.$('#custom-search')) {
          await page.type('#custom-search', 'zzzz-no-such-text');
          await sleep(500);
          inter.rowsAfterNoMatchSearch = await visibleRows();
          inter.infoAfterSearch = await page.evaluate(() => (document.querySelector('#pagination-info') || {}).textContent);
          await page.evaluate(() => { const i = document.querySelector('#custom-search'); i.value = ''; i.dispatchEvent(new Event('input', { bubbles: true })); });
          await sleep(400);
          inter.rowsAfterClear = await visibleRows();
          await page.type('#custom-search', 'example');
          await sleep(500);
          inter.rowsAfterExample = await visibleRows();
          await page.evaluate(() => { const i = document.querySelector('#custom-search'); i.value = ''; i.dispatchEvent(new Event('input', { bubbles: true })); });
          await sleep(300);
        }
        if (await page.$('#rows-per-page')) {
          await page.select('#rows-per-page', '30');
          await sleep(300);
          inter.infoRows30 = await page.evaluate(() => document.querySelector('#pagination-info').textContent);
          await page.select('#rows-per-page', '10');
          await sleep(300);
          await page.click('#next-page');
          await sleep(300);
          inter.infoAfterNext = await page.evaluate(() => document.querySelector('#pagination-info').textContent);
          await page.click('#prev-page');
          await sleep(300);
          inter.infoAfterPrev = await page.evaluate(() => document.querySelector('#pagination-info').textContent);
        }
        // downloads
        const csvBtn = await page.$('.download-csv-bulk button');
        const xlsBtn = await page.$('.download-xlsx-bulk button');
        if (csvBtn) { await csvBtn.click(); await sleep(1500); }
        if (xlsBtn) { await xlsBtn.click(); await sleep(2500); }
        const files = fs.readdirSync(dl);
        inter.downloads = files;
        const csv = files.find((f) => f.endsWith('.csv'));
        const xlsx = files.find((f) => f.endsWith('.xlsx'));
        if (csv) rec.csv = fs.readFileSync(path.join(dl, csv), 'utf8');
        if (xlsx) {
          try { rec.xlsxSheet = execFileSync('unzip', ['-p', path.join(dl, xlsx), 'xl/worksheets/sheet1.xml']).toString(); } catch (e) { rec.notes.push('xlsx unzip failed'); }
        }
        rec.interactions = inter;
        // multi-table tools (og / twitter): click each tab
        const tabs = await page.$$('.table-cat-element');
        if (tabs.length) {
          inter.tabs = [];
          for (const tab of tabs) {
            await tab.click();
            await sleep(300);
            inter.tabs.push(await page.evaluate(() => [...document.querySelectorAll('.test_result_area table')].filter((t) => !t.classList.contains('d-none') && t.offsetParent).length));
          }
        }
      }
      await page.evaluate(() => window.scrollTo(0, 0));
      const area = await page.$('.test_result_area');
      if (area) await area.screenshot({ path: path.join(outDir, slug + '.png') });
    } catch (e) {
      rec.errors.push('runner: ' + e.message);
    }
    fs.writeFileSync(path.join(outDir, slug + '.json'), JSON.stringify(rec, null, 1));
    console.log(mode, slug, 'table=' + rec.table, 'rows=' + (rec.tables ? rec.tables.map((t) => t.rows.length).join('/') : '-'), 'pills=' + rec.pills, 'errors=' + rec.errors.length, (rec.seconds || 0) + 's');
    await page.close();
  }
  await browser.close();
})();
