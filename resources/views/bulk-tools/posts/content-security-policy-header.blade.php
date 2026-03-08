@section('title', 'Content Security Policy (CSP) Header Tester | Webqa')
@section('meta-description', 'Check if a page sends a Content Security Policy header and validate basic directives to reduce XSS and injection risks. Get clear Pass/Fail results and export findings.')
@section('canonical', 'https://webqa.co/tool/content-security-policy-header-test')
@section('og-title', 'Test Content Security Policy (CSP) Headers | Webqa')
@section('og-description', 'Audit CSP headers to ensure scripts and other resources only load from trusted sources. Find missing or weak policies and export results for quick fixes.')
@section('og-url', 'https://webqa.co/tool/content-security-policy-header-test')
@section('og-image', 'https://webqa.co/new-assets/assets/images/og/tools/csp-header-test.png')
@section('og-image-alt', 'CSP header test')

<div class="single-post-content-main bulk-tool-test">
  <div class="single-post-content">
    <h2 class="tools_des_fastheading">Content Security Policy Header</h2>

<div class="list yellow-content summary-block">
  <span class="summary-heading">Quick Summary</span>
  <p>A Content Security Policy Header Test checks whether your website sends a "Content Security Policy (CSP)" header and whether it’s configured securely.</p>
  <ol>
    <li>CSP (Content Security Policy) tells browsers which sources are allowed to load scripts, styles, images, frames, and other resources.</li>
    <li>It’s one of the most effective defenses against cross-site scripting (XSS) by reducing what malicious code is allowed to execute.</li>
    <li>CSP can also help mitigate clickjacking when you use the "frame-ancestors" directive.</li>
    <li>You can deploy CSP safely using "Report-Only mode" to collect violations before enforcing a strict policy.</li>
    <li>This tool helps you validate whether CSP is present, readable, and aligned with best practices.</li>
  </ol>
</div>

<h3>What is Content Security Policy (CSP)?</h3>
<p>Content Security Policy (CSP) is a browser security feature delivered via an HTTP response header (and in some cases, a meta tag). It provides a set of rules that instructs the browser what the page is allowed to load and execute.</p>

<p>Think of CSP as a whitelist of trusted sources for your website. It helps you control:</p>
<ul>
  <li>Where scripts can run from</li>
  <li>Where styles can load from</li>
  <li>Which images, fonts, and media are allowed to be rendered</li>
  <li>Which domains can embed your website in frames</li>
</ul>

<p>CSP is most commonly used to control JavaScript execution. Because many cyber attacks rely on injecting or running malicious scripts, CSP is widely recommended as a strong mitigation against "cross site scripting (XSS) attacks".</p>


<h3>Why CSP Matters</h3>
<p>Content Security Policy (CSP) is one of the most practical security controls you can add to a website. It works at the browser level and helps reduce the impact of common web attacks, especially those involving malicious scripts.</p>

<h5>Strong protection against XSS</h5>
<p>Cross site scripting (XSS) attacks often work by injecting malicious JavaScript into a webpage. CSP helps reduce this risk by limiting which scripts are allowed to load and which types of script execution are permitted.</p>

<h5>Limits damage from third party scripts</h5>
<p>Many websites use analytics, tag managers, ads, chat widgets, and other third party tools for different purposes. A Content Security Policy Header helps ensure those resources load only from trusted sources, reducing the risk of unexpected script injection.</p>

<h5>Clickjacking defense with frame ancestors</h5>
<p>CSP can also protect against "framing based" attacks by using the frame-ancestors directive, which controls which websites are allowed to embed your pages in an iframe.</p>

<h5>Safer rollout with Report Only mode</h5>
<p>CSP can break websites if it blocks required scripts, styles, or API calls that are essential for the loading and functioning of a website. A safer approach is to start with "Report-Only" mode to monitor violations, fix issues, and then enforce the policy once you’re confident that nothing will break once a CSP header is enforced.</p>


<h3>Common CSP Directives</h3>
<p>A Content Security Policy header is made up of directives separated by semicolons. Each directive controls what the browser is allowed to load or execute for a specific type of resource.</p>

<p>Here are the most commonly used CSP directives:</p>
<ol>
  <li><b>default-src</b> – The fallback rule for most resource types when a more specific directive is not defined.</li>
  <li><b>script-src</b> – Controls where JavaScript can load from and how scripts are allowed to run. This is often the most important directive for XSS protection.</li>
  <li><b>style-src</b> – Controls where CSS stylesheets can load from (and whether inline styles are allowed).</li>
  <li><b>img-src</b> – Defines which sources images can be loaded from.</li>
  <li><b>font-src</b> – Defines which sources fonts can be loaded from.</li>
  <li><b>connect-src</b> – Controls which endpoints the page can connect to using fetch/XHR/WebSockets (APIs, analytics endpoints, etc.).</li>
  <li><b>object-src</b> – Controls plugin content (historically used for Flash). Many secure policies set this to none.</li>
  <li><b>base-uri</b> – Restricts what can be used in the HTML base tag, which helps prevent certain types of URL manipulation.</li>
  <li><b>frame-ancestors</b> – Controls which sites are allowed to embed your pages in frames/iframes (modern clickjacking protection).</li>
  <li><b>upgrade-insecure-requests</b> – Automatically upgrades HTTP resource requests to HTTPS (useful during HTTPS migration).</li>
</ol>

<p>A well-configured CSP typically focuses first on locking down scripts (script-src), then expands to cover other resource types without breaking website functionality.</p>


<h3>How to Implement Common CSP Directives</h3>
<p>Given below are some practical examples of common CSP directive implementations. These examples are meant to help you understand the structure of a policy and how directives work together to achieve a desired outcome</p>

<h5>Basic CSP Header Policy</h5>
<p>This policy allows content only from your own domain. It’s a simple baseline for many websites and acts as a good starting point.</p>
<div class="code-block">
  <code>
    Content-Security-Policy: default-src 'self';
  </code>
</div>

<h5>Allow scripts from self + a trusted CDN</h5>
<p>Useful when you host most files yourself but load scripts from a trusted CDN (Content delivery network)</p>
<div class="code-block">
  <code>
    Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.example.com;
  </code>
</div>

<h5>Common website policy (scripts, styles, images, fonts, API calls)</h5>
<p>This is a more realistic setup for modern sites that use a CDN, analytics code, and API endpoints.</p>
<div class="code-block">
  <code>
    Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.example.com; style-src 'self' https://cdn.example.com; img-src 'self' data: https:; font-src 'self' https://cdn.example.com; connect-src 'self' https://api.example.com;
  </code>
</div>

<h5>Clickjacking protection using frame-ancestors</h5>
<p>This blocks other sites from embedding your pages in iframes (modern alternative to X-Frame-Options).</p>
<div class="code-block">
  <code>
    Content-Security-Policy: frame-ancestors 'self';
  </code>
</div>

<h5>Allow embedding only on trusted partner domains</h5>
<p>If you need to allow framing on specific trusted domains, define them explicitly.</p>
<div class="code-block">
  <code>
    Content-Security-Policy: frame-ancestors 'self' https://partner1.com https://partner2.com;
  </code>
</div>

<h5>Report-Only mode (safe rollout)</h5>
<p>Use Report-Only to collect violations without breaking your site. This helps you refine the policy before enforcing it.</p>
<div class="code-block">
  <code>
    Content-Security-Policy-Report-Only: default-src 'self'; script-src 'self' https://cdn.example.com;
  </code>
</div>

<p><div class="green-highlight-table"><b>Tip:</b> CSP can break functionality if it blocks required resources. Start with "Report-Only", review what gets blocked, then tighten and enforce the policy once everything is working normally.</div></p>



<h3>Good vs Bad CSP Examples</h3>
<p>A “good” CSP policy limits where scripts and resources can load from without breaking the site. A “bad” CSP policy is usually too permissive offering little protection or too strict without testing - breaking important functionality.</p>

<p><b>Examples of Good CSP setups</b></p>
<table class="good-bad-example-table">
  <tr>
    <th>CSP example and intent</th>
    <th>Why this is good</th>
  </tr>
  <tr>
    <td>
      <b>CSP Example</b>&nbsp;&nbsp;&nbsp; - default-src 'self';<br>
      <b>Intent</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Allow resources only from your own site by default
    </td>
    <td>A strong baseline that reduces exposure to unexpected third-party resources.</td>
  </tr>
  <tr>
    <td>
      <b>CSP Example</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - default-src 'self'; script-src 'self' https://cdn.example.com;<br>
      <b>Intent</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Allow scripts only from your site and a trusted CDN
    </td>
    <td>Locks down script execution (a major XSS control) while still supporting common CDN usage.</td>
  </tr>
  <tr>
    <td>
      <b>CSP Example</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - object-src 'none'; base-uri 'none';<br>
      <b>Intent</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Block plugin content and restrict base URL manipulation
    </td>
    <td>Reduces attack surface by disabling risky legacy mechanisms and preventing certain URL-based attacks.</td>
  </tr>
  <tr>
    <td>
      <b>CSP Example</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - frame-ancestors 'self';<br>
      <b>Intent</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Prevent unwanted embedding in iframes
    </td>
    <td>Helps mitigate clickjacking by allowing framing only within your own site.</td>
  </tr>
  <tr>
    <td>
      <b>CSP Example</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Content-Security-Policy-Report-Only: default-src 'self'; script-src 'self' https://cdn.example.com;<br>
      <b>Intent</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Test the policy safely before enforcing
    </td>
    <td>Lets you collect CSP violations and fix issues without breaking site functionality during rollout.</td>
  </tr>
</table>

<p><b>Examples of Bad CSP setups</b></p>
<table class="good-bad-example-table">
  <tr>
    <th>CSP example and issue</th>
    <th>Why this is bad</th>
  </tr>
  <tr>
    <td>
      <b>CSP Example</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - default-src *;<br>
      <b>Issue</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Allows resources from anywhere
    </td>
    <td>This is overly permissive and provides little real protection because any domain can serve content.</td>
  </tr>
  <tr>
    <td>
      <b>CSP Example</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - script-src * 'unsafe-inline' 'unsafe-eval';<br>
      <b>Issue</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Allows unsafe script execution patterns
    </td>
    <td>Weakens XSS protection by allowing inline scripts and eval-like behavior, which attackers often abuse.</td>
  </tr>
  <tr>
    <td>
      <b>CSP Example</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - script-src 'self'; (but site relies on third-party tools)<br>
      <b>Issue</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Too strict without testing
    </td>
    <td>Can break analytics, tag managers, payment scripts, chat widgets, or CDNs if not included and tested first.</td>
  </tr>
  <tr>
    <td>
      <b>CSP Example</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Missing frame-ancestors and no X-Frame-Options<br>
      <b>Issue</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - No framing protection
    </td>
    <td>If your pages can be framed freely, you may be exposed to clickjacking risks depending on page functionality.</td>
  </tr>
</table>

<p>A good CSP balances security and functionality: start in Report-Only mode, tighten scripts first, and then expand the policy to cover other resource types without breaking critical site features.</p>


<!-- Start FAQ -->
<div class="getting-recover-main recover-faq-area">
  <h3>FAQs on Content Security Policy Header</h3>
  <div class="accordion" id="accordionPanelsStayOpenExample">
    @foreach([
      [
        'q' => 'What is a Content Security Policy header?',
        'a' => 'A CSP header is a browser security mechanism that defines which sources are allowed to load scripts, styles, images, fonts, frames, and other resources on a page.'
      ],
      [
        'q' => 'Why is CSP important for security?',
        'a' => 'CSP helps reduce the risk of cross site scripting (XSS) by preventing malicious scripts from loading or executing unless they come from trusted sources.'
      ],
      [
        'q' => 'Can CSP break my website?',
        'a' => 'Yes. If CSP blocks required scripts, stylesheets, fonts, or API calls, some parts of your website may stop working. That’s why it’s recommended to start with Report-Only mode before enforcing a strict CSP policy.'
      ],
      [
        'q' => 'What is CSP Report-Only mode?',
        'a' => 'Report-Only mode monitors CSP violations without blocking content. It allows you to see what would break and adjust the policy safely before enforcement.'
      ],
      [
        'q' => 'What is the difference between CSP and X-Frame-Options?',
        'a' => 'X-Frame-Options provides basic framing protection, while CSP’s frame-ancestors directive offers more flexible and modern control over which domains can embed your pages.'
      ],
      [
        'q' => 'Does CSP affect SEO?',
        'a' => 'While CSP itself isn’t a ranking factor, a broken CSP can block scripts or resources required for rendering, which can impact page experience and indexing.'
      ],
      [
        'q' => 'Should I allow unsafe-inline or unsafe-eval in CSP?',
        'a' => 'These weaken CSP’s protection and should generally be avoided. They are sometimes used temporarily during migrations but should be removed for stronger security.'
      ],
      [
        'q' => 'What is a “strict CSP”?',
        'a' => 'A strict CSP typically uses nonces or hashes for scripts, avoids unsafe-inline and unsafe-eval, and locks down high-risk directives like script-src, object-src, and base-uri.'
      ],
      [
        'q' => 'How often should I test my CSP header?',
        'a' => 'Test your CSP after adding new scripts, third-party tools, CDNs, framework updates, or hosting/CDN changes and periodically to ensure it hasn’t been removed or weakened.'
      ],
      [
        'q' => 'What does this CSP Header Test tool check?',
        'a' => 'It checks whether a CSP header is present, whether it’s enforced or report-only, and whether it follows common best practices or appears overly permissive.'
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