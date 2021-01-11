/********************************************************************
 * Copyright (C) 2016-Present Mark Chester Goking <chitgoks@gmail.com>.
 *
 * This file is part of Annotationeer and it can not be copied
 * and/or distributed without the express permission of the author.
 ********************************************************************/

/**
 * These are the url properties that are used by Annotationeer to communicate with the backend.<br/>
 * These should be overridden and placed in {@link Override.overrideDefaultVariables|Override.overrideDefaultVariables()}.
 * @namespace
 */
var Url = { };

/**
 * The domain of the rest API backend.
 * @type {string}
 */
// -chnaged to below- Url.hostUrl =  window.location.protocol + '//' + window.location.hostname;
// ahmad
// -----START-----
if(parent.SUGAR){
    Url.hostUrl = parent.SUGAR.App.config.signDocURL.url;
} else {
    Url.hostUrl = hostUrl;
}
// -----END-----
/**
 * The url where documents are located.
 * @type {string}
 */
Url.docUrl = Url.hostUrl + '/pdf.js/web/';

/**
 * The url of the REST API.
 * @type {string}
 */
// -chnaged to below- Url.restUrl = Url.hostUrl + '/ann/silex/web/annotationeer/';
// ahmad
// -----START-----
Url.restUrl = Url.hostUrl + 'annotationeer/';
// -----END-----

/**
 * The url endpoint for saving annotation.
 * @type {string}
 */
Url.annotationSaveUrl = 'annotations/saveAnnotation.php';

/**
 * The url endpoint for deleting annotation.
 * @type {string}
 */
Url.annotationDeleteUrl = 'annotations/deleteAnnotation.php';

/**
 * The url endpoint for saving signature.
 * @type {string}
 */
/**
 * The url endpoint for deleting signature.
 * @type {string}
 */
// -chnaged to below- Url.signatureSaveUrl = 'signature';
// -chnaged to below- Url.signatureDeleteUrl = 'signature';
// ahmad
// -----START-----
Url.signatureSaveUrl = 'annotations/addSignature.php';
Url.signatureDeleteUrl = 'annotations/deleteSignature.php';
// -----END-----
/**
 * The url path where stamp images are located.
 * @type {string}
 */
Url.stampFolderUrl = 'images/';

/**
 * The url path where review status icons are located.
 * @type {string}
 */
Url.reviewStatusFolderUrl = 'images/';

/**
 * The url endpoint for saving comment.
 * @type {string}
 */
Url.commentSaveUrl = 'annotation/[annotation_id]/comment';

Url.commentImageUrl = 'annotation/[comment_id]/commentImage';
/**
 * The url endpoint for deleting annotation.
 * @type {string}
 */
Url.commentDeleteUrl = 'annotation/[annotation_id]/comment';

Url.annotationPositionInsert = 'annotation/[document_id]/position';
/**
 * The url endpoint for saving review status.
 * @type {string}
 */
Url.reviewStatusSaveUrl = 'annotation/[annotation_id]/comment/[comment_id]/review_status'

/**
 * The url endpoint for exporting annotations to PDF.
 * @type {string}
 */
Url.exportAnnotationUrl = 'export';

/**
 * The url endpoint for saving bookmark.
 * @type {string}
 */
Url.bookmarkSaveUrl = 'bookmark';

/**
 * The url endpoint for deleting bookmark.
 * @type {string}
 */
Url.bookmarkDeleteUrl = 'bookmark';

/**
 * The url endpoint for saving custom stamp.
 * @type {string}
 */
Url.stampSaveUrl = 'stamp';

/**
 * The url endpoint for deleting custom stamp.
 * @type {string}
 */
Url.stampDeleteUrl = 'stamp';

/**
 * The url endpoint for saving PieceInformation.
 * @type {string}
 */
Url.pieceinfoSaveUrl = 'annotation/[annotation_id]/pieceinfosave';

/**
 * The url endpoint for saving welder Information.
 * @type {string}
 */
Url.welderinfoSaveUrl = 'annotation/[annotation_id]/welderinfosave';


Url.weldermarkUrl = 'annotation/getMarkdetail';

Url.MarkinfoUpdateUrl = 'annotation/[annotation_id]/MarkinfoUpdateUrl';

Url.PositionshiftUrl = 'annotation/getPositionshiftDetail';
Url.PositionDeleteUrl = 'annotation/[inspection_id]/PositionDeleteDetail';
