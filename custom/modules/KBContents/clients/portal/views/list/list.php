<?php
$viewdefs['KBContents'] = 
array (
  'portal' => 
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
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'related_fields' => 
                array (
                  0 => 'kbdocument_id',
                  1 => 'kbarticle_id',
                ),
              ),
              1 => 
              array (
                'name' => 'category_name',
                'label' => 'LBL_CATEGORY_NAME',
                'default' => true,
                'enabled' => true,
              ),
              2 => 
              array (
                'name' => 'language',
                'label' => 'LBL_LANG',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'type' => 'enum-config',
                'key' => 'languages',
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_entered',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
