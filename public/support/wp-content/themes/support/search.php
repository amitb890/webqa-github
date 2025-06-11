<?php get_header(); ?>
 <!-- main sections starts -->
    <main class="main-sections">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="support_main_area">
           

              

            
<?php if ( have_posts() ) : ?>

<p><?php printf( esc_html__( 'Search Results for: %s', 'blankslate' ), get_search_query() ); ?></p>

<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php endwhile; ?>

<?php else : ?>

<div align="center" style="min-height:360px;">
<h3><?php esc_html_e( 'Sorry, nothing matched your search. Please try again.', 'blankslate' ); ?></h3>
</div>
<?php endif; ?>
            
            
            
            
            
            
            
            
            
            
            
              
          
              

          </div>
<?php get_footer(); ?>