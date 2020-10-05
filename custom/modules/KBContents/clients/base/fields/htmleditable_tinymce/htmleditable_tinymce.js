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
/**
 * @class View.Fields.Base.Emails.Htmleditable_tinymceField
 * @alias SUGAR.App.view.fields.BaseEmailsHtmleditable_tinymceField
 * @extends View.Fields.Base.Htmleditable_tinymceField
 */
({
    extendsFrom: 'KBContentsHtmleditable_tinymceField',

    initialize: function (options) {
        this._super('initialize', [options]);

        app.events.on('data:sync:complete', function (method, model, options) {
            // Execute after 1 seconds (1000 milliseconds):
            if (this.tplName == 'preview') {
                setTimeout(_.bind(function () {
                    this.setViewContent(this.value);
                }, this), 250);
            }
        }, this);
    },

    /**
     * @inheritdoc
     *
     * Resize the field's container based on the height of the iframe content
     * for preview.
     */
    setViewContent: function (value) {
        var field;
        // Pad this to the final height due to the iframe margins/padding
        var padding = 25;
        var contentHeight = 0;

        this._super('setViewContent', [value]);

        // Only set this field height if it is in the preview pane
        if (this.tplName !== 'preview') {
            return;
        }

        contentHeight = this._getContentHeight() + padding;

        // Only resize the editor when the content is fully loaded
        if (contentHeight > padding) {
            // Set the maximum height to 400px
            if (contentHeight > 400) {
                contentHeight = 400;
            }

            field = this._getHtmlEditableField();
            field.css('height', contentHeight);
            field.css('margin-left', 0);
        }
    },

    /**
     * Get the content height of the field's iframe.
     *
     * @private
     * @return {number} Returns 0 if the iframe isn't found.
     */
    _getContentHeight: function () {
        var editable = this._getHtmlEditableField();

        if (this._iframeHasBody(editable)) {
            return editable.contents().find('body')[0].offsetHeight;
        }

        return 0;
    },

})
