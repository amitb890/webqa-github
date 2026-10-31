# Tools Page Table — Handover Notes

Everything you need to integrate and keep customising the redesigned results table for the
**Webqa tools pages** (Meta title, Meta description, Robots Meta tag, Canonical Tag, Images and URL Slug so far).

- **Built by:** Intella Digital (front end prototyped with Claude)
- **For:** Moeez — integration into the live Webqa tools pages
- **Status:** front end only, with dummy data. No back end calls.

---

## 1. What this is

Webqa's tools show results in a table, one row per tested URL. The old table's HTML/CSS was
poor. This folder contains a rebuilt, self-contained table (CSS + vanilla JS, no build step,
no framework) plus demo pages to view it.

**Before running a test, the user chooses which optional columns they want.** For Meta title
these are **Length**, **Title Equal to H1 ?** and **Casing**, so there are 2³ = **8 possible table
layouts**. For Meta description the only optional column is **Length**, so there are **2 layouts**.
Robots Meta tag and Canonical Tag have no optional columns, so each has **1 layout**. Images has
**7 optional checks**, so **128 layouts**; its demo page shows 3 representative ones.

The table is therefore built by JavaScript from a list of column definitions plus the
user's choice, not from fixed HTML. The same core will be reused by the next tool pages, each with
its own columns.

**Limits:** a result set holds **at most 100 URLs**.

**Rule for every tool:** `#`, URL, Content and **Result always show**, whatever the user chooses.
Only the tool-specific check columns (e.g. Length, Casing) can be optional. The core enforces the
Result rule: a column with `key: 'result'` is always shown even if marked `optional`, and the core
warns in the browser console if a tool's columns have no Result column or mark it optional.

---

## 2. Folder structure

```
tools-page-table/
├── tools-page-table.md          ← this file
├── index.html                   demo home page (not part of the table)
├── pages/
│   ├── meta-title.html          demo page: all 8 Meta title table layouts
│   ├── meta-description.html    demo page: both Meta description table layouts
│   ├── robots-meta.html         demo page: the Robots Meta tag table (no options, one layout)
│   ├── canonical-tag.html       demo page: the Canonical Tag table (no options, one layout)
│   ├── images.html              demo page: 3 of the 128 Images layouts
│   └── url-slug.html            demo page: 4 example URL Slug layouts
└── assets/
    ├── css/
    │   ├── tools-page-table.css ← THE TABLE STYLES, shared by every tool (copy into Webqa)
    │   └── page-layout.css        demo shell only: header bar, sidebar, page headings, index page
    ├── js/
    │   ├── tools-page-table.js  ← THE SHARED CORE: builds and runs any tools table (copy into Webqa)
    │   ├── meta-title.js        ← Meta title tool: column definitions, dummy data, demo options
    │   ├── meta-description.js  ← Meta description tool: column definitions, dummy data, demo options
    │   ├── robots-meta.js       ← Robots Meta tag tool: column definitions, dummy data
    │   ├── canonical-tag.js     ← Canonical Tag tool: column definitions, dummy data
    │   ├── images.js            ← Images tool: column definitions (with column groups), dummy data, demo options
    │   ├── url-slug.js          ← URL Slug tool: column definitions, dummy data, demo options
    │   ├── demo-options.js        demo pages only: renders one table per option (Option 1: all rows, others: 10)
    │   ├── page-layout.js         demo shell only: sidebar navigation (NAV list) and sidebar collapse
    │   └── vendor/
    │       └── xlsx.full.min.js   SheetJS 0.18.5, used for the XLSX download
    ├── fonts/inter/               Inter 400/500/600 woff2 (Latin) + LICENSE.txt (SIL OFL 1.1)
    └── images/                    SVG icons (see section 8)
```

**What belongs to the table vs. the demo:**

| Part of the table (integrate these) | Demo only (Webqa's own layout replaces these) |
|---|---|
| `assets/css/tools-page-table.css` | `assets/css/page-layout.css` |
| `assets/js/tools-page-table.js` (core) | `assets/js/page-layout.js`, `assets/js/demo-options.js` |
| The `…_COLUMNS` definitions in each tool file (`meta-title.js`, `meta-description.js`, `robots-meta.js`, `canonical-tag.js`, `images.js`) | Dummy data and `…_OPTIONS` in each tool file |
| `assets/js/vendor/xlsx.full.min.js` | `index.html`, header bar, sidebar, page headings |
| `assets/fonts/inter/*` | `assets/images/sidebar-toggle.svg` |
| `assets/images/*` (except `sidebar-toggle.svg`) | |

---

## 3. Running it locally

No server needed: open `pages/meta-title.html` directly in a browser (double-click). Everything,
including fonts and the XLSX library, is local, so it works offline.

If you prefer a local server:

```bash
cd tools-page-table && python3 -m http.server 8765
```

then open `http://localhost:8765/pages/meta-title.html`.

---

## 4. Integrating into Webqa

1. **Copy assets:** `css/tools-page-table.css`, `js/tools-page-table.js`, `js/vendor/xlsx.full.min.js`,
   `fonts/inter/` and `images/`. Keep `css/`, `js/`, `images/` and `fonts/` as siblings: the CSS
   finds fonts and the dropdown arrow via `../fonts` and `../images`, and the core finds its icons
   via `../images/` relative to where `tools-page-table.js` is loaded from. (To keep icons
   elsewhere, pass `iconBase: '/path/to/icons/'` to `ToolsTable.create`.)
2. **Link the stylesheet** in the page `<head>`:
   ```html
   <link rel="stylesheet" href="…/assets/css/tools-page-table.css">
   ```
   If Webqa already loads Inter, you can delete the `@font-face` block at the top of the CSS and
   the `fonts` folder.
3. **Add an empty container** where the table should appear, e.g. `<div id="results"></div>`.
4. **Load scripts at the end of `<body>`, in this order:**
   ```html
   <script src="…/assets/js/vendor/xlsx.full.min.js"></script>   <!-- skip if Webqa already has SheetJS -->
   <script src="…/assets/js/tools-page-table.js"></script>       <!-- shared core -->
   <script src="…/assets/js/meta-title.js"></script>             <!-- tool's column definitions -->
   ```
   For production, keep `META_TITLE_COLUMNS` (and `MAX_TITLE_LENGTH`) from `meta-title.js` and
   drop the dummy data, the demo `META_TITLE_OPTIONS` list and the `DemoOptions.render(…)` call.
5. **Create the table** with the user's chosen columns and the real results:
   ```js
   ToolsTable.create(document.getElementById('results'), {
     columns: META_TITLE_COLUMNS,
     visible: ['length', 'casing'],   // the optional columns the user ticked before the test
     data: results,                   // array of rows, section 5
     fileName: 'meta-title-results'   // CSV/XLSX download name (optional)
   });
   ```

**Width:** the table card has no max-width; it fills whatever container it's placed in, matching
the Webqa tools page (full width with a slight left/right margin). Set the side margins on the
page container, not on `.table-card`. The demo uses 16px.

**Style isolation:** every rule in `tools-page-table.css` is scoped under `.table-card`, so it
won't restyle any other table on the site. The one exception is `body.resizing` (a cursor style
applied only while a column is being dragged). Several tables can live on one page; each has its
own search, sort, paging and resizing.

---

## 5. Data format (Meta title)

An array (max 100 items) of:

```js
{
  url: 'https://example.com/about',      // string, shown as a link
  content: 'About Us – Example Co',      // the meta title text
  length: 21,                            // number of characters in the title
  titleEqualsH1: 'Yes',                  // "Yes" | "No"
  casing: 'Camel case',                  // "Camel case" | "Sentence case" | "Neither Camel case nor Sentence case"
  result: 'Pass'                         // "Pass" | "Fail"
}
```

- Values must match these strings exactly; they drive the pill colours.
- Rows can include fields for hidden columns: they're simply not shown, searched or exported.
- All text is HTML-escaped before rendering, so raw user content is safe.
- The `#` column shows each row's original position in the data (it doesn't change when sorting
  or searching).
- **Data that arrives later** (fetch/AJAX): create the table with `data: []`, then call
  `table.setData(rows)` on the object `ToolsTable.create` returns. Column widths are re-measured.

---

## 5b. Data format (Meta description)

An array (max 100 items) of:

```js
{
  url: 'https://example.com/about',      // string, shown as a link
  content: 'Learn about our team.',      // the meta description text
  length: 21,                            // number of characters in the description
  result: 'Pass'                         // "Pass" | "Fail"
}
```

`META_DESCRIPTION_COLUMNS` in `meta-description.js`:

| Column | Optional | Display | Sortable | Align |
|---|---|---|---|---|
| `#` | no | plain number, grey | no | left |
| URL | no | blue link, opens in new tab; starts at 22% (min 160px) | no | left |
| Content | no | plain text; **grow column** (widest) | no | left |
| Length | **yes** | pill: **green ≤ 160**, **red > 160** (`MAX_DESCRIPTION_LENGTH`) | yes | centre |
| Result | no | pill: **green** Pass, **red** Fail | yes | left |

Create it the same way as Meta title:

```js
ToolsTable.create(document.getElementById('results'), {
  columns: META_DESCRIPTION_COLUMNS,
  visible: ['length'],              // or [] when the user switched Length off
  data: results,
  fileName: 'meta-description-results'
});
```

## 5c. Data format (Robots Meta tag)

An array (max 100 items) of:

```js
{
  url: 'https://example.com/about',      // string, shown as a link
  robotsTagExists: 'Yes',                // "Yes" | "No"
  content: 'index, follow',              // the robots meta tag's content attribute ("—" when there is no tag)
  result: 'Pass'                         // "Pass" | "Fail"
}
```

`ROBOTS_META_COLUMNS` in `robots-meta.js` (none are optional):

| Column | Display | Sortable | Align |
|---|---|---|---|
| `#` | plain number, grey | no | left |
| URL | blue link, opens in new tab; **grow column**, shares spare width equally with Content (min 160px) | no | left |
| Robots tag exists? | pill: **green Yes**, **blue No**; **compact** (heading on two lines, min 104px) | yes | centre |
| Content | plain text; **grow column**, same width as URL (min 160px) | no | left |
| Result | pill: **green** Pass, **red** Fail | yes | left |

```js
ToolsTable.create(document.getElementById('results'), {
  columns: ROBOTS_META_COLUMNS,
  data: results,
  fileName: 'robots-meta-results'
});
```

## 5d. Data format (Canonical Tag)

An array (max 100 items) of:

```js
{
  url: 'https://example.com/team-1/',            // the tested URL, shown as a link
  canonicalUrl: 'https://example.com/team-1',    // the page's canonical URL, shown as a link
  equalToActualUrl: 'No',                        // "Yes" | "No"
  result: 'Fail'                                 // "Pass" | "Fail"
}
```

`CANONICAL_TAG_COLUMNS` in `canonical-tag.js` (none are optional):

| Column | Display | Sortable | Align |
|---|---|---|---|
| `#` | plain number, grey | no | left |
| URL | blue link, opens in new tab; **grow column**, shares spare width equally with Canonical URL (min 160px) | no | left |
| Canonical URL | blue link, opens in new tab; **grow column**, same width as URL (min 160px) | no | left |
| Equal to Actual URL | pill: **green Yes**, **red No**; **compact** (heading on two lines, min 104px) | yes | centre |
| Result | pill: **green** Pass, **red** Fail | yes | left |

In the dummy data, Result is Pass when the canonical equals the URL and Fail otherwise; in Webqa
the real Pass/Fail comes from the test.

```js
ToolsTable.create(document.getElementById('results'), {
  columns: CANONICAL_TAG_COLUMNS,
  data: results,
  fileName: 'canonical-tag-results'
});
```

## 5e. Data format (Images)

An array (max 100 items) of:

```js
{
  url: 'https://example.com/about',                       // page tested, shown as a link
  imageUrl: 'https://cdn.example.com/images/team.jpg',    // shown only as an image icon linking to it
  altText: 'Team of four smiling',                        // "" when the image has no alt text
  altSpaces: 'Yes',                                       // "Yes" | "No": are the words separated by spaces?
  fileName: 'team-photo-office.jpg',
  fileNameLength: 21,                                     // characters in the file name
  fileNameHyphens: 'Yes',                                 // "Yes" | "No": does the file name use hyphens?
  fileNameUppercase: 'No',                                // "Yes" | "No": any uppercase characters?
  fileNameSpecial: 'No',                                  // "Yes" | "No": anything other than letters, digits, dots and hyphens?
  fileSizeKb: 184,                                        // number, shown as "184 KB"
  result: 'Pass'                                          // "Pass" | "Fail"
}
```

`IMAGES_COLUMNS` in `images.js` uses **column groups** (a two-row header):

| Group | Column | Display | Sortable | Align |
|---|---|---|---|---|
| | `#` | plain number, grey | no | left |
| | URL | blue link; starts at 16% (min 160px) | no | left |
| | Image link | **chain-link icon** linking to the image (new tab); the image URL isn't displayed, but is searched and exported | no | centre |
| **Alternate text** | Content | plain text; **grow column**; "No alt text" in grey italics when empty | no | left |
| **Alternate text** | Spaces | pill: **green Yes**, **red No**; header has an (i) tooltip: "Are the words in alternate text separated by spaces?" | yes | centre |
| **File name** | File name | plain text (starts at min 180px) | no | left |
| **File name** | Length | pill: **green below 50**, **red 50 or more** (`MAX_FILE_NAME_LENGTH` in `images.js`) | yes | centre |
| **File name** | Hyphens | pill: **green Yes**, **red No**; (i) tooltip: "Are words in file name separated by hyphens?" | yes | centre |
| **File name** | Uppercase characters | pill: **red Yes**, **green No**; (i) tooltip: "Does file name contain uppercase characters?" | yes | centre |
| **File name** | Special characters | pill: **red Yes**, **green No**; (i) tooltip: "Does file name contain special characters?" | yes | centre |
| **File name** | File size | pill "184 KB": **green below 150 KB**, **red 150 KB or more** (`MAX_FILE_SIZE_KB` in `images.js`); sorts by the number | yes | centre |
| | Result | pill: **green** Pass, **red** Fail | yes | left |

**Compact columns:** Spaces, Length, Hyphens, Uppercase characters and Special characters use
`compact: true`, so they're only as wide as their heading's longest word plus its sort arrow and (i).

**One row per image:** a page usually has several images, so one page URL has several consecutive
rows (the dummy data gives each page 1–5 images; 100 rows in total). The URL column has
`hideRepeats: true`, so the URL shows on the first of those rows only; the CSV/XLSX download
still has the URL on every row. In the dummy data,
Result is Fail when there's no alt text, the file name has uppercase or special characters, or the
file is over 500 KB; in Webqa the real Pass/Fail comes from the test. CSV/XLSX headers for grouped
columns are prefixed with the group, e.g. "File name: Length".

With every column shown the table is wider than most screens, so it scrolls sideways; the header
still sticks (using the script fallback, see "Sticky header").

**Images settings (what the user can tick before the test).** Each check shows its column
(`optional: true`); #, URL, Image link, File name and Result always show:

| Setting the user ticks | Column (`visible` key) |
|---|---|
| Maximum file size of an image file should be 150 KB | File name: File size (`fileSizeKb`) |
| Words in image file must be separated by hyphens only | File name: Hyphens (`fileNameHyphens`) |
| Image file name can not have uppercase characters | File name: Uppercase characters (`fileNameUppercase`) |
| Image file name can not have special characters | File name: Special characters (`fileNameSpecial`) |
| Maximum length of an image file name should be 50 characters | File name: Length (`fileNameLength`) |
| An image must have an alt text | Alternate text: Content (`altText`) |
| Words in alt text must be separated by spaces only | Alternate text: Spaces (`altSpaces`) |

7 checks = 2⁷ = **128 combinations**. Any combination works: pass the ticked keys as `visible`.

- When **Content** is switched off, **File name** takes the spare width instead (`fallbackGrow`).
- When only the File name column is left in its group (no file name checks ticked), the group
  header disappears and File name shows as an ordinary heading.
- If both alt text checks are off, the Alternate text group disappears entirely.

## 5f. Data format (URL Slug)

The slug is the part of the URL after the domain name. An array (max 100 items) of:

```js
{
  url: 'https://example.com/blog/how-to-write-seo-friendly-urls',
  slug: 'blog/how-to-write-seo-friendly-urls',
  length: 35,                   // characters in the slug (domain excluded)
  numbers: 'No',                // "Yes" | "No"
  specialCharacters: 'No',      // "Yes" | "No"
  uppercase: 'No',              // "Yes" | "No"
  hyphens: 'Yes',               // "Yes" | "No": words separated by hyphens only?
  result: 'Pass'                // "Pass" | "Fail"
}
```

`URL_SLUG_COLUMNS` in `url-slug.js`:

| Column | Display | Sortable | Align |
|---|---|---|---|
| `#` | plain number, grey | no | left |
| URL | blue link; **grow column**, same width as Slug (min 160px) | no | left |
| Slug | plain text; **grow column**, same width as URL (min 160px) | no | left |
| Length (**optional**) | pill: **green ≤ 60**, **red > 60** (`MAX_SLUG_LENGTH`); compact | yes | centre |
| Numbers? (**optional**) | pill: **red Yes**, **green No**; (i) "Does the URL slug contain numbers?"; compact | yes | centre |
| Special characters (**optional**) | pill: **red Yes**, **green No**; (i) "Does the URL slug contain special characters?"; compact | yes | centre |
| Uppercase characters (**optional**) | pill: **red Yes**, **green No**; (i) "Does the URL slug contain uppercase characters?"; compact | yes | centre |
| Hyphens? (**optional**) | pill: **green Yes**, **red No**; (i) "Are words in the url slug separated by hyphens only?"; compact | yes | centre |
| Result | pill: **green** Pass, **red** Fail | yes | left |

In the dummy data, "special characters" means anything other than letters, digits, hyphens,
underscores and slashes, and Result is Pass only when every check passes (in Webqa, Result comes
from the test and depends on the settings the user ticked).

**URL Slug settings (what the user can tick before the test).** #, URL, Slug and Result always show:

| Setting the user ticks | Column (`visible` key) |
|---|---|
| Every character in the URL needs to be lowercase | Uppercase characters (`uppercase`) |
| URLs cannot contain numbers | Numbers? (`numbers`) |
| URLs cannot contain special characters | Special characters (`specialCharacters`) |
| Maximum length of a URL should be 60 characters (excluding the domain name) | Length (`length`) |
| Words in URLs should be separated by Hyphens only | Hyphens? (`hyphens`) |
| Words in URLs should be separated by Underscores only | **no column yet**: to be decided |
| Words in URLs can be separated by either Hyphens or underscores | **no column yet**: to be decided |

The demo shows 4 example layouts (`URL_SLUG_OPTIONS`, `checkCoverage: false`):

| Option | Settings ticked |
|---|---|
| 1 - When all settings are chosen | all 5 with a column |
| 2 - Only the character settings | lowercase, numbers, special characters |
| 3 - Only the length and hyphens settings | length, hyphens |
| 4 - Only the lowercase setting | lowercase |

---

## 6. The shared core (`tools-page-table.js`)

Exposed as `window.ToolsTable`.

### Core functions: which columns are shown

| Function | Returns |
|---|---|
| `ToolsTable.create(container, options)` | Builds the table card inside `container`. Returns `{ element, columns, setData(rows) }`. |
| `ToolsTable.resolveColumns(columns, visible)` | The columns to show: every non-optional column (**always including Result**) plus the optional ones listed in `visible`, in definition order. `visible` omitted → all columns. Warns in the console about unknown keys. |
| `ToolsTable.optionalKeys(columns)` | Keys of the columns the user can switch on/off, e.g. `['length', 'titleEqualsH1', 'casing']`. Never includes Result. |
| `ToolsTable.hiddenKeys(columns, visible)` | Keys of the optional columns that are switched off. |
| `ToolsTable.combinations(keys)` | Every combination of the keys, most columns first (2ⁿ layouts, all → none). Useful for building and checking demo pages. |
| `ToolsTable.badge(text, tone, modifier)` | Pill HTML. `tone`: `'good'` (green), `'bad'` (red), `'info'` (blue) or `''`. `modifier`: extra size class, e.g. `'casing'`. |
| `DemoOptions.render({ …, checkCoverage })` (demo only) | `checkCoverage: false` skips the "missing combination" warning, for tools where only a selection of layouts is shown (Images). |
| `ToolsTable.iconLink(href, iconName, label)` | A small icon button linking to `href` (new tab) without showing the URL, e.g. the Images "Image link" column. `label` is the tooltip and screen-reader text. |
| `ToolsTable.iconUrl(name)` | URL of an icon in `assets/images`. |
| `ToolsTable.infoTip(text)` | An (i) icon with a tooltip, for use inside a `render` function (headers get one automatically from `tooltip`). |
| `ToolsTable.escapeHtml(value)` | Escapes text for use inside `render` functions. |

`create` options: `columns` (required), `visible`, `data`, `fileName`, `iconBase`,
`pageSizes` (default `[10, 25, 50, 100]`).

### Column definitions

Each tool describes its columns once, in display order:

| Property | Meaning |
|---|---|
| `key` | Data field (`row[key]`); also used in `visible` and for sorting |
| `label` | Header text (also the CSV/XLSX header) |
| `optional` | `true` = the user can switch this column on/off before the test (ignored for `key: 'result'`, which always shows) |
| `sortable` | `true` = click the header to sort (numbers numerically, text A–Z) |
| `align` | `'center'` centres the header and values (default left) |
| `numeric` | `true` = digits line up (tabular numbers) |
| `noWrap` | `true` = header stays on one line; the column starts wide enough to fit it |
| `compact` | `true` = as narrow as possible: 8px side padding instead of 16px, and the header wraps between words. Used for every **Yes/No** column and every **Length** column. For multi-word headings, add `minStartWidth` (e.g. `104`) so the heading takes two lines at most |
| `grow` | `true` = takes the spare width and is the widest column on load (e.g. Content). **Several grow columns share the spare width equally** (e.g. URL and Content on Robots Meta tag) |
| `startShare` | Starting width as a share of the table (e.g. URL `0.22`) |
| `minStartWidth` | Minimum starting width in px, for any column (e.g. File name `180`). For a grow column it's also the narrowest it shrinks to (default `MIN_GROW_WIDTH`, 240px) |
| `hideRepeats` | `true` = when consecutive rows have the same value, it shows on the first row only (e.g. Images URL, since one page has several images). The first row of every results page always shows it. Search, sorting and CSV/XLSX still use the value on every row |
| `tooltip` | Short help text. Adds a small (i) icon next to the header label; hovering or focusing it shows the text in a tooltip (e.g. Images Spaces). Long labels still wrap between words; the icon stays beside the last word |
| `group` | Header text of a column group. Consecutive columns with the same `group` sit under one shared header cell (two-row header), e.g. `'Alternate text'` over Content / Spaces. Both header rows stick while scrolling. A group left with a single column of the same name (e.g. only "File name") is shown as an ordinary heading |
| `fallbackGrow` | `true` = acts as the grow column only when no `grow` column is shown (e.g. Images File name, when Content is switched off) |
| `cellClass` | Extra class on the `<th>`/`<td>` |
| `value(row, ctx)` | Value for search and export (default `row[key]`). `ctx.rowNumber` = original position |
| `render(row, ctx)` | Cell HTML (default: escaped value). Use `ToolsTable.badge()` for pills |

The Meta title columns (`META_TITLE_COLUMNS` in `meta-title.js`):

| Column | Optional | Display | Sortable | Align |
|---|---|---|---|---|
| `#` | no | plain number, grey | no | left |
| URL | no | blue link, opens in new tab; starts at 22% (min 160px) | no | left |
| Content | no | plain text; **grow column** (widest) | no | left |
| Length | **yes** | pill: **green ≤ 65**, **red > 65** (`MAX_TITLE_LENGTH`) | yes | centre |
| Title Equal to H1 ? | **yes** | pill: **red Yes** (title copies the H1), **green No**; **compact** (heading on two lines, min 104px) | yes | centre |
| Casing | **yes** | pill (144 × 40px): **green** Camel / Sentence case, **red** Neither | yes | centre |
| Result | no | pill: **green** Pass, **red** Fail | yes | left |

### Core settings (top of `tools-page-table.js`)

| Setting | Default | What it does |
|---|---|---|
| `MIN_COL_WIDTH` | `50` | Narrowest a column can be dragged |
| `MIN_GROW_WIDTH` | `240` | The grow column (Content) never goes below this |
| `DEFAULT_PAGE_SIZES` | `[10, 25, 50, 100]` | "Show rows" options (override per table with `pageSizes`) |

---

## 7. Features and how they work

### Toolbar (top of the card)
- **Left:** CSV and XLSX download icons (both green file icons). Hover/keyboard focus shows a
  dark tooltip: "Download CSV" / "Download XLSX" (pure CSS, from the `data-tooltip` attribute).
- **Right:** search box. Live-filters across the **shown** columns; resets to page 1.

### Downloads
- Export **all rows matching the current search**, in the current sort order, across all pages
  (not just the visible page), with **only the shown columns**.
- CSV is UTF-8 with a BOM so Excel opens accents correctly. XLSX uses SheetJS.
- File name: `fileName` option + `.csv` / `.xlsx` (default `tools-page-table`).

### Sorting
- Click a sortable header. First click ascending, then toggles.
- The active column turns blue and shows a blue arrow (rotated for descending); other sortable
  columns show a faint grey arrow. Uses `aria-sort` on the `<th>` for accessibility.

### Pagination (bottom of the card)
- **Left:** "Showing 1–10 of 100".
- **Right:** "Show rows" dropdown (10 / 25 / 50 / 100, default 10), previous/next buttons,
  "Page X of Y".

### Column resizing
- Drag the thin separator at the right edge of any header cell. Minimum 50px per column.
- The separators run the full height of the header row; they turn blue on hover/drag.
- **The table never leaves blank space on the right:** shrinking a column gives the space to the
  column on its right (or left, for the last column). Widening beyond the card makes the table
  scroll sideways.
- **Starting widths** (measured once the page has loaded): short columns start at their narrowest
  width (headers may wrap between words, unless `noWrap`), `startShare` columns get their share,
  and the **grow column gets everything left** and is never narrower than a `startShare` column.
  With fewer optional columns, Content simply gets wider.
- When the container changes width (window resize, sidebar collapse), the grow column grows or
  shrinks to fit (`ResizeObserver`).

### Sticky header
- When the page scrolls past the top of the table, the header row stays pinned to the top of the
  window, with a soft shadow.
- **Normally pure CSS** (`position: sticky` on the `<th>`), so the browser handles it and it scrolls
  smoothly with no jerking.
- CSS sticky only works against the page when the table isn't inside a scrolling box, so
  `.table-wrap` only scrolls sideways when the table is actually wider than its container. JS adds
  `.fits` to `.table-wrap` when the table fits, which sets `overflow: visible`.
- **Fallback:** when the table is wider than its container (a column dragged wide, or a narrow
  screen), the script moves the header with a transform instead. This works, but can lag slightly
  while scrolling, because the script runs after the browser has scrolled.
- **Fixed site header:** if the Webqa page has a fixed header, set its height on the page, e.g.
  `.table-card { --table-sticky-top: 64px; }`. Both the CSS and the fallback use it.
- `.table-card` uses `overflow: clip`, not `overflow: hidden`, for its rounded corners:
  `hidden` would turn the card into a scroll box and stop the header sticking.

### Empty state
- If a search matches nothing: "No matching rows." and "Showing 0 of 0".

---

## 8. Visual design reference

**Font:** Inter (400/500/600), table body 14px / 20px line height; header 13px / 600, normal case
(as written in the column definitions, not all caps). Toolbar and footer inherit the page font
(Webqa uses Circular Std).

**Design tokens:** all colours live as CSS custom properties at the top of the table section of
`tools-page-table.css` (`.table-card { --tpt-… }`). Change them there to retheme every table.

| Token | Value | Used for |
|---|---|---|
| `--tpt-text` | `#101828` | Cell text |
| `--tpt-text-secondary` | `#344054` | Header text, page numbers, select |
| `--tpt-text-muted` | `#667085` | Footer text, empty state |
| `--tpt-text-faint` | `#98a2b3` | `#` column, search placeholder |
| `--tpt-accent` | `#2563eb` | Links, active sort, focus rings, resize highlight |
| `--tpt-border` | `#e4e7ec` | Card border, toolbar/footer dividers |
| `--tpt-control-border` | `#d0d5dd` | Search, select, page buttons |
| `--tpt-header-bg` | `#e3e9f7` | Header row background |
| `--tpt-header-line` | `#c3cee6` | Header column separators and bottom line |
| `--tpt-row-divider` | `#eef0f3` | Lines between rows |
| `--tpt-row-hover` | `#f6f8fd` | Row hover |
| `--tpt-footer-bg` | `#fcfcfd` | Footer background |
| `--tpt-good-text` / `-bg` / `-border` | `#067647` / `#ecfdf3` / `#abefc6` | **Green pills** (`.badge.good`) |
| `--tpt-bad-text` / `-bg` / `-border` | `#b42318` / `#fef3f2` / `#fecdca` | **Red pills** (`.badge.bad`) |
| `--tpt-info-text` / `-bg` / `-border` | `#175cd3` / `#eff8ff` / `#b2ddff` | **Blue pills** (`.badge.info`), e.g. Robots tag exists = No |
| `--tpt-edge-padding` | `20px` | Inner padding at the card's left/right edges |

| Element | Spec |
|---|---|
| Card | white, 1px border, 12px radius, soft two-layer shadow, full width of its container |
| Toolbar | 14px × 20px padding; 40px download buttons and search (260px wide), 8px radius |
| Tooltip | dark `#101828`, 8px radius, small pointer arrow, centred under the button |
| Header cells | 12px × 16px padding (20px at the card edges); bottom line drawn as an inset shadow so it stays attached while sticky |
| Body cells | 14px × 16px padding (20px at the card edges), top-aligned |
| Links | `--tpt-accent`, weight 500, underline on hover |
| Pills | rectangular, 4px radius, 12px / 600 text, 3px × 10px padding, 1px border |
| Pill size modifiers | `.length` (min 40px, tabular digits), `.yes-no` (min 44px), `.file-size` (min 64px, tabular digits), `.casing` (fixed 144 × 40px so all three values match) |
| Footer | light `--tpt-footer-bg`, top border; 32px select (custom arrow) and 32px square page buttons |
| Focus | 4px soft blue ring on buttons, search and select (keyboard users) |
| Motion | 0.12–0.15s transitions on hover states; download buttons lift 1px on hover |

Column classes the core adds to `<th>`/`<td>`: `col-first` / `col-last` (edge padding),
`th-group` (shared group header cell), `sub-head` (second header row), `col-center` (`align: 'center'`), `col-numeric`
(`numeric: true`), `no-wrap` (`noWrap: true`, header only), plus any `cellClass`
(the `#` column uses `num`).

**Icons** (`assets/images/`, all SVG):
`file-csv.svg`, `file-xlsx.svg` (green `#16a34a`), `search.svg`, `sort-arrow.svg` (grey idle),
`sort-arrow-active.svg` (blue), `chevron-left.svg`, `chevron-right.svg`, `chevron-down.svg`
(Show rows select arrow, referenced from the CSS), `image-link.svg` (blue chain-link icon for the Images "Image link" column).
`sidebar-toggle.svg` is for the demo shell only.

`info.svg` (grey (i) icon for tooltips).

**Other element styles:** `.icon-link` (32px bordered icon button), `.cell-empty` (grey italic
placeholder text, e.g. "No alt text"), `.info-tip` (the (i) icon button), `.th-with-tip` (keeps a
header label and its (i) icon together).

**Tooltips:** one shared `.tpt-tooltip` element is added to the page by the core and positioned
next to the (i) icon (above it, or below when there's no room). It lives outside the table on
purpose: header cells clip their content, so a tooltip inside them would be cut off. Dark
`#101828`, white 12px text, max 260px wide, small pointer arrow.

---

## 9. Recipes

### Add a new tool page (e.g. Meta description)
1. Create `assets/js/<tool>.js` with:
   - `<TOOL>_COLUMNS`: the column definitions (section 6). Mark the columns the user can switch
     off with `optional: true`; give one column `grow: true`. **Always include a Result column**
     (`key: 'result'`), as the last column; it shows in every option.
   - For the demo page: dummy data (100 rows), a `<TOOL>_OPTIONS` list with one entry per
     combination of optional columns (Option 1 = all settings chosen, first), and a call to
     `DemoOptions.render({ toolName, columns, options, data, fileName })`.
     `ToolsTable.combinations(ToolsTable.optionalKeys(<TOOL>_COLUMNS))` lists every combination;
     `DemoOptions.render` warns in the console if one is missing.
2. Copy `pages/meta-title.html` → `pages/<tool>.html`; keep the `main-option` / `other-options`
   containers, update the headings, and load `<tool>.js` instead of `meta-title.js` (after
   `tools-page-table.js` and `demo-options.js`).
3. Add the page to the sidebar: one entry in the `NAV` list at the top of
   `assets/js/page-layout.js`, under its section (SEO, Performance, Best Practices or Security).
   Every demo page's sidebar is built from that list.

No CSS or core changes are needed for a new tool.

### Add a column to a tool
Add one entry to that tool's column definitions, in the position it should appear, and the field
to the data. Everything else (header, cells, search, sort, export, widths) follows automatically.

### Add a new pill rule
In the column's `render`, return `ToolsTable.badge(value, condition ? 'good' : 'bad', modifier)`.
For a new colour, add `--tpt-…` tokens and a `.table-card .badge.<tone>` rule in the CSS.

---

## 10. Gotchas

- Column widths are measured on the `load` event. Use `table.setData(rows)` for data that arrives
  later; it re-measures.
- Keep `.table-card` on `overflow: clip`, and don't add `overflow` to any element between the
  table and the page. Either would stop the sticky header working (see "Sticky header").
- Load `tools-page-table.js` with a normal `<script src>` tag (not inlined or bundled) unless you
  pass `iconBase`; it works out the icon folder from its own URL.
- The XLSX button shows an alert if `xlsx.full.min.js` didn't load.
- `xlsx.full.min.js` is ~860 KB; consider loading it only on tool pages.
- Browser support: modern evergreen browsers (uses `ResizeObserver`, pointer events,
  `requestAnimationFrame`, CSS `overflow: clip`, `:focus-visible`).

---

## 11. Demo page content (not for integration)

`pages/meta-title.html`, top to bottom:
1. **Meta Title** (page heading: the tool name, 30px, the largest text on the page) + intro line
2. **Option 1 - When all settings are chosen** (all columns)
3. **Other options** + intro line, then Options 2–8:

| Option | Hidden columns | Shown optional columns |
|---|---|---|
| 1 | none | Length, Title Equal to H1 ?, Casing |
| 2 | Casing | Length, Title Equal to H1 ? |
| 3 | Casing, Title Equal to H1 ? | Length |
| 4 | Casing, Title Equal to H1 ?, Length | none |
| 5 | Length | Title Equal to H1 ?, Casing |
| 6 | Title Equal to H1 ? | Length, Casing |
| 7 | Length, Casing | Title Equal to H1 ? |
| 8 | Length, Title Equal to H1 ? | Casing |

Each option shows its title, a "Columns: …" line, **Test Results**, and the table. The sections
are generated by `DemoOptions.render` (`demo-options.js`) from `META_TITLE_OPTIONS`.

`pages/images.html` shows 3 of the 128 combinations (`IMAGES_OPTIONS` in `images.js`, with
`checkCoverage: false` so `DemoOptions.render` doesn't warn about the other 125):

| Option | Settings ticked |
|---|---|
| 1 - When all settings are chosen | all 7 |
| 2 - When only the file name settings are chosen | the 5 file name checks |
| 3 - When only the alt text settings are chosen | the 2 alt text checks |

`pages/robots-meta.html` and `pages/canonical-tag.html` have no
options: just the heading, an intro line, **Test Results** and one table with all 100 dummy rows. They call `ToolsTable.create`
directly (no `demo-options.js`).

**Rows on every demo page:** Option 1 (all settings chosen) shows all 100 dummy rows, so paging,
sorting and the sticky header can be tried. Every other option shows only the first 10 rows, to
keep the page short. The limit is `OTHER_OPTIONS_ROWS` in `demo-options.js`.

`pages/meta-description.html` follows the same structure with two options:

| Option | Hidden columns | Shown optional columns |
|---|---|---|
| 1 - When all settings are chosen | none | Length |
| 2 - When the Length table isn't there | Length | none |

The demo shell has a dark header bar with a centred title ("Tools Page Table CSS Improvement")
and a collapsible left sidebar, built by `page-layout.js` from its `NAV` list: **Index** at the
top, then sections **SEO** (Meta Title, Meta Description, Robots Meta Tag, Canonical Tag, Images, URL Slug),
**Performance**, **Best Practices** and **Security** (the last three show "Coming soon" until
pages are added). Each section is an **accordion**: click its heading (+ / −) to expand or collapse
it. The section holding the current page opens by default (SEO on the Index page); after that,
each section's open/closed state is remembered in localStorage. The current page is highlighted; the collapsed state is remembered in the
browser's localStorage.
