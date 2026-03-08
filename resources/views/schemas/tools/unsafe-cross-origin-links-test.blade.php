<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What are cross-origin links?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Cross-origin links are links that take users from your website (origin) to a different website (a different origin/domain). They’re common on the web, but opening them in a new tab without proper attributes can create security risks like reverse tabnabbing."
      }
    },
    {
      "@type": "Question",
      "name": "What's the issue with using target=\"_blank\" without additional attributes?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "When you use target=\"_blank\" without rel=\"noopener\", the newly opened page may be able to access window.opener and potentially redirect your original tab to a malicious page (reverse tabnabbing)."
      }
    },
    {
      "@type": "Question",
      "name": "How can rel=\"noopener\" or rel=\"noreferrer\" attributes help?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "rel=\"noopener\" prevents the opened page from accessing window.opener. rel=\"noreferrer\" does the same and also prevents sending the referrer header. Using them with target=\"_blank\" is a recommended security best practice."
      }
    },
    {
      "@type": "Question",
      "name": "When should I use rel=\"noopener\"?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Use rel=\"noopener\" on any external link that opens in a new tab using target=\"_blank\". It’s especially important for links that point to third-party sites you don’t control."
      }
    },
    {
      "@type": "Question",
      "name": "Do I need noopener/noreferrer for internal links too?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "If the link opens in a new tab, adding rel=\"noopener\" is still a good habit. The bigger risk is with external links, but using it consistently prevents mistakes and improves security hygiene."
      }
    }
  ]
}
</script>
