@section('title', 'HSTS Header Tester: Force HTTPS for Secure Browsing | Webqa')
@section('meta-description', 'Check if a page sends the Strict-Transport-Security (HSTS) header to enforce HTTPS and prevent downgrade attacks. Get clear Pass/Fail results and export findings.')
@section('canonical', 'https://webqa.co/tool/hsts-header-test')
@section('og-title', 'Test HSTS (Strict-Transport-Security) Headers | Webqa')
@section('og-description', 'Audit HSTS headers to ensure browsers always use HTTPS for your site, improving security and preventing protocol downgrades. Export results for quick fixes.')
@section('og-url', 'https://webqa.co/tool/hsts-header-test')
@section('og-image', 'https://webqa.co/new-assets/assets/images/meta-tags/open-graph-image.png')
@section('og-image-alt', 'HSTS header test')

<div class="single-post-content-main bulk-tool-test">
  <div class="single-post-content">
    <h2 class="tools_des_fastheading">HSTS Header</h2>

<div class="list yellow-content summary-block">
  <span class="summary-heading">Quick Summary</span>
  <p>An HSTS Header Test checks whether your website sends the "Strict-Transport-Security" header and whether it’s configured properly.</p>
  <ol>
    <li><b>HSTS (HTTP Strict Transport Security)</b> tells browsers to only use HTTPS for the domain for a specified period.</li>
    <li>It helps prevent SSL stripping and downgrade attacks by blocking HTTP access once the policy is cached in the browser.</li>
    <li>A strong policy typically includes "max-age", "includeSubDomains" and "preload".</li>
    <li>Misconfigured HSTS can break subdomains or lock users into HTTPS when your TLS setup isn’t ready.</li>
    <li>This tool helps you confirm your HSTS header exists, is correctly formatted, and whether it follows best practices.</li>
  </ol>
</div>


<h3>What Is HSTS and How Does the Strict Transport Security Header Work?</h3>
<p>HSTS stands for - HTTP Strict Transport Security. It is a browser security mechanism that ensures your website is accessed only over HTTPS.</p>

<p>HSTS is enabled by sending a response header called "Strict-Transport-Security" from your web server that is hosting the website. When a browser receives this header over a secure HTTPS connection, it remembers that your site should never be accessed using HTTP again for a specified period of time.</p>

<p>Once the policy is stored in the browser, the following things will happen:</p>
<ol>
  <li>Any attempt to access the site using "http://"" is automatically upgraded to "https://".</li>
  <li>The browser refuses to make insecure HTTP connections to your domain.</li>
  <li>The risk of SSL stripping and downgrade attacks is significantly reduced.</li>
</ol>

<p>This behavior is especially important because it protects users in the following situations:</p>
<ol>
  <li>They manually type http:// in the address bar to access your website.</li>
  <li>They click on outdated or insecure HTTP links which could be added to other parts of your website or through social media links.</li>
  <li>An attacker attempts to intercept traffic and force an insecure connection.</li>
</ol>

<p>The "Strict Transport Security header" works on a time-based policy. The duration is controlled by the "max-age" directive, which tells the browser how long (in seconds) it should enforce HTTPS-only access. During this period, the browser will not attempt an HTTP connection to your website.</p>

<p>In short, HSTS shifts HTTPS enforcement from the server to the browser itself. This makes HTTPS usage more reliable, consistent, and resistant to network-based attacks especially on public or untrusted networks.</p>


<h3>Key HSTS Directives</h3>
<p>The Strict Transport Security header is made up of directives that control how browsers enforce HTTPS for your domain. The most common directives are max-age, includeSubDomains, and preload.</p>

<h5>max-age</h5>
<p>max-age sets how long in seconds the browser should enforce HTTPS-only access for your website.</p>
<ol>
  <li>max-age=31536000 = 1 year</li>
  <li>max-age=63072000 = 2 years</li>
</ol>
<p>During this time, the browser will automatically upgrade HTTP requests to HTTPS and refuse insecure connections.</p>

<h5> includeSubDomains</h5>
<p>includeSubDomains extends the HSTS rule to all subdomains (for example: blog.example.com, app.example.com).</p>
<p><div class="red-highlight-table"><b>Important:</b> Only enable this if every subdomain you use is HTTPS ready. Otherwise, you can accidentally break services that are running on HTTP.</div></p>

<h5>preload</h5>
<p>preload is an optional directive used when you want to be eligible for the "HSTS preload list" (a list built into many browsers).</p>
<p>If your domain is preloaded, browsers will enforce HTTPS even on the first visit, before they’ve ever seen your header.</p>
<p><div class="green-highlight-table"><b>Note:</b> Adding preload alone does not automatically preload your site. You must also meet preload requirements and submit your domain for inclusion.</div></p>

<!-- Start FAQ -->
<div class="getting-recover-main recover-faq-area">
  <h3>FAQs on HSTS Header Test</h3>
  <div class="accordion" id="accordionPanelsStayOpenExample">
    @foreach([
      [
        'q' => 'What is the HSTS header name?',
        'a' => 'The HSTS header is called Strict-Transport-Security. When a browser receives it over HTTPS, it remembers to access your site only via HTTPS for the duration you specify.'
      ],
      [
        'q' => 'Does HSTS redirect HTTP to HTTPS?',
        'a' => 'Not exactly. Your server can redirect HTTP to HTTPS, but HSTS makes the browser automatically upgrade requests to HTTPS after it has stored the policy. This provides stronger protection than redirects alone.'
      ],
      [
        'q' => 'What is a good max-age value for HSTS?',
        'a' => 'Many sites use 1 year (31536000) or 2 years (63072000) once they are confident HTTPS is stable. A safer approach is to start with a short max-age and increase it gradually.'
      ],
      [
        'q' => 'Should I use includeSubDomains?',
        'a' => 'Only if every subdomain you use is HTTPS-ready. If a subdomain still runs on HTTP, enabling includeSubDomains can break access to that subdomain until the policy expires.'
      ],
      [
        'q' => 'What does preload mean in HSTS?',
        'a' => 'Preload is an optional directive used when you want to be eligible for the HSTS preload list. If your domain is preloaded, browsers enforce HTTPS from the very first visit, even before they’ve seen your header.'
      ],
      [
        'q' => 'Does adding preload automatically put my site on the preload list?',
        'a' => 'No. Adding preload does not automatically preload your site. You must meet the preload requirements and submit your domain for inclusion in the preload list.'
      ],
      [
        'q' => 'Can HSTS cause problems if misconfigured?',
        'a' => 'Yes. If your certificate expires, HTTPS breaks, or a subdomain is not HTTPS-ready, users may be unable to access those endpoints until the HSTS max-age expires. That’s why a staged rollout is recommended.'
      ],
      [
        'q' => 'When should I run an HSTS Header Test?',
        'a' => 'Run it after enabling HTTPS, after changing hosting/CDN settings, after renewing or switching certificates, and periodically to ensure the header is still present and configured correctly.'
      ]
    ] as $faq)
    <div class="accordion-item">
      <h2 class="accordion-header" id="heading-{{ \Illuminate\Support\Str::slug($faq['q']) }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#collapse-{{ \Illuminate\Support\Str::slug($faq['q']) }}"
          aria-expanded="false"
          aria-controls="collapse-{{ \Illuminate\Support\Str::slug($faq['q']) }}">
          {{ $faq['q'] }}
        </button>
      </h2>
      <div id="collapse-{{ \Illuminate\Support\Str::slug($faq['q']) }}"
        class="accordion-collapse collapse"
        aria-labelledby="heading-{{ \Illuminate\Support\Str::slug($faq['q']) }}">
        <div class="accordion-body">
          <p>{{ $faq['a'] }}</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
<!-- End FAQ -->





   
  </div>
</div>