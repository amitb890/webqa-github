@extends('layouts.master')

@section('title', 'Run Precise Webpage Audits with Clear Pass/Fail | Webqa')
@section('meta-description', 'Audit any URL against your standards. Set criteria like title length and casing, get Pass/Fail results, share analysis links, and export PDF/CSV/XLSX.')
@section('canonical', 'https://webqa.co/features/webpage-audit')
@section('og-title', 'Custom Webpage Audits with Shareable Results | Webqa')
@section('og-description', 'Define acceptance criteria, test any page, and see decisive Pass/Fail outcomes. Each analysis includes a shareable URL and exports to PDF/CSV/XLSX.')
@section('og-url', 'https://webqa.co/features/webpage-audit')
@section('og-image', 'https://webqa.co/new-assets/assets/images/meta-tags/open-graph-image.png')
@section('og-image-alt', 'Webpage audit')

@section("content")

    <!-- Section 1 Starts -->
     <section class="fcs1">
        <div id="fcat1" class="fcs1-d1">
            <h1>Run a complete Website Audit of your website</h1>
            <p>
                Keep your website in top shape for users and search engines. prioritize, and fix 170+ technical and on-page SEO issues. 
            </p>
            <div class="fcs1-d1-button">
                <button class="fr1-d1-button" id="fr1-d1-button" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Sign Up Free
                </button>
            </div>
        </div>
        <div class="fcs1-d2" id="fcat1-d2">
            <img src="{{ asset('new-assets/assets/images/feature-childpage-audtest/iP7k4x-MRCSU9zvi8Cz4-Photoroom-1.svg') }}" alt="">
        </div>
     </section>
    <!-- Section 1 Ends -->

    <!-- Section 2 Start -->
     <section class="fcat2">
        <h1>
            What is Website Audit
        </h1>
        <p>
            A website audit is like a comprehensive health check-up for your website. It's a thorough examination of various aspects that influence your website's performance, user experience, and search engine visibility. The goal is to uncover strengths, weaknesses, and potential issues that might be hindering the site from achieving its goals.
        </p>
     </section>
    <!-- Section 2 Ends -->


    <!-- Section 3 starts -->
     <section class="fcwt2" id="fcat3" style="background-color: #f1f4f9; margin-top: 0;">
        <div class="fcwt2-d1" id="fcat3-d1">
            <h1>Features that transform the way to audit</h1>
        </div>
        <div class="fcwt2-d2" id="fcat2-d2">
            <div class="fcwt2-d2-card-d" id="fcat2-d2-card-d-1">
                <h3>
                    All major metrics in one simple dashboard
                </h3>
                <p>Marketplaces leave you in a sea of competitors, but growing your own strong brand boosts recognition and loyalty while keeping you in control. 
                    <br>
                    <p>
                        Showcase glowing reviews from Setmore or Google and give a clear snapshot of what your brand is all about.
                    </p>
                </p> 
            </div>
            <div class="fcwt2-d2-card" id="fcat3-d2-card-2">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-audtest/Group-1065.svg') }}" alt="">
            </div>
            <div class="fcwt2-d2-card" id="fcat3-d2-card">
                <img
                 src="{{ asset('new-assets/assets/images/feature-childpage-audtest/Group-1066.svg') }}" alt="">
            </div>
            <div class="fcwt2-d2-card-d padding-left" id="fcat2-d2-card-d-4">
                <h3>
                    115+ metrics for in-depth analysis
                </h3>
                <p>Display your services and let customers choose a time and team member that suits them. Once booked, they receive a confirmation—with a link for virtual appointments. 
                </p>
                <p>
                    It's your page, you make the rules. Tailor every aspect of your offering — and most importantly, keep all the profit.
                </p>
            </div>
            <div class="fcwt2-d2-card-d" id="fcat3-d2-card-d-5">
                <h3>
                    Track Improvements Over Time
                </h3>
                <p>Marketplaces leave you in a sea of competitors, but growing your own strong brand boosts recognition and loyalty while keeping you in control. 
                    <br>
                    <p>
                        Showcase glowing reviews from Setmore or Google and give a clear snapshot of what your brand is all about.
                    </p>
                </p>
            </div>
            <div class="fcwt2-d2-card" id="fcat3-d2-card-6">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-audtest/Group-1065-(1).svg') }}" alt="">
            </div>
            <div class="fcwt2-d2-card" id="fcat3-d2-card-7">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-audtest/Group-1066-(1).svg') }}" alt="">
            </div>
            <div class="fcwt2-d2-card-d padding-left" id="fcat3-d2-card-d-8">
                <h3>
                    Get an SEO audit of every single page, image, or resource
                </h3>
                <p>Display your services and let customers choose a time and team member that suits them. Once booked, they receive a confirmation—with a link for virtual appointments.
                <p>
                    It's your page, you make the rules. Tailor every aspect of your offering — and most importantly, keep all the profit.
                </p>
                </p>
            </div>
        </div>
     </section>
    <!-- Section 3 Ends -->
    
    <!-- Section 4 Starts -->
    <section class="fcat4">
      <div class="fcat4-mainD">
        <h1 class="fcat4-mainD-h">Steps for Website Auditing</h1>
        <div class="fcat4-mainD-cards">
          <div class="fcat4-mainD-d-card">
            <img src="{{ asset('new-assets/assets/images/feature-childpage-audtest/left-card.svg') }}" alt="">
            <div class="fcat4-mainD-d-card-ld">
              <div class="fcat4-mainD-d-card-d1">
                <h6>1</h6>
              </div>
              <div class="fcat4-mainD-d-card-ldd"></div>
            </div>
            <div class="fcat4-mainD-d-card-d2">
              <h6>Enter your website URL</h6>
              <p>Simply enter your website’s URL in the field above and click “Test Now.”</p>
            </div>
          </div>
          <div class="fcat4-mainD-d-card">
            <img src="{{ asset('new-assets/assets/images/feature-childpage-audtest/center-card.svg') }}" alt="">
            <div class="fcat4-mainD-d-card-ld">
              <div class="fcat4-mainD-d-card-d1">
                <h6>2</h6>
              </div>
              <div class="fcat4-mainD-d-card-ldd"></div>
            </div>
            <div class="fcat4-mainD-d-card-d2">
              <h6>Set up your project</h6>
              <p>Configure your audit by defining a crawl scope, page limit, crawl source, and project name.</p>
            </div>
          </div>
          <div class="fcat4-mainD-d-card">
            <img src="{{ asset('new-assets/assets/images/feature-childpage-audtest/right-card.svg') }}" alt="">
            <div class="fcat4-mainD-d-card-ld">
              <div class="fcat4-mainD-d-card-d1">
                <h6>3</h6>
              </div>
              <div class="fcat4-mainD-d-card-ldd" style="opacity:0;"></div>
            </div>
            <div class="fcat4-mainD-d-card-d2">
              <h6>Scan your website</h6>
              <p>Site Audit tool will automatically scan your site, checking for more than 140 on-page and technical SEO factors.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Section 4 Ends -->

    <!-- Section 5 Starts -->
     @include('components.imran-components.fcr6')
    <!-- Section 5 Ends -->

    <!-- Section 6 Starts -->
    {{-- has margin-top: 150px; and margin-bottom: 150px; --}}
      <section class="fcr7 fact-6">
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
    <!-- Section 6 Ends -->

    <!-- Last Section Starts -->
   <section class="fr4 section-margin fcat-last">
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
            <div class="fr4-d2" id="fcat-last-d2-reports">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-audtest/image-71-(4).svg') }}" alt="">
            </div>
        </div>
   </section>
  <!-- Last Section Ends -->


        <!-- Footer Area Start -->
    {{-- @include('components.imran-components.footer') --}}
    <!-- Footer Area End -->
 @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
@endsection
@endsection