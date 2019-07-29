<?php
$mod_strings['LBL_MASK_CONFIG'] = 'Liste des caractères disponible pour le masque de saisie';
$mod_strings['LBL_MASK_CONFIG_CAR'] = 'Caractère de masque';
$mod_strings['LBL_MASK_CONFIG_CAR_DESC'] = 'Description du masque';
$mod_strings['LBL_ALIAS_CONFIG_CAR'] = 'Masque spécial';
$mod_strings['LBL_ALIAS_CONFIG_CAR_DESC'] = 'Description';

$mod_strings['LBL_SYNOLIA'] = 'SYNOLIA';
$mod_strings['LBL_SYNOLIA_ADMIN_DESC'] = 'Configuration des Plugins SYNOLIA';

$mod_strings['LBL_SYNOFIELDMASK_TITLE'] = 'SynoFieldMask';
$mod_strings['LBL_SYNOFIELDMASK_INFOS'] = 'Configuration des masques de saisies';
$mod_strings['LBL_SYNOFIELDMASK_MANAGE_SELECTION_MODULE'] = 'Choisissez le module que vous voulez personnaliser.';
$mod_strings['LBL_SYNOFIELDMASK_MANAGE_NONE'] = 'Module';
$mod_strings['LBL_SYNOFIELDMASK_MANAGE_NO_MODULE'] = 'Aucun module à personnaliser';
$mod_strings['LBL_SYNOFIELDMASK_MODULE_SAVED_1'] = 'Module ';
$mod_strings['LBL_SYNOFIELDMASK_MODULE_SAVED_2'] = ' sauvegardé';
$mod_strings['LBL_SYNOFIELDMASK_MODULE_SAVED_3'] = ' réinitialisé';
$mod_strings['LBL_SYNOFIELDMASK_HELP'] = 'Aide';
$mod_strings['LBL_SYNOFIELDMASK_HELP_TEXT'] = "
<p>Les champs présentés à gauche sont les champs de Type Nom, Varchar et Téléphone du module que vous avez sélectionné.</p>
<br>
<p>Vous pouvez spécifier un <b>masque de saisie</b> pour chaque champ présent.<br />
Ex: <i>(EEE) 999</i> autorise l'écriture de \"aBc123\" et affichera \"(ABC) 123\"<br>
<br>
</p>
<p>Vous pouvez spécifier un <b>masque spécial</b> pour des actions spécifiques mais vous ne pouvez pas le combiner avec les autres masques de saisie sinon il ne sera plus reconnu<br>
Ex : <i>upper</i> autorise l'écriture de \"aBc &1é!\" et affichera \"ABC &1É!\"<br>
<br>
</p>
<hr>
<p>Les masques optionnels \"[...]\" vous permettent de laisser à l'utilisateur le choix de certains caractères à renseigner ou non. Pour passer un masque optionnel il faut utiliser la barre d'espace<br>
Ex: <i>(+9[9[9]]) 9 99 99 99 99</i> autorise l'écriture de \"33(espace)123456789\" et affichera \"+(33) 1 23 45 67 89\"<br>
<br>
</p>
<p>Pour échapper un caractère de masque vous pouvez utiliser \"\\\\\".<br>
Ex: <i>\\\\0</i> pour afficher \"0\" au lieu du masque
<br>
</p>
";
