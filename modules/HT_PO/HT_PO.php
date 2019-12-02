<?PHP

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
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/HT_PO/HT_PO_sugar.php');
require_once('include/upload_file.php');

class HT_PO extends HT_PO_sugar {

    function deleteAttachment($isduplicate = 'false') {
        if ($this->ACLAccess('edit')) {
            if ($isduplicate == 'true') {
                return true;
            }
            $removeFile = 'upload://{$this->id}';
        }

        if (SugarAutoloader::fileExists($removeFile)) {
            if (!UploadFile::unlink($removeFile)) {
                $GLOBALS['log']->error("*** Could not unlink() file: [ {$removeFile} ]");
            } else {
                $this->filename = '';
                $this->file_mime_type = '';
                $this->file = '';
                $this->save();
                return true;
            }
        } else {
            $this->filename = '';
            $this->file_mime_type = '';
            $this->file = '';
            $this->save();
            return true;
        }
        return false;
    }

}
