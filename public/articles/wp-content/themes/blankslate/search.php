<?php
get_header();
?>


<div class="search-page-header" style="text-align:center; margin:40px 0;">
  <h1 style="font-size:32px; font-weight:700; color:#222;">
    Search Results for: "<?php echo get_search_query(); ?>"
  </h1>
</div>

<?php if ( have_posts() ) : ?>
  <div class="blog-list-area" style="max-width:1100px; margin:0 auto;">
    <div class="blog-list-main">
      <?php while ( have_posts() ) : the_post(); ?>
        <div class="blog-list-single" style="margin-bottom:40px;">
          <div class="blog-list-single-img" style="margin-bottom:15px;">
            <a href="<?php the_permalink(); ?>">
              <?php if ( has_post_thumbnail() ) {
                the_post_thumbnail('medium', array(
                  'alt' => get_the_title(),
                  'style' => 'width:100%; height:auto; border-radius:8px;'
                ));
              } else {
                echo '<img src="https://webqa.co/raw-files/assets/images/blog/default-thumb.png" alt="blog" style="width:100%; height:auto; border-radius:8px;">';
              } ?>
            </a>
          </div>

          <?php
          if ( has_tag() ) {
            echo '<div class="post-category" style="margin-bottom:10px;">';
            echo '<ul style="list-style:none; padding:0; margin:0; display:flex; flex-wrap:wrap; gap:8px;">';
            $post_tags = get_the_tags();
            foreach ( $post_tags as $tag ) {
              $tag_link = get_tag_link( $tag->term_id );
              echo '<li><a href="' . esc_url( $tag_link ) . '" style="background:#f1f1f1; padding:5px 10px; border-radius:4px; text-decoration:none; color:#333; font-size:13px;">' . esc_html( $tag->name ) . '</a></li>';
            }
            echo '</ul></div>';
          }
          ?>

          <div class="blog-list-single-heading">
            <h4 style="font-size:20px; line-height:1.4; font-weight:600; margin:0;">
              <a href="<?php the_permalink(); ?>" style="text-decoration:none; color:#222;"><?php the_title(); ?></a>
            </h4>
            <div style="text-align:left;"><?php the_excerpt(); ?></div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

<?php else : ?>
  <p style="text-align:center; margin:40px 0;">No results found for your search.</p>
<?php endif; ?>

<?php get_footer(); ?>
