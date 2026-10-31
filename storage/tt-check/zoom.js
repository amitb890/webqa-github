// Usage: node zoom.js <slug> <outPrefix> <selector> [w] [h]  -> 2x crop of the top-left of selector's box
const puppeteer = require('/Users/flake/.nvm/versions/node/v22.20.0/lib/node_modules/lighthouse/node_modules/puppeteer-core');
const [slug, out, sel = '.test_result_table', w = '620', h = '260', urls = 'https://example.com,https://www.iana.org/domains/reserved'] = process.argv.slice(2);
(async () => {
  const browser = await puppeteer.launch({ executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome', headless: 'new', args: ['--no-sandbox', '--user-data-dir=/tmp/pt/profile-z' + process.pid], defaultViewport: { width: 1440, height: 1000, deviceScaleFactor: 2 } });
  const page = await browser.newPage();
  await page.goto(`http://127.0.0.1:8765/tools/${slug}`, { waitUntil: 'networkidle2' });
  await page.evaluate((u) => { document.querySelector('#urlValue').value = u.split(',').join('\n'); }, urls);
  await page.click('#startTestBulk');
  await page.waitForSelector('.test_result_area table', { timeout: 120000 });
  await new Promise(r => setTimeout(r, 1500));
  const box = await page.evaluate((sel) => { const r = document.querySelector(sel).getBoundingClientRect(); return { x: r.x + scrollX, y: r.y + scrollY, w: r.width, h: r.height }; }, sel);
  await page.screenshot({ path: out + '.png', captureBeyondViewport: true, clip: { x: box.x - 6, y: box.y - 6, width: Math.min(+w, box.w + 12), height: Math.min(+h, box.h + 12) } });
  await browser.close();
})();
