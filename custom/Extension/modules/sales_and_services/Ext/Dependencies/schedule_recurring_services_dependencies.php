<?php

// *** General Dependencies ***
$dependencies['sales_and_services']['schedule_recurring_services_timings_panel_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c', 'end_date_option_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'recurring_end_date_c',
                'label' => 'recurring_end_date_c_label',
                'value' => 'and(equal($end_date_option_c, "End date"), equal($recurring_sale_c, true))',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'occurrences_c',
                'label' => 'occurrences_c_label',
                'value' => 'and(equal($end_date_option_c, "End after occurrences"), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

// *** Occurance Dependencies ***
$dependencies['sales_and_services']['schedule_recurring_services_occurs_c_field_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c', 'occurs_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'daily_repeats_on_c',
                'label' => 'daily_repeats_on_c_label',
                'value' => 'and(equal($occurs_c, "Daily"), equal($recurring_sale_c, true))',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'weekly_repeats_on_c',
                'label' => 'weekly_repeats_on_c_label',
                'value' => 'and(equal($occurs_c, "Weekly"), equal($recurring_sale_c, true))',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'monthly_repeats_on_c',
                'label' => 'monthly_repeats_on_c_label',
                'value' => 'and(equal($occurs_c, "Monthly"), equal($recurring_sale_c, true))',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'yearly_repeat_every_year_c',
                'label' => 'yearly_repeat_every_year_c_label',
                'value' => 'and(equal($occurs_c, "Yearly"), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

// *** Daily Dependencies ***
$dependencies['sales_and_services']['daily_repeat_on_one_panel_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c', 'daily_repeats_on_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'daily_after_no_of_days_c',
                'label' => 'daily_after_no_of_days_c_label',
                'value' => 'and(equal($daily_repeats_on_c, "Every next no of day"), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

// *** Weekly Dependencies ***
$dependencies['sales_and_services']['weekly_repeat_on_one_panel_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c', 'weekly_repeats_on_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'weekly_after_no_of_weeks_c',
                'label' => 'weekly_after_no_of_weeks_c_label',
                'value' => 'and(equal($weekly_repeats_on_c, "Every next no of week"), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

// *** Monthly Dependencies ***
$dependencies['sales_and_services']['monthly_repeat_on_one_panel_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c', 'monthly_repeats_on_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'monthly_after_no_of_months_c',
                'label' => 'monthly_after_no_of_months_c_label',
                'value' => 'and(equal($monthly_repeats_on_c, "Every next no of month"), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

$dependencies['sales_and_services']['monthly_repeat_on_two_panel_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c', 'monthly_on_the_specific_day_of_month_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'monthly_specific_day_of_month_c',
                'label' => 'monthly_specific_day_of_month_c_label',
                'value' => 'and(equal($monthly_on_the_specific_day_of_month_c, "On the specific day of month"), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

$dependencies['sales_and_services']['monthly_repeat_on_three_panel_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c', 'monthly_by_day_of_week_on_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'monthly_week_no_c',
                'label' => 'monthly_week_no_c_label',
                'value' => 'and(equal($monthly_by_day_of_week_on_c, "On"), equal($recurring_sale_c, true))',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'monthly_month_day_c',
                'label' => 'monthly_month_day_c_label',
                'value' => 'and(equal($monthly_by_day_of_week_on_c, "On"), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

// *** Yearly Dependencies ***
$dependencies['sales_and_services']['yearly_repeat_on_two_panel_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c', 'yearly_on_specific_date_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'yearly_on_specific_month_c',
                'label' => 'yearly_on_specific_month_c_label',
                'value' => 'and(equal($yearly_on_specific_date_c, "On"), equal($recurring_sale_c, true))',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'yearly_date_of_month_c',
                'label' => 'yearly_date_of_month_c_label',
                'value' => 'and(equal($yearly_on_specific_date_c, "On"), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

$dependencies['sales_and_services']['yearly_repeat_on_three_panel_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c', 'yearly_by_day_of_the_week_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'yearly_week_no_c',
                'label' => 'yearly_week_no_c_label',
                'value' => 'and(equal($yearly_by_day_of_the_week_c, "On"), equal($recurring_sale_c, true))',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'yearly_by_day_of_the_week_li_c',
                'label' => 'yearly_by_day_of_the_week_li_c_label',
                'value' => 'and(equal($yearly_by_day_of_the_week_c, "On"), equal($recurring_sale_c, true))',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'yearly_by_day_of_week_month_c',
                'label' => 'yearly_by_day_of_week_month_c_label',
                'value' => 'and(equal($yearly_by_day_of_the_week_c, "On"), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

//----------------------------------------------------
// ********** Business Logic Dependencies ************
//----------------------------------------------------

$dependencies['sales_and_services']['schedule_recurring_services_recurring_start_date_c_field_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_sale_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'recurring_start_date_c',
                'label' => 'recurring_start_date_c_label',
                'value' => 'equal($recurring_sale_c, true)',
            ),
        ),
    ),
);

$dependencies['sales_and_services']['schedule_recurring_services_end_date_option_c_field_dep'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('recurring_start_date_c', 'recurring_sale_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'end_date_option_c',
                'label' => 'end_date_option_c_label',
                'value' => 'and(not(equal($recurring_start_date_c, "")), equal($recurring_sale_c, true))',
            ),
        ),
    ),
);

$dependencies['sales_and_services']['schedule_recurring_services_occurs_c_field_dep_2'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('end_date_option_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'occurs_c',
                'label' => 'occurs_c_label',
                'value' => 'equal($end_date_option_c, "No end date")',
            ),
        ),
    ),
);
