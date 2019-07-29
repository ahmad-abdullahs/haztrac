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
	css: ['hint-help'],

	initialize: function(options) {
		this._specialMessage1 = app.lang.get('LBL_HINT_HELP_MESSAGE1');
		this._specialMessage2 = app.lang.get('LBL_HINT_HELP_MESSAGE2');
		this._specialMessage3 = app.lang.get('LBL_HINT_HELP_MESSAGE3');
		this._super('initialize', [options]);
		this._moduleName = this.context.get('module');
		this._detectAttrs_Contacts = ['first_name', 'last_name'];
		this._detectAttrs_Leads = ['first_name', 'last_name', 'account_name', 'website', 'title', 'phone_work'];
		this._moduleSingular = app.lang.getModuleName(this._moduleName);
		if (this._moduleName === 'Accounts') {
			this._defaultMessage1 = app.lang.get('LBL_HINT_HELP_DEFAULT_MESSAGE1A', null, this);
			this._defaultMessage2 = '';
		} else {
			this._defaultMessage1 = app.lang.get('LBL_HINT_HELP_DEFAULT_MESSAGE1B', null, this);
			this._defaultMessage2 = '';
		}
		this._nonTriggerFields = ['phone_work', 'title', 'first_name', 'last_name'];
		this._relatedModules = ['Contacts', 'Leads', 'Accounts'];
		this._message1 = this._defaultMessage1;
		this._message2 = this._defaultMessage2;
		if (this.context) {
			this.listenTo(this.model, 'change', this._DetectChange);
			this.context.on('app:preview:stage2-show-notification', function() {
				// Close preview to show helper.
				app.events.trigger('preview:close');
				this._changeMsg();
			}, this);
		}
	},

	_setMsg: function(msg1, msg2) {
		this._message1 = msg1;
		this._message2 = msg2;
		this.render();
	},

	_changeMsg: function() {
		if (this._moduleName === 'Accounts') {
			if (this.model.get('name')) {
				// When website entered and no match found, change message.
				if (this.model.get('website')) {
					this._setMsg(this._specialMessage1, '');
				} else {
					this._setMsg(this._specialMessage1, this._specialMessage3);
				}
			} else {
				this._setMsg(this._defaultMessage1, this._defaultMessage2);
				this._addIndicators();
			}
		} else {
			if (this.model.get('first_name') && this.model.get('last_name')) {
				if (this.model.get('email') && this.model.get('email').length > 0) {
					this._setMsg(this._specialMessage1, '');
				} else {
					this._setMsg(this._specialMessage1, this._specialMessage2);
				}
			} else {
				this._setMsg(this._defaultMessage1, this._defaultMessage2);
				this._addIndicators();
			}
		}
	},

	_triggerPreview: function(attr, value) {
		app.events.trigger('preview:close');
		app.events.trigger('preview:render', this.model);
		app.events.trigger('hint:user-input', true);
		return;
	},

	_isValidDomain: function(domain) {
		var re = new RegExp(/[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/);
		return domain.match(re);
	},


	_DetectChange: function() {
		// Once we detected there is only one specific attribute changed in model, 
		// we trigger hint preview to update the new enriched data.
		var keys = _.keys(this.model.changedAttributes());
		if (_.contains(this._relatedModules, this._moduleName) &&
			(keys.length === 1 ||
				(keys.length === 2 && keys[0] === 'first_name' && (keys[1] === 'full_name' || keys[1] === 'name')) ||
				(keys.length === 2 && keys[0] === 'last_name' && (keys[1] === 'full_name' || keys[1] === 'name')))) {

			var val = this.model.changedAttributes()[keys[0]];
			if (this._moduleName === 'Accounts') {
				if (keys[0] === 'website') {
					if ((val && val.trim() !== '' && this._isValidDomain(val)) || val.trim() === '') {
						if (this.model.get('website') || this.model.get('name')) {
							this._triggerPreview(keys[0], val);
						} else {
							app.events.trigger('preview:close');
						}
					}
				} else if (keys[0] === 'name') {
					if (val && val.trim() !== '') {
						if (this.model.get('website') || this.model.get('name')) {
							this._triggerPreview(keys[0], val);
						} else {
							app.events.trigger('preview:close');
						}
					}
				}
			} else { // under Contacts and Leads
				if (_.contains(this['_detectAttrs_' + this._moduleName], keys[0])) {
					var flag = _.contains(this._nonTriggerFields, keys[0]);
					if (!flag) {
						app.events.trigger('hint:user-input', false);
					} else {
						this._triggerPreview(keys[0], val);
					}
				}
			}
		}
		return;
	},

	_addIndicators: function() {
		var self = this;
		this.$('[data-name="loading"]').removeClass('hidden');
		setTimeout(function() {
			self.$('[data-name="loading"]').addClass('hidden');
		}, 1000);
	},
})
