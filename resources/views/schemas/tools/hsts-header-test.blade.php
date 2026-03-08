<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is the HSTS header name?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The HSTS header is called Strict-Transport-Security. When a browser receives it over HTTPS, it remembers to access your site only via HTTPS for the duration you specify."
      }
    },
    {
      "@type": "Question",
      "name": "Does HSTS redirect HTTP to HTTPS?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Not exactly. Your server can redirect HTTP to HTTPS, but HSTS makes the browser automatically upgrade requests to HTTPS after it has stored the policy. This provides stronger protection than redirects alone."
      }
    },
    {
      "@type": "Question",
      "name": "What is a good max-age value for HSTS?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Many sites use 1 year (31536000) or 2 years (63072000) once they are confident HTTPS is stable. A safer approach is to start with a short max-age and increase it gradually."
      }
    },
    {
      "@type": "Question",
      "name": "Should I use includeSubDomains?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Only if every subdomain you use is HTTPS-ready. If a subdomain still runs on HTTP, enabling includeSubDomains can break access to that subdomain until the policy expires."
      }
    },
    {
      "@type": "Question",
      "name": "What does preload mean in HSTS?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Preload is an optional directive used when you want to be eligible for the HSTS preload list. If your domain is preloaded, browsers enforce HTTPS from the very first visit, even before they’ve seen your header."
      }
    },
    {
      "@type": "Question",
      "name": "Does adding preload automatically put my site on the preload list?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "No. Adding preload does not automatically preload your site. You must meet the preload requirements and submit your domain for inclusion in the preload list."
      }
    },
    {
      "@type": "Question",
      "name": "Can HSTS cause problems if misconfigured?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. If your certificate expires, HTTPS breaks, or a subdomain is not HTTPS-ready, users may be unable to access those endpoints until the HSTS max-age expires. That’s why a staged rollout is recommended."
      }
    },
    {
      "@type": "Question",
      "name": "When should I run an HSTS Header Test?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Run it after enabling HTTPS, after changing hosting/CDN settings, after renewing or switching certificates, and periodically to ensure the header is still present and configured correctly."
      }
    },
    {
      "@type": "Question",
      "name": "What does this HSTS Header Test tool check?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "It checks whether the Strict-Transport-Security header is present over HTTPS and highlights key directives like max-age, includeSubDomains, and preload so you can verify configuration and best practices."
      }
    }
  ]
}
</script>
