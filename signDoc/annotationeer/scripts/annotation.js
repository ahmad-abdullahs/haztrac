/********************************************************************
 * Copyright (C) 2016-Present Mark Chester Goking <chitgoks@gmail.com>.
 *
 * This file is part of Annotationeer and it can not be copied
 * and/or distributed without the express permission of the author.
 ********************************************************************/

/**
 * <p>The PDFDocument. By default, only documentId is needed but if you wish to use an experimental feature where
 * user can navigation a group of PDFs, then all properties need to be set.</p>
 * @namespace PDFDocument
 */
PDFDocument.prototype = {};

/**
 * @constructor
 * @memberof PDFDocument
 */
function PDFDocument() {
    /**
     * The id of the document.
     * @type {number}
     */
    this.documentId = 0;
    /**
     * The total pages of the PDF.
     * @type {number}
     */
    this.totalPages = 0;
    /**
     * If this is the first PDF in the group of PDFs.
     * @type {boolean}
     */
    this.isFirst = false;
    /**
     * If this is the last PDF in the group of PDFs.
     * @type {boolean}
     */
    this.isLast = false;
}

/**
 * <p>An annotation comment can be set a status when reviewed by users.</p>
 * @namespace ReviewStatus
 */
ReviewStatus.prototype = {};

/**
 * @constructor
 * @memberof ReviewStatus
 */
function ReviewStatus() {
    /**
     * The id of the review status.
     * @type {number}
     */
    this.id = 0;
    /**
     * The review status.
     * @type {string}
     */
    this.status = '';
    /**
     * Who reviewed the comment.
     * @type {string}
     */
    this.reviewedBy = Annotationeer.getUsername();
    //noinspection JSUnusedGlobalSymbols
    /**
     * Date object of the review status.
     * @type {object}
     */
    this.dateReviewed = new Date();
    /**
     * Identifier if this object needs to be inserted/updated in the backend.
     * @type {string}
     */
    this.modified = Default.SAVE_ALL_ANNOTATIONS_ONE_TIME ? 'insert' : '';
}

/**
 * <p>Represents the digital signature created by the user.</p>
 * @namespace DigitalSignature
 */
DigitalSignature.prototype = {};

/**
 * @constructor
 * @memberof DigitalSignature
 */
function DigitalSignature() {
    /**
     * The id of the digital signature.
     * @type {number}
     */
    this.id = 0;
    /**
     * The user who created the digital signature.
     * @type {string}
     */
    this.username = null;
    /**
     * The digital signature in base64 string.
     * @type {string}
     */
    this.signature = null;
    /**
     * The width dimension of the digital signature.
     * @type {number}
     */
    this.width = 0;
    /**
     * The height dimension of the digital signature.
     * @type {number}
     */
    this.height = 0;
}

/**
 * <p>The watermark orientation that will be used as an option for the user to select when rendering watermarks.</p>
 * @namespace WatermarkOrientation
 */
var WatermarkOrientation = {};

/**
 * @memberof WatermarkOrientation
 * @type {number}
 */
WatermarkOrientation.CENTER_VERTICAL = 0;
/**
 * @memberof WatermarkOrientation
 * @type {number}
 */
WatermarkOrientation.CENTER_HORIZONTAL = 1;
/**
 * @memberof WatermarkOrientation
 * @type {number}
 */
WatermarkOrientation.CENTER_DIAGONAL = 2;
/**
 * @memberof WatermarkOrientation
 * @type {number}
 */
WatermarkOrientation.UPPER_RIGHT_HORIZONTAL = 3;
/**
 * @memberof WatermarkOrientation
 * @type {number}
 */
WatermarkOrientation.UPPER_LEFT_HORIZONTAL = 4;

/**
 * <p>The annotation type.</p>
 * @namespace AnnotationType
 */
AnnotationType.prototype = {
    init: function (id, icon) {
        this.id = id;
        this.icon = icon;
    }
};

/**
 * @constructor
 * @memberof AnnotationType
 * @param {number} id The id of the annotation type.
 * @param {string} icon The image source path for the icon.
 */
function AnnotationType(id, icon) {
    this.init(id, icon);
}

/**
 * <p>Comment entry of an annotation.</p>
 * @namespace Comment
 */
Comment.prototype = {};

/**
 * @constructor
 * @memberof Comment
 */
function Comment() {
    /**
     * The id of the comment
     * @type {number}
     */
    this.id = 0;
    /**
     * The user who created the comment.
     * @type {string}
     */
    this.username = Annotationeer.getUsername();
    /**
     * The date object when the comment was first created.
     * @type {object}
     */
    this.dateCreated = new Date();
    /**
     * The date object when the comment was modified.
     * @type {object}
     */
    this.dateModified = new Date();
    /**
     * The comment itself.
     * @type {string}
     */
    this.comment = '';
    /**
     * The parent id of the root comment. If value is 0, it is the root comment.
     * @type {number}
     */
    this.parentId = 0;
    /**
     * The annotation id to reference which annotation this comment belongs to.
     * @type {number}
     */
    this.annotationId = 0;
    /**
     * Identifier if this object needs to be inserted/updated in the backend.
     * @type {string}
     */
    this.modified = Default.SAVE_ALL_ANNOTATIONS_ONE_TIME ? 'insert' : '';

    /**
     * <p>List of review status entries for this comment. Only the last entry in the array is shown to the user.
     * The rest are kept for history tracking purposes.</p>
     * @type {Array.<ReviewStatus>}
     */
    this.reviewStatuses = [];
}

/**
 * <p>The drawing position represents a point for annotations based on points like drawing, line, arrow, etc.</p>
 * @namespace DrawingPosition
 */
DrawingPosition.prototype = {
    /**
     * Rotate the coordinate based on the current scale and update original coordinate.
     * @function
     * @name DrawingPosition.DrawingPosition#rotate
     * @param {object} canvas The canvas object.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     */
    rotate: function (canvas, angle, scale) {
        var bx = this.origX * scale;
        var by = this.origY * scale;

        if (angle == 90) {
            this.x = canvas.height - by;
            this.y = bx;
        } else if (angle == 270) {
            this.x = by;
            this.y = canvas.width - bx;
        } else if (angle == 180) {
            this.x = canvas.height - bx;
            this.y = canvas.width - by;
        } else {
            this.x = bx;
            this.y = by;
        }
    },
    /**
     * Calculate the original coordinate based on the current scale.
     * @function
     * @name DrawingPosition.DrawingPosition#calculateOrigPosition
     * @param {object} canvas The canvas object.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     * @param {boolean} useDisplayCoordinate
     */
    calculateOrigPosition: function (canvas, angle, scale, useDisplayCoordinate) {
        PageManager.consoleLog('DrawingPosition.calculateOrigPosition()');
        var x = useDisplayCoordinate ? this.x : this.origX;
        var y = useDisplayCoordinate ? this.y : this.origY;

        if (x < 0) {
            this.x = x = (1 * scale);
        } else if (x >= canvas.width) {
            this.x = x = canvas.width - (1 * scale);
        }

        if (y < 0) {
            this.y = y = (1 * scale);
        } else if (y >= canvas.height) {
            this.y = y = canvas.height - (1 * scale);
        }

        if (angle == 90) {
            this.origX = y / scale;
            this.origY = Math.ceil((canvas.width - x) / scale);
        } else if (angle == 180) {
            this.origX = Math.ceil((canvas.width - x) / scale);
            this.origY = Math.ceil((canvas.height - y) / scale);
        } else if (angle == 270) {
            this.origX = Math.ceil((canvas.height - y) / scale);
            this.origY = x / scale;
        } else {
            this.origX = x / scale;
            this.origY = y / scale;
        }

        this.lastX = 0;
        this.lastY = 0;
    }

};

/**
 * A helper function to create json string into a {@link DrawingPosition} object.
 * @function
 * @memberof DrawingPosition
 * @param {string} json The json string.
 * @returns {DrawingPosition}
 */
DrawingPosition.createFromJSON = function (json) {
    if (typeof json === 'string')
        json = JSON.parse(json);

    var obj = new DrawingPosition();

    for (var key in json) {
        if (!json.hasOwnProperty(key))
            continue;

        obj[key] = json[key];
    }
    return obj;
};

/**
 * @constructor
 * @memberof DrawingPosition
 */
function DrawingPosition() {
    /**
     * The id of the drawing position.
     * @type {number}
     */
    this.id = 0;
    /**
     * The x coordinate based on the current scale of the PDF.JS Viewer.
     * @type {decimal}
     */
    this.x = 0;
    /**
     * The y coordinate based on the current scale of the PDF.JS Viewer.
     * @type {decimal}
     */
    this.y = 0;
    /**
     * The x coordinate based on the scale of 100% or 1.
     * @type {decimal}
     */
    this.origX = 0;
    /**
     * The y coordinate based on the scale of 100% or 1.
     * @type {decimal}
     */
    this.origY = 0;

    // Used to store values if point is moved.
    this.lastX = 0;
    this.lastY = 0;
}

/**
 * @constructor
 * @memberof HighlightTextRect
 */
function HighlightTextRect() {
    /**
     * The id of the highlight text rect.
     * @type {number}
     */
    this.id = 0;
    /**
     * The x coordinate based on the scale of 100% or 1.
     * @type {decimal}
     */
    this.origLeft = 0;
    /**
     * The y coordinate based on the scale of 100% or 1.
     * @type {decimal}
     */
    this.origTop = 0;
    /**
     * <p>The right x coordinate based on the scale of 100% or 1. This is calculated based on the value of x + width.</p>
     * @type {decimal}
     */
    this.origRight = 0;
    /**
     * <p>The bottom y coordinate based on the scale of 100% or 1. This is calculated based on the value of y + height.</p>
     * @type {decimal}
     */
    this.origBottom = 0;
    /**
     * The width of the highlight text rect based on the scale of 100% or 1.
     * @type {decimal}
     */
    this.origWidth = 0;
    /**
     * The height of the highlight text rect based on the scale of 100% or 1.
     * @type {decimal}
     */
    this.origHeight = 0;
    /**
     * The x coordinate based on the current scale of the PDF.JS Viewer.
     * @type {decimal}
     */
    this.left = 0;
    /**
     * The y coordinate based on the current scale of the PDF.JS Viewer.
     * @type {decimal}
     */
    this.top = 0;
    /**
     * <p>The right x coordinate based on the current scale of the PDF.JS Viewer. This is calculated based on
     * the value of x + width.</p>
     * @type {decimal}
     */
    this.right = 0;
    /**
     * <p>The bottom y coordinate based on the current scale of the PDF.JS Viewer. This is calculated based on
     * the value of y + height.</p>
     * @type {decimal}
     */
    this.bottom = 0;
    /**
     * The width of the highlight text rect based on the current scale of the PDF.JS Viewer.
     * @type {decimal}
     */
    this.width = 0;
    /**
     * The height of the highlight text rect based on the current scale of the PDF.JS Viewer.
     * @type {decimal}
     */
    this.height = 0;
    /**
     * The angle of the text in the PDF when rotation is 0.
     * @type {number}
     */
    this.domRotateAngle = 0;
}

/**
 * <p>The highlight text rectangle represents boundary from the text selection. A text selection that involves one line
 * can be one of a group of div layers depending on how PDF.JS generates the text layer.</p>
 * @namespace HighlightTextRect
 */
HighlightTextRect.prototype = {
    /**
     * Rotate the boundary based on the current scale and update original boundary dimension.
     * @function
     * @param {object} canvas The canvas object.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     */
    rotate: function (canvas, angle, scale) {
        var bLeft = parseFloat(this.origLeft) * scale;
        var bTop = parseFloat(this.origTop) * scale;
        var bRight = parseFloat(this.origRight) * scale;
        var bBottom = parseFloat(this.origBottom) * scale;
        var bWidth = parseFloat(this.origWidth) * scale;
        var bHeight = parseFloat(this.origHeight) * scale;

        if (angle == 90) {
            this.left = canvas.width - bTop - bHeight;
            this.top = bLeft;
            this.height = bWidth;
            this.width = bHeight;
            this.right = this.left + this.width;
            this.bottom = this.top + this.height;
        } else if (angle == 270) {
            this.left = bTop;
            this.top = canvas.height - bLeft - bWidth;
            this.height = bWidth;
            this.width = bHeight;
            this.right = this.left + this.width;
            this.bottom = this.top + this.height;
        } else if (angle == 180) {
            this.left = canvas.width - bLeft - bWidth;
            this.top = canvas.height - bTop - bHeight;
            this.width = bWidth;
            this.height = bHeight;
            this.right = this.left + this.width;
            this.bottom = this.top + this.height;
        } else {
            this.left = bLeft;
            this.top = bTop;
            this.right = bRight;
            this.bottom = bBottom;
            this.width = bWidth;
            this.height = bHeight;
        }
    },
    /**
     * Calculate the original boundary based on the current scale.
     * @function
     * @param {object} canvas The canvas object.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     */
    calculateOrigBound: function (canvas, angle, scale) {
        PageManager.consoleLog('HighlightTextRect.calculateOrigBound()');
        var x = this.left;
        var y = this.top;
        var w = this.width;
        var h = this.height;

        if (angle == 90) {
            this.origLeft = y / scale;
            this.origTop = Math.ceil((canvas.width - (x + w)) / scale);
            this.origWidth = h / scale;
            this.origHeight = w / scale;
        } else if (angle == 180) {
            this.origLeft = Math.ceil((canvas.width - (x + w)) / scale);
            this.origTop = Math.ceil((canvas.height - (y + h)) / scale);
            this.origWidth = w / scale;
            this.origHeight = h / scale;
        } else if (angle == 270) {
            this.origLeft = Math.ceil((canvas.height - (y + h)) / scale);
            this.origTop = x / scale;
            this.origWidth = h / scale;
            this.origHeight = w / scale;
        } else {
            this.origLeft = x / scale;
            this.origTop = y / scale;
            this.origWidth = w / scale;
            this.origHeight = h / scale;
        }

        this.origRight = this.origLeft + this.origWidth;
        this.origBottom = this.origTop + this.origHeight;
    },
    /**
     * Sets the angle to the property {@link HighlightTextRect.HighlightTextRect#domRotateAngle|HighlightTextRect#domRotateAngle}.
     * @function
     * @param {number} elementAngle The rotation angle of the text in rotation angle 0 of the PDF.JS Viewer.
     * @param {number} pdfViewerAngle The rotation angle of the PDF.JS Viewer.
     */
    setDomRotateAngle: function (elementAngle, pdfViewerAngle) {
        this.domRotateAngle = elementAngle - pdfViewerAngle;

        if (this.domRotateAngle == -90)
            this.domRotateAngle = 270;
        else if (this.domRotateAngle == -270)
            this.domRotateAngle = 90;
    },

    getAngleBasedOnDomRotateAngle: function (angle) {
        var finalAngle = (this.domRotateAngle + angle) % 360;
        if (finalAngle < 0) {
            finalAngle += 360;
        }
        return  finalAngle;
    },
    /**
     * String representation of the highlight text rect object.
     * @function
     * @returns {string}
     */
    toString: function () {
        return '{ left: ' + this.origLeft + ', top: ' + this.origTop + ', width: ' + this.origWidth + ', ' + ', height: ' + this.origHeight + '}';
    }

};

HighlightTextRect.createFromJSON = function (json) {
    if (typeof json === 'string')
        json = JSON.parse(json);

    var obj = new HighlightTextRect();

    for (var key in json) {
        if (!json.hasOwnProperty(key))
            continue;

        obj[key] = json[key];
    }
    return obj;
};

function AnnotationSelectionHandle() {
    this.x = 0;
    this.y = 0;
}

AnnotationSelectionHandle.prototype = {

};

/**
 * Represents an annotation.
 * @constructor
 * @memberof Annotation
 */
// -chnaged to below-    function Annotation() {
// ahmad
// -----START-----
function Annotation(a) {
// -----END-----
    /**
     * The id of the annotation.
     * @type {number}
     */
    this.id = 0;

    /**
     * <p>The x coordinate of the annotation based on the current scale of the PDF.JS Viewer. Used for display
     * purposes only.</p>
     * @type {decimal}
     */
    this.x = 0;
    /**
     * <p>The y coordinate of the annotation based on the current scale of the PDF.JS Viewer. Used for display
     * purposes only.</p>
     * @type {decimal}
     */
    this.y = 0;
    /**
     * <p>The width of the annotation based on the current scale of the PDF.JS Viewer. Used for display
     * purposes only.</p>
     * @type {decimal}
     */
    this.w = 1;
    /**
     * <p>The height of the annotation based on the current scale of the PDF.JS Viewer. Used for display
     * purposes only.</p>
     * @type {decimal}
     */
    this.h = 1;

    // this will be used to store original annotations for easy scaling
    this.origX = 0;
    this.origY = 0;
    this.origW = 1;
    this.origH = 1;

    /**
     * The index page number of the PDF.JS page.
     * @type {number}
     */
    this.pageIndex = -1;
    /**
     * The width of the PDF.JS page. This is needed when converting to coordinates in the PDF space.
     * @type {number}
     */
    this.pageWidth = 0;
    /**
     * The height of the PDF.JS page. This is needed when converting to coordinates in the PDF space.
     * @type {number}
     */
    this.pageHeight = 0;
    /**
     * The annotation type.
     * @type {number}
     */
    this.annotationType = -1;

    this.clicked = false;
    this.moving = false;
    this.selected = false;
    // This property is used to indicate if the annotation is selectable.
    this.selectable = false;
    // This property will depend on the value retrieved from the database.
    /**
     * Sets an annotation if it is ready only or not.
     * @default false
     * @type {number}
     */
    this.readOnly = false;
    /**
     * Sets an annotation if users can add comments (replies) to it even if annotation itself is ready only.
     * @default false
     * @type {number}
     */
    this.readOnlyComment = false;

    /**
     * <p>This is used if {@link Default.SAVE_ALL_ANNOTATIONS_ONE_TIME} is true. Values can be modified or deleted
     * for update and deletion as well as insert for new entry.</p>
     *
     * <p>Values are either insert, update, delete. If insert, set id to 0 so
     * the server will treat it as a new entry.</p>
     * @type {string}
     */
    this.modified = Default.SAVE_ALL_ANNOTATIONS_ONE_TIME ? 'insert' : '';

    // This property will set if the annotation is visible or not.
    /**
     * Sets the visibility of the annotation.
     * @default false
     * @type {boolean}
     */
    this.hidden = false;

    /**
     * This is used to identify that this kind of annotation is not the final one being saved. This
     * should indicate that the annotation is still in creation stage while this variable is true.
     */
    this.dummy = false;

    /**
     * Circle type annotation will have its own x, y coordinate stored
     * because the x, y, w, h will still be used when annotation is
     * moved or resize.
     */
    // Used as starting point when creating circle
    this.circleStartX = 0;
    this.circleStartY = 0;
    // Track latest x, y coordinate
    this.circleLastX = 0;
    this.circleLastY = 0;

    /**
     * Holds the 8 tiny boxes that will be our selection handles
     * the selection handles will be in this order:
     * 0  1  2
     * 3     4
     * 5  6  7
     *
     * If this is an annotation that is of poly line type, then its drawing
     * positions points will be used as basis for positioning and the selection
     * handles will be increased based on the number of points in its array.
     */
    this.selectionHandles = [];
    for (var i = 0; i < Default.ANNOTATION_SELECTION_MAX_POINTS; i++) {
        this.selectionHandles.push(new AnnotationSelectionHandle());
    }

    // This property is used to reference name value pairs. Useful for form field annotations.
    /**
     * The name of the form field name attribute.
     * @type {string}
     */
    this.formFieldName = '';
    /**
     * The value of the form field value attribute.
     * @type {string}
     */
    this.formFieldValue = '';
    // used if annotation type is TYPE_TEXT
    /**
     * Represents the label of some annotations that use this. e.g. Free text, measurement area.
     * @type {string}
     */
    this.text = '';
    /**
     * The font size of the annotation. Depends on the value set to {@link Default.FONT_SIZE}.
     * @type {number}
     */
    this.fontSize = Default.FONT_SIZE;
    /**
     * The font of the annotation. Depends on the value set to {@link Default.FONT_TYPE}.
     * @type {string}
     */
    this.font = Default.FONT_TYPE;
    /**
     * The line style of the annotation. Depends on the value set to {@link Default.ANNOTATION_LINE_STYLE_DEFAULT}.
     * @type {number}
     */
    this.lineStyle = Default.ANNOTATION_LINE_STYLE_DEFAULT;
    /**
     * <p>The calibration label of the measurement for the annotation. This property will hold the still representation of
     * the calibration value due to the introduction of {@link MeasurementType.FOOT_INCH}.</p>
     * @default The value set to {@link PageManager.calibrationLabel}. Empty {string} if none.
     * @type {decimal}
     */
    this.calibrationLabel = PageManager.calibrationLabel;
    /**
     * The calibration value of the measurement for the annotation.
     * @default The value set to {@link PageManager.calibrationValue}. 1 is set if none.
     * @type {decimal}
     */
    this.calibrationValue = PageManager.calibrationValue;
    /**
     * The calibration measurement type for the annotation. Depends on the value set to {@link Default.ANNOTATION_LINE_STYLE_DEFAULT}.
     * @default The value set to {@link PageManager.calibrationMeasurementType}.
     * @type {number}
     */
    this.calibrationMeasurementType = PageManager.calibrationMeasurementType;
    /**
     * The measurement unit of the annotation. Depends on the value set to {@link Default.ANNOTATION_MEASUREMENT_TYPE_DEFAULT}.
     * @type {number}
     */
    this.measurementType = Default.ANNOTATION_MEASUREMENT_TYPE_DEFAULT;
    /**
     * The line width of the annotation.
     * @default The value set to {@link Default.DRAW_WIDTH}.
     * @type {number}
     */
    this.lineWidth = Default.DRAW_WIDTH;
    /**
     * The opacity of the annotation. Depends on the value set to {@link Default.FILL_OPACITY}.
     * @type {decimal}
     */
    this.opacity = Default.FILL_OPACITY;

    /**
     * If false, then calculate width and height. Used by annotations that use HTML elements
     * like Div and Input fields.
     */
    this.hasDimension = false;

    // used if annotation type is TYPE_TEXT_HIGHLIGHT
    this.highlightTextRects = [];

    // used if annotation type is TYPE_DRAWING
    this.drawingPositions = [];
    /**
     * The foreground color of the annotation. Depends on the value set to {@link Default.DRAW_COLOR_FOREGROUND}.
     * @type {string}
     */
    this.color = Default.DRAW_COLOR_FOREGROUND;
    /**
     * The background color of the annotation. Depends on the value set to {@link Default.DRAW_COLOR_BACKGROUND}.
     * @type {string}
     */
    // -chnaged to below-   this.backgroundColor = Default.DRAW_COLOR_BACKGROUND;
    // ahmad
    // -----START-----
    if (a) {
        this.backgroundColor = '#ffff00';
    } else {
        this.backgroundColor = Default.DRAW_COLOR_BACKGROUND;
    }
    // -----END-----

    // used to assign stamp image or custom icon
    this.icon = new Image();
    // Used to hold the image path and file to be assigned to Image variable
    this.iconSrc = '';

    // Used to hold recorded audio data for playing
    this.audio = null;
    /*
     Used to indicate that this annotation has an audio associated with it but not
     downloaded yet due to it being an existing annotation from the server so if the
     user decides to listen on the audio, it will check if this is true then will
     download the audio from the server before assigning it to the audio property.
     */
    this.audioAvailable = false;
    /**
     * The date when this annotation was first created.
     * @type {object}
     */
    this.dateCreated = new Date();
    /**
     * The date when this annotation was last modified.
     * @type {object}
     */
    this.dateModified = new Date();
    /**
     * The document id that this annotation belongs to.
     * @type {number}
     */
    this.docId = Annotationeer.currentDocument.documentId;
    // Comments by users for this annotation
    this.comments = [];
    this.comments.push(new Comment());
}

//noinspection JSUnusedGlobalSymbols,JSUnusedLocalSymbols
/**
 * @namespace Annotation
 */
Annotation.prototype = {

    /**
     * Draws annotation to the canvas.
     * @function
     * @param {object} context The context of the canvas.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     * @param {boolean} printPreview If this is to be drawn during print preview.
     */
    draw: function (context, angle, scale, printPreview) {
        if (this.drawingPositions.length == 0 && (Math.abs(this.w) < 0 || Math.abs(this.h) < 0))
            return;

        // Set default values for line width and opacity so other annotations with default values will not be affected.
        context.lineWidth = this.lineWidth * scale;
        context.opacity = this.opacity;
        context.strokeStyle = this.color;
        context.lineJoin = Default.DRAW_LINEJOIN;
        context.lineCap = Default.DRAW_LINECAP;

        /**
         * We do the background fill for Annotation.TYPE_TEXT because we can set opacity here while doing it
         * in CSS with just the hex value of the color is not possible.
         */
        if (this.annotationType == Annotation.TYPE_HIGHLIGHT) {
            var rgbColor = Util.hexToRgb(this.backgroundColor);
            context.fillStyle = 'rgba(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ', ' + this.opacity + ')';
            context.fillRect(this.x, this.y, this.w, this.h);
        } else if (this.annotationType == Annotation.TYPE_BOX || this.annotationType == Annotation.TYPE_SCREENSHOT) {
            if (this.annotationType == Annotation.TYPE_SCREENSHOT) {
                context.fillStyle = Default.SCREENSHOT_FILL_COLOR;
                context.fillRect(this.x, this.y, this.w, this.h);
            }

            context.strokeStyle = this.annotationType == Annotation.TYPE_SCREENSHOT ? Default.SCREENSHOT_BORDER_COLOR : this.color;

            if (this.lineStyle == LineStyle.SOLID)
                context.strokeRect(this.x, this.y, this.w, this.h);
            else
                this.drawCloud(context, this.lineWidth, this.color, scale, 8, true);
        } else if (this.annotationType == Annotation.TYPE_CIRCLE_FILL || this.annotationType == Annotation.TYPE_CIRCLE_STROKE) {
            /**
             * http://jsfiddle.net/AbdiasSoftware/37vge/
             * If circleStartX and other circle variables have values, that means user is creating or resizing it.
             * If no value is assigned, use the x, y, w, h values to calculate the values of the circle variables.
             */
            var radiusX = (this.circleLastX > 0 ? this.circleLastX - this.circleStartX : (this.x + this.w) - this.x) * 0.5,
                    radiusY = (this.circleLastY > 0 ? this.circleLastY - this.circleStartY : (this.y + this.h) - this.y) * 0.5,
                    centerX = (this.circleStartX > 0 ? this.circleStartX : this.x) + radiusX,
                    centerY = (this.circleStartY > 0 ? this.circleStartY : this.y) + radiusY,
                    step = 0.05,
                    pi2 = Math.PI * 2 - step;

            context.beginPath();
            context.moveTo(centerX + radiusX * Math.cos(0), centerY + radiusY * Math.sin(0));

            for (var a = step; a < pi2; a += step) {
                context.lineTo(centerX + radiusX * Math.cos(a), centerY + radiusY * Math.sin(a));
            }

            context.closePath();

            if (this.annotationType == Annotation.TYPE_CIRCLE_FILL) {
                var rgbColor = Util.hexToRgb(this.backgroundColor);
                context.fillStyle = 'rgba(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ', ' + this.opacity + ')';
                context.fill();
            } else {
                // Use 3 digit hex color code because small ellipse curve is not smooth if 6 digit is used. No idea why.
                context.strokeStyle = Util.getShortHexColorCode(this.color);
                context.stroke();
            }

            context.closePath();
        } else if (this.usesImage()) {
            if (angle != 0) {
                var x, y;
                var w = this.w;
                var h = this.h;

                switch (angle) {
                    case 90:
                        x = this.x + this.w;
                        y = this.y;
                        w = this.h;
                        h = this.w;
                        break;
                    case 180:
                        x = this.x + this.w;
                        y = this.y + this.h;
                        break;
                    case 270:
                        x = this.x;
                        y = this.y + this.h;
                        w = this.h;
                        h = this.w;
                        break;
                }

                if (this.annotationType == Annotation.TYPE_STAMP || this.annotationType == Annotation.TYPE_DIGITAL_SIGNATURE) {
                    context.save();
                    context.translate(x, y);
                    context.rotate(angle * Math.PI / 180);
                    context.drawImage(this.icon, 0, 0, w, h);
                    context.restore();
                } else
                    Util.changeColorOfDrawnImage(context, this.icon, this.backgroundColor, x, y, w, h, angle * Math.PI / 180, false, printPreview);
            } else {
                if (this.annotationType == Annotation.TYPE_STAMP || this.annotationType == Annotation.TYPE_DIGITAL_SIGNATURE) {
                    context.drawImage(this.icon, this.x, this.y, this.w, this.h);
                } else
                    Util.changeColorOfDrawnImage(context, this.icon, this.color, this.x, this.y, this.w, this.h, false, printPreview);
            }
        }

        /**
         * Always call beginPath() first, then closePath() after or else other shapes that needs only to be filled
         * will have stroke values included. These calls will restrict the styling to this shape only.
         */
        else if (this.annotationType == Annotation.TYPE_LINE ||
                this.annotationType == Annotation.TYPE_ARROW ||
                this.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE)
        {
            if (this.drawingPositions.length < 2)
                return;

            //var angle = Util.getAngle(this.drawingPositions[0].x, this.drawingPositions[0].y,
            //    this.drawingPositions[1].x, this.drawingPositions[1].y, false);

            context.beginPath();
            context.moveTo(this.drawingPositions[0].x, this.drawingPositions[0].y);
            context.lineTo(this.drawingPositions[1].x, this.drawingPositions[1].y);
            context.closePath();

            if (this.annotationType != Annotation.TYPE_LINE) {
                var distance = Util.getDistance(this.drawingPositions[0].x, this.drawingPositions[0].y,
                        this.drawingPositions[1].x, this.drawingPositions[1].y);

                if (!Default.ANNOTATION_MEASUREMENT_DISTANCE_MINIMUM_LENGTH || distance > (Default.ARROW_SIZE * scale) * 2 * (this.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE ? 2 : 1))
                    this.drawLineArrowhead(context, this.annotationType === Annotation.TYPE_MEASUREMENT_DISTANCE, true, scale);

                // Draw measurement label.
                if (this.annotationType === Annotation.TYPE_MEASUREMENT_DISTANCE &&
                        (!Default.ANNOTATION_MEASUREMENT_DISTANCE_MINIMUM_LENGTH || !this.isArrowNotLongEnough(scale))) {
                    var font = (Default.ANNOTATION_MEASUREMENT_DISTANCE_LABEL_FONT_SIZE * scale) + Default.FONT_SIZE_TYPE + ' ' + this.font;
                    var padding = 5 * scale;
                    var gap = 5 * scale;
                    var origDistance = Util.getDistance(this.drawingPositions[0].origX, this.drawingPositions[0].origY, this.drawingPositions[1].origX, this.drawingPositions[1].origY);
                    this.text = Util.getMeasurementFromPixels(this, origDistance);
                    Util.drawLabelOnTopOfLine(context, this.text, this.drawingPositions[0], this.drawingPositions[1], gap, font, this.color, 'center', padding);
                }
            }

            context.stroke();
        } else if (this.annotationType == Annotation.TYPE_POLY_LINE ||
                this.annotationType == Annotation.TYPE_POLYGON ||
                this.annotationType == Annotation.TYPE_MEASUREMENT_AREA)
        {
            // http://stackoverflow.com/questions/34853113/drawing-multiple-polygons-in-js
            context.beginPath();

            for (var i = 0; i < this.drawingPositions.length; i++) {
                if (i === 0)
                    context.moveTo(this.drawingPositions[i].x, this.drawingPositions[i].y);
                else
                    context.lineTo(this.drawingPositions[i].x, this.drawingPositions[i].y);
            }

            if (!this.dummy && this.annotationType !== Annotation.TYPE_POLY_LINE)
                context.closePath();

            context.stroke();

            if (this.annotationType == Annotation.TYPE_MEASUREMENT_AREA) {
                this.text = Util.getAreaFromPixels(this, this.getArea());
                this.drawTextInsideShape(context, angle, scale);
            }
        } else if (this.annotationType === Annotation.TYPE_CLOUD) {
            this.drawCloud(context, this.lineWidth, this.color, scale);
        } else if (this.annotationType === Annotation.TYPE_DRAWING) {
            context.save();
            context.lineJoin = 'round';
            context.lineCap = 'round';

            // We place selected code here because we fill a wider drawing to represent the selection color
            if (this.selected) {
                for (var p = 0; p < this.drawingPositions.length; p++) {
                    if (p == 0) {
                        context.moveTo(this.drawingPositions[p].x, this.drawingPositions[p].y);
                        context.beginPath();
                    }

                    context.lineTo(this.drawingPositions[p].x, this.drawingPositions[p].y);
                    context.stroke();
                }
            }

            for (var p = 0; p < this.drawingPositions.length; p++) {
                if (p == 0) {
                    context.moveTo(this.drawingPositions[p].x, this.drawingPositions[p].y);
                    context.beginPath();
                }

                context.lineTo(this.drawingPositions[p].x, this.drawingPositions[p].y);
                context.stroke();
            }

            context.restore();
        } else if (this.hasFieldSet()) {
            var group = [];
            var page = pages[Default.canvasIdName + (this.pageIndex + 1)];

            if (page)
                for (var ca = 0; ca < page.canvasAnnotations.length; ca++) {
                    if (!page.canvasAnnotations[ca].hasFieldSet() ||
                            page.canvasAnnotations[ca].formFieldName != this.formFieldName ||
                            page.canvasAnnotations[ca].pageIndex != this.pageIndex ||
                            page.canvasAnnotations[ca].annotationType != this.annotationType)
                        continue;

                    group.push(page.canvasAnnotations[ca]);
                }

            var box = Util.getBoundingBoxOfPolygons(group, angle);
            context.lineWidth = Default.ANNOTATION_SELECTED_LINEWIDTH * scale;
            context.strokeStyle = 'black';

            // IE 9 does not support this function, only IE 11 and above.
            //noinspection JSUnresolvedVariable
            if (context.setLineDash)
                context.setLineDash([3]);

            context.strokeRect(box.x, box.y, box.width, box.height);

            // Reset line style
            if (context.setLineDash)
                context.setLineDash([0]);
        }
        // Selectable text type annotations e.g. highlight, underline, strike-through will only be printed in
        // canvas if this is in print preview mode.
        else if (this.isSelectableTextType() && (!Default.ANNOTATION_SELECTABLE_TEXT_AS_DIV || printPreview)) {
            if (this.annotationType == Annotation.TYPE_TEXT_HIGHLIGHT) {
                var rgbColor = Util.hexToRgb(this.backgroundColor);
                context.fillStyle = 'rgba(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ', ' + this.opacity + ')';

                for (var htr = 0; htr < this.highlightTextRects.length; htr++) {
                    context.fillRect(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top,
                            this.highlightTextRects[htr].width, this.highlightTextRects[htr].height);
                }
            } else {
                context.lineWidth = scale;
                context.strokeStyle = this.color;
                context.beginPath();

                for (var htr = 0; htr < this.highlightTextRects.length; htr++) {
                    if (this.annotationType == Annotation.TYPE_TEXT_UNDERLINE) {
                        switch (angle) {
                            case 0:
                                switch (this.highlightTextRects[htr].domRotateAngle) {
                                    case 0:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom);
                                        break;
                                    case 90:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom);
                                        break;
                                    case 180:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].top);
                                        break;
                                    case 270:
                                        context.moveTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom);
                                        break;
                                }
                                break;
                            case 90:
                                switch (this.highlightTextRects[htr].domRotateAngle) {
                                    case 0:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom);
                                        break;
                                    case 90:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].top);
                                        break;
                                    case 180:
                                        context.moveTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom);
                                        break;
                                    case 270:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom);
                                        break;
                                }
                                break;
                            case 180:
                                switch (this.highlightTextRects[htr].domRotateAngle) {
                                    case 0:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].top);
                                        break;
                                    case 90:
                                        context.moveTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].top);
                                        break;
                                    case 180:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom);
                                        break;
                                    case 270:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom);
                                        context.lineTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top);
                                        break;
                                }
                                break;
                            case 270:
                                switch (this.highlightTextRects[htr].domRotateAngle) {
                                    case 0:
                                        context.moveTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom);
                                        break;
                                    case 90:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom);
                                        break;
                                    case 180:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom);
                                        break;
                                    case 270:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].top);
                                        break;
                                }
                                break;
                        }
                    } else if (this.annotationType == Annotation.TYPE_TEXT_STRIKE_THROUGH || this.annotationType == Annotation.TYPE_TEXT_REPLACE) {
                        switch (angle) {
                            case 0:
                            case 180:
                                switch (this.highlightTextRects[htr].domRotateAngle) {
                                    case 0:
                                    case 180:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom - ((this.highlightTextRects[htr].bottom - this.highlightTextRects[htr].top) / 2));
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom - ((this.highlightTextRects[htr].bottom - this.highlightTextRects[htr].top) / 2));
                                        break;
                                    case 90:
                                    case 270:
                                        context.moveTo(this.highlightTextRects[htr].right - ((this.highlightTextRects[htr].right - this.highlightTextRects[htr].left) / 2), this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].right - ((this.highlightTextRects[htr].right - this.highlightTextRects[htr].left) / 2), this.highlightTextRects[htr].bottom);
                                        break;
                                }
                                break;
                            case 90:
                            case 270:
                                switch (this.highlightTextRects[htr].domRotateAngle) {
                                    case 0:
                                    case 180:
                                        context.moveTo(this.highlightTextRects[htr].right - ((this.highlightTextRects[htr].right - this.highlightTextRects[htr].left) / 2), this.highlightTextRects[htr].top);
                                        context.lineTo(this.highlightTextRects[htr].right - ((this.highlightTextRects[htr].right - this.highlightTextRects[htr].left) / 2), this.highlightTextRects[htr].bottom);
                                        break;
                                    case 90:
                                    case 270:
                                        context.moveTo(this.highlightTextRects[htr].left, this.highlightTextRects[htr].bottom - ((this.highlightTextRects[htr].bottom - this.highlightTextRects[htr].top) / 2));
                                        context.lineTo(this.highlightTextRects[htr].right, this.highlightTextRects[htr].bottom - ((this.highlightTextRects[htr].bottom - this.highlightTextRects[htr].top) / 2));
                                        break;
                                }
                                break;
                        }
                    }
                }

                context.stroke();
                context.closePath();

                // Fill background aside from strike-through as this will be the visual indicator for a TYPE_TEXT_REPLACE annotation.
                if (this.annotationType == Annotation.TYPE_TEXT_REPLACE) {
                    //var rgbColor = Util.hexToRgb(this.backgroundColor);
                    //context.fillStyle = 'rgba(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ', ' + this.opacity + ')';
                    //context.fillRect(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top, this.highlightTextRects[htr].width, this.highlightTextRects[htr].height);
                    this.drawQuadraticCurveTriangle(context, angle, this.highlightTextRects[this.highlightTextRects.length - 1])
                }
            }
        } else if (this.annotationType == Annotation.TYPE_TEXT && printPreview) {
            if (this.icon) {
                context.save();
                context.translate(this.x, this.y);
                context.drawImage(this.icon, 0, 0, this.w, this.h);
                context.restore();
            }
        } else if (this.annotationType == Annotation.TYPE_TEXT_INSERT) {
            this.drawQuadraticCurveTriangle(context, angle);
        }

        if (Default.ANNOTATION_SELECTABLE_TEXT_AS_DIV) {
            var highlightedTexts = PageManager.getPageContainer(this.pageIndex + 1).find('div[id=highlight' + this.id + ']');
            for (var ht = 0; ht < highlightedTexts.length; ht++) {
                highlightedTexts[ht].style.border = '';
            }
        }

        // Draw selection
        // This is a stroke along the box and also 8 new selection handles
        if ((this.selected || this.selectable) && !printPreview) {
            if (this.isSelectableTextType()) {
                if (Default.ANNOTATION_SELECTABLE_TEXT_AS_DIV) {
                    for (var ht = 0; ht < highlightedTexts.length; ht++) {
                        highlightedTexts[ht].style.border = Default.ANNOTATION_SELECTION_BOX_COLOR_TYPE_TEXT;
                    }
                } else {
                    context.strokeStyle = Default.ANNOTATION_SELECTED_COLOR;
                    context.lineWidth = Default.ANNOTATION_SELECTED_LINEWIDTH * scale;

                    for (var htr = 0; htr < this.highlightTextRects.length; htr++) {
                        context.strokeRect(this.highlightTextRects[htr].left, this.highlightTextRects[htr].top,
                                this.highlightTextRects[htr].width, this.highlightTextRects[htr].height);
                    }
                }
            } else if (this.drawingPositions.length > 0 && this.annotationType != Annotation.TYPE_DRAWING) {
                if ((!this.selected && this.selectable)) {
                    if (this.annotationType == Annotation.TYPE_CLOUD) {
                        this.drawCloud(context, Default.ANNOTATION_SELECTED_LINEWIDTH, Default.ANNOTATION_SELECTED_COLOR, scale);
                    } else {
                        context.strokeStyle = Default.ANNOTATION_SELECTED_COLOR;
                        context.lineWidth = Default.ANNOTATION_SELECTED_LINEWIDTH * scale;

                        for (var d = 0; d < this.drawingPositions.length; d++) {
                            if (d == 0)
                                context.moveTo(this.drawingPositions[d].x, this.drawingPositions[d].y);
                            else
                                context.lineTo(this.drawingPositions[d].x, this.drawingPositions[d].y);
                        }

                        context.stroke();
                    }

                } else {
                    var half = (Default.ANNOTATION_SELECTION_BOX_SIZE / 2) * scale;

                    /**
                     * If selection handles are lacking for poly line type annotations, add them here so the number
                     * of drawing positions will be the same as the number of selection handles available.
                     */
                    if (this.selectionHandles.length < this.drawingPositions.length) {
                        var diff = this.drawingPositions.length - this.selectionHandles.length;
                        for (var d = 0; d < diff; d++) {
                            this.selectionHandles.push(new AnnotationSelectionHandle());
                        }
                    }

                    for (var d = 0; d < this.drawingPositions.length; d++) {
                        this.selectionHandles[d].x = this.drawingPositions[d].x - half;
                        this.selectionHandles[d].y = this.drawingPositions[d].y - half;
                        this.selectionHandles[d].x = this.drawingPositions[d].x - half;
                        this.selectionHandles[d].y = this.drawingPositions[d].y - half;
                    }

                    context.fillStyle = Default.ANNOTATION_SELECTION_BOX_COLOR;
                    var length = this.isPolyLineType() ? this.drawingPositions.length :
                            this.selectionHandles.length;
                    for (var i = 0; i < length; i++) {
                        if (!this.isPolyLineType() && i > 1)
                            continue;

                        var cur = this.selectionHandles[i];
                        context.fillRect(cur.x, cur.y, Default.ANNOTATION_SELECTION_BOX_SIZE * scale, Default.ANNOTATION_SELECTION_BOX_SIZE * scale);
                    }
                }
            } else {
                context.strokeStyle = Default.ANNOTATION_SELECTED_COLOR;
                context.lineWidth = Default.ANNOTATION_SELECTED_LINEWIDTH * scale;
                context.strokeRect(this.x, this.y, this.w, this.h);

                if (!this.isResizable() || (!this.selected && this.selectable))
                    return;

                // Draw the boxes
                var half = (Default.ANNOTATION_SELECTION_BOX_SIZE / 2) * scale;

                // 0  1  2
                // 3     4
                // 5  6  7

                // Top left, middle, right
                this.selectionHandles[0].x = this.x - half;
                this.selectionHandles[0].y = this.y - half;

                this.selectionHandles[1].x = this.x + this.w / 2 - half;
                this.selectionHandles[1].y = this.y - half;

                this.selectionHandles[2].x = this.x + this.w - half;
                this.selectionHandles[2].y = this.y - half;

                // Middle left
                this.selectionHandles[3].x = this.x - half;
                this.selectionHandles[3].y = this.y + this.h / 2 - half;

                // Middle right
                this.selectionHandles[4].x = this.x + this.w - half;
                this.selectionHandles[4].y = this.y + this.h / 2 - half;

                // Bottom left, middle, right
                this.selectionHandles[6].x = this.x + this.w / 2 - half;
                this.selectionHandles[6].y = this.y + this.h - half;

                this.selectionHandles[5].x = this.x - half;
                this.selectionHandles[5].y = this.y + this.h - half;

                this.selectionHandles[7].x = this.x + this.w - half;
                this.selectionHandles[7].y = this.y + this.h - half;

                context.fillStyle = Default.ANNOTATION_SELECTION_BOX_COLOR;
                for (var i = 0; i < this.selectionHandles.length; i++) {
                    var cur = this.selectionHandles[i];
                    context.fillRect(cur.x, cur.y, Default.ANNOTATION_SELECTION_BOX_SIZE * scale, Default.ANNOTATION_SELECTION_BOX_SIZE * scale);
                }
            }
        }
    },

    /**
     * Draws line arrowhead on both points based on parameter value.
     * @see {@link https://stackoverflow.com/questions/60862501/draw-line-arrowhead-without-rotating-in-canvas/60868157}
     * @function
     * @param {object} context The canvas context.
     * @param {number} distanceFromLine The distance from the line to the back tip of the arrowhead.
     * @param {number} arrowLength The length of the arrow head.
     * @param {boolean} arrowStart Draw arrowhead on start point.
     * @param {boolean} arrowEnd Draw arrowhead on end point.
     * @returns {boolean}
     */
    drawLineArrowhead: function (context, arrowStart, arrowEnd, scale) {
        var p1 = this.drawingPositions[0];
        var p2 = this.drawingPositions[1];

        // context.lineCap = 'round';

        if (arrowStart) {
            var lineAngle = Math.atan2(p2.y - p1.y, p2.x - p1.x);
            var delta = Math.PI / Default.ARROW_SIZE;
            for (var i = 0; i < 2; i++) {
                if (i == 0) {
                    context.moveTo(p1.x + (Default.ARROWHEAD_LENGTH * scale) * Math.cos(lineAngle + delta), p1.y + (Default.ARROWHEAD_LENGTH * scale) * Math.sin(lineAngle + delta));
                    context.lineTo(p1.x, p1.y);
                } else {
                    context.lineTo(p1.x + (Default.ARROWHEAD_LENGTH * scale) * Math.cos(lineAngle + delta), p1.y + (Default.ARROWHEAD_LENGTH * scale) * Math.sin(lineAngle + delta));
                }
                delta *= -1;
            }
        }

        if (arrowEnd) {
            var lineAngle = Math.atan2(p1.y - p2.y, p1.x - p2.x);
            var delta = Math.PI / Default.ARROW_SIZE;
            for (var i = 0; i < 2; i++) {
                if (i == 0) {
                    context.moveTo(p2.x + (Default.ARROWHEAD_LENGTH * scale) * Math.cos(lineAngle + delta), p2.y + (Default.ARROWHEAD_LENGTH * scale) * Math.sin(lineAngle + delta));
                    context.lineTo(p2.x, p2.y);
                } else {
                    context.lineTo(p2.x + (Default.ARROWHEAD_LENGTH * scale) * Math.cos(lineAngle + delta), p2.y + (Default.ARROWHEAD_LENGTH * scale) * Math.sin(lineAngle + delta));
                }
                delta *= -1;
            }
        }

        context.stroke();
    },

    /**
     * Custom function to simulate Java's Rect.contains() method, also checks if rectangle was created in reverse (bottom-top).
     * @function
     * @param {decimal} mouseX The x coordinate returned by the mouse event.
     * @param {decimal} mouseY The y coordinate returned by the mouse event.
     * @param {object} e The event object.
     * @returns {boolean}
     */
    contains: function (mouseX, mouseY, e) {
        // If radius is not null, this means this is a tap touch event using finger or stylus
        //if (e && e.changedTouches) {
        //    // In case there is no radius within the touch event, set default to 1. This means
        //    // mouse cursor is still used for touch events using an emulator in desktop.
        //    var circle = {
        //        x: mouseX,
        //        y: mouseY,
        //        r: (e.changedTouches[0].radiusX ? e.changedTouches[0].radiusX : 1)
        //    };
        //
        //    var rect = {
        //        x: this.x,
        //        y: this.y,
        //        w: this.w,
        //        h: this.h
        //    };
        //
        //    return Util.isRectCircleColliding(circle, rect);
        //}
        //else
        return (
                ((mouseX >= this.x && mouseX <= this.x + this.w) || (mouseX <= this.x && mouseX >= this.x + this.w)) &&
                ((mouseY >= this.y && mouseY <= this.y + this.h) || (mouseY <= this.y && mouseY >= this.y + this.h))
                );
    },

    /**
     * <p>This function draws text inside a shape. Most likely a measurement area annotation. But this can be used in other
     * annotations by basing its bounding box as its container. You can override this function if you wish to change how
     * the text inside the annotation will be displayed.</p>
     * @function
     * @param {object} context The canvas context.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     */
    drawTextInsideShape: function (context, angle, scale) {
        if (!Default.ANNOTATION_DRAW_TEXT_IN_SHAPE || PageManager.startCreatingAnnotation)
            return;

        context.font = (Default.ANNOTATION_MEASUREMENT_DISTANCE_LABEL_FONT_SIZE * scale) + Default.FONT_SIZE_TYPE + ' ' + this.font;
        var textWidth = context.measureText(this.text).width;
        // We use this function to consistently get the width and height of the annotation. Still some bug with regards to points
        // when it is moved.
        var box = Util.getBoundingBoxOfPoints(this.drawingPositions);
        var x = box.x;
        var y = box.y;
        var w = box.w;
        var h = box.h;

        x = x + (w / 2);
        y = y + (h / 2);

        if (angle == 0 || angle == 180) {
            var textX = textWidth / 2;
            x = x - (angle == 180 ? -textX : textX);
        } else if (angle == 90 || angle == 270) {
            var textX = textWidth / 2;
            y = y - (angle == 270 ? -textX : textX);
        }

        context.save();
        context.translate(x, y);
        context.rotate(angle * Math.PI / 180);
        context.fillStyle = this.color;
        context.fillText(this.text, 0, 0);
        context.restore();
    },

    /**
     * <p>When this gets called, the canvas width/height does not reflect the new value(). used by rotateRight()
     * and rotateLeft(). in setScale(), the canvas size reflects its new value. The 3rd parameter
     * is made available in case the canvas size reflects the latest size so the 3rd parameter will be used.</p>
     * @function
     * @param {object} context The canvas context.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     */
    rotate: function (canvas, angle, scale) {
        var bx = this.origX * scale;
        var by = this.origY * scale;
        var bw = this.origW * scale;
        var bh = this.origH * scale;

        if (angle == 90) {
            this.x = canvas.height - by - bh;
            this.y = bx;
            this.h = bw;
            this.w = bh;
        } else if (angle == 270) {
            this.x = by;
            this.y = canvas.width - bx - bw;
            this.h = bw;
            this.w = bh;
        } else if (angle == 180) {
            this.x = canvas.height - bx - bw;
            this.y = canvas.width - by - bh;
            this.w = bw;
            this.h = bh;
        } else {
            this.x = bx;
            this.y = by;
            this.w = bw;
            this.h = bh;
        }
    },

    /**
     * <p>Works differently from rotate(). We create a temporary DIV with coordinates based on the annotation's properties.
     * However, once this function is called, x,y coordinates will have to be re-adjusted and DIV styles re-assigned for
     * correct positioning and angle rotation.</p>
     * @function
     * @param {object} context The canvas context.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     * @param {object} div The div layer of the free text annotation if annotation type is {@link Annotation.TYPE_TEXT}
     */
    rotateText: function (canvas, angle, scale, div) {
        PageManager.consoleLog('Annotation.rotateText()');
        var x = this.origX * scale;
        var y = this.origY * scale;
        var w = this.origW * scale;
        var h = this.origH * scale;

        if (angle == 90) {
            this.x = canvas.height - y - h;
            this.y = x;
            this.h = w;
            this.w = h;
            div.css('left', (this.x + this.w) + (this.w < 0 ? Math.abs(this.w) : 0));
            div.css('top', this.y + (this.h < 0 ? this.h : 0));
            div.css('transform-origin', '0 0');
            div.css('transform', 'rotate(90deg)');
        } else if (angle == 270) {
            this.x = y;
            this.y = canvas.width - x - w;
            this.h = w;
            this.w = h;
            div.css('left', this.x + (this.w < 0 ? this.w : 0));
            div.css('top', (this.y + this.h) + (this.h < 0 ? Math.abs(this.h) : 0));
            div.css('transform-origin', '0 0');
            div.css('transform', 'rotate(-90deg)');
        } else if (angle == 180) {
            this.x = canvas.height - x - w;
            this.y = canvas.width - y - h;
            this.w = w;
            this.h = h;
            div.css('left', this.x + (w < 0 ? w : 0));
            div.css('top', this.y + (h < 0 ? h : 0));
            div.css('transform', 'rotate(180deg)');
        } else {
            this.x = x;
            this.y = y;
            this.w = w;
            this.h = h;

            if (w < 0)
                div.css('left', this.x + (w < 0 ? w : 0));

            if (h < 0)
                div.css('top', this.y + (h < 0 ? h : 0));
        }
    },

    /**
     * This has the same implementation as the {@link Annotation.rotate|Annotation.rotate()} function of
     * {@link DrawingPosition} and {@link HighlightTextRect} class.
     * @function
     * @param {object} context The canvas context.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     */
    rotatePoint: function (canvas, angle, scale) {
        var bx = this.origX * scale;
        var by = this.origY * scale;

        if (angle == 90) {
            this.x = canvas.height - by;
            this.y = bx;
        } else if (angle == 270) {
            this.x = by;
            this.y = canvas.width - bx;
        } else if (angle == 180) {
            this.x = canvas.height - bx;
            this.y = canvas.width - by;
        } else {
            this.x = bx;
            this.y = by;
        }
    },

    /**
     * String representation of the annotation object.
     * @function
     * @returns {string}
     */
    toString: function () {
        return 'id: ' + this.id + ', rect[' + this.x + ', ' + this.y + ', ' + this.w + ', ' + this.h + '] orig:[' + this.origX + ', ' + this.origY + ', ' + this.origW + ', ' + this.origH + ']';
    },

    /**
     * <p>If the annotation is a highlight or box, get the text that is within the bounds. It adds a span tag for every character found within
     * the div text layer of the PDF.JS page.</p>
     *
     * <p> This implementation should not be changed to Vanilla Javascript as it messed up the result.</p>
     * @function
     * @param {object} annotation The annotation object.
     * @returns {string}
     */
    getTextBelowIt: function (annotation) {
        PageManager.consoleLog('Annotation.getTextBelowIt()');

        var div = PageManager.getPageContainer(this.pageIndex + 1).find('.textLayer');
        var divs = $(div).children();
        var buffer = '';

        divs.each(function (index) {
            var x = parseFloat(div.css('left'));
            var y = parseFloat(div.css('top'));
            var w = parseFloat(div.attr('data-canvas-width'));
            var h = parseFloat(div.height());

            if (Annotation.prototype.intersects(x, y, w, h)) {
                var divSpan = $(this);
                var origHtml = divSpan.html();

                divSpan.html(function (i, html) {
                    var chars = $.trim(html).split("");
                    return '<span annot="true">' + chars.join('</span><span annot="true">') + '</span>';
                });

                var letterBuffer = '';

                $(divSpan).find('span[annot="true"]').each(function () {
                    if (annotation.intersects($(this).offset().left - div.offset().left, $(this).offset().top - div.offset().top, $(this).width(), $(this).height()))
                    {
                        letterBuffer += $(this).text();
                    }
                });

                divSpan.html(origHtml);

                if (letterBuffer.length > 0) {
                    buffer += letterBuffer;

                    if (index + 1 <= divs.length - 1 && parseFloat(divs.eq(index).css('top')) != parseFloat(divs.eq(index + 1).css('top'))) {
                        buffer += '\\n';
                    }
                }
            }
        });

        return buffer;
    },

    intersects: function (x2, y2, w2, h2) {
        return !(this.x > x2 + w2 || this.x + this.w < x2 || this.y > y2 + h2 || this.y + this.h < y2);
    },

    /**
     * For use if annotation has bounds.
     * @function
     * @param {object} canvas The canvas object.
     * @param {number} angle The angle of the canvas.
     * @param {decimal} scale The scale of the canvas.
     * @param {boolean} useDisplayCoordinate
     */
    calculateOrigBound: function (canvas, angle, scale, useDisplayCoordinate) {
        var x = useDisplayCoordinate ? this.x : this.origX;
        var y = useDisplayCoordinate ? this.y : this.origY;
        var w = useDisplayCoordinate ? this.w : this.origW;
        var h = useDisplayCoordinate ? this.h : this.origH;

        /**
         * Set the page dimension details so that this can be adjusted when the annotation
         * will be exported to PDF using iText.
         */
        this.pageWidth = parseInt(PageManager.getPageWidth(canvas.width, canvas.height) / scale);
        this.pageHeight = parseInt(PageManager.getPageHeight(canvas.width, canvas.height) / scale);

        /**
         * For annotations that have images in them, switch the width and height if angle is 90 or 270 degrees
         */
        if (this.icon && this.icon.src && !useDisplayCoordinate && (angle == 90 || angle == 270)) {
            var temp = w;
            w = h;
            h = temp;
        }

        // Location of annotation must be within the canvas area
        if (w < 0) {
            if (x + w < 0) {
                this.x = x = Math.abs(w);
            } else if (x >= canvas.width) {
                this.x = x = canvas.width;
            }
        } else {
            if (x < 0) {
                this.x = x = 1;
            } else if (x + w >= canvas.width) {
                this.x = x = canvas.width - w - 1;
            }
        }

        if (h < 0) {
            if (y + h < 0) {
                this.y = y = Math.abs(h);
            } else if (y >= canvas.height) {
                this.y = y = canvas.height;
            }
        } else {
            if (y < 0) {
                this.y = y = 1;
            } else if (y + h >= canvas.height) {
                this.y = y = canvas.height - h - 1;
            }
        }

        if (angle == 90) {
            this.origX = y / scale;
            this.origY = Math.ceil((canvas.width - (x + w)) / scale);
            this.origW = h / scale;
            this.origH = w / scale;
        } else if (angle == 180) {
            this.origX = Math.ceil((canvas.width - (x + w)) / scale);
            this.origY = Math.ceil((canvas.height - (y + h)) / scale);
            this.origW = w / scale;
            this.origH = h / scale;
        } else if (angle == 270) {
            this.origX = Math.ceil((canvas.height - (y + h)) / scale);
            this.origY = x / scale;
            this.origW = h / scale;
            this.origH = w / scale;
        } else {
            this.origX = x / scale;
            this.origY = y / scale;
            this.origW = w / scale;
            this.origH = h / scale;
        }

        if (this.isResizable()) {
            // Annotation width and height should be minimum 5 pixel / scale
            var MIN_SIDE = 10;

            if (this.isFormField())
                MIN_SIDE = Default.FORM_FIELD_SIZE_MINIMUM;

            this.origW = Math.abs(this.origW) < MIN_SIDE ? MIN_SIDE : this.origW;
            this.origH = Math.abs(this.origH) < MIN_SIDE ? MIN_SIDE : this.origH;
            this.w = Math.abs(w) < MIN_SIDE * scale ? MIN_SIDE * scale : w;
            this.h = Math.abs(h) < MIN_SIDE * scale ? MIN_SIDE * scale : h;

            if (this.isFormField()) {
                var ff = $('#' + Default.ANNOTATION_ID_PREFIX_FORM_FIELD + (this.id ? this.id : ''));
                ff.css('left', this.x + (angle == 90 ? Math.abs(this.w) : 0));
                ff.css('top', this.y + (angle == 270 ? Math.abs(this.h) : 0));
                ff.css('width', Math.abs(angle != 0 && angle != 180 ? this.h : this.w));
                ff.css('height', Math.abs(angle != 0 && angle != 180 ? this.w : this.h));
            }
        } else if (this.annotationType == Annotation.TYPE_TEXT) {
            var freeText = $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + (this.id ? this.id : ''));
            freeText.css('left', (this.x + (angle == 90 ? this.w : 0)));
            freeText.css('top', (this.y + (angle == 270 ? this.h : 0)));
        }

        // Placed this back on because if circle is out of place on right side, its placement is incorrect
        if (this.annotationType == Annotation.TYPE_CIRCLE_FILL || this.annotationType == Annotation.TYPE_CIRCLE_STROKE) {
            this.circleStartX = this.x;
            this.circleStartY = this.y;
            this.circleLastX = this.x + this.w;
            this.circleLastY = this.y + this.h;
        }
    },

    /**
     * Helper function to determine if the mouse coordinate is in any of the highlight text rect coordinate of the annotation.
     * @function
     * @param {decimal} mouseX The X coordinate of the mouse cursor.
     * @param {decimal} mouseY The Y coordinate of the mouse cursor.
     * @param {object} e The mouse event object.
     * @returns {boolean}
     */
    containsHighlightText: function (mouseX, mouseY, e) {
        if (this.highlightTextRects) {
            for (var i = 0; i < this.highlightTextRects.length; i++) {
                if (e && e.changedTouches) {
                    var circle = {
                        x: mouseX,
                        y: mouseY,
                        r: (e.changedTouches[0].radiusX ? e.changedTouches[0].radiusX : 1)
                    };

                    var rect = {
                        x: this.highlightTextRects[i].left,
                        y: this.highlightTextRects[i].top,
                        w: this.highlightTextRects[i].width,
                        h: this.highlightTextRects[i].height
                    };

                    if (Util.isRectCircleColliding(circle, rect))
                        return true;
                } else
                if (((mouseX >= this.highlightTextRects[i].left && mouseX <= this.highlightTextRects[i].left + this.highlightTextRects[i].width) ||
                        (mouseX <= this.highlightTextRects[i].left && mouseX >= this.highlightTextRects[i].left + this.highlightTextRects[i].width)) &&
                        ((mouseY >= this.highlightTextRects[i].top && mouseY <= this.highlightTextRects[i].top + this.highlightTextRects[i].height) ||
                                (mouseY <= this.highlightTextRects[i].top && mouseY >= this.highlightTextRects[i].top + this.highlightTextRects[i].height)))
                    return true;
            }
        }

        return false;
    },

    /**
     * Helper function to return the background color for use by the highlight text selection annotation.
     * @function
     * @returns {string}
     */
    getHighlightTextColor: function () {
        return this.backgroundColor;
    },

    /**
     * <p>The same implementation of the {@link Annotation.toString|Annotation.toString()} but returns the highlight text
     * rects information only.</p>
     * @function
     * @returns {string}
     */
    toStringHighlightTextCoordinates: function () {
        if (!this.highlightTextRects)
            return null;

        var str = '';
        for (var i = 0; i < this.highlightTextRects.length; i++) {
            str += this.highlightTextRects[i].origLeft + ',' + this.highlightTextRects[i].origTop + ',' +
                    this.highlightTextRects[i].origWidth + ',' + this.highlightTextRects[i].origHeight + ',';
        }

        return str.length > 0 ? str.substring(0, str.length - 1) : str;
    },

    /**
     * <p>To make it easier to detect if a mouse pointer is within the path of the drawing, we use HTML5 Canvas
     * isPointInStroke(). Doing it manually is hard since a drawing will also take into account its thickness
     * and I have no idea how the inner workings of Canvas.</p>
     * @function
     * @param {object} page Page Canvas of PDF.
     * @param {decimal} mouseX The X coordinate of the mouse cursor.
     * @param {decimal} mouseY The Y coordinate of the mouse cursor.
     * @returns {boolean}
     */
    containsDrawing: function (page, mouseX, mouseY) {
        if (!this.drawingPositions || this.drawingPositions.length === 0) {
            return false;
        }

        if (this.drawingPositions.length === 2) {
            return this.hasArrowHead() ?
                    this.containsLineArrowhead(mouseX, mouseY, PDFViewerApplication.pdfViewer.currentScale) :
                    this.containsLine(this.drawingPositions[0], this.drawingPositions[1], mouseX, mouseY, PDFViewerApplication.pdfViewer.currentScale);
        } else if (this.annotationType === Annotation.TYPE_CLOUD) {
            // We use the original implementation for now because it is hard to find a formula for this one.
            var cache = document.createElement('canvas');
            cache.height = page.ctx.canvas.height;
            cache.width = page.ctx.canvas.width;

            var cache_ctx = cache.getContext('2d');

            cache_ctx.beginPath();
            cache_ctx.lineWidth = this.lineWidth + Default.DRAW_WIDTH_THICKNESS_FOR_MOUSE_CLICK;

            for (var p = 0; p < this.drawingPositions.length; p++) {
                if (p == 0)
                    cache_ctx.moveTo(this.drawingPositions[p].x, this.drawingPositions[p].y);
                else
                    cache_ctx.lineTo(this.drawingPositions[p].x, this.drawingPositions[p].y);

                cache_ctx.stroke();
            }

            var result = false;
            try {
                if (this.isPolyLineType())
                    result = cache_ctx.isPointInPath(mouseX, mouseY) || cache_ctx.isPointInStroke(mouseX, mouseY);
                else
                    result = cache_ctx.isPointInStroke(mouseX, mouseY);
            } catch (e) {
                /**
                 * Browser is IE since it does not support isPointInStroke(). Also using
                 * isPointInPath() will not work with lines because it needs a shape and
                 * a line is just a part of a shape.
                 */
                result = cache_ctx.isPointInPath(mouseX, mouseY);
            }

            return result;
        } else {
            // Drawing or other polylines.
            return this.containsConnectingline(mouseX, mouseY, PDFViewerApplication.pdfViewer.currentScale);
        }
    },

    containsLineArrowhead: function (mouseX, mouseY, scale) {
        var p1 = this.drawingPositions[0];
        var p2 = this.drawingPositions[1];
        var inLine = this.containsLine(p1, p2, mouseX, mouseY, scale);
        if (inLine)
            return true;

        if (this.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE) {
            var lineAngle = Math.atan2(p2.y - p1.y, p2.x - p1.x);
            var delta = Math.PI / Default.ARROW_SIZE;
            for (var i = 0; i < 2; i++) {
                inLine = false;
                x = p1.x + (Default.ARROWHEAD_LENGTH * scale) * Math.cos(lineAngle + delta)
                y = p1.y + (Default.ARROWHEAD_LENGTH * scale) * Math.sin(lineAngle + delta)
                inLine = this.containsLine(p1, {x: x, y: y}, mouseX, mouseY, scale);
                delta *= (-1);

                if (inLine)
                    return true;
            }
        }

        var lineAngle = Math.atan2(p1.y - p2.y, p1.x - p2.x);
        var delta = Math.PI / Default.ARROW_SIZE;
        for (i = 0; i < 2; i++) {
            inLine = false;
            x = p2.x + (Default.ARROWHEAD_LENGTH * scale) * Math.cos(lineAngle + delta)
            y = p2.y + (Default.ARROWHEAD_LENGTH * scale) * Math.sin(lineAngle + delta)
            inLine = this.containsLine(p2, {x: x, y: y}, mouseX, mouseY, scale);
            delta *= (-1);

            if (inLine)
                return true;
        }
        return false;
    },

    /**
     * <p>Check if mouse cursor coordinate is on top of the line.</p>
     * @see {@link https://stackoverflow.com/questions/6865832/detecting-if-a-point-is-of-a-line-segment}
     * @function
     * @param {object} startPoint Point coordinate { x, y }.
     * @param {object} endPoint Point coordinate { x, y }.
     * @param {decimal} mouseX The X coordinate of the mouse cursor.
     * @param {decimal} mouseY The Y coordinate of the mouse cursor.
     * @param {decimal} scale The scale value.
     * @returns {boolean} Returns true if inside line.
     */
    containsLine: function (startPoint, endPoint, mouseX, mouseY, scale) {
        if (this.drawingPositions.length < 2)
            return false;

        var lineThickness = this.lineWidth * scale;
        var L2 = (((endPoint.x - startPoint.x) * (endPoint.x - startPoint.x)) + ((endPoint.y - startPoint.y) * (endPoint.y - startPoint.y)));
        if (L2 === 0)
            return false;

        var r = (((mouseX - startPoint.x) * (endPoint.x - startPoint.x)) + ((mouseY - startPoint.y) * (endPoint.y - startPoint.y))) / L2;

        // Assume line thickness is circular.
        if (r < 0) {
            // Outside startPoint.
            return (Math.sqrt(((startPoint.x - mouseX) * (startPoint.x - mouseX)) + ((startPoint.y - mouseY) * (startPoint.y - mouseY))) <= lineThickness);
        } else if (0 <= r && r <= 1) {
            // On the line segment.
            var s = (((startPoint.y - mouseY) * (endPoint.x - startPoint.x)) - ((startPoint.x - mouseX) * (endPoint.y - startPoint.y))) / L2;
            return (Math.abs(s) * Math.sqrt(L2) <= lineThickness);
        } else {
            // Outside endPoint.
            return (Math.sqrt(((endPoint.x - mouseX) * (endPoint.x - mouseX)) + ((endPoint.y - mouseY) * (endPoint.y - mouseY))) <= lineThickness);
        }
    },

    /**
     * <p>Check if mouse cursor coordinate is on top of the polyline.</p>
     * @see {@link https://stackoverflow.com/questions/6865832/detecting-if-a-point-is-of-a-line-segment/16271191}
     * @function
     * @param {decimal} mouseX The X coordinate of the mouse cursor.
     * @param {decimal} mouseY The Y coordinate of the mouse cursor.
     * @param {decimal} scale The scale value.
     * @returns {boolean} Returns true if inside the polyline.
     */
    containsConnectingline: function (mouseX, mouseY, scale) {
        if (this.annotationType == Annotation.TYPE_CLOUD || this.drawingPositions.length <= 2)
            return false;

        for (var i = 0; i < this.drawingPositions.length; i++) {
            var inLine = false;

            if (i === this.drawingPositions.length - 1) {
                if (this.annotationType === Annotation.TYPE_DRAWING || this.annotationType === Annotation.TYPE_POLYLINE)
                    break;
                // If not polyline, then use the first coordinate as the closing coordinate.
                else
                    inLine = this.containsLine(this.drawingPositions[i], this.drawingPositions[0], mouseX, mouseY, scale);
            } else
                inLine = this.containsLine(this.drawingPositions[i], this.drawingPositions[i + 1], mouseX, mouseY, scale);

            if (inLine)
                return true;
        }

        return false;
    },

    /**
     * If the annotation is resizable or not.
     * @function
     * @returns {boolean}
     */
    isResizable: function () {
        if (this.isReadOnly())
            return false;

        if (this.isFormField())
            return true;

        switch (this.annotationType) {
            case Annotation.TYPE_AUDIO:
            case Annotation.TYPE_STICKY_NOTE:
            case Annotation.TYPE_DRAWING:
            case Annotation.TYPE_TEXT:
            case Annotation.TYPE_TEXT_HIGHLIGHT:
            case Annotation.TYPE_TEXT_STRIKE_THROUGH:
            case Annotation.TYPE_TEXT_UNDERLINE:
            case Annotation.TYPE_TEXT_INSERT:
            case Annotation.TYPE_TEXT_REPLACE:
            case Annotation.TYPE_HYPERLINK:
                return false;
            default:
                return true;
        }
    },

    isMovable: function () {
        if (this.isReadOnly())
            return false;

        return !(this.annotationType == Annotation.TYPE_DRAWING ||
                this.annotationType == Annotation.TYPE_TEXT_HIGHLIGHT ||
                this.annotationType == Annotation.TYPE_TEXT_STRIKE_THROUGH ||
                this.annotationType == Annotation.TYPE_TEXT_UNDERLINE ||
                this.annotationType == Annotation.TYPE_TEXT_INSERT ||
                this.annotationType == Annotation.TYPE_TEXT_REPLACE ||
                this.annotationType == Annotation.TYPE_HYPERLINK);
    },

    isReadOnly: function () {
        // ahmad
        // We will check if document is locked then 
        // We return readOnly true for each annotation.
        if (parent.SUGAR) {
            if (parent.document.getElementById('signDocframe').getAttribute('is_locked') == "1") {
                return true;
            }
        } else if (is_locked == "1") {
            return true;
        }

        return Default.ANNOTATIONS_READ_ONLY || this.readOnly;
    },

    /**
     * <p>Set the icon source filename when an image or a url with image is assigned. The iconSrc variable will be
     * used in server side to save the filename.</p>
     * @function
     * @param {string} src The image source path.
     * @param {boolean} reload If the annotation is reloaded when the Annotationeer instance is already running. The page
     * where the annotation belongs to needs to be repainted once the image is loaded.
     */
    setIconSource: function (src, reload) {
        if (typeof src == 'string' && !src.startsWith('http') &&
                !src.startsWith('data:image') && !src.startsWith(Url.stampFolderUrl))
            src = Url.stampFolderUrl + src;

        if (!this.icon)
            this.icon = new Image();

        if (reload) {
            var annot = this;
            this.icon.onload = function () {
                var page = pages[Default.canvasIdName + (annot.pageIndex + 1)];
                if (page)
                    page.invalidate();
            }
        }

        if (Util.isImage(src)) {
            this.icon = src;
            this.iconSrc = this.icon.src;
        } else {
            this.icon.src = src;
            this.iconSrc = src;
        }
    },

    /**
     * If the arrow is below the minimum length.
     * @function
     * @returns {boolean}
     */
    isArrowNotLongEnough: function (scale) {
        if (!this.drawingPositions || this.drawingPositions.length != 2)
            return false;

        var distance = Util.getDistance(this.drawingPositions[0].x, this.drawingPositions[0].y,
                this.drawingPositions[1].x, this.drawingPositions[1].y);
        return (distance < (Default.ARROW_SIZE * scale) * 2 * (this.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE ? 2 : 1));
    },

    /**
     * If the annotation is a text selection type.
     * @function
     * @returns {boolean}
     */
    isSelectableTextType: function () {
        return this.annotationType == Annotation.TYPE_TEXT_HIGHLIGHT ||
                this.annotationType == Annotation.TYPE_TEXT_UNDERLINE ||
                this.annotationType == Annotation.TYPE_TEXT_STRIKE_THROUGH ||
                this.annotationType == Annotation.TYPE_TEXT_REPLACE;
    },

    /**
     * Refers to annotations that depend on the Div layer instead of the Canvas.
     * @function
     * @returns {boolean}
     */
    isBasedOnDivLayer: function () {
        return this.isSelectableTextType() || this.annotationType == Annotation.TYPE_TEXT;
    },

    /**
     * Gets the area of the annotation. Not sure if this will work with self intersecting polygons<br/>
     * @see {@link http://www.techbluff.com/javascript/function-to-calculate-polygon-area/}
     * @function
     * @returns {decimal}
     */
    getArea: function () {
        if (this.drawingPositions.length == 0)
            return 0;

        // Accumulates area in the loop
        var area = 0;
        // The last vertex is the 'previous' one to the first
        var j = this.drawingPositions.length - 1;

        for (var i = 0; i < this.drawingPositions.length; i++) {
            area = area + (this.drawingPositions[j].origX + this.drawingPositions[i].origX) *
                    (this.drawingPositions[j].origY - this.drawingPositions[i].origY);
            // j is previous vertex to i
            j = i;
        }
        return Math.abs(area);
    },

    /**
     * Indicate if annotation has editable properties like background color, foreground color, etc.
     * @function
     * @returns {boolean}
     */
    hasEditableProperties: function () {
        return (!this.usesImage() ||
                this.annotationType == Annotation.TYPE_STICKY_NOTE ||
                this.annotationType == Annotation.TYPE_TEXT_INSERT) &&
                this.annotationType != Annotation.TYPE_HYPERLINK;
    },

    /**
     * If the annotation uses a background color property.
     * @function
     * @returns {boolean}
     */
    hasBackgroundColorProperty: function () {
        return this.annotationType == Annotation.TYPE_HIGHLIGHT ||
                this.annotationType == Annotation.TYPE_CIRCLE_FILL ||
                this.annotationType == Annotation.TYPE_TEXT ||
                this.annotationType == Annotation.TYPE_TEXT_HIGHLIGHT ||
                this.annotationType == Annotation.TYPE_STICKY_NOTE;
    },

    /**
     * If the annotation uses a foreground color property.
     * @function
     * @returns {boolean}
     */
    hasForegroundColorProperty: function () {
        return this.annotationType == Annotation.TYPE_TEXT ||
                !this.hasBackgroundColorProperty();
    },

    /**
     * <p>This function is used to indicate if the mouse cursor is within any of the
     * selection handles' area which also takes into account its radius area where
     * its size can indicate a finger or stylus. Used for touch detection on resize.</p>
     * @function
     * @param {decimal} mouseX The X coordinate of the mouse cursor.
     * @param {decimal} mouseY The Y coordinate of the mouse cursor.
     * @param {decimal} radius The radius of the cursor indicates this is a touch event. But instead of
     * multiplying by 2 to make it a diameter, we use the radius value since the returned value
     * from the touch radius has a diameter value.
     * @returns {boolean}
     */
    getSelectionHandleIndex: function (mouseX, mouseY, radius) {
        var circle = {
            x: mouseX,
            y: mouseY,
            r: radius
        };

        for (var i = 0; i < this.selectionHandles.length; i++) {
            var rect = {
                x: this.selectionHandles[i].x,
                y: this.selectionHandles[i].y,
                w: Default.ANNOTATION_SELECTION_BOX_SIZE,
                h: Default.ANNOTATION_SELECTION_BOX_SIZE
            };

            if (Util.isRectCircleColliding(circle, rect))
                return i;

        }
        return -1;
    },

    /**
     * Returns the tooltip string of the annotation.
     * @function
     * @returns {string}
     */
    getTooltip: function () {
        var comment = this.getRootComment();
        return (comment != '' ? (Default.ANNOTATIONS_TOOLTIP_MAX_CHARS > 0 &&
                comment.length > Default.ANNOTATIONS_TOOLTIP_MAX_CHARS ?
                comment.substring(0, Default.ANNOTATIONS_TOOLTIP_MAX_CHARS) + '...' : comment) :
                Message.NO_COMMENT);
    },

    /**
     * If an annotation uses an image for its icon.
     * @function
     * @returns {boolean}
     */
    usesImage: function () {
        return this.annotationType == Annotation.TYPE_AUDIO ||
                this.annotationType == Annotation.TYPE_STICKY_NOTE ||
                this.annotationType == Annotation.TYPE_STAMP ||
                this.annotationType == Annotation.TYPE_DIGITAL_SIGNATURE;
    },

    /**
     * There are certain annotations that cannot be set to toggled when creating new annotations.
     * @function
     * @returns {boolean}
     */
    isNonToggable: function () {
        return this.annotationType == Annotation.TYPE_AUDIO ||
                this.annotationType == Annotation.TYPE_TEXT ||
                this.annotationType == Annotation.TYPE_SCREENSHOT ||
                this.annotationType == Annotation.TYPE_STICKY_NOTE ||
                this.usesImage() ||
                this.isPolyLineType() ||
                this.isFormField();
    },

    /**
     * <p>Since we followed Adobe Acrobat's style with measurement area where the root comment is the measurement
     * itself, the annotation's comment thread will disable the root comment for editing.</p>
     * @function
     * @returns {boolean}
     */
    isRootCommentEditable: function () {
        return !this.hasMeasuring() && this.annotationType != Annotation.TYPE_TEXT;
    },

    /**
     * If the annotation has a measurement associated with it.
     * @function
     * @returns {boolean}
     */
    hasMeasuring: function () {
        return this.annotationType == Annotation.TYPE_MEASUREMENT_AREA ||
                this.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE;
    },

    /**
     * If the annotation can contain comments.
     * @function
     * @returns {boolean}
     */
    canContainComments: function () {
        return !this.isFormField() &&
                this.annotationType != Annotation.TYPE_DIGITAL_SIGNATURE &&
                this.annotationType != Annotation.TYPE_HYPERLINK;
    },

    /**
     * If the annotation is a form field.
     * @function
     * @returns {boolean}
     */
    isFormField: function () {
        return this.annotationType == Annotation.TYPE_FORM_TEXT_FIELD ||
                this.annotationType == Annotation.TYPE_FORM_CHECKBOX ||
                this.annotationType == Annotation.TYPE_FORM_RADIO_BUTTON ||
                this.annotationType == Annotation.TYPE_FORM_TEXT_AREA ||
                this.annotationType == Annotation.TYPE_FORM_COMBO_BOX ||
                this.annotationType == Annotation.TYPE_FORM_BUTTON;
    },

    /**
     * If the kind of form field can be grouped.
     * @function
     * @returns {boolean}
     */
    hasFieldSet: function () {
        return this.annotationType == Annotation.TYPE_FORM_CHECKBOX ||
                this.annotationType == Annotation.TYPE_FORM_RADIO_BUTTON;
    },

    /**
     * Returns the root comment of the annotation.
     * @function
     * @returns {string}
     */
    getRootComment: function () {
        if (this.annotationType == Annotation.TYPE_MEASUREMENT_AREA)
            return Util.getAreaFromPixels(this, this.getArea());
        else if (this.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE || this.annotationType == Annotation.TYPE_TEXT)
            return this.text;
        else
            return this.comments[0].comment.length > 0 ? this.comments[0].comment : Message.NO_COMMENT;
    },

    /**
     * If the annotation uses line style.
     * @function
     * @returns {boolean}
     */
    hasLineStyle: function () {
        return this.annotationType == Annotation.TYPE_BOX;
    },

    /**
     * If the annotation uses opacity.
     * @function
     * @returns {boolean}
     */
    hasOpacity: function () {
        return this.annotationType == Annotation.TYPE_HIGHLIGHT ||
                this.annotationType == Annotation.TYPE_CIRCLE_FILL ||
                this.annotationType == Annotation.TYPE_TEXT_HIGHLIGHT;
    },

    /**
     * If the annotation uses two end points. e.g. Arrow, line, measurement distance.
     * @function
     * @returns {boolean}
     */
    hasTwoEndPoints: function () {
        return this.annotationType == Annotation.TYPE_LINE ||
                this.annotationType == Annotation.TYPE_ARROW ||
                this.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE;
    },

    /**
     * If the annotation is a polyline type.
     * @function
     * @returns {boolean}
     */
    isPolyLineType: function () {
        return this.annotationType == Annotation.TYPE_CLOUD ||
                this.annotationType == Annotation.TYPE_POLY_LINE ||
                this.annotationType == Annotation.TYPE_POLYGON ||
                this.annotationType == Annotation.TYPE_MEASUREMENT_AREA;
    },

    /**
     * If the annotation uses line width.
     * @function
     * @returns {boolean|*}
     */
    hasLineWidth: function () {
        return this.annotationType == Annotation.TYPE_BOX ||
                this.annotationType == Annotation.TYPE_CIRCLE_STROKE ||
                this.annotationType == Annotation.TYPE_DRAWING ||
                this.annotationType == Annotation.TYPE_LINE ||
                this.annotationType == Annotation.TYPE_ARROW ||
                this.isPolyLineType();
    },

    /**
     * If the annotation has an arrowhead.
     * @function
     * @returns {boolean}
     */
    hasArrowHead: function () {
        return this.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE ||
                this.annotationType == Annotation.TYPE_ARROW;
    },

    /**
     * <p>Helper function to draw cloud annotation where the parameter of line width is required to
     * distinguish it from being a normal displayed annotation versus a selectable one.</p>
     * @function
     * @param {object} context The canvas context.
     * @param {number} lineWidth The line width.
     * @param {string} color The color of the cloud annotation.
     * @param {decimal} scale The scale of the canvas.
     * @param {decimal} radius The radius of the cloud. This is an override option via parameter.
     * @param {boolean} isBox If the annotation type is {@link Annotation.TYPE_BOX}.
     */
    drawCloud: function (context, lineWidth, color, scale, radius, isBox) {
        // Same code as above, the difference is only the line width.
        var radius = (radius ? radius : Default.CLOUD_RADIUS) * scale;
        var overlap = Default.CLOUD_OVERLAP;
        var stretch = Default.CLOUD_STRETCH;

        var circle = [];
        var delta = 2 * radius * overlap;

        // Do not use Array.splice() as it will hold the same reference for the objects in the array.
        var points = [].concat(this.drawingPositions);

        if (!Util.isClockWise(points)) {
            points.reverse();
        }

        if (isBox) {
            var dps = [];
            var dp;

            if (this.w < 0 && this.h < 0) {
                // Upper left.
                dp = new DrawingPosition();
                dp.x = this.x;
                dp.y = this.y;
                dps.push(dp);

                // Upper right.
                dp = new DrawingPosition();
                dp.x = this.x + this.w;
                dp.y = this.y;
                dps.push(dp);

                // Lower left.
                dp = new DrawingPosition();
                dp.x = this.x + this.w;
                dp.y = this.y + this.h;
                dps.push(dp);

                // Lower right.
                dp = new DrawingPosition();
                dp.x = this.x;
                dp.y = this.y + this.h;
                dps.push(dp);
            } else if (this.w < 0 || this.h < 0) {
                // Upper left.
                dp = new DrawingPosition();
                dp.x = this.x + this.w;
                dp.y = this.y;
                dps.push(dp);

                // Upper right.
                dp = new DrawingPosition();
                dp.x = this.x;
                dp.y = this.y;
                dps.push(dp);

                // Lower left.
                dp = new DrawingPosition();
                dp.x = this.x;
                dp.y = this.y + this.h;
                dps.push(dp);

                // Lower right.
                dp = new DrawingPosition();
                dp.x = this.x + this.w;
                dp.y = this.y + this.h;
                dps.push(dp);
            }
            // If width > 0 and height > 0.
            else {
                // Upper left.
                dp = new DrawingPosition();
                dp.x = this.x;
                dp.y = this.y;
                dps.push(dp);

                // Upper right.
                var dp = new DrawingPosition();
                dp.x = this.x + this.w;
                dp.y = this.y;
                dps.push(dp);

                // Lower right.
                var dp = new DrawingPosition();
                dp.x = this.x + this.w;
                dp.y = this.y + this.h;
                dps.push(dp);

                // Lower left.
                var dp = new DrawingPosition();
                dp.x = this.x;
                dp.y = this.y + this.h;
                dps.push(dp);
            }

            points = [].concat(dps);
        }

        var prev = points[points.length - 1];
        for (var i = 0; i < points.length; i++) {
            var curr = points[i];

            var dx = curr.x - prev.x;
            var dy = curr.y - prev.y;

            var len = Math.sqrt(dx * dx + dy * dy);

            dx = dx / len;
            dy = dy / len;

            var d = delta;

            if (stretch) {
                var n = (len / delta + 0.5) | 0;
                if (n < 1)
                    n = 1;
                d = len / n;
            }

            for (var a = 0; a + 0.1 * d < len; a += d) {
                circle.push({
                    x: prev.x + a * dx,
                    y: prev.y + a * dy
                });
            }

            prev = curr;
        }

        // Determine intersection angles of circles
        var prev = circle[circle.length - 1];
        for (var i = 0; i < circle.length; i++) {
            var curr = circle[i];
            var angle = Util.intersectAngle(prev, curr, radius);

            prev.end = angle[0];
            curr.begin = angle[1];

            prev = curr;
        }

        // Draw the cloud
        context.save();

        context.strokeStyle = color;
        context.lineWidth = lineWidth * scale;

        var incise = Math.PI * Default.CLOUD_INCISE / 180;

        for (var i = 0; i < circle.length; i++) {
            context.beginPath();
            context.arc(circle[i].x, circle[i].y, radius, circle[i].begin, circle[i].end + incise);
            context.stroke();
        }

        context.restore();
    },

    /**
     * If the annotation can use review status in its comments.
     * @function
     * @returns {boolean}
     */
    isReviewStatusable: function () {
        // We remove this because anybody should be able to add a comment status regardless
        // if the annotation is read-only or not.
        //if (this.readOnly)
        //	return false;

        return this.annotationType != Annotation.TYPE_DIGITAL_SIGNATURE;
    },

    /**
     * <p>Draws a triangle with quadratic curves on the side. The lineTo() function is not really needed but
     * still placed there to easily understand how the shape is drawn.</p>
     * @function
     * @param context The canvas context.
     * @param angle The angle of the PDF.JS page.
     * @param rect The rectangle of HighlightTextRect which will be used as basis for drawing this in text replace annotation.
     * This assumes the rect's domRotateAngle is 0 as doing it for others is too much work.
     */
    drawQuadraticCurveTriangle: function (context, angle, rect) {
        context.beginPath();

        var h = rect ? (angle == 90 || angle == 270 ? rect.width : rect.height) / 2 : this.h;
        var w = h;
        var x = this.x;
        var y = this.y;

        if (angle == 0) {
            if (rect) {
                x = rect.right - (w / 2);
                y = rect.top + h;
            }

            // Left bottom to top.
            context.moveTo(x, y + h);
            context.quadraticCurveTo(x + (w / 2), y + (h / 2), x + (w / 2), y);
            // Right top to bottom.
            context.quadraticCurveTo(x + (w / 2), y + (h / 2), x + w, y + h);
            // Bottom right to left.
            context.lineTo(x, y + h);
        } else if (angle == 90) {
            if (rect) {
                x = rect.left;
                y = rect.bottom - (w / 2);
            }

            // Left top to right middle.
            context.moveTo(x, y);
            context.quadraticCurveTo(x + (w / 2), y + (h / 2), x + w, y + (h / 2));
            // Right middle to bottom left.
            context.quadraticCurveTo(x + (w / 2), y + (h / 2), x, y + h);
            // Bottom left to top.
            context.lineTo(x, y);
        } else if (angle == 180) {
            if (rect) {
                x = rect.left - (w / 2);
                y = rect.top;
            }

            // Left top to bottom.
            context.moveTo(x, y);
            context.quadraticCurveTo(x + (w / 2), y + (h / 2), x + (w / 2), y + h);
            // Right bottom to top.
            context.quadraticCurveTo(x + (w / 2), y + (h / 2), x + w, y);
            // Top left to right.
            context.lineTo(x, y);
        } else if (angle == 270) {
            if (rect) {
                x = rect.right - w;
                y = rect.top - (w / 2);
            }

            // Right bottom to left middle.
            context.moveTo(x + w, y + h);
            context.quadraticCurveTo(x + (w / 2), y + (h / 2), x, y + (h / 2));
            // Left middle to right top.
            context.quadraticCurveTo(x + (w / 2), y + (h / 2), x + w, y);
            // Right top to bottom.
            context.lineTo(x + w, y + h);
        }

        context.fillStyle = this.color;
        context.fill();
        context.closePath();
    }

};

/**
 * Creats an annotation object from a JSON string.
 * @see {@link http://stackoverflow.com/questions/8111446/turning-json-strings-into-objects-with-methods}
 * @function
 * @param {string} json The JSON string.
 * @returns {Annotation}
 */
Annotation.createFromJSON = function (json) {
    if (typeof json === 'string')
        json = JSON.parse(json);

    var obj = new Annotation();

    for (var key in json) {
        if (!json.hasOwnProperty(key)) {
            continue;
        }

        if (key == 'drawingPositions') {
            var array = json[key];
            for (var a in array) {
                array[a] = DrawingPosition.createFromJSON(array[a]);
            }
            obj[key] = array;
        } else if (key == 'highlightTextRects') {
            var array = json[key];
            for (var a in array) {
                array[a] = HighlightTextRect.createFromJSON(array[a]);
            }
            obj[key] = array;
        } else if (key == 'iconSrc') {
            if (json[key] != '') {
                obj.icon = new Image();
                // This may be a url. If so, get the image file name.
                obj.setIconSource(json[key].startsWith('data:image') ? json[key] : 'images/' + json[key].split('/').pop());
                obj.setIconSource(json[key].startsWith('data:image') ? json[key] : 'images/' + json[key].split('/').pop());
            }
        } else
            obj[key] = json[key];
    }
    return obj;
};

/**
 * jQuery.extend() is not consistent as references property values also get changed. Then the icon property is specifically
 * referenced because the Annotation.createFromJSON() will not return it as an Image object but as a type Object.
 * @function
 * @param {object} annotation The annotation object.
 * @returns {Annotation.Annotation}
 */
Annotation.clone = function (annotation) {
    var clone = Annotation.createFromJSON(Util.jsonStringify(annotation));
    clone.icon = annotation.icon;
    return clone;
};

/**
 * The property for annotation type TYPE_AUDIO.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_AUDIO = 1;
/**
 * The property for annotation type TYPE_HIGHLIGHT.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_HIGHLIGHT = 2;
/**
 * The property for annotation type TYPE_BOX.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_BOX = 3;
/**
 * The property for annotation type TYPE_DRAWING.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_DRAWING = 4;
/**
 * The property for annotation type TYPE_TEXT_HIGHLIGHT.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_TEXT_HIGHLIGHT = 5;
/**
 * The property for annotation type TYPE_TEXT.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_TEXT = 6;
/**
 * The property for annotation type TYPE_TEXT_UNDERLINE.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_TEXT_UNDERLINE = 7;
/**
 * The property for annotation type TYPE_TEXT_STRIKE_THROUGH.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_TEXT_STRIKE_THROUGH = 8;
/**
 * The property for annotation type TYPE_STICKY_NOTE.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_STICKY_NOTE = 9;
/**
 * The property for annotation type TYPE_CIRCLE_FILL.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_CIRCLE_FILL = 10;
/**
 * The property for annotation type TYPE_CIRCLE_STROKE.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_CIRCLE_STROKE = 11;
/**
 * The property for annotation type TYPE_STAMP.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_STAMP = 12;
/**
 * The property for annotation type TYPE_ARROW.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_ARROW = 13;
/**
 * The property for annotation type TYPE_MEASUREMENT_DISTANCE.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_MEASUREMENT_DISTANCE = 14;
/**
 * The property for annotation type TYPE_MEASUREMENT_AREA.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_MEASUREMENT_AREA = 15;
/**
 * The property for annotation type TYPE_FORM_TEXT_FIELD.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_FORM_TEXT_FIELD = 16;
/**
 * The property for annotation type TYPE_FORM_CHECKBOX.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_FORM_CHECKBOX = 17;
/**
 * The property for annotation type TYPE_FORM_RADIO_BUTTON.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_FORM_RADIO_BUTTON = 18;
/**
 * The property for annotation type TYPE_FORM_TEXT_AREA.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_FORM_TEXT_AREA = 19;
/**
 * The property for annotation type TYPE_FORM_COMBO_BOX.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_FORM_COMBO_BOX = 20;
/**
 * The property for annotation type TYPE_FORM_BUTTON.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_FORM_BUTTON = 21;
/**
 * The property for annotation type TYPE_HYPERLINK.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_HYPERLINK = 22;
/**
 * The property for annotation type TYPE_DIGITAL_SIGNATURE.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_DIGITAL_SIGNATURE = 23;
/**
 * The property for annotation type TYPE_LINE.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_LINE = 24;
/**
 * The property for annotation type TYPE_POLY_LINE.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_POLY_LINE = 25;
/**
 * The property for annotation type TYPE_POLYGON.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_POLYGON = 26;
/**
 * The property for annotation type TYPE_CLOUD.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_CLOUD = 27;
/**
 * The property for annotation type TYPE_TEXT_INSERT.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_TEXT_INSERT = 28;
/**
 * The property for annotation type TYPE_TEXT_REPLACE.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_TEXT_REPLACE = 29;
/**
 * The property for annotation type TYPE_SCREENSHOT.
 * @memberof Annotation
 * @type {number}
 */
Annotation.TYPE_SCREENSHOT = -9999;

/**
 * The measurement unit type.
 * @namespace MeasurementType
 */
var MeasurementType = {};

/**
 * The property for measurement unit INCHES.
 * @memberof MeasurementType
 * @type {number}
 */
MeasurementType.INCHES = 1;

/**
 * The property for measurement unit CENTIMETERS.
 * @memberof MeasurementType
 * @type {number}
 */
MeasurementType.CENTIMETERS = 2;

/**
 * The property for measurement unit MILLEMETERS.
 * @memberof MeasurementType
 * @type {number}
 */
MeasurementType.MILLIMETERS = 3;

/**
 * The property for measurement unit FOOT and INCH.
 * @memberof MeasurementType
 * @type {number}
 */
MeasurementType.FOOT_INCH = 4;

/**
 * The line style for border.
 * @namespace LineStyle
 */
var LineStyle = {};

/**
 * The property for line style SOLID.
 * @memberof LineStyle
 * @type {number}
 */
LineStyle.SOLID = 1;

/**
 * The property for line style CLOUD.
 * @memberof LineStyle
 * @type {number}
 */
LineStyle.CLOUD = 2;
