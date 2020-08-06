<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dictionary["competitor_cost"]["fields"]["description_competitor"] = array(
    'name' => 'description_competitor',
    'vname' => 'LBL_DESCRIPTION',
    'type' => 'text',
    'comment' => 'Full text of the note',
    'full_text_search' =>
    array(
        'enabled' => true,
        'searchable' => true,
        'boost' => 0.5,
    ),
    'rows' => 6,
    'cols' => 80,
    'duplicate_on_record_copy' => 'always',
);
