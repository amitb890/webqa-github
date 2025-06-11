<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if ( is_singular() ) { echo '<h1 class="entry-title" itemprop="headline">'; } else { echo '<div class="single-getting">
                <div class="getting-left-content">
                  <h4>'; } ?>
<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
<?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h4>'; } ?>

<?php if ( !is_search() ) { get_template_part( 'entry', 'meta' ); } ?>
<?php get_template_part( 'entry', ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
<?php if ( is_singular() ) { get_template_part( 'entry-footer' ); } ?>
</article>


