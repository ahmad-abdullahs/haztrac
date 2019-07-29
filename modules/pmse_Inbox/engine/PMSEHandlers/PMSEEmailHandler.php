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

require_once 'include/workflow/alert_utils.php';

use Sugarcrm\Sugarcrm\ProcessManager;

class PMSEEmailHandler
{
    /**
     * The Bean Handler object
     * @var PMSEBeanHandler
     */
    private $beanUtils;

    /**
     * The Administration bean
     * @var Administration
     */
    private $admin;

    /**
     * The Localization Bean
     * @deprecated Will be removed in a future release
     * @var PMSELogger
     */
    private $locale;

    /**
     * The Logger object
     * @var PMSELogger
     */
    private $logger;

    /**
     * The Related Module object
     * @var PMSERelatedModule
     */
    private $pmseRelatedModule;

    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $msg = 'The %s method will be removed in a future release and should no longer be used';
        LoggerManager::getLogger()->deprecated(sprintf($msg, __METHOD__));
    }

    /**
     * Get the PMSE Related Module object
     * @return PMSERelatedModule
     */
    protected function getRelatedModuleObject()
    {
        if (empty($this->pmseRelatedModule)) {
            $this->pmseRelatedModule = ProcessManager\Factory::getPMSEObject('PMSERelatedModule');
        }

        return $this->pmseRelatedModule;
    }

    /**
     * Gets the proper bean for processing
     * @param SugarBean $bean The target bean
     * @param string $module The related module name
     * @return SugarBean
     * @deprecated Will be removed in a future release
     */
    protected function getProperBean(SugarBean $bean, $module)
    {
        global $beanList;
        // Module in this case could be a relationship name, link name or
        // some other value
        if (!isset($beanList[$module])) {
            return $this->getRelatedModuleObject()->getRelatedModule($bean, $module);
        }
        // If the module is an actual module, send the original bean back
        return $bean;
    }

    /**
     * Gets the Bean Handler object
     * @return PMSEBeanHandler
     * @codeCoverageIgnore
     */
    public function getBeanUtils()
    {
        if (empty($this->beanUtils)) {
            $this->beanUtils = ProcessManager\Factory::getPMSEObject('PMSEBeanHandler');
        }

        return $this->beanUtils;
    }

    /**
     * Gets the localization object
     * @deprecated Will be removed in a future release
     * @return type
     * @codeCoverageIgnore
     */
    public function getLocale()
    {
        $msg = 'The %s method will be removed in a future release and should no longer be used';
        LoggerManager::getLogger()->deprecated(sprintf($msg, __METHOD__));

        global $locale;
        return $locale;
    }

    /**
     * Gets the PMSE Logger object
     * @return PMSELogger
     * @codeCoverageIgnore
     */
    public function getLogger()
    {
        if (empty($this->logger)) {
            $this->logger = PMSELogger::getInstance();
        }

        return $this->logger;
    }

    /**
     * Gets the administration object
     * @return Administration
     * @codeCoverageIgnore
     */
    public function getAdmin()
    {
        if (empty($this->admin)) {
            $this->admin = new Administration();
        }

        return $this->admin;
    }

    /**
     * Sets the administration object
     * @param Administration $admin
     */
    public function setAdmin(Administration $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Sets the bean handler object
     * @param PMSEBeanHandler $beanUtils
     * @codeCoverageIgnore
     */
    public function setBeanUtils(PMSEBeanHandler $beanUtils)
    {
        $this->beanUtils = $beanUtils;
    }

    /**
     * Sets the localization object
     * @deprecated Will be removed in a future release
     * @param type $locale
     * @codeCoverageIgnore
     */
    public function setLocale($locale)
    {
        $msg = 'The %s method will be removed in a future release and should no longer be used';
        LoggerManager::getLogger()->deprecated(sprintf($msg, __METHOD__));

        $this->locale = $locale;
    }

    /**
     * Sets the logger oject
     * @param PMSELogger $logger
     * @codeCoverageIgnore
     */
    public function setLogger(PMSELogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @param type $module
     * @param type $beanId
     * @return type
     * @codeCoverageIgnore
     */
    public function retrieveBean($module, $beanId = null)
    {
        return BeanFactory::getBean($module, $beanId);
    }

    /**
     * Get the email data stored in a json string and also processes and parses the variable data.
     * @param type $bean
     * @param type $json
     * @param type $flowData
     * @return \StdClass
     */
    public function processEmailsFromJson($bean, $json, $flowData)
    {
        $addresses = json_decode($json);
        $result = new stdClass();
        if (isset($addresses->to) && is_array($addresses->to)) {
            $result->to = $this->processEmailsAndExpand($bean, $addresses->to, $flowData);
        }
        if (isset($addresses->cc) && is_array($addresses->cc)) {
            $result->cc = $this->processEmailsAndExpand($bean, $addresses->cc, $flowData);
        }
        if (isset($addresses->bcc) && is_array($addresses->bcc)) {
            $result->bcc = $this->processEmailsAndExpand($bean, $addresses->bcc, $flowData);
        }

        return $result;
    }

    /**
     * Process the email and also obtains the bean data that needs to be inserted in the email object,
     * replacing the variables instances with the actual value.
     * @param type $bean
     * @param type $to
     * @param type $flowData
     * @return \StdClass
     * @codeCoverageIgnore
     */
    public function processEmailsAndExpand($bean, $to, $flowData)
    {
        $res = array();

        foreach ($to as $entry) {
            switch (strtoupper($entry->type)) {
                case 'USER':
                    $res = array_merge(
                        $res, $this->processUserEmails($bean, $entry, $flowData)
                    );
                    break;
                case 'TEAM':
                    $res = array_merge(
                        $res, $this->processTeamEmails($bean, $entry, $flowData)
                    );
                    break;
                case 'ROLE':
                    $res = array_merge(
                        $res, $this->processRoleEmails($bean, $entry, $flowData)
                    );
                    break;
                case 'RECIPIENT':
                    $res = array_merge(
                        $res, $this->processRecipientEmails($bean, $entry, $flowData)
                    );
                    break;
                case 'EMAIL':
                    $res = array_merge(
                        $res, $this->processDirectEmails($bean, $entry, $flowData)
                    );
                    break;
            }
        }

        return $res;
    }

    public function processUserEmails($bean, $entry, $flowData)
    {
        $res = $users = array();

        // Get all the related beans
        $beans = $this->getRelatedModuleObject()->getChainedRelationshipBeans([$bean], $entry);

        foreach ($beans as $b) {
            switch ($entry->value) {
                case 'last_modifier':
                    $users[] = $this->getLastModifier($b);
                    break;
                case 'record_creator':
                    $users[] = $this->getRecordCreator($b);
                    break;
                case 'is_assignee':
                    $users[] = $this->getCurrentAssignee($b);
                    break;
            }
        }
        foreach ($users as $user) {
            $res = array_merge($res, $this->getUserEmails($user, $entry));
        }
        return $res;
    }

    public function getCurrentAssignee($bean)
    {
        $userBean = $this->retrieveBean("Users", $bean->assigned_user_id);
        return $userBean;
    }

    public function getRecordCreator($bean)
    {
        $userBean = $this->retrieveBean("Users", $bean->created_by);
        return $userBean;
    }

    public function getLastModifier($bean)
    {
        $userBean = $this->retrieveBean("Users", $bean->modified_user_id);
        return $userBean;
    }

    /**
     * Checks if a User bean is for an active user
     * @param $userBean
     * @return bool
     */
    public function isUserActiveForEmail(User $userBean)
    {
        // Emails should only be sent when Employee Status is Active AND User Status is Active
        return PMSEEngineUtils::isUserActive($userBean) && !empty($userBean->full_name) && !empty($userBean->email1);
    }

    public function getUserEmails($userBean, $entry)
    {
        $res = array();
        $user = $userBean;
        if ($entry->user === 'manager_of') {
            $user = $this->getSupervisor($userBean);
        }

        if (isset($user) && $this->isUserActiveForEmail($user)) {
            $item = new stdClass();
            $item->name = $user->full_name;
            $item->address = $user->email1;
            $res[] = $item;
        }
        return $res;
    }

    public function getSupervisor($user)
    {
        if (isset($user->reports_to_id) && $user->reports_to_id != '') {
            $supervisor = $this->retrieveBean("Users", $user->reports_to_id);
            if (
                isset($supervisor->full_name) &&
                !empty($supervisor->full_name) &&
                isset($supervisor->email1) &&
                !empty($supervisor->email1)
            ) {
                return $supervisor;
            } else {
                return '';
            }
        }
    }

    public function processTeamEmails($bean, $entry, $flowData)
    {
        $res = array();
        $team = $this->retrieveBean('Teams',$entry->value); //$beanFactory->getBean('Teams');
        //$response = $team->getById();
        $members = $team->get_team_members();
        foreach ($members as $user) {
            $userBean = $this->retrieveBean("Users", $user->id);
            if ($this->isUserActiveForEmail($userBean)) {
                $item = new stdClass();
                $item->name = $userBean->full_name;
                $item->address = $userBean->email1;
                $res[] = $item;
            }
        }
        return $res;
    }

    public function processRoleEmails($bean, $entry, $flowData)
    {
        $res = array();
        $role = $this->retrieveBean('ACLRoles', $entry->value);
        $userList = $role->get_linked_beans('users','User');
        foreach ($userList as $user) {
            if ($this->isUserActiveForEmail($user)) {
                $item = new stdClass();
                $item->name = $user->full_name;
                $item->address = $user->email1;
                $res[] = $item;
            }
        }
        return $res;
    }

    public function processRecipientEmails($bean, $entry, $flowData)
    {
        $res = array();
        $field = $entry->value;

        $beans = $this->getRelatedModuleObject()->getChainedRelationshipBeans([$bean], $entry);

        foreach ($beans as $b) {
            if (!empty($b->$field)) {
                $item = new stdClass();
                $item->name = $b->$field;
                $item->address = $b->$field;
                $res[] = $item;
            }
        }
        return $res;
    }

    public function processDirectEmails($bean, $entry, $flowData)
    {
        $res = array();
        $item = new stdClass();
        if (isset($entry->id)) {
            $userBean = $this->retrieveBean('Users', $entry->id);
            if (!empty($userBean)) {
                $item->name = $userBean->full_name;
                $item->address = $userBean->email1;
                $res[] = $item;
            }
        } else {
            // for typed-in emails
            $item->name = $entry->value;
            $item->address = $entry->value;
            $res[] = $item;
        }

        return $res;
    }

    /**
     * Returns a Mailer object
     * @return mixed
     */
    protected function retrieveMailer()
    {
        return MailerFactory::getSystemDefaultMailer();
    }
    /**
     * Send the email based in an email template and with the email data parsed.
     * @param type $moduleName
     * @param type $beanId
     * @param type $addresses
     * @param type $templateId
     * @return type
     */
    public function sendTemplateEmail($moduleName, $beanId, $addresses, $templateId)
    {
        $mailTransmissionProtocol = "unknown";
        if (PMSEEngineUtils::isEmailRecipientEmpty($addresses)) {
            $this->getLogger()->alert('All email recipients are filtered out of the email recipient list.');
            return;
        }
        try {
            $bean = $this->retrieveBean($moduleName, $beanId);
            $templateObject = $this->retrieveBean('pmse_Emails_Templates');
            $templateObject->disable_row_level_security = true;

            $mailObject = $this->retrieveMailer();
            $mailTransmissionProtocol   = $mailObject->getMailTransmissionProtocol();

            $this->addRecipients($mailObject, $addresses);

            if (isset($templateId) && $templateId != "") {
                $templateObject->retrieve($templateId);
            } else {
                $this->getLogger()->warning('template_id is not defined');
            }

            if (!empty($templateObject->from_name) && !empty($templateObject->from_address)) {
                $mailObject->setHeader(EmailHeaders::From, new EmailIdentity($templateObject->from_address, $templateObject->from_name));
            }

            $sender = $this->getSender($templateObject);

            if (isset($sender)) {
                $mailObject->setHeader(EmailHeaders::From, new EmailIdentity($sender['address'], $sender['name']));
            }

            $emailBody = $this->getEmailBody($templateObject, $bean);
            $mailObject->setHtmlBody($emailBody['htmlBody']);
            $mailObject->setTextBody($emailBody['textBody']);

            $mailObject->setSubject($this->getSubject($templateObject, $bean));

            $mailObject->send();
        } catch (MailerException $mailerException) {
            $message = $mailerException->getMessage();
            $this->getLogger()->warning("Error sending email (method: {$mailTransmissionProtocol}), (error: {$message})");
        }
    }

    /**
     * Save the email's content to the DB and then add it to the job queue to send later
     *
     * @param $flowData
     */
    public function queueEmail($flowData)
    {
        $id = $this->saveEmailContent($flowData);
        if (isset($id)) {
            $this->addEmailToQueue($id);
        } else {
            $this->getLogger()->warning('Unable to queue email for flow id ' . $flowData['id']);
        }
    }
    /**
     * Add pmse_EmailMessage ID to the job queue to send the email through the job queue
     *
     * @param $id The ID of the pmse_EmailMessage bean
     */
    public function addEmailToQueue($id)
    {
        $job = BeanFactory::newBean('SchedulersJobs');
        $job->name = "SugarBPM Email Queue";
        $job->target = "class::SugarJobSendAWFEmail";
        $job->data = json_encode(array('id' => $id));

        $jq = new SugarJobQueue();
        $jq->submitJob($job);
    }

    /**
     * Get email from pmse_email_message table
     *
     * @param string $id ID of the pmse_EmailMessage bean
     * @return SugarBean
     */
    public function getQueuedEmail($id)
    {
        return BeanFactory::getBean('pmse_EmailMessage', $id);
    }

    /**
     * Send email using an array of email values
     * @param pmse_EmailMessage $email
     * @return bool `true` if email is sent
     */
    public function sendEmailFromQueue(pmse_EmailMessage $email)
    {
        if (empty($email) || empty($email->id)) {
            $this->getLogger()->warning(
                "Error sending email. Email data not found"
            );
            return false;
        }

        $mailObject = $this->retrieveMailer();
        $mailTransmissionProtocol = $mailObject->getMailTransmissionProtocol();

        $addresses = new stdClass();
        $addresses->to = json_decode($email->to_addrs);
        $addresses->cc = json_decode($email->cc_addrs);
        $addresses->bcc = json_decode($email->bcc_addrs);

        $this->addRecipients($mailObject, $addresses);
        $mailObject->setHtmlBody($email->body_html);
        $mailObject->setTextBody($email->body);
        $mailObject->setSubject($email->subject);

        try {
            $mailObject->send();
            return true;
        } catch (MailerException $mailerException) {
            $message = $mailerException->getMessage();
            $this->getLogger()->warning(
                "Error sending email (method: {$mailTransmissionProtocol}), (error: {$message})"
            );
            return false;
        }
    }

    /**
     * Save email to pmse_email_message table with runtime values
     *
     * @param array $flowData
     * @return string|null mixed
     */
    public function saveEmailContent($flowData)
    {
        $beans = $this->getBeansForEmailContentSave($flowData);

        if (is_null($beans)) {
            return null;
        }

        list($evnDefBean, $templateBean, $targetBean, $emailMessageBean) = $beans;

        $addresses = $this->getRecipients($evnDefBean, $targetBean, $flowData);

        if (PMSEEngineUtils::isEmailRecipientEmpty($addresses)) {
            $this->getLogger()->alert('All email recipients are filtered out of the email recipient list.');
            return null;
        }

        foreach ($addresses as $recipientType => $emailAddresses) {
            $emailMessageBean->{$recipientType . '_addrs'} = json_encode($emailAddresses);
        }

        $emailBody = $this->getEmailbody($templateBean, $targetBean);
        $emailMessageBean->body = $emailBody['textBody'];
        $emailMessageBean->body_html = $emailBody['htmlBody'];

        $emailMessageBean->subject = $this->getSubject($templateBean, $targetBean);

        $sender = $this->getSender($templateBean);
        if (isset($sender)) {
            $emailMessageBean->from_addr = $sender['address'];
            $emailMessageBean->from_name = $sender['name'];
        }

        $emailMessageBean->flow_id = $flowData['id'];
        return $emailMessageBean->save();
    }

    /**
     * Helper method to get all the beans required for saveEmailContent
     * @param array $flowData
     * @return array|null All the beans needed to save
     */
    protected function getBeansForEmailContentSave($flowData)
    {
        $evnDefBean = BeanFactory::getBean('pmse_BpmEventDefinition', $flowData['bpmn_id']);
        $templateBean = BeanFactory::getBean('pmse_Emails_Templates', $evnDefBean->evn_criteria);
        $targetBean = BeanFactory::getBean($flowData['cas_sugar_module'], $flowData['cas_sugar_object_id']);
        $emailMessageBean = BeanFactory::getBean('pmse_EmailMessage');

        if (empty($evnDefBean->id)) {
            $this->getLogger()->warning('Event Definition not found. Unable to save email');
            return null;
        }

        if (empty($templateBean->id)) {
            $this->getLogger()->warning('Email Template not found. Unable to save email');
            return null;
        }

        if (empty($targetBean) || empty($targetBean->id)) {
            $this->getLogger()->warning('Target Bean not found. Unable to save email');
            return null;
        }

        return [$evnDefBean, $templateBean, $targetBean, $emailMessageBean];
    }

    /**
     * Get the recipients for the email
     *
     * @param SugarBean $eventDefinitionBean Bean containing the event definition
     * @param SugarBean $targetBean Target module bean
     * @param array $flowData Flow Data
     * @return StdClass
     */
    public function getRecipients($eventDefinitionBean, $targetBean, $flowData)
    {
        $json = htmlspecialchars_decode($eventDefinitionBean->evn_params);
        return $this->processEmailsFromJson($targetBean, $json, $flowData);
    }

    /**
     * Get the email body (html and text) from the template
     *
     * @param SugarBean $templateBean Email template bean
     * @param SugarBean $targetBean Target module bean
     * @return array
     */
    public function getEmailBody($templateBean, $targetBean)
    {
        if (empty($templateBean->body) && !empty($templateBean->body_html)) {
            $templateBean->body = $templateBean->body_html;
        }

        // We should hit this condition almost every time so let's save some processing
        // by only merging the bean into the template once
        if ($templateBean->body === $templateBean->body_html) {
            $mergedHtmlContent = $mergedTextContent
                = $this->mergeBeanContentIntoTemplate($templateBean->body_html, $targetBean);
        } else {
            // Edge case when body is different from html body
            // Should never happen unless someone has customized or made their own API calls
            $mergedHtmlContent = $this->mergeBeanContentIntoTemplate($templateBean->body_html, $targetBean);
            $mergedTextContent = $this->mergeBeanContentIntoTemplate($templateBean->body, $targetBean);
        }

        return [
            'htmlBody' => $this->getHtmlEmailBody($mergedHtmlContent),
            'textBody' => $this->getTextEmailBody($mergedTextContent),
        ];
    }

    /**
     * Merge bean info into the html body
     *
     * @param $content
     * @return null|string
     */
    private function getHtmlEmailBody($content)
    {
        if (!empty($content)) {
            $textOnly = EmailFormatter::isTextOnly($content);
            if (!$textOnly) {
                return $this->fromHtml($content);
            }
        }

        $this->getLogger()->warning('Process Email Template body_html is not defined');
        return null;
    }

    /**
     * Merge bean info into text body
     *
     * @param string $content
     * @return null|string
     */
    private function getTextEmailBody($content)
    {
        if (!empty($content)) {
            return $this->getTextFromHtml($content);
        }

        $this->getLogger()->warning('Process Email Template body is not defined');
        return null;
    }

    /**
     * Get the subject from the template bean
     *
     * @param SugarBean $templateBean Email template bean
     * @param SugarBean $targetBean Target module bean
     * @return null|string
     */
    public function getSubject($templateBean, $targetBean)
    {
        if (!empty($templateBean->subject)) {
            $mergedContent = $this->mergeBeanContentIntoTemplate($templateBean->subject, $targetBean);
            return $this->getTextFromHtml($mergedContent);
        }

        $this->getLogger()->warning('template subject is not defined');
        return null;
    }

    /**
     * Get the From name and email address from the email template
     *
     * @param SugarBean $templateBean Email template bean
     * @return array|null
     */
    public function getSender($templateBean)
    {
        if (!empty($templateBean->from_name) && !empty($templateBean->from_address)) {
            return [
                'address' => $templateBean->from_address,
                'name' => $templateBean->from_name,
            ];
        }

        return null;
    }

    /**
     * Merge any variables from the bean into the template
     *
     * @param string $content
     * @param SugarBean $targetBean Target module bean
     * @return null|string
     */
    private function mergeBeanContentIntoTemplate($content, $targetBean)
    {
        if (!empty($content)) {
            return $this->getBeanUtils()->mergeBeanInTemplate($targetBean, $content, true);
        }

        return null;
    }

    /**
     * Wrapper for db_utils.php from_html function
     *
     * @param string $text
     * @return string
     */
    protected function fromHtml($text)
    {
        return from_html($text);
    }

    /**
     * Clean out any HTML content from the content
     *
     * @param string $content
     * @return string
     */
    private function getTextFromHtml($content)
    {
        return $this->fromHtml(strip_tags(br2nl($content)));
    }

    /**
     * Add receipients to Mailer object in preparation to sending email
     * @param $mailObject Mailer object
     * @param $addresses To, CC & BCC Email addresses
     */
    protected function addRecipients($mailObject, $addresses)
    {
        foreach (['to', 'cc', 'bcc'] as $type) {
            if (isset($addresses->{$type})) {
                $method = 'addRecipients' . ucfirst($type);
                foreach ($addresses->{$type} as $key => $email) {
                    $mailObject->{$method}(new EmailIdentity($email->address, $email->name));
                }
            }
        }
    }

    /**
     * Checks if the primary email address exists
     * @param type $field
     * @param type $bean
     * @param type $historyData
     * @return boolean
     */
    public function doesPrimaryEmailExists($field, $bean, $historyData)
    {
        if ($field->field == 'email_addresses_primary') {
            $preEmail = $bean->emailAddress->getPrimaryAddress('', $bean->id, $bean->module_dir);
            if (empty($preEmail)) {
                //is a new record, it hasn't any email in DB yet
                $emailKey = $this->getPrimaryEmailKeyFromREQUEST($bean);
                if (isset($historyData)) {
                    $historyData->savePredata($field->field, $_REQUEST[$emailKey]);
                }
                $_REQUEST[$emailKey] = $field->value;
            } else {
                //the record exist in db
                if (isset($historyData)) {
                    $historyData->savePredata($field->field, $preEmail);
                }
                $this->updateEmails($bean, $field->value);
            }
            return true;
        }
        return false;
    }

    /**
     * Get the primary Key from a request in order to obtain the email id
     * @param type $bean
     * @return type
     */
    public function getPrimaryEmailKeyFromREQUEST($bean)
    {
        $module = $bean->module_dir;
        $widgetCount = 0;
        $moduleItem = '0';

        $widget_id = '';
        foreach ($_REQUEST as $key => $value) {
            if (strpos($key, 'emailAddress') !== false) {
                break;
            }
            $widget_id = $_REQUEST[$module . '_email_widget_id'];
        }

        while (isset($_REQUEST[$module . $widget_id . "emailAddress" . $widgetCount])) {
            if (empty($_REQUEST[$module . $widget_id . "emailAddress" . $widgetCount])) {
                $widgetCount++;
                continue;
            }

            $primaryValue = false;

            $eId = $module . $widget_id;
            if (isset($_REQUEST[$eId . 'emailAddressPrimaryFlag'])) {
                $primaryValue = $_REQUEST[$eId . 'emailAddressPrimaryFlag'];
            } elseif (isset($_REQUEST[$module . 'emailAddressPrimaryFlag'])) {
                $primaryValue = $_REQUEST[$module . 'emailAddressPrimaryFlag'];
            }

            if ($primaryValue) {
                return $eId . 'emailAddress' . $widgetCount;
            }
            $widgetCount++;
        }
        $_REQUEST[$bean->module_dir . '_email_widget_id'] = 0;
        $_REQUEST['emailAddressWidget'] = 1;
        $_REQUEST['useEmailWidget'] = true;
        $emailId = $bean->module_dir . $moduleItem . 'emailAddress';
        $_REQUEST[$emailId . 'PrimaryFlag'] = $emailId . $moduleItem;
        $_REQUEST[$emailId . 'VerifiedFlag' . $moduleItem] = true;
        //$_REQUEST[$emailId . 'VerifiedValue' . $moduleItem] = $myemail;

        return $emailId . $moduleItem;
    }

    /**
     * Update the email data in the REQUEST global object
     * @param type $bean
     * @param type $newEmailAddress
     */
    public function updateEmails($bean, $newEmailAddress)
    {
        //Note.- in the future will be an 'array' of change fields emails
        $moduleItem = '0';
        $addresses = $bean->emailAddress->getAddressesByGUID($bean->id, $bean->module_dir);
        if (sizeof($addresses) > 0) {
            $_REQUEST[$bean->module_dir . '_email_widget_id'] = 0;
            $_REQUEST['emailAddressWidget'] = 1;
            $_REQUEST['useEmailWidget'] = true;
        }
        foreach ($addresses as $item => $data) {
            if (!isset($data['email_address_id']) || !isset($data['primary_address'])) {
                $this->getLogger()->error(' The Email address Id or the primary address flag does not exist in DB');
                continue;
            }
            $emailAddressId = $data['email_address_id'];
            $emailId = $bean->module_dir . $moduleItem . 'emailAddress';
            if (!empty($emailAddressId) && $data['primary_address'] == 1) {
                $_REQUEST[$emailId . 'PrimaryFlag'] = $emailId . $item;
                $_REQUEST[$emailId . $item] = $newEmailAddress;
            } else {
                $_REQUEST[$emailId . $item] = $data['email_address'];
            }
            $_REQUEST[$emailId . 'Id' . $item] = $emailAddressId;
            $_REQUEST[$emailId . 'VerifiedFlag' . $item] = true;
            $_REQUEST[$emailId . 'VerifiedValue' . $item] = $data['email_address'];
        }
    }
}
