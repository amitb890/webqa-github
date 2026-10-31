// Usage: node probe.js <slug> '<js expression returning JSON-able, evaluated in page after test finished>'
const puppeteer = require('/Users/flake/.nvm/versions/node/v22.20.0/lib/node_modules/lighthouse/node_modules/puppeteer-core');
const [slug, expr, urls = 'https://example.com,https://www.iana.org/domains/reserved', width = '1440'] = process.argv.slice(2);
(async () => {
  const browser = await puppeteer.launch({ executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome', headless: 'new', args: ['--no-sandbox', '--user-data-dir=/tmp/pt/profile-p' + process.pid], defaultViewport: { width: +width, height: 1000 } });
  const page = await browser.newPage();
  await page.goto(`http://127.0.0.1:8765/tools/${slug}`, { waitUntil: 'networkidle2' });
  await page.evaluate((u) => { document.querySelector('#urlValue').value = u.split(',').join('\n'); }, urls);
  await page.click('#startTestBulk');
  await page.waitForSelector('.test_result_area table', { timeout: 120000 });
  await new Promise(r => setTimeout(r, 1500));
  console.log(JSON.stringify(await page.evaluate(expr), null, 1));
  await browser.close();
})();
