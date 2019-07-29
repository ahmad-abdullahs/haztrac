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
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo translate('LBL_CONFIRMATION_TITLE', 'EmailAddresses');?></title>
        <style>
            .confirmation {
                font-family: Arial;
                font-weight: normal;
                margin: 0 auto;
                width: 320px;
            }

            .confirmation_image {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 109px;
                margin-top: 100px;
                margin-bottom: 20px;
            }

            .confirmation_title {
                font-size: 24px;
                text-align: center;
                color: #000000;
                padding-bottom: 5px
            }

            .confirmation_message {
                font-size: 14px;
                text-align: left;
                color: #303030;
            }
        </style>
    </head>
    <body>
    <div class="confirmation">
        <div class="confirmation_image">
            <?php
                $siteUrl = $GLOBALS['sugar_config']['site_url'];
                $confirmationImage = $siteUrl . '/include/images/email_address_confirmed.png';
            ?>
            <img src="<?php echo $confirmationImage;?>"/>
        </div>
        <div class="confirmation_title">
            <?php
            echo translate('LBL_CONFIRMATION_TITLE', 'EmailAddresses');
            ?>
        </div>
        <div class="confirmation_message">
            <?php
            echo translate('LBL_CONFIRMATION_MESSAGE', 'EmailAddresses');
            ?>
        </div>
    </div>
    </body>
</html>
