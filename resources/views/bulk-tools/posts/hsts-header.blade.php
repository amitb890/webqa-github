@section('title', 'HSTS Header Tester: Force HTTPS for Secure Browsing | Webqa')
@section('meta-description', 'Check if a page sends the Strict Transport Security (HSTS) header to enforce HTTPS and prevent downgrade attacks. Get clear Pass/Fail results and export findings.')
@section('canonical', 'https://webqa.co/tools/hsts-header-test')
@section('og-title', 'Test HSTS - Strict Transport Security Headers | Webqa')
@section('og-description', 'Audit HSTS headers to ensure browsers always use HTTPS for your site, improving security and preventing protocol downgrades. Export results for quick fixes.')
@section('og-url', 'https://webqa.co/tools/hsts-header-test')
@section('og-image', 'https://webqa.co/new-assets/assets/images/og/tools/hsts-header-test.png')
@section('og-image-alt', 'HSTS header test')


<div class="single-post-content-main bulk-tool-test">
  <div class="single-post-content">

    <h2 class="tools_des_fastheading">HSTS Header</h2>


    <div class="list yellow-content summary-block">
      <span class="summary-heading">Quick Summary</span>

      <p>
        HTTP Strict Transport Security (HSTS) is a browser security mechanism
        that tells browsers to use HTTPS when connecting to a website instead
        of allowing insecure HTTP connections.
      </p>

      <ol>
        <li>
          HSTS (HTTP Strict Transport Security) is enabled through the
          Strict Transport Security HTTP response header.
        </li>
        <li>
          The max-age directive tells the browser how long the HSTS
          policy should remain active.
        </li>
        <li>
          includeSubDomains extends the HSTS policy to subdomains of
          the host.
        </li>
        <li>
          preload is used when a domain is intended to meet the
          requirements for inclusion in browser HSTS preload lists.
        </li>
        <li>
          HSTS helps protect against downgrade and SSL stripping attacks by
          preventing the browser from making insecure HTTP connections once
          the policy is known.
        </li>
        <li>
          HSTS must be delivered over HTTPS. A browser does not trust an HSTS
          policy received over an insecure HTTP connection.
        </li>
        <li>
          This test checks whether the HSTS header is present and helps
          identify missing or potentially incomplete configurations.
        </li>
      </ol>
    </div>


    <h3>What Is HSTS and How Does the Strict Transport Security Header Work?</h3>

    <p>
      HSTS stands for <b>HTTP Strict Transport Security</b>. It is a browser
      security mechanism that allows a website to tell browsers that it should
      only be accessed using HTTPS.
    </p>

    <p>
      HSTS is enabled by sending the
      <b>Strict Transport Security</b> response header from the website over a
      secure HTTPS connection.
    </p>

    <p>
      When a browser receives a valid HSTS policy, it stores the policy for the
      period specified by the <b>max-age</b> directive. During that period,
      the browser treats the host as HTTPS-only.
    </p>

    <p>
      For example, a website might send:
    </p>

    <div class="code-block">
      <code>
        <span class="token-attr">Strict Transport Security:</span>
        <span class="token-value">max-age=31536000</span>
      </code>
    </div>

    <p>
      This tells the browser to remember the HTTPS-only policy for
      <b>31,536,000 seconds</b>, or one year.
    </p>

    <p>Once the HSTS policy is active, the browser can:</p>

    <ol>
      <li>
        Automatically upgrade HTTP URLs for the HSTS host to HTTPS before
        making the connection.
      </li>
      <li>
        Prevent insecure HTTP connections from being used for that host.
      </li>
      <li>
        Refuse to let users bypass certain TLS certificate errors for an
        HSTS host.
      </li>
    </ol>

    <img src="{{ asset('new-assets/assets/images/bulk-tool/hsts-header.png') }}" alt="HSTS Header" width="600" height="400" class="img-fluid my-4">

    <p>
      This behavior is especially important when visitors use public or
      otherwise untrusted networks, where an attacker may attempt to interfere
      with an insecure HTTP connection.
    </p>


    <h3>HSTS vs  HTTP to HTTPS Redirects</h3>

    <p>
      HSTS and HTTP-to-HTTPS redirects both help move visitors toward secure
      connections, but they work at different stages.
    </p>

    <table class="good-bad-example-table">
      <thead>
        <tr>
          <th>HTTP Redirect</th>
          <th>HSTS</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Server receives an HTTP request first.</td>
          <td>
            Browser can upgrade the request to HTTPS before making the HTTP
            connection.
          </td>
        </tr>
        <tr>
          <td>Typically uses a 301 or 308 response.</td>
          <td>
            Uses the Strict Transport Security response header.
          </td>
        </tr>
        <tr>
          <td>
            Useful when the browser does not already know the HSTS policy.
          </td>
          <td>
            Applies after the browser has learned the HSTS policy.
          </td>
        </tr>
        <tr>
          <td>
            Does not by itself prevent the initial HTTP connection.
          </td>
          <td>
            Helps prevent insecure HTTP connections for known HSTS hosts.
          </td>
        </tr>
      </tbody>
    </table>

    <p>
      For a modern HTTPS website, server-side HTTP-to-HTTPS redirects and HSTS
      generally complement each other rather than replace each other.
    </p>


    <h3>How Does HSTS Prevent SSL Stripping Attacks?</h3>

    <p>
      An SSL-stripping attack attempts to keep a visitor on an insecure HTTP
      connection even though the website supports HTTPS. This can be
      particularly dangerous when a visitor is using an untrusted network.
    </p>

    <p>
      Without HSTS, a visitor may initially request:
    </p>

    <div class="code-block">
    
        <span class="token-value">http://example.com</span>
   
    </div>

    <p>
      The server could then redirect the visitor to:
    </p>

    <div class="code-block">
      
        <span class="token-value">https://example.com</span>
      
    </div>

    <p>
      The problem is that the initial HTTP connection occurred before the
      browser knew that the website required HTTPS.
    </p>

    <p>
      Once HSTS is active, the browser can upgrade the HTTP URL to HTTPS itself,
      avoiding that initial insecure connection.
    </p>

    <img src="{{ asset('new-assets/assets/images/bulk-tool/hsts-protection.png') }}" alt="HSTS protection" width="600" height="400" class="img-fluid my-4">

    <div class="list yellow-content">
      <p><b>In simple terms:</b></p>

      <p>
        HTTP redirect:
        <b>Browser → HTTP → Server → HTTPS redirect</b>
      </p>

      <p>
        HSTS:
        <b>Browser → HTTPS → Server</b>
      </p>
    </div>


    <h3>What Happens Before the Browser Knows About HSTS?</h3>

    <p>
      HSTS is not automatically known by every browser. A browser normally
      learns a website's HSTS policy after receiving the
      <b>Strict Transport Security</b> header over HTTPS.
    </p>

    <p>
      This means there can be a protection gap on the very first connection if
      the browser has never previously received an HSTS policy for the host.
    </p>

    <p>
      This is one reason HSTS preload lists exist. A domain included in a
      browser's preload data can be treated as HTTPS-only before the browser
      has received the site's HSTS header.
    </p>

    <p>
      Preloading is therefore a separate mechanism from simply sending the
      HSTS header and should be approached carefully because changes to a
      preload list are not instantaneous.
    </p>


    <h3>Key HSTS Directives</h3>

    <p>
      The Strict Transport Security header is made up of directives that
      control how browsers enforce HTTPS for your domain. The most common
      directives are <b>max-age</b>, <b>includeSubDomains</b>, and
      <b>preload</b>.
    </p>


    <h5>1. max-age</h5>

    <p>
      The <b>max-age</b> directive specifies how many seconds the browser
      should remember that the host must only be accessed using HTTPS.
    </p>

    <div class="code-block">
      <code>
        <span class="token-attr">Strict Transport Security:</span>
        <span class="token-value">max-age=31536000</span>
      </code>
    </div>

    <ul>
      <li><b>31536000</b> = 1 year</li>
      <li><b>63072000</b> = 2 years</li>
    </ul>

    <p>
      During this period, the browser enforces the HTTPS-only policy for the
      host. When the browser receives the HSTS header again, the policy's
      expiration is refreshed according to the current <b>max-age</b> value.
    </p>


    <h5>2. includeSubDomains</h5>

    <p>
      <b>includeSubDomains</b> extends the HSTS policy to subdomains of the
      host.
    </p>

    <div class="code-block">
      <code>
        <span class="token-attr">Strict Transport Security:</span>
        <span class="token-value">max-age=31536000; includeSubDomains</span>
      </code>
    </div>

    <p>
      For example, an HSTS policy for <b>example.com</b> with
      <b>includeSubDomains</b> can also apply to hosts such as:
    </p>

    <ul>
      <li>www.example.com</li>
      <li>app.example.com</li>
      <li>blog.example.com</li>
      <li>admin.example.com</li>
    </ul>

    <div class="red-highlight-table">
      <b>Important:</b>
      <p>
        Only use includeSubDomains when all relevant subdomains
        are ready to operate correctly over HTTPS. Otherwise, HSTS can prevent
        users from accessing HTTP-only subdomains.
      </p>
    </div>


    <h5>3. preload</h5>

    <p>
      <b>preload</b> is an optional token associated with HSTS preload lists.
      It indicates that a site intends to meet the requirements for preload
      inclusion.
    </p>

    <p>
      Preloading allows participating browsers to know that a domain should
      be treated as HTTPS-only before the browser has received the site's HSTS
      response.
    </p>

    <div class="green-highlight-table">
      <b>Important:</b>
      <p>
        Adding preload to the header does not by itself place your
        domain on a browser's preload list. The domain must satisfy the
        relevant requirements and be submitted through the appropriate
        preload service.
      </p>
    </div>


    <h3>What Does a Strong HSTS Configuration Look Like?</h3>

    <p>
      A common HSTS configuration for a mature HTTPS-only website is:
    </p>

    <div class="code-block">
      <code>
        <span class="token-attr">Strict Transport Security:</span>
        <span class="token-value">max-age=63072000; includeSubDomains; preload</span>
      </code>
    </div>

    <p>
      This configuration represents a two-year HSTS policy, applies the policy
      to subdomains, and indicates that the site intends to qualify for HSTS
      preloading.
    </p>

    <p>
      However, this should not be copied blindly. A long HSTS duration,
      <b>includeSubDomains</b>, and preload can create significant operational
      consequences if any hostname in the covered domain is not ready for
      HTTPS.
    </p>


    <h3>How Does HSTS Affect Subdomains?</h3>

    <p>
      HSTS policies are applied to hosts, and the
      <b>includeSubDomains</b> directive can extend the policy to subdomains.
    </p>

    <p>
      For example, if <b>example.com</b> sends:
    </p>

    <div class="code-block">
      <code>
        <span class="token-attr">Strict Transport Security:</span>
        <span class="token-value">max-age=31536000; includeSubDomains</span>
      </code>
    </div>

    <p>
      browsers can apply the policy to subdomains such as
      <b>app.example.com</b> and <b>blog.example.com</b>.
    </p>

    <p>
      This makes HSTS stronger, but it also increases the scope of the policy.
      Before enabling <b>includeSubDomains</b>, review old, forgotten,
      staging, development, API, mail, and third-party-managed subdomains that
      may still exist under the domain.
    </p>


    <h3>What Happens If HSTS Is Misconfigured?</h3>

    <p>
      HSTS is powerful because browsers enforce the policy rather than merely
      displaying it as a recommendation. That also means configuration
      mistakes can have real consequences.
    </p>

    <ul>
      <li>
        <b>Expired or invalid TLS certificates:</b> browsers may refuse access
        rather than allowing users to bypass the certificate warning.
      </li>
      <li>
        <b>HTTP-only subdomains:</b> includeSubDomains can make
        those services inaccessible.
      </li>
      <li>
        <b>Premature preload:</b> once a domain is distributed through preload
        lists, removing or changing the policy is not instantaneous.
      </li>
      <li>
        <b>Incomplete HTTPS migration:</b> legacy endpoints may stop working
        when browsers enforce HTTPS.
      </li>
    </ul>

    <p>
      For this reason, HSTS should generally be introduced after the website's
      HTTPS configuration has been thoroughly tested.
    </p>


    <h3>How to Roll Out HSTS Safely</h3>

    <p>
      HSTS is best introduced gradually on websites that are migrating from
      HTTP to HTTPS or that have a large number of subdomains.
    </p>

    <ol>
      <li>
        <b>Make the entire website HTTPS-ready.</b>
        Check pages, assets, APIs, redirects, cookies, forms, and third-party
        integrations.
      </li>

      <li>
        <b>Verify HTTP-to-HTTPS redirects.</b>
        HTTP requests should consistently reach their HTTPS equivalents.
      </li>

      <li>
        <b>Start with a shorter max-age.</b>
        This allows the configuration to be tested before committing browsers
        to a long policy period.
      </li>

      <li>
        <b>Increase max-age gradually.</b>
        Once HTTPS is stable, move toward a longer HSTS duration.
      </li>

      <li>
        <b>Test subdomains.</b>
        Do this before enabling includeSubDomains.
      </li>

      <li>
        <b>Consider preload only when ready.</b>
        Preload should be treated as a deliberate long-term commitment rather
        than simply another header setting.
      </li>
    </ol>


    <h3>What Does the HSTS Header Test Check?</h3>

    <p>
      The HSTS Header Test examines the HTTP response from a webpage and
      checks whether it includes the
      <b>Strict Transport Security</b> response header.
    </p>

    <p>The test can help identify:</p>

    <ul>
      <li>Whether the HSTS header is present.</li>
      <li>The configured <b>max-age</b> value.</li>
      <li>Whether <b>includeSubDomains</b> is enabled.</li>
      <li>Whether the <b>preload</b> token is present.</li>
      <li>
        Whether the header appears to follow common HSTS configuration
        practices.
      </li>
    </ul>

    <p>
      A missing HSTS header does not necessarily mean that HTTPS itself is
      unavailable or incorrectly configured. It means that the browser is not
      being given an HSTS policy through that response.
    </p>

    <p>
      Likewise, the presence of HSTS does not replace proper TLS
      configuration, HTTPS redirects, certificate management, or other
      security controls.
    </p>


    <h3>HSTS vs. HTTPS: What's the Difference?</h3>

    <table class="good-bad-example-table">
      <thead>
        <tr>
          <th>HTTPS</th>
          <th>HSTS</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Encrypts the connection between the browser and server.</td>
          <td>
            Tells the browser to use HTTPS for the host.
          </td>
        </tr>
        <tr>
          <td>Requires a valid TLS certificate.</td>
          <td>
            Relies on HTTPS being correctly configured.
          </td>
        </tr>
        <tr>
          <td>Protects data in transit.</td>
          <td>
            Helps prevent insecure HTTP connections and downgrade attacks.
          </td>
        </tr>
        <tr>
          <td>Can be used without HSTS.</td>
          <td>
            Requires HTTPS to work correctly.
          </td>
        </tr>
      </tbody>
    </table>

    <p>
      HSTS does not replace HTTPS. Instead, it strengthens an HTTPS deployment
      by telling compatible browsers to consistently use the secure protocol.
    </p>


    <h3>Does HSTS Affect SEO?</h3>

    <p>
      HSTS is primarily a security mechanism rather than a direct search
      ranking factor.
    </p>

    <p>
      Its purpose is to enforce HTTPS usage in browsers and reduce the risk of
      downgrade and interception attacks. It does not directly tell search
      engines how a page should rank.
    </p>

    <p>
      However, maintaining a consistent HTTPS implementation is important for
      website reliability and technical quality. HSTS should therefore be
      viewed as a security improvement rather than a direct SEO optimization.
    </p>


    <h3>Good vs. Bad HSTS Practices</h3>

    <table class="good-bad-example-table">
      <thead>
        <tr>
          <th>Good Practice</th>
          <th>Bad Practice</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Serve HSTS over HTTPS.</td>
          <td>
            Expect browsers to trust HSTS sent over HTTP.
          </td>
        </tr>
        <tr>
          <td>
            Use a meaningful max-age after HTTPS is stable.
          </td>
          <td>
            Immediately use a very long policy without testing HTTPS.
          </td>
        </tr>
        <tr>
          <td>
            Test all subdomains before using includeSubDomains.
          </td>
          <td>
            Enable includeSubDomains without checking legacy subdomains.
          </td>
        </tr>
        <tr>
          <td>
            Use preload only when the domain is ready for its requirements.
          </td>
          <td>
            Add preload simply because it appears more secure.
          </td>
        </tr>
        <tr>
          <td>
            Maintain valid TLS certificates across covered hosts.
          </td>
          <td>
            Assume HSTS will compensate for certificate problems.
          </td>
        </tr>
        <tr>
          <td>
            Verify the actual production response header.
          </td>
          <td>
            Assume a server configuration change automatically reached every
            request.
          </td>
        </tr>
      </tbody>
    </table>


    <h3>Common HSTS Configuration Mistakes</h3>

    <ol>
      <li>
        <b>Sending HSTS over HTTP:</b> browsers ignore the policy when it is
        received over an insecure connection.
      </li>

      <li>
        <b>Using a very short max-age indefinitely:</b> this limits the period
        during which browsers enforce HTTPS.
      </li>

      <li>
        <b>Enabling includeSubDomains too early:</b> HTTP-only subdomains can
        become inaccessible.
      </li>

      <li>
        <b>Adding preload without preparation:</b> preload requires a much more
        complete HTTPS deployment.
      </li>

      <li>
        <b>Assuming HSTS replaces redirects:</b> redirects remain useful for
        browsers that have not yet learned the HSTS policy.
      </li>

      <li>
        <b>Forgetting certificates:</b> HSTS makes browsers less tolerant of
        TLS certificate problems because certificate errors cannot simply be
        bypassed.
      </li>
    </ol>


    <h3>When Should You Run an HSTS Header Test?</h3>

    <p>
      HSTS is generally a configuration-level setting, but it is worth checking
      whenever your HTTPS infrastructure changes.
    </p>

    <ol>
      <li>After migrating a website from HTTP to HTTPS.</li>
      <li>After changing your web server or CDN configuration.</li>
      <li>After changing HTTPS or TLS settings.</li>
      <li>After renewing or replacing certificates.</li>
      <li>After adding or changing subdomains.</li>
      <li>Before enabling includeSubDomains.</li>
      <li>Before submitting a domain for HSTS preloading.</li>
      <li>During periodic security-header audits.</li>
    </ol>


    <h3>Conclusion</h3>

    <p>
      HTTP Strict Transport Security is an important part of a modern HTTPS
      security strategy. By sending the
      Strict Transport Security response header, a website can tell
      compatible browsers to use HTTPS for future connections and avoid
      insecure HTTP access.
    </p>

    <p>
      The max-age directive controls how long the policy is remembered,
      while includeSubDomains extends the policy to subdomains.
     preload can be used as part of a deliberate HSTS preload strategy
      when the website meets the necessary requirements.
    </p>

    <p>
      HSTS should be implemented carefully because an overly aggressive policy
      can affect subdomains and make certificate or HTTPS configuration
      problems more difficult for users to bypass.
    </p>

    <p>
      The WebQA HSTS Header Test helps you verify whether the
      Strict Transport Security header is present and review its
      configuration so you can identify missing or potentially misconfigured
      HSTS policies.
    </p>


    <!-- Start FAQ -->
    <div class="getting-recover-main recover-faq-area">

      <h3>FAQs on HSTS Header Test</h3>

      <div class="accordion" id="accordionHstsHeaderFaq">

        @foreach([
          [
            'q' => 'What is the HSTS header?',
            'a' => 'The HSTS header is called Strict Transport Security. It tells compatible browsers that a website should only be accessed using HTTPS for the period specified by the max-age directive.'
          ],
          [
            'q' => 'Does HSTS redirect HTTP to HTTPS?',
            'a' => 'Not exactly. A server can redirect HTTP requests to HTTPS, but HSTS allows the browser to upgrade HTTP URLs to HTTPS before making the insecure HTTP connection once the browser already knows the HSTS policy.'
          ],
          [
            'q' => 'What is a good max-age value for HSTS?',
            'a' => 'There is no single value that is correct for every website. Many mature HTTPS deployments use a long duration such as one or two years. A staged rollout with a shorter duration can be safer while HTTPS configuration is being validated.'
          ],
          [
            'q' => 'Should I use includeSubDomains?',
            'a' => 'Use includeSubDomains only when the relevant subdomains are ready to operate correctly over HTTPS. Otherwise, HSTS can make HTTP-only subdomains inaccessible.'
          ],
          [
            'q' => 'What does preload mean in HSTS?',
            'a' => 'The preload token indicates that the site intends to meet the requirements for HSTS preload inclusion. Preloading allows participating browsers to know that a domain should use HTTPS even before they have received its HSTS header.'
          ],
          [
            'q' => 'Does adding preload automatically preload my website?',
            'a' => 'No. Adding preload to the response header does not by itself place a domain on browser preload lists. The domain must satisfy the relevant requirements and be submitted through the appropriate preload service.'
          ],
          [
            'q' => 'Can HSTS cause problems if it is misconfigured?',
            'a' => 'Yes. HSTS can prevent users from accessing HTTP-only services, and browsers do not allow users to simply bypass certain TLS certificate errors for HSTS hosts. This is why HTTPS and all covered subdomains should be tested before applying a long HSTS policy.'
          ],
          [
            'q' => 'When should I run an HSTS Header Test?',
            'a' => 'Run the test after enabling HTTPS, changing web server or CDN settings, modifying TLS configuration, adding subdomains, or preparing for HSTS preloading. Periodic security-header audits can also help confirm that the policy remains present.'
          ]
        ] as $faq)

        <div class="accordion-item">

          <h2 class="accordion-header"
            id="heading-{{ \Illuminate\Support\Str::slug($faq['q']) }}">

            <button class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
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
              <p>{!! $faq['a'] !!}</p>
            </div>

          </div>

        </div>

        @endforeach

      </div>

    </div>
    <!-- End FAQ -->


  </div>
</div>