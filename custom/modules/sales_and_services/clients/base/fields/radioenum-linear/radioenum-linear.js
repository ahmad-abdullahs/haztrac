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
    bindDomChange: function () {
        this._super("bindDomChange");
        if (this.model.get(this.name) == 'Daily') {
            // Hide all others
            $('div[data-name=daily_repeat_on].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=weekly_repeat_on].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on].record-cell').addClass('vis_action_hidden');
        } else if (this.model.get(this.name) == 'Weekly') {
            // Hide all others
            $('div[data-name=weekly_repeat_on].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=daily_repeat_on].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on].record-cell').addClass('vis_action_hidden');
        } else if (this.model.get(this.name) == 'Monthly') {
            // Hide all others
            $('div[data-name=monthly_repeat_on].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=daily_repeat_on].record-cell').addClass('vis_action_hidden');
            $('div[data-name=weekly_repeat_on].record-cell').addClass('vis_action_hidden');
        }
    },
})
