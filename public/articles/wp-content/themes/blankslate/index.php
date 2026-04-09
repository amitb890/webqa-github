<?php
get_header();
?>



<div class="intro-text" style="text-align: center;">
    <!-- main sections starts -->
    <main class="main-sections blog-padding">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="blog-main-area">
            <!-- top highlight blog start -->



<?php

// === First Loop: Show Latest Post ===
$featured_query = new WP_Query( array(
    'posts_per_page' => 1,
    'ignore_sticky_posts' => 1
) );

$featured_id = 0;
if ( $featured_query->have_posts() ) :
    while ( $featured_query->have_posts() ) : $featured_query->the_post();
        $featured_id = get_the_ID(); ?>
        <div class="blog-highlight">
                 <?php if ( has_post_thumbnail() ) : ?>
                      <div class="featured-image" style="max-width: 700px; margin: 20px auto;">
                        <?php the_post_thumbnail('large', array('style' => 'width:100%; height:auto; border-radius:8px;')); ?>
                      </div>
              <?php endif; ?>
              <div class="highlight-content">
                  <?php
if ( has_tag() ) { // Check if the post has any tags
    echo '<div class="post-category"><ul>';
    
    // Output each tag as a list item with a link
    $post_tags = get_the_tags();
    if ( $post_tags ) {
        foreach ( $post_tags as $tag ) {
            $tag_link = get_tag_link( $tag->term_id );
            echo '<li><a href="' . esc_url( $tag_link ) . '">' . esc_html( $tag->name ) . '</a></li>';
        }
    }

    echo '</ul></div>';
}
?>

              
                <h3 style="text-align:left;"><a style="color:#000;font-size:30px;font-weight:bold;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <div style="text-align:left;"><?php the_excerpt(); ?></div>
<div class="read-article-button" style="width: 100%;padding-top: 30px;margin-left: auto;margin-right: auto;"><a href="<?php the_permalink(); ?>" class="btn btn_primary rounded-pill" style="color:#EEE;">Read article</a></div>
              </div>
            </div>
              
            <!-- top highlight blog end -->
        <?php endwhile;
        wp_reset_postdata();
    endif;
    ?>


<?php
// === Second Loop: Show All Other Posts (Exclude Latest) ===

$all_posts_query = new WP_Query( array(
    'posts_per_page' => -1,
    'post__not_in' => array( intval($featured_id) ),
    'ignore_sticky_posts' => 1
) );

if ( $all_posts_query->have_posts() ) : ?>
	<!-- blog list 1 start -->
<div class="blog-list-area">
  <div class="blog-list-title">
    <h3 style="font-size:40px;margin:0 auto;margin-bottom:150px;">More Articles</h3>
  </div>
  <div class="blog-list-main">

    <?php
    while ( $all_posts_query->have_posts() ) :
        $all_posts_query->the_post();
    ?>
      <div class="blog-list-single">

        <!-- Post Thumbnail -->
        <div class="blog-list-single-img">
          <a href="<?php the_permalink(); ?>">
            <?php
            if ( has_post_thumbnail() ) {
                the_post_thumbnail('medium', array('alt' => get_the_title()));
            } else {
                echo '<img src="https://webqa.co/raw-files/assets/images/blog/default-thumb.png" alt="blog">';
            }
            ?>
          </a>
        </div>

        <!-- Post Tags -->
        <?php
        if ( has_tag() ) {
            echo '<div class="post-category"><ul>';
            $post_tags = get_the_tags();
            foreach ( $post_tags as $tag ) {
                $tag_link = get_tag_link( $tag->term_id );
                echo '<li><a href="' . esc_url( $tag_link ) . '">' . esc_html( $tag->name ) . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>

        <!-- Post Title -->
        <div class="blog-list-single-heading">
            
          <h4 style="text-align:left;"><a style="color:#000;font-weight:bold;text-decoration:none;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <div style="text-align:left;"><?php the_excerpt(); ?></div>
        </div>

      </div><!-- /.blog-list-single -->
    <?php endwhile; ?>

  </div><!-- /.blog-list-main -->
</div><!-- /.blog-list-area -->
<!-- blog list 1 end -->
</div>
<?php
    wp_reset_postdata();
else :
    echo '<p style="text-align:center;">No posts found.</p>';
endif;

get_footer();
?>