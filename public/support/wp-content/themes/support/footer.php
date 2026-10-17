<div class="trial-area">
            <div class="trial-content">
              <h2>Wondering why your content isn't
                showing up on the SERPs?</h2>
                <?php if (function_exists('webqa_authenticated') && webqa_authenticated()) { ?>
                <a href="/dashboard" class="btn btn_primary rounded-pill">Dashboard</a>
                <?php } else { ?>
                <a type="button" class="btn btn_primary rounded-pill" data-bs-toggle="modal" data-bs-target="#registerModal">Start Free Trial</a>
                <?php } ?>
            </div>
          </div>

          
        </div>
      </div>
    </main>
    <!-- main sections ends -->
<?php
if (!function_exists('webqa_include_shared')) {
    require_once dirname(__DIR__, 4) . '/shared/laravel-context.php';
    webqa_boot_laravel_context();
}
webqa_include_shared('site-footer.php');
webqa_include_shared('auth-modals.php');
webqa_include_shared('site-scripts.php');
wp_footer();
?>
</body>
</html>