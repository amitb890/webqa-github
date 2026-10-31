// Usage: node inspect.js <slug> <outPrefix> ; prints computed styles for selected nodes and takes a 2x screenshot
const puppeteer = require('/Users/flake/.nvm/versions/node/v22.20.0/lib/node_modules/lighthouse/node_modules/puppeteer-core');
const slug = process.argv[2] || 'meta-title';
const out = process.argv[3];
(async () => {
  const browser = await puppeteer.launch({
    executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
    headless: 'new', args: ['--no-sandbox', '--user-data-dir=/tmp/pt/profile-i' + process.pid],
    defaultViewport: { width: 1440, height: 1000, deviceScaleFactor: 2 },
  });
  const page = await browser.newPage();
  await page.goto(`http://127.0.0.1:8765/tools/${slug}`, { waitUntil: 'networkidle2' });
  await page.evaluate(() => { document.querySelector('#urlValue').value = 'https://example.com\nhttps://www.iana.org/domains/reserved'; });
  await page.click('#startTestBulk');
  await page.waitForSelector('.test_result_area table', { timeout: 120000 });
  await new Promise(r => setTimeout(r, 1500));
  const res = await page.evaluate(() => {
    const q = s => document.querySelector(s);
    const pick = (el) => { if (!el) return null; const c = getComputedStyle(el); return { cls: el.className, br: c.borderRadius, border: c.border, bb: c.borderBottom, bg: c.backgroundColor, shadow: c.boxShadow, overflow: c.overflow, ff: c.fontFamily }; };
    return {
      card: pick(q('.test_result_table')),
      dl: pick(q('.bulk-download-result')),
      ul: pick(q('.bulk-datatable-download-result')),
      tr: pick(q('.test_result_table .table-responsive')),
      wrap: pick(q('.dataTables_wrapper')),
      table: pick(q('table.bulk-table')),
      th: pick(q('table.bulk-table th')),
    };
  });
  console.log(JSON.stringify(res, null, 1));
  const el = await page.$('.test_result_area');
  
  await el.screenshot({ path: out + '.png' });
  await browser.close();
})();
