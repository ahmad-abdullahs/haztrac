({
    // This view is used for showing up the dashlet on right side of the drawer for 
    // showing module important fields in the dashlet
    // @see screenshots 5.1.png
    extendsFrom: 'sales_and_servicesCustomPointOfAttentionLvView',

    parentModel: null,

    dashletListModel: null,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },
})
