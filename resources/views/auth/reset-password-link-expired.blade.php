@extends('layouts.guest')
@section('title', 'Link expired | Webqa')
@section('meta-description', 'This password reset link is no longer valid.')
@section("content")

<main class="main-sections">
  <div class="inner_content">
    <div class="container-fluid">
      <div class="login_banner_area login-page">
        <div class="logIn_modal_area">
          <div class="login_modal">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title">Link expired</h1>
                <button type="button" class="btn-close login_close_btn" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>This link has expired. Request a new reset link and try again.</p>
                <div class="login_modal_form">
                  <div class="d-grid gap-2 mb-28">
                    <a class="btn btn_primary rounded-pill login_modal_btn text-center text-decoration-none" href="{{ route('password.request') }}">Request new link</a>
                  </div>
                  <p class="text-center priv"><a href="{{ route('login') }}" class="text-decoration-none">Back to login</a></p>
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
