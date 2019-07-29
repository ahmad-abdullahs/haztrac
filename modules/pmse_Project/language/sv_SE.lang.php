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
  'LBL_MODULE_NAME' => 'Processdefinitioner',
  'LBL_MODULE_TITLE' => 'Processdefinition',
  'LBL_MODULE_NAME_SINGULAR' => 'Processdefinition',

  'LNK_LIST' => 'Visa Processdefinitioner',
  'LNK_NEW_PMSE_PROJECT' => 'Skapa Processdefinitioner',
  'LNK_IMPORT_PMSE_PROJECT' => 'Importera Processdefinitioner',

  'LBL_PRJ_STATUS' => 'Status',
  'LBL_PRJ_MODULE' => 'Målmodul',
  'LBL_PMSE_BUTTON_SAVE' => 'Spara',
  'LBL_PMSE_BUTTON_CANCEL' => 'Avbryt',
  'LBL_PMSE_BUTTON_YES' => 'Ja',
  'LBL_PMSE_BUTTON_NO' => 'Nej',
  'LBL_PMSE_BUTTON_OK' => 'Ok',
    'LBL_PMSE_FORM_ERROR' => 'Vänligen åtgärda eventuella fel innan du fortsätter.',

    'LBL_PMSE_LABEL_DESIGN' => 'Design',
    'LBL_PMSE_LABEL_EXPORT' => 'Exportera',
    'LBL_PMSE_LABEL_DELETE' => 'Radera',
    'LBL_PMSE_LABEL_ENABLE' => 'Aktivera',
    'LBL_PMSE_LABEL_DISABLE' => 'Inaktivera',

    'LBL_PMSE_SAVE_DESIGN_BUTTON_LABEL' => 'Spara & Designa',
    'LBL_PMSE_IMPORT_BUTTON_LABEL' => 'Importera',

    'LBL_PMSE_MY_PROCESS_DEFINITIONS' => 'Mina Processdefinitioner',
    'LBL_PMSE_ALL_PROCESS_DEFINITIONS' => 'Alla Processdefinitioner',

    'LBL_PMSE_PROCESS_DEFINITIONS_ENABLED' => 'Aktiverad',
    'LBL_PMSE_PROCESS_DEFINITIONS_DISABLED' => 'Inaktiverad',
    'LBL_PMSE_PROCESS_DEFINITIONS_EDIT' => 'Det finns aktiva processer som kör mot processdefinitionen. Om den uppdateras kan processerna påverkas negativt. Vill du ändå redigera den?',
    'LBL_PMSE_DISABLE_CONFIRMATION_PD' => 'Det finns aktiva processer som kör mot processdefinitionen. Om den uppdateras kan processerna påverkas negativt. Vill du ändå avaktivera den?',

    'LBL_PMSE_PROCESS_DEFINITION_IMPORT_TEXT' => 'Ladda upp en .bpm fil för att importera en processdefinition.',
    'LBL_PMSE_PROCESS_DEFINITION_IMPORT_SUCCESS' => 'Processdefinitioner har framgångsrikt importerats in i systemet',
    'LBL_PMSE_PROCESS_DEFINITION_EMPTY_WARNING' => 'Vänligen välj en giltig *.bpm-fil.',
    'LBL_PMSE_PROCESS_DEFINITION_IMPORT_BR' => 'Processdefinitionen har importerats, men innehåller en eller fler Affärsregelhandlingar som inte har tillhörande affärsregler.',
    'LBL_BPM_IMPORT_SELECT' => 'Den här processdefinitionen innehåller följande affärsregler och e-post mallar. '
        . 'Välj de du vill importera.',
    'LBL_BUSINESS_RULES' => 'Affärsregler',
    'LBL_EMAIL_TEMPLATES' => 'E-postmallar',


//    /*PMSE*/

//    'LBL_PMSE_LABEL_TERMINATE_CASES' => 'Terminate Process',

//    'LBL_PMSE_LABEL_CUSTOM_FORM_MODULE' => 'Custom Form Module',
//    'LBL_PMSE_LABEL_CUSTOM_FORM_PROCESS' => 'Custom Form Process',
//    'LBL_PMSE_LABEL_CUSTOM_FORM_NAME' => 'Custom Form name',
//    'LBL_PMSE_LABEL_CUSTOM_FORM_DESC' => 'Custom Form description',
//    'LBL_PMSE_LABEL_LOADING' => 'Loading, please wait...',
//    'LBL_PMSE_LABEL_CASETAKEN' => 'This Process was already taken by another User',
//    'LBL_PMSE_LABEL_CASECOMPLETED' => 'The Process is already closed',
//    'LBL_PMSE_LABEL_UNASSIGNED' => 'Unassigned',
//    'LBL_PMSE_LABEL_SEARCHBYDUEDATE' => 'Search By Due Date',
//    'LBL_PMSE_LABEL_SETTINGSEARCHBYDUEDATE' => 'Setting Search by  Due Date',
//    'LBL_PMSE_LABEL_SEARCH' => 'Search',
//    'LBL_PMSE_LABEL_DELETED_RECORD'=>'The records related to this Process has been removed',


    /**TOOLBAR**/
    'LBL_PMSE_ADAM_DESIGNER_LEADS' => 'Leads',
    'LBL_PMSE_ADAM_DESIGNER_OPPORTUNITY' => 'Affärsmöjlighet',
    'LBL_PMSE_ADAM_DESIGNER_DOCUMENTS' => 'Dokument',
    'LBL_PMSE_ADAM_DESIGNER_OTHER_MODULES' => 'Målmodul',
    'LBL_PMSE_ADAM_DESIGNER_WAIT' => 'Vänta',
    'LBL_PMSE_ADAM_DESIGNER_RECEIVE_MESSAGE' => 'Ta emot meddelande',
    'LBL_PMSE_ADAM_DESIGNER_SEND_MESSAGE' => 'Skicka meddelande',
    'LBL_PMSE_ADAM_DESIGNER_USER_TASK' => 'Aktivitet',
    'LBL_PMSE_ADAM_DESIGNER_EXCLUSIVE' => 'Exklusive',
    'LBL_PMSE_ADAM_DESIGNER_PARALLEL' => 'Parallell',
    'LBL_PMSE_ADAM_DESIGNER_COMMENT' => 'Kommentera',
    'LBL_PMSE_ADAM_DESIGNER_UNDO' => 'Ångra',
    'LBL_PMSE_ADAM_DESIGNER_REDO' => 'Gör om',
    'LBL_PMSE_ADAM_DESIGNER_SAVE' => 'Spara',
    'LBL_PMSE_ADAM_DESIGNER_VALIDATE' => 'Validera',
    'LBL_PMSE_ADAM_DESIGNER_SAVE_AND_VALIDATE' => 'Spara och validera',
    'LBL_PMSE_ADAM_DESIGNER_VIEW_ERRORS' => 'Kör validering för att söka efter fel',

    /**ELEMENTS NAMES**/
    'LBL_PMSE_ADAM_DESIGNER_TASK' => 'Aktivitet',
    'LBL_PMSE_ADAM_DESIGNER_ACTION' => 'Åtgärd',
    'LBL_PMSE_ADAM_DESIGNER_LEAD_START_EVENT' => 'Lead Starta Event',
    'LBL_PMSE_ADAM_DESIGNER_OPPORTUNITY_START_EVENT' => 'Affärsmöjlighet Starta Event' ,
    'LBL_PMSE_ADAM_DESIGNER_DOCUMENT_START_EVENT' => 'Dokument Starta Event',
    'LBL_PMSE_ADAM_DESIGNER_OTHER_MODULE_EVENT' => 'Annan Modul Event',
    'LBL_PMSE_ADAM_DESIGNER_WAIT_EVENT' => 'Vänta Event',
    'LBL_PMSE_ADAM_DESIGNER_MESSAGE_EVENT' => 'Meddelande Event',
//    'LBL_PMSE_ADAM_DESIGNER_BOUNDARY_EVENT' => 'Boundary Event',
    'LBL_PMSE_ADAM_DESIGNER_EXCLUSIVE_GATEWAY' => 'Exklusive Gateway',
    'LBL_PMSE_ADAM_DESIGNER_PARALLEL_GATEWAY' => 'Parallell Gateway',
    'LBL_PMSE_ADAM_DESIGNER_END_EVENT' => 'Avsluta Event',
    'LBL_PMSE_ADAM_DESIGNER_TEXT_ANNOTATION' => 'Textnotering',


    /**GENERAL**/
    'LBL_PMSE_MESSAGE_CANCEL_CONFIRM' => 'Inställningarna har ändrats. Vill du kasta ändringarna?',
    'LBL_PMSE_MESSAGE_REMOVE_ALL_START_CRITERIA' => 'Modulen ändras så kriterierna kommer också tas bort, eftersom det inte finns någon relation till fälten.',
    'LBL_PMSE_MESSAGE_INVALID_CONNECTION' => 'Ogiltig anslutning',

    'LBL_PMSE_CONTEXT_MENU_SETTINGS' => 'Inställningar...',
    'LBL_PMSE_CONTEXT_MENU_DELETE' => 'Radera',

    'LBL_PMSE_FORM_LABEL_MODULE' => 'Modul',
    'LBL_PMSE_FORM_LABEL_FILTER' => 'Filter',
    'LBL_PMSE_FORM_LABEL_RELATED' => 'Relaterad till',
    'LBL_PMSE_FORM_LABEL_CRITERIA' => 'Kriterie',
    'LBL_PMSE_FORM_LABEL_DURATION' => 'Varaktighet',
    'LBL_PMSE_FORM_LABEL_UNIT' => 'Enhet',

    'LBL_PMSE_FORM_OPTION_SELECT' => 'Välj...',
    'LBL_PMSE_FORM_OPTION_TARGET_MODULE' => 'Målmodul',
    'LBL_PMSE_FORM_OPTION_DAYS' => 'Dagar',
    'LBL_PMSE_FORM_OPTION_HOURS' => 'Timmar',
    'LBL_PMSE_FORM_OPTION_MINUTES' => 'Minuter',
    'LBL_PMSE_MESSAGE_CANNOTDROPOUTSIDECANVAS' => 'Kan inte släppa elementet utanför duken',
    'LBL_PMSE_FORM_TOOLTIP_DURATION' => 'Definiera varaktigheten på tidseventet',

    /**PROCESSDEFINTION**/
    // CONTEXT MENU
    'LBL_PMSE_CONTEXT_MENU_PROCESS_DEFINITION' => 'Processdefinition',
    'LBL_PMSE_CONTEXT_MENU_SAVE' => 'Spara',
    'LBL_PMSE_CONTEXT_MENU_REFRESH' => 'Uppdatera',
    'LBL_PMSE_CONTEXT_MENU_ZOOM' => 'Zooma',
    'LBL_PMSE_CONTEXT_MENU_50' => '50%',
    'LBL_PMSE_CONTEXT_MENU_75' => '75%',
    'LBL_PMSE_CONTEXT_MENU_100' => '100%',
    'LBL_PMSE_CONTEXT_MENU_125' => '125%',
    'LBL_PMSE_CONTEXT_MENU_150' => '150%',
    // FORMS
    'LBL_PMSE_LABEL_PROCESS_NAME' => 'Processnamn',
    'LBL_PMSE_LABEL_DESCRIPTION' => 'Beskrivning',
    'LBL_PMSE_LABEL_TERMINATE_PROCESS' => 'Avluta processen',
    'LBL_PMSE_LABEL_LOCKED_FIELDS' => 'Låsta fält',

    /**TASKS**/
    // CONTEXT MENU
    'LBL_PMSE_CONTEXT_MENU_FORMS' => 'Formulär...',
    'LBL_PMSE_CONTEXT_MENU_USERS' => 'Användare...',
    'LBL_PMSE_CONTEXT_MENU_ACTION_TYPE' => 'Typ av åtgärd',
    'LBL_PMSE_CONTEXT_MENU_UNASSIGNED' => '[Unassigned]',
    'LBL_PMSE_CONTEXT_MENU_BUSINESS_RULE' => 'Affärsregel',
    'LBL_PMSE_CONTEXT_MENU_ASSIGN_USER' => 'Tilldela Användare',
    'LBL_PMSE_CONTEXT_MENU_ASSIGN_TEAM' => 'Round Robin',
    'LBL_PMSE_CONTEXT_MENU_CHANGE_FIELD' => 'Ändra Fält',
    'LBL_PMSE_CONTEXT_MENU_ADD_RELATED_RECORD' => 'Lägg till relaterad record',
    // CONFIRMATIONS
    'LBL_PMSE_CHANGE_ACTION_TYPE_CONFIRMATION' => 'Om du ändrar handlingens typ kommer alla tidigare inställningar för handlingen att förloras. Vill du fortsätta?',
    // FORMS
    'LBL_PMSE_FORM_TITLE_ACTIVITY' => 'Aktivitet',
    'LBL_PMSE_FORM_LABEL_READ_ONLY_FIELDS' => 'Readonly fält',
    'LBL_PMSE_FORM_LABEL_REQUIRED_FIELDS' => 'Obligatoriska fält',
    'LBL_PMSE_FORM_LABEL_GENERAL_SETTINGS' => 'Allmän',
    'LBL_PMSE_FORM_LABEL_EXPECTED_TIME' => 'Förväntat Tid',
    'LBL_PMSE_FORM_LABEL_FORM_TYPE' => 'Formulär Typ',
    'LBL_PMSE_FORM_LABEL_RESPONSE_BUTTONS' => 'Formulär Knappar',
    'LBL_PMSE_FORM_OPTION_APPROVE_REJECT' => 'Godkänn/Avvisa',
    'LBL_PMSE_FORM_OPTION_ROUTE' => 'Dirigera',
    'LBL_PMSE_FORM_LABEL_OTHER_DERIVATION_OPTIONS' => 'Andra dirigeringsval',
    'LBL_PMSE_FORM_LABEL_RECORD_OWNERSHIP' => 'Change Record Owner',
    'LBL_PMSE_FORM_LABEL_TEAM' => 'Lag',
    'LBL_PMSE_FORM_LABEL_REASSIGN' => 'Reassigna Aktivitet',

    'LBL_PMSE_FORM_TITLE_USER_DEFINITION' => 'Användardefinition',
    'LBL_PMSE_FORM_LABEL_ASSIGNMENT_METHOD' => 'Tilldelningsmetod',
    'LBL_PMSE_FORM_OPTION_ROUND_ROBIN' => 'Round Robin',
    'LBL_PMSE_FORM_OPTION_SELF_SERVICE' => 'Självbetjäning',
    'LBL_PMSE_FORM_OPTION_STATIC_ASSIGNMENT' => 'Statisk Tilldelning',
    'LBL_PMSE_FORM_LABEL_ASSIGN_TO_TEAM' => 'Tilldela till team',
    'LBL_PMSE_FORM_LABEL_ASSIGN_TO_USER' => 'Tilldela till Användare',
    'LBL_PA_FORM_COMBO_ASSIGN_TO_USER_HELP_TEXT' => 'Välj...',
    'LBL_PA_FORM_COMBO_NO_MATCHES_FOUND' => 'Inga träffar hittades',
    'LBL_PA_FORM_LABEL_ASSIGN_TO_TEAM' => 'Välj Processanvändare från Lag',
    'LBL_PA_FORM_LABEL_ASSIGN_TO_USER' => 'Välj processanvändare',
    'LBL_PMSE_FORM_OPTION_CURRENT_USER' => 'Nuvarande användare',
    'LBL_PMSE_FORM_OPTION_RECORD_OWNER' => 'Postägare',
    'LBL_PMSE_FORM_OPTION_SUPERVISOR' => 'Handledare',
    'LBL_PMSE_FORM_OPTION_CREATED_BY_USER' => 'Skapad av användare',
    'LBL_PMSE_FORM_OPTION_LAST_MODIFIED_USER' => 'Senast redigerad av användare',

    'LBL_PMSE_FORM_TITLE_BUSINESS_RULE' => 'Affärsregel',
    'LBL_PMSE_LABEL_RULE' => 'Regel',

    'LBL_PMSE_FORM_TITLE_ASSIGN_USER' => 'Tilldela Användare',
    'LBL_PA_FORM_LABEL_UPDATE_RECORD_OWNER' => 'Uppdatera "Tilldelad" på post',

    'LBL_PMSE_FORM_TITLE_ADD_RELATED_RECORD' => 'Lägg till relaterad record',
    'LBL_PMSE_FORM_LABEL_RELATED_MODULE' => 'Relaterad modul',
    'LBL_PMSE_FORM_LABEL_FIELDS' => 'Fält',

    'LBL_PMSE_FORM_TITLE_CHANGE_FIELDS' => 'Ändra fält',

    'LBL_PMSE_FORM_TITLE_ASSIGN_TEAM' => 'Round Robin',

    'LBL_PMSE_MESSAGE_ACTIVITY_NAME_EMPTY' => 'Namnet på aktiviteten är tom:',
    'LBL_PMSE_MESSAGE_ACTIVITY_NAME_ALREADY_EXISTS' => 'Namnet "%s" finns redan.',

    /**EVENTS**/
    // CONTEXT MENU
    'LBL_PMSE_CONTEXT_MENU_ACTION' => 'Åtgärd',
    'LBL_PMSE_CONTEXT_MENU_RECEIVE_MESSAGE' => 'Ta emot meddelande',
    'LBL_PMSE_CONTEXT_MENU_SEND_MESSAGE' => 'Skicka meddelande',
    'LBL_PMSE_CONTEXT_MENU_TIMER' => 'Timer',
    'LBL_PMSE_CONTEXT_MENU_RESULT' => 'Resultat',
    'LBL_PMSE_CONTEXT_MENU_DO_NOTHING' => 'Gör ingenting',
    'LBL_PMSE_CONTEXT_MENU_TERMINATE_PROCESS' => 'Avluta processen',
    'LBL_PMSE_CONTEXT_MENU_LISTEN' => 'Lyssna',

    // FORMS
    'LBL_PMSE_FORM_TITLE_LABEL_EVENT' => 'Händelse',
    'LBL_PMSE_FORM_LABEL_APPLIES_TO' => 'Tillämpa på:',
    'LBL_PMSE_FORM_OPTION_NEW_RECORDS_ONLY' => 'Endast nya poster',
    'LBL_PMSE_FORM_OPTION_UPDATED_RECORDS_ONLY' => 'Bara uppdaterade records',
    'LBL_PMSE_FORM_OPTION_UPDATED_RECORDS_ONLY_AU' => 'Endast uppdaterade poster (Alla uppdateringar - Se hjälptext)',

    'LBL_PMSE_FORM_TOOLTIP_WHEN_START_EVENT' => 'Välj när eventet skall starta',
    'LBL_PMSE_FORM_TOOLTIP_EVENT_MODULE' => 'Välj SugarCRM-modul för att applicera händelse-trigger',

    'LBL_PMSE_FORM_LABEL_FIXED_DATE' => 'Fast Datum',

    'LBL_PMSE_FORM_LABEL_EMAIL_TEMPLATE' => 'Emailmall',

    'LBL_PMSE_FORM_LABEL_EMAIL_TO' => 'Till',
    'LBL_PMSE_FORM_LABEL_EMAIL_CC' => 'Kopia',
    'LBL_PMSE_FORM_LABEL_EMAIL_BCC' => 'Bcc',

    //ROLES IN EXPRESSION BUILDER
    'LBL_PMSE_FORM_OPTION_ADMINISTRATOR' => 'Administratör',

    /**GATEWAYS**/
    // CONTEXT MENU
    'LBL_PMSE_CONTEXT_MENU_DIRECTION' => 'Riktning...',
    'LBL_PMSE_CONTEXT_MENU_CONVERGING' => 'Konvergerande',
    'LBL_PMSE_CONTEXT_MENU_DIVERGING' => 'Divergerande',
    'LBL_PMSE_CONTEXT_MENU_CONVERT' => 'Konvertera...',
    'LBL_PMSE_CONTEXT_MENU_EXCLUSIVE_GATEWAY' => 'Exklusive Gateway',
    'LBL_PMSE_CONTEXT_MENU_PARELLEL_GATEWAY' => 'Parallell Gateway',
    'LBL_PMSE_CONTEXT_MENU_INCLUSIVE_GATEWAY' => 'Inklusive Gateway',
    'LBL_PMSE_CONTEXT_MENU_EVENT_BASED_GATEWAY' => 'Event-Baserad Gateway',
    'LBL_PMSE_CONTEXT_MENU_DEFAULT_FLOW' => 'Standardflöde',
    'LBL_PMSE_CONTEXT_MENU_NONE' => 'Ingen',

    // FORMS
    'LBL_PMSE_FORM_TITLE_GATEWAY' => 'Gateway',

    'LBL_PMSE_CONTEXT_MENU_DEFAULT_TASK' => '(Aktivitet)',
    'LBL_PMSE_CONTEXT_MENU_DEFAULT_EVENT' => '(Händelse)',
    'LBL_PMSE_CONTEXT_MENU_DEFAULT_GATEWAY' => '(Gateway)',

    'LBL_PMSE_BPMN_WARNING_PANEL_TITLE' => 'Elementfel',
    'LBL_PMSE_BPMN_WARNING_LABEL' => 'Errors',
    'LBL_PMSE_BPMN_WARNING_SINGULAR_LABEL' => 'Error',

    /**CRITERIA BUILDER**/
    'LBL_PMSE_EXPCONTROL_VARIABLES_PANEL_TITLE' => 'Fält',
    'LBL_PMSE_EXPCONTROL_MODULE_FIELD_EVALUATION_TITLE' => 'Utvärdering av modulfält',
    'LBL_PMSE_EXPCONTROL_MODULE_FIELD_EVALUATION_MODULE' => 'Modul',
    'LBL_PMSE_EXPCONTROL_MODULE_FIELD_EVALUATION_RELATED' => 'Relaterad till',
    'LBL_PMSE_EXPCONTROL_MODULE_FIELD_EVALUATION_VARIABLE' => 'Fält',
    'LBL_PMSE_EXPCONTROL_MODULE_FIELD_EVALUATION_VALUE' => 'Värde',
    'LBL_PMSE_EXPCONTROL_FORM_RESPONSE_EVALUATION_TITLE' => 'Utvärdering av formulärssvar',
    'LBL_PMSE_EXPCONTROL_FORM_RESPONSE_EVALUATION_FORM' => 'Formulär',
    'LBL_PMSE_EXPCONTROL_FORM_RESPONSE_EVALUATION_STATUS' => 'Status',
    'LBL_PMSE_EXPCONTROL_BUSINESS_RULES_EVALUATION_TITLE' => 'Affärsregel Evaluering',
    'LBL_PMSE_EXPCONTROL_BUSINESS_RULES_EVALUATION_BR' => 'Affärsregel',
    'LBL_PMSE_EXPCONTROL_BUSINESS_RULES_EVALUATION_RESPONSE' => 'Respons',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_TITLE' => 'Användarevaluering',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_USER' => 'Användare',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_CURRENT' => 'Nuvarande användare',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_SUPERVISOR' => 'Handledare',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_OWNER' => 'Postägare',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_OPERATOR' => 'Operatör',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_ADMIN' => 'är admin',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_ADMIN_FULL' => '%TARGET% är admin',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_ROLE' => 'har rollen',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_ROLE_FULL' => '%TARGET% har rollen %VALUE%',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_USER' => 'är användare',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_USER_FULL' => '%TARGET% är användare %VALUE%',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_NOT_ADMIN' => 'är inte admin',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_NOT_ADMIN_FULL' => '%TARGET% är inte admin',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_NOT_ROLE' => 'har inte rollen',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_NOT_ROLE_FULL' => '%TARGET% har inte rollen %VALUE%',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_NOT_USER' => 'är inte användare',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_IS_NOT_USER_FULL' => '%TARGET% är inte användare %VALUE%',
    'LBL_PMSE_EXPCONTROL_USER_EVALUATION_VALUE' => 'Värde',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_FIXED_DATE' => 'Fast Datum',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_FIXED_DATETIME' => 'Fast Datumtid',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TIMESPAN_TITLE' => 'Tidsintervall',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TIMESPAN_AMOUNT' => 'Värde',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TIMESPAN_UNIT' => 'Enhet',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TIMESPAN_YEARS' => 'år',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TIMESPAN_MONTHS' => 'månader',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TIMESPAN_WEEKS' => 'veckor',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TIMESPAN_DAYS' => 'dagar',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TIMESPAN_HOURS' => 'timmar',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TIMESPAN_MINUTES' => 'minuter',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_BASIC' => 'Sträng, Nummer och Boolean',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_BASIC_NUMBER' => 'Nummer',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_BASIC_VALUE' => 'Värde',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_BASIC_ADD_STRING' => 'lägg till sträng',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_BASIC_ADD_NUMBER' => 'lägg till nummer',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_BASIC_ADD_BOOLEAN' => 'lägg till boolean',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_CURRENCY' => 'Valuta',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_CURRENCY_CURRENCY' => 'Valuta',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_CURRENCY_AMOUNT' => 'Summa',
    'LBL_PMSE_EXPCONTROL_EVALUATIONS_TITLE' => 'Utvärderingar',
    'LBL_PMSE_EXPCONTROL_CONSTANTS_TITLE' => 'Konstant',
    'LBL_PMSE_EXPCONTROL_OPERATOR_MINOR_THAN' => 'är mindre än',
    'LBL_PMSE_EXPCONTROL_OPERATOR_MINOR_THAN_DATE' => 'före',
    'LBL_PMSE_EXPCONTROL_OPERATOR_MINOR_EQUAL_THAN' => 'är mindre än eller lika med',
    'LBL_PMSE_EXPCONTROL_OPERATOR_EQUAL' => 'är lika med',
    'LBL_PMSE_EXPCONTROL_OPERATOR_EQUAL_TEXT' => 'är',
    'LBL_PMSE_EXPCONTROL_OPERATOR_MAJOR_EQUAL' => 'är större än eller lika med',
    'LBL_PMSE_EXPCONTROL_OPERATOR_MAJOR' => 'är större än',
    'LBL_PMSE_EXPCONTROL_OPERATOR_MAJOR_DATE' => 'efter',
    'LBL_PMSE_EXPCONTROL_OPERATOR_STARTS_TEXT' => 'börjar med',
    'LBL_PMSE_EXPCONTROL_OPERATOR_ENDS_TEXT' => 'slutar med',
    'LBL_PMSE_EXPCONTROL_OPERATOR_CONTAINS_TEXT' => 'innehåller',
    'LBL_PMSE_EXPCONTROL_OPERATOR_NOT_CONTAINS_TEXT' => 'innehåller inte',

    'LBL_PMSE_EXPCONTROL_OPERATOR_CHANGES' => 'ändrar',
    'LBL_PMSE_EXPCONTROL_OPERATOR_CHANGES_FROM' => 'ändrar från',
    'LBL_PMSE_EXPCONTROL_OPERATOR_CHANGES_TO' => 'ändrar till',

    'LBL_PMSE_EXPCONTROL_OPERATOR_MAJOR_EQUAL_DATE' => 'på eller efter',
    'LBL_PMSE_EXPCONTROL_OPERATOR_MINOR_EQUAL_DATE' => 'på eller före',
    'LBL_PMSE_EXPCONTROL_OPERATOR_NOT_EQUAL' => 'inte är lika med',
    'LBL_PMSE_EXPCONTROL_OPERATOR_NOT_EQUAL_TEXT' => 'är inte',
    'LBL_PMSE_EXPCONTROL_OPERATOR_NOT_EQUAL_DATE' => 'är inte lika med',

    'LBL_PMSE_EXPCONTROL_ALL_RELATED_RECORDS' => 'Alla relaterade poster',
    'LBL_PMSE_EXPCONTROL_ANY_RELATED_RECORDS' => 'Relaterade poster',

    'LBL_PMSE_RUNTIME_BUTTON' => 'Löptid',

    'LBL_PMSE_FORMPANEL_SUBMIT' => 'Lägg till',
    'LBL_PMSE_FORMPANEL_CLOSE' => 'Close',

    'LBL_PMSE_EMAILPICKER_TEAMS' => 'Team',
    'LBL_PMSE_EMAILPICKER_RELATED_TO' => '%RELATED% besläktad med %MODULE%',
    'LBL_PMSE_EMAILPICKER_USER_CREATED' => 'Användaren som skapade %MODULE%',
    'LBL_PMSE_EMAILPICKER_USER_LAST_MODIFIED' => 'Användaren som senast ändrade %MODULE%',
    'LBL_PMSE_EMAILPICKER_USER_IS_ASSIGNED' => 'Användare som är tilldelad till %MODULE%',
    'LBL_PMSE_EMAILPICKER_USER_WAS_ASSIGNED' => 'Användare som var tilldelad till %MODULE%',
    'LBL_PMSE_EMAILPICKER_MANAGER_CREATED' => 'Chefen för den som skapade %MODULE%',
    'LBL_PMSE_EMAILPICKER_MANAGER_LAST_MODIFIED' => 'Chefen för den som senast ändrade %MODULE%',
    'LBL_PMSE_EMAILPICKER_MANAGER_IS_ASSIGNED' => 'Chefen för den som är tilldelad till %MODULE%',
    'LBL_PMSE_EMAILPICKER_MANAGER_WAS_ASSIGNED' => 'Chefen för den som var tilldelad till %MODULE%',
    'LBL_PMSE_EMAILPICKER_ROLE_ITEM' => 'roll: %ROLE%',
    'LBL_PMSE_EMAILPICKER_TEAM_ITEM' => 'lag: %TEAM%',
    'LBL_PMSE_EMAILPICKER_SUGGESTIONS' => 'Förslag',
    'LBL_PMSE_EMAILPICKER_RESULTS_TITLE' => '%NUMBER% förslag för "%TEXT%"',
    'LBL_PMSE_EMAILPICKER_USER_RECORD_CREATOR' => 'skapade posten',
    'LBL_PMSE_EMAILPICKER_USER_LAST_MODIFIER' => 'redigerade posten senast',
    'LBL_PMSE_EMAILPICKER_USER_IS_ASIGNEE' => 'är tilldelad posten',

    'LBL_PMSE_UPDATERFIELD_VARIABLES_LIST_TITLE' => '%MODULE% fält',
    'LBL_PMSE_UPDATERFIELD_ADD_TEAM' => 'Lägg till team...',

    //ERRORS ELEMENTS MESSAGE
    'LBL_PMSE_MESSAGE_ERROR_START_EVENT_OUTGOING' => 'Starthändelsen måste ha ett utgående sekvensflöde',
    'LBL_PMSE_MESSAGE_ERROR_END_EVENT_INCOMING' => 'Sluthändelsen måste ha ett inkommande sekvensflöde',
    'LBL_PMSE_MESSAGE_ERROR_INTERMEDIATE_EVENT_INCOMING' => 'Mellanhändelsen måste ha en eller fler inkommande sekvensflöden',
    'LBL_PMSE_MESSAGE_ERROR_INTERMEDIATE_EVENT_OUTGOING' => 'Mellanhändelsen måste ha ett utgående sekvensflöde',
    'LBL_PMSE_MESSAGE_ERROR_BOUNDARY_EVENT_OUTGOING' => 'Kanthändelsen måste ha ett utgående sekvensflöde',
    'LBL_PMSE_MESSAGE_ERROR_ACTIVITY_INCOMING' => 'Aktiviteten måste ha ett inkommande sekvensflöde',
    'LBL_PMSE_MESSAGE_ERROR_ACTIVITY_OUTGOING' => 'Aktiviteten måste ha ett utgående sekvensflöde',
    'LBL_PMSE_MESSAGE_ERROR_ACTIVITY_SCRIPT_TASK' => 'Skriptuppgiften måste ha en giltig typ skild från [Unassigned]',
    'LBL_PMSE_MESSAGE_ERROR_GATEWAY_DIVERGING_INCOMING' => 'Gatewayen kan ha ett eller fler inkommande sekvensflöden',
    'LBL_PMSE_MESSAGE_ERROR_GATEWAY_DIVERGING_OUTGOING' => 'Gatewayen måste ha två eller fler utgående sekvensflöden',
    'LBL_PMSE_MESSAGE_ERROR_GATEWAY_CONVERGING_INCOMING' => 'Gatewayen måste ha två eller fler inkommande sekvensflöden',
    'LBL_PMSE_MESSAGE_ERROR_GATEWAY_CONVERGING_OUTGOING' => 'Gatewayen kan inte ha ett utgående sekvensflöde',
    'LBL_PMSE_MESSAGE_ERROR_GATEWAY_MIXED_INCOMING' => 'Gatewayen måste ha två eller fler inkommande sekvensflöden',
    'LBL_PMSE_MESSAGE_ERROR_GATEWAY_MIXED_OUTGOING' => 'Gatewayen måste ha två eller fler utgående sekvensflöden',
    'LBL_PMSE_MESSAGE_ERROR_ANNOTATION' => 'Textannotering måste ha en associeringslinje',

    'LBL_PMSE_IMPORT_PROCESS_DEFINITION_FAILURE' => 'Misslyckades att skapa Processdefinitioner från fil',
    'LBL_PMSE_CANNOT_CONFIGURE_ADD_RELATED_RECORD' => 'Det finns inga relaterade moduler till den här målmodulen',
    'LBL_PMSE_PROJECT_NAME_EMPTY' => 'Processdefinitionsnamn är ett obligatoriskt fält och får inte vara tomt.',

    'LBL_PMSE_INVALID_EXPRESSION_SYNTAX' => 'Ogiltigt syntax i uttrycket.',
    'LBL_PMSE_MESSAGE_ERROR_CURRENCIES_MIX' => 'Can&#39;t use two different currencies in the same expression.',

    // PMSE Validation tool strings

    'LBL_PMSE_VALIDATOR_IN_PROGRESS_RETRIEVING' => 'Validera processdefinition: Hämta elementinställningar',
    'LBL_PMSE_VALIDATOR_IN_PROGRESS_VALIDATING' => 'Validera processdefinition: Validera elementinställningar',
    'LBL_PMSE_VALIDATOR_REFRESH_ERROR_LIST' => 'Uppdaterar fellistan ...',
    'LBL_PMSE_VALIDATOR_COMPLETE' => 'Validering komplett! Hittade problem: ',
    'LBL_PMSE_VALIDATOR_TOOLTIP_ISSUES' => ' problem',
    'LBL_PMSE_VALIDATOR_TOOLTIP_IN_PROGRESS' => 'Validering pågår',
    'LBL_PMSE_VALIDATOR_WARNING_INFO' => 'Varning: Processen kan stoppa vid detta element eller ha andra oavsiktliga effekter',
    'LBL_PMSE_VALIDATOR_ERROR_INFO' => 'Fel: Processen kommer att stoppa vid detta element',

    'LBL_PMSE_ERROR_UNABLE_TO_VALIDATE' => 'Kan inte validera element',

    'LBL_PMSE_ERROR_FLOW_INCOMING_MINIMUM' => 'Elementet når inte upp till minsta antal inkommande flöden',
    'LBL_PMSE_ERROR_FLOW_INCOMING_MINIMUM_INFO' => 'Detta element måste ha ett minsta antal inkommande vägar. Kontrollera antalet vägar som ansluter till detta element för att säkerställa att det minsta antalet uppnås.',

    'LBL_PMSE_ERROR_FLOW_INCOMING_MAXIMUM' => 'Elementet överstiger det maximala antalet inkommande flöden',
    'LBL_PMSE_ERROR_FLOW_INCOMING_MAXIMUM_INFO' => 'Detta element har ett maximalt antal inkommande vägar som inte får överskridas. Kontrollera antalet vägar som ansluter till detta element för att säkerställa att det maximala antalet inte överskrids.',

    'LBL_PMSE_ERROR_FLOW_OUTGOING_MINIMUM' => 'Elementet når inte upp till minsta antal utgående flöden',
    'LBL_PMSE_ERROR_FLOW_OUTGOING_MINIMUM_INFO' => 'Detta element måste ha ett minsta antal utgående vägar. Kontrollera antalet vägar som leder bort från detta element för att säkerställa att det minsta antalet uppnås.',

    'LBL_PMSE_ERROR_FLOW_OUTGOING_MAXIMUM' => 'Elementet överstiger det maximala antalet utgående flöden',
    'LBL_PMSE_ERROR_FLOW_OUTGOING_MAXIMUM_INFO' => 'Detta element har ett maximalt antal utgående vägar som inte får överskridas. Kontrollera antalet vägar som leder bort från detta element för att säkerställa att det maximala antalet inte överskrids.',

    'LBL_PMSE_ERROR_FIELD_REQUIRED' => 'Det erforderliga fältet är inte inställt',
    'LBL_PMSE_ERROR_FIELD_REQUIRED_INFO' => 'Detta element har ett fält som krävs, men har inte ställts in. Kontrollera elementinställningarna för att säkerställa att fältet har angetts korrekt, se sedan till att klicka på knappen ”Spara”.',

    'LBL_PMSE_ERROR_DATA_NOT_FOUND' => 'Data finns inte för närvarande i systemet',
    'LBL_PMSE_ERROR_DATA_NOT_FOUND_INFO' => 'Inställningarna för detta element refererar till en specifik bit data som inte finns i databasen. Kontrollera inställningarna för elementet för att se till att alla data som det refereras till finns (dvs specifika användare, modul fält, grupper, etc.).',

    'LBL_PMSE_ERROR_LOGIC_IMPOSSIBLE' => 'Uttrycket för villkorsrutan kommer aldrig att utvärderas till sant',
    'LBL_PMSE_ERROR_LOGIC_IMPOSSIBLE_INFO' => 'Villkorsrutor innehåller logiska AND/OR/NOT uttryck. Detta fel innebär att en villkorsruta i elementinställningarna har konfigurerats så att uttrycket aldrig blir sant. Markera villkorsrutan för att eliminera eventuella logiska motsägelser som hindrar uttrycket från vara sant.',

    'LBL_PMSE_ERROR_ELEMENT_UNREACHABLE' => 'Elementet kan inte nås',
    'LBL_PMSE_ERROR_ELEMENT_UNREACHABLE_INFO' => 'För att ett element ska utföras i en process, måste den ha en väg ansluten till den. Kedjan av vägar som leder till detta element måste börja med ett startelement. Kontrollera kedjan av inkommande sökvägar till detta element att se till att kedjan börjar med ett startelement.',

    'LBL_PMSE_ERROR_WAIT_EVENT_ONE_DATETIME' => 'Väntetidskriterier måste innehålla exakt en dagtidkonstant',
    'LBL_PMSE_ERROR_WAIT_EVENT_ONE_DATETIME_INFO' => 'Detta väntehändelseelement har konfigurerats med hjälp av villkorsrutan ”fast datum”. Detta fält måste innehålla exakt en ”fast Dagtid”-konstant eller dagtid fältreferens. Alla andra delar av uttrycket måste vara matematikoperatorer (+/-) och ”tidsintervall”-konstanter.',

    'LBL_PMSE_ERROR_WAIT_EVENT_ZERO_DURATION' => 'Värdet för varaktighet får inte anges till noll',
    'LBL_PMSE_ERROR_WAIT_EVENT_ZERO_DURATION_INFO' => 'Detta väntehändelseelement har konfigurerats med inställningen ”varaktighet”. Den här inställningen får inte vara lika med noll, då uppstår ett fel. Kontrollera inställningarna för elementet för att säkerställa att ”varaktighet” inte är inställd på noll.',

    'LBL_PMSE_ERROR_WAIT_EVENT_NO_PARAMETERS' => 'Väntetidsparametrar har inte ställts in',
    'LBL_PMSE_ERROR_WAIT_EVENT_NO_PARAMETERS_INFO' => 'Väntehändelseelementet har inte några inställningar som konfigurerats. Kontrollera inställningarna för elementet att se till att ”varaktighet” eller ”fast datum” är markerade, ange värden som önskas och klicka på knappen ”Spara”.',

    'LBL_PMSE_ERROR_ACTIVITY_EXPECTED_TIME' => 'Förväntad tid är mindre än noll',
    'LBL_PMSE_ERROR_ACTIVITY_EXPECTED_TIME_INFO' => 'Under ”blanketter”-inställningarna för detta aktivitetselement sätts förväntad tid till ett negativt värde, vilket gör att processen fryser när den når elementet. Öppna ”formulär”-inställningar för det här elementet om du vill ändra förväntad tid till ett icke-negativt tal.',

    'LBL_PMSE_ERROR_ACTION_UNASSIGNED' => 'Händelsetyp är [Unassigned]',
    'LBL_PMSE_ERROR_ACTION_UNASSIGNED_INFO' => 'Detta händelseelement har inte en bestämd typ. Detta kan ändras genom högerklickning på händelseelementet från listan "händelsetyp".',

    'LBL_PMSE_ERROR_GATEWAY_NO_GUARANTEED_PATH' => 'Att en viss väg tas garanteras inte',
    'LBL_PMSE_ERROR_GATEWAY_NO_GUARANTEED_PATH_INFO' => 'Detta felmeddelande inträffar för att det finns en möjlighet att ingen av vägarna ut ur detta gateway-element kommer att användas, vilket kan leda till att processen stoppas. Det är rekommenderat att ställa in en standardväg att använda ifall inga av uttrycken för villkorsrutorna i elementinställningarna uppfylls. Det kan göras genom att högerklicka på gateway-elementet och välja ett element under menyn "standardflöde". Om en standardväg inte har angetts ska uttrycken för villkorsrutan ändras för att säkerställa att åtminstone en av dem ska vara sann när processen körs.',

    'LBL_PMSE_ERROR_GATEWAY_CONVERGING_TYPE_MISMATCH' => 'Konvergerande gateway-typ matchar int gateway-typen för det inkommande flödet',
    'LBL_PMSE_ERROR_GATEWAY_CONVERGING_TYPE_MISMATCH_INFO' => 'Divergerande gateways expanderar processer till ett flertal grenar. När man använder en konvergerande gateway för att omkonvergera dessa grenar tillbaka till en väg måste rätt typ av konvergerande gateway användas, beroende på typen av divergerande gateway som använts för att skapa grenarna. För grenar som skapats med exklusiva eller händelsebaserade gateways, använd en exklusiv konvergerande gateway för att omkonvergera dem. För grenar skapade med parallella eller inkluderande divergerande gateways, använd en parallell konvergerande gateway för att omkonvergera dem.',
);
