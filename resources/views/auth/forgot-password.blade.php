@extends('layouts.guest')
@section('title', 'Reset Your Password | Webqa')
@section('meta-description', 'This is forgot-password page meta description.')
@section("content")
    
    <!-- main sections starts -->
    <main class="main-sections">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="login_banner_area login-page">
             <!-- Modal -->
          <div class="logIn_modal_area">
            <div class="login_modal">
              <div class="modal-content">
                @if (session('status'))
                <h5 class="card-title-custom">Email sent.</h5>
                <p class="let">A link has been sent to your email, head over to your email to reset your password.</p>
                @else
                <div class="modal-header">
                  <h1 class="modal-title">Forgot Your Password ?</h1>
                  <button type="button" class="btn-close login_close_btn"></button>
                </div>
                <div class="modal-body">
                  <p>Enter the email address associated with your account and we'll send you a link to reset your password.</p>
                  <div class="login_modal_form">
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="input-wrap mb-24">
                            <label for="email" class="form-label label-bold">Email Address</label>
                            <input type="email" class="form-control h-5 {{ $errors->has('email') ? 'invalid' : ''  }}" name="email" id="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="d-grid gap-2 mb-28">
                            <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Send reset link">
                        </div>
                        <p class="text-center priv"><a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a></p>
                    </form>
                    <div class="signUp_modal_area">
                      <span>Need an account?</span>
                      <a href="{{ route('register') }}">Sign up</a>
                    </div>
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </main>
    <!-- main sections ends -->


@endsection