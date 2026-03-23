<!-- header main starts -->
    <header id="headerMain" class="header_main genarel_header_main">
      <nav class="navbar_main">
        <div class="container-fluid">
          <a href="https://webqa.co/" class="navbar-brand">
            <img src="https://webqa.co/new-assets/assets/images/webQA_logo.png" alt="WebQA" width="78" height="16" class="img-fluid"/>
          </a>

          
          <div class="login_area">
            <a type="button" class="header_login" data-bs-toggle="modal" data-bs-target="#LoginexampleModal">Login</a>
            <a href="#" class="btn btn_primary rounded-pill">Free Signup</a>
          </div>
          <!-- Modal -->
          <div class="modal fade logIn_modal_area" id="LoginexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"    aria-hidden="true">
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
                          <span><img src="assets/images/eye.png" alt="icon"></span>
                        </label>
                        <input type="password" placeholder="Password" id="login_pass">
                      </div>
                      <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Login">
                      <a href="#" class="login_forgetPass">Forgotten your password?</a>
                      <div class="loginOr">
                        <span>Or</span>
                      </div>
                      <a href="#" class="loginOr_btn">
                        <img src="assets/images/google.png" alt="icon">
                        <span>Login with Google</span>
                      </a>
                      <a href="#" class="loginOr_btn">
                        <img src="assets/images/facebook.png" alt="icon">
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
    
    
<section class="blog-title-section">
  <div class="blog-title">
    <h2 style="line-height:20px;">Webqa Blog</h2>
    <p style="text-align:center;margin-bottom:30px;font-style:italic;">
      Insights and best practices to help you build faster, cleaner, and world class websites.
    </p>
  </div>

  <div class="blog-menu">
    <nav style="display:flex;align-items:center;justify-content:center;gap:20px;flex-wrap:wrap;">
      <a href="https://webqa.co/articles/" class="blog-home">
        <img src="https://webqa.co/raw-files/assets/images/blog/home.svg" alt="home" style="width:20px;height:20px;">
      </a>

      <ul style="display:flex;list-style:none;gap:15px;margin:0;padding:0;">
        <li><a href="#">SEO</a></li>
        <li><a href="#">Performance</a></li>
        <li><a href="#">Best Practices</a></li>
        <li><a href="#">Security</a></li>
        <li><a href="#">Checklists</a></li>
      </ul>

      <!-- Search icon that becomes input -->
      <a href="#" id="searchIcon">
        <img src="https://webqa.co/raw-files/assets/images/blog/search.svg" alt="search" style="width:20px;height:20px;cursor:pointer;">
      </a>

      <button id="blog_menuBtn" class="blog_menu_btn" type="button" style="background:none;border:none;cursor:pointer;">
        <span></span><span></span><span></span>
      </button>
    </nav>
  </div>
</section>

<!-- Inline JS for the search field -->
<script>
  document.getElementById("searchIcon").addEventListener("click", function(event) {
    event.preventDefault();

    const searchLink = event.currentTarget;
    const form = document.createElement("form");
    form.action = "<?php echo esc_url(home_url('/')); ?>";
    form.method = "get";
    form.style.display = "inline-block";

    const input = document.createElement("input");
    input.type = "text";
    input.name = "s";
    input.placeholder = "Search articles...";
    input.style.cssText = `
      padding:5px 10px;
      border:1px solid #ccc;
      border-radius:4px;
      font-size:14px;
      outline:none;
      width:180px;
    `;

    form.appendChild(input);
    searchLink.replaceWith(form);
    input.focus();

    input.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        form.replaceWith(searchLink);
      }
    });
  });
</script>