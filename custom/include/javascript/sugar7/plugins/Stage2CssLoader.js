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
    app.events.on('app:init', function() {
        var plugin = {
            /**
             * Load CSS files specified in component.css array.
             */
            onAttach: function() {
                this.loadCss();
            },

            /**
             * Load given CSS file paths.
             * @param {array} [cssFiles] - paths to css files
             */
            loadCss: function(cssFiles) {
                var $previouslyAdded;
                _.each(cssFiles || this.css, function(file) {
                    var $link;
                    if (!this.isCssLoaded(file)) {
                        if (file.indexOf('.css') === -1) {
                            file = file + '.css';
                        }
                        $link = $('<link>', {
                            href: 'custom/themes/basehint/' + file,
                            type: 'text/css',
                            rel: 'stylesheet'
                        });

                        if ($previouslyAdded) {
                            $previouslyAdded.after($link);
                        } else {
                            // We prepend instead of append so that styles in Styleguide is preferred over
                            // dynamically loaded CSS styles when they have equal specificity order.
                            $link.prependTo(document.head);
                        }

                        $previouslyAdded = $link;
                    }
                }, this);
            },

            /**
             * Is the given CSS file already loaded in the browser?
             * @param {string} href
             * @returns {boolean}
             */
            isCssLoaded: function(href) {
                return !!_.find(document.styleSheets, function(style) {
                    return style.href && (style.href.indexOf(href) !== -1);
                });
            }
        };

        plugin.loadCss.apply(plugin, [['../data-enrichment/hint-modules']]);
        app.plugins.register('Stage2CssLoader', ['layout', 'view', 'field'], plugin);
    });
})(SUGAR.App);
