<?php

foreach ($admin_group_header as $key => $header) {
	if ($header[0] == 'LBL_ADMINISTRATION_HOME_TITLE') {

		$admin_group_header[$key][3]['Administration']['word_manager'] = array('word_templates','LBL_WORD_TEMPLATES','LBL_WORD_TEMPLATES_DESC','javascript:parent.SUGAR.App.router.navigate("word_templates", {trigger: true});');

		break;
	}
}