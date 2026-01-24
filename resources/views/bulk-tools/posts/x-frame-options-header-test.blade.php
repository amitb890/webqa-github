<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What does X-Frame-Options protect against?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "X-Frame-Options helps protect against clickjacking attacks, where a malicious website may embed your page in an iframe to trick users into clicking something they didn’t intend to."
      }
    },
    {
      "@type": "Question",
      "name": "Which is better: DENY or SAMEORIGIN?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "DENY is the strongest option because it blocks all framing, even by your own webpages. SAMEORIGIN is useful when your site legitimately needs to embed its own pages within the same origin but you want to restrict embedding from other websites."
      }
    },
    {
      "@type": "Question",
      "name": "What is ALLOW-FROM and should I use it?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "ALLOW-FROM was intended to allow framing from a specific URL, but it has limited browser support and is considered obsolete. If you need allowlisting, use Content-Security-Policy (CSP) frame-ancestors instead."
      }
    },
    {
      "@type": "Question",
      "name": "Can I allow my page to be embedded on a partner domain?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, but X-Frame-Options is not ideal for allowlisting. The recommended approach is to use CSP frame-ancestors, which supports reliable allowlists across modern browsers."
      }
    },
    {
      "@type": "Question",
      "name": "Do I need CSP frame-ancestors if I already use X-Frame-Options?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Not always. X-Frame-Options is often enough for basic protection. However, frame-ancestors is more flexible and is considered the modern best practice, especially when you need to allow trusted third-party embeds."
      }
    },
    {
      "@type": "Question",
      "name": "Why is my iframe not working?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "If the embedded page sends X-Frame-Options: DENY, it cannot be framed anywhere. If it sends SAMEORIGIN, it can only be framed by pages from the same origin. Browsers will block the iframe when the embedding page is not allowed."
      }
    },
    {
      "@type": "Question",
      "name": "Should I enable framing protection on all pages?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Most websites should protect sensitive pages like login, account, checkout, and admin areas. For public content that must be embedded (like widgets or docs), use CSP frame-ancestors to allow only trusted domains."
      }
    },
    {
      "@type": "Question",
      "name": "Can this header break legitimate embeds on my own site?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. If you use DENY, even your own site can’t embed the page. If your site requires internal embedding, SAMEORIGIN is usually the better choice."
      }
    },
    {
      "@type": "Question",
      "name": "What does this X-Frame-Options Header Test tool check?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "It checks whether the X-Frame-Options header is present and whether it is set to DENY or SAMEORIGIN. It may also highlight when ALLOW-FROM is used and recommend CSP frame-ancestors for allowlisting."
      }
    }
  ]
}
</script>
