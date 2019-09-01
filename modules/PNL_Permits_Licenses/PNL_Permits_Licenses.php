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
require_once('modules/PNL_Permits_Licenses/PNL_Permits_Licenses_sugar.php');

class PNL_Permits_Licenses extends PNL_Permits_Licenses_sugar {

    public function save($check_notify = false) {
        $ret = parent::save($check_notify);

        $this->setPreviewURL();

        return $ret;
    }

    private function setPreviewURL() {
        $this->license_preview_c = 'https://docs.google.com/viewer?url=https%3A%2F%2Fsugar.haztrac.com%2F%3FentryPoint%3DLicense_Preview%26report_id%3D' . $this->id . '&embedded=true&chrome=false&dov=1';

        $this->db->query("UPDATE {$this->table_name}_cstm SET license_preview_c='$this->license_preview_c' WHERE id_c='{$this->id}'");
    }

}
