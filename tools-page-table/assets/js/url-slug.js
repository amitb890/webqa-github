// URL Slug tool: column definitions, dummy data and the demo page's table options.
// Loads after tools-page-table.js (the shared core). See the handover notes for the column definition format.
// The slug is the part of the URL after the domain name.
//
// Before the test the user ticks any of these settings; each one shows its column (optional: true):
//   Every character in the URL needs to be lowercase                       -> uppercase
//   URLs cannot contain numbers                                            -> numbers
//   URLs cannot contain special characters                                 -> specialCharacters
//   Maximum length of a URL should be 60 characters (excluding the domain) -> length
//   Words in URLs should be separated by Hyphens only                      -> hyphens
//   Words in URLs should be separated by Underscores only                  -> (no column yet)
//   Words in URLs can be separated by either Hyphens or underscores        -> (no column yet)
// #, URL, Slug and Result always show.

const MAX_SLUG_LENGTH = 60; // slug lengths up to this show a green pill, longer ones red
const yesNoPill = (value, goodWhen, modifier = 'yes-no') => ToolsTable.badge(value, value === goodWhen ? 'good' : 'bad', modifier);

// ---- Columns for the URL Slug results table, in display order ----
const URL_SLUG_COLUMNS = [
  { key: 'index', label: '#', cellClass: 'num', numeric: true,
    value: (row, ctx) => ctx.rowNumber },
  // URL and Slug share the spare width equally
  { key: 'url', label: 'URL', grow: true, minStartWidth: 160,
    render: row => `<a href="${ToolsTable.escapeHtml(row.url)}" target="_blank" rel="noopener">${ToolsTable.escapeHtml(row.url)}</a>` },
  { key: 'slug', label: 'Slug', grow: true, minStartWidth: 160 },
  // Green up to 60 characters, red above
  { key: 'length', label: 'Length', optional: true, sortable: true, align: 'center', numeric: true, compact: true,
    render: row => ToolsTable.badge(row.length, row.length <= MAX_SLUG_LENGTH ? 'good' : 'bad', 'length') },
  // Yes is red, No is green
  { key: 'numbers', label: 'Numbers?', optional: true, sortable: true, align: 'center', compact: true,
    tooltip: 'Does the URL slug contain numbers?',
    render: row => yesNoPill(row.numbers, 'No') },
  // Yes is red, No is green
  { key: 'specialCharacters', label: 'Special characters', optional: true, sortable: true, align: 'center', compact: true,
    tooltip: 'Does the URL slug contain special characters?',
    render: row => yesNoPill(row.specialCharacters, 'No') },
  // Yes is red, No is green
  { key: 'uppercase', label: 'Uppercase characters', optional: true, sortable: true, align: 'center', compact: true,
    tooltip: 'Does the URL slug contain uppercase characters?',
    render: row => yesNoPill(row.uppercase, 'No') },
  // Yes is green, No is red
  { key: 'hyphens', label: 'Hyphens?', optional: true, sortable: true, align: 'center', compact: true,
    tooltip: 'Are words in the url slug separated by hyphens only?',
    render: row => yesNoPill(row.hyphens, 'Yes') },
  { key: 'result', label: 'Result', sortable: true,
    render: row => ToolsTable.badge(row.result, row.result === 'Pass' ? 'good' : 'bad') }
];

// ---- Dummy data: replace with the real results for the tested URLs (max 100) ----
// numbers / specialCharacters / uppercase / hyphens: "Yes" | "No"; Result: "Pass" | "Fail" (dummy values only)
const sampleDomains = [
  'https://example.com', 'https://www.example.co.uk', 'https://shop.example-store.com', 'https://blog.example.io',
  'https://docs.example.dev', 'https://example.org', 'https://news.example.net', 'https://www.example.com.au',
  'https://help.example.com', 'https://store.example.ae'
];
const sampleSlugs = [
  'blog/how-to-write-seo-friendly-urls',
  'Products/Blue_Running_Shoes',
  'about-us',
  'services/web-design-and-development-for-growing-small-and-medium-businesses',
  'p?id=4821&ref=home',
  'contact',
  'news/2026/10/product-launch-recap',
  'caf%C3%A9-menu',
  'Summer-Sale!',
  'guides/technical_seo/canonical-tags'
];

const countOf = (text, pattern) => (text.match(pattern) || []).length;
const yesNo = flag => (flag ? 'Yes' : 'No');

const data = Array.from({ length: 100 }, (_, i) => {
  const slug = sampleSlugs[i % 10];
  const domain = sampleDomains[Math.floor(i / 10) % 10];
  const numbers = countOf(slug, /[0-9]/g) > 0;
  const special = countOf(slug, /[^A-Za-z0-9\-_\/]/g) > 0; // anything but letters, digits, hyphens, underscores and slashes
  const uppercase = countOf(slug, /[A-Z]/g) > 0;
  // Hyphens only: no other word separators (underscores or encoded spaces); a one-word slug counts as Yes
  const hyphensOnly = !/_|%20/.test(slug);
  return {
    url: `${domain}/${slug}`,
    slug,
    length: slug.length,
    numbers: yesNo(numbers),
    specialCharacters: yesNo(special),
    uppercase: yesNo(uppercase),
    hyphens: yesNo(hyphensOnly),
    result: !numbers && !special && !uppercase && hyphensOnly && slug.length <= MAX_SLUG_LENGTH ? 'Pass' : 'Fail'
  };
});
// ---- End dummy data ----

// ---- Demo page options ----
// Too many combinations to show them all, so the demo shows a few representative ones.
const URL_SLUG_OPTIONS = [
  { title: 'Option 1 - When all settings are chosen',
    visible: ['length', 'numbers', 'specialCharacters', 'uppercase', 'hyphens'] },
  { title: 'Option 2 - When only the character settings are chosen (lowercase, numbers, special characters)',
    visible: ['numbers', 'specialCharacters', 'uppercase'] },
  { title: 'Option 3 - When only the length and hyphens settings are chosen',
    visible: ['length', 'hyphens'] },
  { title: 'Option 4 - When only the lowercase setting is chosen',
    visible: ['uppercase'] }
];

DemoOptions.render({
  toolName: 'URL Slug',
  columns: URL_SLUG_COLUMNS,
  options: URL_SLUG_OPTIONS,
  data,
  fileName: 'url-slug-results',
  checkCoverage: false // only a selection of the combinations is shown
});
