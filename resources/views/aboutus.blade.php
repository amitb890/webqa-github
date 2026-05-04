@extends('layouts.master', ['headerPadding' => 'aup'])

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
                    <h1 class="as1-center-h1">We bring <span style="color: #417cec;">control</span> to website audits.</h1>
                    <p class="as1-center-p">Modern teams shape higher quality websites with audits that adapt to their standards, not the other way around.</p>
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
                        <p class="as2-dtop-left-p">Webqa is a website auditing and testing platform. <br><br>We help teams understand, improve, and maintain the quality of their websites across SEO, performance, security, and web development best practices.</p>
                    </div>
                    <div class="as2-dtop-right">
                        <p class="as2-dtop-right-p1">
                            Auditing a website properly is getting harder - not because there aren’t enough tools, but because none of them let you truly define your own standards.
                        </p>
                        <p class="as2-dtop-right-p2">Most website auditors lock you into their rules, apply the same checks to every website, and leave you stitching together results from multiple sources just to get a complete picture.<br><br>Webqa exists to change that.<br><br>It’s built for teams who care about doing audits the right way for their context. You decide what “good” looks like and align the checks to match, instead of settling for generic, one-size-fits-all reports. By bringing everything into one place and letting you shape how audits work from project to project, Webqa turns website QA from an exhausting chore into a repeatable, standards-driven practice.</p>
                    </div>
                    <div class="as2-line1"></div>
                </div>
                <div class="as2-dmid">
                    <div class="as2-dmid-img">
                        <img  src="{{ asset('new-assets/assets/images/aboutUs/Layer-2.svg') }}" alt="Webqa mission">
                    </div>
                    <div class="as2-dmid-right">
                        <h2 class="as2-dmid-right-h" style="color: #fff;">Our Mission</h2>
                        <p class="as2-dmid-right-p">Our mission is to make website auditing calm, consistent and standards driven.<br><br>You shouldn’t need ten different tools, conflicting rules, or scattered spreadsheets to test a single page. With Webqa, teams define what “good” looks like once, audit against those standards, and align around a single source of truth.
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
                            A web where quality is measurable and consistent - where you are empowered to define standards, audit with confidence, and fix what matters without friction.
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
                    <button class="as3-down-buton" type="button" onclick="window.open('{{ url('/features/webpage-audit') }}', '_blank', 'noopener,noreferrer')">Learn more</button>

                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon2">
                           <img class="as3-down-two-img-div1" src="{{ asset('new-assets/assets/images/aboutUs/Vector.svg') }}" alt="website tracker icon 1">
                           <img class="as3-down-two-img-div2" src="{{ asset('new-assets/assets/images/aboutUs/Vector-(1).svg') }}" alt="website tracker icon 2"> 
                    </div>
                    <h4 class="as3-down-two-h">Website Tracker</h4>
                    <p class="as3-down-two-p">See every metric for every URL in one big, filterable table - perfect for spotting patterns across templates and catching regressions early.</p>
                    <button class="as3-down-buton" type="button" onclick="window.open('{{ url('/features/website-tracker') }}', '_blank', 'noopener,noreferrer')">Learn more</button>
                   

                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img class="as3-down-three-img2" src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(2).svg') }}" alt="reports icon">
                    </div>
                    <h4 class="as3-down-three-h">Reports</h4>
                    <p class="as3-down-three-p">Drill into tabular, per-metric reports (titles, descriptions, canonicals, speed etc) for fast triage and fixes.</p>
                    <button class="as3-down-buton" type="button" onclick="window.open('{{ url('/features/reports') }}', '_blank', 'noopener,noreferrer')">Learn more</button>
                    

                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img class="as3-down-four-img2" src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(3).svg') }}" alt="settings icon">
                    </div>
                    <h4 class="as3-down-four-h">Settings</h4>
                    <p class="as3-down-four-p">Define project level rules that defines acceptance criteria for each test. Help teams align on exactly what “good” looks like.</p>
                    <button class="as3-down-buton" type="button" onclick="window.open('{{ url('/features/settings') }}', '_blank', 'noopener,noreferrer')">Learn more</button>
                </div>
            </div>
         </section>
        <!-- Section 3 ends -->

        <!-- Secton 4 starts -->
         <section class="as4">
            <div class="container as4-inner">
                <div class="as4-topd">
                    <div class="as4-topd-h">
                        <h1>Explore some of our Tools</h1>
                      
                    </div>
                    <p class="as4-topd-p">
                        Your everyday QA, simplified. Run targeted tests, customize acceptance criteria, and turn results into clear fixes for SEO, performance, and accessibility.
                    </p>
                </div>
                <div class="as4-cards">
                    <a target="_blank" href="{{ url('/tool/http-status-code') }}">
                        <div class="as4-card">
                        <div class="as4-card-imgs">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector.svg') }}" alt="http status code checker icon 1">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector-(1).svg') }}" alt="http status code checker icon 2">
                        </div>
                        <h4>HTTP Status Code</h4>
                        <p>Check live response codes for single pages or bulk URL lists, then fix redirects, 4xx/5xxs, and other crawl issues before they hurt your website's SEO.</p>
                    </div>
                    </a>
                    <a target="_blank" href="{{ url('/tool/meta-title') }}">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(1).svg') }}" alt="meta title test icon">
                        </div>
                        <h4>Meta Title</h4>
                        <p>Keep page titles consistent and in shape: set your preferred length and casing, ensure they differ from H1s, and get a clear pass/fail for every page.</p>
                    </div>
                    </a>
                    <a target="_blank" href="{{ url('/tool/google-core-web-vitals') }}">
                    
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(2).svg') }}" alt="core web vitals test icon">
                        </div>
                        <h4>Core Web Vitals</h4>
                        <p>Measure core web vitals metrics (LCP, CLS, INP) to find what’s slowing your pages down, then focus on the fixes that improve UX and performance.</p>
                    </div>
                    </a>
                    <a target="_blank" href="{{ url('/tool/broken-links') }}">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(2).svg') }}" alt="broken link checker icon">
                        </div>
                        <h4>Broken Links</h4>
                        <p>Check any page for broken links in seconds. Find 404s and dead internal or external links before they hurt your users and SEO.</p>
                    </div>
                    </a>
                   <a target="_blank" href="{{ url('/tool/robotstxt') }}">
                        <div class="as4-card">
                        <div class="as4-card-imgs">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector.svg') }}" alt="robotstxt checker icon 1">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector-(1).svg') }}" alt="robotstxt checker icon 2">
                        </div>
                        <h4>Robots.txt</h4>
                        <p>Validate crawl directives and catch disallow rules before they block pages from indexing. Great for website migrations and template changes.</p>
                    </div>
                    </a>
                    <a target="_blank" href="{{ url('/tool/images') }}">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(3).svg') }}" alt="Images checker icon">
                        </div>
                        <h4>Images</h4>
                        <p>Scan any page for image issues: missing or weak alt text and other problems that affect accessibility, relevance, and how fast images feel.</p>
                    </div>
                    </a>
                </div>
                <button class="as4-button" type="button" onclick="window.open('{{ url('/tools') }}', '_blank', 'noopener,noreferrer')">View All Tools</button>

            </div>
         </section>
        <!-- Secton 4 ends -->


        <!-- Section 5 starts -->
         <section class="as5">
            <div class="as5-inner container">
                <div>
                    <h1>Loved by SEOs, developers and Digital Teams</h1>
                    <p>Real stories from professionals and teams sharing the problems they’ve solved and the wins they’re proud of.</p>
                </div>
                <div class="as5-cards-wrapper">
                    <div class="as5-cards">
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-8.png') }}" style="border-radius: 35px;" alt="Customer testimonial on webqa - 1">
                                <div class="as5-card-img-p">
                                    <h6>Nigel Tan</h6>
                                    <p>Marketing, NovaTrade</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Running a website audit with Webqa has become part of our weekly routine. The ability to customize checks saved us time and gave us exactly the insights we needed.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-2.jpeg') }}" style="border-radius: 35px;" alt="Customer testimonial on webqa - 2">
                                <div class="as5-card-img-p">
                                    <h6>Riya Salgaonkar</h6>
                                    <p>Project Manager, Sealink Capital</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Having all our SEO, performance, and technical checks in one place finally replaced the messy stack of tools we used before. Everything we need is under one roof and far easier to manage.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-4.png') }}" style="border-radius: 35px;" alt="Customer testimonial on webqa - 2">
                                <div class="as5-card-img-p">
                                    <h6>Edward Clarke</h6>
                                    <p>Software Engineer, Autodesk</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Customisable audits helped us improve page speed and accessibility without needing multiple tools. It gave our team a clear, focused list of fixes we could act on immediately.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-5.png') }}" style="border-radius: 35px;" alt="Customer testimonial on webqa - 2">
                                <div class="as5-card-img-p">
                                    <h6>Miguel Perez</h6>
                                    <p>Product Manager, TestGorilla</p>
                                </div>
                            </div>
                            <p class="as5-card-p">During our website migration, Webqa became essential. It highlighted redirect gaps, missing metadata, and structural issues early—saving us from post launch surprises.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-3.jpeg') }}" style="border-radius: 35px;" alt="Customer testimonial on webqa - 2">
                                <div class="as5-card-img-p">
                                    <h6>Arun Mohan</h6>
                                    <p>Developer, Redian Software</p>
                                </div>
                            </div>
                            <p class="as5-card-p">We rely on Webqa before every client site launch. It’s like having a QA team on standby that spots everything, from missing tags to slow pages.</p>
                        </div>
                        
                        
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-6.png') }}" style="border-radius: 35px;" alt="Customer testimonial on webqa - 2">
                                <div class="as5-card-img-p">
                                    <h6>Hadia Saeed</h6>
                                    <p>SEO Manager, Clicktap Digital</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Managing audits for multiple client sites used to be chaotic. With Webqa’s project setup and consistent checks, we can run technical audits at scale without losing accuracy.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-7.png') }}" style="border-radius: 35px;" alt="Customer testimonial on webqa - 3">
                                <div class="as5-card-img-p">
                                    <h6>Claire Wang</h6>
                                    <p>Marketing, Nytelock Digital</p>
                                </div>
                            </div>
                            <p class="as5-card-p">The ability to download clean PDF and XLSX reports has been a game changer. Sharing findings with clients and internal teams is faster and far more organised.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-1.jpeg') }}" style="border-radius: 35px;" alt="Customer testimonial on webqa - 4">
                                <div class="as5-card-img-p">
                                    <h6>Neo Ramatla</h6>
                                    <p>Consultant, Chilli Media</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Webqa helped us uncover technical SEO issues we didn’t even know existed. The level of detail in each report made optimizing our site straightforward and impactful.</p>
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
    <form action="{{ route('contact.store') }}" method="post">
      @csrf
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
    @if(session('contact_success'))
    <div role="alert" class="alert webqa__alert alert-custom alert-dismissible fade show" style="margin-top:50px;text-align:center;">Your message has been sent. You will hear from us shortly.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('contact_error'))
    <div role="alert" class="alert webqa__alert alert-danger alert-dismissible fade show" style="margin-top:50px;text-align:center;">{{ session('contact_error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    </form>
  </div>
</div>


<!-- Contact us form section ends -->



         @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
@endsection
@endsection