@extends('layouts.master', ['headerPadding' => 'aup'])

@section('title', 'About us | Webqa')
@section('meta-description', 'Webqa simplifies website audits with your standards—custom checks, pass/fail clarity, shareable analysis, and a website tracker for faster fixes.')
@section('canonical', 'https://webqa.co/aboutus')
@section('og-title', 'About Webqa — Smarter Website Auditing')
@section('og-description', 'Discover how Webqa turns audits into action with your standards, clear results, shareable analyses, and site-wide tracking to prioritize fixes.')
@section('og-url', 'https://webqa.co/aboutus')
@section('og-image', 'https://webqa.co/new-assets/assets/images/meta-tags/open-graph-image.png')
@section('og-image-alt', 'About Webqa')

@section('css')
<link rel="stylesheet" href="{{ asset('new-assets/css/about-page.css') }}{{ \App\Http\Helpers::getCacheBuster() }}">
@endsection

@section("content")
<div class="about-page">
        <!--Section 1 starts -->
        <section class="as1">
                <div class="as1-left">
                    <img class="as1-left-img1" width="560" height="560" src="{{ asset('new-assets/assets/images/aboutUs/hero-left.png') }}" alt="SEO professional">
                    <img class="as1-left-img2" width="72" height="72" src="{{ asset('new-assets/assets/images/aboutUs/hero-badge-left.png') }}" alt="">
                </div>
                <div class="as1-center">
                    <h1 class="as1-center-h1">We bring <span class="as1-accent">control</span> to website audits.</h1>
                    <p class="as1-center-p">Modern teams shape higher quality websites with audits that adapt to their standards, not the other way around.</p>
                </div>
                <div class="as1-right">
                    <img class="as1-right-img2" width="72" height="72" src="{{ asset('new-assets/assets/images/aboutUs/hero-badge-right.png') }}" alt="">
                    <img class="as1-right-img1" width="560" height="520" src="{{ asset('new-assets/assets/images/aboutUs/hero-right.png') }}" alt="Audit specialist">
                </div>
        </section>
        <!-- Section 1 ends -->

        <!-- Section 2 starts -->
        <section class="as2" aria-labelledby="about-webqa-heading">
            <div class="as2-inner">
                <div class="as2-head">
                    <h2 id="about-webqa-heading">About Webqa</h2>
                    <p>Webqa is a website auditing and testing platform. We help teams understand, improve, and maintain the quality of their websites across SEO, performance, security, and web development best practices.</p>
                </div>

                <div class="as2-columns">
                    <div class="as2-col">
                        <p class="as2-lead">Auditing a website properly is getting harder - not because there aren’t enough tools, but because none of them let you truly define your own standards.</p>
                        <p>Most website auditors lock you into their rules, apply the same checks to every website, and leave you stitching together results from multiple sources just to get a complete picture.</p>
                    </div>
                    <div class="as2-col">
                        <p class="as2-turn">Webqa exists to change that.</p>
                        <p>It’s built for teams who care about doing audits the right way for their context. You decide what “good” looks like and align the checks to match, instead of settling for generic, one-size-fits-all reports. By bringing everything into one place and letting you shape how audits work from project to project, Webqa turns website QA from an exhausting chore into a repeatable, standards-driven practice.</p>
                    </div>
                </div>

                <div class="as2-principles">
                    <article class="as2-principle">
                        <div class="as2-principle-icon">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/mission.png') }}" width="176" height="272" alt="">
                        </div>
                        <div class="as2-principle-copy">
                            <h3>Our Mission</h3>
                            <p class="as2-principle-lead">Our mission is to make website auditing calm, consistent and standards driven.</p>
                            <p>You shouldn’t need ten different tools, conflicting rules, or scattered spreadsheets to test a single page. With Webqa, teams define what “good” looks like once, audit against those standards, and align around a single source of truth.</p>
                        </div>
                    </article>
                    <article class="as2-principle">
                        <div class="as2-principle-icon">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/vision.png') }}" width="176" height="176" alt="">
                        </div>
                        <div class="as2-principle-copy">
                            <h3>Our Vision</h3>
                            <p>A web where quality is measurable and consistent - where you are empowered to define standards, audit with confidence, and fix what matters without friction.</p>
                        </div>
                    </article>
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
                        <img src="{{ asset('new-assets/assets/images/aboutUs/icons/audit.png') }}" width="44" height="44" alt="">
                    </div>
                    <h4 class="as3-down-one-h">Webpage Audit</h4>
                    <p class="as3-down-one-p">Analyze a page against your standards and instantly share or export findings to prioritize SEO, performance, and quality fixes.</p>
                    <button class="as3-down-buton" type="button" onclick="window.open('{{ url('/features/webpage-audit') }}', '_blank', 'noopener,noreferrer')">Learn more</button>

                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                           <img src="{{ asset('new-assets/assets/images/aboutUs/icons/tracker.png') }}" width="44" height="44" alt="">
                    </div>
                    <h4 class="as3-down-two-h">Website Tracker</h4>
                    <p class="as3-down-two-p">See every metric for every URL in one big, filterable table - perfect for spotting patterns across templates and catching regressions early.</p>
                    <button class="as3-down-buton" type="button" onclick="window.open('{{ url('/features/website-tracker') }}', '_blank', 'noopener,noreferrer')">Learn more</button>
                   

                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img src="{{ asset('new-assets/assets/images/aboutUs/icons/reports.png') }}" width="44" height="44" alt="">
                    </div>
                    <h4 class="as3-down-three-h">Reports</h4>
                    <p class="as3-down-three-p">Drill into tabular, per-metric reports (titles, descriptions, canonicals, speed etc) for fast triage and fixes.</p>
                    <button class="as3-down-buton" type="button" onclick="window.open('{{ url('/features/reports') }}', '_blank', 'noopener,noreferrer')">Learn more</button>
                    

                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img src="{{ asset('new-assets/assets/images/aboutUs/icons/settings.png') }}" width="44" height="44" alt="">
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
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/icons/http.png') }}" width="44" height="44" alt="">
                        </div>
                        <h4>HTTP Status Code</h4>
                        <p>Check live response codes for single pages or bulk URL lists, then fix redirects, 4xx/5xxs, and other crawl issues before they hurt your website's SEO.</p>
                    </div>
                    </a>
                    <a target="_blank" href="{{ url('/tool/meta-title') }}">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/icons/title.png') }}" width="44" height="44" alt="">
                        </div>
                        <h4>Meta Title</h4>
                        <p>Keep page titles consistent and in shape: set your preferred length and casing, ensure they differ from H1s, and get a clear pass/fail for every page.</p>
                    </div>
                    </a>
                    <a target="_blank" href="{{ url('/tool/google-core-web-vitals') }}">
                    
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/icons/vitals.png') }}" width="44" height="44" alt="">
                        </div>
                        <h4>Core Web Vitals</h4>
                        <p>Measure core web vitals metrics (LCP, CLS, INP) to find what’s slowing your pages down, then focus on the fixes that improve UX and performance.</p>
                    </div>
                    </a>
                    <a target="_blank" href="{{ url('/tool/broken-links') }}">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/icons/links.png') }}" width="44" height="44" alt="">
                        </div>
                        <h4>Broken Links</h4>
                        <p>Check any page for broken links in seconds. Find 404s and dead internal or external links before they hurt your users and SEO.</p>
                    </div>
                    </a>
                   <a target="_blank" href="{{ url('/tool/robotstxt') }}">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/icons/robots.png') }}" width="44" height="44" alt="">
                        </div>
                        <h4>Robots.txt</h4>
                        <p>Validate crawl directives and catch disallow rules before they block pages from indexing. Great for website migrations and template changes.</p>
                    </div>
                    </a>
                    <a target="_blank" href="{{ url('/tool/images') }}">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/icons/images.png') }}" width="44" height="44" alt="">
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
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-8.png') }}" width="56" height="56" alt="Nigel Tan">
                                <div class="as5-card-img-p">
                                    <h6>Nigel Tan</h6>
                                    <p>Marketing, NovaTrade</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Running a website audit with Webqa has become part of our weekly routine. The ability to customize checks saved us time and gave us exactly the insights we needed.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-2.jpeg') }}" width="56" height="56" alt="Riya Salgaonkar">
                                <div class="as5-card-img-p">
                                    <h6>Riya Salgaonkar</h6>
                                    <p>Project Manager, Sealink Capital</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Having all our SEO, performance, and technical checks in one place finally replaced the messy stack of tools we used before. Everything we need is under one roof and far easier to manage.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-4.png') }}" width="56" height="56" alt="Edward Clarke">
                                <div class="as5-card-img-p">
                                    <h6>Edward Clarke</h6>
                                    <p>Software Engineer, Autodesk</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Customisable audits helped us improve page speed and accessibility without needing multiple tools. It gave our team a clear, focused list of fixes we could act on immediately.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-5.png') }}" width="56" height="56" alt="Miguel Perez">
                                <div class="as5-card-img-p">
                                    <h6>Miguel Perez</h6>
                                    <p>Product Manager, TestGorilla</p>
                                </div>
                            </div>
                            <p class="as5-card-p">During our website migration, Webqa became essential. It highlighted redirect gaps, missing metadata, and structural issues early—saving us from post launch surprises.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-3.jpeg') }}" width="56" height="56" alt="Arun Mohan">
                                <div class="as5-card-img-p">
                                    <h6>Arun Mohan</h6>
                                    <p>Developer, Redian Software</p>
                                </div>
                            </div>
                            <p class="as5-card-p">We rely on Webqa before every client site launch. It’s like having a QA team on standby that spots everything, from missing tags to slow pages.</p>
                        </div>
                        
                        
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-6.png') }}" width="56" height="56" alt="Hadia Saeed">
                                <div class="as5-card-img-p">
                                    <h6>Hadia Saeed</h6>
                                    <p>SEO Manager, Clicktap Digital</p>
                                </div>
                            </div>
                            <p class="as5-card-p">Managing audits for multiple client sites used to be chaotic. With Webqa’s project setup and consistent checks, we can run technical audits at scale without losing accuracy.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-7.png') }}" width="56" height="56" alt="Claire Wang">
                                <div class="as5-card-img-p">
                                    <h6>Claire Wang</h6>
                                    <p>Marketing, Nytelock Digital</p>
                                </div>
                            </div>
                            <p class="as5-card-p">The ability to download clean PDF and XLSX reports has been a game changer. Sharing findings with clients and internal teams is faster and far more organised.</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/t-1.jpeg') }}" width="56" height="56" alt="Neo Ramatla">
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
                    <button type="button" class="as5-bottom1" aria-label="Previous testimonials">
                        <span class="as5-arrow as5-arrow-left"></span>
                    </button>
                    <button type="button" class="as5-bottom2" aria-label="Next testimonials">
                        <span class="as5-arrow as5-arrow-right"></span>
                    </button>
                </div>
            </div>
         </section>
         <!-- Section 5 endss -->
        

        <!-- Section 6 starts -->
         @include('components.imran-components.as6')
        <!-- Section 6 ends -->

<section class="about-contact" id="contact">
  <div class="about-contact-card">
    <h2>Contact us</h2>
    <p class="about-contact-byline">Please use the contact form below if you have any questions or if you need any assistance.</p>

    @if(session('contact_success'))
      <div id="about-contact-status" class="about-form-success" role="status" tabindex="-1">
        Your message has been sent. You will hear from us shortly.
      </div>
    @endif
    @if(session('contact_error'))
      <div id="about-contact-status" class="about-form-error" role="alert" tabindex="-1">
        {{ session('contact_error') }}
      </div>
    @endif

    <form id="about-contact-form" action="{{ route('contact.store') }}" method="post" novalidate>
      @csrf
      <input type="hidden" name="about_contact" value="1">

      <div class="about-field {{ $errors->has('name') ? 'is-invalid' : '' }}">
        <label for="name">Name <span>Optional</span></label>
        <input type="text" id="name" name="name" placeholder="Your name" autocomplete="name" maxlength="100" value="{{ old('name') }}">
        <p class="about-field-error" id="name-error">@error('name'){{ $message }}@enderror</p>
      </div>

      <div class="about-field {{ $errors->has('email') ? 'is-invalid' : '' }}">
        <label for="email">Email <span class="is-required">Required</span></label>
        <input type="email" id="email" name="email" placeholder="you@company.com" autocomplete="email" maxlength="255" value="{{ old('email') }}" aria-describedby="email-error">
        <p class="about-field-error" id="email-error">@error('email'){{ $message }}@enderror</p>
      </div>

      <div class="about-field {{ $errors->has('subject') ? 'is-invalid' : '' }}">
        <label for="subject">Subject <span>Optional</span></label>
        <input type="text" id="subject" name="subject" placeholder="What is this about?" autocomplete="off" maxlength="200" value="{{ old('subject') }}">
        <p class="about-field-error" id="subject-error">@error('subject'){{ $message }}@enderror</p>
      </div>

      <div class="about-field {{ $errors->has('message') ? 'is-invalid' : '' }}">
        <label for="message">Message <span class="is-required">Required</span></label>
        <textarea id="message" name="message" rows="6" maxlength="5000" placeholder="How can we help?" aria-describedby="message-error">{{ old('message') }}</textarea>
        <p class="about-field-error" id="message-error">@error('message'){{ $message }}@enderror</p>
      </div>

      <button class="about-submit" type="submit">Send message</button>
    </form>
  </div>
</section>
</div>

         @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
<script>
(function () {
  var form = document.getElementById("about-contact-form");
  var status = document.getElementById("about-contact-status");
  if (status) {
    status.focus({ preventScroll: true });
    status.scrollIntoView({ behavior: "smooth", block: "center" });
  }
  if (!form) return;

  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
  var namePattern = /^[\p{L}][\p{L}\s.'’-]{0,99}$/u;

  function validate(input) {
    var field = input.closest(".about-field");
    var error = field.querySelector(".about-field-error");
    var value = input.value.trim();
    var message = "";

    if (input.id === "name") {
      if (value.length > 100) message = "Name must be 100 characters or fewer.";
      else if (value !== "" && !namePattern.test(value)) message = "Use letters, spaces, apostrophes, or hyphens.";
    } else if (input.id === "email") {
      if (value === "") message = "Email is required.";
      else if (!emailPattern.test(value) || value.length > 255) message = "Enter a valid email address.";
    } else if (input.id === "subject") {
      if (value.length > 200) message = "Subject must be 200 characters or fewer.";
    } else if (input.id === "message") {
      if (value === "") message = "Message is required.";
      else if (value.length < 10) message = "Message should be at least 10 characters.";
      else if (value.length > 5000) message = "Message must be 5,000 characters or fewer.";
    }

    error.textContent = message;
    field.classList.toggle("is-invalid", message !== "");
    field.classList.toggle("is-valid", message === "" && value !== "");
    if (message) input.setAttribute("aria-invalid", "true");
    else input.removeAttribute("aria-invalid");
    return message === "";
  }

  Array.prototype.forEach.call(form.querySelectorAll("input, textarea"), function (input) {
    if (input.type === "hidden") return;
    input.addEventListener("blur", function () {
      input.dataset.touched = "1";
      validate(input);
    });
    input.addEventListener("input", function () {
      if (input.dataset.touched === "1" || input.value.trim() !== "") {
        input.dataset.touched = "1";
        validate(input);
      }
    });
  });

  form.addEventListener("submit", function (event) {
    var ok = true;
    var firstInvalid = null;
    Array.prototype.forEach.call(form.querySelectorAll("input, textarea"), function (input) {
      if (input.type === "hidden") return;
      input.dataset.touched = "1";
      if (!validate(input)) {
        ok = false;
        if (!firstInvalid) firstInvalid = input;
      }
    });
    if (!ok) {
      event.preventDefault();
      if (firstInvalid) firstInvalid.focus();
    }
  });
})();
</script>
@endsection
@endsection