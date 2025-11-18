@extends('layouts.master')

@section('title', 'About us | Webqa')
@section('meta-description', 'Webqa simplifies website audits with your standards—custom checks, pass/fail clarity, shareable analysis, and a website tracker for faster fixes.')
@section('canonical', 'https://webqa.co/aboutus')
@section('og-title', 'About Webqa — Smarter Website Auditing')
@section('og-description', 'Discover how Webqa turns audits into action with your standards, clear results, shareable analyses, and site-wide tracking to prioritize fixes.')
@section('og-url', 'https://webqa.co/aboutus')
@section('og-image', 'https://webqa.co/new-assets/assets/images/meta-tags/open-graph-image.png')
@section('og-image-alt', 'About Webqa')

@section("content")

        <!--Section 1 starts -->
        <section class="as1">
                <div class="as1-left">
                    <img class="as1-left-img1"  src="{{ asset('new-assets/assets/images/aboutUs/as1-left-img.svg') }}" alt="SEO professional">
                    <img class="as1-left-img2"  src="{{ asset('new-assets/assets/images/aboutUs/as1-left-img-absolute.svg') }}" alt="marketing analyst">
                </div>
                <div class="as1-center">
                    <h1 class="as1-center-h1"> <span style="color: #417cec;">Website auditing</span> done at scale!</h1>
                    <p class="as1-center-p">Run precise checks on demand—or in bulk—and cut through noise to the fixes that matter.</p>
                </div>
                <div class="as1-right">
                    <img class="as1-right-img2" src="{{ asset('new-assets/assets/images/aboutUs/as1-right-img-absolute.svg') }}" alt="reports">
                    <img class="as1-right-img1"  src="{{ asset('new-assets/assets/images/aboutUs/as1-right-img.svg') }}" alt="audit">
                </div>
        </section>
        <!-- Section 1 ends -->

        <!-- Section 2 starts -->
        <section class="as2 container-fluid">
            <div class="container-fluid as2-inner">
                <div class="as2-dtop">
                    <div class="as2-dtop-left">
                        <div class="as2-dtop-left-hs">
                            <h1 style="color: #fff;">About Webqa</h1>
                            <h1 style="color: #fff;"></h1>
                        </div>
                        <p class="as2-dtop-left-p">From solo creators to enterprise teams, Webqa makes page-level audits fast and reliable with customizable checks, shareable analysis links, and site-wide tracking that surfaces what to fix first.</p>
                    </div>
                    <div class="as2-dtop-right">
                        <p class="as2-dtop-right-p1">
                            Webqa helps you evaluate any page across SEO, performance, best practices, mobile, and security—then turn results into clear next steps.
                        </p>
                        <p class="as2-dtop-right-p2">
                            Define your own acceptance criteria for each test (for example, title length and casing rules, “must not equal H1,” and more) and get a precise Pass/Fail against your standards. Each analysis receives a unique, shareable URL and supports exports to PDF, CSV, and XLSX for easy hand-offs. When you need to move faster across templates, the Tools section lets you run a single check on up to 100 URLs at once. Getting started is free: add your site, we auto-detect URLs via XML sitemaps, and prepare a dashboard for 10 URLs with links to detailed reports and a Website Tracker for cross-page patterns.
                        </p>
                    </div>
                    <div class="as2-line1"></div>
                </div>
                <div class="as2-dmid">
                    <div class="as2-dmid-img">
                        <img  src="{{ asset('new-assets/assets/images/aboutUs/Layer-2.svg') }}" alt="Webqa mission">
                    </div>
                    <div class="as2-dmid-right">
                        <h2 class="as2-dmid-right-h" style="color: #fff;">Our Mission</h2>
                        <p class="as2-dmid-right-p">
                            Empower teams to ship better webpages faster by turning audits into clear, customizable checks—with shareable results, actionable reports, and tools that scale from a single URL to entire site sections.
                        </p>
                    </div>
                    <div class="as2-line2"></div>
                </div>
                <div class="as2-dlast">
                    <div class="as2-dlast-img">
                        <img  src="{{ asset('new-assets/assets/images/aboutUs/Layer-3.svg') }}" alt="Webqa vision">
                    </div>
                    
                    <div class="as2-dlast-right">
                        <h2 class="as2-dlast-right-h" style="color: #fff;">Our Vision</h2>
                        <p class="as2-dlast-right-p">
                            A web where quality is measurable and consistent—where anyone can define standards, audit with confidence, and fix what matters without friction.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section 2 ends -->

        <!-- Section 3 starts -->
         <section class="container as3">
            <div class="as3-top">
                <h1 class="as3-top-h">Features that turn audits into action</h1>
<p class="as3-top-p">Webqa gives you customizable checks, shareable reports, and a live website tracker—so teams align fast and fix what matters.</p>

            </div>
            <div class="as3-down">
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img class="as3-down-one-img2" src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(1).svg') }}" alt="webpage audit icon">
                    </div>
                    <h4 class="as3-down-one-h">Webpage Audit</h4>
                    <p class="as3-down-one-p">Analyze a page against your standards and instantly share or export findings to prioritize SEO, performance, and quality fixes.</p>
                    <button class="as3-down-buton" type="button"
  onclick="window.open('https://webqa.co/features/webpage-audit', '_blank', 'noopener,noreferrer')">
  Learn more
</button>

                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon2">
                           <img class="as3-down-two-img-div1" src="{{ asset('new-assets/assets/images/aboutUs/Vector.svg') }}" alt="website tracker icon 1">
                           <img class="as3-down-two-img-div2" src="{{ asset('new-assets/assets/images/aboutUs/Vector-(1).svg') }}" alt="website tracker icon 2"> 
                    </div>
                    <h4 class="as3-down-two-h">Website Tracker</h4>
                    <p class="as3-down-two-p">See every metric for every URL in one big, filterable table—perfect for spotting patterns across templates and catching regressions early</p>
                    <button class="as3-down-buton" type="button"
  onclick="window.open('https://webqa.co/features/website-tracker', '_blank', 'noopener,noreferrer')">
  Learn more
</button>

                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img class="as3-down-three-img2" src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(2).svg') }}" alt="reports icon">
                    </div>
                    <h4 class="as3-down-three-h">Reports</h4>
                    <p class="as3-down-three-p">Drill into tabular, per-metric reports (titles, descriptions, canonicals, speed, and more) straight from dashboard widgets for fast triage and fixes.</p>
                    <button class="as3-down-buton" type="button"
  onclick="window.open('https://webqa.co/features/reports', '_blank', 'noopener,noreferrer')">
  Learn more
</button>

                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img class="as3-down-four-img2" src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(3).svg') }}" alt="settings icon">
                    </div>
                    <h4 class="as3-down-four-h">Settings</h4>
                    <p class="as3-down-four-p">Define project-level rules that drive Pass/Fail for each test—your standards, not generic ones—so teams align on exactly what “good” looks like.</p>
                    <button class="as3-down-buton" type="button"
  onclick="window.open('https://webqa.co/features/settings', '_blank', 'noopener,noreferrer')">
  Learn more
</button>

                </div>
            </div>
         </section>
        <!-- Section 3 ends -->

        <!-- Secton 4 starts -->
         <section class="as4">
            <div class="container as4-inner">
                <div class="as4-topd">
                    <div class="as4-topd-h">
                        <h1>Explore our Tools</h1>
                      
                    </div>
                    <p class="as4-topd-p">
                        Your everyday QA, simplified. Run targeted tests, customize acceptance criteria, and turn results into clear fixes for SEO, performance, and accessibility.
                    </p>
                </div>
                <div class="as4-cards">
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-imgs">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector.svg') }}" alt="http status code checker icon 1">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector-(1).svg') }}" alt="http status code checker icon 2">
                        </div>
                        <h4>HTTP Status Code Checker</h4>
                        <p>Spot crawl blockers fast—check live response codes for single pages or bulk lists so you can fix redirects, 4xx/5xx, and SEO-impacting errors in one sweep.</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(1).svg') }}" alt="meta title test icon">
                        </div>
                        <h4>Meta Title Test</h4>
                        <p>Enforce your title standards at scale: set min/max length, casing rules, exclude words from casing checks, and ensure titles aren’t identical to H1—then get a clear Pass/Fail.</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(2).svg') }}" alt="core web vitals test icon">
                        </div>
                        <h4>Core Web Vitals</h4>
                        <p>Measure LCP, CLS, and INP/Lighthouse metrics to understand what’s slowing users down and prioritize fixes that move the needle on UX and rankings</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(2).svg') }}" alt="broken link checker icon">
                        </div>
                        <h4>Broken Links Checker</h4>
                        <p>Hunt down 404s and dead outbound links that hurt SEO and UX—clean them up and keep users (and crawlers) moving</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-imgs">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector.svg') }}" alt="robotstxt checker icon 1">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector-(1).svg') }}" alt="robotstxt checker icon 2">
                        </div>
                        <h4>Robots.txt Tester</h4>
                        <p>Validate crawl directives and catch disallow rules or syntax issues before they block important pages from indexing. Great for migrations and template changes.</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(3).svg') }}" alt="Images checker icon">
                        </div>
                        <h4>Images</h4>
                        <p>Audit image-related SEO on any page—surface missing or weak alt attributes and other image issues so you can boost accessibility, relevance, and load experience</p>
                    </div>
                    </a>
                </div>
                <button class="as4-button" type="button" onclick="window.open('https://webqa.co/tools', '_blank', 'noopener,noreferrer')">View All Tools</button>

            </div>
         </section>
        <!-- Secton 4 ends -->


        <!-- Section 5 starts -->
         <section class="as5">
            <div class="as5-inner container">
                <div>
                    <h1>Why Users Love Webqa</h1>
                    <p>Clear insights. Customizable audits. Real impact. Hear what professionals are saying about their experience with Webqa.</p>
                </div>
                <div class="as5-cards-wrapper">
                    <div class="as5-cards">
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/Ellipse-93.svg') }}" alt="Customer testimonial on webqa - 1">
                                <div class="as5-card-img-p">
                                    <h6>Matt Diggity</h6>
                                    <p>Owner, DiggityMarketing.com</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Running a site audit with Webqa became part of our weekly routine. The ability to customize checks saved us time and gave us exactly the insights we needed.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/Ellipse-94.svg') }}" alt="Customer testimonial on webqa - 2">
                                <div class="as5-card-img-p">
                                    <h6>Rachel Miller</h6>
                                    <p>Founder, Pagewheel.com</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Webqa helped us uncover technical SEO issues we didn’t even know existed. The level of detail in each report made optimizing our site straightforward and impactful</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/Ellipse-95.svg') }}" alt="Customer testimonial on webqa - 3">
                                <div class="as5-card-img-p">
                                    <h6>Brittany Berger</h6>
                                    <p>Marketing, WorkBrighter.co</p>
                                </div>
                            </div>
                            <p class="as5-card-p">We rely on Webqa before every client site launch. It’s like having a QA team on standby that spots everything—from missing tags to slow pages</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/Ellipse-95.svg') }}" alt="Customer testimonial on webqa - 4">
                                <div class="as5-card-img-p">
                                    <h6>Ryan Robinson</h6>
                                    <p>Blogger & Consultant, RyRob.com</p>
                                </div>
                            </div>
                            <p class="as5-card-p">"Webqa’s customizable audits helped us improve page speed and accessibility without needing multiple tools. Our performance score jumped within a week."</p>
                        </div>
                    </div>
                </div>
                
                <div class="as5-bottom">
                    <div class="as5-bottom1">
                        <img src="{{ asset('new-assets/assets/images/aboutUs/left-arrow.svg') }}" alt="Left arrow icon">
                    </div>
                    <div class="as5-bottom2">
                        <img src="{{ asset('new-assets/assets/images/aboutUs/right-arrow.svg') }}" alt="Right arrow icon">
                    </div>
                </div>
            </div>
         </section>
         <!-- Section 5 endss -->
        

        <!-- Section 6 starts -->
         @include('components.imran-components.as6')
        <!-- Section 6 ends -->

<!-- Contact us form section starts -->
<style>
  /* Hide placeholder text on focus */
  .contact-us-form input::placeholder,
  .contact-us-form textarea::placeholder {
    transition: color 0.15s ease;
  }
  .contact-us-form input:focus::placeholder,
  .contact-us-form textarea:focus::placeholder {
    color: transparent;
  }
</style>

<div class="contact-us-about-page" style="margin-top:160px;margin-bottom:160px;">
  <h1 class="as6-h" style="text-align:center;">Contact us</h1>
  <div class="contact-us-byline" style="text-align: center;margin-top: 80px;font-size: 20px;">
    Please use the contact form below if you have any questions or if you need any assistance.
  </div>

  <div class="contact-us-form" style="width: 550px;margin: 0 auto;padding-top: 50px;">
    <form action="/contact" method="post">
      <div class="name" style="margin-bottom: 15px;">
        <label for="name" style="margin-right: 50px;">Name</label>
        <input
          type="text"
          style="width:350px;border: 2px solid #EEE;padding: 5px;border-radius: 4px;"
          id="name"
          name="name"
          placeholder="Your name"
          autocomplete="name"
          required
        />
      </div>

      <div class="email" style="margin-bottom: 15px;">
        <label style="margin-right: 53px;" for="email">Email</label>
        <input
          type="email"
          style="width:350px;border: 2px solid #EEE;padding: 5px;border-radius: 4px;"
          id="email"
          name="email"
          placeholder="Your email"
          autocomplete="email"
          required
        />
      </div>

      <div class="subject" style="margin-bottom: 15px;">
        <label style="margin-right: 37px;" for="subject">Subject</label>
        <input
          type="text"
          style="width:350px;border: 2px solid #EEE;padding: 5px;border-radius: 4px;"
          id="subject"
          name="subject"
          placeholder="Subject"
        />
      </div>

      <div class="message" style="margin-bottom: 15px; position: relative;">
        <label for="message" style="margin-right: 28px; display:flex; position:absolute;">Message</label>
        <textarea
          style="width:350px;height:200px;border: 2px solid #EEE;padding: 5px;border-radius: 4px;margin-left:95px;"
          id="message"
          name="message"
          rows="5"
          placeholder="Write your message..."
          required
        ></textarea>
      </div>

      <div class="submit_button" style="margin-left: 38%;margin-top: 50px;">
        <button type="submit" style="background-color: var(--primary);color: var(--white);text-decoration: none;font-weight: 500;border: 1px solid var(--primary);padding: 7px;width: 125px;border-radius: 4px;">
          Submit
        </button>
      </div>
    
    <div role="alert" class="alert webqa__alert alert-custom alert-dismissible fade show" style="margin-top:50px;text-align:center;">Your message has been sent. You will hear from us shortly
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
    </form>
  </div>
</div>


<!-- Contact us form section ends -->



         @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
@endsection
@endsection