$( document ).ready(function() {


  const CSV_FILE_NAME = "QA Results.csv";
  const CSV_FILE_NAME_BROKEN_LINKS = "QA Results - Broken Links.csv";


  let prevData = "", pageTitle = "", pageDesc = "", pageTitleStatus = true, pageDescStatus = true, buildTestStatus = false, testIndex = 0;
  let titleTruncateLength = 65, descriptionTruncateLength = 160;
  let ogTagsFoundStatus = false;
  let emailModalSuggestionStatus = false;
  let brokenLinksData
  let ogTagsData = {
    title:{

    },
    desc:{

    },
    img:{

    },
    url:{

    },
  }
  let resultsData = [];
  let resultsDataImages = [];
  let resultsDataBestPractices = [];
  let resultsDataSecurity = [];
  let resultsDataPerformance = [];
  let resultsDataMeta = [];

  let dataPassed = [];
  let dataFailed = [];
  
  let dataPassedMeta = [];
  let dataFailedMeta = [];

  let dataPassedImages = [];
  let dataFailedImages = [];

  let dataPassedPerformance = [];
  let dataFailedPerformance = [];

  let dataPassedCBP = [];
  let dataFailedCBP = [];

  let dataPassedSecurity = [];
  let dataFailedSecurity = [];

  let firstTest = true;
  let activeUpdateData, statusHomeTab = false
  let activeUpdateStatusElement
  let obj, projectUrl, imageTestStatus = false
  let extendedTiles = true
  var updateStatusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'), {
      keyboard: false
  })
  var modalFix = new bootstrap.Modal(document.getElementById('modalFix'), {
        keyboard: false
  })
  var modalEmail = new bootstrap.Modal(document.getElementById('modalEmail'), {
    keyboard: false 
  })
  



  // DEALS WITH UI ELEMENTS(BUILDING AND RENDERING HTML TO THE DOM)
  class UI{
    // Helper function to update loader-single-item background when tests are complete
    static updateContainerBackground(contentId){
      const content = document.getElementById(contentId)
      if(!content) return
      
      const container = content.closest(".loader-single-item-container")
      if(!container) return
      
      const loaderItem = container.querySelector(".loader-single-item")
      if(!loaderItem) return
      
      // When content is closed, check if all tests are complete
      const table = content.querySelector(".status-table")
      if(table){
        const allRows = table.querySelectorAll("tbody tr")
        const totalRows = allRows.length
        
        if(totalRows > 0){
          let completedCount = 0
          allRows.forEach(row => {
            const firstTd = row.querySelector("td")
            if(firstTd && !firstTd.classList.contains("testing")){
              completedCount++
            }
          })
          
          // If all tests are complete, set gray background on loader-single-item
          if(completedCount === totalRows){
            loaderItem.style.setProperty("background-color", "rgba(230, 235, 242, 1)", "important")
          }
        }
      }
    }
    
    // Function to update all container backgrounds based on content visibility
    static updateAllContainerBackgrounds(){
      const contentSections = ["seo-content", "performance-content", "best-practices-content", "security-content"]
      contentSections.forEach(contentId => {
        UI.updateContainerBackground(contentId)
      })
    }
    
    static updateLoaderCurrentTestStatus(label){
      UI.collapsePreviousParent(label)
      document.getElementById(label.name).querySelector(".loader-item-current").textContent = "Testing..."
      
      // Open the content section when its first test starts
      // But only if user hasn't manually closed it
      const parentType = label.parent
      if(!parentType || parentType === "seo"){
        // SEO tests (default case)
        const seoContent = document.getElementById("seo-content")
        if(seoContent && seoContent.style.display !== "block" && !seoContent.getAttribute("data-user-closed")){
          seoContent.style.display = "block"
        }
      } else if(parentType === "performance"){
        const performanceContent = document.getElementById("performance-content")
        if(performanceContent && performanceContent.style.display !== "block" && !performanceContent.getAttribute("data-user-closed")){
          performanceContent.style.display = "block"
        }
      } else if(parentType === "bestPractices"){
        const bestPracticesContent = document.getElementById("best-practices-content")
        if(bestPracticesContent && bestPracticesContent.style.display !== "block" && !bestPracticesContent.getAttribute("data-user-closed")){
          bestPracticesContent.style.display = "block"
        }
      } else if(parentType === "security"){
        const securityContent = document.getElementById("security-content")
        if(securityContent && securityContent.style.display !== "block" && !securityContent.getAttribute("data-user-closed")){
          securityContent.style.display = "block"
        }
      }
    }


    
  static setNeedleByValue(value) {
    const needle = document.querySelector(".analysis-score .pointer");
    const score = document.querySelector(".analysis-score .score-health");

    needle.style.transition = "transform 3s ease-in-out";
    const minAngle = -120;
    const maxAngle = 120;
    const clamped = Math.max(0, Math.min(100, value));
    const angle = minAngle + ((clamped / 100) * (maxAngle - minAngle));
    
    needle.style.transform = `rotate(${angle}deg)`;
    if(value <=25){
      score.style.color = "#C1262C";
    }
    else if(value > 25 && value <=49){
      score.style.color = "#D85C23";
    }
    else if(value >= 50 && value <=74){
      score.style.color = "#F69220";
    }
    else{
      score.style.color = "#23B473";
    }
    score.textContent = value;


    let current = 0;
    const duration = 3000; 
    const frameRate = 30;
    const steps = Math.ceil(duration / frameRate);
    const increment = clamped / steps;

    const counter = setInterval(() => {
      current += increment;
      if (current >= clamped) {
        current = clamped;
        clearInterval(counter);
      }
      score.textContent = Math.round(current);
    }, frameRate);
  }

  static collapsePreviousParent(data){
    let parentCard = data.parent

    // collapse elements parent div after all elements are testing
    if(parentCard === "performance"){
      if(document.getElementById("seo-content")){
        document.getElementById("seo-content").style.display = "none"
        // Update background after closing
        UI.updateAllContainerBackgrounds()
      }        
    }

    if(parentCard === "bestPractices"){
      if(document.getElementById("performance-content")){
        document.getElementById("performance-content").style.display = "none"
        // Update background after closing
        UI.updateAllContainerBackgrounds()
      }
    }

    if(parentCard === "security"){
      if(document.getElementById("best-practices-content")){
        document.getElementById("best-practices-content").style.display = "none"
        // Update background after closing
        UI.updateAllContainerBackgrounds()
      }
    }

    // end collapse
  }




    static getBrokenLinks(allLinks, limit){
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
      
          // Add table header
          html += `<table class="broken-links-table">
          <thead>
            <tr>
              <th class="blt-header">URL</th>
              <th class="blt-header">HTTP Status Code</th>
              <th class="blt-3header">
                <a href="#" class="ignore-all-link" data-urls='${JSON.stringify(brokenUrls.map(item => item.url))}'>Ignore All</a>
              </th>
            </tr>
          </thead>
          <tbody>`
      
      // Display broken links
      brokenUrls.forEach((item, index) => {
        if(limit && index >= 5) return; // Limit to 5 items in card view
        
        html+=`<tr>
          <td>
            <div class="url-cell">
              <a href="${item.url}" target="_blank"><span class="broken-link-index">${index+1}. </span><span class="broken-link-url">${item.url}</span></a>
            </div>
          </td>
          <td><strong>${item.status}</strong></td>
          <td><button class="btn btn-sm btn-outline-secondary ignore-link-btn" data-url="${item.url}">Ignore</button></td>
        </tr>`
      })
      
      html += `</tbody></table>`
      return html
    }

    static buildEmail(email){
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
        UI.toggleEmailSuggestionBox("hide")
        $("#emailTo").val("")
      }else{
        Controls.handleAlert(0, "Can not enter more than 10 emails at once.", ".analysis-mail-top")
      }
    }


    static getProblemsElement(problems){
      // building problems
      let ul = document.createElement("ol")
      if(problems){
        if(problems.length > 0){
          ul.classList.add("pl-20")
          problems.forEach(problem=>{
              const li = document.createElement("li")
              li.innerHTML = problem
              ul.appendChild(li)
          })
        }else{
          ul = ""
        }
      }else{
        ul = ""
      }

      return ul
    }
    static getTwitterTagsElement(data, icon){
      let ulTitle = UI.getProblemsElement(data.problems)
      let ulImage = UI.getProblemsElement(data.problemsImage)
      let ulImageAlt = UI.getProblemsElement(data.problemsImageAlt)


      return `
      <div class="card">
        <div class="card-header">
          <div class="card-header-title">
            <div class="card-header-left">
              <span>
                ${icon}
              </span>
              <h4>${data.title}</h4>
              <span class="card-help">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0V0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36957 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4V14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4V4Z"
                    fill="#D3D5D8" />
                </svg>
                <div class="card-help-body">
                  <p>${data.description}</p>
                  <a target="_blank" href="${data.learnMoreURL}"">Learn More</a>
                </div>
              </span>
            </div>
            ${!data.status ? 
              `<div class="card-header-right data-test-name="${data.title}">
                  <button class="btn rounded-pill fix-btn">
                    How to fix it?
                  </button>
            </div>`
            : ""}
            <span class="badge bagde-single-view ${data.status ? "text-success-custom" : "text-danger-custom"}">${data.status ? "PASS" : "FAIL"}</span>
          </div>
          
          <button class="showhide-btn collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#multiCollapseContent${guidGenerator()}" aria-expanded="false"
            aria-controls="multiCollapseContent${guidGenerator()}">
            <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round"></path>
            </svg>
          </button>
        </div>
        <div class="card-body collapse show" id="multiCollapseContent${guidGenerator()}">
          <div class="card-single-content ${data.status ? "text-success-custom" : "text-danger-custom"}">
            <p>
              <span class="badge twitter_badge">${data.status ? "PASS" : "FAIL"}</span>
              <span class="twitter_content">${data.message}</span>
            </p>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="meta-graph-table">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th>Tag</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Issues</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th class="text-center">1</th>
                        <td><span>Twitter Title Tag</span></td>
                        <td>
                          <p class="twitter_title">
                            ${data.content}
                          </p>
                        </td>
                        <td>
                          <div class="status-card ${data.statusTitle ? "text-success-custom" : "text-danger-custom"}">${data.statusTitle ? "PASS" : "FAIL"}
                          </div>
                        </td>
                        <td>${ulTitle!= "" ? ulTitle.outerHTML : data.messageTitle}</td>
                      </tr>
                      <tr>
                        <th class="text-center">2</th>
                        <td><span>Twitter Image</span></td>
                        <td>
                          <p class="twitter_image">${data.contentImage}</p>
                        </td>
                        <td>
                          <div class="status-card ${data.statusImage ? "text-success-custom" : "text-danger-custom"}">${data.statusImage ? "PASS" : "FAIL"}
                          </div>
                        </td>
                        <td>${ulImage!= "" ? ulImage.outerHTML : data.messageImage}</td>
                      </tr>
                      <tr>
                        <th class="text-center">3</th>
                        <td><span>Twitter Image Alt</span></td>
                        <td>
                          <p class="twitter_image_alt">
                            ${data.contentImageAlt}
                          </p>
                        </td>
                        <td>
                          <div class="status-card ${data.statusImageAlt ? "text-success-custom" : "text-danger-custom"}">${data.statusImageAlt ? "PASS" : "FAIL"}
                          </div>
                        </td>
                        <td>${ulImageAlt!= "" ? ulImageAlt.outerHTML : data.messageImageAlt}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>`
    }


   
    static getOgTagsElement(data, icon){
      let ulTitle = UI.getProblemsElement(data.problems)
      let ulDesc = UI.getProblemsElement(data.problemsDesc)
      let ulImage = UI.getProblemsElement(data.problemsImage)
      let ulURL = UI.getProblemsElement(data.problemsURL)

      return `
      <div class="card">
        <div class="card-header">
          <div class="card-header-title">
            <div class="card-header-left">
              <span>
                ${icon}
              </span>
              <h4>${data.title}</h4>
              <span class="card-help">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0V0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36957 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4V14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4V4Z"
                    fill="#D3D5D8" />
                </svg>
                <div class="card-help-body">
                  <p>${data.description}</p>
                  <a target="_blank" href="${data.learnMoreURL}"">Learn More</a>
                </div>
              </span>
            </div>
            ${!data.status ? 
              `<div class="card-header-right data-test-name="${data.title}">
                  <button class="btn rounded-pill fix-btn">
                    How to fix it?
                  </button>
            </div>`
            : ""}
            <span class="badge bagde-single-view ${data.status ? "text-success-custom" : "text-danger-custom"}">${data.status ? "PASS" : "FAIL"}</span>
          </div>
          
          <button class="showhide-btn collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#multiCollapseContent${guidGenerator()}" aria-expanded="false"
            aria-controls="multiCollapseContent${guidGenerator()}">
            <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round"></path>
            </svg>
          </button>
        </div>
        <div class="card-body collapse show" id="multiCollapseContent${guidGenerator()}">
          <div class="card-single-content ${data.status ? "text-success-custom" : "text-danger-custom"}">
            <p>
              <span class="badge og_badge">${data.status ? "PASS" : "FAIL"}</span>
              <span class="og_content">${data.message}</span>
            </p>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="meta-graph-table">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th>Tag</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Issues</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th class="text-center">1</th>
                        <td><span>OG Title Tag</span></td>
                        <td>
                          <p class="og_title_tag">
                            ${data.content}
                          </p>
                        </td>
                        <td>
                          <div class="status-card ${data.statusTitle ? "text-success-custom" : "text-danger-custom"}">${data.statusTitle ? "PASS" : "FAIL"}
                          </div>
                        </td>
                        <td>${ulTitle!= "" ? ulTitle.outerHTML : data.messageTitle}</td>
                      </tr>
                      <tr>
                        <th class="text-center">2</th>
                        <td><span>OG Description</span></td>
                        <td>
                          <p class="og_description">${data.contentDesc}</p>
                        </td>
                        <td>
                          <div class="status-card ${data.statusDesc ? "text-success-custom" : "text-danger-custom"}">${data.statusDesc ? "PASS" : "FAIL"}
                          </div>
                        </td>
                        <td>${ulDesc!= "" ? ulDesc.outerHTML : data.messageDesc}</td>
                      </tr>
                      <tr>
                        <th class="text-center">3</th>
                        <td><span>Og URL</span></td>
                        <td>
                          <p>
                            <a target="_blank" href="${data.contentURL}" class="og_url">${data.contentURL}</a>
                          </p>
                        </td>
                        <td>
                          <div class="status-card ${data.statusURL ? "text-success-custom" : "text-danger-custom"}">${data.statusURL ? "PASS" : "FAIL"}
                          </div>
                        </td>
                        <td>${ulURL!= "" ? ulURL.outerHTML : data.messageURL}</td>
                      </tr>
                      <tr>
                        <th class="text-center">4</th>
                        <td><span>OG Image</span></td>
                        <td>
                          <p class="og_image">${data.contentImage}</p>
                        </td>
                        <td>
                          <div class="status-card ${data.statusImage ? "text-success-custom" : "text-danger-custom"}">${data.statusImage ? "PASS" : "FAIL"}
                          </div>
                        </td>
                        <td>${ulImage!= "" ? ulImage.outerHTML : data.messageImage}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="social-review">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Facebook Preview</h4>
                    <a target="_blank" href="${data.contentImage}">View Image</a>
                  </div>
                  <div class="card-body">
                    <img src="${data.contentImage}" alt="review-linkdine" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Linkedin Preview</h4>
                    <a target="_blank" href="${data.contentImage}">View Image</a>
                  </div>
                  <div class="card-body">
                    <img src="${data.contentImage}" alt="review-linkdine" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>`
    }
    
    static toggleTiles(extendedStatus){
      const activeElementId = $(".nav-link-home-tab.active").attr("data-bs-target")
      $(".project-tiles-btn.active").removeClass("active")
      $(".tab-content-area .results-container.active").removeClass("active")
      $(".tab-content-area .results-container.show").removeClass("show")

      if(extendedStatus){
        $("#tilesExtended").addClass("active")
        $(".meta-tag-items").removeClass("single-view")
        $(".collapse").collapse("show")
        $(`${activeElementId}`).addClass("active")
        $(`${activeElementId}`).addClass("show")
      }else{
        $("#tilesSingle").addClass("active")
        $(".meta-tag-items").addClass("single-view")
        $('.collapse').collapse('hide')
        $(".tab-content-area .results-container").addClass("active")
        $(".tab-content-area .results-container").addClass("show")
      }
      
    }

    static toggleEmailModal(){
      modalEmail.toggle()
    }

    static updateEmailModal(){
      $("#emailTo").val("")
      $("#emailSubject").val("")
      document.querySelector(".analysis-mail").innerHTML = ""
      const MESSAGE = `Hello,\n\nI recently did a webpage audit report for the URL ${projectUrl}, please find it attached.\n\nThanks`
      document.querySelector("#modalEmailMessage").innerHTML = MESSAGE
      document.querySelector("#modalEmailMessage").value = MESSAGE
      document.querySelector("#modalEmailFileName").innerHTML = CSV_FILE_NAME
    }


    static buildModalEmailBox(email){
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
      UI.toggleEmailSuggestionBox("show")
    }

    static toggleEmailSuggestionBox(type){
      if(type === "hide"){
        document.querySelector(".email-suggestion").innerHTML = ""
        document.querySelector(".email-suggestion").style.display = "none"
      }else{
        document.querySelector(".email-suggestion").style.display = "block"
      }
    }

    static updateSnippetElement(title, description){  
      $(".snippet-title").html(truncateString(title, titleTruncateLength))
      $(".snippet-description").html(truncateString(description, descriptionTruncateLength))
    }


    static getImageIssuesHTML(problem, i){
      if(problem.imageProblems.length === 1){
        let p = document.createElement("p")
        p.classList.add("m-0")
        p.innerHTML = problem.imageProblems[0]
        return p
      }else{
        let ul = document.createElement("ul")
        ul.classList.add("m-0")
        if(problem.imageProblems.length > 0){
            problem.imageProblems.forEach(problem=>{
                const li = document.createElement("li")
                li.innerHTML = problem
                ul.appendChild(li)
            })
        }
        return ul
      }
    }

    static displayEmailModalAlert(){
      const div = buildAlert({status: 0, msg: "Please enter an accurate email."})
      document.querySelector(".analysis-mail-to-container").appendChild(div)
    }
  }


  class Controls{
    static buildCSV(csvName) {
        // Get the original table structure to preserve headers
        const originalTable = $(".analysis-table-image table").clone()[0];
        
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


    static fetchCachedTestResult(testKey) {
      return fetch(`/api/cached-test?test_key=${testKey}`)
        .then(res => res.json());
    }

    static saveCachedTestResult(testKey, result, testLabels) {
      return fetch('/api/cached-test', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
          test_key: testKey,
          result,
          test_labels: JSON.stringify(testLabels),
          resultsData: JSON.stringify(resultsData),
          dataFailed: JSON.stringify(dataFailed),
          dataPassed: JSON.stringify(dataPassed),
          projectUrl: projectUrl,
          projectRoute: window.location.href
        })
      });
    }

    static testRequest(results, testLabels, testKey, resultsByLabel = {}){
      const label = testLabels[testIndex]
      testIndex++;

      const test = Controls.buildTestInformation(results, label)
      UI.updateLoaderCurrentTestStatus(label)
      $.ajax({
          url : `${label.url}`,
          type : 'POST',
          aysnc: false,
          data: {
              "data": test,
              "_method": 'POST',
              "aysnc": false,
              "_token": $('meta[name="csrf-token"]').attr('content'),
          },       
          success: function(data) {
            Controls.buildTest(data, label, testLabels)
            resultsByLabel[label.name] = data;
            if(testLabels.length === resultsData.length){
              window.setTimeout(function(){
                endTest(testLabels)

                // When the test is done, save the result
                // You may need to adjust this if your test is async
                Controls.saveCachedTestResult(testKey, resultsByLabel, testLabels);
              }, 3000)
            }else{
              Controls.testRequest(results, testLabels, testKey, resultsByLabel)              
            }
          }
          });
    }


    static buildTestInformation(results, label){
      let test = getTest(results, label)
      if(!test){
          test = {
              content: ""
          }
      }
      if(!test.metaContent || test.metaContent === undefined){
          test.metaContent = {
              content: "",
          }
      }
      if(label.name === "a" || label.name === "img" || label.name === "stylesheet" || label.name === "script" || label.name === "table"){
          test = {
              links: test,
              label: label,
              urlValue: projectUrl,
              pageType: "live"
          }
      }else{
          test.label = label
          test.urlValue = projectUrl
          test.pageType = "live"
      }
      
      if(test.name === "og:title"){
        let ogDesc = getTest(results, label.information.ogDesc)
        test.ogDesc = ogDesc || { content: "" }
        let ogImage = getTest(results, label.information.ogImage)
        test.ogImage = ogImage || { content: "" }
        let ogURL = getTest(results, label.information.ogURL)
        test.ogURL = ogURL || { content: "" }
      }
      if(test.name === "twitter:title"){
        let twitterImage = getTest(results, label.information.twitterImage)
        test.twitterImage = twitterImage || { content: "" }
        let twitterImageAlt = getTest(results, label.information.twitterImageAlt)
        test.twitterImageAlt = twitterImageAlt || { content: "" }
      }

      return test
    }



    static buildTest(data, label, testLabels, cachedExist = false){
        data = JSON.parse(data)
        data.label = label
        // testing casing
        if(data.casingStatus){
            const content = data.content
            data.casingClass = "text-success-custom"
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
                    data.casingClass = "text-danger-custom"
                }
            }
            if(data.titleCasingSentence){
                if(!isSentenceCase(content, data.excludedWordsVal)){
                    data.problems.push(`${data.tagName} does not follow Sentence casing`)
                    data.status = false
                    data.casingClass = "text-danger-custom"
                }
            }
            if(data.titleCasingBoth){
                if(!isCamelCase(content, data.excludedWordsVal) && !isSentenceCase(content, data.excludedWordsVal)){
                    data.problems.push(`${data.tagName} does not follow Camel casing or Sentence casing`)
                    data.status = false
                    data.casingClass = "text-danger-custom"
                }
            }
        }

        resultsData.push(data)
      

        if(data.parentCard === "images"){
            imageTestStatus = true
            data.problems.forEach(prob=>{
                resultsDataImages.push(prob)
                if(prob.status){
                    dataPassedImages.push(data)
                }else{
                    dataFailedImages.push(data)
                }
            })

            if(data.status){
                dataPassed.push(data)
            }else{
                dataFailed.push(data)
            }
        }else{
            switch(data.parentCard){
                case "security":
                        resultsDataSecurity.push(data)
                    break;
                case "codingBestPractices":
                        resultsDataBestPractices.push(data)
                    break;
                case "performance":
                        resultsDataPerformance.push(data)
                    break;
                default:
                    resultsDataMeta.push(data)
                    break;
            }

            if(data.status){
                switch(data.parentCard){
                    case "security":
                          dataPassedSecurity.push(data)
                      break;
                    case "codingBestPractices":
                            dataPassedCBP.push(data)
                        break;
                    case "performance":
                            dataPassedPerformance.push(data)
                        break;
                    default:
                        dataPassedMeta.push(data)
                        break;
                }
                dataPassed.push(data)
            }else{
                switch(data.parentCard){
                    case "security":
                            dataFailedSecurity.push(data)
                      break;
                    case "codingBestPractices":
                            dataFailedCBP.push(data)
                        break;
                    case "performance":
                            dataFailedPerformance.push(data)
                        break;
                    default:
                            dataFailedMeta.push(data)
                        break;
                }
                dataFailed.push(data)
            }
        }

        buildResult(testLabels, data, cachedExist)
    }

    static collapseCard(){
      var myCollapsible = document.querySelectorAll('.results-container .collapse')
      myCollapsible.forEach(el=>{
        el.addEventListener('shown.bs.collapse', function (e) {
          e.target.parentElement.classList.add("collapsed")
          e.target.parentElement.classList.remove("hidden")
        })

        el.addEventListener('hidden.bs.collapse', function (e) {
          e.target.parentElement.classList.add("hidden")
          e.target.parentElement.classList.remove("collapsed")
        })
      }) 
    }
    static tableElement(){
      if(data.name === "og_tags"){
        ogTagsFoundStatus = true
        if(data.type === "title"){
          ogTagsData.title = data
          if(Controls.buildTableElementStatus(data)){
            buildElementWithTable()
          }
        }

        if(data.type === "description"){
          ogTagsData.desc = data
          if(Controls.buildTableElementStatus(data)){
            buildElementWithTable()
          }
        }

        if(data.type === "image"){
          ogTagsData.img = data
          if(Controls.buildTableElementStatus(data)){
            buildElementWithTable()
          }
        }

        if(data.type === "url"){
          ogTagsData.url = data
          if(Controls.buildTableElementStatus(data)){
            buildElementWithTable()
          }
        }
      }
    }

    static buildTableElementStatus(data){
      if(data.type === "url"){
        return true
      }else{
        return false
      }
    }


    static toggleTiles(){
      extendedTiles = !extendedTiles
      UI.toggleTiles(extendedTiles)
    }


    static getEmails(){
      const array = []
      document.querySelectorAll(".analysis-single-mail").forEach(el=>{
        array.push(el.textContent.trim())
      })

      return array
    }


    static validateEmailReport(){
      clearAlerts()
      if(document.querySelector(".analysis-single-mail")){
        return true
      }

      Controls.handleAlert(0, "Please enter at least one email.", ".analysis-mail-top")
      return false
    }

    static handleAlert(status, msg, classVal, notHide = false){
      displayAlert(classVal, {
        status: status,
        msg: msg,
        notHide: notHide
      })
    }


    static validateModalEmail(emailValue){
      if(validateEmail(emailValue)){
        return true;
      }
    }


    static getStatusMessage(status){
      return status == true ? "PASS" : "FAIL"; 
    }


    static displayEmailModal(){
      UI.toggleEmailModal()
    }




    static sendEmail(){
      const TABLE = Controls.buildCSVTable(data, false)
      const exporter = new TableCSVExporter(TABLE, this.CSV_NAME);
      const LINK = exporter.getCsvLink();
      const MESSAGE = document.querySelector("#modalEmailMessage").value
      const SUBJECT = document.querySelector("#emailSubject").value
      const ALL_EMAILS = Controls.getEmails()
      
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
          UI.updateEmailModal()
          displayAlert(".analysis-content-body", result)
          scrollToTop()
        },
        error: function(data){
            removeLoader()
            displayAlert(".analysis-content-body", {
                status: 0,
                msg: "There was an error, please try again later."
            })
        }
      })

      UI.toggleEmailModal()
    }


    static getIssuesString(issuesList){
      let p = ""
      if(issuesList.length > 0){
        issuesList.forEach((issue, i)=>{
          p += i === issuesList.length-1 ? `${issue}` : `${issue}, ` 
        })
      }else{
        p = ""
      }
      
      return p
    }

    static buildCSVTable(data){
      const table = document.createElement("table")
      if(resultsDataMeta.length > 0){
        var theadMeta = document.createElement("thead")
        var tbodyMeta = document.createElement("tbody")

        theadMeta.innerHTML = `<tr>
        <th># Meta Tags</th>
        <th>Type</th>
        <th>Content</th>
        <th>Length</th>
        <th>Status</th>
        <th>Message</th>
        <th>Problems</th>
        <tr>`
        table.appendChild(theadMeta)
        resultsDataMeta.forEach((el, i)=>{
          const PROBLEMS =  Controls.getIssuesString(el.problems)
          const tr = document.createElement("tr")
          tr.innerHTML = `
          <td>${i+1}</td>
          <td>${el.title}</td>
          <td>${el.content}</td>
          <td>${el.casingStatus ? el.content.length : ""}</td>
          <td>${Controls.getStatusMessage(el.status)}</td>
          <td>${el.message}</td>
          <td>${PROBLEMS}</td>
          `;
          tbodyMeta.appendChild(tr)
        })

        for(var i = 0;i < 2;i++){
          const tr1 = document.createElement("tr")
          tbodyMeta.appendChild(tr1)
        }

        table.appendChild(tbodyMeta)
    }

    // images section
    if(resultsDataImages.length > 0){
      var theadImages = document.createElement("thead")
      var tbodyImages = document.createElement("tbody")

      theadImages.innerHTML = `<tr>
      <th># Images</th>
      <th>Image URL</th>
      <th>Alternate Text</th>
      <th>File Name</th>
      <th>File Size</th>
      <th>Status</th>
      <th>Problems</th>
      <tr>`
      table.appendChild(theadImages)
      resultsDataImages.forEach((el, i)=>{
        const PROBLEMS =  Controls.getIssuesString(el.imageProblems)

        const tr = document.createElement("tr")
        tr.innerHTML = `
        <td>${i+1}</td>
        <td>${el.imageSrc}</td>
        <td>${el.imageAlt}</td>
        <td>${el.imageName}</td>
        <td>${el.imageSizeValue}</td>
        <td>${Controls.getStatusMessage(el.status)}</td>
        <td>${PROBLEMS}</td>
        `;
        tbodyImages.appendChild(tr)
      })

      for(var i = 0;i < 2;i++){
        const tr1 = document.createElement("tr")
        tbodyImages.appendChild(tr1)
      }
      table.appendChild(tbodyImages)
    }


    // performance section
    if(resultsDataPerformance.length > 0){
      var theadPerformance = document.createElement("thead")
      var tbodyPerformance = document.createElement("tbody")

      theadPerformance.innerHTML = `<tr>
      <th># Performance</th>
      <th>Type</th>
      <th>Status (Desktop)</th>
      <th>Status (Mobile)</th>
      <th>Score (Desktop)</th>
      <th>Score (Mobile)</th>
      <th>Message (Desktop)</th>
      <th>Message (Mobile)</th>
      <tr>`
      table.appendChild(theadPerformance)
      resultsDataPerformance.forEach((el, i)=>{
        const tr = document.createElement("tr")
        if(el.tagName === "insights"){
          tr.innerHTML = `
          <td>${i+1}</td>
          <td>${el.title}</td>
          <td>${Controls.getStatusMessage(el.statusDesktop)}</td>
          <td>${Controls.getStatusMessage(el.statusMobile)}</td>
          <td>Google Insights Desktop Score is ${el.scoreDesktop}</td>
          <td>Google Insights Mobile Score is ${el.scoreDesktop}</td>
          <td>${el.messageDesktop}</td>
          <td>${el.messageMobile}</td>
          `;
        }else if(el.tagName === "lighthouse"){
          tr.innerHTML = `
          <td>${i+1}</td>
          <td>${el.title}</td>
          <td>${Controls.getStatusMessage(el.statusDesktop)}</td>
          <td>${Controls.getStatusMessage(el.statusMobile)}</td>
          <td>Performance score is ${el.scoreDesktop}, Accessibility score is ${el.accessibilityDesktop}, Best Practices score is ${el.bestPracticesDesktop}, SEO score is ${el.seoDesktop}</td>
          <td>Performance score is ${el.scoreMobile}, Accessibility score is ${el.accessibilityMobile}, Best Practices score is ${el.bestPracticesMobile}, SEO score is ${el.seoMobile}</td>
          <td>${el.messageDesktop}</td>
          <td>${el.messageMobile}</td>
          `;
        }else if(el.tagName === "core_web_vitals"){
          tr.innerHTML = `
          <td>${i+1}</td>
          <td>${el.title}</td>
          <td>${Controls.getStatusMessage(el.statusDesktop)}</td>
          <td>${Controls.getStatusMessage(el.statusMobile)}</td>
          <td>CLS score is ${el.clsDesktop}, FCP score is ${el.fcpDesktop}, FID score is ${el.fidDesktop}, LCP score is ${el.lcpDesktop}, SI score is ${el.siDesktop}, TBT score is ${el.tbtDesktop}, TTI score is ${el.ttiDesktop}</td>
          <td>CLS score is ${el.clsMobile}, FCP score is ${el.fcpMobile}, FID score is ${el.fidMobile}, LCP score is ${el.lcpMobile}, SI score is ${el.siMobile}, TBT score is ${el.tbtMobile}, TTI score is ${el.ttiMobile}</td>
          <td>${el.messageDesktop}</td>
          <td>${el.messageMobile}</td>
          `;
        }

        tbodyPerformance.appendChild(tr)
      })

      for(var i = 0;i < 2;i++){
        const tr1 = document.createElement("tr")
        tbodyPerformance.appendChild(tr1)
      }
      table.appendChild(tbodyPerformance)
    }


    // best practices section
    if(resultsDataBestPractices.length > 0){
      var theadBestPractices = document.createElement("thead")
      var tbodyBestPractices = document.createElement("tbody")

      theadBestPractices.innerHTML = `<tr>
      <th># Coding Best Practices</th>
      <th>Type</th>
      <th>Status</th>
      <th>Message</th>
      <th>Problems</th>
      <tr>`
      table.appendChild(theadBestPractices)
      resultsDataBestPractices.forEach((el, i)=>{
        const PROBLEMS =  Controls.getIssuesString(el.problems)

        const tr = document.createElement("tr")
        tr.innerHTML = `
        <td>${i+1}</td>
        <td>${el.title}</td>
        <td>${Controls.getStatusMessage(el.status)}</td>
        <td>${el.message}</td>
        <td>${PROBLEMS}</td>
        `;
        tbodyBestPractices.appendChild(tr)
      })

      for(var i = 0;i < 2;i++){
        const tr1 = document.createElement("tr")
        tbodyBestPractices.appendChild(tr1)
      }
      table.appendChild(tbodyBestPractices)
    }

    // security section
    if(resultsDataSecurity.length > 0){
      var theadSecurity = document.createElement("thead")
      var tbodySecurity = document.createElement("tbody")

      theadSecurity.innerHTML = `<tr>
      <th># Security</th>
      <th>Type</th>
      <th>Status</th>
      <th>Message</th>
      <th>Problems</th>
      <tr>`
      table.appendChild(theadSecurity)
      resultsDataSecurity.forEach((el, i)=>{
        const PROBLEMS =  Controls.getIssuesString(el.problems)

        const tr = document.createElement("tr")
        tr.innerHTML = `
        <td>${i+1}</td>
        <td>${el.title}</td>
        <td>${Controls.getStatusMessage(el.status)}</td>
        <td>${el.message}</td>
        <td>${PROBLEMS}</td>
        `;
        tbodySecurity.appendChild(tr)
      })

      for(var i = 0;i < 2;i++){
        const tr1 = document.createElement("tr")
        tbodySecurity.appendChild(tr1)
      }
      table.appendChild(tbodySecurity)
    }

    return table
  }

    static buildBrokenLinksCSV(){
      const allLinks = brokenLinksData.allLinks
      const table = document.createElement("table")

      var thead = document.createElement("thead")
      var tbody = document.createElement("tbody")

      thead.innerHTML = `<tr>
      <th>#</th>
      <th>Broken Link</th>
      <th>HTTP Status Code</th>
      <tr>`
      table.appendChild(thead)
  

      let i = 0;
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

              const tr = document.createElement("tr")
              tr.innerHTML = `
              <td>${i}</td>
              <td>${key}</td>
              <td>${status}</td>
              `;

              tbody.appendChild(tr)
            }
        }
      }
    
      table.appendChild(tbody)
      const exporter = new TableCSVExporter(table, CSV_FILE_NAME_BROKEN_LINKS);
      exporter.downloadCSV();
    }

    static getCsvLink(table){
      const dataTable = table;
      const exporter = new TableCSVExporter(dataTable);
      const csvOutput = exporter.convertToCSV();
      const csvBlob = new Blob([csvOutput], { type: "text/csv" });
      const blobUrl = URL.createObjectURL(csvBlob);
      return blobUrl;
    }
    
    static downloadCSV(blobUrl){
      const anchorElement = document.createElement("a");
      anchorElement.href = blobUrl;
      anchorElement.download = CSV_FILE_NAME;
      anchorElement.click();
      setTimeout(() => {
          URL.revokeObjectURL(blobUrl);
      }, 500);
    }


    static updatePageTitleDesc(results){
      results.forEach(el=>{
      if(el.name === "title" && pageTitleStatus && typeof el.content === "string"){
         pageTitle = el.content 
           pageTitleStatus = false
        }

      if(el.name === "description" && pageDescStatus && typeof el.content === "string"){
        pageDesc = el.content 
          pageDescStatus = false
        }
      })
    }

    static updatePageTitleDescFromMap(resultsMap){
      if(!resultsMap || typeof resultsMap !== "object"){
        return
      }
  
      const normalizeResult = (result) => {
        if (!result) return null
        if (typeof result === "string") {
          try {
            return JSON.parse(result)
          } catch (e) {
            return null
          }
        }
        return result
      }
  
      const titleResult = normalizeResult(resultsMap["title"])
      if(titleResult && pageTitleStatus && typeof titleResult.content === "string"){
        pageTitle = titleResult.content
        pageTitleStatus = false
      }
  
      const descResult = normalizeResult(resultsMap["description"])
      if(descResult && pageDescStatus && typeof descResult.content === "string"){
        pageDesc = descResult.content
        pageDescStatus = false
      }
    }
  }








  // main test logic
  const ref_id = $("#test_id").val()
  const testKey = ref_id;
  Controls.fetchCachedTestResult(testKey).then(data => {
    if (data.result) {
      const labels = JSON.parse(data.test_labels)
      projectUrl = data.projectUrl; // restore projectUrl
    
      labels.forEach(label => {
        const result = data.result[label.name]
        Controls.buildTest(result, label, labels, true)
        
        // If this is a broken links test, store the data globally for ignore functionality
        if (label.name === 'broken_links' && result.allLinks) {
          window.currentAnalysisData = {
            allLinks: result.allLinks,
            totalBrokenLinks: result.totalBrokenLinks || 0
          };
        }
      })
      endTest(JSON.parse(data.test_labels));
      removeLoader();
    } else {
      // No cache, run test as usual
      runTestAndCache(testKey);
    }
  });

  // end of main test logic




  

  $("#project").on( "change", function(e) {
      buildCustomizer()
  })

  $("#hidePassed").on( "change", function(e) {
      hideThatPass(e)
  })

  $("#hidePassedImages").on( "change", function(e) {
      hideThatPass(e, "images")
  })


  document.getElementById('updateStatusModal').addEventListener('hidden.bs.modal', function (event) {
      // const el = activeUpdateStatusElement.querySelector(".intentional")
      // el.checked = !el.checked
  })

   // mail-report-modal
   $(".analysis-mail").click(function (e) {
    const target = e.target.closest(".analysis-single-delete")
    if(target){
      target.parentElement.remove();
    }
  });


  $(".email-suggestion").on('click', function (e) {
    if(emailModalSuggestionStatus){
      const email = $("#emailTo").val()
      UI.buildEmail(email)
    }
  })


  $("#emailTo").on('keyup', function (e) {
        if(Controls.validateModalEmail(e.target.value)){
          emailModalSuggestionStatus = true
          UI.buildModalEmailBox(e.target.value)
        }else{
          emailModalSuggestionStatus = false
          UI.toggleEmailSuggestionBox("hide")
        }

        if (e.key === 'Enter' || e.keyCode === 13) {
          if(emailModalSuggestionStatus){
            UI.buildEmail(e.target.value)
          }
        }

  });

  $("#sendAnalysisEmailBtn").on('click', function (e) {
    if(Controls.validateEmailReport()){
      Controls.sendEmail()
    }
  });


  $("#confirmStatusUpdate").on( "click", function(e) {
      let arr1, arr2
      activeUpdateData.status = !activeUpdateData.status 
      activeUpdateData.problems = []

      for(var i = 0;i < dataFailed.length;i++){
          const el = dataFailed[i]
          if(el.label.name === activeUpdateData.label.name){
              dataPassed.push(activeUpdateData)
              dataFailed.splice(i, 1)
          }
      }

      switch(activeUpdateData.parentCard){
          case "images":
              arr1 = dataFailedImages
              arr2 = dataPassedImages
              break;
          case "codingBestPractices":
              arr1 = dataFailedCBP
              arr2 = dataPassedCBP
              break;
          case "performance":
              arr1 = dataFailedPerformance
              arr2 = dataPassedPerformance
              break;
          case "security":
              arr1 = dataFailedSecurity
              arr2 = dataPassedSecurity
              break;
          default:
              arr1 = dataFailedMeta
              arr2 = dataPassedMeta
              break;
      }

      for(var i = 0;i < arr1.length;i++){
          const el = arr1[i]
          if(el.label.name === activeUpdateData.label.name){
              arr2.push(activeUpdateData)
              arr1.splice(i, 1)
          }
      }

      buildElement1(activeUpdateData, true)
      activeUpdateStatusElement.remove()
      updateStatusModal.hide()
      updateUIProgress()
  })


  $(".input-check-all").on( "change", function(e) {
      const parent = e.target.parentElement.parentElement.parentElement
      updateCustomizerInputStatus(parent, e)
  })

  $("#element_all").on( "change", function(e) {
      const parent = e.target.parentElement.parentElement.parentElement.parentElement
      updateCustomizerInputStatus(parent, e)
  })







  function updateCustomizerInputStatus(parent, e){
      const inputs = parent.querySelectorAll("input")
      inputs.forEach(input=>{
          if(input.id != e.target.id){
              if(e.target.checked){
                  input.checked = true
              }else{
                  input.checked = false
              }
          }
      })
  }



  function buildCustomizer(){
      let project = document.querySelector("#activeProject").getAttribute("data-val")
      project = getStringPart(project, "-", 1)

      $.ajax({
          url : `/data/get-settings/${project}`,
          type : 'GET',
          data: {
              "_method": 'GET',
              "_token": $('meta[name="csrf-token"]').attr('content'),
          },       
          success : function(data) {
              metaTagLabels.forEach(label=>{
                  if(data[label.dbName]){
                      const div = document.createElement("div")
                      div.classList.add("form-check")
                      div.classList.add("form-check-custom")
                      div.innerHTML = `
                          <input checked data-title="${label.displayName}" data-url="${label.url}" data-name="${label.name}" class="form-check-input customizer-check-input" type="checkbox" value="" id="check_${label.name}">
                          <label class="form-check-label" for="check_${label.name}">${label.displayName}</label>
                      `
                      document.querySelector("#accordianMetaTags .inner-element-content").appendChild(div)
                  }
              })

              imagesLabels.forEach(label=>{
                  if(data[label.dbName]){
                      const div = document.createElement("div")
                      div.classList.add("form-check")
                      div.classList.add("form-check-custom")
                      div.innerHTML = `
                          <input checked data-parent="images" data-title="${label.displayName}" data-url="${label.url}" data-name="${label.name}" class="form-check-input customizer-check-input" type="checkbox" value="" id="check_${label.name}">
                          <label class="form-check-label" for="check_${label.name}">${label.displayName}</label>
                      `
                      document.querySelector("#accordianImages .inner-element-content").appendChild(div)
                  }
              })

              performanceLabels.forEach(label=>{
                  if(data[label.dbName]){
                      const div = document.createElement("div")
                      div.classList.add("form-check")
                      div.classList.add("form-check-custom")
                      div.innerHTML = `
                          <input checked data-parent="performance" data-title="${label.displayName}" data-url="${label.url}" data-name="${label.name}" class="form-check-input customizer-check-input" type="checkbox" value="" id="check_${label.name}">
                          <label class="form-check-label" for="check_${label.name}">${label.displayName}</label>
                      `
                      document.querySelector("#accordianPerformance .inner-element-content").appendChild(div)
                  }
              })

              securityLabels.forEach(label=>{
                  if(data[label.dbName]){
                      const div = document.createElement("div")
                      div.classList.add("form-check")
                      div.classList.add("form-check-custom")
                      div.innerHTML = `
                          <input checked data-parent="security" data-title="${label.displayName}" data-url="${label.url}" data-name="${label.name}" class="form-check-input customizer-check-input" type="checkbox" value="" id="check_${label.name}">
                          <label class="form-check-label" for="check_${label.name}">${label.displayName}</label>
                      `
                      document.querySelector("#accordianSecurity .inner-element-content").appendChild(div)
                  }
              })

              CBPLabels.forEach(label=>{
                  if(data[label.dbName]){
                      const div = document.createElement("div")
                      div.classList.add("form-check")
                      div.classList.add("form-check-custom")
                      div.innerHTML = `
                          <input checked data-parent="bestPractices" data-title="${label.displayName}" data-url="${label.url}" data-name="${label.name}" class="form-check-input customizer-check-input" type="checkbox" value="" id="check_${label.name}">
                          <label class="form-check-label" for="check_${label.name}">${label.displayName}</label>
                      `
                      document.querySelector("#accordianCBP .inner-element-content").appendChild(div)
                  }
              })
          },
      });
  }




  function buildLoaderTestsDetails(testLabels){
      $("#completedTests").html("0")
      $("#totalTests").html(testLabels.length)

      const metaTagsElement = buildLoaderDetailSingleElement("SEO", "seo-content")
      let metaTagsElementStatus = false
      const performanceElement = buildLoaderDetailSingleElement("Performance", "performance-content")
      let performanceElementStatus = false
      const bestPracticesElement = buildLoaderDetailSingleElement("Best Practices", "best-practices-content")
      let bestPracticesElementStatus = false
      const securityElement = buildLoaderDetailSingleElement("Security", "security-content")
      let securityElementStatus = false

      testLabels.forEach(el=>{
          let div
          switch(el.parent){
              case "performance":
                  div = performanceElement
                  performanceElementStatus = true
                  break;
              case "bestPractices":
                  div = bestPracticesElement
                  bestPracticesElementStatus = true
                  break;
              case "security":
                  div = securityElement
                  securityElementStatus = true
                  break;
              default:
                  div = metaTagsElement
                  metaTagsElementStatus = true
                  break;
          }

          const tr = document.createElement("tr")
          tr.id = el.name
          tr.innerHTML = `
          <td class="testing">${el.title}</td>
          <td class="loader-item-current"></td>
          <td class="loader-item-chip"></td>
          `
          div.querySelector(".status-table tbody").appendChild(tr)
          
      })

      metaTagsElementStatus ? document.querySelector(".loader-list-items").appendChild(metaTagsElement) : ""
      performanceElementStatus ? document.querySelector(".loader-list-items").appendChild(performanceElement) : ""
      bestPracticesElementStatus ? document.querySelector(".loader-list-items").appendChild(bestPracticesElement) : ""
      securityElementStatus ? document.querySelector(".loader-list-items").appendChild(securityElement) : ""


     $(".loader-list-items").on( "click", function(e) {
        if(e.target.classList.contains("dropdown-toggle")){
          toggleLoaderDropdown(e.target.getAttribute("data-id"))
        } else if(e.target.closest(".loader-single-item")){
          // Handle click on loader-single-item itself
          const loaderItem = e.target.closest(".loader-single-item");
          const container = loaderItem.closest(".loader-single-item-container");
          const dropdownToggle = container.querySelector(".dropdown-toggle");
          if(dropdownToggle){
            toggleLoaderDropdown(dropdownToggle.getAttribute("data-id"))
          }
        }
    
      }) 

  }   

  function toggleLoaderDropdown(id) {

    var content = document.getElementById(id);
    const isCurrentlyOpen = content.style.display === "block";   

    // Close all other open accordions first

    const allContentElements = document.querySelectorAll(".loader-single-item-container .content");
    allContentElements.forEach(function(element) {
      if(element.id !== id && element.style.display === "block") {
        element.style.display = "none";
        // Mark as user-closed when manually closed
        element.setAttribute("data-user-closed", "true");
        // Update background when closing (gray if tests complete)
        UI.updateContainerBackground(element.id);
      }
    });
    
    // Toggle the clicked accordion
    if (isCurrentlyOpen) {
        content.style.display = "none";
        // Mark as user-closed when manually closed
        content.setAttribute("data-user-closed", "true");
        // Update background when closing (gray if tests complete)
        UI.updateContainerBackground(id);
    } else {
        content.style.display = "block";
        // Remove user-closed flag when user manually opens
        content.removeAttribute("data-user-closed");
    }
  }

  function buildLoaderDetailSingleElement(label, idVal){
    const div = document.createElement("div")
    div.classList.add("loader-single-item-container")
    div.innerHTML = `
    <div class="loader-single-item">
      <b>${label}</b> 
      <span class="success"><span class="details-passed">0</span> Test Passed</span> 
      <span class="fail"><span class="details-failed">0</span> Test Failed</span>
      <span>
        <a class="dropdown-toggle loader-dropdown-toggle-analysis" data-id="${idVal}" href="javascript:void()"></a>
      </span>
    </div>
    <div id="${idVal}" class="content">
        <table class="status-table">
            <tr><td>Test</td><td>Status</td><td>Result</td></tr>
        </table>
    </div>
    `
    return div
}




  function buildLoader(obj, testLabels){
    const div = getLoaderElement(true)
    document.querySelector(".loader__card").appendChild(div)
    buildLoaderTestsDetails(testLabels)
    showLoaderDetailsToggle()
    updateLoaderUI(obj, testLabels)
  }

  
  function updateLoaderUI(obj, testLabels){
      $("#loader_url").html(projectUrl)
      document.querySelector(".loader__card").classList.remove("d-none")
  }

  function removeLoader(){
      document.querySelector(".loader__card").innerHTML = ""
      document.querySelector(".loader__card").classList.add("d-none")
  }
  

  function removeReportContainer(){
      document.querySelector(".card-custom-container").remove()
  }


  function buildReportContainer(){
      if(document.querySelector(".card-custom-container")){
          removeReportContainer()
      }
      const div = document.createElement("div")
      div.style.display = "none"
      div.classList.add("card-custom-container")
      div.innerHTML = `
      <div class="card-custom show" id="cardMetaTitle">
          <div class="card-custom-header align-items-center d-flex">
              <h5 class="label-header">Meta Tags</h5>
              <div class="flex-grow-1 d-sm-block d-md-none"></div>
              <div class="progress-item mr-meta">
                  <p class="label-meta" id="metaTagsFailed"></p>
                  <div class="progress progress-rounded progress-mini">
                      <div class="progress-bar bg-danger" id="metaTagsFailedProgress" role="progressbar"></div>
                  </div>
              </div>
              <div class="progress-item">
                  <p class="label-meta" id="metaTagsPassed"></p>
                  <div class="progress progress-rounded progress-mini">
                      <div class="progress-bar bg-success" id="metaTagsPassedProgress" role="progressbar"></div>
                  </div>
              </div>
              <div class="progress-item ms-auto">
                  <label class="accordion-button-custom2">
                      <div class="chevron-icon" id="collapseCustomContainer"></div>
                  </label>
              </div>
          </div>
      </div>

      <div class="card-custom show" id="cardImages">
          <div class="card-custom-header d-flex align-items-center">
              <h5 class="label-header">Images</h5>
              <div class="progress-item d-flex align-items-center">
                  <div class="progress progress-rounded progress-images mr-13">
                      <div class="progress-bar bg-success" id="imagesPassedProgress"></div>
                  </div>
                  <div id="imagesPassed" class="label-meta m-0"></div>
              </div>
              <div class="progress-item ms-auto">
                  <label class="accordion-button-custom2">
                      <div class="chevron-icon" id="collapseCustomContainer"></div>
                  </label>
              </div>
          </div>
      </div>

      <div class="card-custom show" id="cardPerformance">
          <div class="card-custom-header align-items-center d-flex">
              <h5 class="label-header">Performance</h5>
              <div class="flex-grow-1 d-sm-block d-md-none"></div>
              <div class="progress-item mr-meta">
                  <p class="label-meta" id="performanceFailed">2 Failed</p>
                  <div class="progress progress-rounded progress-mini">
                      <div class="progress-bar bg-danger" id="performanceFailedProgress" role="progressbar" style="width: 100%;"></div>
                  </div>
              </div>
              <div class="progress-item">
                  <p class="label-meta" id="performancePassed">0 Passed</p>
                  <div class="progress progress-rounded progress-mini">
                      <div class="progress-bar bg-success" id="performancePassedProgress" role="progressbar" style="width: 0%;"></div>
                  </div>
              </div>
              <div class="progress-item ms-auto">
                  <label class="accordion-button-custom2">
                      <div class="chevron-icon" id="collapseCustomContainer"></div>
                  </label>
              </div>
          </div>
      </div>

      <div class="card-custom show" id="cardCBP">
          <div class="card-custom-header align-items-center d-flex">
              <h5 class="label-header">Coding Best Practices</h5>
              <div class="flex-grow-1 d-sm-block d-md-none"></div>
              <div class="progress-item mr-meta">
                  <p class="label-meta" id="CBPFailed">2 Failed</p>
                  <div class="progress progress-rounded progress-mini">
                      <div class="progress-bar bg-danger" id="CBPFailedProgress" role="progressbar" style="width: 100%;"></div>
                  </div>
              </div>
              <div class="progress-item">
                  <p class="label-meta" id="CBPPassed">0 Passed</p>
                  <div class="progress progress-rounded progress-mini">
                      <div class="progress-bar bg-success" id="CBPPassedProgress" role="progressbar" style="width: 0%;"></div>
                  </div>
              </div>
              <div class="progress-item ms-auto">
                  <label class="accordion-button-custom2">
                      <div class="chevron-icon" id="collapseCustomContainer"></div>
                  </label>
              </div>
          </div>
      </div>
      <div class="card-custom show" id="cardSecurity">
          <div class="card-custom-header align-items-center d-flex">
              <h5 class="label-header">Security</h5>
              <div class="flex-grow-1 d-sm-block d-md-none"></div>
              <div class="progress-item mr-meta">
                  <p class="label-meta" id="securityFailed">2 Failed</p>
                  <div class="progress progress-rounded progress-mini">
                      <div class="progress-bar bg-danger" id="securityFailedProgress" role="progressbar" style="width: 100%;"></div>
                  </div>
              </div>
              <div class="progress-item">
                  <p class="label-meta" id="securityPassed">0 Passed</p>
                  <div class="progress progress-rounded progress-mini">
                      <div class="progress-bar bg-success" id="securityPassedProgress" role="progressbar" style="width: 0%;"></div>
                  </div>
              </div>
              <div class="progress-item ms-auto">
                  <label class="accordion-button-custom2">
                      <div class="chevron-icon" id="collapseCustomContainer"></div>
                  </label>
              </div>
          </div>
      </div>
      `
      document.querySelector(".content-inner").appendChild(div)
  }


  function buildElementGoogle(data){
      let div = document.createElement("div")
      div.classList.add("analysis-card")
      div.classList.add("analysis-card-google")
      div.setAttribute("data-name", data.label.name)
      data.status ? div.classList.add("card__pass") : div.classList.add("card__failed")
      let icon
      if(data.status){
          icon = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12.72 6.79L8.43001 11.09L6.78 9.44C6.69036 9.33532 6.58004 9.2503 6.45597 9.19027C6.33191 9.13025 6.19678 9.09652 6.05906 9.0912C5.92134 9.08588 5.78401 9.10909 5.65568 9.15936C5.52736 9.20964 5.41081 9.28589 5.31335 9.38335C5.2159 9.4808 5.13964 9.59735 5.08937 9.72568C5.03909 9.854 5.01589 9.99133 5.02121 10.1291C5.02653 10.2668 5.06026 10.4019 5.12028 10.526C5.1803 10.65 5.26532 10.7604 5.37 10.85L7.72 13.21C7.81344 13.3027 7.92426 13.376 8.0461 13.4258C8.16794 13.4755 8.2984 13.5008 8.43001 13.5C8.69234 13.4989 8.94374 13.3947 9.13 13.21L14.13 8.21C14.2237 8.11704 14.2981 8.00644 14.3489 7.88458C14.3997 7.76272 14.4258 7.63201 14.4258 7.5C14.4258 7.36799 14.3997 7.23728 14.3489 7.11542C14.2981 6.99356 14.2237 6.88296 14.13 6.79C13.9426 6.60375 13.6892 6.49921 13.425 6.49921C13.1608 6.49921 12.9074 6.60375 12.72 6.79ZM10 0C8.02219 0 6.08879 0.58649 4.4443 1.6853C2.79981 2.78412 1.51809 4.3459 0.761209 6.17317C0.00433284 8.00043 -0.193701 10.0111 0.192152 11.9509C0.578004 13.8907 1.53041 15.6725 2.92894 17.0711C4.32746 18.4696 6.10929 19.422 8.0491 19.8079C9.98891 20.1937 11.9996 19.9957 13.8268 19.2388C15.6541 18.4819 17.2159 17.2002 18.3147 15.5557C19.4135 13.9112 20 11.9778 20 10C20 8.68678 19.7413 7.38642 19.2388 6.17317C18.7363 4.95991 17.9997 3.85752 17.0711 2.92893C16.1425 2.00035 15.0401 1.26375 13.8268 0.761205C12.6136 0.258658 11.3132 0 10 0ZM10 18C8.41775 18 6.87104 17.5308 5.55544 16.6518C4.23985 15.7727 3.21447 14.5233 2.60897 13.0615C2.00347 11.5997 1.84504 9.99113 2.15372 8.43928C2.4624 6.88743 3.22433 5.46197 4.34315 4.34315C5.46197 3.22433 6.88743 2.4624 8.43928 2.15372C9.99113 1.84504 11.5997 2.00346 13.0615 2.60896C14.5233 3.21447 15.7727 4.23984 16.6518 5.55544C17.5308 6.87103 18 8.41775 18 10C18 12.1217 17.1572 14.1566 15.6569 15.6569C14.1566 17.1571 12.1217 18 10 18Z" fill="#80AE35"></path>
        </svg>`;
      }else{
          icon = `<svg width="20" height="20" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M13.8329 6.41288C13.7399 6.31915 13.6293 6.24476 13.5075 6.19399C13.3856 6.14322 13.2549 6.11708 13.1229 6.11708C12.9909 6.11708 12.8602 6.14322 12.7383 6.19399C12.6164 6.24476 12.5058 6.31915 12.4129 6.41288L10.1229 8.71288L7.83288 6.41288C7.64458 6.22458 7.38918 6.11879 7.12288 6.11879C6.85658 6.11879 6.60119 6.22458 6.41288 6.41288C6.22458 6.60119 6.11879 6.85658 6.11879 7.12288C6.11879 7.38918 6.22458 7.64458 6.41288 7.83288L8.71288 10.1229L6.41288 12.4129C6.31915 12.5058 6.24476 12.6164 6.19399 12.7383C6.14322 12.8602 6.11708 12.9909 6.11708 13.1229C6.11708 13.2549 6.14322 13.3856 6.19399 13.5075C6.24476 13.6293 6.31915 13.7399 6.41288 13.8329C6.50585 13.9266 6.61645 14.001 6.73831 14.0518C6.86016 14.1025 6.99087 14.1287 7.12288 14.1287C7.25489 14.1287 7.3856 14.1025 7.50746 14.0518C7.62932 14.001 7.73992 13.9266 7.83288 13.8329L10.1229 11.5329L12.4129 13.8329C12.5058 13.9266 12.6164 14.001 12.7383 14.0518C12.8602 14.1025 12.9909 14.1287 13.1229 14.1287C13.2549 14.1287 13.3856 14.1025 13.5075 14.0518C13.6293 14.001 13.7399 13.9266 13.8329 13.8329C13.9266 13.7399 14.001 13.6293 14.0518 13.5075C14.1025 13.3856 14.1287 13.2549 14.1287 13.1229C14.1287 12.9909 14.1025 12.8602 14.0518 12.7383C14.001 12.6164 13.9266 12.5058 13.8329 12.4129L11.5329 10.1229L13.8329 7.83288C13.9266 7.73992 14.001 7.62932 14.0518 7.50746C14.1025 7.3856 14.1287 7.25489 14.1287 7.12288C14.1287 6.99087 14.1025 6.86016 14.0518 6.73831C14.001 6.61645 13.9266 6.50585 13.8329 6.41288ZM17.1929 3.05288C16.2704 2.09778 15.167 1.33596 13.9469 0.811868C12.7269 0.287778 11.4147 0.0119157 10.0869 0.000377568C8.7591 -0.0111606 7.44231 0.241856 6.21334 0.744665C4.98438 1.24747 3.86786 1.99001 2.92893 2.92893C1.99001 3.86786 1.24747 4.98438 0.744665 6.21334C0.241856 7.44231 -0.0111606 8.7591 0.000377568 10.0869C0.0119157 11.4147 0.287778 12.7269 0.811868 13.9469C1.33596 15.167 2.09778 16.2704 3.05288 17.1929C3.97535 18.148 5.0788 18.9098 6.29884 19.4339C7.51888 19.958 8.83108 20.2339 10.1589 20.2454C11.4867 20.2569 12.8035 20.0039 14.0324 19.5011C15.2614 18.9983 16.3779 18.2558 17.3168 17.3168C18.2558 16.3779 18.9983 15.2614 19.5011 14.0324C20.0039 12.8035 20.2569 11.4867 20.2454 10.1589C20.2339 8.83108 19.958 7.51888 19.4339 6.29884C18.9098 5.0788 18.148 3.97535 17.1929 3.05288ZM15.7829 15.7829C14.4749 17.0923 12.7534 17.9077 10.9117 18.0902C9.06993 18.2727 7.22189 17.8109 5.6824 16.7837C4.14292 15.7564 3.00724 14.2271 2.46886 12.4564C1.93047 10.6856 2.02269 8.78302 2.7298 7.07267C3.4369 5.36231 4.71516 3.95003 6.34677 3.07644C7.97839 2.20286 9.86242 1.92201 11.6779 2.28176C13.4934 2.6415 15.1279 3.61957 16.3031 5.04934C17.4783 6.47911 18.1214 8.27212 18.1229 10.1229C18.1265 11.1742 17.9215 12.2157 17.5198 13.1873C17.1182 14.1588 16.5278 15.041 15.7829 15.7829Z" fill="#FA5457"></path>
        </svg>`
      }


      switch(data.tagName){
          case "insights":
              data.googleInsightsDesktop || data.googleInsightsMobile ? div.innerHTML = getGoogleInsightsElement(data, icon) : buildElement1(data);
              break;
          case "lighthouse":
              data.googleLighthouseCheckOverall ? div.innerHTML = getGoogleLighthouseElement(data, icon) : buildElement1(data);
              break;
          case "core_web_vitals":
              data.googleCoreCheckOverall ? div.innerHTML = getGoogleCoreWebVitalsElement(data, icon) : buildElement1(data);
              break;
          case "mobile_friendliness":
              data.googleMobileFriendly ? div.innerHTML = getGoogleMobileFriendlyElement(data, icon) : buildElement1(data);
              break;
      }

      document.getElementById("cardPerformance").appendChild(div)
  }



  function getGoogleMobileFriendlyElement(data, icon){
    let ul
    if(data.tagName != "Images"){
      ul = UI.getProblemsElement(data.problems)
    }

    return `
    <div class="card">
      <div class="card-header">
        <div class="card-header-title">
          <div class="card-header-left">
            <span>
            ${icon}

            </span>
            <h4>${data.title}</h4>
            <span class="card-help" title="This is title">
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0V0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36957 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4V14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4V4Z" fill="#D3D5D8"></path>
              </svg>
              <div class="card-help-body">
                <p>${data.description}</p>
                <a href="${data.learnMoreURL}" target="_blank">Learn More</a>
              </div>
            </span>
          </div>
          
          ${!data.status ? 
            `<div class="card-header-right data-test-name="${data.title}" data-test-name="${data.title}">
                <button class="btn rounded-pill fix-btn">
                  How to fix it?
                </button>
          </div>
          `
          : ""}

          <span class="badge bagde-single-view ${data.status ? "text-success-custom" : "text-danger-custom"}">${data.status ? "PASS" : "FAIL"}</span>
        </div>
        <button class="showhide-btn collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#multiCollapseContent${guidGenerator()}" aria-expanded="false"
            aria-controls="multiCollapseContent${guidGenerator()}">
            <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round"></path>
            </svg>
          </button>
      </div>
      <div class="card-body collapse show" id="multiCollapseContent${guidGenerator()}">
        <div class="row">
          <div class="col-md-6">
            <div class="card-single-content badge-orange">
              <p>
              <span class="badge status_pdf">${data.status ? "PASS" : "FAIL"}</span>
              </p>
            </div>
            <h6 class="message_pdf"><b>${data.message}</b></h6>
            <span class="mt-2 mb-2">${data.message_secondary}</span>

            ${data.problems ? 
              `${data.problems.length > 0 && data.title != 'Images' ? 

                  `<div class="card-inner-problems">
                      <div class="card">
                          <div class="card-body">
                          <h4>Problems</h4>
                          ${ul.outerHTML}
                          </div>
                      </div>
                  </div>` 

                : ""}`
              : ""}
      

          </div>
       

          <div class="col-md-6 flex-center">
            <div class="performance-mobile">
              <div class="performance-mobile-img">

                <div class="phone-frame" 
                    >
                  <img src="${data.screenshotDataMobile}" class="screenshot" alt="Screenshot">
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    `;
}

  
  function getGoogleInsightsElement(data, icon){
      return `<div class="card">
                    <div class="card-header">
                      <div class="card-header-title">
                        <div class="card-header-left">
                          <span>
                            ${icon}
                          </span>
                          <h4>Google Page Speed Overall Score</h4>
                          <span class="card-help">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0V0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36957 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4V14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4V4Z"
                                fill="#D3D5D8" />
                            </svg>
                            <div class="card-help-body">
                              <p>
                                page titles are prominently featured in
                                search engine result pages and are displayed
                                in your visitors browser tabs.
                              </p>
                              <a href="#">Learn More</a>
                            </div>
                          </span>
                        </div>
                        ${!data.status ? 
                          `<div class="card-header-right data-test-name="${data.title}">
                              <button class="btn rounded-pill fix-btn">
                                How to fix it?
                              </button>
                        </div>`
                        : ""}
                        <span class="badge bagde-single-view ${data.status ? "text-success-custom" : "text-danger-custom"}">${data.status ? "PASS" : "FAIL"}</span>
                      </div>
                      <button class="showhide-btn collapsed collapseHideButton" type="button" data-bs-toggle="collapse"
                        data-bs-target="#multiCollapseContent${guidGenerator()}" aria-expanded="false"
                        aria-controls="multiCollapseContent${guidGenerator()}">
                        <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="card-body collapse hide collapseHide" id="multiCollapseContent${guidGenerator()}">
                      <ul class="nav nav-pills responsive-nav-tabs" id="pills-tab1" role="tablist">

                      ${data.googleInsightsDesktop ? `
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="pills-1-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                            aria-selected="true">
                            <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M2.07443 0.0437603C1.09163 0.206865 0.31375 0.913647 0.0670038 1.86717C0.00845388 2.09301 8.95995e-05 2.69524 8.95995e-05 6.92756C8.95995e-05 12.2138 -0.0124568 11.942 0.259382 12.5024C0.460125 12.9164 0.936889 13.3764 1.38438 13.5855C1.57676 13.6775 1.8486 13.7695 1.98242 13.7946C2.14553 13.8239 3.17015 13.8406 4.92247 13.8406H7.61158L7.27701 14.5098L6.94244 15.1789H5.94709C4.99775 15.1789 4.94756 15.1831 4.79282 15.2751C4.33697 15.5302 4.34952 16.1994 4.81373 16.4336C4.96847 16.5172 5.08139 16.5172 9.57719 16.5172C14.073 16.5172 14.1859 16.5172 14.3406 16.4336C14.8132 16.1952 14.8132 15.501 14.3406 15.2626C14.1943 15.1873 14.0939 15.1789 13.1947 15.1789H12.2119L11.8774 14.5098L11.5428 13.8406H14.2486C17.2305 13.8406 17.2723 13.8365 17.7993 13.5855C18.1924 13.3973 18.711 12.8829 18.895 12.5024C19.1668 11.942 19.1543 12.2096 19.1543 6.94011C19.1543 1.62461 19.1668 1.8839 18.8741 1.31931C18.6692 0.930375 18.2217 0.474522 17.8536 0.294689C17.2472 -0.00224304 17.9373 0.02285 9.70265 0.0144863C5.62089 0.0103035 2.18735 0.02285 2.07443 0.0437603ZM17.0089 1.39877C17.2932 1.48242 17.5358 1.67061 17.678 1.909L17.7951 2.10974L17.8076 6.86901L17.816 11.6283L17.7282 11.8374C17.6738 11.9587 17.5609 12.1134 17.4522 12.2096C17.0925 12.5275 17.724 12.5024 9.57719 12.5024C1.46384 12.5024 2.07025 12.5233 1.71477 12.2222C1.6144 12.1343 1.49311 11.9712 1.43875 11.8583L1.33837 11.645V6.91502V2.18083L1.45547 1.96336C1.59348 1.69571 1.80259 1.51587 2.09952 1.4155C2.31281 1.34441 2.65575 1.34022 9.56046 1.33604C15.8546 1.33604 16.8248 1.34441 17.0089 1.39877Z"
                                fill="#1E63B8" />
                            </svg>
                            Desktop
                          </button>
                        </li>` : ""}

                        ${data.googleInsightsMobile ? `
                        <li class="nav-item" role="presentation">
                          <button class="nav-link ${!data.googleInsightsDesktop ? 'active' : ''}" id="pills-2-tab" data-bs-toggle="pill" data-bs-target="#pills-2"
                            type="button" role="tab" aria-controls="pills-2" aria-selected="false">
                            <svg width="12" height="19" viewBox="0 0 12 19" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M1.14601 0.0296154C0.667761 0.144543 0.289614 0.552347 0.193224 1.06025C0.141321 1.33459 0.141321 17.6246 0.193224 17.8989C0.274785 18.3178 0.545419 18.6737 0.927273 18.8517L1.13859 18.9518H5.68006H10.2215L10.4328 18.8517C10.8147 18.6737 11.0853 18.3178 11.1669 17.8989C11.2188 17.6246 11.2188 1.33459 11.1669 1.06025C11.0853 0.641323 10.8147 0.285419 10.4328 0.10747L10.2215 0.0073719L5.75421 -4.3869e-05C3.22211 -4.3869e-05 1.22757 0.0110779 1.14601 0.0296154ZM7.16299 0.989811C7.19265 1.04171 7.19265 1.0862 7.16299 1.1381C7.12591 1.20854 7.08513 1.21225 5.68006 1.21225C4.27498 1.21225 4.2342 1.20854 4.19713 1.1381C4.16747 1.0862 4.16747 1.04171 4.19713 0.989811C4.2342 0.919373 4.27498 0.915665 5.68006 0.915665C7.08513 0.915665 7.12591 0.919373 7.16299 0.989811ZM10.3142 9.31275V16.5976H5.68006H1.04591V9.31275V2.02786H5.68006H10.3142V9.31275ZM5.89138 17.0833C6.01743 17.1315 6.18796 17.2872 6.2584 17.4207C6.37704 17.6468 6.29918 17.9916 6.09157 18.1658C5.66894 18.5217 5.04981 18.2289 5.04981 17.6728C5.04981 17.2501 5.50211 16.935 5.89138 17.0833Z"
                                fill="#8F8F8F" />
                            </svg>
                            Mobile
                          </button>
                        </li>` : ""}
                      </ul>

                      <div class="tab-content mt-3" id="pills-tabContent1">
                        
                      
                      ${data.googleInsightsDesktop ? `
                        <div class="tab-pane fade ${data.googleInsightsDesktop ? "active show": ""}" id="pills-1" role="tabpanel"
                          aria-labelledby="pills-1-tab" tabindex="0">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="performance-desktop">
                                <div class="performance-score">
                                  <div class="performance-circle">
                                    <span
                                      class="circular-progress circular-progress-lg ${data.statusDesktop ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.scoreDesktop}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="32" class="fw-normal overallDesktop"></text>
                                      </svg>
                                    </span>
                                  </div>
                                  <div class="performance-text">
                                    <ul>
                                      <li>
                                        <span>Good</span><span>90-100</span>
                                      </li>
                                      <li>
                                        <span>Average</span><span>50-89</span>
                                      </li>
                                      <li>
                                        <span>Poor</span><span>0-49</span>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="performance-single-text">
                                  <h4>Performance</h4>
                                  <p>
                                    Values are estimated and may vary. The
                                    <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/performance-scoring/">performance score</a> is calculated directly
                                    from these metrics.
                                    <a target="_blank" href="https://googlechrome.github.io/lighthouse/scorecalc/">See calculator.</a>
                                  </p>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="performance-mobile">
                                <div class="performance-mobile-img">
<div class="laptop-frame">
  <!-- dynamic screenshot -->
                  <img src="${data.screenshotDataDesktop}" class="screenshot" alt="Screenshot">

  <!-- static laptop PNG -->
  <img src="/new-assets/assets/images/desktop_border.png" class="frame" alt="Laptop Frame">
</div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>` 
                        : ""}



                      ${data.googleInsightsMobile ? `
                        <div class="tab-pane fade ${!data.googleInsightsDesktop ? 'active show': ''}" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab"
                          tabindex="0">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="performance-desktop">
                                <div class="performance-score">
                                  <div class="performance-circle">
                                    <span
                                      class="circular-progress circular-progress-lg ${data.statusMobile ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.scoreMobile}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="32" class="fw-normal overallMobile"></text>
                                      </svg>
                                    </span>
                                  </div>
                                  <div class="performance-text">
                                    <ul>
                                      <li>
                                        <span>Good</span><span>90-100</span>
                                      </li>
                                      <li>
                                        <span>Average</span><span>50-89</span>
                                      </li>
                                      <li>
                                        <span>Poor</span><span>0-49</span>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                                <div class="performance-single-text">
                                  <h4>Performance</h4>
                                  <p>
                                    Values are estimated and may vary. The
                                    <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/performance-scoring/">performance score</a> is calculated directly
                                    from these metrics.
                                    <a target="_blank" href="https://googlechrome.github.io/lighthouse/scorecalc/">See calculator.</a>
                                  </p>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="performance-mobile">
                                <div class="performance-mobile-img">
                                
                                <div class="phone-frame" 
                                      >
                                    <img src="${data.screenshotDataMobile}" class="screenshot" alt="Screenshot">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>`
                        : ""}


                      </div>
                    </div>
                  </div>`;
  }

  function getGoogleLighthouseElement(data, icon){
      return `
      <div class="card">
                    <div class="card-header">
                      <div class="card-header-title">
                        <div class="card-header-left">
                          <span>
                            ${icon}
                          </span>
                          <h4>Lighthouse Score</h4>
                          <span class="card-help">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0V0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36957 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4V14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4V4Z"
                                fill="#D3D5D8" />
                            </svg>
                            <div class="card-help-body">
                              <p>
                                page titles are prominently featured in
                                search engine result pages and are displayed
                                in your visitors browser tabs.
                              </p>
                              <a href="#">Learn More</a>
                            </div>
                          </span>
                        </div>
                        ${!data.status ? 
                          `<div class="card-header-right data-test-name="${data.title}">
                              <button class="btn rounded-pill fix-btn">
                                How to fix it?
                              </button>
                        </div>`
                        : ""}
                        <span class="badge bagde-single-view ${data.status ? "text-success-custom" : "text-danger-custom"}">${data.status ? "PASS" : "FAIL"}</span>
                      </div>
                      <button class="showhide-btn collapsed collapseHideButton" type="button" data-bs-toggle="collapse"
                        data-bs-target="#multiCollapseContent${guidGenerator()}" aria-expanded="false"
                        aria-controls="multiCollapseContent${guidGenerator()}">
                        <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="card-body collapse show collapseHide" id="multiCollapseContent${guidGenerator()}">
                      <div class="row gy-3 gy-sm-0 align-items-center">
                        <div class="col-sm-3 d-none d-sm-block"></div>
                        <div class="col-sm-6">
                          <ul class="nav nav-pills responsive-nav-tabs" id="pills-tab3" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="pills-5-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-5" type="button" role="tab" aria-controls="pills-5"
                                aria-selected="true">
                                <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <path
                                    d="M2.07443 0.0437603C1.09163 0.206865 0.31375 0.913647 0.0670038 1.86717C0.00845388 2.09301 8.95995e-05 2.69524 8.95995e-05 6.92756C8.95995e-05 12.2138 -0.0124568 11.942 0.259382 12.5024C0.460125 12.9164 0.936889 13.3764 1.38438 13.5855C1.57676 13.6775 1.8486 13.7695 1.98242 13.7946C2.14553 13.8239 3.17015 13.8406 4.92247 13.8406H7.61158L7.27701 14.5098L6.94244 15.1789H5.94709C4.99775 15.1789 4.94756 15.1831 4.79282 15.2751C4.33697 15.5302 4.34952 16.1994 4.81373 16.4336C4.96847 16.5172 5.08139 16.5172 9.57719 16.5172C14.073 16.5172 14.1859 16.5172 14.3406 16.4336C14.8132 16.1952 14.8132 15.501 14.3406 15.2626C14.1943 15.1873 14.0939 15.1789 13.1947 15.1789H12.2119L11.8774 14.5098L11.5428 13.8406H14.2486C17.2305 13.8406 17.2723 13.8365 17.7993 13.5855C18.1924 13.3973 18.711 12.8829 18.895 12.5024C19.1668 11.942 19.1543 12.2096 19.1543 6.94011C19.1543 1.62461 19.1668 1.8839 18.8741 1.31931C18.6692 0.930375 18.2217 0.474522 17.8536 0.294689C17.2472 -0.00224304 17.9373 0.02285 9.70265 0.0144863C5.62089 0.0103035 2.18735 0.02285 2.07443 0.0437603ZM17.0089 1.39877C17.2932 1.48242 17.5358 1.67061 17.678 1.909L17.7951 2.10974L17.8076 6.86901L17.816 11.6283L17.7282 11.8374C17.6738 11.9587 17.5609 12.1134 17.4522 12.2096C17.0925 12.5275 17.724 12.5024 9.57719 12.5024C1.46384 12.5024 2.07025 12.5233 1.71477 12.2222C1.6144 12.1343 1.49311 11.9712 1.43875 11.8583L1.33837 11.645V6.91502V2.18083L1.45547 1.96336C1.59348 1.69571 1.80259 1.51587 2.09952 1.4155C2.31281 1.34441 2.65575 1.34022 9.56046 1.33604C15.8546 1.33604 16.8248 1.34441 17.0089 1.39877Z"
                                    fill="#1E63B8" />
                                </svg>
                                Desktop
                              </button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="pills-6-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-6" type="button" role="tab" aria-controls="pills-6"
                                aria-selected="false">
                                <svg width="12" height="19" viewBox="0 0 12 19" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <path
                                    d="M1.14601 0.0296154C0.667761 0.144543 0.289614 0.552347 0.193224 1.06025C0.141321 1.33459 0.141321 17.6246 0.193224 17.8989C0.274785 18.3178 0.545419 18.6737 0.927273 18.8517L1.13859 18.9518H5.68006H10.2215L10.4328 18.8517C10.8147 18.6737 11.0853 18.3178 11.1669 17.8989C11.2188 17.6246 11.2188 1.33459 11.1669 1.06025C11.0853 0.641323 10.8147 0.285419 10.4328 0.10747L10.2215 0.0073719L5.75421 -4.3869e-05C3.22211 -4.3869e-05 1.22757 0.0110779 1.14601 0.0296154ZM7.16299 0.989811C7.19265 1.04171 7.19265 1.0862 7.16299 1.1381C7.12591 1.20854 7.08513 1.21225 5.68006 1.21225C4.27498 1.21225 4.2342 1.20854 4.19713 1.1381C4.16747 1.0862 4.16747 1.04171 4.19713 0.989811C4.2342 0.919373 4.27498 0.915665 5.68006 0.915665C7.08513 0.915665 7.12591 0.919373 7.16299 0.989811ZM10.3142 9.31275V16.5976H5.68006H1.04591V9.31275V2.02786H5.68006H10.3142V9.31275ZM5.89138 17.0833C6.01743 17.1315 6.18796 17.2872 6.2584 17.4207C6.37704 17.6468 6.29918 17.9916 6.09157 18.1658C5.66894 18.5217 5.04981 18.2289 5.04981 17.6728C5.04981 17.2501 5.50211 16.935 5.89138 17.0833Z"
                                    fill="#8F8F8F" />
                                </svg>
                                Mobile
                              </button>
                            </li>
                          </ul>
                        </div>
                        <div class="col-sm-3 text-center text-sm-end">
                          <button class="showhide-btn collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target=".multi-collapse2" aria-expanded="false"
                            aria-controls="multiCollapsePerformance21 multiCollapsePerformance22 multiCollapsePerformance23 multiCollapsePerformance24 multiCollapsePerformance25 multiCollapsePerformance26 multiCollapsePerformance27 multiCollapsePerformance28 multiCollapsePerformance29 multiCollapsePerformance210 multiCollapsePerformance211 multiCollapsePerformance212">
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
                      </div>
                      <div class="tab-content mt-3" id="pills-tabContent3">
                        <div class="tab-pane fade show active" id="pills-5" role="tabpanel"
                          aria-labelledby="pills-5-tab" tabindex="0">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="performance-grid-items">
                                <div class="lighthose-circle-content">
                                  <div class="lighthouse-single-circle">
                                    <span
                                      class="circular-progress ${data.statusPerformanceDesktop ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} circular-progress-md progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.scoreDesktop}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="24" class="fw-normal performanceDesktop"></text>
                                      </svg>
                                    </span>
                                    <p>Performance</p>
                                  </div>
                                  <div class="lightose-content collapse multi-collapse2"
                                    id="multiCollapsePerformance21">
                                    <p>
                                    Values are estimated and may vary. The
                                    <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/performance-scoring/">performance score</a> is calculated directly
                                    from these metrics.
                                    <a target="_blank" href="https://googlechrome.github.io/lighthouse/scorecalc/">See calculator.</a>
                                  </p>
                                    <div class="analysis-range1">
                                      <div class="analysis-rangeNum">
                                        <span>0.1 sec</span>
                                        <span>0.25 sec</span>
                                      </div>
                                      <input class="slider-input" id="analysisEx45" type="text" data-slider-id="slider45"
                                        data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                        data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                    { "start": 7, "end": 8, "class": "category2" },
                                    { "start": 17, "end": 19 },
                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                    { "start": -3, "end": 19 }]' />
                                    </div>
                                  </div>
                                </div>
                                <div class="lighthose-circle-content">
                                  <div class="lighthouse-single-circle">
                                    <span
                                      class="circular-progress ${data.statusAccessibilityDesktop ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} circular-progress-md progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.accessibilityDesktop}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="24" class="fw-normal accessibilityDesktop"></text>
                                      </svg>
                                    </span>
                                    <p>Accessibility</p>
                                  </div>
                                  <div class="lightose-content collapse multi-collapse2"
                                    id="multiCollapsePerformance22">
                                    <p>
                                      These checks highlight opportunities
                                      to
                                      <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/accessibility/">improve the accessibility of your
                                        web app.</a>
                                      Only a subset of accessibility issues
                                      can be automatically detected so
                                      manual testing is also encouraged.
                                    </p>
                                    <div class="analysis-range1">
                                      <div class="analysis-rangeNum">
                                        <span>0.1 sec</span>
                                        <span>0.25 sec</span>
                                      </div>
                                      <input class="slider-input" id="analysisEx46" type="text" data-slider-id="slider46"
                                        data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                        data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                    { "start": 7, "end": 8, "class": "category2" },
                                    { "start": 17, "end": 19 },
                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                    { "start": -3, "end": 19 }]' />
                                    </div>
                                  </div>
                                </div>
                                <div class="lighthose-circle-content">
                                  <div class="lighthouse-single-circle">
                                    <span
                                      class="circular-progress ${data.statusBestPracticesDesktop ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} circular-progress-md progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.bestPracticesDesktop}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="24" class="fw-normal bestPracticesDesktop"></text>
                                      </svg>
                                    </span>
                                    <p>Best Practices</p>
                                  </div>
                                  <div class="lightose-content collapse multi-collapse2"
                                    id="multiCollapsePerformance23">
                                    <p>
                                      These checks highlight opportunities to improve the overall code health of your web app.
                                      <a target="_blank" href="https://developer.chrome.com/en/docs/lighthouse/best-practices/">Learn more on Best Practices Audits</a>
                                    </p>

                                    <div class="analysis-range1">
                                      <div class="analysis-rangeNum">
                                        <span>0.1 sec</span>
                                        <span>0.25 sec</span>
                                      </div>
                                      <input class="slider-input" id="analysisEx47" type="text" data-slider-id="slider47"
                                        data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                        data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                    { "start": 7, "end": 8, "class": "category2" },
                                    { "start": 17, "end": 19 },
                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                    { "start": -3, "end": 19 }]' />
                                    </div>
                                  </div>
                                </div>
                                <div class="lighthose-circle-content">
                                  <div class="lighthouse-single-circle">
                                    <span
                                      class="circular-progress ${data.statusSeoDesktop ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} circular-progress-md progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.seoDesktop}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="24" class="fw-normal seoDesktop"></text>
                                      </svg>
                                    </span>
                                    <p>SEO</p>
                                  </div>
                                  <div class="lightose-content collapse multi-collapse2"
                                    id="multiCollapsePerformance24">
                                    <p>
                                      These checks ensure that your page is
                                      following basic search engine
                                      optimization advice. There are many
                                      additional factors Lighthouse does not
                                      score here that may affect your search
                                      ranking, including performance on <a target="_blank" href="https://web.dev/learn-core-web-vitals/">Core
                                      Web Vitals.
                                      <a target="_blank" href="https://developers.google.com/search/docs/essentials">Learn more on Google search essentials</a>
                                    </p>

                                    <div class="analysis-range1">
                                      <div class="analysis-rangeNum">
                                        <span>0.1 sec</span>
                                        <span>0.25 sec</span>
                                      </div>
                                      <input class="slider-input" id="analysisEx48" type="text" data-slider-id="slider48"
                                        data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                        data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                    { "start": 7, "end": 8, "class": "category2" },
                                    { "start": 17, "end": 19 },
                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                    { "start": -3, "end": 19 }]' />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="pills-6" role="tabpanel" aria-labelledby="pills-6-tab"
                          tabindex="0">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="performance-grid-items">
                                <div class="lighthose-circle-content">
                                  <div class="lighthouse-single-circle">
                                    <span
                                      class="circular-progress ${data.statusPerformanceMobile ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} circular-progress-md progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.scoreMobile}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="24" class="fw-normal performanceMobile"></text>
                                      </svg>
                                    </span>
                                    <p>Performance</p>
                                  </div>
                                  <div class="lightose-content collapse multi-collapse2"
                                    id="multiCollapsePerformance25">
                                    <p>
                                    Values are estimated and may vary. The
                                    <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/performance-scoring/">performance score</a> is calculated directly
                                    from these metrics.
                                    <a target="_blank" href="https://googlechrome.github.io/lighthouse/scorecalc/">See calculator.</a>
                                  </p>

                                    <div class="analysis-range1">
                                      <div class="analysis-rangeNum">
                                        <span>0.1 sec</span>
                                        <span>0.25 sec</span>
                                      </div>
                                      <input class="slider-input" id="analysisEx49" type="text" data-slider-id="slider49"
                                        data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                        data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                    { "start": 7, "end": 8, "class": "category2" },
                                    { "start": 17, "end": 19 },
                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                    { "start": -3, "end": 19 }]' />
                                    </div>
                                  </div>
                                </div>
                                <div class="lighthose-circle-content">
                                  <div class="lighthouse-single-circle">
                                    <span
                                      class="circular-progress ${data.statusAccessibilityMobile ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} circular-progress-md progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.accessibilityMobile}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="24" class="fw-normal accessibilityMobile"></text>
                                      </svg>
                                    </span>
                                    <p>Accessibility</p>
                                  </div>
                                  <div class="lightose-content collapse multi-collapse2"
                                    id="multiCollapsePerformance26">
                                    <p>
                                      These checks highlight opportunities
                                      to
                                      <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/accessibility/">improve the accessibility of your
                                        web app.</a>
                                      Only a subset of accessibility issues
                                      can be automatically detected so
                                      manual testing is also encouraged.
                                    </p>

                                    <div class="analysis-range1">
                                      <div class="analysis-rangeNum">
                                        <span>0.1 sec</span>
                                        <span>0.25 sec</span>
                                      </div>
                                      <input class="slider-input" id="analysisEx50" type="text" data-slider-id="slider50"
                                        data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                        data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                    { "start": 7, "end": 8, "class": "category2" },
                                    { "start": 17, "end": 19 },
                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                    { "start": -3, "end": 19 }]' />
                                    </div>
                                  </div>
                                </div>
                                <div class="lighthose-circle-content">
                                  <div class="lighthouse-single-circle">
                                    <span
                                      class="circular-progress ${data.statusBestPracticesMobile ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} circular-progress-md progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.bestPracticesMobile}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="24" class="fw-normal bestPracticesMobile"></text>
                                      </svg>
                                    </span>
                                    <p>Best Practices</p>
                                  </div>
                                  <div class="lightose-content collapse multi-collapse2"
                                    id="multiCollapsePerformance27">
                                    <p>
                                      These checks highlight opportunities to improve the overall code health of your web app.
                                      <a target="_blank" href="https://developer.chrome.com/en/docs/lighthouse/best-practices/">Learn more on Best Practices Audits</a>
                                    </p>

                                    <div class="analysis-range1">
                                      <div class="analysis-rangeNum">
                                        <span>0.1 sec</span>
                                        <span>0.25 sec</span>
                                      </div>
                                      <input class="slider-input" id="analysisEx51" type="text" data-slider-id="slider51"
                                        data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                        data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                    { "start": 7, "end": 8, "class": "category2" },
                                    { "start": 17, "end": 19 },
                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                    { "start": -3, "end": 19 }]' />
                                    </div>
                                  </div>
                                </div>
                                <div class="lighthose-circle-content">
                                  <div class="lighthouse-single-circle">
                                    <span
                                      class="circular-progress ${data.statusSeoMobile ? "progress-green-alt progress-green-alt-bg" : "progress-orange-alt progress-orange-alt-bg"} circular-progress-md progress-text-fill">
                                      <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none" data-value="${data.seoMobile}" class="svg-circle">
                                        <circle r="45" cx="50" cy="50" />
                                        <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                                        <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0"
                                          stroke-linecap="round" stroke-linejoin="round"
                                          stroke-dashoffset="282.78302001953125"
                                          stroke-dasharray="282.78302001953125" />
                                        <!-- Value automatically updates based on data-value set above -->
                                        <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                                          font-size="24" class="fw-normal seoMobile"></text>
                                      </svg>
                                    </span>
                                    <p>SEO</p>
                                  </div>
                                  <div class="lightose-content collapse multi-collapse2"
                                    id="multiCollapsePerformance28">
                                    <p>
                                      These checks ensure that your page is
                                      following basic search engine
                                      optimization advice. There are many
                                      additional factors Lighthouse does not
                                      score here that may affect your search
                                      ranking, including performance on <a target="_blank" href="https://web.dev/learn-core-web-vitals/">Core
                                      Web Vitals.
                                      <a target="_blank" href="https://developers.google.com/search/docs/essentials">Learn more on Google search essentials</a>
                                    </p>
                                    <div class="analysis-range1">
                                      <div class="analysis-rangeNum">
                                        <span>0.1 sec</span>
                                        <span>0.25 sec</span>
                                      </div>
                                      <input class="slider-input" id="analysisEx52" type="text" data-slider-id="slider52"
                                        data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                        data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                    { "start": 7, "end": 8, "class": "category2" },
                                    { "start": 17, "end": 19 },
                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                    { "start": -3, "end": 19 }]' />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>`
  }

  function getGoogleCoreWebVitalsElement(data, icon){
    return `<div class="card">
                    <div class="card-header">
                      <div class="card-header-title">
                        <div class="card-header-left">
                          <span>
                            ${icon}
                          </span>
                          <h4>Core Web Vitals</h4>
                          <span class="card-help">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0V0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36957 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4V14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4V4Z"
                                fill="#D3D5D8" />
                            </svg>
                            <div class="card-help-body">
                              <p>
                                page titles are prominently featured in
                                search engine result pages and are displayed
                                in your visitors browser tabs.
                              </p>
                              <a href="#">Learn More</a>
                            </div>
                          </span>
                        </div>
                        ${!data.status ? 
                          `<div class="card-header-right data-test-name="${data.title}">
                              <button class="btn rounded-pill fix-btn">
                                How to fix it?
                              </button>
                        </div>`
                        : ""}
                        <span class="badge bagde-single-view ${data.status ? "text-success-custom" : "text-danger-custom"}">${data.status ? "PASS" : "FAIL"}</span>
                      </div>
                      <button class="showhide-btn collapsed collapseHideButton" type="button" data-bs-toggle="collapse"
                        data-bs-target="#multiCollapseContent${guidGenerator()}" aria-expanded="false"
                        aria-controls="multiCollapseContent${guidGenerator()}">
                        <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="card-body collapse show collapseHide" id="multiCollapseContent${guidGenerator()}">
                      <div class="row gy-3 gy-sm-0 align-items-center">
                        <div class="col-sm-3 d-none d-sm-block"></div>
                        <div class="col-sm-6">
                          <ul class="nav nav-pills responsive-nav-tabs" id="pills-tab4" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="pills-7-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-7" type="button" role="tab" aria-controls="pills-7"
                                aria-selected="true">
                                <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <path
                                    d="M2.07443 0.0437603C1.09163 0.206865 0.31375 0.913647 0.0670038 1.86717C0.00845388 2.09301 8.95995e-05 2.69524 8.95995e-05 6.92756C8.95995e-05 12.2138 -0.0124568 11.942 0.259382 12.5024C0.460125 12.9164 0.936889 13.3764 1.38438 13.5855C1.57676 13.6775 1.8486 13.7695 1.98242 13.7946C2.14553 13.8239 3.17015 13.8406 4.92247 13.8406H7.61158L7.27701 14.5098L6.94244 15.1789H5.94709C4.99775 15.1789 4.94756 15.1831 4.79282 15.2751C4.33697 15.5302 4.34952 16.1994 4.81373 16.4336C4.96847 16.5172 5.08139 16.5172 9.57719 16.5172C14.073 16.5172 14.1859 16.5172 14.3406 16.4336C14.8132 16.1952 14.8132 15.501 14.3406 15.2626C14.1943 15.1873 14.0939 15.1789 13.1947 15.1789H12.2119L11.8774 14.5098L11.5428 13.8406H14.2486C17.2305 13.8406 17.2723 13.8365 17.7993 13.5855C18.1924 13.3973 18.711 12.8829 18.895 12.5024C19.1668 11.942 19.1543 12.2096 19.1543 6.94011C19.1543 1.62461 19.1668 1.8839 18.8741 1.31931C18.6692 0.930375 18.2217 0.474522 17.8536 0.294689C17.2472 -0.00224304 17.9373 0.02285 9.70265 0.0144863C5.62089 0.0103035 2.18735 0.02285 2.07443 0.0437603ZM17.0089 1.39877C17.2932 1.48242 17.5358 1.67061 17.678 1.909L17.7951 2.10974L17.8076 6.86901L17.816 11.6283L17.7282 11.8374C17.6738 11.9587 17.5609 12.1134 17.4522 12.2096C17.0925 12.5275 17.724 12.5024 9.57719 12.5024C1.46384 12.5024 2.07025 12.5233 1.71477 12.2222C1.6144 12.1343 1.49311 11.9712 1.43875 11.8583L1.33837 11.645V6.91502V2.18083L1.45547 1.96336C1.59348 1.69571 1.80259 1.51587 2.09952 1.4155C2.31281 1.34441 2.65575 1.34022 9.56046 1.33604C15.8546 1.33604 16.8248 1.34441 17.0089 1.39877Z"
                                    fill="#1E63B8" />
                                </svg>
                                Desktop
                              </button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="pills-8-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-8" type="button" role="tab" aria-controls="pills-8"
                                aria-selected="false">
                                <svg width="12" height="19" viewBox="0 0 12 19" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <path
                                    d="M1.14601 0.0296154C0.667761 0.144543 0.289614 0.552347 0.193224 1.06025C0.141321 1.33459 0.141321 17.6246 0.193224 17.8989C0.274785 18.3178 0.545419 18.6737 0.927273 18.8517L1.13859 18.9518H5.68006H10.2215L10.4328 18.8517C10.8147 18.6737 11.0853 18.3178 11.1669 17.8989C11.2188 17.6246 11.2188 1.33459 11.1669 1.06025C11.0853 0.641323 10.8147 0.285419 10.4328 0.10747L10.2215 0.0073719L5.75421 -4.3869e-05C3.22211 -4.3869e-05 1.22757 0.0110779 1.14601 0.0296154ZM7.16299 0.989811C7.19265 1.04171 7.19265 1.0862 7.16299 1.1381C7.12591 1.20854 7.08513 1.21225 5.68006 1.21225C4.27498 1.21225 4.2342 1.20854 4.19713 1.1381C4.16747 1.0862 4.16747 1.04171 4.19713 0.989811C4.2342 0.919373 4.27498 0.915665 5.68006 0.915665C7.08513 0.915665 7.12591 0.919373 7.16299 0.989811ZM10.3142 9.31275V16.5976H5.68006H1.04591V9.31275V2.02786H5.68006H10.3142V9.31275ZM5.89138 17.0833C6.01743 17.1315 6.18796 17.2872 6.2584 17.4207C6.37704 17.6468 6.29918 17.9916 6.09157 18.1658C5.66894 18.5217 5.04981 18.2289 5.04981 17.6728C5.04981 17.2501 5.50211 16.935 5.89138 17.0833Z"
                                    fill="#8F8F8F" />
                                </svg>
                                Mobile
                              </button>
                            </li>
                          </ul>
                        </div>
                        <div class="col-sm-3 text-center text-sm-end">
                          <button class="showhide-btn collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target=".multi-collapse3" aria-expanded="false"
                            aria-controls="multiCollapsePerformance31 multiCollapsePerformance32 multiCollapsePerformance33 multiCollapsePerformance34 multiCollapsePerformance35 multiCollapsePerformance36 multiCollapsePerformance37 multiCollapsePerformance38 multiCollapsePerformance39 multiCollapsePerformance310 multiCollapsePerformance311 multiCollapsePerformance312">
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
                      </div>
                      <div class="tab-content mt-3" id="pills-tabContent4">
                        <div class="tab-pane fade show active" id="pills-7" role="tabpanel"
                          aria-labelledby="pills-7-tab" tabindex="0">
                          <div class="row">
                            <div class="col-12">
                              <div class="performance-desktop performance-list-two">
                                <div class="performance-core-items">
                                  <ul>
                                    <li class="${data.statusFCPDesktop ? "active-orange-green" : "active-orange-red"}">
                                      <p>First Contentful Paint</p>
                                      <h2 class="fcpDesktop">${data.fcpDesktop} s</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance31">
                                        <span>First Contentful Paint marks the time at which the first text or image is painted.
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/first-contentful-paint/">Learn more about the First Contentful Paint metric.</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>1.8 sec</span>
                                            <span>3.0 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx33" type="text" data-slider-id="slider33"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                    <li class="${data.statusTBTDesktop ? "active-orange-green" : "active-orange-red"}">
                                      <p>Time to Interactive</p>
                                      <h2 class="ttiDesktop">${data.tbtDesktop} s</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance32">
                                        <span>Time to Interactice measures how long it takes a page to become fully interactive.
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/interactive/">Learn more about the Time to Interactive Metric</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>3.8 sec</span>
                                            <span>7.3 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx34" type="text" data-slider-id="slider34"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                    <li class="${data.statusSIPDesktop ? "active-orange-green" : "active-orange-red"}">
                                      <p>Speed Index</p>
                                      <h2 class="siDesktop">${data.siDesktop} s</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance33">
                                        <span>Speed Index shows how quickly the contents of a page are visibly populated.
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/speed-index/">Learn more about the Speed Index Metric</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>4.3 sec</span>
                                            <span>5.8 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx35" type="text" data-slider-id="slider35"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                              <div class="performance-desktop performance-list-two">
                                <div class="performance-core-items">
                                  <ul>
                                    <li class="${data.statusTBTDesktop ? "active-orange-green" : "active-orange-red"}">
                                      <p>Total Blocking Time</p>
                                      <h2 class="tbtDesktop">${data.tbtDesktop} ms</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance34">
                                        <span>Sum of all time periods between FCP and Time to Interactive, when task length exceeded 50ms, expressed in milliseconds.
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/lighthouse-total-blocking-time/?utm_source=lighthouse&utm_medium=lr">Learn more about the Total Blocking time metric.</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>300 ms</span>
                                            <span>600 ms</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx36" type="text" data-slider-id="slider36"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                    <li class="${data.statusLCPDesktop ? "active-orange-green" : "active-orange-red"}">
                                      <p>Largest Contentful Paint</p>
                                      <h2 class="lcpDesktop">${data.lcpDesktop} s</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance35">
                                        <span>Largest Contentful Paint marks the time at which the largest text or image is painted
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/lighthouse-largest-contentful-paint/">Learn more about the Largest Contentful paint metric.</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>2.5 sec</span>
                                            <span>4.0 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx37" type="text" data-slider-id="slider37"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                    <li class="${data.statusCLSDesktop ? "active-orange-green" : "active-orange-red"}">
                                      <p>Cumulative Layout Shift</p>
                                      <h2 class="clsDesktop">${data.clsDesktop}</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance36">
                                        <span>Cumulative Layout Shift measures the movement of visible elements within the viewport.
                                          <a target="_blank" href="https://web.dev/cls/">Learn more about the Cumulative Layout Shift Metric</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>0.1 sec</span>
                                            <span>0.25 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx38" type="text" data-slider-id="slider38"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="pills-8" role="tabpanel" aria-labelledby="pills-8-tab"
                          tabindex="0">
                          <div class="row">
                            <div class="col-12">
                              <div class="performance-desktop performance-list-two">
                                <div class="performance-core-items">
                                  <ul>
                                    <li class="${data.statusFCPMobile ? "active-orange-green" : "active-orange-red"}">
                                      <p>First Contentful Paint</p>
                                      <h2 class="fcpMobile">${data.fcpMobile} s</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance37">
                                        <span>First Contentful Paint marks the time at which the first text or image is painted.
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/first-contentful-paint/">Learn more about the First Contentful Paint metric.</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>1.8 sec</span>
                                            <span>3.0 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx39" type="text" data-slider-id="slider39"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                    <li class="${data.statusTTIMobile ? "active-orange-green" : "active-orange-red"}">
                                      <p>Time to Interactive</p>
                                      <h2 class="ttiMobile">${data.ttiMobile} s</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance38">
                                        <span>Time to Interactice measures how long it takes a page to become fully interactive.
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/interactive/">Learn more about the Time to Interactive Metric</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>3.8 sec</span>
                                            <span>7.3 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx40" type="text" data-slider-id="slider40"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                    <li class="${data.statusSIMobile ? "active-orange-green" : "active-orange-red"}">
                                      <p>Speed Index</p>
                                      <h2 class="siMobile">${data.siMobile} s</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance39">
                                        <span>Speed Index shows how quickly the contents of a page are visibly populated.
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/speed-index/">Learn more about the Speed Index Metric</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>4.3 sec</span>
                                            <span>5.8 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx41" type="text" data-slider-id="slider41"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                              <div class="performance-desktop performance-list-two">
                                <div class="performance-core-items">
                                  <ul>
                                    <li class="${data.statusTBTMobile ? "active-orange-green" : "active-orange-red"}">
                                      <p>Total Blocking Time</p>
                                      <h2 class="tbtMobile">${data.tbtMobile} ms</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance310">
                                        <span>Sum of all time periods between FCP and Time to Interactive, when task length exceeded 50ms, expressed in milliseconds.
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/lighthouse-total-blocking-time/?utm_source=lighthouse&utm_medium=lr">Learn more about the Total Blocking time metric.</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>300 ms</span>
                                            <span>600 ms</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx42" type="text" data-slider-id="slider42"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                    <li class="${data.statusLCPMobile ? "active-orange-green" : "active-orange-red"}">
                                      <p>Largest Contentful Paint</p>
                                      <h2 class="lcpMobile">${data.lcpMobile} s</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance311">
                                        <span>Largest Contentful Paint marks the time at which the largest text or image is painted
                                          <a target="_blank" href="https://developer.chrome.com/docs/lighthouse/performance/lighthouse-largest-contentful-paint/">Learn more about the Largest Contentful paint metric.</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>2.5 sec</span>
                                            <span>4.0 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx43" type="text" data-slider-id="slider43"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                    <li class="${data.statusCLSMobile ? "active-orange-green" : "active-orange-red"}">
                                      <p>Cumulative Layout Shift</p>
                                      <h2 class="clsMobile">${data.clsMobile}</h2>
                                      <div class="collapse multi-collapse3" id="multiCollapsePerformance312">
                                        <span>Cumulative Layout Shift measures the movement of visible elements within the viewport.
                                          <a target="_blank" href="https://web.dev/cls/">Learn more about the Cumulative Layout Shift Metric</a></span>
                                        <div class="analysis-range1">
                                          <div class="analysis-rangeNum">
                                            <span>0.1 sec</span>
                                            <span>0.25 sec</span>
                                          </div>
                                          <input class="slider-input" id="analysisEx44" type="text" data-slider-id="slider44"
                                            data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                            data-slider-value="85" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                        { "start": 7, "end": 8, "class": "category2" },
                                        { "start": 17, "end": 19 },
                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                        { "start": -3, "end": 19 }]' />
                                        </div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>`;
  } 

  function buildResult(testLabels, data, buildResult){
      if(!buildResult){
        updateProgress(testLabels, data)
      }
      if(data.name === "google_check"){
          buildElementGoogle(data)
      }else if(data.name === "og_tags" || data.name === "twitter_tags"){
          buildElementWithTable(testLabels, data)
      }else{
          buildElement1(data, false)
      }


      switch(data.tagName){
          case "Images":
              buildImagesPanel(data)
              break;
      }
      // activateTooltip()
  }




  function buildImagesPanel(data){
      data.problems.forEach((prob, i)=>{
        
          const tr = document.createElement("tr")
          prob.status ? tr.classList.add("passed") : tr.classList.add("failed") 
          prob.status ? tr.classList.add("row-green-bg") : tr.classList.add("row-orange-bg") 
          tr.innerHTML = `
          <td class="content-td image-table-link" td-replace="${prob.imageSrc}"><a href="${prob.imageSrc}" target="_blank"><span>Link</span>
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M11.3333 5.33333C11.1565 5.33333 10.987 5.40357 10.8619 5.5286C10.7369 5.65362 10.6667 5.82319 10.6667 6V10C10.6667 10.1768 10.5964 10.3464 10.4714 10.4714C10.3464 10.5964 10.1768 10.6667 10 10.6667H2C1.82319 10.6667 1.65362 10.5964 1.5286 10.4714C1.40357 10.3464 1.33333 10.1768 1.33333 10V2C1.33333 1.82319 1.40357 1.65362 1.5286 1.5286C1.65362 1.40357 1.82319 1.33333 2 1.33333H6C6.17681 1.33333 6.34638 1.2631 6.4714 1.13807C6.59643 1.01305 6.66667 0.843478 6.66667 0.666667C6.66667 0.489856 6.59643 0.320286 6.4714 0.195262C6.34638 0.0702379 6.17681 0 6 0H2C1.46957 0 0.960859 0.210714 0.585787 0.585787C0.210714 0.960859 0 1.46957 0 2V10C0 10.5304 0.210714 11.0391 0.585787 11.4142C0.960859 11.7893 1.46957 12 2 12H10C10.5304 12 11.0391 11.7893 11.4142 11.4142C11.7893 11.0391 12 10.5304 12 10V6C12 5.82319 11.9298 5.65362 11.8047 5.5286C11.6797 5.40357 11.5101 5.33333 11.3333 5.33333Z" fill="#1E63B8"></path>
              <path d="M8.66728 1.33333H9.72061L5.52728 5.52C5.46479 5.58198 5.4152 5.65571 5.38135 5.73695C5.3475 5.81819 5.33008 5.90533 5.33008 5.99333C5.33008 6.08134 5.3475 6.16848 5.38135 6.24972C5.4152 6.33096 5.46479 6.40469 5.52728 6.46667C5.58925 6.52915 5.66299 6.57875 5.74423 6.61259C5.82547 6.64644 5.9126 6.66387 6.00061 6.66387C6.08862 6.66387 6.17576 6.64644 6.25699 6.61259C6.33823 6.57875 6.41197 6.52915 6.47394 6.46667L10.6673 2.28V3.33333C10.6673 3.51014 10.7375 3.67971 10.8625 3.80474C10.9876 3.92976 11.1571 4 11.3339 4C11.5108 4 11.6803 3.92976 11.8053 3.80474C11.9304 3.67971 12.0006 3.51014 12.0006 3.33333V0.666667C12.0006 0.489856 11.9304 0.320286 11.8053 0.195262C11.6803 0.0702379 11.5108 0 11.3339 0H8.66728C8.49047 0 8.3209 0.0702379 8.19587 0.195262C8.07085 0.320286 8.00061 0.489856 8.00061 0.666667C8.00061 0.843478 8.07085 1.01305 8.19587 1.13807C8.3209 1.2631 8.49047 1.33333 8.66728 1.33333Z" fill="#1E63B8"></path>
          </svg> </a></td>
          <td class="align-left">${prob.imageAlt}</td>
          <td class="${prob.imageAltSpacesClass}">${prob.imageAltSpacesStatus ? "<span class='result_pass'>Yes</span>" : "<span class='result_fail'>No</span>"}</td>
          <td class="align-left">${prob.imageName}</td>
          <td class="${prob.imageLengthClass}">${prob.imageLengthStatus ? prob.imageName.length : "-"}</td>
          <td class="${prob.imageHyphenClass}">${prob.imageHyphenStatus ? "<span class='result_pass'>Yes</span>" : "<span class='result_fail'>No</span>"}</td>
          <td class="${prob.imageUppercaseClass}">${prob.imageUppercaseStatus ? "<span class='result_fail'>Yes</span>" : "<span class='result_pass'>No</span>"}</td>
          <td class="${prob.imageSpecialClass}">${prob.imageSpecialStatus ? "<span class='result_fail'>Yes</span>" : "<span class='result_pass'>No</span>"}</td>
          <td class="${prob.imageSizeClass}">${prob.imageSizeValue}</td>
          <td class="${prob.status ? "result_pass" : "result_fail"}">${prob.status ? "PASS" : "FAIL"}</td>
          `
          document.getElementById("tbodyImages").appendChild(tr)
      })
  }


    // Schema panel: pretty-print JSON-LD sample, list types and problems
    function buildSchemaPanel(data){
      const div = document.createElement("div")
      div.classList.add("analysis-card")
      div.setAttribute("data-name", data.label.name)
      // Defensive status: if backend didn't return boolean, compute from problems/httpStatus
      const status = (typeof data.status !== 'undefined') ? data.status : (!data.problems || data.problems.length === 0) && (typeof data.httpStatus === 'undefined' || data.httpStatus === 200);
      status ? div.classList.add("card__pass") : div.classList.add("card__failed")
  
      const badge = `<span class="badge bagde-single-view ${status ? "text-success-custom" : "text-danger-custom"}">${status ? "PASS" : "FAIL"}</span>`
  
      // If backend provided blocks, render accordion grouped by type; otherwise fall back to single snippet
      if (data.blocks && data.blocks.length) {
        // build map: type -> array of blocks
        const map = {};
        data.blocks.forEach((blk, i) => {
          const types = blk.types && blk.types.length ? blk.types : ['(unknown)'];
          types.forEach(t => {
            if(!map[t]) map[t] = [];
            map[t].push(Object.assign({}, blk, { index: i+1 }));
          });
        });
  
        let accordionHtml = '';
        let idx = 0;
        for(const t in map){
          idx++;
          const blocksForType = map[t];
          const errors = blocksForType.reduce((acc, b) => acc + (b.problems && b.problems.length ? b.problems.length : 0), 0);
          const warnings = 0;
          const items = blocksForType.length;
  
          let inner = '';
          blocksForType.forEach(b=>{
            const snippet = b.snippet ? `<pre style="white-space:pre-wrap; background:#f8f9fa; padding:8px; border-radius:4px; max-height:220px; overflow:auto;">${escapeHtml(b.snippet)}</pre>` : '';
            const probs = (b.problems && b.problems.length) ? UI.getProblemsElement(b.problems) : '<div class="no-problems">No problems</div>';
            inner += `<div class="schema-block"><div style="margin-bottom:6px;"><strong>Block ${b.index}</strong></div>${snippet}${probs}</div>`;
          });
  
          accordionHtml += `
            <div class="schema-type-row" style="border:1px solid #eee; margin-bottom:8px; border-radius:6px; padding:10px;">
              <div class="d-flex justify-content-between align-items-center">
                <div><strong>${t}</strong></div>
                <div style="font-size:12px; color:#666">${errors} ERRORS &nbsp;&nbsp; ${warnings} WARNINGS &nbsp;&nbsp; ${items} ITEM${items>1?'S':''}</div>
              </div>
              <div style="margin-top:8px; display:none;" class="schema-type-content" id="schema-type-content-${idx}">
                ${inner}
              </div>
              <div style="text-align:right; margin-top:8px;">
                <a href="javascript:void(0)" class="schema-toggle-icon" data-target="#schema-type-content-${idx}">
                  <svg width="12" height="8" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </a>
              </div>
            </div>
          `;
        }
  
        div.innerHTML = `
          <div class="card">
            <div class="card-header">
              <div class="card-header-title">
                <div class="card-header-left">
                  <h4>${data.title}</h4>
                </div>
                ${badge}
              </div>
            </div>
            <div class="card-body">
              ${accordionHtml}
            </div>
          </div>
        `;
        // style badge for visibility
        setTimeout(()=> {
          try {
            const b = div.querySelector('.bagde-single-view');
            if(b){
              b.style.backgroundColor = status ? '#80AE35' : '#FA5457';
              b.style.color = '#fff';
              b.style.padding = '4px 8px';
              b.style.borderRadius = '12px';
              b.style.fontSize = '12px';
              b.style.marginLeft = '8px';
              b.style.display = 'inline-block';
            }
          }catch(e){}
        }, 10);
        // attach click handlers for toggle icons
        setTimeout(()=> {
          const toggles = div.querySelectorAll('.schema-toggle-icon');
          toggles.forEach(btn=>{
            btn.addEventListener('click', function(){
              const target = document.querySelector(this.getAttribute('data-target'));
              if(!target) return;
              const svg = this.querySelector('svg');
              if(target.style.display === 'block') {
                target.style.display = 'none';
                if(svg) svg.style.transform = '';
              } else {
                target.style.display = 'block';
                if(svg) svg.style.transform = 'rotate(180deg)';
              }
            })
          })
        }, 10);
  
      } else {
        const typesHtml = (data.types && data.types.length) ? `<div style="margin-bottom:8px;"><strong>Types:</strong> ${data.types.join(', ')}</div>` : `<div style="margin-bottom:8px;"><strong>Types:</strong> None detected</div>`;
        const snippetHtml = data.sampleSnippet ? `<pre class="schema-snippet" style="white-space:pre-wrap; max-height:320px; overflow:auto; background:#f8f9fa; padding:10px; border-radius:4px;">${escapeHtml(data.sampleSnippet)}</pre>` : `<div class="no-snippet">No JSON-LD sample available.</div>`;
        const problemsHtml = (data.problems && data.problems.length) ? UI.getProblemsElement(data.problems) : `<div class="no-problems">No problems detected.</div>`;
        div.innerHTML = `
          <div class="card">
            <div class="card-header">
              <div class="card-header-title">
                <div class="card-header-left">
                  <h4>${data.title}</h4>
                </div>
                ${badge}
              </div>
            </div>
            <div class="card-body collapse show">
              <div class="row">
                <div class="content-element col-md-6">
                  ${typesHtml}
                  <div style="margin-top:10px;"><strong>Sample JSON-LD</strong></div>
                  ${snippetHtml}
                </div>
                <div class="content-element col-md-6">
                  <div style="margin-bottom:10px;"><strong>Problems / Warnings</strong></div>
                  ${problemsHtml}
                </div>
              </div>
            </div>
          </div>
        `
        // style badge for visibility (fallback)
        setTimeout(()=> {
          try {
            const b = div.querySelector('.bagde-single-view');
            if(b){
              b.style.backgroundColor = (data.status || (data.problems && data.problems.length===0 && data.httpStatus===200)) ? '#80AE35' : '#FA5457';
              b.style.color = '#fff';
              b.style.padding = '4px 8px';
              b.style.borderRadius = '12px';
              b.style.fontSize = '12px';
              b.style.marginLeft = '8px';
              b.style.display = 'inline-block';
            }
          }catch(e){}
        }, 10);
      }
  alert(data.showContent)
      // If Schema test is excluded (server signals showContent=false) do not render the schema card
      if(data && data.label && data.label.name === 'schema' && data.showContent === false){
        return;
      }
  
      // Append into the SEO card container (same place other SEO tests use)
      const target = document.getElementById("cardMetaTitle") || document.querySelector(".card-custom-container");
      if(target){
        target.appendChild(div)
      }else{
        document.body.appendChild(div)
      }
  
      // Attach global delegated click handler for schema subcard toggles (only once)
      try {
        if (!window._schemaSubToggleBound) {
          document.addEventListener('click', function(ev){
          const btn = (ev.target.closest && (ev.target.closest('.schema-sub-toggle') || ev.target.closest('.schema-sub-header')));
            if(!btn) return;
            const selector = btn.getAttribute('data-target') || (btn.querySelector && btn.querySelector('.schema-sub-toggle') && btn.querySelector('.schema-sub-toggle').getAttribute('data-target'));
            if(!selector) return;
            // Prefer to find target within the same card ancestor for isolation
            const card = btn.closest('.analysis-card');
            let target = null;
            if(card){
              target = card.querySelector(selector);
            }
            if(!target){
              target = document.querySelector(selector);
            }
            if(!target) {
              console.debug('Schema toggle: target not found', selector, btn);
              return;
            }
  
            // determine current computed display
            const comp = window.getComputedStyle(target).display;
            console.debug('Schema toggle click', { selector, comp, target, btn });
            try {
              if(comp === 'none'){
                target.style.display = 'block';
                const svg = btn.querySelector('svg');
                if(svg) svg.style.transform = 'rotate(180deg)';
              } else {
                target.style.display = 'none';
                const svg = btn.querySelector('svg');
                if(svg) svg.style.transform = '';
              }
            } catch (e) {
              console.error('Schema toggle error', e);
            }
          });
          window._schemaSubToggleBound = true;
        }
      } catch(e){}
    }
  
    // helper to escape HTML for safe display
    function escapeHtml(unsafe) {
      if(!unsafe) return "";
      return String(unsafe)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }
  
  // Exposed helper to toggle schema subcards (used by inline onclick attributes)
  window.toggleSchemaSubBySelector = function(selector, btn){
    try{
      const elBtn = btn || document.querySelector(`[data-target="${selector}"]`);
      const card = elBtn && elBtn.closest ? elBtn.closest('.analysis-card') : null;
      let target = null;
      if(card){
        target = card.querySelector(selector);
      }
      if(!target){
        target = document.querySelector(selector);
      }
      if(!target){
        console.debug('toggleSchemaSubBySelector: target not found', selector, btn);
        return;
      }
      const comp = window.getComputedStyle(target).display;
      console.debug('toggleSchemaSubBySelector click', { selector, comp, target, btn });
      if(comp === 'none'){
        target.style.display = 'block';
        const svg = (elBtn && elBtn.querySelector) ? elBtn.querySelector('svg') : null;
        if(svg) svg.style.transform = 'rotate(180deg)';
      } else {
        target.style.display = 'none';
        const svg = (elBtn && elBtn.querySelector) ? elBtn.querySelector('svg') : null;
        if(svg) svg.style.transform = '';
      }
    }catch(e){
      console.error('toggleSchemaSubBySelector error', e);
    }
  }

  function buildElementWithTable(testLabels, data){
    let div = document.createElement("div")
      div.classList.add("analysis-card")
      div.setAttribute("data-name", data.label.name)
      data.status ? div.classList.add("card__pass") : div.classList.add("card__failed")
      let icon
      if(data.status){
          icon = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12.72 6.79L8.43001 11.09L6.78 9.44C6.69036 9.33532 6.58004 9.2503 6.45597 9.19027C6.33191 9.13025 6.19678 9.09652 6.05906 9.0912C5.92134 9.08588 5.78401 9.10909 5.65568 9.15936C5.52736 9.20964 5.41081 9.28589 5.31335 9.38335C5.2159 9.4808 5.13964 9.59735 5.08937 9.72568C5.03909 9.854 5.01589 9.99133 5.02121 10.1291C5.02653 10.2668 5.06026 10.4019 5.12028 10.526C5.1803 10.65 5.26532 10.7604 5.37 10.85L7.72 13.21C7.81344 13.3027 7.92426 13.376 8.0461 13.4258C8.16794 13.4755 8.2984 13.5008 8.43001 13.5C8.69234 13.4989 8.94374 13.3947 9.13 13.21L14.13 8.21C14.2237 8.11704 14.2981 8.00644 14.3489 7.88458C14.3997 7.76272 14.4258 7.63201 14.4258 7.5C14.4258 7.36799 14.3997 7.23728 14.3489 7.11542C14.2981 6.99356 14.2237 6.88296 14.13 6.79C13.9426 6.60375 13.6892 6.49921 13.425 6.49921C13.1608 6.49921 12.9074 6.60375 12.72 6.79ZM10 0C8.02219 0 6.08879 0.58649 4.4443 1.6853C2.79981 2.78412 1.51809 4.3459 0.761209 6.17317C0.00433284 8.00043 -0.193701 10.0111 0.192152 11.9509C0.578004 13.8907 1.53041 15.6725 2.92894 17.0711C4.32746 18.4696 6.10929 19.422 8.0491 19.8079C9.98891 20.1937 11.9996 19.9957 13.8268 19.2388C15.6541 18.4819 17.2159 17.2002 18.3147 15.5557C19.4135 13.9112 20 11.9778 20 10C20 8.68678 19.7413 7.38642 19.2388 6.17317C18.7363 4.95991 17.9997 3.85752 17.0711 2.92893C16.1425 2.00035 15.0401 1.26375 13.8268 0.761205C12.6136 0.258658 11.3132 0 10 0ZM10 18C8.41775 18 6.87104 17.5308 5.55544 16.6518C4.23985 15.7727 3.21447 14.5233 2.60897 13.0615C2.00347 11.5997 1.84504 9.99113 2.15372 8.43928C2.4624 6.88743 3.22433 5.46197 4.34315 4.34315C5.46197 3.22433 6.88743 2.4624 8.43928 2.15372C9.99113 1.84504 11.5997 2.00346 13.0615 2.60896C14.5233 3.21447 15.7727 4.23984 16.6518 5.55544C17.5308 6.87103 18 8.41775 18 10C18 12.1217 17.1572 14.1566 15.6569 15.6569C14.1566 17.1571 12.1217 18 10 18Z" fill="#80AE35"></path>
        </svg>`;
      }else{
          icon = `<svg width="20" height="20" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M13.8329 6.41288C13.7399 6.31915 13.6293 6.24476 13.5075 6.19399C13.3856 6.14322 13.2549 6.11708 13.1229 6.11708C12.9909 6.11708 12.8602 6.14322 12.7383 6.19399C12.6164 6.24476 12.5058 6.31915 12.4129 6.41288L10.1229 8.71288L7.83288 6.41288C7.64458 6.22458 7.38918 6.11879 7.12288 6.11879C6.85658 6.11879 6.60119 6.22458 6.41288 6.41288C6.22458 6.60119 6.11879 6.85658 6.11879 7.12288C6.11879 7.38918 6.22458 7.64458 6.41288 7.83288L8.71288 10.1229L6.41288 12.4129C6.31915 12.5058 6.24476 12.6164 6.19399 12.7383C6.14322 12.8602 6.11708 12.9909 6.11708 13.1229C6.11708 13.2549 6.14322 13.3856 6.19399 13.5075C6.24476 13.6293 6.31915 13.7399 6.41288 13.8329C6.50585 13.9266 6.61645 14.001 6.73831 14.0518C6.86016 14.1025 6.99087 14.1287 7.12288 14.1287C7.25489 14.1287 7.3856 14.1025 7.50746 14.0518C7.62932 14.001 7.73992 13.9266 7.83288 13.8329L10.1229 11.5329L12.4129 13.8329C12.5058 13.9266 12.6164 14.001 12.7383 14.0518C12.8602 14.1025 12.9909 14.1287 13.1229 14.1287C13.2549 14.1287 13.3856 14.1025 13.5075 14.0518C13.6293 14.001 13.7399 13.9266 13.8329 13.8329C13.9266 13.7399 14.001 13.6293 14.0518 13.5075C14.1025 13.3856 14.1287 13.2549 14.1287 13.1229C14.1287 12.9909 14.1025 12.8602 14.0518 12.7383C14.001 12.6164 13.9266 12.5058 13.8329 12.4129L11.5329 10.1229L13.8329 7.83288C13.9266 7.73992 14.001 7.62932 14.0518 7.50746C14.1025 7.3856 14.1287 7.25489 14.1287 7.12288C14.1287 6.99087 14.1025 6.86016 14.0518 6.73831C14.001 6.61645 13.9266 6.50585 13.8329 6.41288ZM17.1929 3.05288C16.2704 2.09778 15.167 1.33596 13.9469 0.811868C12.7269 0.287778 11.4147 0.0119157 10.0869 0.000377568C8.7591 -0.0111606 7.44231 0.241856 6.21334 0.744665C4.98438 1.24747 3.86786 1.99001 2.92893 2.92893C1.99001 3.86786 1.24747 4.98438 0.744665 6.21334C0.241856 7.44231 -0.0111606 8.7591 0.000377568 10.0869C0.0119157 11.4147 0.287778 12.7269 0.811868 13.9469C1.33596 15.167 2.09778 16.2704 3.05288 17.1929C3.97535 18.148 5.0788 18.9098 6.29884 19.4339C7.51888 19.958 8.83108 20.2339 10.1589 20.2454C11.4867 20.2569 12.8035 20.0039 14.0324 19.5011C15.2614 18.9983 16.3779 18.2558 17.3168 17.3168C18.2558 16.3779 18.9983 15.2614 19.5011 14.0324C20.0039 12.8035 20.2569 11.4867 20.2454 10.1589C20.2339 8.83108 19.958 7.51888 19.4339 6.29884C18.9098 5.0788 18.148 3.97535 17.1929 3.05288ZM15.7829 15.7829C14.4749 17.0923 12.7534 17.9077 10.9117 18.0902C9.06993 18.2727 7.22189 17.8109 5.6824 16.7837C4.14292 15.7564 3.00724 14.2271 2.46886 12.4564C1.93047 10.6856 2.02269 8.78302 2.7298 7.07267C3.4369 5.36231 4.71516 3.95003 6.34677 3.07644C7.97839 2.20286 9.86242 1.92201 11.6779 2.28176C13.4934 2.6415 15.1279 3.61957 16.3031 5.04934C17.4783 6.47911 18.1214 8.27212 18.1229 10.1229C18.1265 11.1742 17.9215 12.2157 17.5198 13.1873C17.1182 14.1588 16.5278 15.041 15.7829 15.7829Z" fill="#FA5457"></path>
        </svg>`
      }


      switch(data.name){
          case "og_tags":
              div.innerHTML = UI.getOgTagsElement(data, icon)
              break;
          case "twitter_tags":
              div.innerHTML = UI.getTwitterTagsElement(data, icon)
              break;
      }


      document.getElementById("cardMetaTitle").appendChild(div)
  }


 
  function buildElement1(data, intentionalState){
    let brokenLinksCount = 0
    if(data.title === 'Broken Links'){
      // Count actual broken links by looping through data.allLinks
      for (var key in data.allLinks) {
        if (data.allLinks.hasOwnProperty(key)) {
          let status
          const state = data.allLinks[key]["state"];

          if(state == "fulfilled"){
            const value = data.allLinks[key]["value"];
            status = value["status"]
          }else{
            status = 404
          }

          if(status != 200 && status != 0 && status != 405){
            brokenLinksCount++
          }
        }
      }

      brokenLinksData = data
      // Store the broken links data globally for the ignore functionality
      window.currentAnalysisData = {
        allLinks: data.allLinks,
        totalBrokenLinks: brokenLinksCount
      };
    }
      // building problems
      let ul
      if(data.tagName != "Images"){
        ul = UI.getProblemsElement(data.problems)
      }
      
      // Prepare schema subcards HTML if this is Schema test
      let schemaBlocksHtml = '';
      if((data.title === 'Schema' || data.tagName === 'Schema') && Array.isArray(data.blocks) && data.blocks.length){
        schemaBlocksHtml += '<div class="card-inner-content schema-blocks-container">';
        data.blocks.forEach((b, idx) => {
          const typesText = (b.types && b.types.length) ? b.types.join(', ') : '(unknown)';
          const snippet = b.snippet ? `<pre style="white-space:pre-wrap; background:#f8f9fa; padding:8px; border-radius:4px; max-height:220px; overflow:auto;">${escapeHtml(b.snippet)}</pre>` : '';
          const probsHtml = (b.problems && b.problems.length) ? UI.getProblemsElement(b.problems) : '<div class="no-problems">No problems</div>';
          // Make header clickable by adding schema-sub-header with data-target
          schemaBlocksHtml += `<div class="card mb-2 schema-subcard">
              <div class="card-body">
                <div class="schema-sub-header d-flex justify-content-between align-items-center" data-target="#schema-sub-${idx}" role="button" tabindex="0" style="cursor:pointer;"
                     onclick="toggleSchemaSubBySelector('#schema-sub-${idx}', this)">
                  <div><strong>${typesText}</strong></div>
                  <div><a href="javascript:void(0)" class="schema-sub-toggle" data-target="#schema-sub-${idx}" onclick="toggleSchemaSubBySelector('#schema-sub-${idx}', this)">▾</a></div>
                </div>
                <div id="schema-sub-${idx}" style="display:none; margin-top:8px;">
                  ${snippet}
                  ${probsHtml}
                </div>
              </div>
            </div>`;
        });
        schemaBlocksHtml += '</div>';
      }
      

      const div = document.createElement("div")
      div.classList.add("analysis-card")
      div.setAttribute("data-name", data.label.name)
      data.status ? div.classList.add("card__pass") : div.classList.add("card__failed")
      // Default favicon - will be updated via AJAX
      const defaultFavicon = '/new-assets/assets/images/amazon.png';
      let testedUrlFavicon = defaultFavicon;
      let icon
      if(data.status){
          icon = `<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12.72 6.79L8.43001 11.09L6.78 9.44C6.69036 9.33532 6.58004 9.2503 6.45597 9.19027C6.33191 9.13025 6.19678 9.09652 6.05906 9.0912C5.92134 9.08588 5.78401 9.10909 5.65568 9.15936C5.52736 9.20964 5.41081 9.28589 5.31335 9.38335C5.2159 9.4808 5.13964 9.59735 5.08937 9.72568C5.03909 9.854 5.01589 9.99133 5.02121 10.1291C5.02653 10.2668 5.06026 10.4019 5.12028 10.526C5.1803 10.65 5.26532 10.7604 5.37 10.85L7.72 13.21C7.81344 13.3027 7.92426 13.376 8.0461 13.4258C8.16794 13.4755 8.2984 13.5008 8.43001 13.5C8.69234 13.4989 8.94374 13.3947 9.13 13.21L14.13 8.21C14.2237 8.11704 14.2981 8.00644 14.3489 7.88458C14.3997 7.76272 14.4258 7.63201 14.4258 7.5C14.4258 7.36799 14.3997 7.23728 14.3489 7.11542C14.2981 6.99356 14.2237 6.88296 14.13 6.79C13.9426 6.60375 13.6892 6.49921 13.425 6.49921C13.1608 6.49921 12.9074 6.60375 12.72 6.79ZM10 0C8.02219 0 6.08879 0.58649 4.4443 1.6853C2.79981 2.78412 1.51809 4.3459 0.761209 6.17317C0.00433284 8.00043 -0.193701 10.0111 0.192152 11.9509C0.578004 13.8907 1.53041 15.6725 2.92894 17.0711C4.32746 18.4696 6.10929 19.422 8.0491 19.8079C9.98891 20.1937 11.9996 19.9957 13.8268 19.2388C15.6541 18.4819 17.2159 17.2002 18.3147 15.5557C19.4135 13.9112 20 11.9778 20 10C20 8.68678 19.7413 7.38642 19.2388 6.17317C18.7363 4.95991 17.9997 3.85752 17.0711 2.92893C16.1425 2.00035 15.0401 1.26375 13.8268 0.761205C12.6136 0.258658 11.3132 0 10 0ZM10 18C8.41775 18 6.87104 17.5308 5.55544 16.6518C4.23985 15.7727 3.21447 14.5233 2.60897 13.0615C2.00347 11.5997 1.84504 9.99113 2.15372 8.43928C2.4624 6.88743 3.22433 5.46197 4.34315 4.34315C5.46197 3.22433 6.88743 2.4624 8.43928 2.15372C9.99113 1.84504 11.5997 2.00346 13.0615 2.60896C14.5233 3.21447 15.7727 4.23984 16.6518 5.55544C17.5308 6.87103 18 8.41775 18 10C18 12.1217 17.1572 14.1566 15.6569 15.6569C14.1566 17.1571 12.1217 18 10 18Z" fill="#80AE35"></path>
        </svg>`;
      }else{
          icon = `<svg width="20" height="20" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M13.8329 6.41288C13.7399 6.31915 13.6293 6.24476 13.5075 6.19399C13.3856 6.14322 13.2549 6.11708 13.1229 6.11708C12.9909 6.11708 12.8602 6.14322 12.7383 6.19399C12.6164 6.24476 12.5058 6.31915 12.4129 6.41288L10.1229 8.71288L7.83288 6.41288C7.64458 6.22458 7.38918 6.11879 7.12288 6.11879C6.85658 6.11879 6.60119 6.22458 6.41288 6.41288C6.22458 6.60119 6.11879 6.85658 6.11879 7.12288C6.11879 7.38918 6.22458 7.64458 6.41288 7.83288L8.71288 10.1229L6.41288 12.4129C6.31915 12.5058 6.24476 12.6164 6.19399 12.7383C6.14322 12.8602 6.11708 12.9909 6.11708 13.1229C6.11708 13.2549 6.14322 13.3856 6.19399 13.5075C6.24476 13.6293 6.31915 13.7399 6.41288 13.8329C6.50585 13.9266 6.61645 14.001 6.73831 14.0518C6.86016 14.1025 6.99087 14.1287 7.12288 14.1287C7.25489 14.1287 7.3856 14.1025 7.50746 14.0518C7.62932 14.001 7.73992 13.9266 7.83288 13.8329L10.1229 11.5329L12.4129 13.8329C12.5058 13.9266 12.6164 14.001 12.7383 14.0518C12.8602 14.1025 12.9909 14.1287 13.1229 14.1287C13.2549 14.1287 13.3856 14.1025 13.5075 14.0518C13.6293 14.001 13.7399 13.9266 13.8329 13.8329C13.9266 13.7399 14.001 13.6293 14.0518 13.5075C14.1025 13.3856 14.1287 13.2549 14.1287 13.1229C14.1287 12.9909 14.1025 12.8602 14.0518 12.7383C14.001 12.6164 13.9266 12.5058 13.8329 12.4129L11.5329 10.1229L13.8329 7.83288C13.9266 7.73992 14.001 7.62932 14.0518 7.50746C14.1025 7.3856 14.1287 7.25489 14.1287 7.12288C14.1287 6.99087 14.1025 6.86016 14.0518 6.73831C14.001 6.61645 13.9266 6.50585 13.8329 6.41288ZM17.1929 3.05288C16.2704 2.09778 15.167 1.33596 13.9469 0.811868C12.7269 0.287778 11.4147 0.0119157 10.0869 0.000377568C8.7591 -0.0111606 7.44231 0.241856 6.21334 0.744665C4.98438 1.24747 3.86786 1.99001 2.92893 2.92893C1.99001 3.86786 1.24747 4.98438 0.744665 6.21334C0.241856 7.44231 -0.0111606 8.7591 0.000377568 10.0869C0.0119157 11.4147 0.287778 12.7269 0.811868 13.9469C1.33596 15.167 2.09778 16.2704 3.05288 17.1929C3.97535 18.148 5.0788 18.9098 6.29884 19.4339C7.51888 19.958 8.83108 20.2339 10.1589 20.2454C11.4867 20.2569 12.8035 20.0039 14.0324 19.5011C15.2614 18.9983 16.3779 18.2558 17.3168 17.3168C18.2558 16.3779 18.9983 15.2614 19.5011 14.0324C20.0039 12.8035 20.2569 11.4867 20.2454 10.1589C20.2339 8.83108 19.958 7.51888 19.4339 6.29884C18.9098 5.0788 18.148 3.97535 17.1929 3.05288ZM15.7829 15.7829C14.4749 17.0923 12.7534 17.9077 10.9117 18.0902C9.06993 18.2727 7.22189 17.8109 5.6824 16.7837C4.14292 15.7564 3.00724 14.2271 2.46886 12.4564C1.93047 10.6856 2.02269 8.78302 2.7298 7.07267C3.4369 5.36231 4.71516 3.95003 6.34677 3.07644C7.97839 2.20286 9.86242 1.92201 11.6779 2.28176C13.4934 2.6415 15.1279 3.61957 16.3031 5.04934C17.4783 6.47911 18.1214 8.27212 18.1229 10.1229C18.1265 11.1742 17.9215 12.2157 17.5198 13.1873C17.1182 14.1588 16.5278 15.041 15.7829 15.7829Z" fill="#FA5457"></path>
        </svg>`
      }

      
      div.innerHTML =  `
                  <div class="card">
                    <div class="card-header">
                      <div class="card-header-title">
                        <div class="card-header-left">
                          <span>
                            ${icon}
                          </span>
                          <h4>${data.title}</h4>
                          <span class="card-help">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0V0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36957 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4V14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4V4Z"
                                fill="#D3D5D8" />
                            </svg>
                            <div class="card-help-body">
                              <p>${data.description}</p>
                              <a href="${data.learnMoreURL}" target="_blank">Learn More</a>
                            </div>
                          </span>
                        </div>
                        ${!data.status ? 
                          `<div class="card-header-right data-test-name="${data.title}" data-test-name="${data.title}">
                              <button class="btn rounded-pill fix-btn">
                                How to fix it?
                              </button>
                        </div>
                        `
                        : ""}

                      <span class="badge bagde-single-view ${data.status ? "text-success-custom" : "text-danger-custom"}">${data.status ? "PASS" : "FAIL"}</span>
                      </div>
                      <button class="showhide-btn collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#multiCollapseContent${guidGenerator()}" aria-expanded="false"
                        aria-controls="multiCollapseContent${guidGenerator()}">
                        <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        </svg>
                      </button>
                    </div>
                    <div class="card-body collapse show" id="multiCollapseContent${guidGenerator()}">
                      <div class="row">



                        <div class="content-element ${data.showSnippet ? "col-md-6" : "col-md-12"}">
                          <div class="card-single-content ${data.status ? "text-success-custom" : "text-danger-custom"} problem-help">
                            <p>
                              <span class="badge status_pdf">${data.status ? "PASS" : "FAIL"}</span>
                              <span class="message_pdf">${data.label.name === "broken_links"  ? `Your page has ${window.currentAnalysisData.totalBrokenLinks} broken links, please see the list below.` : data.message}</span>
                            </p>

                            ${data.showSnippet ? `
                            <div class="align-items-end justify-content-end card-sniper-group">
                              <div class="show-snip-btn snippet-btn" style="display:none">
                                  <button>
                                    <span>Show Snippet</span>
                                    <span>
                                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="16" height="16" rx="8" fill="white"></rect>
                                        <path d="M12.9583 7.79868C11.9486 5.45449 10.0493 4 8 4C5.95071 4 4.05138 5.45449 3.04173 7.79868C3.01421 7.86174 3 7.9298 3 7.99861C3 8.06741 3.01421 8.13548 3.04173 8.19854C4.05138 10.5427 5.95071 11.9972 8 11.9972C10.0493 11.9972 11.9486 10.5427 12.9583 8.19854C12.9858 8.13548 13 8.06741 13 7.99861C13 7.9298 12.9858 7.86174 12.9583 7.79868ZM8 10.9976C6.41555 10.9976 4.91607 9.85296 4.05138 7.99861C4.91607 6.14425 6.41555 4.99965 8 4.99965C9.58445 4.99965 11.0839 6.14425 11.9486 7.99861C11.0839 9.85296 9.58445 10.9976 8 10.9976ZM8 5.9993C7.60458 5.9993 7.21803 6.11656 6.88925 6.33625C6.56046 6.55593 6.30421 6.86818 6.15288 7.23351C6.00156 7.59883 5.96197 8.00082 6.03911 8.38865C6.11626 8.77648 6.30667 9.13272 6.58628 9.41233C6.86589 9.69194 7.22213 9.88235 7.60996 9.95949C7.99778 10.0366 8.39978 9.99705 8.7651 9.84572C9.13043 9.6944 9.44267 9.43814 9.66236 9.10936C9.88205 8.78058 9.9993 8.39403 9.9993 7.99861C9.9993 7.46836 9.78866 6.95983 9.41372 6.58489C9.03878 6.20994 8.53025 5.9993 8 5.9993ZM8 8.99826C7.80229 8.99826 7.60902 8.93963 7.44462 8.82979C7.28023 8.71994 7.1521 8.56382 7.07644 8.38116C7.00078 8.19849 6.98098 7.9975 7.01956 7.80358C7.05813 7.60967 7.15334 7.43155 7.29314 7.29175C7.43294 7.15194 7.61106 7.05673 7.80498 7.01816C7.99889 6.97959 8.19989 6.99939 8.38255 7.07505C8.56521 7.15071 8.72134 7.27884 8.83118 7.44323C8.94102 7.60762 8.99965 7.80089 8.99965 7.99861C8.99965 8.26373 8.89433 8.518 8.70686 8.70547C8.51939 8.89294 8.26512 8.99826 8 8.99826Z" fill="#1E63B8"></path>
                                      </svg>
                                    </span>
                                  </button>
                              </div>
                            </div>` : ""}
                            
                            ${data.hideDetails ? `
                            <div class="col-sm-3 text-center text-sm-end">
                          <button class="showhide-btn collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target=".multi-collapse2" aria-expanded="false"
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
                        </div>` : ""}
                          </div>
                          



                          ${
                              data.showContent ? `
                              <div class="card-inner-content">
                                  <div class="card mb-2">
                                      <div class="card-body">
                                      <h4>${data.tagName}</h4>
                                      <p>${data.content}</p>
                                  </div>
                              </div>
                              ` : "" 
                          }

                          ${
                              data.title === 'Canonical URL' ? `
                              <div class="card-inner-content">
                                  <div class="card mb-2">
                                      <div class="card-body">
                                          <div class="card-actual-url">
                                              <p>
                                              <span>Actual URL</span>
                                              ${projectUrl}
                                              </p>
                                              <p>
                                              <span>Canonical URL</span>
                                              ${data.content}
                                              </p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              ` : "" 
                          }
                          ${
                            data.title === 'CSS Caching' ? `
                            ${data.cssData.length > 0 ? 
                              `<div class="card-inner-content">
                                <div class="card mb-2">
                                    <div class="card-body">
                                    ${data.content}
                                    <div class="card-actual-url">
                                          <table>
                                              <tr>
                                                  <th>CSS URL</th>
                                                  <th>CSS cache time (minutes)</th>
                                              </tr>
                                              ${data.cssData.map(item => `
                                                  <tr>
                                                      <td>${item.url}</td>
                                                      <td>${item.cacheExpiryTime}</td>
                                                  </tr>
                                              `).join('')}
                                          </table>
                                      </div> 
                                      
                                    </div>
                                </div>
                            </div>`
                            : ''}` : "" 
                        }
                        
                        ${schemaBlocksHtml ? schemaBlocksHtml : ''}

                        ${
                          data.title === 'Broken Links' ? `
                            <div class="card-inner-content ${brokenLinksCount > 0 ? '' : 'd-none'}">
                              <div class="card broken-links-card">
                                <div class="card-body">
                                  <div class="meta-list-single">
                                    ${!data.statusUI ? UI.getBrokenLinks(data.allLinks, true) : ""}
                                  </div>
                                </div>
                              </div>



                              <button class="meta-list-brokenHeader" data-bs-toggle="modal" data-bs-target="#broken-links-modal">
                                See the entire list of broken links
                              </button>



                              <div class="modal meta-list-brokenBody" aria-labelledby="exampleModalToggleLabel" tabindex="1" id="broken-links-modal" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-crossolm">
                                  <div class="modal-content modal-content-crossolm">
                                    <div class="modal-header modal-header-blm">
                                      <span class="modal-title">Broken Links</span>
                                      <span class="close modal-close close-crossolm" data-bs-dismiss="modal">×</span>
                                     </div>
                                    <div class="modal-body">
                                      <div class="card-body">
                                        <div class="meta-list-single">
                                          ${!data.statusUI ? UI.getBrokenLinks(data.allLinks, false) : ""}
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer-alert"></div>
                                  </div>
                                </div>
                              </div>


                            </div>
                            ` : "" 
                          }

                          ${
                            data.title === 'Robots.txt' ? `
                            
                            <div class="modal custom-modal" id="secondaryBots">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <span class="modal-title">User-agent List</span>
                                <span  class="close modal-close" data-bs-dismiss="modal">&times;</span>
                               </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                <div class="modal-table-div">
                                  <table>

                                  <>       
                                  
                                  ${data.secondaryBots.map((item, index) => `
                                        <tr>
                                          <td>${index + 1}</td>
                                          <td>
                                          <span>${item}</span>
                                          </td>
                                      </tr>tbody
                                      `).join('')}   
                                            </> 
                                  </table>
                                  </div>   
                                </div>
                                <!-- Modal Footer -->
                              </div>
                            </div>
                          </div>
                          ${data.urlBlock == true ? 
                            `
                            <div class="card-inner-content">
                           
                                <div class="card mb-2 robotsTxt-card">
                                
                                    <div class="card-body robotsTxt-scroll-wrapper">
                                    <div class="robotsTxt-scroll-content">
                                    
                                    ${data.content}
                                    </div>
                                    <div class="card-actual-url robotsTxt-card-actual-url">
                                    <table style="font-family: 'Courier Prime';">
                                    ${data.robotTextResponseData.map((item, index) => {
                                        if (item.trim() !== '') {
                                            return `
                                                <tr>
                                                    <td style="padding-right:0px; color:#8f8f8f;">${index + 1}</td> <!-- Auto-incrementing value -->
                                                    <td class="robotsTxt-card-td" style="color:#555555;">${item}</td>
                                                </tr>
                                            `;
                                        } else {
                                            return ''; // Empty string if item is blank
                                        }
                                    }).join('')}
                                </table>
                                      </div>
                                    </div>
                                </div>
                            </div>`
                            : ''}` : "" 
                        }

              

                         ${
                          data.title === 'JS Caching' ? `
                          ${data.jsData.length > 0 ? 
                            `<div class="card-inner-content">
                              <div class="card mb-2">
                              <div class="card-body">
                                  ${data.content}
                                  <div class="card-actual-url">
                                        <table>
                                            <tr>
                                                <th>JS URL</th>
                                                <th>JS cache time (minutes)</th>
                                            </tr>
                                            ${data.jsData.map(item => `
                                                <tr>
                                                    <td>${item.url}</td>
                                                    <td>${item.cacheExpiryTime}</td>
                                                </tr>
                                            `).join('')}
                                        </table>
                                    </div>
                                  </div>
                              </div>
                          </div>` 
                          : ''}
                          ` : "" 
                      }

                    ${
                      data.title === 'Protocol Relative Resource Links' ? `
                      ${data.protocolRelativeResourceData.length > 0 ? 
                        `<div class="card-inner-content">
                          <div class="card mb-2" style="background:none">
                              <div class="card-body">
                              ${data.content}
                              <div class="card-actual-url">
                           
                                <span data-bs-toggle="modal" data-bs-target="#protocolRelativeResourceModal" 
                                style="border-bottom: 1px solid #7f6e6e; cursor: pointer;">See the entire list of protocol relative resource links</span>
                                <div class="modal custom-modal" id="protocolRelativeResourceModal">
                                 <div class="modal-dialog">
                                   <div class="modal-content">
                                   <!-- Modal Header -->
                                     <div class="modal-header">
                                      <span class="modal-title">Protocol Relative Resource Links</span>
                                      <span  class="close modal-close" data-bs-dismiss="modal">&times;</span>
                                     </div>
                                  <!-- Modal Body -->
                                  <div class="modal-body">
                                  <span style="padding-bottom: 10px;" class="analysis-body-css">Below are the links found on this page which qualify as Protocol resource links.</span>
                                  <div class="modal-table-div">
                                  <table>
          
                            <tbody>          
                                  ${data.protocolRelativeResourceData.map((item, index) => `
                                        <tr>
                                          <td>${index + 1}</td>
                                          <td>
                                          <span><a href="${item}" target="_blank"></i></a></span><span><a href="${item}" target="_blank">${item}</a></span>
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
                              </div>
                          </div>
                      </div>` : ''}
                      ` : "" 
                  }
                      ${
                        data.title === 'Headings' ? `
                        
                      <div class="card-inner-content collapse multi-collapse2" id="multiCollapsePerformanceHeadings">
                        <table class="table-headings-collapse">
                          <thead>
                            <tr>
                              <th>Heading</th>
                              <th>Quantity</th>
                              <th>Content</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- H1 -->
                            <tr>
                              <td>H1</td>
                              ${data.headingArray['h1'].length > 0 ? `
                              <td>${data.headingArray['h1'].length}</td>
                              <td class="content-cell">

                                ${data.headingArray['h1'].length > 0 ? 
                                    `
                                    <span>${data.headingArray['h1'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${data.headingArray['h1'].length > 12 ? '' : 'd-none'}" data-id="h1" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>

                              ` : 
                              `
                              <td>0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H1 heading tags</div>
                              </td>`}
                            </tr>

                              ${data.headingArray['h1'].length > 0 ? 
                                  `
                                    ${data.headingArray['h1'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h1">
                                      <td></td>
                                      <td></td>
                                      <td class="content-cell">
                                      ${item}
                                      </td>
                                    </tr>
                                    `).join('')}` 
                                : ``
                              }





                            <!-- H2 -->
                            <tr>
                              <td>H2</td>
                              ${data.headingArray['h2'].length > 0 ? `
                              <td>${data.headingArray['h2'].length}</td>
                              <td class="content-cell">

                                ${data.headingArray['h2'].slice(1).length > 0 ? 
                                    `
                                    <span>${data.headingArray['h2'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${data.headingArray['h2'].length > 12 ? '' : 'd-none'}" data-id="h2" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>
                              ` : 
                              `
                              <td>0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H2 heading tags</div>
                              </td>`}
                            </tr>
                            
                            ${data.headingArray['h2'].length > 0 ? 
                                  `
                                    ${data.headingArray['h2'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h2">
                                      <td></td>
                                      <td></td>
                                      <td class="content-cell">
                                      ${item}
                                      </td>
                                    </tr>
                                    `).join('')}` 
                                : ``
                              }




                            <!-- H3 -->
                            <tr>
                              <td>H3</td>
                              ${data.headingArray['h3'].length > 0 ? `
                              <td>${data.headingArray['h3'].length}</td>
                              <td class="content-cell">

                                ${data.headingArray['h3'].length > 0 ? 
                                    `
                                    <span>${data.headingArray['h3'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${data.headingArray['h3'].length > 12 ? '' : 'd-none'}" data-id="h3" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>
                              ` : 
                              `
                              <td>0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H3 heading tags</div>
                              </td>`}
                            </tr>
                            
                            ${data.headingArray['h3'].length > 0 ? 
                                  `
                                    ${data.headingArray['h3'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h3">
                                      <td></td>
                                      <td></td>
                                      <td class="content-cell">
                                      ${item}
                                      </td>
                                    </tr>
                                    `).join('')}` 
                                : ``
                              }



                            <!-- H4 -->
                            <tr>
                              <td>H4</td>
                              ${data.headingArray['h4'].length > 0 ? `
                              <td>${data.headingArray['h4'].length}</td>
                              <td class="content-cell">

                                ${data.headingArray['h4'].length > 0 ? 
                                    `
                                    <span>${data.headingArray['h4'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${data.headingArray['h4'].length > 12 ? '' : 'd-none'}" data-id="h4" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>
                              ` : 
                              `
                              <td>0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H4 heading tags</div>
                              </td>`}
                            </tr>
                            
                            ${data.headingArray['h4'].length > 0 ? 
                                  `
                                    ${data.headingArray['h4'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h4">
                                      <td></td>
                                      <td></td>
                                      <td class="content-cell">
                                      ${item}
                                      </td>
                                    </tr>
                                    `).join('')}` 
                                : ``
                              }



                            <!-- H5 -->
                            <tr>
                              <td>H5</td>
                              ${data.headingArray['h5'].length > 0 ? `
                              <td>${data.headingArray['h5'].length}</td>
                              <td class="content-cell">

                                ${data.headingArray['h5'].length > 0 ? 
                                    `
                                    <span>${data.headingArray['h5'][0]}</span>
                                    `
                                  : ``
                                }
                                <button class="show collapsible showhide-btn ${data.headingArray['h5'].length > 12 ? '' : 'd-none'}" data-id="h5" type="button">
                                <span>Show</span>
                                  <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 4L4 1L1 4" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round"
                                      stroke-linejoin="round"></path>
                                  </svg>
                                </button>
                              </td>
                              ` : 
                              `
                              <td>0</td>
                              <td colspan="1" class="p-0">
                              <div class="no-tags">The page does not contain any H5 heading tags</div>
                              </td>`}
                            </tr>

                            ${data.headingArray['h5'].length > 0 ? 
                                  `
                                    ${data.headingArray['h5'].slice(1).map(item => `
                                    <tr class="content-row" data-val="h5">
                                      <td></td>
                                      <td></td>
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
                        `
                        
                        : "" 
                    }
                    
                    ${
                      data.title === 'Unsafe Cross Origin Links' ? `
                      ${data.crossOriginLinksData.length > 0 ? 
                        `<div class="card-inner-content">
                          <div class="card mb-2">
                              <div class="card-body card-body-crossolm">
                              ${data.content}
                              <div class="card-actual-url">
                              <span data-bs-toggle="modal" data-bs-target="#crossOriginLinksModal" 
                                style="border-bottom: 1px solid #7f6e6e; cursor: pointer;">Click here to see list of Cross Origin Links List</span>
                        
                      <div class="modal" id="crossOriginLinksModal">
                        <div class="modal-dialog modal-dialog-crossolm">
                            <div class="modal-content modal-content-crossolm">
                                <!-- Modal Header -->
                                <div class="modal-header modal-header-crossolm">
                                    <h4 class="modal-title modal-title-crossolm">Cross Origin Links</h4>
                                    <button type="button" class="close close-crossolm" data-bs-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body modal-table-div-crossolm">
                                <table>
                                    <tr>
                                    <th style="text-align: left;
                                        padding-right: 20px; padding-bottom: 10px; font-size: 14px !important;
                                        font-weight: 400 !important;
                                        line-height: 18px !important;
                                        color: rgba(110, 110, 110, 1) !important;
                                        font-family: Circular Std !important;">URL</th>
                                    </tr>         
                            ${data.crossOriginLinksData.map((item, index) => `
                                        <tr>
                                          <td>${index + 1}</td>
                                          <td>
                                          <span>${item}</span>
                                          </td>
                                      </tr>
                                      `).join('')}      
                                 </table>
                                 </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        </div>
                      </div>`: ''}
                      ` : "" 
                  }
                          
                          

                          ${data.problems ? 
                          `${data.problems.length > 0 && data.title != 'Images'? 
                              `<div class="card-inner-problems">
                                  <div class="card">
                                      <div class="card-body">
                                      <h4>Problems</h4>
                                      ${ul.outerHTML}
                                      </div>
                                  </div>
                              </div>` : ""}`
                              : ""}

                              ${data.title === "Canonical URL" ? `
                                  ${!data.status ? `
                                      <div class="row align-items-end justify-content-end card-sniper-group">
                                        <div class="snippet-btn intentional-btn" data-name="${data.title}">
                                          <button class="float-end">
                                            <span>Is this intentional</span>
                                            <span>
                                              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="16" height="16" rx="8" fill="white"></rect>
                                                <path d="M12.9583 7.79868C11.9486 5.45449 10.0493 4 8 4C5.95071 4 4.05138 5.45449 3.04173 7.79868C3.01421 7.86174 3 7.9298 3 7.99861C3 8.06741 3.01421 8.13548 3.04173 8.19854C4.05138 10.5427 5.95071 11.9972 8 11.9972C10.0493 11.9972 11.9486 10.5427 12.9583 8.19854C12.9858 8.13548 13 8.06741 13 7.99861C13 7.9298 12.9858 7.86174 12.9583 7.79868ZM8 10.9976C6.41555 10.9976 4.91607 9.85296 4.05138 7.99861C4.91607 6.14425 6.41555 4.99965 8 4.99965C9.58445 4.99965 11.0839 6.14425 11.9486 7.99861C11.0839 9.85296 9.58445 10.9976 8 10.9976ZM8 5.9993C7.60458 5.9993 7.21803 6.11656 6.88925 6.33625C6.56046 6.55593 6.30421 6.86818 6.15288 7.23351C6.00156 7.59883 5.96197 8.00082 6.03911 8.38865C6.11626 8.77648 6.30667 9.13272 6.58628 9.41233C6.86589 9.69194 7.22213 9.88235 7.60996 9.95949C7.99778 10.0366 8.39978 9.99705 8.7651 9.84572C9.13043 9.6944 9.44267 9.43814 9.66236 9.10936C9.88205 8.78058 9.9993 8.39403 9.9993 7.99861C9.9993 7.46836 9.78866 6.95983 9.41372 6.58489C9.03878 6.20994 8.53025 5.9993 8 5.9993ZM8 8.99826C7.80229 8.99826 7.60902 8.93963 7.44462 8.82979C7.28023 8.71994 7.1521 8.56382 7.07644 8.38116C7.00078 8.19849 6.98098 7.9975 7.01956 7.80358C7.05813 7.60967 7.15334 7.43155 7.29314 7.29175C7.43294 7.15194 7.61106 7.05673 7.80498 7.01816C7.99889 6.97959 8.19989 6.99939 8.38255 7.07505C8.56521 7.15071 8.72134 7.27884 8.83118 7.44323C8.94102 7.60762 8.99965 7.80089 8.99965 7.99861C8.99965 8.26373 8.89433 8.518 8.70686 8.70547C8.51939 8.89294 8.26512 8.99826 8 8.99826Z" fill="#1E63B8"></path>
                                              </svg>
                                            </span>
                                          </button>
                                        </div>
                                      </div>
                                  ` : ""}

                              ` : ""}

                          ${
                              data.tagStatus ? `
                              <div class="card-content-bottom">
                              <div class="card-single-content ${data.lengthClass}">
                                <p>
                                  Length-
                                  <span class="badge badge_pdf">${data.content ? data.content.length : 0} characters</span>
                                </p>
                              </div>

                              ${data.casingStatus ? `
                              <div class="card-single-content ${data.casingClass}">
                                <p>
                                  Casing-
                                  <span class="badge casing_pdf">${data.casing}</span>
                                </p>
                              </div>` 
                              
                              : ``}
                              
                              </div>` : ""
                          }
                          </div>
                        </div>

                        ${data.showSnippet ? `
                              <div class="col-md-6 snippet-element">
                                <div class="card-inner-content">
                                  <div class="card">
                                    <div class="card-body">
                                      <div class="card-hide-content">
                                        <p class="card-hide-content-text">${data.snippetContent}</p>
                                        <div class="card-show-icon">
                                          <button class="btn rounded-pill hide-snippet">
                                            <span><svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.47067 1.29174C4.64601 1.26486 4.82315 1.25149 5.00054 1.25175C6.59016 1.25175 8.0848 2.39647 8.95459 4.25103C8.82157 4.53325 8.67132 4.80704 8.5047 5.07083C8.4518 5.15271 8.424 5.24828 8.42472 5.34576C8.42583 5.45485 8.46261 5.56059 8.52943 5.64683C8.59625 5.73307 8.68945 5.79508 8.7948 5.8234C8.90016 5.85172 9.01189 5.8448 9.11295 5.80369C9.214 5.76258 9.29883 5.68953 9.3545 5.5957C9.5874 5.22975 9.78971 4.84521 9.95935 4.44598C9.98617 4.3836 10 4.31642 10 4.24853C10 4.18063 9.98617 4.11345 9.95935 4.05107C8.94959 1.70664 7.05005 0.251985 5.00054 0.251985C4.76593 0.250803 4.5317 0.27088 4.30071 0.311971C4.23506 0.323131 4.17226 0.347111 4.11588 0.382542C4.0595 0.417974 4.01066 0.464163 3.97213 0.518472C3.9336 0.572781 3.90615 0.634147 3.89134 0.699066C3.87653 0.763985 3.87465 0.831185 3.88581 0.89683C3.89697 0.962476 3.92095 1.02528 3.95638 1.08166C3.99181 1.13804 4.038 1.18688 4.09231 1.22541C4.14662 1.26394 4.20799 1.29139 4.2729 1.3062C4.33782 1.32101 4.40502 1.32289 4.47067 1.31173V1.29174ZM1.60636 0.14701C1.55975 0.100402 1.50442 0.0634309 1.44352 0.0382068C1.38262 0.0129827 1.31736 0 1.25144 0C1.18553 0 1.12026 0.0129827 1.05936 0.0382068C0.998467 0.0634309 0.943135 0.100402 0.896527 0.14701C0.802398 0.24114 0.749517 0.368806 0.749517 0.501925C0.749517 0.635044 0.802398 0.762711 0.896527 0.85684L1.69633 1.65165C0.989291 2.33225 0.426568 3.14828 0.0417324 4.05107C0.0142073 4.11414 0 4.18221 0 4.25103C0 4.31984 0.0142073 4.38791 0.0417324 4.45098C1.05149 6.79541 2.95103 8.25006 5.00054 8.25006C5.89888 8.24386 6.776 7.97638 7.52493 7.48025L8.39473 8.35504C8.4412 8.40189 8.49648 8.43908 8.5574 8.46446C8.61831 8.48984 8.68365 8.5029 8.74964 8.5029C8.81563 8.5029 8.88097 8.48984 8.94188 8.46446C9.0028 8.43908 9.05809 8.40189 9.10456 8.35504C9.15141 8.30857 9.1886 8.25328 9.21398 8.19237C9.23935 8.13145 9.25242 8.06611 9.25242 8.00012C9.25242 7.93413 9.23935 7.8688 9.21398 7.80788C9.1886 7.74697 9.15141 7.69168 9.10456 7.64521L1.60636 0.14701ZM4.03577 3.99109L5.26048 5.21579C5.17599 5.24002 5.08843 5.25181 5.00054 5.25078C4.73539 5.25078 4.4811 5.14545 4.2936 4.95796C4.10611 4.77047 4.00078 4.51618 4.00078 4.25103C3.99976 4.16314 4.01155 4.07557 4.03577 3.99109ZM5.00054 7.2503C3.41092 7.2503 1.91628 6.10558 1.05149 4.25103C1.37446 3.53807 1.83284 2.89464 2.40117 2.35648L3.28595 3.25127C3.07813 3.63057 2.99889 4.06704 3.06014 4.49519C3.12138 4.92335 3.3198 5.3201 3.62564 5.62593C3.93147 5.93176 4.32822 6.13019 4.75637 6.19143C5.18453 6.25267 5.62099 6.17344 6.0003 5.96561L6.79511 6.75042C6.25079 7.07079 5.6321 7.24312 5.00054 7.2503Z" fill="#6E6E6E"></path>
                                              </svg>
                                            </span>
                                            Hide
                                          </button>
                                        </div>
                                      </div>
                                      <div class="google-card-container">
                                        <div class="card-text-link-container">
                                          <div class="card-text-link-image">
                                            <span class="icon">
                                               <img id="activeFavicon" src="${testedUrlFavicon}" alt="icon">
                                            </span>
                                          </div>
                                          <div class="card-text-link">
                                          <span class="web-title">Setmore</span>
                                          <a class="card-text-link" href="${projectUrl}" target="_blank">${projectUrl.length > 80 ? projectUrl.substring(0, 80) + ' ...' : projectUrl}</a>
                                          </div>
                                        </div>
                                        <div class="card-single-text">
                                          <p class="snippet-title"></p>
                                          <p class="snippet-description"></p>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        ` : ""}

                        ${
                          data.title === 'Images' ? `
                          <div class="download_result">
                          
                            <ul class="datatable_download_result">
                                <li>Download:</li>
                                <li class='download-csv-bulk website-tracker-csv' data-csv=><button><img src="/new-assets/assets/images/xl.png" alt="icon" title="Download CSV"></button></li>
                                <li class='email-modal-btn'><button><img src="/new-assets/assets/images/email.png" alt="icon" title="Email this"></button></li>
                                <li class='download-xlsx-bulk' data-csv=><button><img src="/new-assets/assets/images/htdocs.png" alt="icon" title="Download XLSX"></button></li>
            
                                <li class='search-li-images datatable_download_result_li'>
                                  <input type="text" class="form-control" id="custom-search" placeholder="Search">
                                </li>
                            </ul>
                               
                          </div>
                          <div class="image-data-table">
                              <div class="row">
                                  <div class="col-lg-12">
                                  <div class="analysis-table-image">
                                      <div class="table-responsive">
                                      <table class="table table-bordered dataTable custom-dataTable">
                                      <thead class="result_data_header">
                                      <tr style="white-space: nowrap;">
                                          <th class="transparent">Image Link</th>
                                          <th class="transparent" colspan="2" class="">Alternate Text</th> 
                                          <th class="transparent" colspan="6">File Name</th>
                                          <th class="transparent" colspan="1">Result</th>
                                      </tr>
                                      <tr>
                                          <th></th>
                                          <th class="align-left">Content</th>
                                          <th class="">Words separated by spaces?</th>
                                          <th class="align-left">File name</th>
                                          <th class="">LEN</th>
                                          <th class="">Words separated by hyphens?</th>
                                          <th class="">Uppercase characters?</th>
                                          <th class="">Special characters?</th>
                                          <th class="">File Size</th>
                                          <th class=""></th>
                                      </tr>
                                      </thead>
                                          <tbody id="tbodyImages">
                                      
                                          </tbody>
                                      </table>
                                      </div>
                                  </div>
                                  </div>
                              </div>
                          </div>
                          
                          <div class="card-body">
                              
                              </div>

                          ` : "" 
                      }

                      </div>
                    </div>
                  </div>`;

                  let parentID
                  switch(data.parentCard){
                      case "images":
                          parentID = "cardImages"
                          break;
                      case "codingBestPractices":
                          parentID = "cardCBP"
                          break;
                      case "security":
                        parentID = "cardSecurity"
                        break;
                      case "performance":
                          parentID = "cardPerformance"
                          break;
                      default:
                          parentID = "cardMetaTitle"
                          break;
                  }
          
                
                if(intentionalState){
                  if(activeUpdateStatusElement.nextElementSibling){
                    activeUpdateStatusElement.nextElementSibling.before(div)
                  }else{
                    activeUpdateStatusElement.before(div)
                  }
                }else{
                  document.getElementById(parentID).appendChild(div)
                }
                // Fetch favicon via AJAX if snippet preview exists
                if(data.showSnippet && projectUrl){
                  const faviconImg = div.querySelector('#activeFavicon');
                  if(faviconImg){
                    $.ajax({
                      url: '/test/get-favicon-url',
                      type: 'POST',
                      data: {
                        url: projectUrl,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                      },
                      success: function(response){
                        if(response.favicon && response.favicon !== ''){
                          faviconImg.src = response.favicon;
                        }

                       const webTitle = getFormattedName(projectUrl)
                       $('.web-title').text(webTitle)
                      },
                      error: function(){
                        // Keep default favicon on error
                      }
                    });
                  }
                }
  }


  
  function getFormattedName(url) {
    // Remove 'https://', 'http://', 'www.', and trailing slashes
    let domain = url.replace(/https?:\/\/(www\.)?/, '').replace(/\/.*/, '');
    
    // Split the domain by dots
    let parts = domain.split('.');
    
    let name;
    if (parts.length >= 3) {
        // If 3 or more dots are present, take the third-to-last part
        name = parts[parts.length - 3];
    } else {
        // Otherwise, take the second-to-last part
        name = parts[parts.length - 2];
    }
    
    // Capitalize the first letter and insert into input field
    let formattedName = name.charAt(0).toUpperCase() + name.slice(1);
    $('.onbording_project_name').val(formattedName);
    return formattedName;
  }

      
  function runTestAndCache(testKey){
    $.ajax({
      url : `/test/get-analysis`,
      type : 'POST',
      data: {
          "ref_id": ref_id,
          "_method": 'POST',
          "_token": $('meta[name="csrf-token"]').attr('content'),
      },       
      success : function(result) {
          if(result.status === 1){
            let data = result.data
            projectUrl = data.url

            const testLabels = JSON.parse(data.testLabels)
            buildLoader(obj, testLabels)

            setTimeout(function (){
              const results = JSON.parse(data.data)
              Controls.updatePageTitleDesc(results)


              Controls.testRequest(results, testLabels, testKey)
            }, 1000);
          }
      },
      error: function(data){
          if(!checkIfAuthenticated(data.responseJSON)){
              window.location = "/login"
          }
          removeLoader()
          displayAlert({
              status: 0,
              msg: data.responseJSON.message
          })
      }
    }); 
  }


  function endTest(testLabels){
    
    buildNavTabs(testLabels)
    buildAnalysisArea(testLabels)
    updateCircularProgress()
    updateSliders()
    disableSliderRange()
    UI.updateEmailModal()
    UI.toggleTiles(extendedTiles)
    buildDatatable()

    // updating snippet element title and description
    UI.updateSnippetElement(pageTitle, pageDesc)

    document.querySelector(".control-hide-show").style.display = "flex"
    document.querySelector(".meta-tag-items").style.display = "block"

    Controls.collapseCard()
    $('.single-view .results-container .analysis-card:last-child > .card').css({
      'border-bottom-right-radius': '0 !important',
      'border-bottom-left-radius': '0 !important'
    });
    
    // Close all content sections when all tests are finished
    const contentSections = ["seo-content", "performance-content", "best-practices-content", "security-content"]
    contentSections.forEach(contentId => {
      const content = document.getElementById(contentId)
      if(content){
        content.style.display = "none"
        // Reset user-closed flag for fresh test run
        content.removeAttribute("data-user-closed")
      }
    })


    // firstTest = false

    updateEvents()
    $('#metaTagsUl').removeClass("show")
    // update health score
    const healthScore = getReportProgress(dataPassed.length, resultsData.length, false)
    UI.setNeedleByValue(healthScore)
    removeLoader()
}


  function disableSliderRange(){
    $(".slider-input").parent().css({display: "none"})
  }


  function buildNavTabs(testLabels){
      const div = document.createElement("div")
      div.classList.add("nav")
      div.classList.add("nav-tabs")
      let metaElement = resultsDataMeta.length > 0 ? getNavTabElement("cardMetaTitle", "Meta Tags", dataPassedMeta.length, resultsDataMeta.length) : ""
      div.innerHTML += metaElement

      let imagesElement = imageTestStatus ? getNavTabElement("cardImages", "Images", dataPassedImages.length, resultsDataImages.length) : ""
      div.innerHTML += imagesElement

      let performanceElement = resultsDataPerformance.length > 0 ? getNavTabElement("cardPerformance", "Performance", dataPassedPerformance.length, resultsDataPerformance.length) : ""
      div.innerHTML += performanceElement

      let CBPElement = resultsDataBestPractices.length > 0 ? getNavTabElement("cardCBP", "Coding Best Practices", dataPassedCBP.length, resultsDataBestPractices.length) : ""
      div.innerHTML += CBPElement

      let securityElement = resultsDataSecurity.length > 0 ? getNavTabElement("cardSecurity", "Security", dataPassedSecurity.length, resultsDataSecurity.length) : ""
      div.innerHTML += securityElement
      
      document.querySelector(".meta-tag-items nav").appendChild(div)
  }

  function getNavTabElement(title, nameVal, passed, total){
    let status = false
    status = title === "cardMetaTitle" && resultsDataMeta.length > 0 ? true : false
    status = title === "cardImages" && resultsDataMeta.length === 0 && imageTestStatus ? true : status
    status = title === "cardPerformance" && resultsDataMeta.length === 0 && !imageTestStatus && resultsDataPerformance.length > 0 ? true : status
    status = title === "cardCBP" && resultsDataMeta.length === 0 && !imageTestStatus && resultsDataPerformance.length === 0 && resultsDataBestPractices.length > 0 ? true : status
    status = title === "cardSecurity" && resultsDataMeta.length === 0 && !imageTestStatus && resultsDataPerformance.length === 0 && resultsDataBestPractices.length === 0 && resultsDataSecurity.length > 0 ? true : status


    status ? document.getElementById(title).classList.add("show") : ""
    status ? document.getElementById(title).classList.add("active") : ""

    const div = `
      <div class="nav-link nav-link-home-tab ${status ? "active" : ""}" id="nav-home-tab" data-bs-toggle="tab" data-nav-val="${title}" data-bs-target="#${title}" type="button" role="tab" aria-controls="#${title}" aria-selected="true">
          <div class="analysis-tab-btn">
              <div class="tab-btn-content">
              <p>${passed}/${total}</p>
              <span>${nameVal}</span>
              </div>
              <div class="tab-btn-icon tab-first-item">
              <span>
                  <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 19.7709C1 19.6018 1 19.4265 1 19.2574C1.01253 19.2198 1.03132 19.1885 1.03758 19.1509C1.119 18.5183 1.41336 18.0048 1.8643 17.5663C2.17745 17.2595 2.47808 16.94 2.79749 16.6394C2.92276 16.5204 2.9666 16.4014 2.9666 16.2323C2.96033 12.8565 2.96033 9.48075 2.96033 6.11123C2.96033 5.52251 3.21712 5.27199 3.79958 5.27199C4.97077 5.27199 6.14196 5.26572 7.31315 5.27825C7.49478 5.27825 7.58246 5.21562 7.67015 5.05904C9.07307 2.54756 11.2213 1.11332 14.096 1.00685C17.2777 0.887851 19.6576 2.32209 21.2171 5.10288C21.286 5.22814 21.3612 5.27825 21.5052 5.27825C22.3695 5.27199 23.2401 5.27199 24.1044 5.27825C24.7495 5.27825 24.9937 5.52251 24.9937 6.17386C24.9937 11.1279 24.9937 16.082 24.9937 21.0298C24.9937 21.6749 24.7432 21.9254 24.1044 21.9254C22.0501 21.9254 19.9958 21.9254 17.9415 21.9254C17.8413 21.9254 17.7474 21.9254 17.6409 21.9254C17.6409 22.4954 17.6409 23.034 17.6409 23.5851C17.7286 23.5851 17.81 23.5851 17.8852 23.5851C18.4175 23.5851 18.9499 23.5851 19.476 23.5851C19.7641 23.5851 19.9896 23.7167 20.1148 23.9797C20.2401 24.2302 20.2213 24.4933 20.0397 24.7062C19.9395 24.8252 19.7829 24.9004 19.6514 24.9881C15.8685 24.9881 12.0856 24.9881 8.30271 24.9881C8.25261 24.9567 8.2025 24.9254 8.1524 24.8941C7.87683 24.7313 7.73904 24.4244 7.8142 24.1363C7.88935 23.8231 8.13987 23.6039 8.45929 23.5851C8.56576 23.5789 8.6785 23.5789 8.78497 23.5789C9.3048 23.5789 9.82463 23.5789 10.3445 23.5789C10.3445 23.0089 10.3445 22.4703 10.3445 21.9192C10.2255 21.9192 10.1253 21.9192 10.0188 21.9192C8.30898 21.9192 6.59916 21.9192 4.88309 21.9254C4.68894 21.9254 4.49478 21.9505 4.30689 22.0068C2.92902 22.3952 1.48852 21.606 1.09395 20.2344C1.06889 20.0716 1.03758 19.9213 1 19.7709ZM20.6785 8.62272C20.6848 5.1843 17.904 2.38472 14.4656 2.37219C11.0021 2.36593 8.2025 5.14672 8.19624 8.61645C8.19624 12.0549 10.977 14.8419 14.4217 14.8544C17.8727 14.8607 20.6722 12.0799 20.6785 8.62272ZM23.5845 17.6352C23.5845 13.9714 23.5845 10.3325 23.5845 6.68117C23.0021 6.68117 22.4321 6.68117 21.8747 6.68117C22.5136 10.1321 21.5992 13.0319 18.6305 14.9734C15.5804 16.9714 12.499 16.6394 9.5428 14.5476C9.33612 14.7542 9.12317 14.9797 8.8977 15.1989C8.79749 15.2929 8.7787 15.368 8.84134 15.4995C9.06054 15.9505 9.14822 16.4327 9.0668 16.9338C9.02923 17.1718 8.9666 17.4035 8.91649 17.6415C13.8079 17.6352 18.6868 17.6352 23.5845 17.6352ZM23.5845 19.057C23.4656 19.057 23.3653 19.057 23.2714 19.057C18.405 19.057 13.5386 19.0695 8.67223 19.0382C7.99582 19.0319 7.47599 19.1634 7.05637 19.7146C6.84969 19.9901 6.56785 20.2094 6.27975 20.4912C12.0919 20.4912 17.8351 20.4912 23.5908 20.4912C23.5845 20.0152 23.5845 19.558 23.5845 19.057ZM4.38205 6.67491C4.38205 9.4557 4.38205 12.224 4.38205 15.0549C4.83298 14.5476 5.32777 14.1968 5.94781 14.059C6.58664 13.9213 7.18789 14.0215 7.73278 14.3096C8.00835 14.0403 8.27766 13.7772 8.54697 13.5079C6.94989 11.4912 6.45511 9.20518 7.02505 6.67491C6.12944 6.67491 5.25887 6.67491 4.38205 6.67491ZM3.53653 20.6853C3.92484 20.6853 4.20042 20.5851 4.41962 20.3659C5.40292 19.3889 6.39248 18.4056 7.36952 17.416C7.6263 17.1593 7.73278 16.8336 7.68893 16.4703C7.6263 15.9881 7.36326 15.6436 6.90605 15.4808C6.44885 15.3179 6.02296 15.4181 5.67223 15.7563C5.22756 16.1822 4.79541 16.6269 4.36326 17.0653C3.8309 17.5977 3.29854 18.1238 2.77244 18.6561C2.40919 19.0256 2.31524 19.5267 2.52192 19.9776C2.7286 20.4348 3.10438 20.6666 3.53653 20.6853ZM11.7975 23.5538C13.2756 23.5538 14.7411 23.5538 16.2129 23.5538C16.2129 23.0027 16.2129 22.4703 16.2129 21.9192C14.7349 21.9192 13.2756 21.9192 11.7975 21.9192C11.7975 22.4641 11.7975 23.0027 11.7975 23.5538Z" fill="white" stroke="white" stroke-width="0.5"></path>
                  <path d="M14.4416 11.2553C14.7923 10.9484 15.1368 10.6541 15.4813 10.3597C15.7882 10.0966 16.1201 10.0966 16.3581 10.3534C16.5961 10.6165 16.5585 10.9672 16.2516 11.2365C15.7882 11.6436 15.3247 12.0507 14.855 12.4516C14.5857 12.6833 14.3038 12.6833 14.0282 12.4453C13.5523 12.0382 13.0825 11.6311 12.6128 11.2177C12.331 10.9735 12.2996 10.6165 12.5189 10.366C12.7381 10.1092 13.0825 10.0904 13.3769 10.3346C13.7276 10.6353 14.0784 10.9422 14.4416 11.2553Z" fill="white" stroke="white" stroke-width="0.5"></path>
                  <path d="M14.4407 6.12167C14.1338 6.38472 13.8332 6.64777 13.5326 6.90455C13.4574 6.97345 13.3823 7.04234 13.3008 7.09871C13.0378 7.28034 12.7184 7.24276 12.518 7.01102C12.3238 6.77929 12.3175 6.43482 12.543 6.22814C13.0503 5.76468 13.5702 5.32 14.0962 4.87533C14.2967 4.70622 14.5848 4.71249 14.7914 4.88159C15.3113 5.32 15.8248 5.76468 16.3322 6.21562C16.5702 6.43482 16.5639 6.78556 16.3572 7.01729C16.1443 7.24902 15.8123 7.2866 15.5555 7.07366C15.1798 6.77303 14.8165 6.44735 14.4407 6.12167Z" fill="white" stroke="white" stroke-width="0.5"></path>
                  </svg>
              </span>
              </div>
          </div>
      </div>
      `
      return div
  }

  function updateEvents(){
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

    $(document).on("click", ".hidePassedBtn", function () {
      $(this).toggleClass("active");
      $(".card__failed").show();
      if ($(this).hasClass("active")) {
        $(".card__pass").hide();
      } else {
        $(".card__pass").show();
      }
    });

      $(".fix-btn").on( "click", function(e) {
        const val = e.target.parentElement.getAttribute("data-test-name")
        const data = getModalFixContent(val)
        $("#modalFixLabel").html(data.headerTitle)
        $(".modal-video-content").html(data.contentHTML)
        if(data.video_url != ""){
          $(".modal-video iframe").attr("src", data.video_url)
          $(".modal-video").css({display: "block"})
        }else{
          $(".modal-video").css({display: "none"})
        }
        modalFix.toggle()
      })

      $(".intentional-btn").on( "click", function(e) {
        const target = e.target.closest(".intentional-btn")
        activeUpdateStatusElement = target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement
        activeUpdateData = getElementData(activeUpdateStatusElement.getAttribute("data-name"))
        if(name === "Robots Meta"){
            $("#updateStatusModalText").html(`So you are saying Noindex,Nofollow meta tag is supposed to exist ?`)
        }else{
            $("#updateStatusModalURLOriginal").html(projectUrl)
            $("#updateStatusModalURLCanonical").html(activeUpdateData.content)
        }

        updateStatusModal.toggle()
    })

    $(".hide-snippet").on( "click", function(e) {
      const target = e.target.closest(".hide-snippet").parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement
      target.querySelector(".snippet-element").style.display = "none"
      target.querySelector(".show-snip-btn").style.display = "block"
      target.querySelector(".content-element").classList.remove("col-md-6")
      target.querySelector(".content-element").classList.add("col-md-12")

    })

    $(".show-snip-btn").on( "click", function(e) {
      const target = e.target.closest(".show-snip-btn").parentElement.parentElement.parentElement.parentElement.parentElement
      target.querySelector(".snippet-element").style.display = "block"
      target.querySelector(".show-snip-btn").style.display = "none"
      target.querySelector(".content-element").classList.add("col-md-6")
      target.querySelector(".content-element").classList.remove("col-md-12")
    })
    


    // download csv file
    $(".download-csv-btn").on( "click", function(e) {
        const table = Controls.buildCSVTable(data, false)
        const exporter = new TableCSVExporter(table, CSV_FILE_NAME);
        exporter.downloadCSV();
    })

    // download csv file
    $(".email-modal-btn").on( "click", function(e) {
      Controls.displayEmailModal(e)
    })


    // change project tiles
    $(".project-tiles-btn").on( "click", function(e) {
      Controls.toggleTiles()
    })  

    $("#downloadCSVBrokenLinks").on( "click", function(e) {
      Controls.buildBrokenLinksCSV(data, false)
    })  

    $(".download-csv-bulk").on( "click", function(e) {
      let csvName = 'images.csv';
      Controls.buildCSV(csvName)
    })


  }

  function updateUIProgress(){
    const total = resultsData.length

    const metaNavTab = document.querySelector("div[data-nav-val=cardMetaTitle]")
    metaNavTab.querySelector(".tab-btn-content p").innerHTML = `${dataPassedMeta.length}/${resultsDataMeta.length}`
    document.querySelectorAll(".progress-red svg").forEach(el=>{
      el.setAttribute("data-value", getReportProgress(dataFailed.length, total, false))
    })

    document.querySelectorAll(".progress-green svg").forEach(el=>{
      el.setAttribute("data-value", getReportProgress(dataPassed.length, total, false))
    })
    updateCircularProgress()
  }


  function getElementData(name){
      for(var i = 0;i < resultsData.length;i++){
          const el = resultsData[i]
          if(el.label.name === name){
              return el
          }
      }
  }



  function removeReportCard(){
      document.querySelector(".report-information").remove()
  }


  function buildAnalysisArea(testLabels){
    const total = testLabels.length

    const div = document.createElement("div")
    div.classList.add("analysis-area")
    div.innerHTML =  `
    <div class="analysis-area">
          <div class="row gy-4 gy-lg-0">
            <div class="col-md-8 order-1 order-md-0">
              <div class="analysis-link-progress">
                <div class="card">


                  <div class="control-hide-show" id="chs-analysisProgress">
                    <div class="control-hide ${dataFailed.length == 0 ? "d-none": ""}"  >
                      <button class="btn_toggle_show rounded-pill hidePassedBtn">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path
                              d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z" />
                          </svg></span>
                        Hide Items Passed
                      </button>
                    </div>
                    
                    <div class="control-dash-icon project-tiles-btn" id="tilesExtended">
                          <button class="btn">
                            <svg width="25" height="18" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6 11.3393C12.6 11.7067 12.2547 12 11.8687 12H9.76867C9.68097 12.0021 9.59375 11.9864 9.51222 11.9541C9.43068 11.9217 9.3565 11.8733 9.2941 11.8116C9.2317 11.7499 9.18235 11.6763 9.14901 11.5952C9.11566 11.5141 9.09899 11.4271 9.1 11.3393V9.33933C9.09866 9.25097 9.11502 9.16322 9.1481 9.08127C9.18118 8.99932 9.23031 8.92481 9.29262 8.86213C9.35493 8.79945 9.42914 8.74987 9.51089 8.7163C9.59265 8.68273 9.68029 8.66586 9.76867 8.66667H11.8687C12.2553 8.66667 12.6 8.972 12.6 9.33933V11.3393ZM11.8687 7.33333H9.76867C8.60867 7.33333 7.7 8.23467 7.7 9.33933V11.3393C7.7 12.444 8.60867 13.3333 9.76867 13.3333H11.8687C13.0287 13.3333 14 12.444 14 11.3393V9.33933C14 8.23467 13.0287 7.33333 11.8687 7.33333ZM4.9 11.3393C4.9 11.7067 4.55467 12 4.16867 12H2.06867C1.98097 12.0021 1.89375 11.9864 1.81222 11.9541C1.73068 11.9217 1.6565 11.8733 1.5941 11.8116C1.5317 11.7499 1.48235 11.6763 1.44901 11.5952C1.41566 11.5141 1.39899 11.4271 1.4 11.3393V9.33933C1.39866 9.25097 1.41502 9.16322 1.44809 9.08127C1.48117 8.99932 1.53031 8.92481 1.59262 8.86213C1.65493 8.79945 1.72914 8.74987 1.81089 8.7163C1.89265 8.68273 1.98029 8.66586 2.06867 8.66667H4.16867C4.55533 8.66667 4.9 8.972 4.9 9.33933V11.3393ZM4.16867 7.33333H2.06867C0.908667 7.33333 0 8.23467 0 9.33933V11.3393C0 12.444 0.908667 13.3333 2.06867 13.3333H4.16867C5.32867 13.3333 6.3 12.444 6.3 11.3393V9.33933C6.3 8.23467 5.32867 7.33333 4.16867 7.33333ZM12.6 4.006C12.6 4.37333 12.2547 4.66667 11.8687 4.66667H9.76867C9.68097 4.66873 9.59375 4.65311 9.51222 4.62074C9.43068 4.58838 9.3565 4.53992 9.2941 4.47826C9.2317 4.41661 9.18235 4.34302 9.14901 4.26188C9.11566 4.18074 9.09899 4.09372 9.1 4.006V2.006C9.09866 1.91763 9.11502 1.82989 9.1481 1.74794C9.18118 1.66598 9.23031 1.59147 9.29262 1.5288C9.35493 1.46612 9.42914 1.41653 9.51089 1.38297C9.59265 1.3494 9.68029 1.33252 9.76867 1.33333H11.8687C12.2553 1.33333 12.6 1.63867 12.6 2.006V4.006ZM11.8687 0H9.76867C8.60867 0 7.7 0.901333 7.7 2.006V4.006C7.7 5.11067 8.60867 6 9.76867 6H11.8687C13.0287 6 14 5.11067 14 4.006V2.006C14 0.901333 13.0287 0 11.8687 0ZM4.9 4.006C4.9 4.37333 4.55467 4.66667 4.16867 4.66667H2.06867C1.98097 4.66873 1.89375 4.65311 1.81222 4.62074C1.73068 4.58838 1.6565 4.53992 1.5941 4.47826C1.5317 4.41661 1.48235 4.34302 1.44901 4.26188C1.41566 4.18074 1.39899 4.09372 1.4 4.006V2.006C1.39866 1.91763 1.41502 1.82989 1.44809 1.74794C1.48117 1.66598 1.53031 1.59147 1.59262 1.5288C1.65493 1.46612 1.72914 1.41653 1.81089 1.38297C1.89265 1.3494 1.98029 1.33252 2.06867 1.33333H4.16867C4.55533 1.33333 4.9 1.63867 4.9 2.006V4.006ZM4.16867 0H2.06867C0.908667 0 0 0.901333 0 2.006V4.006C0 5.11067 0.908667 6 2.06867 6H4.16867C5.32867 6 6.3 5.11067 6.3 4.006V2.006C6.3 0.901333 5.32867 0 4.16867 0Z" fill="#D5D5DD"></path>
                            </svg>
                          </button>
                    </div>

                    <div class="control-bars-icon project-tiles-btn" id="tilesSingle">
                          <button class="btn">
                            <svg width="20" height="15" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M13.0243 0H0.975719C0.437606 0 0 0.437606 0 0.975719C0 1.51383 0.437606 1.95144 0.975719 1.95144H13.0243C13.5622 1.95144 14 1.51383 14 0.975719C14 0.437606 13.5622 0 13.0243 0ZM13.0243 4.40814H0.975719C0.437606 4.40814 0 4.84574 0 5.38386C0 5.92197 0.437606 6.35958 0.975719 6.35958H13.0243C13.5622 6.35958 14 5.92197 14 5.38386C14 4.84574 13.5622 4.40814 13.0243 4.40814ZM13.0243 8.81627H0.975719C0.437606 8.81627 0 9.25385 0 9.79199C0 10.3301 0.437606 10.7677 0.975719 10.7677H13.0243C13.5622 10.7677 14 10.3301 14 9.79199C14 9.25384 13.5622 8.81627 13.0243 8.81627Z" fill="#6E6E6E"></path>
                            </svg>
                          </button>
                        </div>
                  </div>
                  <div class="card-body">
                    <div class="link-title">
                      <h5>Report Generated</h5>
                    </div>

                    <div class="report-generate d-flex">
                      <div class="url">
                        <a href="${projectUrl}" target='blank'"
                          class="link-dark text-break project-url">${projectUrl}
                        <span>
                          <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M11.3333 5.33333C11.1565 5.33333 10.987 5.40357 10.8619 5.5286C10.7369 5.65362 10.6667 5.82319 10.6667 6V10C10.6667 10.1768 10.5964 10.3464 10.4714 10.4714C10.3464 10.5964 10.1768 10.6667 10 10.6667H2C1.82319 10.6667 1.65362 10.5964 1.5286 10.4714C1.40357 10.3464 1.33333 10.1768 1.33333 10V2C1.33333 1.82319 1.40357 1.65362 1.5286 1.5286C1.65362 1.40357 1.82319 1.33333 2 1.33333H6C6.17681 1.33333 6.34638 1.2631 6.4714 1.13807C6.59643 1.01305 6.66667 0.843478 6.66667 0.666667C6.66667 0.489856 6.59643 0.320286 6.4714 0.195262C6.34638 0.0702379 6.17681 0 6 0H2C1.46957 0 0.960859 0.210714 0.585787 0.585787C0.210714 0.960859 0 1.46957 0 2V10C0 10.5304 0.210714 11.0391 0.585787 11.4142C0.960859 11.7893 1.46957 12 2 12H10C10.5304 12 11.0391 11.7893 11.4142 11.4142C11.7893 11.0391 12 10.5304 12 10V6C12 5.82319 11.9298 5.65362 11.8047 5.5286C11.6797 5.40357 11.5101 5.33333 11.3333 5.33333Z"
                              fill="#1E63B8" />
                            <path
                              d="M8.66728 1.33333H9.72061L5.52728 5.52C5.46479 5.58198 5.4152 5.65571 5.38135 5.73695C5.3475 5.81819 5.33008 5.90533 5.33008 5.99333C5.33008 6.08134 5.3475 6.16848 5.38135 6.24972C5.4152 6.33096 5.46479 6.40469 5.52728 6.46667C5.58925 6.52915 5.66299 6.57875 5.74423 6.61259C5.82547 6.64644 5.9126 6.66387 6.00061 6.66387C6.08862 6.66387 6.17576 6.64644 6.25699 6.61259C6.33823 6.57875 6.41197 6.52915 6.47394 6.46667L10.6673 2.28V3.33333C10.6673 3.51014 10.7375 3.67971 10.8625 3.80474C10.9876 3.92976 11.1571 4 11.3339 4C11.5108 4 11.6803 3.92976 11.8053 3.80474C11.9304 3.67971 12.0006 3.51014 12.0006 3.33333V0.666667C12.0006 0.489856 11.9304 0.320286 11.8053 0.195262C11.6803 0.0702379 11.5108 0 11.3339 0H8.66728C8.49047 0 8.3209 0.0702379 8.19587 0.195262C8.07085 0.320286 8.00061 0.489856 8.00061 0.666667C8.00061 0.843478 8.07085 1.01305 8.19587 1.13807C8.3209 1.2631 8.49047 1.33333 8.66728 1.33333Z"
                              fill="#1E63B8" />
                          </svg>
                        </span>
                        </a>
                      </div>
                    </div>
                                 <!-- Progress Download -->
                    <div class="progress-download">
                      <div class="progress-items">
                        <div class="pi-indicator">
                          <p>Passed</p>
                          <p>Failed</p>
                        </div>
                        <div class="pi-scale" data-passed="${dataPassed.length}" data-failed="${dataFailed.length}">
                          <p class="pi-scale-passedNum">${dataPassed.length}</p>
                          <p class="pi-scale-failedNum">${dataFailed.length}</p>
                          <div class="pi-scale-fill"></div>
                        </div>
                      </div>
                      <div class="download-items-wrapper">
                        <div class="download-items-wrapper-top">
                          <p>Download</p> 
                        </div>
                         <div class="download-items">
                        
                        <div class="download-single-item" id="dsi-pdf" data-tooltip="Download PDF">
                          <div>
                            
                          </div>
                          <div class="download-single-link">
                            <a href="javascript:void()" class="download-pdf-btn">
                              <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <rect width="19.6602" height="19.6602" fill="url(#pattern0_421_1569)"/>
                                  <defs>
                                  <pattern id="pattern0_421_1569" patternContentUnits="objectBoundingBox" width="1" height="1">
                                  <use xlink:href="#image0_421_1569" transform="scale(0.00195312)"/>
                                  </pattern>
                                  <image id="image0_421_1569" width="512" height="512" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                                  </defs>
                                  </svg>
                              </span>
                              
                            </a>
                          </div>
                        </div>
                        <div class="download-single-item" id="dsi-xlsx" data-tooltip="Download Excel">
                          <div class="download-single-link">
                            <a href="javascript:void()" class="email-modal-btn">
                              <span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <rect width="23.3779" height="23.3779" fill="url(#pattern0_421_1568)"/>
                                  <defs>
                                  <pattern id="pattern0_421_1568" patternContentUnits="objectBoundingBox" width="1" height="1">
                                  <use xlink:href="#image0_421_1568" transform="scale(0.00195312)"/>
                                  </pattern>
                                  <image id="image0_421_1568" width="512" height="512" preserveAspectRatio="none" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAYAAAD0eNT6AAAgAElEQVR4Ae2dCXQdxZnvyUwm782b7cx7My/YAck4ZGVC1lkyk0kIJiwThgSIg5FkCGviBMISYiAkQSYYwuZAICwBwpYAsYFgXcmybMuyvEmyJS/yIsmbAJF5ZyYvs7zJy5slod757Nyodd333l6ququqfz7H51717Vu3+l//+r5fd1dVH3EE/1AABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABWxUYGJi4reHX375D/mPBnggew8MDu7/AxvjAnVCARTwRAGl1G+M7J941+j4xBdHX5p4anR8YtPo+MQ/jI5P/HJ0fELxHw3wQD4e2Lh9RC1dM/DasrWDP1s9sP3F3u3bj/Ek7HAYKIACeSoweuDHbxsZn7h1dHziZQJ8PgEe3dG9lgcEAH7U3ffr/21rBn65enD7LXnGDX4bBVDAYQV2v/Tj942NTzzPGT7Jp1by4bP8/VEJAAIDL67uU6sHtt/vcAii6iiAAlkrMPLqq/9jbHziIRJ//oGd5EobRPFAGACUrwisHdxxedYxhN9DARRwUIHRl1796Oj4xI+jBB32ITnhATs8UAsA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ADNKzUuNNzSX0bmMjgfwAB7AAwEPyBi0vPNf4X9/RnvzAgAA2scDeAAP4IEMPbC38MnXBgEa2+aemGGjQ8ABAkZ3Ai4ewAMF9cB3bch/ha/DUYtn/3ZjqflfC2pCgAQgwQN4AA9k7IGGtpZPFz752iJAY1vzUwAAZyJ4AA/gATyQgQd+9sauub9jS/4rfD0alrZ8LINGh7IzpmzalGCOB/CAbR5oaG9+rPBJ1zYBGkstW2wzCvUheOEBPIAHvPLAa0d1NL/LtvxX+PrMKDWfQ0fzqqNxxYUrLngAD1jlgYb25hcLn2ytFEAd8bqGtuZeIAAIwAN4AA/gAQMe+Pdjlra8zcr8R6WOOKJx6Zz3Npaa/9NAw1tFoRwfwQ0P4AE8kK0HGkrNt5BnLVdgRqn5ejpGth0DvdEbD+ABzz0weOyy0/6L5emP6h3R2vobjaXmZZ6bkSsS3BvFA3gAD2TjgX88etk5bya7OqLA9NKl/62x1LwRCOCsBA/gATyAB1J44P8d3d7y146kPqpZVuDNL8z9n42llu0pGh66zoau0Rmd8QAesNEDP29oaz69nFN4dUyBP148+3dntDetAAI4A8ADeAAP4IEYHvgnzvwdS/ih1e054fUzSi2tjaXmX8ZofBtplDpxloQH8AAeMO+BwaOWthwbmk/Y6KYCje0tH29sbx4HAjgLwAN4AA/ggcM90PRvjW1NC9+5ePYb3Mxy1LqmAvLkwIZS042Nbc3/fHjj0yHQBA/gATxQQA+81lhq+tHMjvPeWjOB8KEfChy7rPn3G9qbrm0oNe8poNm5hGj+EiIaozEesN8D/9JYan60oe3c4/zIbBxFbAVmdMz988a2ppsaSy3rGktN/wYQcAaEB/AAHvDWA6Mz2loeaig1f0quCMdOGHzBYwUWz/7NhvammceUmk9uaG+a3VBqvqShvelS/qMBHsADeMA9DzSWmpuObm85Y0ZH03tkfRiPsxeHhgIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIoUAAF/j8axagEkoTkRgAAAABJRU5ErkJggg=="/>
                                  </defs>
                                  </svg>

                              </span>
                              
                            </a>
                          </div>
                        </div>
      
                        <div class="download-single-item" id="dsi-xlsx" data-tooltip="Download Excel">
                          <div class="download-single-link">
                            <a  class="export-excel-button">
                              <span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <rect width="23.3779" height="23.3779" fill="url(#pattern0_421_1568)"/>
                                  <defs>
                                  <pattern id="pattern0_421_1568" patternContentUnits="objectBoundingBox" width="1" height="1">
                                  <use xlink:href="#image0_421_1568" transform="scale(0.00195312)"/>
                                  </pattern>
                                  <image id="image0_421_1568" width="512" height="512" preserveAspectRatio="none" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAYAAAD0eNT6AAAgAElEQVR4Ae2dCXQdxZnvyUwm782b7cx7My/YAck4ZGVC1lkyk0kIJiwThgSIg5FkCGviBMISYiAkQSYYwuZAICwBwpYAsYFgXcmybMuyvEmyJS/yIsmbAJF5ZyYvs7zJy5slod757Nyodd333l6ququqfz7H51717Vu3+l//+r5fd1dVH3EE/1AABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABVAABWxUYGJi4reHX375D/mPBnggew8MDu7/AxvjAnVCARTwRAGl1G+M7J941+j4xBdHX5p4anR8YtPo+MQ/jI5P/HJ0fELxHw3wQD4e2Lh9RC1dM/DasrWDP1s9sP3F3u3bj/Ek7HAYKIACeSoweuDHbxsZn7h1dHziZQJ8PgEe3dG9lgcEAH7U3ffr/21rBn65enD7LXnGDX4bBVDAYQV2v/Tj942NTzzPGT7Jp1by4bP8/VEJAAIDL67uU6sHtt/vcAii6iiAAlkrMPLqq/9jbHziIRJ//oGd5EobRPFAGACUrwisHdxxedYxhN9DARRwUIHRl1796Oj4xI+jBB32ITnhATs8UAsA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ADNKzUuNNzSX0bmMjgfwAB7AAwEPyBi0vPNf4X9/RnvzAgAA2scDeAAP4IEMPbC38MnXBgEa2+aemGGjQ8ABAkZ3Ai4ewAMF9cB3bch/ha/DUYtn/3ZjqflfC2pCgAQgwQN4AA9k7IGGtpZPFz752iJAY1vzUwAAZyJ4AA/gATyQgQd+9sauub9jS/4rfD0alrZ8LINGh7IzpmzalGCOB/CAbR5oaG9+rPBJ1zYBGkstW2wzCvUheOEBPIAHvPLAa0d1NL/LtvxX+PrMKDWfQ0fzqqNxxYUrLngAD1jlgYb25hcLn2ytFEAd8bqGtuZeIAAIwAN4AA/gAQMe+Pdjlra8zcr8R6WOOKJx6Zz3Npaa/9NAw1tFoRwfwQ0P4AE8kK0HGkrNt5BnLVdgRqn5ejpGth0DvdEbD+ABzz0weOyy0/6L5emP6h3R2vobjaXmZZ6bkSsS3BvFA3gAD2TjgX88etk5bya7OqLA9NKl/62x1LwRCOCsBA/gATyAB1J44P8d3d7y146kPqpZVuDNL8z9n42llu0pGh66zoau0Rmd8QAesNEDP29oaz69nFN4dUyBP148+3dntDetAAI4A8ADeAAP4IEYHvgnzvwdS/ih1e054fUzSi2tjaXmX8ZofBtplDpxloQH8AAeMO+BwaOWthwbmk/Y6KYCje0tH29sbx4HAjgLwAN4AA/ggcM90PRvjW1NC9+5ePYb3Mxy1LqmAvLkwIZS042Nbc3/fHjj0yHQBA/gATxQQA+81lhq+tHMjvPeWjOB8KEfChy7rPn3G9qbrm0oNe8poNm5hGj+EiIaozEesN8D/9JYan60oe3c4/zIbBxFbAVmdMz988a2ppsaSy3rGktN/wYQcAaEB/AAHvDWA6Mz2loeaig1f0quCMdOGHzBYwUWz/7NhvammceUmk9uaG+a3VBqvqShvelS/qMBHsADeMA9DzSWmpuObm85Y0ZH03tkfRiPsxeHhgIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIogAIoUAAF/j8axagEkoTkRgAAAABJRU5ErkJggg=="/>
                                  </defs>
                                  </svg>

                              </span>
                              
                            </a>
                          </div>
                        </div>

                        <div class="download-single-item" id="dsi-csv" data-tooltip="Download CSV">
                          <div class="download-single-link">
                            <a href="javascript:void()" class="download-csv-btn">
                              <span>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <rect width="23.3779" height="23.3779" fill="url(#pattern0_421_1567)"/>
                                  <defs>
                                  <pattern id="pattern0_421_1567" patternContentUnits="objectBoundingBox" width="1" height="1">
                                  <use xlink:href="#image0_421_1567" transform="scale(0.00195312)"/>
                                  </pattern>
                                  <image id="image0_421_1567" width="512" height="512" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                                  </defs>
                                  </svg>

                              </span>
                              
                            </a>
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 analysis-area-container-two"> 
           
                       
                    
              <div class="analysis-score container-health-score">
                  
                  <div class="control-hide-show" id="chs-healthScore">
                    <div class="control-hide ${dataFailed.length == 0 ? "d-none": ""}"  >
                      <button class="btn_toggle_show rounded-pill hidePassedBtn">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path
                              d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z" />
                          </svg></span>
                        Hide Items Passed
                      </button>
                    </div>
                    
                    <div class="control-dash-icon project-tiles-btn" id="tilesExtended">
                          <button class="btn">
                            <svg width="25" height="18" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6 11.3393C12.6 11.7067 12.2547 12 11.8687 12H9.76867C9.68097 12.0021 9.59375 11.9864 9.51222 11.9541C9.43068 11.9217 9.3565 11.8733 9.2941 11.8116C9.2317 11.7499 9.18235 11.6763 9.14901 11.5952C9.11566 11.5141 9.09899 11.4271 9.1 11.3393V9.33933C9.09866 9.25097 9.11502 9.16322 9.1481 9.08127C9.18118 8.99932 9.23031 8.92481 9.29262 8.86213C9.35493 8.79945 9.42914 8.74987 9.51089 8.7163C9.59265 8.68273 9.68029 8.66586 9.76867 8.66667H11.8687C12.2553 8.66667 12.6 8.972 12.6 9.33933V11.3393ZM11.8687 7.33333H9.76867C8.60867 7.33333 7.7 8.23467 7.7 9.33933V11.3393C7.7 12.444 8.60867 13.3333 9.76867 13.3333H11.8687C13.0287 13.3333 14 12.444 14 11.3393V9.33933C14 8.23467 13.0287 7.33333 11.8687 7.33333ZM4.9 11.3393C4.9 11.7067 4.55467 12 4.16867 12H2.06867C1.98097 12.0021 1.89375 11.9864 1.81222 11.9541C1.73068 11.9217 1.6565 11.8733 1.5941 11.8116C1.5317 11.7499 1.48235 11.6763 1.44901 11.5952C1.41566 11.5141 1.39899 11.4271 1.4 11.3393V9.33933C1.39866 9.25097 1.41502 9.16322 1.44809 9.08127C1.48117 8.99932 1.53031 8.92481 1.59262 8.86213C1.65493 8.79945 1.72914 8.74987 1.81089 8.7163C1.89265 8.68273 1.98029 8.66586 2.06867 8.66667H4.16867C4.55533 8.66667 4.9 8.972 4.9 9.33933V11.3393ZM4.16867 7.33333H2.06867C0.908667 7.33333 0 8.23467 0 9.33933V11.3393C0 12.444 0.908667 13.3333 2.06867 13.3333H4.16867C5.32867 13.3333 6.3 12.444 6.3 11.3393V9.33933C6.3 8.23467 5.32867 7.33333 4.16867 7.33333ZM12.6 4.006C12.6 4.37333 12.2547 4.66667 11.8687 4.66667H9.76867C9.68097 4.66873 9.59375 4.65311 9.51222 4.62074C9.43068 4.58838 9.3565 4.53992 9.2941 4.47826C9.2317 4.41661 9.18235 4.34302 9.14901 4.26188C9.11566 4.18074 9.09899 4.09372 9.1 4.006V2.006C9.09866 1.91763 9.11502 1.82989 9.1481 1.74794C9.18118 1.66598 9.23031 1.59147 9.29262 1.5288C9.35493 1.46612 9.42914 1.41653 9.51089 1.38297C9.59265 1.3494 9.68029 1.33252 9.76867 1.33333H11.8687C12.2553 1.33333 12.6 1.63867 12.6 2.006V4.006ZM11.8687 0H9.76867C8.60867 0 7.7 0.901333 7.7 2.006V4.006C7.7 5.11067 8.60867 6 9.76867 6H11.8687C13.0287 6 14 5.11067 14 4.006V2.006C14 0.901333 13.0287 0 11.8687 0ZM4.9 4.006C4.9 4.37333 4.55467 4.66667 4.16867 4.66667H2.06867C1.98097 4.66873 1.89375 4.65311 1.81222 4.62074C1.73068 4.58838 1.6565 4.53992 1.5941 4.47826C1.5317 4.41661 1.48235 4.34302 1.44901 4.26188C1.41566 4.18074 1.39899 4.09372 1.4 4.006V2.006C1.39866 1.91763 1.41502 1.82989 1.44809 1.74794C1.48117 1.66598 1.53031 1.59147 1.59262 1.5288C1.65493 1.46612 1.72914 1.41653 1.81089 1.38297C1.89265 1.3494 1.98029 1.33252 2.06867 1.33333H4.16867C4.55533 1.33333 4.9 1.63867 4.9 2.006V4.006ZM4.16867 0H2.06867C0.908667 0 0 0.901333 0 2.006V4.006C0 5.11067 0.908667 6 2.06867 6H4.16867C5.32867 6 6.3 5.11067 6.3 4.006V2.006C6.3 0.901333 5.32867 0 4.16867 0Z" fill="#D5D5DD"></path>
                            </svg>
                          </button>
                    </div>

                    <div class="control-bars-icon project-tiles-btn" id="tilesSingle">
                          <button class="btn">
                            <svg width="20" height="15" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M13.0243 0H0.975719C0.437606 0 0 0.437606 0 0.975719C0 1.51383 0.437606 1.95144 0.975719 1.95144H13.0243C13.5622 1.95144 14 1.51383 14 0.975719C14 0.437606 13.5622 0 13.0243 0ZM13.0243 4.40814H0.975719C0.437606 4.40814 0 4.84574 0 5.38386C0 5.92197 0.437606 6.35958 0.975719 6.35958H13.0243C13.5622 6.35958 14 5.92197 14 5.38386C14 4.84574 13.5622 4.40814 13.0243 4.40814ZM13.0243 8.81627H0.975719C0.437606 8.81627 0 9.25385 0 9.79199C0 10.3301 0.437606 10.7677 0.975719 10.7677H13.0243C13.5622 10.7677 14 10.3301 14 9.79199C14 9.25384 13.5622 8.81627 13.0243 8.81627Z" fill="#6E6E6E"></path>
                            </svg>
                          </button>
                        </div>
                  </div>
                  <div class="title">
                    <span>Health Score</span>
                    <span class="card-help">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                          xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0V0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36957 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4V14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4V4Z"
                            fill="#D3D5D8" />
                        </svg>
                        <div class="card-help-body">
                          <p>Learn more</p>
                        </div>
                    </span>
                  </div>

                  <div class="healthBarDiv">
                        <div class="healthScore center">
                            <div class="label-health poor">POOR</div>
                            <div class="label-health avg">AVG</div>
                            <div class="label-health good">GOOD</div>
                            <div class="label-health best">BEST</div>
                            </div>
                            <div class="middleCircle"></div>
                            <div class="pointer"></div>
                            <div class="pointer-pivot"></div>

                            <div class="scoreDiv">
                                <p class="score-health">50</p>
                            </div>
                        </div>    
                  </div>
              </div>

             
            </div>
          </div>

          
        </div>
    `
    document.querySelector(".analysis-content-body").prepend(div)
    
    document.querySelectorAll('.pi-scale').forEach(scale => {
      const passed = parseFloat(scale.dataset.passed) || 0;
      const failed = parseFloat(scale.dataset.failed) || 0;
      const total = passed + failed;

      const passedPercent = total === 0 ? 0 : (passed / total) * 100;

      const fill = scale.querySelector('.pi-scale-fill');
      
      // Animate after short delay (so transition triggers)
      setTimeout(() => {
        fill.style.width = `${passedPercent}%`;
      }, 100);
    });

}

  function updateProgress(testLabels, data){
      const total = testLabels.length

      // (------OVERALL PROGRESS----------) //
      $("#loader_test_current").html(data.title)
      const totalPercent = parseInt(getReportProgress(resultsData.length, total, false))
      document.querySelector(".loader-bold-span").innerHTML = `${totalPercent}%`
      $(".progress .progress-bar").css("width", `${totalPercent}%`)

      $("#failedProgress").attr("data-value", getReportProgress(dataFailed.length, total, false))
      $("#passedProgress").attr("data-value", getReportProgress(dataPassed.length, total, false))

      $("#failedProgress").attr("data-text", dataFailed.length, total, false)
      $("#passedProgress").attr("data-text", dataPassed.length, total, false)

      updateCircularProgress()
      updateLoaderDetails(data)
  }

  function updateLoaderDetails(data){


      const parent = document.getElementById(data.label.name).parentElement.parentElement.parentElement.parentElement
      const failedElement = parent.querySelector(".details-failed")
      const passedElement = parent.querySelector(".details-passed")

      const contentParent = document.getElementById(data.label.name).parentElement
      const currentTotal = contentParent.children.length - 1
      
      if(data.status){
        let currentInt = parseInt(passedElement.textContent)
        currentInt++

        passedElement.textContent = currentInt
        if(currentInt > 1){
          passedElement.parentElement.innerHTML = `<span class="details-passed">${currentInt}</span> Tests Passed`
        }else{
          passedElement.parentElement.innerHTML = `<span class="details-passed">${currentInt}</span> Test Passed`
        }
        $("#completedTests").html(resultsData.length)
      
      }else{
        let currentInt = parseInt(failedElement.textContent)
        currentInt++
        if(currentInt > 1){
          failedElement.parentElement.innerHTML = `<span class="details-failed">${currentInt}</span> Tests Failed`
        }else{
          failedElement.parentElement.innerHTML = `<span class="details-failed">${currentInt}</span> Test Failed`
        }
      }

      

      

      document.getElementById(data.label.name).querySelector(".testing").classList.remove("testing")
      document.getElementById(data.label.name).querySelector(".loader-item-current").textContent = "Tested"
      if(data.status){
        document.getElementById(data.label.name).querySelector(".loader-item-chip").classList.add("chip-alert")
        document.getElementById(data.label.name).querySelector(".loader-item-chip").classList.add("success")
        document.getElementById(data.label.name).querySelector(".loader-item-chip").textContent = "PASS"
      }else{
        document.getElementById(data.label.name).querySelector(".loader-item-chip").classList.add("chip-alert")
        document.getElementById(data.label.name).querySelector(".loader-item-chip").classList.add("fail")
        document.getElementById(data.label.name).querySelector(".loader-item-chip").textContent = "FAIL"
      }

      // Helper function to check and close content section when all tests are complete
      function checkAndCloseSection(contentId, parentType){
        const content = document.getElementById(contentId)
        if(!content) return
        
        const table = content.querySelector(".status-table")
        if(!table) return
        
        const allRows = table.querySelectorAll("tbody tr")
        const totalRows = allRows.length
        if(totalRows === 0) return
        
        let completedCount = 0
        allRows.forEach(row => {
          const firstTd = row.querySelector("td")
          if(firstTd && !firstTd.classList.contains("testing")){
            completedCount++
          }
        })
        
        // Check if all tests are done (all rows' first td no longer have "testing" class)
        if(completedCount === totalRows){
          content.style.display = "none"
          // Set background color of the loader-single-item when tests are complete and content is closed
          const container = content.closest(".loader-single-item-container")
          if(container){
            const loaderItem = container.querySelector(".loader-single-item")
            if(loaderItem){
              loaderItem.style.setProperty("background-color", "rgba(230, 235, 242, 1)", "important")
            }
          }
        }
      }

      // Check and close sections based on test parent type
      const parentType = data.label.parent
      if(!parentType || parentType === "seo"){
        // SEO tests (default case)
        checkAndCloseSection("seo-content", "seo")
      } else if(parentType === "performance"){
        checkAndCloseSection("performance-content", "performance")
      } else if(parentType === "bestPractices"){
        checkAndCloseSection("best-practices-content", "bestPractices")
      } else if(parentType === "security"){
        checkAndCloseSection("security-content", "security")
      }
      
      // Update all container backgrounds to ensure consistency
      UI.updateAllContainerBackgrounds()
  }

  function hideThatPass(e, type){
      let displayShow = type === "images" ? "table-row" : "block"
      let el = type === "images" ? document.querySelectorAll("#tbodyImages .passed") : document.querySelectorAll(".card-body-content.passed")
      el.forEach((el, index)=>{
          if(e.target.checked === true){
              el.style.display = 'none'
          }else{
              el.style.display = displayShow
          }
      })
  }





    // Broken Links Individual Ignore Functionality
    $(document).on('click', '.ignore-link-btn', function(e) {
      e.preventDefault();
      const url = $(this).data('url');
      let project = document.querySelector("#activeProject").getAttribute("data-val")
      const projectId = getStringPart(project, "-", 1)
      
      // Detect if the button was clicked from modal or card body
      const isFromModal = $(this).closest('#broken-links-modal').length > 0;
      let alertContainer;
      let closestCardBody = null;
      
      if (isFromModal) {
        alertContainer = '.modal-footer-alert';
      } else {
        // Find the closest card body from the clicked button and get its selector
        closestCardBody = $(this).closest('.content-element');
        if (closestCardBody.length > 0) {
          // Create a unique selector for this specific card body
          const cardBodyId = closestCardBody.attr('id') || 'content-element-' + Math.random().toString(36).substr(2, 9);
          if (!closestCardBody.attr('id')) {
            closestCardBody.attr('id', cardBodyId);
          }
          alertContainer = '#' + cardBodyId;
        } else {
          alertContainer = '.analysis-content-body';
        }
      }
      
      if (!url) {
        Controls.handleAlert(0, "No URL to ignore.", alertContainer, true);
        return;
      }
      

      
      $.ajax({
        url: '/api/ignore-broken-link',
        type: 'POST',
        data: {
          project_id: projectId,
          url: url,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.success) {
            // Show success alert in appropriate container
            Controls.handleAlert(3, `URL "${url}" has been added to the ignore list.`, alertContainer, true);
            
            // Find and update the current analysis data to remove the ignored URL
            const currentAnalysisData = window.currentAnalysisData;
            if (currentAnalysisData && currentAnalysisData.allLinks) {
              // Remove the ignored URL from allLinks
              delete currentAnalysisData.allLinks[url];
              
              // Re-render based on context
              if (isFromModal) {
                // If clicked from modal, update both modal and card
                const brokenLinksCard = document.querySelector('.broken-links-card .meta-list-single');
                const brokenLinksModal = document.querySelector('#broken-links-modal .meta-list-single');
                
                if (brokenLinksCard) {
                  brokenLinksCard.innerHTML = UI.getBrokenLinks(currentAnalysisData.allLinks, true);
                }
                
                if (brokenLinksModal) {
                  brokenLinksModal.innerHTML = UI.getBrokenLinks(currentAnalysisData.allLinks, false);
                }
              } else {
                // If clicked from card body, update the specific card body directly
                if (closestCardBody && closestCardBody.length > 0) {
                  const cardMetaListSingle = closestCardBody.find('.meta-list-single');
                  if (cardMetaListSingle.length > 0) {
                    cardMetaListSingle.html(UI.getBrokenLinks(currentAnalysisData.allLinks, true));
                  }
                }
                
                // Also update the modal if it exists (for consistency)
                const brokenLinksModal = document.querySelector('#broken-links-modal .meta-list-single');
                if (brokenLinksModal) {
                  brokenLinksModal.innerHTML = UI.getBrokenLinks(currentAnalysisData.allLinks, false);
                }
              }


                 // Update the broken links count if it exists
                 const totalBrokenLinksElement = document.querySelector('.broken-links-card');
                 if (totalBrokenLinksElement && currentAnalysisData.totalBrokenLinks !== undefined) {
                   const remainingBrokenLinks = Object.keys(currentAnalysisData.allLinks).filter(key => {
                     const state = currentAnalysisData.allLinks[key]["state"];
                     let status = 404;
                     if (state === "fulfilled") {
                       const value = currentAnalysisData.allLinks[key]["value"];
                       status = value["status"];
                     }
                     return status != 200 && status != 0 && status != 405;
                   }).length;
                   
                  //  currentAnalysisData.totalBrokenLinks = remainingBrokenLinks;
                  //  totalBrokenLinksElement.textContent = remainingBrokenLinks;
                   
                   // Hide the broken links section if no more broken links
                   if (remainingBrokenLinks === 0) {
                     const brokenLinksSection = document.querySelector('.card-inner-content');
                     if (brokenLinksSection) {
                       brokenLinksSection.classList.add('d-none');
                     }
                   }
                 }
              
    
            } else {
              // Fallback: if global data is not available, just remove the row from current view
              $(e.target).closest('tr').fadeOut(300, function() {
                $(this).remove();
              });
            }
          } else {
            Controls.handleAlert(0, response.message || "Failed to ignore URL.", alertContainer, true);
          }
        },
        error: function(xhr) {
          const response = xhr.responseJSON || {};
          Controls.handleAlert(0, response.message || "An error occurred while ignoring the URL.", alertContainer, true);
        }
      });
    });

    // Broken Links Ignore All Functionality
    $(document).on('click', '.ignore-all-link', function(e) {
      e.preventDefault();
      const urls = $(this).data('urls');
      let project = document.querySelector("#activeProject").getAttribute("data-val")
      const projectId = getStringPart(project, "-", 1)
      
      // Detect if the button was clicked from modal or card body
      const isFromModal = $(this).closest('#broken-links-modal').length > 0;
      let alertContainer;
      let closestCardBody = null;
      
      if (isFromModal) {
        alertContainer = '.modal-footer-alert';
      } else {
        // Find the closest card body from the clicked button and get its selector
        closestCardBody = $(this).closest('.content-element');
        if (closestCardBody.length > 0) {
          // Create a unique selector for this specific card body
          const cardBodyId = closestCardBody.attr('id') || 'content-element-' + Math.random().toString(36).substr(2, 9);
          if (!closestCardBody.attr('id')) {
            closestCardBody.attr('id', cardBodyId);
          }
          alertContainer = '#' + cardBodyId;
        } else {
          alertContainer = '.analysis-content-body';
        }
      }
      
      if (!urls || urls.length === 0) {
        Controls.handleAlert(0, "No URLs to ignore.", alertContainer, true);
        return;
      }
      
      // // Show confirmation dialog
      // if (!confirm(`Are you sure you want to ignore all ${urls.length} broken links?`)) {
      //   return;
      // }
      
      $.ajax({
        url: '/api/ignore-all-broken-links',
        type: 'POST',
        data: {
          project_id: projectId,
          urls: urls,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.success) {            
            // Find and update the current analysis data to remove all ignored URLs
            const currentAnalysisData = window.currentAnalysisData;

            // Show success alert in appropriate container
            Controls.handleAlert(3, `All URL(s) have been added to the ignore list.`, alertContainer, true);

            if (currentAnalysisData && currentAnalysisData.allLinks) {
              // Remove all ignored URLs from allLinks
              urls.forEach(url => {
                delete currentAnalysisData.allLinks[url];
              });
              
              // Re-render based on context
              if (isFromModal) {
                // If clicked from modal, update both modal and card
                const brokenLinksCard = document.querySelector('.broken-links-card .meta-list-single');
                const brokenLinksModal = document.querySelector('#broken-links-modal .meta-list-single');
                
                if (brokenLinksCard) {
                  brokenLinksCard.innerHTML = UI.getBrokenLinks(currentAnalysisData.allLinks, true);
                }
                
                if (brokenLinksModal) {
                  brokenLinksModal.innerHTML = UI.getBrokenLinks(currentAnalysisData.allLinks, false);
                }
              } else {
                // If clicked from card body, update the specific card body directly
                if (closestCardBody && closestCardBody.length > 0) {
                  const cardMetaListSingle = closestCardBody.find('.meta-list-single');
                  if (cardMetaListSingle.length > 0) {
                    cardMetaListSingle.html(UI.getBrokenLinks(currentAnalysisData.allLinks, true));
                  }
                }
                
                // Also update the modal if it exists (for consistency)
                const brokenLinksModal = document.querySelector('#broken-links-modal .meta-list-single');
                if (brokenLinksModal) {
                  brokenLinksModal.innerHTML = UI.getBrokenLinks(currentAnalysisData.allLinks, false);
                }
              }
              
              // Update the broken links count if it exists
              const totalBrokenLinksElement = document.querySelector('.broken-links-card');
              if (totalBrokenLinksElement && currentAnalysisData.totalBrokenLinks !== undefined) {
                const remainingBrokenLinks = Object.keys(currentAnalysisData.allLinks).filter(key => {
                  const state = currentAnalysisData.allLinks[key]["state"];
                  let status = 404;
                  if (state === "fulfilled") {
                    const value = currentAnalysisData.allLinks[key]["value"];
                    status = value["status"];
                  }
                  return status != 200 && status != 0 && status != 405;
                }).length;
                
                currentAnalysisData.totalBrokenLinks = remainingBrokenLinks;
                totalBrokenLinksElement.textContent = remainingBrokenLinks;
                
                                // Hide the broken links section if no more broken links
                if (remainingBrokenLinks === 0) {
                  const brokenLinksSection = document.querySelector('.card-inner-content');
                  if (brokenLinksSection) {
                    brokenLinksSection.classList.add('d-none');
                  }
                }
              }
            } else {
              // Fallback: if global data is not available, just remove all rows from current view
              $('.broken-links-table tbody tr').fadeOut(300, function() {
                $(this).remove();
              });
            }
          } else {
            Controls.handleAlert(0, response.message || "Failed to ignore URLs.", alertContainer, true);
          }
        },
        error: function(xhr) {
          const response = xhr.responseJSON || {};
          Controls.handleAlert(0, response.message || "An error occurred while ignoring the URLs.", alertContainer, true );
        }
      });
    });
  
  
})




function buildDatatable(testLabels) {
  if ($('.custom-dataTable').length) {
  createDatatableElement()
  }
}
function createDatatableElement() {
  var paginationHtml = `
  <div class="table-pagination ms-auto">
      <div class="show-row">
          <span>Show rows:</span>
          <select name="" id="rows-per-page" class="btn btn-outline-gray">
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
              <option value="40">40</option>
          </select>
      </div>
      <div class="total-row">
          <span>Go to:</span>
          <input type="text" name="canPageGo" id="canPageGo" class="form-control can-page-go-control">
      </div>
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
  </div>`;
// Append the pagination element to the container with the class 'test_result_area'
  $('.analysis-table-image').append(paginationHtml);
  if ($('.custom-dataTable').length) {
    var datatableClass =  'custom-dataTable';
  initializeCustomDataTable(datatableClass)
  }
}
function initializeCustomDataTable(datatableClass) {
  // Initialize the DataTable
  var tableImg = $('.' + datatableClass).DataTable({
      pageLength: 10, // Number of rows per page
      paging: true,   // Enable pagination
      info: false,    // Hide the info text (optional)
      searching: true // Disable default searching
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
