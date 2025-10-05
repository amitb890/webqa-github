<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Webqa - Onboarding</title>
        <!-- bootstrap styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/bootstrap/css/bootstrap.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <!-- font awesome styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/fontawesome/css/all.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <!-- custom styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/assets/fonts/font-styles.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.res.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="icon" type="image/x-icon" href="{{ asset('new-assets/assets/images/favicon.ico') }}{{ \App\Http\Helpers::getCacheBuster() }}  ">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('new-assets/assets/images/apple-icon-180x180.png') }}{{ \App\Http\Helpers::getCacheBuster() }}  ">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('new-assets/assets/images/android-chrome-192x192.png') }}{{ \App\Http\Helpers::getCacheBuster() }}  ">
  </head>
  <body>
    <div id="app">
      <!-- header main starts -->
      <header id="headerMain" class="header_main onbording-header-padding">
        <nav class="navbar_main">
          <div class="container-fluid">
            <a href="{{ route('dashboard') }}" class="navbar-brand  register-logo">
              <img
                src="/new-assets/assets/images/webQA_logo.png"
                alt="WebQA"
                width="78"
                height="16"
                class="img-fluid"
              />
            </a>
          </div>
        </nav>
      </header>
      <!-- header main ends -->

      <!-- mobile menu starts -->
      <aside
        class="offcanvas offcanvas-start"
        tabindex="-1"
        id="offcanvasMobileMenu"
        aria-labelledby="offcanvasMobileMenuLabel"
      >
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
          ></button>
        </div>
        <div class="offcanvas-body">
          <div class="user_control">
            <div class="dropdown">
              <a
                class="dropdown-toggle p-2"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <span class="icon">
                  <svg
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M9 17C13.4183 17 17 13.4183 17 9C17 4.58172 13.4183 1 9 1C4.58172 1 1 4.58172 1 9C1 13.4183 4.58172 17 9 17Z"
                      stroke="#6E6E6E"
                      stroke-width="1.3"
                      stroke-miterlimit="10"
                    />
                    <path
                      d="M1.45572 6.33333H16.5445"
                      stroke="#6E6E6E"
                      stroke-width="1.3"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M1.45572 11.6667H16.5443"
                      stroke="#6E6E6E"
                      stroke-width="1.3"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M8.99999 16.7852C10.8409 16.7852 12.3333 13.2996 12.3333 8.99993C12.3333 4.70026 10.8409 1.21468 8.99999 1.21468C7.15904 1.21468 5.66666 4.70026 5.66666 8.99993C5.66666 13.2996 7.15904 16.7852 8.99999 16.7852Z"
                      stroke="#6E6E6E"
                      stroke-width="1.3"
                      stroke-miterlimit="10"
                    />
                  </svg>
                </span>
                Sohanlalso
              </a>

              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
              </ul>
            </div>
            <div class="dropdown">
              <a
                class="dropdown-toggle btn btn-outline-gray rounded-pill p-1 pe-2"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <span class="profile_icon">JD</span>
              </a>

              <ul class="dropdown-menu dropdown-menu-end user-dropdown">
                <div class="user-dropdown-list">
                  <li><a class="dropdown-item" href="#"><img src="/new-assets/assets/images/user-pro.png" alt="icon">My Profile
                    </a></li>
                  <li><a class="dropdown-item" href="#"><img src="/new-assets/assets/images/logout.png" alt="icon">Logout</a></li>
                </div>
              </ul>
            </div>
          </div>
        </div>
      </aside>
      <!-- mobile menu ends -->

      <!-- main sections starts -->
      <main class="main-sections">
        <div class="inner_content mw-100">
          <div class="container">
            <!-- Onboarding area start  -->
                   <div class="onboard-form-head">
                  <h4>Let's create your first project</h4>
                </div>
                <div class="form-slider">
                  <div class="form-slider-range">
                    <span class="progress-line"></span>
                    <span class="progress-dot one active"></span>
                    <span class="progress-dot two"></span>
                    <span class="progress-dot three"></span>
                    <span class="progress-dot four"></span>
                  </div>
                </div>
            <div class="row align-items-center onboard-main-items">
              <input type="hidden" id="sitemapInput" name="sitemapData">

              <div class="col-md-6">
                <div class="onboard-main-form">
                  <div class="card">
                    <div class="card-body">
                        <div id="formSetp1" class="form-setp active">
                          <div class="form-card-title">
                            <h3>Enter your website address</h3>
                          </div>
                          <div class="form-card-input">
                            <input
                            data-name="Website address"
                                id="homepage"
                              type="url"
                              class="form-control"
                              required
                              value=""
                            />
                          </div>
                          <div class="onboard-form-button">
                            <button
                              id="formTriggerBtn1"
                              class="btn btn_primary rounded-pill ms-auto"
                              type="button"
                            >
                              Next
                            </button>
                          </div>
                        </div>
                        <div id="formSetp2" class="form-setp">
                          <div class="form-card-title">
                            <h3>Enter XML sitemap</h3>
                          </div>
                          <div class="form-card-input">
                            <input
                            id="xmlSitemap"
                              type="url"
                              class="form-control"
                              required
                            />
                          </div>

                          <div class="onboard-form-button">
                            <button
                              id="BtnPrev1"
                              class="btn btn_transparent btn_prev rounded-pill onbordingButtonClass"
                              type="button"
                            >
                              <span>
                                <svg
                                  width="5"
                                  height="8"
                                  viewBox="0 0 5 8"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg"
                                >
                                  <path
                                    d="M4 7L1 4L4 1"
                                    stroke="#6E6E6E"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                  />
                                </svg>
                              </span>
                              Previous
                            </button>
                            <button
                              id="BtnSkip1"
                              class="btn btn_transparent btn_next rounded-pill ms-auto me-3 onbordingButtonClass"
                              type="button"
                            >
                              Skip
                            </button>
                            <button
                              id="formTriggerBtn2"
                              class="btn btn_primary rounded-pill onbordingButtonClass"
                              type="button"
                            >
                              Next
                            </button>
                          </div>
                        </div>
                        <div id="formSetp3" class="form-setp">
                          <div class="form-card-title">
                            <h3>Enter URLs list</h3>
                          </div>
                          <div class="form-card-input urls-list-container">
                            <textarea class="form-control" rows="10" id="urlsList">

                            </textarea>
                          </div>

                          <div class="onboard-form-button">
                            <button
                              id="BtnPrev2"
                              class="btn btn_transparent btn_prev rounded-pill  onbordingButtonClass"
                              type="button"
                            >
                              <span>
                                <svg
                                  width="5"
                                  height="8"
                                  viewBox="0 0 5 8"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg"
                                >
                                  <path
                                    d="M4 7L1 4L4 1"
                                    stroke="#6E6E6E"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                  />
                                </svg>
                              </span>
                              Previous
                            </button>
                            <button
                              id="BtnSkip2"
                              class="btn btn_transparent btn_next rounded-pill ms-auto me-3 onbordingButtonClass"
                              type="button"
                            >
                              Skip
                            </button>
                            <button
                              id="formTriggerBtn3"
                              class="btn btn_primary rounded-pill  onbordingButtonClass"
                              type="button"
                            >
                              Next
                            </button>
                          </div>
                        </div>
                        <div id="formSetp4" class="form-setp">
                          <div class="form-card-title">
                            <h3>Enter project name</h3>
                          </div>
                          <div class="form-card-input">
                            <input
                            data-name="Project name"
                            id="name"
                              type="text"
                              class="form-control onbording_project_name"
                              required
                            />
                          </div>

                          <div class="onboard-form-button">
                            <button
                              id="BtnPrev3"
                              class="btn btn_transparent btn_prev rounded-pill"
                              type="button"
                            >
                              <span>
                                <svg
                                  width="5"
                                  height="8"
                                  viewBox="0 0 5 8"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg"
                                >
                                  <path
                                    d="M4 7L1 4L4 1"
                                    stroke="#6E6E6E"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                  />
                                </svg>
                              </span>
                              Previous
                            </button>
                            <button
                              id="formTriggerBtn4"
                              class="btn btn_primary rounded-pill onbordingButtonClass"
                              type="button"
                            >
                              Next
                            </button>
                          </div>
                        </div>
                        <div id="formSetp5" class="form-setp">
                          <div class="form-card-input">
                            <div class="form-final-content">
                              <svg
                                width="68"
                                height="68"
                                viewBox="0 0 68 68"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <circle cx="34" cy="34" r="34" fill="#3D9F3B" />
                                <path
                                  d="M45 26L29.875 41L23 34.1818"
                                  stroke="white"
                                  stroke-width="5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                />
                              </svg>
                              <p>Project <span id="projectName"></span> has been created successfully</p>
                              <button id="finishOnboarding"
                                class="btn btn_primary rounded-pill"
                                type="submit"
                              >
                                Finish
                              </button>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="form-single-text">
                  <p class="xml-sitemap-message">
                   
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-image">
                  <img
                    src="/new-assets/assets/images/onboarding-img-1.png"
                    alt=""
                    class="img-fluid onboarding-img"
                    id="onboardingImg"
                  />
                </div>
              </div>
            </div>
            <!-- Onboarding area end  -->
          </div>
        </div>
      </main>
      <!-- main sections ends -->
    </div>

    <!-- jQuery -->
    <script src="{{ asset('new-assets/vendor/jQurey/jquery-3.6.1.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <!-- bootstrap scripts -->
    <script src="{{ asset('new-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <!-- custom scripts -->
    <script src="{{ asset('new-assets/js/functions.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
    <script src="{{ asset('new-assets/js/onboarding.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
  </body>
</html>
