@extends('layouts.guest')
@section('title', 'Create a Free Account | Webqa')
@section('meta-description', 'This is register page meta description.')
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
                  <h1 class="modal-title">Free Sign up</h1>
                  <button type="button" class="btn-close login_close_btn"></button>
                </div>
                <div class="modal-body">
                  <p>Get started - no credit card required</p>
                  <div class="login_modal_form">
                  <form action="{{ route('register') }}" method="POST"   id="loginModal">
                        @csrf
                        <div>
                            <input type="text" class="{{ $errors->has('name') ? 'invalid' : ''  }}" name="name" id="name" value="{{ old('name') }}" placeholder="Your Name">
                        </div>
                        @if ($errors->has('name'))
                            <span class="feedback">{{ $errors->first('name') }}</span>
                        @endif

                        <div>
                            <input type="email" class="{{ $errors->has('email') ? 'invalid' : ''  }}" name="email" id="email" value="{{ old('email') }}" placeholder="Your Email">
                        </div>
                        @if ($errors->has('email'))
                            <span class="feedback">{!! $errors->first('email') !!}</span>
                        @endif

                        <div class="login_input_password">
                        <label for="password" class="login_input_label">
                        <span>
                            <img src="/new-assets/assets/images/eye.png" class="togglePassword" alt="icon">
                        </span>
                        </label>
                        <input type="password" class="passwordRegister{{ $errors->has('password') ? ' invalid' : ''  }}" name="password" id="password" placeholder="Password">
                        </div>
                        @if ($errors->has('password'))
                            <span class="feedback">{{ $errors->first('password') }}</span>
                        @endif

                        <div class="login_input_password">
                        <label for="password_confirmation" class="login_input_label">
                        <span>
                            <img src="/new-assets/assets/images/eye.png" class="toggleConfirmPassword" alt="icon">
                        </span>
                        </label>
                        <input type="password" class="passwordConfirmationRegister {{ $errors->has('password') ? 'invalid' : ''  }}" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                        </div>



                        <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Register">
                        <p class="text-center priv">By signing in, you agree to our <a href="{{ route('terms') }}" class="text-decoration-none">terms of use</a> & <a href="{{ route('privacy') }}" class="text-decoration-none">Privacy Policy.</a></p>


                        <div class="loginOr">
                            <span>Or</span>
                        </div>
                        <a href="{{ url('/login/google') }}" class="loginOr_btn">
                            <img src="/new-assets/assets/images/google.png" alt="icon">
                            <span>Login with Google</span>
                        </a>
                    </form>
                    <div class="signUp_modal_area">
                        <span>Already have an account?</span>
                      <a href="{{ route('login') }}">Login</a>
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
