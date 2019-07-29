<?php
$mod_strings['LBL_MASK_CONFIG'] = 'Mask caracters configuration';
$mod_strings['LBL_MASK_CONFIG_CAR'] = 'Mask caracter';
$mod_strings['LBL_MASK_CONFIG_CAR_DESC'] = 'Description';
$mod_strings['LBL_ALIAS_CONFIG_CAR'] = 'Special Mask';
$mod_strings['LBL_ALIAS_CONFIG_CAR_DESC'] = 'Description';

$mod_strings['LBL_SYNOLIA'] = 'SYNOLIA';
$mod_strings['LBL_SYNOLIA_ADMIN_DESC'] = 'SYNOLIA Plugins configuration';

$mod_strings['LBL_SYNOFIELDMASK_TITLE'] = 'SynoFieldMask';
$mod_strings['LBL_SYNOFIELDMASK_INFOS'] = 'Set mask on fields';
$mod_strings['LBL_SYNOFIELDMASK_MANAGE_SELECTION_MODULE'] = 'Choose a module.';
$mod_strings['LBL_SYNOFIELDMASK_MANAGE_NONE'] = 'Module';
$mod_strings['LBL_SYNOFIELDMASK_MANAGE_NO_MODULE'] = 'No module to configure';
$mod_strings['LBL_SYNOFIELDMASK_MODULE_SAVED_1'] = 'Module ';
$mod_strings['LBL_SYNOFIELDMASK_MODULE_SAVED_2'] = ' saved';
$mod_strings['LBL_SYNOFIELDMASK_MODULE_SAVED_3'] = ' restored';
$mod_strings['LBL_SYNOFIELDMASK_HELP'] = 'Help';
$mod_strings['LBL_SYNOFIELDMASK_HELP_TEXT'] = "
<p>Left side presents all the Fields that have Name, Varchar or Telephone as Type in the selected module.</p>
<br>
<p>You can specify a <b>mask</b> for any of these fields<br />
Ex: <i>(EEE) 999</i> will allow writting \"ABC123\" and will result in \"(ABC) 123\"<br>
<br>
</p>
<p>You can specify a <b>special mask</b> for specific actions but you can't combine it with other masks so it won't be reconize<br>
Ex : <i>upper</i> will allow writting \"aBc &1é!\" and will result in \"ABC &1É!\"<br>
<br>
</p>
<hr>
<p>Optional masks \"[...]\" allow the user the choice not to fill in the caracter(s). To skip an optional part of a mask you must use the space bar.<br>
Ex: <i>+9[9[9]](9[9[9]])999[9]-9999</i> will allow writting \"12(space)345678(space)9000\" and will result in \"+12(345)678-9000\"<br>
<br>
</p>
<p>To escape a mask caracter you can use \"\\\\\".<br>
Ex: <i>\\\\0</i> to write \"0\" instead of the mask<br>
<br>
</p>
";
