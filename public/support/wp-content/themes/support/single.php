<?php get_header(); ?>



<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <!-- main sections starts -->
    <main class="main-sections" style="padding-block: 58px;">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="getting_main_area">
           <?php include('wp-content/themes/support/breadcrumb.php');?>      
            <div class="getting-recover-bg">
              <div class="getting-recover-main">
                <div class="recover-title">
                  <h2 style="margin-bottom:65px;"><?php the_title(); ?></h2>
                </div>

				<?php the_content(); ?>
				<?php include('wp-content/themes/support/helpful.php');?>

<?php endwhile; endif; ?>
<?php get_footer(); ?>