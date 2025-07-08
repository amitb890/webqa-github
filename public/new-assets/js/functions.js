// Alert Manager - Unified alert system for the frontend
class AlertManager {
    static types = {
        SUCCESS: 'success',
        ERROR: 'error', 
        WARNING: 'warning',
        INFO: 'info',
        CUSTOM: 'custom'
    };

    static positions = {
        TOP: 'top',
        BOTTOM: 'bottom',
        AFTER: 'after',
        BEFORE: 'before',
        REPLACE: 'replace'
    };

    static defaultConfig = {
        type: this.types.INFO,
        position: this.positions.TOP,
        autoHide: true,
        duration: 3000,
        dismissible: true,
        prepend: true
    };

    /**
     * Show an alert with unified configuration
     * @param {string|HTMLElement} target - CSS selector or DOM element
     * @param {string} message - Alert message
     * @param {Object} config - Configuration options
     */
    static show(target, message, config = {}) {
        const finalConfig = { ...this.defaultConfig, ...config };
        const targetElement = typeof target === 'string' ? document.querySelector(target) : target;
        
        if (!targetElement) {
            console.error('AlertManager: Target element not found', target);
            return;
        }

        const alertElement = this.createAlertElement(message, finalConfig);
        this.positionAlert(targetElement, alertElement, finalConfig);
        
        if (finalConfig.autoHide) {
            this.autoHide(alertElement, finalConfig.duration);
        }

        return alertElement;
    }

    /**
     * Create alert element with proper styling
     */
    static createAlertElement(message, config) {
        const alertElement = document.createElement('div');
        alertElement.setAttribute('role', 'alert');
        
        // Base classes
        const baseClasses = ['alert', 'webqa__alert', 'alert-dismissible', 'fade', 'show'];
        
        // Type-specific classes
        const typeClasses = {
            [this.types.SUCCESS]: ['alert-success'],
            [this.types.ERROR]: ['alert-danger'],
            [this.types.WARNING]: ['alert-warning'],
            [this.types.INFO]: ['alert-info'],
            [this.types.CUSTOM]: ['alert-custom']
        };

        alertElement.classList.add(...baseClasses, ...typeClasses[config.type]);

        // Build content
        let content = message;
        if (config.dismissible) {
            content += `
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
        }

        alertElement.innerHTML = content;
        return alertElement;
    }

    /**
     * Position alert relative to target element
     */
    static positionAlert(targetElement, alertElement, config) {
        
        switch (config.position) {
            case this.positions.TOP:
                if (config.prepend) {
                    targetElement.insertBefore(alertElement, targetElement.firstChild);
                } else {
                    targetElement.appendChild(alertElement);
                }
                break;
            case this.positions.BOTTOM:
                targetElement.appendChild(alertElement);
                break;
            case this.positions.AFTER:
                targetElement.parentNode.insertBefore(alertElement, targetElement.nextSibling);
                break;
            case this.positions.BEFORE:
                targetElement.parentNode.insertBefore(alertElement, targetElement);
                break;
            case this.positions.REPLACE:
                targetElement.innerHTML = '';
                targetElement.appendChild(alertElement);
                break;
        }
    }

    /**
     * Auto-hide alert after specified duration
     */
    static autoHide(alertElement, duration) {
        setTimeout(() => {
            if (alertElement && alertElement.parentNode) {
                $(alertElement).fadeTo(500, 500).slideUp(500, function() {
                    $(this).remove();
                });
            }
        }, duration);
    }

    /**
     * Clear all alerts from a target
     */
    static clear(target) {
        const targetElement = typeof target === 'string' ? document.querySelector(target) : target;
        if (targetElement) {
            const alerts = targetElement.querySelectorAll('.alert');
            alerts.forEach(alert => alert.remove());
        }
    }

    /**
     * Convenience methods for common alert types
     */
    static success(target, message, config = {}) {
        return this.show(target, message, { ...config, type: this.types.SUCCESS });
    }

    static error(target, message, config = {}) {
        return this.show(target, message, { ...config, type: this.types.ERROR });
    }

    static warning(target, message, config = {}) {
        return this.show(target, message, { ...config, type: this.types.WARNING });
    }

    static info(target, message, config = {}) {
        return this.show(target, message, { ...config, type: this.types.INFO });
    }

    static custom(target, message, config = {}) {
        return this.show(target, message, { ...config, type: this.types.CUSTOM });
    }

    /**
     * Show alert after an element (useful for form validation)
     */
    static afterElement(element, message, config = {}) {
        return this.show(element, message, { ...config, position: this.positions.AFTER });
    }

    /**
     * Show alert before an element
     */
    static beforeElement(element, message, config = {}) {
        return this.show(element, message, { ...config, position: this.positions.BEFORE });
    }
}

class rememberUrl {
    constructor(message, onDelete) {
        this.message = message;
        this.onDelete = onDelete;
    }

    display() {
        cleanToast()
        const element = this.buildAlertDelete();
        document.body.appendChild(element);
        if(this.onDelete == true) {
            $('.toast').toast({ autohide: false });
        }
        $('.toast').toast('show');
        $('#backgroundBackdrop').fadeIn(); // Show the backdrop
    }

    buildAlertDelete() {
        const div = document.createElement("div");
        div.classList.add("toast");
        div.classList.add("rememberUrl");
        div.setAttribute("role", "alert");
        div.setAttribute("aria-live", "assertive");
        div.setAttribute("aria-atomic", "true");

        
if(this.onDelete == true) {
        div.innerHTML = `
          <div class="toast-header">
            <strong class="mr-auto">The URL does not belongs to any of your projects,
            <br>
            General settings will apply
            </strong>
            <button type="button" class="ml-auto mb-1 close toastClose" data-dismiss="toast" aria-label="Close" style="border: 0;
                color: #6E6E6E;
                background-color: #fff;
                font-size: 1.5em; /* Increase font size */
                padding-left: 30%; /* Adjust padding */
                ">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body" style="    border-bottom: var(--bs-toast-border-width) solid var(--bs-toast-header-border-color);
        border-top-left-radius: calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));
        border-top-right-radius: calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));">
       <span style="    display: inline-block;
       width: 50%;">
        <input
                        type="checkbox"
                         id="rememberURLCheckbox" name=""
                      /> Don't show this again</span>
        <button type="button" class="btn btn_primary rounded-pill" id="iUnderstand">I Understand</button>
        </div>
            <div class="toast-footer" style="margin: 10px; text-align: right;">
                if you want to customize the settings for this URL, please create a project first.
            </div>
           `;
       
        
        // Add click event listener to the close button
        const closeButton = div.querySelector('.close'); 
        } else {
                div.innerHTML = `
                <div class="toast-body">${this.message}</div>`
        }
        return div;
    }
}


$(document).on("click",".toastClose",function() {
    $('#backgroundBackdrop').fadeOut(); // Hide the backdrop
});

class Toast{
   
    constructor(message){
        this.message = message
        cleanToast()
    }

   
    display() {
        const element = this.buildAlert();
        document.body.appendChild(element);
        this.toastElement = element;

        // Initialize the toast without interaction pausing
        $(element).toast({
            autohide: false // Prevent Bootstrap's built-in auto-hide to manage manually
        });

        $(element).toast("show");

        // Force auto-hide after 5 seconds regardless of interaction
        setTimeout(() => {
            this.forceHide(element);
        }, 5000); // Adjust the delay (5000ms = 5 seconds) as needed
        $(element).on("hidden.bs.toast", function () {
            $(this).removeAttr("style");
        });
    }

    forceHide(element) {
        if (element) {
            $(element).toast("hide");
            element.addEventListener("hidden.bs.toast", () => {
                element.remove(); // Clean up after hiding
            });
        }
    }

    buildAlert(){
        const div = document.createElement("div")
        div.classList.add("toast")
        div.setAttribute("role", "alert")
        div.setAttribute("aria-live", "assertive")
        div.setAttribute("aria-atomic", "true")
        div.innerHTML = `
        <div class="toast-body">${this.message}</div>`
        return div
    }
}
// Action on toast hidden

class ToastDelete {
    constructor(message, onDelete) {
        this.message = message;
        this.onDelete = onDelete;
    }

    display() {
        cleanToast()
        const element = this.buildAlertDelete();
        document.body.appendChild(element);
        if(this.onDelete == true) {
            $('.toast').toast({ autohide: false });
        }
        $('.toast').toast('show');
    }

    buildAlertDelete() {
        const div = document.createElement("div");
        div.classList.add("toast");
        div.classList.add("toastDelete");
        div.setAttribute("role", "alert");
        div.setAttribute("aria-live", "assertive");
        div.setAttribute("aria-atomic", "true");

        
if(this.onDelete == true) {
        div.innerHTML = `
          <div class="toast-header">
            <strong class="mr-auto">Are you sure?</strong>
            <button type="button" class="ml-auto mb-1 close toastClose" data-dismiss="toast" aria-label="Close" style="border: 0;
                color: #6E6E6E;
                background-color: #fff;
                font-size: 1.5em; /* Increase font size */
                padding-left: 370px; /* Adjust padding */
                ">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body" style="    border-bottom: var(--bs-toast-border-width) solid var(--bs-toast-header-border-color);
        border-top-left-radius: calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));
        border-top-right-radius: calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));">
         ${this.message}
        </div>
            <div class="toast-footer" style="margin: 10px; text-align: right;">
                <button type="button" class="btn btn_primary rounded-pill toastClose" style="background-color: white; color: #6E6E6E;">Cancel</button>
                <button type="button" class="btn btn_primary rounded-pill deleteProjectToast">Yes</button>
            </div>
           `;
       
        
        // Add click event listener to the close button
        const closeButton = div.querySelector('.close'); 
        } else {
                div.innerHTML = `
                <div class="toast-body">${this.message}</div>`
        }
        return div;
    }
}



class TableCSVExporter {
    constructor (table, fileName, includeHeaders = true) {
        this.table = table;
        $(this.table).find('tr.root-tr').remove();

        if ($('#report-slug').val()) {
            this.fileName = this.prepareCsvName($('#report-slug').val()) + '.csv';
        } else  {
            this.fileName = fileName;
        }
        this.rows = Array.from(table.querySelectorAll("tr"));

        if (!includeHeaders && this.rows[0].querySelectorAll("th").length) {
            this.rows.shift();
        }
    }

    convertToCSV () {
        const lines = [];
        const numCols = this._findLongestRowLength();

        for (const row of this.rows) {
            let line = "";

            for (let i = 0; i < numCols; i++) {
                if (row.children[i] !== undefined) {
                    line += TableCSVExporter.parseCell(row.children[i]);
                }

                line += (i !== (numCols - 1)) ? "," : "";
            }

            lines.push(line);
        }

        return lines.join("\n");
    }
    convertToCSVTracker() {
        const lines = [];
        const numCols = this._findLongestRowLength();
    
        for (const row of this.rows) {
            const cells = Array(numCols).fill(""); // Create an array to hold cell values
            let colIndex = 0;
    
            for (const cell of row.children) {
                // Find the first empty position in cells array
                while (cells[colIndex] !== "") colIndex++;
    
                const colspan = parseInt(cell.getAttribute("colspan"), 10) || 1;
    
                // Add the cell content to the array and repeat for colspan
                cells[colIndex] = TableCSVExporter.parseCell(cell);
    
                // Skip the next columns if colspan > 1
                colIndex += colspan;
            }
    
            // Join the array into a CSV line
            lines.push(cells.join(","));
        }
    
        return lines.join("\n");
    }
    
    
 
    _findLongestRowLength() {
        return this.rows.reduce((l, row) => row.childElementCount > l ? row.childElementCount : l, 0);
    }

    
    static parseCell(tableCell) {
        let parsedValue = tableCell.getAttribute("td-replace") || tableCell.textContent.trim(); 
    
        // Replace all double quotes with two double quotes
        parsedValue = parsedValue.replace(/"/g, `""`);
    
        // Always enclose values in double quotes if they contain a comma, new-line, or double-quote
        if (/[",\n]/.test(parsedValue) || parsedValue.includes("http")) {
            parsedValue = `"${parsedValue}"`;
        }
    
        return parsedValue;
    }
    
    


    getCsvLink(){
        let csvOutput; // Declare the variable outside the blocks

       if($('.website-tracker-csv').length){
            csvOutput = this.convertToCSVTracker();
        } else {
            csvOutput = this.convertToCSV();
        }
        const csvBlob = new Blob([csvOutput], { type: "text/csv" });
        const blobUrl = URL.createObjectURL(csvBlob);
        return blobUrl;
    }
      
    downloadCSV(){
        const blobUrl = this.getCsvLink()
        const anchorElement = document.createElement("a");
        anchorElement.href = blobUrl;
        anchorElement.download = this.fileName;
        anchorElement.click();
        setTimeout(() => {
            URL.revokeObjectURL(blobUrl);
        }, 500);
    }
    prepareCsvName(slug) {
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
}



function showValidationPopup(text){
    $('.validationPopup').show()                      
    $('.validationPopupText').html(text)
    $("#urlValue").addClass("invalid")
    
    setTimeout(function() {
        $(".validationPopup").hide();
        $("#urlValue").removeClass("invalid")
    }, 3000);
}


function cleanToast() {
    $('.toast').remove()
    $('.toastDelete').remove()
}

function buildAlertNew(txt){
    const span = document.createElement("div")
    span.innerHTML = txt
    span.classList.add("invalid-feedback")
    span.style.display = "block"
    return span
}

function buildAlertNewSuccess(txt){
    const span = document.createElement("div")
    span.innerHTML = txt
    span.classList.add("success-feedback")
    span.style.display = "block"
    return span
}

function clearAlerts(){
    $(`.alert`).remove()
    $(`.invalid-feedback`).remove()
}

function clearAlertsNew(){
    $(`.alert`).remove()
    $(`.invalid-feedback`).remove()
  }

function scrollToTop(){
    $('html,body').animate({ scrollTop: 0 }, 'fast');
}

function scrollToSection(element){
    $('html,body').animate({ scrollTop: $(element).offset().top - 100 }, 'fast');
}

function clearValues(inputs){
    inputs.forEach(el=>{
        $(el).val("")
    })
}

function getParam(url, s){
    var url_string = url
    var url = new URL(url_string);
    var c = url.searchParams.get(s);
    return c
}

function isInt(value) {
    var er = /^-?[0-9]+$/;
    return er.test(value);
}

function isStringBoolean(){
    if(value == "on" || value == "off"){
        
    }
}

function getSettingsVal(inputs){
    let obj1 = {}
    const elementArray = ["excludedWordsCasingVal", "UrlStopWordsVal", "excluded_words"]
    inputs.forEach(el=>{
        let val
        if(elementArray.includes(el.id)){
            val = el.value
            val = val.split(",")
            val = trimArray(val)
            val = removeDuplicates(val)
            val = val.toString()

            el.value = val
            el.innerHTML = val
        }else{
            val = parseInt(el.value)

            if($(el).attr("type") === "checkbox"){
                val = el.checked
    
                if(val === "on" || val == "1" || val == true && val != ""){
                    val = 1
                }else if(val === "off" || val == "0" || val == false && val != ""){
                    val = 0
                }
            }
        }

        obj1[el.id] = val
    })    

    return {
        settings_sub: obj1
    }
}

function getReportProgress(n, t, p){
    let ans
    if(p){
        n === 0 || t === 0 ? ans = "0%" : ans = ((n/t) * 100) + "%"
    }else{
        n === 0 || t === 0 ? ans = 0 : ans = ((n/t) * 100)
    }
    return ans
}

function getLoaderElement(status){
    const loaderImage = getLoaderImage()

    const div = document.createElement("div")
    div.classList.add("card-body")
    div.innerHTML = `
        <div class="row">
        <div class="col-md-12">
            <div class="loader-card-title">
            <div class="loader-img">
                ${loaderImage}
            </div>
            <div class="loader-title-single">
                <h2>We are running your test, please wait...</h2>
            </div>
            <p id="loader_url"></p>

            <div class="loader-progress">
                <div class="progress">
                <div
                    class="progress-bar progress-bar_primary loader-progress-range"
                    role="progressbar"
                    aria-label="Example with label"
                    style="width: 0%"
                    aria-valuenow="60"
                    title=""
                    aria-valuemin="0"
                    aria-valuemax="100"
                ></div>
                </div>
                <div class="loader-checking">
                <span id="loader_test_current"></span>
                <span class="loader-bold-span"></span>
                </div>
            </div>
            <!-- Loader Progress Start -->
            <div class="progress-loader mt-2" style="display:none">
                <div
                class="progress-items d-flex justify-content-center"
                >
                <div class="single-progress">
                    <span class="circular-progress progress-red">
                    <svg
                        id="failedProgress"
                        viewBox="0 0 100 100"
                        xmlns="http://www.w3.org/2000/svg"
                        preserveAspectRatio="none"
                        data-value="8"
                        class="svg-circle"
                    >
                        <circle r="45" cx="50" cy="50" />
                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                        <path
                        class="meter"
                        d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-dashoffset="282.78302001953125"
                        stroke-dasharray="282.78302001953125"
                        />
                        <!-- Value automatically updates based on data-value set above -->
                        <text
                        x="50"
                        y="50"
                        text-anchor="middle"
                        dominant-baseline="central"
                        font-size="24"
                        id="failedProgressText"
                        ></text>
                    </svg>
                    </span>
                    <span>Failed</span>
                </div>
                <div class="single-progress">
                    <span class="circular-progress progress-green">
                    <svg
                    id="passedProgress"
                        viewBox="0 0 100 100"
                        xmlns="http://www.w3.org/2000/svg"
                        preserveAspectRatio="none"
                        data-value="80"
                        class="svg-circle"
                    >
                        <circle r="45" cx="50" cy="50" />
                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                        <path
                        class="meter"
                        d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-dashoffset="282.78302001953125"
                        stroke-dasharray="282.78302001953125"
                        />
                        <!-- Value automatically updates based on data-value set above -->
                        <text
                        x="50"
                        y="50"
                        text-anchor="middle"
                        dominant-baseline="central"
                        font-size="24"
                        id="passedProgressText"
                        ></text>
                    </svg>
                    </span>
                    <span>Passed</span>
                </div>
                </div>
            </div>
            <!-- Loader Progress End -->

            ${status ? `
            <div class="loader-details show-details-btn">
                <button type="button">
                Show Details
                <i class="fa-solid fa-angle-down"></i>
                </button>
            </div>` : ""}
            
            </div>
        </div>
        </div>
        <!-- loader list item -->
        <div id="loaderMetadata" class="loader-list-toggle">
        <div class="loader-list-items">
            <h4>Completed Tests <span id="completedTests"></span>/<span id="totalTests"></span></h4>
        </div>
        </div>`;
        return div;
}

function validateFrontFooter(data, type){
    const value = data.el.value.trim()
    if(value === ""){
        const alert = buildAlertNew(data.msgEmpty)
        data.el.parentElement.parentElement.parentElement.querySelector(".search-setting-container").prepend(alert)
        return false
    }else if(!isValidURL(value)){
        let msgInvalid = `${value} is an incorrect URL format, please enter the URL in the correct format and try again.`
        const alert = buildAlertNew(msgInvalid)
        data.el.parentElement.parentElement.parentElement.querySelector(".search-setting-container").prepend(alert)
        return false
    }

    return true
}


function validateFront(data, type){
    let state = true, customizerState = true, checkedBoxes
    if(type === "bulk"){
        checkedBoxes = document.querySelectorAll('.bulk-test-criteria [type=checkbox]:checked');
    }else if(type === "analysis"){
        checkedBoxes = document.querySelectorAll('.form-check input[type=checkbox]:checked');
    }else{
        checkedBoxes = document.querySelectorAll('.check-box input[type=checkbox]:checked');

    }
    const value = data.el.value.trim()
    if(value === ""){
        const alert = buildAlertNew(data.msgEmpty)
        data.el.parentElement.parentElement.parentElement.querySelector(".search-setting-container").prepend(alert)
        return false
    }

    if(type === "bulk"){
        if(checkedBoxes.length < 1){
            const alert = buildAlertNew("At least one test criteria must be selected.")
            data.el.parentElement.parentElement.parentElement.querySelector(".search-setting-container").prepend(alert)
            return false
        }
        var list = value.split("\n")
        for(var i = 0;i < list.length; i++){
            var domain = constructTestURL(list[i])
            if(!isValidURL(domain)){
                let msgInvalid = `${domain} is an incorrect URL format, please enter the URL in the correct format and try again.`
                const alert = buildAlertNew(msgInvalid)
                data.el.parentElement.parentElement.parentElement.querySelector(".search-setting-container").prepend(alert)
                return false
            }
        }
    }else{
        if(!isValidURL(value)){
            let msgInvalid = `${value} is an incorrect URL format, please enter the URL in the correct format and try again.`
            const alert = buildAlertNew(msgInvalid)
            data.el.parentElement.parentElement.parentElement.querySelector(".search-setting-container").prepend(alert)
            return false
        }
    }


    checkedBoxes.forEach(el=>{
        if(el.id === "is_excluded_words" || el.id === "url_stop_words" || el.id === "xml_sitemap_custom" || el.id === "html_sitemap_custom"){
            const newEl = el.parentElement.nextElementSibling.children[0]
            if(newEl.value === ""){
                const alert = buildAlertNew("You need to enter at least one word.")
                newEl.parentElement.appendChild(alert)
                state = false
                customizerState = false
            }
        }
        const inputs = el.parentElement.querySelectorAll(".input-inline")
        inputs.forEach(input=>{
            if(input.value === ""){
                const alert = buildAlertNew("Value can not be empty")
                input.parentElement.parentElement.appendChild(alert)
                state = false
                customizerState = false
            }


            if(state){
                // if(!isInt(input.value)){
                //     const alert = buildAlertNew("Value must be an integer")
                //     input.parentElement.parentElement.appendChild(alert)
                //     state = false
                //     customizerState = false
                // }

                // isInt(input.value) replaced with true

                if(true){
                    let max = 1000, min = 2
                    
                    if(input.parentElement.previousElementSibling.hasAttribute("google-check")){
                        max = 100
                    }
                    if(input.parentElement.previousElementSibling.hasAttribute("google-check-core")){
                        max = 10000
                        min = 0
                    }
                    if(input.parentElement.previousElementSibling.hasAttribute("image-check")){
                        max = 1000000
                    }
                    let val = parseFloat(input.value)
                    if(val > max){
                        const alert = buildAlertNew(`Value must be less than ${max}`)
                        input.parentElement.parentElement.appendChild(alert)
                        state = false
                        customizerState = false
                    }

                    if(val < min){
                        const alert = buildAlertNew("Value must be greater than or equal to 1")
                        input.parentElement.parentElement.appendChild(alert)
                        state = false
                        customizerState = false
                    }

                    if(input.parentElement.previousElementSibling.hasAttribute("min-value-check")){
                        const el = input.parentElement.parentElement.previousElementSibling.querySelector(".input-inline")
                        if(val > parseFloat(el.value)){
                            const alert = buildAlertNew("Minimum length can not be greater than maximum length")
                            input.parentElement.parentElement.appendChild(alert)
                            state = false
                            customizerState = false   
                        }
                    }
                }
            }
        })
    })

    if(!customizerState){
        const alert = buildAlertNew("There were some errors in the customizer, please fix them before continuing.")
        data.el.parentElement.parentElement.parentElement.querySelector(".search-setting-container").prepend(alert)
    }
    return state
}

function removeTrailingSlash(str) {
    return str.endsWith('/') ? str.slice(0, -1) : str;
}

function getSitemapAddress(type, address){
    if(isValidURL(address)){
        address = new URL(address).origin
        return type === "xml" ? address+"/sitemap.xml" : address+"/sitemap" 
    }
}

function displayAlertGlobal(data){
    alert(data.msg)
}   


function buildAlert(data){
    let className, msg
    msg = data.msg != undefined ? data.msg : data
    if(data.status == 1){
        className = ["alert", "webqa__alert", "alert-success", "alert-dismissible", "fade", "show"]
    }else if(data.status == 3){
        className = ["alert", "webqa__alert", "alert-custom", "alert-dismissible", "fade", "show"]
    }else{
        className = ["alert", "webqa__alert", "alert-danger", "alert-dismissible", "fade", "show"]
    }
    const div = document.createElement("div")
    div.setAttribute("role", "alert")
    className.forEach(val=>{
        div.classList.add(val)
    })
    div.innerHTML = 
    `${msg}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    return div
}

function displayAlert(classVal, data){
    const div = buildAlert(data)
    $(`${classVal}`)[0].prepend(div)
    if(!data.notHide){
        $(".alert").fadeTo(3000, 500).slideUp(500, function() {
            $(".alert").slideUp(500);
            $(".alert").remove();
        });
    }
}

function toggleHomePageSettingsArea(){
    $("#settingBtn").toggleClass("active");
    $(".home-setting-area").slideToggle();
}

function displayAlertSimple(classVal, data, prependStatus){
    const div = buildAlertNew(data.msg)
    if(prependStatus){
        $(`${classVal}`)[0].prepend(div)
    }else{
        $(`${classVal}`)[0].appendChild(div)
    }
}

function displayAlertSimpleSuccess(classVal, data, prependStatus){
    const div = buildAlertNewSuccess(data.msg)
    if(prependStatus){
        $(`${classVal}`)[0].prepend(div)
    }else{
        $(`${classVal}`)[0].appendChild(div)
    }
}


function getActiveProjectId(){
   return parseInt(getStringPart(document.querySelector("#activeProject").getAttribute("data-val"), "-", 1))
}

function getActiveProjectName(){
    return document.querySelector("#activeProject").getAttribute("data-name")
 }


function hasNumber(myString) {
    return /\d/.test(myString);
}

function hasSpecialCharacters(str){
    var format = /[!@#$%^&*()_+\=\[\]{};:"\\|,.<>\+?]+/;
    if(format.test(str)){
        return true;
    }else{
        return false;
    }
}

function hasAlphabets(str){
    var format = /[a-zA-Z]/g;            
    if(format.test(str)){
        return true;
    } else {
        return false;
    }
}

function hasSpecialCharacters2(str){
    var format = /[@#$%^&*()_+\=\[\]{};"\\<>\+]+/;
    if(format.test(str)){
        return true;
    }else{
        return false;
    }
}

function hasSpecialCharacters3(str){
    var format = /[!@#$%^&*()_+\=\[\]{};:"\\<>\/?]+/;
    if(format.test(str)){
        return true;
    }else{
        return false;
    }
}


function hasUppercaseCase(str) {
    return (/[A-Z]/.test(str));
}


function isValidURL(str) {
    var count = (str.match(/http/g) || []).length;
    if(count > 1){
        return false
    }
    return (/(http|https):\/\/[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&=]*)/i.test(str));
}

// data array (takes the brandname argument and splits it to words, splits first by "," and then by " ")
var data = Array()
data.push(".","|",":","-","&"," ","+", ",")

function isCamelCase(str, brandname){
    let ans;
   var newStr = str.split(" ")

   var brandnameCommaSeparatedArray = brandname.split(",")

   brandnameCommaSeparatedArray.forEach(str=>{
        var newStr = str.split(" ")
        newStr.forEach(str=>{
            data.push(str)
        })
    })  

   
   for (let i = 0; i < newStr.length; i++) {
    const element = newStr[i];
       if(!hasNumber(element) && !data.includes(element)){
        var first = element.charAt(0)   
            if(!hasUppercaseCase(first)){
                ans = false;
                break;
            }else{
                if(hasSpecialCharacters2(element)){
                    ans = false;
                    break;
                }else{
                    var finalStr = element.substr(1, element.length)
                    if(hasUppercaseCase(finalStr)){
                        ans = false
                        break
                    }else{
                        ans = true
                    }
                }
            }
        }
   }
   return ans;
}



function isSentenceCase(str, brandname){
    let ans;
   var newStr = str.split(" ")
    var brandnameCommaSeparatedArray = brandname.split(",")

    brandnameCommaSeparatedArray.forEach(str=>{
        var newStr = str.split(" ")
        newStr.forEach(str=>{
            data.push(str)
        })
    }) 

   for (let i = 0; i < newStr.length; i++) {
    const element = newStr[i];
       if(!hasNumber(element) && !data.includes(element)){;
            var first = element.charAt(0)   
            if(i === 0){
                if(!hasUppercaseCase(first)){
                    ans = false;
                    break;
                }
            }else{
                if(hasSpecialCharacters2(element)){
                    ans = false;
                    break;
                }else{
                    if(hasUppercaseCase(element)){
                        ans = false
                        break
                    }else{
                        ans = true
                    }
                }
            }
        }
   }
   return ans;
}


function isSingleWord(str){
    if(str.split("-").length > 1){
        return false;
    }
    if(str.split("_").length > 1){
        return false;
    }
    if(str.split(" ").length > 1){
        return false;
    }
    if(str.split("/").length > 1){
        return false;
    }
    return true
}







// show-details-btn
 function showLoaderDetailsToggle(){
    $(".show-details-btn").click(function () {
      $(".loader-list-toggle").slideToggle(300);
      $("body, html").animate(
        { scrollTop: $(this).offset().top - $("#headerMain").height() },
        300
      );
    });
  }


  function updateSliders(){
    if (typeof $().slider !== "undefined") {
      document.querySelectorAll(".slider-input").forEach(el=>{
        const val = el.getAttribute("data-slider-value")
        const minVal = el.getAttribute("data-slider-min")
        const maxVal = el.getAttribute("data-slider-max")
        const step = el.getAttribute("data-slider-step")
        const sliderId = el.getAttribute("data-slider-id")

        $(el).slider({
          id: sliderId,
          min: minVal,
          max: maxVal,
          step: step,
          value: val,
          rangeHighlights: [
            { start: 2, end: 5, class: "category1" },
            { start: 7, end: 8, class: "category2" },
            { start: 17, end: 19 },
            { start: 17, end: 24 },
            { start: -3, end: 19 },
          ],
        });
      })
      // Setting page end
    }
  }

    // circular progress bar
    function updateCircularProgress(){
        // Get all the Meters
        const meters = document.querySelectorAll("svg[data-value] .meter");
    
        if (!meters.length) return;
    
        meters.forEach((path) => {
          // Get the length of the path
          let length = path.getTotalLength();
          // Get the value of the meter
          let value = parseInt(path.parentNode.getAttribute("data-value"));
          let textValue = path.parentNode.getAttribute("data-text");
          textValue = textValue != null ? textValue : value
          // Calculate the percentage of the total length
          let to = length * ((100 - value) / 100);
          // Trigger Layout in Safari hack https://jakearchibald.com/2013/animated-line-drawing-svg/
          path.getBoundingClientRect();
          // Set the Offset
          path.style.strokeDashoffset = Math.max(0, to);
          path.nextElementSibling.textContent = `${textValue}`;
        });
      }


      function guidGenerator() {
        // var S4 = function() {
        //    return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
        // };
        // return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
        return Date.now()
    }

function validate(data){
    if(data.status === 0){
        for (const key in data.msg) {
            const msg = data.msg[key][0]
            const alert = buildAlertNew(msg)
            if($(`#${key}`)[0] || $(`.${key}`)[0]){
                if($(`#${key}`)[0]){
                    $(`#${key}`)[0].parentElement.appendChild(alert)
                }
                if($(`.${key}`)[0]){
                        $(`.${key}`)[0].parentElement.appendChild(alert)
                }
            }else{
              $(`[name=${key}]`)[0].parentElement.parentElement.prepend(alert)
            }
        }
    }
}

function trimArray(arr){
    return arr.map(element => {
        return element.trim();
    });
}

function removeDuplicates(a) {
    return a.filter(function(item, pos, ary) {
        return !pos || item != ary[pos - 1];
    });
}
  
function checkIfAuthenticated(data) {
    if(data.error){
        if(data.error === "Unauthenticated."){
            return 0;
        }
    }

    return 1;
}

function getAllValues(className){
    const inputs = document.querySelector(className).querySelectorAll("input,textarea,select")
    let obj = {}
    inputs.forEach(el=>{
        let val = el.value

        // building casing excluded values
        switch(el.id){
            case "excludedWordsCasingVal":case "UrlStopWordsVal":
                val = val.split(",")
                val = trimArray(val)
                val = removeDuplicates(val)
                val = val.toString()

                el.value = val
                el.innerHTML = val
                break;
        }

        if($(el).attr("type") === "checkbox"){
            val = el.checked
        }
        if(val === "on" || val == "1" || val == true && val != ""){
            val = 1
        }else if(val === "off" || val == "0" || val == false && val != ""){
            val = 0
        }
        obj[el.id] = val
    })
    return obj
}

function getStringPart(str, terminator, n) {
    // n = 0 | 1 (depending if you want first or second part after terminator)
    return str.split(terminator)[n];
}

function getTest(data, label){
    let checkReStatusTitle = true , checkReStatusDesc = true, checkReStatusOgTitle = true, checkReStatusTwitterTitle = true, checkReStatusOgDesc = true
    let meta, meta_desc
    let arr = []
    let arr2 = []
    let arr3 = []
    let arr4 = []
    let arr5 = []
    for(var i = 0;i < data.length; i++){
        const el = data[i]
        // converting name of the scarpped data to lowercase
        let name = el.name
        if(name){
            name = name.toLowerCase()
        }


        // if statement to make sure only the firt element is added (in case the title or any other tag repeats in the page)
            switch(name){
                case"title":
                if(checkReStatusTitle){ 
                    meta = el
                    checkReStatusTitle = false
                }
                break;
                case"description":
                if(checkReStatusDesc){ 
                    meta_desc = el
                    checkReStatusDesc = false
                }
                break;
                case"og:title":
                if(checkReStatusOgTitle){ 
                    el.metaContent = meta
                    checkReStatusOgTitle = false
                }
                break;
                case"twitter:title":
                if(checkReStatusTwitterTitle){ 
                    el.metaContent = meta
                    checkReStatusTwitterTitle = false
                }
                break;
                case"og:description":
                if(checkReStatusOgDesc){ 
                    el.metaContent = meta_desc
                    checkReStatusOgDesc = false
                }
                break;
            }


 

        if(label.name === "a" || label.name === "img" || label.name === "stylesheet" || label.name === "script" || label.name === "table"){
            if(name === "a"){
                arr.push(el)
            }else if(name === "img"){
                arr2.push(el)
            }else if(name === "stylesheet"){
                arr3.push(el)
            }else if(name === "script"){
                arr4.push(el)
            }else if(name === "table"){
                arr5.push(el)
            }
        }else{
            if(name === label.name){
                return el
            }
        }
    }
    

    if(label.name === "a"){
        return arr
    }

    if(label.name === "img"){
        return arr2
    }

    if(label.name === "stylesheet"){
        return arr3
    }
    
    if(label.name === "script"){
        return arr4
    }

    if(label.name === "table"){
        return arr5
    }
}

if($("#html_sitemap")[0]){
    $("#html_sitemap").on( "change", function(e) {
        if(e.target.checked){
            $("#html_sitemap_val").css({display: "block"})
        }else{
            $("#html_sitemap_val").css({display: "none"})
        }
    })
}

if($("#xml_sitemap")[0]){
    $("#xml_sitemap").on( "change", function(e) {
        if(e.target.checked){
            $("#xml_sitemap_val").css({display: "block"})
        }else{
            $("#xml_sitemap_val").css({display: "none"})
        }
    })
}

if($("#is_excluded_words")[0]){
    $("#is_excluded_words").on( "change", function(e) {
        if(e.target.checked){
            $("#excluded_words").css({display: "block"})
        }else{
            $("#excluded_words").css({display: "none"})
        }
    })
}

if($("#xml_sitemap_custom")[0]){
    $("#xml_sitemap_custom").on( "change", function(e) {
        if(e.target.checked){
            $("#xml_sitemap_val").css({display: "block"})
        }else{
            $("#xml_sitemap_val").css({display: "none"})
        }
    })
}

if($("#html_sitemap_custom")[0]){
    $("#html_sitemap_custom").on( "change", function(e) {
        if(e.target.checked){
            $("#html_sitemap_val").css({display: "block"})
        }else{
            $("#html_sitemap_val").css({display: "none"})
        }
    })
}

if($("#url_stop_words")[0]){
    $("#url_stop_words").on( "change", function(e) {
        if(e.target.checked){
            $("#url_stop_words_val").css({display: "block"})
        }else{
            $("#url_stop_words_val").css({display: "none"})
        }
    })
}


if($('input[has-disabled="true"]')[0]){
    $('input[has-disabled="true"]').on("change", (e)=>{
        const parent = e.target.parentElement.parentElement
        const els = parent.querySelectorAll(`input[has-disabled="true"]`)
        els.forEach(el=>{
            if(el.id != e.target.id){
                if(e.target.checked){
                    el.setAttribute("disabled", true)
                }else{
                    el.removeAttribute("disabled")
                }
            }
        })
    })
}


function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function getRandomInt(max) {
    return Math.floor(Math.random() * max);
}

  
function getLoaderImage(){
    const path = "/new-assets/assets/images/";
    const images = [
        "loader-img-1.gif",
        "loader-img-2.gif",
        "loader-img-3.gif",
        "loader-img-4.gif",
        "loader-img-5.gif",
        "loader-img-6.gif",
        "loader-img-7.gif",
        "loader-img-8.gif",
        "loader-img-9.gif",
        "loader-img-10.gif",
        "loader-img-11.gif",
        "loader-img-12.gif",
        "loader-img-13.gif",
        "loader-img-14.gif",
        "loader-img-15.gif",
    ];
    const index = getRandomInt(14);
    
    return `<img src="${path + images[index]}" class="img-fluid">`
}


function groupUrlsBySubfolder(urls) {
    const groupedUrls = {};

    urls.forEach((url, index) => {
        // Parse the URL to extract the path
        const urlObj = new URL(url);
        const path = urlObj.pathname.trim();
        const segments = path.split('/').filter(Boolean);


        // Determine the subfolder group
        const groupName = segments.length < 2 ? 'Root' : capitalize(segments[0]);
        const groupId = segments.length < 2 ? 'root' : segments[0].toLowerCase();

        // Initialize the group if not already present
        if (!groupedUrls[groupId]) {
            groupedUrls[groupId] = {
                name: groupName,
                id: groupId,
                urls: []
            };
        }

        // Add the URL along with its original index to the group
        groupedUrls[groupId].urls.push({ url, original_index: index });
    });

    // Convert the grouped URLs object into an array
    return Object.values(groupedUrls);
}

// Helper function to capitalize the first letter of a string
function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}



function getModalFixContent(testName){
    const data = [
        {
            headerTitle: "Meta Title Test",
            name: "Meta Title",
            video_url: "",
            contentHTML: `<h6>How to fix meta title for search results?</h6>
            <p>A meta title tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized meta titles</p>`
        },
        {
            headerTitle: "How to fix it 1?",
            name: "Og Title",
            video_url: "",
            contentHTML: `<h6>How to fix meta title for search results?</h6>
            <p>An og tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
            <ul>
            <li>All images have an Alternate text.</li>
            <li>All images have a file size lesser than 150KB</li>
            <li>All images have a proper file name.</li>
            </ul>

            <p><a href="javascript:void()">Learn more</a> on how to write optimized meta titles</p>`
        },
        
        {
            headerTitle: "Meta Description Test",
            name: "Meta Description",
            video_url: "",
            contentHTML: `<h6>How to fix meta description for search results?</h6>
            <p>A meta description tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized meta descriptions</p>`
        },

        {
            headerTitle: "Meta Description Test",
            name: "Meta Description",
            video_url: "",
            contentHTML: `<h6>How to fix meta description for search results?</h6>
            <p>A meta description tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized meta descriptions</p>`
        },

        {
            headerTitle: "Robots Meta",
            name: "Robots Meta Tag",
            video_url: "",
            contentHTML: `<h6>How to fix Robots Meta Tag for search results?</h6>
            <p>A Robots Meta Tag tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Robots Meta Tags</p>`
        },
        {
            headerTitle: "Canonical URL",
            name: "Canonical URL",
            video_url: "",
            contentHTML: `<h6>How to fix Canonical Tag for search results?</h6>
            <p>A Canonical Tag tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Canonical Tags</p>`
        },

        {
            headerTitle: "Images Test",
            name: "Images",
            video_url: "",
            contentHTML: `<h6>How to fix Images for search results?</h6>
            <p>A Images tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Images</p>`
        },

        {
            headerTitle: "URL Slug Test",
            name: "URL Slug",
            video_url: "",
            contentHTML: `<h6>How to fix URL Slug for search results?</h6>
            <p>A URL Slug tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized URL Slug</p>`
        },

        {
            headerTitle: "Robots.txt Test",
            name: "Robots.txt",
            video_url: "",
            contentHTML: `<h6>How to fix Robots.txt for search results?</h6>
            <p>A Robots.txt tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Robots.txt</p>`
        },

        {
            headerTitle: "Headings Test",
            name: "Headings",
            video_url: "",
            contentHTML: `<h6>How to fix Headings for search results?</h6>
            <p>A Headings tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Headings</p>`
        },

     
        {
            headerTitle: "XML Sitemap Test",
            name: "XML Sitemap",
            video_url: "",
            contentHTML: `<h6>How to fix XML Sitemap for search results?</h6>
            <p>A XML Sitemap tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized XML Sitemap</p>`
        },

    
        {
            headerTitle: "Twitter Tags Test",
            name: "Twitter Tags",
            video_url: "",
            contentHTML: `<h6>How to fix Twitter Tags for search results?</h6>
            <p>A Twitter Tags tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Twitter Tags</p>`
        },

        {
            headerTitle: "Favicon Test",
            name: "Favicon",
            video_url: "",
            contentHTML: `<h6>How to fix Favicon for search results?</h6>
            <p>A Favicon tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Favicon</p>`
        },

        {
            headerTitle: "Meta Viewport Test",
            name: "Meta Viewport",
            video_url: "",
            contentHTML: `<h6>How to fix Meta Viewport for search results?</h6>
            <p>A Meta Viewport tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Meta Viewport</p>`
        },

        {
            headerTitle: "Doctype Test",
            name: "Doctype",
            video_url: "",
            contentHTML: `<h6>How to fix Doctype for search results?</h6>
            <p>A Doctype tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Doctype</p>`
        },

        {
            headerTitle: "CSS Caching Test",
            name: "CSS Caching",
            video_url: "",
            contentHTML: `<h6>How to fix CSS Caching for search results?</h6>
            <p>A CSS Caching tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized CSS Caching</p>`
        },

        {
            headerTitle: "JS Caching Test",
            name: "JS Caching",
            video_url: "",
            contentHTML: `<h6>How to fix JS Caching for search results?</h6>
            <p>A JS Caching tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized JS Caching</p>`
        },

        {
            headerTitle: "Gzip Compression Test",
            name: "Gzip Compression",
            video_url: "",
            contentHTML: `<h6>How to fix Gzip Compression for search results?</h6>
            <p>A Gzip Compression tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Gzip Compression</p>`
        },

        {
            headerTitle: "HTML Compression Test",
            name: "HTML Compression",
            video_url: "",
            contentHTML: `<h6>How to fix HTML Compression for search results?</h6>
            <p>A HTML Compression tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized HTML Compression</p>`
        },

        {
            headerTitle: "CSS Compression Test",
            name: "CSS Compression",
            video_url: "",
            contentHTML: `<h6>How to fix CSS Compression for search results?</h6>
            <p>A CSS Compression tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized CSS Compression</p>`
        },

        {
            headerTitle: "JS Compression Test",
            name: "JS Compression",
            video_url: "",
            contentHTML: `<h6>How to fix JS Compression for search results?</h6>
            <p>A JS Compression tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized JS Compression</p>`
        },

        {
            headerTitle: "HTML Page Size Test",
            name: "HTML Page Size",
            video_url: "",
            contentHTML: `<h6>How to fix HTML Page Size for search results?</h6>
            <p>A HTML Page Size tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized HTML Page Size</p>`
        },

        {
            headerTitle: "Nested Tables Test",
            name: "Nested Tables",
            video_url: "",
            contentHTML: `<h6>How to fix Nested Tables for search results?</h6>
            <p>A Nested Tables tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Nested Tables</p>`
        },

        {
            headerTitle: "Frameset Test",
            name: "Frameset",
            video_url: "",
            contentHTML: `<h6>How to fix Frameset for search results?</h6>
            <p>A Frameset tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Frameset</p>`
        },

        {
            headerTitle: "Safe Browsing Test",
            name: "Safe Browsing",
            video_url: "",
            contentHTML: `<h6>How to fix Safe Browsing for search results?</h6>
            <p>A Safe Browsing tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Safe Browsing</p>`
        },

        {
            headerTitle: "Unsafe Cross Origin Links Test",
            name: "Unsafe Cross Origin Links",
            video_url: "",
            contentHTML: `<h6>How to fix Unsafe Cross Origin Links for search results?</h6>
            <p>A Unsafe Cross Origin Links tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Unsafe Cross Origin Links</p>`
        },

        {
            headerTitle: "Protocol Relative Resource Links Test",
            name: "Protocol Relative Resource Links",
            video_url: "",
            contentHTML: `<h6>How to fix Protocol Relative Resource Links for search results?</h6>
            <p>A Protocol Relative Resource Links tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Protocol Relative Resource Links</p>`
        },

        {
            headerTitle: "Content Security Policy Header Test",
            name: "Content Security Policy Header",
            video_url: "",
            contentHTML: `<h6>How to fix Content Security Policy Header for search results?</h6>
            <p>A Content Security Policy Header tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Content Security Policy Header</p>`
        },

        {
            headerTitle: "X Frame Options Header Test",
            name: "X Frame Options Header",
            video_url: "",
            contentHTML: `<h6>How to fix X Frame Options Header for search results?</h6>
            <p>A X Frame Options Header tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized X Frame Options Header</p>`
        },

        {
            headerTitle: "HSTS Header Test",
            name: "HSTS Header",
            video_url: "",
            contentHTML: `<h6>How to fix HSTS Header for search results?</h6>
            <p>A HSTS Header tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized HSTS Header</p>`
        },

        {
            headerTitle: "Bad content type Test",
            name: "Bad content type",
            video_url: "",
            contentHTML: `<h6>How to fix Bad content type for search results?</h6>
            <p>A Bad content type tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Bad content type</p>`
        },

        {
            headerTitle: "SSL Cetificate enable Test",
            name: "SSL Cetificate enable",
            video_url: "",
            contentHTML: `<h6>How to fix SSL Cetificate enable for search results?</h6>
            <p>A SSL Cetificate enable tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized SSL Cetificate enable</p>`
        },

        {
            headerTitle: "Directory Browsing Test",
            name: "Directory Browsing",
            video_url: "",
            contentHTML: `<h6>How to fix Directory Browsing for search results?</h6>
            <p>A Directory Browsing tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Directory Browsing</p>`
        },

        {
            headerTitle: "Google Page Speed Overall Score Test",
            name: "Google Page Speed Overall Score",
            video_url: "",
            contentHTML: `<h6>How to fix Google Page Speed Overall Score for search results?</h6>
            <p>A Google Page Speed Overall Score tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Google Page Speed Overall Score</p>`
        },

        {
            headerTitle: "Lighthouse Score Test",
            name: "Lighthouse Score",
            video_url: "",
            contentHTML: `<h6>How to fix Lighthouse Score for search results?</h6>
            <p>A Lighthouse Score tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Lighthouse Score</p>`
        },

        {
            headerTitle: "Core Web Vitals Test",
            name: "Core Web Vitals",
            video_url: "",
            contentHTML: `<h6>How to fix Core Web Vitals for search results?</h6>
            <p>A Core Web Vitals tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Core Web Vitals</p>`
        },

        {
            headerTitle: "Open Graph Tags Test",
            name: "Open Graph Tags",
            video_url: "",
            contentHTML: `<h6>How to fix Open Graph Tags for search results?</h6>
            <p>A Open Graph Tags tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Open Graph Tags</p>`
        },

        {
            headerTitle: "Twitter Tags Test",
            name: "Twitter Tags",
            video_url: "",
            contentHTML: `<h6>How to fix Twitter Tags for search results?</h6>
            <p>A Twitter Tags tag is an HTML element on a webpage that specifies the title of the page to search engines.</p>
           

            <p><a href="javascript:void()">Learn more</a> on how to write optimized Twitter Tags</p>`
        },



    ]
    for(var i = 0;i < data.length;i++){
        const el = data[i]
        if(el.name === testName){
            return el
        }
    }
}


function truncateString(str, num) {
    if (str.length <= num) {
      return str
    }
    return str.slice(0, num) + '...'
}



const validateEmail = (email) => {
    return String(email)
      .toLowerCase()
      .match(
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      );
};

function round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
}

const getRoundedNumber = (num) =>{
    const decimalPlaces = countDecimals(num)
    if(decimalPlaces > 2){
        return round(num, 2)
    }

    return num
}

const countDecimals = (value) => {
    if (Math.floor(value) === value) return 0;

    var str = value.toString();
    if (str.indexOf(".") !== -1 && str.indexOf("-") !== -1) {
        return str.split("-")[1] || 0;
    } else if (str.indexOf(".") !== -1) {
        return str.split(".")[1].length || 0;
    }
    return str.split("-")[1] || 0;
}

const getURLWithProtocol = (link) => {
    return (link.indexOf('://') === -1) ? 'http://' + link : link;
}

const constructTestURL = (link) => {
    link = getURLWithProtocol(link)
    return link
}

function updateEmailModal(projectUrl){
    $("#emailTo").val("")
    $("#emailSubject").val("")
    document.querySelector(".analysis-mail").innerHTML = ""
    const MESSAGE = `Hello,\n\nI recently did a webpage audit report.\nPlease find it attached.\n\nThanks`
    document.querySelector("#modalEmailMessage").innerHTML = MESSAGE
    document.querySelector("#modalEmailMessage").value = MESSAGE
    document.querySelector("#modalEmailFileName").innerHTML = "Marketing QA Tool Results.csv"
}

const runEmail = (TABLE) => {
    var emailModalSuggestionStatus = false;
    function validateModalEmail(emailValue){
        if(validateEmail(emailValue)){
          return true;
        }
    }

    function buildModalEmailBox(email){
        document.querySelector(".email-suggestion").innerHTML = ""
        const div = document.createElement("div")
          div.classList.add("card")
          div.innerHTML = `
              <img src="https://lh3.googleusercontent.com/a/default-user=s64-p">
              <div>
              <h4>${email}</h4>
              <p>${email}</p>
              </div></div>
          `
        document.querySelector(".email-suggestion").appendChild(div)
        toggleEmailSuggestionBox("show")
    }

    function toggleEmailSuggestionBox(type){
        if(type === "hide"){
          document.querySelector(".email-suggestion").innerHTML = ""
          document.querySelector(".email-suggestion").style.display = "none"
        }else{
          document.querySelector(".email-suggestion").style.display = "block"
        }
    }

    function buildEmail(email){
        if(document.querySelectorAll(".analysis-single-mail").length < 10){
          const div = document.createElement("span")
          div.classList.add("analysis-single-mail")
          div.innerHTML = `
          ${email}
          <p class='analysis-single-delete'>
            <i class="fa-solid fa-xmark"></i>
          </p>
          `
          document.querySelector(".analysis-mail").appendChild(div)
          toggleEmailSuggestionBox("hide")
          $("#emailTo").val("")
        }else{
          console.log("Can not enter more than 10 emails at once.")
        }
    }



    $("#emailTo").on('keyup', function (e) {
        if(validateModalEmail(e.target.value)){
            emailModalSuggestionStatus = true
            buildModalEmailBox(e.target.value)
        }else{
            emailModalSuggestionStatus = false
            toggleEmailSuggestionBox("hide")
        }

        if(e.key === 'Enter' || e.keyCode === 13) {
            if(emailModalSuggestionStatus){
                buildEmail(e.target.value)
            }
        }

    });


    $(".email-suggestion").on('click', function (e) {
        if(emailModalSuggestionStatus){
          const email = $("#emailTo").val()
          buildEmail(email)
        }
    })

    $(".analysis-mail").click(function (e) {
        const target = e.target.closest(".analysis-single-delete")
        if(target){
          target.parentElement.remove();
        }
    });

}

function getEmails(){
    const array = []
    document.querySelectorAll(".analysis-single-mail").forEach(el=>{
      array.push(el.textContent.trim())
    })

    return array
}

function validateEmailReport(){
    clearAlerts()
    if(document.querySelector(".analysis-single-mail")){
      return true
    }

    displayAlert(".analysis-mail-top", {status: 0, msg: "Please enter at least one email."})
    return false
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


function getGoogleCWVColorByScore(score, type) {
    let color = "danger";
  
    switch (type) {
      case "lcp":
        if (score <= 2.5) color = "success";
        else if (score <= 4.0) color = "orange";
        break;
  
      case "fid":
        if (score <= 100) color = "success";
        else if (score <= 300) color = "orange";
        break;
  
      case "cls":
        if (score <= 0.1) color = "success";
        else if (score <= 0.25) color = "orange";
        break;
  
      case "fcp":
        if (score <= 1.8) color = "success";
        else if (score <= 3.0) color = "orange";
        break;
  
      case "tbt":
        if (score <= 200) color = "success";
        else if (score <= 600) color = "orange";
        break;
  
      case "speed_index":
        if (score <= 3.4) color = "success";
        else if (score <= 5.8) color = "orange";
        break;
  
      case "interactive":
        if (score <= 3.8) color = "success";
        else if (score <= 7.3) color = "orange";
        break;
  
      default:
        color = "danger"; // default to bad if unknown type
    }
  
    return color;
  }

function getGoogleInsightsColorByScore(score) {
    if (score >= 90) return "success";
    if (score >= 50 && score < 90) return "orange";
    return "danger";
}


async function checkSitemapUrls(urls) {    
    try {
        const response = await $.ajax({
            url: '/check-sitemap-urls',
            type: 'POST',
            data: {
                urls: urls,
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json'
        });
        
        return response;
    } catch (error) {
        console.warn('Error checking sitemap URLs:', error);
        // Return all URLs as invalid if there's an error
        return urls.map(url => ({ url, valid: false }));
    }
}

function sendEmail(TABLE){
    const exporter = new TableCSVExporter(TABLE, "Marketing QA Tool Results.csv");
    const LINK = exporter.getCsvLink();
    const MESSAGE = document.querySelector("#modalEmailMessage").value
    const SUBJECT = document.querySelector("#emailSubject").value
    const ALL_EMAILS = getEmails()
    const CSV_FILE_NAME = "QA Results.csv";
    
    $.ajax({
      url : `/test/email-report`,
      type : 'POST',
      data: {
          "link": LINK,
          "message": MESSAGE,
          "emails": ALL_EMAILS,
          "subject": SUBJECT,
          "file_name": CSV_FILE_NAME,
          "_method": 'POST',
          "_token": $('meta[name="csrf-token"]').attr('content'),
      },       
      success : function(result) {
        updateEmailModal()
        displayAlert(".tools_body", result)
        scrollToTop()
      },
      error: function(data){
          removeLoader()
          displayAlert(".tools_body", {
              status: 0,
              msg: "There was an error, please try again later."
          })
      }
    })

    modalEmail.toggle()
}


function buildLoader(){
    removeSpinner()

    const div = document.createElement("div")
    div.classList.add("loading-container")
    div.innerHTML = `<div class='loading'></div>`
    document.body.appendChild(div)
}



function removeLoader(){
    if(document.querySelector(".loader__card")){
        document.querySelector(".loader__card").innerHTML = ""
    }
    removeSpinner()
}

function removeSpinner(){
    if(document.querySelector(".loading-container")){
        document.querySelector(".loading-container").remove()
    }
}

function splitNParts(num, parts) {
    let array = []
    for (let i = parts; i >= 1; i--) {
        const pn = Math.round(num / i)
        array.push(pn)
    }
    return array
}

function animateHealthScore(inputValue){
    if (!isNaN(inputValue) && inputValue >= 0 && inputValue <= 100) {
        // Calculate arrow rotation
        if(inputValue <= 24){
          var arrowRotation = (inputValue / 100) * 180 - 95;
        }else if(inputValue === 25){
          var arrowRotation = (inputValue / 100) * 180 - 105;
        }else if(inputValue === 50){
          var arrowRotation = (inputValue / 100) * 180 - 90;
          document.getElementById('healthInput').innerHTML = inputValue;
          return arrow.style.transform = `rotate(${arrowRotation}deg) translateX(20%)`;
        }
        else if(inputValue === 75){
          var arrowRotation = (inputValue / 100) * 180 - 80;
          document.getElementById('healthInput').innerHTML = inputValue;
          return arrow.style.transform = `rotate(${arrowRotation}deg) translateX(20%)`;
        }else{
          var arrowRotation = (inputValue / 100) * 180 - 85;
        }
        document.getElementById('healthInput').innerHTML = inputValue;
        arrow.style.transform = `rotate(${arrowRotation}deg) translateX(0%)`;
    }
}

function getSitemapVal(type, origin, element, elementVal){
    if(element.is(":checked")){
        return elementVal.val()
    }else{
        if(type == "html"){
            return `${origin}/sitemap`
        }else{
            return `${origin}/sitemap.xml`
        }
    }
}


function getAllTestLabels2(projecdId){
    return $.ajax({
        url : `/get-all-labels/${projecdId}`,
        type : 'get',
        aysnc: false,
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
        },       
        success: function(data) {
          
        },error: function(data){
        }
    });
}


function getAllTestLabels(type, label = "default"){
    const securityLabels = [
        {
            displayName: "Safe browsing",
            name: "is_safe_browsing",
            dbName: "is_safe_browsing",
            url: "/test/safe-browsing",
            hasDashboardParent: true,
            dashboardParent: "security_labels",
            parent: "security"
        },
        {
            displayName: "Unsafe cross origin links",
            name: "cross_origin_links",
            dbName: "cross_origin_links",
            url: "/test/cross-origin-links",
            hasDashboardParent: true,
            dashboardParent: "security_labels",
            parent: "security"
        },
        {
            displayName: "Protocol relative resource links",
            name: "protocol_relative_resource",
            dbName: "protocol_relative_resource",
            url: "/test/protocol-relative-resource",
            hasDashboardParent: true,
            dashboardParent: "security_labels",
            parent: "security"
        },
        {
            displayName: "Content Security Policy Header",
            name: "content_security_policy_header",
            dbName: "content_security_policy_header",
            url: "/test/content-security-policy-header",
            hasDashboardParent: true,
            dashboardParent: "security_labels",
            parent: "security"
        },
        {
            displayName: "X Frame Options Header",
            name: "x_frame_options_header",
            dbName: "x_frame_options_header",
            url: "/test/x-frame-options-header",
            hasDashboardParent: true,
            dashboardParent: "security_labels",
            parent: "security"
        },
        {
            displayName: "HSTS Header",
            name: "hsts_header",
            dbName: "hsts_header",
            url: "/test/hsts-header",
            hasDashboardParent: true,
            dashboardParent: "security_labels",
            parent: "security"
        },
        {
            displayName: "Bad content Type",
            name: "bad_content_type",
            dbName: "bad_content_type",
            url: "/test/bad-content",
            hasDashboardParent: true,
            dashboardParent: "security_labels",
            parent: "security"
        },
        {
            displayName: "SSL Certificate",
            name: "ssl_certificate_enable",
            dbName: "ssl_certificate_enable",
            url: "/test/ssl-certificate",
            hasDashboardParent: true,
            dashboardParent: "security_labels",
            parent: "security"
        },
        {
            displayName: "Directory Browsing",
            name: "folder_browsing_enable",
            dbName: "folder_browsing_enable",
            url: "/test/directory-browsing",
            hasDashboardParent: true,
            dashboardParent: "security_labels",
            parent: "security"
        },
    ]
    
    const CBPLabels = [
        {
            displayName: "GZIP Compression",
            name: "gzip_compression",
            dbName: "gzip_compression",
            url: "/test/gzip-compression",
            hasDashboardParent: true,
            dashboardParent: "cbp_labels",
            parent: "bestPractices"
        },
        {
            displayName: "HTML Compression",
            name: "html_compression",
            dbName: "html_compression",
            url: "/test/html-compression",
            hasDashboardParent: true,
            dashboardParent: "cbp_labels",
            parent: "bestPractices"
        },
        {
            displayName: "CSS Compression",
            name: "css_compression",
            dbName: "css_compression",
            url: "/test/css-compression",
            hasDashboardParent: true,
            dashboardParent: "cbp_labels",
            parent: "bestPractices"
        },
        {
            displayName: "JS Compression",
            name: "js_compression",
            dbName: "js_compression",
            url: "/test/js-compression",
            hasDashboardParent: true,
            dashboardParent: "cbp_labels",
            parent: "bestPractices"
        },
        {
            displayName: "CSS caching",
            name: "css_caching_enable",
            dbName: "css_caching_enable",
            url: "/test/css-caching-enable",
            hasDashboardParent: true,
            dashboardParent: "cbp_labels",
            parent: "bestPractices"
        },
        {
            displayName: "JS caching",
            name: "js_caching_enable",
            dbName: "js_caching_enable",
            url: "/test/js-caching-enable",
            hasDashboardParent: true,
            dashboardParent: "cbp_labels",
            parent: "bestPractices"
        },
        {
            displayName: "Page Size",
            name: "page_size",
            dbName: "page_size",
            url: "/test/page-size",
            hasDashboardParent: true,
            dashboardParent: "cbp_labels",
            parent: "bestPractices"
        },
        {
            displayName: "Nested Tables",
            name: "nested_tables",
            dbName: "nested_tables",
            url: "/test/nested-tables",
            hasDashboardParent: true,
            dashboardParent: "cbp_labels",
            parent: "bestPractices"
        },
        {
            displayName: "Frameset",
            name: "frameset",
            dbName: "frameset",
            url: "/test/frameset",
            hasDashboardParent: true,
            dashboardParent: "cbp_labels",
            parent: "bestPractices"
        },
        {
            displayName: "Broken Links",
            name: "broken_links",
            dbName: "broken_links",
            url: "/test/broken-links",
            hasDashboardParent: false,
            dashboardParent: "",
            parent: "bestPractices"
        },
    ]
    const performanceLabels = [
        {
            displayName: "Overall Score",
            name: "google_overall",
            dbName: "google_overall",
            url: "/test/google-page-speed-insights",
            urlDetails: "/test-details/google-page-speed-insights",
            reportsUrl: "/reports/mobile-friendly",
            parent: "performance"
        },
        {
            displayName: "Lighthouse Score",
            name: "google_lighthouse",
            dbName: "google_lighthouse",
            url: "/test/google-page-speed-lighthouse",
            urlDetails: "/test-details/google-page-speed-lighthouse",
            reportsUrl: "/reports/mobile-friendly",
            parent: "performance"
        },
        {
            displayName: "Core Web Vitals",
            name: "core_web_vitals",
            dbName: "core_web_vitals",
            url: "/test/google-page-speed-core-web-vitals",
            urlDetails: "/test-details/google-page-speed-core-web-vitals",
            reportsUrl: "/reports/mobile-friendly",
            parent: "performance"
        },
        {
            displayName: "Mobile Friendliness",
            name: "mobile_friendly",
            dbName: "mobile_friendly",
            url: "/test/mobile-friendly",
            urlDetails: "/test-details/mobile-friendly",
            reportsUrl: "/reports/mobile-friendly",
            hasDashboardParent: false,
            parent: "performance",
        }
    ]
    
    
    const SEOLabels = [
        {
            displayName: "Meta Title",
            name: "title",
            dbName: "meta_title",
            url: "/test/title",
            urlDetails: "/test-details/title",
            reportsUrl: "/reports/meta-title",
            parent: "seo",
        },
        {
            displayName: "Meta Description",
            name: "description",
            dbName: "meta_desc",
            url: "/test/description",
            urlDetails: "/test-details/description",
            reportsUrl: "/reports/description",
            parent: "seo",
        },
        {
            displayName: "Robots Meta Tag",
            name: "robots",
            dbName: "robots_meta",
            url: "/test/robots-meta",
            urlDetails: "/test-details/robots-meta",
            reportsUrl: "/reports/robots-meta",
            parent: "seo",
        },
        {
            displayName: "Canonical Tag",
            name: "canonical",
            dbName: "canonical_url",
            url: "/test/canonical-url",
            urlDetails: "/test-details/canonical-url",
            reportsUrl: "/reports/canonical-url",
            parent: "seo",
        },
        {
            displayName: "Images",
            name: "img",
            dbName: "images",
            url: "/test/images",
            urlDetails: "/test-details/images",
            reportsUrl: "/reports/images",
            parent: "seo",
        },
        {
            displayName: "URL Slug",
            name: "url",
            dbName: "url_slug",
            url: "/test/url-slug",
            parent: "seo",
        },
        {
            displayName: "Robot.txt",
            name: "robot_text_test",
            dbName: "robot_text_test",
            url: "/test/robot-text-test",
            parent: "seo",
        },
        {
            displayName: "Headings",
            name: "h1_heading_tag",
            dbName: "h1_heading_tag",
            url: "/test/h1-heading-tag",
            parent: "seo",
        },
        {
            displayName: "XML Sitemap",
            name: "xml_sitemap",
            dbName: "xml_sitemap",
            url: "/test/xml-sitemap",
            urlDetails: "/test-details/xml-sitemap",
            reportsUrl: "/reports/xml-sitemap",
            parent: "seo",
        },
        {
            displayName: "HTML Sitemap",
            name: "html_sitemap",
            dbName: "html_sitemap",
            url: "/test/html-sitemap",
            urlDetails: "/test-details/html-sitemap",
            reportsUrl: "/reports/html-sitemap",
            parent: "seo",
        },
        {
            displayName: "Open Graph tags",
            name: "og:title",
            dbName: "open_graph_tags",
            url: "/test/og-tags",
            urlDetails: "/test-details/og-tags",
            ogDesc:{
                displayName: "OG Description",
                name: "og:description",
                dbName: "open_graph_desc",
            },
            ogImage:{
                displayName: "OG Image",
                name: "og:image",
                dbName: "open_graph_image",
            },
            ogURL:{
                displayName: "OG URL",
                name: "og:url",
                dbName: "open_graph_url",
            },
            parent: "seo",
        },
        {
            displayName: "Twitter Tags",
            name: "twitter:title",
            dbName: "twitter_tags",
            url: "/test/twitter-tags",
            urlDetails: "/test-details/twitter-tags",
            twitterImage:{
                displayName: "Twitter Image",
                name: "twitter:image",
                dbName: "twitter_image",
            },
            twitterImageAlt:{
                displayName: "Twitter Image Alt",
                name: "twitter:image:alt",
                dbName: "twitter_image_alt",
            },
            parent: "seo",
        },
        {
            displayName: "Favicon",
            name: "icon",
            dbName: "favicon",
            url: "/test/favicon",
            parent: "seo",
        },
        {
            displayName: "Meta Viewport",
            name: "viewport",
            dbName: "meta_viewport",
            url: "/test/meta-viewport",
            parent: "seo",
        },
        {
            displayName: "Doctype",
            name: "doctype",
            dbName: "doctype",
            url: "/test/doctype",
            parent: "seo",
        },
        {
            displayName: "HTTP Status Code",
            name: "http_status_code",
            dbName: "http_status_code",
            url: "/test/http-status-code",
            parent: "seo",
        },
    ]

    
    return {
        seo: SEOLabels,
        performance: performanceLabels,
        security: securityLabels,
        bestPractices: CBPLabels,
        allLabels: SEOLabels.concat(securityLabels, CBPLabels, performanceLabels)
    }
}