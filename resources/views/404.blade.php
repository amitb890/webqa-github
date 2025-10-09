@extends('layouts.master')

@section('title', 'Page not found | Webqa')
@section('meta-description', 'The page that you are looking for does not exist.')
@section("content")

    <!-- Section 1 starts -->
     <section class="ep1 container">
            <div class="ep1-dleft">
                <div class="ep1-dleft-h">
                    <h1 style="font-weight: bolder;" class="ep1-dright-h1">Oops!</h1>
                    <h1 style="font-weight: bolder;" class="ep1-dright-h2">This page didn’t pass the test.</h1>
                </div>
                <p class="ep1-dright-p">Looks like this page does not exist. <br>Let’s get you back to optimizing your website with WebQA.</span>
                </p>
                <a class="ep1-dright-ref" href="{{ route('index') }}">
                    <button class="ep1-dright-button">Go to Homepage</button>
                </a>
            </div>
            <div class="ep1-dright">
                <img class="ep1-dleft-img" src="{{ asset('new-assets/assets/images/404-error-page/dude-gif.gif') }}" alt="">
            </div>
     </section>
    <!-- Section 1 ends -->

    @section('hideFooter', true)


     @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
@endsection
@endsection