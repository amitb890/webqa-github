<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is a Content Security Policy header?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "A CSP header is a browser security mechanism that defines which sources are allowed to load scripts, styles, images, fonts, frames, and other resources on a page."
      }
    },
    {
      "@type": "Question",
      "name": "Why is CSP important for security?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "CSP helps reduce the risk of cross-site scripting (XSS) by preventing malicious scripts from loading or executing unless they come from trusted sources."
      }
    },
    {
      "@type": "Question",
      "name": "Can CSP break my website?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. If CSP blocks required scripts, stylesheets, fonts, frames, or API calls, parts of your website may stop working. A safer approach is to start with Report-Only mode, review violations, then enforce a stricter policy."
      }
    },
    {
      "@type": "Question",
      "name": "What is CSP Report-Only mode?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Report-Only mode monitors CSP violations without blocking content. It helps you see what would be blocked and adjust the policy safely before enforcing it."
      }
    },
    {
      "@type": "Question",
      "name": "What is the difference between CSP and X-Frame-Options?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "X-Frame-Options provides basic clickjacking protection, while CSP’s frame-ancestors directive offers more flexible and modern control over which origins can embed your pages."
      }
    },
    {
      "@type": "Question",
      "name": "Does CSP affect SEO?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "CSP itself isn’t a ranking factor, but a misconfigured CSP can block resources required for rendering, which may impact indexing and user experience."
      }
    },
    {
      "@type": "Question",
      "name": "Should I allow unsafe-inline or unsafe-eval in CSP?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "They weaken CSP’s protection and should generally be avoided. They are sometimes used temporarily during migrations, but long-term best practice is to use nonces or hashes instead."
      }
    },
    {
      "@type": "Question",
      "name": "What is a “strict CSP”?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "A strict CSP typically uses nonces or hashes for scripts, avoids unsafe-inline and unsafe-eval, and locks down high-risk directives like script-src, object-src, and base-uri."
      }
    },
    {
      "@type": "Question",
      "name": "How often should I test my CSP header?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Test CSP after adding new scripts, third-party tools, CDNs, framework updates, or hosting/CDN changes—and periodically to ensure it hasn’t been removed or weakened."
      }
    },
    {
      "@type": "Question",
      "name": "What does this CSP Header Test tool check?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "It checks whether a CSP header is present, whether it’s enforced or report-only, and whether it follows common best practices or appears overly permissive."
      }
    }
  ]
}
</script>
