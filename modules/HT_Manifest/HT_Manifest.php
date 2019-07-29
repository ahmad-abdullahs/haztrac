<?PHP
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
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/HT_Manifest/HT_Manifest_sugar.php');
class HT_Manifest extends HT_Manifest_sugar {
    public function save($check_notify = false) {
		if (empty($this->manifest_number)) {
			$this->manifest_number = 'MO-' . $this->getUniqueNumber();
		}

		$ret = parent::save($check_notify);

		$this->updateTransporters();

		return $ret;
	}

	private function getUniqueNumber() {
		$uniqueNumber = rand(100000, 999999);

		if (!$this->isUniqueNumber($uniqueNumber)) {
			$uniqueNumber = $this->getUniqueNumber();
		}

		return $uniqueNumber;
	}

	private function isUniqueNumber($number) {
		global $db;

		$res = $db->query("SELECT id FROM {$this->table_name} WHERE deleted='0' AND manifest_number like '%{$number}%'");
		if ($row = $db->fetchByAssoc($res)) {
			return false;
		}

		return true;
	}

	private function updateTransporters() {
		global $db;

		$res = $db->query(
			"DELETE FROM ht_manifest_ht_assets_and_objects_c WHERE ht_manifest_ht_assets_and_objectsht_manifest_ida = '{$this->id}'");
		
		if (!empty($this->transporter)) {
			if (is_string($this->transporter)) {
				$this->transporter = json_decode($this->transporter, true);
			}

			if (!empty($this->transporter)) {
        		$insertSQLs = array();
				foreach ($this->transporter as $transporter) {
					$transporterId = $transporter['id'];
					$transferDate = $transporter['transfer_date'];

					$insertSQLs[] =<<<SQL
	                    SELECT
	                        UUID() as 'id',
	                        NOW() as 'date_modified',
	                        '0' as 'deleted',
	                        '{$transferDate}' as 'transfer_date',
	                        '{$this->id}' as 'ht_manifest_ht_assets_and_objectsht_manifest_ida',
	                        '{$transporterId}' as 'ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb'
SQL;
				}

				// preparing Insert SQL for relationships
		        $insertSQL =<<<SQL
		            INSERT INTO ht_manifest_ht_assets_and_objects_c (
		                id,
		                date_modified,
		                deleted,
		                transfer_date,
		                ht_manifest_ht_assets_and_objectsht_manifest_ida,
		                ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb
		            )
SQL;
        		$db->query($insertSQL . implode(' UNION ', $insertSQLs));
			}
		}
	}
}