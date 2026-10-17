<?php
require_once dirname(__DIR__, 4) . '/shared/laravel-context.php';
webqa_boot_laravel_context();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="<?php echo webqa_e(webqa_csrf_token()); ?>">
<?php webqa_include_shared('site-head.php'); ?>
<?php wp_head(); ?>
</head>
<body class="body_padding">
<?php webqa_include_shared('site-header.php'); ?>

<div class="container-fluid">
  <section class="support_banner_area">
    <div class="support_banner_content">
      <h1>Hi, how can we help?</h1>
      <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
        <div class="suppor_search">
          <input type="search" placeholder="Search for articles ..." name="s">
        </div>
      </form>
    </div>
  </section>
</div>
