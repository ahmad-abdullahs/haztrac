/********************************************************************
 * Copyright (C) 2016-Present Mark Chester Goking <chitgoks@gmail.com>.
 *
 * This file is part of Annotationeer and it can not be copied
 * and/or distributed without the express permission of the author.
 ********************************************************************/

/**
 * These are the properties that affect how Annotationeer behaves with its features.<br/>
 * These should be overridden and placed in {@link Override.overrideDefaultVariables|Override.overrideDefaultVariables()}.
 * @namespace
 */
var Default = { };

/**
 * By default, its value is based on computation is 4096 width X 4096 height. If the canvas size
 * is more than that, the renderings can be blurry and its mouse position will be out of place.
 * To disable this, set value at -1 but the performance will be noticeable as there will be a lag.
 *
 * Usually, the good optimal max zoom value at 2.5 or 250%. Any zoom value more than that and you
 * will notice some blurriness that would indicate that mouse positions will get out of place because
 * the value of width * height of the canvas is more than the default (4096x4096) of PDF.JS.
 */
//PDFJS.maxCanvasPixels = -1;

// Annotationeer variable settings
Default.canvasIdName = 'pageAnnotation';

/**
 * Z-Index property for the Annotationeer canvas.
 * @default 1000
 * @type {number}
 */
Default.zIndex = 1000;

/**
 * Z-Index property for the annotation tooltip.
 * @default 99999
 * @type {number}
 */
Default.zIndex_TOOLTIP = 99999;

/**
 * Radius of click around the first point to close the draw. Do not change.<br/>
 * For use by annotations of poly line type.
 * @default 15
 * @type {number}
 */
Default.END_CLICK_RADIUS = 15;

/**
 * For use in {@link PageManager.setCuror|PageManager.setCuror()} calls. Do not change.
 * @default 12
 * @type {number}
 */
Default.CURSOR_CROSSHAIR_PIXEL_SIZE = 12;

/**
 * Annotationeer will generate events related to annotation actions. Default is false.
 * @type {boolean}
 */
Default.CREATE_ANNOTATION_EVENTS = false;

/**
 * <p>The font unit to be used. It is advisable not to use any other font type like pt.
 * Chrome/IE renders font sizes differently from Firefox. Change at our own risk.</p>
 * @default px
 * @type {string}
 */
Default.FONT_SIZE_TYPE = 'px';

/**
 * The default font size for annotations that use text.
 * @default 15
 * @type {number}
 */
Default.FONT_SIZE = '15';

/**
 * The default font for annotations that use text.<br/>
 * Now changed to Helvetica so that font support in iText will not require an embedded font.<br/>
 * Helvetica is one of 14 standard type-1 fonts. The others being Times, Courier and Symbol.
 * @default Helvetica
 * @type {string}
 */
Default.FONT_TYPE = 'Helvetica';

/**
 * The default font size watermark labels in pixel.
 * @default 90
 * @type {number}
 */
Default.WATERMARK_FONT_SIZE = 90;

/**
 * The default font for watermark labels.
 * @default tahoma
 * @type {string}
 */
Default.WATERMARK_FONT_TYPE = 'tahoma';

/**
 * Show watermark in every page.
 * @default true
 * @type {boolean}
 */
Default.WATERMARK_SHOW = true;

/**
 * <p>Sets how the watermark will be displayed.</p>
 * The following options are available.
 * <ul>
 *     <li>WatermarkOrientation.CENTER_VERTICAL</li>
 *     <li>WatermarkOrientation.CENTER_HORIZONTAL</li>
 *     <li>WatermarkOrientation.CENTER_DIAGONAL</li>
 *     <li>WatermarkOrientation.UPPER_RIGHT_HORIZONTAL</li>
 *     <li>WatermarkOrientation.UPPER_LEFT_HORIZONTAL</li>
 * </ul>
 * @default {@link WatermarkOrientation.CENTER_VERTICAL}
 * @type {number}
 */
Default.WATERMARK_ORIENTATION = WatermarkOrientation.CENTER_VERTICAL;

/**
 * Set the border color of the screenshot when selecting a boundary.
 * @default red
 * @type {string}
 */
Default.SCREENSHOT_BORDER_COLOR = 'red';

/**
 * The default fill opacity for annotations that use background. Value should be between 0-1.
 * @default 0.3
 * @type {decimal}
 */
Default.FILL_OPACITY = 0.3;

// Default screen shot background color. Change to your preference
var hexScreenShotColor = '#d4bdc8';
var rgbScreenShot = Util.hexToRgb(hexScreenShotColor);

/**
 * The default screenshot fill color. Value should be in rgba().
 * @type {string}
 */
Default.SCREENSHOT_FILL_COLOR = 'rgba(' + rgbScreenShot.r + ', ' + rgbScreenShot.g + ', ' + rgbScreenShot.b + ', ' + Default.FILL_OPACITY + ')';

/**
 * The screenshot background color outside the selected boundary that mimics a dim background effect. Value should be in rgba().
 * @type {string}
 */
Default.SCREENSHOT_DIM_COLOR = 'rgba(0, 0, 0, ' + Default.FILL_OPACITY + ')';

/**
 * If you want annotations to be included in screenshot.
 * @default false
 * @type {boolean}
 */
Default.SCREENSHOT_INCLUDE_ANNOTATIONS = false;

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
Default.DRAW_COLOR_BACKGROUND = '#ffff00';

/**
 * The default line thickness for annotations that use this feature.
 * @default 1
 * @type {number}
 */
Default.DRAW_WIDTH = 2;

/**
 * <p>The style of the end cap when drawing lines. Possible alues for the lineCap property are butt(default)|round|square.</p>
 * @default square
 * @type {string}
 */
Default.DRAW_LINECAP = 'square';

/**
 * <p>The style of the corner when two lines meet. Possible alues for the lineJoin property are bevel|round|miter(default).</p>
 * @default miter
 * @type {string}
 */
Default.DRAW_LINEJOIN = 'miter';

// This is used to draw a virtual line with thickness so that mouse clicks can be captured easily.
Default.DRAW_WIDTH_THICKNESS_FOR_MOUSE_CLICK = 6;

/**
 * Sets the required minimum number of points for a drawing annotation. If not, then a message pops up informing<br/>
 * the user that the drawing is too short.
 * @default 10
 * @type {number}
 */
// ahmad
Default.DRAW_POINT_MINIMUM = 1;

/**
 * The default border color for annotations that use this feature.
 * @default red
 * @type {string}
 */
Default.ANNOTATION_BOX_COLOR = 'red';

/**
 * The color of the image upon creation will be based on the background color from the color picker.
 * @default false
 * @type {boolean}
 */
Default.ANNOTATION_IMAGE_COLOR_BASE_ON_COLOR_PICKER = false;


/**
 * Draw text inside a shape. Most likely a measurement area annotation.
 * @default false
 * @type {boolean}
 */
Default.ANNOTATION_DRAW_TEXT_IN_SHAPE = false;

/**
 * The default thickness for annotations that use lines or borders.
 * @default 2
 * @type {number}
 */
Default.ANNOTATION_SELECTED_LINEWIDTH = 2;

Default.ANNOTATION_SELECTED_COLOR = '#cc0000';

/**
 * The default color of the boundary box when an annotation is selected.
 * @default darkred
 * @type {string}
 */
Default.ANNOTATION_SELECTION_BOX_COLOR = 'darkred';

/**
 * The size in pixel of the selection handle for dragging.
 * @default 8
 * @type {number}
 */
Default.ANNOTATION_SELECTION_BOX_SIZE = 8;

/**
 * The default border color of the free text annotation when selected.
 * @default 1px solid red
 * @type {string}
 */
Default.ANNOTATION_SELECTION_BOX_COLOR_TYPE_TEXT = '1px solid red';

/**
 * <p>The default id prefix that will be used when generating a name for the id property of the DIV element
 * for free text annotations.</p>
 * @default texts
 * @type {string}
 */
Default.ANNOTATION_ID_PREFIX_FREE_TEXT = 'texts';

/**
 * <p>The default id prefix that will be used when generating a name for the id property of the form element.</p>
 * @default form
 * @type {string}
 */
Default.ANNOTATION_ID_PREFIX_FORM_FIELD = 'form';

/**
 * <p>The default id prefix that will be used when generating a name for the id property of the DIV element
 * for text selection annotations.</p>
 * @default highlight
 * @type {string}
 */
Default.ANNOTATION_ID_PREFIX_HIGHLIGHT_TEXT = 'highlight';

/**
 * When an annotation is created, its tool bar button will be toggled. Default is true.
 * @type {boolean}
 */
Default.ANNOTATION_BUTTON_TOGGLED = true;

/**
 * Change the title of the pressed button to "Stop [button title]".
 * @default true
 * @type {boolean}
 */
Default.ANNOTATION_BUTTON_TOGGLED_CHANGE_TITLE = true;

/**
 * The arrow annotation will require a minimum length in order for it to be created.
 * @default true
 * @type {boolean}
 */
Default.ANNOTATION_ARROW_MINIMUM_LENGTH = true;

/**
 * Look up the values in the measurement_types table in the database for your preferred default value.<br/>
 * 1 is inches.
 * @default {@link LineStyle.SOLID}
 * @type {number}
 */
Default.ANNOTATION_LINE_STYLE_DEFAULT = LineStyle.SOLID;

/**
 * The measurement distance will require a minimum length in order for the annotation to be created.
 * @default true
 * @type {boolean}
 */
Default.ANNOTATION_MEASUREMENT_DISTANCE_MINIMUM_LENGTH = true;

/**
 * This is a fixed setting for the font size label on the measurement distance annotation.
 * @default 12
 * @type {number}
 */
Default.ANNOTATION_MEASUREMENT_DISTANCE_LABEL_FONT_SIZE = 12;

/**
 * <p>Sets the default measurement type.</p>
 * The following options are available.
 * <ul>
 *     <li>MeasurementType.INCHES</li>
 *     <li>MeasurementType.CENTIMETERS</li>
 *     <li>MeasurementType.MILLIMETERS</li>
 *     <li>MeasurementType.FOOT_INCH</li>
 * </ul>
 * @default {@link MeasurementType.INCHES}
 * @type {number}
 */
Default.ANNOTATION_MEASUREMENT_TYPE_DEFAULT = MeasurementType.INCHES;

/**
 * <p>Maximum number of points for shape. If area measurement annotation reaches number
 * of max points without closing the polygon, it will close it.</p>
 *
 * <p>This should not be changed as this is also the value used by annotations that square
 * shaped and its max selection handles is 8.</p>
 * @default 8
 * @type {number}
 */
Default.ANNOTATION_SELECTION_MAX_POINTS = 8;

/**
 * <p>The default width of the stamp SVG images bundled with Annotationeer. This value has to be set because
 * IE is an idiot for not being able to identify an image's width/height when source is set, we manually set
 * preferred width and height.</p>
 * @default 188
 * @type {number}
 */
Default.ANNOTATION_STAMP_WIDTH = 188;

/**
 * <p>The default height of the stamp SVG images bundled with Annotationeer. This value has to be set because
 * IE is an idiot for not being able to identify an image's width/height when source is set, we manually set
 * preferred width and height.</p>
 * @default 100
 * @type {number}
 */
Default.ANNOTATION_STAMP_HEIGHT = 100;

/**
 * <p>The default width/height of the sticky note icon bundled with Annotationeer. This value has to be set because
 * IE is an idiot for not being able to identify an image's width/height when source is set, we manually set
 * preferred width and height.</p>
 *
 * <p>If you plan to use a different sticky note image, change this property. It has to be the same for width and
 * height. Default value is 22.</p>
 * @type {number}
 */
Default.ANNOTATION_ICON_SIDE = 22;

/**
 * <p>The minimum value for the font size. This will be used as part of the range option given to the user.</p>
 * @default 6
 * @type {number}
 */
Default.ANNOTATION_TYPE_TEXT_FONT_SIZE_RANGE_MIN = 6;

/**
 * <p>The maximum value for the font size. This will be used as part of the range option given to the user.</p>
 * @default 24
 * @type {number}
 */
Default.ANNOTATION_TYPE_TEXT_FONT_SIZE_RANGE_MAX = 24;

/**
 * <p>By default, a free text annotation is not multi-line. This property sets the maximum number of characters
 * allowed.</p>
 * @default 20
 * @type {number}
 */
Default.ANNOTATION_TYPE_TEXT_CHAR_LIMIT = 20;

/**
 * <p>Once PDF.JS perfects its text layer positioning, set this to false so that the auto-adjust code for
 * strike-through position will be ignored.</p>
 * @default true
 * @type {boolean}
 */
Default.ANNOTATION_STRIKE_THROUGH_ADJUST = true;

/**
 * A button will be added in the annotation toolbar as well as the annotation sidebar list to toggle
 * display or hide an annotation or all annotations.
 * @default false
 * @type {boolean}
 */
Default.ANNOTATION_SHOW_HIDE_FEATURE = false;

/**
 * The export button will be enabled and shown.
 * @default false
 * @type {boolean}
 */
Default.ANNOTATION_EXPORT_ENABLED = false;

/**
 * <p>The distance of the arrowhead backtip from the line.</p>
 * @default 5
 * @type {number}
 */
Default.ARROW_SIZE = 5;

/**
 * <p>The length of the arrowhead.</p>
 * @default 9
 * @type {number}
 */
Default.ARROWHEAD_LENGTH = 9;

/**
 * <p>If true, annotation TYPE_TEXT will show a prompt popup for user to input text in. To modify it,
 * it will be available as an input text field under the properties window.</p>
 *
 * <p>If false, user will type the text and its div layer will expand as it sees fit. To modify it,
 * it will be available as a text area field because user can have line breaks between words.</p>
 * @default true
 * @type {boolean}
 */
Default.TYPE_TEXT_1_LINER = true;

/**
 * This will serve as the default text to be set if user does not set any text due to maybe
 * pressing ESC key or annotation lost its focus.
 * @default Change text
 * @type {string}
 */
Default.TYPE_TEXT_DEFAULT_TEXT_IF_EMPTY = 'Change text';

/**
 * If true, an expand/collapse icon will appear on the left side of the action pane where upon clicking
 * on it, will show the comments of the annotation.
 * @default false
 * @type {boolean}
 */
Default.ANNOTATION_LIST_COMMENTS_SHOW = false;

// Expands the comments of the "selected annotation" in the sidebar.
Default.ANNOTATION_LIST_COMMENTS_EXPAND_SELECTED = 0;
// Expands the comments of the all annotations in the sidebar.
Default.ANNOTATION_LIST_COMMENTS_EXPAND_ALWAYS = 1;
/**
 * <p>Sets how the behavior of comments in the sidebar will be displayed.</p>
 * The following options are available.
 * <ul>
 *     <li>Default.ANNOTATION_LIST_COMMENTS_EXPAND_SELECTED</li>
 *     <li>Default.ANNOTATION_LIST_COMMENTS_EXPAND_ALWAYS</li>
 * </ul>
 * @default Default.ANNOTATION_LIST_COMMENTS_EXPAND_SELECTED
 * @type {number}
 */
Default.ANNOTATION_LIST_COMMENTS_EXPAND = Default.ANNOTATION_LIST_COMMENTS_EXPAND_SELECTED;

/**
 * All sticky note annotations will show a popup after creation. If false, no popup will show
 * unless the user selects edit or reply from the right click popup menu.
 * @default true
 * @type {boolean}
 */
Default.ANNOTATION_STICKY_NOTE_POPUP_ON_CREATE = true;

/**
 * <p>Annoations related to square type shapes can get the text on top of it. The function {@link Annotation.Annotation#getTextBelowIt|Annotation.getTextBelowIt()}
 * in Annotation prototype works fast in Chrome but typically slow in IE.</p>
 *
 * Implementation is a hack so use with caution.
 * @default false
 * @type {boolean}
 */
Default.ANNOTATION_GET_TEXT_BELOW_IT = false;

/**
 * <p>When user hovers over an annotation, it will show a selectable border similar to when an annotation is selected,
 * but without the selection handles.</p>
 * @default false
 * @type {boolean}
 */
Default.ANNOTATION_SELECTABLE_TEXT_SHOW_ON_HOVER = false;

/**
 * <p>Added this variable for historical purposes sake. Selectable text type annotations like highlight, underline
 * and strike through are better off drawn in canvas compared to having them as DIV layers as this may have
 * performance issues on large documents with so many div layers.</p>
 * @default false
 * @type {boolean}
 */
Default.ANNOTATION_SELECTABLE_TEXT_AS_DIV = false;

/**
 * <p>All annotations will be saved when user clicks the save button. If user leaves the page,
 * the onBeforeUnload event will check if there are annotations that need saving.</p>
 *
 * <p>If yes, it will prompt the user that there are annotations that need saving, or else the changes
 * will be discarded.</p>
 * @default true
 * @type {boolean}
 */
Default.SAVE_ALL_ANNOTATIONS_ONE_TIME = true;

/**
 * This is a universal setting to set all annotations to read-only. If an annotation's property is<br/>
 * not read-only and this setting is, the universal setting will be followed.
 * @default false
 * @type {boolean}
 */
Default.ANNOTATIONS_READ_ONLY = false;

/**
 * Show tooltips on annotations when hovered. Tooltip will not be used if in mobile mode.
 * @default true
 * @type {boolean}
 */
Default.ANNOTATIONS_TOOLTIP = true;

/**
 * Show tooltips after delay in ms.
 * @default 500
 * @type {number}
 */
Default.ANNOTATIONS_TOOLTIP_DELAY_SHOW = 500;

/**
 * Sets the maximum number of characters to be displayed in the tooltip. If 0, all text will be shown.
 * @default 20
 * @type {number}
 */
Default.ANNOTATIONS_TOOLTIP_MAX_CHARS = 20;

/**
 * Enable feature to create audio annotations.
 * @default fa;se
 * @type {boolean}
 */
Default.ANNOTATIONS_AUDIO = false;

/**
 * <p>A new button with a color picker icon will be visible in the annotation toolbar.
 * The user can then navigate anywhere in the PDF pages and get the pixel coordinate
 * which will the RGB color.</p>.
 *
 * Note that annotations on top of the PDF page canvas will be ignored.
 * @default false
 * @type {boolean}
 */
Default.PAGE_COLOR_PICKER_ENABLED = false;

/**
 * <p>Filtering by date will include checking the annotation's comments' dateModified property if they are equal.</p>
 * @default false
 * @type {boolean}
 */
Default.FILTER_INCLUDE_COMMENT_DATE_MODIFIED = false;

/**
 * Enable feature to create form fields as annotations (text field, checkbox, radio button).
 * @default false
 * @type {boolean}
 */
Default.INCLUDE_FORM_FIELDS = false;

/**
 * The minimum size for width and height in pixel when a form field annotation is resized.
 * @default 20
 * @type {number}
 */
Default.FORM_FIELD_SIZE_MINIMUM = 20;

/**
 * The default width in pixels for the newly created input text field.
 * @default 162
 * @type {number}
 */
Default.FORM_FIELD_TEXTFIELD_SIZE_WIDTH = 162;

/**
 * The default height in pixels for the newly created input text field.
 * @default 19
 * @type {number}
 */
Default.FORM_FIELD_TEXTFIELD_SIZE_HEIGHT = 19;

/**
 * Use the Toastr 3rd party library to display non-blocking alert replacing the native one.
 * @default false
 * @type {boolean}
 */
Default.ALERT_BEAUTIFY = false;

/**
 * Show a prompt when attempting to delete an annotation.
 * @default false
 * @type {boolean}
 */
Default.ALERT_DELETE = false;

/**
 * Each comment can have a review status set by a user. Please note that {@link Default.COMMENT_FEATURE_STATUS_DISPLAY}<br/>
 * must also be set to true. No point for a user to be able to set a review status on a comment and not see them.<br/>
 * @default false
 * @type {boolean}
 */
Default.COMMENT_FEATURE_STATUS_ENABLED = false;

/**
 * <p>A comment with review status will be shown if available. This is not related to {@link Default.COMMENT_FEATURE_STATUS_ENABLED}
 * where it allows a user to set a review status on a comment or not.</p>
 * @default false
 * @type {boolean}
 */
Default.COMMENT_FEATURE_STATUS_DISPLAY = false;

/**
 * <p>The property used by {@link Default.DOUBLE_CLICK_WHAT_EVENT} if the double click event will show the properties
 * dialog.</p>
 * @type {number}
 */
Default.DOUBLE_CLICK_SHOW_PROPERTIES = 0;

/**
 * <p>The property used by {@link Default.DOUBLE_CLICK_WHAT_EVENT} if the double click event will show the comment list
 * dialog.</p>
 * @type {number}
 */
Default.DOUBLE_CLICK_SHOW_COMMENT_POPUP = 1;
/**
 * <p>Sets what the double click event will product.</p>
 * The following options are available.
 * <ul>
 *     <li>Default.DOUBLE_CLICK_SHOW_PROPERTIES</li>
 *     <li>Default.DOUBLE_CLICK_SHOW_COMMENT_POPUP</li>
 * </ul>
 * @default {@link Default.DOUBLE_CLICK_SHOW_PROPERTIES}
 * @type {number}
 */
Default.DOUBLE_CLICK_WHAT_EVENT = Default.DOUBLE_CLICK_SHOW_PROPERTIES;

/**
 * Enables feature to add custom stamps based on the user who uploaded them.
 * @default false
 * @type {boolean}
 */
Default.STAMP_CUSTOM_ENABLED = false;

/**
 * The arc radius of the cloud annotation's circle shape.
 * @default 12
 * @type {number}
 */
Default.CLOUD_RADIUS = 12;

/**
 * The arc distance relative to the radius of the cloud annotation.
 * @default 0.8333
 * @type {decimal}
 */
Default.CLOUD_OVERLAP = 0.8333;

/**
 * Determines if the corner arcs should coincide.
 * @default true
 * @type {boolean}
 */
Default.CLOUD_STRETCH = true;

/**
 * Determines how long the cloud shapes in the cloud annotation stretches.
 * @default 15
 * @type {number}
 */
Default.CLOUD_INCISE = 15;

/**
 * The bookmark feature will be enabled. Default is false.
 * @type {boolean}
 */
Default.BOOKMARK_ENABLE = false;

/**
 * Show console messages.
 * @default true
 * @type {boolean}
 */
Default.CONSOLE_LOG_ENABLE = true;

/**
 * Delay in milliseconds how the mousestop event will run the function in the listener.
 * @default 500
 * @type {number}
 */
Default.MOUSE_STOP_DELAY = 500;