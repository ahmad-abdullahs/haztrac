<?php

class PNL_Permits_LicensesApiHelper extends SugarBeanApiHelper {

    public function formatForApi(\SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $data = parent::formatForApi($bean, $fieldList, $options);

        global $sugar_config;
        // This license_preview_id is for the dashlet, if the file is attached then 
        // it will show the pdf otherwise it will show the white background jpg.
        $data['license_preview_id'] = $bean->id;

        // This is for the preview and the record view.
        $data['license_preview_c'] = "{$sugar_config['site_url']}/upload/report-preview.jpg#zoom=60";
        $data['fileExist'] = false;
        if (file_exists("upload/{$bean->id}")) {
            $data['license_preview_c'] = "{$sugar_config['site_url']}/upload/{$bean->id}#zoom=60";
            $data['fileExist'] = true;
        } else {
            $data['license_preview_id'] = "report-preview.jpg";
        }

        return $data;
    }

}
