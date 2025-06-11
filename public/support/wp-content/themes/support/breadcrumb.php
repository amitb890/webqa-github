


<div class="support-link">
              <a href="https://webqa.co/support/"> <span>Support</span> <img src="https://webqa.co/support/wp-content/themes/support/assets/images/arrow.png" alt="icon"> </a>
              <a href=""> <span><?php
  foreach ( ( get_the_category() ) as $category ) {
    echo $category->cat_name . ' ';
  }
?></span> <img src="https://webqa.co/support/wp-content/themes/support/assets/images/arrow.png" alt="icon"> </a>
              <span><?php echo get_the_title( $post_id ); ?></span>
            </div>