<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * THIS CLASS IS GENERATED BY MODULE BUILDER
 * PLEASE DO NOT CHANGE THIS CLASS
 * PLACE ANY CUSTOMIZATIONS IN PNL_Permits_Licenses
 */

require_once 'include/SugarObjects/templates/file/File.php';

class PNL_Permits_Licenses_sugar extends File {
    public $new_schema = true;
    public $module_dir = 'PNL_Permits_Licenses';
    public $object_name = 'PNL_Permits_Licenses';
    public $table_name = 'pnl_permits_licenses';
    public $importable = false;
    public $team_id;
    public $team_set_id;
    public $acl_team_set_id;
    public $team_count;
    public $team_name;
    public $acl_team_names;
    public $team_link;
    public $team_count_link;
    public $teams;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $tag;
    public $tag_link;
    public $id;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $activities;
    public $following;
    public $following_link;
    public $my_favorite;
    public $favorite_link;
    public $commentlog;
    public $commentlog_link;
    public $locked_fields;
    public $locked_fields_link;
    public $document_name;
    public $filename;
    public $file_ext;
    public $file_mime_type;
    public $uploadfile;
    public $active_date;
    public $exp_date;
    public $category_id;
    public $subcategory_id;
    public $status_id;
    public $status;
    
    public function bean_implements($interface){
        switch($interface){
            case 'ACL': return true;
        }
        return false;
    }
    
}