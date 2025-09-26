<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 error page</title>

    @include('components.imran-components.meta-tags-css-links')
</head>
<body style="background-color: #fff;">

    <!-- header starts -->
        @include('components.imran-components.header')
        <!-- header ends -->

    <!-- Section 1 starts -->
     <section class="ep1 container">
            <div class="ep1-dleft">
                <div class="ep1-dleft-h">
                    <h1 style="font-weight: bolder;" class="ep1-dright-h1">Oops!</h1>
                    <h1 style="font-weight: bolder;" class="ep1-dright-h2">This link is broken</h1>
                </div>
                <p class="ep1-dright-p">Even the best sites can have crawl issues. Let’s get you back to optimized content and <span style="font-weight: bolder; font-size: 1.2rem;">boost your website.</span>
                </p>
                <a class="ep1-dright-ref" href="index.html">
                    <button class="ep1-dright-button">Go to Homepage</button>
                </a>
            </div>
            <div class="ep1-dright">
                <img class="ep1-dleft-img" src="{{ asset('raw-files-css-js/assets/images/404-error-page/c1568bfffff642df9edd3ef84394c09cd5def696 (1).gif') }}" alt="">
            </div>
     </section>
    <!-- Section 1 ends -->


    @include('components.imran-components.js-scripts')
</body>
</html>