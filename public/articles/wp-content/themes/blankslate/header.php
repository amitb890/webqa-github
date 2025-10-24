<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" type="image/x-icon" href="https://webqa.co/new-assets/assets/images/favicon.ico">
<?php if ( is_front_page() || is_home() ) : ?>
    <title>Webqa Blog - Articles on Website Improvement</title>
<?php else : ?>
    <title><?php wp_title( '| Webqa', true, 'right' ); ?></title>
<?php endif; ?>
<meta name="description" content="<?php echo get_the_excerpt(); ?>" />
<link rel="canonical" href="<?php echo wp_get_canonical_url(); ?>" />
	
<!-- bootstrap styles -->
<link rel="stylesheet" href="https://webqa.co/public/articles/wp-content/themes/theme-assets/bootstrap.min.css" />
<!-- custom styles -->
<link rel="stylesheet" href="https://webqa.co/public/articles/wp-content/themes/theme-assets/font-styles.css" />
<link rel="stylesheet" href="https://webqa.co/public/articles/wp-content/themes/theme-assets/main.css" />
<link rel="stylesheet" href="https://webqa.co/public/articles/wp-content/themes/theme-assets/main.res.css" />	
	
</head>

<body class="body_padding">
<?php include('top-navigation.php'); ?>


