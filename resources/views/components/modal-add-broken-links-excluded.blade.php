<div class="modal fade" id="addBrokenLinksExcludedModal" aria-hidden="true" aria-labelledby="addBrokenLinksExcludedModalLabel"
      tabindex="-1">
    <div class="modal-dialog modal-dialog-centered analysis-profile-dialog">
    <div class="modal-content">
        <div class="modal-header analysis-profile-header">
        <h1 class="modal-title fs-5" id="addBrokenLinksExcludedModalLabel">
            Exclude URLs from Broken Links Check
        </h1>
        </div>
        <div class="modal-body">
            <?php
                      $cleaned = preg_replace('/\s+/', '', $settings->settingsSub->broken_links_excluded_urls);
                      $lines = explode(",", $cleaned);
                      $formatted = implode("\n", $lines);?>
            <div class="sitemap-container">
                <div class="sitemap-numbers" id="brokenLinksExcludedNumbers"></div>
                <textarea
                      class="sitemap-textarea"
                        placeholder="Enter each URL in a new line"
                        id="addBrokenLinksExcludedVal"
                        cols="30"
                        rows="10">{{ htmlspecialchars($formatted) }}</textarea>
            </div>

                    <div class="modal-footer-alert"></div>
        <div class="modal-footer">
        <button class="btn btn_primary rounded-pill" id="confirmAddBrokenLinksExcluded">
            Save
        </button>
        </div>
        </div>

    </div>
    </div>
</div>
