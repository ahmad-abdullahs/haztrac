<?php

class AccountsBeforeSave {

    public function generateUniqueAccountNumber($bean, $event, $arguments) {
        if (!isset($bean->account_number_c) || empty($bean->account_number_c)) {
            $seven_digit_random_number = mt_rand(1000000, 9999999);
            $bean->sample_id_number_c = $seven_digit_random_number;
        }

        // Only assign account number when the record is created.
        if (!$arguments['isUpdate']) {
            $sq = new \SugarQuery();
            $sq->from(BeanFactory::newBean('Accounts'), ['team_security' => false]);
            $sq->select->fieldRaw('MAX(account_number_c)', 'account_number_c');

            $account_number_c = $sq->getOne();
            $max_id = '';
            if (empty($account_number_c)) {
                $max_id = 'A17940';
            } else {
                $max_id = 'A' . (substr($account_number_c, 1) + 1);
            }
            $bean->account_number_c = $max_id;
        }
    }

}
