const fs = require('fs');
const [a, b] = process.argv.slice(2);
const slugs = fs.readdirSync(a).filter(f => f.endsWith('.json')).map(f => f.replace('.json', ''));
let bad = 0;
const strip = (s) => (s || '').replace(/_\d{2}_\d{2}_\d{4}_[\d.]+_[AP]M/g, '');
for (const s of slugs) {
  if (!fs.existsSync(`${b}/${s}.json`)) { console.log(s, 'MISSING in', b); continue; }
  const A = JSON.parse(fs.readFileSync(`${a}/${s}.json`)), B = JSON.parse(fs.readFileSync(`${b}/${s}.json`));
  const diffs = [];
  if (A.table !== B.table) diffs.push(`table ${A.table} vs ${B.table}`);
  if (A.errors.join('|') !== B.errors.join('|')) diffs.push('errors differ: ' + JSON.stringify([A.errors, B.errors]));
  if (JSON.stringify(A.tables) !== JSON.stringify(B.tables)) {
    // find first differing cell
    const at = A.tables || [], bt = B.tables || [];
    for (let i = 0; i < Math.max(at.length, bt.length); i++) {
      const x = at[i], y = bt[i];
      if (!x || !y) { diffs.push('table count differs'); break; }
      if (JSON.stringify(x.headers) !== JSON.stringify(y.headers)) diffs.push(`headers t${i}: ${JSON.stringify(x.headers)} vs ${JSON.stringify(y.headers)}`);
      if (JSON.stringify(x.classes) !== JSON.stringify(y.classes)) diffs.push(`cell classes t${i} differ`);
      x.rows.forEach((r, ri) => r.forEach((c, ci) => { if (c !== (y.rows[ri] || [])[ci]) diffs.push(`t${i} r${ri} c${ci}: "${c}" vs "${(y.rows[ri] || [])[ci]}"`); }));
    }
  }
  if (strip(A.csv) !== strip(B.csv)) diffs.push('CSV differs');
  if (strip(A.xlsxSheet) !== strip(B.xlsxSheet)) diffs.push('XLSX sheet differs');
  const ia = JSON.stringify({ ...A.interactions, downloads: undefined }), ib = JSON.stringify({ ...B.interactions, downloads: undefined });
  if (ia !== ib) diffs.push('interactions differ: ' + ia + ' vs ' + ib);
  if (A.pagination !== B.pagination) diffs.push(`pagination text ${A.pagination} vs ${B.pagination}`);
  if (diffs.length) { bad++; console.log('DIFF', s, '\n  ' + diffs.slice(0, 6).join('\n  ')); }
  else console.log('same', s, 'csv=' + (A.csv ? A.csv.split('\n').length : 'none'), 'xlsx=' + (A.xlsxSheet ? 'ok' : 'none'));
}
console.log('differing tools:', bad);
