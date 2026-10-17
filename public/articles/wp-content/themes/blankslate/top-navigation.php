<?php webqa_include_shared('site-header.php'); ?>

<section class="blog-title-section">
  <div class="blog-title">
    <h2 style="line-height:20px;">Webqa Blog</h2>
    <p style="text-align:center;margin-bottom:30px;font-style:italic;">
      Insights and best practices to help you build faster, cleaner, and world class websites.
    </p>
  </div>

  <div class="blog-menu">
    <nav style="display:flex;align-items:center;justify-content:center;gap:20px;flex-wrap:wrap;">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="blog-home">
        <img src="/new-assets/assets/images/blog/home.svg" alt="home" style="width:20px;height:20px;">
      </a>

      <ul style="display:flex;list-style:none;gap:15px;margin:0;padding:0;">
        <li><a href="#">SEO</a></li>
        <li><a href="#">Performance</a></li>
        <li><a href="#">Best Practices</a></li>
        <li><a href="#">Security</a></li>
        <li><a href="#">Checklists</a></li>
      </ul>

      <!-- Search icon that becomes input -->
      <a href="#" id="searchIcon">
        <img src="/new-assets/assets/images/blog/search.svg" alt="search" style="width:20px;height:20px;cursor:pointer;">
      </a>

      <button id="blog_menuBtn" class="blog_menu_btn" type="button" style="background:none;border:none;cursor:pointer;">
        <span></span><span></span><span></span>
      </button>
    </nav>
  </div>
</section>

<!-- Inline JS for the search field -->
<script>
  document.getElementById("searchIcon").addEventListener("click", function(event) {
    event.preventDefault();

    const searchLink = event.currentTarget;
    const form = document.createElement("form");
    form.action = "<?php echo esc_url(home_url('/')); ?>";
    form.method = "get";
    form.style.display = "inline-block";

    const input = document.createElement("input");
    input.type = "text";
    input.name = "s";
    input.placeholder = "Search articles...";
    input.style.cssText = `
      padding:5px 10px;
      border:1px solid #ccc;
      border-radius:4px;
      font-size:14px;
      outline:none;
      width:180px;
    `;

    form.appendChild(input);
    searchLink.replaceWith(form);
    input.focus();

    input.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        form.replaceWith(searchLink);
      }
    });
  });
</script>