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
		'change input[name=checkbox-import]': 'isChecked',
		'click .save_import': 'saveImport',
		'click .cancel': 'cancel',
		'mouseenter [rel="tooltip"]': 'showTooltip',
		'mouseleave [rel="tooltip"]': 'hideTooltip'
	},

	initialize: function(options) {
		options.context.set('forceNew', true);
		this._super('initialize', [options]);
		this._emailCollection = options.context.get('_emailCollection');
		if (this.layout) {
			this.layout.on('app:view:stage2-email-import', function() {
				this._emailsToImport = [];
				this._emailCollection = this.context.get('_emailCollection');
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
		$('.save_import').prop('disabled', true);
	},

	isChecked: function(e) {
		var self = this;
		var $btn = $(e.currentTarget);
		var isChecked = $btn.is(':checked');
		var newEmail = $btn.attr('value');

		if (isChecked) {
			if (_.indexOf(self._emailsToImport, newEmail) === -1) {
				self._emailsToImport.push(newEmail);
			}
		} else {
			self._emailsToImport = _.without(self._emailsToImport, newEmail);
		}

		if (!_.isEmpty(this._emailsToImport)) {
			$('.save_import').prop('disabled', false);
		} else {
			$('.save_import').prop('disabled', true);
		}

	},

	_mergeEmail: function() {
		var emails = this.model.get('email') || [];
		var newEmails = [];
		var isPrimary = false;
		if (!_.isEmpty(this._emailsToImport)) {
			if (emails.length === 0) {
				isPrimary = true;
			}
			_.each(this._emailsToImport, function(item) {
				var newItem = {
					email_address: item,
					invalid_email: false,
					opt_out: false,
					primary_address: isPrimary
				}
				newEmails.push(newItem);
				emails.push(newItem);
				isPrimary = false;
			}, this);
			this._emailsToImport = newEmails;
		}
		return emails;
	},

	_disableButtons: function(flag) {
		$("[data-name='email-import-btn']").prop('disabled', flag);
		$("input[name=checkbox-import]").prop('disabled', flag);
	},

	saveImport: function() {
		var self = this;
		if (!_.isEmpty(this._emailsToImport)) {
			this._disableButtons(true);
			if (this.context.parent.get('create')) {
				this.model.set({
					'email': this._mergeEmail()
				});
			} else {
				this.model.save({
					'email': this._mergeEmail()
				});
			}
			this._disableButtons(false);
			this.layout.trigger('app:preview:popup-close', this._emailsToImport);
			app.$contentEl.removeAttr('aria-hidden');
			this._disposeView();

		} else {
			app.alert.show('message-id', {
				level: 'error',
				messages: 'No email is selected',
				autoClose: true
			});
		}
	},

	_disposeView: function() {
		var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {
			name: 'stage2-email-import'
		}));
		if (index > -1) {
			this.layout._components[index].dispose();
			this.layout._components.splice(index, 1);
		}
	},

	cancel: function() {
		app.$contentEl.removeAttr('aria-hidden');
		this._disposeView();
	}
})
