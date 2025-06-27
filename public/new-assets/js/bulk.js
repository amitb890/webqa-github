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
        const table = $(".test_result_area table").clone()[0];
    
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
        console.log(allLinks)
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
                i++
  
                html+=`
                <p>
                    <span>${i}</span>
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.3333 5.33333C11.1565 5.33333 10.987 5.40357 10.8619 5.5286C10.7369 5.65362 10.6667 5.82319 10.6667 6V10C10.6667 10.1768 10.5964 10.3464 10.4714 10.4714C10.3464 10.5964 10.1768 10.6667 10 10.6667H2C1.82319 10.6667 1.65362 10.5964 1.5286 10.4714C1.40357 10.3464 1.33333 10.1768 1.33333 10V2C1.33333 1.82319 1.40357 1.65362 1.5286 1.5286C1.65362 1.40357 1.82319 1.33333 2 1.33333H6C6.17681 1.33333 6.34638 1.2631 6.4714 1.13807C6.59643 1.01305 6.66667 0.843478 6.66667 0.666667C6.66667 0.489856 6.59643 0.320286 6.4714 0.195262C6.34638 0.0702379 6.17681 0 6 0H2C1.46957 0 0.960859 0.210714 0.585787 0.585787C0.210714 0.960859 0 1.46957 0 2V10C0 10.5304 0.210714 11.0391 0.585787 11.4142C0.960859 11.7893 1.46957 12 2 12H10C10.5304 12 11.0391 11.7893 11.4142 11.4142C11.7893 11.0391 12 10.5304 12 10V6C12 5.82319 11.9298 5.65362 11.8047 5.5286C11.6797 5.40357 11.5101 5.33333 11.3333 5.33333Z" fill="#8F8F8F"></path>
                    <path d="M8.66532 1.33333H9.71866L5.52532 5.52C5.46284 5.58198 5.41324 5.65571 5.3794 5.73695C5.34555 5.81819 5.32812 5.90533 5.32812 5.99333C5.32812 6.08134 5.34555 6.16848 5.3794 6.24972C5.41324 6.33096 5.46284 6.40469 5.52532 6.46667C5.5873 6.52915 5.66103 6.57875 5.74227 6.61259C5.82351 6.64644 5.91065 6.66387 5.99866 6.66387C6.08667 6.66387 6.1738 6.64644 6.25504 6.61259C6.33628 6.57875 6.41002 6.52915 6.47199 6.46667L10.6653 2.28V3.33333C10.6653 3.51014 10.7356 3.67971 10.8606 3.80474C10.9856 3.92976 11.1552 4 11.332 4C11.5088 4 11.6784 3.92976 11.8034 3.80474C11.9284 3.67971 11.9987 3.51014 11.9987 3.33333V0.666667C11.9987 0.489856 11.9284 0.320286 11.8034 0.195262C11.6784 0.0702379 11.5088 0 11.332 0H8.66532C8.48851 0 8.31894 0.0702379 8.19392 0.195262C8.0689 0.320286 8.00061 0.489856 8.00061 0.666667C8.00061 0.843478 8.07085 1.01305 8.19587 1.13807C8.3209 1.2631 8.49047 1.33333 8.66728 1.33333Z" fill="#8F8F8F"></path>
                    </svg>
                    <a href="${key}" target="_blank">${key}</a>
                    <strong>${status}</strong>
                </p>`
              }
          }
        }
        if(i === 0){
            html = "NA"
        }
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
            <div class="download_result">
                <ul>
                    <li>Download:</li>
                    <li class='download-csv-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download CSV"></button></li>
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
            <div class="download_result">
                <ul>
                    <li>Download:</li>
                    <li class='download-csv-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download CSV"></button></li>
                    <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li>
                </ul>
                </div>
            </div>`
        }else if(label === "img"){
            div = `
            <div class="download_result">
                <ul class="datatable_download_result">
                    <li>Download:</li>
                    <li class='download-csv-bulk website-tracker-csv' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download CSV"></button></li>
                    <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li>
                    <li class='download-xlsx-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/htdocs.png" alt="icon" title="Download XLSX"></button></li>

                    <li class='datatable_download_result_li' style="">
                        <input type="text" class="form-control" id="custom-search" placeholder="Search">
                    </li>
                </ul>
            </div>
            `
        }else if(label === "page_speed_google_lighthouse" || label === "page_speed_google" || label === "page_speed_google_core"){
            div = `
            <div class="download_result">
                <ul class="datatable_download_result">
                    <li>Download:</li>
                    <li class='download-csv-bulk download-csv-bulk-rowspan website-tracker-csv' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download CSV"></button></li>
                    <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li>
                    <li class='download-xlsx-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/htdocs.png" alt="icon" title="Download XLSX"></button></li>

                    <li class='datatable_download_result_li' style="">
                        <input type="text" class="form-control" id="custom-search" placeholder="Search">
                    </ul>
                </div>
            </div>
            `
        } 
        else if(label === "title"){
            div = `
            <div class="download_result">
                <ul class="datatable_download_result">
                    <li>Download:</li>
                    <li class='download-csv-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download CSV"></button></li>
                    <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li>
                    <li class='download-xlsx-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/htdocs.png" alt="icon" title="Download XLSX"></button></li>
                   
                    <li class='datatable_download_result_li' style="">
                        <input type="text" class="form-control" id="custom-search" placeholder="Search">
                    </ul>
                </div>
            </div>
            `
        }
        else{
            div = `
            <div class="download_result">
                <ul class="datatable_download_result">
                    <li>Download:</li>
                    <li class='download-csv-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download CSV"></button></li>
                    <li class='email-bulk'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li>
                    <li class='download-xlsx-bulk' data-csv=${csvName}><button><img src="/new-assets/assets/images/htdocs.png" alt="icon" title="Download XLSX"></button></li>
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
    }
    

    static updateLoaderUI(){
        document.querySelector(".loader__card").classList.remove("d-none")
    }
}



$( document ).ready(function() {
    Controls.init()
    const label = JSON.parse($("#data_value").val())
    let results = [], resultsFailed = [], resultsPassed = []
    let activeUpdateData
    let activeUpdateStatusElement
    let url_list, url_list_length, obj_settings, obj, settingsVal, activeURL = "", settings
    let errorStatus = false, resultsError = []
    var updateStatusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'), {
        keyboard: false
    })
    var failedListModal = new bootstrap.Modal(document.getElementById('failedListModal'), {
        keyboard: false
    })

    $("#startTestBulk").on( "click", function(e) {
        const urlInput = $("#urlValue")[0]
        let urlInputVal = $("#urlValue")[0].value
        results = [], resultsFailed = [], resultsPassed = [], resultsError = [], errorStatus = false

        clearAlerts()
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
            msgMinimumSelection: "At least one test criteria has to be selected.", 
            msgEmpty: "Please enter urls.", 
            msgExceed: "You can not enter more than 100 urls."
            }, "bulk")){
            // Split, trim, and remove empty lines
            let original_url_list = urlInputVal.trim().split("\n").map(url => url.trim()).filter(url => url)
            // Remove duplicates
            let unique_url_list = [...new Set(original_url_list)]
            // If duplicates were found, update textarea and show alert
            if (unique_url_list.length < original_url_list.length) {
                $("#urlValue")[0].value = unique_url_list.join("\n")
                
                AlertManager.afterElement("#urlValue", "Duplicate URLS were removed and were not tested.", {
                    type: AlertManager.types.ERROR,
                    autoHide: false
                });
            }
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
        $(".test_result_area").html("")
    }


    function startTest(){
        const url = constructTestURL(url_list[0])
        const origin = new URL(url).origin
        const htmlSitemap = `${origin}/sitemap`
        const xmlSitemap = `${origin}/sitemap.xml`

        obj["urlValue"] = url
        obj["bulkUrl"] = $("#urlValue").val()
        obj["settingsVal"] = settingsVal
        obj["settingsVal"]["settings_sub"]["html_sitemap_val"] = htmlSitemap
        obj["settingsVal"]["settings_sub"]["xml_sitemap_val"] = xmlSitemap


        $.ajax({
            url : `/test/collect`,
            type : 'POST',
            aysnc: false,
            data: {
                "data": obj,
                "_method": 'POST',
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },       
            success : function(data) {

                if(data.status === 0){
                    // test failed
                    errorStatus = true
                    resultsError.push(data)
                    checkFinished()
                }else{
                    data = JSON.parse(data)
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
                        checkFinished()
                    }
                }
            },
            error: function(data){
            }
        })
    }



    function runTest(label, test, url){
        $.ajax({
            url : `${label.url}`,
            type : 'POST',
            aysnc: false,
            data: {
                "data": test,
                "_method": 'POST',
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },       
            success : function(data) {
                data = JSON.parse(data)
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
        modifyCssEndTest()
    }
    modifyCss()
    function modifyCss(){
        $('.tools_sidebar .accordion-body').attr('style', 'margin-top: -10px !important');
    }
    function modifyCssEndTest(){
        $('.table-responsive').attr('style', 'white-space: normal !important');
    }
 
    function buildFailedList(list){
        const p = document.createElement("p")
        p.innerHTML = "Some urls were not tested, <a href='javascript:void()' id='showFailedModal'>Click here</a> to view them."
        document.querySelector(".failed-list").appendChild(p)
        const ol = document.createElement("ol")
        list.forEach(data=>{
            const li = document.createElement("li")
            li.innerHTML = data.failed
            ol.appendChild(li)
        })
        document.querySelector(".failed-list-data").appendChild(ol)
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

        console.log(label.name)
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
                    <td class="align-left result_data_url content-td"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left content-td">${result.content != null ? result.content : "-"}</td>
                    <td class="${result.lengthClass} ${settings.max_title_length || settings.min_title_length ? "" : "d-none hidden-element"}">${result.content != null ? result.content.length : 0}</td>
                    <td class="${settings.is_title_equal_h1 ? "" : "d-none hidden-element"}">No</td>
                    <td class="${result.casingClass} ${settings.title_casing_both || settings.title_casing_camel || settings.title_casing_sentence ? "" : "d-none hidden-element"}">${result.casing ? result.casing : "-"}</td>
                    <td class="${result.status ? "result_pass" : "result_fail"} strong" ><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();
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
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
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
                    <th class="${settings.max_url_length || settings.min_url_length ? "" : "d-none hidden-element"}">LEN</th>
                    <th class="${settings.url_no_numbers ? "" : "d-none hidden-element"}">Has Numbers?</th>
                    <th class="${settings.url_no_special ? "" : "d-none hidden-element"}">Has Special Characters?</th>
                    <th class="${settings.url_slug_lowercase ? "" : "d-none hidden-element"}">Has Uppercase Characters?</th>
                    <th class="${settings.url_casing_only_hyphens ? "" : "d-none hidden-element"}">Words Separated By Hyphens Only?</th>
                    <th class="${settings.url_casing_only_underscores ? "" : "d-none hidden-element"}">Words Separated By Underscores Only?</th>
                    <th class="${settings.url_stop_words ? "" : "d-none hidden-element"}">Contains Stop Words?</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td class="text-center">${i+1}</td>
                    <td class="align-left result_data_url content-td"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left content-td">${result.content != '' ? result.content : "-"}</td>
                    <td class="${result.lengthClass} ${settings.max_url_length || settings.min_url_length ? "" : "d-none hidden-element"}">${result.content != null ? result.content.length : 0}</td>
                    <td class="${result.statusNumbers ? "result_pass" : "result_fail"} ${settings.url_no_numbers ? "" : "d-none hidden-element"}">${result.statusNumbers ? "No" : "Yes"}</td>
                    <td class="${result.statusSpecial ? "result_pass" : "result_fail"} ${settings.url_no_special ? "" : "d-none hidden-element"}">${result.statusSpecial ? "No" : "Yes"}</td>
                    <td class="${result.statusLowercase ? "result_pass" : "result_fail"} ${settings.url_slug_lowercase ? "" : "d-none hidden-element"}">${result.statusLowercase ? "No" : "Yes"}</td>
                    <td class="${result.statusHyphens ? "result_pass" : "result_fail"} ${settings.url_casing_only_hyphens ? "" : "d-none hidden-element"}">${!isSingleWord(result.content) ? result.statusHyphens ? "Yes" : "No" : "-"}</td>
                    <td class="${result.statusUnderscore ? "result_pass" : "result_fail"} ${settings.url_casing_only_underscores ? "" : "d-none hidden-element"}">${result.statusUnderscore ? "Yes" : "No"}</td>
                    <td class="${result.statusStopWords ? "result_pass" : "result_fail"} ${settings.url_stop_words ? "" : "d-none hidden-element"}">${result.statusStopWords ? "No" : "Yes"}</td>
                    <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>

                    `
                    tbody.appendChild(tr)
                })
                createDatatableElement();
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
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left">${result.content != null ? result.content : "Open Graph Title does not exist."}</td>
                    <td class="${result.lengthClass} ${settings.max_og_title_length || settings.min_og_title_length ? "" : "d-none hidden-element"}">${result.content != null ? result.content.length : 0}</td>
                    <td class="${result.casingClass} ${settings.og_title_casing_both || settings.og_title_casing_camel || settings.og_title_casing_sentence ? "" : "d-none hidden-element"}">${result.casing ? result.casing : "-"}</td>
                    <td class="${result.isEqualClass} ${settings.is_og_title_equal_title ? "" : "d-none hidden-element"}">${result.isEqualStatus ? "Yes" : "No"}</td>
                    <td class="${result.statusTitle ? "result_pass" : "result_fail"}">${result.statusTitle ? "PASS" : "FAIL"}</td>
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
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left">${result.contentDesc != null ? result.contentDesc : "Open Graph Description does not exist."}</td>
                    <td class="${result.lengthDescClass} ${settings.max_og_desc_length || settings.min_og_desc_length ? "" : "d-none hidden-element"}">${result.contentDesc != null ? result.contentDesc.length : 0}</td>
                    <td class="${result.isEqualDescClass} ${settings.is_og_desc_equal_desc ? "" : "d-none hidden-element"}">${result.isEqualDescStatus ? "Yes" : "No"}</td>
                    <td class="${result.statusDesc ? "result_pass" : "result_fail"}">${result.statusDesc ? "PASS" : "FAIL"}</td>
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
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left">${result.contentImage != null && result.contentImage != "" ? result.contentImage : "Open Graph Image does not exist."}</td>
                    <td class="${settings.og_image_dimensions_min || settings.og_image_dimensions_exact ? "" : "d-none hidden-element"}"><span class="${result.widthImageClass}">${result.dimensions != null ? result.dimensions.w : "-"}</span>, <span class="${result.heightImageClass}">${result.dimensions != null ? result.dimensions.h : ""}</span></td>
                    <td class="${result.statusImage ? "result_pass" : "result_fail"}">${result.statusImage ? "PASS" : "FAIL"}</td>
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
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left">${result.contentURL != null && result.contentURL != "" ? result.contentURL : "Open Graph URL does not exist."}</td>
                    <td class="${result.lengthURLClass} ${settings.max_og_url_length ? "" : "d-none hidden-element"}">${result.contentURL != null ? result.contentURL.length : 0}</td>
                    <td class="${result.isEqualURLClass} ${settings.is_og_url_equal_url ? "" : "d-none hidden-element"}">${result.isEqualURLStatus ? "Yes" : "No"}</td>
                    <td class="${result.statusURL ? "result_pass" : "result_fail"}">${result.statusURL ? "PASS" : "FAIL"}</td>
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
                    <th class="${settings.max_twitter_title_length || settings.min_twitter_title_length ? "" : "d-none hidden-element"}">LEN</th>
                    <th class="${settings.twitter_title_casing_both || settings.twitter_title_casing_camel || settings.twitter_title_casing_sentence ? "" : "d-none hidden-element"}">Casing</th>
                    <th class="${settings.is_twitter_title_equal_title ? "" : "d-none hidden-element"}">Twitter:Title Equal to title?</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left">${result.content != null ? result.content : "Twitter Title does not exist."}</td>
                    <td class="${result.lengthClass} ${settings.max_twitter_title_length || settings.min_twitter_title_length ? "" : "d-none hidden-element"}">${result.content != null ? result.content.length : 0}</td>
                    <td class="${result.casingClass} ${settings.twitter_title_casing_both || settings.twitter_title_casing_camel || settings.twitter_title_casing_sentence ? "" : "d-none hidden-element"}">${result.casing ? result.casing : "-"}</td>
                    <td class="${result.isEqualClass} ${settings.is_twitter_title_equal_title ? "" : "d-none hidden-element"}">${result.isEqualStatus ? "Yes" : "No"}</td>
                    <td class="${result.statusTitle ? "result_pass" : "result_fail"}">${result.statusTitle ? "PASS" : "FAIL"}</td>
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
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left">${result.contentImage != null && result.contentImage != "" ? result.contentImage : "Twitter Image does not exist."}</td>
                    <td class="${settings.twitter_image_dimensions_min || settings.twitter_image_dimensions_exact ? "" : "d-none hidden-element"}"><span class="${result.widthImageClass}">${result.dimensions != null ? result.dimensions.w : "-"}</span>, <span class="${result.heightImageClass}">${result.dimensions != null ? result.dimensions.h : ""}</span></td>
                    <td class="${result.statusImage ? "result_pass" : "result_fail"}">${result.statusImage ? "PASS" : "FAIL"}</td>
                    `
                    tbody2.appendChild(tr)
                })
       
                thead3 = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                    <th class="align-left">Twitter:Image:Alt</th>
                    <th class="${settings.max_twitter_image_alt_length ? "" : "d-none hidden-element"}">LEN</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr = document.createElement("tr")
                    tr.innerHTML = `
                    <td>${i+1}</td>
                    <td class="align-left result_data_url"><a href="${result.tested_url}" target="_blank">${result.tested_url}<img src="/new-assets/assets/images/copy-link.png" alt="icon"></a></td>
                    <td class="align-left">${result.contentImageAlt != null && result.contentImageAlt != "" ? result.contentImageAlt : "Twitter Image Alt does not exist."}</td>
                    <td class="${result.lengthImageAltClass} ${settings.max_twitter_image_alt_length ? "" : "d-none hidden-element"}">${result.contentImageAlt ? result.contentImageAlt.length : 0}</td>
                    <td class="${result.statusImageAlt ? "result_pass" : "result_fail"}">${result.statusImageAlt ? "PASS" : "FAIL"}</td>
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
                            <th class="${settings.image_alt_only_spaces ? "" : "d-none hidden-element"}">Words separated by spaces?</th>
                            <th class="align-left">File name</th>
                            <th class="${settings.image_name_max_characters ? "" : "d-none hidden-element"}">LEN</th>
                            <th class="${settings.image_name_only_hyphens ? "" : "d-none hidden-element"}">Words separated by hyphens?</th>
                            <th class="${settings.image_name_no_uppercase ? "" : "d-none hidden-element"}">Uppercase characters?</th>
                            <th class="${settings.image_name_no_special ? "" : "d-none hidden-element"}">Special characters?</th>
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
                                <td class="content-td image-table-link" td-replace="${prob.imageSrc}"><a href="${prob.imageSrc}" target="_blank"><span>Link</span>
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.3333 5.33333C11.1565 5.33333 10.987 5.40357 10.8619 5.5286C10.7369 5.65362 10.6667 5.82319 10.6667 6V10C10.6667 10.1768 10.5964 10.3464 10.4714 10.4714C10.3464 10.5964 10.1768 10.6667 10 10.6667H2C1.82319 10.6667 1.65362 10.5964 1.5286 10.4714C1.40357 10.3464 1.33333 10.1768 1.33333 10V2C1.33333 1.82319 1.40357 1.65362 1.5286 1.5286C1.65362 1.40357 1.82319 1.33333 2 1.33333H6C6.17681 1.33333 6.34638 1.2631 6.4714 1.13807C6.59643 1.01305 6.66667 0.843478 6.66667 0.666667C6.66667 0.489856 6.59643 0.320286 6.4714 0.195262C6.34638 0.0702379 6.17681 0 6 0H2C1.46957 0 0.960859 0.210714 0.585787 0.585787C0.210714 0.960859 0 1.46957 0 2V10C0 10.5304 0.210714 11.0391 0.585787 11.4142C0.960859 11.7893 1.46957 12 2 12H10C10.5304 12 11.0391 11.7893 11.4142 11.4142C11.7893 11.0391 12 10.5304 12 10V6C12 5.82319 11.9298 5.65362 11.8047 5.5286C11.6797 5.40357 11.5101 5.33333 11.3333 5.33333Z" fill="#1E63B8"></path>
                                    <path d="M8.66728 1.33333H9.72061L5.52728 5.52C5.46479 5.58198 5.4152 5.65571 5.38135 5.73695C5.3475 5.81819 5.33008 5.90533 5.33008 5.99333C5.33008 6.08134 5.3475 6.16848 5.3794 6.24972C5.41324 6.33096 5.46284 6.40469 5.52532 6.46667C5.5873 6.52915 5.66103 6.57875 5.74227 6.61259C5.82351 6.64644 5.91065 6.66387 5.99866 6.66387C6.08667 6.66387 6.1738 6.64644 6.25504 6.61259C6.33628 6.57875 6.41002 6.52915 6.47199 6.46667L10.6673 2.28V3.33333C10.6673 3.51014 10.7375 3.67971 10.8625 3.80474C10.9876 3.92976 11.1571 4 11.3339 4C11.5108 4 11.6803 3.92976 11.8053 3.80474C11.9304 3.67971 12.0006 3.51014 12.0006 3.33333V0.666667C12.0006 0.489856 11.9304 0.320286 11.8053 0.195262C11.6803 0.0702379 11.5108 0 11.3339 0H8.66728C8.48851 0 8.31894 0.0702379 8.19392 0.195262C8.0689 0.320286 8.00061 0.489856 8.00061 0.666667C8.00061 0.843478 8.07085 1.01305 8.19587 1.13807C8.3209 1.2631 8.49047 1.33333 8.66728 1.33333Z" fill="#1E63B8"></path>
                                </svg> </a></td>
                                <td class="align-left ${settings.image_alt ? "" : "d-none hidden-element"}">${prob.imageAlt}</td>
                                <td class="${prob.imageAltSpacesClass} ${settings.image_alt_only_spaces ? "" : "d-none hidden-element"}">${prob.imageAltSpacesStatus ? "<span class='result_pass'>Yes</span>" : "<span class='result_fail'>No</span>"}</td>
                                <td class="align-left">${prob.imageName}</td>
                                <td class="${prob.imageLengthClass} ${settings.image_name_max_characters ? "" : "d-none hidden-element"}">${prob.imageLengthStatus ? prob.imageName.length : "-"}</td>
                                <td class="${prob.imageHyphenClass} ${settings.image_name_only_hyphens ? "" : "d-none hidden-element"}">${prob.imageHyphenStatus ? "<span class='result_pass'>Yes</span>" : "<span class='result_fail'>No</span>"}</td>
                                <td class="${prob.imageUppercaseClass} ${settings.image_name_no_uppercase ? "" : "d-none hidden-element"}">${prob.imageUppercaseStatus ? "<span class='result_fail'>Yes</span>" : "<span class='result_pass'>No</span>"}</td>
                                <td class="${prob.imageSpecialClass} ${settings.image_name_no_special ? "" : "d-none hidden-element"}">${prob.imageSpecialStatus ? "<span class='result_fail'>Yes</span>" : "<span class='result_pass'>No</span>"}</td>
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
                            <td class="${result.status ? "result_pass" : "result_fail"} strong"><strong>${result.status ? "PASS" : "FAIL"}</strong></td>
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
                    thead = `<thead class="result_data_header">
                    <tr>
                        <th>#</th>
                        <th>URL</th>
                        <th colspan="2" class="text-center">Performance</th>
                        <th colspan="2" class="text-center">Accessibility</th>
                        <th colspan="2" class="text-center">Best Practices</th>
                        <th colspan="2" class="text-center">SEO</th>
                        <th>Result</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Desktop</th>
                        <th>Mobile</th>
                        <th>Desktop</th>
                        <th>Mobile</th>
                        <th>Desktop</th>
                        <th>Mobile</th>
                        <th>Desktop</th>
                        <th>Mobile</th>
                        <th></th>
                    </tr>
                    </thead>`

                results.forEach((result, i)=>{
                    const tr1 = document.createElement("tr")
                    tr1.innerHTML = `
                        <tr>
                            <td>${i+1}</td>
                            <td class="align-left">${result.tested_url}</td>
                            <td class="${result.statusPerformanceDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.scoreDesktop)}</td>
                            <td class="${result.statusPerformanceMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.scoreMobile)}</td>
                            
                            <td class="${result.statusAccessibilityDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.accessibilityDesktop)}</td>
                            <td class="${result.statusAccessibilityMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.accessibilityMobile)}</td>

                            <td class="${result.statusBestPracticesDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.bestPracticesDesktop)}</td>
                            <td class="${result.statusBestPracticesMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.bestPracticesMobile)}</td>

                            <td class="${result.statusSeoDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.seoDesktop)}</td>
                            <td class="${result.statusSeoMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.seoMobile)}</td>               

                            <td class="${result.statusDesktop && result.statusMobile ? "result_pass" : "result_fail"} strong">${result.statusDesktop && result.statusMobile ? "PASS" : "FAIL"}</td>
                        </tr>`
                    tbody.appendChild(tr1)

                    const tr2 = document.createElement("tr")
                  
                })
                createDatatableElement();
                break;
            case "page_speed_google_core":
                table.classList.add("dataTable")
                table.classList.add("custom-dataTable")
                thead = `<thead class="result_data_header">
                <tr>
                    <th>#</th>
                    <th>URL</th>
                    <th colspan="2" class="text-center">LCP</th>
                    <th colspan="2" class="text-center">FID</th>
                    <th colspan="2" class="text-center">CLS</th>
                    <th colspan="2" class="text-center">FCP</th>
                    <th colspan="2" class="text-center">TTI</th>
                    <th colspan="2" class="text-center">SI</th>
                    <th colspan="2" class="text-center">TBT</th>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th colspan="2" class="text-center">(seconds)</th>
                    <th colspan="2" class="text-center">(seconds)</th>
                    <th colspan="2" class="text-center">(seconds)</th>
                    <th colspan="2" class="text-center">(milliseconds)</th>
                    <th colspan="2" class="text-center">(milliseconds)</th>
                    <th colspan="2" class="text-center">(seconds)</th>
                    <th colspan="2" class="text-center">(seconds)</th>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Result</th>
                </tr>
                </thead>`

                results.forEach((result, i)=>{
                    const tr1 = document.createElement("tr")
                    tr1.innerHTML = `
                        <tr>
                            <td>${i+1}</td>
                            <td class="align-left">${result.tested_url}</td>
                            <td class="${result.statusLCPDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.lcpDesktop)}</td>
                            <td class="${result.statusLCPMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.lcpMobile)}</td>
                           
                            <td class="${result.statusFIDDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.fidDesktop)}</td>
                            <td class="${result.statusFIDMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.fidMobile)}</td>
                            
                            <td class="${result.statusCLSDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.clsDesktop)}</td>
                            <td class="${result.statusCLSMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.clsMobile)}</td>
                            
                            <td class="${result.statusFCPDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.fcpDesktop)}</td>
                            <td class="${result.statusFCPMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.fcpMobile)}</td>
                            
                            <td class="${result.statusTTIDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.ttiDesktop)}</td>
                            <td class="${result.statusTTIMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.ttiMobile)}</td>
                           
                            <td class="${result.statusSIDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.siDesktop)}</td>
                            <td class="${result.statusSIMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.siMobile)}</td>
                           
                            <td class="${result.statusTBTDesktop ? "result_pass" : "result_fail"}">${getRoundedNumber(result.tbtDesktop)}</td>
                            <td class="${result.statusTBTMobile ? "result_pass" : "result_fail"}">${getRoundedNumber(result.tbtMobile)}</td>      
                           
                            <td class="${result.statusDesktop && result.statusMobile ? "result_pass" : "result_fail"} strong">${result.statusDesktop && result.statusMobile ? "PASS" : "FAIL"}</td>
                        </tr>`
                    tbody.appendChild(tr1)

                    
                })
                createDatatableElement();
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
             
                ${result.status ? `` : `<span data-bs-toggle="modal" data-bs-target="#crossOriginModal${i}" 
                style="cursor: pointer;">List of Links</span>`}
                

                
                <div class="modal custom-modal" id="crossOriginModal${i}">
                <div class="modal-dialog">
                  <div class="modal-content">
                  <!-- Modal Header -->
                    <div class="modal-header">
                     <span class="modal-title">Cross origin links</span>
                     <span  class="tool-test-close close modal-close" data-bs-dismiss="modal">&times;</span>
                    </div>
                 <!-- Modal Body -->
                 <div class="modal-body">
                 <span style="padding-bottom: 10px;" class="analysis-body-css">Below are the links found on this page which qualify as Cross origin links.</span>
                 <div class="modal-table-div">
                 <table class="tool-table">

          <tbody>          
                 ${result.crossOriginLinksData.map((item, index) => `
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
                        <th># of broken links</th>
                        <th>List of broken links</th>
                        <th>Result</th>
                    </tr>
                </thead>`

            results.forEach((result, i)=>{
                const tr = document.createElement("tr")
                tr.innerHTML = `
                <td>${i+1}</td>
                <td class="align-left">${result.tested_url}</td>
                <td class="align-left">${result.status_url ? result.totalBrokenLinks != null ? result.totalBrokenLinks : 0 : "NA"}</td>
                <td class="align-left">${result.status_url ? UI.getBrokenLinks(result.allLinks, false) : result.message}</td>
                <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "PASS" : "FAIL"}<td>`
                tbody.appendChild(tr)
            })
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
                break;
                

            case "viewport":
                table.classList.add("dataTable")
            table.classList.add("custom-dataTable")
            thead = `<thead class="result_data_header">
             <tr>
                <th>#</th>
                <th class="result_header"><span>URL</span>  <img src="/new-assets/assets/images/search.png" alt="icon"></th>
                <th>Meta Viewport Tag Present?</th>
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
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
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
            tableImg.page.len($(this).val()).draw();
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
   
    
})

$(document).on("click",".download-xlsx-bulk",function() {
    let xlsxName = $(this).attr('data-csv') + '.xlsx';
    ToolXlsx.buildXLSX(xlsxName);
});
class ToolXlsx {
    static async buildXLSX(xlsxName) {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet("Sheet1");

        // Clone the table to work with
        const table = $(".test_result_area table").clone()[0];
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



