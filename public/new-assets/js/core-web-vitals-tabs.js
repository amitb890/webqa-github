// Core Web Vitals Tab Functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.core-web-vitals-tabs .tab-button');
    const performanceLeft = document.querySelector('.performance-left');
    const performanceRight = document.querySelector('.performance-right');

    // Function to switch tabs
    function switchTab(activeTab) {
        // Remove active class from all buttons
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });

        // Add active class to clicked button
        activeTab.classList.add('active');

        // Show/hide content based on selected tab
        if (activeTab.dataset.tab === 'desktop') {
            if (performanceLeft) performanceLeft.style.display = 'block';
            if (performanceRight) performanceRight.style.display = 'none';
        } else if (activeTab.dataset.tab === 'mobile') {
            if (performanceLeft) performanceLeft.style.display = 'none';
            if (performanceRight) performanceRight.style.display = 'block';
        }
    }

    // Add click event listeners to tab buttons
    tabButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            switchTab(this);
        });
    });

    // Initialize with Desktop tab active
    const desktopTab = document.querySelector('.tab-button[data-tab="desktop"]');
    if (desktopTab) {
        switchTab(desktopTab);
    }
});

