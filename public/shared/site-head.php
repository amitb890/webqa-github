<?php
require_once __DIR__ . '/laravel-context.php';
webqa_boot_laravel_context();
?>
<link rel="icon" type="image/x-icon" href="<?php echo webqa_e(webqa_asset('new-assets/assets/images/favicon.ico')); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo webqa_e(webqa_asset('new-assets/assets/images/apple-icon-180x180.png')); ?>">
<link rel="icon" type="image/png" sizes="192x192" href="<?php echo webqa_e(webqa_asset('new-assets/assets/images/android-chrome-192x192.png')); ?>">
<link rel="stylesheet" href="<?php echo webqa_e(webqa_asset('new-assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo webqa_e(webqa_asset('new-assets/vendor/fontawesome/css/all.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo webqa_e(webqa_asset('new-assets/assets/fonts/font-styles.css')); ?>" />
<link rel="stylesheet" href="<?php echo webqa_e(webqa_asset('new-assets/css/main.css')); ?>" />
<link rel="stylesheet" href="<?php echo webqa_e(webqa_asset('new-assets/css/main.res.css')); ?>" />
<script>
(function () {
  var meta = document.querySelector('meta[name="csrf-token"]');
  if (meta && meta.getAttribute('content')) {
    return;
  }

  fetch('/auth/context', {
    credentials: 'same-origin',
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    if (!data) {
      return;
    }
    if (meta && data.csrf) {
      meta.setAttribute('content', data.csrf);
    }
    if (data.authenticated) {
      var area = document.querySelector('.login_area');
      if (area) {
        area.innerHTML = '<a href="/dashboard" class="btn btn_primary rounded-pill">Dashboard</a>';
      }
    }
  }).catch(function () {});
})();
</script>
