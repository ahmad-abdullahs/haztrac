<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_save_class {

    function before_save_method($bean, $event, $arguments) {
        // fixAmp
        $bean->header_html = str_replace('&amp;', '&', $bean->header_html);
        $bean->footer_html = str_replace('&amp;', '&', $bean->footer_html);
    }

}
