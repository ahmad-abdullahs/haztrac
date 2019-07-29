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
    initialize: function(options) {
        this._super('initialize', [options]);
        this.templateCollection = app.data.createBeanCollection('word_templates');
        this._fetchTemplate(true);
    },

    /**
     * @inheritdoc
     */
    _fetchTemplate: function(isFetch = false) {
    	if (isFetch) {
	        this.fetchCalled = true;
	        var collection = this.templateCollection;
	        collection.module = 'word_templates';
	        collection.filterDef = {'$and': [{
	            'word_temp_module': this.module
	        }]};
	        collection.fetch();
    	}
    },

    /**
     * @inheritdoc
     */
    emailClicked: function(evt) {
        var templateId = this.$(evt.currentTarget).data('id');
        var urlParams = $.param({
            'entryPoint': 'WordView',
            'targetModule': this.module,
            'targetModuleId': this.model.id,
            'template_id': templateId
        });

        var url = window.location.href;
        url = url.split('#');
        window.open('https://docs.google.com/viewer?url=' + encodeURIComponent(url[0] + '?' + urlParams) + '&embedded=true&chrome=false&dov=1');
    },

    /**
     * @inheritdoc
     */
    _buildDownloadLink: function(templateId) {
        var urlParams = $.param({
            'action': 'WordTemplate',
            'module': this.module,
            'record': this.model.id,
            'template_id': templateId,
            'save_note': true
        });
        return '?' + urlParams;
    }
 })