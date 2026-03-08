<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <meta name="description" content="@yield('meta-description')">

        <!-- bootstrap styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/bootstrap/css/bootstrap.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/bootstrap-slider/bootstrap-slider.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}"/>

        <link rel="stylesheet" href="{{ asset('new-assets/vendor/magnific-popup/magnific-popup.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />

        <!-- font awesome styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/vendor/fontawesome/css/all.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <!-- custom styles -->
        <link rel="stylesheet" href="{{ asset('new-assets/assets/fonts/font-styles.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel="stylesheet" href="{{ asset('new-assets/css/main.res.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    
        <link rel="icon" type="image/x-icon" href="{{ asset('new-assets/assets/images/favicon.ico') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('new-assets/assets/images/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('new-assets/assets/images/android-chrome-192x192.png') }}">
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-NRZQHZTZ');</script>
        @yield("css")
    </head>
    <body class="authentication-page">
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NRZQHZTZ"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    <header id="headerMain" class="header_main genarel_header_main">
      <nav class="navbar_main">
        <div class="container-fluid">
          <a href="{{ route('index') }}" class="navbar-brand register-logo">
            <img
              src="/new-assets/assets/images/webQA_logo.png"
              alt="WebQA"
              width="78"
              height="16"
              class="img-fluid"
            />
          </a>
        </div>
      </nav>
    </header>
    <!-- header main ends -->

        @yield("content")


        <!-- jQuery -->
        <script src="{{ asset('new-assets/vendor/jQurey/jquery-3.6.1.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
        <!-- bootstrap scripts -->
        <script src="{{ asset('new-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
        <script src="{{ asset('new-assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
        <script src="{{ asset('new-assets/vendor/fontawesome/js/all.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

        <!-- custom scripts -->
        <script src="{{ asset('new-assets/js/functions.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
        <script src="{{ asset('new-assets/js/app.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
        <script src="{{ asset('new-assets/js/imran.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>


        @yield("js")
        <script>
          $(document).ready(function() {
            const $passwordInput = $('.passwordRegister');
            const $togglePassword = $('.togglePassword');
            $togglePassword.on('click', function() {
            if($passwordInput.attr('type') == 'password') {
              $passwordInput.attr('type', 'text');
            } else {
              $passwordInput.attr('type', 'password');
            }
              
            });

            const $passwordInputConfirm = $('.passwordConfirmationRegister');
            const $togglePasswordConfirm = $('.toggleConfirmPassword');
            $togglePasswordConfirm.on('click', function() {
              if($passwordInputConfirm.attr('type') == 'password') {
                $passwordInputConfirm.attr('type', 'text');
              } else {
                $passwordInputConfirm.attr('type', 'password');
              }
            });

            $('#loginModal').on('keypress', function(event) {
            if (event.which === 13) { // 13 is the Enter key
                event.preventDefault(); // Prevent the default action
                $(this).submit(); // Submit the form
            }
           });
          });
          </script>

    </body>
</html>
