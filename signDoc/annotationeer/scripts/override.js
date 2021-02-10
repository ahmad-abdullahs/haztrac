/**
 * <p>This Javascript file is for overriding existing functions and variables in the Annotationeer
 * web application if you decide to change it with your implementation.</p>
 *
 * <p>This way, when new code changes are retrieved from the repository, the core files are intact and
 * your custom functionality  and settings will not be affected.</p>
 *
 * <p>By default, the function names that start with orig are called within the overridden functions. If
 * you have a different implementation, then comment out the lines affected and add in your code.</p>
 *
 * <p>Uncomment the function(s) that you wish to override. These are the most common when you start off
 * using it. Any other functions that you intend to override still need to be placed in this file so that
 * you will have not merging issues when updating the core files.</p>
 * @namespace
 */
var Override = {};

/**
 * Place overridden variables from default.js, message.js and urls.js.<br/>
 * This will be executed when PageManager.initWebAppPreferences() is called.
 * @memberof Override
 * @function overrideDefaultVariables
 */
Override.overrideDefaultVariables = function () {
    Default.WATERMARK_SHOW = false;
    Default.SAVE_ALL_ANNOTATIONS_ONE_TIME = false;
    Default.BOOKMARK_ENABLE = true;
    Annotationeer.username = parent.user_id;
    Annotationeer.user_name = parent.user_name;
    Default.ANNOTATION_SELECTED_LINEWIDTH = 2;
    Default.DRAW_WIDTH = 1;
    Message.MARK_REQUIREMENT = 'Mark Required';
    Message.LOCATION_REQUIREMENT = 'Location Required';
    Message.COMMENT_SAVE_ERROR = 'error';
//Annotationeer.currentDocument.documentId=parent.doc;
    /**
     * The default color foreground for annotations that use this feature.
     * @default #ff0000 (red)
     * @type {string}
     */
    Default.DRAW_COLOR_FOREGROUND = '#000000';

    /**
     * The default color background for annotations that use this feature.
     * @default #ffff00 (yellow)
     * @type {string}
     */
    Default.DRAW_COLOR_BACKGROUND = '#ffffff';
    Default.ANNOTATION_TYPE_TEXT_CHAR_LIMIT = 70;
    PageManager.consoleLog(parent.welders_variable);
}

document.addEventListener('DOMContentLoaded', function (e) {

    $('button#viewAnnotations').click();
    $('button#sidebarToggle').click();

}, false);

var origDownloadAnnotations = Annotationeer.downloadAnnotations;
Annotationeer.downloadAnnotations = function (reload) {
    origDownloadAnnotations(reload);
}


/**
 * <p>This is where you place code to download annotations from the server and place them in arrays annotations and
 * highlightTexts. Once populated, loop through these 2 array objects and add them to the PDF pages.</p>
 * @function
 * @memberof Annotationeer
 * @param {boolean} reload Reload annotations in the sidebar after retrieving data from the backend.
 */
Annotationeer.downloadAnnotations = function (reload) {

    annotations = [];
    // -chnaged to below- var annotationURL = Url.restUrl + 'annotations/' + Annotationeer.currentDocument.documentId;
    // ahmad
    // -----START-----
    if (parent.SUGAR) {
        var ele = parent.document.getElementById('signDocframe');
        if (!ele) {
            ele = parent.document.getElementById('signDocframeRecordPreview');
        }

        var annotationURL = Url.restUrl + 'annotations/' + Annotationeer.currentDocument.documentId +
                '?sugar_user_id=' + parent.SUGAR.App.user.get('id') +
                '&document_id=' + ele.getAttribute('document_id');
    } else {
        var annotationURL = Url.restUrl + 'annotations/' + Annotationeer.currentDocument.documentId +
                '?sugar_user_id=' + sugar_user_id +
                '&document_id=' + document_id;
    }
    // -----END-----
    $.ajax({
        dataType: 'json',
        url: annotationURL,
        async: false,
        headers: {
            'username': Annotationeer.getUsername()
        },
        success: function (response) {
            PageManager.consoleLog(response);
            for (var i = 0; i < response.settings.length; i++) {
                if (response.settings[i].key == 'ANNOTATIONS_READ_ONLY') {
                    Default.ANNOTATIONS_READ_ONLY = response.settings[i].value == 'true';
                }
            }

            for (var i = 0; i < response.annotations.length; i++) {
                var annotation = new Annotation();
                annotation.id = response.annotations[i].id;
                annotation.srno = parseInt(response.annotations[i].sr_no);
                annotation.annotationType = parseInt(response.annotations[i].annotation_type_id);
                annotation.inspection_type = parseInt(response.annotations[i].inspection_type);
                annotation.pageIndex = parseInt(response.annotations[i].page_index);
                annotation.pageWidth = parseInt(response.annotations[i].page_width);
                annotation.pageHeight = parseInt(response.annotations[i].page_height);
                annotation.docId = response.annotations[i].doc_id;
                annotation.modified = '';
                annotation.readOnly = parseInt(response.annotations[i].read_only);
                annotation.readOnlyComment = parseInt(response.annotations[i].read_only_comment);
                annotation.calibrationLabel = response.annotations[i].calibration_label;
                annotation.calibrationValue = parseFloat(response.annotations[i].calibration_value);
                annotation.calibrationMeasurementType = parseFloat(response.annotations[i].calibration_measurement_type_id);
                annotation.measurementType = parseInt(response.annotations[i].measurement_type_id);
                annotation.lineStyle = parseInt(response.annotations[i].line_style_id);
                annotation.hasDimension = true;
                if (response.annotations[i].mark != '') {
                    annotation.mark = response.annotations[i].mark;
                }
                if (response.annotations[i].mark_location != '') {
                    annotation.mark_location = response.annotations[i].mark_location;
                }
                if (response.annotations[i].uni != '') {
                    annotation.mark_uni = parseInt(response.annotations[i].uni);
                }

                // Use global setting value if no value is set in the database
                if (annotation.measurementType == 0)
                    annotation.measurementType = Default.ANNOTATION_MEASUREMENT_TYPE_DEFAULT;

                // Parse annotation string x, y, w, h
                var c_ = response.annotations[i].coordinate.split(',');
                annotation.x = parseFloat(c_[0]);
                annotation.y = parseFloat(c_[1]);
                annotation.w = parseFloat(c_[2]);
                annotation.h = parseFloat(c_[3]);
                annotation.origX = annotation.x;
                annotation.origY = annotation.y;
                annotation.origW = annotation.w;
                annotation.origH = annotation.h;
                if (parent.welders_variable != '' && parent.inspection_type == 3) {
                    var jsond = JSON.parse(parent.welders_variable);
                    annotation.weldersinfo = jsond;
                }

                annotation.formFieldName = response.annotations[i].form_field_name;
                annotation.formFieldValue = response.annotations[i].form_field_value;
                annotation.text = response.annotations[i].text;
                annotation.fontSize = response.annotations[i].font_size;
                annotation.font = response.annotations[i].font;
                annotation.lineWidth = response.annotations[i].line_width;
                annotation.opacity = response.annotations[i].opacity;

                annotation.dateCreated = moment(response.annotations[i].date_created).toDate();
                annotation.dateModified = moment(response.annotations[i].date_modified).toDate();

                if (annotation.annotationType == Annotation.TYPE_AUDIO)
                    annotation.audioAvailable = true;

                if (response.annotations[i].icon != '')
                    annotation.setIconSource(response.annotations[i].icon, reload);
                // We do if condition here so default values would not be overwritten
                if (response.annotations[i].color)
                    annotation.color = response.annotations[i].color;
                if (response.annotations[i].background_color)
                    annotation.backgroundColor = response.annotations[i].background_color;

                if (annotation.annotationType == Annotation.TYPE_TEXT)
                    PageManager.setFreeTextImageToAnnotation(annotation, annotation.id);

                // Drawing Positions
                for (var d = 0; d < response.annotations[i].drawing_positions.length; d++) {
                    var dp = new DrawingPosition();
                    dp.id = response.annotations[i].drawing_positions[d].id;
                    dp.annotationId = response.annotations[i].drawing_positions[d].annotation_id;

                    var dc_ = response.annotations[i].drawing_positions[d].coordinate.split(',');
                    dp.x = parseFloat(dc_[0]);
                    dp.y = parseFloat(dc_[1]);
                    dp.origX = dp.x;
                    dp.origY = dp.y;

                    annotation.drawingPositions.push(dp);
                }

                // Highlight Text Rect
                for (var d = 0; d < response.annotations[i].highlight_text_rects.length; d++) {
                    var htr = new HighlightTextRect();
                    htr.id = response.annotations[i].highlight_text_rects[d].id;
                    htr.annotationId = response.annotations[i].highlight_text_rects[d].annotationId;

                    var dc_ = response.annotations[i].highlight_text_rects[d].coordinate.split(',');
                    htr.left = parseFloat(dc_[0]);
                    htr.top = parseFloat(dc_[1]);
                    htr.width = parseFloat(dc_[2]);
                    htr.height = parseFloat(dc_[3]);
                    htr.right = htr.left + htr.width;
                    htr.bottom = htr.top + htr.height;
                    htr.origLeft = htr.left;
                    htr.origTop = htr.top;
                    htr.origWidth = htr.width;
                    htr.origHeight = htr.height;
                    htr.origRight = htr.right;
                    htr.origBottom = htr.bottom;
                    htr.setDomRotateAngle(response.annotations[i].highlight_text_rects[d].dom_rotate_angle, rotateAngle);

                    annotation.highlightTextRects.push(htr);
                }
                //PageManager.consoleLog(annotation);
//PageManager.consoleLog(response.annotations[i].comments);
                // Comments
                for (var c = 0; c < response.annotations[i].comments.length; c++) {
                    if (c == 0)
                        annotation.comments = [];

                    var comment = new Comment();
                    comment.id = response.annotations[i].comments[c].id;
                    comment.annotationId = response.annotations[i].comments[c].annotation_id;
                    comment.username = response.annotations[i].comments[c].username;
                    comment.user_name = response.annotations[i].comments[c].first_name + ' ' + response.annotations[i].comments[c].last_name;
                    //  comment.user_name = response.annotations[i].comments[c].user_name;
                    comment.comment = response.annotations[i].comments[c].comment;
                    comment.status = response.annotations[i].comments[c].status;
                    comment.dateCreated = moment(response.annotations[i].comments[c].date_created).toDate();
                    comment.dateModified = moment(response.annotations[i].comments[c].date_modified).toDate();
                    comment.parentId = response.annotations[i].comments[c].parent_id;
                    comment.modified = '';

                    // Review status
                    if (response.annotations[i].comments[c].review_statuses)
                        for (var s = 0; s < response.annotations[i].comments[c].review_statuses.length; s++) {
                            var rs = new ReviewStatus();
                            rs.id = response.annotations[i].comments[c].review_statuses[s].id;
                            rs.commentId = response.annotations[i].comments[c].review_statuses[s].comment_id;
                            rs.status = response.annotations[i].comments[c].review_statuses[s].status;
                            rs.reviewedBy = response.annotations[i].comments[c].review_statuses[s].reviewed_by;
                            rs.dateReviewed = moment(response.annotations[i].comments[c].review_statuses[s].date_reviewed).toDate();
                            rs.modified = '';
                            comment.reviewStatuses.push(rs);
                        }

                    annotation.comments.push(comment);
                }

                annotations.push(annotation);
            }

            if (response.digital_signatures)
                for (var i = 0; i < response.digital_signatures.length; i++) {
                    var ds = new DigitalSignature();
                    ds.id = response.digital_signatures[i].id;
                    ds.username = response.digital_signatures[i].username;
                    ds.signature = response.digital_signatures[i].signature;
                    ds.width = response.digital_signatures[i].width;
                    ds.height = response.digital_signatures[i].height;
                    PageManager.addDigitalSignatureToList(ds);
                }

            if (Default.STAMP_CUSTOM_ENABLED && response.stamps)
                for (var i = 0; i < response.stamps.length; i++) {
                    PageManager.addStampToList(response.stamps[i].id, response.stamps[i].stamp, response.stamps[i].width, response.stamps[i].height);
                }

            if (response.bookmarks)
                for (var i = 0; i < response.bookmarks.length; i++) {
                    var bookmark = new Bookmark();
                    bookmark.id = response.bookmarks[i].id;
                    bookmark.pageIndex = parseInt(response.bookmarks[i].page_index);
                    bookmark.docId = response.bookmarks[i].doc_id;
                    bookmark.parentId = response.bookmarks[i].parent_id;
                    bookmark.label = response.bookmarks[i].label;
                    bookmark.zoom = parseFloat(response.bookmarks[i].zoom);
                    bookmark.pageX = parseFloat(response.bookmarks[i].pageX);
                    bookmark.pageY = parseFloat(response.bookmarks[i].pageY);
                    bookmark.pageWidth = parseFloat(response.bookmarks[i].page_width);
                    bookmark.pageHeight = parseFloat(response.bookmarks[i].page_height);
                    bookmark.createdBy = response.bookmarks[i].created_by;
                    bookmark.dateCreated = moment(response.bookmarks[i].date_created).toDate();
                    bookmark.dateModified = moment(response.bookmarks[i].date_modified).toDate();
                    BookmarkManager.bookmarks.push(bookmark);
                }

            if (Util.isFunction(Annotationeer.a389nnotationsDownloaded))
                Annotationeer.annotationsDownloaded()

            if (reload)
                PageManager.reloadAnnotations();
            if (parent.inspection_type == 3) {
                parent.dropdown_ForRevision(parent.doc, parent.select_rev);
            } else if (parent.inspection_type == 2) {
                parent.dropdown_For_InspectionRevision(parent.doc, parent.select_rev);
            }
        }
    });
};

Annotationeer.saveAnnotation = function (annotation, text, doNotTriggerEvent) {
    PageManager.consoleLog('Annotationeer.saveAnnotation(): processing annotation: ' + annotation.id + (text ? ', with text: ' + text : ''));
    PageManager.consoleLog(parent.doc);
    PageManager.consoleLog(parent.my_var);
    PageManager.consoleLog(parent.filename);
    PageManager.consoleLog(parent.inspection_type);
    PageManager.consoleLog(parent.user_id);
    PageManager.consoleLog(parent.other);
    PageManager.consoleLog(parent.insp);

    var showCommentForm = annotation.id == 0;
    var copyAnnotation = [];
    annotation.project = parent.my_var;
    // -chnaged to below- annotation.document_id = parent.doc;
    // ahmad
    // -----START-----
    if (parent.SUGAR) {
        var ele = parent.document.getElementById('signDocframe');
        if (!ele) {
            ele = parent.document.getElementById('signDocframeRecordPreview');
        }

        annotation.document_id = ele.getAttribute('document_id');
    } else {
        annotation.document_id = document_id;
    }
    // -----END-----
    annotation.document = parent.filename;
    annotation.inspection_type = parent.inspection_type;
    // -chnaged to below- annotation.user_id = parent.user_id;
    // ahmad
    // -----START-----
    if (parent.SUGAR) {
        annotation.user_id = parent.SUGAR.App.user.get('id');
    } else {
        annotation.user_id = sugar_user_id;
    }
    // -----END-----
    annotation.other = parent.other;
    // -chnaged to below- annotation.username = parent.user_id;
    // -chnaged to below- annotation.user_name = parent.user_name;
    // ahmad
    // -----START-----
    if (parent.SUGAR) {
        annotation.username = parent.SUGAR.App.user.get('full_name');
        annotation.user_name = parent.SUGAR.App.user.get('full_name');
    } else {
        annotation.username = full_name;
        annotation.user_name = full_name;
    }
    // -----END-----
    annotation.request = parent.insp;
    if (parent.welders_variable != '' && parent.inspection_type == 3) {
        var jsond = JSON.parse(parent.welders_variable);
        annotation.weldersinfo = jsond;
    }

    //  PageManager.consoleLog(jsond.length);
    // for (var w=0; w<jsond.length; w++) {
    //     annotation.welders[].wdvid = jsond[w].wdvid;
    //     annotation.welders[].welder_name = jsond[w].welder_name;
    //     annotation.welders[].welder_id = jsond.welder_id;
    //   }
    //annotation.push(copyAnnotation);

    /**
     * If SAVE_ALL_ANNOTATIONS_ONE_TIME is true, then just update annotations in code and setting temporary
     * id to make each annotation as unique. When saved to server, it will check for the modified variable
     * and see if the value is changed. If changed, then treat it as id == 0 to insert data.
     */
    // Change code here to save to web server
    if (Default.SAVE_ALL_ANNOTATIONS_ONE_TIME) {
        /**
         * If this is a new annotation, then id will be negative so that it will not
         * conflict with id that are in the early + value like those < 10.
         */
        if (annotation.id == 0) {
            annotation.id = -annotations.length - 1;
        } else if (annotation.modified == '') {
            annotation.modified = 'update';
        }

        PageManager.updateAnnotationListAfterSave(annotation, showCommentForm, doNotTriggerEvent);
    } else {
        // We pass a copy as request object so that certain properties can be modified like free text's iconSrc needs to be null.
        var copyAnnotation = Annotation.clone(annotation);
        copyAnnotation.icon = null;

        if (copyAnnotation.annotationType == Annotation.TYPE_TEXT)
            copyAnnotation.iconSrc = null;


        $.ajax({
            url: Url.restUrl + Url.annotationSaveUrl,
            type: 'post',
            data: Util.jsonStringify(copyAnnotation),
            contentType: 'application/json',
            dataType: 'json',
            cache: false,
            success: function (response) {
                annotation.id = response.id;
                annotation.modified = response.modified;
                annotation.oldModified = response.oldModified ? response.oldModified : '';

                for (var c = 0; c < response.comments.length; c++) {
                    annotation.comments[c].id = response.comments[c].id;
                    annotation.comments[c].modified = response.comments[c].modified;
                    annotation.comments[c].user_name = parent.user_name;
                    for (var s = 0; s < response.comments[c].reviewStatuses.length; s++) {
                        annotation.comments[c].reviewStatuses[s].id = response.comments[c].reviewStatuses[s].id;
                        annotation.comments[c].reviewStatuses[s].modified = response.comments[c].reviewStatuses[s].modified;

                    }
                }

                PageManager.updateAnnotationListAfterSave(annotation, showCommentForm, false);
                PageManager.consoleLog('Save successful. Id: ' + annotation.id);
                //  PageManager.consoleLog(annotation.inspection_type);

                var commentToUse = response.comments[0];
                var rs = commentToUse.reviewStatuses.length > 0 ?
                        commentToUse.reviewStatuses[commentToUse.reviewStatuses.length - 1] : null;
                if (annotation.inspection_type == 3) {
                    Annotationeer.editAnnotation2(annotation, key = 'create', key == 'create' ? commentToUse : null);
                }


            },
            error: function (xhr, status, error) {
                PageManager.consoleLog('Error saving annotation: ' + error);
            }
        });
    }

    PageManager.initFilterOptions();
};

/**
 * This function is called after annotations are downloaded from the server.
 */
//Annotationeer.annotationsDownloaded = function() {
//
//}

// var origSaveAnnotation = Annotationeer.saveAnnotation;
// Annotationeer.saveAnnotation = function(annotation, text, doNotTriggerEvent) {
//    origSaveAnnotation(annotation, text, doNotTriggerEvent);
// }

//var origDeleteAnnotation = Annotationeer.deleteAnnotation;
//Annotationeer.deleteAnnotation = function(annotation, fromAngular, doNotTriggerEvent) {
//    origDeleteAnnotation(annotation, fromAngular, doNotTriggerEvent);
//}


//var origConvertColor = PageManager.convertColor;
//PageManager.convertColor = function(color) {
//    origConvertColor(color);
//}

/**
 * Place your overridden code for saving screenshot here.
 * If you wish to use a "Save As" feature, use a 3rd party library called reImg.
 */
//Annotationeer.saveScreenShot = function(canvas) {
//
//}
//
//// Place your overridden code for capturing page screenshot here.
//Annotationeer.saveCapturePage = function(canvas) {
//
//}

/**
 * Place your overridden code here if you wish to override how you want to save digital signature.
 * @param signaturePad
 * @param justUse
 * @param annotation
 */
//Annotationeer.saveDigitalSignature = function(signaturePad, justUse, annotation) {
//
//}

/**
 * Place your overridden code here if you wish to override how you want to delete digital signature.
 * @param id
 */
//Annotationeer.deleteDigitalSignature = function(id) {
//
//}

/**
 * Place your overridden code here if you wish to override how you want to delete stamp.
 * @param id
 */
//Annotationeer.deleteStamp = function(id) {
//
//}

if (Default.CREATE_ANNOTATION_EVENTS) {
    document.addEventListener('annotation_insert', function (e) {
        console.log(e.annotation);
    });

    document.addEventListener('annotation_update', function (e) {
        console.log(e.annotation);
    });

    document.addEventListener('annotation_delete', function (e) {
        console.log(e.annotation);
    });
}

/**
 * Place your code here if you wish to affect how the UI will look like.
 * e.g. Removing buttons
 */
document.addEventListener('DOMContentLoaded', function (e) {
    $('button#sidebarToggle').click();
    $('button#viewAnnotations').click();

}, false);


/**
 * Initiates a create annotation action.
 * @function
 * @memberof PageManager
 * @param {object} button The button that triggered this function.
 * @param {number} type The annotation type.
 * @param {string} icon The path of the image icon.
 * @param {number} iconWidth The width of the icon.
 * @param {number} iconHeight The height of the icon.
 */

PageManager.createAnnotation = function (button, type, icon, iconWidth, iconHeight) {
    var reseted = false;

    if ($(button).hasClass('toggled')) {

        resetVar();
        reseted = true;

        if (type != Annotation.TYPE_STAMP && type != Annotation.TYPE_DIGITAL_SIGNATURE)
            return;
    }

    if (!reseted)
        resetVar(false, type == Annotation.TYPE_STAMP || type == Annotation.TYPE_DIGITAL_SIGNATURE);

    $(button).addClass('toggled');

    if (Default.ANNOTATION_BUTTON_TOGGLED_CHANGE_TITLE) {
        //$(button).attr('title', 'Stop ' + $(button).attr('title'));
        PageManager.translateDOML10n(button, $(button).attr('data-l10n-id') + '_stop');
    }

    // -chnaged to below-    PageManager.boxAnnotationGuide = new Annotation();
    // ahmad
    // -----START-----
    if (type == Annotation["TYPE_HIGHLIGHT"] || type == Annotation["TYPE_CIRCLE_FILL"]) {
        PageManager.boxAnnotationGuide = new Annotation(1);
    } else {
        PageManager.boxAnnotationGuide = new Annotation();
    }
    // -----END-----
    PageManager.boxAnnotationGuide.dummy = true;
    PageManager.boxAnnotationGuide.annotationType = type;

    if (type == Annotation.TYPE_STICKY_NOTE || type == Annotation.TYPE_TEXT_INSERT) {
        PageManager.boxAnnotationGuide.backgroundColor = Default.ANNOTATION_IMAGE_COLOR_BASE_ON_COLOR_PICKER ?
                Default.DRAW_COLOR_BACKGROUND : '#ffffff';
    }

    if (type == Annotation.TYPE_DRAWING)
        PageManager.startDraw = true;
    else
        PageManager.startCreatingAnnotation = true;

    if (icon) {
        if (PageManager.boxAnnotationGuide.annotationType == Annotation.TYPE_DIGITAL_SIGNATURE) {
            var canvas = $('<canvas></canvas>');
            var ctx = canvas[0].getContext('2d');
            var image = new Image();
            image.onload = function () {
                ctx.drawImage(image, 0, 0);
                canvas.remove();
            };
            image.src = icon;
            PageManager.boxAnnotationGuide.icon = image;
            // We cannot depend using the image's naturalWidth and naturalHeight properties
            // because these are not supported in IE11 but Bing is okay.
            PageManager.boxAnnotationGuide.icon.width = iconWidth;
            PageManager.boxAnnotationGuide.icon.height = iconHeight;
        } else {
            PageManager.boxAnnotationGuide.setIconSource(icon);

            if (PageManager.boxAnnotationGuide.annotationType == Annotation.TYPE_STAMP) {
                // Compute width based on preferred height
                //Util.getImageWidthFromHeight(PageManager.boxAnnotationGuide.icon, Default.ANNOTATION_STAMP_HEIGHT)
                PageManager.boxAnnotationGuide.icon.width = Default.ANNOTATION_STAMP_WIDTH;
                PageManager.boxAnnotationGuide.icon.height = Default.ANNOTATION_STAMP_HEIGHT;
            } else {
                PageManager.boxAnnotationGuide.icon.width = Default.ANNOTATION_ICON_SIDE;
                PageManager.boxAnnotationGuide.icon.height = Default.ANNOTATION_ICON_SIDE;
            }
        }
    }
    if (Util.isMobile()) {
        if (PageManager.boxAnnotationGuide.isPolyLineType() || PageManager.boxAnnotationGuide.annotationType == Annotation.TYPE_TEXT) {
            $('#markText').removeClass('hidden');
        }

        $('#cancelAnnotation').removeClass('hidden');
    }
};

/**
 * Add an annotation to the page.
 * @function
 * @memberof Page
 * @param {Annotation} tempAnnotation The annotation object.
 * @param {number} angle The rotation angle.
 * @param {decimal} scale The scale value.
 * @param {boolean} useOrigDimension Use original dimension if true.
 * @param {boolean} isAddedAfterLoad Indicates if annotation is added after document is loaded.
 * @param {boolean} doNotTriggerEvent Trigger an event or not.
 */
Page.prototype.addAnnotation = function (tempAnnotation, angle, scale, useOrigDimension, isAddedAfterLoad, doNotTriggerEvent) {
    var annotation = new Annotation();
    //annotation.user_name=parent.user_name;
    annotation.x = useOrigDimension ? tempAnnotation.origX : tempAnnotation.x;
    annotation.y = useOrigDimension ? tempAnnotation.origY : tempAnnotation.y;
    annotation.w = useOrigDimension ? tempAnnotation.origW : tempAnnotation.w;
    annotation.h = useOrigDimension ? tempAnnotation.origH : tempAnnotation.h;

    annotation.origX = annotation.x;
    annotation.origY = annotation.y;
    annotation.origW = annotation.w;
    annotation.origH = annotation.h;

    annotation.id = tempAnnotation.id;

    annotation.pageIndex = tempAnnotation.pageIndex;
    annotation.pageWidth = tempAnnotation.pageWidth;
    annotation.pageHeight = tempAnnotation.pageHeight;

    annotation.annotationType = tempAnnotation.annotationType;
    annotation.inspection_type = parent.inspection_type;
    annotation.lineStyle = tempAnnotation.lineStyle;
    annotation.calibrationLabel = tempAnnotation.calibrationLabel;
    annotation.calibrationValue = tempAnnotation.calibrationValue;
    annotation.calibrationMeasurementType = tempAnnotation.calibrationMeasurementType;
    annotation.measurementType = tempAnnotation.measurementType;

    annotation.color = tempAnnotation.color;
    annotation.backgroundColor = tempAnnotation.backgroundColor ? tempAnnotation.backgroundColor : Default.DRAW_COLOR_BACKGROUND;
    annotation.lineWidth = tempAnnotation.lineWidth;
    annotation.opacity = tempAnnotation.opacity;
    annotation.srno = tempAnnotation.srno;
    annotation.status = "Pending";
    annotation.mark = tempAnnotation.mark;
    annotation.mark_location = tempAnnotation.mark_location;
    annotation.uni = tempAnnotation.uni;
    annotation.user_name = tempAnnotation.user_name;

    if (parent.welders_variable != '' && parent.inspection_type == 3) {
        var jsond = JSON.parse(parent.welders_variable);
        annotation.weldersinfo = jsond;
    }

    /**
     * tempAnnotation.icon becomes an Object happens when this function is called when an annotation event is
     * triggered. If this happens, do not call the function setIconSource().
     */
    if (annotation.usesImage())
        annotation.setIconSource(tempAnnotation.icon);

    annotation.drawingPositions = tempAnnotation.drawingPositions;
    annotation.comments = tempAnnotation.comments;
    //annotation.comments[annotation.comments.length-1].user_name=annotation.comments[annotation.comments.length-1].user_name;
    annotation.modified = tempAnnotation.modified;
    annotation.selected = tempAnnotation.selected;
    annotation.hidden = tempAnnotation.hidden;
    annotation.readOnly = tempAnnotation.readOnly;
    annotation.readOnlyComment = tempAnnotation.readOnlyComment;

    annotation.audio = tempAnnotation.audio;
    annotation.audioAvailable = tempAnnotation.audioAvailable;

    annotation.dateCreated = tempAnnotation.dateCreated;
    annotation.dateModified = tempAnnotation.dateModified;

    if (!useOrigDimension)
        if (annotation.annotationType == Annotation.TYPE_DRAWING) {
            if (annotation.drawingPositions.length < Default.DRAW_POINT_MINIMUM) {
                this.invalidate();
                return;
            }
        } else if (annotation.hasTwoEndPoints()) {
            if (annotation.drawingPositions.length == 1) {
                tempAnnotation.drawingPositions = [];
                PageManager.showAlert(Message.ARROW_CREATE_REQUIREMENT, 'info');
                return;
            } else if (annotation.isArrowNotLongEnough(scale)) {
                if (((annotation.annotationType == Annotation.TYPE_ARROW || annotation.annotationType == Annotation.TYPE_LINE) && Default.ANNOTATION_ARROW_MINIMUM_LENGTH) ||
                        (annotation.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE && Default.ANNOTATION_MEASUREMENT_DISTANCE_MINIMUM_LENGTH))
                {
                    tempAnnotation.drawingPositions = [];
                    PageManager.showAlert(Message.ARROW_CREATE_LONGER, 'info');
                    return;
                }
            }
        }

    this.canvasAnnotations.push(annotation);

    if (isAddedAfterLoad) {
        if (annotation.drawingPositions.length > 0) {
            for (var i = 0; i < annotation.drawingPositions.length; i++) {
                var drawingPosition = annotation.drawingPositions[i];
                drawingPosition.origX = drawingPosition.x;
                drawingPosition.origY = drawingPosition.y;
                drawingPosition.calculateOrigPosition(this.canvas, angle, scale, true);
            }
        }

        annotation.calculateOrigBound(this.canvas, angle, scale);
        // if(parent.inspection_type == 3){
        //     PageManager.consoleLog('working this step');
        //
        //     annotation.inspection_type=parent.inspection_type;
        //       PageManager.consoleLog(annotation);
        //     var commentToUse;var key;
        //     Annotationeer.editAnnotation2(annotation, key='create', key == 'create' ? commentToUse : null);
        //     return false;
        //   }
        if (Util.isFunction(Annotationeer.saveAnnotation))
            Annotationeer.saveAnnotation(annotation,
                    Default.ANNOTATION_GET_TEXT_BELOW_IT &&
                    (annotation.annotationType == Annotation.TYPE_HIGHLIGHT ||
                            annotation.annotationType == Annotation.TYPE_BOX) ? annotation.getTextBelowIt(annotation) : '',
                    doNotTriggerEvent);
        else
            PageManager.showAlert(Message.FUNC_UNDEFINED_ANNO_SAVE, 'info');
    } else {
        //  PageManager.consoleLog('working');
        PageManager.updateAnnotationListAfterSave(annotation, false, doNotTriggerEvent);
    }
};


/**
 * Initialize filter options.
 * @function
 * @memberof PageManager
 */
PageManager.initFilterOptions = function () {
    PageManager.consoleLog('PageManager.initFilterOptions()');
    PageManager.consoleLog('this one working');

    var callback = function () {
        // https://codeburst.io/javascript-array-distinct-5edc93501dc4
        // Avoid duplicates in array.
        var mapAt = new Map();
        var mapU = new Map();
        var mapS = new Map();
        var annotationTypesFound = [];
        var usersFound = [];
        var statusFound = [];
        for (var a in annotations) {
            if (annotations[a].modified == 'delete')
                continue;

            var annotationType = annotations[a].annotationType;
            if (!mapAt.has(annotationType)) {
                annotationTypesFound.push(PageManager.getAnnotationTypeById(annotationType));
                mapAt.set(annotationType, '');
            }

            for (var c in annotations[a].comments) {
                var username = annotations[a].comments[c].username;
                if (!mapU.has(username)) {
                    usersFound.push(username);
                    mapU.set(username, '');
                }

                if (annotations[a].comments[c].reviewStatuses.length == 0)
                    continue;

                var status = annotations[a].comments[c].reviewStatuses[annotations[a].comments[c].reviewStatuses.length - 1].status;
                if (!mapS.has(status)) {
                    statusFound.push(status);
                    mapS.set(status, '');
                }
            }
        }

        var className = 'selected-filter';

        var statusContainer = $('div#filter-option-comment-status');
        // Find first if there are already selected options so their state will be set when recreated.
        statusContainer.find('span[class="' + className + '"]').each(function () {
            mapS.set(this.innerHTML, className);
        });

        statusContainer.empty();
        // Sort case insensitive.
        statusFound.sort(function (a, b) {
            return a.toLowerCase().localeCompare(b.toLowerCase());
        });

        for (var s = 0; s < statusFound.length; s++) {
            statusContainer.append('<span ' + (mapS.has(statusFound[s]) && mapS.get(statusFound[s]) == className ?
                    'class="' + className + '"' : '') + '>' + statusFound[s] + '</span>');
        }

        // If no comment status found, hide the section.
        if (statusFound.length == 0) {
            statusContainer.prev().hide();
            statusContainer.hide();
        } else {
            statusContainer.prev().show();
            statusContainer.show();
        }

        var userContainer = $('div#filter-option-comment-by');
        userContainer.find('span[class="' + className + '"]').each(function () {
            mapU.set(this.innerHTML, className);
        });

        userContainer.empty();
        usersFound.sort(function (a, b) {
            return a.toLowerCase().localeCompare(b.toLowerCase());
        });

        for (var uf = 0; uf < usersFound.length; uf++) {
            userContainer.append('<span ' + (mapU.has(usersFound[uf]) && mapU.get(usersFound[uf]) == className ?
                    'class="' + className + '"' : '') + '>' + usersFound[uf] + '</span>');
        }

        var stampContainer = $('div#filter-option-type');
        stampContainer.find('span[class="' + className + '"]').each(function () {
            mapAt.set(this.getAttribute('id'), className);
        });

        stampContainer.empty();
        for (var atf = 0; atf < annotationTypesFound.length; atf++) {
            stampContainer.append('<span id="' + annotationTypesFound[atf].id + '"' +
                    (mapAt.get(annotationTypesFound[atf].id + '') == className ?
                            ' class="' + className + '"' : '') + '><img src="' +
                    Url.stampFolderUrl + annotationTypesFound[atf].icon + '"/></span>');
        }
    }


    // var annoSubpiece = $('#popupfabricationContainer');
    // if (!annoSubpiece.hasClass('remodal-is-opened'))
    //     annoSubpiece.remodal().open();

    // Disable filter user interface header if there are no annotations.
    $('div.filter-annotation-container').find('*').prop('disabled', annotations.length == 0);

    var annoListCont = $('div#annotationListContainer');
    if (annoListCont.length == 0)
        return;

    if (annotations.length == 0)
        angular.element(annoListCont).scope().hideFilterForm(callback);
    else
        callback();
};


Annotationeer.editAnnotation2 = function (annotation, key, comment) {
    PageManager.consoleLog('Annotationeer.editAnnotation(): id: ' + annotation.id + ', key: ' + key);

    if (!annotation.canContainComments())
        return;

    // Since measuring type annotations and free text has its caption as its root comment, running this
    // function will result in opening up the comments popup as reply.
    if (annotation.hasMeasuring() || annotation.annotationType == Annotation.TYPE_TEXT) {
        // If comment is null, then comment is root that is not editable.
        if (!comment && !annotation.readOnlyComment)
            key = 'reply';
    }

    // We destroy the context menu for this menu item because if annotation type is TYPE_TEXT,
    // the alert() will overlap the context menu. This is a hack.
    $.contextMenu('destroy', '#' + Default.canvasIdName + (annotation.pageIndex + 1));

    Annotationeer.openAnnotationForm2(annotation, key, comment);
};

Annotationeer.openAnnotationForm2 = function (annotation, key, comment) {
    PageManager.consoleLog('Annotationeer.openAnnotationForm2()');
    PageManager.consoleLog(annotation);
    PageManager.consoleLog(key);
    PageManager.consoleLog(comment);
    //angular.element($('#popupfabricationContainer')).scope().setAnnotation(annotation, key, comment);
    angular.element($('#popupContainer')).scope().setAnnotation(annotation, key, comment);
};


Annotationeer.savePieceinfo = function (annotation, comment) {
    comment.other = parent.other;
    comment.piece_list = parent.piece_list;
    comment.user_id = annotation.user_id;
//PageManager.consoleLog(comment);
    PageManager.consoleLog(Util.jsonStringify(comment));
    $.ajax({
        url: Url.restUrl + Url.pieceinfoSaveUrl.replace('[annotation_id]', annotation.id),
        method: 'post',
        contentType: 'application/json',
        data: Util.jsonStringify(comment),
        success: function (response) {
            var json = typeof response == 'string' ? JSON.parse(response) : response;
            comment.id = json.id;
            comment.modified = json.modified;
            annotation.oldModified = json.oldModified ? json.oldModified : '';
            //  PageManager.updateAnnotationComment(annotation);
            PageManager.consoleLog(comment);
            parent.render_list_subPiece(comment.other, comment.piece_list);
            parent.render_Inspection_list(parent.other, '', parent.piece_list);
            $('#popupContainer').remodal().close();
        },
        error: function () {
            PageManager.showAlert(Message.COMMENT_SAVE_ERROR, 'error');
        }
    });

    //parent.render_Inspection_list();
};


Annotationeer.openAnnotationForm = function (annotation, key, comment) {

    PageManager.consoleLog(annotation.inspection_type);
    PageManager.consoleLog(key);
    if (annotation.inspection_type == 3 && parent.welders_variable == '' && key == 'reply') {
        //  PageManager.showAlert(Message.COMMENT_SAVE_ERROR_REPORT, 'error');
    } else {
        if (annotation.inspection_type == 3 && key == 'edit') {
            //var weldermarkUrl = Url.restUrl + 'annotations/' + Annotationeer.currentDocument.documentId;
//Custom ajax request to get mark location
            $.ajax({
                url: Url.restUrl + Url.weldermarkUrl + '/' + annotation.id,
                // method: 'post',
                contentType: 'application/json',
                data: Util.jsonStringify(comment),
                success: function (response) {
                    var json = typeof response == 'string' ? JSON.parse(response) : response;
                    annotation.uni = json.uni;
                    annotation.mark = json.mark;
                    annotation.mark_location = json.mark_location;

                },
                error: function () {
                    //PageManager.showAlert(Message.COMMENT_SAVE_ERROR, 'error');
                }
            });
        }
    }
    //  PageManager.consoleLog(annotation);
    if (parent.welders_variable != '' && parent.inspection_type == 3) {
        var jsond = JSON.parse(parent.welders_variable);
        annotation.weldersinfo = jsond;
    }
    //PageManager.consoleLog(parent.fab_date);
    PageManager.consoleLog(annotation);
    PageManager.consoleLog('Annotationeer.openAnnotationForm()');
    // $scope.mark  = annotation.mark;
    // $scope.location  = annotation.location;
    angular.element($('#popupContainer')).scope().setAnnotation(annotation, key, comment);

};


Annotationeer.saveWelderinfo = function (annotation, comment) {
    comment.other = parent.other;
    comment.user_id = annotation.user_id;
    PageManager.consoleLog(comment.weldervar);
    PageManager.consoleLog(comment);
// return false;
    PageManager.consoleLog(Util.jsonStringify(comment));
    $.ajax({
        url: Url.restUrl + Url.welderinfoSaveUrl.replace('[annotation_id]', annotation.id),
        method: 'post',
        contentType: 'application/json',
        data: Util.jsonStringify(comment),
        success: function (response) {
            var json = typeof response == 'string' ? JSON.parse(response) : response;
            comment.id = json.id;
            comment.modified = json.modified;
            annotation.oldModified = json.oldModified ? json.oldModified : '';
            //  PageManager.updateAnnotationComment(annotation);
            parent.render_list_subPiece(parent.other, parent.piece_list);
            parent.render_Inspection_list(parent.other, '', parent.piece_list);
            $('#popupContainer').remodal().close();
        },
        error: function () {
            PageManager.showAlert(Message.COMMENT_SAVE_ERROR, 'error');
        }
    });
};


Annotationeer.updateMarkinfo = function (annotation, comment) {
    comment.other = parent.other;
    comment.user_id = annotation.user_id;
    comment.uni = annotation.uni;
//PageManager.consoleLog(comment);
    PageManager.consoleLog(Util.jsonStringify(comment));
    $.ajax({
        url: Url.restUrl + Url.MarkinfoUpdateUrl.replace('[annotation_id]', annotation.id),
        method: 'post',
        contentType: 'application/json',
        data: Util.jsonStringify(comment),
        success: function (response) {
            var json = typeof response == 'string' ? JSON.parse(response) : response;
            comment.id = json.id;
            comment.modified = json.modified;
            annotation.oldModified = json.oldModified ? json.oldModified : '';
            //  PageManager.updateAnnotationComment(annotation);
            parent.render_list_subPiece(parent.other, parent.piece_list);
            parent.render_Inspection_list(parent.other, '', parent.piece_list);
            $('#popupContainer').remodal().close();
        },
        error: function () {
            PageManager.showAlert(Message.COMMENT_SAVE_ERROR, 'error');
        }
    });
};



/**
 * Delete annotation from annotations array and the page's canvas.
 * @function
 * @memberof Annotationeer
 * @param {Annotation} annotation The annotation object.
 * @param {boolean} fromAngular Indicates if this action came from the sidebar list.
 * @param {boolean} doNotTriggerEvent If true, trigger annotation event. Default.CREATE_ANNOTATION_EVENT will still override this.
 */
Annotationeer.deleteAnnotation = function (annotation, fromAngular, doNotTriggerEvent) {
//  return false;
    PageManager.consoleLog('Annotationeer.deleteAnnotation(): id: ' + annotation.id);
    PageManager.consoleLog(annotation);
    if (annotation.isReadOnly())
        return;

    if (Default.ANNOTATIONS_TOOLTIP && annotation.tooltip) {
        if (typeof annotation.tooltip.hide == 'function')
            annotation.tooltip.hide();

        annotation.tooltip = undefined;
    }

    PageManager.hideContextMenu();

    /**
     * If doNotTriggerEvent is true, then this means that the delete annotation event was triggered
     * after the call to the server, hence there should be no request to the server for this.
     */
    if (!Default.SAVE_ALL_ANNOTATIONS_ONE_TIME && !doNotTriggerEvent) {
        // -added below- 
        // ahmad
        // -----START-----
        if (parent.SUGAR) {
            var ele = parent.document.getElementById('signDocframe');
            if (!ele) {
                ele = parent.document.getElementById('signDocframeRecordPreview');
            }

            annotation.document_id = ele.getAttribute('document_id');
        } else {
            annotation.document_id = document_id;
        }
        // -----END-----
        $.ajax({
            url: Url.restUrl + Url.annotationDeleteUrl + '/' + annotation.id,
            type: 'delete',
            data: Util.jsonStringify(annotation),
            contentType: 'application/json',
            dataType: 'json',
            cache: false,
            success: function () {
                PageManager.consoleLog('Delete successful');
                if (annotation.inspection_type == 3) {
                    parent.deleteMarkLocation(annotation.id, parent.other, parent.piece_list);
                }
            },
            error: function (xhr, status, error) {
                PageManager.consoleLog('Error deleting annotation: ' + error);
            }
        });
    }

    var page = pages[Default.canvasIdName + (annotation.pageIndex + 1)];
    if (page)
        for (var j = 0; j < page.canvasAnnotations.length; j++) {
            if (page.canvasAnnotations[j].id != annotation.id)
                continue;

            page.canvasAnnotations.splice(j, 1);
            page.invalidate();
            break;
        }

    for (var i = 0; i < annotations.length; i++) {
        if (annotations[i].id == annotation.id) {
            if (Default.SAVE_ALL_ANNOTATIONS_ONE_TIME) {
                if (annotations[i].id <= 0)
                    annotations.splice(i, 1);
                else
                    annotations[i].modified = 'delete';
            } else
                annotations.splice(i, 1);

            break;
        }
    }

    if (annotation.annotationType == Annotation.TYPE_TEXT) {
        $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + annotation.id).remove();
    } else if (annotation.isFormField()) {
        $('#form' + annotation.id).remove();
    } else if (Default.ANNOTATION_SELECTABLE_TEXT_AS_DIV && annotation.isSelectableTextType()) {
        var divs = PageManager.getPageContainer(annotation.pageIndex + 1).find('.canvasWrapper').children('div[id="' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + annotation.id + '"]');
        for (var d = 0; d < divs.length; d++) {
            $(divs[d]).remove();
        }
    }

    if (!fromAngular)
        angular.element($('#annotationListContainer')).scope().$digest();

    if (Default.CREATE_ANNOTATION_EVENTS && !doNotTriggerEvent) {
        PageManager.createAnnotationEvent(annotation, 'delete');
    }

    PageManager.removeSelectedAnnotation(annotation);
    PageManager.initFilterOptions();
};

// ahmad
// Erase functionality added.
PageManager.isEraserSelected = false;

PageManager.eraseAnnotation = function (button) {
    if ($(button).hasClass('toggled')) {
        resetVar();
        PageManager.isEraserSelected = false;
        return;
    }

    resetVar();
    $(button).addClass('toggled');
    PageManager.isEraserSelected = true;

    if (Default.ANNOTATION_BUTTON_TOGGLED_CHANGE_TITLE) {
        PageManager.translateDOML10n(button, $(button).attr('data-l10n-id') + '_stop');
    }
};

PageManager.removeAllAnnotations = function (button) {
    PageManager.consoleLog('Annotationeer.removeAllAnnotations()');
    if (annotations.length > 0) {
        var result = confirm("Are you sure you want to remove all annotations?");
        if (result == true) {
            $.ajax({
                url: Url.restUrl + Url.annotationDeleteUrl + '/all',
                type: 'delete',
                data: Util.jsonStringify({
                    document_id: document_id,
                    id: 'all',
                }),
                contentType: 'application/json',
                dataType: 'json',
                cache: false,
                success: function (xhr, status, msg) {
                    PageManager.consoleLog(msg.responseJSON.message);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    PageManager.consoleLog('Error deleting annotations: ' + error);
                }
            });
        }
    } else {
        alert("There is no annotation available on the document.");
    }
};