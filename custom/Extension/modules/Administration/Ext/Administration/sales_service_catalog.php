<?php

foreach ($admin_group_header as $key => $header) {
	if ($header[0] == 'LBL_PRICE_LIST_TITLE') {
		$admin_group_header[$key][3]['Products'] = array();

		$admin_group_header[$key][3]['Products']['product_catalog'] = $header[3]['Products']['product_catalog'];
		$admin_group_header[$key][3]['Products']['HT_Sales_Service_Catalog'] = array('Products','LBL_SALES_SERVICE_CATALOG_TITLE','LBL_SALES_SERVICE_CATALOG','javascript:parent.SUGAR.App.router.navigate("HT_Sales_Service_Catalog", {trigger: true});');
		$admin_group_header[$key][3]['Products']['manufacturers'] = $header[3]['Products']['manufacturers'];
		$admin_group_header[$key][3]['Products']['product_categories'] = $header[3]['Products']['product_categories'];
		$admin_group_header[$key][3]['Products']['shipping_providers'] = $header[3]['Products']['shipping_providers'];
		$admin_group_header[$key][3]['Products']['product_types'] = $header[3]['Products']['product_types'];

		break;
	}
}