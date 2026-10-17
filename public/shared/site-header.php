<?php
require_once __DIR__ . '/laravel-context.php';
webqa_boot_laravel_context();
?>
<header id="headerMain" class="header_main genarel_header_main">
  <nav class="navbar_main">
    <div class="container-fluid container-fluid-main container-fluid-tool-page header_home_page">
      <div class="container-fluid-inner">
        <a href="/" class="navbar-brand">
          <img
            src="/new-assets/assets/images/webQA_logo.png"
            alt="WebQA"
            width="78"
            height="16"
            class="img-fluid"
          />
        </a>

        <ul class="genarel_header_items">
          <li>
            <div class="dropdown dropdown2">
              <a
                class="dropdown-toggle"
                href="/features"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <span>Features</span>
                <i class="fa-solid fa-angle-down dropdown2-arrow"></i>
              </a>

              <ul class="dropdown-menu dropdown-menu-end">
                <div class="dropdown-menu2">
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/features/website-tracker">Website Tracker</a>
                    </div>
                  </li>
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/features/settings">Settings</a>
                    </div>
                  </li>
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/features/reports">Reports</a>
                    </div>
                  </li>
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/features/webpage-audit">Webpage Audit</a>
                    </div>
                  </li>
                  <div class="no-grid">
                    <button onclick="window.location='/features'">
                      Features
                    </button>
                  </div>
                </div>
              </ul>
            </div>
          </li>
          <li>
            <div class="dropdown dropdown2">
              <a
                class="dropdown-toggle"
                href="/tools"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <span>Tools</span>
                <i class="fa-solid fa-angle-down dropdown2-arrow"></i>
              </a>

              <ul class="dropdown-menu dropdown-menu-end">
                <div class="dropdown-menu2">
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/tools/meta-title">
                        <img src="/new-assets/assets/images/new-header-images/meta-tags.svg" alt="">
                      </a>
                      <a href="/tools/meta-title">Meta title</a>
                    </div>
                  </li>
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/tools/broken-links">
                        <img src="/new-assets/assets/images/new-header-images/security.svg" alt="">
                      </a>
                      <a href="/tools/broken-links">Security</a>
                    </div>
                  </li>
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/tools/images">
                        <img src="/new-assets/assets/images/new-header-images/images.svg" alt="">
                      </a>
                      <a href="/tools/images">Images</a>
                    </div>
                  </li>
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/tools/google-page-speed-insights">
                        <img src="/new-assets/assets/images/new-header-images/performances.svg" alt="">
                      </a>
                      <a href="/tools/google-page-speed-insights">Page Speed</a>
                    </div>
                  </li>
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/tools/http-status-code">
                        <img src="/new-assets/assets/images/new-header-images/on-page-elements.svg" alt="">
                      </a>
                      <a href="/tools/http-status-code">HTTP Status Code</a>
                    </div>
                  </li>
                  <li class="dropdown-menu2-item">
                    <div class="dm2i-div">
                      <a href="/tools/google-core-web-vitals">
                        <img src="/new-assets/assets/images/new-header-images/html-best-practices.svg" alt="">
                      </a>
                      <a href="/tools/google-core-web-vitals">Core web vitals</a>
                    </div>
                  </li>
                  <div class="no-grid">
                    <button onclick="window.location='/tools'">
                      All Tools
                    </button>
                  </div>
                </div>
              </ul>
            </div>
          </li>
        </ul>
      </div>
      <div class="login_area">
        <?php if (!webqa_authenticated()) { ?>
          <a type="button" class="header_login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
          <a type="button" class="btn btn_primary rounded-pill btn_primary2" data-bs-toggle="modal" data-bs-target="#registerModal">Free Signup</a>
        <?php } else { ?>
          <a href="/dashboard" class="btn btn_primary rounded-pill">Dashboard</a>
        <?php } ?>
      </div>

      <button id="header_menuBtn" class="header_menu_btn ms-3" type="button">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>
</header>
