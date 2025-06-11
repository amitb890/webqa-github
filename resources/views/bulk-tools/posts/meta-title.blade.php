<!-- post page blog start -->
<div class="single-post-content-main">
              
                <div class="single-post-content">
                  <h2 class="tools_des_fastheading">How to pass the Meta Title test?</h2>
                  <p>In order to pass the Robots Meta Tag test, one must understand its functions, attributes, and importance. Below, we have explained every detail related to the Robots meta tag in great depth. This will assist you in figuring out how to pass the test and optimize your web pages accordingly.</p>
                  
                  <div class="tools_video_popup">
                    <span class="tools_video_img">
                      <img src="/new-assets/assets/images/blog/tools-popup.png" alt="icon">
                      <a class="test-popup-link" href="https://www.youtube.com/watch?v=vQkXF5__TQI"><img src="/new-assets/assets/images/youtube_color.png" alt="play"></a>
                    </span>
                  </div>
                  <h2 id="meta">What is a Robots Meta Tag?</h2>
                  <p>A Robots meta tag is a piece of HTML code that is incorporated into the section of a web page and tells search engines whether a given page should be indexed and shown in search engine result pages or not.</p>
                  
                  <p class="pera_padding">In the source code of a page, a robots meta tag appears like this:</p>

                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="noindex" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <p>There are situations when you do not want specific pages on your website to show up in Google search results. By using the Robots meta tag, you can control which pages show up and which pages do not show up in the search results. Put simply, you can use these page-specific tags to stop required pages from being indexed. Robots meta tags, however, are also frequently used mistakenly. As a result, even the desired pages do not show up in the Google search results. Therefore, it becomes necessary to understand the ins and outs of Robots meta tags and how to check for them.</p>

                  <h2>Understanding the Directives and Attributes Of Robots Meta Tag</h2>

                  <p>There are two attributes: name and content. Each of these properties must have a value assigned to it. Please note that both attributes are non-case sensitive. Let's take a closer look at these attributes.
                  </p>
                  
                  <h2>Name Attribute</h2>

                  <p>The name attribute defines which crawlers should follow the mentioned instructions. This attribute is also known as a user-agent (UA). Your user-agent (UA) indicates the browser in use. However, Google's user agents include Googlebot and Googlebot-image.</p>

                  <p class="pera_padding">For example,</p>
                  
                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="googlebot" content="noindex"></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>
                  
                  <p>All crawlers are represented by the UA variable "robots". Furthermore, you are permitted to include as many robots meta tags as you require to instruct different crawlers. The most common user agents are Google and Bing.</p>

                  <h2>Content Attribute</h2>

                  <p>The content attribute specifies how to crawl and index the page's content. In the event that a web page's meta robots tag is missing, search engines will automatically crawl the page and follow all of its links (unless there is the rel="nofollow" attribute given).
                  </p>

                  <p>Mentioned below are some of the most common values used for content attributes:</p>

                  <h4>noindex</h4>
                  <p class="pera_padding">Stops search engine from indexing the page.</p>
                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="noindex" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <h4>nofollow</h4>
                  <p class="pera_padding">Stops search engine from following the links on the page.</p>
                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="nofollow" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <h4>all</h4>
                  <p class="pera_padding">The default value to specify both index and follow. Not supported by Bing.</p>
                  <button class="tools_link_btn"> 
                    <p><span><</span> meta name="robots" content="all" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <h4>none</h4>
                  <p class="pera_padding">The value to specify both noindex and nofollow. Not supported by Bing.</p>
                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="none" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <h4>noarchive</h4>
                  <p class="pera_padding">Stops search engine from showing a cached version of the page in the SERP.</p>
                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="noarchive" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <h4>notranslate</h4>
                  <p class="pera_padding">Stops search engine from offering page translation in the SERP. Not supported by Bing.
                  </p>
                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="notranslate" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <h4>noimageindex</h4>
                  <p class="pera_padding">Stops search engine from indexing images embedded on the page. Not supported by Bing.</p>
                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="noimageindex" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <h4>unavailable_after</h4>
                  <p class="pera_padding">Instructs search engine not to display a page in search results after a specified date/time.</p>
                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="unavailable_after: Wednesday, 02-Nov-22 12:20:36
                      GMT" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>
                  
                  <h2 class="tools-des-heading">Understanding NoIndex & NoFollow</h2>

                  <h2>What is a "NoIndex" tag?</h2>

                  <p>NoIndex is a meta tag that is placed in a web page's header code to inform search engines that they can crawl the particular page to examine its content but cannot index the page to show it in search engine results. Here's an example of how the NoIndex tag appears in a source code-
                  </p>

                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="noindex" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <p>Indexing is the technique by which Google searches or crawls the internet for new content, which is then incorporated into Google's database of searchable content.
                  </p>

                  <h2>What is a "NoFollow" tag?</h2>

                  <p>NoFollow is a meta tag that is placed into the header code of a webpage to instruct search engines not to follow the links on that page. In practice, this rejects all of the links on that page. Additionally, any of the pages linked through that particular web page will not receive its SERP ranking authority. Please remember that the links on that page might still be indexable, particularly if there are backlinks directed to them. Here's an example of how the NoIndex tag appears in a source code-
                  </p>

                  <button class="tools_link_btn"> 
                    <p><span><</span>meta name="robots" content="nofollow" /></p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <h2>What is the difference between NoFollow and
                    NoIndex?</h2>

                  <p>The functionality of NoIndex and NoFollow is significantly different. NoFollow is used to tell search engine crawlers not to follow the links on your page, while NoIndex is used to tell search engines not to keep your web page for appearance in search results. In brief, NoIndex functions primarily for your web pages and NoFollow for the links on those web pages.
                  </p>

                  <h2>Using “NoIndex” and “NoFollow” Separately</h2>

                  <p>If you want to prevent a search engine from indexing your web page but still want it to follow the links on it, simply use the "noindex" tag. This will give the other pages your page links to better ranking authority. But, when you want a search engine to index your web page but not follow the links on that page, use the "nofollow" tag.
                  </p>

                  <h2>Using “NoIndex, NoFollow” Together</h2>

                  <p class="pera_padding">When you don't want a webpage to be indexed in search results and you also don't want the links on that page to be followed, add both a "noindex" and "nofollow" tag.</p>
                  <p>For instance, you wouldn't need search engines to index or follow the links on the pages where you might have explained an ongoing company offer.</p>

                  <h2>How Can a Page Be Marked as Noindex?</h2>
                  <p class="pera_padding">A NoIndex directive may be given in one of two ways:</p>
                  <ul>
                    <li>Incorporate a “noindex” meta tag into the HTML code of the page</li>
                    <li>In the HTTP response, add a “noindex” header</li>
                  </ul>

                  <h2>How to Mark an Already Indexed Page as NoIndex?</h2>

                  <p class="pera_padding">If you classify a page as “noindex” after it has already been indexed by a search engine, the page   will be eliminated from the search results once it has been crawled again.
                  </p>
                  <p> Remember, if you are mistakenly using the robots.txt file to stop the crawler, this technique of pulling a page from the index won't function. The “noindex” value won't be visible to a crawler if you instruct it not to read the page. Thus, the page will continue to be indexed while its contents won't be updated.</p>

                  <h2>Functions of Robots Meta Tag</h2>
                  <p class="pera_padding">Robots meta tags are used to govern how Google reads and follows the content of your website. This comprises-</p>
                  <ul>
                    <li>If a page should be displayed in search results.</li>
                    <li>deciding whether or not to click on a link (irrespective of the index tag)</li>
                    <li>Prevent the indexing of images on a page</li>
                    <li> Stop search engines from displaying cached copies of a web page</li>
                    <li> Requests that the page's snippet (meta description) not appear on the SERPs</li>
                  </ul>

                  <h2>SEO Importance of Robots Meta Tag</h2>
                  <p class="pera_padding">Despite having other functions, the meta robots tag is frequently used to prevent pages from appearing in search results. You may want to stop search engines from crawling certain content types, including cache, photos, and more.</p>
                  <p>In general, the wider your website is, the more administration of crawling and indexing there is to do. For SEO, it's imperative to adequately combine robots.txt, sitemaps, and page-level instructions.</p>

                  <h2>What is an X-Robots-Tag?</h2>
                  <p class="pera_padding">The robots meta tag is appropriate for enforcing noindex directives on individual HTML pages. But what if you want to stop content such as PDFs from being indexed by search engines? X-robots-tags are then utilized in this situation. While adding meta robots tags to HTML pages is quite simple, adding x-robots-tag is tricky. Any directive that may be used as a meta robots tag can also be utilized as an x-robots-tag because this is an HTTP header response rather than an HTML tag. </p>
                  <p>You must have access to your website's header or server configuration file in order to use the x-robots-tag. If you don't have the authorization for this, you'll have to utilize meta robots tags to guide crawlers. Example of x-robots-tag header response-</p>

                  <button class="tools_link_btn"> 
                    <p>x-robots-tag: noindex, nofollow</p>
                    <span><i class="fa-regular fa-clone"></i></span>
                  </button>

                  <div class="tools_accordion_area">
                    <div class="getting-recover-main recover-faq-area">
                      <h3>FAQs</h3>
                      <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="recover_headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                              How many time I can change the password
                            </button>
                          </h2>
                          <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="recover_headingOne">
                            <div class="accordion-body">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, quod numquam! Iste officia mollitia quasi impedit beatae libero ipsam accusantium unde sapiente optio atque dolore sit ducimus rem magnam,</p>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="recover_headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                              Can I change the password via OTP on mobile and email address?
                            </button>
                          </h2>
                          <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="recover_headingTwo">
                            <div class="accordion-body">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, quod numquam! Iste officia mollitia quasi impedit beatae libero ipsam accusantium unde sapiente optio atque dolore sit ducimus rem magnam,</p>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="recover_headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                              What if I forgot my current password?
                            </button>
                          </h2>
                          <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="recover_headingThree">
                            <div class="accordion-body">
                              <p>Please note that if there are conflicting values, Google will use the most restrictive one. For example, if you give both index and noindex values, Google will follow the noindex value.
                              </p>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="recover_headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                              Do I require password if I signup directly with my google account?
                            </button>
                          </h2>
                          <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="recover_headingFour">
                            <div class="accordion-body">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, quod numquam! Iste officia mollitia quasi impedit beatae libero ipsam accusantium unde sapiente optio atque dolore sit ducimus rem magnam,</p>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="recover_headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
                              Can I set a new password without knowing my current password?
                            </button>
                          </h2>
                          <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="recover_headingFive">
                            <div class="accordion-body">
                              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, quod numquam! Iste officia mollitia quasi impedit beatae libero ipsam accusantium unde sapiente optio atque dolore sit ducimus rem magnam,</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- post page blog end -->