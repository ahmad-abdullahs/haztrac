<?php
// created: 2015-11-10 09:16:50
$dictionary["bc_Quote"]["fields"]["bc_quotecategory_bc_quote"] = array (
  'name' => 'bc_quotecategory_bc_quote',
  'type' => 'link',
  'relationship' => 'bc_quotecategory_bc_quote',
  'source' => 'non-db',
  'module' => 'bc_QuoteCategory',
  'bean_name' => 'bc_QuoteCategory',
  'side' => 'right',
  'vname' => 'LBL_BC_QUOTECATEGORY_BC_QUOTE_FROM_BC_QUOTE_TITLE',
  'id_name' => 'bc_quotecategory_bc_quotebc_quotecategory_ida',
  'link-type' => 'one',
);
$dictionary["bc_Quote"]["fields"]["bc_quotecategory_bc_quote_name"] = array (
  'name' => 'bc_quotecategory_bc_quote_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_BC_QUOTECATEGORY_BC_QUOTE_FROM_BC_QUOTECATEGORY_TITLE',
  'save' => true,
  'id_name' => 'bc_quotecategory_bc_quotebc_quotecategory_ida',
  'link' => 'bc_quotecategory_bc_quote',
  'table' => 'bc_quotecategory',
  'module' => 'bc_QuoteCategory',
  'rname' => 'name',
  'required' => true,
);
$dictionary["bc_Quote"]["fields"]["bc_quotecategory_bc_quotebc_quotecategory_ida"] = array (
  'name' => 'bc_quotecategory_bc_quotebc_quotecategory_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_BC_QUOTECATEGORY_BC_QUOTE_FROM_BC_QUOTE_TITLE_ID',
  'id_name' => 'bc_quotecategory_bc_quotebc_quotecategory_ida',
  'link' => 'bc_quotecategory_bc_quote',
  'table' => 'bc_quotecategory',
  'module' => 'bc_QuoteCategory',
  'reportable' => false,
  'side' => 'right',
  'rname' => 'id',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
