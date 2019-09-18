REPLACE INTO `fields_meta_data` (`id`, `name`, `vname`, `custom_module`, `type`, `len`, `required`, `date_modified`, `deleted`, `audited`, `massupdate`, `duplicate_merge`, `reportable`, `importable`, `ext2`, `ext3`) VALUES ('ProductTemplatesproduct_vendor_c', 'product_vendor_c', 'LBL_PRODUCT_VENDOR', 'ProductTemplates', 'relate', '255', '0', '2019-07-27 22:31:28', '0', '0', '0', '1', '1', 'true', 'Accounts', 'v_vendors_id_c');
REPLACE INTO `fields_meta_data` (`id`, `name`, `vname`, `custom_module`, `type`, `len`, `required`, `date_modified`, `deleted`, `audited`, `massupdate`, `duplicate_merge`, `reportable`, `importable`, `ext1`, `ext2`, `ext3`) VALUES ('RevenueLineItemsproduct_vendor_c', 'product_vendor_c', 'LBL_PRODUCT_VENDOR', 'RevenueLineItems', 'relate', '255', '0', '2019-07-27 22:31:28', '0', '0', '0', '1', '1', 'true', '', 'Accounts', 'v_vendors_id_c');


SET SQL_SAFE_UPDATES = 0;
update revenue_line_items_cstm set v_vendors_id_c = '2634fd90-d984-11e9-b356-000c29e77cbc' where  v_vendors_id_c = '3d2aeea0-d8cc-11e9-acbc-000c29e77cbc';	
update revenue_line_items_cstm set v_vendors_id_c = '70e38f04-d985-11e9-bfce-000c29e77cbc' where  v_vendors_id_c = '6d96c12c-9ec0-11e9-b073-000c29e77cbc';	
update revenue_line_items_cstm set v_vendors_id_c = 'c971137c-d984-11e9-b848-000c29e77cbc' where  v_vendors_id_c = '90f465ee-b0c6-11e9-becc-000c29e77cbc';	
update revenue_line_items_cstm set v_vendors_id_c = '502cb68c-ae5b-11e9-b224-000c29e77cbc' where  v_vendors_id_c = '92f915fa-ac21-11e9-8273-000c29e77cbc';	
update revenue_line_items_cstm set v_vendors_id_c = 'f796c46c-d985-11e9-a9c6-000c29e77cbc' where  v_vendors_id_c = 'a5264f44-9ebc-11e9-9d7b-000c29e77cbc';	
update revenue_line_items_cstm set v_vendors_id_c = '6a64f234-d986-11e9-954c-000c29e77cbc' where  v_vendors_id_c = 'b453520c-9e10-11e9-b134-000c29e77cbc';	
update revenue_line_items_cstm set v_vendors_id_c = '2e619afc-d987-11e9-894f-000c29e77cbc' where  v_vendors_id_c = 'eb5990f0-993c-11e9-a575-000c29e77cbc';	
update revenue_line_items_cstm set v_vendors_id_c = '97f29b24-d987-11e9-b693-000c29e77cbc' where  v_vendors_id_c = 'f1db515c-946e-11e9-95f0-000c29e77cbc';	
update product_templates_cstm set v_vendors_id_c = '2634fd90-d984-11e9-b356-000c29e77cbc' where  v_vendors_id_c = '3d2aeea0-d8cc-11e9-acbc-000c29e77cbc';
update product_templates_cstm set v_vendors_id_c = '70e38f04-d985-11e9-bfce-000c29e77cbc' where  v_vendors_id_c = '6d96c12c-9ec0-11e9-b073-000c29e77cbc';
update product_templates_cstm set v_vendors_id_c = 'c971137c-d984-11e9-b848-000c29e77cbc' where  v_vendors_id_c = '90f465ee-b0c6-11e9-becc-000c29e77cbc';
update product_templates_cstm set v_vendors_id_c = '502cb68c-ae5b-11e9-b224-000c29e77cbc' where  v_vendors_id_c = '92f915fa-ac21-11e9-8273-000c29e77cbc';
update product_templates_cstm set v_vendors_id_c = 'f796c46c-d985-11e9-a9c6-000c29e77cbc' where  v_vendors_id_c = 'a5264f44-9ebc-11e9-9d7b-000c29e77cbc';
update product_templates_cstm set v_vendors_id_c = '6a64f234-d986-11e9-954c-000c29e77cbc' where  v_vendors_id_c = 'b453520c-9e10-11e9-b134-000c29e77cbc';
update product_templates_cstm set v_vendors_id_c = '2e619afc-d987-11e9-894f-000c29e77cbc' where  v_vendors_id_c = 'eb5990f0-993c-11e9-a575-000c29e77cbc';
update product_templates_cstm set v_vendors_id_c = '97f29b24-d987-11e9-b693-000c29e77cbc' where  v_vendors_id_c = 'f1db515c-946e-11e9-95f0-000c29e77cbc';

-- vendor has relationship with manifest, lab reports and contacts.