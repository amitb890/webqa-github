<?php
if (!function_exists('webqa_nav_icon')) {
  function webqa_nav_icon($paths) {
    return '<span class="nav-mega-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">' . $paths . '</svg></span>';
  }
}
?>
<li>
  <div class="dropdown dropdown2">
    <a
      class="dropdown-toggle nav-drop-toggle"
      href="/features"
      data-bs-toggle="dropdown"
      data-bs-display="static"
      aria-expanded="false"
    >
      <span>Features</span>
      <i class="fa-solid fa-angle-down dropdown2-arrow" aria-hidden="true"></i>
    </a>

    <div class="dropdown-menu nav-mega">
      <div class="nav-mega-grid">
        <a class="nav-mega-link" href="/features/webpage-audit">
          <?php echo webqa_nav_icon('<rect x="8" y="2.5" width="8" height="4" rx="1"/><path d="M16 4.5h2a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-13a2 2 0 0 1 2-2h2"/><path d="M9 14l2 2 4-4"/>'); ?>
          <span class="nav-mega-label">Webpage Audit</span>
        </a>
        <a class="nav-mega-link" href="/features/website-tracker">
          <?php echo webqa_nav_icon('<path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="M19 9l-5 5-4-4-3 3"/>'); ?>
          <span class="nav-mega-label">Website Tracker</span>
        </a>
        <a class="nav-mega-link" href="/features/reports">
          <?php echo webqa_nav_icon('<path d="M14.5 2.5H6a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2.5V8h6M8 13h8M8 17h5"/>'); ?>
          <span class="nav-mega-label">Reports</span>
        </a>
        <a class="nav-mega-link" href="/features/settings">
          <?php echo webqa_nav_icon('<path d="M21 5h-7M10 5H3M21 12h-9M8 12H3M21 19h-5M12 19H3M14 3v4M8 10v4M16 17v4"/>'); ?>
          <span class="nav-mega-label">Settings</span>
        </a>
      </div>
      <div class="nav-mega-pills">
        <a class="nav-mega-pill" href="/features">All features</a>
        <a class="nav-mega-pill" href="/features/webpage-audit">Audits</a>
        <a class="nav-mega-pill" href="/features/website-tracker">Tracking</a>
        <a class="nav-mega-pill" href="/features/reports">Reports</a>
        <a class="nav-mega-pill" href="/features/settings">Settings</a>
      </div>
    </div>
  </div>
</li>
<li>
  <div class="dropdown dropdown2">
    <a
      class="dropdown-toggle nav-drop-toggle"
      href="/tools"
      data-bs-toggle="dropdown"
      data-bs-display="static"
      aria-expanded="false"
    >
      <span>Tools</span>
      <i class="fa-solid fa-angle-down dropdown2-arrow" aria-hidden="true"></i>
    </a>

    <div class="dropdown-menu nav-mega">
      <div class="nav-mega-grid">
        <a class="nav-mega-link" href="/tools/meta-title">
          <?php echo webqa_nav_icon('<path d="M4 7V5h16v2"/><path d="M12 5v14"/><path d="M9 19h6"/>'); ?>
          <span class="nav-mega-label">Meta title</span>
        </a>
        <a class="nav-mega-link" href="/tools/images">
          <?php echo webqa_nav_icon('<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="M21 15l-3.1-3.1a2 2 0 0 0-2.8 0L6 21"/>'); ?>
          <span class="nav-mega-label">Images</span>
        </a>
        <a class="nav-mega-link" href="/tools/google-page-speed-insights">
          <?php echo webqa_nav_icon('<path d="M12 14l4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/>'); ?>
          <span class="nav-mega-label">Page speed</span>
        </a>
        <a class="nav-mega-link" href="/tools/google-core-web-vitals">
          <?php echo webqa_nav_icon('<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>'); ?>
          <span class="nav-mega-label">Core Web Vitals</span>
        </a>
        <a class="nav-mega-link" href="/tools/broken-links">
          <?php echo webqa_nav_icon('<path d="M12 21.5s7.5-3.2 7.5-9.5V5.5L12 2.5l-7.5 3V12c0 6.3 7.5 9.5 7.5 9.5z"/><path d="M9 12l2 2 4-4"/>'); ?>
          <span class="nav-mega-label">Security</span>
        </a>
        <a class="nav-mega-link" href="/tools/http-status-code">
          <?php echo webqa_nav_icon('<path d="M18 16l4-4-4-4M6 8l-4 4 4 4M14.5 4l-5 16"/>'); ?>
          <span class="nav-mega-label">HTTP status</span>
        </a>
      </div>
      <div class="nav-mega-pills">
        <a class="nav-mega-pill" href="/tools">All tools</a>
        <a class="nav-mega-pill" href="/tools#seo">SEO</a>
        <a class="nav-mega-pill" href="/tools#performance">Performance</a>
        <a class="nav-mega-pill" href="/tools#best-practices">Best practices</a>
        <a class="nav-mega-pill" href="/tools#security">Security</a>
      </div>
    </div>
  </div>
</li>
<li><a class="nav-plain-link" href="/articles/">Articles</a></li>
<li><a class="nav-plain-link" href="/support/">Support</a></li>
