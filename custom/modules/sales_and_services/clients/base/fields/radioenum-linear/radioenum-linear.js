/**
 * @class View.Fields.Base.RadioenumField
 * @alias SUGAR.App.view.fields.BaseRadioenumField
 * @extends View.Fields.Base.EnumField
 */
({
    // On list-edit template,
    // we want the radio buttons to be replaced by a select so each method must call the EnumField method instead.
    extendsFrom: 'RadioenumField',
    _render: function () {
        this._super("_render");

        // Show the radio buttons list in linear fashion...
        this.$el.css('display', 'flex');
    },
//    bindDomChange: function() {
//        if (this.tplName === 'list-edit') {
//            this._super("bindDomChange");
//        } else {
//            if (!(this.model instanceof Backbone.Model)) return;
//            var self = this;
//            var el = this.$el.find(this.fieldTag);
//            el.on("change", function() {
//                self.model.set(self.name, self.unformat(self.$(self.fieldTag+":radio:checked").val()));
//            });
//        }
//    },
})
