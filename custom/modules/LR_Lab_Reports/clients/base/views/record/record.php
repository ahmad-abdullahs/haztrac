<?php
$viewdefs['LR_Lab_Reports'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
            'events' => 
            array (
              'click' => 'button:cancel_button:click',
            ),
          ),
          1 => 
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:edit_button:click',
                'name' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'shareaction',
                'name' => 'share',
                'label' => 'LBL_RECORD_SHARE_BUTTON',
                'acl_action' => 'view',
              ),
              2 => 
              array (
                'type' => 'pdfaction',
                'name' => 'download-pdf',
                'label' => 'LBL_PDF_VIEW',
                'action' => 'download',
                'acl_action' => 'view',
              ),
              3 => 
              array (
                'type' => 'pdfaction',
                'name' => 'email-pdf',
                'label' => 'LBL_PDF_EMAIL',
                'action' => 'email',
              ),
              4 => 
              array (
                'type' => 'divider',
              ),
              5 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              6 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'LR_Lab_Reports',
                'acl_action' => 'create',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              8 => 
              array (
                'type' => 'divider',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
              10 => 
              array (
                'type' => 'divider',
              ),
              11 => 
              array (
                'type' => 'report-preview',
                'label' => 'LBL_REPORT_PREVIEW',
                'acl_action' => 'view',
              ),
            ),
          ),
          3 => 
          array (
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
          ),
        ),
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'label' => 'LBL_RECORD_HEADER',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'width' => 42,
                'height' => 42,
                'dismiss_label' => true,
//                'readonly' => true,
              ),
              1 => 'document_name',
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              3 => 
              array (
                'name' => 'follow',
                'label' => 'LBL_FOLLOW',
                'type' => 'follow',
                'readonly' => true,
                'dismiss_label' => true,
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'project_name_c',
                'label' => 'LBL_PROJECT_NAME',
                'tabindex' => '2',
              ),
              1 => 
              array (
                'name' => 'status_id',
                'label' => 'LBL_DOC_STATUS',
                'tabindex' => '3',
              ),
              2 => 
              array (
                'name' => 'commodity_c',
                'label' => 'LBL_COMMODITY',
                'tabindex' => '4',
              ),
              3 => 
              array (
                'name' => 'sample_id_number_c',
                'label' => 'LBL_SAMPLE_ID_NUMBER',
                'tabindex' => '30',
              ),
              4 => 
              array (
                'name' => 'project_lr_lab_reports_1_name',
              ),
              5 => 
              array (
              ),
              6 => 
              array (
                'name' => 'object_number_c',
                'label' => 'LBL_OBJECT_NUMBER',
                'tabindex' => '5',
              ),
              7 => 
              array (
                'name' => 'lab_ref_number_c',
                'label' => 'LBL_LAB_REF_NUMBER',
                'tabindex' => '9',
              ),
              8 => 
              array (
                'name' => 'manifests',
                'type' => 'manifests',
                'label' => 'LBL_MANIFESTS',
                'dismiss_label' => true,
                'tabindex' => '10',
              ),
              9 => 
              array (
                'name' => 'other_ref_number_c',
                'label' => 'LBL_OTHER_REF_NUMBER',
                'tabindex' => '11',
              ),
              10 => 
              array (
                'name' => 'sample_date_time_c',
                'label' => 'LBL_SAMPLE_DATE_TIME',
                'tabindex' => '6',
              ),
              11 => 
              array (
                'name' => 'sent_via_c',
                'label' => 'LBL_SENT_VIA',
                'tabindex' => '7',
              ),
              12 => 
              array (
                'name' => 'v_vendors_lr_lab_reports_1_name',
                'tabindex' => '8',
              ),
              13 => 
              array (
                'name' => 'uploadfile',
                'populate_list' => 
                array (
                  0 => 'document_name',
                ),
              ),
              14 => 
              array (
                'name' => 'analysis_templates_c',
                'label' => 'LBL_ANALYSIS_TEMPLATES',
                'tabindex' => '16',
              ),
              15 => 
              array (
                'name' => 'analysis_date_c',
                'label' => 'LBL_ANALYSIS_DATE',
                'tabindex' => '17',
              ),
              16 => 
              array (
                'name' => 'accounts_lr_lab_reports_1_name',
                'tabindex' => '9',
              ),
              17 => 
              array (
                'name' => 'accounts_lr_lab_reports_2_name',
                'tabindex' => '10',
              ),
              18 => 
              array (
                'name' => 'special_instructions_c',
                'studio' => 'visible',
                'label' => 'LBL_SPECIAL_INSTRUCTIONS',
                'tabindex' => '11',
              ),
              19 => 
              array (
                'name' => 'instructions_c',
                'studio' => 'visible',
                'label' => 'LBL_INSTRUCTIONS',
                'tabindex' => '12',
              ),
              20 => 
              array (
                'name' => 'assigned_user_name',
                'tabindex' => '13',
              ),
              21 => 
              array (
                'name' => 'team_name',
                'tabindex' => '14',
              ),
              22 => 
              array (
                'name' => 'description',
                'tabindex' => '15',
                'span' => 12,
              ),
              23 => 
              array (
                'name' => 'tag',
                'tabindex' => '27',
                'span' => 12,
              ),
              24 => 
              array (
                'name' => 'date_modified_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_MODIFIED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_modified',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'modified_by_name',
                  ),
                ),
              ),
              25 => 
              array (
                'name' => 'date_entered_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_ENTERED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_entered',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'created_by_name',
                  ),
                ),
              ),
              26 => 
              array (
                'name' => 'wpm_waste_profile_module_lr_lab_reports_name',
              ),
              27 => 
              array (
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'lab_report_preview_c',
                'label' => 'LBL_LAB_REPORT_PREVIEW',
                'span' => 12,
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL3',
            'label' => 'LBL_RECORDVIEW_PANEL3',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'coa_api_gravity_sixty_c',
                'label' => 'LBL_COA_API_GRAVITY_SIXTY',
              ),
              1 => 
              array (
                'name' => 'coa_aniline_point_f_c',
                'label' => 'LBL_COA_ANILINE_POINT_F',
              ),
              2 => 
              array (
                'name' => 'coa_ash_wt_c',
                'label' => 'LBL_COA_ASH_WT',
              ),
              3 => 
              array (
                'name' => 'coa_asphaltenes_wt_c',
                'label' => 'LBL_COA_ASPHALTENES_WT',
              ),
              4 => 
              array (
                'name' => 'coa_organic_chlorides_ppm_c',
                'label' => 'LBL_COA_ORGANIC_CHLORIDES_PPM',
              ),
              5 => 
              array (
                'name' => 'coa_inorganic_chlorides_c',
                'label' => 'LBL_COA_INORGANIC_CHLORIDES',
              ),
              6 => 
              array (
                'name' => 'coa_color_astm_c',
                'label' => 'LBL_COA_COLOR_ASTM',
              ),
              7 => 
              array (
                'name' => 'coa_density_c',
                'label' => 'LBL_COA_DENSITY',
              ),
              8 => 
              array (
                'name' => 'coa_density_lb_gal_c',
                'label' => 'LBL_COA_DENSITY_LB_GAL',
              ),
              9 => 
              array (
                'name' => 'coa_distillation_c',
                'label' => 'LBL_COA_DISTILLATION',
              ),
              10 => 
              array (
                'name' => 'coa_flash_point_pmcc_f_c',
                'label' => 'LBL_COA_FLASH_POINT_PMCC_F',
              ),
              11 => 
              array (
                'name' => 'coa_flash_point_coc_f_c',
                'label' => 'LBL_COA_FLASH_POINT_COC_F',
              ),
              12 => 
              array (
                'name' => 'coa_fame_content_wt_c',
                'label' => 'LBL_COA_FAME_CONTENT_WT',
              ),
              13 => 
              array (
                'name' => 'coa_hydrogen_sulfide_ppm_c',
                'label' => 'LBL_COA_HYDROGEN_SULFIDE_PPM',
              ),
              14 => 
              array (
                'name' => 'coa_total_halogens_ppm_c',
                'label' => 'LBL_COA_TOTAL_HALOGENS_PPM',
              ),
              15 => 
              array (
                'name' => 'coa_compatibility_w6_c',
                'label' => 'LBL_COA_COMPATIBILITY_W6',
              ),
              16 => 
              array (
                'name' => 'coa_heat_of_combustion_gal_c',
                'label' => 'LBL_COA_HEAT_OF_COMBUSTION_GAL',
              ),
              17 => 
              array (
                'name' => 'coa_heat_of_combustion_lb_c',
                'label' => 'LBL_COA_HEAT_OF_COMBUSTION_LB',
              ),
              18 => 
              array (
                'name' => 'coa_ph_c',
                'label' => 'LBL_COA_PH',
              ),
              19 => 
              array (
                'name' => 'coa_pcb_c',
                'label' => 'LBL_COA_PCB',
              ),
              20 => 
              array (
                'name' => 'pour_point_f_c',
                'label' => 'LBL_POUR_POINT_F',
              ),
              21 => 
              array (
                'name' => 'coa_mercaptan_sulfur_wt_c',
                'label' => 'LBL_COA_MERCAPTAN_SULFUR_WT',
              ),
              22 => 
              array (
                'name' => 'coa_reid_vapor_pressure_psi_c',
                'label' => 'LBL_COA_REID_VAPOR_PRESSURE_PSI',
              ),
              23 => 
              array (
                'name' => 'coa_true_vapor_pressure_60_c',
                'label' => 'LBL_COA_TRUE_VAPOR_PRESSURE_60',
              ),
              24 => 
              array (
                'name' => 'coa_sediment_by_extraction_c',
                'label' => 'LBL_COA_SEDIMENT_BY_EXTRACTION',
              ),
              25 => 
              array (
                'name' => 'coa_styrene_c',
                'label' => 'LBL_COA_STYRENE',
              ),
              26 => 
              array (
                'name' => 'coa_sulfur_wt_c',
                'label' => 'LBL_COA_SULFUR_WT',
              ),
              27 => 
              array (
                'name' => 'coa_total_acid_number_c',
                'label' => 'LBL_COA_TOTAL_ACID_NUMBER',
              ),
              28 => 
              array (
                'name' => 'coa_water_by_distillation_c',
                'label' => 'LBL_COA_WATER_BY_DISTILLATION',
              ),
              29 => 
              array (
                'name' => 'coa_water_by_karlfisher_c',
                'label' => 'LBL_COA_WATER_BY_KARLFISHER',
              ),
              30 => 
              array (
                'name' => 'coa_viscosity_122f_cst_c',
                'label' => 'LBL_COA_VISCOSITY_122F_CST',
              ),
              31 => 
              array (
              ),
            ),
          ),
          4 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL4',
            'label' => 'LBL_RECORDVIEW_PANEL4',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'analysis_metals_c',
                'label' => 'LBL_ANALYSIS_METALS',
              ),
              1 => 
              array (
                'name' => 'metal_aluminum_c',
                'label' => 'LBL_METAL_ALUMINUM',
              ),
              2 => 
              array (
                'name' => 'metal_arsenic_c',
                'label' => 'LBL_METAL_ARSENIC',
              ),
              3 => 
              array (
                'name' => 'metal_barium_c',
                'label' => 'LBL_METAL_BARIUM',
              ),
              4 => 
              array (
                'name' => 'metal_cadmium_c',
                'label' => 'LBL_METAL_CADMIUM',
              ),
              5 => 
              array (
                'name' => 'metal_calcium_c',
                'label' => 'LBL_METAL_CALCIUM',
              ),
              6 => 
              array (
                'name' => 'metal_chromium_c',
                'label' => 'LBL_METAL_CHROMIUM',
              ),
              7 => 
              array (
                'name' => 'metal_chromium_vi_c',
                'label' => 'LBL_METAL_CHROMIUM_VI',
              ),
              8 => 
              array (
                'name' => 'metal_copper_c',
                'label' => 'LBL_METAL_COPPER',
              ),
              9 => 
              array (
                'name' => 'metal_iron_c',
                'label' => 'LBL_METAL_IRON',
              ),
              10 => 
              array (
                'name' => 'metal_lead_c',
                'label' => 'LBL_METAL_LEAD',
              ),
              11 => 
              array (
                'name' => 'metal_mercury_c',
                'label' => 'LBL_METAL_MERCURY',
              ),
              12 => 
              array (
                'name' => 'metal_nickel_c',
                'label' => 'LBL_METAL_NICKEL',
              ),
              13 => 
              array (
                'name' => 'metal_phosphorus_c',
                'label' => 'LBL_METAL_PHOSPHORUS',
              ),
              14 => 
              array (
                'name' => 'metal_selenium_c',
                'label' => 'LBL_METAL_SELENIUM',
              ),
              15 => 
              array (
                'name' => 'metal_silicon_c',
                'label' => 'LBL_METAL_SILICON',
              ),
              16 => 
              array (
                'name' => 'metal_silver_c',
                'label' => 'LBL_METAL_SILVER',
              ),
              17 => 
              array (
                'name' => 'metal_sodium_c',
                'label' => 'LBL_METAL_SODIUM',
              ),
              18 => 
              array (
                'name' => 'metal_vanadium_c',
                'label' => 'LBL_METAL_VANADIUM',
              ),
              19 => 
              array (
                'name' => 'metal_zinc_c',
                'label' => 'LBL_METAL_ZINC',
              ),
              20 => 
              array (
                'span' => 12,
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => false,
        ),
      ),
    ),
  ),
);
