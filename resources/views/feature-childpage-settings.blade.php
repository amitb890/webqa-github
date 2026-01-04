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
                    <p>Easily customize your website’s meta titles to improve search visibility.</p>
                </div>
                <div class="fcs3-d2-card card-active">
                    <h6>Meta Title</h6>
                    <p>Easily customize your website’s meta titles to improve search visibility.</p>
                </div>
                <div class="fcs3-d2-card">
                    <h6>Meta Description</h6>
                    <p>Easily customize your website’s meta titles to improve search visibility.</p>
                </div>
                <div class="fcs3-d2-card">
                    <h6>Images</h6>
                    <p>Easily customize your website’s meta titles to improve search visibility.</p>
                </div>
                <div class="fcs3-d2-card">
                    <h6>URL Slug</h6>
                    <p>Easily customize your website’s meta titles to improve search visibility.</p>
                </div>
                <div class="fcs3-d2-card">
                    <h6>Keywords</h6>
                    <p>Easily customize your website’s meta titles to improve search visibility.</p>
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
                Our Customized Auditing Settings let you define exactly what matters for your website’s success. Choose specific metrics, focus areas, and performance goals tailored to your business. From SEO to speed optimization, our flexible settings ensure every audit delivers precise insights, empowering you to take targeted, impactful action.
            </p>
            <img class="fr2-d-img zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-settings/Group-1009-(1).svg') }}" alt="">
        </div>
     </section>
    <!-- Section 4 Ends -->

    <!-- Section 5 Starts -->
     <section class="fcs5">
        <div class="fcs5-d">
            <h1>Coding Best Practices</h1>
            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                            <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
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
                <p>Web QA offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
            </div>
            <div class="fcs6-cards-wrapper cards-paddings">
                <div class="fcs6-cards">
                    <div class="fcs6-card">
                        <h6>Safe Browsing</h6>
                        <p>Identifies issues like broken links, slow page speed, and poor keyword usage that may be affecting your search engine rankings.</p>
                    </div>
                    <div class="fcs6-card">
                        <h6>Unsafe Cross Origin <br> Links</h6>
                        <p>Identifies issues like broken links, slow page speed, and poor keyword usage that may be affecting your search engine rankings.</p>
                    </div>
                    <div class="fcs6-card">
                        <h6>Protocol Relative Resource Links</h6>
                        <p>Identifies issues like broken links, slow page speed, and poor keyword usage that may be affecting your search engine rankings.</p>
                    </div>
                    <div class="fcs6-card">
                        <h6>Content Security Policy Header</h6>
                        <p>Identifies issues like broken links, slow page speed, and poor keyword usage that may be affecting your search engine rankings.</p>
                    </div>
                    <div class="fcs6-card">
                        <h6>Content Security Policy Header</h6>
                        <p>Identifies issues like broken links, slow page speed, and poor keyword usage that may be affecting your search engine rankings.</p>
                    </div>
                    <div class="fcs6-card">
                        <h6>Content Security Policy Header</h6>
                        <p>Identifies issues like broken links, slow page speed, and poor keyword usage that may be affecting your search engine rankings.</p>
                    </div>
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
                            <h5 class="as6-card-question-h5">How do I retrieve my password?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos libero quos sint nulla sapiente, sunt veniam ullam doloremque aperiam? Voluptate, accusantium enim dolores atque maxime nesciunt repudiandae dignissimos expedita ipsum quisquam tempora sequi saepe nostrum eum error molestiae, unde quis!</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">What's included in the free trial?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos libero quos sint nulla sapiente, sunt veniam ullam doloremque aperiam? Voluptate, accusantium enim dolores atque maxime nesciunt repudiandae dignissimos expedita ipsum quisquam tempora sequi saepe nostrum eum error molestiae, unde quis!</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">How do I remove extra keywords/projects after switching to a subscription plan with lower limits?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos libero quos sint nulla sapiente, sunt veniam ullam doloremque aperiam? Voluptate, accusantium enim dolores atque maxime nesciunt repudiandae dignissimos expedita ipsum quisquam tempora sequi saepe nostrum eum error molestiae, unde quis!</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">How do I change my login and password?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos libero quos sint nulla sapiente, sunt veniam ullam doloremque aperiam? Voluptate, accusantium enim dolores atque maxime nesciunt repudiandae dignissimos expedita ipsum quisquam tempora sequi saepe nostrum eum error molestiae, unde quis!</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">How to set the location where I want to track keywords?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos libero quos sint nulla sapiente, sunt veniam ullam doloremque aperiam? Voluptate, accusantium enim dolores atque maxime nesciunt repudiandae dignissimos expedita ipsum quisquam tempora sequi saepe nostrum eum error molestiae, unde quis!</p>
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