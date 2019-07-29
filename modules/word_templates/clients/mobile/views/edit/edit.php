<?php
$module_name = 'word_templates';
$viewdefs[$module_name] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'edit' => 
      array (
        'templateMeta' => 
        array (
          'maxColumns' => '1',
          'widths' => 
          array (
            0 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
            1 => 
            array (
              'label' => '10',
              'field' => '30',
            ),
          ),
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'name' => 'LBL_PANEL_DEFAULT',
            'columns' => '1',
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'document_name',
                'label' => 'LBL_DOC_NAME',
              ),
              1 => 
              array (
                'name' => 'uploadfile',
                'displayParams' => 
                array (
                  'link' => 'uploadfile',
                  'id' => 'id',
                ),
              ),
              2 => 'active_date',
              3 => 'exp_date',
              4 => 'assigned_user_name',
            ),
          ),
        ),
      ),
    ),
  ),
);
