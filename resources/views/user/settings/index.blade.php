@extends('layouts.app') @section('title', 'Webqa - Settings') @section("content")




<!-- Setting area start  -->
<div class="setting-area">

    @include("components.modal-add-sitemap", ["settings" => $settings]) @include("components.modal-add-broken-links-excluded", ["settings" => $settings])

    <!-- setting menu area start -->
    <div class="setting-menu-area d-none d-sm-block">
        <div class="menu-title">
            <h3>Settings</h3>
        </div>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading1">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#flush-collapse1"
            aria-expanded="true"
            aria-controls="flush-collapse1"
          >
            Website QA
          </button>
        </h2>
                <div id="flush-collapse1" class="accordion-collapse collapse show" aria-labelledby="flush-heading1" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-meta-tab" data-bs-toggle="pill" data-bs-target="#v-pills-meta" type="button" role="tab" aria-controls="v-pills-meta" aria-selected="true">
                                SEO
                            </button>


                            <button class="nav-link" id="v-pills-performance-tab" data-bs-toggle="pill" data-bs-target="#v-pills-performance" type="button" role="tab" aria-controls="v-pills-performance" aria-selected="false">
                                Performance
                            </button>

                            <button class="nav-link" id="v-pills-coding-tab" data-bs-toggle="pill" data-bs-target="#v-pills-coding" type="button" role="tab" aria-controls="v-pills-coding" aria-selected="false">
                                Best Practices
                            </button>

                            <button class="nav-link" id="v-pills-security-tab" data-bs-toggle="pill" data-bs-target="#v-pills-security" type="button" role="tab" aria-controls="v-pills-security" aria-selected="false">
                                Security
                            </button>
                             <button class="nav-link" id="v-pills-reports-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reports" type="button" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports
                             </button>





                        </div>
                    </div>
                </div>
            </div>
            <div class="my-profile">
                <a href="https://webqa.co/test-archive-web-app">
                    <span style="margin:0 auto;">Previous Tests</span>
                </a>
            </div>
        </div>
    </div>
    <!-- setting menu area end -->

    <!-- setting content and tab content area start -->
    <div class="setting-content-area">
        <!-- setting alert start -->
        <div class="setting-alert-area">

            <div class="setting-alert-btn ms-auto">
                <button class="btn btn_primary rounded-pill" type="submit" id="saveSettings">
                    Save Settings
                </button>
            </div>
        </div>
        <!-- setting alert end -->

        <div class="tab-content" id="v-pills-tabContent">
            <!-- meta tag tab content start -->
            <div class="tab-pane fade show active" id="v-pills-meta" role="tabpanel" aria-labelledby="v-pills-meta-tab" tabindex="0">
                <div class="tab-content-area">
                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Meta Title</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" id="switchMetaTitle" {{ $settings->meta_title ? 'checked' : '' }} />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="isMetaTitle" {{ $settings->settingsSub->meta_title ? "checked" : "" }} />
                                        <label class="form-check-label" for="isMetaTitle">
                                            Every page must have a meta title tag
                                        </label>
                                    </div>
                                    <div class="check-range">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="titleMaxLength" {{ $settings->settingsSub->max_title_length ? "checked" : "" }} />
                                            <label class="form-check-label" for="titleMaxLength">
                                                Maximum length of Title tag should be
                                                <input class="slider-input-text" type="number" id="titleMaxLengthVal" value="{{$settings->settingsSub->max_title_length_val}}" min="0" max="100"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range">
                                            <span class="span-left">0</span>
                                            <input id="ex21" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{$settings->settingsSub->max_title_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">100</span>
                                        </div>
                                    </div>
                                    <div class="check-range">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="titleMinLength" {{ $settings->settingsSub->min_title_length ? "checked" : "" }} />
                                            <label class="form-check-label" for="titleMinLength">
                                                Minimum length of Title tag should be
                                                <input class="slider-input-text" type="number" value="{{$settings->settingsSub->min_title_length_val}}" min="0" max="100" id="titleMinLengthVal"> Characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range2">
                                            <span class="span-left">{{$settings->settingsSub->min_title_length_val}}</span>
                                            <input id="ex22" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="30" data-slider-step="1" data-slider-value="{{$settings->settingsSub->min_title_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">30</span>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="titleEquaH1" {{ $settings->settingsSub->is_title_equal_h1 ? "checked" : "" }} />
                                        <label class="form-check-label" for="titleEquaH1">
                                            Title Tag must not be equal to H1 heading tag
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input hideInputCheck" type="checkbox" value="" id="excludedWordsCasing" {{ $settings->settingsSub->is_excluded_words ? "checked" : "" }} />
                                        <label class="form-check-label" for="excludedWordsCasing">
                                            Exclude specific words from casing checks (separate each word with a comma)
                                        </label>
                                    </div>
                                    <textarea class="hideInputCheckElement" placeholder="Separate each word with a comma" id="excludedWordsCasingVal" cols="30" rows="10">{{$settings->settingsSub->excluded_words}}</textarea>
                                    <div class="form-check form-check-black">
                                        <input class="form-check-input toggleCasingChecks" type="checkbox" id="enableTitleCasingChecks" {{ $settings->settingsSub->title_casing_camel || $settings->settingsSub->title_casing_sentence || $settings->settingsSub->title_casing_both ? "checked" : "" }} />
                                        <label class="form-check-label" for="enableTitleCasingChecks">
                                            Enable Casing Checks
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="radioTitleCasing" id="casingBoth" {{ $settings->settingsSub->title_casing_both ? "checked" : "" }} />
                                        <label class="form-check-label" for="casingBoth">
                                            Title Tag must be either in Camel casing or Sentence casing
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="radioTitleCasing" id="casingCamel" {{ $settings->settingsSub->title_casing_camel ? "checked" : "" }} />
                                        <label class="form-check-label" for="casingCamel">
                                            Title Tag must be in Camel casing
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="radioTitleCasing" id="casingSentence" {{ $settings->settingsSub->title_casing_sentence ? "checked" : "" }} />
                                        <label class="form-check-label" for="casingSentence">
                                            Title Tag must be in Sentence casing
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsMetaTitle" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Meta Description</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" id="switchMetaDesc" {{ $settings->meta_desc ? 'checked' : '' }} />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="isMetaDesc" {{ $settings->settingsSub->meta_desc ? "checked" : "" }} />
                                        <label class="form-check-label" for="isMetaDesc">
                                            Every page must have a meta description tag
                                        </label>
                                    </div>
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="metaDescLengthMax" {{ $settings->settingsSub->max_desc_length ? "checked" : "" }} />
                                            <label class="form-check-label" for="metaDescLengthMax">
                                                Maximum length of meta descripiton should be
                                                <input class="slider-input-text" type="number" value="{{ $settings->settingsSub->max_desc_length_val}}" id="metaDescLengthMaxVal" min="0" max="220"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range3">
                                            <span class="span-left">0</span>
                                            <input id="ex23" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="220" data-slider-step="1" value="50" data-slider-value="{{ $settings->settingsSub->max_desc_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">220</span>
                                        </div>
                                    </div>
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="metaDescLengthMin" {{ $settings->settingsSub->min_desc_length ? "checked" : "" }} />
                                            <label class="form-check-label" for="metaDescLengthMin">
                                                Minimum length of meta descripiton should be
                                                <input class="slider-input-text" type="number" value="{{ $settings->settingsSub->min_desc_length_val}}" min="0" max="70" id="metaDescLengthMinVal"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range4">
                                            <span class="span-left">0</span>
                                            <input id="ex24" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="70" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->min_desc_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">70</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsMetaDesc" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Robots Meta Tag</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->robots_meta ? 'checked' : '' }} id="switchRobotsMeta" name="switchRobotsMeta" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="liveRobotsMeta" {{ $settings->settingsSub->live_urls_robots_meta ? "checked" : "" }} />
                                        <label class="form-check-label" for="robots1">
                                            A URL must not have robots meta tag content set to (noindex,nofollow), unless added intentionally
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsRobotsMeta" />
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Canonical URL</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" id="switchCanonical" {{ $settings->canonical_url ? 'checked' : '' }} />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->canonical_url ? "checked" : "" }} id="canonicalUrl" />
                                        <label class="form-check-label" for="canonical1">
                                            Every page must have a canonical URL tag
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->canonical_url_equal_url ? "checked" : "" }} id="canonicalEqualUrl" />
                                        <label class="form-check-label" for="canonical2">
                                            Canonical URL must be equal to the actual URL (self canonicalize)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->canonical_url_ignore_slash ? "checked" : "" }} id="canonicalIgnoreSlash" />
                                        <label class="form-check-label" for="canonical3">
                                            Ignore the trailing slash in Canonical URL
                                        </label>
                                    </div>
                                </div>
        <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsCanonical" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schema accordion start -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Schema</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->schema ? 'checked' : '' }} id="switchSchema" name="switchSchema" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="schemaChoice" id="isSchemaTest" value="1" {{ $settings->settingsSub->schema_test ? "checked" : "" }} />
                                        <label class="form-check-label" for="isSchemaTest">
                                            All the webpages of the project should be tested for Schema.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="schemaChoice" id="isSchemaTestCustom" value="1" {{ $settings->settingsSub->schema_test_custom ? "checked" : "" }} />
                                        <label class="form-check-label" for="isSchemaTestCustom">
                                            Only specific pages of the project should be tested for Schema
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="schemaVal">Add the urls of your project where schema should be tested</label>
                                        <?php
                                            $cleanedSchema = preg_replace('/\s+/', '', $settings->settingsSub->schema_val ?? '');
                                            $schemaLines = explode(",", $cleanedSchema);
                                            $schemaFormatted = implode("\n", $schemaLines);
                                        ?>
                                        <div class="project-urls-numbered schema-urls-numbered">
                                            <div class="project-urls-numbered__numbers" id="schemaNumbers"></div>
                                            <textarea class="form-control project-urls-numbered__textarea" id="schemaVal" rows="12" placeholder="Enter each url in a new line">{{ htmlspecialchars($schemaFormatted) }}</textarea>
                                        </div>
                                        <div style="margin-top:8px;">
                                            <small class="text-muted">Edit URLs inline and click "Save Settings" to persist.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsSchema" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Schema accordion end -->

                    <!-- single accordion item -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Images</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->images ? "checked" : "" }} id="switchImages" name="switchImages" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="maximumFileSize" {{ $settings->settingsSub->image_max_size ? "checked" : "" }} />
                                            <label class="form-check-label" for="maximumFileSize">
                                                Maximum file size of an image file should be
                                                <input class="slider-input-text" type="number" id="maximumFileSizeVal" value="{{ $settings->settingsSub->image_max_size_val}}" min="0" max="1700"> KB
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range7">
                                            <span class="span-left">0</span>
                                            <input id="ex34" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="2000" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->image_max_size_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">2000</span>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="imageNameHyphen" {{ $settings->settingsSub->image_name_only_hyphens ? "checked" : "" }} />
                                        <label class="form-check-label" for="imageNameHyphen">
                                            Words in image file must be separated by hyphens only
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="imageNameUppercase" {{ $settings->settingsSub->image_name_no_uppercase ? "checked" : "" }} />
                                        <label class="form-check-label" for="imageNameUppercase">
                                            Image file name can not have uppercase characters
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="imageNameSpecial" {{ $settings->settingsSub->image_name_no_special ? "checked" : "" }} />
                                        <label class="form-check-label" for="imageNameSpecial">
                                            Image file name can not have special characters
                                        </label>
                                    </div>
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="imageNameLength" {{ $settings->settingsSub->image_name_max_characters ? "checked" : "" }} />
                                            <label class="form-check-label" for="imageNameLength">
                                                Maximum length of an image file name should be
                                                <input class="slider-input-text" type="number" id="imageNameLengthVal" value="{{ $settings->settingsSub->image_name_max_characters_val}}" min="0" max="200"> Characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range7">
                                            <span class="span-left">0</span>
                                            <input id="ex35" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="200" data-slider-step="1" data-slider-value="170" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">200</span>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="imageAlt" {{ $settings->settingsSub->image_alt ? "checked" : "" }} />
                                        <label class="form-check-label" for="imageAlt">
                                            An image must have an alt text
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="imageAltSpaces" {{ $settings->settingsSub->image_alt_only_spaces ? "checked" : "" }} />
                                        <label class="form-check-label" for="imageAltSpaces">
                                            Words in alt text must be separated by spaces only
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsImages" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>URL Slug</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->url_slug ? 'checked' : '' }} id="switchUrlSlug" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->url_slug_lowercase ? "checked" : "" }} id="UrlLowercase" />
                                        <label class="form-check-label" for="urlslug1">
                                            Every character in the URL needs to be lowercase
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->url_no_numbers ? "checked" : "" }} id="UrlNoNumbers" />
                                        <label class="form-check-label" for="urlslug2">
                                            URLs cannot contain numbers
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->url_no_special ? "checked" : "" }} id="UrlNoSpecial" />
                                        <label class="form-check-label" for="urlslug3">
                                            URLs cannot contain special characters
                                        </label>
                                    </div>
                                    <div class="check-range">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->max_url_length ? "checked" : "" }} id="maxUrlLength" />
                                            <label class="form-check-label" for="urlslug4">
                                                Maximum length of a URL should be
                                                <input type="number" class="slider-input-text" value="{{ $settings->settingsSub->max_url_length_val}}" id="maxUrlLengthVal" min="0" max="100" id="ex25-input"> Characters (excluding the domain name)
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range5">
                                            <span class="span-left">0</span>
                                            <input id="ex25" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->max_url_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">100</span>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input hideInputCheck" type="checkbox" {{ $settings->settingsSub->url_stop_words ? "checked" : "" }} id="UrlStopWords" />
                                        <label class="form-check-label" for="urlslug5">
                                            URLs must not contain specific stop words (separate each word with a comma)
                                        </label>
                                    </div>
                                    <textarea class="hideInputCheckElement" placeholder="Separate each word with a comma" id="UrlStopWordsVal" cols="30" rows="10">{{$settings->settingsSub->url_stop_words_val}}</textarea>
                                    <div class="form-check form-check-black">
                                        <input class="form-check-input toggleCasingChecks" type="checkbox" id="enableURLChecks" {{ $settings->settingsSub->url_casing_only_hyphens || $settings->settingsSub->url_casing_only_underscores || $settings->settingsSub->url_casing_both? "checked" : "" }} />
                                        <label class="form-check-label" for="enableURLChecks">
                                            Enable URL Checks
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="urlCasingCheck" {{ $settings->settingsSub->url_casing_only_hyphens ? "checked" : "" }} id="UrlOnlyHyphens" />
                                        <label class="form-check-label" for="UrlOnlyHyphens">
                                            Words in URLs should be separated by hyphens only
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="urlCasingCheck" {{ $settings->settingsSub->url_casing_only_underscores ? "checked" : "" }} id="UrlOnlyUnderscores" />
                                        <label class="form-check-label" for="UrlOnlyUnderscores">
                                            Words in URLs should be separated by underscores only
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="urlCasingCheck" {{ $settings->settingsSub->url_casing_both ? "checked" : "" }} id="UrlBoth" />
                                        <label class="form-check-label" for="UrlBoth">
                                            Words in URLs can be separated by either hyphens or underscores
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Robots.txt</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->robot_text_test ? 'checked' : '' }} id="switchRobotTxtTestHeader" name="switchRobotTxtTestHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="isRobotTextTestBlockUrlEnable" {{ $settings->settingsSub->robot_text_test_block_url ? "checked" : "" }} />
                                        <label class="form-check-label" for="isRobotTextTestBlockUrlEnable">
                                            No page on the website should be blocked in Robots.txt
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultRobotTextEnable" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Headings</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->h1_heading_tag ? 'checked' : '' }} id="switchH1HeadingTag" name="switchH1HeadingTag" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="isH1HeadingTagEnable" {{ $settings->settingsSub->h1_heading_tag ? "checked" : "" }} />
                                        <label class="form-check-label" for="isH1HeadingTagEnable">
                                            Every page must have at least one H1 heading tag
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="h1HeadingTagLength" {{ $settings->settingsSub->h1_heading_tag_length ? "checked" : "" }} />
                                        <label class="form-check-label" for="h1HeadingTagLength">
                                            A page can have at most
                                            <input class="slider-input-text" type="number" id="h1HeadingTagLengthVal" value="{{$settings->settingsSub->h1_heading_tag_length_val}}" min="0" max="100"> H1 heading tag
                                        </label>
                                    </div>
                            

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="h2HeadingTagLength" {{ $settings->settingsSub->h2_heading_tag_length ? "checked" : "" }} />
                                        <label class="form-check-label" for="h2HeadingTagLength">
                                            A page can have at most
                                            <input class="slider-input-text" type="number" id="h2HeadingTagLengthVal" value="{{$settings->settingsSub->h2_heading_tag_length_val}}" min="0" max="100"> H2 heading tag
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="h3HeadingTagLength" {{ $settings->settingsSub->h3_heading_tag_length ? "checked" : "" }} />
                                        <label class="form-check-label" for="h3HeadingTagLength">
                                            A page can have at most
                                            <input class="slider-input-text" type="number" id="h3HeadingTagLengthVal" value="{{$settings->settingsSub->h3_heading_tag_length_val}}" min="0" max="100"> H3 heading tag
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="h4HeadingTagLength" {{ $settings->settingsSub->h4_heading_tag_length ? "checked" : "" }} />
                                        <label class="form-check-label" for="h4HeadingTagLength">
                                            A page can have at most
                                            <input class="slider-input-text" type="number" id="h4HeadingTagLengthVal" value="{{$settings->settingsSub->h4_heading_tag_length_val}}" min="0" max="100"> H4 heading tag
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="h5HeadingTagLength" {{ $settings->settingsSub->h5_heading_tag_length ? "checked" : "" }} />
                                        <label class="form-check-label" for="h5HeadingTagLength">
                                            A page can have at most
                                            <input class="slider-input-text" type="number" id="h5HeadingTagLengthVal" value="{{$settings->settingsSub->h5_heading_tag_length_val}}" min="0" max="100"> H5 heading tag
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="h6HeadingTagLength" {{ $settings->settingsSub->h6_heading_tag_length ? "checked" : "" }} />
                                        <label class="form-check-label" for="h6HeadingTagLength">
                                            A page can have at most
                                            <input class="slider-input-text" type="number" id="h6HeadingTagLengthVal" value="{{$settings->settingsSub->h6_heading_tag_length_val}}" min="0" max="100"> H6 heading tag
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultH1HeadingTagEnable"/>
                                </div>
                            </div>
                        </div>



                    </div>


                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>XML sitemap</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->xml_sitemap ? 'checked' : '' }} id="switchXML" name="switchXML" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->xml_sitemap ? "checked" : "" }} id="isXmlSitemap" />
                                        <label class="form-check-label" for="isXmlSitemap">
                                            Every page must be added to XML sitemap
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input hideInputCheck" type="checkbox" id="isXmlSitemapCustom" {{ $settings->settingsSub->xml_sitemap_custom ? "checked" : "" }} />
                                        <label class="form-check-label" for="isXmlSitemapCustom">
                                            Add XML sitemap manually
                                        </label>
                                    </div>

                                    <div class="form-check form-check-link">
                                        <label class="form-check-label" for="pagefavicon2">
                                            Address of the XML Sitemap File
                                        </label>

                                        <?php
                      $moreThanOne = false;
                      $cleaned = preg_replace('/\s+/', '', $settings->settingsSub->xml_sitemap_val);
                      $lines = explode(",", $cleaned);
                      $formatted = implode("\n", $lines);
                      if(count($lines) > 1){
                        $moreThanOne = true;
                      }
                    
                    ?>

                                            @if($moreThanOne)
                                            <textarea disabled class="add-more-sitemap-textarea" placeholder="Enter each url in a new line" id="addSitemapVal" cols="30" rows="10">{{ htmlspecialchars($formatted) }}</textarea>
                                            @else
                                            <input class="form-control hideInputCheckElement" type="text" id="xmlSitemapVal" value="{{ $settings->settingsSub->xml_sitemap_val}}"> @endif

                                            <div class="add-more-sitemap">
                                                <p>+ Add more</p>
                                            </div>
                                    </div>

                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsXML" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>HTML sitemap</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->html_sitemap ? 'checked' : '' }} id="switchHTML" name="switchHTML" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="isHtmlSitemap" {{ $settings->settingsSub->html_sitemap ? "checked" : "" }} />
                                        <label class="form-check-label" for="isHtmlSitemap">
                                            Every page must be added to HTML sitemap
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input hideInputCheck" type="checkbox" id="isHtmlSitemapCustom" {{ $settings->settingsSub->html_sitemap_custom ? "checked" : "" }} />
                                        <label class="form-check-label" for="isHtmlSitemapCustom">
                                            Add HTML sitemap manually
                                        </label>
                                    </div>
                                    <div class="form-check form-check-link">
                                        <label class="form-check-label" for="pagefavicon2">
                                            Address of the HTML Sitemap File
                                        </label>
                                        <input class="hideInputCheckElement" type="text" id="htmlSitemapVal" value="{{ $settings->settingsSub->html_sitemap_val}}">
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsHTML" />
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Open graph Tags</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->open_graph_tags ? 'checked' : '' }} id="switchOgTitle" name="switchOgTitle" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content m-bottom">
                                <div class="accor-content">
                                    <div class="meta-title">
                                        <h3>Open Graph Title</h3>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->og_title ? "checked" : "" }} id="isOgTitle" />
                                        <label class="form-check-label" for="graphtitle1">
                                            Every page must have an Open Graph Title tag
                                        </label>
                                    </div>
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->max_og_title_length ? "checked" : "" }} id="ogTitleMax" />
                                            <label class="form-check-label" for="ogTitleMax">
                                                Maximum length of Open graph title tag should be
                                                <input type="number" class="slider-input-text" id="ogTitleMaxVal" value="{{ $settings->settingsSub->max_og_title_length_val}}" min="0" max="100" id="ex26-input"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range">
                                            <span class="span-left">0</span>
                                            <input id="ex26" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->max_og_title_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">100</span>
                                        </div>
                                    </div>
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->min_og_title_length ? "checked" : "" }} id="ogTitleMin" />
                                            <label class="form-check-label" for="ogTitleMin">
                                                Minimum length of Open graph title tag should be
                                                <input type="number" class="slider-input-text" id="ogTitleMinVal" value="{{ $settings->settingsSub->min_og_title_length_val}}" min="0" max="30" id="ex27-input"> Characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range2">
                                            <span class="span-left">0</span>
                                            <input id="ex27" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="30" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->min_og_title_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">30</span>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->is_og_title_equal_title ? "checked" : "" }} id="ogTitleEqualTitle" />
                                        <label class="form-check-label" for="ogTitleEqualTitle">
                                            Content of Open graph title tag must be equal to the Content of Title Tag
                                        </label>
                                    </div>
                                    <div class="form-check form-check-black">
                                        <input class="form-check-input toggleCasingChecks" type="checkbox" id="enableTitleCasingChecks" {{ $settings->settingsSub->og_title_casing_camel || $settings->settingsSub->og_title_casing_sentence || $settings->settingsSub->og_title_casing_both ? "checked" : "" }} />
                                        <label class="form-check-label" for="graphtitle5">
                                            Enable Casing Checks
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="radioOgTitleCasing" {{ $settings->settingsSub->og_title_casing_camel ? "checked" : "" }} id="ogTitleCasingCamel" />
                                        <label class="form-check-label" for="ogTitleCasingCamel">
                                            Open graph title tag must be in camel casing.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="radioOgTitleCasing" {{ $settings->settingsSub->og_title_casing_sentence ? "checked" : "" }} id="ogTitleCasingSentence" />
                                        <label class="form-check-label" for="ogTitleCasingSentence">
                                            Open graph title tag must be in sentence casing.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="radioOgTitleCasing" {{ $settings->settingsSub->og_title_casing_both ? "checked" : "" }} id="ogTitleCasingBoth" />
                                        <label class="form-check-label" for="ogTitleCasingBoth">
                                            Open graph title tag can be either in camel casing or in sentence casing
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsOGTitle" />
                                </div>
                            </div>

                            <!-- Desc -->
                            <div class="meta-content m-bottom">
                                <div class="accor-content">
                                    <div class="meta-title">
                                        <h3>Open Graph Description</h3>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->og_desc ? "checked" : "" }} id="isOgDesc" />
                                        <label class="form-check-label" for="isOgDesc">
                                            Every page must have an Open Graph description tag
                                        </label>
                                    </div>
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->max_og_desc_length ? "checked" : "" }} id="OgDescMax" />
                                            <label class="form-check-label" for="graphdes2">
                                                Maximum length of OG Description should be
                                                <input type="number" class="slider-input-text" value="{{ $settings->settingsSub->max_og_desc_length_val}}" id="OgDescMaxVal" min="0" max="220" id="ex28-input"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range3">
                                            <span class="span-left">0</span>
                                            <input id="ex28" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="220" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->max_og_desc_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">220</span>
                                        </div>
                                    </div>
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->min_og_desc_length ? "checked" : "" }} id="OgDescMin" />
                                            <label class="form-check-label" for="OgDescMin">
                                                Minimum length of OG Description should be
                                                <input type="number" class="slider-input-text" value="{{ $settings->settingsSub->min_og_desc_length_val}}" id="OgDescMinVal" min="0" max="70" id="ex29-input"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range4">
                                            <span class="span-left">0</span>
                                            <input id="ex29" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="70" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->min_og_desc_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">70</span>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->is_og_desc_equal_desc ? "checked" : "" }} id="ogDescEqualDesc" />
                                        <label class="form-check-label" for="ogDescEqualDesc">
                                            OG Description must be the same as Meta description
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsOGDesc" />
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="meta-content m-bottom">
                                <div class="accor-content">
                                    <div class="meta-title">
                                        <h3>Open Graph Image</h3>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->og_image ? "checked" : "" }} id="isOgImage" />
                                        <label class="form-check-label" for="graphimg1">
                                            Every page must have an Open Graph image
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->og_image_dimensions_min ? "checked" : "" }} id="ogImageDimensionsLeast" />
                                        <label class="form-check-label" for="ogImageDimensionsLeast">
                                            Width of OG Image should be at least
                                            <input type="text" id="ogImageDimensionsLeastWidth" value="{{ $settings->settingsSub->og_image_width_min}}"> pixels and height of OG Image should be at least
                                            <input type="text" id="ogImageDimensionsLeastHeight" value="{{ $settings->settingsSub->og_image_height_min}}"> pixels
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->og_image_dimensions_exact ? "checked" : "" }} id="ogImageDimensionsExact" />
                                        <label class="form-check-label" for="graphimg3">
                                            Width of OG Image should be exactly
                                            <input class="input_2" type="text" id="ogImageDimensionsExactWidth" value="{{ $settings->settingsSub->og_image_width_exact}}"> pixels and height of OG Image should be exactly
                                            <input type="text" id="ogImageDimensionsExactHeight" value="{{ $settings->settingsSub->og_image_height_exact}}"> pixels
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsOGImage" />
                                </div>
                            </div>

                            <!-- URL -->
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="meta-title">
                                        <h3>Open Graph URL</h3>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->og_url ? "checked" : "" }} id="isOgUrl" />
                                        <label class="form-check-label" for="isOgUrl">
                                            Every page must have an Open Graph URL
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->is_og_url_equal_url ? "checked" : "" }} id="ogUrlEqualUrl" />
                                        <label class="form-check-label" for="ogUrlEqualUrl">
                                            Open Graph URL must be equal to the actual URL
                                        </label>
                                    </div>
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->max_og_url_length ? "checked" : "" }} id="ogUrlMax" />
                                            <label class="form-check-label" for="ogUrlMax">
                                                Maximum length of OG URL should be
                                                <input type="number" class="slider-input-text" id="ogUrlMaxVal" value="{{ $settings->settingsSub->max_og_url_length_val}}" min="0" max="100"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range4">
                                            <span class="span-left">0</span>
                                            <input id="ex30" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->max_og_url_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">100</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion -->




                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Twitter Tags</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->twitter_tags ? 'checked' : '' }} id="switchTwitterTitle" name="switchTwitterTitle" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="meta-title">
                                        <h3>Twitter title tag</h3>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->twitter_title ? "checked" : "" }} id="isTwitterTitle" />
                                        <label class="form-check-label" for="isTwitterTitle">
                                            Every page must have a Twitter title tag
                                        </label>
                                    </div>
                                    <div class="check-range">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->max_twitter_title_length ? "checked" : "" }} id="twitterTitleLengthMax" />
                                            <label class="form-check-label" for="twitterTitleLengthMax">
                                                Maximum length of Twitter title should be
                                                <input type="number" class="slider-input-text" value="{{ $settings->settingsSub->max_twitter_title_length_val}}" id="twitterTitleLengthMaxVal" min="0" max="100"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range">
                                            <span class="span-left">0</span>
                                            <input id="ex31" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->max_twitter_title_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">100</span>
                                        </div>
                                    </div>
                                    <div class="check-range">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->min_twitter_title_length ? "checked" : "" }} id="twitterTitleLengthMin" />
                                            <label class="form-check-label" for="twitertitle3">
                                                Minimum length of Twitter title should be
                                                <input type="number" class="slider-input-text" value="{{ $settings->settingsSub->min_twitter_title_length_val}}" id="twitterTitleLengthMinVal" min="0" max="30"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range2">
                                            <span class="span-left">0</span>
                                            <input id="ex32" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="30" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->min_twitter_title_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">30</span>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->is_twitter_title_equal_title ? "checked" : "" }} id="twitterTitleEqualTitle" />
                                        <label class="form-check-label" for="twitterTitleEqualTitle">
                                            Twitter title must be equal to Title Tag
                                        </label>
                                    </div>
                                    <div class="form-check form-check-black">
                                        <input class="form-check-input toggleCasingChecks" type="checkbox" id="enableTwitterTitleCasingChecks" checked />
                                        <label class="form-check-label" for="enableTwitterTitleCasingChecks">
                                            Enable Casing Checks
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="twitterTitleCasing" {{ $settings->settingsSub->twitter_title_casing_camel ? "checked" : "" }} id="twitterTitleCasingCamel" />
                                        <label class="form-check-label" for="twitterTitleCasingCamel">
                                            Twitter title must be in camel casing
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="twitterTitleCasing" {{ $settings->settingsSub->twitter_title_casing_sentence ? "checked" : "" }} id="twitterTitleCasingSentence" />
                                        <label class="form-check-label" for="twitterTitleCasingSentence">
                                            Twitter title must be in sentence casing
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input casing-check-input" type="radio" name="twitterTitleCasing" {{ $settings->settingsSub->twitter_title_casing_both ? "checked" : "" }} id="twitterTitleCasingBoth" />
                                        <label class="form-check-label" for="twitertitle8">
                                            Twitter title can be either in camel casing or sentence casing
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsTwitterTitle" />
                                </div>
                            </div>

                            <!-- Twitter Image -->
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="meta-title">
                                        <h3>Twitter image tag</h3>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->twitter_image ? "checked" : "" }} id="isTwitterImage" />
                                        <label class="form-check-label" for="isTwitterImage">
                                            Every page must have a Twitter image tag
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->twitter_image_dimensions_min ? "checked" : "" }} id="twitterImageDimensionsMin" />
                                        <label class="form-check-label" for="twitterImageDimensionsMin">
                                            Width of Twitter image tag should be at least
                                            <input type="text" id="twitterImageWidthMin" value="{{ $settings->settingsSub->twitter_image_width_min}}"> pixels and height of Twitter image tag should be at least
                                            <input type="text" id="twitterImageHeightMin" value="{{ $settings->settingsSub->twitter_image_height_min}}"> pixels
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->twitter_image_dimensions_exact ? "checked" : "" }} id="twitterImageDimensionsExact" />
                                        <label class="form-check-label" for="twitterImageDimensionsExact">
                                            Width of Twitter image tag should be exactly
                                            <input class="input_2" type="text" value="{{ $settings->settingsSub->twitter_image_width_exact}}" id="twitterImageWidthExact"> pixels and height of Twitter image tag should be exactly
                                            <input type="text" value="{{ $settings->settingsSub->twitter_image_width_exact}}" id="twitterImageHeightExact"> pixels
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsTwitterImage" />
                                </div>
                            </div>

                            <!-- Twitter Image Alt -->
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="meta-title">
                                        <h3>Twitter Image Alt</h3>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->twitter_image_alt ? "checked" : "" }} id="isTwitterImageAlt" />
                                        <label class="form-check-label" for="isTwitterImageAlt">
                                            Every page must have a Twitter image alt Tag
                                        </label>
                                    </div>
                                    <div class="check-range check-range2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $settings->settingsSub->max_twitter_image_alt_length}}" id="twitterImageAltMax" />
                                            <label class="form-check-label" for="twitterImageAltMax">
                                                Maximum length of Twitter image alt should
                                                <input type="number" class="slider-input-text" value="{{ $settings->settingsSub->max_twitter_image_alt_length_val}}" id="twitterImageAltMaxVal" min="0" max="500"> characters
                                            </label>
                                        </div>
                                        <div class="slider-range slider-range6">
                                            <span class="span-left">0</span>
                                            <input id="ex33" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="500" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->max_twitter_image_alt_length_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">500</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion -->



                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Favicon</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->favicon ? 'checked' : '' }} id="switchFavicon" name="switchFavicon" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->favicon ? "checked" : "" }} id="isFavicon" />
                                        <label class="form-check-label" for="pagefavicon1">
                                            Every page must have a Favicon
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->favicon_dimensions_min ? "checked" : "" }} id="faviconDimensionsMin" />
                                        <label class="form-check-label" for="faviconDimensionsMin">
                                            Width of Favicon should be at least
                                            <input type="text" value="{{ $settings->settingsSub->favicon_width_min}}" id="faviconWidthMin"> pixels and height of favicon should be at least
                                            <input type="text" value="{{ $settings->settingsSub->favicon_height_min}}" id="faviconHeightMin"> pixels
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" {{ $settings->settingsSub->favicon_dimensions_exact ? "checked" : "" }} id="faviconDimensionsExact" />
                                        <label class="form-check-label" for="faviconDimensionsExact">
                                            Width of Favicon should be exactly
                                            <input type="text" value="{{ $settings->settingsSub->favicon_width_exact}}" id="faviconWidthExact"> pixels and height of favicon should be exactly
                                            <input type="text" value="{{ $settings->settingsSub->favicon_height_exact}}" id="faviconHeightExact"> pixels
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsFavicon" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Meta Viewport</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->meta_viewport ? 'checked' : '' }} id="switchViewport" name="switchViewport" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <p><b>No Customisations are available for this test.</b></p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isMetaViewport" {{ $settings->settingsSub->meta_viewport ? "checked" : "" }} />
                                        <label class="form-check-label" for="isMetaViewport">
                                            Every page must have a Meta viewport tag
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsViewport" />
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Doctype</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->doctype ? 'checked' : '' }} id="switchDoctype" name="switchDoctype" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p><b>No Customisations are available for this test.</b></p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isDoctype" {{ $settings->settingsSub->doctype ? "checked" : "" }} />
                                        <label class="form-check-label" for="isDoctype">
                                            Every page must have HTML Doctype declaration
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsDoctype" />
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>HTTP Status Code</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->http_status_code ? 'checked' : '' }} id="switchHttpStatusCode" name="switchHttpStatusCode" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">


                                    @include("components.http-status-code-settings")



                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsDoctype" />
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
            <!-- meta tag tab content end -->



            <!-- performance tab content start -->
            <div class="tab-pane fade" id="v-pills-performance" role="tabpanel" aria-labelledby="v-pills-performance-tab" tabindex="0">
                <!-- performance notice start -->
                <div class="performance-notice">
                    <p>
                        We use Google Page speed insights API to collect scores for Lighthouse and core web vitals. The PageSpeed Insights API returns real-world data from the Chrome User Experience Report and lab data from Lighthouse.
                        <a href="#">Learn more</a>
                    </p>
                </div>
                <!-- performance notice end -->

                <div class="tab-content-area performance-content-area">
                    <!-- single accordion item -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Overall Score</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->google_overall ? "checked" : "" }} id="switchGoogleOverall" name="switchGoogleOverall" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content performance-content">
                                <div class="performance-left">
                                    <div class="accor-content">
                                        <div class="performance-title">
                                            <h4>Desktop</h4>
                                            <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.84603 0.81879C1.49767 1.04256 0.430452 2.01224 0.0919265 3.32044C0.0115984 3.63028 0.000122927 4.45651 0.000122927 10.2631C0.000122927 17.5156 -0.0170902 17.1426 0.355862 17.9115C0.631272 18.4795 1.28537 19.1106 1.89931 19.3975C2.16324 19.5238 2.5362 19.65 2.7198 19.6844C2.94357 19.7246 4.34932 19.7475 6.75342 19.7475H10.4428L9.98376 20.6656L9.52474 21.5836H8.15916C6.8567 21.5836 6.78785 21.5893 6.57555 21.7156C5.95014 22.0656 5.96735 22.9836 6.60424 23.3049C6.81654 23.4197 6.97146 23.4197 13.1395 23.4197C19.3076 23.4197 19.4625 23.4197 19.6748 23.3049C20.3231 22.9779 20.3231 22.0254 19.6748 21.6984C19.474 21.5951 19.3362 21.5836 18.1026 21.5836H16.7543L16.2953 20.6656L15.8362 19.7475H19.5485C23.6395 19.7475 23.6969 19.7418 24.4199 19.3975C24.9592 19.1393 25.6707 18.4336 25.9232 17.9115C26.2961 17.1426 26.2789 17.5098 26.2789 10.2803C26.2789 2.98765 26.2961 3.34339 25.8945 2.5688C25.6133 2.03519 24.9994 1.40978 24.4945 1.16305C23.6625 0.755676 24.6092 0.790102 13.3116 0.778627C7.71162 0.77289 3.00095 0.790102 2.84603 0.81879ZM23.3354 2.67781C23.7256 2.79257 24.0584 3.05076 24.2535 3.37782L24.4141 3.65322L24.4313 10.1828L24.4428 16.7123L24.3223 16.9992C24.2477 17.1656 24.0928 17.3779 23.9436 17.5098C23.4502 17.9459 24.3166 17.9115 13.1395 17.9115C2.00833 17.9115 2.8403 17.9402 2.35259 17.527C2.21488 17.4065 2.04849 17.1828 1.9739 17.0279L1.83619 16.7352V10.2459V3.75077L1.99685 3.45241C2.1862 3.08519 2.47308 2.83847 2.88046 2.70076C3.17308 2.60322 3.64358 2.59748 13.1166 2.59175C21.7518 2.59175 23.083 2.60322 23.3354 2.67781Z"
                                                fill="#222222" />
                                            </svg>
                                        </div>
                                        <div class="overall-item">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleInsightsDesktop" {{ $settings->settingsSub->google_insights_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="checkbox">
                                                        Overall Score
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0–100 rating that reflects the page’s loading speed for users on desktop; higher scores denote better performance.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="slider-range score-range1">
                                                <span class="span-left">0</span>
                                                <input id="score1" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_insights_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                        { "start": 7, "end": 8, "class": "category2" },
                                                        { "start": 17, "end": 19 },
                                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                        { "start": -3, "end": 19 }]' />
                                                <span class="span-right">100</span>
                                            </div>
                                            <div class="range-value">
                                                <p>Greater than</p>
                                                <input class="slider-input-text" type="number" id="googleInsightsDesktopVal" value="{{ $settings->settingsSub->google_insights_desktop_val}}" min="0" max="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Mobile area -->
                                <div class="performance-right">
                                    <div class="accor-content">
                                        <div class="performance-title">
                                            <h4>Mobile</h4>
                                            <svg width="17" height="29" viewBox="0 0 17 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.02332 0.0441456C1.31131 0.215246 0.748334 0.822384 0.604829 1.57854C0.527557 1.98698 0.527557 26.2393 0.604829 26.6478C0.726256 27.2714 1.12917 27.8013 1.69767 28.0662L2.01228 28.2153H8.77357H15.5349L15.8495 28.0662C16.418 27.8013 16.8209 27.2714 16.9423 26.6478C17.0196 26.2393 17.0196 1.98698 16.9423 1.57854C16.8209 0.954849 16.418 0.424984 15.8495 0.160053L15.5349 0.0110283L8.88396 -1.14441e-05C5.1142 -1.14441e-05 2.14475 0.0165482 2.02332 0.0441456ZM10.9813 1.47367C11.0255 1.55095 11.0255 1.61718 10.9813 1.69445C10.9261 1.79932 10.8654 1.80484 8.77357 1.80484C6.68171 1.80484 6.621 1.79932 6.5658 1.69445C6.52165 1.61718 6.52165 1.55095 6.5658 1.47367C6.621 1.3688 6.68171 1.36329 8.77357 1.36329C10.8654 1.36329 10.9261 1.3688 10.9813 1.47367ZM15.6729 13.8648V24.7104H8.77357H1.8743V13.8648V3.01911H8.77357H15.6729V13.8648ZM9.08818 25.4335C9.27584 25.5052 9.52973 25.7371 9.6346 25.9358C9.81122 26.2724 9.69532 26.7857 9.38623 27.0452C8.75702 27.575 7.83527 27.139 7.83527 26.3111C7.83527 25.6819 8.50864 25.2127 9.08818 25.4335Z"
                                                fill="black" />
                                            </svg>
                                        </div>
                                        <div class="overall-item">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleInsightsMobile" {{ $settings->settingsSub->google_insights_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="overalscore2">
                                                        Overall Score
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0–100 rating that reflects the page’s loading speed for users on mobile networks and devices; higher scores denote better performance.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="slider-range score-range1">
                                                <span class="span-left">0</span>
                                                <input id="score2" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_insights_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                        { "start": 7, "end": 8, "class": "category2" },
                                                        { "start": 17, "end": 19 },
                                                        { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                        { "start": -3, "end": 19 }]' />
                                                <span class="span-right">100</span>
                                            </div>
                                            <div class="range-value">
                                                <p>Greater than</p>
                                                <input class="slider-input-text" type="number" id="googleInsightsMobileVal" value="{{ $settings->settingsSub->google_insights_mobile_val}}" min="0" max="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- performance button -->
                            <div class="accor-content-button performance-button">
                                <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsGoogleInsights" />
                            </div>
                        </div>
                    </div>
                    <!-- single accordion item -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Lighthouse Score</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->google_lighthouse ? "checked" : "" }} id="switchGoogleLighthouse" name="switchGoogleLighthouse" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content performance-content">
                                <div class="performance-left">
                                    <div class="accor-content">
                                        <div class="performance-title">
                                            <h4>Desktop</h4>
                                            <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.84603 0.81879C1.49767 1.04256 0.430452 2.01224 0.0919265 3.32044C0.0115984 3.63028 0.000122927 4.45651 0.000122927 10.2631C0.000122927 17.5156 -0.0170902 17.1426 0.355862 17.9115C0.631272 18.4795 1.28537 19.1106 1.89931 19.3975C2.16324 19.5238 2.5362 19.65 2.7198 19.6844C2.94357 19.7246 4.34932 19.7475 6.75342 19.7475H10.4428L9.98376 20.6656L9.52474 21.5836H8.15916C6.8567 21.5836 6.78785 21.5893 6.57555 21.7156C5.95014 22.0656 5.96735 22.9836 6.60424 23.3049C6.81654 23.4197 6.97146 23.4197 13.1395 23.4197C19.3076 23.4197 19.4625 23.4197 19.6748 23.3049C20.3231 22.9779 20.3231 22.0254 19.6748 21.6984C19.474 21.5951 19.3362 21.5836 18.1026 21.5836H16.7543L16.2953 20.6656L15.8362 19.7475H19.5485C23.6395 19.7475 23.6969 19.7418 24.4199 19.3975C24.9592 19.1393 25.6707 18.4336 25.9232 17.9115C26.2961 17.1426 26.2789 17.5098 26.2789 10.2803C26.2789 2.98765 26.2961 3.34339 25.8945 2.5688C25.6133 2.03519 24.9994 1.40978 24.4945 1.16305C23.6625 0.755676 24.6092 0.790102 13.3116 0.778627C7.71162 0.77289 3.00095 0.790102 2.84603 0.81879ZM23.3354 2.67781C23.7256 2.79257 24.0584 3.05076 24.2535 3.37782L24.4141 3.65322L24.4313 10.1828L24.4428 16.7123L24.3223 16.9992C24.2477 17.1656 24.0928 17.3779 23.9436 17.5098C23.4502 17.9459 24.3166 17.9115 13.1395 17.9115C2.00833 17.9115 2.8403 17.9402 2.35259 17.527C2.21488 17.4065 2.04849 17.1828 1.9739 17.0279L1.83619 16.7352V10.2459V3.75077L1.99685 3.45241C2.1862 3.08519 2.47308 2.83847 2.88046 2.70076C3.17308 2.60322 3.64358 2.59748 13.1166 2.59175C21.7518 2.59175 23.083 2.60322 23.3354 2.67781Z"
                                                fill="#222222" />
                                            </svg>
                                        </div>
                                        <!-- single item 1 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googlePerformanceDesktop" {{ $settings->settingsSub->google_performance_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googlePerformanceDesktop">
                                                        Performance Score
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0–100 rating that reflects page speed and responsiveness for desktop users; higher scores denote better performance.

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

                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range1">
                                                    <span class="span-left">0</span>
                                                    <input id="score3" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_performance_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">100</span>
                                                </div>
                                                <div class="range-value">
                                                    <p>Greater than</p>
                                                    <input class="slider-input-text" type="number" id="googlePerformanceDesktopVal" value="{{ $settings->settingsSub->google_performance_desktop_val}}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 2 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleAccessibilityDesktop" {{ $settings->settingsSub->google_accessibility_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleAccessibilityDesktop">
                                                        Accessibility
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0–100 rating that reflects how usable the page is for people with disabilities on desktop; higher scores denote better accessibility.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range1">
                                                    <span class="span-left">90</span>
                                                    <input id="score4" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_accessibility_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">120</span>
                                                </div>
                                                <div class="range-value">
                                                    <p>Greater than</p>
                                                    <input class="slider-input-text" type="number" id="googleAccessibilityDesktopVal" value="{{ $settings->settingsSub->google_accessibility_desktop_val}}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 3 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleBestPracticesDesktop" {{ $settings->settingsSub->google_best_practices_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleBestPracticesDesktop">
                                                        Best Practices
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0–100 rating that reflects adherence to modern web development and security practices on desktop; higher scores denote better compliance.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range1">
                                                    <span class="span-left">90</span>
                                                    <input id="score5" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_best_practices_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">120</span>
                                                </div>
                                                <div class="range-value">
                                                    <p>Greater than</p>
                                                    <input class="slider-input-text" type="number" id="googleBestPracticesDesktopVal" value="{{ $settings->settingsSub->google_best_practices_desktop_val}}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 4 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleSeoDesktop" {{ $settings->settingsSub->google_seo_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleSeoDesktop">
                                                        SEO
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0-100 rating that denotes how optimised your webpage is for search engine bots. A higher scores denotes stronger optimisation.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range1">
                                                    <span class="span-left">90</span>
                                                    <input id="score6" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_seo_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">120</span>
                                                </div>
                                                <div class="range-value">
                                                    <p>Greater than</p>
                                                    <input class="slider-input-text" type="number" id="googleSeoDesktopVal" value="{{ $settings->settingsSub->google_seo_desktop_val}}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item -->
                                    </div>
                                </div>

                                <!-- mobile area -->
                                <div class="performance-right">
                                    <div class="accor-content">
                                        <div class="performance-title">
                                            <h4>Mobile</h4>
                                            <svg width="17" height="29" viewBox="0 0 17 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.02332 0.0441456C1.31131 0.215246 0.748334 0.822384 0.604829 1.57854C0.527557 1.98698 0.527557 26.2393 0.604829 26.6478C0.726256 27.2714 1.12917 27.8013 1.69767 28.0662L2.01228 28.2153H8.77357H15.5349L15.8495 28.0662C16.418 27.8013 16.8209 27.2714 16.9423 26.6478C17.0196 26.2393 17.0196 1.98698 16.9423 1.57854C16.8209 0.954849 16.418 0.424984 15.8495 0.160053L15.5349 0.0110283L8.88396 -1.14441e-05C5.1142 -1.14441e-05 2.14475 0.0165482 2.02332 0.0441456ZM10.9813 1.47367C11.0255 1.55095 11.0255 1.61718 10.9813 1.69445C10.9261 1.79932 10.8654 1.80484 8.77357 1.80484C6.68171 1.80484 6.621 1.79932 6.5658 1.69445C6.52165 1.61718 6.52165 1.55095 6.5658 1.47367C6.621 1.3688 6.68171 1.36329 8.77357 1.36329C10.8654 1.36329 10.9261 1.3688 10.9813 1.47367ZM15.6729 13.8648V24.7104H8.77357H1.8743V13.8648V3.01911H8.77357H15.6729V13.8648ZM9.08818 25.4335C9.27584 25.5052 9.52973 25.7371 9.6346 25.9358C9.81122 26.2724 9.69532 26.7857 9.38623 27.0452C8.75702 27.575 7.83527 27.139 7.83527 26.3111C7.83527 25.6819 8.50864 25.2127 9.08818 25.4335Z"
                                                fill="black"></path>
                                            </svg>
                                        </div>
                                        <!-- single item 1 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googlePerformanceMobile" {{ $settings->settingsSub->google_performance_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googlePerformanceMobile">
                                                        Performance Score
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0–100 rating that reflects page speed and responsiveness on mobile devices and networks; higher scores denote better performance.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range1">
                                                    <span class="span-left">0</span>
                                                    <input id="score7" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_performance_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">100</span>
                                                </div>
                                                <div class="range-value">
                                                    <p>Greater than</p>
                                                    <input class="slider-input-text" type="number" id="googlePerformanceMobileVal" value="{{ $settings->settingsSub->google_performance_mobile_val}}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 2 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleAccessibilityMobile" {{ $settings->settingsSub->google_accessibility_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleAccessibilityMobile">
                                                        Accessibility
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">

                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0–100 rating that reflects page speed and responsiveness on mobile devices and networks; higher scores denote better performance.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range1">
                                                    <span class="span-left">90</span>
                                                    <input id="score8" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_accessibility_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">120</span>
                                                </div>
                                                <div class="range-value">
                                                    <p>Greater than</p>
                                                    <input class="slider-input-text" type="number" id="googleAccessibilityMobileVal" value="{{ $settings->settingsSub->google_accessibility_mobile_val}}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 3 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleBestPracticesMobile" {{ $settings->settingsSub->google_best_practices_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleBestPracticesMobile">
                                                        Best Practices
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">




                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0–100 rating that reflects adherence to modern web development and security practices on mobile; higher scores denote better compliance.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range1">
                                                    <span class="span-left">90</span>
                                                    <input id="score9" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_best_practices_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">120</span>
                                                </div>
                                                <div class="range-value">
                                                    <p>Greater than</p>
                                                    <input class="slider-input-text" type="number" id="googleBestPracticesMobileVal" value="{{ $settings->settingsSub->google_best_practices_mobile_val}}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 4 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleSeoMobile" {{ $settings->settingsSub->google_seo_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleSeoMobile">
                                                        SEO
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A 0–100 rating that reflects how well the page follows basic search optimization guidelines on mobile; higher scores denote better discoverability.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range1">
                                                    <span class="span-left">90</span>
                                                    <input id="score10" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_seo_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">120</span>
                                                </div>
                                                <div class="range-value">
                                                    <p>Greater than</p>
                                                    <input class="slider-input-text" type="number" id="googleSeoMobileVal" value="{{ $settings->settingsSub->google_seo_mobile_val}}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item -->
                                    </div>
                                </div>
                            </div>
                            <!-- performance button -->
                            <div class="accor-content-button performance-button">
                                <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsGoogleLighthouse" />
                            </div>
                        </div>
                    </div>

                    <!-- single accordion item -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Core Web Vitals</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->core_web_vitals ? "checked" : "" }} id="switchCoreWebVitals" name="switchCoreWebVitals" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content performance-content">
                                <div class="performance-left">
                                    <div class="accor-content">
                                        <div class="performance-title">
                                            <h4>Desktop</h4>
                                            <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.84603 0.81879C1.49767 1.04256 0.430452 2.01224 0.0919265 3.32044C0.0115984 3.63028 0.000122927 4.45651 0.000122927 10.2631C0.000122927 17.5156 -0.0170902 17.1426 0.355862 17.9115C0.631272 18.4795 1.28537 19.1106 1.89931 19.3975C2.16324 19.5238 2.5362 19.65 2.7198 19.6844C2.94357 19.7246 4.34932 19.7475 6.75342 19.7475H10.4428L9.98376 20.6656L9.52474 21.5836H8.15916C6.8567 21.5836 6.78785 21.5893 6.57555 21.7156C5.95014 22.0656 5.96735 22.9836 6.60424 23.3049C6.81654 23.4197 6.97146 23.4197 13.1395 23.4197C19.3076 23.4197 19.4625 23.4197 19.6748 23.3049C20.3231 22.9779 20.3231 22.0254 19.6748 21.6984C19.474 21.5951 19.3362 21.5836 18.1026 21.5836H16.7543L16.2953 20.6656L15.8362 19.7475H19.5485C23.6395 19.7475 23.6969 19.7418 24.4199 19.3975C24.9592 19.1393 25.6707 18.4336 25.9232 17.9115C26.2961 17.1426 26.2789 17.5098 26.2789 10.2803C26.2789 2.98765 26.2961 3.34339 25.8945 2.5688C25.6133 2.03519 24.9994 1.40978 24.4945 1.16305C23.6625 0.755676 24.6092 0.790102 13.3116 0.778627C7.71162 0.77289 3.00095 0.790102 2.84603 0.81879ZM23.3354 2.67781C23.7256 2.79257 24.0584 3.05076 24.2535 3.37782L24.4141 3.65322L24.4313 10.1828L24.4428 16.7123L24.3223 16.9992C24.2477 17.1656 24.0928 17.3779 23.9436 17.5098C23.4502 17.9459 24.3166 17.9115 13.1395 17.9115C2.00833 17.9115 2.8403 17.9402 2.35259 17.527C2.21488 17.4065 2.04849 17.1828 1.9739 17.0279L1.83619 16.7352V10.2459V3.75077L1.99685 3.45241C2.1862 3.08519 2.47308 2.83847 2.88046 2.70076C3.17308 2.60322 3.64358 2.59748 13.1166 2.59175C21.7518 2.59175 23.083 2.60322 23.3354 2.67781Z"
                                                fill="#222222" />
                                            </svg>
                                        </div>
                                        <!-- single item 1 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleLCPDesktop" {{ $settings->settingsSub->google_lcp_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleLCPDesktop">
                                                        Largest Contentful Paint
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            The time (in seconds) for the largest content element to render for desktop users; lower values indicate faster loading.

                                                        </p>

                                                        <div class="color-flex">

                                                            <p><span></span>&nbsp; Poor</p>

                                                            <h6>more than 4 seconds</h6>

                                                        </div>

                                                        <div class="color-flex">

                                                            <p><span></span>&nbsp; Average</p>

                                                            <h6>2.5 - 4 (seconds)</h6>

                                                        </div>

                                                        <div class="color-flex">

                                                            <p><span></span>&nbsp; Good</p>

                                                            <h6>0 - 2.5 (seconds)</h6>

                                                        </div>

                                                    </div>

                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range2">
                                                    <span class="span-left">0</span>
                                                    <input id="score11" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="5" data-slider-step="0.5" data-slider-value="{{ $settings->settingsSub->google_lcp_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">5</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleLCPDesktopVal" value="{{ $settings->settingsSub->google_lcp_desktop_val}}" min="0" max="5">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 2 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleFCPDesktop" {{ $settings->settingsSub->google_fcp_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="firstcp">
                                                        First Contentful Paint
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">


                                                    <div class="tooltips-contents">

                                                        <p>

                                                            The time (in seconds) until the first text or image appears for desktop users; lower values indicate faster loading.

                                                        </p>

                                                        <div class="color-flex">

                                                            <p><span></span>&nbsp; Poor</p>

                                                            <h6>more than 3 seconds</h6>

                                                        </div>

                                                        <div class="color-flex">

                                                            <p><span></span>&nbsp; Average</p>

                                                            <h6>1.8 - 3 (seconds)</h6>

                                                        </div>

                                                        <div class="color-flex">

                                                            <p><span></span>&nbsp; Good</p>

                                                            <h6>0 - 1.8 (seconds)</h6>

                                                        </div>

                                                    </div>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range2">
                                                    <span class="span-left">0</span>
                                                    <input id="score12" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="5" data-slider-step="0.5" data-slider-value="{{ $settings->settingsSub->google_fcp_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">5</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleFCPDesktopVal" value="{{ $settings->settingsSub->google_fcp_desktop_val}}" min="0" max="5">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 3 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleCLSDesktop" {{ $settings->settingsSub->google_cls_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="cls1">
                                                        Cumulative Layout Shift
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A unitless score that measures unexpected layout movement on desktop; lower values indicate better stability.

                                                        </p>

                                                        <div class="color-flex">

                                                            <p><span></span>&nbsp; Poor</p>

                                                            <h6>more than 0.25</h6>

                                                        </div>

                                                        <div class="color-flex">

                                                            <p><span></span>&nbsp; Average</p>

                                                            <h6>0.1 - 0.25</h6>

                                                        </div>

                                                        <div class="color-flex">

                                                            <p><span></span>&nbsp; Good</p>

                                                            <h6>0 - 0.1</h6>

                                                        </div>

                                                    </div>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range3">
                                                    <span class="span-left">0</span>
                                                    <input id="score13" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="0.5" data-slider-step="0.1" data-slider-value="{{ $settings->settingsSub->google_cls_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">0.5</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleCLSDesktopVal" value="{{ $settings->settingsSub->google_cls_desktop_val}}" min="0" max="0.5">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 4 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleFIDDesktop" {{ $settings->settingsSub->google_fid_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleFIDDesktop">
                                                        First Input Delay
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            The time (in milliseconds) from a user’s first interaction to the browser’s response on desktop; lower values indicate better responsiveness.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range4">
                                                    <span class="span-left">0</span>
                                                    <input id="score14" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="500" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_fid_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">500</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleFIDDesktopVal" value="{{ $settings->settingsSub->google_fid_desktop_val}}" min="0" max="500">
                                                        <span>ms</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 5 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleTBTDesktop" {{ $settings->settingsSub->google_tbt_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="tbt1">
                                                        Total Blocking TIme
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            The total time (in milliseconds) when the main thread was blocked long enough to delay input on desktop; lower values indicate better responsiveness.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range4">
                                                    <span class="span-left">0</span>
                                                    <input id="score15" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="500" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_tbt_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">500</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleTBTDesktopVal" value="{{ $settings->settingsSub->google_tbt_desktop_val}}" min="0" max="500">
                                                        <span>ms</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 6 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleTTIDesktop" {{ $settings->settingsSub->google_tti_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleTTIDesktop">
                                                        Time to Interactive
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            The time (in seconds) until the page is fully interactive for desktop users; lower values indicate better responsiveness.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range5">
                                                    <span class="span-left">0</span>
                                                    <input id="score16" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="8" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_tti_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">8</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleTTIDesktopVal" value="{{ $settings->settingsSub->google_tti_desktop_val}}" min="0" max="8">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 7 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleSIDesktop" {{ $settings->settingsSub->google_speed_index_desktop ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleSIDesktop">
                                                        Speed Index
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            The time (in seconds) showing how quickly content becomes visually complete on desktop; lower values indicate faster rendering.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range5">
                                                    <span class="span-left">0</span>
                                                    <input id="score17" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="8" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_speed_index_desktop_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">8</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleSIDesktopVal" value="{{ $settings->settingsSub->google_speed_index_desktop_val}}" min="0" max="8">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item -->
                                    </div>
                                </div>

                                <!-- mobile area -->
                                <div class="performance-right">
                                    <div class="accor-content">
                                        <div class="performance-title">
                                            <h4>Mobile</h4>
                                            <svg width="17" height="29" viewBox="0 0 17 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.02332 0.0441456C1.31131 0.215246 0.748334 0.822384 0.604829 1.57854C0.527557 1.98698 0.527557 26.2393 0.604829 26.6478C0.726256 27.2714 1.12917 27.8013 1.69767 28.0662L2.01228 28.2153H8.77357H15.5349L15.8495 28.0662C16.418 27.8013 16.8209 27.2714 16.9423 26.6478C17.0196 26.2393 17.0196 1.98698 16.9423 1.57854C16.8209 0.954849 16.418 0.424984 15.8495 0.160053L15.5349 0.0110283L8.88396 -1.14441e-05C5.1142 -1.14441e-05 2.14475 0.0165482 2.02332 0.0441456ZM10.9813 1.47367C11.0255 1.55095 11.0255 1.61718 10.9813 1.69445C10.9261 1.79932 10.8654 1.80484 8.77357 1.80484C6.68171 1.80484 6.621 1.79932 6.5658 1.69445C6.52165 1.61718 6.52165 1.55095 6.5658 1.47367C6.621 1.3688 6.68171 1.36329 8.77357 1.36329C10.8654 1.36329 10.9261 1.3688 10.9813 1.47367ZM15.6729 13.8648V24.7104H8.77357H1.8743V13.8648V3.01911H8.77357H15.6729V13.8648ZM9.08818 25.4335C9.27584 25.5052 9.52973 25.7371 9.6346 25.9358C9.81122 26.2724 9.69532 26.7857 9.38623 27.0452C8.75702 27.575 7.83527 27.139 7.83527 26.3111C7.83527 25.6819 8.50864 25.2127 9.08818 25.4335Z"
                                                fill="black"></path>
                                            </svg>
                                        </div>
                                        <!-- single item 1 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleLCPMobile" {{ $settings->settingsSub->google_lcp_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="lcprint">
                                                        Largest Contentful Paint
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            The time (in seconds) for the largest content element to render on mobile devices and networks; lower values indicate faster loading.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range2">
                                                    <span class="span-left">0</span>
                                                    <input id="score18" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="5" data-slider-step="0.5" data-slider-value="{{ $settings->settingsSub->google_lcp_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">5</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleLCPMobileVal" value="{{ $settings->settingsSub->google_lcp_mobile_val}}" min="0" max="5">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 2 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleFCPMobile" {{ $settings->settingsSub->google_fcp_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleFCPMobile">
                                                        First Contentful Paint
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            The time (in seconds) until the first text or image appears on mobile devices and networks; lower values indicate faster loading.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range2">
                                                    <span class="span-left">0</span>
                                                    <input id="score19" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="5" data-slider-step="0.5" data-slider-value="{{ $settings->settingsSub->google_fcp_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">5</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleFCPMobileVal" value="{{ $settings->settingsSub->google_fcp_mobile_val}}" min="0" max="5">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 3 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleCLSMobile" {{ $settings->settingsSub->google_cls_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleCLSMobile">
                                                        Cumulative Layout Shift
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents">

                                                        <p>

                                                            A unitless score that measures unexpected layout movement on mobile devices; lower values indicate better stability.

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
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range3">
                                                    <span class="span-left">0</span>
                                                    <input id="score20" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="0.5" data-slider-step="0.1" data-slider-value="{{ $settings->settingsSub->google_cls_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">0.5</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleCLSMobileVal" value="{{ $settings->settingsSub->google_cls_mobile_val}}" min="0" max="0.5">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 4 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleFIDMobile" {{ $settings->settingsSub->google_fid_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleFIDMobile">
                                                        First Input Delay
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents" style="width:300px;">

                                                        <p>

                                                            The time (in milliseconds) from a user’s first interaction to the browser’s response on mobile; lower values indicate better responsiveness.

                                                        </p>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Poor</p>

                                                            <h6>more than 300 (milliseconds)</h6>

                                                        </div>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Average</p>

                                                            <h6>100 - 300 (milliseconds)</h6>

                                                        </div>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Good</p>

                                                            <h6>0 - 100 (milliseconds)</h6>

                                                        </div>

                                                    </div>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range4">
                                                    <span class="span-left">0</span>
                                                    <input id="score21" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="500" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_fid_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">500</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleFIDMobileVal" value="{{ $settings->settingsSub->google_fid_mobile_val}}" min="0" max="500">
                                                        <span>ms</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 5 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleTBTMobile" {{ $settings->settingsSub->google_tbt_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleTBTMobile">
                                                        Total Blocking TIme
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents" style="width:300px;">

                                                        <p>

                                                            The total time (in milliseconds) when the main thread was blocked long enough to delay input on mobile; lower values indicate better responsiveness.

                                                        </p>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Poor</p>

                                                            <h6>more than 600 (milliseconds)</h6>

                                                        </div>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Average</p>

                                                            <h6>200 - 600 (milliseconds)</h6>

                                                        </div>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Good</p>

                                                            <h6>0 - 200 (milliseconds)</h6>

                                                        </div>

                                                    </div>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range4">
                                                    <span class="span-left">0</span>
                                                    <input id="score22" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="500" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_tbt_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">500</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleTBTMobileVal" value="{{ $settings->settingsSub->google_tbt_mobile_val}}" min="0" max="500">
                                                        <span>ms</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 6 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleTTIMobile" {{ $settings->settingsSub->google_tti_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleTTIMobile">
                                                        Time to Interactive
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents" style="width:300px;">

                                                        <p>

                                                            The time (in seconds) until the page is fully interactive on mobile devices; lower values indicate better responsiveness.

                                                        </p>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Poor</p>

                                                            <h6>more than 7.3 (seconds)</h6>

                                                        </div>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Average</p>

                                                            <h6>3.9 - 7.3 (seconds)</h6>

                                                        </div>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Good</p>

                                                            <h6>0 - 3.8 (seconds)</h6>

                                                        </div>

                                                    </div>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range5">
                                                    <span class="span-left">0</span>
                                                    <input id="score23" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="8" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_tti_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">8</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleTTIMobileVal" value="{{ $settings->settingsSub->google_tti_mobile_val}}" min="0" max="8">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item 7 -->
                                        <div class="overall-item overall-item2">
                                            <div class="tooltips-flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="googleSIMobile" {{ $settings->settingsSub->google_speed_index_mobile ? "checked" : "" }} />
                                                    <label class="form-check-label" for="googleSIMobile">
                                                        Speed Index
                                                    </label>
                                                </div>
                                                <div class="overall-tooltips">
                                                    <div class="tooltips-contents" style="width:300px;">

                                                        <p>

                                                            The time (in seconds) showing how quickly content becomes visually complete on mobile; lower values indicate faster rendering.

                                                        </p>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Poor</p>

                                                            <h6>more than 5.8 (seconds)</h6>

                                                        </div>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Average</p>

                                                            <h6>3.4 - 5.8 (seconds)</h6>

                                                        </div>

                                                        <div class="color-flex" style="max-width:230px;">

                                                            <p><span></span>&nbsp; Good</p>

                                                            <h6>0 - 3.4 (seconds)</h6>

                                                        </div>

                                                    </div>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M7.432 10.632C7.3976 10.67 7.36554 10.7101 7.336 10.752C7.30572 10.7966 7.28151 10.845 7.264 10.896C7.24094 10.9413 7.22476 10.9899 7.216 11.04C7.21208 11.0933 7.21208 11.1467 7.216 11.2C7.2133 11.3049 7.23522 11.4091 7.28 11.504C7.31593 11.6033 7.37325 11.6934 7.44791 11.7681C7.52256 11.8427 7.61273 11.9001 7.712 11.936C7.80776 11.9783 7.91131 12.0002 8.016 12.0002C8.1207 12.0002 8.22424 11.9783 8.32 11.936C8.41928 11.9001 8.50944 11.8427 8.58409 11.7681C8.65875 11.6934 8.71607 11.6033 8.752 11.504C8.78753 11.4067 8.80383 11.3035 8.8 11.2C8.80061 11.0947 8.78043 10.9903 8.74062 10.8929C8.70081 10.7954 8.64215 10.7067 8.568 10.632C8.49363 10.557 8.40515 10.4975 8.30766 10.4569C8.21018 10.4163 8.10561 10.3954 8 10.3954C7.89439 10.3954 7.78983 10.4163 7.69234 10.4569C7.59485 10.4975 7.50637 10.557 7.432 10.632ZM8 0C6.41775 0 4.87103 0.469192 3.55544 1.34824C2.23985 2.22729 1.21447 3.47672 0.608967 4.93853C0.00346627 6.40034 -0.15496 8.00887 0.153721 9.56072C0.462403 11.1126 1.22433 12.538 2.34315 13.6569C3.46197 14.7757 4.88743 15.5376 6.43928 15.8463C7.99113 16.155 9.59966 15.9965 11.0615 15.391C12.5233 14.7855 13.7727 13.7602 14.6518 12.4446C15.5308 11.129 16 9.58225 16 8C16 6.94942 15.7931 5.90914 15.391 4.93853C14.989 3.96793 14.3997 3.08601 13.6569 2.34315C12.914 1.60028 12.0321 1.011 11.0615 0.608964C10.0909 0.206926 9.05058 0 8 0ZM8 14.4C6.7342 14.4 5.49683 14.0246 4.44435 13.3214C3.39188 12.6182 2.57157 11.6186 2.08717 10.4492C1.60277 9.27972 1.47603 7.9929 1.72298 6.75142C1.96992 5.50994 2.57946 4.36957 3.47452 3.47452C4.36958 2.57946 5.50995 1.96992 6.75142 1.72297C7.9929 1.47603 9.27973 1.60277 10.4492 2.08717C11.6186 2.57157 12.6182 3.39187 13.3214 4.44435C14.0246 5.49682 14.4 6.7342 14.4 8C14.4 9.69738 13.7257 11.3252 12.5255 12.5255C11.3253 13.7257 9.69739 14.4 8 14.4ZM8 4C7.57845 3.99973 7.16427 4.1105 6.79913 4.32115C6.43399 4.53181 6.13078 4.83493 5.92 5.2C5.86212 5.29105 5.82325 5.39287 5.80574 5.49934C5.78823 5.6058 5.79244 5.71471 5.8181 5.81951C5.84377 5.9243 5.89038 6.02283 5.95511 6.10915C6.01984 6.19547 6.10137 6.2678 6.19478 6.32179C6.28819 6.37579 6.39156 6.41033 6.49867 6.42334C6.60578 6.43635 6.71441 6.42756 6.81803 6.3975C6.92165 6.36744 7.01812 6.31673 7.10164 6.24841C7.18516 6.1801 7.25399 6.0956 7.304 6C7.37449 5.87791 7.47598 5.77662 7.5982 5.70638C7.72042 5.63614 7.85903 5.59944 8 5.6C8.21217 5.6 8.41566 5.68428 8.56569 5.83431C8.71572 5.98434 8.8 6.18783 8.8 6.4C8.8 6.61217 8.71572 6.81565 8.56569 6.96568C8.41566 7.11571 8.21217 7.2 8 7.2C7.78783 7.2 7.58435 7.28428 7.43432 7.43431C7.28429 7.58434 7.2 7.78782 7.2 8V8.8C7.2 9.01217 7.28429 9.21565 7.43432 9.36568C7.58435 9.51571 7.78783 9.6 8 9.6C8.21217 9.6 8.41566 9.51571 8.56569 9.36568C8.71572 9.21565 8.8 9.01217 8.8 8.8V8.656C9.3291 8.46401 9.77389 8.09218 10.0566 7.60549C10.3393 7.11881 10.442 6.54823 10.3467 5.99351C10.2514 5.43879 9.96416 4.93521 9.5352 4.57081C9.10623 4.20641 8.56283 4.00437 8 4Z"
                                                        fill="#D3D5D8" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="score-range-flex">
                                                <div class="slider-range score-range5">
                                                    <span class="span-left">0</span>
                                                    <input id="score24" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="8" data-slider-step="1" data-slider-value="{{ $settings->settingsSub->google_speed_index_mobile_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                          { "start": 7, "end": 8, "class": "category2" },
                                                          { "start": 17, "end": 19 },
                                                          { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                          { "start": -3, "end": 19 }]' />
                                                    <span class="span-right">8</span>
                                                </div>
                                                <div class="range-value range-value2">
                                                    <p>less than</p>
                                                    <div class="range-sec">
                                                        <input class="slider-input-text" type="number" id="googleSIMobileVal" value="{{ $settings->settingsSub->google_speed_index_mobile_val}}" min="0" max="8">
                                                        <span>sec</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single item -->
                                    </div>
                                </div>
                            </div>
                            <!-- performance button -->
                            <div class="accor-content-button performance-button" style="text-align:right;">
                                <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsCoreWebVitals" />
                            </div>
                        </div>
                    </div>
                    <!-- single accordion end -->

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Mobile friendliness</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->mobile_friendly ? 'checked' : '' }} id="switchMobileFriendly" name="switchMobileFriendly" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <p><b>No Customisations are available for this test.</b></p>

                                    <p>This test checks for mobile friendliness of your webpages using Google's Mobile-Friendly Test API. You can read more on Google's mobile friendly test API <a target="_blank" href="https://developers.google.com/search/blog/2017/01/introducing-mobile-friendly-test-api">documentation here</a>.</p>

                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isMobileFriendly" {{ $settings->settingsSub->mobile_friendly ? "checked" : "" }} />
                                        <label class="form-check-label" for="isMobileFriendly">
                                            Page should be mobile friendly
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultIsMobileFriendly" />
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- performance tab content start -->

            <!-- on page tab content start -->
            <div class="tab-pane fade" id="v-pills-security" role="tabpanel" aria-labelledby="v-pills-security-tab" tabindex="0">
                <div class="tab-content-area">


                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Safe Browsing</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->is_safe_browsing ? 'checked' : '' }} id="switchIsSafeBrowsingHeader" name="switchIsSafeBrowsingHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isSafeBrowsingEnable" {{ $settings->settingsSub->is_safe_browsing ? "checked" : "" }} />
                                        <label class="form-check-label" for="isSafeBrowsingEnable">
                                            Safe Browsing
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultisSafeBrowsingEnable" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Unsafe Cross Origin Links</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->cross_origin_links ? 'checked' : '' }} id="switchCrossOriginLinksHeader" name="switchCrossOriginLinksHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isCrossOriginLinksEnable" {{ $settings->settingsSub->cross_origin_links ? "checked" : "" }} />
                                        <label class="form-check-label" for="isCrossOriginLinksEnable">
                                            Unsafe Cross Origin Links
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultCrossOriginLinksEnable" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Protocol Relative Resource Links</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->protocol_relative_resource ? 'checked' : '' }} id="switchProtocolRelativeResourceHeader" name="switchProtocolRelativeResourceHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isProtocolRelativeResourceEnable" {{ $settings->settingsSub->protocol_relative_resource ? "checked" : "" }} />
                                        <label class="form-check-label" for="isProtocolRelativeResourceEnable">
                                            protocol Relative Resource Links
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultProtocolRelativeResourceEnable" />
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Content Security Policy Header</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->content_security_policy_header ? 'checked' : '' }} id="switchContentSecurityPolicyHeader" name="switchContentSecurityPolicyHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="IsContentSecurityPolicyHeader" {{ $settings->settingsSub->content_security_policy_header ? "checked" : "" }} />
                                        <label class="form-check-label" for="IsContentSecurityPolicyHeader">
                                            Content Security Policy Header must be enabled.
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsContentSecurityPolicyHeader" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion -->


                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>X Frame Options Header</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->x_frame_options_header ? 'checked' : '' }} id="switchXFrameOptionsHeader" name="switchXFrameOptionsHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="IsXFrameOptionsHeader" {{ $settings->settingsSub->x_frame_options_header ? "checked" : "" }} />
                                        <label class="form-check-label" for="IsXFrameOptionsHeader">
                                            X Frame Options Header must be enabled.
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsXframeOptionsHeader" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion end -->

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>HSTS Header</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->hsts_header ? 'checked' : '' }} id="switchHSTS" name="switchHSTS" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isHSTS" {{ $settings->settingsSub->hsts_header ? "checked" : "" }} />
                                        <label class="form-check-label" for="isHSTS">
                                            Every page must have HSTS enabled
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsHSTS" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>SSL Certificate</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->ssl_certificate_enable ? 'checked' : '' }} id="switchSSLCertificateEnableHeader" name="switchSSLCertificateEnableHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isSSLCertificateEnableType" {{ $settings->settingsSub->ssl_certificate_enable ? "checked" : "" }} />
                                        <label class="form-check-label" for="isSSLCertificateEnableType">
                                            SSL Certificate
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsIsSSLCertificate" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Bad Content Type</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->bad_content_type ? 'checked' : '' }} id="switchBadContentTypeHeader" name="switchBadContentTypeHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isBadContentType" {{ $settings->settingsSub->bad_content_type ? "checked" : "" }} />
                                        <label class="form-check-label" for="isBadContentType">
                                            Bad Content Type.
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsIsBadContentType" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Directory Browsing</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->folder_browsing_enable ? 'checked' : '' }} id="switchFolderBrowsingEnableHeader" name="switchFolderBrowsingEnableHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isFolderBrowsingEnable" {{ $settings->settingsSub->folder_browsing_enable ? "checked" : "" }} />
                                        <label class="form-check-label" for="isFolderBrowsingEnable">
                                            Directory Browsing
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultisFolderBrowsingEnable" />
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- on page tab content end -->

            <!-- coding practices tab content start -->
            <div class="tab-pane fade" id="v-pills-coding" role="tabpanel" aria-labelledby="v-pills-coding-tab" tabindex="0">
                <div class="tab-content-area">
                    <!-- single accordion item -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>HTML Compression</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->html_compression ? "checked" : "" }} id="switchHTMLCompression" name="switchHTMLCompression" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="htmlCompression" {{ $settings->settingsSub->is_html_compression ? "checked" : "" }} />
                                        <label class="form-check-label" for="htmlCompression">
                                            HTML Code has to be compressed and minified
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsHTMLCompression" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion item -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>CSS Compression</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->css_compression ? "checked" : "" }} id="switchCSSCompression" name="switchCSSCompression" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="cssCompression" {{ $settings->settingsSub->is_css_compression ? "checked" : "" }} />
                                        <label class="form-check-label" for="cssCompression">
                                            CSS Code has to be compressed and minified
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsCSSCompression" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion item -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>JS Compression</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->js_compression ? "checked" : "" }} id="switchJSCompression" name="switchJSCompression" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="jsCompression" {{ $settings->settingsSub->is_js_compression ? "checked" : "" }} />
                                        <label class="form-check-label" for="jsCompression">
                                            All external JavaScript code must be compressed and minified
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsJSCompression" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion item -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>GZIP Compression</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->gzip_compression ? "checked" : "" }} id="switchGZIPCompression" name="switchGZIPCompression" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="gzipCompression" {{ $settings->settingsSub->is_gzip_compression ? "checked" : "" }} />
                                        <label class="form-check-label" for="gzipCompression">
                                            All external JavaScript code must be compressed and minified
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsGZIPCompression" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion end -->

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Nested Tables</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->nested_tables ? 'checked' : '' }} id="switchNestedTables" name="switchNestedTables" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="noNestedTables" {{ $settings->settingsSub->no_nested_tables ? "checked" : "" }} />
                                        <label class="form-check-label" for="noNestedTables">
                                            The HTML Page should not have any nested tables.
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsNestedTables" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion end -->

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>HTML Page Size</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->page_size ? 'checked' : '' }} id="switchPageSize" name="switchPageSize" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">

                                    <div class="check-range">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="pageSize" {{ $settings->settingsSub->page_size ? "checked" : "" }} />
                                            <label class="form-check-label" for="pageSize">
                                                Maximum size of the HTML page should be
                                                <input class="slider-input-text" type="number" id="pageSizeVal" value="{{$settings->settingsSub->page_size_val}}" min="0" max="100"> KB
                                            </label>
                                        </div>
                                        <div class="slider-range">
                                            <span class="span-left">0</span>
                                            <input id="ex21" type="text" data-slider-id="slider22" class="slider-input" data-slider-min="0" data-slider-max="150" data-slider-step="1" data-slider-value="{{$settings->settingsSub->page_size_val}}" data-slider-rangeHighlights='[{ "start": 2, "end": 5, "class": "category1" },
                                                      { "start": 7, "end": 8, "class": "category2" },
                                                      { "start": 17, "end": 19 },
                                                      { "start": 17, "end": 24 }, //not visible -  out of slider range
                                                      { "start": -3, "end": 19 }]' />
                                            <span class="span-right">150</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsPageSize" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion end -->


                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Frameset</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->frameset ? 'checked' : '' }} id="switchFrameset" name="switchFrameset" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isFrameset" {{ $settings->settingsSub->no_frameset ? "checked" : "" }} />
                                        <label class="form-check-label" for="isFrameset">
                                            Webpage should not be using any frameset tag
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultSettingsFrameset" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single accordion end -->



                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>Broken Links</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->broken_links ? 'checked' : '' }} id="switchBrokenLinksHeader" name="switchBrokenLinksHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="isBrokenLinksEnable" {{ $settings->settingsSub->broken_links ? "checked" : "" }} />
                                        <label class="form-check-label" for="isBrokenLinksEnable">
                                            Check for all broken links(links that do not have 200 status code)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input hideInputCheck" type="checkbox" id="brokenLinksExcludeUrls" {{ $settings->settingsSub->broken_links_exclude_urls ? "checked" : "" }} />
                                        <label class="form-check-label" for="brokenLinksExcludeUrls">
                                            Exclude specific URLs from broken links check
                                        </label>
                                    </div>
                                    <div class="hideInputCheckElement">
                                        <a type="button" class="add-more-broken-links-excluded" id="addMoreBrokenLinksExcluded">
                      Ignore List
                    </a>
                                        <div class="mt-2" id="brokenLinksExcludedPreview"></div>
                                    </div>
                                </div>
                                <div class="accor-content-button">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultBrokenLinksEnable" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>CSS caching</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->css_caching_enable ? 'checked' : '' }} id="switchCssCachingEnableHeader" name="switchCssCachingEnableHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isCssCachingEnable" {{ $settings->settingsSub->css_caching_enable ? "checked" : "" }} />
                                        <label class="form-check-label" for="isCssCachingEnable">
                                            CSS caching
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultisCssCachingEnable" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single accordion -->
                    <div class="accor-single-item">
                        <div class="accor-head">
                            <div class="accor-title-btn">
                                <button>
                                    <img src="/new-assets/assets/images/setting/menu-content-arrow.svg" alt="btn" />
                                </button>
                                <span>JS caching</span>
                            </div>
                            <div class="accor-head-switch">
                                <div class="toggle-button-cover">
                                    <div class="button-cover">
                                        <div class="button r" id="button-9">
                                            <input type="checkbox" class="checkbox" {{ $settings->js_caching_enable ? 'checked' : '' }} id="switchJsCachingEnableHeader" name="switchJsCachingEnableHeader" />
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accor-body">
                            <div class="meta-content">
                                <div class="accor-content"><p>No Customisations are available for this test.</p>
                                    <div class="form-check" style="display:none;">
                                        <input class="form-check-input" type="checkbox" id="isJsCachingEnable" {{ $settings->settingsSub->js_caching_enable ? "checked" : "" }} />
                                        <label class="form-check-label" for="isJsCachingEnable">
                                            JS caching
                                        </label>
                                    </div>
                                </div>
                                <div class="accor-content-button" style="display:none;">
                                    <input class="reset-default btn btn_primary rounded-pill" type="submit" value="Reset" id="defaultisJSCachingEnable" />
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- coding practices tab content end -->
  <!-- reports tab content start -->
      <div
        class="tab-pane fade"
        id="v-pills-reports"
        role="tabpanel"
        aria-labelledby="v-pills-reports-tab"
        tabindex="0"
      >
        <div class="tab-content-area">
          <!-- SEO accordion -->
          <div class="accor-single-item">
            <div class="accor-head">
              <div class="accor-title-btn">
                <button>
                  <img
                    src="/new-assets/assets/images/setting/menu-content-arrow.svg"
                    alt="btn"
                  />
                </button>
                <span>SEO</span>
              </div>
            </div>
            <div class="accor-body">
              <div class="meta-content" style="background-color: rgba(255, 255, 255, 1); padding: 0;">
                <div class="accor-content" style="padding: 0;">
                  <!-- Meta Title Report -->
                  <div class="report-item" style="border-bottom: 1px solid #e0e0e0; padding-bottom: 15px; margin: 0;">
                    <div class="report-label">
                      <span>Meta Title</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/meta-title" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchMetaTitleReport"
                              {{ !$reportSettings || $reportSettings->meta_title ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Meta Description Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Meta Description</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/description" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchMetaDescReport"
                              {{ !$reportSettings || $reportSettings->meta_desc ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Robots Meta Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Robots Meta Tag</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/robots-meta" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchRobotsMetaReport"
                              {{ !$reportSettings || $reportSettings->robots_meta ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Canonical URL Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Canonical URL</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/canonical" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCanonicalUrlReport"
                              {{ !$reportSettings || $reportSettings->canonical_url ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Images Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Images</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/images" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchImagesReport"
                              {{ !$reportSettings || $reportSettings->images ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- URL Slug Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>URL Slug</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/url-slug" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchUrlSlugReport"
                              {{ !$reportSettings || $reportSettings->url_slug ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Robots.txt Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Robots.txt</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/robots-meta" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchRobotTextTestReport"
                              {{ !$reportSettings || $reportSettings->robot_text_test ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Headings Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Headings</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/headings" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchH1HeadingTagReport"
                              {{ !$reportSettings || $reportSettings->h1_heading_tag ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- XML Sitemap Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>XML Sitemap</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/xml-sitemap" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchXmlSitemapReport"
                              {{ !$reportSettings || $reportSettings->xml_sitemap ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Open Graph Title Tag Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Open Graph Title Tag</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/og-tags" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchOpenGraphTagsReport"
                              {{ !$reportSettings || $reportSettings->open_graph_tags ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Twitter Tags Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Twitter Tags</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/twitter-tags" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchTwitterTagsReport"
                              {{ !$reportSettings || $reportSettings->twitter_tags ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Favicon Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Favicon</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/favicon" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchFaviconReport"
                              {{ !$reportSettings || $reportSettings->favicon ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Meta Viewport Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Meta Viewport</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/meta-viewport" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchMetaViewportReport"
                              {{ !$reportSettings || $reportSettings->meta_viewport ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Doctype Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Doctype</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/doctype" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchDoctypeReport"
                              {{ !$reportSettings || $reportSettings->doctype ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- HTTP Status Code Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>HTTP Status Code</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/http-status-code" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchHttpStatusCodeReport"
                              {{ !$reportSettings || $reportSettings->http_status_code ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Performance accordion -->
          <div class="accor-single-item">
            <div class="accor-head">
              <div class="accor-title-btn">
                <button>
                  <img
                    src="/new-assets/assets/images/setting/menu-content-arrow.svg"
                    alt="btn"
                  />
                </button>
                <span>Performance</span>
              </div>
            </div>
            <div class="accor-body">
              <div class="meta-content" style="background-color: rgba(255, 255, 255, 1); padding: 0;">
                <div class="accor-content" style="padding: 0;">
                  <!-- Overall Score Report -->
                  <div class="report-item" style="border-bottom: 1px solid #e0e0e0; padding-bottom: 15px; margin: 0;">
                    <div class="report-label">
                      <span>Overall Score</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/google-page-speed-insights" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchGoogleOverallReport"
                              {{ !$reportSettings || $reportSettings->google_overall ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Lighthouse Score Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Lighthouse Score</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/google-page-speed-lighthouse" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchGoogleLighthouseReport"
                              {{ !$reportSettings || $reportSettings->google_lighthouse ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Core Web Vitals Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Core Web Vitals</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/google-page-speed-core-web-vitals" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCoreWebVitalsReport"
                              {{ !$reportSettings || $reportSettings->core_web_vitals ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Mobile Friendliness Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Mobile Friendliness</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/mobile-friendly" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchMobileFriendlyReport"
                              {{ !$reportSettings || $reportSettings->mobile_friendly ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Best Practices accordion -->
          <div class="accor-single-item">
            <div class="accor-head">
              <div class="accor-title-btn">
                <button>
                  <img
                    src="/new-assets/assets/images/setting/menu-content-arrow.svg"
                    alt="btn"
                  />
                </button>
                <span>Best Practices</span>
              </div>
            </div>
            <div class="accor-body">
              <div class="meta-content" style="background-color: rgba(255, 255, 255, 1); padding: 0;">
                <div class="accor-content" style="padding: 0;">
                  <!-- HTML Compression Report -->
                  <div class="report-item" style="border-bottom: 1px solid #e0e0e0; padding-bottom: 15px; margin: 0;">
                    <div class="report-label">
                      <span>HTML Compression</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/html-compression" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchHtmlCompressionReport"
                              {{ !$reportSettings || $reportSettings->html_compression ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- CSS Compression Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>CSS Compression</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/css-compression" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCssCompressionReport"
                              {{ !$reportSettings || $reportSettings->css_compression ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- JS Compression Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>JavaScript Compression</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/js-compression" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchJsCompressionReport"
                              {{ !$reportSettings || $reportSettings->js_compression ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- GZIP Compression Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>GZIP Compression</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/gzip-compression" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchGzipCompressionReport"
                              {{ !$reportSettings || $reportSettings->gzip_compression ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- CSS Caching Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>CSS Caching</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/css-caching" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCssCachingReport"
                              {{ !$reportSettings || $reportSettings->css_caching_enable ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- JS Caching Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>JS Caching</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/js-caching" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchJsCachingReport"
                              {{ !$reportSettings || $reportSettings->js_caching_enable ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Page Size Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Page Size</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/page-size" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchPageSizeReport"
                              {{ !$reportSettings || $reportSettings->page_size ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Nested Tables Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Nested Tables</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/nested-tables" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchNestedTablesReport"
                              {{ !$reportSettings || $reportSettings->nested_tables ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Frameset Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Frameset</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/frameset" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchFramesetReport"
                              {{ !$reportSettings || $reportSettings->frameset ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Broken Links Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Broken Links</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/broken-links" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchBrokenLinksReport"
                              {{ !$reportSettings || $reportSettings->broken_links ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Security accordion -->
          <div class="accor-single-item">
            <div class="accor-head">
              <div class="accor-title-btn">
                <button>
                  <img
                    src="/new-assets/assets/images/setting/menu-content-arrow.svg"
                    alt="btn"
                  />
                </button>
                <span>Security</span>
              </div>
            </div>
            <div class="accor-body">
              <div class="meta-content" style="background-color: rgba(255, 255, 255, 1); padding: 0;">
                <div class="accor-content" style="padding: 0;">
                  <!-- Safe Browsing Report -->
                  <div class="report-item" style="border-bottom: 1px solid #e0e0e0; padding-bottom: 15px; margin: 0;">
                    <div class="report-label">
                      <span>Safe Browsing</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/safe-browsing" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchSafeBrowsingReport"
                              {{ !$reportSettings || $reportSettings->is_safe_browsing ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Unsafe Cross Origin Links Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Unsafe Cross Origin Links</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/unsafe-cross-origin-links" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchCrossOriginLinksReport"
                              {{ !$reportSettings || $reportSettings->cross_origin_links ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Protocol Relative Resource Links Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Protocol Relative Resource Links</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/protocol-relative-resource" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchProtocolRelativeResourceReport"
                              {{ !$reportSettings || $reportSettings->protocol_relative_resource ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Content Security Policy Header Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Content Security Policy Header</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/content-security-policy-header" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchContentSecurityPolicyReport"
                              {{ !$reportSettings || $reportSettings->content_security_policy_header ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- X Frame Options Header Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>X Frame Options Header</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/x-frame-options-header" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchXFrameOptionsReport"
                              {{ !$reportSettings || $reportSettings->x_frame_options_header ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- HSTS Header Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>HSTS Header</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/hsts-header" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchHstsHeaderReport"
                              {{ !$reportSettings || $reportSettings->hsts_header ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Bad Content Type Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Bad Content Type</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/bad-content-type" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchBadContentTypeReport"
                              {{ !$reportSettings || $reportSettings->bad_content_type ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- SSL Certificate Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>SSL Certificate</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/ssl-certificate" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchSslCertificateReport"
                              {{ !$reportSettings || $reportSettings->ssl_certificate_enable ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Directory Browsing Report -->
                  <div class="report-item">
                    <div class="report-label">
                      <span>Directory Browsing</span>
                    </div>
                    <div class="report-actions">
                      <a href="/reports/directory-browsing" target="_blank" class="open-link">Open Link <i class="fas fa-external-link-alt"></i></a>
                    </div>
                    <div class="report-switch">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-9">
                            <input
                              type="checkbox"
                              class="checkbox"
                              id="switchFolderBrowsingReport"
                              {{ !$reportSettings || $reportSettings->folder_browsing_enable ? 'checked' : '' }}
                            />
                            <div class="knobs">
                              <span></span>
                            </div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- reports tab content end -->
    </div>

    <!-- default button start -->
    <div class="reset-bottom-btn">
      <input
        class="reset-default btn btn_primary rounded-pill"
        type="submit"
        value="Reset"
        id="defaultSettings"
      />
    </div>
    <!-- default button end -->
  </div>
</div>
<!-- setting content and tab content area end -->

<style>
.report-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #e9ecef;
    gap: 20px;
}

.report-item:last-child {
    border-bottom: none;
}

.report-label {
    flex: 1;
    font-size: 16px;
    color: #333;
    font-weight: 500;
}

.report-actions {
    margin-right: 80px;
}

.open-link {
    color: #007bff;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.open-link:hover {
    color: #0056b3;
    text-decoration: none;
}

.open-link i {
    font-size: 12px;
}

.report-switch {
    flex-shrink: 0;
}
</style>




@endsection @section("js")
<script>
    var addSitemapModal = new bootstrap.Modal(document.getElementById('addSitemapModal'), {
      keyboard: false
    })
    var addBrokenLinksExcludedModal = new bootstrap.Modal(document.getElementById('addBrokenLinksExcludedModal'), {
      keyboard: false
    })
    
    const settings = {!! $settings->toJson() !!};
    const project = {!! $project->toJson() !!};

    // Initialize broken links excluded preview on page load
    $(document).ready(function() {
      const excludedUrls = settings.settings_sub.broken_links_excluded_urls;
      if (excludedUrls) {
        const urlsArray = excludedUrls.split(',').map(url => url.trim()).filter(url => url);
        updateBrokenLinksExcludedPreview(urlsArray);
      }
    });

    const defaultMetaTitle = {
        "switchMetaTitle": 1,
        "isMetaTitle": 1,
        "titleMaxLength": 1,
        "titleMaxLengthVal": 65,
        "titleMinLength": 0,
        "titleMinLengthVal": "",
        "titleEquaH1": 1,
        "casingBoth": 1,
        "casingCamel": 0,
        "casingSentence": 0,
        "excludedWordsCasing": 0,
        "excludedWordsCasingVal": "",
    }
    const defaultMetaDesc = {
        "switchMetaDesc": 1,
        "isMetaDesc": 1,
        "metaDescLengthMax": 1,
        "metaDescLengthMaxVal": 160,
        "metaDescLengthMin": 0,
        "metaDescLengthMinVal": "",
    }
    const defaultRobotsMeta = {
        "switchRobotsMeta": 1,
        "liveRobotsMeta": 1,
    }
    const defaultCanonical = {
        "switchCanonical": 1,
        "canonicalUrl": 1,
        "canonicalEqualUrl": 1,
        "canonicalIgnoreSlash": 1,
    }
    const defaultURL = {
        "switchUrlSlug": 1,
        "UrlLowercase": 1,
        "UrlNoNumbers": 0,
        "UrlNoSpecial": 1,
        "maxUrlLength": 1,
        "maxUrlLengthVal": 60,
        "UrlOnlyHyphens": 1,
        "UrlOnlyUnderscores": 0,
        "UrlBoth": 0,
        "UrlStopWords": 0,
        "UrlStopWordsVal": "",
    }
    const defaultOGTitle = {
        "switchOgTitle": 1,
        "isOgTitle": 1,
        "ogTitleMax": 1,
        "ogTitleMaxVal": 95,
        "ogTitleMin": 1,
        "ogTitleMinVal": 40,
        "ogTitleEqualTitle": 0,
        "ogTitleCasingSentence": 0,
        "ogTitleCasingCamel": 1,
        "ogTitleCasingBoth": 0,
    }
    const defaultOGDesc = {
        "isOgDesc": 1,
        "OgDescMax": 1,
        "OgDescMaxVal": 200,
        "OgDescMin": 1,
        "OgDescMinVal": 40,
        "ogDescEqualDesc": 0,
    }
    const defaultOGImage = {
        "isOgImage": 1,
        "ogImageDimensionsLeast": 0,
        "ogImageDimensionsLeastWidth": 0,
        "ogImageDimensionsLeastHeight": 0,
        "ogImageDimensionsExact": 1,
        "ogImageDimensionsExactWidth": 1200,
        "ogImageDimensionsExactHeight": 630,
    }
    const defaultOGUrl = {
        "isOgUrl": 10,
        "ogUrlEqualUrl": 0,
        "ogUrlMax": 10,
        "ogUrlMaxVal": 60,
    }
    const defaultTwitterTitle = {
        "switchTwitterTitle": 1,
        "isTwitterTitle": 1,
        "twitterTitleLengthMax": 1,
        "twitterTitleLengthMaxVal": 170,
        "twitterTitleLengthMin": 0,
        "twitterTitleLengthMinVal": "",
        "twitterTitleEqualTitle": 0,
        "twitterTitleCasingSentence": 0,
        "twitterTitleCasingCamel": 1,
        "twitterTitleCasingBoth": 0,
    }
    const defaultTwitterImage = {
        "isTwitterImage": 1,
        "twitterImageDimensionsMin": 0,
        "twitterImageWidthMin": 0,
        "twitterImageHeightMin": 0,
        "twitterImageDimensionsExact": 1,
        "twitterImageWidthExact": 1200,
        "twitterImageHeightExact": 675,
    }
    const defaultTwitterImageAlt = {
        "isTwitterImageAlt": 1,
        "twitterImageAltMax": 1,
        "twitterImageAltMaxVal": 400,
    }
    const defaultFavicon = {
        "switchFavicon": 1,
        "isFavicon": 1,
        "faviconDimensionsMin": 0,
        "faviconWidthMin": 0,
        "faviconHeightMin": 0,
        "faviconDimensionsExact": 0,
        "faviconWidthExact": 0,
        "faviconHeightExact": 0,
    }
    const defaultXMLSitemap = {
        "switchXML": 1,
        "isXmlSitemap": 0,
        "isXmlSitemapCustom": 1,
        "xmlSitemapVal": `${project.homepage}/xml.sitemap`,
    }
    const defaultHTMLSitemap = {
        "switchHTML": 0,
        "isHtmlSitemap": 0,
        "isHtmlSitemapCustom": 1,
        "htmlSitemapVal": `${project.homepage}/sitemap`,
    }
    const defaultSchema = {
        "switchSchema": 0,
        "isSchemaTest": 0,
        "isSchemaTestCustom": 1,
        "schemaVal": "",
    }
    const defaultViewport = {
        "switchViewport": 1,
        "isMetaViewport": 1,
    }
    const defaultFrameset = {
        "switchFrameset": 1,
        "isFrameset": 1,
    }
    const defaultDoctype = {
        "switchDoctype": 1,
        "isDoctype": 1,
    }

    const defaultNestedTables = {
        "switchNestedTables": 1,
        "noNestedTables": 1,
    }

    const defaultContentSecurityPolicyHeader = {
        "switchContentSecurityPolicyHeader": 1,
        "IsContentSecurityPolicyHeader": 1,
    }

    const defaultXframeOptionsHeader = {
        "switchXFrameOptionsHeader": 1,
        "IsXFrameOptionsHeader": 1,
    }

    const defaultBadContentHeader = {
        "switchBadContentTypeHeader": 1,
        "isBadContentType": 1,
    }

    const defaultSSLCertificate = {
        "switchSSLCertificateEnableHeader": 1,
        "isSSLCertificateEnableType": 1,
    }

    const defaultisFolderBrowsingEnable = {
        "switchFolderBrowsingEnableHeader": 1,
        "isFolderBrowsingEnable": 1,
    }

    const defaultisCssCachingEnable = {
        "switchCssCachingEnableHeader": 1,
        "isCssCachingEnable": 1,
    }

    const defaultisJsCachingEnable = {
        "switchJsCachingEnableHeader": 1,
        "isJsCachingEnable": 1,
    }

    const defaultIsMobileFriendly = {
        "switchMobileFriendly": 1,
        "isMobileFriendly": 1,
    }

    const defaultisSafeBrowsing = {
        "switchIsSafeBrowsingHeader": 1,
        "isSafeBrowsingEnable": 1,
    }

    const defaultCrossOriginLinks = {
        "switchCrossOriginLinksHeader": 1,
        "isCrossOriginLinksEnable": 1,
    }

    const defaultBrokenLinks = {
        "switchBrokenLinksHeader": 1,
        "isBrokenLinksEnable": 1,
    }

    

    const defaultProtocolRelativeResource = {
        "switchProtocolRelativeResourceHeader": 1,
        "isProtocolRelativeResourceEnable": 1,
    }

    const defaultRobotText = {
        "switchRobotTxtTestHeader": 1,
        "isRobotTextTestBlockUrlEnable": 1,
    }
    

    const defaultH1HeadingTag = {
        "switchH1HeadingTag": 1,
        "isH1HeadingTagEnable": 1,
        "h1HeadingTagLength": 1,
        "h1HeadingTagLengthVal": 1,
        "h2HeadingTagLength": 0,
        "h2HeadingTagLengthVal": 1,
        "h3HeadingTagLength": 0,
        "h3HeadingTagLengthVal": 1,
        "h4HeadingTagLength": 0,
        "h4HeadingTagLengthVal": 1,
        "h5HeadingTagLength": 0,
        "h5HeadingTagLengthVal": 1,
        "h6HeadingTagLength": 0,
        "h6HeadingTagLengthVal": 1,
        
    }

    const defaultPageSize = {
        "switchPageSize": 1,
        "pageSize": 1,
        "pageSizeVal": 100,
    }

    const defaultHSTS = {
        "switchHSTS": 1,
        "isHSTS": 1,
    }

    const defaultImages = {
        "switchImages": 1,
        "maximumFileSize": 1,
        "maximumFileSizeVal": 150,
        "imageNameHyphen": 1,
        "imageNameUppercase": 1,
        "imageNameSpecial": 1,
        "imageNameLength": 1,
        "imageNameLengthVal": 50,
        "imageAlt": 1,
        "imageAltSpaces": 1,
    }
    const defaultHTMLCompression = {
        "switchHTMLCompression": 1,
        "htmlCompression": 0,
    }
    const defaultCSSCompression = {
        "switchCSSCompression": 1,
        "cssCompression": 0,
    }
    const defaultJSCompression = {
        "switchJSCompression": 1,
        "jsCompression": 0,
    }
    const defaultGZIPCompression = {
        "switchGZIPCompression": 1,
        "gzipCompression": 0,
    }
    const defaultGoogleOverall = {
        "switchGoogleOverall": 1,
        "googleInsightsDesktop": 1,
        "googleInsightsDesktopVal": 90,
        "googleInsightsMobile": 1,
        "googleInsightsMobileVal": 90,
    }
    const defaultGoogleLighthouse = {
        "switchGoogleLighthouse": 1,
        "googlePerformanceDesktop": 1,
        "googlePerformanceDesktopVal": 90,
        "googlePerformanceMobile": 1,
        "googlePerformanceMobileVal": 90,
        "googleAccessibilityDesktop": 1,
        "googleAccessibilityDesktopVal": 90,
        "googleAccessibilityMobile": 1,
        "googleAccessibilityMobileVal": 90,
        "googleBestPracticesDesktop": 1,
        "googleBestPracticesDesktopVal": 90,
        "googleBestPracticesMobile": 1,
        "googleBestPracticesMobileVal": 90,
        "googleSeoDesktop": 1,
        "googleSeoDesktopVal": 90,
        "googleSeoMobile": 1,
        "googleSeoMobileVal": 90,
    }
    const defaultCoreWebVitals = {
        "switchCoreWebVitals": 1,
        "googleLCPDesktop": 1,
        "googleLCPDesktopVal": 2.5,
        "googleLCPMobile": 1,
        "googleLCPMobileVal": 2.5,
        "googleFCPDesktop": 1,
        "googleFCPDesktopVal": 2,
        "googleFCPMobile": 1,
        "googleFCPMobileVal": 2,
        "googleCLSDesktop": 1,
        "googleCLSDesktopVal": .1,
        "googleCLSMobile": 1,
        "googleCLSMobileVal": .1,
        "googleFIDDesktop": 1,
        "googleFIDDesktopVal": 100,
        "googleFIDMobile": 1,
        "googleFIDMobileVal": 100,
        "googleTBTDesktop": 1,
        "googleTBTDesktopVal": 300,
        "googleTBTMobile": 1,
        "googleTBTMobileVal": 300,
        "googleTTIDesktop": 1,
        "googleTTIDesktopVal": 4,
        "googleTTIMobile": 1,
        "googleTTIMobileVal": 4,
        "googleSIDesktop": 1,
        "googleSIDesktopVal": 4,
        "googleSIMobile": 1,
        "googleSIMobileVal": 4,
    }

    const defaultSettings = {
            "switchMetaTitle": 1,
            "switchMetaDesc": 1,
            "switchRobotsMeta": 1,
            "switchCanonical": 1,
            "switchUrlSlug": 1,
            "switchOgTitle": 1,
            "switchTwitterTitle": 1,
            "switchFavicon": 1,
            "switchXML": 1,
            "switchSchema": 0,
            "switchHTML": 0,
            "switchViewport": 1,
            "switchFrameset": 1,
            "switchDoctype": 1,
            "switchPageSize": 1,
            "switchHSTS": 1,
            "switchNestedTables": 1,
            "switchContentSecurityPolicyHeader": 1,
            "switchXFrameOptionsHeader": 1,
            "switchBadContentTypeHeader": 1,
            "switchSSLCertificateEnableHeader": 1,
            "switchFolderBrowsingEnableHeader": 1,
            "switchCssCachingEnableHeader": 1,
            "switchJsCachingEnableHeader": 1,
            "switchMobileFriendly": 1,

            "switchIsSafeBrowsingHeader": 1,
            "switchCrossOriginLinksHeader": 1,
            "switchBrokenLinksHeader": 1,
            "switchProtocolRelativeResourceHeader": 1,
            "switchRobotTxtTestHeader": 1,
            "switchH1HeadingTag": 1,
            
            "switchImages": 1,
            "switchHTMLCompression": 1,
            "switchCSSCompression": 1,
            "switchJSCompression": 1,
            "switchGZIPCompression": 1,
            "switchGoogleOverall": 1,
            "switchGoogleLighthouse": 1,
            "switchCoreWebVitals": 1,

            "isMetaTitle": 1,
            "titleMaxLength": 1,
            "titleMaxLengthVal": 65,
            "titleMinLength": 0,
            "titleMinLengthVal": "",
            "titleEquaH1": 1,
            "casingBoth": 1,
            "casingCamel": 0,
            "casingSentence": 0,
            "excludedWordsCasing": 0,
            "excludedWordsCasingVal": "",

            "isMetaDesc": 1,
            "metaDescLengthMax": 1,
            "metaDescLengthMaxVal": 160,
            "metaDescLengthMin": 0,
            "metaDescLengthMinVal": "",

            "liveRobotsMeta": 1,


            "canonicalUrl": 1,
            "canonicalEqualUrl": 1,
            "canonicalIgnoreSlash": 1,

            "UrlLowercase": 1,
            "UrlNoNumbers": 0,
            "UrlNoSpecial": 1,
            "maxUrlLength": 1,
            "maxUrlLengthVal": 60,
            "UrlOnlyHyphens": 1,
            "UrlOnlyUnderscores": 0,
            "UrlBoth": 0,
            "UrlStopWords": 0,
            "UrlStopWordsVal": "",

            "isOgTitle": 1,
            "ogTitleMax": 1,
            "ogTitleMaxVal": 95,
            "ogTitleMin": 1,
            "ogTitleMinVal": 40,
            "ogTitleEqualTitle": 0,
            "ogTitleCasingSentence": 0,
            "ogTitleCasingCamel": 1,
            "ogTitleCasingBoth": 0,

            "isOgDesc": 1,
            "OgDescMax": 1,
            "OgDescMaxVal": 200,
            "OgDescMin": 1,
            "OgDescMinVal": 40,
            "ogDescEqualDesc": 0,


            "isOgImage": 1,
            "ogImageDimensionsLeast": 0,
            "ogImageDimensionsLeastWidth": 0,
            "ogImageDimensionsLeastHeight": 0,
            "ogImageDimensionsExact": 1,
            "ogImageDimensionsExactWidth": 1200,
            "ogImageDimensionsExactHeight": 630,

        
            "isOgUrl": 10,
            "ogUrlEqualUrl": 0,
            "ogUrlMax": 10,
            "ogUrlMaxVal": 60,

            "isTwitterTitle": 1,
            "twitterTitleLengthMax": 1,
            "twitterTitleLengthMaxVal": 170,
            "twitterTitleLengthMin": 0,
            "twitterTitleLengthMinVal": "",
            "twitterTitleEqualTitle": 0,
            "twitterTitleCasingSentence": 0,
            "twitterTitleCasingCamel": 1,
            "twitterTitleCasingBoth": 0,


            "isTwitterImage": 1,
            "twitterImageDimensionsMin": 0,
            "twitterImageWidthMin": 0,
            "twitterImageHeightMin": 0,
            "twitterImageDimensionsExact": 1,
            "twitterImageWidthExact": 1200,
            "twitterImageHeightExact": 675,


            "isTwitterImageAlt": 1,
            "twitterImageAltMax": 1,
            "twitterImageAltMaxVal": 400,

            "isFavicon": 1,
            "faviconDimensionsMin": 0,
            "faviconWidthMin": 0,
            "faviconHeightMin": 0,
            "faviconDimensionsExact": 0,
            "faviconWidthExact": 0,
            "faviconHeightExact": 0,


            "isXmlSitemap": 1,
            "isSchemaTest": 0,
            "isSchemaTestCustom": 1,
            "schemaVal": "",
            "isXmlSitemapCustom": 1,
            "xmlSitemapVal": `${project.homepage}/xml.sitemap`,

            "isHtmlSitemap": 0,
            "isHtmlSitemapCustom": 1,
            "htmlSitemapVal": `${project.homepage}/sitemap`,

            "isMetaViewport": 1,

            "isFrameset": 1,

            "isDoctype": 1,

            "isHSTS": 1,

            "pageSize": 1,
            "pageSizeVal": 100,

            "noNestedTables": 1,

            "IsContentSecurityPolicyHeader": 1,

            "IsXFrameOptionsHeader": 1,

            "isBadContentType": 1,

            "isSSLCertificateEnableType": 1,

            "isFolderBrowsingEnable": 1,
            
            "isCssCachingEnable": 1,

            "isJsCachingEnable": 1,

            "isMobileFriendly": 1,

            "isSafeBrowsingEnable": 1,

            "isCrossOriginLinksEnable": 1,

            "isBrokenLinksEnable": 1,

            "isProtocolRelativeResourceEnable": 1,

            "isRobotTextTestBlockUrlEnable": 1,

            "isH1HeadingTagEnable": 1,
            "h1HeadingTagLength": 1,
            "h1HeadingTagLengthVal": 1,
            "h2HeadingTagLength": 0,
            "h2HeadingTagLengthVal": 1,
            "h3HeadingTagLength": 0,
            "h3HeadingTagLengthVal": 1,
            "h4HeadingTagLength": 0,
            "h4HeadingTagLengthVal": 1,
            "h5HeadingTagLength": 0,
            "h5HeadingTagLengthVal": 1,
            "h6HeadingTagLength": 0,
            "h6HeadingTagLengthVal": 1,

            "ProtocolRelativeResource": 1,

            "h1HeadingTagLength": 1,
            "h1HeadingTagLengthVal": 1,
            "h2HeadingTagLength": 0,
            "h2HeadingTagLengthVal": 1,
            "h3HeadingTagLength": 0,
            "h3HeadingTagLengthVal": 1,
            "h4HeadingTagLength": 0,
            "h4HeadingTagLengthVal": 1,
            "h5HeadingTagLength": 0,
            "h5HeadingTagLengthVal": 1,
            "h6HeadingTagLength": 0,
            "h6HeadingTagLengthVal": 1,


            "maximumFileSize": 1,
            "maximumFileSizeVal": 150,
            "imageNameHyphen": 1,
            "imageNameUppercase": 1,
            "imageNameSpecial": 1,
            "imageNameLength": 1,
            "imageNameLengthVal": 50,
            "imageAlt": 1,
            "imageAltSpaces": 1,

            "htmlCompression": 1,

            "cssCompression": 1,

            "jsCompression": 1,

            "gzipCompression": 1,
            
            "googleInsightsDesktop": 1,
            "googleInsightsDesktopVal": 90,
            "googleInsightsMobile": 1,
            "googleInsightsMobileVal": 90,

            "googlePerformanceDesktop": 1,
            "googlePerformanceDesktopVal": 90,
            "googlePerformanceMobile": 1,
            "googlePerformanceMobileVal": 90,
            "googleAccessibilityDesktop": 1,
            "googleAccessibilityDesktopVal": 90,
            "googleAccessibilityMobile": 1,
            "googleAccessibilityMobileVal": 90,
            "googleBestPracticesDesktop": 1,
            "googleBestPracticesDesktopVal": 90,
            "googleBestPracticesMobile": 1,
            "googleBestPracticesMobileVal": 90,
            "googleSeoDesktop": 1,
            "googleSeoDesktopVal": 90,
            "googleSeoMobile": 1,
            "googleSeoMobileVal": 90,

            "googleLCPDesktop": 1,
            "googleLCPDesktopVal": 2.5,
            "googleLCPMobile": 1,
            "googleLCPMobileVal": 2.5,
            "googleFCPDesktop": 1,
            "googleFCPDesktopVal": 2,
            "googleFCPMobile": 1,
            "googleFCPMobileVal": 2,
            "googleCLSDesktop": 1,
            "googleCLSDesktopVal": .1,
            "googleCLSMobile": 1,
            "googleCLSMobileVal": .1,
            "googleFIDDesktop": 1,
            "googleFIDDesktopVal": 100,
            "googleFIDMobile": 1,
            "googleFIDMobileVal": 100,
            "googleTBTDesktop": 1,
            "googleTBTDesktopVal": 300,
            "googleTBTMobile": 1,
            "googleTBTMobileVal": 300,
            "googleTTIDesktop": 1,
            "googleTTIDesktopVal": 4,
            "googleTTIMobile": 1,
            "googleTTIMobileVal": 4,
            "googleSIDesktop": 1,
            "googleSIDesktopVal": 4,
            "googleSIMobile": 1,
            "googleSIMobileVal": 4,
        }

    $(".reset-default").on("click", function(e){
        let obj = getAllValues(".setting-content-area")
        switch(e.target.id){
            case "defaultSettingsMetaTitle":
                for (const prop in defaultMetaTitle) {
                    obj[prop] = defaultMetaTitle[prop]
                    updateValues(defaultMetaTitle, prop)
                }
                break;
            case "defaultSettingsMetaDesc":
                for (const prop in defaultMetaDesc) {
                    obj[prop] = defaultMetaDesc[prop]
                    updateValues(defaultMetaDesc, prop)
                }
                break;
            case "defaultSettingsRobotsMeta":
                for (const prop in defaultRobotsMeta) {
                    obj[prop] = defaultRobotsMeta[prop]
                    updateValues(defaultRobotsMeta, prop)
                }
                break;
            case "defaultSettingsCanonical":
                for (const prop in defaultCanonical) {
                    obj[prop] = defaultCanonical[prop]
                    updateValues(defaultCanonical, prop)
                }
                break;
            case "defaultSettingsUrl":
                for (const prop in defaultURL) {
                    obj[prop] = defaultURL[prop]
                    updateValues(defaultURL, prop)
                }
                break;
            case "defaultSettingsOGTitle":
                for (const prop in defaultOGTitle) {
                    obj[prop] = defaultOGTitle[prop]
                    updateValues(defaultOGTitle, prop)
                }
                break;
            case "defaultSettingsOGDesc":
                for (const prop in defaultOGDesc) {
                    obj[prop] = defaultOGDesc[prop]
                    updateValues(defaultOGDesc, prop)
                }
                break;
            case "defaultSettingsOGImage":
                for (const prop in defaultOGImage) {
                    obj[prop] = defaultOGImage[prop]
                    updateValues(defaultOGImage, prop)
                }
                break;
            case "defaultSettingsOGUrl":
                for (const prop in defaultOGUrl) {
                    obj[prop] = defaultOGUrl[prop]
                    updateValues(defaultOGUrl, prop)
                }
                break;
            case "defaultSettingsTwitterTitle":
                for (const prop in defaultTwitterTitle) {
                    obj[prop] = defaultTwitterTitle[prop]
                    updateValues(defaultTwitterTitle, prop)
                }
                break;
            case "defaultSettingsTwitterImage":
                for (const prop in defaultTwitterImage) {
                    obj[prop] = defaultTwitterImage[prop]
                    updateValues(defaultTwitterImage, prop)
                }
                break;
            case "defaultSettingsTwitterImageAlt":
                for (const prop in defaultTwitterImageAlt) {
                    obj[prop] = defaultTwitterImageAlt[prop]
                    updateValues(defaultTwitterImageAlt, prop)
                }
                break;
            case "defaultSettingsFavicon":
                for (const prop in defaultFavicon) {
                    obj[prop] = defaultFavicon[prop]
                    updateValues(defaultFavicon, prop)
                }
                break;
            case "defaultSettingsXML":
                for (const prop in defaultXMLSitemap) {
                    obj[prop] = defaultXMLSitemap[prop]
                    updateValues(defaultXMLSitemap, prop)
                }
                break;
            case "defaultSettingsSchema":
                for (const prop in defaultSchema) {
                    obj[prop] = defaultSchema[prop]
                    updateValues(defaultSchema, prop)
                }
                break;
            case "defaultSettingsHTML":
                for (const prop in defaultHTMLSitemap) {
                    obj[prop] = defaultHTMLSitemap[prop]
                    updateValues(defaultHTMLSitemap, prop)
                }
                break;
            case "defaultSettingsViewport":
                for (const prop in defaultViewport) {
                    obj[prop] = defaultViewport[prop]
                    updateValues(defaultViewport, prop)
                }
                break;
            case "defaultSettingsFrameset":
                for (const prop in defaultFrameset) {
                    obj[prop] = defaultFrameset[prop]
                    updateValues(defaultFrameset, prop)
                }
                break;
            case "defaultSettingsDoctype":
                for (const prop in defaultDoctype) {
                    obj[prop] = defaultDoctype[prop]
                    updateValues(defaultDoctype, prop)
                }
                break;
            case "defaultSettingsHSTS":
                for (const prop in defaultHSTS) {
                    obj[prop] = defaultHSTS[prop]
                    updateValues(defaultHSTS, prop)
                }
                break;
            case "defaultSettingsPageSize":
                for (const prop in defaultPageSize) {
                    obj[prop] = defaultPageSize[prop]
                    updateValues(defaultPageSize, prop)
                }
                break;
            case "defaultSettingsNestedTables":
                for (const prop in defaultNestedTables) {
                    obj[prop] = defaultNestedTables[prop]
                    updateValues(defaultNestedTables, prop)
                }
                break;

            case "defaultSettingsContentSecurityPolicyHeader":
                for (const prop in defaultContentSecurityPolicyHeader) {
                    obj[prop] = defaultContentSecurityPolicyHeader[prop]
                    updateValues(defaultContentSecurityPolicyHeader, prop)
                }
                break;

            case "defaultSettingsXframeOptionsHeader":
                for (const prop in defaultXframeOptionsHeader) {
                    obj[prop] = defaultXframeOptionsHeader[prop]
                    updateValues(defaultXframeOptionsHeader, prop)
                }
                break;
            case "defaultSettingsIsBadContentType":
                for (const prop in defaultBadContentHeader) {
                    obj[prop] = defaultBadContentHeader[prop]
                    updateValues(defaultBadContentHeader, prop)
                }
                break;  
            
            case "defaultSettingsIsSSLCertificate":
                for (const prop in defaultSSLCertificate) {
                    obj[prop] = defaultSSLCertificate[prop]
                    updateValues(defaultSSLCertificate, prop)
                }
                break;
            
            case "defaultisFolderBrowsingEnable":
                for (const prop in defaultisFolderBrowsingEnable) {
                    obj[prop] = defaultisFolderBrowsingEnable[prop]
                    updateValues(defaultisFolderBrowsingEnable, prop)
                }
                break;
            case "defaultisCssCachingEnable":
                for (const prop in defaultisCssCachingEnable) {
                    obj[prop] = defaultisCssCachingEnable[prop]
                    updateValues(defaultisCssCachingEnable, prop)
                }
                break;  
            case "defaultisJsCachingEnable":
                for (const prop in defaultisJsCachingEnable) {
                    obj[prop] = defaultisJsCachingEnable[prop]
                    updateValues(defaultisJsCachingEnable, prop)
                }
                break; 
            case "defaultisSafeBrowsingEnable":
                for (const prop in defaultisSafeBrowsing) {
                    obj[prop] = defaultisSafeBrowsing[prop]
                    updateValues(defaultisSafeBrowsing, prop)
                }
                break;         
            case "defaultCrossOriginLinksEnable":
                  for (const prop in defaultCrossOriginLinks) {
                      obj[prop] = defaultCrossOriginLinks[prop]
                      updateValues(defaultCrossOriginLinks, prop)
                  }
                  break; 
            case "defaultBrokenLinksEnable":
                  for (const prop in defaultBrokenLinks) {
                      obj[prop] = defaultBrokenLinks[prop]
                      updateValues(defaultBrokenLinks, prop)
                  }
                  break;       
            case "defaultProtocolRelativeResourceEnable":
                  for (const prop in defaultProtocolRelativeResource) {
                      obj[prop] = defaultProtocolRelativeResource[prop]
                      updateValues(defaultProtocolRelativeResource, prop)
                  }
                  break;
          case "defaultRobotTextEnable":
                  for (const prop in defaultRobotText) {
                      obj[prop] = defaultRobotText[prop]
                      updateValues(defaultRobotText, prop)
                  }
                  break;      
            case "defaultH1HeadingTagEnable":
                  for (const prop in defaultH1HeadingTag) {
                      obj[prop] = defaultH1HeadingTag[prop]
                      updateValues(defaultH1HeadingTag, prop)
                  }
                  break;     
            case "defaultSettingsImages":
                for (const prop in defaultImages) {
                    obj[prop] = defaultImages[prop]
                    updateValues(defaultImages, prop)
                }
                break;
            case "defaultSettingsHTMLCompression":
                for (const prop in defaultHTMLCompression) {
                    obj[prop] = defaultHTMLCompression[prop]
                    updateValues(defaultHTMLCompression, prop)
                }
                break;
            case "defaultSettingsCSSCompression":
                for (const prop in defaultCSSCompression) {
                    obj[prop] = defaultCSSCompression[prop]
                    updateValues(defaultCSSCompression, prop)
                }
                break;
            case "defaultSettingsJSCompression":
                for (const prop in defaultJSCompression) {
                    obj[prop] = defaultJSCompression[prop]
                    updateValues(defaultJSCompression, prop)
                }
                break;
            case "defaultSettingsGZIPCompression":
                for (const prop in defaultGZIPCompression) {
                    obj[prop] = defaultGZIPCompression[prop]
                    updateValues(defaultGZIPCompression, prop)
                }
                break;
            case "defaultSettingsGoogleInsights":
                for (const prop in defaultGoogleOverall) {
                    obj[prop] = defaultGoogleOverall[prop]
                    updateValues(defaultGoogleOverall, prop)
                }
                break;
            case "defaultSettingsGoogleLighthouse":
                for (const prop in defaultGoogleLighthouse) {
                    obj[prop] = defaultGoogleLighthouse[prop]
                    updateValues(defaultGoogleLighthouse, prop)
                }
                break;
            case "defaultSettingsCoreWebVitals":
                for (const prop in defaultCoreWebVitals) {
                    obj[prop] = defaultCoreWebVitals[prop]
                    updateValues(defaultCoreWebVitals, prop)
                }
                break;
            default:
                for (const prop in defaultSettings) {
                    obj[prop] = defaultSettings[prop]
                    updateValues(defaultSettings, prop)
                }
                break;
        }
        clearAlerts()
        saveAjax(defaultSettings)

        e.preventDefault()
    })

    
  $("#saveSettings").on( "click", async function() {
      clearAlerts()
      const obj = getAllValues(".setting-content-area")
      // Include report settings in the data object
      obj.reportSettings = getReportSettings()

      // Schema validations when custom pages selected — collect errors instead of failing fast
      const clientErrors = [];
      // clear previous schema field error UI (textarea + label)
      $("#schemaVal").removeClass('is-invalid');
      $("#schemaVal").next('.invalid-feedback').remove();
      $("#schemaVal").closest('.form-group').find('label[for=\"schemaVal\"]').removeClass('text-danger');

      try {
        const isCustom = obj["isSchemaTestCustom"] == 1 || obj["isSchemaTestCustom"] === true || obj["isSchemaTestCustom"] === "1";
        if(isCustom){
          let val = obj["schemaVal"] || "";
          // Normalize into array: split on newline and commas as safety, trim, filter empties
          let lines = val.split(/\r?\n/).map(l => l.trim()).filter(l => l);
          // Ensure no line contains more than one URL (comma or multiple http occurrences)
          const multiPerLine = lines.filter(l => (l.match(/https?:\/\//g) || []).length > 1 || l.includes(','));
          if(multiPerLine.length > 0){
            clientErrors.push("Please put only one URL per line for Schema list.");
          }
          // Remove duplicates preserving order
          const seen = new Set();
          lines = lines.filter(x => {
            const k = x;
            if(seen.has(k)) return false;
            seen.add(k);
            return true;
          });

          if(lines.length === 0){
            clientErrors.push("Please enter at least one URL when 'Only specific pages' is selected for Schema.");
          }

          // Domain validation (normalize hosts to accept www and non-www)
          let rootDomain = project.homepage;
          if (rootDomain) {
            try {
              rootDomain = new URL(rootDomain).host;
            } catch (e) {
              rootDomain = rootDomain.replace(/^https?:\/\//, '').replace(/\/$/, '').split('/')[0];
            }
            const normalizeHost = (h) => (h || '').replace(/^www\./i, '').toLowerCase();
            let invalidUrls = [];
            lines.forEach(function(url) {
              if (url) {
                let urlHost = '';
                try {
                  urlHost = new URL(url).host;
                } catch (e) {
                  urlHost = url.replace(/^https?:\/\//, '').replace(/\/$/, '').split('/')[0];
                }
                if (normalizeHost(urlHost) !== normalizeHost(rootDomain)) {
                  invalidUrls.push(url);
                }
              }
            });
            if (invalidUrls.length > 0) {
              clientErrors.push(`The following Schema URLs do not match the project domain (${rootDomain}): ${invalidUrls.join(', ')}`);
            }
          }

          // Check all URLs in a single request to the server endpoint /check-simple-urls
          let results = [];
          try {
            const resp = await $.ajax({
              url: '/check-simple-urls',
              method: 'POST',
              data: { urls: lines, _token: $('meta[name="csrf-token"]').attr('content') }
            });
            results = resp.results || [];
          } catch (err) {
            clientErrors.push("Error validating one or more Schema URLs. Please try again.");
          }

          const badUrls = results.filter(r => !r || !r.valid).map(r => r && r.url ? r.url : '');
          if (badUrls.length > 0) {
            clientErrors.push(`The following Schema URLs are not reachable or returned non-200 responses: ${badUrls.join(', ')}`);
          }

          // If any client errors: store for merge with server errors; highlight schema; still call saveAjax so all errors show together
          if(clientErrors.length > 0){
            window._clientValidationErrors = clientErrors.slice();
            $("#schemaVal").addClass('is-invalid');
            $("#schemaVal").closest('.form-group').find('label[for=\"schemaVal\"]').addClass('text-danger');
            const firstErr = clientErrors[0];
            if($("#schemaVal").next('.invalid-feedback').length === 0){
              $("#schemaVal").after(`<div class="invalid-feedback" style="display:block;">${firstErr}</div>`);
            } else {
              $("#schemaVal").next('.invalid-feedback').html(firstErr).show();
            }
            const accorItem = $("#schemaVal").closest('.accor-single-item');
            if(accorItem.length){
              accorItem.css({ 'border': '1px solid red', 'border-radius': '4px' });
              accorItem.find('.accor-head .accor-title-btn span').css({ 'color': 'rgba(194, 40, 44, 1)' });
            }
          } else {
            window._clientValidationErrors = [];
          }

          obj["schemaVal"] = lines.join(',');
          $("#schemaVal").val(lines.join('\n'));
        }
      } catch (e) {
        displayAlertNoHide(".setting-alert-area", { status: 0, msg: "Unexpected error validating Schema URLs."});
        return;
      }

      if(!window._clientValidationErrors) window._clientValidationErrors = [];
      saveAjax(obj)
  });


  function updateValues(obj, prop){
        const el = document.getElementById(prop)
        el.value = obj[prop]
        if($(el).attr("type") === "checkbox"){
            el.checked = obj[prop]
        }
        if(el.classList.contains("switch-custom")){
            el.parentElement.nextElementSibling.innerHTML = obj[prop] == 1 ? "ON" : "OFF"
        }
    }


function saveAjax(obj){
        $.ajax({
            url : `/settings/${settings.id}`,
            type : 'PUT',
            data: {
                "data": obj,
                "_method": 'PUT',
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },       
            success : function(data) {
                const clientErrs = Array.isArray(window._clientValidationErrors) ? window._clientValidationErrors : [];
                let alertData = data;

                if(data.status === 0 || (data.status === 1 && clientErrs.length > 0)){
                    if(data.status === 0) validate(data);
                    const errors = [];
                    clientErrs.forEach(m => errors.push(m));
                    if(data.status === 0 && data.msg){
                        for(const key in data.msg){
                            const messages = data.msg[key];
                            if(Array.isArray(messages)){
                                messages.forEach(m=>errors.push(m));
                            }else if(typeof messages === 'string'){
                                errors.push(messages);
                            }
                        }
                    }
                    const seen = new Set();
                    const deduped = [];
                    errors.forEach(m => {
                        if(!m) return;
                        const normalized = String(m).trim();
                        if(!seen.has(normalized)){
                            seen.add(normalized);
                            deduped.push(normalized);
                        }
                    });
                    const listMsg = deduped.length > 1
                        ? `Please fix the following errors before saving the settings:<div style="padding-top: 10px;">${deduped.map((m,i)=>`<div style="padding-bottom: 5px;">${i+1}. ${m}</div>`).join('')}</div>`
                        : (deduped.length === 1 ? deduped[0] : "There were some errors, please fix them before saving.");
                    alertData = { status: 0, msg: listMsg };

                    if(clientErrs.length > 0){
                        $("#schemaVal").addClass('is-invalid');
                        $("#schemaVal").closest('.form-group').find('label[for=\"schemaVal\"]').addClass('text-danger');
                        if($("#schemaVal").next('.invalid-feedback').length === 0){
                            $("#schemaVal").after(`<div class="invalid-feedback" style="display:block;">${clientErrs[0]}</div>`);
                        } else {
                            $("#schemaVal").next('.invalid-feedback').html(clientErrs[0]).show();
                        }
                        const accorItem = $("#schemaVal").closest('.accor-single-item');
                        if(accorItem.length > 0){
                            accorItem.css({ 'border': '1px solid red', 'border-radius': '4px' });
                            accorItem.find('.accor-head .accor-title-btn span').css({'color': 'rgba(194, 40, 44, 1)'});
                        }
                    }
                    window._clientValidationErrors = [];
                }
                displayAlertNoHide(".setting-alert-area", alertData);
                scrollToTop();
            },
            error: function(data){
                if(!checkIfAuthenticated(data.responseJSON)){
                    window.location = "/login"
                }
            }
        });
    }

    function getReportSettings() {
        // Collect all report settings checkbox values
        const reportSettings = {};
        
        // Collect all report checkbox values (only those with "Report" suffix in ID)
        const reportCheckboxes = document.querySelectorAll('#v-pills-reports input[type="checkbox"][id$="Report"]');
        reportCheckboxes.forEach(checkbox => {
            // Map checkbox ID to database field name
            let fieldName = checkbox.id.replace('switch', '').replace('Report', '');
            
            // Convert camelCase to snake_case for database fields
            fieldName = fieldName.replace(/([A-Z])/g, '_$1').toLowerCase();
            if (fieldName.startsWith('_')) {
                fieldName = fieldName.substring(1);
            }
            
            // Special cases for field name mapping
            const fieldMapping = {
                'meta_title': 'meta_title',
                'meta_desc': 'meta_desc',
                'robots_meta': 'robots_meta',
                'canonical_url': 'canonical_url',
                'images': 'images',
                'url_slug': 'url_slug',
                'robot_text_test': 'robot_text_test',
                'h1_heading_tag': 'h1_heading_tag',
                'xml_sitemap': 'xml_sitemap',
                'open_graph_tags': 'open_graph_tags',
                'twitter_tags': 'twitter_tags',
                'favicon': 'favicon',
                'meta_viewport': 'meta_viewport',
                'doctype': 'doctype',
                'http_status_code': 'http_status_code',
                'google_overall': 'google_overall',
                'google_lighthouse': 'google_lighthouse',
                'core_web_vitals': 'core_web_vitals',
                'mobile_friendly': 'mobile_friendly',
                'html_compression': 'html_compression',
                'css_compression': 'css_compression',
                'js_compression': 'js_compression',
                'gzip_compression': 'gzip_compression',
                'css_caching': 'css_caching_enable',
                'js_caching': 'js_caching_enable',
                'page_size': 'page_size',
                'nested_tables': 'nested_tables',
                'frameset': 'frameset',
                'broken_links': 'broken_links',
                'safe_browsing': 'is_safe_browsing',
                'cross_origin_links': 'cross_origin_links',
                'protocol_relative_resource': 'protocol_relative_resource',
                'content_security_policy': 'content_security_policy_header',
                'x_frame_options': 'x_frame_options_header',
                'hsts_header': 'hsts_header',
                'bad_content_type': 'bad_content_type',
                'ssl_certificate': 'ssl_certificate_enable',
                'folder_browsing': 'folder_browsing_enable'
            };
            
            const dbFieldName = fieldMapping[fieldName] || fieldName;
            reportSettings[dbFieldName] = checkbox.checked ? 1 : 0;
        });
        
        return reportSettings;
    }


  $(".hideInputCheck").each(function(el){
    toggleElement(this)
  })
  

  $(".hideInputCheck").on("change", function(){
    toggleElement(this)
  })

  $(".toggleCasingChecks").each(function(el){
    disableElement(this)
  })
  

  $(".toggleCasingChecks").on("change", function(){
    disableElement(this)
  })

  $(".casing-check-input").on("change", function(){
    updateCasingInput(this)
  })
  // Show/hide schema textarea based on radio selection
  $(".casing-check-input#isSchemaTestCustom, .casing-check-input#isSchemaTest").on("change", function(){
    const isCustom = document.getElementById('isSchemaTestCustom').checked;
    if(isCustom){
      $("#schemaVal").closest('.form-group').show();
    }else{
      $("#schemaVal").closest('.form-group').hide();
    }
  })
  // Ensure correct initial visibility on page load
  $(".casing-check-input#isSchemaTestCustom, .casing-check-input#isSchemaTest").trigger('change');
  // Initialize schema textarea line numbers (and again after layout so height is correct)
  updateSchemaNumbers();
  setTimeout(updateSchemaNumbers, 100);
  $(window).on('load', updateSchemaNumbers);

  $(".http-checkbox").on("change", function(){
    updateHTTPInput(this)
  })

  $(".add-more-sitemap").on("click", function(){
    addMoreSitemap(this)
  })

  // Initialize sitemap numbering when modal is shown
  $('#addSitemapModal').on('shown.bs.modal', function () {
    updateSitemapNumbers();
  });

  // Handle textarea input and Enter key for sitemap numbering
  $("#addSitemapVal").on('input keydown', function(e) {
    if (e.key === 'Enter') {
      // Allow the default behavior first
      setTimeout(() => {
        updateSitemapNumbers();
      }, 0);
    } else {
      // Update numbers on any input change
      updateSitemapNumbers();
    }
  });

  // Handle paste events
  $("#addSitemapVal").on('paste', function() {
    setTimeout(() => {
      updateSitemapNumbers();
    }, 0);
  });

  // Schema textarea handlers
  $("#schemaVal").on('input keydown', function(e) {
    if (e.key === 'Enter') {
      setTimeout(() => { updateSchemaNumbers(); }, 0);
    } else {
      updateSchemaNumbers();
    }
  });

  $("#schemaVal").on('paste', function() {
    setTimeout(() => { updateSchemaNumbers(); }, 0);
  });

  // Sync scroll for schema textarea (and keep numbers height in sync so they stay inside)
  $("#schemaVal").on('scroll', function() {
    const numbersDiv = document.getElementById('schemaNumbers');
    const ta = this;
    if (numbersDiv) {
      numbersDiv.style.height = ta.clientHeight + 'px';
      numbersDiv.scrollTop = ta.scrollTop;
    }
  });

  // Resize: keep schema numbers column height in sync with textarea
  var schemaTextareaEl = document.getElementById('schemaVal');
  if (schemaTextareaEl && window.ResizeObserver) {
    new ResizeObserver(function() {
      updateSchemaNumbers();
    }).observe(schemaTextareaEl);
  }

  // Sync scroll between textarea and numbers
  $("#addSitemapVal").on('scroll', function() {
    const numbersDiv = document.getElementById('sitemapNumbers');
    if (numbersDiv) {
      numbersDiv.scrollTop = this.scrollTop;
    }
  });

  // Broken Links Excluded Modal Event Handlers
  $(".add-more-broken-links-excluded").on("click", function(){
    addMoreBrokenLinksExcluded(this)
  })

  // Initialize broken links excluded numbering when modal is shown
  $('#addBrokenLinksExcludedModal').on('shown.bs.modal', function () {
    updateBrokenLinksExcludedNumbers();
  });

  // Handle textarea input and Enter key for broken links excluded numbering
  $("#addBrokenLinksExcludedVal").on('input keydown', function(e) {
    if (e.key === 'Enter') {
      // Allow the default behavior first
      setTimeout(() => {
        updateBrokenLinksExcludedNumbers();
      }, 0);
    } else {
      // Update numbers on any input change
      updateBrokenLinksExcludedNumbers();
    }
  });

  // Handle paste events for broken links excluded
  $("#addBrokenLinksExcludedVal").on('paste', function() {
    setTimeout(() => {
      updateBrokenLinksExcludedNumbers();
    }, 0);
  });

  // Sync scroll between textarea and numbers for broken links excluded
  $("#addBrokenLinksExcludedVal").on('scroll', function() {
    const numbersDiv = document.getElementById('brokenLinksExcludedNumbers');
    if (numbersDiv) {
      numbersDiv.scrollTop = this.scrollTop;
    }
  });

  $("#confirmAddSitemap").on("click", function(){
    clearAlerts()
    const val = $("#addSitemapVal").val();
    // Split, trim, filter, and remove duplicates
    let sitemapsArray = val
      .split('\n')
      .map(line => line.trim())
      .filter(line => line);
    sitemapsArray = Array.from(new Set(sitemapsArray));
    const lines = sitemapsArray.join(',');

    // --- DOMAIN VALIDATION ---
    let rootDomain = project.homepage;
    if (rootDomain) {
      try {
        rootDomain = new URL(rootDomain).host;
      } catch (e) {
        rootDomain = rootDomain.replace(/^https?:\/\//, '').replace(/\/$/, '').split('/')[0];
      }
      let invalidUrls = [];
      sitemapsArray.forEach(function(url) {
        if (url) {
          let urlHost = '';
          try {
            urlHost = new URL(url).host;
          } catch (e) {
            urlHost = url.replace(/^https?:\/\//, '').replace(/\/$/, '').split('/')[0];
          }
          if (urlHost !== rootDomain) {
            invalidUrls.push(url);
          }
        }
      });
      if (invalidUrls.length > 0) {
        let msg = `The following sitemap URLs do not match the root domain (${rootDomain}):<br>${invalidUrls.join('<br>')}`;
        alertData = {
            status: 0,
            msg: msg
        }
        displayAlertSimple(".modal-footer-alert", alertData)
        return false;
      }
    }
    // --- END DOMAIN VALIDATION ---

    if(validateAddSitemap(val)){
      checkSitemapUrls(sitemapsArray).then(results => {
        const failedUrls = results
          .filter(result => !result.valid)
          .map(result => result.url);

        if(failedUrls.length > 0) {
          msg = `The following sitemap URLs are not valid:\n${failedUrls.join(', ')}`
          alertData = {
              status: 0,
              msg: msg
          }
          displayAlertSimple(".modal-footer-alert", alertData)
          return false
        }else {
          saveSitemap(lines)
            .done(function(data){
              if(data.status === 1){
                addSitemapModal.toggle()
                const alert = new Toast("XML Sitemap updated succesfully. Refresh the page to take effect");
                alert.display()
                // Update textarea with only unique URLs (one per line)
                $("#addSitemapVal").val(sitemapsArray.join('\n'));
              }
          });
        }
      });
    }
  })

  $("#confirmAddBrokenLinksExcluded").on("click", function(){
    clearAlerts()
    const val = $("#addBrokenLinksExcludedVal").val();
    // Split, trim, filter, and remove duplicates
    let excludedUrlsArray = val
      .split('\n')
      .map(line => line.trim())
      .filter(line => line);
    excludedUrlsArray = Array.from(new Set(excludedUrlsArray));
    const lines = excludedUrlsArray.join(',');

    if(validateAddBrokenLinksExcluded(val)){
      saveBrokenLinksExcluded(lines)
        .done(function(data){
          if(data.status === 1){
            addBrokenLinksExcludedModal.toggle()
            const alert = new Toast("Excluded URLs updated successfully.");
            alert.display()
            // Update textarea with only unique URLs (one per line)
            $("#addBrokenLinksExcludedVal").val(excludedUrlsArray.join('\n'));
            // Update preview
            updateBrokenLinksExcludedPreview(excludedUrlsArray);
          }
      });
    }
  })


  function saveSitemap(val){
    return $.ajax({
          url : `/settings/save-sitemap/${settings.id}`,
          type : 'put',
          aysnc: false,
          data: {
              "_token": $('meta[name="csrf-token"]').attr('content'), 
              "sitemapString": val,
          },       
          success: function(data) {
            
          },error: function(data){
          }
    });
  }


  function validateAddSitemap(sitemapString){
    clearAlerts()
    let msg
    if(sitemapString === ""){
      msg = "Please enter at least one sitemap"
      alertData = {
          status: 0,
          msg: msg
      }
      displayAlertSimple(".modal-footer-alert", alertData)
      return false

    }else{
      return true
    }

  }


  function addMoreSitemap(element){
    addSitemapModal.toggle()
  }

  function updateSitemapNumbers() {
    const textarea = document.getElementById('addSitemapVal');
    const numbersDiv = document.getElementById('sitemapNumbers');
    
    if (!textarea || !numbersDiv) return;
    
    const lines = textarea.value.split('\n');
    const lineCount = lines.length;
    
    // Generate numbers for each line
    let numbersText = '';
    for (let i = 1; i <= lineCount; i++) {
      numbersText += i + '\n';
    }
    
    // Update the numbers display
    numbersDiv.textContent = numbersText;
    
    // Sync scroll position
    numbersDiv.scrollTop = textarea.scrollTop;
  }

  function updateBrokenLinksExcludedNumbers() {
    const textarea = document.getElementById('addBrokenLinksExcludedVal');
    const numbersDiv = document.getElementById('brokenLinksExcludedNumbers');
    
    if (!textarea || !numbersDiv) return;
    
    const lines = textarea.value.split('\n');
    const lineCount = lines.length;
    
    // Generate numbers for each line
    let numbersText = '';
    for (let i = 1; i <= lineCount; i++) {
      numbersText += i + ". " + '\n';
    }
    
    // Update the numbers display
    numbersDiv.textContent = numbersText;
    
    // Sync scroll position
    numbersDiv.scrollTop = textarea.scrollTop;
  }

  // Schema textarea line numbers – fixed line-height so numbers and URLs align
  function updateSchemaNumbers() {
    const textarea = document.getElementById('schemaVal');
    const numbersDiv = document.getElementById('schemaNumbers');
    
    if (!textarea || !numbersDiv) return;
    
    numbersDiv.style.height = textarea.clientHeight + 'px';
    numbersDiv.style.overflow = 'hidden';
    
    const lineCount = Math.max(1, textarea.value.split('\n').length);
    let html = '';
    for (let i = 1; i <= lineCount; i++) {
      html += '<div>' + i + '.</div>';
    }
    numbersDiv.innerHTML = html;
    numbersDiv.scrollTop = textarea.scrollTop;
    
    // Use same values as CSS so each number line lines up with one textarea line
    numbersDiv.style.fontSize = '14px';
    numbersDiv.style.lineHeight = '21px';
    numbersDiv.style.paddingTop = '17px';
    numbersDiv.style.paddingBottom = '10px';
  }

  function addMoreBrokenLinksExcluded(element){
    addBrokenLinksExcludedModal.toggle()
  }

  function updateBrokenLinksExcludedPreview(urls) {
    // const previewDiv = document.getElementById('brokenLinksExcludedPreview');
    // if (!previewDiv) return;
    
    // if (urls.length === 0) {
    //   previewDiv.innerHTML = '<small class="text-muted">No excluded URLs added yet.</small>';
    // } else {
    //   let previewHtml = '<small class="text-muted">Excluded URLs (' + urls.length + '):</small><br>';
    //   urls.forEach((url, index) => {
    //     previewHtml += '<small class="text-muted">' + (index + 1) + '. ' + url + '</small><br>';
    //   });
    //   previewDiv.innerHTML = previewHtml;
    // }
  }

  function validateAddBrokenLinksExcluded(excludedUrlsString){
    clearAlerts()
    let msg
    if(excludedUrlsString === ""){
      msg = "Please enter at least one URL to exclude"
      alertData = {
          status: 0,
          msg: msg
      }
      displayAlertSimple(".modal-footer-alert", alertData)
      return false
    }else{
      return true
    }
  }

  function saveBrokenLinksExcluded(val){
    return $.ajax({
          url : `/settings/save-broken-links-excluded/${settings.id}`,
          type : 'put',
          aysnc: false,
          data: {
              "_token": $('meta[name="csrf-token"]').attr('content'), 
              "excludedUrlsString": val,
          },       
          success: function(data) {
            
          },error: function(data){
          }
    });
  }

  

  function updateHTTPInput(){
    let val = ""
    $(".http-checkbox").each(function(el){
      if(this.checked){
        val+=this.value + ","
      }
    })

    val = val.substring(0, val.length - 1);

    $("#http_status_code_accepted").val(val)
  }

  function initCasingInput(){
    $(".casing-check-input").each(function(el){
      if(this.checked){
        $(this).prop( "value", 1 );
      }else{
        $(this).prop( "value", 0 );
      }
    })
  }


  function updateCasingInput(element){
    const inputs = $(element).parent().parent()[0].querySelectorAll(".casing-check-input")

    $(inputs).each(function(el){
      $(this).prop( "value", 0 );
    })
    $(element).prop( "value", 1 );

  }

  function toggleElement(element){
    const inputElement = $(element).parent().next()

    if(element.checked){
      inputElement.css("display", "block")
    }else{
      inputElement.css("display", "none")
    }
  }

  function disableElement(element){
    const all = []
    const inputElement = $(element).parent().next().children().first()
    const inputElement1 = $(element).parent().next().next().children().first()
    const inputElement2 = $(element).parent().next().next().next().children().first()
    all.push(inputElement)
    all.push(inputElement1)
    all.push(inputElement2)


    $(all).each(function(el){
      if(element.checked){
        this.prop( "disabled", false );
      }else{
        this.prop( "disabled", true );
        this.prop( "value", 0 );
        this.prop( "checked", false );
      }
    })
  }


  document.addEventListener("DOMContentLoaded", (e)=>{
    initCasingInput()
  })
</script>
@endsection