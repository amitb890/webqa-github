@extends('layouts.master')
@section('title', 'Website Auditing and Testing Tool | Webqa')
@section('meta-description', 'This is home page meta description.')
@section("content")


<main class="main-sections">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="home-title">
          <h1>Test Your Website for <span class="typing-text"></span></h1>
            <p>
              Test a webpage for SEO, Page speed,
              Mobile Friendliness, HTML best practices and standards.
            </p>
          </div>
          <div class="home-search">
            <div class="footer_search_item">
              <form class="footer_search_box" id="footerTestForm">
                <input
                id="urlValue"
                  type="text"
                  class="footer_control"
                  name="search"
                  placeholder="Enter a URL to conduct a test"
                />
                <div class="footer_utils">
                  <a type="button" id="startTest" class="btn btn_primary rounded-pill">Test Now</a>
                </div>
              </form>
            </div>

            <div class="search-setting-container">
              <div class="search-setting">
                <p id="settingBtn">
                  Test Settings <i class="fa-solid fa-angle-down"></i>
                </p>
              </div>
            </div>
            
          </div>
         
          <div class="home-setting-wrap">
            <div class="home-setting-area active">
              <div class="home-setting-container">
                <!-- home setting tab sidebar start -->
                <div class="home-setting-sidebar">
                  <div
                    class="d-flex align-items-center justify-content-between"
                  >
                    <div class="form-check form-switch form-switch-2">
                      <input
                        class="form-check-input form-check-switch"
                        type="checkbox"
                        role="switch"
                        id="selectAllInput"
                        checked
                      />
                      <label class="form-check-label" for="selectAllInput"
                        >Select All</label
                      >
                    </div>
                    <button class="tav-menu-btn d-none">
                      <i class="fa-solid fa-angle-left"></i>
                    </button>
                  </div>
                  <div
                    class="accordion accordion-flush"
                    id="accordionFlushExample"
                  >
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-headingOne">
                      <input
                            class="form-check-input input-check-all"
                            id="metaTagsCheckAll"
                            type="checkbox"
                            value=""
                            checked
                          />
                        <label
                          class="accordion-button form-check-label collapsed"
                          role="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#flush-collapseOne"
                          aria-expanded="false"
                          aria-controls="flush-collapseOne"
                          id="metaTagsCollapse"
                        >
                          SEO
                        </label>
                      </h2>
                      <div
                        id="flush-collapseOne"
                        class="accordion-collapse collapse"
                        aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample"
                      >
                        <div class="accordion-body">
                          <div class="d-flex align-items-start">
                            <div
                              class="nav flex-column nav-pills"
                              id="v-pills-tab"
                              role="tablist"
                              aria-orientation="vertical"
                            >
                              <button
                                class="nav-link active"
                                data-controls="v-pills-title"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    value=""
                                    checked
                                    data-name="title"
                                  />
                                  Meta Title
                                </label>
                              </button>
                              <button
                                class="nav-link"
                                data-controls="v-pills-description"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    value=""
                                    checked
                                    data-name="description"
                                  />
                                  Meta Description
                                </label>
                              </button>
                              <button
                                class="nav-link"
                                data-controls="v-pills-robots"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="robots"
                                  />
                                  Robots Meta
                                </label>
                              </button>
                              <button
                                class="nav-link"
                                data-controls="v-pills-canonical"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="canonical"
                                  />
                                  Canonical URL
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-images"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="img"
                                  />
                                  Images
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-url"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="url"
                                  />
                                  URL Slug
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-robots"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="robot_text_test"
                                  />
                                  Robots.txt
                                </label>
                              </button>

                              <!-- <button
                                class="nav-link"
                                data-controls="v-pills-h1-heading"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="h1_heading_tag"
                                  />
                                  H1 heading tag
                                </label>
                              </button> -->

                              <button
                                class="nav-link"
                                data-controls="v-pills-xml-sitemap"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="xml_sitemap"
                                  />
                                  XML sitemap
                                </label>
                              </button>
                              <button
                                class="nav-link"
                                data-controls="v-pills-html-sitemap"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="html_sitemap"
                                  />
                                  HTML sitemap
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-open"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="og:title"
                                  />
                                  Open Graph Tags
                                </label>
                              </button>
                              <button
                                class="nav-link"
                                data-controls="v-pills-twiter"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="twitter:title"
                                  />
                                  Twitter Tags
                                </label>
                              </button>
                      
                              <button
                                class="nav-link"
                                data-controls="v-pills-favicon"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="icon"
                                  />
                                  Favicon
                                </label>
                              </button>
                      

                              <button
                                class="nav-link"
                                data-controls="v-pills-meta-viewport"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="viewport"
                                  />
                                  Meta Viewport
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-doctype"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="doctype"
                                  />
                                  Doctype
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-http-status"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="http_status_code"
                                  />
                                  HTTP Status Code
                                </label>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
            
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-headingThree">
                      <input
                            class="form-check-input input-check-all"
                            id="performanceCheckAll"
                            type="checkbox"
                            value=""
                            checked
                          />
                        <label
                          class="accordion-button form-check-label collapsed"
                          role="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#flush-collapseThree"
                          aria-expanded="false"
                          aria-controls="flush-collapseThree"
                        >
                          Performance
                        </label>
                      </h2>
                      <div
                        id="flush-collapseThree"
                        class="accordion-collapse collapse"
                        aria-labelledby="flush-headingThree"
                        data-bs-parent="#accordionFlushExample"
                      >
                        <div class="accordion-body">
                          <div class="d-flex align-items-start">
                            <div
                              class="nav flex-column nav-pills"
                              id="v-pills-tab"
                              role="tablist"
                              aria-orientation="vertical"
                            >
                       
                            <button
                                class="nav-link"
                                data-controls="v-pills-google-overall"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="google_overall"
                                  />
                                  Overall Score
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-google-lighthouse"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="google_lighthouse"
                                  />
                                  Lighthouse Score
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-google-core"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="core_web_vitals"
                                  />
                                  Core Web Vitals
                                </label>
                              </button>


                              <button
                                class="nav-link"
                                data-controls="v-pills-mobile-friendly"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="mobile_friendly"
                                  />
                                  Mobile Friendliness
                                </label>
                              </button>



                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-headingFour">
                      <input
                            class="form-check-input input-check-all"
                            id="CBPCheckAll"
                            type="checkbox"
                            value=""
                            checked
                          />
                        <label
                          class="accordion-button form-check-label collapsed"
                          role="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#flush-collapseFour"
                          aria-expanded="false"
                          aria-controls="flush-collapseFour"
                        >

                          Best Practices
                        </label>
                      </h2>
                      <div
                        id="flush-collapseFour"
                        class="accordion-collapse collapse"
                        aria-labelledby="flush-headingFour"
                        data-bs-parent="#accordionFlushExample"
                      >
                        <div class="accordion-body">
                          <div class="d-flex align-items-start">
                            <div
                              class="nav flex-column nav-pills"
                              id="v-pills-tab"
                              role="tablist"
                              aria-orientation="vertical"
                            >

                            <button
                                class="nav-link"
                                data-controls="v-pills-html-compression"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="html_compression"
                                  />
                                  HTML Compression
                                </label>
                              </button>


                              <button
                                class="nav-link"
                                data-controls="v-pills-css-compression"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="css_compression"
                                  />
                                  CSS Compression
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-js-compression"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="js_compression"
                                  />
                                  JS Compression
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-gzip-compression"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="gzip_compression"
                                  />
                                  GZIP Compression
                                </label>
                              </button>


                              <button
                                class="nav-link"
                                data-controls="v-pills-css-caching"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="css_caching_enable"
                                  />
                                  CSS Caching
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-js-caching"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="js_caching_enable"
                                  />
                                  JS Caching
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-nested"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="nested_tables"
                                  />
                                  Nested Tables
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-page-size"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="page_size"
                                  />
                                  Page Size
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-frameset"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="frameset"
                                  />
                                  Frameset
                                </label>
                              </button>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-headingFive">
                      <input
                            class="form-check-input input-check-all"
                            id="securityCheckAll"
                            type="checkbox"
                            value=""
                            checked
                          />
                        <label
                          class="accordion-button form-check-label collapsed"
                          role="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#flush-collapseFive"
                          aria-expanded="false"
                          aria-controls="flush-collapseFive"
                        >

                          Security
                        </label>
                      </h2>
                      <div
                        id="flush-collapseFive"
                        class="accordion-collapse collapse"
                        aria-labelledby="flush-headingFive"
                        data-bs-parent="#accordionFlushExample"
                      >
                        <div class="accordion-body">
                          <div class="d-flex align-items-start">
                            <div
                              class="nav flex-column nav-pills"
                              id="v-pills-tab"
                              role="tablist"
                              aria-orientation="vertical"
                            >
                             
                            <button
                                class="nav-link"
                                data-controls="v-pills-safe-browsing"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="is_safe_browsing"
                                  />
                                  Safe browsing
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-cross-origin"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="cross_origin_links"
                                  />
                                  Unsafe Cross Origin Links
                                </label>
                              </button>

                            <button
                                class="nav-link"
                                data-controls="v-pills-protocol"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="protocol_relative_resource"
                                  />
                                  Protocol Relative Resource Links
                                </label>
                              </button>


                              <button
                                class="nav-link d-none"
                                data-controls="v-pills-broken-links"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="broken_links"
                                  />
                                  Broken Links
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-content-security"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="content_security_policy_header"
                                  />
                                  Content Security Policy Header
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-x-frame"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="x_frame_options_header"
                                  />
                                  X Frame Options Header
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-hsts-header"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="hsts_header"
                                  />
                                  HSTS Header
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-ssl"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="ssl_certificate_enable"
                                  />
                                  SSL Certificate
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-content-type"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="bad_content_type"
                                  />
                                  Bad content Type
                                </label>
                              </button>

                              <button
                                class="nav-link"
                                data-controls="v-pills-folder"
                              >
                                <label class="form-check">
                                  <input
                                    class="form-check-input customizer-check-input"
                                    type="checkbox"
                                    checked
                                    data-name="folder_browsing_enable"
                                  />
                                  Directory Browsing
                                </label>
                              </button>

                            
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- <div class="accordion-btn">
                    <button
                      class="btn btn_primary rounded-pill"
                      type="button"
                    >
                      Reset to Default
                    </button>
                  </div> -->
                </div>
                <!-- home setting tab sidebar end -->

                <!-- home setting tab content start -->
                <div class="home-setting-tab-content active">
                  <div class="tab-content" id="v-pills-tabContent">
                    <div
                      class="tab-pane fade show active"
                      id="v-pills-title"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Meta Title</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="meta_title">
                                <label class="form-check-label" for="meta_title">Every page must have a meta title tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" max-value-check checked type="checkbox" id="max_title_length">
                                <label class="form-check-label" for="max_title_length">Maximum length of the Title tag should be <input value="65" id="max_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" min-value-check type="checkbox" id="min_title_length">
                                <label class="form-check-label" for="min_title_length">Minimum length of the Title tag should be <input value="0" id="min_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="is_title_equal_h1">
                                <label class="form-check-label" for="is_title_equal_h1">Title tag must not be equal to H1 heading tag</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_excluded_words">
                                <label class="form-check-label" for="is_excluded_words">Exclude specific words from casing checks (seperate each word with a comma)</label>
                            </div>
                            <div class="form-check">
                                <textarea style="display: none" class="form-control" placeholder="Separate each word with a comma" rows="4" id="excluded_words"></textarea>
                            </div>

                            <div class="form-check form-check-black">
                              <input
                                class="form-check-input toggleCasingChecks"
                                type="checkbox"
                                id="enableTitleCasingChecks"
                                checked
                              />
                              <label class="form-check-label" for="enableTitleCasingChecks">
                                Enable Casing Checks
                              </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input casing-check-input" name="radioTitleCasing" checked type="radio" id="title_casing_both">
                                <label class="form-check-label" for="title_casing_both">Title tag must be either in camel casing or sentence casing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input casing-check-input" name="radioTitleCasing" disabled type="radio" id="title_casing_camel">
                                <label class="form-check-label" for="title_casing_camel">Title tag must be in camel casing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input casing-check-input" name="radioTitleCasing" disabled type="radio" id="title_casing_sentence">
                                <label class="form-check-label" for="title_casing_sentence">Title tag must be in sentence casing</label>
                            </div>
                          </div>

                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="v-pills-description"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Meta Description</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="meta_desc">
                                <label class="form-check-label" for="meta_desc">Every page must have a meta description tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" max-value-check checked type="checkbox" id="max_desc_length">
                                <label class="form-check-label" for="max_desc_length">Maximum length of the description tag should be <input value="160" id="max_desc_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" min-value-check type="checkbox" id="min_desc_length">
                                <label class="form-check-label" for="min_desc_length">Minimum length of the description tag should be <input value="0" id="min_desc_length_val" type="number"> characters</label>
                            </div>
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="v-pills-robots"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Robots Meta Tag</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="live_urls_robots_meta">
                                <label class="form-check-label" for="live_urls_robots_meta">Live URLs Must Not have Robots meta tag
                          (noindex,nofollow), Unless intentionally added
                          on a case by case basis</label>
                            </div>
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="v-pills-canonical"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Canonical URL</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="canonical_url">
                                <label class="form-check-label" for="canonical_url">Every page must have a canonical URL tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="canonical_url_equal_url">
                                <label class="form-check-label" for="canonical_url_equal_url">Canonical URL must be equal to the actual URL (self canonicalise)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="canonical_url_ignore_slash">
                                <label class="form-check-label" for="canonical_url_ignore_slash">Ignore the Trailing Slash in Canonical URL</label>
                            </div>
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-images"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Images</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_max_size">
                            <label class="form-check-label" for="image_max_size">Maximum file size of an image file should be <input id="image_max_size_val" value="150"/> KB</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_name_only_hyphens">
                            <label class="form-check-label" for="image_name_only_hyphens">Words in image file must be separated by hyphens only</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_name_no_uppercase">
                            <label class="form-check-label" for="image_name_no_uppercase">Image file name can not have uppercase characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_name_no_special">
                            <label class="form-check-label" for="image_name_no_special">Image file name can not have special characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_name_max_characters">
                            <label class="form-check-label" for="image_name_max_characters">Maximum length of an image file name should be <input id="image_name_max_characters_val" value="50"/> Characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_alt">
                            <label class="form-check-label" for="image_alt">An image must have an alt text</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_alt_only_spaces">
                            <label class="form-check-label" for="image_alt_only_spaces">Words in alt text must be separated by spaces only</label>
                        </div>

                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-url"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">URL Slug</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                              <div class="form-check">
                                  <input class="form-check-input" checked type="checkbox" id="url_slug_lowercase">
                                  <label class="form-check-label" for="url_slug_lowercase">Every character in the URL needs to be lowercase</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox" id="url_no_numbers">
                                  <label class="form-check-label" for="url_no_numbers">URLs cannot contain numbers</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" checked type="checkbox" id="url_no_special">
                                  <label class="form-check-label" for="url_no_special">URLs cannot contain special characters</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" checked type="checkbox" id="max_url_length">
                                  <label class="form-check-label" for="max_url_length">Maximum length of a URL should be <input value="60" id="max_url_length_val" type="number" /> Characters (excluding the domain name)</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox" id="url_stop_words">
                                  <label class="form-check-label" for="url_stop_words">URLs must not contain specific stop words(separate each word with a comma)</label>
                              </div>
                              <div class="form-check">
                                  <textarea style="display: none" class="form-control" id="url_stop_words_val" rows="4" placeholder="Separate each word with a comma"></textarea>
                              </div>

                              <div class="form-check form-check-black">
                                <input checked class="form-check-input toggleCasingChecks" type="checkbox" id="enableURLChecks"/>
                                <label class="form-check-label" for="enableURLChecks">
                                  Enable URL Checks
                                </label>
                              </div>
                              <div class="form-check">
                                <input
                                  class="form-check-input casing-check-input"
                                  type="radio"
                                  name="urlCasingCheck" id="url_casing_only_hyphens"/>
                                <label class="form-check-label" for="url_casing_only_hyphens">
                                  Words in URLs should be separated by Hyphens
                                  only
                                </label>
                              </div>
                              <div class="form-check">
                                <input
                                  class="form-check-input casing-check-input"
                                  type="radio"
                                  name="urlCasingCheck" id="url_casing_only_underscores"/>
                                <label class="form-check-label" for="url_casing_only_underscores">
                                  Words in URLs should be separated by Underscores
                                  only
                                </label>
                              </div>
                              <div class="form-check">
                                <input
                                  class="form-check-input casing-check-input" 
                                  type="radio"
                                  name="urlCasingCheck" id="url_casing_both"/>
                                <label class="form-check-label" for="url_casing_both">
                                  Words in URLs can be separated by either Hyphens
                                  or underscores
                                </label>
                              </div>

                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>
                    
                    <div
                      class="tab-pane fade"
                      id="v-pills-robots"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Robots.txt</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="robot_text_test_block_url">
                            <label class="form-check-label" for="robot_text_test_block_url">No page on the website should be blockes in Robots.txt</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-xml-sitemap"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">XML Sitemap</h5>
                        <div class="meta-content">
                          <div class="accor-content">


                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="xml_sitemap">
                            <label class="form-check-label" for="xml_sitemap">Every page must be added to XML sitemap</label>
                          </div>

                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="xml_sitemap_custom">
                              <label class="form-check-label" for="xml_sitemap_custom">Add XML sitemap manually</label>
                          </div>
                          <div class="form-check">
                            <input class="input-inline" type="text" id="xml_sitemap_val" style="display: none" class="form-control">
                          </div>

                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-html-sitemap"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">HTML Sitemap</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="html_sitemap">
                            <label class="form-check-label" for="html_sitemap">Every page must be added to HTML sitemap</label>
                        </div>

                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="html_sitemap_custom">
                              <label class="form-check-label" for="html_sitemap_custom">Add HTML sitemap manually</label>
                          </div>
                          <div class="form-check">
                            <input class="input-inline" type="text" id="html_sitemap_val" style="display: none" class="form-control">
                          </div>

                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>
                    
      

                    <div
                      class="tab-pane fade"
                      id="v-pills-open"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Open Graph Tags</h5>
                        <div class="meta-content">
                          <div class="accor-content">

                          <div>
                            <h6>OG Title</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="og_title">
                                <label class="form-check-label" for="og_title">Every page must have a OG Title tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" max-value-check checked type="checkbox" id="max_og_title_length">
                                <label class="form-check-label" for="max_og_title_length">Maximum length of OG Title should be <input value="95" id="max_og_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" min-value-check checked type="checkbox" id="min_og_title_length">
                                <label class="form-check-label" for="min_og_title_length">Minimum length of OG Title should be <input value="40" id="min_og_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_og_title_equal_title">
                                <label class="form-check-label" for="is_og_title_equal_title">OG Title be equal to Title tag</label>
                            </div>

                            <div class="form-check form-check-black">
                              <input
                                class="form-check-input toggleCasingChecks"
                                type="checkbox"
                                id="enableTitleCasingChecks" checked/>
                              <label class="form-check-label" for="graphtitle5">
                                Enable Casing Checks
                              </label>
                            </div>

                            <div class="form-check">
                                <input name="radioOgTitleCasing" class="form-check-input casing-check-input" checked type="radio" id="og_title_casing_camel">
                                <label class="form-check-label" for="og_title_casing_camel">OG Title must be in camel casing</label>
                            </div>
                            <div class="form-check">
                                <input name="radioOgTitleCasing" class="form-check-input casing-check-input" type="radio" id="og_title_casing_sentence">
                                <label class="form-check-label" for="og_title_casing_sentence">OG Title must be in sentence casing</label>
                            </div>
                            <div class="form-check">
                                <input name="radioOgTitleCasing" class="form-check-input casing-check-input" type="radio" id="og_title_casing_both">
                                <label class="form-check-label" for="og_title_casing_both">OG Title must be either in camel casing or sentence casing</label>
                            </div>
                        </div>

                        <div>
                            <br>
                            <h6>OG Description</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="og_desc">
                                <label class="form-check-label" for="og_desc">Every page must have a OG Description tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" max-value-check checked type="checkbox" id="max_og_desc_length">
                                <label class="form-check-label" for="max_og_desc_length">Maximum length of the OG description tag should be <input value="200" id="max_og_desc_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" min-value-check checked type="checkbox" id="min_og_desc_length">
                                <label class="form-check-label" for="min_og_desc_length">Minimum length of the OG description tag should be <input value="40" id="min_og_desc_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_og_desc_equal_desc">
                                <label class="form-check-label" for="is_og_desc_equal_desc">OG Description must be the same as Meta description</label>
                            </div>
                        </div>

                        <div>
                            <br>
                            <h6>OG Image</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="og_image">
                                <label class="form-check-label" for="og_image">Every page must have a OG Image tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" image-check has-disabled="true" disabled type="checkbox" id="og_image_dimensions_min">
                                <label class="form-check-label" for="og_image_dimensions_min">Width of OG Image should be at least <input id="og_image_width_min" value="0" type="number" /> pixels and height of OG Image should be at least<input id="og_image_height_min" value="0" type="number" /> pixels</label>   
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" image-check has-disabled="true" checked type="checkbox" id="og_image_dimensions_exact">
                                <label class="form-check-label" for="og_image_dimensions_exact">Width of OG Image should be exactly <input id="og_image_width_exact" value="1200" type="number" /> pixels and height of OG Image should be exactly<input id="og_image_height_exact" value="630" type="number" /> pixels</label>   
                            </div>
                        </div>
                        
                        <div>
                            <br>
                            <h6>OG URL</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="og_url">
                                <label class="form-check-label" for="og_url">Every page must have a OG URL tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_og_url_equal_url">
                                <label class="form-check-label" for="is_og_url_equal_url">Open Graph URL must be equal to the actual URL</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="max_og_url_length">
                                <label class="form-check-label" for="max_og_url_length">Maximum length of OG URL should be <input value="60" id="max_og_url_length_val" type="number" /> characters</label>
                            </div>
                        </div>


                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="v-pills-twiter"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Twitter Tags</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                          
                          <div>
                            <h6>Twitter Title</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="twitter_title">
                                <label class="form-check-label" for="twitter_title">Every page must have a Twitter Title tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" max-value-check checked type="checkbox" id="max_twitter_title_length">
                                <label class="form-check-label" for="max_twitter_title_length">Maximum length of Twitter Title should be <input value="175" id="max_twitter_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" min-value-check type="checkbox" id="min_twitter_title_length">
                                <label class="form-check-label" for="min_twitter_title_length">Minimum length of Twitter Title should be <input value="0" id="min_twitter_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_twitter_title_equal_title">
                                <label class="form-check-label" for="is_twitter_title_equal_title">Twitter Title be equal to Title tag</label>
                            </div>

                            <div class="form-check form-check-black">
                              <input
                                class="form-check-input toggleCasingChecks"
                                type="checkbox"
                                id="enableTwitterTitleCasingChecks"
                                checked
                              />
                              <label
                                class="form-check-label"
                                for="enableTwitterTitleCasingChecks"
                              >
                                Enable Casing Checks
                              </label>
                            </div>

                            <div class="form-check">
                                <input name="twitterTitleCasing" class="form-check-input casing-check-input" checked type="radio" id="twitter_title_casing_camel">
                                <label class="form-check-label" for="twitter_title_casing_camel">Twitter Title must be in camel casing</label>
                            </div>
                            <div class="form-check">
                                <input name="twitterTitleCasing" class="form-check-input casing-check-input" type="radio" id="twitter_title_casing_sentence">
                                <label class="form-check-label" for="twitter_title_casing_sentence">Twitter Title must be in sentence casing</label>
                            </div>
                            <div class="form-check">
                                <input name="twitterTitleCasing" class="form-check-input casing-check-input" type="radio" id="twitter_title_casing_both">
                                <label class="form-check-label" for="twitter_title_casing_both">Twitter Title must be either in camel casing or sentence casing</label>
                            </div>
                        </div>
      
                        <div>
                            <br>
                            <h6>Twitter Image</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="twitter_image">
                                <label class="form-check-label" for="twitter_image">Every page must have a Twitter Image tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" image-check has-disabled="true" disabled type="checkbox" id="twitter_image_dimensions_min">
                                <label class="form-check-label" for="twitter_image_dimensions_min">Width of Twitter Image should be at least <input id="twitter_image_width_min" value="0" type="number" /> pixels and height of Twitter Image should be at least<input id="twitter_image_height_min" value="0" type="number" /> pixels</label>   
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" image-check has-disabled="true" checked type="checkbox" id="twitter_image_dimensions_exact">
                                <label class="form-check-label" for="twitter_image_dimensions_exact">Width of Twitter Image should be exactly <input id="twitter_image_width_exact" value="1200" type="number" /> pixels and height of Twitter Image should be exactly<input id="twitter_image_height_exact" value="675" type="number" /> pixels</label>   
                            </div>
                        </div>
   
                        <div>
                            <br>
                            <h6>Twitter Image Alt</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="twitter_image_alt">
                                <label class="form-check-label" for="twitter_image_alt">Every page must have a Twitter Image ALT tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="max_twitter_image_alt_length">
                                <label class="form-check-label" for="max_twitter_image_alt_length">Maximum length of Twitter Image ALT should be <input value="400" id="max_twitter_image_alt_length_val" type="number" /> characters</label>   
                            </div>
                        </div>


                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>
                    <div
                      class="tab-pane fade"
                      id="v-pills-favicon"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Favicon</h5>
                        <div class="meta-content">
                          <div class="accor-content">

                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="favicon">
                            <label class="form-check-label" for="favicon">Every page must have a Favicon</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" image-check has-disabled="true" type="checkbox" id="favicon_dimensions_min">
                            <label class="form-check-label" for="favicon_dimensions_min">Width of Favicon should be at least <input id="favicon_width_min" value="0" type="number" /> pixels and height of Favicon should be at least<input id="favicon_height_min" value="0" type="number" /> pixels</label>   
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" image-check has-disabled="true" type="checkbox" id="favicon_dimensions_exact">
                            <label class="form-check-label" for="favicon_dimensions_exact">Width of Favicon should be exactly <input id="favicon_width_exact" value="0" type="number" /> pixels and height of Favicon should be exactly<input id="favicon_height_exact" value="0" type="number" /> pixels</label>   
                        </div>

                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-meta-viewport"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Meta Viewport</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="meta_viewport">
                            <label class="form-check-label" for="meta_viewport">Every page must have a Meta Viewport Tag</label>
                        </div>

                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>
      

                    <div
                      class="tab-pane fade"
                      id="v-pills-http-status"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">HTTP Status Code</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          @include("components.http-status-code-settings")

                          
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-doctype"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Doctype</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="doctype">
                            <label class="form-check-label" for="doctype">Every page must have HTML Doctype declaration</label>
                          </div>

                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>



                    <!-- PERFORMANCE -->
                    <div
                      class="tab-pane fade"
                      id="v-pills-google-overall"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Overall Score</h5>
                        <div class="meta-content transparent">
                          <div class="accor-content">
                            
                          <div class="meta-content performance-content performance-content-analysis">
                            <div class="performance-left">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Desktop</h4>
                                  <svg
                                    width="27"
                                    height="24"
                                    viewBox="0 0 27 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.84603 0.81879C1.49767 1.04256 0.430452 2.01224 0.0919265 3.32044C0.0115984 3.63028 0.000122927 4.45651 0.000122927 10.2631C0.000122927 17.5156 -0.0170902 17.1426 0.355862 17.9115C0.631272 18.4795 1.28537 19.1106 1.89931 19.3975C2.16324 19.5238 2.5362 19.65 2.7198 19.6844C2.94357 19.7246 4.34932 19.7475 6.75342 19.7475H10.4428L9.98376 20.6656L9.52474 21.5836H8.15916C6.8567 21.5836 6.78785 21.5893 6.57555 21.7156C5.95014 22.0656 5.96735 22.9836 6.60424 23.3049C6.81654 23.4197 6.97146 23.4197 13.1395 23.4197C19.3076 23.4197 19.4625 23.4197 19.6748 23.3049C20.3231 22.9779 20.3231 22.0254 19.6748 21.6984C19.474 21.5951 19.3362 21.5836 18.1026 21.5836H16.7543L16.2953 20.6656L15.8362 19.7475H19.5485C23.6395 19.7475 23.6969 19.7418 24.4199 19.3975C24.9592 19.1393 25.6707 18.4336 25.9232 17.9115C26.2961 17.1426 26.2789 17.5098 26.2789 10.2803C26.2789 2.98765 26.2961 3.34339 25.8945 2.5688C25.6133 2.03519 24.9994 1.40978 24.4945 1.16305C23.6625 0.755676 24.6092 0.790102 13.3116 0.778627C7.71162 0.77289 3.00095 0.790102 2.84603 0.81879ZM23.3354 2.67781C23.7256 2.79257 24.0584 3.05076 24.2535 3.37782L24.4141 3.65322L24.4313 10.1828L24.4428 16.7123L24.3223 16.9992C24.2477 17.1656 24.0928 17.3779 23.9436 17.5098C23.4502 17.9459 24.3166 17.9115 13.1395 17.9115C2.00833 17.9115 2.8403 17.9402 2.35259 17.527C2.21488 17.4065 2.04849 17.1828 1.9739 17.0279L1.83619 16.7352V10.2459V3.75077L1.99685 3.45241C2.1862 3.08519 2.47308 2.83847 2.88046 2.70076C3.17308 2.60322 3.64358 2.59748 13.1166 2.59175C21.7518 2.59175 23.083 2.60322 23.3354 2.67781Z"
                                      fill="#222222"
                                    />
                                  </svg>
                                </div>
                                <div class="overall-item">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_insights_desktop"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_insights_desktop"
                                      >
                                        Overall Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="slider-range score-range1">
                                    <span class="span-left">0</span>
                                    <input
                                      id="score1"
                                      type="text"
                                      data-slider-id="slider22"
                                      class="slider-input"
                                      data-slider-min="0"
                                      data-slider-max="100"
                                      data-slider-step="1"
                                      data-slider-value="90"
                                      data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                    { "start": 7, "end": 8, "class": "category2" },
                                                                    { "start": 17, "end": 19 },
                                                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                    { "start": -3, "end": 19 }]'
                                    />
                                    <span class="span-right">100</span>
                                  </div>
                                  <div class="range-value">
                                    <p>Greater than</p>
                                    <input class="slider-input-text" type="number" id="google_insights_desktop_val" value="90" min="0" max="100">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Mobile area -->
                            <div class="performance-right">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Mobile</h4>
                                  <svg
                                    width="17"
                                    height="29"
                                    viewBox="0 0 17 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.02332 0.0441456C1.31131 0.215246 0.748334 0.822384 0.604829 1.57854C0.527557 1.98698 0.527557 26.2393 0.604829 26.6478C0.726256 27.2714 1.12917 27.8013 1.69767 28.0662L2.01228 28.2153H8.77357H15.5349L15.8495 28.0662C16.418 27.8013 16.8209 27.2714 16.9423 26.6478C17.0196 26.2393 17.0196 1.98698 16.9423 1.57854C16.8209 0.954849 16.418 0.424984 15.8495 0.160053L15.5349 0.0110283L8.88396 -1.14441e-05C5.1142 -1.14441e-05 2.14475 0.0165482 2.02332 0.0441456ZM10.9813 1.47367C11.0255 1.55095 11.0255 1.61718 10.9813 1.69445C10.9261 1.79932 10.8654 1.80484 8.77357 1.80484C6.68171 1.80484 6.621 1.79932 6.5658 1.69445C6.52165 1.61718 6.52165 1.55095 6.5658 1.47367C6.621 1.3688 6.68171 1.36329 8.77357 1.36329C10.8654 1.36329 10.9261 1.3688 10.9813 1.47367ZM15.6729 13.8648V24.7104H8.77357H1.8743V13.8648V3.01911H8.77357H15.6729V13.8648ZM9.08818 25.4335C9.27584 25.5052 9.52973 25.7371 9.6346 25.9358C9.81122 26.2724 9.69532 26.7857 9.38623 27.0452C8.75702 27.575 7.83527 27.139 7.83527 26.3111C7.83527 25.6819 8.50864 25.2127 9.08818 25.4335Z"
                                      fill="black"
                                    />
                                  </svg>
                                </div>
                                <div class="overall-item">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_insights_mobile"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_insights_mobile"
                                      >
                                        Overall Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="slider-range score-range1">
                                    <span class="span-left">0</span>
                                    <input
                                      id="score2"
                                      type="text"
                                      data-slider-id="slider22"
                                      class="slider-input"
                                      data-slider-min="0"
                                      data-slider-max="100"
                                      data-slider-step="1"
                                      data-slider-value="90"
                                      data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                    { "start": 7, "end": 8, "class": "category2" },
                                                                    { "start": 17, "end": 19 },
                                                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                    { "start": -3, "end": 19 }]'
                                    />
                                    <span class="span-right">100</span>
                                  </div>
                                  <div class="range-value">
                                    <p>Greater than</p>
                                    <input class="slider-input-text" type="number" id="google_insights_mobile_val" value="90" min="0" max="100">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-google-lighthouse"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Lighthouse Score</h5>
                        <div class="meta-content transparent">
                          <div class="accor-content">

                          
                          <div class="meta-content performance-content performance-content-analysis">
                            <div class="performance-left">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Desktop</h4>
                                  <svg
                                    width="27"
                                    height="24"
                                    viewBox="0 0 27 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.84603 0.81879C1.49767 1.04256 0.430452 2.01224 0.0919265 3.32044C0.0115984 3.63028 0.000122927 4.45651 0.000122927 10.2631C0.000122927 17.5156 -0.0170902 17.1426 0.355862 17.9115C0.631272 18.4795 1.28537 19.1106 1.89931 19.3975C2.16324 19.5238 2.5362 19.65 2.7198 19.6844C2.94357 19.7246 4.34932 19.7475 6.75342 19.7475H10.4428L9.98376 20.6656L9.52474 21.5836H8.15916C6.8567 21.5836 6.78785 21.5893 6.57555 21.7156C5.95014 22.0656 5.96735 22.9836 6.60424 23.3049C6.81654 23.4197 6.97146 23.4197 13.1395 23.4197C19.3076 23.4197 19.4625 23.4197 19.6748 23.3049C20.3231 22.9779 20.3231 22.0254 19.6748 21.6984C19.474 21.5951 19.3362 21.5836 18.1026 21.5836H16.7543L16.2953 20.6656L15.8362 19.7475H19.5485C23.6395 19.7475 23.6969 19.7418 24.4199 19.3975C24.9592 19.1393 25.6707 18.4336 25.9232 17.9115C26.2961 17.1426 26.2789 17.5098 26.2789 10.2803C26.2789 2.98765 26.2961 3.34339 25.8945 2.5688C25.6133 2.03519 24.9994 1.40978 24.4945 1.16305C23.6625 0.755676 24.6092 0.790102 13.3116 0.778627C7.71162 0.77289 3.00095 0.790102 2.84603 0.81879ZM23.3354 2.67781C23.7256 2.79257 24.0584 3.05076 24.2535 3.37782L24.4141 3.65322L24.4313 10.1828L24.4428 16.7123L24.3223 16.9992C24.2477 17.1656 24.0928 17.3779 23.9436 17.5098C23.4502 17.9459 24.3166 17.9115 13.1395 17.9115C2.00833 17.9115 2.8403 17.9402 2.35259 17.527C2.21488 17.4065 2.04849 17.1828 1.9739 17.0279L1.83619 16.7352V10.2459V3.75077L1.99685 3.45241C2.1862 3.08519 2.47308 2.83847 2.88046 2.70076C3.17308 2.60322 3.64358 2.59748 13.1166 2.59175C21.7518 2.59175 23.083 2.60322 23.3354 2.67781Z"
                                      fill="#222222"
                                    />
                                  </svg>
                                </div>
                                <!-- single item 1 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_performance_desktop"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_performance_desktop"
                                      >
                                        Performance Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score3"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">100</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_performance_desktop_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 2 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_accessibility_desktop"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_accessibility_desktop"
                                      >
                                        Accessibility
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score4"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_accessibility_desktop_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 3 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_best_practices_desktop"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_best_practices_desktop"
                                      >
                                        Best Practices
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score5"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_best_practices_desktop_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 4 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_seo_desktop"
                                        checked
                                      />
                                      <label class="form-check-label" for="google_seo_desktop">
                                        SEO
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score6"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_seo_desktop_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item -->
                              </div>
                            </div>

                            <!-- mobile area -->
                            <div class="performance-right">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Mobile</h4>
                                  <svg
                                    width="17"
                                    height="29"
                                    viewBox="0 0 17 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.02332 0.0441456C1.31131 0.215246 0.748334 0.822384 0.604829 1.57854C0.527557 1.98698 0.527557 26.2393 0.604829 26.6478C0.726256 27.2714 1.12917 27.8013 1.69767 28.0662L2.01228 28.2153H8.77357H15.5349L15.8495 28.0662C16.418 27.8013 16.8209 27.2714 16.9423 26.6478C17.0196 26.2393 17.0196 1.98698 16.9423 1.57854C16.8209 0.954849 16.418 0.424984 15.8495 0.160053L15.5349 0.0110283L8.88396 -1.14441e-05C5.1142 -1.14441e-05 2.14475 0.0165482 2.02332 0.0441456ZM10.9813 1.47367C11.0255 1.55095 11.0255 1.61718 10.9813 1.69445C10.9261 1.79932 10.8654 1.80484 8.77357 1.80484C6.68171 1.80484 6.621 1.79932 6.5658 1.69445C6.52165 1.61718 6.52165 1.55095 6.5658 1.47367C6.621 1.3688 6.68171 1.36329 8.77357 1.36329C10.8654 1.36329 10.9261 1.3688 10.9813 1.47367ZM15.6729 13.8648V24.7104H8.77357H1.8743V13.8648V3.01911H8.77357H15.6729V13.8648ZM9.08818 25.4335C9.27584 25.5052 9.52973 25.7371 9.6346 25.9358C9.81122 26.2724 9.69532 26.7857 9.38623 27.0452C8.75702 27.575 7.83527 27.139 7.83527 26.3111C7.83527 25.6819 8.50864 25.2127 9.08818 25.4335Z"
                                      fill="black"
                                    ></path>
                                  </svg>
                                </div>
                                <!-- single item 1 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_performance_mobile"
                                        checked
                                      />
                                      <label class="form-check-label" for="google_performance_mobile">
                                        Performance Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score7"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">100</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_performance_mobile_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 2 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_accessibility_mobile"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_accessibility_mobile"
                                      >
                                        Accessibility
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score8"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_accessibility_mobile_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 3 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_best_practices_mobile"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_best_practices_mobile"
                                      >
                                        Best Practices
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score9"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_best_practices_mobile_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 4 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_seo_mobile"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_seo_mobile"
                                      >
                                        SEO
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score10"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_seo_mobile_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item -->
                              </div>
                            </div>
                          </div>
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-google-core"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Core Web Vitals</h5>
                        <div class="meta-content transparent">
                          <div class="accor-content">

                          <div class="meta-content performance-content performance-content-analysis">
                            <div class="performance-left">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Desktop</h4>
                                  <svg
                                    width="27"
                                    height="24"
                                    viewBox="0 0 27 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.84603 0.81879C1.49767 1.04256 0.430452 2.01224 0.0919265 3.32044C0.0115984 3.63028 0.000122927 4.45651 0.000122927 10.2631C0.000122927 17.5156 -0.0170902 17.1426 0.355862 17.9115C0.631272 18.4795 1.28537 19.1106 1.89931 19.3975C2.16324 19.5238 2.5362 19.65 2.7198 19.6844C2.94357 19.7246 4.34932 19.7475 6.75342 19.7475H10.4428L9.98376 20.6656L9.52474 21.5836H8.15916C6.8567 21.5836 6.78785 21.5893 6.57555 21.7156C5.95014 22.0656 5.96735 22.9836 6.60424 23.3049C6.81654 23.4197 6.97146 23.4197 13.1395 23.4197C19.3076 23.4197 19.4625 23.4197 19.6748 23.3049C20.3231 22.9779 20.3231 22.0254 19.6748 21.6984C19.474 21.5951 19.3362 21.5836 18.1026 21.5836H16.7543L16.2953 20.6656L15.8362 19.7475H19.5485C23.6395 19.7475 23.6969 19.7418 24.4199 19.3975C24.9592 19.1393 25.6707 18.4336 25.9232 17.9115C26.2961 17.1426 26.2789 17.5098 26.2789 10.2803C26.2789 2.98765 26.2961 3.34339 25.8945 2.5688C25.6133 2.03519 24.9994 1.40978 24.4945 1.16305C23.6625 0.755676 24.6092 0.790102 13.3116 0.778627C7.71162 0.77289 3.00095 0.790102 2.84603 0.81879ZM23.3354 2.67781C23.7256 2.79257 24.0584 3.05076 24.2535 3.37782L24.4141 3.65322L24.4313 10.1828L24.4428 16.7123L24.3223 16.9992C24.2477 17.1656 24.0928 17.3779 23.9436 17.5098C23.4502 17.9459 24.3166 17.9115 13.1395 17.9115C2.00833 17.9115 2.8403 17.9402 2.35259 17.527C2.21488 17.4065 2.04849 17.1828 1.9739 17.0279L1.83619 16.7352V10.2459V3.75077L1.99685 3.45241C2.1862 3.08519 2.47308 2.83847 2.88046 2.70076C3.17308 2.60322 3.64358 2.59748 13.1166 2.59175C21.7518 2.59175 23.083 2.60322 23.3354 2.67781Z"
                                      fill="#222222"
                                    />
                                  </svg>
                                </div>
                                <!-- single item 1 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_lcp_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_lcp_desktop"
                                      >
                                        Largest Contentful Paint
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range2">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score11"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="5"
                                        data-slider-step="0.5"
                                        data-slider-value="2.5"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_lcp_desktop_val" value="2.5" min="0" max="5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 2 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_fcp_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_fcp_desktop"
                                      >
                                        First CP Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range2">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score12"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="5"
                                        data-slider-step="0.5"
                                        data-slider-value="2"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_fcp_desktop_val" value="2" min="0" max="5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 3 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_cls_desktop" 
                                        checked
                                      />
                                      <label class="form-check-label" for="google_cls_desktop">
                                        Cumulative Layout Shift
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range3">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score13"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="0.5"
                                        data-slider-step="0.1"
                                        data-slider-value=".1"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">0.5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_cls_desktop_val" value=".1" min="0" max="0.5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 4 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_fid_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_fid_desktop"
                                      >
                                        First Input Delay
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range4">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score14"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="500"
                                        data-slider-step="1"
                                        data-slider-value="100"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">500</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_fid_desktop_val" value="100" min="0" max="500">
                                        <span>ms</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 5 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_tbt_desktop" 
                                        checked
                                      />
                                      <label class="form-check-label" for="google_tbt_desktop">
                                        Total Blocking TIme
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range4">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score15"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="500"
                                        data-slider-step="1"
                                        data-slider-value="300"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">500</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_tbt_desktop_val" value="300" min="0" max="500">
                                        <span>ms</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 6 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_tti_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_tti_desktop"
                                      >
                                        Time to Interactive
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range5">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score16"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="8"
                                        data-slider-step="1"
                                        data-slider-value="4"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">8</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_tti_desktop_val" value="4" min="0" max="8">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 7 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_speed_index_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_speed_index_desktop"
                                      >
                                        Speed Index
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range5">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score17"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="8"
                                        data-slider-step="1"
                                        data-slider-value="4"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">8</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_speed_index_desktop_val" value="4" min="0" max="8">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item -->
                              </div>
                            </div>

                            <!-- mobile area -->
                            <div class="performance-right">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Mobile</h4>
                                  <svg
                                    width="17"
                                    height="29"
                                    viewBox="0 0 17 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.02332 0.0441456C1.31131 0.215246 0.748334 0.822384 0.604829 1.57854C0.527557 1.98698 0.527557 26.2393 0.604829 26.6478C0.726256 27.2714 1.12917 27.8013 1.69767 28.0662L2.01228 28.2153H8.77357H15.5349L15.8495 28.0662C16.418 27.8013 16.8209 27.2714 16.9423 26.6478C17.0196 26.2393 17.0196 1.98698 16.9423 1.57854C16.8209 0.954849 16.418 0.424984 15.8495 0.160053L15.5349 0.0110283L8.88396 -1.14441e-05C5.1142 -1.14441e-05 2.14475 0.0165482 2.02332 0.0441456ZM10.9813 1.47367C11.0255 1.55095 11.0255 1.61718 10.9813 1.69445C10.9261 1.79932 10.8654 1.80484 8.77357 1.80484C6.68171 1.80484 6.621 1.79932 6.5658 1.69445C6.52165 1.61718 6.52165 1.55095 6.5658 1.47367C6.621 1.3688 6.68171 1.36329 8.77357 1.36329C10.8654 1.36329 10.9261 1.3688 10.9813 1.47367ZM15.6729 13.8648V24.7104H8.77357H1.8743V13.8648V3.01911H8.77357H15.6729V13.8648ZM9.08818 25.4335C9.27584 25.5052 9.52973 25.7371 9.6346 25.9358C9.81122 26.2724 9.69532 26.7857 9.38623 27.0452C8.75702 27.575 7.83527 27.139 7.83527 26.3111C7.83527 25.6819 8.50864 25.2127 9.08818 25.4335Z"
                                      fill="black"
                                    ></path>
                                  </svg>
                                </div>
                                <!-- single item 1 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_lcp_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_lcp_mobile"
                                      >
                                        Largest Contentful Paint
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range2">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score18"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="5"
                                        data-slider-step="0.5"
                                        data-slider-value="2.5"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_lcp_mobile_val" value="2.5" min="0" max="5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 2 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_fcp_mobile" 
                                        checked
                                      />
                                      <label class="form-check-label" for="google_fcp_mobile">
                                        First CP Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range2">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score19"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="5"
                                        data-slider-step="0.5"
                                        data-slider-value="2"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_fcp_mobile_val" value="2" min="0" max="5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 3 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_cls_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_cls_mobile"
                                      >
                                        Cumulative Layout Shift
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range3">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score20"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="0.5"
                                        data-slider-step="0.1"
                                        data-slider-value="0.1"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">0.5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_cls_mobile_val" value="0.1" min="0" max="0.5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 4 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_fid_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_fid_mobile"
                                      >
                                        First Input Delay
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range4">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score21"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="500"
                                        data-slider-step="1"
                                        data-slider-value="100"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">500</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_fid_mobile_val" value="100" min="0" max="500">
                                        <span>ms</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 5 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_tbt_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_tbt_mobile"
                                      >
                                        Total Blocking TIme
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range4">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score22"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="500"
                                        data-slider-step="1"
                                        data-slider-value="300"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">500</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_tbt_mobile_val" value="300" min="0" max="500">
                                        <span>ms</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 6 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_tti_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_tti_mobile"
                                      >
                                        Time to Interactive
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range5">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score23"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="8"
                                        data-slider-step="1"
                                        data-slider-value="4"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">8</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_tti_mobile_val" value="4" min="0" max="8">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 7 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_speed_index_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_speed_index_mobile"
                                      >
                                        Speed Index
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range5">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score24"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="8"
                                        data-slider-step="1"
                                        data-slider-value="4"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">8</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_speed_index_mobile_val" value="4" min="0" max="8">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item -->
                              </div>
                            </div>
                          </div>

                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-mobile-friendly"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Mobile Friendly</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="mobile_friendly">
                            <label class="form-check-label" for="mobile_friendly">Page should be mobile friendly</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-html-compression"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">HTML Code Compression</h5>
                        <div class="meta-content">
                          <div class="accor-content">

                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_html_compression">
                            <label class="form-check-label" for="is_html_compression">HTML Code has to be compressed and minified</label>
                          </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-css-compression"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">CSS Code Compression</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_css_compression">
                            <label class="form-check-label" for="is_css_compression">All external stylesheets code must be compressed and minified</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-js-compression"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">JS Code Compression</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_js_compression">
                            <label class="form-check-label" for="is_js_compression">All external JavaScript code must be compressed and minified</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-gzip-compression"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">GZIP Compression</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_gzip_compression">
                            <label class="form-check-label" for="is_gzip_compression">The HTML page must have GZIP compression enabled</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>



                    <div
                      class="tab-pane fade"
                      id="v-pills-css-caching"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">CSS Caching</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="css_caching_enable">
                            <label class="form-check-label" for="css_caching_enable">CSS Caching</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-js-caching"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">JS Caching</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="js_caching_enable">
                            <label class="form-check-label" for="js_caching_enable">JS Caching</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-nested"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Nested Tables</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="no_nested_tables">
                            <label class="form-check-label" for="no_nested_tables">The HTML Page should not have any nested tables.</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-page-size"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">HTML Page Size</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                            <div class="form-check">
                                  <input class="form-check-input" checked type="checkbox" id="page_size">
                                <label class="form-check-label" for="page_size">Maximum size of the HTML page should be <input class="slider-input-text" type="number" id="page_size_val" value="100" min="0" max="100"> KB</label>
                            </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-frameset"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Frameset</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="no_frameset">
                            <label class="form-check-label" for="no_frameset">Webpage should not be using any frameset tag</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                    <div
                      class="tab-pane fade"
                      id="v-pills-safe-browsing"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Safe Browsing</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_safe_browsing">
                            <label class="form-check-label" for="is_safe_browsing">Safe Browsing.</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-cross-origin"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Unsafe Cross Origin Links</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="cross_origin_links">
                            <label class="form-check-label" for="cross_origin_links">Cross Origin Links</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-protocol"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Protocol Relative Resource Links</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                                     
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="protocol_relative_resource">
                            <label class="form-check-label" for="protocol_relative_resource">Protocol Relative Resource Links</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-robots"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Robots.txt</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="robot_text_test_block_url">
                            <label class="form-check-label" for="robot_text_test_block_url">No page on the website should be blocked in Robots.txt</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

              

                    <div
                      class="tab-pane fade d-none"
                      id="v-pills-broken-links"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Broken Links</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="broken_links">
                            <label class="form-check-label" for="broken_links">Broken Links</label>
                        </div>
                        
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-content-security"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Content Security Policy Header</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="content_security_policy_header">
                            <label class="form-check-label" for="content_security_policy_header">Content Security Policy Header must be enabled.</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-x-frame"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">X Frame Options Header</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="x_frame_options_header">
                            <label class="form-check-label" for="x_frame_options_header">X Frame Options Header must be enabled.</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-hsts-header"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">HSTS Header</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="hsts_header">
                            <label class="form-check-label" for="hsts_header">Every page must have HSTS enabled</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-ssl"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">SSL Certificate</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="ssl_certificate_enable">
                            <label class="form-check-label" for="ssl_certificate_enable">SSL Certificate</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-content-type"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Bad Content Type</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="bad_content_type">
                            <label class="form-check-label" for="bad_content_type">Bad Content Type.</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>

                    <div
                      class="tab-pane fade"
                      id="v-pills-folder"
                    >
                      <div class="home-meta-content">
                        <h5 class="home-meta-title">Bad Content Type</h5>
                        <div class="meta-content">
                          <div class="accor-content">
                            
                          <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="folder_browsing_enable">
                            <label class="form-check-label" for="folder_browsing_enable">Directory Browsing</label>
                        </div>
                        
                          </div>
                          <div class="home-content-button">
                            <input
                              class="btn-cancel btn btn_primary rounded-pill"
                              type="submit"
                              value="Cancel"
                            />
                            <input
                              class="btn-done btn btn_primary rounded-pill"
                              type="submit"
                              value="Done"
                            />
                          </div>
                        </div>
                        <!-- <div class="accor-content-button">
                          <input
                            class="btn btn_primary rounded-pill"
                            type="reset"
                            value="Reset to Default"
                          />
                        </div> -->
                      </div>
                    </div>


                  </div>
                </div>
                <!-- home setting tab content end -->
              </div>
            </div>
          </div>

          <!--  w_area Css Start-->
          <div class="w_area">
            <div class="w_content">
              <img src="/new-assets/assets/images/home/w.png" alt="img" />
            </div>
          </div>
          <!--  w_area Css End -->

          <!--  what_webqa_area Css Start-->
          <div class="what_webqa_area">
            <div class="home_section_title">
              <h2>What is WebQA?</h2>
              <p>
                WebQA is more than just a website audit tool — it’s a customizable platform that helps you uncover hidden issues, improve performance, and keep your site secure. With flexible settings, actionable insights, and clear reports, WebQA adapts to your needs and makes optimizing your website simple and effective.
              </p>
            </div>
            <div class="what_webqa_content">
              <div class="single_what_item_main">
                <div class="single_what_item">
                  <img src="/new-assets/assets/images/home/check.svg" alt="icon" />
                  <p>
                    <b>Customisable QA process</b> - Tailor every test with your own rules and benchmarks for truly relevant results.
                  </p>
                </div>
              </div>
              <div class="single_what_item_main">
                <div class="single_what_item">
                  <img src="/new-assets/assets/images/home/check.svg" alt="icon" />
                  <p><b>Comprehensive Checks </b>- From SEO and speed to security and best practices — WebQA covers it all.</p>
                </div>
              </div>
              <div class="single_what_item_main">
                <div class="single_what_item">
                  <img src="/new-assets/assets/images/home/check.svg" alt="icon" />
                  <p>
                    <b>Actionable Insights</b> - Get clear pass/fail results with recommendations you can implement right away.
                  </p>
                </div>
              </div>
              <div class="single_what_item_main">
                <div class="single_what_item">
                  <img src="/new-assets/assets/images/home/check.svg" alt="icon" />
                  <p>
                    <b>Easy reporting</b> - Turn audits into shareable reports that track progress and prove value.
                  </p>
                </div>
              </div>
            </div>
            <div class="Features_btn_area">
              <a href="https://webqa.co/features" class="Features_btn">See All Features</a>
            </div>
          </div>
          <!--  what_webqa_area Css End -->

          <!-- Learn More Video Area Start -->
          <div class="learn_more_video_area">
            <div class="learn_more_content">
              <h4>Learn more about WebQA. Watch the video</h4>

              <div class="video-wrapper">
                <video width="100%" height="100%" loop autoplay muted>
                  <source src="/new-assets/assets/images/home-video.mp4" type="video/mp4">
                Your browser does not support the video tag.
                </video>
              </div>
            </div>
          </div>
          <!-- Learn More Video Area End -->

          <!-- Designed Area Start -->
          <div class="Designed_area">
            <div class="home_section_title">
              <h2>Built for teams who want flawless websites</h2>
              <p>
                WebQA is built for anyone who cares about website performance, security, and growth. Whether you optimize for search, manage projects, build websites, or run a business, WebQA gives you the insights you need to fix issues and keep your site at its best.
              </p>
            </div>
            <div class="Designed_content">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="seoAnalysts-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#seoAnalysts"
                    type="button"
                    role="tab"
                    aria-controls="seoAnalysts"
                    aria-selected="true"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="34"
                      height="34"
                      viewBox="0 0 34 34"
                      fill="none"
                    >
                      <g clip-path="url(#clip0_5397_8007)">
                        <path
                          d="M28.9643 14.4661C28.9287 16.6426 28.4127 18.7842 27.4532 20.7377C27.2659 21.1203 27.3258 21.323 27.6124 21.6048C29.3215 23.2898 31.0177 24.9859 32.7013 26.693C33.8913 27.8981 34.2697 29.362 33.8072 30.9714C33.3651 32.5118 32.3038 33.5218 30.7289 33.8776C29.1541 34.2334 27.7602 33.7921 26.6059 32.6304C24.9495 30.9599 23.2626 29.3148 21.6151 27.6239C21.3004 27.3013 21.0762 27.2974 20.6914 27.4811C12.3242 31.4802 2.45612 26.7032 0.36019 17.6504C-1.42358 9.92379 3.60411 1.97533 11.3253 0.329017C19.1446 -1.3377 26.7613 3.48137 28.5413 11.259C28.7846 12.3059 28.8279 13.3962 28.9643 14.4661ZM14.4826 25.5262C20.7067 25.4063 25.5165 20.5643 25.4974 14.4317C25.4795 8.2099 20.5665 3.38573 14.4329 3.4074C8.21771 3.42908 3.39771 8.33742 3.41554 14.4814C3.42956 20.6956 8.33621 25.4369 14.4826 25.5262ZM24.0933 25.2839C25.8057 27.0003 27.4876 28.7027 29.1898 30.3848C29.5338 30.7227 29.9823 30.701 30.3365 30.3592C30.6907 30.0175 30.6754 29.6056 30.3887 29.2115C30.3086 29.113 30.2208 29.0209 30.1263 28.9361C28.6279 27.4339 27.1287 25.9329 25.6286 24.4333C25.5139 24.3185 25.3738 24.2216 25.2464 24.1132L24.0933 25.2839Z"
                          fill="#7790AE"
                          stroke="white"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_5397_8007">
                          <rect width="34" height="34" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                    SEO Analysts
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="websiteOwners-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#websiteOwners"
                    type="button"
                    role="tab"
                    aria-controls="websiteOwners"
                    aria-selected="false"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="39"
                      height="34"
                      viewBox="0 0 39 34"
                      fill="none"
                    >
                      <g clip-path="url(#clip0_5397_8018)">
                        <path
                          d="M26.8933 24.3069C27.7403 22.486 28.5495 20.7489 29.3575 19.0094C29.6768 18.3244 29.9826 17.6333 30.3166 16.9569C30.67 16.2387 31.1526 16.0243 31.9008 16.2177C33.6277 16.6489 35.3558 17.0801 37.0814 17.5113C38.2526 17.807 38.9899 18.7433 38.9911 19.9617C38.9984 23.8219 38.9984 27.6821 38.9911 31.5422C38.9911 32.9824 37.9516 34.0062 36.5196 34.0062C29.7763 34.0062 23.0358 34.0062 16.2982 34.0062C15.333 34.0062 14.8723 33.5516 14.8711 32.5906C14.8711 28.3822 14.8711 24.1746 14.8711 19.9678C14.8711 18.7654 15.5901 17.8156 16.7125 17.5273C18.3955 17.0949 20.0834 16.6736 21.7688 16.251C22.6621 16.028 23.1093 16.251 23.5139 17.1047C24.5766 19.379 25.6369 21.6544 26.6947 23.9311C26.741 24.0149 26.7897 24.1036 26.8933 24.3069ZM36.4233 31.5004C36.4485 31.3908 36.4664 31.2797 36.477 31.1677C36.477 27.5753 36.477 23.9828 36.4892 20.3904C36.4892 20.0036 36.2905 19.9075 35.9944 19.8323C34.8976 19.5551 33.8007 19.2779 32.7039 18.986C32.303 18.8788 32.1056 18.9958 31.924 19.395C30.6834 22.1283 29.4217 24.8518 28.1388 27.5654C28.002 27.8816 27.7877 28.1572 27.5161 28.3662C26.8226 28.8356 26.0841 28.5288 25.6661 27.6332C24.3767 24.8768 23.0951 22.1172 21.8212 19.3543C21.6494 18.9847 21.4458 18.8911 21.0741 18.9934C20.0614 19.2742 19.0487 19.5625 18.0275 19.7917C17.5327 19.9013 17.3389 20.0824 17.3438 20.6343C17.3722 24.0214 17.3722 27.4086 17.3438 30.7957C17.3438 31.3648 17.4986 31.5151 18.0579 31.5127C23.9661 31.493 29.8791 31.5004 35.7848 31.5004H36.4233Z"
                          fill="#7790AE"
                          stroke="white"
                          stroke-width="0.5"
                        />
                        <path
                          d="M26.7112 0C27.6839 0.000566218 28.647 0.19481 29.5455 0.571637C30.4439 0.948464 31.2602 1.50049 31.9476 2.19621C32.635 2.89193 33.1801 3.71772 33.5519 4.62641C33.9236 5.53511 34.1146 6.50892 34.1141 7.49225C34.1135 8.47558 33.9214 9.44916 33.5486 10.3574C33.1758 11.2657 32.6298 12.0908 31.9415 12.7858C31.2533 13.4807 30.4365 14.0317 29.5376 14.4075C28.6387 14.7833 27.6754 14.9764 26.7027 14.9759C22.6079 14.9635 19.2554 11.583 19.2578 7.46945C19.2603 3.3559 22.5909 0 26.7112 0ZM21.8036 7.46206C21.7955 8.11367 21.9158 8.7604 22.1573 9.36458C22.3988 9.96877 22.7569 10.5183 23.2105 10.9813C23.6642 11.4443 24.2044 11.8114 24.7998 12.0613C25.3951 12.3111 26.0337 12.4388 26.6783 12.4368C29.4301 12.4442 31.6676 10.1983 31.642 7.45467C31.6307 6.13745 31.105 4.8781 30.1794 3.95093C29.2538 3.02376 28.0033 2.5039 26.7002 2.5046C26.0558 2.50166 25.4171 2.62794 24.8213 2.87612C24.2254 3.12431 23.6841 3.48948 23.2287 3.9505C22.7734 4.41153 22.4129 4.95926 22.1683 5.56202C21.9237 6.16477 21.7998 6.81057 21.8036 7.46206Z"
                          fill="#7790AE"
                          stroke="white"
                          stroke-width="0.5"
                        />
                        <path
                          d="M11.0524 23.3262L12.1114 22.1201L14.004 23.7623C13.2533 24.6247 12.5636 25.5043 11.7787 26.2854C11.2913 26.7634 10.5308 26.5823 10.0092 25.9786C8.79705 24.5717 7.59178 23.1582 6.39341 21.7382C5.51353 20.6971 5.51841 20.691 4.22296 21.1394C3.6709 21.3304 2.89705 21.3784 2.63869 21.7727C2.3523 22.2026 2.52778 22.9554 2.52656 23.5676C2.52656 25.9688 2.52656 28.3723 2.52656 30.771V31.4991H8.141V33.9988H6.9735C5.47088 33.9988 3.96947 33.9988 2.46441 33.9988C1.04344 33.9914 0.0148743 32.9614 0.0112183 31.5163C0.0014689 28.2311 0.0014689 24.9458 0.0112183 21.6606C0.0112183 20.5518 0.612029 19.7042 1.66131 19.3358C2.86414 18.9133 4.08281 18.5375 5.28076 18.1038C6.01197 17.8377 6.56037 18.0312 7.05028 18.6188C8.1739 19.9678 9.32189 21.2959 10.4626 22.6326C10.6405 22.8543 10.8282 23.0675 11.0524 23.3262Z"
                          fill="#7790AE"
                          stroke="white"
                          stroke-width="0.5"
                        />
                        <path
                          d="M17.5821 11.2812C17.5918 12.1478 17.431 13.0078 17.1089 13.811C16.7869 14.6143 16.31 15.3448 15.7062 15.9601C15.1023 16.5753 14.3835 17.0631 13.5915 17.3949C12.7994 17.7268 11.95 17.8962 11.0927 17.8932C7.45616 17.9092 4.51915 14.9931 4.51184 11.3637C4.50118 9.61206 5.17927 7.92787 6.39696 6.68164C7.61466 5.43541 9.2722 4.72923 11.0049 4.71845C12.7377 4.70767 14.4037 5.39317 15.6365 6.62415C16.8692 7.85513 17.5678 9.53075 17.5785 11.2824L17.5821 11.2812ZM11.0756 7.25508C8.79548 7.25508 6.99915 9.04761 7.00768 11.3206C7.02863 12.395 7.46622 13.418 8.22616 14.1693C8.98611 14.9207 10.0076 15.3401 11.0706 15.3374C12.1335 15.3346 13.1529 14.9099 13.909 14.1546C14.6652 13.3994 15.0976 12.3741 15.1131 11.2997C15.111 10.7658 15.0049 10.2375 14.8009 9.74506C14.5969 9.25262 14.2989 8.80561 13.924 8.42958C13.5491 8.05355 13.1046 7.75586 12.6158 7.55349C12.1271 7.35112 11.6037 7.24805 11.0756 7.25016V7.25508Z"
                          fill="#7790AE"
                          stroke="white"
                          stroke-width="0.5"
                        />
                        <path
                          d="M10.3477 33.9581V31.5447H12.7484V33.9581H10.3477Z"
                          fill="#7790AE"
                          stroke="white"
                          stroke-width="0.5"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_5397_8018">
                          <rect width="39" height="34" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                    Website Owners
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="webDeveloper-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#webDeveloper"
                    type="button"
                    role="tab"
                    aria-controls="webDeveloper"
                    aria-selected="false"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="40"
                      height="29"
                      viewBox="0 0 40 29"
                      fill="none"
                    >
                      <g clip-path="url(#clip0_5397_8032)">
                        <path
                          d="M14.5508 27.0299C14.7007 26.4872 14.8955 25.7505 15.1067 25.0165C17.366 17.1643 19.628 9.31253 21.8926 1.46125C22.2088 0.364966 23.119 -0.194031 24.0946 0.0624022C25.1357 0.33376 25.6671 1.31065 25.3415 2.4612C23.8744 7.63419 22.3977 12.8072 20.9116 17.9802C20.0259 21.0736 19.1251 24.163 18.2462 27.2606C18.0132 28.0842 17.6807 28.772 16.7296 28.9634C15.6136 29.1886 14.5685 28.3745 14.5508 27.0299Z"
                          fill="#7790AE"
                          stroke="white"
                        />
                        <path
                          d="M4.37543 14.5624C6.35261 16.5203 8.27119 18.4062 10.1707 20.3139C10.4635 20.5921 10.6918 20.9306 10.8397 21.3057C10.9666 21.6848 10.958 22.0959 10.8155 22.4695C10.673 22.8431 10.4052 23.1561 10.0576 23.3558C9.26999 23.8185 8.48511 23.7235 7.76973 23.0234C6.20271 21.4861 4.65342 19.9313 3.0973 18.3832C2.29471 17.5854 1.48802 16.7903 0.693602 15.9857C-0.224811 15.0536 -0.234358 14.055 0.684054 13.1365C3.00325 10.8154 5.32838 8.49986 7.65938 6.1897C8.56281 5.29286 9.64201 5.23995 10.4173 6.03638C11.1545 6.79076 11.0891 7.89654 10.2375 8.74996C8.3148 10.6576 6.38395 12.568 4.37543 14.5624Z"
                          fill="#7790AE"
                          stroke="white"
                        />
                        <path
                          d="M35.6146 14.5434C33.6252 12.572 31.7025 10.6562 29.7662 8.75402C29.3043 8.2995 29.0181 7.79206 29.0849 7.13401C29.1028 6.79277 29.2231 6.46474 29.4303 6.19236C29.6376 5.91999 29.9221 5.71581 30.2472 5.60627C31.0144 5.31456 31.6711 5.53029 32.2298 6.08115C33.7914 7.62427 35.3489 9.17101 36.9023 10.7214C37.7049 11.5205 38.5129 12.3129 39.306 13.1202C40.2217 14.0523 40.2325 15.0522 39.3141 15.9694C36.9795 18.3085 34.6376 20.6399 32.2884 22.9637C31.4232 23.8171 30.3344 23.8429 29.5781 23.0654C28.8219 22.288 28.9091 21.2107 29.7635 20.3518C31.6889 18.4456 33.617 16.5338 35.6146 14.5434Z"
                          fill="#7790AE"
                          stroke="white"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_5397_8032">
                          <rect width="40" height="29" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                    Web Developers
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="projectManagers-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#projectManagers"
                    type="button"
                    role="tab"
                    aria-controls="projectManagers"
                    aria-selected="false"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="34"
                      viewBox="0 0 24 34"
                      fill="none"
                    >
                      <g clip-path="url(#clip0_5397_8037)">
                        <path
                          d="M10.3641 23.1934C10.5521 21.8885 10.7454 20.5836 10.9174 19.2766C10.9355 19.1395 10.8441 18.9738 10.7698 18.8399C10.4682 18.3001 10.1475 17.7773 9.84592 17.2322C9.32663 16.3045 9.78221 15.5097 10.8346 15.5033C11.6481 15.5033 12.4626 15.4927 13.2771 15.5033C14.1681 15.5171 14.6236 16.2907 14.2243 17.0972C14.1302 17.3065 14.0161 17.5061 13.8834 17.6933C13.2027 18.5817 12.9638 19.5274 13.2601 20.6474C13.4725 21.4698 13.5234 22.338 13.7666 23.1976C14.1426 22.1655 14.5188 21.133 14.8955 20.1001C15.3426 18.876 15.7875 17.6498 16.2399 16.4267C16.567 15.5448 16.9833 15.3439 17.8795 15.6234C19.0721 15.9932 20.305 16.261 21.3351 17.0345C22.9949 18.2788 23.9263 19.9503 23.9634 22.0075C24.0272 25.6203 23.99 29.2332 23.9836 32.846C23.9836 33.5824 23.5588 34.0021 22.8261 34.0021C15.6049 34.0064 8.38646 34.0064 1.17088 34.0021C0.444513 34.0021 0.017597 33.5771 0.0154731 32.8428C0.00910143 29.2491 -0.0227435 25.6554 0.0292919 22.0617C0.0707078 19.216 1.9408 16.873 4.70186 16.0506C5.19248 15.905 5.68308 15.7626 6.17158 15.6138C7.00096 15.3609 7.43954 15.5639 7.74114 16.3832C8.53123 18.5339 9.31071 20.6877 10.0966 22.8406C10.1433 22.9681 10.2027 23.0935 10.2505 23.2199L10.3641 23.1934ZM21.8735 31.8663V31.2287C21.8735 28.3625 21.8735 25.4967 21.8735 22.6312C21.8735 20.0109 20.5631 18.418 17.9443 17.8878C16.2452 22.5399 14.5461 27.2001 12.847 31.8684L21.8735 31.8663ZM11.1479 31.8578L6.04415 17.8634C3.30008 18.435 2.02576 20.3243 2.10434 22.9277C2.18823 25.7022 2.12345 28.4819 2.12345 31.2596V31.8557L11.1479 31.8578Z"
                          fill="#7790AE"
                        />
                        <path
                          d="M5.51228 6.47652C5.52715 5.19596 5.92024 3.94841 6.64207 2.89087C7.3639 1.83334 8.38223 1.01307 9.56888 0.533295C10.7555 0.0535231 12.0575 -0.064314 13.3109 0.194614C14.5644 0.453542 15.7133 1.07766 16.613 1.98844C17.5128 2.89921 18.1232 4.05594 18.3675 5.31305C18.6117 6.57016 18.4789 7.87148 17.9858 9.05324C17.4926 10.235 16.6611 11.2444 15.596 11.9544C14.5308 12.6644 13.2796 13.0433 11.9997 13.0434C11.141 13.0447 10.2907 12.8752 9.49803 12.5448C8.7054 12.2143 7.98633 11.7294 7.38266 11.1184C6.779 10.5073 6.30277 9.78224 5.98167 8.98536C5.66058 8.18848 5.50101 7.33567 5.51228 6.47652ZM7.61387 6.29482C7.42272 8.61448 9.28325 10.7514 11.6684 10.9224C14.336 11.1137 16.2995 8.96301 16.4036 6.7443C16.5098 4.45865 14.731 2.31114 12.4372 2.12306C9.59333 1.89035 7.62449 4.13775 7.61387 6.29482Z"
                          fill="#7790AE"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_5397_8037">
                          <rect width="24" height="34" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                    Project Managers
                  </button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div
                  class="tab-pane fade show active"
                  id="seoAnalysts"
                  role="tabpanel"
                  aria-labelledby="seoAnalysts-tab"
                >
                  <div class="learn_more_tab_content">
                    <div class="learn_more_left">
                      <img src="/new-assets/assets/images/home/home-1.png" alt="img" />
                    </div>
                    <div class="learn_more_right">
                      <div class="learn_more_right_single">
                        <h6>Optimize every meta tag</h6>
                        <p>
                          Set custom rules for titles, descriptions, and keywords to maximize SEO impact.
                        </p>
                      </div>
                      <div class="learn_more_right_single">
                        <h6>Boost SERP visibility</h6>
                        <p>
                          Identify speed, mobile, and technical issues that hold your rankings back.
                        </p>
                      </div>
                      <div class="learn_more_right_single">
                        <h6>Show results with reports</h6>
                        <p>
                          Deliver clear, data-backed insights to prove ROI to stakeholders.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="websiteOwners"
                  role="tabpanel"
                  aria-labelledby="websiteOwners-tab"
                >
                  <div class="learn_more_tab_content">
                    <div class="learn_more_left">
                      <img src="/new-assets/assets/images/home/home-2.png" alt="img" />
                    </div>
                    <div class="learn_more_right">
                      <div class="learn_more_right_single">
                        <h6>Fix issues with ease</h6>
                        <p>
                          Spot problems without needing deep technical knowledge or coding skills.
                        </p>
                      </div>
                      <div class="learn_more_right_single">
                        <h6>Keep your site healthy</h6>
                        <p>
                          Ensure speed, security, and usability are always up to standard.
                        </p>
                      </div>
                      <div class="learn_more_right_single">
                        <h6>Protect your growth</h6>
                        <p>
                          Avoid missed opportunities by staying on top of your website’s performance.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="webDeveloper"
                  role="tabpanel"
                  aria-labelledby="webDeveloper-tab"
                >
                  <div class="learn_more_tab_content">
                    <div class="learn_more_left">
                      <img src="/new-assets/assets/images/home/home-3.png" alt="img" />
                    </div>
                    <div class="learn_more_right">
                      <div class="learn_more_right_single">
                        <h6>Catch errors early</h6>
                        <p>
                          Find broken HTML, code flaws, and best-practice gaps before launch.
                        </p>
                      </div>
                      <div class="learn_more_right_single">
                        <h6>Secure your website</h6>
                        <p>
                          Run checks for vulnerabilities and safeguard your users’ data.
                        </p>
                      </div>
                      <div class="learn_more_right_single">
                        <h6>Save time with automation</h6>
                        <p>
                         Automated audits help you focus on building, not fixing.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="projectManagers"
                  role="tabpanel"
                  aria-labelledby="projectManagers-tab"
                >
                  <div class="learn_more_tab_content">
                    <div class="learn_more_left">
                      <img src="/new-assets/assets/images/home/home-4.png" alt="img" />
                    </div>
                    <div class="learn_more_right">
                      <div class="learn_more_right_single">
                        <h6>Track site health at a glance</h6>
                        <p>
                          Monitor project progress with easy-to-read reports and test results.
                        </p>
                      </div>
                      <div class="learn_more_right_single">
                        <h6>Ensure delivery standards</h6>
                        <p>
                          Guarantee websites meet quality, security, and performance goals.
                        </p>
                      </div>
                      <div class="learn_more_right_single">
                        <h6>Align your team</h6>
                        <p>
                         Use pass/fail criteria to keep everyone on the same page.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Designed Area Start -->

          <!-- problems Area Start -->
          <div class="problems_area">
            <div class="home_section_title">
              <h2>Solve Website Issues Before They Hurt Your Growth</h2>
              <p>
                WebQA helps you uncover and fix the issues holding your website back — from slow-loading pages and broken meta tags to poor security and missed best practices. With clear insights and customizable audits, you can resolve problems early, boost performance, and keep your site search-engine and user-friendly.
              </p>
            </div>
            <div class="problems_content">
              <div class="problem_left_content">
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseOne"
                        aria-expanded="true"
                        aria-controls="collapseOne"
                      >
                        Website QA
                      </button>
                    </h2>
                    <div
                      id="collapseOne"
                      class="accordion-collapse collapse show"
                      aria-labelledby="headingOne"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <p>
                          Spot errors, broken HTML tags, and performance issues instantly.
                        </p>

                        <a href="https://webqa.co/features/webpage-audit" class="tryFreeBtn">Learn more</a>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                      <button
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo"
                        aria-expanded="false"
                        aria-controls="collapseTwo"
                      >
                        Website Tracker
                      </button>
                    </h2>
                    <div
                      id="collapseTwo"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingTwo"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <p>
                          Monitor your site’s health and track changes over time.
                        </p>

                        <a href="https://webqa.co/features/website-tracker" class="tryFreeBtn">Learn more</a>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseThree"
                        aria-expanded="false"
                        aria-controls="collapseThree"
                      >
                        Customised Audits
                      </button>
                    </h2>
                    <div
                      id="collapseThree"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingThree"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <p>
                          Set your own rules and audit your site your way.
                        </p>

                        <a href="https://webqa.co/features/settings" class="tryFreeBtn">Learn more</a>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFore">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseFore"
                        aria-expanded="false"
                        aria-controls="collapseFore"
                      >
                        Reports
                      </button>
                    </h2>
                    <div
                      id="collapseFore"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingFore"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <p>
                          Get clear pass/fail results with actionable insights.
                        </p>

                        <a href="https://webqa.co/features/reports" class="tryFreeBtn">Learn more</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="problem_right_content">
                <img src="/new-assets/assets/images/home/problem-img.svg" alt="img" />
              </div>
            </div>
          </div>
          <!-- problems Area End -->

          <!-- assurance Area Start -->
          <div class="assurance_area">
            <div class="assurance_content">
              <div class="assurance_left_content">
                <h2>
                  3 Steps to improve your website quality assurance process
                </h2>
                <div class="assurance_left_img">
                  <img src="/new-assets/assets/images/home/assurance.png" alt="img" />
                </div>
              </div>
              <div class="assurance_right_content">
                <p>
                  We give you a completely customisable Quality assurance tool
                  using which you can design a quality assurance process for
                  your website. The website quality assurance tool covers
                  Technical SEO checks,Pagespeed checks, Mobile responsiveness,
                  and HTML best practices. Apart from this, you can setup a
                  website tracker and setup alerts for your website, so that
                  when something is broken you are immediately informed via
                  email and SMS notifications.
                </p>
                <div class="assurance_right_bottom_content">
                  <img src="/new-assets/assets/images/home/hand.png" alt="img" />
                  <h3>Bring people on the same page</h3>

                  <p>
                    The biggest problem in a quality assurance process for a
                    website is bringing people on the same page. This includes
                    Web developers, project managers, Marketing Analysts,
                    Designers and other team members working collaboratively on
                    a single website.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- assurance Area End -->

          <!-- customisable Area Start -->
          <div class="customisable_area">
            <div class="home_section_title">
              <h2>Customize Your Website Audit, Your Way</h2>
              <p>
                WebQA goes beyond generic audits. With flexible settings and customizable criteria, you decide how each test is performed. Whether it’s setting the ideal length for meta titles or defining performance thresholds, WebQA adapts to your preferences — giving you accurate, tailored results that match your goals.
              </p>
            </div>
            <div class="customisable_tab_content">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="home-meta-tags-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#home-meta-tags"
                    type="button"
                    role="tab"
                    aria-controls="home-meta-tags"
                    aria-selected="true"
                  >
                    SEO
                  </button>
                </li>

                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="home-performance-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#home-performance"
                    type="button"
                    role="tab"
                    aria-controls="home-performance"
                    aria-selected="false"
                  >
                    Performance
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="home-coding-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#home-coding"
                    type="button"
                    role="tab"
                    aria-controls="home-coding"
                    aria-selected="false"
                  >
                    Best Practices
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="home-html-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#home-html"
                    type="button"
                    role="tab"
                    aria-controls="home-html"
                    aria-selected="false"
                  >
                    Website Security
                  </button>
                </li>
                
              </ul>
              <div class="tab-content" id="myTabContent">
                <div
                  class="tab-pane fade show active"
                  id="home-meta-tags"
                  role="tabpanel"
                  aria-labelledby="home-meta-tags-tab"
                >
                  <div class="home_images_tab_content">
                    <div class="home_images_tab_left">
                      <h3>SEO</h3>
                      <p>
                        Fine-tune your SEO by setting custom rules for titles, descriptions, and keywords. WebQA checks each page against your criteria to ensure your tags are optimized exactly how you want.
                      </p>
                      <div class="home_images_btn_area">
                        <a href="#" class="learn_more_btn">Learn More</a>
                        <a data-bs-toggle="modal" data-bs-target="#registerModal" href="#" class="sign_up_free">Sign Up</a>
                      </div>
                    </div>
                    <div
                      class="home_images_tab_right"
                      style="
                        background: url(/new-assets/assets/images/home/home-images-tab.png)
                          no-repeat scroll center center / cover;
                      "
                    ></div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="home-images"
                  role="tabpanel"
                  aria-labelledby="home-images-tab"
                >
                  <div class="home_images_tab_content">
                    <div class="home_images_tab_left">
                      <h3>Performance</h3>
                      <p>
                        Define speed benchmarks and loading thresholds that matter to your business. WebQA highlights bottlenecks and helps you keep your website fast and user-friendly.
                      </p>
                      <div class="home_images_btn_area">
                        <a href="#" class="learn_more_btn">Learn More</a>
                        <a data-bs-toggle="modal" data-bs-target="#registerModal" href="#" class="sign_up_free">Sign Up</a>
                      </div>
                    </div>
                    <div
                      class="home_images_tab_right"
                      style="
                        background: url(/new-assets/assets/images/home/home-images-tab.png)
                          no-repeat scroll center center / cover;
                      "
                    ></div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="home-performance"
                  role="tabpanel"
                  aria-labelledby="home-performance-tab"
                >
                  <div class="home_images_tab_content">
                    <div class="home_images_tab_left">
                      <h3>Performance</h3>
                      <p>
                        Define speed benchmarks and loading thresholds that matter to your business. WebQA highlights bottlenecks and helps you keep your website fast and user-friendly.
                      </p>
                      <div class="home_images_btn_area">
                        <a href="#" class="learn_more_btn">Learn More</a>
                        <a data-bs-toggle="modal" data-bs-target="#registerModal" href="#" class="sign_up_free">Sign Up</a>
                      </div>
                    </div>
                    <div
                      class="home_images_tab_right"
                      style="
                        background: url(/new-assets/assets/images/home/home-images-tab.png)
                          no-repeat scroll center center / cover;
                      "
                    ></div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="home-coding"
                  role="tabpanel"
                  aria-labelledby="home-coding-tab"
                >
                  <div class="home_images_tab_content">
                    <div class="home_images_tab_left">
                      <h3>Best practices</h3>
                      <p>
                        From clean HTML to mobile readiness, WebQA ensures your site follows modern web standards. Customize your checks to meet your own quality bar.
                      </p>
                      <div class="home_images_btn_area">
                        <a href="#" class="learn_more_btn">Learn More</a>
                        <a data-bs-toggle="modal" data-bs-target="#registerModal" href="#" class="sign_up_free">Sign Up</a>
                      </div>
                    </div>
                    <div
                      class="home_images_tab_right"
                      style="
                        background: url(/new-assets/assets/images/home/home-images-tab.png)
                          no-repeat scroll center center / cover;
                      "
                    ></div>
                  </div>
                </div>
                <div
                  class="tab-pane fade"
                  id="home-html"
                  role="tabpanel"
                  aria-labelledby="home-html-tab"
                >
                  <div class="home_images_tab_content">
                    <div class="home_images_tab_left">
                      <h3>Website security</h3>
                      <p>
                        Protect your website and users by auditing for vulnerabilities. WebQA lets you enforce specific security checks to reduce risks and keep your site safe.
                      </p>
                      <div class="home_images_btn_area">
                        <a href="#" class="learn_more_btn">Learn More</a>
                        <a data-bs-toggle="modal" data-bs-target="#registerModal" href="#" class="sign_up_free">Sign Up</a>
                      </div>
                    </div>
                    <div
                      class="home_images_tab_right"
                      style="
                        background: url(/new-assets/assets/images/home/home-images-tab.png)
                          no-repeat scroll center center / cover;
                      "
                    ></div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <!-- customisable Area End -->

          <!-- Trial Area Css -->
          <div class="trial-area">
            <div class="trial-content">
              <h2>Think your site is flawless? Test it with WebQA for hidden issues.</h2>
              <a data-bs-toggle="modal" data-bs-target="#registerModal" href="#" class="btn btn_primary rounded-pill"
                >Sign up</a
              >
            </div>
          </div>
        </div>
      </div>
    </main>


    @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
@endsection
@endsection