@section('title', 'Schema / JSON-LD Tester: Structured Data Bulk Check | Webqa')
@section('meta-description', 'Bulk test JSON-LD structured data across multiple URLs. Detect schema types, validate markup, and find missing or invalid structured data. Pass/Fail results and export.')
@section('canonical', 'https://webqa.co/tool/schema')
@section('og-title', 'Schema Test: Bulk JSON-LD Structured Data Check | Webqa')
@section('og-description', 'Validate JSON-LD and schema.org markup across many URLs at once. See types found, parse errors, and pass/fail per URL.')
@section('og-url', 'https://webqa.co/tool/schema')

<div class="single-post-content-main bulk-tool-test">
  <div class="single-post-content">
    <h2 class="tools_des_fastheading">Schema</h2>

    <div class="list yellow-content summary-block">
      <span class="summary-heading">Quick Summary</span>
      <p>Schema (often implemented as JSON-LD) is structured data that helps search engines understand your page content—products, articles, organizations, events, and more.</p>
      <ol>
        <li>Search engines use schema to show rich results (e.g. stars, FAQs, breadcrumbs) in search results.</li>
        <li>Valid JSON-LD in <code>&lt;script type="application/ld+json"&gt;</code> is the recommended way to add structured data.</li>
        <li>Missing or invalid schema can mean no rich results and weaker topical signals.</li>
        <li>This tool checks multiple URLs for the presence of JSON-LD, reported types, and parse errors.</li>
      </ol>
    </div>

    <h3>What is Schema / JSON-LD?</h3>
    <p>Schema.org structured data describes your page in a machine-readable format. JSON-LD (JavaScript Object Notation for Linked Data) is one of the formats supported by Google and others. It is typically embedded in the page <code>&lt;head&gt;</code> or body inside a <code>&lt;script type="application/ld+json"&gt;</code> tag.</p>
    <p>Example:</p>
    <div class="code-block">
      <code>
        <span class="token-tag">&lt;script type="application/ld+json"&gt;</span><br>
        { "@context": "https://schema.org", "@type": "Organization", "name": "Example", "url": "https://example.com" }<br>
        <span class="token-tag">&lt;/script&gt;</span>
      </code>
    </div>

    <h3>Why Does Schema Matter?</h3>
    <ul>
      <li><b>Rich results:</b> Valid schema can unlock rich snippets, FAQs, and other enhanced SERP features.</li>
      <li><b>Clarity for crawlers:</b> Search engines use it to understand entities, types, and relationships on the page.</li>
      <li><b>Consistency:</b> Bulk testing helps ensure every important URL has correct, parseable structured data.</li>
    </ul>

    <h3>Do's and Don'ts</h3>
    <div class="list green-list">
      <h3>Do's</h3>
      <ul>
        <li>Use valid JSON inside <code>application/ld+json</code> script tags.</li>
        <li>Include <code>@context</code> and <code>@type</code> as required by schema.org.</li>
        <li>Test pages after adding or changing structured data.</li>
        <li>Prefer JSON-LD over Microdata or RDFa for easier maintenance.</li>
      </ul>
    </div>
    <div class="list red-list">
      <h3>Don'ts</h3>
      <ul>
        <li>Don't inject invalid JSON (syntax errors, trailing commas, or HTML inside the script).</li>
        <li>Don't duplicate the same entity in conflicting ways across multiple blocks.</li>
        <li>Don't leave critical pages without any structured data when it could apply.</li>
      </ul>
    </div>

    <div class="getting-recover-main recover-faq-area">
      <h3>FAQs</h3>
      <div class="accordion" id="accordionSchemaFAQ">
        @foreach([
          [
            'q' => 'What does this Schema test check?',
            'a' => 'It fetches each URL, finds script tags with type="application/ld+json", parses the JSON, and reports schema types (e.g. Organization, Article), parse errors, and pass/fail per URL.',
          ],
          [
            'q' => 'Why did my URL fail?',
            'a' => 'Common reasons: no JSON-LD on the page, invalid JSON (syntax error), non-200 HTTP response, or no @type found in the structured data.',
          ],
          [
            'q' => 'Does this validate against schema.org rules?',
            'a' => 'This tool checks for presence and valid JSON-LD and reports types. Full schema.org validation (required properties, value types) can be done with Google’s Rich Results Test or similar validators.',
          ],
        ] as $faq)
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading-schema-{{ \Illuminate\Support\Str::slug($faq['q']) }}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              data-bs-target="#collapse-schema-{{ \Illuminate\Support\Str::slug($faq['q']) }}"
              aria-expanded="false"
              aria-controls="collapse-schema-{{ \Illuminate\Support\Str::slug($faq['q']) }}">
              {{ $faq['q'] }}
            </button>
          </h2>
          <div id="collapse-schema-{{ \Illuminate\Support\Str::slug($faq['q']) }}"
            class="accordion-collapse collapse"
            aria-labelledby="heading-schema-{{ \Illuminate\Support\Str::slug($faq['q']) }}">
            <div class="accordion-body">
              <p>{{ $faq['a'] }}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
