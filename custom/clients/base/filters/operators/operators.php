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

$viewdefs['base']['filter']['operators'] = array(
    'multienum' => array(
        '$contains' => 'LBL_OPERATOR_CONTAINS',
        '$not_contains' => 'LBL_OPERATOR_NOT_CONTAINS',
    ),
    'enum' => array(
        '$in' => 'LBL_OPERATOR_CONTAINS',
        '$not_in' => 'LBL_OPERATOR_NOT_CONTAINS',
        '$empty' => 'LBL_OPERATOR_EMPTY',
        '$not_empty' => 'LBL_OPERATOR_NOT_EMPTY',
    ),
    'varchar' => array(
        '$contains' => 'LBL_OPERATOR_CSTM_CONTAINS',
        '$equals' => 'LBL_OPERATOR_MATCHES',
        '$starts' => 'LBL_OPERATOR_STARTS_WITH',
    ),
    'name' => array(
        '$contains' => 'LBL_OPERATOR_CSTM_CONTAINS',
        '$equals' => 'LBL_OPERATOR_MATCHES',
        '$starts' => 'LBL_OPERATOR_STARTS_WITH',
    ),
    'email' => array(
        '$contains' => 'LBL_OPERATOR_CSTM_CONTAINS',
        '$equals' => 'LBL_OPERATOR_MATCHES',
        '$starts' => 'LBL_OPERATOR_STARTS_WITH',
    ),
    'text' => array(
        '$contains' => 'LBL_OPERATOR_CSTM_CONTAINS',
        '$equals' => 'LBL_OPERATOR_MATCHES',
        '$starts' => 'LBL_OPERATOR_STARTS_WITH',
    ),
    'textarea' => array(
        '$contains' => 'LBL_OPERATOR_CSTM_CONTAINS',
        '$equals' => 'LBL_OPERATOR_MATCHES',
        '$starts' => 'LBL_OPERATOR_STARTS_WITH',
    ),
    'currency' => array(
        '$equals' => 'LBL_OPERATOR_EQUALS',
        '$not_equals' => 'LBL_OPERATOR_NOT_EQUALS',
        '$gt' => 'LBL_OPERATOR_GREATER_THAN',
        '$lt' => 'LBL_OPERATOR_LESS_THAN',
        '$gte' => 'LBL_OPERATOR_GREATER_THAN_OR_EQUALS',
        '$lte' => 'LBL_OPERATOR_LESS_THAN_OR_EQUALS',
        '$between' => 'LBL_OPERATOR_BETWEEN',
    ),
    'int' => array(
        '$equals' => 'LBL_OPERATOR_EQUALS',
        '$not_equals' => 'LBL_OPERATOR_NOT_EQUALS',
        '$in' => 'LBL_OPERATOR_CONTAINS',
        '$gt' => 'LBL_OPERATOR_GREATER_THAN',
        '$lt' => 'LBL_OPERATOR_LESS_THAN',
        '$gte' => 'LBL_OPERATOR_GREATER_THAN_OR_EQUALS',
        '$lte' => 'LBL_OPERATOR_LESS_THAN_OR_EQUALS',
        '$between' => 'LBL_OPERATOR_BETWEEN',
    ),
    'double' => array(
        '$equals' => 'LBL_OPERATOR_EQUALS',
        '$not_equals' => 'LBL_OPERATOR_NOT_EQUALS',
        '$gt' => 'LBL_OPERATOR_GREATER_THAN',
        '$lt' => 'LBL_OPERATOR_LESS_THAN',
        '$gte' => 'LBL_OPERATOR_GREATER_THAN_OR_EQUALS',
        '$lte' => 'LBL_OPERATOR_LESS_THAN_OR_EQUALS',
        '$between' => 'LBL_OPERATOR_BETWEEN',
    ),
    'float' => array(
        '$equals' => 'LBL_OPERATOR_EQUALS',
        '$not_equals' => 'LBL_OPERATOR_NOT_EQUALS',
        '$gt' => 'LBL_OPERATOR_GREATER_THAN',
        '$lt' => 'LBL_OPERATOR_LESS_THAN',
        '$gte' => 'LBL_OPERATOR_GREATER_THAN_OR_EQUALS',
        '$lte' => 'LBL_OPERATOR_LESS_THAN_OR_EQUALS',
        '$between' => 'LBL_OPERATOR_BETWEEN',
    ),
    'decimal' => array(
        '$equals' => 'LBL_OPERATOR_EQUALS',
        '$not_equals' => 'LBL_OPERATOR_NOT_EQUALS',
        '$gt' => 'LBL_OPERATOR_GREATER_THAN',
        '$lt' => 'LBL_OPERATOR_LESS_THAN',
        '$gte' => 'LBL_OPERATOR_GREATER_THAN_OR_EQUALS',
        '$lte' => 'LBL_OPERATOR_LESS_THAN_OR_EQUALS',
        '$between' => 'LBL_OPERATOR_BETWEEN',
    ),
    'date' => array(
        '$equals' => 'LBL_OPERATOR_EQUALS',
        '$lt' => 'LBL_OPERATOR_BEFORE',
        '$gt' => 'LBL_OPERATOR_AFTER',
        'yesterday' => 'LBL_OPERATOR_YESTERDAY',
        'today' => 'LBL_OPERATOR_TODAY',
        'tomorrow' => 'LBL_OPERATOR_TOMORROW',
        'last_7_days' => 'LBL_OPERATOR_LAST_7_DAYS',
        'next_7_days' => 'LBL_OPERATOR_NEXT_7_DAYS',
        'last_30_days' => 'LBL_OPERATOR_LAST_30_DAYS',
        'next_30_days' => 'LBL_OPERATOR_NEXT_30_DAYS',
        'last_45_days' => 'LBL_OPERATOR_LAST_45_DAYS',
        'next_45_days' => 'LBL_OPERATOR_NEXT_45_DAYS',
        'last_60_days' => 'LBL_OPERATOR_LAST_60_DAYS',
        'next_60_days' => 'LBL_OPERATOR_NEXT_60_DAYS',
        'last_month' => 'LBL_OPERATOR_LAST_MONTH',
        'this_month' => 'LBL_OPERATOR_THIS_MONTH',
        'next_month' => 'LBL_OPERATOR_NEXT_MONTH',
        'last_year' => 'LBL_OPERATOR_LAST_YEAR',
        'this_year' => 'LBL_OPERATOR_THIS_YEAR',
        'next_year' => 'LBL_OPERATOR_NEXT_YEAR',
        '$dateBetween' => 'LBL_OPERATOR_BETWEEN',
    ),
    'datetime' => array(
        '$starts' => 'LBL_OPERATOR_EQUALS',
        '$lte' => 'LBL_OPERATOR_BEFORE',
        '$gte' => 'LBL_OPERATOR_AFTER',
        'yesterday' => 'LBL_OPERATOR_YESTERDAY',
        'today' => 'LBL_OPERATOR_TODAY',
        'tomorrow' => 'LBL_OPERATOR_TOMORROW',
        'last_7_days' => 'LBL_OPERATOR_LAST_7_DAYS',
        'next_7_days' => 'LBL_OPERATOR_NEXT_7_DAYS',
        'last_30_days' => 'LBL_OPERATOR_LAST_30_DAYS',
        'next_30_days' => 'LBL_OPERATOR_NEXT_30_DAYS',
        'last_45_days' => 'LBL_OPERATOR_LAST_45_DAYS',
        'next_45_days' => 'LBL_OPERATOR_NEXT_45_DAYS',
        'last_60_days' => 'LBL_OPERATOR_LAST_60_DAYS',
        'next_60_days' => 'LBL_OPERATOR_NEXT_60_DAYS',
        'last_month' => 'LBL_OPERATOR_LAST_MONTH',
        'this_month' => 'LBL_OPERATOR_THIS_MONTH',
        'next_month' => 'LBL_OPERATOR_NEXT_MONTH',
        'last_year' => 'LBL_OPERATOR_LAST_YEAR',
        'this_year' => 'LBL_OPERATOR_THIS_YEAR',
        'next_year' => 'LBL_OPERATOR_NEXT_YEAR',
        '$dateBetween' => 'LBL_OPERATOR_BETWEEN',
    ),
    'datetimecombo' => array(
        '$starts' => 'LBL_OPERATOR_EQUALS',
        '$lte' => 'LBL_OPERATOR_BEFORE',
        '$gte' => 'LBL_OPERATOR_AFTER',
        'yesterday' => 'LBL_OPERATOR_YESTERDAY',
        'today' => 'LBL_OPERATOR_TODAY',
        'tomorrow' => 'LBL_OPERATOR_TOMORROW',
        'last_7_days' => 'LBL_OPERATOR_LAST_7_DAYS',
        'next_7_days' => 'LBL_OPERATOR_NEXT_7_DAYS',
        'last_30_days' => 'LBL_OPERATOR_LAST_30_DAYS',
        'next_30_days' => 'LBL_OPERATOR_NEXT_30_DAYS',
        'last_45_days' => 'LBL_OPERATOR_LAST_45_DAYS',
        'next_45_days' => 'LBL_OPERATOR_NEXT_45_DAYS',
        'last_60_days' => 'LBL_OPERATOR_LAST_60_DAYS',
        'next_60_days' => 'LBL_OPERATOR_NEXT_60_DAYS',
        'last_month' => 'LBL_OPERATOR_LAST_MONTH',
        'this_month' => 'LBL_OPERATOR_THIS_MONTH',
        'next_month' => 'LBL_OPERATOR_NEXT_MONTH',
        'last_year' => 'LBL_OPERATOR_LAST_YEAR',
        'this_year' => 'LBL_OPERATOR_THIS_YEAR',
        'next_year' => 'LBL_OPERATOR_NEXT_YEAR',
        '$dateBetween' => 'LBL_OPERATOR_BETWEEN',
    ),
    'bool' => array(
        '$equals' => 'LBL_OPERATOR_IS'
    ),
    'relate' => array(
        '$in' => 'LBL_OPERATOR_CONTAINS',
        '$not_in' => 'LBL_OPERATOR_NOT_CONTAINS',
    ),
    'teamset' => array(
        '$in' => 'LBL_OPERATOR_CONTAINS',
        '$not_in' => 'LBL_OPERATOR_NOT_CONTAINS',
    ),
    'phone' => array(
        '$contains' => 'LBL_OPERATOR_CSTM_CONTAINS',
        '$starts' => 'LBL_OPERATOR_STARTS_WITH',
        '$equals' => 'LBL_OPERATOR_IS',
    ),
    'radioenum' => array(
        '$equals' => 'LBL_OPERATOR_IS',
        '$not_equals' => 'LBL_OPERATOR_IS_NOT',
    ),
    'parent' => array(
        '$equals' => 'LBL_OPERATOR_IS',
    ),
    'tag' => array(
        '$in' => 'LBL_OPERATOR_CONTAINS',
        '$not_in' => 'LBL_OPERATOR_NOT_CONTAINS',
        '$empty' => 'LBL_OPERATOR_EMPTY',
        '$not_empty' => 'LBL_OPERATOR_NOT_EMPTY',
    ),
);
