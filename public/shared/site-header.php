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
          <?php include __DIR__ . '/nav-dropdowns.php'; ?>
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
