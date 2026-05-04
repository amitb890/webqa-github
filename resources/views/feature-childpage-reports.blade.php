@extends('layouts.master', ['headerPadding' => 'fcpr'])

@section('title', 'Share Clear Audit Findings With Reports | Webqa')
@section('meta-description', 'Turn audits into action with per-metric reports. Open from the dashboard, review issues line by line, and export PDF/CSV/XLSX for fast hand-offs.')
@section('canonical', 'https://webqa.co/features/reports')
@section('og-title', 'Share Actionable Audit Findings with Website Reports | Webqa')
@section('og-description', 'Website Reports turns audit data into clear tables—titles, speed, canonicals, and more. Jump in from widgets and export PDF/CSV/XLSX for streamlined hand-offs.')
@section('og-url', 'https://webqa.co/features/reports')
@section('og-image', 'https://webqa.co/new-assets/assets/images/og/features-reports.png')
@section('og-image-alt', 'Website reports')

@section("content")

<!-- Section 1 Starts -->
<section class="fcr1">
  <div class="fcr1-d1">
    <h1 class="fcr1-d1-h">
      Generate Clear Website Reports in Minutes
    </h1>
    <p class="fcr1-d1-p">
      Create detailed reports for SEO, performance, best practices, and security - all from a single dashboard. Share insights, spot issues, and take action fast.
    </p>
    <div>
      <button class="fr1-d1-button" id="fr1-d1-button" data-bs-toggle="modal" data-bs-target="#registerModal">
        <p>Sign up Free</p>
      </button>
    </div>
  </div>
  <div class="fcr1-d2" style="flex: 3;">
    <!-- HERO IMAGE UPDATED -->
    <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/reports-hero.png') }}" alt="">
  </div>
</section>
<!-- Section 1 Ends -->


<!-- Section 2 Starts -->
<section class="fcr2">
  <div class="fcr2-inner">
    <div class="fcr2-d1">
      <h1>SEO Reports - Validate SEO signals across every page</h1>
      <p>
        Spot what’s limiting search visibility in minutes. Get structured reports for metadata, indexation, canonicals, headings, status codes, and sitemaps - ready to share.
      </p>
    </div>

    <div class="fcr2-d2">
      <div class="fcr2-d2-1">
        <div class="fcr2-carousel" data-carousel aria-label="SEO report images">
          <div class="fcr2-track">
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/seo-report-1.png') }}" alt="SEO report image 1">
            </div>
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/seo-report-2.png') }}" alt="SEO report image 2">
            </div>
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/seo-report-3.png') }}" alt="SEO report image 3">
            </div>
          </div>
        </div>
      </div>

      <div class="fcr2-d2-2">
        <h3>SEO Signals & Indexability Reports</h3>
        <ol class="fcr2-d2-2-ol">
          <li class="fcr2-d2-2-li"><p><b>Metadata checks</b>: meta titles, meta descriptions, URL slugs, and missing/duplicate fields</p></li>
          <li class="fcr2-d2-2-li"><p><b>Indexation signals</b>: canonical tags, robots meta directives (index/noindex, follow/nofollow), and crawl guidance.</p></li>
          <li class="fcr2-d2-2-li"><p><b>Technical health</b>: HTTP status codes, redirects, broken pages, and inconsistent URLs.</p></li>
          <li class="fcr2-d2-2-li"><p><b>Structure and coverage</b>: heading hierarchy (H1–H6), XML sitemap availability, and sitemap URL coverage.</p></li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Section 2 Ends -->


<!-- Section 3 Starts -->
<section class="fcr3">
  <div class="fcr3-inner">
    <div class="fcr3-d1">
      <div class="fcr3-d1-d1">
        <h1>Performance Reports - Diagnose website speed issues</h1>
      </div>
      <p>
        Generate performance reports that pinpoint slow pages, heavy assets, and rendering bottlenecks - so you can prioritize fixes that improve user experience and rankings.
      </p>
    </div>

    <div class="fcr3-d2">
      <div class="fcr3-d2-1">
        <div class="fcr2-carousel" data-carousel aria-label="Performance report images">
          <div class="fcr2-track">
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/performance-report-1.png') }}" alt="Performance report image 1">
            </div>
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/performance-report-2.png') }}" alt="Performance report image 2">
            </div>
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/performance-report-3.png') }}" alt="Performance report image 3">
            </div>
          </div>
        </div>
      </div>

      <div class="fcr3-d2-2">
        <h3>Find What’s Slowing Your Website Pages</h3>
        <ol class="fcr3-d2-2-ol">
          <li class="fcr3-d2-2-li"><p><b>Core Web Vitals</b>: LCP, CLS, INP (and supporting lab metrics) across pages and templates.</p></li>
          <li class="fcr3-d2-2-li"><p><b>Loading & server signals</b>: TTFB, redirects, caching opportunities, and compression gaps.</p></li>
          <li class="fcr3-d2-2-li"><p><b>Asset & page weight</b>: large images, heavy scripts, unused CSS/JS, and third-party impact.</p></li>
          <li class="fcr3-d2-2-li"><p><b>Prioritized fixes</b>: page-level issues grouped by severity, with exports for dev hand-offs.</p></li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Section 3 Ends -->


<!-- Section 4 Starts -->
<section class="fcr2">
  <div class="fcr2-inner">
    <div class="fcr2-d1">
      <h1>Best Practices Reports - Validate modern web standards</h1>
      <p>Generate reports that surface quality and standards issues affecting usability, accessibility, and long-term website health.
Identify outdated patterns, structural problems, and risky implementations—organized for fast fixes.
      </p>
    </div>

    <div class="fcr2-d2">
      <div class="fcr2-d2-1">
        <div class="fcr2-carousel" data-carousel aria-label="Best practices report images">
          <div class="fcr2-track">
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/best-practices-report-1.png') }}" alt="Best practices report image 1">
            </div>
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/best-practices-report-2.png') }}" alt="Best practices report image 2">
            </div>
          </div>
        </div>
      </div>

      <div class="fcr2-d2-2">
        <h3>Meta Description Reports</h3>
        <ol class="fcr2-d2-2-ol">
          <li class="fcr2-d2-2-li"><p><b>HTML & markup quality</b>: invalid tags, broken structure, duplicate IDs, and deprecated elements.</p></li>
          <li class="fcr2-d2-2-li"><p><b>Accessibility basics</b>: missing alt attributes, improper labels, contrast issues, and semantic gaps.</p></li>
          <li class="fcr2-d2-2-li"><p><b>Linking & resource hygiene</b>: broken links, mixed content, insecure resources, and inefficient loading patterns.</p></li>
          <li class="fcr2-d2-2-li"><p><b>Modern web standards</b>: responsive best practices, viewport configuration, and compatibility checks.</p></li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Section 4 Ends -->


<!-- Section 5 Starts -->
<section class="fcr3">
  <div class="fcr3-inner">
    <div class="fcr3-d1">
      <h1>Security Reports - Identify risks and protect your website</h1>
      <p>
        Generate clear security reports to uncover vulnerabilities, misconfigurations, and risky exposures.
Understand where your site may be at risk and what needs attention - without digging through raw data.
      </p>
    </div>

    <div class="fcr3-d2">
      <div class="fcr3-d2-1">
        <div class="fcr2-carousel" data-carousel aria-label="Security report images">
          <div class="fcr2-track">
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/security-report-1.png') }}" alt="Security report image 1">
            </div>
            <div class="fcr2-slide">
              <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/security-report-2.png') }}" alt="Security report image 2">
            </div>
          </div>
        </div>
      </div>

      <div class="fcr3-d2-2">
        <h3>Security Signals & Exposure Reports</h3>
        <ol class="fcr3-d2-2-ol">
          <li class="fcr3-d2-2-li"><p><b>Protocol & encryption checks</b>: HTTPS usage, mixed content, insecure requests, and certificate issues.</p></li>
          <li class="fcr3-d2-2-li"><p><b>Header & policy validation</b>: security headers, content security policy (CSP), and misconfigurations.</p></li>
          <li class="fcr3-d2-2-li"><p><b>Exposure risks</b>: open directories, unsafe forms, third-party scripts, and sensitive data leaks.</p></li>
          <li class="fcr3-d2-2-li"><p><b>Response & access signals</b>: HTTP status anomalies, error exposure, and access control indicators.</p></li>
        </ol>
      </div>
    </div>
  </div>
</section>
<!-- Section 5 Ends -->


<!-- Section 6 Starts -->
<section class="fcr6">
      <div class="fcr6-d1">
        <h1>Reports that keep every team aligned</h1>
        <p>Marketing analysts, web developers, project managers, and website owners all need the same thing: clear answers and fast next steps. WebQA Reports turns audits into structured, shareable findings - so each team can review what matters to them and move work forward without back-and-forth.</p>
      </div>
      <div class="fcr6-d2">
        <div class="fcr6-d2-card">
          <div class="frc6-card-div">
            <i class="fa-solid fa-chevron-left" style="color: #417cec; font-size: 13px;"></i>
            <i class="fa-solid fa-chevron-right" style="color: #417cec; font-size: 13px;"></i>
          </div>
          <h6>
            Marketing ready insights for SEO and content teams
          </h6>
          <p>Quickly review titles, meta descriptions, canonicals, indexation signals, headings, and sitemap coverage in clear tables. Spot patterns by page type, identify what’s blocking visibility, and export clean data for analysis, content planning, or stakeholder updates.</p>
        </div>
        <div class="fcr6-d2-card">
          <div class="frc6-card-div">
            <i class="fa-solid fa-chevron-left" style="color: #417cec; font-size: 13px;"></i>
            <i class="fa-solid fa-chevron-right" style="color: #417cec; font-size: 13px;"></i>
          </div>
          <h6>
            Developer friendly detail for faster fixes
          </h6>
          <p>Give engineers precise, page - level findings across performance, best practices, and security - Core Web Vitals, status codes, redirects, markup issues, mixed content, and more. No guessing, no screenshots - just a clear list of what’s failing and where.</p>
        </div>
        <div class="fcr6-d2-card">
          <div class="frc6-card-div">
            <i class="fa-solid fa-chevron-left" style="color: #417cec; font-size: 13px;"></i>
            <i class="fa-solid fa-chevron-right" style="color: #417cec; font-size: 13px;"></i>
          </div>
          <h6>Project managers get clean handoffs and clear priorities</h6>
          <p>Turn audits into action lists. Reports help you group issues, track what’s most urgent, and assign work across teams with less triage. Share exports or direct report links to keep delivery moving and reduce review cycles.</p>
        </div>
        <div class="fcr6-d2-card">
          <div class="frc6-card-div">
            <i class="fa-solid fa-chevron-left" style="color: #417cec;font-size: 13px;"></i>
            <i class="fa-solid fa-chevron-right" style="color: #417cec;font-size: 13px;"></i>
          </div>
          <h6>Stakeholders get clarity without the complexity</h6>
          <p>Understand the health of your site at a glance - what’s working, what needs attention, and what to fix next. Use ready to share reports to align everyone, confirm improvements after changes, and keep quality high as your site grows.</p>
        </div>
      </div>
    </section>
<!-- Section 6 Ends -->


<!-- Section 7 Starts -->
{{-- has margin-top: 150px; and margin-bottom: 150px; --}}
@include('components.imran-components.fcr7')
<!-- Section 7 Ends -->


<!-- Last Section Starts -->
<section class="fr4 section-margin">
  <div class="fr4-inner">
    <div class="fr4-d1">
      <h3>Improve Your Website's Performance with Actionable Reports</h3>
      <p>Generate SEO, performance, best practices, and security reports in minutes—then share fixes with your team and move faster.</p>
      <div>
        <button class="fr4-d1-button" data-bs-toggle="modal" data-bs-target="#registerModal">
          Sign Up Free
        </button>
      </div>
    </div>
    <div class="fr4-d2" id="fr4-d2-reports">
      <img class="zoomable-img" src="{{ asset('new-assets/assets/images/feature-childpage-reports/image-71-(1).svg') }}" alt="">
    </div>
  </div>
</section>
<!-- Last Section Ends -->

<div id="imagePreviewOverlay">
  <span class="image-preview-close">&times;</span>
  <img id="imagePreviewContent" src="" alt="Preview">
</div>

<!-- ===================== -->
<!-- CSS + JS AT PAGE END  -->
<!-- ===================== -->

<style>
  /* Keep image column wide and stable for .fcr2 sections */
  .fcr2-d2{
    display: flex;
    align-items: flex-start;
    gap: 24px;
  }
  .fcr2-d2-1{
    flex: 0 0 clamp(320px, 52%, 680px);
    max-width: 680px;
  }
  .fcr2-d2-2{
    flex: 1 1 auto;
    min-width: 0;
  }

  /* Apply same width rules to .fcr3 sections as well */
  .fcr3-d2{
    display: flex;
    align-items: flex-start;
    gap: 24px;
  }
  .fcr3-d2-1{
    flex: 0 0 clamp(320px, 52%, 680px);
    max-width: 680px;
  }
  .fcr3-d2-2{
    flex: 1 1 auto;
    min-width: 0;
  }

  /* Shared horizontal slider */
  .fcr2-carousel{
    position: relative;
    overflow: hidden;
    width: 100%;
    border-radius: 12px;
  }
  .fcr2-track{
    display: flex;
    will-change: transform;
    transition: transform 600ms ease;
  }
  .fcr2-slide{
    flex: 0 0 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    height: clamp(260px, 30vw, 480px);
  }
  .fcr2-slide img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    display: block;
    max-width: 100%;
  }

  /* Stack on smaller screens */
  @media (max-width: 992px){
    .fcr2-d2, .fcr3-d2{
      flex-direction: column;
    }
    .fcr2-d2-1, .fcr3-d2-1{
      flex: 0 0 auto;
      max-width: 100%;
    }
    .fcr2-slide{
      height: clamp(220px, 55vw, 420px);
    }
  }

  @media (prefers-reduced-motion: reduce){
    .fcr2-track{ transition: none; }
  }
  

  /* --- Hero image sizing (Section 1) --- */
  .fcr1-d2 img{
    width: 100%;
    height: auto;
    max-width: 1120px;   /* ~2x of 560px */
    max-height: 840px;   /* ~2x of 420px */
    object-fit: contain;
    display: block;
    margin-left: auto;
  }

  /* Medium screens */
  @media (max-width: 1200px){
    .fcr1-d2 img{
      max-width: 960px;  /* ~2x of 480px */
      max-height: 720px; /* ~2x of 360px */
    }
  }

  /* Mobile */
  @media (max-width: 992px){
    .fcr1-d2 img{
      max-width: 100%;
      max-height: 640px; /* ~2x of 320px */
      margin: 0 auto;
    }
  }


</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const carousels = Array.from(document.querySelectorAll("[data-carousel]"));
    if (!carousels.length) return;

    carousels.forEach((root) => {
      const track = root.querySelector(".fcr2-track");
      const slides = Array.from(root.querySelectorAll(".fcr2-slide"));
      if (!track || slides.length < 2) return;

      // Avoid double-init
      if (root.dataset.inited === "1") return;
      root.dataset.inited = "1";

      // Clone first slide to end for seamless loop
      const firstClone = slides[0].cloneNode(true);
      track.appendChild(firstClone);

      let index = 0;
      const total = slides.length;     // original slide count (before clone)
      const intervalMs = 5000;

      function goTo(i, animate = true) {
        track.style.transition = animate ? "transform 600ms ease" : "none";
        track.style.transform = `translateX(-${i * 100}%)`;
      }

      goTo(0, false);

      setInterval(() => {
        index += 1;
        if (index <= total) {
          goTo(index, true);
        } else {
          index = 1;
          goTo(0, false);
          requestAnimationFrame(() => {
            goTo(index, true);
          });
        }
      }, intervalMs);


      track.addEventListener("transitionend", () => {
        if (index === total) {
          index = 0;
          goTo(index, false);
        }
      });
    });
  });
</script>

@section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
@endsection

@endsection
