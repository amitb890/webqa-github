// Usage: node run.js <slug> <outPrefix> [urls comma-separated] [width]
const puppeteer = require('/Users/flake/.nvm/versions/node/v22.20.0/lib/node_modules/lighthouse/node_modules/puppeteer-core');
const BASE = process.env.BASE || 'http://127.0.0.1:8765';
const slug = process.argv[2] || 'meta-title';
const out = process.argv[3] || ('/Applications/XAMPP/xamppfiles/htdocs/webqa-github/storage/tt-check/' + slug);
const urls = (process.argv[4] || 'https://example.com,https://www.iana.org/domains/reserved').split(',');
const width = parseInt(process.argv[5] || '1440', 10);

(async () => {
  const browser = await puppeteer.launch({
    executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
    headless: 'new',
    args: ['--no-sandbox', '--user-data-dir=/Applications/XAMPP/xamppfiles/htdocs/webqa-github/storage/tt-check/profile-' + process.pid],
    defaultViewport: { width, height: 1000 },
  });
  const page = await browser.newPage();
  const errors = [];
  page.on('pageerror', e => errors.push('pageerror: ' + e.message));
  page.on('console', m => { if (m.type() === 'error') errors.push('console: ' + m.text()); });
  await page.goto(`${BASE}/tools/${slug}`, { waitUntil: 'networkidle2', timeout: 60000 });
  await page.evaluate((u) => { document.querySelector('#urlValue').value = u.join('\n'); }, urls);
  await page.click('#startTestBulk');
  try {
    await page.waitForSelector('.test_result_area table', { timeout: 120000 });
  } catch (e) {
    console.log('NO TABLE for', slug);
  }
  await new Promise(r => setTimeout(r, 1500));
  const info = await page.evaluate(() => {
    const t = document.querySelector('.test_result_area table');
    return {
      hasTable: !!t,
      rows: t ? t.querySelectorAll('tbody tr').length : 0,
      headers: t ? [...t.querySelectorAll('thead th')].filter(th => th.offsetParent).map(th => th.textContent.trim()) : [],
      firstRow: t ? [...(t.querySelector('tbody tr') || { children: [] }).children].filter(td => td.offsetParent).map(td => td.textContent.trim().slice(0, 60)) : [],
    };
  });
  console.log(JSON.stringify(info, null, 1));
  const area = await page.$('.test_result_area');
  if (area) {
    await area.screenshot({ path: out + '.png' }); require('fs').writeFileSync(out + '.html', await page.evaluate(() => document.querySelector('.test_result_area').outerHTML.replace(/<svg[\s\S]*?<\/svg>/g,'<svg/>')));
  }
  console.log('errors:', errors.slice(0, 8));
  await browser.close();
})().catch(e => { console.error(e); process.exit(1); });
