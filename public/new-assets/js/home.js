$( document ).ready(function() {
    let obj, startStatus = true, inputSelectAllStatus = false
    const allLabels = getAllTestLabels("dashboard").allLabels


    init()
    
    // ============================================
    // URL TRUNCATION FOR TEXTAREA - HOME PAGE
    // ============================================
    
    // Function to truncate a single URL to 85 characters
    function truncateUrl(url, maxLength = 85) {
        if (!url || url.length <= maxLength) {
            return url;
        }
        return url.substring(0, maxLength) + '...';
    }
    
    // Function to get full URLs from storage (for AJAX calls)
    function getFullUrlsValue() {
        const input = document.getElementById('urlValue');
        if (!input) return '';
        
        // Get current input value (may be truncated)
        const currentValue = input.value;
        
        // Get stored full value if it exists
        const storedFullValue = input.getAttribute('data-full-value');
        
        // If we have a stored full value, check if current value is truncated
        if (storedFullValue !== null && storedFullValue !== '') {
            // Check if current value contains truncation markers
            if (currentValue.endsWith('...')) {
                // Current value is truncated, use stored full value
                return storedFullValue;
            } else {
                // Current value appears to be full (no truncation)
                // This means user has modified it, so use current value
                // Also update stored value to keep it in sync
                input.setAttribute('data-full-value', currentValue);
                return currentValue;
            }
        }
        
        // If no stored value, return current value (might be truncated, but it's all we have)
        return currentValue;
    }
    
    // Function to format input with truncated URL
    function formatInputDisplay(forceFormat = false) {
        const input = document.getElementById('urlValue');
        if (!input) return;
        
        // Only format when input is not focused (on blur), unless forceFormat is true
        if (!forceFormat && document.activeElement === input) {
            return;
        }
        
        // Get current value from input
        let currentValue = input.value;
        
        // Check if we have a stored full value
        const storedFullValue = input.getAttribute('data-full-value');
        
        // If current value contains "..." it means it's truncated, so use stored full value
        if (currentValue.endsWith('...') && storedFullValue !== null && storedFullValue !== '') {
            currentValue = storedFullValue;
        }
        
        // Truncate if longer than 85 characters
        const truncated = truncateUrl(currentValue, 85);
        
        // Store full value if we truncated
        if (truncated !== currentValue) {
            input.setAttribute('data-full-value', currentValue);
        } else {
            // No truncation needed, clear stored value
            input.removeAttribute('data-full-value');
        }
        
        // Update input with truncated display
        input.value = truncated;
    }
    
    // Debounce timer for input truncation
    let inputFormatTimer = null;
    
    // On paste: truncate URL after paste completes
    $('#urlValue').on('paste', function(e) {
        const input = e.target;
        
        // Wait for paste to complete, then truncate
        setTimeout(function() {
            // Get the value after paste
            let currentValue = input.value;
            
            // Store full value before truncating
            input.setAttribute('data-full-value', currentValue);
            
            // Get current cursor position (after paste, before truncation)
            const cursorPos = input.selectionStart;
            
            // Truncate if longer than 90 characters
            const truncated = truncateUrl(currentValue, 90);
            
            // Store full value if we truncated
            if (truncated !== currentValue) {
                input.setAttribute('data-full-value', currentValue);
            }
            
            // Update input with truncated display
            const newValue = truncated;
            
            // Only update if value changed
            if (input.value !== newValue) {
                // Update the value
                input.value = newValue;
                
                // After paste, browser typically places cursor at the end of pasted content
                // Since we're truncating, we need to place cursor at the end of the new value
                const newCursorPos = newValue.length;
                input.setSelectionRange(newCursorPos, newCursorPos);
            } else {
                // Value didn't change, but cursor might have moved - restore it
                input.setSelectionRange(cursorPos, cursorPos);
            }
        }, 50);
    });
    
    // On blur: truncate URL when user clicks away
    $('#urlValue').on('blur', function() {
        formatInputDisplay();
    });
    
    // On input: store full value and truncate after user stops typing
    $('#urlValue').on('input', function(e) {
        const input = e.target;
        const currentValue = input.value;
        
        // If current value doesn't end with "...", it means user is typing the full value
        // Store it so we can retrieve it later for AJAX calls
        if (!currentValue.endsWith('...')) {
            input.setAttribute('data-full-value', currentValue);
        }
        
        // Clear any existing timer
        if (inputFormatTimer) {
            clearTimeout(inputFormatTimer);
        }
        
        // Truncate after user stops typing (500ms delay)
        // Only if value exceeds 85 characters
        if (currentValue.length > 85) {
            inputFormatTimer = setTimeout(function() {
                formatInputDisplay(true); // Force format even if focused
            }, 500);
        }
    });
    
    // Format on initial load if input has content
    if ($('#urlValue').length && $('#urlValue').val().trim()) {
        formatInputDisplay();
    }

    function updateHTTPInput(){
        let val = ""
        $(".http-checkbox").each(function(el){
          if(this.checked){
            val+=this.value + ","
          }
        })
    
        val = val.substring(0, val.length - 1);
    
        $("#http_status_code_accepted").val(val)
    }

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

    function init(){
        // show first cuztomizer element (meta-title)
        $('#v-pills-home-tab').tab('show')
        

        // toggle meta tags cuztomizer
        $('#flush-collapseOne').collapse("show")

        // init home typer text
        createTypeWriter()
    }


    // EVENTS
    $(".input-check-all").on( "click", function(e) {
        const parent = e.target.parentElement.nextElementSibling
        updateCustomizerInputStatus(parent, e)
    })

    
    $(".http-checkbox").on("change", function(){
        updateHTTPInput(this)
    })

    $("#selectAllInput").on( "change", function(e) {
        const parent = document.querySelector(".accordion-flush")
        updateCustomizerInputStatus(parent, e)
    })

    $("#startTest").on( "click", function(e) {

        e.preventDefault()
        clearAlerts()

        let testLabels = []
        const inputs = document.querySelectorAll(".customizer-check-input")
        inputs.forEach(input=>{
            const nameVal = input.getAttribute("data-name")

            const data = getLabelData(nameVal)
            if(input.checked){
                const labelObj = {
                    name: data.name,
                    url: data.url,
                    title: data.displayName,
                    parent: data.parent,
                    information: data
                }
                testLabels.push(labelObj)
            }
        })


        if(testLabels.length > 0){
            const urlField = $("#urlValue")[0]
            
            // Get full URL for validation and AJAX (not truncated)
            const fullUrl = getFullUrlsValue()
            
            // Temporarily set the full URL value for validation
            const originalValue = urlField.value
            urlField.value = fullUrl
            
            // Validate with full URL
            const isValid = validateFront({el: urlField, msgEmpty: "Please enter a URL to conduct a test."}, "analysis")
            
            // Restore truncated value for display
            urlField.value = originalValue
            
            if(isValid){
                buildLoader(obj, testLabels)
                // Use full URL for AJAX call
                runTest(testLabels, fullUrl, "analysis")
            }
        }else{
            displayAlertSimple(".footer_search_item", {
                status: 0,
                msg: "Please select at least one test to perform the analysis."

            }, false)
            toggleHomePageSettingsArea()
        }

    });
    

    $("#startTestFooter").on( "click", function(e) {
        e.preventDefault()
        clearAlerts()
        const urlField = document.querySelector("#urlValueFooter")
        if(validateFrontFooter({el: urlField, msgEmpty: "Please enter a URL to conduct a test."}, "analysis")){
            buildLoader()
            let testLabels = []
            allLabels.forEach(label=>{
                const nameVal = label
                const labelObj = {
                    name: label.name,
                    url: label.url,
                    title: label.displayName,
                    parent: label.parent,
                    information: label
                }
                testLabels.push(labelObj)
            })
            // Note: #urlValueFooter doesn't have truncation, so use value directly
            runTest(testLabels, urlField.value, "default")
        }

    });


 


    function runTest(testLabels, url, type){
        console.log(url)
        let alertClass
        if(type === "default"){
            alertClass = ".footer-form-container"
        }else{
            alertClass = ".footer_search_item"
        }
        const origin = new URL(url).origin
        
        const htmlSitemap = getSitemapVal("html", origin, $("#html_sitemap_custom"), $("#html_sitemap_val"))
        const xmlSitemap = getSitemapVal("xml", origin , $("#xml_sitemap_custom"), $("#xml_sitemap_val"))

        obj = {}
        obj["urlValue"] = url
        obj["project"] = type
        obj["saveInDB"] = 1
        obj["testLabels"] = JSON.stringify(testLabels)

        if(type != "default"){
            const inputs = document.querySelectorAll(".home-setting-container input,.home-setting-container textarea")
            const settingsVal = getSettingsVal(inputs)

            obj["settingsVal"] = settingsVal
            obj["settingsVal"]["settings_sub"]["html_sitemap_val"] = htmlSitemap
            obj["settingsVal"]["settings_sub"]["xml_sitemap_val"] = xmlSitemap
        }


        $.ajax({
            url : `/test/collect`,
            type : 'POST',
            async: false,
            data: {
                "data": obj,
                "_method": 'POST',
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },       
            success : function(data) {
                if(data.status === 0){
                    removeLoader()    
                    displayAlertSimple(alertClass, {
                        status: 0,
                        msg: "The url you have entered was not found. Please test with a different url."
                    })
                    startStatus = true
                }else if(data.status === 1){
                    window.location.href = `/analysis-report/w/${data.ref_id}`
                }else if(data.status === 2){
                    removeLoader()
                    displayAlertSimple(alertClass, {
                        status: 0,
                        msg: data.msg
                    })
                }
            },
            error: function(data){
                removeLoader()    
                displayAlertSimple(alertClass, {
                    status: 0,
                    msg: "The url you have entered was not found. Please test with a different url."

                }, false)
                
            }
        });
    }
    




    $(".nav-pills .nav-link").on( "click", function(e) {
        selectCustomizerItem(e.target)
    })

    $(".customizer-check-input").on( "change", function(e) {
        const target = e.target.parentElement

        if(e.target.checked){
            selectCustomizerItem(target, false)
        }else{
            // document.querySelector(".tab-pane.show").classList.remove("show")
            // document.querySelector(".tab-pane.active").classList.remove("active")
            // document.querySelector(".nav-link.active").classList.remove("active")
        }
    })


    // $(".home-setting-sidebar .accordion-item").on( "click", function(e) {
    //     const target = e.target
    //     const input = target.querySelector("input")
    //     if(target.classList.contains("accordion-button")){
    //         if(input.checked){
    //             input.checked = false
    //         }else{
    //             input.checked = true
    //         }
    //     }
    // })

    $(".btn-cancel, .btn-done").on( "click", function(e) {
        toggleHomePageSettingsArea()
    })


    // $(".input-check-all").on( "change", function(e) {
    //     const parent = e.target.parentElement.parentElement
    //     const inputs = parent.querySelectorAll("input")
    //     inputs.forEach(input=>{
    //         if(e.target.checked){
    //             input.checked = true
    //         }else{
    //             input.checked = false
    //         }
    //     })
    // })

    $(".toggleCasingChecks").each(function(el){
        disableElement(this)
    })

    $(".toggleCasingChecks").on("change", function(){
        disableElement(this)
    })

    $(".casing-check-input").on("change", function(){
        updateCasingInput(this)
    })





    function selectCustomizerItem(target, allow = true){
        const input = target.querySelector("input")
        if(target.classList.contains("form-check")){
            if(allow){
                if(input.checked){
                    input.checked = false
                }else{
                    input.checked = true
                }
            }

            const idVal = target.parentElement.getAttribute("data-controls")
            document.querySelector(".tab-pane.show").classList.remove("show")
            document.querySelector(".tab-pane.active").classList.remove("active")
            document.querySelector(".nav-link.active").classList.remove("active")

            document.getElementById(idVal).classList.add("show")
            document.getElementById(idVal).classList.add("active")
            target.parentElement.classList.add("active")
        }
    }

    function initCasingInput(){
        $(".casing-check-input").each(function(el){
            if(this.checked){
            $(this).prop( "value", 1 );
            }else{
            $(this).prop( "value", 0 );
            }
        })
    }


    function updateCasingInput(element){
        const inputs = $(element).parent().parent()[0].querySelectorAll(".casing-check-input")

        $(inputs).each(function(el){
            $(this).prop( "value", 0 );
        })
        $(element).prop( "value", 1 );

    }

    function disableElement(element){
        const all = []
        const inputElement = $(element).parent().next().children().first()
        const inputElement1 = $(element).parent().next().next().children().first()
        const inputElement2 = $(element).parent().next().next().next().children().first()
        all.push(inputElement)
        all.push(inputElement1)
        all.push(inputElement2)
    
    
        $(all).each(function(el){
          if(element.checked){
            this.prop( "disabled", false );
          }else{
            this.prop( "disabled", true );
            this.prop( "value", 0 );
            this.prop( "checked", false );
          }
        })
    }

    function getLabelData(name){
        for(var i = 0;i < allLabels.length;i++){
            const label = allLabels[i];
            if(label.name === name){
                return label;
            }
        }
    }


    // type writer
function createTypeWriter(){
    // get the element
    const textFields = Array.from(document.querySelectorAll(".typing-text"));
  
    if (!textFields.length) return;
  
    // make a words array
    const words = ["Technical SEO", "Page Speed", "HTML Best Practices", "Images", "Mobile Friendliness", "Meta Tags"];
  
    textFields.forEach(function (text) {
      // start typing effect
      setTyper(text, words);
    });
  
    function setTyper(element, words) {
      const LETTER_TYPE_DELAY = 75;
      const WORD_STAY_DELAY = 2000;
  
      const DIRECTION_FORWARDS = 0;
      const DIRECTION_BACKWARDS = 1;
  
      var direction = DIRECTION_FORWARDS;
      var wordIndex = 0;
      var letterIndex = 0;
  
      var wordTypeInterval;
  
      startTyping();
  
      function startTyping() {
        wordTypeInterval = setInterval(typeLetter, LETTER_TYPE_DELAY);
      }
  
      function typeLetter() {
        const word = words[wordIndex];
  
        if (direction == DIRECTION_FORWARDS) {
          letterIndex++;
  
          if (letterIndex == word.length) {
            direction = DIRECTION_BACKWARDS;
            clearInterval(wordTypeInterval);
            setTimeout(startTyping, WORD_STAY_DELAY);
          }
        } else if (direction == DIRECTION_BACKWARDS) {
          letterIndex--;
  
          if (letterIndex == 0) {
            nextWord();
          }
        }
  
        const textToType = word.substring(0, letterIndex);
  
        element.textContent = textToType;
      }
  
      function nextWord() {
        letterIndex = 0;
        direction = DIRECTION_FORWARDS;
        wordIndex++;
  
        if (wordIndex == words.length) {
          wordIndex = 0;
        }
      }
    }
  };

})
   
$(document).ready(function () {
    $(".lighthouse-mobile").hide();
    $(".vitals-mobile").hide();
  // Core Vitals tab switch
  $(".cw-tab-btn").click(function () {
    $(".cw-tab-btn").removeClass("active");
    $(this).addClass("active");

    if ($(this).hasClass("cw-desktop")) {
      $(".vitals-desktop").show();
      $(".vitals-mobile").hide();
    } else if ($(this).hasClass("cw-mobile")) {
      $(".vitals-mobile").show();
      $(".vitals-desktop").hide();
    }
  });

  // Lighthouse tab switch
  $(".lh-tab-btn").click(function () {
    $(".lh-tab-btn").removeClass("active");
    $(this).addClass("active");

    if ($(this).hasClass("lh-desktop")) {
      $(".lighthouse-desktop").show();
      $(".lighthouse-mobile").hide();
    } else if ($(this).hasClass("lh-mobile")) {
      $(".lighthouse-mobile").show();
      $(".lighthouse-desktop").hide();
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const imgs = document.querySelectorAll(".as1 img");
  let loadedCount = 0;

  imgs.forEach(img => {

    function reveal() {
      img.classList.add("loaded");
      
      loadedCount++;
      if (loadedCount === imgs.length) {

        imgs.forEach(i => i.classList.add("loaded"));
      }
    }

    if (img.complete) {
      reveal();
    } else {
      img.onload = reveal;
      img.onerror = reveal;
    }
  });
});

