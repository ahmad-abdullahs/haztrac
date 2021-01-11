/********************************************************************
 * Copyright (C) 2016-Present Mark Chester Goking <chitgoks@gmail.com>.
 *
 * This file is part of Annotationeer and it can not be copied
 * and/or distributed without the express permission of the author.
 ********************************************************************/

// Slowly moving functions here to class so users can easily know where the function belongs to.
/**
 * Actions related to pages.
 * @namespace
 */
var PageManager = { };

/**
 * <p>This array will store all annotation type objects including the images to represent the icon that will
 * be displayed in the tool bar. This will also be used in the annotation_list.js getImage() function.</p>
 * @memberof PageManager
 * @type {Array<AnnotationType>}
 */
PageManager.annotationTypes = [];

/**
 * Stores watermark text.
 * @memberof PageManager
 * @type {Array}
 */
PageManager.watermarkText = [];

/**
 * The pages array that stores all {@link Page} objects.
 * @global
 * @type {Array<Page>}
 */
var pages = [];

/**
 * Holds annotations of all PDF pages
 * @global
 * @type {Array<Annotation>}
 */
var annotations = [];

/**
 * This indicates the user is going to create an annotation e.g. highlight/box.
 * @memberof PageManager
 * @type {boolean}
 */
PageManager.startCreatingAnnotation = false;

/**
 * Indicator to start drawing.
 * @memberof PageManager
 * @type {boolean}
 */
PageManager.startDraw = false;

/**
 * Indicator if user is resizing or moving the annotation.
 * @memberof PageManager
 * @type {boolean}
 */
PageManager.isResizeDrag = false;
/**
 * Will save the # of the selection handle if the mouse is over one.
 * @memberof PageManager
 * @type {number}
 */
PageManager.expectResize = -1;
/**
 * This identifies what kind of action will happen after selecting text. e.g. highlight, underline, strike-through.
 * @memberof PageManager
 * @type {number}
 */
PageManager.selectionTextType = -1;

/**
 * Represents the currently selected annotation.
 * @memberof PageManager
 * @type {Array}
 */
PageManager.selectedAnnotations = [];

/**
 * <p>This variable will be used as basis for new measurement type annotations after user has calibrated.
 * We changed this to a calibration label instead of a float value because of the introduction of the
 * {@link MeasurementType.FOOT_INCH} measurement unit.</p>
 * @default Empty {string}
 * @memberof PageManager
 * @type {string}
 */
PageManager.calibrationLabel = '';
/**
 * <p>This variable will be used as calibration value for computing the calibration label.
 * @default 1
 * @memberof PageManager
 * @type {decimal}
 */
PageManager.calibrationValue = 1;
/**
 * Default calibration type that measurement annotations use once it is set.
 * @default {@link Default.ANNOTATION_MEASUREMENT_TYPE_DEFAULT}
 * @memberof PageManager
 * @type {number}
 */
PageManager.calibrationMeasurementType = Default.ANNOTATION_MEASUREMENT_TYPE_DEFAULT;
/**
 * Variable for highlight/box creation guide.
 * @memberof PageManager
 * @type {object}
 */
PageManager.boxAnnotationGuide = {};
/**
 * Variable for drawing creation guide.
 * @memberof PageManager
 * @type {Array}
 */
PageManager.drawingGuide = [];

var rotateAngle = 0;
/**
 * Tracker because mouseMove(e) which returns 1 even if no button is pressed (firefox).
 * @memberof PageManager
 * @type {boolean}
 */
PageManager.leftButtonMouseClicked = false;

/**
 * Tracker to detect which annotation was mouse left clicked. Important to enable moving and resizing
 * because this feature is only available if there is 1 selected annotation.
 * @memberof PageManager
 * @type {boolean}
 */
PageManager.leftButtonMouseClickedAnnotation = null;

/**
 * This variable is used to store the value returned by PageManager.getSelectedTextClientRects() for use in iOS
 * devices because of the selection context menu that messes up the creation of a selected text
 * annotation (highlight, underline, strike-through).
 * @memberof PageManager
 * @type {object}
 */
PageManager.iosSelectedTextClientRects = null;
/**
 * This variable meanwhile, stores the text that is part of the selection.
 * @memberof PageManager
 * @type {string}
 */
PageManager.iosSelectedText = null;
/**
 * Initiates a create audio annotation action.
 * @function
 * @memberof PageManager
 * @param {object} button The button that triggered this function.
 */
PageManager.createAudio = function(button) {
    if (Default.SAVE_ALL_ANNOTATIONS_ONE_TIME) {
		PageManager.showAlert(Message.SAVE_CONFLICT_REQUIREMENT, 'info');
        return;
    }

    // If audio is not supported
    if (!PageManager.hasGetUserMedia()) {
		PageManager.showAlert(Message.AUDIO_NO_SUPPORT, 'info');
        return;
    }

	PageManager.createAnnotation(button, Annotation.TYPE_AUDIO, 'images/' + PageManager.getAnnotationTypeById(Annotation.TYPE_AUDIO).icon);
};
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
PageManager.createAnnotation = function(button, type, icon, iconWidth, iconHeight) {
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

        PageManager.boxAnnotationGuide = new Annotation();
	PageManager.boxAnnotationGuide.dummy = true;
	PageManager.boxAnnotationGuide.annotationType = type;

    if (type == Annotation.TYPE_STICKY_NOTE || type == Annotation.TYPE_TEXT_INSERT) {
        PageManager.boxAnnotationGuide.backgroundColor = Default.ANNOTATION_IMAGE_COLOR_BASE_ON_COLOR_PICKER ?
        Default.DRAW_COLOR_BACKGROUND : '#000000';
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
            image.onload = function() {
                ctx.drawImage(image, 0, 0);
                canvas.remove();
            };
            image.src = icon;
			PageManager.boxAnnotationGuide.icon = image;
            // We cannot depend using the image's naturalWidth and naturalHeight properties
            // because these are not supported in IE11 but Bing is okay.
			PageManager.boxAnnotationGuide.icon.width = iconWidth;
			PageManager.boxAnnotationGuide.icon.height = iconHeight;
        }
        else {
			PageManager.boxAnnotationGuide.setIconSource(icon);

            if (PageManager.boxAnnotationGuide.annotationType == Annotation.TYPE_STAMP) {
                // Compute width based on preferred height
                //Util.getImageWidthFromHeight(PageManager.boxAnnotationGuide.icon, Default.ANNOTATION_STAMP_HEIGHT)
				PageManager.boxAnnotationGuide.icon.width = Default.ANNOTATION_STAMP_WIDTH;
				PageManager.boxAnnotationGuide.icon.height = Default.ANNOTATION_STAMP_HEIGHT;
            }
            else {
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
 * Shows a list of stamp as a drop down.
 * @function
 * @memberof PageManager
 * @param {object} button The button that triggered this function.
 */
PageManager.showStampChooser = function(button) {
    if ($(button).hasClass('toggled')) {
        resetVar();
        return;
    }

	PageManager.resetAllToggles();
	PageManager.closeAllDropDown();
    $(button).addClass('toggled');

    // Remove right css property.
    $("#stampList").css({ 'right': ''});

    if ($('#stampList').hasClass('show')) {
        resetVar();
        $('#stampList').removeClass('show');
    }
    else {
        $('#stampList').addClass('show');
        $("#stampList").scrollTop(0);

        if (Util.isElementOffRightScreen($('#stampList')))
            $("#stampList").css('right', 0);
    }
};
/**
 * Rotate page to the right.
 * @function
 * @memberof PageManager
 */
PageManager.rotateRight = function() {
	PageManager.clearAnnotationeerDOMElements();
    rotateAngle = Math.abs(PDFViewerApplication.pdfViewer.pagesRotation + 90);
    if (Math.abs(rotateAngle) == 360) rotateAngle = 0;
    PDFViewerApplication.rotatePages(90);
};
/**
 * Rotate page to the left.
 * @function
 * @memberof PageManager
 */
PageManager.rotateLeft = function() {
	PageManager.clearAnnotationeerDOMElements();
    rotateAngle = PDFViewerApplication.pdfViewer.pagesRotation - 90;
    if (rotateAngle == -90) rotateAngle = 270;
    else if (rotateAngle == -270) rotateAngle = 90;
    else if (Math.abs(rotateAngle) == 360) rotateAngle = 0;
    else rotateAngle = Math.abs(rotateAngle);
    PDFViewerApplication.rotatePages(-90);
};

/**
 * Resets all UI configuration settings.
 * @param enableHandToolOrScreenShot There are cases when hand tool should be enabled when other settings are reset.
 * e.g. Annotationeer.runAfterPageRendered() will reset settings but if handTool mode is enabled, it should
 * persist.
 * @param preserveSelection Preserve selected annotation in case settings need to be reset but selections
 * should persist.
 * e.g. If user clicks on sidebar annotation list and views another page that has not yet been rendered.
 * @param page The page reference.
 */
function resetVar(enableHandToolOrScreenShot, preserveSelection, page) {
	PageManager.isResizeDrag = false;
	PageManager.expectResize = -1;
	PageManager.iosSelectedTextClientRects = null;
	PageManager.iosSelectedText = null;

    if (!preserveSelection) {
		PageManager.startCreatingAnnotation = false;
		PageManager.startDraw = false;
		PageManager.selectionTextType = 0;

        for (var p in pages) {
            if (!pages.hasOwnProperty(p))
                continue;

            pages[p].canvas.style.cursor = 'default';
            pages[p].canvas.style.pointerEvents = 'auto';
            pages[p].isDrawing = false;
            pages[p].isCreatingAnnotation = false;
			PageManager.getPageContainer(pages[p].pageIndex + 1).addClass('selectTextDisabled');
			PageManager.getPageContainer(pages[p].pageIndex + 1).children('.freeTextLayer').removeClass('hidden');

            if (!enableHandToolOrScreenShot) {
                pages[p].screenshotAnnotation = null;

                if (!page && !enableHandToolOrScreenShot && !preserveSelection)
                    pages[p].invalidate();
            }

            if (page && pages[p].pageIndex == page.pageIndex) {
                pages[p].invalidate();
                break;
            }
        }
    }

    $('#page_color_bg').css('background', '');
	PageManager.resetAllToggles(enableHandToolOrScreenShot, preserveSelection);
	PageManager.closeAllDropDown();
	PageManager.clearSelectedText();
}

/**
 * If screenshot button was clicked, within the clearSelectedAnnotationArray() function,
 * we repaint the pages if it was toggled so that the dim screen will not appear anymore.
 * @function
 * @memberof PageManager
 * @param {boolean} preserveSelection Preserve selection if function is called.
 * @param {boolean} screenshotClear Clear screenshot if function is called.
 */
PageManager.resetSelectedAnnotation = function(preserveSelection, screenshotClear) {
    if (preserveSelection)
        return;

	PageManager.clearSelectedAnnotationArray(true, screenshotClear);
};
/**
 * Stops hand tool mode.
 * @function
 * @memberof PageManager
 */
PageManager.resetHandToolMode = function() {
    PageManager.hideContextMenu();
    $('#secondaryToolbar').addClass('hidden');
	PageManager.translateDOML10n($('#aHandTool').removeClass('toggled'), 'hand_tool_enable');
	PageManager.translateDOML10n($('#toggleHandToolOverride span'), 'hand_tool_menu_enable');

    if (PageManager.getHandTool().active)
        PageManager.getHandTool().deactivate();
};
/**
 * Stops text selection mode.
 * @function
 * @memberof PageManager
 * @param {boolean} preserveSelection Ignores this function call if true.
 */
PageManager.resetSelectTextMode = function(preserveSelection) {
    if (preserveSelection)
        return;

    PageManager.hideContextMenu();
    PageManager.clearSelectedText();

    if (pages) {
        for (var p in pages) {
            if (!pages.hasOwnProperty(p))
                continue;

            pages[p].canvas.style.pointerEvents = 'auto';
			PageManager.getPageContainer(pages[p].pageIndex + 1).children('.freeTextLayer').removeClass('hidden');
        }
    }
};
/**
 * Stops screenshot mode.
 * @function
 * @memberof PageManager
 */
PageManager.resetScreenShot = function() {
    PageManager.hideContextMenu();
	PageManager.translateDOML10n($('#toggleScreenShot').removeClass('toggled'), 'screenshot_enable');
};

PageManager.selectText = function(type, button) {
    var jQueryButton = $(button);

    if (jQueryButton.hasClass('toggled')) {
        resetVar();
    }
    else {
        resetVar();
		PageManager.selectionTextType = type;

        // This will only apply for mobile devices
        if (Util.isMobile()) {
            if (type > -1)
                $('#markText').removeClass('hidden');

            $('#cancelAnnotation').removeClass('hidden');
        }

        jQueryButton.addClass('toggled');

        if (Default.ANNOTATION_BUTTON_TOGGLED_CHANGE_TITLE) {
            PageManager.translateDOML10n(button, jQueryButton.attr('data-l10n-id') + '_stop');
        }

        if (pages) {
            for (var p in pages) {
                if (!pages.hasOwnProperty(p))
                    continue;

                pages[p].canvas.style.pointerEvents = 'none';
				PageManager.getPageContainer(pages[p].pageIndex + 1).children('.freeTextLayer').addClass('hidden');

                if (type != Annotation.TYPE_TEXT_INSERT)
                    PageManager.getPageContainer(pages[p].pageIndex + 1).removeClass('selectTextDisabled');
            }
        }
    }
};
/**
 * Gets the text from text selection.
 * @function
 * @memberof PageManager
 * @returns {string}
 */
PageManager.getSelectedText = function() {
    if (window.getSelection) {
        return window.getSelection().toString();
    }
    else if (document.selection) {
        return document.selection.createRange().text;
    }
    return '';
};
/**
 * Clears the text selected.
 * @function
 * @memberof PageManager
 */
PageManager.clearSelectedText = function() {
    if (window.getSelection) {
        if (window.getSelection().empty) {  // Chrome
            window.getSelection().empty();
        }
        else if (window.getSelection().removeAllRanges) {  // Firefox
            window.getSelection().removeAllRanges();
        }
    }
    else if (document.selection) {  // IE?
        document.selection.empty();
    }
};

/**
 * <p>Returns true if mouse coordinate is within text selection area.</p>
 * @see {@link http://stackoverflow.com/questions/12603397/calculate-width-height-of-the-selected-text-javascript}
 * @function
 * @memberof PageManager
 * @param {decimal} mouseX The x coordinate of the mouse event.
 * @param {decimal} mouseY The y coordinate of the mouse event.
 * @returns {boolean}
 */
PageManager.isWithinSelectionBound = function(mouseX, mouseY) {
    var sel = document.selection, range;
    var x = 0, y = 0, width = 0, height = 0;
    if (sel) {
        if (sel.type != "Control") {
            range = sel.createRange();
            x = range.boundingLeft;
            y = range.boundingTop;
            width = range.boundingWidth;
            height = range.boundingHeight;
        }
    } else if (window.getSelection) {
        sel = window.getSelection();
        if (sel.rangeCount) {
            range = sel.getRangeAt(0).cloneRange();
            if (range.getBoundingClientRect) {
                var rect = range.getBoundingClientRect();
                x = rect.left;
                y = rect.top;
                width = rect.right - rect.left;
                height = rect.bottom - rect.top;
            }
        }
    }
    return (mouseX >= x && mouseX <= x + width && mouseY >= y && mouseY <= y + height);
};

/**
 * <p>In particular a Chrome bug which results in selections spanning multiple nodes
 * returning rectangles for all the parents of the endContainer. Use range_fix.js.</p>
 * @function
 * @memberof PageManager
 * @returns {Array}
 */
PageManager.getSelectedTextClientRects = function() {
    if (window.getSelection)
        return RangeFix.getClientRects(window.getSelection().getRangeAt(0));
    else if (document.selection)
        return document.selection.createRange().getClientRects();

    return null;
};

/**
 * <p>Because PageManager.getSelectedTextClientRects() does not work in IE when selection is
 * multi-line, we use this method instead as it is more accurate.</p>
 * @function
 * @memberof PageManager
 * @returns {Array}
 */
PageManager.getSelectedTextClientRectsAsNodes = function() {
    if (window.getSelection)
        return window.getSelection().getRangeAt(0).cloneContents().querySelectorAll('*');
    else if (document.selection)
        return document.getSelection().getRangeAt(0).cloneContents().querySelectorAll('*');

    return null;
};

/**
 * <p>Pretty useful to calculate width of text for elements without any width specified.
 * This is usually if the font is monospace. measureText() is new in HTML5.</p>
 * @see {@link http://stackoverflow.com/questions/118241/calculate-text-width-with-javascript}
 * @function
 * @memberof PageManager
 * @param {string} text The text.
 * @param {string} font The font of the text.
 * @returns {number}
 */
PageManager.getTextWidth = function(text, font) {
    // Re-use canvas object for better performance
    var canvas = PageManager.getTextWidth.canvas || (PageManager.getTextWidth.canvas = document.createElement('canvas'));
    var context = canvas.getContext('2d');
    context.font = font;
    var metrics = context.measureText(text);
    return metrics.width;
};

/**
 * Detects if browser is HTML5 ready, else this GetUserMedia() is not available.
 * @function
 * @memberof PageManager
 * @returns {boolean}
 */
PageManager.hasGetUserMedia = function() {
    return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia || navigator.msGetUserMedia);
};

/**
 * Activate screenshot mode.
 * @function
 * @memberof PageManager
 */
PageManager.screenShotMode = function() {
    if ($('#toggleScreenShot').hasClass('toggled')) {
        resetVar();
		PageManager.translateDOML10n($('#toggleScreenShot').removeClass('toggled'), 'screenshot_enable');
    }
    else {
        resetVar();
		PageManager.translateDOML10n($('#toggleScreenShot').addClass('toggled'), 'screenshot_disable');

		PageManager.boxAnnotationGuide = new Annotation();
		PageManager.boxAnnotationGuide.annotationType = Annotation.TYPE_SCREENSHOT;
		PageManager.startCreatingAnnotation = true;

        for (var p in pages) {
            if (!pages.hasOwnProperty(p))
                continue;

            pages[p].invalidate();
        }

        if (Util.isMobile())
            $('#cancelAnnotation').removeClass('hidden');
    }
};

/**
 * Reset all buttons that are toggled.
 * @function
 * @memberof PageManager
 * @param {boolean} enableHandToolOrScreenShot Enable hand or screenshot button.
 * @param {boolean} preserveSelection Preserve visual display of selection of annotation.
 */
PageManager.resetAllToggles = function(enableHandToolOrScreenShot, preserveSelection) {
    // Returned is list of native elements, not JQuery elements.
    var annotationButtons = $('.annotation');
    var screenshotClear = false;

    for (var ab=0; ab<annotationButtons.length; ab++) {
        if (enableHandToolOrScreenShot &&
           // (annotationButtons[ab].getAttribute('title').toLowerCase().indexOf('screen shot') > -1 ||
           // annotationButtons[ab].getAttribute('title').toLowerCase().indexOf('hand tool') > -1)
            (annotationButtons[ab].getAttribute('data-l10n-id').indexOf('screenshot') > -1 ||
            annotationButtons[ab].getAttribute('data-l10n-id').indexOf('hand_tool') > -1)
            )
        {
            // Skip
        }
        else {
            if (!preserveSelection) {
                annotationButtons[ab].classList.remove('toggled');
                //annotationButtons[ab].setAttribute('title', annotationButtons[ab].getAttribute('title').replace(/Stop/g, ''));
                // Remove all l10n keys with a '_stop' substring.
                PageManager.translateDOML10n(annotationButtons[ab], annotationButtons[ab].getAttribute('data-l10n-id').replace(/_stop/, ''));

                //if (annotationButtons[ab].getAttribute('title').toLowerCase().indexOf('screen shot') > -1) {
                if (annotationButtons[ab].getAttribute('data-l10n-id').indexOf('screenshot') > -1 && !screenshotClear)
                    screenshotClear = true;
            }
        }
    }

    //PageManager.resetSelectTextMode(preserveSelection);
	PageManager.resetSelectedAnnotation(preserveSelection, screenshotClear);
	PageManager.resetPageColorPickerMode();

    // This will only apply for mobile devices
    if (!preserveSelection) {
        $('#markText').addClass('hidden');
        $('#cancelAnnotation').addClass('hidden');
    }

    if (!enableHandToolOrScreenShot) {
		PageManager.resetHandToolMode();
		PageManager.resetScreenShot();
    }

    if (PDFViewerApplication.secondaryToolbar.isOpen)
        PDFViewerApplication.secondaryToolbar.toggle();
};

/**
 * <p>Measures text by creating a DIV in the document and adding the relevant text to it.
 * Then checking the .offsetWidth and .offsetHeight. Because adding elements to the DOM is not particularly
 * efficient in animations (particularly) it caches the measured text width/height.</p>
 * @see {@link http://www.rgraph.net/blog/2013/january/measuring-text-height-with-html5-canvas.html}
 * @function
 * @memberof PageManager
 * @param {string} text The text to measure.
 * @param {boolean} bold Whether the text is bold or not.
 * @param {string} font The font to use.
 * @returns {object} A two element array of the width and height of the text.
 */
PageManager.measureText = function(text, bold, font) {
    // This global variable is used to cache repeated calls with the same arguments
    var str = text + ':' + bold + ':' + font;
    if (typeof(__measuretext_cache__) == 'object' && __measuretext_cache__[str]) {
        return __measuretext_cache__[str];
    }

    var div = document.createElement('DIV');
    div.innerHTML = text;
    div.style.position = 'absolute';
    div.style.top = '-100px';
    div.style.left = '-100px';
    div.style.fontFamily = font;
    div.style.fontWeight = bold ? 'bold' : 'normal';
    //div.style.fontSize = size + 'pt';
    div.style.margin = 0;
    div.style.padding = 0;
    document.body.appendChild(div);

    var size = [div.offsetWidth, div.offsetHeight];

    document.body.removeChild(div);

    // Add the sizes to the cache as adding DOM elements is costly and can cause slow downs
    if (typeof(__measuretext_cache__) != 'object') {
        __measuretext_cache__ = [];
    }
    __measuretext_cache__[str] = size;

    return size;
};

/**
 * <p>This is an optimization function which resets a page's state that it has not yet been viewed if
 * it is not visible on the screen.</p>
 *
 * <p>This is to minimize lagging when there are so many annotations for every page and if the scale
 * value is big.</p>
 * @function
 * @memberof PageManager
 */
PageManager.resetPagesIfOffScreen = function() {
    if (!pages)
        return;

    for (var p in pages) {
        if (!pages.hasOwnProperty(p))
            continue;

        if (!PageManager.getPageContainer(pages[p].pageIndex + 1).isOnScreen())
            PDFViewerApplication.pdfViewer.getPageView(pages[p].pageIndex).reset();
    }
};

/**
 * Initializes web app preferences. Libraries are loaded here if certain features are enabled.
 * @function
 * @memberof PageManager
 */
PageManager.initWebAppPreferences = function() {
    if (typeof Override.overrideDefaultVariables === 'function')
        Override.overrideDefaultVariables();

    // Make annotations toolbar inactive first until a page is rendered.
    PageManager.setAnnotationToolbarState('disabled');

    PageManager.populateAnnotationTypesArray();

    PageManager.resizeToolbarBasedOnBrowserWidth();

    // Bootstrap annotation list and popup form
    //angular.element(document).ready(function() {
    //    angular.bootstrap(document.getElementById('annotationListContainer'), ['annotationList']);
    //    angular.bootstrap(document.getElementById('popupContainer'), ['annotationForm']);
    //});

    if (Default.SAVE_ALL_ANNOTATIONS_ONE_TIME) {
        $('#save').removeClass('hidden');
    }
    else {
        // Since by default save button is hidden, hide the separator before it
        $('#save').prev().addClass('hidden');
    }

    if (Util.isMobile()) {

    }
    else {
        if (Default.ANNOTATIONS_TOOLTIP) {
            Util.loadScript('popper.min.js');
            Util.loadScript('tippy-bundle.iife.min.js');
        }
    }

    if (!Default.ANNOTATIONS_AUDIO)
        $('#audio').remove();
    else
        Util.loadScript('record_mp3/recordmp3.js', function() {
            // Loaded Javascript library and CSS stylesheet for audio.
            Util.onloadCSS(loadCSS('record_mp3/css.css'), function() {

            });
        });

    if (!Default.ANNOTATION_SHOW_HIDE_FEATURE) {
        $('#show_hide').remove();
    }

    // Noticed that even Edge browser has problem with overflow and margin-left css properties.
    if (Util.isIE() || !Util.supportsHTML5ColorInput()) {
        Util.onloadCSS(loadCSS('jquery.minicolors.min.css'), function () {
            Util.loadScript('jquery.minicolors.min.js', function () {
                $('#backgroundPalette').minicolors();
                $('#colorPalette').minicolors();
            });
        });
    }

    if (Default.PAGE_COLOR_PICKER_ENABLED) {
        $('#togglePageColorPicker').removeClass("hidden");
    }

    /**
     * If Annotationeer.pdfDocuments[] array contains more than 1 item, then this means it is a grouped PDF. Else, use
     * the default navigation logic of PDF.JS.
     */
    if (Annotationeer.pdfDocuments.length == 1) {
        $('#aPageNumber').addClass("hidden");
        $('#aNumPages').addClass("hidden");

        $('#pageNumber').removeClass("hidden");
        $('#numPages').removeClass("hidden");
    }

    if (Default.INCLUDE_FORM_FIELDS)
        $('#form_field_group').removeClass('hidden');

    if (Default.ALERT_BEAUTIFY) {
        Util.onloadCSS(loadCSS('toastr.min.css'), function() {
            Util.loadScript('toastr.min.js', function() { });
        });
    }

    if (Util.isIOSDevice()) {
        document.addEventListener('selectionchange', function() {
            if ($('button#textSelectMode').hasClass('toggled'))
                return;

            var selectedTextClientRects = PageManager.getSelectedTextClientRects();
            if ($('button#markText').is(':visible') && selectedTextClientRects) {
				PageManager.iosSelectedTextClientRects = selectedTextClientRects;
				PageManager.iosSelectedText = PageManager.getSelectedText();
            }
        });
    }

    if (Default.ANNOTATION_EXPORT_ENABLED)
        $('button#export').removeClass('hidden');

    if (Default.STAMP_CUSTOM_ENABLED) {
        $('#stampList').children(':first').removeClass('hidden');

        Util.onloadCSS(loadCSS('dropzone.min.css'), function() {
            Util.loadScript('dropzone.min.js', function() {
                Dropzone.autoDiscover = false;
            });
        });
    }

	/**
	 * When updating a new version of the JSTree CSS file, ensure you modify the path for the 3
	 * images 32px.png, 42px.png and throbber.gif located in the images folder.
	 */
	if (Default.BOOKMARK_ENABLE) {
        Util.onloadCSS(loadCSS('jstree.min.css'), function() {
            Util.loadScript('jstree.min.js', function() {
				BookmarkManager.init();
			});
		});
	}
};

/**
 * <p>Convenience method to add annotations to {@link PageManager.selectedAnnotations|PageManager.selectedAnnotations[]}
 * array variable so we can add other code that needs to be executed here.</p>
 * @function
 * @memberof PageManager
 * @param annotation
 * @param fromAngular If event is triggered from the sidebar annotation list
 */
PageManager.addSelectedAnnotation = function(annotation, fromAngular) {
	PageManager.consoleLog('PageManager.addSelectedAnnotation()');
  PageManager.consoleLog(annotation);
    if (annotation.hidden)
        return;

    var pagesThatNeedInvalidate = [];

    if (fromAngular) {
        for (var a=0; a<annotations.length; a++) {
            if (annotations[a].selected)
                if ($.inArray(annotations[a].pageIndex, pagesThatNeedInvalidate) === -1) {
                    pagesThatNeedInvalidate.push(annotations[a].pageIndex);
                }

            annotations[a].selected = false;
        }

		PageManager.clearSelectedAnnotationArray();
    }

    annotation.selected = true;
    for (var i=0; i<annotations.length;i++){
        if (annotation.id == annotations[i].id) {
            annotations[i].selected = annotation.selected;

            if ($.inArray(annotations[i].pageIndex, pagesThatNeedInvalidate) === -1) {
                pagesThatNeedInvalidate.push(annotations[i].pageIndex);
            }

            break;
        }
    }

	PageManager.selectedAnnotations.push(annotation);

    if (fromAngular) {
        for (var i=0; i<pagesThatNeedInvalidate.length; i++) {
            var page = pages[Default.canvasIdName + (pagesThatNeedInvalidate[i] + 1)];
            if (page) page.invalidate();
        }
    }
    else {
        PageManager.refreshAnnotationList();

        /**
         * When annotation is selected via the canvas, the annotation on the sidebar list will
         * be scrolled into view. This will happen if the option below is false since the comments
         * will not be expanded by default when selected.
         */
        if (!Default.ANNOTATION_LIST_COMMENTS_SHOW ||
			Default.ANNOTATION_LIST_COMMENTS_EXPAND != Default.ANNOTATION_LIST_COMMENTS_EXPAND_SELECTED)
			PageManager.scrollToAnnotationInList(annotation);
      var as=1;
    }

    if (!Default.ANNOTATION_LIST_COMMENTS_SHOW ||
		Default.ANNOTATION_LIST_COMMENTS_EXPAND == Default.ANNOTATION_LIST_COMMENTS_EXPAND_SELECTED)
	{
        var img = $('#img_' + annotation.id);
        if (img.length > 0 && img.attr('src').indexOf('expand') > -1) {
            setTimeout(function() {
                angular.element('#' + img.attr('id')).triggerHandler('click');
                PageManager.scrollToAnnotationInList(annotation);
            }, 0);
        }
    }

    if (Util.isMobile())
        PageManager.displayContextMenuForMobile(PageManager.selectedAnnotations.length == 1);
};

/**
 * This function is used to update the annotation from the Angular JS environment.
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 * @param {boolean} openedUponAnnotationCreation Indicates that this comment window was opened after annotation was created.
 */
PageManager.updateAnnotationComment = function(annotation, openedUponAnnotationCreation) {
	PageManager.consoleLog('PageManager.updateAnnotationComment()');

    root:
    for (var p in pages) {
        if (!pages.hasOwnProperty(p))
            continue;

        if (pages[p].pageIndex == annotation.pageIndex) {
            for (var i=0; i<pages[p].canvasAnnotations.length; i++) {
                if (pages[p].canvasAnnotations[i].id == annotation.id) {
                    pages[p].canvasAnnotations[i].comments = annotation.comments;
                    break root;
                }
            }
        }
    }

    for (var a=0; a<annotations.length; a++) {
        if (annotations[a].id == annotation.id) {
            annotations[a].comments = annotation.comments;
            annotations[a].modified = annotation.modified;
            break;
        }
    }

    /**
     * We call this if option is true because the updated values for comments will not
     * reflect unless we call the controller digest again.
     */
    PageManager.refreshAnnotationList();

    // Refresh review status in case user set a new one.
    if (Default.COMMENT_FEATURE_STATUS_DISPLAY)
        setTimeout(function() {
            angular.element('div#popupContainer').scope().$digest();
        }, 10);


    if (Default.CREATE_ANNOTATION_EVENTS && !openedUponAnnotationCreation)
		PageManager.createAnnotationEvent(annotation, 'update');
};

/**
 * Sets the annotation to not selected.
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 * @param {boolean} doNotRefreshPageAfterRemove Do not redraw canvas.
 */
PageManager.removeSelectedAnnotation = function(annotation, doNotRefreshPageAfterRemove) {
    for (var i=0; i<annotations.length;i++){
        if (annotation.id == annotations[i].id) {
            annotations[i].selected = false;
            break;
        }
    }

    for (var i=0; i<PageManager.selectedAnnotations.length; i++) {
        if (annotation.id == PageManager.selectedAnnotations[i].id) {
			PageManager.selectedAnnotations.splice(i, 1);
            break;
        }
    }

    var page = pages[Default.canvasIdName + (annotation.pageIndex + 1)];
    for (var i=0; i<page.canvasAnnotations.length; i++) {
        if (annotation.id == page.canvasAnnotations[i].id) {
            page.canvasAnnotations[i].selected = false;

            if (!doNotRefreshPageAfterRemove)
                page.invalidate();

            break;
        }
    }

    // If annotation is layer type, remove.
    var layers = $('div#' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + annotation.id);
    for (var l=0; l<layers.length; l++) {
        $(layers[l]).css('border', '');
        $(layers[l]).css('border-top-color', '');
        $(layers[l]).css('border-bottom-color', '');
        $(layers[l]).css('border-left-color', '');
        $(layers[l]).css('border-right-color', '');
    }

    if (Util.isMobile())
		PageManager.displayContextMenuForMobile(PageManager.selectedAnnotations.length == 1);

    PageManager.refreshAnnotationList();
};

/**
 * Close all dropdown list in the toolbar. e.g. Stamp, signature.
 * @function
 * @memberof PageManager
 */
PageManager.closeAllDropDown = function() {
    $('#stamp').removeClass('toggled');
    $('#stampList').removeClass('show');
    $('#digital_signature').removeClass('toggled');
    $('#digitalSignatureList').removeClass('show');
};

/**
 * Refresh annotation list in the sidebar to reflect the current state.
 * @function
 * @memberof PageManager
 */
 PageManager.refreshAnnotationList = function() {
     PageManager.consoleLog('PageManager.refreshAnnotationList()');
      var annotationListContainer = angular.element($('#annotationListContainer'))
      if (annotationListContainer.length > 0)
          setTimeout(function() {
              var annotationList = annotationListContainer.scope();
              annotationList.$digest();

              if (annotationList.hasFilterOption())
                  annotationList.filterAnnotations();

              PDFViewerApplication.l10n.translate(document.getElementById('annotationListContainer'));
          }, 0);
 };

/**
 * Clear annotations that are selected.
 * @function
 * @memberof PageManager
 * @param {boolean} redraw Redraws all canvas where the selected annotations are located.
 * @param {boolean} screenshotClear Clears screenshot.
 * @param {boolean} doNotRefreshSideBar Do not call {@link PageManager.refreshAnnotationList()}.
 */
PageManager.clearSelectedAnnotationArray = function(redraw, screenshotClear, doNotRefreshSideBar) {
    PageManager.consoleLog('PageManager.clearSelectedAnnotationArray()');

    if (PageManager.selectedAnnotations.length == 0)
        return;

    for (var i=0; i<PageManager.selectedAnnotations.length; i++) {
        if (PageManager.selectedAnnotations[i].isFormField()) {
            var input = $('div#' + Default.ANNOTATION_ID_PREFIX_FORM_FIELD + PageManager.selectedAnnotations[i].id);
            input.css('border', '');
        }
        else if (PageManager.selectedAnnotations[i].annotationType == Annotation.TYPE_TEXT) {
            var div = $('div#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + PageManager.selectedAnnotations[i].id);
            div.css('border', '');
        }
        else if (PageManager.selectedAnnotations[i].isSelectableTextType()) {
            if (Default.ANNOTATION_SELECTABLE_TEXT_AS_DIV) {
                var div = $('div#' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + PageManager.selectedAnnotations[i].id);
                div.css('border', '');
                div.css('border-top-color', '');
                div.css('border-bottom-color', '');
                div.css('border-left-color', '');
                div.css('border-right-color', '');
            }
        }
    }

    if (pages && (redraw || screenshotClear)) {
        var pagesWhereAnnotationsAreSelected = [];

        for (var s=0; s<PageManager.selectedAnnotations.length; s++) {
            if ($.inArray(PageManager.selectedAnnotations[s].pageIndex, pagesWhereAnnotationsAreSelected) === -1)
                pagesWhereAnnotationsAreSelected.push(PageManager.selectedAnnotations[s].pageIndex);
        }


        for (var p=0; p<pagesWhereAnnotationsAreSelected.length; p++) {
            var page = pages[Default.canvasIdName + (pagesWhereAnnotationsAreSelected[p] + 1)];

            for (var i=0; i<page.canvasAnnotations.length; i++) {
                page.canvasAnnotations[i].clicked = false;
                page.canvasAnnotations[i].moving = false;
                page.canvasAnnotations[i].selected = false;
            }

            page.invalidate();
        }
    }

	PageManager.selectedAnnotations = [];

	PageManager.displayContextMenuForMobile(false);

    for (var a=0; a<annotations.length; a++) {
        annotations[a].selected = false;
    }

    if (!doNotRefreshSideBar)
        PageManager.refreshAnnotationList();
};

PageManager.createSelectText = function() {
    if (PageManager.selectionTextType <= 0)
        return;

    try {
        var selectionNodes = Util.getNodesBetween($(Util.getSelectionBoundaryElement(true)), $(Util.getSelectionBoundaryElement()), true);

        if (selectionNodes.length === 0) {
            PageManager.clearSelectedText();
            return;
        }

        // If selected text overlaps between 2 or more pages, cancel.
        var pagesFound = [];
        for (var s=0; s<selectionNodes.length; s++) {
            if (selectionNodes[s].length === 0)
                continue;

            pagesFound.push(selectionNodes[s][0].parentElement.parentElement.getAttribute('data-page-number'));
        }

        if (pagesFound === 0) {
            PageManager.clearSelectedText();
            return;
        }

        if (new Set(pagesFound).size > 1) {
            PageManager.clearSelectedText();
            PageManager.showAlert(Message.TEXT_SELECT_OVERLAP, 'info');
            return;
        }

        if (Util.getAngleCountOfSelectedNodes(selectionNodes) > 1) {
			PageManager.clearSelectedText();
            PageManager.showAlert(Message.TEXT_SELECT_REQUIREMENT, 'info');
            return;
        }

        var pageNumber = parseInt(pagesFound[0]);
        var page = pages['pageAnnotation' + pageNumber];
        if (page.pageIndex === pageNumber - 1) {
            var annotation = page.highlightText(PageManager.selectionTextType, pageNumber - 1,
                rotateAngle, PDFViewerApplication.pdfViewer.currentScale, null, null, null, selectionNodes[0]);

            if (annotation) {
                if (Util.isFunction(Annotationeer.saveAnnotation))
                    Annotationeer.saveAnnotation(annotation);
                else
                    PageManager.showAlert(Message.FUNC_UNDEFINED_ANNO_SAVE, 'info');
            }
        }

        PageManager.clearSelectedText();
    } catch (e) { }
};

/**
 * This function is used only if {@link Default.SAVE_ALL_ANNOTATIONS_ONE_TIME} is false.
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 * @param {boolean} newlyCreated Indicates if this annotation is newly created.
 * @param {boolean} doNotTriggerEvent If true, trigger annotation event. {@link Default.CREATE_ANNOTATION_EVENT} will still override this.
 */
PageManager.updateAnnotationListAfterSave = function(annotation, newlyCreated, doNotTriggerEvent) {
    /**
     * This section of code is used to replace the existing annotation object when user edits an annotation like
     * moving its located, resizing it, or editing comments associated to this annotation.
     *
     * This can be placed inside the success block of the ajax call to save annotation to server if
     * Default.SAVE_ALL_ANNOTATIONS_ONE_TIME is false.
     */
    var replaced = false;
    for (var i=0; i<annotations.length; i++) {
        if (annotations[i].id == annotation.id) {
            annotations.splice(i, 1, annotation);
            replaced = true;
            break;
        }
    }
//PageManager.consoleLog(annotation);
    if ((annotation.id <= 0 || (annotation.id > 0 && (!annotation.audio && !annotation.audioAvailable))) &&
        annotation.annotationType == Annotation.TYPE_AUDIO)
    {
        Annotationeer.showPlayer(annotation);
    }

    if (!replaced) annotations.push(annotation);

    if (annotation.annotationType == Annotation.TYPE_TEXT)
        $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT).attr('id', Default.ANNOTATION_ID_PREFIX_FREE_TEXT + annotation.id);
    else if (annotation.isFormField())
        $('#' + Default.ANNOTATION_ID_PREFIX_FORM_FIELD).attr('id', Default.ANNOTATION_ID_PREFIX_FORM_FIELD + annotation.id);
    else if (annotation.isSelectableTextType()) {
        // Save to server and get returned id and assign id to all div elements where id=highlight
        var divs = PageManager.getPageContainer(annotation.pageIndex + 1).find('.canvasWrapper').children('div[id="' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + '"]');
        for (var d=0; d<divs.length; d++) {
            $(divs[d]).attr('id', Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + annotation.id);
        }
    }
    /**
     * Reset the last tracked positions once saved so that these will be assigned values
     * when they will be used again.
     */
    else if (annotation.hasTwoEndPoints()) {
        for (var i=0; i<annotation.drawingPositions.length; i++) {
            annotation.drawingPositions[i].lastX = -1;
            annotation.drawingPositions[i].lastY = -1;
        }
    }

    // Update the reference to annotations in Angular JS.
    if (newlyCreated)
        PageManager.refreshAnnotationList();

    // If annotation is TYPE_STICKY_NOTE, show popup comment form if default option is true.
    if (newlyCreated &&
        ((Default.ANNOTATION_STICKY_NOTE_POPUP_ON_CREATE && annotation.annotationType == Annotation.TYPE_STICKY_NOTE) ||
        annotation.annotationType == Annotation.TYPE_TEXT_INSERT || annotation.annotationType == Annotation.TYPE_TEXT_REPLACE))
    {
        $.contextMenu('destroy',  '#' + Default.canvasIdName + (annotation.pageIndex + 1));
		Annotationeer.editAnnotation(annotation, 'edit');
    }

    if (Default.CREATE_ANNOTATION_EVENTS && !doNotTriggerEvent)
		PageManager.createAnnotationEvent(annotation);
};

/**
 * <p>When annotation is selected, the page is scrolled but sometimes the annotation
 * is not visible. We move the scroll bar position adding the y value based on the
 * annotation position.</p>
 * @function
 * @memberof PageManager
 */
PageManager.scrollToAnnotationInCanvas = function(annotation) {
	PageManager.consoleLog('PageManager.scrollToAnnotationInCanvas() annotation: ' + annotation);

    if (!annotation)
        return;

    // Starting PDF.JS v2, scrollPageIntoView() accepts an object param.
    if (Annotationeer.isPDFJSVersion2Plus()) {
        PDFViewerApplication.pdfViewer.scrollPageIntoView({ pageNumber: (annotation.pageIndex + 1)});
    }
    else {
        PDFViewerApplication.pdfViewer.scrollPageIntoView(annotation.pageIndex + 1);
    }

    var y = annotation.y;
    // If annotation has highlightTextRects, get the smallest Y coordinate value
    if (annotation.highlightTextRects.length > 0)
        y = annotation.highlightTextRects.reduce(function(prev, curr) {
            return prev.Cost < curr.Cost ? prev : curr;
        }).top;

    var viewerContainer = $('#viewerContainer');
    // Scroll vertical.
    viewerContainer.scrollTop((viewerContainer.scrollTop() + y) - $('#toolbarContainer').height());
    // Scroll horizontal. Add 10 pixels to give spacing when annotation is shown horizontally.
    viewerContainer.scrollLeft((viewerContainer.scrollLeft() + annotation.x) - 10);
};

/**
 * <p>A convenience function to return the element of the annotation in the annotation list depending on
 * the {@link Default.ANNOTATION_LIST_SIDEBAR_RIGHT} setting.</p>
 * @function
 * @memberof PageManager
 * @returns {*|jQuery|HTMLElement}
 */
PageManager.getAnnotationListRowElement = function(annotation) {
    return $('#annotationList #' + annotation.id);
};

/**
 * Returns the sidebar container element.
 * @function
 * @memberof PageManager
 * @returns {*|jQuery|HTMLElement}
 */
PageManager.getSidebarContainerElement = function() {
    return $('#sidebarContent');
};

/**
 * <p>Helper function to programmatically remove DOM elements created by Annotationeer to help
 * in optimization when viewer is either scaled or rotated.</p>
 * @function
 * @memberof PageManager
 */
PageManager.clearAnnotationeerDOMElements = function() {
	PageManager.consoleLog('clearAnnotationeerDOMElements()');

    for (var i=0; i<Annotationeer.aTotalPages; i++) {
        var pageContainer = PageManager.getPageContainer(i + 1);
        var canvasWrapper = pageContainer.find('.canvasWrapper');
        var divs = canvasWrapper.find('div[id^="' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + '"]');
        for (var d=0; d<divs.length; d++) {
            $(divs[d]).remove();
        }

        var divs = canvasWrapper.find('div[id^="' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + '"]');
        for (var d=0; d<divs.length; d++) {
            $(divs[d]).remove();
        }

        var inputs = canvasWrapper.find('input[id^="' + Default.ANNOTATION_ID_PREFIX_FORM_FIELD + '"]');
        for (var ii=0; ii<inputs.length; ii++) {
            $(inputs[ii]).remove();
        }

        canvasWrapper.find('canvas#pageAnnotation' + (i + 1)).remove();
        pageContainer.find('div.freeTextLayer').remove();
    }
};

/**
 * This function will set a cursor using an image and will handle cross browser issues.
 * @function
 * @memberof PageManager
 * @param {object} canvas The canvas object.
 * @param {string} image The image name that matches the .cur file.
 * @param {string} defaultCursor The default cursor.
 */
PageManager.setCursor = function(canvas, image, defaultCursor){
    canvas.style.cursor = (Util.isIE() ? 'url(images/' + image + '.cur)' :
        'url(images/' + image + '.svg) ' + ' ' + Default.CURSOR_CROSSHAIR_PIXEL_SIZE + ' ' +
        Default.CURSOR_CROSSHAIR_PIXEL_SIZE) + ', ' + defaultCursor;
}

/**
 * <p>Call this function if you want to unload all annotations from the web application. If you wish to
 * retrieve them again, call {@link Annotationeer.downloadAnnotations|Annotationeer.downloadAnnotations()}.
 * The annotation list will also be cleared when this function is called.</p>
 * @function
 * @memberof PageManager
 */
PageManager.unloadAnnotations = function() {
	PageManager.consoleLog('PageManager.unloadAnnotations()');
    annotations = [];
    for (var p in pages) {
        if (!pages.hasOwnProperty(p))
            continue;

        var divs = PageManager.getPageContainer(pages[p].pageIndex + 1).find('.canvasWrapper div');
        for (var d=0; d<divs.length; d++) {
            $(divs[d]).remove();
        }

        pages[p].canvasAnnotations = [];
        pages[p].invalidate();
    }

    // Also unload the list from the Angular JS environment, by re-bootstrapping it. Quickest way.
    angular.bootstrap(document.getElementById('annotationListContainer'), ['annotationList']);
};

/**
 * <p>Do not call this function directly if you want to reload annotations to the PDF. Call
 * {@link Annotationeer.downloadAnnotations|Annotationeer.downloadAnnotations()} and set the parameter to true.</p>
 * @function
 * @memberof PageManager
 */
PageManager.reloadAnnotations = function() {
  PageManager.consoleLog('working');
    for (var p in pages) {
        if (!pages.hasOwnProperty(p))
            continue;

        Annotationeer.loadAnnotations(pages[p].pageIndex);
    }

    var annotationListContainer = $('div#annotationListContainer');
    if (annotationListContainer.length > 0) {
        angular.element(annotationListContainer).scope().annotations = annotations;
        angular.bootstrap(annotationListContainer[0], ['annotationList']);
    }

    if (Default.BOOKMARK_ENABLE)
        BookmarkManager.init();
};

/**
 * <p>This function is only used when the web application is viewed in a mobile device because higlighting
 * text after text selection is not possible in a mobile browser. Ideally, this function can also be
 * used if the user is creating a poly line type annotation in a mobile device.</p>
 * @function
 * @memberof PageManager
 */
PageManager.markText = function() {
	PageManager.consoleLog('PageManager.markText()');

    if (PageManager.boxAnnotationGuide && PageManager.boxAnnotationGuide.annotationType == Annotation.TYPE_TEXT) {
        resetVar();
        return;
    }

    if (PageManager.selectionTextType == 0 &&
        PageManager.boxAnnotationGuide && Annotation.prototype.isPrototypeOf(PageManager.boxAnnotationGuide) &&
		PageManager.boxAnnotationGuide.isPolyLineType())
	{
        var page = pages['pageAnnotation' + (PageManager.boxAnnotationGuide.pageIndex + 1)];
		PageManager.boxAnnotationGuide.drawingPositions.splice(PageManager.boxAnnotationGuide.drawingPositions.length - 1, 1);
        page.canvasAnnotations.splice(page.canvasAnnotations.length - 1, 1);
        page.addAnnotation(PageManager.boxAnnotationGuide, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, false, true);
        resetVar();
        return;
    }

	PageManager.createSelectText();
	PageManager.iosSelectedTextClientRects = null;
};

/**
 * <p>This function is only used when the web application is viewed in a mobile device because there is no way to
 * press the escape key so this button will act as a workaround.</p>
 * @function
 * @memberof PageManager
 */
PageManager.cancelCreateAnnotation = function() {
    if (PageManager.selectionTextType == 0 && PageManager.boxAnnotationGuide &&
		Annotation.prototype.isPrototypeOf(PageManager.boxAnnotationGuide) &&
		PageManager.boxAnnotationGuide.isPolyLineType())
	{
        var page = pages['pageAnnotation' + (PageManager.boxAnnotationGuide.pageIndex + 1)];
        page.canvasAnnotations.splice(page.canvasAnnotations.length - 1);
        page.invalidate();
    }

    resetVar();
    $('#cancelAnnotation').addClass('hidden');
};

/**
 * These functions are called when creating annotation related events like add, delete, update.
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 * @param {string} what The action to assign.
 * @param {object} comment If not null, then the value of the what property will be assigned to the comment object.
 */
PageManager.createAnnotationEvent = function(annotation, what, comment) {
    if (what) {
		if (comment) {
			for (var c=0; c<annotation.comments.length; c++) {
				if (annotation.comments[c].id == comment.id) {
					annotation.comments[c].modified = what;
					break;
				}
			}
		}
		else
			annotation.modified = what;
	}

    var event = document.createEvent('CustomEvent');
    event.initCustomEvent('annotation_' + (annotation.oldModified ? annotation.oldModified :
        annotation.modified), true, true,
    {
        annotation: annotation
    });
    event.annotation = annotation;
    var page = pages[Default.canvasIdName + (annotation.pageIndex + 1)];
    page.canvas.dispatchEvent(event);
};

/**
 * Helper function to return an annotation in the global annotations array based on id.
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 * @returns {number} The index of the array.
 */
PageManager.getAnnotationById = function(annotation) {
    for (var a=0; a<annotations.length; a++) {
        if (annotations[a].id == annotation.id)
            return annotations[a];
    }
    return null;
};

/**
 * <p>Helper function to add annotation to canvas. This can be useful if you wish to get a reference to
 * an annotation object and pass it to some other Annotationeer instance in another tab, window or
 * iFrame.</p>
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 */
PageManager.updateAnnotationToCanvas = function(annotation) {
    if (!annotation)
        return;

	PageManager.clearSelectedAnnotationArray();

    annotation = Annotation.createFromJSON(annotation);

    if (annotation.modified === 'update') {
        var updateCanvasAnnotations = false;

        for (var a=0; a<annotations.length; a++) {
            /**
             * For the first condition, if annotation.oldId property != 0, then it means the annotation was saved to
             * the server and an id was returned. So update this annotation's id.
             *
             * The second condition means annotation already has a database generated id, so just updated its
             * properties.
             */
            if (annotations[a].id == annotation.oldId || annotations[a].id == annotation.id)
                updateCanvasAnnotations = true;

            if (updateCanvasAnnotations) {
                annotations[a] = annotation;
                var page = pages[Default.canvasIdName + (annotation.pageIndex + 1)];
                for (var c=0; c<page.canvasAnnotations.length; c++) {
                    if (page.canvasAnnotations[c].id == annotation.id) {
                        page.canvasAnnotations[c] = annotation;

                        // Quickest workaround for annotations involving div layers is to
                        // delete and re-add them again.
                        if (annotation.isSelectableTextType()) {
                            var divs = PageManager.getPageContainer(annotation.pageIndex + 1).find('.canvasWrapper').children('div[id="' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + annotation.oldId + '"]');
                            for (var d=0; d<divs.length; d++) {
                                $(divs[d]).remove();
                            }

                            var pageView = PDFViewerApplication.pdfViewer.getPageView(annotation.pageIndex);
                            page.highlightText(annotation.annotationType, annotation.pageIndex, rotateAngle,
                                PDFViewerApplication.pdfViewer.currentScale, pageView, annotation,
                                annotation.getHighlightTextColor());

                            divs = PageManager.getPageContainer(annotation.pageIndex + 1).find('.canvasWrapper').children('div[id="' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + '"]');
                            for (var d=0; d<divs.length; d++) {
                                $(divs[d]).attr('id', Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + annotation.id);
                            }
                        }
                        else {
                            if (annotation.annotationType == Annotation.TYPE_TEXT) {
                                /**
                                 * Remove from page's canvasAnnotations array since the workaround is to
                                 * remove the annotation from the canvas and re-add it.
                                 */
                                page.canvasAnnotations.splice(c, 1);
                                $('#' + Default.ANNOTATION_ID_PREFIX_FREE_TEXT + annotation.id).remove();
                                page.addText(annotation, rotateAngle, PDFViewerApplication.pdfViewer.currentScale,
                                    true, true, true);
                            }
                            else if (annotation.isFormField()) {
                                page.canvasAnnotations.splice(c, 1);
                                $('#forms' + annotation.id).remove();
                                page.addFormField(annotation, rotateAngle, PDFViewerApplication.pdfViewer.currentScale,
                                    true, true, true);
                            }
                            page.invalidate();
                        }

                        break;
                    }
                }
                break;
            }
        }

        if (!updateCanvasAnnotations) {
            PageManager.insertAnnotationToCanvas(annotation);
        }
    }
    else if (annotation.modified == 'delete') {
        Annotationeer.deleteAnnotation(annotation, false, true);
    }
    else if (annotation.modified == 'insert' || annotation.modified == '') {

        /**
         * Since this involves syncing, user code might call this function redundantly so
         * the best solution to avoid duplication is to check the annotations array to see
         * if it exists.
         */
        for (var a=0; a<annotations.length; a++) {
            if (annotations[a].id == annotation.id) {
                return;
            }
        }

        PageManager.insertAnnotationToCanvas(annotation);
    }

    /**
     * By default, we add this to the selected annotation array since if there is a change in annotation
     * behavior, this will happen if the annotation is first selected.
     */
	PageManager.addSelectedAnnotation(annotation);
};

/**
 * <p>This is a convenience function that is used by updateAnnotationToCanvas() to
 * avoid re-writing blocks of code within the if conditions.</p>
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 */
PageManager.insertAnnotationToCanvas = function(annotation) {

    var page = pages[Default.canvasIdName + (annotation.pageIndex + 1)];

    // If page is not yet created during sync, do nothing.
    if (!page) {
        return;
    }

    switch (annotation.annotationType) {
        case Annotation.TYPE_TEXT_HIGHLIGHT:
        case Annotation.TYPE_TEXT_UNDERLINE:
        case Annotation.TYPE_TEXT_STRIKE_THROUGH:
            var pageView = PDFViewerApplication.pdfViewer.getPageView(annotation.pageIndex);
            page.highlightText(annotation.annotationType, annotation.pageIndex, rotateAngle,
                PDFViewerApplication.pdfViewer.currentScale, pageView, annotation,
                annotation.getHighlightTextColor());

            var divs = PageManager.getPageContainer(annotation.pageIndex + 1).find('.canvasWrapper').children('div[id="' + Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + '"]');
            for (var d=0; d<divs.length; d++) {
                $(divs[d]).attr('id', Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT + annotation.id);
            }

            annotations.push(annotation);
			PageManager.updateAnnotationListAfterSave(annotation, false, true);
            break;
        case Annotation.TYPE_TEXT:
            page.addText(annotation, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, true, true, true);
            break;
        case Annotation.TYPE_FORM_TEXT_FIELD:
            page.addFormField(annotation, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, true, true, true);
            break;
        default:
            page.addAnnotation(annotation, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, false, true, true);
            page.invalidate();
            break;
    }
}

/**
 * Activate page color picker mode.
 * @function
 * @memberof PageManager
 */
PageManager.pageColorPickerMode = function() {
    if ($('#toggleDraw').hasClass('toggled')) {
        resetVar();
    }
    else {
        resetVar();
        $('#togglePageColorPicker').addClass('toggled');
    }
};

/**
 * Stops page color picker mode.
 * @function
 * @memberof PageManager
 */
PageManager.resetPageColorPickerMode = function() {
    $('#togglePageColorPicker').removeClass('toggled');
};

/**
 * This is the function that gets called once the color picker is clicked anywhere in the PDF canvas page.
 * @function
 * @memberof PageManager
 * @param {number} pageIndex The page index.
 * @param {decimal} x The x coordinate.
 * @param {decimal} y The y coordinate.
 * @returns {string}
 */
PageManager.getPageColor = function(pageIndex, x, y) {
    var canvas = $('#page' + (pageIndex + 1));

    if (canvas.length == 0)
        return;

    var img_data = canvas[0].getContext('2d').getImageData(x, y, 1, 1).data;
    var R = img_data[0];
    var G = img_data[1];
    var B = img_data[2];
    return R + ',' + G + ',' + B;
};

PageManager.convertColor = function(color) {
    // Place your overridden code in override.js.
};

/**
 * Helper methods to get the correct page width at 0 degrees rotation.
 * @function
 * @memberof PageManager
 * @param {number} width The width of the page.
 * @param {number} height The height of the page.
 * @returns {number}
 */
PageManager.getPageWidth = function(width, height) {
    return rotateAngle == 90 || rotateAngle == 270 ? height : width;
};

/**
 * Helper methods to get the correct page height at 0 degrees rotation.
 * @function
 * @memberof PageManager
 * @param {number} width The width of the page.
 * @param {number} height The height of the page.
 * @returns {number}
 */
PageManager.getPageHeight = function(width, height) {
    return rotateAngle == 90 || rotateAngle == 270 ? width : height;
};

/**
 * Enable or disable the annotation toolbar.
 * @function
 * @memberof PageManager
 * @param {string} state Values are <strong>enabled</strong> or <strong>disabled</strong>.
 */
PageManager.setAnnotationToolbarState = function(state) {
    if (state == 'enabled')
        $('#toolbarAnnotations :button').removeAttr('disabled');
    else
        $('#toolbarAnnotations :button').attr('disabled', 'disabled');
};

/**
 * Show or hide all annotations.
 * @function
 * @memberof PageManager
 */
PageManager.showHideAnnotations = function() {
    if ($('#show_hide img').attr('src').indexOf('eye_hide') > -1) {
        // Hide all annotations
        $('#show_hide img').attr('src', 'images/eye_show.svg');
        $('#show_hide').attr('title', 'Show all annotations');

        for (var a=0; a<annotations.length; a++) {
            annotations[a].hidden = true;
        }

        for (var p in pages) {
            if (!pages.hasOwnProperty(p))
                continue;

            for (var c=0; c<pages[p].canvasAnnotations.length; c++) {
                pages[p].canvasAnnotations[c].hidden = true;
            }
            pages[p].invalidate();
        }
    }
    else {
        // Show all annotations
        $('#show_hide img').attr('src', 'images/eye_hide.svg');
        $('#show_hide').attr('title', 'Hide all annotations');

        for (var a=0; a<annotations.length; a++) {
            annotations[a].hidden = false;
        }

        for (var p in pages) {
            if (!pages.hasOwnProperty(p))
                continue;

            for (var c=0; c<pages[p].canvasAnnotations.length; c++) {
                pages[p].canvasAnnotations[c].hidden = false;
            }
            pages[p].invalidate();
        }
    }

    PageManager.refreshAnnotationList();
};

/**
 * This function is called from the Angular JS sidebar annotation list.
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 */
PageManager.showHideAnnotation = function(annotation) {
    for (var a=0; a<annotations.length; a++) {
        if (annotations[a].id == annotation.id) {
            annotations[a].hidden = annotation.hidden;
            break;
        }
    }

    var page = pages[Default.canvasIdName + (annotation.pageIndex + 1)];
    for (var c=0; c<page.canvasAnnotations.length; c++) {
        if (page.canvasAnnotations[c].id == annotation.id) {
            page.canvasAnnotations[c].hidden = annotation.hidden;
            break;
        }
    }

    page.invalidate();
};

/**
 * <p>This will show either the alert using the browser's native function or the 3rd party
 * library called Toastr if Default.ALERT_BEAUTIFY = true.</p>
 * @function
 * @memberof PageManager
 * @param {string} message The alert message.
 * @param {string} type If alert type is success, error, info.
 */
PageManager.showAlert = function(message, type) {
    if (!message)
        return;

    if (Default.ALERT_BEAUTIFY) {
        toastr.options.preventDuplicates = true;
        toastr.options.timeOut = 1500;

        var dir = document.documentElement.getAttribute('dir');
        toastr.options.positionClass = dir == 'ltr' ? 'toast-top-right' : 'toast-top-left';

        if (type == 'success')
            toastr.success(message);
        else if (type == 'error')
            toastr.error(message);
        else
            toastr.info(message);
    }
    else
        alert(message);
};

/**
 * Show confirm dialog.
 * @function
 * @memberof PageManager
 * @param {string} message The message of the dialog.
 * @param {string} callback The callback function to execute if not null.
 * @returns {string} The result action of the confirm dialog.
 */
PageManager.showConfirm = function(message, callback) {
    if (!message)
        return;

    if (Default.ALERT_BEAUTIFY) {
        $('#confirmContainer').removeClass('hidden');
        $('#confirmContainer #message').html(message);
        $('#confirmContainer').remodal({
            closeOnConfirm: false,
            closeOnOutsideClick: false
        }).open();

        $(document).on('click', '.remodal-confirm', function() {
            $('#confirmContainer').remodal().close();
            $(document).off('click', '.remodal-confirm');

            if (Util.isFunction(callback))
                callback();
        });
    }
    else
        return confirm(message);
};

PageManager.showDigitalSignatureChooser = function(button) {
    if ($(button).hasClass('toggled')) {
        resetVar();
        return;
    }

	PageManager.resetAllToggles();
	PageManager.closeAllDropDown();
    $(button).addClass('toggled');

    if ($('#digitalSignatureList').hasClass('show')) {
        resetVar();
        $('#digitalSignatureList').removeClass('show');
    }
    else {
		PageManager.ensureSignatureListIsOnScreen();
    }

};

PageManager.ensureSignatureListIsOnScreen = function() {
    $('#digital_signature').addClass('toggled');
    $('#digitalSignatureList').addClass('show');
    $("#digitalSignatureList").scrollTop(0);

    // Remove left/right css property.
    $("#digitalSignatureList").css({ 'left': '', 'right': ''});

    if (Util.isElementOffRightScreen($('#digitalSignatureList')))
        $("#digitalSignatureList").css('right', 0);
    else if (Util.isElementOffLeftScreen($('#digitalSignatureList')))
        $("#digitalSignatureList").css('left', 0);
};

/**
 * Shows the digital signature form.
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 */
PageManager.showDigitalSignaturePad = function(annotation) {
    $('#digitalSignatureList').removeClass('show');
    angular.element($('#digitalSignatureContainer')).scope().showDigitalSignaturePad(annotation);
};

/**
 * Add the digital signature to the list once saved by the user.
 * @function
 * @memberof PageManager
 * @param {object} ds The digital signature object.
 */
PageManager.addDigitalSignatureToList = function(ds) {
    var displayMaxWidth = 70;
    var displayMaxHeight = 20;

    var prefix = ds.signature.substring(0, 26);
    var suffix = window.atob(ds.signature.substring(26));

    var sig = suffix
        // This is to support old svg tags that used the signature_pad library.
        .replaceAll('stroke="black"', 'stroke="#cccccc"')
        .replace(/stroke=\"([^\"]*)\"/g, 'stroke="#cccccc"');

    if (sig.indexOf('viewBox') == -1)
        // Add viewBox attribute since IE does not display this correctly without it.
        sig = sig.replaceAll('width=', 'viewBox="0 0 ' + ds.width + ' ' + ds.height + '" width=');

    var li = '<li id="' + ds.id + '"><a onclick="Annotationeer.deleteDigitalSignature(' + ds.id + ')"><img src="images/delete.svg" height="16"/></a>' +
        '<a onclick="PageManager.createAnnotation($(\'#digital_signature\'), Annotation.TYPE_DIGITAL_SIGNATURE, \'' + ds.signature +
        '\', ' + ds.width + ', ' + ds.height + ')">' +
        '<img src="' + prefix + window.btoa(sig)  + '" width="' + (ds.width > displayMaxWidth ? displayMaxWidth : ds.width) +
        '" height="' + (ds.height > displayMaxHeight ? displayMaxHeight : ds.height) + '"/></a></li>';
    $('#digitalSignatureList').append(li);
};

/**
 * Add a custom stamp to the list after upload.
 * @function
 * @memberof PageManager
 * @param {number} id The id of the stamp.
 * @param {string} stamp The custom image.
 * @param {number} width The width of the stamp image.
 * @param {number} height The height of the stamp image.
 */
PageManager.addStampToList = function(id, stamp, width, height) {
    var displayMaxWidth = 60;
    var displayMaxHeight = 20;

    var li = '<li id="' + id + '"><a onclick="Annotationeer.deleteStamp(' + id + ')"><img src="images/delete.svg" height="16"/></a>' +
        '<a onclick="PageManager.createAnnotation($(\'#stamp\'), Annotation.TYPE_STAMP, \'' + stamp + '\', ' + width + ', ' +
        height + ')">' + '<img src="' + stamp + '" width="' + (width > displayMaxWidth ? displayMaxWidth : width) +
        '" height="' + (height > displayMaxHeight ? displayMaxHeight : height) + '"/></a></li>';
    $(li).insertAfter($('#stampList').children(':first'));
};

/**
 * This is a helper function that draws annotations in the canvas' context given.
 * @function
 * @memberof PageManager
 * @param {object} context The canvas context.
 * @param {object} pdfPageViewPort The PDF.JS page viewport..
 * @param {Array<Annotation>} annotations The annotations that belong to this page.
 */
PageManager.drawAnnotationsInCanvas = function(context, pdfPageViewPort, annotations) {
    if (!annotations)
        return null;

    //var correctWidth = pdfPageViewPort.rotation == 90 || pdfPageViewPort.rotation == 270 ? pdfPageViewPort.height : pdfPageViewPort.width;
    //var correctHeight = pdfPageViewPort.rotation == 90 || pdfPageViewPort.rotation == 270 ? pdfPageViewPort.width : pdfPageViewPort.height;
    var portWidth = Math.round(pdfPageViewPort.width / pdfPageViewPort.scale);
    var portHeight = Math.round(pdfPageViewPort.height / pdfPageViewPort.scale);
    var correctWidth = (rotateAngle == 0 || rotateAngle == 180) ? portWidth : portHeight;
    var correctHeight = (rotateAngle == 0 || rotateAngle == 180) ? portHeight : portWidth;

    // This will be used by the watermark as basis on how big it will be drawn.
    var canvas = $('<canvas></canvas>');
    canvas.attr('width', correctWidth);
    canvas.attr('height', correctHeight);
    canvas.css('z-index', '' + Default.zIndex);

    for (var a=0; a<annotations.length; a++) {
        var newBounds = Util.getNewPosition(annotations[a].origX, annotations[a].origY, annotations[a].origW, annotations[a].origH,
            annotations[a].pageWidth, annotations[a].pageHeight, correctWidth, correctHeight);

        annotations[a].x = newBounds.x;
        annotations[a].y = newBounds.y;
        annotations[a].w = newBounds.width;
        annotations[a].h = newBounds.height;

        // If circle annotation, ensure these variables are all zeros so that the x, y, w, h variables will be used
        // to render the shape.
        annotations[a].circleStartX = 0;
        annotations[a].circleStartY = 0;
        annotations[a].circleLastX = 0;
        annotations[a].circleLastY = 0;

        // If annotation type involves points.
        if (annotations[a].drawingPositions.length > 0) {
            for (var dp=0; dp<annotations[a].drawingPositions.length; dp++) {
                var newPoints = Util.getNewPosition(annotations[a].drawingPositions[dp].origX,
                    annotations[a].drawingPositions[dp].origY, 1, 1,
                    annotations[a].pageWidth, annotations[a].pageHeight, correctWidth, correctHeight);

                annotations[a].drawingPositions[dp].x = newPoints.x;
                annotations[a].drawingPositions[dp].y = newPoints.y;
            }
        }

        // If annotation type involves highlight text rectangles.
        if (annotations[a].highlightTextRects.length > 0) {
            for (var htr=0; htr<annotations[a].highlightTextRects.length; htr++) {
                var newRect = Util.getNewPosition(annotations[a].highlightTextRects[htr].origLeft,
                    annotations[a].highlightTextRects[htr].origTop,
                    annotations[a].highlightTextRects[htr].origWidth,
                    annotations[a].highlightTextRects[htr].origHeight,
                    annotations[a].pageWidth, annotations[a].pageHeight, correctWidth, correctHeight);

                annotations[a].highlightTextRects[htr].left = newRect.x;
                annotations[a].highlightTextRects[htr].top = newRect.y;
                annotations[a].highlightTextRects[htr].right = newRect.x + newRect.width;
                annotations[a].highlightTextRects[htr].bottom = newRect.y + newRect.height;
                annotations[a].highlightTextRects[htr].width = newRect.width;
                annotations[a].highlightTextRects[htr].height = newRect.height;
            }
        }

        annotations[a].draw(context, 0, 1, true);
    }

    return canvas[0];
};

/**
 * <p>This helper function creates a div layer presentation of the free text annotation at scale value
 * of 2 and rotation value 0. The reason why scale value is 2 (200%) is because the PDF.JS print
 * preview scales it to 200% so we have to draw this at scale value 2 to make it the same size as
 * the PDF.JS page considering we do no scaling when free text is displayed in print preview.</p>
 *
 * <p>Using DOM-to-Image library, the output will be an svg and will be set as an icon of the
 * annotation object. This is manily used for print preview purposes since free text
 * annotation is the only type to be DOM based instead of canvas.</p>
 * @function
 * @memberof PageManager
 */
PageManager.setFreeTextImageToAnnotation = function(annotation, id) {
    if (annotation.annotationType != Annotation.TYPE_TEXT || !annotation.setIconSource)
        return;

    var el = document.createElement('div');

    var rgbColor = Util.hexToRgb(annotation.backgroundColor);
    var background = 'rgba(' + rgbColor.r + ', ' + rgbColor.g + ', ' + rgbColor.b + ', ' + Default.FILL_OPACITY + ')';

    // No idea why but x 2 on width and height seems to do the trick.
    el.setAttribute('style', 'white-space: nowrap; position: relative; color: ' + annotation.color + '; ' +
        'background:' + background + '; ' + 'z-index: -99; width:' + (annotation.origW * 2) + 'px; height:' + (annotation.origH * 2) + 'px;' +
        'display: inline-block; font:' + (annotation.fontSize * 2) + Default.FONT_SIZE_TYPE + ' ' + Default.FONT_TYPE);
    el.setAttribute('id', id);
    el.innerHTML = annotation.text;

    $('#pageAnnotation' + (annotation.pageIndex + 1)).parent().append(el);

    domtoimage.toSvg(el).then(function(dataUrl) {
        annotation.setIconSource(dataUrl);
        $(el).remove();
    });
};

/**
 * Remove annotation toolbar.
 * @function
 * @memberof PageManager
 */
PageManager.removeAnnotationToolbar = function() {
    var toolbar = $('.toolbar');
    var toolbarAnnotations = $('#toolbarAnnotations');
    var toolbarContainer = $('#toolbarContainer');
    var viewerContainer = $('#viewerContainer');

    toolbar.css('height', toolbar.height() - toolbarAnnotations.height());
    toolbarContainer.style('height', (toolbarContainer.height() - toolbarAnnotations.height()) + 'px', 'important');
    viewerContainer.style('top', (parseInt(viewerContainer.css('top')) - toolbarAnnotations.height()) + 'px', 'important');
    toolbarAnnotations.remove();

    // Based on code in the resize sensor.
    var height = toolbarContainer[0].clientHeight;
    if (!Annotationeer.isPDFJSVersion2Plus()) {
        height = $('#outerContainer')[0].clientWidth <= 840 ? toolbarContainer[0].clientHeight : 0;
    }
    $('#sidebarContainer').css('cssText', 'top: ' + height + 'px !important;');
};

/**
 * Show or hide annotation toolbar.
 * @function
 * @memberof PageManager
 */
PageManager.showHideAnnotationToolbar = function() {
    var toolbar = $('.toolbar');
    var toolbarAnnotations = $('#toolbarAnnotations');
    var visible = toolbarAnnotations.is(':visible');
    var toolbarContainer = $('#toolbarContainer');
    var viewerContainer = $('#viewerContainer');
    var toolbarHeight = visible ? toolbarAnnotations.height() : -toolbarAnnotations.height();

    toolbar.css('height', toolbar.height() - toolbarHeight);
    // Setting css visibility and checking using is(':visible') does not work.
    visible ? toolbarAnnotations.hide() : toolbarAnnotations.show();
    toolbarContainer.style('height', (toolbarContainer.height() - toolbarHeight) + 'px', 'important');
    viewerContainer.style('top', (parseInt(viewerContainer.css('top')) - toolbarHeight) + 'px', 'important');

    var height = toolbarContainer[0].clientHeight;
    if (!Annotationeer.isPDFJSVersion2Plus()) {
        height = $('#outerContainer')[0].clientWidth <= 840 ? toolbarContainer[0].clientHeight : 0;
    }
    $('#sidebarContainer').css('cssText', 'top: ' + height + 'px !important;');
};

/**
 * This is a helper function that shows the context menu items within the toolbar for touch devices.
 * @function
 * @memberof PageManager
 * @param {boolean} show
 */
PageManager.displayContextMenuForMobile = function(show) {
    if (show) {
        if (PageManager.selectedAnnotations[0].hasEditableProperties())
            $('button#settings').removeClass('hidden');

        if (PageManager.selectedAnnotations[0].canContainComments() && !PageManager.selectedAnnotations[0].readOnly &&
			PageManager.selectedAnnotations[0].isRootCommentEditable()) {
            $('button#edit').removeClass('hidden');
            $('button#comment_history').removeClass('hidden');
        }

        if (PageManager.selectedAnnotations[0].canContainComments() && !PageManager.selectedAnnotations[0].readOnlyComment)
            $('button#reply').removeClass('hidden');

        if (!PageManager.selectedAnnotations[0].isReadOnly())
            $('button#delete').removeClass('hidden');
    }
    else {
        $('button#settings').addClass('hidden');
        $('button#comment_history').addClass('hidden');
        $('button#edit').addClass('hidden');
        $('button#reply').addClass('hidden');
        $('button#delete').addClass('hidden');
    }
};

/**
 * <p>This function exists because since PDF.JS 1.7, the pageContainer# id does not exist
 * anymore. It is now replaced with data-page-number attribute so this functions aims
 * to make Annotationeer work for users using pre and post 1.7 versions.</p>
 * @function
 * @memberof PageManager
 * @param {number} pageNumber
 * @returns {object} A JQuery|HTMLElement
 */
PageManager.getPageContainer = function(pageNumber) {
    var div = $('#pageContainer' + pageNumber);
    return div.length > 0 ? div : $('div.page[data-page-number=' + pageNumber + ']');
};

/**
 * Show the add stamp form.
 * @function
 * @memberof PageManager
 */
PageManager.showAddStamp = function() {
    var uploadStampContainer = $('#uploadStampContainer');
    uploadStampContainer.removeClass('hidden');
    uploadStampContainer.find('button.remodal-close').removeClass('disabled');
    uploadStampContainer.find('button.remodal-close').removeAttr('disabled');
    uploadStampContainer.remodal().open();
};

/**
 * <p>This function is now moved here so that it can be re-used for other purposes like printing.</p>
 * @function
 * @memberof PageManager
 * @param {object} canvas The canvas object.
 * @param {decimal} scale The current scale value.
 * @param {number} angle The current rotation value.
 */
PageManager.drawWatermarkOnCanvas = function(canvas, scale, angle) {
    if (!PageManager.watermarkText)
        return;

    if (PageManager.watermarkText.length == 0) {
        PageManager.watermarkText.push('Annotationeer');
        PageManager.watermarkText.push('Company Name');
        PageManager.watermarkText.push('Copyright 2015');
    }

    if (PageManager.watermarkText.length > 3) {
        PageManager.watermarkText.splice(3);
        return;
    }

    var context = canvas.getContext('2d');
    context.save();

    var fontSize = Default.WATERMARK_FONT_SIZE * scale;
    context.font = fontSize + 'pt ' + Default.WATERMARK_FONT_TYPE;
    context.fillStyle = 'rgba(0, 0, 0, 0.1)';
    context.textBaseline = 'alphabetic';

    var textHeight = fontSize;
    var extraSpaceOfFont;
    var lineSpacing = fontSize;
    var totalLineHeight = 0;

    for (var i=PageManager.watermarkText.length-1; i>=0; i--) {
        extraSpaceOfFont = Page.prototype.getTextHeight(context.font, PageManager.watermarkText[i]);
        totalLineHeight += textHeight + extraSpaceOfFont.height;

        if (i != PageManager.watermarkText.length - 1)
            totalLineHeight += lineSpacing;
    }

    // This is the original code block for displaying multi line text horizontally without translate() and rotate()
    //var y = ((canvas.height - totalLineHeight) / 2) + (textHeight / 2);
    var gap = textHeight / 2;

    if (Default.WATERMARK_ORIENTATION == WatermarkOrientation.CENTER_VERTICAL) {
        context.rotate((90 + angle) * Math.PI / 180);

        for (var i=PageManager.watermarkText.length-1; i>=0; i--) {
            var x = 0;
            var y = 0;

            if (angle == 0) {
                x = (canvas.height - context.measureText(PageManager.watermarkText[i]).width) / 2;
                y = -((canvas.width - totalLineHeight) / 2) - gap;
            }
            else if (angle == 90) {
                x = -(canvas.width + context.measureText(PageManager.watermarkText[i]).width) / 2;
                y = -((canvas.height - totalLineHeight) / 2) - gap;
            }
            else if (angle == 180) {
                x = -(canvas.height + context.measureText(PageManager.watermarkText[i]).width) / 2;
                y = ((canvas.width + totalLineHeight) / 2) - gap;
            }
            else if (angle == 270) {
                x = (canvas.width - context.measureText(PageManager.watermarkText[i]).width) / 2;
                y = ((canvas.height + totalLineHeight) / 2) - gap;
            }

            context.fillText(PageManager.watermarkText[i], x, y);
            extraSpaceOfFont = Page.prototype.getTextHeight(context.font, PageManager.watermarkText[i]);
            gap += textHeight + lineSpacing + extraSpaceOfFont.height;
        }
    }
    else if (Default.WATERMARK_ORIENTATION == WatermarkOrientation.CENTER_DIAGONAL) {
        context.save();
        context.translate(canvas.width / 2, canvas.height / 2);
        context.rotate((angle + 60) * Math.PI / 180);

        for (var i=PageManager.watermarkText.length-1; i>=0; i--) {
            var x = -(context.measureText(PageManager.watermarkText[i]).width) / 2;
            var y = -(totalLineHeight / 2) + gap;

            context.fillText(PageManager.watermarkText[i], x, y);
            extraSpaceOfFont = Page.prototype.getTextHeight(context.font, PageManager.watermarkText[i]);
            gap += textHeight + lineSpacing + extraSpaceOfFont.height;
        }

        context.restore();
    }
    else if (Default.WATERMARK_ORIENTATION == WatermarkOrientation.UPPER_LEFT_HORIZONTAL) {
        context.rotate(angle * Math.PI / 180);

        for (var i=PageManager.watermarkText.length-1; i>=0; i--) {
            var x = 0;
            var y = 0;

            if (angle == 0) {
                x = 1;
                y = textHeight + gap;
            }
            else if (angle == 90) {
                x = 1;
                y = -(canvas.width - textHeight - gap);
            }
            else if (angle == 180) {
                x = -canvas.width;
                y = -(canvas.height - textHeight - gap);
            }
            else if (angle == 270) {
                x = -canvas.height;
                y = textHeight + gap;
            }

            context.fillText(PageManager.watermarkText[i], x, y);
            extraSpaceOfFont = Page.prototype.getTextHeight(context.font, PageManager.watermarkText[i]);
            // If you wish to add spacing between text, use lineSPacing variable and add it.
            gap += textHeight + extraSpaceOfFont.height;
        }
    }
    else if (Default.WATERMARK_ORIENTATION == WatermarkOrientation.UPPER_RIGHT_HORIZONTAL) {
        context.rotate(angle * Math.PI / 180);

        for (var i=PageManager.watermarkText.length-1; i>=0; i--) {
            var x = 0;
            var y = 0;

            if (angle == 0) {
                x = canvas.width - context.measureText(PageManager.watermarkText[i]).width;
                y = textHeight + gap;
            }
            else if (angle == 90) {
                x = canvas.height - context.measureText(PageManager.watermarkText[i]).width;
                y = -(canvas.width - textHeight - gap);
            }
            else if (angle == 180) {
                x = -context.measureText(PageManager.watermarkText[i]).width;
                y = -(canvas.height - textHeight - gap);
            }
            else if (angle == 270) {
                x = -context.measureText(PageManager.watermarkText[i]).width;
                y = textHeight + gap;
            }

            context.fillText(PageManager.watermarkText[i], x, y);
            extraSpaceOfFont = Page.prototype.getTextHeight(context.font, PageManager.watermarkText[i]);
            gap += textHeight + extraSpaceOfFont.height;
        }
    }

    context.restore();
};

/**
 * <p>This is the only workaround I can find where one does not need to place a lot of code within viewer.js
 * to make the print preview feature work. Just call this function within the canvas.mozPrintCallback() call
 * inside the promise just before obj.done() is called.</p>
 * @function
 * @memberof PageManager
 * @param {object} ctx The context from PDF.JS rendering.
 * @param {number} pageIndex The page index of the page.
 * @param {object} scaleRenderContext If not null, scale the context to make annotation renderings in sync.
 */
PageManager.printPreviewPage = function(ctx, pageIndex, scaleRenderContext) {
    var canvasAnnotations = [];
    for (var a=0; a<annotations.length; a++) {
        if (annotations[a].pageIndex == pageIndex && annotations[a].modified != 'delete'){
            // -chnaged to below-    ***One Line commented and other is un-commented***
            // ahmad
            // -----START-----
            canvasAnnotations.push(jQuery.extend(true, {}, annotations[a]));
            // -----END-----
            //canvasAnnotations.push(Annotation.clone(annotations[a]));
        }
    }

    ctx.save();
    if (rotateAngle) {
        var cw = ctx.canvas.width / 2, ch = ctx.canvas.height / 2;
        ctx.translate(cw, ch);
        ctx.rotate(rotateAngle * Math.PI / 180);
        if (rotateAngle == 180)
            ctx.translate(-cw, -ch);
        else
            ctx.translate(-ch, -cw);
    }

    if (scaleRenderContext) {
        ctx.scale(scaleRenderContext, scaleRenderContext);
    }

    var pdfPageView = PDFViewerApplication.pdfViewer.getPageView(pageIndex);
    var viewport = pdfPageView.viewport;
    var canvas = PageManager.drawAnnotationsInCanvas(ctx, viewport, canvasAnnotations);

    if (Default.WATERMARK_SHOW)
        PageManager.drawWatermarkOnCanvas(canvas, pdfPageView.scale / viewport.scale, 0);

    ctx.drawImage(canvas, 0, 0);
    ctx.restore();
};

/**
 * @function
 * @memberof PageManager
 * @param {string} what What to show in the sidebar. E.g. bookmark, thumbnail, annotations.
 */
PageManager.showInSidebar = function(what) {
    $('div#toolbarSidebar button').each(function() {
        $(this).removeClass('toggled');
    });

    $('div#sidebarContent > div').each(function() {
        $(this).addClass('hidden');
    });

    if (!what)
        return;
    if (what == 'annotations') {
        // Sometimes this works. Sometimes it does not. Workaround is to wrap this inside a setTimeout().
        if ($('div#sidebarContent div#annotationListContainer').length == 0)
            $('div#annotationListContainer').detach().appendTo($('div#annotationsView')).removeClass('hidden');

        $('div#annotationsView').removeClass('hidden');
        $('button#viewAnnotations').addClass('toggled');
    }
    else if (what == 'bookmarks') {
        if ($('div#bookmarksView div#bookmarkListContainer').length == 0)
            $('div#bookmarkListContainer').detach().appendTo($('div#bookmarksView')).removeClass('hidden');

        $('div#bookmarksView').removeClass('hidden');
        $('button#viewBookmarks').addClass('toggled');
    }
};

/**
 * This function is mainly used to get the icon to be displayed in the sidebar list.
 * @function
 * @memberof PageManager
 */
PageManager.populateAnnotationTypesArray = function() {
    PageManager.annotationTypes = [
        new AnnotationType(Annotation.TYPE_AUDIO, 'audio.svg'),
        new AnnotationType(Annotation.TYPE_HIGHLIGHT, 'highlight.svg'),
        new AnnotationType(Annotation.TYPE_BOX, 'box.svg'),
        new AnnotationType(Annotation.TYPE_DRAWING, 'pencil.svg'),
        new AnnotationType(Annotation.TYPE_TEXT_HIGHLIGHT, 'text_highlight.svg'),
        new AnnotationType(Annotation.TYPE_TEXT, 'text.svg'),
        new AnnotationType(Annotation.TYPE_TEXT_UNDERLINE, 'text_underline.svg'),
        new AnnotationType(Annotation.TYPE_TEXT_STRIKE_THROUGH, 'text_strike_through.svg'),
        new AnnotationType(Annotation.TYPE_STICKY_NOTE, 'comment.svg'),
        new AnnotationType(Annotation.TYPE_CIRCLE_FILL, 'circle_fill.svg'),
        new AnnotationType(Annotation.TYPE_CIRCLE_STROKE, 'circle_stroke.svg'),
        new AnnotationType(Annotation.TYPE_STAMP, 'stamp.svg'),
        new AnnotationType(Annotation.TYPE_ARROW, 'arrow.svg'),
        new AnnotationType(Annotation.TYPE_MEASUREMENT_DISTANCE, 'measurement_distance.svg'),
        new AnnotationType(Annotation.TYPE_MEASUREMENT_AREA, 'measurement_area.svg'),
        new AnnotationType(Annotation.TYPE_FORM_TEXT_FIELD, 'text_field.svg'),
        new AnnotationType(Annotation.TYPE_FORM_CHECKBOX, 'checkbox.svg'),
        new AnnotationType(Annotation.TYPE_FORM_RADIO_BUTTON, 'radio_button.svg'),
        new AnnotationType(Annotation.TYPE_FORM_BUTTON, 'button.svg'),
        new AnnotationType(Annotation.TYPE_FORM_TEXT_AREA, 'text_area.svg'),
        new AnnotationType(Annotation.TYPE_FORM_COMBO_BOX, 'combo_box.svg'),
        new AnnotationType(Annotation.TYPE_FORM_BUTTON, 'button.svg'),
        new AnnotationType(Annotation.TYPE_HYPERLINK, 'hyperlink.svg'),
        new AnnotationType(Annotation.TYPE_DIGITAL_SIGNATURE, 'digital_signature.svg'),
        new AnnotationType(Annotation.TYPE_LINE, 'line.svg'),
        new AnnotationType(Annotation.TYPE_POLY_LINE, 'poly_line.svg'),
        new AnnotationType(Annotation.TYPE_POLYGON, 'polygon.svg'),
        new AnnotationType(Annotation.TYPE_CLOUD, 'cloud.svg'),
        new AnnotationType(Annotation.TYPE_TEXT_INSERT, 'text_insert.svg'),
        new AnnotationType(Annotation.TYPE_TEXT_REPLACE, 'text_replace.svg')
    ];
};

/**
 * Returns the annotation by annotation type id.
 * @function
 * @memberof PageManager
 * @param {number} id The annotation type id.
 * @returns {Annotation}
 */
PageManager.getAnnotationTypeById = function(id) {
    if (!PageManager.annotationTypes)
        return null;

    for (var at=0; at<PageManager.annotationTypes.length; at++) {
        if (PageManager.annotationTypes[at].id == id)
            return PageManager.annotationTypes[at];
    }

    return null;
};

/**
 * The logic is the same as the screenshot but returns the whole page instead. The scale value is always set to 1.
 * I do not know how to make it work using current scale value.
 * @function
 * @memberof PageManager
 */
PageManager.capturePage = function() {
    PDFViewerApplication.pdfDocument.getPage(PDFViewerApplication.pdfViewer.currentPageNumber).then(function(page) {
        // change true|false if scale is more than threshold, always set to threshold limit
        var retainAspectRatioRegardlessOfScale = true;
        var threshold = 1;
        var thresholdScaleValue = 1;

        var scale = 1;
        var viewport = page.getViewport(scale);
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };

        canvas.height = viewport.height;
        canvas.width = viewport.width;

        page.render(renderContext).then(function() {
            if (Default.SCREENSHOT_INCLUDE_ANNOTATIONS)
                PageManager.printPreviewPage(ctx, PDFViewerApplication.pdfViewer.currentPageNumber - 1, scale);

            Annotationeer.saveCapturePage(canvas);
        });
    });
};

/**
 * Take a screenshot.
 * @function
 * @memberof PageManager
 * @param {Annotation} annotation The annotation object.
 */
PageManager.screenShot = function(annotation) {
    PDFViewerApplication.pdfDocument.getPage(annotation.pageIndex + 1).then(function(page) {
        // change true|false if scale is more than threshold, always set to threshold limit
        var retainAspectRatioRegardlessOfScale = true;
        var threshold = 1;
        var thresholdScaleValue = 1;

        var scale = PDFViewerApplication.pdfViewer.currentScale;

        if (!retainAspectRatioRegardlessOfScale) {
            scale = scale <= threshold ? scale : thresholdScaleValue;
        }

        // re-adjust scale to make it look the same when displayed in pdf.js
        scale += (scale * 0.3);

        var viewport = page.getViewport(scale);
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };

        canvas.height = viewport.height;
        canvas.width = viewport.width;

        var canvasAnnotation = $('#pageAnnotation' + (annotation.pageIndex + 1));
        var diffBetViewportAndCanvasAnnotation = viewport.width / canvasAnnotation.width();

        if (!retainAspectRatioRegardlessOfScale && PDFViewerApplication.pdfViewer.currentScale > 1) {
            diffBetViewportAndCanvasAnnotation = viewport.width / (canvasAnnotation.width() / PDFViewerApplication.pdfViewer.currentScale);
        }

        page.render(renderContext).then(function() {
            var crop_canvas = document.createElement('canvas');
            var left, top, width, height;

            if (retainAspectRatioRegardlessOfScale) {
                crop_canvas.width = annotation.w;
                crop_canvas.height = annotation.h;

                left = annotation.x;
                top = annotation.y;
                width = annotation.w;
                height = annotation.h;
            }
            else {
                crop_canvas.width = scale <= thresholdScaleValue ? annotation.w : annotation.origW;
                crop_canvas.height = scale <= thresholdScaleValue ? annotation.h : annotation.origH;

                left = scale <= thresholdScaleValue ? annotation.x : annotation.origX;
                top = scale <= thresholdScaleValue ? annotation.y : annotation.origY;
                width = scale <= thresholdScaleValue ? annotation.w : annotation.origW;
                height = scale <= thresholdScaleValue ? annotation.h : annotation.origH;
            }

            if (width < 0) {
                left = left + width;
                width = Math.abs(width);
                crop_canvas.width = width;
            }

            if (height < 0) {
                top = top + height;
                height = Math.abs(height);
                crop_canvas.height = height;
            }

            // Add annotations to canvas page.
            if (Default.SCREENSHOT_INCLUDE_ANNOTATIONS)
                PageManager.printPreviewPage(ctx, annotation.pageIndex, scale);

            crop_canvas.getContext('2d').drawImage(canvas,
                left * diffBetViewportAndCanvasAnnotation,
                top * diffBetViewportAndCanvasAnnotation,
                width * diffBetViewportAndCanvasAnnotation,
                height * diffBetViewportAndCanvasAnnotation,
                0, 0,
                width * diffBetViewportAndCanvasAnnotation,
                height * diffBetViewportAndCanvasAnnotation
            );

            resetVar(false, false, page);

            Annotationeer.saveScreenShot(crop_canvas);
        });
    });
};

/**
 * Returns the hand tool reference.
 * @function
 * @memberof PageManager
 * @returns {object}
 */
PageManager.getHandTool = function() {
    return PDFViewerApplication.handTool ? PDFViewerApplication.handTool :
        PDFViewerApplication.pdfCursorTools.handTool;
};

/**
 * Override function so that the browser's context menu will not be  shown in the canvas annotation layer.
 * @function
 * @memberof PageManager
 */
PageManager.hideContextMenu = function() {
    $('canvas[id^="' + Default.canvasIdName + '"]').contextMenu('hide');
};

/**
 * Activates hand tool mode.
 * @function
 * @memberof PageManager
 */
PageManager.handToolMode = function() {
    if (PageManager.getHandTool().active) {
        resetVar();
    }
    else {
        resetVar();
        PageManager.getHandTool().activate();
		PageManager.translateDOML10n($('#aHandTool').addClass('toggled'), 'hand_tool_disable');
		PageManager.translateDOML10n($('#toggleHandToolOverride span'), 'hand_tool_menu_disable');
    }
};

/**
 * <p>Originally we called .focus() and .click() but since it does not work in iOS mobile browsers,
 * we shifted to using .trigger() instead.</p>
 * @function
 * @memberof PageManager
 */
PageManager.openColorPicker = function(what) {
    if (what == 'background') {
        $('#backgroundPalette').trigger('focus');
        $('#backgroundPalette').trigger('click');
    }
    else {
        $('#colorPalette').trigger('focus');
        $('#colorPalette').trigger('click');
    }
};

/**
 * <p>This function will use PDF.JS' L10n reference to translate key value pair when key is set to a
 * new value.</p>
 * @function
 * @memberof PageManager
 * @param {object} element The element to assign the translation to.
 * @param {object} key The key of the translation.
 */
PageManager.translateDOML10n = function(element, key) {
    var el = element instanceof jQuery ? element[0] : element;

    if (!el)
        return;
    el.setAttribute('data-l10n-id', key);

    if (PDFViewerApplication.l10n)
        return PDFViewerApplication.l10n.translate(el);
};

/**
 * <p>A Convenience method to iterate through each element's children that have the data-l10n-id attribute
 * and get the translation.</p>
 * @function
 * @memberof PageManager
 * @param {object} elementObject Any DOM element.
 */
PageManager.translateEachL10n = function(elementObject) {
	var element = elementObject instanceof jQuery ? elementObject : $(elementObject);

	var promises = [];
	element.find('[data-l10n-id]').each(function(index, el) {
		promises.push(PageManager.translateDOML10n(el, el.getAttribute('data-l10n-id')));
	});

	return Promise.all(promises);
};

/**
 * <p>Scroll to the annotation and select it in the annotation list side bar.
 * Not using the $fn.scrollTo from util.js since it does not correctly
 * show the selected annotation in the sidebar when the sidebar container
 * is located below the annotation toolbar.</p>
 * @function
 * @memberof PageManager
 * @param {Annotation} The annotation object.
 */
 PageManager.scrollToAnnotationInList = function(annotation) {
     // https://stackoverflow.com/questions/11039885/scrollintoview-causing-the-whole-page-to-move/11041376
   if (annotation.selected && $('#annotationList').is(':visible')) {
          var el = PageManager.getAnnotationListRowElement(annotation);
         if (el.length > 0)
             el[0].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'end' });
     }
 };

/**
 * Opens the properties dialog for the annotation.
 * @param annotation
 */
PageManager.openAnnotationPropertiesForm = function(annotation) {
	if (annotation.hasEditableProperties())
		angular.element($('#propertiesContainer')).scope().showPropertiesWindow(annotation);
};

PageManager.consoleLog = function(str) {
	if (Default.CONSOLE_LOG_ENABLE) {
        console.log(str);
    }
};

/**
 * Resize toolbar and rearranges the buttons based on the browser width.
 * @function
 * @memberof PageManager
 */
PageManager.resizeToolbarBasedOnBrowserWidth = function() {
    var toolbarAnnotations = $('#toolbarAnnotations');
    $('#toolbarContainer').css('cssText', 'height: ' + (toolbarAnnotations[0].clientHeight + 32) + 'px !important;');
    $('#viewerContainer').css('cssText', 'top: ' + (toolbarAnnotations[0].clientHeight + 32) + 'px !important;');

    /**
     * Because PDF.JS v2+ now has the sidebar below the toolbar, we detect the version firsthand, then set
     * the appropriate default height.
     */
    var height = $('#toolbarContainer')[0].clientHeight;
    if (!Annotationeer.isPDFJSVersion2Plus()) {
        height = $('#outerContainer')[0].clientWidth <= 840 ? $('#toolbarContainer')[0].clientHeight : 0;
    }
    $('#sidebarContainer').css('cssText', 'top: ' + height + 'px !important;');
};

/**
 * <p>This function renders the thumbnail based on pageIndex page. While the purpose of this function is to draw
 * annotations in the thumbnail image, it will have to be used in conjunction with annotation events to update
 * every action the user does on annotations since these events are generated by Annotationeer via
 * {@link Default.CREATE_ANNOTATION_EVENTS}.</p>
 * @function
 * @memberof PageManager
 * @param {number} pageIndex The index of the page in the pages list.
 */
PageManager.generateThumbnailWithAnnotations = function(pageIndex) {
    // Remove image thumbnail for replacement.
    $('div.thumbnail[data-page-number=' + (pageIndex + 1) + '] div img').remove();
    PDFViewerApplication.pdfThumbnailViewer._thumbnails[pageIndex].renderingState = 0;
    PDFViewerApplication.pdfSidebar._updateThumbnailViewer();
};

/**
 * Initialize filter options.
 * @function
 * @memberof PageManager
 */
PageManager.initFilterOptions = function() {
    PageManager.consoleLog('PageManager.initFilterOptions()');

    var callback = function() {
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
        statusContainer.find('span[class="' + className + '"]').each(function() {
            mapS.set(this.innerHTML, className);
        });

        statusContainer.empty();
        // Sort case insensitive.
        statusFound.sort(function (a, b) {
            return a.toLowerCase().localeCompare(b.toLowerCase());
        });

        for (var s=0; s<statusFound.length; s++) {
            statusContainer.append('<span ' + (mapS.has(statusFound[s]) && mapS.get(statusFound[s]) == className ?
                'class="' + className + '"' : '') + '>' + statusFound[s] + '</span>');
        }

        // If no comment status found, hide the section.
        if (statusFound.length == 0) {
            statusContainer.prev().hide();
            statusContainer.hide();
        }
        else {
            statusContainer.prev().show();
            statusContainer.show();
        }

        var userContainer = $('div#filter-option-comment-by');
        userContainer.find('span[class="' + className + '"]').each(function() {
            mapU.set(this.innerHTML, className);
        });

        userContainer.empty();
        usersFound.sort(function (a, b) {
            return a.toLowerCase().localeCompare(b.toLowerCase());
        });

        for (var uf=0; uf<usersFound.length; uf++) {
            userContainer.append('<span ' + (mapU.has(usersFound[uf]) && mapU.get(usersFound[uf]) == className ?
                'class="' + className + '"' : '') + '>' + usersFound[uf] + '</span>');
        }

        var stampContainer = $('div#filter-option-type');
        stampContainer.find('span[class="' + className + '"]').each(function() {
            mapAt.set(this.getAttribute('id'), className);
        });

        stampContainer.empty();
        for (var atf=0; atf<annotationTypesFound.length; atf++) {
            stampContainer.append('<span id="' + annotationTypesFound[atf].id + '"' +
                (mapAt.get(annotationTypesFound[atf].id + '') == className ?
                ' class="' + className + '"' : '') + '><img src="' +
                Url.stampFolderUrl + annotationTypesFound[atf].icon + '"/></span>');
        }
    }

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

/**
 * <p>Helper function to create annotations. Why is this not in page.js? Because this click event
 * happens on the PDF.JS page, not in the Annotationeer canvas which the page variable references
 * on.</p>
 * @function
 * @memberof PageManager
 * @param {object} e The mouse event object when clicked.
 * @param {number} angle The angle rotation of the PDF.JS page.
 */
PageManager.createAnnotationTextInsert = function(e, angle) {
    var page = pages[Default.canvasIdName + PDFViewerApplication.pdfViewer.currentPageNumber];
    var coord = page.getMouse(e, page, true);
    var divStyleLeft = parseFloat($(e.target).css('left'));
    var divStyleTop = parseFloat($(e.target).css('top'));

    PageManager.createAnnotation($('button#text_insert')[0], Annotation.TYPE_TEXT_INSERT, Url.stampFolderUrl + PageManager.getAnnotationTypeById(Annotation.TYPE_TEXT_INSERT).icon);
    PageManager.boxAnnotationGuide.w = PageManager.boxAnnotationGuide.h = (e.target.clientHeight / 2);

    if (angle == 0) {
        PageManager.boxAnnotationGuide.x = coord.x;
        PageManager.boxAnnotationGuide.y = divStyleTop;
        // Re-adjust position so that arrow tip will be centered.
        PageManager.boxAnnotationGuide.x -= PageManager.boxAnnotationGuide.w / 2;
        PageManager.boxAnnotationGuide.y = e.target.offsetTop + PageManager.boxAnnotationGuide.h;
    }
    else if (angle == 90) {
        PageManager.boxAnnotationGuide.x = divStyleLeft - e.target.clientHeight;
        PageManager.boxAnnotationGuide.y = coord.y - PageManager.boxAnnotationGuide.h;
    }
    else if (angle == 180) {
        PageManager.boxAnnotationGuide.x = coord.x;
        PageManager.boxAnnotationGuide.y = divStyleTop - PageManager.boxAnnotationGuide.h;
        // Re-adjust position so that arrow tip will be centered.
        PageManager.boxAnnotationGuide.x -= PageManager.boxAnnotationGuide.w / 2;
        PageManager.boxAnnotationGuide.y -= PageManager.boxAnnotationGuide.h;
    }
    else if (angle == 270) {
        PageManager.boxAnnotationGuide.x = divStyleLeft +  PageManager.boxAnnotationGuide.h;
        PageManager.boxAnnotationGuide.y = coord.y - PageManager.boxAnnotationGuide.h;
    }

    PageManager.boxAnnotationGuide.pageIndex = PDFViewerApplication.pdfViewer.currentPageNumber - 1;
    page.addAnnotation(PageManager.boxAnnotationGuide, rotateAngle, PDFViewerApplication.pdfViewer.currentScale, false, true);
    resetVar(true, false, page);
};

/**
 * <p>This context menu will show up when user selects a text to create a text highlight, underline or
 * strike-through. Instead of marking up the selected text, this menu will show up before marking it
 * after user selects a menu item. This option will fire if {@link Default.TEXT_TYPE_POPUP_BEFORE_CREATE} is
 * true.</p>
 * @function
 * @memberof PageManager
 * @param {object} e The event object.
 */
PageManager.displaySelectedTextMenu = function(e) {
    var page = PDFViewerApplication.pdfViewer.currentPageNumber;
    var px = e.pageX, py = e.pageY;
    var anPage = pages[Default.canvasIdName + page];
    anPage.getMouse(e, anPage);

    $.contextMenu({
        selector: 'canvas#' + Default.canvasIdName + page,
        trigger: 'none',
        callback: function (key) {
            switch (key) {
                case 'add_bookmark':
                    PageManager.consoleLog('Add Bookmark');
                    var selectedText = PageManager.getSelectedText();
                    var node = BookmarkManager.addBookmark();
                    var bookmark = BookmarkManager.getBookmarkFromList(node);
                    bookmark.label = selectedText;
                    $('div#bookmarks').jstree('set_text', node, selectedText);
                    BookmarkManager.saveBookmark(bookmark, node);
                    PageManager.clearSelectedText();
                    break;
            }
        },
        items: {
            'add_bookmark': { name: '<span data-l10n-id="add_bookmark_label">Add Bookmark</span>', isHtmlName: true }

        },
        events: {
            hide: function() {
                $.contextMenu('destroy',  '#' + Default.canvasIdName + page);
            }
        }
    });

    $('#' + Default.canvasIdName + page).contextMenu({x: px, y: py});
};

PageManager.load_DocumentRevisions = function() {
	PageManager.consoleLog('load_DocumentRevisions()');
  var e = document.getElementById("RevisionSelect");
  var strUser = e.options[e.selectedIndex].value;
  var doc = e.options[e.selectedIndex].getAttribute('doc');
  var plansheet = e.options[e.selectedIndex].getAttribute('plan');
  // alert(strUser);
  if(strUser!="" &&  parent.inspection_type==3){
      parent.render_Plansheet_ByRevision(parent.doc,strUser,plansheet);
    }
  else if(strUser!="" &&  parent.inspection_type==2){
      parent.render_Plansheet_ByRevision(doc,strUser,plansheet);
    }

};
