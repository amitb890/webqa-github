

<!-- main sections starts -->
    <main class="main-sections blog-padding">
      <div class="inner_content">
        <div class="container-fluid">
          <div class="blog-main-area single-post-main">
            <!-- post page blog start -->
            <div class="post-page-headline post-page-headline2">
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
              <h1><?php the_title(); ?></h1>
              <div style="margin-top:30px;"><?php the_post_thumbnail( 'full' ); ?></div>
            </div>
            
            <div class="single-post-content single-post-content2"><?php the_content(); ?></div>

<?php get_template_part( 'nav', 'below' ); ?>



