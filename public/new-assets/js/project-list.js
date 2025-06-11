$(document).on("click", ".deleteProject", function () {
  // Create a new toast with a delete button
      let myToast;
      if ($('#projectCount').val() > 1) {  
        myToast = new ToastDelete("Deleting a project is permanent and cannot be undone. All the data of this project will be lost.", true);
          // Display the toast
      } else {
        myToast = new ToastDelete("Sorry, but your account needs to be have at least one project, The last project cannot be deleted.", false);
      }
      myToast.display();
      $('.toastDelete').attr('style', 'width: 523px !important; position: fixed !important; top: 50% !important; left: 50% !important; transform: translate(-50%, -50%) !important;');
      $('.deleteProjectToast').attr('data-id', $(this).data('id'))
      $('.deleteProjectToast').attr('data-name', $(this).attr('data-name'))
      return;
   });

   $(document).on("click", ".deleteProject1", function () {
    // Create a new toast with a delete button
        let myToast;
        if ($('#projectCount').val() > 1) {  
          myToast = new rememberUrl("Deleting a project is permanent and cannot be undone. All the data of this project will be lost.", true);
            // Display the toast
        } else {
          myToast = new rememberUrl("Sorry, but your account needs to be have at least one project, The last project cannot be deleted.", false);
        }
        myToast.display();
        $('.rememberUrl').attr('style', 'width: 523px !important; position: fixed !important; top: 25% !important; left: 50% !important; transform: translate(-50%, -50%) !important;');
        $('.deleteProjectToast').attr('data-id', $(this).data('id'))
        $('.deleteProjectToast').attr('data-name', $(this).attr('data-name'))
        return;
     });
  
  
  $(document).on("click", ".deleteProjectToast", function () {
    var projectId = $(this).data('id');
    var projectName = $(this).data('name');
      $.ajax({
        url: `/projects/` + projectId,
        type: 'DELETE',
        data: {
          "active_project_id": getCookie('data-val'),
          "_token": $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (data) {
          var rowId = "project_" + projectId; // Construct the ID of the <tr> element
          var row = $("#" + rowId); // Find the <tr> element by its ID
          $('#projectCount').val(data.projectsCount)
          if (data.status == 3 || data.status == 1) {
            if (data.status == 3) {
              activeProject(data.data)
            }
            row.remove(); // Remove the <tr> element
            displayAlert('.project_area', 'Project <b>' + projectName +'</b> has been deleted successfully.')
          } 
          $('.toastDelete').removeClass('show');
          $('.toastDelete').addClass('hide');
        }
      });
    
  });
  $(document).on("click", ".toastClose", function () {
    $('.toastDelete').removeClass('show');
    $('.toastDelete').addClass('hide');
  });
  
  function activeProject(data) {
    // Create the new li element
    var activeFavicon = '';
    if (data.favicon == "default" || data.favicon == "") {
      activeFavicon = "/new-assets/assets/images/amazon.png";
    } else {
      activeFavicon = data.favicon;
    }
    var newLi = '<li><a id="projectLi" class="dropdown-item select-project" href="#" data-favicon="/new-assets/assets/images/amazon.png" data-val="project-' + data.id + '" data-name="' + data.name + '">\
                  <img src="' + activeFavicon + '" alt="icon">\
                  '+ data.name + '</a></li>';
  
    // Append the new li element to the div
    $('.header-dropdown-list').append(newLi);
    $("#activeProject").attr("data-val", 'project-' + data.id);
    $("#activeProject").attr("data-name", data.name);
    $("#activeProject").text(data.name);
    $("#activeFavicon").attr("src", activeFavicon);
  
    setCookie('activeProject', data.id, 7);
    setCookie('activeProjectName', data.name, 7);
    setCookie('activeProjectFavicon', $('#projectLi').attr('data-favicon'), 7);
    updateSidebarSettingsLink()
  }
  // Get Cookie
  function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  }
  
  function updateSidebarSettingsLink() {
    if (document.querySelector("#activeProject")) {
      const projectId = getStringPart(document.querySelector("#activeProject").getAttribute("data-val"), "-", 1)
      const href = `${new URL(window.location.href).origin}/settings/${projectId}/edit`;
      $("#sidebarSettingsLink").attr("href", href)
    }
  }
  
  function setCookie(name, value, days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }
  
  