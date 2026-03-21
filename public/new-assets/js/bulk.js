var modalEmail = new bootstrap.Modal(document.getElementById('modalEmail'), {
    keyboard: false 
})

class Controls{
    static defaultData = {}
    static CSV_NAME = "Marketing QA Tool Results.csv";
    static init(){
        this.saveDefaultSettings()
        runEmail()
    }


    static updateHTTPInput(){
        let val = ""
        $(".http-checkbox").each(function(el){
          if(this.checked){
            val+=this.value + ","
          }
        })
    
        val = val.substring(0, val.length - 1);
    
        $("#http_status_code_accepted").val(val)
    }


    static buildCSV(csvName) {
        // Get the original table structure to preserve headers
        const originalTable = $(".test_result_area table").clone()[0];
        
        // Get the DataTable instance
        const dataTable = $('.custom-dataTable').DataTable();
        
        // Get all data from DataTable (not just current page)
        const allData = dataTable.data().toArray();
        
        // Create a new table element with all data
        const table = document.createElement('table');
        
        // Copy the header structure from the original table
        const originalThead = originalTable.querySelector('thead');
        if (originalThead) {
            const newThead = originalThead.cloneNode(true);
            table.appendChild(newThead);
        }
        
        const tbody = document.createElement('tbody');
        
        // Add all data rows
        allData.forEach(rowData => {
            const row = document.createElement('tr');
            rowData.forEach(cellData => {
                const td = document.createElement('td');
                
                // Handle different types of cell data
                if (typeof cellData === 'string') {
                    // If it's a string, check if it contains HTML
                    if (cellData.includes('<')) {
                        // Create a temporary div to extract text from HTML
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = cellData;
                        
                        // Check if it contains an anchor tag with href
                        const anchor = tempDiv.querySelector('a');
                        if (anchor && anchor.href) {
                            td.textContent = anchor.href;
                        } else {
                            td.textContent = tempDiv.textContent || tempDiv.innerText || '';
                        }
                    } else {
                        td.textContent = cellData;
                    }
                } else if (cellData && cellData.nodeType) {
                    // If it's a DOM element, check if it's an anchor with href
                    if (cellData.tagName && cellData.tagName.toLowerCase() === 'a' && cellData.href) {
                        td.textContent = cellData.href;
                    } else {
                        td.textContent = cellData.textContent || cellData.innerText || '';
                    }
                } else {
                    td.textContent = cellData || '';
                }
                
                row.appendChild(td);
            });
            tbody.appendChild(row);
        });
        
        table.appendChild(tbody);
        
        // Remove hidden elements
        $(table).find(".export-hidden-element").remove();
    
        // Replace td content with td-replace attribute value if it exists
        $(table)
            .find("td[td-replace]")
            .each(function () {
                const replacementValue = $(this).attr("td-replace");
                if (replacementValue) {
                    $(this).text(replacementValue); // Replace td content with attribute value
                }
            });
        const exporter = new TableCSVExporter(table, csvName);
        exporter.downloadCSV();
    }
    

    static emailReport(){
        modalEmail.toggle()
    }


    static saveDefaultSettings(){
        document.querySelectorAll(".bulk-test-criteria input,.bulk-test-criteria textarea").forEach(el=>{
            if(el.getAttribute("type") == "checkbox"){
                Controls.defaultData[el.id] = el.checked
            }else{
                Controls.defaultData[el.id] = (isInt(el.value)) ? parseInt(el.value) : el.value
            }
        })

    }

    static resetDefaultSettings(){
        for(const property in Controls.defaultData) {
            if($(`#${property}`).attr("type") == "checkbox"){
                $(`#${property}`).prop('checked', Controls.defaultData[property]);
            }
            $(`#${property}`).val(Controls.defaultData[property])
        }
    }
}


class UI{
    static getBrokenLinks(allLinks){
        let html = ""
        let i = 0
        let brokenUrls = []
        
        // Collect all broken URLs first
        for (var key in allLinks) {
          if (allLinks.hasOwnProperty(key)) {
              let status
              const state = allLinks[key]["state"];
  
              if(state == "fulfilled"){
                const value = allLinks[key]["value"];
                status = value["status"]
              }else{
                status = 404
              }
  
              if(status != 200 && status != 0 && status != 405){
                brokenUrls.push({url: key, status: status})
              }
          }
        }
        
        if(brokenUrls.length === 0){
            return "NA"
        }
        
        // Add table header
        html += `<table class="bulk-broken-links-table">
          <thead>
            <tr>
              <th>#</th>
              <th>URL</th>
              <th>HTTP Status Code</th>
            </tr>
          </thead>
          <tbody>`
        
        // Display broken links
        brokenUrls.forEach((item, index) => {
          
          html+=`<tr>
            <td class="serial-number">${index+1}</td>
            <td>
              <div class="url-cell">
                <a href="${item.url}" target="_blank"><span class="broken-link-url">${item.url}</span></a>
              </div>
            </td>
            <td><strong>${item.status}</strong></td>
          </tr>`
        })
        
        html += `</tbody></table>`
        return html
    }
  
    static displayErrorNoTest(){
        const alert = buildAlert("All the urls you tested returned a 404. Please try again.")
        $(".footer_search_item").prepend(alert)
    }


    static toggleBulkTable(id){
        const prevId = $(".table-cat-element.active").attr("data-name")
        $(".table-cat-element.active").removeClass("active")
        $(`[data-name=${id}]`).addClass("active")

        $(`#${prevId}`).addClass("d-none")
        $(`#${id}`).removeClass("d-none")
    }

    static bulkContentRedirect(el){
        $(".single-post-left-sidebar a.active").removeClass("active")
        $(el).addClass("active")
        const HREF = el.getAttribute("href")
        scrollToSection(`${HREF}`);
    }

    static toggleTestCriteria(el){
        $(el).toggleClass("active");
        $(".tools_meta_content").slideToggle();
    }

    static scrollToSection(){
        scrollToSection(".test_result_area")
    }


static getTableTop(label, slug){
        let div = ""
        let csvName = this.prepareCsvName(slug);
        if(label === "og:title"){
            div = `
            <div class="bulk-table-category">
                <div class="table-cat-element active" data-name="table_og_title"><span>Open Graph Title</span></div>
                <div class="table-cat-element" data-name="table_og_desc"><span>Open Graph Description</span></div>
                <div class="table-cat-element" data-name="table_og_url"><span>Open Graph URL</span></div>
                <div class="table-cat-element" data-name="table_og_image"><span>Open Graph Image</span></div>
            </div>
            <div class="download_result bulk-download-result">
                <ul>
                    
                    <li class='download-csv-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/csv_icon.png" alt="icon" title="Download CSV"></button></li>
                    <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li>
                </ul>
                </div>
            </div>
            `
        }else if(label === "twitter:title"){
            div = `
            <div class="bulk-table-category">
                <div class="table-cat-element active" data-name="table_twitter_title"><span>Twitter Title</span></div>
                <div class="table-cat-element" data-name="table_twitter_image"><span>Twitter Image</span></div>
                <div class="table-cat-element" data-name="table_twitter_image_alt"><span>Twitter Image Alt</span></div>
            </div>
            <div class="download_result bulk-download-result">
                <ul>
                    
                    <li class='download-csv-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/csv_icon.png" alt="icon" title="Download CSV"></button></li>
                    <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li>
                </ul>
                </div>
            </div>`
        }else if(label === "img"){
            div = `
            <div class="download_result bulk-download-result">
                <ul class="datatable_download_result bulk-datatable-download-result">
                    
                    <li class='download-csv-bulk website-tracker-csv' data-csv=${csvName}><button><img src="/new-assets/assets/images/csv_icon.png" alt="icon" title="Download CSV"></button></li>
                    <li class='download-xlsx-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download XLSX"></button></li>

                    <li class='datatable_download_result_li' style="">
                        <input type="text" class="form-control" id="custom-search" placeholder="Search">
                    </li>
                </ul>
            </div>
            `
        }else if(label === "page_speed_google_lighthouse" || label === "page_speed_google" || label === "page_speed_google_core"){
            div = `
            <div class="download_result bulk-download-result">
                <ul class="datatable_download_result bulk-datatable-download-result">
                    
                <!--   <li class='pdf-bulk'><button><img src="/new-assets/assets/images/pdf_icon.png" alt="icon" title="Download PDF"></button></li> -->
                    <li class='download-csv-bulk download-csv-bulk-rowspan website-tracker-csv' data-csv=${csvName}><button><img src="/new-assets/assets/images/csv_icon.png" alt="icon" title="Download CSV"></button></li>
                <!--    <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li> -->
                    <li class='download-xlsx-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download XLSX"></button></li>

                    <li class='datatable_download_result_li' style="">
                        <input type="text" class="form-control" id="custom-search" placeholder="Search">
                    </ul>
                </div>
            </div>
            `
        } 
        else if(label === "title"){
            div = `
            <div class="download_result bulk-download-result">
                <ul class="datatable_download_result bulk-datatable-download-result">
                    
                <!--   <li class='pdf-bulk'><button><img src="/new-assets/assets/images/pdf_icon.png" alt="icon" title="Download PDF"></button></li> -->
                    <li class='download-csv-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/csv_icon.png" alt="icon" title="Download CSV"></button></li>
                    <li class='download-xlsx-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download XLSX"></button></li>
               <!-- <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li> -->

                    <li class='datatable_download_result_li' style="">
                        <input type="text" class="form-control" id="custom-search" placeholder="Search">
                    </ul>
                </div>
            </div>
            `
        }
        else{
            div = `
            <div class="download_result bulk-download-result">
                <ul class="datatable_download_result bulk-datatable-download-result">
                    
          <!--         <li class='pdf-bulk'><button><img src="/new-assets/assets/images/pdf_icon.png" alt="icon" title="Download PDF"></button></li> -->
                    <li class='download-csv-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/csv_icon.png" alt="icon" title="Download CSV"></button></li>
                    <li class='download-xlsx-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download XLSX"></button></li>
                <!--     <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li> -->
                    <li class='datatable_download_result_li' style="">
                        <input type="text" class="form-control" id="custom-search" placeholder="Search">
                    </ul>
                </div>
            </div>
            `
        }
        return div
    }
    static prepareCsvName(slug) {
        // Replace hyphens with underscores and remove "test" keyword
        const formattedSlug = slug.replace(/-test/g, '').replace(/-/g, '_').trim();

        // Get the current date and time
        const now = new Date();

        // Format the date as DD_MM_YYYY
        const date = `${now.getDate().toString().padStart(2, '0')}_${
            (now.getMonth() + 1).toString().padStart(2, '0')
        }_${now.getFullYear()}`;

        // Format the time as HH.MM.SS AM/PM
        const hours = now.getHours();
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const amPm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = (hours % 12 || 12).toString(); // Convert to 12-hour format
        const time = `${formattedHours}.${minutes}.${seconds}_${amPm}`;

        // Combine slug, date, and time
        const csvName = `${formattedSlug}_${date}_${time}`;

        return csvName;
    }
    static showPageElements(){
        document.querySelector(".main_tools_meta_description").classList.remove("d-none")
    }

    static buildLoader(obj, testLabels){
        const div = getLoaderElement(false)
        document.querySelector(".loader__card").appendChild(div)
        UI.updateLoaderUI()
        UI.toggleContent(false)
    }

    static toggleContent(state){
        const dispay = state == true ? "block" : "none"
        document.querySelector(".tools_body_content").style.display = dispay
        
        // When content becomes visible, ensure textarea shows truncated URLs
        if(state === true && typeof window.formatTextareaDisplay === 'function'){
            setTimeout(function() {
                window.formatTextareaDisplay();
            }, 50);
        }
    }
    

    static updateLoaderUI(){
        document.querySelector(".loader__card").classList.remove("d-none")
    }
}



$( document ).ready(function() {
    Controls.init()
    toggleTestResultAreaVisibility();
    const label = JSON.parse($("#data_value").val())
    let results = [], resultsFailed = [], resultsPassed = []
    let activeUpdateData
    let activeUpdateStatusElement
    let url_list, url_list_length, obj_settings, obj, settingsVal, activeURL = "", settings
    let errorStatus = false, resultsError = []
    /** Wall-clock start for current URL (collect + runTest share one minute budget). */
    let bulkCurrentUrlStartTs = 0
    var updateStatusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'), {
        keyboard: false
    })
    var failedListModal = new bootstrap.Modal(document.getElementById('failedListModal'), {
        keyboard: false
    })

    // ============================================
    // URL TRUNCATION FOR TEXTAREA - CLEAN IMPLEMENTATION
    // ============================================
    
    // Function to truncate a single URL to 100 characters
    function truncateUrl(url, maxLength = 100) {
        if (!url || url.length <= maxLength) {
            return url;
        }
        return url.substring(0, maxLength) + '...';
    }
    
    // Function to get full URLs from storage (for AJAX calls)
    function getFullUrlsValue() {
        const textarea = document.getElementById('urlValue');
        if (!textarea) return '';
        
        // Get current textarea value (may be truncated)
        const currentValue = textarea.value;
        
        // Get stored full value if it exists
        const storedFullValue = textarea.getAttribute('data-full-value');
        
        // If we have a stored full value, check if current value is truncated
        if (storedFullValue !== null && storedFullValue !== '') {
            // Check if current value contains truncation markers
            const hasTruncatedLines = currentValue.split('\n').some(line => line.trim() !== '' && line.endsWith('...'));
            
            if (hasTruncatedLines) {
                // Current value is truncated, use stored full value
                return storedFullValue;
            } else {
                // Current value appears to be full (no truncation)
                // This means user has modified it (added/deleted URLs), so use current value
                // Also update stored value to keep it in sync
                textarea.setAttribute('data-full-value', currentValue);
                return currentValue;
            }
        }
        
        // If no stored value, return current value (might be truncated, but it's all we have)
        return currentValue;
    }
    
    // Function to format textarea with truncated URLs (only called on blur)
    window.formatTextareaDisplay = function formatTextareaDisplay() {
        const textarea = document.getElementById('urlValue');
        if (!textarea) return;
        
        // Only format when textarea is not focused (on blur)
        if (document.activeElement === textarea) {
            return;
        }
        
        // Get current value from textarea
        let currentValue = textarea.value;
        
        // Check if we have a stored full value
        const storedFullValue = textarea.getAttribute('data-full-value');
        
        // If current value contains "..." it means it's truncated, so use stored full value
        if (currentValue.includes('...') && storedFullValue !== null && storedFullValue !== '') {
            currentValue = storedFullValue;
        }
        
        // Process each line: truncate if longer than 100 characters
        const lines = currentValue.split('\n');
        let hasLongUrls = false;
        const formattedLines = lines.map((line) => {
            // Preserve empty lines
            if (line.trim() === '') {
                return line;
            }
            // Truncate if longer than 100 characters
            const truncated = truncateUrl(line, 100);
            if (truncated !== line) {
                hasLongUrls = true;
            }
            return truncated;
        });
        
        // Store full value if we truncated any URLs
        if (hasLongUrls) {
            textarea.setAttribute('data-full-value', currentValue);
        } else {
            // No truncation needed, clear stored value
            textarea.removeAttribute('data-full-value');
        }
        
        // Update textarea with truncated display
        textarea.value = formattedLines.join('\n');
    }
    
    // Debounce timer for duplicate checking
    let duplicateCheckTimer = null;
    
    // Function to clear all alerts
    function clearAllAlerts() {
        AlertManager.clear("#urlValue");
        const urlValueEl = document.querySelector("#urlValue");
        if (urlValueEl && urlValueEl.parentNode) {
            const invalidFeedbacks = urlValueEl.parentNode.querySelectorAll('.invalid-feedback');
            invalidFeedbacks.forEach(el => el.remove());
        }
    }
    
    // Function to check for duplicate URLs
    function checkDuplicateUrls() {
        clearAllAlerts();
        
        const fullUrlsValue = getFullUrlsValue();
        if (!fullUrlsValue || !fullUrlsValue.trim()) {
            // No URLs, so no duplicates - warning already cleared by clearAllAlerts()
            return;
        }
        
        const urlList = fullUrlsValue.trim().split("\n")
            .map(url => url.trim())
            .filter(url => url);
        
        const seen = new Set();
        const duplicates = [];
        urlList.forEach(url => {
            if (seen.has(url)) {
                duplicates.push(url);
            } else {
                seen.add(url);
            }
        });
        
        // Only show warning if there are duplicates
        // If no duplicates, clearAllAlerts() already cleared the warning
        if (duplicates.length > 0) {
            const duplicateCount = duplicates.length;
            AlertManager.afterElement("#urlValue", `${duplicateCount} Duplicate URL${duplicateCount > 1 ? 's' : ''} found`, {
                type: AlertManager.types.WARNING,
                autoHide: false
            });
        }
        // If duplicates.length === 0, the warning is already cleared by clearAllAlerts() above
    }

    // Event handlers - simple and clean
    
    // On paste: truncate URLs after paste completes
    $('#urlValue').on('paste', function(e) {
        clearAllAlerts();
        
        const textarea = e.target;
        
        // Wait for paste to complete, then truncate
        setTimeout(function() {
            // Get the value after paste
            let currentValue = textarea.value;
            
            // Store full value before truncating
            textarea.setAttribute('data-full-value', currentValue);
            
            // Get current cursor position (after paste, before truncation)
            // This is where the browser placed the cursor after paste
            const cursorPos = textarea.selectionStart;
            
            // Process each line: truncate if longer than 100 characters
            const lines = currentValue.split('\n');
            let hasLongUrls = false;
            
            const formattedLines = lines.map((line) => {
                // Preserve empty lines
                if (line.trim() === '') {
                    return line;
                }
                // Truncate if longer than 100 characters
                const truncated = truncateUrl(line, 100);
                if (truncated !== line) {
                    hasLongUrls = true;
                }
                return truncated;
            });
            
            // Store full value if we truncated any URLs
            if (hasLongUrls) {
                textarea.setAttribute('data-full-value', currentValue);
            }
            
            // Update textarea with truncated display
            const newValue = formattedLines.join('\n');
            
            // Only update if value changed
            if (textarea.value !== newValue) {
                // Update the value
                textarea.value = newValue;
                
                // After paste, browser typically places cursor at the end of pasted content
                // Since we're truncating, we need to place cursor at the end of the new value
                // This ensures that subsequent pastes will work correctly
                const newCursorPos = newValue.length;
                textarea.setSelectionRange(newCursorPos, newCursorPos);
            } else {
                // Value didn't change, but cursor might have moved - restore it
                textarea.setSelectionRange(cursorPos, cursorPos);
            }
            
            // Check for duplicates
            checkDuplicateUrls();
        }, 50);
    });

    // On blur: truncate URLs when user clicks away
    $('#urlValue').on('blur', function() {
        formatTextareaDisplay();
        checkDuplicateUrls();
    });

    // On input: only check for duplicates, don't truncate (allows Enter to work)
    $('#urlValue').on('input', function() {
        // Clear alerts immediately when input changes
        clearAllAlerts();
        
        if (duplicateCheckTimer) {
            clearTimeout(duplicateCheckTimer);
        }
        
        // Check duplicates after a short delay (debounce)
        // This ensures the warning is updated/cleared when URLs are added or deleted
        duplicateCheckTimer = setTimeout(function() {
            checkDuplicateUrls();
        }, 300);
    });

    // Format on initial load if textarea has content
    if ($('#urlValue').length && $('#urlValue').val().trim()) {
        formatTextareaDisplay();
        checkDuplicateUrls();
    }

    $("#startTestBulk").on( "click", function(e) {
        // Get full URLs (restores if truncated)
        const fullUrlsValue = getFullUrlsValue();
        
        const urlInput = $("#urlValue")[0]
        let urlInputVal = fullUrlsValue
        results = [], resultsFailed = [], resultsPassed = [], resultsError = [], errorStatus = false

        // Clear all alerts (including AlertManager alerts)
        clearAlerts()
        clearAllAlerts()
        clearTables()

        results = []
        obj_settings = getAllValues(".bulk-test-criteria")
        obj = {}
        obj["settings"] = obj_settings
        obj["project"] = "bulk"
        obj["testLabels"] = label
        obj["pageType"] = "live"

        if(validateFront({
            el: $("#urlValue")[0], 
            msgMinimumSelection: "Please select at least one test criteria to perform the analysis.", 
            msgEmpty: "Enter at least one URL to test", 
            msgExceed: "You can not enter more than 100 urls."
            }, "bulk")){
            // Split, trim, and remove empty lines
            let original_url_list = urlInputVal.trim().split("\n").map(url => url.trim()).filter(url => url)
            // Remove duplicates
            let unique_url_list = [...new Set(original_url_list)]
            
            // Store the processed full URLs (after deduplication) - this will be used in AJAX
            const processedFullUrls = unique_url_list.join("\n");
            // Store in a variable accessible to startTest function
            window.bulkFullUrls = processedFullUrls;
            
            // IMPORTANT: Store full URLs in data attribute BEFORE updating textarea
            // This ensures we always have the full URLs stored even if textarea shows truncated
            $("#urlValue")[0].setAttribute('data-full-value', processedFullUrls);
            
            // Update textarea with full URLs (will be used for testing)
            // But format it to show truncated for display
            $("#urlValue")[0].value = processedFullUrls;
            
            // If duplicates were found, show warning (but allow test to proceed)
            if (unique_url_list.length < original_url_list.length) {
                const duplicateCount = original_url_list.length - unique_url_list.length;
                AlertManager.afterElement("#urlValue", `${duplicateCount} Duplicate URL${duplicateCount > 1 ? 's' : ''} found`, {
                    type: AlertManager.types.WARNING,
                    autoHide: false
                });
            }
            
            // Format to show truncated URLs in textarea (visual only)
            formatTextareaDisplay();
            
            url_list = unique_url_list
            url_list_length = url_list.length
            const inputs = document.querySelectorAll(".bulk-test-criteria input,.bulk-test-criteria textarea")
            settingsVal = getSettingsVal(inputs)

            UI.buildLoader()
            startTest()
        }

        e.preventDefault()
    })




    function updateProgress(){
        const currentLength = results.length
        const total = url_list_length
        const totalPercent = ((currentLength / total) * 100).toFixed(1)
        $("#loader_test_current").html(activeURL)
        $(".loader-bold-span").html(`${totalPercent}%`)
        $(".progress .progress-bar").css("width", `${totalPercent}%`)
        $('.progress-loader').show()
        $("#failedProgress").attr("data-value", getReportProgress(resultsFailed.length, total, false))
        $("#passedProgress").attr("data-value", getReportProgress(resultsPassed.length, total, false))

        $("#failedProgress").attr("data-text", resultsFailed.length, total, false)
        $("#passedProgress").attr("data-text", resultsPassed.length, total, false)


        updateCircularProgress()
    }


    function removeLoader(){
        document.querySelector(".loader__card").innerHTML = ""
        document.querySelector(".loader__card").classList.add("d-none")
    }
    

  


function clearTables(){
    $(".test_result_area").html("");
    toggleTestResultAreaVisibility();
}


function toggleFailedListVisibility() {
    const el = document.querySelector(".failed-list");
    if (!el) return;

    // Hide when empty (or only whitespace)
    el.style.display = el.textContent.trim().length ? "" : "none";
}

function toggleTestResultAreaVisibility() {
    const el = document.querySelector(".test_result_area");
    if (!el) return;

    // Hide when empty (or only whitespace)
    el.style.display = el.innerHTML.trim().length ? "" : "none";
}

    /** Max time per URL for collect + run test (Lighthouse / bulk can hang on bad URLs). */
    const BULK_PER_URL_TIMEOUT_MS = 60000

    /**
     * Skip current URL and advance progress (never leave the bulk run stuck).
     * Completion uses results.length + resultsError.length vs url_list_length.
     */
    function abortCurrentBulkUrl(reason) {
        if (!url_list || url_list.length === 0) {
            return
        }
        const currentUrl = constructTestURL(url_list[0])
        activeURL = currentUrl
        errorStatus = true
        resultsError.push({ failed: currentUrl + " — " + (reason || "Skipped") })
        checkFinished()
    }



    function startTest(){
        if (!url_list || url_list.length === 0) {
            return
        }
        bulkCurrentUrlStartTs = Date.now()
        const url = constructTestURL(url_list[0])
        let origin
        try {
            origin = new URL(url).origin
        } catch (e) {
            abortCurrentBulkUrl("Invalid URL")
            return
        }
        const htmlSitemap = `${origin}/sitemap`
        const xmlSitemap = `${origin}/sitemap.xml`

        obj["urlValue"] = url
        // Use the processed full URLs stored in window.bulkFullUrls (set before startTest was called)
        obj["bulkUrl"] = window.bulkFullUrls || getFullUrlsValue()
        obj["settingsVal"] = settingsVal
        obj["settingsVal"]["settings_sub"]["html_sitemap_val"] = htmlSitemap
        obj["settingsVal"]["settings_sub"]["xml_sitemap_val"] = xmlSitemap


        $.ajax({
            url : `/test/collect`,
            type : 'POST',
            aysnc: false,
            // First leg: leave room so collect + runTest stay within BULK_PER_URL_TIMEOUT_MS total
            timeout: Math.min(40000, BULK_PER_URL_TIMEOUT_MS),
            data: {
                "data": obj,
                "_method": 'POST',
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },       
            success : function(response) {
                let data
                try {
                    data = typeof response === "string" ? JSON.parse(response) : response
                } catch (e) {
                    abortCurrentBulkUrl("Invalid response from collect (parse error)")
                    return
                }

                if(data.status === 0){
                    // test failed
                    errorStatus = true
                    resultsError.push(data)
                    checkFinished()
                }else{
                    if(data.response){
                        data = data.response
                        let test = getTest(data, label)
                        if(!test){
                            test = {
                                content: "",
                                name: label.name
                            }
                        }
                        if(!test.metaContent){
                            test.metaContent = {
                                content: "",
                            }
                        }
                        if(label.name === "a" || label.name === "img" || label.name === "stylesheet" || label.name === "script"){
                            test = {
                                links: test,
                                label: label,
                                urlValue: obj.urlValue,
                                pageType: obj.pageType
                            }
                        }else{
                            test.label = label
                            test.urlValue = obj.urlValue
                            test.pageType = obj.pageType
                        }


                        if(test.name === "og:title"){
                            let ogDesc = getTest(data, label.ogDesc)
                            if(!ogDesc){
                                test.ogDesc = {
                                    content: "",
                                }
                            }else{
                                test.ogDesc = ogDesc
                            }
                            let ogImage = getTest(data, label.ogImage)
                            if(!ogImage){
                                test.ogImage = {
                                    content: "",
                                }
                            }else{
                                test.ogImage = ogImage
                            }
                            let ogURL = getTest(data, label.ogURL)
                            if(!ogURL){
                                test.ogURL = {
                                    content: "",
                                }
                            }else{
                                test.ogURL = ogURL
                            }
                        }
                        if(test.name === "twitter:title"){
                            let twitterImage = getTest(data, label.twitterImage)
                            if(!twitterImage){
                                test.twitterImage = {
                                    content: "",
                                }
                            }else{
                                test.twitterImage = twitterImage
                            }
                            let twitterImageAlt = getTest(data, label.twitterImageAlt)
                            if(!twitterImageAlt){
                                test.twitterImageAlt = {
                                    content: "",
                                }
                            }else{
                                test.twitterImageAlt = twitterImageAlt
                            }
                        }
    
                        runTest(label, test, url)
                    }else{
                        resultsFailed.push(data.failed)
                        errorStatus = true
                        resultsError.push({
                            failed: (data.failed && String(data.failed).trim() !== "")
                                ? data.failed
                                : (url + " — Collect returned no test payload")
                        })
                        checkFinished()
                    }
                }
            },
            error: function(xhr, status, err) {
                const msg =
                    status === "timeout"
                        ? "Collect timed out (first phase, max " + (Math.min(40000, BULK_PER_URL_TIMEOUT_MS) / 1000) + "s)"
                        : ("Collect failed" + (err ? ": " + err : ""))
                abortCurrentBulkUrl(msg)
            }
        })
    }



    function runTest(label, test, url){
        const elapsed = Date.now() - bulkCurrentUrlStartTs
        const runTestTimeout = Math.max(500, BULK_PER_URL_TIMEOUT_MS - elapsed)
        if (runTestTimeout <= 500) {
            abortCurrentBulkUrl("No time left for test (over " + (BULK_PER_URL_TIMEOUT_MS / 1000) + "s budget)")
            return
        }
        $.ajax({
            url : `${label.url}`,
            type : 'POST',
            aysnc: false,
            timeout: runTestTimeout,
            data: {
                "data": test,
                "_method": 'POST',
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },       
            success : function(response) {
                let data
                try {
                    data = typeof response === "string" ? JSON.parse(response) : response
                } catch (e) {
                    abortCurrentBulkUrl("Invalid response from test (parse error)")
                    return
                }
                data.label = label
                data.tested_url = url
                // testing casing
                if(data.casingStatus){
                    const content = data.content
                    data.casingClass = "result_pass"

                    if(isCamelCase(content, data.excludedWordsVal)){
                        data.casing = "Camel Casing"
                    }else if(isSentenceCase(content, data.excludedWordsVal)){
                        data.casing = "Sentence Casing"
                    }else{
                        data.casing = "Neither Camel Case nor Sentence Case"
                    }
                    if(data.titleCasingCamel){
                        if(!isCamelCase(content, data.excludedWordsVal)){
                            data.problems.push(`${data.tagName} does not follow Camel casing`)
                            data.status = false
                            data.casingClass = "result_fail"
                        }
                    }
                    if(data.titleCasingSentence){
                        if(!isSentenceCase(content, data.excludedWordsVal)){
                            data.problems.push(`${data.tagName} does not follow Sentence casing`)
                            data.status = false
                            data.casingClass = "result_fail"
                        }
                    }
                    if(data.titleCasingBoth){
                        if(!isCamelCase(content, data.excludedWordsVal) && !isSentenceCase(content, data.excludedWordsVal)){
                            data.problems.push(`${data.tagName} does not follow Camel casing or Sentence casing`)
                            data.status = false
                            data.casingClass = "result_fail"
                        }
                    }
                }


                activeURL = data.tested_url
                settings = data.settings
                results.push(data)
                if(data.status){
                    resultsPassed.push(data)
                }else{
                    resultsFailed.push(data)
                }
                checkFinished()
            },
            error: function(xhr, status, err) {
                const msg =
                    status === "timeout"
                        ? "Test timed out (URL budget " + (BULK_PER_URL_TIMEOUT_MS / 1000) + "s total for collect + test)"
                        : ("Test request failed" + (err ? ": " + err : ""))
                abortCurrentBulkUrl(msg)
            }
        })
    }

    function checkFinished(){
        updateProgress()
        if(url_list_length === results.length + resultsError.length){
            window.setTimeout(function(){
                endTest()
            }, 3000)
        }else{
            url_list.shift()
            startTest()
        }
    }

    
    function updateEvents(){
        $(".table-cat-element").on( "click", function(e) {
            const target = e.target.closest(".table-cat-element")      
            const id = target.getAttribute("data-name")
            UI.toggleBulkTable(id)
        })

        $(".intentional-btn").on( "click", function(e) {
            activeUpdateStatusElement = e.target.parentElement.parentElement
            const index = parseInt(activeUpdateStatusElement.children[0].textContent)-1
            activeUpdateData = results[index]

            if(activeUpdateData.label.name === "robots"){
                $("#updateStatusModalText").html(`So you are saying Noindex,Nofollow meta tag is supposed to exist ?`)
            }else{
                $("#updateStatusModalURLOriginal").html(projectUrl)
                $("#updateStatusModalURLCanonical").html(activeUpdateData.content)
            }
    
            updateStatusModal.toggle()
        })
        $("#showFailedModal").on( "click", function(e) {
            failedListModal.toggle()
        })


        $(".download-csv-bulk").on( "click", function(e) {
            let csvName = $(this).attr('data-csv') + '.csv';
            Controls.buildCSV(csvName)
        })

        $(".email-bulk").on( "click", function(e) {
            Controls.emailReport()
        })

        $(".table-headings-collapse").click(function (e) {
            let target = $(e.target).closest(".collapsible")[0]
            if(target){
                if(target.classList.contains("collapsible")){
                    const id = target.getAttribute("data-id")
                    const row = $(`[data-val='${id}']`);

                    const isShown = row[0].classList.contains('show');
                    row.toggleClass('show');

                    const toggleBtn = row[0].previousElementSibling.querySelector('.collapsible span');
                    toggleBtn.textContent = isShown ? 'Show' : 'Hide';
                    row[0].previousElementSibling.querySelector('.collapsible').classList.remove('show')
                    row[0].previousElementSibling.querySelector('.collapsible').classList.remove('hide')
                    row[0].previousElementSibling.querySelector('.collapsible').classList.add(isShown ? 'show' : 'hide')
                }
            }
        });
        
    }



    function endTest(){
        updateEmailModal(activeURL)
        if(results.length > 0){
            buildTable()
            if(errorStatus){
                buildFailedList(resultsError)
            }
            UI.showPageElements()

            updateEvents()
            removeLoader()
            UI.toggleContent(true)
            UI.scrollToSection()
        }else{
            UI.displayErrorNoTest()
            UI.toggleContent(true)
            removeLoader()
        }
        
        // Format textarea to show truncated URLs after tests complete (for better visual display)
        // Use setTimeout to ensure textarea is visible before formatting
        setTimeout(function() {
            formatTextareaDisplay();
        }, 100);
    }
    modifyCss()
    function modifyCss(){
        $('.tools_sidebar .accordion-body').attr('style', 'margin-top: -10px !important');
    }
 
    function buildFailedList(list){
        const p = document.createElement("p")
        p.innerHTML = "Some URLs weren’t tested because they returned 404 (Not Found). <a href='javascript:void()' id='showFailedModal'>View details</a>"
        document.querySelector(".failed-list").appendChild(p)
        const ol = document.createElement("ol")
        list.forEach(data=>{
            const li = document.createElement("li")
            li.innerHTML = data.failed
            ol.appendChild(li)
        })
        document.querySelector(".failed-list-data").appendChild(ol)
        toggleFailedListVisibility(); 
    }

    function convertObjToIntVal(obj){
        for(key in obj){
            let val = obj[key]
            if(val == "1"){
                obj[key] = true
            }else if(val == "0"){
                obj[key] = false
            }
        }
        return obj
    }

    function buildTable(){
        document.querySelector(".failed-list-data").innerHTML = ""

        settings = convertObjToIntVal(settings)

        // build table container
        document.querySelector(".test_result_area").innerHTML = `
            <h2>Test Results</h2>
            <span class="failed-list"></span>
            <div class="test_result_table">
              <div class="table-responsive">
              ${UI.getTableTop(label.name, label.slug)}
            </div>`;
        
        toggleFailedListVisibility(); // hides it initially

        const table = document.createElement("table")
        table.classList.add("table")
        table.classList.add("bulk-table")
        table.classList.add("table-bordered")

     

        let thead, thead2, thead3, thead4
        const tbody = document.createElement("tbody")
        const tbody2 = document.createElement("tbody")
        const tbody3 = document.createElement("tbody")
        const tbody4 = document.createElement("tbody")

        tbody.classList.add("result_data_body")
        tbody2.classList.add("result_data_body")
        tbody3.classList.add("result_data_body")
        tbody4.classList.add("result_data_body")

        switch(label.name){
            case "title":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">Content</th>
                    <th class="${settings.max_title_length || settings.min_title_length ? "" : "d-none hidden-element"}">Length</th>
                    <th class="${settings.is_title_equal_h1 ? "" : "d-none hidden-element"}">Title Equal to H1? </th>
                    <th class="${settings.title_casing_both || settings.title_casing_camel || settings.title_casing_sentence ? "" : "d-none hidden-element"}">Casing</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td class="text-center">${i+1}</td>
                    <td class="align-left result_data_url content-td"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="align-left content-td">${result.content != null ? result.content : "-"}</td>
                    <td class="${result.lengthClass} ${settings.max_title_length || settings.min_title_length ? "" : "d-none hidden-element"}" style="text-align:center;">${result.content != null ? result.content.length : 0}</td>
                    <td class="${settings.is_title_equal_h1 ? "" : "d-none hidden-element"}" style="text-align:center;">No</td>
                    <td class="${result.casingClass} ${settings.title_casing_both || settings.title_casing_camel || settings.title_casing_sentence ? "" : "d-none hidden-element"}" style="text-align:center;">${result.casing ? result.casing : "-"}</td>
                    <td class="${result.status ? "result_pass" : "result_fail"} strong" style="text-align:center;"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();
                // Set dynamic column widths only for meta-title table
                setTimeout(function() {
                    setDynamicColumnWidths(table, 'title');
                }, 100);
                break;

            case "description":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
                <tr>
                    <th class="text-center">#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">Content</th>
                    <th class="${settings.max_desc_length || settings.min_desc_length ? "" : "d-none hidden-element"}">LEN</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td class="text-center">${i+1}</td>
                    <td class="align-left result_data_url content-td"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left content-td">${result.content != null ? result.content : "-"}</td>
                    <td class="${result.lengthClass} ${settings.max_desc_length || settings.min_desc_length ? "" : "d-none hidden-element"}">${result.content != null ? result.content.length : 0}</td>
                    <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();
                break;
            case "robots":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="${settings.live_urls_robots_meta? "" : "d-none hidden-element"}">Robots Tag Exists</th>
                    <th class="align-left">Content</th>
                    <th class="export-hidden-element"></th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="${result.isExists ? "result_fail" : "result_pass"} strong  ${settings.live_urls_robots_meta? "" : "d-none hidden-element"}">${result.contentExists ? "Yes" : "No"}</td>
                    <td class="text-center">${result.content != null && result.content != "" ? result.content : "-"}</td>
                    ${!result.status && result.isExists ? `<td class="export-hidden-element"><a data-name="${data.title}" class="intentional-btn" id="intentional_${i}">Is this is intentional?</a></td>` : "<td class='export-hidden-element'>-</td>"}              
                    <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();
                break;
            case "canonical":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">Canonical URL</th>
                    <th class="${settings.canonical_url_equal_url ? "" : "d-none hidden-element"}">Equal to Actual URL?</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    let msg
                    switch(result.statusIsEqualURL){
                        case true:
                            msg = "Yes"
                            break;
                        case false:
                            msg = "No"
                            break;
                        default:
                            msg = "-"
                            break;
                    }
                
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url content-td"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left content-td">${result.content != null ? result.content : "-"}</td>
                    <td class="${settings.canonical_url_equal_url ? "" : "d-none hidden-element"} ${result.statusIsEqualURL || result.statusIsEqualURL === null ? "result_pass" : "result_fail"}">${msg}</td>
                    <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>

                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();
                break;
            case "url":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">Slug</th>
                    <th class="text-center ${settings.max_url_length || settings.min_url_length ? "" : "d-none hidden-element"}">LEN</th>
                    <th class="${settings.url_no_numbers ? "" : "d-none hidden-element"}">Has Numbers?</th>
                    <th class="text-center ${settings.url_no_special ? "" : "d-none hidden-element"}"><span class="bulk-th-tooltip-inline">Special Characters?${typeof getCriteriaTooltipMarkup === 'function' ? getCriteriaTooltipMarkup('<p>Does the URL contain special characters?</p>', 'bulk-tooltips-contents') : ''}</span></th>
                    <th class="text-center ${settings.url_slug_lowercase ? "" : "d-none hidden-element"}"><span class="bulk-th-tooltip-inline">Uppercase Characters?${typeof getCriteriaTooltipMarkup === 'function' ? getCriteriaTooltipMarkup('<p>Does the URL contain uppercase characters?</p>', 'bulk-tooltips-contents') : ''}</span></th>
                    <th class="${settings.url_casing_only_hyphens ? "" : "d-none hidden-element"}"><span class="bulk-th-tooltip-inline">Hyphens Only?${typeof getCriteriaTooltipMarkup === 'function' ? getCriteriaTooltipMarkup('<p>Are words in the URL separated by Hyphens only?</p>', 'bulk-tooltips-contents') : ''}</span></th>
                    <th class="${settings.url_casing_only_underscores ? "" : "d-none hidden-element"}">Words Separated By Underscores Only?</th>
                    <th class="${settings.url_stop_words ? "" : "d-none hidden-element"}">Contains Stop Words?</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td class="text-center">${i+1}</td>
                    <td class="align-left result_data_url content-td"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="align-left content-td">${result.content != '' ? result.content : "-"}</td>
                    <td class="text-center ${result.lengthClass} ${settings.max_url_length || settings.min_url_length ? "" : "d-none hidden-element"}">${result.content != null ? result.content.length : 0}</td>
                    <td class="${result.statusNumbers ? "result_pass" : "result_fail"} ${settings.url_no_numbers ? "" : "d-none hidden-element"}">${result.statusNumbers ? "No" : "Yes"}</td>
                    <td class="text-center ${result.statusSpecial ? "result_pass" : "result_fail"} ${settings.url_no_special ? "" : "d-none hidden-element"}">${result.statusSpecial ? "No" : "Yes"}</td>
                    <td class="text-center ${result.statusLowercase ? "result_pass" : "result_fail"} ${settings.url_slug_lowercase ? "" : "d-none hidden-element"}">${result.statusLowercase ? "No" : "Yes"}</td>
                    <td class="${result.statusHyphens ? "result_pass" : "result_fail"} ${settings.url_casing_only_hyphens ? "" : "d-none hidden-element"}">${!isSingleWord(result.content) ? result.statusHyphens ? "Yes" : "No" : "-"}</td>
                    <td class="${result.statusUnderscore ? "result_pass" : "result_fail"} ${settings.url_casing_only_underscores ? "" : "d-none hidden-element"}">${result.statusUnderscore ? "Yes" : "No"}</td>
                    <td class="${result.statusStopWords ? "result_pass" : "result_fail"} ${settings.url_stop_words ? "" : "d-none hidden-element"}">${result.statusStopWords ? "No" : "Yes"}</td>
                    <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>

                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();
                // Set dynamic column widths for URL Slug table
                setTimeout(function() {
                    setDynamicColumnWidths(table, 'url');
                }, 100);
                break;
            case "og:title":
                thead = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">OG:Title</th>
                    <th class="${settings.max_og_title_length || settings.min_og_title_length ? "" : "d-none hidden-element"}">LEN</th>
                    <th class="${settings.og_title_casing_both || settings.og_title_casing_camel || settings.og_title_casing_sentence ? "" : "d-none hidden-element"}">Casing</th>
                    <th class="${settings.is_og_title_equal_title ? "" : "d-none hidden-element"}">OG:Title Equal to title?</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="align-left">${result.content != null ? result.content : "Open Graph Title does not exist."}</td>
                    <td class="text-center ${result.lengthClass} ${settings.max_og_title_length || settings.min_og_title_length ? "" : "d-none hidden-element"}">${result.content != null ? result.content.length : 0}</td>
                    <td class="${result.casingClass} ${settings.og_title_casing_both || settings.og_title_casing_camel || settings.og_title_casing_sentence ? "" : "d-none hidden-element"}">${result.casing ? result.casing : "-"}</td>
                    <td class="${result.isEqualClass} ${settings.is_og_title_equal_title ? "" : "d-none hidden-element"}">${result.isEqualStatus ? "Yes" : "No"}</td>
                    <td class="text-center ${result.statusTitle ? "result_pass" : "result_fail"}">${result.statusTitle ? "PASS" : "FAIL"}</td>
                    `
                    tbody.appendChild(tr)
                })

                thead2 = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">OG:Description</th>
                    <th class="${settings.max_og_desc_length || settings.min_og_desc_length ? "" : "d-none hidden-element"}">LEN</th>
                    <th class="${settings.is_og_desc_equal_desc ? "" : "d-none hidden-element"}">OG:Description Equal to meta desciption?</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="align-left">${result.contentDesc != null ? result.contentDesc : "Open Graph Description does not exist."}</td>
                    <td class="text-center ${result.lengthDescClass} ${settings.max_og_desc_length || settings.min_og_desc_length ? "" : "d-none hidden-element"}">${result.contentDesc != null ? result.contentDesc.length : 0}</td>
                    <td class="${result.isEqualDescClass} ${settings.is_og_desc_equal_desc ? "" : "d-none hidden-element"}">${result.isEqualDescStatus ? "Yes" : "No"}</td>
                    <td class="text-center ${result.statusDesc ? "result_pass" : "result_fail"}">${result.statusDesc ? "PASS" : "FAIL"}</td>
                    `
                    tbody2.appendChild(tr)
                })

                thead3 = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">OG:Image</th>
                    <th class="${settings.og_image_dimensions_min || settings.og_image_dimensions_exact ? "" : "d-none hidden-element"}">Width, Height</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="align-left">${result.contentImage != null && result.contentImage != "" ? `<a href="${result.contentImage}" target="_blank" rel="noopener noreferrer">${result.contentImage}</a>` : "Open Graph Image does not exist."}</td>
                    <td class="${settings.og_image_dimensions_min || settings.og_image_dimensions_exact ? "" : "d-none hidden-element"}"><span class="${result.widthImageClass}">${result.dimensions != null ? result.dimensions.w : "-"}</span>, <span class="${result.heightImageClass}">${result.dimensions != null ? result.dimensions.h : ""}</span></td>
                    <td class="text-center ${result.statusImage ? "result_pass" : "result_fail"}">${result.statusImage ? "PASS" : "FAIL"}</td>
                    `
                    tbody3.appendChild(tr)
                })
  
                thead4 = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">OG:URL</th>
                    <th class="${settings.max_og_url_length ? "" : "d-none hidden-element"}">LEN</th>
                    <th class="${settings.is_og_url_equal_url ? "" : "d-none hidden-element"}">OG:URL Equal to the actual url?</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="align-left">${result.contentURL != null && result.contentURL != "" ? result.contentURL : "Open Graph URL does not exist."}</td>
                    <td class="text-center ${result.lengthURLClass} ${settings.max_og_url_length ? "" : "d-none hidden-element"}">${result.contentURL != null ? result.contentURL.length : 0}</td>
                    <td class="${result.isEqualURLClass} ${settings.is_og_url_equal_url ? "" : "d-none hidden-element"}">${result.isEqualURLStatus ? "Yes" : "No"}</td>
                    <td class="text-center ${result.statusURL ? "result_pass" : "result_fail"}">${result.statusURL ? "PASS" : "FAIL"}</td>
                    `
                    tbody4.appendChild(tr)
                })
                break;
            case "twitter:title":
                thead = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">Twitter:Title</th>
                    <th class="${settings.max_twitter_title_length || settings.min_twitter_title_length ? "" : "d-none hidden-element"}" style="white-space: nowrap;">LEN</th>
                    <th class="${settings.twitter_title_casing_both || settings.twitter_title_casing_camel || settings.twitter_title_casing_sentence ? "" : "d-none hidden-element"}">Casing</th>
                    <th class="${settings.is_twitter_title_equal_title ? "" : "d-none hidden-element"}">Twitter:Title Equal to title?</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="align-left">${result.content != null ? result.content : "Twitter Title does not exist."}</td>
                    <td class="text-center ${result.lengthClass} ${settings.max_twitter_title_length || settings.min_twitter_title_length ? "" : "d-none hidden-element"}">${result.content != null ? result.content.length : 0}</td>
                    <td class="text-center ${result.casingClass} ${settings.twitter_title_casing_both || settings.twitter_title_casing_camel || settings.twitter_title_casing_sentence ? "" : "d-none hidden-element"}">${result.casing ? result.casing : "-"}</td>
                    <td class="text-center ${result.isEqualClass} ${settings.is_twitter_title_equal_title ? "" : "d-none hidden-element"}">${result.isEqualStatus ? "Yes" : "No"}</td>
                    <td class="text-center ${result.statusTitle ? "result_pass" : "result_fail"}">${result.statusTitle ? "PASS" : "FAIL"}</td>
                    `
                    tbody.appendChild(tr)
                })
      

                thead2 = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">Twitter:Image</th>
                    <th class="${settings.twitter_image_dimensions_min || settings.twitter_image_dimensions_exact ? "" : "d-none hidden-element"}">Width, Height</th>
                    <th>Result</th>
                </tr>
                </thead>`

                
                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="align-left">${result.contentImage != null && result.contentImage != "" ? `<a href="${result.contentImage}" target="_blank" rel="noopener noreferrer">${result.contentImage}</a>` : "Twitter Image does not exist."}</td>
                    <td class="text-center ${settings.twitter_image_dimensions_min || settings.twitter_image_dimensions_exact ? "" : "d-none hidden-element"}"><span class="${result.widthImageClass}">${result.dimensions != null ? result.dimensions.w : "-"}</span>, <span class="${result.heightImageClass}">${result.dimensions != null ? result.dimensions.h : ""}</span></td>
                    <td class="text-center ${result.statusImage ? "result_pass" : "result_fail"}">${result.statusImage ? "PASS" : "FAIL"}</td>
                    `
                    tbody2.appendChild(tr)
                })
       
                thead3 = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">Twitter:Image:Alt</th>
                    <th class="${settings.max_twitter_image_alt_length ? "" : "d-none hidden-element"}" style="white-space: nowrap;">LEN</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}</a></td>
                    <td class="align-left">${result.contentImageAlt != null && result.contentImageAlt != "" ? result.contentImageAlt : "Twitter Image Alt does not exist."}</td>
                    <td class="text-center ${result.lengthImageAltClass} ${settings.max_twitter_image_alt_length ? "" : "d-none hidden-element"}">${result.contentImageAlt ? result.contentImageAlt.length : 0}</td>
                    <td class="text-center ${result.statusImageAlt ? "result_pass" : "result_fail"}">${result.statusImageAlt ? "PASS" : "FAIL"}</td>
                    `
                    tbody3.appendChild(tr)
                })
                break;
             case "icon":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">Favicon</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td class="text-center">${i+1}</td>
                    <td class="align-left result_data_url content-td"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left content-td">${result.content != null ? result.content : "-"}</td>
                    <td class="${result.status ? "result_pass" : "result_fail"} strong" ><strong>${result.status ? "PASS" : "FAIL"}</strong></td>

                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();
                break;
            case "html_sitemap":
                    table.classList.add("dataTable")
                    table.classList.add("custom-dataTable")
                    thead = `<thead class="result_data_header">
                    <tr>
                        <th>#</th>
                        <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                        <th class="align-left">Message</th>
                        <th>Result</th>
                    </tr>
                    </thead>`
    
                    results.forEach((result, i)=>{
                        const tr = document.createElement("tr")
                        tr.innerHTML = `
                        <td>${i+1}</td>
                        <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                        <td class="align-left">${result.message}</td>
                        <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>
                        `
                        tbody.appendChild(tr)
                    })
                    createDatatableElement();
                    break;
                case "xml_sitemap":
                    table.classList.add("dataTable")
                    table.classList.add("custom-dataTable")
                    thead = `<thead class="result_data_header">
                    <tr>
                        <th>#</th>
                        <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                        <th class="align-left">URL added to XML Sitemap?</th>
                        <th>Result</th>
                    </tr>
                    </thead>`
    
                    results.forEach((result, i)=>{
                        const tr = document.createElement("tr")
                        tr.innerHTML = `
                        <td>${i+1}</td>
                        <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                        <td class="align-left">${result.message}</td>
                        <td class="${result.status ? "result_pass" : "result_fail"} strong" ><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                        `
                        tbody.appendChild(tr)
                    })
                    createDatatableElement();
                    break;
                case "schema":
                    table.classList.add("dataTable")
                    table.classList.add("custom-dataTable")
                    thead = `<thead class="result_data_header">
                    <tr>
                        <th>#</th>
                        <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                        <th class="align-left">Types</th>
                        <th class="align-left">Problems</th>
                        <th>Result</th>
                    </tr>
                    </thead>`
                    // Store schema results for popup (by row index)
                    window.schemaResultsData = results.slice()
                    // Ensure schema content modal exists
                    let schemaContentModal = document.getElementById("schemaContentModal")
                    if(!schemaContentModal){
                        schemaContentModal = document.createElement("div")
                        schemaContentModal.className = "modal fade meta-list-brokenBody"
                        schemaContentModal.id = "schemaContentModal"
                        schemaContentModal.setAttribute("aria-labelledby", "schemaContentModalLabel")
                        schemaContentModal.setAttribute("tabindex", "-1")
                        schemaContentModal.setAttribute("aria-hidden", "true")
                        schemaContentModal.innerHTML = `
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title schema-content-heading" id="schemaContentModalLabel">Schema (JSON-LD)</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="overflow-x: auto;">
                                        <pre id="schemaContentModalBody" class="schema-json-pre" style="white-space: pre-wrap; word-break: break-word; margin: 0; font-size: 13px;"></pre>
                                    </div>
                                </div>
                            </div>
                        `
                        document.body.appendChild(schemaContentModal)
                    }
                    results.forEach((result, i)=>{
                        const problemsStr = (result.problems && result.problems.length) ? result.problems.join('; ') : 'None'
                        const typesArr = (result.types && result.types.length) ? result.types : []
                        const typesHtml = typesArr.length
                            ? typesArr.map(t => {
                                const esc = (s) => String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;')
                                return `<span class="schema-type-link" data-result-index="${i}" data-type="${esc(t)}" style="cursor: pointer; color: #3A7CEC; text-decoration: underline;">${esc(t)}</span>`
                            }).join(', ')
                            : 'None'
                        const tr = document.createElement("tr")
                        tr.innerHTML = `
                        <td class="text-center">${i+1}</td>
                        <td class="align-left result_data_url content-td"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                        <td class="align-left content-td">${typesHtml}</td>
                        <td class="align-left content-td">${problemsStr}</td>
                        <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                        `
                        tbody.appendChild(tr)
                    })
                    $(document).off('click', '.schema-type-link').on('click', '.schema-type-link', function(e){
                        e.preventDefault()
                        e.stopPropagation()
                        const rowIndex = parseInt($(this).data('result-index'), 10)
                        const typeName = $(this).data('type')
                        const rowData = window.schemaResultsData && window.schemaResultsData[rowIndex]
                        if(!rowData || !rowData.blocks){ return }
                        const blocks = rowData.blocks
                        const matching = blocks.filter(b => b.types && b.types.indexOf(typeName) !== -1)
                        const snippets = matching.length ? matching.map((b, idx) => (matching.length > 1 ? `/* Block ${idx + 1} */\n` : '') + (b.snippet || '')).join('\n\n') : 'No content for this type.'
                        const titleEl = document.querySelector('#schemaContentModalLabel')
                        if(titleEl) titleEl.textContent = `Schema content for "${typeName}"`
                        const bodyEl = document.getElementById('schemaContentModalBody')
                        if(bodyEl){ bodyEl.textContent = snippets }
                        const modalEl = document.getElementById('schemaContentModal')
                        if(modalEl){
                            let inst = bootstrap.Modal.getInstance(modalEl)
                            if(!inst) inst = new bootstrap.Modal(modalEl, { keyboard: false })
                            inst.show()
                        }
                    })
                    createDatatableElement();
                    break;
                    case "img":
                        let colspanAlt = 0,colspanName = 1
                        table.classList.add("dataTable")
                        table.classList.add("custom-dataTable")
                        settings.image_alt ? colspanAlt++ : ""
                        settings.image_alt_only_spaces ? colspanAlt++ : ""

                        settings.image_max_size ? colspanName++ : ""
                        settings.image_name_no_special ? colspanName++ : ""
                        settings.image_name_no_uppercase ? colspanName++ : ""
                        settings.image_name_only_hyphens ? colspanName++ : ""
                        settings.image_name_max_characters ? colspanName++ : ""


                        thead = `<thead class="result_data_header">
                        <tr style="white-space: nowrap;">
                            <th class="transparent">#</th>
                            <th class="result_header transparent align-left">URL</th>
                            <th class="transparent">Image Link</th>
                            <th class="transparent" colspan="${colspanAlt}" class="${colspanAlt > 0 ? "" : "d-none hidden-element"}">Alternate Text</th> 
                            <th class="transparent" colspan="${colspanName}">File Name</th>
                            <th class="transparent" colspan="1">Result</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="align-left ${settings.image_alt ? "" : "d-none hidden-element"}">Content</th>
                            <th class="text-center ${settings.image_alt_only_spaces ? "" : "d-none hidden-element"}">
                                <span class="bulk-th-tooltip-inline">Spaces${typeof getCriteriaTooltipMarkup === 'function' ? getCriteriaTooltipMarkup('<p>Words separated by spaces?</p>', 'bulk-tooltips-contents') : ''}</span>
                            </th>
                            <th class="align-left">File name</th>
                            <th class="${settings.image_name_max_characters ? "" : "d-none hidden-element"}" style="white-space: nowrap;">LEN</th>
                            <th class="${settings.image_name_only_hyphens ? "" : "d-none hidden-element"}">Words separated by hyphens?</th>
                            <th class="text-center ${settings.image_name_no_uppercase ? "" : "d-none hidden-element"}">Uppercase characters?</th>
                            <th class="text-center ${settings.image_name_no_special ? "" : "d-none hidden-element"}">Special characters?</th>
                            <th class="${settings.image_max_size ? "" : "d-none hidden-element"}">File Size</th>
                            <th class=""></th>
                        </tr>
                        </thead>`

                        results.forEach((result, i)=>{
                            result.problems.forEach((prob, z)=>{
                                const tr = document.createElement("tr")
                                tr.innerHTML = `
                                <td class="${z===0 ? 'has-border' : ''}">${z===0 ? i+1 : ''}</td>
                                <td class="align-left ${z===0 ? 'has-border' : ''}">${z===0 ? result.tested_url: ''}</td>
                                <td class="content-td image-table-link text-center" td-replace="${prob.imageSrc}"><a href="${prob.imageSrc}" target="_blank">Link</a></td>
                                <td class="align-left ${settings.image_alt ? "" : "d-none hidden-element"}">${prob.imageAlt}</td>
                                <td class="text-center ${prob.imageAltSpacesClass} ${settings.image_alt_only_spaces ? "" : "d-none hidden-element"}">${prob.imageAltSpacesStatus ? "<span class='result_pass'>Yes</span>" : "<span class='result_fail'>No</span>"}</td>
                                <td class="align-left">${prob.imageName}</td>
                                <td class="${prob.imageLengthClass} ${settings.image_name_max_characters ? "" : "d-none hidden-element"}">${prob.imageLengthStatus ? prob.imageName.length : "-"}</td>
                                <td class="text-center ${prob.imageHyphenClass} ${settings.image_name_only_hyphens ? "" : "d-none hidden-element"}">${prob.imageHyphenStatus ? "<span class='result_pass'>Yes</span>" : "<span class='result_fail'>No</span>"}</td>
                                <td class="text-center ${prob.imageUppercaseClass} ${settings.image_name_no_uppercase ? "" : "d-none hidden-element"}">${prob.imageUppercaseStatus ? "<span class='result_fail'>Yes</span>" : "<span class='result_pass'>No</span>"}</td>
                                <td class="text-center ${prob.imageSpecialClass} ${settings.image_name_no_special ? "" : "d-none hidden-element"}">${prob.imageSpecialStatus ? "<span class='result_fail'>Yes</span>" : "<span class='result_pass'>No</span>"}</td>
                                <td class="${prob.imageSizeClass} ${settings.image_max_size ? "" : "d-none hidden-element"}">${prob.imageSizeValue}</td>
                                <td class="${prob.status ? "result_pass" : "result_fail"}">${prob.status ? "PASS" : "FAIL"}</td>
                                `
                                tbody.appendChild(tr)
                            })
                        })
                        createDatatableElement();
                        break;
                        case "compression":
                        case "stylesheet":
                        case "script":
                        case "gzip_compression":
                        case "nestedtables":
                        case "frameset":
                        case "pagesize":
                        case "css_caching_enable":
                        case "js_caching_enable":
                        case "xframe":
                        case "mobile_friendly":    
                        table.classList.add("dataTable")
                        table.classList.add("custom-dataTable")  
                        thead = `<thead class="result_data_header">
                        <tr>
                            <th style="width:3%;">#</th>
                            <th class="result_header" style="width:60%;"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                            <th style="width:37%;">Result</th>
                        </tr>
                        </thead>`

                        results.forEach((result, i)=>{
                            const tr = document.createElement("tr")
                            tr.innerHTML = `
                            <td style="text-align:center;">${i+1}</td>
                            <td class="align-left">${result.tested_url}</td>
                            <td class="${result.status ? "result_pass" : "result_fail"} strong" style="text-align:center;"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                            `
                            tbody.appendChild(tr)
                        })
                        createDatatableElement();
                        break;
                    case "page_speed_google":
                        
                        table.classList.add("dataTable")
                        table.classList.add("custom-dataTable")
                        thead = `<thead class="result_data_header">
                        <tr>
                            <th>#</th>
                            <th class="">URL</th>
                            <th class="text-center">Desktop Score</th>
                            <th class="text-center">Mobile Score</th>
                            <th class="text-center">Result</th>
                        </tr>
                       
                        </thead>`

                        results.forEach((result, i)=>{
                            const tr1 = document.createElement("tr")
                            tr1.innerHTML = `
                                <tr>
                                    <td>${i+1}</td>
                                    <td class="align-left">${result.tested_url}</td>
                                    <td class="${result.statusDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.scoreDesktop)}</td>
                                    <td class="${result.statusMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.scoreMobile)}</td>
                                    <td class="${result.statusDesktop && result.statusMobile ? "result_pass" : "result_fail"} strong">${result.statusDesktop && result.statusMobile ? "PASS" : "FAIL"}</td>
                                
                                    </tr>`
                            tbody.appendChild(tr1)

                            // const tr2 = document.createElement("tr")
                            // tr2.innerHTML = `
                            //     <tr>
                            //         <td>Mobile</td>
                            //         <td class="${result.statusMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.scoreMobile)}</td>
                            //         <td class="${result.statusMobile ? "result_pass" : "result_fail"}">${result.statusMobile ? "PASS" : "FAIL"}</td>
                            //     </tr>`
                            // tbody.appendChild(tr2)
                        })
                        createDatatableElement();
                        break;
                case "page_speed_google_lighthouse":
                    table.classList.add("dataTable")
                    table.classList.add("custom-dataTable")
                table.classList.add("bulk-table-lighthouse")
                    // Determine which Lighthouse sub-checks are enabled in settings
                    const showPerfDesktop = !!settings.google_performance_desktop;
                    const showPerfMobile = !!settings.google_performance_mobile;
                    const showAccDesktop = !!settings.google_accessibility_desktop;
                    const showAccMobile = !!settings.google_accessibility_mobile;
                    const showBestDesktop = !!settings.google_best_practices_desktop;
                    const showBestMobile = !!settings.google_best_practices_mobile;
                    const showSeoDesktop = !!settings.google_seo_desktop;
                    const showSeoMobile = !!settings.google_seo_mobile;

                    const perfCount = (showPerfDesktop ? 1 : 0) + (showPerfMobile ? 1 : 0);
                    const accCount = (showAccDesktop ? 1 : 0) + (showAccMobile ? 1 : 0);
                    const bestCount = (showBestDesktop ? 1 : 0) + (showBestMobile ? 1 : 0);
                    const seoCount = (showSeoDesktop ? 1 : 0) + (showSeoMobile ? 1 : 0);

                    // Build header rows conditionally based on enabled checks
                    let firstRow = `<tr><th>#</th><th>URL</th>`;
                    if (perfCount > 0) firstRow += `<th colspan="${perfCount}" class="text-center">Performance</th>`;
                    if (accCount > 0) firstRow += `<th colspan="${accCount}" class="text-center">Accessibility</th>`;
                    if (bestCount > 0) firstRow += `<th colspan="${bestCount}" class="text-center">Best Practices</th>`;
                    if (seoCount > 0) firstRow += `<th colspan="${seoCount}" class="text-center">SEO</th>`;
                    firstRow += `<th>Result</th></tr>`;

                    let secondRow = `<tr><th></th><th></th>`;
                    if (showPerfDesktop) secondRow += `<th>Desktop</th>`;
                    if (showPerfMobile) secondRow += `<th>Mobile</th>`;
                    if (showAccDesktop) secondRow += `<th>Desktop</th>`;
                    if (showAccMobile) secondRow += `<th>Mobile</th>`;
                    if (showBestDesktop) secondRow += `<th>Desktop</th>`;
                    if (showBestMobile) secondRow += `<th>Mobile</th>`;
                    if (showSeoDesktop) secondRow += `<th>Desktop</th>`;
                    if (showSeoMobile) secondRow += `<th>Mobile</th>`;
                    secondRow += `<th></th></tr>`;

                    thead = `<thead class="result_data_header">${firstRow}${secondRow}</thead>`;

                    results.forEach((result, i)=>{
                        const tr1 = document.createElement("tr")
                        let rowHtml = `<tr>
                            <td class="text-center">${i+1}</td>
                            <td class="align-left">${result.tested_url}</td>`;

                        if (showPerfDesktop) rowHtml += `<td class="text-center ${result.statusPerformanceDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.scoreDesktop)}</td>`;
                        if (showPerfMobile)  rowHtml += `<td class="text-center ${result.statusPerformanceMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.scoreMobile)}</td>`;

                        if (showAccDesktop)  rowHtml += `<td class="text-center ${result.statusAccessibilityDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.accessibilityDesktop)}</td>`;
                        if (showAccMobile)   rowHtml += `<td class="text-center ${result.statusAccessibilityMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.accessibilityMobile)}</td>`;

                        if (showBestDesktop) rowHtml += `<td class="text-center ${result.statusBestPracticesDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.bestPracticesDesktop)}</td>`;
                        if (showBestMobile)  rowHtml += `<td class="text-center ${result.statusBestPracticesMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.bestPracticesMobile)}</td>`;

                        if (showSeoDesktop)  rowHtml += `<td class="text-center ${result.statusSeoDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.seoDesktop)}</td>`;
                        if (showSeoMobile)   rowHtml += `<td class="text-center ${result.statusSeoMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.seoMobile)}</td>`;

                        rowHtml += `<td class="text-center ${result.statusDesktop && result.statusMobile ? "result_pass" : "result_fail"} strong">${result.statusDesktop && result.statusMobile ? "PASS" : "FAIL"}</td>`;
                        rowHtml += `</tr>`;

                        tr1.innerHTML = rowHtml;
                        tbody.appendChild(tr1)
                    })
                    createDatatableElement();
                    // Set dynamic column widths for Lighthouse table
                    setTimeout(function() {
                        setDynamicColumnWidths(table, 'lighthouse');
                    }, 100);
                break;
            case "page_speed_google_core":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                table.classList.add("bulk-table-core")
                // Determine which Core Web Vitals sub-checks are enabled in settings
                const showLcpDesktop = !!settings.google_lcp_desktop;
                const showLcpMobile = !!settings.google_lcp_mobile;
                const showFidDesktop = !!settings.google_fid_desktop;
                const showFidMobile = !!settings.google_fid_mobile;
                const showClsDesktop = !!settings.google_cls_desktop;
                const showClsMobile = !!settings.google_cls_mobile;
                const showFcpDesktop = !!settings.google_fcp_desktop;
                const showFcpMobile = !!settings.google_fcp_mobile;
                const showTtiDesktop = !!settings.google_tti_desktop;
                const showTtiMobile = !!settings.google_tti_mobile;
                const showSiDesktop = !!settings.google_speed_index_desktop;
                const showSiMobile = !!settings.google_speed_index_mobile;
                const showTbtDesktop = !!settings.google_tbt_desktop;
                const showTbtMobile = !!settings.google_tbt_mobile;

                const lcpCount = (showLcpDesktop ? 1 : 0) + (showLcpMobile ? 1 : 0);
                const fidCount = (showFidDesktop ? 1 : 0) + (showFidMobile ? 1 : 0);
                const clsCount = (showClsDesktop ? 1 : 0) + (showClsMobile ? 1 : 0);
                const fcpCount = (showFcpDesktop ? 1 : 0) + (showFcpMobile ? 1 : 0);
                const ttiCount = (showTtiDesktop ? 1 : 0) + (showTtiMobile ? 1 : 0);
                const siCount = (showSiDesktop ? 1 : 0) + (showSiMobile ? 1 : 0);
                const tbtCount = (showTbtDesktop ? 1 : 0) + (showTbtMobile ? 1 : 0);

                let firstRowCore = `<tr><th>#</th><th>URL</th>`;
                if (lcpCount > 0) firstRowCore += `<th colspan="${lcpCount}" class="text-center">LCP</th>`;
                if (fidCount > 0) firstRowCore += `<th colspan="${fidCount}" class="text-center">FID</th>`;
                if (clsCount > 0) firstRowCore += `<th colspan="${clsCount}" class="text-center">CLS</th>`;
                if (fcpCount > 0) firstRowCore += `<th colspan="${fcpCount}" class="text-center">FCP</th>`;
                if (ttiCount > 0) firstRowCore += `<th colspan="${ttiCount}" class="text-center">TTI</th>`;
                if (siCount > 0) firstRowCore += `<th colspan="${siCount}" class="text-center">SI</th>`;
                if (tbtCount > 0) firstRowCore += `<th colspan="${tbtCount}" class="text-center">TBT</th>`;
                firstRowCore += `<th></th></tr>`;

                let secondRowCore = `<tr><th></th><th></th>`;
                if (lcpCount > 0) secondRowCore += `<th colspan="${lcpCount}" class="text-center">(seconds)</th>`;
                if (fidCount > 0) secondRowCore += `<th colspan="${fidCount}" class="text-center">(milliseconds)</th>`;
                if (clsCount > 0) secondRowCore += `<th colspan="${clsCount}" class="text-center">(seconds)</th>`;
                if (fcpCount > 0) secondRowCore += `<th colspan="${fcpCount}" class="text-center">(milliseconds)</th>`;
                if (ttiCount > 0) secondRowCore += `<th colspan="${ttiCount}" class="text-center">(milliseconds)</th>`;
                if (siCount > 0) secondRowCore += `<th colspan="${siCount}" class="text-center">(seconds)</th>`;
                if (tbtCount > 0) secondRowCore += `<th colspan="${tbtCount}" class="text-center">(seconds)</th>`;
                secondRowCore += `<th></th></tr>`;

                let thirdRowCore = `<tr><th></th><th></th>`;
                if (showLcpDesktop) thirdRowCore += `<th>Desktop</th>`;
                if (showLcpMobile) thirdRowCore += `<th>Mobile</th>`;
                if (showFidDesktop) thirdRowCore += `<th>Desktop</th>`;
                if (showFidMobile) thirdRowCore += `<th>Mobile</th>`;
                if (showClsDesktop) thirdRowCore += `<th>Desktop</th>`;
                if (showClsMobile) thirdRowCore += `<th>Mobile</th>`;
                if (showFcpDesktop) thirdRowCore += `<th>Desktop</th>`;
                if (showFcpMobile) thirdRowCore += `<th>Mobile</th>`;
                if (showTtiDesktop) thirdRowCore += `<th>Desktop</th>`;
                if (showTtiMobile) thirdRowCore += `<th>Mobile</th>`;
                if (showSiDesktop) thirdRowCore += `<th>Desktop</th>`;
                if (showSiMobile) thirdRowCore += `<th>Mobile</th>`;
                if (showTbtDesktop) thirdRowCore += `<th>Desktop</th>`;
                if (showTbtMobile) thirdRowCore += `<th>Mobile</th>`;
                thirdRowCore += `<th>Result</th></tr>`;

                thead = `<thead class="result_data_header">${firstRowCore}${secondRowCore}${thirdRowCore}</thead>`;

                results.forEach((result, i)=>{
                    const tr1 = document.createElement("tr")
                    let rowHtml = `<tr>
                        <td class="text-center">${i+1}</td>
                        <td class="align-left">${result.tested_url}</td>`;

                    if (showLcpDesktop) rowHtml += `<td class="text-center ${result.statusLCPDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.lcpDesktop)}</td>`;
                    if (showLcpMobile)  rowHtml += `<td class="text-center ${result.statusLCPMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.lcpMobile)}</td>`;

                    if (showFidDesktop) rowHtml += `<td class="text-center ${result.statusFIDDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.fidDesktop)}</td>`;
                    if (showFidMobile)  rowHtml += `<td class="text-center ${result.statusFIDMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.fidMobile)}</td>`;

                    if (showClsDesktop) rowHtml += `<td class="text-center ${result.statusCLSDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.clsDesktop)}</td>`;
                    if (showClsMobile)  rowHtml += `<td class="text-center ${result.statusCLSMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.clsMobile)}</td>`;

                    if (showFcpDesktop) rowHtml += `<td class="text-center ${result.statusFCPDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.fcpDesktop)}</td>`;
                    if (showFcpMobile)  rowHtml += `<td class="text-center ${result.statusFCPMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.fcpMobile)}</td>`;

                    if (showTtiDesktop) rowHtml += `<td class="text-center ${result.statusTTIDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.ttiDesktop)}</td>`;
                    if (showTtiMobile)  rowHtml += `<td class="text-center ${result.statusTTIMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.ttiMobile)}</td>`;

                    if (showSiDesktop) rowHtml += `<td class="text-center ${result.statusSIDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.siDesktop)}</td>`;
                    if (showSiMobile)  rowHtml += `<td class="text-center ${result.statusSIMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.siMobile)}</td>`;

                    if (showTbtDesktop) rowHtml += `<td class="text-center ${result.statusTBTDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.tbtDesktop)}</td>`;
                    if (showTbtMobile)  rowHtml += `<td class="text-center ${result.statusTBTMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.tbtMobile)}</td>`;

                    rowHtml += `<td class="text-center ${result.statusDesktop && result.statusMobile ? "result_pass" : "result_fail"} strong">${result.statusDesktop && result.statusMobile ? "PASS" : "FAIL"}</td>`;
                    rowHtml += `</tr>`;

                    tr1.innerHTML = rowHtml;
                    tbody.appendChild(tr1)
                })
                createDatatableElement();
                // Set dynamic column widths for Core Web Vitals table
                setTimeout(function() {
                    setDynamicColumnWidths(table, 'core');
                }, 100);
                break;
            /*case "content-security": 
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>
                `
                tbody.appendChild(tr)
            })
            break;  
            
            case "hsts": 
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>
                `
                tbody.appendChild(tr)
            })
            break;
            case "xframe": 
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>
                `
                tbody.appendChild(tr)
            })
            break;
            
            case "ssl-certificate": 
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>
                `
                tbody.appendChild(tr)
            })
            break;

            case "directory-browsing": 
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>
                `
                tbody.appendChild(tr)
            })
            break;

            case "bad-content-type": 
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>
                `
                tbody.appendChild(tr)
            })
            break; */
            case "ssl-certificate":
            case  "directory-browsing":   
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
                 <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="export-hidden-element">Output</th>
                    <th>Result</th>
                </tr>
                </thead>`
    
                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left">${result.tested_url}</td>
                    <td class="export-hidden-element">${result.message}</td>
                    <td class="${result.status ? "result_pass" : "result_fail"} strong">${result.status ? "PASS" : "FAIL"}</td>
                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();    
            break;
            case "cross-origin-links":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
             <tr>
                <th style="width:3%;">#</th>
                <th class="result_header" style="width:60%;"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th class="export-hidden-element" style="width:18%;">Output</th>
                <th style="width:10%;">Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td style="text-align:center;">${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="export-hidden-element" style="text-align:center;">${result.message}</td>
                <td class="${result.status ? "result_pass" : "result_fail"} strong" style="text-align:center;font-weight:bold;">${result.status ? "PASS" : "FAIL"}
                <span class="export-hidden-element">
                <br><br>
             
                ${result.status ? `` : `<span data-bs-toggle="modal" data-bs-target="#crossOriginModal${i}" 
                style="cursor: pointer;font-weight:normal;font-size:12px;color:#6e6e6e;">List of Links</span>`}
                

                
                <div class="modal custom-modal" id="crossOriginModal${i}">
                <div class="modal-dialog">
                  <div class="modal-content" style="border-radius:7px;">
                  <!-- Modal Header -->
                    <div class="modal-header" style="background: #f4f7fe;border-radius:7px;">
                     <h1 class="modal-title fs-5" style="font-weight:bold;">Unsafe cross origin links</h1>
                     <button type="button" class="btn-close" style="cursor:pointer;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                 <!-- Modal Body -->
                 <div class="modal-body" style="text-align:left;font-weight:normal;">
                 <p style="margin-bottom:20px;">Below are the cross-origin links found on this page.</p>
                 

                 <table class="tool-table" style="background:#FFFFFF;border:1px solid #FFFFFF;">

          <tbody>          
                 ${result.crossOriginLinksData.map((item, index) => `
                       <tr>
                         <td style="width:5%">${index + 1}</td>
                         <td><span><a href="${item}" target="_blank">${item}</a></span>
                         </td>
                     </tr>
                     `).join('')}   
                           </tbody>  
                </table>

                </div>
               <!-- Modal Footer -->
             </div>
           </div>
          </div></div>
         </div>
          </div>
          </div>
          </td>   `
                tbody.appendChild(tr)
            })
            createDatatableElement();
            break;

            case "protocall-relative-resource-links":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th class="export-hidden-element">Output</th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="export-hidden-element">${result.message}</td>
                <td class="${result.status ? "result_pass" : "result_fail"} strong">${result.status ? "PASS" : "FAIL"}
                <span class="export-hidden-element">
                <br><br>
                <span class="" data-bs-toggle="modal" data-bs-target="#protocolModal${i}" 
                                style="cursor: pointer;">List of Links</span>

                
                <div class="modal custom-modal" id="protocolModal${i}">
                <div class="modal-dialog">
                  <div class="modal-content">
                  <!-- Modal Header -->
                    <div class="modal-header">
                     <span class="modal-title">Protocol Relative Resource Links</span>
                     <span  class="tool-test-close close modal-close" data-bs-dismiss="modal">&times;</span>
                    </div>
                 <!-- Modal Body -->
                 <div class="modal-body">
                 <span style="padding-bottom: 10px;" class="analysis-body-css">Below are the links found on this page which qualify as Protocol resource links.</span>
                 <div class="modal-table-div">
                 <table class="tool-table">

          <tbody>          
                 ${result.protocolRelativeResourceData.map((item, index) => `
                       <tr>
                         <td>${index + 1}</td>
                         <td>
                         <span><a href="${item}" target="_blank"><i class="fas fa-external-link-alt" style="color:#c3c9d1"></i></a></span><span><a href="${item}" target="_blank">${item}</a></span>
                         </td>
                     </tr>
                     `).join('')}   
                           </tbody>  
                </table>
                </div>
                </div>
               <!-- Modal Footer -->
             </div>
           </div>
          </div></div>
         </div>
          </div>
          </span>
          </td>   `
                tbody.appendChild(tr)
            })
            createDatatableElement();
            break;

            case "broken_links":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = 
                `<thead class="result_data_header">
                    <tr>
                        <th>#</th>
                        <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                        <th>Internal</th>
                        <th>External</th>

                        
                        <th>List of broken links</th>
                        <th>Result</th>
                    </tr>
                </thead>`
                
                // Create single modal outside the loop (check if it already exists)
                let brokenLinksModal = document.getElementById("brokenLinksModal")
                if(!brokenLinksModal){
                    brokenLinksModal = document.createElement("div")
                    brokenLinksModal.className = "modal fade meta-list-brokenBody"
                    brokenLinksModal.id = "brokenLinksModal"
                    brokenLinksModal.setAttribute("aria-labelledby", "exampleModalToggleLabel")
                    brokenLinksModal.setAttribute("tabindex", "1")
                    brokenLinksModal.setAttribute("aria-hidden", "true")
                    brokenLinksModal.style.display = "none"
                    brokenLinksModal.innerHTML = `
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                            List of broken links
                                        </h1>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="overflow-x: hidden;">
                                    <div class="card-body bulk-broken-links-modal">
                                        <div class="meta-list-single" id="brokenLinksModalContent" style="overflow-x: hidden;">
                                            <!-- Content will be dynamically updated here -->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer-alert"></div>
                            </div>
                        </div>
                    `
                    // Append modal to body (outside table)
                    document.body.appendChild(brokenLinksModal)
                }
                
                // Initialize or get Bootstrap modal instance
                let brokenLinksModalInstance = bootstrap.Modal.getInstance(brokenLinksModal)
                if(!brokenLinksModalInstance){
                    brokenLinksModalInstance = new bootstrap.Modal(brokenLinksModal, {
                        keyboard: false
                    })
                }
                
                // Store broken links data for each row (use window or a more accessible scope)
                if(!window.brokenLinksData){
                    window.brokenLinksData = []
                } else {
                    window.brokenLinksData = [] // Reset for new table
                }
                
            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                
                // Determine what to show in the "List of broken links" column
                let listOfBrokenLinksContent = ""
                
                if(result.status_url){
                    // URL was parsed successfully
                    const totalBroken = result.totalBrokenLinks != null ? result.totalBrokenLinks : 0
                    
                    if(totalBroken > 0){
                        // Store broken links data for this row
                        window.brokenLinksData[i] = {
                            allLinks: result.allLinks,
                            tested_url: result.tested_url,
                            totalBroken: totalBroken
                        }
                        
                        // Has broken links - show clickable link
                        listOfBrokenLinksContent = `<span class="show-broken-links-modal" data-row-index="${i}" style="cursor: pointer; color: #3A7CEC; text-decoration: underline;">List of Broken link</span>`
                    } else {
                        // No broken links (totalBrokenLinks is 0) - show message
                        listOfBrokenLinksContent = result.message || "No broken links found"
                    }
                } else {
                    // URL parsing failed - show error message
                    listOfBrokenLinksContent = result.message
                }
                
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="align-left">${result.status_url ? result.internal != null ? result.internal.length  : 0 : "NA"}</td>
                <td class="align-left">${result.status_url ? result.external != null ? result.external.length  : 0 : "NA"}</td>

                <td class="align-left">${listOfBrokenLinksContent}</td>
                <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>`
                tbody.appendChild(tr)
            })
            
            // Add click event handler for "List of Broken link" links (using event delegation)
            $(document).off('click', '.show-broken-links-modal').on('click', '.show-broken-links-modal', function(e){
                e.preventDefault()
                e.stopPropagation()
                const rowIndex = parseInt($(this).data('row-index'))
                const rowData = window.brokenLinksData && window.brokenLinksData[rowIndex]
                
                if(rowData && rowData.allLinks){
                    // Generate broken links HTML
                    const brokenLinksHtml = UI.getBrokenLinks(rowData.allLinks, false)
                    
                    // Update modal content
                    const modalContent = document.getElementById('brokenLinksModalContent')
                    if(modalContent){
                        modalContent.innerHTML = brokenLinksHtml
                        
                        // Get or create modal instance
                        const modalElement = document.getElementById('brokenLinksModal')
                        let modalInstance = bootstrap.Modal.getInstance(modalElement)
                        if(!modalInstance){
                            modalInstance = new bootstrap.Modal(modalElement, {
                                keyboard: false
                            })
                        }
                        
                        // Show modal
                        modalInstance.show()
                    } else {
                        console.error('Modal content element not found')
                    }
                } else {
                    console.error('Row data or allLinks not found for index:', rowIndex)
                }
            })
            
            createDatatableElement();    
            break;


            case "headings-test":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th>Output</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left">${result.tested_url}</td>
                    <td>
                    <div class="bulk-headings-message">
                    <span>${result.message}</span>
                        <button class="showhide-btn showhide-btn-bulk collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target=".multi-collapse2`+i+`" aria-expanded="false"
                            aria-controls="multiCollapsePerformanceHeadings">
                            <span class="show">Show</span>
                            <span class="hide">Hide</span>
                            details
                            <svg width="8" height="5" viewBox="0 0 8 5" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <br>
                    <div class="card-inner-content collapse multi-collapse2`+i+`" id="multiCollapsePerformanceHeadings">
                        <table class="table-headings-collapse">
                          <thead>
                            <tr>
                              <th style="width: 60px;">Heading</th>
                              <th style="width: 60px;">Quantity</th>
                              <th>Content</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- H1 -->
                            <tr>
                              <td style="width: 60px;">H1</td>
                              ${result.headingArray['h1'].length > 0 ? `
                              <td style="width: 60px;">${result.headingArray['h1'].length}</td>
                              <td class="content-cell">

                                ${result.headingArray['h1'].length > 0 ? 
                                    `
                                    <span>${result.headingArray['h1'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${result.headingArray['h1'].length > 12 ? '' : 'd-none'}" data-id="h1" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>

                              ` :
                              `
                              <td style="width: 60px;">0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H1 heading tags</div>
                              </td>`}
                            </tr>

                              ${result.headingArray['h1'].length > 0 ? 
                                  `
                                    ${result.headingArray['h1'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h1">
                                      <td style="width: 60px;"></td>
                                      <td style="width: 60px;"></td>
                                      <td class="content-cell">
                                      ${item}
                                      </td>
                                    </tr>
                                    `).join('')}` 
                                : ``
                              }

                            <!-- H2 -->
                            <tr>
                              <td style="width: 60px;">H2</td>
                              ${result.headingArray['h2'].length > 0 ? `
                              <td style="width: 60px;">${result.headingArray['h2'].length}</td>
                              <td class="content-cell">

                                ${result.headingArray['h2'].length > 0 ? 
                                    `
                                    <span>${result.headingArray['h2'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${result.headingArray['h2'].length > 12 ? '' : 'd-none'}" data-id="h2" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>
                              ` : 
                              `
                              <td style="width: 60px;">0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H2 heading tags</div>
                              </td>`}
                            </tr>
                            
                            ${result.headingArray['h2'].length > 0 ? 
                                  `
                                    ${result.headingArray['h2'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h2">
                                      <td style="width: 60px;"></td>
                                      <td style="width: 60px;"></td>
                                      <td class="content-cell">
                                      ${item}
                                      </td>
                                    </tr>
                                    `).join('')}` 
                                : ``
                              }

                            <!-- H3 -->
                            <tr>
                              <td style="width: 60px;">H3</td>
                              ${result.headingArray['h3'].length > 0 ? `
                              <td style="width: 60px;">${result.headingArray['h3'].length}</td>
                              <td class="content-cell">

                                ${result.headingArray['h3'].length > 0 ? 
                                    `
                                    <span>${result.headingArray['h3'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${result.headingArray['h3'].length > 12 ? '' : 'd-none'}" data-id="h3" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>
                              ` :
                              `
                              <td style="width: 60px;">0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H3 heading tags</div>
                              </td>`}
                            </tr>
                            
                            ${result.headingArray['h3'].length > 0 ? 
                                  `
                                    ${result.headingArray['h3'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h3">
                                      <td style="width: 60px;"></td>
                                      <td style="width: 60px;"></td>
                                      <td class="content-cell">
                                      ${item}
                                      </td>
                                    </tr>
                                    `).join('')}` 
                                : ``
                              }

                            <!-- H4 -->
                            <tr>
                              <td style="width: 60px;">H4</td>
                              ${result.headingArray['h4'].length > 0 ? `
                              <td style="width: 60px;">${result.headingArray['h4'].length}</td>
                              <td class="content-cell">

                                ${result.headingArray['h4'].length > 0 ? 
                                    `
                                    <span>${result.headingArray['h4'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${result.headingArray['h4'].length > 12 ? '' : 'd-none'}" data-id="h4" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>
                              ` : 
                              `
                              <td style="width: 60px;">0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H4 heading tags</div>
                              </td>`}
                            </tr>
                            
                            ${result.headingArray['h4'].length > 0 ? 
                                  `
                                    ${result.headingArray['h4'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h4">
                                      <td style="width: 60px;"></td>
                                      <td style="width: 60px;"></td>
                                      <td class="content-cell">
                                      ${item}
                                      </td>
                                    </tr>
                                    `).join('')}` 
                                : ``
                              }

                            <!-- H5 -->
                            <tr>
                              <td style="width: 60px;">H5</td>
                              ${result.headingArray['h5'].length > 0 ? `
                              <td style="width: 60px;">${result.headingArray['h5'].length}</td>
                              <td class="content-cell">

                                ${result.headingArray['h5'].length > 0 ? 
                                    `
                                    <span>${result.headingArray['h5'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${result.headingArray['h5'].length > 12 ? '' : 'd-none'}" data-id="h5" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>
                              ` :
                              `
                              <td style="width: 60px;">0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H5 heading tags</div>
                              </td>`}
                            </tr>

                            ${result.headingArray['h5'].length > 0 ? 
                                  `
                                    ${result.headingArray['h5'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h5">
                                      <td style="width: 60px;"></td>
                                      <td style="width: 60px;"></td>
                                      <td class="content-cell">
                                      ${item}
                                      </td>
                                    </tr>
                                    `).join('')}` 
                                : ``
                              }

                          </tbody>
                        </table>
                      </div>
                    </td>
                    <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>
                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();
                // Set dynamic column widths for headings detail tables
                setTimeout(function() {
                    document.querySelectorAll(".table-headings-collapse").forEach(function(subTable) {
                        setDynamicColumnWidths(subTable, 'headings');
                    });
                }, 100);
                break;
                

            case "viewport":
                table.classList.add("dataTable")
            table.classList.add("custom-dataTable")
            thead = `<thead class="result_data_header">
             <tr>
                <th style="width:3%;">#</th>
                <th class="result_header" style="width:60%;"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th style="width:19%;">Meta viewport tag present?</th>
                <th style="width:18%;">Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td style="text-align:center;">${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="${result.status ? "result_pass" : "result_fail"} strong" style="text-align:center;"><strong>${result.status ? "Yes" : "No"}</strong></td>
                <td class="${result.status ? "result_pass" : "result_fail"} strong" style="text-align:center;"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                `
                tbody.appendChild(tr)
            })
            break;
            case "doctype":
                table.classList.add("dataTable")
            table.classList.add("custom-dataTable")
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>Doctype Tag Present?</th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "Yes" : "No"}</strong></td>
                <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                `
                tbody.appendChild(tr)
            })
            break;
            case "http_status_code":
                table.classList.add("dataTable")
            table.classList.add("custom-dataTable")
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>HTTP Status Code</th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.httpCode} ${result.httpCodeName}</strong></td>
                <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                `
                tbody.appendChild(tr)
            })
            createDatatableElement();
            break;
            
            default: 
            table.classList.add("dataTable")
            table.classList.add("custom-dataTable")
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>Output</th>
                <th>Result</th>
            </tr>
            </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="content-td">${result.message}</td>
                <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}</td>
                `
                tbody.appendChild(tr)
            })
            createDatatableElement();
            break;
            
        }


        table.innerHTML+=thead
        table.appendChild(tbody)

        $(".test_result_area .table-responsive").append(table)
        
        toggleTestResultAreaVisibility();

        if ($('.custom-dataTable').length) {
            var datatableClass =  'custom-dataTable';
          initializeCustomDataTable(datatableClass)
        }
        
        // if(label.name === "img" ||  label.name === "title"){ 
        //   var datatableClass =  'custom-dataTable';
        //   initializeCustomDataTable(datatableClass)
        // }
        if(label.name === "og:title"){
            table.id = "table_og_title"
            
            const tableOgDesc = document.createElement("table")
            tableOgDesc.classList.add("d-none")
            tableOgDesc.id = "table_og_desc"
            tableOgDesc.classList.add("table")
            tableOgDesc.classList.add("bulk-table")
            tableOgDesc.classList.add("table-bordered")

            const tableOgImage = document.createElement("table")
            tableOgImage.classList.add("d-none")
            tableOgImage.id = "table_og_image"
            tableOgImage.classList.add("table")
            tableOgImage.classList.add("bulk-table")
            tableOgImage.classList.add("table-bordered")

            const tableOgURL = document.createElement("table")
            tableOgURL.classList.add("d-none")
            tableOgURL.id = "table_og_url"
            tableOgURL.classList.add("table")
            tableOgURL.classList.add("bulk-table")
            tableOgURL.classList.add("table-bordered")

            tableOgDesc.innerHTML+=thead2
            tableOgDesc.appendChild(tbody2)

            tableOgImage.innerHTML+=thead3
            tableOgImage.appendChild(tbody3)

            tableOgURL.innerHTML+=thead4
            tableOgURL.appendChild(tbody4)
            $(".test_result_area .table-responsive").append(tableOgDesc)
            $(".test_result_area .table-responsive").append(tableOgImage)
            $(".test_result_area .table-responsive").append(tableOgURL)
            // Set dynamic column widths for OG tables
            setTimeout(function() {
                setDynamicColumnWidths(table, 'og');
                setDynamicColumnWidths(tableOgDesc, 'og');
                setDynamicColumnWidths(tableOgImage, 'og');
                setDynamicColumnWidths(tableOgURL, 'og');
            }, 100);
        }

        if(label.name === "twitter:title"){
            table.id = "table_twitter_title"
            
            const tableTwitterImage = document.createElement("table")
            tableTwitterImage.classList.add("d-none")
            tableTwitterImage.id = "table_twitter_image"
            tableTwitterImage.classList.add("table")
            tableTwitterImage.classList.add("bulk-table")
            tableTwitterImage.classList.add("table-bordered")

            const tableTwitterImageAlt = document.createElement("table")
            tableTwitterImageAlt.classList.add("d-none")
            tableTwitterImageAlt.id = "table_twitter_image_alt"
            tableTwitterImageAlt.classList.add("table")
            tableTwitterImageAlt.classList.add("bulk-table")
            tableTwitterImageAlt.classList.add("table-bordered")

            tableTwitterImage.innerHTML+=thead2
            tableTwitterImage.appendChild(tbody2)

            tableTwitterImageAlt.innerHTML+=thead3
            tableTwitterImageAlt.appendChild(tbody3)

            $(".test_result_area .table-responsive").append(tableTwitterImage)
            $(".test_result_area .table-responsive").append(tableTwitterImageAlt)
            // Set dynamic column widths for Twitter tables
            setTimeout(function() {
                setDynamicColumnWidths(table, 'twitter');
                setDynamicColumnWidths(tableTwitterImage, 'twitter');
                setDynamicColumnWidths(tableTwitterImageAlt, 'twitter');
            }, 100);
        }
    }



    // document.getElementById('updateStatusModal').addEventListener('hidden.bs.modal', function (event) {
    //     const el = activeUpdateStatusElement.querySelector(".intentional")
    //     el.checked = !el.checked
    // })


    $("#confirmStatusUpdate").on( "click", function(e) {
        $(".table-container").html("")

        activeUpdateData.status = !activeUpdateData.status 
        activeUpdateData.problems = []

        for(var i = 0;i < resultsFailed.length;i++){
            const el = resultsFailed[i]
            if(el.label.name === activeUpdateData.label.name){
                resultsFailed.splice(i, 1)
            }
        }

        if(results.length > 0){
            buildTable()
            buildFailedList(resultsFailed)
        }

        updateStatusModal.toggle()
        updateEvents()
        
    })


    $(".http-checkbox").on("change", function(){
        Controls.updateHTTPInput(this)
    })
    



    $(".check-close").on("click", (e)=>{
        $(".drop-toggle").prop("checked", false)
        $(".toggle i").removeClass("active")
    })

    $("#sendAnalysisEmailBtn").on('click', function (e) {
        if(validateEmailReport()){
            const table = $( ".test_result_area table" ).clone()[0]
            sendEmail(table)
        }
    });


    $("#selectAll").on( "click", function(e) {
        const parent = e.target.parentElement.parentElement
        const els = parent.querySelectorAll(`input[type="checkbox"]`)
        els.forEach(el=>{
            if(!el.hasAttribute("disabled")){
                el.setAttribute("checked", true)
            }
        })
        
        e.preventDefault()
    })

    // toggle bulk test criteria
    $(".test-criteria").click(function () {
        UI.toggleTestCriteria($(".test-criteria"));
    });

    // reset bulk tool settings
    $("#resetDefaultBulk").click(function () {
        Controls.resetDefaultSettings();
    });

    // toggle test criteria
    $(".toggle-test-criteria").click(function () {
        UI.toggleTestCriteria($(".test-criteria"));
    });

    // toggle test criteria
    $(".single-post-left-sidebar a").click(function (e) {
        e.preventDefault();
        UI.bulkContentRedirect(e.target);
    });

    function createDatatableElement() {
        var paginationHtml = `
        <div class="table-pagination ms-auto">
            <div class="showing-pagination">
                <span id="pagination-info">Showing 1 - 10 of 112</span>
                <div class="btn-group me-2 showing-pagination-btn" role="group" aria-label="First group">
                    <button type="button" id="prev-page" class="btn btn-outline-gray">
                        <i class="fa-solid fa-angle-left"></i>
                    </button>
                    <button type="button" id="next-page" class="btn btn-primary" style="height: 25px;
                    padding: 5px 11px;">
                    <i class="fa-solid fa-angle-right"></i>
                    </button>
                </div>
            </div>
            <div class="total-row">
                <span>Go to:</span>
                <input type="text" name="canPageGo" id="canPageGo" class="form-control can-page-go-control">
            </div>
            <div class="show-row">
                <span>Show rows:</span>
                <select name="" id="rows-per-page" class="btn btn-outline-gray">
                    <option value="10">10</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="500">500</option>
                    <option value="-1">All</option>
                </select>
            </div>
        </div>`;
    // Append the pagination element to the container with the class 'test_result_area'
    $('.test_result_area').append(paginationHtml);
    }
    
    function initializeCustomDataTable(datatableClass) {
        // Initialize the DataTable
        var tableImg = $('.' + datatableClass).DataTable({
            pageLength: 10, // Number of rows per page
            paging: true,   // Enable pagination
            info: false,    // Hide the info text (optional)
            searching: true, // Disable default searching
            ordering: false 
        });
    
        // Hide default DataTables pagination, info text, and length controls
        $('.dataTables_paginate').hide();
        $('.dataTables_info').hide();
        $('.dataTables_length').hide();
    
        // Cache custom pagination elements
        var $rowsPerPage = $("#rows-per-page");
        var $paginationInfo = $("#pagination-info");
        var $canPageGo = $("#canPageGo");
        var $prevPage = $("#prev-page");
        var $nextPage = $("#next-page");
    
        // Custom search input
        var $customSearchInput = $("#custom-search");
    
        // Initial update of custom pagination info
        updatePaginationInfo();
    
        // Function to update the custom pagination info
        function updatePaginationInfo() {
            var pageInfo = tableImg.page.info();
            $paginationInfo.text(`Showing ${pageInfo.start + 1} - ${pageInfo.end} of ${pageInfo.recordsTotal}`);
        }
    
        // Change the page length when the rows per page selector is changed
        $rowsPerPage.change(function () {
            var selectedValue = $(this).val();
            // Convert to integer, -1 means show all rows
            var pageLength = parseInt(selectedValue);
            tableImg.page.len(pageLength).draw();
            updatePaginationInfo();
        });
    
        // Go to a specific page when pressing Enter in the "Go to" input
        $canPageGo.keypress(function (e) {
            if (e.which === 13) { // Enter key
                var page = parseInt($(this).val(), 10) - 1;
                if (!isNaN(page)) {
                    tableImg.page(page).draw('page');
                    updatePaginationInfo();
                }
            }
        });
    
        // Navigate to the previous page
        $prevPage.click(function () {
            tableImg.page('previous').draw('page');
            updatePaginationInfo();
        });
    
        // Navigate to the next page
        $nextPage.click(function () {
            tableImg.page('next').draw('page');
            updatePaginationInfo();
        });
    
        // Custom search functionality
        $customSearchInput.on('input', function () {
            tableImg.search(this.value).draw();
            updatePaginationInfo();
        });
    }
   
    /**
     * Function to set dynamic column widths based on visible columns
     * @param {HTMLElement} table - The table element
     * @param {String} tableType - Type of table (e.g., 'title', 'description', etc.)
     */
    function setDynamicColumnWidths(table, tableType) {
        if (!table) return;
        
        // Get all header cells (th elements)
        const thead = table.querySelector('thead');
        if (!thead) return;
        
        const headerCells = (tableType === 'lighthouse' || tableType === 'core')
            ? thead.querySelectorAll('tr:last-child th')
            : thead.querySelectorAll('th');
        const visibleColumns = [];
        const columnTypes = [];
        
        // Identify visible columns and their types
        headerCells.forEach((th, index) => {
            const isHidden = th.classList.contains('d-none') || th.classList.contains('hidden-element');
            if (!isHidden) {
                visibleColumns.push(index);
                
                // Determine column type based on content and position
                const thText = th.textContent.trim().toLowerCase();
                let columnType = 'default';
                
                if (thText === '#' || thText.includes('si no') || index === 0) {
                    columnType = 'rowNumber';
                } else if ((tableType === 'lighthouse' || tableType === 'core') && index === 1) {
                    columnType = 'url';
                } else if ((tableType === 'lighthouse' || tableType === 'core') && index === headerCells.length - 1) {
                    columnType = 'result';
                } else if (thText === 'url' || th.classList.contains('result_header')) {
                    columnType = 'url';
                } else if (tableType === 'headings' && thText === 'heading') {
                    columnType = 'heading';
                } else if (tableType === 'headings' && thText === 'quantity') {
                    columnType = 'quantity';
                } else if ((tableType === 'og' || tableType === 'twitter') && (thText.startsWith('og:') || thText.startsWith('twitter:'))) {
                    columnType = 'content';
                } else if ((tableType === 'lighthouse' || tableType === 'core') && (thText === 'desktop' || thText === 'mobile')) {
                    columnType = 'metric';
                } else if (thText === 'content' || (tableType === 'url' && thText === 'slug')) {
                    columnType = 'content';
                } else if (thText === 'length' || thText === 'len') {
                    columnType = 'length';
                } else if (thText.includes('equal') || thText.includes('h1')) {
                    columnType = 'comparison';
                } else if (thText === 'casing') {
                    columnType = 'casing';
                } else if (thText === 'result') {
                    columnType = 'result';
                }
                
                columnTypes.push(columnType);
            }
        });
        
        // Calculate widths based on number of visible columns and column types
        const widthConfig = calculateColumnWidths(visibleColumns.length, columnTypes, tableType);
        
        // Apply widths to header cells
        headerCells.forEach((th, index) => {
            if (visibleColumns.includes(index)) {
                const widthIndex = visibleColumns.indexOf(index);
                const width = widthConfig[widthIndex];
                if (width) {
                    th.style.width = width + '%';
                    th.style.minWidth = width + '%';
                    th.style.maxWidth = width + '%';
                }
            }
        });
        
        // Apply widths to data cells (td elements)
        const tbody = table.querySelector('tbody');
        if (tbody) {
            const rows = tbody.querySelectorAll('tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                cells.forEach((td, index) => {
                    if (visibleColumns.includes(index)) {
                        const widthIndex = visibleColumns.indexOf(index);
                        const width = widthConfig[widthIndex];
                        if (width) {
                            td.style.width = width + '%';
                            td.style.minWidth = width + '%';
                            td.style.maxWidth = width + '%';
                        }
                    }
                });
            });
        }
        
        // Truncate URLs after column widths are set
        truncateUrlsInTable(table);
    }
    
    /**
     * Truncate URLs in table cells based on calculated column width
     * @param {HTMLElement} table - The table element
     */
    function truncateUrlsInTable(table) {
        if (!table) return;
        
        // Wait for layout to be calculated
        setTimeout(function() {
            const urlCells = table.querySelectorAll('td.result_data_url');
            
            urlCells.forEach(function(cell) {
                const link = cell.querySelector('a');
                if (!link) return;
                
                // Get the full URL text (extract text nodes only, ignore images)
                const img = link.querySelector('img');
                const hasImage = img !== null;
                let fullUrl = '';
                
                // Get text content by cloning and removing images
                const clone = link.cloneNode(true);
                const cloneImgs = clone.querySelectorAll('img');
                cloneImgs.forEach(img => img.remove());
                fullUrl = clone.textContent.trim();
                
                // Skip if already truncated or empty
                if (!fullUrl || fullUrl.endsWith('...')) return;
                
                // Get actual pixel width of the cell
                const cellWidth = cell.offsetWidth;
                const padding = 20; // Account for padding and margins
                const imageWidth = hasImage ? 25 : 0; // Space for copy icon
                const availableWidth = cellWidth - padding - imageWidth;
                
                // Create a temporary span to measure text width
                const measureSpan = document.createElement('span');
                measureSpan.style.visibility = 'hidden';
                measureSpan.style.position = 'absolute';
                measureSpan.style.whiteSpace = 'nowrap';
                measureSpan.style.fontSize = window.getComputedStyle(link).fontSize;
                measureSpan.style.fontFamily = window.getComputedStyle(link).fontFamily;
                measureSpan.style.fontWeight = window.getComputedStyle(link).fontWeight;
                document.body.appendChild(measureSpan);
                
                // Check if URL needs truncation
                measureSpan.textContent = fullUrl;
                const textWidth = measureSpan.offsetWidth;
                
                if (textWidth > availableWidth && availableWidth > 50) { // Minimum width check
                    // Binary search for the right truncation point
                    let left = 0;
                    let right = fullUrl.length;
                    let truncatedUrl = fullUrl;
                    
                    while (left < right) {
                        const mid = Math.floor((left + right) / 2);
                        const testUrl = fullUrl.substring(0, mid) + '...';
                        measureSpan.textContent = testUrl;
                        
                        if (measureSpan.offsetWidth <= availableWidth) {
                            truncatedUrl = testUrl;
                            left = mid + 1;
                        } else {
                            right = mid;
                        }
                    }
                    
                    // Update the link text, keeping full URL in href
                    if (hasImage) {
                        link.innerHTML = truncatedUrl + '<img src="/new-assets/assets/images/copy-link.png" alt="icon">';
                    } else {
                        link.textContent = truncatedUrl;
                    }
                    
                    // Store full URL in data attribute for reference
                    link.setAttribute('data-full-url', fullUrl);
                }
                
                // Clean up
                document.body.removeChild(measureSpan);
            });
        }, 150); // Small delay to ensure layout is complete
    }
    
    /**
     * Calculate column widths based on visible columns count and types
     * @param {Number} visibleCount - Number of visible columns
     * @param {Array} columnTypes - Array of column type identifiers
     * @param {String} tableType - Type of table
     * @returns {Array} Array of width percentages
     */
    function calculateColumnWidths(visibleCount, columnTypes, tableType) {
        const widths = [];

        if (tableType === 'lighthouse' || tableType === 'core') {
            const hasRow = columnTypes.includes('rowNumber');
            const hasUrl = columnTypes.includes('url');
            const hasResult = columnTypes.includes('result');
            const metricCount = columnTypes.filter(type => type === 'metric').length;

            const fixedRow = hasRow ? 3 : 0;
            const fixedUrl = hasUrl ? 30 : 0;
            const fixedResult = hasResult ? 10 : 0;

            let remaining = 100 - fixedRow - fixedUrl - fixedResult;
            if (remaining < 0) remaining = 0;

            const metricBase = metricCount > 0 ? Math.floor(remaining / metricCount) : 0;
            let remainder = metricCount > 0 ? remaining - metricBase * metricCount : 0;

            columnTypes.forEach((type) => {
                if (type === 'rowNumber') {
                    widths.push(fixedRow);
                } else if (type === 'url') {
                    widths.push(fixedUrl);
                } else if (type === 'result') {
                    widths.push(fixedResult);
                } else if (type === 'metric') {
                    const width = metricBase + (remainder > 0 ? 1 : 0);
                    if (remainder > 0) remainder -= 1;
                    widths.push(width);
                } else {
                    widths.push(0);
                }
            });

            return widths;
        }

        function getWidthRules(type) {
            const fixed = {
                rowNumber: 3,
                comparison: 11,
                casing: 15
            };

            switch (type) {
                case 'url':
                    return {
                        fixed,
                        weights: {
                            url: 50,
                            content: 30,
                            slug: 30,
                            length: 10,
                            result: 10,
                            default: 10
                        }
                    };
                case 'headings':
                    return {
                        fixed,
                        weights: {
                            heading: 15,
                            quantity: 10,
                            content: 30,
                            result: 10,
                            default: 10
                        }
                    };
                case 'og':
                    return {
                        fixed,
                        weights: {
                            // Make URL column 10% narrower and content 10% wider
                            url: 40,
                            content: 40,
                            length: 10,
                            result: 10,
                            default: 10
                        }
                    };
                case 'twitter':
                    return {
                        fixed,
                        weights: {
                            url: 40,
                            content: 40,
                            length: 10,
                            result: 10,
                            default: 10
                        }
                    };
                case 'lighthouse':
                    return {
                        fixed,
                        weights: {
                            url: 20,
                            metric: 8,
                            result: 12,
                            default: 10
                        }
                    };
                case 'core':
                    return {
                        fixed,
                        weights: {
                            url: 20,
                            metric: 8,
                            result: 12,
                            default: 10
                        }
                    };
                case 'title':
                default:
                    return {
                        fixed,
                        weights: {
                            url: 50,
                            content: 30,
                            length: 10,
                            result: 10,
                            default: 10
                        }
                    };
            }
        }

        const rules = getWidthRules(tableType);
        const fixed = rules.fixed;
        const weights = rules.weights;
        const FIXED_COMPARISON_WIDTH = fixed.comparison;
        const FIXED_CASING_WIDTH = fixed.casing;
        const FIXED_ROW_NUMBER_WIDTH = fixed.rowNumber;

        // Calculate total fixed width
        let totalFixedWidth = FIXED_ROW_NUMBER_WIDTH; // Always include row number
        const hasComparison = columnTypes.includes('comparison');
        const hasCasing = columnTypes.includes('casing');
        
        if (hasComparison) {
            totalFixedWidth += FIXED_COMPARISON_WIDTH;
        }
        if (hasCasing) {
            totalFixedWidth += FIXED_CASING_WIDTH;
        }
        
        // Remaining width to distribute among other columns
        const remainingWidth = 100 - totalFixedWidth;
        
        // Count flexible columns (columns that need dynamic width)
        const flexibleColumns = columnTypes.filter(type => 
            type !== 'rowNumber' && 
            type !== 'comparison' && 
            type !== 'casing'
        );
        const flexibleCount = flexibleColumns.length;
        
        // Calculate proportional widths for flexible columns
        if (flexibleCount > 0) {
            const baseWidths = {};
            Object.keys(weights).forEach(key => {
                baseWidths[key] = 0;
            });
            
            // Calculate total weight
            let totalWeight = 0;
            flexibleColumns.forEach(type => {
                totalWeight += weights[type] || weights.default;
            });
            
            // Assign proportional widths
            flexibleColumns.forEach(type => {
                const weight = weights[type] || weights.default;
                baseWidths[type] = Math.round((remainingWidth * weight) / totalWeight);
            });
            
            // Adjust for rounding errors
            const assignedWidth = Object.values(baseWidths).reduce((sum, w) => sum + w, 0);
            const adjustment = remainingWidth - assignedWidth;
            if (adjustment !== 0 && flexibleColumns.length > 0) {
                // Add adjustment to URL column (highest priority)
                const urlIndex = flexibleColumns.indexOf('url');
                if (urlIndex !== -1) {
                    baseWidths.url += adjustment;
                } else {
                    // If no URL, add to first flexible column
                    baseWidths[flexibleColumns[0]] += adjustment;
                }
            }
            // Build final widths array in column order
            columnTypes.forEach((type) => {
                if (type === 'rowNumber') {
                    widths.push(FIXED_ROW_NUMBER_WIDTH);
                } else if (type === 'comparison') {
                    widths.push(FIXED_COMPARISON_WIDTH);
                } else if (type === 'casing') {
                    widths.push(FIXED_CASING_WIDTH);
                } else {
                    widths.push(baseWidths[type] || Math.floor(remainingWidth / flexibleCount));
                }
            });
        } else {
            // No flexible columns, only fixed widths
            columnTypes.forEach((type) => {
                if (type === 'rowNumber') {
                    widths.push(FIXED_ROW_NUMBER_WIDTH);
                } else if (type === 'comparison') {
                    widths.push(FIXED_COMPARISON_WIDTH);
                } else if (type === 'casing') {
                    widths.push(FIXED_CASING_WIDTH);
                } else {
                    widths.push(0);
                }
            });
        }
        
        // Final normalization to ensure sum is exactly 100%
        const total = widths.reduce((sum, w) => sum + w, 0);
        if (total !== 100 && widths.length > 0) {
            const adjustment = 100 - total;
            // Adjust the URL column if it exists, otherwise adjust the last column
            const urlIndex = columnTypes.indexOf('url');
            if (urlIndex !== -1 && urlIndex < widths.length) {
                widths[urlIndex] += adjustment;
            } else {
                widths[widths.length - 1] += adjustment;
            }
        }
        
        return widths;
    }
    
})

$(document).on("click",".download-xlsx-bulk",function() {
    let xlsxName = $(this).attr('data-csv') + '.xlsx';
    ToolXlsx.buildXLSX(xlsxName);
});