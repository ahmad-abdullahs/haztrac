<?php
$module_name = 'HRM_Employee_Info';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'type' => 'fullname',
                'fields' => 
                array (
                  0 => 'salutation',
                  1 => 'first_name',
                  2 => 'last_name',
                ),
                'link' => true,
                'label' => 'LBL_LIST_NAME',
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'title',
                'label' => 'LBL_TITLE',
                'default' => true,
                'enabled' => true,
              ),
              2 => 
              array (
                'name' => 'employee_id_num',
                'label' => 'LBL_EMPLOYEE_ID_NUM',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'phone_work',
                'label' => 'LBL_OFFICE_PHONE',
                'default' => true,
                'enabled' => true,
              ),
              4 => 
              array (
                'name' => 'email',
                'label' => 'LBL_EMAIL_ADDRESS',
                'link' => true,
                'default' => true,
                'enabled' => true,
              ),
              5 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'do_not_call',
                'label' => 'LBL_DO_NOT_CALL',
                'default' => false,
                'enabled' => true,
              ),
              8 => 
              array (
                'name' => 'phone_home',
                'label' => 'LBL_HOME_PHONE',
                'default' => false,
                'enabled' => true,
              ),
              9 => 
              array (
                'name' => 'phone_mobile',
                'label' => 'LBL_MOBILE_PHONE',
                'default' => false,
                'enabled' => true,
              ),
              10 => 
              array (
                'name' => 'phone_other',
                'label' => 'LBL_WORK_PHONE',
                'default' => false,
                'enabled' => true,
              ),
              11 => 
              array (
                'name' => 'phone_fax',
                'label' => 'LBL_FAX_PHONE',
                'default' => false,
                'enabled' => true,
              ),
              12 => 
              array (
                'name' => 'primary_address_street',
                'label' => 'LBL_PRIMARY_ADDRESS_STREET',
                'default' => false,
                'enabled' => true,
              ),
              13 => 
              array (
                'name' => 'primary_address_city',
                'label' => 'LBL_PRIMARY_ADDRESS_CITY',
                'default' => false,
                'enabled' => true,
              ),
              14 => 
              array (
                'name' => 'primary_address_state',
                'label' => 'LBL_PRIMARY_ADDRESS_STATE',
                'default' => false,
                'enabled' => true,
              ),
              15 => 
              array (
                'name' => 'primary_address_postalcode',
                'label' => 'LBL_PRIMARY_ADDRESS_POSTALCODE',
                'default' => false,
                'enabled' => true,
              ),
              16 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'default' => false,
                'enabled' => true,
                'readonly' => true,
              ),
              17 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
