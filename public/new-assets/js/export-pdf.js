$(document).on("click", ".download-pdf-btn", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // === ADD ROBOTO FONT ===
    // Note: You need to add the base64 encoded font files here
    // For now, we'll check if Roboto fonts are available in window.ROBOTO_FONTS
    let fontFamily = "Roboto"; // Default to Roboto
    
    if (window.ROBOTO_FONTS && window.ROBOTO_FONTS.regular && window.ROBOTO_FONTS.medium && window.ROBOTO_FONTS.bold) {
        try {
            // Add Roboto Regular (400 weight)
            doc.addFileToVFS("Roboto-Regular.ttf", window.ROBOTO_FONTS.regular);
            doc.addFont("Roboto-Regular.ttf", "Roboto", "normal");
            
            // Add Roboto Medium (500 weight)
            doc.addFileToVFS("Roboto-Medium.ttf", window.ROBOTO_FONTS.medium);
            doc.addFont("Roboto-Medium.ttf", "Roboto", "medium");
            
            // Add Roboto Bold (700 weight)
            doc.addFileToVFS("Roboto-Bold.ttf", window.ROBOTO_FONTS.bold);
            doc.addFont("Roboto-Bold.ttf", "Roboto", "bold");
            
            fontFamily = "Roboto"; // Use Roboto if loaded successfully
            console.log("✅ Roboto fonts loaded successfully (Regular, Medium, Bold)");
        } catch (error) {
            console.log("⚠️ Error loading Roboto fonts, falling back to Helvetica:", error);
        }
    } else {
        console.log("⚠️ Roboto fonts not found in window.ROBOTO_FONTS, using Helvetica");
        console.log("   Required: regular, medium, and bold font files");
    }
    
    // Store font family globally for this PDF session
    window.PDF_FONT_FAMILY = fontFamily;

    const projectUrl = document.querySelector(".project-url")?.getAttribute("href") || "N/A";
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleDateString("en-GB");
    const formattedTime = currentDate.toLocaleTimeString("en-GB");

    // === COVER PAGE ===
    renderCoverPage(doc, projectUrl, formattedDate, formattedTime);
    
    // === ADD NEW PAGE FOR CONTENT ===
    doc.addPage();
    
    let y = 10;

    // Check if any SEO tests exist before showing SEO header
    const hasMetaTitle = document.querySelector('.analysis-card[data-name="title"]');
    const hasMetaDescription = document.querySelector('.analysis-card[data-name="description"]');
    const hasRobotsMetaTag = document.querySelector('.analysis-card[data-name="robots"]');
    const hasCanonicalTag = document.querySelector('.analysis-card[data-name="canonical"]');
    const hasImages = document.querySelector('.custom-dataTable');
    const hasURLSlug = document.querySelector('.analysis-card[data-name="url_slug"]');
    const hasRobotsTxt = document.querySelector('.analysis-card[data-name="robots_txt"]');
    const hasHeadings = document.querySelector('.analysis-card[data-name="headings"]');
    const hasXMLSitemap = document.querySelector('.analysis-card[data-name="xml_sitemap"]');
    const hasOpenGraphTags = document.querySelector('.analysis-card[data-name="open_graph"]');
    const hasTwitterTags = document.querySelector('.analysis-card[data-name="twitter_tags"]');
    const hasFavicon = document.querySelector('.analysis-card[data-name="favicon"]');
    const hasMetaViewport = document.querySelector('.analysis-card[data-name="meta_viewport"]');
    const hasDoctype = document.querySelector('.analysis-card[data-name="doctype"]');
    const hasHTTPStatusCode = document.querySelector('.analysis-card[data-name="http_status"]');
    
    const hasAnySEOTest = hasMetaTitle || hasMetaDescription || hasRobotsMetaTag || hasCanonicalTag || 
                         hasImages || hasURLSlug || hasRobotsTxt || hasHeadings || hasXMLSitemap || 
                         hasOpenGraphTags || hasTwitterTags || hasFavicon || hasMetaViewport || 
                         hasDoctype || hasHTTPStatusCode;
    
    if (hasAnySEOTest) {
        y = renderSEOHeader(doc, y);
        y = checkPageBreak(doc, y, 60);
    }

    const metaTitleY = y;
    y = renderMetaTitle(doc, y);
    const hasMetaTitleContent = y > metaTitleY;
    if (hasMetaTitleContent) y = addSeparatorLine(doc, y); // Add separator after Meta Title
    y = checkPageBreak(doc, y, 60);

    const metaDescY = y;
    y = renderMetaDescription(doc, y);
    const hasMetaDescContent = y > metaDescY;
    if (hasMetaDescContent) y = addSeparatorLine(doc, y); // Add separator after Meta Description
    y = checkPageBreak(doc, y, 60);

    const canonicalY = y;
    y = renderCanonicalURL(doc, y);
    const hasCanonicalContent = y > canonicalY;
    if (hasCanonicalContent) y = addSeparatorLine(doc, y); // Add separator after Canonical URL
    y = checkPageBreak(doc, y, 60);

    const urlSlugY = y;
    y = renderUrlSlug(doc, y);
    const hasUrlSlugContent = y > urlSlugY;
    if (hasUrlSlugContent) y = addSeparatorLine(doc, y); // Add separator after URL Slug
    y = checkPageBreak(doc, y, 60);

    const robotsTxtY = y;
    y = renderRobotsTxtTest(doc, y);
    const hasRobotsTxtContent = y > robotsTxtY;
    if (hasRobotsTxtContent) y = addSeparatorLine(doc, y); // Add separator after Robots.txt Test
    y = checkPageBreak(doc, y, 60);

    const xmlSitemapY = y;
    y = renderXmlSitemapTest(doc, y);
    const hasXmlSitemapContent = y > xmlSitemapY;
    if (hasXmlSitemapContent) y = addSeparatorLine(doc, y); // Add separator after XML Sitemap Test
    y = checkPageBreak(doc, y, 60);

    const faviconY = y;
    y = renderFaviconTest(doc, y);
    const hasFaviconContent = y > faviconY;
    if (hasFaviconContent) y = addSeparatorLine(doc, y); // Add separator after Favicon Test
    y = checkPageBreak(doc, y, 60);

    const doctypeY = y;
    y = renderDoctypeTest(doc, y);
    const hasDoctypeContent = y > doctypeY;
    if (hasDoctypeContent) y = addSeparatorLine(doc, y); // Add separator after Doctype Test
    y = checkPageBreak(doc, y, 60);

    const viewportY = y;
    y = renderMetaViewportTest(doc, y);
    const hasViewportContent = y > viewportY;
    if (hasViewportContent) y = addSeparatorLine(doc, y); // Add separator after Meta Viewport Test
    y = checkPageBreak(doc, y, 60);

    const httpStatusCodeY = y;
    y = renderHttpStatusCodeTest(doc, y);
    const hasHttpStatusCodeContent = y > httpStatusCodeY;
    if (hasHttpStatusCodeContent) y = addSeparatorLine(doc, y); // Add separator after HTTP Status Code Test
    y = checkPageBreak(doc, y, 60);

    // === Headings Test ===
    y = renderHeadingsTest(doc, y);
    y = checkPageBreak(doc, y, 60);
    
    // === Headings Table ===
    y = renderHeadingsTable(doc, y);
    y = checkPageBreak(doc, y, 60);

    const robotsY = y;
    y = renderRobotsMeta(doc, y);
    const hasRobotsContent = y > robotsY;
    if (hasRobotsContent) y = addSeparatorLine(doc, y); // Add separator after Robots Meta
    y = checkPageBreak(doc, y, 60);

    y = renderImagesHeader(doc, y);
    y = checkPageBreak(doc, y, 60);

    y = addTableToPDF(doc, y);
    y = checkPageBreak(doc, y, 60);

    const openGraphY = y;
    y = renderOpenGraphTest(doc, y);
    const hasOpenGraphContent = y > openGraphY;
    if (hasOpenGraphContent) y = addSeparatorLine(doc, y); // Add separator after Open Graph Test
    y = checkPageBreak(doc, y, 60);

    const twitterY = y;
    y = renderTwitterTest(doc, y);
    const hasTwitterContent = y > twitterY;
    // Removed separator line after Twitter Test
    y = checkPageBreak(doc, y, 60);

    
    // Check if any performance tests exist before showing Performance header
    const hasOverallScore = document.querySelector('.analysis-card[data-name="google_overall"]');
    const hasLighthouseScore = document.querySelector('.analysis-card[data-name="google_lighthouse"]');
    const hasCoreWebVitals = document.querySelector('.analysis-card[data-name="core_web_vitals"]');
    const hasMobileFriendliness = document.querySelector('.analysis-card[data-name="mobile_friendliness"]');
    
    const hasAnyPerformanceTest = hasOverallScore || hasLighthouseScore || hasCoreWebVitals || hasMobileFriendliness;
    
    if (hasAnyPerformanceTest) {
        const perfHeaderY = y;
        y = renderPerformanceHeaderSection(doc, y);
        const hasPerfHeader = y > perfHeaderY;
        // Removed separator line before Performance table
        y = checkPageBreak(doc, y, 60);
    }
    
    const perfSectionY = y;
    y = renderPerformanceSection(doc, y);
    const hasPerfSection = y > perfSectionY;
    // Removed separator line between Performance and Lighthouse tables
    y = checkPageBreak(doc, y, 60);

    const lighthouseY = y;
    y = renderLighthouseScoreTable(doc, y);
    const hasLighthouse = y > lighthouseY;
    // Removed separator line before Lighthouse Score table
    y = checkPageBreak(doc, y, 60);

    const coreWebY = y;
    y = renderCoreWebVitalsTable(doc, y);
    const hasCoreWeb = y > coreWebY;
    if (hasCoreWeb) y = addSeparatorLine(doc, y); // Add separator after Core Web Vitals
    y = checkPageBreak(doc, y, 60);

    // === Google Mobile Friendly Test ===
    y = renderGoogleMobileFriendlyTest(doc, y);
    y = checkPageBreak(doc, y, 60);

    const bestPracticesY = y;
    y = renderBestPracticesTable(doc, y);
    const hasBestPractices = y > bestPracticesY;
    y = checkPageBreak(doc, y, 60);
    
    // === Broken Links Test (Best Practices Category) ===
    const brokenLinksY = y;
    y = renderBrokenLinksTest(doc, y);
    const hasBrokenLinksContent = y > brokenLinksY;
    y = checkPageBreak(doc, y, 60);
    
    // === Broken Links Table ===
    y = addBrokenLinksTableToPDF(doc, y);
    y = checkPageBreak(doc, y, 60);

    const securityY = y;
    y = renderSecurityTable(doc, y);
    const hasSecurity = y > securityY;
    // Note: No separator after last section
    y = checkPageBreak(doc, y, 60);

    // Add new sections here in future
    // y = renderNewTestSection(doc, y);

    // Generate filename with current date and time
    const now = new Date();
    const dateStr = now.toISOString().split('T')[0]; // YYYY-MM-DD format
    const timeStr = now.toTimeString().split(' ')[0].replace(/:/g, '-'); // HH-MM-SS format
    const filename = `webpage_analysis_report_${dateStr}_${timeStr}.pdf`;
    
    doc.save(filename);
    
});

/* ---------- Common Drawing Function ---------- */
function drawSection1(doc, title, content, length, casing, result, yPosition, showCasing = true) {
    const x = 10;
    const width = 190;
    const padding = 3;
    const availableWidth = width - 2 * padding;
    const font = window.PDF_FONT_FAMILY || "Roboto";

    // Compute text height
    const contentLines = doc.splitTextToSize(content, width - 2 * padding);
    let boxHeight = 12 + contentLines.length * 4;
    if (showCasing) boxHeight += 6;

    // === 1. Draw Section Title ===
    doc.setFont(font, "medium").setFontSize(12);
    const titleText = sanitizeTestTitle(title);
    doc.text(titleText, x, yPosition + 10);

    // === 2. Draw Status Badge (PASS/FAIL) on right of title ===
    const resultUpper = result.toUpperCase();
    const resultColor =
        resultUpper === "PASS" ? [40, 167, 69] :
        resultUpper === "FAIL" ? [220, 53, 69] : [0, 0, 0];

    doc.setFontSize(20)
        .setTextColor(...resultColor)
        .text(resultUpper, x + width - 10, yPosition + 10, { align: "right" });
    doc.setTextColor(0, 0, 0); // Reset color

    // === 3. Draw Content Box ===
    const boxY = yPosition + 17; // Added vertical gap between title/badge and content box
    doc.setFillColor(249, 249, 249); // light gray
    doc.rect(x, boxY, width, boxHeight, "F");

    // === 4. Inside Content Box ===
    let textY = boxY + 10;
    
    // Check if content contains labels like "Actual URL:", "Canonical URL:", "URL Slug Content:", "Robots.txt Test Content:", "XML Sitemap Test Content:", "Favicon Test Content:", "Doctype Test Content:", "Meta Viewport Test Content:", "HTTP Status Code Test Content:", "Broken Links Test Content:", "Headings Test Content:", or "Google Mobile Friendly Test Content:"
    const hasLabels = content.includes("Actual URL:") || content.includes("Canonical URL:") || content.includes("URL Slug Content:") || content.includes("Robots.txt Test Content:") || content.includes("XML Sitemap Test Content:") || content.includes("Favicon Test Content:") || content.includes("Doctype Test Content:") || content.includes("Meta Viewport Test Content:") || content.includes("HTTP Status Code Test Content:") || content.includes("Broken Links Test Content:") || content.includes("Headings Test Content:") || content.includes("Google Mobile Friendly Test Content:");
    
    if (hasLabels) {
        // Parse and render content with label styling
        const lines = content.split('\n');
        lines.forEach((line, index) => {
            if (line.trim()) {
                // Check if line contains a label (ends with colon)
                if (line.includes(':') && (line.includes('Actual URL:') || line.includes('Canonical URL:') || line.includes('URL Slug Content:') || line.includes('Robots.txt Test Content:') || line.includes('XML Sitemap Test Content:') || line.includes('Favicon Test Content:') || line.includes('Doctype Test Content:') || line.includes('Meta Viewport Test Content:') || line.includes('HTTP Status Code Test Content:') || line.includes('Broken Links Test Content:') || line.includes('Headings Test Content:') || line.includes('Google Mobile Friendly Test Content:'))) {
                    // Split label and value
                    const colonIndex = line.indexOf(':');
                    const label = line.substring(0, colonIndex + 1);
                    const value = line.substring(colonIndex + 1).trim();

                    // Draw label with medium font weight
                    doc.setFont(font, "medium").setFontSize(10).setTextColor(34, 34, 34);
                    doc.text(label, x + padding, textY);

                    // Draw value with normal font weight
                    if (value) {
                        const labelWidth = doc.getTextWidth(label);
                        doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                        doc.text(value, x + padding + labelWidth + 2, textY);
                    }
                } else {
                    // Regular text with normal font weight
                    doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                    doc.text(line, x + padding, textY);
                }
                textY += 5;
            }
        });
        textY += 4;
    } else {
        const lines = content.split('\n');
        const hasContentLabel = lines.some(line => line.trim().startsWith('Content:'));

        if (hasContentLabel) {
            lines.forEach((line) => {
                if (!line.trim()) return;

                if (line.trim().startsWith('Content:')) {
                    const label = 'Content:';
                    const value = line.substring(label.length).trim();

                    doc.setFont(font, "medium").setFontSize(10).setTextColor(34, 34, 34);
                    doc.text(label, x + padding, textY);

                    if (value) {
                        const labelWidth = doc.getTextWidth(label);
                        const maxValueWidth = availableWidth - labelWidth - 4;
                        const valueLines = doc.splitTextToSize(value, Math.max(maxValueWidth, 10));

                        doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                        valueLines.forEach((lineText, idx) => {
                            if (idx === 0) {
                                doc.text(lineText, x + padding + labelWidth + 2, textY);
                            } else {
                                textY += 5;
                                doc.text(lineText, x + padding + labelWidth + 2, textY);
                            }
                        });
                    }
                } else {
                    doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                    doc.text(line, x + padding, textY);
                }

                textY += 5;
            });

            textY += 4;
        } else {
            // Normal content without labels
            doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
            doc.text(contentLines, x + padding, textY);
            textY += contentLines.length * 5 + 4;
        }
    }

    // Length (only show if not empty and not a labeled section like Canonical URL)
    if (length && length.trim() !== "" && !hasLabels) {
        doc.setFont(font, "medium").setTextColor(34, 34, 34).text("Length:", x + padding, textY);
        doc.setFont(font, "normal").setTextColor(34, 34, 34).text(length, x + 38, textY);
        textY += 6;
    }

    // Casing (only show if enabled and not a labeled section)
    if (showCasing && !hasLabels) {
        doc.setFont(font, "medium").setTextColor(34, 34, 34).text("Casing:", x + padding, textY);
        doc.setFont(font, "normal").setTextColor(34, 34, 34).text(casing, x + 38, textY);
        textY += 6;
    }

    return boxY + boxHeight + 10; // return updated y-position
}

function drawSection(doc, title, content, length, casing, result, yPosition, showCasing = true) {
    const x = 10;
    const width = 190;
    const padding = 6; // ✅ slightly more padding on both sides
    const pageHeight = doc.internal.pageSize.getHeight();
    const font = window.PDF_FONT_FAMILY || "Roboto";

    const availableTextWidth = width - 2 * padding;

    // === 1. Split content ===
    const contentLines = doc.splitTextToSize(content, availableTextWidth);
    const lineHeight = doc.internal.getLineHeight() / doc.internal.scaleFactor;
    let textHeight = contentLines.length * (lineHeight + 1.5);

    const rawContentLines = content.split('\n');
    const hasContentLabel = rawContentLines.some(line => line.trim().startsWith('Content:'));

    if (hasContentLabel) {
        doc.setFont(font, "normal").setFontSize(10);
        let estimatedLineCount = 0;

        rawContentLines.forEach(line => {
            const trimmed = line.trim();
            if (!trimmed) return;

            if (trimmed.startsWith('Content:')) {
                estimatedLineCount += 1; // label line itself
                const label = 'Content:';
                const value = trimmed.substring(label.length).trim();

                doc.setFont(font, "medium").setFontSize(10);
                const labelWidth = doc.getTextWidth(label);
                doc.setFont(font, "normal").setFontSize(10);

                if (value) {
                    const maxValueWidth = Math.max(availableTextWidth - labelWidth - 4, 10);
                    const valueLines = doc.splitTextToSize(value, maxValueWidth);
                    if (valueLines.length > 0) {
                        estimatedLineCount += valueLines.length - 1;
                    }
                }
            } else {
                const wrapped = doc.splitTextToSize(trimmed, availableTextWidth);
                estimatedLineCount += Math.max(wrapped.length, 1);
            }
        });

        const lineSpacing = 5;
        textHeight = estimatedLineCount * lineSpacing + 4; // add small buffer
    }

    let boxHeight = 10 + textHeight + 8;
    if (showCasing) boxHeight += 7;

    // === 2. Page break check ===
    if (yPosition + boxHeight + 30 > pageHeight) {
        doc.addPage();
        yPosition = 20;
    }

    // === 3. PASS/FAIL icon ===
    const isPass = result.toUpperCase() === "PASS";
    
    const checkImage = window.PDF_IMAGES.CHECK_IMAGE;
    const crossImage = window.PDF_IMAGES.CROSS_IMAGE;
    const iconImage = isPass ? checkImage : crossImage;

    const iconSize = 4;
    const iconX = x - 1;
    const iconY = yPosition + 7;
    doc.addImage(iconImage, "PNG", iconX, iconY, iconSize, iconSize);

    // === 4. Title ===
    doc.setFont(font, "medium").setFontSize(12).setTextColor(34, 34, 34);
    const titleText = sanitizeTestTitle(title);
    doc.text(titleText, x + 5, yPosition + 10.2);

    // === 5. PASS/FAIL badge ===
    // const resultUpper = result.toUpperCase();
    // const scale = 0.7;
    // const badgeTextWidth = doc.getTextWidth(resultUpper) * scale;
    // const badgePadding = 5 * scale;
    // const badgeWidth = badgeTextWidth + badgePadding * 2;
    // const badgeHeight = 8 * scale;
    // const badgeX = x + width - badgeWidth - 0.5;
    // const badgeY = yPosition + 6.8;

    // const bgColor = isPass ? [212, 237, 218] : [248, 215, 218];
    // const textColor = isPass ? [40, 167, 69] : [220, 53, 69];
// === 5. PASS/FAIL badge ===
const resultUpper = result.toUpperCase();
const scale = 0.7;

// Compute text + padding
const badgeTextWidth = doc.getTextWidth(resultUpper) * scale;
const badgePadding = 5 * scale;
let badgeWidth = badgeTextWidth + badgePadding * 2;
let badgeHeight = 8 * scale;

// ✅ Adjustments per your request - make badge smaller from left side
badgeWidth *= 0.9;         // reduce width by 10% (was 15%) for better text centering
badgeHeight *= 1.1;        // increase height by 10%
const badgeX = x + width - badgeWidth - 0.5; // ✅ align perfectly with section box like drawSectionNoLength
const badgeY = yPosition + 6.8 - (badgeHeight * 0.1); // ✅ move badge 10% up on section box

const bgColor = isPass ? [223, 239, 217] : [248, 229, 229]; // Updated FAIL background color
const textColor = isPass ? [92, 174, 53] : [212, 100, 100]; // Updated FAIL text color

// ✅ Rounded badge (small radius)
doc.setFillColor(...bgColor);
roundedRect(doc, badgeX, badgeY, badgeWidth, badgeHeight, 0.8, "F");

// ✅ Text adjustments - reduce font size by 10%
const reducedFont = 14 * scale * 0.9; // reduce font size by 10% (was 1.0, now 0.9)
doc.setFontSize(reducedFont).setFont("helvetica", "normal"); // Note: Using Helvetica as closest to Circular Std in jsPDF
doc.setTextColor(...textColor);

// ✅ Center text in badge - perfect centering
const badgeTextX = badgeX + badgeWidth / 2 - doc.getTextWidth(resultUpper) * scale / 2 - 0.8 - (isPass ? badgeWidth * 0.04 : 0); // Move PASS text left by 4% of badge width
const badgeTextY = badgeY + badgeHeight / 2 + (reducedFont / 6.5); // Move text slightly more up
doc.text(resultUpper, badgeTextX, badgeTextY);
    doc.setTextColor(0, 0, 0);

    // === 6. Section box (✅ with rounded corners) ===
    const boxY = yPosition + 14;
    doc.setFillColor(246, 248, 250);
    roundedRect(doc, x, boxY, width, boxHeight, 1.2, "F");

    // === 7. Content text (✅ with side padding) ===
    let textY = boxY + 8;
    
    // Check if content contains labels like "Actual URL:", "Canonical URL:", "URL Slug Content:", "Robots.txt Test Content:", "XML Sitemap Test Content:", "Favicon Test Content:", "Doctype Test Content:", "Meta Viewport Test Content:", "HTTP Status Code Test Content:", "Broken Links Test Content:", "Headings Test Content:", or "Google Mobile Friendly Test Content:"
    const hasLabels = content.includes("Actual URL:") || content.includes("Canonical URL:") || content.includes("URL Slug Content:") || content.includes("Robots.txt Test Content:") || content.includes("XML Sitemap Test Content:") || content.includes("Favicon Test Content:") || content.includes("Doctype Test Content:") || content.includes("Meta Viewport Test Content:") || content.includes("HTTP Status Code Test Content:") || content.includes("Broken Links Test Content:") || content.includes("Headings Test Content:") || content.includes("Google Mobile Friendly Test Content:");
    
    if (hasLabels) {
        // Parse and render content with label styling
        const lines = content.split('\n');
        lines.forEach((line, index) => {
            if (line.trim()) {
                // Check if line contains a label (ends with colon)
                if (line.includes(':') && (line.includes('Actual URL:') || line.includes('Canonical URL:') || line.includes('URL Slug Content:') || line.includes('Robots.txt Test Content:') || line.includes('XML Sitemap Test Content:') || line.includes('Favicon Test Content:') || line.includes('Doctype Test Content:') || line.includes('Meta Viewport Test Content:') || line.includes('HTTP Status Code Test Content:') || line.includes('Broken Links Test Content:') || line.includes('Headings Test Content:') || line.includes('Google Mobile Friendly Test Content:'))) {
                    // Split label and value
                    const colonIndex = line.indexOf(':');
                    const label = line.substring(0, colonIndex + 1);
                    const value = line.substring(colonIndex + 1).trim();

                    // Draw label with medium font weight
                    doc.setFont(font, "medium").setFontSize(10).setTextColor(34, 34, 34);
                    doc.text(label, x + padding, textY);

                    // Draw value with normal font weight
                    if (value) {
                        const labelWidth = doc.getTextWidth(label);
                        doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                        doc.text(value, x + padding + labelWidth + 2, textY);
                    }
                } else {
                    // Regular text with normal font weight
                    doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                    doc.text(line, x + padding, textY);
                }
                textY += 5;
            }
        });
        textY += 4;
    } else {
        const lines = rawContentLines;

        if (hasContentLabel) {
            lines.forEach((line) => {
                if (!line.trim()) return;

                if (line.trim().startsWith('Content:')) {
                    const label = 'Content:';
                    const value = line.substring(label.length).trim();

                    doc.setFont(font, "medium").setFontSize(10).setTextColor(34, 34, 34);
                    doc.text(label, x + padding, textY);

                    if (value) {
                        // Use same spacing as Length and Casing (x + 28)
                        const valueStartX = x + 28;
                        const maxValueWidth = Math.max(availableTextWidth - (28 - padding), 10);
                        const valueLines = doc.splitTextToSize(value, maxValueWidth);

                        doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                        valueLines.forEach((lineText, idx) => {
                            if (idx === 0) {
                                doc.text(lineText, valueStartX, textY);
                            } else {
                                textY += 5;
                                doc.text(lineText, valueStartX, textY);
                            }
                        });
                    }
                } else {
                    doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                    doc.text(line, x + padding, textY);
                }

                textY += 5;
            });

            textY += 4;
        } else {
            // Normal content without labels
            doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
            try {
                doc.text(content, x + padding, textY, {
                    maxWidth: availableTextWidth,
                    align: "justify"
                });
                textY += textHeight + 4;
            } catch (err) {
                textY = drawJustifiedText(doc, content, x + padding, textY, availableTextWidth, lineHeight + 1.5);
            }
        }
    }

    // === 8. Length line (✅ tighter spacing) - only show if not a labeled section ===
    if (length && length.trim() !== "" && !hasLabels) {
        doc.setFont(font, "medium").setTextColor(34, 34, 34).text("Length:", x + padding, textY);
        doc.setFont(font, "normal").text(length, x + 28, textY); // reduced spacing
        textY += 7;
    }

    // === 9. Casing line (✅ tighter spacing) - only show if enabled and not a labeled section ===
    if (showCasing && !hasLabels) {
        doc.setFont(font, "medium").text("Casing:", x + padding, textY);
        doc.setFont(font, "normal").text(casing, x + 28, textY);
        textY += 5;
    }

    return boxY + boxHeight + 15;
}

// === Rounded rectangle helper ===
function roundedRect(doc, x, y, width, height, radius, style = "S") {
    doc.roundedRect(x, y, width, height, radius, radius, style);
}

// Remove trailing " Test" from section titles for cleaner headers
function sanitizeTestTitle(title) {
    if (typeof title !== "string") return title;
    return title.replace(/\s+Test\b$/, "").trim();
}

// === Manual justification fallback ===
function drawJustifiedText(doc, text, x, y, maxWidth, lineHeight) {
    const words = text.split(/\s+/);
    let line = '';
    let lines = [];

    for (let i = 0; i < words.length; i++) {
        const testLine = line + words[i] + ' ';
        const testWidth = doc.getTextWidth(testLine);
        if (testWidth > maxWidth && i > 0) {
            lines.push(line.trim());
            line = words[i] + ' ';
        } else {
            line = testLine;
        }
    }
    lines.push(line.trim());

    lines.forEach((l, idx) => {
        if (idx === lines.length - 1) {
            doc.text(l, x, y);
        } else {
            const wordsInLine = l.split(/\s+/);
            const totalWordsWidth = wordsInLine.reduce((sum, w) => sum + doc.getTextWidth(w), 0);
            const spaceWidth = (maxWidth - totalWordsWidth) / (wordsInLine.length - 1);
            let currentX = x;
            wordsInLine.forEach((w) => {
                doc.text(w, currentX, y);
                currentX += doc.getTextWidth(w) + spaceWidth;
            });
        }
        y += lineHeight;
    });
    return y;
}



/* ---------- Section Function without Length Display ---------- */
function drawSectionNoLength_2(doc, title, content, result, yPosition) {
    const x = 10;
    const width = 190;
    const padding = 6; // ✅ Match Meta Description padding for consistent spacing
    const font = window.PDF_FONT_FAMILY || "Roboto";

    // === 1. Status Icon with Data Image ===
    const isPass = result.toUpperCase() === "PASS";
    const iconSize = 4; // tweak to fit nicely
    const iconX = x - 1; // Position for the icon
    const iconY = yPosition + 7; // Position for the icon
    
    // Use data images for PASS/FAIL icons
    const checkImage = window.PDF_IMAGES.CHECK_IMAGE;
    const crossImage = window.PDF_IMAGES.CROSS_IMAGE;
// ❌ FAIL (red circle + X)
// You will add the cross image data here
    
    const iconImage = isPass ? checkImage : crossImage;
    
    // Add the data image to PDF
    if (iconImage) {
        try {
            doc.addImage(iconImage, 'PNG', iconX, iconY, iconSize, iconSize);
        } catch (e) {
            console.log("Error loading icon image:", e);
            // Fallback to colored circle
            const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
            doc.setFillColor(...circleColor);
            doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
        }
    } else {
        // Fallback when no image data provided
        const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
        doc.setFillColor(...circleColor);
        doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
    }

    // === 2. Title Alignment ===
    doc.setFont(font, "medium").setFontSize(12).setTextColor(34, 34, 34);
    
    const titleText = sanitizeTestTitle(title);
    doc.text(titleText, x + 5, yPosition + 10.2); // Matches check icon vertical position

    // === 3. PASS Badge (perfectly aligned) ===
    const resultUpper = result.toUpperCase();

    // scaling factor (reduce to 70%)
    const scale = 0.7;

    const badgeTextWidth = doc.getTextWidth(resultUpper) * scale;
    const badgePadding = 5 * scale; 
    let badgeWidth = badgeTextWidth + badgePadding * 2;
    let badgeHeight = 8 * scale;

    // ✅ Apply same badge styling as drawSection
    badgeWidth *= 0.9;         // reduce width by 10% for better text centering
    badgeHeight *= 1.1;        // increase height by 10%
    const badgeX = x + width - badgeWidth - 0.5;
    const badgeY = yPosition + 6.8 - (badgeHeight * 0.1); // move badge 10% up

    // ✅ Updated colors to match drawSection
    const bgColor = resultUpper === "PASS" ? [223, 239, 217] : [248, 229, 229];
    const textColor = resultUpper === "PASS" ? [92, 174, 53] : [212, 100, 100];

    // ✅ Rounded badge (small radius)
    doc.setFillColor(...bgColor);
    roundedRect(doc, badgeX, badgeY, badgeWidth, badgeHeight, 0.8, "F");

    // ✅ Text adjustments - reduce font size by 10%
    const reducedFont = 14 * scale * 0.9;
    doc.setFontSize(reducedFont).setFont("helvetica", "normal");
    doc.setTextColor(...textColor);

    // ✅ Center text in badge - perfect centering
    const badgeTextX = badgeX + badgeWidth / 2 - doc.getTextWidth(resultUpper) * scale / 2 - 0.8;
    const badgeTextY = badgeY + badgeHeight / 2 + (reducedFont / 6.5);
    doc.text(resultUpper, badgeTextX, badgeTextY);

    doc.setTextColor(0, 0, 0);

    // === 4. Content Box with Top and Bottom Borders ===
    const contentLines = doc.splitTextToSize(content, width - 2 * padding); // Use full available width
    
    // Calculate proper box height with balanced spacing
    const topPadding = 2; // Space at top of content box (minimal for compact look)
    const bottomPadding = 2; // Space at bottom of content box (minimal for compact look)
    const lineSpacing = 5; // Space between lines (reduced for more compact look)
    const numberOfLines = contentLines.length;

    let boxHeight = topPadding + (numberOfLines * lineSpacing) + bottomPadding;

    const boxY = yPosition + 14; // Added vertical gap between title/badge and content box // Perfect spacing from title - same as drawSection
    
    // Draw top border to match bottom border
    // Top border removed
    
    // ✅ Content box background with rounded corners
    doc.setFillColor(246, 248, 250);
    roundedRect(doc, x, boxY, width, boxHeight, 1.2, "F");

    // === 5. Content Text ===
    // Center the content vertically in the box with more offset
    const totalTextHeight = (numberOfLines * 6); // Total height of all text lines
    const availableSpace = boxHeight - (topPadding + bottomPadding);
    const extraSpace = availableSpace - totalTextHeight;
    const centeredTopPadding = topPadding + (extraSpace / 2) + 2; // Added 2px more offset
    
    let textY = boxY + centeredTopPadding; // Center content vertically with more offset
    
    // Parse content to apply medium font weight to labels
    const contentText = content;
    const lines = contentText.split('\n');
    
    // Calculate the maximum label width for consistent URL alignment
    let maxLabelWidth = 0;
    const labelLines = lines.filter(line => line.trim() && line.includes(':') && (line.includes('Actual URL:') || line.includes('Canonical URL:') || line.includes('URL Slug Content:') || line.includes('Robots.txt Test Content:') || line.includes('XML Sitemap Test Content:') || line.includes('Favicon Test Content:') || line.includes('Doctype Test Content:') || line.includes('Meta Viewport Test Content:') || line.includes('HTTP Status Code Test Content:') || line.includes('Broken Links Test Content:') || line.includes('Headings Test Content:') || line.includes('Google Mobile Friendly Test Content:')));
    
    labelLines.forEach(line => {
        const colonIndex = line.indexOf(':');
        const label = line.substring(0, colonIndex + 1);
        doc.setFont(font, "medium").setFontSize(10);
        const labelWidth = doc.getTextWidth(label);
        maxLabelWidth = Math.max(maxLabelWidth, labelWidth);
    });
    
    // Add spacing between label and value
    const labelValueSpacing = 8; // Distance between label and URL
    const valueStartX = x + padding + maxLabelWidth + labelValueSpacing;
    
    lines.forEach((line, index) => {
        if (line.trim()) {
            // Check if line contains a label (ends with colon)
                if (line.includes(':') && (line.includes('Actual URL:') || line.includes('Canonical URL:') || line.includes('URL Slug Content:') || line.includes('Robots.txt Test Content:') || line.includes('XML Sitemap Test Content:') || line.includes('Favicon Test Content:') || line.includes('Doctype Test Content:') || line.includes('Meta Viewport Test Content:') || line.includes('HTTP Status Code Test Content:') || line.includes('Broken Links Test Content:') || line.includes('Headings Test Content:') || line.includes('Google Mobile Friendly Test Content:'))) {
                // Split label and value
                const colonIndex = line.indexOf(':');
                const label = line.substring(0, colonIndex + 1);
                const value = line.substring(colonIndex + 1).trim();
                
                // Draw label with medium font weight
                doc.setFont(font, "medium").setFontSize(10).setTextColor(34, 34, 34);
                doc.text(label, x + padding, textY);
                
                // Draw value with normal font weight at consistent position
                if (value) {
                    doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                    // Wrap value text to respect right margin
                    const maxValueWidth = width - valueStartX - rightMargin;
                    const valueLines = doc.splitTextToSize(value, maxValueWidth);
                    valueLines.forEach((valueLine, lineIndex) => {
                        doc.text(valueLine, valueStartX, textY + (lineIndex * lineSpacing));
                    });
                    // Adjust textY for multi-line values
                    textY += (valueLines.length - 1) * lineSpacing;
                }
            } else {
                // Regular text with normal font weight
                doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                // Wrap regular text to respect right margin
                const maxTextWidth = width - x - padding - rightMargin;
                const textLines = doc.splitTextToSize(line, maxTextWidth);
                textLines.forEach((textLine, lineIndex) => {
                    doc.text(textLine, x + padding, textY + (lineIndex * lineSpacing));
                });
                // Adjust textY for multi-line text
                textY += (textLines.length - 1) * lineSpacing;
            }
            
            textY += 6; // Line height for compact spacing between Actual URL and Canonical URL
        }
    });

    // === 6. Bottom Divider Line ===
    const lineY = boxY + boxHeight;
    // Bottom divider removed

    return lineY + 15; // Increased spacing between sections
}

function drawSectionNoLength(doc, title, content, result, yPosition) {
    const x = 10;
    const width = 190;
    const padding = 6;
    const font = window.PDF_FONT_FAMILY || "Roboto";
    
    // Use very conservative text width - 85% of available width to prevent overflow
    const TEXT_WIDTH_PERCENTAGE = 0.85;

    // === 1. Status Icon with Data Image ===
    const isPass = result.toUpperCase() === "PASS";
    const iconSize = 4;
    const iconX = x - 1;
    const iconY = yPosition + 7;
    
    const checkImage = window.PDF_IMAGES.CHECK_IMAGE;
    const crossImage = window.PDF_IMAGES.CROSS_IMAGE;
    const iconImage = isPass ? checkImage : crossImage;
    
    if (iconImage) {
        try {
            doc.addImage(iconImage, 'PNG', iconX, iconY, iconSize, iconSize);
        } catch (e) {
            console.log("Error loading icon image:", e);
            const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
            doc.setFillColor(...circleColor);
            doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
        }
    } else {
        const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
        doc.setFillColor(...circleColor);
        doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
    }

    // === 2. Title Alignment ===
    doc.setFont(font, "medium").setFontSize(12).setTextColor(34, 34, 34);
    const titleText = sanitizeTestTitle(title);
    doc.text(titleText, x + 5, yPosition + 10.2);

    // === 3. PASS Badge ===
    const resultUpper = result.toUpperCase();
    const scale = 0.7;
    const badgeTextWidth = doc.getTextWidth(resultUpper) * scale;
    const badgePadding = 5 * scale; 
    let badgeWidth = badgeTextWidth + badgePadding * 2;
    let badgeHeight = 8 * scale;

    badgeWidth *= 0.9;
    badgeHeight *= 1.1;
    const badgeX = x + width - badgeWidth - 0.5;
    const badgeY = yPosition + 6.8 - (badgeHeight * 0.1);

    const bgColor = resultUpper === "PASS" ? [223, 239, 217] : [248, 229, 229];
    const textColor = resultUpper === "PASS" ? [92, 174, 53] : [212, 100, 100];

    doc.setFillColor(...bgColor);
    roundedRect(doc, badgeX, badgeY, badgeWidth, badgeHeight, 0.8, "F");

    const reducedFont = 14 * scale * 0.9;
    doc.setFontSize(reducedFont).setFont("helvetica", "normal");
    doc.setTextColor(...textColor);

    const badgeTextX = badgeX + badgeWidth / 2 - doc.getTextWidth(resultUpper) * scale / 2 - 0.8 - (isPass ? badgeWidth * 0.04 : 0);
    const badgeTextY = badgeY + badgeHeight / 2 + (reducedFont / 6.5);
    doc.text(resultUpper, badgeTextX, badgeTextY);

    doc.setTextColor(0, 0, 0);

    // === 4. Content Box with Reduced Height ===
    // Fixed values for consistent spacing
    const lineSpacing = 6; // Space between lines
    
    // Pre-calculate text wrapping to get accurate line count
    // Use percentage-based width calculation for maximum safety
    // Calculate available width and apply percentage reduction
    const baseAvailableWidth = width - 2 * padding;
    const availableTextWidth = baseAvailableWidth * TEXT_WIDTH_PERCENTAGE;
    const contentLines = doc.splitTextToSize(content, availableTextWidth);
    const numberOfLines = contentLines.length;
    
    // Calculate total text height
    const totalTextHeight = (numberOfLines * lineSpacing);
    
    // Set box height with reduced bottom padding by 10%
    const boxVerticalPadding = 6; // Top padding
    const bottomPadding = 0; // No bottom padding for minimal spacing
    let boxHeight = totalTextHeight + boxVerticalPadding + bottomPadding;

    const boxY = yPosition + 14;
    
    // Content box background
    doc.setFillColor(246, 248, 250);
    roundedRect(doc, x, boxY, width, boxHeight, 1.2, "F");

    // === 5. Vertically Centered Content Text ===
    // Calculate starting Y position to center the content vertically with additional 10% bottom reduction
    const totalContentHeight = numberOfLines * lineSpacing;
    const startY = boxY + (boxHeight - totalContentHeight) / 2 + (lineSpacing / 3) + 2.5; // Move content down by 3.6px (reduced by 20% from 4.5px)
    
    let textY = startY;
    
    // Parse content to apply medium font weight to labels
    const contentText = content;
    const lines = contentText.split('\n');
    
    // Calculate the maximum label width for consistent URL alignment
    let maxLabelWidth = 0;
    const labelLines = lines.filter(line => line.trim() && line.includes(':') && (line.includes('Actual URL:') || line.includes('Canonical URL:') || line.includes('URL Slug Content:') || line.includes('Robots.txt Test Content:') || line.includes('XML Sitemap Test Content:') || line.includes('Favicon Test Content:') || line.includes('Doctype Test Content:') || line.includes('Meta Viewport Test Content:') || line.includes('HTTP Status Code Test Content:') || line.includes('Broken Links Test Content:') || line.includes('Headings Test Content:') || line.includes('Google Mobile Friendly Test Content:')));
    
    labelLines.forEach(line => {
        const colonIndex = line.indexOf(':');
        const label = line.substring(0, colonIndex + 1);
        doc.setFont(font, "medium").setFontSize(10);
        const labelWidth = doc.getTextWidth(label);
        maxLabelWidth = Math.max(maxLabelWidth, labelWidth);
    });
    
    // Add spacing between label and value
    const labelValueSpacing = 8;
    const valueStartX = x + padding + maxLabelWidth + labelValueSpacing;
    const rightMargin = padding; // Add proper right margin
    
    lines.forEach((line, index) => {
        if (line.trim()) {
            // Check if line contains a label (ends with colon)
            if (line.includes(':') && (line.includes('Actual URL:') || line.includes('Canonical URL:') || line.includes('URL Slug Content:') || line.includes('Robots.txt Test Content:') || line.includes('XML Sitemap Test Content:') || line.includes('Favicon Test Content:') || line.includes('Doctype Test Content:') || line.includes('Meta Viewport Test Content:') || line.includes('HTTP Status Code Test Content:') || line.includes('Broken Links Test Content:') || line.includes('Headings Test Content:') || line.includes('Google Mobile Friendly Test Content:'))) {
                // Split label and value
                const colonIndex = line.indexOf(':');
                const label = line.substring(0, colonIndex + 1);
                const value = line.substring(colonIndex + 1).trim();
                
                // Draw label with medium font weight
                doc.setFont(font, "medium").setFontSize(10).setTextColor(34, 34, 34);
                doc.text(label, x + padding, textY);
                
                // Draw value with normal font weight at consistent position
                if (value) {
                    doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                    // Wrap value text to respect right margin (use percentage-based width)
                    const baseValueWidth = width - valueStartX - rightMargin;
                    const maxValueWidth = baseValueWidth * TEXT_WIDTH_PERCENTAGE;
                    const valueLines = doc.splitTextToSize(value, maxValueWidth);
                    valueLines.forEach((valueLine, lineIndex) => {
                        // Ensure text doesn't go beyond box boundaries
                        doc.text(valueLine, valueStartX, textY + (lineIndex * lineSpacing));
                    });
                    // Adjust textY for multi-line values
                    textY += (valueLines.length - 1) * lineSpacing;
                }
            } else {
                // Regular text with normal font weight (this is the path for robots.txt content)
                doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                // Use percentage-based width for regular text to prevent overflow
                // This ensures text never exceeds 85% of available width
                const baseTextWidth = width - 2 * padding;
                const maxTextWidth = baseTextWidth * TEXT_WIDTH_PERCENTAGE;
                const textLines = doc.splitTextToSize(line, maxTextWidth);
                
                textLines.forEach((textLine, lineIndex) => {
                    // Verify each line fits before rendering
                    doc.setFont(font, "normal").setFontSize(10);
                    let finalText = textLine;
                    let actualWidth = doc.getTextWidth(finalText);
                    
                    // If text is still too wide, keep reducing until it fits
                    let attempts = 0;
                    while (actualWidth > maxTextWidth && attempts < 5) {
                        const reductionFactor = 0.95; // Reduce by 5% each attempt
                        const newWidth = maxTextWidth * Math.pow(reductionFactor, attempts + 1);
                        const reSplit = doc.splitTextToSize(finalText, newWidth);
                        finalText = reSplit[0] || finalText;
                        actualWidth = doc.getTextWidth(finalText);
                        attempts++;
                    }
                    
                    // Render the text
                    doc.text(finalText, x + padding, textY + (lineIndex * lineSpacing));
                });
                // Adjust textY for multi-line text
                textY += (textLines.length - 1) * lineSpacing;
            }
            
            textY += lineSpacing;
        }
    });

    // === 6. Return next Y position ===
    const lineY = boxY + boxHeight;
    
    // Reset font settings to default
    doc.setFont(font, "normal").setFontSize(10).setTextColor(0, 0, 0);
    
    return lineY + 10;
}
function renderCoverPage(doc, url, date, time) {
    const pageWidth = doc.internal.pageSize.width;
    const pageHeight = doc.internal.pageSize.height;
    const font = window.PDF_FONT_FAMILY || "Roboto";

    // === 1. Main Title ===
    doc.setFont(font, "medium");
    doc.setFontSize(24);
    doc.setTextColor(0, 102, 204);
    doc.text("Webpage Audit Report", pageWidth / 2, 80, { align: "center" });

    // === 3. URL ===
    doc.setFont(font, "normal");
    doc.setFontSize(12);
    doc.setTextColor(0, 0, 0);
    
    // Handle long URLs by wrapping them
    const urlText = url;
    const maxUrlWidth = pageWidth - 40; // Leave 20px margin on each side
    const urlLines = doc.splitTextToSize(urlText, maxUrlWidth);
    
    // Calculate starting Y position for URL (centered vertically around 120)
    const urlLineHeight = 7; // Line spacing for URL
    const totalUrlHeight = urlLines.length * urlLineHeight;
    let urlY = 120 - (totalUrlHeight / 2) + (urlLineHeight / 2);
    
    // Render each line of the URL, centered
    urlLines.forEach((line, index) => {
        doc.text(line, pageWidth / 2, urlY + (index * urlLineHeight), { align: "center" });
    });

    // === 4. Generated Date ===
    // Position date below URL, accounting for multi-line URLs
    const dateY = urlY + (urlLines.length * urlLineHeight) + 15; // 15px spacing after URL
    doc.setFontSize(10);
    doc.text(`Generated on ${date}`, pageWidth / 2, dateY, { align: "center" });

    // === 5. Logo ===
    const logoY = pageHeight - 51; // Moved down by 40% total (from original 80 to 51)
    const targetW = 60; // Even smaller logo size
    const targetH = 18; // Proportionally smaller height

    const base64Logo = window.PDF_IMAGES.COMPANY_LOGO; 
    // put full base64 string here

    doc.addImage(base64Logo, 'PNG', (pageWidth - targetW) / 2, logoY, targetW, targetH);

    // === 6. Prepared By text - REMOVED ===
    // Text removed as requested
}


function renderCoverPage_1(doc, url, date, time) {
    const pageWidth = doc.internal.pageSize.width;
    const pageHeight = doc.internal.pageSize.height;
    const font = window.PDF_FONT_FAMILY || "Roboto";

    // === 1. Main Title ===
    doc.setFont(font, "medium");
    doc.setFontSize(24);
    doc.setTextColor(0, 102, 204);
    doc.text("Webpage Audit Report", pageWidth / 2, 80, { align: "center" });

    // === 3. URL (Center Aligned) ===
    doc.setFont(font, "normal");
    doc.setFontSize(12);
    doc.setTextColor(0, 0, 0);
    doc.text(`URL: ${url}`, pageWidth / 2, 120, { align: "center" });

    // === 4. Generated Date (Center Aligned) ===
    doc.setFontSize(10);
    doc.text(`Generated on ${date}`, pageWidth / 2, 140, { align: "center" });

    // === 5. WebQA Logo (use pre-made data image instead of canvas) ===
    const logoY = pageHeight - 80;
    
    // 🔹 Replace this string with your actual base64 logo
    const logoDataUrl = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJoAAAAeCAYAAADU3gfZAAAACXBIWXMAABYlAAAWJQFJUiTwAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAsxSURBVHgB5VtPb9zGFX9Dcv0HSZt1nRpIYDfrSiqMopHWByOSLqFOPXqFfgBvP4GVW9G6kAzURW+2P4E29wKWP4GYiyXAh9BGb7bgLVCgQGPA20tja7mcvkdy11zyveFQWjuA8gNWq+UMZ4Yzb96f3xuq+aWVXQDwoYzg+ZO9NfgBsPrnl9ugoVsq0Kr/6M75y/AOML+4vAVKbTJF730e5n+z7IPjfAlKtzVAWwE0If3gtEAff/fxnxBi/fD5P/YDeIdY+Hy5qx21Xbg8iNTpy/0wGIAlPND6G5xgnynzW22/WaexmUFDRygI4ISC5tqLD2+icG1AIlQ6ua4K9fB3i6rjPz64amNuaaXvgAqGKr7dD/f7MGOgkN1gLuNY33Tx+x5Ywokc6EmFWWPvFcu3vvMh271FxEp/DScQc5+vdDz95gUK2RYIzy6BBE+D7rpa7c4vrmzADNFqL7eAt3bU8XWoASfbBcEsGpsFHMXuoMRs7v/l5wGcMKBw3FUOPICaAlaESrXcXXSFHpB2hBnA1bBpKPbn22jiLeEkf8l8Co3NatD2YM04nESzObe0uo3CMVMthEDteLh73HUjbaZAdYyVtNoES3j0J3LO3EPVzd5ka4sX2tfaMHLbXNn3H1zs/2v/70FVG4nZ1LrFlZ00szm/uIrzrbs2dbMAYIDfzcxHq7qjjetJDvw6HBGNEfjaqdSy1n58otGyigFbw9J8au3dpeiE+ww/vvag2dmu3GE/FrNJkVzmj5kQYJ01jO7OHTzZu4yR79XsW9F1rSs3Xuc4Plvs2GkrL35t1Ycz+U/HD4U6lebT5DTGjZ9AdPZis/mzX5jVcIIfh9msWMQBbu6viFJ5Hu4HnLag6wdP97tK6d8n9SUo2DyKCSV6xU5zUh/qpk21iaBFztmeVKkq+jQ5jd+f/wIajbPwyadLN0xtmMzmUMf34YSAtJlxEZVefx7uWdEGz8L9nlIRcXySsDVtNU4e2oUbNao3bYICb/wP7RyMWALgNFNqPg0Pz2si0maHP70Cv7x0jaIin4RJMoGJ2dRMAZrNx3+9EIIBrSvLrUYDfQqVX0A9QMcunDWhyfWltQpHrg5teCx0JWQNoPRt0lZQA8/Cx+F8e+U2zt1dvs2kvy2wRBIEaNXlyshcK869SYOCAAzwpm9A86kcn6knOn0Jcyzs0OHZi3DhwpVEoxGcNIoJgAUJKyNpSksmfcxa04P75TtRtF2K7GZDaCZsvZtMaKkvhV15KHnJRh2hsAjCnbgYGtiAiRz+g3B/C44A0oD4nDcFTZloHFsB9mIUTMUWBSPnzAYGGZy28ykYJKEHAU7+h8l8uqPXrI9l2qHOpd/CuXOf5S/d8DdelXyG1T/+py2azTjuFa+R0FPqLEuN+GBAntBMIuMjIIkQXSWl6vIgYdxNI8oyKJKTbqTNAMeAMrkXceW4J8D9wq8zRv2moDGOvS4YMCVopoYUk4pIdjnwO3T00a/gwqXV4uXmmw+ibqmy43S5NjizSVrB1W++BbCfPEIicNr7tg7JmMG3iBALnemthCMrIFZKFHSt4mPRN5GjduRSZbXBJP8x07a9tCl9m+1BwQ1T4OGUrsjRZ7vYkMlp/HD+dxOTWRjRdatryfWy2aTAw+RM06SAAehPbb8PElqhFi3SC7gYn0n1Izhj9EOrYHQLDP3mIeQ1p7RtZoK54KNpChpLgpaZT7ahvPnMmOMucAPG5/7w09WAKxsHBePfdcxmGnazfQ5Q5a/nOCdFoT8ndCSkR4nExv3gJ9Aa7tMHKhxghl4QBXwWhxfQRegDO4zq9JaJoiL/drojzZtpA+daErTsgdndlTefJn+D1Cs+9G2xGN76ddoVuDMu2nR5fzBS+upBuLeTX6w09E94JmYAdtxPATt0NIb4rYOnexv0of+x78sGLdo8hlC/VxgoqqCoLSmTJNQV858Od1HFIus8MZ8m0nGEgyMaQ0v+Hg5oHBQ42uHNb8FnyfrtlNtSPclsZGo+YIqaNQMDOpO2zmkd6ntETL0kbEp9mfslai1bc778h3+3Vm693KXvUlegWtw9Ve4E9S3lNTWT+jNmkjS/iT3u4tA9s4NhLPEyxYdvuvA/H00YddTi7k0Xfq+f/kAfS7Maq3n4YbSBk9VDzccueBxFvamBRq/bqNFK9fD+1gLjeL8tf3u2a6r9NC9r5RdFkmbMQMI2v/jFfVT5HJc1oYbQ3P5T8dQBLsRrGk8ABpBwOY1Tu+RqKPzG32v7f/ukT2UL7dU28lz8jRr+a2q3gS4R+mfN8m25IKAICgr4te1wVBgraBl5S4vgF8sc7V2P3VigWqbt+WnX6x1GI9J8zG5VN1XDGwgkbTiewEltRTQFC+S1hJLZwIqIJd8225wlKHX4EX4NHK1DLUlaSkEEICAvZMkF/HYKwiZDGzcUWSduVKg0BklelsOIgge2ZJz/3MpfE6qCGMbionakIAAK9jzYOodSrSV+p6m0s8n3cbxQf8awctJNzryr48v0PXQNGgv9RiM90GjcLQVNb4Wt9Sx8FGI66io7Xkfu15zX1G3poARzvHvqWcpDEJCF22z0Kd3D2fNTnic5jnQH25YeRTtgDzo+06/7Ua7Zb8lhZlSI8ZBpReBwynXRfKuyZpoStsdhMfdJz2rKCtTMa9qilP/0pJq0Q+cWlx8q6ehOAZI9J62GzmugbAlWxmwS0FgPWKODofbB06OlbizRsjlzlZHXLKY4MvkdDdIEmxik7HCpHJpHf+vV2mEU70LRr502oyG2sYbkNGUymqaMgymveWwU8p+Oqa4yvE9QrizTGSaqo1yXN5sj93TA1rfYCAu/vtaek3yNalhRFAbNMMgLaUYNiEJLAiKNlYTtlOes2Wo22vwlDiwHzGt24N3Bz0f2RkEzmM8SRgZHNj2xoawiPMlsSiE1+RdSbpFAuzZueA+QA9zGxPMLilBN2ocFapq59oq4KNS/5Lfi9annSaJPBaYotkljlcZZR9hG6vRVUyCD45D4xFruiNh+7E7mTAoeJ5hbXLmn5AFljajesyePjBTA6q3vtrDmpqkOmc1Hd85flYoX2stdSiEJ925Fzqn7ee1BC4WE8Dbn7BLRml8Ew3udE9Bz6lH8dRSlk+s2VBu1Ps2NL9+k1zgfyWZec42EdOyJTsmgqes9f/oo0VIrf3rZoxxjubrqx8NDYzQqvK9pHLMEw7NM3v90qhpRjq52zNWw8mBiFhSYtaMeGdt5lvqAvGbERDbSC6/oVEf2eUUnKTghM5G8xuHRGX9s0zutXtAne3vJN9yyIy0YZRaoHOx6JhOURof4nGMNvnfnY9x4UHY1cppNbFHIa1YFDxwMMjLJf1YKmiGJOkZoOoc0Rkp1gJG2iONRABVATbReMR4/+/ARbYXfwsDKdeD6wbF+ZapD2YYsZ1oPxxQ28/uaus7cJDBkYCb5z0pBI7APMi5T2nqiYpC1I6WrqonHlCKg3GZVWkXoI0kX1dJmKNh1+6L6jorWbfohzSYdAKgY15GFzXT0flR1UECC4Z0TojqsBE1SjcYUBQNj/jO2J2kn+UVd6xW8nSrnmMNIOS+oL7A2cxBQfRstPwa5BEkfyWGEGgKXCFt6FMlW2FJSmKdXjupSEAynfpL8Z2UwMAY54sVrxG3RqQmogeSBnYZfKoiHVhqtCDIDHmYr0OkgFU2+zNhk0kP3szNtQZXfkYbi5fdSh3BmciqEdqaOoYvc4hK8PfCZ9IOL/A1tyLr+DYe0H9VBB3spCQByfmb2jif194T6I2YgHwAhZ9nBMZbdBkcnryySoDWAPy09ZE5q1B035xOTnPwf2xLvVjRBWLQAAAAASUVORK5CYII=";  
    
    const targetW = 60; // Even smaller logo size
    const targetH = 18; // Proportionally smaller height  // mm
    doc.addImage(logoDataUrl, 'PNG', (pageWidth - targetW) / 2, logoY, targetW, targetH);

    // === 6. Prepared by text - REMOVED ===
    // Text removed as requested
}

// === Helper: Draw a rotated rounded rectangle ===
function drawRotatedRoundedRect(ctx, cx, cy, angleDeg, width, height, radius, fillStyle) {
	const rad = (Math.PI / 180) * angleDeg;
	ctx.save();
	ctx.translate(cx, cy);
	ctx.rotate(rad);
	ctx.fillStyle = fillStyle;
	drawRoundedRectPath(ctx, -width / 2, -height / 2, width, height, radius);
	ctx.fill();
	ctx.restore();
}

function drawRoundedRectPath(ctx, x, y, width, height, radius) {
	const r = Math.min(radius, width / 2, height / 2);
	ctx.beginPath();
	ctx.moveTo(x + r, y);
	ctx.lineTo(x + width - r, y);
	ctx.quadraticCurveTo(x + width, y, x + width, y + r);
	ctx.lineTo(x + width, y + height - r);
	ctx.quadraticCurveTo(x + width, y + height, x + width - r, y + height);
	ctx.lineTo(x + r, y + height);
	ctx.quadraticCurveTo(x, y + height, x, y + height - r);
	ctx.lineTo(x, y + r);
	ctx.quadraticCurveTo(x, y, x + r, y);
}

/* ---------- Header ---------- */
function renderHeaderSection(doc, url, date, time, y) {
    const font = window.PDF_FONT_FAMILY || "Roboto";
    doc.setFont(font, "medium").setFontSize(14).text("Analysis Report", 10, y);
    y += 10;

    doc.setFont(font, "normal").setFontSize(12);
    doc.text(`URL: ${url}`, 10, y); y += 10;
    doc.text(`Date: ${date}, ${time}`, 10, y); y += 10;
    doc.line(10, y, 200, y); y += 10;
    return y;
}

/* ========== SEPARATOR FUNCTION ========== */
// Add separator line between sections (conditional)
function addSeparatorLine(doc, y, shouldShow = true) {
    if (!shouldShow) return y; // Don't add separator if section is not visible
    
    const x = 10;
    const width = 190;
    
    // Ultra-minimal spacing before the line
    y += 1;
    
    // Draw a subtle separator line
    doc.setDrawColor(220, 220, 220); // Light gray
    doc.setLineWidth(0.1); // Reduced to 1mm thickness
    doc.line(x, y, x + width, y);
    
    // Ultra-minimal spacing after the line
    y += 1;
    
    return y;
}

/* ---------- Meta Title ---------- */
function renderMetaTitle(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="title"]');
    if (!el) return y;

    const rawContent = el.querySelector(".card-inner-content p")?.innerText || "N/A";
    const length = el.querySelector(".badge_pdf")?.innerText || "N/A";
    const casing = el.querySelector(".casing_pdf")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";

    const content = `Content: ${rawContent}`;

    return drawSection(doc, "Meta Title", content, length, casing, status, y, true);
}

/* ---------- Meta Description ---------- */
function renderMetaDescription(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="description"]');
    if (!el) return y;

    let rawContent = el.querySelector(".card-inner-content p")?.innerText || "N/A";
    const length = el.querySelector(".badge_pdf")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";

    if (length === "N/A") rawContent = "Meta description does not exist.";

    const content = `Content: ${rawContent}`;

    return drawSection(doc, "Meta Description", content, length, "", status, y, false);
}

/* ---------- Canonical URL ---------- */
function renderCanonicalURL(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="canonical"]');
    if (!el) return y;

    const actualUrl = el.querySelector(".card-actual-url p:nth-of-type(1)")?.innerText.replace("Actual URL", "").trim() || "N/A";
    let canonicalUrl = el.querySelector(".card-actual-url p:nth-of-type(2)")?.innerText.replace("Canonical URL", "").trim() || "N/A";
    if (canonicalUrl === "-") canonicalUrl = "Canonical URL Tag does not exist";

    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Use drawSectionNoLength without length display
    const content = `Actual URL: ${actualUrl}\n\nCanonical URL: ${canonicalUrl}`;
    return drawSectionNoLength(doc, "Canonical URL", content, status, y);
}

/* ---------- URL Slug ---------- */
function renderUrlSlug(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="url"]');
    if (!el) return y;

    const urlSlugContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Add label to match Meta Description styling
    const content = urlSlugContent;
    
    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "URL Slug", content, status, y);
}

/* ---------- Robots.txt Test ---------- */
function renderRobotsTxtTest(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="robot_text_test"]');
    if (!el) return y;

    const robotsTxtContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Add label to match Meta Description styling
    const content = robotsTxtContent;
    
    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "Robots.txt Test", content, status, y);
}

/* ---------- XML Sitemap Test ---------- */
function renderXmlSitemapTest(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="xml_sitemap"]');
    if (!el) return y;

    const xmlSitemapContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Add label to match Meta Description styling
    const content = xmlSitemapContent;
    
    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "XML Sitemap Test", content, status, y);
}

/* ---------- Favicon Test ---------- */
function renderFaviconTest(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="icon"]');
    if (!el) return y;

    const faviconContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Add label to match Meta Description styling
    const content = faviconContent;
    
    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "Favicon Test", content, status, y);
}

/* ---------- Doctype Test ---------- */
function renderDoctypeTest(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="doctype"]');
    if (!el) return y;

    const doctypeContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    const content = doctypeContent;
    
    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "Doctype Test", content, status, y);
}

/* ---------- Meta Viewport Test ---------- */
function renderMetaViewportTest(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="viewport"]');
    if (!el) return y;

    const viewportContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    const content = viewportContent;
    
    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "Meta Viewport Test", content, status, y);
}

/* ---------- HTTP Status Code Test ---------- */
function renderHttpStatusCodeTest(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="http_status_code"]');
    if (!el) return y;

    const httpStatusCodeContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    const content = httpStatusCodeContent;
    
    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "HTTP Status Code Test", content, status, y);
}

/* ---------- Broken Links Test ---------- */
function renderBrokenLinksTest(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="broken_links"]');
    if (!el) return y;

    // Try multiple selectors to get the message content reliably
    const messageSpan = el.querySelector(".card-single-content .message_pdf") || 
                       el.querySelector(".card-single-content span:nth-of-type(2)");
    const brokenLinksContent = messageSpan?.innerText?.trim() || "N/A";
    
    // Get status from the badge
    const statusBadge = el.querySelector(".card-single-content .status_pdf") || 
                       el.querySelector(".status_pdf");
    const status = statusBadge?.innerText?.trim() || "N/A";
    
    // Use the content directly without redundant prefix
    const content = brokenLinksContent;
    
    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "Broken Links Test", content, status, y);
}

/* ---------- Broken Links Table ---------- */
function addBrokenLinksTableToPDF(doc, y) {
    // Get the table from inside the broken-links-modal (not the card view)
    const modalElement = document.querySelector("#broken-links-modal");
    if (!modalElement) {
        return y; // Don't show anything if modal not found
    }
    
    const tableElement = modalElement.querySelector(".broken-links-table");
    if (!tableElement) {
        return y; // Don't show anything if table not found
    }

    // Headers for broken links table
    const headers = ["#", "URL", "HTTP Status Code"];
    
    // Get all data from the table
    let allData = [];
    const tableRows = tableElement.querySelectorAll("tbody tr");
    
    allData = Array.from(tableRows).map((row, index) => {
        const cells = row.querySelectorAll("td");
        // First column: URL (get from link href, broken-link-url span, or text)
        const urlCell = cells[0];
        let urlLink = "";
        if (urlCell) {
            const linkElement = urlCell.querySelector("a");
            if (linkElement) {
                // Prefer href attribute, fallback to broken-link-url span, then full text
                urlLink = linkElement.href || 
                         linkElement.querySelector(".broken-link-url")?.textContent.trim() || 
                         linkElement.textContent.trim();
                
                // Clean up URL if it has index prefix (e.g., "1. https://example.com" -> "https://example.com")
                if (urlLink && !urlLink.startsWith('http')) {
                    urlLink = urlLink.replace(/^\d+\.\s*/, '').trim();
                }
            } else {
                // No link, just get text content
                urlLink = urlCell.textContent.trim();
                // Clean up URL if it has index prefix
                if (urlLink && !urlLink.startsWith('http')) {
                    urlLink = urlLink.replace(/^\d+\.\s*/, '').trim();
                }
            }
        }
        
        // Second column: HTTP Status Code (get from strong tag or text)
        const statusCell = cells[1];
        const statusCode = statusCell ? (statusCell.querySelector("strong")?.textContent.trim() || statusCell.textContent.trim()) : "";
        
        return [
            (index + 1).toString(), // Serial number
            urlLink || "",
            statusCode || ""
        ];
    });
    
    // Only render table if there's data
    if (allData.length === 0) {
        return y;
    }

    doc.autoTable({
        startY: y - 4,
        head: [headers],
        body: allData,
        theme: "grid",
        styles: { 
            fontSize: 9, 
            cellPadding: 2, 
            valign: "middle", 
            halign: "left",
            lineColor: [232, 232, 232], // rgba(232, 232, 232, 1) - light gray border
            lineWidth: 0.1 // Previous border width
        },
        headStyles: { 
            fillColor: [213, 229, 255], // Custom background color: rgba(213, 229, 255, 1)
            textColor: [34, 34, 34], // rgba(34, 34, 34, 1) - dark gray text
            fontStyle: 'medium', // Font weight 500
            fontSize: 9, // 9px font size
            lineHeight: 1.0, // 100% line height
            halign: 'center'
        },
        didDrawCell: function(data) {
            const font = window.PDF_FONT_FAMILY || "Roboto";
            // Custom drawing for URL header to ensure left alignment
            if (data.section === 'head' && data.column.index === 1) {
                // Clear the cell first
                doc.setFillColor(213, 229, 255);
                doc.rect(data.cell.x, data.cell.y, data.cell.width, data.cell.height, 'F');
                
                // Draw border
                doc.setDrawColor(232, 232, 232);
                doc.setLineWidth(0.1);
                doc.rect(data.cell.x, data.cell.y, data.cell.width, data.cell.height);
                
                // Draw text left-aligned
                doc.setFont(font, 'medium');
                doc.setFontSize(9);
                doc.setTextColor(34, 34, 34);
                doc.text('URL', data.cell.x + 2, data.cell.y + data.cell.height/2 + 2);
            }
            
            // Add clickable links for URL column (index 1)
            if (data.section === 'body' && data.column.index === 1 && data.cell.text && data.cell.text[0]) {
                const url = data.cell.text[0];
                if (url && (url.startsWith('http') || url.startsWith('https'))) {
                    // Add clickable link area for the entire cell
                    doc.link(data.cell.x, data.cell.y, data.cell.width, data.cell.height, { url: url, target: '_blank' });
                }
            }
        },
        margin: { left: 10, right: 10 },
        columnStyles: {
            0: { halign: 'center', cellWidth: 20 }, // Serial number column (centered, narrow)
            1: { halign: 'left', cellWidth: 130 },  // URL column (left-aligned, wider)
            2: { halign: 'center', cellWidth: 40 }   // HTTP Status Code column (centered)
        }
    });

    return doc.lastAutoTable.finalY + 10;
}

/* ---------- Headings Test ---------- */
function renderHeadingsTest(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="h1_heading_tag"]');
    if (!el) return y;

    const headingsContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    const content = headingsContent;
    
    // Use custom function with dynamic height for Headings Test only
    return drawSectionNoLengthHeadings(doc, "Headings Test", content, status, y);
}

/* ---------- Headings Test with Dynamic Height ---------- */
function drawSectionNoLengthHeadings(doc, title, content, result, yPosition) {
    const x = 10;
    const width = 190;
    const padding = 6;
    const font = window.PDF_FONT_FAMILY || "Roboto";

    // === 1. Status Icon with Data Image ===
    const isPass = result.toUpperCase() === "PASS";
    const iconSize = 4;
    const iconX = x - 1;
    const iconY = yPosition + 7;
    
    const checkImage = window.PDF_IMAGES.CHECK_IMAGE;
    const crossImage = window.PDF_IMAGES.CROSS_IMAGE;
    const iconImage = isPass ? checkImage : crossImage;
    
    if (iconImage) {
        try {
            doc.addImage(iconImage, 'PNG', iconX, iconY, iconSize, iconSize);
        } catch (e) {
            console.log("Error loading icon image:", e);
            const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
            doc.setFillColor(...circleColor);
            doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
        }
    } else {
        const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
        doc.setFillColor(...circleColor);
        doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
    }

    // === 2. Title Alignment ===
    doc.setFont(font, "medium").setFontSize(12).setTextColor(34, 34, 34);
    const titleText = sanitizeTestTitle(title);
    doc.text(titleText, x + 5, yPosition + 10.2);

    // === 3. PASS Badge ===
    const resultUpper = result.toUpperCase();
    const scale = 0.7;
    const badgeTextWidth = doc.getTextWidth(resultUpper) * scale;
    const badgePadding = 5 * scale; 
    let badgeWidth = badgeTextWidth + badgePadding * 2;
    let badgeHeight = 8 * scale;

    badgeWidth *= 0.9;
    badgeHeight *= 1.1;
    const badgeX = x + width - badgeWidth - 0.5;
    const badgeY = yPosition + 6.8 - (badgeHeight * 0.1);

    const bgColor = resultUpper === "PASS" ? [223, 239, 217] : [248, 229, 229];
    const textColor = resultUpper === "PASS" ? [92, 174, 53] : [212, 100, 100];

    doc.setFillColor(...bgColor);
    roundedRect(doc, badgeX, badgeY, badgeWidth, badgeHeight, 0.8, "F");

    const reducedFont = 14 * scale * 0.9;
    doc.setFontSize(reducedFont).setFont("helvetica", "normal");
    doc.setTextColor(...textColor);

    const badgeTextX = badgeX + badgeWidth / 2 - doc.getTextWidth(resultUpper) * scale / 2 - 0.8 - (isPass ? badgeWidth * 0.04 : 0);
    const badgeTextY = badgeY + badgeHeight / 2 + (reducedFont / 6.5);
    doc.text(resultUpper, badgeTextX, badgeTextY);

    doc.setTextColor(0, 0, 0);

    // === 4. Content Box with Dynamic Height (Headings Test Only) ===
    const contentLines = doc.splitTextToSize(content, width - 2 * padding);
    
    // Fixed values for consistent spacing
    const lineSpacing = 6; // Space between lines
    const numberOfLines = contentLines.length;
    
    // Calculate total text height based on actual content
    const totalTextHeight = (numberOfLines * lineSpacing);
    
    // Set box height to fit content exactly with minimal padding
    const boxVerticalPadding = 8; // Top and bottom padding
    let boxHeight = totalTextHeight + boxVerticalPadding; // Dynamic height based on content

    const boxY = yPosition + 14;
    
    // Content box background
    doc.setFillColor(246, 248, 250);
    roundedRect(doc, x, boxY, width, boxHeight, 1.2, "F");

    // === 5. Properly Positioned Content Text ===
    // Calculate starting Y position to center text vertically within the box
    const totalContentHeight = numberOfLines * lineSpacing;
    const baselineOffset = 3.5; // Align baseline so text appears vertically centered
    const startY = boxY + (boxHeight - totalContentHeight) / 2 + baselineOffset;
    
    let textY = startY;
    
    // Parse content to apply medium font weight to labels
    const contentText = content;
    const lines = contentText.split('\n');
    
    // Calculate the maximum label width for consistent URL alignment
    let maxLabelWidth = 0;
    const labelLines = lines.filter(line => line.trim() && line.includes(':') && (line.includes('Actual URL:') || line.includes('Canonical URL:') || line.includes('URL Slug Content:') || line.includes('Robots.txt Test Content:') || line.includes('XML Sitemap Test Content:') || line.includes('Favicon Test Content:') || line.includes('Doctype Test Content:') || line.includes('Meta Viewport Test Content:') || line.includes('HTTP Status Code Test Content:') || line.includes('Broken Links Test Content:') || line.includes('Headings Test Content:') || line.includes('Google Mobile Friendly Test Content:')));
    
    labelLines.forEach(line => {
        const colonIndex = line.indexOf(':');
        const label = line.substring(0, colonIndex + 1);
        doc.setFont(font, "medium").setFontSize(10);
        const labelWidth = doc.getTextWidth(label);
        maxLabelWidth = Math.max(maxLabelWidth, labelWidth);
    });
    
    // Add spacing between label and value
    const labelValueSpacing = 8;
    const valueStartX = x + padding + maxLabelWidth + labelValueSpacing;
    const rightMargin = padding; // Add proper right margin
    
    lines.forEach((line, index) => {
        if (line.trim()) {
            // Check if line contains a label (ends with colon)
            if (line.includes(':') && (line.includes('Actual URL:') || line.includes('Canonical URL:') || line.includes('URL Slug Content:') || line.includes('Robots.txt Test Content:') || line.includes('XML Sitemap Test Content:') || line.includes('Favicon Test Content:') || line.includes('Doctype Test Content:') || line.includes('Meta Viewport Test Content:') || line.includes('HTTP Status Code Test Content:') || line.includes('Broken Links Test Content:') || line.includes('Headings Test Content:') || line.includes('Google Mobile Friendly Test Content:'))) {
                // Split label and value
                const colonIndex = line.indexOf(':');
                const label = line.substring(0, colonIndex + 1);
                const value = line.substring(colonIndex + 1).trim();
                
                // Draw label with medium font weight
                doc.setFont(font, "medium").setFontSize(10).setTextColor(34, 34, 34);
                doc.text(label, x + padding, textY);
                
                // Draw value with normal font weight at consistent position
                if (value) {
                    doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                    // Wrap value text to respect right margin
                    const maxValueWidth = width - valueStartX - rightMargin;
                    const valueLines = doc.splitTextToSize(value, maxValueWidth);
                    valueLines.forEach((valueLine, lineIndex) => {
                        doc.text(valueLine, valueStartX, textY + (lineIndex * lineSpacing));
                    });
                    // Adjust textY for multi-line values
                    textY += (valueLines.length - 1) * lineSpacing;
                }
            } else {
                // Regular text with normal font weight
                doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
                // Wrap regular text to respect right margin
                const maxTextWidth = width - x - padding - rightMargin;
                const textLines = doc.splitTextToSize(line, maxTextWidth);
                textLines.forEach((textLine, lineIndex) => {
                    doc.text(textLine, x + padding, textY + (lineIndex * lineSpacing));
                });
                // Adjust textY for multi-line text
                textY += (textLines.length - 1) * lineSpacing;
            }
            
            textY += lineSpacing;
        }
    });

    // === 6. Return next Y position ===
    const lineY = boxY + boxHeight;
    return lineY + 10;
}

/* ---------- Headings Table ---------- */
function renderHeadingsTable(doc, y) {
    const tableElement = document.querySelector('.table-headings-collapse');
    if (!tableElement) {
        return y; // Don't show anything if table not found
    }

    // Get table headers from the first row
    const headerRow = tableElement.querySelector('thead tr') || tableElement.querySelector('tr');
    const headers = Array.from(headerRow.querySelectorAll('th, td')).map(cell => cell.textContent.trim());
    
    // Find the index of the "Content" column (case-insensitive)
    const contentColumnIndex = headers.findIndex(header => header.toLowerCase().includes('content'));
    
    // Get table data from all rows
    const tableRows = tableElement.querySelectorAll('tbody tr');
    const data = Array.from(tableRows).map(row => {
        const cells = row.querySelectorAll('td');
        return Array.from(cells).map(cell => {
            // Clone the cell to avoid modifying the original DOM
            const cellClone = cell.cloneNode(true);
            // Remove all button elements from the clone
            const buttons = cellClone.querySelectorAll('button');
            buttons.forEach(btn => btn.remove());
            // Return the text content without buttons
            return cellClone.textContent.trim();
        });
    });

    // Prepare column styles - left-align content column if found
    const columnStyles = {};
    if (contentColumnIndex !== -1) {
        columnStyles[contentColumnIndex] = { halign: 'left' };
    }

    doc.autoTable({
        startY: y - 5,
        head: [headers],
        body: data,
        theme: "grid",
        styles: { 
            fontSize: 9, 
            cellPadding: 2, 
            valign: "middle", 
            halign: "center",
            lineColor: [232, 232, 232],
            lineWidth: 0.1
        },
        headStyles: { 
            fillColor: [213, 229, 255],
            textColor: [34, 34, 34],
            fontStyle: 'medium',
            fontSize: 9,
            lineHeight: 1.0,
            halign: 'center'
        },
        didParseCell: function(data) {
            // Left-align header and cells for content column
            if (contentColumnIndex !== -1 && data.column.index === contentColumnIndex) {
                data.cell.styles.halign = 'left';
            }
        },
        columnStyles: columnStyles,
        margin: { left: 10, right: 10 }
    });

    return doc.lastAutoTable.finalY + 10;
}

/* ---------- Robots Meta ---------- */
function renderRobotsMeta(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="robots"]');
    if (!el) return y;

    const robotsContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    const content = robotsContent;

    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "Robots Meta", content, status, y);
}

/* ---------- Open Graph Test ---------- */
function renderOpenGraphTest(doc, y) {
    // Get Open Graph data from the page using specific class names
    const ogTitle = document.querySelector('.og_title_tag')?.textContent?.trim() || '';
    const ogDescription = document.querySelector('.og_description')?.textContent?.trim() || '';
    const ogUrl = document.querySelector('.og_url')?.textContent?.trim() || '';
    const ogImage = document.querySelector('.og_image')?.textContent?.trim() || '';
    const ogContent = document.querySelector('.og_content')?.textContent?.trim() || '';
    
    // Get status from og_badge class
    const ogBadge = document.querySelector('.og_badge')?.textContent?.trim() || '';
    
    // Determine if we have Open Graph data
    const hasOgData = ogTitle || ogDescription || ogUrl || ogBadge;
    
    if (!hasOgData) {
        return y; // Don't show section if no Open Graph data found
    }

    // Use status from og_badge, fallback to "N/A"
    const status = ogBadge || "N/A";

    // Create structured content data
    const contentData = [];
    
    // Add introductory text if available
    if (ogContent) {
        contentData.push({ label: "", value: ogContent, isIntroText: true });
    }
    
    if (ogTitle) contentData.push({ label: "OG Title Tag:", value: ogTitle });
    if (ogDescription) contentData.push({ label: "OG Description:", value: ogDescription });
    if (ogUrl) contentData.push({ label: "Og URL:", value: ogUrl });
    if (ogImage) contentData.push({ label: "OG Image:", value: "Open Image", link: ogImage }); // Display "Open Image" with clickable link
    contentData.push({ label: "OG Type:", value: "Website" });

    // Use custom Open Graph function with proper spacing
    return drawOpenGraphSection(doc, "Open Graph Tags", contentData, status, y);
}

/* ---------- Twitter Test ---------- */
function renderTwitterTest(doc, y) {
    // Get Twitter data from the page using specific class names
    const twitterTitle = document.querySelector('.twitter_title')?.textContent?.trim() || '';
    const twitterImage = document.querySelector('.twitter_image')?.textContent?.trim() || '';
    const twitterImageAlt = document.querySelector('.twitter_image_alt')?.textContent?.trim() || '';
    const twitterContent = document.querySelector('.twitter_content')?.textContent?.trim() || '';
    // Get status from twitter_badge class
    const twitterBadge = document.querySelector('.twitter_badge')?.textContent?.trim() || '';
    
    // Determine if we have Twitter data
    const hasTwitterData = twitterTitle || twitterImage || twitterImageAlt || twitterBadge;
    
    if (!hasTwitterData) {
        return y; // Don't show section if no Twitter data found
    }

    // Use status from twitter_badge, fallback to "N/A"
    const status = twitterBadge || "N/A";

    // Create structured content data
    const contentData = [];
    
    // Add introductory text if available
    if (twitterContent) {
        contentData.push({ label: "", value: twitterContent, isIntroText: true });
    }
    
    if (twitterTitle) contentData.push({ label: "Twitter Title Tag:", value: twitterTitle });
    if (twitterImage) contentData.push({ label: "Twitter Image:", value: "Open Image", link: twitterImage }); // Display "Open Image" with clickable link
    if (twitterImageAlt) contentData.push({ label: "Twitter Image Alt:", value: twitterImageAlt });

    // Use custom Twitter function with proper spacing
    return drawTwitterSection(doc, "Twitter Tags", contentData, status, y);
}
function drawTwitterSection(doc, title, contentData, result, yPosition) {
    const x = 10;
    const width = 190;
    const padding = 5;
    const font = window.PDF_FONT_FAMILY || "helvetica";

    // === 1. Status Icon ===
    const isPass = result.toUpperCase() === "PASS";
    const iconSize = 4;
    const iconX = x - 1;
    const iconY = yPosition + 7;
    const checkImage = window.PDF_IMAGES.CHECK_IMAGE;
    const crossImage = window.PDF_IMAGES.CROSS_IMAGE;
    const iconImage = isPass ? checkImage : crossImage;

    if (iconImage) {
        try {
            doc.addImage(iconImage, "PNG", iconX, iconY, iconSize, iconSize);
        } catch (e) {
            console.log("Error loading icon image:", e);
            const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
            doc.setFillColor(...circleColor);
            doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
        }
    }

    // === 2. Title ===
    doc.setFont(font, "medium").setFontSize(11).setTextColor(34, 34, 34);
    const titleText = sanitizeTestTitle(title);
    doc.text(titleText, x + 5, yPosition + 10.2);

    // === 3. PASS/FAIL Badge ===
    const resultUpper = result.toUpperCase();
    const scale = 0.7;
    const badgeTextWidth = doc.getTextWidth(resultUpper) * scale;
    const badgePadding = 5 * scale;
    let badgeWidth = badgeTextWidth + badgePadding * 2;
    let badgeHeight = 8 * scale;
    badgeWidth *= 0.9;
    badgeHeight *= 1.1;

    const badgeX = x + width - badgeWidth - 0.5;
    const badgeY = yPosition + 6.8 - badgeHeight * 0.1;

    const bgColor = resultUpper === "PASS" ? [223, 239, 217] : [248, 229, 229];
    const textColor = resultUpper === "PASS" ? [92, 174, 53] : [212, 100, 100];

    doc.setFillColor(...bgColor);
    roundedRect(doc, badgeX, badgeY, badgeWidth, badgeHeight, 0.8, "F");

    const reducedFont = 14 * scale * 0.9;
    doc.setFontSize(reducedFont).setFont(font, "normal");
    doc.setTextColor(...textColor);
    const badgeTextX =
        badgeX +
        badgeWidth / 2 -
        (doc.getTextWidth(resultUpper) * scale) / 2 -
        0.8 -
        (isPass ? badgeWidth * 0.04 : 0);
    const badgeTextY = badgeY + badgeHeight / 2 + reducedFont / 6.5;
    doc.text(resultUpper, badgeTextX, badgeTextY);
    doc.setTextColor(0, 0, 0);

    // === 4. Content Box ===
    const labelValueStartX = x + padding + 38;
    const availableContentWidth = width - labelValueStartX - padding;

    let totalContentLines = 0;
    const lineHeight = 4;
    let introTextLines = 0;

    contentData.forEach((item) => {
        if (item.isIntroText) {
            introTextLines = 1;
        } else {
            const valueLines = doc.splitTextToSize(item.value, availableContentWidth);
            totalContentLines += Math.max(1, valueLines.length);
        }
    });

    const itemSpacing = Math.max(0, contentData.length - 1) * 4;
    const boxHeight =
        12 + (introTextLines + totalContentLines) * lineHeight + itemSpacing;

    const boxY = yPosition + 14;
    doc.setFillColor(249, 249, 249);
    roundedRect(doc, x, boxY, width, boxHeight, 1.2, "F");

    // === 5. Content Text ===
    let textY = boxY + 8;
    doc.setFontSize(10).setTextColor(34, 34, 34);

    contentData.forEach((item) => {
        if (item.isIntroText) {
            doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
            const singleLineText = item.value
                .replace(/\n/g, " ")
                .replace(/\s+/g, " ")
                .trim();
            doc.text(singleLineText, x + padding, textY);
            textY += lineHeight + 6;
        } else {
            const labelWeight =
                font === "Roboto" && window.ROBOTO_FONTS && window.ROBOTO_FONTS.medium
                    ? "medium"
                    : "normal";
            const labelFontSize =
                font === "Roboto" && window.ROBOTO_FONTS && window.ROBOTO_FONTS.medium
                    ? 10
                    : 9.5;
            doc.setFont(font, labelWeight).setFontSize(labelFontSize).setTextColor(34, 34, 34);
            doc.text(item.label, x + padding, textY);

            // === ✅ Handle clickable link or normal text ===
            doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
            if (item.link) {
                // Make "Open Image" clickable
                doc.setTextColor(0, 0, 255);
                doc.textWithLink(item.value, labelValueStartX, textY, { url: item.link });

                // Optional: underline link
                const textWidth = doc.getTextWidth(item.value);
                doc.setDrawColor(0, 0, 255);
                doc.line(
                    labelValueStartX,
                    textY + 0.8,
                    labelValueStartX + textWidth,
                    textY + 0.8
                );

                // Reset color
                doc.setTextColor(34, 34, 34);
            } else {
                const valueLines = doc.splitTextToSize(item.value, availableContentWidth);
                valueLines.forEach((line, lineIndex) => {
                    doc.text(line, labelValueStartX, textY + lineIndex * lineHeight);
                });
            }

            textY += lineHeight + 4;
        }
    });

    return boxY + boxHeight + 15;
}

/* ---------- Custom Twitter Section Function ---------- */
function drawTwitterSection_1(doc, title, contentData, result, yPosition) {
    const x = 10;
    const width = 190;
    const padding = 5; // Increased padding for better spacing
    const font = window.PDF_FONT_FAMILY || "helvetica"; // Use Roboto if available, fallback to Helvetica

    // === 1. Status Icon ===
    const isPass = result.toUpperCase() === "PASS";
    const iconSize = 4;
    const iconX = x - 1;
    const iconY = yPosition + 7;
    // Use data images for PASS/FAIL icons
    const checkImage = window.PDF_IMAGES.CHECK_IMAGE;
    const crossImage = window.PDF_IMAGES.CROSS_IMAGE;

    const iconImage = isPass ? checkImage : crossImage;
    
    // Add the data image to PDF
    if (iconImage) {
        try {
            doc.addImage(iconImage, 'PNG', iconX, iconY, iconSize, iconSize);
        } catch (e) {
            console.log("Error loading icon image:", e);
            // Fallback to colored circle
            const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
            doc.setFillColor(...circleColor);
            doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
        }
    }

    // === 2. Title (Normal weight, not bold) ===
    doc.setFont(font, "medium").setFontSize(11).setTextColor(34, 34, 34);
    const titleText = sanitizeTestTitle(title);
    doc.text(titleText, x + 5, yPosition + 10.2);

    // === 3. PASS Badge ===
    const resultUpper = result.toUpperCase();
    const scale = 0.7;
    const badgeTextWidth = doc.getTextWidth(resultUpper) * scale;
    const badgePadding = 5 * scale; 
    let badgeWidth = badgeTextWidth + badgePadding * 2;
    let badgeHeight = 8 * scale;

    // ✅ Apply same badge styling as drawSection
    badgeWidth *= 0.9;         // reduce width by 10% for better text centering
    badgeHeight *= 1.1;        // increase height by 10%
    const badgeX = x + width - badgeWidth - 0.5;
    const badgeY = yPosition + 6.8 - (badgeHeight * 0.1); // move badge 10% up

    // ✅ Updated colors to match drawSection
    const bgColor = resultUpper === "PASS" ? [223, 239, 217] : [248, 229, 229];
    const textColor = resultUpper === "PASS" ? [92, 174, 53] : [212, 100, 100];

    // ✅ Rounded badge (small radius)
    doc.setFillColor(...bgColor);
    roundedRect(doc, badgeX, badgeY, badgeWidth, badgeHeight, 0.8, "F");

    // ✅ Text adjustments - reduce font size by 10%
    const reducedFont = 14 * scale * 0.9;
    doc.setFontSize(reducedFont).setFont(font, "normal");
    doc.setTextColor(...textColor);

    // ✅ Center text in badge - perfect centering
    const badgeTextX = badgeX + badgeWidth / 2 - doc.getTextWidth(resultUpper) * scale / 2 - 0.8 - (isPass ? badgeWidth * 0.04 : 0);
    const badgeTextY = badgeY + badgeHeight / 2 + (reducedFont / 6.5);
    doc.text(resultUpper, badgeTextX, badgeTextY);
    doc.setTextColor(0, 0, 0);

    // === 4. Content Box ===
    const labelValueStartX = x + padding + 38; // Fixed start for values
    const availableContentWidth = width - labelValueStartX - padding; // Width for value text
    
    // Calculate total lines needed
    let totalContentLines = 0;
    const lineHeight = 4; // Reduced line height for tighter spacing
    
    let introTextLines = 0;
    let labelValueItems = 0;
    
    contentData.forEach(item => {
        if (item.isIntroText) {
            introTextLines = 1; // Always single line for intro text
        } else {
            const valueLines = doc.splitTextToSize(item.value, availableContentWidth);
            totalContentLines += Math.max(1, valueLines.length);
            labelValueItems++;
        }
    });

    // Add spacing between items (reduced by 30%: 6px -> 4px)
    const itemSpacing = Math.max(0, (contentData.length - 1)) * 4;
    let boxHeight = 12 + (introTextLines + totalContentLines) * lineHeight + itemSpacing; // Base height + lines * line height + spacing

    const boxY = yPosition + 14; // Gap between title and content box
    
    // ✅ Content box background with rounded corners
    doc.setFillColor(249, 249, 249);
    roundedRect(doc, x, boxY, width, boxHeight, 1.2, "F");

    // === 5. Content Text ===
    let textY = boxY + 8; // Top padding inside the box
    doc.setFontSize(10).setTextColor(34, 34, 34);

    contentData.forEach(item => {
        if (item.isIntroText) {
            // Handle introductory text (no label, full width, single line)
            doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
            // Remove any line breaks and display as single line
            const singleLineText = item.value.replace(/\n/g, ' ').replace(/\s+/g, ' ').trim();
            doc.text(singleLineText, x + padding, textY);
            textY += lineHeight + 6; // Single line height + extra spacing after intro text
        } else {
            // Draw label (medium font weight - 500, or lighter fallback)
            const labelWeight = (font === "Roboto" && window.ROBOTO_FONTS && window.ROBOTO_FONTS.medium) ? "medium" : "normal";
            const labelFontSize = (font === "Roboto" && window.ROBOTO_FONTS && window.ROBOTO_FONTS.medium) ? 10 : 9.5; // Slightly smaller for lighter appearance
            doc.setFont(font, labelWeight).setFontSize(labelFontSize).setTextColor(34, 34, 34);
            doc.text(item.label, x + padding, textY);

            // Draw value (normal font - 400 weight)
            doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
            const valueLines = doc.splitTextToSize(item.value, availableContentWidth);
            valueLines.forEach((line, lineIndex) => {
                doc.text(line, labelValueStartX, textY + (lineIndex * lineHeight));
            });
            
            // Reduced spacing between labels: 4px (reduced by 30% from 6px)
            textY += Math.max(1, valueLines.length) * lineHeight + 4; // Advance Y for next item with 4px spacing
        }
    });

    return boxY + boxHeight + 15; // Increased spacing between sections
}

/* ---------- Custom Open Graph Section Function ---------- */
function drawOpenGraphSection(doc, title, contentData, result, yPosition) {
    const x = 10;
    const width = 190;
    const padding = 5; // Increased padding for better spacing
    const font = window.PDF_FONT_FAMILY || "helvetica"; // Use Roboto if available, fallback to Helvetica

    // === 1. Status Icon ===
    const isPass = result.toUpperCase() === "PASS";
    const iconSize = 4;
    const iconX = x - 1;
    const iconY = yPosition + 7;
    const checkImage = window.PDF_IMAGES.CHECK_IMAGE;
    const crossImage = window.PDF_IMAGES.CROSS_IMAGE;
    // Use data images for PASS/FAIL icons
    
    const iconImage = isPass ? checkImage : crossImage;
    
    // Add the data image to PDF
    if (iconImage) {
        try {
            doc.addImage(iconImage, 'PNG', iconX, iconY, iconSize, iconSize);
        } catch (e) {
            console.log("Error loading icon image:", e);
            // Fallback to colored circle
            const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
            doc.setFillColor(...circleColor);
            doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
        }
    }

    // === 2. Title (Normal weight, not bold) ===
    doc.setFont(font, "medium").setFontSize(11).setTextColor(34, 34, 34);
    const titleText = sanitizeTestTitle(title);
    doc.text(titleText, x + 5, yPosition + 10.2);

    // === 3. PASS Badge ===
    const resultUpper = result.toUpperCase();
    const scale = 0.7;
    const badgeTextWidth = doc.getTextWidth(resultUpper) * scale;
    const badgePadding = 5 * scale; 
    let badgeWidth = badgeTextWidth + badgePadding * 2;
    let badgeHeight = 8 * scale;

    // ✅ Apply same badge styling as drawSection
    badgeWidth *= 0.9;         // reduce width by 10% for better text centering
    badgeHeight *= 1.1;        // increase height by 10%
    const badgeX = x + width - badgeWidth - 0.5;
    const badgeY = yPosition + 6.8 - (badgeHeight * 0.1); // move badge 10% up

    // ✅ Updated colors to match drawSection
    const bgColor = resultUpper === "PASS" ? [223, 239, 217] : [248, 229, 229];
    const textColor = resultUpper === "PASS" ? [92, 174, 53] : [212, 100, 100];

    // ✅ Rounded badge (small radius)
    doc.setFillColor(...bgColor);
    roundedRect(doc, badgeX, badgeY, badgeWidth, badgeHeight, 0.8, "F");

    // ✅ Text adjustments - reduce font size by 10%
    const reducedFont = 14 * scale * 0.9;
    doc.setFontSize(reducedFont).setFont(font, "normal");
    doc.setTextColor(...textColor);

    // ✅ Center text in badge - perfect centering
    const badgeTextX = badgeX + badgeWidth / 2 - doc.getTextWidth(resultUpper) * scale / 2 - 0.8 - (isPass ? badgeWidth * 0.04 : 0);
    const badgeTextY = badgeY + badgeHeight / 2 + (reducedFont / 6.5);
    doc.text(resultUpper, badgeTextX, badgeTextY);
    doc.setTextColor(0, 0, 0);

    // === 4. Content Box ===
    const labelValueStartX = x + padding + 38; // Fixed start for values
    const availableContentWidth = width - labelValueStartX - padding; // Width for value text
    
    // Calculate total lines needed
    let totalContentLines = 0;
    const lineHeight = 4; // Reduced line height for tighter spacing
    
    let introTextLines = 0;
    let labelValueItems = 0;
    
    contentData.forEach(item => {
        if (item.isIntroText) {
            introTextLines = 1; // Always single line for intro text
        } else {
            const valueLines = doc.splitTextToSize(item.value, availableContentWidth);
            totalContentLines += Math.max(1, valueLines.length);
            labelValueItems++;
        }
    });

    // Add spacing between items (reduced by 30%: 6px -> 4px)
    const itemSpacing = Math.max(0, (contentData.length - 1)) * 4;
    let boxHeight = 12 + (introTextLines + totalContentLines) * lineHeight + itemSpacing; // Base height + lines * line height + spacing

    const boxY = yPosition + 14; // Gap between title and content box
    
    // ✅ Content box background with rounded corners
    doc.setFillColor(249, 249, 249);
    roundedRect(doc, x, boxY, width, boxHeight, 1.2, "F");

    // === 5. Content Text ===
    let textY = boxY + 8; // Top padding inside the box
    doc.setFontSize(10).setTextColor(34, 34, 34);

    contentData.forEach(item => {
        if (item.isIntroText) {
            // Handle introductory text (no label, full width, single line)
            doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
            // Remove any line breaks and display as single line
            const singleLineText = item.value.replace(/\n/g, ' ').replace(/\s+/g, ' ').trim();
            doc.text(singleLineText, x + padding, textY);
            textY += lineHeight + 6; // Single line height + extra spacing after intro text
        } else {
            // Draw label (medium font weight - 500)
            doc.setFont(font, "medium").setFontSize(10).setTextColor(34, 34, 34);
            doc.text(item.label, x + padding, textY);

            // Draw value (normal font)
            doc.setFont(font, "normal").setFontSize(10).setTextColor(34, 34, 34);
            const valueLines = doc.splitTextToSize(item.value, availableContentWidth);
            
            // Check if this item has a link (for clickable "Open Image")
            if (item.link) {
                // Draw text as a link with blue color
                doc.setTextColor(0, 102, 204); // Blue color for links
                valueLines.forEach((line, lineIndex) => {
                    const lineY = textY + (lineIndex * lineHeight);
                    const textWidth = doc.getTextWidth(line);
                    doc.text(line, labelValueStartX, lineY);
                    // Add clickable link area that opens in new tab
                    doc.link(labelValueStartX, lineY - 10, textWidth, 12, { url: item.link, target: '_blank' });
                });
                doc.setTextColor(34, 34, 34); // Reset to default color
            } else {
                // Draw normal text
            valueLines.forEach((line, lineIndex) => {
                doc.text(line, labelValueStartX, textY + (lineIndex * lineHeight));
            });
            }
            
            // Reduced spacing between labels: 4px (reduced by 30% from 6px)
            textY += Math.max(1, valueLines.length) * lineHeight + 4; // Advance Y for next item with 4px spacing
        }
    });

    return boxY + boxHeight + 15; // Increased spacing between sections
}

/* ---------- Images Header ---------- */
function renderImagesHeader(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="img"]');
    if (!el) return y;

    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    const x = 10;
    const width = 190;
    const font = window.PDF_FONT_FAMILY || "Roboto";

    // === 1. Status Icon ===
    const isPass = status.toUpperCase() === "PASS";
    const iconSize = 4;
    const iconX = x - 1;
    const iconY = y + 7;
    
    const checkImage = window.PDF_IMAGES.CHECK_IMAGE;
    const crossImage = window.PDF_IMAGES.CROSS_IMAGE;
    const iconImage = isPass ? checkImage : crossImage;
    
    if (iconImage) {
        try {
            doc.addImage(iconImage, 'PNG', iconX, iconY, iconSize, iconSize);
        } catch (e) {
            console.log("Error loading icon image:", e);
            const circleColor = isPass ? [40, 167, 69] : [220, 53, 69];
            doc.setFillColor(...circleColor);
            doc.circle(iconX + 2.5, iconY + 2.5, 2.5, "F");
        }
    }

    // === 2. Title ===
    doc.setFont(font, "medium").setFontSize(12).setTextColor(34, 34, 34);
    doc.text("Images", x + 5, y + 10.2);

    // === 3. PASS/FAIL Badge ===
    const resultUpper = status.toUpperCase();
    const scale = 0.7;
    const badgeTextWidth = doc.getTextWidth(resultUpper) * scale;
    const badgePadding = 5 * scale; 
    let badgeWidth = badgeTextWidth + badgePadding * 2;
    let badgeHeight = 8 * scale;

    badgeWidth *= 0.9;
    badgeHeight *= 1.1;
    const badgeX = x + width - badgeWidth - 0.5;
    const badgeY = y + 6.8 - (badgeHeight * 0.1);

    const bgColor = resultUpper === "PASS" ? [223, 239, 217] : [248, 229, 229];
    const textColor = resultUpper === "PASS" ? [92, 174, 53] : [212, 100, 100];

    doc.setFillColor(...bgColor);
    roundedRect(doc, badgeX, badgeY, badgeWidth, badgeHeight, 0.8, "F");

    const reducedFont = 14 * scale * 0.9;
    doc.setFontSize(reducedFont).setFont("helvetica", "normal");
    doc.setTextColor(...textColor);

    const badgeTextX = badgeX + badgeWidth / 2 - doc.getTextWidth(resultUpper) * scale / 2 - 0.8 - (isPass ? badgeWidth * 0.04 : 0);
    const badgeTextY = badgeY + badgeHeight / 2 + (reducedFont / 6.5);
    doc.text(resultUpper, badgeTextX, badgeTextY);

    doc.setTextColor(0, 0, 0);

    // Return Y position for next section (no content box, just header) - reduced to compensate for table's +10px spacing
    return y + 4;
}

/* ---------- Image Table ---------- */
function addTableToPDF(doc, y) {
    const tableElement = document.querySelector(".custom-dataTable");
    if (!tableElement) {
        return y; // Don't show anything if table not found
    }

    // Updated headers to match data order (removed Status column)
    const headers = ["#", "Image Link", "Alt Text", "File Name", "File Size", "Issues"];
    
    // Get all data from all pages by checking if DataTable is available
    let allData = [];
    let dataTable = null;
    let originalPageLength = null;
    
    // Check if jQuery DataTables is available and table has DataTable instance
    if (typeof $ !== 'undefined' && $.fn.DataTable && $(tableElement).hasClass('custom-dataTable')) {
        try {
            dataTable = $(tableElement).DataTable();
            if (dataTable) {
                console.log("DataTable instance found");
                
                // Store original page length
                originalPageLength = dataTable.page.len();
                console.log("Original page length:", originalPageLength);
                
                // Temporarily show all rows
                dataTable.page.len(-1).draw();
                
                // Wait a moment for DOM to update (DataTables draw is async)
                // Get all visible rows after showing all
                const tableRows = tableElement.querySelectorAll("tbody tr");
                console.log("All visible rows after showing all:", tableRows.length);
                
                allData = Array.from(tableRows).map((row, index) => {
                    const cells = row.querySelectorAll("td");
                    return [
                        (index + 1).toString(), // # - Auto increment number starting from 1
                        cells[0] ? (cells[0].querySelector("a")?.href || "") : "", // Image Link - Show actual URL
                        cells[1]?.textContent.trim() || "", // Alt Text
                        cells[3]?.textContent.trim() || "", // File Size
                        cells[8]?.textContent.trim() || "", // File Name
                        cells[6]?.textContent.trim() || ""  // Issues
                    ];
                });
                
                // Restore original page length
                if (originalPageLength !== null) {
                    dataTable.page.len(originalPageLength).draw();
                    console.log("Restored original page length");
                }
            } else {
                throw new Error("DataTable instance not found");
            }
        } catch (error) {
            console.log("Error with DataTable approach:", error);
            // Fallback to visible rows only
            const tableRows = tableElement.querySelectorAll("tbody tr");
            console.log("Fallback: visible rows count:", tableRows.length);
            allData = Array.from(tableRows).map((row, index) => {
                const cells = row.querySelectorAll("td");
                return [
                    (index + 1).toString(), // # - Auto increment number starting from 1
                    cells[0] ? (cells[0].querySelector("a")?.href || "") : "", // Image Link - Show actual URL
                    cells[1]?.textContent.trim() || "", // Alt Text
                    cells[3]?.textContent.trim() || "", // File Size
                    cells[8]?.textContent.trim() || "", // File Name
                    cells[6]?.textContent.trim() || ""  // Issues
                ];
            });
        }
    } else {
        // Fallback: get visible rows only (no DataTable)
        const tableRows = tableElement.querySelectorAll("tbody tr");
        console.log("No DataTable found, using visible rows count:", tableRows.length);
        allData = Array.from(tableRows).map((row, index) => {
            const cells = row.querySelectorAll("td");
            return [
                (index + 1).toString(), // # - Auto increment number starting from 1
                cells[0] ? (cells[0].querySelector("a")?.href || "") : "", // Image Link - Show actual URL
                cells[1]?.textContent.trim() || "", // Alt Text
                cells[3]?.textContent.trim() || "", // File Size
                cells[8]?.textContent.trim() || "", // File Name
                cells[6]?.textContent.trim() || ""  // Issues
            ];
        });
    }
    
    console.log("Final allData length:", allData.length);

    doc.autoTable({
        startY: y + 10,
        head: [headers],
        body: allData,
        theme: "grid",
        styles: { 
            fontSize: 9, 
            cellPadding: 2, 
            valign: "middle", 
            halign: "left",
            lineColor: [232, 232, 232], // rgba(232, 232, 232, 1) - light gray border
            lineWidth: 0.1 // Previous border width
        },
        headStyles: { 
            fillColor: [213, 229, 255], // Custom background color: rgba(213, 229, 255, 1)
            textColor: [34, 34, 34], // rgba(34, 34, 34, 1) - dark gray text
            fontStyle: 'medium', // ✅ Font weight 500
            fontSize: 9, // 12px font size
            lineHeight: 1.0, // 100% line height
            halign: 'center'
        },
        didDrawCell: function(data) {
            const font = window.PDF_FONT_FAMILY || "Roboto";
            // Custom drawing for Image Link header to ensure left alignment
            if (data.section === 'head' && data.column.index === 1) {
                // Clear the cell first
                doc.setFillColor(213, 229, 255);
                doc.rect(data.cell.x, data.cell.y, data.cell.width, data.cell.height, 'F');
                
                // Draw border
                doc.setDrawColor(232, 232, 232);
                doc.setLineWidth(0.1);
                doc.rect(data.cell.x, data.cell.y, data.cell.width, data.cell.height);
                
                // Draw text left-aligned
                doc.setFont(font, 'medium');
                doc.setFontSize(9);
                doc.setTextColor(34, 34, 34);
                doc.text('Image Link', data.cell.x + 2, data.cell.y + data.cell.height/2 + 2);
            }
            
            // Add clickable links for Image Link column (index 1)
            if (data.section === 'body' && data.column.index === 1 && data.cell.text && data.cell.text[0]) {
                const url = data.cell.text[0];
                if (url && url.startsWith('http')) {
                    // Add clickable link area for the entire cell
                    doc.link(data.cell.x, data.cell.y, data.cell.width, data.cell.height, { url: url, target: '_blank' });
                }
            }
        },
        margin: { left: 10, right: 10 },
        columnStyles: {
            0: { halign: 'center', cellWidth: 15 }, // # column centered and narrow
            1: { halign: 'left', cellWidth: 70 }, // Image Link column (left-aligned)
            2: { halign: 'left', cellWidth: 30 }, // Alt Text column  
            3: { halign: 'left', cellWidth: 40 }, // File Name column
            4: { halign: 'center', cellWidth: 20 }, // File Size column
            5: { halign: 'center', cellWidth: 15 }  // Issues column (was index 6, now index 5)
        }
    });

    return doc.lastAutoTable.finalY + 10;
}
/* ---------- Header ---------- */
function renderPerformanceHeaderSection(doc, y) {
    // Title: Performance
    const x = 10;
    const width = 190;
    const font = window.PDF_FONT_FAMILY || "Roboto";
    doc.setFont(font, "medium");
    doc.setFontSize(12);
    doc.text("Performance", x, y);
    y += 8;
    
    // Add separator line after Performance title
    doc.setDrawColor(220, 220, 220); // light gray color (consistent with other separators)
    doc.setLineWidth(0.1); // 1mm thickness (consistent with other separators)
    doc.line(x, y, x + width, y);
    y += 8; // Increased spacing after separator to prevent overlap
    
    return y;
}
function renderPerformanceSection(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="google_overall"]');
    if (!el) return y;
    const desktopScore = parseInt(document.querySelector(".overallDesktop")?.textContent || "N/A");
    const mobileScore = parseInt(document.querySelector(".overallMobile")?.textContent || "N/A");

    // Title
    const x = 10;
    const font = window.PDF_FONT_FAMILY || "Roboto";
    doc.setFont(font, "normal");
    doc.text("Google Page speed overall score", x, y);
    y += 6;

    // Set font color based on score
    const getColor = (score) => {
        if (isNaN(score)) return [0, 0, 0]; // default black
        if (score >= 90) return [0, 128, 0]; // green
        if (score >= 50) return [255, 165, 0]; // orange
        return [255, 0, 0]; // red
    };

    // Table headers and data
    const headers = ["Desktop", "Mobile"];
    const data = [[
        !isNaN(desktopScore) ? desktopScore.toString() : "N/A",
        !isNaN(mobileScore) ? mobileScore.toString() : "N/A"
    ]];

    doc.autoTable({
        startY: y,
        head: [headers],
        body: data,
        theme: "grid",
        margin: { left: 10, right: 10 }, // Equal left and right margins
        styles: { 
            fontSize: 9, 
            cellPadding: 2, 
            valign: "middle", 
            halign: "center",
            lineColor: [232, 232, 232], // rgba(232, 232, 232, 1) - light gray border
            lineWidth: 0.1 // Previous border width
        },
        headStyles: { 
            fillColor: [213, 229, 255], // Custom background color: rgba(213, 229, 255, 1)
            textColor: [34, 34, 34], // rgba(34, 34, 34, 1) - dark gray text
            fontStyle: 'medium', // Font weight 500
            fontSize: 9, // Same as image table
            lineHeight: 1.0, // 100% line height
            halign: 'center'
        },
        columnStyles: {
            0: { halign: 'center', cellWidth: 95 }, // Desktop column
            1: { halign: 'center', cellWidth: 95 }  // Mobile column
        },
        didDrawCell(cellData) {
            // Apply color coding to score cells (body rows only)
            if (cellData.section === 'body') {
                const cellValue = parseInt(cellData.cell.text[0]);
                if (!isNaN(cellValue)) {
                    const [r, g, b] = getColor(cellValue);
                    // Clear the cell first to prevent overlap
                    doc.setFillColor(255, 255, 255);
                    doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height, 'F');
                    
                    // Redraw border
                    doc.setDrawColor(232, 232, 232);
                    doc.setLineWidth(0.1);
                    doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height);
                    
                    // Draw text with correct color
                    doc.setTextColor(r, g, b);
                    doc.setFontSize(9);
                    const textValue = cellData.cell.text[0];
                    if (textValue !== undefined && textValue !== null && textValue !== '') {
                        doc.text(textValue, cellData.cell.x + cellData.cell.width/2, cellData.cell.y + cellData.cell.height/2 + 2, { align: 'center' });
                    }
                    doc.setTextColor(0, 0, 0); // Reset color
                }
            }
        }
    });

    return doc.lastAutoTable.finalY + 10;
}



function renderLighthouseScoreTable(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="google_lighthouse"]');
    if (!el) return y;

    const performanceDesktop = parseInt(document.querySelector(".performanceDesktop")?.textContent || "N/A");
    const accessibilityDesktop = parseInt(document.querySelector(".accessibilityDesktop")?.textContent || "N/A");
    const bestPracticesDesktop = parseInt(document.querySelector(".bestPracticesDesktop")?.textContent || "N/A");
    const seoDesktop = parseInt(document.querySelector(".seoDesktop")?.textContent || "N/A");

    const performanceMobile = parseInt(document.querySelector(".performanceMobile")?.textContent || "N/A");
    const accessibilityMobile = parseInt(document.querySelector(".accessibilityMobile")?.textContent || "N/A");
    const bestPracticesMobile = parseInt(document.querySelector(".bestPracticesMobile")?.textContent || "N/A");
    const seoMobile = parseInt(document.querySelector(".seoMobile")?.textContent || "N/A");

    // Title
    const x = 10;
    const font = window.PDF_FONT_FAMILY || "Roboto";
    doc.setFont(font, "normal");
    doc.text("Lighthouse Score", x, y);
    y += 6;

    // Set font color based on score
    const getColor = (score) => {
        if (isNaN(score)) return [0, 0, 0]; // default black
        if (score >= 90) return [0, 128, 0]; // green
        if (score >= 50) return [255, 165, 0]; // orange
        return [255, 0, 0]; // red
    };

    // Table headers and data
    const headers = ["", "Performance", "Accessibility", "SEO", "Best Practices"];
    const data = [
        [
            "Desktop",
            !isNaN(performanceDesktop) ? performanceDesktop.toString() : "N/A",
            !isNaN(accessibilityDesktop) ? accessibilityDesktop.toString() : "N/A",
            !isNaN(seoDesktop) ? seoDesktop.toString() : "N/A",
            !isNaN(bestPracticesDesktop) ? bestPracticesDesktop.toString() : "N/A"
        ],
        [
            "Mobile",
            !isNaN(performanceMobile) ? performanceMobile.toString() : "N/A",
            !isNaN(accessibilityMobile) ? accessibilityMobile.toString() : "N/A",
            !isNaN(seoMobile) ? seoMobile.toString() : "N/A",
            !isNaN(bestPracticesMobile) ? bestPracticesMobile.toString() : "N/A"
        ]
    ];

    doc.autoTable({
        startY: y,
        head: [headers],
        body: data,
        theme: "grid",
        margin: { left: 10, right: 10 }, // Equal left and right margins
        styles: { 
            fontSize: 11, 
            cellPadding: 2, 
            valign: "middle", 
            halign: "center",
            lineColor: [232, 232, 232], // rgba(232, 232, 232, 1) - light gray border
            lineWidth: 0.1 // Previous border width
        },
        headStyles: { 
            fillColor: [213, 229, 255], // Custom background color: rgba(213, 229, 255, 1)
            textColor: [34, 34, 34], // rgba(34, 34, 34, 1) - dark gray text
            fontStyle: 'normal', // Medium weight
            fontSize: 9, // Same as other tables
            lineHeight: 1.0, // 100% line height
            halign: 'center'
        },
        columnStyles: {
            0: { halign: 'center', cellWidth: 38 }, // Device column
            1: { halign: 'center', cellWidth: 38 }, // Performance column
            2: { halign: 'center', cellWidth: 38 }, // Accessibility column
            3: { halign: 'center', cellWidth: 38 }, // SEO column
            4: { halign: 'center', cellWidth: 38 }  // Best Practices column
        },
        didDrawCell(cellData) {
            // Apply color coding to score cells (body rows only, exclude first column)
            if (cellData.section === 'body' && cellData.column.index > 0) {
                const cellValue = parseInt(cellData.cell.text[0]);
                if (!isNaN(cellValue)) {
                    const [r, g, b] = getColor(cellValue);
                    // Clear the cell first to prevent overlap
                    doc.setFillColor(255, 255, 255);
                    doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height, 'F');
                    
                    // Redraw border
                    doc.setDrawColor(232, 232, 232);
                    doc.setLineWidth(0.1);
                    doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height);
                    
                    // Draw text with correct color
                    doc.setTextColor(r, g, b);
                    doc.setFontSize(9);
                    const textValue = cellData.cell.text[0];
                    if (textValue !== undefined && textValue !== null && textValue !== '') {
                        doc.text(textValue, cellData.cell.x + cellData.cell.width/2, cellData.cell.y + cellData.cell.height/2 + 2, { align: 'center' });
                    }
                    doc.setTextColor(0, 0, 0); // Reset color
                }
            }
            
            // Apply Roboto font styles to "Desktop" and "Mobile" headers
            if (cellData.section === 'head' && cellData.column.index === 0) {
                const cellText = cellData.cell.text[0];
                const font = window.PDF_FONT_FAMILY || "Roboto";
                if (cellText === "Desktop" || cellText === "Mobile") {
                    // Clear the cell first to prevent overlap
                    doc.setFillColor(213, 229, 255);
                    doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height, 'F');
                    
                    // Redraw border
                    doc.setDrawColor(232, 232, 232);
                    doc.setLineWidth(0.1);
                    doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height);
                    
                    // Apply Roboto font styles
                    doc.setFont(font, 'normal');
                    doc.setFontSize(11); // Reduced font size for better appearance
                    doc.setTextColor(34, 34, 34); // rgba(34, 34, 34, 1)
                    if (cellText !== undefined && cellText !== null && cellText !== '') {
                        doc.text(cellText, cellData.cell.x + cellData.cell.width/2, cellData.cell.y + cellData.cell.height/2 + 2, { align: 'center' });
                    }
                    doc.setTextColor(0, 0, 0); // Reset color
                }
            }
        }
    });

    return doc.lastAutoTable.finalY + 10;
}

/* ---------- Google Mobile Friendly Test ---------- */
function renderGoogleMobileFriendlyTest(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="mobile_friendly"]');
    if (!el) return y;

    const mobileFriendlyContent = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Show only content without label
    const content = mobileFriendlyContent;
    
    // Use drawSectionNoLength without length display
    return drawSectionNoLength(doc, "Mobile Friendliness Test", content, status, y);
}

function renderCoreWebVitalsTable(doc, y) {
    const el = document.querySelector('.analysis-card[data-name="core_web_vitals"]');
    if (!el) return y;
    const x = 10;
    const width = 190;
    const rowHeight = 12;
    const columnCount = 3;
    const cellWidth = width / columnCount;
    const font = window.PDF_FONT_FAMILY || "Roboto";


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
    doc.setFont(font, "normal");
    doc.text("Core Web vitals", x, y);
    y += 6;

    // Table headers and data
    const headers = ["Metric", "Desktop", "Mobile"];
    const data = [
        ["FCP\nFirst contentful paint", fcpDesktop, fcpMobile],
        ["TTI\nTime to Interactive", ttiDesktop, ttiMobile],
        ["SI\nSpeed Index", siDesktop, siMobile],
        ["TBT\nTotal Blocking time", tbtDesktop, tbtMobile],
        ["LCP\nLargest contentful paint", lcpDesktop, lcpMobile],
        ["CLS\nCumulative Layout Shift", clsDesktop, clsMobile]
    ];

    doc.autoTable({
        startY: y,
        head: [headers],
        body: data,
        theme: "grid",
        margin: { left: 10, right: 10 }, // Equal left and right margins
        styles: { 
            fontSize: 9, 
            cellPadding: 2, 
            valign: "middle", 
            halign: "center",
            lineColor: [232, 232, 232], // rgba(232, 232, 232, 1) - light gray border
            lineWidth: 0.1 // Previous border width
        },
        headStyles: { 
            fillColor: [213, 229, 255], // Custom background color: rgba(213, 229, 255, 1)
            textColor: [34, 34, 34], // rgba(34, 34, 34, 1) - dark gray text
            fontStyle: 'normal', // Medium weight
            fontSize: 9, // Same as other tables
            lineHeight: 1.0, // 100% line height
            halign: 'center'
        },
        columnStyles: {
            0: { halign: 'left', cellWidth: 63 }, // Metric column (wider for descriptions)
            1: { halign: 'center', cellWidth: 63 }, // Desktop column
            2: { halign: 'center', cellWidth: 63 }  // Mobile column
        },
        didDrawCell(cellData) {
            // Apply color coding to score cells (body rows only, exclude first column)
            if (cellData.section === 'body' && cellData.column.index > 0) {
                const cellValue = cellData.cell.text[0];
                const [r, g, b] = getVitalsColor(cellValue);
                
                // Clear the cell first to prevent overlap
                doc.setFillColor(255, 255, 255);
                doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height, 'F');
                
                // Redraw border
                doc.setDrawColor(232, 232, 232);
                doc.setLineWidth(0.1);
                doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height);
                
                // Draw text with correct color
                doc.setTextColor(r, g, b);
                doc.setFontSize(9);
                if (cellValue !== undefined && cellValue !== null && cellValue !== '') {
                    doc.text(cellValue, cellData.cell.x + cellData.cell.width/2, cellData.cell.y + cellData.cell.height/2 + 2, { align: 'center' });
                }
                doc.setTextColor(0, 0, 0); // Reset color
            }
        }
    });

    return doc.lastAutoTable.finalY + 10;

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
    const practices = [];
    const font = window.PDF_FONT_FAMILY || "Roboto";

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

    if (practices.length === 0) return y; // No data to display

    // Title
    const x = 10;
    y += 8; // Add spacing before heading to prevent overlap with previous section
    doc.setFont(font, "medium").setFontSize(12);
    doc.text("Best Practices", x, y);
    y += 12; // Increased spacing to prevent separator overlap

    // Helper: Color logic for status
    const getStatusColor = (status) => {
        const isPass = status.toLowerCase() === "pass";
        return isPass ? [0, 128, 0] : [255, 0, 0]; // Green for PASS, Red for FAIL
    };

    // Table headers and data
    const headers = ["Test", "Description", "Status"];

    doc.autoTable({
        startY: y,
        head: [headers],
        body: practices,
        theme: "grid",
        margin: { left: 10, right: 10 }, // Equal left and right margins
        styles: { 
            fontSize: 9, 
            cellPadding: 2, 
            valign: "middle", 
            halign: "left",
            lineColor: [232, 232, 232], // rgba(232, 232, 232, 1) - light gray border
            lineWidth: 0.1 // Previous border width
        },
        headStyles: { 
            fillColor: [213, 229, 255], // Custom background color: rgba(213, 229, 255, 1)
            textColor: [34, 34, 34], // rgba(34, 34, 34, 1) - dark gray text
            fontStyle: 'normal', // Medium weight
            fontSize: 9, // Same as other tables
            lineHeight: 1.0, // 100% line height
            halign: 'center'
        },
        columnStyles: {
            0: { halign: 'left', cellWidth: 50 }, // Test column
            1: { halign: 'left', cellWidth: 100 }, // Description column (wider)
            2: { halign: 'center', cellWidth: 40 }  // Status column
        },
        didDrawCell(cellData) {
            // Apply color coding to status cells (body rows only, last column)
            if (cellData.section === 'body' && cellData.column.index === 2) {
                const status = cellData.cell.text[0];
                const [r, g, b] = getStatusColor(status);
                
                // Clear the cell first to prevent overlap
                doc.setFillColor(255, 255, 255);
                doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height, 'F');
                
                // Redraw border
                doc.setDrawColor(232, 232, 232);
                doc.setLineWidth(0.1);
                doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height);
                
                // Draw text with correct color
                doc.setTextColor(r, g, b);
                doc.setFontSize(9);
                if (status !== undefined && status !== null && status !== '') {
                    doc.text(status, cellData.cell.x + cellData.cell.width/2, cellData.cell.y + cellData.cell.height/2 + 2, { align: 'center' });
                }
                doc.setTextColor(0, 0, 0); // Reset color
            }
        }
    });

    return doc.lastAutoTable.finalY + 10;
}

function renderSecurityTable(doc, y) {
    const practices = [];
    const font = window.PDF_FONT_FAMILY || "Roboto";

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

    if (practices.length === 0) return y; // No data to display

    // Title
    const x = 10;
    doc.setFont(font, "medium").setFontSize(12);
    doc.text("Security", x, y);
    y += 6;

    // Helper: Color logic for status
    const getStatusColor = (status) => {
        const isPass = status.toLowerCase() === "pass";
        return isPass ? [0, 128, 0] : [255, 0, 0]; // Green for PASS, Red for FAIL
    };

    // Table headers and data
    const headers = ["Test", "Description", "Status"];

    doc.autoTable({
        startY: y,
        head: [headers],
        body: practices,
        theme: "grid",
        margin: { left: 10, right: 10 }, // Equal left and right margins
        styles: { 
            fontSize: 9, 
            cellPadding: 2, 
            valign: "middle", 
            halign: "left",
            lineColor: [232, 232, 232], // rgba(232, 232, 232, 1) - light gray border
            lineWidth: 0.1 // Previous border width
        },
        headStyles: { 
            fillColor: [213, 229, 255], // Custom background color: rgba(213, 229, 255, 1)
            textColor: [34, 34, 34], // rgba(34, 34, 34, 1) - dark gray text
            fontStyle: 'normal', // Medium weight
            fontSize: 9, // Same as other tables
            lineHeight: 1.0, // 100% line height
            halign: 'center'
        },
        columnStyles: {
            0: { halign: 'left', cellWidth: 50 }, // Test column
            1: { halign: 'left', cellWidth: 100 }, // Description column (wider)
            2: { halign: 'center', cellWidth: 40 }  // Status column
        },
        didDrawCell(cellData) {
            // Apply color coding to status cells (body rows only, last column)
            if (cellData.section === 'body' && cellData.column.index === 2) {
                const status = cellData.cell.text[0];
                const [r, g, b] = getStatusColor(status);
                
                // Clear the cell first to prevent overlap
                doc.setFillColor(255, 255, 255);
                doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height, 'F');
                
                // Redraw border
                doc.setDrawColor(232, 232, 232);
                doc.setLineWidth(0.1);
                doc.rect(cellData.cell.x, cellData.cell.y, cellData.cell.width, cellData.cell.height);
                
                // Draw text with correct color
                doc.setTextColor(r, g, b);
                doc.setFontSize(9);
                if (status !== undefined && status !== null && status !== '') {
                    doc.text(status, cellData.cell.x + cellData.cell.width/2, cellData.cell.y + cellData.cell.height/2 + 2, { align: 'center' });
                }
                doc.setTextColor(0, 0, 0); // Reset color
            }
        }
    });

    return doc.lastAutoTable.finalY + 10;
}

/* ---------- SEO Header Section ---------- */
function renderSEOHeader(doc, y) {
    const x = 10;
    const width = 190;
    const font = window.PDF_FONT_FAMILY || "Roboto";
    
    // === 1. SEO Title ===
    doc.setFont(font, "medium");
    doc.setFontSize(16);
    doc.setTextColor(0, 0, 0);
    doc.text("SEO", x, y + 10);
    
    // === 2. Separator Line ===
    const lineY = y + 15;
    doc.setDrawColor(220, 220, 220); // light gray color (consistent with other separators)
    doc.setLineWidth(0.1); // Reduced to 1mm thickness (consistent with other separators)
    doc.line(x, lineY, x + width, lineY);
    
    return lineY + 10; // return position after separator line
}

/* ---------- Header ---------- */
function checkPageBreak(doc, y, buffer = 60) {
    const pageHeight = doc.internal.pageSize.height || doc.internal.pageSize.getHeight();
    if (y + buffer > pageHeight) {
        doc.addPage();
        return 10; // Reset y to top margin
    }
    return y;
}
