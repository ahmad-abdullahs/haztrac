{*
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
*}
{literal}<script type="text/javascript" language="Javascript" src="include/javascript/tiny_mce/tiny_mce.js?v=od_iHHnXG4uB9UO_PdDhOg"></script>
<script type="text/javascript" language="Javascript">
if (!SUGAR.util.isTouchScreen()) {
    tinyMCE.init({
        "convert_urls": false,
        "valid_children": "+body[style]",
        "height": 600,
        "width": "100%",
        "theme": "advanced",
        "theme_advanced_toolbar_align": "left",
        "theme_advanced_toolbar_location": "top",
        "theme_advanced_buttons1": "code,help,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,styleselect,formatselect,fontselect,fontsizeselect,",
        "theme_advanced_buttons2": "cut,copy,paste,pastetext,pasteword,selectall,separator,search,replace,separator,bullist,numlist,separator,outdent,indent,separator,ltr,rtl,separator,undo,redo,separator, link,unlink,anchor,image,separator,sub,sup,separator,charmap,visualaid",
        "theme_advanced_buttons3": "tablecontrols,separator,advhr,hr,removeformat,separator,insertdate,inserttime,separator,preview,spellchecker",
        "theme_advanced_statusbar_location": "none",
        "strict_loading_mode": true,
        "mode": "exact",
        "language": "en",
        "plugins": "advhr,insertdatetime,table,preview,paste,searchreplace,directionality,spellchecker",
        "elements": "body_html",
        "extended_valid_elements": "style[dir|lang|media|title|type],hr[class|width|size|noshade],@[class|style]",
        "content_css": "include/javascript/tiny_mce/themes/advanced/skins/default/content.css",
        "apply_source_formatting": true,
        "cleanup_on_startup": true,
        "relative_urls": false,
        "directionality": "ltr",
        setup : function(ed) {
            ed.onInit.add(function(ed, e) {
                ed.onClick.add(function(ed, e) {
                    lastfieldSelected = 'body_html';
                });
            });
        }
    });
} else {
    document.getElementById('body_html').style.width = '100%';
    document.getElementById('body_html').style.height = '100px';
}
</script>{/literal}
{literal}<script type="text/javascript" language="Javascript">
if (!SUGAR.util.isTouchScreen()) {
    tinyMCE.init({
        "convert_urls": false,
        "valid_children": "+body[style]",
        "height": 250,
        "width": "100%",
        "theme": "advanced",
        "theme_advanced_toolbar_align": "left",
        "theme_advanced_toolbar_location": "top",
        "theme_advanced_buttons1": "code,help,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,styleselect,formatselect,fontselect,fontsizeselect,",
        "theme_advanced_buttons2": "cut,copy,paste,pastetext,pasteword,selectall,separator,search,replace,separator,bullist,numlist,separator,outdent,indent,separator,ltr,rtl,separator,undo,redo,separator, link,unlink,anchor,image,separator,sub,sup,separator,charmap,visualaid",
        "theme_advanced_buttons3": "tablecontrols,separator,advhr,hr,removeformat,separator,insertdate,inserttime,separator,preview,spellchecker",
        "theme_advanced_statusbar_location": "none",
        "strict_loading_mode": true,
        "mode": "exact",
        "language": "en",
        "plugins": "advhr,insertdatetime,table,preview,paste,searchreplace,directionality,spellchecker",
        "elements": "header_html",
        "extended_valid_elements": "style[dir|lang|media|title|type],hr[class|width|size|noshade],@[class|style]",
        "content_css": "include/javascript/tiny_mce/themes/advanced/skins/default/content.css",
        "apply_source_formatting": true,
        "cleanup_on_startup": true,
        "relative_urls": false,
        "directionality": "ltr",
        setup : function(ed) {
            ed.onInit.add(function(ed, e) {
                ed.onClick.add(function(ed, e) {
                    lastfieldSelected = 'header_html';
                });
            });
        }
    });
} else {
    document.getElementById('header_html').style.width = '100%';
    document.getElementById('header_html').style.height = '100px';
}
</script>{/literal}
{literal}<script type="text/javascript" language="Javascript">
if (!SUGAR.util.isTouchScreen()) {
    tinyMCE.init({
        "convert_urls": false,
        "valid_children": "+body[style]",
        "height": 250,
        "width": "100%",
        "theme": "advanced",
        "theme_advanced_toolbar_align": "left",
        "theme_advanced_toolbar_location": "top",
        "theme_advanced_buttons1": "code,help,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,styleselect,formatselect,fontselect,fontsizeselect,",
        "theme_advanced_buttons2": "cut,copy,paste,pastetext,pasteword,selectall,separator,search,replace,separator,bullist,numlist,separator,outdent,indent,separator,ltr,rtl,separator,undo,redo,separator, link,unlink,anchor,image,separator,sub,sup,separator,charmap,visualaid",
        "theme_advanced_buttons3": "tablecontrols,separator,advhr,hr,removeformat,separator,insertdate,inserttime,separator,preview,spellchecker",
        "theme_advanced_statusbar_location": "none",
        "strict_loading_mode": true,
        "mode": "exact",
        "language": "en",
        "plugins": "advhr,insertdatetime,table,preview,paste,searchreplace,directionality,spellchecker",
        "elements": "footer_html",
        "extended_valid_elements": "style[dir|lang|media|title|type],hr[class|width|size|noshade],@[class|style]",
        "content_css": "include/javascript/tiny_mce/themes/advanced/skins/default/content.css",
        "apply_source_formatting": true,
        "cleanup_on_startup": true,
        "relative_urls": false,
        "directionality": "ltr",
        setup : function(ed) {
            ed.onInit.add(function(ed, e) {
                ed.onClick.add(function(ed, e) {
                    lastfieldSelected = 'footer_html';
                });
            });
        }
    });
} else {
    document.getElementById('footer_html').style.width = '100%';
    document.getElementById('footer_html').style.height = '100px';
}
</script>{/literal}