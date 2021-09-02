/**
 * @class View.Fields.Base.CustomWordactionField
 * @alias SUGAR.App.view.fields.BaseCustomWordactionField
 * @extends View.Fields.Base.PdfactionField
 */
({
    extendsFrom: 'PdfactionField',

    /**
     * @inheritdoc
     * Create Word Template collection in order to get available template list.
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        this.templateCollection = app.data.createBeanCollection('Doc_Manager');
        this._fetchTemplate(true);
    },

    /**
     * @inheritdoc
     */
    _fetchTemplate: function (isFetch = false) {
        if (isFetch) {
            this.fetchCalled = true;
            var collection = this.templateCollection;
            collection.module = 'Doc_Manager';
            collection.filterDef = {'$and': [{
                        'base_module': this.module
                    }]};
            collection.fetch();
    }
    },

    /**
     * @inheritdoc
     */
    _buildDownloadLink: function (templateId) {
        var urlParams = $.param({
            'action': 'OnlyofficeTemplate',
            'module': this.module,
            'record': this.model.id,
            'onlyoffice_template_id': templateId,
            'save_note': true
        });
        return '?' + urlParams;
    }
})