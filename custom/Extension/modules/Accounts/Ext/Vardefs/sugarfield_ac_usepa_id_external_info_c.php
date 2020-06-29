<?php

global $sugar_config;
$siteURL = $sugar_config['site_url'];
// created: 2020-06-28 03:14:22
$dictionary['Account']['fields']['ac_usepa_id_external_info_c']['default'] = "{$siteURL}/screenshots/report-preview.jpg";
$dictionary['Account']['fields']['ac_usepa_id_external_info_c']['labelValue'] = 'EPA Company Site Details';
$dictionary['Account']['fields']['ac_usepa_id_external_info_c']['dependency'] = '';
$dictionary['Account']['fields']['ac_usepa_id_external_info_c']['height'] = '800';
$dictionary['Account']['fields']['ac_usepa_id_external_info_c']['calculated'] = true;
$dictionary['Account']['fields']['ac_usepa_id_external_info_c']['enforced'] = true;
$dictionary['Account']['fields']['ac_usepa_id_external_info_c']['formula'] = 'concat("epaInfoDir/",$ac_usepa_id_c,".html")';
