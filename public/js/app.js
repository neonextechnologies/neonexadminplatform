/**
 * Action Router - jQuery-based action delegation system
 * 
 * Convention: Use data-action attribute to bind actions
 * Pattern: data-action="moduleName.actionName"
 * 
 * Example:
 * <button data-action="users.delete" data-id="123">Delete</button>
 * 
 * Phase 0A: Core action router convention
 * Layer A: Plain jQuery + Bootstrap (no build required)
 */

(function($) {
    'use strict';

    // Action registry
    const actions = {};

    /**
     * Register an action handler
     * 
     * @param {string} name - Action name (e.g., 'users.delete')
     * @param {function} handler - Action handler function
     */
    window.registerAction = function(name, handler) {
        if (actions[name]) {
            console.warn(`Action "${name}" is already registered. Overwriting.`);
        }
        actions[name] = handler;
    };

    /**
     * Trigger an action
     * 
     * @param {string} name - Action name
     * @param {jQuery} $element - Triggering element
     * @param {Event} event - Original event
     */
    function triggerAction(name, $element, event) {
        if (!actions[name]) {
            console.error(`Action "${name}" is not registered.`);
            return;
        }

        // Get action data from element
        const data = $element.data();
        
        // Call action handler
        actions[name].call($element[0], data, event, $element);
    }

    /**
     * Initialize action router
     */
    function initActionRouter() {
        // Delegate click events for elements with data-action
        $(document).on('click', '[data-action]', function(e) {
            const $this = $(this);
            const action = $this.data('action');
            
            if (!action) {
                return;
            }

            // Prevent default for links and buttons
            if ($this.is('a') || $this.is('button')) {
                e.preventDefault();
            }

            triggerAction(action, $this, e);
        });

        // Delegate change events for selects/inputs with data-action-change
        $(document).on('change', '[data-action-change]', function(e) {
            const $this = $(this);
            const action = $this.data('action-change');
            
            if (!action) {
                return;
            }

            triggerAction(action, $this, e);
        });

        // Delegate submit events for forms with data-action-submit
        $(document).on('submit', '[data-action-submit]', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const action = $this.data('action-submit');
            
            if (!action) {
                return;
            }

            triggerAction(action, $this, e);
        });
    }

    /**
     * Helper: Show Bootstrap toast
     * 
     * @param {string} message - Toast message
     * @param {string} type - Toast type (success, danger, warning, info)
     */
    window.showToast = function(message, type = 'success') {
        const iconMap = {
            success: 'check-circle',
            danger: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };

        const icon = iconMap[type] || 'info-circle';
        const bgClass = `bg-${type}`;

        const toastHtml = `
            <div class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-${icon} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

        // Append to toast container or create one
        let $container = $('#toast-container');
        if (!$container.length) {
            $container = $('<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3"></div>');
            $('body').append($container);
        }

        const $toast = $(toastHtml);
        $container.append($toast);

        const toast = new bootstrap.Toast($toast[0], { autohide: true, delay: 3000 });
        toast.show();

        // Remove toast element after hidden
        $toast.on('hidden.bs.toast', function() {
            $toast.remove();
        });
    };

    /**
     * Helper: Show Bootstrap alert
     * 
     * @param {string} message - Alert message
     * @param {string} type - Alert type (success, danger, warning, info)
     * @param {string} target - Target selector to prepend alert
     */
    window.showAlert = function(message, type = 'success', target = '.card-body') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        $(target).prepend(alertHtml);
    };

    /**
     * Helper: Confirm action with modal
     * 
     * @param {string} message - Confirmation message
     * @param {function} callback - Callback if confirmed
     */
    window.confirmAction = function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    };

    // Initialize on document ready
    $(function() {
        initActionRouter();
        console.log('✅ Action Router initialized (Phase 0A)');
    });

})(jQuery);
