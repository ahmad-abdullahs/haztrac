({
    extendsFrom: 'AccountsRecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    getActiveTab: function (options) {
        return false;
    },

    bindDataChange: function () {
        this.model.on('change:account_status_c', this.colorTheTabs, this);
        this._super('bindDataChange');
    },

    colorTheTabs: function (model, value) {
        if (value == 'Account On Hold') {
            this.$el.find('#recordTab').css('background-color', 'red');
        } else {
            this.$el.find('#recordTab').css('background-color', '#f6f6f6');
        }
    },
})
