@extends('layouts.master')

@section('title', 'Features that Turn Audits into Action | Webqa')
@section('meta-description', 'Explore Webqa features—Webpage Audit, Website Tracker, Reports, and Settings. Set your standards, audit any URL, share results, and export PDF/CSV/XLSX.')
@section('canonical', 'https://webqa.co/features')
@section('og-title', 'Webqa Features: From Audits to Action')
@section('og-description', 'See how Webqa combines customizable audits, a live tracker, per-metric reports, and project-wide settings to turn findings into fixes—plus exports for easy hand-offs.')
@section('og-url', 'https://webqa.co/features')
@section('og-image', 'https://webqa.co/new-assets/assets/images/meta-tags/open-graph-image.png')
@section('og-image-alt', 'Webqa features')

@section("content")
    

    <!-- Section 1 starts -->
     <section class="fr1">
        <div class="fr1-d1">
            <h1 class="fr1-d1-h">Features that turn audits into action</h1>
            <p class="fr1-d1-p">
                Define your own standards, audit any page, and move from findings to fixes with shareable results, reports, and site-wide tracking.
            </p>
            <div>
                <button class="fr1-d1-button" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Sign up Free
                </button>
            </div>
        </div>
        <div class="fr1-d2">
            <img class="fr1-d2-img" 
            src="{{ asset('new-assets/assets/images/feature-root-page/Group-1064.svg') }}" alt="A woman using a laptop to run website audit">
        </div>
     </section>
    <!-- Section 1 ends -->


    <!-- Section 2 Starts -->
     <section class="fr2">
        <div class="fr2-d">
            <h1 class="fr2-d-h">
                Webpage Audit
            </h1>
            <p class="fr2-d-p">
                Run precise, per-URL audits against criteria you control (e.g., title length, casing rules, “must not equal H1”) and get clear Pass/Fail outcomes. Every analysis has a shareable URL and export options (PDF/CSV/XLSX).
            </p>
            <img class="fr2-d-img" 
            src="{{ asset('new-assets/assets/images/feature-root-page/Group-1017.svg') }}" alt="A sample webpage audit report">
            <div class="fr2-d-d">
                <h6 class="fr2-d-d-h6">Standards-based checks you can act on fast</h6>
                <div class="fr2-d-d-d container">
                    <div class="fr2-d-d-dDivs">
                        <h6>
                            Standards based auditing
                        </h6>
                        <p>Define acceptance criteria per test. Webqa returns clear Pass/Fail results against your rules—not generic ones</p>
                    </div>
                    <div class="fr2-d-d-dDivs">
                        <h6>
                            Shareable results
                        </h6>
                        <p>Every analysis gets a permanent, shareable URL; export findings as PDF, CSV, or XLSX for smooth reviews and hand-offs.</p>
                    </div>
                    <div class="fr2-d-d-dDivs">
                        <h6>
                            Bulk checks at scale
                        </h6>
                        <p>Use Tools to run a single check on up to 100 URLs—perfect for templates and key sections—then download results as CSV/XLSX</p>
                    </div>
                </div>
                <div>
                    <button class="fr2-d-d-d2" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Sign up FREE
                    </button>
                </div>
            </div>
        </div>
     </section>
    <!-- Section 2 Ends -->


    <!-- Section 3 Starts -->
     <section class="fr3">
        <div class="fr3-d">
            <div class="fr3-d-h">
                <h1 >
                    Customized Auditing Settings
                </h1>
            </div>
            <p class="fr3-d-p">
                Define acceptance criteria at the project level so every audit reflects your standards—not generic ones. Tune only the parameters you care about.
            </p>
            <img class="fr3-d-img" 
            src="{{ asset('new-assets/assets/images/feature-root-page/Group-1036-(1).svg') }}" alt="customised auditing settings in webqa">
            <div class="fr3-d-d">
                <h6 class="fr3-d-d-h6">Your rules, consistently applied across every audit</h6>
                <div class="fr3-d-d-d container">
                    <div class="fr3-d-d-dDivs">
                        <h6>
                            Define rules per test
                        </h6>
                        <p>Set min/max lengths, casing rules, “must not equal H1,” and more to match your standards.</p>
                    </div>
                    <div class="fr3-d-d-dDivs">
                        <h6>
                            Choose only what matters
                        </h6>
                        <p>Toggle off checks you don’t need and set custom values for the ones you do.</p>
                    </div>
                    <div class="fr3-d-d-dDivs">
                        <h6>
                            Keep settings consistent
                        </h6>
                        <p>Save criteria at the project level and use the same rules in bulk Tools runs.</p>
                    </div>
                </div>
                {{-- <div>
                    <button class="fr2-d-d-d2" data-bs-toggle="modal" data-bs-target="#LoginexampleModal">
                        Sign up Free
                    </button>
                </div> --}}
            </div>
        </div>
     </section>
    <!-- Section 3 Ends -->

    <!-- Section 4 starts -->
     <section class="fr4 margin-top-50 margin-bottom-50">
        <div class="fr4-inner">
            <div class="fr4-d1">
                <h3>Ship better webpages with smarter, customised audits</h3>
                <p>Set your standards, audit any URL, and act on clear Pass/Fail results—plus shareable reports and bulk tools.</p>
                <div>
                    <button class="fr4-d1-button" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Sign Up Free
                    </button>
                </div>
            </div>
            <div class="fr4-d2" id="fr4-d2">
                <img src="{{ asset('new-assets/assets/images/feature-root-page/image-71.svg') }}" alt="Man working on a laptop">
            </div>
        </div>
     </section>
    <!-- Section 4 ends -->


    <!-- Section 5 Starts -->
     <section class="fr2">
        <div class="fr2-d">
            <h1 class="fr2-d-h">
                Website Tracker
            </h1>
            <p class="fr2-d-p">
                See all key metrics for every tracked URL in one large, filterable table—perfect for spotting patterns across templates and catching regressions early.
            </p>
            <img class="fr2-d-img"
             src="{{ asset('new-assets/assets/images/feature-root-page/Group-1036-(2).svg') }}" alt="Website tracker interface of Webqa">
            <div class="fr2-d-d">
                <h6 class="fr2-d-d-h6">All your page metrics in one, always-current view</h6>
                <div class="fr2-d-d-d container">
                    <div class="fr2-d-d-dDivs">
                        <h6>
                            All metrics, all URLs
                        </h6>
                        <p>View every tracked metric for your project in one large, tabular view—so everything’s in one place.</p>
                    </div>
                    <div class="fr2-d-d-dDivs">
                        <h6>
                            Drill into details fast
                        </h6>
                        <p>Jump from high-level summaries to per-metric, tabular reports whenever you need deeper analysis.</p>
                    </div>
                    <div class="fr2-d-d-dDivs">
                        <h6>
                            Keep results up to date
                        </h6>
                        <p>Re-check the project anytime and refresh the tracker with the latest findings.</p>
                    </div>
                </div>
                <div>
                    <button class="fr2-d-d-d2" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Sign up Free
                    </button>
                </div>
            </div>
        </div>
     </section>
    <!-- Section 5 Ends -->

    <!-- Section 6 Starts -->
     <section class="fr3">
        <div class="fr3-d">
            <div class="fr3-d-h">
                <h1 >
                    Website Reports
                </h1>
            </div>
            <p class="fr3-d-p">
                Turn findings into focused action with per-metric, tabular reports you can open straight from the dashboard—then export to PDF, CSV, or XLSX for quick reviews and hand-offs.
            </p>
            <img class="fr3-d-img"
             src="{{ asset('new-assets/assets/images/feature-root-page/Group-1037.svg') }}" alt="A custom website report in Webqa">
            <div class="fr3-d-d">
                <h6 class="fr3-d-d-h6">Per-metric tables that turn findings into fixes</h6>
                <div class="fr3-d-d-d container">
                    <div class="fr3-d-d-dDivs">
                        <h6>
                            Per-metric, tabular reports
                        </h6>
                        <p>See detailed tables for each metric (titles, descriptions, canonicals, speed, and more).</p>
                    </div>
                    <div class="fr3-d-d-dDivs">
                        <h6>
                            Jump in from the dashboard
                        </h6>
                        <p>Open any report directly from its dashboard widget to drill down fast.</p>
                    </div>
                    <div class="fr3-d-d-dDivs">
                        <h6>
                            Export & share results
                        </h6>
                        <p>Download reports as PDF, CSV, or XLSX for easy reviews and hand-offs.</p>
                    </div>
                </div>
                {{-- <div>
                    <button class="fr2-d-d-d2" data-bs-toggle="modal" data-bs-target="#LoginexampleModal">
                        Sign up Free
                    </button>
                </div> --}}
            </div>
        </div>
     </section>
    <!-- Section 6 Ends -->

    <!-- Section last starts -->
     <section class="frlast">
        <div class="frlast-inner">
            <div class="frlast-d1">
                <h3>Raise your website’s quality bar</h3>
                <p>Set the rules once—Webqa applies them everywhere, surfaces issues, and helps you prioritize what to fix next.</p>
                <div>
                    <button class="fr4-d1-button" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Sign Up Free
                    </button>
                </div>
            </div>
            <div class="frlast-d2">
                <img
                 src="{{ asset('new-assets/assets/images/feature-root-page/young-person-intership-Photoroom-1.svg') }}" alt="Two team members working on a laptop">
            </div>
        </div>
     </section>
    <!-- Section last ends -->

     @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
@endsection
@endsection