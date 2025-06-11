$(document).on("click", ".project_urlAction_edit", function () {
  $(".project_url_text_" + $(this).data('id')).removeAttr("disabled");
});

$('.project_url_text').keydown(function (event) {
  // Check if the pressed key is the Enter key (key code 13)
  if (event.keyCode === 13) {
    event.preventDefault(); // Prevent the default form submission
    var urlValid = checkValidSearchURL($(this).val(), $(this).data('id'))
  }
});

function appendUrlList() {
  let list = "";
  // Iterate over elements with the class "my-class"
  $('.project_url_text').each(function (index, element) {
    // 'this' refers to the current element with the class "my-class"
    console.log('Element at index ' + index + ': ' + $(this).val());
    list += $(this).val() + "\n"
  });
  $("#urlsList").html(list)
}

function checkValidSearchURL(urlValue, element) {
  var valid = '';
  if (urlValue != "") {

    $.ajax({
      type: 'POST',
      url: '/check-valid-url', // Use the named route you defined
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        url: urlValue
      },
      success: function (data) {
        $('.search_url_invalid').html('')
        valid = true;
        appendUrlList()
        $('.project_url_text').prop("disabled", true);
      },
      error: function (error) {
        $('.search_url_invalid_' + element).html('URL is not valid.')
        valid = false;
      }
    });
  }
  return valid;
}

$(document).on("click", ".project_urlAction_delete", function () {
  $(".project_data_tr_" + $(this).data('id')).remove();
  appendUrlList()
});


$(document).on("click", ".url_search_edit", function () {
  $('.project_url_title').show();
  if ($('#project_url_search').val() != "") {
    var myArray = $('#project_url_search').val().split(' ');

  $('.project_data_tr').each(function (index, element) {
    var projectUrlSearch = $('#project_url_search').val();
    var urlVar = $(this).data('url');
    var showFlag = 0;
    $.each(myArray, function(index, value){

      if (urlVar.indexOf(value) !== -1) {
        showFlag = 1;
      } else {
        showFlag = 0;
        return false;
      }

    });
    if(showFlag == 1) {
      $(this).show();
    } else {
      $(this).hide();
    }

  });

  } else {
    $('.project_data_tr').show();
  }
});