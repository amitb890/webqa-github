<?php
if (!function_exists('webqa_nav_icon')) {
  function webqa_nav_icon($paths) {
    return '<span class="nav-mega-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">' . $paths . '</svg></span>';
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
          <?php echo webqa_nav_icon('<path d="M8 3.5h8"/><rect x="5" y="5" width="14" height="16" rx="2"/><path d="M8.5 12.5l2.2 2.2 4.3-4.4"/>'); ?>
          <span class="nav-mega-label">Webpage Audit</span>
        </a>
        <a class="nav-mega-link" href="/features/website-tracker">
          <?php echo webqa_nav_icon('<rect x="3.5" y="4" width="17" height="16" rx="2"/><path d="M3.5 9h17M3.5 14h17M9 9v11"/>'); ?>
          <span class="nav-mega-label">Website Tracker</span>
        </a>
        <a class="nav-mega-link" href="/features/reports">
          <?php echo webqa_nav_icon('<path d="M7 3.5h7l4.5 4.5V20a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1z"/><path d="M14 3.5V8h4.5M8.5 13h7M8.5 16.5h4.5"/>'); ?>
          <span class="nav-mega-label">Reports</span>
        </a>
        <a class="nav-mega-link" href="/features/settings">
          <?php echo webqa_nav_icon('<path d="M4 7h16M4 12h16M4 17h16"/><circle cx="8" cy="7" r="1.7"/><circle cx="15" cy="12" r="1.7"/><circle cx="10" cy="17" r="1.7"/>'); ?>
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
          <?php echo webqa_nav_icon('<rect x="3.5" y="5" width="17" height="14" rx="2"/><path d="M7 10h10M7 14h6"/>'); ?>
          <span class="nav-mega-label">Meta title</span>
        </a>
        <a class="nav-mega-link" href="/tools/images">
          <?php echo webqa_nav_icon('<rect x="3.5" y="5" width="17" height="14" rx="2"/><circle cx="8.5" cy="10" r="1.4"/><path d="M4 16.5l4.2-3.4 3.3 2.6 2.6-2 5.4 4.2"/>'); ?>
          <span class="nav-mega-label">Images</span>
        </a>
        <a class="nav-mega-link" href="/tools/google-page-speed-insights">
          <?php echo webqa_nav_icon('<path d="M5 16.5a7 7 0 1 1 14 0"/><path d="M12 16.5l3.6-3.8"/>'); ?>
          <span class="nav-mega-label">Page speed</span>
        </a>
        <a class="nav-mega-link" href="/tools/google-core-web-vitals">
          <?php echo webqa_nav_icon('<path d="M3 12h4l2.2-5 4.2 10L16 12h5"/>'); ?>
          <span class="nav-mega-label">Core Web Vitals</span>
        </a>
        <a class="nav-mega-link" href="/tools/broken-links">
          <?php echo webqa_nav_icon('<rect x="6" y="11" width="12" height="8.5" rx="2"/><path d="M8.5 11V8.2a3.5 3.5 0 0 1 7 0V11"/>'); ?>
          <span class="nav-mega-label">Security</span>
        </a>
        <a class="nav-mega-link" href="/tools/http-status-code">
          <?php echo webqa_nav_icon('<path d="M9 8L5 12l4 4M15 8l4 4-4 4"/>'); ?>
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
