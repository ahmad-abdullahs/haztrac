<?php

class LabReportsBeforeSave {
    public function generateUniqueLabNumber($bean, $event, $arguments) {
        if(!isset($bean->sample_id_number_c) || empty($bean->sample_id_number_c)){
			$six_digit_random_number = mt_rand(100000, 999999);
			$bean->sample_id_number_c = "L-".$six_digit_random_number;
		}
    }
}