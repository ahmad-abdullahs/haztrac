({
    plugins: ['Dashlet'],

    jsTree: null,
    /**
     * @Override
     */
    _renderHtml: function() {
        this._super('_renderHtml');
        this.renderTree();
    },

    /**
     * Renders the tree with module and linked fields
     */
    renderTree: function() {
        if (this.jsTree != null) {
            this.jsTree.jstree('destroy');
        }

        var self = this;
        this.jsTree = this.$('#folder_tree_wrapper').jstree({
            "json_data" : {
                "data" : [
                    {
                        'data': 'Root',
                        'state': 'open',
                        'attr': {
                            'rel': 'drive',
                        },
                        'metadata': {
                            'base': '',
                            'file' : false
                        }
                    }
                ]
            },
            'plugins': ['themes', 'json_data', 'ui', 'types', 'contextmenu'],
            'contextmenu' : {
                "items": {
                    "preview": {
                        "separator_before" : false,
                        "separator_after" : true,
                        "label" : "Preview",
                        "action" : function (obj) {
                            if (obj.attr('rel') == 'default') {
                                self.loadPreview(obj.data());
                            } else {
                                app.alert.show('system_folder_dashlet_error', {
                                    level: 'error',
                                    title: 'Error',
                                    messages: 'Function not available.'
                                });
                            }
                        }
                    },
                    "download": {
                        "separator_before" : false,
                        "separator_after" : true,
                        "label" : "Download",
                        "action" : function (obj) {
                            if (obj.attr('rel') == 'default') {
                                self.download(obj.data());
                            } else {
                                app.alert.show('system_folder_dashlet_error', {
                                    level: 'error',
                                    title: 'Error',
                                    messages: 'Function not available.'
                                });
                            }
                        }
                    },
                    "link": {
                        "separator_before" : false,
                        "separator_after" : true,
                        "label" : "Upload as Note",
                        "action" : function (obj) {
                            if (obj.attr('rel') == 'default') {
                                self.uploadNote(obj.data());
                            } else {
                                app.alert.show('system_folder_dashlet_error', {
                                    level: 'error',
                                    title: 'Error',
                                    messages: 'Function not available.'
                                });
                            }
                        }
                    },
                }
            },
            "types" : {
                "valid_children" : [ "drive" ],
                "types" : {
                    "default" : {
                        "valid_children" : "none",
                        "icon" : {
                            "image" : "index.php?entryPoint=getImage&imageName=file.png"
                        }
                    },
                    "folder" : {
                        "valid_children" : [ "default", "folder" ],
                        "icon" : {
                            "image" : "index.php?entryPoint=getImage&imageName=folder.png"
                        }
                    },
                    "drive" : {
                        "valid_children" : [ "default", "folder" ],
                        "icon" : {
                            "image" : "index.php?entryPoint=getImage&imageName=drive.png"
                        },
                    }
                }
            },
        }).bind('loaded.jstree', _.bind(function() {
            this.addChildNodes(this.jsTree.find('li').first(), this.jsTree.find('li').first().data());
        }, this)).bind('click.jstree', function(e) {
            e.stopPropagation();
            e.preventDefault();
        }).bind('select_node.jstree', _.bind(function(e, data) {
            var action = this.$(data.args[0]).attr('data-action');

            if (action == 'jstree-select') {
                this.loadPreview(data.rslt.obj.data());
            } else {
                var nodeType = this.$(data.args[0]).parent().attr('rel')

                if (nodeType != 'default') {
                    if (data.rslt.obj.find('li').length == 0) {
                        this.addChildNodes(data.rslt.obj, data.rslt.obj.data());
                    }

                    data.inst.toggle_node(data.rslt.obj);
                }
            }
        }, this));
    },

    /**
     * Function: addChildNodes
     * Adds the child nodes to a specific element in the tree
     */
    addChildNodes: function(selectedEl, metadata){
        var self = this;
        var url = app.api.buildURL('SystemFolderTree');
        app.api.call('create', url, {
            base: metadata.base
        }, {
            success: function(data){
                _.each(data, function(item) {
                    self.jsTree.jstree("create_node", selectedEl, 'last', {
                        state: "closed",
                        data: item.data,
                        attr: item.attr,
                        metadata: {
                            base: item.base,
                            file : item.file
                        }
                    }, false, false);
                });
            },
            error: function(err){
                app.alert.show('system_folder_dashlet_error', {
                    level: 'error',
                    title: 'System Folder Dahlet Error',
                    messages: err.message
                });
            }
        });
    },

    loadPreview: function(metadata) {
        if (metadata.file) {
            var urlParams = $.param({
                'entryPoint': 'SystemFileDownload',
                'base': metadata.base
            });
            var url = window.location.href;
            url = url.split('#');
            window.open('https://docs.google.com/viewer?url=' + encodeURIComponent(url[0] + '?' + urlParams) + '&embedded=true&chrome=false&dov=1');
        }
    },

    download: function(metadata) {
        var urlParams = $.param({
            'entryPoint': 'SystemFileDownload',
            'base': metadata.base,
            'force_download': true
        });
        var url = window.location.href;
        url = url.split('#');

        app.bwc.login(null, _.bind(function() {
            app.api.fileDownload(url[0] + '?' + urlParams, null, {iframe: this.$el});
        }, this));
    },

    uploadNote: function(metadata) {
        var context = this.context || this.context.parent;
        var moduleMetadata = app.metadata.getModule(context.get('module'));
        var notelink = '';

        _.each(moduleMetadata.fields, function(field) {
            if (field.type == 'link' && field.module == 'Notes') {
                notelink = field.name;
            }
        });

        if (_.isEmpty(notelink)) {
            app.alert.show('system_folder_dashlet_error', {
                level: 'error',
                title: 'Error',
                messages: 'Unable to find link to Notes module.'
            });

            return;
        }

        var url = app.api.buildURL('SystemFolderTree/UploadNote');
        app.api.call('create', url, {
            link: notelink,
            base: metadata.base,
            module: context.get('module'),
            record: context.get('modelId')
        }, {
            success: function(data){
                app.alert.show('system_folder_dashlet_success', {
                    level: 'success',
                    title: 'Success',
                    messages: 'File has been successfully linked to the record.'
                });

                context.trigger('subpanel:reload', {links: [notelink]});
            },
            error: function(err){
                app.alert.show('system_folder_dashlet_error', {
                    level: 'error',
                    title: 'System Folder Dahlet Error',
                    messages: err.message
                });
            }
        });
    },

    /**
     * @Override
     */
    _dispose: function() {
        if (this.jsTree != null) {
            this.jsTree.jstree('destroy');
        }

        this._super('_dispose');
    }
})
