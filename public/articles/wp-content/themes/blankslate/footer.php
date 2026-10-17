<?php
if (!function_exists('webqa_include_shared')) {
    require_once dirname(__DIR__, 4) . '/shared/laravel-context.php';
    webqa_boot_laravel_context();
}
webqa_include_shared('site-footer.php');
?>
<?php webqa_include_shared('auth-modals.php'); ?>
<?php webqa_include_shared('site-scripts.php'); ?>
</body>
</html>
