<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What does “bad content type” mean?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "It usually means the server is sending a Content-Type (MIME type) header that doesn’t match the actual content being delivered. This can cause browsers and search engines to handle the page or file incorrectly."
      }
    },
    {
      "@type": "Question",
      "name": "Can bad Content-Type affect SEO?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. If search engines can’t correctly interpret what a URL returns (for example, an HTML page served as plain text), it can reduce indexing quality and make it harder for crawlers to understand the page."
      }
    },
    {
      "@type": "Question",
      "name": "Why do my CSS or JS URLs show Content-Type as text/html?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "This commonly happens when the server returns an HTML error page, redirect page, or login page instead of the actual CSS/JS file. The URL looks like an asset, but the response is really HTML."
      }
    },
    {
      "@type": "Question",
      "name": "Is Content-Type the same as a file extension?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "No. A file extension is part of the URL (like .css or .js), while Content-Type is the HTTP header that tells browsers what the response actually is. They should match, but they can mismatch due to errors or misconfiguration."
      }
    },
    {
      "@type": "Question",
      "name": "What is a MIME type?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "MIME stands for Multipurpose Internet Mail Extensions. A MIME type (used in the Content-Type header) tells browsers and bots what kind of content is being returned, using a “type/subtype” format like text/html or application/json."
      }
    },
    {
      "@type": "Question",
      "name": "What is X-Content-Type-Options: nosniff and why does it matter?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "It’s a security header that tells browsers not to guess the Content-Type. This improves security, but it also means incorrect MIME types can cause scripts, styles, or other resources to be blocked."
      }
    },
    {
      "@type": "Question",
      "name": "How do I know what Content-Type a URL should return?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "In general: HTML pages should return text/html, CSS should return text/css, JavaScript should return application/javascript, images should return image/*, PDFs should return application/pdf, and APIs commonly return application/json."
      }
    },
    {
      "@type": "Question",
      "name": "What should I do if the tool flags a URL as bad?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "First, check whether the URL is returning the correct content (not a 404/403/login page). Then fix server/CDN MIME mappings, review redirects/rewrites, clear caches, and re-test to confirm the correct Content-Type is served."
      }
    },
    {
      "@type": "Question",
      "name": "Can a wrong Content-Type break CSS or JavaScript loading?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Browsers may refuse to apply stylesheets or execute scripts if the MIME type is incorrect—especially when nosniff is enabled—resulting in broken layouts or missing functionality."
      }
    },
    {
      "@type": "Question",
      "name": "Can CDNs or reverse proxies change Content-Type headers?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. CDNs, proxies, and caching layers can override headers based on rules or cached responses. If you fix the origin but still see the wrong Content-Type, purge CDN cache and confirm edge rules aren’t rewriting headers."
      }
    }
  ]
}
</script>
