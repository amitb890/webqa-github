$(document).ready(function () {
  const route = `{{ \Route::currentRouteName() }}`;

  // This click event handles the creation of a project when the 'createProject' button is clicked.
  $("#createProjectButton").click(function (e) {

    // Set the route to 'projects.create'.
    const route = "projects.create";
    const name = $("#name")
    const homepage = $("#homepage")
    const urlsList = $("#urlsList")

    // Perform form validation and prevent submission if validation fails.
    const validate = validateProjectForm()
    if (!validate) {
      return false;
    }

    // Make an AJAX request to create a project.
    $.ajax({
      url: `/createProject`,
      type: 'POST',
      data: {
        "name": name.val(),
        "homepage": homepage.val(),
        "xmlSitemap": getSitemapValue('xml_sitemap_vlaue'),
        "htmlSitemap": getSitemapValue('html_sitemap_vlaue'),
        "urlsList": urlsList.val(),
        "route": route,
        "_method": 'POST',
        "_token": $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (data) {
        if (data.status === 0) {
          validate(data)
        } else {
          clearValues([name, homepage, urlsList, xmlSitemap, htmlSitemap])
          $("li.sitemap_li").remove();
          displayAlert('.add_project_area', data)
          scrollToTop()
          activeProject(data.data, 'create');
          clearHtml()
        }

      }
    });
    e.preventDefault();
  });

  $("#editProjectButton").click(function (e) {
    const name = $("#name")
    const homepage = $("#homepage")
    const urlsList = $("#urlsList")

    // Perform form validation and prevent submission if validation fails.
    const validate = validateProjectForm()
    if (!validate) {
      return false;
    }
    // Make an AJAX request to create a project.
    $.ajax({
      url: '/editProject',
      type: 'POST',
      data: {
        "name": name.val(),
        "homepage": homepage.val(),
        "xmlSitemap": getSitemapValue('xml_sitemap_vlaue'),
        "htmlSitemap": getSitemapValue('html_sitemap_vlaue'),
        "urlsList": urlsList.val(),
        "projectId": $('#projectId').val(),
        "settingsSubId": $('#settingsSubId').val(),
        // "route": route,
        "_method": 'POST',
        "_token": $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (data) {

        if (data.status === 0) {
          validate(data)
        } else {
          $("li.sitemap_li").remove();
          displayAlert('.add_project_area', data)
          scrollToTop()
          activeProject(data.data, 'edit');
          clearHtml()
        }

      }
    });
    e.preventDefault();
  });

  function clearHtml() {
    $('.valid_url').hide();
    $('.total_url').empty();
    $('.invalid_url').empty();
    $('#homepage').removeClass('is-valid');
  }
});

// This function is executed when the 'input' event occurs on the 'homepage' input element.
$(document).ready(function () {
  // Select the input element by its ID
  var inputElement = $('#homepage');
  var xhr = null;
 
  // Attach an event listener to the input element
  inputElement.on('input', function () {
    
    var urlValue = $('#homepage').val();
    var container = $('#homepage').closest('.col-md-6.project-single-input');
    container.find('.invalid-feedback').remove();
    if(urlValue != "") {
      if(!isValidURL(urlValue)){
        $('#homepage').addClass('is-invalid');
          $('#homepage').removeClass('is-valid');
          $('.invalid_url').show();
          $('.valid_url').hide();
          $('#check_valid_url').val(0);
          $('.total_url').empty()
          $('.total_url').hide();
          clearValuesUrl(['#urlsList', '#xmlSitemap', '#htmlSitemap'])
          return false;
        
    } else {
      checkValidURL();
     
    }
  } else {
    $('#homepage').removeClass('is-valid');
    $('#homepage').removeClass('is-invalid');
    $('.valid_url').hide();
    $('.invalid_url').hide();
    $('.total_url').empty()
    $('.total_url').hide();
    clearValuesUrl(['#urlsList', '#xmlSitemap', '#htmlSitemap'])
  }

  return;
    
  });
  function updateSitemapInputs() {
    const websiteAddress = removeTrailingSlash($("#homepage").val())
    $("#xmlSitemap").val(getSitemapAddress("xml", websiteAddress))
    $("#htmlSitemap").val(getSitemapAddress("html", websiteAddress))
  }

  function getUrlsList() {
    $("#urlsList").html("")
    const xmlSitemap = $("#xmlSitemap").val()
    const data = {
      sitemapContent: 1,
      urlValue: xmlSitemap,
      xmlSitemap: xmlSitemap,
      content: xmlSitemap,
    }
    
    if (xhr !== null) {
      // Abort the ongoing request
      xhr.abort();
    }
    xhr = $.ajax({
      url: `/test/xml-sitemap`,
      type: 'POST',
      data: {
        data: data,
        "_method": 'POST',
        "_token": $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (data) {
        data = JSON.parse(data)
        if (data.xmldata != "") {
          if (data.xmldata && data.xmldata.url && data.xmldata.url.length > 0) {
            updateUrlsList(data.xmldata.url)
          } 
        } else {
          $("#urlsList").val('')
          $("#xmlSitemap").val('')
          $("#htmlSitemap").val('')
         
        }
      },
      complete: function() {
        // Reset xhr variable after completion
        xhr = null;
    }
    });
  }
  function clearValuesUrl(inputs){
    inputs.forEach(el=>{
        $(el).val("")
    })
}

  function updateUrlsList_bk(urls) {
    let list = "";
    $("#urlsList").val(list)
    var urlUniqueArray = [];
    urls.forEach((url, i) => {
       i === urls.length - 1 ? url.loc : urlUniqueArray.push(url.loc)
      })
    // Remove duplicate values while preserving order
    var uniqueArray = $.grep(urlUniqueArray, function(element, index){
      return index === urlUniqueArray.indexOf(element);
    });

     uniqueArray.forEach((url, i) => {
      list += url + "\n"
    })
  
    $("#urlsList").val(list)
  }

  function updateUrlsList(urls) {
    let list = "";
    $("#urlsList").val(list)
    var urlUniqueArray = [];
    urls.forEach((url, i) => {
       i === urls.length - 1 ? url.loc : urlUniqueArray.push(url.loc)
      })
    // Remove duplicate values while preserving order
    var uniqueArray = $.grep(urlUniqueArray, function(element, index){
      return index === urlUniqueArray.indexOf(element);
    });

     uniqueArray.forEach((url, i) => {
      list += url + "\n"
    })
  
    $("#urlsList").val(list)
  }

  $('#name').on('blur', function () {
    checkUniqueProjectName();
  });

  $('#urlsList').on('input', function () {
    urlCount();
  });


  urlCount()

  $('#project_area').on('click', function () {
    // Assuming 'tabs' is the ID of your tabs container
    checkUniqueProjectName();
  });

  function checkUniqueProjectName() {
    var projectName = $('#name').val();
    var projectId = $('#project_id').val();
    $('#unique_name_project_valid').val(1);
    $.ajax({
      url: '/check-unique-project-name',
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        project_name: projectName,
        projectId: projectId
      },
      success: function (response) {
        if(response.uniqueError) {
          $('#name').removeClass('is-invalid');
          $('.invalid_name').hide();
          $('#unique_name_project_valid').val(1);
        } else {
          $('#name').addClass('is-invalid');
          $('.invalid_name').show();
          $('#unique_name_project_valid').val(0);
        }
      },
  
    });
  }

  function checkValidURL() {
    var urlValue = $('#homepage').val();
    if (urlValue != "") {
      $('#check_valid_url').val(1);
      $.ajax({
        type: 'POST',
        url: '/check-valid-url', // Use the named route you defined
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          url: urlValue
        },
        success: function (data) {
          if(data.valid) {
            $('#homepage').removeClass('is-invalid');
            $('#homepage').addClass('is-valid');
            $('.invalid_url').hide();
            $('.valid_url').show();
            $('#check_valid_url').val(1);
            $('#homepage').val(data.redirectedUrl)
            updateSitemapInputs()
            getUrlsList()
          } else {
            $('#homepage').addClass('is-invalid');
            $('#homepage').removeClass('is-valid');
            $('.invalid_url').show();
            $('.valid_url').hide();
            $('#check_valid_url').val(0);
            $('.total_url').empty()
            $('.total_url').hide();
            clearValuesUrl(['#urlsList', '#xmlSitemap', '#htmlSitemap'])
            return false;
          }
        },
        error: function (error) {
          $('#homepage').addClass('is-invalid');
          $('#homepage').removeClass('is-valid');
          $('.invalid_url').show();
          $('.valid_url').hide();
          $('#check_valid_url').val(0);
        }
      });
    }
  }

  function urlCount() {
    var inputString = $('#urlsList').val();
    $('.total_url').empty()
    $('.total_url').hide();
    if ($('#urlsList').val() != "") {
      var urls = inputString.split(/\n/);
      urls = urls.filter(function (v) { return v !== '' });
      var urlCount = urls.length;
      $('.total_url').html('Total ' + urlCount + ' URL found.')
      $('.total_url').show();
    } else {
      $('.total_url').empty()
      $('.total_url').hide();
    }
  }
});


// This function validates the project form inputs.
function validateProjectForm() {
  clearAlertsNew()
  var validate = true;
  var homepageUrlError = true;
  var projectName = $('#name').val().trim();
  if (projectName === "") {
    const alertMessage = buildAlertNew(`Project name can not be empty`)
    $('#name').parent().append(alertMessage);
    validate = false;
  }

  if ($('#homepage').val() === "") {
    const alertMessage = buildAlertNew(`Project URL can not be empty`)
    $('#homepage').parent().append(alertMessage);
    validate = false;
    homepageUrlError = false;
  } else if (!isValidURL($('#homepage').val())) {
    let msgInvalid =
      $('#homepage').val() +
      ' is an incorrect URL format, please enter the URL in the correct format and try again.'
    const alertMessage = buildAlertNew(msgInvalid)
    // $('#homepage').parent().append(alertMessage);
    validate = false;
    homepageUrlError = false;
  } else {

    // Find elements with the specified class name
    var elements = $(".xml_sitemap_vlaue");
    if (!sitemapValValidationOnSubmit(elements)) {
      validate = false;
    }

    if ($('#unique_name_project_valid').val() == 0) {
      validate = false;
    }
    if ($('#check_valid_url').val() == 0) {
      validate = false;
    }

    var elements = $(".html_sitemap_vlaue");
    if (!sitemapValValidationOnSubmit(elements)) {
      validate = false;
    }
  }
  var urlsListErr = false;
  if ($('#urlsList').val() != "") {
    const inputString = $('#urlsList').val();
    const delimiter = "\n";

    const explodedArray = inputString.split(delimiter);
    const nonBlankArray = explodedArray.filter(item => item.trim() !== '');

    nonBlankArray.forEach(function (inputValue) {
      if (!isValidURL(inputValue)) {
        validate = false;
        urlsListErr = true;
      } else {
        const websiteAddress = removeTrailingSlash($("#homepage").val())
        if ($("#homepage").val() != "" && homepageUrlError == true) {
          const websiteHost = new URL(websiteAddress).host
          const sitemapHost = new URL(inputValue).host

          if (websiteHost != sitemapHost) {
            validate = false;
            urlsListErr = true;
          }
        } else {
          validate = false;
        }
      }
    });

  } else {
    validate = false;
    const alertMessage = buildAlertNew('Please enter atleast one URL.')
    $('#urlsList').parent().append(alertMessage)
  }

  if (urlsListErr) {
    let msgInvalid =
      `Insert value is an incorrect URL format, please enter the URL in the correct format and try again.`
    const alertMessage = buildAlertNew(msgInvalid)
    $('#urlsList').parent().append(alertMessage)
  }
  return validate;
}

function sitemapValValidationOnSubmit(elements) {
  var returnVar = true;
  // Loop through the elements and concatenate their text content
  elements.each(function (index) {
    var inputValue = $(this).text();
    if (!isValidURL(inputValue)) {
      let msgInvalid =
        `${inputValue} is an incorrect URL format, please enter the URL in the correct format and try again.`
      const alertMessage = buildAlertNew(msgInvalid)
      $(this).parent().append(alertMessage)
      returnVar = false
    } else {
      const websiteAddress = removeTrailingSlash($("#homepage").val())
      if ($("#homepage").val() != "") {
        const websiteHost = new URL(websiteAddress).host
        const sitemapHost = new URL(inputValue).host

        if (websiteHost != sitemapHost) {
          let msgInvalid =
            `This URL does not exist in the website address - ${websiteAddress}. Please enter a URL from the website - <a href="${websiteAddress}">${websiteAddress}</a>`
          const alertMessage = buildAlertNew(msgInvalid)
          $(this).parent().append(alertMessage)
          returnVar = false
        }
      }

    }
  });
  return returnVar;
}
// This function validates the value of a sitemap input.
function sitemapValValidation(inputId) {
  const inputValue = $('#' + inputId).val()

  // Select the closest div with class "col-md-6 project-single-input"
  var container = $('#xmlSitemap').closest('.col-md-6.project-single-input');

  // Find and remove elements with class "invalid-feedback" within the container
  container.find('.invalid-feedback').remove();
  if (inputValue != "") {
    if (!isValidURL(inputValue)) {
      let msgInvalid =
        `${inputValue} is an incorrect URL format, please enter the URL in the correct format and try again.`
      const alertMessage = buildAlertNew(msgInvalid)
      $('#' + inputId).parent().append(alertMessage)
      return false
    } else {
      const websiteAddress = removeTrailingSlash($("#homepage").val())
      if ($("#homepage").val() != "") {
        const websiteHost = new URL(websiteAddress).host
        const sitemapHost = new URL(inputValue).host

        if (websiteHost != sitemapHost) {
          let msgInvalid =
            `This URL does not exist in the website address - ${websiteAddress}. Please enter a URL from the website - <a href="${websiteAddress}">${websiteAddress}</a>`
          const alertMessage = buildAlertNew(msgInvalid)
          $('#' + inputId).parent().append(alertMessage)
          return false
        }
      }
    }
  } else {
    let msgInvalid = 'URL can not be empty.'
    const alertMessage = buildAlertNew(msgInvalid)
    $('#' + inputId).parent().append(alertMessage)
    return false;
  }

  return true;
}

function sitemapUrlValid(urlValue, callback) {
  var sitemapValValidation = false;
  if (urlValue != "") {
    $.ajax({
      type: 'POST',
      url: '/check-valid-url', // Use the named route you defined
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        url: urlValue
      },
      success: function (data) {
        callback(data, true);
      },
      error: function (error) {
        callback(data, false);
      }
    });
  }

}

// Click event handler for adding XML sitemap.
$(".xml_sitemap_btn").click(function (e) {
  const inputValue = $('#xmlSitemap').val()
  if (!sitemapValValidation('xmlSitemap')) {
    return false;
  }
  sitemapUrlValid(inputValue, function (data, variableResponse) {

    if (!variableResponse) {
      let msgInvalid =
        `URL not validated`
      const alertMessage = buildAlertNew(msgInvalid)
      $('#xmlSitemap').parent().append(alertMessage)
      return false;
    } else {
      // Create a new li element
      var newLi =
        '<li class="xml_sitemap_li sitemap_li"><span class="xml_sitemap_vlaue">' + inputValue +
        '</span><button type="button" class="sitemap_input_btn"><i class="fa-solid fa-xmark"></i></button></li>';
      $('.xml_sitemap_li:last-child').after(newLi)
    }
  });

});

$(".html_sitemap_btn").click(function (e) {
  if (!sitemapValValidation('htmlSitemap')) {
    return false;
  }
  const inputValue = $('#htmlSitemap').val()

  sitemapUrlValid(inputValue, function (data, variableResponse) {
    if (!variableResponse) {
      let msgInvalid =
        `URL not validated`
      const alertMessage = buildAlertNew(msgInvalid)
      $('#xmlSitemap').parent().append(alertMessage)
      return false;
    } else {
      // Create a new li element
      var newLi =
        '<li class="html_sitemap_li sitemap_li"><span class="html_sitemap_vlaue">' + inputValue +
        '</span><button type="button" class="sitemap_input_btn"><i class="fa-solid fa-xmark"></i></button></li>';
      $('.html_sitemap_li:last-child').after(newLi)
    }
  });
});

// This function retrieves the values of sitemap inputs and concatenates them.
function getSitemapValue(sitemapClass) {
  var concatenatedValues = ""; // Initialize an empty string

  // Find elements with the specified class name
  var elements = $("." + sitemapClass);

  // Loop through the elements and concatenate their text content
  elements.each(function (index) {
    var value = $(this).text();
    concatenatedValues += value;

    // Add a comma if it's not the last element
    if (index < elements.length - 1) {
      concatenatedValues += ",";
    }
  });

  return concatenatedValues;
}

// Click event handler for removing sitemap inputs.
$(document).on("click", ".sitemap_input_btn", function () {
  $(this).closest('.sitemap_li').remove();
});
$(document).ready(function () {
  updateSidebarSettingsLink()
  updateSliders()
});
function activeProject(data, action) {
  // Create the new li element
  if (data.id == getCookie('activeProject') || action == 'create') {
    var activeFavicon = '';
    if (data.favicon == "default" || data.favicon == "") {
      activeFavicon = "/new-assets/assets/images/amazon.png";
    } else {
      activeFavicon = data.favicon;
    }
    // var newLi = '<li><a id="projectLi" class="dropdown-item select-project" href="#" data-favicon="/new-assets/assets/images/amazon.png" data-val="project-' + data.id + '" data-name="' + data.name + '">\
    //             <img src="' + activeFavicon + '" alt="icon">\
    //             '+ data.name + '</a></li>';
    var oldLi = '<li><a id="projectLi" class="dropdown-item select-project" href="#" data-favicon="/new-assets/assets/images/amazon.png" data-val="project-' + getCookie('activeProject') + '" data-name="' + getCookie('activeProjectName') + '">\
    <img src="' + getCookie('activeProjectFavicon') + '" alt="icon">\
    '+ getCookie('activeProjectName') + '</a></li>';

    // Append the new li element to the div
    $('.header-dropdown-list').append(oldLi);
    $("#activeProject").attr("data-val", 'project-' + data.id);
    $("#activeProject").attr("data-name", data.name);
    $("#activeProject").text(data.name);
    $("#activeFavicon").attr("src", activeFavicon);

    setCookie('activeProject', data.id, 7);
    setCookie('activeProjectName', data.name, 7);
    setCookie('activeProjectFavicon', activeFavicon, 7);
    updateSidebarSettingsLink()
  }
}

// new


$(".dropdown-menu-projects").click(function (e) {
  const target = e.target.closest(".select-project")
  if (target.classList.contains("select-project")) {
    selectProject(e, target)
    updateSidebarSettingsLink()
  }
});

function updateSidebarSettingsLink() {
  if (document.querySelector("#activeProject")) {
    const projectId = getStringPart(document.querySelector("#activeProject").getAttribute("data-val"), "-", 1)
    const href = `${new URL(window.location.href).origin}/settings/${projectId}/edit`;
    $("#sidebarSettingsLink").attr("href", href)
  }
}


function selectProject(e, _this) {
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
  aActive.id = "activeProject"
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

  setCookie('activeProject', projectVal, 7);
  setCookie('activeProjectName', projectName, 7);
  setCookie('activeProjectFavicon', projectFavicon, 7);


  e.preventDefault()
}
