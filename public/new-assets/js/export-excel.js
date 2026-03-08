$(document).on("click", ".export-excel-button", function () {
    // Check if ExcelJS is available
    if (typeof ExcelJS === 'undefined') {
        console.error("ExcelJS library is not loaded");
        return;
    }

    exportToExcel();
});

async function exportToExcel() {
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet("SEO Analysis");

    // Get project URL and date
    const projectUrl = document.querySelector(".project-url")?.getAttribute("href") || "N/A";
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleDateString("en-GB");
    const formattedTime = currentDate.toLocaleTimeString("en-GB");

    let currentRow = 1;

    // === META TITLE SECTION ===
    const metaTitleData = getMetaTitleData();
    if (metaTitleData) {
        currentRow = addMetaTitleSection(worksheet, metaTitleData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === META DESCRIPTION SECTION ===
    const metaDescriptionData = getMetaDescriptionData();
    if (metaDescriptionData) {
        currentRow = addMetaDescriptionSection(worksheet, metaDescriptionData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === ROBOTS META TAG SECTION ===
    const robotsMetaData = getRobotsMetaData();
    if (robotsMetaData) {
        currentRow = addRobotsMetaSection(worksheet, robotsMetaData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === CANONICAL URL SECTION ===
    const canonicalUrlData = getCanonicalUrlData();
    if (canonicalUrlData) {
        currentRow = addCanonicalUrlSection(worksheet, canonicalUrlData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === IMAGES SECTION ===
    const imagesData = getImagesData();
    if (imagesData && imagesData.length > 0) {
        currentRow = addImagesSection(worksheet, imagesData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === OPEN GRAPH TAGS SECTION ===
    const openGraphData = getOpenGraphData();
    if (openGraphData) {
        currentRow = addOpenGraphSection(worksheet, openGraphData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === TWITTER TAGS SECTION ===
    const twitterTagsData = getTwitterTagsData();
    if (twitterTagsData) {
        currentRow = addTwitterTagsSection(worksheet, twitterTagsData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === ROBOTS.TXT TEST SECTION ===
    const robotsTxtData = getRobotsTxtData();
    if (robotsTxtData) {
        currentRow = addRobotsTxtSection(worksheet, robotsTxtData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === FAVICON TEST SECTION ===
    const faviconData = getFaviconData();
    if (faviconData) {
        currentRow = addFaviconSection(worksheet, faviconData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === URL SLUG SECTION ===
    const urlSlugData = getUrlSlugData();
    if (urlSlugData) {
        currentRow = addUrlSlugSection(worksheet, urlSlugData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === META VIEWPORT SECTION ===
    const metaViewportData = getMetaViewportData();
    if (metaViewportData) {
        currentRow = addMetaViewportSection(worksheet, metaViewportData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === DOCTYPE SECTION ===
    const doctypeData = getDoctypeData();
    if (doctypeData) {
        currentRow = addDoctypeSection(worksheet, doctypeData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === HTTP STATUS CODE SECTION ===
    const httpStatusCodeData = getHttpStatusCodeData();
    if (httpStatusCodeData) {
        currentRow = addHttpStatusCodeSection(worksheet, httpStatusCodeData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === GOOGLE PAGE SPEED OVERALL SCORE SECTION ===
    const googlePageSpeedData = getGooglePageSpeedData();
    if (googlePageSpeedData) {
        currentRow = addGooglePageSpeedSection(worksheet, googlePageSpeedData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === LIGHTHOUSE SECTION ===
    const lighthouseData = getLighthouseData();
    if (lighthouseData) {
        currentRow = addLighthouseSection(worksheet, lighthouseData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === CORE WEB VITALS SECTION ===
    const coreWebVitalsData = getCoreWebVitalsData();
    if (coreWebVitalsData) {
        currentRow = addCoreWebVitalsSection(worksheet, coreWebVitalsData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === MOBILE FRIENDLINESS SECTION ===
    const mobileFriendlinessData = getMobileFriendlinessData();
    if (mobileFriendlinessData) {
        currentRow = addMobileFriendlinessSection(worksheet, mobileFriendlinessData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === GZIP COMPRESSION SECTION ===
    const gzipCompressionData = getGzipCompressionData();
    if (gzipCompressionData) {
        currentRow = addGzipCompressionSection(worksheet, gzipCompressionData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === HTML COMPRESSION SECTION ===
    const htmlCompressionData = getHtmlCompressionData();
    if (htmlCompressionData) {
        currentRow = addHtmlCompressionSection(worksheet, htmlCompressionData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === CSS COMPRESSION SECTION ===
    const cssCompressionData = getCssCompressionData();
    if (cssCompressionData) {
        currentRow = addCssCompressionSection(worksheet, cssCompressionData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === JS COMPRESSION SECTION ===
    const jsCompressionData = getJsCompressionData();
    if (jsCompressionData) {
        currentRow = addJsCompressionSection(worksheet, jsCompressionData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === CSS CACHING SECTION ===
    const cssCachingData = getCssCachingData();
    if (cssCachingData) {
        currentRow = addCssCachingSection(worksheet, cssCachingData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === JS CACHING SECTION ===
    const jsCachingData = getJsCachingData();
    if (jsCachingData) {
        currentRow = addJsCachingSection(worksheet, jsCachingData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === PAGE SIZE SECTION ===
    const pageSizeData = getPageSizeData();
    if (pageSizeData) {
        currentRow = addPageSizeSection(worksheet, pageSizeData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === NESTED TABLES SECTION ===
    const nestedTablesData = getNestedTablesData();
    if (nestedTablesData) {
        currentRow = addNestedTablesSection(worksheet, nestedTablesData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === FRAMESET SECTION ===
    const framesetData = getFramesetData();
    if (framesetData) {
        currentRow = addFramesetSection(worksheet, framesetData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === BROKEN LINK TEST SECTION ===
    const brokenLinksData = getBrokenLinksData();
    if (brokenLinksData && brokenLinksData.length > 0) {
        currentRow = addBrokenLinksSection(worksheet, brokenLinksData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === UNSAFE CROSS ORIGIN LINKS SECTION ===
    const unsafeCrossOriginLinksData = getUnsafeCrossOriginLinksData();
    if (unsafeCrossOriginLinksData !== null) {
        // Show section even if empty (will show PASS result)
        const linksToShow = unsafeCrossOriginLinksData.length > 0 ? unsafeCrossOriginLinksData : [];
        currentRow = addUnsafeCrossOriginLinksSection(worksheet, linksToShow, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === PROTOCOL RELATIVE RESOURCE LINKS SECTION ===
    const protocolRelativeResourceLinksData = getProtocolRelativeResourceLinksData();
    if (protocolRelativeResourceLinksData !== null) {
        // Show section even if empty (will show PASS result)
        const linksToShow = protocolRelativeResourceLinksData.length > 0 ? protocolRelativeResourceLinksData : [];
        currentRow = addProtocolRelativeResourceLinksSection(worksheet, linksToShow, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === SAFE BROWSING SECTION ===
    const safeBrowsingData = getSafeBrowsingData();
    if (safeBrowsingData) {
        currentRow = addSafeBrowsingSection(worksheet, safeBrowsingData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === X FRAME OPTIONS HEADER TEST SECTION ===
    const xFrameOptionsHeaderData = getXFrameOptionsHeaderData();
    if (xFrameOptionsHeaderData) {
        currentRow = addXFrameOptionsHeaderSection(worksheet, xFrameOptionsHeaderData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === HSTS HEADER SECTION ===
    const hstsHeaderData = getHstsHeaderData();
    if (hstsHeaderData) {
        currentRow = addHstsHeaderSection(worksheet, hstsHeaderData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === BAD CONTENT TYPE SECTION ===
    const badContentTypeData = getBadContentTypeData();
    if (badContentTypeData) {
        currentRow = addBadContentTypeSection(worksheet, badContentTypeData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === SSL CERTIFICATE SECTION ===
    const sslCertificateData = getSslCertificateData();
    if (sslCertificateData) {
        currentRow = addSslCertificateSection(worksheet, sslCertificateData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // === DIRECTORY BROWSING SECTION ===
    const directoryBrowsingData = getDirectoryBrowsingData();
    if (directoryBrowsingData) {
        currentRow = addDirectoryBrowsingSection(worksheet, directoryBrowsingData, currentRow);
        currentRow += 1; // Add spacing between sections
    }

    // Set column widths
    worksheet.columns = [
        { width: 24 }, // Column A - increased by 20% (from 20 to 24)
        { width: 45.5 },  // Column B - increased by 30% (from 35 to 45.5)
        { width: 30 }, // Column C - Image Link (decreased by 50% from 60 to 30)
        { width: 60 }, // Column D - Content (reduced)
        { width: 18 }, // Column E - Words separated by spaces? (reduced)
        { width: 40 }, // Column F - File Name (increased) - getCell(4) = Column D = index 3
        { width: 20 }, // Column G - LEN (reduced) - getCell(5) = Column E = index 4
        { width: 20 }, // Column H - Words separated by hyphens? - getCell(6) = Column F = index 5
        { width: 25 }, // Column I - Uppercase characters? (getCell(7) = Column G = index 6, increased to prevent text cutting)
        { width: 12 }, // Column J - Special characters? (reduced) - getCell(8) = Column H = index 7
        { width: 20 }, // Column K - File Size
        { width: 15 }  // Column L - Result
    ];

    // Generate filename with current date and time
    const now = new Date();
    const dateStr = now.toISOString().split('T')[0]; // YYYY-MM-DD format
    const timeStr = now.toTimeString().split(' ')[0].replace(/:/g, '-'); // HH-MM-SS format
    const filename = `webpage_analysis_report_${dateStr}_${timeStr}.xlsx`;

    // Download the file
    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
    const url = window.URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = filename;
    a.click();

    setTimeout(() => URL.revokeObjectURL(url), 500);
}

// === DATA EXTRACTION FUNCTIONS ===

function getMetaTitleData() {
    const el = document.querySelector('.analysis-card[data-name="title"]');
    if (!el) return null;

    const rawContent = el.querySelector(".card-inner-content p")?.innerText || "N/A";
    const length = el.querySelector(".badge_pdf")?.innerText || "N/A";
    const casing = el.querySelector(".casing_pdf")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";

    // Check if title equals H1
    // Get H1 tag content
    const h1Element = document.querySelector("h1");
    const h1Content = h1Element ? h1Element.innerText.trim() : "";
    const titleEqualH1 = (rawContent !== "N/A" && h1Content && rawContent.trim() === h1Content) ? "Yes" : "No";

    // Extract just the number from length (e.g., "59 characters" -> "59")
    const lengthValue = length !== "N/A" ? length.replace(/\D/g, '') : "N/A";

    return {
        content: rawContent,
        length: lengthValue,
        titleEqualH1: titleEqualH1,
        casing: casing,
        status: status
    };
}

function getMetaDescriptionData() {
    const el = document.querySelector('.analysis-card[data-name="description"]');
    if (!el) return null;

    let rawContent = el.querySelector(".card-inner-content p")?.innerText || "N/A";
    const length = el.querySelector(".badge_pdf")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";

    if (length === "N/A") rawContent = "Meta description does not exist.";

    // Extract just the number from length
    const lengthValue = length !== "N/A" ? length.replace(/\D/g, '') : "N/A";

    return {
        content: rawContent,
        length: lengthValue,
        status: status
    };
}

function getRobotsMetaData() {
    const el = document.querySelector('.analysis-card[data-name="robots"]');
    if (!el) return null;

    const robotsContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";

    // Check if robots tag exists
    const robotsTagExists = (robotsContent !== "N/A" && robotsContent.trim() !== "") ? "Yes" : "No";
    
    // Extract robots tag content (e.g., "index, follow")
    const robotsTagContent = robotsContent !== "N/A" ? robotsContent.trim() : "";
    const lengthValue = robotsTagContent ? robotsTagContent.length.toString() : "N/A";

    return {
        robotsTagExists: robotsTagExists,
        content: robotsTagContent || "N/A",
        length: lengthValue,
        status: status
    };
}

function getUrlSlugData() {
    const el = document.querySelector('.analysis-card[data-name="url"]');
    if (!el) return null;

    // Extract slug content
    const slugContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Extract length from badge
    const lengthBadge = el.querySelector(".badge_pdf")?.innerText || "N/A";
    const lengthValue = lengthBadge !== "N/A" ? lengthBadge.replace(/\D/g, '') : "N/A";
    
    // Try to extract special characters and hyphens info from card content
    // These might be in separate card-single-content divs
    const allContent = el.querySelectorAll(".card-single-content");
    let hasSpecialChars = "N/A";
    let wordsByHyphens = "N/A";
    
    // Look for text that indicates special characters or hyphens
    allContent.forEach(contentEl => {
        const text = contentEl.innerText || "";
        if (text.toLowerCase().includes("special") || text.toLowerCase().includes("character")) {
            hasSpecialChars = text.includes("No") ? "No" : "Yes";
        }
        if (text.toLowerCase().includes("hyphen") || text.toLowerCase().includes("separated")) {
            wordsByHyphens = text.includes("Yes") ? "Yes" : "No";
        }
    });

    return {
        slug: slugContent,
        length: lengthValue,
        hasSpecialChars: hasSpecialChars,
        wordsByHyphens: wordsByHyphens,
        status: status
    };
}

function getCanonicalUrlData() {
    const el = document.querySelector('.analysis-card[data-name="canonical"]');
    if (!el) return null;

    // Extract actual URL
    const actualUrlText = el.querySelector(".card-actual-url p:nth-of-type(1)")?.innerText || "";
    const actualUrl = actualUrlText.replace("Actual URL", "").trim() || "N/A";
    
    // Extract canonical URL
    let canonicalUrlText = el.querySelector(".card-actual-url p:nth-of-type(2)")?.innerText || "";
    let canonicalUrl = canonicalUrlText.replace("Canonical URL", "").trim() || "N/A";
    if (canonicalUrl === "-") canonicalUrl = "Canonical URL Tag does not exist";
    
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Determine if equal (normalize URLs by removing trailing slashes for comparison)
    const actualUrlNormalized = actualUrl !== "N/A" ? actualUrl.replace(/\/$/, '') : "";
    const canonicalUrlNormalized = canonicalUrl !== "N/A" && canonicalUrl !== "Canonical URL Tag does not exist" 
        ? canonicalUrl.replace(/\/$/, '') : "";
    const isEqual = (actualUrlNormalized && canonicalUrlNormalized && actualUrlNormalized === canonicalUrlNormalized) ? "Yes" : "No";

    return {
        actualUrl: actualUrl,
        canonicalUrl: canonicalUrl,
        isEqual: isEqual,
        status: status
    };
}

function getImagesData() {
    const tableElement = document.querySelector(".custom-dataTable");
    if (!tableElement) return null;

    let allData = [];
    let dataTable = null;
    let originalPageLength = null;
    
    // Check if jQuery DataTables is available and table has DataTable instance
    if (typeof $ !== 'undefined' && $.fn.DataTable && $(tableElement).hasClass('custom-dataTable')) {
        try {
            dataTable = $(tableElement).DataTable();
            if (dataTable) {
                // Store original page length
                originalPageLength = dataTable.page.len();
                
                // Temporarily show all rows
                dataTable.page.len(-1).draw();
                
                // Wait a moment for DOM to update
                const tableRows = tableElement.querySelectorAll("tbody tr");
                
                allData = Array.from(tableRows).map((row) => {
                    const cells = row.querySelectorAll("td");
                    
                    // Extract Image Link (from first cell, usually an <a> tag)
                    let imageLink = "";
                    if (cells[0]) {
                        const linkElement = cells[0].querySelector("a");
                        imageLink = linkElement ? (linkElement.href || linkElement.textContent.trim()) : cells[0].textContent.trim();
                    }
                    
                    // Alternate Text columns
                    const altTextContent = cells[1]?.textContent.trim() || "";
                    const wordsSeparatedBySpaces = cells[2]?.textContent.trim() || "";
                    
                    // File Name columns (based on table structure from analysis.js)
                    const fileName = cells[3]?.textContent.trim() || "";
                    const len = cells[4]?.textContent.trim() || "";
                    const wordsSeparatedByHyphens = cells[5]?.textContent.trim() || "";
                    const uppercaseCharacters = cells[6]?.textContent.trim() || "";
                    const specialCharacters = cells[7]?.textContent.trim() || "";
                    const fileSize = cells[8]?.textContent.trim() || "";
                    
                    // Result column (usually the last column or second to last)
                    let result = "";
                    if (cells.length > 9) {
                        result = cells[9]?.textContent.trim() || "";
                    } else if (cells.length > 8) {
                        // Check if last cell has result (PASS/FAIL)
                        const lastCell = cells[cells.length - 1]?.textContent.trim() || "";
                        if (lastCell.toUpperCase() === "PASS" || lastCell.toUpperCase() === "FAIL") {
                            result = lastCell;
                        }
                    }
                    
                    return {
                        imageLink: imageLink,
                        altTextContent: altTextContent,
                        wordsSeparatedBySpaces: wordsSeparatedBySpaces,
                        fileName: fileName,
                        len: len,
                        wordsSeparatedByHyphens: wordsSeparatedByHyphens,
                        uppercaseCharacters: uppercaseCharacters,
                        specialCharacters: specialCharacters,
                        fileSize: fileSize,
                        result: result
                    };
                });
                
                // Restore original page length
                if (originalPageLength !== null) {
                    dataTable.page.len(originalPageLength).draw();
                }
            }
        } catch (error) {
            console.log("Error with DataTable approach:", error);
            // Fallback to visible rows only
            const tableRows = tableElement.querySelectorAll("tbody tr");
            allData = Array.from(tableRows).map((row) => {
                const cells = row.querySelectorAll("td");
                let imageLink = "";
                if (cells[0]) {
                    const linkElement = cells[0].querySelector("a");
                    imageLink = linkElement ? (linkElement.href || linkElement.textContent.trim()) : cells[0].textContent.trim();
                }
                let result = "";
                if (cells.length > 9) {
                    result = cells[9]?.textContent.trim() || "";
                } else if (cells.length > 8) {
                    const lastCell = cells[cells.length - 1]?.textContent.trim() || "";
                    if (lastCell.toUpperCase() === "PASS" || lastCell.toUpperCase() === "FAIL") {
                        result = lastCell;
                    }
                }
                return {
                    imageLink: imageLink,
                    altTextContent: cells[1]?.textContent.trim() || "",
                    wordsSeparatedBySpaces: cells[2]?.textContent.trim() || "",
                    fileName: cells[3]?.textContent.trim() || "",
                    len: cells[4]?.textContent.trim() || "",
                    wordsSeparatedByHyphens: cells[5]?.textContent.trim() || "",
                    uppercaseCharacters: cells[6]?.textContent.trim() || "",
                    specialCharacters: cells[7]?.textContent.trim() || "",
                    fileSize: cells[8]?.textContent.trim() || "",
                    result: result
                };
            });
        }
    } else {
        // Fallback: get visible rows only (no DataTable)
        const tableRows = tableElement.querySelectorAll("tbody tr");
        allData = Array.from(tableRows).map((row) => {
            const cells = row.querySelectorAll("td");
            let imageLink = "";
            if (cells[0]) {
                const linkElement = cells[0].querySelector("a");
                imageLink = linkElement ? (linkElement.href || linkElement.textContent.trim()) : cells[0].textContent.trim();
            }
            let result = "";
            if (cells.length > 9) {
                result = cells[9]?.textContent.trim() || "";
            } else if (cells.length > 8) {
                const lastCell = cells[cells.length - 1]?.textContent.trim() || "";
                if (lastCell.toUpperCase() === "PASS" || lastCell.toUpperCase() === "FAIL") {
                    result = lastCell;
                }
            }
            return {
                imageLink: imageLink,
                altTextContent: cells[1]?.textContent.trim() || "",
                wordsSeparatedBySpaces: cells[2]?.textContent.trim() || "",
                fileName: cells[3]?.textContent.trim() || "",
                len: cells[4]?.textContent.trim() || "",
                wordsSeparatedByHyphens: cells[5]?.textContent.trim() || "",
                uppercaseCharacters: cells[6]?.textContent.trim() || "",
                specialCharacters: cells[7]?.textContent.trim() || "",
                fileSize: cells[8]?.textContent.trim() || "",
                result: result
            };
        });
    }
    
    return allData.length > 0 ? allData : null;
}

function getRobotsTxtData() {
    const el = document.querySelector('.analysis-card[data-name="robot_text_test"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || 
                   el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getMetaViewportData() {
    const el = document.querySelector('.analysis-card[data-name="viewport"]') || 
               document.querySelector('.analysis-card[data-name="meta_viewport"]');
    if (!el) return null;

    // Get the message content from card-single-content span (second span is the message)
    const viewportContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || 
                           el.querySelector(".message_pdf")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Extract if viewport tag is present based on the message
    // Backend messages:
    // - "Your webpage is using a Meta Viewport tag" -> Yes
    // - "Meta Viewport tag either does not exist or is empty" -> No
    let viewportPresent = "N/A";
    const contentLower = viewportContent.toLowerCase();
    if (contentLower.includes("is using") && contentLower.includes("meta viewport")) {
        viewportPresent = "Yes";
    } else if (contentLower.includes("does not exist") || contentLower.includes("is empty") || 
               contentLower.includes("is not using")) {
        viewportPresent = "No";
    } else {
        // Fallback: use status to infer (PASS usually means tag exists, FAIL might mean doesn't exist)
        // But this is less reliable, so we keep as N/A if message doesn't match
    }

    return {
        viewportPresent: viewportPresent,
        status: status
    };
}

function getDoctypeData() {
    const el = document.querySelector('.analysis-card[data-name="doctype"]');
    if (!el) return null;

    // Get the message content from card-single-content span (second span is the message)
    const doctypeContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || 
                          el.querySelector(".message_pdf")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Extract if doctype tag is present based on the message
    // Backend messages:
    // - "Your webpage is using a Doctype tag." -> Yes
    // - "Your webpage is not using a Doctype tag." -> No
    let doctypePresent = "N/A";
    const contentLower = doctypeContent.toLowerCase();
    if (contentLower.includes("is using") && contentLower.includes("doctype")) {
        doctypePresent = "Yes";
    } else if (contentLower.includes("is not using") && contentLower.includes("doctype")) {
        doctypePresent = "No";
    } else {
        // Fallback: use status to infer (PASS usually means tag exists, FAIL might mean doesn't exist)
        // But this is less reliable, so we keep as N/A if message doesn't match
    }

    return {
        doctypePresent: doctypePresent,
        status: status
    };
}

function getHttpStatusCodeData() {
    const el = document.querySelector('.analysis-card[data-name="http_status_code"]') || 
               document.querySelector('.analysis-card[data-name="http_status"]');
    if (!el) return null;

    // Try to get the HTTP status code from card-single-content span (second span is the message)
    // The message might contain the status code like "200 OK" or just the code
    const httpStatusCodeContent = el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || 
                                 el.querySelector(".message_pdf")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || "N/A";
    
    // Extract HTTP status code (e.g., "200 OK" or "200")
    // The content might be in format "200 OK" or just "200" or in a message
    let httpStatusCode = "N/A";
    if (httpStatusCodeContent !== "N/A") {
        // Try to extract status code pattern (e.g., "200 OK", "404 Not Found", etc.)
        const statusCodeMatch = httpStatusCodeContent.match(/(\d{3})\s*(?:-\s*)?([A-Za-z\s]+)?/);
        if (statusCodeMatch) {
            const code = statusCodeMatch[1];
            const name = statusCodeMatch[2] ? statusCodeMatch[2].trim() : "";
            httpStatusCode = name ? `${code} ${name}` : code;
        } else {
            // If no pattern match, use the content as is if it looks like a status code
            httpStatusCode = httpStatusCodeContent.trim();
        }
    }

    return {
        httpStatusCode: httpStatusCode,
        status: status
    };
}

function getGooglePageSpeedData() {
    const el = document.querySelector('.analysis-card[data-name="google_overall"]');
    if (!el) return null;

    // Get desktop and mobile scores from the text elements
    const desktopScoreText = document.querySelector(".overallDesktop")?.textContent || "N/A";
    const mobileScoreText = document.querySelector(".overallMobile")?.textContent || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";
    
    // Parse scores as integers
    const desktopScore = desktopScoreText !== "N/A" ? parseInt(desktopScoreText) : null;
    const mobileScore = mobileScoreText !== "N/A" ? parseInt(mobileScoreText) : null;

    return {
        desktopScore: desktopScore !== null ? desktopScore : "N/A",
        mobileScore: mobileScore !== null ? mobileScore : "N/A",
        status: status
    };
}

function getLighthouseData() {
    const el = document.querySelector('.analysis-card[data-name="google_lighthouse"]');
    if (!el) return null;

    // Get all scores from the text elements
    const performanceDesktopText = document.querySelector(".performanceDesktop")?.textContent || "N/A";
    const accessibilityDesktopText = document.querySelector(".accessibilityDesktop")?.textContent || "N/A";
    const bestPracticesDesktopText = document.querySelector(".bestPracticesDesktop")?.textContent || "N/A";
    const seoDesktopText = document.querySelector(".seoDesktop")?.textContent || "N/A";
    
    const performanceMobileText = document.querySelector(".performanceMobile")?.textContent || "N/A";
    const accessibilityMobileText = document.querySelector(".accessibilityMobile")?.textContent || "N/A";
    const bestPracticesMobileText = document.querySelector(".bestPracticesMobile")?.textContent || "N/A";
    const seoMobileText = document.querySelector(".seoMobile")?.textContent || "N/A";
    
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";
    
    // Parse scores as integers
    const parseScore = (text) => {
        if (text === "N/A") return null;
        const parsed = parseInt(text);
        return isNaN(parsed) ? null : parsed;
    };

    return {
        performanceDesktop: parseScore(performanceDesktopText) !== null ? parseScore(performanceDesktopText) : "N/A",
        accessibilityDesktop: parseScore(accessibilityDesktopText) !== null ? parseScore(accessibilityDesktopText) : "N/A",
        bestPracticesDesktop: parseScore(bestPracticesDesktopText) !== null ? parseScore(bestPracticesDesktopText) : "N/A",
        seoDesktop: parseScore(seoDesktopText) !== null ? parseScore(seoDesktopText) : "N/A",
        performanceMobile: parseScore(performanceMobileText) !== null ? parseScore(performanceMobileText) : "N/A",
        accessibilityMobile: parseScore(accessibilityMobileText) !== null ? parseScore(accessibilityMobileText) : "N/A",
        bestPracticesMobile: parseScore(bestPracticesMobileText) !== null ? parseScore(bestPracticesMobileText) : "N/A",
        seoMobile: parseScore(seoMobileText) !== null ? parseScore(seoMobileText) : "N/A",
        status: status
    };
}

function getCoreWebVitalsData() {
    const el = document.querySelector('.analysis-card[data-name="core_web_vitals"]');
    if (!el) return null;

    // Extract values from text elements, removing unit suffixes (s, ms)
    const extractValue = (text) => {
        if (!text || text === "N/A") return "N/A";
        // Remove " s", " ms" and any whitespace, then parse
        const cleaned = text.toString().replace(/\s*(s|ms)$/i, "").trim();
        const parsed = parseFloat(cleaned);
        return isNaN(parsed) ? text : parsed;
    };

    // Desktop values
    const lcpDesktopText = document.querySelector(".lcpDesktop")?.textContent || "N/A";
    const fidDesktopText = document.querySelector(".fidDesktop")?.textContent || "N/A";
    const clsDesktopText = document.querySelector(".clsDesktop")?.textContent || "N/A";
    const fcpDesktopText = document.querySelector(".fcpDesktop")?.textContent || "N/A";
    const ttiDesktopText = document.querySelector(".ttiDesktop")?.textContent || "N/A";
    const siDesktopText = document.querySelector(".siDesktop")?.textContent || "N/A";
    const tbtDesktopText = document.querySelector(".tbtDesktop")?.textContent || "N/A";

    // Mobile values
    const lcpMobileText = document.querySelector(".lcpMobile")?.textContent || "N/A";
    const fidMobileText = document.querySelector(".fidMobile")?.textContent || "N/A";
    const clsMobileText = document.querySelector(".clsMobile")?.textContent || "N/A";
    const fcpMobileText = document.querySelector(".fcpMobile")?.textContent || "N/A";
    const ttiMobileText = document.querySelector(".ttiMobile")?.textContent || "N/A";
    const siMobileText = document.querySelector(".siMobile")?.textContent || "N/A";
    const tbtMobileText = document.querySelector(".tbtMobile")?.textContent || "N/A";

    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        lcpDesktop: extractValue(lcpDesktopText),
        fidDesktop: extractValue(fidDesktopText),
        clsDesktop: extractValue(clsDesktopText),
        fcpDesktop: extractValue(fcpDesktopText),
        ttiDesktop: extractValue(ttiDesktopText),
        siDesktop: extractValue(siDesktopText),
        tbtDesktop: extractValue(tbtDesktopText),
        lcpMobile: extractValue(lcpMobileText),
        fidMobile: extractValue(fidMobileText),
        clsMobile: extractValue(clsMobileText),
        fcpMobile: extractValue(fcpMobileText),
        ttiMobile: extractValue(ttiMobileText),
        siMobile: extractValue(siMobileText),
        tbtMobile: extractValue(tbtMobileText),
        status: status
    };
}

function getMobileFriendlinessData() {
    const el = document.querySelector('.analysis-card[data-name="mobile_friendly"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getGzipCompressionData() {
    const el = document.querySelector('.analysis-card[data-name="gzip_compression"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getHtmlCompressionData() {
    const el = document.querySelector('.analysis-card[data-name="html_compression"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getCssCompressionData() {
    const el = document.querySelector('.analysis-card[data-name="css_compression"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getJsCompressionData() {
    const el = document.querySelector('.analysis-card[data-name="js_compression"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getCssCachingData() {
    const el = document.querySelector('.analysis-card[data-name="css_caching_enable"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getJsCachingData() {
    const el = document.querySelector('.analysis-card[data-name="js_caching_enable"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getPageSizeData() {
    const el = document.querySelector('.analysis-card[data-name="page_size"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    // Extract HTML Page Size value from message (e.g., "483 KB")
    let htmlPageSize = "N/A";
    if (message && message !== "N/A") {
        // Try to extract size value from message
        const sizeMatch = message.match(/(\d+(?:\.\d+)?\s*(?:KB|MB|GB|B))/i);
        if (sizeMatch) {
            htmlPageSize = sizeMatch[1];
        } else {
            // If no size found, use the message as is
            htmlPageSize = message;
        }
    }

    return {
        htmlPageSize: htmlPageSize,
        message: message,
        status: status
    };
}

function getNestedTablesData() {
    const el = document.querySelector('.analysis-card[data-name="nested_tables"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getFramesetData() {
    const el = document.querySelector('.analysis-card[data-name="frameset"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getBrokenLinksData() {
    // Get the table from inside the broken-links-modal (not the card view)
    const modalElement = document.querySelector("#broken-links-modal") || 
                         document.querySelector("#brokenLinksModal");
    if (!modalElement) return null;
    
    const tableElement = modalElement.querySelector(".broken-links-table") || 
                        modalElement.querySelector(".bulk-broken-links-table");
    if (!tableElement) return null;

    // Get all data from the table
    const tableRows = tableElement.querySelectorAll("tbody tr");
    if (tableRows.length === 0) return null;

    const brokenLinks = [];

    Array.from(tableRows).forEach((row) => {
        const cells = row.querySelectorAll("td");
        if (cells.length < 2) return;

        // First column: URL
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

        if (urlLink && statusCode) {
            brokenLinks.push({
                url: urlLink,
                statusCode: statusCode
            });
        }
    });

    return brokenLinks.length > 0 ? brokenLinks : null;
}

function getUnsafeCrossOriginLinksData() {
    // Get the table from inside the cross-origin-links modal
    const modalElement = document.querySelector("#crossOriginLinksModal");
    if (!modalElement) return null;
    
    const tableElement = modalElement.querySelector("table");
    if (!tableElement) return null;

    // Get all data from the table
    const tableRows = tableElement.querySelectorAll("tbody tr");
    if (tableRows.length === 0) return null;

    const links = [];

    Array.from(tableRows).forEach((row) => {
        const cells = row.querySelectorAll("td");
        if (cells.length < 1) return;

        // Get URL from first cell
        const urlCell = cells[0];
        let urlLink = "";
        if (urlCell) {
            const linkElement = urlCell.querySelector("a");
            if (linkElement) {
                urlLink = linkElement.href || linkElement.textContent.trim();
            } else {
                urlLink = urlCell.textContent.trim();
            }
        }

        if (urlLink) {
            links.push({
                url: urlLink
            });
        }
    });

    return links.length > 0 ? links : null;
}

function getProtocolRelativeResourceLinksData() {
    // Get the table from inside the protocol-relative-resource modal
    const modalElement = document.querySelector("#protocolRelativeResourceModal");
    if (!modalElement) return null;
    
    const tableElement = modalElement.querySelector("table");
    if (!tableElement) return null;

    // Get all data from the table
    const tableRows = tableElement.querySelectorAll("tbody tr");
    if (tableRows.length === 0) return null;

    const links = [];

    Array.from(tableRows).forEach((row) => {
        const cells = row.querySelectorAll("td");
        if (cells.length < 2) return;

        // Get URL from second cell (first cell is index)
        const urlCell = cells[1];
        let urlLink = "";
        if (urlCell) {
            const linkElement = urlCell.querySelector("a");
            if (linkElement) {
                urlLink = linkElement.href || linkElement.textContent.trim();
            } else {
                urlLink = urlCell.textContent.trim();
            }
        }

        if (urlLink) {
            links.push({
                url: urlLink
            });
        }
    });

    return links.length > 0 ? links : null;
}

function getSafeBrowsingData() {
    const el = document.querySelector('.analysis-card[data-name="is_safe_browsing"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getXFrameOptionsHeaderData() {
    const el = document.querySelector('.analysis-card[data-name="x_frame_options_header"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getHstsHeaderData() {
    const el = document.querySelector('.analysis-card[data-name="hsts_header"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getBadContentTypeData() {
    const el = document.querySelector('.analysis-card[data-name="bad_content_type"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getSslCertificateData() {
    const el = document.querySelector('.analysis-card[data-name="ssl_certificate_enable"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getDirectoryBrowsingData() {
    const el = document.querySelector('.analysis-card[data-name="folder_browsing_enable"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

function getOpenGraphData() {
    // Find the Open Graph card first to ensure we're getting the right table
    const ogCard = document.querySelector('.analysis-card[data-name="open_graph_tags"]') || 
                   document.querySelector('.analysis-card[data-name="og:title"]');
    if (!ogCard) return null;

    // Find the Open Graph table within the card
    const table = ogCard.querySelector('.meta-graph-table table');
    if (!table) return null;

    const rows = table.querySelectorAll('tbody tr');
    if (rows.length === 0) return null;

    const data = {
        ogTitle: {},
        ogDescription: {},
        ogUrl: {},
        ogImage: {}
    };

    rows.forEach((row) => {
        const cells = row.querySelectorAll('td');
        if (cells.length < 4) return;

        const tagCell = cells[0];
        const tagName = tagCell.querySelector('span')?.textContent.trim() || '';
        
        // Extract content
        let content = '';
        const contentCell = cells[1];
        if (contentCell) {
            const contentP = contentCell.querySelector('p');
            if (contentP) {
                const link = contentP.querySelector('a');
                if (link) {
                    content = link.textContent.trim() || link.getAttribute('href') || '';
                } else {
                    content = contentP.textContent.trim();
                }
            } else {
                content = contentCell.textContent.trim();
            }
        }

        // Extract status
        const statusCell = cells[2];
        let status = 'FAIL';
        if (statusCell) {
            const statusDiv = statusCell.querySelector('.status-card');
            if (statusDiv) {
                status = statusDiv.textContent.trim().toUpperCase();
            }
        }

        // Extract issues
        const issuesCell = cells[3];
        let issues = 'No problems found.';
        if (issuesCell) {
            const ul = issuesCell.querySelector('ul');
            if (ul) {
                const liItems = ul.querySelectorAll('li');
                issues = Array.from(liItems).map(li => li.textContent.trim()).join('; ');
            } else {
                issues = issuesCell.textContent.trim() || 'No problems found.';
            }
        }

        // Process based on tag name
        if (tagName.includes('OG Title') || tagName.includes('Title Tag')) {
            data.ogTitle.content = content || 'N/A';
            data.ogTitle.status = status;
            data.ogTitle.issues = issues;
        } else if (tagName.includes('OG Description') || tagName.includes('Description')) {
            data.ogDescription.content = content || 'N/A';
            data.ogDescription.status = status;
            data.ogDescription.issues = issues;
        } else if (tagName.includes('Og URL') || tagName.includes('OG URL') || tagName.includes('URL')) {
            data.ogUrl.content = content || 'N/A';
            data.ogUrl.status = status;
            data.ogUrl.issues = issues;
        } else if (tagName.includes('OG Image') || tagName.includes('Image')) {
            data.ogImage.content = content || 'N/A';
            data.ogImage.status = status;
            data.ogImage.issues = issues;
        }
    });

    // Check if we have any data
    if (!data.ogTitle.content && !data.ogDescription.content && !data.ogUrl.content && !data.ogImage.content) {
        return null;
    }

    return data;
}

function getTwitterTagsData() {
    // Find the Twitter Tags card first to ensure we're getting the right table
    const twitterCard = document.querySelector('.analysis-card[data-name="twitter_tags"]') || 
                       document.querySelector('.analysis-card[data-name="twitter:title"]');
    if (!twitterCard) return null;

    // Find the Twitter Tags table within the card
    const table = twitterCard.querySelector('.meta-graph-table table');
    if (!table) return null;

    const rows = table.querySelectorAll('tbody tr');
    if (rows.length === 0) return null;

    const data = {
        twitterTitle: {},
        twitterImage: {},
        twitterImageAlt: {}
    };

    rows.forEach((row) => {
        const cells = row.querySelectorAll('td');
        if (cells.length < 4) return;

        const tagCell = cells[0];
        const tagName = tagCell.querySelector('span')?.textContent.trim() || '';
        
        // Extract content
        let content = '';
        const contentCell = cells[1];
        if (contentCell) {
            const contentP = contentCell.querySelector('p');
            if (contentP) {
                content = contentP.textContent.trim();
            } else {
                content = contentCell.textContent.trim();
            }
        }

        // Extract status
        const statusCell = cells[2];
        let status = 'FAIL';
        if (statusCell) {
            const statusDiv = statusCell.querySelector('.status-card');
            if (statusDiv) {
                status = statusDiv.textContent.trim().toUpperCase();
            }
        }

        // Extract issues for additional info
        const issuesCell = cells[3];
        let issues = '';
        if (issuesCell) {
            const ul = issuesCell.querySelector('ul');
            if (ul) {
                const liItems = ul.querySelectorAll('li');
                issues = Array.from(liItems).map(li => li.textContent.trim()).join('; ');
            } else {
                issues = issuesCell.textContent.trim();
            }
        }

        // Process based on tag name
        if (tagName.includes('Twitter Title')) {
            data.twitterTitle.content = content || 'N/A';
            data.twitterTitle.length = content ? content.length : 0;
            data.twitterTitle.status = status;
            data.twitterTitle.issues = issues;
            // Extract casing from issues if available
            if (issues.toLowerCase().includes('camel')) {
                data.twitterTitle.casing = 'Camel Case';
            } else if (issues.toLowerCase().includes('sentence')) {
                data.twitterTitle.casing = 'Sentence Case';
            } else if (issues.toLowerCase().includes('neither')) {
                data.twitterTitle.casing = 'Neither Camel Case nor Sentence Case';
            } else {
                data.twitterTitle.casing = 'N/A';
            }
        } else if (tagName.includes('Twitter Image') && !tagName.includes('Alt')) {
            data.twitterImage.content = content || 'N/A';
            data.twitterImage.status = status;
            data.twitterImage.issues = issues;
            // Try to extract dimensions from issues text
            let width = 'N/A';
            let height = 'N/A';
            if (issues) {
                // Look for width pattern like "1200 pixels" or "Width of Twitter Image is..."
                const widthMatch = issues.match(/width[^\d]*(\d+)/i) || issues.match(/(\d+)[^\d]*width/i);
                if (widthMatch) {
                    width = widthMatch[1];
                }
                // Look for height pattern
                const heightMatch = issues.match(/height[^\d]*(\d+)/i) || issues.match(/(\d+)[^\d]*height/i);
                if (heightMatch) {
                    height = heightMatch[1];
                }
            }
            // If dimensions not found in issues, try to get from image if URL is available
            if ((width === 'N/A' || height === 'N/A') && content && content.startsWith('http')) {
                // Try to load image and get dimensions (async, but we'll set defaults)
                // For now, we'll leave as N/A if not found in issues
            }
            data.twitterImage.width = width;
            data.twitterImage.height = height;
        } else if (tagName.includes('Twitter Image Alt')) {
            data.twitterImageAlt.content = content || 'N/A';
            data.twitterImageAlt.length = content ? content.length : 0;
            data.twitterImageAlt.status = status;
            data.twitterImageAlt.issues = issues;
        }
    });

    // Check if we have any data
    if (!data.twitterTitle.content && !data.twitterImage.content && !data.twitterImageAlt.content) {
        return null;
    }

    return data;
}

function getFaviconData() {
    const el = document.querySelector('.analysis-card[data-name="icon"]') || 
               document.querySelector('.analysis-card[data-name="favicon"]');
    if (!el) return null;

    const message = el.querySelector(".message_pdf")?.textContent.trim() || 
                   el.querySelector(".card-single-content span:nth-of-type(2)")?.innerText || "N/A";
    const status = el.querySelector(".status_pdf")?.innerText || 
                  el.querySelector(".badge.bagde-single-view")?.innerText || "N/A";

    return {
        message: message,
        status: status
    };
}

// === SECTION RENDERING FUNCTIONS ===

// Helper function to add light gray borders to label cells (column A only) and set vertical middle alignment
function addLabelBorders(cell) {
    cell.border = {
        top: { style: 'dotted', color: { argb: 'FFD3D3D3' } },
        left: { style: 'dotted', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'dotted', color: { argb: 'FFD3D3D3' } },
        right: { style: 'dotted', color: { argb: 'FFD3D3D3' } }
    };
    // Set vertical middle alignment for all labels
    cell.alignment = { vertical: 'middle', horizontal: 'left' };
}

function addMetaTitleSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Meta Title";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;

    // Content row
    const contentRow = worksheet.getRow(currentRow);
    contentRow.getCell(1).value = "Content";
    contentRow.getCell(2).value = data.content;
    // Add light grey background to column A label
    contentRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    contentRow.getCell(1).font = { bold: true };
    addLabelBorders(contentRow.getCell(1));
    // Enable text wrapping for content cell
    contentRow.getCell(2).alignment = { wrapText: true, vertical: 'top' };
    // No background color for content cell
    // Auto-adjust row height for wrapped content (estimate: ~100 characters per line, min 20px)
    const estimatedLines = Math.ceil((data.content.length || 0) / 100) || 1;
    contentRow.height = Math.max(20, estimatedLines * 15);
    currentRow++;

    // Length row
    const lengthRow = worksheet.getRow(currentRow);
    lengthRow.getCell(1).value = "Length";
    lengthRow.getCell(2).value = data.length;
    // Add light grey background to column A label
    lengthRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    lengthRow.getCell(1).font = { bold: true };
    addLabelBorders(lengthRow.getCell(1));
    // Color coding for length (green if between 30-65, red otherwise)
    if (data.length !== "N/A") {
        const lengthNum = parseInt(data.length);
        if (lengthNum >= 30 && lengthNum <= 65) {
            lengthRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
        } else {
            lengthRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red
            };
        }
    }
    currentRow++;

    // Title Equal to H1 row
    const titleEqualH1Row = worksheet.getRow(currentRow);
    titleEqualH1Row.getCell(1).value = "Title Equal to H1";
    titleEqualH1Row.getCell(2).value = data.titleEqualH1;
    // Add light grey background to column A label
    titleEqualH1Row.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    titleEqualH1Row.getCell(1).font = { bold: true };
    addLabelBorders(titleEqualH1Row.getCell(1));
    // No background color for Yes/No value
    currentRow++;

    // Casing row
    const casingRow = worksheet.getRow(currentRow);
    casingRow.getCell(1).value = "Casing";
    casingRow.getCell(2).value = data.casing;
    // Add light grey background to column A label
    casingRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    casingRow.getCell(1).font = { bold: true };
    addLabelBorders(casingRow.getCell(1));
    // Color coding for casing (red if "Neither Camel Case nor Sentence Case", no background otherwise)
    if (data.casing && (data.casing.includes("Neither") || data.casing.toLowerCase().includes("neither"))) {
        casingRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
    }
    currentRow++;

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(2).value = data.status;
    // Add light grey background to column A label
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addMetaDescriptionSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Meta Description";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;

    // Content row
    const contentRow = worksheet.getRow(currentRow);
    contentRow.getCell(1).value = "Content";
    contentRow.getCell(2).value = data.content;
    // Add light grey background to column A label
    contentRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    contentRow.getCell(1).font = { bold: true };
    addLabelBorders(contentRow.getCell(1));
    // Enable text wrapping for content cell
    contentRow.getCell(2).alignment = { wrapText: true, vertical: 'top' };
    // No background color for content cell
    // Auto-adjust row height for wrapped content (estimate: ~100 characters per line, min 20px)
    const estimatedLines = Math.ceil((data.content.length || 0) / 100) || 1;
    contentRow.height = Math.max(20, estimatedLines * 15);
    currentRow++;

    // Length row
    const lengthRow = worksheet.getRow(currentRow);
    lengthRow.getCell(1).value = "Length";
    lengthRow.getCell(2).value = data.length;
    // Add light grey background to column A label
    lengthRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    lengthRow.getCell(1).font = { bold: true };
    addLabelBorders(lengthRow.getCell(1));
    // Color coding for length (green if between 120-160, red otherwise)
    if (data.length !== "N/A") {
        const lengthNum = parseInt(data.length);
        if (lengthNum >= 120 && lengthNum <= 160) {
            lengthRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
        } else {
            lengthRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red
            };
        }
    }
    currentRow++;

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(2).value = data.status;
    // Add light grey background to column A label
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addRobotsMetaSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Robots Meta Tag";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;

    // Robots Tag Exists row
    const robotsExistsRow = worksheet.getRow(currentRow);
    robotsExistsRow.getCell(1).value = "Robots Tag Exists";
    robotsExistsRow.getCell(2).value = data.robotsTagExists;
    // Add light grey background to column A label
    robotsExistsRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    robotsExistsRow.getCell(1).font = { bold: true };
    addLabelBorders(robotsExistsRow.getCell(1));
    // Color coding (green if Yes, red if No)
    if (data.robotsTagExists === "Yes") {
        robotsExistsRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
    } else {
        robotsExistsRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
    }
    currentRow++;

    // Length row (showing the content value like "index, follow")
    const lengthRow = worksheet.getRow(currentRow);
    lengthRow.getCell(1).value = "Length";
    // Show the robots tag content (e.g., "index, follow") instead of length number
    lengthRow.getCell(2).value = data.content !== "N/A" ? data.content : "N/A";
    // Add light grey background to column A label
    lengthRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    lengthRow.getCell(1).font = { bold: true };
    addLabelBorders(lengthRow.getCell(1));
    // Enable text wrapping for content cell
    lengthRow.getCell(2).alignment = { wrapText: true, vertical: 'top' };
    // No background color for Length data
    currentRow++;

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(2).value = data.status;
    // Add light grey background to column A label
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addCanonicalUrlSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Canonical URL";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;

    // Actual URL row
    const actualUrlRow = worksheet.getRow(currentRow);
    actualUrlRow.getCell(1).value = "Actual URL";
    const actualUrlCell = actualUrlRow.getCell(2);
    // Make Actual URL a clickable hyperlink if it's a valid URL
    if (data.actualUrl && (data.actualUrl.startsWith('http://') || data.actualUrl.startsWith('https://'))) {
        actualUrlCell.value = {
            text: data.actualUrl,
            hyperlink: data.actualUrl
        };
        actualUrlCell.font = { color: { argb: 'FF0000FF' }, underline: true }; // Blue color for links
    } else {
        actualUrlCell.value = data.actualUrl;
    }
    actualUrlRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    actualUrlRow.getCell(1).font = { bold: true };
    addLabelBorders(actualUrlRow.getCell(1));
    actualUrlCell.alignment = { wrapText: true, vertical: 'top' };
    // No background color for Actual URL
    currentRow++;

    // Canonical URL row
    const canonicalUrlRow = worksheet.getRow(currentRow);
    canonicalUrlRow.getCell(1).value = "Canonical URL";
    const canonicalUrlCell = canonicalUrlRow.getCell(2);
    // Make Canonical URL a clickable hyperlink if it's a valid URL
    if (data.canonicalUrl && (data.canonicalUrl.startsWith('http://') || data.canonicalUrl.startsWith('https://'))) {
        canonicalUrlCell.value = {
            text: data.canonicalUrl,
            hyperlink: data.canonicalUrl
        };
        canonicalUrlCell.font = { color: { argb: 'FF0000FF' }, underline: true }; // Blue color for links
    } else {
        canonicalUrlCell.value = data.canonicalUrl;
    }
    canonicalUrlRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    canonicalUrlRow.getCell(1).font = { bold: true };
    addLabelBorders(canonicalUrlRow.getCell(1));
    canonicalUrlCell.alignment = { wrapText: true, vertical: 'top' };
    // No background color for Canonical URL
    currentRow++;

    // Equal to Actual URL row
    const equalRow = worksheet.getRow(currentRow);
    equalRow.getCell(1).value = "Equal to Actual URL?";
    equalRow.getCell(2).value = data.isEqual;
    equalRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    equalRow.getCell(1).font = { bold: true };
    addLabelBorders(equalRow.getCell(1));
    // Color coding (green if Yes, no background if No)
    if (data.isEqual === "Yes") {
        equalRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
    }
    currentRow++;

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(2).value = data.status;
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addImagesSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Set column width for "Uppercase characters?" column (getCell(7) = Column G, index 6)
    // Note: getCell() uses 1-based indexing, worksheet.columns uses 0-based
    // getCell(7) = Column G = worksheet.columns[6]
    if (!worksheet.columns || worksheet.columns.length < 7) {
        worksheet.columns = worksheet.columns || [];
        while (worksheet.columns.length < 7) {
            worksheet.columns.push({});
        }
    }
    worksheet.columns[6] = worksheet.columns[6] || {};
    worksheet.columns[6].width = 25;

    // Header row with blue background - merge across all columns (A to J - 10 columns)
    const headerRow = worksheet.getRow(currentRow);
    headerRow.getCell(1).value = "Images";
    headerRow.getCell(1).font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerRow.getCell(1).alignment = { vertical: 'middle', horizontal: 'center' };
    // Merge cells A to J for the header (all 10 data columns)
    worksheet.mergeCells(currentRow, 1, currentRow, 10);
    headerRow.height = 20;
    currentRow++;

    // Total number of images row
    const totalRow = worksheet.getRow(currentRow);
    totalRow.getCell(1).value = "Total number of images";
    totalRow.getCell(2).value = data.length;
    totalRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    totalRow.getCell(1).font = { bold: true };
    addLabelBorders(totalRow.getCell(1));
    currentRow++;
    
    // Empty row after Total number of images
    currentRow++;

    // Main headings row (first row) - with merged cells
    const mainHeaderRow = worksheet.getRow(currentRow);
    
    // Image Link (Column A - single column, no merge needed)
    mainHeaderRow.getCell(1).value = "Image Link";
    mainHeaderRow.getCell(1).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    mainHeaderRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    mainHeaderRow.getCell(1).alignment = { vertical: 'middle', horizontal: 'center' };
    
    // Alternate Text (Columns B-C - merge 2 columns)
    mainHeaderRow.getCell(2).value = "Alternate Text";
    mainHeaderRow.getCell(2).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    mainHeaderRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    mainHeaderRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'center' };
    worksheet.mergeCells(currentRow, 2, currentRow, 3); // Merge columns B and C
    
    // Image File (Columns D-I - merge 6 columns)
    mainHeaderRow.getCell(4).value = "Image File";
    mainHeaderRow.getCell(4).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    mainHeaderRow.getCell(4).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    mainHeaderRow.getCell(4).alignment = { vertical: 'middle', horizontal: 'center' };
    worksheet.mergeCells(currentRow, 4, currentRow, 9); // Merge columns D through I
    
    // Result (Column J - single column, no merge needed)
    mainHeaderRow.getCell(10).value = "Result";
    mainHeaderRow.getCell(10).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    mainHeaderRow.getCell(10).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    mainHeaderRow.getCell(10).alignment = { vertical: 'middle', horizontal: 'center' };
    
    mainHeaderRow.height = 20;
    currentRow++;
    
    // Sub-headings row (second row)
    const subHeaderRow = worksheet.getRow(currentRow);
    
    // Column A: Image Link (empty, already has main heading above)
    subHeaderRow.getCell(1).value = "";
    subHeaderRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    
    // Column B: Content (under Alternate Text)
    subHeaderRow.getCell(2).value = "Content";
    subHeaderRow.getCell(2).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    subHeaderRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    subHeaderRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'center' };
    
    // Column C: Words separated by spaces? (under Alternate Text)
    subHeaderRow.getCell(3).value = "Words separated by spaces?";
    subHeaderRow.getCell(3).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    subHeaderRow.getCell(3).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    subHeaderRow.getCell(3).alignment = { vertical: 'middle', horizontal: 'center' };
    
    // Column D: File Name (under Image File)
    subHeaderRow.getCell(4).value = "File Name";
    subHeaderRow.getCell(4).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    subHeaderRow.getCell(4).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    subHeaderRow.getCell(4).alignment = { vertical: 'middle', horizontal: 'center' };
    
    // Column E: LEN (under Image File)
    subHeaderRow.getCell(5).value = "LEN";
    subHeaderRow.getCell(5).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    subHeaderRow.getCell(5).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    subHeaderRow.getCell(5).alignment = { vertical: 'middle', horizontal: 'center' };
    
    // Column F: Words separated by hyphens? (under Image File)
    subHeaderRow.getCell(6).value = "Words separated by hyphens?";
    subHeaderRow.getCell(6).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    subHeaderRow.getCell(6).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    subHeaderRow.getCell(6).alignment = { vertical: 'middle', horizontal: 'center' };
    
    // Column G: Uppercase characters? (under Image File)
    subHeaderRow.getCell(7).value = "Uppercase characters?";
    subHeaderRow.getCell(7).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    subHeaderRow.getCell(7).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    subHeaderRow.getCell(7).alignment = { vertical: 'middle', horizontal: 'center', wrapText: false };
    
    // Column H: Special characters? (under Image File)
    subHeaderRow.getCell(8).value = "Special characters?";
    subHeaderRow.getCell(8).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    subHeaderRow.getCell(8).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    subHeaderRow.getCell(8).alignment = { vertical: 'middle', horizontal: 'center' };
    
    // Column I: File Size (under Image File)
    subHeaderRow.getCell(9).value = "File Size";
    subHeaderRow.getCell(9).font = { bold: true, size: 11, color: { argb: 'FFFFFFFF' } };
    subHeaderRow.getCell(9).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    subHeaderRow.getCell(9).alignment = { vertical: 'middle', horizontal: 'center' };
    
    // Column J: Result (empty, already has main heading above)
    subHeaderRow.getCell(10).value = "";
    subHeaderRow.getCell(10).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    
    subHeaderRow.height = 20;
    currentRow++;

    // Data rows
    data.forEach((item, index) => {
        const dataRow = worksheet.getRow(currentRow);
        
        // Apply alternating row colors (odd = white, even = light gray)
        const isEvenRow = (index + 1) % 2 === 0;
        const rowBgColor = isEvenRow ? 'FFF2F2F2' : 'FFFFFFFF'; // Light gray for even, white for odd
        
        // Set background color for all cells in the row
        for (let col = 1; col <= 10; col++) {
            const cell = dataRow.getCell(col);
            // Only set background if cell doesn't have a specific color (like green/red for status)
            // We'll set it conditionally below for cells that need special colors
        }
        
        // Image Link (with hyperlink if it's a URL)
        const imageLinkCell = dataRow.getCell(1);
        imageLinkCell.value = item.imageLink || "";
        if (item.imageLink && (item.imageLink.startsWith('http://') || item.imageLink.startsWith('https://'))) {
            imageLinkCell.value = {
                text: item.imageLink,
                hyperlink: item.imageLink
            };
            imageLinkCell.font = { color: { argb: 'FF0000FF' }, underline: true }; // Blue color for links
        }
        // Set row background color if no special color
        if (!imageLinkCell.fill) {
            imageLinkCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: rowBgColor }
            };
        }
        
        // Alternate Text Content
        const altTextCell = dataRow.getCell(2);
        altTextCell.value = item.altTextContent || "";
        altTextCell.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: rowBgColor }
        };
        
        // Words separated by spaces?
        const wordsSpacesCell = dataRow.getCell(3);
        wordsSpacesCell.value = item.wordsSeparatedBySpaces || "";
        wordsSpacesCell.alignment = { vertical: 'middle', horizontal: 'center' };
        if (item.wordsSeparatedBySpaces && item.wordsSeparatedBySpaces.toUpperCase() === "YES") {
            wordsSpacesCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green (overrides row color)
            };
        } else if (item.wordsSeparatedBySpaces && item.wordsSeparatedBySpaces.toUpperCase() === "NO") {
            wordsSpacesCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red (overrides row color)
            };
        } else {
            wordsSpacesCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: rowBgColor }
            };
        }
        
        // File name
        const fileNameCell = dataRow.getCell(4);
        fileNameCell.value = item.fileName || "";
        fileNameCell.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: rowBgColor }
        };
        
        // LEN
        const lenCell = dataRow.getCell(5);
        lenCell.value = item.len || "";
        lenCell.alignment = { vertical: 'middle', horizontal: 'center' };
        if (item.len && /^\d+$/.test(item.len)) {
            lenCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green (overrides row color)
            };
        } else {
            lenCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: rowBgColor }
            };
        }
        
        // Words separated by hyphens?
        const wordsHyphensCell = dataRow.getCell(6);
        wordsHyphensCell.value = item.wordsSeparatedByHyphens || "";
        wordsHyphensCell.alignment = { vertical: 'middle', horizontal: 'center' };
        if (item.wordsSeparatedByHyphens && item.wordsSeparatedByHyphens.toUpperCase() === "YES") {
            wordsHyphensCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green (overrides row color)
            };
        } else {
            wordsHyphensCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: rowBgColor }
            };
        }
        
        // Uppercase characters?
        const uppercaseCell = dataRow.getCell(7);
        uppercaseCell.value = item.uppercaseCharacters || "";
        uppercaseCell.alignment = { vertical: 'middle', horizontal: 'center' };
        if (item.uppercaseCharacters && item.uppercaseCharacters.toUpperCase() === "NO") {
            uppercaseCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green (overrides row color)
            };
        } else if (item.uppercaseCharacters && item.uppercaseCharacters.toUpperCase() === "YES") {
            uppercaseCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red (overrides row color)
            };
        } else {
            uppercaseCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: rowBgColor }
            };
        }
        
        // Special characters?
        const specialCharsCell = dataRow.getCell(8);
        specialCharsCell.value = item.specialCharacters || "";
        specialCharsCell.alignment = { vertical: 'middle', horizontal: 'center' };
        if (item.specialCharacters && item.specialCharacters.toUpperCase() === "NO") {
            specialCharsCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green (overrides row color)
            };
        } else if (item.specialCharacters && item.specialCharacters.toUpperCase() === "YES") {
            specialCharsCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red (overrides row color)
            };
        } else {
            specialCharsCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: rowBgColor }
            };
        }
        
        // File Size
        const fileSizeCell = dataRow.getCell(9);
        fileSizeCell.value = item.fileSize || "";
        fileSizeCell.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: rowBgColor }
        };
        
        // Result
        const resultCell = dataRow.getCell(10);
        resultCell.value = item.result || "";
        resultCell.alignment = { vertical: 'middle', horizontal: 'center' };
        if (item.result && item.result.toUpperCase() === "PASS") {
            resultCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green (overrides row color)
            };
            resultCell.font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
        } else if (item.result && item.result.toUpperCase() === "FAIL") {
            resultCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red (overrides row color)
            };
            resultCell.font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
        } else {
            resultCell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: rowBgColor }
            };
        }
        
        currentRow++;
    });

    return currentRow;
}

function addMetaViewportSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - in both column A and B
    const headerRow = worksheet.getRow(currentRow);
    headerRow.getCell(2).value = "Meta Viewport";
    headerRow.getCell(2).font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerRow.height = 20;
    currentRow++;

    // Meta viewport tag present row
    const viewportPresentRow = worksheet.getRow(currentRow);
    viewportPresentRow.getCell(1).value = "Meta viewport tag present?";
    viewportPresentRow.getCell(2).value = data.viewportPresent;
    viewportPresentRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    viewportPresentRow.getCell(1).font = { bold: true };
    addLabelBorders(viewportPresentRow.getCell(1));
    // Color coding (green if Yes)
    if (data.viewportPresent === "Yes") {
        viewportPresentRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
    }
    currentRow++;

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(2).value = data.status;
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addDoctypeSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Doctype";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;

    // Doctype Tag Present row
    const doctypePresentRow = worksheet.getRow(currentRow);
    doctypePresentRow.getCell(1).value = "Doctype Tag Present?";
    doctypePresentRow.getCell(2).value = data.doctypePresent;
    doctypePresentRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    doctypePresentRow.getCell(1).font = { bold: true };
    addLabelBorders(doctypePresentRow.getCell(1));
    // Color coding (green if Yes)
    if (data.doctypePresent === "Yes") {
        doctypePresentRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
    }
    currentRow++;

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(2).value = data.status;
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addHttpStatusCodeSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "HTTP Status Code";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;

    // HTTP Status Code row
    const statusCodeRow = worksheet.getRow(currentRow);
    statusCodeRow.getCell(1).value = "HTTP Status Code";
    statusCodeRow.getCell(2).value = data.httpStatusCode;
    statusCodeRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    statusCodeRow.getCell(1).font = { bold: true };
    addLabelBorders(statusCodeRow.getCell(1));
    // No background color for HTTP Status Code data
    currentRow++;

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(2).value = data.status;
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addGooglePageSpeedSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Google Page Speed Overall Score";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;

    // Desktop Score row
    const desktopRow = worksheet.getRow(currentRow);
    desktopRow.getCell(1).value = "Desktop Score";
    desktopRow.getCell(2).value = data.desktopScore;
    desktopRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    desktopRow.getCell(1).font = { bold: true };
    addLabelBorders(desktopRow.getCell(1));
    desktopRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' }; // Left align data
    // Color coding for desktop score: light green if >= 90, light red if < 90
    if (typeof data.desktopScore === 'number') {
        if (data.desktopScore >= 90) {
            desktopRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
        } else {
            desktopRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red
            };
        }
    }
    currentRow++;

    // Mobile Score row
    const mobileRow = worksheet.getRow(currentRow);
    mobileRow.getCell(1).value = "Mobile Score";
    mobileRow.getCell(2).value = data.mobileScore;
    mobileRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    mobileRow.getCell(1).font = { bold: true };
    addLabelBorders(mobileRow.getCell(1));
    mobileRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' }; // Left align data
    // Color coding for mobile score: light green if >= 90, light red if < 90
    if (typeof data.mobileScore === 'number') {
        if (data.mobileScore >= 90) {
            mobileRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
        } else {
            mobileRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red
            };
        }
    }
    currentRow++;

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(2).value = data.status;
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' }; // Left align data
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addLighthouseSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Lighthouse";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Helper function to add a category section (Performance, Accessibility, etc.)
    const addCategorySection = (categoryName, desktopScore, mobileScore) => {
        // Category label row
        const categoryRow = worksheet.getRow(currentRow);
        categoryRow.getCell(1).value = categoryName;
        categoryRow.getCell(1).font = { bold: true };
        categoryRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        addLabelBorders(categoryRow.getCell(1));
        currentRow++;

        // Desktop row
        const desktopRow = worksheet.getRow(currentRow);
        desktopRow.getCell(1).value = "Desktop";
        desktopRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        addLabelBorders(desktopRow.getCell(1));
        desktopRow.getCell(2).value = desktopScore;
        desktopRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' }; // Left align score
        // Color coding: light green if >= 90, light red if < 90
        if (typeof desktopScore === 'number') {
            if (desktopScore >= 90) {
                desktopRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFD9EAD3' } // Light green
                };
            } else {
                desktopRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF8D7DA' } // Light red
                };
            }
        }
        currentRow++;

        // Mobile row
        const mobileRow = worksheet.getRow(currentRow);
        mobileRow.getCell(1).value = "Mobile";
        mobileRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        addLabelBorders(mobileRow.getCell(1));
        mobileRow.getCell(2).value = mobileScore;
        mobileRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' }; // Left align score
        // Color coding: light green if >= 90, light red if < 90
        if (typeof mobileScore === 'number') {
            if (mobileScore >= 90) {
                mobileRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFD9EAD3' } // Light green
                };
            } else {
                mobileRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF8D7DA' } // Light red
                };
            }
        }
        currentRow++;
        // Removed empty row between categories
    };

    // Add all category sections
    addCategorySection("Performance", data.performanceDesktop, data.performanceMobile);
    addCategorySection("Accessibility", data.accessibilityDesktop, data.accessibilityMobile);
    addCategorySection("Best Practices", data.bestPracticesDesktop, data.bestPracticesMobile);
    addCategorySection("SEO", data.seoDesktop, data.seoMobile);

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    addLabelBorders(resultRow.getCell(1));
    resultRow.getCell(2).value = data.status;
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' }; // Left align result
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addCoreWebVitalsSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Core Web Vitals";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Helper function to determine if a score is good (green) or bad (red)
    // Based on typical Core Web Vitals thresholds
    const isGoodScore = (metricName, value, isDesktop) => {
        if (typeof value !== 'number') return null; // Can't determine for non-numeric values
        
        // Check if there's a status element in the DOM
        const el = document.querySelector('.analysis-card[data-name="core_web_vitals"]');
        if (el) {
            // Try to find status indicators - these would be in the HTML structure
            // For now, use typical thresholds
            switch(metricName) {
                case 'LCP': return value < 2.5; // Good if < 2.5s
                case 'FID': return value < 100; // Good if < 100ms
                case 'CLS': return value < 0.1; // Good if < 0.1
                case 'FCP': return value < 1.8; // Good if < 1.8s
                case 'TTI': return value < 3.8; // Good if < 3.8s
                case 'SI': return value < 3.4; // Good if < 3.4s
                case 'TBT': return value < 200; // Good if < 200ms
                default: return null;
            }
        }
        return null;
    };

    // Helper function to get unit description
    const getUnitDescription = (metricName) => {
        switch(metricName) {
            case 'LCP': return "measured in seconds";
            case 'FID': return "measured in milliseconds";
            case 'CLS': return ""; // CLS has no unit description
            case 'FCP': return "measured in seconds";
            case 'TTI': return "measured in seconds";
            case 'SI': return "measured in seconds";
            case 'TBT': return "measured in milliseconds";
            default: return "";
        }
    };

    // Helper function to format value with unit
    const formatValue = (value, metricName) => {
        if (value === "N/A") return "N/A";
        if (typeof value === 'number') {
            // Return just the number without "s" or "ms" extensions
            return value.toString();
        }
        return value.toString();
    };

    // Helper function to add a metric section
    const addMetricSection = (metricName, desktopValue, mobileValue) => {
        // Metric name row
        const metricRow = worksheet.getRow(currentRow);
        metricRow.getCell(1).value = metricName;
        metricRow.getCell(1).font = { bold: true };
        metricRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        addLabelBorders(metricRow.getCell(1));
        
        const unitDesc = getUnitDescription(metricName);
        if (unitDesc) {
            metricRow.getCell(2).value = unitDesc;
            metricRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
        }
        currentRow++;

        // Desktop row
        const desktopRow = worksheet.getRow(currentRow);
        desktopRow.getCell(1).value = "Desktop";
        desktopRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        addLabelBorders(desktopRow.getCell(1));
        desktopRow.getCell(2).value = formatValue(desktopValue, metricName);
        desktopRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' }; // Left align score
        
        // Color coding based on thresholds
        const desktopIsGood = isGoodScore(metricName, desktopValue, true);
        if (desktopIsGood === true) {
            desktopRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
        } else if (desktopIsGood === false) {
            desktopRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red
            };
        }
        currentRow++;

        // Mobile row
        const mobileRow = worksheet.getRow(currentRow);
        mobileRow.getCell(1).value = "Mobile";
        mobileRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        addLabelBorders(mobileRow.getCell(1));
        mobileRow.getCell(2).value = formatValue(mobileValue, metricName);
        mobileRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' }; // Left align score
        
        // Color coding based on thresholds
        const mobileIsGood = isGoodScore(metricName, mobileValue, false);
        if (mobileIsGood === true) {
            mobileRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
        } else if (mobileIsGood === false) {
            mobileRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red
            };
        }
        currentRow++;
        // Removed empty row between metrics
    };

    // Add all metric sections: LCP, CLS, FCP, TTI, SI, TBT
    addMetricSection("LCP", data.lcpDesktop, data.lcpMobile);
    addMetricSection("CLS", data.clsDesktop, data.clsMobile);
    addMetricSection("FCP", data.fcpDesktop, data.fcpMobile);
    addMetricSection("TTI", data.ttiDesktop, data.ttiMobile);
    addMetricSection("SI", data.siDesktop, data.siMobile);
    addMetricSection("TBT", data.tbtDesktop, data.tbtMobile);

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    addLabelBorders(resultRow.getCell(1));
    resultRow.getCell(2).value = data.status;
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' }; // Left align result
    // Color coding for result (background colors only, text is black and bold)
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true }; // Black text, bold
    }
    currentRow++;

    return currentRow;
}

function addMobileFriendlinessSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Mobile Friendliness";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "Page is mobile friendly" : "Page is not mobile friendly");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addGzipCompressionSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Gzip Compression";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "Gzip compression enabled" : "Gzip compression is not enabled");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addHtmlCompressionSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "HTML Compression";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "HTML compression enabled" : "HTML compression is not enabled");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addCssCompressionSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "CSS Compression";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "CSS compression enabled" : "CSS compression is not enabled");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addJsCompressionSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "JS Compression";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "JS compression enabled" : "JS compression is not enabled");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addCssCachingSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "CSS Caching";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "CSS Caching enabled" : "CSS Caching is not enabled");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addJsCachingSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "JS Caching";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "JS Caching enabled" : "JS Caching is not enabled");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addPageSizeSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Page Size";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // HTML Page Size row
    const htmlPageSizeRow = worksheet.getRow(currentRow);
    htmlPageSizeRow.getCell(1).value = "HTML Page Size";
    htmlPageSizeRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(htmlPageSizeRow.getCell(1));
    htmlPageSizeRow.getCell(2).value = data.htmlPageSize;
    htmlPageSizeRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    currentRow++;

    // Result row
    const isPass = data.status.toUpperCase() === "PASS";
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    resultRow.getCell(2).value = data.status;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addNestedTablesSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Nested Tables";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "Nested tables does not exist" : "Nested tables exist");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addFramesetSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Frameset";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "Frameset tag does not exist" : "Frameset tag exists");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addBrokenLinksSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Broken Link Test";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Table headers with light blue background
    const headerTableRow = worksheet.getRow(currentRow);
    headerTableRow.getCell(1).value = "URL";
    headerTableRow.getCell(2).value = "HTTP Status Code";

    // Style header cells with light blue background
    for (let col = 1; col <= 2; col++) {
        const headerCell = headerTableRow.getCell(col);
        headerCell.font = { bold: true, size: 11, color: { argb: 'FF000000' } };
        headerCell.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
        };
        headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
        headerCell.border = {
            top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
            left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
            bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
            right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
        };
    }
    headerTableRow.height = 20;
    currentRow++;

    // Data rows
    data.forEach((item, index) => {
        const dataRow = worksheet.getRow(currentRow);
        
        // URL column
        dataRow.getCell(1).value = item.url;
        dataRow.getCell(1).alignment = { vertical: 'middle', horizontal: 'left' };
        dataRow.getCell(1).wrapText = true;
        
        // HTTP Status Code column
        dataRow.getCell(2).value = item.statusCode;
        dataRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'center' };
        dataRow.getCell(2).font = { bold: true };
        
        // Add borders to all cells
        for (let col = 1; col <= 2; col++) {
            const cell = dataRow.getCell(col);
            cell.border = {
                top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
                left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
                bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
                right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
            };
        }
        
        // Alternate row background colors (odd rows white, even rows light gray)
        const rowBgColor = index % 2 === 0 ? 'FFFFFFFF' : 'FFF2F2F2'; // White for odd, light gray for even
        for (let col = 1; col <= 2; col++) {
            dataRow.getCell(col).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: rowBgColor }
            };
        }
        
        dataRow.height = 20;
        currentRow++;
    });

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    
    // If broken links found, status is FAIL, otherwise PASS
    const hasBrokenLinks = data && data.length > 0;
    const resultStatus = hasBrokenLinks ? "FAIL" : "PASS";
    const resultMessage = hasBrokenLinks ? `${data.length} broken link(s) found` : "No broken links found";
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    if (resultStatus.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
    }
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addUnsafeCrossOriginLinksSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Unsafe Cross Origin Links";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Table header with light blue background (only URL column)
    const headerTableRow = worksheet.getRow(currentRow);
    headerTableRow.getCell(1).value = "URL";

    // Style header cell with light blue background
    const headerCell1 = headerTableRow.getCell(1);
    headerCell1.font = { bold: true, size: 11, color: { argb: 'FF000000' } };
    headerCell1.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    headerCell1.alignment = { vertical: 'middle', horizontal: 'center' };
    headerCell1.border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    headerTableRow.height = 20;
    currentRow++;

    // Data rows
    data.forEach((item, index) => {
        const dataRow = worksheet.getRow(currentRow);
        
        // URL column
        dataRow.getCell(1).value = item.url;
        dataRow.getCell(1).alignment = { vertical: 'middle', horizontal: 'left' };
        dataRow.getCell(1).wrapText = true;
        
        // Add borders to cell
        const cell = dataRow.getCell(1);
        cell.border = {
            top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
            left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
            bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
            right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
        };
        
        // Alternate row background colors (odd rows white, even rows light gray)
        const rowBgColor = index % 2 === 0 ? 'FFFFFFFF' : 'FFF2F2F2'; // White for odd, light gray for even
        dataRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: rowBgColor }
        };
        
        dataRow.height = 20;
        currentRow++;
    });

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    
    // If links found, status is FAIL, otherwise PASS
    const hasLinks = data && data.length > 0;
    const resultStatus = hasLinks ? "FAIL" : "PASS";
    const resultMessage = hasLinks ? `${data.length} unsafe cross-origin link(s) found` : "No unsafe cross-origin links found";
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    if (resultStatus.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
    }
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addProtocolRelativeResourceLinksSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Protocol Relative Resource Links";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Table header with light blue background (only URL column)
    const headerTableRow = worksheet.getRow(currentRow);
    headerTableRow.getCell(1).value = "URL";

    // Style header cell with light blue background
    const headerCell1 = headerTableRow.getCell(1);
    headerCell1.font = { bold: true, size: 11, color: { argb: 'FF000000' } };
    headerCell1.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFB4C6E7' } // Light cornflower blue 3
    };
    headerCell1.alignment = { vertical: 'middle', horizontal: 'center' };
    headerCell1.border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    headerTableRow.height = 20;
    currentRow++;

    // Data rows
    data.forEach((item, index) => {
        const dataRow = worksheet.getRow(currentRow);
        
        // URL column
        dataRow.getCell(1).value = item.url;
        dataRow.getCell(1).alignment = { vertical: 'middle', horizontal: 'left' };
        dataRow.getCell(1).wrapText = true;
        
        // Add borders to cell
        const cell = dataRow.getCell(1);
        cell.border = {
            top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
            left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
            bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
            right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
        };
        
        // Alternate row background colors (odd rows white, even rows light gray)
        const rowBgColor = index % 2 === 0 ? 'FFFFFFFF' : 'FFF2F2F2'; // White for odd, light gray for even
        dataRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: rowBgColor }
        };
        
        dataRow.height = 20;
        currentRow++;
    });

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    
    // If links found, status is FAIL, otherwise PASS
    const hasLinks = data && data.length > 0;
    const resultStatus = hasLinks ? "FAIL" : "PASS";
    const resultMessage = hasLinks ? `${data.length} protocol relative resource link(s) found` : "No protocol relative resource links found";
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    if (resultStatus.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
    }
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addSafeBrowsingSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Safe Browsing";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "URL is safe for browsing" : "URL is not safe for browsing");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addXFrameOptionsHeaderSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "X Frame Options Header Test";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "X Frame options header found" : "X Frame options header not found");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addHstsHeaderSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "HSTS Header";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "HSTS header found" : "HSTS header not found");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addBadContentTypeSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Bad Content Type";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "Content type defined" : "Content type not define");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addSslCertificateSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "SSL Certificate";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "SSL Certificate is enabled" : "SSL Certificate is not enabled");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addDirectoryBrowsingSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Directory Browsing";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    // Note: For Directory Browsing, PASS means it's disabled (good), FAIL means it's enabled (bad)
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "Directory Browsing is disabled" : "Directory Browsing is enabled");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS (disabled), light red for FAIL (enabled)
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addOpenGraphSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Open Graph Tags";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // === OG TITLE TAG SECTION ===
    if (data.ogTitle && data.ogTitle.content) {
        // OG Title Tag row
        const titleRow = worksheet.getRow(currentRow);
        titleRow.getCell(1).value = "OG Title Tag";
        titleRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        titleRow.getCell(1).font = { bold: true };
        addLabelBorders(titleRow.getCell(1));
        titleRow.getCell(2).value = data.ogTitle.content;
        titleRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
        currentRow++;

        // Issues row
        if (data.ogTitle.issues && data.ogTitle.issues !== 'N/A' && data.ogTitle.issues.trim() !== '' && data.ogTitle.issues !== 'No problems found.') {
            const issuesRow = worksheet.getRow(currentRow);
            issuesRow.getCell(1).value = "Issues";
            issuesRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            issuesRow.getCell(1).font = { bold: true };
            addLabelBorders(issuesRow.getCell(1));
            issuesRow.getCell(2).value = data.ogTitle.issues;
            issuesRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            currentRow++;
        }

        // Result row
        if (data.ogTitle.status) {
            const resultRow = worksheet.getRow(currentRow);
            resultRow.getCell(1).value = "Result";
            resultRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            resultRow.getCell(1).font = { bold: true };
            addLabelBorders(resultRow.getCell(1));
            resultRow.getCell(2).value = data.ogTitle.status;
            resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
            resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            if (data.ogTitle.status.toUpperCase() === "PASS") {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFD9EAD3' } // Light green
                };
            } else {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF8D7DA' } // Light red
                };
            }
            currentRow++;
        }
    }

    // Empty row between sections
    currentRow++;

    // === OG DESCRIPTION SECTION ===
    if (data.ogDescription && data.ogDescription.content) {
        // OG Description row
        const descRow = worksheet.getRow(currentRow);
        descRow.getCell(1).value = "OG Description";
        descRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        descRow.getCell(1).font = { bold: true };
        addLabelBorders(descRow.getCell(1));
        descRow.getCell(2).value = data.ogDescription.content;
        descRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
        currentRow++;

        // Issues row
        if (data.ogDescription.issues && data.ogDescription.issues !== 'N/A' && data.ogDescription.issues.trim() !== '' && data.ogDescription.issues !== 'No problems found.') {
            const issuesRow = worksheet.getRow(currentRow);
            issuesRow.getCell(1).value = "Issues";
            issuesRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            issuesRow.getCell(1).font = { bold: true };
            addLabelBorders(issuesRow.getCell(1));
            issuesRow.getCell(2).value = data.ogDescription.issues;
            issuesRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            currentRow++;
        }

        // Result row
        if (data.ogDescription.status) {
            const resultRow = worksheet.getRow(currentRow);
            resultRow.getCell(1).value = "Result";
            resultRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            resultRow.getCell(1).font = { bold: true };
            addLabelBorders(resultRow.getCell(1));
            resultRow.getCell(2).value = data.ogDescription.status;
            resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
            resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            if (data.ogDescription.status.toUpperCase() === "PASS") {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFD9EAD3' } // Light green
                };
            } else {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF8D7DA' } // Light red
                };
            }
            currentRow++;
        }
    }

    // Empty row between sections
    currentRow++;

    // === OG URL SECTION ===
    if (data.ogUrl && data.ogUrl.content) {
        // Og URL row
        const urlRow = worksheet.getRow(currentRow);
        urlRow.getCell(1).value = "Og URL";
        urlRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        urlRow.getCell(1).font = { bold: true };
        addLabelBorders(urlRow.getCell(1));
        urlRow.getCell(2).value = data.ogUrl.content;
        urlRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
        currentRow++;

        // Issues row
        if (data.ogUrl.issues && data.ogUrl.issues !== 'N/A' && data.ogUrl.issues.trim() !== '' && data.ogUrl.issues !== 'No problems found.') {
            const issuesRow = worksheet.getRow(currentRow);
            issuesRow.getCell(1).value = "Issues";
            issuesRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            issuesRow.getCell(1).font = { bold: true };
            addLabelBorders(issuesRow.getCell(1));
            issuesRow.getCell(2).value = data.ogUrl.issues;
            issuesRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            currentRow++;
        }

        // Result row
        if (data.ogUrl.status) {
            const resultRow = worksheet.getRow(currentRow);
            resultRow.getCell(1).value = "Result";
            resultRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            resultRow.getCell(1).font = { bold: true };
            addLabelBorders(resultRow.getCell(1));
            resultRow.getCell(2).value = data.ogUrl.status;
            resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
            resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            if (data.ogUrl.status.toUpperCase() === "PASS") {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFD9EAD3' } // Light green
                };
            } else {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF8D7DA' } // Light red
                };
            }
            currentRow++;
        }
    }

    // Empty row between sections
    currentRow++;

    // === OG IMAGE SECTION ===
    if (data.ogImage && data.ogImage.content) {
        // OG Image row
        const imageRow = worksheet.getRow(currentRow);
        imageRow.getCell(1).value = "OG Image";
        imageRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        imageRow.getCell(1).font = { bold: true };
        addLabelBorders(imageRow.getCell(1));
        imageRow.getCell(2).value = data.ogImage.content;
        imageRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
        currentRow++;

        // Issues row
        if (data.ogImage.issues && data.ogImage.issues !== 'N/A' && data.ogImage.issues.trim() !== '' && data.ogImage.issues !== 'No problems found.') {
            const issuesRow = worksheet.getRow(currentRow);
            issuesRow.getCell(1).value = "Issues";
            issuesRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            issuesRow.getCell(1).font = { bold: true };
            addLabelBorders(issuesRow.getCell(1));
            issuesRow.getCell(2).value = data.ogImage.issues;
            issuesRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            currentRow++;
        }

        // Result row
        if (data.ogImage.status) {
            const resultRow = worksheet.getRow(currentRow);
            resultRow.getCell(1).value = "Result";
            resultRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            resultRow.getCell(1).font = { bold: true };
            addLabelBorders(resultRow.getCell(1));
            resultRow.getCell(2).value = data.ogImage.status;
            resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
            resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            if (data.ogImage.status.toUpperCase() === "PASS") {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFD9EAD3' } // Light green
                };
            } else {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF8D7DA' } // Light red
                };
            }
            currentRow++;
        }
    }

    return currentRow;
}

function addTwitterTagsSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Twitter Tags";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // === TWITTER TITLE SECTION ===
    if (data.twitterTitle && data.twitterTitle.content) {
        // Twitter Title row
        const titleRow = worksheet.getRow(currentRow);
        titleRow.getCell(1).value = "Twitter Title";
        titleRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        titleRow.getCell(1).font = { bold: true };
        addLabelBorders(titleRow.getCell(1));
        titleRow.getCell(2).value = data.twitterTitle.content;
        titleRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
        currentRow++;

        // Issues row
        if (data.twitterTitle.issues && data.twitterTitle.issues !== 'N/A' && data.twitterTitle.issues.trim() !== '') {
            const issuesRow = worksheet.getRow(currentRow);
            issuesRow.getCell(1).value = "Issues";
            issuesRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            issuesRow.getCell(1).font = { bold: true };
            addLabelBorders(issuesRow.getCell(1));
            issuesRow.getCell(2).value = data.twitterTitle.issues;
            issuesRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            currentRow++;
        }

        // Result row
        if (data.twitterTitle.status) {
            const resultRow = worksheet.getRow(currentRow);
            resultRow.getCell(1).value = "Result";
            resultRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            resultRow.getCell(1).font = { bold: true };
            addLabelBorders(resultRow.getCell(1));
            resultRow.getCell(2).value = data.twitterTitle.status;
            resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
            resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            if (data.twitterTitle.status.toUpperCase() === "PASS") {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFD9EAD3' } // Light green
                };
            } else {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF8D7DA' } // Light red
                };
            }
            currentRow++;
        }
    }

    // Empty row between sections
    currentRow++;

    // === TWITTER IMAGE SECTION ===
    if (data.twitterImage && data.twitterImage.content) {
        // Twitter Image row
        const imageRow = worksheet.getRow(currentRow);
        imageRow.getCell(1).value = "Twitter Image";
        imageRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        imageRow.getCell(1).font = { bold: true };
        addLabelBorders(imageRow.getCell(1));
        imageRow.getCell(2).value = data.twitterImage.content;
        imageRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
        currentRow++;

        // Width row
        if (data.twitterImage.width && data.twitterImage.width !== 'N/A') {
            const widthRow = worksheet.getRow(currentRow);
            widthRow.getCell(1).value = "Width (px)";
            widthRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            widthRow.getCell(1).font = { bold: true };
            addLabelBorders(widthRow.getCell(1));
            widthRow.getCell(2).value = data.twitterImage.width;
            widthRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
            widthRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
            currentRow++;
        }

        // Height row
        if (data.twitterImage.height && data.twitterImage.height !== 'N/A') {
            const heightRow = worksheet.getRow(currentRow);
            heightRow.getCell(1).value = "Height (px)";
            heightRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            heightRow.getCell(1).font = { bold: true };
            addLabelBorders(heightRow.getCell(1));
            heightRow.getCell(2).value = data.twitterImage.height;
            heightRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
            heightRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
            currentRow++;
        }

        // Result row
        if (data.twitterImage.status) {
            const resultRow = worksheet.getRow(currentRow);
            resultRow.getCell(1).value = "Result";
            resultRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            resultRow.getCell(1).font = { bold: true };
            addLabelBorders(resultRow.getCell(1));
            resultRow.getCell(2).value = data.twitterImage.status;
            resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
            resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            if (data.twitterImage.status.toUpperCase() === "PASS") {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFD9EAD3' } // Light green
                };
            } else {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF8D7DA' } // Light red
                };
            }
            currentRow++;
        }
    }

    // Empty row between sections
    currentRow++;

    // === TWITTER IMAGE ALT SECTION ===
    if (data.twitterImageAlt && data.twitterImageAlt.content) {
        // Twitter Image Alt row
        const imageAltRow = worksheet.getRow(currentRow);
        imageAltRow.getCell(1).value = "Twitter Image Alt";
        imageAltRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        imageAltRow.getCell(1).font = { bold: true };
        addLabelBorders(imageAltRow.getCell(1));
        imageAltRow.getCell(2).value = data.twitterImageAlt.content;
        imageAltRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
        currentRow++;

        // Length row
        if (data.twitterImageAlt.length !== undefined && data.twitterImageAlt.length !== 'N/A') {
            const lengthRow = worksheet.getRow(currentRow);
            lengthRow.getCell(1).value = "Length";
            lengthRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            lengthRow.getCell(1).font = { bold: true };
            addLabelBorders(lengthRow.getCell(1));
            lengthRow.getCell(2).value = data.twitterImageAlt.length;
            lengthRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
            lengthRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
            currentRow++;
        }

        // Result row
        if (data.twitterImageAlt.status) {
            const resultRow = worksheet.getRow(currentRow);
            resultRow.getCell(1).value = "Result";
            resultRow.getCell(1).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD3D3D3' } // Light grey 2
            };
            resultRow.getCell(1).font = { bold: true };
            addLabelBorders(resultRow.getCell(1));
            resultRow.getCell(2).value = data.twitterImageAlt.status;
            resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
            resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
            if (data.twitterImageAlt.status.toUpperCase() === "PASS") {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFD9EAD3' } // Light green
                };
            } else {
                resultRow.getCell(2).fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF8D7DA' } // Light red
                };
            }
            currentRow++;
        }
    }

    return currentRow;
}

function addFaviconSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Favicon Test";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "Favicon exists" : "Favicon does not exist");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left' };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

function addUrlSlugSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "URL Slug";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;

    // Slug row
    const slugRow = worksheet.getRow(currentRow);
    slugRow.getCell(1).value = "Slug";
    slugRow.getCell(2).value = data.slug;
    slugRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    slugRow.getCell(1).font = { bold: true };
    addLabelBorders(slugRow.getCell(1));
    slugRow.getCell(2).alignment = { wrapText: true, vertical: 'top' };
    slugRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD9EAD3' } // Light green
    };
    currentRow++;

    // Length row
    const lengthRow = worksheet.getRow(currentRow);
    lengthRow.getCell(1).value = "Length";
    lengthRow.getCell(2).value = data.length;
    lengthRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    lengthRow.getCell(1).font = { bold: true };
    addLabelBorders(lengthRow.getCell(1));
    lengthRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD9EAD3' } // Light green
    };
    currentRow++;

    // Has Special Characters row
    if (data.hasSpecialChars !== "N/A") {
        const specialCharsRow = worksheet.getRow(currentRow);
        specialCharsRow.getCell(1).value = "Has Special Characters?";
        specialCharsRow.getCell(2).value = data.hasSpecialChars;
        specialCharsRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        specialCharsRow.getCell(1).font = { bold: true };
        addLabelBorders(specialCharsRow.getCell(1));
        if (data.hasSpecialChars === "Yes") {
            specialCharsRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red
            };
        } else {
            specialCharsRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
        }
        currentRow++;
    }

    // Words Separated By Hyphens Only row
    if (data.wordsByHyphens !== "N/A") {
        const hyphensRow = worksheet.getRow(currentRow);
        hyphensRow.getCell(1).value = "Words Separated By Hyphens Only?";
        hyphensRow.getCell(2).value = data.wordsByHyphens;
        hyphensRow.getCell(1).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD3D3D3' } // Light grey 2
        };
        hyphensRow.getCell(1).font = { bold: true };
        addLabelBorders(hyphensRow.getCell(1));
        if (data.wordsByHyphens === "Yes") {
            hyphensRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFD9EAD3' } // Light green
            };
        } else {
            hyphensRow.getCell(2).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFF8D7DA' } // Light red
            };
        }
        currentRow++;
    }

    // Result row
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(2).value = data.status;
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2
    };
    resultRow.getCell(1).font = { bold: true };
    addLabelBorders(resultRow.getCell(1));
    if (data.status.toUpperCase() === "PASS") {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFD9EAD3' } // Light green
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
    } else {
        resultRow.getCell(2).fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFF8D7DA' } // Light red
        };
        resultRow.getCell(2).font = { color: { argb: 'FF000000' }, bold: true };
    }
    currentRow++;

    return currentRow;
}

function addRobotsTxtSection(worksheet, data, startRow) {
    let currentRow = startRow;

    // Header row with blue background - merge columns A and B for header
    const headerRow = worksheet.getRow(currentRow);
    worksheet.mergeCells(currentRow, 1, currentRow, 2);
    const headerCell = headerRow.getCell(1);
    headerCell.value = "Robots.txt Test";
    headerCell.font = { bold: true, size: 12, color: { argb: 'FFFFFFFF' } };
    headerCell.fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FF37A1E4' } // #37a1e4 background
    };
    headerCell.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 20;
    currentRow++;
    currentRow++; // Empty row after header

    // Determine if PASS or FAIL based on status
    const isPass = data.status.toUpperCase() === "PASS";
    
    // Show only one result row based on actual status
    const resultRow = worksheet.getRow(currentRow);
    resultRow.getCell(1).value = "Result";
    resultRow.getCell(1).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: 'FFD3D3D3' } // Light grey 2 - same as other test labels
    };
    addLabelBorders(resultRow.getCell(1));
    
    // Use message from data if available, otherwise use default messages
    const resultMessage = data.message && data.message !== "N/A" ? data.message : 
                         (isPass ? "Robots.txt exists" : "Robots.txt does not exist");
    
    resultRow.getCell(2).value = resultMessage;
    resultRow.getCell(2).fill = {
        type: 'pattern',
        pattern: 'solid',
        fgColor: { argb: isPass ? 'FFD9EAD3' : 'FFF8D7DA' } // Light green for PASS, light red for FAIL
    };
    resultRow.getCell(2).alignment = { vertical: 'middle', horizontal: 'left', wrapText: true };
    // Add borders to result cell
    resultRow.getCell(2).border = {
        top: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        left: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        bottom: { style: 'thin', color: { argb: 'FFD3D3D3' } },
        right: { style: 'thin', color: { argb: 'FFD3D3D3' } }
    };
    // Ensure result cell is not merged
    resultRow.getCell(2).merge = null;
    currentRow++;

    return currentRow;
}

