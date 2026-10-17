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
          <form id="loginForm" data-auth-form="login">
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
            <a href="/forgot-password" class="login_forgetPass">Forgotten your password?</a>
            <div class="loginOr">
              <span>Or</span>
            </div>
            <a href="/login/google" class="loginOr_btn">
              <img src="/new-assets/assets/images/google.png" alt="icon">
              <span>Login with Google</span>
            </a>
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

<div class="modal fade logIn_modal_area" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog login_modal">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="registerModalLabel">Free Signup</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Get started - no credit card needed</p>
        <div class="login_modal_form">
          <form id="registerForm" data-auth-form="register">
            <div>
              <input id="nameRegister" data-name="name" type="text" placeholder="Name">
            </div>
            <div>
              <input id="emailRegister" data-name="email" type="text" placeholder="Email address">
            </div>
            <div class="login_input_password">
              <div>
                <label for="login_pass" class="login_input_label">
                  <span>
                    <img src="/new-assets/assets/images/eye.png" alt="icon" class="togglePassword">
                  </span>
                </label>
              </div>
              <input class="passwordRegister" id="passwordRegister" data-name="password" type="password" placeholder="Password">
            </div>
            <div class="login_input_password">
              <label for="login_pass" class="login_input_label">
                <span>
                  <img src="/new-assets/assets/images/eye.png" alt="icon" id="toggleConfirmPassword">
                </span>
              </label>
              <input id="passwordConfirmationRegister" data-name="password_confirmation" type="password" placeholder="Confirm Password">
            </div>
            <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Sign up">
            <a href="/login/google" class="loginOr_btn">
              <img src="/new-assets/assets/images/google.png" alt="icon">
              <span>Sign up with Google</span>
            </a>
          </form>
          <div class="signUp_modal_area">
            <span>Already have an account?</span>
            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" type="button">Login here</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal custom-modal" id="privacyPolicyModal" tabindex="-1" role="dialog" aria-labelledby="privacyPolicyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-privacy-policy" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-header-priv-pol">Privacy Policy</span>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="modal-body-priv-pol">Privacy Policy</h5>
        <div class="modalBodyContent modalBodyContent-priv-pol">
          <p>Welcome to the WebQA.com website (collectively, including all content and functionality available through the Setmore.com domain name, the Setmore blog, downloadable software, mobile applications (including tablet applications) and other services provided by us, referred to as the "Site"). By accessing or using the Site, you (Site visitor, or "User"), whether registered or not, accept these Terms of Use ("Agreement"), including as applicable Setmore Data Processing Addendum ("DPA") and our Privacy Policy, which are incorporated into the Agreement, and agree to be bound by these terms and all applicable laws of the State of Oregon and the United States of America.</p>
          <p>The Privacy Policy is available for review here: <a href="https://www.webqa.com/privacy">https://www.webqa.com/privacy</a>.</p>
          <p>The WebQA Data Processing Addendum is available here:</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="termsOfUseModal" tabindex="-1" role="dialog" aria-labelledby="termsOfUseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-privacy-policy" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <span class="modal-header-priv-pol">Terms of Use.</span>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="modal-body-priv-pol">Terms and Conditions</h5>
        <div class="modalBodyContent modalBodyContent-priv-pol">
          <p>Welcome to the WebQA.com website (collectively, including all content and functionality available through the Setmore.com domain name, the Setmore blog, downloadable software, mobile applications (including tablet applications) and other services provided by us, referred to as the "Site"). By accessing or using the Site, you (Site visitor, or "User"), whether registered or not, accept these Terms of Use ("Agreement"), including as applicable Setmore Data Processing Addendum ("DPA") and our Privacy Policy, which are incorporated into the Agreement, and agree to be bound by these terms and all applicable laws of the State of Oregon and the United States of America.</p>
          <p>The Privacy Policy is available for review here: <a href="https://www.webqa.com/privacy">https://www.webqa.com/privacy</a>.</p>
          <p>The WebQA Data Processing Addendum is available here:</p>
        </div>
      </div>
    </div>
  </div>
</div>
