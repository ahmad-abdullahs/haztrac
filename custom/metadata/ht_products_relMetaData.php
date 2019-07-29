<?php

$dictionary['ht_product_bundle_product'] = array(
    'table' => 'ht_product_bundle_product',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
        'bundle_id' => array(
            'name' => 'bundle_id',
            'type' => 'id',
        ),
        'product_id' => array(
            'name' => 'product_id',
            'type' => 'id',
        ),
        'product_index' => array(
            'name' => 'product_index',
            'type' => 'int',
            'len' => '11',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'prod_bundl_prodpk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'idx_pbp_bundle',
            'type' => 'index',
            'fields' => array(
                'bundle_id',
            ),
        ),
        array(
            'name' => 'idx_pbp_quote',
            'type' => 'index',
            'fields' => array(
                'product_id',
            ),
        ),
        array(
            'name' => 'idx_pbp_bq',
            'type' => 'alternate_key',
            'fields' => array(
                'product_id',
                'bundle_id',
            ),
        ),
    ),
    'relationships' => array(
        'ht_product_bundle_product' => array(
            'lhs_module' => 'HT_SS_ProductBundles',
            'lhs_table' => 'ht_ss_productbundles',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_Sales_Service_Products',
            'rhs_table' => 'ht_sales_service_products',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'ht_product_bundle_product',
            'join_key_lhs' => 'bundle_id',
            'join_key_rhs' => 'product_id',
            'true_relationship_type' => 'one-to-many',
        ),
    ),
);

$dictionary['projects_ht_products'] = array(
    'table' => 'projects_ht_products',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'product_id' => array(
            'name' => 'product_id',
            'type' => 'id',
        ),
        'project_id' => array(
            'name' => 'project_id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'projects_products_pk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'idx_proj_prod_project',
            'type' => 'index',
            'fields' => array(
                'project_id',
            ),
        ),
        array(
            'name' => 'idx_proj_prod_product',
            'type' => 'index',
            'fields' => array(
                'product_id',
            ),
        ),
        array(
            'name' => 'projects_products_alt',
            'type' => 'alternate_key',
            'fields' => array(
                'project_id',
                'product_id',
            ),
        ),
    ),
    'relationships' => array(
        'projects_ht_products' => array(
            'lhs_module' => 'Project',
            'lhs_table' => 'project',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_Sales_Service_Products',
            'rhs_table' => 'ht_sales_service_products',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'projects_ht_products',
            'join_key_lhs' => 'project_id',
            'join_key_rhs' => 'product_id',
        ),
    ),
);

$dictionary['contracts_ht_products'] = array(
    'table' => 'contracts_ht_products',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'product_id' => array(
            'name' => 'product_id',
            'type' => 'id',
        ),
        'contract_id' => array(
            'name' => 'contract_id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'contracts_prod_pk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'contracts_prod_alt',
            'type' => 'alternate_key',
            'fields' => array(
                'contract_id',
                'product_id',
            ),
        ),
    ),
    'relationships' => array(
        'contracts_ht_products' => array(
            'lhs_module' => 'Contracts',
            'lhs_table' => 'contracts',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_Sales_Service_Products',
            'rhs_table' => 'ht_sales_service_products',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'contracts_ht_products',
            'join_key_lhs' => 'contract_id',
            'join_key_rhs' => 'product_id',
        ),
    ),
);

$dictionary['documents_ht_products'] = array(
    'true_relationship_type' => 'many-to-many',
    'relationships' => array(
        'documents_ht_products' => array(
            'lhs_module' => 'Documents',
            'lhs_table' => 'documents',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_Sales_Service_Products',
            'rhs_table' => 'ht_sales_service_products',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'documents_ht_products',
            'join_key_lhs' => 'document_id',
            'join_key_rhs' => 'product_id',
        ),
    ),
    'table' => 'documents_ht_products',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
            'len' => 36,
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => true,
        ),
        'document_id' => array(
            'name' => 'document_id',
            'type' => 'id',
            'len' => 36,
        ),
        'product_id' => array(
            'name' => 'product_id',
            'type' => 'id',
            'len' => 36,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'documents_productsspk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'documents_products_product_id',
            'type' => 'alternate_key',
            'fields' => array(
                'product_id',
                'document_id',
            ),
        ),
        array(
            'name' => 'documents_products_document_id',
            'type' => 'alternate_key',
            'fields' => array(
                'document_id',
                'product_id',
            ),
        ),
    ),
);

$dictionary['ht_product_ht_product'] = array(
    'table' => 'ht_product_ht_product',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'parent_id' => array(
            'name' => 'parent_id',
            'type' => 'id',
        ),
        'child_id' => array(
            'name' => 'child_id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'prod_prodpk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'idx_pp_parent',
            'type' => 'index',
            'fields' => array(
                'parent_id',
            ),
        ),
        array(
            'name' => 'idx_pp_child',
            'type' => 'index',
            'fields' => array(
                'child_id',
            ),
        ),
    ),
    'relationships' => array(
        'ht_product_ht_product' => array(
            'lhs_module' => 'HT_Sales_Service_Products',
            'lhs_table' => 'ht_sales_service_products',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_Sales_Service_Products',
            'rhs_table' => 'ht_sales_service_products',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'ht_product_ht_product',
            'join_key_lhs' => 'parent_id',
            'join_key_rhs' => 'child_id',
            'reverse' => '1',
        ),
    ),
);

$dictionary['ht_product_bundle_quote'] = array(
    'table' => 'ht_product_bundle_quote',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
        'bundle_id' => array(
            'name' => 'bundle_id',
            'type' => 'id',
        ),
        'quote_id' => array(
            'name' => 'quote_id',
            'type' => 'id',
        ),
        'bundle_index' => array(
            'name' => 'bundle_index',
            'type' => 'int',
            'len' => '11',
            'default' => 0,
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'prod_bundl_quotepk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'idx_pbq_bundle',
            'type' => 'index',
            'fields' => array(
                'bundle_id',
            ),
        ),
        array(
            'name' => 'idx_pbq_quote',
            'type' => 'index',
            'fields' => array(
                'quote_id',
            ),
        ),
        array(
            'name' => 'idx_pbq_bq',
            'type' => 'alternate_key',
            'fields' => array(
                'quote_id',
                'bundle_id',
            ),
        ),
        array(
            'name' => 'bundle_index_idx',
            'type' => 'index',
            'fields' => array(
                'bundle_index',
            ),
        ),
    ),
    'relationships' => array(
        'ht_product_bundle_quote' => array(
            'lhs_module' => 'HT_SS_Quotes',
            'lhs_table' => 'ht_ss_quotes',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_SS_ProductBundles',
            'rhs_table' => 'ht_ss_productbundles',
            'rhs_key' => 'id',
            'relationship_type' => 'one-to-many',
            'join_table' => 'ht_product_bundle_quote',
            'join_key_lhs' => 'quote_id',
            'join_key_rhs' => 'bundle_id',
            'true_relationship_type' => 'one-to-many',
        ),
    ),
);

$dictionary['ht_product_bundle_note'] = array(
    'table' => 'ht_product_bundle_note',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
        'bundle_id' => array(
            'name' => 'bundle_id',
            'type' => 'id',
        ),
        'note_id' => array(
            'name' => 'note_id',
            'type' => 'id',
        ),
        'note_index' => array(
            'name' => 'note_index',
            'type' => 'int',
            'len' => '11',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'prod_bundl_notepk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'idx_pbn_bundle',
            'type' => 'index',
            'fields' => array(
                'bundle_id',
            ),
        ),
        array(
            'name' => 'idx_pbn_note',
            'type' => 'index',
            'fields' => array(
                'note_id',
            ),
        ),
        array(
            'name' => 'idx_pbn_pb_nb',
            'type' => 'alternate_key',
            'fields' => array(
                'note_id',
                'bundle_id',
            ),
        ),
    ),
    'relationships' => array(
        'ht_product_bundle_note' => array(
            'lhs_module' => 'HT_SS_ProductBundles',
            'lhs_table' => 'ht_ss_productbundles',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_SS_ProductBundlesNotes',
            'rhs_table' => 'ht_ss_productbundlesnotes',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'ht_product_bundle_note',
            'join_key_lhs' => 'bundle_id',
            'join_key_rhs' => 'note_id',
            'true_relationship_type' => 'one-to-many',
        ),
    ),
);


$dictionary['ht_quotes_accounts'] = array(
    'table' => 'ht_quotes_accounts',
    'true_relationship_type' => 'one-to-many',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'quote_id' => array(
            'name' => 'quote_id',
            'type' => 'id',
        ),
        'account_id' => array(
            'name' => 'account_id',
            'type' => 'id',
        ),
        'account_role' => array(
            'name' => 'account_role',
            'type' => 'varchar',
            'len' => '20',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'ht_quotes_accountspk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'idx_acc_qte_acc',
            'type' => 'index',
            'fields' => array(
                'account_id',
            ),
        ),
        array(
            'name' => 'idx_acc_qte_opp',
            'type' => 'index',
            'fields' => array(
                'quote_id',
            ),
        ),
        array(
            'name' => 'idx_quote_account_role',
            'type' => 'alternate_key',
            'fields' => array(
                'quote_id',
                'account_role',
            ),
        ),
    ),
    'relationships' => array(
        'ht_quotes_billto_accounts' => array(
            'rhs_module' => 'HT_SS_Quotes',
            'rhs_table' => 'ht_ss_quotes',
            'rhs_key' => 'id',
            'lhs_module' => 'Accounts',
            'lhs_table' => 'accounts',
            'lhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'true_relationship_type' => 'one-to-many',
            'join_table' => 'ht_quotes_accounts',
            'join_key_rhs' => 'quote_id',
            'join_key_lhs' => 'account_id',
            'relationship_role_column' => 'account_role',
            'relationship_role_column_value' => 'Bill To',
        ),
        'ht_quotes_shipto_accounts' => array(
            'rhs_module' => 'HT_SS_Quotes',
            'rhs_table' => 'ht_ss_quotes',
            'rhs_key' => 'id',
            'lhs_module' => 'Accounts',
            'lhs_table' => 'accounts',
            'lhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'true_relationship_type' => 'one-to-many',
            'join_table' => 'ht_quotes_accounts',
            'join_key_rhs' => 'quote_id',
            'join_key_lhs' => 'account_id',
            'relationship_role_column' => 'account_role',
            'relationship_role_column_value' => 'Ship To',
        ),
    ),
);


$dictionary['ht_quotes_contacts'] = array(
    'table' => 'ht_quotes_contacts',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'contact_id' => array(
            'name' => 'contact_id',
            'type' => 'id',
        ),
        'quote_id' => array(
            'name' => 'quote_id',
            'type' => 'id',
        ),
        'contact_role' => array(
            'name' => 'contact_role',
            'type' => 'varchar',
            'len' => '20',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'ht_quotes_contactspk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'idx_con_qte_con',
            'type' => 'index',
            'fields' => array(
                'contact_id',
            ),
        ),
        array(
            'name' => 'idx_con_qte_opp',
            'type' => 'index',
            'fields' => array(
                'quote_id',
            ),
        ),
        array(
            'name' => 'idx_quote_contact_role',
            'type' => 'alternate_key',
            'fields' => array(
                'quote_id',
                'contact_role',
            ),
        ),
    ),
    'relationships' => array(
        'ht_quotes_contacts_shipto' => array(
            'rhs_module' => 'HT_SS_Quotes',
            'rhs_table' => 'ht_ss_quotes',
            'rhs_key' => 'id',
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'true_relationship_type' => 'one-to-many',
            'join_table' => 'ht_quotes_contacts',
            'join_key_rhs' => 'quote_id',
            'join_key_lhs' => 'contact_id',
            'relationship_role_column' => 'contact_role',
            'relationship_role_column_value' => 'Ship To',
        ),
        'ht_quotes_contacts_billto' => array(
            'rhs_module' => 'HT_SS_Quotes',
            'rhs_table' => 'ht_ss_quotes',
            'rhs_key' => 'id',
            'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'true_relationship_type' => 'one-to-many',
            'join_table' => 'ht_quotes_contacts',
            'join_key_rhs' => 'quote_id',
            'join_key_lhs' => 'contact_id',
            'relationship_role_column' => 'contact_role',
            'relationship_role_column_value' => 'Bill To',
        ),
    ),
);

$dictionary['ht_quotes_opportunities'] = array(
    'table' => 'ht_quotes_opportunities',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'opportunity_id' => array(
            'name' => 'opportunity_id',
            'type' => 'id',
        ),
        'quote_id' => array(
            'name' => 'quote_id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'ht_quotes_opportunitiespk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'idx_opp_qte_opp',
            'type' => 'index',
            'fields' => array(
                'opportunity_id',
            ),
        ),
        array(
            'name' => 'idx_quote_oportunities',
            'type' => 'alternate_key',
            'fields' => array(
                'quote_id',
            ),
        ),
    ),
    'relationships' => array(
        'ht_quotes_opportunities' => array(
            'lhs_module' => 'Opportunities',
            'lhs_table' => 'opportunities',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_SS_Quotes',
            'rhs_table' => 'ht_ss_quotes',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'true_relationship_type' => 'one-to-many',
            'join_table' => 'ht_quotes_opportunities',
            'join_key_lhs' => 'opportunity_id',
            'join_key_rhs' => 'quote_id',
        ),
    ),
);

$dictionary['projects_ht_quotes'] = array(
    'table' => 'projects_ht_quotes',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'quote_id' => array(
            'name' => 'quote_id',
            'type' => 'id',
        ),
        'project_id' => array(
            'name' => 'project_id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'projects_ht_quotes_pk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'idx_proj_quote_proj',
            'type' => 'index',
            'fields' => array(
                'project_id',
            ),
        ),
        array(
            'name' => 'idx_proj_quote_quote',
            'type' => 'index',
            'fields' => array(
                'quote_id',
            ),
        ),
        array(
            'name' => 'projects_ht_quotes_alt',
            'type' => 'alternate_key',
            'fields' => array(
                'project_id',
                'quote_id',
            ),
        ),
    ),
    'relationships' => array(
        'projects_ht_quotes' => array(
            'lhs_module' => 'Project',
            'lhs_table' => 'project',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_SS_Quotes',
            'rhs_table' => 'ht_ss_quotes',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'projects_ht_quotes',
            'join_key_lhs' => 'project_id',
            'join_key_rhs' => 'quote_id',
        ),
    ),
);

$dictionary['contracts_ht_quotes'] = array(
    'table' => 'contracts_ht_quotes',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'quote_id' => array(
            'name' => 'quote_id',
            'type' => 'id',
        ),
        'contract_id' => array(
            'name' => 'contract_id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => false,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'contracts_quot_pk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'contracts_quot_alt',
            'type' => 'alternate_key',
            'fields' => array(
                'contract_id',
                'quote_id',
            ),
        ),
    ),
    'relationships' => array(
        'contracts_ht_quotes' => array(
            'lhs_module' => 'Contracts',
            'lhs_table' => 'contracts',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_SS_Quotes',
            'rhs_table' => 'ht_ss_quotes',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'contracts_ht_quotes',
            'join_key_lhs' => 'contract_id',
            'join_key_rhs' => 'quote_id',
        ),
    ),
);

$dictionary['documents_ht_quotes'] = array(
    'true_relationship_type' => 'many-to-many',
    'relationships' => array(
        'documents_ht_quotes' => array(
            'lhs_module' => 'Documents',
            'lhs_table' => 'documents',
            'lhs_key' => 'id',
            'rhs_module' => 'HT_SS_Quotes',
            'rhs_table' => 'ht_ss_quotes',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'documents_ht_quotes',
            'join_key_lhs' => 'document_id',
            'join_key_rhs' => 'quote_id',
        ),
    ),
    'table' => 'documents_ht_quotes',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'date_modified' => array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
            'required' => true,
        ),
        'document_id' => array(
            'name' => 'document_id',
            'type' => 'id',
        ),
        'quote_id' => array(
            'name' => 'quote_id',
            'type' => 'id',
        ),
    ),
    'indices' => array(
        array(
            'name' => 'documents_ht_quotesspk',
            'type' => 'primary',
            'fields' => array(
                'id',
            ),
        ),
        array(
            'name' => 'documents_ht_quotes_quote_id',
            'type' => 'alternate_key',
            'fields' => array(
                'quote_id',
                'document_id',
            ),
        ),
        array(
            'name' => 'documents_ht_quotes_document_id',
            'type' => 'alternate_key',
            'fields' => array(
                'document_id',
                'quote_id',
            ),
        ),
    ),
);
