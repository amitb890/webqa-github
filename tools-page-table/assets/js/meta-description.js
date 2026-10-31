// Meta description tool: column definitions, dummy data and the demo page's table options.
// Loads after tools-page-table.js (the shared core). See the handover notes for the column definition format.

const MAX_DESCRIPTION_LENGTH = 160; // lengths above this show a red pill

// ---- Columns for the Meta description results table, in display order ----
// The user chooses the optional one (Length) before running the test. Result always shows.
const META_DESCRIPTION_COLUMNS = [
  { key: 'index', label: '#', cellClass: 'num', numeric: true,
    value: (row, ctx) => ctx.rowNumber },
  { key: 'url', label: 'URL', startShare: 0.22, minStartWidth: 160,
    render: row => `<a href="${ToolsTable.escapeHtml(row.url)}" target="_blank" rel="noopener">${ToolsTable.escapeHtml(row.url)}</a>` },
  { key: 'content', label: 'Content', grow: true },
  { key: 'length', label: 'Length', optional: true, sortable: true, align: 'center', numeric: true, compact: true,
    render: row => ToolsTable.badge(row.length, row.length > MAX_DESCRIPTION_LENGTH ? 'bad' : 'good', 'length') },
  // Result is never optional: it shows in every option
  { key: 'result', label: 'Result', sortable: true,
    render: row => ToolsTable.badge(row.result, row.result === 'Pass' ? 'good' : 'bad') }
];

// ---- Dummy data: replace with the real results for the tested URLs (max 100) ----
// Result: "Pass" | "Fail" (dummy rule here: Fail when the description is over the length limit)
const sampleDescriptions = [
  'Example helps growing businesses plan, launch and measure digital campaigns with clear reporting and friendly support.',
  'Learn about our team.',
  'Explore our full range of services, from web design and development to SEO, content and performance marketing, all delivered by a senior team that cares about results and long-term growth.',
  'Read the latest news, guides and insights from our experts on SEO, content strategy and conversion optimisation.',
  'Get in touch with our team today. We usually reply within one business day.',
  'Simple, transparent pricing for every team size. Compare plans, see what is included and start a free 14-day trial with no credit card required, then upgrade or cancel at any time you like.',
  'Join a remote-first team building tools that help thousands of marketers do their best work. See open roles.',
  'Answers to the most common questions about our products, shipping times, returns, refunds and account settings.',
  'Meet the people behind Example.',
  'A selection of recent client projects across ecommerce, SaaS and professional services, with results, timelines and the challenges we solved together along the way for each and every one of them.'
];
// A mix of short and long URLs (n is replaced with a number to keep each URL unique)
const sampleDescriptionUrls = [
  'https://example.com/n',
  'https://example.com/blog/2026/10/how-to-write-meta-descriptions-that-get-clicks-n',
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
  const content = sampleDescriptions[i % 10];
  return {
    url: sampleDescriptionUrls[(i * 3) % 10].replace(/\bn\b/, i + 1),
    content,
    length: content.length,
    result: content.length > MAX_DESCRIPTION_LENGTH ? 'Fail' : 'Pass'
  };
});
// ---- End dummy data ----

// ---- Demo page: one table for every combination of the optional columns ----
// `visible` lists the optional columns the user chose. Option 1 is shown first with all rows;
// the rest go under "Other options" with 10 rows each (see demo-options.js).
const META_DESCRIPTION_OPTIONS = [
  { title: 'Option 1 - When all settings are chosen', visible: ['length'] },
  { title: "Option 2 - When the Length table isn't there", visible: [] }
];

DemoOptions.render({
  toolName: 'Meta description',
  columns: META_DESCRIPTION_COLUMNS,
  options: META_DESCRIPTION_OPTIONS,
  data,
  fileName: 'meta-description-results'
});
