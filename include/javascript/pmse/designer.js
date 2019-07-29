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
/*global translate, $, document, window, SUGAR_FLAVOR, AdamProject, AdamCanvas, AdamEvent,
 AdamGateway, AdamActivity, AdamArtifact, AdamFlow, getAutoIncrementName, jCore,
 location, SUGAR_URL, adamUID, RestClient, SUGAR_REST, parseInt, SUGAR_AJAX_URL,
 PROJECT_LOCKED_VARIABLES, Tree, PROJECT_LOCKED_VARIABLES
 */
var project,
    canvas,
    PROJECT_MODULE = 'Leads',
    items,
    myLayout,
    adamUID,
    PROJECT_LOCKED_VARIABLES = [],
    PMSE_DECIMAL_SEPARATOR = '.',
    PMSE_DESIGNER_FORM_TRANSLATIONS = {
        ERROR_INVALID_EMAIL: translate('LBL_PMSE_ADAM_UI_ERROR_INVALID_EMAIL'),
        ERROR_INVALID_INTEGER: translate('LBL_PMSE_ADAM_UI_ERROR_INVALID_INTEGER'),
        ERROR_REQUIRED_FIELD: translate('LBL_PMSE_ADAM_UI_ERROR_REQUIRED_FIELD'),
        ERROR_COMPARISON: translate('LBL_PMSE_ADAM_UI_ERROR_COMPARISON'),
        ERROR_REGEXP: translate('LBL_PMSE_ADAM_UI_ERROR_REGEXP'),
        ERROR_TEXT_LENGTH: translate('LBL_PMSE_ADAM_UI_ERROR_TEXT_LENGTH'),
        ERROR_CHECKBOX_VALUES: translate('LBL_PMSE_ADAM_UI_ERROR_CHECKBOX_VALUES'),
        ERROR_TEXT: translate('LBL_PMSE_ADAM_UI_ERROR_TEXT'),
        ERROR_DATE : translate('LBL_PMSE_ADAM_UI_ERROR_DATE '),
        ERROR_PHONE: translate('LBL_PMSE_ADAM_UI_ERROR_PHONE'),
        ERROR_FLOAT: translate('LBL_PMSE_ADAM_UI_ERROR_FLOAT'),
        ERROR_DECIMAL: translate('LBL_PMSE_ADAM_UI_ERROR_DECIMAL'),
        ERROR_URL: translate('LBL_PMSE_ADAM_UI_ERROR_URL'),

        TITLE_BUSINESS_RULE_EVALUATION: translate('LBL_PMSE_ADAM_UI_TITLE_BUSINESS_RULE_EVALUATION'),
        LBL_BUSINESS: translate('LBL_PMSE_ADAM_UI_LBL_BUSINESS'),
        LBL_OPERATOR: translate('LBL_PMSE_ADAM_UI_LBL_OPERATOR'),
        LBL_UNIT: translate('LBL_PMSE_ADAM_UI_LBL_UNIT'),
        LBL_RESPONSE: translate('LBL_PMSE_LABEL_RESPONSE'),
        LBL_LOGIC_OPERATORS: translate('LBL_PMSE_ADAM_UI_LBL_LOGIC_OPERATORS'),
        LBL_GROUP: translate('LBL_PMSE_ADAM_UI_LBL_GROUP'),
        LBL_OPERATION: translate('LBL_PMSE_ADAM_UI_LBL_OPERATION'),
        LBL_DIRECTION: translate('LBL_PMSE_ADAM_UI_LBL_DIRECTION'),
        LBL_MODULE: translate('LBL_PMSE_FORM_LABEL_MODULE'),
        LBL_FIELD: translate('LBL_PMSE_LABEL_FIELD'),
        LBL_VALUE: translate('LBL_PMSE_LABEL_VALUE'),
        LBL_TARGET_MODULE: translate('LBL_PMSE_FORM_OPTION_TARGET_MODULE'),
        LBL_VARIABLE: translate('LBL_PMSE_ADAM_UI_LBL_VARIABLE'),
        LBL_NUMBER: translate('LBL_PMSE_ADAM_UI_LBL_NUMBER'),
        TITLE_MODULE_FIELD_EVALUATION: translate('LBL_PMSE_ADAM_UI_TITLE_MODULE_FIELD_EVALUATION'),
        TITLE_FORM_RESPONSE_EVALUATION: translate('LBL_PMSE_ADAM_UI_TITLE_FORM_RESPONSE_EVALUATION'),
        TITLE_SUGAR_DATE: translate('LBL_PMSE_ADAM_UI_TITLE_SUGAR_DATE'),
        TITLE_FIXED_DATE: translate('LBL_PMSE_ADAM_UI_TITLE_FIXED_DATE'),
        TITLE_UNIT_TIME: translate('LBL_PMSE_ADAM_UI_TITLE_UNIT_TIME'),
        LBL_FORM: translate('LBL_PMSE_LABEL_FORM'),
        LBL_STATUS: translate('LBL_PMSE_LABEL_STATUS'),
        LBL_APPROVED: translate('LBL_PMSE_LABEL_APPROVED'),
        LBL_REJECTED: translate('LBL_PMSE_LABEL_REJECTED'),
        BUTTON_SUBMIT: translate('LBL_PMSE_BUTTON_ADD'),
        BUTTON_CANCEL: translate('LBL_PMSE_BUTTON_CANCEL')
    };

var currentErrorTable;

var getAutoIncrementName = function (type, targetElement) {
    var i, j, k = canvas.getCustomShapes().getSize(), element, exists, index = 1, auxMap = {
        AdamUserTask: translate('LBL_PMSE_ADAM_DESIGNER_TASK'),
        AdamScriptTask: translate('LBL_PMSE_ADAM_DESIGNER_ACTION'),
        AdamEventLead: translate('LBL_PMSE_ADAM_DESIGNER_LEAD_START_EVENT'),
        AdamEventOpportunity: translate('LBL_PMSE_ADAM_DESIGNER_OPPORTUNITY_START_EVENT'),
        AdamEventDocument: translate('LBL_PMSE_ADAM_DESIGNER_DOCUMENT_START_EVENT'),
        AdamEventOtherModule: translate('LBL_PMSE_ADAM_DESIGNER_OTHER_MODULE_EVENT'),
        AdamEventTimer: translate('LBL_PMSE_ADAM_DESIGNER_WAIT_EVENT'),
        AdamEventMessage: translate('LBL_PMSE_ADAM_DESIGNER_MESSAGE_EVENT'),
        AdamEventReceiveMessage: translate('LBL_PMSE_ADAM_DESIGNER_MESSAGE_EVENT'),
        AdamEventBoundary: translate('LBL_PMSE_ADAM_DESIGNER_BOUNDARY_EVENT'),
        AdamGatewayExclusive: translate('LBL_PMSE_ADAM_DESIGNER_EXCLUSIVE_GATEWAY'),
        AdamGatewayParallel: translate('LBL_PMSE_ADAM_DESIGNER_PARALLEL_GATEWAY'),
        AdamEventEnd: translate('LBL_PMSE_ADAM_DESIGNER_END_EVENT'),
        AdamTextAnnotation: translate('LBL_PMSE_ADAM_DESIGNER_TEXT_ANNOTATION')
    };

    for (i = 0; i < k; i += 1) {
        exists = false;
        for (j = 0; j < k; j += 1) {
            element =  canvas.getCustomShapes().get(j);
            if (element.getName() === auxMap[type] + " # " + (i + 1)) {
                exists = !(targetElement && targetElement === element);
                break;
            }
        }
        if (!exists) {
            break;
        }
    }

    return auxMap[type] + " # " + (i + 1);
};

function renderProject (prjCode) {
    var pmseCurrencies, currencies, sugarCurrencies, currentCurrency, i;

    adamUID = prjCode;

    //RESIZE OPTIONS
    if ($('#container').length) {
        $('#container').height($(window).height() - $('#container').offset().top - $('#footer').height() - 46);
    }
    $(window).resize(function () {
        if ($('#container').length) {
            $('#container').height($(window).height() - $('#content').offset().top - $('#footer').height() - 46);
        }

    });

    //LAYOUT
    myLayout = $('#container').layout({
        north: {
            size: 44,
            spacing_open: 0,
            closable: false,
            slidable: false,
            resizable: false
        },
        north__showOverflowOnHover: true,
        south: {
            size: 200,
            maxSize: 200,
            minSize: 100,
            initHidden: true
        }
    });
    $('#container').css('zIndex', 1);

    $('.ui-layout-north').css('overflow', 'hidden');

    pmseCurrencies = [];
    currencies = SUGAR.App.metadata.getCurrencies();
    for (currID in currencies) {
        if (currencies.hasOwnProperty(currID)) {
            if (currencies[currID].status === 'Active') {
                pmseCurrencies.push({
                    id: currID,
                    iso: currencies[currID].iso4217,
                    name: currencies[currID].name,
                    rate: parseFloat(currencies[currID].conversion_rate),
                    preferred: currID === SUGAR.App.user.getCurrency().currency_id,
                    symbol: currencies[currID].symbol
                });
            }
        }
    }
    project = new AdamProject({
        metadata: [
            {
                name: "teamsDataSource",
                data: {
                    url: "pmse_Project/CrmData/teams/public",
                    root: "result"
                }
            },
            {
                name: "datePickerFormat",
                data: SUGAR.App.date.toDatepickerFormat(SUGAR.App.user.attributes.preferences.datepref)
            },
            {
                name: "fieldsDataSource",
                data: {
                    url: "pmse_Project/CrmData/allRelated/{MODULE}",
                    root: "result"
                }
            },
            {
                name: "targetModuleFieldsDataSource",
                data: {
                    url: "pmse_Project/CrmData/fields/{MODULE}",
                    root: "result"
                }
            },
            {
                name: "currencies",
                data: pmseCurrencies
            }
        ]
    });

    canvas = new AdamCanvas({
        name : 'Adam',
        id: "jcore_designer",
        container : "regular",
        readOnly : false,
        drop : {
            type : "container",
            selectors : ["#AdamEventDocument", "#AdamEventLead",
                "#AdamEventOpportunity", "#AdamEventTimer", "#AdamEventMessage", "#AdamEventEnd",
                "#AdamGatewayExclusive", "#AdamGatewayParallel", "#AdamUserTask", "#AdamScriptTask",
                "#AdamTextAnnotation", ".custom_shape", "#AdamEventReceiveMessage", "#AdamEventOtherModule" ]
        },
        copyAndPasteReferences: {
            AdamEvent: AdamEvent,
            AdamGateway: AdamGateway,
            AdamActivity: AdamActivity,
            AdamArtifact: AdamArtifact,
            AdamFlow: AdamFlow
        },
        toolbarFactory: function (id) {
            var customShape = null,
                name = getAutoIncrementName(id);
            switch (id) {
            case "AdamEventLead":
                customShape = new AdamEvent({
                    canvas : this,
                    width : 33,
                    height : 33,
                    style: {
                        cssClasses: [""]
                    },
                    evn_name: name,
                    evn_type: 'start',
                    evn_marker: 'MESSAGE',
                    evn_behavior: 'catch',
                    evn_message: 'Leads',
                    labels: [{
                        message: '',
                        position : {
                            location : "bottom",
                            diffX : 0,
                            diffY : 0
                        }
                    }],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-event-start',
                                'adam-shape-75-event-start',
                                'adam-shape-100-event-start',
                                'adam-shape-125-event-start',
                                'adam-shape-150-event-start'
                            ]
                        },
                        {
                            layerName : "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-marker-50-start-catch-leads',
                                'adam-marker-75-start-catch-leads',
                                'adam-marker-100-start-catch-leads',
                                'adam-marker-125-start-catch-leads',
                                'adam-marker-150-start-catch-leads'
                            ]
                        }

                    ],
                    drag: 'customshapedrag',
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case "AdamEventOpportunity":
                customShape = new AdamEvent({
                    canvas : this,
                    width : 33,
                    height : 33,
                    style: {
                        cssClasses: [""]
                    },
                    evn_name: name,
                    evn_type: 'start',
                    evn_marker: 'MESSAGE',
                    evn_behavior: 'catch',
                    evn_message: 'Opportunities',
                    labels: [{
                        message: '',
                        position : {
                            location : "bottom",
                            diffX : 0,
                            diffY : 0
                        }
                    }],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-event-start',
                                'adam-shape-75-event-start',
                                'adam-shape-100-event-start',
                                'adam-shape-125-event-start',
                                'adam-shape-150-event-start'
                            ]
                        },
                        {
                            layerName : "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-marker-50-start-catch-opportunities',
                                'adam-marker-75-start-catch-opportunities',
                                'adam-marker-100-start-catch-opportunities',
                                'adam-marker-125-start-catch-opportunities',
                                'adam-marker-150-start-catch-opportunities'
                            ]
                        }
                    ],
                    drag: 'customshapedrag',
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case "AdamEventDocument":
                customShape = new AdamEvent({
                    canvas : this,
                    width : 33,
                    height : 33,
                    style: {
                        cssClasses: [""]
                    },
                    evn_name: name,
                    evn_type: 'start',
                    evn_marker: 'MESSAGE',
                    evn_behavior: 'catch',
                    evn_message: 'Documents',
                    labels: [{
                        message: 'Document Start Event',
                        position : {
                            location : "bottom",
                            diffX : 0,
                            diffY : 0
                        }
                    }],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-event-start',
                                'adam-shape-75-event-start',
                                'adam-shape-100-event-start',
                                'adam-shape-125-event-start',
                                'adam-shape-150-event-start'
                            ]
                        },
                        {
                            layerName : "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-marker-50-start-catch-documents',
                                'adam-marker-75-start-catch-documents',
                                'adam-marker-100-start-catch-documents',
                                'adam-marker-125-start-catch-documents',
                                'adam-marker-150-start-catch-documents'
                            ]
                        }
                    ],
                    drag: 'customshapedrag',
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case "AdamEventOtherModule":
                customShape = new AdamEvent({
                    canvas : this,
                    width : 33,
                    height : 33,
                    style: {
                        cssClasses: [""]
                    },
                    evn_name: name,
                    evn_type: 'start',
                    evn_marker: 'MESSAGE',
                    evn_behavior: 'catch',
                    evn_message: '',
                    labels: [{
                        message: 'Other Start Event',
                        position : {
                            location : "bottom",
                            diffX : 0,
                            diffY : 0
                        }
                    }],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-event-start',
                                'adam-shape-75-event-start',
                                'adam-shape-100-event-start',
                                'adam-shape-125-event-start',
                                'adam-shape-150-event-start'
                            ]
                        },
                        {
                            layerName : "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-marker-50-start-catch-message',
                                'adam-marker-75-start-catch-message',
                                'adam-marker-100-start-catch-message',
                                'adam-marker-125-start-catch-message',
                                'adam-marker-150-start-catch-message'
                            ]
                        }
                    ],
                    drag: 'customshapedrag',
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case 'AdamEventTimer':
                customShape = new AdamEvent({
                    canvas : this,
                    width : 33,
                    height : 33,
                    style: {
                        cssClasses: [""]
                    },
                    evn_name: name,
                    evn_type: 'intermediate',
                    evn_marker: 'TIMER',
                    evn_behavior: 'catch',
                    evn_message: '',
                    labels: [{
                        message: '',
                        position : {
                            location : "bottom",
                            diffX : 0,
                            diffY : 0
                        }
                    }],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-event-intermediate',
                                'adam-shape-75-event-intermediate',
                                'adam-shape-100-event-intermediate',
                                'adam-shape-125-event-intermediate',
                                'adam-shape-150-event-intermediate'
                            ]
                        },
                        {
                            layerName : "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-marker-50-intermediate-catch-timer',
                                'adam-marker-75-intermediate-catch-timer',
                                'adam-marker-100-intermediate-catch-timer',
                                'adam-marker-125-intermediate-catch-timer',
                                'adam-marker-150-intermediate-catch-timer'
                            ]
                        }
                    ],
                    drag: 'customshapedrag',
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case 'AdamEventMessage':
                customShape = new AdamEvent({
                    canvas : this,
                    width : 33,
                    height : 33,
                    style: {
                        cssClasses: [""]
                        //                              cssProperties : {
                        //                                  "border": "1px solid black"
                        //                              }
                    },
                    evn_name: name,
                    evn_type: 'intermediate',
                    evn_marker: 'MESSAGE',
                    evn_behavior: 'throw',
                    evn_message: '',
                    labels: [{
                        message: '',
                        position : {
                            location : "bottom",
                            diffX : 0,
                            diffY : 0
                        }
                    }],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-event-intermediate',
                                'adam-shape-75-event-intermediate',
                                'adam-shape-100-event-intermediate',
                                'adam-shape-125-event-intermediate',
                                'adam-shape-150-event-intermediate'
                            ]
                        },
                        {
                            layerName : "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-marker-50-intermediate-throw-message',
                                'adam-marker-75-intermediate-throw-message',
                                'adam-marker-100-intermediate-throw-message',
                                'adam-marker-125-intermediate-throw-message',
                                'adam-marker-150-intermediate-throw-message'
                            ]
                        }
                    ],
                    drag: 'customshapedrag',
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case 'AdamEventReceiveMessage':
                customShape = new AdamEvent({
                    canvas : this,
                    width : 33,
                    height : 33,
                    style: {
                        cssClasses: [""]
                        //                              cssProperties : {
                        //                                  "border": "1px solid black"
                        //                              }
                    },
                    evn_name: name,
                    evn_type: 'intermediate',
                    evn_marker: 'MESSAGE',
                    evn_behavior: 'catch',
                    evn_message: '',
                    labels: [{
                        message: '',
                        position : {
                            location : "bottom",
                            diffX : 0,
                            diffY : 0
                        }
                    }],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-event-intermediate',
                                'adam-shape-75-event-intermediate',
                                'adam-shape-100-event-intermediate',
                                'adam-shape-125-event-intermediate',
                                'adam-shape-150-event-intermediate'
                            ]
                        },
                        {
                            layerName : "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-marker-50-intermediate-catch-message',
                                'adam-marker-75-intermediate-catch-message',
                                'adam-marker-100-intermediate-catch-message',
                                'adam-marker-125-intermediate-catch-message',
                                'adam-marker-150-intermediate-catch-message'
                            ]
                        }
                    ],
                    drag: 'customshapedrag',
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case 'AdamUserTask':
                customShape = new AdamActivity({
                    canvas : this,
                    width: 100,
                    height: 50,
                    container : 'activity',
                    style: {
                        cssClasses: ['']
                    },
                    layers: [
                        {
                            /* added by mauricio */
                            // since the class bpmn_activity has border and
                            // moves the activity, then move it a few pixels
                            // back to make it look pretty
                            x: -2,
                            y: -2,
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: ['adam-activity-task']
                            }
                        }
                    ],
                    connectAtMiddlePoints: true,
                    drag: 'customshapedrag',
                    resizeBehavior: "activityResize",
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 8,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {
                        //type: 'connectioncontainer',
                        type: 'connection'
                        //selectors : ["#AdamEventBoundary", '.adam_boundary_event']
                    },
                    labels : [
                        {
                            message : "",
                            //x : 10,
                            //y: 10,
                            width : 0,
                            height : 0,
                            orientation: 'horizontal',
                            position: {
                                location: 'center',
                                diffX : 0,
                                diffY : 0

                            },
                            updateParent : true
                        }
                    ],
                    markers: [
                        {
                            markerType: 'USERTASK',
                            x: 5,
                            y: 5,
                            markerZoomClasses: [
                                "adam-marker-50-usertask",
                                "adam-marker-75-usertask",
                                "adam-marker-100-usertask",
                                "adam-marker-125-usertask",
                                "adam-marker-150-usertask"
                            ]
                        }
                    ],
                    act_type: 'TASK',
                    act_task_type: 'USERTASK',
                    act_name: name,
                    minHeight: 50,
                    minWidth: 100,
                    maxHeight: 300,
                    maxWidth: 400
                });
                break;
            case 'AdamScriptTask':
                customShape = new AdamActivity({
                    canvas : this,
                    width: 35,
                    height: 35,
                    container : 'activity',
                    style: {
                        cssClasses: ['']
                    },
                    layers: [
                        {
                            /* added by mauricio */
                            // since the class bpmn_activity has border and
                            // moves the activity, then move it a few pixels
                            // back to make it look pretty
                            x: -2,
                            y: -2,
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: ['adam-activity-task']
                            }
                        },
                        {
                            x: -2,
                            y: -2,
                            layerName: "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-activity-scripttask-none',
                                'adam-shape-75-activity-scripttask-none',
                                'adam-shape-100-activity-scripttask-none',
                                'adam-shape-125-activity-scripttask-none',
                                'adam-shape-150-activity-scripttask-none'
                            ]
                        }
                    ],
                    connectAtMiddlePoints: true,
                    drag: 'customshapedrag',
                    //resizeBehavior: "activityResize",
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    // drop : {
                    //     type: 'connectioncontainer',
                    //     selectors : ["#AdamEventBoundary", '.adam_boundary_event']
                    // },
                    drop : {type: 'connection'},
                    labels : [
                        {
                            message : "",
                            position: {
                                location: 'bottom',
                                diffX : 1,
                                diffY : 4
                            },
                            updateParent : false
                        }
                    ],
                    act_type: 'TASK',
                    act_task_type: 'SCRIPTTASK',
                    act_name: name, //name
                    act_script_type: 'NONE'
                });
                break;
            case 'AdamEventBoundary':
                customShape = new AdamEvent({
                    canvas : this,
                    width : 33,
                    height : 33,
                    style: {
                        cssClasses: [""]
                    },
                    evn_name: name,
                    evn_type: 'boundary',
                    evn_marker: 'TIMER',
                    evn_behavior: 'catch',
                    evn_message: '',
                    labels: [{
                        message: '',
                        position : {
                            location : "bottom",
                            diffX : 0,
                            diffY : 0
                        }
                    }],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-event-intermediate',
                                'adam-shape-75-event-intermediate',
                                'adam-shape-100-event-intermediate',
                                'adam-shape-125-event-intermediate',
                                'adam-shape-150-event-intermediate'
                            ]
                        },
                        {
                            layerName : "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-marker-50-intermediate-catch-timer',
                                'adam-marker-75-intermediate-catch-timer',
                                'adam-marker-100-intermediate-catch-timer',
                                'adam-marker-125-intermediate-catch-timer',
                                'adam-marker-150-intermediate-catch-timer'
                            ]
                        }
                    ],
                    drag: 'customshapedrag',
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case 'AdamEventEnd':
                customShape = new AdamEvent({
                    canvas : this,
                    width : 33,
                    height : 33,
                    style: {
                        cssClasses: [""]
                        //                              cssProperties : {
                        //                                  "border": "1px solid black"
                        //                              }
                    },
                    evn_name: name,
                    evn_type: 'end',
                    evn_marker: 'EMPTY',
                    evn_behavior: 'throw',
                    evn_message: '',
                    labels: [{
                        message: '',
                        position : {
                            location : "bottom",
                            diffX : 0,
                            diffY : 0
                        }
                    }],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-event-end',
                                'adam-shape-75-event-end',
                                'adam-shape-100-event-end',
                                'adam-shape-125-event-end',
                                'adam-shape-150-event-end'
                            ]
                        },
                        {
                            layerName : "second-layer",
                            priority: 3,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-marker-50-end-throw-empty',
                                'adam-marker-75-end-throw-empty',
                                'adam-marker-100-end-throw-empty',
                                'adam-marker-125-end-throw-empty',
                                'adam-marker-150-end-throw-empty'
                            ]
                        }
                    ],
                    drag: 'customshapedrag',
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                    //drop : {type: 'adamconnection'}
                });
                break;
            case 'AdamGatewayExclusive':
                customShape = new AdamGateway({
                    canvas : this,
                    width : 45,
                    height : 45,
                    gat_type: 'exclusive',
                    gat_direction: 'diverging',
                    gat_name: name,

                    style: {
                        cssClasses: [""]
                    },
                    labels : [
                        {
                            message : "",
                            position : {
                                location : "bottom",
                                diffX : 0,
                                diffY : 0
                            }
                        }

                    ],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-gateway-exclusive',
                                'adam-shape-75-gateway-exclusive',
                                'adam-shape-100-gateway-exclusive',
                                'adam-shape-125-gateway-exclusive',
                                'adam-shape-150-gateway-exclusive'
                            ]
                        }
                    ],
                    connectAtMiddlePoints: true,
                    drag: 'regular',
                    resizeBehavior: "no",
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case 'AdamGatewayParallel':
                customShape = new AdamGateway({
                    canvas : this,
                    width : 45,
                    height : 45,
                    gat_type: 'parallel',
                    gat_direction: 'diverging',
                    gat_name: name,
                    style: {
                        cssClasses: [""]
                    },
                    labels : [
                        {
                            message : "",
                            position : {
                                location : "bottom",
                                diffX : 0,
                                diffY : 0
                            }
                        }

                    ],
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true,
                            style: {
                                cssClasses: []
                            },
                            zoomSprites : [
                                'adam-shape-50-gateway-parallel',
                                'adam-shape-75-gateway-parallel',
                                'adam-shape-100-gateway-parallel',
                                'adam-shape-125-gateway-parallel',
                                'adam-shape-150-gateway-parallel'
                            ]
                        }
                    ],
                    connectAtMiddlePoints: true,
                    drag: 'regular',
                    resizeBehavior: "no",
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 4,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    drop : {type: 'connection'}
                });
                break;
            case "AdamTextAnnotation":
                customShape = new AdamArtifact({
                    canvas : this,
                    width: 100,
                    height: 50,
                    style: {
                        cssClasses: []
                    },
                    layers: [
                        {
                            layerName : "first-layer",
                            priority: 2,
                            visible: true
                        }
                    ],
                    connectAtMiddlePoints: true,
                    drag: 'regular',
                    //resizeBehavior: "yes",
                    resizeBehavior: "adamArtifactResize",
                    resizeHandlers: {
                        type: "Rectangle",
                        total: 8,
                        resizableStyle: {
                            cssProperties: {
                                'background-color': "rgb(0, 255, 0)",
                                'border': '1px solid black'
                            }
                        },
                        nonResizableStyle: {
                            cssProperties: {
                                'background-color': "white",
                                'border': '1px solid black'
                            }
                        }
                    },
                    labels : [
                        {
                            message : "",
                            width : 0,
                            height : 0,
                            position: {
                                location : 'center',
                                diffX : 0,
                                diffY : 0
                            },
                            updateParent : true
                        }
                    ],
                    drop : {type: 'connection'},
                    art_type: 'TEXTANNOTATION',
                    art_name: name
                });
                break;
            }

            return customShape;
        }
    });
    canvas.attachListeners();

    jCore.setActiveCanvas(canvas);


    $("#adam_toolbar span[type=draggable]").draggable(
        {
            revert: "invalid",
            helper: function() {
                return $(this).clone().removeAttr('rel').css('zIndex', 5).show().appendTo('body');
            },
            cursor: "move"
        }
    );

    $('#ProjectTitle').hover(function (e) {
        $('.icon-edit-title').css('display', 'block');
    }, function (e) {
        $('.icon-edit-title').css('display', 'none');
    }).click(function (e) {
        e.preventDefault();
        $('#ProjectTitle').css('display', 'none');
        $('.icon-edit-title').css('display', 'block');
        $('#txt-title').css('display', 'block').focus().val($('#ProjectTitle').html());
    });

    var save_name = function() {
        $('#ProjectTitle').css('display', 'block');
        $('#txt-title').css('display', 'none');
        if ($('#ProjectTitle').html() != $('#txt-title').val()){
            $('#ProjectTitle').html(Handlebars.Utils.escapeExpression($('#txt-title').val()));
            url = App.api.buildURL('pmse_Project', null, {id: project.uid});
            attributes = {name: Handlebars.Utils.escapeExpression($('#txt-title').val())};
            App.alert.show('saving', {level: 'process', title: 'LBL_SAVING', autoclose: false});
            App.api.call('update', url, attributes, {
                success: function (data) {
                    App.alert.dismiss('saving');
                },
                error: function (err) {
                }
            });
        }
    };
    $('#txt-title').focusout(function (e) {
        if ($.trim($('#txt-title').val()) !== '') {
            save_name();
        }
    }).keypress(function(e) {
        if(e.which == 13) {
            if ($.trim(this.value) != '') {
                App.alert.dismiss('error-project-name');
                save_name();
            }
            else {
                App.alert.show('error-project-name', {
                    level: 'warning',
                    messages: translate('LBL_PMSE_PROJECT_NAME_EMPTY','pmse_Project'),
                    autoClose: false
                });
            }
        }
    });

    $('#ButtonUndo').click(function () {
        jCore.getActiveCanvas().commandStack.undo();
        jCore.getActiveCanvas().RemoveCurrentMenu();
    });

    $('#ButtonRedo').click(function () {
        jCore.getActiveCanvas().commandStack.redo();
        jCore.getActiveCanvas().RemoveCurrentMenu();
    });

    $('#ButtonSave').click(function () {
        project.save();
        jCore.getActiveCanvas().RemoveCurrentMenu();
    });

    /**
     * Button that when clicked triggers the process design validator
     */
    $('#ButtonValidate').click(function() {
        traverseProcess();
        jCore.getActiveCanvas().RemoveCurrentMenu();
    });

    /**
     * Button that when clicked both saves the project and triggers the
     * process design validator
     */
    $('#ButtonSaveValidate').click(function() {
        project.save();
        traverseProcess();
        jCore.getActiveCanvas().RemoveCurrentMenu();
    });

    //HANDLE ZOOM DROPDOWN
    $('#zoom').change(function (e) {
        var newZoomValue;
        newZoomValue = parseInt($(this).val());
        jCore.getActiveCanvas().applyZoom(newZoomValue);
        refreshMarkers();
        $('.ui-layout-north').css('overflow', 'hidden');
    }).mouseenter(function() {
        $('.ui-layout-north').css('overflow', 'visible');
    });

    project.setUid(prjCode);
    project.setSaveInterval(parseInt(App.config.processDesignerAutosaveInterval));
    project.setCanvas(canvas);
    project.load(prjCode, {
        success: function() {
            $.extend(canvas, {'name': project.name});

            PROJECT_MODULE = project.process_definition.pro_module;
            project.init();

            // Check to see if auto-validate on import is turned on
            if (App.config.autoValidateProcessesOnImport &&
                // Check to see that the page the user came from was the project import page
                // Necessary to prevent re-validation if the user refreshes the canvas page
                App.router.getPreviousFragment() === 'pmse_Project/layout/project-import' &&
                // Check to see that the current URL has the unique data provided by the import page
                App.router.getFragment().indexOf('imported=true') !== -1) {
                traverseProcess();
            }
        }
    });
};

/**
 * Refreshes the error and warning marker icons placed on elements
 */
var refreshMarkers = function() {
    var allElements = getAllElements();
    for (var i = 0; i < allElements.length; i++) {
        allElements[i].clearIssueMarkers();
        if (allElements[i].hasError) {
            allElements[i].showErrorMarker();
        }
        if (allElements[i].hasWarning) {
            allElements[i].showWarningMarker();
        }
    }
};

/**
 * Traverses the process to access each element in order
 * @param {Object} silent is an optional boolean flag indicating if this validation should be run
 *                 silently (no alerts to the user)
 */
var traverseProcess = function(silent) {

    var validationTools = getValidationTools(silent);
    var startEvents = getStartEvents();

    // Prepare the canvas for traversal
    initializeTraversal(validationTools);

    // For each start event element, traverse the path starting from that element
    for (i = 0; i < startEvents.length; i++) {
        validatePathFromStartNode([startEvents[i]], validationTools);
    }

    // Perform final steps for traversal
    finishTraversal(validationTools);
};

/**
 * Performs actions necessary before beginning a validation traversal
 * @param {Object} validationTools is a collection of utility functions for validating element data
 */
var initializeTraversal = function(validationTools) {

    var i;
    var allElements = getAllElements();

    // Reset the hasBeenQueued and currentGatewayScope attributes of each element
    for (i = 0; i < allElements.length; i++) {
        delete allElements[i].hasBeenQueued;
        delete allElements[i].currentGatewayScope;
    }

    // Counting the entire validation as an element itself, start the progress tracker
    validationTools.progressTracker.incrementTotalElements();
    validationTools.progressTracker.start();
};

/**
 * Performs actions necessary at the end of a validation traversal
 * @param {Object} validationTools is a collection of utility functions for validating element data
 */
var finishTraversal = function(validationTools) {

    var i;
    var allElements = getAllElements();

    // Generate a warning for any elements that were unreachable during traversal
    for (i = 0; i < allElements.length; i++) {
        if (!allElements[i].hasBeenQueued && allElements[i].getType() !== 'AdamArtifact') {
            validationTools.createWarning(allElements[i], 'LBL_PMSE_ERROR_ELEMENT_UNREACHABLE');
        }
    }

    // Counting the entire validation as an element itself, initiate the bulk API call to start
    // gathering the element settings
    App.api.triggerBulkCall('get_element_settings');
    validationTools.progressTracker.incrementSettingsGathered();
};

/**
 * Returns an array containing all user-placed elements on the canvas
 * @return {Array}
 */
var getAllElements = function() {
    return jCore.getActiveCanvas().children.asArray().filter(function(elem) {
        return elem.type !== 'MultipleSelectionContainer' && elem.type !== 'AdamArtifact';
    });
};

/**
 * Returns an array containing all start events placed on the canvas
 * @return {Array}
 */
var getStartEvents = function() {
    return jCore.getActiveCanvas().children.asArray().filter(function(elem) {
        return elem.type === 'AdamEvent' && elem.getEventType() === 'START';
    });
};

/**
 * Updates the destination element's gateway scope depending on the current element
 * @param {Object} currElement is the current element being examined in the traversal
 * @param {Object} destElement is a destination element of the current element being examined in the traversal
 */
var setGatewayScope = function(currElement, destElement) {
    destElement.currentGatewayScope = currElement.currentGatewayScope.slice();
    if (currElement.getType() === 'AdamGateway') {
        if (currElement.getDirection() === 'DIVERGING') {
            destElement.currentGatewayScope.unshift(currElement.getGatewayType());
        } else if (currElement.getDirection() === 'CONVERGING') {
            destElement.currentGatewayScope.shift();
        }
    }
};

/**
 * Validates the elements along a path from a given start node
 * @param  {Array} queue is an array that initially contains only the start node element
 * @param {Object} validationTools is a collection of utility functions for validating element data
 */
var validatePathFromStartNode = function(queue, validationTools) {

    // Initialize the queue
    queue[0].hasBeenQueued = true;
    queue[0].currentGatewayScope = [];

    // While there are still elements in the queue, process the next one
    while (queue.length) {
        processNextElement(queue.shift(), queue, validationTools);
    }
};

/**
 * Processes the next element in the traversal queue
 * @param  {Object} currElement is the current element being traversed
 * @param  {Array} queue is an array of elements to be traversed in FIFO order
 * @param {Object} validationTools is a collection of utility functions for validating element data
 */
var processNextElement = function(currElement, queue, validationTools) {

    var i;
    var connectedElements = currElement.getDestElements();

    // Validate the current element
    if (currElement.validate) {
        currElement.validate(validationTools);
    }

    // For each unvisited element that the current element connects to, add it to the queue
    for (i = 0; i < connectedElements.length; i++) {

        if (!connectedElements[i].hasBeenQueued) {
            queueConnectedElement(currElement, connectedElements[i], queue);
        }
    }
};

/**
 * Adds a destination element to the queue, with the correct hasBeenQueued and
 * currentGatewayScope attributes
 * @param  {Object} currElement is the current element being traversed
 * @param  {Object} destElement is a destination element from currElement that
 *                  has not yet been queued
 * @param  {Array} queue is an array of elements to be traversed in FIFO order
 */
var queueConnectedElement = function(currElement, destElement, queue) {

    // Set the proper gateway scope of the destination element
    setGatewayScope(currElement, destElement);

    // Push the destination element onto the queue and mark it as queued
    queue.push(destElement);
    destElement.hasBeenQueued = true;
};

/**
 * Gathers together all the helper functions needed when validating an element
 * @param {Object} silent is an optional boolean flag indicating if this
 *                 validation should be run silently (no alerts to the user)
 * @return {Object} an object containing utility functions used in element validation
 */
var getValidationTools = function(silent) {
    return {
        'progressTracker': new ValidationProgressTracker(silent),
        'validateNumberOfEdges': validateNumberOfEdges,
        'validateAtom': validateAtom,
        'createWarning': createWarning,
        'createError': createError,
        'CriteriaEvaluator': CriteriaEvaluator,
        'getTargetModule': getTargetModule
    };
};

/*
 * Below are various utility functions that are used during a validation traversal of
 * the process definition.
 */

/**
 * Tracks the progress of validating the elements on the canvas. Displays the
 * current status of the validation process to the user and reports the total
 * errors found when complete
 * @param {Object} silent is an optional boolean flag indicating if this
 *                 validation should be run silently (no alerts to the user)
 */
var ValidationProgressTracker = function(silent) {
    this.totalElements = 0,
    this.numSettingsGathered = 0,
    this.totalValidations = 0,
    this.numValidated = 0,
    this.silent = silent,

    /**
     * Performs necessary actions to start the progress tracker
     */
    this.start = function() {

        // Mark the project as currently being validated
        project.isBeingValidated = true;

        // Update button status during validation
        this.updateButtons();

        // Start a fresh error table
        currentErrorTable = document.createElement('tbody');

        // Add the "Refreshing errors" indicator to the error pane
        $('#refreshing-errors').addClass('show');

        // Display the correct progress modal for non-silent validations
        this.showModal();
    },

    /**
     * Increment the total number of elements encountered, to keep track of how
     * many we need API responses for
     */
    this.incrementTotalElements = function() {
        this.totalElements++;
    },

    /**
     * Increments the number of elements we have received API responses for, so
     * that we can track when we have received responses for all of them
     */
    this.incrementSettingsGathered = function() {
        this.numSettingsGathered++;
        if (this.numSettingsGathered === this.totalElements) {

            // All element settings have been gathered, so start validating those settings
            this.startValidating();
        }
    },

    /**
     * Transitions the progress tracker from gathering element settings to validating
     * those settings
     */
    this.startValidating = function() {

        // Count all element validations as a single validation in itself
        this.incrementTotalValidations();

        // Display the correct progress modal for non-silent validations
        this.showModal();

        // We've received the settings information for all elements, so now we can send
        // their setting validation calls in one big bulk call instead of one-by-one
        App.api.triggerBulkCall('validate_element_settings');

        // Count all element validations as a single validation in itself
        this.incrementValidated();
    },

    /**
     * Increments the number of data validations that need to be done on element
     * settings, to keep track of how many we need API responses for
     */
    this.incrementTotalValidations = function() {
        this.totalValidations++;
    },

    /**
     * Increments the number of data validations that have been completed, so that
     * we can track when the validation process has been completed
     */
    this.incrementValidated = function() {
        this.numValidated++;
        if (this.numValidated === this.totalValidations) {

            // All elements have been validated, so report the results to the user
            this.finish();
        }
    },

    /**
     * Performs final actions after validation has finished
     */
    this.finish = function() {

        var errorsFound = currentErrorTable.rows.length;

        // Remove the "Refreshing errors" indicator from the error pane
        $('#refreshing-errors').removeClass();

        // Append the new error table body to the error table
        $('#Error-table').find('tbody').remove();
        $('#Error-table').append(currentErrorTable);

        // Close the error pane if no errors are found
        if (!errorsFound) {
            myLayout.close('south');
        } else if (!this.silent) {
            myLayout.open('south');
        }

        // Refresh the error/warning markers on the elements on the canvas
        refreshMarkers();

        // Display the correct progress modal for non-silent validations
        this.showModal();

        // Mark the project as no longer being validated
        project.isBeingValidated = false;

        // Update buttons after validation
        this.updateButtons();
    },

    /**
     * If validation is non-silent, displays the correct modal to show the user
     * the current status of the validation process
     */
    this.showModal = function() {

        var errorsFound;

        if (!this.silent) {
            App.alert.dismiss('getting_element_settings');
            App.alert.dismiss('validating_element_settings');
            if (this.numSettingsGathered < this.totalElements) {

                // Validation is in the gathering settings phase
                App.alert.show('getting_element_settings', {
                    level: 'process',
                    title: translate('LBL_PMSE_VALIDATOR_IN_PROGRESS_RETRIEVING'),
                    autoClose: false
                });
            } else if (this.numValidated < this.totalValidations) {

                // Validation is in the validating settings phase
                App.alert.show('validating_element_settings', {
                    level: 'process',
                    title: translate('LBL_PMSE_VALIDATOR_IN_PROGRESS_VALIDATING'),
                    autoClose: false
                });
            } else {

                // Validation is complete
                errorsFound = currentErrorTable.rows.length;
                App.alert.show('validation_results', {
                    level: 'success',
                    title: translate('LBL_PMSE_VALIDATOR_COMPLETE') + errorsFound
                });
            }
        }
    },

    /**
     * Updates the styling and action of buttons depending on the current state of
     * validation
     */
    this.updateButtons = function() {
        this.clearButtonStyleAndAction();
        this.updateValidateButton();
        this.updateSaveValidateButton();
        this.updateErrorPaneToggleButton();
    },

    /**
     * Clears the style and action from process validator buttons on the canvas toolbar
     */
    this.clearButtonStyleAndAction = function() {

        // Remove style and action from the validate button
        $('#ButtonValidate').off();
        $('#ButtonValidate > i').removeClass();

        // Remove style and action from the save+validate button
        $('#ButtonSaveValidate').off();
        $('#ButtonSaveValidate > i').removeClass();

        // Remove style and action from the error pane toggle button
        $('#ButtonToggleErrorPane').off();
        $('#ButtonToggleErrorPane > i').removeClass();
    },

    /**
     * Updates the styling and action of the validate button depending on the current
     * state of the validation process
     */
    this.updateValidateButton = function() {
        if (!project.isBeingValidated) {

            // Validate button should be ungreyed and have action
            $('#ButtonValidate').click(function() {
                traverseProcess();
                jCore.getActiveCanvas().RemoveCurrentMenu();
            });
            $('#ButtonValidate > i').addClass('fa fa-check-square check-square-on');
        } else {

            // Validate button should be greyed out and have no action
            $('#ButtonValidate > i').addClass('fa fa-check-square check-square-off');
        }
    },

    /**
     * Updates the styling and action of the save+validate button depending on the
     * current state of the validation process
     */
    this.updateSaveValidateButton = function() {
        if (!project.isBeingValidated) {

            // Save+validate button should be ungreyed and have action
            $('#ButtonSaveValidate').click(function() {
                project.save();
                traverseProcess();
                jCore.getActiveCanvas().RemoveCurrentMenu();
            });
            $('#ButtonSaveValidate > i').filter(':first').addClass('fa fa-save fa-sm save-on');
            $('#ButtonSaveValidate > i').filter(':last').addClass('fa fa-check-square fa-sm check-square-on');
        } else {

            // Save+validate button should be greyed out and have no action
            $('#ButtonSaveValidate > i').filter(':first').addClass('fa fa-save fa-sm save-off');
            $('#ButtonSaveValidate > i').filter(':last').addClass('fa fa-check-square fa-sm check-square-off');
        }
    },

    /**
     * Updates the styling and action of the error pane toggle button depending on the
     * current state of the error table
     */
    this.updateErrorPaneToggleButton = function() {

        if ($('#Error-table > tbody > tr').length) {

            // Error pane toggle button should be ungreyed and have action
            $('#ButtonToggleErrorPane').click(function() {
                myLayout.toggle('south');
            });
            $('#ButtonToggleErrorPane > i').addClass('fa fa-exclamation-triangle exclamation-triangle-on');
        } else {

            // Error pane toggle button should be greyed out and have no action
            $('#ButtonToggleErrorPane > i').addClass('fa fa-exclamation-triangle exclamation-triangle-off');
        }

        // Set the correct tooltip for the error pane toggle button
        $('#ButtonToggleErrorPane').attr('data-original-title', project.isBeingValidated ?
            translate('LBL_PMSE_VALIDATOR_TOOLTIP_IN_PROGRESS') :
            currentErrorTable.rows.length + translate('LBL_PMSE_VALIDATOR_TOOLTIP_ISSUES'));
    };
};

/**
 * Validates that an element has a proper number of incoming and outgoing edges
 * @param  {integer} minIncoming is the minimum number of incoming edges allowed for the element
 * @param  {integer} maxIncoming is the maximum number of incoming edges allowed for the element
 * @param  {integer} minOutgoing is the minimum number of outgoing edges allowed for the element
 * @param  {integer} maxOutgoing is the maximum number of outgoing edges allowed for the element
 * @param  {Object} element is the element on the canvas that is currently being examined/validated
 */
var validateNumberOfEdges = function(minIncoming, maxIncoming, minOutgoing, maxOutgoing, element) {
    var incomingEdges = element.getSourceElements().length;
    var outgoingEdges = element.getDestElements().length;
    // Depending on element type, check proper number of incoming and outgoing edges
    if (minIncoming && incomingEdges < minIncoming) {
        createWarning(element, 'LBL_PMSE_ERROR_FLOW_INCOMING_MINIMUM', minIncoming);
    }
    if (maxIncoming && incomingEdges > maxIncoming) {
        createWarning(element, 'LBL_PMSE_ERROR_FLOW_INCOMING_MAXIMUM', maxIncoming);
    }
    if (minOutgoing && outgoingEdges < minOutgoing) {
        createWarning(element, 'LBL_PMSE_ERROR_FLOW_OUTGOING_MINIMUM', minOutgoing);
    }
    if (maxOutgoing && outgoingEdges > maxOutgoing) {
        createWarning(element, 'LBL_PMSE_ERROR_FLOW_OUTGOING_MAXIMUM', maxOutgoing);
    }
};

/**
 * Validates that the data the criterion atom refers to exists in the database.
 * @param {string} type is the type attribute of the atom being validated
 * @param {string} module is the module attribute of the atom being validated
 * @param {string} field is the field attribute of the atom being validated
 * @param {string} value is the value attribute of the atom being validated
 * @param {Object} element is the element on the canvas that is currently being examined/validated
 * @param {Object} validationTools is a collection of utility functions for validating element data
 */
var validateAtom = function(type, module, field, value, element, validationTools) {
    var i;
    var searchInfo = getSearchInfo(type, module, field, value);
    var options = {
        'bulk': 'validate_element_settings'
    };
    if (searchInfo.url) {
        validationTools.progressTracker.incrementTotalValidations();
        App.api.call('read', searchInfo.url, null, {
            success: function(data) {
                for (i = 0; i < data.result.length; i++) {
                    if (data.result[i].value === searchInfo.key) {
                        return;
                    }
                }
                // Since some types of data can be gathered from different sources,
                // check any backup sources of the data
                if (searchInfo.backupSearchFunction && searchInfo.backupSearchFunction()) {
                    return;
                }
                createWarning(element, 'LBL_PMSE_ERROR_DATA_NOT_FOUND', searchInfo.text);
            },
            error: function(data) {
                createWarning(element, 'LBL_PMSE_ERROR_DATA_NOT_FOUND', searchInfo.text);
            },
            complete: function(data) {
                validationTools.progressTracker.incrementValidated();
            }
        }, options);
    }
};

/**
 * Returns the correct API endpoint URL, key to search for at that endpoint, and a text
 * representation of the endpoint type, based upon the criterion atom attributes
 * @param {string} type is the type attribute of the atom being validated
 * @param {string} module is the module attribute of the atom being validated
 * @param {string} field is the field attribute of the atom being validated
 * @param {string} value is the value attribute of the atom being validated
 * @return {Object} an object containing the correct URL, search key, and text
 */
var getSearchInfo = function(type, module, field, value) {

    var url;
    var text;
    var key;
    var backupSearchFunction;

    switch (type) {
        case 'MODULE':
            key = field;
        case 'VARIABLE':
        case 'recipient':
            url = App.api.buildURL('pmse_Project/CrmData/fields/' + module + '?base_module=' + getTargetModule());
            text = 'Module field';
            key = key || value;
            backupSearchFunction = function() {
                var fields = App.metadata.getModule(module.charAt(0).toUpperCase() + module.slice(1)).fields;
                for (fieldName in fields) {
                    if (fieldName === key) {
                        return true;
                    }
                }
            };
            break;
        case 'USER_IDENTITY':
            url = App.api.buildURL('pmse_Project/CrmData/users/');
            text = 'User';
            key = value;
            break;
        case 'USER_ROLE':
        case 'role':
            url = App.api.buildURL('pmse_Project/CrmData/rolesList/');
            text = 'Role';
            key = value;
            break;
        case 'RELATIONSHIP':
            key = value;
        case 'user':
            url = App.api.buildURL('pmse_Project/CrmData/related/' + getTargetModule());
            text = 'Module relationship';
            key = key || module;
            break;
        case 'TEAM':
        case 'team':
            url = App.api.buildURL('pmse_Project/CrmData/teams/public/');
            text = 'Team';
            key = value;
            break;
        case 'CONTROL':
            url = App.api.buildURL('pmse_Project/CrmData/activities/' + project.uid);
            text = 'Form activity';
            key = field;
            break;
        case 'ALL_BUSINESS_RULES':
            url = App.api.buildURL('pmse_Project/CrmData/rulesets/' + project.uid);
            text = 'Business rule';
            key = value;
            break;
        case 'BUSINESS_RULES':
            url = App.api.buildURL('pmse_Project/CrmData/businessrules/' + project.uid);
            text = 'Business rule action';
            key = field;
            break;
        case 'TEMPLATE':
            url = App.api.buildURL('pmse_Project/CrmData/emailtemplates/' + getTargetModule());
            text = 'Email template';
            key = value;
            break;
    };

    return {
        url: url,
        text: text,
        key: key,
        backupSearchFunction: backupSearchFunction
    };
};

/**
 * Adds a new warning to the error list table
 * @param {Object} element is the element on the canvas that is currently being examined/validated
 * @param {string} warningLabel contains the error text to be presented to the user about the error
 * @param {string} field is an optional value representing a specific field that the error refers to
 */
var createWarning = function(element, warningLabel, field) {
    createError(element, warningLabel, field, true);
};

/**
 * Adds a new error to the error list table
 * @param {Object} element is the element on the canvas that is currently being examined/validated
 * @param {string} errorLabel contains the error text to be presented to the user about the error
 * @param {string} field is an optional value representing a specific field that the error refers to
 */
var createError = function(element, errorLabel, field, warning) {

    // Get the information about the error
    var errorName = field ? (translate(errorLabel) + ': ' + field) : translate(errorLabel);
    var errorInfo = translate(errorLabel + '_INFO');

    // Insert a new row into the error table at the correct index
    var newRow = createErrorRow(element);

    // Insert new cells into the new table row
    var nameCell = newRow.insertCell(0);
    var errorCell = newRow.insertCell(1);

    // Insert the contents into the new table row cells
    nameCell.appendChild(createErrorName(element));
    errorCell.appendChild(createErrorIcon(warning));
    errorCell.appendChild(createErrorText(errorName, errorInfo));

    // Update the error/warning status of the element for adding marker icons
    if (warning) {
        element.hasWarning = true;
    } else {
        element.hasError = true;
    }
};

var createErrorRow = function(element) {
    var rowNumber;
    var otherElement;
    for (rowNumber = 0; rowNumber < currentErrorTable.rows.length; rowNumber++) {
        otherElementName = currentErrorTable.rows[rowNumber].cells[0].innerText;
        if (element.getName() < otherElementName) {
            break;
        }
    }
    return currentErrorTable.insertRow(rowNumber);
};

var createErrorName = function(element) {
    var nameText = document.createElement('a');

    // Set the text content and click handler of the name cell element
    nameText.textContent = element.getName();
    nameText.onclick = function() {

        // When the user clicks the element name, select the element on the canvas and center the canvas view
        // on it
        canvas.emptyCurrentSelection();
        canvas.addToSelection(element);
        centerCanvasOnElement(element);
    };

    return nameText;
};

var createErrorIcon = function(warning) {
    var errorIcon = document.createElement('i');

    // Set the icon type for the error
    errorIcon.setAttribute('rel', 'tooltip');
    errorIcon.setAttribute('data-placement', 'top');
    if (warning) {
        errorIcon.setAttribute('class', 'fa fa-exclamation-triangle fa');
        errorIcon.setAttribute('style', 'color: #FFCC00');
        errorIcon.setAttribute('data-original-title', translate('LBL_PMSE_VALIDATOR_WARNING_INFO'));
    } else {
        errorIcon.setAttribute('class', 'fa fa-exclamation-circle fa');
        errorIcon.setAttribute('style', 'color: red');
        errorIcon.setAttribute('data-original-title', translate('LBL_PMSE_VALIDATOR_ERROR_INFO'));
    }

    return errorIcon;
};

var createErrorText = function(errorName, errorInfo) {
    var errorText = document.createElement('span');

    // Set the text content and tooltip of the error cell element
    errorText.textContent = '  ' + errorName;
    errorText.setAttribute('rel', 'tooltip');
    errorText.setAttribute('data-placement', 'top');
    errorText.setAttribute('data-original-title', errorInfo);

    return errorText;
};

/**
 * Centers the canvas view on the given element
 * @param {Object} element is the element on the canvas that is currently being examined/validated
 */
var centerCanvasOnElement = function(element) {

    // Calculate the correct scroll positions for the horizontal and vertical scrollbars in the center pane
    var centerPane = myLayout.center.pane[0];
    var targetScrollLeft = element.zoomX - (centerPane.clientWidth / 2);
    var targetScrollTop = element.zoomY - (centerPane.clientHeight / 2);
    targetScrollLeft = targetScrollLeft < 0 ? 0 : targetScrollLeft;
    targetScrollTop = targetScrollTop < 0 ? 0 : targetScrollTop;

    // Move the horizontal and vertical scrollbars to the calculated positions
    centerPane.scrollLeft = targetScrollLeft;
    centerPane.scrollTop = targetScrollTop;
};

/**
 * Returns the target module of the current process definition being designed
 * @return {string} The name of the target module
 */
var getTargetModule = function() {
    return project.process_definition.pro_module;
};

/**
 * CriteriaEvaluator provides a way to analyze logical statements in a
 * criteria box. The addOr or addAnd methods accept JSON objects from
 * parsed criteria boxes, and can be used to build larger statements
 * across multiple criteria boxes. Included are methods to determine
 * whether the logical statement is always true or always false.
 */
var CriteriaEvaluator = function() {
    this.criteria = [],

    // Some criteria boxes count empty criteria as true (i.e. start events). For others,
    // it is false (i.e. diverging gateways). The following property can be used to
    // adjust whether or not to count empty criteria as true for this CriteraEvaluator
    // object. By default, it is set to false.
    this.emptyCriteriaIsTrue = false;

    /**
     * Appends a logical statement onto the current one represented by this
     * CriteriaEvaluator as an OR
     * @param {Array} newCriteria is an array of JSON objects parsed
     *                from a set of criteria box data
     */
    this.addOr = function(newCriteria) {
        if (newCriteria.length) {
            if (this.criteria.length) {
                this.criteria.push({
                    expType: 'LOGIC',
                    expValue: 'OR'
                });
            }
            this.criteria.push(this.simplifyCriteria(newCriteria));
        }
    },

    /**
     * Appends a logical statement onto the current one represented by this
     * CriteriaEvaluator as an AND
     * @param {Array} newCriteria is an array of JSON objects parsed
     *                from a set of criteria box data
     */
    this.addAnd = function(newCriteria) {
        if (newCriteria.length) {
            if (this.criteria.length) {
                this.criteria.push({
                    expType: 'LOGIC',
                    expValue: 'AND'
                });
            }
            this.criteria.push(this.simplifyCriteria(newCriteria));
        }
    },

    /**
     * Determines if the logical statement represented by this CriteriaEvaluator is
     * a tautology (always true).
     * @return {boolean} true if there is no way for the statement to be false; false otherwise
     */
    this.isAlwaysTrue = function() {
        var result;

        // If criteria is empty, and empty criteria is true, then the statement
        // is always true, so return true
        if (!this.criteria.length) {
            return this.emptyCriteriaIsTrue ? true : false;
        }

        // If the negation of the statement is always false, then the statement is always true
        this.negateExpression(this.criteria);
        result = this.isAlwaysFalse();
        this.negateExpression(this.criteria);
        return result;
    },

    /**
     * Determines if the logical statement represented by this CriteriaEvaluator is
     * a contradiction (always false).
     * @return {boolean} true if there is no way for the statement to be true; false otherwise
     */
    this.isAlwaysFalse = function() {
        var i;
        var usersLogic;

        // Get a list of all possible ways the statement could be true
        var possibilities = this.generatePossibilities(this.criteria.slice());

        // If criteria is empty, and empty criteria is true, then the statement
        // is always true, so return true
        if (!this.criteria.length) {
            return this.emptyCriteriaIsTrue ? false : true;
        }

        // If one of the possible ways for the statement to be true is
        // actually valid, then return false
        for (i = 0; i < possibilities.length; i++) {
            usersLogic = new LogicTracker();
            usersLogic.add(possibilities[i]);
            if (usersLogic.isValid()) {
                return false;
            }
        }

        // If we reach this point, there are no valid possibilities for the
        // statement to be true, so it must be always false
        return true;
    },

    /**
     * Simplifies JSON-parsed criteria by getting rid of any '( )' groupings and 'NOT'
     * statements
     * @param  {Array} criteria is array of JSON objects parsed from a set of criteria box data
     * @return {Array} an array of the simplified criteria objects
     */
    this.simplifyCriteria = function(criteria) {

        // Convert all '( )' enclosed expressions in the criteria into nested arrays
        criteria = this.getRidOfParentheses(criteria);

        // Perform all negations in the expression in order to remove all 'NOT' Operands
        this.getRidOfNOTs(criteria);

        return criteria;
    },

    /**
     * Takes an array of atom objects and removes any '()' parenthesized groupings by
     * replacing the groupings with nested arrays that are easier to work with.
     * @param  {Array} criteria is array of JSON objects parsed from a set of criteria box data
     * @return {Array} an array consisting of the original criteria data, but with parentheses
     *                 removed and nested parenthesized groupings converted to nested arrays
     */
    this.getRidOfParentheses = function(criteria) {
        var newCriteria = [];

        // Recursively convert parenthesized statements into arrays instead
        while (criteria.length) {
            if (criteria[0].expType === 'GROUP' && criteria[0].expValue === '(') {
                criteria.shift();
                newCriteria.push(this.getRidOfParentheses(criteria));
            } else if (criteria[0].expType === 'GROUP' && criteria[0].expValue === ')') {
                criteria.shift();
                return newCriteria;
            } else {
                newCriteria.push(criteria.shift());
            }
        }
        return newCriteria;
    },

    /**
     * Performs any negation within an array of JSON-parsed criteria, and removes the 'NOT' operators.
     * @param  {Array} criteria is array of JSON objects parsed from a set of criteria box data
     *                 that has had any parenthesized statements converted to nested arrays via the
     *                 getRidOfParentheses() method
     * @return {Array} an array consisting of criteria equivalent to the given criteria, but with 'NOT'
     *                 statements removed
     */
    this.getRidOfNOTs = function(criteria) {
        var i;

        // Recurse to the innermost arrays first
        for (i = 0; i < criteria.length; i++) {
            if (Array.isArray(criteria[i])) {
                criteria[i] = this.getRidOfNOTs(criteria[i]);
            }
        }

        // If we encounter a 'NOT' operator, remove it from criteria, and invert the following expression
        for (i = 0; i < criteria.length; i++) {
            if (criteria[i].expType === 'LOGIC' && criteria[i].expValue === 'NOT') {
                criteria.splice(i, 1);
                this.negateExpression(criteria[i]);
            }
        }
        return criteria;
    },

    /**
     * Returns an array of ALL combinations of values that could make the current criteria statement
     * true. Note that this does not mean each combination is possible or valid, as it does not take
     * into account contradictions among operators and values. Each subarray of the returned array
     * can be thought of as an 'OR' with the other subarrays. Within each of those subarrays, each
     * criteria atom can be thought of as an 'AND' with the other criteria atoms.
     * @param  {Array} criteria is array of JSON objects parsed from a set of criteria box data that
     *                 has been simplified via the simplifyCriteria method
     * @return {Array} an array of subarrays; each subarray is a collection of criteria atoms that represents
     *                 a possible combination of 'AND's that could render the logical statement true
     */
    this.generatePossibilities = function(criteria) {
        var i;
        var j;
        var k;
        var dataToReturn = [];
        var temp = [[]];
        var combinations;

        // Recurse into the innermost nested/parenthesized statement
        for (i = 0; i < criteria.length; i++) {
            if (Array.isArray(criteria[i])) {
                criteria[i] = this.generatePossibilities(criteria[i]);
            }
        }

        // Iterate through the criteria, and add each possible combination of
        // criteria values as subarrays to the dataToReturn array
        for (i = 0; i < criteria.length; i++) {

            if (criteria[i].expType === 'LOGIC' && criteria[i].expValue === 'OR') {

                // We've reached an OR statement, so add the temporary array contents
                // to dataToReturn and start a new temporary array
                for (j = 0; j < temp.length; j++) {
                    dataToReturn.push(temp[j]);
                }
                temp = [[]];
            } else if (Array.isArray(criteria[i])) {

                // If we encounter an array at this point, it has already been
                // evaluated to an array of subarrays. Afterward, temp should
                // consist of all possible combinations of the subarrays with
                // the current temp subarrays.
                combinations = [];
                for (j = 0; j < temp.length; j++) {
                    for (k = 0; k < criteria[i].length; k++) {
                        combinations.push(temp[j].concat(criteria[i][k]));
                    }
                }
                temp = combinations;
            } else if (criteria[i].expType !== 'LOGIC') {

                // If we encounter a single expression, add it to all temp subarrays
                for (j = 0; j < temp.length; j++) {
                    temp[j].push(criteria[i]);
                }
            }
        }

        // Since we have finished iterating, check if temp has unpushed elements
        for (i = 0; i < temp.length; i++) {
            if (temp[i].length) {
                dataToReturn.push(temp[i]);
            }
        }

        return dataToReturn;
    },

    /**
     * Negates the given expression, either a single criterion atom object or array of
     * criterion atom objects
     * @param  {Object} expression is either a single criterion atom object from parsed
     *                 criteria box data, or an array of them. This array should not
     *                 contain any '(', ')', or 'NOT' operators.
     */
    this.negateExpression = function(expression) {
        var i;

        // If the expression is an array of expressions, then negate it recursively.
        // Otherwise, negate the single expression
        if (Array.isArray(expression)) {
            for (i = 0; i < expression.length; i++) {
                this.negateExpression(expression[i]);
            }
        } else {
            this.negateSingleExpression(expression);
        }
    },

    /**
     * Negates a single criterion atom object's operator
     * @param  {Object} expression is a single criterion atom object. It must not be a
     *                  '(', ')', or 'NOT' operator.
     */
    this.negateSingleExpression = function(expression) {

        // Provides mappings for negations of logic values
        var invertLogic = {
            'equals': 'not_equals',
            'not_equals': 'equals',
            'starts_with': 'not_starts_with',
            'not_starts_with': 'starts_with',
            'ends_with': 'not_ends_with',
            'not_ends_with': 'ends_with',
            'contains': 'does_not_contain',
            'does_not_contain': 'contains',
            'AND': 'OR',
            'OR': 'AND'
        };
        if (expression.expType === 'LOGIC') {

            // Inverts AND/OR logic operators
            expression.expValue = invertLogic[expression.expValue];
        } else {

            // Inverts all other logic operators
            expression.expOperator = invertLogic[expression.expOperator];
        }
    };
};

/**
 * LogicTracker stores a collection of LogicAtoms which together hold the
 * information about an entire logical statement in a criteria box, and can
 * be used to evauate the logical statement
 */
var LogicTracker = function() {
    this.atoms = [],

    /**
     * Adds an array of criteria to this LogicTracker
     * @param {Array} criteria is an array in the form produced by the generatePossibilities
     *                function of the CriteriaEvaluator object, where the array
     *                consists of subarrays, and each subarray consists of a
     *                collection of criterion atoms (no ANDs, ORs, NOTs, or parentheses) that
     *                represent a chain of AND statements
     */
    this.add = function(criteria) {
        var i;
        var k;
        var found = false;
        var newAtom;
        for (i = 0; i < criteria.length; i++) {
            found = false;

            // For each criterion atom in the criteria, check if the data it refers to
            // (user, module field, etc.) has been added already to this LogicTracker.
            // If it has, then update the entry in this LogicTracker with the operator
            // and value of the criterion atom.
            for (k = 0; k < this.atoms.length; k++) {
                if (criteria[i].expType === this.atoms[k].type) {
                    if (criteria[i].expModule === this.atoms[k].module) {
                        if (criteria[i].expField === this.atoms[k].field) {
                            this.atoms[k].add(criteria[i].expOperator, criteria[i].expValue);
                            found = true;
                            break;
                        }
                    }
                }
            }

            // Otherwise, create a new unique entry in this LogicTracker using the
            // expType, expModule, and expFields as a key.
            if (!found) {
                newAtom = new LogicAtom(criteria[i].expType, criteria[i].expModule, criteria[i].expField);
                newAtom.add(criteria[i].expOperator, criteria[i].expValue);
                this.atoms.push(newAtom);
            }
        }
    },

    /**
     * Evaluates whether it is possible for the logical statement represented by this LogicTracker to be true
     * @return {boolean} true if the logical statement represented by this LogicTracker is valid; false otherwise
     */
    this.isValid = function() {
        var i;
        for (i = 0; i < this.atoms.length; i++) {
            if (!this.atoms[i].isValid()) {
                return false;
            }
        }
        return true;
    };
};

/**
 * LogicAtom represents a single property referenced in a logical expression.
 * It holds information about all constraints placed on that property, and can
 * be used to evaluate the constraints together. A property is defined by a
 * unique key combination of expType, expModule, and expField fields from a
 * criterion atom object.
 * @param {string} type is the expType field of the property
 * @param {string} module is the expModule field of the property
 * @param {field} field is the expField field of the property
 */
var LogicAtom = function(expType, expModule, expField) {

    this.type = expType,
    this.module = expModule,
    this.field = expField,
    this.operators = {
        'equals': [],
        'not_equals': [],
        'starts_with': [],
        'not_starts_with': [],
        'ends_with': [],
        'not_ends_with': [],
        'contains': [],
        'does_not_contain': []
    },

    /**
     * Adds a constraint to the property that this LogicAtom represents
     * @param {string} operator is the operator that the constraint uses (see this.operators)
     * @param {string} value is the specific value of the constraint
     */
    this.add = function(operator, value) {
        if (this.operators[operator]) {
            this.operators[operator].push(value);
        }
    },

    /**
     * Evaluates all constraints on this LogicAtom to check if they are valid
     * together. Examples of invalid LogicAtoms inlcude properties that are
     * required to equal two different values simultaneously, are required to
     * contain values that they are also required not to contain, etc.
     * @return {boolean} true if this LogicAtom is valid; false otherwise
     */
    this.isValid = function() {
        var result = true;

        // Check for any contradictions from 'is' constraints
        if (result && this.operators.equals.length) {
            if (this.type !== 'USER_ROLE') {

                // Exception for roles (users can have multiple roles)
                result = result && arrayContainsOneDistinctValue(this.operators.equals);
            }
            result = result && arrayDoesNotContainValues(this.operators.equals, this.operators.not_equals) &&
                wordsStartWithPrefixes(this.operators.equals, this.operators.starts_with) &&
                wordsDoNotStartWithPrefixes(this.operators.equals, this.operators.not_starts_with) &&
                wordsEndWithSuffixes(this.operators.equals, this.operators.ends_with) &&
                wordsDoNotEndWithSuffixes(this.operators.equals, this.operators.not_ends_with) &&
                wordsContainSubstrings(this.operators.equals, this.operators.contains) &&
                wordsDoNotContainSubstrings(this.operators.equals, this.operators.does_not_contain);
        }

        // Check for any contradictions from 'starts with' constraints
        if (result && this.operators.starts_with.length) {
            result = result && multiplePrefixesAreAllValid(this.operators.starts_with) &&
                wordsDoNotStartWithPrefixes(this.operators.starts_with, this.operators.not_starts_with) &&
                wordsDoNotContainSubstrings(this.operators.starts_with, this.operators.does_not_contain);
        }

        // Check for any contradictions from 'ends with' constraints
        if (result && this.operators.ends_with.length) {
            result = result && multipleSuffixesAreAllValid(this.operators.ends_with) &&
                wordsDoNotEndWithSuffixes(this.operators.ends_with, this.operators.not_ends_with) &&
                wordsDoNotContainSubstrings(this.operators.ends_with, this.operators.does_not_contain);
        }

        // Check for any contradictions from 'contains' constraints
        if (result && this.operators.contains.length) {
            result = result && wordsDoNotContainSubstrings(this.operators.contains, this.operators.does_not_contain);
        }

        return result;
    },

    /**
     * Checks that there is only one distinct value inside the given array
     * @param  {Array} an array of string values
     * @return {boolean} true if there is only one distinct value in the array; false otherwise
     */
    arrayContainsOneDistinctValue = function(array) {
        return _.uniq(array).length < 2;
    },

    /**
     * Checks that the given array does not contain any of the given values
     * @param  {Array} values is an array of string values
     * @param  {Array} array is an array of string values
     * @return {boolean} false if any string in values is found in array; true otherwise
     */
    arrayDoesNotContainValues = function(values, array) {
        var i;
        for (i = 0; i < values.length; i++) {
            if (array.indexOf(values[i]) !== -1) {
                return false;
            }
        }
        return true;
    },

    /**
     * Checks whether all of the given words begin with all of the given prefixes
     * @param  {Array} words is an array of string values
     * @param  {Array} prefixes is an array of string values
     * @return {boolean} true if all strings in words begin with all strings in prefixes; false otherwise
     */
    wordsStartWithPrefixes = function(words, prefixes) {
        var i;
        var j;
        for (i = 0; i < words.length; i++) {
            for (j = 0; j < prefixes.length; j++) {
                if (words[i].indexOf(prefixes[j]) !== 0) {
                    return false;
                }
            }
        }
        return true;
    },

    /**
     * Checks whether none of the given words begin with any of the given prefixes
     * @param  {Array} words is an array of string values
     * @param  {Array} prefixes is an array of string values
     * @return {boolean} false if any string in words begins with any string in prefixes; true otherwise
     */
    wordsDoNotStartWithPrefixes = function(words, prefixes) {
        var i;
        var j;
        for (i = 0; i < words.length; i++) {
            for (j = 0; j < prefixes.length; j++) {
                if (words[i].indexOf(prefixes[j]) === 0) {
                    return false;
                }
            }
        }
        return true;
    },

    /**
     * Checks whether all of the given words end with all of the given suffixes
     * @param  {Array} words is an array of string values
     * @param  {Array} suffixes is an array of string values
     * @return {boolean} true if all strings in words end with all strings in suffixes; false otherwise
     */
    wordsEndWithSuffixes = function(words, suffixes) {
        var i;
        var j;
        for (i = 0; i < words.length; i++) {
            for (j = 0; j < suffixes.length; j++) {
                if (words[i].substring(words[i].length - suffixes[j].length) !== suffixes[j]) {
                    return false;
                }
            }
        }
        return true;
    },

    /**
     * Checks whether any of the given words end with any of the given suffixes
     * @param  {Array} words is an array of string values
     * @param  {Array} suffixes is an array of string values
     * @return {boolean} false if any string in words ends with any string in suffixes; true otherwise
     */
    wordsDoNotEndWithSuffixes = function(words, suffixes) {
        var i;
        var j;
        for (i = 0; i < words.length; i++) {
            for (j = 0; j < suffixes.length; j++) {
                if (words[i].substring(words[i].length - suffixes[j].length) === suffixes[j]) {
                    return false;
                }
            }
        }
        return true;
    },

    /**
     * Checks whether all of the given words contain all of the given substrings
     * @param  {Array} words is an array of string values
     * @param  {Array} substrings is an array of string values
     * @return {boolean} true if all strings in words contain all strings in substrings; false otherwise
     */
    wordsContainSubstrings = function(words, substrings) {
        var i;
        var j;
        for (i = 0; i < words.length; i++) {
            for (j = 0; j < substrings.length; j++) {
                if (words[i].indexOf(substrings[j]) === -1) {
                    return false;
                }
            }
        }
        return true;
    },

    /**
     * Checks whether any of the given words contain any of the given substrings
     * @param  {Array} words is an array of string values
     * @param  {Array} substrings is an array of string values
     * @return {boolean} false if any strings in words contain any strings in substrings; true otherwise
     */
    wordsDoNotContainSubstrings = function(words, substrings) {
        var i;
        var j;
        for (i = 0; i < words.length; i++) {
            for (j = 0; j < substrings.length; j++) {
                if (words[i].indexOf(substrings[j]) !== -1) {
                    return false;
                }
            }
        }
        return true;
    },

    /**
     * Checks whether all string values in the array could represent the beginning of the same word.
     * For example, ['app', 'appl', 'a', 'apple'] are all valid prefixes of the word 'apple'
     * @param  {Array} array is an array of string values
     * @return {boolean} false if any prefixes contradict each other; true otherwise
     */
    multiplePrefixesAreAllValid = function(array) {
        var i;
        var k;

        // Sort the array in order by string length
        array.sort(function(a, b) {
            return a.length - b.length;
        });

        // For each index of the array, check that the string in that index
        // is prefixed by every string in a lower index
        for (i = 0; i < array.length; i++) {
            for (k = 0; k < i; k++) {
                if (!wordsStartWithPrefixes([array[i]], [array[k]])) {
                    return false;
                }
            }
        }
        return true;
    },

    /**
     * Checks whether all string values in the array could represent the ending of the same word.
     * For example, ['e', 'ple', 'le', 'apple'] are all valid suffixes of the word 'apple'
     * @param  {Array} array is an array of string values
     * @return {boolean} false if any suffixes contradict each other; true otherwise
     */
    multipleSuffixesAreAllValid = function(array) {
        var i;
        var k;

        // Sort the array in order by string length
        array.sort(function(a, b) {
            return a.length - b.length;
        });

        // For each index of the array, check that the string in that index
        // is suffixed by every string in a lower index
        for (i = 0; i < array.length; i++) {
            for (k = 0; k < i; k++) {
                if (!wordsEndWithSuffixes([array[i]], [array[k]])) {
                    return false;
                }
            }
        }
        return true;
    };
};
