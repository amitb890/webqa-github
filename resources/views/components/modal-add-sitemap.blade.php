<div class="modal fade" id="addSitemapModal" aria-hidden="true" aria-labelledby="addSitemapModalLabel"
      tabindex="-1">
    <div class="modal-dialog modal-dialog-centered analysis-profile-dialog">
    <div class="modal-content">
        <div class="modal-header analysis-profile-header">
        <h1 class="modal-title fs-5" id="addSitemapModalLabel">
            Enter XML Sitemaps
        </h1>
        </div>
        <div class="modal-body">
            <?php
                      $cleaned = preg_replace('/\s+/', '', $settings->settingsSub->xml_sitemap_val);
                      $lines = explode(",", $cleaned);
                      $formatted = implode("\n", $lines);?>
            <textarea
                  class=""
                    placeholder="Enter each url in a new line"
                    id="addSitemapVal"
                    cols="30"
                    rows="10">{{ htmlspecialchars($formatted) }}</textarea>

                    <div class="modal-footer-alert"></div>
        <div class="modal-footer">
        <button class="btn btn_primary rounded-pill" id="confirmAddSitemap">
            Save
        </button>
        </div>
        </div>

    </div>
    </div>
</div>