<?php
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
$admin_option_defs = [];
$admin_option_defs['Administration']['hint_data_enrichment'] = [
    //Icon name. Available icons are located in ./themes/default/images
    'Administration',

    //Link name label
    'LBL_HINT_NAME',

    //Link description label
    'LBL_HINT_DESCRIPTION',

    //Link URL
    'javascript:void(parent.SUGAR.App.router.navigate("hint/data-enrichment", {trigger: true}));',
];

$admin_option_defs['Administration']['hint_resync'] = [
    false,
    'LBL_HINT_RESYNC',
    'LBL_HINT_RESYNC_DESCRIPTION',
    'javascript:void(parent.SUGAR.App.router.navigate("hint/insights/resync", {trigger: true}));',
];

$admin_option_defs['Administration']['hint_config'] = [
    'Administration',
    'LBL_HINT_CONFIG_NAME',
    'LBL_HINT_CONFIG_DESCRIPTION',
    'javascript:void(parent.SUGAR.App.router.navigate("hint/config", {trigger: true}));',
];

$admin_group_header[] = [
    //Section header label
    'LBL_HINT_SECTION_HEADER',

    //$other_text parameter for get_form_header()
    '',

    //$show_help parameter for get_form_header()
    false,

    //Section links
    $admin_option_defs,

    //Section description label
    'LBL_HINT_SECTION_DESCRIPTION',
];
