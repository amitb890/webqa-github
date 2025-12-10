@extends('layouts.master')
@section('title', 'Free SEO Tools For Your Website | Webqa')
@section('meta-description', 'This is tool page meta description.')
@section("content")

    <!-- main sections starts -->
    <main class="main-sections blog-padding">
      <div class="inner_content">
        <div class="container-fluid tools-landingpage-container">
          <!-- tools page root start -->
          <div class="tools-root-main-area">
            <!-- tools title area start -->
            <div class="tools-root-title">
              <h1><span>Free SEO Tools</span> to Extract Data from Your Website</h1>
              <p>Use our range of free seo tools to extract seo data for your website. From meta tags, to images, to headings, page speed, coding best practices to sitemaps, we have got you covered.</p>
            </div>
            <!-- tools title area end -->
            <!-- search area start -->
            <div class="tools-root-search">
              <input type="search" placeholder="Search tools..." id="search">
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <!-- search area end -->
            <!-- tab area start -->
            <div class="tools-root-tab-area">
              <div class="tools-root-tab">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">SEO</button>
                  <button class="nav-link" id="v-pills-six-tab" data-bs-toggle="pill" data-bs-target="#v-pills-six" type="button" role="tab" aria-controls="v-pills-six" aria-selected="false">Performance</button>
                  <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Best practices</button>
                  <button class="nav-link" id="v-pills-five-tab" data-bs-toggle="pill" data-bs-target="#v-pills-five" type="button" role="tab" aria-controls="v-pills-five" aria-selected="false">Security</button>
                  
                  
  <!-- Uncoment the below code to see all the other stuff which isn't built yet -->                
<!-- 
<button class="nav-link" id="v-pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#v-pills-disabled" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false">Other tests</button>
-->

                  
               
                </div>
              </div>
              <div class="tools-root-content">
                <div class="tab-content" id="v-pills-tabContent">
                  <!-- Search -->
                  <div class="tab-pane fade" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab" tabindex="0">
                    <div class="tools-root-tab-content-title">
                      <h2>Search</h2>
                      <p id="searchText"></p>
                    </div>

                    <div class="tools-root-items-main"></div>
                  </div>

                  <!-- meta tag -->
                  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <div class="tools-root-tab-content-title">
                      <h2>Meta Tags</h2>
                      <p>Meta tags are snippets of text that briefly describe the content of the page. Meta tags don’t appear on the page but appear in the source code of the page. Meta tags are used to tell search engines what your page is all about.</p>
                    </div>
                    <div class="tools-root-items-main">
                      <!-- Meta title -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/title.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'meta-title'])}}">Meta Title</a>
                          <p>A meta title, also known as a title tag, refers to the text that is displayed on search engine result pages and browser tabs to indicate the topic of a webpage.</p>
                        </div>
                      </div>

                      <!-- Meta description -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/descrip.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'meta-description'])}}">Meta Description</a>
                          <p>Meta Description is displayed in the SERPs under the meta title and summarizes the information on that webpage. Test your meta descriptions for accuracy.</p>
                        </div>
                      </div>

                      <!-- Robots Meta -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/robots.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'robots-meta'])}}">Robots Meta</a>
                          <p>Robots Meta is a piece of HTML code that specifies how search engines will index a URL. Check to see if you have used the tags incorrectly, affecting your ranking.</p>
                        </div>
                      </div>

                      <!-- Canonical -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/url.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'canonical-url'])}}">Canonical URL</a>
                          <p>A canonical URL is used to control issues of content duplicity. Use this test to check for Use this test to look for discrepancies and irregularities in canonical URLs.</p>
                        </div>
                      </div>
                      
                      <!-- Images -->
                       <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/images.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'images'])}}">Images</a>
                          <p>Alt text is inserted as an attribute in an HTML document to tell viewers the gist of an image that cannot be rendered. Check whether your website has proper alt attributes.</p>
                        </div>
                      </div>
                      
                      <!-- URL Slug -->
                      
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/broken.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'url-slug'])}}">URL Slug</a>
                          <p>A URL slug is the human-readable, SEO-friendly segment of a URL that uniquely identifies a page. Use this test to look for discrepancies and irregularities in URL slugs.</p>
                        </div>
                      </div>
                      
                      <!-- Robots.txt -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/robots_txt.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'robotstxt-test'])}}">Robots.txt</a>
                          <p>Test to see if your website is using HTTPS, a secure protocol for sending and receiving data over the Internet. Google is increasingly adopting SSL as a good ranking criterion.</p>
                        </div>
                      </div>
                      
                      <!-- Headings -->
                      
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/headings.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'headings'])}}">Headings</a>
                          <p>Headings structure the content of a webpage and help search engines and users understand the hierarchy of information.Use this test to look for discrepancies and irregularities in headings.</p>
                        </div>
                      </div>
                      
                      <!-- Open Graph Tags -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/graph.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'og-tags'])}}">Open Graph Tags</a>
                          <p>Open Graph Tags are parts of code that control how URLs are displayed when shared on Facebook. You can find them in the <span><</span>head> section of a webpage.</p>
                        </div>
                      </div>
                      
                      <!-- Twitter Tags -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/twiter.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'twitter-tags'])}}">Twitter Tags</a>
                          <p>The metadata values that Twitter uses to show text, images, and videos when you post links. Check to see if you're presenting your content effectively.</p>
                        </div>
                      </div>
                      
                      <!-- Meta Viewport -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/meta_view.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'meta-viewport'])}}">Meta viewport</a>
                          <p>Meta Viewport is the visible portion of a web page that people can see on their screens. Incorrect viewports will force viewers to side-scroll while browsing the site.</p>
                        </div>
                      </div>
                      
                      <!-- Doctype -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/doctype.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'doctype'])}}">Doctype declaration</a>
                          <p>Every HTML document must begin with <span><</span>!DOCTYPE> declaration. It is not an HTML tag. It informs the browser about the HTML version used in the document.</p>
                        </div>
                      </div>
                      
                      <!-- Favicon -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/favicon.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'favicon'])}}">Favicon Test</a>
                          <p>Check to see if your site is using a favicon properly. Favicons are tiny icons that show up in the URL navigation bar of your browser.</p>
                        </div>
                      </div>
                      
                      <!-- HTTP Status code -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/http_status_code.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">HTTP Status Code</a>
                          <p>Status codes for HTTP responses show if a particular HTTP request has been successfully responded to.</p>
                        </div>
                      </div>
                      
                      <!-- XMl Sitemap -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/title.png" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'xml-sitemap'])}}">XML Sitemap</a>
                          <p>HTML sitemaps are purportedly useful for website visitors. An HTML sitemap is simply a clickable list of a website's pages.</p>
                        </div>
                      </div>
                      
                      
                      <!-- HTML Sitemap -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/graph.png" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'html-sitemap'])}}">HTML Sitemap</a>
                          <p>An XML sitemap displays all of the pages on your website that are crawlable along with other helpful details like crawling priority and last updated times.</p>
                        </div>
                      </div>
                      
                      
                      
                      
                      
                      
                    </div>
                  </div>
                  
                  <!-- on page -->
                  <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">
                    <div class="tools-root-tab-content-title">
                      <h2>Tests to be done</h2>
                      <p>These tests are yet to be done.</p>
                    </div>
                    <div class="tools-root-items-main">
                      
                      
                     <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/https.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Page Cache</a>
                          <p>Check if your page is showing cached content. To reduce server load and speed up loading, a page cache saves dynamically generated pages, serving the previously created (cached) page.</p>
                        </div>
                      </div>


                       <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/image_caching.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Image Caching</a>
                          <p>Check to see if your page has an image expiration tag that provides a future expiration date for your photos.</p>
                        </div>
                      </div>


                       <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/modern_image_format.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Modern Image Format</a>
                          <p>Test if your website is displaying photos in modern formats. When compared to PNG or JPEG, image formats like JPEG 2000, JPEG XR, and WebP typically offer better compression.</p>
                        </div>
                      </div>

                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/graph.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Render Blocking Resources</a>
                          <p>This test will look for any JavaScript or CSS resources that are preventing the webpage from rendering properly.</p>
                        </div>
                      </div>

                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/flash.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Flash</a>
                          <p>Check your website to see if it makes use of Flash, an obsolete platform that was often employed to deliver rich multimedia content.</p>
                        </div>
                      </div>

                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/tags.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">CDN</a>
                          <p>Check if your website's resources (images, javascript, and CSS files) are supplied via CDNs. A Content Delivery Network (CDN) provides excellent performance while enabling rapid asset transfers.</p>
                        </div>
                      </div>

                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/https.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Page Objects</a>
                          <p>Examine whether all of the objects requested by this webpage can be retrieved. If they cannot be retrieved, your page may appear improperly, resulting in poor search engine rankings.</p>
                        </div>
                      </div>

                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/https.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">JS Execution Time</a>
                          <p>This test will determine the total execution time of the JavaScript code. Enhanced JavaScript performance will lead to quicker page loads and a better user experience.</p>
                        </div>
                      </div>

                       <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/url.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">DOM Size</a>
                          <p>The size of the DOM tree will be evaluated in this test. The Document Object Model (DOM) of a web page is created by the browser as soon as it is loaded.</p>
                        </div>
                      </div>

                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/twiter.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Console Errors</a>
                          <p>This will look for flaws in the Chrome DevTools Console. These errors may interfere with users' ability to browse your website properly.</p>
                        </div>
                      </div>

                       <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/test.png" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Inline CSS</a>
                          <p>Inspect your web pages’ HTML tags for inline CSS properties. Inline CSS properties can be removed to reduce page loading time and make website upkeep easier.</p>
                        </div>
                      </div>

                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/graph.png" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">JS Errors</a>
                          <p>Examine your page for JavaScript problems. These bugs may negatively influence the overall user experience.</p>
                        </div>
                      </div>

                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/secure_referrer.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'content-security-policy-header-test'])}}">Secure Referrer Policy Header</a>
                          <p>Secure Referrer is a security header used in communication from the server to a client. When a link takes a user to another page or website, the browser is instructed on how to handle it.</p>
                        </div>
                      </div>
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/x_content_type.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="">X Content Type Options Header</a>
                          <p>The server uses the HTTP response header X-Content-Type-Options to signal that the MIME types advertised in the Content-Type headers should be adhered to and not modified.</p>
                        </div>
                      </div>
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/url.png" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Server Signature</a>
                          <p>Test to see if your server's signature is on. A server signature is the exposed representation of your web server and includes private data that could be used to exploit any security flaw.</p>
                        </div>
                      </div>

                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/headings.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'headings'])}}">Headings</a>
                          <p>Test to see if your website is using HTTPS, a secure protocol for sending and receiving data over the Internet. Google is increasingly adopting SSL as a good ranking criterion.</p>
                        </div>
                      </div>  
                      
                      
                      
                    </div>
                  </div>
                  <!-- best practices -->
                  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">
                    <div class="tools-root-tab-content-title">
                      <h2>Best practices</h2>
                      <p>There are several guidelines to keep in mind when you’re building an HTML-based website. It is important to follow best HTML practices to deliver a flawless user experience and rank better. Utilize the below-mentioned tools to keep your website up to the required standard.</p>
                    </div>
                    <div class="tools-root-items-main">
                        
                      <!-- gzip compression -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/gzip_compression.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'gzip-compression'])}}">Gzip compression</a>
                          <p>GZIP is a compression method that is widely used to transfer data over the internet rapidly. Javascript, CSS, and HTML are reduced in size.</p>
                        </div>
                      </div>
                      <!-- HTML compression -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/html_compression.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'html-compression'])}}">HTML Compression</a>
                          <p>By detecting similar strings within a text file and temporarily replacing them to decrease overall file size, HTML compression significantly enhances website speed.</p>
                        </div>
                      </div>
                      <!-- Css compression -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/css_compression.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'css-compression'])}}">CSS Compression</a>
                          <p>Reduce the size of the CSS code on your website by using our CSS compressor tool. It is quick and easy.</p>
                        </div>
                      </div>
                      <!-- JS compression -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/js_compression.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'js-compression'])}}">JS Compression</a>
                          <p>To make your website load faster, use our JavaScript compressor tool to reduce the size of JavaScript code.</p>
                        </div>
                      </div>
                      
                       <!-- CSS caching  -->
                       <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/css_caching.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">CSS Caching</a>
                          <p>Check to see if all CSS resources on your page are being cached by headers. Run the tool and speed up your website the next time a returning user needs the same CSS resource.</p>
                        </div>
                      </div>
                       
                       <!-- JS caching -->
                       <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/js_caching.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">JS Caching</a>
                          <p>Test to see if all JavaScript resources on your page are being cached using headers. Run the tool and speed up your website the next time a returning user needs the same JS resource.</p>
                        </div>
                      </div>
                        
                        
                       <!-- Page size -->
                       <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/html_page_size.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">HTML Page Size</a>
                          <p>Check the HTML size of your page. The HTML size of your website is the total size of the HTML code, it does not include the size of any images, external javascript, or external CSS files.</p>
                        </div>
                      </div>
                       
                       
                        <!-- Nested Tables -->
                        <div class="tools-root-item">
                        <div class="root-icon">
                           <img src="/new-assets/assets/images/tools-root/nested_tables.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="#">Nested Tables</a>
                          <p>See if there are any nested tables on your website. An HTML table that has another table inside of it is said to be nested. Nested tables result in the slow rendering of web pages.</p>
                        </div>
                      </div>
                      
                      <!-- Frameset  -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/frameset.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'frameset'])}}">Frameset</a>
                          <p>Frames divide your browser window into several portions, each of which can load a different HTML document. Users and search engine robots both have problems with frames.</p>
                        </div>
                      </div>
                      
                      <!-- Broken Links  -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/unsafe_cross.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'broken-links'])}}">Broken Links</a>
                          <p>Frames divide your browser window into several portions, each of which can load a different HTML document. Users and search engine robots both have problems with frames.</p>
                        </div>
                      </div>
                      
   
                    </div>
                  </div>
       
                  <!-- security -->
                  <div class="tab-pane fade" id="v-pills-five" role="tabpanel" aria-labelledby="v-pills-five-tab" tabindex="0">
                    <div class="tools-root-tab-content-title">
                      <h2>Security</h2>
                      <p>The security of your website is just as important as its performance and user-experience. Poor security protocols may also result in having your website flagged as unsafe by search engines, ultimately affecting its ranking. Use the listed tools to keep your website’s security measures up to date.</p>
                    </div>
                    <div class="tools-root-items-main">
                        
                      
                      <!-- Unsafe cross origin links -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/unsafe_cross.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'unsafe-cross-origin-links-test'])}}">Unsafe Cross Origin Links</a>
                          <p>This tool will check whether all links to external pages that have the rel="noopener" or rel="noreferrer" attribute are also rel="noopener" or rel="noreferrer" links.</p>
                        </div>
                      </div>
                      
                       <!-- Protocall relative resource links -->
                       
                       <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/broken.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'protocall-relative-resource-links-test'])}}">Protocal Relative Resource Links</a>
                          <p>Use this test to look for discrepancies and irregularities in resource linking that could cause mixed content issues, insecure connections, or inconsistent behavior across HTTP and HTTPS versions of the site.</p>
                        </div>
                      </div>
                      
                       <!-- Content security policy header -->
                       <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/content_security.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'content-security'])}}">Content Security Policy Header</a>
                          <p>Modern browsers employ an HTTP response header called Content-Security-Policy to strengthen the security of a web page.</p>
                        </div>
                      </div>
                      
                      <!-- X Frame Options Header -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/x_frame_options.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'x-frame-options-header-test'])}}">X Frame Options Header</a>
                          <p>The X-Frame Options HTTP response header can be used to prevent click-jacking attacks by making sure that their content is not included on other sites.</p>
                        </div>
                      </div>
                      
                      <!-- HSTS Header -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/hsts_header.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'hsts-header'])}}">HSTS header</a>
                          <p>Check if the HSTS header is used on your website. HTTP Strict Transport Security pushes browsers to use secure connections when a site is accessible only over HTTPS.</p>
                        </div>
                      </div>
                      
                      <!-- Bad content type -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/bad_content_type.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'bad-content-type-test'])}}">Bad Content Type</a>
                          <p>Test to see if your website is using HTTPS, a secure protocol for sending and receiving data over the Internet. Google is increasingly adopting SSL as a good ranking criterion.</p>
                        </div>
                      </div>
                      
                      <!-- SSL Certificate -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/ssl_https.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'ssl-certificate-test'])}}">SSL and HTTPs</a>
                          <p>Test to see if your website is using HTTPS, a secure protocol for sending and receiving data over the Internet. Google is increasingly adopting SSL as a good ranking criterion.</p>
                        </div>
                      </div>
                      
                      
                       <!-- safe browsing -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/safe_brouwsing.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'safe-browsing-test'])}}">Safe Browsing</a>
                          <p>Check to see if Google's safe browsing API has classified your website as hosting malware or engaging in phishing behaviour.</p>
                        </div>
                      </div>
                      
                      <!-- directory browsing -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/directory_browsing.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'safe-browsing-test'])}}">Directory Browsing</a>
                          <p>See if your server supports directory browsing. Visitors won't be able to directly access your directory and browse if it is off. This safeguards your files from public view.</p>
                        </div>
                      </div>
                      
      
                    </div>
                  </div>
                  <!-- performance -->
                  <div class="tab-pane fade" id="v-pills-six" role="tabpanel" aria-labelledby="v-pills-six-tab" tabindex="0">
                    <div class="tools-root-tab-content-title">
                      <h2>Performance</h2>
                      <p>A website’s performance is affected by several factors, and it is imperative that you test all your web pages against every influencing factor. Use the following tools to test your website’s overall performance on Google.</p>
                    </div>
                    <div class="tools-root-items-main">
                    
                    
                     <!-- overall score -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/google_page speed.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'google-page-speed-insights'])}}">Google Page Speed</a>
                          <p>Examine the Google page speed of each of your web pages. With the aid of our tips, make your web pages fast on all devices.</p>
                        </div>
                      </div>
                      
                       <!-- lighthouse -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/lighthouse.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'google-lighthouse'])}}">Lighthouse</a>
                          <p>Lighthouse is an open-source, automated tool for enhancing web page quality . It includes audits for SEO, performance, and more.</p>
                        </div>
                      </div>
                      
                       <!-- core web vitals -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/core_web_vitals.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'google-core-web-vitals'])}}">Core Web Vitals</a>
                          <p>Core Web Vitals are user experience metrics that are part of Google's Page Experience signals. It assesses interactivity with FID, visual stability with CLS, and visual load with LCP.</p>
                        </div>
                      </div>
                      
                       <!-- mobile friendliness -->
                      <div class="tools-root-item">
                        <div class="root-icon">
                          <img src="/new-assets/assets/images/tools-root/mobile_friendly.svg" alt="icon">
                        </div>
                        <div class="root-content">
                          <a href="{{route('tool', ['slug'=>'mobile-friendliness'])}}">Mobile Friendliness</a>
                          <p>Mobile friendliness test evaluates how easily users can navigate a webpage on mobile devices. Use this test to look for discrepancies and irregularities in mobile usability and overall responsive design.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            <!-- tab area end -->
          </div>
          <!-- tools root page end -->
          <!-- Wondering Area Start -->
          <div class="trial-area blog-wondering-mt">
            <div class="trial-content">
              <h2>Wondering why your content isn't
                showing up on the SERPs?</h2>
                <a href="#" class="btn btn_primary rounded-pill">Start Free Trial</a>
            </div>
          </div>
          <!-- Wondering Area End -->
        </div>
      </div>
    </main>
    <!-- main sections ends -->

@endsection

@section("js")

<script>


  const text = "Meta Title"
  let activeElementId = ""
  let activeSearch = false


  function searchTool(input){
    input = input.toLowerCase();
    let status = true, text
    document.querySelector("#v-pills-search .tools-root-items-main").innerHTML = ""

    const elements = document.querySelectorAll(".tools-root-item")
    if(!activeSearch){
      toggleElement("#v-pills-search")
    }
    elements.forEach(element=>{
      const title = element.querySelector("a").textContent.toLowerCase();
      const desc = element.querySelector("p").textContent.toLowerCase();

      if(title.includes(input) || desc.includes(input)){
        const clone = element.cloneNode(true);
        document.querySelector("#v-pills-search .tools-root-items-main").appendChild(clone)
      }
    })


    if(document.querySelectorAll("#v-pills-search .tools-root-item").length > 0){
      text = "Following are your search results..."
    }else{
      text = `Sorry, but we do not have the test - "${input}". Make sure you are not misspelling the test name.`
    }

    buildSearchText(text)

    activeSearch = true
  } 


  function runSearch(e){
    let text = ""
    if(activeElementId != ""){
      activeElementId = document.querySelector(".tab-pane.active").id
    }
    const value = e.target.value
    if(value.length === 0){
      removeSearch()
    }else{
      searchTool(value)
    }
  }

  function buildSearchText(text){
    $("#searchText").html(text)
  }


  function toggleElement(id){
    document.querySelector(".tab-pane.active").classList.remove("show")
    document.querySelector(".tab-pane.active").classList.remove("active")
    document.querySelector(".nav-link.active").classList.remove("active")

    document.querySelector(id).classList.add("active")
    document.querySelector(id).classList.add("show")
  }

  function removeSearch(){
    removeSearchElement(`#v-pills-home`)
    var someTabTriggerEl = document.querySelector('#v-pills-home-tab')
    var tab = new bootstrap.Tab(someTabTriggerEl)
    tab.show()
    activeSearch = false
  }

  function removeSearchElement(){
    document.querySelector("#v-pills-search").classList.remove("show")
    document.querySelector("#v-pills-search").classList.remove("active")
  }

  var triggerTabList = [].slice.call(document.querySelectorAll('.nav-pills button'))
  triggerTabList.forEach(function (triggerEl) {
    var tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', function (event) {
      removeSearchElement()
    })
  })

  document.querySelector("#search").addEventListener("keyup", (e)=>{
    runSearch(e)
  })

  
  $('#search').on('search', function (e) {
    runSearch(e)
  });

</script>

@endsection("js")