$(document).ready(function () {
  let seoColspan = 0, performanceColspan = 0, bestPracticesColspan = 0, securityColspan = 0, totalTests = 1, lighthouseStatus = false, testDetailsLighthouse
  var recheckMax = 5, urls, urlsToCheck = 1
  let page, activeOptionsModalUrl, activeOptionsElement, allLabels
  let hiddenColumns = [], urlsList = []
  let firstRow, secondRow, allUrls, recheckAllowed = true, projectId
  let obj = {
    meta_title: [],
    meta_desc: [],
    robots_meta: [],
    canonical_url: [],
    url_slug: [],
    meta_viewport: [],
    doctype: [],
    http_status_code: [],
    favicon: [],
    page_size: [],
    xml_sitemap: [],
    html_sitemap: [],
    images: [],
    broken_links: [],
    open_graph_tags: [],
    twitter_tags: [],
    is_safe_browsing: [],
    cross_origin_links: [],
    protocol_relative_resource: [],
    content_security_policy_header: [],
    x_frame_options_header: [],
    hsts_header: [],
    bad_content_type: [],
    ssl_certificate_enable: [],
    folder_browsing_enable: [],
    html_compression: [],
    css_compression: [],
    js_compression: [],
    gzip_compression: [],
    nested_tables: [],
    frameset: [],
    page_size: [],
    css_caching_enable: [],
    js_caching_enable: [],
    frameset: [],
    google_overall: [],
    google_lighthouse: [],
    core_web_vitals: [],
    mobile_friendly: [],
  }
  var urlOptionsModalEl = document.querySelector("#urlOptionsModal")
  var urlOptionModalOpenStatus = false

  

  class DB{
    static deleteURL(projectId, url){
      return $.ajax({
          url : `/delete-url`,
          type : 'post',
          aysnc: false,
          data: {
              url: url, 
              projectId: projectId,
              "_token": $('meta[name="csrf-token"]').attr('content'),
          },       
          success: function(data) {
          },error: function(data){
            
          }
      });
  }
      static getDashboardShowStatus(projectId){
          return $.ajax({
              url : `/get-show-dashboard-status/${projectId}`,
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


      static getUrlsList(projectId){
        return $.ajax({
            url : `/get-urls/${projectId}`,
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

      static returnData(projectId){
          return $.ajax({
              url : `/get-test-data/${projectId}`,
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
  }

  class UI{
      static deleteURL(){
        activeOptionsElement.remove()
      }


      static updateRecheckButtonState(isDisabled) {
        const recheckBtn = document.querySelector("#recheckBtn")
        const recheckHyperlink = document.querySelector("#recheckHyperlink")
        
        if (recheckBtn) {
          recheckBtn.disabled = isDisabled
          if (isDisabled) {
            recheckBtn.style.opacity = "0.6"
            recheckBtn.style.cursor = "not-allowed"
            recheckBtn.title = "Please wait for current tests to complete before rechecking"
          } else {
            recheckBtn.style.opacity = "1"
            recheckBtn.style.cursor = "pointer"
            recheckBtn.title = "Recheck dashboard"
          }
        }
        
        if (recheckHyperlink) {
          if (isDisabled) {
            recheckHyperlink.style.opacity = "0.6"
            recheckHyperlink.style.cursor = "not-allowed"
            recheckHyperlink.title = "Please wait for current tests to complete before rechecking"
          } else {
            recheckHyperlink.style.opacity = "1"
            recheckHyperlink.style.cursor = "pointer"
            recheckHyperlink.title = "Recheck dashboard"
          }
        }
      }

      static showWaitingMessage(){
        // Remove any existing waiting message first
        this.removeWaitingMessage();
        let msg = "Please wait while we finish the current queue of tests before starting the recheck."
        displayAlert(".analysis-content-body-message", {
          status: 1,
          msg: msg,
          notHide: true
        })
      }

      static buildRecheckLoader(){
        const div = document.createElement("div")
        div.classList.add("main-tricker-progress")
        div.innerHTML = `
                <div class="gif-loader">
                  <img src="/new-assets/assets/images/preloader1.gif" alt="icon">
                </div>
                <div class="single-tricker-progress">
                  <div class="rechecking-page">
                    <span class="primary-span">Recheking pages... <span id="urlRecheckedProgressText">0%</span></span>
                    <span class="dark-span" id="urlRechecked">0</span>
                    <span>/${urls.length}</span>
                  </div>
                  <div class="progress">
                    <div id="urlRecheckedProgressBar" class="progress-bar tricker-progress" role="progressbar" aria-label="Success example" style="width: 0%;" aria-valuenow="70" title="" aria-valuemin="0" aria-valuemax="100"> </div>
                  </div>
                </div>`
        document.querySelector(".dashboard_recheck_area").prepend(div)
      }

      
      static updateCloneTable(){
        const elements = $("#reportTableClone tbody tr td:first-child .form-check-label")  
        const elements2 = $("#reportTableClone .tracker-column-dropdown span")  
        elements.each(i=>{
          let el = elements[i]
          $("#reportTableClone tbody tr td:first-child").html(el.textContent)
        })

        elements2.each(i=>{
          let el = elements2[i]
          el.parentElement.parentElement.innerHTML = el.textContent
        })

        $("#reportTableClone thead .dropdown-toggle, #reportTableClone thead .dropdown-menu, #reportTableClone thead .total-hidden").remove()

      }

      static updateTableDesign(){
        const height = $("#reportTable .table-header-top").height() + 2
        $(".table-header-top td:first-child").css({height: height})          
      }

      static toggleTrackerElements(){
          $(".tracker-container").removeClass("d-none")
      }

      static initTableBody(id){
          let td = document.createElement("tr")
          td.setAttribute("data-type", id)

          return {
              tableBody: td,
              firstTimeStatus: true
          }
      }

      static buildRootURLElement(el){
        const tr = document.createElement("tr")
        tr.classList.add("root-tr")
        tr.classList.add("export-hidden-element")
        tr.setAttribute("data-id", el.id)
        tr.innerHTML = `
          <td scope="row" class="active-table-url2">
            <div class="form-check input-pt-pb">
              <input class="form-check-input" type="checkbox" value="" id="table_input_check13">
              <div class="d-flex align-items-center justify-content-between">
                <label class="form-check-label" for="table_input_check13">
                  <div class="tracker-left-input">
                    <img src="/new-assets/assets/images/tracker-beg.png" alt="icon">
                    <h6 class="mb-0">${el.name}</h6>
                  </div>
                </label>
                <div class="tracker-right-input collapsed">
                  <h5 class="mb-0">${el.urls.length}</h5>
                  <svg class="svg-inline--fa fa-angle-down" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M201.4 374.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 306.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path></svg><!-- <i class="fa-solid fa-angle-down"></i> Font Awesome fontawesome.com -->
                </div>
              </div>
            </div>
        </td>
        `
        for(var i = 0;i < totalTests;i++){
          tr.innerHTML += "<td></td>"
        }

        document.querySelector(".reports-table-body").appendChild(tr)
      }

      static buildRowsTable(nums){
          nums.forEach(num=>{
              const opt = document.createElement("option")
              opt.innerHTML = `${num}`
              opt.setAttribute("value", num)
              document.querySelector("#rowsTable").appendChild(opt)
          })
          const opt = document.createElement("option")
          opt.innerHTML = `All`
          opt.setAttribute("value", nums[nums.length-1])
          document.querySelector("#rowsTable").appendChild(opt)
      }

      static buildRowsTableReports() {
        const options = [10, 30, 50, 100, 500];
        const select = document.querySelector("#rowsTable");
        select.innerHTML = ""; // Clear existing options
    
        options.forEach(optValue => {
            const opt = document.createElement("option");
            opt.innerHTML = optValue;
            opt.setAttribute("value", optValue);
            select.appendChild(opt);
        });
    
        // Add "All" option with value -1
        const allOption = document.createElement("option");
        allOption.innerHTML = "All";
        allOption.setAttribute("value", -1);
        select.appendChild(allOption);
    }

      static initTable(length){
       
          const tdExtra = document.createElement("td")
          tdExtra.setAttribute("scope", "col")
          tdExtra.innerHTML = ``
          tdExtra.setAttribute("colspan", 1)
          document.querySelector(".table-header").appendChild(tdExtra)

          let tr = document.createElement("tr")
          tr.classList.add("th-bg")
          tr.innerHTML = `
                  <th scope="col">
                      <div class="t-search-url">
                        <span>
                          <svg
                            width="11"
                            height="11"
                            viewBox="0 0 11 11"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M4.99995 8.99991C7.20907 8.99991 8.99991 7.20907 8.99991 4.99995C8.99991 2.79084 7.20907 1 4.99995 1C2.79084 1 1 2.79084 1 4.99995C1 7.20907 2.79084 8.99991 4.99995 8.99991Z"
                              stroke="#6E6E6E"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                            <path
                              d="M10.0002 9.9999L7.8252 7.82492"
                              stroke="#6E6E6E"
                              stroke-width="1.2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                          </svg>
                        </span>
                        <input
                          type="search"
                          id="gsearch"
                          name="gsearch"
                          placeholder="Search URL"
                        />
                      </div>
                    </th>
                    <th scope="col">Date Added</th>
          `


          let td = document.createElement("tr")

          return {
              tableHeader: tr,
          }
      }

      static buildTableHeaderTop(displayName, colspan, color){
        const td = document.createElement("td")
        td.setAttribute("scope", "col")
        td.innerHTML = `${displayName}`
        td.setAttribute("colspan", colspan)
        td.style.background = color
        document.querySelector(".table-header-top").appendChild(td)
      }

      static buildPerformanceTableHeader(type){
        let elements;
        switch(type){
          case "google_overall":
            elements = ["Overall Score"]
            break;
          case "google_lighthouse":
            elements =  ["Performance", "Accessiblity", "Best Practices", "SEO"]
            break;
          case "core_web_vitals":
          elements = ["LCP", "FID", "CLS", "FCP", "TTI", "SI", "TBT"];
          break;
          case "mobile_friendly":
            elements =  ["Mobile Friendly"]
            break;
        }

        const tooltipMap = {
            "LCP": "Largest Contentful Paint, Measured in seconds",
            "FID": "First Input Delay, Measured in ms",
            "CLS": "Cumulative Layout Shift",
            "FCP": "First Contentful Paint, Measured in seconds",
            "TTI": "Time to Interactive, Measured in seconds",
            "SI": "Speed Index, Measured in seconds",
            "TBT": "Total Blocking Time, Measured in ms"
        };


        document.querySelectorAll(".table-header td").forEach(cell => {
            const text = cell.innerText.trim();

            if (tooltipMap[text]) {
                cell.classList.add("custom-tooltip-imran");
                cell.setAttribute("data-tooltip", tooltipMap[text]);
            }
        });


        elements.forEach(el=>{
          const td = document.createElement("td")
          td.setAttribute("scope", "col")
          td.innerHTML = el
          if(el === "Mobile Friendly"){
            td.setAttribute("colspan", 1)
          }else{
            td.setAttribute("colspan", 2)
          }
          document.querySelector(".table-header").appendChild(td)
        })
      }

      static buildTableHeader(type, data, colspan, options, settings, title){
        totalTests+=colspan
          Controls.calcColespan(title, colspan)
          let projectSettings = [];
          if(title === "performance"){
            UI.buildPerformanceTableHeader(type)
          }else{
            console.log(data)
            projectSettings = data[0].settings;
            const displayName = data[0].label.display_name
            const td = document.createElement("td")
            td.setAttribute("data-consists", type)
            td.setAttribute("scope", "col")
            td.innerHTML = `${displayName}
            <span class="total-hidden d-none"></span>
            <a class="dropdown-toggle dropdown-toggle-tracker p-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="/new-assets/assets/images/more.png">
            </a>
            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-start-imran">
                <li class='show-hidden-elements'>
                    <a class="dropdown-item hide-column" href="#">Show hidden columns</a>
                </li>
            </ul>
            `
            td.setAttribute("colspan", colspan)
            document.querySelector(".table-header").appendChild(td)
          }
          let tr = options.tableHeader



         
        
          switch(type){
            case "title":
              tr.innerHTML+=``
              if (projectSettings.meta_title == 1) {
              tr.innerHTML+= `<th scope="col" data-name="title" class="text-start tracker-column-dropdown">
                  <a
                      class="dropdown-toggle p-2 dropdown-toggle-tracker-circle"
                      href="#"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                  >
                      <span>Content</span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                        <circle cx="6.93555" cy="6" r="5.5" transform="rotate(-90 6.93555 6)" stroke="#8191B9"/>
                        <g clip-path="url(#clip0_297_566)">
                        <path d="M3.93555 5H9.93555L6.93543 8L3.93555 5Z" fill="#8191B9"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_297_566">
                        <rect width="6" height="3" fill="white" transform="translate(3.93555 5)"/>
                        </clipPath>
                        </defs>
                      </svg>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-start-two">
                      <li>
                          <a class="dropdown-item hide-column" href="#">Hide column</a>
                      </li>
                      <li>
                          <a class="dropdown-item right-shift" href="#">Shift right</a>
                      </li>
                      <li>
                          <a class="dropdown-item left-shift" href="#">Shift left</a>
                      </li>
                  </ul>
              </th>`
              }
              if (projectSettings.max_title_length == 1) {
                tr.innerHTML+= `
              <th scope="col" data-name="title" class="tracker-column-dropdown">
                  <a class="dropdown-toggle p-2 dropdown-toggle-tracker-circle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <span>Length</span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                        <circle cx="6.93555" cy="6" r="5.5" transform="rotate(-90 6.93555 6)" stroke="#8191B9"/>
                        <g clip-path="url(#clip0_297_566)">
                        <path d="M3.93555 5H9.93555L6.93543 8L3.93555 5Z" fill="#8191B9"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_297_566">
                        <rect width="6" height="3" fill="white" transform="translate(3.93555 5)"/>
                        </clipPath>
                        </defs>
                      </svg>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-start-two">
                      <li><a class="dropdown-item hide-column" href="#">Hide column</a></li>
                      <li><a class="dropdown-item right-shift" href="#">Shift right</a></li>
                      <li><a class="dropdown-item left-shift" href="#">Shift left</a></li>
                  </ul>
              </th>
                `;
            }
            
            if (projectSettings.is_title_equal_h1 == 1) {
            tr.innerHTML +=  `<th scope="col" data-name="title" class="${settings.is_title_equal_h1 ? "" : "hidden-element-tracker"} tracker-column-dropdown">
                  <a class="dropdown-toggle p-2 dropdown-toggle-tracker-circle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <span>Title Equal to H1?</span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                        <circle cx="6.93555" cy="6" r="5.5" transform="rotate(-90 6.93555 6)" stroke="#8191B9"/>
                        <g clip-path="url(#clip0_297_566)">
                        <path d="M3.93555 5H9.93555L6.93543 8L3.93555 5Z" fill="#8191B9"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_297_566">
                        <rect width="6" height="3" fill="white" transform="translate(3.93555 5)"/>
                        </clipPath>
                        </defs>
                      </svg>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-start-two">
                      <li><a class="dropdown-item hide-column" href="#">Hide column</a></li>
                      <li><a class="dropdown-item right-shift" href="#">Shift right</a></li>
                      <li><a class="dropdown-item left-shift" href="#">Shift left</a></li>
                  </ul>
              </th>`
            }
            if (projectSettings.title_casing_both == 1 || projectSettings.title_casing_camel == 1 || projectSettings.title_casing_sentence == 1) {
              tr.innerHTML +=  `<th scope="col" data-name="title" class="${settings.title_casing_both || settings.title_casing_camel || settings.title_casing_sentence ? "" : "hidden-element-tracker"} tracker-column-dropdown">
                  <a class="dropdown-toggle p-2 dropdown-toggle-tracker-circle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <span>Casing</span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                        <circle cx="6.93555" cy="6" r="5.5" transform="rotate(-90 6.93555 6)" stroke="#8191B9"/>
                        <g clip-path="url(#clip0_297_566)">
                        <path d="M3.93555 5H9.93555L6.93543 8L3.93555 5Z" fill="#8191B9"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_297_566">
                        <rect width="6" height="3" fill="white" transform="translate(3.93555 5)"/>
                        </clipPath>
                        </defs>
                      </svg>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-start-two">
                      <li><a class="dropdown-item hide-column" href="#">Hide column</a></li>
                      <li><a class="dropdown-item right-shift" href="#">Shift right</a></li>
                      <li><a class="dropdown-item left-shift" href="#">Shift left</a></li>
                  </ul>
              </th>` 
            }
              break;
              case "description":
                  tr.innerHTML+=`
                  <th class="text-start">Content</th>
                  <th class="${settings.max_desc_length || settings.min_desc_length ? "" : "hidden-element-tracker"}">Length</th>
                  `
                  break;
              case "robots":
                  tr.innerHTML+= `
                  <th class="${settings.live_urls_robots_meta? "" : "hidden-element-tracker"}">Robots Tag Exists</th>
                  <th>Content</th>
                  `
                  break;
              case "canonical":
                  tr.innerHTML+= `
                  <th class="text-start">Canonical URL</th>
                  <th class="${settings.canonical_url_equal_url ? "" : "hidden-element-tracker"}">Equal to Actual URL?</th>
                  `
                  break;
                case "url_slug":
                  tr.innerHTML += `<th>Slug</th>`;
                  if (projectSettings.max_url_length == 1 || projectSettings.min_url_length == 1) {
                    tr.innerHTML += `<th>LEN</th>`;
                  }
                  
                  if (projectSettings.url_no_numbers == 1) {
                      tr.innerHTML += `<th>Has Numbers?</th>`;
                  }
                  
                  if (projectSettings.url_no_special == 1) {
                      tr.innerHTML += `<th>Has Special Characters?</th>`;
                  }
                  
                  if (projectSettings.url_slug_lowercase == 1) {
                      tr.innerHTML += `<th>Has Uppercase Characters?</th>`;
                  }
          
                  if (projectSettings.url_casing_only_hyphens == 1) {
                      tr.innerHTML += `<th>Words Separated By Hyphens Only?</th>`;
                  }
                  
                  if (projectSettings.url_casing_only_underscores == 1) {
                      tr.innerHTML += `<th>Words Separated By Underscores Only?</th>`;
                  }
                  
                  if (projectSettings.url_stop_words == 1) {
                      tr.innerHTML += `<th>Contains Stop Words?</th>`;
                  }
                  break;
                  case "images":
                    tr.innerHTML+= `
                    <th class="text-start">Image Link</th>
                    <th class="${settings.image_alt ? "" : "hidden-element-tracker"}">Alternate Text</th>
                    <th class="${settings.image_alt_only_spaces ? "" : "hidden-element-tracker"}">Words separated by spaces?</th>
                    <th class="">File name</th>
                    <th class="${settings.image_name_max_characters ? "" : "hidden-element-tracker"}">LEN</th>
                    <th class="${settings.image_name_only_hyphens ? "" : "hidden-element-tracker"}">Words separated by hyphens?</th>
                    <th class="${settings.image_name_no_uppercase ? "" : "hidden-element-tracker"}">Uppercase characters?</th>
                    <th class="${settings.image_name_no_special ? "" : "hidden-element-tracker"}">Special characters?</th>
                    <th class="${settings.image_max_size ? "" : "hidden-element-tracker"}">File Size</th>
                    <th>Result</th>
                  `
                  break;
                case "favicon":
                  tr.innerHTML+= `
                  <th class="text-start">Favicon Image URL</th>`
                  break;
                case "meta_viewport":
                  tr.innerHTML+= `
                  <th>Viewport tag exists?</th>`
                  break;
                case "doctype":
                  tr.innerHTML+= `
                  <th>Doctype tag exists?</th>`
                  break;
                case "http_status_code":
                  tr.innerHTML+= `
                  <th></th>`
                  break;
                case "open_graph_tags":
                  tr.innerHTML+= `
                  <th class="text-start">Open Graph Title</th>
                  <th class="${settings.max_og_title_length || settings.min_og_title_length ? "" : "hidden-element-tracker"}">LEN</th>
                  <th class="${settings.og_title_casing_both || settings.og_title_casing_camel || settings.og_title_casing_sentence ? "" : "hidden-element-tracker"}">Casing</th>
                  <th class="${settings.is_og_title_equal_title ? "" : "hidden-element-tracker"}">Open Graph Title Equal to title?</th>
                  <th class="text-start">Open Graph Description</th>
                  <th class="${settings.max_og_desc_length || settings.min_og_desc_length ? "" : "hidden-element-tracker"}">LEN</th>
                  <th class="${settings.is_og_desc_equal_desc ? "" : "hidden-element-tracker"}">Open Graph Description Equal to meta desciption?</th>
                  <th class="text-start">Open Graph Image</th>
                  <th class="${settings.og_image_dimensions_min || settings.og_image_dimensions_exact ? "" : "hidden-element-tracker"}">Width, Height</th>
                  <th class="text-start">Open Graph URL</th>
                  <th class="${settings.max_og_url_length ? "" : "hidden-element-tracker"}">LEN</th>
                  <th class="${settings.is_og_url_equal_url ? "" : "hidden-element-tracker"}">Open Graph URL Equal to the actual url?</th>
                  `
                  break;
                case "twitter_tags":
                  tr.innerHTML+= `
                  <th class="text-start">Twitter Title</th>
                  <th class="${settings.max_twitter_title_length || settings.min_twitter_title_length ? "" : "hidden-element-tracker"}">LEN</th>
                  <th class="${settings.twitter_title_casing_both || settings.twitter_title_casing_camel || settings.twitter_title_casing_sentence ? "" : "hidden-element-tracker"}">Casing</th>
                  <th class="${settings.is_twitter_title_equal_title ? "" : "hidden-element-tracker"}">Twitter Title Equal to Meta title?</th>
                  <th class="text-start">Twitter Image</th>
                  <th class="${settings.twitter_image_dimensions_min || settings.twitter_image_dimensions_exact ? "" : "hidden-element-tracker"}">Width, Height</th>
                  <th class="text-start">Twitter Image Alt</th>
                  <th class="${settings.max_twitter_image_alt_length ? "" : "hidden-element-tracker"}">LEN</th>
                  `
                  break;


                  case "google_overall":
                    tr.innerHTML+=`
                    <th>Desktop</th>
                    <th>Mobile</th>
                    `
                    break;
                  case "google_lighthouse":
                    tr.innerHTML+=`
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    <th>Desktop</th>
                    <th>Mobile</th>
                    `
                    break;
                  case "core_web_vitals":
                    tr.innerHTML+=`
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
                    `
                    break;
                  case "mobile_friendly":
                    tr.innerHTML+=`
                    <th>Mobile Friendly</th>
                    `
                    break;
                  
                  
                  case "gzip_compression":
                    tr.innerHTML+=`
                    <th>Gzip Compression</th>
                    `
                    break;
                  case "html_compression":
                    tr.innerHTML+=`
                    <th>HTML Compression</th>
                    `
                    break;
                  case "css_compression":
                    tr.innerHTML+=`
                    <th>CSS Compression</th>
                    `
                    break;
                  case "js_compression":
                    tr.innerHTML+=`
                    <th>JS Compression</th>
                    `
                    break;
                  case "css_caching_enable":
                    tr.innerHTML+=`
                    <th>CSS Caching</th>
                    `
                    break;
                  case "js_caching_enable":
                    tr.innerHTML+=`
                    <th>JS Caching</th>
                    `
                    break;
                  case "page_size":
                    tr.innerHTML+=`
                    <th>Page Size</th>
                    `
                    break;
                  case "nested_tables":
                    tr.innerHTML+=`
                    <th>Nested Tables</th>
                    `
                    break;
                  case "frameset":
                    tr.innerHTML+=`
                    <th>Frameset</th>
                    `
                    break;
                    
                  
                  case "is_safe_browsing":
                    tr.innerHTML+=`
                    <th>Safe Browsing</th>
                    `
                    break;
                  case "cross_origin_links":
                    tr.innerHTML+=`
                    <th>Cross Origin Links</th>
                    `
                    break;
                  case "protocol_relative_resource":
                    tr.innerHTML+=`
                    <th>Protocol Relative Resource</th>
                    `
                    break;
                  case "content_security_policy_header":
                    tr.innerHTML+=`
                    <th>Content Security Policy Header</th>
                    `
                    break;
                  case "x_frame_options_header":
                    tr.innerHTML+=`
                    <th>X Frame Options Header</th>
                    `
                    break;
                  case "hsts_header":
                    tr.innerHTML+=`
                    <th>HSTS Header</th>
                    `
                    break;
                  case "bad_content_type":
                    tr.innerHTML+=`
                    <th>Bad content Type</th>
                    `
                    break;
                  case "ssl_certificate_enable":
                    tr.innerHTML+=`
                    <th>SSL Certificate</th>
                    `
                    break;
                  case "folder_browsing_enable":
                    tr.innerHTML+=`
                    <th>Folder Browsing</th>
                    `
                    break;

              }

     
          document.querySelector(".reports-table-header").appendChild(tr)


          options.tableHeader = tr
          return options
      }

      static buildTableBodyImages(prob, id, type, result, options, url, settings, seo, dataSetting = null, index) {
        const { DateTime } = luxon;
        const projectSettings = dataSetting ? dataSetting[0].project_settings : null;
        let time = new DateTime.fromSeconds(parseInt(result.tested_at));
        time = time.toLocaleString({ day: 'numeric', month: 'long', year: 'numeric' });
    
        let td = options.tableBody;
    
        if (options.firstTimeStatus && index === 0) { // Only add for the first row
            td.innerHTML += `
            <td scope="row">
                <div class="form-check input-pt-pb">
                    <input class="form-check-input" type="checkbox" value=""/>
                    <label class="form-check-label">${url}</label>
                </div>
                <button class="dropdown-toggle show-url-options-modal" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                    </svg>
                </button>
            </td>
            <td>${time}</td>`;
        } else {
          td.innerHTML += `<td style="display: list-item;"></td><td></td>`;
        }
    
        switch (type) {
            case "images":
                td.innerHTML += `
                <td class=""><a href="${prob.imageSrc}" target="_blank"><span>Link</span>
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.3333 5.33333C11.1565 5.33333 10.987 5.40357 10.8619 5.5286C10.7369 5.65362 10.6667 5.82319 10.6667 6V10C10.6667 10.1768 10.5964 10.3464 10.4714 10.4714C10.3464 10.5964 10.1768 10.6667 10 10.6667H2C1.82319 10.6667 1.65362 10.5964 1.5286 10.4714C1.40357 10.3464 1.33333 10.1768 1.33333 10V2C1.33333 1.82319 1.40357 1.65362 1.5286 1.5286C1.65362 1.40357 1.82319 1.33333 2 1.33333H6C6.17681 1.33333 6.34638 1.2631 6.4714 1.13807C6.59643 1.01305 6.66667 0.843478 6.66667 0.666667C6.66667 0.489856 6.59643 0.320286 6.4714 0.195262C6.34638 0.0702379 6.17681 0 6 0H2C1.46957 0 0.960859 0.210714 0.585787 0.585787C0.210714 0.960859 0 1.46957 0 2V10C0 10.5304 0.210714 11.0391 0.585787 11.4142C0.960859 11.7893 1.46957 12 2 12H10C10.5304 12 11.0391 11.7893 11.4142 11.4142C11.7893 11.0391 12 10.5304 12 10V6C12 5.82319 11.9298 5.65362 11.8047 5.5286C11.6797 5.40357 11.5101 5.33333 11.3333 5.33333Z" fill="#1E63B8"></path>
                             <path d="M8.66728 1.33333H9.72061L5.52728 5.52C5.46479 5.58198 5.4152 5.65571 5.38135 5.73695C5.3475 5.81819 5.33008 5.90533 5.33008 5.99333C5.33008 6.08134 5.3475 6.16848 5.38135 6.24972C5.4152 6.33096 5.46479 6.40469 5.52728 6.46667C5.58925 6.52915 5.66299 6.57875 5.74423 6.61259C5.82547 6.64644 5.9126 6.66387 6.00061 6.66387C6.08862 6.66387 6.17576 6.64644 6.25699 6.61259C6.33823 6.57875 6.41197 6.52915 6.47394 6.46667L10.6673 2.28V3.33333C10.6673 3.51014 10.7375 3.67971 10.8625 3.80474C10.9876 3.92976 11.1571 4 11.3339 4C11.5108 4 11.6803 3.92976 11.8053 3.80474C11.9304 3.67971 12.0006 3.51014 12.0006 3.33333V0.666667C12.0006 0.489856 11.9304 0.320286 11.8053 0.195262C11.6803 0.0702379 11.5108 0 11.3339 0H8.66728C8.49047 0 8.3209 0.0702379 8.19587 0.195262C8.07085 0.320286 8.00061 0.489856 8.00061 0.666667C8.00061 0.843478 8.07085 1.01305 8.19587 1.13807C8.3209 1.2631 8.49047 1.33333 8.66728 1.33333Z" fill="#1E63B8"></path>
                         </svg>
                </a></td>
                <td class="text-start">${prob.imageAlt}</td>
                <td class="${prob.imageAltSpacesClass}">${prob.imageAltSpacesStatus ? "<span style='color: green;'>Yes</span>" : "<span style='color: red;'>No</span>"}</td>
                <td class="text-start">${prob.imageName}</td>
                <td class="${prob.imageLengthClass}">${prob.imageLengthStatus ? prob.imageName.length : "-"}</td>
                <td class="${prob.imageHyphenClass}">${prob.imageHyphenStatus ? "<span style='color: green;'>Yes</span>" : "<span style='color: red;'>No</span>"}</td>
                <td class="${prob.imageUppercaseClass}">${prob.imageUppercaseStatus ? "<span style='color: red;'>Yes</span>" : "<span style='color: green;'>No</span>"}</td>
                <td class="${prob.imageSpecialClass}">${prob.imageSpecialStatus ? "<span style='color: red;'>Yes</span>" : "<span style='color: green;'>No</span>"}</td>
                <td class="${prob.imageSizeClass}">${prob.imageSizeValue}</td>
                <td class="${prob.status ? "result_pass" : "result_fail"}">${prob.status ? "PASS" : "FAIL"}</td>`;
                break;
        }
    
        document.querySelector(".reports-table-body").appendChild(td);
    
        options.tableBody = td;
        options.firstTimeStatus = false;
        return options;
    }

      static buildTableBody(id, type, result, options, url, settings, seo, dataSetting=null){
        const ignore_tests = ["google_overall", "google_lighthouse", "core_web_vitals"]
        let time
        const { DateTime } = luxon;
        const projectSettings = dataSetting ? dataSetting[0].settings : null;

        if(window.location.href.includes("/reports")){
          if(!result){
            return
          }
        }

        if(result){
          if(ignore_tests.includes(type)){
            time = "2025-03-28 08:08:23"
          }else{
            time = new DateTime.fromSeconds(parseInt(result.tested_at))
          }
        }else{
          time = ""
        }
        time = time.toLocaleString({day: 'numeric', month: 'long', year: 'numeric'});
          let td = options.tableBody
          if(options.firstTimeStatus){
              td.innerHTML+=`
              <td scope="row">
              <div class="form-check input-pt-pb">
                <input
                  class="form-check-input"
                  type="checkbox"
                  value=""
                />
                <label class="form-check-label">
                  ${url}
                </label>
              </div>
              <button class="dropdown-toggle show-url-options-modal" type="button">
              <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="currentColor"
              >
              <path
                d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"
              ></path>
              </svg>
            </button>
            </td>
            <td>${time}</td>
              `
          }
          

              switch(type){
                 case "title":
                     if (!result) {
                       if (projectSettings && projectSettings.meta_title == 1) {  
                         td.innerHTML+=`<td class="text-start"></td>`;
                       }
                       if (projectSettings && projectSettings.max_title_length == 1) {
                         td.innerHTML+=`<td class="${settings.max_title_length || settings.min_title_length ? "" : "hidden-element-tracker"}"></td>`;
                       }
                       if (projectSettings && projectSettings.is_title_equal_h1 == 1) {
                         td.innerHTML+= `<td class="${settings.is_title_equal_h1 ? "" : "hidden-element-tracker"}"></td>`;
                       }
                       if (projectSettings && (projectSettings.title_casing_both == 1 || projectSettings.title_casing_camel == 1 || projectSettings.title_casing_sentence == 1)) {
                         td.innerHTML+=`<td class="${settings.title_casing_both || settings.title_casing_camel || settings.title_casing_sentence ? "" : "hidden-element-tracker"}"></td>`;
                       }
                       break;
                     }
                     td.innerHTML+=``
                     
                     if (projectSettings.meta_title == 1) {  
                     td.innerHTML+=`<td class="text-start">${result.content != null ? result.content : "-"}</td>`
                     }
                   if (projectSettings.max_title_length == 1) {
                     td.innerHTML+=`<td class="${result.lengthClass} ${settings.max_title_length || settings.min_title_length ? "" : "hidden-element-tracker"}">${result.content != null ? result.content.length : 0}</td>`
                   }
                   if (projectSettings.is_title_equal_h1 == 1) {
                     td.innerHTML+= `<td class="${settings.is_title_equal_h1 ? "" : "hidden-element-tracker"}">No</td>`
                   }
                   
                   if (projectSettings.title_casing_both == 1 || result.project_settings.title_casing_camel == 1 || result.project_settings.title_casing_sentence == 1) {
                   td.innerHTML+=`<td class="${result.casingClass} ${settings.title_casing_both || settings.title_casing_camel || settings.title_casing_sentence ? "" : "hidden-element-tracker"}">${result.casing ? result.casing : "-"}</td>
                     `
                   }
                     break;
                 case "description":
                     if (!result) {
                       td.innerHTML+=`
                       <td></td>
                       <td class="${settings.max_desc_length || settings.min_desc_length ? "" : "hidden-element-tracker"}"></td>
                       `;
                       break;
                     }
                     td.innerHTML+=`
                     <td>${result.content != null ? result.content : "-"}</td>
                     <td class="${result.lengthClass} ${settings.max_desc_length || settings.min_desc_length ? "" : "hidden-element-tracker"}">${result.content != null ? result.content.length : 0}</td>
                     `
                     break;
                 case "robots":
                     if (!result) {
                       td.innerHTML+=`
                       <td></td>
                       <td></td>
                       `;
                       break;
                     }
                     td.innerHTML+=`
                     <td class="${result.isExists ? "result_fail" : "result_pass"}">${result.isExists ? "Yes" : "No"}</td>
                     <td class="">${result.content != null && result.content != "" ? result.content : "-"}</td>
                     `
                     break;
                 case "canonical":
                     if (!result) {
                       td.innerHTML+=`
                       <td class="text-start"></td>
                       <td class="${settings.canonical_url_equal_url ? "" : "hidden-element-tracker"}"></td>
                       `;
                       break;
                     }
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
                      td.innerHTML+=`
                      <td class="text-start">${result.content != null ? result.content : "-"}</td>
                      <td class="${settings.canonical_url_equal_url ? "" : "hidden-element-tracker"} ${result.statusIsEqualURL || result.statusIsEqualURL === null ? "result_pass" : "result_fail"}">${msg}</td>
                      `
                      break;
                    case "url_slug":
                      if (!result) {
                        td.innerHTML += `<td></td>`;

                        if (projectSettings && (projectSettings.max_url_length == 1 || projectSettings.min_url_length == 1)) {
                          td.innerHTML += `<td class="${settings.max_url_length || settings.min_url_length ? "" : "hidden-element-tracker"}"></td>`;
                        }

                        if (projectSettings && projectSettings.url_no_numbers == 1) {
                            td.innerHTML += `<td></td>`;
                        }

                        if (projectSettings && projectSettings.url_no_special == 1) {
                            td.innerHTML += `<td></td>`;
                        }

                        if (projectSettings && projectSettings.url_slug_lowercase == 1) {
                            td.innerHTML += `<td></td>`;
                        }

                        if (projectSettings && projectSettings.url_casing_only_hyphens == 1) {
                            td.innerHTML += `<td></td>`;
                        }

                        if (projectSettings && projectSettings.url_casing_only_underscores == 1) {
                            td.innerHTML += `<td></td>`;
                        }

                        if (projectSettings && projectSettings.url_stop_words == 1) {
                            td.innerHTML += `<td></td>`;
                        }
                        break;
                      }
                      td.innerHTML += `
                      <td class="amitBannerJi">${result.content != null ? result.content : "-"}</td>`;

                      if (projectSettings.max_url_length == 1 || projectSettings.min_url_length == 1) {
                        td.innerHTML +=  `<td class="${result.lengthClass} ${settings.max_url_length || settings.min_url_length ? "" : "hidden-element-tracker"}">
                                ${result.content != null ? result.content.length : 0}
                            </td>
                        `;
                      }

                        if (projectSettings.url_no_numbers == 1) {
                            td.innerHTML += `
                                <td class="${result.statusNumbers ? "result_pass" : "result_fail"}">${result.statusNumbers ? "No" : "Yes"}</td>
                            `;
                        }

                        if (projectSettings.url_no_special == 1) {
                            td.innerHTML += `
                                <td class="${result.statusSpecial ? "result_pass" : "result_fail"}">${result.statusSpecial ? "No" : "Yes"}</td>
                            `;
                        }

                        if (projectSettings.url_slug_lowercase == 1) {
                            td.innerHTML += `
                                <td class="${result.statusLowercase ? "result_pass" : "result_fail"}">${result.statusLowercase ? "No" : "Yes"}</td>
                            `;
                        }

                        if (projectSettings.url_casing_only_hyphens == 1) {
                            td.innerHTML += `
                                <td class="${result.statusHyphens ? "result_pass" : "result_fail"}">
                                    ${!isSingleWord(result.content) ? result.statusHyphens ? "Yes" : "No" : "-"}
                                </td>
                            `;
                        }

                        if (projectSettings.url_casing_only_underscores == 1) {
                            td.innerHTML += `
                                <td class="${result.statusUnderscore ? "result_pass" : "result_fail"}">${result.statusUnderscore ? "Yes" : "No"}</td>
                            `;
                        }

                        if (projectSettings.url_stop_words == 1) {
                            td.innerHTML += `
                                <td class="${result.statusStopWords ? "result_pass" : "result_fail"}">${result.statusStopWords ? "No" : "Yes"}</td>
                            `;
                        }
                     break;
                    // case "images":
                    //   result.problems.forEach((prob, z)=>{
                    //     td.innerHTML += `
                    //     <td class=""><a href="${prob.imageSrc}" target="_blank"><span>Link1</span>
                    //     <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    //         <path d="M11.3333 5.33333C11.1565 5.33333 10.987 5.40357 10.8619 5.5286C10.7369 5.65362 10.6667 5.82319 10.6667 6V10C10.6667 10.1768 10.5964 10.3464 10.4714 10.4714C10.3464 10.5964 10.1768 10.6667 10 10.6667H2C1.82319 10.6667 1.65362 10.5964 1.5286 10.4714C1.40357 10.3464 1.33333 10.1768 1.33333 10V2C1.33333 1.82319 1.40357 1.65362 1.5286 1.5286C1.65362 1.40357 1.82319 1.33333 2 1.33333H6C6.17681 1.33333 6.34638 1.2631 6.4714 1.13807C6.59643 1.01305 6.66667 0.843478 6.66667 0.666667C6.66667 0.489856 6.59643 0.320286 6.4714 0.195262C6.34638 0.0702379 6.17681 0 6 0H2C1.46957 0 0.960859 0.210714 0.585787 0.585787C0.210714 0.960859 0 1.46957 0 2V10C0 10.5304 0.210714 11.0391 0.585787 11.4142C0.960859 11.7893 1.46957 12 2 12H10C10.5304 12 11.0391 11.7893 11.4142 11.4142C11.7893 11.0391 12 10.5304 12 10V6C12 5.82319 11.9298 5.65362 11.8047 5.5286C11.6797 5.40357 11.5101 5.33333 11.3333 5.33333Z" fill="#1E63B8"></path>
                    //         <path d="M8.66728 1.33333H9.72061L5.52728 5.52C5.46479 5.58198 5.4152 5.65571 5.38135 5.73695C5.3475 5.81819 5.33008 5.90533 5.33008 5.99333C5.33008 6.08134 5.3475 6.16848 5.38135 6.24972C5.4152 6.33096 5.46479 6.40469 5.52728 6.46667C5.58925 6.52915 5.66299 6.57875 5.74423 6.61259C5.82547 6.64644 5.9126 6.66387 6.00061 6.66387C6.08862 6.66387 6.17576 6.64644 6.25699 6.61259C6.33823 6.57875 6.41197 6.52915 6.47394 6.46667L10.6673 2.28V3.33333C10.6673 3.51014 10.7375 3.67971 10.8625 3.80474C10.9876 3.92976 11.1571 4 11.3339 4C11.5108 4 11.6803 3.92976 11.8053 3.80474C11.9304 3.67971 12.0006 3.51014 12.0006 3.33333V0.666667C12.0006 0.489856 11.9304 0.320286 11.8053 0.195262C11.6803 0.0702379 11.5108 0 11.3339 0H8.66728C8.49047 0 8.3209 0.0702379 8.19587 0.195262C8.07085 0.320286 8.00061 0.489856 8.00061 0.666667C8.00061 0.843478 8.07085 1.01305 8.19587 1.13807C8.3209 1.2631 8.49047 1.33333 8.66728 1.33333Z" fill="#1E63B8"></path>
                    //     </svg> </a></td>
                    //     <td class="align-left ${settings.image_alt ? "" : "d-none hidden-element"}">${prob.imageAlt}</td>
                    //     <td class="${prob.imageAltSpacesClass} ${settings.image_alt_only_spaces ? "" : "d-none hidden-element"}">${prob.imageAltSpacesStatus ? "<span style='color: green;'>Yes</span>" : "<span style='color: red;'>No</span>"}</td>
                    //     <td class="align-left">${prob.imageName}</td>
                    //     <td class="${prob.imageLengthClass} ${settings.image_name_max_characters ? "" : "d-none hidden-element"}">${prob.imageLengthStatus ? prob.imageName.length : "-"}</td>
                    //     <td class="${prob.imageHyphenClass} ${settings.image_name_only_hyphens ? "" : "d-none hidden-element"}">${prob.imageHyphenStatus ? "<span style='color: green;'>Yes</span>" : "<span style='color: red;'>No</span>"}</td>
                    //     <td class="${prob.imageUppercaseClass} ${settings.image_name_no_uppercase ? "" : "d-none hidden-element"}">${prob.imageUppercaseStatus ? "<span style='color: red;'>Yes</span>" : "<span style='color: green;'>No</span>"}</td>
                    //     <td class="${prob.imageSpecialClass} ${settings.image_name_no_special ? "" : "d-none hidden-element"}">${prob.imageSpecialStatus ? "<span style='color: red;'>Yes</span>" : "<span style='color: green;'>No</span>"}</td>
                    //     <td class="${prob.imageSizeClass} ${settings.image_max_size ? "" : "d-none hidden-element"}">${prob.imageSizeValue}</td>
                    //     <td class="${prob.status ? "result_pass" : "result_fail"}">${prob.status ? "PASS" : "FAIL"}</td></tr>`
                    //     // tbody.appendChild(tr)
                    // })
                    //   break;
                  case "favicon":
                      if (!result) {
                        td.innerHTML+=`
                        <td class="text-start"></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="text-start"><a href="${result.content}" target="_blank">${result.content}</a></td>
                      `
                      break;
                     case "meta_viewport":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.isExists ? "result_pass" : "result_fail"}"> ${result.isExists ? "Yes" : "No"}</td>
                      `
                      break;
                     case "doctype":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.isExists ? "result_pass" : "result_fail"}">${result.isExists ? "Yes" : "No"}</td>
                      `
                      break;
                    case "http_status_code":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      const acceptedCodes = projectSettings.http_status_code_accepted.split(',').map(Number);
                      const tdClass = acceptedCodes.includes(result.httpCode) ? "result_pass" : "result_fail";
                      td.innerHTML+=`
                      <td class="${tdClass}">${result.httpCode} - ${result.httpCodeName}</td>
                      `
                      break;
                    case "open_graph_tags":
                      if (!result) {
                        td.innerHTML+=`
                        <td class="align-left"></td>
                        <td class="${settings.max_og_title_length || settings.min_og_title_length ? "" : "hidden-element-tracker"}"></td>
                        <td class="${settings.og_title_casing_both || settings.og_title_casing_camel || settings.og_title_casing_sentence ? "" : "hidden-element-tracker"}"></td>
                        <td class="${settings.is_og_title_equal_title ? "" : "hidden-element-tracker"}"></td>
                        <td class="align-left"></td>
                        <td class="${settings.max_og_desc_length || settings.min_og_desc_length ? "" : "hidden-element-tracker"}"></td>
                        <td class="${settings.is_og_desc_equal_desc ? "" : "hidden-element-tracker"}"></td>
                        <td class="align-left"></td>
                        <td class="${settings.og_image_dimensions_min || settings.og_image_dimensions_exact ? "" : "hidden-element-tracker"}"></td>
                        <td class="align-left"></td>
                        <td class="${settings.max_og_url_length ? "" : "hidden-element-tracker"}"></td>
                        <td class="${settings.is_og_url_equal_url ? "" : "hidden-element-tracker"}"></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="align-left">${result.content != null ? result.content : "Open Graph Title does not exist."}</td>
                      <td class="${result.lengthClass} ${settings.max_og_title_length || settings.min_og_title_length ? "" : "hidden-element-tracker"}">${result.content != null ? result.content.length : 0}</td>
                      <td class="${result.casingClass} ${settings.og_title_casing_both || settings.og_title_casing_camel || settings.og_title_casing_sentence ? "" : "hidden-element-tracker"}">${result.casing ? result.casing : "-"}</td>
                      <td class="${result.isEqualClass} ${settings.is_og_title_equal_title ? "" : "hidden-element-tracker"}">${result.isEqualStatus ? "Yes" : "No"}</td>
                      <td class="align-left">${result.contentDesc != null ? result.contentDesc : "Open Graph Description does not exist."}</td>
                      <td class="${result.lengthDescClass} ${settings.max_og_desc_length || settings.min_og_desc_length ? "" : "hidden-element-tracker"}">${result.contentDesc != null ? result.contentDesc.length : 0}</td>
                      <td class="${result.isEqualDescClass} ${settings.is_og_desc_equal_desc ? "" : "hidden-element-tracker"}">${result.isEqualDescStatus ? "Yes" : "No"}</td>
                      <td class="align-left">${result.contentImage != null && result.contentImage != "" ? result.contentImage : "Open Graph Image does not exist."}</td>
                      <td class="${settings.og_image_dimensions_min || settings.og_image_dimensions_exact ? "" : "hidden-element-tracker"}"><span class="${result.widthImageClass}">${result.dimensions != null ? result.dimensions.w : "-"}</span>, <span class="${result.heightImageClass}">${result.dimensions != null ? result.dimensions.h : ""}</span></td>
                      <td class="align-left">${result.contentURL != null && result.contentURL != "" ? result.contentURL : "Open Graph URL does not exist."}</td>
                      <td class="${result.lengthURLClass} ${settings.max_og_url_length ? "" : "hidden-element-tracker"}">${result.contentURL != null ? result.contentURL.length : 0}</td>
                      <td class="${result.isEqualURLClass} ${settings.is_og_url_equal_url ? "" : "hidden-element-tracker"}">${result.isEqualURLStatus ? "Yes" : "No"}</td>
                      `
                      break;
                    case "twitter_tags":
                      if (!result) {
                        td.innerHTML+=`
                        <td class="align-left"></td>
                        <td class="${settings.max_twitter_title_length || settings.min_twitter_title_length ? "" : "hidden-element-tracker"}"></td>
                        <td class="${settings.twitter_title_casing_both || settings.twitter_title_casing_camel || settings.twitter_title_casing_sentence ? "" : "hidden-element-tracker"}"></td>
                        <td class="${settings.is_twitter_title_equal_title ? "" : "hidden-element-tracker"}"></td>
                        <td class="align-left"></td>
                        <td class="${settings.twitter_image_dimensions_min || settings.twitter_image_dimensions_exact ? "" : "hidden-element-tracker"}"></td>
                        <td class="align-left"></td>
                        <td class="${settings.max_twitter_image_alt_length ? "" : "hidden-element-tracker"}"></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="align-left">${result.content != null ? result.content : "Twitter Title does not exist."}</td>
                      <td class="${result.lengthClass} ${settings.max_twitter_title_length || settings.min_twitter_title_length ? "" : "hidden-element-tracker"}">${result.content != null ? result.content.length : 0}</td>
                      <td class="${result.casingClass} ${settings.twitter_title_casing_both || settings.twitter_title_casing_camel || settings.twitter_title_casing_sentence ? "" : "hidden-element-tracker"}">${result.casing ? result.casing : "-"}</td>
                      <td class="${result.isEqualClass} ${settings.is_twitter_title_equal_title ? "" : "hidden-element-tracker"}">${result.isEqualStatus ? "Yes" : "No"}</td>
                      <td class="align-left">${result.contentImage != null && result.contentImage != "" ? result.contentImage : "Twitter Image does not exist."}</td>
                      <td class="${settings.twitter_image_dimensions_min || settings.twitter_image_dimensions_exact ? "" : "hidden-element-tracker"}"><span class="${result.widthImageClass}">${result.dimensions != null ? result.dimensions.w : "-"}</span>, <span class="${result.heightImageClass}">${result.dimensions != null ? result.dimensions.h : ""}</span></td>
                      <td class="align-left">${result.contentImageAlt != null && result.contentImageAlt != "" ? result.contentImageAlt : "Twitter Image Alt does not exist."}</td>
                      <td class="${result.lengthImageAltClass} ${settings.max_twitter_image_alt_length ? "" : "hidden-element-tracker"}">${result.contentImageAlt ? result.contentImageAlt.length : 0}</td>
                      `
                      break;

                  case "google_overall":
                    if(result.desktop && result.mobile){
                      const desktopData = JSON.parse(result.desktop.data)
                      const mobileData = JSON.parse(result.mobile.data)

                      const desktopScore = getRoundedNumber(desktopData.performance_score);
                      const mobileScore = getRoundedNumber(mobileData.performance_score);

                      const desktopColor = getGoogleInsightsColorByScore(desktopScore);
                      const mobileColor = getGoogleInsightsColorByScore(mobileScore);

                      td.innerHTML += `
                        <td class="${desktopColor === 'success' ? 'result_pass' : 'result_fail'}">${desktopScore}</td>
                        <td class="${mobileColor === 'success' ? 'result_pass' : 'result_fail'}">${mobileScore}</td>
                      `;
                    }else{
                      td.innerHTML+=`
                      <td></td>
                      <td></td>
                      `
                    }
              
                    break;
                  case "google_lighthouse":
                    if(result.desktop && result.mobile){
                      const desktopData = JSON.parse(result.desktop.data)
                      const mobileData = JSON.parse(result.mobile.data)

                      const addMetric = (val) => {
                        const score = getRoundedNumber(val);
                        const color = getGoogleInsightsColorByScore(score);
                        const className = color === "success" ? "result_pass" : "result_fail";
                        return `<td class="${className}">${score}</td>`;
                      };

                      td.innerHTML +=
                      addMetric(desktopData.performance_score) +
                      addMetric(mobileData.performance_score) +
                      addMetric(desktopData.accessibility_score) +
                      addMetric(mobileData.accessibility_score) +
                      addMetric(desktopData.best_practices_score) +
                      addMetric(mobileData.best_practices_score) +
                      addMetric(desktopData.seo_score) +
                      addMetric(mobileData.seo_score);
                    }else{
                      td.innerHTML+=`
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>   
                      `
                    }
                    break;
                  case "core_web_vitals":
                    if(result.desktop && result.mobile){
                      const desktopData = JSON.parse(result.desktop.data)
                      const mobileData = JSON.parse(result.mobile.data)

                      const addMetric = (val, type) => {
                        const score = getRoundedNumber(val);
                        const color = getGoogleCWVColorByScore(score, type);
                        const className = color === "success" ? "result_pass" : "result_fail";
                        return `<td class="${className}">${score}</td>`;
                      };
                    
                      td.innerHTML +=
                        addMetric(desktopData.largest_contentful_paint, "lcp") +
                        addMetric(mobileData.largest_contentful_paint, "lcp") +
                        addMetric(desktopData.max_potential_fid, "fid") +
                        addMetric(mobileData.max_potential_fid, "fid") +
                        addMetric(desktopData.cumulative_layout_shift, "cls") +
                        addMetric(mobileData.cumulative_layout_shift, "cls") +
                        addMetric(desktopData.first_contentful_paint, "fcp") +
                        addMetric(mobileData.first_contentful_paint, "fcp") +
                        addMetric(desktopData.interactive, "interactive") +
                        addMetric(mobileData.interactive, "interactive") +
                        addMetric(desktopData.speed_index, "speed_index") +
                        addMetric(mobileData.speed_index, "speed_index") +
                        addMetric(desktopData.total_blocking_time, "tbt") +
                        addMetric(mobileData.total_blocking_time, "tbt");
                    }else{
                      td.innerHTML+=`
                      <td></td>
                      <td></td>
  
                      <td></td>
                      <td></td>
  
                      <td></td>
                      <td></td>
  
                      <td></td>
                      <td></td>
  
                      <td></td>
                      <td></td>
  
                      <td></td>
                      <td></td>
  
                      <td></td>
                      <td></td>   
                      `
                    }
             
                    break;
                 case "mobile_friendly":
                    if (!result) {
                      td.innerHTML+=`
                      <td></td>
                      `;
                      break;
                    }
                    td.innerHTML+=`
                    <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Mobile friendly" : "Not Mobile friendly"}</td>   
                    `
                    break;
                  
                  
                 case "gzip_compression":
                    if (!result) {
                      td.innerHTML+=`
                      <td></td>
                      `;
                      break;
                    }
                    td.innerHTML+=`
                    <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                    `
                    break;
                  case "html_compression":
                    if (!result) {
                      td.innerHTML+=`
                      <td></td>
                      `;
                      break;
                    }
                    td.innerHTML+=`
                    <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                    `
                    break;
                  case "css_compression":
                    if (!result) {
                      td.innerHTML+=`
                      <td></td>
                      `;
                      break;
                    }
                    td.innerHTML+=`
                    <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                    `
                    break;
                  case "js_compression":
                    if (!result) {
                      td.innerHTML+=`
                      <td></td>
                      `;
                      break;
                    }
                    td.innerHTML+=`
                    <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                    `
                    break;
                  case "css_caching_enable":
                    if (!result) {
                      td.innerHTML+=`
                      <td></td>
                      `;
                      break;
                    }
                    td.innerHTML+=`
                    <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                    `
                    break;
                  case "js_caching_enable":
                    if (!result) {
                      td.innerHTML+=`
                      <td></td>
                      `;
                      break;
                    }
                    td.innerHTML+=`
                    <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                    `
                    break;
                  case "page_size":
                    if (!result) {
                      td.innerHTML+=`
                      <td></td>
                      `;
                      break;
                    }
                    td.innerHTML+=`
                    <td class="${result.status ? "result_pass" : "result_fail"}">${result.contentLengthUnits}</td>
                    `
                    break;
                    case "nested_tables":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Does not exist" : "Exists"}</td>
                      `
                      break;
                    case "frameset":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Does not exist" : "Exists"}</td>
                      `
                      break;
  
  
                    case "is_safe_browsing":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                      `
                      break;
                    case "cross_origin_links":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Does not exist" : "Exists"}</td>
                      `
                      break;
                    case "protocol_relative_resource":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Does not exist" : "Exists"}</td>
                      `
                      break;
                    case "content_security_policy_header":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                      `
                      break;
                    case "x_frame_options_header":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                      `
                      break;
                    case "hsts_header":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                      `
                      break;
                    case "bad_content_type":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Does not exist" : "Exists"}</td>
                      `
                      break;
                    case "ssl_certificate_enable":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Enabled" : "Disabled"}</td>
                      `
                      break;
                    case "folder_browsing_enable":
                      if (!result) {
                        td.innerHTML+=`
                        <td></td>
                        `;
                        break;
                      }
                      td.innerHTML+=`
                      <td class="${result.status ? "result_pass" : "result_fail"}">${result.status ? "Disabled" : "Enbled"}</td>
                      `
                      break;
                        
                }
          


          document.querySelector(".reports-table-body").appendChild(td)

          options.tableBody = td
          options.firstTimeStatus = false
          return options
      }

      static showNoTestMessage(){
          const div = buildAlert({status: 0, msg: "Please go to the dashboard and finalize testing before viewing the website tracker."})
          document.querySelector(".tracker-title").appendChild(div)
      }

      static showCantHideMessage(){
        const div = buildAlert({status: 0, msg: "Can't hide more elements of the same test"})
        document.querySelector(".tracker-title").appendChild(div)
    }

      static updatePaginationInfo(startIndex, endIndex, totalItems) {
          $('.showing-pagination span').html(`Showing ${startIndex} - ${endIndex} of ${totalItems}`);
      }        
  }



  class Controls{
      static CSV_NAME = "Marketing QA Tool Results.csv";

      static buildCSV(){
        const table = $( "#reportTableClone" ).clone()[0]
        const exporter = new TableCSVExporter(table, this.CSV_NAME);
        exporter.downloadCSV();
      }
      static buildCSVTracker() {
        const table = $("#reportTableClone").clone(); // Clone the table
        table.find("input, select, textarea, button, label").remove(); // Remove form elements
        table.find("[class], [style], [id]").removeAttr("class style id"); // Remove inline styles, classes, and IDs
        table.find("th, td").each(function () {
            $(this).text($(this).text().trim()); // Keep only the text content
        });
        table.find("tr").eq(3).remove();

        const exporter = new TableCSVExporter(table[0], this.CSV_NAME);
        exporter.downloadCSV();
    }

    static getGoogleDataByUrl(url){
        const result = {
          desktop: null,
          mobile: null
        };

      testDetailsLighthouse.forEach(item => {
          if (item.url === url) {
              if (item.strategy === "desktop") {
                  result.desktop = item;
              }
              if (item.strategy === "mobile") {
                  result.mobile = item;
              }
          }
      });

      console.log(result)
      return result;
    }

      static deleteURL(){
        if(urlsList.length > 1){
            const projectId = getActiveProjectId()

            DB.deleteURL(projectId, activeOptionsModalUrl)
            .done(function(data){
                UI.deleteURL()
                $(".url-options-modal").css({display: "none"})
                const alert = new Toast("URL Deleted Successfully.");
                alert.display()
            })
        }else{
          displayAlert(".alert-section", {
            status: 0,
            msg: "There needs to be at least one active URL in the project."
          })
          $(".url-options-modal").css({display: "none"})
        }
      }

      static initDataTable(){
          const styles = {
            colResize: {
              isEnabled: () => $(window).width() > 768,
              hoverClass: "dt-colresizable-hover",
              hasBoundCheck: true,
              minBoundClass: "dt-colresizable-bound-min",
              maxBoundClass: "dt-colresizable-bound-max",
              saveState: true,
              isResizable: function (column) {
                return column.idx !== 0;
              },
              onResize: function (column) {
              },
              onResizeEnd: function (column, columns) {
            
              },
              stateSaveCallback: function (settings, data) {
                let stateStorageName = window.location.pathname + "/colResizeStateData";
                localStorage.setItem(stateStorageName, JSON.stringify(data));
              },
              stateLoadCallback: function (settings) {
                let stateStorageName = window.location.pathname + "/colResizeStateData",
                  data = localStorage.getItem(stateStorageName);
                return data != null ? JSON.parse(data) : null;
              },
            },
            pageLength: 11,
            autoWidth: false,
            colReorder: true,
            colReorder: {
              columns: ':gt(2)'
            },
            colReorder: true,  // Enable colReorder
            // columnDefs: [
            //     { "reorderable": false,
            //      "targets": [0, 1, 2, 3, 4], // Disable for the first row or irrelevant columns,
            //     }
            // ],
            fixedHeader: true,
          
            select: {
              style: "multi",
              selector: "td:first-child .form-check-input",
            },
            info: false,
            ordering: false,
            fixedColumns: {
              leftColumns: 1,
            },
            lengthChange: false,
            "dom": "lfrti",
           
         
          };
          $('#reportTableClone')[0].innerHTML = $('#reportTable').clone()[0].innerHTML;
          UI.updateCloneTable()
          let table = new DataTable("#reportTable", styles);

          $("#downloadCSV").on('click', function() {
            if($('.website-tracker-csv').length){ 
              Controls.buildCSVTracker()
            }  else {
              Controls.buildCSV()
            }
          });

          

          $(".show-url-options-modal").click(function (e) {
            // saving url that was clicked
            const target = e.target.parentElement.parentElement.parentElement
            const url = target.querySelector(".form-check-label").textContent.trim()
            activeOptionsModalUrl = url
            activeOptionsElement = target

            var modalID = $(".url-options-modal .modal-dialog");
            var topOffset = 0; 
            var thisLeft = $(this).offset().left;
            var thisTop = $(this).offset().top - topOffset;
            var thisWidth = $(this).width();
            var thisHeight = $(this).height();
            var idWidth = $(modalID).width();
            var idHeight = $(modalID).height();

            $(".url-options-modal").css({display: "block"})
            $(modalID).css({ left: thisLeft - Number(idWidth / 2) + Number(thisWidth / 2), top: thisTop - Number(idHeight / 2) + Number(thisHeight) -50 });
            urlOptionModalOpenStatus = true
        });

          $('#tableNext').on('click', function() {
              table.page('next').draw('page');
          });

          $('#tablePrev').on('click', function() {
              table.page('previous').draw('page');
          });

           // Event listener for dropdown change
          $('#rowsTable').on('change', function () {
              const recordsPerPage = parseInt($(this).val()); // Get the selected value and parse as integer
              table.page.len(recordsPerPage).draw();
          });

          $(".left-menu-check .form-check-input").on("change", function () {
            // Get the state of the "All" checkbox
            var isChecked = $(this).prop("checked");
        
            // Set the state of all individual checkboxes based on the "All" checkbox
            $("td:first-child .form-check-input").prop("checked", isChecked);
          });

          $("#reportTable").on("click", function (e) {
              const target = e.target;
              const hideBtn = target.closest("#hide-col-btn");
              const showBtn = target.closest("#show-col-btn");
              if (hideBtn) {
                // hide the first column
                table.column(0).visible(!table.column(0).visible());
                $(this).find(".table-header").prepend(`<td>
                  <button
                    type="button"
                    class="first-col-toggle-btn"
                    id="show-col-btn"
                  >
                    <img
                      src="/new-assets/assets/images/table-collapse.png"
                      alt="icon"
                    />
                  </button>`);
              }
          
              if (showBtn) {
                // show the first column
                table.column(0).visible(!table.column(0).visible());
                $(showBtn).remove();
              }
          });

          $(".t-search-url input").on("input", function (e) {
              $(".alert-no-records").remove()
              const val = table.column(0).search($(this).val()).draw();
              const length = table.page.info().recordsDisplay;

              if(length === 0){
                const msg =  `No records were found with the word ${e.target.value}`
                const p = document.createElement("p")
                p.innerHTML = msg
                p.classList.add("alert")
                p.classList.add("alert-danger")
                p.classList.add("webqa__alert")
                p.classList.add("alert-no-records")
                $(".alert-section").append(p)
              }
          });

          table.on('column-reorder', function(e, settings, details) {
            $('#reportTable .reports-table-header tr:eq(0)').html(firstRow)
            $('#reportTable .reports-table-header tr:eq(1)').html(secondRow)
            UI.updateTableDesign()
        });

          $(".tracker-column-dropdown .left-shift").on("click", function (e) {
            const element = e.target.parentElement.parentElement.parentElement
            const currentElement = element.getAttribute("data-name")
            const currentIndex = Controls.getElementIndex(element)
            Controls.shiftElement(table, currentIndex, "left", currentElement)
          })

          $(".tracker-column-dropdown .right-shift").on("click", function (e) {
            const element = e.target.parentElement.parentElement.parentElement
            const currentElement = element.getAttribute("data-name")
            const currentIndex = Controls.getElementIndex(element)
            Controls.shiftElement(table, currentIndex, "right", currentElement)
          })

          $(".tracker-column-dropdown .hide-column").on("click", function (e) {
            const element = e.target.parentElement.parentElement.parentElement
            const currentElement = element.getAttribute("data-name")
            const currentIndex = Controls.getElementIndex(element)
            const remainingElements = $(`#reportTable tr th[data-name='${currentElement}']`).length

            if(remainingElements > 1){
              Controls.hideElement(table, currentIndex, "right", currentElement)
            }else{
              UI.showCantHideMessage()
            }
          })

          $("#reportTable").on("click", function (e) {
            if(e.target.parentElement.classList.contains("show-hidden-elements")){
              const element = e.target.parentElement.parentElement.parentElement
              const currentElement = element.getAttribute("data-consists")
              Controls.showHiddenElements(table, currentElement)
            }
          })

          $(".tracker-right-input").on("click", (e)=>{
            const trackerElement = $(e.target).closest(".tracker-right-input")[0]
            const element = $(e.target.parentElement.parentElement.parentElement.parentElement).closest(".root-tr")[0]
            const attr = element.getAttribute("data-id")
            if(trackerElement.classList.contains("collapsed")){
              document.querySelectorAll( `tr[data-type='${attr}']`).forEach(el=>{
                el.style.display = "none"                   
              });
              trackerElement.classList.remove("collapsed")
              trackerElement.classList.add("hidden")         
            }else{
              document.querySelectorAll( `tr[data-type='${attr}']`).forEach(el=>{
                el.style.display = "table-row"        
              });
              trackerElement.classList.remove("hidden")
              trackerElement.classList.add("collapsed")
            }
          })


          // $("#reportTable").on("click", function (e) {
          //   const target = e.target;
          //   const hideBtn = target.closest("#hide-col-btn");
          //   const showBtn = target.closest("#show-col-btn");
          //   if (hideBtn) {
          //     // hide the first column
          //     table.column(1).visible(!table.column(1).visible());
          //     $(this).find(".table-header").prepend(`<td>
          //       <button
          //         type="button"
          //         class="first-col-toggle-btn"
          //         id="show-col-btn"
          //       >
          //         <img
          //           src="/new-assets/assets/images/table-collapse.png"
          //           alt="icon"
          //         />
          //       </button>`);
          //   }
        
          //   if (showBtn) {
          //     // show the first column
          //     table.column(1).visible(!table.column(1).visible());
          //     $(showBtn).remove();
          //   }
          // });

      }
      
      static showHiddenElements(table, currentElement){
        const parentElement = $(`[data-consists='${currentElement}']`)[1]
        parentElement.querySelector(".dropdown-toggle-tracker").style.display = "none"

        hiddenColumns.forEach(el=>{
          if(el.element === currentElement){
            let column = table.column(el.index);
            column.visible(true);
            hiddenColumns = hiddenColumns.splice(el.index, 1)
          }
        })
      }

      static getHiddenIndexes(){
      }

      static addElementHiddenMsg(currentElement){
        
      }

      static hideElement(table, currentIndex, side, currentElement){
        const parentElement = $(`[data-consists='${currentElement}']`)[1]
        parentElement.querySelector(".dropdown-toggle-tracker").style.display = "block"


        const index = currentIndex + hiddenColumns.length
        let column = table.column(index);

        // Toggle the visibility
        column.visible(!column.visible());
        const obj = {
          index: index, 
          element: currentElement
        }
        hiddenColumns.push(obj)
        Controls.addElementHiddenMsg(currentElement)
      }


      static shiftElement(table, currentIndex, side, currentElement){
        let newIndex = currentIndex
        if(side === "right"){
          newIndex++
        }else{
          newIndex--
        }



        const newElement = document.querySelector("#reportTable .th-bg").children[newIndex]
        if(newElement){
          if(newElement.getAttribute("data-name") === currentElement){
            table.colReorder.move(currentIndex, newIndex);
          }
        }

      }


      static showNoTestMessage(){
          UI.showNoTestMessage()
          removeLoader()
      }

      static getElementIndex (element) {
        return Array.from(element.parentNode.children).indexOf(element);
      }

      static calcColespan(title, colspan){
        if(title === "seo"){
          seoColspan+=colspan
        }

        if(title === "performance"){
          performanceColspan+=colspan
        }

        if(title === "best-practices"){
          bestPracticesColspan+=colspan
        }

        if(title === "security"){
          securityColspan+=colspan
        }
      }


      static buildTable(data, updatedUrls){
          // build num rows dropdown
          const test = data.meta_title
          const testSettings  = test[0].settings
          const nums = splitNParts(test.length + updatedUrls.length, 5)
          UI.buildRowsTable(nums)
        
          const options = UI.initTable(test.length)
          const settings = convertObjToIntVal(testSettings)
          Controls.buildTableHeader(options, data, settings, updatedUrls)
          Controls.buildTableBody(options, data, settings, updatedUrls)
          Controls.buildTableHeaderTop(options)

      }
      static calculateColspan(title, data){
         let rowspanCal = 0;
         if(title == 'meta-title') {

           if(data[0].settings.max_title_length == 1) {
            rowspanCal += 1;
           }
           if(data[0].settings.meta_title == 1) {
            rowspanCal += 1;
           }
           if(data[0].settings.is_title_equal_h1 == 1) {
            rowspanCal += 1;
           }
           if(data[0].settings.title_casing_both == 1 || data[0].settings.title_casing_camel == 1 || data[0].settings.title_casing_sentence == 1) { 
            rowspanCal += 1;
           }
          //  title_casing_camel
         
         }

         if(title == 'url-slug') {
          if (data[0].settings.max_url_length == 1 || data[0].settings.min_url_length == 1) {
            rowspanCal += 1;
          }
          if(data[0].settings.url_no_numbers == 1) {
           rowspanCal += 1;
          }
          if(data[0].settings.url_no_special == 1) {
           rowspanCal += 1;
          }
          if(data[0].settings.url_slug_lowercase == 1) {
           rowspanCal += 1;
          }
          if(data[0].settings.url_casing_only_hyphens == 1) { 
           rowspanCal += 1;
          }

          if(data[0].settings.url_casing_only_underscores == 1) { 
            rowspanCal += 1;
           }
           if(data[0].settings.url_stop_words ==  1) { 
            rowspanCal += 1;
           }
           rowspanCal += 1;
        
        }

        return rowspanCal;
      }
     

      static buildTableReports(data, updatedUrls){
        // build num rows dropdown
        const test = data.meta_title
        const testSettings  = test[0].settings
        const nums = splitNParts(test.length, 5)
        UI.buildRowsTableReports(nums)

        const options = UI.initTable(test.length)
        const settings = convertObjToIntVal(testSettings)
        
        if(page[1] === "meta-title"){
         const rowspanCal = this.calculateColspan('meta-title', data.meta_title);
          UI.buildTableHeader("title", data.meta_title, rowspanCal, options, settings, "seo", data.meta_title)
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.meta_title[originalIndex]){
                urlsList.push(url)
              }
              
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "title", data.meta_title[originalIndex], options, url, settings, "seo", data.meta_title)
            })
          })

        }else if(page[1] === "description"){
          UI.buildTableHeader("description", data.meta_desc, 2, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.meta_desc[originalIndex]){
                urlsList.push(url)
              }

              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "description", data.meta_desc[originalIndex], options, url, settings, "seo")
            })
          })
        }else if(page[1] === "http-status-code"){
          UI.buildTableHeader("http_status_code", data.http_status_code, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.http_status_code[originalIndex]){
                urlsList.push(url)
              }

              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "http_status_code", data.http_status_code[originalIndex], options, url, settings, "seo", data.meta_title)
            })
          })
        } else if(page[1] === "url-slug"){
          const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("url_slug", data.url_slug, rowspanCal, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.url_slug[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "url_slug", data.url_slug[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        } else if(page[1] === "canonical"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("canonical", data.canonical_url, 2, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.canonical_url[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "canonical", data.canonical_url[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
        else if(page[1] === "robots-meta"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("robots", data.robots_meta, 2, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.robots_meta[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "robots", data.robots_meta[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        } else if(page[1] === "doctype"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("doctype", data.doctype, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.doctype[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "doctype", data.doctype[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
       
        else if(page[1] === "meta-viewport"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("meta_viewport", data.meta_viewport, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.meta_viewport[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "meta_viewport", data.meta_viewport[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
        else if(page[1] === "favicon"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("favicon", data.favicon, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.favicon[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "favicon", data.favicon[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
        
        
        else if(page[1] === "images"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("images", data.images, 10, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.images[originalIndex]){
                urlsList.push(url)
              }
      
             
              const problems =  data.images[originalIndex].problems;
              problems.forEach((problemsVar, index) => {
                const options = UI.initTableBody(el.id)
              UI.buildTableBodyImages(problemsVar, el.id, "images", data.images[originalIndex], options, url, settings, "seo", data.url_slug, index)
            })
            })
          })
        }

        else if(page[1] === "gzip-compression"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("gzip_compression", data.gzip_compression, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.gzip_compression[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "gzip_compression", data.gzip_compression[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "css-compression"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("css_compression", data.css_compression, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.css_compression[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "css_compression", data.css_compression[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
        else if(page[1] === "js-compression"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("js_compression", data.js_compression, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.js_compression[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "js_compression", data.js_compression[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
        else if(page[1] === "html-compression"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("html_compression", data.html_compression, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.html_compression[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "html_compression", data.html_compression[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
    
        else if(page[1] === "css-caching"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("css_caching_enable", data.css_caching_enable, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.css_caching_enable[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "css_caching_enable", data.css_caching_enable[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "js-caching"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("js_caching_enable", data.js_caching_enable, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.js_caching_enable[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "js_caching_enable", data.js_caching_enable[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "page-size"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("page_size", data.page_size, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.page_size[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "page_size", data.page_size[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
        else if(page[1] === "nested-tables"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("nested_tables", data.nested_tables, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.nested_tables[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "nested_tables", data.nested_tables[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
        else if(page[1] === "frameset"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("frameset", data.frameset, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.frameset[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "frameset", data.frameset[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "frameset"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("frameset", data.frameset, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.frameset[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "frameset", data.frameset[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "safe-browsing"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("is_safe_browsing", data.is_safe_browsing, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.is_safe_browsing[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "is_safe_browsing", data.is_safe_browsing[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "unsafe-cross-origin-links"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("cross_origin_links", data.cross_origin_links, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.cross_origin_links[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "cross_origin_links", data.cross_origin_links[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "protocol-relative-resource"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("protocol_relative_resource", data.protocol_relative_resource, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.protocol_relative_resource[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "protocol_relative_resource", data.protocol_relative_resource[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "content-security-policy-header"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("content_security_policy_header", data.content_security_policy_header, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.content_security_policy_header[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "content_security_policy_header", data.content_security_policy_header[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "frameset"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("frameset", data.frameset, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.frameset[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "frameset", data.frameset[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "hsts-header"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("hsts_header", data.hsts_header, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.hsts_header[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "hsts_header", data.hsts_header[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "bad-content-type"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("bad_content_type", data.bad_content_type, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.bad_content_type[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "bad_content_type", data.bad_content_type[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "ssl-certificate"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("ssl_certificate_enable", data.ssl_certificate_enable, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.ssl_certificate_enable[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "ssl_certificate_enable", data.ssl_certificate_enable[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "ssl-certificate"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("ssl_certificate_enable", data.ssl_certificate_enable, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.ssl_certificate_enable[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "ssl_certificate_enable", data.ssl_certificate_enable[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "directory-browsing"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("folder_browsing_enable", data.folder_browsing_enable, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.folder_browsing_enable[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "folder_browsing_enable", data.folder_browsing_enable[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "x-frame-options-header"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("x_frame_options_header", data.x_frame_options_header, 1, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.x_frame_options_header[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "x_frame_options_header", data.x_frame_options_header[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "og-tags"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("open_graph_tags", data.open_graph_tags, 12, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.open_graph_tags[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "open_graph_tags", data.open_graph_tags[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }

        else if(page[1] === "twitter-tags"){
          // const rowspanCal = this.calculateColspan('url-slug', data.url_slug);
          UI.buildTableHeader("twitter_tags", data.twitter_tags, 8, options, settings, "seo")
          updatedUrls.forEach(el=>{
            UI.buildRootURLElement(el)

            const urls = el.urls
            urls.forEach(urlEl=>{
              const url = urlEl.url
              const originalIndex = urlEl.original_index

              if(data.twitter_tags[originalIndex]){
                urlsList.push(url)
              }
      
              const options = UI.initTableBody(el.id)
              UI.buildTableBody(el.id, "twitter_tags", data.twitter_tags[originalIndex], options, url, settings, "seo", data.url_slug)
            })
          })
        }
        else if(page[1] === "google-page-speed-insights"){
          UI.buildTableHeader("google_overall", testDetailsLighthouse, 2, options, settings, "performance")

         updatedUrls.forEach(el=>{
           UI.buildRootURLElement(el)

           const urls = el.urls
           urls.forEach(urlEl=>{
             const url = urlEl.url
             const originalIndex = urlEl.original_index

             const googleData = Controls.getGoogleDataByUrl(url)
             if(googleData){
               urlsList.push(url)
             }
             const options = UI.initTableBody(el.id)
             UI.buildTableBody(el.id, "google_overall", googleData, options, url, settings, "performance", data.url_slug)
           })
         })
       }
       
       
       else if(page[1] === "google-page-speed-lighthouse"){
         UI.buildTableHeader("google_lighthouse", testDetailsLighthouse, 8, options, settings, "performance")

        updatedUrls.forEach(el=>{
          UI.buildRootURLElement(el)

          const urls = el.urls
          urls.forEach(urlEl=>{
            const url = urlEl.url
            const originalIndex = urlEl.original_index

            const googleData = Controls.getGoogleDataByUrl(url)
            if(googleData){
              urlsList.push(url)
            }
            const options = UI.initTableBody(el.id)
            UI.buildTableBody(el.id, "google_lighthouse", googleData, options, url, settings, "performance", data.url_slug)
          })
        })
      }

      
      else if(page[1] === "google-page-speed-core-web-vitals"){
       UI.buildTableHeader("core_web_vitals", testDetailsLighthouse, 14, options, settings, "performance")

      updatedUrls.forEach(el=>{
        UI.buildRootURLElement(el)

        const urls = el.urls
        urls.forEach(urlEl=>{
          const url = urlEl.url
          const originalIndex = urlEl.original_index

          const googleData = Controls.getGoogleDataByUrl(url)
          if(googleData){
            urlsList.push(url)
          }
          const options = UI.initTableBody(el.id)
          UI.buildTableBody(el.id, "core_web_vitals", googleData, options, url, settings, "performance", data.url_slug)
        })
      })
    }

    else if(page[1] === "mobile-friendly"){
     UI.buildTableHeader("mobile_friendly", data.mobile_friendly, 1, options, settings, "performance")

    updatedUrls.forEach(el=>{
      UI.buildRootURLElement(el)

      const urls = el.urls
      urls.forEach(urlEl=>{
        const url = urlEl.url
        const originalIndex = urlEl.original_index

        if(data.mobile_friendly[originalIndex]){
          urlsList.push(url)
        }
        const options = UI.initTableBody(el.id)
        UI.buildTableBody(el.id, "mobile_friendly", data.mobile_friendly[originalIndex], options, url, settings, "performance", data.url_slug)
      })
    })
  }
    }

      static buildTableHeaderTop(){

        if(seoColspan > 0){
          UI.buildTableHeaderTop("SEO", seoColspan, "#1e63b8")
        }

        if(performanceColspan > 0){
          UI.buildTableHeaderTop("Performance", performanceColspan, "#759d62")
        }

        if(bestPracticesColspan > 0){
          UI.buildTableHeaderTop("Best Practices", bestPracticesColspan, "#1e63b8")
        }

        if(securityColspan > 0){
          UI.buildTableHeaderTop("Security", securityColspan, "#759d62")
        }
      }

      static buildTableBody(options, data, settings, updatedUrls){
        updatedUrls.forEach(el=>{
          console.log(el)
          UI.buildRootURLElement(el)

          const urls = el.urls
          urls.forEach(urlEl=>{



            const url = urlEl.url
            const originalIndex = urlEl.original_index

            urlsList.push(url)

            const options = UI.initTableBody(el.id)
            UI.buildTableBody(el.id, "title", data.meta_title[originalIndex], options, url, settings, "seo", data.meta_title)
            UI.buildTableBody(el.id, "description", data.meta_desc[originalIndex], options, url, settings, "seo")
            UI.buildTableBody(el.id, "robots", data.robots_meta[originalIndex], options, url, settings, "seo")
            UI.buildTableBody(el.id, "canonical", data.canonical_url[originalIndex], options, url, settings, "seo")
            UI.buildTableBody(el.id, "open_graph_tags", data.open_graph_tags[originalIndex], options, url, settings, "seo")
            UI.buildTableBody(el.id, "twitter_tags", data.twitter_tags[originalIndex], options, url, settings, "seo")
            UI.buildTableBody(el.id, "url_slug", data.url_slug[originalIndex], options, url, settings, "seo", data.url_slug)
            // UI.buildTableBody(el.id, "images", data.images[originalIndex], options, url, settings, "seo")
            UI.buildTableBody(el.id, "favicon", data.favicon[originalIndex], options, url, settings, "seo")
            UI.buildTableBody(el.id, "meta_viewport", data.meta_viewport[originalIndex], options, url, settings, "seo")
            UI.buildTableBody(el.id, "doctype", data.doctype[originalIndex], options, url, settings, "seo")
            UI.buildTableBody(el.id, "http_status_code", data.http_status_code[originalIndex], options, url, settings, "seo", data.meta_title)
            lighthouseStatus ? UI.buildTableBody(el.id, "google_overall", Controls.getGoogleDataByUrl(url), options, url, settings, "performance") : ""
            lighthouseStatus ? UI.buildTableBody(el.id, "google_lighthouse", Controls.getGoogleDataByUrl(url), options, url, settings, "performance") : ""
            lighthouseStatus ? UI.buildTableBody(el.id, "core_web_vitals", Controls.getGoogleDataByUrl(url), options, url, settings, "performance") : ""
            UI.buildTableBody(el.id, "mobile_friendly", data.mobile_friendly[originalIndex], options, url, settings, "performance")

            UI.buildTableBody(el.id, "gzip_compression", data.cbp_labels.gzip_compression[originalIndex], options, url, settings, "best-practices")
            UI.buildTableBody(el.id, "html_compression", data.cbp_labels.html_compression[originalIndex], options, url, settings, "best-practices")
            UI.buildTableBody(el.id, "css_compression", data.cbp_labels.css_compression[originalIndex], options, url, settings, "best-practices")
            UI.buildTableBody(el.id, "js_compression", data.cbp_labels.js_compression[originalIndex], options, url, settings, "best-practices")
            UI.buildTableBody(el.id, "css_caching_enable", data.cbp_labels.css_caching_enable[originalIndex], options, url, settings, "best-practices")
            UI.buildTableBody(el.id, "js_caching_enable", data.cbp_labels.js_caching_enable[originalIndex], options, url, settings, "best-practices")
            // UI.buildTableBody(el.id, "page_size", data.cbp_labels.page_size[originalIndex], options, url, settings, "best-practices")
            UI.buildTableBody(el.id, "nested_tables", data.cbp_labels.nested_tables[originalIndex], options, url, settings, "best-practices")
            UI.buildTableBody(el.id, "frameset", data.cbp_labels.frameset[originalIndex], options, url, settings, "best-practices")

            UI.buildTableBody(el.id, "is_safe_browsing", data.security_labels.is_safe_browsing[originalIndex], options, url, settings, "security")
            UI.buildTableBody(el.id, "cross_origin_links", data.security_labels.cross_origin_links[originalIndex], options, url, settings, "security")
            UI.buildTableBody(el.id, "protocol_relative_resource", data.security_labels.protocol_relative_resource[originalIndex], options, url, settings, "security")
            UI.buildTableBody(el.id, "content_security_policy_header", data.security_labels.content_security_policy_header[originalIndex], options, url, settings, "security")
            UI.buildTableBody(el.id, "x_frame_options_header", data.security_labels.x_frame_options_header[originalIndex], options, url, settings, "security")
            UI.buildTableBody(el.id, "hsts_header", data.security_labels.hsts_header[originalIndex], options, url, settings, "security")
            UI.buildTableBody(el.id, "bad_content_type", data.security_labels.bad_content_type[originalIndex], options, url, settings, "security")
            UI.buildTableBody(el.id, "ssl_certificate_enable", data.security_labels.ssl_certificate_enable[originalIndex], options, url, settings, "security")
            UI.buildTableBody(el.id, "folder_browsing_enable", data.security_labels.folder_browsing_enable[originalIndex], options, url, settings, "security")

          })
        })

      }

      static buildTableHeader(options, data, settings, testDetailsLighthouse){
        let rowspanCalHeader = 0;
          rowspanCalHeader  = this.calculateColspan('meta-title', data.meta_title);
          UI.buildTableHeader("title", data.meta_title, rowspanCalHeader, options, settings, "seo")
          UI.buildTableHeader("description", data.meta_desc, 2, options, settings, "seo")
          UI.buildTableHeader("robots", data.robots_meta, 2, options, settings, "seo")
          UI.buildTableHeader("canonical", data.canonical_url, 2, options, settings, "seo")
          UI.buildTableHeader("open_graph_tags", data.open_graph_tags, 12, options, settings, "seo")
          UI.buildTableHeader("twitter_tags", data.twitter_tags, 8, options, settings, "seo")
           rowspanCalHeader = this.calculateColspan('url-slug', data.meta_title);

          UI.buildTableHeader("url_slug", data.url_slug, rowspanCalHeader, options, settings, "seo")
          // UI.buildTableHeader("images", data.images, 9, options, settings, "seo")
          UI.buildTableHeader("favicon", data.favicon, 1, options, settings, "seo")
          UI.buildTableHeader("meta_viewport", data.meta_viewport, 1, options, settings, "seo")
          UI.buildTableHeader("doctype", data.doctype, 1, options, settings, "seo")
          UI.buildTableHeader("http_status_code", data.http_status_code, 1, options, settings, "seo")


          lighthouseStatus ? UI.buildTableHeader("google_overall", testDetailsLighthouse, 2, options, settings, "performance") : ""
          lighthouseStatus ? UI.buildTableHeader("google_lighthouse", testDetailsLighthouse, 8, options, settings, "performance") : ""
          lighthouseStatus ? UI.buildTableHeader("core_web_vitals", testDetailsLighthouse, 14, options, settings, "performance") : ""
          UI.buildTableHeader("mobile_friendly", data.mobile_friendly, 1, options, settings, "performance")

          UI.buildTableHeader("gzip_compression", data.cbp_labels.gzip_compression, 1, options, settings, "best-practices")
          UI.buildTableHeader("html_compression", data.cbp_labels.html_compression, 1, options, settings, "best-practices")
          UI.buildTableHeader("css_compression", data.cbp_labels.css_compression, 1, options, settings, "best-practices")
          UI.buildTableHeader("js_compression", data.cbp_labels.js_compression, 1, options, settings, "best-practices")
          UI.buildTableHeader("css_caching_enable", data.cbp_labels.css_caching_enable, 1, options, settings, "best-practices")
          UI.buildTableHeader("js_caching_enable", data.cbp_labels.js_caching_enable, 1, options, settings, "best-practices")
          // UI.buildTableHeader("page_size", data.cbp_labels.page_size, 1, options, settings, "best-practices")
          UI.buildTableHeader("nested_tables", data.cbp_labels.nested_tables, 1, options, settings, "best-practices")
          UI.buildTableHeader("frameset", data.cbp_labels.frameset, 1, options, settings, "best-practices")


          UI.buildTableHeader("is_safe_browsing", data.security_labels.is_safe_browsing, 1, options, settings, "security")
          UI.buildTableHeader("cross_origin_links", data.security_labels.cross_origin_links, 1, options, settings, "security")
          UI.buildTableHeader("protocol_relative_resource", data.security_labels.protocol_relative_resource, 1, options, settings, "security")
          UI.buildTableHeader("content_security_policy_header", data.security_labels.content_security_policy_header, 1, options, settings, "security")
          UI.buildTableHeader("x_frame_options_header", data.security_labels.x_frame_options_header, 1, options, settings, "security")
          UI.buildTableHeader("hsts_header", data.security_labels.hsts_header, 1, options, settings, "security")
          UI.buildTableHeader("bad_content_type", data.security_labels.bad_content_type, 1, options, settings, "security")
          UI.buildTableHeader("ssl_certificate_enable", data.security_labels.ssl_certificate_enable, 1, options, settings, "security")
          UI.buildTableHeader("folder_browsing_enable", data.security_labels.folder_browsing_enable, 1, options, settings, "security")
      }

      static getAllUrls(data){
          const urls = []
          data.meta_title.forEach(el=>{
              urls.push(el.tested_url)
          })
          return urls
      }

      static getActiveLabel(dbName){
        if(dbName === "security_labels"){
          return {
            display_name: "Security Headers",
            urlDetails: "/test-details/security-headers",
            reportsUrl: "/reports/security-headers",
            db_name: "security_labels"
          }
        }
  
        if(dbName === "cbp_labels"){
          return {
            display_name: "HTML Best Practices",
            urlDetails: "/test-details/coding-best-practices",
            reportsUrl: "/reports/coding-best-practices",
            db_name: "cbp_labels"
          }
        }
  
        for(var i = 0;i < allLabels.length;i++){
          const label = allLabels[i]
  
          if(label.db_name === dbName){
            return label
          }
        }
      }

      static updateTestDataForm(results){
        console.log(results, obj)
        for (const [key, value] of Object.entries(results)) {
          for (const [key1, value1] of Object.entries(results[key])) {
            const result = JSON.parse(value1)
            console.log(key1)
            obj[key1].push(result)

          }
  
        }
  
        return obj
    }
  

      static loadData(loadData){
          DB.returnData(loadData)
          .done(function(data){
            console.log(data)
            const testDetails = data.results


              allUrls = Controls.getAllUrls(testDetails)
              const updatedUrls = groupUrlsBySubfolder(allUrls);
              if(page.includes("reports")){
                Controls.buildTableReports(testDetails, updatedUrls)
              }else{
                Controls.buildTable(testDetails, updatedUrls)
              }
              firstRow = $('.reports-table-header tr:eq(0)').clone().html();
              secondRow = $('.reports-table-header tr:eq(1)').clone().html();;

              Controls.initDataTable()
              Controls.activateEvents()


              UI.toggleTrackerElements()
              UI.updateTableDesign()
              removeLoader()
          })
  
      }

      static activateEvents(){
    
        console.log(urlsList)
          // Events
        $("#recheckAllTracker").on("click", async function(e){
          await Controls.recheckStart()
          e.preventDefault()
        })
      }

      static async checkIfTestsAreRunning() {
        try {
          // Check dashboard tests status
          const dashboardResponse = await fetch(`/api/check-status-dashboard/${projectId}`);
          const dashboardData = await dashboardResponse.json();
          
          // Check Google tests status
          const googleResponse = await fetch(`/api/check-status/${projectId}`);
          const googleData = await googleResponse.json();
          
          // If any test is still running, return true
          if (dashboardData.status === 'pending' || dashboardData.status === 'in_progress' || googleData.status === 'pending' || googleData.status === 'in_progress') {
            return true;
          }
          
          return false;
        } catch (error) {
          console.error('Error checking test status:', error);
          // If there's an error, assume tests might be running to be safe
          return true;
        }
      }


      static async recheckStart(){
        if(recheckAllowed){
          // First check if any tests are currently running
          const testsRunning = await Controls.checkIfTestsAreRunning();
          
          if (testsRunning) {
            // Show message that we need to wait for tests to complete
            UI.showWaitingMessage();
            
            // Wait for all tests to complete
            await Controls.waitForTestsToComplete();
            
          }else{
          // Now proceed with recheck
          recheckAllowed = false
          
          // Update button state to show recheck is starting
          UI.updateRecheckButtonState(true)
          
          DB.getUrlsList(projectId) // GET PROJECT URLS AND START TEST
            .done(function(data){
                urls = data.slice(0, recheckMax)
                urlsToCheck = recheckMax
  
                removeLoader()
                UI.buildRecheckLoader()
                obj = {
                  meta_title: [],
                  meta_desc: [],
                  robots_meta: [],
                  canonical_url: [],
                  url_slug: [],
                  meta_viewport: [],
                  doctype: [],
                  favicon: [],
                  page_size: [],
                  xml_sitemap: [],
                  html_sitemap: [],
                  images: [],
                  open_graph_tags: [],
                  twitter_tags: [],
                  http_status_code: [],
                  broken_links: [],
                  security_labels: {
                      is_safe_browsing: [],
                      cross_origin_links: [],
                      protocol_relative_resource: [],
                      content_security_policy_header: [],
                      x_frame_options_header: [],
                      hsts_header: [],
                      bad_content_type: [],
                      ssl_certificate_enable: [],
                      folder_browsing_enable: [],
                  },
                  cbp_labels: {
                      html_compression: [],
                      css_compression: [],
                      js_compression: [],
                      gzip_compression: [],
                      nested_tables: [],
                      frameset: [],
                      page_size: [],
                      css_caching_enable: [],
                      js_caching_enable: [],
                      frameset: [],
                  },
                  google_overall: [],
                  google_lighthouse: [],
                  core_web_vitals: [],
                  mobile_friendly: [],
                }
                // UI.recheckStartedAlert()
                // Controls.startTest(urls, "recheck")
  
  
  
                // async function checkStatusDashboard() {
                //   let controller;
              
                //   while (true) {
              
                //       // Cancel any previous unfinished request
                //       if (controller) controller.abort();
                //       controller = new AbortController();
              
                //       try {
                //           const response = await fetch(`/api/check-status-dashboard/${projectId}`, {
                //               signal: controller.signal
                //           });
              
                //           const { status, results } = await response.json();
                //           Controls.updateProgressRecheck(results);
              
                //           if (status === 'completed') {
              
                //               Controls.endTest();
              
                //               setTimeout(() => {
                //                   recheckAllowed = true;
                //                   UI.updateRecheckButtonState(false); // re-enable button
                //               }, 100);
              
                //               break; // stop loop
                //           }
                //       } catch (e) {
                //           // ignore abort errors
                //           if (e.name !== "AbortError") console.error(e);
                //       }
              
                //       // wait 1 second before next request
                //       await new Promise(res => setTimeout(res, 1000));
                //   }
                // }
              
                // checkStatusDashboard();
              
  
  
  
  
          })
          }
        
        }
      }

      


      static init(){
          allLabels = getAllTestLabels("dashboard").allLabels
          page = location.pathname.split('/').slice(1)
          buildLoader()
          projectId = getActiveProjectId()
          DB.getDashboardShowStatus(projectId)
          .done(function(data) {
              if(data.dashboardStatus){
                async function checkStatus() {
                    const response = await fetch(`/api/check-status/${projectId}`);
                    const { status, results } = await response.json();
        
        
                    if(status === 'completed') {
                      lighthouseStatus = true
                      testDetailsLighthouse = results
                    }


                    Controls.loadData(projectId)
                }
                checkStatus()
              }else{
                  Controls.showNoTestMessage()
              }
          });
      }
  }










  Controls.init()

  // EVENTS
  $(".url-options-modal").on('click', function (e) {
    if(urlOptionModalOpenStatus){
      const el = $(e.target).closest(".url-options-modal .modal-dialog")
      if(el.length < 1){
        $(".url-options-modal").css({display: "none"})
      }
    }
  })
  

  $("#openUrl").on('click', function (e) {
    window.open(activeOptionsModalUrl, '_blank').focus();
    $(".url-options-modal").css({display: "none"})
  })

  $("#deleteUrl").on('click', function (e) {
    Controls.deleteURL()
  })

  

})
$(document).on("click",".download-xlsx-bulk",function() {
  let xlsxName = TableCSVExporter.prepareCsvName($('#report-slug').val()) + '.xlsx';
  ToolXlsx.buildXLSX(xlsxName);

});

$("#hide-col-btn").on("click", function () {
    $("table").toggleClass("first-col-collapsed");
    $(this).toggleClass("collapsed");
});

z
