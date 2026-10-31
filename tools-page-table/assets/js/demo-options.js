// Demo pages only (not for Webqa): renders one table per option of a tool's optional columns.
// Option 1 (the first option, all settings chosen) goes in #main-option with every dummy row;
// the remaining options go in #other-options with just the first few rows, to keep the page short.
// Loads after tools-page-table.js.
(function () {
  'use strict';

  const OTHER_OPTIONS_ROWS = 10; // rows shown in every option except Option 1

  // Warn during development if an option is missing for any combination of optional columns
  function checkAllCombinationsCovered(toolName, columns, options) {
    const covered = new Set(options.map(o => o.visible.slice().sort().join(',')));
    ToolsTable.combinations(ToolsTable.optionalKeys(columns)).forEach(combo => {
      if (!covered.has(combo.slice().sort().join(','))) console.warn(`${toolName}: no option for columns`, combo);
    });
  }

  function buildOptionSection(option, { columns, rows, fileName }) {
    // Grouped columns are listed with their group, e.g. "File name: Length"
    const shown = ToolsTable.resolveColumns(columns, option.visible)
      .map(c => (c.group && c.group !== c.label ? `${c.group}: ${c.label}` : c.label));
    const section = document.createElement('section');
    section.className = 'option-block';
    section.innerHTML = `
      <h3 class="option-title"></h3>
      <p class="option-columns"></p>
      <h3 class="card-title">Test Results</h3>`;
    section.querySelector('.option-title').textContent = option.title;
    section.querySelector('.option-columns').textContent = `Columns: ${shown.join(', ')}`;
    ToolsTable.create(section, { columns, visible: option.visible, data: rows, fileName });
    return section;
  }

  // toolName: for console warnings; columns: the tool's column definitions;
  // options: [{ title, visible }], Option 1 first; data: all dummy rows
  // checkCoverage: false skips the "every combination has an option" warning (when only a selection is shown)
  function render({ toolName, columns, options, data, fileName, checkCoverage = true }) {
    if (checkCoverage) checkAllCombinationsCovered(toolName, columns, options);
    const [mainOption, ...otherOptions] = options;
    document.getElementById('main-option')
      .appendChild(buildOptionSection(mainOption, { columns, rows: data, fileName }));
    const otherContainer = document.getElementById('other-options');
    const fewRows = data.slice(0, OTHER_OPTIONS_ROWS);
    otherOptions.forEach(option => {
      otherContainer.appendChild(buildOptionSection(option, { columns, rows: fewRows, fileName }));
    });
  }

  window.DemoOptions = { render };
})();
