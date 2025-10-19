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
          
<!-- blog article area start -->
          <div class="blog-article-area">
            <div class="blog-article-title">
              <h2>Related Articles</h2>
            </div>
            <div class="blog-list-main">
              <div class="blog-list-single">
                <div class="blog-list-single-img">
                  <img src="https://webqa.co/raw-files/assets/images/blog/blog_7.png" alt="blog">
                </div>
                <div class="post-category">
                  <ul>
                    <li><a href="#">Search Engine</a></li>
                    <li><a href="#">SEO</a></li>
                    <li><a href="#">Website Audit</a></li>
                  </ul>
                </div>
                <div class="blog-list-single-heading">
                  <h4>A 5-step plan to achieve your goals for your next project</h4>
                </div>
              </div>

              <div class="blog-list-single">
                <div class="blog-list-single-img">
                  <img src="https://webqa.co/raw-files/assets/images/blog/blog_8.png" alt="blog">
                </div>
                <div class="post-category">
                  <ul>
                    <li><a href="#">Website Audit</a></li>
                  </ul>
                </div>
                <div class="blog-list-single-heading">
                  <h4>9 professional designers’ tips for overcoming creative block</h4>
                </div>
              </div>

              <div class="blog-list-single">
                <div class="blog-list-single-img">
                  <img src="https://webqa.co/raw-files/assets/images/blog/blog_9.png" alt="blog">
                </div>
                <div class="post-category">
                  <ul>
                    <li><a href="#">SEO</a></li>
                    <li><a href="#">Website Audit</a></li>
                  </ul>
                </div>
                <div class="blog-list-single-heading">
                  <h4>An article all about alliteration in brand names</h4>
                </div>
              </div>
            </div>
          </div>
          <!-- blog article area end -->

        </div>
      </div>
    </main>
    <!-- main sections ends -->
