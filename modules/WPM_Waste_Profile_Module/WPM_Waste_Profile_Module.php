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
require_once('modules/WPM_Waste_Profile_Module/WPM_Waste_Profile_Module_sugar.php');
require_once('include/upload_file.php');

class WPM_Waste_Profile_Module extends WPM_Waste_Profile_Module_sugar {

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

    public function save($check_notify = false) {
        $ret = parent::save($check_notify);

        $this->setPreviewURL();

        return $ret;
    }

    private function setPreviewURL() {
        $this->profile_preview = 'https://docs.google.com/viewer?url=https%3A%2F%2Fsugar.haztrac.com%2F%3FentryPoint%3DWPM_Waste_Profile_Preview%26report_id%3D' . $this->id . '&embedded=true&chrome=false&dov=1';

        $this->db->query("UPDATE {$this->table_name}_cstm SET profile_preview='$this->profile_preview' WHERE id_c='{$this->id}'");
    }

}

function getCertificatesForWP() {
    $query = new SugarQuery();
    $query->from(BeanFactory::getBean("wp_terms_and_conditions"), array(
        'team_security' => false
    ));
    $query->select(array('id', 'name'));
    $query->orderBy('name', 'ASC');
    $result = $query->execute();
    $allTermAndConditions = array('' => '');
    foreach ($result as $row) {
        $allTermAndConditions[$row['id']] = $row['name'];
    }
    return $allTermAndConditions;
}
