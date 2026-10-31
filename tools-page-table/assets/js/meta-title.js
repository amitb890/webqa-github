// Meta title tool: column definitions, dummy data and the demo page's table options.
// Loads after tools-page-table.js (the shared core). See the handover notes for the column definition format.

const MAX_TITLE_LENGTH = 65; // lengths above this show a red pill

// ---- Columns for the Meta title results table, in display order ----
// The user chooses the optional ones (Length, Title Equal to H1 ?, Casing) before running the test.
const META_TITLE_COLUMNS = [
  { key: 'index', label: '#', cellClass: 'num', numeric: true,
    value: (row, ctx) => ctx.rowNumber },
  { key: 'url', label: 'URL', startShare: 0.22, minStartWidth: 160,
    render: row => `<a href="${ToolsTable.escapeHtml(row.url)}" target="_blank" rel="noopener">${ToolsTable.escapeHtml(row.url)}</a>` },
  { key: 'content', label: 'Content', grow: true },
  { key: 'length', label: 'Length', optional: true, sortable: true, align: 'center', numeric: true, compact: true,
    render: row => ToolsTable.badge(row.length, row.length > MAX_TITLE_LENGTH ? 'bad' : 'good', 'length') },
  { key: 'titleEqualsH1', label: 'Title Equal to H1 ?', optional: true, sortable: true, align: 'center', compact: true,
    minStartWidth: 104, // heading wraps onto two lines at most
    // "Yes" means the title just copies the H1, so it is red
    render: row => ToolsTable.badge(row.titleEqualsH1, row.titleEqualsH1 === 'Yes' ? 'bad' : 'good', 'yes-no') },
  { key: 'casing', label: 'Casing', optional: true, sortable: true, align: 'center',
    render: row => ToolsTable.badge(row.casing, row.casing === 'Neither Camel case nor Sentence case' ? 'bad' : 'good', 'casing') },
  // Result is never optional: it shows in every option
  { key: 'result', label: 'Result', sortable: true,
    render: row => ToolsTable.badge(row.result, row.result === 'Pass' ? 'good' : 'bad') }
];

// ---- Dummy data: replace with the real results for the tested URLs (max 100) ----
// Casing: "Camel case" | "Sentence case" | "Neither Camel case nor Sentence case"
// Result: "Pass" | "Fail"
const sampleTitles = [
  ['Welcome to Example – Your Trusted Partner', 'Camel case', 'Pass'],
  ['about us', 'Neither Camel case nor Sentence case', 'Fail'],
  ['Our services for growing businesses', 'Sentence case', 'Pass'],
  ['LATEST NEWS AND INSIGHTS FROM OUR TEAM OF EXPERTS ACROSS THE INDUSTRY', 'Neither Camel case nor Sentence case', 'Fail'],
  ['Contact Us Today', 'Camel case', 'Pass'],
  ['Simple, transparent pricing for every team', 'Sentence case', 'Pass'],
  ['careers', 'Neither Camel case nor Sentence case', 'Fail'],
  ['Frequently Asked Questions About Our Products, Shipping and Returns Policy', 'Camel case', 'Fail'],
  ['Meet the Team', 'Sentence case', 'Pass'],
  ['Portfolio of recent client work', 'Sentence case', 'Pass']
];
// A mix of short and long URLs (n is replaced with a number to keep each URL unique)
const sampleUrls = [
  'https://example.com/n',
  'https://example.com/blog/2026/10/how-to-write-meta-titles-that-rank-and-convert-n',
  'https://ex.io/p/n',
  'https://shop.example-store.co.uk/collections/womens-running-shoes/products/lightweight-trail-runner-n?variant=4421&colour=blue',
  'https://example.com/about-n',
  'https://www.longer-domain-name-example.com/resources/guides/technical-seo/canonical-tags-explained-n',
  'https://example.com/faq#n',
  'https://docs.example.dev/v2/api/reference/endpoints/users/n/permissions?include=roles,groups',
  'https://t.co/n',
  'https://example.com/services/web-development/wordpress-n?utm_source=newsletter&utm_medium=email&utm_campaign=autumn-launch'
];

const data = Array.from({ length: 100 }, (_, i) => {
  const [content, casing, result] = sampleTitles[i % 10];
  return {
    url: sampleUrls[(i * 3) % 10].replace(/\bn\b/, i + 1),
    content,
    length: content.length,
    titleEqualsH1: i % 3 === 1 ? 'No' : 'Yes', // "Yes" | "No"
    casing,
    result
  };
});
// ---- End dummy data ----

// ---- Demo page: one table for every combination of the optional columns ----
// `visible` lists the optional columns the user chose. Option 1 is shown first with all rows;
// the rest go under "Other options" with 10 rows each (see demo-options.js).
const META_TITLE_OPTIONS = [
  { title: 'Option 1 - When all settings are chosen', visible: ['length', 'titleEqualsH1', 'casing'] },
  { title: "Option 2 - When the casing table isn't there", visible: ['length', 'titleEqualsH1'] },
  { title: "Option 3 - When the casing and the Title Equal to H1? table isn't there", visible: ['length'] },
  { title: "Option 4 - When the casing and Title Equal to H1? and Length table isn't there", visible: [] },
  { title: "Option 5 - When the Length table isn't there", visible: ['titleEqualsH1', 'casing'] },
  { title: "Option 6 - When the Title Equal to H1? table isn't there", visible: ['length', 'casing'] },
  { title: "Option 7 - When the Length and casing table isn't there", visible: ['titleEqualsH1'] },
  { title: "Option 8 - When the Length and Title Equal to H1? table isn't there", visible: ['casing'] }
];

DemoOptions.render({
  toolName: 'Meta title',
  columns: META_TITLE_COLUMNS,
  options: META_TITLE_OPTIONS,
  data,
  fileName: 'meta-title-results'
});
