   <!-- Modal -->
   <div class="modal fade logIn_modal_area" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog login_modal">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Enter your existing account details to Login</p>
                  <div class="login_modal_form">
                    <form id="loginModal">
                        <div>
                            <input data-name="email" id="emailLogin" type="text" placeholder="Email">
                        </div>
                      <div class="login_input_password">
                        <label for="login_pass" class="login_input_label">
                          <span><img src="/new-assets/assets/images/eye.png" alt="icon" class="togglePassword"></span>
                        </label>
                        <input data-name="password" class="passwordRegister" id="passwordLogin" type="password" placeholder="Password">
                      </div>
                      <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Login">
                      <a href="{{ route('password.request') }}" class="login_forgetPass">Forgotten your password?</a>
                      <div class="loginOr">
                        <span>Or</span>
                      </div>
                      <a href="{{ url('/login/google') }}" class="loginOr_btn">
                        <img src="/new-assets/assets/images/google.png" alt="icon">
                        <span>Login with Google</span>
                      </a>
                      <!-- <a href="#" class="loginOr_btn">
                        <img src="/new-assets/assets/images/facebook.png" alt="icon">
                        <span>Login with Facebook</span>
                      </a> -->
                    </form>
                    <div class="signUp_modal_area">
                      <span>Need an account?</span>
                      <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" type="button">Sign up here</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>