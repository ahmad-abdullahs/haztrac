<?php

class AccountsBeforeSave {
    public function generateUniqueAccountNumber($bean, $event, $arguments) {
        if(!isset($bean->account_number_c) || empty($bean->account_number_c)){
			$seven_digit_random_number = mt_rand(1000000, 9999999);
			$bean->sample_id_number_c = $seven_digit_random_number;
		}
    }
}