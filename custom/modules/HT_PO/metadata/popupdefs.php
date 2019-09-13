<?php
$popupMeta = array (
    'moduleMain' => 'HT_PO',
    'varName' => 'HT_PO',
    'orderBy' => 'ht_po.name',
    'whereClauses' => array (
  'name' => 'ht_po.name',
),
    'searchInputs' => array (
  0 => 'ht_po_number',
  1 => 'name',
  2 => 'priority',
  3 => 'status',
),
    'listviewdefs' => array (
  'PO_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_PO_DATE',
    'width' => 10,
    'default' => true,
    'name' => 'po_date',
  ),
  'NAME' => 
  array (
    'width' => '45',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
    'name' => 'name',
  ),
  'PO_AMOUNT_C' => 
  array (
    'related_fields' => 
    array (
      0 => 'currency_id',
      1 => 'base_rate',
    ),
    'type' => 'currency',
    'default' => true,
    'label' => 'LBL_PO_AMOUNT',
    'currency_format' => true,
    'width' => '35',
    'name' => 'po_amount_c',
  ),
  'ACCOUNT_ISSUER_C' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_ACCOUNT_ISSUER',
    'id' => 'ACCOUNT_ID_C',
    'link' => true,
    'width' => 10,
    'default' => true,
    'name' => 'account_issuer_c',
  ),
  'DATE_ENTERED' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'label' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'default' => true,
    'name' => 'date_entered',
  ),
  'EXPIRE_DATE' => 
  array (
    'type' => 'date',
    'label' => 'LBL_EXPIRE_DATE',
    'width' => 10,
    'default' => true,
    'name' => 'expire_date',
  ),
  'TEAM_NAME' => 
  array (
    'width' => '25',
    'label' => 'LBL_TEAM',
    'default' => true,
    'name' => 'team_name',
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => 10,
    'default' => true,
    'name' => 'description',
  ),
),
);
