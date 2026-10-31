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
