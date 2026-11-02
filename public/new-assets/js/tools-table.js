/**
 * Tools page results table: presentation helper.
 *
 * Design only. It never changes what a cell says, which classes it carries or what
 * DataTables / the CSV + XLSX exports read. All it does is wrap the text of the
 * Pass / Fail cells (`td.result_pass`, `td.result_fail`) in a <span class="tpt-pill">
 * so tools-table.css can draw them as pills, like the reference design in /tools-page-table.
 *
 * It also asks the browser to load the Inter font up front, so the URL truncation in
 * bulk.js (which measures text) sees the final font and not the fallback.
 */
(function () {
    'use strict';

    var AREA = '.inner_content-tools .test_result_area';
    var CELLS = 'td.result_pass, td.result_fail, td.result_pass-imran, td.result_fail-imran';
    var WORD = /^(pass|fail)$/i;

    // ---- fonts -----------------------------------------------------------------
    if (document.fonts && document.fonts.load) {
        ['400', '500', '600'].forEach(function (weight) {
            document.fonts.load(weight + ' 14px "Inter"').catch(function () {});
        });
    }

    // ---- pills -----------------------------------------------------------------
    function enhanceCell(td) {
        if (td.querySelector('.tpt-pill')) return; // already done

        var pill = null;
        var first = td.firstChild;

        if (first && first.nodeType === 3 && first.nodeValue.trim() !== '') {
            // The cell starts with text: "PASS", "Yes", "14", "-" ... (anything after it, such as the
            // hidden "List of Links" helper on the cross-origin tool, is left exactly as it was)
            pill = document.createElement('span');
            pill.className = 'tpt-pill';
            pill.textContent = first.nodeValue; // full node value, so the cell's textContent is unchanged
            td.replaceChild(pill, first);
        } else if (td.children.length === 1 && td.children[0].tagName === 'STRONG' && td.textContent.trim() === td.children[0].textContent.trim()) {
            // <strong>PASS</strong>
            pill = td.children[0];
            pill.classList.add('tpt-pill');
        } else {
            return; // other markup (e.g. <span class="result_pass">): CSS styles it directly
        }

        if (WORD.test(pill.textContent.trim())) pill.classList.add('tpt-pill-word');
    }

    function enhanceCells(root) {
        var list = root.querySelectorAll ? root.querySelectorAll(CELLS) : [];
        for (var i = 0; i < list.length; i++) enhanceCell(list[i]);
    }

    function enhanceAll() {
        var areas = document.querySelectorAll(AREA);
        for (var i = 0; i < areas.length; i++) enhanceCells(areas[i]);
    }

    // ---- when to run -----------------------------------------------------------
    var area = document.querySelector(AREA);
    if (area && window.MutationObserver) {
        var observer = new MutationObserver(function () {
            // stop watching while we edit, otherwise our own changes would re-trigger us
            observer.disconnect();
            enhanceAll();
            observer.observe(area, { childList: true, subtree: true });
        });
        observer.observe(area, { childList: true, subtree: true });
    }

    // DataTables keeps rows that are not on the current page out of the document, so the
    // observer above can't see them. On every draw, enhance all of the table's rows once.
    if (window.jQuery) {
        window.jQuery(document).on('draw.dt', function (e, settings) {
            try {
                if (!settings || !settings.nTable || !area || !area.contains(settings.nTable)) return;
                if (settings.nTable.getAttribute('data-tpt-pills') === '1') return;
                var nodes = new window.jQuery.fn.dataTable.Api(settings).rows().nodes();
                for (var i = 0; i < nodes.length; i++) enhanceCells(nodes[i]);
                settings.nTable.setAttribute('data-tpt-pills', '1');
            } catch (err) {
                /* presentation only: never break the page */
            }
        });
    }

    enhanceAll();
})();

/**
 * Tools page results table: header features from the reference design (/tools-page-table).
 *
 *   1. Tooltips: one shared tooltip element on <body>, used by the CSV / XLSX buttons and by the
 *      (i) icons in the column headers. It lives outside the table card, so the card's
 *      `overflow: clip` can no longer cut it off.
 *   2. Header help: an (i) icon with a short explanation on the columns listed in HEADER_TIPS.
 *   3. Sorting: a sort button (label + arrow) on short value columns (Length, Yes / No, scores,
 *      Result...). First click ascending, then it toggles. Runs through DataTables (api.order()).
 *   4. Resizing: drag the right edge of a header cell. A shrinking column gives its space to the
 *      neighbour, so the table never leaves blank space on the right.
 *
 * Hooked to DataTables' `init.dt` event, so it applies to every tools table bulk.js builds.
 */
(function () {
    'use strict';

    var $ = window.jQuery;
    if (!$ || !$.fn || !$.fn.dataTable) return;

    var AREA = '.inner_content-tools .test_result_area';
    var MIN_COL_WIDTH = 50;
    var MAX_SORT_VALUE_LENGTH = 40; // longer cell text = a text column (Content, Output...), not sortable

    // ---- Header help text, per tool page (/tools/<slug>), keyed by the lower-case header label ----
    var LEN = function (what) { return 'Number of characters in the ' + what + '.'; };
    var COMMON = {
        'width, height': 'Width and height of the image in pixels.'
    };
    var HEADER_TIPS = {
        'meta-title': {
            'length': LEN('meta title'),
            'title equal to h1?': 'Is the meta title exactly the same as the page\'s H1 heading?',
            'casing': 'Is the meta title written in Camel case or Sentence case?'
        },
        'meta-description': {
            'len': LEN('meta description')
        },
        'robots-meta': {
            'robots tag exists': 'Does the page have a robots meta tag?',
            'content': 'The directives in the robots meta tag, e.g. index, follow.'
        },
        'canonical-url': {
            'canonical url': 'The URL in the page\'s canonical tag.',
            'equal to actual url?': 'Is the canonical URL the same as the tested URL?'
        },
        'url-slug': {
            'slug': 'The part of the URL after the domain name.',
            'len': LEN('URL slug (domain name excluded)'),
            'has numbers?': 'Does the URL slug contain numbers?',
            'special characters?': 'Does the URL slug contain special characters?',
            'uppercase characters?': 'Does the URL slug contain uppercase characters?',
            'hyphens only?': 'Are words in the URL slug separated by hyphens only?',
            'words separated by underscores only?': 'Are words in the URL slug separated by underscores only?',
            'contains stop words?': 'Does the URL slug contain stop words such as "and", "the" or "of"?'
        },
        'images': {
            'content': 'The image\'s alternate (alt) text.',
            'spaces': 'Are the words in alternate text separated by spaces?',
            'len': LEN('image file name'),
            'words separated by hyphens?': 'Are words in the file name separated by hyphens?',
            'uppercase characters?': 'Does the file name contain uppercase characters?',
            'special characters?': 'Does the file name contain special characters?',
            'file size': 'Size of the image file. Large images slow the page down.'
        },
        'og-tags': {
            'og:title': 'The og:title tag: the headline shown when the page is shared on social media.',
            'len': LEN('og:title'),
            'casing': 'Is the og:title written in Camel case or Sentence case?',
            'og:title equal to title?': 'Is the og:title the same as the page\'s meta title?',
            'og:description': 'The og:description tag: the text shown under the headline when the page is shared.',
            'og:description equal to meta desciption?': 'Is the og:description the same as the page\'s meta description?',
            'og:image': 'The og:image tag: the image shown when the page is shared.',
            'og:url': 'The og:url tag: the address used when the page is shared.',
            'og:url equal to the actual url?': 'Is the og:url the same as the tested URL?'
        },
        'twitter-tags': {
            'twitter:title': 'The twitter:title tag: the headline shown when the page is shared on X (Twitter).',
            'len': LEN('twitter:title'),
            'casing': 'Is the twitter:title written in Camel case or Sentence case?',
            'twitter:title equal to title?': 'Is the twitter:title the same as the page\'s meta title?',
            'twitter:image': 'The twitter:image tag: the image shown when the page is shared on X (Twitter).',
            'twitter:image:alt': 'Alternate text for the twitter:image, read out by screen readers.'
        },
        'xml-sitemap': {
            'url added to xml sitemap?': 'Is this URL listed in your XML sitemap?'
        },
        'schema': {
            'types': 'Schema.org types found in the page\'s structured data.',
            'problems': 'Errors found in the page\'s structured data.'
        },
        'meta-viewport': {
            'meta viewport tag present?': 'Does the page have a meta viewport tag? Without it, the page won\'t scale properly on phones.'
        },
        'doctype': {
            'doctype tag present?': 'Does the page start with a <!DOCTYPE html> declaration?'
        },
        'http-status-code': {
            'http status code': 'The status code the server returned, e.g. 200 (OK), 301 (redirect) or 404 (not found).'
        },
        'google-page-speed-insights': {
            'desktop score': 'Google PageSpeed Insights performance score on desktop, out of 100.',
            'mobile score': 'Google PageSpeed Insights performance score on mobile, out of 100.'
        },
        'google-lighthouse': {
            'performance': 'Lighthouse Performance score, out of 100: how fast the page loads.',
            'accessibility': 'Lighthouse Accessibility score, out of 100: how usable the page is for everyone.',
            'best practices': 'Lighthouse Best Practices score, out of 100: modern, secure web standards.',
            'seo': 'Lighthouse SEO score, out of 100: basic search engine optimisation.'
        },
        'broken-links': {
            'internal': 'Number of broken links to pages on the same website.',
            'external': 'Number of broken links to other websites.'
        },
        'headings': {
            'quantity': 'How many headings of this level the page has.'
        }
    };
    // Header labels that are never sortable (links or free text)
    var NO_SORT = /^(#|url|content|slug|canonical url|image link|file name|message|output|types|problems|favicon|list of broken links|width, height|og:(title|description|image|url)|twitter:(title|image|image:alt))$/;

    function toolSlug() {
        var m = window.location.pathname.match(/\/tools?\/([^\/?#]+)/);
        return m ? m[1].toLowerCase() : '';
    }
    function norm(text) {
        return String(text || '').replace(/\s+/g, ' ').trim().toLowerCase();
    }
    function stripHtml(value) {
        return String(value == null ? '' : value)
            .replace(/<[^>]*>/g, '')
            .replace(/&nbsp;/g, ' ')
            .trim();
    }
    function tipFor(label) {
        var tips = HEADER_TIPS[toolSlug()] || {};
        return tips[label] || COMMON[label] || null;
    }

    // ---- 1. Shared tooltip -------------------------------------------------------
    var tipEl = null;
    var tipOwner = null;

    function showTip(target, text, preferBelow) {
        if (!text) return;
        if (!tipEl) {
            tipEl = document.createElement('div');
            tipEl.className = 'tpt-tooltip';
            tipEl.setAttribute('role', 'tooltip');
            document.body.appendChild(tipEl);
        }
        tipOwner = target;
        tipEl.textContent = text;
        tipEl.classList.add('is-visible');

        var r = target.getBoundingClientRect();
        var t = tipEl.getBoundingClientRect();
        var left = Math.min(Math.max(8, r.left + r.width / 2 - t.width / 2), window.innerWidth - t.width - 8);
        var above = r.top - t.height - 10;
        var below = r.bottom + 10;
        var fitsBelow = below + t.height <= window.innerHeight - 8;
        var placeBelow = preferBelow ? (fitsBelow || above < 8) : above < 8;

        tipEl.classList.toggle('is-below', placeBelow);
        tipEl.style.left = left + 'px';
        tipEl.style.top = (placeBelow ? below : above) + 'px';
        tipEl.style.setProperty('--arrow-x', (r.left + r.width / 2 - left) + 'px');
    }
    function hideTip() {
        tipOwner = null;
        if (tipEl) tipEl.classList.remove('is-visible');
    }

    var TIP_TARGETS = AREA + ' .bulk-export-tip[data-tooltip], ' + AREA + ' .tpt-info-tip[data-tip]';
    function tipTarget(node) {
        return node && node.closest ? node.closest(TIP_TARGETS) : null;
    }
    function openTipFor(el) {
        var isExport = el.classList.contains('bulk-export-tip');
        showTip(el, isExport ? el.getAttribute('data-tooltip') : el.getAttribute('data-tip'), isExport);
    }
    document.addEventListener('mouseover', function (e) {
        var el = tipTarget(e.target);
        if (el && el !== tipOwner) openTipFor(el);
    });
    document.addEventListener('mouseout', function (e) {
        var el = tipTarget(e.target);
        if (el && !el.contains(e.relatedTarget)) hideTip();
    });
    document.addEventListener('focusin', function (e) {
        var el = tipTarget(e.target);
        if (el) openTipFor(el);
    });
    document.addEventListener('focusout', function (e) {
        if (tipTarget(e.target)) hideTip();
    });
    window.addEventListener('scroll', hideTip, true);

    // ---- Sorting: numbers with units ("184 KB", "1.2 s") sort by value ------------
    //      The type is set per column in enhanceTable(), so placeholders such as "-" or "Inline SVG
    //      (size not applicable)" don't turn a number column into a text column.
    var UNIT_NUM = /^(-?\d+(?:\.\d+)?)\s*(kb|mb|b|ms|s|%|px)?$/i;
    function isNumberColumn(values) {
        var numbers = 0;
        var ok = values.every(function (raw) {
            var text = stripHtml(raw);
            if (UNIT_NUM.test(text)) { numbers++; return true; }
            return !/^\d/.test(text); // a placeholder, not a different kind of number
        });
        return ok && numbers > 0;
    }
    $.fn.dataTable.ext.type.order['tpt-unit-num-pre'] = function (data) {
        var m = stripHtml(data).match(UNIT_NUM);
        if (!m) return -Infinity; // empty / "-" sort first in ascending order
        var n = parseFloat(m[1]);
        var unit = (m[2] || '').toLowerCase();
        if (unit === 'kb') n *= 1024;
        else if (unit === 'mb') n *= 1048576;
        else if (unit === 'ms') n /= 1000;
        return n;
    };

    // ---- Header layout -----------------------------------------------------------
    function isHiddenCell(cell) {
        return cell.classList.contains('d-none') ||
            cell.classList.contains('hidden-element') ||
            cell.style.display === 'none';
    }
    function isHiddenHeader(th) {
        return window.getComputedStyle(th).display === 'none';
    }

    // Works out, for each visible column, the header cell that labels it ("leaf"): the lowest
    // single-column cell with text. Images / Lighthouse have two header rows, where #, URL and
    // Result sit in the top row above an empty cell.
    function readHeader(table) {
        var columns = [];
        var labelCells = [];
        Array.prototype.forEach.call(table.tHead.rows, function (row) {
            var v = 0;
            Array.prototype.forEach.call(row.cells, function (th) {
                if (isHiddenHeader(th)) return;
                var span = Math.max(1, th.colSpan || 1);
                if (span === 1) (columns[v] = columns[v] || []).push(th);
                if (norm(th.textContent) !== '' || th.hasAttribute('data-tooltip')) labelCells.push(th);
                v += span;
            });
        });
        var leaves = [];
        for (var v = 0; v < columns.length; v++) {
            var cells = columns[v] || [];
            var leaf = null;
            for (var i = cells.length - 1; i >= 0 && !leaf; i--) {
                if (norm(cells[i].textContent) !== '') leaf = cells[i];
            }
            leaves.push(leaf || cells[cells.length - 1] || null);
        }
        return { leaves: leaves, labelCells: labelCells };
    }

    function makeInfoTip(text) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'tpt-info-tip';
        btn.setAttribute('data-tip', text);
        btn.setAttribute('aria-label', text);
        // Clicking the (i) must never sort the column
        btn.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); });
        return btn;
    }

    // Wraps a header cell's existing content (kept as is) so a sort button and an (i) icon can sit beside it
    function decorateHeader(th, tipText, onSort) {
        if (th.querySelector('.tpt-th-inner')) return;
        var label = document.createElement('span');
        label.className = 'tpt-th-label';
        while (th.firstChild) label.appendChild(th.firstChild);

        var inner = document.createElement('span');
        inner.className = 'tpt-th-inner';

        if (onSort) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'tpt-sort-btn';
            var arrow = document.createElement('span');
            arrow.className = 'tpt-sort-arrow';
            arrow.setAttribute('aria-hidden', 'true');
            btn.appendChild(label);
            btn.appendChild(arrow);
            btn.addEventListener('click', onSort);
            inner.appendChild(btn);
        } else {
            inner.appendChild(label);
        }
        if (tipText) inner.appendChild(makeInfoTip(tipText));
        th.appendChild(inner);
    }

    // ---- Table adapters: the same header features work on a DataTables table (most tools) and on
    //      the plain tables bulk.js builds for the Open Graph / Twitter tabs.
    function dataTablesAdapter(settings) {
        var api = new $.fn.dataTable.Api(settings);
        return {
            rows: function () { return api.rows({ order: 'index' }).nodes().toArray(); },
            shownRows: function () { return api.rows({ page: 'current' }).nodes().toArray(); },
            columnCount: function () { return api.columns().count(); },
            columnData: function (col) { return api.column(col).data().toArray(); },
            useNumberSort: function (col) {
                // _sManualType survives DataTables re-detecting types after a row refresh
                settings.aoColumns[col].sType = 'tpt-unit-num';
                settings.aoColumns[col]._sManualType = 'tpt-unit-num';
            },
            order: function () { return api.order(); },
            sort: function (col, dir) { api.order([col, dir]).draw(); },
            // DataTables resets aria-sort while sorting, so callers update the header after the redraw
            onDraw: function (fn) { api.on('draw', fn); }
        };
    }

    function plainTableAdapter(table) {
        var tbody = table.tBodies[0];
        var original = tbody ? Array.prototype.slice.call(tbody.rows) : [];
        var numberCols = {};
        var current = [];
        var listeners = [];
        var sortValue = $.fn.dataTable.ext.type.order['tpt-unit-num-pre'];

        function cellHtml(tr, col) { return tr.cells[col] ? tr.cells[col].innerHTML : ''; }
        return {
            rows: function () { return original.slice(); },
            shownRows: function () { return tbody ? Array.prototype.slice.call(tbody.rows) : []; },
            columnCount: function () { return original.length ? original[0].cells.length : 0; },
            columnData: function (col) { return original.map(function (tr) { return cellHtml(tr, col); }); },
            useNumberSort: function (col) { numberCols[col] = true; },
            order: function () { return current; },
            sort: function (col, dir) {
                var sign = dir === 'desc' ? -1 : 1;
                var keyed = original.map(function (tr, i) {
                    var html = cellHtml(tr, col);
                    return { tr: tr, i: i, key: numberCols[col] ? sortValue(html) : stripHtml(html).toLowerCase() };
                });
                keyed.sort(function (a, b) {
                    var diff = numberCols[col] ? a.key - b.key : a.key.localeCompare(b.key, undefined, { numeric: true });
                    return diff ? diff * sign : a.i - b.i; // keep the original order for equal values
                });
                keyed.forEach(function (k) { tbody.appendChild(k.tr); });
                current = [[col, dir]];
                listeners.forEach(function (fn) { fn(); });
            },
            onDraw: function (fn) { listeners.push(fn); }
        };
    }

    // ---- Images: one row per image. The page's # and URL show on its first row only;
    //      after sorting, show them on the first row of each run instead (like the reference). ----
    function setupGroupedRows(adapter) {
        var nodes = adapter.rows();
        if (!nodes.length) return null;
        var grouped = nodes.some(function (tr) {
            return tr.cells.length > 1 && tr.cells[1].innerHTML.trim() === '' && tr.cells[0].innerHTML.trim() === '';
        });
        if (!grouped) return null;

        var current = null;
        nodes.forEach(function (tr) {
            if (tr.cells.length < 2) return;
            if (tr.cells[1].innerHTML.trim() !== '' || !current) {
                current = { num: tr.cells[0].innerHTML, url: tr.cells[1].innerHTML };
            }
            tr._tptGroup = current;
        });

        return function () {
            var prev = null;
            adapter.shownRows().forEach(function (tr) {
                var group = tr._tptGroup;
                if (!group) return;
                var first = group !== prev;
                tr.cells[0].innerHTML = first ? group.num : '';
                tr.cells[1].innerHTML = first ? group.url : '';
                tr.cells[0].classList.toggle('has-border', first);
                tr.cells[1].classList.toggle('has-border', first);
                prev = group;
            });
        };
    }

    // ---- 3 + 4. Per table setup ------------------------------------------------------
    function enhanceTable(table, adapter) {
        var area = table.closest(AREA);
        if (!area || !table.tHead || table.getAttribute('data-tpt-header') === '1') return;
        table.setAttribute('data-tpt-header', '1');

        var header = readHeader(table);
        var leaves = header.leaves;

        // Visible header columns ↔ table column indexes (hidden columns are skipped).
        // If the header and the rows disagree, only the tooltips are added.
        var firstRow = adapter.rows()[0];
        var colIndex = [];
        if (firstRow) {
            Array.prototype.forEach.call(firstRow.cells, function (td, i) {
                if (!isHiddenCell(td)) colIndex.push(i);
            });
        }
        var mappable = !!firstRow &&
            colIndex.length === leaves.length &&
            firstRow.cells.length === adapter.columnCount() &&
            leaves.every(Boolean);

        function isSortable(v) {
            if (!mappable || v === 0) return false;
            var label = norm(leaves[v].textContent);
            if (NO_SORT.test(label)) return false;
            return adapter.columnData(colIndex[v]).every(function (raw) {
                var html = String(raw == null ? '' : raw);
                return !/<(a|img|svg)\b/i.test(html) && stripHtml(html).length <= MAX_SORT_VALUE_LENGTH;
            });
        }

        // Tooltips on every labelled header cell (group headings too, e.g. Core Web Vitals "LCP")
        header.labelCells.forEach(function (th) {
            if (leaves.indexOf(th) !== -1) return; // leaves are handled below, with sorting
            var existing = th.getAttribute('data-tooltip');
            if (existing) {
                th.removeAttribute('data-tooltip');
                th.classList.remove('custom-tooltip-imran');
            }
            var tip = existing || tipFor(norm(th.textContent));
            if (tip) decorateHeader(th, tip, null);
        });

        var sortCols = [];
        leaves.forEach(function (th, v) {
            if (!th) return;
            var existing = th.getAttribute('data-tooltip');
            if (existing) {
                th.removeAttribute('data-tooltip');
                th.classList.remove('custom-tooltip-imran');
            }
            var tip = existing || tipFor(norm(th.textContent));
            var sortable = isSortable(v);
            if (sortable) {
                sortCols.push(v);
                if (isNumberColumn(adapter.columnData(colIndex[v]))) adapter.useNumberSort(colIndex[v]);
                // Short value columns (Length, Yes / No...) are "compact": tighter side padding, like the
                // reference, so wide tables such as Images leave room for the URL
                if (norm(th.textContent) !== 'result') {
                    th.classList.add('tpt-compact');
                    adapter.rows().forEach(function (tr) {
                        if (tr.cells[colIndex[v]]) tr.cells[colIndex[v]].classList.add('tpt-compact');
                    });
                }
            }
            if (!sortable && !tip) return;
            decorateHeader(th, tip, sortable ? function () {
                var col = colIndex[v];
                var current = adapter.order();
                var dir = (current.length && current[0][0] === col && current[0][1] === 'asc') ? 'desc' : 'asc';
                adapter.sort(col, dir);
            } : null);
        });

        function syncSortState() {
            var current = adapter.order();
            var col = current.length ? current[0][0] : -1;
            var dir = current.length ? current[0][1] : '';
            sortCols.forEach(function (v) {
                var th = leaves[v];
                if (colIndex[v] === col) {
                    th.setAttribute('data-tpt-sort', dir === 'desc' ? 'desc' : 'asc');
                    th.setAttribute('aria-sort', dir === 'desc' ? 'descending' : 'ascending');
                } else {
                    th.removeAttribute('data-tpt-sort');
                    th.removeAttribute('aria-sort');
                }
            });
        }
        adapter.onDraw(syncSortState);

        var fillGroups = setupGroupedRows(adapter);
        if (fillGroups) {
            adapter.onDraw(fillGroups);
            fillGroups();
        }

        if (mappable) setupResizing(table, leaves);
    }

    // Column widths come from a <colgroup> (fixed table layout) once the user first drags a column
    function setupResizing(table, leaves) {
        var widths = null;
        var cols = [];

        function wrapWidth() {
            var wrap = table.closest('.table-responsive') || table.parentElement;
            return wrap ? wrap.clientWidth : 0;
        }
        function total() {
            return widths.reduce(function (sum, w) { return sum + w; }, 0);
        }
        function apply() {
            widths.forEach(function (w, i) { cols[i].style.width = w + 'px'; });
            table.style.width = total() + 'px';
        }
        // The table must never be narrower than its container (no blank space on the right)
        function fillSpare(index) {
            var spare = wrapWidth() - total();
            if (spare > 0) widths[index] += spare;
        }
        function freeze() {
            if (widths) return;
            widths = leaves.map(function (th) { return th.getBoundingClientRect().width; });
            var colgroup = document.createElement('colgroup');
            colgroup.className = 'tpt-cols';
            cols = widths.map(function () {
                var col = document.createElement('col');
                colgroup.appendChild(col);
                return col;
            });
            table.insertBefore(colgroup, table.firstChild);
            table.classList.add('tpt-resized');
            apply();
        }

        leaves.forEach(function (th, i) {
            var handle = document.createElement('span');
            handle.className = 'tpt-col-resizer';
            handle.setAttribute('aria-hidden', 'true');
            th.classList.add('tpt-has-resizer');
            th.appendChild(handle);

            handle.addEventListener('click', function (e) { e.stopPropagation(); });
            handle.addEventListener('pointerdown', function (e) {
                if (e.button !== 0) return;
                e.preventDefault();
                e.stopPropagation();
                freeze();
                var startX = e.clientX;
                var start = widths.slice();
                // When a column shrinks, the column to its right (or left, for the last one) takes up the slack
                var neighbor = i < widths.length - 1 ? i + 1 : i - 1;
                handle.setPointerCapture(e.pointerId);
                handle.classList.add('is-dragging');
                document.body.classList.add('tpt-resizing');
                hideTip();

                function onMove(ev) {
                    widths = start.slice();
                    widths[i] = Math.max(MIN_COL_WIDTH, start[i] + ev.clientX - startX);
                    if (neighbor >= 0) fillSpare(neighbor);
                    apply();
                }
                function onUp() {
                    handle.classList.remove('is-dragging');
                    document.body.classList.remove('tpt-resizing');
                    handle.removeEventListener('pointermove', onMove);
                    handle.removeEventListener('pointerup', onUp);
                    handle.removeEventListener('pointercancel', onUp);
                }
                handle.addEventListener('pointermove', onMove);
                handle.addEventListener('pointerup', onUp);
                handle.addEventListener('pointercancel', onUp);
            });
        });

        // After resizing, keep filling the container when it gets wider (window resize, sidebar)
        if (window.ResizeObserver) {
            var wrap = table.closest('.table-responsive') || table.parentElement;
            var observer = new ResizeObserver(function () {
                if (!document.body.contains(table)) { observer.disconnect(); return; }
                if (!widths) return;
                var widest = widths.indexOf(Math.max.apply(null, widths));
                fillSpare(widest);
                apply();
            });
            if (wrap) observer.observe(wrap);
        }
    }

    function safely(fn) {
        try {
            fn();
        } catch (err) {
            /* presentation only: never break the results table */
            if (window.console) console.warn('tools-table: header features skipped', err);
        }
    }

    // DataTables tables: as soon as DataTables has set them up
    $(document).on('init.dt', function (e, settings) {
        if (!settings || !settings.nTable) return;
        safely(function () { enhanceTable(settings.nTable, dataTablesAdapter(settings)); });
    });

    // Plain tables (Open Graph / Twitter tabs): once bulk.js has added them to the page
    var area = document.querySelector(AREA);
    if (area && window.MutationObserver) {
        var pending = null;
        new MutationObserver(function () {
            clearTimeout(pending);
            pending = setTimeout(function () {
                var tables = area.querySelectorAll('table.bulk-table:not([data-tpt-header])');
                Array.prototype.forEach.call(tables, function (table) {
                    if ($.fn.dataTable.isDataTable(table) || table.closest('table table')) return;
                    if (table.classList.contains('custom-dataTable')) return; // DataTables will pick it up
                    safely(function () { enhanceTable(table, plainTableAdapter(table)); });
                });
            }, 50);
        }).observe(area, { childList: true, subtree: true });
    }
})();
