<!-- main sections starts -->
    <main class="main-sections blog-padding">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="blog-main-area single-post-main">
            <!-- post page blog start -->
            <div class="post-page-headline post-page-headline2">
              <div class="post-category">
                
              </div>
              <h1><?php the_title(); ?></h1>
              <div style="margin-top:30px;"><?php the_post_thumbnail( 'full' ); ?></div>
            </div>
            
            <div class="single-post-content single-post-content2"><?php the_content(); ?></div>

<?php get_template_part( 'nav', 'below' ); ?>



