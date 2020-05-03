/**
 * Controller File
 * Custom subpanel_field Type Field
 */
({
    extendsFrom: 'BaseField',

    events: {
        'click .trigger_previewrow': 'previewPdf',
        'click .toggle-all': 'toggleAll',
        'click .toggle-single': 'checktoggleAll',
    },

    filteredCollection: null,
    columns: null,
    columnsMeta: null,
    colOption: {},
    pdfs: {},
    subpanelModule: null,
    filters: [],
    unixTimeSuffix: '',
    allqueued: true,

    initialize: function (options) {
        this._super('initialize', [options]);
        this._initCollection();

        this.columns = this.def.columns;
        this.subpanelModule = this.def.relatedModule;
        this.filteredCollection = new Backbone.Collection();
        this.columnsMeta = this.getColumnsMeta();
        this.fetchRecords();

        this.unixTimeSuffix = app.date().unix();

        this.model.on('data:sync:complete', function () {
            this.reRenderView();
        }, this);
    },

    _initCollection: function () {
        var self = this;

        var collection = App.data.createBeanCollection('PdfManager');
        this.colOption = {
            'showAlerts': false,
            'fields': ['id', 'name', 'pdf_template_type_id', 'pdf_template_type_name'],
            'limit': -1,
            'success': _.bind(function (data, response) {
                for (var i in response) {
                    var model = app.data.createBean(this.subpanelModule, response[i]);
                    model.template = "detail";

                    if (self.view.layout.jsonFieldStructure[model.get('id')]) {
                        model.set('queued', true);
                        self.pdfs[model.get('id')] = true;
                    } else {
                        model.set('queued', false);
                        self.pdfs[model.get('id')] = false;
                        self.allqueued = false;
                    }

                    model.set('default_printer', self.view.printer_setting[model.get('pdf_template_type_id')] || '');

                    self.filteredCollection.add(model);

                    // The moment we fetched the collection, we send the API calls for Pdf generation 
                    // And putting the pdf in the pdfs/ directory, So that user can make use of that later 
                    // for preview purposes.
                    self.generateAndPutToPdfsDir(model);
                }

                if (!response.length)
                    self.allqueued = false;

                self._render();
            }, this)
        };

        collection.filterDef = [{
                pdf_template_type_id: {
                    // Filter for each field ['Work Order', 'Manifest', 'Label', 'BOI' ...]
                    $equals: this.viewDefs.filterVal,
                }
            }];

        this.collection = collection;
    },

    /**
     * Override to only show edit template. 
     **/
    _loadTemplate: function () {
        this._super('_loadTemplate');
        var template = app.template.getField(this.type, 'detail', this.model.module);
        this.template = template || this.template;
    },

    /**
     * Get each field meta from model vardefs
     */
    getColumnsMeta: function () {
        var meta = new Array;
        var fieldsDef = app.metadata.getModule(this.subpanelModule, "fields");
        _.each(this.columns, function (fieldViewMeta) {
            var fieldVardef = App.utils.deepCopy(fieldsDef[fieldViewMeta.name] || {});
            var fieldMeta = _.extend(fieldVardef, fieldViewMeta);
            meta.push(fieldMeta);
        }, this);
        return meta;
    },

    /**
     * Refetch subpanel data and render view.
     */
    reRenderView: function () {
        this.filteredCollection = new Backbone.Collection();
        this.fetchRecords();
    },

    /**
     * Render subpanel view and its inner fields.
     */
    _render: function () {
        if (_.isNull(this.el))
            return;

        this._super('_render');
        this.renderSubpanelFields();
    },

    /**
     * Render subpanel fields by getting their sfuuid.
     */
    renderSubpanelFields: function () {
        var self = this;
        $('.rowcell>span[sfuuid]').each(function () {
            var $this = $(this),
                    sfId = $this.attr('sfuuid');
            var field = self.view.fields[sfId];
            if (field) {
                field.setElement($this || self.$("span[sfuuid='" + sfId + "']"));
                field.listControlField = true;
                try {
                    field.render();
                } catch (e) {
                }
            }
        });

        // This is added for a specific reason, otherwise the first click on checkbox does not work.
        $('[name=all_check]').change();
    },

    /**
     * Fetch related records for subpanel data.
     */
    fetchRecords: function () {
        if (this.collection) {
            if (this.collection.dataFetched) {
                return;
            }
            this.collection.fetch(this.colOption);
        }
    },

    toggleAll: function (e) {
        var parentCheckBox = $(e.currentTarget);
        var checkBoxes = this.$(".toggle-single");
        if (checkBoxes.length) {
            checkBoxes.prop("checked", parentCheckBox.prop("checked"));
            this.setPdfIsChecked();
        } else {
            parentCheckBox.prop("checked", checkBoxes.length);
        }
    },

    checktoggleAll: function (e) {
        var allChecked = true;
        this.$(".toggle-single").each(function () {
            if (!$(this).prop("checked")) {
                allChecked = false;
            }
        });
        this.$('.toggle-all').prop("checked", allChecked);
        this.setPdfIsChecked();
    },

    /*
     * When user checked or unchecked the Pdf Template this function is called.
     * It will go over all the checkboxes of its own field, not the others, and pushed the 
     * checked models in the checkedPdfsList list so the pdf_template_printer_widget field 
     * should be re-rendered with the selected ones...
     * @returns {undefined}
     */
    setPdfIsChecked: function () {
        var self = this;
        var checkBoxes = this.$(".toggle-single");

        // Maintain a pdfs list, which has the true and false checkbox mapping with there row ids.
        $(checkBoxes).each(function () {
            var checkbox = $(this);
            var row = $(this).closest('tr');
            var beanID = $(row).attr('data-id');

            var isChecked = $(checkbox).prop("checked") == true ? true : false;
            self.pdfs[beanID] = isChecked;
        }, this);

        var dataArr = [];
        _.each(this.view.tabViewFieldNamesList, function (_val) {
            if (_val) {
                // Go over all the checked pdf templates and see if the user has changed the default printer and selected the printer
                // of its own choise, respect the user choise and never overwrites the printer...
                // Also keep the line_number to keep the rows order same and user set its.
                var modelsList = this.view.getField(_val).getCheckedPdfs();
                _.each(modelsList, function (model, key) {
                    if (model) {
                        var defaultPrinter = this.view.printer_setting[model.get('pdf_template_type_id')] || '';
                        var lineNumber = 999, quantity = 1;
                        if (this.view.layout.jsonFieldStructure) {
                            if (this.view.layout.jsonFieldStructure[model.get('id')]) {
                                defaultPrinter = this.view.layout.jsonFieldStructure[model.get('id')].pdf_template_printer_widget_printer;
                                quantity = this.view.layout.jsonFieldStructure[model.get('id')].pdf_template_printer_widget_quantity;
                                lineNumber = this.view.layout.jsonFieldStructure[model.get('id')].pdf_template_printer_widget_line_number;
                            }
                        }

                        var obj = {
                            'pdf_template_printer_widget_name_id': model.get('id'),
                            'pdf_template_printer_widget_name': model.get('name'),
                            'pdf_template_printer_widget_printer': defaultPrinter,
                            'pdf_template_printer_widget_quantity': quantity || 1,
                            'pdf_template_printer_widget_pdf_template_type_id': model.get('pdf_template_type_id'),
                            'pdf_template_printer_widget_line_number': lineNumber,
                        };
                        dataArr.push(obj);
                    }
                }, this);
            }
        }, this);

        // [This is Checkbox ON-CLICK Listner Function] 
        // Since any pdf template is checked or un-checked by user, repopulate the jsonFieldStructure.
        this.view.layout.jsonFieldStructure = {};
        _.each(dataArr, function (val) {
            this.view.layout.jsonFieldStructure[val.pdf_template_printer_widget_name_id] = val;
        }, this);

        // Sort the dataArr on the basis of line_number.
        // Now we have to keep the pdf_template_printer_widget_pdf_template_type_id and pdf_template_printer_widget_line_number saved in the object.
        dataArr = _.sortBy(dataArr, 'pdf_template_printer_widget_line_number');
        app.events.trigger('pdf_template_printer_widget:re-render', JSON.stringify(dataArr));
    },

    getCheckedPdfs: function () {
        var checkedPdfsList = [];
        _.each(this.pdfs, function (flag, pdfId) {
            if (flag) {
                var model = this.filteredCollection.get(pdfId);
                if (model) {
                    checkedPdfsList.push(model);
                }
            }
        }, this);
        return checkedPdfsList;
    },

    generateAndPutToPdfsDir: function (model) {
        app.bwc.login(null, _.bind(function () {
            this._triggerDownload(this._buildDownloadLink(model));
        }, this));
    },

    _triggerDownload: function (url) {
        var self = this;
        app.api.fileDownload(url, {
            success: function () {
            },
            error: function (data) {
                app.error.handleHttpError(data, {});
            },
        }, {
            iframe: this.$el
        });
    },

    _buildDownloadLink: function (model) {
        var urlParams = $.param({
            'action': 'sugarpdf',
            'module': this.model.get('_module'),
            'record': this.model.get('id'),
            'pdf_template_id': model.get('id'),
            'sugarpdf': 'pdfmanager',
            'putToDir': true,
            'unixTimeSuffix': this.unixTimeSuffix,
        });
        return '?' + urlParams;
    },

    previewPdf: function (e) {
        var row = $(e.currentTarget).closest('tr');
        var beanName = $(row).attr('module');
        var beanID = $(row).attr('data-id');

        var href = window.location.href;
        href = href.split("#");
        href = href[0] + 'pdfs/';
        href = href + beanID + '-' + this.unixTimeSuffix + '.pdf';

        app.events.trigger('loadTemplateForPreview', {
            fileURL: href,
        });
    },

    _dispose: function () {
        this._super('_dispose');
    },
})