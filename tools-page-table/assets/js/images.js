// Images tool: column definitions, dummy data and the demo page's table options.
// Loads after tools-page-table.js (the shared core). See the handover notes for the column definition format.
// Uses column groups: "Alternate text" and "File name" each have sub-columns under a shared header.
//
// Before the test the user ticks any of these 7 checks; each one shows its column (optional: true):
//   Maximum file size of an image file should be 150 KB          -> fileSizeKb
//   Words in image file must be separated by hyphens only         -> fileNameHyphens
//   Image file name can not have uppercase characters             -> fileNameUppercase
//   Image file name can not have special characters               -> fileNameSpecial
//   Maximum length of an image file name should be 50 characters  -> fileNameLength
//   An image must have an alt text                                -> altText
//   Words in alt text must be separated by spaces only            -> altSpaces
// #, URL, Image link, File name and Result always show.

const countOf = (text, pattern) => (text.match(pattern) || []).length;
const yesNo = flag => (flag ? 'Yes' : 'No');
const MAX_FILE_NAME_LENGTH = 50; // file name lengths below this show a green pill, otherwise red
const MAX_FILE_SIZE_KB = 150;    // file sizes below this show a green pill, otherwise red

// ---- Columns for the Images results table, in display order ----
const IMAGES_COLUMNS = [
  { key: 'index', label: '#', cellClass: 'num', numeric: true,
    value: (row, ctx) => ctx.rowNumber },
  // A page usually has several images: its URL shows on the first of its rows only
  { key: 'url', label: 'URL', startShare: 0.16, minStartWidth: 160, hideRepeats: true,
    render: row => `<a href="${ToolsTable.escapeHtml(row.url)}" target="_blank" rel="noopener">${ToolsTable.escapeHtml(row.url)}</a>` },
  // Icon only, linked to the image; the image URL itself isn't shown (it is still searched and exported)
  { key: 'imageUrl', label: 'Image link', align: 'center', noWrap: true,
    render: row => ToolsTable.iconLink(row.imageUrl, 'image-link.svg', 'Open image in a new tab') },

  { key: 'altText', label: 'Content', group: 'Alternate text', optional: true, grow: true,
    render: row => (row.altText ? ToolsTable.escapeHtml(row.altText) : '<span class="cell-empty">No alt text</span>') },
  // Yes is green, No is red
  { key: 'altSpaces', label: 'Spaces', group: 'Alternate text', optional: true, sortable: true, align: 'center', compact: true,
    tooltip: 'Are the words in alternate text separated by spaces?',
    render: row => ToolsTable.badge(row.altSpaces, row.altSpaces === 'Yes' ? 'good' : 'bad', 'yes-no') },

  // Always shown; takes the spare width when the alt text Content column is switched off
  { key: 'fileName', label: 'File name', group: 'File name', minStartWidth: 180, fallbackGrow: true },
  // Green below 50 characters, red otherwise
  { key: 'fileNameLength', label: 'Length', group: 'File name', optional: true, sortable: true, align: 'center', numeric: true, compact: true,
    render: row => ToolsTable.badge(row.fileNameLength, row.fileNameLength < MAX_FILE_NAME_LENGTH ? 'good' : 'bad', 'length') },
  // Yes is green, No is red
  { key: 'fileNameHyphens', label: 'Hyphens', group: 'File name', optional: true, sortable: true, align: 'center', compact: true,
    tooltip: 'Are words in file name separated by hyphens?',
    render: row => ToolsTable.badge(row.fileNameHyphens, row.fileNameHyphens === 'Yes' ? 'good' : 'bad', 'yes-no') },
  // Yes is red, No is green
  { key: 'fileNameUppercase', label: 'Uppercase characters', group: 'File name', optional: true, sortable: true, align: 'center', compact: true,
    tooltip: 'Does file name contain uppercase characters?',
    render: row => ToolsTable.badge(row.fileNameUppercase, row.fileNameUppercase === 'Yes' ? 'bad' : 'good', 'yes-no') },
  // Yes is red, No is green
  { key: 'fileNameSpecial', label: 'Special characters', group: 'File name', optional: true, sortable: true, align: 'center', compact: true,
    tooltip: 'Does file name contain special characters?',
    render: row => ToolsTable.badge(row.fileNameSpecial, row.fileNameSpecial === 'Yes' ? 'bad' : 'good', 'yes-no') },
  { key: 'fileSizeKb', label: 'File size', group: 'File name', optional: true, sortable: true, align: 'center', numeric: true, noWrap: true,
    value: row => `${row.fileSizeKb} KB`,
    // Green below 150 KB, red otherwise
    render: row => ToolsTable.badge(`${row.fileSizeKb} KB`, row.fileSizeKb < MAX_FILE_SIZE_KB ? 'good' : 'bad', 'file-size') },

  { key: 'result', label: 'Result', sortable: true,
    render: row => ToolsTable.badge(row.result, row.result === 'Pass' ? 'good' : 'bad') }
];

// ---- Dummy data: replace with the real results for the tested URLs (max 100) ----
// Each sample: [alt text, file name, file size in KB]
const sampleImages = [
  ['Team of four smiling in front of the office', 'team-photo-office.jpg', 184],
  ['', 'IMG_20260512_103344.JPG', 2412],
  ['Blue lightweight trail running shoe, side view', 'trail-runner-blue-side.webp', 96],
  ['logo', 'Logo_Final(2).png', 38],
  ['Chart showing organic traffic growth from January to June', 'organic-traffic-growth-chart-january-to-june-2026-final-version.png', 142],
  ['Close-up of a hand-crafted leather wallet', 'leather_wallet closeup.jpg', 318],
  ['', 'banner@2x.png', 1210],
  ['Customer support agent wearing a headset', 'support-agent-headset.jpg', 156],
  ['Product box - front, back and side', 'Product-Box-Front-Back-Side.jpeg', 488],
  ['Map of our three London offices', 'london-offices-map-with-all-three-locations-marked-clearly.svg', 24]
];
// A mix of short and long page URLs (n is replaced with a number to keep each URL unique)
const sampleImagePageUrls = [
  'https://example.com/n',
  'https://example.com/blog/2026/10/how-to-optimise-images-for-seo-n',
  'https://ex.io/p/n',
  'https://shop.example-store.co.uk/collections/womens-running-shoes/products/lightweight-trail-runner-n?variant=4421&colour=blue',
  'https://example.com/about-n',
  'https://www.longer-domain-name-example.com/resources/guides/technical-seo/image-alt-text-n',
  'https://example.com/faq#n',
  'https://example.com/support/contact-n',
  'https://t.co/n',
  'https://example.com/services/web-development/wordpress-n?utm_source=newsletter&utm_medium=email'
];

// A page usually has several images, so each page URL gets 1–5 rows (a fixed, random-looking pattern)
const imagesPerPage = [3, 1, 4, 2, 5, 2, 3, 1, 4, 3, 2, 5];
const pageOfRow = [];
for (let page = 0; pageOfRow.length < 100; page++) {
  const count = imagesPerPage[page % imagesPerPage.length];
  for (let k = 0; k < count && pageOfRow.length < 100; k++) pageOfRow.push(page);
}

const data = pageOfRow.map((page, i) => {
  const [altText, fileName, fileSizeKb] = sampleImages[(i * 7) % 10];
  const fileNameUppercase = countOf(fileName, /[A-Z]/g);
  const fileNameSpecial = countOf(fileName, /[^A-Za-z0-9.\-]/g); // anything but letters, digits, dots and hyphens
  return {
    url: sampleImagePageUrls[(page * 3) % 10].replace(/\bn\b/, page + 1),
    imageUrl: `https://cdn.example.com/images/${i + 1}/${encodeURIComponent(fileName)}`,
    altText,
    altSpaces: yesNo(countOf(altText, / /g) > 0),          // "Yes" | "No": words separated by spaces?
    fileName,
    fileNameLength: fileName.length,
    fileNameHyphens: yesNo(countOf(fileName, /-/g) > 0),   // "Yes" | "No"
    fileNameUppercase: yesNo(fileNameUppercase > 0),        // "Yes" | "No"
    fileNameSpecial: yesNo(fileNameSpecial > 0),            // "Yes" | "No": anything but letters, digits, dots and hyphens
    fileSizeKb,
    // Dummy rule only; the real result comes from the test
    result: altText && !fileNameUppercase && !fileNameSpecial && fileSizeKb <= 500 ? 'Pass' : 'Fail'
  };
});
// ---- End dummy data ----

// ---- Demo page options ----
// 7 checks give 128 combinations, too many to show, so the demo shows three representative ones.
const FILE_NAME_CHECKS = ['fileNameLength', 'fileNameHyphens', 'fileNameUppercase', 'fileNameSpecial', 'fileSizeKb'];
const ALT_TEXT_CHECKS = ['altText', 'altSpaces'];
const IMAGES_OPTIONS = [
  { title: 'Option 1 - When all settings are chosen', visible: [...ALT_TEXT_CHECKS, ...FILE_NAME_CHECKS] },
  { title: 'Option 2 - When only the file name settings are chosen', visible: FILE_NAME_CHECKS },
  { title: 'Option 3 - When only the alt text settings are chosen', visible: ALT_TEXT_CHECKS }
];

DemoOptions.render({
  toolName: 'Images',
  columns: IMAGES_COLUMNS,
  options: IMAGES_OPTIONS,
  data,
  fileName: 'images-results',
  checkCoverage: false // only a selection of the 128 combinations is shown
});
