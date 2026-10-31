// Demo page layout: builds the sidebar navigation (sections work as accordions) and makes the
// sidebar collapsible. Collapsed/expanded choices are remembered in this browser.
(function () {
  // ---- Sidebar navigation: add new pages here (paths are relative to the tools-page-table folder) ----
  const NAV = [
    { label: 'Index', href: 'index.html' },
    { section: 'SEO', items: [
      { label: 'Meta Title', href: 'pages/meta-title.html' },
      { label: 'Meta Description', href: 'pages/meta-description.html' },
      { label: 'Robots Meta Tag', href: 'pages/robots-meta.html' },
      { label: 'Canonical Tag', href: 'pages/canonical-tag.html' },
      { label: 'Images', href: 'pages/images.html' },
      { label: 'URL Slug', href: 'pages/url-slug.html' }
    ] },
    { section: 'Performance', items: [] },
    { section: 'Best Practices', items: [] },
    { section: 'Security', items: [] }
  ];

  // The tools-page-table folder, worked out from this script's own URL (assets/js/page-layout.js)
  const scriptSrc = document.currentScript ? document.currentScript.src : '';
  const root = scriptSrc ? new URL('../../', scriptSrc) : new URL('./', location.href);

  // Each section is an accordion: click its heading (+ / −) to expand or collapse it.
  // By default the section holding the current page is open (the first section on the Index page);
  // after that, each section's open/closed state is remembered in this browser.
  const SECTIONS_KEY = 'tools-page-sidebar-sections';
  const readSectionState = () => {
    try { return JSON.parse(localStorage.getItem(SECTIONS_KEY)) || {}; } catch (e) { return {}; }
  };
  const saveSectionState = state => {
    try { localStorage.setItem(SECTIONS_KEY, JSON.stringify(state)); } catch (e) { /* storage unavailable */ }
  };

  function renderNav(nav) {
    const here = location.pathname;
    const isHere = item => new URL(item.href, root).pathname === here;
    const link = item => {
      const active = isHere(item) ? ' class="active" aria-current="page"' : '';
      return `<li><a href="${new URL(item.href, root).href}"${active}>${item.label}</a></li>`;
    };
    const sections = NAV.filter(entry => entry.section);
    const currentSection = sections.find(entry => entry.items.some(isHere)) || sections[0];
    const saved = readSectionState();

    nav.innerHTML = NAV.map(entry => {
      if (!entry.section) return `<ul class="sidebar-top">${link(entry)}</ul>`;
      const id = 'sidebar-section-' + entry.section.toLowerCase().replace(/[^a-z0-9]+/g, '-');
      const open = entry.section in saved ? saved[entry.section] : entry === currentSection;
      const body = entry.items.length
        ? `<ul>${entry.items.map(link).join('')}</ul>`
        : '<p class="sidebar-empty">Coming soon</p>';
      return `
        <div class="sidebar-section${open ? ' is-open' : ''}" data-section="${entry.section}">
          <h2>
            <button class="sidebar-section-toggle" type="button" aria-expanded="${open}" aria-controls="${id}">
              <span>${entry.section}</span><span class="sidebar-section-sign" aria-hidden="true">${open ? '−' : '+'}</span>
            </button>
          </h2>
          <div class="sidebar-section-body" id="${id}"><div>${body}</div></div>
        </div>`;
    }).join('');

    nav.querySelectorAll('.sidebar-section-toggle').forEach(button => {
      button.addEventListener('click', () => {
        const section = button.closest('.sidebar-section');
        const open = !section.classList.contains('is-open');
        section.classList.toggle('is-open', open);
        button.setAttribute('aria-expanded', String(open));
        button.querySelector('.sidebar-section-sign').textContent = open ? '−' : '+';
        const state = readSectionState();
        state[section.dataset.section] = open;
        saveSectionState(state);
      });
    });
  }

  const nav = document.querySelector('.sidebar-nav');
  if (nav) renderNav(nav);

  // ---- Collapsible sidebar ----
  const STORAGE_KEY = 'tools-page-sidebar-collapsed';
  const toggle = document.getElementById('sidebar-toggle');
  const layout = document.querySelector('.layout');
  if (!toggle || !layout) return;

  let collapsed = false;
  try { collapsed = localStorage.getItem(STORAGE_KEY) === '1'; } catch (e) { /* storage unavailable */ }

  function apply() {
    layout.classList.toggle('sidebar-collapsed', collapsed);
    toggle.setAttribute('aria-expanded', String(!collapsed));
    toggle.setAttribute('aria-label', collapsed ? 'Show sidebar' : 'Hide sidebar');
    toggle.dataset.tooltip = collapsed ? 'Show sidebar' : 'Hide sidebar';
  }

  apply();
  // Enable the slide animation only after the saved state is applied, so the page doesn't animate on load
  requestAnimationFrame(() => layout.classList.add('sidebar-animate'));

  toggle.addEventListener('click', () => {
    collapsed = !collapsed;
    apply();
    try { localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0'); } catch (e) { /* storage unavailable */ }
  });
})();
