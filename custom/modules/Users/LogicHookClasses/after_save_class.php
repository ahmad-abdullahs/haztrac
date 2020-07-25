<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class after_save_class {

    function after_save_method($bean, $event, $arguments) {
        // If its a New record and the user is not admin
        // When a new user is created automatically 
        // add the user to the Non-admin role to avoid "HR Management" modules access.
        if (!isset($bean->fetched_row['id']) && $bean->UserType == 'RegularUser') {
            $role = BeanFactory::getBean('ACLRoles');
            $role->retrieve_by_string_fields(array(
                'name' => 'Non Admin Users',
            ));

            // Add user to role, if he/she is not already a member
            if (!$bean->check_role_membership($role->name)) {
                $role->set_relationship('acl_roles_users', array(
                    'role_id' => $role->id,
                    'user_id' => $bean->id), false
                );
            }
        }
    }

}
