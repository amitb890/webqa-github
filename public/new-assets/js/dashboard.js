$(document).ready(function () {

  var projectId, originalUrls, urls, urlsToCheck = 1, googleUrlsToCheck = 1, recheckSingleIntervalStatus = true
  var recheckMax = 1, recheckGoogle = 1, recheckSingleMax = 1
  var htmlSitemapData, recheckAllowed = true
  var allResults = [], urlUpdatedList = []
  let allLabels, seoLabels, performanceLabels, cbpLabels, securityLabels;
  var modalSidebar = new bootstrap.Offcanvas(document.querySelector('.sidebar-modal'), {
    keyboard: false 
  })
  let removeTileDisabled = false, refreshTileDisabled = false, refreshTileDbName
  const ignore_tests = ["google_overall", "google_lighthouse", "core_web_vitals"]
  let obj = {
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

  
  class DB{
    static getAlerts(projectId){
      return $.ajax({
          url : `/get-alerts`,
          type : 'post',
          aysnc: false,
          data: {
              "_token": $('meta[name="csrf-token"]').attr('content'), 
              "project_id": projectId,
              "page": "dashboard",
          },       
          success: function(data) {
            
          },error: function(data){
          }
        });
    }

    static updateAlertStatus(){
      $.ajax({
        url : `/update-alert-status`,
        type : 'post',
        aysnc: false,
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'), 
            "project_id": projectId,
            "page": "dashboard",
        },       
        success: function(data) {
          
        },error: function(data){
        }
      });
    }

    static async startGoogleTests(urlsGoogle) {
      const response = await fetch('/api/start-tests', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' ,
            "_token": $('meta[name="csrf-token"]').attr('content'),
          },
          body: JSON.stringify({ 
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "urls":originalUrls.slice(0, urlsGoogle), 
            "project_id": projectId
          })
      });

      return response.json()

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

    static submitIdea(msg){
      var formData = new FormData();
      formData.append("ideaMessage", msg)


      return $.ajax({
        url: '/create-feature-request',
        method: 'post',
        data: formData,
        contentType : false,
        processData : false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            
        }
      });
    }

    static getDashboardShowStatus(){
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


    static getGoogleShowStatus(){
      return $.ajax({
          url : `/get-google-status/${projectId}`,
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

    
    static getTestData(projectId){
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

    static getTestDataSingle(projectId, labelDbName){
      return $.ajax({
          url : `/get-test-data-single/${projectId}/${labelDbName}`,
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



    static updateLabelStatus(dbName, status){
      return $.ajax({
        url : `/update-label-status`,
        type : 'post',
        aysnc: false,
        data: {
              status: status, 
              test_title: dbName, 
              projectId: projectId,
            "_token": $('meta[name="csrf-token"]').attr('content'),
        },       
        success: function(data) {
        },error: function(data){
        }
    });
    }



    static getTestDetails(label, element){
        return $.ajax({
            url : label.urlDetails,
            type : 'post',
            aysnc: false,
            data: {
                data: JSON.stringify(element),
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },       
            success: function(data) {
            },error: function(data){
            }
        });
    }
  }

  class UI{

    static buildRefreshTileLoader(label, target, name){
      target.querySelector(".single_dashboard_card_content").remove()
      const div = document.createElement("div")
      div.classList.add("page_speed_content")
      div.innerHTML =  
      `<div class="progress">
        <div class="progress-bar dashboard-page-speed-progress" role="progressbar" aria-label="Success example" style="width: 0%" aria-valuenow="0%" title="" aria-valuemin="0" aria-valuemax="100"> </div>
      </div>
      <span>0%</span>
      <p>Calculating ${name}, please wait...</p>`
      target.querySelector(".single_dashboard_card").appendChild(div)
    }
    
    static recheckStartedAlert(){
      let msg = `Rechecking has started for ${urlsToCheck} Urls.`
      $('.analysis-content-body-message').show()
      displayAlert(".analysis-content-body-message", {
          status: 1,
          msg: msg,
          notHide: true
      })
    }

    static buildDBAlerts(alerts){
      $(".analysis-content-body-message").html("")
      alerts.forEach(alert=>{
        displayAlert(".analysis-content-body-message", {
          status: 3,
          msg: alert.message,
          notHide: true
        })
      })
      $('.analysis-content-body-message').show()
    
    }
    static buildSuccessMessage(type, label){
      let msg
      if(type === "recheck"){
        msg = `Your dashboard has been rechecked for ${urlsToCheck} Urls.`
      }else if(type === "single_recheck"){
        msg = `Your dashboard has been rechecked for ${originalUrls.length} Urls for the test "${label.display_name}".`
      }else{
        msg = `Your dashboard has been prepared for ${urlsToCheck} Urls. The current project has ${urls.length} Urls. To see data for the entire project, please <a id="recheckHyperlink" href="javascript:void()">re-check</a> once.`
      }
      $('.analysis-content-body-message').show()
      displayAlert(".analysis-content-body-message", {
          status: 3,
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

    static showWaitingMessage(){
      // Remove any existing waiting message first
      this.removeWaitingMessage();
      let msg = "Please wait while we finish the current queue of tests before starting the recheck."
      displayAlert(".analysis-content-body-message", {
        status: 1,
        msg: msg,
        notHide: true
      })
      
      // const div = document.createElement("div")
      // div.id = "waiting-message"
      // div.classList.add("main-tricker-progress")
      // div.innerHTML = `
      //         <div class="gif-loader">
      //           <img src="/new-assets/assets/images/preloader1.gif" alt="icon">
      //         </div>
      //         <div class="single-tricker-progress">
      //           <div class="rechecking-page">
      //             <span class="primary-span">Waiting for current tests to complete...</span>
      //             <span class="dark-span">Please wait while we finish the current queue of tests before starting the recheck.</span>
      //           </div>
      //         </div>`
      // document.querySelector(".dashboard_recheck_area").prepend(div)
    }

    static removeWaitingMessage(){
      const existingMessage = document.querySelector("#waiting-message")
      if (existingMessage) {
        existingMessage.remove()
      }
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

    static buildWidgetSidebar(){
      document.querySelector(".dashboard_offcanvas_content").innerHTML = ""

      let status = false
      if(seoLabels.length > 0){
        status = UI.getWidgetElement(seoLabels, "SEO") || status
      }

      if(performanceLabels.length > 0){
        status = UI.getWidgetElement(performanceLabels, "Performance") || status
      }

      if(securityLabels.length > 0){
        status = UI.getWidgetElement(securityLabels, "Security", {display_name: "Security Labels", db_name:"security_labels"}) || status
      }

      if(cbpLabels.length > 0){
        status = UI.getWidgetElement(cbpLabels, "Coding Best Practices", {display_name: "Coding Best Practices", db_name:"cbp_labels"}) || status
      }

      if(!status){
        const p = document.createElement("div")
        p.classList.add("single_offcanvas_items")
        p.classList.add("ms-2")
        p.innerHTML = "All tests are added."
        document.querySelector(".dashboard_offcanvas_content").appendChild(p)
      }
    }

    static getWidgetElement(listItems, heading, extra){
      let showStatus = false
      const div = document.createElement("div")
      div.classList.add("single_offcanvas_items")
      div.innerHTML+=`<p class="offcanvas_item_title">${heading}</p>`
      const ul = document.createElement("ul")

      if(heading != "Security" && heading != "Coding Best Practices"){
        listItems.forEach(item=>{
          if(item.is_dashboard_status){
            if(!item.show_dashboard_status){
              showStatus = true
              ul.innerHTML+=`<li>${item.display_name}<a data-label="${item.db_name}" class="add-tile add_widget_btn">+Add</a></li>`
            }
          }
        })
      }else{
        const status = Controls.getShowDashboardStatus2(listItems)
        if(listItems[0].is_dashboard_status){
          if(!status){
            showStatus = true
            ul.innerHTML+=`<li>${extra.display_name}<a data-label="${extra.db_name}" class="add-tile add_widget_btn">+Add</a></li>`
          }
        }
      }
      div.appendChild(ul)

      if(showStatus){
        document.querySelector(".dashboard_offcanvas_content").appendChild(div)
      }

      return showStatus
    }


    static buildSubmitIdeaWidget(){
      const div = document.createElement("div")
      div.classList.add("single_dashboard_card_main")
      div.innerHTML = `
      <div class="single_dashboard_card">
        <div class="dashboard_title">
          <p class="text_16_bld">Submit Your Idea</p>
        </div>
        <div class="dashboard_submit_content">
          <p>
            Is there anything that you would like to see in
            Dashboard
          </p>
          <form method="POST" id="submitIdeaForm">
            <textarea id="submitIdeaWidgetMsg"></textarea>
            <span>0/200</span>
            <div class="dasboard_submit_btn">
              <button id="submitIdeaWidgetBtn" type="submit">Submit Idea</button>
            </div>
          </form>
        </div>
      </div>`

    document.querySelector(".dashboard_top_items_main").appendChild(div)
    }

    static buildAddWidget(){
      const div = document.createElement("div")
      div.classList.add("add_Widget_area_main")
      div.innerHTML = `
       <div class="add_Widget_area">
          <button
            class="btn"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample"
          >
            <img src="/new-assets/assets/images/add-widget.svg" alt="icon" />
          </button>

          <span>Add Widget</span>
        </div>
      `
      document.querySelector(".dashboard_top_items_main").appendChild(div)
    }


    static buildLoaderCards(data){
        for (const [key, value] of Object.entries(data)) {
            const element = data[key]
            if(key === "security_labels" || key === "cbp_labels" || element.length > 0 || key === "images"){
              let status = false
              let label 
              let show_dashboard_status = Controls.getShowDashboardStatus(element)


              if(key === "security_labels"){
                  status = show_dashboard_status
                  label = {
                    display_name: "Security Headers",
                    urlDetails: "/test-details/security-headers",
                    reportsUrl: "/reports/security-headers",
                    db_name: "security_labels"
                  }

              }else if(key === "cbp_labels"){
                status = show_dashboard_status
                label = {
                  display_name: "HTML Best Practices",
                  urlDetails: "/test-details/coding-best-practices",
                  reportsUrl: "/reports/coding-best-practices",
                  db_name: "cbp_labels"
                }

              }else{

                if(key === "images"){
                  label = Controls.getActiveLabel("images")
                }else{
                  label = Controls.getActiveLabel(element[0].label.db_name)
                }

                if(label.db_name === "xml_sitemap"){
                  label.display_name = "Sitemap"
                }
              }


              if(label.show_dashboard_status || status){ // making sure the test has at least one url
                Controls.manageSingleCard(element, key, label, false)
              }
            }
          }
    }


    static getSingleLoaderCardElement(label, data){
        let element
        const settings = data.settings
        // Get the label object to access reportsUrl
        const labelObj = Controls.getActiveLabel(label)
        const reportsUrl = labelObj && labelObj.reportsUrl ? labelObj.reportsUrl : "#"
      
        switch(label){
            case "page_size":
                element =  `
                <div class="mobile_friendly_content">
                  <div class="single_mobile_friendly">
                    <p>Total URLs</p>
                    <h3>${data.totalUrls}</h3>
                  </div>
                  <div class="single_mobile_friendly">
                    <p>URLS with page size (<${settings.page_size_val} KB)</p>
                    <h3 class="${data.pageSizePassed > 0 ? 'success' : 'danger'}">${data.pageSizePassed}</h3>
                  </div>
                  <div class="single_mobile_friendly">
                    <p>URLS with page size (>${settings.page_size_val} KB)</p>
                    <h3 class="${data.pageSizeFailed > 0 ? 'danger' : 'success'}">${data.pageSizeFailed}</h3>
                  </div>
                </div>
                <div class="inner_dashboard_footer">
                  <a href="${reportsUrl}">View Report</a>
                </div>`
                break;
            case "meta_title":
                element =  `
                <div class="deshboard_inner_description border_bottom">
                    <p>Duplicate title tags <span class="${data.duplicate > 0 ? 'danger' : 'success'}">${data.duplicate}</span></p>
                    <p>Title tag equals to H1 tag <span class="${data.equalH1 > 0 ? 'danger' : 'success'}">${data.equalH1}</span></p>
                    <p>No title tags <span class="${data.noContent > 0 ? 'danger' : 'success'}">${data.noContent}</span></p>
                </div>
                <div class="deshboard_inner_description border_bottom">
                    <p class="text_14_bld">Length</p>
                    <p>Long title tag content (>65 characters)<span class="${data.lengthOver > 0 ? 'danger' : 'success'}">${data.lengthOver}</span></p>
                    <p>Short title tag content (<30 characters)<span class="${data.lengthBelow > 0 ? 'danger' : 'success'}">${data.lengthBelow}</span></p>
                </div>
                <div class="deshboard_inner_description mb-4">
                    <p class="text_14_bld">Casing</p>
                    <p>Camel casing<span>${data.casingCamel}</span></p>
                    <p>Sentence casing<span>${data.casingSentence}</span></p>
                    <p>No casing<span>${data.casingUndefined}</span></p>
                </div>
                <div class="inner_dashboard_footer">
                    <a href="${reportsUrl}">View Report</a>
                </div>`
                break;
            case "meta_desc":
                element =  `
                <div class="deshboard_inner_description border_bottom">
                    <p>Duplicate meta description <span class="${data.duplicate > 0 ? 'danger' : 'success'}">${data.duplicate}</span></p>
                    <p>No meta description <span class="${data.noContent > 0 ? 'danger' : 'success'}">${data.noContent}</span></p>
                </div>
                <div class="deshboard_inner_description border_bottom">
                    <p class="text_14_bld">Length</p>
                    <p>Long meta description content (>160 characters)<span class="${data.lengthOver > 0 ? 'danger' : 'success'}">${data.lengthOver}</span></p>
                    <p>Short meta description content (<30 characters)<span class="${data.lengthBelow > 0 ? 'danger' : 'success'}">${data.lengthBelow}</span></p>
                </div>
                <div class="inner_dashboard_footer">
                    <a href="${reportsUrl}">View Report</a>
                </div>`
                break;
            case "robots_meta":
                element =  `
                <div class="deshboard_inner_description border_bottom">
                  <p>URL's with Robots meta tag<span>${data.withRobotsMeta}</span></p>
                  <p>URL's without Robots meta tag<span>${data.withoutRobotsMeta}</span></p>
                </div>
                <div class="deshboard_inner_description">
                  <p>URL's with Noindex, Nofollow<span>${data.withNoIndexNofollow}</span></p>
                  <p>URL's with Noindex<span>${data.withNoIndex}</span></p>
                </div>
                <div class="inner_dashboard_footer">
                  <a href="${reportsUrl}">View Report</a>
                </div>`
                break;
            case "canonical_url":
                element =  `
                <div class="deshboard_inner_description border_bottom">
                  <p>
                    URL's with Canonical tag
                    <span>${data.withCanonical}</span>
                  </p>
                  <p>
                    URL's without Canonical tag<span>${data.withoutCanonical}</span>
                  </p>
                </div>
                <div class="inner_dashboard_footer">
                  <a href="${reportsUrl}">View Report</a>
                </div>`
                break;
            case "open_graph_tags":
                element = `    <div class="dashboard_graph_content common_tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link active"
                      id="graph-title-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#graph-title"
                      type="button"
                      role="tab"
                      aria-controls="graph-title"
                      aria-selected="true"
                    >
                      Title
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link"
                      id="graph-description-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#graph-description"
                      type="button"
                      role="tab"
                      aria-controls="graph-description"
                      aria-selected="false"
                    >
                      Description
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link"
                      id="graph-images-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#graph-images"
                      type="button"
                      role="tab"
                      aria-controls="graph-images"
                      aria-selected="false"
                    >
                      Images
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link"
                      id="graph-url-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#graph-url"
                      type="button"
                      role="tab"
                      aria-controls="graph-url"
                      aria-selected="false"
                    >
                      URL
                    </button>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div
                    class="tab-pane fade show active"
                    id="graph-title"
                    role="tabpanel"
                    aria-labelledby="graph-title-tab"
                  >
                    <div class="dashboard_graph_title_content">
                      <p class="text_12"># of pages</p>
                      <div class="deshboard_inner_description">
                        <p>Total URL's<span>${data.totalUrls}</span></p>
                        <p>
                          Total URL's with Open graph title tag<span
                          class="${data.OGTitleElementExists === data.totalUrls ? 'success' : 'danger'}"
                            >${data.OGTitleElementExists}</span
                          >
                        </p>
                        <p>
                          URL's with OG title too long<span class="${data.OGTitleLengthOver > 0 ? 'danger' : 'success'}"
                            >${data.OGTitleLengthOver}</span
                          >
                        </p>
                        <p>
                          URL's with OG title too short<span
                            class="${data.OGTitleLengthBelow > 0 ? 'danger' : 'success'}"
                            >${data.OGTitleLengthBelow}</span
                          >
                        </p>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="graph-description"
                    role="tabpanel"
                    aria-labelledby="graph-description-tab"
                  >
                    <div class="dashboard_graph_description_content">
                      <p class="text_12"># of pages</p>
                      <div class="deshboard_inner_description">
                        <p>Total URL's<span>${data.totalUrls}</span></p>
                        <p>
                          Total URL's with Open graph description tag<span
                          class="${data.OGDescElementExists === data.totalUrls ? 'success' : 'danger'}"
                            >${data.OGDescElementExists}</span
                          >
                        </p>
                        <p>
                          URL's with OG description too long<span class="${data.OGDescLengthOver > 0 ? 'danger' : 'success'}"
                            >${data.OGDescLengthOver}</span
                          >
                        </p>
                        <p>
                          URL's with OG description too short<span
                            class="${data.OGDescLengthBelow > 0 ? 'danger' : 'success'}"
                            >${data.OGDescLengthBelow}</span
                          >
                        </p>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="graph-images"
                    role="tabpanel"
                    aria-labelledby="graph-images-tab"
                  >
                    <div class="dashboard_graph_images_content">
                      <p class="text_12"># of pages</p>
                      <div class="deshboard_inner_description">
                        <p>Total URL's<span>${data.totalUrls}</span></p>
                        <p>
                          Total URL's with Open Graph Image<span
                          class="${data.OGImageElementExists === data.totalUrls ? 'success' : 'danger'}"
                            >${data.OGImageElementExists}</span
                          >
                        </p>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="graph-url"
                    role="tabpanel"
                    aria-labelledby="graph-url-tab"
                  >
                    <div class="dashboard_graph_url_content">
                      <p class="text_12"># of pages</p>
                      <div class="deshboard_inner_description">
                        <p>Total URL's<span>${data.totalUrls}</span></p>
                        <p>Total URL's with Open Graph URL<span
                        class="${data.OGUrlElementExists === data.totalUrls ? 'success' : 'danger'}"
                            >${data.OGUrlElementExists}</span
                          >
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="inner_dashboard_footer">
                <a href="${reportsUrl}">View Report</a>
              </div>`
                break;
            case "twitter_tags":
                element = `<div class="dashboard_graph_content common_tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link active"
                      id="graph-twitter-title-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#graph-twitter-title"
                      type="button"
                      role="tab"
                      aria-controls="graph-twitter-title"
                      aria-selected="true"
                    >
                      Title
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link"
                      id="graph-twitter-images-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#graph-twitter-images"
                      type="button"
                      role="tab"
                      aria-controls="graph-twitter-images"
                      aria-selected="false"
                    >
                      Image
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link"
                      id="graph-twitter-alt-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#graph-twitter-alt"
                      type="button"
                      role="tab"
                      aria-controls="graph-twitter-alt"
                      aria-selected="false"
                    >
                      Image Alt
                    </button>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div
                    class="tab-pane fade show active"
                    id="graph-twitter-title"
                    role="tabpanel"
                    aria-labelledby="graph-twitter-title-tab"
                  >
                    <div class="dashboard_graph_title_content">
                      <p class="text_12"># of pages</p>
                      <div class="deshboard_inner_description">
                        <p>Total URL's<span>${data.totalUrls}</span></p>
                        <p>
                          Total URL's with Twitter title tag<span
                          class="${data.twitterTitleElementExists === data.totalUrls ? 'success' : 'danger'}"
                            >${data.twitterTitleElementExists}</span
                          >
                        </p>
                        <p>
                          URL's with Twitter title too long<span class="${data.twitterTitleLengthOver > 0 ? 'danger' : 'success'}"
                            >${data.twitterTitleLengthOver}</span
                          >
                        </p>
                        <p>
                          URL's with Twitter title too short<span
                          class="${data.twitterTitleLengthBelow > 0 ? 'danger' : 'success'}"
                            >${data.twitterTitleLengthBelow}</span
                          >
                        </p>
                      </div>
                    </div>
                  </div>
           
                  <div
                    class="tab-pane fade"
                    id="graph-twitter-images"
                    role="tabpanel"
                    aria-labelledby="graph-twitter-images-tab"
                  >
                    <div class="dashboard_graph_images_content">
                      <p class="text_12"># of pages</p>
                      <div class="deshboard_inner_description">
                        <p>Total URL's<span>${data.totalUrls}</span></p>
                        <p>
                          Total URL's with Twitter Image<span
                          class="${data.twitterImageElementExists === data.totalUrls ? 'success' : 'danger'}"
                            >${data.twitterImageElementExists}</span
                          >
                        </p>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="graph-twitter-alt"
                    role="tabpanel"
                    aria-labelledby="graph-twitter-alt-tab"
                  >
                    <div class="dashboard_graph_url_content">
                      <p class="text_12"># of pages</p>
                      <div class="deshboard_inner_description">
                        <p>Total URL's<span>${data.totalUrls}</span></p>
                        <p>
                          Total URL's with Twitter Image Alt<span
                          class="${data.twitterImageAltElementExists === data.totalUrls ? 'success' : 'danger'}"
                            >${data.twitterImageAltElementExists}</span
                          >
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="inner_dashboard_footer">
                <a href="${reportsUrl}">View Report</a>
              </div>`
                break;
            case "http_status_code":
              element = `
                  <div class="http_status_content common_tab">
                      <div class="tab-content" id="myTabContent">
                        <div class="dashboard_http_pages_content">
                            <div class="deshboard_inner_description">
                              <p class="pb-3">
                                URLs with 200 OK status code<span class="${data.http200 > 0 ? 'success' : 'danger'}">${data.http200}</span>
                              </p>
                              <p>
                                URLs with 1XX status code<span class="${data.http100x > 0 ? 'danger' : 'success'}">${data.http100x}</span>
                              </p>
                               <p>
                                URLs with 2XX status code<span class="${data.http200x > 0 ? 'danger' : 'success'}">${data.http200x}</span>
                              </p>
                              <p>
                                URLs with 3XX status code<span class="${data.http300x > 0 ? 'danger' : 'success'}">${data.http300x}</span>
                              </p>
                              <p>
                                URLs with 4XX status code<span class="${data.http400x > 0 ? 'danger' : 'success'}">${data.http400x}</span></p>
                              <p>
                                URLs with 5XX status code<span class="${data.http500x > 0 ? 'danger' : 'success'}">${data.http500x}</span>
                              </p>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="inner_dashboard_footer">
                      <a href="${reportsUrl}">View Report</a>
                    </div>`
              break;
              case "broken_links":
                element =  `
                <div class="deshboard_inner_description border_bottom total-broken-links-container">
                    <p class="total-broken-links"><b>${data.totalBrokenInternal + data.totalBrokenExternal}</b></p>
                    <p>Broken links found on this website</p>
                </div>
                <div class="deshboard_inner_description">
                    <p>Pages with broken links <span class="">${data.totalBrokenWebPages}/${data.totalUrls}</span></p>
                    <p>Internal broken links <span class="">${data.totalBrokenInternal}</span></p>
                    <p>External broken links <span class="">${data.totalBrokenExternal}</span></p>
                </div>
                <div class="inner_dashboard_footer">
                    <a href="${reportsUrl}">View Report</a>
                </div>`
                break;
            case "security_labels":
                element = ` <div class="security_table">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="border_none"></th>
                        <th class="gray-bg text-center">Enabled</th>
                        <th class="gray-bg text-center">Not Enabled</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Safe browsing</td>
                        <td class="text-center ${data.safeBrowsingEnabled > 0 ? 'success' : ''}">${data.safeBrowsingEnabled}</td>
                        <td class="text-center ${data.safeBrowsingDisabled > 0 ? 'danger' : ''}">${data.safeBrowsingDisabled}</td>
                      </tr>
                      <tr>
                        <td>Cross Origin Links</td>
                        <td class="text-center ${data.crossOriginLinksEnabled > 0 ? 'success' : ''}">${data.crossOriginLinksEnabled}</td>
                        <td class="text-center ${data.crossOriginLinksDisabled > 0 ? 'danger' : ''}">${data.crossOriginLinksDisabled}</td>
                      </tr>
                      <tr>
                        <td>Protocol Relative Resource</td>
                        <td class="text-center ${data.protocolRelativeEnabled > 0 ? 'success' : ''}">${data.protocolRelativeEnabled}</td>
                        <td class="text-center ${data.protocolRelativeDisabled > 0 ? 'danger' : ''}">${data.protocolRelativeDisabled}</td>
                      </tr>
                      <tr>
                        <td>Content Security Policy Header</td>
                        <td class="text-center ${data.contentSecurityEnabled > 0 ? 'success' : ''}">${data.contentSecurityEnabled}</td>
                        <td class="text-center ${data.contentSecurityDisabled > 0 ? 'danger' : ''}">${data.contentSecurityDisabled}</td>
                      </tr>
                      <tr>
                        <td>X Frame Options Header</td>
                        <td class="text-center ${data.xFrameOptionsEnabled > 0 ? 'success' : ''}">${data.xFrameOptionsEnabled}</td>
                        <td class="text-center ${data.xFrameOptionsDisabled > 0 ? 'danger' : ''}">${data.xFrameOptionsDisabled}</td>
                      </tr>
                      <tr>
                        <td>HSTS Header</td>
                        <td class="text-center ${data.hstsHeaderEnabled > 0 ? 'success' : ''}">${data.hstsHeaderEnabled}</td>
                        <td class="text-center ${data.hstsHeaderDisabled > 0 ? 'danger' : ''}">${data.hstsHeaderDisabled}</td>
                      </tr>
                      <tr>
                        <td>Bad content Type</td>
                        <td class="text-center ${data.badContentEnabled > 0 ? 'success' : ''}">${data.badContentEnabled}</td>
                        <td class="text-center ${data.badContentDisabled > 0 ? 'danger' : ''}">${data.badContentDisabled}</td>
                      </tr>
                      <tr>
                        <td>SSL Certificate Enable</td>
                        <td class="text-center ${data.sslCertificateEnabled > 0 ? 'success' : ''}">${data.sslCertificateEnabled}</td>
                        <td class="text-center ${data.sslCertificateDisabled > 0 ? 'danger' : ''}">${data.sslCertificateDisabled}</td>
                      </tr>
                      <tr>
                        <td>Folder Browsing</td>
                        <td class="text-center ${data.folderBrowsingEnabled > 0 ? 'danger' : ''}">${data.folderBrowsingEnabled}</td>
                        <td class="text-center ${data.folderBrowsingDisabled > 0 ? 'success' : ''}">${data.folderBrowsingDisabled}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="inner_dashboard_footer">
                <a href="${reportsUrl}">View Report</a>
              </div>`;
                break;
            case "mobile_friendly":
              element = `   <div class="mobile_friendly_content">
              <div class="single_mobile_friendly">
                <p>Total URLs</p>
                <h3>${data.totalUrls}</h3>
              </div>
              <div class="single_mobile_friendly">
                <p>Mobile Friendly URLs</p>
                <h3 class="${data.mobileFriendlyPassed > 0 ? 'success' : 'danger'}">${data.mobileFriendlyPassed}</h3>
              </div>
              <div class="single_mobile_friendly">
                <p>Not Mobile Friendly URLs</p>
                <h3 class="${data.mobileFriendlyFailed > 0 ? 'danger' : 'success'}">${data.mobileFriendlyFailed}</h3>
              </div>
            </div>
            <div class="inner_dashboard_footer">
              <a href="#">View Report</a>
            </div>`
              break;
            case "google_overall":
              element = `
              <div class="google_page_content">
              <div class="google_page_top_items">
                <div class="google_page_single_item">
                  <h3 class="${data.colorDesktop}">${getRoundedNumber(data.desktopOverallAvg)}</h3>
                  <div class="google_top_des">
                    <p>Average</p>
                    <p><span>Desktop</span> Score</p>
                  </div>
                </div>
                <div class="google_page_single_item">
                  <h3 class="${data.colorMobile}">${getRoundedNumber(data.mobileOverallAvg)}</h3>
                  <div class="google_top_des">
                    <p>Average</p>
                    <p><span>Mobile</span> Score</p>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="google_page_tab_content desk_mobile_tab common_tab"
            >
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="google-desktop-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#google-desktop"
                    type="button"
                    role="tab"
                    aria-controls="google-desktop"
                    aria-selected="true"
                  >
                    Desktop
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="google-mobile-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#google-mobile"
                    type="button"
                    role="tab"
                    aria-controls="google-mobile"
                    aria-selected="false"
                  >
                    Mobile
                  </button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div
                  class="tab-pane fade show active"
                  id="google-desktop"
                  role="tabpanel"
                  aria-labelledby="google-desktop-tab"
                >
                  <div class="google_inner_content">
                    <div class="single_google_line">
                      <p>
                        <img src="/new-assets/assets/images/green.png" alt="box" />
                        Good
                      </p>
                      <span>${getRoundedNumber(data.desktopGood)}</span>
                    </div>
                    <div class="single_google_line">
                      <p>
                        <img src="/new-assets/assets/images/orange.png" alt="box" />
                        Average
                      </p>
                      <span>${getRoundedNumber(data.desktopAvg)}</span>
                    </div>
                    <div class="single_google_line">
                      <p>
                        <img src="/new-assets/assets/images/red.png" alt="box" />
                        Poor
                      </p>
                      <span>${getRoundedNumber(data.desktopPoor)}</span>
                    </div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="google-mobile"
                  role="tabpanel"
                  aria-labelledby="google-mobile-tab"
                >
                  <div class="google_inner_content">
                    <div class="single_google_line">
                      <p>
                        <img src="/new-assets/assets/images/green.png" alt="box" />
                        Good
                      </p>
                      <span>${getRoundedNumber(data.mobileGood)}</span>
                    </div>
                    <div class="single_google_line">
                      <p>
                        <img src="/new-assets/assets/images/orange.png" alt="box" />
                        Average
                      </p>
                      <span>${getRoundedNumber(data.mobileAvg)}</span>
                    </div>
                    <div class="single_google_line">
                      <p>
                        <img src="/new-assets/assets/images/red.png" alt="box" />
                        Poor
                      </p>
                      <span>${getRoundedNumber(data.mobilePoor)}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="inner_dashboard_footer">
              <a href="${reportsUrl}">View Report</a>
            </div>
              `
            break;
            case "google_lighthouse":

              element = `
              <div
              class="Lighthouse_tab_content desk_mobile_tab common_tab"
            >
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="Lighthouse-desktop-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#Lighthouse-desktop"
                    type="button"
                    role="tab"
                    aria-controls="Lighthouse-desktop"
                    aria-selected="true"
                  >
                    Desktop
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="Lighthouse-mobile-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#Lighthouse-mobile"
                    type="button"
                    role="tab"
                    aria-controls="Lighthouse-mobile"
                    aria-selected="false"
                  >
                    Mobile
                  </button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div
                  class="tab-pane fade show active"
                  id="Lighthouse-desktop"
                  role="tabpanel"
                  aria-labelledby="Lighthouse-desktop-tab"
                >
                  <div class="Lighthouse_table_content">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center gray-bg"></th>
                            <th class="text-center gray-bg">
                              Performance
                            </th>
                            <th class="text-center gray-bg">
                              Accessibility
                            </th>
                            <th class="text-center gray-bg">SEO</th>
                            <th class="text-center gray-bg">
                              Best Practices
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="border_bottom">
                              <p>
                                <img
                                  src="/new-assets/assets/images/green.png"
                                  alt="box"
                                />Good
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopGoodPer)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopGoodAcc)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopGoodSeo)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopGoodBP)}
                            </td>
                          </tr>

                          <tr>
                            <td class="border_bottom">
                              <p>
                                <img
                                  src="/new-assets/assets/images/orange.png"
                                  alt="box"
                                />Average
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopAvgPer)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopAvgAcc)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopAvgSeo)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopAvgBP)}
                            </td>
                          </tr>

                          <tr>
                            <td class="pb-3">
                              <p>
                                <img
                                  src="/new-assets/assets/images/red.png"
                                  alt="box"
                                />Poor
                              </p>
                            </td>
                            <td class="text-center pb-3">${getRoundedNumber(data.desktopPoorPer)}</td>
                            <td class="text-center pb-3">${getRoundedNumber(data.desktopPoorAcc)}</td>
                            <td class="text-center pb-3">${getRoundedNumber(data.desktopPoorSeo)}</td>
                            <td class="text-center pb-3">${getRoundedNumber(data.desktopPoorBP)}</td>
                          </tr>

                          <tr>
                            <td><p>Average</p></td>
                            <td class="text-center ${data.colorPerDesktop}">${getRoundedNumber(data.desktopPerAvg)}</td>
                            <td class="text-center ${data.colorAccDesktop}">${getRoundedNumber(data.desktopAccAvg)}</td>
                            <td class="text-center ${data.colorSeoDesktop}">${getRoundedNumber(data.desktopSeoAvg)}</td>
                            <td class="text-center ${data.colorBPDesktop}">${getRoundedNumber(data.desktopBPAvg)}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="Lighthouse-mobile"
                  role="tabpanel"
                  aria-labelledby="Lighthouse-mobile-tab"
                >
                  <div class="Lighthouse_table_content">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center gray-bg"></th>
                            <th class="text-center gray-bg">
                              Performance
                            </th>
                            <th class="text-center gray-bg">
                              Accessibility
                            </th>
                            <th class="text-center gray-bg">SEO</th>
                            <th class="text-center gray-bg">
                              Best Practices
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="border_bottom">
                              <p>
                                <img
                                  src="/new-assets/assets/images/green.png"
                                  alt="box"
                                />Good
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileGoodPer)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileGoodAcc)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileGoodSeo)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileGoodBP)}
                            </td>
                          </tr>

                          <tr>
                            <td class="border_bottom">
                              <p>
                                <img
                                  src="/new-assets/assets/images/orange.png"
                                  alt="box"
                                />Average
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileAvgPer)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileAvgAcc)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileAvgSeo)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileAvgBP)}
                            </td>
                          </tr>

                          <tr>
                            <td class="pb-3">
                              <p>
                                <img
                                  src="/new-assets/assets/images/red.png"
                                  alt="box"
                                />Poor
                              </p>
                            </td>
                            <td class="text-center pb-3">${getRoundedNumber(data.mobilePoorPer)}</td>
                            <td class="text-center pb-3">${getRoundedNumber(data.mobilePoorAcc)}</td>
                            <td class="text-center pb-3">${getRoundedNumber(data.mobilePoorSeo)}</td>
                            <td class="text-center pb-3">${getRoundedNumber(data.mobilePoorBP)}</td>
                          </tr>

                          <tr>
                          <td><p>Average</p></td>
                          <td class="text-center ${data.colorPerMobile}">${getRoundedNumber(data.mobilePerAvg)}</td>
                          <td class="text-center ${data.colorAccMobile}">${getRoundedNumber(data.mobileAccAvg)}</td>
                          <td class="text-center ${data.colorBPMobile}">${getRoundedNumber(data.mobileSeoAvg)}</td>
                          <td class="text-center ${data.colorSeoMobile}">${getRoundedNumber(data.mobileBPAvg)}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="inner_dashboard_footer">
              <a href="${reportsUrl}">View Report</a>
            </div>
              `
            break;
            case "core_web_vitals":
              element = `
              <div class="core_tab_content desk_mobile_tab common_tab">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="Core-desktop-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#Core-desktop"
                    type="button"
                    role="tab"
                    aria-controls="Core-desktop"
                    aria-selected="true"
                  >
                    Desktop
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="Core-mobile-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#Core-mobile"
                    type="button"
                    role="tab"
                    aria-controls="Core-mobile"
                    aria-selected="false"
                  >
                    Mobile
                  </button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div
                  class="tab-pane fade show active"
                  id="Core-desktop"
                  role="tabpanel"
                  aria-labelledby="Core-desktop-tab"
                >
                  <div class="Lighthouse_table_content">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center gray-bg"></th>
                            <th class="text-center gray-bg">LCP</th>
                            <th class="text-center gray-bg">FCP</th>
                            <th class="text-center gray-bg">CLS</th>
                            <th class="text-center gray-bg">FID</th>
                            <th class="text-center gray-bg">TTI</th>
                            <th class="text-center gray-bg">SI</th>
                            <th class="text-center gray-bg">TBT</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="border_bottom">
                              <p>
                                <img
                                  src="/new-assets/assets/images/green.png"
                                  alt="box"
                                />Good
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.desktopGoodLCP)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.desktopGoodFCP)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopGoodCLS)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopGoodFID)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopGoodTTI)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.desktopGoodSI)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopGoodTBT)}
                            </td>
                          </tr>

                          <tr>
                            <td class="border_bottom">
                              <p>
                                <img
                                  src="/new-assets/assets/images/orange.png"
                                  alt="box"
                                />Average
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.desktopAvgLCP)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.desktopAvgFCP)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopAvgCLS)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopAvgFID)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopAvgTTI)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.desktopAvgSI)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopAvgTBT)}
                            </td>
                          </tr>

                          <tr>
                            <td class="pb-3">
                              <p>
                                <img
                                  src="/new-assets/assets/images/red.png"
                                  alt="box"
                                />Poor
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.desktopPoorLCP)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.desktopPoorFCP)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopPoorCLS)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopPoorFID)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopPoorTTI)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.desktopPoorSI)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.desktopPoorTBT)}
                            </td>
                          </tr>

                          <tr>
                            <td><p>Average</p></td>
                            <td class="text-center border_bottom ${data.colorLCPDesktop}">
                              ${getRoundedNumber(data.desktopLCPAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorFCPDesktop}">
                              ${getRoundedNumber(data.desktopFCPAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorCLSDesktop}">
                            ${getRoundedNumber(data.desktopCLSAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorFIDDesktop}">
                            ${getRoundedNumber(data.desktopFIDAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorTTIDesktop}">
                            ${getRoundedNumber(data.desktopTTIAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorSIDesktop}">
                              ${getRoundedNumber(data.desktopSIAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorTBTDesktop}">
                            ${getRoundedNumber(data.desktopTBTAvg)}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="Core-mobile"
                  role="tabpanel"
                  aria-labelledby="Core-mobile-tab"
                >
                  <div class="Lighthouse_table_content">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center gray-bg"></th>
                            <th class="text-center gray-bg">LCP</th>
                            <th class="text-center gray-bg">FCP</th>
                            <th class="text-center gray-bg">CLS</th>
                            <th class="text-center gray-bg">FID</th>
                            <th class="text-center gray-bg">TTI</th>
                            <th class="text-center gray-bg">SI</th>
                            <th class="text-center gray-bg">TBT</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          <tr>
                            <td class="border_bottom">
                              <p>
                                <img
                                  src="/new-assets/assets/images/green.png"
                                  alt="box"
                                />Good
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.mobileGoodLCP)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.mobileGoodFCP)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileGoodCLS)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileGoodFID)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileGoodTTI)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.mobileGoodSI)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileGoodTBT)}
                            </td>
                          </tr>

                          <tr>
                            <td class="border_bottom">
                              <p>
                                <img
                                  src="/new-assets/assets/images/orange.png"
                                  alt="box"
                                />Average
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.mobileAvgLCP)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.mobileAvgFCP)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileAvgCLS)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileAvgFID)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileAvgTTI)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.mobileAvgSI)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobileAvgTBT)}
                            </td>
                          </tr>

                          <tr>
                            <td class="pb-3">
                              <p>
                                <img
                                  src="/new-assets/assets/images/red.png"
                                  alt="box"
                                />Poor
                              </p>
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.mobilePoorLCP)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.mobilePoorFCP)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobilePoorCLS)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobilePoorFID)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobilePoorTTI)}
                            </td>
                            <td class="text-center border_bottom">
                              ${getRoundedNumber(data.mobilePoorSI)}
                            </td>
                            <td class="text-center border_bottom">
                            ${getRoundedNumber(data.mobilePoorTBT)}
                            </td>
                          </tr>

                          <tr>
                            <td><p>Average</p></td>
                            <td class="text-center border_bottom ${data.colorLCPMobile}"">
                              ${getRoundedNumber(data.mobileLCPAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorFCPMobile}"">
                              ${getRoundedNumber(data.mobileFCPAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorCLSMobile}"">
                            ${getRoundedNumber(data.mobileCLSAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorFIDMobile}"">
                            ${getRoundedNumber(data.mobileFIDAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorTTIMobile}"">
                            ${getRoundedNumber(data.mobileTTIAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorSIMobile}"">
                              ${getRoundedNumber(data.mobileSIAvg)}
                            </td>
                            <td class="text-center border_bottom ${data.colorTBTMobile}"">
                            ${getRoundedNumber(data.mobileTBTAvg)}
                            </td>
                          </tr>
                        </tbody>

                          
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="inner_dashboard_footer">
              <a href="${reportsUrl}">View Report</a>
            </div>
              `
            break;
            case "cbp_labels":
              element = `
              <div class="html_best_practice">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="gray-bg">Compressions</th>
                      <th class="gray-bg text-center">Enabled</th>
                      <th class="gray-bg text-center">Not Enabled</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>HTML Compression</td>
                      <td class="text-center ${data.htmlCompressed > 0 ? 'success' : ''}">${data.htmlCompressed}</td>
                      <td class="text-center ${data.htmlNotCompressed > 0 ? 'danger' : ''}">${data.htmlNotCompressed}</td>
                    </tr>
                    <tr>
                      <td>JS Compression</td>
                      <td class="text-center ${data.jsCompressed > 0 ? 'success' : ''}">${data.jsCompressed}</td>
                      <td class="text-center ${data.jsNotCompressed > 0 ? 'danger' : ''}">${data.jsNotCompressed}</td>
                    </tr>
                    <tr>
                      <td>CSS Compression</td>
                      <td class="text-center ${data.cssCompressed > 0 ? 'success' : ''}">${data.cssCompressed}</td>
                      <td class="text-center ${data.cssNotCompressed > 0 ? 'danger' : ''}">${data.cssNotCompressed}</td>
                    </tr>
                    <tr>
                      <td>Grip Compression</td>
                      <td class="text-center ${data.gzipCompressed > 0 ? 'success' : ''}">${data.gzipCompressed}</td>
                      <td class="text-center ${data.gzipNotCompressed > 0 ? 'danger' : ''}">${data.gzipNotCompressed}</td>
                    </tr>
                    <tr>
                      <td class="gray-bg">Others</td>
                      <td class="gray-bg text-center">Pages with</td>
                      <td class="gray-bg text-center">Pages without</td>
                    </tr>
                    <tr>
                      <td>CSS caching enable</td>
                      <td class="text-center ${data.cssCachingEnable > 0 ? 'success' : ''}">${data.cssCachingEnable}</td>
                      <td class="text-center ${data.cssCachingNotEnable > 0 ? 'danger' : ''}">${data.cssCachingNotEnable}</td>
                    </tr>
                   <tr>
                      <td>JS caching enable</td>
                      <td class="text-center ${data.jsCachingEnable > 0 ? 'success' : ''}">${data.jsCachingEnable}</td>
                      <td class="text-center ${data.jsCachingNotEnable > 0 ? 'danger' : ''}">${data.jsCachingNotEnable}</td>
                    </tr>
                    <tr>
                      <td>Nested Tables</td>
                      <td class="text-center ${data.nestedTables > 0 ? 'success' : ''}">${data.nestedTables}</td>
                      <td class="text-center ${data.nestedTablesWithout > 0 ? 'danger' : ''}">${data.nestedTablesWithout}</td>
                    </tr>
                    <tr>
                      <td>Frameset</td>
                      <td class="text-center ${data.frameset > 0 ? 'success' : ''}">${data.frameset}</td>
                      <td class="text-center ${data.framesetWithout > 0 ? 'danger' : ''}">${data.framesetWithout}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="inner_dashboard_footer">
              <a href="#">View Report</a>
            </div>
              `
              break;    
            case "xml_sitemap":
            element = `
              <div class="dashboard_sitemap_content common_tab">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button
                            class="nav-link active"
                            id="xml-sitemap-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#xml-sitemap"
                            type="button"
                            role="tab"
                            aria-controls="xml-sitemap"
                            aria-selected="true"
                          >
                            XML Sitemap
                          </button>
                        </li>

                        ${htmlSitemapData != null ? `       
                        <li class="nav-item " role="presentation">
                          <button
                            class="nav-link"
                            id="html-sitemap-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#html-sitemap"
                            type="button"
                            role="tab"
                            aria-controls="html-sitemap"
                            aria-selected="false"
                          >
                            HTML Sitemap
                          </button>
                        </li>` : 
                        ""}

                        
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div
                          class="tab-pane fade show active"
                          id="xml-sitemap"
                          role="tabpanel"
                          aria-labelledby="xml-sitemap-tab"
                        >

                        ${data.fileExists ? `
                          
                          <div class="deshboard_inner_description border_bottom">
                            <div class="roboto_url">
                              <p>
                                <span>Robots.txt URL: </span>
                                <span>
                                  https://www.setmore.com/robots.txt
                                  <img
                                    src="/new-assets/assets/images/copy-link2.png"
                                    alt="icon"
                                /></span>
                              </p>
                            </div>
                            <div class="deshboard_inner_description">
                              <p>URL's found on XML sitemap<span class="${data.sitemapExists === data.totalUrls ? 'success' : 'danger'}">${data.sitemapExists}</span></p>
                              <p>URL's found on website<span>${data.totalUrls}</span></p>
                            </div>


                            ${data.sitemapNotFound.length > 0 ? `
                            <div class="dashboard_sitemap_textarea">
                              <p>URL's not included on XML sitemap</p>
                              <textarea>
                                  ${data.sitemapNotFoundString}
                              </textarea>
                            </div>
                            ` : ``}

                          </div>

                          <div class="inner_dashboard_footer">
                            <a href="${reportsUrl}">View Report</a>
                          </div>
                          ` 
                          
                          
                          : `
                          
                          <div class="deshboard_inner_description border_bottom">
                            <div class="blank_sitemap_content">
                              <img
                                src="/new-assets/assets/images/blank-sitemap.svg"
                                alt="icon"
                              />
                              <p>
                                We could not find XML sitemap on your website
                              </p>
                            </div>
                          </div>

                           <div class="inner_dashboard_footer">
                            <a href="${reportsUrl}">View Report</a>
                            </div>
                          `
                        
                        }
                        </div>




                        <div
                          class="tab-pane fade"
                          id="html-sitemap"
                          role="tabpanel"
                          aria-labelledby="html-sitemap-tab">
                          


                    
                          
                      ${htmlSitemapData != null ? htmlSitemapData.fileExists ? `
                          
                      <div class="deshboard_inner_description border_bottom">
                        <div class="roboto_url">
                          <p>
                            <span>Robots.txt URL: </span>
                            <span>
                              https://www.setmore.com/robots.txt
                              <img
                                src="/new-assets/assets/images/copy-link2.png"
                                alt="icon"
                            /></span>
                          </p>
                        </div>
                        <div class="deshboard_inner_description">
                          <p>URL's found on HTML sitemap<span class="${htmlSitemapData.sitemapExists === htmlSitemapData.totalUrls ? 'success' : 'danger'}">${htmlSitemapData.sitemapExists}</span></p>
                          <p>URL's found on website<span>${htmlSitemapData.totalUrls}</span></p>
                        </div>


                        ${htmlSitemapData.sitemapNotFound.length > 0 ? `
                        <div class="dashboard_sitemap_textarea">
                          <p>URL's not included on HTML sitemap</p>
                          <textarea>
                              ${htmlSitemapData.sitemapNotFoundString}
                          </textarea>
                        </div>
                        ` : ``}

                      </div>

                      <div class="inner_dashboard_footer">
                        <a href="${reportsUrl}">View Report</a>
                      </div>
                      ` 
                      
                      
                      : `
                      
                      <div class="deshboard_inner_description border_bottom">
                        <div class="blank_sitemap_content">
                          <img
                            src="/new-assets/assets/images/blank-sitemap.svg"
                            alt="icon"
                          />
                          <p>
                            We could not find HTML sitemap on your website
                          </p>
                        </div>
                      </div>

                       <div class="inner_dashboard_footer">
                        <a href="${reportsUrl}">View Report</a>
                        </div>
                      `
                    
                      : "" }

                    <div class="inner_dashboard_footer">
                      <a href="${reportsUrl}">View Report</a>
                    </div>
            `
      
              break;
              case "images":
                element = `
                <div div class="dashboard_image_content">
                  <div class="deshboard_inner_description border_bottom">
                    <p>Totals Images <span>${data.totalImages}</span></p>
                    <p>
                      Image file name with high file name characters (>${settings.image_name_max_characters_val} characters) <span class="${data.imageNameLengthOver > 0 ? 'danger' : 'success'}">${data.imageNameLengthOver}</span>
                    </p>
                    <p>
                      Images with missing alternative text <span class="${data.imageNameMissingAlt > 0 ? 'danger' : 'success'}">${data.imageNameMissingAlt}</span>
                    </p>
                    <p>
                      Images with high file size (>${settings.image_max_size_val} KB) <span class="${data.imageSizeOver > 0 ? 'danger' : 'success'}">${data.imageSizeOver}</span>
                    </p>
                  </div>
                </div>
                <div class="inner_dashboard_footer">
                  <a href="${reportsUrl}">View Report</a>
                </div>
                `
                break;
            }
        return element
    }

    static updateSingleLoaderCard(data, element, key, activeLabel){
        let label
        const div = document.createElement("div")
        div.classList.add("single_dashboard_card_content")
        // label.hasDashboardParent ? label = key : label = activeLabel.dbName
        switch(key){
          case "security_labels": case "cbp_labels":
            label = key
            break;
          default:
            label = activeLabel.db_name
            break;
        }
        div.innerHTML =  UI.getSingleLoaderCardElement(label, JSON.parse(data))
        if(document.getElementById(`card_${label}`).querySelector(".page_speed_content")){
          document.getElementById(`card_${label}`).querySelector(".page_speed_content").remove()
          document.getElementById(`card_${label}`).querySelector(".single_dashboard_card").appendChild(div)
        }else{
          document.getElementById(`card_${label}`).querySelector(".broken_links_content").remove()
          document.getElementById(`card_${label}`).querySelector(".single_dashboard_card").appendChild(div)
        }
    }

    static buildSingleLoaderCard(label, buildSingleLoaderCard){
        const div = document.createElement("div")
        div.classList.add("single_dashboard_card_main")
        div.classList.add("tile")
        div.setAttribute("data-label", label.db_name)
        div.id = `card_${label.db_name}`
        div.innerHTML = `
        <div class="single_dashboard_card">
            <div class="dashboard_title">
                <p>${label.display_name}</p>
                <div class="dropdown">
                <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="">
                    <p>
                    <svg class="svg-inline--fa fa-ellipsis-vertical" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis-vertical" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512" data-fa-i2svg=""><path fill="currentColor" d="M64 360c30.9 0 56 25.1 56 56s-25.1 56-56 56s-56-25.1-56-56s25.1-56 56-56zm0-160c30.9 0 56 25.1 56 56s-25.1 56-56 56s-56-25.1-56-56s25.1-56 56-56zM120 96c0 30.9-25.1 56-56 56S8 126.9 8 96S33.1 40 64 40s56 25.1 56 56z"></path></svg><!-- <i class="fa-solid fa-ellipsis-vertical"></i> Font Awesome fontawesome.com -->
                    </p>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li>
                      <button class="refresh-tile">
                      <img src="/new-assets/assets/images/refresh.png" alt="icon">
                      Refresh Data
                      </button>
                    </li>
                    <li>
                      <button class="remove-tile">
                      <img src="/new-assets/assets/images/delete.png" alt="icon">
                      Remove Tile
                      </button>
                    </li>
                </ul>
                </div>
            </div>
            <div class="broken_links_content">
                <img src="/new-assets/assets/images/preloader1.gif" alt="img">
            </div>
        </div>
        `
        if(buildSingleLoaderCard){
          document.querySelector(".dashboard_top_items_main").prepend(div)
        }else{
          document.querySelector(".dashboard_top_items_main").append(div)
        }
    }

    static updateProgressBar(percentage){
        document.querySelector(".dashboard-preparing-progress").innerHTML = ""
        document.querySelector(".dashboard-preparing-progress").style.width = percentage + "%"
        document.querySelector(".dashboard_preparing p").innerHTML = parseInt(percentage) + "%"
    }


    static updateRecheckProgressBar(index, percentage){
      $("#urlRechecked").html(index)
      document.querySelector("#urlRecheckedProgressBar").style.width = percentage + "%"
      document.querySelector("#urlRecheckedProgressText").innerHTML = parseInt(percentage) + "%"
    }


    static updateIndividualProgress(label, index){
        const objDbName = label
        if( document.getElementById(objDbName)){
          document.getElementById(objDbName).querySelector(".taly-done").innerHTML = index
          if(urls.length === index){
              const svg = `<svg class="svg-inline--fa fa-check" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path></svg>`
              document.getElementById(objDbName).querySelector("img").remove()
              const html = svg + document.getElementById(objDbName).querySelector("p").innerHTML
              document.getElementById(objDbName).querySelector("p").innerHTML = html
          }
        }
    }   

    static buildDashboardLoader(){
        const ul = document.createElement("ul")
        allLabels.forEach((label, i)=>{
            if(!label.initialTestingState){
              return;
            }
            if(!ignore_tests.includes(label.db_name)){
              const li = UI.getLoaderElement(label, urls)
              ul.appendChild(li)
            }
        })

        const div = document.createElement("div")
        div.classList.add("dashboard_content")
        div.classList.add("dashboard-loader")
        div.innerHTML = `<div class="dashboard_preparing_content">
                <h4>We are preparing your dashboard for the project "<span id="dashboardLoaderProjectName">${getActiveProjectName()}</span>"</h4>
                <p>please check back in a moment...</p>
        
                <div class="dashboard_preparing">
                <div class="progress">
                    <div
                    class="progress-bar dashboard-preparing-progress"
                    role="progressbar"
                    style="width: 0%"
                    aria-valuenow="0"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    ></div>
                </div>
                <p>0%</p>
                </div>
        
                <div class="preparing_list_item">
                <ul>
                    ${ul.outerHTML}
                </ul>
                </div>
        </div>`
        document.querySelector(".main-sections .container-fluid").appendChild(div)
    }

    static getLoaderElement(label, urls){
        const li = document.createElement("li")
        li.id = label.db_name
        li.classList.add("preparing_list")
        li.innerHTML = `<p><img src="/new-assets/assets/images/loading.gif" alt="loading"> ${label.display_name}</p> <span> <span class="taly-done">0</span>/${urls.length}</span>`  
        return li
    }

    static changeUpdatedTime(project){
      const { DateTime } = luxon;
      const time = project.updated_at
      let value = new DateTime.fromISO(time)
      
      // Get the day with ordinal suffix
      const day = value.day;
      const ordinalSuffix = UI.getOrdinalSuffix(day);
      
      // Format the date with ordinal suffix and GMT time
      const formattedDate = `${day}${ordinalSuffix} ${value.toFormat('MMMM yyyy')}, ${value.toFormat('HH:mm')} local time`;
      
      $("#lastUpdated").html(formattedDate)
    }

    static getOrdinalSuffix(day) {
      if (day >= 11 && day <= 13) {
        return 'th';
      }
      switch (day % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
      }
    }

    static toggleDashboardElements(project){
      UI.changeUpdatedTime(project)
      if(document.querySelector(".dashboard-loader")){
        document.querySelector(".dashboard-loader").remove()
      }
      if(document.querySelector(".main-tricker-progress")){
        document.querySelector(".main-tricker-progress").remove()
      }
      
      document.querySelector(".dashboard-elements").classList.remove("d-none")
      document.querySelector(".project-toggle-container").classList.remove("d-none")
      document.querySelector("#urlSearchForm").classList.remove("d-none")
    }

    static updateSingleTileProgress(target, results, dbName, totalUrls) {
      const progressDetails = Controls.calcProgressDashboard(results)


      // Update the progress bar in the target tile
      const progressBar = target.querySelector('.dashboard-page-speed-progress');
      const progressText = target.querySelector('.page_speed_content span');
      if (progressBar && progressText) {
        progressBar.style.width = progressDetails.progress + "%";
        progressText.innerHTML = progressDetails.progress + "%";
      }
    }
  }



  class Controls{
    static init(){
      buildLoader()

      projectId = getActiveProjectId()


       // Check initial button state
      Controls.checkIfTestsAreRunning().then(testsRunning => {
        UI.updateRecheckButtonState(testsRunning);
      });

      getAllTestLabels2(projectId)
      .done(function(data) {
          allLabels = data.all_labels

          seoLabels = data.seo_labels
          performanceLabels = data.performance_labels
          cbpLabels = data.cbp_labels
          securityLabels = data.security_labels
          Controls.finalizeLabels(allLabels, seoLabels, performanceLabels, cbpLabels, securityLabels)


          DB.getUrlsList(projectId) // GET PROJECT URLS AND START TEST
          .done(function(data){
            originalUrls = data
              urls = data.slice(0, urlsToCheck)

              // CHECKING IF DASHBOARD WAS BUILT
              DB.getDashboardShowStatus(projectId)
              .done(function(data) {
                  if(data.dashboardStatus === 1){

                    Controls.buildDashboard()

                    

                  }else if(data.dashboardStatus === 2){

                    Controls.buildDashboard(data.dashboardStatus)

                    async function checkStatusDashboard() {
                      let controller;
                  
                      while (true) {
                  
                          // Cancel any previous unfinished request
                          if (controller) controller.abort();
                          controller = new AbortController();
                  
                          try {
                              const response = await fetch(`/api/check-status-dashboard/${projectId}`, {
                                  signal: controller.signal
                              });
                  
                              const { status, results } = await response.json();
                              Controls.updateProgressRecheck(results);
                  
                              if (status === 'completed') {
                  
                                  Controls.endTest();
                  
                                  setTimeout(() => {
                                      recheckAllowed = true;
                                      UI.updateRecheckButtonState(false); // re-enable button
                                  }, 100);
                  
                                  break; // stop loop
                              }
                          } catch (e) {
                              // ignore abort errors
                              if (e.name !== "AbortError") console.error(e);
                          }
                  
                          // wait 1 second before next request
                          await new Promise(res => setTimeout(res, 1000));
                      }
                    }
                  
                    checkStatusDashboard();

                  }else if(data.dashboardStatus === 3){
                    Controls.buildDashboard(data.dashboardStatus)

                  }else{ 
                    removeLoader()
                    Controls.buildDashboardLoader()
                    if(data.details_progress != "in_progress"){
                      Controls.startTest(urls, "default")
                    } 

                    
                    let controller;
                    async function checkStatusDashboard() {
                        while (true) {

                            // Cancel previous request if still running
                            if (controller) controller.abort();
                            controller = new AbortController();

                            const response = await fetch(`/api/check-status-dashboard/${projectId}`, {
                                signal: controller.signal
                            });

                            const { status, results } = await response.json();

                            Controls.updateDashboardLoader(results);

                            if (status === 'completed') {
                                Controls.endTest();
                                setTimeout(() => (recheckAllowed = true), 100);
                                break;
                            }

                            await new Promise(res => setTimeout(res, 1000));
                        }
                    }

            
                    checkStatusDashboard()
                    
                  }
              });
             

          })
          
      });
  }
    static displayAlerts(){
      
    }


    static updateDashboardLoader(results) {
  
      const progressDetails = Controls.calcProgressDashboard(results)

      Controls.updateProgress(results, progressDetails.progress, progressDetails.completedCount, progressDetails.total);
  }
  
    


    static finalizeGoogleElements(results){
      const tests = ["google_overall", "google_lighthouse", "core_web_vitals"]
      tests.forEach(test=>{
        const testLabel = Controls.getActiveLabel(test)

        DB.getTestDetails(testLabel, results)
        .done(function(data) {
          UI.updateSingleLoaderCard(data, results, test, testLabel)

        });
      })
    }


    static updateGoogleCards(results){
      let resultsTotal, total
      total = googleUrlsToCheck

      if(results){
        resultsTotal = Object.keys(results).length
      }else{
        resultsTotal = 0
      }

      total = total * 2


      if(document.querySelectorAll(".page_speed_content").length > 0){
        const progress = Controls.getGoogleCurrentProgress(results)
        $("#card_google_overall .dashboard-page-speed-progress, #card_google_lighthouse .dashboard-page-speed-progress, #card_core_web_vitals .dashboard-page-speed-progress").css({width: progress + "%"})
        $("#card_google_overall .page_speed_content span, #card_google_lighthouse .page_speed_content span, #card_core_web_vitals .page_speed_content span").html(progress + "%")

      }else{

        const div = document.createElement("div")
        div.classList.add("page_speed_content")
        div.innerHTML =  
            `<div class="progress">
              <div class="progress-bar dashboard-page-speed-progress" role="progressbar" aria-label="Success example" style="width: ${getReportProgress(resultsTotal, total, true)}" aria-valuenow="${getReportProgress(resultsTotal, total, false)}" title="" aria-valuemin="0" aria-valuemax="100"> </div>
            </div>
            <span>${getReportProgress(resultsTotal, total, true)}</span>
            <p>Calculating pages speed, please wait...</p>`
            $("#card_google_overall .broken_links_content, #card_google_lighthouse .broken_links_content, #card_core_web_vitals .broken_links_content").remove()
            $("#card_google_overall .single_dashboard_card, #card_google_lighthouse .single_dashboard_card, #card_core_web_vitals .single_dashboard_card").append(div)
      }
    }

    static getGoogleCurrentProgress(results){
      let resultsTotal, total
      total = googleUrlsToCheck
      total = total * 2

      if(results){
        resultsTotal = Object.keys(results).length
      }else{
        resultsTotal = 0
      }

      return getReportProgress(resultsTotal, total, false)
    }
    static buildGoogleElements(refreshState = false){
      // CHECKING IF GOOGLE ELEMENTS WERE STARTED OR NOT
      DB.getGoogleShowStatus(projectId)
      .done(function(data) {
          if(data.googleStatus){
              
          }else{

            (async () => {
              let urlsGoogle
              if(refreshState){
                urlsGoogle = recheckGoogle
              }else{
                urlsGoogle = googleUrlsToCheck
              }
              const testId = await DB.startGoogleTests(urlsGoogle)

            })()
          }
      });
    }

    static finalizeLabels(allLabels, seoLabels, performanceLabels, cbpLabels, securityLabels){
      // allLabels = Controls.removeElementsFromLabel(allLabels)
      // seoLabels = Controls.removeElementsFromLabel(seoLabels)
      // performanceLabels = Controls.removeElementsFromLabel(performanceLabels)
      cbpLabels = Controls.removeElementsFromLabel(cbpLabels)
      // securityLabels = Controls.removeElementsFromLabel(securityLabels)


    }


    static removeElementsFromLabel(label){
      label.forEach((el, i)=>{
        if(!el.is_dashboard_status){
          label.splice(i, 1)
        }
      })

      return label
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

    static async waitForTestsToComplete() {
      return new Promise((resolve) => {
        const checkInterval = setInterval(async () => {
          const testsRunning = await Controls.checkIfTestsAreRunning();
          
          if (!testsRunning) {
            clearInterval(checkInterval);
            resolve();
          }
        }, 2000); // Check every 2 seconds
      });
    }

    static startTestStatusMonitoring() {
      // Monitor test status every 5 seconds and update recheck button state
      setInterval(async () => {
        const testsRunning = await Controls.checkIfTestsAreRunning();
        UI.updateRecheckButtonState(testsRunning);
      }, 5000);
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
              UI.recheckStartedAlert()
              Controls.startTest(urls, "recheck")



              async function checkStatusDashboard() {
                let controller;
            
                while (true) {
            
                    // Cancel any previous unfinished request
                    if (controller) controller.abort();
                    controller = new AbortController();
            
                    try {
                        const response = await fetch(`/api/check-status-dashboard/${projectId}`, {
                            signal: controller.signal
                        });
            
                        const { status, results } = await response.json();
                        Controls.updateProgressRecheck(results);
            
                        if (status === 'completed') {
            
                            Controls.endTest();
            
                            setTimeout(() => {
                                recheckAllowed = true;
                                UI.updateRecheckButtonState(false); // re-enable button
                            }, 100);
            
                            break; // stop loop
                        }
                    } catch (e) {
                        // ignore abort errors
                        if (e.name !== "AbortError") console.error(e);
                    }
            
                    // wait 1 second before next request
                    await new Promise(res => setTimeout(res, 1000));
                }
              }
            
              checkStatusDashboard();
            




        })
        }
      
      }
    }

  
        
    static getShowDashboardStatus(element){
      for (const [key, value] of Object.entries(element)) {
        const el = element[key]
        if(el.length > 0){
          const labelDbName = el[0].label.db_name
          const activeLabel = Controls.getActiveLabel(labelDbName)
          if(!activeLabel.show_dashboard_status){
            return false
          }
        }
      }

      return true
    }

    static getShowDashboardStatus2(element){
      for (let i = 0;i < element.length;i++) {
        const el = element[i]
          if(!el.show_dashboard_status){
            return false
          }
      }

      return true
    }

    static finalizeTestLabels(labels){
      const data = []
      labels.forEach((label, i)=>{
        if(label.name === "og:title"){
          const newLabelData = getAllTestLabels("dashboard").allLabels
          newLabelData.forEach(el=>{
            if(el.name === "og:title"){
              label.ogDesc = el.ogDesc
              label.ogImage = el.ogImage
              label.ogURL = el.ogURL
            }
          })
        }

        if(label.name === "twitter:title"){
          const newLabelData = getAllTestLabels("dashboard").allLabels
          newLabelData.forEach(el=>{
            if(el.name === "twitter:title"){
              label.twitterImage = el.twitterImage
              label.twitterImageAlt = el.twitterImageAlt
            }
          })
        }
        if(label.is_dashboard_status){
          data.push(label)
        }else{
          delete obj[label.db_name];
        }
      })

      return data    
    }


    static manageSingleCard(element, key, label, appendStatus, status = true){
      if(label.db_name != "html_sitemap" && status){
        UI.buildSingleLoaderCard(label, appendStatus)
      }
      if(!ignore_tests.includes(key)){
        DB.getTestDetails(label, element)
        .done(function(data) {
            if(label.db_name == "html_sitemap"){
              htmlSitemapData = data
            }else{
              UI.updateSingleLoaderCard(data, element, key, label)
            }
        });
      }
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

    static buildDashboardLoader(){
        UI.buildDashboardLoader()
    }

    static updateTestDataForm(results){
      for (const [key, value] of Object.entries(results)) {
        for (const [key1, value1] of Object.entries(results[key])) {
          console.log(key1, value, results[key])
          const result = JSON.parse(value1)
          const label = Controls.getActiveLabel(key1)
          const dbName = label.db_name


          if(label.has_dashboard_parent){
            switch(label.dashboard_parent){
              case "security_labels":
                if(obj["security_labels"]){
                  obj["security_labels"][dbName].push(result)
                }
                break;
              case "cbp_labels":
                if(obj["cbp_labels"]){
                  obj["cbp_labels"][dbName].push(result)
                }
                break;
            }
          }else{
            obj[dbName].push(result)
          }
        }

      }

      return obj
    }


    static cleanNulls(obj) {
      for (const key in obj) {
          if (obj[key] === null || obj[key] === undefined) {
              delete obj[key];
          }
      }
      return obj;
    }
    

    static buildDashboard(dashboardStatus){
        DB.getTestData(projectId)
        .done(function(data) {
          if(data.results.security_labels){
            data.results.security_labels = Controls.cleanNulls(data.results.security_labels) 
          }

          if(data.results.cbp_labels){
            data.results.cbp_labels = Controls.cleanNulls(data.results.cbp_labels) 
          }

            const testDetails = data.results
            const project = data.project
            $(".dashboard_top_items_main").html("")
            UI.buildWidgetSidebar()




            // display alerts from DB
            DB.getAlerts(projectId)
              .done(function(alertsData){
                UI.buildDBAlerts(alertsData.alerts)
                removeLoader()
                UI.toggleDashboardElements(project)
    
                Controls.buildCards(testDetails)
    
                Controls.activeEvents()

                if(dashboardStatus === 2){ // if recheck state build recheck loader
                  urls = originalUrls.slice(0, recheckMax)
                  urlsToCheck = recheckMax
                  UI.buildRecheckLoader()
                }else if(dashboardStatus === 3){ // if recheck single state build recheck loader
                  
                }




                console.log("Dashboard finished")
                Controls.buildGoogleElements()
            });
            
        });

    }

    static activeEvents(){
      Controls.activeSidebarEvents()
      
      $("#submitIdeaForm").on("submit", (e)=>{
        Controls.submitIdeaSubmit()
        e.preventDefault()
      })

      $("#submitIdeaWidgetMsg").on("keyup", (e)=>{
        const val = e.target.value.length
        $("#submitIdeaForm span").html(`${val}/200`)
      })

      $("#recheckHyperlink").on("click", async (e)=>{
        await Controls.recheckStart()
        e.preventDefault()
      })

      $(".alert-custom .btn-close").on("click", (e)=>{
        DB.updateAlertStatus()
        e.preventDefault()
      })
      


      async function checkStatus() {
          const interval = setInterval(async () => {
              const response = await fetch(`/api/check-status/${projectId}`);
              const { status, results } = await response.json();
              Controls.updateGoogleCards(results)

              const googleTiles = ["google_overall", "google_lighthouse", "core_web_vitals"];

              if (status === 'completed') {
                handleGoogleResults(results, googleTiles)

                clearInterval(interval);
                Controls.finalizeGoogleElements(results)
                
                // Re-enable recheck button after Google tests completion
                UI.updateRecheckButtonState(false)
            }
          }, 5000); // Check every 5 seconds
        }

        checkStatus()
    }

    static submitIdeaSubmit(){
      clearAlerts()

      if(Controls.validateSubmitIdea()){
        let msg = document.querySelector("#submitIdeaWidgetMsg").value
        DB.submitIdea(msg)
        .done(function(data) {
          if(data.status === 0){
            displayAlertGlobal(data)
          }else{
            msg = ""
            displayAlertSimpleSuccess(".dashboard_submit_content", {
              status: 1,
              msg: "Featues request successfully submitted."
            })
          }
        });
      }
    }

    static validateSubmitIdea(){
      let state = true
      let alertMsg = ""
      const msg = document.querySelector("#submitIdeaWidgetMsg").value
      if(msg.length < 1){
        state = false
        alertMsg = "Submit idea field can not be empty."
      }

      if(msg.length > 200){
        state = false
        alertMsg = "Message can not be greater than 200 characters. For more detailed message use the sidebar feature request."
      }



      if(!state){
        displayAlertSimple(".dashboard_submit_content", {
          status: 0,
          msg: alertMsg
        })
      }
      return state
    }

    static async refreshSingleTile(e){
      const testsRunning = await Controls.checkIfTestsAreRunning();
        
      if (testsRunning) {
        // Show message that we need to wait for tests to complete
        UI.showWaitingMessage();
        
        // Wait for all tests to complete
        await Controls.waitForTestsToComplete();
        
      }else{
        refreshTileDisabled = true
        recheckSingleIntervalStatus = true
        const target = e.target.closest(".single_dashboard_card_main")
        const elementDbName = target.getAttribute("data-label")
        if(ignore_tests.includes(elementDbName)){
          Controls.refreshTileGoogle(elementDbName, target)
        }else{
          Controls.refreshTile(elementDbName, target)
        } 
      }
    }



    static activeSidebarEvents(){
      $(".remove-tile").on("click", (e)=>{
        console.log("Remove Tile Disabled")
        // if(!removeTileDisabled){
        //   removeTileDisabled = true
        //   const target = e.target.closest(".single_dashboard_card_main")
        //   const elementDbName = target.getAttribute("data-label")
        //   Controls.removeTile(elementDbName, target)
        // }
      })

      $(".refresh-tile").on("click", (e)=>{
          Controls.refreshSingleTile(e)
      })

      $(".add-tile").on("click", (e)=>{
        e.preventDefault()
        const target = e.target
        const elementDbName = target.getAttribute("data-label")
        Controls.addTile(elementDbName)
      })
    }

    static getActiveElement(dbName){
      for (const [key, value] of Object.entries(obj)) {
        if(key == dbName){
          return obj[key]
        }
      }
    }


    static addTile(dbName){
      const label = Controls.getActiveLabel(dbName)
      const element = Controls.getActiveElement(dbName)

      // Disable recheck button when adding a new tile (which starts tests)
      UI.updateRecheckButtonState(true)

      Controls.manageSingleCard(element, dbName, label, true)
      DB.updateLabelStatus(dbName, 1)
      .done(function(){
        getAllTestLabels2(projectId)
        .done(function(data) {
            allLabels = data.all_labels
            seoLabels = data.seo_labels
            performanceLabels = data.performance_labels
            cbpLabels = data.cbp_labels
            securityLabels = data.security_labels
            Controls.finalizeLabels(allLabels, seoLabels, performanceLabels, cbpLabels, securityLabels)


            UI.buildWidgetSidebar()
            let title
            if(element[0]){
              title = element[0].title
            }else if(element.css_caching_enable){
              title = "Coding Best Practices"

            }else{
              title = "Security Headers"
            }
            const msg = `"${title}" was successfully added to dashboard.`
            displayAlert(".analysis-content-body-message", {
              status: 1,
              msg: msg,
              notHide: false
            })
            $('.analysis-content-body-message').show()
            scrollToTop()
            modalSidebar.toggle()
            Controls.activeSidebarEvents()
        });
      })
    }

    static refreshTileGoogle(dbName, target){
      // Disable recheck button when refreshing Google tiles
      UI.updateRecheckButtonState(true)
      
      const googleTiles = ["google_overall", "google_lighthouse", "core_web_vitals"];
      // For each Google tile, build the loader
      googleTiles.forEach(tileDbName => {
        const tileElem = document.querySelector(`.single_dashboard_card_main[data-label='${tileDbName}']`);
        if (tileElem) {
          const name = tileElem.querySelector(".dashboard_title p").textContent;
          UI.buildRefreshTileLoader(tileDbName, tileElem, name);
          if(tileElem.querySelector(".google-error-message")){
            tileElem.querySelector(".google-error-message").remove()
          }
        }
      });
      // Reset Google status in backend first
      fetch(`/reset-google-status/${projectId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      .then(response => response.json())
      .then(data => {
        Controls.buildGoogleElements(true)
        async function checkStatus() {
          const interval = setInterval(async () => {
              const response = await fetch(`/api/check-status/${projectId}`);
              const { status, results } = await response.json();
              Controls.updateGoogleCards(results)

              // Handle Google error logic
              const googleTiles = ["google_overall", "google_lighthouse", "core_web_vitals"];
              if (status === 'completed') {
                handleGoogleResults(results, googleTiles)

                  clearInterval(interval);
                  Controls.finalizeGoogleElements(results)
                  
                  // Re-enable recheck button after Google tile refresh completion
                  UI.updateRecheckButtonState(false)
              }
          }, 5000); // Check every 5 seconds
        }
        checkStatus()
      });
    }

    static refreshTile(dbName, target){
      const name = target.querySelector(".dashboard_title p").textContent
      refreshTileDbName = dbName
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
      UI.buildRefreshTileLoader(dbName, target, name)
      urls = originalUrls.slice(0, recheckSingleMax)
      Controls.startTest(urls, "single_recheck", dbName)

    
      async function checkStatusDashboard() {
        let controller;
    
        while (true) {
            // Cancel any previous ongoing request
            if (controller) controller.abort();
            controller = new AbortController();
    
            try {
                const response = await fetch(`/api/check-status-dashboard/${projectId}`, {
                    signal: controller.signal
                });
    
                const { status, results } = await response.json();
    
                // Update UI for single tile progress
                UI.updateSingleTileProgress(target, results, dbName, urls.length);
    
                // When completed
                if (status === 'completed') {
    
                    if (recheckSingleIntervalStatus) {
    
                        let obj = Controls.updateTestDataForm(results);
                        Controls.manageSingleCard(
                            obj[dbName],
                            dbName,
                            obj[dbName][0].label,
                            false,
                            false
                        );
    
                        // Re-enable recheck button after completion
                        UI.updateRecheckButtonState(false);
    
                        displayAlert(".analysis-content-body-message", {
                            status: 1,
                            msg: "Recheck for the selected tile has been completed successfully.",
                            notHide: true
                        });
    
                        $('.analysis-content-body-message').show();
    
                        // Enable refresh again
                        refreshTileDisabled = false;
    
                        // Reset status flag
                        recheckSingleIntervalStatus = false;
    
                        break; // stop the loop completely
                    }
                }
    
            } catch (e) {
                // Ignore fetch abort errors
                if (e.name !== "AbortError") console.error(e);
            }
    
            // Wait 1 second before next check
            await new Promise(res => setTimeout(res, 1000));
        }
      }
    
      checkStatusDashboard();
    
    }

    static removeTile(dbName, target){
      DB.updateLabelStatus(dbName, 0)
      .done(function(){
        target.remove()
        getAllTestLabels2(projectId)
        .done(function(data) {
            allLabels = data.all_labels
            seoLabels = data.seo_labels
            performanceLabels = data.performance_labels
            cbpLabels = data.cbp_labels
            securityLabels = data.security_labels
            Controls.finalizeLabels(allLabels, seoLabels, performanceLabels, cbpLabels, securityLabels)
            UI.buildWidgetSidebar()
            const title = target.querySelector(".dashboard_title p").textContent
            const msg = `"${title}" was successfully removed from dashboard.`
            displayAlert(".analysis-content-body-message", {
              status: 1,
              msg: msg,
              notHide: false
            })
            $('.analysis-content-body-message').show()
            scrollToTop()
            Controls.activeSidebarEvents()
            removeTileDisabled = false
        });
      })
    }


 

    static buildCards(testDetails){
        UI.buildLoaderCards(testDetails)
        UI.buildSubmitIdeaWidget(testDetails)
        UI.buildAddWidget(testDetails)
    }


    static getTestObject(url, label){
      url = constructTestURL(url)
      const origin = new URL(url).origin


      var obj = {}
      obj["project"] = projectId
      obj["urlValue"] = url
      obj["testLabels"] = label
      obj["pageType"] = "live"

      return obj
    }




    static endTest(type = "na"){        
      if(type === "single_recheck"){
      const key = refreshTileDbName
      let label
      if(key === "security_labels"){
          label = {
            display_name: "Security Headers",
            urlDetails: "/test-details/security-headers",
            reportsUrl: "/reports/security-headers",
            db_name: "security_labels"
          }

      }else if(key === "cbp_labels"){
        label = {
          display_name: "HTML Best Practices",
          urlDetails: "/test-details/coding-best-practices",
          reportsUrl: "/reports/coding-best-practices",
          db_name: "cbp_labels"
        }

      }else{
        label = Controls.getActiveLabel(key)
        if(label.db_name === "xml_sitemap"){
          label.display_name = "Sitemap"
        }
      }



      if(key === "security_labels"){
        obj["security_labels"] = {
          is_safe_browsing: [],
          cross_origin_links: [],
          protocol_relative_resource: [],
          content_security_policy_header: [],
          x_frame_options_header: [],
          hsts_header: [],
          bad_content_type: [],
          ssl_certificate_enable: [],
          folder_browsing_enable: [],
        }
      }else if(key === "cbp_labels"){
        obj["cbp_labels"] = {
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
        }
      }else{
        obj[key] = []
      }

      }

      Controls.buildDashboard()


      // Re-enable recheck button after test completion
      UI.updateRecheckButtonState(false)
    }

    static updateProgress(results, progress, completedCount, total){
        if(results){
          UI.updateProgressBar(progress)

          

          document.querySelectorAll(".preparing_list").forEach(li=>{
            li.querySelector(".taly-done").textContent = completedCount


            // update image
            if(total === completedCount){
              const svg = `<svg class="svg-inline--fa fa-check" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path></svg>`
              li.querySelector("img").remove()
              const html = svg + li.querySelector("p").innerHTML
              li.querySelector("p").innerHTML = html
            }
          })

        }
    }

    static calcProgressDashboard(results){
      if (!results) results = {};
  
      const total = urls.length;
      let completedCount = 0;
  
      Object.keys(results).forEach(url => {
          const urlData = results[url];
  
          if (!urlData) return;
  
          // Case 1: explicit completed/failed
          if (urlData.status === "completed" || urlData.status === "failed") {
              completedCount++;
              return;
          }
  
          // Case 2: Final test data exists (labels present)
          const hasFinalResults = (
              urlData.meta_title ||
              urlData.meta_desc ||
              urlData.robots_meta ||
              urlData.canonical_url
          );
  
          if (hasFinalResults) {
              completedCount++;
          }
      });
  
      const progress = getReportProgress(completedCount, total, false);
      
      return {
        completedCount: completedCount,
        total: total,
        progress: progress,
      }

    }

    static updateProgressRecheck(results){
      
      const progressDetails = Controls.calcProgressDashboard(results)
      UI.updateRecheckProgressBar(progressDetails.completedCount, progressDetails.progress)
    }

    static getCurrentTest(label){
      let currentTest
      if(label.hasDashboardParent){
        switch(label.dashboardParent){
          case "security_labels":

            if(obj["security_labels"]){
              currentTest = obj["security_labels"][label.dbName]
            }
            break;
          case "cbp_labels":
            if(obj["cbp_labels"]){
              currentTest = obj["cbp_labels"][label.dbName]
            }
            break;
        }
      }else{
        currentTest = obj[label.dbName]
      }

      return currentTest
    }

  
    static startTest(urlsUpdated, type, recheck_label = "na"){
      $.ajax({
        url : `/test/start-dashboard-test`,
        type : 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "urls": urlsUpdated,
            "project_id": projectId,
            "test_type": type,
            "recheck_label": recheck_label,
            "_method": 'POST',
        },       
        success : function(data) {
        },
        error: function(data){
        }
      })
    }


    static updateSingleTest(urls, type, recheck_label = "na"){
      $.ajax({
        url : `/test/update-single-dashboard-test`,
        type : 'POST',
        data: {
            "urls": urls,
            "project_id": projectId,
            "type": type,
            "recheck_label": recheck_label,
            "_method": 'POST',
            "_token": $('meta[name="csrf-token"]').attr('content'),
        },       
        success : function(data) {
        },
        error: function(data){
        }
      })
    }

  }




  Controls.init()





  // Events
  $("#recheckBtn").on("click", async function(e){
    await Controls.recheckStart()
    e.preventDefault()
  })


})

// Helper to handle Google results error logic
function handleGoogleResults(results, googleTiles) {
  let validUrls = [];
  let hasValid = false;

  for (const url in results) {
    const urlResult = results[url];
    // If the result is an error object at the top level
    if (urlResult && urlResult.error) {
      continue;
    } else {
      hasValid = true;
      validUrls.push(url);
    }
  }

  if (hasValid) {
    // Let the normal update logic run (do nothing special)
    return true;
  } else {
    // Show error message in each Google card
    googleTiles.forEach(tileDbName => {
      const tileElem = document.querySelector(`.single_dashboard_card_main[data-label='${tileDbName}']`);
      if (tileElem) {
        const cardContent = tileElem.querySelector('.single_dashboard_card_content');
        if (cardContent) cardContent.remove();
        const div = document.createElement('div');
        div.classList.add('single_dashboard_card_content');
        div.innerHTML = `<div class="google-error-message" style="padding: 20px; text-align: center; color: #b94a48;">
          <strong>Please try again later.</strong>
        </div>`;
        tileElem.querySelector('.single_dashboard_card').appendChild(div);
      }
    });
    return false;
  }
}