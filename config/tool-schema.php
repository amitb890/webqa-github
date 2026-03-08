<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tool Page Schema Mapping
    |--------------------------------------------------------------------------
    | Map a tool URL (path) to a schema partial Blade view.
    | Keep paths only (no domain) so it works across www/non-www, http/https, etc.
    |--------------------------------------------------------------------------
    */

    '/tool/meta-title'       => 'schemas.tools.meta-title',
    '/tool/meta-description' => 'schemas.tools.meta-description',
    '/tool/robots-meta'      => 'schemas.tools.robots-meta',
    '/tool/canonical-url'    => 'schemas.tools.canonical-url',
    '/tool/images'           => 'schemas.tools.images',
    '/tool/url-slug'         => 'schemas.tools.url-slug',
    '/tool/robotstxt'        => 'schemas.tools.robotstxt',
    '/tool/headings'         => 'schemas.tools.headings',
    '/tool/xml-sitemap'      => 'schemas.tools.xml-sitemap',
    '/tool/og-tags'          => 'schemas.tools.og-tags',
    '/tool/twitter-tags'     => 'schemas.tools.twitter-tags',
    '/tool/favicon'          => 'schemas.tools.favicon',
    '/tool/meta-viewport'    => 'schemas.tools.meta-viewport',
    '/tool/doctype'          => 'schemas.tools.doctype',
    '/tool/http-status-code' => 'schemas.tools.http-status-code',
    '/tool/html-sitemap'     => 'schemas.tools.html-sitemap',


    '/tool/google-page-speed-insights' => 'schemas.tools.overall-score',
    '/tool/google-lighthouse'          => 'schemas.tools.lighthouse',
    '/tool/google-core-web-vitals'     => 'schemas.tools.core-web-vitals',
    '/tool/mobile-friendliness'        => 'schemas.tools.mobile-friendliness',


    '/tool/gzip-compression' => 'schemas.tools.gzip-compression',
    '/tool/html-compression' => 'schemas.tools.html-compression',
    '/tool/css-compression'  => 'schemas.tools.css-compression',
    '/tool/js-compression'   => 'schemas.tools.js-compression',
    '/tool/css-caching-test' => 'schemas.tools.css-caching-test',
    '/tool/js-caching-test'  => 'schemas.tools.js-caching-test',
    '/tool/page-size'        => 'schemas.tools.page-size',
    '/tool/nested-tables'    => 'schemas.tools.nested-tables',
    '/tool/frameset'         => 'schemas.tools.frameset',
    '/tool/broken-links'     => 'schemas.tools.broken-links',



    '/tool/safe-browsing-test' => 'schemas.tools.safe-browsing-test',
    '/tool/unsafe-cross-origin-links-test' => 'schemas.tools.unsafe-cross-origin-links-test',
    '/tool/protocall-relative-resource-links-test' => 'schemas.tools.protocall-relative-resource-links-test',
    '/tool/content-security-policy-header-test' => 'schemas.tools.content-security-policy-header-test',
    '/tool/x-frame-options-header-test' => 'schemas.tools.x-frame-options-header-test',
    '/tool/hsts-header-test' => 'schemas.tools.hsts-header-test',
    '/tool/bad-content-type-test' => 'schemas.tools.bad-content-type-test',
    '/tool/ssl-certificate-test' => 'schemas.tools.ssl-certificate-test',
    '/tool/directory-browsing-test' => 'schemas.tools.directory-browsing-test',




    // Add more tools here...

];
