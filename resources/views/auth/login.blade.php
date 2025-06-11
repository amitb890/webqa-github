@extends('layouts.guest')
@section('title', 'Login | Webqa')
@section('meta-description', 'This is login page meta description.')
@section("content")
    
    <!-- main sections starts -->
    <main class="main-sections">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="login_banner_area login-page">
                    @if(session('status'))
                    <span class="feedback text-success mb-2">Your password has been changed successfully, please login with your new password.</span>
                    @endif
             <!-- Modal -->
          <div class="logIn_modal_area">
            <div class="login_modal">
              <div class="modal-content">
                <div class="modal-header">
                  
                  @if (session('session_expired')) 
                  <h1 class="modal-title">Welcome Back</h1>
                  @else
                  <h1 class="modal-title">Login</h1>
                  @endif
                  <button type="button" class="btn-close login_close_btn"></button>
                </div>
                <div class="modal-body">
                  @if (session('session_expired')) 
                  <p>Your session has expired, please sign back in</p>
                  @else
                  <p>Fill your existing account details</p>
                  @endif
                  <div class="login_modal_form">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <input type="email" class="{{ $errors->has('email') ? 'invalid' : ''  }}" name="email" id="email" aria-describedby="emailHelp" value="{{ old('email') }}" autofocus>
                        @if ($errors->has('email'))
                            <span class="feedback">{{ $errors->first('email') }}</span>
                        @endif
                        
                      <div class="login_input_password">
                        <label for="login_pass" class="login_input_label">
                          <span><img src="/new-assets/assets/images/eye.png" class="togglePassword" alt="icon"></span>
                        </label>
                        <input type="password" class="passwordRegister {{ $errors->has('email') ? 'invalid' : ''  }}" name="password" id="password">
                      </div>

                        @if ($errors->has('password'))
                            <span class="feedback">{{ $errors->first('password') }}</span>
                        @endif


                      <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Login">

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="login_forgetPass">{{ __('Forgot your password?') }}</a>
                        @endif

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
                      <a href="{{ route('register') }}">Sign up</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </main>
    <!-- main sections ends -->


@endsection