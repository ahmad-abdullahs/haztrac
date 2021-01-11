/********************************************************************
 * Copyright (C) 2016-Present Mark Chester Goking <chitgoks@gmail.com>.
 *
 * This file is part of Annotationeer and it can not be copied
 * and/or distributed without the express permission of the author.
 ********************************************************************/

/**
 * This is where all the annotation action takes place. Based on Simon Sarris' drawing shape in canvas demo.
 * @see {@link http://simonsarris.com/blog/225-canvas-selecting-resizing-shape}
 * @namespace Page
 */

/**
 * @constructor
 * @memberof Page
 */
function Page() {
    // Holds all annotations per canvas.
    this.canvasAnnotations = [];
    /**
     * Page index number
     * @type {number}
     */
    this.pageIndex = -1;

    // Mouse coordinates.
    this.mx;
    this.my;

    /**
     * The canvas object associated with the page where all annotations will be drawn.
     * @type {object}
     */
    this.canvas;
    /**
     * The canvas object.
     * @type {object}
     */
    this.ctx;

    // We use a fake canvas to draw individual shapes for selection testing
    this.ghostcanvas;
    // Fake canvas context
    this.gctx;

    // Since we can drag from anywhere in a node instead of just its x/y corner, we need to save
    // the offset of the mouse when we start dragging.
    this.offsetX;
    this.offsetY;

    // Padding and border style widths for mouse offsets
    this.stylePaddingLeft;
    this.stylePaddingTop;
    this.styleBorderLeft;
    this.styleBorderTop;
    /**
     * The annotation object to represent screen shot dimensions.
     * @type {Annotation}
     */
    this.screenshotAnnotation;
    /**
     * Drawing should only be limited within the page's canvas.
     * @type {boolean}
     */
    this.isDrawing = false;
    /**
     * Creating annotation should be limited within the page's canvas
     * @type {boolean}
     */
    this.isCreatingAnnotation = false;
}

/**
 * <p>Initialize our canvas, add a ghost canvas, set draw loop
 * then add everything we want to initially exist on the canvas.</p>
 * @function
 * @memberof Page
 * @param {string} canvasIdName Initializes the {@link Page} object based on the canvas id name.
 */
Page.prototype.init = function(canvasIdName) {
    this.canvas = document.getElementById(canvasIdName);

    this.ctx = this.canvas.getContext('2d');
    this.ghostcanvas = document.createElement('canvas');
    this.ghostcanvas.height = this.canvas.height;
    this.ghostcanvas.width = this.canvas.width;

    this.gctx = this.ghostcanvas.getContext('2d');

    // Fixes a problem where double clicking causes text to get selected on the canvas
    this.canvas.onselectstart = function() { return false; };

    // Fixes mouse co-ordinate problems when there's a border or padding
    // See getMouse for more details
    if (document.defaultView && document.defaultView.getComputedStyle) {
        this.stylePaddingLeft = parseInt(document.defaultView.getComputedStyle(this.canvas, null)['paddingLeft'], 10)     || 0;
        this.stylePaddingTop  = parseInt(document.defaultView.getComputedStyle(this.canvas, null)['paddingTop'], 10)      || 0;
        this.styleBorderLeft  = parseInt(document.defaultView.getComputedStyle(this.canvas, null)['borderLeftWidth'], 10) || 0;
        this.styleBorderTop   = parseInt(document.defaultView.getComputedStyle(this.canvas, null)['borderTopWidth'], 10)  || 0;
    }

    var self = this;

    if (Util.isMobile()) {
        this.canvas.addEventListener('touchstart', function(e) {
            self.mouseDown(e, true);
        });

        this.canvas.addEventListener('touchmove', function(e) {
            self.mouseMove(e, true);
        });

        this.canvas.addEventListener('touchend', function(e) {
            e.preventDefault();
            self.mouseUp(e);
        });
    }
    else {
          $(this.canvas).mousestop(Default.MOUSE_STOP_DELAY , function(e, data) {
            self.showHideTooltip(true, data.mousemove);
        });
        // this.canvas.mousestop(Default.MOUSE_STOP_DELAY , function(e, data) {
        //     self.showHideTooltip(true, data.mousemove);
        // });
    }

    this.canvas.onmousedown = function(e) {
        self.mouseDown(e);
    };

    this.canvas.onmousemove = function(e) {
        if (self.canvas._tippy && self.canvas._tippy.state.isVisible)
            self.canvas._tippy.hide();

        self.mouseMove(e);
    };

    this.canvas.onmouseup = function(e) {
        self.mouseUp(e);
    };

    // disable browser context menus in canvas, so only annotation popup menu will appear
    this.canvas.oncontextmenu = function(e) {
        e.preventDefault();
        return false;
    };

    this.canvas.ondblclick = function(e) {
        if (PageManager.selectedAnnotations.length > 1) {
            e.preventDefault();
            return;
        }

        self.doubleClick(e);
    };
};

/**
 * Wipes the canvas context. Clears all drawings inside it.
 * @function
 * @memberof Page
 * @param {object} c The canvas object.
 */
Page.prototype.clear = function(c) {
    c.clearRect(0, 0, $(this.canvas).width(), $(this.canvas).height());
};

/**
 * Draws annotations, watermark, form fields.
 * @function
 * @memberof Page
 * @param {decimal} scale The current scale value. If null, use PDFViewerApplication.pdfViewer.currentScale.
 */
Page.prototype.mainDraw = function(scale) {

    this.clear(this.ctx);

    if ((PageManager.startCreatingAnnotation && PageManager.boxAnnotationGuide &&
		PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_SCREENSHOT) ||
        this.screenshotAnnotation)
    {
        // dim background
        this.ctx.fillStyle = Default.SCREENSHOT_DIM_COLOR;
        this.ctx.fillRect(this.canvas.offsetLeft, this.canvas.offsetTop, this.canvas.width, this.canvas.height);

        if (this.screenshotAnnotation)
            this.ctx.clearRect(this.screenshotAnnotation.x, this.screenshotAnnotation.y, this.screenshotAnnotation.w, this.screenshotAnnotation.h);
    }

    // Display annotations
    if (this.canvasAnnotations)
        for (var i=0; i<this.canvasAnnotations.length; i++) {
            if (this.canvasAnnotations[i].isBasedOnDivLayer()) {
                if (Default.ANNOTATION_SELECTABLE_TEXT_AS_DIV) {
                    var div = $('div#' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + this.canvasAnnotations[i].id);
                    if (this.canvasAnnotations[i].isSelectableTextType()) {
                        div.css('display', this.canvasAnnotations[i].hidden ? 'none' : 'block');

                        // Update colors in case user modified them
                        if (this.canvasAnnotations[i].annotationType === Annotation.TYPE_TEXT_HIGHLIGHT) {
                            var rgbColor = Util.hexToRgb(this.canvasAnnotations[i].backgroundColor);
                            var whatColor = 'rgba(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ', ' + Default.FILL_OPACITY + ')';
                            div.css('background-color', whatColor);
                        }
                        else if (this.canvasAnnotations[i].annotationType === Annotation.TYPE_TEXT_STRIKE_THROUGH) {
                            div.find('div').css('border-top-color', this.canvasAnnotations[i].color);
                        }
                        else {
                            var boxShadow = div.css('box-shadow');

                            if (!boxShadow)
                                continue;

                            var rgbColor = Util.hexToRgb(this.canvasAnnotations[i].color);
                            var whatColor = 'rgb(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ')';
                            div.css('box-shadow', whatColor + ' ' + boxShadow.substring(boxShadow.indexOf(')') + 1));
                        }
                    }
                }

                if (this.canvasAnnotations[i].annotationType === Annotation.TYPE_TEXT) {
                    var rgbBackgroundColor = Util.hexToRgb(this.canvasAnnotations[i].backgroundColor);
                    var whatBackgroundColor = 'rgba(' + rgbBackgroundColor.r + ', ' + rgbBackgroundColor.g + ', ' + rgbBackgroundColor.b + ', ' + Default.FILL_OPACITY + ')';
                    var rgbColor = Util.hexToRgb(this.canvasAnnotations[i].color);
                    var whatColor = 'rgb(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ')';
                    var divFreeText = $('div#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + this.canvasAnnotations[i].id);
                    divFreeText.css('background-color', whatBackgroundColor);
                    divFreeText.css('color', whatColor);
                    divFreeText.css('display', this.canvasAnnotations[i].hidden ? 'none' : 'block');
                }
            }
            else if (this.canvasAnnotations[i].isFormField()) {
                var inputFormField = $('input#' + Default.ANNOTATION_ID_PREFIX_FORM_FIELD + this.canvasAnnotations[i].id);
                if (this.canvasAnnotations[i].hidden)
                    inputFormField.attr('hidden', true);
                else
                    inputFormField.removeAttr('hidden');
            }

            if (this.canvasAnnotations[i].hidden)
                continue;

            this.canvasAnnotations[i].draw(this.ctx, rotateAngle, scale ? scale : PDFViewerApplication.pdfViewer.currentScale);
        }

    if (this.screenshotAnnotation) {
        this.screenshotAnnotation.draw(this.ctx, rotateAngle, scale ? scale : PDFViewerApplication.pdfViewer.currentScale);
    }
};

/**
 * Alias for {@link Page.mainDraw|Page.mainDraw()}.
 * @function
 * @memberof Page
 * @param {decimal} scale The current scale value. If null, use PDFViewerApplication.pdfViewer.currentScale.
 */
Page.prototype.invalidate = function(scale) {
    this.mainDraw(scale);
};

/**
 * <p>Sets mx,my to the mouse position relative to the canvas. Unfortunately this can be tricky,
 * we have to worry about padding and borders.</p>
 * @function
 * @memberof Page
 * @param {object} e The event object.
 * @param {object} self The page object.
 * @param {boolean} calculateOnly Acts as a helper method to calculate coordinates insted of setting the mx and my properties.
 */
Page.prototype.getMouse = function(e, self, calculateOnly) {
    var tempX = 0;
    var tempY = 0;

    //var evt = window.event || e;
    var evt = Util.isMobile() && e.changedTouches ? e.changedTouches[0] : e;
    if (evt.pageX || evt.pageY) {
        tempX = evt.pageX;
        tempY = evt.pageY;
    }
    else {
        tempX = evt.clientX +
        (document.documentElement.scrollLeft ||
        document.body.scrollLeft) -
        document.documentElement.clientLeft;
        // tempY = evt.clientY +
        // (document.documentElement.scrollTop ||
        // document.body.scrollTop) -
        // document.documentElement.clientTop;
    }

    if (tempX < 0) { tempX = 0; }
    if (tempY < 0) { tempY = 0; }

    var offset = $(self.canvas).offset();

    if (calculateOnly) {
        return { x: tempX - offset.left, y: tempY - offset.top };
    }
    else {
        this.mx = tempX - offset.left;
        this.my = tempY - offset.top;
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
Page.prototype.addAnnotation = function(tempAnnotation, angle, scale, useOrigDimension, isAddedAfterLoad, doNotTriggerEvent) {
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
    annotation.lineStyle = tempAnnotation.lineStyle;
    annotation.calibrationLabel = tempAnnotation.calibrationLabel;
    annotation.calibrationValue = tempAnnotation.calibrationValue;
    annotation.calibrationMeasurementType = tempAnnotation.calibrationMeasurementType;
    annotation.measurementType = tempAnnotation.measurementType;

    annotation.color = tempAnnotation.color;
    annotation.backgroundColor = tempAnnotation.backgroundColor ? tempAnnotation.backgroundColor : Default.DRAW_COLOR_BACKGROUND;
    annotation.lineWidth = tempAnnotation.lineWidth;
    annotation.opacity = tempAnnotation.opacity;

    /**
     * tempAnnotation.icon becomes an Object happens when this function is called when an annotation event is
     * triggered. If this happens, do not call the function setIconSource().
     */
    if (annotation.usesImage())
        annotation.setIconSource(tempAnnotation.icon);

    annotation.drawingPositions = tempAnnotation.drawingPositions;
    annotation.comments = tempAnnotation.comments;
    annotation.modified = tempAnnotation.modified;
    annotation.selected = tempAnnotation.selected;
    annotation.hidden = tempAnnotation.hidden;
    annotation.readOnly = tempAnnotation.readOnly;
    annotation.readOnlyComment = tempAnnotation.readOnlyComment;

    annotation.audio = tempAnnotation.audio;
    annotation.audioAvailable = tempAnnotation.audioAvailable;

    annotation.dateCreated = tempAnnotation.dateCreated;
    annotation.dateModified = tempAnnotation.dateModified;

    annotation.clicked = tempAnnotation.clicked;
    annotation.selected = tempAnnotation.selected;
    annotation.selectionHandles = tempAnnotation.selectionHandles;

    if (!useOrigDimension)
        if (annotation.annotationType === Annotation.TYPE_DRAWING) {
            if (annotation.drawingPositions.length < Default.DRAW_POINT_MINIMUM) {
                this.invalidate();
                return;
            }
        }
        else if (annotation.hasTwoEndPoints()) {
            if (annotation.drawingPositions.length === 1) {
                tempAnnotation.drawingPositions = [];
				PageManager.showAlert(Message.ARROW_CREATE_REQUIREMENT, 'info');
                return;
            }
            else if (annotation.isArrowNotLongEnough(scale)) {
                if (((annotation.annotationType === Annotation.TYPE_ARROW || annotation.annotationType === Annotation.TYPE_LINE) && Default.ANNOTATION_ARROW_MINIMUM_LENGTH) ||
                    (annotation.annotationType === Annotation.TYPE_MEASUREMENT_DISTANCE && Default.ANNOTATION_MEASUREMENT_DISTANCE_MINIMUM_LENGTH))
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
            for (var i=0; i<annotation.drawingPositions.length; i++) {
                var drawingPosition = annotation.drawingPositions[i];
                drawingPosition.origX = drawingPosition.x;
                drawingPosition.origY = drawingPosition.y;
                drawingPosition.calculateOrigPosition(this.canvas, angle, scale, true);
            }
        }

        annotation.calculateOrigBound(this.canvas, angle, scale);

        if (Util.isFunction(Annotationeer.saveAnnotation))
            Annotationeer.saveAnnotation(annotation,
                Default.ANNOTATION_GET_TEXT_BELOW_IT &&
                (annotation.annotationType === Annotation.TYPE_HIGHLIGHT ||
                annotation.annotationType === Annotation.TYPE_BOX) ? annotation.getTextBelowIt(annotation) : '',
                doNotTriggerEvent);
        else
			PageManager.showAlert(Message.FUNC_UNDEFINED_ANNO_SAVE, 'info');
    }
    else {
		PageManager.updateAnnotationListAfterSave(annotation, false, doNotTriggerEvent);
    }
};

/**
 * Create a highlight text annotation.
 * @see {@link https://gist.github.com/yurydelendik/f2b846dae7cb29c86d23}
 * @function
 * @memberof Page
 * @param {number} type The annotation type.
 * @param {number} pageIndex The page index.
 * @param {number} angle The rotation angle.
 * @param {decimal} scale The scale value.
 * @param {object} pageView The page view object.
 * @param {object} annotation The annotation object.
 * @param {string} color The color.
 * @param {object} selectionNodeBasis This element will be the basis to determine what angle it is currently positioned.
 * @return {Annotation}
 */
Page.prototype.highlightText = function(type, pageIndex, angle, scale, pageView, annotation, color, selectionNodeBasis) {
	PageManager.consoleLog('Page.highlightText()');
    var page = window.PDFViewerApplication.pdfViewer._pages[pageIndex];
    if (!page) page = pageView;

    var pageElement = page.canvas.parentElement;
    var pageRect = page.canvas.getClientRects()[0];
    var selectionRectangles = annotation ? annotation.highlightTextRects:
        (Util.isIOSDevice() && PageManager.iosSelectedTextClientRects ? PageManager.iosSelectedTextClientRects : PageManager.getSelectedTextClientRects());
    var viewport = page.viewport;

    var newAnnotation;

    if (!annotation) {
        // -chnaged to below-    newAnnotation = new Annotation();
        // ahmad
        // -----START-----
        newAnnotation = new Annotation(1);
        // -----END-----
        newAnnotation.pageIndex = pageIndex;
        newAnnotation.annotationType = type;
    }

    for (var i=0; i<selectionRectangles.length; i++) {
        var r = selectionRectangles[i];

        if (annotation) {
			// Rotate Annotationeer's canvas instead of PDF.JS'.
            r.rotate(this.canvas, angle, scale);
        }
        if (!pageRect)
            continue;

        var rect = viewport.convertToPdfPoint
        (
            (annotation ? ($(pageElement).offset().left + r.left) : r.left) - pageRect.left,
            (annotation ? ($(pageElement).offset().top + r.top) : r.top) - pageRect.top
        ).concat
        (
            viewport.convertToPdfPoint(
                (annotation ? ($(pageElement).offset().left + r.right) : r.right) - pageRect.left,
                (annotation ? ($(pageElement).offset().top + r.bottom) : r.bottom) - pageRect.top
            )
        );

        var bounds = viewport.convertToViewportRectangle(rect);
        var left = Math.min(bounds[0], bounds[2]);
        var top = Math.min(bounds[1], bounds[3]);
        var width = Math.max(Math.abs(bounds[0] - bounds[2]), 1);
        var height = Math.max(Math.abs(bounds[1] - bounds[3]), 1);

        if (top <= 0 || left <= 0)
            continue;

        /**
         * This block of code ensures that highlight, strike-through or underline annotations will overlap
         * if user selects a section of text that is already occupied by one of these kinds of annotation.
         */
        var add = true;
        var elements = $(pageElement).children('div[id="' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + '"]');
        for (var e=0; e<elements.length; e++) {
            var element = elements[e];
            if (((Math.abs(Math.round(parseFloat($(element).css('left'))) - Math.round(left)) <= 5 &&
                Math.abs(Math.round(parseFloat($(element).css('top'))) - Math.round(top)) <= 5)) ||
                (Math.round(parseFloat($(element).css('left'))) ==  Math.round(left) &&
                Math.round(parseFloat($(element).css('top'))) ==  Math.round(top))
            )
            {
                add = false;
                break;
            }
        }

        /**
         * Now we draw text highlight to the canvas instead of div layers to improve performance.
         * Underline and strike-through will follow soon but highlight is done first since it is
         * the easiest as it involves only filling.
         */
        if (add) {
            var domRotateAngle = selectionNodeBasis ?
                Util.getRotationDegrees(selectionNodeBasis ? selectionNodeBasis : $('#highlights' + annotation.id)) :
                selectionRectangles[i].getAngleBasedOnDomRotateAngle(rotateAngle);

            if (Default.ANNOTATION_SELECTABLE_TEXT_AS_DIV) {
                var whatStyle = '';
                var whatColor = '';
                var whichSide = '';

                if (type == Annotation.TYPE_TEXT_HIGHLIGHT) {
                    var rgbColor = Util.hexToRgb(annotation ? annotation.backgroundColor : newAnnotation.backgroundColor);
                    whatColor = 'rgba(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ', ' + Default.FILL_OPACITY + ')';
                    whatStyle = 'background-color: ' + whatColor + ';';
                }
                else if (type == Annotation.TYPE_TEXT_UNDERLINE) {
                    whatColor = (annotation ? annotation.color : newAnnotation.color);

                    switch (domRotateAngle) {
                        case 0:
                            whichSide = '0 2px';
                            break;
                        case 90:
                            whichSide = '-2px 0';
                            break;
                        case 180:
                            whichSide = '0 -2px';
                            break;
                        case 270:
                            whichSide = '2px 0';
                            break;
                    }

                    whatStyle = 'box-shadow: ' + whichSide + ' ' + whatColor + ';';
                }
                // z-index property needs to be present in order for the strike-through to be visible
                else if (type == Annotation.TYPE_TEXT_STRIKE_THROUGH)
                    whatStyle = 'z-index: 0; text-decoration: underline;';

                var el = document.createElement('div');
                el.setAttribute('style', 'position: absolute; ' + whatStyle +
                    'left:' + left + 'px; top:' + top + 'px;' +
                    'width:' + width + 'px; height:' + height + 'px;');
                el.setAttribute('id', Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT);

                pageElement.appendChild(el);

                if (type == Annotation.TYPE_TEXT_STRIKE_THROUGH) {
                    whatColor = (annotation ? annotation.color : newAnnotation.color);
                    //noinspection CheckEmptyScriptTag
                    var div = $('<div/>');
                    div.addClass('strikeThrough');
                    // Bit-wise operator (# & 1) == odd
                    //div.addClass('strikeThrough' + (!((angle / 90) & 1) ? 'Horizontal' : 'Vertical'));
                    div.addClass('strikeThrough' + (domRotateAngle == 0 || domRotateAngle == 180 ? 'Horizontal' : 'Vertical'));

                    /**
                     * Once PDF.JS has fixed the DIV layout height issue, remove the DIV CSS top and left values
                     * to re-adjust the strike-through line.
                     */
                    switch (domRotateAngle) {
                        case 0:
                            div.css('border-top-color', whatColor);

                            if (Default.ANNOTATION_STRIKE_THROUGH_ADJUST)
                                div.css('top', '40%');

                            break;
                        case 90:
                            div.css('border-left-color', whatColor);

                            if (Default.ANNOTATION_STRIKE_THROUGH_ADJUST)
                                div.css('left', '55%');

                            break;
                        case 180:
                            div.css('border-top-color', whatColor);

                            if (Default.ANNOTATION_STRIKE_THROUGH_ADJUST)
                                div.css('top', '60%');

                            break;
                        case 270:
                            div.css('border-left-color', whatColor);

                            if (Default.ANNOTATION_STRIKE_THROUGH_ADJUST)
                                div.css('left', '45%');

                            break;
                    }

                    div.appendTo(el);
                }
            }

            if (!annotation) {
                var rectBound = new HighlightTextRect();
                rectBound.left = left;
                rectBound.top = top;
                rectBound.width = Math.max(width, 1);
                rectBound.height = Math.max(height, 1);
                rectBound.right = left + width;
                rectBound.bottom = top + height;
                rectBound.setDomRotateAngle(domRotateAngle, rotateAngle);
				// Use Annotationeer's canvas instead of PDF.JS canvas as parameter.
                rectBound.calculateOrigBound(this.canvas, angle, PDFViewerApplication.pdfViewer.currentScale);

                newAnnotation.highlightTextRects.push(rectBound);

				// We use the page object's width and height property instead of the page.canvas because
				// screen scale affects the canvas width and height property but maintains the values in
				// its style property but is still not accurate. The page's values meanwhile give the
				// correct values.
                newAnnotation.pageWidth = parseInt(PageManager.getPageWidth(page.width, page.height) / scale);
                newAnnotation.pageHeight = parseInt(PageManager.getPageHeight(page.width, page.height) / scale);
                newAnnotation.text = Util.isIOSDevice() ? PageManager.iosSelectedText : PageManager.getSelectedText();
                newAnnotation.modified = Default.SAVE_ALL_ANNOTATIONS_ONE_TIME ? 'insert' : '';
            }
        }
    }

    var annotationToUse = annotation ? annotation : newAnnotation;
    var rects = [];
    for (var h=0; h<annotationToUse.highlightTextRects.length; h++) {
        var rect = annotationToUse.highlightTextRects[h];
        rects.push({
            x: rect.origLeft,
            y: rect.origTop,
            width: rect.origWidth,
            height: rect.origHeight
        });
    }
    var rect = Util.getBoundingBoxOfRects(rects, 0);
    annotationToUse.origX = rect.x;
    annotationToUse.origY = rect.y;
    annotationToUse.origW = rect.width;
    annotationToUse.origH = rect.height;
    annotationToUse.x = rect.x * PDFViewerApplication.pdfViewer._currentScale;
    annotationToUse.y = rect.y * PDFViewerApplication.pdfViewer._currentScale;
    annotationToUse.w = rect.width * PDFViewerApplication.pdfViewer._currentScale;
    annotationToUse.h = rect.height * PDFViewerApplication.pdfViewer._currentScale;

    this.canvasAnnotations.push(annotationToUse);
    this.invalidate();

    return annotation ? annotation : newAnnotation;
};

/**
 * Needed because the ascent and baselint descent is not included when getting height of text based on canvas font.
 * @see {@link http://stackoverflow.com/questions/1134586/how-can-you-find-the-height-of-text-on-an-html-canvas}
 * @function
 * @memberof Page
 * @param {string} font
 * @param {string} text
 * @returns {object}
 */
Page.prototype.getTextHeight = function(font, text) {

    var text = $('<span>' + text + '</span>').css({ fontFamily: font });
    var block = $('<div style="display: inline-block; width: 1px; height: 0;"></div>');

    var div = $('<div></div>');
    div.append(text, block);

    var body = $('body');
    body.append(div);

    try {
        var result = {};

        block.css({ verticalAlign: 'baseline' });
        result.ascent = block.offset().top - text.offset().top;

        block.css({ verticalAlign: 'bottom' });
        result.height = block.offset().top - text.offset().top;

        result.descent = result.height - result.ascent;

    } catch(e) {
        // do nothing
    } finally {
        if (div)
            div.remove();
    }

    return result;
};

/**
 * <p>While the addAnnotation and addText works in the same way, the assigning of coordinate and dimension values
 * are different because text annotation do not have a width and height until after they are inserted inside a
 * DIV element.</p>
 * @function
 * @memberof Page
 * @param {object} annotation The annotation object.
 * @param {decimal} angle The rotation angle.
 * @param {number} scale The scale value.
 * @param {boolean} isAddedAfterLoad If annotation is added after document is loaded.
 * @param {boolean} useOrig Use original dimension or not.
 * @param {boolean} doNotTriggerEvent Trigger an event or not.
 * @param {boolean} editable This indicates the free text annotation is multi-line.
 */
Page.prototype.addText = function(annotation, angle, scale, isAddedAfterLoad, useOrig, doNotTriggerEvent, editable) {
	PageManager.consoleLog('Page.addText()');

    if (!isAddedAfterLoad || (useOrig && annotation.hasDimension)) {
        annotation.x = annotation.origX * scale;
        annotation.y = annotation.origY * scale;
        annotation.w = annotation.origW * scale;
        annotation.h = annotation.origH * scale;
    }

    // Check if exist. If yes, remove then re-create.
    var idToUse = annotation.id != 0 ? annotation.id : '';
    var exist = $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + idToUse);
    if (exist.length > 0) exist.remove();
    var el = document.createElement('div');

    var rgbColor = Util.hexToRgb(annotation.backgroundColor);
    var background = 'rgba(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ', ' + Default.FILL_OPACITY + ')';

    /**
     * Reason why white-space: nowrap is included only for IE is because when user creates a multi-line free text
     * annotation, pressing ESCAPE key will make it a 1 liner instead.
     */
    el.setAttribute('style', 'position: absolute; color: ' + annotation.color + '; outline-color:' + annotation.color + '; ' +
        'background:' + background + '; ' + 'left:' + annotation.x + 'px; top:' + annotation.y + 'px; ' +
        'font:' + (annotation.fontSize * scale) + Default.FONT_SIZE_TYPE + ' ' + Default.FONT_TYPE + ';' +
        (Util.isIE() ? 'white-space: nowrap;' : ''));
    el.setAttribute('id', Default.ANNOTATION_ID_PREFIX_FREE_TEXT + idToUse);
    el.innerHTML = annotation.text;

	PageManager.getPageContainer(annotation.pageIndex + 1).find(editable ? '.freeTextLayer' : '.canvasWrapper').append(el);

    var canvasAnnotations = this.canvasAnnotations;
    var canvas = this.canvas;

    /**
     * This section of code is used when creating a multi-line free text annotation. When page is scaled or
     * rotated, the else block will be executed.
     */
    if (editable) {
        $(el).attr('contenteditable', 'true');
        $(el).css('zIndex', '9999999');

        // setTimeout() is used here or else the div will not be in editing mode.
        setTimeout(function() {
            $(el).trigger('focus');
        }, 10);

        /**
         * Chrome has a different approach with new lines in div contenteditables. Instead of just
         * adding a br tag, it wraps that with a div tag. We replace it with 2 BR tags instead.
         *
         * The behavior for this is that if the caret position is at the end and new characters are
         * typed, one of the BR tag is removed. However, if the line break happens between text
         * characters, we use a custom function getSelectionTextInfo() to detect if caret position
         * is at the end or not. If it is, add 2 BR tags else just 1.
         */
        $(el).keydown(function(e) {
            // Trap the return key being pressed
            if (e.keyCode == 13) {
                if (Default.TYPE_TEXT_1_LINER) {
                    e.stopPropagation();
                }
                else {
                    // IE does not support document.execCommand()
                    if (Util.isIE())
                        return true;

                    // Insert 2 br tags (if only one br tag is inserted the cursor won't go to the next line)
                    var caretState = Util.getSelectionTextInfo(el);
                    document.execCommand('insertHTML', false, '<br/>' + (caretState.atEnd ? '<br/>' : ''));
                }
                return false;
            }

            // Escape key, in case user cancels, call focus out to save annotation.
            if (e.keyCode == 27) {
                $('body').focus();
            }
            else
                e.stopPropagation();
        });

        if (Default.TYPE_TEXT_1_LINER)
            $(el).limitText(Default.ANNOTATION_TYPE_TEXT_CHAR_LIMIT);

        $(el).dblclick(function() {
            if ($(this).is(":focus"))
                $(el).trigger('focusout');
        });

        $(el).focusout(function() {
            $(this).unbind('focusout');
            $(this).unbind('keydown');
            $(this).unbind('dblclick');

            $(el).removeClass('editable');
            $(el).css('zIndex', '');

            // Transfer from div.freeTextLayer to div.canvasWrapper
            $(el).appendTo(PageManager.getPageContainer(annotation.pageIndex + 1).find('.canvasWrapper'));

            // http://stackoverflow.com/questions/14751900/replace-div-tag-with-br-on-keydown-in-chrome-for-html-contenteditable
            // Replace div tags with br.
            if ($(el).text().trim().length == 0)
                $(el).html(Default.TYPE_TEXT_DEFAULT_TEXT_IF_EMPTY);

            annotation.text = $(el).html().replace(/<div>/gi,'<br/>').replace(/<\/div>/gi,'');

            if (angle > 0 && !annotation.hasDimension) {
                var divFreeText = $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + idToUse);
                switch (angle) {
                    case 90:
                        divFreeText.css('transform-origin', '0 0');
                        divFreeText.css('transform', 'rotate(90deg)');
                        break;
                    case 270:
                        divFreeText.css('transform-origin', '0 0');
                        divFreeText.css('transform', 'rotate(-90deg)');
                        break;
                    case 180:
                        divFreeText.css('transform', 'rotate(180deg)');
                        break;
                }
            }

            if (!annotation.hasDimension) {
                annotation.hasDimension = true;

                /**
                 * Check if angle is 90 or 270 degrees, then re-adjust coordinates to always position
                 * as portrait mode
                 */
                var x = annotation.x;
                var y = annotation.y;

                /**
                 * We use el.getBoundingClientRect() instead of $(el) in getting the width and height because
                 * using it via JQuery style will return an int whereas getBoundingClientRect() returns the
                 * correct float value.
                 */
                switch (angle) {
                    case 90:
                        annotation.w = el.getBoundingClientRect().width;
                        annotation.h = el.getBoundingClientRect().height;
                        annotation.x = x - (idToUse == '' ? annotation.w : 0);
                        annotation.y = y;
                        break;
                    case 270:
                        if (idToUse != '') {
                            $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + idToUse).css('top', (annotation.y + annotation.h) + 'px');
                            // Re-position y coordinate using previous text's detail
                            annotation.y = y + annotation.h;
                            // Set height of new text
                            annotation.h = el.getBoundingClientRect().height;
                            // Re-adjust y coordinate using new text's detail
                            annotation.y = annotation.y - annotation.h;
                        }
                        else {
                            annotation.w = el.getBoundingClientRect().width;
                            annotation.h = el.getBoundingClientRect().height;
                            annotation.x = x;
                            annotation.y = y - annotation.h;
                        }
                        break;
                    default:
                        annotation.w = el.getBoundingClientRect().width;
                        annotation.h = el.getBoundingClientRect().height;
                        break;
                }
            }

            if (!useOrig) {
                annotation.origX = annotation.x;
                annotation.origY = annotation.y;
                annotation.origW = annotation.w;
                annotation.origH = annotation.h;
            }

            canvasAnnotations.push(annotation);

            if (isAddedAfterLoad) {
                annotation.calculateOrigBound(canvas, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, true);

                if (Util.isFunction(Annotationeer.saveAnnotation))
                    Annotationeer.saveAnnotation(annotation, null, doNotTriggerEvent);
                else
					PageManager.showAlert(Message.FUNC_UNDEFINED_ANNO_SAVE, 'info');
            }

            PageManager.setFreeTextImageToAnnotation(annotation, 'clone_' + annotation.id);
            resetVar();
        });
    }
    else {
        annotation.text = $(el).html();

        /**
         * This block of code is the same as above but placed inside the focusout() function
         * of the element.
         */
        if (angle > 0 && !annotation.hasDimension) {
            var divFreeText = $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + idToUse);
            switch (angle) {
                case 90:
                    divFreeText.css('transform-origin', '0 0');
                    divFreeText.css('transform', 'rotate(90deg)');
                    break;
                case 270:
                    divFreeText.css('transform-origin', '0 0');
                    divFreeText.css('transform', 'rotate(-90deg)');
                    break;
                case 180:
                    divFreeText.css('transform', 'rotate(180deg)');
                    break;
            }
        }

        if (!annotation.hasDimension) {
            annotation.hasDimension = true;

            /**
             * Check if angle is 90 or 270 degrees, then re-adjust coordinates to always position
             * as portrait mode
             */
            var x = annotation.x;
            var y = annotation.y;

            switch (angle) {
                case 90:
                    annotation.w = el.getBoundingClientRect().width;
                    annotation.h = el.getBoundingClientRect().height;
                    annotation.x = x - (idToUse == '' ? annotation.w : 0);
                    annotation.y = y;
                    break;
                case 270:
                    if (idToUse != '') {
                        $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + idToUse).css('top', (annotation.y + annotation.h) + 'px');
                        // Re-position y coordinate using previous text's detail
                        annotation.y = y + annotation.h;
                        // Set height of new text
                        annotation.h = el.getBoundingClientRect().height;
                        // Re-adjust y coordinate using new text's detail
                        annotation.y = annotation.y - annotation.h;
                    }
                    else {
                        annotation.w = el.getBoundingClientRect().width;
                        annotation.h = el.getBoundingClientRect().height;
                        annotation.x = x;
                        annotation.y = y - annotation.h;
                    }
                    break;
                default:
                    annotation.w = el.getBoundingClientRect().width;
                    annotation.h = el.getBoundingClientRect().height;
                    break;
            }
        }

        if (!useOrig) {
            annotation.origX = annotation.x;
            annotation.origY = annotation.y;
            annotation.origW = annotation.w;
            annotation.origH = annotation.h;
        }

        canvasAnnotations.push(annotation);

        if (isAddedAfterLoad) {
            annotation.calculateOrigBound(canvas, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, true);

            if (Util.isFunction(Annotationeer.saveAnnotation))
                Annotationeer.saveAnnotation(annotation, null, doNotTriggerEvent);
            else
				PageManager.showAlert(Message.FUNC_UNDEFINED_ANNO_SAVE, 'info');
        }

        PageManager.setFreeTextImageToAnnotation(annotation, 'clone_' + annotation.id);
    }
};

/**
 * Executes when a double click happens.
 * @function
 * @memberof Page
 * @param {object} e The event object.
 */
Page.prototype.doubleClick = function(e) {

    if (PageManager.selectedAnnotations.length > 1)
        return;

    if (PageManager.startCreatingAnnotation) {
        /**
         * If user is still creating an annotation that is of poly line type, double clicking it means annotation must
         * be created. Since the mouse action is a double click, 2 extra drawing position entries will be added when
         * this happens, so manually remove the last 2 entries.
         */
        if (PageManager.boxAnnotationGuide && PageManager.boxAnnotationGuide.isPolyLineType()) {
            if (PageManager.boxAnnotationGuide.drawingPositions.length - 2 > 2) {
				PageManager.boxAnnotationGuide.drawingPositions.splice(PageManager.boxAnnotationGuide.drawingPositions.length - 2, 2);

                var boundingBox = Util.getBoundingBoxOfPoints(PageManager.boxAnnotationGuide.drawingPositions);
				PageManager.boxAnnotationGuide.x = boundingBox.x;
				PageManager.boxAnnotationGuide.y = boundingBox.y;
				PageManager.boxAnnotationGuide.w = boundingBox.w;
				PageManager.boxAnnotationGuide.h = boundingBox.h;

                this.canvasAnnotations.splice(this.canvasAnnotations.length - 1, 1);
                this.addAnnotation(PageManager.boxAnnotationGuide, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, false, true);
				this.invalidate();
                resetVar();
            }
            else {
				PageManager.boxAnnotationGuide.drawingPositions.splice(PageManager.boxAnnotationGuide.drawingPositions.length - 1, 1);
            }
        }

        return;
    }

    /**
     * This code is only for TYPE_TEXT annotations because we add an option to allow the
     * user to edit the text if the annotation gets double clicked.
     */
    for (var c=0; c<this.canvasAnnotations.length; c++) {
        if (this.canvasAnnotations[c].isReadOnly() ||
            (!this.canvasAnnotations[c].isSelectableTextType() && !this.canvasAnnotations[c].contains(this.mx, this.my, e)) ||
            (this.canvasAnnotations[c].isSelectableTextType() && !this.canvasAnnotations[c].containsHighlightText(this.mx, this.my, e)))
            continue;

        if (Default.DOUBLE_CLICK_WHAT_EVENT == Default.DOUBLE_CLICK_SHOW_PROPERTIES) {
            if (this.canvasAnnotations[c].annotationType === Annotation.TYPE_TEXT) {
                if (rotateAngle != 0) {
                    if (Message.FREETEXT_ROTATE_MODIFY)
						PageManager.showAlert(Message.FREETEXT_ROTATE_MODIFY, 'info');
                }
                else {
					PageManager.clearSelectedAnnotationArray();
                    this.invalidate();
                    var annotation = this.canvasAnnotations[c];
                    this.canvasAnnotations.splice(c, 1);
                    $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + annotation.id).remove();
                    // Set hasDimension property to false so that after updating, its bounding dimension will be updated.
                    annotation.hasDimension = false;
                    this.addText(annotation, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, true, true, false, true);
                    var caretRange = Util.getMouseEventCaretRange(e);

                    // Set a timer to allow the selection to happen and the dust settle first
                    window.setTimeout(function () {
                        //noinspection JSReferencingMutableVariableFromClosure
                        Util.selectRange(caretRange);
                    }, 10);
                }
            }
            else
				PageManager.openAnnotationPropertiesForm(this.canvasAnnotations[c]);
        }
        else if (Default.DOUBLE_CLICK_WHAT_EVENT == Default.DOUBLE_CLICK_SHOW_COMMENT_POPUP) {
			Annotationeer.editAnnotation(this.canvasAnnotations[c], 'edit');
        }

        break;
    }
};

/**
 * Executes when a mouse down event happens.
 * @function
 * @memberof Page
 * @param {object} e The mouse event object.
 * @param {string} touch If this is a touch device or not.
 */
Page.prototype.mouseDown = function(e, touch) {
    // If hand tool mode, then ignore events in the annotation canvas layer
    if (PageManager.getHandTool().active)
        return;

	PageManager.closeAllDropDown();

    if (touch || e.which == 1)
		PageManager.leftButtonMouseClicked = true;
    else if (e.which == 3)
        return;

    Page.prototype.getMouse(e, this);

    if (touch && (PageManager.startDraw || PageManager.startCreatingAnnotation)) {
        e.preventDefault();
    }

    if (PageManager.startDraw) {
        if (PageManager.leftButtonMouseClicked) {
            this.isDrawing = true;
			PageManager.drawingGuide = [];
            this.ctx.moveTo(this.mx, this.my);
            this.ctx.beginPath();
        }
        return;
    }

    if (PageManager.startCreatingAnnotation && PageManager.leftButtonMouseClicked) {
        if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_TEXT) {
			Annotationeer.showTextInput(this, this.mx, this.my);
            e.preventDefault();
            // We set this variable manually instead of depending on the resetVar() function because
            // it is called when focusout gets triggered which gets executed after mouse down event.
			PageManager.startCreatingAnnotation = false;
            return;
        }

        if (PageManager.startCreatingAnnotation) {
            this.isCreatingAnnotation = true;
        }

		PageManager.boxAnnotationGuide.x = this.mx;
		PageManager.boxAnnotationGuide.y = this.my;
		PageManager.boxAnnotationGuide.pageIndex = this.pageIndex;

        if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_SCREENSHOT) {
            this.screenshotAnnotation = PageManager.boxAnnotationGuide;
            this.screenshotAnnotation.pageIndex = this.pageIndex;
        }
        else  {
            if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_CIRCLE_FILL ||
				PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_CIRCLE_STROKE) {
				PageManager.boxAnnotationGuide.circleStartX = this.mx;
				PageManager.boxAnnotationGuide.circleStartY = this.my;
            }
            else if (PageManager.boxAnnotationGuide.hasTwoEndPoints()) {
                var drawingPosition = new DrawingPosition();
                drawingPosition.x = this.mx;
                drawingPosition.y = this.my;
				PageManager.boxAnnotationGuide.drawingPositions.push(drawingPosition);
            }

            if (PageManager.boxAnnotationGuide.isPolyLineType()) {
                if (this.canvasAnnotations.length == 0 || !this.canvasAnnotations[this.canvasAnnotations.length - 1].dummy)
                    this.canvasAnnotations.push(PageManager.boxAnnotationGuide);
            }
            else
                this.canvasAnnotations.push(PageManager.boxAnnotationGuide);
        }

        return;
    }

    // We are over a selection box
    if (PageManager.expectResize !== -1) {
		PageManager.isResizeDrag = true;
        return;
    }

    if (!this.canvasAnnotations)
        return;

    for (var i=this.canvasAnnotations.length-1; i>= 0; i--) {
        /**
         * Since mouse move is not possible in touch event scenarios, we detect if an annotation is already
         * selected, then check to see if its selection handles fall within the touch coordinates. If so,
         * bypass the next block of code.
         */
        if (touch && this.canvasAnnotations[i].selected) {
			PageManager.expectResize = this.canvasAnnotations[i].getSelectionHandleIndex(this.mx, this.my,
                e.changedTouches[0].radiusX ? e.changedTouches[0].radiusX : 1);

            if (PageManager.expectResize !== -1) {
				PageManager.isResizeDrag = true;
                break;
            }
        }

        /**
         * Removed this since IE is an idiot for not allowing getImageData() and toDataURL()
         * of Canvas be used because of CORS issue. We use the annotation's contains() function
         * instead.
         */
        if (this.isMouseCoordinateInAnnotationArea(this.canvasAnnotations[i], e)) {
            /**
             * If mouse selection did not include a CTRL key event, clear the array
             * to select only one.
             */
            if (e.ctrlKey) {
                if (this.canvasAnnotations[i].selected) {
                    this.canvasAnnotations[i].clicked = false;
					PageManager.removeSelectedAnnotation(this.canvasAnnotations[i], true);
                }
                else {
                    PageManager.addSelectedAnnotation(this.canvasAnnotations[i]);
                }
            }
            else {
                if (PageManager.selectedAnnotations.length > 0) {
					PageManager.clearSelectedAnnotationArray(true, false, true);
                }

                this.canvasAnnotations[i].clicked = true;
                PageManager.addSelectedAnnotation(this.canvasAnnotations[i]);
            }

			PageManager.leftButtonMouseClickedAnnotation = this.canvasAnnotations[i];

			PageManager.consoleLog('Total selected annotations: ' + PageManager.selectedAnnotations.length);

            // Do not set offsetX and offsetY as var because its range of availability will not expand
            // through other mouse events like mouseMove and mouseDown
            offsetX = this.mx - this.canvasAnnotations[i].x;
            offsetY = this.my - this.canvasAnnotations[i].y;
            this.canvasAnnotations[i].x = this.mx - offsetX;
            this.canvasAnnotations[i].y = this.my - offsetY;
            this.invalidate();
            return;
        }
    }

    /**
     * If this is a touch event and a selection handler had been set, then do not deselect the annotation
     * so that it will be able to resize.
     */
    if (touch && PageManager.expectResize > -1)
        return;

    // If no annotations selected, reset selected attribute and re-draw canvas
    if (PageManager.selectedAnnotations.length > 0) {
        PageManager.clearSelectedAnnotationArray(true);
    }
};

/**
 * Executes when a mouse move event happens.
 * @function
 * @memberof Page
 * @param {object} e The mouse event object.
 * @param {string} touch If this is a touch device or not.
 */
Page.prototype.mouseMove = function(e, touch) {
    // If hand tool mode, then ignore events in the annotation canvas layer
    if (PageManager.getHandTool().active)
        return;

    if (!touch) {
        if (PageManager.startCreatingAnnotation || this.isCreatingAnnotation) {
            if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_STICKY_NOTE)
                PageManager.setCursor(this.canvas, 'comment', 'crosshair');
            else if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_STAMP)
                PageManager.setCursor(this.canvas, 'stamp', 'crosshair');
            else if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_AUDIO)
                PageManager.setCursor(this.canvas, 'audio', 'crosshair');
            else if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_TEXT)
                this.canvas.style.cursor = 'text';
            else if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_DIGITAL_SIGNATURE)
                PageManager.setCursor(this.canvas, 'digital_signature', 'crosshair');
            else if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_FORM_TEXT_FIELD)
                PageManager.setCursor(this.canvas, 'text_field', 'crosshair');
            else if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_FORM_CHECKBOX)
                PageManager.setCursor(this.canvas, 'checkbox', 'crosshair');
            else if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_FORM_RADIO_BUTTON)
                PageManager.setCursor(this.canvas, 'radio_button', 'crosshair');
            else
                this.canvas.style.cursor = 'crosshair';
        }
        else if (PageManager.startDraw || this.isDrawing) {
            this.canvas.style.cursor = 'default';
        }
    }

    if ($('#togglePageColorPicker').hasClass('toggled')) {
        this.canvas.style.cursor = 'crosshair';
        var rgb = PageManager.getPageColor(this.pageIndex, this.mx, this.my);
        var rgb_arr = rgb.split(/,| /);
        $('#page_color_bg').css('background', Util.rgbToHex(rgb_arr[0], rgb_arr[1], rgb_arr[2]));
    }

    Page.prototype.getMouse(e, this);

    if (this.isDrawing) {
        var drawingPosition = new DrawingPosition();
        drawingPosition.x = this.mx;
        drawingPosition.y = this.my;
		PageManager.drawingGuide.push(drawingPosition);

        this.ctx.lineWidth = PageManager.boxAnnotationGuide.lineWidth * PDFViewerApplication.pdfViewer.currentScale;
        this.ctx.strokeStyle = PageManager.boxAnnotationGuide.color;
        this.ctx.lineTo(this.mx, this.my);
        this.ctx.stroke();

        return;
    }
    else if (this.isCreatingAnnotation) {
        if (PageManager.boxAnnotationGuide.usesImage())
            return;

		PageManager.boxAnnotationGuide.w = this.mx - PageManager.boxAnnotationGuide.x;
		PageManager.boxAnnotationGuide.h = this.my - PageManager.boxAnnotationGuide.y;

        if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_CIRCLE_FILL ||
			PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_CIRCLE_STROKE) {
			PageManager.boxAnnotationGuide.circleLastX = this.mx;
			PageManager.boxAnnotationGuide.circleLastY = this.my;
        }
        /**
         * While the arrow annotation will not have any use for the x, y, w, h dimension,
         * we will just leave the code for assigning values to them as is.
         */
        else if (this.pageIndex == PageManager.boxAnnotationGuide.pageIndex && PageManager.boxAnnotationGuide.drawingPositions.length > 0) {
            var drawingPosition = new DrawingPosition();
            drawingPosition.x = this.mx;
            drawingPosition.y = this.my;

            if (PageManager.boxAnnotationGuide.drawingPositions.length > 1)
				PageManager.boxAnnotationGuide.drawingPositions.splice(PageManager.boxAnnotationGuide.drawingPositions.length - 1, 1);

			PageManager.boxAnnotationGuide.drawingPositions.push(drawingPosition);

            /**
             * If measurement annotation, update original coordinates at 100% so that
             * the label value for the measurement will be correct and fixed.
             */
            if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_MEASUREMENT_DISTANCE)
                for (var i=0; i<PageManager.boxAnnotationGuide.drawingPositions.length; i++) {
					PageManager.boxAnnotationGuide.drawingPositions[i].calculateOrigPosition(this.canvas, rotateAngle,
                        PDFViewerApplication.pdfViewer.currentScale, true);
                }
        }

        this.invalidate();
        return;
    }

    // Allow only left mouse click to drag and only 1 selected annotation can be resize and/or moved.
    if (PageManager.selectedAnnotations.length == 1 && PageManager.selectedAnnotations[0].pageIndex == this.pageIndex)
    {
        if (PageManager.selectedAnnotations[0].isMovable() && PageManager.selectedAnnotations[0].selected &&
            (PageManager.selectedAnnotations[0].clicked || PageManager.selectedAnnotations[0].moving) &&
			PageManager.leftButtonMouseClicked && !PageManager.isResizeDrag)
        {
            if (touch)
                e.preventDefault();

            if (PageManager.selectedAnnotations[0].clicked) {
				PageManager.selectedAnnotations[0].clicked = false;
				PageManager.selectedAnnotations[0].moving = true;
            }

			PageManager.selectedAnnotations[0].x = this.mx - offsetX;
			PageManager.selectedAnnotations[0].y = this.my - offsetY;

            if (PageManager.selectedAnnotations[0].annotationType === Annotation.TYPE_TEXT) {
                var ht = $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + PageManager.selectedAnnotations[0].id);
                ht.css('left', PageManager.selectedAnnotations[0].x + (rotateAngle == 90 ? PageManager.selectedAnnotations[0].w : 0));
                ht.css('top', PageManager.selectedAnnotations[0].y + (rotateAngle == 270 ? PageManager.selectedAnnotations[0].h : 0));
            }
            else if (PageManager.selectedAnnotations[0].drawingPositions.length > 0) {
                // Formula taken from
                // http://stackoverflow.com/questions/32450669/how-to-drag-connected-lines-using-html5-canvas
                for (var d=0; d<PageManager.selectedAnnotations[0].drawingPositions.length; d++) {
                    if (PageManager.selectedAnnotations[0].drawingPositions[d].lastX <= 0)
						PageManager.selectedAnnotations[0].drawingPositions[d].lastX = this.mx;
                    if (PageManager.selectedAnnotations[0].drawingPositions[d].lastY <= 0)
						PageManager.selectedAnnotations[0].drawingPositions[d].lastY = this.my;

					PageManager.selectedAnnotations[0].drawingPositions[d].x += this.mx - PageManager.selectedAnnotations[0].drawingPositions[d].lastX;
					PageManager.selectedAnnotations[0].drawingPositions[d].y += this.my - PageManager.selectedAnnotations[0].drawingPositions[d].lastY;

					PageManager.selectedAnnotations[0].drawingPositions[d].lastX = this.mx;
					PageManager.selectedAnnotations[0].drawingPositions[d].lastY = this.my;
                }

                var boundingBox = Util.getBoundingBoxOfPoints(PageManager.selectedAnnotations[0].drawingPositions);
                PageManager.selectedAnnotations[0].x = boundingBox.x;
                PageManager.selectedAnnotations[0].y = boundingBox.y;
                PageManager.selectedAnnotations[0].w = boundingBox.w;
                PageManager.selectedAnnotations[0].h = boundingBox.h;
            }

            this.invalidate();
        }
        else if (PageManager.isResizeDrag) {
            if (touch)
                e.preventDefault();

            if (!PageManager.selectedAnnotations[0].isResizable())
                return;

            if (PageManager.selectedAnnotations[0].drawingPositions.length > 0) {
				PageManager.selectedAnnotations[0].drawingPositions[PageManager.expectResize].x = this.mx;
				PageManager.selectedAnnotations[0].drawingPositions[PageManager.expectResize].y = this.my;

                if (PageManager.selectedAnnotations[0].annotationType === Annotation.TYPE_MEASUREMENT_DISTANCE)
					PageManager.selectedAnnotations[0].drawingPositions[PageManager.expectResize].calculateOrigPosition(this.canvas,
                        rotateAngle, PDFViewerApplication.pdfViewer.currentScale, true);
            }
            else {
                // Time To resize!
                var oldX = PageManager.selectedAnnotations[0].x;
                var oldY = PageManager.selectedAnnotations[0].y;
                // 0  1  2
                // 3     4
                // 5  6  7
                switch (PageManager.expectResize) {
                    case 0:
						PageManager.selectedAnnotations[0].x = this.mx;
						PageManager.selectedAnnotations[0].y = this.my;
						PageManager.selectedAnnotations[0].w += oldX - this.mx;
						PageManager.selectedAnnotations[0].h += oldY - this.my;
                        break;
                    case 1:
						PageManager.selectedAnnotations[0].y = this.my;
						PageManager.selectedAnnotations[0].h += oldY - this.my;
                        break;
                    case 2:
						PageManager.selectedAnnotations[0].y = this.my;
						PageManager.selectedAnnotations[0].w = this.mx - oldX;
						PageManager.selectedAnnotations[0].h += oldY - this.my;
                        break;
                    case 3:
						PageManager.selectedAnnotations[0].x = this.mx;
						PageManager.selectedAnnotations[0].w += oldX - this.mx;
                        break;
                    case 4:
						PageManager.selectedAnnotations[0].w = this.mx - oldX;
                        break;
                    case 5:
						PageManager.selectedAnnotations[0].x = this.mx;
						PageManager.selectedAnnotations[0].w += oldX - this.mx;
						PageManager.selectedAnnotations[0].h = this.my - oldY;
                        break;
                    case 6:
						PageManager.selectedAnnotations[0].h = this.my - oldY;
                        break;
                    case 7:
						PageManager.selectedAnnotations[0].w = this.mx - oldX;
						PageManager.selectedAnnotations[0].h = this.my - oldY;
                        break;
                }
            }

            this.invalidate();
        }

        /**
          * If annotation type is circle, set the circleLastX and circleLastY as the moving coordinates
          * because the x and y variables serve as the starting point to how the circle was created.
          */
        if (PageManager.selectedAnnotations[0].annotationType === Annotation.TYPE_CIRCLE_FILL ||
			PageManager.selectedAnnotations[0].annotationType === Annotation.TYPE_CIRCLE_STROKE)
		{
			PageManager.selectedAnnotations[0].circleStartX = PageManager.selectedAnnotations[0].x;
			PageManager.selectedAnnotations[0].circleStartY = PageManager.selectedAnnotations[0].y;
			PageManager.selectedAnnotations[0].circleLastX = PageManager.selectedAnnotations[0].x + PageManager.selectedAnnotations[0].w;
			PageManager.selectedAnnotations[0].circleLastY = PageManager.selectedAnnotations[0].y + PageManager.selectedAnnotations[0].h;
        }
        else if (PageManager.selectedAnnotations[0].isFormField()) {
            var ff = $('#' + Default.ANNOTATION_ID_PREFIX_FORM_FIELD + PageManager.selectedAnnotations[0].id);
            ff.css('left', PageManager.selectedAnnotations[0].x + (rotateAngle == 90 ? Math.abs(PageManager.selectedAnnotations[0].w) : 0));
            ff.css('top', PageManager.selectedAnnotations[0].y + (rotateAngle == 270 ? Math.abs(PageManager.selectedAnnotations[0].h) : 0));
            ff.css('width', Math.abs(rotateAngle != 0 && rotateAngle != 180 ? PageManager.selectedAnnotations[0].h : PageManager.selectedAnnotations[0].w));
            ff.css('height', Math.abs(rotateAngle != 0 && rotateAngle != 180 ? PageManager.selectedAnnotations[0].w : PageManager.selectedAnnotations[0].h));

            // If width or height are negative values, re-adjust coordinate position.
            if (PageManager.selectedAnnotations[0].w < 0) {
                ff.css('left', parseFloat(ff.css('left')) + PageManager.selectedAnnotations[0].w);
            }

            if (PageManager.selectedAnnotations[0].h < 0) {
                ff.css('top', parseFloat(ff.css('top')) + PageManager.selectedAnnotations[0].h);
            }
        }
    }

    if (Default.ANNOTATION_SELECTABLE_TEXT_SHOW_ON_HOVER && !PageManager.leftButtonMouseClicked)
        for (var i=0; i<this.canvasAnnotations.length; i++) {
            if (this.canvasAnnotations[i].isReadOnly())
                continue;

            this.canvasAnnotations[i].selectable = this.isMouseCoordinateInAnnotationArea(this.canvasAnnotations[i], e);
            this.invalidate();
        }

    // if there's a selection see if we grabbed one of the selection handles
    if (PageManager.selectedAnnotations.length == 1 && PageManager.selectedAnnotations[0] !== null && !PageManager.isResizeDrag) {
        for (var i=0; i<PageManager.selectedAnnotations[0].selectionHandles.length; i++) {
            // 0  1  2
            // 3     4
            // 5  6  7
            var cur = PageManager.selectedAnnotations[0].selectionHandles[i];

            // We do not need to use the ghost context because selection handles will always be rectangles
            if (this.mx >= cur.x && this.mx <= cur.x + (Default.ANNOTATION_SELECTION_BOX_SIZE * PDFViewerApplication.pdfViewer.currentScale) &&
                this.my >= cur.y && this.my <= cur.y + (Default.ANNOTATION_SELECTION_BOX_SIZE * PDFViewerApplication.pdfViewer.currentScale)) {
                // We found one!
				PageManager.expectResize = i;

                if (PageManager.selectedAnnotations[0].drawingPositions.length > 0) {
                    this.canvas.style.cursor = 'alias';
                }
                else {
                    switch (i) {
                        case 0:
                            this.canvas.style.cursor = PageManager.selectedAnnotations[0].w < 0 && PageManager.selectedAnnotations[0].h < 0 ? 'se-resize' : PageManager.selectedAnnotations[0].w < 0 || PageManager.selectedAnnotations[0].h < 0 ? 'sw-resize' : 'nw-resize';
                            break;
                        case 1:
                            this.canvas.style.cursor = PageManager.selectedAnnotations[0].w < 0 || PageManager.selectedAnnotations[0].h < 0 ? 's-resize' : 'n-resize';
                            break;
                        case 2:
                            this.canvas.style.cursor = PageManager.selectedAnnotations[0].w < 0 && PageManager.selectedAnnotations[0].h < 0 ? 'sw-resize' : PageManager.selectedAnnotations[0].w < 0 || PageManager.selectedAnnotations[0].h < 0 ? 'se-resize' : 'ne-resize';
                            break;
                        case 3:
                            this.canvas.style.cursor = PageManager.selectedAnnotations[0].w < 0 || PageManager.selectedAnnotations[0].h < 0 ? 'e-resize' : 'w-resize';
                            break;
                        case 4:
                            this.canvas.style.cursor = PageManager.selectedAnnotations[0].w < 0 || PageManager.selectedAnnotations[0].h < 0 ? 'w-resize' : 'e-resize';
                            break;
                        case 5:
                            this.canvas.style.cursor = PageManager.selectedAnnotations[0].w < 0 && PageManager.selectedAnnotations[0].h < 0 ? 'ne-resize' : PageManager.selectedAnnotations[0].w < 0 || PageManager.selectedAnnotations[0].h < 0 ? 'nw-resize' : 'sw-resize';
                            break;
                        case 6:
                            this.canvas.style.cursor = PageManager.selectedAnnotations[0].w < 0 || PageManager.selectedAnnotations[0].h < 0 ? 'n-resize' : 's-resize';
                            break;
                        case 7:
                            this.canvas.style.cursor = PageManager.selectedAnnotations[0].w < 0 && PageManager.selectedAnnotations[0].h < 0 ? 'nw-resize' : PageManager.selectedAnnotations[0].w < 0 || PageManager.selectedAnnotations[0].h < 0 ? 'ne-resize' : 'se-resize';
                            break;
                    }
                }
                return;
            }

        }
        // not over a selection box, return to normal
		PageManager.isResizeDrag = false;
		PageManager.expectResize = -1;
        this.canvas.style.cursor = 'default';
    }
};

/**
 * Executes when a mouse up event happens.
 * @function
 * @memberof Page
 * @param {object} e The mouse event object.
 */
Page.prototype.mouseUp = function(e) {
    // If hand tool mode, then ignore events in the annotation canvas layer
    if (PageManager.getHandTool().active)
        return;

	PageManager.leftButtonMouseClicked = false;
	PageManager.leftButtonMouseClickedAnnotation = null;

    Page.prototype.getMouse(e, this);

    if ($('#togglePageColorPicker').hasClass('toggled')) {
		PageManager.convertColor(PageManager.getPageColor(this.pageIndex, this.mx, this.my));
        resetVar();
        return;
    }

    if (e.which == 3) {
        if (PageManager.startDraw)
            return;

        if (PageManager.startCreatingAnnotation) {
            if (PageManager.boxAnnotationGuide && PageManager.boxAnnotationGuide.isPolyLineType()) {
                this.showPolyLineCreateMenu(e.clientX, e.clientY, this.mx, this.my);
            }

            return;
        }

        /**
         * The logic here is that if a user selects an annotation, PageManager.selectedAnnotations variable will have entries.
         * However, if user right clicks on an annotation right away, PageManager.selectedAnnotations is empty, hence we pass
         * the this.canvasAnnotations and loop through each annotation if the mouse cursor falls under an
         * annotation's bound area.
         */
        var annotations = PageManager.selectedAnnotations.length > 0 ? PageManager.selectedAnnotations : this.canvasAnnotations;
        for (var i=annotations.length-1; i>= 0; i--) {
            var process = false;
            if (annotations[i].isSelectableTextType() && annotations[i].containsHighlightText(this.mx, this.my)) {
                process = true;
            }
            else if (annotations[i].drawingPositions.length > 0 &&
               annotations[i].containsDrawing(this, this.mx, this.my))
            {
               process = true;
            }
            else if (annotations[i].contains(this.mx, this.my)) {
                process = true;
            }

            if (process) {
                if (PageManager.selectedAnnotations.length > 0) {
                    annotations[i].moving = false;
                }
                else {
					PageManager.addSelectedAnnotation(annotations[i]);
                    this.invalidate();
                }

                if (PageManager.selectedAnnotations.length > 0) {
                    if (Util.isFunction(Annotationeer.displayAnnotationMenu)) {
                        e.stopPropagation();
						Annotationeer.displayAnnotationMenu(PageManager.selectedAnnotations, e.clientX, e.clientY);
                    }
                    else
						PageManager.showAlert(Message.FUNC_UNDEFINED_ANNO_DISPLAY, 'info');
                }

                break;
            }
        }

        return;
    }

    /**
     * Loop through all pages because user's mouseUp event may end up on the next or previous page. If this
     * happens, consider the drawing as finished.
     */
    for (var p in pages) {
        if (!pages.hasOwnProperty(p))
            continue;

        if (pages[p].isDrawing) {
            pages[p].isDrawing = false;

            // We at least set a minimum of 10 points to allow an annotation to be called a drawing
            if (PageManager.drawingGuide.length < Default.DRAW_POINT_MINIMUM) {
				PageManager.drawingGuide = [];
                pages[p].invalidate();

                if (Message.DRAWING_CREATE_REQUIREMENT)
					PageManager.showAlert(Message.DRAWING_CREATE_REQUIREMENT, 'info');

                return;
            }

            var annotation = new Annotation();
            annotation.annotationType = Annotation.TYPE_DRAWING;
            annotation.pageIndex = pages[p].pageIndex;
            annotation.pageWidth = parseInt(PageManager.getPageWidth(pages[p].canvas.width, pages[p].canvas.height) / PDFViewerApplication.pdfViewer.currentScale);
            annotation.pageHeight = parseInt(PageManager.getPageHeight(pages[p].canvas.width, pages[p].canvas.height) / PDFViewerApplication.pdfViewer.currentScale);

            for (var i=0; i<PageManager.drawingGuide.length; i++) {
                var drawingPosition = PageManager.drawingGuide[i];
                annotation.drawingPositions.push(drawingPosition);
            }

            var boundingBox = Util.getBoundingBoxOfPoints(annotation.drawingPositions);
            annotation.x = boundingBox.x;
            annotation.y = boundingBox.y;
            annotation.w = boundingBox.w;
            annotation.h = boundingBox.h;

            pages[p].addAnnotation(annotation, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, false, true);

			PageManager.drawingGuide = [];

            if (Default.ANNOTATION_BUTTON_TOGGLED || !annotation.isNonToggable) {
                // We call invalidate here because if this does not get called, the resetVar() below
                // will call invalidate within its function due to its 3rd parameter.
                pages[p].invalidate();
                return;
            }

            // Call function with no parameters since the purpose is to reset the button states and page's var.
            resetVar(false, false, pages[p]);
        }
        else if (pages[p].isCreatingAnnotation) {
            if (PageManager.boxAnnotationGuide.annotationType === Annotation.TYPE_SCREENSHOT) {
                PageManager.screenShot(pages[p].screenshotAnnotation);
                pages[p].screenshotAnnotation = null;
            }
            else {
                if (PageManager.boxAnnotationGuide.isPolyLineType()) {
                    if (PageManager.boxAnnotationGuide.annotationType != Annotation.TYPE_POLY_LINE &&
						PageManager.boxAnnotationGuide.drawingPositions.length > 2 &&
                        Math.abs(this.mx - PageManager.boxAnnotationGuide.drawingPositions[0].x) < Default.END_CLICK_RADIUS &&
                        Math.abs(this.my -PageManager.boxAnnotationGuide.drawingPositions[0].y) < Default.END_CLICK_RADIUS)
                    {
                        // Polygon is now closed
                        pages[p].isCreatingAnnotation = false;
						PageManager.boxAnnotationGuide.drawingPositions.splice(PageManager.boxAnnotationGuide.drawingPositions.length - 1, 1);

                        var boundingBox = Util.getBoundingBoxOfPoints(PageManager.boxAnnotationGuide.drawingPositions);
						PageManager.boxAnnotationGuide.x = boundingBox.x;
						PageManager.boxAnnotationGuide.y = boundingBox.y;
						PageManager.boxAnnotationGuide.w = boundingBox.w;
						PageManager.boxAnnotationGuide.h = boundingBox.h;
                    }
                    else {
                        var drawingPosition = new DrawingPosition();
                        drawingPosition.x = this.mx;
                        drawingPosition.y = this.my;

                        if (PageManager.boxAnnotationGuide.drawingPositions.length == 0)
							PageManager.boxAnnotationGuide.drawingPositions.push(drawingPosition);
                        else
							PageManager.boxAnnotationGuide.drawingPositions[PageManager.boxAnnotationGuide.drawingPositions.length - 1] = drawingPosition;
                    }

                    if (pages[p].pageIndex == PageManager.boxAnnotationGuide.pageIndex) {
                        if (pages[p].isCreatingAnnotation) {
                            /**
                             * Originally we set the new instantiated object inside the push() call but
                             * this time we have to set its coordinate in case this is created in a
                             * mobile device where no mouse move event occurs.
                             * @type {DrawingPosition}
                             */
                            var dp = new DrawingPosition();
                            dp.x = this.mx;
                            dp.y = this.my;

							PageManager.boxAnnotationGuide.drawingPositions.push(dp);

                            if (Util.isMobile() && PageManager.boxAnnotationGuide.drawingPositions.length > 3)
                                $('#markText').removeClass('hidden');

                            return;
                        }
                    }
                    else {
						PageManager.boxAnnotationGuide.drawingPositions = [];
                        this.invalidate();

                        if (Message.POLY_LINE_CREATE_WRONG_PAGE)
							PageManager.showAlert(Message.POLY_LINE_CREATE_WRONG_PAGE, 'info');

                        return;
                    }
                }
                else if (PageManager.boxAnnotationGuide.drawingPositions.length > 0) {
					PageManager.boxAnnotationGuide.pageWidth = parseInt(PageManager.getPageWidth(pages[p].canvas.width, pages[p].canvas.height) / PDFViewerApplication.pdfViewer.currentScale);
					PageManager.boxAnnotationGuide.pageHeight = parseInt(PageManager.getPageHeight(pages[p].canvas.width, pages[p].canvas.height) / PDFViewerApplication.pdfViewer.currentScale);

                    var boundingBox = Util.getBoundingBoxOfPoints(PageManager.boxAnnotationGuide.drawingPositions);
					PageManager.boxAnnotationGuide.x = boundingBox.x;
					PageManager.boxAnnotationGuide.y = boundingBox.y;
					PageManager.boxAnnotationGuide.w = boundingBox.w;
					PageManager.boxAnnotationGuide.h = boundingBox.h;
                }
                else if (PageManager.boxAnnotationGuide.annotationType != Annotation.TYPE_HIGHLIGHT &&
					PageManager.boxAnnotationGuide.annotationType != Annotation.TYPE_BOX &&
					PageManager.boxAnnotationGuide.annotationType != Annotation.TYPE_CIRCLE_FILL &&
					PageManager.boxAnnotationGuide.annotationType != Annotation.TYPE_CIRCLE_STROKE) {
					PageManager.boxAnnotationGuide.x = pages[p].mx - Default.CURSOR_CROSSHAIR_PIXEL_SIZE;
					PageManager.boxAnnotationGuide.y = pages[p].my - Default.CURSOR_CROSSHAIR_PIXEL_SIZE;

                    if (PageManager.boxAnnotationGuide.usesImage()) {
						PageManager.boxAnnotationGuide.w = PageManager.boxAnnotationGuide.icon.width;
						PageManager.boxAnnotationGuide.h = PageManager.boxAnnotationGuide.icon.height;
                    }

					PageManager.boxAnnotationGuide.w = PageManager.boxAnnotationGuide.w * PDFViewerApplication.pdfViewer.currentScale;
					PageManager.boxAnnotationGuide.h = PageManager.boxAnnotationGuide.h * PDFViewerApplication.pdfViewer.currentScale;
                }

                for (var i=0; i<pages[p].canvasAnnotations.length; i++) {
                    if (pages[p].canvasAnnotations[i].id == 0) {
                        pages[p].canvasAnnotations.splice(i, 1);
                        break;
                    }
                }

                if (PageManager.boxAnnotationGuide.isFormField()) {
                    pages[p].addFormField(PageManager.boxAnnotationGuide, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, false, true);
                }
                else {
                    pages[p].addAnnotation(PageManager.boxAnnotationGuide, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, false, true);
                }
            }

            /**
             * This is more like a hack to make it work quicker without adding more code. If Default.ANNOTATION_BUTTON_TOGGLED is
             * true and if annotation type is either arrow, measurement distance or area, resetVar() will be called but programmatically
             * click the annotation button involved to make it toggle again and continue creating new annotations.
             */
            var recentlyToggledButton = null;

            if (!PageManager.boxAnnotationGuide.isNonToggable()) {
                var annotationButtons = $('.annotation');
                for (var ab=0; ab<annotationButtons.length; ab++) {
                    if ($(annotationButtons[ab]).hasClass('toggled'))
                        recentlyToggledButton = $(annotationButtons[ab]);
                }
            }

            resetVar();

            pages[p].invalidate();


            if (Default.ANNOTATION_BUTTON_TOGGLED && !PageManager.boxAnnotationGuide.isNonToggable() && recentlyToggledButton) {
                recentlyToggledButton.click();
            }

            return;
        }

        if (PageManager.selectedAnnotations.length == 1 && PageManager.selectedAnnotations[0].pageIndex == pages[p].pageIndex &&
            (PageManager.selectedAnnotations[0].moving || PageManager.isResizeDrag))
        {
			PageManager.selectedAnnotations[0].dateModified = new Date();

            if (PageManager.selectedAnnotations[0].drawingPositions.length > 0) {
                // Check first if length is beyond minimum, else set minimum length, for arrow and distance measurement.
                if (PageManager.selectedAnnotations[0].drawingPositions.length == 2 &&
                    ((PageManager.selectedAnnotations[0].annotationType === Annotation.TYPE_MEASUREMENT_DISTANCE && Default.ANNOTATION_MEASUREMENT_DISTANCE_MINIMUM_LENGTH) ||
                    (PageManager.selectedAnnotations[0].annotationType === Annotation.TYPE_ARROW || PageManager.selectedAnnotations[0].annotationType === Annotation.TYPE_LINE)))
                {
                    var distance = Util.getDistance(PageManager.selectedAnnotations[0].drawingPositions[0].x,
						PageManager.selectedAnnotations[0].drawingPositions[0].y,
						PageManager.selectedAnnotations[0].drawingPositions[1].x,
						PageManager.selectedAnnotations[0].drawingPositions[1].y);
                    var scale = PDFViewerApplication.pdfViewer.currentScale;
                    if (distance < (Default.ARROW_SIZE * scale) * 2 * (PageManager.selectedAnnotations[0].annotationType === Annotation.TYPE_MEASUREMENT_DISTANCE ? 2 : 1)) {
                        var angle = Util.getAngle(PageManager.selectedAnnotations[0].drawingPositions[0].x, PageManager.selectedAnnotations[0].drawingPositions[0].y,
							PageManager.selectedAnnotations[0].drawingPositions[1].x, PageManager.selectedAnnotations[0].drawingPositions[1].y, false);
                        var point = Util.getPointFromDistance(PageManager.selectedAnnotations[0].drawingPositions[0].x, PageManager.selectedAnnotations[0].drawingPositions[0].y,
                            angle, (Default.ARROW_SIZE * scale) * 2 * (PageManager.selectedAnnotations[0].annotationType === Annotation.TYPE_MEASUREMENT_DISTANCE ? 2 : 1) + (1 * scale));

						PageManager.selectedAnnotations[0].drawingPositions[1].x = point.x;
						PageManager.selectedAnnotations[0].drawingPositions[1].y = point.y;
                    }
                }

                for (var i=0; i<PageManager.selectedAnnotations[0].drawingPositions.length; i++) {
                    var drawingPosition = PageManager.selectedAnnotations[0].drawingPositions[i];
                    drawingPosition.origX = drawingPosition.x;
                    drawingPosition.origY = drawingPosition.y;
                    drawingPosition.calculateOrigPosition(pages[p].canvas, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, true);
                }

                var boundingBox = Util.getBoundingBoxOfPoints(PageManager.selectedAnnotations[0].drawingPositions);
				PageManager.selectedAnnotations[0].x = boundingBox.x;
				PageManager.selectedAnnotations[0].y = boundingBox.y;
				PageManager.selectedAnnotations[0].w = boundingBox.w;
				PageManager.selectedAnnotations[0].h = boundingBox.h;
            }

			PageManager.selectedAnnotations[0].calculateOrigBound(pages[p].canvas, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, true);

            if (PageManager.selectedAnnotations[0].moving || PageManager.isResizeDrag) {
				PageManager.selectedAnnotations[0].moving = false;
				PageManager.selectedAnnotations[0].modified = 'update';

                // We call invalidate because if the user moves the annotation and the mouseUp ends up on the next or
                // previous page, the annotation's position must be refreshed with the newly adjusted position
                pages[p].invalidate();

                if (Util.isFunction(Annotationeer.saveAnnotation))
                    Annotationeer.saveAnnotation(PageManager.selectedAnnotations[0]);
                else
					PageManager.showAlert(Message.FUNC_UNDEFINED_ANNO_SAVE, 'info');
            }
        }
    }

	PageManager.isResizeDrag = false;
	PageManager.expectResize = -1;
};

/**
 * Add a form field.
 * @function
 * @memberof Page
 * @param {object} annotation The annotation object.
 * @param {decimal} angle The rotation angle.
 * @param {number} scale The scale value.
 * @param {boolean} isAddedAfterLoad If annotation is added after document is loaded.
 * @param {boolean} useOrig Use original dimension or not.
 * @param {boolean} doNotTriggerEvent Trigger an event or not.
 */
Page.prototype.addFormField = function(annotation, angle, scale, useOrig, isAddedAfterLoad, doNotTriggerEvent) {
	PageManager.consoleLog('Page.addFormField()');

    var formField = document.createElement('input');
    formField.setAttribute('id', Default.ANNOTATION_ID_PREFIX_FORM_FIELD + (annotation.id != 0 ? annotation.id : ''));
    formField.setAttribute('disabled', 'disabled');
    formField.setAttribute('name', annotation.formFieldName ? annotation.formFieldName : '');

    if (!isAddedAfterLoad || (useOrig && annotation.hasDimension)) {
        annotation.x = annotation.origX * scale;
        annotation.y = annotation.origY * scale;
        annotation.w = annotation.origW * scale;
        annotation.h = annotation.origH * scale;
    }

    if (annotation.annotationType === Annotation.TYPE_FORM_TEXT_FIELD) {
        // Only working solution as autocomplete=off does not work in Chrome
        formField.setAttribute('onfocus', 'this.removeAttribute("readonly")');
        formField.setAttribute('type', 'text');
        formField.setAttribute('value', annotation.formFieldValue);
        formField.style.borderStyle = 'solid';
        formField.style.borderWidth = '1px';
        formField.style.font = (annotation.fontSize * scale) + Default.FONT_SIZE_TYPE + ' ' + Default.FONT_TYPE;
    }
    else if (annotation.annotationType === Annotation.TYPE_FORM_CHECKBOX)
        formField.setAttribute('type', 'checkbox');
    else if (annotation.annotationType === Annotation.TYPE_FORM_RADIO_BUTTON)
        formField.setAttribute('type', 'radio');

    if (!annotation.hasDimension) {
        annotation.w = annotation.annotationType === Annotation.TYPE_FORM_TEXT_FIELD ?
            (angle != 0 && angle != 180 ? Default.FORM_FIELD_TEXTFIELD_SIZE_HEIGHT : Default.FORM_FIELD_TEXTFIELD_SIZE_WIDTH) * scale :
            Default.FORM_FIELD_SIZE_MINIMUM * scale;
        annotation.h = annotation.annotationType === Annotation.TYPE_FORM_TEXT_FIELD ?
            (angle !=0 && angle != 180 ? Default.FORM_FIELD_TEXTFIELD_SIZE_WIDTH : Default.FORM_FIELD_TEXTFIELD_SIZE_HEIGHT) * scale :
            Default.FORM_FIELD_SIZE_MINIMUM * scale;
        annotation.hasDimension = true;

        if (angle == 90) {
            formField.style.transformOrigin = '0 0';
            formField.style.transform = 'rotate(90deg)';
        }
        else if (angle == 270) {
            formField.style.transformOrigin = '0 0';
            formField.style.transform = 'rotate(-90deg)';
        }
        else if (angle == 180) {
            formField.style.transform = 'rotate(180deg)';
        }
    }

    // If using native Javascript, the px string must be appended.
    formField.style.position = 'absolute';
    formField.style.left = (annotation.x + (angle == 90 ? Math.abs(annotation.w) : 0)) + 'px';
    formField.style.top = (annotation.y + (angle == 270 ? Math.abs(annotation.h) : 0))+ 'px';
    formField.style.width = Math.abs(annotation.w) + 'px';
    formField.style.height = Math.abs(annotation.h) + 'px';

    /**
     * Instead of adding the form field firsthand in order to get the offset width and height, we use
     * default width and height for form fields because the values differ on rotation. Because of this,
     * we can add the form field at the bottom after all attributes have been set.
     */
	PageManager.getPageContainer(annotation.pageIndex + 1).find('.canvasWrapper').append(formField);

    this.canvasAnnotations.push(annotation);

    if (isAddedAfterLoad) {
        annotation.calculateOrigBound(this.canvas, angle, scale, true);

        if (Util.isFunction(Annotationeer.saveAnnotation))
            Annotationeer.saveAnnotation(annotation, null, doNotTriggerEvent);
        else
			PageManager.showAlert(Message.FUNC_UNDEFINED_ANNO_SAVE, 'info');
    }
};

/**
 * <p>This function mimics Adobe Acrobat's behavior when creating poly line type annotations when right clicking
 * using the mouse, will show this context menu.</p>
 * @function
 * @memberof Page
 * @param {decimal} menuX The x coordinate where the menu should appear.
 * @param {decimal} menuY The y coordinate where the menu should appear.
 * @param {decimal} lastPointX The last point x coordinate of the annotation.
 * @param {decimal} lastPointY The last point y coordinate of the annotation.
 */
Page.prototype.showPolyLineCreateMenu = function(menuX, menuY, lastPointX, lastPointY) {
    if (!PageManager.startCreatingAnnotation || (PageManager.startCreatingAnnotation && PageManager.boxAnnotationGuide.drawingPositions.length < 3))
        return;

    var items = {
        'cancel': { name: '<span data-l10n-id="cancel_label">Cancel</span>', isHtmlName: true },
        'sep': '---------',
        'complete' : { name: '<span data-l10n-id="complete_label">Complete</span>', isHtmlName: true }
    };

    var page = this;

    $.contextMenu({
        selector: 'canvas#' + Default.canvasIdName + (this.pageIndex + 1),
        trigger: 'none',
        zIndex: 99999,
        callback: function(key) {
            switch (key) {
                case 'cancel':
                    // Since user cancelled it, remove annotation and let user create again.
                    page.canvasAnnotations.splice(page.canvasAnnotations.length - 1);
                    page.invalidate();
					PageManager.boxAnnotationGuide.drawingPositions = [];
                    break;
                case 'complete':
                    // Remove extra drawing position entry because of the mouse click.
					PageManager.boxAnnotationGuide.drawingPositions.splice(PageManager.boxAnnotationGuide.drawingPositions.length - 1, 1);
                    // Update last drawing position's coordinates based on last mouse click of the user before menu was shown.
					PageManager.boxAnnotationGuide.drawingPositions[PageManager.boxAnnotationGuide.drawingPositions.length - 1].x = lastPointX;
					PageManager.boxAnnotationGuide.drawingPositions[PageManager.boxAnnotationGuide.drawingPositions.length - 1].y = lastPointY;

                    var boundingBox = Util.getBoundingBoxOfPoints(PageManager.boxAnnotationGuide.drawingPositions);
					PageManager.boxAnnotationGuide.x = boundingBox.x;
					PageManager.boxAnnotationGuide.y = boundingBox.y;
					PageManager.boxAnnotationGuide.w = boundingBox.w;
					PageManager.boxAnnotationGuide.h = boundingBox.h;

                    // Remove extra annotation added to canvas' annotation list because of the mouse click.
                    page.canvasAnnotations.splice(page.canvasAnnotations.length - 1, 1);
                    // Add the final created annotation
                    page.addAnnotation(PageManager.boxAnnotationGuide, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, false, true);
					page.invalidate();
                    resetVar();
                    break;
            }
        },
        items: items,
        events: {
			show: function() {
				PageManager.translateEachL10n($('ul.context-menu-list'));
			},
            hide: function() {
                $.contextMenu('destroy',  'canvas#' + Default.canvasIdName + (page.pageIndex + 1));
            }
        }
    });

    $('#' + Default.canvasIdName + (this.pageIndex + 1)).contextMenu({x: menuX, y: menuY});
};

/**
 * <p>This is a utility function to detect if a mouse event's coordinate (whether mouse down, move or up) falls
 * within the annotation's bounding area.</p>
 * @function
 * @memberof Page
 * @param {object} annotation The annotation object.
 * @param {object} mouseEvent The mouse event object.
 * @returns {boolean}
 */
Page.prototype.isMouseCoordinateInAnnotationArea = function(annotation, mouseEvent) {
    // This condition is different for these types of annotations because their coordinates
    // are based on a DIV element's position, not canvas
    return ((annotation.isSelectableTextType() && annotation.containsHighlightText(this.mx, this.my, mouseEvent)) ||
        (annotation.drawingPositions.length > 0 && annotation.containsDrawing(this, this.mx, this.my)) ||
        (annotation.drawingPositions.length === 0 && annotation.contains(this.mx, this.my, mouseEvent)));
};

/**
 * Show or hide tooltip in the page.
 * @function
 * @memberof Page
 * @param {boolean} show Shows or hide the tooltip in the page.
 * @param {object} event The event
 */
Page.prototype.showHideTooltip = function(show, event) {
    if (PageManager.isResizeDrag || PageManager.startCreatingAnnotation || PageManager.startDrawing || PageManager.leftButtonMouseClicked)
        return;

    if (!Util.isMobile() && Default.ANNOTATIONS_TOOLTIP)
        if (show) {
            // Hover tooltip if on top of annotation shape.
            for (var i=this.canvasAnnotations.length-1; i>=0; i--) {
                if (this.canvasAnnotations[i].isFormField())
                    continue;

                if ((this.canvasAnnotations[i].drawingPositions.length === 0 && this.canvasAnnotations[i].contains(this.mx, this.my)) ||
                    (this.canvasAnnotations[i].drawingPositions.length > 0 && this.canvasAnnotations[i].containsDrawing(this, this.mx, this.my)) ||
                    (this.canvasAnnotations[i].highlightTextRects.length > 0 && this.canvasAnnotations[i].containsHighlightText(this.mx, this.my)))
                {
                    if (this.canvasAnnotations[i].moving)
                        return;

                    var comment = this.canvasAnnotations[i].comments[0];
                    var date = comment.dateModified;

                    if (!Util.isFunction(date.getMonth))
                        date = new Date(date);

                    var content = document.createElement('div');
                    content.innerHTML = this.canvasAnnotations[i].isFormField() ?
                    '<strong data-l10n-id="name_label">Name</strong>: ' + (this.canvasAnnotations[i].formFieldName ?
                        this.canvasAnnotations[i].formFieldName : Message.NOT_ASSIGNED) + '<br/>' +
                    '<strong data-l10n-id="value_label">Value</strong>: ' + (this.canvasAnnotations[i].formFieldValue ?
                        this.canvasAnnotations[i].formFieldValue : Message.NOT_ASSIGNED) :
                    '<strong>' + comment.user_name + '</strong>' +
                    ' - <small>' + Util.getMomentFormattedDate(date) +
                    ' - ' + (this.canvasAnnotations[i].comments.length - 1) +
                    ' <span data-l10n-id="replies_label">replies</span></small><br/>' +
                    '<span class="pre-tag">' + this.canvasAnnotations[i].getTooltip() + '</span>';
                    var x = event.clientX;
                    var y = event.clientY;

                    this.canvas._tippy = null;
                    tippy(this.canvas, {
                        allowHTML: true,
                        boundary: this.canvas,
                        content: content.innerHTML,
                        duration: [Default.ANNOTATIONS_TOOLTIP_DELAY_SHOW, 0],
                        lazy: false,
                        trigger: 'manual',
                        zIndex: Default.zIndex_TOOLTIP,
                        onShow: function onShow(instance) {
                            instance.popperInstance.reference = {
                                clientWidth: 0,
                                clientHeight: 0,
                                getBoundingClientRect: function getBoundingClientRect() {
                                    return {
                                        width: 0,
                                        height: 0,
                                        top: y,
                                        right: x,
                                        bottom: y,
                                        left: x,
                                    };
                                }
                            };
                        }
                    });

                    var self = this;
                    setTimeout(function() {
                        self.canvas._tippy.show();
                    });
                    return;
                }
            }

            if (this.canvas._tippy && this.canvas._tippy.state.isVisible)
                this.canvas._tippy.hide();
        }
        else {
            $.contextMenu('destroy',  '#' + Default.canvasIdName + this.pageIndex);;
        }
}
