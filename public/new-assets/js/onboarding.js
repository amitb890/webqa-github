$(document).ready(function(){

    class OnboardingController {
        constructor() {
            this.currentStep = 1;
            this.totalSteps = 5;
            this.formData = {};
            this.isProcessing = false;
            this.step = 1; // For image management
            this.maxExecutionTime = 600000; // 1 minute in milliseconds (easily changeable)
            this.activeRequests = []; // Track active requests
            this.activeTimeouts = []; // Track active timeouts
            this.init();
        }

        init() {
            this.bindEvents();
            this.updateProgressIndicator();
            this.updateButtonStates();
        }

        bindEvents() {
            // Next button events
            $("#formTriggerBtn1").click(() => this.handleNext(1));
            $("#formTriggerBtn2").click(() => this.handleNext(2));
            $("#formTriggerBtn3").click(() => this.handleNext(3));
            $("#formTriggerBtn4").click(() => this.handleNext(4));

            // Previous button events
            $("#BtnPrev1").click(() => this.handlePrevious(2));
            $("#BtnPrev2").click(() => this.handlePrevious(3));
            $("#BtnPrev3").click(() => this.handlePrevious(4));

            // Skip button events
            $("#BtnSkip1").click(() => this.handleSkip(2));
            $("#BtnSkip2").click(() => this.handleSkip(3));

            // Finish button
            $("#finishOnboarding").click(() => this.handleFinish());

            // Auto-populate project name from homepage URL
            $("#homepage").on('input', () => {
                const url = $("#homepage").val();
                const domainName = this.extractDomainName(url);
                if (domainName) {
                    $("#name").val(domainName);
                }
                this.clearErrorMessages();
                this.updateButtonStates();
            });

            // Form input events - clear errors when user starts typing
            $("#xmlSitemap, #urlsList, #name").on('input', () => {
                this.clearErrorMessages();
                // Update button states for real-time validation
                this.updateButtonStates();
            });

            // Load more sitemaps functionality
            $(document).on('click', '.load-more-sitemap-dropdown', (e) => {
                e.preventDefault();
                $('.sitemap-link.d-none').toggleClass('d-none');
                const loadMoreBtn = $(e.target).closest('.load-more-sitemap');
                const isExpanded = !$('.sitemap-link.d-none').length;
                loadMoreBtn.find('span').text(isExpanded ? 'Show Less' : 'Load All');
            });
        }

        async handleNext(stepNumber) {
            if (this.isProcessing) return;
            
            // Validate current step before proceeding
            if (!this.validateCurrentStep()) {
                return;
            }

            // Collect form data from current step
            this.collectStepData(stepNumber - 1);

            try {
                // Handle step-specific async operations
                switch(stepNumber) {
                    case 1:
                        // Show loading state on formTriggerBtn1
                        this.setButtonLoadingState('formTriggerBtn1', true);
                        await this.detectSitemaps(this.formData.homepage);
                        // Hide loading state on formTriggerBtn1
                        this.setButtonLoadingState('formTriggerBtn1', false);
                        break;
                    case 2:
                        // Show loading state on formTriggerBtn2
                        this.setButtonLoadingState('formTriggerBtn2', true);
                        // Get sitemaps from sitemapInput (stored during sitemap detection)
                        const sitemapsData = $('#sitemapInput').val();
                        const sitemaps = sitemapsData ? JSON.parse(sitemapsData) : [];
                        await this.detectUrls(sitemaps);
                        // Hide loading state on formTriggerBtn2
                        this.setButtonLoadingState('formTriggerBtn2', false);
                        break;
                    default:
                        break;
                }

                // Move to next step only after async operations complete
                this.goToStep(stepNumber + 1);
            } catch (error) {
                console.error('Error in step processing:', error);
                // Hide loading state on error based on current step
                if (stepNumber === 1) {
                    this.setButtonLoadingState('formTriggerBtn1', false);
                } else if (stepNumber === 2) {
                    this.setButtonLoadingState('formTriggerBtn2', false);
                }
                // Show error message to user
                this.showErrorMessages(['An error occurred. Please try again.']);
            }
        }

        async detectUrls(selectedSitemaps) {
            // Clear existing URLs list
            $("#urlsList").html("");
            
            // If no sitemap selected, use homepage
            if (!selectedSitemaps || selectedSitemaps.length === 0) {
                $("#urlsList").html($('#homepage').val());
                // Show alert for limited URLs
                this.showLimitedUrlsAlert();
                return;
            }

            const controller = new AbortController();
            this.addActiveRequest(controller);

            try {
                // Set up timeout
                const timeoutId = setTimeout(() => {
                    controller.abort();
                    console.log('URL detection timed out after', this.maxExecutionTime, 'ms');
                }, this.maxExecutionTime);
                this.addActiveTimeout(timeoutId);

                let res = await fetch('/onboarding/fetch-urls', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ sitemaps: selectedSitemaps }),
                    signal: controller.signal
                });
                
                // Clear timeout since request completed
                clearTimeout(timeoutId);
                this.removeActiveTimeout(timeoutId);
                
                if (!res.ok) {
                    if (res.status === 403) {
                        throw new Error('FORBIDDEN_403');
                    }
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                
                let data = await res.json();
                console.log('Total URLs:', data.count, data.urls);
                
                // Process URLs similar to getUrlsList function
                if (data.urls && data.urls.length > 0) {
                    let list = "";
                    data.urls.forEach((url, i) => {
                        list += i === data.urls.length - 1 ? url.trim() : url.trim() + "\n";
                    });
                    $("#urlsList").html(list);
                    
                    // Check if only 1 URL was detected
                    if (data.urls.length === 1) {
                        // Show warning for single URL
                        this.showLimitedUrlsAlert();
                    } else {
                        // Show success message in formSetp3 for multiple URLs
                        this.showUrlsSuccessMessage(data.urls.length);
                        
                        // Update UI with success message
                        $(".form-single-text").removeClass("warning").addClass("success");
                        $('.xml-sitemap-message').html('Detected ' + data.urls.length + ' URLs from the XML Sitemap');
                        $('.form-single-text').css({display: "flex"});
                        $(".sitemap-link").remove();
                        $(".load-more-sitemap").remove();
                    }
                } else {
                    // No URLs detected - add root URL
                    const rootUrl = $('#homepage').val();
                    $("#urlsList").html(rootUrl);
                    // Show alert for limited URLs
                    this.showLimitedUrlsAlert();
                }
                
                return data.urls;
                
            } catch (error) {
                // Clear timeout on error
                this.activeTimeouts.forEach(id => clearTimeout(id));
                this.activeTimeouts = [];
                
                console.error('Error fetching URLs:', error);
                
                if (error.name === 'AbortError') {
                    console.log('URL detection was aborted or timed out');
                    // Add root URL as fallback
                    const rootUrl = $('#homepage').val();
                    $("#urlsList").html(rootUrl);
                    // Show alert for limited URLs
                    this.showLimitedUrlsAlert();
                } else if (error.message === 'FORBIDDEN_403') {
                    console.log('URL detection forbidden (403)');
                    // Show 403 error message
                    this.showUrls403Error();
                } else {
                    // Fallback on error - add root URL
                    const rootUrl = $('#homepage').val();
                    $("#urlsList").html(rootUrl);
                    // Show alert for limited URLs
                    this.showLimitedUrlsAlert();
                }
                
                return [];
            } finally {
                this.removeActiveRequest(controller);
            }
        }

        async detectSitemaps(homepage) {
            const controller = new AbortController();
            this.addActiveRequest(controller);

            try {
                // Set up timeout
                const timeoutId = setTimeout(() => {
                    controller.abort();
                    console.log('Sitemap detection timed out after', this.maxExecutionTime, 'ms');
                }, this.maxExecutionTime);
                this.addActiveTimeout(timeoutId);

                const response = await fetch('/onboarding/detect-sitemaps', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    body: JSON.stringify({ root_url: homepage }),
                    signal: controller.signal
                });
                
                // Clear timeout since request completed
                clearTimeout(timeoutId);
                this.removeActiveTimeout(timeoutId);
                
                if (!response.ok) {
                    if (response.status === 403) {
                        throw new Error('FORBIDDEN_403');
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Sitemap detection result:', data);
                
                // Process sitemap data using the same logic as main.js
                this.updateSitemapInputsServer(data.sitemaps || [], homepage);
                
                return data;
            } catch (error) {
                // Clear timeout on error
                this.activeTimeouts.forEach(id => clearTimeout(id));
                this.activeTimeouts = [];
                
                if (error.name === 'AbortError') {
                    console.log('Sitemap detection was aborted or timed out');
                    // Add fallback - just add the homepage as a basic sitemap
                    this.updateSitemapInputsServer([], homepage);
                } else if (error.message === 'FORBIDDEN_403') {
                    console.log('Sitemap access forbidden (403)');
                    // Show 403 error message
                    this.showSitemap403Error();
                } else {
                    throw error;
                }
            } finally {
                this.removeActiveRequest(controller);
            }
        }

        updateSitemapInputsServer(xmlSitemap, url) {
            $(".sitemap-link").remove();
            $(".load-more-sitemap").remove();
            
            const websiteAddress = this.removeTrailingSlash($("#homepage").val());
            $('.xml-sitemap-message').empty();
            $('.form-single-text').hide();
            
            if (xmlSitemap.length == 0) {
                $(".form-single-text").addClass("warning");
                $('.xml-sitemap-message').text("We could not autodetect an XML Sitemap on your website. This might be because the sitemap returnd a 403/404. Please enter your XML Sitemap in 'Enter Sitemap XML field");
                $('.form-single-text').css({display: "flex"});
            } else {
                const sitemapJson = JSON.stringify(xmlSitemap);
                $("#xmlSitemap").val(xmlSitemap[0]);
                let msg;
                xmlSitemap.length > 1 ? msg = `We have autodetected ${xmlSitemap.length} main XML Sitemaps on your website at` : msg = "We have autodetected an XML Sitemap on your website at";
                $(".form-single-text").removeClass("success");
                $(".form-single-text").removeClass("warning");
                $('.xml-sitemap-message').html(msg);

                $('.form-single-text').css({display: "flex"});
                
                if(xmlSitemap.length > 4) {
                    $.each(xmlSitemap, function(index, value) {
                        if(index > 3) {
                            $('.form-single-text').append('<a class="sitemap-link d-none" target="_blank" href="' + value + '">' + value + '</a>');
                        } else {
                            $('.form-single-text').append('<a class="sitemap-link" target="_blank" href="' + value + '">' + value + '</a>');
                        }
                    });

                    const div = document.createElement("div");
                    div.classList.add("load-more-sitemap");
                    div.innerHTML = `<a class="dropdown-toggle load-more-sitemap-dropdown" href="#" role="button">
                    <span>Load All</span>
                    </a>`;

                    $('.form-single-text').append(div);
                } else {
                    $.each(xmlSitemap, function(index, value) {
                        $('.form-single-text').append('<a class="sitemap-link" target="_blank" href="' + value + '">' + value + '</a>');
                    });
                }
                $('#sitemapInput').val(sitemapJson);
            }
        }

        removeTrailingSlash(str) {
            return str.endsWith('/') ? str.slice(0, -1) : str;
        }

        prevImg() {
            this.step = this.step - 1;
            $("#onboardingImg").attr(
                "src",
                `/new-assets/assets/images/onboarding-img-${this.step}.png`
            );
        }

        nextImg() {
            this.step = this.step + 1;
            $("#onboardingImg").attr(
                "src",
                `/new-assets/assets/images/onboarding-img-${this.step}.png`
            );
        }

        // Request and timeout management methods
        addActiveRequest(controller) {
            this.activeRequests.push(controller);
        }

        removeActiveRequest(controller) {
            const index = this.activeRequests.indexOf(controller);
            if (index > -1) {
                this.activeRequests.splice(index, 1);
            }
        }

        addActiveTimeout(timeoutId) {
            this.activeTimeouts.push(timeoutId);
        }

        removeActiveTimeout(timeoutId) {
            const index = this.activeTimeouts.indexOf(timeoutId);
            if (index > -1) {
                this.activeTimeouts.splice(index, 1);
            }
        }

        stopAllExecutions() {
            // Abort all active requests
            this.activeRequests.forEach(controller => {
                if (controller && controller.abort) {
                    controller.abort();
                }
            });
            this.activeRequests = [];

            // Clear all active timeouts
            this.activeTimeouts.forEach(timeoutId => {
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
            });
            this.activeTimeouts = [];

            // Reset processing state
            this.isProcessing = false;
            this.updateButtonStates();
        }


        handlePrevious(stepNumber) {
            // Stop all executions and reset to previous screen
            this.stopAllExecutions();
            
            // Reset button states
            this.resetAllButtons();
            
            // Go to previous step
            this.goToStep(stepNumber - 1);
        }

        resetAllButtons() {
            // Reset all button states to initial
            $('.onbordingButtonClass').prop('disabled', false);
            $('#formTriggerBtn1, #formTriggerBtn2, #formTriggerBtn3, #formTriggerBtn4').text('Next');
            $('#BtnSkip1, #BtnSkip2').text('Skip');
        }

        showSitemap403Error() {
            $(".form-single-text").addClass("warning");
            $('.xml-sitemap-message').text('Your sitemap returned a 403 Forbidden error and cannot be accessed. Please enter your sitemap URL manually in the XML Sitemap field.');
            $('.form-single-text').css({display: "flex"});
            $(".sitemap-link").remove();
            $(".load-more-sitemap").remove();
        }

        showUrls403Error() {
            // Add root URL as fallback and show 403 message
            const rootUrl = $('#homepage').val();
            $("#urlsList").html(rootUrl);
            // Show alert for limited URLs
            this.showLimitedUrlsAlert();
        }

        showLimitedUrlsAlert() {
            // Clear any existing alerts first
            $('#formSetp3 .alert').remove();
            
            // Show form-single-text warning
            $(".form-single-text").removeClass("success").addClass("warning");
            $('.xml-sitemap-message').text("We could not autodetect an XML Sitemap on your website. This might be because the sitemap returned a 403/404. Please enter your XML Sitemap in 'Enter Sitemap XML field'");
            $('.form-single-text').css({display: "flex"});
            
            // Show warning alert for limited URLs using webqa__alert styling
            const warningAlert = buildAlert({
                msg: 'We could not autodetect an XML Sitemap on your website. This might be because the sitemap returned a 403/404. Only the root URL has been added. You can add more URLs manually if needed.',
                status: 0
            });
            $('#urlsList')[0].parentElement.appendChild(warningAlert);
        }

        showUrlsSuccessMessage(urlCount) {
            // Clear any existing alerts first
            $('#formSetp3 .alert').remove();
            
            // Show success message for URLs detected using webqa__alert styling
            const successAlert = buildAlert({
                msg: `Successfully detected ${urlCount} URLs from your sitemap and added them to the list.`,
                status: 1
            });
            $('#urlsList')[0].parentElement.appendChild(successAlert);
        }

        async handleSkip(stepNumber) {
            if (this.isProcessing) return;
            this.collectStepData(stepNumber - 1);
            
            // If skipping from step 2 (XML sitemap), run URL detection
            if (stepNumber === 2) {
                try {
                    // Show loading state on skip button
                    this.setButtonLoadingState('BtnSkip1', true);
                    
                    // Get sitemaps from sitemapInput (stored during sitemap detection)
                    const sitemapsData = $('#sitemapInput').val();
                    const sitemaps = sitemapsData ? JSON.parse(sitemapsData) : [];
                    await this.detectUrls(sitemaps);
                    
                    // Hide loading state on skip button
                    this.setButtonLoadingState('BtnSkip1', false);
                } catch (error) {
                    console.error('Error in skip URL detection:', error);
                    this.setButtonLoadingState('BtnSkip1', false);
                    this.showErrorMessages(['Error processing URLs. Please try again.']);
                    return;
                }
            }
            
            this.goToStep(stepNumber + 1);
        }

        handleFinish() {
            if (this.isProcessing) return;
            this.collectStepData(4);
            this.finishOnboarding();
        }

        finishOnboarding() {
            // Get form data
            const name = $("#name").val();
            const homepage = $("#homepage").val();
            const xmlSitemap = $("#xmlSitemap").val();
            const urlsList = $("#urlsList").val();
            
            // Convert XML sitemap array to comma-separated string
            const sitemapsData = $('#sitemapInput').val();
            let xmlSitemapString = xmlSitemap; // Default to single sitemap
            
            if (sitemapsData) {
                try {
                    const sitemapsArray = JSON.parse(sitemapsData);
                    xmlSitemapString = sitemapsArray[0]
                } catch (error) {
                    console.error('Error parsing sitemaps data:', error);
                    // Fallback to single sitemap value
                }
            }

            // Show finish button loading state
            this.setFinishButtonLoadingState(true);

            // Submit form data
            $.ajax({
                url: '/createProject',
                type: 'POST',
                data: {
                    "name": name,
                    "homepage": homepage,
                    "xmlSitemap": xmlSitemapString,
                    "htmlSitemap": "", // Not used in current flow
                    "urlsList": urlsList,
                    "route": "onboarding",
                    "_method": 'POST',
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                },
                success: (data) => {
                    // Keep loading state until redirect
                    // Redirect to dashboard on success
                    window.location = "/dashboard";
                },
                error: (error) => {
                    console.error('Error creating project:', error);
                    this.setFinishButtonLoadingState(false);
                    this.showErrorMessages(['Error creating project. Please try again.']);
                }
            });
        }

        setFinishButtonLoadingState(isLoading) {
            const finishButton = $("#finishOnboarding");
            
            if (isLoading) {
                finishButton.prop('disabled', true);
                finishButton.html('<span class="spinner-border spinner-border-sm me-2"></span>Creating Project...');
            } else {
                finishButton.prop('disabled', false);
                finishButton.text('Finish');
            }
        }

        goToStep(stepNumber) {
            if (stepNumber < 1 || stepNumber > this.totalSteps) return;

            // Hide sitemap message when navigating away from step 2
            if (this.currentStep === 2 && stepNumber !== 2) {
                $('.form-single-text').hide();
            }

            // Update image based on step direction
            if (stepNumber > this.currentStep) {
                this.nextImg();
            } else if (stepNumber < this.currentStep) {
                this.prevImg();
            }

            // Hide all steps
            $('.form-setp').removeClass('active').hide();

            // Show current step
            $(`#formSetp${stepNumber}`).addClass('active').show();

            // Update current step
            this.currentStep = stepNumber;

            // Update progress indicator
            this.updateProgressIndicator();

            // Update button states
            this.updateButtonStates();

            // Update project name in final step
            if (stepNumber === 5) {
                $('#projectName').text(this.formData.name || '');
            }
        }

        validateCurrentStep() {
            const currentStepElement = $(`#formSetp${this.currentStep}`);
            
            // Clear any existing error messages
            this.clearErrorMessages();
            
            // Check required fields in current step
            const requiredInputs = currentStepElement.find('input[required], textarea[required]');
            let isValid = true;
            let errorMessages = [];

            requiredInputs.each(function() {
                if (!$(this).val().trim()) {
                    isValid = false;
                    const fieldName = $(this).attr('data-name') || $(this).attr('name') || 'This field';
                    errorMessages.push(`${fieldName} is required`);
                }
            });

            // Special validation for URL fields
            if (this.currentStep === 1) {
                const url = $('#homepage').val();
                if (url && !this.isValidUrl(url)) {
                    isValid = false;
                    errorMessages.push('Please enter a valid homepage URL (e.g., https://example.com). Files and direct paths are not allowed.');
                }
            }

            // Special validation for URLs list (Step 3)
            if (this.currentStep === 3) {
                const urlsList = $('#urlsList').val().trim();
                if (!urlsList) {
                    isValid = false;
                    errorMessages.push('URLs list is required');
                } else {
                    // Check if there's at least one valid URL
                    const urls = urlsList.split('\n').filter(url => url.trim());
                    const hasValidUrl = urls.some(url => this.isValidUrl(url.trim()));
                    
                    if (!hasValidUrl) {
                        isValid = false;
                        errorMessages.push('Please enter at least one valid URL');
                    }
                }
            }

            // Show error messages if validation fails
            if (!isValid) {
                this.showErrorMessages(errorMessages);
            }

            return isValid;
        }

        clearErrorMessages() {
            $('.invalid-feedback').remove();
        }

        showErrorMessages(messages) {
            const currentStepElement = $(`#formSetp${this.currentStep}`);
            const errorHtml = buildAlertNew(messages.join('<br>'));
            currentStepElement.find('.form-card-input').after(errorHtml);
        }

        isValidUrl(string) {
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
                
                // For homepage validation in step 1, ensure it's not pointing to a specific file
                if (this.currentStep === 1) {
                    const pathname = urlObj.pathname;
                    // Check if pathname ends with common file extensions
                    const fileExtensions = ['.txt', '.xml', '.html', '.htm', '.php', '.pdf', '.doc', '.docx', '.jpg', '.jpeg', '.png', '.gif', '.css', '.js', '.json'];
                    const hasFileExtension = fileExtensions.some(ext => pathname.toLowerCase().endsWith(ext));
                    
                    if (hasFileExtension) {
                        return false;
                    }
                }
                
                return true;
            } catch (_) {
                return false;
            }
        }

        extractDomainName(url) {
            try {
                // Parse the URL
                const urlObj = new URL(url);
                let hostname = urlObj.hostname;
                
                // Remove 'www.' prefix if present
                hostname = hostname.replace(/^www\./, '');
                
                // Extract the domain name (without TLD)
                // Split by dots and get the first part (main domain)
                const parts = hostname.split('.');
                
                // If there are multiple parts, return the second-to-last part
                // (handles cases like example.co.uk)
                if (parts.length >= 2) {
                    return parts[0];
                }
                
                return hostname;
            } catch (error) {
                // If URL is invalid or incomplete, return empty string
                return '';
            }
        }

        collectStepData(stepNumber) {
            switch(stepNumber) {
                case 0: // Step 1
                    this.formData.homepage = $('#homepage').val();
                    break;
                case 1: // Step 2
                    this.formData.xmlSitemap = $('#xmlSitemap').val();
                    break;
                case 2: // Step 3 (now URLs list)
                    this.formData.urlsList = $('#urlsList').val();
                    break;
                case 3: // Step 4 (now project name)
                    this.formData.name = $('#name').val();
                    break;
            }
        }

        updateProgressIndicator() {
            // Update progress dots
            $('.progress-dot').removeClass('active');
            for (let i = 1; i <= this.currentStep; i++) {
                $(`.progress-dot:nth-child(${i + 1})`).addClass('active');
            }

            // Update progress line
            const progressPercentage = ((this.currentStep - 1) / (this.totalSteps - 1)) * 100;
            $('.progress-line').css('width', `${progressPercentage}%`);
        }

        updateButtonStates() {
            // Disable all next buttons initially
            $('.onbordingButtonClass').prop('disabled', true);

            // Enable next button only if not processing
            if (!this.isProcessing) {
                $(`#formTriggerBtn${this.currentStep}`).prop('disabled', false);
            }

            // Enable previous buttons (except on first step)
            if (this.currentStep > 1) {
                $(`#BtnPrev${this.currentStep - 1}`).prop('disabled', false);
            }

            // Enable skip buttons (except on last step and when processing)
            if (!this.isProcessing && this.currentStep < this.totalSteps - 1) {
                if (this.currentStep === 2) {
                    $('#BtnSkip1').prop('disabled', false);
                } else if (this.currentStep === 3) {
                    // Only enable skip if URLs list has valid content
                    const urlsList = $('#urlsList').val().trim();
                    if (urlsList) {
                        const urls = urlsList.split('\n').filter(url => url.trim());
                        const hasValidUrl = urls.some(url => this.isValidUrl(url.trim()));
                        if (hasValidUrl) {
                            $('#BtnSkip2').prop('disabled', false);
                        }
                    }
                }
            }
        }

        setProcessingState(isProcessing) {
            this.isProcessing = isProcessing;
            this.updateButtonStates();
            
            if (isProcessing) {
                $('.onbordingButtonClass').html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');
            } else {
                // Reset button texts
                $('#formTriggerBtn1, #formTriggerBtn2, #formTriggerBtn3, #formTriggerBtn4').text('Next');
                $('#BtnSkip1, #BtnSkip2').text('Skip');
            }
        }

        setButtonLoadingState(buttonId, isLoading) {
            const button = $(`#${buttonId}`);
            
            if (isLoading) {
                button.prop('disabled', true);
                let loadingText = 'Processing...';
                
                // Set specific loading text based on button
                if (buttonId === 'formTriggerBtn1') {
                    loadingText = 'Detecting sitemaps...';
                } else if (buttonId === 'formTriggerBtn2') {
                    loadingText = 'Extracting URLs...';
                } else if (buttonId === 'BtnSkip1') {
                    loadingText = 'Extracting URLs...';
                }
                
                button.html(`<span class="spinner-border spinner-border-sm me-2"></span>${loadingText}`);
            } else {
                button.prop('disabled', false);
                // Reset to appropriate text based on button type
                if (buttonId.startsWith('BtnSkip')) {
                    button.text('Skip');
                } else {
                    button.text('Next');
                }
            }
        }

    }

    class UI {
        static init() {
            UI.adjustMainSectionsPadding();
        }

        static adjustMainSectionsPadding() {
            $(".main-sections").css("paddingBlock", `${$("#headerMain").height()}px`);

            $(window).on("resize", function () {
                $(".main-sections").css("paddingBlock", `${$("#headerMain").height()}px`);
            });
        }
    }

    // Initialize the application
    UI.init();

    // Initialize onboarding controller
    const onboardingController = new OnboardingController();

});