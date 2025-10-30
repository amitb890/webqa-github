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
    static updateLoaderCurrentTestStatus(label){
      UI.collapsePreviousParent(label)
      document.getElementById(label.name).querySelector(".loader-item-current").textContent = "Testing..."
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
        }        
      }

      if(parentCard === "bestPractices"){
        if(document.getElementById("performance-content")){
          document.getElementById("performance-content").style.display = "none"
        }
      }

      if(parentCard === "security"){
        if(document.getElementById("best-practices-content")){
          document.getElementById("best-practices-content").style.display = "none"
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
            <th>URL</th>
            <th>HTTP Status Code</th>
            <th>
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
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          test_key: testKey,
          result,
          test_labels: JSON.stringify(testLabels),
          resultsData: JSON.stringify(resultsData),
          dataFailed: JSON.stringify(dataFailed),
          dataPassed: JSON.stringify(dataPassed),
          projectUrl: projectUrl,
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
        if(el.name === "title" && pageTitleStatus){
           pageTitle = el.content 
           pageTitleStatus = false
        }

        if(el.name === "description" && pageDescStatus){
          pageDesc = el.content 
          pageDescStatus = false
        }
      })
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
      const bestPracticesElement = buildLoaderDetailSingleElement("HTML Best practices", "best-practices-content")
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
        }
    
      })    

  }   

  function toggleLoaderDropdown(id) {
    var content = document.getElementById(id);
    if (content.style.display === "block") {
        content.style.display = "none";
    } else {
        content.style.display = "block";
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
          <a class="dropdown-toggle" data-id="${idVal}" href="javascript:void()"></a>
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
      

      const div = document.createElement("div")
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



                              <div class="modal fade meta-list-brokenBody" aria-labelledby="exampleModalToggleLabel" tabindex="1" id="broken-links-modal" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <div>
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                          List of broken links
                                        </h1>
                                        <button id="downloadCSVBrokenLinks"><img src="/new-assets/assets/images/xl.png" alt="xl-img"> Download CSV</button>
                                      </div>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

                                  <tbody>       
                                  
                                  ${data.secondaryBots.map((item, index) => `
                                        <tr>
                                          <td>${index + 1}</td>
                                          <td>
                                          <span>${item}</span>
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
                          </div>
                          ${data.urlBlock == true ? 
                            `
                            <div class="card-inner-content">
                           
                                <div class="card mb-2" style="width:50%">
                                    <div class="card-body">
                                    ${data.content}
                                    <div class="card-actual-url">
                                    <table style="font-family: 'Courier Prime';">
                                    ${data.robotTextResponseData.map((item, index) => {
                                        if (item.trim() !== '') {
                                            return `
                                                <tr>
                                                    <td style="padding-right:30px">${index + 1}</td> <!-- Auto-incrementing value -->
                                                    <td>${item}</td>
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
                              <div class="card-body">
                              ${data.content}
                              <div class="card-actual-url">
                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crossOriginLinksModal">
                                 Click here to see list of Cross Origin Links List
                                  </button>
                        
                      <div class="modal" id="crossOriginLinksModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Cross Origin Links</h4>
                                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                <table>
                                    <tr>
                                    <th>URL</th>
                                    </tr>         
                            ${data.crossOriginLinksData.map(item => `
                                              <tr>
                                                  <td>${item}</td>
                                              </tr>
                                            `).join('')}     
                                 </table></div>
                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        </div></div>
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
                                              <img id="activeFavicon" src="http://127.0.0.1:8000/storage/images/67a9d25d46e0ffavicon.ico" alt="icon">
                                            </span>
                                          </div>
                                          <div class="card-text-link">
                                            <span>Setmore</span>
                                            <a class="card-text-link" href="${projectUrl}" target="_blank">${projectUrl}</a>
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

      $("#hidePassed").click(function () {
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
                        <span class="circular-progress progress-red">
                          <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                            data-value="${getReportProgress(dataFailed.length, total, false)}" data-text="${dataFailed.length}" class="svg-circle">
                            <circle r="45" cx="50" cy="50" />
                            <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                            <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0" stroke-linecap="round"
                              stroke-linejoin="round" stroke-dashoffset="282.78302001953125"
                              stroke-dasharray="282.78302001953125" />
                            <!-- Value automatically updates based on data-value set above -->
                            <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                              font-size="24"></text>
                          </svg>
                        </span>
                        <span class="circular-progress progress-green">
                          <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                            data-value="${getReportProgress(dataPassed.length, total, false)}" data-text="${dataPassed.length}" class="svg-circle">
                            <circle r="45" cx="50" cy="50" />
                            <!-- 282.78302001953125 is auto-calculated by path.getTotalLength() -->
                            <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0" stroke-linecap="round"
                              stroke-linejoin="round" stroke-dashoffset="282.78302001953125"
                              stroke-dasharray="282.78302001953125" />
                            <!-- Value automatically updates based on data-value set above -->
                            <text x="50" y="50" text-anchor="middle" dominant-baseline="central"
                              font-size="24"></text>
                          </svg>
                        </span>
                      </div>
                      <div class="download-items">
                        <div class="download-single-item">
                          <div class="download-single-link">
                            <a href="javascript:void()" class="download-csv-btn">
                              <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <path
                                    d="M10.4557 0H11.8047V1.81796C14.0772 1.81796 16.3496 1.8225 18.6245 1.81093C19.0175 1.77461 19.4127 1.85024 19.7645 2.02909C19.9469 2.38298 20.0242 2.7817 19.9872 3.17812C19.9759 7.11922 19.9745 11.0592 19.9831 14.9981C20.021 15.6615 19.9952 16.327 19.9058 16.9855C19.8149 17.4577 19.2472 17.4693 18.8679 17.485C16.5153 17.4916 14.1602 17.4805 11.8051 17.485V19.529H10.3946C6.93344 18.9018 3.46527 18.3204 0 17.7139V1.81796C3.48593 1.21266 6.97186 0.615626 10.4557 0Z"
                                    fill="#207245" />
                                  <path
                                    d="M11.8047 2.49805H19.2992V16.8054H11.8047V15.4419H13.6226V13.8532H11.8047V12.9443H13.6226V11.3552H11.8047V10.4462H13.6226V8.85676H11.8047V7.94778H13.6226V6.35872H11.8047V5.45222H13.6226V3.86069H11.8047V2.49805Z"
                                    fill="white" />
                                  <path d="M14.5293 3.86084H17.7107V5.45155H14.5293V3.86084Z" fill="#207245" />
                                  <path
                                    d="M6.72782 5.98847C7.24098 5.95211 7.7558 5.92112 8.27226 5.89551C7.66627 7.13888 7.05547 8.37963 6.43984 9.61777C7.06456 10.8895 7.7025 12.1522 8.32928 13.4239C7.78251 13.3925 7.23603 13.3577 6.68981 13.3194C6.25793 12.3915 5.87953 11.4396 5.55648 10.4685C5.24784 11.3907 4.80699 12.2604 4.4529 13.1644C3.95709 13.1574 3.45798 13.1372 2.96094 13.1165C3.54434 11.9741 4.1079 10.8226 4.70948 9.68718C4.19839 8.5175 3.63771 7.37053 3.11051 6.20787C3.61017 6.17812 4.10983 6.14933 4.60949 6.12151C4.94788 7.00942 5.31767 7.88617 5.59739 8.7968C5.89694 7.83163 6.3444 6.92348 6.72824 5.98971L6.72782 5.98847Z"
                                    fill="white" />
                                  <path
                                    d="M14.5293 6.35889H17.7107V7.94877H14.5293V6.35889ZM14.5293 8.85692H17.7107V10.4468H14.5293V8.85692ZM14.5293 11.355H17.7107V12.9448H14.5293V11.355ZM14.5293 13.853H17.7107V15.4429H14.5293V13.853Z"
                                    fill="#207245" />
                                </svg>
                              </span>
                              <span>Download CSV</span>
                            </a>
                          </div>
                        </div>
                        <div class="download-single-item">
                          <div class="download-single-link">
                            <a href="javascript:void(0)" class="download-pdf-btn">
                              <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <path
                                    d="M10.4557 0H11.8047V1.81796C14.0772 1.81796 16.3496 1.8225 18.6245 1.81093C19.0175 1.77461 19.4127 1.85024 19.7645 2.02909C19.9469 2.38298 20.0242 2.7817 19.9872 3.17812C19.9759 7.11922 19.9745 11.0592 19.9831 14.9981C20.021 15.6615 19.9952 16.327 19.9058 16.9855C19.8149 17.4577 19.2472 17.4693 18.8679 17.485C16.5153 17.4916 14.1602 17.4805 11.8051 17.485V19.529H10.3946C6.93344 18.9018 3.46527 18.3204 0 17.7139V1.81796C3.48593 1.21266 6.97186 0.615626 10.4557 0Z"
                                    fill="#207245" />
                                  <path
                                    d="M11.8047 2.49805H19.2992V16.8054H11.8047V15.4419H13.6226V13.8532H11.8047V12.9443H13.6226V11.3552H11.8047V10.4462H13.6226V8.85676H11.8047V7.94778H13.6226V6.35872H11.8047V5.45222H13.6226V3.86069H11.8047V2.49805Z"
                                    fill="white" />
                                  <path d="M14.5293 3.86084H17.7107V5.45155H14.5293V3.86084Z" fill="#207245" />
                                  <path
                                    d="M6.72782 5.98847C7.24098 5.95211 7.7558 5.92112 8.27226 5.89551C7.66627 7.13888 7.05547 8.37963 6.43984 9.61777C7.06456 10.8895 7.7025 12.1522 8.32928 13.4239C7.78251 13.3925 7.23603 13.3577 6.68981 13.3194C6.25793 12.3915 5.87953 11.4396 5.55648 10.4685C5.24784 11.3907 4.80699 12.2604 4.4529 13.1644C3.95709 13.1574 3.45798 13.1372 2.96094 13.1165C3.54434 11.9741 4.1079 10.8226 4.70948 9.68718C4.19839 8.5175 3.63771 7.37053 3.11051 6.20787C3.61017 6.17812 4.10983 6.14933 4.60949 6.12151C4.94788 7.00942 5.31767 7.88617 5.59739 8.7968C5.89694 7.83163 6.3444 6.92348 6.72824 5.98971L6.72782 5.98847Z"
                                    fill="white" />
                                  <path
                                    d="M14.5293 6.35889H17.7107V7.94877H14.5293V6.35889ZM14.5293 8.85692H17.7107V10.4468H14.5293V8.85692ZM14.5293 11.355H17.7107V12.9448H14.5293V11.355ZM14.5293 13.853H17.7107V15.4429H14.5293V13.853Z"
                                    fill="#207245" />
                                </svg>
                              </span>
                              <span>Download PDF</span>
                            </a>
                          </div>
                        </div>
                        <div class="download-single-item">
                          <div class="download-single-link">
                            <a href="javascript:void()" class="email-modal-btn">
                              <span>
                                <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <path
                                    d="M10.4296 10.0792L1.02963 4.09717C0.543667 3.77579 0.203353 3.27641 0.0819721 2.70658C-0.0394083 2.13674 0.0678548 1.54203 0.380663 1.0505C0.693472 0.558975 1.1868 0.209957 1.75442 0.0786023C2.32204 -0.052752 2.91855 0.0440657 3.41548 0.348207L10.3118 4.73658L16.5037 0.402133C16.9868 0.0747687 17.5793 -0.0494304 18.1532 0.0563609C18.7271 0.162152 19.2363 0.489443 19.5709 0.967543C19.9055 1.44564 20.0387 2.03618 19.9415 2.61161C19.8444 3.18703 19.5249 3.70116 19.0519 4.04295L10.4296 10.0792Z"
                                    fill="#EA4435" />
                                  <path
                                    d="M18.5185 15.5557H15.5556L15.5556 2.22233C15.5556 1.63296 15.7897 1.06773 16.2064 0.650983C16.6232 0.234235 17.1884 0.000108719 17.7778 0.000108719C18.3671 0.000108719 18.9324 0.234235 19.3491 0.650983C19.7659 1.06773 20 1.63296 20 2.22233V14.0742C20 14.4671 19.8439 14.8439 19.5661 15.1217C19.2883 15.3996 18.9114 15.5557 18.5185 15.5557Z"
                                    fill="#00AC47" />
                                  <path
                                    d="M19.967 1.90036C19.9605 1.85592 19.961 1.81051 19.9517 1.76614C19.9375 1.69814 19.9111 1.63532 19.8908 1.56969C19.8711 1.49458 19.8474 1.42057 19.8198 1.34799C19.805 1.3128 19.7822 1.28192 19.7654 1.24769C19.7193 1.14895 19.6659 1.05375 19.6058 0.962879C19.5762 0.919842 19.5391 0.883175 19.5064 0.842434C19.4502 0.768389 19.3895 0.697907 19.3245 0.631397C19.2753 0.583471 19.2191 0.543397 19.1656 0.500212C19.1087 0.45141 19.0493 0.4055 18.9878 0.362656C18.9291 0.324286 18.8648 0.29473 18.8026 0.26199C18.7371 0.227841 18.673 0.190656 18.6048 0.163397C18.539 0.136878 18.4688 0.11999 18.4 0.0997674C18.3311 0.0795452 18.2627 0.0553229 18.192 0.0422117C18.1045 0.0281484 18.0162 0.0192443 17.9276 0.0155452C17.8714 0.0116193 17.8157 0.00176738 17.7592 0.00221182C17.6544 0.00526585 17.55 0.0157864 17.4467 0.0336933C17.405 0.0399155 17.363 0.039397 17.3216 0.0479896C17.1818 0.0906973 17.0424 0.13465 16.9034 0.179841C16.8653 0.196138 16.8319 0.22036 16.7949 0.23873C16.4188 0.414255 16.1015 0.694969 15.8814 1.04695C15.6614 1.39893 15.548 1.8071 15.555 2.22214V6.49029L19.0513 4.04266C19.3946 3.81223 19.6638 3.48724 19.8263 3.10701C19.9888 2.72677 20.0376 2.3076 19.9668 1.90021L19.967 1.90036Z"
                                    fill="#FFBA00" />
                                  <path
                                    d="M2.22222 0C2.81159 0 3.37682 0.234126 3.79357 0.650874C4.21032 1.06762 4.44444 1.63285 4.44444 2.22222V15.5556H1.48148C1.08857 15.5556 0.711748 15.3995 0.433916 15.1216C0.156084 14.8438 0 14.467 0 14.0741V2.22222C0 1.63285 0.234126 1.06762 0.650874 0.650874C1.06762 0.234126 1.63285 0 2.22222 0Z"
                                    fill="#4285F4" />
                                  <path
                                    d="M0.0334347 1.90039C0.0399533 1.85595 0.0394348 1.81054 0.0486941 1.76617C0.0629163 1.69817 0.0893607 1.63535 0.109657 1.56972C0.129332 1.49463 0.153021 1.42065 0.18062 1.34809C0.195435 1.31291 0.21825 1.28202 0.235138 1.2478C0.281198 1.14902 0.33453 1.05379 0.394694 0.962909C0.424324 0.919872 0.461361 0.883205 0.494101 0.842465C0.550262 0.76842 0.610972 0.697938 0.675879 0.631427C0.725139 0.583501 0.781287 0.543427 0.834916 0.500242C0.891818 0.451421 0.951153 0.40551 1.01269 0.362686C1.07143 0.324316 1.13573 0.29476 1.19788 0.26202C1.2621 0.225692 1.32811 0.192613 1.39566 0.162909C1.46158 0.13639 1.53181 0.119501 1.60055 0.0992791C1.66929 0.0790569 1.73781 0.0548346 1.80847 0.0417235C1.89602 0.0276638 1.98432 0.0187598 2.07292 0.015057C2.12921 0.011131 2.18484 0.0012791 2.24129 0.00172354C2.34608 0.0047738 2.45051 0.0152943 2.55381 0.033205C2.59551 0.0394273 2.63751 0.0389087 2.67899 0.0475013C2.75069 0.0657711 2.8214 0.0877262 2.89084 0.113279C2.96067 0.131839 3.02952 0.153892 3.09714 0.179353C3.13521 0.195649 3.16862 0.219872 3.20566 0.238242C3.30168 0.283353 3.39431 0.33534 3.48284 0.393798C3.77961 0.597567 4.02232 0.870509 4.19001 1.18906C4.35771 1.5076 4.44534 1.86218 4.44536 2.22217V6.49032L0.949064 4.04283C0.605788 3.81235 0.336632 3.48735 0.174139 3.10714C0.0116463 2.72693 -0.0372248 2.30779 0.0334347 1.90039Z"
                                    fill="#C52528" />
                                </svg>
                              </span>
                              <span>Email This</span>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
           
                       
                    
                    <div class="analysis-score container-health-score">
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

          <!-- Control Hide Show -->
          <div class="control-hide-show">
            <div class="control-hide ${dataFailed.length == 0 ? "d-none": ""}"  >
              <button id="hidePassed" class="btn_toggle_show rounded-pill">
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
        </div>
    `
    document.querySelector(".analysis-content-body").prepend(div)

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
