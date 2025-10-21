@extends('layouts.master')
@include("components.test-title")
@section("content")
@include("components.modal-update-status-robots")
@include("components.modal-failed-urls")
@include("components.modal-email")
<link rel="stylesheet" href="{{ asset('new-assets/vendor/datatables/datatables.min.css') }}" />

    <!-- main sections starts -->
    <main class="main-sections">
    <input hidden value="{{json_encode($d)}}" id="data_value">
      <div class="inner_content inner_content-tools">
        <div class="container-fluid">
          <div class="tools_top_area">
            <div class="tools_sidebar">
              <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse_tools_1" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                     SEO
                    </button>
                  </h2>

                        <?php  
                            $seoStatus = false;
                            $seo = $data["seo"];
                            foreach($seo as $el){
                                if($el["name"] === $d["name"]){
                                    $seoStatus = true;
                                }
                            }
                        ?>
                  <div id="panelsStayOpen-collapse_tools_1" class="accordion-collapse collapse {{$seoStatus ? 'show' : ''}}" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                    
                    @foreach($data["seo"] as $el)
                        <?php $slug = 'tool/' . $el["slug"];?>
                        <a href="/{{$el['route']}}" class="{{ Request::path() === $slug ? 'active' : '' }}">{{$el["displayName"]}}<i class="fa-solid fa-angle-right"></i></a>
                    @endforeach
                    </div>
                  </div>
                </div>
             
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse_tools_3" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                      Performance
                    </button>
                  </h2>

                  <?php  
                    $performanceStatus = false;
                    $performance = $data["performance"];
                    foreach($performance as $el){
                        if($el["name"] === $d["name"]){
                            $performanceStatus = true;
                        }
                    }
                ?>
                  <div id="panelsStayOpen-collapse_tools_3" class="accordion-collapse collapse {{$performanceStatus ? 'show' : ''}}" aria-labelledby="panelsStayOpen-headingTwo">
                    <div class="accordion-body">
                        @foreach($data["performance"] as $el)
                            <?php $slug = 'tool/' . $el["slug"];?>
                            <a href="/{{$el['route']}}" class="{{ Request::path() === $slug ? 'active' : '' }}">{{$el["displayName"]}}<i class="fa-solid fa-angle-right"></i></a>
                        @endforeach
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse_tools_4" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                      Best Practices
                    </button>
                  </h2>

                  <?php  
                    $bestStatus = false;
                    $best_practices = $data["best_practices"];
                    foreach($best_practices as $el){
                        if($el["name"] === $d["name"]){
                            $bestStatus = true;
                        }
                    }
                ?>
                  <div id="panelsStayOpen-collapse_tools_4" class="accordion-collapse collapse {{$bestStatus ? 'show' : ''}}" aria-labelledby="panelsStayOpen-headingTwo">
                    <div class="accordion-body">
                      @foreach($data["best_practices"] as $el)
                            <?php $slug = 'tool/' . $el["slug"];?>
                            <a href="/{{$el['route']}}" class="{{ Request::path() === $slug ? 'active' : '' }}">{{$el["displayName"]}}<i class="fa-solid fa-angle-right"></i></a>
                        @endforeach
                    </div>
                  </div>
                </div>

                <div class="accordion-item tools-last-accordion">
                  <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse_tools_5" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                      Security
                    </button>
                  </h2>

                    <?php  
                        $securityStatus = false;
                        $security = $data["security"];
                        foreach($security as $el){
                            if($el["name"] === $d["name"]){
                                $securityStatus = true;
                            }
                        }
                    ?>
                  <div id="panelsStayOpen-collapse_tools_5" class="accordion-collapse collapse {{$securityStatus ? 'show' : ''}}" aria-labelledby="panelsStayOpen-headingFive">
                    <div class="accordion-body">
                        @foreach($data["security"] as $el)
                            <?php $slug = 'tool/' . $el["slug"];?>
                            <a href="/{{$el['route']}}" class="{{ Request::path() === $slug ? 'active' : '' }}">{{$el["displayName"]}}<i class="fa-solid fa-angle-right"></i></a>
                        @endforeach
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="tools_body">
            @include("components.loader")

              <div class="tools_body_content">

                <h1>{{$d["main_heading"]}}</h1>
                <p class="col2-p">{{$d["main_para"]}}</p>
                  
                <div class="footer_search_item">
                  <div class="footer_search_box">
                    <textarea class="footer_control bulk_test_textarea" placeholder="Enter upto 100 urls, one url per line" id="urlValue">{{ session('bulkUrl', 'https://www.setmore.com/') }}</textarea>
                  </div>
                </div>



                <!-- Hide/Show test criteria -->
                <div class="dropdown {{isset($d['bulk_ignore']) === true ? 'd-none' : ''}}">
                  <p class="test-criteria">Add Test Criteria <i class="fa-solid fa-angle-down"></i></p>
                  
  
                  <div class="home-meta-content tools_meta_content">
                    <div class="meta-content tools_meta_inner_content">
                      <div class="accor-content bulk-test-criteria">

                        @if($d['slug'] === 'meta-viewport')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="meta_viewport">
                            <label class="form-check-label" for="meta_viewport">Every page must have a Meta Viewport Tag</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'frameset')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="no_frameset">
                            <label class="form-check-label" for="no_frameset">Webpage should not be using any frameset tag</label>
                        </div>
                        @endif
                        

                        @if($d['slug'] === 'doctype')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="doctype">
                            <label class="form-check-label" for="doctype">Every page must have a Meta Viewport Tag</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'broken-links')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="broken_links">
                            <label class="form-check-label" for="broken_links">Check for all broken links(links that do not have 200 status code)</label>
                        </div>
                        @endif


                  
                        @if($d['slug'] === 'http-status-code')
                        
                        @include("components.http-status-code-settings")



                        @endif



                        @if($d['slug'] === 'headings')
                            <div class="accor-content">
                                <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="h1_heading_tag"
                                    checked
                                    
                                />
                                <label
                                    class="form-check-label"
                                    for="h1_heading_tag"
                                >
                                    Every page must have at least one H1 heading tag
                                </label>
                                </div>
                                <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="h1_heading_tag_length"
                                    
                                />
                                <label
                                    class="form-check-label"
                                    for="h1_heading_tag_length"
                                >
                                A page can have at most
                                    <input class="slider-input-text" type="number" id="h1_heading_tag_length_val"  min="0" max="100"> H1 heading tag
                                </label>
                                </div>
                            </div>
                            <div class="accor-content-button">
                            <input
                                class="reset-default btn btn_primary rounded-pill"
                                type="submit"
                                value="Reset"
                                id="defaultH1HeadingTagEnable"
                            />
                            </div>
                      
                            <div class="accor-content">
                                
                                <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="h2_heading_tag_length"
                                    
                                />
                                <label
                                    class="form-check-label"
                                    for="h2_heading_tag_length"
                                >
                                A page can have at most
                                    <input class="slider-input-text" type="number" value="0" id="h2_heading_tag_length_val"  min="0" max="100"> H2 heading tag
                                </label>
                                </div>
            
                                <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="h3_heading_tag_length"
                                    
                                />
                                <label
                                    class="form-check-label"
                                    for="h3_heading_tag_length"
                                >
                                A page can have at most
                                    <input class="slider-input-text" value="0" type="number" id="h3_heading_tag_length_val"  min="0" max="100"> H3 heading tag
                                </label>
                                </div>
            
                                <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="h4_heading_tag_length"
                                    
                                />
                                <label
                                    class="form-check-label"
                                    for="h4_heading_tag_length"
                                >
                                A page can have at most
                                    <input class="slider-input-text" value="0" type="number" id="h4_heading_tag_length_val"  min="0" max="100"> H4 heading tag
                                </label>
                                </div>
            
                                <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="h5_heading_tag_length"
                                    
                                />
                                <label
                                    class="form-check-label"
                                    for="h5_heading_tag_length"
                                >
                                A page can have at most
                                    <input class="slider-input-text" type="number" value="0" id="h5_heading_tag_length_val"  min="0" max="100"> H5 heading tag
                                </label>
                                </div>
            
                                <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="h6_heading_tag_length"
                                    
                                />
                                <label
                                    class="form-check-label"
                                    for="h6_heading_tag_length"
                                >
                                A page can have at most
                                    <input class="slider-input-text" type="number" value="0" id="h6_heading_tag_length_val" min="0" max="100"> H6 heading tag
                                </label>
                                </div>
            
            
                            </div>
                        @endif

                        @if($d['slug'] === 'page-size')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="page_size">
                            <label class="form-check-label" for="page_size">Maximum size of the HTML page should be <input value="100" id="page_size_val" type="number" min="0" max="100"> KB</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'hsts-header-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="hsts_header">
                            <label class="form-check-label" for="hsts_header">Every page must have HSTS enabled</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'bad-content-type-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="bad_content_type">
                            <label class="form-check-label" for="bad_content_type">Bad Content Type.</label>
                        </div>
                        @endif
                       
                        
                        @if($d['slug'] === 'css-caching-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="css_caching_enable">
                            <label class="form-check-label" for="css_caching_enable">CSS Caching</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'mobile-friendliness')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="mobile_friendly">
                            <label class="form-check-label" for="mobile_friendly">Page should be mobile friendly</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'js-caching-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="js_caching_enable">
                            <label class="form-check-label" for="js_caching_enable">JS caching</label>
                        </div>
                        @endif
                        

                        @if($d['slug'] === 'robotstxt-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="robot_text_test_block_url">
                            <label class="form-check-label" for="robot_text_test_block_url">Live URLs Must Not have Robots meta tag (noindex,nofollow), Unless intentionally added on a case by case basis</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'safe-browsing-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_safe_browsing">
                            <label class="form-check-label" for="is_safe_browsing">Every page must have safe browsing enabled</label>
                        </div>
                        @endif
                        @if($d['slug'] === 'unsafe-cross-origin-links-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="cross_origin_links">
                            <label class="form-check-label" for="cross_origin_links">Every page must have safe browsing enabled</label>
                        </div>
                        @endif
                        @if($d['slug'] === 'protocall-relative-resource-links-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="protocol_relative_resource">
                            <label class="form-check-label" for="protocol_relative_resource">Protocall-relative-resource-links-test</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'ssl-certificate-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="ssl_certificate_enable">
                            <label class="form-check-label" for="ssl_certificate_enable">Every page must have safe browsing enabled</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'directory-browsing-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="folder_browsing_enable">
                            <label class="form-check-label" for="folder_browsing_enable">Every page must have safe browsing enabled</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'content-security-policy-header-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="content_security_policy_header">
                            <label class="form-check-label" for="content_security_policy_header">Content Security Policy Header must be enabled.</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'x-frame-options-header-test')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="x_frame_options_header">
                            <label class="form-check-label" for="x_frame_options_header">X Frame Options Header must be enabled.</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'nested-tables')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="no_nested_tables">
                            <label class="form-check-label" for="no_nested_tables">The HTML Page should not have any nested tables.</label>
                        </div>
                        @endif

                      @if($d['slug'] === 'meta-title')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="meta_title">
                            <label class="form-check-label" for="meta_title">Every page must have a meta title tag</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" max-value-check checked type="checkbox" id="max_title_length">
                            <label class="form-check-label" for="max_title_length">Maximum length of the Title tag should be <input value="65" id="max_title_length_val" type="number"> characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" min-value-check type="checkbox" id="min_title_length">
                            <label class="form-check-label" for="min_title_length">Minimum length of the Title tag should be <input value="0" id="min_title_length_val" type="number"> characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_title_equal_h1">
                            <label class="form-check-label" for="is_title_equal_h1">Title tag must not be equal to H1 heading tag</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" has-disabled="true" checked type="checkbox" id="title_casing_both">
                            <label class="form-check-label" for="title_casing_both">Title tag must be either in camel casing or sentence casing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" has-disabled="true" disabled type="checkbox" id="title_casing_camel">
                            <label class="form-check-label" for="title_casing_camel">Title tag must be in camel casing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" has-disabled="true" disabled type="checkbox" id="title_casing_sentence">
                            <label class="form-check-label" for="title_casing_sentence">Title tag must be in sentence casing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_excluded_words">
                            <label class="form-check-label" for="is_excluded_words">Exclude specific words from casing checks (seperate each word with a comma)</label>
                        </div>
                        <div class="form-check">
                            <textarea style="display: none" class="form-control" placeholder="Separate each word with a comma" rows="4" id="excluded_words"></textarea>
                        </div>
                        @endif


                        @if($d['slug'] === 'meta-description')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="meta_desc">
                            <label class="form-check-label" for="meta_desc">Every page must have a meta description tag</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" max-value-check checked type="checkbox" id="max_desc_length">
                            <label class="form-check-label" for="max_desc_length">Maximum length of the description tag should be <input value="160" id="max_desc_length_val" type="number"> characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" min-value-check type="checkbox" id="min_desc_length">
                            <label class="form-check-label" for="min_desc_length">Minimum length of the description tag should be <input value="0" id="min_desc_length_val" type="number"> characters</label>
                        </div>
                        @endif


                        @if($d['slug'] === 'canonical-url')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="canonical_url">
                            <label class="form-check-label" for="canonical_url">Every page must have a canonical URL tag</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="canonical_url_equal_url">
                            <label class="form-check-label" for="canonical_url_equal_url">Canonical URL must be equal to the actual URL (self canonicalise)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="canonical_url_ignore_slash">
                            <label class="form-check-label" for="canonical_url_ignore_slash">Ignore the Trailing Slash in Canonical URL</label>
                        </div>
                        @endif


                        @if($d['slug'] === 'robots-meta')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="live_urls_robots_meta">
                            <label class="form-check-label" for="live_urls_robots_meta">Live URLs Must Not have Robots meta tag
                      (noindex,nofollow), Unless intentionally added
                      on a case by case basis</label>
                        </div>
                        @endif


                        @if($d['slug'] === 'url-slug')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="url_slug_lowercase">
                            <label class="form-check-label" for="url_slug_lowercase">Every character in the URL needs to be lowercase</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="url_no_numbers">
                            <label class="form-check-label" for="url_no_numbers">URLs cannot contain numbers</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="url_no_special">
                            <label class="form-check-label" for="url_no_special">URLs cannot contain special characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="max_url_length">
                            <label class="form-check-label" for="max_url_length">Maximum length of a URL should be <input value="60" id="max_url_length_val" type="number" /> Characters (excluding the domain name)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" has-disabled="true" checked type="checkbox" id="url_casing_only_hyphens">
                            <label class="form-check-label" for="url_casing_only_hyphens">Words in URLs should be separated by Hyphens only</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" has-disabled="true" disabled type="checkbox" id="url_casing_only_underscores">
                            <label class="form-check-label" for="url_casing_only_underscores">Words in URLs should be separated by Underscores only</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" has-disabled="true" disabled type="checkbox" id="url_casing_both">
                            <label class="form-check-label" for="url_casing_both">Words in URLs can be separated by either Hyphens or underscores</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="url_stop_words">
                            <label class="form-check-label" for="url_stop_words">URLs must not contain specific stop words(separate each word with a comma)</label>
                        </div>
                        <div class="form-check">
                            <textarea class="form-check-input"rea style="display: none" class="form-control" id="url_stop_words_val" rows="4" placeholder="Separate each word with a comma"></textarea>
                        </div>
                        @endif


                        @if($d['slug'] === 'og-tags')
                        <div>
                            <h6>OG Title</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="og_title">
                                <label class="form-check-label" for="og_title">Every page must have a OG Title tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" max-value-check checked type="checkbox" id="max_og_title_length">
                                <label class="form-check-label" for="max_og_title_length">Maximum length of OG Title should be <input value="95" id="max_og_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" min-value-check checked type="checkbox" id="min_og_title_length">
                                <label class="form-check-label" for="min_og_title_length">Minimum length of OG Title should be <input value="40" id="min_og_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" has-disabled="true" checked type="checkbox" id="og_title_casing_camel">
                                <label class="form-check-label" for="og_title_casing_camel">OG Title must be in camel casing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" has-disabled="true" disabled type="checkbox" id="og_title_casing_sentence">
                                <label class="form-check-label" for="og_title_casing_sentence">OG Title must be in sentence casing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" has-disabled="true" disabled type="checkbox" id="og_title_casing_both">
                                <label class="form-check-label" for="og_title_casing_both">OG Title must be either in camel casing or sentence casing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_og_title_equal_title">
                                <label class="form-check-label" for="is_og_title_equal_title">OG Title be equal to Title tag</label>
                            </div>
                        </div>

                        <div>
                            <br>
                            <h6>OG Description</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="og_desc">
                                <label class="form-check-label" for="og_desc">Every page must have a OG Description tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" max-value-check checked type="checkbox" id="max_og_desc_length">
                                <label class="form-check-label" for="max_og_desc_length">Maximum length of the OG description tag should be <input value="200" id="max_og_desc_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" min-value-check checked type="checkbox" id="min_og_desc_length">
                                <label class="form-check-label" for="min_og_desc_length">Minimum length of the OG description tag should be <input value="40" id="min_og_desc_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_og_desc_equal_desc">
                                <label class="form-check-label" for="is_og_desc_equal_desc">OG Description must be the same as Meta description</label>
                            </div>
                        </div>

                        <div>
                            <br>
                            <h6>OG Image</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="og_image">
                                <label class="form-check-label" for="og_image">Every page must have a OG Image tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" image-check has-disabled="true" disabled type="checkbox" id="og_image_dimensions_min">
                                <label class="form-check-label" for="og_image_dimensions_min">Width of OG Image should be at least <input id="og_image_width_min" value="0" type="number" /> pixels and height of OG Image should be at least<input id="og_image_height_min" value="0" type="number" /> pixels</label>   
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" image-check has-disabled="true" checked type="checkbox" id="og_image_dimensions_exact">
                                <label class="form-check-label" for="og_image_dimensions_exact">Width of OG Image should be exactly <input id="og_image_width_exact" value="1200" type="number" /> pixels and height of OG Image should be exactly<input id="og_image_height_exact" value="630" type="number" /> pixels</label>   
                            </div>
                        </div>
                        
                        <div>
                            <br>
                            <h6>OG URL</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="og_url">
                                <label class="form-check-label" for="og_url">Every page must have a OG URL tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_og_url_equal_url">
                                <label class="form-check-label" for="is_og_url_equal_url">Open Graph URL must be equal to the actual URL</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="max_og_url_length">
                                <label class="form-check-label" for="max_og_url_length">Maximum length of OG URL should be <input value="60" id="max_og_url_length_val" type="number" /> characters</label>
                            </div>
                        </div>
                        @endif


                        @if($d['slug'] === 'twitter-tags')
                        <div>
                            <br>
                            <h6>Twitter Title</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="twitter_title">
                                <label class="form-check-label" for="twitter_title">Every page must have a Twitter Title tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" max-value-check checked type="checkbox" id="max_twitter_title_length">
                                <label class="form-check-label" for="max_twitter_title_length">Maximum length of Twitter Title should be <input value="175" id="max_twitter_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" min-value-check type="checkbox" id="min_twitter_title_length">
                                <label class="form-check-label" for="min_twitter_title_length">Minimum length of Twitter Title should be <input value="0" id="min_twitter_title_length_val" type="number"> characters</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"  has-disabled="true" checked type="checkbox" id="twitter_title_casing_camel">
                                <label class="form-check-label" for="twitter_title_casing_camel">Twitter Title must be in camel casing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"  has-disabled="true" disabled type="checkbox" id="twitter_title_casing_sentence">
                                <label class="form-check-label" for="twitter_title_casing_sentence">Twitter Title must be in sentence casing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"  has-disabled="true" disabled type="checkbox" id="twitter_title_casing_both">
                                <label class="form-check-label" for="twitter_title_casing_both">Twitter Title must be either in camel casing or sentence casing</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_twitter_title_equal_title">
                                <label class="form-check-label" for="is_twitter_title_equal_title">Twitter Title be equal to Title tag</label>
                            </div>
                        </div>
      
                        <div>
                            <br>
                            <h6>Twitter Image</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="twitter_image">
                                <label class="form-check-label" for="twitter_image">Every page must have a Twitter Image tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" image-check has-disabled="true" disabled type="checkbox" id="twitter_image_dimensions_min">
                                <label class="form-check-label" for="twitter_image_dimensions_min">Width of Twitter Image should be at least <input id="twitter_image_width_min" value="0" type="number" /> pixels and height of Twitter Image should be at least<input id="twitter_image_height_min" value="0" type="number" /> pixels</label>   
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" image-check has-disabled="true" checked type="checkbox" id="twitter_image_dimensions_exact">
                                <label class="form-check-label" for="twitter_image_dimensions_exact">Width of Twitter Image should be exactly <input id="twitter_image_width_exact" value="1200" type="number" /> pixels and height of Twitter Image should be exactly<input id="twitter_image_height_exact" value="675" type="number" /> pixels</label>   
                            </div>
                        </div>
   
                        <div>
                            <br>
                            <h6>Twitter Image Alt</h6>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="twitter_image_alt">
                                <label class="form-check-label" for="twitter_image_alt">Every page must have a Twitter Image ALT tag</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" checked type="checkbox" id="max_twitter_image_alt_length">
                                <label class="form-check-label" for="max_twitter_image_alt_length">Maximum length of Twitter Image ALT should be <input value="400" id="max_twitter_image_alt_length_val" type="number" /> characters</label>   
                            </div>
                        </div>
                        @endif

                        @if($d['slug'] === 'favicon')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="favicon">
                            <label class="form-check-label" for="favicon">Every page must have a Favicon</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" image-check has-disabled="true" type="checkbox" id="favicon_dimensions_min">
                            <label class="form-check-label" for="favicon_dimensions_min">Width of Favicon should be at least <input id="favicon_width_min" value="0" type="number" /> pixels and height of Favicon should be at least<input id="favicon_height_min" value="0" type="number" /> pixels</label>   
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" image-check has-disabled="true" type="checkbox" id="favicon_dimensions_exact">
                            <label class="form-check-label" for="favicon_dimensions_exact">Width of Favicon should be exactly <input id="favicon_width_exact" value="0" type="number" /> pixels and height of Favicon should be exactly<input id="favicon_height_exact" value="0" type="number" /> pixels</label>   
                        </div>
                        @endif

                        @if($d['slug'] === 'html-sitemap')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="html_sitemap">
                            <label class="form-check-label" for="html_sitemap">Every page must be added to HTML sitemap</label>
                        </div>
                        @endif


                        @if($d['slug'] === 'xml-sitemap')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="xml_sitemap">
                            <label class="form-check-label" for="xml_sitemap">Every page must be added to XML sitemap</label>
                        </div>
                        @endif



                        @if($d['slug'] === 'images')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_max_size">
                            <label class="form-check-label" for="image_max_size">Maximum file size of an image file should be <input id="image_max_size_val" value="150"/> KB</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_name_only_hyphens">
                            <label class="form-check-label" for="image_name_only_hyphens">Words in image file must be separated by hyphens only</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_name_no_uppercase">
                            <label class="form-check-label" for="image_name_no_uppercase">Image file name can not have uppercase characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_name_no_special">
                            <label class="form-check-label" for="image_name_no_special">Image file name can not have special characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_name_max_characters">
                            <label class="form-check-label" for="image_name_max_characters">Maximum length of an image file name should be <input id="image_name_max_characters_val" value="50"/> Characters</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_alt">
                            <label class="form-check-label" for="image_alt">An image must have an alt text</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="image_alt_only_spaces">
                            <label class="form-check-label" for="image_alt_only_spaces">Words in alt text must be separated by spaces only</label>
                        </div>
                        @endif


                        @if($d['slug'] === 'html-compression')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_html_compression">
                            <label class="form-check-label" for="is_html_compression">HTML Code has to be compressed and minified</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'css-compression')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_css_compression">
                            <label class="form-check-label" for="is_css_compression">All external stylesheets code must be compressed and minified</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'js-compression')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_js_compression">
                            <label class="form-check-label" for="is_js_compression">All external JavaScript code must be compressed and minified</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'gzip-compression')
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" id="is_gzip_compression">
                            <label class="form-check-label" for="is_gzip_compression">The HTML page must have GZIP compression enabled</label>
                        </div>
                        @endif

                        @if($d['slug'] === 'google-page-speed-insights')
                        <div class="meta-content performance-content performance-content-analysis">
                            <div class="performance-left bg-white">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Desktop</h4>
                                  <svg
                                    width="27"
                                    height="24"
                                    viewBox="0 0 27 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.84603 0.81879C1.49767 1.04256 0.430452 2.01224 0.0919265 3.32044C0.0115984 3.63028 0.000122927 4.45651 0.000122927 10.2631C0.000122927 17.5156 -0.0170902 17.1426 0.355862 17.9115C0.631272 18.4795 1.28537 19.1106 1.89931 19.3975C2.16324 19.5238 2.5362 19.65 2.7198 19.6844C2.94357 19.7246 4.34932 19.7475 6.75342 19.7475H10.4428L9.98376 20.6656L9.52474 21.5836H8.15916C6.8567 21.5836 6.78785 21.5893 6.57555 21.7156C5.95014 22.0656 5.96735 22.9836 6.60424 23.3049C6.81654 23.4197 6.97146 23.4197 13.1395 23.4197C19.3076 23.4197 19.4625 23.4197 19.6748 23.3049C20.3231 22.9779 20.3231 22.0254 19.6748 21.6984C19.474 21.5951 19.3362 21.5836 18.1026 21.5836H16.7543L16.2953 20.6656L15.8362 19.7475H19.5485C23.6395 19.7475 23.6969 19.7418 24.4199 19.3975C24.9592 19.1393 25.6707 18.4336 25.9232 17.9115C26.2961 17.1426 26.2789 17.5098 26.2789 10.2803C26.2789 2.98765 26.2961 3.34339 25.8945 2.5688C25.6133 2.03519 24.9994 1.40978 24.4945 1.16305C23.6625 0.755676 24.6092 0.790102 13.3116 0.778627C7.71162 0.77289 3.00095 0.790102 2.84603 0.81879ZM23.3354 2.67781C23.7256 2.79257 24.0584 3.05076 24.2535 3.37782L24.4141 3.65322L24.4313 10.1828L24.4428 16.7123L24.3223 16.9992C24.2477 17.1656 24.0928 17.3779 23.9436 17.5098C23.4502 17.9459 24.3166 17.9115 13.1395 17.9115C2.00833 17.9115 2.8403 17.9402 2.35259 17.527C2.21488 17.4065 2.04849 17.1828 1.9739 17.0279L1.83619 16.7352V10.2459V3.75077L1.99685 3.45241C2.1862 3.08519 2.47308 2.83847 2.88046 2.70076C3.17308 2.60322 3.64358 2.59748 13.1166 2.59175C21.7518 2.59175 23.083 2.60322 23.3354 2.67781Z"
                                      fill="#222222"
                                    />
                                  </svg>
                                </div>
                                <div class="overall-item">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_insights_desktop"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_insights_desktop"
                                      >
                                        Overall Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="slider-range score-range1">
                                    <span class="span-left">0</span>
                                    <input
                                      id="score1"
                                      type="text"
                                      data-slider-id="slider22"
                                      class="slider-input"
                                      data-slider-min="0"
                                      data-slider-max="100"
                                      data-slider-step="1"
                                      data-slider-value="90"
                                      data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                    { "start": 7, "end": 8, "class": "category2" },
                                                                    { "start": 17, "end": 19 },
                                                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                    { "start": -3, "end": 19 }]'
                                    />
                                    <span class="span-right">100</span>
                                  </div>
                                  <div class="range-value">
                                    <p>Greater than</p>
                                    <input class="slider-input-text" type="number" id="google_insights_desktop_val" value="90" min="0" max="100">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Mobile area -->
                            <div class="performance-right bg-white">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Mobile</h4>
                                  <svg
                                    width="17"
                                    height="29"
                                    viewBox="0 0 17 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.02332 0.0441456C1.31131 0.215246 0.748334 0.822384 0.604829 1.57854C0.527557 1.98698 0.527557 26.2393 0.604829 26.6478C0.726256 27.2714 1.12917 27.8013 1.69767 28.0662L2.01228 28.2153H8.77357H15.5349L15.8495 28.0662C16.418 27.8013 16.8209 27.2714 16.9423 26.6478C17.0196 26.2393 17.0196 1.98698 16.9423 1.57854C16.8209 0.954849 16.418 0.424984 15.8495 0.160053L15.5349 0.0110283L8.88396 -1.14441e-05C5.1142 -1.14441e-05 2.14475 0.0165482 2.02332 0.0441456ZM10.9813 1.47367C11.0255 1.55095 11.0255 1.61718 10.9813 1.69445C10.9261 1.79932 10.8654 1.80484 8.77357 1.80484C6.68171 1.80484 6.621 1.79932 6.5658 1.69445C6.52165 1.61718 6.52165 1.55095 6.5658 1.47367C6.621 1.3688 6.68171 1.36329 8.77357 1.36329C10.8654 1.36329 10.9261 1.3688 10.9813 1.47367ZM15.6729 13.8648V24.7104H8.77357H1.8743V13.8648V3.01911H8.77357H15.6729V13.8648ZM9.08818 25.4335C9.27584 25.5052 9.52973 25.7371 9.6346 25.9358C9.81122 26.2724 9.69532 26.7857 9.38623 27.0452C8.75702 27.575 7.83527 27.139 7.83527 26.3111C7.83527 25.6819 8.50864 25.2127 9.08818 25.4335Z"
                                      fill="black"
                                    />
                                  </svg>
                                </div>
                                <div class="overall-item">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_insights_mobile"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_insights_mobile"
                                      >
                                        Overall Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="slider-range score-range1">
                                    <span class="span-left">0</span>
                                    <input
                                      id="score2"
                                      type="text"
                                      data-slider-id="slider22"
                                      class="slider-input"
                                      data-slider-min="0"
                                      data-slider-max="100"
                                      data-slider-step="1"
                                      data-slider-value="90"
                                      data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                    { "start": 7, "end": 8, "class": "category2" },
                                                                    { "start": 17, "end": 19 },
                                                                    { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                    { "start": -3, "end": 19 }]'
                                    />
                                    <span class="span-right">100</span>
                                  </div>
                                  <div class="range-value">
                                    <p>Greater than</p>
                                    <input class="slider-input-text" type="number" id="google_insights_mobile_val" value="90" min="0" max="100">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endif


                        @if($d['slug'] === 'google-lighthouse')
                        <div class="meta-content performance-content performance-content-analysis">
                            <div class="performance-left bg-white">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Desktop</h4>
                                  <svg
                                    width="27"
                                    height="24"
                                    viewBox="0 0 27 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.84603 0.81879C1.49767 1.04256 0.430452 2.01224 0.0919265 3.32044C0.0115984 3.63028 0.000122927 4.45651 0.000122927 10.2631C0.000122927 17.5156 -0.0170902 17.1426 0.355862 17.9115C0.631272 18.4795 1.28537 19.1106 1.89931 19.3975C2.16324 19.5238 2.5362 19.65 2.7198 19.6844C2.94357 19.7246 4.34932 19.7475 6.75342 19.7475H10.4428L9.98376 20.6656L9.52474 21.5836H8.15916C6.8567 21.5836 6.78785 21.5893 6.57555 21.7156C5.95014 22.0656 5.96735 22.9836 6.60424 23.3049C6.81654 23.4197 6.97146 23.4197 13.1395 23.4197C19.3076 23.4197 19.4625 23.4197 19.6748 23.3049C20.3231 22.9779 20.3231 22.0254 19.6748 21.6984C19.474 21.5951 19.3362 21.5836 18.1026 21.5836H16.7543L16.2953 20.6656L15.8362 19.7475H19.5485C23.6395 19.7475 23.6969 19.7418 24.4199 19.3975C24.9592 19.1393 25.6707 18.4336 25.9232 17.9115C26.2961 17.1426 26.2789 17.5098 26.2789 10.2803C26.2789 2.98765 26.2961 3.34339 25.8945 2.5688C25.6133 2.03519 24.9994 1.40978 24.4945 1.16305C23.6625 0.755676 24.6092 0.790102 13.3116 0.778627C7.71162 0.77289 3.00095 0.790102 2.84603 0.81879ZM23.3354 2.67781C23.7256 2.79257 24.0584 3.05076 24.2535 3.37782L24.4141 3.65322L24.4313 10.1828L24.4428 16.7123L24.3223 16.9992C24.2477 17.1656 24.0928 17.3779 23.9436 17.5098C23.4502 17.9459 24.3166 17.9115 13.1395 17.9115C2.00833 17.9115 2.8403 17.9402 2.35259 17.527C2.21488 17.4065 2.04849 17.1828 1.9739 17.0279L1.83619 16.7352V10.2459V3.75077L1.99685 3.45241C2.1862 3.08519 2.47308 2.83847 2.88046 2.70076C3.17308 2.60322 3.64358 2.59748 13.1166 2.59175C21.7518 2.59175 23.083 2.60322 23.3354 2.67781Z"
                                      fill="#222222"
                                    />
                                  </svg>
                                </div>
                                <!-- single item 1 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_performance_desktop"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_performance_desktop"
                                      >
                                        Performance Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score3"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">100</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_performance_desktop_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 2 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_accessibility_desktop"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_accessibility_desktop"
                                      >
                                        Accessibility
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score4"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_accessibility_desktop_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 3 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_best_practices_desktop"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_best_practices_desktop"
                                      >
                                        Best Practices
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score5"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_best_practices_desktop_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 4 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_seo_desktop"
                                        checked
                                      />
                                      <label class="form-check-label" for="google_seo_desktop">
                                        SEO
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score6"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_seo_desktop_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item -->
                              </div>
                            </div>

                            <!-- mobile area -->
                            <div class="performance-right bg-white">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Mobile</h4>
                                  <svg
                                    width="17"
                                    height="29"
                                    viewBox="0 0 17 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.02332 0.0441456C1.31131 0.215246 0.748334 0.822384 0.604829 1.57854C0.527557 1.98698 0.527557 26.2393 0.604829 26.6478C0.726256 27.2714 1.12917 27.8013 1.69767 28.0662L2.01228 28.2153H8.77357H15.5349L15.8495 28.0662C16.418 27.8013 16.8209 27.2714 16.9423 26.6478C17.0196 26.2393 17.0196 1.98698 16.9423 1.57854C16.8209 0.954849 16.418 0.424984 15.8495 0.160053L15.5349 0.0110283L8.88396 -1.14441e-05C5.1142 -1.14441e-05 2.14475 0.0165482 2.02332 0.0441456ZM10.9813 1.47367C11.0255 1.55095 11.0255 1.61718 10.9813 1.69445C10.9261 1.79932 10.8654 1.80484 8.77357 1.80484C6.68171 1.80484 6.621 1.79932 6.5658 1.69445C6.52165 1.61718 6.52165 1.55095 6.5658 1.47367C6.621 1.3688 6.68171 1.36329 8.77357 1.36329C10.8654 1.36329 10.9261 1.3688 10.9813 1.47367ZM15.6729 13.8648V24.7104H8.77357H1.8743V13.8648V3.01911H8.77357H15.6729V13.8648ZM9.08818 25.4335C9.27584 25.5052 9.52973 25.7371 9.6346 25.9358C9.81122 26.2724 9.69532 26.7857 9.38623 27.0452C8.75702 27.575 7.83527 27.139 7.83527 26.3111C7.83527 25.6819 8.50864 25.2127 9.08818 25.4335Z"
                                      fill="black"
                                    ></path>
                                  </svg>
                                </div>
                                <!-- single item 1 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_performance_mobile"
                                        checked
                                      />
                                      <label class="form-check-label" for="google_performance_mobile">
                                        Performance Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score7"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">100</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_performance_mobile_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 2 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_accessibility_mobile"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_accessibility_mobile"
                                      >
                                        Accessibility
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score8"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_accessibility_mobile_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 3 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_best_practices_mobile"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_best_practices_mobile"
                                      >
                                        Best Practices
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score9"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_best_practices_mobile_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 4 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_seo_mobile"
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_seo_mobile"
                                      >
                                        SEO
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range1">
                                      <span class="span-left">90</span>
                                      <input
                                        id="score10"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="100"
                                        data-slider-step="1"
                                        data-slider-value="90"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">120</span>
                                    </div>
                                    <div class="range-value">
                                      <p>Greater than</p>
                                      <input class="slider-input-text" type="number" id="google_seo_mobile_val" value="90" min="0" max="100">
                                    </div>
                                  </div>
                                </div>
                                <!-- single item -->
                              </div>
                            </div>
                          </div>
                       
                        @endif


                        @if($d['slug'] === 'google-core-web-vitals')
                        <div class="meta-content performance-content performance-content-analysis">
                            <div class="performance-left bg-white">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Desktop</h4>
                                  <svg
                                    width="27"
                                    height="24"
                                    viewBox="0 0 27 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.84603 0.81879C1.49767 1.04256 0.430452 2.01224 0.0919265 3.32044C0.0115984 3.63028 0.000122927 4.45651 0.000122927 10.2631C0.000122927 17.5156 -0.0170902 17.1426 0.355862 17.9115C0.631272 18.4795 1.28537 19.1106 1.89931 19.3975C2.16324 19.5238 2.5362 19.65 2.7198 19.6844C2.94357 19.7246 4.34932 19.7475 6.75342 19.7475H10.4428L9.98376 20.6656L9.52474 21.5836H8.15916C6.8567 21.5836 6.78785 21.5893 6.57555 21.7156C5.95014 22.0656 5.96735 22.9836 6.60424 23.3049C6.81654 23.4197 6.97146 23.4197 13.1395 23.4197C19.3076 23.4197 19.4625 23.4197 19.6748 23.3049C20.3231 22.9779 20.3231 22.0254 19.6748 21.6984C19.474 21.5951 19.3362 21.5836 18.1026 21.5836H16.7543L16.2953 20.6656L15.8362 19.7475H19.5485C23.6395 19.7475 23.6969 19.7418 24.4199 19.3975C24.9592 19.1393 25.6707 18.4336 25.9232 17.9115C26.2961 17.1426 26.2789 17.5098 26.2789 10.2803C26.2789 2.98765 26.2961 3.34339 25.8945 2.5688C25.6133 2.03519 24.9994 1.40978 24.4945 1.16305C23.6625 0.755676 24.6092 0.790102 13.3116 0.778627C7.71162 0.77289 3.00095 0.790102 2.84603 0.81879ZM23.3354 2.67781C23.7256 2.79257 24.0584 3.05076 24.2535 3.37782L24.4141 3.65322L24.4313 10.1828L24.4428 16.7123L24.3223 16.9992C24.2477 17.1656 24.0928 17.3779 23.9436 17.5098C23.4502 17.9459 24.3166 17.9115 13.1395 17.9115C2.00833 17.9115 2.8403 17.9402 2.35259 17.527C2.21488 17.4065 2.04849 17.1828 1.9739 17.0279L1.83619 16.7352V10.2459V3.75077L1.99685 3.45241C2.1862 3.08519 2.47308 2.83847 2.88046 2.70076C3.17308 2.60322 3.64358 2.59748 13.1166 2.59175C21.7518 2.59175 23.083 2.60322 23.3354 2.67781Z"
                                      fill="#222222"
                                    />
                                  </svg>
                                </div>
                                <!-- single item 1 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_lcp_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_lcp_desktop"
                                      >
                                        Largest Contentful Paint
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range2">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score11"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="5"
                                        data-slider-step="0.5"
                                        data-slider-value="2.5"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_lcp_desktop_val" value="2.5" min="0" max="5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 2 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_fcp_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_fcp_desktop"
                                      >
                                        First CP Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range2">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score12"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="5"
                                        data-slider-step="0.5"
                                        data-slider-value="2"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_fcp_desktop_val" value="2" min="0" max="5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 3 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_cls_desktop" 
                                        checked
                                      />
                                      <label class="form-check-label" for="google_cls_desktop">
                                        Cumulative Layout Shift
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range3">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score13"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="0.5"
                                        data-slider-step="0.1"
                                        data-slider-value=".1"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">0.5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_cls_desktop_val" value=".1" min="0" max="0.5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 4 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_fid_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_fid_desktop"
                                      >
                                        First Input Delay
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range4">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score14"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="500"
                                        data-slider-step="1"
                                        data-slider-value="100"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">500</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_fid_desktop_val" value="100" min="0" max="500">
                                        <span>ms</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 5 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_tbt_desktop" 
                                        checked
                                      />
                                      <label class="form-check-label" for="google_tbt_desktop">
                                        Total Blocking TIme
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range4">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score15"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="500"
                                        data-slider-step="1"
                                        data-slider-value="300"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">500</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_tbt_desktop_val" value="300" min="0" max="500">
                                        <span>ms</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 6 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_tti_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_tti_desktop"
                                      >
                                        Time to Interactive
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range5">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score16"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="8"
                                        data-slider-step="1"
                                        data-slider-value="4"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">8</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_tti_desktop_val" value="4" min="0" max="8">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 7 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_speed_index_desktop" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_speed_index_desktop"
                                      >
                                        Speed Index
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range5">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score17"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="8"
                                        data-slider-step="1"
                                        data-slider-value="4"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">8</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_speed_index_desktop_val" value="4" min="0" max="8">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item -->
                              </div>
                            </div>

                            <!-- mobile area -->
                            <div class="performance-right bg-white">
                              <div class="accor-content">
                                <div class="performance-title">
                                  <h4>Mobile</h4>
                                  <svg
                                    width="17"
                                    height="29"
                                    viewBox="0 0 17 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M2.02332 0.0441456C1.31131 0.215246 0.748334 0.822384 0.604829 1.57854C0.527557 1.98698 0.527557 26.2393 0.604829 26.6478C0.726256 27.2714 1.12917 27.8013 1.69767 28.0662L2.01228 28.2153H8.77357H15.5349L15.8495 28.0662C16.418 27.8013 16.8209 27.2714 16.9423 26.6478C17.0196 26.2393 17.0196 1.98698 16.9423 1.57854C16.8209 0.954849 16.418 0.424984 15.8495 0.160053L15.5349 0.0110283L8.88396 -1.14441e-05C5.1142 -1.14441e-05 2.14475 0.0165482 2.02332 0.0441456ZM10.9813 1.47367C11.0255 1.55095 11.0255 1.61718 10.9813 1.69445C10.9261 1.79932 10.8654 1.80484 8.77357 1.80484C6.68171 1.80484 6.621 1.79932 6.5658 1.69445C6.52165 1.61718 6.52165 1.55095 6.5658 1.47367C6.621 1.3688 6.68171 1.36329 8.77357 1.36329C10.8654 1.36329 10.9261 1.3688 10.9813 1.47367ZM15.6729 13.8648V24.7104H8.77357H1.8743V13.8648V3.01911H8.77357H15.6729V13.8648ZM9.08818 25.4335C9.27584 25.5052 9.52973 25.7371 9.6346 25.9358C9.81122 26.2724 9.69532 26.7857 9.38623 27.0452C8.75702 27.575 7.83527 27.139 7.83527 26.3111C7.83527 25.6819 8.50864 25.2127 9.08818 25.4335Z"
                                      fill="black"
                                    ></path>
                                  </svg>
                                </div>
                                <!-- single item 1 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_lcp_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_lcp_mobile"
                                      >
                                        Largest Contentful Paint
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range2">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score18"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="5"
                                        data-slider-step="0.5"
                                        data-slider-value="2.5"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_lcp_mobile_val" value="2.5" min="0" max="5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 2 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_fcp_mobile" 
                                        checked
                                      />
                                      <label class="form-check-label" for="google_fcp_mobile">
                                        First CP Score
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range2">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score19"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="5"
                                        data-slider-step="0.5"
                                        data-slider-value="2"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_fcp_mobile_val" value="2" min="0" max="5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 3 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_cls_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_cls_mobile"
                                      >
                                        Cumulative Layout Shift
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range3">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score20"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="0.5"
                                        data-slider-step="0.1"
                                        data-slider-value="0.1"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">0.5</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_cls_mobile_val" value="0.1" min="0" max="0.5">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 4 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_fid_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_fid_mobile"
                                      >
                                        First Input Delay
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range4">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score21"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="500"
                                        data-slider-step="1"
                                        data-slider-value="100"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">500</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_fid_mobile_val" value="100" min="0" max="500">
                                        <span>ms</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 5 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_tbt_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_tbt_mobile"
                                      >
                                        Total Blocking TIme
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range4">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score22"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="500"
                                        data-slider-step="1"
                                        data-slider-value="300"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">500</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_tbt_mobile_val" value="300" min="0" max="500">
                                        <span>ms</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 6 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_tti_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_tti_mobile"
                                      >
                                        Time to Interactive
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range5">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score23"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="8"
                                        data-slider-step="1"
                                        data-slider-value="4"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">8</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_tti_mobile_val" value="4" min="0" max="8">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item 7 -->
                                <div class="overall-item overall-item2">
                                  <div class="tooltips-flex">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="google_speed_index_mobile" 
                                        checked
                                      />
                                      <label
                                        class="form-check-label"
                                        for="google_speed_index_mobile"
                                      >
                                        Speed Index
                                      </label>
                                    </div>
                                    <div class="overall-tooltips">
                                      <div class="tooltips-contents bulk-tooltips-contents">
                                        <p>
                                          Lorem Ipsum is simply dummy text of the
                                          printing and typesetting industry.
                                        </p>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Poor</p>
                                          <h6>0-49</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Average</p>
                                          <h6>50-89</h6>
                                        </div>
                                        <div class="color-flex">
                                          <p><span></span>&nbsp; Good</p>
                                          <h6>90-100</h6>
                                        </div>
                                      </div>
                                      <svg
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                      >
                                        <path
                                          d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                          fill="#D3D5D8"
                                        />
                                      </svg>
                                    </div>
                                  </div>
                                  <div class="score-range-flex">
                                    <div class="slider-range score-range5">
                                      <span class="span-left">0</span>
                                      <input
                                        id="score24"
                                        type="text"
                                        data-slider-id="slider22"
                                        class="slider-input"
                                        data-slider-min="0"
                                        data-slider-max="8"
                                        data-slider-step="1"
                                        data-slider-value="4"
                                        data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                                      { "start": 7, "end": 8, "class": "category2" },
                                                                      { "start": 17, "end": 19 },
                                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                                      { "start": -3, "end": 19 }]'
                                      />
                                      <span class="span-right">8</span>
                                    </div>
                                    <div class="range-value range-value2">
                                      <p>less than</p>
                                      <div class="range-sec">
                                        <input class="slider-input-text" type="number" id="google_speed_index_mobile_val" value="4" min="0" max="8">
                                        <span>sec</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- single item -->
                              </div>
                            </div>
                          </div>
                        @endif

                      </div>
                      <div class="home-content-button">
                        <input class="btn-cancel btn btn_primary rounded-pill toggle-test-criteria" type="submit" value="Cancel">
                        <input class="btn btn_primary rounded-pill toggle-test-criteria" type="submit" value="Done">
                      </div>
                    </div>
                    <div class="accor-content-button">
                      <input class="btn btn_primary rounded-pill" type="reset" value="Reset to Default" id="resetDefaultBulk">
                    </div>
                  </div>
                </div>


              <div class="test-now-btn-container">
                  <button class="btn btn_primary test-now-btn" id="startTestBulk">Test Now</button>
              </div>

              </div>


            </div>
          </div>

          <!-- Test Result Area Start -->
          <div class="test_result_area">

          </div>
          <!-- Test Result Area End -->

          <!-- Tools Meta Description Start-->
          <div class="main_tools_meta_description">
            <div class="blog-main-area single-post-main">
              <!-- post page blog start -->
              
            @if($d['slug'] === 'meta-title')
                @include("bulk-tools.posts.meta-title")
            @elseif($d['slug'] === 'meta-description')
                @include("bulk-tools.posts.meta-desc")
            @elseif($d['slug'] === 'canonical-url')
                @include("bulk-tools.posts.canonical-tag")  
            @elseif($d['slug'] === 'robots-meta')
                @include("bulk-tools.posts.robots-meta")    
            @elseif($d['slug'] === 'url-slug')
                @include("bulk-tools.posts.url-slug")    
            @elseif($d['slug'] === 'og-tags')
                @include("bulk-tools.posts.og-tags")
            @elseif($d['slug'] === 'twitter-tags')
                @include("bulk-tools.posts.twitter-tags")
            @elseif($d['slug'] === 'favicon')
                @include("bulk-tools.posts.favicon")
            @elseif($d['slug'] === 'xml-sitemap')
                @include("bulk-tools.posts.xml-sitemap")
            @elseif($d['slug'] === 'html-sitemap')
                @include("bulk-tools.posts.html-sitemap")
            @elseif($d['slug'] === 'headings')
                @include("bulk-tools.posts.html-sitemap")
                
            @elseif($d['slug'] === 'meta-viewport')
                @include("bulk-tools.posts.meta-viewport")
            @elseif($d['slug'] === 'doctype')
                @include("bulk-tools.posts.doctype") 
            @elseif($d['slug'] === 'images')
                @include("bulk-tools.posts.images") 
            @elseif($d['slug'] === 'http-status-code')
                @include("bulk-tools.posts.http-status-code") 
            @elseif($d['slug'] === 'google-page-speed-insights')
                @include("bulk-tools.posts.page-speed-overall-score") 
            @elseif($d['slug'] === 'google-lighthouse')
                @include("bulk-tools.posts.google-lighthouse") 
            @elseif($d['slug'] === 'google-core-web-vitals')
                @include("bulk-tools.posts.google-core-web-vitals") 
            @elseif($d['slug'] === 'html-compression')
                @include("bulk-tools.posts.html-compression")
            @elseif($d['slug'] === 'css-compression')
                @include("bulk-tools.posts.css-compression")
            @elseif($d['slug'] === 'js-compression')
                @include("bulk-tools.posts.js-compression")
            @elseif($d['slug'] === 'gzip-compression')
                @include("bulk-tools.posts.gzip-compression")
            @elseif($d['slug'] === 'nested-tables')
                @include("bulk-tools.posts.nested-tables")         
            @elseif($d['slug'] === 'frameset')
                @include("bulk-tools.posts.frameset")
            @elseif($d['slug'] === 'page-size')
                @include("bulk-tools.posts.page-size")
            @elseif($d['slug'] === 'x-frame-options-header-test')
                @include("bulk-tools.posts.x-frame-options-header")
            @elseif($d['slug'] === 'content-security-policy-header-test')
                @include("bulk-tools.posts.content-security-policy-header")
            @elseif($d['slug'] === 'hsts-header-test')
                @include("bulk-tools.posts.hsts-header")
            @elseif($d['slug'] === 'safe-browsing-test')
                @include("bulk-tools.posts.safe-browsing")

            @elseif($d['slug'] === 'protocall-relative-resource-links-test')
                @include("bulk-tools.posts.protocall-relative-resource-links")
            @elseif($d['slug'] === 'unsafe-cross-origin-links-test')
                @include("bulk-tools.posts.unsafe-cross-origin-links")
            @elseif($d['slug'] === 'ssl-certificate-test')
                @include("bulk-tools.posts.ssl-certificate")
            @elseif($d['slug'] === 'directory-browsing-test')
                @include("bulk-tools.posts.directory-browsing")
            @elseif($d['slug'] === 'bad-content-type-test')
                 @include("bulk-tools.posts.bad-content-type")
            @elseif($d['slug'] === 'robotstxt')
                 @include("bulk-tools.posts.robotstxt-test")
                 @elseif($d['slug'] === 'js-caching-test')
                 @include("bulk-tools.posts.js-caching-test")
                 @elseif($d['slug'] === 'css-caching-test')
                 @include("bulk-tools.posts.css-caching-test")
                 @elseif($d['slug'] === 'mobile-friendliness')
                 @include("bulk-tools.posts.mobile-friendliness")             
                
                @endif

              <!-- post page blog end -->
            </div>
          </div>
          <!-- Tools Meta Description End-->

          <!-- Trial Area -->
          <div class="trial-area">
            <div class="trial-content">
              <h2>Wondering why your content isn't
                showing up on the SERPs?</h2>
                <a href="#" class="btn btn_primary rounded-pill">Start Free Trial</a>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- main sections ends -->

@endsection

@section("js")
<script src="/new-assets/js/exceljs.min.js"></script>
<script src="/new-assets/js/bulk.js"></script>
<script src="/new-assets/js/exportXlsx.js"></script>
<script src="{{ asset('new-assets/vendor/datatables/datatables.min.js') }}"></script>
@endsection