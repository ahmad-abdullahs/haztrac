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

require_once('modules/Notes/NotesApiHelper.php');

class CustomNotesApiHelper extends NotesApiHelper {

    public function formatForApi(\SugarBean $bean, array $fieldList = array(), array $options = array()) {
        global $db, $sugar_config;

        $data = parent::formatForApi($bean, $fieldList, $options);

        $data['notes_preview'] = "{$sugar_config['site_url']}/pdfs/report-preview.jpg#zoom=60";
        $data['fileExist'] = false;
        if (!empty($bean->id) && !empty($bean->file_ext)) {
            if (file_exists("upload/{$bean->id}")) {
                $data['notes_preview'] = "{$sugar_config['site_url']}/upload/{$bean->id}#zoom=60";

                if ($bean->file_ext == 'pdf') {
                    $data['popOutFullViewLink'] = "#bwc/index.php?entryPoint=openpdf&id={$bean->id}&uploadDir=upload";
                } else {
                    $data['popOutFullViewLink'] = "{$sugar_config['site_url']}/index.php?entryPoint=download&id={$bean->id}&type=Notes";
                }

                $data['fileExist'] = true;
            }
        }

        return $data;
    }

}
