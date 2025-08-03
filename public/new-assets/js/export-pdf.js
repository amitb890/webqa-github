$(document).on("click", ".download-pdf-btn", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const projectUrl = document.querySelector(".project-url")?.getAttribute("href") || "N/A";
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleDateString("en-GB");
    const formattedTime = currentDate.toLocaleTimeString("en-GB");

    let y = 10;

    y = renderHeaderSection(doc, projectUrl, formattedDate, formattedTime, y);
    y = checkPageBreak(doc, y, 60);

    y = renderMetaTitle(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = renderMetaDescription(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = renderCanonicalURL(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = addTableToPDF(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = renderRobotsMeta(doc, y);
    y = checkPageBreak(doc, y, 60);

    
    y = renderPerformanceHeaderSection(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = renderPerformanceSection(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = renderLighthouseScoreTable(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = renderCoreWebVitalsTable(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = renderBestPracticesTable(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = renderSecurityTable(doc, y);
    y = checkPageBreak(doc, y, 60);

    // Add new sections here in future
    // y = renderNewTestSection(doc, y);

    doc.save("Analysis_Report.pdf");
    
});

/* ---------- Common Drawing Function ---------- */
function drawSection(doc, title, content, length, casing, result, yPosition, showCasing = true) {
    const x = 10, width = 190, height = showCasing ? 50 : 44;
    doc.setFillColor(240, 240, 240);
    doc.rect(x, yPosition, width, height, "F");
    doc.setDrawColor(0).setLineWidth(0.5).rect(x, yPosition, width, height);

    let textY = yPosition + 8;
    doc.setFont("helvetica", "bold").setFontSize(12).text(title, x + 5, textY);
    textY += 6;

    doc.setFont("helvetica", "normal");
    const splitContent = doc.splitTextToSize(content, width - 10);
    doc.text(splitContent, x + 5, textY);
    textY += splitContent.length * 5 + 6;

    doc.setFont("helvetica", "bold").text("Length:", x + 5, textY);
    doc.setFont("helvetica", "normal").text(length, x + 30, textY);
    textY += 6;

    if (showCasing) {
        doc.setFont("helvetica", "bold").text("Casing:", x + 5, textY);
        doc.setFont("helvetica", "normal").text(casing, x + 30, textY);
        textY += 6;
    }

    doc.setFont("helvetica", "bold").text("Result:", x + 5, textY);
    const resultLower = result.toLowerCase();
    doc.setTextColor(resultLower === "pass" ? 0x00 : resultLower === "fail" ? 255 : 0,
                     resultLower === "pass" ? 128 : resultLower === "fail" ? 0 : 0,
                     resultLower === "pass" || resultLower === "fail" ? 0 : 0);
    doc.setFont("helvetica", "normal").text(result, x + 30, textY);
    doc.setTextColor(0, 0, 0);
}

/* ---------- Header ---------- */
function renderHeaderSection(doc, url, date, time, y) {
    doc.setFont("helvetica", "bold").setFontSize(14).text("Analysis Report", 10, y);
    y += 10;

    doc.setFont("helvetica", "normal").setFontSize(12);
    doc.text(`URL: ${url}`, 10, y); y += 10;
    doc.text(`Date: ${date}, ${time}`, 10, y); y += 10;
    doc.line(10, y, 200, y); y += 10;
    return y;
}

/* ---------- Meta Title ---------- */
function renderMetaTitle(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="title"]');
    if (!el) return y;

    const content = el.querySelector(".card-inner-content p")?.innerText || "N/A";
    const length = el.querySelector(".badge_pdf")?.innerText || "N/A";
    const casing = el.querySelector(".casing_pdf")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";

    drawSection(doc, "Meta Title", content, length, casing, status, y);
    return y + 60;
}

/* ---------- Meta Description ---------- */
function renderMetaDescription(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="description"]');
    if (!el) return y;

    let content = el.querySelector(".card-inner-content p")?.innerText || "N/A";
    const length = el.querySelector(".badge_pdf")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";

    if (length === "N/A") content = "Meta description does not exist.";

    drawSection(doc, "Meta Description", content, length, "", status, y, false);
    return y + 55;
}

/* ---------- Canonical URL ---------- */
function renderCanonicalURL(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="canonical"]');
    if (!el) return y;

    const actualUrl = el.querySelector(".card-actual-url p:nth-of-type(1)")?.innerText.replace("Actual URL", "").trim() || "N/A";
    let canonicalUrl = el.querySelector(".card-actual-url p:nth-of-type(2)")?.innerText.replace("Canonical URL", "").trim() || "N/A";
    if (canonicalUrl === "-") canonicalUrl = "Canonical URL Tag does not exist";

    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    const x = 10, width = 190, height = 40;

    doc.setFillColor(240, 240, 240);
    doc.rect(x, y, width, height, "F").setDrawColor(0).setLineWidth(0.5).rect(x, y, width, height);

    let textY = y + 8;
    doc.setFont("helvetica", "bold").setFontSize(12).text("Canonical URL", x + 5, textY);
    textY += 6;

    doc.setFont("helvetica", "bold").text("Actual URL:", x + 5, textY);
    doc.setFont("helvetica", "normal").text(actualUrl, x + 40, textY);
    textY += 6;

    doc.setFont("helvetica", "bold").text("Canonical URL:", x + 5, textY);
    doc.setFont("helvetica", "normal").text(canonicalUrl, x + 40, textY);
    textY += 6;

    doc.setFont("helvetica", "bold").text("Result:", x + 5, textY);
    const resultLower = status.toLowerCase();
    doc.setTextColor(resultLower === "pass" ? 0x00 : resultLower === "fail" ? 255 : 0,
                     resultLower === "pass" ? 128 : resultLower === "fail" ? 0 : 0,
                     resultLower === "pass" || resultLower === "fail" ? 0 : 0);
    doc.setFont("helvetica", "normal").text(status, x + 40, textY);
    doc.setTextColor(0, 0, 0);
    return y + 50;
}

/* ---------- Robots Meta ---------- */
function renderRobotsMeta(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="robots"]');
    if (!el) return y;

    const content = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    const x = 10, width = 190, height = 30;

    doc.setFillColor(240, 240, 240);
    doc.rect(x, y, width, height, "F").setDrawColor(0).setLineWidth(0.5).rect(x, y, width, height);

    let textY = y + 8;
    doc.setFont("helvetica", "bold").setFontSize(12).text("Robots Meta", x + 5, textY);
    textY += 6;

    doc.setFont("helvetica", "bold").text("Robots Meta Content:", x + 5, textY);
    doc.setFont("helvetica", "normal").text(content, x + 50, textY);
    textY += 6;

    doc.setFont("helvetica", "bold").text("Result:", x + 5, textY);
    const resultLower = status.toLowerCase();
    doc.setTextColor(resultLower === "pass" ? 0x00 : resultLower === "fail" ? 255 : 0,
                     resultLower === "pass" ? 128 : resultLower === "fail" ? 0 : 0,
                     resultLower === "pass" || resultLower === "fail" ? 0 : 0);
    doc.setFont("helvetica", "normal").text(status, x + 50, textY);
    doc.setTextColor(0, 0, 0);

    return y + 40;
}

/* ---------- Image Table ---------- */
function addTableToPDF(doc, y) {
    const tableElement = document.querySelector(".custom-dataTable");
    if (!tableElement) {
        doc.text("Image Data Table: No table found!", 10, y);
        return y + 10;
    }

    const headers = ["#", "Image Link", "Alternate Text", "File Size", "File Name", "Status", "Issues"];
    const tableRows = tableElement.querySelectorAll("tbody tr");

    const data = Array.from(tableRows).map(row => {
        const cells = row.querySelectorAll("td");
        return headers.map((_, i) => {
            const td = cells[i];
            if (!td) return "";
            if (i === 1) {
                const a = td.querySelector("a");
                return a?.href ? { text: "View Image", url: a.href } : "";
            }
            return td.textContent.trim();
        });
    });

    doc.autoTable({
        startY: y + 10,
        head: [headers],
        body: data.map(row => row.map(cell => typeof cell === "object" ? "" : cell)),
        theme: "grid",
        styles: { fontSize: 10, cellPadding: 3, valign: "middle", halign: "center" },
        headStyles: { fillColor: [0, 102, 204], textColor: 255, fontStyle: 'bold' },
        didDrawCell(data) {
            const cellData = data.row.raw[data.column.index];
            if (data.column.index === 1 && typeof cellData === "object" && cellData.url) {
                doc.setTextColor(0, 0, 255);
                doc.textWithLink(cellData.text, data.cell.x + 4, data.cell.y + 5, { url: cellData.url });
                doc.setTextColor(0, 0, 0);
            }
        }
    });

    return doc.lastAutoTable.finalY + 10;
}
/* ---------- Header ---------- */
function renderPerformanceHeaderSection(doc, y) {
    // Title: Performance
    const x = 10;
    doc.setFont("helvetica", "bold");
    doc.setFontSize(12);
    doc.text("Performance", x, y);
    y += 8;
    return y;
}
function renderPerformanceSection(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="google_overall"]');
    if (!el) return y;
    const desktopScore = parseInt(document.querySelector(".overallDesktop")?.textContent || "N/A");
    const mobileScore = parseInt(document.querySelector(".overallMobile")?.textContent || "N/A");

    const x = 10;
    const width = 190;
    const rowHeight = 10;
    const cellWidth = width / 2;

    
    doc.setFont("helvetica", "normal");
    doc.text("Google Page speed overall score", x, y);
    y += 6;

    // Header Row
    doc.setFillColor(0, 102, 204);
    doc.setTextColor(255, 255, 255);
    doc.rect(x, y, cellWidth, rowHeight, "F");
    doc.rect(x + cellWidth, y, cellWidth, rowHeight, "F");

    doc.setFont("helvetica", "bold");
    doc.text("Desktop", x + 5, y + 7);
    doc.text("Mobile", x + cellWidth + 5, y + 7);
    y += rowHeight;

    // Score Row Background
    doc.setTextColor(0, 0, 0);
    doc.rect(x, y, cellWidth, rowHeight);
    doc.rect(x + cellWidth, y, cellWidth, rowHeight);

    // Set font color based on score
    const getColor = (score) => {
        if (isNaN(score)) return [0, 0, 0]; // default black
        if (score >= 90) return [0, 128, 0]; // green
        if (score >= 50) return [255, 165, 0]; // orange
        return [255, 0, 0]; // red
    };

    // Desktop Score
    let [r1, g1, b1] = getColor(desktopScore);
    doc.setTextColor(r1, g1, b1);
    doc.setFont("helvetica", "normal");
    doc.text(!isNaN(desktopScore) ? desktopScore.toString() : "N/A", x + 5, y + 7);

    // Mobile Score
    let [r2, g2, b2] = getColor(mobileScore);
    doc.setTextColor(r2, g2, b2);
    doc.text(!isNaN(mobileScore) ? mobileScore.toString() : "N/A", x + cellWidth + 5, y + 7);

    // Reset text color
    doc.setTextColor(0, 0, 0);

    return y + rowHeight + 10;
}



function renderLighthouseScoreTable(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="google_lighthouse"]');
    if (!el) return y;
    const x = 10;
    const width = 190;
    const rowHeight = 10;
    const columnCount = 5;
    const cellWidth = width / columnCount;

    const performanceDesktop = parseInt(document.querySelector(".performanceDesktop")?.textContent || "N/A");
    const accessibilityDesktop = parseInt(document.querySelector(".accessibilityDesktop")?.textContent || "N/A");
    const bestPracticesDesktop = parseInt(document.querySelector(".bestPracticesDesktop")?.textContent || "N/A");
    const seoDesktop = parseInt(document.querySelector(".seoDesktop")?.textContent || "N/A");

    const performanceMobile = parseInt(document.querySelector(".performanceMobile")?.textContent || "N/A");
    const accessibilityMobile = parseInt(document.querySelector(".accessibilityMobile")?.textContent || "N/A");
    const bestPracticesMobile = parseInt(document.querySelector(".bestPracticesMobile")?.textContent || "N/A");
    const seoMobile = parseInt(document.querySelector(".seoMobile")?.textContent || "N/A");

    // Data Rows
    const desktopScores = ['Desktop', performanceDesktop, accessibilityDesktop, seoDesktop, bestPracticesDesktop];
    const mobileScores = ['Mobile', performanceMobile, accessibilityMobile, seoMobile, bestPracticesMobile];

   

    doc.setFont("helvetica", "normal");
    doc.text("Lighthouse Score", x, y);
    y += 6;

    // Header Row
    doc.setFillColor(0, 102, 204);
    doc.setTextColor(255, 255, 255);
    for (let i = 0; i < columnCount; i++) {
        doc.rect(x + i * cellWidth, y, cellWidth, rowHeight, "F");
    }

    doc.setFont("helvetica", "bold");
    const headers = ["", "Performance","Accessibility", "SEO", "Best Practices"];
    headers.forEach((header, i) => {
        doc.text(header, x + i * cellWidth + 5, y + 7);
    });

    y += rowHeight;

    // Helper to draw a data row with center-aligned text
const drawDataRow = (scores) => {
    scores.forEach((score, i) => {
        const [r, g, b] = getColor(score);
        doc.setTextColor(r, g, b);
        doc.rect(x + i * cellWidth, y, cellWidth, rowHeight);

        doc.setFont("helvetica", "normal");
        const scoreStr = score.toString();
        const textWidth = doc.getTextWidth(scoreStr);
        const textX = x + i * cellWidth + (cellWidth - textWidth) / 2;
        const textY = y + rowHeight / 2 + 3; // Rough vertical center

        doc.text(scoreStr, textX, textY);
    });
    y += rowHeight;
    return y;
};


    // Draw two rows: Desktop, Mobile
    y = drawDataRow(desktopScores);
    y = drawDataRow(mobileScores);

    // Reset text color
    doc.setTextColor(0, 0, 0);

    return y + 10;

    function getColor(score) {
        if (isNaN(score)) return [0, 0, 0];
        if (score >= 90) return [0, 128, 0]; // green
        if (score >= 50) return [255, 165, 0]; // orange
        return [255, 0, 0]; // red
    }
}

function renderCoreWebVitalsTable(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="core_web_vitals"]');
    if (!el) return y;
    const x = 10;
    const width = 190;
    const rowHeight = 12;
    const columnCount = 3;
    const cellWidth = width / columnCount;


    // Desktop values
    const fcpDesktop = formatTimeUnit(document.querySelector(".fcpDesktop")?.textContent || "N/A");
    const ttiDesktop = formatTimeUnit(document.querySelector(".ttiDesktop")?.textContent || "N/A");
    const siDesktop  = formatTimeUnit(document.querySelector(".siDesktop")?.textContent || "N/A");
    const tbtDesktop = formatTimeUnit(document.querySelector(".tbtDesktop")?.textContent || "N/A");
    const lcpDesktop = formatTimeUnit(document.querySelector(".lcpDesktop")?.textContent || "N/A");
    const clsDesktop = document.querySelector(".clsDesktop")?.textContent || "N/A"; // CLS = no conversion

    // Mobile values
    const fcpMobile = formatTimeUnit(document.querySelector(".fcpMobile")?.textContent || "N/A");
    const ttiMobile = formatTimeUnit(document.querySelector(".ttiMobile")?.textContent || "N/A");
    const siMobile  = formatTimeUnit(document.querySelector(".siMobile")?.textContent || "N/A");
    const tbtMobile = formatTimeUnit(document.querySelector(".tbtMobile")?.textContent || "N/A");
    const lcpMobile = formatTimeUnit(document.querySelector(".lcpMobile")?.textContent || "N/A");
    const clsMobile = document.querySelector(".clsMobile")?.textContent || "N/A"; // CLS = no conversion


    const vitals = [
        ["FCP", "First contentful paint", fcpDesktop, fcpMobile],
        ["TTI", "Time to Interactive", ttiDesktop, ttiMobile],
        ["SI", "Speed Index", siDesktop, siMobile],
        ["TBT", "Total Blocking time", tbtDesktop, tbtMobile],
        ["LCP", "Largest contentful paint", lcpDesktop, lcpMobile],
        ["CLS", "Cumulative Layout Shift", clsDesktop, clsMobile],
    ];

    // Title
    doc.setFont("helvetica", "bold");
    doc.setFontSize(12);
    doc.setTextColor(0, 0, 0);
    doc.text("Core Web vitals", x, y);
    y += 6;

    // Header Row
    doc.setFillColor(0, 102, 204);
    doc.setTextColor(255, 255, 255);
    for (let i = 0; i < columnCount; i++) {
        doc.rect(x + i * cellWidth, y, cellWidth, rowHeight, "F");
    }

    doc.setFont("helvetica", "bold");
    const headers = ["", "Desktop", "Mobile"];
    headers.forEach((header, i) => {
        doc.text(header, x + i * cellWidth + 5, y + 7);
    });

    y += rowHeight;
    // Data Rows
    vitals.forEach(([code, label, desktop, mobile]) => {
        // Label Cell with subtext
        doc.setTextColor(0, 0, 0);
        doc.setFont("helvetica", "bold");
        doc.rect(x, y, cellWidth, rowHeight);
        doc.text(code, x + 2, y + 5); // main title

        doc.setFont("helvetica", "normal");
        doc.setFontSize(8);
        doc.text(label, x + 2, y + 10); // subtext
        doc.setFontSize(10); // reset for next

        // Desktop Cell
        let [r1, g1, b1] = getVitalsColor(desktop);
        doc.setTextColor(r1, g1, b1);
        doc.setFont("helvetica", "normal");
        doc.rect(x + cellWidth, y, cellWidth, rowHeight);
        centerText(doc, desktop, x + cellWidth, y, cellWidth, rowHeight);

        // Mobile Cell
        let [r2, g2, b2] = getVitalsColor(mobile);
        doc.setTextColor(r2, g2, b2);
        doc.rect(x + 2 * cellWidth, y, cellWidth, rowHeight);
        centerText(doc, mobile, x + 2 * cellWidth, y, cellWidth, rowHeight);

        y += rowHeight;
    });

    // Reset
    doc.setTextColor(0, 0, 0);
    return y + 10;

    // Helper: Center-align text
    function centerText(doc, text, x, y, w, h) {
        const textWidth = doc.getTextWidth(text);
        const textX = x + (w - textWidth) / 2;
        const textY = y + h / 2 + 3;
        doc.text(text, textX, textY);
    }

    // Helper: Color logic based on value (simplified)
    function getVitalsColor(text) {
        if (typeof text !== "string") return [0, 0, 0];
        if (text.includes("seconds")) {
            const val = parseFloat(text);
            if (val < 1) return [0, 128, 0];        // Green
            if (val < 4) return [255, 165, 0];      // Orange
            return [255, 0, 0];                     // Red
        }
        if (text.includes("milli")) {
            const val = parseFloat(text);
            if (val < 20) return [0, 128, 0];
            if (val < 50) return [255, 165, 0];
            return [255, 0, 0];
        }
        const val = parseFloat(text);
        if (val < 0.1) return [0, 128, 0];
        if (val < 0.3) return [255, 165, 0];
        return [255, 0, 0];
    }
}

function formatTimeUnit(value) {
    if (typeof value !== "string") return value;

    value = value.trim().toLowerCase();

    if (value.endsWith(" s")) {
        return value.replace(/ s$/, " seconds");
    } else if (value.endsWith(" ms")) {
        return value.replace(/ ms$/, " milli seconds");
    }

    return value;
}

function renderBestPracticesTable(doc, y) {
    const x = 10;
    const width = 190;
    const colWidths = [50, 100, 40];
    const lineHeight = 5;
    const columnCount = 3;
    const rowHeight = 12;
    const cellWidth = width / columnCount;
    

    const practices = [];

    const tests = [
        ["gzip_compression", "Gzip Compression"],
        ["html_compression", "HTML Compression"],
        ["css_compression", "CSS Compression"],
        ["js_compression", "JS Compression"],
        ["page_size", "HTML Page Size"],
        ["nested_tables", "Nested Tables"],
        ["frameset", "Frameset"]
    ];

    tests.forEach(([dataName, label]) => {
        const el = document.querySelector(`.analysis-card[data-name="${dataName}"]`);
        if (el) {
            const status = el.querySelector(".status_pdf")?.textContent.trim() || "N/A";
            const message = el.querySelector(".message_pdf")?.textContent.trim() || "";
            practices.push([label, message, status]);
        }
    });



    // Title
    doc.setFont("helvetica", "bold");
    doc.setFontSize(12);
    doc.setTextColor(0, 0, 0);
    doc.text("Best Practices", x, y);
    y += 6;

    
    // Header Row
    doc.setFillColor(0, 102, 204);
    doc.setTextColor(255, 255, 255);
    for (let i = 0; i < columnCount; i++) {
        doc.rect(x + i * cellWidth, y, cellWidth, rowHeight, "F");
    }

    doc.setFont("helvetica", "bold");
    const headers = ["Test", "Description", "Status"];
    headers.forEach((header, i) => {
        const textWidth = doc.getTextWidth(header);
        const textX = x + i * cellWidth + (cellWidth - textWidth) / 2;
        doc.text(header, textX, y + 7);
    });
    

    y += rowHeight;


    doc.setFont("helvetica", "normal");

    // Rows
    practices.forEach(([test, desc, status]) => {
        // Wrap description and calculate height
        const descLines = doc.splitTextToSize(desc, colWidths[1] - 4);
        const lineCount = descLines.length;
        const cellHeight = lineCount * lineHeight + 2;

        let cellX = x;

        // Test
        doc.setFontSize(8);
        doc.setTextColor(0, 0, 0);
        doc.rect(cellX, y, colWidths[0], cellHeight);
        doc.text(test, cellX + 2, y + lineHeight);
        cellX += colWidths[0];

        // Description
        doc.setFontSize(8);
        doc.rect(cellX, y, colWidths[1], cellHeight);
        descLines.forEach((line, i) => {
            const lineY = y + lineHeight + i * lineHeight;
            doc.text(line, cellX + 2, lineY);
        });
        cellX += colWidths[1];

        // Status
        const isPass = status.toLowerCase() === "pass";
        const color = isPass ? [0, 128, 0] : [255, 0, 0];
        doc.setTextColor(...color);
        doc.setFontSize(8);
        doc.rect(cellX, y, colWidths[2], cellHeight);

        // Calculate center positions
        const statusTextWidth = doc.getTextWidth(status);
        const statusX = cellX + (colWidths[2] - statusTextWidth) / 2;
        const statusY = y + cellHeight / 2 + 2.5;

        doc.text(status, statusX, statusY);


        y += cellHeight;
    });

    doc.setTextColor(0, 0, 0); // Reset
    return y + 10;
}

function renderSecurityTable(doc, y) {
    const x = 10;
    const width = 190;
    const colWidths = [50, 100, 40];
    const lineHeight = 5;
    const columnCount = 3;
    const rowHeight = 12;
    const cellWidth = width / columnCount;

    const practices = [];

    const tests = [
        ["content_security_policy_header", "Content Security Policy Header"],
        ["x_frame_options_header", "X Frame Options Header"],
        ["hsts_header", "HSTS Header"],
        ["bad_content_type", "Bad content type"],
        ["ssl_certificate_enable", "SSL Certificate"],
        ["folder_browsing_enable", "Directory Browsing"]
    ];

    tests.forEach(([dataName, label]) => {
        const el = document.querySelector(`.analysis-card[data-name="${dataName}"]`);
        if (el) {
            const status = el.querySelector(".status_pdf")?.textContent.trim() || "N/A";
            const message = el.querySelector(".message_pdf")?.textContent.trim() || "";
            practices.push([label, message, status]);
        }
    });

    // Title
    doc.setFont("helvetica", "bold");
    doc.setFontSize(12);
    doc.setTextColor(0, 0, 0);
    doc.text("Security", x, y);
    y += 6;

    // Header Row
    doc.setFillColor(0, 102, 204);
    doc.setTextColor(255, 255, 255);
    for (let i = 0; i < columnCount; i++) {
        doc.rect(x + i * cellWidth, y, cellWidth, rowHeight, "F");
    }

    doc.setFont("helvetica", "bold");
    const headers = ["Test", "Description", "Status"];
    headers.forEach((header, i) => {
        const textWidth = doc.getTextWidth(header);
        const textX = x + i * cellWidth + (cellWidth - textWidth) / 2;
        doc.text(header, textX, y + 7);
    });

    y += rowHeight;
    doc.setFont("helvetica", "normal");

    // Rows
    practices.forEach(([test, desc, status]) => {
        const descLines = doc.splitTextToSize(desc, colWidths[1] - 4);
        const lineCount = descLines.length;
        const cellHeight = lineCount * lineHeight + 2;

        let cellX = x;

        // Test Cell
        doc.setFontSize(8);
        doc.setTextColor(0, 0, 0);
        doc.rect(cellX, y, colWidths[0], cellHeight);
        doc.text(test, cellX + 2, y + lineHeight);
        cellX += colWidths[0];

        // Description Cell
        doc.rect(cellX, y, colWidths[1], cellHeight);
        descLines.forEach((line, i) => {
            const lineY = y + lineHeight + i * lineHeight;
            doc.text(line, cellX + 2, lineY);
        });
        cellX += colWidths[1];

        // Status Cell
        const isPass = status.toLowerCase() === "pass";
        const color = isPass ? [0, 128, 0] : [255, 0, 0];
        doc.setTextColor(...color);
        doc.setFontSize(8);
        doc.rect(cellX, y, colWidths[2], cellHeight);

        const statusTextWidth = doc.getTextWidth(status);
        const statusX = cellX + (colWidths[2] - statusTextWidth) / 2;
        const statusY = y + cellHeight / 2 + 2.5;

        doc.text(status, statusX, statusY);

        y += cellHeight;
    });

    doc.setTextColor(0, 0, 0); // Reset
    return y + 10;
}




function checkPageBreak(doc, y, buffer = 60) {
    const pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
    if (y + buffer > pageHeight) {
        doc.addPage();
        return 10; // Reset y to top margin
    }
    return y;
}
