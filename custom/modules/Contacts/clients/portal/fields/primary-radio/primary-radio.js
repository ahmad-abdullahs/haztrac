({
    groupname: "",
    is_primary: false,
    disabled: false,
    initialize: function (options) {
        this._super('initialize', [options]);
        this.groupname = this.def.groupname || this.name;
    },
    bindDataChange: function () {
        if (this.model) {
            this.model.on('change:' + this.name, this.updateWholeGroup, this);
        }
    },
    updateWholeGroup: function (model, value) {
        var self = this;
        if (value == "1") {
            this.view.$('[group-name=' + this.groupname + ']').each(function () {
                var name = $(this).attr('name');
                var sfId = $(this).parent('span').attr('sfuuid');
                if (name != self.name) {
                    $(this).prop('checked', false);
                    // Also update the JSON (It is updated in the fieldSet field, because it is dealing with the Json)
                    self.model.set(name, '0', {silent: true});
                    // This is mendatory to unset the is_primary attribute for radio button which are already unchecked.
                    // other on innerfield render they will be marked check on basis of this attr in hbs although in model it is set to 0.
                    var field = self.view.fields[sfId];
                    field.is_primary = false;
                }
            });
            this.view.$('[name=' + this.name + ']').prop('checked', true);
            this.model.set(this.name, '1', {silent: true});
        }
    },
    render: function () {
        this.setPrimary();
        this.setDisabledBit();
        this._super('render');
    },
    setPrimary: function () {
        var hasValue = (this.model.get(this.name) == "1") ? true : false;
        if (hasValue) {
            this.is_primary = true;
        }
    },
    setDisabledBit: function () {
        this.disabled = this.def.disabled || this.def.isNew || false;
    },
    dispose: function () {
        this.model.off('change:' + this.name, this.updateWholeGroup, this);
        this._super('dispose');
    }
})