$(document).on("click", ".download-pdf-btn", function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    let projectUrl = document.querySelector(".project-url")?.getAttribute("href") || "N/A";
    let currentDate = new Date();
    let formattedDate = currentDate.toLocaleDateString("en-GB");
    let formattedTime = currentDate.toLocaleTimeString("en-GB");

    let titleElement = document.querySelector('.analysis-card[data-name="title"]');
    let descriptionElement = document.querySelector('.analysis-card[data-name="description"]');
    let imgElement = document.querySelector('.analysis-card[data-name="img"]');
    let canonicalElement = document.querySelector('.analysis-card[data-name="canonical"]');

    let y = 10;

    doc.setFont("helvetica", "bold");
    doc.setFontSize(14);
    doc.text("Analysis Report", 10, y);
    y += 10;

    doc.setFont("helvetica", "normal");
    doc.setFontSize(12);
    doc.text(`URL: ${projectUrl}`, 10, y);
    y += 10;
    doc.text(`Date: ${formattedDate}, ${formattedTime}`, 10, y);
    y += 10;

    doc.line(10, y, 200, y);
    y += 10;

    function drawSection(title, content, length, casing, result, yPosition, showCasing = true) {
        const x = 10;
        const width = 190;
        let height = showCasing ? 50 : 44;
    
        // Light Gray Background
        doc.setFillColor(240, 240, 240);
        doc.rect(x, yPosition, width, height, "F");
    
        // Black Border
        doc.setDrawColor(0);
        doc.setLineWidth(0.5);
        doc.rect(x, yPosition, width, height);
    
        let textY = yPosition + 8;
    
        // Title
        doc.setFont("helvetica", "bold");
        doc.setFontSize(12);
        doc.text(title, x + 5, textY);
        textY += 6;
    
        // Content
        doc.setFont("helvetica", "normal");
        let splitContent = doc.splitTextToSize(content, width - 10);
        doc.text(splitContent, x + 5, textY);
        textY += splitContent.length * 5 + 6;
    
        // Length
        doc.setFont("helvetica", "bold");
        doc.text("Length:", x + 5, textY);
        doc.setFont("helvetica", "normal");
        doc.text(length, x + 30, textY);
        textY += 6;
    
        // Casing (Only if enabled)
        if (showCasing) {
            doc.setFont("helvetica", "bold");
            doc.text("Casing:", x + 5, textY);
            doc.setFont("helvetica", "normal");
            doc.text(casing, x + 30, textY);
            textY += 6;
        }
    
        // Result with Color (Pass = Green, Fail = Red)
        doc.setFont("helvetica", "bold");
        doc.text("Result:", x + 5, textY);
        if (result.toLowerCase() === "pass") {
            doc.setTextColor(0, 128, 0); // Green
        } else if (result.toLowerCase() === "fail") {
            doc.setTextColor(255, 0, 0); // Red
        } else {
            doc.setTextColor(0, 0, 0); // Default Black
        }
        doc.setFont("helvetica", "normal");
        doc.text(result, x + 30, textY);
        doc.setTextColor(0, 0, 0); // Reset to Black
    }
    

    if (titleElement) {
        let titleContent = titleElement.querySelector(".card-inner-content p")?.innerText || "N/A";
        let titleLength = titleElement.querySelector(".badge_pdf")?.innerText || "N/A";
        let titleCasing = titleElement.querySelector(".casing_pdf")?.innerText || "N/A";
        let titleStatus = titleElement.querySelector(".status_pdf")?.innerText || "N/A";

        drawSection("Meta Title", titleContent, titleLength, titleCasing, titleStatus, y);
        y += 60;
    }

    if (descriptionElement) {
        let descContent = descriptionElement.querySelector(".card-inner-content p")?.innerText || "N/A";
        let descLength = descriptionElement.querySelector(".badge_pdf")?.innerText || "N/A";
        let descStatus = descriptionElement.querySelector(".status_pdf")?.innerText || "N/A";

        if (descLength === "N/A") {
            descContent = "Meta description does not exist.";
        }

        drawSection("Meta Description", descContent, descLength, "", descStatus, y, false);
        y += 55;
    }

    // Canonical Section - Show Both Actual URL & Canonical URL
    if (canonicalElement) {
        let actualUrlText = "Actual URL:";
        let canonicalUrlText = "Canonical URL:";
        let actualUrl = canonicalElement.querySelector(".card-actual-url p:nth-of-type(1)")?.innerText.replace("Actual URL", "").trim() || "N/A";
        let canonicalUrl = canonicalElement.querySelector(".card-actual-url p:nth-of-type(2)")?.innerText.replace("Canonical URL", "").trim() || "N/A";
        let canonicalStatus = canonicalElement.querySelector(".status_pdf")?.innerText || "N/A";
    
        // Check if Canonical URL is "-"
        if (canonicalUrl === "-") {
            canonicalUrl = "Canonical URL Tag does not exist";
        }
    
        const x = 10;
        const width = 190;
        const height = 40;
    
        // Light Gray Background
        doc.setFillColor(240, 240, 240);
        doc.rect(x, y, width, height, "F");
    
        // Black Border
        doc.setDrawColor(0);
        doc.setLineWidth(0.5);
        doc.rect(x, y, width, height);
    
        let textY = y + 8;
    
        // Title
        doc.setFont("helvetica", "bold");
        doc.setFontSize(12);
        doc.text("Canonical URL", x + 5, textY);
        textY += 6;
    
        // Actual URL
        doc.setFont("helvetica", "bold");
        doc.text(actualUrlText, x + 5, textY);
        doc.setFont("helvetica", "normal");
        doc.text(actualUrl, x + 40, textY); // Align URLs properly
        textY += 6;
    
        // Canonical URL
        doc.setFont("helvetica", "bold");
        doc.text(canonicalUrlText, x + 5, textY);
        doc.setFont("helvetica", "normal");
        doc.text(canonicalUrl, x + 40, textY);
        textY += 6;
    
        // Result
        doc.setFont("helvetica", "bold");
        doc.text("Result:", x + 5, textY);
        if (canonicalStatus.toLowerCase() === "pass") {
            doc.setTextColor(0, 128, 0); // Green
        } else if (canonicalStatus.toLowerCase() === "fail") {
            doc.setTextColor(255, 0, 0); // Red
        } else {
            doc.setTextColor(0, 0, 0); // Default Black
        }
        doc.setFont("helvetica", "normal");
        doc.text(canonicalStatus, x + 40, textY);
        doc.setTextColor(0, 0, 0); // Reset to Black
    
        y += 50;
    }
    
    
    y = addTableToPDF(doc, y);
    if (imgElement) {
   
        y = addRobotsMetaToPDF(doc, y);
    }
    doc.save("Analysis_Report.pdf");
});


function addRobotsMetaToPDF(doc, y) {
    // Check if the Robots Meta section exists
    let robotsElement = document.querySelector('.analysis-card[data-name="robots"]');
    if (!robotsElement) {
        return y; // If not found, return y unchanged
    }

    // Extract relevant content
    let robotsContent = robotsElement.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    let robotsStatus = robotsElement.querySelector(".status_pdf")?.innerText || "N/A";

    const x = 10;
    const width = 190;
    const height = 30;

    // Light Gray Background
    doc.setFillColor(240, 240, 240);
    doc.rect(x, y, width, height, "F");

    // Black Border
    doc.setDrawColor(0);
    doc.setLineWidth(0.5);
    doc.rect(x, y, width, height);

    let textY = y + 8;

    // Title
    doc.setFont("helvetica", "bold");
    doc.setFontSize(12);
    doc.text("Robots Meta", x + 5, textY);
    textY += 6;

    // Content
    doc.setFont("helvetica", "bold");
    doc.text("Robots Meta Content:", x + 5, textY);
    doc.setFont("helvetica", "normal");
    doc.text(robotsContent, x + 50, textY);
    textY += 6;

    // Result with Color (Pass = Green, Fail = Red)
    doc.setFont("helvetica", "bold");
    doc.text("Result:", x + 5, textY);
    if (robotsStatus.toLowerCase() === "pass") {
        doc.setTextColor(0, 128, 0); // Green
    } else if (robotsStatus.toLowerCase() === "fail") {
        doc.setTextColor(255, 0, 0); // Red
    } else {
        doc.setTextColor(0, 0, 0); // Default Black
    }
    doc.setFont("helvetica", "normal");
    doc.text(robotsStatus, x + 50, textY);
    doc.setTextColor(0, 0, 0); // Reset to Black

    return y + 40; // Move down for the next section and return updated y
}
function addTableToPDF(doc, y) {
    const tableElement = document.querySelector(".custom-dataTable");
    if (!tableElement) {
        doc.text("Image Data Table: No table found!", 10, y);
        return y + 10;
    }

    // Define headers manually
    const tableHeaders = ["#", "Image Link", "Alternate Text", "File Size", "File Name", "Status", "Issues"];
    const expectedColumnCount = tableHeaders.length;
    const tableData = [];

    const tableRows = tableElement.querySelectorAll("tbody tr");

    tableRows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll("td");

        for (let index = 0; index < expectedColumnCount; index++) {
            const td = cells[index];

            if (!td) {
                rowData.push(""); // pad if not enough cells
                continue;
            }

            if (index === 1) {
                const linkElement = td.querySelector("a");
                if (linkElement && linkElement.href) {
                    rowData.push({ text: "View Image", url: linkElement.href });
                } else {
                    rowData.push("");
                }
            } else {
                rowData.push(td.textContent.trim());
            }
        }

        tableData.push(rowData);
    });


console.log("PDF Table Headers:", tableHeaders);
console.log("PDF Table Rows:", tableData);
    doc.autoTable({
        startY: y + 10,
        head: [tableHeaders],
        body: tableData.map(row =>
            row.map(cell => (typeof cell === "object" ? "" : cell)) // only show plain text
        ),
        theme: "grid",
        styles: {
            fontSize: 10,
            cellPadding: 3,
            valign: "middle",
            halign: "center"
        },
        headStyles: {
            fillColor: [0, 102, 204],
            textColor: 255,
            fontStyle: 'bold'
        },
        didDrawCell: function (data) {
            const cellData = tableData[data.row.index]?.[data.column.index];
            if (data.column.index === 1 && typeof cellData === "object" && cellData.url && data.cell.raw != 'Image Link') {
                console.log(data.cell.raw)
                const { x, y } = data.cell;
                doc.setTextColor(0, 0, 255);
                doc.textWithLink(cellData.text, x + 4, y + 5, { url: cellData.url });
                doc.setTextColor(0, 0, 0);
            }
        }
    });

    return doc.lastAutoTable.finalY + 10;
}
