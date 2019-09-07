<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/RelateRecordApi.php");

class CustomRelateRecordApi extends RelateRecordApi {

    public function registerApiRest() {
        return parent::registerApiRest();
    }

    public function createRelatedLinks(ServiceBase $api, array $args, $securityTypeLocal = 'view', $securityTypeRemote = 'view') {
        $this->requireArgs($args, array('ids'));
        $ids = $this->normalizeLinkIds($args['ids']);

        $result = array(
            'related_records' => array(),
        );

        $primaryBean = $this->loadBean($api, $args);

        list($linkName) = $this->checkRelatedSecurity(
                $api, $args, $primaryBean, $securityTypeLocal, $securityTypeRemote
        );
        $relatedModuleName = $primaryBean->$linkName->getRelatedModuleName();

        foreach ($ids as $id => $additionalValues) {
            $relatedBean = BeanFactory::retrieveBean($relatedModuleName, $id);

            if (!$relatedBean || $relatedBean->deleted) {
                throw new SugarApiExceptionNotFound('Could not find the related bean');
            }

            $relatedData = $this->getRelatedFields($api, $args, $primaryBean, $linkName, $relatedBean);

            $primaryBean->$linkName->add(array($relatedBean), array_merge($relatedData, $additionalValues));

            // ++
            // Code is added to create the RevenueLineItems relationship with account when the RevenueLineItems is 
            // selected from the selection list, the account will be the parent record account on which the selection
            // drawer is pulled up.
            if ($relatedBean->module_dir == 'RevenueLineItems') {
                if ($args['module'] == 'sales_and_services' || $args['module'] == 'RevenueLineItems') {
                    $relatedBean = BeanFactory::retrieveBean($relatedBean->module_dir, $relatedBean->id);
                    $relatedBean->load_relationship('account_link');
                    $relatedBean->account_link->add($additionalValues['account_id']);
                }
            }
            $result['related_records'][] = $this->formatBean($api, $args, $relatedBean);
        }
        //Clean up any hanging related records.
        SugarRelationship::resaveRelatedBeans();

        $result['record'] = $this->formatBean($api, $args, $primaryBean);

        return $result;
    }

}
