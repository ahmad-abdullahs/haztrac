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
    plugins: ['Dashlet'],

    collection: null,

    _newEntryModel: null,

    events: {
        'click [name=addComment]': 'addComment',
    },

    _defaultSettings: {
        max_display_chars: 500,
    },

    initialize: function (options) {
        this._super('initialize', [options]);
        this._initSettings();

        if (!_.isUndefined(this.options.context.parent) && !_.isNull(this.options.context.parent)) {
            if (this.options.context.parent.get('model')) {
                if (this.options.context.parent.get('model').get('commentlog')) {
                    this.showCommentLog(this.options.context.parent.get('model').get('commentlog'), true);
                    this.collection = this.options.context.parent.get('model').get('commentlog');
                    this.collection.on('add remove reset', function () {
                        if (this.disposed) {
                            return;
                        }
                        this.showCommentLog(this.options.context.parent.get('model').get('commentlog'), false);
                        this.render();
                    }, this);
                }
            }
        }
    },

    _initSettings: function () {
        var configSettings = {
            max_display_chars: app.config.commentlog.maxchars,
        };
        this._settings = _.extend({}, this._defaultSettings, configSettings);
        return this;
    },

    showCommentLog: function (commentlog, order) {
        var collection = commentlog;

        if (!collection) {
            return;
        }

        if (order)
            var comments = collection.models.reverse();

        if (comments) {
            this.msgs = [];
            // add readable time and user link to users
            _.each(comments, function (commentModel) {
                var id = commentModel.get('id');

                var msg = {
                    id: commentModel.get('id'),
                    entry: commentModel.get('entry'),
                    created_by_name: commentModel.get('created_by_name'),
                };

                msg.showShort = msg.entry !== msg.entryShort;

                // to date display format
                var enteredDate = app.date(commentModel.get('date_entered'));
                if (enteredDate.isValid()) {
                    msg.entered_date = enteredDate.formatUser();
                }

                var link = commentModel.get('created_by_link');
                if (link && link.id) {
                    if (app.acl.hasAccess('view', 'Employees', {acls: link._acl})) {
                        msg.href = '#' + app.router.buildRoute('Employees', link.id, 'detail');
                    }
                } else if (commentModel.has('created_by')) {
                    msg.href = '#' + app.router.buildRoute('Employees', commentModel.get('created_by'), 'detail');
                }

                this.msgs.push(msg);
            }, this);
            this.render();
        }
    },

    addComment: function () {
        if (!(this.model instanceof Backbone.Model)) {
            return;
        }

        var self = this;
        var el = this.$el.find('div[name=commentContent]');
        var value = el.text();
        if (value) {
            var collectionField = this.model.get('commentlog');
            if (!collectionField) {
                this.model.set('commentlog', []);
                collectionField = this.model.get('commentlog');
            }

            this._newEntryModel = app.data.createRelatedBean(this.model, null, 'commentlog_link', {
                entry: value,
                _link: 'commentlog_link',
                created_by_name: app.user.get('full_name'),
                created_by_link: {
                    full_name: app.user.get('full_name'),
                    id: app.user.id,
                },
            });

            collectionField.models.reverse();
            collectionField.add(this._newEntryModel);
            this.model.save({}, {
                success: function (model, response) {
                    self.showCommentLog(model.get('commentlog'), true);
                    self.render();
                },
            });
        }
    },

    loadData: function (options) {
        this._super('loadData', [options]);
    },

    dispose: function () {
        this._super('dispose');
    }
})
