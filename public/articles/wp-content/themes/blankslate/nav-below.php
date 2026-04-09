<!-- share and media start -->
          <div class="share-and-media">
            <div class="post-share-area">
              <h4>Share this article</h4>
              <div class="post-medias">
                <a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank" class="twiter"><i class="fa-brands fa-twitter"></i></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= rawurlencode( get_permalink() ); ?>&title=<?= rawurlencode( get_the_title() ); ?>" target="_blank" aria-label="Share on LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode( get_permalink() ); ?>" target="_blank" aria-label="Share on Facebook" class="facebook"><i class="fa-brands fa-facebook"></i></a>
              </div>
            </div>
            <div class="post-help-area">
              <h4>Was this post helpful?</h4>
              <div class="like-unlike">
                <div class="like">
                  <a href="#"><img src="https://webqa.co/articles/wp-content/themes/theme-assets/like.svg" alt="like"></a>
                  <p>Yes</p>
                </div>
                <div class="unlike">
                  <a href="#"><img src="https://webqa.co/articles/wp-content/themes/theme-assets/unlike.svg" alt="unlike"></a>
                  <p>Not really</p>
                </div>
              </div>
            </div>
          </div>
          <!-- share and media end -->
          <!-- Wondering Area Start -->
          <div class="trial-area blog-wondering-mt">
            <div class="trial-content">
              <h2>Think your site is flawless? Test it with WebQA for hidden issues</h2>
                <a data-bs-toggle="modal" data-bs-target="#registerModal" href="#" class="btn btn_primary rounded-pill">Sign Up</a>
            </div>
          </div>
          <!-- Wondering Area End -->
          

        </div>
      </div>
    </main>
    <!-- main sections ends -->
