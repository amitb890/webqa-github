// Robots Meta tag tool: column definitions, dummy data and the demo page's table.
// Loads after tools-page-table.js (the shared core). See the handover notes for the column definition format.
// This tool has no optional columns, so there is only one table layout.

// ---- Columns for the Robots Meta tag results table, in display order ----
const ROBOTS_META_COLUMNS = [
  { key: 'index', label: '#', cellClass: 'num', numeric: true,
    value: (row, ctx) => ctx.rowNumber },
  // URL and Content share the spare width equally
  { key: 'url', label: 'URL', grow: true, minStartWidth: 160,
    render: row => `<a href="${ToolsTable.escapeHtml(row.url)}" target="_blank" rel="noopener">${ToolsTable.escapeHtml(row.url)}</a>` },
  // Yes is green, No is blue
  { key: 'robotsTagExists', label: 'Robots tag exists?', sortable: true, align: 'center', compact: true,
    minStartWidth: 104, // heading wraps onto two lines at most
    render: row => ToolsTable.badge(row.robotsTagExists, row.robotsTagExists === 'Yes' ? 'good' : 'info', 'yes-no') },
  { key: 'content', label: 'Content', grow: true, minStartWidth: 160 },
  { key: 'result', label: 'Result', sortable: true,
    render: row => ToolsTable.badge(row.result, row.result === 'Pass' ? 'good' : 'bad') }
];

// ---- Dummy data: replace with the real results for the tested URLs (max 100) ----
// robotsTagExists: "Yes" | "No"; content: the tag's content attribute ("—" when there is no tag)
// Result: "Pass" | "Fail" (dummy values only; the real result comes from the test)
const sampleRobots = [
  ['Yes', 'index, follow', 'Pass'],
  ['Yes', 'noindex, nofollow', 'Fail'],
  ['No', '—', 'Pass'],
  ['Yes', 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1', 'Pass'],
  ['Yes', 'noindex, follow', 'Fail'],
  ['Yes', 'index, nofollow', 'Pass'],
  ['No', '—', 'Pass'],
  ['Yes', 'noarchive, nosnippet', 'Pass'],
  ['Yes', 'none', 'Fail'],
  ['Yes', 'index, follow, noimageindex, unavailable_after: 2027-12-31', 'Pass']
];
// A mix of short and long URLs (n is replaced with a number to keep each URL unique)
const sampleRobotsUrls = [
  'https://example.com/n',
  'https://example.com/blog/2026/10/robots-meta-tag-best-practices-n',
  'https://ex.io/p/n',
  'https://shop.example-store.co.uk/collections/womens-running-shoes/products/lightweight-trail-runner-n?variant=4421&colour=blue',
  'https://example.com/about-n',
  'https://www.longer-domain-name-example.com/resources/guides/technical-seo/canonical-tags-explained-n',
  'https://example.com/faq#n',
  'https://staging.example.dev/v2/preview/landing-pages/n/draft?include=assets,variants',
  'https://t.co/n',
  'https://example.com/services/web-development/wordpress-n?utm_source=newsletter&utm_medium=email&utm_campaign=autumn-launch'
];

const data = Array.from({ length: 100 }, (_, i) => {
  const [robotsTagExists, content, result] = sampleRobots[i % 10];
  return {
    url: sampleRobotsUrls[(i * 3) % 10].replace(/\bn\b/, i + 1),
    robotsTagExists,
    content,
    result
  };
});
// ---- End dummy data ----

// ---- Demo page: a single table (no options for this tool) ----
ToolsTable.create(document.getElementById('results'), {
  columns: ROBOTS_META_COLUMNS,
  data,
  fileName: 'robots-meta-results'
});
