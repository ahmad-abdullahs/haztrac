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
$mod_strings = array(
	'DESC_MODULES_INSTALLED'					=> 'Die folgenden Module wurden installiert:',
	'DESC_MODULES_QUEUED'						=> 'Die folgenden Module können installiert werden:',

	'ERR_UW_CANNOT_DETERMINE_GROUP'				=> 'Gruppe kann nicht bestimmt werden',
	'ERR_UW_CANNOT_DETERMINE_USER'				=> 'Besitzer kann nicht bestimmt werden',
	'ERR_UW_CONFIG_WRITE'						=> 'Fehler beim Aktualisieren der config.php mit neuen Versionsinformationen.',
	'ERR_UW_CONFIG'								=> 'Bitte konfigurieren Sie Schreibrechte für die config.php-Datei und laden Sie diese Seite erneut.',
	'ERR_UW_DIR_NOT_WRITABLE'					=> 'Verzeichnis nicht beschreibbar',
	'ERR_UW_FILE_NOT_COPIED'					=> 'Datei nicht kopiert',
	'ERR_UW_FILE_NOT_DELETED'					=> 'Problem beim Entfernen eines Paketes',
	'ERR_UW_FILE_NOT_READABLE'					=> 'Datei kann nicht gelesen werden.',
	'ERR_UW_FILE_NOT_WRITABLE'					=> 'Datei kann nicht verschoben oder geschrieben werden',
	'ERR_UW_FLAVOR_2'							=> 'Upgrade-Edition: ',
	'ERR_UW_FLAVOR'								=> 'SugarCRM-System-Edition: ',
	'ERR_UW_LOG_FILE_UNWRITABLE'				=> './upgradeWizard.log konnte nicht erstellt/geschrieben werden. Bitte überprüfen Sie die Berechtigungen in Ihrem Sugar-Verzeichnis.',
    'ERR_UW_MBSTRING_FUNC_OVERLOAD'				=> 'mbstring.func_overload ist höher als 1.<br/>Bitte in der php.ini ändern und danach den Webserver neu starten.',
	'ERR_UW_MYSQL_VERSION'						=> 'SugarCRM benötigt MySQL Version 4.1.2 oder neuer. Gefunden:',
	'ERR_UW_OCI8_VERSION'				        => 'Ihre Oracle Version ist mit Sugar nicht kompatibel. Bitte eine kompatible Version installieren. Bitte die Compatabilty Matrix in der Release Notes anschauen. Aktuelle Version: ',
	'ERR_UW_NO_FILE_UPLOADED'					=> 'Bitte geben Sie eine Datei an und versuchen Sie es erneut!',
	'ERR_UW_NO_FILES'							=> 'Ein Fehler ist aufgetreten; keine Dateien für die Überprüfung gefunden.',
	'ERR_UW_NO_MANIFEST'						=> 'In der zip-Datei fehlt manifest.php. Kann nicht fortsetzen.',
	'ERR_UW_NO_VIEW'							=> 'Ungültige Ansicht angegeben.',
	'ERR_UW_NO_VIEW2'							=> 'Ansicht nicht definiert. Bitte gehen Sie auf die Startseite für Administration, um auf diese Seite zu gelangen.',
	'ERR_UW_NOT_VALID_UPLOAD'					=> 'Ungültiger Upload.',
	'ERR_UW_NO_CREATE_TMP_DIR'					=> 'Das temporäre Verzeichnis konnte nicht erstellt werden. Dateiberechtigungen überprüfen.',
	'ERR_UW_ONLY_PATCHES'						=> 'Auf dieser Seite können Sie nur Patches hochladen.',
    'ERR_UW_PREFLIGHT_ERRORS'					=> 'Fehler gefunden während den letzten Kontrollen',
	'ERR_UW_UPLOAD_ERR'							=> 'Beim Upload der Datei ist ein Fehler aufgetreten; bitte versuchen Sie es erneut!<br>\n',
	'ERR_UW_VERSION'							=> 'SugarCRM-System-Version: ',
    'ERR_UW_WRONG_TYPE'							=> 'Diese Seite dient nicht der Ausführung ',
	'ERR_UW_PHP_FILE_ERRORS'					=> array(
													1 => 'Die hochgeladene Datei ist größer als upload_max_filesize in php.ini.',
													2 => 'Die hochgeladene Datei ist größer als die MAX_FILE_SIZE Direktive, die im HTML-Fomular angegeben wurde.',
													3 => 'Die hochgeladene Datei wurde nur teilweise hochgeladen.',
													4 => 'Keine Datei hochgeladen.',
													5 => 'Unbekannter Fehler.',
													6 => 'Ein temporäres Verzeichnis fehlt.',
													7 => 'Datei konnte nicht geschrieben werden.',
													8 => 'Datei-Upload gestoppt wegen Dateierweiterung.',
),

    'ERROR_HT_NO_WRITE'                         => 'Datei: %s kann nicht geschrieben werden',
    'ERROR_MANIFEST_TYPE'                       => 'Die Manifest-Datei muss den Typ der Anwendung spezifizieren.',
    'ERROR_PACKAGE_TYPE'                        => 'Manifest-Datei spezifiziert einen unbekannten Anwendungstyp: %s',
    'ERROR_VERSION_INCOMPATIBLE'                => 'Die geladene Datei ist nicht mit dieser Sugar Version kompatibel:',
    'ERROR_FLAVOR_INCOMPATIBLE'                 => 'Die hochgeladene Datei ist nicht kompatibel mit dieser Sugar-Edition (Professional, Enterprise oder Ultimate): %s',

    'ERROR_UW_CONFIG_DB'                        => 'Fehler beim Abspeichern des Konfigurationswertes %s in die Datenbank (key %s, value %s).',
    'ERR_NOT_ADMIN'                             => "Nicht authorisierter Zugriff auf die Administration",
    'ERR_NO_VIEW_ACCESS_REASON'                 => 'Sie haben nicht die entsprechenden Benutzerrechte um diese Seite zu sehen',

    'LBL_BUTTON_BACK'							=> 'Zurück',
	'LBL_BUTTON_CANCEL'							=> 'Abbrechen',
	'LBL_BUTTON_DELETE'							=> 'Paket löschen',
	'LBL_BUTTON_DONE'							=> 'Fertig',
	'LBL_BUTTON_EXIT'							=> 'Abmelden',
	'LBL_BUTTON_INSTALL'						=> 'Vorprüfung vor Upgrade',
	'LBL_BUTTON_NEXT'							=> 'Weiter',
	'LBL_BUTTON_RECHECK'						=> 'Nachprüfung',
	'LBL_BUTTON_RESTART'						=> 'Neustart',

	'LBL_UPLOAD_UPGRADE'						=> 'Upgrade-Paket hochladen ',
	'LBL_UPLOAD_FILE_NOT_FOUND'					=> 'Upload-Datei nicht gefunden',
	'LBL_UW_BACKUP_FILES_EXIST_TITLE'			=> 'Datei-Backup',
	'LBL_UW_BACKUP_FILES_EXIST'					=> 'Gesicherte Dateien von diesem Upgrade finden Sie in',
	'LBL_UW_BACKUP'								=> 'Datei-Backup',
	'LBL_UW_CANCEL_DESC'						=> 'Der Upgrade-Assistent wurde abgebrochen. Alle temporären Dateien und die hochgeladene Upgrade-Dateien wurden gelöscht.',
	'LBL_UW_CHARSET_SCHEMA_CHANGE'				=> 'Zeichensatz-Schema-Änderungen',
	'LBL_UW_CHECK_ALL'							=> 'Alle markieren',
	'LBL_UW_CHECKLIST'							=> 'Upgrade-Schritte',
	'LBL_UW_COMMIT_ADD_TASK_DESC_1'				=> "Die Sicherheitskopien der überschriebenen Dateien sind in folgendem Verzeichnis:\n",
	'LBL_UW_COMMIT_ADD_TASK_DESC_2'				=> "Führen Sie die folgenden Dateien manuell zusammen:",
	'LBL_UW_COMMIT_ADD_TASK_NAME'				=> 'Upgrade-Prozess: Dateien manuell zusammenführen',
	'LBL_UW_COMMIT_ADD_TASK_OVERVIEW'			=> 'Bitte benutzen Sie eine vertraute Methode, um diese Dateien zusammenzuführen. Bis dieser Schritt fertig ist, ist Ihre SugarCRM-Installation in einem instabilen Zustand und die Aktualisierung ist nicht beendet.',
	'LBL_UW_COMPLETE'							=> 'Fertig',
	'LBL_UW_CONTINUE_CONFIRMATION'              => 'Diese Sugar-Version enthält eine neue Lizenzvereinbarung. Möchten Sie fortfahren?',
	'LBL_UW_COMPLIANCE_ALL_OK'					=> 'Alle erforderlichen Systemeinstellungen erfüllt',
	'LBL_UW_COMPLIANCE_CALLTIME'				=> 'PHP-Einstellungen: Zeit-Pass-Abruf nach Referenz',
	'LBL_UW_COMPLIANCE_CURL'					=> 'cURL-Modul',
	'LBL_UW_COMPLIANCE_IMAP'					=> 'IMAP-Modul',
	'LBL_UW_COMPLIANCE_MBSTRING'				=> 'MBStrings-Modul',
	'LBL_UW_COMPLIANCE_MBSTRING_FUNC_OVERLOAD'	=> 'Parameter MBStrings func_overload',
	'LBL_UW_COMPLIANCE_MEMORY'					=> 'PHP-Einstellungen: Speicherlimit',
    'LBL_UW_COMPLIANCE_STREAM'                  => 'PHP-Einstellungen: Stream',
	'LBL_UW_COMPLIANCE_MSSQL_MAGIC_QUOTES'		=> 'MS SQL Server & PHP Magic Quotes GPC',
	'LBL_UW_COMPLIANCE_MYSQL'					=> 'Mindest-MySQL-Version',
    'LBL_UW_COMPLIANCE_DB'                      => 'Mindest-Datenbankversion',
	'LBL_UW_COMPLIANCE_PHP_INI'					=> 'Speicherort von php.ini',
    'LBL_UW_COMPLIANCE_PHP_VERSION'             => 'PHP-Version',
	'LBL_UW_COMPLIANCE_SAFEMODE'				=> 'PHP-Einstellungen: Sicherer Modus',
	'LBL_UW_COMPLIANCE_TITLE'					=> 'Überprüfung der Servereinstellungen',
	'LBL_UW_COMPLIANCE_TITLE2'					=> 'Gefundene Einstellungen',
	'LBL_UW_COMPLIANCE_XML'						=> 'XML-Parsing',
    'LBL_UW_COMPLIANCE_ZIPARCHIVE'				=> 'Zip-Unterstützung',

	'LBL_UW_COPIED_FILES_TITLE'					=> 'Dateien erfolgreich kopiert',
	'LBL_UW_CUSTOM_TABLE_SCHEMA_CHANGE'			=> 'Benutzerdefinierte Tabellen-Schemenänderungen',

	'LBL_UW_DB_CHOICE1'							=> 'Upgrade-Assistent führt SQL aus',
	'LBL_UW_DB_CHOICE2'							=> 'Manuelle SQL-Abfragen',
	'LBL_UW_DB_INSERT_FAILED'					=> 'EINFÜGEN fehlgeschlagen - verglichene Resultate unterschiedlich',
	'LBL_UW_DB_ISSUES_PERMS'					=> 'Datenbank-Berechtigungen',
	'LBL_UW_DB_ISSUES'							=> 'Datenbank-Probleme',
	'LBL_UW_DB_METHOD'							=> 'Datenbank-Update-Methode',
	'LBL_UW_DB_NO_ADD_COLUMN'					=> 'TABELLE VERÄNDERN [table] SPALTE HINZUFÜGEN [column]',
	'LBL_UW_DB_NO_CHANGE_COLUMN'				=> 'TABELLE VERÄNDERN [table] SPALTE ÄNDERN [column]',
	'LBL_UW_DB_NO_CREATE'						=> 'TABELLE ERSTELLEN [table]',
	'LBL_UW_DB_NO_DELETE'						=> 'FORMULAR LÖSCHEN [table]',
	'LBL_UW_DB_NO_DROP_COLUMN'					=> 'TABELLE VERÄNDERN [table] SPALTE WEGLASSEN [column]',
	'LBL_UW_DB_NO_DROP_TABLE'					=> 'TABELLE WEGLASSEN [table]',
	'LBL_UW_DB_NO_ERRORS'						=> 'Alle Berechtigungen verfügbar',
	'LBL_UW_DB_NO_INSERT'						=> 'EINFÜGEN IN [table]',
	'LBL_UW_DB_NO_SELECT'						=> 'AUSWÄHLEN [x] AUS [table]',
	'LBL_UW_DB_NO_UPDATE'						=> 'AKTUALISIEREN [table]',
	'LBL_UW_DB_PERMS'							=> 'Notwendige Berechtigungen',

	'LBL_UW_DESC_MODULES_INSTALLED'				=> 'Die folgenden Upgrade-Pakete wurden installiert:',
	'LBL_UW_END_DESC'							=> 'Herzlichen Glückwunsch! Ihr System ist auf dem neuesten Stand.',
	'LBL_UW_END_DESC2'							=> 'Falls Sie einige Schritte manuell durchzuführen - wie Dateizusammenführungen oder SQL-Abfragen - tun Sie dies jetzt. Ihr System ist in einem instabilen Zustand, bis Sie diese Schritte durchgeführt haben.',
	'LBL_UW_END_LOGOUT_PRE'						=> 'Der Update wurde fertiggestellt.',
	'LBL_UW_END_LOGOUT_PRE2'					=> '"Fertig" auswählen, um den Update-Assistent zu verlassen.',
	'LBL_UW_END_LOGOUT'							=> 'Wenn Sie ein weiteres Upgrade-Paket mit dem Upgrade-Assistenten anwenden möchten, melden Sie sich davor ab und wieder an.',
	'LBL_UW_END_LOGOUT2'						=> 'Abmelden',
	'LBL_UW_REPAIR_INDEX'						=> 'Für eine verbesserte Leistung der Datenbank, führen Sie bitte den Skript <a href="index.php?module=Administration&action=RepairIndex" target="_blank">Index reparieren</a> aus.',

	'LBL_UW_FILE_DELETED'						=> "wurde entfernt.<br>",
	'LBL_UW_FILE_GROUP'							=> 'Gruppe',
	'LBL_UW_FILE_ISSUES_PERMS'					=> 'Dateiberechtigungen',
	'LBL_UW_FILE_ISSUES'						=> 'Dateifehler',
	'LBL_UW_FILE_NEEDS_DIFF'					=> 'Datei benötigt manuellen Vergleich',
	'LBL_UW_FILE_NO_ERRORS'						=> '<b>Alle Dateien schreibbar</b>',
	'LBL_UW_FILE_OWNER'							=> 'Eigentümer',
	'LBL_UW_FILE_PERMS'							=> 'Berechtigungen',
	'LBL_UW_FILE_UPLOADED'						=> 'wurde hochgeladen',
	'LBL_UW_FILE'								=> 'Dateiname',
	'LBL_UW_FILES_QUEUED'						=> 'Die folgenden Upgrades können lokal installiert werden:',
	'LBL_UW_FILES_REMOVED'						=> "Die folgenden Dateien werden aus dem System entfernt:<br>\n",
	'LBL_UW_NEXT_TO_UPLOAD'						=> "<b>Klicken Sie auf \"Weiter\", um die Upgrade-Pakete hochzuladen.</b>",
	'LBL_UW_FROZEN'								=> 'Laden Sie ein Paket hoch, bevor Sie den Vorgang fortsetzen.',
	'LBL_UW_HIDE_DETAILS'						=> 'Details ausblenden',
	'LBL_UW_IN_PROGRESS'						=> 'In Bearbeitung',
	'LBL_UW_INCLUDING'							=> 'Einschließend',
	'LBL_UW_INCOMPLETE'							=> 'Unvollständig',
	'LBL_UW_INSTALL'							=> 'Datei INSTALL',
	'LBL_UW_MANUAL_MERGE'						=> 'Datei zusammenführen',
	'LBL_UW_MODULE_READY_UNINSTALL'				=> "Das Modul kann nun deinstalliert werden. Klicken Sie auf \"Bestätigen\", um mit der Installation fortzufahren.<br>\n",
	'LBL_UW_MODULE_READY'						=> "Das Modul kann nun installiert werden. Klicken Sie auf \"Bestätigen\", um mit der Installation fortzufahren.",
	'LBL_UW_NO_INSTALLED_UPGRADES'				=> 'Keine aufgezeichneten Upgrades gefunden.',
	'LBL_UW_NONE'								=> 'Kein(e)',
	'LBL_UW_NOT_AVAILABLE'						=> 'Nicht verfügbar',
	'LBL_UW_OVERWRITE_DESC'						=> "Alle geänderten Dateien werden überschrieben - inklusive allfälliger Anpassungen am Code und an den Vorlagen. Sind Sie sicher, dass Sie fortfahren möchten?",
	'LBL_UW_OVERWRITE_FILES_CHOICE1'			=> 'Alle Dateien überschreiben',
	'LBL_UW_OVERWRITE_FILES_CHOICE2'			=> 'Manuelles Zusammenführen - Alle beibehalten',
	'LBL_UW_OVERWRITE_FILES'					=> 'Zusammenführungsmethode',
	'LBL_UW_PATCH_READY'						=> 'Der Patch ist bereit. Klicken Sie auf "Bestätigen", um den Aktualisierungsprozess abzuschließen.',
	'LBL_UW_PATCH_READY2'						=> '<h2>Hinweis: Angepasste Layouts gefunden</h2><br />Die folgende(n) Datei(en) besitzen neue Felder oder es wurden im Studio Layouts verändert. Der Patch den Sie gerade installieren enthält Änderungen für diese Datei(en). Für <u>jede Datei</u> können Sie:<br><ul><li>[<b>Standard</b>] Behalten Sie Ihre Version in dem Sie das Kästchen nicht anhaken. Die Modifikationen durch den Patch werden ignoriert.</li>oder<li>Akzeptieren Sie die Änderungen in dem Sie das Kästchen markieren. Ihre Layouts müssen im Studio angepasst werden.</li></ul>',

	'LBL_UW_PREFLIGHT_ADD_TASK'					=> 'Aufgabe für manuelles Zusammenführen erstellen?',
	'LBL_UW_PREFLIGHT_COMPLETE'					=> 'Letzte Kontrollen',
	'LBL_UW_PREFLIGHT_DIFF'						=> 'Differenziert',
	'LBL_UW_PREFLIGHT_EMAIL_REMINDER'			=> 'Sich selbst eine Erinnerung für das manuelle Zusammenführen e-mailen?',
	'LBL_UW_PREFLIGHT_FILES_DESC'				=> 'Die unten angeführten Dateien wurden verändert. Entfernen SIe die Markierung bei Positionen die einen manuellen Abgleich erfordern. <i>Gefundene Änderungen an Layouts werden automatisch deaktiviert; wählen Sie die aus, die überschrieben werden sollen.',
	'LBL_UW_PREFLIGHT_NO_DIFFS'					=> 'Keine manuelle Dateizusammenführung erforderlich.',
	'LBL_UW_PREFLIGHT_NOT_NEEDED'				=> 'Nicht benötigt.',
	'LBL_UW_PREFLIGHT_PRESERVE_FILES'			=> 'Automatisch beibehaltene Dateien:',
	'LBL_UW_PREFLIGHT_TESTS_PASSED'				=> 'Alle Kontrollen erfolgreich bestanden.',
	'LBL_UW_PREFLIGHT_TESTS_PASSED2'			=> 'Drücken Sie auf "Weiter", um die aktualisierten Dateien auf das System zu kopieren.',
	'LBL_UW_PREFLIGHT_TESTS_PASSED3'			=> '<b>Hinweis: </b> Der gesamte Upgrade-Prozess ist verpflichtend durchzuführen. Wenn Sie nicht fortfahren möchten, klicken Sie auf "Abbrechen".',
	'LBL_UW_PREFLIGHT_TOGGLE_ALL'				=> 'Alle Dateien anzeigen/ausblenden',

	'LBL_UW_REBUILD_TITLE'						=> 'Resultat neu berechnen',
	'LBL_UW_SCHEMA_CHANGE'						=> 'Schema-Änderungen',

	'LBL_UW_SHOW_COMPLIANCE'					=> 'Gefundene Einstellungen anzeigen',
	'LBL_UW_SHOW_DB_PERMS'						=> 'Fehlende Datenbanknerechtigungen anzeigen',
	'LBL_UW_SHOW_DETAILS'						=> 'Details zeigen',
	'LBL_UW_SHOW_DIFFS'							=> 'Dateien anzeigen, die manuell zusammengeführt werden müssen',
	'LBL_UW_SHOW_NW_FILES'						=> 'Dateien mit falschen Berechtigungen anzeigen',
	'LBL_UW_SHOW_SCHEMA'						=> 'Schema für Änderungsskript anzeigen',
	'LBL_UW_SHOW_SQL_ERRORS'					=> 'Falsche Abfragen anzeigen',
	'LBL_UW_SHOW'								=> 'Anzeigen',

	'LBL_UW_SKIPPED_FILES_TITLE'				=> 'Übersprungene Dateien',
	'LBL_UW_SKIPPING_FILE_OVERWRITE'			=> 'Datei-Überschreibungen übersprungen - Manuelle Zusammenführung gewählt.',
	'LBL_UW_SQL_RUN'							=> 'Überprüfen Sie, wann SQL manuell gelaufen ist',
	'LBL_UW_START_DESC'							=> 'Dieser Assistent hilft Ihnen beim Aktualisieren Ihrer Sugar-Instanz.',
	'LBL_UW_START_DESC2'						=> 'Hinweis: Wir empfehlen dringend, die Aktualisierung auf einer geklonten Instanz des Produktionservers durchzuführen. Bitte sichern Sie die Datenbank und die Systemdateien (alle Dateien im SugarCRM Verzeichnis), bevor Sie die Aktualisierung durchführen.',
	'LBL_UW_START_DESC3'						=> 'Um die Systemprüfung für den Upgrade durchzuführen, drücken Sie auf "Weiter". Die Prüfung umfasst Zugriffsberechtigungen, Datenbankrechte und Servereinstellungen.',
	'LBL_UW_START_UPGRADED_UW_DESC'				=> 'Der neue Upgrade-Assistent wird nun den Aktualisierungsprozess fortsetzen.',
	'LBL_UW_START_UPGRADED_UW_TITLE'			=> 'Willkommen beim neuen Upgrade-Assistent',

	'LBL_UW_SYSTEM_CHECK_CHECKING'				=> 'Die Überprüfung läuft, bitte um etwas Geduld. Dies kann bis zu 30 Sekunden dauern.',
	'LBL_UW_SYSTEM_CHECK_FILE_CHECK_START'		=> 'Die passenden Dateien für die Überprüfung werden gesucht.',
	'LBL_UW_SYSTEM_CHECK_FILES'					=> 'Dateien',
	'LBL_UW_SYSTEM_CHECK_FOUND'					=> 'Gefunden',

	'LBL_UW_TITLE_CANCEL'						=> 'Abbrechen',
	'LBL_UW_TITLE_COMMIT'						=> 'Upgrade bestätigen',
	'LBL_UW_TITLE_END'							=> 'Nachkontrolle',
	'LBL_UW_TITLE_PREFLIGHT'					=> 'Letzte Kontrollen',
	'LBL_UW_TITLE_START'						=> 'Willkommen',
	'LBL_UW_TITLE_SYSTEM_CHECK'					=> 'System-Überprüfungen',
	'LBL_UW_TITLE_UPLOAD'						=> 'Paket hochladen',
	'LBL_UW_TITLE'								=> 'Upgrade-Assistent',
	'LBL_UW_UNINSTALL'							=> 'Deinstallieren',
	//500 upgrade labels
	'LBL_UW_ACCEPT_THE_LICENSE' 				=> 'Lizenz akzeptieren',
	'LBL_UW_CONVERT_THE_LICENSE' 				=> 'Lizenz umwandeln',
	'LBL_UW_CUSTOMIZED_OR_UPGRADED_MODULES'     => 'Upgrade/benutzerdefinierte Module',
	'LBL_UW_FOLLOWING_MODULES_CUSTOMIZED'       => 'Die folgende Module wurden als benutzerdefiniert erkannt nud werden beibehalten',
	'LBL_UW_FOLLOWING_MODULES_UPGRADED'         => 'Die folgende Module sind mit Studio angepasst worden und wurden aktualisiert',

	'LBL_START_UPGRADE_IN_PROGRESS'             => 'Der Vorgang wird gestartet',
	'LBL_SYSTEM_CHECKS_IN_PROGRESS'             => 'Das System wird überprüft',
	'LBL_LICENSE_CHECK_IN_PROGRESS'             => 'Die Lizenzen werden überprüft',
	'LBL_PREFLIGHT_CHECK_IN_PROGRESS'           => 'Vorprüfung in Bearbeitung',
    'LBL_PREFLIGHT_FILE_COPYING_PROGRESS'       => 'Die Dateien werden kopiert',
	'LBL_COMMIT_UPGRADE_IN_PROGRESS'            => 'Das Upgrade wird bestätigt',
    'LBL_UW_COMMIT_DESC'						=> 'Für zusätzliche Upgrade-Scripts, klicken Sie auf Weiter.',
	'LBL_UPGRADE_SCRIPTS_IN_PROGRESS'			=> 'Die Scripts werden aktualisiert',
	'LBL_UPGRADE_SUMMARY_IN_PROGRESS'			=> 'Upgrade-Zusammenfassung wird erstellt',
	'LBL_UPGRADE_IN_PROGRESS'                   => 'in Bearbeitung',
	'LBL_UPGRADE_TIME_ELAPSED'                  => 'Vergangene Zeit',
	'LBL_UPGRADE_CANCEL_IN_PROGRESS'			=> 'Upgrade wird abgebrochen und das System bereinigt',
    'LBL_UPGRADE_TAKES_TIME_HAVE_PATIENCE'      => 'Das Upgrade kann einige Zeit dauern',
    'LBL_UPLOADE_UPGRADE_IN_PROGRESS'           => 'Upload-Überprüfungen in Bearbeitung',
	'LBL_UPLOADING_UPGRADE_PACKAGE'      		=> 'Upgrade-Paket wird hochgeladen',
    'LBL_UW_DORP_THE_OLD_SCHMEA' 				=> 'Möchten Sie, dass Sugar die alten 451 Schemata entfernt?',
	'LBL_UW_DROP_SCHEMA_UPGRADE_WIZARD'			=> 'Durch den Upgrade-Assistent wird das alte 451 Schema entfernt',
	'LBL_UW_DROP_SCHEMA_MANUAL'					=> 'Manuelles Drop-Schema Post-Upgrade',
	'LBL_UW_DROP_SCHEMA_METHOD'					=> 'Altes Schema Löschmethode',
	'LBL_UW_SHOW_OLD_SCHEMA_TO_DROP'			=> 'Zeige altes Schema, das entfernt werden kann',
	'LBL_UW_SKIPPED_QUERIES_ALREADY_EXIST'      => 'Übersprungene Abfragen',
	'ERR_CHECKSYS_PHP_INVALID_VER'      => 'Ihre PHP-Version wird von Sugar nicht unterstützt. Sie müssen eine kompatible Version installieren. Bitte überprüfen Sie dazu die Kompatibilitätsmatrix in den Versionshinweisen. Ihre Version ist ',
	'LBL_BACKWARD_COMPATIBILITY_ON' 			=> 'Der PHP-Rückwärts-Kompatibilitätsmodus ist eingeschaltet. Deaktivieren Sie den Modus "zend.ze1_compatibility_mode", um fortzufahren',
	//including some strings from moduleinstall that are used in Upgrade
	'LBL_ML_ACTION' => 'Aktion',
    'LBL_ML_CANCEL'             => 'Abbrechen',
    'LBL_ML_COMMIT'=>'Bestätigen',
    'LBL_ML_DESCRIPTION' => 'Beschreibung',
    'LBL_ML_INSTALLED' => 'Installiert am',
    'LBL_ML_NAME' => 'Name',
    'LBL_ML_PUBLISHED' => 'Veröffentlicht am',
    'LBL_ML_TYPE' => 'Typ',
    'LBL_ML_UNINSTALLABLE' => 'Deinstallierbar',
    'LBL_ML_VERSION' => 'Version',
	'LBL_ML_INSTALL'=>'Installieren',
	//adding the string used in tracker. copying from homepage
	'LBL_HOME_PAGE_4_NAME' => 'Tracker',
	'LBL_MODULE_NAME' => 'Upgrade-Assistent',
	'LBL_MODULE_NAME_SINGULAR' => 'Upgrade-Assistent',
	'LBL_UPLOAD_SUCCESS' => 'Das Upgrade-Paket wurde erfolgreich geladen. Klicken Sie auf "Weiter" für die finale Überprüfung.',
	'LBL_UW_TITLE_LAYOUTS' => 'Layouts bestätigen',
	'LBL_LAYOUT_MODULE_TITLE' => 'Layouts',
	'LBL_LAYOUT_MERGE_DESC' => 'Als Bestandteil des Upgrades wurden neue Felder hinzugefügt und können automatisch zu den existierenden Layouts/Masken angefügt werden. Nähere Informationen über die hinzugefügten Felder entnehmen Sie bitte den Versionshinweisen.<br><br>Sollten Sie die neuen Felder nicht hinzugefügt werden, heben Sie bitte die Markierung des entsprechenden Moduls auf, und Ihre Layouts/Masken bleiben unverändert. Die Felder sind nach dem Upgrade in Studio verfügbar. <br><br>',
	'LBL_LAYOUT_MERGE_TITLE' => 'Bestätigen Sie die Änderungen mit "Weiter", um das Upgrade zu finalisieren.',
	'LBL_LAYOUT_MERGE_TITLE2' => 'Klicken Sie auf "Weiter", um das Upgrade zu finalisieren.',
	'LBL_UW_CONFIRM_LAYOUTS' => 'Bestätigen der Layouts',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS' => 'Layout-Resultate bestätigen',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS_DESC' => 'Folgende Layouts wurden erfolgreich zusammengeführt',
	'LBL_SELECT_FILE' => 'Datei auswählen:',
	'LBL_LANGPACKS' => 'Sprachpakete' /*for 508 compliance fix*/,
	'LBL_MODULELOADER' => 'Module verwalten' /*for 508 compliance fix*/,
	'LBL_PATCHUPGRADES' => 'Patch-Upgrades' /*for 508 compliance fix*/,
	'LBL_THEMES' => 'Schema Einstellungen' /*for 508 compliance fix*/,
	'LBL_WORKFLOW' => 'Workflow' /*for 508 compliance fix*/,
	'LBL_UPGRADE' => 'Aktualisieren:' /*for 508 compliance fix*/,
	'LBL_PROCESSING' => 'In Bearbeitung' /*for 508 compliance fix*/,
    'LBL_GLOBAL_TEAM_DESC'                      => 'Global sichtbar',
);
