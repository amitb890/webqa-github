@extends('layouts.guest')
@section('title', 'Set a new password | Webqa')
@section('meta-description', 'Choose a new password for your WebQA account.')
@section("content")

<main class="main-sections">
  <div class="inner_content">
    <div class="container-fluid">
      <div class="login_banner_area login-page">
        <div class="logIn_modal_area">
          <div class="login_modal">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title">Reset your password</h1>
                <button type="button" class="btn-close login_close_btn" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Enter a new password for your account. Use a strong password you don’t use elsewhere.</p>
                <div class="login_modal_form">
                  <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    @if ($errors->has('email'))
                      <div class="input-wrap mb-24">
                        <span class="feedback">{{ $errors->first('email') }}</span>
                      </div>
                    @endif

                    <div class="input-wrap mb-24">
                      <label for="password" class="form-label label-bold">New password</label>
                      <input type="password" class="form-control h-5 {{ $errors->has('password') ? 'invalid' : '' }}" name="password" id="password" autocomplete="new-password">
                      @if ($errors->has('password'))
                        <span class="feedback">{{ $errors->first('password') }}</span>
                      @endif
                    </div>

                    <div class="input-wrap mb-24">
                      <label for="password_confirmation" class="form-label label-bold">Confirm new password</label>
                      <input type="password" class="form-control h-5 {{ $errors->has('password_confirmation') ? 'invalid' : '' }}" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                      @if ($errors->has('password_confirmation'))
                        <span class="feedback">{{ $errors->first('password_confirmation') }}</span>
                      @endif
                    </div>

                    <div class="d-grid gap-2 mb-28">
                      <input class="btn btn_primary rounded-pill login_modal_btn" type="submit" value="Update password">
                    </div>
                    <p class="text-center priv"><a href="{{ route('login') }}" class="text-decoration-none">Back to login</a></p>
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

@endsection
