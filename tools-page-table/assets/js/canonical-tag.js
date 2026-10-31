// Canonical Tag tool: column definitions, dummy data and the demo page's table.
// Loads after tools-page-table.js (the shared core). See the handover notes for the column definition format.
// This tool has no optional columns, so there is only one table layout.

const linkCell = url => `<a href="${ToolsTable.escapeHtml(url)}" target="_blank" rel="noopener">${ToolsTable.escapeHtml(url)}</a>`;

// ---- Columns for the Canonical Tag results table, in display order ----
const CANONICAL_TAG_COLUMNS = [
  { key: 'index', label: '#', cellClass: 'num', numeric: true,
    value: (row, ctx) => ctx.rowNumber },
  // URL and Canonical URL share the spare width equally
  { key: 'url', label: 'URL', grow: true, minStartWidth: 160,
    render: row => linkCell(row.url) },
  { key: 'canonicalUrl', label: 'Canonical URL', grow: true, minStartWidth: 160,
    render: row => linkCell(row.canonicalUrl) },
  // Yes is green, No is red
  { key: 'equalToActualUrl', label: 'Equal to Actual URL', sortable: true, align: 'center', compact: true,
    minStartWidth: 104, // heading wraps onto two lines at most
    render: row => ToolsTable.badge(row.equalToActualUrl, row.equalToActualUrl === 'Yes' ? 'good' : 'bad', 'yes-no') },
  { key: 'result', label: 'Result', sortable: true,
    render: row => ToolsTable.badge(row.result, row.result === 'Pass' ? 'good' : 'bad') }
];

// ---- Dummy data: replace with the real results for the tested URLs (max 100) ----
// equalToActualUrl: "Yes" | "No"; Result: "Pass" | "Fail" (dummy values only; the real result comes from the test)
// Each sample: [tested URL, canonical URL] (n is replaced with a number to keep each URL unique)
const sampleCanonicals = [
  ['https://example.com/n', 'https://example.com/n'],
  ['https://example.com/blog/2026/10/canonical-tags-explained-n', 'https://example.com/blog/2026/10/canonical-tags-explained-n'],
  ['https://ex.io/p/n', 'https://example.io/products/n'],
  ['https://shop.example-store.co.uk/collections/womens-running-shoes/products/lightweight-trail-runner-n?variant=4421&colour=blue',
   'https://shop.example-store.co.uk/products/lightweight-trail-runner-n'],
  ['https://example.com/about-n', 'https://example.com/about-n'],
  ['http://www.longer-domain-name-example.com/resources/guides/technical-seo/n', 'https://www.longer-domain-name-example.com/resources/guides/technical-seo/n'],
  ['https://example.com/faq-n', 'https://example.com/faq-n'],
  ['https://docs.example.dev/v2/api/reference/endpoints/users/n/permissions?include=roles,groups',
   'https://docs.example.dev/v2/api/reference/endpoints/users/n/permissions?include=roles,groups'],
  ['https://example.com/team-n/', 'https://example.com/team-n'],
  ['https://example.com/services/web-development/wordpress-n?utm_source=newsletter&utm_medium=email&utm_campaign=autumn-launch',
   'https://example.com/services/web-development/wordpress-n']
];

const data = Array.from({ length: 100 }, (_, i) => {
  const [url, canonicalUrl] = sampleCanonicals[(i * 3) % 10].map(u => u.replace(/\bn\b/, i + 1));
  const equal = url === canonicalUrl;
  return {
    url,
    canonicalUrl,
    equalToActualUrl: equal ? 'Yes' : 'No',
    result: equal ? 'Pass' : 'Fail'
  };
});
// ---- End dummy data ----

// ---- Demo page: a single table (no options for this tool) ----
ToolsTable.create(document.getElementById('results'), {
  columns: CANONICAL_TAG_COLUMNS,
  data,
  fileName: 'canonical-tag-results'
});
