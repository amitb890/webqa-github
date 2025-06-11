<?php get_header(); ?>

<main class="main-sections" style="padding-block: 58px;">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="getting_main_area">
			  <div class="getting-title">
              <h2>Getting Started</h2>
              <a href="https://webqa.co/support/" class="support_btn"> <img src="https://webqa.co/support/wp-content/themes/support/assets/images/home.png" alt="icon">Support Home</a>
            </div>
           <div class="support-link">
              <a href="https://webqa.co/support/"> <span>Support</span> <img src="https://webqa.co/support/wp-content/themes/support/assets/images/arrow.png" alt="icon"> </a>
              <a href=""> <span><?php
  foreach ( ( get_the_category() ) as $category ) {
    echo $category->cat_name . ' ';
  }
?></span>  </a>
              
            </div>
            <div class="single-getting-main">
            	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		              <div class="single-getting">
		                <div class="getting-left-content">
		                  <h4><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
		                  <p><?php the_excerpt(); ?></p>
		                </div>
		                <a href="<?php the_permalink();?>"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg><!-- <i class="fa-solid fa-angle-right"></i> Font Awesome fontawesome.com --></a>
		              </div>
              <?php endwhile; endif; ?>

              
           
            </div>
          </div>
          









<?php get_footer(); ?>





