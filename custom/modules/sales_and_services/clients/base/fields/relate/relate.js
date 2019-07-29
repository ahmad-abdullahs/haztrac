({
     extendsFrom: 'RelateField',
     initialize: function(options) {
         this._super('initialize', [options]);
     },
     openSelectDrawer: function() {
         var filterOptions = new app.utils.FilterOptions()
         .config({
             'initial_filter': 'FilterAccountsTemplate',
             'initial_filter_label': 'LBL_FILTER_ACCOUNTS_TEMPLATE',
             'filter_populate': {
                 'account_id': this.model.get('accounts_sales_and_services_1accounts_ida'),
             }
         })
         .format();
         //this custom code will effect for all relate fields in Enrollment module.But we need initial filter only for Courses relate field.
         filterOptions = (this.getSearchModule() == "Contacs") ? filterOptions : this.getFilterOptions();
         app.drawer.open({
             layout: 'selection-list',
             context: {
                 module: this.getSearchModule(),
                 fields: this.getSearchFields(),
                 filterOptions: filterOptions,
             }
         }, _.bind(this.setValue, this));
     },
 })