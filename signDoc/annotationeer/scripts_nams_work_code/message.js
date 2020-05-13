/********************************************************************
 * Copyright (C) 2016-Present Mark Chester Goking <chitgoks@gmail.com>.
 *
 * This file is part of Annotationeer and it can not be copied
 * and/or distributed without the express permission of the author.
 ********************************************************************/

/**
 * <p>Message class - contains variables that references alert messages on various actions and events in Annotationeer.
 * If you do not wish to have these alert messages show up, you can set these variables to null.</p>
 * @namespace
 */

var Message = {};

/**
 * <p>This function checks if Annotationeer has a language property file based on the
 * browser's primary language. If no property file is found, it will load the
 * default english property file.</p>
 * @function
 * @memberof Message
 */
Message.initTranslations = function() {
	var language = Util.getLocaleOfBrowser();
	if (language.startsWith('en') && language.indexOf('-') > -1) {
		language = 'en';
	}

	$.ajax({
		type: 'HEAD',
		url: 'locale/' + language + '.properties',
		success: function() {
			document.webL10n.setLanguage(language);
		},
		error: function() {
			document.webL10n.setLanguage('en');
		}
	});
};

/**
 * <p>Since we are doing localization, the default values of the properties are the keys themselves and this
 * function will retrieve the translation text and assign them as the new value of the properties.</p>
 * @function
 * @memberof Message
 */
Message.loadTranslations = function() {
	var promises = [];

	// Place translations in a promise array for processing.
	for (var prop in Message) {
		//noinspection JSUnfilteredForInLoop
		var key = Message[prop];

		if (Util.isFunction(key))
			continue;

		if (PDFViewerApplication.l10n)
			promises.push(PDFViewerApplication.l10n.get(key.replace('{{', '').replace('}}', '')));
	}

	// Once promise array contains at least one object, wait till all promises are resolved, then
	// assign each translation based on the property looped from the object.
	if (promises.length > 0)
		Promise.all(promises).then(function(values) {
			var k = 0;
			for (var prop in Message) {
				if (!Message.hasOwnProperty(prop) || Util.isFunction(Message[prop]))
					continue;

				if (values[k] && values[k].startsWith('{{') && values[k].endsWith('}}')) {
					break;
				}

				Message[prop] = values[k];
				k++;
			}
		});
};

/**
 * Message string to delete the annotation.
 * @type {string}
 */
Message.ANNOTATION_DELETE_ASK = 'delete_annotation';
/**
 * Message string when saving annotation is successful.
 * @type {string}
 */
Message.ANNOTATION_SAVE_SUCCESS = 'save_success';
/**
 * Message string when saving annotation returns an error.
 * @type {string}
 */
Message.ANNOTATION_SAVE_ERROR = 'save_error';
/**
 * Message string when there is nothing to save.
 * @type {string}
 */
Message.ANNOTATION_SAVE_NOTHING = 'save_nothing';
/**
 * Message string if no comment is provided and the user attempts to save the comment.
 * @type {string}
 */
Message.COMMENT_REQUIREMENT = 'comment_req';

Message.WELDER_REQUIREMENT = 'welder_required';
/**
 * Message string when saving the comment returns an error.
 * @type {string}
 */
Message.COMMENT_SAVE_ERROR = 'comment_save_error';

Message.COMMENT_SAVE_ERROR_REPORT = 'Select Date of Febrication';
/**
 * Message string to delete the comment.
 * @type {string}
 */
Message.COMMENT_DELETE_ERROR = 'comment_delete_error';
/**
 * Message string when saving the review status returns an error.
 * @type {string}
 */
Message.REVIEW_STATUS_SAVE_ERROR = 'review_status_save_error';
/**
 * Message string if text selection overlaps between pages.
 * @type {string}
 */
Message.TEXT_SELECT_OVERLAP = 'text_select_overlap';
/**
 * Message string if text selection is required.
 * @type {string}
 */
Message.TEXT_SELECT_REQUIREMENT = 'text_select_req';
/**
 * Message string if there is no audio support.
 * @type {string}
 */
Message.AUDIO_NO_SUPPORT = 'audio_no_support';
/**
 * Message string if there is a conflict requirement.
 * @type {string}
 */
Message.SAVE_CONFLICT_REQUIREMENT = 'save_conflict_req';
/**
 * Message string if there are unsaved annotations and the user attempts to leave the page.
 * @type {string}
 */
Message.SAVE_UNSAVED = 'save_unsaved';
/**
 * Message string if the function {@link Annotationeer.saveAnnotation|Annotationeer.saveAnnotation()} does not exist.
 * @type {string}
 */
Message.FUNC_UNDEFINED_ANNO_SAVE = 'func_undef_anno_save';
/**
 * Message string if the function {@link Annotationeer.displayAnnotationMenu|Annotationeer.displayAnnotationMenu()} does not exist.
 * @type {string}
 */
Message.FUNC_UNDEFINED_ANNO_DISPLAY = 'func_undef_anno_display';

Message.ARROW_CREATE_REQUIREMENT = 'arrow_create_req';
/**
 * Message string if the arrow created is shorter than the minimum required.
 * @type {string}
 */
Message.ARROW_CREATE_LONGER = 'arrow_create_longer';
/**
 * Message string if the user is required to draw something.
 * @type {string}
 */
Message.DRAWING_CREATE_REQUIREMENT = 'draw_create_req';
/**
 * Message string if the rotation of the free text when modified is not 0 degrees.
 * @type {string}
 */
Message.FREETEXT_ROTATE_MODIFY = 'freetext_rotate_modify';
/**
 * Message string to alert the user the polyline is created in the wrong page.
 * @type {string}
 */
Message.POLY_LINE_CREATE_WRONG_PAGE = 'polyline_create_wrong_page';
/**
 * Message string for no comment.
 * @type {string}
 */
Message.NO_COMMENT = 'no_comment';
Message.ANNO_CREATED = 'Annotation Created';
/**
 * Message string if the feature is invokved but it is not yet overridden.
 * @type {string}
 */
Message.FEATURE_NOT_OVERRIDDEN = 'feature_not_overriden';
/**
 * Message string if there no images dragged to upload form.
 * @type {string}
 */
Message.STAMP_ADD_EMPTY = 'stamp_add_empty';
/**
 * Message string when saving the stamp returns an error.
 * @type {string}
 */
Message.STAMP_DELETE_ERROR = 'stamp_delete_error';
/**
 * Message string for not assigned.
 * @type {string}
 */
Message.NOT_ASSIGNED = 'not_assigned';
/**
 * Message string when providing signature is required.
 * @type {string}
 */
Message.PROVIDE_SIGNATURE = 'provide_signature';

Message.SELECT_STATUS = 'Please select status';
