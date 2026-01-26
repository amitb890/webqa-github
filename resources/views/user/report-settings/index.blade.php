@extends('layouts.app')
@section('title', 'Webqa - Report Settings')
@section("content")

<!-- Setting area start  -->
<div class="setting-area">


  <!-- setting menu area start -->
  <div class="setting-menu-area d-none d-sm-block">
    <div class="menu-title">
      <h3>Settings</h3>
    </div>
    <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-heading1">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-collapse1"
            aria-expanded="true"
            aria-controls="flush-collapse1"
          >
            Website QA
          </button>
        </h2>
        <div
          id="flush-collapse1"
          class="accordion-collapse collapse show"
          aria-labelledby="flush-heading1"
          data-bs-parent="#accordionFlushExample"
        >
          <div class="accordion-body">
            <div
              class="nav flex-column nav-pills me-3"
              role="tablist"
              aria-orientation="vertical"
            >
              {{-- <button
                class="nav-link active v-pills-meta-tab"
                id="v-pills-meta-tab"
                data-bs-toggle="pill"
                data-bs-target="#v-pills-meta"
                type="button"
                role="tab"
                aria-controls="v-pills-meta"
                aria-selected="true"
              >
              
                SEO
              </button> --}}
               <button
                class="nav-link"
              ><a class="settignSidebarLink" href="" style="color: inherit; text-decoration: none;">
                SEO</a>
              </button>
              <button
                class="nav-link"
              ><a class="settignSidebarLink" href="" style="color: inherit; text-decoration: none;">
                Performance</a>
              </button>
              <button
                class="nav-link"
              ><a class="settignSidebarLink" href="" style="color: inherit; text-decoration: none;">
                Best Practices</a>
              </button>
              <button
                class="nav-link"
              ><a class="settignSidebarLink" href="" style="color: inherit; text-decoration: none;">
                Security</a>
              </button>
              <button
                class="nav-link"
              ><a href="{{ route('report-settings.edit') }}" style="color: inherit; text-decoration: none;">
                Reports</a>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="my-profile">
        <a href="https://webqa.co/test-archive-web-app">
          <span style="margin:0 auto;">Previous Tests</span>
        </a>
      </div>
    </div>
  </div>
  <!-- setting menu area end -->

  <!-- setting content and tab content area start -->
  <div class="setting-content-area">
    <!-- setting alert start -->
    <div class="setting-alert-area">
      
      <div class="setting-alert-btn ms-auto">
        <button class="btn btn_primary rounded-pill" type="submit" id="saveReportSettings"> 
          Save Settings
        </button>
      </div>
    </div>
    <!-- setting alert end -->

    <div class="tab-content" id="v-pills-tabContent">
      <!-- SEO Category -->
      <div
        class="tab-pane fade show active"
        id="v-pills-meta"
        role="tabpanel"
        aria-labelledby="v-pills-meta-tab"
        tabindex="0"
      >
        <div class="tab-content-area">
          <!-- SEO Category Accordion -->
          <div class="accor-single-item">
            <div class="accor-head" 
                 style="background-color: rgba(255, 255, 255, 1);">
              <div class="accor-title-btn" 
                   style="display: flex; 
                          justify-content: space-between; 
                          align-items: center; 
                          width: 100%;">
                <span style="color: rgba(19, 85, 165, 1);">SEO</span>
                <button>
                  <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" 
                       alt="btn" />
                </button>
              </div>
            </div>
            <div class="accor-body show" 
                 style="background-color: rgba(255, 255, 255, 1);">
              <div class="meta-content" 
                   style="background-color: rgba(255, 255, 255, 1); 
                          padding: 0;">
                <div class="accor-content" 
                     style="padding: 0;">
                  <!-- Meta Title Report -->
                  <div class="report-item" 
                       style="border-bottom: 1px solid #e0e0e0; 
                              padding-bottom: 15px; 
                              margin: 0;">
                    <div class="report-label">
                      <span>Meta Title</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/meta-title" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchMetaTitle"
                              {{ !$settings || $settings->meta_title ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Meta Description Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Meta Description</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/description" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchMetaDesc"
                              {{ !$settings || $settings->meta_desc ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Robots Meta Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Robots Meta Tag</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/robots-meta" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchRobotsMeta"
                              {{ !$settings || $settings->robots_meta ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Canonical URL Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Canonical URL</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/canonical" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCanonicalUrl"
                              {{ !$settings || $settings->canonical_url ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Images Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Images</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/images" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchImages"
                              {{ !$settings || $settings->images ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- URL Slug Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>URL Slug</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/url-slug" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchUrlSlug"
                              {{ !$settings || $settings->url_slug ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Robots.txt Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Robots.txt</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/robots-meta" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchRobotTextTest"
                              {{ !$settings || $settings->robot_text_test ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Headings Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Headings</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/headings" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchH1HeadingTag"
                              {{ !$settings || $settings->h1_heading_tag ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- XML Sitemap Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>XML Sitemap</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/xml-sitemap" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchXmlSitemap"
                              {{ !$settings || $settings->xml_sitemap ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Open Graph Title Tag Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Open Graph Title Tag</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/og-tags" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchOpenGraphTags"
                              {{ !$settings || $settings->open_graph_tags ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Twitter Tags Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Twitter Tags</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/twitter-tags" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchTwitterTags"
                              {{ !$settings || $settings->twitter_tags ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Favicon Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Favicon</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/favicon" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchFavicon"
                              {{ !$settings || $settings->favicon ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Meta Viewport Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Meta Viewport</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/meta-viewport" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchMetaViewport"
                              {{ !$settings || $settings->meta_viewport ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Doctype Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Doctype</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/doctype" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchDoctype"
                              {{ !$settings || $settings->doctype ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- HTTP Status Code Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>HTTP Status Code</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/http-status-code" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchHttpStatusCode"
                              {{ !$settings || $settings->http_status_code ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Performance Category -->
      <div
        class="tab-pane fade"
        id="v-pills-performance"
        role="tabpanel"
        aria-labelledby="v-pills-performance-tab"
        tabindex="0"
      >
        <div class="tab-content-area">
          <!-- Performance Category Accordion -->
          <div class="accor-single-item">
            <div class="accor-head" 
                 style="background-color: rgba(255, 255, 255, 1);">
              <div class="accor-title-btn" 
                   style="display: flex; 
                          justify-content: space-between; 
                          align-items: center; 
                          width: 100%;">
                <span style="color: rgba(19, 85, 165, 1);">Performance</span>
                <button>
                  <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" 
                       alt="btn" />
                </button>
              </div>
            </div>
            <div class="accor-body show" 
                 style="background-color: rgba(255, 255, 255, 1);">
              <div class="meta-content" 
                   style="background-color: rgba(255, 255, 255, 1); 
                          padding: 0;">
                <div class="accor-content" 
                     style="padding: 0;">
                  <!-- Overall Score Report -->
                  <div class="report-item" 
                       style="border-bottom: 1px solid #e0e0e0; 
                              padding-bottom: 15px; 
                              margin: 0;">
                    <div class="report-label">
                      <span>Overall Score</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/google-page-speed-insights" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchGoogleOverall"
                              {{ !$settings || $settings->google_overall ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Lighthouse Score Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Lighthouse Score</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/google-page-speed-lighthouse" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchGoogleLighthouse"
                              {{ !$settings || $settings->google_lighthouse ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Core Web Vitals Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Core Web Vitals</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/google-page-speed-core-web-vitals" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCoreWebVitals"
                              {{ !$settings || $settings->core_web_vitals ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Mobile Friendliness Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Mobile Friendliness</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/mobile-friendly" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchMobileFriendly"
                              {{ !$settings || $settings->mobile_friendly ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Best Practices Category -->
      <div
        class="tab-pane fade"
        id="v-pills-coding"
        role="tabpanel"
        aria-labelledby="v-pills-coding-tab"
        tabindex="0"
      >
        <div class="tab-content-area">
          <!-- Best Practices Category Accordion -->
          <div class="accor-single-item">
            <div class="accor-head" 
                 style="background-color: rgba(255, 255, 255, 1);">
              <div class="accor-title-btn" 
                   style="display: flex; 
                          justify-content: space-between; 
                          align-items: center; 
                          width: 100%;">
                <span style="color: rgba(19, 85, 165, 1);">Best Practices</span>
                <button>
                  <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" 
                       alt="btn" />
                </button>
              </div>
            </div>
            <div class="accor-body show" 
                 style="background-color: rgba(255, 255, 255, 1);">
              <div class="meta-content" 
                   style="background-color: rgba(255, 255, 255, 1); 
                          padding: 0;">
                <div class="accor-content" 
                     style="padding: 0;">
                  <!-- HTML Compression Report -->
                  <div class="report-item" 
                       style="border-bottom: 1px solid #e0e0e0; 
                              padding-bottom: 15px; 
                              margin: 0;">
                    <div class="report-label">
                      <span>HTML Compression</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/html-compression" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchHtmlCompression"
                              {{ !$settings || $settings->html_compression ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- CSS Compression Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>CSS Compression</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/css-compression" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCssCompression"
                              {{ !$settings || $settings->css_compression ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- JS Compression Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>JavaScript Compression</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/js-compression" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchJsCompression"
                              {{ !$settings || $settings->js_compression ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- GZIP Compression Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>GZIP Compression</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/gzip-compression" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchGzipCompression"
                              {{ !$settings || $settings->gzip_compression ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- CSS Caching Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>CSS Caching</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/css-caching" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCssCaching"
                              {{ !$settings || $settings->css_caching_enable ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- JS Caching Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>JS Caching</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/js-caching" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchJsCaching"
                              {{ !$settings || $settings->js_caching_enable ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Page Size Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Page Size</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/page-size" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchPageSize"
                              {{ !$settings || $settings->page_size ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Nested Tables Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Nested Tables</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/nested-tables" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchNestedTables"
                              {{ !$settings || $settings->nested_tables ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Frameset Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Frameset</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/frameset" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchFrameset"
                              {{ !$settings || $settings->frameset ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Broken Links Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Broken Links</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/broken-links" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchBrokenLinks"
                              {{ !$settings || $settings->broken_links ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Security Category -->
      <div
        class="tab-pane fade"
        id="v-pills-security"
        role="tabpanel"
        aria-labelledby="v-pills-security-tab"
        tabindex="0"
      >
        <div class="tab-content-area">
          <!-- Security Category Accordion -->
          <div class="accor-single-item">
            <div class="accor-head" 
                 style="background-color: rgba(255, 255, 255, 1);">
              <div class="accor-title-btn" 
                   style="display: flex; 
                          justify-content: space-between; 
                          align-items: center; 
                          width: 100%;">
                <span style="color: rgba(19, 85, 165, 1);">Security</span>
                <button>
                  <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" 
                       alt="btn" />
                </button>
              </div>
            </div>
            <div class="accor-body show" 
                 style="background-color: rgba(255, 255, 255, 1);">
              <div class="meta-content" 
                   style="background-color: rgba(255, 255, 255, 1); 
                          padding: 0;">
                <div class="accor-content" 
                     style="padding: 0;">
                  <!-- Safe Browsing Report -->
                  <div class="report-item" 
                       style="border-bottom: 1px solid #e0e0e0; 
                              padding-bottom: 15px; 
                              margin: 0;">
                    <div class="report-label">
                      <span>Safe Browsing</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/safe-browsing" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchSafeBrowsing"
                              {{ !$settings || $settings->is_safe_browsing ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Unsafe Cross Origin Links Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Unsafe Cross Origin Links</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/unsafe-cross-origin-links" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCrossOriginLinks"
                              {{ !$settings || $settings->cross_origin_links ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Protocol Relative Resource Links Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Protocol Relative Resource Links</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/protocol-relative-resource" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchProtocolRelativeResource"
                              {{ !$settings || $settings->protocol_relative_resource ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Content Security Policy Header Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Content Security Policy Header</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/content-security-policy-header" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchContentSecurityPolicy"
                              {{ !$settings || $settings->content_security_policy_header ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- X Frame Options Header Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>X Frame Options Header</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/x-frame-options-header" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchXFrameOptions"
                              {{ !$settings || $settings->x_frame_options_header ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- HSTS Header Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>HSTS Header</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/hsts-header" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchHstsHeader"
                              {{ !$settings || $settings->hsts_header ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Bad Content Type Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Bad Content Type</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/bad-content-type" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchBadContentType"
                              {{ !$settings || $settings->bad_content_type ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- SSL Certificate Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>SSL Certificate</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/ssl-certificate" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchSslCertificate"
                              {{ !$settings || $settings->ssl_certificate_enable ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Directory Browsing Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Directory Browsing</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/directory-browsing" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchFolderBrowsing"
                              {{ !$settings || $settings->folder_browsing_enable ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- setting content and tab content area end -->
</div>
<!-- Setting area end -->

<style>
.report-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #e9ecef;
    gap: 20px;
}

.report-item:last-child {
    border-bottom: none;
}

.report-label {
    flex: 1;
    font-size: 16px;
    color: #333;
    font-weight: 500;
}

.report-actions {
    margin-right: 80px;
}

.open-link {
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.open-link:hover {
    color: #0056b3;
    text-decoration: none;
}

.open-link i {
    font-size: 12px;
}

.report-switch {
    flex-shrink: 0;
}

.accor-content {
    padding: 20px 0;
}

/* Make all tab-panes visible by default */
.tab-content .tab-pane {
    display: block !important;
    opacity: 1 !important;
}

/* Ensure proper spacing between categories */
.tab-pane {
    margin-bottom: 30px;
}
</style>
@endsection
@section("js")
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Save Report Settings functionality
    document.getElementById('saveReportSettings').addEventListener('click', function() {
        // Collect all form data
        const formData = new FormData();
        
        // Add CSRF token
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('_method', 'PUT');
        
        // Collect all checkbox values with proper field name mapping
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            // Map checkbox ID to database field name
            let fieldName = checkbox.id.replace('switch', '');
            
            // Convert camelCase to snake_case for database fields
            fieldName = fieldName.replace(/([A-Z])/g, '_$1').toLowerCase();
            if (fieldName.startsWith('_')) {
                fieldName = fieldName.substring(1);
            }
            
            // Special cases for field name mapping
            const fieldMapping = {
                'meta_title': 'meta_title',
                'meta_desc': 'meta_desc',
                'robots_meta': 'robots_meta',
                'canonical_url': 'canonical_url',
                'images': 'images',
                'url_slug': 'url_slug',
                'robot_text_test': 'robot_text_test',
                'h1_heading_tag': 'h1_heading_tag',
                'xml_sitemap': 'xml_sitemap',
                'open_graph_tags': 'open_graph_tags',
                'twitter_tags': 'twitter_tags',
                'favicon': 'favicon',
                'meta_viewport': 'meta_viewport',
                'doctype': 'doctype',
                'http_status_code': 'http_status_code',
                'google_overall': 'google_overall',
                'google_lighthouse': 'google_lighthouse',
                'core_web_vitals': 'core_web_vitals',
                'mobile_friendly': 'mobile_friendly',
                'html_compression': 'html_compression',
                'css_compression': 'css_compression',
                'js_compression': 'js_compression',
                'gzip_compression': 'gzip_compression',
                'css_caching': 'css_caching_enable',
                'js_caching': 'js_caching_enable',
                'page_size': 'page_size',
                'nested_tables': 'nested_tables',
                'frameset': 'frameset',
                'broken_links': 'broken_links',
                'safe_browsing': 'is_safe_browsing',
                'cross_origin_links': 'cross_origin_links',
                'protocol_relative_resource': 'protocol_relative_resource',
                'content_security_policy': 'content_security_policy_header',
                'x_frame_options': 'x_frame_options_header',
                'hsts_header': 'hsts_header',
                'bad_content_type': 'bad_content_type',
                'ssl_certificate': 'ssl_certificate_enable',
                'folder_browsing': 'folder_browsing_enable'
            };
            
            const dbFieldName = fieldMapping[fieldName] || fieldName;
            formData.append(dbFieldName, checkbox.checked ? 1 : 0);
        });
        
        // Send AJAX request
        fetch('{{ route("report-settings.update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            let alertData;
            if (data.status === 1) {
                alertData = {
                    status: 1,
                    msg: 'Report settings saved successfully!'
                };
                
                // Update window.reportSettings with new values
                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    let fieldName = checkbox.id.replace('switch', '');
                    fieldName = fieldName.replace(/([A-Z])/g, '_$1').toLowerCase();
                    if (fieldName.startsWith('_')) {
                        fieldName = fieldName.substring(1);
                    }
                    
                    const fieldMapping = {
                        'meta_title': 'meta_title',
                        'meta_desc': 'meta_desc',
                        'robots_meta': 'robots_meta',
                        'canonical_url': 'canonical_url',
                        'images': 'images',
                        'url_slug': 'url_slug',
                        'robot_text_test': 'robot_text_test',
                        'h1_heading_tag': 'h1_heading_tag',
                        'xml_sitemap': 'xml_sitemap',
                        'open_graph_tags': 'open_graph_tags',
                        'twitter_tags': 'twitter_tags',
                        'favicon': 'favicon',
                        'meta_viewport': 'meta_viewport',
                        'doctype': 'doctype',
                        'http_status_code': 'http_status_code',
                        'google_overall': 'google_overall',
                        'google_lighthouse': 'google_lighthouse',
                        'core_web_vitals': 'core_web_vitals',
                        'mobile_friendly': 'mobile_friendly',
                        'html_compression': 'html_compression',
                        'css_compression': 'css_compression',
                        'js_compression': 'js_compression',
                        'gzip_compression': 'gzip_compression',
                        'css_caching': 'css_caching_enable',
                        'js_caching': 'js_caching_enable',
                        'page_size': 'page_size',
                        'nested_tables': 'nested_tables',
                        'frameset': 'frameset',
                        'broken_links': 'broken_links',
                        'safe_browsing': 'is_safe_browsing',
                        'cross_origin_links': 'cross_origin_links',
                        'protocol_relative_resource': 'protocol_relative_resource',
                        'content_security_policy': 'content_security_policy_header',
                        'x_frame_options': 'x_frame_options_header',
                        'hsts_header': 'hsts_header',
                        'bad_content_type': 'bad_content_type',
                        'ssl_certificate': 'ssl_certificate_enable',
                        'folder_browsing': 'folder_browsing_enable'
                    };
                    
                    const dbFieldName = fieldMapping[fieldName] || fieldName;
                    if (window.reportSettings && dbFieldName) {
                        window.reportSettings[dbFieldName] = checkbox.checked ? 1 : 0;
                    }
                });
                
                // Refresh sidebar filtering
                if (typeof window.filterSidebarReports === 'function') {
                    window.filterSidebarReports();
                }
            } else {
                alertData = {
                    status: 0,
                    msg: 'Error saving report settings: ' + data.msg
                };
            }
            displayAlert(".setting-alert-area", alertData);
            scrollToTop();
        })
        .catch(error => {
            console.error('Error:', error);
            const alertData = {
                status: 0,
                msg: 'Error saving report settings'
            };
            displayAlert(".setting-alert-area", alertData);
            scrollToTop();
        });
    });
});



$(document).ready(function () {
  // Use event delegation to avoid conflicts with Bootstrap
  // $(document).off('click', '[id^="v-pills-"][id$="-tab"]').on('click', '[id^="v-pills-"][id$="-tab"]', function (e) {
    
    $('[id^="v-pills-"][id$="-tab"]').on('click', function () {

    // First close all accordions
    $('.accor-body').removeClass('show').hide();
    $('.accor-single-item').removeClass('active');

    let target = $(this).data('bs-target'); // e.g. "#v-pills-meta", "#v-pills-performance", etc.

    // open accordion inside the corresponding tab
    $(target).find('.accor-body').addClass('show').show();
    $(target).find('.accor-single-item').addClass('active');
  });
});

</script>

@endsection
