
class ToolXlsx {
    static async buildXLSX(xlsxName) {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet("Sheet1");

        // Clone the table to work with
        let table;

        if ($(".test_result_area table").length) {
        table = $(".test_result_area table").clone()[0];
        } else {
        table = $("#reportTable").clone()[0];
        $(table).find(".dropdown-toggle-tracker-circle").remove();
        $(table).find(".dropdown-menu").remove();
        $(table).find(".dropdown-toggle").remove();
        }

        $(table).find(".export-hidden-element").remove();
        console.log(table)
        // Add rows and apply styles
        ToolXlsx.addTableToSheet(table, worksheet);

        // Dynamically adjust column widths
        ToolXlsx.setColumnWidths(table, worksheet);

        // Download the file
        const buffer = await workbook.xlsx.writeBuffer();
        const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
        const url = window.URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = xlsxName;
        a.click();

        setTimeout(() => URL.revokeObjectURL(url), 500);
    }

    static addTableToSheet(table, worksheet) {
        const rows = table.rows;
        const mergeMap = {}; // Store merge references
    
        for (let rowIndex = 0; rowIndex < rows.length; rowIndex++) {
            const row = rows[rowIndex];
            const excelRow = worksheet.addRow([]);
            let excelColIndex = 1; // Track the Excel column index
    
            for (let colIndex = 0; colIndex < row.cells.length; colIndex++) {
                const cell = row.cells[colIndex];
    
                // Skip cells that are already part of a merged range
                while (mergeMap[`${rowIndex},${excelColIndex}`]) {
                    excelColIndex++;
                }
    
                const excelCell = excelRow.getCell(excelColIndex);
                const cellContent = cell.hasAttribute("td-replace")
                    ? cell.getAttribute("td-replace").trim()
                    : cell.textContent.trim();
    
                // Check for colspan
                const colspan = parseInt(cell.getAttribute("colspan") || "1", 10);
                if (colspan > 1) {
                    const startCol = excelColIndex;
                    const endCol = excelColIndex + colspan - 1;
    
                    // Merge the columns in Excel
                    worksheet.mergeCells(rowIndex + 1, startCol, rowIndex + 1, endCol);
    
                    // Mark merged cells in mergeMap
                    for (let i = startCol + 1; i <= endCol; i++) {
                        mergeMap[`${rowIndex},${i}`] = true;
                    }
    
                    // Apply styles for merged cell
                    excelCell.alignment = { horizontal: "center", vertical: "middle" };
                }
    
                // Set the cell value
                excelCell.value = cellContent;
    
                // Apply text wrapping
                excelCell.alignment = { wrapText: true, vertical: "middle" };
    
                // Apply borders
                excelCell.border = {
                    left: { style: "dotted", color: { argb: "FFB0B0B0" } },
                    right: { style: "dotted", color: { argb: "FFB0B0B0" } },
                };
    
                // Apply styles based on tag or class
                if (cell.tagName.toLowerCase() === "th") {
                    excelCell.font = { color: { argb: "FFFFFFFF" }, bold: true, size: 12 };
                    excelCell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "37a1e4" } }; // Blue background
                    excelCell.alignment = { horizontal: "center", vertical: "middle" };
                } else {
                    const cellClass = cell.className;
    
                    if (cellClass.includes("result_pass")) {
                        excelCell.font = { color: { argb: "000000" } };
                        excelCell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "d9ead3" } }; // Green background
                        excelCell.alignment = { horizontal: "center", vertical: "middle" };
    
                    } else if (cellClass.includes("result_fail")) {
                        excelCell.font = { color: { argb: "000000" } };
                        excelCell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "f4cccc" } }; // Red background
                        excelCell.alignment = { horizontal: "center", vertical: "middle" };
    
                    } else if (cellClass.includes("highlight")) {
                        excelCell.font = { bold: true };
                        excelCell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "FFFFFF00" } }; // Yellow background
                    }

                    // 💡 Add center alignment if 'text-center' class is present
                    if (cellClass.includes("text-center")) {
                        excelCell.alignment = { ...excelCell.alignment, horizontal: "center" };
                    }
    
                    if (cellClass.includes("strong")) {
                        excelCell.font = { ...excelCell.font, bold: true };
                    }
                }
    
                // Move to the next column, considering colspan
                excelColIndex += colspan;
            }
    
            // Apply alternating row background color
           
            // Apply alternating row background color, ignoring <th> cells
            if (rowIndex % 2 !== 0) {
                excelRow.eachCell((cell, colNumber) => {
                    const htmlCell = row.cells[colNumber - 1]; // Get the corresponding HTML cell
                    if (
                        !mergeMap[`${rowIndex},${colNumber}`] &&
                        htmlCell &&
                        htmlCell.tagName.toLowerCase() !== "th" &&
                        !htmlCell.classList.contains("result_pass") && // Skip if cell has result_pass
                        !htmlCell.classList.contains("result_fail") // Skip if cell has result_fail
                    ) {
                        cell.fill = {
                            type: "pattern",
                            pattern: "solid",
                            fgColor: { argb: "FFefefef" }, // Light grey
                        };
                    }
                });
            }

        }
    }
    
    

    static setColumnWidths(table, worksheet) {
        const rows = table.rows;
        const colWidths = [];
    
        // Calculate maximum content length for each column
        for (let rowIndex = 0; rowIndex < rows.length; rowIndex++) {
            const row = rows[rowIndex];
    
            for (let colIndex = 0; colIndex < row.cells.length; colIndex++) {
                const cell = row.cells[colIndex];
                const cellTextLength = cell.textContent.trim().length;
    
                // Check if the cell has the 'content-td' class
                if (cell.classList.contains("content-td")) {
                    colWidths[colIndex] = 50; // Set width to 50 for content-td
                } else {
                    // Determine the max length for other cells
                    colWidths[colIndex] = Math.max(colWidths[colIndex] || 0, cellTextLength);
                }
            }
        }
    
        // Adjust the width dynamically and set it to the worksheet
        worksheet.columns = colWidths.map((width) => ({
            width: Math.max(10, width + 2), // Minimum width of 10 for non-content-td columns
        }));
    }
    
}
