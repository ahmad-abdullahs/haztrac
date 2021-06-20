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
/**
 * @class View.Views.Base.ListHeaderpaneView
 * @alias SUGAR.App.view.views.BaseListHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'ListHeaderpaneView',
    toRecepientsList: [],
    ccRecepientsList: [],
    contactsList: [],
    accountsIdNameList: {},
    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        app.events.on('showMafiestTotalVolume', this.showMafiestTotalVolume, this);
    },

    bindDataChange: function () {
        this.context.on('button:email_manifest_button:click', function () {
            var documentLinksList = this.getManifestDocumentLinks();
            this.prePopulateComposeEmailDrawer(documentLinksList);
        }, this);

        this._super('bindDataChange');
    },

    showMafiestTotalVolume: function () {
        var rliGalonTotal = 0.00;
        var rliGalonTotalField = this.getField('rli_galon_total_title');

        if (rliGalonTotalField) {
            var filterpanel = this.layout.getComponent('filterpanel');

            if (filterpanel) {
                var list = filterpanel.getComponent('list');
                if (list) {
                    var recordlist = list.getComponent('recordlist');
                    if (recordlist) {
                        if (recordlist.massCollection.length == 0) {
                            // Clear the display
                            rliGalonTotalField.def.default_value = '';
                            rliGalonTotalField.render();
                        } else {
                            // Show the mafiest total volume
                            _.each(recordlist.massCollection.models, function (model) {
                                rliGalonTotal += model.get('rli_galon_total');
                            }, this);

                            rliGalonTotal = app.utils.formatNumber(rliGalonTotal, 0, 2);
                            rliGalonTotalField.def.default_value = 'Selected Total Volume : ' + rliGalonTotal;
                            rliGalonTotalField.render();
                        }
                    }
                }
            }
        }
    },

    getManifestDocumentLinks: function () {
        var documentLinksList = [];
        var companyIds = [];
        var filterpanel = this.layout.getComponent('filterpanel');

        if (filterpanel) {
            var list = filterpanel.getComponent('list');
            if (list) {
                var recordlist = list.getComponent('recordlist');
                if (recordlist) {
                    if (recordlist.massCollection.length == 0) {
                        app.alert.show('noManifestSelected', {
                            level: 'warning',
                            messages: 'Please select Manifest(s) to compose email.',
                            autoClose: true
                        });
                    } else {
                        _.each(recordlist.massCollection.models, function (model) {
                            companyIds.push(model.get('accounts_ht_manifest_1accounts_ida'));
                            if (model.get('popOutFullViewLink')) {
                                documentLinksList.push({
                                    name: model.get('name'),
                                    manifest_no_actual_c: model.get('manifest_no_actual_c'),
                                    link: model.get('popOutFullViewLink'),
                                    accounts_ht_manifest_1accounts_ida: model.get('accounts_ht_manifest_1accounts_ida'),
                                    accounts_ht_manifest_1_name: model.get('accounts_ht_manifest_1_name'),
                                });
                            }
                        }, this);

                        companyIds = _.filter(_.uniq(companyIds));
                        if (companyIds.length > 1) {
                            app.alert.show('differentCompaniesSelected', {
                                level: 'warning',
                                messages: 'Please select Manifest(s) from same Company.',
                                autoClose: true
                            });
                            return [];
                        }

                        if (documentLinksList.length == 0) {
                            app.alert.show('noDocumentsAttached', {
                                level: 'warning',
                                messages: 'Selected Manifest(s) does not have the documents attached.',
                                autoClose: true
                            });
                        }
                    }
                }
            }
        }

        return documentLinksList;
    },

    /*
     * ya function tub call hota ha jub koi user manifest ka list view ja ka mass select 
     * walay checkboxes say records ko list view pay select karnay ka bad email manifest 
     * ka button ko click karta ha.
     * 
     * Logic is ke Sergio ka sath kuch is tarha discuss hoe the: 
     * 
     */
    prePopulateComposeEmailDrawer: function (documentLinksList) {
        if (documentLinksList.length == 0) {
            return;
        }

        var self = this;
        var accountsList = this.getRelatedAccounts(documentLinksList);
        // For now we are considering that, when user select the manifests from the list view, he
        // will select manifest which have common account name.
        // Need to discuss with Sergio, regarding user selecting manifests with different accounts.

        if (accountsList.length > 0) {
            var url = app.api.buildURL('Accounts', 'contacts', {
                id: accountsList[0], link: true, limit: -1,
            }, {
                limit: -1, order_by: 'date_entered', fields: ['id', 'name', 'full_name', 'email'],
            }, {
                limit: -1,
            }, {});
            app.api.call('read', url, {}, {
                success: _.bind(function (response) {
                    self.toRecepientsList = [];
                    self.ccRecepientsList = [];
                    self.contactsList = [];

                    if (!_.isEmpty(app.user.get('email'))) {
                        _.each(app.user.get('email'), function (emailObj) {
                            var ccBean = app.data.createBean('EmailParticipants', {
                                _link: 'cc',
                                email_address_id: emailObj.email_address_id,
                                email_address: emailObj.email_address
                            });

                            ccBean.set({
                                parent: {
                                    _acl: {},
                                    type: 'Users',
                                    id: app.user.get('id'),
                                    name: app.user.get('full_name') || ''
                                },
                                parent_type: 'Users',
                                parent_id: app.user.get('id'),
                                parent_name: app.user.get('full_name') || ''
                            });

                            self.ccRecepientsList.push(ccBean);
                        });
                    }

                    _.each(response.records, function (record) {
                        if (!_.isEmpty(record.email)) {
                            var bean = app.data.createBean('EmailParticipants', {
                                _link: 'to',
                                email_address_id: record.email.email_address_id,
                                email_address: record.email.email_address
                            });

                            bean.set({
                                parent: {
                                    _acl: {},
                                    type: 'Contacts',
                                    id: record.id,
                                    name: record.name || ''
                                },
                                parent_type: 'Contacts',
                                parent_id: record.id,
                                parent_name: record.name || ''
                            });

                            self.toRecepientsList.push(bean);
                            self.contactsList.push(record.name);
                        }
                    }, self);

                    self.contactsList = _.filter(_.uniq(self.contactsList));
                    self.contactsList = self.contactsList.sort();

                    app.utils.openEmailCreateDrawer('compose-email', {
                        // subject
                        // name: '',
                        // body
                        description_html: self.getEmailHTML(documentLinksList),
                        to: self.toRecepientsList,
                        cc: self.ccRecepientsList,
                        parent_type: 'Accounts',
                        parent_id: accountsList[0],
                        parent_name: self.accountsIdNameList[accountsList[0]],
                    }, _.bind(function (context, model) {
                        if (model) {
                            var controllerContext = app.controller.context;
                            var controllerContextModule = controllerContext.get('module');

                            self.trigger('emailclient:close');

                            if (controllerContextModule === 'HT_Manifest' && controllerContext.get('layout') === 'records') {
                                // Refresh the current list view if it is the HT_Manifest list view.
                                controllerContext.reloadData();
                            }
                        }
                    }, self));

                }, this)
            });
        }
    },

    getEmailHTML: function (documentLinksList) {
        if (documentLinksList.length == 0) {
            return;
        }

        var header = this.getHeader(documentLinksList);
        var body = this.getBody(documentLinksList);
        var footer = this.getFooter();

        return '<div>' + header + body + footer + '</div>';
    },

    getHeader: function (documentLinksList) {
        var names = '';
        if (this.contactsList) {
            names = this.contactsList.join(' / ');
        }
        return '<div class="adM">\n\
    <p></p>\n\
</div>\n\
<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">Dear ' + names + ',</p>';
    },

    getBody: function (documentLinksList) {
        var body = '';
        var innerContent = '';

        body += '<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">&nbsp;</p>\n\
<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">Per your request, we have prepared the below manifest(s) for your review. The manifest(s) are being provided via a direct web link. Please click on the link which should take you directly to a browser via which will display your manifest(s). </p>\n\
<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">&nbsp;</p>\n\
<ol style="background: #f2f2f2;">';
        _.each(documentLinksList, function (item) {
            innerContent += '<li><a href="' + item.link + '" data-mce-href="' + item.link + '">' + item.manifest_no_actual_c + '</a></li>';
        }, this);

        body += innerContent;
        body += '</ol>\n\
<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">&nbsp;</p>\n\
<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">After selecting the link and viewing the manifest(s) in a web browser, you can press <b>CTRL+P</b> on your keyboard to bring up your print window. You may also press the print icon on the top right side of the viewer.</p>\n\
<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">&nbsp;</p>\n\
<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">Should you need any additional assistance, please do not hesitate to contact me. </p>';

        return body;
    },

    getFooter: function () {
        return '<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">&nbsp;</p>\n\
<p class="MsoNormal" style="margin-top:0in;margin-right:0in;margin-bottom:0in;margin-left:9.0pt">Regards, </p>\n\
<font color="#888888"></font>\n\
<p></p>\n\
<font color="#888888">\n\
<div>--\n\
    <br>\n\
    <span style="line-height:1.5px">&nbsp;</span>\n\
    <table style="table-layout:fixed" width="450" cellpadding="0" border="0">\n\
        <tbody>\n\
            <tr>\n\
                <td width="65" valign="top" align="left">\n\
                    <span style="margin:0px;padding:0px;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">\n\
                        <a style="text-decoration:none" href="https://htmlsig.com/t/000001DCJCWR" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://htmlsig.com/t/000001DCJCWR&amp;source=gmail&amp;ust=1616666710445000&amp;usg=AFQjCNEEYkr0WDA33rKQteXgohBPRtgSvw">\n\
                            <img src="https://ci4.googleusercontent.com/proxy/eQzaIQ1OIUiYC5Yv7ja67i4XIfD_5ImHzECveffN4rEMnclAUlp71V-Hzwl2s0MO_UBU2DKRZEfuzS3fZdi4kKHpkV6o5OuVdTpvls1MgFIsBLcbGIXe7x9yBYQXucUVZ0vF9Y-dZCm7QmLzXA=s0-d-e1-ft#https://htmlsigs.s3.amazonaws.com/logos/files/000/977/155/landscape/Botavia-Black-Full.png" alt="Botavia Energy, LLC " width="65" height="80" border="0" class="CToWUd">\n\
                        </a>\n\
                    </span>\n\
                </td>\n\
                <td width="10" valign="top" nowrap="" align="left">&nbsp;</td>\n\
                <td width="375" nowrap="" align="left">\n\
                    <span style="margin:0px;padding:0px;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;font-size:12px;line-height:14.4px;display:block">\n\
                        <span style="font-weight:bold;color:rgb(0,0,0);font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;display:inline">\n\
                            <span style="margin:0px;padding:0px;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;font-size:12px;line-height:14.4px;color:rgb(33,33,33);display:block">Sergio\n\
                                Shapiro \n\
                                <span style="color:rgb(33,33,33);font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif"></span>\n\
                                <span style="display:inline;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">\n\
                                    <br>\n\
                                </span>\n\
                                <a href="mailto:sshapiro@botaviaenergy.com" style="color:rgb(130,116,41);text-decoration:none;display:inline" target="_blank">sshapiro@botaviaenergy.com</a>\n\
                                <span style="color:rgb(33,33,33);font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif"></span>\n\
                            </span>\n\
                        </span>\n\
                    </span>\n\
                    <p>\n\
                        <span style="margin:0px;padding:0px;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;font-size:12px;line-height:14.4px;display:block">\n\
                            <span style="font-weight:bold;color:rgb(0,0,0);font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;display:inline">Botavia Energy, LLC </span>\n\
                            <span style="display:inline;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">\n\
                                <br>\n\
                            </span>\n\
                            <span style="color:rgb(33,33,33);display:inline;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">Office: </span>\n\
                            <span style="color:rgb(33,33,33);font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;display:inline">+1 (702)964-1128 </span>\n\
                            <span style="color:rgb(33,33,33);display:inline;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif"> | </span>\n\
                            <span style="color:rgb(33,33,33);display:inline;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">Ext 4004 | Fax: </span>\n\
                            <span style="color:rgb(33,33,33);font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;display:inline">+1 (702) 442-0764 </span>\n\
                            <span style="display:inline;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">\n\
                                <br>\n\
                            </span>\n\
                            <span style="color:rgb(33,33,33);font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;display:inline"> West\n\
                                Coast Operations | Las Vegas Trade Desk</span>\n\
                            <span style="display:inline;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">\n\
                                <br>\n\
                            </span>\n\
                            <span style="color:rgb(33,33,33);font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;display:inline">ICE:\n\
                                sshapiro</span>\n\
                            <span style="display:inline;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">\n\
                                <br>\n\
                            </span>\n\
                            <a href="http://www.BotaviaEnergy.com" style="color:rgb(130,116,41);text-decoration:none;display:inline" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.BotaviaEnergy.com&amp;source=gmail&amp;ust=1616666710445000&amp;usg=AFQjCNGFwqFIUT3AX8jsoN1DIuPPbftxSw">www.BotaviaEnergy.com</a>\n\
                        </span>\n\
                        <span style="margin:0px;padding:0px;line-height:100%;font-size:0px;display:block;font-family:Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif"></span>\n\
                    </p>\n\
                </td>\n\
            </tr>\n\
        </tbody>\n\
    </table>\n\
    <p>&nbsp;</p>\n\
</div>\n\
</font>';
    },

    getRelatedAccounts: function (documentLinksList) {
        var accountsList = [];
        _.each(documentLinksList, function (item) {
            accountsList.push(item.accounts_ht_manifest_1accounts_ida);
            this.accountsIdNameList[item.accounts_ht_manifest_1accounts_ida] = item.accounts_ht_manifest_1_name;

        }, this);

        return _.filter(_.uniq(accountsList));
    },
})
