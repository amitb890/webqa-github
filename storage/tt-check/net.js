const puppeteer = require('/Users/flake/.nvm/versions/node/v22.20.0/lib/node_modules/lighthouse/node_modules/puppeteer-core');
const [slug, port='8766', urls='https://www.python.org'] = process.argv.slice(2);
(async()=>{
  const b = await puppeteer.launch({executablePath:'/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',headless:'new',args:['--no-sandbox','--user-data-dir=/tmp/pt/profile-n'+process.pid],defaultViewport:{width:1440,height:1000}});
  const p = await b.newPage();
  p.on('response', async r => { if (/\/test\//.test(r.url())) { let t=''; try{t=(await r.text()).slice(0,700)}catch(e){} console.log(r.status(), r.url(), '\n  ', t.replace(/\s+/g,' ')); }});
  await p.goto(`http://127.0.0.1:${port}/tools/${slug}`,{waitUntil:'domcontentloaded'});
  await p.waitForSelector('#startTestBulk'); await new Promise(r=>setTimeout(r,800));
  await p.evaluate(u=>{document.querySelector('#urlValue').value=u.split(',').join('\n')},urls);
  await p.click('#startTestBulk');
  await new Promise(r=>setTimeout(r,20000));
  await b.close();
})();
