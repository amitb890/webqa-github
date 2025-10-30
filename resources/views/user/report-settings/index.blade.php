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
                Coding Best Practices</a>
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
        <a href="{{ route('profile.index') }}">
          <span>My Profile</span>
          <svg
            width="18"
            height="18"
            viewBox="0 0 18 18"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M8.9922 0C7.24482 0.00331996 5.53612 0.514712 4.07422 1.47189C2.61232 2.42906 1.46032 3.7907 0.758536 5.39096C0.0567519 6.99122 -0.164526 8.76103 0.121655 10.4848C0.407836 12.2086 1.18912 13.812 2.37036 15.0996C3.21401 16.0141 4.23793 16.7439 5.37761 17.2431C6.51728 17.7423 7.748 18 8.9922 18C10.2364 18 11.4671 17.7423 12.6068 17.2431C13.7465 16.7439 14.7704 16.0141 15.614 15.0996C16.7953 13.812 17.5766 12.2086 17.8627 10.4848C18.1489 8.76103 17.9276 6.99122 17.2259 5.39096C16.5241 3.7907 15.3721 2.42906 13.9102 1.47189C12.4483 0.514712 10.7396 0.00331996 8.9922 0ZM8.9922 16.2168C7.12589 16.2139 5.33344 15.4873 3.99203 14.1897C4.39929 13.1982 5.0921 12.3502 5.98242 11.7534C6.87273 11.1567 7.92037 10.838 8.9922 10.838C10.064 10.838 11.1117 11.1567 12.002 11.7534C12.8923 12.3502 13.5851 13.1982 13.9924 14.1897C12.651 15.4873 10.8585 16.2139 8.9922 16.2168ZM7.19034 7.20745C7.19034 6.85107 7.29601 6.5027 7.49401 6.20639C7.692 5.91007 7.97341 5.67912 8.30266 5.54275C8.6319 5.40637 8.9942 5.37068 9.34373 5.44021C9.69325 5.50973 10.0143 5.68135 10.2663 5.93334C10.5183 6.18534 10.6899 6.5064 10.7594 6.85592C10.829 7.20545 10.7933 7.56774 10.6569 7.89699C10.5205 8.22624 10.2896 8.50765 9.99326 8.70564C9.69695 8.90363 9.34857 9.00931 8.9922 9.00931C8.51432 9.00931 8.05601 8.81947 7.71809 8.48156C7.38018 8.14364 7.19034 7.68533 7.19034 7.20745ZM15.2176 12.613C14.4127 11.2362 13.1738 10.1652 11.695 9.56789C12.1537 9.04774 12.4526 8.40628 12.5558 7.72047C12.659 7.03467 12.5621 6.33365 12.2768 5.70154C11.9914 5.06943 11.5297 4.53309 10.9471 4.15687C10.3645 3.78064 9.68573 3.58052 8.9922 3.58052C8.29867 3.58052 7.61987 3.78064 7.03726 4.15687C6.45465 4.53309 5.99297 5.06943 5.70763 5.70154C5.42229 6.33365 5.3254 7.03467 5.42859 7.72047C5.53179 8.40628 5.83068 9.04774 6.28941 9.56789C4.81062 10.1652 3.57172 11.2362 2.76677 12.613C2.12525 11.5203 1.7863 10.2764 1.78475 9.00931C1.78475 7.09778 2.5441 5.26453 3.89576 3.91288C5.24742 2.56122 7.08066 1.80186 8.9922 1.80186C10.9037 1.80186 12.737 2.56122 14.0886 3.91288C15.4403 5.26453 16.1996 7.09778 16.1996 9.00931C16.1981 10.2764 15.8591 11.5203 15.2176 12.613Z"
              fill="#222222"
            />
          </svg>
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

      <!-- Coding Best Practices Category -->
      <div
        class="tab-pane fade"
        id="v-pills-coding"
        role="tabpanel"
        aria-labelledby="v-pills-coding-tab"
        tabindex="0"
      >
        <div class="tab-content-area">
          <!-- Coding Best Practices Category Accordion -->
          <div class="accor-single-item">
            <div class="accor-head" 
                 style="background-color: rgba(255, 255, 255, 1);">
              <div class="accor-title-btn" 
                   style="display: flex; 
                          justify-content: space-between; 
                          align-items: center; 
                          width: 100%;">
                <span style="color: rgba(19, 85, 165, 1);">Coding Best Practices</span>
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
