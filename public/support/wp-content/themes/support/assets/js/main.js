$(document).ready(function () {
  // Sidebar Js
  $(".collaps_sidebar").click(function () {
    $(".side_content").slideToggle(function () {
      $(".collaps_sidebar").toggleClass("rotate");
      if ($(window).width() > 991) {
        $(".footer-area").toggleClass("small");
      }
    });
  });


  // Element JS
  $(".customize_test").click(function () {
    $(".element-main-area").slideToggle();
  });

  // home Page Js Start
  $("#settingBtn").click(function () {
    $(this).toggleClass("active");
    $(".home-setting-area").slideToggle();
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

  // Tools Single Js
  $(".test_criteria").click(function () {
    $(this).toggleClass("active");
    $(".tools_meta_content").slideToggle();
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
  // Element Page Close Btn
  $(".element-cls span").click(function () {
    $(".element-main-area").hide();
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
  if (typeof $().slider !== "undefined") {
    $("#ex21").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 2nd range
    $("#ex22").slider({
      id: "slider22",
      min: 0,
      max: 30,
      step: 1,
      value: 23,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 3rd range
    $("#ex23").slider({
      id: "slider22",
      min: 0,
      max: 220,
      step: 1,
      value: 200,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 4th range
    $("#ex24").slider({
      id: "slider22",
      min: 0,
      max: 70,
      step: 1,
      value: 60,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 5th range
    $("#ex25").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 90,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 6th range
    $("#ex26").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 83,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 7th range
    $("#ex27").slider({
      id: "slider22",
      min: 0,
      max: 30,
      step: 1,
      value: 25,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 8th range
    $("#ex28").slider({
      id: "slider22",
      min: 0,
      max: 220,
      step: 1,
      value: 188,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 9th range
    $("#ex29").slider({
      id: "slider22",
      min: 0,
      max: 70,
      step: 1,
      value: 60,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 10th range
    $("#ex30").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 88,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 11th range
    $("#ex31").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 83,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 12th range
    $("#ex32").slider({
      id: "slider22",
      min: 0,
      max: 30,
      step: 1,
      value: 25,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 13th range
    $("#ex33").slider({
      id: "slider22",
      min: 0,
      max: 500,
      step: 1,
      value: 450,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 14th range
    $("#ex34").slider({
      id: "slider22",
      min: 0,
      max: 2000,
      step: 1,
      value: 1700,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 15th range
    $("#ex35").slider({
      id: "slider22",
      min: 0,
      max: 200,
      step: 1,
      value: 170,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });

    // performance range
    // 1st range
    $("#score1").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 90,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 2nd range
    $("#score2").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 90,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 3rd range
    $("#score3").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 90,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 4th range
    $("#score4").slider({
      id: "slider22",
      min: 90,
      max: 120,
      step: 1,
      value: 117,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 5th range
    $("#score5").slider({
      id: "slider22",
      min: 90,
      max: 120,
      step: 1,
      value: 117,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 6th range
    $("#score6").slider({
      id: "slider22",
      min: 90,
      max: 120,
      step: 1,
      value: 117,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 7th range
    $("#score7").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 90,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 8th range
    $("#score8").slider({
      id: "slider22",
      min: 90,
      max: 120,
      step: 1,
      value: 117,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 9th range
    $("#score9").slider({
      id: "slider22",
      min: 90,
      max: 120,
      step: 1,
      value: 117,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 10th range
    $("#score10").slider({
      id: "slider22",
      min: 90,
      max: 120,
      step: 1,
      value: 117,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 11th range
    $("#score11").slider({
      id: "slider22",
      min: 0,
      max: 5,
      step: 0.5,
      value: 3,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 12th range
    $("#score12").slider({
      id: "slider22",
      min: 0,
      max: 5,
      step: 0.5,
      value: 2,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 13th range
    $("#score13").slider({
      id: "slider22",
      min: 0,
      max: 0.5,
      step: 0.1,
      value: 0.2,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 14th range
    $("#score14").slider({
      id: "slider22",
      min: 0,
      max: 500,
      step: 1,
      value: 100,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 15th range
    $("#score15").slider({
      id: "slider22",
      min: 0,
      max: 500,
      step: 1,
      value: 100,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 16th range
    $("#score16").slider({
      id: "slider22",
      min: 0,
      max: 8,
      step: 1,
      value: 2,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 17th range
    $("#score17").slider({
      id: "slider22",
      min: 0,
      max: 8,
      step: 1,
      value: 2,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 18th range
    $("#score18").slider({
      id: "slider22",
      min: 0,
      max: 5,
      step: 0.5,
      value: 3,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 19th range
    $("#score19").slider({
      id: "slider22",
      min: 0,
      max: 5,
      step: 0.5,
      value: 2,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 20th range
    $("#score20").slider({
      id: "slider22",
      min: 0,
      max: 0.5,
      step: 0.1,
      value: 0.2,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 21th range
    $("#score21").slider({
      id: "slider22",
      min: 0,
      max: 500,
      step: 1,
      value: 100,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 22th range
    $("#score22").slider({
      id: "slider22",
      min: 0,
      max: 500,
      step: 1,
      value: 100,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 23th range
    $("#score23").slider({
      id: "slider22",
      min: 0,
      max: 8,
      step: 1,
      value: 2,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    // 24th range
    $("#score24").slider({
      id: "slider22",
      min: 0,
      max: 8,
      step: 1,
      value: 2,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });

    // Setting page end
  }

  // setting range value
  function getSliderValue(slider, target) {
    $(slider).on("slide", function (slideEvt) {
      $(target).val(slideEvt.value);
    });
  }

  function setSliderValue(slider, target) {
    $(target).on("input", function () {
      $(slider).slider("setValue", $(this).val());
    });
  }

  //   $('#ex21').slider();
  getSliderValue("#ex21", "#ex21-input");
  setSliderValue("#ex21", "#ex21-input");

  getSliderValue("#ex22", "#ex22-input");
  setSliderValue("#ex22", "#ex22-input");

  getSliderValue("#ex23", "#ex23-input");
  setSliderValue("#ex23", "#ex23-input");

  getSliderValue("#ex24", "#ex24-input");
  setSliderValue("#ex24", "#ex24-input");

  getSliderValue("#ex25", "#ex25-input");
  setSliderValue("#ex25", "#ex25-input");

  getSliderValue("#ex26", "#ex26-input");
  setSliderValue("#ex26", "#ex26-input");

  getSliderValue("#ex27", "#ex27-input");
  setSliderValue("#ex27", "#ex27-input");

  getSliderValue("#ex28", "#ex28-input");
  setSliderValue("#ex28", "#ex28-input");

  getSliderValue("#ex29", "#ex29-input");
  setSliderValue("#ex29", "#ex29-input");

  getSliderValue("#ex30", "#ex30-input");
  setSliderValue("#ex30", "#ex30-input");

  getSliderValue("#ex31", "#ex31-input");
  setSliderValue("#ex31", "#ex31-input");

  getSliderValue("#ex32", "#ex32-input");
  setSliderValue("#ex32", "#ex32-input");

  getSliderValue("#ex33", "#ex33-input");
  setSliderValue("#ex33", "#ex33-input");

  getSliderValue("#ex34", "#ex34-input");
  setSliderValue("#ex34", "#ex34-input");

  getSliderValue("#ex35", "#ex35-input");
  setSliderValue("#ex35", "#ex35-input");

  getSliderValue("#score1", "#score1-input");
  setSliderValue("#score1", "#score1-input");

  getSliderValue("#score2", "#score2-input");
  setSliderValue("#score2", "#score2-input");

  getSliderValue("#score3", "#score3-input");
  setSliderValue("#score3", "#score3-input");

  getSliderValue("#score4", "#score4-input");
  setSliderValue("#score4", "#score4-input");

  getSliderValue("#score5", "#score5-input");
  setSliderValue("#score5", "#score5-input");

  getSliderValue("#score6", "#score6-input");
  setSliderValue("#score6", "#score6-input");

  getSliderValue("#score7", "#score7-input");
  setSliderValue("#score7", "#score7-input");

  getSliderValue("#score8", "#score8-input");
  setSliderValue("#score8", "#score8-input");

  getSliderValue("#score9", "#score9-input");
  setSliderValue("#score9", "#score9-input");

  getSliderValue("#score10", "#score10-input");
  setSliderValue("#score10", "#score10-input");

  getSliderValue("#score11", "#score11-input");
  setSliderValue("#score11", "#score11-input");

  getSliderValue("#score12", "#score12-input");
  setSliderValue("#score12", "#score12-input");

  getSliderValue("#score13", "#score13-input");
  setSliderValue("#score13", "#score13-input");

  getSliderValue("#score14", "#score14-input");
  setSliderValue("#score14", "#score14-input");

  getSliderValue("#score15", "#score15-input");
  setSliderValue("#score15", "#score15-input");

  getSliderValue("#score16", "#score16-input");
  setSliderValue("#score16", "#score16-input");

  getSliderValue("#score17", "#score17-input");
  setSliderValue("#score17", "#score17-input");

  getSliderValue("#score18", "#score18-input");
  setSliderValue("#score18", "#score18-input");

  getSliderValue("#score19", "#score19-input");
  setSliderValue("#score19", "#score19-input");

  getSliderValue("#score20", "#score20-input");
  setSliderValue("#score20", "#score20-input");

  getSliderValue("#score21", "#score21-input");
  setSliderValue("#score21", "#score21-input");

  getSliderValue("#score22", "#score22-input");
  setSliderValue("#score22", "#score22-input");

  getSliderValue("#score23", "#score23-input");
  setSliderValue("#score23", "#score23-input");

  getSliderValue("#score24", "#score24-input");
  setSliderValue("#score24", "#score24-input");
  // setting range value

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

  // show-details-btn
  $(".show-details-btn").click(function () {
    $(".loader-list-toggle").slideToggle(300);
    $("body, html").animate(
      { scrollTop: $(this).offset().top - $("#headerMain").height() },
      300
    );
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
        `./assets/images/onboarding-img-${step}.png`
      );
    }

    function nextImg() {
      step = step + 1;
      $("#onboardingImg").attr(
        "src",
        `./assets/images/onboarding-img-${step}.png`
      );
    }

    $("#formTriggerBtn1").click(function () {
      $(".form-setp").removeClass("active");
      $("#formSetp2").addClass("active");
      $(".form-slider-range .progress-line").width("25%");
      $(".progress-dot.two").addClass("active");
      nextImg();
    });
    $("#formTriggerBtn2, #BtnSkip1").click(function () {
      $(".form-setp").removeClass("active");
      $("#formSetp3").addClass("active");
      $(".form-slider-range .progress-line").width("50%");
      $(".progress-dot.three").addClass("active");
      nextImg();
    });
    $("#formTriggerBtn3, #BtnSkip2").click(function () {
      $(".form-setp").removeClass("active");
      $("#formSetp4").addClass("active");
      $(".form-slider-range .progress-line").width("75%");
      $(".progress-dot.four").addClass("active");
      nextImg();
    });
    $("#formTriggerBtn4").click(function () {
      $(".form-setp").removeClass("active");
      $("#formSetp5").addClass("active");
      $(".form-slider-range .progress-line").width("100%");
      $(".progress-dot.five").addClass("active");
      nextImg();
    });
    $("#formTriggerBtn5").click(function () {
      $(".form-setp").removeClass("active");
      $("#formSetp6").addClass("active");
      nextImg();
    });
    $("#BtnPrev1").click(function () {
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

  if (typeof $().slider !== "undefined") {
    $("#analysisEx21").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx22").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx23").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx24").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx25").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx26").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx27").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx28").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx29").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx30").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx31").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx32").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx33").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx34").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx35").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx36").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx37").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx38").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx39").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx40").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx41").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx42").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx43").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx44").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx45").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx46").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx47").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx48").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx49").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx50").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx51").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
    $("#analysisEx52").slider({
      id: "slider22",
      min: 0,
      max: 100,
      step: 1,
      value: 85,
      rangeHighlights: [
        { start: 2, end: 5, class: "category1" },
        { start: 7, end: 8, class: "category2" },
        { start: 17, end: 19 },
        { start: 17, end: 24 },
        { start: -3, end: 19 },
      ],
    });
  }

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

  $("#showEverything").click(function () {
    $("#hidePassed").removeClass("active");
    if (!$(this).hasClass("active")) {
      $(this).addClass("active");
      $(".analysis-card").show();
    } else {
      $(this).removeClass("active");
      $(".analysis-card").hide();
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

    if (
      !$(this).hasClass("active") &&
      !$("#showEverything").hasClass("active")
    ) {
      $(".analysis-card").hide();
    }
  });

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

  (function () {
    const path = "./assets/images/";
    const images = [
      "loader-img-1.png",
      "loader-img-2.png",
      "loader-img-3.png",
      "loader-img-4.png",
      "loader-img-5.png",
    ];
    const interval = 5000;
    let index = 0;

    setInterval(() => {
      if (index > images.length - 1) index = 0;
      $(".loader-img img").attr("src", path + images[index]);
      index++;
    }, interval);
  })();

  // circular progress bar
  (function () {
    // Get all the Meters
    const meters = document.querySelectorAll("svg[data-value] .meter");

    if (!meters.length) return;

    meters.forEach((path) => {
      // Get the length of the path
      let length = path.getTotalLength();
      // Get the value of the meter
      let value = parseInt(path.parentNode.getAttribute("data-value"));
      // Calculate the percentage of the total length
      let to = length * ((100 - value) / 100);
      // Trigger Layout in Safari hack https://jakearchibald.com/2013/animated-line-drawing-svg/
      path.getBoundingClientRect();
      // Set the Offset
      path.style.strokeDashoffset = Math.max(0, to);
      path.nextElementSibling.textContent = value > 9 ? value : `0${value}`;
    });
  })();

  // showhide btn
  $(".showhide-btn").click(function () {
    $(this).closest(".card-header").toggleClass("rounded-lg");
  });

  // $('.test-popup-link').magnificPopup({
  //   type: 'iframe',
  //   // other options
  // });
});
// Tracker Page Tooltip
const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
