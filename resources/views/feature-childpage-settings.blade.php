@extends('layouts.master', ['headerPadding' => 'fcps'])

@section('title', 'Define Project-Wide Audit Rules in Settings | Webqa')
@section('meta-description', 'Set acceptance criteria for each test—title length, casing, “must not equal H1,” and more. Apply rules across audits and tools for consistent Pass/Fail results.')
@section('canonical', 'https://webqa.co/features/settings')
@section('og-title', 'Settings: Define Project-Wide Audit Rules | Webqa')
@section('og-description', 'Configure the criteria that power your checks. Choose only the parameters you need and ensure consistent, standards-based results across audits and bulk tools.')
@section('og-url', 'https://webqa.co/features/settings')
@section('og-image', 'https://webqa.co/new-assets/assets/images/og/features-settings.png')
@section('og-image-alt', 'Settings')

@section("content")

    <!-- Section 1 Starts -->
     <section class="fcs1">
        <div class="fcs1-d1">
            <h1>Customized Auditing Settings for Maximum Impact</h1>
            <p>
                We analyze every element — design, performance, SEO, and user experience to uncover growth opportunities.
            </p>
            <div class="fcs1-d1-button">
                <button id="fcs1-d1-btn" class="fr1-d1-button" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Sign Up Free
                </button>
            </div>
        </div>
        <div class="fcs1-d2">
            <img src="{{ asset('new-assets/assets/images/feature-childpage-settings/Group-1048.svg') }}" alt="">
        </div>
     </section>
    <!-- Section 1 Ends -->

    <!-- Section 2 Starts -->
     <section class="fcs2">
        <h1>
            Customized Auditing Settings
        </h1>
        <p>
            Our Customized Auditing Settings let you define exactly what matters for your website’s success. Choose specific metrics, focus areas, and performance goals tailored to your business. From SEO to speed optimization, our flexible settings ensure every audit delivers precise insights, empowering you to take targeted, impactful action.
        </p>
     </section>
    <!-- Section 2 Ends -->

    <!-- Section 3 Starts -->
     <section class="fcs3">
        <div class="fcs3-d1">
            <h1>Customized SEO Controls</h1>
            <div class="fcs3-d1-imgdiv">
                <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-settings/Group-1050.svg') }}" alt="">
            </div>
        </div>
        <div class="fcs3-d2">
            <div class="fcs3-d2-inner">
                <div class="fcs3-d2-card">
                    <h6>Meta Headers</h6>
                    <p>Require at least one H1 and set the maximum number of H1 through H6 tags a page may use.</p>
                </div>
                <div class="fcs3-d2-card card-active">
                    <h6>Meta Title</h6>
                    <p>Set minimum and maximum title length, sentence or camel casing, and whether the title may match the H1.</p>
                </div>
                <div class="fcs3-d2-card">
                    <h6>Meta Description</h6>
                    <p>Set the shortest and longest meta description a page can have so every snippet follows the same length rule.</p>
                </div>
                <div class="fcs3-d2-card">
                    <h6>Images</h6>
                    <p>Require alt text, cap file size and filename length, and allow only hyphen-separated lowercase names.</p>
                </div>
                <div class="fcs3-d2-card">
                    <h6>URL Slug</h6>
                    <p>Require lowercase URLs, set a maximum length, and choose hyphens, underscores, or either as word separators.</p>
                </div>
                <div class="fcs3-d2-card">
                    <h6>Keywords</h6>
                    <p>Skip chosen words in title casing checks and block stop words in URLs so keyword rules stay the same on every page.</p>
                </div>
            </div>
        </div>
        <div class="fcs3-d3">
            <div class="fcs3-d3-d1 arrow-active">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
            <div class="fcs3-d3-d2">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </div>
     </section>
    <!-- Section 3 Ends -->

    <!-- Section 4 Starts -->
     <section id="fcs4" class="fr2 section-margin-top-zero section-margin-bottom-zero">
        <div class="fr2-d">
            <h1 class="fr2-d-h">
                Define your acceptance criteria for performance tests
            </h1>
            <p class="fr2-d-p">
                Set the scores a page must reach before a performance check passes. Choose minimum PageSpeed scores for desktop and mobile, then apply the same Lighthouse, Core Web Vitals, and mobile-friendliness bars to every audit in the project.
            </p>
            <img class="fr2-d-img zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-settings/Group-1009-(1).svg') }}" alt="">
        </div>
     </section>
    <!-- Section 4 Ends -->

    <!-- Section 5 Starts -->
     <section class="fcs5">
        <div class="fcs5-d">
            <h1>Coding Best Practices</h1>
            <p>Set the markup and delivery rules every page must meet. These checks cover compression, caching, page weight, and HTML patterns that slow rendering or make pages harder to crawl.</p>
            <div class="fcs5-inner container">
                <div class="fcs5-cards">
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >HTML Code Compression</h5>
                            </div>
                            
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>A page passes when its HTML is minified and extra whitespace and comments have been removed.</p>
                        </div>
                    </div>
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >HTML Page Size</h5>
                            </div>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>Set the maximum HTML document size in kilobytes. Images and external CSS or JavaScript files are left out of that total.</p>
                        </div>
                    </div>
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >CSS Code Compression</h5>
                            </div>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>External stylesheets must be compressed and minified before the page can pass.</p>
                        </div>
                    </div>
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >Frameset</h5>
                            </div>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>The page must not use a frameset. Frames split the window into separate documents and are difficult for users and crawlers.</p>
                        </div>
                    </div>
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >JS Code Compression</h5>
                            </div>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>External JavaScript files must be compressed and minified.</p>
                        </div>
                    </div>
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >Broken Links</h5>
                            </div>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>Flag links that do not return a 200 status, and keep an ignore list for URLs you want this check to skip.</p>
                        </div>
                    </div>
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >GZip Compression</h5>
                            </div>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>The HTML response must be served with GZIP compression enabled.</p>
                        </div>
                    </div>
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >CSS Caching</h5>
                            </div>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>Stylesheets must send cache headers such as Cache-Control or an ETag so returning visitors are not forced to download them again.</p>
                        </div>
                    </div>
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >Nested Tables</h5>
                            </div>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>The page must not contain a table inside another table. Nested tables slow rendering.</p>
                        </div>
                    </div>
                    <div class="fcs5-card">
                        <div class="fcs5-card-question">
                            <div class="fcs5-card-question-h5">
                                <h5 >JS Caching</h5>
                            </div>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="fcs5-card-toggle">
                            <p>JavaScript files must send cache headers such as Cache-Control or an ETag so repeat visits can reuse them.</p>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
     </section>
    <!-- Section 5 Ends -->

    <!-- Section 6 Starts -->
     <section class="fcs6">
        <div class="fcs6-inner">
            <div class="fcs6-d1">
                <h1>Security Settings</h1>
                <p>Turn on the security checks a project must pass. Each card opens that test in Tools so you can run it on its own.</p>
            </div>
            <div class="fcs6-cards-wrapper cards-paddings">
                <div class="fcs6-cards">
                    <a class="fcs6-card" href="{{ route('tools', ['slug' => 'safe-browsing-test']) }}">
                        <h6>Safe Browsing</h6>
                        <p>Fail the project if Google Safe Browsing flags the site for malware, phishing, or other harmful content.</p>
                    </a>
                    <a class="fcs6-card" href="{{ route('tools', ['slug' => 'unsafe-cross-origin-links-test']) }}">
                        <h6>Unsafe Cross Origin Links</h6>
                        <p>Links that open in a new tab must include rel="noopener" or rel="noreferrer" so the original page cannot be controlled by the destination.</p>
                    </a>
                    <a class="fcs6-card" href="{{ route('tools', ['slug' => 'protocall-relative-resource-links-test']) }}">
                        <h6>Protocol Relative Resource Links</h6>
                        <p>Require full HTTPS URLs for page resources. Protocol-relative links that start with // are not allowed.</p>
                    </a>
                    <a class="fcs6-card" href="{{ route('tools', ['slug' => 'content-security-policy-header-test']) }}">
                        <h6>Content Security Policy Header</h6>
                        <p>The response must include a Content-Security-Policy header that limits where scripts and other resources can load from.</p>
                    </a>
                    <a class="fcs6-card" href="{{ route('tools', ['slug' => 'x-frame-options-header-test']) }}">
                        <h6>X Frame Options Header</h6>
                        <p>The response must send X-Frame-Options so other sites cannot embed the page and attempt clickjacking.</p>
                    </a>
                    <a class="fcs6-card" href="{{ route('tools', ['slug' => 'hsts-header-test']) }}">
                        <h6>HSTS Header</h6>
                        <p>The site must send Strict-Transport-Security so browsers keep using HTTPS on later visits.</p>
                    </a>
                    <a class="fcs6-card" href="{{ route('tools', ['slug' => 'bad-content-type-test']) }}">
                        <h6>Bad Content Type</h6>
                        <p>HTML, CSS, JavaScript, and images must be served with the correct Content-Type so browsers do not guess the file type.</p>
                    </a>
                    <a class="fcs6-card" href="{{ route('tools', ['slug' => 'ssl-certificate-test']) }}">
                        <h6>SSL Certificate</h6>
                        <p>The certificate must be valid, unexpired, trusted, and matched to the domain, with the page served over HTTPS.</p>
                    </a>
                    <a class="fcs6-card" href="{{ route('tools', ['slug' => 'directory-browsing-test']) }}">
                        <h6>Directory Browsing</h6>
                        <p>Directory listings must be turned off so visitors cannot open folders and browse files on the server.</p>
                    </a>
                </div>
            </div>
                
            <div class="fcs6-bottom">
                <div class="fcs6-bottom1">
                    <img src="{{ asset('new-assets/assets/images/aboutUs/left-arrow.svg') }}" alt="">
                </div>
                <div class="fcs6-bottom2">
                    <img src="{{ asset('new-assets/assets/images/aboutUs/right-arrow.svg') }}" alt="">
                </div>
            </div>
        </div>
     </section>
    <!-- Section 6 Ends -->

    <!-- Section 7 starts -->
         <section id="fcs7" class="fcr7">
            <div class="as6-inner container">
                <h1 class="as6-h">Frequently Asked Questions</h1>
                <div class="as6-cards">
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">What do Settings control?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Settings are the pass and fail rules for a project. Audits and bulk tools use those same rules, so a page is judged the same way in every check.</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">Can each project have its own rules?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Yes. Title length, casing, image rules, URL rules, and which checks are required are saved on the project. Updating one project leaves the others unchanged.</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">Which SEO rules can I customize?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>You can set title and description length, title casing, whether the title may match the H1, heading counts, image alt text and filenames, and URL length, case, and separators.</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">Do coding and security tests have numeric limits?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Most of them are on or off. Compression, caching, framesets, security headers, SSL, and Safe Browsing either meet the rule or they fail. HTML page size, image size, and the broken-link ignore list are the checks with extra options.</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">Will a settings change update results I already have?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>New audits and tool runs use the updated rules. Results that are already saved stay as they are until you run those checks again.</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">Where can I run a single security test?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Each card under Security Settings links to that test in Tools. Open the card to run the check without starting a full project audit.</p>
                        </div>
                    </div>
                </div>

                
            </div>
        </section>
        <!-- Section 7 ends -->

        <!-- Section 8 Starts -->
     <section class="fr4 section-margin">
        <div class="fr4-inner">
            <div class="fr4-d1">
                <h3>Increase Your Website Performance with Premium Features</h3>
                <p>Explore organic and paid traffic metrics for any website using Site Explorer.</p>
                <div>
                    <button class="fr4-d1-button" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Sign Up Free
                    </button>
                </div>
            </div>
            <div class="fr4-d2">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-settings/image-71-(3).svg') }}" alt="">
            </div>
        </div>
   </section>
    <!-- Section 8 Ends -->

    <div id="imagePreviewOverlay">
        <span class="image-preview-close">&times;</span>
        <img id="imagePreviewContent" src="" alt="Preview">
    </div>
     @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
@endsection
@endsection