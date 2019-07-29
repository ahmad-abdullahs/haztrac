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

$dictionary['pmse_EmailMessage'] = array(
    'table' => 'pmse_email_message',
    'audited' => false,
    'activity_enabled' => false,
    'reassignable' => false,
    'duplicate_merge' => true,
    'fields' => array(
        'from_addr' => array(
            'name' => 'from_addr',
            'vname' => 'LBL_FROM',
            'type' => 'varchar',
            'len' => 255,
            'comment' => 'Email address of person who send the email',
        ),
        'from_name' => array(
            'name' => 'from_name',
            'vname' => 'LBL_FROM_NAME',
            'type' => 'varchar',
            'len' => 255,
            'comment' => 'Name of the sender',
        ),
        'to_addrs' => array(
            'name' => 'to_addrs',
            'vname' => 'LBL_TO',
            'type' => 'text',
            'comment' => 'Email address(es) of person(s) to receive the email',
        ),
        'cc_addrs' => array(
            'name' => 'cc_addrs',
            'vname' => 'LBL_CC',
            'type' => 'text',
            'comment' => 'Email address(es) of person(s) to receive a carbon copy of the email',
        ),
        'bcc_addrs' => array(
            'name' => 'bcc_addrs',
            'vname' => 'LBL_BCC',
            'type' => 'text',
            'comment' => 'Email address(es) of person(s) to receive a blind carbon copy of the email',
        ),
        'body' => array(
            'name' => 'body',
            'vname' => 'LBL_TEXT_BODY',
            'type' => 'longtext',
            'reportable' => false,
            'comment' => 'Email body in plain text',
        ),
        'body_html' => array(
            'name' => 'body_html',
            'vname' => 'LBL_HTML_BODY',
            'type' => 'longhtml',
            'reportable' => false,
            'comment' => 'Email body in HTML format',
        ),
        'subject' => array(
            'name' => 'subject',
            'vname' => 'LBL_SUBJECT',
            'type' => 'name',
            'dbType' => 'varchar',
            'len' => 255,
        ),
        'flow_id' => array(
            'name' => 'flow_id',
            'vname' => 'LBL_FLOW_ID',
            'type' => 'id',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'default' => 0,
        ),
    ),
    'relationships' => array(),
    'optimistic_locking' => true,
    'ignore_templates' => array(
        'taggable',
        'lockable_fields',
        'commentlog',
    ),
);

VardefManager::createVardef('pmse_EmailMessage', 'pmse_EmailMessage');
