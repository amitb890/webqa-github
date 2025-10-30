$(document).ready(function () {

  if(document.getElementById('modalCustomizer')){
    var modalCustomizer = new bootstrap.Modal(document.getElementById('modalCustomizer'), {
      keyboard: false
    })
  }
  
  // new
  updateSidebarSettingsLink()
  updateSliders()
  $(".dropdown-menu-projects").click(function (e) {
    const target = e.target.closest(".select-project")
    if(target.classList.contains("select-project")){
      selectProject(e, target)
      updateSidebarSettingsLink()
      updateSettings()
    }
  });

  function updateSidebarSettingsLink(){
    if(document.querySelector("#activeProject")){
      const projectId = getStringPart(document.querySelector("#activeProject").getAttribute("data-val"), "-", 1)
      const href =  `${new URL(window.location.href).origin}/settings/${projectId}/edit`;
      $("#sidebarSettingsLink").attr("href", href)
      $(".settignSidebarLink").attr("href", href)
    }
  }


  function updateSettings(){ 
    // Get the current URL
       const currentUrl = window.location.href;

       // Define a regular expression to match 'settings/{id}/edit'
       const regex = /settings\/\d+\/edit/;

       // Check if the URL matches the pattern
       if (regex.test(currentUrl)) {
         const projectId = getStringPart(document.querySelector("#activeProject").getAttribute("data-val"), "-", 1)

         const hrefSettings =  `${new URL(window.location.href).origin}/settings/${projectId}/edit`;
         window.location.href = hrefSettings;

         // Add your conditional logic here
       } else {
           console.log("The URL does not match the pattern.");
       }

 }


 function selectProject(e, _this){
  const active = $("#activeProject");
  const activeVal = active.attr("data-val");
  const activeName = active.attr("data-name");
  const activeFavicon = active.attr("data-favicon");

  const projectVal = $(_this).attr("data-val")
  const projectName = $(_this).attr("data-name")
  const projectFavicon = $(_this).attr("data-favicon")

  const a = document.createElement("a")
  a.classList.add("dropdown-item")
  a.classList.add("select-project")
  a.setAttribute("data-name", activeName)
  a.setAttribute("data-val", activeVal)
  a.setAttribute("data-favicon", activeFavicon)
  a.innerHTML = `
  <img src="${activeFavicon}" alt="icon">
  ${activeName}
  `

  const aActive = document.createElement("span")
  aActive.id="activeProject"
  aActive.classList.add("d-none")
  aActive.classList.add("d-sm-inline")
  aActive.setAttribute("data-name", projectName)
  aActive.setAttribute("data-val", projectVal)
  aActive.setAttribute("data-favicon", projectFavicon)
  aActive.innerHTML = `
  ${projectName}
  `


  active[0].parentNode.replaceChild(aActive, active[0]);
  _this.parentNode.replaceChild(a, _this);
  $("#activeFavicon").attr("src", projectFavicon);
  $(`[data-val='${activeVal}']`)[0].querySelector("img").setAttribute("src", activeFavicon)
  setCookie('activeProject',projectVal,7);
  setCookie('activeProjectName',projectName,7);
  setCookie('activeProjectFavicon',projectFavicon,7);

  const myToast = new Toast("Switched project to <b>" + getCookie('activeProjectName') + "</b>");
  myToast.display();
  //   e.preventDefault()
  // }
  $('.toast').attr('style', 'border-color: green !important; color: green !important; background-color: #abffab !important;');
//   setTimeout(function(){
//     // Replace "yourAttribute" with the attribute you want to remove
//     $(".toast").removeAttr("style");
// }, 5000); 
e.preventDefault()
}

function displayAlertSwithProject(classVal, data){
  $('.analysis-content-body-switch-project').show();
  const div = buildAlert(data)
  $(`${classVal}`)[0].prepend(div)
  $(".alert").fadeTo(3000, 5000).slideUp(5000, function() {
      $(".alert").slideUp(5000);
      $(".alert").remove();
      $('.analysis-content-body-switch-project').hide()
  });
}


  if(document.querySelectorAll('.category-header')){
    document.querySelectorAll('.category-header').forEach(header => {
      const targetId = header.getAttribute('data-bs-target');
      const icon = header.querySelector('.toggle-icon');
      const collapseEl = document.querySelector(targetId);
      const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseEl, { toggle: false });

      collapseEl.addEventListener('show.bs.collapse', () => {
        icon.textContent = '−';
      });

      collapseEl.addEventListener('hide.bs.collapse', () => {
        icon.textContent = '+';
      });

      // Initialize icon state
      if (collapseEl.classList.contains('show')) {
        icon.textContent = '−';
      } else {
        icon.textContent = '+';
      }
    });
  }


  // Sidebar Js
  $(".collaps_sidebar").click(function () {
    $(".side_content").slideToggle(function () {
      $(".collaps_sidebar").toggleClass("rotate");
      if ($(window).width() > 991) {
        $(".footer-area").toggleClass("small");
      }
    });
    $('.settingsCollapse').collapse('hide');
  });


  // Element JS
  $(".customize_test").click(function () {
    modalCustomizer.toggle()
    scrollToTop()
  });

  // Handle close click
  $('#modalCustomizer .btn-close').click(function () {
    modalCustomizer.hide()
  })

  // home Page Js Start
  $("#settingBtn").click(function () {
    toggleHomePageSettingsArea()
  });
  // home Page Js End

  // Blog Page Js Start
  $("#blog_menuBtn").click(function () {
    $(".blog-menu nav>ul").slideToggle();
  });
  // Blog Page Js End

  // Project Page JS
  
  $(".sitemap_input_btn").click(function () {
    $(this).closest("li").remove(); 
  });


  // Tricker page start js
  $(".search_advance_click").click(function () {
    $(".advance-search").show();
    $(this).slideToggle();
  });
  // Table Menu
  $("#menuBtn2").click(function () {
    $(".main-menu-right").slideToggle();
    // $(this).slideToggle();
  });

  // Header Menu
  $("#header_menuBtn").click(function () {
    $(".genarel_header_items").slideToggle();
  });


  // tracker-advance-search
  $(".tracker-advance-search h6").click(function () {
    $(this).toggleClass("active");
    $(".advance-arrow").toggleClass("active");
  });
  // Tricker Success Alert js
  $(".tracker-success-icon").click(function () {
    $(".success-section").hide();
  });
  // tracker-advance-hide
  $(".advance-crose").click(function () {
    $(".tracker-advance-search").hide();
  });
  // toggle search box
  $(".search_box_icon").click(function () {
    $(".search_box").toggleClass("show");
  });
  // Tricker page end js

  if ($(window).width() < 992) {
    $(document).click(function (event) {
      // toggle search box
      const showSearch =
        event.target.closest(".search_box") ||
        event.target.closest(".search_box_icon");
      if (!showSearch) {
        $(".search_box").removeClass("show");
      }

      // toggle sidebar menu
      const showSidebar =
        event.target.closest(".sidebar") || event.target.closest("#menuBtn");
      if (!showSidebar) {
        $(".sidebar").removeClass("show");
      }
    });
  }

  // adjust main sections top padding
  $(".main-sections").css("paddingBlock", `${$("#headerMain").height()}px`);

  $(window).on("resize", function () {
    // adjust main sections top padding
    $(".main-sections").css("paddingBlock", `${$("#headerMain").height()}px`);
  });

  // toggle menu
  $("#menuBtn").click(function () {
    $(".sidebar").toggleClass("show");
  });

  // Setting page Start
  // Range JQuery
  // 1st range

  // setting range value
  function getSliderValue(slider, target) {
    $(slider).on("slide", function (slideEvt) {
      $(target).val(slideEvt.value);
    });
  }

  function setSliderValue(slider, target) {
    $(slider).slider("setValue", $(target).val());
  }

  $(".slider-input").on("change", function(){
    const textInput = this.parentElement.previousElementSibling != null ? this.parentElement.previousElementSibling.parentElement.querySelector("input[type='number']") : this.parentElement.parentElement.querySelector("input[type='number']")
    getSliderValue(this, textInput);
  })

  $(".slider-input-text").on("change", function(){
    let textInput
    if(this.parentElement.parentElement.querySelector(".slider-range") || this.parentElement.parentElement.nextElementSibling){
      textInput = this.parentElement.parentElement.nextElementSibling != null ? this.parentElement.parentElement.nextElementSibling.querySelector("input") : this.parentElement.parentElement.querySelector(".slider-range").querySelector("input")
    }else{
      textInput = this.parentElement.parentElement.parentElement.querySelector(".slider-range").querySelector("input")
    }
    setSliderValue(`#${textInput.id}`, this);
  })



  // Analysis page start
  // mail-report-modal
  $("#mail1").click(function () {
    $("#anayslis-report-icon1").hide();
  });
  $("#mail2").click(function () {
    $("#anayslis-report-icon2").hide();
  });
  $("#mail3").click(function () {
    $("#anayslis-report-icon3").hide();
  });
  $("#mail4").click(function () {
    $("#anayslis-report-icon4").hide();
  });
  $("#mail5").click(function () {
    $("#anayslis-report-icon5").hide();
  });
  $("#mail6").click(function () {
    $("#anayslis-report-icon6").hide();
  });
  $("#mail7").click(function () {
    $("#anayslis-report-icon7").hide();
  });
  $("#mail8").click(function () {
    $("#anayslis-report-icon8").hide();
  });
  $("#mail9").click(function () {
    $("#anayslis-report-icon9").hide();
  });


  if (typeof radialProgress !== "undefined") {
    // Failed-circle
    jQuery(".progress-failed")
      .radialProgress("init", {
        size: 70,
        fill: 8,
        "font-family": "450",
        "font-size": "22",
        "text-color": "var(--black)",
        background: "rgba(250, 84, 87, 0.05)",
        color: "var(--text-orange-red)",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 8, time: 2000 });

    // Warning-circle
    jQuery(".progress-warning")
      .radialProgress("init", {
        size: 80,
        fill: 8,
        "font-family": "450",
        "font-size": "22",
        "text-color": "var(--black)",
        background: "rgba(252, 123, 16, 0.05)",
        color: "#fc7b10",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 2, time: 2000 });

    // Passed-circle
    jQuery(".progress-passed")
      .radialProgress("init", {
        size: 70,
        fill: 8,
        "font-family": "450",
        "font-size": "22",
        "text-color": "var(--black)",
        background: "rgba(128, 174, 53, 0.05)",
        color: "var(--text-lime-deep)",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 49, time: 3000 });

    // Performance-circle
    jQuery("#performance-circle")
      .radialProgress("init", {
        size: 120,
        fill: 8,
        "font-family": "450",
        "font-size": "40",
        "text-color": "#64B240",
        background: "rgba(128, 174, 53, 0.05)",
        color: "#64B240",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 98, time: 3000 });

    // Performance-circle2
    jQuery("#performance-circle2")
      .radialProgress("init", {
        size: 120,
        fill: 8,
        "font-family": "450",
        "font-size": "40",
        "text-color": "#ECA059",
        background: "#FAF8E9",
        color: "#ECA059",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 70, time: 3000 });

    // Performance-circle2
    jQuery("#performance-circle3")
      .radialProgress("init", {
        size: 120,
        fill: 8,
        "font-family": "450",
        "font-size": "40",
        "text-color": "#E52F34",
        background: "#FAE9E9",
        color: "#E52F34",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 30, time: 3000 });

    // lighthouse-performance
    jQuery("#lighthouse-performance")
      .radialProgress("init", {
        size: 80,
        fill: 5,
        "font-family": "450",
        "font-size": "28",
        "text-color": "#ECA059",
        background: "#FAF8E9",
        color: "#ECA059",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 57, time: 3000 });

    // lighthouse-accessibility
    jQuery("#lighthouse-accessibility")
      .radialProgress("init", {
        size: 80,
        fill: 5,
        "font-family": "450",
        "font-size": "25",
        "text-color": "#ECA059",
        background: "#FAF8E9",
        color: "#ECA059",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 87, time: 3000 });

    // lighthouse-best
    jQuery("#lighthouse-best")
      .radialProgress("init", {
        size: 80,
        fill: 5,
        "font-family": "450",
        "font-size": "25",
        "text-color": "#ECA059",
        background: "#FAF8E9",
        color: "#ECA059",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 97, time: 3000 });

    // lighthouse-eso
    jQuery("#lighthouse-eso")
      .radialProgress("init", {
        size: 80,
        fill: 5,
        "font-family": "450",
        "font-size": "25",
        "text-color": "#64B240",
        background: "#FAF8E9",
        color: "#64B240",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 90, time: 3000 });

    // lighthouse-performance2
    jQuery("#lighthouse-performance2")
      .radialProgress("init", {
        size: 80,
        fill: 5,
        "font-family": "450",
        "font-size": "28",
        "text-color": "#ECA059",
        background: "#FAF8E9",
        color: "#ECA059",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 57, time: 3000 });

    // lighthouse-accessibility2
    jQuery("#lighthouse-accessibility2")
      .radialProgress("init", {
        size: 80,
        fill: 5,
        "font-family": "450",
        "font-size": "25",
        "text-color": "#ECA059",
        background: "#FAF8E9",
        color: "#ECA059",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 87, time: 3000 });

    // lighthouse-best2
    jQuery("#lighthouse-best2")
      .radialProgress("init", {
        size: 80,
        fill: 5,
        "font-family": "450",
        "font-size": "25",
        "text-color": "#ECA059",
        background: "#FAF8E9",
        color: "#ECA059",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 97, time: 3000 });

    // lighthouse-eso2
    jQuery("#lighthouse-eso2")
      .radialProgress("init", {
        size: 80,
        fill: 5,
        "font-family": "450",
        "font-size": "25",
        "text-color": "#64B240",
        background: "#FAF8E9",
        color: "#64B240",
        range: [0, 100],
      })
      .radialProgress("to", { perc: 90, time: 3000 });
  }

  function multistepForm() {
    let step = 1;

    function prevImg() {
      step = step - 1;
      $("#onboardingImg").attr(
        "src",
        `/new-assets/assets/images/onboarding-img-${step}.png`
      );
    }


    function updateSitemapInputs(){
      const websiteAddress = removeTrailingSlash($("#homepage").val())
      $("#xmlSitemap").val(getSitemapAddress("xml", websiteAddress))
      $("#htmlSitemap").val(getSitemapAddress("html", websiteAddress))
    }
    function updateSitemapInputsServer(xmlSitemap, url){
      $(".sitemap-link").remove()
      $(".load-more-sitemap").remove()

      
      const websiteAddress = removeTrailingSlash($("#homepage").val())
      $('xml-sitemap-message').empty()
      $('.form-single-text').hide()
      if (xmlSitemap.length == 0) {
        $(".form-single-text").addClass("warning")
        $('.xml-sitemap-message').text("We could not autodetect an XML Sitemap on your website. Please enter your XML Sitemap in 'Enter Sitemap XML field'")
        $('.form-single-text').css({display: "flex"})
    
      } else {
        const sitemapJson = JSON.stringify(xmlSitemap);
        $("#xmlSitemap").val(xmlSitemap[0])
        let msg
        xmlSitemap.length > 1 ? msg = `We have autodetected ${xmlSitemap.length} XML Sitemaps on your website at` : msg = "We have autodetected an XML Sitemap on your website at"
        $(".form-single-text").removeClass("success")
        $(".form-single-text").removeClass("warning")
        $('.xml-sitemap-message').html(msg);

        $('.form-single-text').css({display: "flex"})
        if(xmlSitemap.length > 4){
          $.each(xmlSitemap, function(index, value) {
            if(index > 3){
              $('.form-single-text').append('<a class="sitemap-link d-none" target="_blank" href="' + value + '">' + value + '</a>');
            }else{
              $('.form-single-text').append('<a class="sitemap-link" target="_blank" href="' + value + '">' + value + '</a>');
            }
          });

          const div = document.createElement("div")
          div.classList.add("load-more-sitemap")
          div.innerHTML = `<a class="dropdown-toggle load-more-sitemap-dropdown" href="#" role="button">
          <span>Load All</span>
          </a>`

          $('.form-single-text').append(div);


        }else{
          $.each(xmlSitemap, function(index, value) {
            $('.form-single-text').append('<a  class="sitemap-link" target="_blank" href="' + value + '">' + value + '</a>');
          });
        }
        $('#sitemapInput').val(sitemapJson);

      }
      
      // $("#htmlSitemap").val(getSitemapAddress("html", websiteAddress))
    }

    function updateProjectName(){
      const name = $("#name").val()
      $("#projectName").html(name)
    }

    function getUrlsList(){
      $("#urlsList").html("")
      const xmlSitemap = $("#xmlSitemap").val()
      if (xmlSitemap == "") {
        $("#urlsList").html($('#homepage').val());
        $(".sitemap-loader").remove()
        return;
      }
      const multipleSitemap = $("#sitemapInput").val()
      const data = {
        sitemapContent: 1,
        urlValue: xmlSitemap, 
        xmlSitemap: xmlSitemap, 
        content: xmlSitemap, 
        multipleSitemap: multipleSitemap,
      }
        $.ajax({
          url : `/test/xml-sitemap-multiple`,
          type : 'POST',
          data: {
              data: data,
              "_method": 'POST',
              "_token": $('meta[name="csrf-token"]').attr('content'),
          },       
          success : function(data) {
            data = JSON.parse(data)
            if(data.xmldata != ""){
              if(data.xmldata.length > 0){
                let list = "";
                data.xmldata.forEach((url, i)=>{
                  list+= i === data.xmldata.length-1 ? url.trim() : url.trim() + "\n"
                })
                $("#urlsList").html(list)
                $(".form-single-text").addClass("success")
                $('.xml-sitemap-message').html('Detected ' + data.xmldata.length + ' URLs from the XML Sitemap');
                $('.form-single-text').show()
                $(".sitemap-link").remove()
                $(".load-more-sitemap").remove()

              } else {
                $("#urlsList").html($('#homepage').val());
                $('.xml-sitemap-message').text('We were not able to detect any URLs on the website, you can add the URLs manually.')
              }

            }
            $(".sitemap-loader").remove()

          },
          error: function (error) {
            $('.xml-sitemap-message').text('We were not able to detect any URLs on the website, you can add the URLs manually.')
            $(".sitemap-loader").remove()
        }
        });
     
    }
    
    function updateUrlsList(urls){
      let list = "";
      urls.forEach((url, i)=>{
        list+= i === urls.length-1 ? url.loc : url.loc + "\n"
      })
      $("#urlsList").html(list)
    }

    function nextImg() {
      step = step + 1;
      $("#onboardingImg").attr(
        "src",
        `/new-assets/assets/images/onboarding-img-${step}.png`
      );
    }

    function buildSitemapLoader(){
      const div = document.createElement("div")
      div.classList.add("sitemap-loader")
      div.innerHTML = `
      <img src="/new-assets/assets/images/sitemap-loader.gif" />
      <span>Extracting URLS....</span>
      `
      document.querySelector(".urls-list-container").appendChild(div)
    }

    

    function validateOnboarding(nameVal){
      clearAlertsNew()
      const input = document.querySelector(".form-setp.active input,.form-setp.active textarea")
      const inputName = input.getAttribute("data-name")

      switch(nameVal){
        case "homepageVal":
          if(input.value === ""){
            const alert = buildAlertNew(`${inputName} can not be empty`)
            input.parentElement.appendChild(alert)
            return false
          }

          // Auto-prepend https://www. if needed
          const formattedUrl = formatHomepageUrl(input.value);
          if (formattedUrl !== input.value) {
            input.value = formattedUrl;
          }

          if(!isValidURL(input.value)){
            let msgInvalid = `${input.value} is an incorrect URL format, please enter the URL in the correct format and try again.`
            const alert = buildAlertNew(msgInvalid)
            input.parentElement.appendChild(alert)
            return false
          }
          break;

          case "projectName":
          if(input.value === ""){
            const alert = buildAlertNew(`${inputName} can not be empty`)
            input.parentElement.appendChild(alert)
            return false
          }

          if(hasSpecialCharacters(input.value)){
            const alert = buildAlertNew(`${inputName} can not have special characters`)
            input.parentElement.appendChild(alert)
            return false
          }

          if(!hasAlphabets(input.value)){
            const alert = buildAlertNew(`${inputName} is in incorrect format. Please try adding some alphabets.`)
            input.parentElement.appendChild(alert)
            return false
          }

    
          break;

          case "sitemapVal":
          if(input.value != ""){
            if(!isValidURL(input.value)){
              let msgInvalid = `${input.value} is an incorrect URL format, please enter the URL in the correct format and try again.`
              const alert = buildAlertNew(msgInvalid)
              input.parentElement.appendChild(alert)
              return false
            }else{
              const websiteAddress = removeTrailingSlash($("#homepage").val())
              const websiteHost = new URL(websiteAddress).host
              const sitemapHost = new URL(input.value).host

              if(websiteHost != sitemapHost){
                let msgInvalid = `This URL does not exist in the website address - ${websiteAddress}. Please enter a URL from the website - <a href="${websiteAddress}">${websiteAddress}</a>`
                const alert = buildAlertNew(msgInvalid)
                input.parentElement.appendChild(alert)
                return false
              }
            }
          }
          break;
      }

      return true
    }

    function formatHomepageUrl(url) {
      // Remove any existing protocol and www
      let cleanUrl = url.trim().toLowerCase();
      
      // If it already has a protocol, return as is
      if (cleanUrl.startsWith('http://') || cleanUrl.startsWith('https://')) {
        return cleanUrl;
      }
      
      // If it starts with www., add https://
      if (cleanUrl.startsWith('www.')) {
        return 'https://' + cleanUrl;
      }
      
      // Otherwise, add https://www.
      return 'https://www.' + cleanUrl;
    }

    async function checkValidURLOnbording() {
      var urlValue = $('#homepage').val();
      var isValid = false;
      // Wrap the AJAX call in a Promise
       await  $.ajax({
              type: 'POST',
              url: '/check-valid-url',
              data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                  url: urlValue
              },
              success: function (data) {
                  if(data.valid) {
                    $(".form-setp").removeClass("active");
                    $("#formSetp2").addClass("active");
                    $(".form-slider-range .progress-line").width("25%");
                    $(".progress-dot.two").addClass("active");
                    $('#homepage').val(data.redirectedUrl)
                    nextImg();
                    updateSitemapInputsServer(data.firstXmlUrl, data.redirectedUrl)
                    getFormattedName(data.redirectedUrl)
                  } else {
                    const alert = buildAlertNew(`This URL does not exist, Please enter valid URL.`);
                    $('#homepage').after(alert);
                  }
              },
              error: function (error) {
                  var result1 = false;
              }
          });
          return isValid;
  }

  async function checkValidSitemapOnbording() {
    var urlValue = $('#xmlSitemap').val();
    if(urlValue == "") {
      sitemapNext()
      return;
    }
    var isValid = false;
    // Wrap the AJAX call in a Promise
     await  $.ajax({
            type: 'POST',
            url: '/check-valid-url',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                url: urlValue,
                sitemap: true
            },
            success: function (data) {
                if(data.valid) {
                  if(data.sitemap) {
                    sitemapNext()
                    $('.form-single-text').hide()

                  } else {
                    const alert = buildAlertNew(`The URL you entered is not an XML Sitemap.`);
                  $('#xmlSitemap').after(alert);
                  }
                } else {
                  const alert = buildAlertNew(`This URL does not exist, Please enter valid URL.`);
                  $('#xmlSitemap').after(alert);
                }
            },
            error: function (error) {
                var result1 = false;
            }
        });
        return isValid;
}
  function sitemapNext() { 
    $(".form-setp").removeClass("active");
    $("#formSetp3").addClass("active");
    $(".form-slider-range .progress-line").width("50%");
    $(".progress-dot.three").addClass("active");
    nextImg();
  }
  

  function toggleContent(id) {
    const row = document.getElementById(id);
    const isShown = row.classList.contains('show');
    row.classList.toggle('show');

    const toggleBtn = row.previousElementSibling.querySelector('.collapsible');
    toggleBtn.textContent = isShown ? 'Show' : 'Hide';
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

    
  
    
    
    
    

    $("#formTriggerBtn1").click(function () {
      if(validateOnboarding("homepageVal")){
        checkValidURLOnbording()
      }
    });
    $("#formTriggerBtn2, #BtnSkip1").click(function () {
      if(validateOnboarding("sitemapVal")){
        checkValidSitemapOnbording()
        
      }
    });
    $("#formTriggerBtn3, #BtnSkip2").click(function () {
      if(validateOnboarding("sitemapVal")){
        $('.form-single-text').hide()
        $(".form-setp").removeClass("active");
        $("#formSetp4").addClass("active");
        $(".form-slider-range .progress-line").width("75%");
        $(".progress-dot.four").addClass("active");
        $("#urlsList").html("")
        buildSitemapLoader()
        window.setTimeout(function(){
          getUrlsList()
        }, 1000)
        nextImg();
      }
    });
    $("#formTriggerBtn4, #BtnSkip3").click(function () {
      if(validateOnboarding("urlList")){
        $('.form-single-text').hide()
        $(".form-setp").removeClass("active");
        $("#formSetp5").addClass("active");
        $(".form-slider-range .progress-line").width("100%");
        $(".progress-dot.five").addClass("active");
        nextImg();
      }
    });
    $("#formTriggerBtn5").click(function () {
      if(validateOnboarding("projectName")){
        $(".form-setp").removeClass("active");
        $("#formSetp6").addClass("active");
        updateProjectName()
        nextImg();
      }
    });
    $("#BtnPrev1").click(function () {
      $('.form-single-text').hide()
      $(".form-setp").removeClass("active");
      $("#formSetp1").addClass("active");
      $(".progress-dot.two").removeClass("active");
      $(".form-slider-range .progress-line").width("0%");
      prevImg();
    });
    $("#BtnPrev2").click(function () {
      $(".form-setp").removeClass("active");
      $("#formSetp2").addClass("active");
      $(".progress-dot.three").removeClass("active");
      $(".form-slider-range .progress-line").width("25%");
      prevImg();
    });
    $("#BtnPrev3").click(function () {
      $('.form-single-text').hide()
      $(".form-setp").removeClass("active");
      $("#formSetp3").addClass("active");
      $(".progress-dot.four").removeClass("active");
      $(".form-slider-range .progress-line").width("50%");
      prevImg();
    });
    $("#BtnPrev4").click(function () {
      $(".form-setp").removeClass("active");
      $("#formSetp4").addClass("active");
      $(".progress-dot.five").removeClass("active");
      $(".form-slider-range .progress-line").width("75%");
      prevImg();
    });
    $(".onbordingButtonClass").click(function () {
    });


    $("#finishOnboarding").click(function (e) {
        const route = "onboarding";
        const name = $("#name")
        const homepage = $("#homepage")
        const xmlSitemap = $("#xmlSitemap")
        const htmlSitemap = $("#htmlSitemap")
        const urlsList = $("#urlsList")
        $.ajax({
            url : `/createProject`,
            type : 'POST',
            data: {
                "name": name.val(),
                "homepage": homepage.val(),
                "xmlSitemap": xmlSitemap.val(),
                "htmlSitemap": htmlSitemap.val(),
                "urlsList": urlsList.val(),
                "route": route, 
                "_method": 'POST',
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },       
            success : function(data) {
              if(route === "projects.create"){
                  clearValues([name, homepage, urlsList])
                  displayAlert(data)
                  scrollToTop()
              }else{
                  window.location = "/dashboard"
              }
            }
        });
        e.preventDefault();
    });
  }
  multistepForm();

  $(".profile-single-input input").on("input", function () {
    if ($(this).val().length > 0) {
      $(this).closest(".profile-single-input").find(".show-pass-btn").fadeIn();
      return;
    }
    $(".show-pass-btn").fadeOut();
  });

  $(".show-pass-btn").fadeOut();

  $(".show-pass-btn").click(function () {
    const passwordField = $(this)
      .closest(".profile-single-input")
      .find("input");

    if ($(this).find("i").hasClass("fa-eye")) {
      $(this).find("i").removeClass("fa-eye");
      $(this).find("i").addClass("fa-eye-slash");
    } else {
      $(this).find("i").removeClass("fa-eye-slash");
      $(this).find("i").addClass("fa-eye");
    }
    if (passwordField.attr("type") === "password") {
      passwordField.attr("type", "text");
    } else {
      passwordField.attr("type", "password");
    }
  });

 

  // Analysis page end
  if (typeof d3 !== "undefined") {
    // For Setting Page
    // switch button
    var color = d3.scale
      .linear()
      .domain(range)
      .range(["#930F16", "#F0F0D0", "#228B22"]);
    // Setting page end
  }

  // off canvas menu
  const navSidebar = document.getElementById("ideaSidenav");
  function openNav() {
    navSidebar.style.width = "372px";
  }
  function closeNav() {
    navSidebar.style.width = "0";
  }
  window.onclick = function (event) {
    if (event.target == navSidebar) {
      navSidebar.style.width = "0";
      alert("Hello");
    }


  };

  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (() => {
    "use strict";

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll(".needs-validation");

    // Loop over them and prevent submission
    Array.from(forms).forEach((form) => {
      form.addEventListener(
        "submit",
        (event) => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }

          form.classList.add("was-validated");
        },
        false
      );
    });
  })();

 

  $(".accor-single-item.active .accor-body").slideDown();

  $(".accor-single-item .accor-title-btn").click(function () {
    if ($(this).closest(".accor-single-item").hasClass("active")) {
      $(this).closest(".accor-single-item").removeClass("active");
      $(this).closest(".accor-single-item").find(".accor-body").slideUp();
      return;
    }

    $(".accor-single-item").removeClass("active");
    $(".accor-single-item .accor-body").slideUp();
    $(this).closest(".accor-single-item").addClass("active");
    $(this).closest(".accor-single-item").find(".accor-body").slideDown();
  });

  $(".sidebar_menu__top .sidebar_menu__item:last-child").click(function () {
    $(".setting-menu-area").toggleClass("hide");
  });
  function toggleSettingsBar() {
    if ($(window).width() > 991) {
      $(".setting-menu-area").removeClass("hide");
    } else {
      $(".setting-menu-area").addClass("hide");
    }
  }
  toggleSettingsBar();
  $(window).on("resize", function () {
    toggleSettingsBar();
  });

  $(".progress .progress-bar").css("width", function () {
    $(this).text($(this).attr("aria-valuenow") + "%");
    return $(this).attr("aria-valuenow") + "%";
  });
  $(".progress .loader-progress-range").css("width", function () {
    $(this).text($(this).attr("title") + " ");
    return $(this).attr("title") + " ";
  });

  $(".progress .tricker-progress").css("width", function () {
    $(this).text($(this).attr("title") + " ");
    return $(this).attr("title") + " ";
  });

  


  // showhide btn
  $(".showhide-btn").click(function () {
    $(this).closest(".card-header").toggleClass("rounded-lg");
  });

  // $('.test-popup-link').magnificPopup({
  //   type: 'iframe',
  //   // other options
  // });




  // showhide btn
  $(".showhide-btn").click(function () {
    $(this).closest(".card-header").toggleClass("rounded-lg");
  });

  // Setting Tab Content
  $(".tav-menu-btn").click(function () {
    $(this).toggleClass("active");
    $(".home-setting-area").toggleClass("active");
    $(".home-setting-tab-content").toggleClass("active");
  });


  // analysis sidebar nice select js
  if($("#select_option").length > 0){
    $('#select_option').niceSelect();
  }
});
// Tracker Page Tooltip
const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);



/* Newly added JS*/

// video home page

function playVideo() {
  var playerDiv = document.getElementById("player");
  var thumbnail = document.querySelector(".video-wrapper img");

  // Replace 'VIDEO_ID' with your YouTube video ID
  playerDiv.innerHTML =
    '<iframe src="https://www.youtube.com/embed/-pvOlJWoDn8?si=rzWh2GFUHA1h2TWG1" frameborder="0" allowfullscreen></iframe>';

  thumbnail.style.display = "none";
  playerDiv.style.display = "block";
}

$(function () {
  $(".dropdown").on("click", function () {
    $(".tracker-table tr > *:first-child").css({
      "z-index": 0,
    });

    $(this).closest("th, td").css({
      "z-index": 1,
    });
  });
});

/* ====================Feedback==================== */
$(function () {
  const options = {
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
        //console.log('...resizing...');
      },
      onResizeEnd: function (column, columns) {
        //console.log('...resize end...');
        // console.log(column);
        // console.log(columns);
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
    info: false,
    ordering: false,
    paging: false,
    autoWidth: false,
    fixedColumns: {
      leftColumns: 1,
    },
    // responsive: true,
    select: {
      style: "multi",
      selector: "td:first-child .form-check-input",
    },
  };

  
  $(".left-menu-check .form-check-input").on("change", function () {
    // Get the state of the "All" checkbox
    var isChecked = $(this).prop("checked");

    // Set the state of all individual checkboxes based on the "All" checkbox
    $("td:first-child .form-check-input").prop("checked", isChecked);

    // Update DataTables selection
    table.rows().select(isChecked);
  });

  $(".form-single-text").on("click", function (e) {
    if(e.target.classList.contains("load-more-sitemap-dropdown")){
      $(".sitemap-link").removeClass("d-none")
      $(".load-more-sitemap span").html("Collapse")
      const el = $(".load-more-sitemap-dropdown")
      el.addClass("collapse-more-sitemap-dropdown")
      el.removeClass("load-more-sitemap-dropdown")

    }else if(e.target.classList.contains("collapse-more-sitemap-dropdown")){
      document.querySelectorAll(".sitemap-link").forEach((el, i)=>{
        if(i > 3){
          el.classList.add("d-none")
        }
      })
      $(".load-more-sitemap span").html("Load All")
      const el = $(".collapse-more-sitemap-dropdown")
      el.removeClass("collapse-more-sitemap-dropdown")
      el.addClass("load-more-sitemap-dropdown")
    }

    e.preventDefault()
  })
  

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
            src="assets/images/table-collapse.png"
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

  $(".t-search-url input").on("input", function () {
    table.search($(this).val()).draw();
  });
});
/* ====================Feedback==================== */





// sidebar collaps js 
$(".sibar_collaps2").click(function () {
  $(".sidebar_menu.sidebar_menu2").toggleClass('sidebar_active');
});



// IMRANS CODE

// About Page FAQs, question dropdown
function aboutUsFaqFunctionality(){
  document.querySelectorAll(".as6-card").forEach((card) => {
  card.addEventListener("click", function () {
    const toggle = card.querySelector(".as6-card-toggle");
    const arrow  = card.querySelector(".as6-card-question img");

    // Toggle active class directly on the card
    card.classList.toggle("active");

    // Change arrow source smoothly
    if (card.classList.contains("active")) {
      arrow.src = "../new-assets/assets/images/aboutUs/up-arrow.svg";
    } else {
      arrow.src = "../new-assets/assets/images/aboutUs/down-arrow.svg";
    }
  });
});

document.querySelectorAll(".as6-card").forEach((card) => {
  card.addEventListener("click", function () {
    const heading = card.querySelector(".as6-card-question h5");

    if (heading.style.color === "rgb(43, 86, 165)") { 
      // reset styles
      heading.style.color = "";
      card.style.background = "";
    } else {
      // apply styles
      heading.style.color = "#2b56a5";
      card.style.background = "#f1f4f9";
    }
  });
});
}
aboutUsFaqFunctionality();


// About Page carousel, functionality
function aboutUsCarouselFunctionality(){
const cardsContainer = document.querySelector(".as5-cards");
  const leftBtn = document.querySelector(".as5-bottom1");
  const rightBtn = document.querySelector(".as5-bottom2");
  if (!cardsContainer || !leftBtn || !rightBtn) return;

  const cards = cardsContainer.querySelectorAll(".as5-card");
  if (!cards.length) return;

  const firstCard = cards[0];
  const lastCard = cards[cards.length - 1];

  // helper to update UI and store disabled state on the element
  function applyUI({ leftDisabled, rightDisabled }) {
    if (leftDisabled) {
      leftBtn.style.background = "#e4e4e4";
      leftBtn.style.cursor = "not-allowed";
      leftBtn.dataset.disabled = "true";
    } else {
      leftBtn.style.background = "#2b56a5";
      leftBtn.style.cursor = "pointer";
      leftBtn.dataset.disabled = "false";
    }

    if (rightDisabled) {
      rightBtn.style.background = "#e4e4e4";
      rightBtn.style.cursor = "not-allowed";
      rightBtn.dataset.disabled = "true";
    } else {
      rightBtn.style.background = "#2b56a5";
      rightBtn.style.cursor = "pointer";
      rightBtn.dataset.disabled = "false";
    }
  }

  function isScrollable() {
    // returns true if there's actually overflow to scroll
    return cardsContainer.scrollWidth > cardsContainer.clientWidth + 1;
  }

  // compute card step (card width + gap)
  function getStep() {
    if (cards.length > 1) {
      return cards[1].offsetLeft - cards[0].offsetLeft;
    }
    const gapStr = getComputedStyle(cardsContainer).gap || "0";
    const gap = parseFloat(gapStr) || 0;
    return cards[0].offsetWidth + gap;
  }
  let step = getStep();

  // Fallback update using scrollLeft (if IntersectionObserver not available)
  function updateByScroll() {
    const maxScroll = Math.max(0, cardsContainer.scrollWidth - cardsContainer.clientWidth);
    const scrollPos = Math.round(cardsContainer.scrollLeft);

    if (!isScrollable()) {
      applyUI({ leftDisabled: true, rightDisabled: true });
      return;
    }

    const atStart = scrollPos <= 2; // tolerance for subpixel
    const atEnd = scrollPos >= maxScroll - 2;
    applyUI({ leftDisabled: atStart, rightDisabled: atEnd });
  }

  // IntersectionObserver approach (more robust)
  let io = null;
  if ("IntersectionObserver" in window) {
    io = new IntersectionObserver(
      (entries) => {
        // determine the visibility of first and last card
        let firstVisible = false;
        let lastVisible = false;
        for (const e of entries) {
          if (e.target === firstCard) firstVisible = e.intersectionRatio >= 0.6;
          if (e.target === lastCard) lastVisible = e.intersectionRatio >= 0.6;
        }

        if (!isScrollable()) {
          applyUI({ leftDisabled: true, rightDisabled: true });
          return;
        }

        // if first is mostly visible -> left disabled; if last mostly visible -> right disabled
        applyUI({ leftDisabled: firstVisible, rightDisabled: lastVisible });
      },
      { root: cardsContainer, threshold: [0, 0.25, 0.5, 0.75, 1] }
    );

    io.observe(firstCard);
    io.observe(lastCard);

    // Force a tiny paint/scroll so IO triggers initial state reliably
    requestAnimationFrame(() => {
      cardsContainer.scrollLeft = Math.min(cardsContainer.scrollLeft + 0.001, cardsContainer.scrollWidth);
      cardsContainer.scrollLeft = Math.max(cardsContainer.scrollLeft - 0.001, 0);
    });
  } else {
    // fallback: wire scroll event
    cardsContainer.addEventListener("scroll", updateByScroll, { passive: true });
    // run initially
    setTimeout(updateByScroll, 0);
  }

  // Guarded scrolling (do nothing if the button is disabled)
  function guardScroll(dir) {
    // recompute max scroll and pos for guard
    const maxScroll = Math.max(0, cardsContainer.scrollWidth - cardsContainer.clientWidth);
    const pos = Math.round(cardsContainer.scrollLeft);

    if ((dir === -1 && pos <= 2) || (dir === 1 && pos >= maxScroll - 2)) {
      return; // already at edge, ignore click
    }

    cardsContainer.scrollBy({ left: dir * step, behavior: "smooth" });
  }

  rightBtn.addEventListener("click", () => {
    if (rightBtn.dataset.disabled === "true") return;
    guardScroll(1);
  });

  leftBtn.addEventListener("click", () => {
    if (leftBtn.dataset.disabled === "true") return;
    guardScroll(-1);
  });

  // Keep step and UI accurate on resize / images/fonts load
  window.addEventListener("resize", () => {
    step = getStep();
    if (!io) updateByScroll();
  });

  window.addEventListener("load", () => {
    step = getStep();
    if (!io) updateByScroll();
  });

  // final initial run (ensure something runs fast)
  if (!io) {
    updateByScroll();
  } else {
    // if IO exists, let it settle with a tiny delay
    setTimeout(() => {
      // defensive: if IO didn't mark anything (edge case), fallback to scroll-based check
      // this also ensures UI is set even if IO timing is odd
      const maxScroll = Math.max(0, cardsContainer.scrollWidth - cardsContainer.clientWidth);
      const pos = Math.round(cardsContainer.scrollLeft);
      if (!isScrollable()) applyUI({ leftDisabled: true, rightDisabled: true });
      else applyUI({ leftDisabled: pos <= 2, rightDisabled: pos >= maxScroll - 2 });
    }, 60);
  }
}
aboutUsCarouselFunctionality();

// Feature Child Page carousel functionality
function featureChildPageSettingsCarousel() {
  const cards = document.querySelectorAll(".fcs3-d2-card");
  let activeIndex = Array.from(cards).findIndex(card => card.classList.contains("card-active"));

  const leftArrow = document.querySelector(".fcs3-d3-d1"); // left div
  const rightArrow = document.querySelector(".fcs3-d3-d2"); // right div

  // Stop the function if the required elements don’t exist
  if (cards.length === 0 || !leftArrow || !rightArrow) {
    return;
  }

  function updateActiveCard(newIndex) {
    if (newIndex < 0 || newIndex >= cards.length) return; // stop at edges

    // remove active class from old card
    cards[activeIndex].classList.remove("card-active");

    // add active class to new card
    activeIndex = newIndex;
    cards[activeIndex].classList.add("card-active");

    // optional: center/scroll the active card
    cards[activeIndex].scrollIntoView({
      behavior: "smooth",
      inline: "center",
      block: "nearest"
    });
  }

  leftArrow.addEventListener("click", () => {
    updateActiveCard(activeIndex - 1);

    // toggle arrow-active class
    leftArrow.classList.add("arrow-active");
    rightArrow.classList.remove("arrow-active");
  });

  rightArrow.addEventListener("click", () => {
    updateActiveCard(activeIndex + 1);

    // toggle arrow-active class
    rightArrow.classList.add("arrow-active");
    leftArrow.classList.remove("arrow-active");
  });
}

featureChildPageSettingsCarousel();


// feature Child Page Settings FAQs, Coding Best Practices dropdown
function featureChildPageSettingsFaq(){
  document.querySelectorAll(".fcs5-card").forEach((card) => {
    card.addEventListener("click", function () {
      const heading = card.querySelector(".fcs5-card-question h5");
      const arrow   = card.querySelector(".fcs5-card-question img");

      // toggle active class
      card.classList.toggle("active");

      // arrow change
      if (card.classList.contains("active")) {
        arrow.src = "../new-assets/assets/images/aboutUs/up-arrow.svg";
        heading.style.color = "#2b56a5";
        card.style.background = "#f1f4f9";
      } else {
        arrow.src = "../new-assets/assets/images/aboutUs/down-arrow.svg";
        heading.style.color = "";
        card.style.background = "";
      }
    });
  });
}
featureChildPageSettingsFaq();

function featureChildPageSecSet() {
  const cardsContainer = document.querySelector(".fcs6-cards");
  const leftBtn = document.querySelector(".fcs6-bottom1");
  const rightBtn = document.querySelector(".fcs6-bottom2");
  if (!cardsContainer || !leftBtn || !rightBtn) return;

  const cards = cardsContainer.querySelectorAll(".fcs6-card");
  if (!cards.length) return;

  const firstCard = cards[0];
  const lastCard = cards[cards.length - 1];

  // helper to update UI and store disabled state on the element
  function applyUI({ leftDisabled, rightDisabled }) {
    if (leftDisabled) {
      leftBtn.style.background = "#e4e4e4";
      leftBtn.style.cursor = "not-allowed";
      leftBtn.dataset.disabled = "true";
    } else {
      leftBtn.style.background = "#2b56a5";
      leftBtn.style.cursor = "pointer";
      leftBtn.dataset.disabled = "false";
    }

    if (rightDisabled) {
      rightBtn.style.background = "#e4e4e4";
      rightBtn.style.cursor = "not-allowed";
      rightBtn.dataset.disabled = "true";
    } else {
      rightBtn.style.background = "#2b56a5";
      rightBtn.style.cursor = "pointer";
      rightBtn.dataset.disabled = "false";
    }
  }

  function isScrollable() {
    // returns true if there's actually overflow to scroll
    return cardsContainer.scrollWidth > cardsContainer.clientWidth + 1;
  }

  // compute card step (card width + gap)
  function getStep() {
    if (cards.length > 1) {
      return cards[1].offsetLeft - cards[0].offsetLeft;
    }
    const gapStr = getComputedStyle(cardsContainer).gap || "0";
    const gap = parseFloat(gapStr) || 0;
    return cards[0].offsetWidth + gap;
  }
  let step = getStep();

  // Fallback update using scrollLeft (if IntersectionObserver not available)
  function updateByScroll() {
    const maxScroll = Math.max(0, cardsContainer.scrollWidth - cardsContainer.clientWidth);
    const scrollPos = Math.round(cardsContainer.scrollLeft);

    if (!isScrollable()) {
      applyUI({ leftDisabled: true, rightDisabled: true });
      return;
    }

    const atStart = scrollPos <= 2; // tolerance for subpixel
    const atEnd = scrollPos >= maxScroll - 2;
    applyUI({ leftDisabled: atStart, rightDisabled: atEnd });
  }

  // IntersectionObserver approach (more robust)
  let io = null;
  if ("IntersectionObserver" in window) {
    io = new IntersectionObserver(
      (entries) => {
        // determine the visibility of first and last card
        let firstVisible = false;
        let lastVisible = false;
        for (const e of entries) {
          if (e.target === firstCard) firstVisible = e.intersectionRatio >= 0.6;
          if (e.target === lastCard) lastVisible = e.intersectionRatio >= 0.6;
        }

        if (!isScrollable()) {
          applyUI({ leftDisabled: true, rightDisabled: true });
          return;
        }

        // if first is mostly visible -> left disabled; if last mostly visible -> right disabled
        applyUI({ leftDisabled: firstVisible, rightDisabled: lastVisible });
      },
      { root: cardsContainer, threshold: [0, 0.25, 0.5, 0.75, 1] }
    );

    io.observe(firstCard);
    io.observe(lastCard);

    // Force a tiny paint/scroll so IO triggers initial state reliably
    requestAnimationFrame(() => {
      cardsContainer.scrollLeft = Math.min(cardsContainer.scrollLeft + 0.001, cardsContainer.scrollWidth);
      cardsContainer.scrollLeft = Math.max(cardsContainer.scrollLeft - 0.001, 0);
    });
  } else {
    // fallback: wire scroll event
    cardsContainer.addEventListener("scroll", updateByScroll, { passive: true });
    // run initially
    setTimeout(updateByScroll, 0);
  }

  // Guarded scrolling (do nothing if the button is disabled)
  function guardScroll(dir) {
    // recompute max scroll and pos for guard
    const maxScroll = Math.max(0, cardsContainer.scrollWidth - cardsContainer.clientWidth);
    const pos = Math.round(cardsContainer.scrollLeft);

    if ((dir === -1 && pos <= 2) || (dir === 1 && pos >= maxScroll - 2)) {
      return; // already at edge, ignore click
    }

    cardsContainer.scrollBy({ left: dir * step, behavior: "smooth" });
  }

  rightBtn.addEventListener("click", () => {
    if (rightBtn.dataset.disabled === "true") return;
    guardScroll(1);
  });

  leftBtn.addEventListener("click", () => {
    if (leftBtn.dataset.disabled === "true") return;
    guardScroll(-1);
  });

  // Keep step and UI accurate on resize / images/fonts load
  window.addEventListener("resize", () => {
    step = getStep();
    if (!io) updateByScroll();
  });

  window.addEventListener("load", () => {
    step = getStep();
    if (!io) updateByScroll();
  });

  // final initial run (ensure something runs fast)
  if (!io) {
    updateByScroll();
  } else {
    // if IO exists, let it settle with a tiny delay
    setTimeout(() => {
      // defensive: if IO didn't mark anything (edge case), fallback to scroll-based check
      // this also ensures UI is set even if IO timing is odd
      const maxScroll = Math.max(0, cardsContainer.scrollWidth - cardsContainer.clientWidth);
      const pos = Math.round(cardsContainer.scrollLeft);
      if (!isScrollable()) applyUI({ leftDisabled: true, rightDisabled: true });
      else applyUI({ leftDisabled: pos <= 2, rightDisabled: pos >= maxScroll - 2 });
    }, 60);
  }
}
featureChildPageSecSet();


function sliderWebTracker(){
  const container = document.querySelector('.fcwt3-d2');
  const wrapper = document.querySelector('.fcwt3-d2-wrapper');
  const slides = Array.from(wrapper.querySelectorAll('.fcwt3-d2-slide'));

  let current = 1; // middle slide active by default

  function getCurrentTranslateX(el){
    const st = window.getComputedStyle(el).transform;
    if (!st || st === 'none') return 0;
    // handle matrix(...) and matrix3d(...)
    const m2 = st.match(/^matrix\((.+)\)$/);
    if (m2) {
      const parts = m2[1].split(',').map(s => s.trim());
      return parseFloat(parts[4]) || 0; // tx
    }
    const m3 = st.match(/^matrix3d\((.+)\)$/);
    if (m3) {
      const parts = m3[1].split(',').map(s => s.trim());
      return parseFloat(parts[12]) || 0; // tx in 3d matrix
    }
    return 0;
  }

  function updateSlider() {
    if (!slides.length) return;

    // visible container & slide geometry (absolute coordinates)
    const containerRect = container.getBoundingClientRect();
    const containerCenter = containerRect.left + containerRect.width / 2;

    const slideRect = slides[current].getBoundingClientRect();
    const slideCenter = slideRect.left + slideRect.width / 2;

    // how much we need to move (positive => move wrapper right)
    const delta = containerCenter - slideCenter;

    // apply change relative to current translate (to avoid jumps)
    const currentTranslate = getCurrentTranslateX(wrapper);
    const newTranslate = currentTranslate + delta;

    wrapper.style.transform = `translateX(${newTranslate}px)`;

    // toggle active class
    slides.forEach(s => s.classList.remove('active'));
    slides[current].classList.add('active');
  }

  // click events
  slides.forEach((slide, index) => {
    slide.addEventListener('click', () => {
      if (index === current) return; // do nothing if already active
      current = index;
      updateSlider();
    });
  });

  // recalc when images load (their widths may change)
  slides.forEach(slide => {
    const img = slide.querySelector('img');
    if (img && !img.complete) img.addEventListener('load', updateSlider);
  });

  // also recalc on resize
  window.addEventListener('resize', updateSlider);

  // init (run on next tick so layout is stable)
  requestAnimationFrame(updateSlider);
}

sliderWebTracker();

// IMRANS CODE ENDS HERE