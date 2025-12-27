<div class="modal fade" id="addSitemapModal" aria-hidden="true" aria-labelledby="addSitemapModalLabel"
      tabindex="-1">
    <div class="modal-dialog modal-dialog-centered analysis-profile-dialog">
    <div class="modal-content modal-content-position">
        <div class="modal-header analysis-profile-header">
        <h1 class="modal-title fs-5" id="addSitemapModalLabel">
            Enter XML Sitemaps Imran
        </h1>
        </div>
        <div class="modal-body">
            <?php
                      $cleaned = preg_replace('/\s+/', '', $settings->settingsSub->xml_sitemap_val);
                      $lines = explode(",", $cleaned);
                      $formatted = implode("\n", $lines);?>
            <div class="sitemap-container">
                <div class="sitemap-numbers" id="sitemapNumbers"></div>
                <textarea
                      class="sitemap-textarea"
                        placeholder="Enter each url in a new line"
                        id="addSitemapVal"
                        cols="30"
                        rows="10">{{ htmlspecialchars($formatted) }}</textarea>
            </div>

                    <div class="modal-footer-alert"></div>
        <div class="modal-footer">
        <button class="btn btn_primary rounded-pill" id="confirmAddSitemap">
            Save
        </button>
        </div>
        </div>
        <div class="modal-content-cross" data-bs-dismiss="modal" role="button" aria-label="Close">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
            <line x1="5" y1="5" x2="19" y2="19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="19" y1="5" x2="5" y2="19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
    </div>
</div>