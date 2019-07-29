/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
(function(app) {
    var clipboard;

    /**
     * Clears the clipboard alert before any view change.
     */
    app.events.once('app:init', function() {
        app.before('app:view:change', function() {
            app.alert.dismiss('clipboard');

            return true;
        });
    });

    /**
     * Triggers events with the "clipboard" namespace on the target element.
     *
     * @param {HTMLElement} target
     * @param {string} event
     * @param {Object} params
     */
    function triggerEvent(target, event, params) {
        $(target).trigger('clipboard.' + event, params);
    }

    /**
     * Enables the application to copy or cut text to the user's clipboard when
     * the user clicks on any element with the attribute
     * `data-clipboard="enabled"`.
     *
     * @example
     * Copy text from the data-clipboard-text attribute on the trigger element.
     * <button data-clipboard="enabled" data-clipboard-text="Copy this text">
     *     Copy
     * </button>
     *
     * @example
     * Copy the value from another element.
     * <input name="website" type="text" value="https://www.sugarcrm.com" />
     * <button data-clipboard="enabled" data-clipboard-target="[name=website]">
     *     Copy
     * </button>
     *
     * See {@link https://clipboardjs.com|clipboard.js} for more about its
     * declarative API using HTML5's data attributes.
     *
     * @class Clipboard
     * @alias SUGAR.App.clipboard
     * @singleton
     */
    app.augment('clipboard', {
        /**
         * Creates a ClipboardJS instance to listen for clicks on any element
         * with the attribute `data-clipboard="enabled"`. A success or error
         * alert is automatically shown when text is copied to the clipboard.
         *
         * A `clipboard.success` event is triggered on the clicked element when
         * the action is successful. Components can listen to this event on
         * their elements to perform additional logic.
         *
         * A `clipboard.error` event is triggered on the clicked element when
         * the action is unsuccessful. Components can listen to this event on
         * their elements to perform additional logic.
         *
         * Components can listen to the `clipboard` event on their elements to
         * handle all clipboard events the same.
         */
        init: function() {
            // The clipboard can't be initialized more than once.
            if (clipboard) {
                return;
            }

            clipboard = new ClipboardJS('[data-clipboard=enabled]');

            clipboard.on('success', function(evt) {
                app.alert.show('clipboard', {
                    level: 'success',
                    messages: app.lang.get('LBL_TEXT_COPIED_TO_CLIPBOARD_SUCCESS'),
                    autoClose: true
                });

                // Return focus to the element that was clicked.
                evt.clearSelection();

                triggerEvent(evt.trigger, 'success', evt);
            });

            clipboard.on('error', function(evt) {
                app.alert.show('clipboard', {
                    level: 'error',
                    messages: app.lang.get('LBL_TEXT_COPIED_TO_CLIPBOARD_ERROR'),
                });

                // Return focus to the element that was clicked.
                evt.clearSelection();

                triggerEvent(evt.trigger, 'error', evt);
            });
        },

        /**
         * Dispose of the clipboard to remove all DOM nodes and event listeners
         * that were added by ClipboardJS.
         *
         * Call {@link Clipboard#init} if you dispose of it and then need to
         * initialize the module again.
         */
        dispose: function() {
            if (clipboard) {
                clipboard.destroy();
                clipboard = undefined;
            }
        }
    }, false);
})(SUGAR.App);
