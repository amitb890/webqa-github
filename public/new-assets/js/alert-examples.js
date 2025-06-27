/**
 * AlertManager Usage Examples
 * 
 * This file demonstrates how to use the new unified AlertManager system
 * throughout the frontend for consistent and efficient alert handling.
 */

// Example 1: Basic usage
AlertManager.show("#container", "This is a basic alert");

// Example 2: Success alert
AlertManager.success("#container", "Operation completed successfully!");

// Example 3: Error alert that doesn't auto-hide
AlertManager.error("#container", "Something went wrong!", {
    autoHide: false
});

// Example 4: Warning alert with custom duration
AlertManager.warning("#container", "Please review your input", {
    duration: 5000
});

// Example 5: Info alert positioned after an element
AlertManager.info("#urlValue", "duplicates were removed", {
    position: AlertManager.positions.AFTER,
    autoHide: true,
    duration: 3000
});

// Example 6: Custom alert with specific styling
AlertManager.custom("#container", "Custom styled message", {
    type: AlertManager.types.CUSTOM
});

// Example 7: Form validation - show error after input field
AlertManager.error("#emailInput", "Please enter a valid email address", {
    position: AlertManager.positions.AFTER,
    autoHide: false
});

// Example 8: Success message at the top of a container
AlertManager.success(".dashboard-content", "Dashboard updated successfully!", {
    position: AlertManager.positions.TOP,
    prepend: true
});

// Example 9: Clear all alerts from a container
AlertManager.clear("#container");

// Example 10: Convenience method for after element
AlertManager.afterElement("#urlValue", "URL processed successfully");

// Example 11: Before element positioning
AlertManager.beforeElement("#submitButton", "Please review before submitting", {
    type: AlertManager.types.WARNING
});

/**
 * Common Use Cases:
 * 
 * 1. Form Validation:
 *    AlertManager.error("#emailInput", "Invalid email format", {
 *        position: AlertManager.positions.AFTER,
 *        autoHide: false
 *    });
 * 
 * 2. Success Messages:
 *    AlertManager.success("#container", "Data saved successfully!");
 * 
 * 3. Warning Messages:
 *    AlertManager.warning("#container", "Please check your input", {
 *        duration: 5000
 *    });
 * 
 * 4. Info Messages:
 *    AlertManager.info("#container", "Processing your request...", {
 *        autoHide: false
 *    });
 * 
 * 5. Error Messages:
 *    AlertManager.error("#container", "An error occurred", {
 *        autoHide: false
 *    });
 * 
 * 6. Clear Alerts:
 *    AlertManager.clear("#container");
 * 
 * Configuration Options:
 * - type: 'success', 'error', 'warning', 'info', 'custom'
 * - position: 'top', 'bottom', 'after', 'before', 'replace'
 * - autoHide: true/false
 * - duration: milliseconds (default: 3000)
 * - dismissible: true/false (default: true)
 * - prepend: true/false (default: true for top position)
 */ 