<?php
$admin_option_defs = array();

$admin_option_defs['Administration']['login_licence_link'] = array(
    '',
    // title of the link 
    $mod_strings['LBL_LOGINPLUGINLICENSE_TITLE'],
    // description for the link
    $mod_strings['LBL_LOGIN_LICENSE'],
    // where to send the user when the link is clicked
    'index.php?module=Administration&action=license',
);


$admin_option_defs['Administration']['Login_Manage_Images'] = array(
    '',
    'LBL_UPLOAD_IMAGE_FOR_LOGIN_SLIDER',
    'LBL_UPLOAD_IMAGE_FOR_LOGIN_SLIDER_DESCRITOPN',
    'index.php?module=Administration&action=loginpageslidergallery'
);

$admin_option_defs['Administration']['Login_Quote_Category'] = array(
    '',
    'LBL_QUOTE_CATEGORY',
    'LBL_QUOTE_CATEGORY_DESCRIPTION',
     'javascript:parent.SUGAR.App.router.navigate("bc_QuoteCategory", {trigger: true})'
);
$admin_option_defs['Administration']['Login_Quote'] = array(
    '',
    'LBL_QUOTE',
    'LBL_QUOTE_DESCRIPTION',
    'javascript:parent.SUGAR.App.router.navigate("bc_Quote", {trigger: true});'
);
$admin_group_header[] = array(
    'LBL_UPLOAD_IMAGE_FOR_LOGIN_SLIDER_SECTION',
    '',
    false,
    $admin_option_defs,
    'LBL_UPLOAD_IMAGE_FOR_LOGIN_SLIDER_SECTION_DESCRIPTION'
);

