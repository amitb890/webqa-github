<!-- main sections starts -->
    <main class="main-sections blog-padding">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="blog-main-area single-post-main" style="border:none;padding-bottom:0px;">
            <!-- post page blog start -->
            <div class="post-page-headline post-page-headline2" style="padding-bottom:10px;">
              <div class="post-category">
                
              </div>
             
              <h1><a style="color: #000;text-decoration: none;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
              
              <div style="margin-top:20px;margin-bottom:20px;"><?php the_post_thumbnail( 'full' ); ?></div>
            </div>
            
            <div class="single-post-content single-post-content2">
                <?php
$content = get_the_content(); // Get the full post content
$character_limit = 300; // Set your desired character limit
$truncated_content = mb_strimwidth($content, 0, $character_limit, '...'); // Truncate and add ellipsis
echo $truncated_content;
?>
            </div>
            <div class="read-article-button" style="width: 10%;padding-top: 30px;margin-left: auto;margin-right: auto;"><a href="<?php the_permalink(); ?>" class="btn btn_primary rounded-pill">Read article</a></div>

<?php get_template_part( 'nav', 'below-index' ); ?>



