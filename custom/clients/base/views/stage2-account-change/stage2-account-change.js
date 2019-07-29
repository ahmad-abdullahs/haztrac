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
({
	plugins: ['Stage2CssLoader'],

	css: ['hint-email-import'],

	events: {
		'change input[name=select]': 'isSelected',
		'click .save': 'savePrimary',
		'click .cancel': 'cancel',
		'mouseenter [rel="tooltip"]': 'showTooltip',
		'mouseleave [rel="tooltip"]': 'hideTooltip'
	},

	initialize: function(options) {
		options.context.set('forceNew', true);
		this._super('initialize', [options]);
		this._moduleSingular = app.lang.getModuleName(this.context.get('module'));
		this._domainCollection = options.context.get('_domainCollection');

		if (this.layout) {
			this.layout.on('app:view:stage2-account-change', function() {
				this._domainCollection = this.context.get('_domainCollection');
				this._domains = _.uniq(_.pluck(this._domainCollection, 'domain'));
				this.render();
			}, this);
		}
	},

	_render: function() {
		this._super('_render');
		this.$('.modal').modal({
			backdrop: 'static'
		});
		this.$('.modal').modal('show');
		$('.datepicker').css('z-index', '20000');
		app.$contentEl.attr('aria-hidden', true);
		$('.modal-backdrop').insertAfter($('.modal'));
		$('.save').prop('disabled', true);
	},

	isSelected: function(e) {
		var self = this;
		var $btn = $(e.currentTarget);
		this._newDomain = $btn.attr('value');

		if (!this._newDomain) {
			$('.save').prop('disabled', true);
		} else {
			$('.save').prop('disabled', false);
		}
	},

	_disableButtons: function(flag) {
		$("[data-name='btn']").prop("disabled", flag);
		$("input[name=select]").prop("disabled", flag);
	},

	savePrimary: function() {
		var self = this;
		if (!this._newDomain) {
			app.alert.show('message-id', {
				level: 'error',
				messages: app.lang.get('LBL_HINT_NO_ACCOUNT_SELECTED'),
				autoClose: true
			});
		} else {
			this._disableButtons(true);
			var emails = this.model.get('email');
			var email = _.findWhere(this._domainCollection, {
				domain: this._newDomain
			}).address;

			emails.unshift({
				email_address: email,
				invalid_email: false,
				opt_out: false,
				primary_address: true,
				reply_to_address: false,
			});
			this.model.set({
				email: emails
			});

			this._disableButtons(false);
			this.layout.trigger('app:preview:popup-close');
			app.$contentEl.removeAttr('aria-hidden');
			this._disposeView();
		}
	},

	_disposeView: function() {
		/**Find the index of the view in the components list of the layout*/
		var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {
			name: 'stage2-account-change'
		}));
		if (index > -1) {
			/** dispose the view so that the evnets, context elements etc created by it will be released*/
			this.layout._components[index].dispose();
			/**remove the view from the components list**/
			this.layout._components.splice(index, 1);
		}
	},

	cancel: function() {
		app.$contentEl.removeAttr('aria-hidden');
		this._disposeView();
	}
})
