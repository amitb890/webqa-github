/**
 * Content shown in the "How to fix it?" modal on the analysis report.
 *
 * A single test can fail for several different reasons (a meta title can be
 * missing, too long, too short or badly cased), so the copy is stored per
 * failure reason rather than per test. HowToFix.resolveCase() switches on the
 * test title and inspects the result object returned by the backend to pick the
 * reason that actually applies to this page.
 *
 * Every entry follows the same shape:
 *   name        - name of the error
 *   intro       - brief introduction to the error
 *   fix         - { paragraph, steps[] } explaining how to fix it
 *   consequence - what happens if it is left unfixed
 *   closing     - closing statement
 *   learnMore   - optional documentation URL
 *   video       - optional embed URL
 */
(function (global) {
  "use strict";

  var CONTENT = {
    /* ------------------------------------------------------------------ *
     * Meta Title
     * ------------------------------------------------------------------ */
    "meta_title.missing": {
      name: "Missing Meta Title",
      intro:
        "The <code>&lt;title&gt;</code> element of this page is absent or empty. It is the single strongest on-page signal of what a page is about: search engines use it as the clickable headline in results, browsers use it as the tab label, and social networks fall back to it when no other title is supplied.",
      fix: {
        paragraph:
          "Add one unique <code>&lt;title&gt;</code> element inside the <code>&lt;head&gt;</code> of the page. Write it for a human first, front-load the term the page should rank for, and keep it within the character limit configured for this project so it is not truncated in search results.",
        steps: [
          "Open the template or CMS field that renders the <code>&lt;head&gt;</code> of this page.",
          "Add <code>&lt;title&gt;Your page title&lt;/title&gt;</code> as the first tag after the character set declaration.",
          "Lead with the primary keyword or the concrete thing the page offers, then add your brand after a separator, for example <code>Appointment Scheduling Software | Webqa</code>.",
          "Keep the title within the configured length so search engines do not cut it off mid-sentence.",
          "Confirm no other page on the site uses the same title.",
          "Publish, clear any page or CDN cache, then re-run this test."
        ]
      },
      consequence:
        "Without a title, search engines invent one from your body copy or anchor text. The result is usually a truncated, keyword-less headline that nobody clicks, so the page loses both ranking strength and click-through rate, and browser tabs show a bare URL.",
      closing:
        "A title tag is the cheapest ranking improvement available on any page. Add it once and the fix is permanent."
    },

    "meta_title.too_long": {
      name: "Meta Title Too Long",
      intro:
        "This page has a <code>&lt;title&gt;</code>, but it exceeds the maximum length configured for this project. Search engines render titles inside a fixed pixel width, so anything beyond that budget is replaced with an ellipsis.",
      fix: {
        paragraph:
          "Shorten the title so the meaningful part survives truncation. The first half of a title does the ranking and persuading work, so cut from the end rather than the beginning.",
        steps: [
          "Copy the current title into a text editor and count the characters.",
          "Delete filler words such as \"the\", \"best\", \"your one-stop\" and any repeated keyword.",
          "Move the brand name to the very end, or drop it entirely on deep pages where it adds nothing.",
          "Rewrite so the primary keyword sits within the first 30 characters.",
          "Trim until you are inside the configured limit, then read the result aloud to confirm it still forms a sentence.",
          "Publish the shorter title and re-run this test."
        ]
      },
      consequence:
        "Truncated titles read as unfinished thoughts. Users skim past them, calls to action disappear behind the ellipsis, and any keyword you placed at the end is never seen by the searcher, so it stops contributing to relevance.",
      closing:
        "Treat the character limit as a hard design constraint: if the title does not fit, the page is trying to say too much in one line."
    },

    "meta_title.too_short": {
      name: "Meta Title Too Short",
      intro:
        "The <code>&lt;title&gt;</code> on this page is shorter than the minimum length configured for this project. Very short titles waste the most valuable piece of text real estate a page has and rarely give a searcher enough context to click.",
      fix: {
        paragraph:
          "Expand the title until it describes both the topic and the value of the page. You are not padding it out with keywords, you are answering the question \"why should someone open this result instead of the one above it?\"",
        steps: [
          "Identify the primary search term this page should answer.",
          "Write the title as topic plus qualifier, for example <code>Meta Title Checker</code> becomes <code>Free Meta Title Checker for SEO Audits</code>.",
          "Add a differentiator that appears on the page itself, such as a location, an audience, a format or a year.",
          "Append the brand name after a pipe or dash if the page is commercially important.",
          "Stay under the maximum length so the longer title is still shown in full.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "A one or two word title competes for a keyword with none of the supporting context search engines use to judge relevance. Ranking pages with richer titles will outrank it, and the sparse result attracts far fewer clicks even when it does rank.",
      closing:
        "Aim for a title that would make sense if you read it out with no other information on screen."
    },

    "meta_title.casing": {
      name: "Meta Title Casing Does Not Match Your Standard",
      intro:
        "The title on this page is present and correctly sized, but its capitalisation does not follow the casing rule selected in your project settings. Inconsistent casing across a site looks unpolished in search results, where several of your pages often appear together.",
      fix: {
        paragraph:
          "Rewrite the title using the casing convention your project enforces. Title Case (also called camel casing here) capitalises every significant word; Sentence case capitalises only the first word and proper nouns. Words listed as exclusions in your settings are ignored by the check.",
        steps: [
          "Open Project Settings and note which casing rule is enabled and which words are excluded.",
          "Rewrite the title following that rule exactly, for example <code>How To Fix A Meta Title</code> for Title Case or <code>How to fix a meta title</code> for Sentence case.",
          "Leave acronyms, product names and brand names in their official casing.",
          "Do not capitalise entire words for emphasis; search engines routinely rewrite shouting titles.",
          "Apply the same rule to the H1 so the page reads consistently.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "Nothing breaks, but your search listings look assembled by different people. Mixed casing erodes the sense of a maintained, trustworthy site and makes automated title rewriting by search engines more likely.",
      closing:
        "Casing is a five second edit that keeps every listing on your domain looking like it belongs to the same brand."
    },

    /* ------------------------------------------------------------------ *
     * Meta Description
     * ------------------------------------------------------------------ */
    "meta_description.missing": {
      name: "Missing Meta Description",
      intro:
        "This page has no <code>&lt;meta name=\"description\"&gt;</code> tag, or the tag is empty. The description is the paragraph shown under your title in search results and it is the main piece of sales copy you control in the listing.",
      fix: {
        paragraph:
          "Write one description per page that summarises what the visitor gets, in the visitor's own language. It is not a ranking factor by itself, but it decides how many people choose your result, and click-through rate very much matters.",
        steps: [
          "Add <code>&lt;meta name=\"description\" content=\"...\"&gt;</code> inside the <code>&lt;head&gt;</code> of the page.",
          "Open with the benefit or the answer, not with your company name.",
          "Include the primary keyword naturally so search engines bold it in the snippet.",
          "Finish with a concrete next step such as \"Compare plans\", \"Read the checklist\" or \"Book a demo\".",
          "Keep it inside the configured length so it is not cut short.",
          "Publish, then re-run this test."
        ]
      },
      consequence:
        "When the tag is missing, search engines scrape an arbitrary sentence from the page body. That extract often starts mid-thought, includes navigation text or cookie notices, and reads badly, which measurably reduces clicks on an otherwise well-ranked page.",
      closing:
        "You are writing an advertisement that runs for free, forever. It is worth the two minutes."
    },

    "meta_description.too_long": {
      name: "Meta Description Too Long",
      intro:
        "The meta description on this page is longer than the maximum configured for this project. Search results allocate a fixed amount of space to the snippet, and anything past that point is replaced with an ellipsis.",
      fix: {
        paragraph:
          "Tighten the description so the complete thought, including the call to action, fits in the visible area. Front-load the value and cut anything that repeats the title.",
        steps: [
          "Paste the current description into an editor and count the characters.",
          "Delete any phrase that duplicates wording already present in the title tag.",
          "Remove hedging language such as \"we aim to provide\" and marketing filler such as \"industry-leading\".",
          "Make sure the call to action sits before the character limit, not after it.",
          "Trim to fit the configured maximum and read it back as a single sentence.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "The end of your description, which is usually where the call to action lives, never reaches the searcher. The snippet trails off, looks unedited, and the persuasive part of the copy is wasted.",
      closing:
        "Write to the limit deliberately rather than letting search engines decide where your sentence ends."
    },

    "meta_description.too_short": {
      name: "Meta Description Too Short",
      intro:
        "The meta description exists but falls below the minimum length configured for this project. A very short description leaves most of the snippet area blank, which search engines often fill with text scraped from the page instead.",
      fix: {
        paragraph:
          "Expand the description until it uses the available space to answer the searcher's question and set an expectation about the page.",
        steps: [
          "State what the page is in the first clause.",
          "Add the specific value: what the reader will learn, get or be able to do.",
          "Include one supporting detail such as a number, a format, a price or a timeframe.",
          "Close with an action phrase.",
          "Check the total length sits between the configured minimum and maximum.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "Short descriptions get overridden. Search engines decide your snippet is not informative enough, substitute a body-copy extract, and you lose control of the only paragraph you were able to write for the results page.",
      closing:
        "Use the full space you are given; an empty snippet is a missed pitch."
    },

    /* ------------------------------------------------------------------ *
     * Canonical URL
     * ------------------------------------------------------------------ */
    "canonical.missing": {
      name: "Missing Canonical Tag",
      intro:
        "This page does not declare a canonical URL. The canonical tag tells search engines which address is the authoritative version of a page, which matters because the same content is usually reachable through several URLs: with and without <code>www</code>, over HTTP and HTTPS, with a trailing slash, or with tracking parameters attached.",
      fix: {
        paragraph:
          "Add a self-referencing canonical tag to the <code>&lt;head&gt;</code> of every indexable page. It must be an absolute URL, it must return HTTP 200, and it must match the version of the URL you actually want in the index.",
        steps: [
          "Decide the canonical form for your site: protocol, subdomain and trailing slash convention.",
          "Add <code>&lt;link rel=\"canonical\" href=\"https://example.com/your-page\"&gt;</code> to the page head.",
          "Use the full absolute URL, never a relative path.",
          "Make sure the canonical target itself is not redirected, blocked by robots.txt or marked <code>noindex</code>.",
          "Confirm the tag is rendered in the initial HTML response, not injected later by JavaScript.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "Search engines pick a canonical for you. Link equity is split across duplicate addresses, the wrong URL can end up ranking, parameterised copies compete with the clean version, and you may see the page disappear from results as a duplicate.",
      closing:
        "One line in the head consolidates every variant of this page into a single, stronger URL."
    },

    "canonical.mismatch": {
      name: "Canonical URL Does Not Match This Page",
      intro:
        "This page declares a canonical URL that points somewhere other than itself. That is a valid technique for genuine duplicates, but when it happens unintentionally it tells search engines to ignore this page entirely and index the other one instead.",
      fix: {
        paragraph:
          "Decide whether this page is meant to be a duplicate. If it has content worth ranking, point the canonical at its own URL. If it truly is a duplicate, verify the target is the right one and is reachable.",
        steps: [
          "Compare the canonical value shown in the report against the URL in the address bar.",
          "If the two should be the same, correct the canonical to reference this exact URL, including protocol, subdomain and trailing slash.",
          "Look for the usual culprits: a hard-coded homepage canonical in a shared template, a staging domain left in place, or a CMS plugin overriding the value.",
          "If the mismatch is intentional, confirm the target returns HTTP 200 and is not itself canonicalised elsewhere.",
          "Check that your trailing-slash setting in Project Settings matches how your server actually serves URLs.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "This page will be dropped from search results and all of its ranking signals will be handed to the URL named in the canonical tag. If that tag was copied from a template, an entire section of the site can collapse into a single indexed page.",
      closing:
        "A canonical tag is an instruction, not a hint. Point it deliberately."
    },

    /* ------------------------------------------------------------------ *
     * Robots Meta
     * ------------------------------------------------------------------ */
    "robots_meta.noindex": {
      name: "Page Blocked By A Robots Meta Tag",
      intro:
        "This page carries a robots meta tag containing <code>noindex</code> or <code>nofollow</code>. That is an explicit instruction to search engines not to list the page, and not to follow the links on it. On a live page it is almost always a leftover from development or a misapplied CMS setting.",
      fix: {
        paragraph:
          "Remove the directive, or narrow it so it only applies to pages you genuinely want excluded such as internal search results, thank-you pages and account areas.",
        steps: [
          "Locate <code>&lt;meta name=\"robots\" content=\"noindex, nofollow\"&gt;</code> in the page head.",
          "Check whether it comes from the template, an SEO plugin, or a global \"discourage search engines\" switch left on after launch.",
          "Delete the tag, or replace it with <code>&lt;meta name=\"robots\" content=\"index, follow\"&gt;</code> if your template requires the tag to exist.",
          "Inspect the HTTP response for an <code>X-Robots-Tag</code> header carrying the same directive at the server level.",
          "Request re-indexing in Google Search Console so the page is recrawled rather than waiting for the next natural crawl.",
          "Re-run this test to confirm the directive is gone."
        ]
      },
      consequence:
        "The page cannot appear in search results at all, no matter how good the content or how many links point to it. With <code>nofollow</code> in place, pages linked only from here also stop being discovered, which can quietly de-index a whole subsection.",
      closing:
        "If a page is worth publishing, make sure you have not told search engines to ignore it."
    },

    /* ------------------------------------------------------------------ *
     * Robots.txt
     * ------------------------------------------------------------------ */
    "robots_txt.blocked": {
      name: "URL Blocked By robots.txt",
      intro:
        "Your <code>/robots.txt</code> file contains a rule that disallows crawlers from requesting this URL. Crawlers respect that file before they fetch anything else, so this page is never downloaded and its content is never evaluated.",
      fix: {
        paragraph:
          "Edit robots.txt so the disallow rule stops matching this URL. Remember that rules are prefix matches, so a short pattern can accidentally block far more than intended.",
        steps: [
          "Open <code>https://your-domain/robots.txt</code> and find the <code>Disallow</code> line that matches this path.",
          "Narrow the pattern so it only covers what you meant to block, or remove it if it is obsolete.",
          "Add an explicit <code>Allow</code> rule for this path if it sits under a directory that must stay blocked.",
          "Make sure you have not disallowed the CSS, JavaScript or image directories, since crawlers need those to render the page.",
          "Test the final file with the robots.txt tester in Google Search Console.",
          "Deploy and re-run this test."
        ]
      },
      consequence:
        "The page will not be crawled, so it cannot be indexed on its own merits. Because crawlers never see the HTML, any canonical tag, structured data or internal links on the page are also invisible, and the URL may still appear in results as a bare link with no description.",
      closing:
        "robots.txt controls crawling, not indexing. Use it to protect infrastructure, never to hide content you want ranked."
    },

    "robots_txt.missing": {
      name: "robots.txt Could Not Be Read",
      intro:
        "The crawler was unable to retrieve a usable <code>/robots.txt</code> file for this domain. A missing file is tolerated, but a file that times out or returns a server error is treated as a signal to stop crawling entirely.",
      fix: {
        paragraph:
          "Make sure the file is reachable at the root of the domain and returns either a valid file with HTTP 200 or a clean HTTP 404. Anything in the 5xx range is actively harmful.",
        steps: [
          "Request <code>https://your-domain/robots.txt</code> directly and note the status code.",
          "If it returns a 5xx error, fix the server rule or application route that is intercepting the request.",
          "If the file does not exist, create a minimal one containing <code>User-agent: *</code> followed by <code>Disallow:</code> with no value.",
          "Add a <code>Sitemap:</code> line pointing at your XML sitemap.",
          "Serve it as <code>text/plain</code> from the domain root, not from a subdirectory.",
          "Re-run this test."
        ]
      },
      consequence:
        "A robots.txt that errors out causes crawlers to postpone crawling the whole site as a precaution. Crawl rate drops, new pages take much longer to be discovered, and updates to existing pages are picked up late.",
      closing:
        "A two line robots.txt that loads reliably is better than a clever one that sometimes fails."
    },

    /* ------------------------------------------------------------------ *
     * Headings
     * ------------------------------------------------------------------ */
    "headings.no_h1": {
      name: "Missing H1 Heading",
      intro:
        "This page has no <code>&lt;h1&gt;</code> element. The H1 is the on-page headline: it tells both readers and search engines what the page is about, and it is the anchor point screen readers use to describe the page to users who cannot see the layout.",
      fix: {
        paragraph:
          "Add exactly one H1 that states the subject of the page in plain language, and make it the first heading in the content area.",
        steps: [
          "Identify the visual headline of the page, the large text a reader would call the title.",
          "Mark that text up as <code>&lt;h1&gt;</code> instead of a styled <code>&lt;div&gt;</code>, <code>&lt;p&gt;</code> or <code>&lt;span&gt;</code>.",
          "Keep the H1 closely aligned with the title tag without duplicating it word for word.",
          "Do not put the site logo or the navigation inside the H1.",
          "Use <code>&lt;h2&gt;</code> and <code>&lt;h3&gt;</code> for the sections beneath it so the outline stays sequential.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "Search engines fall back to guessing the page topic from less reliable signals, so relevance for your target term weakens. Screen reader users lose the main landmark for orienting themselves, which is an accessibility failure as well as an SEO one.",
      closing:
        "One clear H1 per page is the simplest structural rule in SEO and it is still the most frequently broken."
    },

    "headings.too_many": {
      name: "Too Many Headings At One Level",
      intro:
        "This page uses more headings at one or more levels than the limit configured in your project settings. Headings are a document outline, not a styling tool, and an outline with dozens of same-level entries no longer communicates any structure.",
      fix: {
        paragraph:
          "Rebuild the heading hierarchy so it describes the shape of the content. One H1, a handful of H2 sections, and H3s nested inside those sections where a section genuinely has sub-parts.",
        steps: [
          "List every heading on the page in document order and note its level.",
          "Reduce the page to a single H1.",
          "Group the remaining headings into a small number of top-level themes and mark those as H2.",
          "Demote the rest to H3 or lower so each one sits under the H2 it belongs to.",
          "Replace headings that exist purely to make text large with a paragraph and a CSS class.",
          "Confirm no level is skipped, then re-run this test."
        ]
      },
      consequence:
        "A flat wall of same-level headings gives search engines no way to work out which parts of the page matter, so keyword emphasis is diluted across everything. Assistive technology users navigating by heading get an unusable list with no hierarchy.",
      closing:
        "If your heading outline would not work as a table of contents, it is not working for search engines either."
    },

    /* ------------------------------------------------------------------ *
     * Images
     * ------------------------------------------------------------------ */
    "images.alt_missing": {
      name: "Images Without Alternate Text",
      intro:
        "One or more images on this page have a missing or empty <code>alt</code> attribute. Alternate text is the textual equivalent of an image: it is read aloud by screen readers, shown when the image fails to load, and used by search engines to understand and rank the image.",
      fix: {
        paragraph:
          "Describe what each image conveys, in the context of the surrounding copy. Write for someone who cannot see the picture, not for a keyword tool.",
        steps: [
          "Work through the image table on this report and note every row flagged for alternate text.",
          "Add <code>alt=\"...\"</code> to each one, describing the content and function of the image in a short phrase.",
          "Include the keyword only where it genuinely describes the image; never repeat it across every image on the page.",
          "For purely decorative images such as spacers, borders and background flourishes, use an explicitly empty <code>alt=\"\"</code> so assistive technology skips them.",
          "If the image is inside a link, make the alt text describe the link destination.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "Screen reader users hear a filename or nothing at all, which is a direct accessibility barrier and a legal exposure in many jurisdictions. You also forfeit image search traffic and lose the keyword context that alt text contributes to the page.",
      closing:
        "Alternate text is the least expensive accessibility improvement you can ship, and it pays back in image search."
    },

    "images.oversized": {
      name: "Image File Size Above The Limit",
      intro:
        "One or more images on this page exceed the maximum file size configured for this project. Images are almost always the largest thing a browser has to download, and oversized files are the most common cause of a slow Largest Contentful Paint.",
      fix: {
        paragraph:
          "Compress and correctly size every offending image. Most oversized images on the web are simply the original upload being scaled down by CSS, which means the visitor downloads far more pixels than the layout will ever display.",
        steps: [
          "Check the rendered dimensions of each flagged image and resize the source file to match, allowing for a 2x version for high-density screens.",
          "Export as WebP or AVIF and keep a JPEG or PNG fallback if you still support older browsers.",
          "Run the files through a compressor and target the configured size limit.",
          "Serve responsive variants with <code>srcset</code> and <code>sizes</code> so phones do not download desktop artwork.",
          "Add <code>loading=\"lazy\"</code> to images below the fold, but never to the hero image.",
          "Re-upload, purge the CDN cache and re-run this test."
        ]
      },
      consequence:
        "Every extra kilobyte delays the point at which the page looks usable. Slow pages lose visitors before they render, fail Core Web Vitals thresholds, and consume mobile data allowances, all of which feed back into lower rankings and conversions.",
      closing:
        "Compressing images is the highest return performance work available on nearly every page."
    },

    "images.filename": {
      name: "Poorly Formed Image File Names",
      intro:
        "One or more image file names on this page break the naming rules configured for this project: uppercase characters, special characters, missing hyphen separators, or a name longer than the permitted length. File names are a genuine ranking signal for image search and they also cause portability problems between servers.",
      fix: {
        paragraph:
          "Rename the offending files to short, lowercase, hyphen-separated descriptions of what the image shows, then update every reference to them.",
        steps: [
          "Review the image table on this report and note each flagged file name.",
          "Rename using lowercase letters, digits and hyphens only, for example <code>IMG_4021 Final(1).JPG</code> becomes <code>blue-running-shoes-side.jpg</code>.",
          "Describe the subject in two to four words and stay inside the configured length limit.",
          "Remove camera defaults, spaces, underscores, ampersands, brackets and percent-encoded characters.",
          "Update the <code>src</code> and <code>srcset</code> references, plus any CSS or database entries pointing at the old names.",
          "Add redirects if the old paths were already indexed, then re-run this test."
        ]
      },
      consequence:
        "Search engines lose a useful clue about image content, so image search visibility suffers. Uppercase and special characters also break on case-sensitive servers and after CDN migrations, producing broken images that are hard to trace.",
      closing:
        "Fix naming at upload time and this test never fails again."
    },

    "images.multiple": {
      name: "Multiple Image Problems Detected",
      intro:
        "Several different image issues were found on this page, spanning alternate text, file size and file naming. Images typically account for most of a page's download weight and a large share of its accessibility surface, so they are worth auditing together rather than one at a time.",
      fix: {
        paragraph:
          "Use the image table on this report as a worklist. Fix everything on one image before moving to the next, so each file is handled once.",
        steps: [
          "Sort the image table by file size and deal with the heaviest files first: resize to their rendered dimensions, then convert to WebP or AVIF.",
          "Add descriptive <code>alt</code> text to every image that is missing it, and an explicit empty <code>alt=\"\"</code> to decorative ones.",
          "Rename files to lowercase, hyphen-separated, descriptive names within the configured length.",
          "Add <code>width</code> and <code>height</code> attributes to every image so the browser reserves space and avoids layout shift.",
          "Apply <code>loading=\"lazy\"</code> below the fold and leave the hero image eager.",
          "Purge caches and re-run this test to confirm every row passes."
        ]
      },
      consequence:
        "Left as they are, these images slow the page down, fail Core Web Vitals, exclude screen reader users, and give up image search traffic. Because the problems compound, the page ends up losing on performance, accessibility and discovery at once.",
      closing:
        "One pass through the image table clears the largest cluster of issues on most pages."
    },

    /* ------------------------------------------------------------------ *
     * URL Slug
     * ------------------------------------------------------------------ */
    "url_slug.uppercase": {
      name: "Uppercase Characters In The URL",
      intro:
        "The slug for this page contains uppercase characters. Paths are case sensitive on most web servers, so <code>/About-Us</code> and <code>/about-us</code> are two different resources that can both be crawled and indexed.",
      fix: {
        paragraph:
          "Move to an all-lowercase URL and redirect the mixed-case version to it, so only one form is ever reachable.",
        steps: [
          "Change the slug for this page to lowercase in your CMS or router.",
          "Add a permanent 301 redirect from the old mixed-case URL to the new one.",
          "Add a server rule that lowercases incoming paths, so future mistakes self-correct.",
          "Update internal links, menus and sitemap entries to the lowercase form.",
          "Point the canonical tag at the lowercase URL.",
          "Re-run this test."
        ]
      },
      consequence:
        "The same content is indexed at two addresses, which splits link equity between them and can trigger duplicate content filtering. Visitors who type or paste the wrong case reach a 404, and analytics reports the page as two separate entries.",
      closing:
        "Lowercase URLs everywhere is a rule with no exceptions worth making."
    },

    "url_slug.numbers": {
      name: "Numbers In The URL Slug",
      intro:
        "The slug contains numeric characters, which your project settings disallow. Numbers in URLs are usually database identifiers, dates or pagination artefacts, and they tie the address to an implementation detail rather than to the content.",
      fix: {
        paragraph:
          "Replace the numeric portion with descriptive words wherever the number does not carry meaning for the reader.",
        steps: [
          "Decide whether the number is meaningful, as in a model number or a year in a report title.",
          "If it is not meaningful, rewrite the slug using words only, for example <code>/product/48213</code> becomes <code>/product/wireless-noise-cancelling-headphones</code>.",
          "Avoid burying dates in the path unless the content is genuinely dated, because it makes evergreen updates look stale.",
          "Add a 301 redirect from the old numeric URL.",
          "Update internal links, the sitemap and the canonical tag.",
          "Re-run this test."
        ]
      },
      consequence:
        "Opaque URLs tell a searcher nothing before they click, which lowers click-through rate. They also make the address fragile: changing the underlying record or CMS can change the number and silently break every link pointing at it.",
      closing:
        "A URL a person could read out over the phone is a URL that will still work in five years."
    },

    "url_slug.special_characters": {
      name: "Special Characters In The URL Slug",
      intro:
        "The slug contains characters outside the safe set of lowercase letters, digits and hyphens. Anything else has to be percent-encoded, which produces long unreadable URLs and inconsistent behaviour across browsers, mail clients and chat applications.",
      fix: {
        paragraph:
          "Reduce the slug to a clean ASCII, hyphen-separated string and redirect the old address.",
        steps: [
          "Remove spaces, ampersands, plus signs, percent signs, brackets, quotes and commas from the slug.",
          "Transliterate accented and non-Latin characters into ASCII where your audience is served by it, for example <code>café</code> becomes <code>cafe</code>.",
          "Replace every separator with a single hyphen and collapse any repeats.",
          "Add a 301 redirect from the encoded URL to the clean one.",
          "Update internal links, sitemap entries and the canonical tag.",
          "Re-run this test."
        ]
      },
      consequence:
        "Encoded URLs get truncated when shared, break when pasted into plain-text contexts, and are frequently mangled by link auto-detection. Some crawlers treat the encoded and decoded forms as separate URLs, creating duplicates.",
      closing:
        "Letters, digits and hyphens will carry any slug you need. Nothing else is worth the trouble."
    },

    "url_slug.too_long": {
      name: "URL Slug Too Long",
      intro:
        "The slug is longer than the maximum configured for this project. Long URLs are truncated in search results, hard to share, and usually a sign that the whole title has been pasted into the address.",
      fix: {
        paragraph:
          "Shorten the slug to the few words that identify the page, keeping the most distinctive term.",
        steps: [
          "Strip stop words such as \"a\", \"the\", \"and\", \"of\" and \"for\" from the slug.",
          "Reduce it to three to five meaningful words that still describe the page.",
          "Remove any directory levels that add no navigational value, for example <code>/blog/articles/2024/posts/</code>.",
          "Keep the primary keyword and drop the rest of the sentence.",
          "Add a 301 redirect from the long URL, then update internal links and the sitemap.",
          "Re-run this test."
        ]
      },
      consequence:
        "Truncated URLs in search results look untrustworthy and reduce clicks. Very long paths are also more likely to be broken by email clients and messaging apps that wrap or shorten them.",
      closing:
        "Short URLs are easier to link to, and links are still the currency of search."
    },

    "url_slug.separator": {
      name: "Words In The URL Are Not Separated Correctly",
      intro:
        "The slug does not use the word separator your project requires. Search engines split words on hyphens; other characters, or no separator at all, mean a multi-word slug is read as one unrecognisable token.",
      fix: {
        paragraph:
          "Re-write the slug so every word boundary uses the configured separator, then redirect the old form.",
        steps: [
          "Check Project Settings for whether hyphens or underscores are required.",
          "Rewrite the slug so each word boundary uses that separator, for example <code>/metatitlechecker</code> or <code>/meta_title_checker</code> becomes <code>/meta-title-checker</code>.",
          "Collapse repeated separators and remove any leading or trailing ones.",
          "Add a 301 redirect from the old URL.",
          "Update internal links, the sitemap and the canonical tag.",
          "Re-run this test."
        ]
      },
      consequence:
        "Run-together slugs stop the individual keywords in the URL from being recognised, so the address contributes nothing to relevance. It is also harder for a reader to parse the URL and decide whether the page is what they want.",
      closing:
        "Consistent separators make URLs readable by both people and crawlers."
    },

    "url_slug.stop_words": {
      name: "Stop Words In The URL Slug",
      intro:
        "The slug contains words from the stop-word list configured for this project. Words such as \"the\", \"and\", \"of\" and \"for\" add length to a URL without adding meaning or search relevance.",
      fix: {
        paragraph:
          "Remove the stop words, keeping the slug grammatical enough to read, and redirect the previous address.",
        steps: [
          "Open Project Settings and review the stop-word list in use.",
          "Delete those words from the slug, for example <code>/the-best-guide-to-fixing-a-meta-title</code> becomes <code>/fix-meta-title-guide</code>.",
          "Keep a stop word only where removing it changes the meaning, as in <code>/state-of-the-art</code>.",
          "Confirm the shortened slug is still unique across the site.",
          "Add a 301 redirect, then update internal links and the sitemap.",
          "Re-run this test."
        ]
      },
      consequence:
        "The URL is longer than it needs to be, so it is truncated earlier in search results and the keywords that matter get pushed out of view. It is a small loss, but it applies to every impression the page ever receives.",
      closing:
        "Trim the connective tissue and let the keywords carry the URL."
    },

    "url_slug.multiple": {
      name: "Multiple URL Slug Problems",
      intro:
        "The slug for this page breaks more than one of the URL rules configured for your project. Because changing a URL means putting a redirect in place, it is worth fixing every issue in a single edit rather than revising the address repeatedly.",
      fix: {
        paragraph:
          "Design the final slug once, using every rule at the same time, then move to it in one step.",
        steps: [
          "Write the target slug: lowercase, hyphen-separated, no special characters, no stop words, no gratuitous numbers, within the configured length.",
          "Check it is unique and does not collide with an existing route.",
          "Update the slug in your CMS or router.",
          "Add a single 301 redirect from the old URL to the new one.",
          "Update internal links, navigation, the XML sitemap and the canonical tag together.",
          "Re-run this test and confirm every rule now passes."
        ]
      },
      consequence:
        "Each unfixed rule chips away at how readable, shareable and portable the URL is, and every additional round of URL changes adds another redirect hop that slows the page and dilutes link equity.",
      closing:
        "Change a URL once, deliberately, and it will not need touching again."
    },

    /* ------------------------------------------------------------------ *
     * Broken Links
     * ------------------------------------------------------------------ */
    "broken_links.found": {
      name: "Broken Links On The Page",
      intro:
        "One or more links on this page point at URLs that do not resolve successfully. Every broken link is a dead end for a visitor and a wasted crawl request for a search engine.",
      fix: {
        paragraph:
          "Work through the link table on this report and deal with each failing URL according to why it fails. Client errors mean the target is gone or mistyped; server errors mean the target exists but is failing.",
        steps: [
          "Open the broken links list and note the status code returned for each URL.",
          "For 404s, correct the typo, restore the missing page, or point the link at the closest equivalent that still exists.",
          "For 5xx responses, investigate the destination server rather than the link; the address is right but the target is failing.",
          "For links to sites you do not control, replace them with a current source or an archived copy.",
          "Remove links that no longer serve a purpose instead of pointing them at the homepage.",
          "Publish and re-run this test to confirm the list is clear."
        ]
      },
      consequence:
        "Visitors hit error pages and leave, which raises bounce rate on the referring page. Crawl budget is spent fetching URLs that return nothing, link equity flowing through those links is lost, and a page full of dead links reads as unmaintained to both users and search engines.",
      closing:
        "Broken links accumulate silently as a site grows. Clearing them is routine maintenance with an immediate payoff."
    },

    "broken_links.unreachable": {
      name: "Page Links Could Not Be Checked",
      intro:
        "The crawler was unable to parse the links on this page, which usually means the HTML could not be retrieved or was returned in an unexpected form. Until the page can be read, its outbound links cannot be validated.",
      fix: {
        paragraph:
          "Make sure the page returns complete HTML to an ordinary HTTP request, without depending on JavaScript execution or on a bot-detection challenge being solved.",
        steps: [
          "Request the URL with a plain HTTP client and check the status code and the body you get back.",
          "Confirm the response is HTML and not a challenge page, a login redirect or a rate-limit notice.",
          "Whitelist the crawler in your firewall, WAF or bot-protection service if it is being blocked.",
          "If the links are injected by client-side JavaScript, add server-rendered markup so they exist in the initial response.",
          "Check for a request timeout caused by a slow server response.",
          "Re-run this test."
        ]
      },
      consequence:
        "If our crawler cannot read the page, search engine crawlers most likely cannot either. Content that is never fetched is never indexed, and broken links inside it stay invisible until a visitor finds them.",
      closing:
        "Make the raw HTML response complete and correct, and every other test on this page becomes reliable too."
    },

    /* ------------------------------------------------------------------ *
     * XML Sitemap
     * ------------------------------------------------------------------ */
    "xml_sitemap.not_listed": {
      name: "Page Not Listed In The XML Sitemap",
      intro:
        "Your XML sitemap was found and parsed, but this URL does not appear in it. A sitemap is how you tell search engines which pages you consider important and when they last changed; anything missing from it relies purely on being discovered through internal links.",
      fix: {
        paragraph:
          "Add this URL to the sitemap in exactly the form you want indexed, and make sure the sitemap is regenerated whenever content changes.",
        steps: [
          "Open your sitemap and confirm the URL is genuinely absent rather than listed in a different form.",
          "Add a <code>&lt;url&gt;</code> entry containing the absolute, canonical address of this page.",
          "Match the canonical exactly: same protocol, same subdomain, same trailing slash convention.",
          "Make sure your CMS or build step regenerates the sitemap automatically on publish.",
          "Reference the sitemap from robots.txt with a <code>Sitemap:</code> line and submit it in Google Search Console.",
          "Re-run this test."
        ]
      },
      consequence:
        "Discovery slows down. New and updated pages wait for a crawler to follow an internal link rather than being flagged directly, which delays indexing by days or weeks and can leave deep pages permanently unfound.",
      closing:
        "A sitemap does not force indexing, but leaving a page out of it removes your clearest way to ask."
    },

    "xml_sitemap.missing": {
      name: "XML Sitemap Not Found",
      intro:
        "No usable XML sitemap could be loaded for this site. Either the file does not exist, the configured location is wrong, or the response was not valid XML.",
      fix: {
        paragraph:
          "Generate a valid sitemap, publish it at a stable URL, and tell search engines where it is.",
        steps: [
          "Generate a sitemap with your CMS, framework or a crawler, listing only canonical, indexable, HTTP 200 URLs.",
          "Publish it at a predictable path such as <code>/sitemap.xml</code> and serve it as <code>application/xml</code>.",
          "Split into a sitemap index if you exceed 50,000 URLs or 50 MB uncompressed.",
          "Add a <code>Sitemap:</code> line to robots.txt pointing at the absolute URL.",
          "Submit the sitemap in Google Search Console and Bing Webmaster Tools, then check the parse report for errors.",
          "Re-run this test."
        ]
      },
      consequence:
        "Without a sitemap, search engines have to find every page by crawling links. Orphaned pages are never discovered, large sites are crawled inefficiently, and you lose the reporting that tells you how many of your submitted URLs are actually indexed.",
      closing:
        "A sitemap is the cheapest crawl-efficiency improvement available for a site of any size."
    },

    /* ------------------------------------------------------------------ *
     * HTML Sitemap
     * ------------------------------------------------------------------ */
    "html_sitemap.not_listed": {
      name: "Page Not Listed In The HTML Sitemap",
      intro:
        "Your HTML sitemap page does not link to this URL. Unlike the XML sitemap, an HTML sitemap is a real page for real visitors, and it doubles as a reliable internal link source that helps crawlers reach deep content.",
      fix: {
        paragraph:
          "Add a link to this page from the HTML sitemap, grouped under the section it belongs to, and keep the list generated rather than hand-maintained.",
        steps: [
          "Open your HTML sitemap page and locate the section this page belongs to.",
          "Add a normal <code>&lt;a href&gt;</code> link using the canonical URL and descriptive anchor text.",
          "Generate the list programmatically so new pages appear without manual work.",
          "Keep the sitemap reachable from the site footer so both visitors and crawlers can find it.",
          "If the list has grown very large, paginate or split it by section instead of publishing thousands of links on one page.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "Pages with no internal links pointing at them are effectively orphaned: crawlers struggle to reach them, they accumulate no internal link equity, and visitors browsing your structure never encounter them.",
      closing:
        "An HTML sitemap is a safety net that catches the pages your navigation forgot."
    },

    "html_sitemap.missing": {
      name: "HTML Sitemap Not Found",
      intro:
        "No HTML sitemap could be located or read at the configured address. It is optional, but on larger sites it is a useful way to guarantee every published page has at least one internal link pointing at it.",
      fix: {
        paragraph:
          "Publish a single page that links to every important URL on the site, organised by section, and link to it from the footer.",
        steps: [
          "Create a page at a stable path such as <code>/sitemap</code>.",
          "Generate the link list from the same source of truth as your navigation so it never drifts.",
          "Group links under headings that mirror your site structure and use descriptive anchor text.",
          "Link to the page from the global footer.",
          "Confirm the page is indexable, returns HTTP 200 and is not blocked by robots.txt.",
          "Update the sitemap location in Project Settings and re-run this test."
        ]
      },
      consequence:
        "Deep pages that are not surfaced by navigation, search or category listings can end up with no internal links at all, which makes them very hard for crawlers to discover and effectively invisible to search.",
      closing:
        "One generated page can guarantee that nothing you publish is orphaned."
    },

    /* ------------------------------------------------------------------ *
     * Open Graph Tags
     * ------------------------------------------------------------------ */
    "og.title": {
      name: "Open Graph Title Problem",
      intro:
        "The <code>og:title</code> tag on this page is missing, outside the configured length, or does not match the meta title as your settings require. Open Graph tags control how a URL is rendered when it is shared on Facebook, LinkedIn, WhatsApp, Slack and most other platforms.",
      fix: {
        paragraph:
          "Set an explicit <code>og:title</code> in the page head that reads well as a social card headline and satisfies the rules configured for this project.",
        steps: [
          "Add <code>&lt;meta property=\"og:title\" content=\"...\"&gt;</code> to the <code>&lt;head&gt;</code>.",
          "Write a headline that stands alone without the surrounding page, since a shared card carries no other context.",
          "Keep it within the configured minimum and maximum length so it is not clipped in the card.",
          "If your settings require the Open Graph title to match the meta title, keep the two in sync in your template rather than editing them separately.",
          "Use the Facebook Sharing Debugger or LinkedIn Post Inspector to re-scrape the URL and clear the cached card.",
          "Re-run this test."
        ]
      },
      consequence:
        "Shared links fall back to whatever text the platform can scrape, which is often the site name or a fragment of navigation. Cards with weak headlines get far fewer clicks, so every share of this page returns less traffic than it should.",
      closing:
        "You only get one social card per URL, and platforms cache it aggressively. Set it deliberately before the page is shared."
    },

    "og.description": {
      name: "Open Graph Description Problem",
      intro:
        "The <code>og:description</code> tag is missing, outside the configured length, or does not match the meta description as your settings require. This is the supporting line of text beneath the headline on a social share card.",
      fix: {
        paragraph:
          "Add an <code>og:description</code> that gives a reader enough reason to click without needing the rest of the page.",
        steps: [
          "Add <code>&lt;meta property=\"og:description\" content=\"...\"&gt;</code> to the page head.",
          "Summarise the value of the page in one or two sentences written for a social feed rather than a search result.",
          "Keep it inside the configured length limits so nothing is truncated on the card.",
          "Keep it consistent with the meta description if your project settings require the two to match.",
          "Re-scrape the URL in the Facebook Sharing Debugger to refresh the cached card.",
          "Re-run this test."
        ]
      },
      consequence:
        "Platforms substitute an arbitrary extract from the page, which often turns out to be a cookie notice, a menu label or a half sentence. The card looks careless and share performance drops accordingly.",
      closing:
        "Two lines of copy decide how this page performs every time somebody shares it."
    },

    "og.image": {
      name: "Open Graph Image Problem",
      intro:
        "The <code>og:image</code> tag is missing, unreachable, or does not meet the dimensions configured for this project. The image is by far the largest element of a social card and the main reason a link gets noticed in a feed.",
      fix: {
        paragraph:
          "Provide one absolute, publicly reachable image URL at the required dimensions, and declare its size so platforms can lay out the card before the file finishes downloading.",
        steps: [
          "Add <code>&lt;meta property=\"og:image\" content=\"https://example.com/share.png\"&gt;</code> using an absolute URL, never a relative path.",
          "Export the image at the dimensions required by your project settings, commonly 1200 by 630 pixels for a landscape card.",
          "Add <code>og:image:width</code>, <code>og:image:height</code> and <code>og:image:alt</code> alongside it.",
          "Serve the file over HTTPS, keep it under about 5 MB, and make sure it is not blocked by robots.txt or behind authentication.",
          "Keep important text away from the outer edges, since platforms crop cards differently.",
          "Re-scrape the URL in the Facebook Sharing Debugger, then re-run this test."
        ]
      },
      consequence:
        "Without a valid image the platform either shows a bare text link or picks an arbitrary image from the page, such as a logo or an icon. Text-only cards occupy a fraction of the space in a feed and attract dramatically fewer clicks.",
      closing:
        "The share image is the most visible asset on this page for everyone who arrives through social."
    },

    "og.url": {
      name: "Open Graph URL Problem",
      intro:
        "The <code>og:url</code> tag is missing, too long, or does not match this page's address. This tag is the canonical identity of the page for social platforms: it is the address they attribute shares, likes and comments to.",
      fix: {
        paragraph:
          "Set <code>og:url</code> to the absolute canonical address of this page so every share of every variant accumulates against one URL.",
        steps: [
          "Add <code>&lt;meta property=\"og:url\" content=\"https://example.com/your-page\"&gt;</code> to the page head.",
          "Use the same value as the canonical tag, matching protocol, subdomain and trailing slash exactly.",
          "Strip tracking parameters such as <code>utm_*</code> so shares from campaigns do not fragment the count.",
          "Make sure the URL returns HTTP 200 and is not redirected.",
          "Generate the value from the same helper that produces the canonical tag so the two cannot drift apart.",
          "Re-scrape the URL and re-run this test."
        ]
      },
      consequence:
        "Share counts and engagement get split across URL variants, so a page that has been shared widely looks unpopular. Worse, a wrong <code>og:url</code> can make shares of this page resolve to a different page entirely.",
      closing:
        "One canonical address for search, and the same one for social."
    },

    "og.blocked": {
      name: "Open Graph Tags Could Not Be Read",
      intro:
        "No Open Graph tags could be read from this page, and the response looked like a bot-protection or firewall challenge rather than your actual HTML. The tags may well be present, but nothing that fetches the page as a bot can see them.",
      fix: {
        paragraph:
          "Allow legitimate crawlers and social scrapers to receive the real HTML response instead of a challenge page.",
        steps: [
          "Request the URL with a plain HTTP client and inspect the body you receive.",
          "If it is a challenge, CAPTCHA or rate-limit page, adjust the rules in your CDN, WAF or bot-management service.",
          "Whitelist the recognised social scraper user agents, including <code>facebookexternalhit</code>, <code>Twitterbot</code>, <code>LinkedInBot</code> and <code>Slackbot</code>.",
          "Set browser-integrity and security-level rules to skip requests for public content pages.",
          "Confirm the fix with the Facebook Sharing Debugger, which reports exactly what it received.",
          "Re-run this test."
        ]
      },
      consequence:
        "Every share of this page renders as a plain link with no title, description or image, because no platform can fetch the metadata. The same protection usually blocks search engine crawlers too, which puts indexing at risk.",
      closing:
        "Security rules should stop abuse, not stop the crawlers you depend on for traffic."
    },

    /* ------------------------------------------------------------------ *
     * Twitter Tags
     * ------------------------------------------------------------------ */
    "twitter.title": {
      name: "Twitter Card Title Problem",
      intro:
        "The <code>twitter:title</code> tag is missing, outside the configured length, or does not match the meta title as your settings require. Twitter and X read these tags to build the preview card shown when your URL is posted.",
      fix: {
        paragraph:
          "Declare an explicit Twitter card title, together with the card type, so the preview is predictable rather than inherited.",
        steps: [
          "Add <code>&lt;meta name=\"twitter:card\" content=\"summary_large_image\"&gt;</code> to the page head.",
          "Add <code>&lt;meta name=\"twitter:title\" content=\"...\"&gt;</code> with a headline written for a timeline.",
          "Keep it inside the configured length so it is not clipped in the card.",
          "Keep it aligned with the meta title if your project settings require the two to match.",
          "Validate with the Card Validator, then re-run this test."
        ]
      },
      consequence:
        "The card falls back to Open Graph values or to scraped page text. In the worst case the post renders as a naked URL, which looks like spam in a timeline and is scrolled past.",
      closing:
        "A card title is short-form copy that has to work on its own. Write it once and it serves every post."
    },

    "twitter.image": {
      name: "Twitter Card Image Problem",
      intro:
        "The <code>twitter:image</code> tag is missing, unreachable, or does not meet the dimensions configured for this project. The image is what stops a scroll, so a card without one is close to invisible.",
      fix: {
        paragraph:
          "Supply one absolute HTTPS image URL at the dimensions your settings require, and declare the card type that matches the image shape.",
        steps: [
          "Add <code>&lt;meta name=\"twitter:image\" content=\"https://example.com/card.png\"&gt;</code> using an absolute URL.",
          "Export at the required dimensions, commonly 1200 by 675 pixels for a large summary card.",
          "Set <code>twitter:card</code> to <code>summary_large_image</code> for a full-width image or <code>summary</code> for a thumbnail.",
          "Serve over HTTPS, keep the file under 5 MB, and use JPEG, PNG, WebP or a static GIF.",
          "Make sure the file is not blocked by robots.txt or served behind authentication.",
          "Validate the card and re-run this test."
        ]
      },
      consequence:
        "Posts linking to this page render as small text-only cards. They take up a fraction of the space in a timeline and earn a fraction of the clicks, so social distribution of this page underperforms permanently.",
      closing:
        "One correctly sized image turns a link into a piece of content people notice."
    },

    "twitter.image_alt": {
      name: "Twitter Card Image Alt Problem",
      intro:
        "The <code>twitter:image:alt</code> tag is missing or exceeds the configured length. This is the alternate text for the card image, read aloud by screen readers to users browsing their timeline.",
      fix: {
        paragraph:
          "Describe the card image in one short sentence, within the character limit your settings allow.",
        steps: [
          "Add <code>&lt;meta name=\"twitter:image:alt\" content=\"...\"&gt;</code> next to the image tag.",
          "Describe what the image shows and why it is relevant, not the file name.",
          "Stay within the configured maximum length so the value is not rejected.",
          "Avoid stuffing keywords; the text is read aloud to a person.",
          "Validate the card and re-run this test."
        ]
      },
      consequence:
        "Screen reader users get no description of the card image, so a share of this page is less accessible than it needs to be. It is a small omission that excludes real people for no reason.",
      closing:
        "One sentence makes your social presence usable for everyone who encounters it."
    },

    /* ------------------------------------------------------------------ *
     * Favicon
     * ------------------------------------------------------------------ */
    "favicon.missing": {
      name: "Missing Favicon",
      intro:
        "No favicon could be found for this page. The favicon is the small icon that identifies your site in browser tabs, bookmark lists, history, mobile home screens and, increasingly, in search results themselves.",
      fix: {
        paragraph:
          "Publish an icon set and declare it in the page head so every context has an appropriately sized file to use.",
        steps: [
          "Create a square source image of at least 512 by 512 pixels with a simple, legible mark.",
          "Export the sizes browsers ask for, typically 16, 32, 48, 180 and 512 pixels.",
          "Place <code>favicon.ico</code> at the domain root so clients that request it directly succeed.",
          "Declare the rest in the head with <code>&lt;link rel=\"icon\"&gt;</code> and <code>&lt;link rel=\"apple-touch-icon\"&gt;</code>.",
          "Add a web app manifest referencing the larger icons for installable and mobile use.",
          "Hard refresh, since browsers cache favicons aggressively, then re-run this test."
        ]
      },
      consequence:
        "Your tab shows a generic placeholder, which makes the site hard to pick out among a dozen open tabs and harder to recognise in a bookmark list. Search results that display favicons show a blank space next to your listing, which reads as unfinished next to competitors.",
      closing:
        "A favicon is a one-time setup task that improves recognition everywhere your site appears."
    },

    "favicon.dimensions": {
      name: "Favicon Dimensions Do Not Meet Requirements",
      intro:
        "A favicon was found, but its dimensions do not match the size rules configured for this project. Icons that are too small look blurry when scaled up, and non-square icons get stretched or cropped unpredictably.",
      fix: {
        paragraph:
          "Re-export the icon from a large square source at the required dimensions, and provide several sizes so each client picks the right one.",
        steps: [
          "Start from a square source image of at least 512 by 512 pixels; never upscale a small icon.",
          "Export the exact dimensions required by your project settings.",
          "Provide multiple sizes and declare each with its own <code>&lt;link rel=\"icon\" sizes=\"...\"&gt;</code> entry.",
          "Simplify the artwork so it stays legible at 16 pixels; fine detail and small text disappear entirely.",
          "Replace the files, purge your CDN cache, and hard refresh the browser.",
          "Re-run this test."
        ]
      },
      consequence:
        "The icon renders soft, stretched or cropped depending on the client. It is a small detail, but it is displayed next to your brand name in every tab, bookmark and search listing, and a blurry mark undermines the impression of a professionally maintained site.",
      closing:
        "Export once from a large square source and the icon looks sharp in every context."
    },

    /* ------------------------------------------------------------------ *
     * Meta Viewport
     * ------------------------------------------------------------------ */
    "viewport.missing": {
      name: "Missing Meta Viewport Tag",
      intro:
        "This page has no <code>&lt;meta name=\"viewport\"&gt;</code> tag. Without it, mobile browsers assume the page was built for a desktop screen, render it at around 980 pixels wide and shrink the whole thing to fit, leaving text too small to read.",
      fix: {
        paragraph:
          "Add the standard responsive viewport declaration to the head of every page, and make sure your CSS actually adapts to the width it reports.",
        steps: [
          "Add <code>&lt;meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"&gt;</code> inside the <code>&lt;head&gt;</code>.",
          "Place it in the shared layout template so it applies site-wide.",
          "Do not add <code>user-scalable=no</code> or a <code>maximum-scale</code> below 5, because both block pinch-zoom and fail accessibility requirements.",
          "Check your CSS uses relative units and media queries rather than fixed pixel widths.",
          "Test on a real phone as well as in device emulation.",
          "Re-run this test."
        ]
      },
      consequence:
        "Mobile visitors get a zoomed-out desktop layout they have to pinch and pan to read. Search engines treat the page as not mobile friendly, which directly affects ranking under mobile-first indexing, and most mobile visitors leave rather than fight the layout.",
      closing:
        "One line of markup is the difference between a usable mobile page and an unusable one."
    },

    /* ------------------------------------------------------------------ *
     * Doctype
     * ------------------------------------------------------------------ */
    "doctype.missing": {
      name: "Missing Or Invalid Doctype",
      intro:
        "This page does not start with a valid HTML5 doctype declaration. Without it, browsers fall back to quirks mode, an emulation of pre-standards behaviour that changes how the box model, layout and CSS inheritance work.",
      fix: {
        paragraph:
          "Make <code>&lt;!DOCTYPE html&gt;</code> the very first thing in the response, before any other output.",
        steps: [
          "Add <code>&lt;!DOCTYPE html&gt;</code> as the first line of your base layout template.",
          "Make sure nothing is emitted before it: no blank lines, HTML comments, BOM characters or stray output from an include.",
          "Remove any legacy XHTML or HTML 4 doctype and replace it with the short HTML5 form.",
          "Check for PHP files with whitespace after a closing tag, a very common cause of output before the doctype.",
          "Load the page and confirm the browser reports standards mode rather than quirks mode.",
          "Re-run this test."
        ]
      },
      consequence:
        "Quirks mode changes box sizing and layout rules, so the page renders inconsistently across browsers and small CSS differences turn into visible breakage. Bugs of this kind are notoriously hard to diagnose because the CSS itself is correct.",
      closing:
        "Fifteen characters at the top of the document guarantee every browser follows the same rules."
    },

    /* ------------------------------------------------------------------ *
     * HTTP Status Code
     * ------------------------------------------------------------------ */
    "http_status.redirect": {
      name: "URL Responds With A Redirect",
      intro:
        "This URL does not serve content directly; it returns a redirect to another address. Redirects are legitimate, but a URL you are auditing, linking to or submitting in a sitemap should normally be the final destination rather than a stop along the way.",
      fix: {
        paragraph:
          "Decide which URL is the real one and make everything point straight at it, so no visitor or crawler has to follow a hop.",
        steps: [
          "Trace the full redirect chain and note the final destination and the status code at each step.",
          "Update internal links, menus, sitemap entries and canonical tags to reference the final URL directly.",
          "Collapse multi-step chains into a single 301 so at most one hop is ever needed.",
          "Use 301 for permanent moves and 302 only for genuinely temporary ones.",
          "Check your accepted status codes in Project Settings if you intend this URL to redirect permanently.",
          "Re-run this test."
        ]
      },
      consequence:
        "Every hop adds a round trip before the page starts loading, which is most noticeable on mobile connections. Redirect chains also dilute link equity, waste crawl budget, and can end in loops that make the content unreachable.",
      closing:
        "Link to the destination, not to the doormat."
    },

    "http_status.client_error": {
      name: "URL Returns A Client Error",
      intro:
        "This URL responded with a 4xx status code, meaning the server understood the request but will not serve the page. Common causes are a deleted page, a mistyped path, an authentication requirement, or a rule blocking the request.",
      fix: {
        paragraph:
          "Work out whether the URL should exist. If it should, restore or repair it; if it should not, make sure nothing still points at it.",
        steps: [
          "Note the exact status code, because 404, 401, 403 and 410 each mean something different.",
          "For 404, restore the page or 301 redirect the URL to the closest surviving equivalent.",
          "For 401 or 403, check whether authentication, an IP allow-list or a WAF rule is intercepting the request.",
          "For 410, confirm the removal was intentional and remove remaining internal links to the URL.",
          "Update sitemap entries, internal links and any external references you control.",
          "Re-run this test."
        ]
      },
      consequence:
        "The page cannot be indexed and cannot be read by visitors. Every internal link pointing at it leaks link equity into a dead end, and if the URL previously ranked, that traffic disappears until the address resolves again.",
      closing:
        "A 4xx on a URL you are auditing means the content is unreachable. Nothing else about the page matters until that is fixed."
    },

    "http_status.server_error": {
      name: "URL Returns A Server Error",
      intro:
        "This URL responded with a 5xx status code, which means the server failed while trying to produce the page. Unlike a 404, the address is valid, so this is an application or infrastructure fault rather than a content problem.",
      fix: {
        paragraph:
          "Treat this as an incident. Find the failure in your logs, fix the underlying cause, and confirm the page returns HTTP 200 consistently rather than intermittently.",
        steps: [
          "Check your application and web server error logs for the request and read the stack trace or error entry.",
          "Reproduce the failure directly to confirm it is consistent and not load related.",
          "Look at the usual causes: an uncaught exception, a database connection failure, a memory or execution timeout, or a bad deployment.",
          "Fix the cause and deploy, then request the URL repeatedly to confirm it is stable.",
          "Add uptime monitoring on this URL so the next occurrence is caught before a crawler finds it.",
          "Re-run this test."
        ]
      },
      consequence:
        "Visitors see an error page instead of your content. Search engines that encounter repeated 5xx responses reduce crawl rate across the whole site and will eventually drop affected pages from the index, and recovery takes far longer than the outage itself.",
      closing:
        "Server errors are the most damaging status code in SEO because they undermine trust in the entire domain, not just one page."
    },

    "http_status.unexpected": {
      name: "Unexpected HTTP Status Code",
      intro:
        "This URL returned a status code that is not in the accepted list configured for this project. The page may still render, but responding with an unexpected code changes how crawlers, caches and monitoring treat it.",
      fix: {
        paragraph:
          "Make the response code match what the page actually is, then confirm your accepted codes in Project Settings reflect how the site is intended to behave.",
        steps: [
          "Note the code returned and compare it against the accepted list in Project Settings.",
          "Confirm the code is semantically correct: 200 for content served, 301 for a permanent move, 404 for content that does not exist.",
          "Look for middleware, a CDN rule or a caching layer overriding the application's response.",
          "Fix the response at the layer that is setting it, not by loosening the accepted list, unless the code is genuinely intended.",
          "Re-check the URL directly to confirm the new code.",
          "Re-run this test."
        ]
      },
      consequence:
        "Crawlers and caches use the status code to decide whether to index, store or retry a response. An incorrect code can keep a live page out of the index, or keep a removed page in it, and it makes your monitoring untrustworthy.",
      closing:
        "The status code is a contract with every client that fetches the page. Make it say what you mean."
    },

    /* ------------------------------------------------------------------ *
     * Schema / structured data
     * ------------------------------------------------------------------ */
    "schema.missing": {
      name: "No Structured Data Found",
      intro:
        "This page contains no JSON-LD structured data. Structured data describes your content in a vocabulary search engines understand, and it is what makes rich results such as star ratings, FAQs, breadcrumbs, prices and event details possible.",
      fix: {
        paragraph:
          "Add a JSON-LD block that describes what this page actually is, using the schema.org type that fits, and include the properties that type requires.",
        steps: [
          "Choose the type that matches the page: <code>Article</code>, <code>Product</code>, <code>FAQPage</code>, <code>LocalBusiness</code>, <code>Organization</code> and so on.",
          "Add a <code>&lt;script type=\"application/ld+json\"&gt;</code> block to the head or body containing the markup.",
          "Populate every required property for that type, plus the recommended ones that unlock richer results.",
          "Make sure the markup only describes content actually visible on the page; inventing data is a policy violation.",
          "Validate with the Rich Results Test and the Schema Markup Validator.",
          "Publish and re-run this test."
        ]
      },
      consequence:
        "The page is ineligible for every rich result. Competitors with markup occupy more vertical space in results with review stars, images and FAQ expanders, so they win clicks even at the same ranking position.",
      closing:
        "Structured data does not change your ranking directly, but it changes how much of the results page you own."
    },

    "schema.invalid_json": {
      name: "Structured Data Could Not Be Parsed",
      intro:
        "A JSON-LD block was found on this page but it is not valid JSON, so no consumer can read it. A single syntax error invalidates the entire block, including any correct markup inside it.",
      fix: {
        paragraph:
          "Repair the JSON syntax, then generate the block programmatically so template variables cannot break it again.",
        steps: [
          "Copy the block into a JSON validator to find the exact position of the syntax error.",
          "Check for the usual causes: a trailing comma, an unescaped double quote inside a value, a smart quote from a word processor, or an unclosed brace.",
          "Escape or strip HTML and newlines inside string values.",
          "Build the object server-side and serialise it with a real JSON encoder rather than concatenating strings in a template.",
          "Confirm the block is inside <code>&lt;script type=\"application/ld+json\"&gt;</code> and contains no HTML comments.",
          "Validate with the Rich Results Test and re-run this test."
        ]
      },
      consequence:
        "The markup is silently ignored, so you carry the maintenance cost of structured data with none of the benefit. Because nothing on the page looks broken, this often goes unnoticed for months.",
      closing:
        "Generate structured data with a JSON encoder and syntax errors stop being possible."
    },

    "schema.missing_type": {
      name: "Structured Data Missing A Type",
      intro:
        "A JSON-LD block was found and parsed, but at least one entity in it has no <code>@type</code> property. Without a type, a consumer has no way to know what the object describes, so the entity is discarded.",
      fix: {
        paragraph:
          "Give every entity in the graph an explicit <code>@type</code> from the schema.org vocabulary, and make sure the required properties for that type are present.",
        steps: [
          "Add <code>\"@type\"</code> to every object in the block, including nested ones such as <code>author</code>, <code>publisher</code> and <code>offers</code>.",
          "Use the exact schema.org spelling, which is case sensitive, for example <code>BlogPosting</code> rather than <code>blogposting</code>.",
          "Include <code>\"@context\": \"https://schema.org\"</code> at the top level.",
          "Fill in the required properties for each type you declare.",
          "Validate with the Schema Markup Validator to confirm every entity is recognised.",
          "Re-run this test."
        ]
      },
      consequence:
        "Untyped entities are ignored, so the page loses eligibility for the rich results that depend on them. Partially typed graphs are the hardest kind to debug because some features work and others silently do not.",
      closing:
        "Type every entity and the whole graph becomes usable rather than half readable."
    },

    "schema.http": {
      name: "Structured Data Could Not Be Retrieved",
      intro:
        "The page could not be fetched in order to check its structured data. The request either failed, timed out, or returned something other than the HTML document.",
      fix: {
        paragraph:
          "Make sure the URL returns HTTP 200 with the full HTML document to an ordinary request, without requiring JavaScript execution.",
        steps: [
          "Request the URL directly and note the status code and response body.",
          "Fix any redirect chain, authentication requirement or firewall rule intercepting the request.",
          "If the JSON-LD is injected by client-side JavaScript, render it server-side so it exists in the initial HTML.",
          "Check the response is not being truncated by a timeout or a proxy.",
          "Re-run this test once the page responds cleanly."
        ]
      },
      consequence:
        "If the document cannot be fetched, its structured data cannot be read by anything, including search engines. Rich result eligibility is lost and the underlying fetch problem probably affects indexing of the page as a whole.",
      closing:
        "Structured data can only work on a page that reliably loads. Fix the response first."
    },

    /* ------------------------------------------------------------------ *
     * Caching
     * ------------------------------------------------------------------ */
    "css_caching.disabled": {
      name: "CSS Files Are Not Cached",
      intro:
        "The stylesheets on this page are served without usable cache headers, so browsers re-download them on every visit. CSS rarely changes between deployments, which makes it an ideal candidate for long-lived caching.",
      fix: {
        paragraph:
          "Send explicit far-future cache headers for stylesheets and change the file name when the contents change, so you never have to invalidate a cache by hand.",
        steps: [
          "Add <code>Cache-Control: public, max-age=31536000, immutable</code> to responses for <code>.css</code> files.",
          "Add a content hash to the file name at build time, for example <code>main.8f3c2a.css</code>, so a new deployment produces a new URL.",
          "Remove <code>no-cache</code>, <code>no-store</code> and <code>Pragma: no-cache</code> headers that a global rule may be applying to static assets.",
          "Configure the same policy at your CDN as well as at the origin.",
          "Verify with the Network panel that a repeat visit reports the stylesheet as served from cache.",
          "Re-run this test."
        ]
      },
      consequence:
        "Returning visitors re-download CSS they already have, adding a blocking request to the critical rendering path on every page view. Pages feel slower than they are, bandwidth is wasted, and Largest Contentful Paint suffers on repeat visits.",
      closing:
        "Hashed file names plus a one year cache lifetime is the standard solution and it needs configuring only once."
    },

    "js_caching.disabled": {
      name: "JavaScript Files Are Not Cached",
      intro:
        "The scripts on this page are served without usable cache headers, so browsers fetch them again on every visit. Script bundles are usually the largest text assets a page loads, which makes this the most expensive kind of missing cache.",
      fix: {
        paragraph:
          "Serve script bundles with long cache lifetimes and versioned file names, so repeat visitors execute from cache instead of downloading again.",
        steps: [
          "Add <code>Cache-Control: public, max-age=31536000, immutable</code> to responses for <code>.js</code> files.",
          "Include a content hash in the bundle file name so each build produces a distinct URL.",
          "Exclude genuinely dynamic scripts from the immutable policy and give them a short max-age instead.",
          "Mirror the policy at the CDN and check no security or proxy layer is stripping the header.",
          "Confirm on a repeat visit that scripts are served from cache rather than refetched.",
          "Re-run this test."
        ]
      },
      consequence:
        "Every visit re-downloads and re-parses the same JavaScript, delaying interactivity and inflating Total Blocking Time. On mobile connections this is often the single largest contributor to a slow repeat visit.",
      closing:
        "Cache your bundles properly and returning visitors get a page that feels instant."
    },

    /* ------------------------------------------------------------------ *
     * Compression
     * ------------------------------------------------------------------ */
    "gzip.disabled": {
      name: "Gzip Compression Not Enabled",
      intro:
        "This page is served without gzip or Brotli compression. HTML, CSS, JavaScript and JSON are highly compressible text, and enabling compression typically cuts transfer size by 60 to 80 percent for a single server setting.",
      fix: {
        paragraph:
          "Turn on compression at the web server or CDN for all text based content types, and verify the response header confirms it.",
        steps: [
          "Enable the compression module for your server: <code>mod_deflate</code> or <code>mod_brotli</code> on Apache, <code>gzip on</code> or <code>brotli on</code> on Nginx.",
          "Add the text content types you serve, including <code>text/html</code>, <code>text/css</code>, <code>application/javascript</code>, <code>application/json</code> and <code>image/svg+xml</code>.",
          "Do not compress already-compressed formats such as JPEG, PNG, WebP, MP4 or ZIP; it wastes CPU and can increase size.",
          "Enable compression at the CDN as well, since it may be serving from an uncompressed cached copy.",
          "Check the response includes <code>Content-Encoding: gzip</code> or <code>br</code>.",
          "Re-run this test."
        ]
      },
      consequence:
        "Every visitor downloads several times more data than necessary. Time to First Byte and Largest Contentful Paint both suffer, mobile users on slow connections wait noticeably longer, and your bandwidth costs are several times higher than they need to be.",
      closing:
        "Compression is the highest impact per minute of work of any performance change available."
    },

    "html_compression.disabled": {
      name: "HTML Is Not Minified",
      intro:
        "The HTML for this page contains a large amount of unnecessary whitespace and formatting. That formatting is helpful while writing templates but it is dead weight on the wire, and HTML is on the critical rendering path.",
      fix: {
        paragraph:
          "Minify HTML as part of your build or response pipeline, so the source templates stay readable while the delivered document does not.",
        steps: [
          "Enable HTML minification in your framework, build tool or a response middleware.",
          "Collapse redundant whitespace and strip HTML comments from production output.",
          "Preserve whitespace inside <code>&lt;pre&gt;</code>, <code>&lt;textarea&gt;</code> and <code>&lt;code&gt;</code> blocks, where it is significant.",
          "Move inline <code>&lt;style&gt;</code> and <code>&lt;script&gt;</code> content into cacheable external files where practical.",
          "Make sure gzip or Brotli is also enabled, since the two compound.",
          "Re-run this test."
        ]
      },
      consequence:
        "A larger HTML document takes longer to download and parse before anything can render. The effect is smaller than a missing gzip header but it applies to the one resource that blocks everything else on the page.",
      closing:
        "Write templates for humans and ship them minified for browsers."
    },

    "css_compression.disabled": {
      name: "CSS Files Are Not Minified",
      intro:
        "One or more stylesheets on this page are served unminified, with the comments, indentation and line breaks from development still in place. Stylesheets block rendering, so their size directly delays the first paint.",
      fix: {
        paragraph:
          "Minify every stylesheet during your build and, while you are there, remove the rules the page never uses.",
        steps: [
          "Add a CSS minifier to your build pipeline, such as cssnano, esbuild or your framework's asset compiler.",
          "Reference the minified output in your templates and keep the readable source in version control only.",
          "Run a coverage report and remove unused rules, which on most sites are the majority of the file.",
          "Inline the small amount of CSS needed for above-the-fold content and load the rest asynchronously.",
          "Confirm gzip or Brotli is enabled as well.",
          "Re-run this test."
        ]
      },
      consequence:
        "Render-blocking stylesheets stay larger than they need to be, so the browser waits longer before it can paint anything. First Contentful Paint and Largest Contentful Paint both slip, and the delay is worst on the mobile connections most of your visitors use.",
      closing:
        "Minification is automatic once configured, and the source files you work in never change."
    },

    "js_compression.disabled": {
      name: "JavaScript Files Are Not Minified",
      intro:
        "One or more scripts on this page are served unminified. JavaScript is usually the heaviest text asset on a page, and unlike CSS it also has to be parsed, compiled and executed, so its size costs more than download time alone.",
      fix: {
        paragraph:
          "Minify and bundle your scripts in the build, and split the output so each page only ships the code it actually needs.",
        steps: [
          "Add a minifier such as esbuild, terser or SWC to your build and reference the minified output.",
          "Enable tree shaking so unused exports are dropped from the bundle.",
          "Code split by route so a page does not download the whole application.",
          "Add <code>defer</code> or <code>async</code> to script tags that do not need to block parsing.",
          "Confirm gzip or Brotli compression is enabled on top of minification.",
          "Re-run this test."
        ]
      },
      consequence:
        "Larger bundles take longer to download, parse and execute on the main thread, which pushes up Total Blocking Time and Interaction to Next Paint. The page can look ready while remaining unresponsive to taps and clicks.",
      closing:
        "Smaller bundles are the most reliable way to make a page feel fast rather than merely look loaded."
    },

    /* ------------------------------------------------------------------ *
     * Page weight and legacy markup
     * ------------------------------------------------------------------ */
    "page_size.too_large": {
      name: "HTML Page Size Above The Limit",
      intro:
        "The HTML document for this page is larger than the maximum size configured for this project. This measures the markup alone, not images or scripts, so a large figure means the document itself is bloated.",
      fix: {
        paragraph:
          "Reduce the amount of markup the server sends. Oversized HTML is usually caused by inlined assets, embedded data, or rendering an entire dataset into one response.",
        steps: [
          "Move inline <code>&lt;style&gt;</code> and <code>&lt;script&gt;</code> blocks into external cacheable files.",
          "Remove inlined base64 images and reference real image files instead.",
          "Strip embedded JSON state dumps down to the fields the page actually uses.",
          "Paginate or lazy load long lists and tables rather than rendering thousands of rows at once.",
          "Delete commented-out markup, unused template fragments and duplicated wrapper elements.",
          "Enable HTML minification and gzip, then re-run this test."
        ]
      },
      consequence:
        "A large HTML document delays the very first thing the browser needs, so nothing else can start. Parsing cost rises, the DOM grows, memory use on low-end phones climbs, and Largest Contentful Paint and Time to Interactive both degrade.",
      closing:
        "The HTML is the one resource nothing else can start without. Keep it lean."
    },

    "nested_tables.found": {
      name: "Nested Tables In The Markup",
      intro:
        "This page contains tables nested inside other tables. That pattern comes from pre-CSS layout techniques, and it is slow to render, hostile to assistive technology and effectively impossible to make responsive.",
      fix: {
        paragraph:
          "Replace table-based layout with CSS, and keep <code>&lt;table&gt;</code> for genuine tabular data only.",
        steps: [
          "Identify whether each table holds real tabular data or is being used to position elements.",
          "Rebuild layout tables using CSS Grid or Flexbox on semantic containers.",
          "For real data tables, flatten the nesting and use <code>&lt;thead&gt;</code>, <code>&lt;tbody&gt;</code>, <code>&lt;th&gt;</code> with a <code>scope</code> attribute, and a <code>&lt;caption&gt;</code>.",
          "Never place a table inside a table cell for spacing; use padding and margins.",
          "Make wide data tables scroll horizontally in a wrapper instead of forcing the page to be wide.",
          "Re-run this test."
        ]
      },
      consequence:
        "Nested tables force the browser to recalculate layout repeatedly, which is slow on mobile. Screen readers announce a confusing maze of nested grids, the layout cannot adapt to small screens, and search engines have a harder time working out which parts of the page are content.",
      closing:
        "CSS has handled layout for two decades. Tables should only ever hold data."
    },

    "frameset.found": {
      name: "Frameset Used On The Page",
      intro:
        "This page uses a <code>&lt;frameset&gt;</code> or <code>&lt;frame&gt;</code> element. Framesets were removed from the HTML standard, are unsupported in modern browsers and break the fundamental assumption that one URL corresponds to one page of content.",
      fix: {
        paragraph:
          "Rebuild the page as a single document, moving shared regions into server-side includes or components rather than separate framed documents.",
        steps: [
          "Identify what each frame contains, typically navigation, a header and a content area.",
          "Create one HTML document that includes all of those regions.",
          "Move the repeated regions into a layout template, partial or component so they are still maintained in one place.",
          "Replace <code>&lt;frameset&gt;</code> with semantic elements such as <code>&lt;header&gt;</code>, <code>&lt;nav&gt;</code> and <code>&lt;main&gt;</code>, laid out with CSS.",
          "Add 301 redirects from the old frame document URLs to the new combined page.",
          "Re-run this test."
        ]
      },
      consequence:
        "Framed content cannot be bookmarked, shared or linked to correctly, and search engines usually index the frame documents separately from the frameset, so visitors arrive at fragments with no navigation. Modern browsers may not render the layout at all.",
      closing:
        "Framesets are a dead technology. Rebuilding the page as one document fixes SEO, accessibility and usability together."
    },

    /* ------------------------------------------------------------------ *
     * Security headers
     * ------------------------------------------------------------------ */
    "csp.missing": {
      name: "Missing Content Security Policy Header",
      intro:
        "This page is served without a <code>Content-Security-Policy</code> header. A CSP tells the browser which sources of scripts, styles, images and frames it is allowed to load, and it is the most effective defence against cross-site scripting.",
      fix: {
        paragraph:
          "Introduce a policy in report-only mode first so you can see what it would block, then enforce it once the reports are clean.",
        steps: [
          "Inventory every external origin the page legitimately loads from: scripts, styles, fonts, images, frames and analytics.",
          "Add <code>Content-Security-Policy-Report-Only</code> with a starting policy such as <code>default-src 'self'</code> plus the origins you identified.",
          "Collect violation reports for a representative period and fix genuine breakages before enforcing.",
          "Remove inline scripts and event handler attributes, or authorise them with a per-request nonce rather than <code>unsafe-inline</code>.",
          "Switch the header to <code>Content-Security-Policy</code> to enforce, and keep the reporting endpoint in place.",
          "Re-run this test."
        ]
      },
      consequence:
        "Any injected script, whether through a vulnerable form, a comment field or a compromised third-party dependency, executes with full access to the page. That is how card skimmers and session theft work, and without a CSP there is nothing at the browser layer to stop it.",
      closing:
        "A CSP is the one header that limits the damage when something else on the page has already been compromised."
    },

    "x_frame.missing": {
      name: "Missing X-Frame-Options Header",
      intro:
        "This page does not send an <code>X-Frame-Options</code> header or an equivalent <code>frame-ancestors</code> directive, so any site can load it inside an iframe. That is the precondition for clickjacking, where an attacker overlays your page and tricks users into clicking things they cannot see.",
      fix: {
        paragraph:
          "Declare who is allowed to frame this page. For most sites the answer is nobody, or only the site itself.",
        steps: [
          "Add <code>X-Frame-Options: SAMEORIGIN</code> to responses, or <code>DENY</code> if the page is never framed even by you.",
          "Add the modern equivalent, <code>Content-Security-Policy: frame-ancestors 'self'</code>, which browsers prefer and which supports multiple origins.",
          "If a specific partner must embed the page, list only their origin in <code>frame-ancestors</code>.",
          "Apply the header globally at the server or CDN so no route is missed.",
          "Confirm your own embeds, such as previews and widgets, still work after the change.",
          "Re-run this test."
        ]
      },
      consequence:
        "An attacker can embed your page invisibly beneath their own interface and harvest clicks on real buttons, approving transfers, changing settings or granting permissions. Users see the attacker's page and interact with yours.",
      closing:
        "One header removes an entire category of attack from your exposure."
    },

    "hsts.missing": {
      name: "Missing HSTS Header",
      intro:
        "This page does not send a <code>Strict-Transport-Security</code> header. Without it, a browser will still try HTTP first for a typed or remembered address, and that initial plaintext request can be intercepted and redirected before your HTTPS redirect ever runs.",
      fix: {
        paragraph:
          "Instruct browsers to use HTTPS exclusively for your domain, then extend the policy to subdomains and finally to the preload list once you are confident.",
        steps: [
          "Confirm every page and asset, including subdomains, is fully reachable over HTTPS with a valid certificate.",
          "Add <code>Strict-Transport-Security: max-age=31536000</code> to HTTPS responses.",
          "Test with a short max-age first, such as 300 seconds, so a mistake is quickly reversible.",
          "Once stable, add <code>includeSubDomains</code>, and then <code>preload</code> if you want the policy built into browsers.",
          "Keep the permanent HTTP to HTTPS redirect in place for first-time visitors.",
          "Re-run this test."
        ]
      },
      consequence:
        "The first request of a session can be downgraded to HTTP by an attacker on the same network, exposing cookies and session tokens and enabling a man-in-the-middle for the rest of the visit. Public Wi-Fi makes this a practical attack, not a theoretical one.",
      closing:
        "HSTS closes the gap between a user typing your domain and your server enforcing HTTPS. Set max-age conservatively and increase it."
    },

    "bad_content_type.mismatch": {
      name: "Content Type Declaration Mismatch",
      intro:
        "The <code>Content-Type</code> declared in a meta tag on this page does not match the <code>Content-Type</code> sent in the HTTP response header. Browsers trust the header, so the meta tag is at best redundant and at worst actively misleading, which is a known route to MIME confusion attacks.",
      fix: {
        paragraph:
          "Set the content type once, in the HTTP response header, and make the page's declaration agree with it or remove it entirely.",
        steps: [
          "Check what your server actually sends, which should be <code>Content-Type: text/html; charset=UTF-8</code> for an HTML page.",
          "Remove the legacy <code>&lt;meta http-equiv=\"Content-Type\"&gt;</code> tag and replace it with the modern <code>&lt;meta charset=\"UTF-8\"&gt;</code>.",
          "Keep <code>&lt;meta charset&gt;</code> within the first 1024 bytes of the document.",
          "Make sure the server charset and the document charset are the same, since a mismatch is what produces garbled characters.",
          "Add <code>X-Content-Type-Options: nosniff</code> so browsers stop guessing content types.",
          "Re-run this test."
        ]
      },
      consequence:
        "Conflicting declarations cause encoding corruption, where accented and non-Latin characters render as replacement symbols. They also encourage MIME sniffing, which attackers exploit to have an uploaded file executed as script rather than served as data.",
      closing:
        "Declare the content type once, in the header, and let the document simply agree with it."
    },

    "directory_browsing.enabled": {
      name: "Directory Browsing Enabled",
      intro:
        "The server returns a directory index listing for this path instead of a page or an error. Anyone can browse your file structure and read files that were never meant to be linked, including backups, logs, exports and configuration.",
      fix: {
        paragraph:
          "Disable automatic directory listings across the whole server, then remove any sensitive files that were exposed while it was on.",
        steps: [
          "Set <code>Options -Indexes</code> in your Apache configuration or <code>autoindex off;</code> in Nginx, applied at the server level rather than per directory.",
          "Add an <code>index.html</code> or route handler for directories that must respond to a bare request.",
          "Audit the exposed directories for files that should never have been public: <code>.sql</code> dumps, <code>.zip</code> backups, <code>.env</code> files, logs and editor swap files.",
          "Move those files outside the web root entirely rather than relying on obscurity.",
          "Rotate any credentials, API keys or tokens that appeared in exposed files.",
          "Re-run this test."
        ]
      },
      consequence:
        "Attackers routinely scan for open directories because they are a reliable source of database dumps, credentials and source code. A single exposed backup can hand over your entire application and user data, and search engines may index the listing, making it discoverable through search.",
      closing:
        "Treat this as urgent. Disable indexes, then check what was reachable while they were on."
    },

    "safe_browsing.unsafe": {
      name: "Flagged By Google Safe Browsing",
      intro:
        "This URL is listed in Google's Safe Browsing database as unsafe, which means Google has detected malware, unwanted software, social engineering content or a phishing pattern on the page or something it loads.",
      fix: {
        paragraph:
          "Treat this as a security incident. Find and remove the malicious content, close the entry point that allowed it, and only then request a review.",
        steps: [
          "Open the Security Issues report in Google Search Console to see exactly what was detected and where.",
          "Take the site offline or into maintenance mode if active malware is being served to visitors.",
          "Scan the file system and database for injected scripts, unexpected redirects, obfuscated code and unfamiliar admin accounts.",
          "Restore from a known clean backup where possible, then patch the CMS, plugins, themes and server packages that allowed the compromise.",
          "Rotate every credential: hosting, database, CMS administrators, API keys and FTP or SSH access.",
          "Remove or replace any third-party script that was the source, then request a review in Search Console and re-run this test."
        ]
      },
      consequence:
        "Chrome, Safari, Firefox and Edge all show a full-screen red interstitial warning before your page loads, which stops essentially all traffic. The listing also suppresses the site in search results and can get your sending domain blocklisted for email.",
      closing:
        "Clean the compromise first, then request the review. Requesting a review before the site is clean extends the listing."
    },

    "cross_origin.unsafe": {
      name: "Unsafe Cross-Origin Links",
      intro:
        "This page contains links that open in a new tab with <code>target=\"_blank\"</code> but do not set <code>rel=\"noopener\"</code>. Without it, the page you link to receives a reference to your window through <code>window.opener</code> and can navigate it somewhere else.",
      fix: {
        paragraph:
          "Add the protective <code>rel</code> attributes to every link that opens a new browsing context, and make it the default in whatever renders your links.",
        steps: [
          "Find every <code>&lt;a target=\"_blank\"&gt;</code> on the page, including links generated from user content.",
          "Add <code>rel=\"noopener noreferrer\"</code> to each one.",
          "Update your link component, template helper or markdown renderer so the attributes are applied automatically.",
          "Sanitise user-submitted HTML to inject the same attributes server-side.",
          "Keep <code>noopener</code> even on modern browsers that imply it, because older clients and embedded webviews do not.",
          "Re-run this test."
        ]
      },
      consequence:
        "A malicious or compromised destination can silently replace the tab your visitor came from with a convincing copy of your login page. The user switches back, sees your branding and enters their credentials into the attacker's form. It also leaks your full URL as a referrer.",
      closing:
        "Two words in the <code>rel</code> attribute close a phishing vector that requires no vulnerability on your side."
    },

    "protocol_relative.found": {
      name: "Protocol Relative Resource Links",
      intro:
        "This page loads resources using protocol relative URLs that begin with <code>//</code>. These inherit whatever protocol the page was loaded over, which was a useful trick during the transition to HTTPS but is now a liability.",
      fix: {
        paragraph:
          "Rewrite every protocol relative reference to an explicit <code>https://</code> URL, and add a policy that upgrades anything you miss.",
        steps: [
          "Search your templates, CSS and JavaScript for <code>src=\"//</code> and <code>href=\"//</code>.",
          "Replace each with an explicit <code>https://</code> URL, or a root-relative <code>/path</code> for assets on your own domain.",
          "Check your database too, since editor-inserted content often carries these URLs.",
          "Add <code>Content-Security-Policy: upgrade-insecure-requests</code> so any remaining HTTP subresource is upgraded automatically.",
          "Confirm every third-party origin you depend on supports HTTPS.",
          "Re-run this test."
        ]
      },
      consequence:
        "Any context that is not HTTPS, such as a local file, an email client preview or a legacy webview, fetches these resources over plain HTTP, which allows them to be intercepted or modified in transit. Browsers also block mixed content, so stylesheets and scripts can silently fail to load and break the page.",
      closing:
        "HTTPS is the default now. State it explicitly and remove the ambiguity."
    },

    "ssl.missing": {
      name: "SSL Certificate Missing Or Invalid",
      intro:
        "A valid SSL certificate could not be verified for this domain. The certificate may be expired, self-signed, issued for a different hostname, or missing an intermediate certificate in the chain.",
      fix: {
        paragraph:
          "Install a valid certificate that covers every hostname you serve, complete the chain, and automate renewal so this cannot recur.",
        steps: [
          "Check the certificate's expiry date, the hostnames it covers and the completeness of its chain.",
          "Issue a new certificate from a trusted authority; Let's Encrypt is free and widely supported.",
          "Make sure it covers every hostname in use, including <code>www</code> and any subdomains.",
          "Install the full chain, including intermediate certificates, since a missing intermediate fails on many clients even when browsers appear fine.",
          "Automate renewal with certbot or your platform's equivalent, and add expiry monitoring.",
          "Redirect all HTTP traffic to HTTPS, then re-run this test."
        ]
      },
      consequence:
        "Browsers show a full-page security warning before any of your content appears, which stops almost all traffic. Search engines treat HTTPS as a ranking signal and will not favour a site serving certificate errors, and any data submitted over the connection is exposed in transit.",
      closing:
        "Fix the certificate first and automate the renewal, because an expired certificate is an outage that arrives on a schedule."
    },

    /* ------------------------------------------------------------------ *
     * Performance: PageSpeed / Lighthouse / Core Web Vitals
     * ------------------------------------------------------------------ */
    "pagespeed.mobile": {
      name: "PageSpeed Score Below Target On Mobile",
      intro:
        "The Google PageSpeed Insights score for this page on mobile is below the threshold configured for this project. The mobile test simulates a mid-range phone on a throttled connection, which is much closer to how most of your visitors actually experience the page than a desktop test.",
      fix: {
        paragraph:
          "Work on the largest contributors first. On almost every page the mobile score is dominated by unoptimised images and by JavaScript that blocks the main thread, so start there rather than with micro-optimisations.",
        steps: [
          "Open the PageSpeed report and note the top opportunities by estimated saving in seconds.",
          "Convert images to WebP or AVIF, size them to their rendered dimensions, and serve responsive variants with <code>srcset</code>.",
          "Preload the hero image and the fonts used above the fold, and set <code>font-display: swap</code>.",
          "Defer or remove non-essential third-party scripts such as chat widgets, heat maps and secondary analytics.",
          "Eliminate render-blocking CSS by inlining the above-the-fold rules and loading the rest asynchronously.",
          "Enable compression and long-lived caching for static assets, then re-run this test."
        ]
      },
      consequence:
        "Mobile is where most traffic arrives and where Google evaluates your page for ranking under mobile-first indexing. A slow mobile page loses visitors before it renders, converts worse for those who stay, and is ranked below faster competitors for the same query.",
      closing:
        "Fix mobile performance first. Desktop nearly always improves as a side effect."
    },

    "pagespeed.desktop": {
      name: "PageSpeed Score Below Target On Desktop",
      intro:
        "The Google PageSpeed Insights score for this page on desktop is below the threshold configured for this project. Desktop runs on a fast simulated connection, so a low score here means something substantial is wrong rather than merely unoptimised.",
      fix: {
        paragraph:
          "A poor desktop score usually points at a small number of large problems: an enormous asset, a slow server response, or a third-party script blocking the main thread.",
        steps: [
          "Check Time to First Byte; if the server is slow, no front-end work will rescue the score.",
          "Find the largest resources in the report and reduce them, particularly hero images, video posters and web fonts.",
          "Audit third-party scripts and remove anything that is not earning its cost.",
          "Split large JavaScript bundles so each page loads only the code it needs.",
          "Add explicit <code>width</code> and <code>height</code> to media so layout does not shift as it loads.",
          "Re-run this test after each change so you can attribute the improvement."
        ]
      },
      consequence:
        "Slow desktop pages lose visitors at exactly the point of highest intent, and on business and enterprise sites desktop is often where the highest value conversions happen. Performance also feeds directly into ranking through Core Web Vitals.",
      closing:
        "A low desktop score on a fast connection means the page is doing far more work than it needs to."
    },

    "pagespeed.both": {
      name: "PageSpeed Score Below Target",
      intro:
        "This page scores below the configured PageSpeed threshold on both mobile and desktop. When both environments fail, the cause is normally structural, affecting how the page is built and delivered rather than how it adapts to a device.",
      fix: {
        paragraph:
          "Address the delivery pipeline before tuning individual assets. A single structural fix, such as enabling compression or removing a blocking third-party script, often moves both scores at once.",
        steps: [
          "Measure Time to First Byte and fix slow server response, missing page caching or an unindexed database query first.",
          "Enable gzip or Brotli compression and long-lived caching for every static asset.",
          "Optimise the Largest Contentful Paint element, which is usually the hero image or the headline block, and preload it.",
          "Remove or defer third-party scripts, then re-measure to see what each one actually cost.",
          "Minify and code split CSS and JavaScript so each page ships only what it uses.",
          "Re-run this test and confirm both environments clear the threshold."
        ]
      },
      consequence:
        "Every visitor on every device waits longer than necessary. That shows up as higher bounce rates, lower conversion, failing Core Web Vitals and reduced ranking, and the effect compounds across every page that shares the same templates and assets.",
      closing:
        "Structural performance fixes apply site-wide. The work you do here improves every page at once."
    },

    "lighthouse.performance": {
      name: "Lighthouse Performance Score Below Target",
      intro:
        "The Lighthouse performance category scores below the threshold configured for this project. This category is a weighted composite of loading metrics, so improving it means improving the individual metrics that feed it rather than chasing the number.",
      fix: {
        paragraph:
          "Look at which metric contributes most of the deficit and work on that one. Largest Contentful Paint and Total Blocking Time carry the heaviest weights in the score.",
        steps: [
          "Identify the Largest Contentful Paint element in the report, then preload it and remove anything that delays it.",
          "Reduce Total Blocking Time by splitting long JavaScript tasks and deferring work that is not needed for the first interaction.",
          "Eliminate render-blocking resources by inlining critical CSS and deferring the rest.",
          "Set explicit dimensions on images, embeds and ad slots to remove layout shift.",
          "Cut unused CSS and JavaScript, which on most pages is the majority of what is shipped.",
          "Re-run this test after each change so you can see which one mattered."
        ]
      },
      consequence:
        "Poor performance metrics are used directly in ranking through Core Web Vitals, and they correlate strongly with abandonment. Every additional second before the page is usable costs conversions on this and every page built from the same templates.",
      closing:
        "Work on the metric, not the score. The score follows."
    },

    "lighthouse.accessibility": {
      name: "Lighthouse Accessibility Score Below Target",
      intro:
        "The Lighthouse accessibility category scores below the threshold configured for this project. These are automated checks, so they catch the mechanical problems: missing labels, insufficient colour contrast, absent alternate text and broken landmark structure.",
      fix: {
        paragraph:
          "Fix the reported violations in order of how many users they affect, then follow up with a manual keyboard and screen reader pass, since automation catches only a portion of real accessibility issues.",
        steps: [
          "Add programmatic labels to every form control using <code>&lt;label for&gt;</code> or an <code>aria-label</code>.",
          "Fix colour contrast so body text meets at least a 4.5 to 1 ratio against its background.",
          "Add descriptive <code>alt</code> text to meaningful images and an explicit empty <code>alt=\"\"</code> to decorative ones.",
          "Restore a sequential heading structure with one H1 and no skipped levels.",
          "Set the <code>lang</code> attribute on the <code>&lt;html&gt;</code> element and ensure interactive elements are reachable and operable by keyboard with a visible focus style.",
          "Re-run this test, then verify manually with a keyboard and a screen reader."
        ]
      },
      consequence:
        "People using screen readers, keyboard navigation, magnification or high contrast modes are excluded from parts of the page. Beyond the human cost, accessibility is a legal requirement in many markets, and the same structural signals help search engines understand the page.",
      closing:
        "Accessibility fixes are usually small, mechanical edits that make the page better for everyone."
    },

    "lighthouse.best_practices": {
      name: "Lighthouse Best Practices Score Below Target",
      intro:
        "The Lighthouse best practices category scores below the threshold configured for this project. This category covers the general health of the page: secure delivery, correct image handling, absence of console errors and avoidance of deprecated APIs.",
      fix: {
        paragraph:
          "Work through the reported audits; each one is a small, self-contained fix rather than a project.",
        steps: [
          "Serve every resource over HTTPS and eliminate mixed content warnings.",
          "Set explicit <code>width</code> and <code>height</code> on images so they display at their correct aspect ratio.",
          "Clear browser console errors, since each one indicates something on the page is genuinely failing.",
          "Replace deprecated APIs and libraries flagged in the report.",
          "Add <code>rel=\"noopener\"</code> to links that open in a new tab and remove unnecessary permission requests on page load.",
          "Re-run this test."
        ]
      },
      consequence:
        "These issues rarely break the page outright, which is exactly why they accumulate. Over time they produce inconsistent rendering, silent JavaScript failures that suppress features, and security warnings that undermine visitor trust.",
      closing:
        "This category is a maintenance checklist. Clearing it keeps small problems from becoming incidents."
    },

    "lighthouse.seo": {
      name: "Lighthouse SEO Score Below Target",
      intro:
        "The Lighthouse SEO category scores below the threshold configured for this project. These are the baseline technical requirements for a page to be crawled, indexed and understood, not a measure of content quality.",
      fix: {
        paragraph:
          "Clear the reported audits, which are all foundational: crawlability, metadata, link quality and mobile readiness.",
        steps: [
          "Confirm the page is crawlable and indexable, with no stray <code>noindex</code> directive or robots.txt block.",
          "Add a unique title tag and meta description.",
          "Add the responsive viewport meta tag so the page is usable on mobile.",
          "Give every link descriptive anchor text rather than \"click here\" or a bare URL.",
          "Make sure text is large enough to read without zooming and that tap targets are adequately sized and spaced.",
          "Re-run this test."
        ]
      },
      consequence:
        "Failing these audits means search engines may be unable to crawl, index or correctly interpret the page. No amount of content or link building compensates for a page that cannot be read properly in the first place.",
      closing:
        "This is the floor, not the ceiling. Clear it and then the content work can pay off."
    },

    "core_web_vitals.lcp": {
      name: "Largest Contentful Paint Too Slow",
      intro:
        "Largest Contentful Paint measures how long it takes for the biggest piece of content in the viewport, usually a hero image or a headline block, to finish rendering. On this page it exceeds the threshold configured for your project. LCP is the metric visitors experience as \"how long until the page looked ready\".",
      fix: {
        paragraph:
          "Identify the LCP element, then remove everything standing between the initial request and that element being painted. There are only four contributors: server response time, resource load delay, resource load time and render delay.",
        steps: [
          "Find the LCP element in the report so you are optimising the right thing.",
          "Reduce Time to First Byte with page caching, a CDN and faster database queries.",
          "Preload the LCP resource with <code>&lt;link rel=\"preload\"&gt;</code> and set <code>fetchpriority=\"high\"</code> on the hero image.",
          "Never lazy load the LCP image; <code>loading=\"lazy\"</code> on a hero image is one of the most common causes of a failing LCP.",
          "Compress and correctly size that image, and serve it as WebP or AVIF.",
          "Remove render-blocking CSS and fonts ahead of it by inlining critical CSS and using <code>font-display: swap</code>, then re-run this test."
        ]
      },
      consequence:
        "LCP is a Core Web Vital used directly in Google's ranking systems. A slow LCP also drives abandonment: visitors judge whether a page is working within the first couple of seconds, and most leave before a slow hero finishes loading.",
      closing:
        "Optimise the single element that defines LCP and you will usually fix the whole metric in one change."
    },

    "core_web_vitals.cls": {
      name: "Cumulative Layout Shift Too High",
      intro:
        "Cumulative Layout Shift measures how much visible content moves around unexpectedly while the page loads. On this page it exceeds the configured threshold, which means text and buttons are jumping as late-arriving content pushes them out of the way.",
      fix: {
        paragraph:
          "Reserve space for everything that loads asynchronously. Layout shift happens because the browser lays out the page before it knows how big something is going to be.",
        steps: [
          "Add explicit <code>width</code> and <code>height</code> attributes, or a CSS <code>aspect-ratio</code>, to every image, video and iframe.",
          "Reserve a fixed-height container for ads, embeds and anything injected by JavaScript.",
          "Preload web fonts and use <code>font-display: optional</code> or a metric-matched fallback to avoid reflow when the font swaps in.",
          "Never insert banners, cookie notices or promotional bars above existing content after the page has painted.",
          "Use CSS <code>transform</code> for animation rather than properties that trigger layout, such as <code>top</code>, <code>height</code> or <code>margin</code>.",
          "Re-run this test."
        ]
      },
      consequence:
        "Layout shift causes mis-clicks: a visitor reaches for a link and content moves under their finger, so they tap an advert or the wrong button. It is one of the most disliked experiences on the mobile web, and as a Core Web Vital it also feeds into ranking.",
      closing:
        "Reserve space for everything and the page will settle instead of dancing."
    },

    "core_web_vitals.fcp": {
      name: "First Contentful Paint Too Slow",
      intro:
        "First Contentful Paint measures how long the visitor stares at a blank screen before anything at all appears. On this page it exceeds your configured threshold, which means the browser is being made to wait before it can paint a single pixel.",
      fix: {
        paragraph:
          "Shorten the critical path: the minimum set of work required before the first paint. Everything else can wait.",
        steps: [
          "Reduce Time to First Byte with server-side caching and a CDN close to your visitors.",
          "Inline the CSS needed for above-the-fold content and load the remaining stylesheets asynchronously.",
          "Move <code>&lt;script&gt;</code> tags out of the critical path with <code>defer</code> or <code>async</code>.",
          "Preconnect to the origins that serve critical resources so DNS, TCP and TLS costs overlap with other work.",
          "Reduce the size of the HTML document itself, since nothing can paint until it is parsed.",
          "Re-run this test."
        ]
      },
      consequence:
        "A long blank screen is the point at which most abandonment happens; visitors cannot tell a slow page from a broken one. FCP also gates every downstream metric, so a slow first paint guarantees a slow LCP.",
      closing:
        "Get something meaningful on screen quickly and the rest of the load feels much faster than it is."
    },

    "core_web_vitals.fid": {
      name: "Input Delay Too High",
      intro:
        "This page's potential first input delay exceeds the configured threshold. Input delay is the time between a visitor tapping or clicking and the browser being free to start responding, and it is caused by the main thread being busy with JavaScript.",
      fix: {
        paragraph:
          "Reduce and break up main-thread work during load, so the browser always has a gap in which to respond to input.",
        steps: [
          "Find long tasks in the performance report, meaning any task over 50 milliseconds, and split them into smaller chunks.",
          "Defer JavaScript that is not needed for the first interaction, and lazy load features on demand.",
          "Move heavy computation into a web worker so it never blocks the main thread.",
          "Remove or delay third-party scripts, which are frequently the largest source of blocking time.",
          "Code split by route so a page only parses and executes the JavaScript it actually needs.",
          "Re-run this test."
        ]
      },
      consequence:
        "The page looks ready but does not respond. Visitors tap repeatedly, assume it is broken and leave, or trigger the same action several times. Unresponsiveness is perceived as a worse failure than slow loading.",
      closing:
        "A page that looks ready must be ready. Keep the main thread free during load."
    },

    "core_web_vitals.tbt": {
      name: "Total Blocking Time Too High",
      intro:
        "Total Blocking Time sums the portion of every long task that blocks the main thread during load. On this page it exceeds the configured threshold, which means JavaScript is monopolising the thread the browser needs for rendering and input.",
      fix: {
        paragraph:
          "Ship less JavaScript, and break up what remains so no single task holds the thread for long.",
        steps: [
          "Audit your bundles and remove libraries that duplicate functionality or are barely used.",
          "Enable tree shaking and code splitting so each route loads only its own code.",
          "Break long-running functions into smaller units that yield back to the browser between chunks.",
          "Delay third-party tags until after the page is interactive, or load them on user interaction.",
          "Replace heavy client-side rendering with server-rendered HTML where the content is not interactive.",
          "Re-run this test."
        ]
      },
      consequence:
        "High blocking time makes the page feel frozen: scrolling stutters, taps do nothing and animations drop frames. It is the main driver of poor Interaction to Next Paint, which is now a Core Web Vital used in ranking.",
      closing:
        "The fastest JavaScript is the JavaScript you never send."
    },

    "core_web_vitals.tti": {
      name: "Time To Interactive Too Slow",
      intro:
        "Time to Interactive measures how long until the page is reliably able to respond to input. On this page it exceeds the configured threshold, meaning there is an extended window where the page looks finished but does not work.",
      fix: {
        paragraph:
          "Close the gap between the page appearing and the page functioning by reducing the JavaScript that has to run before it is ready.",
        steps: [
          "Reduce the total JavaScript executed during load through code splitting and removing unused dependencies.",
          "Hydrate progressively, prioritising the components a visitor is likely to interact with first.",
          "Defer analytics, chat, consent and A/B testing scripts until after the page is interactive.",
          "Avoid large synchronous work during initialisation, such as parsing big JSON payloads on the main thread.",
          "Server-render static content instead of building it in the browser.",
          "Re-run this test."
        ]
      },
      consequence:
        "Visitors interact with a page that appears ready and nothing happens. Those lost interactions are usually the important ones, since the first thing someone clicks is typically navigation or a call to action.",
      closing:
        "Looking loaded is not being loaded. Narrow the gap between the two."
    },

    "core_web_vitals.speed_index": {
      name: "Speed Index Too Slow",
      intro:
        "Speed Index measures how quickly the visible area of the page fills in, rather than when a single milestone is reached. On this page it exceeds the configured threshold, which means content appears gradually rather than arriving together.",
      fix: {
        paragraph:
          "Prioritise everything needed to paint the visible viewport, and defer everything below the fold.",
        steps: [
          "Inline the CSS required for above-the-fold content so the first paint does not wait on a stylesheet request.",
          "Preload the hero image and the fonts used in the visible area.",
          "Lazy load images and iframes below the fold so they do not compete for bandwidth.",
          "Remove render-blocking scripts from the document head.",
          "Reduce the number of separate requests needed for the initial view by bundling and using HTTP/2 or HTTP/3.",
          "Re-run this test."
        ]
      },
      consequence:
        "A page that fills in piecemeal feels slow even when its milestone metrics are acceptable, because the visitor watches it assemble. Perceived speed is what drives engagement, and a high Speed Index means the page feels sluggish throughout.",
      closing:
        "Optimise for the visible viewport first. That is the only part the visitor is judging."
    },

    "core_web_vitals.multiple": {
      name: "Multiple Core Web Vitals Failing",
      intro:
        "More than one Core Web Vitals metric on this page is outside the thresholds configured for your project. When several metrics fail together the cause is usually shared, so a small number of fixes will move all of them.",
      fix: {
        paragraph:
          "Start with the causes that affect every metric at once: server response time, render-blocking resources, oversized images and excessive JavaScript. Re-measure after each change rather than doing everything at once.",
        steps: [
          "Reduce Time to First Byte with page caching and a CDN; this improves every load metric simultaneously.",
          "Optimise, preload and correctly prioritise the Largest Contentful Paint element, and never lazy load it.",
          "Set explicit dimensions on all images, embeds and ad slots to remove layout shift.",
          "Cut JavaScript through code splitting and removing unused dependencies, then defer third-party tags.",
          "Inline critical CSS and load the rest asynchronously so the first paint is not blocked.",
          "Re-run this test after each change to confirm which metrics improved."
        ]
      },
      consequence:
        "Core Web Vitals are used directly in Google's ranking systems, and a page failing several at once is a poor experience on every axis: slow to appear, slow to respond and visually unstable. Because these problems usually live in shared templates and assets, they affect the whole site rather than this page alone.",
      closing:
        "A handful of structural fixes usually clears every failing metric. Measure after each one so you know what worked."
    },

    "mobile_friendly.failed": {
      name: "Page Is Not Mobile Friendly",
      intro:
        "This page failed one or more of Google's mobile usability checks, which cover the viewport declaration, legible font sizes, adequately sized tap targets and content that fits the screen width. Google indexes the mobile version of your page, so these checks describe the version that actually gets ranked.",
      fix: {
        paragraph:
          "Make the page work on a phone rather than making a desktop layout survive on one. Each failing audit maps to a specific, small fix.",
        steps: [
          "Add <code>&lt;meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"&gt;</code> to the page head.",
          "Set body text to at least 16 pixels and avoid fixed pixel sizes that cannot scale.",
          "Give tap targets a minimum size of about 48 by 48 pixels with at least 8 pixels of spacing between them.",
          "Replace fixed pixel widths with relative units and media queries so no element forces horizontal scrolling.",
          "Make wide tables and code blocks scroll inside their own container rather than widening the page.",
          "Test on a real device as well as in emulation, then re-run this test."
        ]
      },
      consequence:
        "Most of your visitors are on phones, and Google ranks based on the mobile rendering of the page. A page that requires pinching, zooming and horizontal scrolling loses those visitors immediately and is ranked below mobile-ready competitors for the same query.",
      closing:
        "Mobile is not a secondary version of the page. It is the version that gets indexed."
    },

    /* ------------------------------------------------------------------ *
     * Fallback
     * ------------------------------------------------------------------ */
    "generic.failed": {
      name: "Test Failed",
      intro:
        "This check did not pass for the page you audited. The result panel on the card lists exactly what was detected, which is the most specific information available for this test.",
      fix: {
        paragraph:
          "Use the detected problems listed below as your worklist. Fix them at the source, in the template or server configuration that produces the page, so the change applies everywhere rather than only here.",
        steps: [
          "Read the detected problems on this card and the result message on the report.",
          "Reproduce the issue by loading the page yourself and inspecting the relevant markup or response header.",
          "Apply the fix in the shared template, component or server configuration rather than on this page alone.",
          "Check the relevant threshold in Project Settings if the test depends on a configurable limit.",
          "Deploy the change and clear any page, application or CDN cache.",
          "Re-run the audit to confirm the check now passes."
        ]
      },
      consequence:
        "Leaving the check failing means whatever it measures, discoverability, performance, accessibility or security, stays degraded on this page and on every other page built from the same template.",
      closing:
        "Fix it once in the right place and the whole site benefits."
    }
  };

  /* -------------------------------------------------------------------- *
   * Helpers used by the resolver
   * -------------------------------------------------------------------- */

  function textOf(result) {
    if (!result) {
      return "";
    }
    var parts = [];
    var keys = [
      "message",
      "messageDesktop",
      "messageMobile",
      "messageTitle",
      "messageDesc",
      "messageImage",
      "messageURL",
      "messageImageAlt"
    ];
    keys.forEach(function (key) {
      if (typeof result[key] === "string") {
        parts.push(result[key]);
      }
    });

    var problemLists = [
      "problems",
      "problemsDesc",
      "problemsImage",
      "problemsURL",
      "problemsImageAlt"
    ];
    problemLists.forEach(function (key) {
      var list = result[key];
      if (!Array.isArray(list)) {
        return;
      }
      list.forEach(function (item) {
        if (typeof item === "string") {
          parts.push(item);
        } else if (item && Array.isArray(item.imageProblems)) {
          parts.push(item.imageProblems.join(" "));
        }
      });
    });

    return parts.join(" ").toLowerCase();
  }

  function matches(haystack, pattern) {
    return new RegExp(pattern, "i").test(haystack);
  }

  function isFalse(value) {
    return value === false || value === 0 || value === "0";
  }

  /* -------------------------------------------------------------------- *
   * Case resolution: switch on the test, then on the reason it failed
   * -------------------------------------------------------------------- */

  function resolveCase(testName, result) {
    var text = textOf(result);
    var title = String(testName || "").trim();

    switch (title) {
      case "Meta Title":
        if (matches(text, "not exist|missing|is empty")) {
          return "meta_title.missing";
        }
        if (matches(text, "more than")) {
          return "meta_title.too_long";
        }
        if (matches(text, "less than")) {
          return "meta_title.too_short";
        }
        if (matches(text, "casing")) {
          return "meta_title.casing";
        }
        return "meta_title.missing";

      case "Meta Description":
        if (matches(text, "not exist|missing|is empty")) {
          return "meta_description.missing";
        }
        if (matches(text, "more than")) {
          return "meta_description.too_long";
        }
        if (matches(text, "less than")) {
          return "meta_description.too_short";
        }
        return "meta_description.missing";

      case "Canonical URL":
        if (matches(text, "not exactly the same|does not match|not the same")) {
          return "canonical.mismatch";
        }
        return "canonical.missing";

      case "Robots Meta":
      case "Robots Meta Tag":
        return "robots_meta.noindex";

      case "Robots.txt":
        if (matches(text, "block")) {
          return "robots_txt.blocked";
        }
        return "robots_txt.missing";

      case "Headings":
        if (matches(text, "h1") && matches(text, "no |not |missing|zero|0 ")) {
          return "headings.no_h1";
        }
        if (matches(text, "more than|exceed|maximum")) {
          return "headings.too_many";
        }
        return "headings.no_h1";

      case "Images": {
        var imageReasons = 0;
        if (matches(text, "alternate text")) {
          imageReasons++;
        }
        if (matches(text, "file size")) {
          imageReasons++;
        }
        if (matches(text, "file name")) {
          imageReasons++;
        }
        if (imageReasons > 1) {
          return "images.multiple";
        }
        if (matches(text, "alternate text")) {
          return "images.alt_missing";
        }
        if (matches(text, "file size")) {
          return "images.oversized";
        }
        if (matches(text, "file name")) {
          return "images.filename";
        }
        return "images.multiple";
      }

      case "URL Slug": {
        var slugReasons = [];
        if (matches(text, "uppercase")) {
          slugReasons.push("url_slug.uppercase");
        }
        if (matches(text, "number")) {
          slugReasons.push("url_slug.numbers");
        }
        if (matches(text, "special")) {
          slugReasons.push("url_slug.special_characters");
        }
        if (matches(text, "more than|exceed|maximum")) {
          slugReasons.push("url_slug.too_long");
        }
        if (matches(text, "hyphen|underscore|separated")) {
          slugReasons.push("url_slug.separator");
        }
        if (matches(text, "stop word")) {
          slugReasons.push("url_slug.stop_words");
        }
        if (slugReasons.length > 1) {
          return "url_slug.multiple";
        }
        return slugReasons[0] || "url_slug.multiple";
      }

      case "Broken Links":
        if (result && result.status_url === 0) {
          return "broken_links.unreachable";
        }
        if (matches(text, "could not|unable|failed to parse")) {
          return "broken_links.unreachable";
        }
        return "broken_links.found";

      case "XML Sitemap":
        if (matches(text, "not added|not found in|not listed|not present")) {
          return "xml_sitemap.not_listed";
        }
        return "xml_sitemap.missing";

      case "HTML Sitemap":
        if (matches(text, "not added|not found in|not listed|not present")) {
          return "html_sitemap.not_listed";
        }
        return "html_sitemap.missing";

      case "Open Graph Tags":
      case "Og Title":
        if (matches(text, "cloudflare|challenge|blocked|could not be read")) {
          return "og.blocked";
        }
        if (isFalse(result && result.statusTitle)) {
          return "og.title";
        }
        if (isFalse(result && result.statusDesc)) {
          return "og.description";
        }
        if (isFalse(result && result.statusImage)) {
          return "og.image";
        }
        if (isFalse(result && result.statusURL)) {
          return "og.url";
        }
        if (matches(text, "og:image|image")) {
          return "og.image";
        }
        if (matches(text, "og:description|description")) {
          return "og.description";
        }
        if (matches(text, "og:url|url")) {
          return "og.url";
        }
        return "og.title";

      case "Twitter Tags":
        if (isFalse(result && result.statusImageAlt)) {
          return "twitter.image_alt";
        }
        if (isFalse(result && result.statusImage)) {
          return "twitter.image";
        }
        if (isFalse(result && result.statusTitle)) {
          return "twitter.title";
        }
        if (matches(text, "alt")) {
          return "twitter.image_alt";
        }
        if (matches(text, "image")) {
          return "twitter.image";
        }
        return "twitter.title";

      case "Favicon":
        if (matches(text, "width|height|dimension|pixel|size")) {
          return "favicon.dimensions";
        }
        return "favicon.missing";

      case "Meta Viewport":
        return "viewport.missing";

      case "Doctype":
        return "doctype.missing";

      case "HTTP Status Code": {
        var code = parseInt(result && result.httpCode, 10);
        if (code >= 300 && code < 400) {
          return "http_status.redirect";
        }
        if (code >= 400 && code < 500) {
          return "http_status.client_error";
        }
        if (code >= 500) {
          return "http_status.server_error";
        }
        return "http_status.unexpected";
      }

      case "Schema":
        if (matches(text, "parse|invalid json|malformed|syntax")) {
          return "schema.invalid_json";
        }
        if (matches(text, "@type|type is missing|no type")) {
          return "schema.missing_type";
        }
        if (matches(text, "http|request|could not be retrieved|status")) {
          return "schema.http";
        }
        return "schema.missing";

      case "CSS Caching":
        return "css_caching.disabled";

      case "JS Caching":
        return "js_caching.disabled";

      case "Gzip Compression":
        return "gzip.disabled";

      case "HTML Compression":
        return "html_compression.disabled";

      case "CSS Compression":
        return "css_compression.disabled";

      case "JS Compression":
        return "js_compression.disabled";

      case "HTML Page Size":
      case "Page Size":
        return "page_size.too_large";

      case "Nested Tables":
        return "nested_tables.found";

      case "Frameset":
        return "frameset.found";

      case "Content Security Policy Header":
        return "csp.missing";

      case "X Frame Options Header":
        return "x_frame.missing";

      case "HSTS Header":
        return "hsts.missing";

      case "Bad content type":
      case "Bad Content Type":
        return "bad_content_type.mismatch";

      case "Directory Browsing":
        return "directory_browsing.enabled";

      case "Safe Browsing":
        return "safe_browsing.unsafe";

      case "Unsafe Cross Origin Links":
        return "cross_origin.unsafe";

      case "Protocol Relative Resource Links":
        return "protocol_relative.found";

      case "SSL Cetificate enable":
      case "SSL Certificate":
        return "ssl.missing";

      case "Google Page Speed Overall Score":
      case "Overall Score": {
        var desktopFailed = isFalse(result && result.statusDesktop);
        var mobileFailed = isFalse(result && result.statusMobile);
        if (desktopFailed && mobileFailed) {
          return "pagespeed.both";
        }
        if (mobileFailed) {
          return "pagespeed.mobile";
        }
        if (desktopFailed) {
          return "pagespeed.desktop";
        }
        return "pagespeed.both";
      }

      case "Lighthouse Score":
        if (
          isFalse(result && result.statusPerformanceDesktop) ||
          isFalse(result && result.statusPerformanceMobile)
        ) {
          return "lighthouse.performance";
        }
        if (
          isFalse(result && result.statusAccessibilityDesktop) ||
          isFalse(result && result.statusAccessibilityMobile)
        ) {
          return "lighthouse.accessibility";
        }
        if (
          isFalse(result && result.statusBestPracticesDesktop) ||
          isFalse(result && result.statusBestPracticesMobile)
        ) {
          return "lighthouse.best_practices";
        }
        if (
          isFalse(result && result.statusSEODesktop) ||
          isFalse(result && result.statusSEOMobile)
        ) {
          return "lighthouse.seo";
        }
        if (matches(text, "accessibility")) {
          return "lighthouse.accessibility";
        }
        if (matches(text, "best practice")) {
          return "lighthouse.best_practices";
        }
        if (matches(text, "seo")) {
          return "lighthouse.seo";
        }
        return "lighthouse.performance";

      case "Core Web Vitals": {
        var metrics = [
          ["core_web_vitals.lcp", ["statusLCPDesktop", "statusLCPMobile"]],
          ["core_web_vitals.cls", ["statusCLSDesktop", "statusCLSMobile"]],
          ["core_web_vitals.fcp", ["statusFCPDesktop", "statusFCPMobile"]],
          ["core_web_vitals.fid", ["statusFIDDesktop", "statusFIDMobile"]],
          ["core_web_vitals.tbt", ["statusTBTDesktop", "statusTBTMobile"]],
          ["core_web_vitals.tti", ["statusTTIDesktop", "statusTTIMobile"]],
          ["core_web_vitals.speed_index", ["statusSIDesktop", "statusSIMobile"]]
        ];
        var failing = metrics.filter(function (metric) {
          return metric[1].some(function (key) {
            return isFalse(result && result[key]);
          });
        });
        if (failing.length > 1) {
          return "core_web_vitals.multiple";
        }
        if (failing.length === 1) {
          return failing[0][0];
        }
        if (matches(text, "largest contentful|lcp")) {
          return "core_web_vitals.lcp";
        }
        if (matches(text, "layout shift|cls")) {
          return "core_web_vitals.cls";
        }
        if (matches(text, "first contentful|fcp")) {
          return "core_web_vitals.fcp";
        }
        if (matches(text, "blocking time|tbt")) {
          return "core_web_vitals.tbt";
        }
        if (matches(text, "interactive|tti")) {
          return "core_web_vitals.tti";
        }
        if (matches(text, "speed index")) {
          return "core_web_vitals.speed_index";
        }
        if (matches(text, "input delay|fid")) {
          return "core_web_vitals.fid";
        }
        return "core_web_vitals.multiple";
      }

      case "Google Mobile Friendly Test":
      case "Mobile Friendliness":
        return "mobile_friendly.failed";

      default:
        return "generic.failed";
    }
  }

  /* -------------------------------------------------------------------- *
   * Rendering
   * -------------------------------------------------------------------- */

  function escapeHTML(value) {
    return String(value === null || value === undefined ? "" : value)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;");
  }

  /**
   * Flatten the various problem shapes the backend returns into plain strings
   * so the modal can show what was actually detected on this page.
   */
  function detectedProblems(result) {
    if (!result) {
      return [];
    }
    var found = [];
    [
      "problems",
      "problemsDesc",
      "problemsImage",
      "problemsURL",
      "problemsImageAlt"
    ].forEach(function (key) {
      var list = result[key];
      if (!Array.isArray(list)) {
        return;
      }
      list.forEach(function (item) {
        if (typeof item === "string" && item.trim()) {
          found.push(item.trim());
        } else if (item && Array.isArray(item.imageProblems)) {
          item.imageProblems.forEach(function (problem) {
            var label = item.imageName ? item.imageName + ": " + problem : problem;
            if (found.indexOf(label) === -1) {
              found.push(label);
            }
          });
        }
      });
    });

    var unique = [];
    found.forEach(function (item) {
      if (unique.indexOf(item) === -1) {
        unique.push(item);
      }
    });

    return unique.slice(0, 12);
  }

  function buildBody(entry, result) {
    var problems = detectedProblems(result);
    var message = result && typeof result.message === "string" ? result.message.trim() : "";

    var html = "";

    html += '<section class="htf-section htf-section--intro">';
    html += '<h3 class="htf-section-title">What went wrong</h3>';
    html += '<p class="htf-text">' + entry.intro + "</p>";
    html += "</section>";

    if (message || problems.length) {
      html += '<section class="htf-section htf-section--detected">';
      html += '<h3 class="htf-section-title">Detected on this page</h3>';
      html += '<div class="htf-detected">';
      if (message) {
        html += '<p class="htf-detected-message">' + escapeHTML(message) + "</p>";
      }
      if (problems.length) {
        html += '<ul class="htf-detected-list">';
        problems.forEach(function (problem) {
          html += "<li>" + escapeHTML(problem) + "</li>";
        });
        html += "</ul>";
      }
      html += "</div>";
      html += "</section>";
    }

    html += '<section class="htf-section htf-section--fix">';
    html += '<h3 class="htf-section-title">How to fix it</h3>';
    html += '<p class="htf-text">' + entry.fix.paragraph + "</p>";
    html += '<ol class="htf-steps">';
    entry.fix.steps.forEach(function (step) {
      html += "<li>" + step + "</li>";
    });
    html += "</ol>";
    html += "</section>";

    html += '<section class="htf-section htf-section--consequence">';
    html += '<h3 class="htf-section-title">If you leave this unfixed</h3>';
    html += '<p class="htf-text">' + entry.consequence + "</p>";
    html += "</section>";

    html += '<p class="htf-closing">' + entry.closing + "</p>";

    return html;
  }

  var HowToFix = {
    CONTENT: CONTENT,

    resolveCase: resolveCase,

    /**
     * Build everything the modal needs for one failed test.
     *
     * @param {string} testName Card title, e.g. "Meta Title".
     * @param {object} [result] Result object returned by the backend.
     */
    render: function (testName, result) {
      var caseKey = resolveCase(testName, result);
      var entry = CONTENT[caseKey] || CONTENT["generic.failed"];
      // Only a documentation URL written for this specific failure belongs here.
      // The generic per-test link already lives in the card's help tooltip.
      var learnMore = entry.learnMore || "";

      return {
        caseKey: caseKey,
        testName: testName || "",
        headerTitle: entry.name,
        errorName: entry.name,
        contentHTML: buildBody(entry, result),
        learnMoreURL: learnMore,
        video_url: entry.video || ""
      };
    }
  };

  global.HowToFix = HowToFix;
})(window);
