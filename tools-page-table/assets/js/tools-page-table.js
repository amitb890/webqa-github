// Tools Page Table: shared core for every Webqa tools results table (Meta title, and the pages that follow).
//
// Each tool page describes its own columns once (see assets/js/meta-title.js for an example), marks
// which ones the user can switch on/off before the test (`optional: true`), and then creates a table
// with the columns the user chose. The core decides which columns are shown and handles search,
// sorting, paging, column resizing, the sticky header and CSV/XLSX export.
//
// Needs tools-page-table.css, and the SheetJS (XLSX) library loaded first for the XLSX download.
//
//   ToolsTable.create(container, {
//     columns: META_TITLE_COLUMNS,          // column definitions for this tool (see "Column definitions")
//     visible: ['length', 'casing'],         // optional columns the user chose; omit to show all of them
//     data: rows                             // result rows (max 100)
//   });
(function () {
  'use strict';

  // Icons live in assets/images, next to this script's assets/js folder
  const scriptSrc = document.currentScript ? document.currentScript.src : '';
  const DEFAULT_ICON_BASE = scriptSrc ? new URL('../images/', scriptSrc).href : 'assets/images/';

  // ---- Settings shared by every table ----
  const MIN_COL_WIDTH = 50;          // narrowest a column can be dragged
  const MIN_GROW_WIDTH = 240;        // a "grow" column (e.g. Content) never goes below this, unless it sets minStartWidth
  const DEFAULT_PAGE_SIZES = [10, 25, 50, 100];

  // ---- Column definitions ----
  // Each tool page passes an array of these, in display order:
  //   key            data field (row[key]); also used in `visible` and for sorting
  //   label          header text
  //   optional       true = the user can switch this column on/off before the test
//                  (ignored for the Result column, which always shows on every tools page)
  //   sortable       true = click the header to sort
  //   align          'center' to centre the header and values (default left)
  //   numeric        true = digits line up (tabular numbers)
  //   noWrap         true = the header stays on one line (the column starts wide enough to fit it)
  //   grow           true = takes the spare width; the widest column on load (e.g. Content). If several
  //                  columns have grow, they share the spare width equally (e.g. URL and Content)
  //   fallbackGrow   true = acts as the grow column only when no `grow` column is shown
  //                  (e.g. Images File name, when the alt text Content column is switched off)
  //   startShare     starting width as a share of the table width (e.g. 0.22 for URL)
  //   minStartWidth  minimum starting width in px (for any column, including startShare ones)
  //   group          header text of a column group; consecutive columns with the same group are shown
  //                  under one shared header cell (a two-row header), e.g. 'Alternate text'
  //   tooltip        short help text shown from a small (i) icon next to the header label
  //   compact        true = as narrow as possible: tighter padding, and the header wraps between words
  //                  (for short values such as Yes/No or Length pills)
  //   hideRepeats    true = when consecutive rows have the same value, show it on the first row only
  //                  (e.g. Images URL: one page, several images). Search, sort and export still use it
  //   cellClass      extra class on the <th>/<td>
  //   value(row, ctx)  value used for search, sorting fallback and export (default row[key])
  //   render(row, ctx) cell HTML (default: the escaped value). ctx = { rowNumber }

  // ---- Core helpers: which columns are shown ----

  // Rule for every tools page: the Result column always shows, whatever the user chooses.
  // It can't be made optional, and every tool's column definitions must include it.
  const RESULT_KEY = 'result';
  const isOptional = c => Boolean(c.optional) && c.key !== RESULT_KEY;

  function checkColumns(columns) {
    if (!columns.some(c => c.key === RESULT_KEY)) {
      console.warn(`ToolsTable: every tools table needs a "${RESULT_KEY}" column (it always shows)`);
    }
    columns.filter(c => c.key === RESULT_KEY && c.optional).forEach(() => {
      console.warn(`ToolsTable: the "${RESULT_KEY}" column can't be optional; it always shows`);
    });
  }

  // Keys of the columns the user can switch on/off (never includes Result)
  function optionalKeys(columns) {
    return columns.filter(isOptional).map(c => c.key);
  }

  // The columns to show: every non-optional column (always including Result), plus the optional
  // ones listed in `visible` (all optional columns when `visible` is omitted).
  // Display order always follows `columns`.
  function resolveColumns(columns, visible) {
    if (visible == null) return columns.slice();
    const wanted = new Set(visible);
    const known = new Set(optionalKeys(columns));
    wanted.forEach(key => {
      if (!known.has(key) && key !== RESULT_KEY) console.warn(`ToolsTable: "${key}" is not an optional column`);
    });
    return columns.filter(c => !isOptional(c) || wanted.has(c.key));
  }

  // Keys of the optional columns that are hidden
  function hiddenKeys(columns, visible) {
    const shown = new Set(resolveColumns(columns, visible).map(c => c.key));
    return optionalKeys(columns).filter(key => !shown.has(key));
  }

  // Every combination of the given keys, most columns first (2^n layouts, from "all" down to "none")
  function combinations(keys) {
    const result = [];
    for (let mask = (1 << keys.length) - 1; mask >= 0; mask--) {
      result.push(keys.filter((_, i) => mask & (1 << i)));
    }
    return result.sort((a, b) => b.length - a.length);
  }

  // ---- Rendering helpers for column definitions ----
  function escapeHtml(value) {
    return String(value).replace(/[&<>"']/g, ch => (
      { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch]
    ));
  }

  // URL of an icon in assets/images (for use in render functions)
  function iconUrl(name) {
    return `${DEFAULT_ICON_BASE}${name}`;
  }

  // A small icon button that opens `href` in a new tab, without showing the URL itself
  function iconLink(href, iconName, label) {
    return `<a class="icon-link" href="${escapeHtml(href)}" target="_blank" rel="noopener" title="${escapeHtml(label)}" aria-label="${escapeHtml(label)}"><img src="${iconUrl(iconName)}" alt=""></a>`;
  }

  // A small (i) icon that shows `text` in a tooltip on hover or keyboard focus.
  // Used automatically for a column's `tooltip`; can also be used inside render functions.
  function infoTip(text) {
    return `<button class="info-tip" type="button" aria-label="${escapeHtml(text)}" data-tip="${escapeHtml(text)}"><img src="${iconUrl('info.svg')}" alt=""></button>`;
  }

  // One shared tooltip for every .info-tip on the page. It is positioned on the page (not inside the
  // table) so header cells, which clip their content, can't cut it off.
  let tooltipEl = null;
  function showTip(target) {
    if (!tooltipEl) {
      tooltipEl = document.createElement('div');
      tooltipEl.className = 'tpt-tooltip';
      tooltipEl.setAttribute('role', 'tooltip');
      document.body.appendChild(tooltipEl);
    }
    tooltipEl.textContent = target.dataset.tip;
    tooltipEl.classList.add('is-visible');
    const r = target.getBoundingClientRect();
    const t = tooltipEl.getBoundingClientRect();
    const left = Math.min(Math.max(8, r.left + r.width / 2 - t.width / 2), window.innerWidth - t.width - 8);
    const above = r.top - t.height - 10;
    tooltipEl.classList.toggle('is-below', above < 8);
    tooltipEl.style.left = `${left}px`;
    tooltipEl.style.top = `${above < 8 ? r.bottom + 10 : above}px`;
    tooltipEl.style.setProperty('--arrow-x', `${r.left + r.width / 2 - left}px`);
  }
  function hideTip() {
    if (tooltipEl) tooltipEl.classList.remove('is-visible');
  }
  ['mouseover', 'focusin'].forEach(type => document.addEventListener(type, e => {
    const tip = e.target.closest && e.target.closest('.info-tip');
    if (tip) showTip(tip);
  }));
  ['mouseout', 'focusout'].forEach(type => document.addEventListener(type, e => {
    if (e.target.closest && e.target.closest('.info-tip')) hideTip();
  }));
  window.addEventListener('scroll', hideTip, { passive: true });

  // A pill. tone: 'good' (green) | 'bad' (red) | 'info' (blue) | '' (neutral). modifier: extra class for sizing, e.g. 'casing'
  function badge(text, tone, modifier) {
    return `<span class="${['badge', tone, modifier].filter(Boolean).join(' ')}">${escapeHtml(text)}</span>`;
  }

  // ---- The table ----
  function create(container, options = {}) {
    if (!options.columns) throw new Error('ToolsTable.create: pass the column definitions as `columns`');
    checkColumns(options.columns);
    const columns = resolveColumns(options.columns, options.visible);
    const iconBase = options.iconBase || DEFAULT_ICON_BASE;
    const fileName = options.fileName || 'tools-page-table';
    const pageSizes = options.pageSizes || DEFAULT_PAGE_SIZES;
    const icon = name => `${iconBase}${name}`;

    let data = [];
    let rowNumber = new Map(); // row -> its original position (1-based)
    const ctxFor = row => ({ rowNumber: rowNumber.get(row) });
    const cellValue = (c, row) => (c.value ? c.value(row, ctxFor(row)) : row[c.key]);
    const cellHtml = (c, row) => (c.render ? c.render(row, ctxFor(row)) : escapeHtml(cellValue(c, row)));
    const cellClasses = c => [
      c.cellClass,
      c.align === 'center' ? 'col-center' : '',
      c.numeric ? 'col-numeric' : '',
      c.compact ? 'col-compact' : '',
      c === columns[0] ? 'col-first' : '',
      c === columns[columns.length - 1] ? 'col-last' : ''
    ].filter(Boolean).join(' ');

    // ---- Build the card ----
    const sortArrows = `<img class="sort-idle" src="${icon('sort-arrow.svg')}" alt=""><img class="sort-active" src="${icon('sort-arrow-active.svg')}" alt="">`;
    // One header cell per column ("leaf"); data-col links it back to its column for widths and resizing
    const leafCell = (c, i, extra = '') => {
      const classes = [cellClasses(c), c.noWrap ? 'no-wrap' : ''].filter(Boolean).join(' ');
      const label = c.sortable
        ? `<button class="sort-btn" type="button">${escapeHtml(c.label)}${sortArrows}</button>`
        : escapeHtml(c.label);
      // With a tooltip, the label and its (i) icon stay together on one line
      const content = c.tooltip ? `<span class="th-with-tip">${label}${infoTip(c.tooltip)}</span>` : label;
      return `<th class="${classes}" data-col="${i}"${c.sortable ? ` data-sort="${escapeHtml(c.key)}"` : ''}${extra}>${content}</th>`;
    };
    // Column groups: ungrouped columns span both header rows; each group gets one shared cell on the
    // first row with its columns' own headers underneath on the second row.
    // A group left with a single column of the same name (e.g. only "File name") is shown ungrouped.
    const groupOf = columns.map(c => {
      if (!c.group) return null;
      const members = columns.filter(m => m.group === c.group);
      return members.length === 1 && c.label === c.group ? null : c.group;
    });
    const hasGroups = groupOf.some(Boolean);
    let headRows;
    if (!hasGroups) {
      headRows = `<tr>${columns.map((c, i) => leafCell(c, i)).join('')}</tr>`;
    } else {
      let top = '', bottom = '';
      columns.forEach((c, i) => {
        const group = groupOf[i];
        if (!group) { top += leafCell(c, i, ' rowspan="2"'); return; }
        if (i === 0 || groupOf[i - 1] !== group) {
          let span = 1;
          while (groupOf[i + span] === group) span++;
          const last = i + span === columns.length ? ' col-last' : '';
          top += `<th class="th-group${last}" colspan="${span}" scope="colgroup">${escapeHtml(group)}</th>`;
        }
        bottom += leafCell(c, i);
      });
      headRows = `<tr>${top}</tr><tr class="sub-head">${bottom}</tr>`;
    }

    const card = document.createElement('div');
    card.className = 'table-card';
    card.innerHTML = `
      <div class="toolbar">
        <div class="downloads">
          <button class="file-btn download-csv" type="button" aria-label="Download CSV" data-tooltip="Download CSV">
            <img src="${icon('file-csv.svg')}" alt="">
          </button>
          <button class="file-btn download-xlsx" type="button" aria-label="Download XLSX" data-tooltip="Download XLSX">
            <img src="${icon('file-xlsx.svg')}" alt="">
          </button>
        </div>
        <div class="search">
          <img src="${icon('search.svg')}" alt="">
          <input type="search" class="table-search" placeholder="Search..." aria-label="Search table">
        </div>
      </div>
      <div class="table-wrap">
        <table>
          <colgroup>${columns.map(() => '<col>').join('')}</colgroup>
          <thead>${headRows}</thead>
          <tbody></tbody>
        </table>
        <div class="empty">No matching rows.</div>
      </div>
      <div class="table-footer">
        <span class="row-summary"></span>
        <div class="pager">
          <label>
            Show rows
            <select class="page-size">
              ${pageSizes.map(n => `<option value="${n}">${n}</option>`).join('')}
            </select>
          </label>
          <div class="page-nav">
            <button class="icon-btn prev-page" type="button" aria-label="Previous page">
              <img src="${icon('chevron-left.svg')}" alt="">
            </button>
            <span class="page-info"></span>
            <button class="icon-btn next-page" type="button" aria-label="Next page">
              <img src="${icon('chevron-right.svg')}" alt="">
            </button>
          </div>
        </div>
      </div>`;
    container.appendChild(card);

    const $ = selector => card.querySelector(selector);
    const table = $('table');
    const tbody = table.tBodies[0];
    const tableWrap = $('.table-wrap');
    const searchInput = $('.table-search');
    const emptyState = $('.empty');
    const pageSizeSelect = $('.page-size');
    const prevBtn = $('.prev-page');
    const nextBtn = $('.next-page');
    const pageInfo = $('.page-info');
    const rowSummary = $('.row-summary');
    const cols = Array.from(table.querySelectorAll('col'));
    const headers = columns.map((_, i) => table.tHead.querySelector(`th[data-col="${i}"]`)); // one per column
    const allHeaderCells = Array.from(table.tHead.querySelectorAll('th'));                 // includes group cells
    const subHeaderCells = hasGroups ? Array.from(table.tHead.rows[1].cells) : [];
    // Grow columns share the spare width equally (at least one; defaults to the first column)
    const growCols = columns.map((c, i) => (c.grow ? i : -1)).filter(i => i >= 0);
    if (!growCols.length) columns.forEach((c, i) => { if (c.fallbackGrow) growCols.push(i); });
    if (!growCols.length) growCols.push(0);
    // A grow column's minimum is its own minStartWidth, or MIN_GROW_WIDTH
    const minGrow = i => columns[i].minStartWidth || MIN_GROW_WIDTH;
    const shareCols = columns.map((c, i) => (c.startShare ? i : -1)).filter(i => i >= 0);

    const state = { filtered: [], page: 1, pageSize: pageSizes[0], sortKey: null, sortDir: 'asc' };

    // ---- Rendering ----
    function render() {
      const total = state.filtered.length;
      const pageCount = Math.max(1, Math.ceil(total / state.pageSize));
      state.page = Math.min(state.page, pageCount);
      const start = (state.page - 1) * state.pageSize;
      const pageRows = state.filtered.slice(start, start + state.pageSize);

      tbody.innerHTML = pageRows.map((row, r) => {
        const prev = pageRows[r - 1];
        const cells = columns.map(c => {
          // Same value as the row above (on this page of results): leave the cell empty
          const repeat = c.hideRepeats && prev && cellValue(c, prev) === cellValue(c, row);
          return `<td class="${cellClasses(c)}${repeat ? ' cell-repeat' : ''}">${repeat ? '' : cellHtml(c, row)}</td>`;
        }).join('');
        return `<tr>${cells}</tr>`;
      }).join('');

      emptyState.style.display = total ? 'none' : 'block';
      rowSummary.textContent = total
        ? `Showing ${start + 1}–${start + pageRows.length} of ${total}`
        : 'Showing 0 of 0';
      pageInfo.textContent = `Page ${state.page} of ${pageCount}`;
      prevBtn.disabled = state.page <= 1;
      nextBtn.disabled = state.page >= pageCount;
      updateStickyHeader();
    }

    // Applies the current search (shown columns only) and sort to the full data set
    function applyFilterAndSort() {
      const term = searchInput.value.trim().toLowerCase();
      const rows = data.filter(row =>
        columns.some(c => String(cellValue(c, row)).toLowerCase().includes(term))
      );
      if (state.sortKey) {
        const dir = state.sortDir === 'asc' ? 1 : -1;
        rows.sort((a, b) => {
          const x = a[state.sortKey], y = b[state.sortKey];
          const diff = typeof x === 'number' ? x - y : String(x).localeCompare(String(y));
          return diff * dir || rowNumber.get(a) - rowNumber.get(b);
        });
      }
      state.filtered = rows;
    }

    function setData(rows) {
      data = rows.slice();
      rowNumber = new Map(data.map((row, i) => [row, i + 1]));
      applyFilterAndSort();
      state.page = 1;
      render();
    }

    // ---- Search, sorting, paging ----
    searchInput.addEventListener('input', () => {
      applyFilterAndSort();
      state.page = 1;
      render();
    });

    // Sortable headers: first click ascending, then toggles descending/ascending
    const sortHeaders = headers.filter(th => th.dataset.sort);
    sortHeaders.forEach(th => {
      th.querySelector('.sort-btn').addEventListener('click', () => {
        const key = th.dataset.sort;
        state.sortDir = state.sortKey === key && state.sortDir === 'asc' ? 'desc' : 'asc';
        state.sortKey = key;
        sortHeaders.forEach(h => h.removeAttribute('aria-sort'));
        th.setAttribute('aria-sort', state.sortDir === 'asc' ? 'ascending' : 'descending');
        applyFilterAndSort();
        state.page = 1;
        render();
      });
    });

    pageSizeSelect.addEventListener('change', () => {
      state.pageSize = Number(pageSizeSelect.value);
      state.page = 1;
      render();
    });
    prevBtn.addEventListener('click', () => { state.page--; render(); });
    nextBtn.addEventListener('click', () => { state.page++; render(); });

    // ---- Column widths and resizing ----
    const colWidth = i => parseFloat(cols[i].style.width);
    const setColWidth = (i, w) => { cols[i].style.width = w + 'px'; };
    const totalWidth = () => cols.reduce((sum, _, i) => sum + colWidth(i), 0);
    const syncTableWidth = () => {
      table.style.width = totalWidth() + 'px';
      // Second header row sticks just below the first one
      if (hasGroups) {
        const firstRowHeight = table.tHead.rows[0].offsetHeight;
        subHeaderCells.forEach(th => { th.style.top = `calc(var(--table-sticky-top, 0px) + ${firstRowHeight}px)`; });
      }
      // Only scroll sideways when the table is wider than its container (see the sticky header notes)
      tableWrap.classList.toggle('fits', table.offsetWidth <= tableWrap.clientWidth + 1);
      updateStickyHeader();
    };

    // The table must never be narrower than its container (no blank space on the right)
    function fillSpareWidth(fillerIndex) {
      const spare = tableWrap.clientWidth - totalWidth();
      if (spare > 0) setColWidth(fillerIndex, colWidth(fillerIndex) + spare);
      syncTableWidth();
    }

    // Grow or shrink the grow column so the table fills its container, without going below its minimum
    function fitToContainer() {
      const share = (tableWrap.clientWidth - totalWidth()) / growCols.length;
      growCols.forEach(i => setColWidth(i, Math.max(minGrow(i), colWidth(i) + share)));
      syncTableWidth();
    }

    // Short columns start at their narrowest width (a "no-wrap" header counts at its one-line width),
    // startShare columns get their share, and the grow column takes everything left so it is the widest
    function setStartingWidths() {
      table.classList.remove('resizable');
      cols.forEach(col => { col.style.width = ''; });
      table.style.width = 'min-content';
      const natural = headers.map(th => th.getBoundingClientRect().width);
      table.style.width = '';
      natural.forEach((w, i) => setColWidth(i, Math.max(w, columns[i].minStartWidth || 0)));
      shareCols.forEach(i => {
        const c = columns[i];
        setColWidth(i, Math.max(c.minStartWidth || 0, Math.round(tableWrap.clientWidth * c.startShare)));
      });
      // Grow columns split whatever is left equally
      const others = totalWidth() - growCols.reduce((sum, i) => sum + colWidth(i), 0);
      const each = (tableWrap.clientWidth - others) / growCols.length;
      growCols.forEach(i => setColWidth(i, Math.max(minGrow(i), each)));
      // A grow column must never start narrower than a startShare column
      shareCols.forEach(i => {
        growCols.forEach(g => {
          if (colWidth(g) < colWidth(i)) {
            const shared = colWidth(i) + colWidth(g);
            setColWidth(i, Math.round(shared * 0.4));
            setColWidth(g, shared - colWidth(i));
          }
        });
      });
      syncTableWidth();
      table.classList.add('resizable');
    }

    function attachResizeHandles() {
      headers.forEach((th, i) => {
        const handle = document.createElement('span');
        handle.className = 'col-resizer';
        th.appendChild(handle);

        handle.addEventListener('pointerdown', e => {
          e.preventDefault();
          const startX = e.clientX;
          const startWidths = cols.map((_, j) => colWidth(j));
          // When a column shrinks, the column to its right (or left, for the last one) takes up the slack
          const neighbor = i < cols.length - 1 ? i + 1 : i - 1;
          handle.setPointerCapture(e.pointerId);
          handle.classList.add('dragging');
          document.body.classList.add('resizing');

          const onMove = ev => {
            startWidths.forEach((w, j) => setColWidth(j, w));
            setColWidth(i, Math.max(MIN_COL_WIDTH, startWidths[i] + ev.clientX - startX));
            fillSpareWidth(neighbor);
          };
          const onUp = () => {
            handle.classList.remove('dragging');
            document.body.classList.remove('resizing');
            handle.removeEventListener('pointermove', onMove);
            handle.removeEventListener('pointerup', onUp);
            handle.removeEventListener('pointercancel', onUp);
          };
          handle.addEventListener('pointermove', onMove);
          handle.addEventListener('pointerup', onUp);
          handle.addEventListener('pointercancel', onUp);
        });
      });
    }

    function initColumns() {
      setStartingWidths();
      attachResizeHandles();
      // Refit whenever the table's container changes width (window resize, sidebar opened or closed)
      new ResizeObserver(fitToContainer).observe(tableWrap);
    }

    // ---- Export: every row matching the search, across all pages, shown columns only ----
    function getTableData() {
      const header = columns.map((c, i) => (groupOf[i] ? `${groupOf[i]}: ${c.label}` : c.label));
      const body = state.filtered.map(row => columns.map(c => cellValue(c, row)));
      return [header, ...body];
    }

    $('.download-csv').addEventListener('click', () => {
      const csv = getTableData()
        .map(row => row.map(v => '"' + String(v).replace(/"/g, '""') + '"').join(','))
        .join('\r\n');
      const blob = new Blob(['﻿' + csv], { type: 'text/csv;charset=utf-8;' });
      const link = document.createElement('a');
      link.href = URL.createObjectURL(blob);
      link.download = `${fileName}.csv`;
      link.click();
      URL.revokeObjectURL(link.href);
    });

    $('.download-xlsx').addEventListener('click', () => {
      if (typeof XLSX === 'undefined') {
        alert('XLSX library failed to load. Check assets/js/vendor/xlsx.full.min.js is present.');
        return;
      }
      const sheet = XLSX.utils.aoa_to_sheet(getTableData());
      const book = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(book, sheet, 'Results');
      XLSX.writeFile(book, `${fileName}.xlsx`);
    });

    // ---- Sticky header ----
    // Normally CSS position: sticky pins the header (smooth, handled by the browser).
    // Only when the table is wider than its container (it then scrolls sideways, which blocks CSS sticky)
    // does this script move the header itself as a fallback. It also adds the shadow while the header is pinned.
    function updateStickyHeader() {
      const stickyTop = parseFloat(getComputedStyle(headers[0]).top) || 0;
      const tableTop = table.getBoundingClientRect().top - stickyTop;
      const headHeight = table.tHead.offsetHeight;
      const lastRowHeight = tbody.rows.length ? tbody.rows[tbody.rows.length - 1].offsetHeight : 0;
      // Stop before the header would cover the last row
      const maxOffset = Math.max(0, table.offsetHeight - headHeight - lastRowHeight);
      const offset = Math.min(Math.max(0, -tableTop), maxOffset);
      const useFallback = !tableWrap.classList.contains('fits');
      table.classList.toggle('header-stuck', offset > 0);
      allHeaderCells.forEach(th => { th.style.transform = useFallback && offset ? `translateY(${offset}px)` : ''; });
    }

    let stickyFrame = 0;
    const scheduleStickyHeader = () => {
      if (!stickyFrame) stickyFrame = requestAnimationFrame(() => { stickyFrame = 0; updateStickyHeader(); });
    };
    window.addEventListener('scroll', scheduleStickyHeader, { passive: true });
    window.addEventListener('resize', scheduleStickyHeader);

    // ---- Start ----
    setData(options.data || []);
    // Measure columns only after the page has fully laid out
    if (document.readyState === 'complete') initColumns();
    else window.addEventListener('load', initColumns);

    return {
      element: card,
      columns,
      // Replace the rows (e.g. when results arrive from the server); column widths are re-measured
      setData(rows) {
        setData(rows);
        if (table.classList.contains('resizable')) setStartingWidths();
      }
    };
  }

  window.ToolsTable = { create, resolveColumns, optionalKeys, hiddenKeys, combinations, badge, iconLink, iconUrl, infoTip, escapeHtml };
})();
