@extends('layouts.master')

@section('title', 'Track Every URL in One Live Table | Webqa')
@section('meta-description', 'Replace spreadsheets with Website Tracker. See metrics for every URL, grouped by directory. Re-check in a click, view pass/fail colors, and export CSV/XLSX.')
@section('canonical', 'https://webqa.co/features/website-tracker')
@section('og-title', 'Website Tracker: One Live Table for Every URL | Webqa')
@section('og-description', 'Monitor all metrics across your site in a single, filterable view. Group by directory, refresh results anytime, and export CSV/XLSX for easy hand-offs.')
@section('og-url', 'https://webqa.co/features/website-tracker')
@section('og-image', 'https://webqa.co/new-assets/assets/images/meta-tags/open-graph-image.png')
@section('og-image-alt', 'Website tracker')

@section("content")
    
    
    <!-- Section 1 Starts -->
     <section class="fcwt1">
        <div class="fcwt1-d1">
            <h1>Effortless Website Tracking in One Place</h1>
            <p>Replace scattered sheets with a single, filterable tracker for every URL—see key metrics at a glance, spot patterns, drill into reports, re-check in one click, share what matters, and keep teams aligned.</p>
            <div>
                <button class="fr1-d1-button">
                    Try Website Tracker Free
                </button>
            </div>
        </div>
        <div class="fcwt1-d2">
            <img 
            src="{{ asset('new-assets/assets/images/feature-childpage-webtracker/Group-1044.svg') }}" alt="Webqa website tracker interface">
        </div>
     </section>
    <!-- Section 1 Ends -->

    <!-- Section 2 Starts -->
     <section class="fcwt2">
        <div class="fcwt2-d1">
            <h1 style="max-width:750px;">Your entire website, one live tracker</h1>
        </div>
        <div class="fcwt2-d2">
            <div class="fcwt2-d2-card-d">
                <h3>
                    One table for every URL
                </h3>
                <p>Track all key metrics for your project in a single, live, tabular view—so you can scan performance across pages without hopping between reports. Organize at scale and keep everything in one place.
                <p>URLs are grouped by directory and cover results from 38 tests, giving you a complete snapshot at a glance.</p>    
                </p> 
            </div>
            <div class="fcwt2-d2-card">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-webtracker/Group-1045.svg') }}" alt="One table for every URL">
            </div>
            <div class="fcwt2-d2-card">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-webtracker/Group-1046.svg') }}" alt="Customize the view to your workflow">
            </div>
            <div class="fcwt2-d2-card-d">
                <h3>
                    Customize the view to your workflow
                </h3>
                <p>Hide columns you don’t need, focus on the tests that matter, and reorder columns like a spreadsheet—so the tracker mirrors how your team reviews pages. 

                </p>
                <p>Build stakeholder-specific views (SEO, content, engineering) to keep each team focused on the metrics they own.</p>
                
            </div>
            <div class="fcwt2-d2-card-d">
                <h3>
                    Re-check with recency you can trust
                </h3>
                <p>Refresh results for the whole project or for selected URLs. The tracker shows when each page was last checked, helping you judge freshness and validity before acting
               
                </p>
                <p>Re-check all URLs or just a subset in a click, so template changes and hotfixes are verified immediately.</p>
            </div>
            <div class="fcwt2-d2-card">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-webtracker/Group-1045.svg') }}" alt="Re-check with recency you can trust">
            </div>
            <div class="fcwt2-d2-card">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-webtracker/Group-1046.svg') }}" alt="Visual status + easy exports">
            </div>
            <div class="fcwt2-d2-card-d">
                <h3>
                    Visual status + easy exports
                </h3>
                <p>Scan pass/fail at a glance with clear status cues, then export the entire table to CSV or XLSX for deeper analysis or sharing with stakeholders. Import to Sheets/Excel in seconds
               
                </p>
                <p>Green cells highlight passes and red cells flag failures—making it obvious where to prioritize fixes before you export.</p>
            </div>
        </div>
     </section>
    <!-- Section 2 Ends -->

    <!-- Section 3 Starts  -->
     <section class="fcwt3">
        <div class="fcwt3-d1">
            <h1>See Website Tracker in action</h1>
            <p>Flip through real screenshots of the live, filterable table. Watch how pages group by directory, pass/fail colors surface priorities, and one-click re-checks keep every metric fresh.</p>
        </div>
        <div class="fcwt3-d2">
            <div class="fcwt3-d2-wrapper">
                <div class="fcwt3-d2-slide">
                    <img src="{{ asset('new-assets/assets/images/feature-childpage-webtracker/Group-1012.svg') }}" alt="detailed view of website tracker 1">
                </div>
                <div class="fcwt3-d2-slide">
                    <img src="{{ asset('new-assets/assets/images/feature-childpage-webtracker/Group-1012.svg') }}" alt="detailed view of website tracker 2">
                </div>
                <div class="fcwt3-d2-slide">
                    <img src="{{ asset('new-assets/assets/images/feature-childpage-webtracker/Group-1012.svg') }}" alt="detailed view of website tracker 3">
                </div>
            </div>
        </div>
     </section>
    <!-- Section 3 Ends  -->

    <!-- Section 4 Starts -->
     @include('components.imran-components.fcr6')
    <!-- Section 4 Ends -->

    <!-- Section 5 Starts -->
    {{-- has margin-top: 150px; and margin-bottom: 150px; --}}
     <section class="fcr7">
            <div class="as6-inner container">
                <h1 class="as6-h">Frequently Asked Questions</h1>
                <div class="as6-cards">
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">What exactly is Website Tracker, and how is it different from Reports?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="down arrow">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Website Tracker is the bird’s-eye view of your site. It brings all tracked metrics for every URL into one large, tabular view, so you can scan performance across pages without hopping between individual reports.</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">What data does the tracker include, and how is it organized?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="down arrow">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Results from 38 tests across SEO, performance, best practices, and security. URLs are grouped by directory, so you can compare sections/templates and spot regressions quickly.</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">Can I customize the tracker to match how my team reviews pages?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="down arrow">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Yes. Hide columns or entire tests, reorder columns like a spreadsheet, and tailor views for SEO, content, or engineering. Re-check all or selected URLs; last-checked dates show freshness.</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">How do pass/fail indicators and recency help me prioritize fixes?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="down arrow">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Green cells mean a metric passed; red cells flag failures—priorities pop instantly. The last-checked date helps you judge freshness after releases, then jump to the matching report to fix fast.</p>
                        </div>
                    </div>
                    <div class="as6-card">
                        <div class="as6-card-question">
                            <h5 class="as6-card-question-h5">Can I export the tracker and work in Excel/Sheets if needed?</h5>
                            <img src="{{ asset('new-assets/assets/images/aboutUs/down-arrow.svg') }}" alt="down arrow">
                        </div>
                        <div class="as6-card-toggle">
                            <p>Yes. Export the tracker to CSV/XLSX for Excel/Sheets. Individual Webpage Audits export to PDF/CSV/XLSX and have shareable links. Bulk Tools runs aren’t saved as links but their tables can be downloaded.</p>
                        </div>
                    </div>
                </div>

                
            </div>
   </section>
    <!-- Section 5 Ends -->
     
    <!-- Section 6 Starts -->
     <section class="fr4 section-margin">
        <div class="fr4-inner">
            <div class="fr4-d1">
                <h3>Replace Clumsy spreadsheets with Website Tracker</h3>
                <p style="max-width:600px;">See all metrics for every page, grouped by directory. Build review-ready views, refresh results anytime, and keep teams aligned on what to fix first.</p>
                <div>
                    <button class="fr4-d1-button" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Sign Up Free
                    </button>
                </div>
            </div>
            <div class="fr4-d2" id="fcwt-s6">
                <img src="{{ asset('new-assets/assets/images/feature-childpage-webtracker/image-71-(2).svg') }}" alt="man and woman looking at a laptop">
            </div>
        </div>
   </section>
    <!-- Section 6 Ends -->



     @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
@endsection
@endsection