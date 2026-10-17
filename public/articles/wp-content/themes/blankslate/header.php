<?php
require_once dirname(__DIR__, 4) . '/shared/laravel-context.php';
webqa_boot_laravel_context();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="<?php echo webqa_e(webqa_csrf_token()); ?>">
<?php if (is_tag()) { ?>
<meta name="robots" content="noindex, follow">
<?php } ?>
<?php if ( is_front_page() || is_home() ) : ?>
<title>Webqa Blog - Articles on Website Improvement</title>
<?php else : ?>
<title><?php wp_title( '| Webqa', true, 'right' ); ?></title>
<?php endif; ?>
<meta name="description" content="<?php echo get_the_excerpt(); ?>" />
<link rel="canonical" href="<?php echo wp_get_canonical_url(); ?>" />

<meta property="og:title" content="<?php wp_title( '| Webqa', true, 'right' ); ?>"/>
<meta property="og:description" content="<?php echo get_the_excerpt(); ?>"/>
<meta property="og:url" content="<?php echo wp_get_canonical_url(); ?>"/>
<meta property="og:type" content="website">
<meta property="og:image" content="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" />

<meta property="twitter:title" content="<?php wp_title( '| Webqa', true, 'right' ); ?>"/>
<meta property="twitter:description" content="<?php echo get_the_excerpt(); ?>"/>
<meta property="twitter:url" content="<?php echo wp_get_canonical_url(); ?>"/>
<meta property="twitter:image" content="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>"/>
<meta property="twitter:card" content="summary_large_image"/>

<?php webqa_include_shared('site-head.php'); ?>
</head>

<body class="body_padding">
<?php include __DIR__ . '/top-navigation.php'; ?>
