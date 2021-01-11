/********************************************************************
 * Copyright (C) 2016-Present Mark Chester Goking <chitgoks@gmail.com>.
 *
 * This file is part of Annotationeer and it can not be copied
 * and/or distributed without the express permission of the author.
 ********************************************************************/

var app = angular.module('annotationList', ['ngSanitize', 'Util']);

app.controller('AnnotationListController', function($compile, $filter, $rootScope, $scope, $timeout, $window, UtilService) {
    $scope.annotations = $window.annotations;
    // Dummy variable, not of use because when calling functions from Vanilla JS, this does not get updated even with ng-model.
    $scope.filter = { text : '' };
    $scope.sortOption = 'pageIndex';
    // Used to store reference to currently selected annotation to show comments.
    $scope.annotationShowComments = null;
    $scope.UtilService = UtilService;

    // This is called after $digest() finishes running. The third argument is set to false to prevent another digest cycle trigger.
    $timeout(function() {
        if ($scope.alwaysExpandComments())
            $scope.expandCommentsOfAnnotations();

        // Initialize filter options if there are annotations upon download.
        $window.PageManager.initFilterOptions();

        // Click listener for the filter options.
        var className = 'selected-filter';
        // This executes twice if loaded in Angular JS. So we unbind first then bind.
        $('div#filter-options-container').off().on('click', function(e) {
            var span = $(e.target);

            // If clicked is image tag, pass reference to its parent which is span.
            if (span.prop('tagName').toLowerCase() == 'img')
                span = span.parent();

            if (span.hasClass(className))
                span.removeClass(className);
            else
                span.addClass(className);

            $('input#search-comments-input').val('');
            $scope.filterAnnotations();
        });

        $scope.setHideFilterFormState();

        PDFViewerApplication.l10n.translate(document.getElementById('annotationListContainer'));
    });

    $scope.getImage = function(annotationType) {
        var at = $window.PageManager.getAnnotationTypeById(annotationType);
        return at ? at.icon  : '';
    };

    $scope.showHide = function(annotation) {

        annotation.hidden = !annotation.hidden;
        $window.PageManager.showHideAnnotation(annotation);
    };

    $scope.view = function(annotation) {
        $window.Annotationeer.editAnnotation(annotation, 'view');
    };

    $scope.edit = function(annotation) {
        $window.Annotationeer.editAnnotation(annotation, 'edit', annotation.comments[0]);
    };

    $scope.reply = function(annotation) {
        $window.Annotationeer.editAnnotation(annotation, 'reply');
    };

    $scope.delete = function(annotation) {
        $timeout(function() {
            var exec = function(annotation) {
                $window.Annotationeer.deleteAnnotation(annotation, true);

                if (Default.SAVE_ALL_ANNOTATIONS_ONE_TIME)
                    for (var i=0; i<$scope.annotations.length; i++) {
                        if ($scope.annotations[i].id == annotation.id) {
                            $scope.annotations[i].modified = 'delete';
                            break;
                        }
                    }
            };

            if (Default.ALERT_DELETE) {
                if (Default.ALERT_BEAUTIFY) {
                    $window.PageManager.showConfirm(Message.ANNOTATION_DELETE_ASK, function() { exec(annotation); });
                    return;
                }
                else {
                    if (!$window.PageManager.showConfirm(Message.ANNOTATION_DELETE_ASK)) {
                        return;
                    }
                }
            }

            exec(annotation);
        }, 100);
    };

    $scope.useShowHideAnnotationFeature = function() {
        return Default.ANNOTATION_SHOW_HIDE_FEATURE;
    };

    /**
     * Place this in a timeout because it does not work if called directly from Vanilla JS.
     */
    $scope.filterAnnotations = function() {
        $timeout(function() {
            var isDateTrue = Util.isDate($('input#search-comments-input').val());
            var hasFilterOption = $scope.hasFilterOption();
PageManager.consoleLog($scope.annotations);
            for (var a=0; a<$scope.annotations.length; a++) {
                delete $scope.annotations[a]['filtered'];

                if (!hasFilterOption)
                    continue;

                if ($('input#search-comments-input').val().length > 0) {
                    if (isDateTrue) {
                        if (Util.formatDate($scope.annotations[a].dateCreated) == $('input#search-comments-input').val())
                            $scope.annotations[a].filtered = true;

                        if (Default.FILTER_INCLUDE_COMMENT_DATE_MODIFIED && !$scope.annotations[a].filtered)
                            for (var cc=0; cc<$scope.annotations[a].comments.length; cc++) {
                                if (Util.formatDate($scope.annotations[a].comments[cc].dateModified) == $('input#search-comments-input').val()) {
                                    $scope.annotations[a].filtered = true;
                                    break;
                                }
                            }
                    }
                    else {
                        // If the filter matches part of annotation's text property.
                        if ($scope.annotations[a].text.toLowerCase().indexOf($('input#search-comments-input').val().toLowerCase()) > -1) {
                            $scope.annotations[a].filtered = true;
                        }
                        // If the filter matches part of annotation comment's username property.
                        else if ($scope.annotations[a].comments[0].username.toLowerCase().indexOf($('input#search-comments-input').val().toLowerCase()) > -1) {
                            $scope.annotations[a].filtered = true;
                        }
                        else {
                            // Check if annotaton comments contain the text.
                            for (var c=0; c<$scope.annotations[a].comments.length; c++) {
                                if ($scope.annotations[a].comments[c].comment.trim().toLowerCase().indexOf($('input#search-comments-input').val().toLowerCase()) > -1)
                                    $scope.annotations[a].filtered = true;
                            }
                        }
                    }

                    continue;
                }

                var className = 'selected-filter';
                // These variables indicate if user selected these filter options.
                var usernameOption = false, annotationTypeOption = false, reviewStatusOption = false;
                // These variables are used as place holder to indicate a condition is true based on the property.
                var usernameYes = false, annotationTypeYes = false, reviewStatusYes = false;

                // Check if comment's author is selected.
                $('div#filter-option-comment-by > span[class="' + className + '"]').each(function() {
                    usernameOption = true;
                    var span = $(this);
                    for (var c=0; c<$scope.annotations[a].comments.length; c++) {
                        if ($scope.annotations[a].comments[c].username == span.html()) {
                            usernameYes = true;
                            return false;
                        }
                    }
                });

                // Check if annotation's annotation type is selected.
                $('div#filter-option-type > span[class="' + className + '"').each(function() {
                    annotationTypeOption = true;
                    if ($(this).prop('id') == $scope.annotations[a].annotationType) {
                        annotationTypeYes = true;
                        return false;
                    }
                });

                // Check if annotation comment's review status is selected.
                $('div#filter-option-comment-status > span[class="' + className + '"').each(function() {
                    reviewStatusOption = true;
                    var span = $(this);
                    for (var c=0; c<$scope.annotations[a].comments.length; c++) {
                        if ($scope.annotations[a].comments[c].reviewStatuses.length > 0) {
                            var rs = $scope.annotations[a].comments[c].reviewStatuses[$scope.annotations[a].comments[c].reviewStatuses.length - 1];
                            if (span.html().toLowerCase() == rs.status.toLowerCase()) {
                                reviewStatusYes = true;
                            }
                        }
                    }
                });

                // Username only.
                if (usernameOption && !annotationTypeOption && !reviewStatusOption) {
                    if (usernameYes)
                        $scope.annotations[a].filtered = true;
                }
                // Annotation type only.
                else if (!usernameOption && annotationTypeOption && !reviewStatusOption) {
                    if (annotationTypeYes)
                        $scope.annotations[a].filtered = true;
                }
                // Review status only.
                else if (!usernameOption && !annotationTypeOption && reviewStatusOption) {
                    if (reviewStatusYes)
                        $scope.annotations[a].filtered = true;
                }
                // Username and annotation type.
                else if (usernameOption && annotationTypeOption && !reviewStatusOption) {
                    if (usernameYes && annotationTypeYes)
                        $scope.annotations[a].filtered = true;
                }
                // Username and review status.
                else if (usernameOption && !annotationTypeOption && reviewStatusOption) {
                    if (usernameYes && reviewStatusYes)
                        $scope.annotations[a].filtered = true;
                }
                // Annotation type and review status.
                else if (!usernameOption && annotationTypeOption && reviewStatusOption) {
                    if (annotationTypeYes && reviewStatusYes)
                        $scope.annotations[a].filtered = true;
                }
                // Username, annotation type and review status.
                else if (usernameOption && annotationTypeOption && reviewStatusOption) {
                    if (usernameYes && annotationTypeYes && reviewStatusYes)
                        $scope.annotations[a].filtered = true;
                }
            }
        });
    };

    $scope.partOfFilteredResult = function(annotation) {
        var hasFilterOption = $scope.hasFilterOption();
        return annotation.modified != 'delete' &&
            ((!hasFilterOption && !annotation.filtered) ||
            (hasFilterOption && annotation.filtered));
    };

    /**
     * This function checks if any filter option is selected or populated.
     * @returns {boolean}
     */
    $scope.hasFilterOption = function() {
        var has = false;

        if ($('input#search-comments-input').val().length > 0)
            has = true;

        var className = 'selected-filter';

        if ($('div#filter-option-comment-by > span[class="' + className + '"').length > 0 ||
            $('div#filter-option-type > span[class="' + className + '"').length > 0 ||
            $('div#filter-option-comment-status > span[class="' + className + '"').length > 0)
            has = true;

        return has;
    }

    $scope.clearFilter = function() {
        $('input#search-comments-input').val('');

        // Remove selected-filter class in all comment by options.
        $('div#filter-option-comment-by > span').each(function() {
            $(this).removeClass('selected-filter');
        });

        // Remove selected-filter class in all stamp filter options.
        $('div#filter-option-type > span').each(function() {
            $(this).removeClass('selected-filter');
        });

        // Remove selected-filter class in all comment status options.
        $('div#filter-option-comment-status > span').each(function() {
            $(this).removeClass('selected-filter');
        });

        // Select first sort option.
        $scope.sortOption = 'pageIndex';

        $scope.filterAnnotations();
    };

    $scope.showComments = function(annotation) {
        if (Default.ANNOTATION_LIST_COMMENTS_EXPAND == Default.ANNOTATION_LIST_COMMENTS_EXPAND_ALWAYS) {
            // If option is to always show comments, then ignore the rest of the code.
            return;
        }
        else {
            var img = $('#img_' + annotation.id);
            if (img.length == 0 || img.attr('src').indexOf('collapse') > -1)
                return;
        }

        var tr = $('#comment-list').parent().parent();
        if (tr && tr.attr('id') == annotation.id) {
            $scope.annotationShowComments = null;
            return;
        }

        $scope.annotationShowComments = annotation;
    };

    $scope.isShowComments = function() {
        return Default.ANNOTATION_LIST_COMMENTS_SHOW;
    };

    $scope.alwaysExpandComments = function() {
        return Default.ANNOTATION_LIST_COMMENTS_EXPAND == Default.ANNOTATION_LIST_COMMENTS_EXPAND_ALWAYS;
    };

    $scope.showReviewStatus = function(comment) {
        if (!comment || comment.reviewStatuses.length == 0)
            return '';

        var rs = comment.reviewStatuses[comment.reviewStatuses.length - 1];
        //noinspection HtmlUnknownTarget
        return '<img src="' + Url.reviewStatusFolderUrl + 'status_' + rs.status.toLowerCase() + '.svg" height="13" title="' + rs.status + ' by ' + rs.reviewedBy + '"/>';
    };

    $scope.getReviewStatusFolderUrl = function() {
        return Url.reviewStatusFolderUrl;
    };

    $scope.getLatestReviewStatus = function(comment) {
        return comment.reviewStatuses[comment.reviewStatuses.length - 1];
    };

    $scope.isCommentFeatureStatusDisplay = function() {
        return Default.COMMENT_FEATURE_STATUS_DISPLAY;
    };

    /**
     * The original code copied the same code in annotationeer.js. Instead, it calls the function to
     * avoid code redundancy.
     * @param evt The event object.
     * @param annotation The annotation object.
     * @param comment The comment object.
     * @param selector If not null, then use this selector.
     * @param trigger
     * @param reviewStatusMenuItemsOnly If true, only menu items related to review status will be shown. And this means
     * that Default.ANNOTATION_LIST_COMMENTS_SHOW is false.
     */
    $scope.handleContextMenu = function(evt, annotation, comment, trigger, selector, reviewStatusMenuItemsOnly) {
        if (reviewStatusMenuItemsOnly && evt.which != 3)
            return;
        Annotationeer.displayAnnotationMenu(annotation, 0, 0, selector , trigger, comment, reviewStatusMenuItemsOnly);
    };

    $scope.clickedRow = function(evt, annotation) {
        $window.PageManager.addSelectedAnnotation(annotation, true);
        $window.PageManager.scrollToAnnotationInCanvas(annotation);
    };

    /**
     * This function exists for code readability rather than placing all if conditions within
     * the directive template. This function will return true if all comments of the annotation
     * do not have an id of 0.
     *
     * Since changes to the comment list can originate from the canvas area, the last comment in
     * the list may be a dummy. Hence, we check if the id of the previous comment in the list
     * is not 0,
     */
    $scope.isLastComment = function(comment, annotation) {
        //var comment = annotation.comments[index];
        var isLast = false;//index == annotation.comments.length - 1;
        var index = -1;

        for (var c=annotation.comments.length-1; c>=0; c--) {
            if (annotation.comments[c].modified != 'delete') {
                if (annotation.comments[c].id == comment.id) {
                    isLast = true;
                    index = c;
                }

                break;
            }
        }

        if (isLast)
            return comment.id != 0;
        else
            return comment.id != 0 && index == annotation.comments.length - 2 &&
                annotation.comments[annotation.comments.length - 1].id == 0;
    };

    $scope.expandCommentsOfAnnotations = function() {
        for (var i=0; i<$scope.annotations.length; i++) {
            $scope.showComments($scope.annotations[i]);
        }
    };

    $scope.isBySameUser = function(comment) {
        return Annotationeer.commentIsBySameUser(comment);
    };

    /**
     * Shows or hides the form within the search comments user interface.
     */
    $scope.showHideSearchCommentsForm = function() {
        $scope.hideFilterForm();

        var speed = 200;
        var div = $('div#search-comments-container > div');

        // The parent container of the filter option should have a display of type flex.
        if (!div.is(':visible'))
            div.slideDown({
                start: function () {
                    $(this).css({
                        display: 'flex',
                        speed: speed
                    })
                },
                done: function() {
                    $scope.setHideFilterFormState();
                }
            });
        else
            div.slideUp(speed, function() {
                $scope.setHideFilterFormState();
            });

        div.find('input').focus();
    };

    /**
     * Shows or hides the forms within the filter options user interface.
     */
    $scope.showHideFilterOptionsForm = function() {
        $scope.hideFilterForm();

        var speed = 200;
        var div = $('div#filter-options-container > div');

        if (!div.is(':visible'))
            div.slideDown(speed, function() {
                $scope.setHideFilterFormState();
            });
        else
            div.slideUp(speed, function() {
                $scope.setHideFilterFormState();
            });
    };

    /**
     * Shows or hides the forms within the filter options user interface.
     */
    $scope.showHideSortOptions = function() {
        $scope.hideFilterForm();

        var speed = 200;
        var div = $('div#sort-container > div');

        if (!div.is(':visible'))
            div.slideDown({
                start: function() {
                    $(this).css({
                        display: 'flex',
                        speed: speed
                    })
                },
                done: function() {
                    $scope.setHideFilterFormState();
                }
            });
        else
            div.slideUp(speed, function() {
                $scope.setHideFilterFormState();
            });
    };

    /**
     * Shows or hides the whole user interface including the search comments form.
     * @param callback The callback function to execute if it is not null.
     */
    $scope.hideFilterForm = function(callback) {
        var speed = 200;
        var container = null;

        if ($('input#search-comments-input').is(':visible'))
            container = $('input#search-comments-input');
        else if ($('div#filter-option-type').is(':visible'))
            container = $('div#filter-option-type');
        else if ($('select#sort-select').is(':visible'))
            container = $('select#sort-select');

        if (container)
            container.parent().slideUp(speed, function() {
                if (Util.isFunction(callback))
                    callback();

                $scope.setHideFilterFormState();
            });
    };

    /**
     * If search comment filter form and filter options form are hidden, then this buttion
     * should also be hidden.
     */
    $scope.setHideFilterFormState = function() {
        var button = $('button#hide-filter-form-button');
        if ($('div#search-comments-container > div').is(':visible') ||
            $('div#filter-options-container > div').is(':visible') ||
            $('div#sort-container > div').is(':visible'))
            button.removeClass('hidden');
        else
            button.addClass('hidden');
    }

  });

app.filter('newline', function($sce) {
    return function(text) {
        return text ? $sce.trustAsHtml(text.replace(/\n/g, '<br />')) : '';
    };
});

/*
 * We set the form as another module/Angular application because placing the 2 divs (popup, annotation list)
 * in index.html inside 1 div that will house the ng-app label, the popup window will not show. We use a
 * 3rd part library to make this work. ng-app will only accept 1 module unless you bootstrap it manually.
 */
var form = angular.module('annotationForm', ['ngSanitize', 'Util']);

form.controller('AnnotationFormController', function($document, $http, $sce, $scope, $timeout, UtilService) {
    $scope.annotation = null;
    $scope.key = null;
    $scope.currentUsername = Annotationeer.getUsername();
    $scope.formComment = new Comment();
    $scope.UtilService = UtilService;
    $scope.formComment.mark =null;
    $scope.formComment.location =null;
    $document.on('opened', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'popupContainer')
            return;

        window.PageManager.translateEachL10n($('div#popupContentContainer'));

        var popupContainer = $('#popupContainer');
        popupContainer.removeClass('hidden');
        popupContainer.find('button.remodal-close').removeClass('disabled');
        popupContainer.find('button.remodal-close').removeAttr('disabled');
        $('#comment').focus();
    });

    $document.on('closed', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'popupContainer')
            return;

        if ($scope.key == 'reply')
            $scope.closePopup(e.reason == 'cancellation');

        $scope.formComment = new Comment();
    });

    /**
     * Sets the annotation reference for processing.
     * @param annotation The annoation object.
     * @param key Indicates what action to take, e.g. edit, reply.
     * @param comment If not null, the form will point to this specific comment, not the root.
     */
    $scope.setAnnotation = function(annotation, key, comment) {
        $scope.formComment = { };
        $scope.annotation = annotation;
        $scope.key = key;
PageManager.consoleLog(annotation);
        if($scope.annotation.inspection_type==3){
          $scope.formComment.mark  = annotation.mark;
          $scope.formComment.location  = annotation.mark_location;
          PageManager.consoleLog(annotation.mark_location);
        }

        if (key == 'reply') {
            var comment = new Comment();
            comment.annotationId = annotation.id;
            comment.parentId = -$scope.annotation.comments[0].id;
            $scope.annotation.comments.push(comment);
            $scope.formComment = jQuery.extend({}, comment);
        }
        else if (key == 'create') {
            if (comment) {
                for (var c=0; c<$scope.annotation.comments.length; c++) {
                    if ($scope.annotation.comments[c].id == comment.id) {
                        $scope.annotation.comments[c].annotationId = annotation.id;
                        $scope.formComment = jQuery.extend({}, $scope.annotation.comments[c]);
                        break;
                    }
                }
            }
            else {
                $scope.annotation.comments[0].annotationId = annotation.id;
                $scope.formComment = jQuery.extend({}, $scope.annotation.comments[0]);
            }

            // Check if last object of the comments array has empty text comment, then it means
            // this was supposed to be a reply form but user decided to edit existing comment.
            // If so, we hide it while user modifies existing comment then show it back once
            // it is saved.
            if ($scope.annotation.comments.length > 1 &&
                $scope.annotation.comments[$scope.annotation.comments.length - 1].comment == '')
            {
                $scope.annotation.comments.splice($scope.annotation.comments.length - 1, 1);
            }
        }
        else {
            if (comment) {
                for (var c=0; c<$scope.annotation.comments.length; c++) {
                    if ($scope.annotation.comments[c].id == comment.id) {
                        $scope.annotation.comments[c].annotationId = annotation.id;
                        $scope.formComment = jQuery.extend({}, $scope.annotation.comments[c]);
                        break;
                    }
                }
            }
            else {
                $scope.annotation.comments[0].annotationId = annotation.id;
                $scope.formComment = jQuery.extend({}, $scope.annotation.comments[0]);
            }

            // Check if last object of the comments array has empty text comment, then it means
            // this was supposed to be a reply form but user decided to edit existing comment.
            // If so, we hide it while user modifies existing comment then show it back once
            // it is saved.
            if ($scope.annotation.comments.length > 1 &&
                $scope.annotation.comments[$scope.annotation.comments.length - 1].comment == '')
            {
                $scope.annotation.comments.splice($scope.annotation.comments.length - 1, 1);
            }

            if($scope.annotation.inspection_type==3){
              $scope.formComment.mark  = $scope.annotation.mark;
              $scope.formComment.location  = $scope.annotation.mark_location;
            }
        }

        $timeout(function() {
            // If comment id is not null, it means the dialog is already open and the user wants to
            // edit an existing comment.
            var popupContainer = $('#popupContainer');
            if (!popupContainer.hasClass('remodal-is-opened'))
                popupContainer.remodal().open();
            // Else it means the EDIT action link from within the dialog was clicked.
            else
                $('textarea#comment').focus();
        });
    };

    $scope.isBySameUser = function(comment) {
        return Annotationeer.commentIsBySameUser(comment);
    };

    $scope.deleteComment = function(annotation, comment) {
        Annotationeer.deleteComment(annotation, comment);
    };

    // Show context menu for review status
    $scope.handleContextMenu = function(evt, annotation, comment, selector, index) {
        if (annotation.comments.length - 1 <= index)
            return;

        Annotationeer.displayAnnotationMenu(annotation, 0, 0, selector , 'right', comment, true);
    };

    $scope.saveComment = function() {

        if ($scope.formComment.comment == '' && $scope.formComment.status >1) {
            $timeout(function() {
                PageManager.showAlert(Message.COMMENT_REQUIREMENT, 'info');
                $('#comment').focus();
            });
            return;
        }
        else if (typeof $scope.formComment.status === 'undefined' || $scope.formComment.status === null) {
            $timeout(function() {
                PageManager.showAlert(Message.SELECT_STATUS, 'info');
                $('#comment').focus();
            });
            return;
        }

        var comment;
        if ($scope.key == 'reply') {
            comment = $scope.annotation.comments[$scope.annotation.comments.length - 1];
            comment.parentId = $scope.annotation.comments[0].id;
        }
        else {
            for (var c=0; c<$scope.annotation.comments.length; c++) {
                if ($scope.annotation.comments[c].id == $scope.formComment.id) {
                    comment = $scope.annotation.comments[c];
                    break;
                }
            }

            comment.dateModified = new Date();
        }

        /**
          Start Color Changed For Edit comment Section Modified by Nam devlopers
        **/
         PageManager.consoleLog($scope.formComment.status);
              if($scope.formComment.status==1){ $scope.annotation.color ='#00ff4a'; $scope.annotation.backgroundColor ='#00ff4a'; }
              else if($scope.formComment.status==2){ $scope.annotation.color ='#bf0505'; $scope.annotation.backgroundColor ='#bf0505'; }
              else if($scope.formComment.status==4){ $scope.annotation.color ='#bf0505';  $scope.annotation.backgroundColor ='#bf0505';}
              else { $scope.annotation.color ='#0433ff'; $scope.annotation.backgroundColor ='#0433ff';}

              if ($scope.annotation.annotationType == Annotation.TYPE_TEXT)
              PageManager.setFreeTextImageToAnnotation($scope.annotation, 'clone_' + $scope.annotation.id);
              var page = pages[Default.canvasIdName + ($scope.annotation.pageIndex + 1)];
              page.invalidate();
              UtilService.setModifiedToUpdate($scope.annotation);
            //  PageManager.consoleLog($scope.annotation.color);
        /**
          End Line Color Changed For Edit comment Section Modified by Nam devlopers
        **/
        comment.comment = $scope.formComment.comment;
        comment.status = $scope.formComment.status;
        if (Default.SAVE_ALL_ANNOTATIONS_ONE_TIME) {
            if (comment.id == 0)
                comment.id = -$scope.annotation.comments.length - 1;

            if ($scope.key == 'edit')
                comment.modified = 'update';

            if ($scope.annotation.modified == '') {
                $scope.annotation.oldModified = 'update';
            }

            window.PageManager.updateAnnotationComment($scope.annotation);
            $('#popupContainer').remodal().close();
        }
        else {
            Annotationeer.saveComment($scope.annotation, comment);
        }
    };

    $scope.savePieceinfo = function() {
      PageManager.consoleLog($scope.formComment);
      if ($scope.formComment.mark == '') {
          $timeout(function() {
              PageManager.showAlert(Message.MARK_REQUIREMENT, 'info');
              $('#mark').focus();
          });
          return;
      }
      else if ($scope.formComment.location == '') {
          $timeout(function() {
              PageManager.showAlert(Message.LOCATION_REQUIREMENT, 'info');
              $('#location').focus();
          });
          return;
      }else{
        var comment;
        comment = $scope.annotation.comments[$scope.annotation.comments.length - 1];
        comment.parentId = $scope.annotation.comments[0].id;
        comment.annotationId = $scope.annotation.comments[0].annotationId;
        comment.mark = $scope.formComment.mark;
        comment.location = $scope.formComment.location;
        comment.modified = 'insert';
      //  PageManager.consoleLog(comment);
        Annotationeer.savePieceinfo($scope.annotation, comment);
      }
    };

    $scope.saveWelderinfo = function() {
      PageManager.consoleLog($scope.formComment);
      if($scope.formComment.status==1){ $scope.annotation.color ='#00ff4a'; $scope.annotation.backgroundColor ='#00ff4a'; }
      else if($scope.formComment.status==2){ $scope.annotation.color ='#bf0505'; $scope.annotation.backgroundColor ='#bf0505'; }
      else if($scope.formComment.status==4){ $scope.annotation.color ='#bf0505';  $scope.annotation.backgroundColor ='#bf0505';}
      else { $scope.annotation.color ='#0433ff'; $scope.annotation.backgroundColor ='#0433ff';}

      if ($scope.formComment.weldervar == '') {
          $timeout(function() {
              PageManager.showAlert(Message.WELDER_REQUIREMENT, 'info');
              $('#weldervar').focus();
          });
          return;
      }
      else if (typeof $scope.formComment.status === 'undefined' || $scope.formComment.status === null) {
          $timeout(function() {
              PageManager.showAlert(Message.SELECT_STATUS, 'info');
              $('#status').focus();
          });
          return;
      }
      else if ($scope.formComment.comment == '') {
          $timeout(function() {
              PageManager.showAlert(Message.COMMENT_REQUIREMENT, 'info');
              $('#comment').focus();
          });
          return;
      }else{
        var comment;
        comment = $scope.annotation.comments[$scope.annotation.comments.length - 1];
        comment.parentId = $scope.annotation.comments[0].id;
        comment.annotationId = $scope.annotation.comments[0].annotationId;
        comment.weldervar = $scope.formComment.weldervar;
        comment.comment = $scope.formComment.comment;
        comment.color = $scope.annotation.color;
        comment.backgroundColor = $scope.annotation.backgroundColor;
        comment.status = $scope.formComment.status;
        comment.non_destructive = $scope.formComment.non_destructive;
        comment.non_ultrasonic = $scope.formComment.non_ultrasonic;
        comment.modified = 'update';
      // PageManager.consoleLog(comment);
        Annotationeer.saveWelderinfo($scope.annotation, comment);
      }
    };

    $scope.updatePieceinfo = function() {

      if ($scope.formComment.mark == '') {
          $timeout(function() {
              PageManager.showAlert(Message.MARK_REQUIREMENT, 'info');
              $('#mark').focus();
          });
          return;
      }
      else if ($scope.formComment.location == '') {
          $timeout(function() {
              PageManager.showAlert(Message.LOCATION_REQUIREMENT, 'info');
              $('#location').focus();
          });
          return;
      }else{
        var comment;
        comment = $scope.annotation.comments[$scope.annotation.comments.length - 1];
        comment.parentId = $scope.annotation.comments[0].id;
        comment.annotationId = $scope.annotation.comments[0].annotationId;
        comment.mark = $scope.formComment.mark;
        comment.location = $scope.formComment.location;
        comment.modified = 'update';
      // PageManager.consoleLog(comment);
        Annotationeer.updateMarkinfo($scope.annotation, comment);
      }
    };

    $scope.closePopup = function(canceled) {
        if (!$scope.annotation || !$scope.annotation.comments || $scope.annotation.comments.length == 1)
            return;

        if ($scope.key == 'reply' && (canceled || $scope.formComment.comment == ''))
            $scope.annotation.comments.splice($scope.annotation.comments.length - 1, 1);
    };

    $scope.getRootComment = function(annotation, comment, index) {
      // if (index == 0) {
            var str = '';
            if (annotation.annotationType == Annotation.TYPE_MEASUREMENT_AREA)
                str = Util.getAreaFromPixels(annotation, annotation.getArea());
            else if (annotation.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE)
                str = annotation.text;
            else if (annotation.annotationType == Annotation.TYPE_TEXT)
                str = annotation.text;
            else
                str = comment.comment;

            return str && str.length > 0 ? $sce.trustAsHtml(str.replace(/\n/g, '<br />')) : Message.ANNO_CREATED;
      //  }

      //  return (comment.comment != '' ? $sce.trustAsHtml(comment.comment.replace(/\n/g, '<br />')) : Message.ANNO_CREATED);
    };

    $scope.getReviewStatusFolderUrl = function() {
        return Url.reviewStatusFolderUrl;
    };

    $scope.getLatestReviewStatus = function(comment) {
        return comment.reviewStatuses[comment.reviewStatuses.length - 1];
    };

    $scope.isCommentFeatureStatusDisplay = function() {
        return Default.COMMENT_FEATURE_STATUS_DISPLAY;
    };

    $scope.getMomentFormattedDate = function(date, pattern) {
        return Util.getMomentFormattedDate(date, pattern);
    }
});

form.filter('newline', function($sce) {
    return function(text) {
        return text.length > 0 ? $sce.trustAsHtml(text.replace(/\n/g, '<br />')) : '';
    };
});

var cal = angular.module('calibrateForm', ['Util']);

cal.controller('CalibrateFormController', function($document, $scope, $timeout, UtilService) {

    $scope.annotation = null;
    // Has to be some object because does not seem to get the value of input field if directly a variable.
    $scope.calibration = {};
    $scope.measurementTypes = UtilService.getMeasurementTypes();

    $document.on('opened', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'calibrateContainer')
            return;

    });

    $document.on('closed', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'calibrateContainer')
            return;

    });

    $scope.showCalibrateForm = function(annotation) {
        $scope.annotation = annotation;
        $scope.annotation.calibrationMeasurementTypeChosen = UtilService.getMeasurementType(annotation.calibrationMeasurementType);

        //if (annotation.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE) {
        //    var origDistance = Util.getDistance($scope.annotation.drawingPositions[0].origX, $scope.annotation.drawingPositions[0].origY,
        //        $scope.annotation.drawingPositions[1].origX, $scope.annotation.drawingPositions[1].origY);
        //    $scope.calibration.value = $scope.annotation.calibrationValue * origDistance;
        //}
        //else if (annotation.annotationType == Annotation.TYPE_MEASUREMENT_AREA) {
        //    var area = $scope.annotation.getArea();
        //    $scope.calibration.value = $scope.annotation.calibrationValue * area;
        //}
        $scope.calibration.label = $scope.annotation.calibrationLabel;

        $timeout(function() {
            var calibrateContainer = $('div#calibrateContainer');
            calibrateContainer.removeClass('hidden');
            calibrateContainer.find('button.remodal-close').removeClass('disabled');
            calibrateContainer.find('button.remodal-close').removeAttr('disabled');
            calibrateContainer.remodal({
                closeOnOutsideClick: false
            }).open();
        });
    };

    $scope.measurementTypeChanged = function(oldValue) {
        if (!$scope.calibration.label || $scope.calibration.label.length == 0)
            return;

        // If formatted, call the directive programmatically to ensure only floating numbers are allowed.
        if (oldValue && JSON.parse(oldValue).id == MeasurementType.FOOT_INCH) {
            // parseFloat() will remove extra decimals if any, then revert it back to string.
            $scope.calibration.label = parseFloat($scope.calibration.label.replace(/[^0-9.]/g, '')) + '';
            var input = document.getElementById('calibrateInputText');
            input.value = $scope.calibration.label;
            var ngModel = angular.element(input).controller('ngModel');
            ngModel.$setViewValue($scope.calibration.label);
        }

        PageManager.calibrationLabel = $scope.calibration.label;
        PageManager.calibrationMeasurementType = $scope.annotation.calibrationMeasurementTypeChosen.id;
        $scope.annotation.calibrationMeasurementType = PageManager.calibrationMeasurementType;
        $scope.annotation.calibrationLabel = PageManager.calibrationLabel;

        var calculateCalibrationValue = 0;

        if ($scope.annotation.calibrationMeasurementType == MeasurementType.FOOT_INCH) {
            // Convert to inches first, then assign calibration value.
            var inches = Util.heightToInches($scope.calibration.label);
            calculateCalibrationValue = parseFloat(inches);
        }
        else {
            calculateCalibrationValue = parseFloat($scope.calibration.label);
        }

        if ($scope.annotation.annotationType == Annotation.TYPE_MEASUREMENT_DISTANCE) {
            var origDistance = Util.getDistance($scope.annotation.drawingPositions[0].origX, $scope.annotation.drawingPositions[0].origY,
            $scope.annotation.drawingPositions[1].origX, $scope.annotation.drawingPositions[1].origY);
            $scope.annotation.calibrationValue =  calculateCalibrationValue / origDistance;
        }
        else if ($scope.annotation.annotationType == Annotation.TYPE_MEASUREMENT_AREA) {
            var area = $scope.annotation.getArea();
            $scope.annotation.calibrationValue =  calculateCalibrationValue / area;
        }

        PageManager.calibrationValue = $scope.annotation.calibrationValue;        

        var page = pages[Default.canvasIdName + ($scope.annotation.pageIndex + 1)];
        page.invalidate();

        UtilService.setModifiedToUpdate($scope.annotation);
    };

});

cal.directive("floatingNumberOnly", function() {
    return {
        require: 'ngModel',
        link: function(scope, ele, attr, ctrl) {

            ctrl.$parsers.push(function(inputValue) {
                if (inputValue == '')
                    return '';

                if (scope.annotation.calibrationMeasurementTypeChosen.id == MeasurementType.FOOT_INCH) {
                    scope.calibration.label = inputValue;
                    ctrl.$setViewValue(inputValue);
                    ctrl.$render();
                    return inputValue;
                }

                var pattern = new RegExp("(^[0-9]{1,9})+(\.[0-9]{1,4})?$", "g");
                var dotPattern = /^[.]*$/;

                if (dotPattern.test(inputValue)) {
                    ctrl.$setViewValue('');
                    ctrl.$render();
                    return '';
                }

                var newInput = inputValue.replace(/[^0-9.]/g, '');

                if (newInput != inputValue) {
                    ctrl.$setViewValue(newInput);
                    ctrl.$render();
                }

                // If a same function call made twice, erroneous result is to be expected.

                var result;
                var dotCount;
                var newInputLength = newInput.length;
                if (result = (pattern.test(newInput))) {
                    // Count of dots present.
                    dotCount = newInput.split(".").length - 1;
                    // Condition to restrict "integer part" to 9 digit count.
                    if (dotCount == 0 && newInputLength > 9) {
                        newInput = newInput.slice(0, newInputLength - 1);
                        ctrl.$setViewValue(newInput);
                        ctrl.$render();
                    }
                }
                // Pattern failed.
                else {
                    // Count of dots present.
                    dotCount = newInput.split(".").length - 1;
                    // Condition to accept min of 1 dot.
                    if (newInputLength > 0 && dotCount > 1) {
                        newInput = newInput.slice(0, newInputLength - 1);
                    }

                    // Condition to restrict "fraction part" to 4 digit count only.
                    if ((newInput.slice(newInput.indexOf(".") + 1).length) > 4) {
                        newInput = newInput.slice(0, newInputLength - 1);
                    }

                    ctrl.$setViewValue(newInput);
                    ctrl.$render();
                }

                return newInput;
            });
        }
    };
});

angular.module('playerForm', []).controller('PlayerFormController', function($document, $http, $scope) {

    $scope.annotation = null;

    $document.on('opened', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'playerContainer')
            return;

        var audioPlayer = $('#audioPlayer');
        if ($scope.annotation.audio) {
            audioPlayer[0].src = URL.createObjectURL($scope.annotation.audio);
            audioPlayer[0].play();
        }
        else if ($scope.annotation.audioAvailable) {
            $http({
                method: 'GET',
                url: Url.restUrl + 'audio/' + $scope.annotation.id,
                responseType: 'arraybuffer'
            }).then(function successCallback(response) {
                var source = new Blob([response.data], {type: 'audio/mp3'});
                $scope.annotation.audio = source;

                audioPlayer[0].src = URL.createObjectURL(source);
                audioPlayer[0].play();

                window.disablePlayerUI(false);
                window.disableRecordUI(true);
            }, function errorCallback() {
                $('#playerContainer').find('.status').html('Status: Error getting audio.');
                window.disablePlayerUI(true);
                window.disableRecordUI(true);
            });
        }
        else {
            $('#playerContainer').find('.status').html('Status: Recording ...');
            window.record();
        }
    });

    $document.on('closed', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'playerContainer')
            return;

        PageManager.updateAnnotationListAfterSave($scope.annotation);
    });

    $scope.showPlayer = function(annotation) {
        if (Default.ANNOTATIONS_AUDIO && !annotation.audio) {
            window.initAudioPlayer();
        }

        var playerContainer = $('#playerContainer');
        playerContainer.find('.status').html('Status:');

        window.disablePlayerUI(!annotation.audio || !annotation.audioAvailable);
        window.disableRecordUI(annotation.audio || annotation.audioAvailable);

        playerContainer.removeClass('hidden');
        /**
         * Add these two lines because there is a tendency when creating an audio annotation and
         * after closing the player popup window and opening it again, the close button is disabled.
         * No idea why it behaves this way. If it is an existing audio annotation, behavior is ok.
         */
        playerContainer.find('button.remodal-close').removeClass('disabled');
        playerContainer.find('button.remodal-close').removeAttr('disabled');
        playerContainer.remodal().open();
        playerContainer.addClass('player-background');

        $scope.annotation = annotation;
    };
});

angular.module('propertiesForm', ['Util']).controller('PropertiesFormController', function($document, $scope, $timeout, UtilService) {

    $scope.annotation = null;
    $scope.property = {};
    $scope.measurementTypes = UtilService.getMeasurementTypes();
    $scope.lineStyles = UtilService.getLineStyles();

    $document.on('opening', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'propertiesContainer')
            return;

        loadTranslations();

        if ($scope.annotation.hasLineWidth())
            $timeout(function() {
                $('#lineWidth').val($scope.annotation.lineWidth);
            });

        if ($scope.annotation.hasOpacity())
            $timeout(function() {
                $('#opacity').val($scope.annotation.opacity);
            });
    });

    $document.on('opened', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'propertiesContainer')
            return;

        $('#propertiesContainer').removeClass('hidden');

        $('#backgroundPaletteProperty').on('input', function() {
            var me = $(this);
            $timeout(function() {
                $scope.annotation.backgroundColor = me.val();

                if ($scope.annotation.annotationType == Annotation.TYPE_TEXT)
                    PageManager.setFreeTextImageToAnnotation($scope.annotation, 'clone_' + $scope.annotation.id);

                var page = pages[Default.canvasIdName + ($scope.annotation.pageIndex + 1)];
                page.invalidate();

                $scope.setModifiedToUpdate();
            });
        });

        $('#colorPaletteProperty').on('input', function() {
            var me = $(this);
            $timeout(function() {
                $scope.annotation.color = me.val();

                if ($scope.annotation.annotationType == Annotation.TYPE_TEXT)
                    PageManager.setFreeTextImageToAnnotation($scope.annotation, 'clone_' + $scope.annotation.id);

                var page = pages[Default.canvasIdName + ($scope.annotation.pageIndex + 1)];
                page.invalidate();

                $scope.setModifiedToUpdate();
            });
        });

        if (Default.TYPE_TEXT_1_LINER)
            $('textarea#textAreaText').remove();
        else {
            $('input#inputText').remove();
            $('span.subLabel').remove();
        }

        if ($scope.annotation.hasLineWidth())
            $('#lineWidth').on('change', function() {
                $timeout(function() {
                    $scope.annotation.lineWidth = $('#lineWidth').val();
                    $scope.setModifiedToUpdate();

                    var page = pages[Default.canvasIdName + ($scope.annotation.pageIndex + 1)];
                    page.invalidate();
                });
            });

        if ($scope.annotation.hasOpacity())
            $('#opacity').on('change', function() {
                $timeout(function() {
                    $scope.annotation.opacity = $('#opacity').val();
                    $scope.setModifiedToUpdate();

                    var page = pages[Default.canvasIdName + ($scope.annotation.pageIndex + 1)];
                    page.invalidate();
                });
            });
    });

    $document.on('closed', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'propertiesContainer')
            return;

        $('#backgroundPaletteProperty').off('input');
        $('#colorPaletteProperty').off('input');

        if ($scope.annotation.hasLineWidth())
            $('#lineWidth').off('change');

        if ($scope.annotation.hasOpacity())
            $('#opacity').off('change');
    });

    var refreshAnnotationInPage = function(annotation) {
        if (annotation.modified == '')
            annotation.modified = 'update';

        var divs = window.PageManager.getPageContainer(annotation.pageIndex + 1).find('.canvasWrapper').children('div');
        for (var d=0; d<divs.length; d++) {
            $(divs[d]).remove();
        }

        var inputs = window.PageManager.getPageContainer(annotation.pageIndex + 1).find('.canvasWrapper').children('input');
        for (var i=0; i<inputs.length; i++) {
            $(inputs[i]).remove();
        }

        window.Annotationeer.loadAnnotations(annotation.pageIndex, true, annotation.annotationType == Annotation.TYPE_TEXT);
    };

    $document.on('closed', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'propertiesContainer')
            return;

        var backgroundPaletteProperty = $('#backgroundPaletteProperty');
        var colorPaletteProperty = $('#colorPaletteProperty');

        colorPaletteProperty.off('input');
        backgroundPaletteProperty.off('input');

        if (window.Util.isIE() || !window.Util.supportsHTML5ColorInput()) {
            backgroundPaletteProperty.minicolors('destroy');
            colorPaletteProperty.minicolors('destroy');
        }
    });

    $scope.lineStyleChanged = function() {
        if ($scope.annotation.lineStyle != $scope.annotation.lineStyleChosen.id) {
            $scope.annotation.lineStyle = $scope.annotation.lineStyleChosen.id;

            var page = pages[Default.canvasIdName + ($scope.annotation.pageIndex + 1)];
            page.invalidate();

            $scope.setModifiedToUpdate();
        }
    };

    $scope.measurementTypeChanged = function() {
        if ($scope.annotation.measurementType != $scope.annotation.measurementTypeChosen.id) {
            $scope.annotation.measurementType = $scope.annotation.measurementTypeChosen.id;

            var page = pages[Default.canvasIdName + ($scope.annotation.pageIndex + 1)];
            page.invalidate();

            $scope.setModifiedToUpdate();
        }
    };

    $scope.showPropertiesWindow = function(annotation) {
        $scope.annotation = annotation;
        $scope.annotation.measurementTypeChosen = UtilService.getMeasurementType($scope.annotation.measurementType);
        $scope.annotation.lineStyleChosen = UtilService.getLineStyle($scope.annotation.lineStyle);

        $timeout(function() {
            // Configure Annotation.TYPE_TEXT properties
            if ($scope.annotation.annotationType == Annotation.TYPE_TEXT) {
                $scope.property.fontSizeMin = Default.ANNOTATION_TYPE_TEXT_FONT_SIZE_RANGE_MIN;
                $scope.property.fontSizeMax = Default.ANNOTATION_TYPE_TEXT_FONT_SIZE_RANGE_MAX;
                $scope.property.fontSize = $scope.annotation.fontSize;
                // http://stackoverflow.com/questions/8062399/how-replace-html-br-with-newline-character-n
                // Replace br tags with \n.
                $scope.property.text = $scope.annotation.text.replace(/<br\s*\/?>/mg, '\n').replace(/&nbsp;/g, ' ');
            }

            if ($scope.annotation.isFormField()) {
                $scope.property.formFieldName = $scope.annotation.formFieldName;
                $scope.property.formFieldValue = $scope.annotation.formFieldValue;
            }

            var propertiesContainer = $('#propertiesContainer');
            propertiesContainer.find('button.remodal-close').removeClass('disabled');
            propertiesContainer.find('button.remodal-close').removeAttr('disabled');
            propertiesContainer.remodal().open();
            propertiesContainer.addClass('properties-background');

            var backgroundPaletteProperty = $('#backgroundPaletteProperty');
            backgroundPaletteProperty.val($scope.annotation.backgroundColor);
            var colorPaletteProperty = $('#colorPaletteProperty');
            colorPaletteProperty.val($scope.annotation.color);

            if (window.Util.isIE() || !window.Util.supportsHTML5ColorInput()) {
                backgroundPaletteProperty.minicolors();
                colorPaletteProperty.minicolors();
            }
        });
    };

    $scope.showColorPicker = function(what) {
        if (what == 'background') {
            var backgroundPaletteProperty = $('#backgroundPaletteProperty');
            backgroundPaletteProperty.trigger('focus');
            backgroundPaletteProperty.trigger('click');
        }
        else {
            var colorPaletteProperty = $('#colorPaletteProperty');
            colorPaletteProperty.trigger('focus');
            colorPaletteProperty.trigger('click');
        }
    };

    // http://stackoverflow.com/questions/11873570/angularjs-for-loop-with-numbers-ranges
    $scope.range = function(min, max, step) {
        step = step || 1;
        var input = [];
        for (var i = min; i <= max; i += step) {
            input.push(i);
        }
        return input;
    };

    $scope.getTypeTextAnnotationTypeId = function() {
        return Annotation.TYPE_TEXT;
    };

    $scope.getTypeTextCharLimit = function() {
        return Default.ANNOTATION_TYPE_TEXT_CHAR_LIMIT;
    };

    $scope.updateFontSize = function() {
        $timeout(function() {
            $scope.annotation.fontSize = $scope.property.fontSize;
            $scope.annotation.hasDimension = false;

            refreshAnnotationInPage($scope.annotation);
        });
    };

    $scope.updateText = function() {
        if ($scope.property.text.length == 0)
            return;

        $timeout(function() {
            // Convert \n characters to br tag if Default.TYPE_TEXT_1_LINER is false since free text
            // multi-line is from a div contenteditable.
            $scope.annotation.text = Default.TYPE_TEXT_1_LINER ? $scope.property.text.replace(/\s/g, '&nbsp;') :
                $scope.property.text.replace(/\n/g, '<br>').replace(/\s/g, '&nbsp;');
            $scope.annotation.hasDimension = false;
            $scope.setModifiedToUpdate();
            refreshAnnotationInPage($scope.annotation);
        });
    };

    $scope.updateFormFieldName = function() {
        if ($scope.property.formFieldName.length == 0 && $scope.annotation.formFieldName.length == 0)
            return;

        $timeout(function() {
            $scope.annotation.formFieldName = $scope.property.formFieldName;
            $scope.setModifiedToUpdate();
            refreshAnnotationInPage($scope.annotation);
        });
    };

    $scope.updateFormFieldValue = function() {
        if ($scope.property.formFieldValue.length == 0 && $scope.annotation.formFieldValue.length == 0)
            return;

        $timeout(function() {
            $scope.annotation.formFieldValue = $scope.property.formFieldValue;
            $scope.setModifiedToUpdate();
            refreshAnnotationInPage($scope.annotation);
        });
    };

    $scope.setModifiedToUpdate = function() {
        $scope.annotation.modified = 'update';

        if (!Default.SAVE_ALL_ANNOTATIONS_ONE_TIME)
            window.Annotationeer.saveAnnotation($scope.annotation);

        if (Default.CREATE_ANNOTATION_EVENTS)
            window.PageManager.createAnnotationEvent($scope.annotation);
    };

    var loadTranslations = function() {
        $('div#propertyContentContainer [data-l10n-id]').each(function(index, element) {
            window.PageManager.translateDOML10n(element, element.getAttribute('data-l10n-id'));
        });
    };
});

angular.module('digitalSignatureForm', []).controller('DigitalSignatureFormController', function($document, $scope) {

    var signaturePad = null;
    var annotation = null;

    $document.on('opened', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'digitalSignatureContainer')
            return;

        var wrapper = document.getElementById('signature-pad');

        var clearButton = wrapper.querySelector('[data-action=clear]');
        clearButton.addEventListener('click', clearSignature);

        var justUseButton = wrapper.querySelector('[data-action=just_use]');
        justUseButton.addEventListener('click', useSignature, false);
        justUseButton.justUse = true;

        var saveUseButton = wrapper.querySelector('[data-action=save_use]');
        saveUseButton.addEventListener('click', useSignature, false);
    });

    var clearSignature = function() {
        if (signaturePad)
            signaturePad.jSignature('reset');
    };

    var useSignature = function(e) {
        if (!signaturePad)
            return;

        if (!signaturePad.jSignature('isModified')) {
            PageManager.showAlert(Message.PROVIDE_SIGNATURE, 'info');
        }
        else {
            window.Annotationeer.saveDigitalSignature(signaturePad, e.target.justUse, annotation);
            $('#digitalSignatureContainer').remodal().close();
        }
    };

    $document.on('closed', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'digitalSignatureContainer')
            return;

        if (e.reason && e.reason == 'cancellation' && !annotation) {
            window.PageManager.ensureSignatureListIsOnScreen();
        }

        // Remove jSignature elements, including the canvas.
        signaturePad.empty();
        $(window).unbind('.jSignature');
        signaturePad = null;
        annotation = null;

        var wrapper = document.getElementById('signature-pad');

        var clearButton = wrapper.querySelector('[data-action=clear]');
        clearButton.removeEventListener('click', clearSignature);

        var justUseButton = wrapper.querySelector('[data-action=just_use]');
        justUseButton.removeEventListener('click', useSignature);

        var saveUseButton = wrapper.querySelector('[data-action=save_use]');
        saveUseButton.removeEventListener('click', useSignature);
    });

    $scope.showDigitalSignaturePad = function(_annotation) {
        var digitalSignatureContainer = $('#digitalSignatureContainer');
        digitalSignatureContainer.removeClass('hidden');
        digitalSignatureContainer.find('button.remodal-close').removeClass('disabled');
        digitalSignatureContainer.find('button.remodal-close').removeAttr('disabled');
        digitalSignatureContainer.remodal().open();

        annotation = _annotation;

        signaturePad = $('#signature');
        signaturePad.jSignature({
            'decor-color': 'transparent',
            'height': '150px'
        });
    };

    $scope.clickX = function() {
        if (!annotation)
            $('#digitalSignatureList').addClass('show');
    };
});

angular.module('uploadStampForm', []).controller('UploadStampFormController', function($document, $scope) {

    $document.on('opened', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'uploadStampContainer')
            return;

        $('#stampList').removeClass('show');

        $('form#stamp-dropzone').dropzone({
            url: Url.restUrl + Url.stampSaveUrl,
            method: 'post',
            headers: {
                'username': Annotationeer.getUsername()
            },
            acceptedFiles: 'image/*',
            parallelUploads: 1,
            maxFiles: 1,
            addRemoveLinks: true,
            clickable: true,
            dictDefaultMessage: window.Message.STAMP_ADD_EMPTY,
            init: function() {
                // Translate intro message.
                var dzMessage = $('div.dz-message');
                PageManager.translateDOML10n(dzMessage[0], dzMessage.attr('data-l1on-id'));

                this.on('success', function(file, response) {
                    file.id = response.id;
                    window.PageManager.addStampToList(response.id, response.stamp, response.width, response.height);
                });
            }
        });
    });

    $document.on('closed', '.remodal', function(e) {
        if ($(e.currentTarget).attr('id') != 'uploadStampContainer')
            return;

        if (e.reason && e.reason == 'cancellation') {
            $scope.clickX();
        }
    });

    $scope.showUploadStampForm = function() {
        var uploadStampContainer = $('#uploadStampContainer');
        uploadStampContainer.removeClass('hidden');
        uploadStampContainer.find('button.remodal-close').removeClass('disabled');
        uploadStampContainer.find('button.remodal-close').removeAttr('disabled');
        uploadStampContainer.remodal().open();
    };

    $scope.clickX = function() {
        $('button#stamp').addClass('toggled');
        var stampList = $('#stampList');
        stampList.addClass('show');
        stampList.scrollTop(0);
        Dropzone.forElement('form#stamp-dropzone').destroy();
    };

});

angular.module('Util', []).service('UtilService', function() {

    var lineStyles = [
        { id: LineStyle.SOLID, name: 'Solid Line' },
        { id: LineStyle.CLOUD, name: 'Cloud' }
    ];

    var measurementTypes = [
        { id: MeasurementType.INCHES, name: 'Inches' },
        { id: MeasurementType.CENTIMETERS, name: 'Centimeters' },
        { id: MeasurementType.MILLIMETERS, name: 'Millimeters' },
        { id: MeasurementType.FOOT_INCH, name: 'Foot-Inch' }
    ];

    this.getMomentFormattedDate = function(date, pattern) {
        return Util.getMomentFormattedDate(date, pattern);
    };

    this.getLineStyles = function() {
        return lineStyles;
    };

    this.getLineStyle= function(id) {
        for (var ls=0; ls<lineStyles.length; ls++) {
            if (lineStyles[ls].id == id)
                return lineStyles[ls];
        }
        return null;
    };

    this.getMeasurementTypes = function() {
        return measurementTypes;
    };

    this.getMeasurementType = function(id) {
        for (var mt=0; mt<measurementTypes.length; mt++) {
            if (measurementTypes[mt].id == id)
                return measurementTypes[mt];
        }
        return null;
    };

    this.setModifiedToUpdate = function(annotation) {
        annotation.modified = 'update';

        if (!Default.SAVE_ALL_ANNOTATIONS_ONE_TIME)
            window.Annotationeer.saveAnnotation(annotation);

        if (Default.CREATE_ANNOTATION_EVENTS)
            window.PageManager.createAnnotationEvent(annotation);
    };

});
