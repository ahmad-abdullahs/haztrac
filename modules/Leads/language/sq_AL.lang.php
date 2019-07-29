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

$mod_strings = array (
    //DON'T CONVERT THESE THEY ARE MAPPINGS
    'db_last_name' => 'LBL_LIST_LAST_NAME',
    'db_first_name' => 'LBL_LIST_FIRST_NAME',
    'db_title' => 'LBL_LIST_TITLE',
    'db_email1' => 'LBL_LIST_EMAIL_ADDRESS',
    'db_account_name' => 'LBL_LIST_ACCOUNT_NAME',
    'db_email2' => 'LBL_LIST_EMAIL_ADDRESS',

    //END DON'T CONVERT

    // Dashboard Names
    'LBL_LEADS_LIST_DASHBOARD' => 'Paneli i listës së drejtuesve',
    'LBL_LEADS_RECORD_DASHBOARD' => 'Paneli i regjistrimeve të drejtuesve',

    'ERR_DELETE_RECORD' => 'en_us Duhet përcaktuar numrin e regjistrimit për të fshirëudhëheqjen',
    'LBL_ACCOUNT_DESCRIPTION'=> 'Përshkrimi i llogarisë',
    'LBL_ACCOUNT_ID'=>'ID e Llogarisë',
    'LBL_ACCOUNT_NAME' => 'Emri i llogarisë:',
    'LBL_ACTIVITIES_SUBPANEL_TITLE'=>'Aktivitetet',
    'LBL_ADD_BUSINESSCARD' => 'Shto kartën e biznesit',
    'LBL_ADDRESS_INFORMATION' => 'informacioni i adresës',
    'LBL_ALT_ADDRESS_CITY' => 'Adresa alternative e qytetit',
    'LBL_ALT_ADDRESS_COUNTRY' => 'Adresa alternative e shtetit',
    'LBL_ALT_ADDRESS_POSTALCODE' => 'Adresa alternative e kodit postal',
    'LBL_ALT_ADDRESS_STATE' => 'Adresa alternative e shtetit',
    'LBL_ALT_ADDRESS_STREET_2' => 'Adresa alternative 2 e qrrugës',
    'LBL_ALT_ADDRESS_STREET_3' => 'Adresa alternative 3 e rrugës',
    'LBL_ALT_ADDRESS_STREET' => 'Adresa alternative e rrugës',
    'LBL_ALTERNATE_ADDRESS' => 'Adresë tjetër:',
    'LBL_ANY_ADDRESS' => 'çdo adresë',
    'LBL_ANY_EMAIL' => 'çdo email:',
    'LBL_ANY_PHONE' => 'çdo numër telefoni:',
    'LBL_ASSIGNED_TO_NAME' => 'Drejtuar',
    'LBL_ASSIGNED_TO_ID' => 'Përdorues i caktuar',
    'LBL_BACKTOLEADS' => 'Kthe te udhëheqjet',
    'LBL_BUSINESSCARD' => 'Konverto udhëheqjen',
    'LBL_CITY' => 'Qyteti',
    'LBL_CONTACT_ID' => 'ID e Kontaktit',
    'LBL_CONTACT_INFORMATION' => 'Pasqyra',
    'LBL_CONTACT_NAME' => 'Emri i udhëheqësit',
    'LBL_CONTACT_OPP_FORM_TITLE' => 'Udhëheqje-mundësi:',
    'LBL_CONTACT_ROLE' => 'roli',
    'LBL_CONTACT' => 'Udhëheqje',
    'LBL_CONVERT_BUTTON_LABEL' => 'Konverto',
    'LBL_SAVE_CONVERT_BUTTON_LABEL' => 'Ruaj dhe konverto',
    'LBL_CONVERT_PANEL_OPTIONAL' => '(opcionale)',
    'LBL_CONVERT_ACCESS_DENIED' => 'Ju keni humbur qasje edituesae në modulet e nevojshme për të kthyer në kontakt: {{requiredModulesMissing}}',
    'LBL_CONVERT_FINDING_DUPLICATES' => 'Kërkim për duplikatë',
    'LBL_CONVERT_IGNORE_DUPLICATES' => 'Injoro dhe krijo të ri',
    'LBL_CONVERT_BACK_TO_DUPLICATES' => 'Kthehu tek duplikatët',
    'LBL_CONVERT_SWITCH_TO_CREATE' => 'Krijo të re',
    'LBL_CONVERT_SWITCH_TO_SEARCH' => 'Kërkim',
    'LBL_CONVERT_DUPLICATES_FOUND' => '{{duplicateCount}} u gjet duplikat',
    'LBL_CONVERT_CREATE_NEW' => 'I ri {{moduleName}}',
    'LBL_CONVERT_SELECT_MODULE' => 'Zgjidh {{moduleName}}',
    'LBL_CONVERT_SELECTED_MODULE' => 'Po zgjedh {{moduleName}}',
    'LBL_CONVERT_CREATE_MODULE' => 'Krijo {{moduleName}}',
    'LBL_CONVERT_CREATED_MODULE' => 'Po krijon {{moduleName}}',
    'LBL_CONVERT_RESET_PANEL' => 'Rivendos',
    'LBL_CONVERT_COPY_RELATED_ACTIVITIES' => 'Kopjo aktivitetet e përafërta në',
    'LBL_CONVERT_MOVE_RELATED_ACTIVITIES' => 'Lëviz aktivitetet e përafërta në',
    'LBL_CONVERT_MOVE_ACTIVITIES_TO_CONTACT' => 'Lëviz veprimtaritë përkatëse në regjistrin e kontaktit',
    'LBL_CONVERTED_ACCOUNT'=>'Llogaria e konvertuar',
    'LBL_CONVERTED_CONTACT' => 'Kontakti i konvertuar',
    'LBL_CONVERTED_OPP'=>'Mundësia e konvertuar:',
    'LBL_CONVERTED'=> 'I konvertuar',
    'LBL_CONVERTLEAD_BUTTON_KEY' => 'V',
    'LBL_CONVERTLEAD_TITLE' => 'Udhëheqje e konvertuar [Alt+V]',
    'LBL_CONVERTLEAD' => 'Konverto udhëheqje',
    'LBL_CONVERTLEAD_WARNING' => 'Paralajmërim: Statusi i Klientit Potencial që ju jeni gati për të kthyer është "Konvertuar". KontaktI dhe/ose të dhënat e llogarive mund tashmë të krijohen prej Klientit Potencial.. Nëse ju dëshironi të vazhdoni me konvertimin e Klientit Potencial, kliko Ruaj. Për të shkuar përsëri në Klientin Potencial pa konvertimin e tij, klikoni Anulo.',
    'LBL_CONVERTLEAD_WARNING_INTO_RECORD' => 'Kontakt i mundshëm',
    'LBL_CONVERTLEAD_ERROR' => 'E pa aftë për të konvertuar kontaktin',
    'LBL_CONVERTLEAD_FILE_WARN' => 'Ju me sukses keni konvertuar kontaktin {{leadName}}, por ka një problem gjatë ngarkimit të bashkangjitjeve në një ose më shumë regjistrime.',
    'LBL_CONVERTLEAD_SUCCESS' => 'u me sukses keni konvertuar kontaktin {{leadName}}',
    'LBL_COUNTRY' => 'Shteti',
    'LBL_CREATED_NEW' => 'Krijo të re',
	'LBL_CREATED_ACCOUNT' => 'Krijimi i llogari së re',
    'LBL_CREATED_CALL' => 'Krijimi i thirrjes së re',
    'LBL_CREATED_CONTACT' => 'Krijimi i kontaktit të ri',
    'LBL_CREATED_MEETING' => 'Krijimi i mbledhjes së re',
    'LBL_CREATED_OPPORTUNITY' => 'Krijimi i mundësisë së re',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'udhëheqjet',
    'LBL_DEPARTMENT' => 'Departamenti',
    'LBL_DESCRIPTION_INFORMATION' => 'Informacioni përshkrues',
    'LBL_DESCRIPTION' => 'Përshkrim:',
    'LBL_DO_NOT_CALL' => 'Mos telefono:',
    'LBL_DUPLICATE' => 'Udhëheqje të ngjashme',
    'LBL_EMAIL_ADDRESS' => 'Email adresa',
    'LBL_EMAIL_OPT_OUT' => 'Email i zgjedhur jashtë:',
    'LBL_EXISTING_ACCOUNT' => 'Përdorim i llogarisë ekzistuese',
    'LBL_EXISTING_CONTACT' => 'Përdorim i kontaktit ekzistues',
    'LBL_EXISTING_OPPORTUNITY' => 'Përdorim i mundësisë ekzistuese',
    'LBL_FAX_PHONE' => 'faks',
    'LBL_FIRST_NAME' => 'Emri',
    'LBL_FULL_NAME' => 'Emri',
    'LBL_HISTORY_SUBPANEL_TITLE'=>'Historia',
    'LBL_HOME_PHONE' => 'telefoni i shtëpisë',
    'LBL_IMPORT_VCARD' => 'Importo vCard',
    'LBL_IMPORT_VCARD_SUCCESS' => 'Kontakti nga vKarta është krijuar me sukses',
    'LBL_VCARD' => 'vCard',
    'LBL_IMPORT_VCARDTEXT' => 'Krijo automatikisht kontakt të ri duke importuar vCard nga systemi i dosjeve të tua.',
    'LBL_INVALID_EMAIL'=>'Email Jo Valid',
    'LBL_INVITEE' => 'Raportet direkte',
    'LBL_LAST_NAME' => 'Mbiemri',
    'LBL_LEAD_SOURCE_DESCRIPTION' => 'Përshkrimi i burimit të udhëheqjes',
    'LBL_LEAD_SOURCE' => 'Burimi i udhëheqjes',
    'LBL_LIST_ACCEPT_STATUS' => 'Prano statusin',
    'LBL_LIST_ACCOUNT_NAME' => 'Emri i llogarisë',
    'LBL_LIST_CONTACT_NAME' => 'Emri i udhëheqjes',
    'LBL_LIST_CONTACT_ROLE' => 'Roli',
    'LBL_LIST_DATE_ENTERED' => 'Data e krijimit',
    'LBL_LIST_EMAIL_ADDRESS' => 'Email',
    'LBL_LIST_FIRST_NAME' => 'Emri',
    'LBL_VIEW_FORM_TITLE' => 'Shikimi i udhëheqjeve',
    'LBL_LIST_FORM_TITLE' => 'Lista e udhëheqjeve',
    'LBL_LIST_LAST_NAME' => 'Mbiemri',
    'LBL_LIST_LEAD_SOURCE_DESCRIPTION' => 'Përshkrimi i burimit të udhëheqjes',
    'LBL_LIST_LEAD_SOURCE' => 'Burimi i udhëheqjes',
    'LBL_LIST_MY_LEADS' => 'Udhëheqjet e mia',
    'LBL_LIST_NAME' => 'Emri',
    'LBL_LIST_PHONE' => 'telefoni i zyrës',
    'LBL_LIST_REFERED_BY' => 'Referuar nga',
    'LBL_LIST_STATUS' => 'Statusi',
    'LBL_LIST_TITLE' => 'Titulli',
    'LBL_MOBILE_PHONE' => 'Celular:',
    'LBL_MODULE_NAME' => 'Udhëheqjet',
    'LBL_MODULE_NAME_SINGULAR' => 'klient potencial',
    'LBL_MODULE_TITLE' => 'Udhëheqjet: Ballina',
    'LBL_NAME' => 'Emri',
    'LBL_NEW_FORM_TITLE' => 'Udhëheqje e re',
    'LBL_NEW_PORTAL_PASSWORD' => 'Fajlëkalim i ri i portalit',
    'LBL_OFFICE_PHONE' => 'telefoni i zyrës',
    'LBL_OPP_NAME' => 'Emri i mundësisë',
    'LBL_OPPORTUNITY_AMOUNT' => 'Sasia e mundësisë',
    'LBL_OPPORTUNITY_ID'=>'ID e mundësisë',
    'LBL_OPPORTUNITY_NAME' => 'Emri i mundësisë',
    'LBL_CONVERTED_OPPORTUNITY_NAME' => 'Emri i mundësisë së konvertuar',
    'LBL_OTHER_EMAIL_ADDRESS' => 'Email tjetër',
    'LBL_OTHER_PHONE' => 'Telefon tjetër',
    'LBL_PHONE' => 'Telefoni',
    'LBL_PORTAL_ACTIVE' => 'Portali aktiv:',
    'LBL_PORTAL_APP'=> 'Aplikimi i portalit',
    'LBL_PORTAL_INFORMATION' => 'Informacioni i portalit',
    'LBL_PORTAL_NAME' => 'Emri i portalit',
    'LBL_PORTAL_PASSWORD_ISSET' => 'Fjalëkalimi i portalit është përcaktuar:',
    'LBL_POSTAL_CODE' => 'Kodi postal',
    'LBL_STREET' => 'Rruga',
    'LBL_PRIMARY_ADDRESS_CITY' => 'Adresë primare e qytetit',
    'LBL_PRIMARY_ADDRESS_COUNTRY' => 'Adresë primare e shtetit',
    'LBL_PRIMARY_ADDRESS_POSTALCODE' => 'Adresë primare e kodit postal',
    'LBL_PRIMARY_ADDRESS_STATE' => 'Adresë primare e shtetit',
    'LBL_PRIMARY_ADDRESS_STREET_2'=>'Adresa  e rrugës primare 2',
    'LBL_PRIMARY_ADDRESS_STREET_3'=>'Adresa e rrugës primare 3',
    'LBL_PRIMARY_ADDRESS_STREET' => 'Adresë primare e rrugës',
    'LBL_PRIMARY_ADDRESS' => 'Adresa primare',
    'LBL_RECORD_SAVED_SUCCESS' => 'Ju me sukses keni krijuar {{moduleSingularLower}} {{full_name}}.',
    'LBL_REFERED_BY' => 'Referuar Nga:',
    'LBL_REPORTS_TO_ID'=>'I raporton ID',
    'LBL_REPORTS_TO' => 'I reporton',
    'LBL_REPORTS_FROM' => 'Raporte nga:',
    'LBL_SALUTATION' => 'Përshëndetje',
    'LBL_MODIFIED'=>'Modifikuar nga',
	'LBL_MODIFIED_ID'=>'Modifikuar nga Id',
	'LBL_CREATED'=>'Krijuar nga',
	'LBL_CREATED_ID'=>'Krijuar nga Id',
    'LBL_SEARCH_FORM_TITLE' => 'Kërkimi i udhëheqjeve',
    'LBL_SELECT_CHECKED_BUTTON_LABEL' => 'selekto udhëheqjet e kontrolluara',
    'LBL_SELECT_CHECKED_BUTTON_TITLE' => 'selekto udhëheqjet e kontrolluara',
    'LBL_STATE' => 'Shteti',
    'LBL_STATUS_DESCRIPTION' => 'Përshkrimi i statusit:',
    'LBL_STATUS' => 'Statusi',
    'LBL_TITLE' => 'Titulli',
    'LBL_UNCONVERTED'=> 'E pakonvertuar',
    'LNK_IMPORT_VCARD' => 'Krijo udhëheqje nga vCard',
    'LNK_LEAD_LIST' => 'Shiko udhëheqjet',
    'LNK_NEW_ACCOUNT' => 'krijo llogari',
    'LNK_NEW_APPOINTMENT' => 'krijo takim',
    'LNK_NEW_CONTACT' => 'krijo kontaktet',
    'LNK_NEW_LEAD' => 'Krijo udhëheqje',
    'LNK_NEW_NOTE' => 'Krijo shënim',
    'LNK_NEW_TASK' => 'Krijo detyrë',
    'LNK_NEW_CASE' => 'Krijo rast',
    'LNK_NEW_CALL' => 'Thirrje identifikuese',
    'LNK_NEW_MEETING' => 'Cakto mbledhje',
    'LNK_NEW_OPPORTUNITY' => 'Krijo mundësi',
	'LNK_SELECT_ACCOUNTS' => 'ose selekto llogarinë',
    'LNK_SELECT_CONTACTS' => 'OSE Zgjidh Kontakti',
    'NTC_COPY_ALTERNATE_ADDRESS' => 'Kopjo adresën alternative në atë primare',
    'NTC_COPY_PRIMARY_ADDRESS' => 'Kopjo adresën primare në atë alternative',
    'NTC_DELETE_CONFIRMATION' => 'A jeni të sigurtë që dëshironi të fshini këtë regjistrim?',
    'NTC_OPPORTUNITY_REQUIRES_ACCOUNT' => 'Krijimi i një mundësie kërkon një llogari. Ju lutemi ose krijoni një të re ose selektoni një ekzistuese.',
    'NTC_REMOVE_CONFIRMATION' => 'A jeni të sigurt që dëshironi të largoni këtë udhëheqje nga rasti?',
    'NTC_REMOVE_DIRECT_REPORT_CONFIRMATION' => 'A jeni të sigurt që dëshironi të largoni këtë regjistrim si regjistrim direkt?',
    'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE'=>'fushatat',
    'LBL_TARGET_OF_CAMPAIGNS'=>'Fushatë e suksesshme',
    'LBL_TARGET_BUTTON_LABEL'=>'e synuar',
    'LBL_TARGET_BUTTON_TITLE'=>'e synuar',
    'LBL_TARGET_BUTTON_KEY'=>'T',
    'LBL_CAMPAIGN' => 'Fushata:',
  	'LBL_LIST_ASSIGNED_TO_NAME' => 'Përdorues i caktuar',
    'LBL_PROSPECT_LIST' => 'lista e prospektit',
    'LBL_PROSPECT' => 'Synim',
    'LBL_CAMPAIGN_LEAD' => 'fushatat',
	'LNK_LEAD_REPORTS' => 'Shiko raportet e udhëheqjes',
    'LBL_BIRTHDATE' => 'Ditëlindja:',
    'LBL_THANKS_FOR_SUBMITTING_LEAD' =>'Faleminderit për paraqitjen tuaj.',
    'LBL_SERVER_IS_CURRENTLY_UNAVAILABLE' =>'Na vjen keq, serveri aktualisht është në dispozicion, ju lutem provoni përsëri më vonë.',
    'LBL_ASSISTANT_PHONE' => 'Telefon i ndihmësit',
    'LBL_ASSISTANT' => 'Ndihmë',
    'LBL_REGISTRATION' => 'Regjistrimi',
    'LBL_MESSAGE' => 'Ju lutem shkruani informacionin tuaj më poshtë. Informacioni dhe/ose një llogari do të krijohet për ju në pritje të miratimit.',
    'LBL_SAVED' => 'Faleminderit për regjistrimin. Llogaria juaj do të krijohet dhe dikush do t&#39;ju kontaktojë pas pak.',
    'LBL_CLICK_TO_RETURN' => 'Kthehu në portal',
    'LBL_CREATED_USER' => 'Përdorues i krijuar',
    'LBL_MODIFIED_USER' => 'përdorues i modifikuar',
    'LBL_CAMPAIGNS' => 'fushatat',
    'LBL_CAMPAIGNS_SUBPANEL_TITLE' => 'fushatat',
    'LBL_CONVERT_MODULE_NAME' => 'Modul',
    'LBL_CONVERT_MODULE_NAME_SINGULAR' => 'Moduli',
    'LBL_CONVERT_REQUIRED' => 'E nevojshme',
    'LBL_CONVERT_SELECT' => 'Lejo selektimin',
    'LBL_CONVERT_COPY' => 'Kopjo të dhënat',
    'LBL_CONVERT_EDIT' => 'Ndrysho',
    'LBL_CONVERT_DELETE' => 'Fshi',
    'LBL_CONVERT_ADD_MODULE' => 'Shto modul',
    'LBL_CONVERT_EDIT_LAYOUT' => 'Ndrysho konvertimin e formatit',
    'LBL_CREATE' => 'Krijo',
    'LBL_SELECT' => 'ose Selekto',
	'LBL_WEBSITE' => 'Faqja e internetit',
	'LNK_IMPORT_LEADS' => 'Importo udhëheqjet',
	'LBL_NOTICE_OLD_LEAD_CONVERT_OVERRIDE' => 'Shënim: Konvertimi aktual i Klientit Potencial të ekranit përmban fushat me porosi. Kur ju rregulloni Konvertimin e ekranit të Klientit Potencial në studio për herë të parë, ju do të duhet të shtoni fushat e porositura për paraqitjen, si të nevojshme. Fushat me porosi nuk do të shfaqen automatikisht në paraqitjen, ashtu siç kanë bërë më parë.',
//Convert lead tooltips
	'LBL_MODULE_TIP' 	=> 'Moduli për të krijuar një regjistrim të ri in.',
	'LBL_REQUIRED_TIP' 	=> 'Modulet e kërkuara duhet të jenë krijuar apo selektuar para Klientit Potencial i cili mund të konvertohet.',
	'LBL_COPY_TIP'		=> 'Nëse kontrollohen, nga fushat e Klientit Potencial do të kopjohen në fushat me të njëjtin emër në të dhënat e reja të krijuara.',
	'LBL_SELECTION_TIP' => 'Modulet me fushë të lidhjes në Kontaktet ku mund të selektohen në vend të krijimit gjatë procesit të konvertimit të Klientit Potencial.',
	'LBL_EDIT_TIP'		=> 'Modifiko paraqitjen e Konvertimit për këtë modul.',
	'LBL_DELETE_TIP'	=> 'Fshini këtë modul nga paraqitja e konvertimit.',

    'LBL_ACTIVITIES_MOVE'   => 'Lëviz Aktivitetet në',
    'LBL_ACTIVITIES_COPY'   => 'Kopjo Aktivitetet në',
    'LBL_ACTIVITIES_MOVE_HELP'   => "Selekto regjistrimin në të cilën për të lëvizur aktivitetet e Klientëve Potencial. Detyrat, Thirrjet, takime, Shënime dhe e-mail do të zhvendosen në regjistrimin(et) e selektuar.",
    'LBL_ACTIVITIES_COPY_HELP'   => "Selektoni regjistrimin(et) për të cilin do të krijoni kopje të aktiviteteve tët Klientëve Potencial. Detyrat e reja, Telefonatat, takime dhe shënime do të krijohen për secilin nga selektimi i regjistrimit. Emailat do të jenë të lidhura me selektimin e regjistrimit",
    //For export labels
    'LBL_PHONE_HOME' => 'telefoni i shtëpisë',
    'LBL_PHONE_MOBILE' => 'celulari',
    'LBL_PHONE_WORK' => 'telfoni i zyrës',
    'LBL_PHONE_OTHER' => 'telefon tjetër',
    'LBL_PHONE_FAX' => 'telefon faks',
    'LBL_CAMPAIGN_ID' => 'ID e fushatës',
    'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Emri i përdoruesit të caktuar',
    'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID e përdoruesit të caktuar',
    'LBL_EXPORT_MODIFIED_USER_ID' => 'Modifikuar nga ID',
    'LBL_EXPORT_CREATED_BY' => 'Krijuar Nga ID',
    'LBL_EXPORT_PHONE_MOBILE' => 'Celular',
    'LBL_EXPORT_EMAIL2'=>'email adresa tjera',
	'LBL_EDITLAYOUT' => 'Ndrysho formatin' /*for 508 compliance fix*/,
	'LBL_ENTERDATE' => 'Data e nisjes' /*for 508 compliance fix*/,
	'LBL_LOADING' => 'Ngarkimi...' /*for 508 compliance fix*/,
	'LBL_EDIT_INLINE' => 'Ndrysho' /*for 508 compliance fix*/,
    //D&B Principal Identification
    'LBL_DNB_PRINCIPAL_ID' => 'D&B ID',
    //Dashlet
    'LBL_OPPORTUNITIES_SUBPANEL_TITLE' => 'Mundësitë',

    //Document title
    'TPL_BROWSER_SUGAR7_RECORDS_TITLE' => '{{module}} » {{appId}}',
    'TPL_BROWSER_SUGAR7_RECORD_TITLE' => '{{#if last_name}}{{#if first_name}}{{first_name}} {{/if}}{{last_name}} &raquo; {{/if}}{{module}} &raquo; {{appId}}',
    'LBL_NOTES_SUBPANEL_TITLE' => 'Shënime',

    'LBL_HELP_CONVERT_TITLE' => 'Konverto {module_name}}',

    // Help Text
    // List View Help Text
    'LBL_HELP_RECORDS' => '{{plural_module_name}} është moduli i cili gjurmon dhe menaxhon produktin apo shërbimin të lidhur me problemet e raportuara të organizatës tuaj nga klientët. {{plural_module_name}} janë tipikisht të lidhur me regjstrimin e {{plural_module_name}} dhe shumësi i {{plural_module_name}} mund të asocohen me njëjësin e {{accounts_singular_module}}. Ka disa mënyra për të krijuar  {{plural_module_name}} në Sugar siç është nëpërmjet modulit {{plural_module_name}}, importimi i  {{plural_module_name}} ose konvertimi nga emaili. Një herë që {{module_name}} është krijuar, ju mund ta shikoni dhe editoni informacionin lidhur me {{module_name}} nëpërmjet shikimit të {{module_name}}. Çdo regjistrim {{module_name}} mund të lidhet me regjistrimet e Sugar si {{calls_module}}, {{contacts_module}}, {{bugs_module}} dhe shumë të tjera.',

    // Record View Help Text
    'LBL_HELP_RECORD' => 'Moduli {{plural_module_name}} u lejon juve të gjurmoni shitjet individuale dhe rreshtat të cilat u përkasin atyre shitjeve nga fillimi deri në fund. Çdo regjistrim {{module_name}} përfaqëson një titull për ekipin e {{revenuelineitems_module}} si dhe është i ndërlidhur me regjistrime tjera të rëndësishme si {{quotes_module}}, {{contacts_module}} etj. -Editoni këtë fushë regjistrimesh duke klikuar në fushën individuale ose në butonin Edit. -Veprime tjera shtesë janë në dispozicion në veprimet e poshtme në menu në të djathtë të butonit Edit.',

    // Create View Help Text
    'LBL_HELP_CREATE' => 'Moduli {{plural_module_name}} përbëhet nga individë me perspektivë që mund të jenë të interesuar në një produkt ose shërbim që ofron organizata jote. Pasi {{module_name}} kualifikohet si {{opportunities_singular_module}} shitjesh, ai mund të konvertohet në një {{contacts_singular_module}}, {{accounts_singular_module}}, {{opportunities_singular_module}} ose një regjistër tjetër. 

Për të krijuar një {{module_name}}: 
1. Jep vlerat për fushat sipas dëshirës.
 - Fushat e shënuar si "Të nevojshme" duhet të plotësohen përpara ruajtjes.
 - Kliko "Shfaq më shumë" për të shfaqur fusha shtesë nëse është e nevojshme.
2. Kliko "Ruaj" për të finalizuar regjistrimin e ri dhe për t&#39;u kthyer në faqen e mëparshme.',

    // Convert View Help Text
    'LBL_HELP_CONVERT' => 'Sugar ju mundëson të konvertoni ___ në ___ ose module tjera një herë që ___ i plotëson kriteret kualifikuese. Kaloni në çdo modul duke ndryshuar fushat dhe më pas konfirmoni vlerat e regjistrimeve të reja duke klikuar në çdo buton. Nëse Sugar detekton një regjistrim ekzistues i cili përputhet me ____ informacionin, ju keni opsionin të krijoni duplikim ose të konfirmoni zgjedhjen me butonin e lidhur ose të klikoni "Injoro dhe krijo të ri" dhe procedoni normalisht. Pasi të konfirmoni çdo modul të kërkuar dhe të dëshiruar, klikoni Ruaj dhe konverto butonin lart për të finalizuar bisedën.',

    //Marketo
    'LBL_MKTO_SYNC' => 'Sinkronizo me Marketo®',
    'LBL_MKTO_ID' => 'Marketo kontakti ID',
    'LBL_MKTO_LEAD_SCORE' => 'Pikët e kontaktit',

    'LBL_FILTER_LEADS_REPORTS' => 'Raportet e kontaktit',
    'LBL_DATAPRIVACY_BUSINESS_PURPOSE' => 'Qëllimet e biznesit u miratuan për',
    'LBL_DATAPRIVACY_CONSENT_LAST_UPDATED' => 'Miratimi i përditësuar së fundi',
);
