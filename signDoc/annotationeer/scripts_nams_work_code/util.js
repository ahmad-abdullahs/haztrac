/********************************************************************
 * Copyright (C) 2016-Present Mark Chester Goking <chitgoks@gmail.com>.
 *
 * This file is part of Annotationeer and it can not be copied
 * and/or distributed without the express permission of the author.
 ********************************************************************/

/**
 * This function enables you to load a CSS file programmatically.
 * https://github.com/filamentgroup/loadCSS/blob/master/loadCSS.js
 */
(function(w) {
    "use strict";
    /* exported loadCSS */
    var loadCSS = function(href, before, media) {
        // Arguments explained:
        // `href` [REQUIRED] is the URL for your CSS file.
        // `before` [OPTIONAL] is the element the script should use as a reference for injecting our stylesheet <link> before
        // By default, loadCSS attempts to inject the link after the last stylesheet or script in the DOM. However, you might desire a more specific location in your document.
        // `media` [OPTIONAL] is the media type or query of the stylesheet. By default it will be 'all'
        var doc = w.document;
        var ss = doc.createElement( "link" );
        var ref;
        if (before) {
            ref = before;
        }
        else {
            var refs = (doc.body || doc.getElementsByTagName("head")[0]).childNodes;
            ref = refs[refs.length - 1];
        }

        var sheets = doc.styleSheets;
        ss.rel = "stylesheet";
        ss.href = href;
        // temporarily set media to something inapplicable to ensure it'll fetch without blocking render
        ss.media = "only x";

        // Inject link
        // Note: the ternary preserves the existing behavior of "before" argument, but we could choose to change the argument to "after" in a later release and standardize on ref.nextSibling for all refs
        // Note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
        ref.parentNode.insertBefore( ss, ( before ? ref : ref.nextSibling ) );
        // A method (exposed on return object for external use) that mimics onload by polling until document.styleSheets until it includes the new sheet.
        var onloadcssdefined = function(cb) {
            var resolvedHref = ss.href;
            var i = sheets.length;
            while (i--) {
                if (sheets[i].href === resolvedHref) {
                    return cb();
                }
            }

            setTimeout(function() {
                onloadcssdefined( cb );
            }, 0);
        };

        // once loaded, set link's media back to `all` so that the stylesheet applies once it loads
        ss.onloadcssdefined = onloadcssdefined;
        onloadcssdefined(function() {
            ss.media = media || "all";
        });
        return ss;
    };
    // commonjs
    if (typeof module !== "undefined") {
        module.exports = loadCSS;
    }
    else {
        w.loadCSS = loadCSS;
    }
} (typeof global !== "undefined" ? global : this));

// http://upshots.org/javascript/jquery-test-if-element-is-in-viewport-visible-on-screen
$.fn.isOnScreen = function() {
    var viewport = {};
    viewport.top = $(window).scrollTop();
    viewport.bottom = viewport.top + $(window).height();
    var bounds = {};
    bounds.top = this.offset().top;
    bounds.bottom = bounds.top + this.outerHeight();
    return ((bounds.top <= viewport.bottom) && (bounds.bottom >= viewport.top));
};

// http://aramk.com/blog/2012/01/17/adding-css-rules-with-important-using-jquery/
// Set !important to CSS in JQuery
jQuery.fn.style = function(styleName, value, priority) {
    // DOM node
    var node = this.get(0);
    // Ensure we have a DOM node
    if (typeof node == 'undefined') {
        return;
    }
    // CSSStyleDeclaration
    var style = this.get(0).style;
    // Getter/Setter
    if (typeof styleName != 'undefined') {
        if (typeof value != 'undefined') {
            // Set style property
            var priority = typeof priority != 'undefined' ? priority : '';
            style.setProperty(styleName, value, priority);
        }
        else {
            // Get style property
            return style.getPropertyValue(styleName);
        }
    }
    else {
        // Get CSSStyleDeclaration
        return style;
    }
};

/**
 * This function aims to provide a functionality to a div.contenteditable limiting characters
 * based on max char setting. This includes paste.
 *
 * http://jsfiddle.net/shriek/H7h87/
 *
 * @param maxLengthOption Maximum number of characters allowed.
 * @param option Other properties.
 */
$.fn.limitText = function(maxLengthOption, option) {
    'use strict';
    var self = this,
        that = option || {};
    return (function () {
        var text_remaining,
            textAreas = self,
            textAreasCount = textAreas.length,
            maxLength, maxLength2,
            selector = that.selector || false,
            charTxt = selector ? (that.text ? ' ' + that.text : '') : false;
        var textAreasAll = (function () {
            for (var i=0; i<textAreasCount; i++) {
                textAreas[i].onkeydown = function(e) {
                    if (!(e.keyCode == 8)) {
                        maxLength = maxLengthOption;
                        countText(this, maxLength);
                        return this.innerText.length < maxLength;
                    }
                };
                textAreas[i].onkeyup = function(e) {
                    maxLength2 = maxLengthOption;
                    copyPastePrevent(this, maxLength2, e);
                    countText(this, maxLength2);
                };
            }
        }());
        var countText = selector?function (obj, maxChar) {
            text_remaining = maxChar - $(obj).text().length;
            $(obj).next(that.selector).html(text_remaining + charTxt);
        }: function() {
            return false;
        };
        var copyPastePrevent = function(obj, max, e) {
            var chopped;
            if ($(obj).text().length > max) {
                chopped = $(obj).text().substring(0, max);
                $(obj).html(chopped);
            }
            else {
                /**
                 * Added code here. If ctrl-v then set html() with the
                 * value of text() so that it will be a 1 liner. Only do
                 * this if paste event is triggered, otherwise ignore or
                 * else when user types a character, caret will go to
                 * first position all the time.
                 */
                if (e && e.ctrlKey && e.keyCode == 86)
                    $(obj).html($(obj).text().trim());
            }
        };
    }());
};

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

// http://stackoverflow.com/questions/36213455/add-startswith-in-ie-11
if (!String.prototype.startsWith) {
    String.prototype.startsWith = function(searchString, position) {
        position = position || 0;
        return this.substr(position, searchString.length) === searchString;
    };
}

// https://stackoverflow.com/questions/280634/endswith-in-javascript
if (typeof String.prototype.endsWith !== 'function') {
	String.prototype.endsWith = function(suffix) {
		return this.indexOf(suffix, this.length - suffix.length) !== -1;
	};
}

/**
 * Override Date's toJSON() function call from within JSON.stringify because it returns
 * an incorrect value. Using MomentJS' library, the date will be stringified and preserve
 * its timezone.
 * http://stackoverflow.com/questions/31096130/how-to-json-stringify-a-javascript-date-and-preserve-timezone
 * @returns {*}
 */
Date.prototype.toJSON = function() {
    return moment(this).format();
};

/**
 * Helper functions.
 * @namespace Util
 */
var Util = { };

/**
 * <p>Load a CSS file programmatically.</p>
 * @function
 * @memberof Util
 * @param {string} url The url of the CSS file.
 * @param {string} callback The callback function to call once the script file is loaded.
 */
Util.onloadCSS = function(ss, callback) {
    ss.onload = function() {
        ss.onload = null;
        if (callback) {
            callback.call(ss);
        }
    };

    // This code is for browsers that don ot support onload, any browser that
    // supports onload should use that instead.
    // No support for onload:
    //	* Android 4.3 (Samsung Galaxy S4, Browserstack)
    //	* Android 4.2 Browser (Samsung Galaxy SIII Mini GT-I8200L)
    //	* Android 2.3 (Pantech Burst P9070)

    // Weak inference targets Android < 4.4
    if ('isApplicationInstalled' in navigator && 'onloadcssdefined' in ss) {
        ss.onloadcssdefined(callback);
    }
};

/**
 * <p>Load a Javascript file programmatically.</p>
 * @see {@link https://www.nczonline.net/blog/2009/07/28/the-best-way-to-load-external-javascript/}
 * @function
 * @memberof Util
 * @param {string} url The url of the script file.
 * @param {string} callback The callback function to call once the script file is loaded.
 */
Util.loadScript = function(url, callback) {
    var script = document.createElement('script');
    script.type = 'text/javascript';

    // IE
    if (script.readyState) {
        script.onreadystatechange = function() {
            if (script.readyState == 'loaded' || script.readyState == 'complete') {
                script.onreadystatechange = null;
                if (callback)
                    callback();
            }
        };
    }
    // Others
    else {
        if (callback)
            script.onload = function() {
                callback();
            };
    }

    script.src = url;
    document.getElementsByTagName('head')[0].appendChild(script);
};

/**
 * Global intersection angles of two circles of the same radius. For use in cloud annotation calculation.
 * https://stackoverflow.com/questions/34623855/what-is-the-algorithm-behind-the-pdf-cloud-annotation
 */
Util.intersectAngle = function(p, q, r) {
    var dx = q.x - p.x;
    var dy = q.y - p.y;

    var len = Math.sqrt(dx * dx + dy * dy);
    var a = 0.5 * len / r;

    if (a < -1) a = -1;
    if (a > 1) a = 1;

    var phi = Math.atan2(dy, dx);
    var gamma = Math.acos(a);

    return [phi - gamma, Math.PI + phi + gamma];
};

/**
 * Returns true if the browser is in an iOS device.
 * @see {@link https://stackoverflow.com/questions/16039219/disable-selection-context-menu-in-ios-safari}
 * @function
 * @memberof Util
 * @return {boolean}
 */
Util.isIOSDevice = function() {
    return (/(iPad|iPhone|iPod)/g.test(navigator.userAgent));
};

/**
 * <p>If the browser is from Microsoft e.g. IE, Edge, etc.</p>
 * @see {@link http://stackoverflow.com/questions/19999388/check-if-user-is-using-ie-with-jquery}
 * @function
 * @memberof Util
 * @returns {boolean}
 */
Util.isIE = function() {
    var userAgent = navigator.userAgent;
    return userAgent.indexOf("MSIE") > -1 || userAgent.indexOf("Trident/") > -1;
};

/**
 * <p>If the browser supports HTML5 color input picker.</p>
 * @see {@link http://stackoverflow.com/questions/8278670/how-to-check-if-a-html5-input-is-supported}
 * @function
 * @memberof Util
 * @returns {boolean}
 */
Util.supportsHTML5ColorInput = function() {
    var i = document.createElement('input');
    i.setAttribute('type', 'color');
    return i.type !== 'text';
};

/**
 * Draws text on top of a line.
 * @see {@link http://stackoverflow.com/questions/5068216/placing-text-label-along-a-line-on-a-canvas}
 * @function
 * @memberof Util
 * @param {object} ctx Canvas context.
 * @param {string} text Text to draw.
 * @param {object} p1 point 1.
 * @param {object} p2 point 2.
 * @param {number} gap Gap space between the line and text.
 * @param {string} font Font value for use in Canvas setting.
 * @param {string} color The color of the label.
 * @param {string} alignment Text alignment: center, left, right.
 * @param {number} padding Left and right padding space if alignment is left or right.
 */
Util.drawLabelOnTopOfLine = function(ctx, text, p1, p2, gap, font, color, alignment, padding) {
    if (!alignment) alignment = 'center';
    if (!padding) padding = 0;

    var dx = p2.x - p1.x;
    var dy = p2.y - p1.y;
    var len = Math.sqrt(dx * dx + dy * dy);
    var avail = len - 2 * padding;

    var textToDraw = text;
    if (Default.ANNOTATION_MEASUREMENT_DISTANCE_MINIMUM_LENGTH && ctx.measureText && ctx.measureText(textToDraw).width > avail) {
        while (textToDraw && ctx.measureText(textToDraw + '...').width > avail) textToDraw = textToDraw.slice(0, -1);
        textToDraw += '...';
    }

    // Keep text upright
    var angle = Math.atan2(dy, dx);
    if (angle < -Math.PI / 2 || angle > Math.PI / 2) {
        var p = p1;
        p1 = p2;
        p2 = p;
        dx *= -1;
        dy *= -1;
        angle -= Math.PI;
    }

    var p, pad;
    if (alignment == 'center') {
        p = p1;
        pad = 1 / 2;
    }
    else {
        var left = alignment == 'left';
        p = left ? p1 : p2;
        pad = padding / len * (left ? 1 : -1);
    }

    if (font)
        ctx.font = font;

    ctx.save();
    ctx.textAlign = alignment;
    ctx.translate(p.x + dx * pad, (p.y + dy * pad) - gap);
    ctx.rotate(angle);
    ctx.fillStyle = color;
    ctx.fillText(textToDraw, 0, 0);
    ctx.restore();
};

/**
 * <p>Pythagoras theorem - get distance between 2 points.</p>
 * Sourced: {@link http://stackoverflow.com/questions/20916953/get-distance-between-two-points-in-canvas}
 * @function
 * @memberof Util
 * @param {decimal} x1 The x coordinate of the first point.
 * @param {decimal} y1 The y coordinate of the first point.
 * @param {decimal} x2 The x coordinate of the second point.
 * @param {decimal} y2 The y coordinate of the second point.
 * @returns {*}
 */
Util.getDistance = function(x1, y1, x2, y2) {
    var a = x1 - x2;
    var b = y1 - y2;
    return Math.sqrt(a * a + b * b);
};

/**
 * @see {@link http://forums.codeguru.com/showthread.php?106593-Calculating-a-point-from-a-point-angle-and-distance}
 * @function
 * @memberof Util
 * @param {decimal} x1
 * @param {decimal} y1
 * @param {number} angle
 * @param {decimal} distance
 * @returns {object} { x, y }
 */
Util.getPointFromDistance = function(x1, y1, angle, distance) {
    var x = x1 + (Math.cos(angle) * distance);
    var y = y1 + (Math.sin(angle) * distance);
    return { x: x, y: y };
};

/**
 * @see {@link https://gist.github.com/conorbuck/2606166}
 * @function
 * @memberof Util
 * @param {decimal} x1 The x coordinate of the first point.
 * @param {decimal} y1 The y coordinate of the first point.
 * @param {decimal} x2 The x coordinate of the second point.
 * @param {decimal} y2 The y coordinate of the second point.
 * @param {number} degrees The angle in degrees.
 * @returns {number}
 */
Util.getAngle = function(x1, y1, x2, y2, degrees) {
    if (degrees)
        return Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
    else
    // in radians
        return Math.atan2(y2 - y1, x2 - x1);
};

/**
 * <p>Gets the maximum and minimum coordinates from an array of points.</p>
 * @see {@link http://stackoverflow.com/questions/18798568/get-max-and-min-of-object-values-from-javascript-array}
 * @function
 * @memberof Util
 * @param {Array<DrawingPosition>} coordinates
 * @returns {object} { x, y, w, h }
 */
Util.getBoundingBoxOfPoints = function(coordinates) {
    var minX = Util.getMinField(coordinates, 'x');
    var minY = Util.getMinField(coordinates, 'y');
    var maxX = Util.getMaxField(coordinates, 'x');
    var maxY = Util.getMaxField(coordinates, 'y');
    return { x: minX, y: minY, w: (maxX - minX), h: (maxY - minY) };
};

/**
 * Get the bounding box based from an array of highlight text rects.
 * @function
 * @memberof Util
 * @param {Array<HighlightTextRect>} rects The highlight text rectangles of the annotation.
 * @param {number} angle The angle.
 * @returns {object} { x, y, w, h }
 */
Util.getBoundingBoxOfRects = function(rects, angle) {
    var minX = Number.MAX_VALUE;
    var minY = Number.MAX_VALUE;
    var maxX = Number.MIN_VALUE;
    var maxY = Number.MIN_VALUE;

    for (var r=0; r<rects.length; r++) {
        var rect = rects[r];
        var ax = rect.x - (rect.width < 0 ? Math.abs(rect.width) : 0);
        var ay = rect.y - (rect.height < 0 ? Math.abs(rect.height) : 0);
        var bx = ax + Math.abs(rect.width);
        var by = ay + Math.abs(rect.height);

        minX = Math.min(ax, minX);
        minY = Math.min(ay, minY);
        maxX = Math.max(bx, maxX);
        maxY = Math.max(by, maxY);
    }

    var width = maxX - minX;
    var height = maxY - minY;

    return { x: minX, y : minY, width: width, height: height };
};

/**
 * Gets the maximum value from an array based on a property.
 * @function
 * @memberof Util
 * @param {Array<DrawingPosition>} array The array of {@link DrawingPosition} objects.
 * @param {string} field The property of the object to base on.
 * @returns {decimal}
 */
Util.getMaxField = function(array, field) {
    return array.reduce(function (previousValue, currentValue) {
        return Math.max(currentValue[field], previousValue);
    }, -Infinity);
};

/**
 * Gets the minimum value from an array based on a property.
 * @function
 * @memberof Util
 * @param {Array<DrawingPosition>} array The array of {@link DrawingPosition} objects.
 * @param {string} field The property of the object to base on.
 * @returns {decimal}
 */
Util.getMinField = function(array, field) {
    return array.reduce(function (previousValue, currentValue) {
        return Math.min(currentValue[field], previousValue);
    }, Infinity);
};

/**
 * @function
 * @memberof Util
 * Calculate the measurement distance annotation.
 * @param {Annotation} annotation The annotation object.
 * @param {number} pixels The distance of the line annotation in pixel.
 * @returns {decimal}
 */
Util.getMeasurementFromPixels = function(annotation, pixels) {
    var calibratedValue = annotation.calibrationValue * pixels;
    // var mm = pixels * 0.264583;
    var mm = 0;

    if (annotation.calibrationMeasurementType == MeasurementType.CENTIMETERS) {
        // cm to mm = 1 to 10
        mm = calibratedValue * 10;
    }
    else if (annotation.calibrationMeasurementType == MeasurementType.MILLIMETERS) {
        mm = calibratedValue;
    }
    else if (annotation.calibrationMeasurementType == MeasurementType.INCHES ||
        annotation.calibrationMeasurementType == MeasurementType.FOOT_INCH)
    {
        // in to mm = 1 to 2.54
        mm = calibratedValue * 25.4
    }

    switch (annotation.measurementType) {
        case MeasurementType.CENTIMETERS:
            return Math.abs((mm * 0.1).toFixed(1)) + ' cm';
        case MeasurementType.MILLIMETERS :
            return Math.abs((mm).toFixed(1)) + ' mm';
        case MeasurementType.INCHES:
            return Math.abs((mm * 0.0393701).toFixed(1)) + ' in';
        case MeasurementType.FOOT_INCH:
            var totalInches = Math.abs((mm * 0.0393701).toFixed(1));
            var feet = totalInches >= 12 ? parseInt(totalInches / 12) : 0;
            var inches = totalInches >= 12 ? Math.round(totalInches % 12) : totalInches;
            return feet > 0 ? feet + '\' ' + inches + '"' : inches + '"';
    }

    return '';
};

/**
 * Gets the area based on calibration value.
 * @function
 * @memberof Util
 * @param {Annotation} annotation
 * @param {decimal} area Originally, half of the total area is passed here but this time with calibration we use the
 * area value itself. Under observation.
 * @returns {decimal}
 */
Util.getAreaFromPixels = function(annotation, area) {
    // Always convert to square inch first since this will be our basis.
    // 9216 is product of 96 x 96 (which is dpi).
    //var squareInch = Math.abs(area / 2) / 9216;
    var calibratedValue = Math.abs((area * annotation.calibrationValue));
    var squareInch = 0;

    switch (annotation.calibrationMeasurementType) {
        case MeasurementType.CENTIMETERS:
            squareInch = calibratedValue * 0.155;
            break;
        case MeasurementType.INCHES:
        case MeasurementType.FOOT_INCH:
            squareInch = calibratedValue;
            break;
        case MeasurementType.MILLIMETERS:
            squareInch = calibratedValue * 0.00155;
            break;
    }

    switch (annotation.measurementType) {
        case MeasurementType.CENTIMETERS:
            return (squareInch * 6.4516).toFixed(2) + ' sq cm';
        case MeasurementType.MILLIMETERS :
            return (squareInch * 645.16).toFixed(2) + ' sq mm';
        case MeasurementType.INCHES:
        case MeasurementType.FOOT_INCH:
            return squareInch.toFixed(2) + ' sq in';
    }

    return '';
};

/**
 * <p>Returns a numerical value corresponding to the rotation applied to any HTML element.</p>
 * @see {@link http://stackoverflow.com/questions/8270612/get-element-moz-transformRotate-value-in-jquery}
 * @function
 * @memberof Util *
 * @param {object} obj Must be a JQuery element.
 * @returns {number}
 */
Util.getRotationDegrees = function(obj) {
    var matrix = obj.css("-webkit-transform") ||
        obj.css("-moz-transform") ||
        obj.css("-ms-transform") ||
        obj.css("-o-transform") ||
        obj.css("transform");
    var angle = 0;

    if (!matrix) {
        angle = 0;
    }
    else if (matrix === 'none') {
        angle = 0;
    }
    else {
        var values = matrix.split('(')[1].split(')')[0].split(',');
        var a = values[0];
        var b = values[1];
        angle = Math.round(Math.atan2(b, a) * (180 / Math.PI));
    }

    return (angle < 0) ? angle + 360 : angle;
};


/**
 * Lists the different angles of the selectedNodes.
 * @function
 * @memberof Util
 * @param {object} nodes The HTML nodes.
 * @returns {number}
 */
Util.getAngleCountOfSelectedNodes = function(nodes) {
    var angles = [];

    for (var n in nodes) {
        var angle = Util.getRotationDegrees(nodes[n]);
        if ($.inArray(angle, angles) == -1) {
            angles.push(angle);
        }
    }

    return angles.length;
};

/**
 * <p>Gets the HTML nodes between a selection range.</p>
 * @see {@link http://stackoverflow.com/questions/667951/how-to-get-nodes-lying-inside-a-range-with-javascript}
 * @function
 * @memberof Util
 * @param {object} startNode The first node belong to the selection range.
 * @param {object} endNode The last node belong to the selection range.
 * @param {boolean} includeStartAndEnd If the first and lats node should be included.
 * @param {string} filter The filter to specifically extract only the nodes that match.
 * @returns {Array<object>}
 */
Util.getNodesBetween = function(startNode, endNode, includeStartAndEnd, filter) {
    if (startNode == endNode && startNode.childNodes.length === 0)
        return [startNode];

    var getNextNode = function(node, finalNode, skipChildren) {
        // If there are child nodes and we didn't come from a child node
        if (finalNode == node)
            return null;

        if (node.firstChild && !skipChildren)
            return node.firstChild;

        if (!node.parentNode)
            return null;

        return node.nextSibling || getNextNode(node.parentNode, endNode, true);
    };

    var nodes = [];

    if (includeStartAndEnd)
        nodes.push(startNode);

    while ((startNode = getNextNode(startNode, endNode)) && (startNode != endNode)) {
        if (filter) {
            if (filter(startNode)) {
                nodes.push(startNode);
            }
        }
        else {
            nodes.push(startNode);
        }
    }

    if (includeStartAndEnd) {
        nodes.push(endNode);
    }

    return nodes;
};

/**
 * <p>Determine if a cloud annotation's points are in a clockwise or counter clockwise direction.
 * This, so the cloud can be drawn accordingly.</p>
 * @see {@link https://stackoverflow.com/questions/14505565/detect-if-a-set-of-points-in-an-array-that-are-the-vertices-of-a-complex-polygon}
 * @function
 * @memberof Util
 * @param {Array<DrawingPositions>} points The array of {@link DrawingPosition}.
 * @returns {boolean}
 */
Util.isClockWise = function(points) {
    var area = 0;

    for (var i=0; i<points.length; i++) {
        var j = (i + 1) % points.length;
        area += points[i].x * points[j].y;
        area -= points[j].x * points[i].y;
    }

    return area > 0;
};

/**
 * Recalculate the new coordinates based on the new page's dimension.
 * @function
 * @memberof Util
 * @param {decimal} oldX Original x coordinate.
 * @param {decimal} oldY Original y coordinate.
 * @param {decimal} oldW Original width coordinate.
 * @param {decimal} oldH Original height coordinate.
 * @param {decimal} oldPageW Original page width.
 * @param {decimal} oldPageH Original page height.
 * @param {decimal} newPageW Page width where the original coordinates will be based on.
 * @param {decimal} newPageH Page height where the original coordinates will be based on.
 * @returns {object} { x, y, width, height }
 */
Util.getNewPosition = function(oldX, oldY, oldW, oldH, oldPageW, oldPageH, newPageW, newPageH) {
    return {
        x: ((oldX) * newPageW / oldPageW),
        y: ((oldY) * newPageH / oldPageH),
        width: oldW * newPageW / oldPageW,
        height: oldH * newPageH / oldPageH
    };
};

/**
 * @see {@link http://stackoverflow.com/questions/17095851/check-if-element-is-off-right-edge-of-screen}
 * @function
 * @memberof Util
 * @param {object} elem The HTML element.
 * @returns {boolean}
 */
Util.isElementOffRightScreen = function(elem) {
    if (!(elem instanceof jQuery))
        elem = $(elem);

    var screenWidth = $(window).width();
    var rightEdge = elem.offset().left + elem.width();

    return rightEdge > screenWidth;
};

/**
 * @function
 * @memberof Util
 * @param {object} elem The HTML element.
 * @returns {boolean}
 */
Util.isElementOffLeftScreen = function(elem) {
    if (!(elem instanceof jQuery))
        elem = $(elem);

    return elem.offset().left < 0;
};

/**
 * Detect which properties of an object results in a circular reference JSON error.
 * @function
 * @memberof Util
 * @param {object} obj The object to check if it will trigger a circular error.
 */
Util.listCircularJSON = function(obj) {
    var seenObjects = [];

    function detect (obj) {
        if (obj && typeof obj === 'object') {
            if (seenObjects.indexOf(obj) !== -1) {
                return true;
            }
            seenObjects.push(obj);
            for (var key in obj) {
                if (obj.hasOwnProperty(key) && detect(obj[key])) {
					return true;
                }
            }
        }
        return false;
    }

    return detect(obj);
};

/**
 * <p>There is no native way to detect if a caret's cursor position is at the end of an element like DIV contenteditable.</p>
 * @see {@link http://stackoverflow.com/questions/7451468/contenteditable-div-how-can-i-determine-if-the-cursor-is-at-the-start-or-end-o/7478420#7478420}
 * @function
 * @memberof Util
 * @param {object} el The HTML element.
 * @returns {object} { atStart, atEnd }
 */
Util.getSelectionTextInfo = function(el) {
    var atStart = false, atEnd = false;
    var selRange, testRange;
    if (window.getSelection) {
        var sel = window.getSelection();
        if (sel.rangeCount) {
            selRange = sel.getRangeAt(0);
            testRange = selRange.cloneRange();

            testRange.selectNodeContents(el);
            testRange.setEnd(selRange.startContainer, selRange.startOffset);
            atStart = (testRange.toString() == "");

            testRange.selectNodeContents(el);
            testRange.setStart(selRange.endContainer, selRange.endOffset);
            atEnd = (testRange.toString() == "");
        }
    }
    else if (document.selection && document.selection.type != "Control") {
        selRange = document.selection.createRange();
        testRange = selRange.duplicate();

        testRange.moveToElementText(el);
        testRange.setEndPoint("EndToStart", selRange);
        atStart = (testRange.text == "");

        testRange.moveToElementText(el);
        testRange.setEndPoint("StartToEnd", selRange);
        atEnd = (testRange.text == "");
    }

    return { atStart: atStart, atEnd: atEnd };
};

/**
 * Select a range of HTML elements programmatically.
 * @function
 * @memberof Util
 * @param {object} range
 */
Util.selectRange = function(range) {
    if (range) {
        if (typeof range.select != "undefined") {
            range.select();
        }
        else if (typeof window.getSelection != "undefined") {
            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        }
    }
};

/**
 * <p>This function is used instead since the caret position is placed where the mouse cursor is located.
 * Part of the function was removed because it would not work in Firefox. It seems document.caretPositionFromPoint()
 * works in modern Firefox browsers.</p>
 * @see {@link http://stackoverflow.com/questions/12920225/text-selection-in-divcontenteditable-when-double-click}
 * @function
 * @memberof Util
 * @param {object} evt The event object.
 * @returns {object}
 */
Util.getMouseEventCaretRange = function(evt) {
    var range, x = evt.clientX, y = evt.clientY;

    // Try the simple IE way first
    if (document.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToPoint(x, y);
    }
    else if (typeof document.createRange != "undefined") {
        // Try the standards-based way
        if (document.caretPositionFromPoint) {
            var pos = document.caretPositionFromPoint(x, y);
            range = document.createRange();
            range.setStart(pos.offsetNode, pos.offset);
            range.collapse(true);
        }
        // Next, the WebKit way
        else if (document.caretRangeFromPoint) {
            range = document.caretRangeFromPoint(x, y);
        }
    }

    return range;
};

/**
 * <p>Converts a component color to hex.</p>
 * @see {@link http://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb}
 * @function
 * @memberof Util
 * @param c
 * @returns {string}
 */
Util.componentToHex = function(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
};

/**
 * Convert rgb to hex.
 * @function
 * @memberof Util
 * @param {number} r The red color.
 * @param {number} g The green color.
 * @param {number} b The blue color.
 * @returns {string}
 */
Util.rgbToHex = function(r, g, b) {
    return "#" + Util.componentToHex(r) + Util.componentToHex(g) + Util.componentToHex(b);
};

/**
 * Convert hex to rgb.
 * @function
 * @memberof Util
 * @param {string} hex The hex code.
 * @returns {object} { r, g, b }
 */
Util.hexToRgb = function(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
};

/**
 * <p>Convert RGB to hex.</p>
 * @see {@link http://www.webdesignerdepot.com/2013/03/how-to-create-a-color-picker-with-html5-canvas/}
 * @function
 * @memberof Util
 * @param {string} r The red color.
 * @param {string} g The green color.
 * @param {string} b The blue color.
 * @returns {string}
 */
Util.rgbToHex = function(r, g, b) {
    return '#' + Util.toHex(r) + Util.toHex(g) + Util.toHex(b);
};

Util.toHex = function(n) {
    n = parseInt(n, 10);

    if (isNaN(n))
        return "00";

    n = Math.max(0, Math.min(n, 255));
    return "0123456789ABCDEF".charAt((n - n % 16) / 16) + "0123456789ABCDEF".charAt(n % 16);
};

/**
 * Convert RGB to short hex.
 * @param {objec} rgb Object with r,g,b properties.
 * @returns {string}
 */
Util.rgbToShortHex = function(rgb){
    var hexR = Math.round(rgb.r / 17).toString(16);
    var hexG = Math.round(rgb.g / 17).toString(16);
    var hexB = Math.round(rgb.b / 17).toString(16);
    return '#' + hexR + '' + hexG + '' + hexB;
};

Util.getShortHexColorCode = function(code) {
    var rgb = Util.hexToRgb(code);
    return Util.rgbToShortHex(rgb);
};

/**
 * <p>Update value of a query string parameter.</p>
 * @see {@link http://stackoverflow.com/questions/5999118/add-or-update-query-string-parameter}
 * @function
 * @memberof Util
 * @param {string} uri The URI.
 * @param {string} key They key of the query string.
 * @param {string} value The value of the query string.
 * @returns {*}
 */
Util.updateQueryStringParameter = function(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
};

/**
 * Returns true if it is an image.
 * @function
 * @memberof Util
 * @param {object} i The image object.
 * @returns {boolean}
 */
Util.isImage = function(i) {
    return i instanceof HTMLImageElement;
};

/**
 * <p>Gets the width of the image based on its height. IE11 does not support naturalWidth and naturalHeight
 * properties of image.</p>
 * @function
 * @memberof Util
 * @param {object} img The image object.
 * @param {number} height The height of the image.
 * @returns {number}
 */
Util.getImageWidthFromHeight = function(img, height) {
    return height * (img.naturalWidth / img.naturalHeight);
};

/**
 * Change the color of the image.
 * @function
 * @memberof Util
 * @see {@link http://stackoverflow.com/questions/16228048/replace-a-specific-color-by-another-in-an-image-sprite-in-a-html5-canvas}
 * @param {object} context The canvas context.
 * @param {object} image The image object.
 * @param {string} color The color to apply on the image.
 * @param {decimal} x The x coordinate where the image will be drawn.
 * @param {decimal} y The y coordinate where the image will be drawn.
 * @param {decimal} w The width of the image.
 * @param {decimal} h The height of the image.
 * @param {number} rotate The rotation angle.
 * @param {boolean} printPreview If this image is drawn in print preview.
 */
Util.changeColorOfDrawnImage = function(context, image, color, x, y, w, h, rotate, printPreview) {
    // Change icon to black
    context.save();
    context.translate(x, y);

    if (rotate)
        context.rotate(rotate);

    if (printPreview)
        context.clearRect(0, 0, w, h);

    context.drawImage(image, 0, 0, w, h);
    context.fillStyle = color;
    context.globalCompositeOperation = 'source-atop';
    context.fillRect(0, 0, w, h);
    context.restore();
};

/**
 * Gets the selection DOM element that the selected text belongs to. While this function can be changed to accommodate
 * returning a list of all DOM elements that fall within the selection, this function will do. The first element returned
 * can be used to identify what angle rotation the DOM element has, if any.
 * @param isStart returns the first DOM element if there are many DOM elements in the selection. False will return the
 * last element.
 * http://stackoverflow.com/questions/1335252/how-can-i-get-the-dom-element-which-contains-the-current-selection
 */
Util.getSelectionBoundaryElement = function(isStart) {
    var range, sel, container;
    if (document.selection) {
        range = document.selection.createRange();
        range.collapse(isStart);
        return range.parentElement();
    }
    else {
        sel = window.getSelection();
        if (sel.getRangeAt) {
            if (sel.rangeCount > 0) {
                range = sel.getRangeAt(0);
            }
        }
        else {
            // Old WebKit
            range = document.createRange();
            range.setStart(sel.anchorNode, sel.anchorOffset);
            range.setEnd(sel.focusNode, sel.focusOffset);

            // Handle the case when the selection was selected backwards (from the end to the start in the document)
            if (range.collapsed !== sel.isCollapsed) {
                range.setStart(sel.focusNode, sel.focusOffset);
                range.setEnd(sel.anchorNode, sel.anchorOffset);
            }
        }

        if (range) {
            container = range[isStart ? "startContainer" : "endContainer"];

            // Check if the container is a text node and return its parent if so
            return container.nodeType === 3 ? container.parentNode : container;
        }
    }
};

/**
 * Returns true if the point is inside the circle.
 * @function
 * @memberof Util
 * @see {@link http://stackoverflow.com/questions/16792841/detect-if-user-clicks-inside-a-circle}
 * @param {decimal} x The x coordinate.
 * @param {decimal} y The y coordinate.
 * @param {decimal} cx The x coordinate in the circle.
 * @param {decimal} cy The y coordinate in the circle.
 * @param {number} radius The radius.
 * @returns {boolean}
 */
Util.isPointInCircle = function(x, y, cx, cy, radius) {
    var distanceSquared = (x - cx) * (x - cx) + (y - cy) * (y - cy);
    return distanceSquared <= radius * radius;
};

/**
 * If the browser is Safari.
 * @function
 * @memberof Util
 * @return {boolean}
 */
Util.isSafari = function() {
    return navigator.userAgent.indexOf("Safari") > -1;
};

/**
 * @function
 * @memberof Util
 * @param {object} date The date object.
 * @return {boolean}
 */
Util.isDate = function(date) {
    return moment(date, moment.localeData().longDateFormat('l'), true).isValid();
};

/**
 * Formats the date. We now use moment library to format Date object based on locale.
 * @function
 * @memberof Util
 * @param {object} date The date object.
 * @return {string}
 */
Util.formatDate = function(date) {
    return moment(date).format(moment.localeData().longDateFormat('l'));
};

//noinspection JSUnusedLocalSymbols
/**
 * Gets the bounding box of polygons based on the angle. For now angle supported is 0.
 * @function
 * @memberof Util
 * @param {Array<Annotation>} annotations The array of {@link Annotation}.
 * @param {number} angle The angle.
 * @returns {object} { x, y, width, height }
 */
Util.getBoundingBoxOfPolygons = function(annotations, angle) {
    var minX = Number.MAX_VALUE;
    var minY = Number.MAX_VALUE;
    var maxX = Number.MIN_VALUE;
    var maxY = Number.MIN_VALUE;

    for (var a=0; a<annotations.length; a++) {
        var ax = annotations[a].x - (annotations[a].w < 0 ? Math.abs(annotations[a].w) : 0);
        var ay = annotations[a].y - (annotations[a].h < 0 ? Math.abs(annotations[a].h) : 0);
        var bx = ax + Math.abs(annotations[a].w);
        var by = ay + Math.abs(annotations[a].h);

        minX = Math.min(ax, minX);
        minY = Math.min(ay, minY);
        maxX = Math.max(bx, maxX);
        maxY = Math.max(by, maxY);
    }

    var width = maxX - minX;
    var height = maxY - minY;

    return { x: minX, y : minY, width: width, height: height };
};

/**
 * <p>Detect if Annotationeer is run in a mobile device. Basing it in "return 'ontouchstart' in window" is not
 * enough as it could be in a desktop with touch features.</p>
 * @function
 * @memberof Util
 * @returns {boolean}
 */
Util.isMobile = function() {
    var check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};


// http://stackoverflow.com/questions/20885297/collision-detection-in-html5-canvas
Util.isRectCircleColliding = function(circle, rect){
    var distX = Math.abs(circle.x - rect.x - rect.w / 2);
    var distY = Math.abs(circle.y - rect.y - rect.h / 2);

    if (distX > (rect.w / 2 + circle.r)) { return false; }
    if (distY > (rect.h / 2 + circle.r)) { return false; }

    if (distX <= (rect.w / 2)) { return true; }
    if (distY <= (rect.h / 2)) { return true; }

    var dx = distX - rect.w / 2;
    var dy = distY - rect.h / 2;
    return (dx * dx + dy * dy <= (circle.r * circle.r));
};

/**
 * Returns true if it is a function.
 * @function
 * @memberof Util
 * @param {string} x The function name.
 * @returns {boolean}
 */
Util.isFunction = function(x) {
    return Object.prototype.toString.call(x) == '[object Function]';
};

/**
 * Returns true if even is supported.
 * @function
 * @memberof Util
 * @param {string} eventName The event name.
 * @returns {boolean}
 */
Util.isEventSupported = function(eventName) {
	var el = document.createElement('div');
	eventName = 'on' + eventName;
	var isSupported = (eventName in el);
	if (!isSupported) {
		el.setAttribute(eventName, 'return;');
		isSupported = typeof el[eventName] == 'function';
	}
	el = null;
	return isSupported;
};

/**
 * <p>Helper function to compare version of PDF.JS.</p>
 * <p>Return 1 if a > b<br/>
 * Return -1 if a < b<br/>
 * Return 0 if a == b</p>
 * @see {@link https://stackoverflow.com/questions/6832596/how-to-compare-software-version-number-using-js-only-number}
 * @function
 * @memberof Util
 * @param {decimal} a The version number of PDF.JS.
 * @param {decimal} b The version number of PDF.JS.
 * @returns {number}
 */
Util.versionCompare = function(a, b) {
    if (a === b) {
        return 0;
    }

    var a_components = a.split(".");
    var b_components = b.split(".");

    var len = Math.min(a_components.length, b_components.length);

    // loop while the components are equal
    for (var i = 0; i < len; i++) {
        // A bigger than B
        if (parseInt(a_components[i]) > parseInt(b_components[i])) {
            return 1;
        }

        // B bigger than A
        if (parseInt(a_components[i]) < parseInt(b_components[i])) {
            return -1;
        }
    }

    // If one's a prefix of the other, the longer one is greater.
    if (a_components.length > b_components.length) {
        return 1;
    }

    if (a_components.length < b_components.length) {
        return -1;
    }

    // Otherwise they are the same.
    return 0;
};

/**
 * Get the locale of the browser.
 * @function
 * @memberof Util
 * @returns {string}
 */
Util.getLocaleOfBrowser = function() {
    return window.navigator.userLanguage || window.navigator.language;
};

/**
 * Format the date using the Moment libary.
 * @function
 * @memberof Util
 * @param {object} date The date object.
 * @param {string} pattern The date format pattern.
 * @returns {string}
 */
Util.getMomentFormattedDate = function(date, pattern) {
    // Set locale for moment JS library.
    moment.locale(Util.getLocaleOfBrowser());
    // English is M/D/YYYY.
    return moment(date).format(moment.localeData().longDateFormat(pattern ? pattern : 'L'));
};

/**
 * <p>We use this function to stringify instead of using JSON.stringify() to avoid the circular references
 * error message.</p>
 * @see {@link https://gist.github.com/zmmbreeze/9408172}
 * @function
 * @memberof Util
 * @param {object} object The object to stringify.
 * @return {object}
 */
Util.jsonStringify = function(object) {
    var cache = [];
    var data = JSON.stringify(object, function(key, value) {
        if (typeof value === 'object' && value !== null) {
            if (cache.indexOf(value) !== -1) {
                // Circular reference found, discard key
                return;
            }
            // Store value in our collection
            cache.push(value);
        }
        return value;
    });

    // Enable garbage collection.
    cache = null;
    return data;
};

/**
 * <p>Clone the canvas.</p>
 * @see {@link https://stackoverflow.com/questions/3318565/any-way-to-clone-html5-canvas-element-with-its-content}
 * @function
 * @memberof Util
 * @param {object} oldCanvas The canvas object to clone.
 * @returns {object} A copy of the canvas object.
 */
Util.cloneCanvas = function(oldCanvas) {
    // Create a new canvas.
    var newCanvas = document.createElement('canvas');
    var context = newCanvas.getContext('2d');

    // Set dimensions.
    newCanvas.width = oldCanvas.width;
    newCanvas.height = oldCanvas.height;

    // Apply the old canvas to the new one.
    context.drawImage(oldCanvas, 0, 0);

    // Return the new canvas.
    return newCanvas;
};

/**
 * <p>Check if the mouse click falls on an area where the user can select text.</p>
 * @see {@link https://jsfiddle.net/abrady0/ggr5mu7o/}
 * @function
 * @memberof Util
 * @param {object} parentElt The parent element.
 * @param {decimal} x The x coordinate.
 * @param {decimal} y The y coordinate.
 */
Util.findClickedWord = function (parentElt, x, y) {
    var range = document.createRange();
    var words = parentElt.textContent.split(' ');
    var start = 0;
    var end = 0;
    for (var i=0; i<words.length; i++) {
        var word = words[i];
        end = start + word.length;
        range.setStart(parentElt, start);
        range.setEnd(parentElt, end);
        // Not getBoundingClientRect as word could wrap.
        var rects = range.getClientRects();
        var clickedRect = isClickInRects(rects);
        if (clickedRect) {
            return [word, start, clickedRect];
        }
        start = end + 1;
    }

    function isClickInRects(rects) {
        for (var i=0; i<rects.length; ++i) {
            var r = rects[i]
            if (r.left<x && r.right>x && r.top<y && r.bottom>y) {
                return r;
            }
        }
        return false;
    }
    return null;
}

/**
 * <p>Converts a height formatted label to inches.</p>
 * @see {@link https://www.experts-exchange.com/questions/24196185/Convert-Input-field-display-of-feet-and-inches-to-inches.html}
 * @function
 * @memberof Util
 * @param {string} height The height to convert. e.g. 5'7" (5 foot 7 inches), 6" (6 inches).
 * @returns {decimal}
 */
Util.heightToInches = function(height) {
    var ft = '', inches = '';
    if (height.match(/'/)) {
        var vals = height.split('\'');
        ft = vals.length > 0 && vals[0].length > 0 ? parseFloat(vals[0].replace('\'', '')) : 0;
        inches = vals.length > 1 && vals[1].length > 0 ? vals[1] : 0;
    }
    else {
        ft = 0;
        inches = height;
    }
    return (ft * 12) + parseFloat(inches);
}