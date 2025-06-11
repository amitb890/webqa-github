<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" href="https://webqa.co/support/wp-content/themes/support/assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://webqa.co/support/wp-content/themes/support/assets/css/font-styles.css" />
<link rel="stylesheet" href="https://webqa.co/support/wp-content/themes/support/assets/css/main.css" />
<link rel="stylesheet" href="https://webqa.co/support/wp-content/themes/support/assets/css/main.res.css" />
<?php wp_head(); ?>
</head>
  
  
  
<body class="body_padding">

 <header id="headerMain" class="header_main genarel_header_main">
      <nav class="navbar_main">
        <div class="container-fluid">
          <a href="./index.html" class="navbar-brand">
            <img src="https://webqa.co/support/wp-content/themes/support/assets/images/webQA_logo.png" alt="WebQA" width="78" height="16" class="img-fluid">
          </a>

          <ul class="genarel_header_items">
            <li><a href="#">Tools</a></li>
            <li><a href="#">Features</a></li>
            <li>
              <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <span>Pricing</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another Action</a></li>
                </ul>
              </div>
            </li>
          </ul>
          <div class="login_area">
            <a type="button" class="header_login" data-bs-toggle="modal" data-bs-target="#LoginexampleModal">Login</a>
            <a href="#" class="btn btn_primary rounded-pill">Start Free Trial</a>
          </div>
          <!-- Modal -->
          <div class="modal fade logIn_modal_area" id="LoginexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog login_modal">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Login</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Fill your existing account details</p>
                  <div class="login_modal_form">
                    <form action="#" method="POST">
                      <input type="email" placeholder="Email">
                      <div class="login_input_password">
                        <label for="login_pass" class="login_input_label">
                          <span><img src="https://webqa.co/support/wp-content/themes/support/assets/images/eye.png" alt="icon"></span>
                        </label>
                        <input type="password" placeholder="Password" id="login_pass">
                      </div>
                      <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Login">
                      <a href="#" class="login_forgetPass">Forgotten your password?</a>
                      <div class="loginOr">
                        <span>Or</span>
                      </div>
                      <a href="#" class="loginOr_btn">
                        <img src="https://webqa.co/support/wp-content/themes/support/assets/images/google.png" alt="icon">
                        <span>Login with Google</span>
                      </a>
                      <a href="#" class="loginOr_btn">
                        <img src="https://webqa.co/support/wp-content/themes/support/assets/images/facebook.png" alt="icon">
                        <span>Login with Facebook</span>
                      </a>
                    </form>
                    <div class="signUp_modal_area">
                      <span>Need an account?</span>
                      <a href="#">Sign up</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <button id="header_menuBtn" class="header_menu_btn ms-3" type="button">
            <span></span><span></span><span></span>
          </button>
        </div>
      </nav>
    </header>
<!-- header main ends -->

<!-- Banner Area Start -->
    <div class="container-fluid">
      <section class="support_banner_area">
        <div class="support_banner_content">
          <h1>Hi, how can we help?</h1>
          <form action="#" method="POST">
            <div class="suppor_search">
              <input type="search" placeholder="Search for articles ..." name="s">
            </div>
          </form>
        </div>
      </section>
    </div>


