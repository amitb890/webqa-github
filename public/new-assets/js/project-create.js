$(document).ready(function() {
    
    // Detect if we're on create or edit page
    const isEditPage = $('#editProjectButton').length > 0;
    const isCreatePage = $('#createProjectButton').length > 0;
    
    // Track last processed homepage URL to prevent duplicate sitemap detection
    // Initialize with current homepage value on edit page (if exists)
    let lastProcessedHomepage = $('#homepage').val() ? $('#homepage').val().trim() : '';

    // Add auto line numbers to URLs list (project create/edit only)
    function initUrlsListAutoNumbers() {
        const textarea = document.getElementById('urlsList');
        if (!textarea) return;

        const wrapper = textarea.closest('.project-urls-numbered');
        if (!wrapper) return;

        const numbers = wrapper.querySelector('.project-urls-numbered__numbers');
        if (!numbers) return;

        function getLineHeightPx() {
            const cs = getComputedStyle(textarea);
            if (cs.lineHeight === 'normal') {
                return parseFloat(cs.fontSize) * 1.2;
            }
            return parseFloat(cs.lineHeight);
        }

        function syncStyles() {
            const cs = getComputedStyle(textarea);
            numbers.style.fontSize = cs.fontSize;
            numbers.style.lineHeight = `${getLineHeightPx()}px`;
            numbers.style.paddingTop = cs.paddingTop;
            numbers.style.paddingBottom = cs.paddingBottom;
        }

        function renderNumbers() {
            const value = textarea.value.trim();
            if (value === '') {
                numbers.innerHTML = '';
                return;
            }

            const lines = textarea.value.split('\n').length;
            let html = '';
            for (let i = 1; i <= lines; i++) {
                html += `<div>${i}.</div>`;
            }
            numbers.innerHTML = html;
        }

        function syncScroll() {
            numbers.style.height = textarea.clientHeight + 'px';
            numbers.scrollTop = textarea.scrollTop;
        }

        function refreshNumbers() {
            syncStyles();
            renderNumbers();
            syncScroll();
        }

        refreshNumbers();
        // Repaint after layout/fonts settle (DevTools triggers this too)
        setTimeout(refreshNumbers, 0);
        setTimeout(refreshNumbers, 100);
        window.addEventListener('load', refreshNumbers);

        textarea.addEventListener('input', refreshNumbers);

        textarea.addEventListener('scroll', syncScroll);
        window.addEventListener('resize', () => {
            syncStyles();
            renderNumbers();
            syncScroll();
        });

        if (window.ResizeObserver) {
            const ro = new ResizeObserver(() => {
                syncStyles();
                renderNumbers();
                syncScroll();
            });
            ro.observe(textarea);
        }
    }

    initUrlsListAutoNumbers();

    function setUrlsListValue(value) {
        const urlsList = $("#urlsList");
        urlsList.val(value);
        const el = urlsList[0];
        if (el) {
            el.dispatchEvent(new Event("input", { bubbles: true }));
        }
    }
    
    // URL validation function (same as onboarding isValidUrl method)
    function isValidURLForHomepage(string) {
        try {
            // Remove leading/trailing whitespace
            string = string.trim();
            
            // Check for invalid characters at the start
            if (string.startsWith('@') || string.includes('@http')) {
                return false;
            }
            
            // Parse the URL
            const urlObj = new URL(string);
            
            // Check if protocol is http or https
            if (!['http:', 'https:'].includes(urlObj.protocol)) {
                return false;
            }
            
            // Check if hostname is valid (not empty, not just whitespace)
            if (!urlObj.hostname || urlObj.hostname.trim() === '' || urlObj.hostname === 'www.') {
                return false;
            }
            
            // Check if hostname has at least one dot (e.g., example.com)
            if (!urlObj.hostname.includes('.')) {
                return false;
            }
            
            // For homepage validation, ensure it's not pointing to a specific file
            const pathname = urlObj.pathname;
            // Check if pathname ends with common file extensions
            const fileExtensions = ['.txt', '.xml', '.html', '.htm', '.php', '.pdf', '.doc', '.docx', '.jpg', '.jpeg', '.png', '.gif', '.css', '.js', '.json'];
            const hasFileExtension = fileExtensions.some(ext => pathname.toLowerCase().endsWith(ext));
            
            if (hasFileExtension) {
                return false;
            }
            
            return true;
        } catch (_) {
            return false;
        }
    }
    
    // Validate homepage URL
    function validateHomepageUrl() {
        clearAlertsNew();
        const input = document.getElementById('homepage');
        const inputName = input.getAttribute('data-name') || 'Website address';
        let isValid = true;

        // Check if empty
        if (input.value.trim() === "") {
            const alert = buildAlertNew(`${inputName} can not be empty`);
            input.parentElement.appendChild(alert);
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            $('.valid_url').hide();
            $('#check_valid_url').val(0);
            return false;
        }

        // Validate URL format using same logic as onboarding
        if (!isValidURLForHomepage(input.value)) {
            let msgInvalid = 'Please enter a valid homepage URL (e.g., https://example.com). Files and direct paths are not allowed.';
            const alert = buildAlertNew(msgInvalid);
            input.parentElement.appendChild(alert);
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            $('.valid_url').hide();
            $('#check_valid_url').val(0);
            return false;
        }

        // If format is valid, skip server validation
        $('#homepage').removeClass('is-invalid');
        $('#homepage').addClass('is-valid');
        $('.valid_url').show();
        $('#check_valid_url').val(1);
        
        // Check homepage uniqueness first - sitemap detection will only run if URL is unique
        checkUniqueProjectHomepage(input.value.trim());
        
        return true;
    }
    
    // Fetch URLs from sitemaps function (same as onboarding detectUrls)
    async function fetchUrls(selectedSitemaps) {
        // Clear existing URLs list and hide messages
        setUrlsListValue("");
        $('#noUrlsDetectedMessage').hide();
        $('.total_url').hide();
        
        // If no sitemap selected, add homepage and show message
        if (!selectedSitemaps || selectedSitemaps.length === 0) {
            const rootUrl = $('#homepage').val().trim();
            if (rootUrl) {
                setUrlsListValue(rootUrl);
                $('.total_url').text('Total 1 URL found.').show();
            }
            $('#noUrlsDetectedMessage').show();
            return;
        }

        try {
            // Update loader text to "Extracting URLs..."
            $('#loader-text').text('Extracting URLs...');
            
            const response = await fetch('/onboarding/fetch-urls', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({ sitemaps: selectedSitemaps })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Total URLs:', data.count, data.urls);
            
            // Process URLs and populate urlsList textarea
            if (data.urls && data.urls.length > 0) {
                let list = "";
                data.urls.forEach((url, i) => {
                    const trimmedUrl = url.trim();
                    list += trimmedUrl;
                    // Add newline if not the last item
                    if (i < data.urls.length - 1) {
                        list += "\n";
                    }
                });
                setUrlsListValue(list);
                
                // Show total URL count and hide no URLs message
                const urlCount = data.count || data.urls.length;
                $('.total_url').text(`${urlCount} URL${urlCount !== 1 ? 's' : ''} found.`).show();
                $('#noUrlsDetectedMessage').hide();
            } else {
                // No URLs detected - add homepage and show message
                const rootUrl = $('#homepage').val().trim();
                if (rootUrl) {
                    setUrlsListValue(rootUrl);
                    $('.total_url').text('Total 1 URL found.').show();
                }
                $('#noUrlsDetectedMessage').show();
            }
            
        } catch (error) {
            console.error('Error fetching URLs:', error);
            // On error, add homepage and show message
            const rootUrl = $('#homepage').val().trim();
            if (rootUrl) {
                setUrlsListValue(rootUrl);
                $('.total_url').text('Total 1 URL found.').show();
            }
            $('#noUrlsDetectedMessage').show();
        }
    }

    // Detect sitemaps function (same as onboarding)
    async function detectSitemaps(homepage) {
        // Show loader under homepage field
        $('#loader-text').text('Detecting sitemaps...');
        $('#sitemap-loader').show();
        
        try {
            const response = await fetch('/onboarding/detect-sitemaps', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                body: JSON.stringify({ root_url: homepage })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Sitemap detection result:', data);
            
            // Update XML Sitemap textarea with all detected sitemaps
            if (data.sitemaps && data.sitemaps.length > 0) {
                // Join all sitemaps with newline (one per line)
                const sitemapsText = data.sitemaps.join('\n');
                $('#xmlSitemap').val(sitemapsText);
                
                // After sitemaps are detected, fetch URLs from those sitemaps
                await fetchUrls(data.sitemaps);
            } else {
                // No sitemaps detected - show message
                $('#xmlSitemap').val('');
                await fetchUrls([]);
            }
            
        } catch (error) {
            console.error('Error detecting sitemaps:', error);
            // On error, show message
            $('#xmlSitemap').val('');
            await fetchUrls([]);
        } finally {
            // Hide loader after both operations complete
            $('#sitemap-loader').hide();
        }
    }

    // Check unique project name function
    function checkUniqueProjectName() {
        var projectName = $('#name').val().trim();
        var projectId = $('#project_id').val() || 0;
        
        if (projectName === '') {
            $('#unique_name_project_valid').val(0);
            return;
        }
        
        $('#unique_name_project_valid').val(1);
        $.ajax({
            url: '/check-unique-project-name',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                project_name: projectName,
                projectId: projectId
            },
            success: function (response) {
                if(response.uniqueError) {
                    $('#name').removeClass('is-invalid');
                    $('.invalid_name').hide();
                    $('#unique_name_project_valid').val(1);
                } else {
                    $('#name').addClass('is-invalid');
                    $('.invalid_name').show();
                    $('#unique_name_project_valid').val(0);
                }
            },
            error: function() {
                $('#name').addClass('is-invalid');
                $('.invalid_name').show();
                $('#unique_name_project_valid').val(0);
            }
        });
    }

    // Check unique project homepage function
    // Sitemap detection will only run if homepage URL is unique and has changed
    function checkUniqueProjectHomepage(homepageValue) {
        var homepage = homepageValue || $('#homepage').val().trim();
        var projectId = $('#project_id').val() || 0;
        
        if (homepage === '') {
            $('#unique_homepage_project_valid').val(0);
            lastProcessedHomepage = ''; // Reset tracking
            return;
        }
        
        // Only check if URL format is valid
        if (!isValidURLForHomepage(homepage)) {
            $('#unique_homepage_project_valid').val(0);
            lastProcessedHomepage = ''; // Reset tracking
            return;
        }
        
        // Normalize homepage for comparison (remove trailing slashes, normalize)
        const normalizedHomepage = homepage.toLowerCase().replace(/\/+$/, '');
        const normalizedLastProcessed = lastProcessedHomepage.toLowerCase().replace(/\/+$/, '');
        
        // Check if homepage has changed - if same, skip sitemap detection
        const homepageChanged = normalizedHomepage !== normalizedLastProcessed;
        
        // Set to invalid initially (will be updated by AJAX response)
        $('#unique_homepage_project_valid').val(0);
        
        // Make AJAX call to check uniqueness
        $.ajax({
            url: '/check-unique-project-homepage',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                homepage: homepage,
                projectId: projectId
            },
            success: function (response) {
                if(response.uniqueError) {
                    // Homepage is unique - hide error message and show "URL validated." message
                    $('.invalid_homepage').hide();
                    $('.valid_url').show(); // Show "URL validated." message
                    $('#unique_homepage_project_valid').val(1);
                    
                    // Only call detectSitemaps if URL is unique AND has changed
                    if (homepageChanged) {
                        lastProcessedHomepage = homepage; // Update tracking
                        detectSitemaps(homepage);
                    }
                } else {
                    // Homepage is not unique - show error message and hide "URL validated." message
                    $('.invalid_homepage').show();
                    $('.valid_url').hide(); // Hide "URL validated." message
                    $('#unique_homepage_project_valid').val(0);
                    // Hide sitemap loader if it was showing
                    $('#sitemap-loader').hide();
                    lastProcessedHomepage = ''; // Reset tracking on error
                }
            },
            error: function() {
                // On error, show the uniqueness error and hide "URL validated." message
                $('.invalid_homepage').show();
                $('.valid_url').hide(); // Hide "URL validated." message
                $('#unique_homepage_project_valid').val(0);
                // Hide sitemap loader if it was showing
                $('#sitemap-loader').hide();
                lastProcessedHomepage = ''; // Reset tracking on error
            }
        });
    }

    // Validate project form function (simplified version for both create and edit)
    function validateProjectForm() {
        clearAlertsNew();
        var validate = true;
        var projectName = $('#name').val().trim();
        
        if (projectName === "") {
            const alertMessage = buildAlertNew('Project name can not be empty');
            $('#name').parent().append(alertMessage);
            validate = false;
        }

        if ($('#homepage').val().trim() === "") {
            const alertMessage = buildAlertNew('Project URL can not be empty');
            $('#homepage').parent().append(alertMessage);
            validate = false;
        } else if (!isValidURLForHomepage($('#homepage').val())) {
            let msgInvalid = 'Please enter a valid homepage URL (e.g., https://example.com). Files and direct paths are not allowed.';
            const alertMessage = buildAlertNew(msgInvalid);
            $('#homepage').parent().append(alertMessage);
            validate = false;
        }

        if ($('#unique_name_project_valid').val() == 0) {
            validate = false;
        }
        
        if ($('#check_valid_url').val() == 0) {
            validate = false;
        }

        if ($('#unique_homepage_project_valid').val() == 0) {
            validate = false;
        }

        // Validate URLs list - this field is required
        const urlsListValue = $('#urlsList').val().trim();
        if (urlsListValue === "") {
            const alertMessage = buildAlertNew('List of urls can not be empty');
            $('#urlsList').parent().append(alertMessage);
            validate = false;
        } else {
            // Remove serial numbers for validation (both create and edit pages)
            let inputString = removeSerialNumbersFromUrls(urlsListValue);
            
            const delimiter = "\n";
            const explodedArray = inputString.split(delimiter);
            const nonBlankArray = explodedArray.filter(item => item.trim() !== '');
            
            if (nonBlankArray.length === 0) {
                const alertMessage = buildAlertNew('Please enter at least one valid URL in the list');
                $('#urlsList').parent().append(alertMessage);
                validate = false;
            }
        }

        return validate;
    }

    // Add data-name attribute if not present
    if (!$('#homepage').attr('data-name')) {
        $('#homepage').attr('data-name', 'Website address');
    }

    // Apply validation on input change (when user types)
    $('#homepage').on('input', function() {
        // Clear only this field's validation errors on typing
        $(this).parent().find('.invalid-feedback').remove();
        $(this).removeClass('is-invalid is-valid');
        $('.valid_url').hide();
        $('.invalid_homepage').hide(); // Hide homepage uniqueness error
        $('#unique_homepage_project_valid').val(1); // Reset uniqueness flag
        $('#sitemap-loader').hide(); // Hide loader if user starts typing again
        $('#xmlSitemap').val(''); // Clear sitemap field on new input
        setUrlsListValue(''); // Clear URLs list on new input
        $('.total_url').hide().empty(); // Hide and clear total URL count
        $('#noUrlsDetectedMessage').hide(); // Hide no URLs message
        lastProcessedHomepage = ''; // Reset tracking when user types
    });

    // Apply validation on blur (when user leaves the field / tab change)
    $('#homepage').on('blur', function() {
        if ($(this).val().trim() !== '') {
            // validateHomepageUrl() already handles URL validation, sitemap detection, and uniqueness check
            validateHomepageUrl();
        }
    });

    // Apply unique name validation on project name input blur
    $('#name').on('blur', function() {
        if ($(this).val().trim() !== '') {
            checkUniqueProjectName();
        }
    });

    // Clear validation on project name input change
    $('#name').on('input', function() {
        // Clear only this field's validation errors on typing
        $(this).parent().find('.invalid-feedback').remove();
        $(this).removeClass('is-invalid');
        $('.invalid_name').hide();
        $('#unique_name_project_valid').val(1);
    });

    // Clear validation on URLs list input change
    $('#urlsList').on('input', function() {
        // Clear only this field's validation errors on typing
        $(this).parent().find('.invalid-feedback').remove();
    });

    // Function to remove serial numbers from URLs before sending to server
    function removeSerialNumbersFromUrls(urlsText) {
        if (!urlsText || urlsText.trim() === '') {
            return urlsText;
        }
        
        // Split by newline and process each line
        const lines = urlsText.split('\n');
        const cleanedLines = lines.map(line => {
            // Remove pattern like "1. ", "2. ", "10. " etc. from the start of each line
            // Handle various formats: "1. https://...", "1.https://...", "1.  https://..."
            let cleaned = line.trim();
            cleaned = cleaned.replace(/^\d+\.\s*/, '').trim();
            
            // Additional check: if line still starts with a number and dot, remove it again
            cleaned = cleaned.replace(/^\d+\.\s*/, '').trim();
            
            return cleaned;
        }).filter(line => line !== ''); // Remove empty lines
        
        return cleanedLines.join('\n');
    }

    // Function to extract domain from URL (normalized - removes www and normalizes scheme)
    function extractDomain(url) {
        try {
            let urlStr = url.trim();
            
            // Add scheme if missing
            if (!urlStr.match(/^https?:\/\//i)) {
                urlStr = 'https://' + urlStr;
            }
            
            const urlObj = new URL(urlStr);
            let host = urlObj.hostname;
            
            // Remove www. prefix
            host = host.replace(/^www\./i, '');
            
            return host.toLowerCase();
        } catch (e) {
            return null;
        }
    }

    // Function to validate URLs belong to homepage domain
    function validateUrlsAgainstHomepage(homepage, urlsList) {
        const invalidUrls = [];
        
        if (!homepage || !urlsList) {
            return invalidUrls;
        }
        
        // Extract homepage domain (normalized)
        const homepageDomain = extractDomain(homepage);
        if (!homepageDomain) {
            return invalidUrls;
        }
        
        // Remove serial numbers and split URLs
        const cleanedUrls = removeSerialNumbersFromUrls(urlsList);
        const urlArray = cleanedUrls.split('\n').filter(url => url.trim() !== '');
        
        // Check each URL
        urlArray.forEach(url => {
            const urlDomain = extractDomain(url.trim());
            if (urlDomain && urlDomain !== homepageDomain) {
                invalidUrls.push(url.trim());
            }
        });
        
        return invalidUrls;
    }

    // Function to show invalid URLs modal
    function showInvalidUrlsModal(invalidUrls) {
        // Create modal HTML if it doesn't exist
        if ($('#invalidUrlsModal').length === 0) {
            const modalHtml = `
                <div class="modal fade" id="invalidUrlsModal" tabindex="-1" role="dialog" aria-labelledby="invalidUrlsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 800px;">
                        <div class="modal-content">
                            <div class="modal-header" style="padding: 20px 30px; border-bottom: 1px solid #dee2e6; position: relative;">
                                <h5 class="modal-title" id="invalidUrlsModalLabel" style="margin: 0; font-size: 1.25rem; font-weight: 600; color: #212529;">URLs Not Matching Homepage Domain</h5>
                                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 1.75rem; color: #6c757d; cursor: pointer; opacity: 0.7; transition: all 0.2s ease-in-out; padding: 5px 10px; line-height: 1; width: auto; height: auto;">
                                    <span aria-hidden="true" style="font-size: 1.75rem; line-height: 1; display: inline-block; font-weight: 300;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="padding: 25px 30px;">
                                <p style="margin-bottom: 20px; color: #495057; font-size: 0.95rem;">The following URLs do not belong to the homepage domain:</p>
                                <ol id="invalidUrlsList" style="max-height: 400px; overflow-y: auto; padding-left: 30px; margin: 0; list-style-position: outside;">
                                </ol>
                            </div>
                            <div class="modal-footer" style="padding: 15px 30px; border-top: 1px solid #dee2e6; justify-content: flex-end;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="min-width: 80px;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    #invalidUrlsModal .btn-close-modal {
                        position: absolute !important;
                        top: 20px !important;
                        right: 20px !important;
                        z-index: 10;
                    }
                    #invalidUrlsModal .btn-close-modal:hover {
                        opacity: 1 !important;
                        color: #212529 !important;
                        background-color: #f8f9fa !important;
                        border-radius: 4px;
                    }
                    #invalidUrlsModal .btn-close-modal:focus {
                        outline: 2px solid #0d6efd;
                        outline-offset: 2px;
                        box-shadow: none;
                    }
                    #invalidUrlsModal .modal-header {
                        position: relative;
                    }
                    #invalidUrlsModal .modal-title {
                        padding-right: 50px;
                    }
                    #invalidUrlsModal ol li {
                        margin-bottom: 12px;
                        word-break: break-all;
                        padding-left: 8px;
                        color: #495057;
                        line-height: 1.6;
                    }
                    #invalidUrlsModal .modal-body p {
                        margin-bottom: 20px;
                    }
                </style>
            `;
            $('body').append(modalHtml);
        }
        
        // Populate the list with serial numbers
        const listElement = $('#invalidUrlsList');
        listElement.empty();
        invalidUrls.forEach((url, index) => {
            listElement.append(`<li style="margin-bottom: 10px; word-break: break-all;">${url}</li>`);
        });
        
        // Show modal - try Bootstrap 5 first, fallback to jQuery
        const modalElement = document.getElementById('invalidUrlsModal');
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        } else {
            $('#invalidUrlsModal').modal('show');
        }
    }

    // This function retrieves the values of sitemap inputs and concatenates them.
    function getSitemapValue(sitemapClass) {
        var concatenatedValues = ""; // Initialize an empty string

        // Find elements with the specified class name
        var elements = $("." + sitemapClass);

        // Loop through the elements and concatenate their text content
        elements.each(function (index) {
            var value = $(this).text();
            concatenatedValues += value;

            // Add a comma if it's not the last element
            if (index < elements.length - 1) {
                concatenatedValues += ",";
            }
        });

        return concatenatedValues;
    }

    function clearHtml() {
        $('.valid_url').hide();
        $('.total_url').empty();
        $('.invalid_url').empty();
        $('#homepage').removeClass('is-valid');
    }

    // Create Project Button Handler
    if (isCreatePage) {
        $("#createProjectButton").click(function (e) {
            e.preventDefault();
            
            clearAlertsNew();
            let hasErrors = false;
            
            // Get field values
            const name = $("#name");
            const projectName = name.val().trim();
            const homepage = $("#homepage");
            const homepageVal = homepage.val().trim();
            const urlsList = $("#urlsList");
            const urlsListVal = urlsList.val().trim();
            
            // Validate project name is not empty
            if (projectName === "") {
                const alert = buildAlertNew('Project name can not be empty');
                name.parent().append(alert);
                hasErrors = true;
            }

            // Validate homepage is not empty
            if (homepageVal === "") {
                const alert = buildAlertNew('Project URL can not be empty');
                homepage.parent().append(alert);
                hasErrors = true;
            }

            // Validate URLs list is not empty
            if (urlsListVal === "") {
                const alert = buildAlertNew('List of urls can not be empty');
                urlsList.parent().append(alert);
                hasErrors = true;
            }

            // Validate all URLs belong to homepage domain (only if both homepage and urlsList are not empty)
            let invalidUrls = [];
            if (homepageVal !== "" && urlsListVal !== "") {
                invalidUrls = validateUrlsAgainstHomepage(homepageVal, urlsListVal);
                if (invalidUrls.length > 0) {
                    const invalidCount = invalidUrls.length;
                    const errorMessage = `There are ${invalidCount} URL${invalidCount !== 1 ? 's' : ''} which ${invalidCount !== 1 ? 'are' : 'is'} not part of the root domain. Remove these urls to save the project. <a href="#" id="seeInvalidUrls" style="color: #C2282C; text-decoration: underline; cursor: pointer;">See URLs</a>`;
                    const alert = buildAlertNew(errorMessage);
                    urlsList.parent().append(alert);
                    hasErrors = true;
                    
                    // Store invalid URLs for modal
                    $('#invalidUrlsData').remove();
                    $('<div>').attr('id', 'invalidUrlsData').data('urls', invalidUrls).appendTo('body');
                    
                    // Handle click on "See URLs" link
                    $(document).off('click', '#seeInvalidUrls').on('click', '#seeInvalidUrls', function(e) {
                        e.preventDefault();
                        showInvalidUrlsModal(invalidUrls);
                    });
                }
            }

            // If any validation errors, stop here and show all errors
            if (hasErrors) {
                return false;
            }

            // Check if project name is unique
            if ($('#unique_name_project_valid').val() == 0) {
                // Trigger validation if not already done
                checkUniqueProjectName();
                return false;
            }

            // Check if homepage is unique
            if ($('#unique_homepage_project_valid').val() == 0) {
                // Trigger validation if not already done
                checkUniqueProjectHomepage();
                return false;
            }

            // Set the route to 'projects.create'.
            const route = "projects.create";

            // Store original button text and set loading state
            const createButton = $("#createProjectButton");
            const originalButtonText = createButton.html();
            createButton.prop('disabled', true);
            createButton.html('<span class="spinner-border spinner-border-sm me-2"></span>Creating Project...');

            // Make an AJAX request to create a project.
            // Get first line from xmlSitemap textarea
            const xmlSitemapValue = $("#xmlSitemap").val().split('\n')[0].trim();
            
            // Remove serial numbers from URLs list before sending
            let cleanedUrlsList = urlsList.val();
            cleanedUrlsList = removeSerialNumbersFromUrls(cleanedUrlsList);
            
            $.ajax({
                url: `/createProject`,
                type: 'POST',
                data: {
                    "name": name.val(),
                    "homepage": homepage.val(),
                    "xmlSitemap": xmlSitemapValue,
                    "urlsList": cleanedUrlsList,
                    "route": route,
                    "_method": 'POST',
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    if (data.status === 0) {
                        // Restore button on validation error
                        createButton.prop('disabled', false);
                        createButton.html(originalButtonText);
                        validate(data)
                    } else {
                        // Redirect to dashboard on success (button state will be reset on page load)
                        window.location = "/dashboard";
                    }
                },
                error: function() {
                    // Restore button on error
                    createButton.prop('disabled', false);
                    createButton.html(originalButtonText);
                }
            });
        });
    }

    // Edit Project Button Handler
    if (isEditPage) {
        $("#editProjectButton").click(function (e) {
            e.preventDefault();
            
            clearAlertsNew();
            let hasErrors = false;
            
            // Get field values
            const name = $("#name");
            const projectName = name.val().trim();
            const homepage = $("#homepage");
            const homepageVal = homepage.val().trim();
            const urlsList = $("#urlsList");
            const urlsListVal = urlsList.val().trim();
            
            // Validate project name is not empty
            if (projectName === "") {
                const alert = buildAlertNew('Project name can not be empty');
                name.parent().append(alert);
                hasErrors = true;
            }

            // Validate homepage is not empty
            if (homepageVal === "") {
                const alert = buildAlertNew('Project URL can not be empty');
                homepage.parent().append(alert);
                hasErrors = true;
            }

            // Validate URLs list is not empty
            if (urlsListVal === "") {
                const alert = buildAlertNew('List of urls can not be empty');
                urlsList.parent().append(alert);
                hasErrors = true;
            }

            // Validate all URLs belong to homepage domain (only if both homepage and urlsList are not empty)
            let invalidUrls = [];
            if (homepageVal !== "" && urlsListVal !== "") {
                invalidUrls = validateUrlsAgainstHomepage(homepageVal, urlsListVal);
                if (invalidUrls.length > 0) {
                    const invalidCount = invalidUrls.length;
                    const errorMessage = `There are ${invalidCount} URL${invalidCount !== 1 ? 's' : ''} which ${invalidCount !== 1 ? 'are' : 'is'} not part of the root domain. Remove these urls to save the project. <a href="#" id="seeInvalidUrlsEdit" style="color: #C2282C; text-decoration: underline; cursor: pointer;">See URLs</a>`;
                    const alert = buildAlertNew(errorMessage);
                    urlsList.parent().append(alert);
                    hasErrors = true;
                    
                    // Store invalid URLs for modal
                    $('#invalidUrlsDataEdit').remove();
                    $('<div>').attr('id', 'invalidUrlsDataEdit').data('urls', invalidUrls).appendTo('body');
                    
                    // Handle click on "See URLs" link
                    $(document).off('click', '#seeInvalidUrlsEdit').on('click', '#seeInvalidUrlsEdit', function(e) {
                        e.preventDefault();
                        showInvalidUrlsModal(invalidUrls);
                    });
                }
            }

            // If any validation errors, stop here and show all errors
            if (hasErrors) {
                return false;
            }

            // Check if project name is unique
            if ($('#unique_name_project_valid').val() == 0) {
                // Trigger validation if not already done
                checkUniqueProjectName();
                return false;
            }

            // Check if homepage is unique
            if ($('#unique_homepage_project_valid').val() == 0) {
                // Trigger validation if not already done
                checkUniqueProjectHomepage();
                return false;
            }

            // Perform form validation and prevent submission if validation fails.
            const validate = validateProjectForm();
            if (!validate) {
                return false;
            }
            
            // Get first line from xmlSitemap textarea
            const xmlSitemapValue = $("#xmlSitemap").val().split('\n')[0].trim();
            
            // Remove serial numbers from URLs list before sending
            let cleanedUrlsList = urlsList.val();
            cleanedUrlsList = removeSerialNumbersFromUrls(cleanedUrlsList);
            
            // Make an AJAX request to edit a project.
            $.ajax({
                url: '/editProject',
                type: 'POST',
                data: {
                    "name": name.val(),
                    "homepage": homepage.val(),
                    "xmlSitemap": xmlSitemapValue,
                    "urlsList": cleanedUrlsList,
                    "projectId": $('#projectId').val(),
                    "settingsSubId": $('#settingsSubId').val(),
                    "_method": 'POST',
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    if (data.status === 0) {
                        validate(data)
                    } else {
                        $("li.sitemap_li").remove();
                        displayAlert('.add_project_area', data)
                        scrollToTop()
                        activeProject(data.data, 'edit');
                        clearHtml()
                    }
                }
            });
        });
    }

});
