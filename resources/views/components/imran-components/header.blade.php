<header id="headerMain" class="header_main genarel_header_main">
        <nav class="navbar_main">
            <div class="container-fluid">
            <a href="./index.html" class="navbar-brand">
                <img
                src="{{ asset('raw-files-css-js/assets/images/webQA_logo.png') }}"
                alt="WebQA"
                width="78"
                height="16"
                class="img-fluid"
                />
            </a>

            <ul class="genarel_header_items">
                <li>
                <div class="dropdown">
                    <a
                    class="dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    >
                    <span>Features</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Stuff</a></li>
                        <li><a class="dropdown-item" href="#">Stuff</a></li>
                    </ul>
                </div>
                </li>
                <li>
                <div class="dropdown">
                    <a
                    class="dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    >
                    <span>Tools</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Stuff</a></li>
                        <li><a class="dropdown-item" href="#">Stuff</a></li>
                    </ul>
                </div>
                </li>
                <li><a href="aboutus.html">About Us</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
            <div class="login_area">
                <a type="button" class="header_login" data-bs-toggle="modal" data-bs-target="#LoginexampleModal">Login</a>
                <a href="#" class="btn btn_primary rounded-pill">Start Free Trial</a>
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
                            <span><img src="{{ asset('raw-files-css-js/assets/images/eye.png') }}" alt="icon"></span>
                            </label>
                            <input type="password" placeholder="Password" id="login_pass">
                        </div>
                        <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Login">
                        <a href="#" class="login_forgetPass">Forgotten your password?</a>
                        <div class="loginOr">
                            <span>Or</span>
                        </div>
                        <a href="#" class="loginOr_btn">
                            <img src="{{ asset('raw-files-css-js/assets/images/google.png') }}" alt="icon">
                            <span>Login with Google</span>
                        </a>
                        <a href="#" class="loginOr_btn">
                            <img src="{{ asset('raw-files-css-js/assets/images/facebook.png') }}" alt="icon">
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