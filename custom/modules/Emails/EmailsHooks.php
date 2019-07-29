<?php

class EmailsHooks
{
	function afterSave($bean, $event, $arguments) {
		global $sugar_config;

		if ($bean->type == 'inbound') {
			$reportNumber = $this->getReportNumber($bean->name);
			if ($reportNumber != null) {
				$report = BeanFactory::getBean('LR_Lab_Reports');
				$report->retrieve_by_string_fields(array(
					'sample_id_number_c' => $reportNumber
				));

				if (empty($report->id)) {
					$report = $this->createAndEmailReport($bean);
				}

				$note = BeanFactory::getBean('Notes');
				$note->retrieve_by_string_fields(array(
					'email_id' => $bean->id,
					'email_type' => 'Emails'
				));

				if (!empty($note->id)) {
					$report->filename = $note->filename;
					$report->file_ext = $note->file_ext;
					$report->file_mime_type = $note->file_mime_type;

					$report->save();

					// copy file in upload
					copy("{$sugar_config['upload_dir']}/{$note->id}", "{$sugar_config['upload_dir']}/{$report->id}");
				}
			}
		}
	}

	private function createAndEmailReport($bean) {
		global $sugar_config;

		// creating report
		$report = BeanFactory::getBean('LR_Lab_Reports');
		$report->document_name = $bean->name;
		$report->assigned_user_id = '1';
		$report->save();

		//emailing the report
		try {
            $mailer = MailerFactory::getSystemDefaultMailer();

            // set the subject of the email
            $body =<<<TXT
Hi,

We are unable to find the record of the "{$report->name}" in our system. We have created a new record. 
Please access the report via: {$sugar_config['site_url']}#LR_Lab_Reports/{$report->id} to link this report Manually.

Thank You
TXT;
            $mailer->setTextBody($body);
            $mailer->setSubject('Unable to find Lab Report');

            // reuse the mailer, but process one send per recipient
            $mailer->clearRecipients();
            $mailer->addRecipientsTo(new EmailIdentity(
            	$sugar_config['lab_report_email']['email'],
            	$sugar_config['lab_report_email']['name']
            ));

            $mailer->send();
        } catch (MailerException $me) {
        	$GLOBALS['log']->fatal("Email Sending Issue: " . $me->getMessage());
        }

		return $report;
	}

	private function getReportNumber($emailSubject) {
		global $sugar_config;

		$exMacro = explode('%1', $sugar_config['lab_report_macro']);
		$open = $exMacro[0];
		$close = $exMacro[1];

		if($sub = stristr($emailSubject, $open)) {
			$sub2 = str_replace($open, '', $sub);
			$sub3 = substr($sub2, 0, strpos($sub2, $close));

            if (!empty(trim($sub3))) {
                return $sub3;
            }
        }

        return null;
    }
}
