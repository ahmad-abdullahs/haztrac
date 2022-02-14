<?php

//// created: 2019-08-11 19:09:20
//$dictionary["ProductTemplate"]["fields"]["product_templates_product_templates_1"] = array(
//    'name' => 'product_templates_product_templates_1',
//    'type' => 'link',
//    'relationship' => 'product_templates_product_templates_1',
//    'source' => 'non-db',
//    'module' => 'ProductTemplates',
//    'bean_name' => 'ProductTemplate',
//    'vname' => 'LBL_PRODUCTTEMPLATES_PRODUCTTEMPLATES_1_FROM_PRODUCTTEMPLATES_L_TITLE',
//    'id_name' => 'product_templates_product_templates_1product_templates_idb',
////    'link-type' => 'many',
////    'side' => 'left',
//);
//
//$dictionary["ProductTemplate"]["fields"]["product_templates_product_templates_1_right"] = array(
//    'name' => 'product_templates_product_templates_1_right',
//    'type' => 'link',
//    'relationship' => 'product_templates_product_templates_1',
//    'source' => 'non-db',
//    'module' => 'ProductTemplates',
//    'bean_name' => 'ProductTemplate',
//    'side' => 'right',
//    'vname' => 'LBL_PRODUCTTEMPLATES_PRODUCTTEMPLATES_1_FROM_PRODUCTTEMPLATES_R_TITLE',
//    'id_name' => 'product_templates_product_templates_1product_templates_ida',
//    'link-type' => 'many',
//);
////
////$dictionary["ProductTemplate"]["fields"]["product_templates_product_templates_1_name"] = array(
////    'name' => 'product_templates_product_templates_1_name',
////    'type' => 'relate',
////    'source' => 'non-db',
////    'vname' => 'LBL_PRODUCTTEMPLATES_PRODUCTTEMPLATES_1_FROM_PRODUCTTEMPLATES_L_TITLE',
////    'save' => true,
////    'id_name' => 'product_templates_product_templates_1product_templates_ida',
////    'link' => 'product_templates_product_templates_1_right',
////    'table' => 'product_templates',
////    'module' => 'ProductTemplates',
////    'rname' => 'name',
////);
////
////$dictionary["ProductTemplate"]["fields"]["product_templates_product_templates_1product_templates_ida"] = array(
////    'name' => 'product_templates_product_templates_1product_templates_ida',
////    'type' => 'id',
////    'source' => 'non-db',
////    'vname' => 'LBL_PRODUCTTEMPLATES_PRODUCTTEMPLATES_1_FROM_PRODUCTTEMPLATES_R_TITLE_ID',
////    'id_name' => 'product_templates_product_templates_1product_templates_ida',
////    'link' => 'product_templates_product_templates_1_right',
////    'table' => 'product_templates',
////    'module' => 'ProductTemplates',
////    'rname' => 'id',
////    'reportable' => false,
////    'side' => 'right',
////    'massupdate' => false,
////    'duplicate_merge' => 'disabled',
////    'hideacl' => true,
////);

// created: 2019-08-11 19:09:20
$dictionary["ProductTemplate"]["fields"]["product_templates_product_templates_1"] = array(
    'name' => 'product_templates_product_templates_1',
    'type' => 'link',
    'relationship' => 'product_templates_product_templates_1',
    'source' => 'non-db',
    'module' => 'ProductTemplates',
    'bean_name' => 'ProductTemplate',
    'vname' => 'LBL_PRODUCTTEMPLATES_PRODUCTTEMPLATES_1_FROM_PRODUCTTEMPLATES_L_TITLE',
    'id_name' => 'product_templates_product_templates_1product_templates_idb',
    'link-type' => 'many',
    'side' => 'left',
);

$dictionary["ProductTemplate"]["fields"]["product_templates_product_templates_1_right"] = array(
    'name' => 'product_templates_product_templates_1_right',
    'type' => 'link',
    'relationship' => 'product_templates_product_templates_1',
    'source' => 'non-db',
    'module' => 'ProductTemplates',
    'bean_name' => 'ProductTemplate',
    'side' => 'right',
    'vname' => 'LBL_PRODUCTTEMPLATES_PRODUCTTEMPLATES_1_FROM_PRODUCTTEMPLATES_R_TITLE',
    'id_name' => 'product_templates_product_templates_1product_templates_ida',
    'link-type' => 'one',
);
$dictionary["ProductTemplate"]["fields"]["product_templates_product_templates_1_name"] = array(
    'name' => 'product_templates_product_templates_1_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_PRODUCTTEMPLATES_PRODUCTTEMPLATES_1_FROM_PRODUCTTEMPLATES_L_TITLE',
    'save' => true,
    'id_name' => 'product_templates_product_templates_1product_templates_ida',
    'link' => 'product_templates_product_templates_1_right',
    'table' => 'product_templates',
    'module' => 'ProductTemplates',
    'rname' => 'name',
);

$dictionary["ProductTemplate"]["fields"]["product_templates_product_templates_1product_templates_ida"] = array(
    'name' => 'product_templates_product_templates_1product_templates_ida',
    'type' => 'id',
    'source' => 'non-db',
    'vname' => 'LBL_PRODUCTTEMPLATES_PRODUCTTEMPLATES_1_FROM_PRODUCTTEMPLATES_R_TITLE_ID',
    'id_name' => 'product_templates_product_templates_1product_templates_ida',
    'link' => 'product_templates_product_templates_1_right',
    'table' => 'product_templates',
    'module' => 'ProductTemplates',
    'rname' => 'id',
    'reportable' => false,
    'side' => 'right',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
);