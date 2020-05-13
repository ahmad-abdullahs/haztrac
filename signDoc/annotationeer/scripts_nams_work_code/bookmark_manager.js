/********************************************************************
 * Copyright (C) 2016-Present Mark Chester Goking <chitgoks@gmail.com>.
 *
 * This file is part of Annotationeer and it can not be copied
 * and/or distributed without the express permission of the author.
 ********************************************************************/

/**
 * Everything about bookmarks.<br/>
 * @namespace Bookmark
 */
Bookmark.prototype = {};

/**
 * @constructor
 * @memberof Bookmark
 */
function Bookmark() {
	/**
	 * The id of the bookmark.
	 * @type {number}
	 */
	this.id = 0;
	/**
	 * The page index where the bookmark belongs to
	 * @type {number}
	 */
	this.pageIndex = -1;
	/**
	 * The id of the document.
	 * @type {number}
	 */
	this.docId = Annotationeer.currentDocument.documentId;
	/**
	 * The parent id of the bookmark.
	 * @type {number}
	 */
	this.parentId = 0;
	/**
	 * The hierarchy order of the bookmark.
	 * @type {number}
	 */
	this.hierarchy = 0;
	//noinspection JSUnusedGlobalSymbols
	/**
	 * The user who created the bookmark.
	 * @type {string}
	 */
	this.createdBy = Annotationeer.getUsername();
	/**
	 * The label text display of the bookmark/
	 * @type {string}
	 */
	this.label = '';
	/**
	 * The zoom value of the PDF page.
	 * @type {decimal}
	 */
	this.zoom = 0;
	/**
	 * <p>The x coordinate where the bookmark should zoom into based on the PDF coordinate space.</p>
	 * @type {decimal}
	 */
	this.pageX = 0;
	/**
	 * <p>The y coordinate where the bookmark should zoom into based on the PDF coordinate space.</p>
	 * @type {decimal}
	 */
	this.pageY = 0;
	/**
	 * The page width of the document where the bookmark was created.
	 * @type {number}
	 */
	this.pageWidth = 0;
	/**
	 * The page height of the document where the bookmark was created.
	 * @type {number}
	 */
	this.pageHeight = 0;
	/**
	 * The date of the bookmark when it was first created.
	 * @type {object}
	 */
	this.dateCreated = new Date();
	/**
	 * The date of the bookmark when it was last modified.
	 * @type {object}
	 */
	this.dateModified = new Date();
}

/**
 * Everything about how bookmarks are handled.<br/>
 * @namespace BookmarkManager
 */
var BookmarkManager = { };

/**
 * Bookmark entries of the document.
 * @type {Array}
 */
BookmarkManager.bookmarks = [];

/**
 * Initialize the tree.
 * @function
 * @memberof BookmarkManager
 */
BookmarkManager.init = function() {
	var treeElement = $('div#bookmarks');
	var tree = treeElement.jstree(true);
	if (tree)
		tree.destroy();
	treeElement.empty();

	$('button#viewBookmarks').removeClass('hidden');

	// Disable browser context menu in the bookmark area.
	treeElement.on('contextmenu', function(e) {
		e.preventDefault();
	});

	treeElement.jstree({
		plugins: ['contextmenu', 'dnd'],
		core : {
			// So that create works.
			check_callback : true,
			// Disable multiple selection.
			multiple: false,
			themes: {
				name: 'default-dark',
				icons: false
			},
			keyboard: {
				f2: function(e) {
					// Disable for now.
					e.preventDefault();
				}
			}
		},
		contextmenu: {
			items: function(node) {
				var tree = $('div#bookmarks').jstree(true);
				return {
					add: {
						separator_before: false,
						separator_after: false,
						label: '<span data-l10n-id="add_label">Add</span>',
						action: function() {
							var bookmark = BookmarkManager.createNewInstance();
							var newnode = { 'id' : bookmark.id , 'text' : 'Bookmark' };
							tree.deselect_all();
							tree.create_node(node.id, newnode, 'last');
							tree.edit(newnode);
							BookmarkManager.replaceWithCustomEdit(tree, newnode);
						}
					},
					rename: {
						separator_before: false,
						separator_after: false,
						icon: false,
						label: '<span data-l10n-id="rename_label">Rename</span>',
						action: function() {
							tree.edit(node);
							BookmarkManager.replaceWithCustomEdit(tree, node);
						}
					},
					delete: {
						separator_before: false,
						separator_after: false,
						icon: false,
						label: '<span data-l10n-id="delete_label">Delete</span>',
						action: function() {
							var children = [ node.id ];

							if (node.children_d.length > 0)
								children.push(node.children_d);

							BookmarkManager.deleteBookmark(children.join());
							tree.delete_node(node);
						}
					}
				};
			}
		}
	});

	treeElement.on('move_node.jstree', function(e, data) {
		var jsTreeNode = $('div#bookmarks').jstree(true).get_node(data.node);
		var bookmark = BookmarkManager.getBookmarkFromList(jsTreeNode);
		bookmark.parentId = isNaN(jsTreeNode.parent) ? 0 : jsTreeNode.parent;
		BookmarkManager.saveBookmark(bookmark, data.node);
	});

	$(document).bind('context_show.vakata', function(reference, element) {
		PageManager.translateEachL10n($('ul.vakata-context').first());

		// Lisener to disable browser context menu from showing up on JSTree context menu.
		element.element[0].addEventListener('contextmenu', function(e) {
			e.preventDefault();
		});
	});

	treeElement.on('rename_node.jstree', function(e, data) {
		var bookmark = BookmarkManager.getBookmarkFromList(data.node);
		bookmark.label = data.text;
		bookmark.parentId = data.node.parent == '#' ? 0 : data.node.parent;
		bookmark.dateModified = new Date();
		BookmarkManager.saveBookmark(bookmark, data.node);
	});

	treeElement.on('select_node.jstree', function(e, data) {
		var bookmark = BookmarkManager.getBookmarkFromList(data.node);
		BookmarkManager.gotoPage(bookmark);
	});

	// Remove this event from being listened so that when user is in edit mode, letters that are typed
	// will not be triggered to search for nodes that start with that letter.
	treeElement.off('keypress.jstree');

	BookmarkManager.createBookmarkTree();
};

/**
 * Creates the tree for the document's bookmarks.
 * @function
 * @memberof BookmarkManager
 */
BookmarkManager.createBookmarkTree = function() {
	if (BookmarkManager.bookmarks.length == 0)
		return;

	var tree = $('div#bookmarks');

	for (var i = 0; i < BookmarkManager.bookmarks.length; ++i) {
		var b = BookmarkManager.bookmarks[i];
		if (b.parentId == 0)
			b.parentId = '#';

		tree.jstree(true).create_node(b.parentId, {
			id: b.id,
			parentId: b.parentId,
			text: b.label
		});
	}

	tree.jstree('open_all');
};

/**
 * Adds a bookmark entry node in the tree.
 * @function
 * @memberof BookmarkManager
 * @returns {object} This is returned so user can know what details to save bookmark.
 */
BookmarkManager.addBookmark = function() {
	var bookmark = BookmarkManager.createNewInstance();
	var node = { 'id' : bookmark.id , 'text' : 'Bookmark' };
	var tree = $('#bookmarks').jstree(true);
	tree.deselect_all();
	tree.create_node('#', node, 'last');
	tree.edit(node);
	BookmarkManager.replaceWithCustomEdit(tree, node);
	return node;
};

/**
 * Creates a new bookmark object and adds it to the bookmarks array.
 * @function
 * @memberof BookmarkManager
 * @returns {Bookmark}
 */
BookmarkManager.createNewInstance = function() {
	var bookmark = new Bookmark();
	bookmark.id = -BookmarkManager.bookmarks.length - 1;
	bookmark.zoom = PDFViewerApplication.pdfViewer.currentScale;
	bookmark.pageX = PDFViewerApplication.pdfViewer._location.left;
	bookmark.pageY = PDFViewerApplication.pdfViewer._location.top;
	bookmark.pageIndex = PDFViewerApplication.pdfViewer._location.pageNumber - 1;
	bookmark.createdBy = Annotationeer.getUsername();

	var page = pages[Default.canvasIdName + (bookmark.pageIndex + 1)];
	bookmark.pageWidth = PageManager.getPageWidth(page.canvas.width, page.canvas.height) / bookmark.zoom;
	bookmark.pageHeight = PageManager.getPageHeight(page.canvas.width, page.canvas.height) / bookmark.zoom;

	BookmarkManager.bookmarks.push(bookmark);
	return bookmark;
};

/**
 * Gets a bookmark reference from the bookmarks array.
 * @function
 * @memberof BookmarkManager
 * @param {object} node The tree node.
 * @returns {Bookmark}
 */
BookmarkManager.getBookmarkFromList = function(node) {
	for (var i=0; i<BookmarkManager.bookmarks.length; ++i) {
		var b = BookmarkManager.bookmarks[i];
		if (node.id == b.id) {
			return b;
		}
	}
};

/**
 * Saves bookmark to the database.
 * @function
 * @memberof BookmarkManager
 * @param {Bookmark} bookmark The bookmark object.
 * @param {object} node After saving, the reference node's id will also be updated.
 */
BookmarkManager.saveBookmark = function(bookmark, node) {
	PageManager.consoleLog('BookmarkManager.saveBookmark()');

	// This will be used to update the hierarchy order of each node.
	bookmark.hierarchyJson = BookmarkManager.createJsonHierarchy();

	$.ajax({
		url: Url.restUrl + Url.bookmarkSaveUrl,
		type: 'post',
		data: Util.jsonStringify(bookmark),
		contentType: 'application/json',
		dataType: 'json',
		cache: false,
		success: function(response) {
			// Update array if this was an insert transaction.
			if (response.oldId) {
				for (var i = 0; i < BookmarkManager.bookmarks.length; ++i) {
					var b = BookmarkManager.bookmarks[i];
					if (response.oldId == b.id) {
						b.id = response.id;
						// Update id in the tree.
						$('div#bookmarks').jstree(true).set_id(node, response.id);
					}
				}
			}

			PageManager.consoleLog('Save successful. Id: ' + bookmark.id);
		},
		error: function(xhr, status, error) {
			PageManager.consoleLog('Error saving bookmark: ' + error);
		}
	});
};

/**
 * Deletes bookmarks based on a comma delimeted string.
 * @function
 * @memberof BookmarkManager
 * @param {string} bookmarkIds
 */
BookmarkManager.deleteBookmark = function(bookmarkIds) {
	$.ajax({
		url: Url.restUrl + Url.bookmarkDeleteUrl,
		type: 'delete',
		data: Util.jsonStringify({
			ids: bookmarkIds
		}),
		contentType: 'application/json',
		dataType: 'json',
		cache: false,
		success: function() {
			var arr = bookmarkIds.split(',');
			for (var i = 0; i < BookmarkManager.bookmarks.length; ++i) {
				if (arr.indexOf(BookmarkManager.bookmarks[i].id) > -1) {
					BookmarkManager.bookmarks.splice(i, 1);
					--i;
					break;
				}
			}

			PageManager.consoleLog('Delete bookmark successful.');
		},
		error: function(xhr, status, error) {
			PageManager.consoleLog('Error deleting annotation: ' + error);
		}
	});
};

/**
 * This function returns a json where the key is the id and the value is
 * the hierarchy order for the nodes.
 * @function
 * @memberof BookmarkManager.
 * @returns {string}
 */
BookmarkManager.createJsonHierarchy = function() {
	var array = $('div#bookmarks').jstree().get_json('#', { 'flat': true });
	var json = [];
	for (var a=0; a<array.length; a++) {
		json.push({
			id : array[a].id,
			hierarchy : a + 1
		});
	}
	return Util.jsonStringify(json);
};

/**
 * When the tree node is clicked, it will navigate to the page where the bookmark is linked to.
 * @function
 * @memberof BookmarkManager
 * @param {object} bookmark The bookmark object.
 */
BookmarkManager.gotoPage = function(bookmark) {
	PDFViewerApplication.pdfViewer.currentScale = bookmark.zoom;
	//noinspection JSUnresolvedFunction
	PDFViewerApplication.pdfViewer.scrollPageIntoView({
		pageNumber: (bookmark.pageIndex + 1),
		destArray: [ null, { name: 'XYZ' }, bookmark.pageX, bookmark.pageY, null],
		allowNegativeOffset: true
	});
};

/**
 * Replace default input field with textarea.
 * @function
 * @memberof BookmarkManager
 * @param {object} tree The JSTree object.
 * @param {object} node The tree node.
 */
BookmarkManager.replaceWithCustomEdit = function(tree, node) {
	var textarea = $('<textarea></textarea>');
	textarea.addClass('jstree-rename-input');
	textarea.attr('rows', 1);
	textarea.val(node.text);

	var input = $('.jstree-rename-input');
	input.replaceWith(textarea);

	// Remove classes of span tag. This needs to be called after the
	// input field is replaced or else layout will be messed up.
	textarea.parent().removeClass();
	textarea.focus();

	var textAreaRenameInput = $('textarea.jstree-rename-input');

	// Autosize textarea @ https://stephanwagner.me/auto-resizing-textarea
	textAreaRenameInput.on('keyup input', function() {
		//noinspection JSUnresolvedVariable
		var offset = this.offsetHeight - this.clientHeight;
		//noinspection JSUnresolvedVariable
		$(this).css('height', 'auto').css('height', this.scrollHeight + offset);
	});

	textAreaRenameInput.on('keydown', function(e) {
		// Enter key
		if (e.which == 13) {
			e.preventDefault();
			e.stopPropagation();
		}
	});

	textAreaRenameInput.on('blur', function(e) {
		e.stopImmediatePropagation();
		e.preventDefault();
		var li = textarea.parent();
		li.append('<a class="jstree-anchor" href="#" tabindex="-1" id="' + li.attr('aria-labelledby') + '"><i class="jstree-icon jstree-themeicon" role="presentation"></i>' + textarea.val() + '</a>');
		tree.rename_node(node, textarea.val());
		textarea.remove();
	});

	// Trigger an input event so that height will be resized by default just like when user types.
	textarea.trigger('input');
};
