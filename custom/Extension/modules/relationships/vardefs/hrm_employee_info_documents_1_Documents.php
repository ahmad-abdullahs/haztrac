<?php
// created: 2020-08-29 18:58:54
$dictionary["Document"]["fields"]["hrm_employee_info_documents_1"] = array (
  'name' => 'hrm_employee_info_documents_1',
  'type' => 'link',
  'relationship' => 'hrm_employee_info_documents_1',
  'source' => 'non-db',
  'module' => 'HRM_Employee_Info',
  'bean_name' => 'HRM_Employee_Info',
  'side' => 'right',
  'vname' => 'LBL_HRM_EMPLOYEE_INFO_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'id_name' => 'hrm_employee_info_documents_1hrm_employee_info_ida',
  'link-type' => 'one',
);
$dictionary["Document"]["fields"]["hrm_employee_info_documents_1_name"] = array (
  'name' => 'hrm_employee_info_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_HRM_EMPLOYEE_INFO_DOCUMENTS_1_FROM_HRM_EMPLOYEE_INFO_TITLE',
  'save' => true,
  'id_name' => 'hrm_employee_info_documents_1hrm_employee_info_ida',
  'link' => 'hrm_employee_info_documents_1',
  'table' => 'hrm_employee_info',
  'module' => 'HRM_Employee_Info',
  'rname' => 'full_name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["Document"]["fields"]["hrm_employee_info_documents_1hrm_employee_info_ida"] = array (
  'name' => 'hrm_employee_info_documents_1hrm_employee_info_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_HRM_EMPLOYEE_INFO_DOCUMENTS_1_FROM_DOCUMENTS_TITLE_ID',
  'id_name' => 'hrm_employee_info_documents_1hrm_employee_info_ida',
  'link' => 'hrm_employee_info_documents_1',
  'table' => 'hrm_employee_info',
  'module' => 'HRM_Employee_Info',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
