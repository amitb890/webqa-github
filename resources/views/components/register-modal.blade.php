   <!-- Modal -->
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
            <form id="loginModal">

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
                <input id="passwordConfirmationRegister"  type="password"  placeholder="Confirm Password">
              </div>



              <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Sign up">
              <a href="{{ url('/login/google') }}" class="loginOr_btn">
                <img src="/new-assets/assets/images/google.png" alt="icon">
                <span>Sign up with Google</span>
              </a>
              <!-- <a href="#" class="loginOr_btn"><img src="/new-assets/assets/images/facebook.png" alt="icon"><span>Login with Facebook</span></a> -->
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