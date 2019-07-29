-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: haztrack
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` char(36) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `googleplus` varchar(100) DEFAULT NULL,
  `account_type` varchar(50) DEFAULT NULL,
  `industry` varchar(50) DEFAULT NULL,
  `annual_revenue` varchar(100) DEFAULT NULL,
  `phone_fax` varchar(100) DEFAULT NULL,
  `billing_address_street` varchar(150) DEFAULT NULL,
  `billing_address_city` varchar(100) DEFAULT NULL,
  `billing_address_state` varchar(100) DEFAULT NULL,
  `billing_address_postalcode` varchar(20) DEFAULT NULL,
  `billing_address_country` varchar(255) DEFAULT NULL,
  `rating` varchar(100) DEFAULT NULL,
  `phone_office` varchar(100) DEFAULT NULL,
  `phone_alternate` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `ownership` varchar(100) DEFAULT NULL,
  `employees` varchar(10) DEFAULT NULL,
  `ticker_symbol` varchar(10) DEFAULT NULL,
  `shipping_address_street` varchar(150) DEFAULT NULL,
  `shipping_address_city` varchar(100) DEFAULT NULL,
  `shipping_address_state` varchar(100) DEFAULT NULL,
  `shipping_address_postalcode` varchar(20) DEFAULT NULL,
  `shipping_address_country` varchar(255) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `sic_code` varchar(10) DEFAULT NULL,
  `duns_num` varchar(15) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `physical_address_city` varchar(100) DEFAULT NULL,
  `physical_address_state` varchar(100) DEFAULT NULL,
  `physical_address_street` text,
  `physical_address_postalcode` varchar(20) DEFAULT NULL,
  `physical_address_country` varchar(100) DEFAULT NULL,
  `physical_address_account_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_accounts_date_modfied` (`date_modified`),
  KEY `idx_accounts_id_del` (`id`,`deleted`),
  KEY `idx_accounts_date_entered` (`date_entered`),
  KEY `idx_accounts_name_del` (`name`,`deleted`),
  KEY `idx_accnt_parent_id` (`parent_id`),
  KEY `idx_account_billing_address_city` (`billing_address_city`),
  KEY `idx_account_billing_address_country` (`billing_address_country`),
  KEY `idx_accounts_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_accounts_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_audit`
--

DROP TABLE IF EXISTS `accounts_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_accounts_audit_parent_id` (`parent_id`),
  KEY `idx_accounts_audit_event_id` (`event_id`),
  KEY `idx_accounts_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_accounts_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_bugs`
--

DROP TABLE IF EXISTS `accounts_bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_bugs` (
  `id` char(36) NOT NULL,
  `account_id` char(36) DEFAULT NULL,
  `bug_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_acc_bug_acc` (`account_id`),
  KEY `idx_acc_bug_bug` (`bug_id`),
  KEY `idx_account_bug` (`account_id`,`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_cases`
--

DROP TABLE IF EXISTS `accounts_cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_cases` (
  `id` char(36) NOT NULL,
  `account_id` char(36) DEFAULT NULL,
  `case_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_acc_case_acc` (`account_id`),
  KEY `idx_acc_acc_case` (`case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_contacts`
--

DROP TABLE IF EXISTS `accounts_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_contacts` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `primary_account` tinyint(1) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_account_contact` (`account_id`,`contact_id`),
  KEY `idx_contid_del_accid` (`contact_id`,`deleted`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_cstm`
--

DROP TABLE IF EXISTS `accounts_cstm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_cstm` (
  `id_c` char(36) NOT NULL,
  `account_terms_c` varchar(100) DEFAULT '',
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_dataprivacy`
--

DROP TABLE IF EXISTS `accounts_dataprivacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_dataprivacy` (
  `id` char(36) NOT NULL,
  `account_id` char(36) DEFAULT NULL,
  `dataprivacy_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_acc_dataprivacy_acc` (`account_id`),
  KEY `idx_acc_dataprivacy_dataprivacy` (`dataprivacy_id`),
  KEY `idx_accounts_dataprivacy` (`account_id`,`dataprivacy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_ht_manifest_1_c`
--

DROP TABLE IF EXISTS `accounts_ht_manifest_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_ht_manifest_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `accounts_ht_manifest_1accounts_ida` char(36) DEFAULT NULL,
  `accounts_ht_manifest_1ht_manifest_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_accounts_ht_manifest_1_ida1_deleted` (`accounts_ht_manifest_1accounts_ida`,`deleted`),
  KEY `idx_accounts_ht_manifest_1_idb2_deleted` (`accounts_ht_manifest_1ht_manifest_idb`,`deleted`),
  KEY `accounts_ht_manifest_1_alt` (`accounts_ht_manifest_1ht_manifest_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_opportunities`
--

DROP TABLE IF EXISTS `accounts_opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_opportunities` (
  `id` char(36) NOT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_account_opportunity` (`account_id`,`opportunity_id`),
  KEY `idx_oppid_del_accid` (`opportunity_id`,`deleted`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts_sales_and_services_1_c`
--

DROP TABLE IF EXISTS `accounts_sales_and_services_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts_sales_and_services_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `accounts_sales_and_services_1accounts_ida` char(36) DEFAULT NULL,
  `accounts_sales_and_services_1sales_and_services_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_accounts_sales_and_services_1_ida1_deleted` (`accounts_sales_and_services_1accounts_ida`,`deleted`),
  KEY `idx_accounts_sales_and_services_1_idb2_deleted` (`accounts_sales_and_services_1sales_and_services_idb`,`deleted`),
  KEY `accounts_sales_and_services_1_alt` (`accounts_sales_and_services_1sales_and_services_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_actions`
--

DROP TABLE IF EXISTS `acl_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_actions` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `acltype` varchar(100) DEFAULT NULL,
  `aclaccess` int(3) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_aclaction_id_del` (`id`,`deleted`),
  KEY `idx_category_name` (`category`,`name`),
  KEY `idx_del_category_name_acltype_aclaccess` (`deleted`,`category`,`name`,`acltype`,`aclaccess`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_fields`
--

DROP TABLE IF EXISTS `acl_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_fields` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `aclaccess` int(3) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `role_id` char(36) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aclfield_role_del` (`role_id`,`category`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_role_sets`
--

DROP TABLE IF EXISTS `acl_role_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_role_sets` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `hash` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_acl_role_sets_hash` (`hash`),
  KEY `idx_acl_role_sets_date_modfied` (`date_modified`),
  KEY `idx_acl_role_sets_id_del` (`id`,`deleted`),
  KEY `idx_acl_role_sets_date_entered` (`date_entered`),
  KEY `idx_acl_role_sets_name_del` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_role_sets_acl_roles`
--

DROP TABLE IF EXISTS `acl_role_sets_acl_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_role_sets_acl_roles` (
  `id` char(36) NOT NULL,
  `acl_role_set_id` char(36) DEFAULT NULL,
  `acl_role_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_rsr_set_id` (`acl_role_set_id`,`acl_role_id`),
  KEY `idx_rsr_role_id` (`acl_role_id`),
  KEY `idx_rsr_acl_role_set_id` (`acl_role_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_roles`
--

DROP TABLE IF EXISTS `acl_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_roles` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_aclrole_id_del` (`id`,`deleted`),
  KEY `idx_aclrole_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_roles_actions`
--

DROP TABLE IF EXISTS `acl_roles_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_roles_actions` (
  `id` char(36) NOT NULL,
  `role_id` char(36) DEFAULT NULL,
  `action_id` char(36) DEFAULT NULL,
  `access_override` int(3) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_acl_role_id` (`role_id`),
  KEY `idx_acl_action_id` (`action_id`),
  KEY `idx_del_override` (`role_id`,`deleted`,`action_id`,`access_override`),
  KEY `idx_aclrole_action` (`role_id`,`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acl_roles_users`
--

DROP TABLE IF EXISTS `acl_roles_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_roles_users` (
  `id` char(36) NOT NULL,
  `role_id` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_aclrole_id` (`role_id`),
  KEY `idx_acluser_id` (`user_id`),
  KEY `idx_aclrole_user` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `parent_id` char(36) DEFAULT NULL,
  `parent_type` varchar(100) DEFAULT NULL,
  `activity_type` varchar(100) DEFAULT NULL,
  `data` longtext,
  `comment_count` int(11) DEFAULT '0',
  `last_comment` longtext,
  PRIMARY KEY (`id`),
  KEY `idx_activities_date_modfied` (`date_modified`),
  KEY `idx_activities_id_del` (`id`,`deleted`),
  KEY `idx_activities_date_entered` (`date_entered`),
  KEY `activity_records` (`parent_type`,`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `activities_users`
--

DROP TABLE IF EXISTS `activities_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities_users` (
  `id` char(36) NOT NULL,
  `activity_id` char(36) NOT NULL,
  `parent_type` varchar(100) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `fields` longtext,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `activities_records` (`parent_type`,`parent_id`),
  KEY `activities_users_parent` (`activity_id`,`parent_id`,`parent_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `address_book`
--

DROP TABLE IF EXISTS `address_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address_book` (
  `assigned_user_id` char(36) NOT NULL,
  `bean` varchar(50) DEFAULT NULL,
  `bean_id` char(36) NOT NULL,
  PRIMARY KEY (`assigned_user_id`,`bean_id`),
  KEY `ab_user_bean_idx` (`assigned_user_id`,`bean`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `address_book_list_items`
--

DROP TABLE IF EXISTS `address_book_list_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address_book_list_items` (
  `list_id` char(36) NOT NULL,
  `bean_id` char(36) NOT NULL,
  PRIMARY KEY (`list_id`,`bean_id`),
  KEY `abli_list_id_idx` (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `address_book_lists`
--

DROP TABLE IF EXISTS `address_book_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address_book_lists` (
  `id` char(36) NOT NULL,
  `assigned_user_id` char(36) NOT NULL,
  `list_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `abml_user_bean_idx` (`assigned_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `audit_events`
--

DROP TABLE IF EXISTS `audit_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_events` (
  `id` char(36) NOT NULL,
  `type` char(10) DEFAULT NULL,
  `parent_id` char(36) NOT NULL,
  `module_name` varchar(100) DEFAULT NULL,
  `source` text,
  `data` text,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aud_eve_ptd` (`parent_id`,`type`,`date_created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bugs`
--

DROP TABLE IF EXISTS `bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bugs` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `bug_number` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `priority` varchar(100) DEFAULT NULL,
  `resolution` varchar(255) DEFAULT NULL,
  `work_log` text,
  `found_in_release` varchar(255) DEFAULT NULL,
  `fixed_in_release` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `product_category` varchar(255) DEFAULT NULL,
  `portal_viewable` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bugsnumk` (`bug_number`),
  KEY `idx_bugs_date_modfied` (`date_modified`),
  KEY `idx_bugs_id_del` (`id`,`deleted`),
  KEY `idx_bugs_date_entered` (`date_entered`),
  KEY `idx_bugs_name_del` (`name`,`deleted`),
  KEY `idx_bug_name` (`name`),
  KEY `idx_bugs_assigned_user` (`assigned_user_id`),
  KEY `idx_bugs_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_bugs_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bugs_audit`
--

DROP TABLE IF EXISTS `bugs_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bugs_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_bugs_audit_parent_id` (`parent_id`),
  KEY `idx_bugs_audit_event_id` (`event_id`),
  KEY `idx_bugs_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_bugs_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calls`
--

DROP TABLE IF EXISTS `calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calls` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `duration_hours` int(11) DEFAULT '0',
  `duration_minutes` int(2) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Planned',
  `direction` varchar(100) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `reminder_time` int(11) DEFAULT '-1',
  `email_reminder_time` int(11) DEFAULT '-1',
  `email_reminder_sent` tinyint(1) DEFAULT '0',
  `outlook_id` varchar(255) DEFAULT NULL,
  `repeat_type` varchar(36) DEFAULT NULL,
  `repeat_interval` int(3) DEFAULT '1',
  `repeat_dow` varchar(7) DEFAULT NULL,
  `repeat_until` date DEFAULT NULL,
  `repeat_count` int(7) DEFAULT NULL,
  `repeat_selector` varchar(36) DEFAULT NULL,
  `repeat_days` varchar(128) DEFAULT NULL,
  `repeat_ordinal` varchar(36) DEFAULT NULL,
  `repeat_unit` varchar(36) DEFAULT NULL,
  `repeat_parent_id` char(36) DEFAULT NULL,
  `recurrence_id` datetime DEFAULT NULL,
  `recurring_source` varchar(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_calls_date_modfied` (`date_modified`),
  KEY `idx_calls_id_del` (`id`,`deleted`),
  KEY `idx_calls_date_entered` (`date_entered`),
  KEY `idx_calls_name_del` (`name`,`deleted`),
  KEY `idx_call_name` (`name`),
  KEY `idx_status` (`status`),
  KEY `idx_calls_date_start` (`date_start`),
  KEY `idx_calls_recurrence_id` (`recurrence_id`),
  KEY `idx_calls_date_start_end_del` (`date_start`,`date_end`,`deleted`),
  KEY `idx_calls_repeat_parent_id` (`repeat_parent_id`,`deleted`),
  KEY `idx_calls_date_start_reminder` (`date_start`,`reminder_time`),
  KEY `idx_calls_par_del` (`parent_id`,`parent_type`,`deleted`),
  KEY `idx_call_direction` (`direction`),
  KEY `idx_calls_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_calls_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calls_contacts`
--

DROP TABLE IF EXISTS `calls_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calls_contacts` (
  `id` char(36) NOT NULL,
  `call_id` char(36) DEFAULT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `required` varchar(1) DEFAULT '1',
  `accept_status` varchar(25) DEFAULT 'none',
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_con_call_call` (`call_id`),
  KEY `idx_con_call_con` (`contact_id`),
  KEY `idx_call_contact` (`call_id`,`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calls_leads`
--

DROP TABLE IF EXISTS `calls_leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calls_leads` (
  `id` char(36) NOT NULL,
  `call_id` char(36) DEFAULT NULL,
  `lead_id` char(36) DEFAULT NULL,
  `required` varchar(1) DEFAULT '1',
  `accept_status` varchar(25) DEFAULT 'none',
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_lead_call_call` (`call_id`),
  KEY `idx_lead_call_lead` (`lead_id`),
  KEY `idx_call_lead` (`call_id`,`lead_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calls_users`
--

DROP TABLE IF EXISTS `calls_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calls_users` (
  `id` char(36) NOT NULL,
  `call_id` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `required` varchar(1) DEFAULT '1',
  `accept_status` varchar(25) DEFAULT 'none',
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_usr_call_call` (`call_id`),
  KEY `idx_usr_call_usr` (`user_id`),
  KEY `idx_call_users` (`call_id`,`user_id`),
  KEY `idx_call_users_del` (`call_id`,`user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign_log`
--

DROP TABLE IF EXISTS `campaign_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign_log` (
  `id` char(36) NOT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `target_tracker_key` varchar(36) DEFAULT NULL,
  `target_id` char(36) DEFAULT NULL,
  `target_type` varchar(100) DEFAULT NULL,
  `activity_type` varchar(100) DEFAULT NULL,
  `activity_date` datetime DEFAULT NULL,
  `related_id` char(36) DEFAULT NULL,
  `related_type` varchar(100) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `hits` int(11) DEFAULT '0',
  `list_id` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_modified` datetime DEFAULT NULL,
  `more_information` varchar(100) DEFAULT NULL,
  `marketing_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_camp_tracker` (`target_tracker_key`),
  KEY `idx_camp_campaign_id` (`campaign_id`),
  KEY `idx_camp_more_info` (`more_information`),
  KEY `idx_target_id` (`target_id`),
  KEY `idx_target_id_deleted` (`target_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign_trkrs`
--

DROP TABLE IF EXISTS `campaign_trkrs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign_trkrs` (
  `id` char(36) NOT NULL,
  `tracker_name` varchar(30) DEFAULT NULL,
  `tracker_url` varchar(255) DEFAULT 'http://',
  `tracker_key` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` char(36) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `is_optout` tinyint(1) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `campaign_tracker_key_idx` (`tracker_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaigns` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `tracker_key` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_count` int(11) DEFAULT '0',
  `refer_url` varchar(255) DEFAULT 'http://',
  `tracker_text` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `impressions` int(11) DEFAULT '0',
  `budget` decimal(26,6) DEFAULT NULL,
  `expected_cost` decimal(26,6) DEFAULT NULL,
  `actual_cost` decimal(26,6) DEFAULT NULL,
  `expected_revenue` decimal(26,6) DEFAULT NULL,
  `campaign_type` varchar(100) DEFAULT NULL,
  `objective` text,
  `content` text,
  `frequency` varchar(100) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_campaigns_date_modfied` (`date_modified`),
  KEY `idx_campaigns_id_del` (`id`,`deleted`),
  KEY `idx_campaigns_date_entered` (`date_entered`),
  KEY `idx_campaigns_name_del` (`name`,`deleted`),
  KEY `camp_auto_tracker_key` (`tracker_key`),
  KEY `idx_campaign_name` (`name`),
  KEY `idx_campaign_status` (`status`),
  KEY `idx_campaign_campaign_type` (`campaign_type`),
  KEY `idx_campaign_end_date` (`end_date`),
  KEY `idx_campaigns_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_campaigns_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaigns_audit`
--

DROP TABLE IF EXISTS `campaigns_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaigns_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_campaigns_audit_parent_id` (`parent_id`),
  KEY `idx_campaigns_audit_event_id` (`event_id`),
  KEY `idx_campaigns_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_campaigns_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cases`
--

DROP TABLE IF EXISTS `cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cases` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `case_number` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `priority` varchar(100) DEFAULT NULL,
  `resolution` text,
  `work_log` text,
  `account_id` char(36) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `portal_viewable` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `casesnumk` (`case_number`),
  KEY `idx_cases_date_modfied` (`date_modified`),
  KEY `idx_cases_id_del` (`id`,`deleted`),
  KEY `idx_cases_date_entered` (`date_entered`),
  KEY `idx_cases_name_del` (`name`,`deleted`),
  KEY `idx_case_name` (`name`),
  KEY `idx_account_id` (`account_id`),
  KEY `idx_cases_stat_del` (`assigned_user_id`,`status`,`deleted`),
  KEY `idx_cases_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_cases_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cases_audit`
--

DROP TABLE IF EXISTS `cases_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cases_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_cases_audit_parent_id` (`parent_id`),
  KEY `idx_cases_audit_event_id` (`event_id`),
  KEY `idx_cases_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_cases_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cases_bugs`
--

DROP TABLE IF EXISTS `cases_bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cases_bugs` (
  `id` char(36) NOT NULL,
  `case_id` char(36) DEFAULT NULL,
  `bug_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_cas_bug_cas` (`case_id`),
  KEY `idx_cas_bug_bug` (`bug_id`),
  KEY `idx_case_bug` (`case_id`,`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `root` char(36) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `is_external` tinyint(1) DEFAULT '0',
  `source_id` varchar(255) DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_meta` text,
  PRIMARY KEY (`id`),
  KEY `idx_categories_date_modfied` (`date_modified`),
  KEY `idx_categories_id_del` (`id`,`deleted`),
  KEY `idx_categories_date_entered` (`date_entered`),
  KEY `idx_categories_name_del` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category_tree`
--

DROP TABLE IF EXISTS `category_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_tree` (
  `self_id` char(36) DEFAULT NULL,
  `node_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_node_id` int(11) DEFAULT '0',
  `type` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`node_id`),
  KEY `idx_categorytree` (`self_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `parent_id` char(36) NOT NULL,
  `data` longtext,
  PRIMARY KEY (`id`),
  KEY `idx_comments_date_modfied` (`date_modified`),
  KEY `idx_comments_id_del` (`id`,`deleted`),
  KEY `idx_comments_date_entered` (`date_entered`),
  KEY `comment_activities` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `category` varchar(32) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `value` text,
  `platform` varchar(32) DEFAULT NULL,
  KEY `idx_config_cat` (`category`),
  KEY `idx_config_platform` (`platform`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `salutation` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `googleplus` varchar(100) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `do_not_call` tinyint(1) DEFAULT '0',
  `phone_home` varchar(100) DEFAULT NULL,
  `phone_mobile` varchar(100) DEFAULT NULL,
  `phone_work` varchar(100) DEFAULT NULL,
  `phone_other` varchar(100) DEFAULT NULL,
  `phone_fax` varchar(100) DEFAULT NULL,
  `primary_address_street` varchar(150) DEFAULT NULL,
  `primary_address_city` varchar(100) DEFAULT NULL,
  `primary_address_state` varchar(100) DEFAULT NULL,
  `primary_address_postalcode` varchar(20) DEFAULT NULL,
  `primary_address_country` varchar(255) DEFAULT NULL,
  `alt_address_street` varchar(150) DEFAULT NULL,
  `alt_address_city` varchar(100) DEFAULT NULL,
  `alt_address_state` varchar(100) DEFAULT NULL,
  `alt_address_postalcode` varchar(20) DEFAULT NULL,
  `alt_address_country` varchar(255) DEFAULT NULL,
  `assistant` varchar(75) DEFAULT NULL,
  `assistant_phone` varchar(100) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `lead_source` varchar(255) DEFAULT NULL,
  `dnb_principal_id` varchar(30) DEFAULT NULL,
  `reports_to_id` char(36) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `portal_name` varchar(255) DEFAULT NULL,
  `portal_active` tinyint(1) DEFAULT '0',
  `portal_password` varchar(255) DEFAULT NULL,
  `portal_app` varchar(255) DEFAULT NULL,
  `preferred_language` varchar(255) DEFAULT NULL,
  `dp_business_purpose` text,
  `dp_consent_last_updated` date DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `mkto_sync` tinyint(1) DEFAULT '0',
  `mkto_id` int(11) DEFAULT NULL,
  `mkto_lead_score` int(11) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_contacts_date_modfied` (`date_modified`),
  KEY `idx_contacts_id_del` (`id`,`deleted`),
  KEY `idx_contacts_date_entered` (`date_entered`),
  KEY `idx_contacts_last_first` (`last_name`,`first_name`,`deleted`),
  KEY `idx_contacts_first_last` (`first_name`,`last_name`,`deleted`),
  KEY `idx_contacts_del_last` (`deleted`,`last_name`),
  KEY `idx_cont_del_reports` (`deleted`,`reports_to_id`,`last_name`),
  KEY `idx_reports_to_id` (`reports_to_id`),
  KEY `idx_del_id_user` (`deleted`,`id`,`assigned_user_id`),
  KEY `idx_cont_assigned` (`assigned_user_id`),
  KEY `idx_contact_title` (`title`),
  KEY `idx_contact_mkto_id` (`mkto_id`),
  KEY `idx_contacts_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_contacts_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts_audit`
--

DROP TABLE IF EXISTS `contacts_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_contacts_audit_parent_id` (`parent_id`),
  KEY `idx_contacts_audit_event_id` (`event_id`),
  KEY `idx_contacts_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_contacts_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts_bugs`
--

DROP TABLE IF EXISTS `contacts_bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts_bugs` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `bug_id` char(36) DEFAULT NULL,
  `contact_role` varchar(50) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_con_bug_con` (`contact_id`),
  KEY `idx_con_bug_bug` (`bug_id`),
  KEY `idx_contact_bug` (`contact_id`,`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts_cases`
--

DROP TABLE IF EXISTS `contacts_cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts_cases` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `case_id` char(36) DEFAULT NULL,
  `contact_role` varchar(50) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_con_case_con` (`contact_id`),
  KEY `idx_con_case_case` (`case_id`),
  KEY `idx_contacts_cases` (`contact_id`,`case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts_dataprivacy`
--

DROP TABLE IF EXISTS `contacts_dataprivacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts_dataprivacy` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `dataprivacy_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_con_dataprivacy_con` (`contact_id`),
  KEY `idx_con_dataprivacy_dataprivacy` (`dataprivacy_id`),
  KEY `idx_contacts_dataprivacy` (`contact_id`,`dataprivacy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts_sales_and_services_1_c`
--

DROP TABLE IF EXISTS `contacts_sales_and_services_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts_sales_and_services_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `contacts_sales_and_services_1contacts_ida` char(36) DEFAULT NULL,
  `contacts_sales_and_services_1sales_and_services_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_contacts_sales_and_services_1_ida1_deleted` (`contacts_sales_and_services_1contacts_ida`,`deleted`),
  KEY `idx_contacts_sales_and_services_1_idb2_deleted` (`contacts_sales_and_services_1sales_and_services_idb`,`deleted`),
  KEY `contacts_sales_and_services_1_alt` (`contacts_sales_and_services_1sales_and_services_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts_users`
--

DROP TABLE IF EXISTS `contacts_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts_users` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_con_users_con` (`contact_id`),
  KEY `idx_con_users_user` (`user_id`),
  KEY `idx_contacts_users` (`contact_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contract_types`
--

DROP TABLE IF EXISTS `contract_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contract_types` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `list_order` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_contract_types_date_modfied` (`date_modified`),
  KEY `idx_contract_types_id_del` (`id`,`deleted`),
  KEY `idx_contract_types_date_entered` (`date_entered`),
  KEY `idx_contract_types_name_del` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contracts`
--

DROP TABLE IF EXISTS `contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `reference_code` varchar(255) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_contract_value` decimal(26,6) DEFAULT NULL,
  `total_contract_value_usdollar` decimal(26,6) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `customer_signed_date` date DEFAULT NULL,
  `company_signed_date` date DEFAULT NULL,
  `expiration_notice` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_contracts_date_modfied` (`date_modified`),
  KEY `idx_contracts_id_del` (`id`,`deleted`),
  KEY `idx_contracts_date_entered` (`date_entered`),
  KEY `idx_contracts_name_del` (`name`,`deleted`),
  KEY `idx_contract_name` (`name`),
  KEY `idx_contract_status` (`status`),
  KEY `idx_contract_start_date` (`start_date`),
  KEY `idx_contract_end_date` (`end_date`),
  KEY `idx_contracts_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_contracts_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contracts_audit`
--

DROP TABLE IF EXISTS `contracts_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_contracts_audit_parent_id` (`parent_id`),
  KEY `idx_contracts_audit_event_id` (`event_id`),
  KEY `idx_contracts_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_contracts_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contracts_contacts`
--

DROP TABLE IF EXISTS `contracts_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts_contacts` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `contract_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `contracts_contacts_alt` (`contact_id`,`contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contracts_ht_products`
--

DROP TABLE IF EXISTS `contracts_ht_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts_ht_products` (
  `id` char(36) NOT NULL,
  `product_id` char(36) DEFAULT NULL,
  `contract_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `contracts_prod_alt` (`contract_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contracts_ht_quotes`
--

DROP TABLE IF EXISTS `contracts_ht_quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts_ht_quotes` (
  `id` char(36) NOT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `contract_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `contracts_quot_alt` (`contract_id`,`quote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contracts_opportunities`
--

DROP TABLE IF EXISTS `contracts_opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts_opportunities` (
  `id` char(36) NOT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `contract_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `contracts_opp_alt` (`contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contracts_products`
--

DROP TABLE IF EXISTS `contracts_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts_products` (
  `id` char(36) NOT NULL,
  `product_id` char(36) DEFAULT NULL,
  `contract_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `contracts_prod_alt` (`contract_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contracts_quotes`
--

DROP TABLE IF EXISTS `contracts_quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts_quotes` (
  `id` char(36) NOT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `contract_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `contracts_quot_alt` (`contract_id`,`quote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contracts_sales_and_services_1_c`
--

DROP TABLE IF EXISTS `contracts_sales_and_services_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contracts_sales_and_services_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `contracts_sales_and_services_1contracts_ida` char(36) DEFAULT NULL,
  `contracts_sales_and_services_1sales_and_services_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_contracts_sales_and_services_1_ida1_deleted` (`contracts_sales_and_services_1contracts_ida`,`deleted`),
  KEY `idx_contracts_sales_and_services_1_idb2_deleted` (`contracts_sales_and_services_1sales_and_services_idb`,`deleted`),
  KEY `contracts_sales_and_services_1_alt` (`contracts_sales_and_services_1sales_and_services_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currencies` (
  `id` char(36) NOT NULL,
  `name` varchar(36) DEFAULT NULL,
  `symbol` varchar(36) DEFAULT NULL,
  `iso4217` varchar(3) DEFAULT NULL,
  `conversion_rate` decimal(26,6) DEFAULT '0.000000',
  `status` varchar(100) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `created_by` char(36) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_currency_name` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields` (
  `bean_id` char(36) DEFAULT NULL,
  `set_num` int(11) DEFAULT '0',
  `field0` varchar(255) DEFAULT NULL,
  `field1` varchar(255) DEFAULT NULL,
  `field2` varchar(255) DEFAULT NULL,
  `field3` varchar(255) DEFAULT NULL,
  `field4` varchar(255) DEFAULT NULL,
  `field5` varchar(255) DEFAULT NULL,
  `field6` varchar(255) DEFAULT NULL,
  `field7` varchar(255) DEFAULT NULL,
  `field8` varchar(255) DEFAULT NULL,
  `field9` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  KEY `idx_beanid_set_num` (`bean_id`,`set_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_queries`
--

DROP TABLE IF EXISTS `custom_queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_queries` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `custom_query` text,
  `query_type` varchar(50) DEFAULT NULL,
  `list_order` int(4) DEFAULT NULL,
  `query_locked` varchar(3) DEFAULT '0',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_customqueries` (`name`,`deleted`),
  KEY `idx_custom_queries_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dashboards`
--

DROP TABLE IF EXISTS `dashboards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dashboards` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `dashboard_module` varchar(100) DEFAULT NULL,
  `view_name` varchar(100) DEFAULT NULL,
  `metadata` text,
  `default_dashboard` tinyint(1) DEFAULT '0',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_dashboards_date_modfied` (`date_modified`),
  KEY `idx_dashboards_id_del` (`id`,`deleted`),
  KEY `idx_dashboards_date_entered` (`date_entered`),
  KEY `idx_dashboards_name_del` (`name`,`deleted`),
  KEY `user_module_view` (`assigned_user_id`,`dashboard_module`,`view_name`),
  KEY `idx_dashboards_tmst_id` (`team_set_id`),
  KEY `idx_dashboards_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_privacy`
--

DROP TABLE IF EXISTS `data_privacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_privacy` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `dataprivacy_number` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Open',
  `priority` varchar(100) DEFAULT NULL,
  `resolution` text,
  `work_log` text,
  `business_purpose` text,
  `source` varchar(255) DEFAULT NULL,
  `requested_by` varchar(255) DEFAULT NULL,
  `date_opened` date DEFAULT NULL,
  `date_due` date DEFAULT NULL,
  `date_closed` date DEFAULT NULL,
  `fields_to_erase` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dataprivacynumk` (`dataprivacy_number`),
  KEY `idx_data_privacy_date_modfied` (`date_modified`),
  KEY `idx_data_privacy_id_del` (`id`,`deleted`),
  KEY `idx_data_privacy_date_entered` (`date_entered`),
  KEY `idx_data_privacy_name_del` (`name`,`deleted`),
  KEY `idx_dataprivacy_name` (`name`),
  KEY `idx_data_privacy_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_data_privacy_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_privacy_audit`
--

DROP TABLE IF EXISTS `data_privacy_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_privacy_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_data_privacy_audit_parent_id` (`parent_id`),
  KEY `idx_data_privacy_audit_event_id` (`event_id`),
  KEY `idx_data_privacy_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_data_privacy_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data_sets`
--

DROP TABLE IF EXISTS `data_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_sets` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `report_id` char(36) DEFAULT NULL,
  `query_id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `list_order_y` int(3) DEFAULT '0',
  `exportable` varchar(3) DEFAULT '0',
  `header` varchar(3) DEFAULT '0',
  `description` text,
  `table_width` varchar(3) DEFAULT '0',
  `font_size` varchar(8) DEFAULT '0',
  `output_default` varchar(100) DEFAULT NULL,
  `prespace_y` varchar(3) DEFAULT '0',
  `use_prev_header` varchar(3) DEFAULT '0',
  `header_back_color` varchar(100) DEFAULT NULL,
  `body_back_color` varchar(100) DEFAULT NULL,
  `header_text_color` varchar(100) DEFAULT NULL,
  `body_text_color` varchar(100) DEFAULT NULL,
  `table_width_type` varchar(3) DEFAULT NULL,
  `custom_layout` varchar(10) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_dataset` (`name`,`deleted`),
  KEY `idx_data_sets_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dataset_attributes`
--

DROP TABLE IF EXISTS `dataset_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset_attributes` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `display_type` varchar(25) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `attribute_type` varchar(8) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `font_size` varchar(8) DEFAULT '0',
  `cell_size` varchar(3) DEFAULT NULL,
  `size_type` varchar(3) DEFAULT NULL,
  `bg_color` varchar(25) DEFAULT NULL,
  `font_color` varchar(25) DEFAULT NULL,
  `wrap` varchar(3) DEFAULT NULL,
  `style` varchar(25) DEFAULT NULL,
  `format_type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_datasetatt` (`parent_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dataset_layouts`
--

DROP TABLE IF EXISTS `dataset_layouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset_layouts` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `parent_value` varchar(50) DEFAULT NULL,
  `layout_type` varchar(25) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `list_order_x` int(4) DEFAULT NULL,
  `list_order_z` int(4) DEFAULT NULL,
  `row_header_id` char(36) DEFAULT NULL,
  `hide_column` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_datasetlayout` (`parent_value`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `document_revisions`
--

DROP TABLE IF EXISTS `document_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_revisions` (
  `id` char(36) NOT NULL,
  `change_log` varchar(255) DEFAULT NULL,
  `document_id` char(36) DEFAULT NULL,
  `doc_id` varchar(100) DEFAULT NULL,
  `doc_type` varchar(100) DEFAULT NULL,
  `doc_url` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `file_ext` varchar(100) DEFAULT NULL,
  `file_mime_type` varchar(100) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `revision` varchar(100) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documentrevision_mimetype` (`file_mime_type`),
  KEY `idx_document_revisions_document_id_deleted` (`document_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `document_name` varchar(255) DEFAULT NULL,
  `doc_id` varchar(100) DEFAULT NULL,
  `doc_type` varchar(100) DEFAULT 'Sugar',
  `doc_url` varchar(255) DEFAULT NULL,
  `active_date` date DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `category_id` varchar(100) DEFAULT NULL,
  `subcategory_id` varchar(100) DEFAULT NULL,
  `status_id` varchar(100) DEFAULT NULL,
  `document_revision_id` char(36) DEFAULT NULL,
  `related_doc_id` char(36) DEFAULT NULL,
  `related_doc_rev_id` char(36) DEFAULT NULL,
  `is_template` tinyint(1) DEFAULT '0',
  `template_type` varchar(100) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_documents_date_modfied` (`date_modified`),
  KEY `idx_documents_id_del` (`id`,`deleted`),
  KEY `idx_documents_date_entered` (`date_entered`),
  KEY `idx_doc_cat` (`category_id`,`subcategory_id`),
  KEY `idx_document_doc_type` (`doc_type`),
  KEY `idx_document_exp_date` (`exp_date`),
  KEY `idx_documents_related_doc_id_deleted` (`related_doc_id`,`deleted`),
  KEY `idx_documents_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_documents_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_accounts`
--

DROP TABLE IF EXISTS `documents_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_accounts` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_accounts_account_id` (`account_id`,`document_id`),
  KEY `documents_accounts_document_id` (`document_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_bugs`
--

DROP TABLE IF EXISTS `documents_bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_bugs` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `bug_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_bugs_bug_id` (`bug_id`,`document_id`),
  KEY `documents_bugs_document_id` (`document_id`,`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_cases`
--

DROP TABLE IF EXISTS `documents_cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_cases` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `case_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_cases_case_id` (`case_id`,`document_id`),
  KEY `documents_cases_document_id` (`document_id`,`case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_contacts`
--

DROP TABLE IF EXISTS `documents_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_contacts` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `contact_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_contacts_contact_id` (`contact_id`,`document_id`),
  KEY `documents_contacts_document_id` (`document_id`,`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_ht_products`
--

DROP TABLE IF EXISTS `documents_ht_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_ht_products` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `product_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_products_product_id` (`product_id`,`document_id`),
  KEY `documents_products_document_id` (`document_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_ht_quotes`
--

DROP TABLE IF EXISTS `documents_ht_quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_ht_quotes` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_ht_quotes_quote_id` (`quote_id`,`document_id`),
  KEY `documents_ht_quotes_document_id` (`document_id`,`quote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_opportunities`
--

DROP TABLE IF EXISTS `documents_opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_opportunities` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_docu_opps_oppo_id` (`opportunity_id`,`document_id`),
  KEY `idx_docu_oppo_docu_id` (`document_id`,`opportunity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_products`
--

DROP TABLE IF EXISTS `documents_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_products` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `product_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_products_product_id` (`product_id`,`document_id`),
  KEY `documents_products_document_id` (`document_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_quotes`
--

DROP TABLE IF EXISTS `documents_quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_quotes` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_quotes_quote_id` (`quote_id`,`document_id`),
  KEY `documents_quotes_document_id` (`document_id`,`quote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents_revenuelineitems`
--

DROP TABLE IF EXISTS `documents_revenuelineitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_revenuelineitems` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `document_id` char(36) DEFAULT NULL,
  `rli_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_revenuelineitems_revenuelineitem_id` (`rli_id`,`document_id`),
  KEY `documents_revenuelineitems_document_id` (`document_id`,`rli_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eapm`
--

DROP TABLE IF EXISTS `eapm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eapm` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `password` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `application` varchar(100) DEFAULT 'webex',
  `api_data` text,
  `consumer_key` varchar(255) DEFAULT NULL,
  `consumer_secret` varchar(255) DEFAULT NULL,
  `oauth_token` varchar(255) DEFAULT NULL,
  `oauth_secret` varchar(255) DEFAULT NULL,
  `validated` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_eapm_date_modfied` (`date_modified`),
  KEY `idx_eapm_id_del` (`id`,`deleted`),
  KEY `idx_eapm_date_entered` (`date_entered`),
  KEY `idx_eapm_name_del` (`name`,`deleted`),
  KEY `idx_app_active` (`assigned_user_id`,`application`,`validated`),
  KEY `idx_eapm_name` (`name`),
  KEY `idx_eapm_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email_addr_bean_rel`
--

DROP TABLE IF EXISTS `email_addr_bean_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_addr_bean_rel` (
  `id` char(36) NOT NULL,
  `email_address_id` char(36) NOT NULL,
  `bean_id` char(36) NOT NULL,
  `bean_module` varchar(100) DEFAULT NULL,
  `primary_address` tinyint(1) DEFAULT '0',
  `reply_to_address` tinyint(1) DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_email_address_id` (`email_address_id`),
  KEY `idx_bean_id` (`bean_id`,`bean_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email_addresses`
--

DROP TABLE IF EXISTS `email_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_addresses` (
  `id` char(36) NOT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `email_address_caps` varchar(255) DEFAULT NULL,
  `invalid_email` tinyint(1) DEFAULT '0',
  `opt_out` tinyint(1) DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_ea_caps_opt_out_invalid` (`email_address_caps`,`opt_out`,`invalid_email`),
  KEY `idx_ea_opt_out_invalid` (`email_address`,`opt_out`,`invalid_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email_addresses_audit`
--

DROP TABLE IF EXISTS `email_addresses_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_addresses_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_email_addresses_audit_parent_id` (`parent_id`),
  KEY `idx_email_addresses_audit_event_id` (`event_id`),
  KEY `idx_email_addresses_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_email_addresses_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email_cache`
--

DROP TABLE IF EXISTS `email_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_cache` (
  `ie_id` char(36) DEFAULT NULL,
  `mbox` varchar(60) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `fromaddr` varchar(100) DEFAULT NULL,
  `toaddr` varchar(255) DEFAULT NULL,
  `senddate` datetime DEFAULT NULL,
  `message_id` varchar(255) DEFAULT NULL,
  `mailsize` int(10) unsigned DEFAULT NULL,
  `imap_uid` int(10) unsigned DEFAULT NULL,
  `msgno` int(10) unsigned DEFAULT NULL,
  `recent` tinyint(4) DEFAULT NULL,
  `flagged` tinyint(4) DEFAULT NULL,
  `answered` tinyint(4) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `seen` tinyint(4) DEFAULT NULL,
  `draft` tinyint(4) DEFAULT NULL,
  KEY `idx_ie_id` (`ie_id`),
  KEY `idx_mail_date` (`ie_id`,`mbox`,`senddate`),
  KEY `idx_mail_from` (`ie_id`,`mbox`,`fromaddr`),
  KEY `idx_mail_subj` (`subject`),
  KEY `idx_mail_to` (`toaddr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email_marketing`
--

DROP TABLE IF EXISTS `email_marketing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_marketing` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `from_name` varchar(100) DEFAULT NULL,
  `from_addr` varchar(100) DEFAULT NULL,
  `reply_to_name` varchar(100) DEFAULT NULL,
  `reply_to_addr` varchar(100) DEFAULT NULL,
  `inbound_email_id` char(36) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `template_id` char(36) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `all_prospect_lists` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_emmkt_name` (`name`),
  KEY `idx_emmkit_del` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email_marketing_prospect_lists`
--

DROP TABLE IF EXISTS `email_marketing_prospect_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_marketing_prospect_lists` (
  `id` char(36) NOT NULL,
  `prospect_list_id` char(36) DEFAULT NULL,
  `email_marketing_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `email_mp_prospects` (`email_marketing_id`,`prospect_list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_templates` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `published` varchar(3) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  `body_html` text,
  `deleted` tinyint(1) DEFAULT '0',
  `base_module` varchar(50) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `from_address` varchar(255) DEFAULT NULL,
  `text_only` tinyint(1) DEFAULT '0',
  `type` varchar(255) DEFAULT 'email',
  `has_variables` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_email_template_name` (`name`),
  KEY `idx_emailtemplate_type` (`type`),
  KEY `idx_emailtemplate_date_modified` (`date_modified`),
  KEY `idx_emailtemplate_date_entered` (`date_entered`),
  KEY `idx_email_templates_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_email_templates_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `emailman`
--

DROP TABLE IF EXISTS `emailman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emailman` (
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` char(36) DEFAULT NULL,
  `marketing_id` char(36) DEFAULT NULL,
  `list_id` char(36) DEFAULT NULL,
  `send_date_time` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `in_queue` tinyint(1) DEFAULT '0',
  `in_queue_date` datetime DEFAULT NULL,
  `send_attempts` int(11) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  `related_id` char(36) DEFAULT NULL,
  `related_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_eman_list` (`list_id`,`user_id`,`deleted`),
  KEY `idx_eman_campaign_id` (`campaign_id`),
  KEY `idx_eman_relid_reltype_id` (`related_id`,`related_type`,`campaign_id`),
  KEY `idx_emailman_send_date_time` (`send_date_time`),
  KEY `idx_emailman_send_attempts` (`send_attempts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_sent` datetime DEFAULT NULL,
  `message_id` varchar(255) DEFAULT NULL,
  `message_uid` varchar(64) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `flagged` tinyint(1) DEFAULT '0',
  `reply_to_status` tinyint(1) DEFAULT '0',
  `intent` varchar(100) DEFAULT 'pick',
  `mailbox_id` char(36) DEFAULT NULL,
  `state` varchar(100) NOT NULL DEFAULT 'Archived',
  `reply_to_id` char(36) DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `total_attachments` int(11) DEFAULT NULL,
  `outbound_email_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_email_name` (`name`),
  KEY `idx_message_id` (`message_id`),
  KEY `idx_email_parent_id` (`parent_id`),
  KEY `idx_email_assigned` (`assigned_user_id`,`type`,`status`),
  KEY `idx_date_modified` (`date_modified`),
  KEY `idx_state` (`state`,`id`),
  KEY `idx_mailbox_id` (`mailbox_id`),
  KEY `idx_emails_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `emails_beans`
--

DROP TABLE IF EXISTS `emails_beans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails_beans` (
  `id` char(36) NOT NULL,
  `email_id` char(36) DEFAULT NULL,
  `bean_id` char(36) DEFAULT NULL,
  `bean_module` varchar(100) DEFAULT NULL,
  `campaign_data` text,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_emails_beans_bean_id` (`bean_id`),
  KEY `idx_emails_beans_email_bean` (`email_id`,`bean_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `emails_email_addr_rel`
--

DROP TABLE IF EXISTS `emails_email_addr_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails_email_addr_rel` (
  `id` char(36) NOT NULL,
  `email_id` char(36) DEFAULT NULL,
  `address_type` varchar(4) DEFAULT NULL,
  `email_address_id` char(36) DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_eearl_email_id` (`email_id`,`address_type`),
  KEY `idx_eearl_email_address_deleted` (`email_address_id`,`deleted`),
  KEY `idx_eearl_email_address_role` (`email_address_id`,`address_type`,`deleted`),
  KEY `idx_eearl_parent` (`parent_type`,`parent_id`,`deleted`),
  KEY `idx_eearl_parent_role` (`parent_type`,`parent_id`,`address_type`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `emails_text`
--

DROP TABLE IF EXISTS `emails_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails_text` (
  `email_id` char(36) NOT NULL,
  `from_addr` varchar(255) DEFAULT NULL,
  `reply_to_addr` varchar(255) DEFAULT NULL,
  `to_addrs` text,
  `cc_addrs` text,
  `bcc_addrs` text,
  `description` longtext,
  `description_html` longtext,
  `raw_source` longtext,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`email_id`),
  KEY `emails_textfromaddr` (`from_addr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `embedded_files`
--

DROP TABLE IF EXISTS `embedded_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `embedded_files` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `filename` varchar(255) DEFAULT NULL,
  `file_mime_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_embedded_files_date_modfied` (`date_modified`),
  KEY `idx_embedded_files_id_del` (`id`,`deleted`),
  KEY `idx_embedded_files_date_entered` (`date_entered`),
  KEY `idx_embedded_files_name_del` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `erased_fields`
--

DROP TABLE IF EXISTS `erased_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `erased_fields` (
  `bean_id` char(36) NOT NULL,
  `table_name` varchar(128) NOT NULL,
  `data` text,
  PRIMARY KEY (`bean_id`,`table_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `expressions`
--

DROP TABLE IF EXISTS `expressions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expressions` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `lhs_type` varchar(15) DEFAULT NULL,
  `lhs_field` varchar(50) DEFAULT NULL,
  `lhs_module` varchar(50) DEFAULT NULL,
  `lhs_value` varchar(100) DEFAULT NULL,
  `lhs_group_type` varchar(10) DEFAULT NULL,
  `operator` varchar(15) DEFAULT NULL,
  `rhs_group_type` varchar(10) DEFAULT NULL,
  `rhs_type` varchar(15) DEFAULT NULL,
  `rhs_field` varchar(50) DEFAULT NULL,
  `rhs_module` varchar(50) DEFAULT NULL,
  `rhs_value` varchar(255) DEFAULT NULL,
  `parent_id` char(36) NOT NULL,
  `exp_type` varchar(100) DEFAULT NULL,
  `exp_order` int(4) DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `parent_exp_id` char(36) DEFAULT NULL,
  `parent_exp_side` int(8) DEFAULT NULL,
  `ext1` varchar(50) DEFAULT NULL,
  `ext2` varchar(50) DEFAULT NULL,
  `ext3` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_exp` (`parent_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fields_meta_data`
--

DROP TABLE IF EXISTS `fields_meta_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fields_meta_data` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `vname` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `help` varchar(255) DEFAULT NULL,
  `custom_module` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `len` int(11) DEFAULT NULL,
  `required` tinyint(1) DEFAULT '0',
  `default_value` varchar(255) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `audited` tinyint(1) DEFAULT '0',
  `massupdate` tinyint(1) DEFAULT '0',
  `duplicate_merge` smallint(6) DEFAULT '0',
  `reportable` tinyint(1) DEFAULT '1',
  `importable` varchar(255) DEFAULT NULL,
  `ext1` varchar(255) DEFAULT '',
  `ext2` varchar(255) DEFAULT '',
  `ext3` varchar(255) DEFAULT '',
  `ext4` text,
  PRIMARY KEY (`id`),
  KEY `idx_meta_id_del` (`id`,`deleted`),
  KEY `idx_meta_cm_del` (`custom_module`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filters`
--

DROP TABLE IF EXISTS `filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filters` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `filter_definition` longtext,
  `filter_template` longtext,
  `module_name` varchar(100) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_filters_date_modfied` (`date_modified`),
  KEY `idx_filters_id_del` (`id`,`deleted`),
  KEY `idx_filters_date_entered` (`date_entered`),
  KEY `idx_filters_name_del` (`name`,`deleted`),
  KEY `idx_filters_tmst_id` (`team_set_id`),
  KEY `idx_filters_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `folders`
--

DROP TABLE IF EXISTS `folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folders` (
  `id` char(36) NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `folder_type` varchar(25) DEFAULT NULL,
  `parent_folder` char(36) DEFAULT NULL,
  `has_child` tinyint(1) DEFAULT '0',
  `is_group` tinyint(1) DEFAULT '0',
  `is_dynamic` tinyint(1) DEFAULT '0',
  `dynamic_query` text,
  `assign_to_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `created_by` char(36) NOT NULL,
  `modified_by` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_parent_folder` (`parent_folder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `folders_rel`
--

DROP TABLE IF EXISTS `folders_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folders_rel` (
  `id` char(36) NOT NULL,
  `folder_id` char(36) NOT NULL,
  `polymorphic_module` varchar(25) DEFAULT NULL,
  `polymorphic_id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_poly_module_poly_id` (`polymorphic_module`,`polymorphic_id`),
  KEY `idx_fr_id_deleted_poly` (`folder_id`,`deleted`,`polymorphic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `folders_subscriptions`
--

DROP TABLE IF EXISTS `folders_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folders_subscriptions` (
  `id` char(36) NOT NULL,
  `folder_id` char(36) NOT NULL,
  `assigned_user_id` char(36) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_folder_id_assigned_user_id` (`folder_id`,`assigned_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forecast_manager_worksheets`
--

DROP TABLE IF EXISTS `forecast_manager_worksheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forecast_manager_worksheets` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `quota` decimal(26,6) DEFAULT NULL,
  `best_case` decimal(26,6) DEFAULT NULL,
  `best_case_adjusted` decimal(26,6) DEFAULT NULL,
  `likely_case` decimal(26,6) DEFAULT NULL,
  `likely_case_adjusted` decimal(26,6) DEFAULT NULL,
  `worst_case` decimal(26,6) DEFAULT NULL,
  `worst_case_adjusted` decimal(26,6) DEFAULT NULL,
  `timeperiod_id` char(36) DEFAULT NULL,
  `draft` tinyint(1) DEFAULT '0',
  `user_id` char(36) DEFAULT NULL,
  `opp_count` int(5) DEFAULT NULL,
  `pipeline_opp_count` int(5) DEFAULT '0',
  `pipeline_amount` decimal(26,6) DEFAULT '0.000000',
  `closed_amount` decimal(26,6) DEFAULT '0.000000',
  `manager_saved` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_forecast_manager_worksheets_date_modfied` (`date_modified`),
  KEY `idx_forecast_manager_worksheets_id_del` (`id`,`deleted`),
  KEY `idx_forecast_manager_worksheets_date_entered` (`date_entered`),
  KEY `idx_forecast_manager_worksheets_name_del` (`name`,`deleted`),
  KEY `idx_manager_worksheets_user_timestamp_assigned_user` (`assigned_user_id`,`user_id`,`timeperiod_id`,`draft`,`deleted`),
  KEY `idx_forecast_manager_worksheets_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_forecast_manager_worksheets_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forecast_manager_worksheets_audit`
--

DROP TABLE IF EXISTS `forecast_manager_worksheets_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forecast_manager_worksheets_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_forecast_manager_worksheets_audit_parent_id` (`parent_id`),
  KEY `idx_forecast_manager_worksheets_audit_event_id` (`event_id`),
  KEY `idx_forecast_manager_worksheets_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_forecast_manager_worksheets_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forecast_tree`
--

DROP TABLE IF EXISTS `forecast_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forecast_tree` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `hierarchy_type` varchar(25) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `forecast_tree_idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forecast_worksheets`
--

DROP TABLE IF EXISTS `forecast_worksheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forecast_worksheets` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `parent_id` char(36) DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `opportunity_name` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `product_template_id` char(36) DEFAULT NULL,
  `product_template_name` varchar(255) DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `sales_status` varchar(255) DEFAULT NULL,
  `likely_case` decimal(26,6) DEFAULT NULL,
  `best_case` decimal(26,6) DEFAULT NULL,
  `worst_case` decimal(26,6) DEFAULT NULL,
  `date_closed` date DEFAULT NULL,
  `date_closed_timestamp` bigint(20) unsigned DEFAULT NULL,
  `sales_stage` varchar(255) DEFAULT NULL,
  `probability` double DEFAULT NULL,
  `commit_stage` varchar(50) DEFAULT NULL,
  `draft` int(11) DEFAULT '0',
  `next_step` varchar(100) DEFAULT NULL,
  `lead_source` varchar(50) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `list_price` decimal(26,6) DEFAULT NULL,
  `cost_price` decimal(26,6) DEFAULT NULL,
  `discount_price` decimal(26,6) DEFAULT NULL,
  `discount_amount` decimal(26,6) DEFAULT NULL,
  `quantity` int(5) DEFAULT '1',
  `total_amount` decimal(26,6) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_forecast_worksheets_date_modfied` (`date_modified`),
  KEY `idx_forecast_worksheets_id_del` (`id`,`deleted`),
  KEY `idx_forecast_worksheets_date_entered` (`date_entered`),
  KEY `idx_forecast_worksheets_name_del` (`name`,`deleted`),
  KEY `idx_worksheets_parent` (`parent_id`,`parent_type`),
  KEY `idx_worksheets_assigned_del_time_draft_parent_type` (`deleted`,`assigned_user_id`,`draft`,`date_closed_timestamp`,`parent_type`),
  KEY `idx_forecastworksheet_commit_stage` (`commit_stage`),
  KEY `idx_forecastworksheet_sales_stage` (`sales_stage`),
  KEY `idx_forecast_worksheets_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_forecast_worksheets_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forecasts`
--

DROP TABLE IF EXISTS `forecasts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forecasts` (
  `id` char(36) NOT NULL,
  `timeperiod_id` char(36) DEFAULT NULL,
  `forecast_type` varchar(100) DEFAULT NULL,
  `opp_count` int(5) DEFAULT NULL,
  `pipeline_opp_count` int(5) DEFAULT '0',
  `pipeline_amount` decimal(26,6) DEFAULT '0.000000',
  `closed_amount` decimal(26,6) DEFAULT '0.000000',
  `opp_weigh_value` int(11) DEFAULT NULL,
  `best_case` decimal(26,6) DEFAULT NULL,
  `likely_case` decimal(26,6) DEFAULT NULL,
  `worst_case` decimal(26,6) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_forecast_user_tp` (`user_id`,`timeperiod_id`,`date_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fts_queue`
--

DROP TABLE IF EXISTS `fts_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fts_queue` (
  `id` char(36) NOT NULL,
  `bean_id` char(36) DEFAULT NULL,
  `bean_module` varchar(100) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `processed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_beans_bean_id` (`bean_module`,`bean_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holidays` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `holiday_date` date DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `person_id` char(36) DEFAULT NULL,
  `person_type` varchar(255) DEFAULT NULL,
  `related_module` varchar(255) DEFAULT NULL,
  `related_module_id` char(36) DEFAULT NULL,
  `resource_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_holiday_id_del` (`id`,`deleted`),
  KEY `idx_holiday_id_rel` (`related_module_id`,`related_module`),
  KEY `idx_holiday_holiday_date` (`holiday_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_assets_and_objects`
--

DROP TABLE IF EXISTS `ht_assets_and_objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_assets_and_objects` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `asset_number` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_number` (`asset_number`),
  KEY `idx_ht_assets_and_objects_date_modfied` (`date_modified`),
  KEY `idx_ht_assets_and_objects_id_del` (`id`,`deleted`),
  KEY `idx_ht_assets_and_objects_date_entered` (`date_entered`),
  KEY `idx_ht_assets_and_objects_name_del` (`name`,`deleted`),
  KEY `idx_ht_assets_and_objects_tmst_id` (`team_set_id`),
  KEY `idx_ht_assets_and_objects_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_assets_and_objects_audit`
--

DROP TABLE IF EXISTS `ht_assets_and_objects_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_assets_and_objects_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_ht_assets_and_objects_audit_parent_id` (`parent_id`),
  KEY `idx_ht_assets_and_objects_audit_event_id` (`event_id`),
  KEY `idx_ht_assets_and_objects_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_ht_assets_and_objects_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_assets_and_objects_cstm`
--

DROP TABLE IF EXISTS `ht_assets_and_objects_cstm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_assets_and_objects_cstm` (
  `id_c` char(36) NOT NULL,
  `asset_type_c` varchar(100) DEFAULT 'Trucks',
  `model_year_c` varchar(255) DEFAULT '',
  `make_c` varchar(255) DEFAULT '',
  `model_c` varchar(255) DEFAULT '',
  `serial_vin_c` varchar(255) DEFAULT '',
  `object_no_c` varchar(255) DEFAULT '',
  `picture_c` varchar(255) DEFAULT NULL,
  `ins_exp_c` varchar(255) DEFAULT '',
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_assets_and_objects_documents_1_c`
--

DROP TABLE IF EXISTS `ht_assets_and_objects_documents_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_assets_and_objects_documents_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `ht_assets_and_objects_documents_1ht_assets_and_objects_ida` char(36) DEFAULT NULL,
  `ht_assets_and_objects_documents_1documents_idb` char(36) DEFAULT NULL,
  `document_revision_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_assets_and_objects_documents_1_ida1_deleted` (`ht_assets_and_objects_documents_1ht_assets_and_objects_ida`,`deleted`),
  KEY `idx_ht_assets_and_objects_documents_1_idb2_deleted` (`ht_assets_and_objects_documents_1documents_idb`,`deleted`),
  KEY `ht_assets_and_objects_documents_1_alt` (`ht_assets_and_objects_documents_1ht_assets_and_objects_ida`,`ht_assets_and_objects_documents_1documents_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_manifest`
--

DROP TABLE IF EXISTS `ht_manifest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_manifest` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `sales_and_service_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `manifest_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_manifest_date_modfied` (`date_modified`),
  KEY `idx_ht_manifest_id_del` (`id`,`deleted`),
  KEY `idx_ht_manifest_date_entered` (`date_entered`),
  KEY `idx_ht_manifest_name_del` (`name`,`deleted`),
  KEY `idx_ht_manifest_tmst_id` (`team_set_id`),
  KEY `idx_ht_manifest_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_manifest_audit`
--

DROP TABLE IF EXISTS `ht_manifest_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_manifest_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_ht_manifest_audit_parent_id` (`parent_id`),
  KEY `idx_ht_manifest_audit_event_id` (`event_id`),
  KEY `idx_ht_manifest_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_ht_manifest_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_manifest_cstm`
--

DROP TABLE IF EXISTS `ht_manifest_cstm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_manifest_cstm` (
  `id_c` char(36) NOT NULL,
  `shipping_address_street_c` varchar(150) DEFAULT NULL,
  `shipping_address_city_c` varchar(100) DEFAULT NULL,
  `shipping_address_state_c` varchar(100) DEFAULT NULL,
  `shipping_address_postalcode_c` varchar(20) DEFAULT NULL,
  `shipping_address_country_c` varchar(100) DEFAULT NULL,
  `status_c` varchar(100) DEFAULT 'Active',
  `consolidate_c` tinyint(1) DEFAULT '0',
  `start_date_c` date DEFAULT NULL,
  `complete_date_c` date DEFAULT NULL,
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_manifest_ht_assets_and_objects_c`
--

DROP TABLE IF EXISTS `ht_manifest_ht_assets_and_objects_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_manifest_ht_assets_and_objects_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `ht_manifest_ht_assets_and_objectsht_manifest_ida` char(36) DEFAULT NULL,
  `ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb` char(36) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_manifest_ht_assets_and_objects_ida1_deleted` (`ht_manifest_ht_assets_and_objectsht_manifest_ida`,`deleted`),
  KEY `idx_ht_manifest_ht_assets_and_objects_idb2_deleted` (`ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb`,`deleted`),
  KEY `ht_manifest_ht_assets_and_objects_alt` (`ht_manifest_ht_assets_and_objectsht_manifest_ida`,`ht_manifest_ht_assets_and_objectsht_assets_and_objects_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_manifest_lr_lab_reports_1_c`
--

DROP TABLE IF EXISTS `ht_manifest_lr_lab_reports_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_manifest_lr_lab_reports_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `ht_manifest_lr_lab_reports_1ht_manifest_ida` char(36) DEFAULT NULL,
  `ht_manifest_lr_lab_reports_1lr_lab_reports_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_manifest_lr_lab_reports_1_ida1_deleted` (`ht_manifest_lr_lab_reports_1ht_manifest_ida`,`deleted`),
  KEY `idx_ht_manifest_lr_lab_reports_1_idb2_deleted` (`ht_manifest_lr_lab_reports_1lr_lab_reports_idb`,`deleted`),
  KEY `ht_manifest_lr_lab_reports_1_alt` (`ht_manifest_lr_lab_reports_1lr_lab_reports_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_manifest_revenuelineitems_1_c`
--

DROP TABLE IF EXISTS `ht_manifest_revenuelineitems_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_manifest_revenuelineitems_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `ht_manifest_revenuelineitems_1ht_manifest_ida` char(36) DEFAULT NULL,
  `ht_manifest_revenuelineitems_1revenuelineitems_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_manifest_revenuelineitems_1_ida1_deleted` (`ht_manifest_revenuelineitems_1ht_manifest_ida`,`deleted`),
  KEY `idx_ht_manifest_revenuelineitems_1_idb2_deleted` (`ht_manifest_revenuelineitems_1revenuelineitems_idb`,`deleted`),
  KEY `ht_manifest_revenuelineitems_1_alt` (`ht_manifest_revenuelineitems_1ht_manifest_ida`,`ht_manifest_revenuelineitems_1revenuelineitems_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_manifest_sales_and_services_1_c`
--

DROP TABLE IF EXISTS `ht_manifest_sales_and_services_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_manifest_sales_and_services_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `ht_manifest_sales_and_services_1ht_manifest_ida` char(36) DEFAULT NULL,
  `ht_manifest_sales_and_services_1sales_and_services_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_manifest_sales_and_services_1_ida1_deleted` (`ht_manifest_sales_and_services_1ht_manifest_ida`,`deleted`),
  KEY `idx_ht_manifest_sales_and_services_1_idb2_deleted` (`ht_manifest_sales_and_services_1sales_and_services_idb`,`deleted`),
  KEY `ht_manifest_sales_and_services_1_alt` (`ht_manifest_sales_and_services_1ht_manifest_ida`,`ht_manifest_sales_and_services_1sales_and_services_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_manifest_v_vendors_c`
--

DROP TABLE IF EXISTS `ht_manifest_v_vendors_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_manifest_v_vendors_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `ht_manifest_v_vendorsht_manifest_ida` char(36) DEFAULT NULL,
  `ht_manifest_v_vendorsv_vendors_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_manifest_v_vendors_ida1_deleted` (`ht_manifest_v_vendorsht_manifest_ida`,`deleted`),
  KEY `idx_ht_manifest_v_vendors_idb2_deleted` (`ht_manifest_v_vendorsv_vendors_idb`,`deleted`),
  KEY `ht_manifest_v_vendors_alt` (`ht_manifest_v_vendorsht_manifest_ida`,`ht_manifest_v_vendorsv_vendors_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_po`
--

DROP TABLE IF EXISTS `ht_po`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_po` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `po_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `po_status` varchar(255) DEFAULT 'Open',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_po_date_modfied` (`date_modified`),
  KEY `idx_ht_po_id_del` (`id`,`deleted`),
  KEY `idx_ht_po_date_entered` (`date_entered`),
  KEY `idx_ht_po_name_del` (`name`,`deleted`),
  KEY `idx_ht_po_tmst_id` (`team_set_id`),
  KEY `idx_ht_po_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_po_accounts_c`
--

DROP TABLE IF EXISTS `ht_po_accounts_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_po_accounts_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `ht_po_accountsaccounts_ida` char(36) DEFAULT NULL,
  `ht_po_accountsht_po_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_po_accounts_ida1_deleted` (`ht_po_accountsaccounts_ida`,`deleted`),
  KEY `idx_ht_po_accounts_idb2_deleted` (`ht_po_accountsht_po_idb`,`deleted`),
  KEY `ht_po_accounts_alt` (`ht_po_accountsht_po_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_po_audit`
--

DROP TABLE IF EXISTS `ht_po_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_po_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_ht_po_audit_parent_id` (`parent_id`),
  KEY `idx_ht_po_audit_event_id` (`event_id`),
  KEY `idx_ht_po_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_ht_po_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_product_bundle_note`
--

DROP TABLE IF EXISTS `ht_product_bundle_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_product_bundle_note` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `bundle_id` char(36) DEFAULT NULL,
  `note_id` char(36) DEFAULT NULL,
  `note_index` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pbn_bundle` (`bundle_id`),
  KEY `idx_pbn_note` (`note_id`),
  KEY `idx_pbn_pb_nb` (`note_id`,`bundle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_product_bundle_product`
--

DROP TABLE IF EXISTS `ht_product_bundle_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_product_bundle_product` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `bundle_id` char(36) DEFAULT NULL,
  `product_id` char(36) DEFAULT NULL,
  `product_index` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pbp_bundle` (`bundle_id`),
  KEY `idx_pbp_quote` (`product_id`),
  KEY `idx_pbp_bq` (`product_id`,`bundle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_product_bundle_quote`
--

DROP TABLE IF EXISTS `ht_product_bundle_quote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_product_bundle_quote` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `bundle_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `bundle_index` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pbq_bundle` (`bundle_id`),
  KEY `idx_pbq_quote` (`quote_id`),
  KEY `idx_pbq_bq` (`quote_id`,`bundle_id`),
  KEY `bundle_index_idx` (`bundle_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_product_ht_product`
--

DROP TABLE IF EXISTS `ht_product_ht_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_product_ht_product` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `child_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pp_parent` (`parent_id`),
  KEY `idx_pp_child` (`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_quotes_accounts`
--

DROP TABLE IF EXISTS `ht_quotes_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_quotes_accounts` (
  `id` char(36) NOT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `account_role` varchar(20) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_acc_qte_acc` (`account_id`),
  KEY `idx_acc_qte_opp` (`quote_id`),
  KEY `idx_quote_account_role` (`quote_id`,`account_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_quotes_contacts`
--

DROP TABLE IF EXISTS `ht_quotes_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_quotes_contacts` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `contact_role` varchar(20) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_con_qte_con` (`contact_id`),
  KEY `idx_con_qte_opp` (`quote_id`),
  KEY `idx_quote_contact_role` (`quote_id`,`contact_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_quotes_opportunities`
--

DROP TABLE IF EXISTS `ht_quotes_opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_quotes_opportunities` (
  `id` char(36) NOT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_opp_qte_opp` (`opportunity_id`),
  KEY `idx_quote_oportunities` (`quote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_sales_service_catalog`
--

DROP TABLE IF EXISTS `ht_sales_service_catalog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_sales_service_catalog` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  `type_id` char(36) DEFAULT NULL,
  `manufacturer_id` char(36) DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `mft_part_num` varchar(50) DEFAULT NULL,
  `vendor_part_num` varchar(50) DEFAULT NULL,
  `date_cost_price` date DEFAULT NULL,
  `cost_price` decimal(26,6) DEFAULT NULL,
  `discount_price` decimal(26,6) DEFAULT NULL,
  `list_price` decimal(26,6) DEFAULT NULL,
  `cost_usdollar` decimal(26,6) DEFAULT NULL,
  `discount_usdollar` decimal(26,6) DEFAULT NULL,
  `list_usdollar` decimal(26,6) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `tax_class` varchar(100) DEFAULT NULL,
  `date_available` date DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `weight` decimal(12,2) DEFAULT NULL,
  `qty_in_stock` int(5) DEFAULT NULL,
  `support_name` varchar(50) DEFAULT NULL,
  `support_description` varchar(255) DEFAULT NULL,
  `support_contact` varchar(50) DEFAULT NULL,
  `support_term` varchar(100) DEFAULT NULL,
  `pricing_formula` varchar(100) DEFAULT NULL,
  `pricing_factor` decimal(8,2) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_sales_service_catalog_date_modfied` (`date_modified`),
  KEY `idx_ht_sales_service_catalog_id_del` (`id`,`deleted`),
  KEY `idx_ht_sales_service_catalog_date_entered` (`date_entered`),
  KEY `idx_ht_sales_service_catalog_name_del` (`name`,`deleted`),
  KEY `idx_ht_sales_service_catalog_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_ss_catalog_status` (`status`),
  KEY `idx_ss_catalog_qty_in_stock` (`qty_in_stock`),
  KEY `idx_ss_catalog_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_sales_service_catalog_audit`
--

DROP TABLE IF EXISTS `ht_sales_service_catalog_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_sales_service_catalog_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_ht_sales_service_catalog_audit_parent_id` (`parent_id`),
  KEY `idx_ht_sales_service_catalog_audit_event_id` (`event_id`),
  KEY `idx_ht_sales_service_catalog_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_ht_sales_service_catalog_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_sales_service_products`
--

DROP TABLE IF EXISTS `ht_sales_service_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_sales_service_products` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `revenuelineitem_id` char(36) DEFAULT NULL,
  `ht_sales_service_catalog_id` char(36) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `subtotal` decimal(26,6) DEFAULT '0.000000',
  `total_amount` decimal(26,6) DEFAULT '0.000000',
  `type_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `manufacturer_id` char(36) DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `mft_part_num` varchar(50) DEFAULT NULL,
  `vendor_part_num` varchar(50) DEFAULT NULL,
  `date_purchased` date DEFAULT NULL,
  `cost_price` decimal(26,6) DEFAULT NULL,
  `discount_price` decimal(26,6) DEFAULT '0.000000',
  `discount_amount` decimal(26,6) DEFAULT '0.000000',
  `discount_rate_percent` decimal(26,2) DEFAULT NULL,
  `discount_amount_usdollar` decimal(26,6) DEFAULT NULL,
  `discount_select` tinyint(1) DEFAULT '1',
  `deal_calc` decimal(26,6) DEFAULT NULL,
  `deal_calc_usdollar` decimal(26,6) DEFAULT NULL,
  `list_price` decimal(26,6) DEFAULT NULL,
  `cost_usdollar` decimal(26,6) DEFAULT NULL,
  `discount_usdollar` decimal(26,6) DEFAULT NULL,
  `list_usdollar` decimal(26,6) DEFAULT NULL,
  `status` varchar(100) DEFAULT '',
  `tax_class` varchar(100) DEFAULT 'Taxable',
  `website` varchar(255) DEFAULT NULL,
  `weight` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT '1.00',
  `support_name` varchar(50) DEFAULT NULL,
  `support_description` varchar(255) DEFAULT NULL,
  `support_contact` varchar(50) DEFAULT NULL,
  `support_term` varchar(100) DEFAULT NULL,
  `date_support_expires` date DEFAULT NULL,
  `date_support_starts` date DEFAULT NULL,
  `pricing_formula` varchar(100) DEFAULT NULL,
  `pricing_factor` int(4) DEFAULT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `asset_number` varchar(50) DEFAULT NULL,
  `book_value` decimal(26,6) DEFAULT NULL,
  `book_value_usdollar` decimal(26,6) DEFAULT NULL,
  `book_value_date` date DEFAULT NULL,
  `date_closed` date DEFAULT NULL,
  `date_closed_timestamp` bigint(20) unsigned DEFAULT NULL,
  `next_step` varchar(100) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_sales_service_products_date_modfied` (`date_modified`),
  KEY `idx_ht_sales_service_products_id_del` (`id`,`deleted`),
  KEY `idx_ht_sales_service_products_date_entered` (`date_entered`),
  KEY `idx_ht_sales_service_products_name_del` (`name`,`deleted`),
  KEY `idx_ht_sales_service_products_tmst_id` (`team_set_id`),
  KEY `idx_ht_sales_service_products_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_prod_user_dc_timestamp` (`id`,`assigned_user_id`,`date_closed_timestamp`),
  KEY `idx_product_quantity` (`quantity`),
  KEY `idx_product_contact` (`contact_id`),
  KEY `idx_product_account` (`account_id`),
  KEY `idx_product_opp` (`opportunity_id`),
  KEY `idx_product_quote` (`quote_id`),
  KEY `idx_product_rli` (`revenuelineitem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_sales_service_products_audit`
--

DROP TABLE IF EXISTS `ht_sales_service_products_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_sales_service_products_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_ht_sales_service_products_audit_parent_id` (`parent_id`),
  KEY `idx_ht_sales_service_products_audit_event_id` (`event_id`),
  KEY `idx_ht_sales_service_products_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_ht_sales_service_products_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_ss_productbundles`
--

DROP TABLE IF EXISTS `ht_ss_productbundles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_ss_productbundles` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `bundle_stage` varchar(255) DEFAULT NULL,
  `taxrate_id` char(36) DEFAULT NULL,
  `tax` decimal(26,6) DEFAULT NULL,
  `tax_usdollar` decimal(26,6) DEFAULT NULL,
  `total` decimal(26,6) DEFAULT NULL,
  `total_usdollar` decimal(26,6) DEFAULT NULL,
  `subtotal_usdollar` decimal(26,6) DEFAULT NULL,
  `shipping_usdollar` decimal(26,6) DEFAULT NULL,
  `deal_tot` decimal(26,6) DEFAULT NULL,
  `deal_tot_usdollar` decimal(26,6) DEFAULT NULL,
  `new_sub` decimal(26,6) DEFAULT NULL,
  `new_sub_usdollar` decimal(26,6) DEFAULT NULL,
  `subtotal` decimal(26,6) DEFAULT NULL,
  `taxable_subtotal` decimal(26,6) DEFAULT NULL,
  `shipping` decimal(26,6) DEFAULT NULL,
  `default_group` tinyint(1) DEFAULT '0',
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_ss_productbundles_date_modfied` (`date_modified`),
  KEY `idx_ht_ss_productbundles_id_del` (`id`,`deleted`),
  KEY `idx_ht_ss_productbundles_date_entered` (`date_entered`),
  KEY `idx_ht_ss_productbundles_name_del` (`name`,`deleted`),
  KEY `idx_ht_ss_productbundles_tmst_id` (`team_set_id`),
  KEY `idx_ht_ss_productbundles_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_ss_productbundles_audit`
--

DROP TABLE IF EXISTS `ht_ss_productbundles_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_ss_productbundles_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_ht_ss_productbundles_audit_parent_id` (`parent_id`),
  KEY `idx_ht_ss_productbundles_audit_event_id` (`event_id`),
  KEY `idx_ht_ss_productbundles_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_ht_ss_productbundles_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_ss_productbundlesnotes`
--

DROP TABLE IF EXISTS `ht_ss_productbundlesnotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_ss_productbundlesnotes` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ht_ss_productbundlesnotes_date_modfied` (`date_modified`),
  KEY `idx_ht_ss_productbundlesnotes_id_del` (`id`,`deleted`),
  KEY `idx_ht_ss_productbundlesnotes_date_entered` (`date_entered`),
  KEY `idx_ht_ss_productbundlesnotes_name_del` (`name`,`deleted`),
  KEY `idx_ht_ss_productbundlesnotes_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_ss_productbundlesnotes_audit`
--

DROP TABLE IF EXISTS `ht_ss_productbundlesnotes_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_ss_productbundlesnotes_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_ht_ss_productbundlesnotes_audit_parent_id` (`parent_id`),
  KEY `idx_ht_ss_productbundlesnotes_audit_event_id` (`event_id`),
  KEY `idx_ht_ss_productbundlesnotes_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_ht_ss_productbundlesnotes_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_ss_quotes`
--

DROP TABLE IF EXISTS `ht_ss_quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_ss_quotes` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `shipper_id` char(36) DEFAULT NULL,
  `taxrate_id` char(36) DEFAULT NULL,
  `taxrate_value` decimal(26,6) DEFAULT '0.000000',
  `show_line_nums` tinyint(1) DEFAULT '1',
  `quote_type` varchar(255) DEFAULT NULL,
  `date_quote_expected_closed` date DEFAULT NULL,
  `original_po_date` date DEFAULT NULL,
  `payment_terms` varchar(128) DEFAULT NULL,
  `date_quote_closed` date DEFAULT NULL,
  `date_order_shipped` date DEFAULT NULL,
  `order_stage` varchar(100) DEFAULT NULL,
  `quote_stage` varchar(100) DEFAULT NULL,
  `purchase_order_num` varchar(50) DEFAULT NULL,
  `quote_num` int(11) NOT NULL AUTO_INCREMENT,
  `subtotal` decimal(26,6) DEFAULT NULL,
  `subtotal_usdollar` decimal(26,6) DEFAULT NULL,
  `shipping` decimal(26,6) DEFAULT '0.000000',
  `shipping_usdollar` decimal(26,6) DEFAULT NULL,
  `discount` decimal(26,6) DEFAULT NULL,
  `deal_tot` decimal(26,2) DEFAULT NULL,
  `deal_tot_discount_percentage` decimal(26,2) DEFAULT '0.00',
  `deal_tot_usdollar` decimal(26,2) DEFAULT NULL,
  `new_sub` decimal(26,6) DEFAULT NULL,
  `new_sub_usdollar` decimal(26,6) DEFAULT NULL,
  `taxable_subtotal` decimal(26,6) DEFAULT NULL,
  `tax` decimal(26,6) DEFAULT '0.000000',
  `tax_usdollar` decimal(26,6) DEFAULT NULL,
  `total` decimal(26,6) DEFAULT NULL,
  `total_usdollar` decimal(26,6) DEFAULT NULL,
  `billing_address_street` varchar(150) DEFAULT NULL,
  `billing_address_city` varchar(100) DEFAULT NULL,
  `billing_address_state` varchar(100) DEFAULT NULL,
  `billing_address_postalcode` varchar(20) DEFAULT NULL,
  `billing_address_country` varchar(100) DEFAULT NULL,
  `shipping_address_street` varchar(150) DEFAULT NULL,
  `shipping_address_city` varchar(100) DEFAULT NULL,
  `shipping_address_state` varchar(100) DEFAULT NULL,
  `shipping_address_postalcode` varchar(20) DEFAULT NULL,
  `shipping_address_country` varchar(100) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quote_num` (`quote_num`),
  KEY `idx_ht_ss_quotes_date_modfied` (`date_modified`),
  KEY `idx_ht_ss_quotes_id_del` (`id`,`deleted`),
  KEY `idx_ht_ss_quotes_date_entered` (`date_entered`),
  KEY `idx_ht_ss_quotes_name_del` (`name`,`deleted`),
  KEY `idx_qte_name` (`name`),
  KEY `idx_quote_quote_stage` (`quote_stage`),
  KEY `idx_quote_date_quote_expected_closed` (`date_quote_expected_closed`),
  KEY `idx_ht_ss_quotes_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_ht_ss_quotes_tmst_id` (`team_set_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ht_ss_quotes_audit`
--

DROP TABLE IF EXISTS `ht_ss_quotes_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ht_ss_quotes_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_ht_ss_quotes_audit_parent_id` (`parent_id`),
  KEY `idx_ht_ss_quotes_audit_event_id` (`event_id`),
  KEY `idx_ht_ss_quotes_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_ht_ss_quotes_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `import_maps`
--

DROP TABLE IF EXISTS `import_maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `import_maps` (
  `id` char(36) NOT NULL,
  `name` varchar(254) DEFAULT NULL,
  `source` varchar(36) DEFAULT NULL,
  `enclosure` varchar(1) DEFAULT ' ',
  `delimiter` varchar(1) DEFAULT ',',
  `module` varchar(36) DEFAULT NULL,
  `content` text,
  `default_values` text,
  `has_header` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `is_published` varchar(3) DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `idx_owner_module_name` (`assigned_user_id`,`module`,`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inbound_email`
--

DROP TABLE IF EXISTS `inbound_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inbound_email` (
  `id` varchar(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Active',
  `server_url` varchar(100) DEFAULT NULL,
  `email_user` varchar(100) DEFAULT NULL,
  `email_password` varchar(100) DEFAULT NULL,
  `port` int(5) DEFAULT NULL,
  `service` varchar(50) DEFAULT NULL,
  `mailbox` text,
  `delete_seen` tinyint(1) DEFAULT '0',
  `mailbox_type` varchar(10) DEFAULT NULL,
  `template_id` char(36) DEFAULT NULL,
  `stored_options` text,
  `group_id` char(36) DEFAULT NULL,
  `is_personal` tinyint(1) DEFAULT '0',
  `groupfolder_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_deleted` (`deleted`),
  KEY `idx_inbound_email_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inbound_email_autoreply`
--

DROP TABLE IF EXISTS `inbound_email_autoreply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inbound_email_autoreply` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `autoreplied_to` varchar(100) DEFAULT NULL,
  `ie_id` char(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_ie_autoreplied_to` (`autoreplied_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `inbound_email_cache_ts`
--

DROP TABLE IF EXISTS `inbound_email_cache_ts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inbound_email_cache_ts` (
  `id` varchar(255) NOT NULL,
  `ie_timestamp` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job_queue`
--

DROP TABLE IF EXISTS `job_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_queue` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `scheduler_id` char(36) DEFAULT NULL,
  `execute_time` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `resolution` varchar(20) DEFAULT NULL,
  `message` text,
  `target` varchar(255) DEFAULT NULL,
  `data` longtext,
  `requeue` tinyint(1) DEFAULT '0',
  `retry_count` tinyint(4) DEFAULT NULL,
  `failure_count` tinyint(4) DEFAULT NULL,
  `job_delay` int(11) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `percent_complete` int(11) DEFAULT NULL,
  `job_group` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `fallible` tinyint(1) DEFAULT '0',
  `rerun` tinyint(1) DEFAULT '0',
  `interface` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status_scheduler` (`status`,`scheduler_id`),
  KEY `idx_status_time` (`status`,`execute_time`,`date_entered`),
  KEY `idx_status_entered` (`status`,`date_entered`),
  KEY `idx_status_modified` (`status`,`date_modified`),
  KEY `idx_group_status` (`job_group`,`status`),
  KEY `idx_job_queue_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job_queue_audit`
--

DROP TABLE IF EXISTS `job_queue_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_queue_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_job_queue_audit_parent_id` (`parent_id`),
  KEY `idx_job_queue_audit_event_id` (`event_id`),
  KEY `idx_job_queue_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_job_queue_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kbarticles`
--

DROP TABLE IF EXISTS `kbarticles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kbarticles` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `kbdocument_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_kbarticles_date_modfied` (`date_modified`),
  KEY `idx_kbarticles_id_del` (`id`,`deleted`),
  KEY `idx_kbarticles_date_entered` (`date_entered`),
  KEY `idx_kbarticles_name_del` (`name`,`deleted`),
  KEY `idx_kbarticles_tmst_id` (`team_set_id`),
  KEY `idx_kbarticles_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kbcontent_templates`
--

DROP TABLE IF EXISTS `kbcontent_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kbcontent_templates` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `body` longtext,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_kbcontent_templates_date_modfied` (`date_modified`),
  KEY `idx_kbcontent_templates_id_del` (`id`,`deleted`),
  KEY `idx_kbcontent_templates_date_entered` (`date_entered`),
  KEY `idx_kbcontent_templates_name_del` (`name`,`deleted`),
  KEY `idx_kbcontent_templates_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kbcontent_templates_audit`
--

DROP TABLE IF EXISTS `kbcontent_templates_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kbcontent_templates_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_kbcontent_templates_audit_parent_id` (`parent_id`),
  KEY `idx_kbcontent_templates_audit_event_id` (`event_id`),
  KEY `idx_kbcontent_templates_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_kbcontent_templates_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kbcontents`
--

DROP TABLE IF EXISTS `kbcontents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kbcontents` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `kbdocument_body` longtext,
  `language` varchar(2) DEFAULT NULL,
  `active_date` date DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `approved` tinyint(1) DEFAULT '0',
  `status` varchar(100) DEFAULT 'draft',
  `viewcount` int(11) DEFAULT '0',
  `revision` int(11) DEFAULT '0',
  `useful` int(11) DEFAULT '0',
  `notuseful` int(11) DEFAULT '0',
  `kbdocument_id` char(36) DEFAULT NULL,
  `active_rev` tinyint(4) DEFAULT '0',
  `is_external` tinyint(1) DEFAULT '0',
  `kbarticle_id` char(36) DEFAULT NULL,
  `kbsapprover_id` char(36) DEFAULT NULL,
  `kbscase_id` char(36) DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_kbcontents_date_modfied` (`date_modified`),
  KEY `idx_kbcontents_id_del` (`id`,`deleted`),
  KEY `idx_kbcontents_date_entered` (`date_entered`),
  KEY `idx_kbcontents_name_del` (`name`,`deleted`),
  KEY `idx_kbcontent_name` (`name`),
  KEY `idx_kbcontent_del_doc_id` (`kbdocument_id`,`deleted`),
  KEY `idx_kbcontents_tmst_id` (`team_set_id`),
  KEY `idx_kbcontents_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kbcontents_audit`
--

DROP TABLE IF EXISTS `kbcontents_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kbcontents_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_kbcontents_audit_parent_id` (`parent_id`),
  KEY `idx_kbcontents_audit_event_id` (`event_id`),
  KEY `idx_kbcontents_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_kbcontents_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kbdocuments`
--

DROP TABLE IF EXISTS `kbdocuments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kbdocuments` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_kbdocuments_date_modfied` (`date_modified`),
  KEY `idx_kbdocuments_id_del` (`id`,`deleted`),
  KEY `idx_kbdocuments_date_entered` (`date_entered`),
  KEY `idx_kbdocuments_name_del` (`name`,`deleted`),
  KEY `idx_kbdocuments_tmst_id` (`team_set_id`),
  KEY `idx_kbdocuments_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kbusefulness`
--

DROP TABLE IF EXISTS `kbusefulness`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kbusefulness` (
  `id` char(36) NOT NULL,
  `kbarticle_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `vote` smallint(6) DEFAULT NULL,
  `zeroflag` tinyint(4) DEFAULT NULL,
  `ssid` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `kbusefulness_user` (`kbarticle_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `key_value_cache`
--

DROP TABLE IF EXISTS `key_value_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `key_value_cache` (
  `id` char(32) NOT NULL,
  `date_expires` datetime DEFAULT NULL,
  `value` longtext,
  PRIMARY KEY (`id`),
  KEY `key_value_cache_date_expires` (`date_expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leads` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `salutation` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `googleplus` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `do_not_call` tinyint(1) DEFAULT '0',
  `phone_home` varchar(100) DEFAULT NULL,
  `phone_mobile` varchar(100) DEFAULT NULL,
  `phone_work` varchar(100) DEFAULT NULL,
  `phone_other` varchar(100) DEFAULT NULL,
  `phone_fax` varchar(100) DEFAULT NULL,
  `primary_address_street` varchar(150) DEFAULT NULL,
  `primary_address_city` varchar(100) DEFAULT NULL,
  `primary_address_state` varchar(100) DEFAULT NULL,
  `primary_address_postalcode` varchar(20) DEFAULT NULL,
  `primary_address_country` varchar(255) DEFAULT NULL,
  `alt_address_street` varchar(150) DEFAULT NULL,
  `alt_address_city` varchar(100) DEFAULT NULL,
  `alt_address_state` varchar(100) DEFAULT NULL,
  `alt_address_postalcode` varchar(20) DEFAULT NULL,
  `alt_address_country` varchar(255) DEFAULT NULL,
  `assistant` varchar(75) DEFAULT NULL,
  `assistant_phone` varchar(100) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `converted` tinyint(1) DEFAULT '0',
  `refered_by` varchar(100) DEFAULT NULL,
  `lead_source` varchar(100) DEFAULT NULL,
  `lead_source_description` text,
  `status` varchar(100) DEFAULT 'New',
  `status_description` text,
  `reports_to_id` char(36) DEFAULT NULL,
  `dp_business_purpose` text,
  `dp_consent_last_updated` date DEFAULT NULL,
  `dnb_principal_id` varchar(30) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_description` text,
  `contact_id` char(36) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `opportunity_name` varchar(255) DEFAULT NULL,
  `opportunity_amount` varchar(50) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `portal_name` varchar(255) DEFAULT NULL,
  `portal_app` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `preferred_language` varchar(255) DEFAULT NULL,
  `mkto_sync` tinyint(1) DEFAULT '0',
  `mkto_id` int(11) DEFAULT NULL,
  `mkto_lead_score` int(11) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_leads_date_modfied` (`date_modified`),
  KEY `idx_leads_id_del` (`id`,`deleted`),
  KEY `idx_leads_date_entered` (`date_entered`),
  KEY `idx_leads_last_first` (`last_name`,`first_name`,`deleted`),
  KEY `idx_leads_first_last` (`first_name`,`last_name`,`deleted`),
  KEY `idx_lead_acct_name_first` (`account_name`,`deleted`),
  KEY `idx_lead_del_stat` (`last_name`,`status`,`deleted`,`first_name`),
  KEY `idx_lead_opp_del` (`opportunity_id`,`deleted`),
  KEY `idx_leads_acct_del` (`account_id`,`deleted`),
  KEY `idx_lead_assigned` (`assigned_user_id`),
  KEY `idx_lead_contact` (`contact_id`),
  KEY `idx_reports_to` (`reports_to_id`),
  KEY `idx_lead_phone_work` (`phone_work`),
  KEY `idx_lead_mkto_id` (`mkto_id`),
  KEY `idx_leads_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_leads_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `leads_audit`
--

DROP TABLE IF EXISTS `leads_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leads_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_leads_audit_parent_id` (`parent_id`),
  KEY `idx_leads_audit_event_id` (`event_id`),
  KEY `idx_leads_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_leads_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `leads_dataprivacy`
--

DROP TABLE IF EXISTS `leads_dataprivacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leads_dataprivacy` (
  `id` char(36) NOT NULL,
  `lead_id` char(36) DEFAULT NULL,
  `dataprivacy_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_lead_dataprivacy_lead` (`lead_id`),
  KEY `idx_lead_dataprivacy_dataprivacy` (`dataprivacy_id`),
  KEY `idx_leads_dataprivacy` (`lead_id`,`dataprivacy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `linked_documents`
--

DROP TABLE IF EXISTS `linked_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `linked_documents` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `parent_type` varchar(25) DEFAULT NULL,
  `document_id` char(36) DEFAULT NULL,
  `document_revision_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_parent_document` (`parent_type`,`parent_id`,`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locked_field_bean_rel`
--

DROP TABLE IF EXISTS `locked_field_bean_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locked_field_bean_rel` (
  `id` char(36) NOT NULL,
  `pd_id` char(36) NOT NULL,
  `bean_id` char(36) NOT NULL,
  `bean_module` varchar(100) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_locked_fields_rel_pdid_beanid` (`pd_id`,`bean_id`),
  KEY `idx_locked_field_bean_rel_del_bean_module_beanid` (`bean_module`,`deleted`),
  KEY `idx_locked_field_bean_rel_beanid_del_bean_module` (`bean_id`,`deleted`,`bean_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lr_lab_reports`
--

DROP TABLE IF EXISTS `lr_lab_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lr_lab_reports` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `document_name` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `file_ext` varchar(100) DEFAULT NULL,
  `file_mime_type` varchar(100) DEFAULT NULL,
  `active_date` date DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `category_id` varchar(100) DEFAULT NULL,
  `subcategory_id` varchar(100) DEFAULT NULL,
  `status_id` varchar(100) DEFAULT NULL,
  `report_number` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `report_numk` (`report_number`),
  KEY `idx_lr_lab_reports_date_modfied` (`date_modified`),
  KEY `idx_lr_lab_reports_id_del` (`id`,`deleted`),
  KEY `idx_lr_lab_reports_date_entered` (`date_entered`),
  KEY `idx_lr_lab_reports_tmst_id` (`team_set_id`),
  KEY `idx_lr_lab_reports_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lr_lab_reports_accounts_c`
--

DROP TABLE IF EXISTS `lr_lab_reports_accounts_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lr_lab_reports_accounts_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `lr_lab_reports_accountslr_lab_reports_ida` char(36) DEFAULT NULL,
  `lr_lab_reports_accountsaccounts_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_lr_lab_reports_accounts_ida1_deleted` (`lr_lab_reports_accountslr_lab_reports_ida`,`deleted`),
  KEY `idx_lr_lab_reports_accounts_idb2_deleted` (`lr_lab_reports_accountsaccounts_idb`,`deleted`),
  KEY `lr_lab_reports_accounts_alt` (`lr_lab_reports_accountslr_lab_reports_ida`,`lr_lab_reports_accountsaccounts_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lr_lab_reports_audit`
--

DROP TABLE IF EXISTS `lr_lab_reports_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lr_lab_reports_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_lr_lab_reports_audit_parent_id` (`parent_id`),
  KEY `idx_lr_lab_reports_audit_event_id` (`event_id`),
  KEY `idx_lr_lab_reports_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_lr_lab_reports_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lr_lab_reports_contacts_c`
--

DROP TABLE IF EXISTS `lr_lab_reports_contacts_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lr_lab_reports_contacts_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `lr_lab_reports_contactslr_lab_reports_ida` char(36) DEFAULT NULL,
  `lr_lab_reports_contactscontacts_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_lr_lab_reports_contacts_ida1_deleted` (`lr_lab_reports_contactslr_lab_reports_ida`,`deleted`),
  KEY `idx_lr_lab_reports_contacts_idb2_deleted` (`lr_lab_reports_contactscontacts_idb`,`deleted`),
  KEY `lr_lab_reports_contacts_alt` (`lr_lab_reports_contactslr_lab_reports_ida`,`lr_lab_reports_contactscontacts_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manufacturers`
--

DROP TABLE IF EXISTS `manufacturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manufacturers` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `list_order` int(4) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_manufacturers_date_modfied` (`date_modified`),
  KEY `idx_manufacturers_id_del` (`id`,`deleted`),
  KEY `idx_manufacturers_date_entered` (`date_entered`),
  KEY `idx_manufacturers_name_del` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meetings` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `location` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `join_url` varchar(600) DEFAULT NULL,
  `host_url` varchar(600) DEFAULT NULL,
  `displayed_url` varchar(400) DEFAULT NULL,
  `creator` varchar(50) DEFAULT NULL,
  `external_id` varchar(50) DEFAULT NULL,
  `duration_hours` int(11) DEFAULT '0',
  `duration_minutes` int(2) DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `parent_type` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Planned',
  `type` varchar(255) DEFAULT 'Sugar',
  `parent_id` char(36) DEFAULT NULL,
  `reminder_time` int(11) DEFAULT '-1',
  `email_reminder_time` int(11) DEFAULT '-1',
  `email_reminder_sent` tinyint(1) DEFAULT '0',
  `outlook_id` varchar(255) DEFAULT NULL,
  `sequence` int(11) DEFAULT '0',
  `repeat_type` varchar(36) DEFAULT NULL,
  `repeat_interval` int(3) DEFAULT '1',
  `repeat_dow` varchar(7) DEFAULT NULL,
  `repeat_until` date DEFAULT NULL,
  `repeat_count` int(7) DEFAULT NULL,
  `repeat_selector` varchar(36) DEFAULT NULL,
  `repeat_days` varchar(128) DEFAULT NULL,
  `repeat_ordinal` varchar(36) DEFAULT NULL,
  `repeat_unit` varchar(36) DEFAULT NULL,
  `repeat_parent_id` char(36) DEFAULT NULL,
  `recurrence_id` datetime DEFAULT NULL,
  `recurring_source` varchar(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_meetings_date_modfied` (`date_modified`),
  KEY `idx_meetings_id_del` (`id`,`deleted`),
  KEY `idx_meetings_date_entered` (`date_entered`),
  KEY `idx_meetings_name_del` (`name`,`deleted`),
  KEY `idx_mtg_name` (`name`),
  KEY `idx_meet_par_del` (`parent_id`,`parent_type`,`deleted`),
  KEY `idx_meet_stat_del` (`assigned_user_id`,`status`,`deleted`),
  KEY `idx_meet_date_start` (`date_start`),
  KEY `idx_meet_recurrence_id` (`recurrence_id`),
  KEY `idx_meet_date_start_end_del` (`date_start`,`date_end`,`deleted`),
  KEY `idx_meet_repeat_parent_id` (`repeat_parent_id`,`deleted`),
  KEY `idx_meet_date_start_reminder` (`date_start`,`reminder_time`),
  KEY `idx_meetings_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_meetings_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `meetings_contacts`
--

DROP TABLE IF EXISTS `meetings_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meetings_contacts` (
  `id` char(36) NOT NULL,
  `meeting_id` char(36) DEFAULT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `required` varchar(1) DEFAULT '1',
  `accept_status` varchar(25) DEFAULT 'none',
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_con_mtg_mtg` (`meeting_id`),
  KEY `idx_con_mtg_con` (`contact_id`),
  KEY `idx_meeting_contact` (`meeting_id`,`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `meetings_leads`
--

DROP TABLE IF EXISTS `meetings_leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meetings_leads` (
  `id` char(36) NOT NULL,
  `meeting_id` char(36) DEFAULT NULL,
  `lead_id` char(36) DEFAULT NULL,
  `required` varchar(1) DEFAULT '1',
  `accept_status` varchar(25) DEFAULT 'none',
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_lead_meeting_meeting` (`meeting_id`),
  KEY `idx_lead_meeting_lead` (`lead_id`),
  KEY `idx_meeting_lead` (`meeting_id`,`lead_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `meetings_users`
--

DROP TABLE IF EXISTS `meetings_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meetings_users` (
  `id` char(36) NOT NULL,
  `meeting_id` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `required` varchar(1) DEFAULT '1',
  `accept_status` varchar(25) DEFAULT 'none',
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_usr_mtg_mtg` (`meeting_id`),
  KEY `idx_usr_mtg_usr` (`user_id`),
  KEY `idx_meeting_users` (`meeting_id`,`user_id`),
  KEY `idx_meeting_users_del` (`meeting_id`,`user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `metadata_cache`
--

DROP TABLE IF EXISTS `metadata_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metadata_cache` (
  `id` char(36) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `data` longblob,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `type_indx` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `file_mime_type` varchar(100) DEFAULT NULL,
  `file_ext` varchar(100) DEFAULT NULL,
  `file_source` varchar(32) DEFAULT NULL,
  `file_size` int(11) DEFAULT '0',
  `filename` varchar(255) DEFAULT NULL,
  `upload_id` char(36) DEFAULT NULL,
  `email_type` varchar(255) DEFAULT NULL,
  `email_id` char(36) DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `portal_flag` tinyint(1) DEFAULT '0',
  `embed_flag` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_notes_date_modfied` (`date_modified`),
  KEY `idx_notes_id_del` (`id`,`deleted`),
  KEY `idx_notes_date_entered` (`date_entered`),
  KEY `idx_notes_name_del` (`name`,`deleted`),
  KEY `idx_note_name` (`name`),
  KEY `idx_notes_parent` (`parent_id`,`parent_type`),
  KEY `idx_note_contact` (`contact_id`),
  KEY `idx_note_email_id` (`email_id`),
  KEY `idx_note_email_type` (`email_type`),
  KEY `idx_note_email` (`email_id`,`email_type`),
  KEY `idx_notes_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_notes_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `is_read` tinyint(1) DEFAULT '0',
  `severity` varchar(15) DEFAULT NULL,
  `parent_type` varchar(100) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_notifications_date_modfied` (`date_modified`),
  KEY `idx_notifications_id_del` (`id`,`deleted`),
  KEY `idx_notifications_date_entered` (`date_entered`),
  KEY `idx_notifications_name_del` (`name`,`deleted`),
  KEY `idx_notifications_my_unread_items` (`assigned_user_id`,`is_read`,`deleted`),
  KEY `idx_notifications_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications_audit`
--

DROP TABLE IF EXISTS `notifications_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_notifications_audit_parent_id` (`parent_id`),
  KEY `idx_notifications_audit_event_id` (`event_id`),
  KEY `idx_notifications_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_notifications_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oauth_consumer`
--

DROP TABLE IF EXISTS `oauth_consumer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_consumer` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `c_key` varchar(255) DEFAULT NULL,
  `c_secret` varchar(255) DEFAULT NULL,
  `oauth_type` varchar(50) DEFAULT 'oauth1',
  `client_type` varchar(50) DEFAULT 'user',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ckey` (`c_key`),
  KEY `idx_oauth_consumer_date_modfied` (`date_modified`),
  KEY `idx_oauth_consumer_id_del` (`id`,`deleted`),
  KEY `idx_oauth_consumer_date_entered` (`date_entered`),
  KEY `idx_oauth_consumer_name_del` (`name`,`deleted`),
  KEY `idx_oauthkey_name` (`name`),
  KEY `idx_oauthkey_client_type` (`client_type`),
  KEY `idx_oauth_consumer_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oauth_nonce`
--

DROP TABLE IF EXISTS `oauth_nonce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_nonce` (
  `conskey` varchar(32) NOT NULL,
  `nonce` varchar(32) NOT NULL,
  `nonce_ts` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`conskey`,`nonce`),
  KEY `oauth_nonce_keyts` (`conskey`,`nonce_ts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oauth_tokens`
--

DROP TABLE IF EXISTS `oauth_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_tokens` (
  `id` char(36) NOT NULL,
  `secret` varchar(32) DEFAULT NULL,
  `tstate` varchar(1) DEFAULT NULL,
  `consumer` char(36) NOT NULL,
  `token_ts` bigint(20) DEFAULT NULL,
  `expire_ts` bigint(20) DEFAULT '-1',
  `verify` varchar(32) DEFAULT NULL,
  `download_token` varchar(36) DEFAULT NULL,
  `platform` varchar(255) DEFAULT 'base',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `callback_url` varchar(255) DEFAULT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`,`deleted`),
  KEY `oauth_state_ts` (`tstate`,`token_ts`),
  KEY `constoken_key` (`consumer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `opportunities`
--

DROP TABLE IF EXISTS `opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opportunities` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `opportunity_type` varchar(255) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `lead_source` varchar(50) DEFAULT NULL,
  `amount` decimal(26,6) DEFAULT NULL,
  `amount_usdollar` decimal(26,6) DEFAULT NULL,
  `date_closed` date DEFAULT NULL,
  `date_closed_timestamp` bigint(20) unsigned DEFAULT NULL,
  `next_step` varchar(100) DEFAULT NULL,
  `sales_stage` varchar(255) DEFAULT 'Prospecting',
  `sales_status` varchar(255) DEFAULT 'New',
  `probability` double DEFAULT NULL,
  `best_case` decimal(26,6) DEFAULT NULL,
  `worst_case` decimal(26,6) DEFAULT NULL,
  `commit_stage` varchar(50) DEFAULT NULL,
  `total_revenue_line_items` int(11) DEFAULT NULL,
  `closed_revenue_line_items` int(11) DEFAULT NULL,
  `included_revenue_line_items` int(11) DEFAULT NULL,
  `mkto_sync` tinyint(1) DEFAULT '0',
  `mkto_id` int(11) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_opportunities_date_modfied` (`date_modified`),
  KEY `idx_opportunities_id_del` (`id`,`deleted`),
  KEY `idx_opportunities_date_entered` (`date_entered`),
  KEY `idx_opportunities_name_del` (`name`,`deleted`),
  KEY `idx_opp_name` (`name`),
  KEY `idx_opp_assigned_timestamp` (`assigned_user_id`,`date_closed_timestamp`,`deleted`),
  KEY `idx_opportunity_sales_status` (`sales_status`),
  KEY `idx_opportunity_opportunity_type` (`opportunity_type`),
  KEY `idx_opportunity_lead_source` (`lead_source`),
  KEY `idx_opportunity_next_step` (`next_step`),
  KEY `idx_opportunity_mkto_id` (`mkto_id`),
  KEY `idx_opportunities_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_opportunities_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `opportunities_audit`
--

DROP TABLE IF EXISTS `opportunities_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opportunities_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_opportunities_audit_parent_id` (`parent_id`),
  KEY `idx_opportunities_audit_event_id` (`event_id`),
  KEY `idx_opportunities_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_opportunities_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `opportunities_contacts`
--

DROP TABLE IF EXISTS `opportunities_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opportunities_contacts` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `contact_role` varchar(50) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_con_opp_con` (`contact_id`),
  KEY `idx_con_opp_opp` (`opportunity_id`),
  KEY `idx_opportunities_contacts` (`opportunity_id`,`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `outbound_email`
--

DROP TABLE IF EXISTS `outbound_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `outbound_email` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(15) DEFAULT 'user',
  `user_id` char(36) NOT NULL,
  `email_address_id` char(36) DEFAULT NULL,
  `mail_sendtype` varchar(8) DEFAULT 'SMTP',
  `mail_smtptype` varchar(20) DEFAULT 'other',
  `mail_smtpserver` varchar(100) DEFAULT NULL,
  `mail_smtpport` int(5) DEFAULT '465',
  `mail_smtpuser` varchar(100) DEFAULT NULL,
  `mail_smtppass` varchar(100) DEFAULT NULL,
  `mail_smtpauth_req` tinyint(1) DEFAULT '0',
  `mail_smtpssl` int(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `oe_user_id_idx` (`id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pdfmanager`
--

DROP TABLE IF EXISTS `pdfmanager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pdfmanager` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `base_module` varchar(100) DEFAULT '',
  `published` varchar(100) DEFAULT 'yes',
  `field` varchar(100) DEFAULT '0',
  `body_html` text,
  `template_name` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT 'SugarCRM',
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `header_title` varchar(255) DEFAULT NULL,
  `header_text` varchar(255) DEFAULT NULL,
  `header_logo` varchar(255) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pdfmanager_date_modfied` (`date_modified`),
  KEY `idx_pdfmanager_id_del` (`id`,`deleted`),
  KEY `idx_pdfmanager_date_entered` (`date_entered`),
  KEY `idx_pdfmanager_name_del` (`name`,`deleted`),
  KEY `idx_pdfmanager_name` (`name`),
  KEY `idx_pdfmanager_base_module` (`base_module`),
  KEY `idx_pdfmanager_published` (`published`),
  KEY `idx_pdfmanager_tmst_id` (`team_set_id`),
  KEY `idx_pdfmanager_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_activity_definition`
--

DROP TABLE IF EXISTS `pmse_bpm_activity_definition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_activity_definition` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `pro_id` varchar(36) DEFAULT '',
  `act_type` varchar(32) DEFAULT 'TASK',
  `act_duration` int(4) DEFAULT '0',
  `act_duration_unit` varchar(32) DEFAULT 'DAYS',
  `act_send_notification` int(4) DEFAULT '0',
  `act_assignment_method` varchar(32) DEFAULT 'balanced',
  `act_assign_team` varchar(40) DEFAULT '',
  `act_assign_user` varchar(40) DEFAULT '',
  `act_value_based_assignment` varchar(255) DEFAULT '',
  `act_reassign` int(4) DEFAULT '0',
  `act_reassign_team` varchar(40) DEFAULT '',
  `act_adhoc` int(4) DEFAULT '0',
  `act_adhoc_behavior` varchar(40) DEFAULT '',
  `act_adhoc_team` varchar(40) DEFAULT '',
  `act_response_buttons` varchar(40) DEFAULT '',
  `act_last_user_assigned` varchar(40) DEFAULT '',
  `act_field_module` varchar(100) DEFAULT '',
  `act_fields` text,
  `act_readonly_fields` text,
  `act_expected_time` text,
  `act_required_fields` text,
  `act_related_modules` text,
  `act_service_url` text,
  `act_service_params` text,
  `act_service_method` text,
  `act_update_record_owner` int(4) DEFAULT '0',
  `execution_mode` varchar(10) DEFAULT 'DEFAULT',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_activity_definition_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_activity_definition_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_activity_definition_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_activity_definition_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_activity_definition_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_activity_step`
--

DROP TABLE IF EXISTS `pmse_bpm_activity_step`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_activity_step` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `pro_id` varchar(36) DEFAULT '',
  `act_step_type` varchar(30) DEFAULT 'START',
  `act_criteria` text,
  `act_step_form` varchar(255) DEFAULT '',
  `act_step_script` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_activity_step_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_activity_step_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_activity_step_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_activity_step_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_activity_step_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_activity_user`
--

DROP TABLE IF EXISTS `pmse_bpm_activity_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_activity_user` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `pro_id` varchar(36) DEFAULT '',
  `act_user_type` varchar(32) DEFAULT '',
  `act_user_id` varchar(40) DEFAULT '',
  `act_group_id` varchar(40) DEFAULT '',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_activity_user_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_activity_user_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_activity_user_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_activity_user_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_activity_user_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_config`
--

DROP TABLE IF EXISTS `pmse_bpm_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_config` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `cfg_status` varchar(20) DEFAULT 'ACTIVE',
  `cfg_value` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_config_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_config_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_config_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_config_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_config_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_dynamic_forms`
--

DROP TABLE IF EXISTS `pmse_bpm_dynamic_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_dynamic_forms` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `dyn_uid` varchar(32) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `dyn_module` varchar(255) DEFAULT '',
  `dyn_view_defs` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_dynamic_forms_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_dynamic_forms_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_dynamic_forms_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_dynamic_forms_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_dynamic_forms_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_event_definition`
--

DROP TABLE IF EXISTS `pmse_bpm_event_definition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_event_definition` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `evn_status` varchar(32) DEFAULT 'ACTIVE',
  `evn_type` varchar(30) DEFAULT 'START',
  `evn_module` varchar(128) DEFAULT 'Leads',
  `evn_criteria` text,
  `evn_params` text,
  `evn_script` text,
  `execution_mode` varchar(10) DEFAULT 'DEFAULT',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_event_definition_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_event_definition_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_event_definition_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_event_definition_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_event_definition_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_flow`
--

DROP TABLE IF EXISTS `pmse_bpm_flow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_flow` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `cas_id` int(4) DEFAULT NULL,
  `cas_index` int(4) DEFAULT NULL,
  `pro_id` varchar(36) DEFAULT '',
  `cas_previous` int(4) DEFAULT '0',
  `cas_reassign_level` int(4) DEFAULT '0',
  `bpmn_id` varchar(36) DEFAULT '',
  `bpmn_type` varchar(32) DEFAULT '',
  `cas_assignment_method` varchar(32) DEFAULT '',
  `cas_user_id` varchar(40) DEFAULT '',
  `cas_thread` int(4) DEFAULT '0',
  `cas_flow_status` varchar(32) DEFAULT 'OPEN',
  `cas_sugar_module` varchar(128) DEFAULT 'ProcessMaker',
  `cas_sugar_object_id` varchar(40) DEFAULT '',
  `cas_sugar_action` varchar(40) DEFAULT 'DetailView',
  `cas_adhoc_type` varchar(40) DEFAULT '',
  `cas_adhoc_parent_id` varchar(40) DEFAULT '',
  `cas_adhoc_actions` varchar(255) DEFAULT '',
  `cas_task_start_date` datetime DEFAULT NULL,
  `cas_delegate_date` datetime DEFAULT NULL,
  `cas_start_date` datetime DEFAULT NULL,
  `cas_finish_date` datetime DEFAULT NULL,
  `cas_due_date` datetime DEFAULT NULL,
  `cas_queue_duration` int(4) DEFAULT '0',
  `cas_duration` int(4) DEFAULT '0',
  `cas_delay_duration` int(4) DEFAULT '0',
  `cas_started` int(4) DEFAULT '0',
  `cas_finished` int(4) DEFAULT '0',
  `cas_delayed` int(4) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_flow_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_flow_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_flow_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_flow_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_flow_cas_flow_status` (`bpmn_id`,`cas_flow_status`),
  KEY `idx_pmse_bpm_flow_status` (`cas_flow_status`),
  KEY `idx_pmse_bpm_flow_cas_sugar_object_id` (`cas_sugar_object_id`),
  KEY `idx_pmse_bpm_flow_parent` (`cas_sugar_object_id`,`cas_sugar_module`),
  KEY `idx_pmse_bpm_flow_cas_id` (`cas_id`),
  KEY `idx_pmse_bpm_flow_parent_and_cas_id` (`cas_sugar_object_id`,`cas_sugar_module`,`cas_index`),
  KEY `idx_pmse_bpm_flow_bpmn_type_flow_status_due_date_del` (`bpmn_type`,`cas_flow_status`,`cas_due_date`,`deleted`),
  KEY `idx_pmse_bpm_flow_del_cas_id` (`cas_id`,`deleted`),
  KEY `idx_pmse_bpm_flow_cas_id_flow_status` (`cas_id`,`cas_flow_status`),
  KEY `idx_pmse_bpm_flow_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_form_action`
--

DROP TABLE IF EXISTS `pmse_bpm_form_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_form_action` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `cas_id` int(4) DEFAULT NULL,
  `act_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `user_id` varchar(36) DEFAULT '',
  `frm_index` int(4) DEFAULT NULL,
  `frm_last` int(4) DEFAULT NULL,
  `frm_action` varchar(255) DEFAULT 'ROUTE',
  `frm_user_id` varchar(255) DEFAULT '',
  `frm_user_name` varchar(255) DEFAULT '',
  `frm_date` datetime DEFAULT NULL,
  `frm_comment` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_form_action_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_form_action_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_form_action_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_form_action_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_form_action_del_cas_id` (`cas_id`,`deleted`),
  KEY `idx_pmse_bpm_form_action_cas_id_frm_last` (`cas_id`,`frm_last`,`deleted`),
  KEY `idx_pmse_bpm_form_action_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_gateway_definition`
--

DROP TABLE IF EXISTS `pmse_bpm_gateway_definition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_gateway_definition` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `execution_mode` varchar(10) DEFAULT 'DEFAULT',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_gateway_definition_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_gateway_definition_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_gateway_definition_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_gateway_definition_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_gateway_definition_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_group`
--

DROP TABLE IF EXISTS `pmse_bpm_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_group` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `grp_uid` varchar(36) DEFAULT '',
  `grp_parent_group` int(4) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_group_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_group_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_group_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_group_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_group_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_group_user`
--

DROP TABLE IF EXISTS `pmse_bpm_group_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_group_user` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `user_id` varchar(36) DEFAULT '',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_group_user_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_group_user_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_group_user_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_group_user_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_group_user_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_notes`
--

DROP TABLE IF EXISTS `pmse_bpm_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_notes` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `cas_id` varchar(36) DEFAULT '',
  `cas_index` int(4) DEFAULT NULL,
  `not_user_id` varchar(40) DEFAULT '',
  `not_user_recipient_id` varchar(40) DEFAULT '',
  `not_type` varchar(32) DEFAULT 'GENERAL',
  `not_date` datetime DEFAULT NULL,
  `not_status` varchar(10) DEFAULT 'ACTIVE',
  `not_availability` varchar(32) DEFAULT '',
  `not_content` text,
  `not_recipients` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_notes_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_notes_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_notes_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_notes_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_notes_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_process_definition`
--

DROP TABLE IF EXISTS `pmse_bpm_process_definition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_process_definition` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `prj_id` varchar(36) DEFAULT '',
  `pro_module` varchar(255) DEFAULT '',
  `pro_status` varchar(255) DEFAULT '',
  `pro_locked_variables` text,
  `pro_terminate_variables` text,
  `execution_mode` varchar(10) DEFAULT 'SYNC',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_process_definition_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_process_definition_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_process_definition_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_process_definition_name_del` (`name`,`deleted`),
  KEY `idx_pd_prj_id` (`prj_id`),
  KEY `idx_pd_pro_status` (`pro_status`),
  KEY `idx_pmse_bpm_process_definition_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_related_dependency`
--

DROP TABLE IF EXISTS `pmse_bpm_related_dependency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_related_dependency` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `evn_id` varchar(36) DEFAULT '',
  `evn_uid` varchar(36) DEFAULT '',
  `evn_marker` varchar(36) DEFAULT '',
  `evn_is_interrupting` varchar(36) DEFAULT '',
  `evn_attached_to` varchar(36) DEFAULT '',
  `evn_cancel_activity` varchar(36) DEFAULT '',
  `evn_activity_ref` varchar(36) DEFAULT '',
  `evn_wait_for_completion` varchar(36) DEFAULT '',
  `evn_error_name` varchar(36) DEFAULT '',
  `evn_error_code` varchar(36) DEFAULT '',
  `evn_escalation_name` varchar(36) DEFAULT '',
  `evn_escalation_code` varchar(36) DEFAULT '',
  `evn_condition` varchar(36) DEFAULT '',
  `evn_message` varchar(36) DEFAULT '',
  `evn_operation_name` varchar(36) DEFAULT '',
  `evn_operation_implementation` varchar(36) DEFAULT '',
  `evn_time_date` varchar(36) DEFAULT '',
  `evn_time_cycle` varchar(36) DEFAULT '',
  `evn_time_duration` varchar(36) DEFAULT '',
  `evn_behavior` varchar(36) DEFAULT '',
  `evn_status` varchar(36) DEFAULT '',
  `evn_type` varchar(36) DEFAULT '',
  `evn_module` varchar(36) DEFAULT '',
  `evn_criteria` text,
  `evn_params` text,
  `evn_script` text,
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `pro_module` varchar(36) DEFAULT '',
  `pro_status` varchar(36) DEFAULT '',
  `pro_locked_variables` text,
  `pro_terminate_variables` text,
  `rel_element_id` varchar(40) DEFAULT '',
  `rel_element_type` varchar(32) DEFAULT '',
  `rel_process_module` varchar(32) DEFAULT '',
  `rel_element_module` varchar(32) DEFAULT '',
  `rel_element_relationship` varchar(255) DEFAULT '',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_related_dependency_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_related_dependency_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_related_dependency_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_related_dependency_name_del` (`name`,`deleted`),
  KEY `idx_prostatus_evntype_evnmodule_evn_behavior` (`pro_status`,`evn_type`,`evn_module`,`evn_behavior`),
  KEY `idx_pmse_bpm_related_dependency_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpm_thread`
--

DROP TABLE IF EXISTS `pmse_bpm_thread`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpm_thread` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `cas_id` int(4) DEFAULT '0',
  `cas_thread_index` int(4) DEFAULT '0',
  `cas_thread_parent` int(4) DEFAULT '0',
  `cas_thread_status` varchar(32) DEFAULT 'OPEN',
  `cas_flow_index` int(4) DEFAULT '0',
  `cas_thread_tokens` int(4) DEFAULT '0',
  `cas_thread_passes` int(4) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpm_thread_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpm_thread_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpm_thread_date_entered` (`date_entered`),
  KEY `idx_pmse_bpm_thread_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpm_thread_del_cas_id` (`cas_id`,`deleted`),
  KEY `idx_pmse_bpm_thread_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_activity`
--

DROP TABLE IF EXISTS `pmse_bpmn_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_activity` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `act_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `act_type` varchar(30) DEFAULT 'TASK',
  `act_is_for_compensation` int(4) DEFAULT '0',
  `act_start_quantity` int(4) DEFAULT '1',
  `act_completion_quantity` int(4) DEFAULT '1',
  `act_task_type` varchar(20) DEFAULT 'EMPTY',
  `act_implementation` text,
  `act_instantiate` int(4) DEFAULT '0',
  `act_script_type` varchar(255) DEFAULT '',
  `act_script` text,
  `act_loop_type` varchar(20) DEFAULT 'NONE',
  `act_test_before` int(4) DEFAULT '0',
  `act_loop_maximum` int(4) DEFAULT '0',
  `act_loop_condition` varchar(100) DEFAULT '',
  `act_loop_cardinality` int(4) DEFAULT '0',
  `act_loop_behavior` varchar(20) DEFAULT 'NONE',
  `act_is_adhoc` int(4) DEFAULT '0',
  `act_is_collapsed` int(4) DEFAULT '1',
  `act_completion_condition` varchar(255) DEFAULT '',
  `act_ordering` varchar(20) DEFAULT 'PARALLEL',
  `act_cancel_remaining_instances` int(4) DEFAULT '1',
  `act_protocol` varchar(255) DEFAULT '',
  `act_method` varchar(255) DEFAULT '',
  `act_is_global` int(4) DEFAULT '0',
  `act_referer` int(4) DEFAULT NULL,
  `act_default_flow` int(4) DEFAULT NULL,
  `act_master_diagram` int(4) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_activity_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_activity_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_activity_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_activity_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_activity_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_artifact`
--

DROP TABLE IF EXISTS `pmse_bpmn_artifact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_artifact` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `art_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `art_type` varchar(15) DEFAULT '',
  `art_category_ref` varchar(32) DEFAULT '',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_artifact_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_artifact_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_artifact_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_artifact_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_artifact_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_bound`
--

DROP TABLE IF EXISTS `pmse_bpmn_bound`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_bound` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `bou_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `dia_id` varchar(36) DEFAULT '',
  `element_id` varchar(36) DEFAULT '',
  `bou_element` varchar(36) DEFAULT '',
  `bou_element_type` varchar(32) DEFAULT '',
  `bou_x` int(4) DEFAULT '0',
  `bou_y` int(4) DEFAULT '0',
  `bou_width` int(4) DEFAULT '0',
  `bou_height` int(4) DEFAULT '0',
  `bou_rel_position` int(4) DEFAULT '0',
  `bou_size_identical` int(4) DEFAULT '0',
  `bou_container` varchar(30) DEFAULT '',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_bound_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_bound_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_bound_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_bound_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_bound_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_data`
--

DROP TABLE IF EXISTS `pmse_bpmn_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_data` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `dat_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `dat_type` varchar(20) DEFAULT '',
  `dat_is_collection` int(4) DEFAULT '0',
  `dat_item_kind` varchar(20) DEFAULT 'INFORMATION',
  `dat_capacity` int(4) DEFAULT '0',
  `dat_is_unlimited` int(4) DEFAULT '0',
  `dat_state` varchar(255) DEFAULT '',
  `dat_is_global` int(4) DEFAULT '0',
  `dat_object_ref` int(4) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_data_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_data_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_data_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_data_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_data_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_diagram`
--

DROP TABLE IF EXISTS `pmse_bpmn_diagram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_diagram` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `dia_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `dia_is_closable` int(4) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_diagram_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_diagram_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_diagram_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_diagram_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_diagram_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_documentation`
--

DROP TABLE IF EXISTS `pmse_bpmn_documentation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_documentation` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `doc_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `doc_element` varchar(36) DEFAULT '',
  `doc_element_type` varchar(45) DEFAULT '',
  `doc_documentation` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_documentation_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_documentation_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_documentation_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_documentation_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_documentation_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_event`
--

DROP TABLE IF EXISTS `pmse_bpmn_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_event` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `evn_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `evn_type` varchar(30) DEFAULT '',
  `evn_marker` varchar(30) DEFAULT 'EMPTY',
  `evn_is_interrupting` int(4) DEFAULT '1',
  `evn_attached_to` int(4) DEFAULT NULL,
  `evn_cancel_activity` int(4) DEFAULT '0',
  `evn_activity_ref` int(4) DEFAULT NULL,
  `evn_wait_for_completion` int(4) DEFAULT '1',
  `evn_error_name` varchar(255) DEFAULT '',
  `evn_error_code` varchar(255) DEFAULT '',
  `evn_escalation_name` varchar(255) DEFAULT '',
  `evn_escalation_code` varchar(255) DEFAULT '',
  `evn_condition` varchar(255) DEFAULT '',
  `evn_message` text,
  `evn_operation_name` varchar(255) DEFAULT '',
  `evn_operation_implementation` varchar(255) DEFAULT '',
  `evn_time_date` varchar(255) DEFAULT '',
  `evn_time_cycle` varchar(255) DEFAULT '',
  `evn_time_duration` varchar(255) DEFAULT '',
  `evn_behavior` varchar(20) DEFAULT 'CATCH',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_event_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_event_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_event_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_event_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_event_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_extension`
--

DROP TABLE IF EXISTS `pmse_bpmn_extension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_extension` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `ext_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `ext_element` varchar(36) DEFAULT '',
  `ext_element_type` varchar(45) DEFAULT '',
  `ext_extension` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_extension_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_extension_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_extension_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_extension_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_extension_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_flow`
--

DROP TABLE IF EXISTS `pmse_bpmn_flow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_flow` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `flo_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `dia_id` varchar(36) DEFAULT '',
  `flo_type` varchar(20) DEFAULT '',
  `flo_element_origin` varchar(36) DEFAULT '',
  `flo_element_origin_type` varchar(32) DEFAULT '',
  `flo_element_origin_port` int(4) DEFAULT '0',
  `flo_element_dest` varchar(36) DEFAULT '',
  `flo_element_dest_type` varchar(32) DEFAULT '',
  `flo_element_dest_port` int(4) DEFAULT '0',
  `flo_is_inmediate` int(4) DEFAULT NULL,
  `flo_condition` text,
  `flo_eval_priority` int(4) DEFAULT '0',
  `flo_x1` int(4) DEFAULT '0',
  `flo_y1` int(4) DEFAULT '0',
  `flo_x2` int(4) DEFAULT '0',
  `flo_y2` int(4) DEFAULT '0',
  `flo_state` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_flow_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_flow_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_flow_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_flow_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_flow_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_gateway`
--

DROP TABLE IF EXISTS `pmse_bpmn_gateway`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_gateway` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `gat_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `gat_type` varchar(30) DEFAULT '',
  `gat_direction` varchar(30) DEFAULT 'UNSPECIFIED',
  `gat_instantiate` int(4) DEFAULT '0',
  `gat_event_gateway_type` varchar(20) DEFAULT 'NONE',
  `gat_activation_count` int(4) DEFAULT '0',
  `gat_waiting_for_start` int(4) DEFAULT '1',
  `gat_default_flow` varchar(36) DEFAULT '',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_gateway_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_gateway_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_gateway_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_gateway_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_gateway_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_lane`
--

DROP TABLE IF EXISTS `pmse_bpmn_lane`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_lane` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `lan_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `lns_id` varchar(36) DEFAULT '',
  `lan_child_laneset` varchar(36) DEFAULT '',
  `lan_is_horizontal` int(4) DEFAULT '1',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_lane_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_lane_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_lane_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_lane_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_lane_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_laneset`
--

DROP TABLE IF EXISTS `pmse_bpmn_laneset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_laneset` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `lns_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `lns_parent_lane` varchar(36) DEFAULT '',
  `lns_is_horizontal` int(4) DEFAULT '1',
  `lns_state` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_laneset_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_laneset_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_laneset_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_laneset_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_laneset_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_participant`
--

DROP TABLE IF EXISTS `pmse_bpmn_participant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_participant` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `par_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `pro_id` varchar(36) DEFAULT '',
  `lns_id` varchar(36) DEFAULT '',
  `par_minimum` int(4) DEFAULT '0',
  `par_maximum` int(4) DEFAULT '1',
  `par_num_participants` int(4) DEFAULT '1',
  `par_is_horizontal` int(4) DEFAULT '1',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_participant_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_participant_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_participant_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_participant_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_participant_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_bpmn_process`
--

DROP TABLE IF EXISTS `pmse_bpmn_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_bpmn_process` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `pro_uid` varchar(36) DEFAULT '',
  `prj_id` varchar(36) DEFAULT '',
  `dia_id` varchar(36) DEFAULT '',
  `pro_type` varchar(10) DEFAULT 'NONE',
  `pro_is_executable` int(4) DEFAULT '0',
  `pro_is_closed` int(4) DEFAULT '0',
  `pro_is_subprocess` int(4) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_bpmn_process_date_modfied` (`date_modified`),
  KEY `idx_pmse_bpmn_process_id_del` (`id`,`deleted`),
  KEY `idx_pmse_bpmn_process_date_entered` (`date_entered`),
  KEY `idx_pmse_bpmn_process_name_del` (`name`,`deleted`),
  KEY `idx_pmse_bpmn_process_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_business_rules`
--

DROP TABLE IF EXISTS `pmse_business_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_business_rules` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `rst_uid` varchar(36) DEFAULT NULL,
  `rst_type` varchar(100) DEFAULT 'single',
  `rst_definition` text,
  `rst_editable` int(4) DEFAULT '0',
  `rst_source` varchar(255) DEFAULT NULL,
  `rst_source_definition` text,
  `rst_module` varchar(100) DEFAULT NULL,
  `rst_filename` varchar(255) DEFAULT NULL,
  `rst_create_date` datetime DEFAULT NULL,
  `rst_update_date` datetime DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_business_rules_date_modfied` (`date_modified`),
  KEY `idx_pmse_business_rules_id_del` (`id`,`deleted`),
  KEY `idx_pmse_business_rules_date_entered` (`date_entered`),
  KEY `idx_pmse_business_rules_name_del` (`name`,`deleted`),
  KEY `idx_pmse_business_rules_tmst_id` (`team_set_id`),
  KEY `idx_pmse_business_rules_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_emails_templates`
--

DROP TABLE IF EXISTS `pmse_emails_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_emails_templates` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `from_name` varchar(255) DEFAULT NULL,
  `from_address` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  `body_html` text,
  `type` varchar(255) DEFAULT NULL,
  `base_module` varchar(100) DEFAULT NULL,
  `text_only` tinyint(4) DEFAULT NULL,
  `published` varchar(3) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_emails_templates_date_modfied` (`date_modified`),
  KEY `idx_pmse_emails_templates_id_del` (`id`,`deleted`),
  KEY `idx_pmse_emails_templates_date_entered` (`date_entered`),
  KEY `idx_pmse_emails_templates_name_del` (`name`,`deleted`),
  KEY `idx_pmse_emails_templates_tmst_id` (`team_set_id`),
  KEY `idx_pmse_emails_templates_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_inbox`
--

DROP TABLE IF EXISTS `pmse_inbox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_inbox` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `cas_id` int(11) NOT NULL AUTO_INCREMENT,
  `cas_parent` int(11) DEFAULT NULL,
  `cas_status` varchar(32) DEFAULT 'IN PROGRESS',
  `pro_id` varchar(36) DEFAULT NULL,
  `cas_title` varchar(255) DEFAULT NULL,
  `pro_title` varchar(255) DEFAULT NULL,
  `cas_custom_status` varchar(32) DEFAULT NULL,
  `cas_init_user` varchar(36) DEFAULT NULL,
  `cas_create_date` datetime DEFAULT NULL,
  `cas_update_date` datetime DEFAULT NULL,
  `cas_finish_date` datetime DEFAULT NULL,
  `cas_pin` varchar(10) DEFAULT '0000',
  `cas_assigned_status` varchar(12) DEFAULT 'UNASSIGNED',
  `cas_module` varchar(100) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_inbox_date_modfied` (`date_modified`),
  KEY `idx_pmse_inbox_id_del` (`id`,`deleted`),
  KEY `idx_pmse_inbox_date_entered` (`date_entered`),
  KEY `idx_pmse_inbox_name_del` (`name`,`deleted`),
  KEY `idx_pmse_inbox_case_id` (`cas_id`),
  KEY `idx_pmse_inbox_tmst_id` (`team_set_id`),
  KEY `idx_pmse_inbox_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pmse_project`
--

DROP TABLE IF EXISTS `pmse_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pmse_project` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `prj_uid` varchar(36) DEFAULT NULL,
  `prj_target_namespace` varchar(255) DEFAULT NULL,
  `prj_expression_language` varchar(255) DEFAULT NULL,
  `prj_type_language` varchar(255) DEFAULT NULL,
  `prj_exporter` varchar(255) DEFAULT NULL,
  `prj_exporter_version` varchar(255) DEFAULT NULL,
  `prj_author` varchar(255) DEFAULT NULL,
  `prj_author_version` varchar(255) DEFAULT NULL,
  `prj_original_source` varchar(255) DEFAULT NULL,
  `prj_status` varchar(10) DEFAULT 'INACTIVE',
  `prj_module` varchar(100) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pmse_project_date_modfied` (`date_modified`),
  KEY `idx_pmse_project_id_del` (`id`,`deleted`),
  KEY `idx_pmse_project_date_entered` (`date_entered`),
  KEY `idx_pmse_project_name_del` (`name`,`deleted`),
  KEY `idx_pmse_project_tmst_id` (`team_set_id`),
  KEY `idx_pmse_project_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_bundle_note`
--

DROP TABLE IF EXISTS `product_bundle_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_bundle_note` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `bundle_id` char(36) DEFAULT NULL,
  `note_id` char(36) DEFAULT NULL,
  `note_index` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pbn_bundle` (`bundle_id`),
  KEY `idx_pbn_note` (`note_id`),
  KEY `idx_pbn_pb_nb` (`note_id`,`bundle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_bundle_notes`
--

DROP TABLE IF EXISTS `product_bundle_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_bundle_notes` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_bundle_product`
--

DROP TABLE IF EXISTS `product_bundle_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_bundle_product` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `bundle_id` char(36) DEFAULT NULL,
  `product_id` char(36) DEFAULT NULL,
  `product_index` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pbp_bundle` (`bundle_id`),
  KEY `idx_pbp_quote` (`product_id`),
  KEY `idx_pbp_bq` (`product_id`,`bundle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_bundle_quote`
--

DROP TABLE IF EXISTS `product_bundle_quote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_bundle_quote` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `bundle_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `bundle_index` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pbq_bundle` (`bundle_id`),
  KEY `idx_pbq_quote` (`quote_id`),
  KEY `idx_pbq_bq` (`quote_id`,`bundle_id`),
  KEY `bundle_index_idx` (`bundle_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_bundles`
--

DROP TABLE IF EXISTS `product_bundles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_bundles` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bundle_stage` varchar(255) DEFAULT NULL,
  `description` text,
  `taxrate_id` char(36) DEFAULT NULL,
  `tax` decimal(26,6) DEFAULT NULL,
  `tax_usdollar` decimal(26,6) DEFAULT NULL,
  `total` decimal(26,6) DEFAULT NULL,
  `total_usdollar` decimal(26,6) DEFAULT NULL,
  `subtotal_usdollar` decimal(26,6) DEFAULT NULL,
  `shipping_usdollar` decimal(26,6) DEFAULT NULL,
  `deal_tot` decimal(26,6) DEFAULT NULL,
  `deal_tot_usdollar` decimal(26,6) DEFAULT NULL,
  `new_sub` decimal(26,6) DEFAULT NULL,
  `new_sub_usdollar` decimal(26,6) DEFAULT NULL,
  `subtotal` decimal(26,6) DEFAULT NULL,
  `taxable_subtotal` decimal(26,6) DEFAULT NULL,
  `shipping` decimal(26,6) DEFAULT NULL,
  `default_group` tinyint(1) DEFAULT '0',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_products_bundles` (`name`,`deleted`),
  KEY `idx_product_bundles_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_categories` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `list_order` int(4) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_categories_date_modfied` (`date_modified`),
  KEY `idx_product_categories_id_del` (`id`,`deleted`),
  KEY `idx_product_categories_date_entered` (`date_entered`),
  KEY `idx_product_categories_name_del` (`name`,`deleted`),
  KEY `idx_producttemplate_id_parent_name` (`id`,`parent_id`,`name`,`deleted`),
  KEY `idx_product_categories_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_product`
--

DROP TABLE IF EXISTS `product_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_product` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `child_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pp_parent` (`parent_id`),
  KEY `idx_pp_child` (`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_templates`
--

DROP TABLE IF EXISTS `product_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_templates` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `type_id` char(36) DEFAULT NULL,
  `manufacturer_id` char(36) DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `mft_part_num` varchar(50) DEFAULT NULL,
  `vendor_part_num` varchar(50) DEFAULT NULL,
  `date_cost_price` date DEFAULT NULL,
  `cost_price` decimal(26,6) DEFAULT NULL,
  `discount_price` decimal(26,6) DEFAULT NULL,
  `list_price` decimal(26,6) DEFAULT NULL,
  `cost_usdollar` decimal(26,6) DEFAULT NULL,
  `discount_usdollar` decimal(26,6) DEFAULT NULL,
  `list_usdollar` decimal(26,6) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `tax_class` varchar(100) DEFAULT NULL,
  `date_available` date DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `weight` decimal(12,2) DEFAULT NULL,
  `qty_in_stock` int(5) DEFAULT NULL,
  `support_name` varchar(50) DEFAULT NULL,
  `support_description` varchar(255) DEFAULT NULL,
  `support_contact` varchar(50) DEFAULT NULL,
  `support_term` varchar(100) DEFAULT NULL,
  `pricing_formula` varchar(100) DEFAULT NULL,
  `pricing_factor` decimal(8,2) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_templates_date_modfied` (`date_modified`),
  KEY `idx_product_templates_id_del` (`id`,`deleted`),
  KEY `idx_product_templates_date_entered` (`date_entered`),
  KEY `idx_product_templates_name_del` (`name`,`deleted`),
  KEY `idx_producttemplate_status` (`status`),
  KEY `idx_producttemplate_qty_in_stock` (`qty_in_stock`),
  KEY `idx_producttemplate_category` (`category_id`),
  KEY `idx_product_templates_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_templates_audit`
--

DROP TABLE IF EXISTS `product_templates_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_templates_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_product_templates_audit_parent_id` (`parent_id`),
  KEY `idx_product_templates_audit_event_id` (`event_id`),
  KEY `idx_product_templates_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_product_templates_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_types`
--

DROP TABLE IF EXISTS `product_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_types` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `list_order` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_product_types_date_modfied` (`date_modified`),
  KEY `idx_product_types_id_del` (`id`,`deleted`),
  KEY `idx_product_types_date_entered` (`date_entered`),
  KEY `idx_product_types_name_del` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `revenuelineitem_id` char(36) DEFAULT NULL,
  `product_template_id` char(36) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `subtotal` decimal(26,6) DEFAULT '0.000000',
  `total_amount` decimal(26,6) DEFAULT '0.000000',
  `type_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `manufacturer_id` char(36) DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `mft_part_num` varchar(50) DEFAULT NULL,
  `vendor_part_num` varchar(50) DEFAULT NULL,
  `date_purchased` date DEFAULT NULL,
  `cost_price` decimal(26,6) DEFAULT NULL,
  `discount_price` decimal(26,6) DEFAULT '0.000000',
  `discount_amount` decimal(26,6) DEFAULT '0.000000',
  `discount_rate_percent` decimal(26,2) DEFAULT NULL,
  `discount_amount_usdollar` decimal(26,6) DEFAULT NULL,
  `discount_select` tinyint(1) DEFAULT '1',
  `deal_calc` decimal(26,6) DEFAULT NULL,
  `deal_calc_usdollar` decimal(26,6) DEFAULT NULL,
  `list_price` decimal(26,6) DEFAULT NULL,
  `cost_usdollar` decimal(26,6) DEFAULT NULL,
  `discount_usdollar` decimal(26,6) DEFAULT NULL,
  `list_usdollar` decimal(26,6) DEFAULT NULL,
  `status` varchar(100) DEFAULT '',
  `tax_class` varchar(100) DEFAULT 'Taxable',
  `website` varchar(255) DEFAULT NULL,
  `weight` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT '1.00',
  `support_name` varchar(50) DEFAULT NULL,
  `support_description` varchar(255) DEFAULT NULL,
  `support_contact` varchar(50) DEFAULT NULL,
  `support_term` varchar(100) DEFAULT NULL,
  `date_support_expires` date DEFAULT NULL,
  `date_support_starts` date DEFAULT NULL,
  `pricing_formula` varchar(100) DEFAULT NULL,
  `pricing_factor` int(4) DEFAULT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `asset_number` varchar(50) DEFAULT NULL,
  `book_value` decimal(26,6) DEFAULT NULL,
  `book_value_usdollar` decimal(26,6) DEFAULT NULL,
  `book_value_date` date DEFAULT NULL,
  `date_closed` date DEFAULT NULL,
  `date_closed_timestamp` bigint(20) unsigned DEFAULT NULL,
  `next_step` varchar(100) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_products_date_modfied` (`date_modified`),
  KEY `idx_products_id_del` (`id`,`deleted`),
  KEY `idx_products_date_entered` (`date_entered`),
  KEY `idx_products_name_del` (`name`,`deleted`),
  KEY `idx_prod_user_dc_timestamp` (`id`,`assigned_user_id`,`date_closed_timestamp`),
  KEY `idx_product_quantity` (`quantity`),
  KEY `idx_product_contact` (`contact_id`),
  KEY `idx_product_account` (`account_id`),
  KEY `idx_product_opp` (`opportunity_id`),
  KEY `idx_product_quote` (`quote_id`),
  KEY `idx_product_rli` (`revenuelineitem_id`),
  KEY `idx_products_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_products_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `products_audit`
--

DROP TABLE IF EXISTS `products_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_products_audit_parent_id` (`parent_id`),
  KEY `idx_products_audit_event_id` (`event_id`),
  KEY `idx_products_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_products_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `estimated_start_date` date DEFAULT NULL,
  `estimated_end_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `is_template` tinyint(1) DEFAULT '0',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_project_name` (`name`),
  KEY `idx_project_estimated_start_date` (`estimated_start_date`),
  KEY `idx_project_estimated_end_date` (`estimated_end_date`),
  KEY `idx_project_status` (`status`),
  KEY `idx_project_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `project_resources`
--

DROP TABLE IF EXISTS `project_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_resources` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `resource_id` char(36) DEFAULT NULL,
  `resource_type` varchar(20) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `project_task`
--

DROP TABLE IF EXISTS `project_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `project_id` char(36) NOT NULL,
  `project_task_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `description` text,
  `resource_id` text,
  `predecessors` text,
  `date_start` date DEFAULT NULL,
  `time_start` int(11) DEFAULT NULL,
  `time_finish` int(11) DEFAULT NULL,
  `date_finish` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `duration_unit` text,
  `actual_duration` int(11) DEFAULT NULL,
  `percent_complete` int(11) DEFAULT NULL,
  `date_due` date DEFAULT NULL,
  `time_due` time DEFAULT NULL,
  `parent_task_id` int(11) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `milestone_flag` tinyint(1) DEFAULT '0',
  `order_number` int(11) DEFAULT '1',
  `task_number` int(11) DEFAULT NULL,
  `estimated_effort` int(11) DEFAULT NULL,
  `actual_effort` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `utilization` int(11) DEFAULT '100',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_project_task_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `project_task_audit`
--

DROP TABLE IF EXISTS `project_task_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_project_task_audit_parent_id` (`parent_id`),
  KEY `idx_project_task_audit_event_id` (`event_id`),
  KEY `idx_project_task_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_project_task_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_accounts`
--

DROP TABLE IF EXISTS `projects_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_accounts` (
  `id` char(36) NOT NULL,
  `account_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_acct_proj` (`project_id`),
  KEY `idx_proj_acct_acct` (`account_id`),
  KEY `projects_accounts_alt` (`project_id`,`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_bugs`
--

DROP TABLE IF EXISTS `projects_bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_bugs` (
  `id` char(36) NOT NULL,
  `bug_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_bug_proj` (`project_id`),
  KEY `idx_proj_bug_bug` (`bug_id`),
  KEY `projects_bugs_alt` (`project_id`,`bug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_cases`
--

DROP TABLE IF EXISTS `projects_cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_cases` (
  `id` char(36) NOT NULL,
  `case_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_case_proj` (`project_id`),
  KEY `idx_proj_case_case` (`case_id`),
  KEY `projects_cases_alt` (`project_id`,`case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_contacts`
--

DROP TABLE IF EXISTS `projects_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_contacts` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_con_proj` (`project_id`),
  KEY `idx_proj_con_con` (`contact_id`),
  KEY `projects_contacts_alt` (`project_id`,`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_ht_products`
--

DROP TABLE IF EXISTS `projects_ht_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_ht_products` (
  `id` char(36) NOT NULL,
  `product_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_prod_project` (`project_id`),
  KEY `idx_proj_prod_product` (`product_id`),
  KEY `projects_products_alt` (`project_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_ht_quotes`
--

DROP TABLE IF EXISTS `projects_ht_quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_ht_quotes` (
  `id` char(36) NOT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_quote_proj` (`project_id`),
  KEY `idx_proj_quote_quote` (`quote_id`),
  KEY `projects_ht_quotes_alt` (`project_id`,`quote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_opportunities`
--

DROP TABLE IF EXISTS `projects_opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_opportunities` (
  `id` char(36) NOT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_opp_proj` (`project_id`),
  KEY `idx_proj_opp_opp` (`opportunity_id`),
  KEY `projects_opportunities_alt` (`project_id`,`opportunity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_products`
--

DROP TABLE IF EXISTS `projects_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_products` (
  `id` char(36) NOT NULL,
  `product_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_prod_project` (`project_id`),
  KEY `idx_proj_prod_product` (`product_id`),
  KEY `projects_products_alt` (`project_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_quotes`
--

DROP TABLE IF EXISTS `projects_quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_quotes` (
  `id` char(36) NOT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_quote_proj` (`project_id`),
  KEY `idx_proj_quote_quote` (`quote_id`),
  KEY `projects_quotes_alt` (`project_id`,`quote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `projects_revenue_line_items`
--

DROP TABLE IF EXISTS `projects_revenue_line_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects_revenue_line_items` (
  `id` char(36) NOT NULL,
  `rli_id` char(36) DEFAULT NULL,
  `project_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_proj_rli_project` (`project_id`),
  KEY `idx_proj_rli_product` (`rli_id`),
  KEY `projects_rli_alt` (`project_id`,`rli_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prospect_list_campaigns`
--

DROP TABLE IF EXISTS `prospect_list_campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prospect_list_campaigns` (
  `id` char(36) NOT NULL,
  `prospect_list_id` char(36) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pro_id` (`prospect_list_id`),
  KEY `idx_cam_id` (`campaign_id`),
  KEY `idx_prospect_list_campaigns` (`prospect_list_id`,`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prospect_lists`
--

DROP TABLE IF EXISTS `prospect_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prospect_lists` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `list_type` varchar(100) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `description` text,
  `domain_name` varchar(255) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_prospect_list_name` (`name`),
  KEY `idx_prospect_list_list_type` (`list_type`),
  KEY `idx_prospect_list_date_entered` (`date_entered`),
  KEY `idx_prospect_lists_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_prospect_lists_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prospect_lists_prospects`
--

DROP TABLE IF EXISTS `prospect_lists_prospects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prospect_lists_prospects` (
  `id` char(36) NOT NULL,
  `prospect_list_id` char(36) DEFAULT NULL,
  `related_id` char(36) DEFAULT NULL,
  `related_type` varchar(25) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_plp_pro_id` (`prospect_list_id`),
  KEY `idx_plp_rel_id` (`related_id`,`related_type`,`prospect_list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prospects`
--

DROP TABLE IF EXISTS `prospects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prospects` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `salutation` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `googleplus` varchar(100) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `do_not_call` tinyint(1) DEFAULT '0',
  `phone_home` varchar(100) DEFAULT NULL,
  `phone_mobile` varchar(100) DEFAULT NULL,
  `phone_work` varchar(100) DEFAULT NULL,
  `phone_other` varchar(100) DEFAULT NULL,
  `phone_fax` varchar(100) DEFAULT NULL,
  `primary_address_street` varchar(150) DEFAULT NULL,
  `primary_address_city` varchar(100) DEFAULT NULL,
  `primary_address_state` varchar(100) DEFAULT NULL,
  `primary_address_postalcode` varchar(20) DEFAULT NULL,
  `primary_address_country` varchar(255) DEFAULT NULL,
  `alt_address_street` varchar(150) DEFAULT NULL,
  `alt_address_city` varchar(100) DEFAULT NULL,
  `alt_address_state` varchar(100) DEFAULT NULL,
  `alt_address_postalcode` varchar(20) DEFAULT NULL,
  `alt_address_country` varchar(255) DEFAULT NULL,
  `assistant` varchar(75) DEFAULT NULL,
  `assistant_phone` varchar(100) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `tracker_key` int(11) NOT NULL AUTO_INCREMENT,
  `birthdate` date DEFAULT NULL,
  `lead_id` char(36) DEFAULT NULL,
  `account_name` varchar(150) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `dp_business_purpose` text,
  `dp_consent_last_updated` date DEFAULT NULL,
  `dnb_principal_id` varchar(30) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_prospects_date_modfied` (`date_modified`),
  KEY `idx_prospects_id_del` (`id`,`deleted`),
  KEY `idx_prospects_date_entered` (`date_entered`),
  KEY `idx_prospects_last_first` (`last_name`,`first_name`,`deleted`),
  KEY `idx_prospects_first_last` (`first_name`,`last_name`,`deleted`),
  KEY `prospect_auto_tracker_key` (`tracker_key`),
  KEY `idx_prospecs_del_last` (`last_name`,`deleted`),
  KEY `idx_prospects_assigned` (`assigned_user_id`),
  KEY `idx_prospect_title` (`title`),
  KEY `idx_prospects_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_prospects_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prospects_audit`
--

DROP TABLE IF EXISTS `prospects_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prospects_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_prospects_audit_parent_id` (`parent_id`),
  KEY `idx_prospects_audit_event_id` (`event_id`),
  KEY `idx_prospects_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_prospects_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prospects_dataprivacy`
--

DROP TABLE IF EXISTS `prospects_dataprivacy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prospects_dataprivacy` (
  `id` char(36) NOT NULL,
  `prospect_id` char(36) DEFAULT NULL,
  `dataprivacy_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_prospect_dataprivacy_prospect` (`prospect_id`),
  KEY `idx_prospect_dataprivacy_dataprivacy` (`dataprivacy_id`),
  KEY `idx_prospects_dataprivacy` (`prospect_id`,`dataprivacy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotas`
--

DROP TABLE IF EXISTS `quotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotas` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `user_id` char(36) DEFAULT NULL,
  `timeperiod_id` char(36) DEFAULT NULL,
  `quota_type` varchar(100) DEFAULT NULL,
  `amount` decimal(26,6) DEFAULT NULL,
  `amount_base_currency` decimal(26,6) DEFAULT NULL,
  `committed` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_quotas_date_modfied` (`date_modified`),
  KEY `idx_quotas_id_del` (`id`,`deleted`),
  KEY `idx_quotas_date_entered` (`date_entered`),
  KEY `idx_quotas_name_del` (`name`,`deleted`),
  KEY `idx_quota_user_tp` (`user_id`,`timeperiod_id`),
  KEY `idx_quotas_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotas_audit`
--

DROP TABLE IF EXISTS `quotas_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotas_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_quotas_audit_parent_id` (`parent_id`),
  KEY `idx_quotas_audit_event_id` (`event_id`),
  KEY `idx_quotas_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_quotas_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotes`
--

DROP TABLE IF EXISTS `quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotes` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `shipper_id` char(36) DEFAULT NULL,
  `taxrate_id` char(36) DEFAULT NULL,
  `taxrate_value` decimal(26,6) DEFAULT '0.000000',
  `show_line_nums` tinyint(1) DEFAULT '1',
  `quote_type` varchar(255) DEFAULT NULL,
  `date_quote_expected_closed` date DEFAULT NULL,
  `original_po_date` date DEFAULT NULL,
  `payment_terms` varchar(128) DEFAULT NULL,
  `date_quote_closed` date DEFAULT NULL,
  `date_order_shipped` date DEFAULT NULL,
  `order_stage` varchar(100) DEFAULT NULL,
  `quote_stage` varchar(100) DEFAULT NULL,
  `purchase_order_num` varchar(50) DEFAULT NULL,
  `quote_num` int(11) NOT NULL AUTO_INCREMENT,
  `subtotal` decimal(26,6) DEFAULT NULL,
  `subtotal_usdollar` decimal(26,6) DEFAULT NULL,
  `shipping` decimal(26,6) DEFAULT '0.000000',
  `shipping_usdollar` decimal(26,6) DEFAULT NULL,
  `discount` decimal(26,6) DEFAULT NULL,
  `deal_tot` decimal(26,2) DEFAULT NULL,
  `deal_tot_discount_percentage` decimal(26,2) DEFAULT '0.00',
  `deal_tot_usdollar` decimal(26,2) DEFAULT NULL,
  `new_sub` decimal(26,6) DEFAULT NULL,
  `new_sub_usdollar` decimal(26,6) DEFAULT NULL,
  `taxable_subtotal` decimal(26,6) DEFAULT NULL,
  `tax` decimal(26,6) DEFAULT '0.000000',
  `tax_usdollar` decimal(26,6) DEFAULT NULL,
  `total` decimal(26,6) DEFAULT NULL,
  `total_usdollar` decimal(26,6) DEFAULT NULL,
  `billing_address_street` varchar(150) DEFAULT NULL,
  `billing_address_city` varchar(100) DEFAULT NULL,
  `billing_address_state` varchar(100) DEFAULT NULL,
  `billing_address_postalcode` varchar(20) DEFAULT NULL,
  `billing_address_country` varchar(100) DEFAULT NULL,
  `shipping_address_street` varchar(150) DEFAULT NULL,
  `shipping_address_city` varchar(100) DEFAULT NULL,
  `shipping_address_state` varchar(100) DEFAULT NULL,
  `shipping_address_postalcode` varchar(20) DEFAULT NULL,
  `shipping_address_country` varchar(100) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quote_num` (`quote_num`),
  KEY `idx_quotes_date_modfied` (`date_modified`),
  KEY `idx_quotes_id_del` (`id`,`deleted`),
  KEY `idx_quotes_date_entered` (`date_entered`),
  KEY `idx_quotes_name_del` (`name`,`deleted`),
  KEY `idx_qte_name` (`name`),
  KEY `idx_quote_quote_stage` (`quote_stage`),
  KEY `idx_quote_date_quote_expected_closed` (`date_quote_expected_closed`),
  KEY `idx_quotes_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_quotes_tmst_id` (`team_set_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotes_accounts`
--

DROP TABLE IF EXISTS `quotes_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotes_accounts` (
  `id` char(36) NOT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `account_role` varchar(20) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_acc_qte_acc` (`account_id`),
  KEY `idx_acc_qte_opp` (`quote_id`),
  KEY `idx_quote_account_role` (`quote_id`,`account_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotes_audit`
--

DROP TABLE IF EXISTS `quotes_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotes_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_quotes_audit_parent_id` (`parent_id`),
  KEY `idx_quotes_audit_event_id` (`event_id`),
  KEY `idx_quotes_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_quotes_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotes_contacts`
--

DROP TABLE IF EXISTS `quotes_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotes_contacts` (
  `id` char(36) NOT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `contact_role` varchar(20) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_con_qte_con` (`contact_id`),
  KEY `idx_con_qte_opp` (`quote_id`),
  KEY `idx_quote_contact_role` (`quote_id`,`contact_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotes_opportunities`
--

DROP TABLE IF EXISTS `quotes_opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotes_opportunities` (
  `id` char(36) NOT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_opp_qte_opp` (`opportunity_id`),
  KEY `idx_quote_oportunities` (`quote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotes_sales_and_services_1_c`
--

DROP TABLE IF EXISTS `quotes_sales_and_services_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotes_sales_and_services_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `quotes_sales_and_services_1quotes_ida` char(36) DEFAULT NULL,
  `quotes_sales_and_services_1sales_and_services_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_quotes_sales_and_services_1_ida1_deleted` (`quotes_sales_and_services_1quotes_ida`,`deleted`),
  KEY `idx_quotes_sales_and_services_1_idb2_deleted` (`quotes_sales_and_services_1sales_and_services_idb`,`deleted`),
  KEY `quotes_sales_and_services_1_alt` (`quotes_sales_and_services_1sales_and_services_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `record_list`
--

DROP TABLE IF EXISTS `record_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `record_list` (
  `id` char(36) NOT NULL,
  `assigned_user_id` char(36) NOT NULL,
  `module_name` varchar(50) DEFAULT NULL,
  `records` longtext,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `releases`
--

DROP TABLE IF EXISTS `releases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `releases` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `list_order` int(4) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_releases` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_cache`
--

DROP TABLE IF EXISTS `report_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_cache` (
  `id` char(36) NOT NULL,
  `assigned_user_id` char(36) NOT NULL,
  `contents` text,
  `report_options` text,
  `deleted` varchar(1) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`assigned_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_maker`
--

DROP TABLE IF EXISTS `report_maker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_maker` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `report_align` varchar(8) DEFAULT NULL,
  `description` text,
  `scheduled` tinyint(1) DEFAULT '0',
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_rmaker` (`name`,`deleted`),
  KEY `idx_report_maker_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_schedules`
--

DROP TABLE IF EXISTS `report_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_schedules` (
  `id` char(36) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `report_id` char(36) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `next_run` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `time_interval` int(11) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `schedule_type` varchar(3) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `revenue_line_items`
--

DROP TABLE IF EXISTS `revenue_line_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revenue_line_items` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `product_template_id` char(36) DEFAULT NULL,
  `account_id` char(36) DEFAULT NULL,
  `total_amount` decimal(26,6) DEFAULT NULL,
  `type_id` char(36) DEFAULT NULL,
  `quote_id` char(36) DEFAULT NULL,
  `manufacturer_id` char(36) DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `mft_part_num` varchar(50) DEFAULT NULL,
  `vendor_part_num` varchar(50) DEFAULT NULL,
  `date_purchased` date DEFAULT NULL,
  `cost_price` decimal(26,6) DEFAULT NULL,
  `discount_price` decimal(26,6) DEFAULT NULL,
  `discount_amount` decimal(26,6) DEFAULT NULL,
  `discount_rate_percent` decimal(26,2) DEFAULT NULL,
  `discount_amount_usdollar` decimal(26,6) DEFAULT NULL,
  `discount_select` tinyint(1) DEFAULT '0',
  `deal_calc` decimal(26,6) DEFAULT NULL,
  `deal_calc_usdollar` decimal(26,6) DEFAULT NULL,
  `list_price` decimal(26,6) DEFAULT NULL,
  `cost_usdollar` decimal(26,6) DEFAULT NULL,
  `discount_usdollar` decimal(26,6) DEFAULT NULL,
  `list_usdollar` decimal(26,6) DEFAULT NULL,
  `status` varchar(100) DEFAULT '',
  `tax_class` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `weight` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT '1.00',
  `support_name` varchar(50) DEFAULT NULL,
  `support_description` varchar(255) DEFAULT NULL,
  `support_contact` varchar(50) DEFAULT NULL,
  `support_term` varchar(100) DEFAULT NULL,
  `date_support_expires` date DEFAULT NULL,
  `date_support_starts` date DEFAULT NULL,
  `pricing_formula` varchar(100) DEFAULT NULL,
  `pricing_factor` int(4) DEFAULT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `asset_number` varchar(50) DEFAULT NULL,
  `book_value` decimal(26,6) DEFAULT NULL,
  `book_value_usdollar` decimal(26,6) DEFAULT NULL,
  `book_value_date` date DEFAULT NULL,
  `best_case` decimal(26,6) DEFAULT NULL,
  `likely_case` decimal(26,6) DEFAULT NULL,
  `worst_case` decimal(26,6) DEFAULT NULL,
  `date_closed` date DEFAULT NULL,
  `date_closed_timestamp` bigint(20) unsigned DEFAULT NULL,
  `next_step` varchar(100) DEFAULT NULL,
  `commit_stage` varchar(50) DEFAULT 'exclude',
  `sales_stage` varchar(255) DEFAULT 'Prospecting',
  `probability` double DEFAULT NULL,
  `lead_source` varchar(50) DEFAULT NULL,
  `campaign_id` char(36) DEFAULT NULL,
  `opportunity_id` char(36) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `base_rate` decimal(26,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_revenue_line_items_date_modfied` (`date_modified`),
  KEY `idx_revenue_line_items_id_del` (`id`,`deleted`),
  KEY `idx_revenue_line_items_date_entered` (`date_entered`),
  KEY `idx_revenue_line_items_name_del` (`name`,`deleted`),
  KEY `idx_rli_user_dc_timestamp` (`id`,`assigned_user_id`,`date_closed_timestamp`),
  KEY `idx_revenuelineitem_sales_stage` (`sales_stage`),
  KEY `idx_revenuelineitem_probability` (`probability`),
  KEY `idx_revenuelineitem_commit_stage` (`commit_stage`),
  KEY `idx_revenuelineitem_quantity` (`quantity`),
  KEY `idx_revenuelineitem_oppid` (`opportunity_id`),
  KEY `idx_revenue_line_items_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_revenue_line_items_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `revenue_line_items_audit`
--

DROP TABLE IF EXISTS `revenue_line_items_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revenue_line_items_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_revenue_line_items_audit_parent_id` (`parent_id`),
  KEY `idx_revenue_line_items_audit_event_id` (`event_id`),
  KEY `idx_revenue_line_items_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_revenue_line_items_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `revenue_line_items_cstm`
--

DROP TABLE IF EXISTS `revenue_line_items_cstm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revenue_line_items_cstm` (
  `id_c` char(36) NOT NULL,
  `manifest_number_c` varchar(50) DEFAULT NULL,
  `estimated_quantity_c` decimal(12,2) DEFAULT '1.00',
  `unit_of_measure_c` varchar(100) DEFAULT 'Gallon',
  `charge_c` decimal(26,6) DEFAULT '0.000000',
  `close_amount_c` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text,
  `modules` text,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_role_id_del` (`id`,`deleted`),
  KEY `idx_role_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles_modules`
--

DROP TABLE IF EXISTS `roles_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_modules` (
  `id` char(36) NOT NULL,
  `role_id` char(36) DEFAULT NULL,
  `module_id` char(36) DEFAULT NULL,
  `allow` tinyint(1) DEFAULT '0',
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`),
  KEY `idx_module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles_users`
--

DROP TABLE IF EXISTS `roles_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_users` (
  `id` char(36) NOT NULL,
  `role_id` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_ru_role_id` (`role_id`),
  KEY `idx_ru_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_and_services`
--

DROP TABLE IF EXISTS `sales_and_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_and_services` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `ss_number` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ssnumk` (`ss_number`),
  KEY `idx_sales_and_services_date_modfied` (`date_modified`),
  KEY `idx_sales_and_services_id_del` (`id`,`deleted`),
  KEY `idx_sales_and_services_date_entered` (`date_entered`),
  KEY `idx_sales_and_services_name_del` (`name`,`deleted`),
  KEY `idx_sales_and_services_tmst_id` (`team_set_id`),
  KEY `idx_sales_and_services_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_and_services_accounts_1_c`
--

DROP TABLE IF EXISTS `sales_and_services_accounts_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_and_services_accounts_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `sales_and_services_accounts_1sales_and_services_ida` char(36) DEFAULT NULL,
  `sales_and_services_accounts_1accounts_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sales_and_services_accounts_1_ida1_deleted` (`sales_and_services_accounts_1sales_and_services_ida`,`deleted`),
  KEY `idx_sales_and_services_accounts_1_idb2_deleted` (`sales_and_services_accounts_1accounts_idb`,`deleted`),
  KEY `sales_and_services_accounts_1_alt` (`sales_and_services_accounts_1sales_and_services_ida`,`sales_and_services_accounts_1accounts_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_and_services_audit`
--

DROP TABLE IF EXISTS `sales_and_services_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_and_services_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_sales_and_services_audit_parent_id` (`parent_id`),
  KEY `idx_sales_and_services_audit_event_id` (`event_id`),
  KEY `idx_sales_and_services_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_sales_and_services_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_and_services_contacts_1_c`
--

DROP TABLE IF EXISTS `sales_and_services_contacts_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_and_services_contacts_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `sales_and_services_contacts_1sales_and_services_ida` char(36) DEFAULT NULL,
  `sales_and_services_contacts_1contacts_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sales_and_services_contacts_1_ida1_deleted` (`sales_and_services_contacts_1sales_and_services_ida`,`deleted`),
  KEY `idx_sales_and_services_contacts_1_idb2_deleted` (`sales_and_services_contacts_1contacts_idb`,`deleted`),
  KEY `sales_and_services_contacts_1_alt` (`sales_and_services_contacts_1sales_and_services_ida`,`sales_and_services_contacts_1contacts_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_and_services_cstm`
--

DROP TABLE IF EXISTS `sales_and_services_cstm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_and_services_cstm` (
  `id_c` char(36) NOT NULL,
  `on_date_c` date DEFAULT NULL,
  `status_c` varchar(100) DEFAULT 'Draft',
  `taxable_c` tinyint(1) DEFAULT '0',
  `auto_truck_service_number_c` varchar(255) DEFAULT NULL,
  `account_terms_c` varchar(100) DEFAULT '',
  `internal_notes_c` text,
  `print_notes_c` text,
  `billing_address_street_c` text,
  `billing_address_state_c` varchar(100) DEFAULT NULL,
  `billing_address_postalcode_c` varchar(20) DEFAULT NULL,
  `billing_address_city_c` varchar(100) DEFAULT NULL,
  `billing_address_country_c` varchar(100) DEFAULT NULL,
  `shipping_address_postalcode_c` varchar(20) DEFAULT NULL,
  `shipping_address_street_c` text,
  `shipping_address_city_c` varchar(100) DEFAULT NULL,
  `shipping_address_state_c` varchar(100) DEFAULT NULL,
  `shipping_address_country_c` varchar(100) DEFAULT NULL,
  `payment_status_c` varchar(100) DEFAULT '',
  `payment_reference_c` varchar(255) DEFAULT NULL,
  `payment_paid_c` tinyint(1) DEFAULT '1',
  `on_time_c` varchar(255) DEFAULT NULL,
  `profile_no_c` varchar(255) DEFAULT NULL,
  `svc_days_c` varchar(255) DEFAULT NULL,
  `ht_po_id_c` char(36) DEFAULT NULL,
  `svc_type_c` varchar(100) DEFAULT '1',
  `rli_total_c` decimal(18,2) DEFAULT NULL,
  `lat_c` varchar(255) DEFAULT '',
  `lon_c` varchar(255) DEFAULT '',
  PRIMARY KEY (`id_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_and_services_revenuelineitems_1_c`
--

DROP TABLE IF EXISTS `sales_and_services_revenuelineitems_1_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_and_services_revenuelineitems_1_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `sales_and_services_revenuelineitems_1sales_and_services_ida` char(36) DEFAULT NULL,
  `sales_and_services_revenuelineitems_1revenuelineitems_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sales_and_services_revenuelineitems_1_ida1_deleted` (`sales_and_services_revenuelineitems_1sales_and_services_ida`,`deleted`),
  KEY `idx_sales_and_services_revenuelineitems_1_idb2_deleted` (`sales_and_services_revenuelineitems_1revenuelineitems_idb`,`deleted`),
  KEY `sales_and_services_revenuelineitems_1_alt` (`sales_and_services_revenuelineitems_1revenuelineitems_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_reports`
--

DROP TABLE IF EXISTS `saved_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_reports` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `module` varchar(255) DEFAULT NULL,
  `report_type` varchar(255) DEFAULT NULL,
  `content` longtext,
  `is_published` tinyint(1) DEFAULT '0',
  `chart_type` varchar(36) DEFAULT 'none',
  `schedule_type` varchar(3) DEFAULT 'pro',
  `favorite` tinyint(1) DEFAULT '0',
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_saved_reports_date_modfied` (`date_modified`),
  KEY `idx_saved_reports_id_del` (`id`,`deleted`),
  KEY `idx_saved_reports_date_entered` (`date_entered`),
  KEY `idx_saved_reports_name_del` (`name`,`deleted`),
  KEY `idx_savedreport_module` (`module`),
  KEY `idx_saved_reports_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_saved_reports_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_search`
--

DROP TABLE IF EXISTS `saved_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_search` (
  `id` char(36) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `search_module` varchar(150) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `contents` text,
  `description` text,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_desc` (`name`,`deleted`),
  KEY `idx_saved_search_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedulers`
--

DROP TABLE IF EXISTS `schedulers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedulers` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `job` varchar(255) DEFAULT NULL,
  `date_time_start` datetime DEFAULT NULL,
  `date_time_end` datetime DEFAULT NULL,
  `job_interval` varchar(100) DEFAULT NULL,
  `time_from` time DEFAULT NULL,
  `time_to` time DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `catch_up` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_schedulers_date_modfied` (`date_modified`),
  KEY `idx_schedulers_id_del` (`id`,`deleted`),
  KEY `idx_schedulers_date_entered` (`date_entered`),
  KEY `idx_schedulers_name_del` (`name`,`deleted`),
  KEY `idx_schedule` (`date_time_start`,`deleted`),
  KEY `idx_scheduler_job_interval` (`job_interval`),
  KEY `idx_scheduler_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedulers_times`
--

DROP TABLE IF EXISTS `schedulers_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedulers_times` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `scheduler_id` char(36) NOT NULL,
  `execute_time` datetime DEFAULT NULL,
  `status` varchar(25) DEFAULT 'ready',
  PRIMARY KEY (`id`),
  KEY `idx_scheduler_id` (`scheduler_id`,`execute_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `session_active`
--

DROP TABLE IF EXISTS `session_active`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_active` (
  `id` char(36) NOT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `last_request_time` datetime DEFAULT NULL,
  `session_type` varchar(100) DEFAULT NULL,
  `is_violation` tinyint(1) DEFAULT '0',
  `num_active_sessions` int(11) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `session_history`
--

DROP TABLE IF EXISTS `session_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_history` (
  `id` char(36) NOT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `last_request_time` datetime DEFAULT NULL,
  `session_type` varchar(100) DEFAULT NULL,
  `is_violation` tinyint(1) DEFAULT '0',
  `num_active_sessions` int(11) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shippers`
--

DROP TABLE IF EXISTS `shippers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shippers` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `list_order` int(4) DEFAULT NULL,
  `default_cost` decimal(26,6) DEFAULT NULL,
  `default_cost_usdollar` decimal(26,6) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_shippers_date_modfied` (`date_modified`),
  KEY `idx_shippers_id_del` (`id`,`deleted`),
  KEY `idx_shippers_date_entered` (`date_entered`),
  KEY `idx_shippers_name_del` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `styleguide`
--

DROP TABLE IF EXISTS `styleguide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `styleguide` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `salutation` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `googleplus` varchar(100) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `do_not_call` tinyint(1) DEFAULT '0',
  `phone_home` varchar(100) DEFAULT NULL,
  `phone_mobile` varchar(100) DEFAULT NULL,
  `phone_work` varchar(100) DEFAULT NULL,
  `phone_other` varchar(100) DEFAULT NULL,
  `phone_fax` varchar(100) DEFAULT NULL,
  `primary_address_street` varchar(150) DEFAULT NULL,
  `primary_address_city` varchar(100) DEFAULT NULL,
  `primary_address_state` varchar(100) DEFAULT NULL,
  `primary_address_postalcode` varchar(20) DEFAULT NULL,
  `primary_address_country` varchar(255) DEFAULT NULL,
  `alt_address_street` varchar(150) DEFAULT NULL,
  `alt_address_city` varchar(100) DEFAULT NULL,
  `alt_address_state` varchar(100) DEFAULT NULL,
  `alt_address_postalcode` varchar(20) DEFAULT NULL,
  `alt_address_country` varchar(255) DEFAULT NULL,
  `assistant` varchar(75) DEFAULT NULL,
  `assistant_phone` varchar(100) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `file_mime_type` varchar(100) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `currency_id` char(36) DEFAULT '-99',
  `list_price` decimal(26,6) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `secret_password` varchar(255) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `radio_button_group` varchar(255) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_styleguide_date_modfied` (`date_modified`),
  KEY `idx_styleguide_id_del` (`id`,`deleted`),
  KEY `idx_styleguide_date_entered` (`date_entered`),
  KEY `idx_styleguide_last_first` (`last_name`,`first_name`,`deleted`),
  KEY `idx_styleguide_first_last` (`first_name`,`last_name`,`deleted`),
  KEY `idx_styleguide_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `parent_type` varchar(100) DEFAULT NULL,
  `parent_id` char(36) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_subscriptions_date_modfied` (`date_modified`),
  KEY `idx_subscriptions_id_del` (`id`,`deleted`),
  KEY `idx_subscriptions_date_entered` (`date_entered`),
  KEY `subscription_parent` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sugarfavorites`
--

DROP TABLE IF EXISTS `sugarfavorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sugarfavorites` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `record_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sugarfavorites_date_modfied` (`date_modified`),
  KEY `idx_sugarfavorites_id_del` (`id`,`deleted`),
  KEY `idx_sugarfavorites_date_entered` (`date_entered`),
  KEY `idx_sugarfavorites_name_del` (`name`,`deleted`),
  KEY `idx_favs_date_entered` (`date_entered`,`deleted`),
  KEY `idx_favs_user_module` (`modified_user_id`,`module`,`deleted`),
  KEY `idx_favs_module_record_deleted` (`module`,`record_id`,`deleted`),
  KEY `idx_favs_id_record_id` (`record_id`,`id`),
  KEY `idx_sugarfavorites_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag_bean_rel`
--

DROP TABLE IF EXISTS `tag_bean_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_bean_rel` (
  `id` char(36) NOT NULL,
  `tag_id` char(36) NOT NULL,
  `bean_id` char(36) NOT NULL,
  `bean_module` varchar(100) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_tagsrel_tagid_beanid` (`tag_id`,`bean_id`),
  KEY `idx_tag_bean_rel_del_bean_module_beanid` (`deleted`,`bean_module`,`bean_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `name_lower` varchar(255) DEFAULT NULL,
  `source_id` varchar(255) DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_meta` text,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tags_date_modfied` (`date_modified`),
  KEY `idx_tags_id_del` (`id`,`deleted`),
  KEY `idx_tags_date_entered` (`date_entered`),
  KEY `idx_tags_name_del` (`name`,`deleted`),
  KEY `idx_tag_name` (`name`),
  KEY `idx_tag_name_lower` (`name_lower`),
  KEY `idx_tags_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tags_audit`
--

DROP TABLE IF EXISTS `tags_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_tags_audit_parent_id` (`parent_id`),
  KEY `idx_tags_audit_event_id` (`event_id`),
  KEY `idx_tags_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_tags_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `status` varchar(100) DEFAULT 'Not Started',
  `date_due_flag` tinyint(1) DEFAULT '0',
  `date_due` datetime DEFAULT NULL,
  `date_start_flag` tinyint(1) DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `contact_id` char(36) DEFAULT NULL,
  `priority` varchar(100) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tasks_date_modfied` (`date_modified`),
  KEY `idx_tasks_id_del` (`id`,`deleted`),
  KEY `idx_tasks_date_entered` (`date_entered`),
  KEY `idx_tasks_name_del` (`name`,`deleted`),
  KEY `idx_tsk_name` (`name`),
  KEY `idx_task_con_del` (`contact_id`,`deleted`),
  KEY `idx_task_par_del` (`parent_id`,`parent_type`,`deleted`),
  KEY `idx_task_assigned` (`assigned_user_id`),
  KEY `idx_task_status` (`status`),
  KEY `idx_task_date_due` (`date_due`),
  KEY `idx_tasks_assigned_del` (`assigned_user_id`,`deleted`),
  KEY `idx_tasks_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tasks_audit`
--

DROP TABLE IF EXISTS `tasks_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_tasks_audit_parent_id` (`parent_id`),
  KEY `idx_tasks_audit_event_id` (`event_id`),
  KEY `idx_tasks_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_tasks_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `taxrates`
--

DROP TABLE IF EXISTS `taxrates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxrates` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `value` decimal(26,6) DEFAULT NULL,
  `list_order` int(4) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_taxrates_date_modfied` (`date_modified`),
  KEY `idx_taxrates_id_del` (`id`,`deleted`),
  KEY `idx_taxrates_date_entered` (`date_entered`),
  KEY `idx_taxrates_name_del` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team_memberships`
--

DROP TABLE IF EXISTS `team_memberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_memberships` (
  `id` char(36) NOT NULL,
  `team_id` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `explicit_assign` tinyint(1) DEFAULT '0',
  `implicit_assign` tinyint(1) DEFAULT '0',
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_team_membership` (`user_id`,`team_id`),
  KEY `idx_del_team_user` (`deleted`,`team_id`,`user_id`),
  KEY `idx_teammemb_team_user` (`team_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team_notices`
--

DROP TABLE IF EXISTS `team_notices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_notices` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `status` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `url_title` varchar(255) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_team_notice` (`name`,`deleted`),
  KEY `idx_team_notices_tmst_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team_set_events`
--

DROP TABLE IF EXISTS `team_set_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_set_events` (
  `id` char(36) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `params` text,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team_sets`
--

DROP TABLE IF EXISTS `team_sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_sets` (
  `id` char(36) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `team_md5` varchar(32) DEFAULT NULL,
  `team_count` int(11) DEFAULT '0',
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `created_by` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_team_sets_md5` (`team_md5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team_sets_modules`
--

DROP TABLE IF EXISTS `team_sets_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_sets_modules` (
  `id` char(36) NOT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `module_table_name` varchar(128) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_team_sets_modules` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team_sets_teams`
--

DROP TABLE IF EXISTS `team_sets_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_sets_teams` (
  `id` char(36) NOT NULL,
  `team_set_id` char(36) NOT NULL,
  `team_id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_ud_set_id` (`team_set_id`,`team_id`),
  KEY `idx_ud_team_id` (`team_id`),
  KEY `idx_ud_team_set_id` (`team_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team_sets_users_1`
--

DROP TABLE IF EXISTS `team_sets_users_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_sets_users_1` (
  `team_set_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  PRIMARY KEY (`team_set_id`,`user_id`),
  KEY `idx_tud1_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team_sets_users_2`
--

DROP TABLE IF EXISTS `team_sets_users_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_sets_users_2` (
  `team_set_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  PRIMARY KEY (`team_set_id`,`user_id`),
  KEY `idx_tud2_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` char(36) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `name_2` varchar(128) DEFAULT NULL,
  `associated_user_id` char(36) DEFAULT NULL,
  `private` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_teams_date_modfied` (`date_modified`),
  KEY `idx_teams_id_del` (`id`,`deleted`),
  KEY `idx_teams_date_entered` (`date_entered`),
  KEY `idx_teams_name_del` (`name`,`deleted`),
  KEY `idx_team_del` (`name`),
  KEY `idx_team_del_name` (`deleted`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `timeperiods`
--

DROP TABLE IF EXISTS `timeperiods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timeperiods` (
  `id` char(36) NOT NULL,
  `name` varchar(36) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_date_timestamp` int(14) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_date_timestamp` int(14) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `is_fiscal` tinyint(1) DEFAULT '0',
  `is_fiscal_year` tinyint(1) DEFAULT '0',
  `leaf_cycle` int(2) DEFAULT NULL,
  `type` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_timestamps` (`id`,`start_date_timestamp`,`end_date_timestamp`),
  KEY `idx_timeperiod_name` (`name`),
  KEY `idx_timeperiod_start_date` (`start_date`),
  KEY `idx_timeperiod_end_date` (`end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tracker`
--

DROP TABLE IF EXISTS `tracker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tracker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monitor_id` char(36) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `item_id` char(36) DEFAULT NULL,
  `item_summary` varchar(255) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `session_id` char(36) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_tracker_iid` (`item_id`),
  KEY `idx_tracker_userid_vis_id` (`user_id`,`visible`,`id`),
  KEY `idx_tracker_userid_itemid_vis` (`user_id`,`item_id`,`visible`),
  KEY `idx_tracker_userid_del_vis` (`user_id`,`deleted`,`visible`),
  KEY `idx_tracker_monitor_id` (`monitor_id`),
  KEY `idx_tracker_date_modified` (`date_modified`),
  KEY `idx_trckr_mod_uid_dtmod_item` (`module_name`,`user_id`,`date_modified`,`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=598 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tracker_perf`
--

DROP TABLE IF EXISTS `tracker_perf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tracker_perf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monitor_id` char(36) NOT NULL,
  `server_response_time` double DEFAULT NULL,
  `db_round_trips` int(6) DEFAULT NULL,
  `files_opened` int(6) DEFAULT NULL,
  `memory_usage` int(12) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tracker_perf_mon_id` (`monitor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tracker_queries`
--

DROP TABLE IF EXISTS `tracker_queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tracker_queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query_id` char(36) NOT NULL,
  `text` text,
  `query_hash` varchar(36) DEFAULT NULL,
  `sec_total` double DEFAULT NULL,
  `sec_avg` double DEFAULT NULL,
  `run_count` int(6) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tracker_queries_query_hash` (`query_hash`),
  KEY `idx_tracker_queries_query_id` (`query_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tracker_sessions`
--

DROP TABLE IF EXISTS `tracker_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tracker_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` char(36) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `seconds` int(9) DEFAULT '0',
  `client_ip` varchar(45) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_tracker_sessions_s_id` (`session_id`),
  KEY `idx_tracker_sessions_uas_id` (`user_id`,`active`,`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tracker_tracker_queries`
--

DROP TABLE IF EXISTS `tracker_tracker_queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tracker_tracker_queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monitor_id` char(36) DEFAULT NULL,
  `query_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tracker_tq_monitor` (`monitor_id`),
  KEY `idx_tracker_tq_query` (`query_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `upgrade_history`
--

DROP TABLE IF EXISTS `upgrade_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `upgrade_history` (
  `id` char(36) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `md5sum` varchar(32) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `version` varchar(64) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `id_name` varchar(255) DEFAULT NULL,
  `manifest` longtext,
  `patch` text,
  `date_entered` datetime DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `upgrade_history_md5_uk` (`md5sum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_preferences`
--

DROP TABLE IF EXISTS `user_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_preferences` (
  `id` char(36) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `assigned_user_id` char(36) NOT NULL,
  `contents` longtext,
  PRIMARY KEY (`id`),
  KEY `idx_userprefnamecat` (`assigned_user_id`,`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `user_name` varchar(60) DEFAULT NULL,
  `user_hash` varchar(255) DEFAULT NULL,
  `system_generated_password` tinyint(1) DEFAULT '0',
  `pwd_last_changed` datetime DEFAULT NULL,
  `authenticate_id` varchar(100) DEFAULT NULL,
  `sugar_login` tinyint(1) DEFAULT '1',
  `picture` varchar(255) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `external_auth_only` tinyint(1) DEFAULT '0',
  `receive_notifications` tinyint(1) DEFAULT '1',
  `description` text,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `phone_home` varchar(50) DEFAULT NULL,
  `phone_mobile` varchar(50) DEFAULT NULL,
  `phone_work` varchar(50) DEFAULT NULL,
  `phone_other` varchar(50) DEFAULT NULL,
  `phone_fax` varchar(50) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `address_street` varchar(150) DEFAULT NULL,
  `address_city` varchar(100) DEFAULT NULL,
  `address_state` varchar(100) DEFAULT NULL,
  `address_country` varchar(100) DEFAULT NULL,
  `address_postalcode` varchar(20) DEFAULT NULL,
  `default_team` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `portal_only` tinyint(1) DEFAULT '0',
  `show_on_employees` tinyint(1) DEFAULT '1',
  `employee_status` varchar(100) DEFAULT NULL,
  `messenger_id` varchar(100) DEFAULT NULL,
  `messenger_type` varchar(100) DEFAULT NULL,
  `reports_to_id` char(36) DEFAULT NULL,
  `is_group` tinyint(1) DEFAULT '0',
  `preferred_language` varchar(255) DEFAULT NULL,
  `acl_role_set_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_name` (`user_name`,`is_group`,`status`,`last_name`,`first_name`,`id`),
  KEY `idx_user_first_last` (`first_name`,`last_name`,`deleted`),
  KEY `idx_user_last_first` (`last_name`,`first_name`,`deleted`),
  KEY `idx_users_reports_to_id` (`reports_to_id`,`id`),
  KEY `idx_last_login` (`last_login`),
  KEY `idx_users_tmst_id` (`team_set_id`),
  KEY `idx_user_title` (`title`),
  KEY `idx_user_department` (`department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users_feeds`
--

DROP TABLE IF EXISTS `users_feeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_feeds` (
  `user_id` char(36) DEFAULT NULL,
  `feed_id` char(36) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  KEY `idx_ud_user_id` (`user_id`,`feed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users_holidays`
--

DROP TABLE IF EXISTS `users_holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_holidays` (
  `id` char(36) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `holiday_id` char(36) DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_user_holi_user` (`user_id`),
  KEY `idx_user_holi_holi` (`holiday_id`),
  KEY `users_quotes_alt` (`user_id`,`holiday_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users_last_import`
--

DROP TABLE IF EXISTS `users_last_import`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_last_import` (
  `id` char(36) NOT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `import_module` varchar(36) DEFAULT NULL,
  `bean_type` varchar(36) DEFAULT NULL,
  `bean_id` char(36) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`assigned_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users_password_link`
--

DROP TABLE IF EXISTS `users_password_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_password_link` (
  `id` char(36) NOT NULL,
  `username` varchar(36) DEFAULT NULL,
  `date_generated` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users_signatures`
--

DROP TABLE IF EXISTS `users_signatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_signatures` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `user_id` char(36) DEFAULT NULL,
  `signature` text,
  `signature_html` text,
  PRIMARY KEY (`id`),
  KEY `idx_users_signatures_date_modfied` (`date_modified`),
  KEY `idx_users_signatures_id_del` (`id`,`deleted`),
  KEY `idx_users_signatures_date_entered` (`date_entered`),
  KEY `idx_users_signatures_name_del` (`name`,`deleted`),
  KEY `idx_usersig_uid` (`user_id`),
  KEY `idx_usersig_created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `v_vendors`
--

DROP TABLE IF EXISTS `v_vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `v_vendors` (
  `id` char(36) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `googleplus` varchar(100) DEFAULT NULL,
  `v_vendors_type` varchar(50) DEFAULT NULL,
  `industry` varchar(50) DEFAULT NULL,
  `annual_revenue` varchar(100) DEFAULT NULL,
  `phone_fax` varchar(100) DEFAULT NULL,
  `billing_address_street` varchar(150) DEFAULT NULL,
  `billing_address_city` varchar(100) DEFAULT NULL,
  `billing_address_state` varchar(100) DEFAULT NULL,
  `billing_address_postalcode` varchar(20) DEFAULT NULL,
  `billing_address_country` varchar(255) DEFAULT NULL,
  `rating` varchar(100) DEFAULT NULL,
  `phone_office` varchar(100) DEFAULT NULL,
  `phone_alternate` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `ownership` varchar(100) DEFAULT NULL,
  `employees` varchar(10) DEFAULT NULL,
  `ticker_symbol` varchar(10) DEFAULT NULL,
  `shipping_address_street` varchar(150) DEFAULT NULL,
  `shipping_address_city` varchar(100) DEFAULT NULL,
  `shipping_address_state` varchar(100) DEFAULT NULL,
  `shipping_address_postalcode` varchar(20) DEFAULT NULL,
  `shipping_address_country` varchar(255) DEFAULT NULL,
  `team_id` char(36) DEFAULT NULL,
  `team_set_id` char(36) DEFAULT NULL,
  `acl_team_set_id` char(36) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_v_vendors_date_modfied` (`date_modified`),
  KEY `idx_v_vendors_id_del` (`id`,`deleted`),
  KEY `idx_v_vendors_date_entered` (`date_entered`),
  KEY `idx_v_vendors_name_del` (`name`,`deleted`),
  KEY `idx_v_vendors_tmst_id` (`team_set_id`),
  KEY `idx_v_vendors_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `v_vendors_accounts_c`
--

DROP TABLE IF EXISTS `v_vendors_accounts_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `v_vendors_accounts_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `v_vendors_accountsv_vendors_ida` char(36) DEFAULT NULL,
  `v_vendors_accountsaccounts_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_v_vendors_accounts_ida1_deleted` (`v_vendors_accountsv_vendors_ida`,`deleted`),
  KEY `idx_v_vendors_accounts_idb2_deleted` (`v_vendors_accountsaccounts_idb`,`deleted`),
  KEY `v_vendors_accounts_alt` (`v_vendors_accountsv_vendors_ida`,`v_vendors_accountsaccounts_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `v_vendors_audit`
--

DROP TABLE IF EXISTS `v_vendors_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `v_vendors_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_v_vendors_audit_parent_id` (`parent_id`),
  KEY `idx_v_vendors_audit_event_id` (`event_id`),
  KEY `idx_v_vendors_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_v_vendors_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `v_vendors_contacts_c`
--

DROP TABLE IF EXISTS `v_vendors_contacts_c`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `v_vendors_contacts_c` (
  `id` char(36) NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `v_vendors_contactsv_vendors_ida` char(36) DEFAULT NULL,
  `v_vendors_contactscontacts_idb` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_v_vendors_contacts_ida1_deleted` (`v_vendors_contactsv_vendors_ida`,`deleted`),
  KEY `idx_v_vendors_contacts_idb2_deleted` (`v_vendors_contactscontacts_idb`,`deleted`),
  KEY `v_vendors_contacts_alt` (`v_vendors_contactscontacts_idb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vcals`
--

DROP TABLE IF EXISTS `vcals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vcals` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `user_id` char(36) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `idx_vcal` (`type`,`user_id`,`source`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `versions`
--

DROP TABLE IF EXISTS `versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `versions` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `file_version` varchar(255) DEFAULT NULL,
  `db_version` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_version` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `weblogichooks`
--

DROP TABLE IF EXISTS `weblogichooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weblogichooks` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `webhook_target_module` varchar(255) DEFAULT NULL,
  `request_method` varchar(255) DEFAULT 'POST',
  `url` varchar(255) DEFAULT NULL,
  `trigger_event` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_weblogichooks_date_modfied` (`date_modified`),
  KEY `idx_weblogichooks_id_del` (`id`,`deleted`),
  KEY `idx_weblogichooks_date_entered` (`date_entered`),
  KEY `idx_weblogichooks_name_del` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `word_templates`
--

DROP TABLE IF EXISTS `word_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `word_templates` (
  `id` char(36) NOT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `document_name` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `file_ext` varchar(100) DEFAULT NULL,
  `file_mime_type` varchar(100) DEFAULT NULL,
  `active_date` date DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `category_id` varchar(100) DEFAULT NULL,
  `subcategory_id` varchar(100) DEFAULT NULL,
  `status_id` varchar(100) DEFAULT NULL,
  `word_temp_module` varchar(255) DEFAULT NULL,
  `assigned_user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_word_templates_date_modfied` (`date_modified`),
  KEY `idx_word_templates_id_del` (`id`,`deleted`),
  KEY `idx_word_templates_date_entered` (`date_entered`),
  KEY `idx_word_templates_assigned_del` (`assigned_user_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `word_templates_audit`
--

DROP TABLE IF EXISTS `word_templates_audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `word_templates_audit` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `data_type` varchar(100) DEFAULT NULL,
  `before_value_string` varchar(255) DEFAULT NULL,
  `after_value_string` varchar(255) DEFAULT NULL,
  `before_value_text` text,
  `after_value_text` text,
  PRIMARY KEY (`id`),
  KEY `idx_word_templates_audit_parent_id` (`parent_id`),
  KEY `idx_word_templates_audit_event_id` (`event_id`),
  KEY `idx_word_templates_audit_pa_ev_id` (`parent_id`,`event_id`),
  KEY `idx_word_templates_audit_after_value` (`after_value_string`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow`
--

DROP TABLE IF EXISTS `workflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `base_module` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `description` text,
  `type` varchar(100) DEFAULT NULL,
  `fire_order` varchar(100) DEFAULT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `record_type` varchar(100) DEFAULT NULL,
  `list_order_y` int(3) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_workflow` (`name`,`deleted`),
  KEY `idx_workflow_type` (`type`),
  KEY `idx_workflow_base_module` (`base_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow_actions`
--

DROP TABLE IF EXISTS `workflow_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow_actions` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `field` varchar(50) DEFAULT NULL,
  `value` text,
  `set_type` varchar(10) DEFAULT NULL,
  `adv_type` varchar(10) DEFAULT NULL,
  `parent_id` char(36) NOT NULL,
  `ext1` varchar(50) DEFAULT NULL,
  `ext2` varchar(50) DEFAULT NULL,
  `ext3` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_action` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow_actionshells`
--

DROP TABLE IF EXISTS `workflow_actionshells`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow_actionshells` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `action_type` varchar(100) DEFAULT NULL,
  `parent_id` char(36) NOT NULL,
  `parameters` varchar(255) DEFAULT NULL,
  `rel_module` varchar(50) DEFAULT NULL,
  `rel_module_type` varchar(10) DEFAULT NULL,
  `action_module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_actionshell` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow_alerts`
--

DROP TABLE IF EXISTS `workflow_alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow_alerts` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `field_value` varchar(50) DEFAULT NULL,
  `rel_email_value` varchar(50) DEFAULT NULL,
  `rel_module1` varchar(255) DEFAULT NULL,
  `rel_module2` varchar(255) DEFAULT NULL,
  `rel_module1_type` varchar(10) DEFAULT NULL,
  `rel_module2_type` varchar(10) DEFAULT NULL,
  `where_filter` tinyint(1) DEFAULT '0',
  `user_type` varchar(100) DEFAULT NULL,
  `array_type` varchar(100) DEFAULT NULL,
  `relate_type` varchar(100) DEFAULT NULL,
  `address_type` varchar(100) DEFAULT NULL,
  `parent_id` char(36) NOT NULL,
  `user_display_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_workflowalerts` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow_alertshells`
--

DROP TABLE IF EXISTS `workflow_alertshells`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow_alertshells` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `alert_text` text,
  `alert_type` varchar(100) DEFAULT NULL,
  `source_type` varchar(100) DEFAULT NULL,
  `parent_id` char(36) NOT NULL,
  `custom_template_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_workflowalertshell` (`name`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow_schedules`
--

DROP TABLE IF EXISTS `workflow_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow_schedules` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `date_expired` datetime DEFAULT NULL,
  `workflow_id` char(36) DEFAULT NULL,
  `target_module` varchar(50) DEFAULT NULL,
  `bean_id` char(36) DEFAULT NULL,
  `parameters` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_wkfl_schedule` (`workflow_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow_triggershells`
--

DROP TABLE IF EXISTS `workflow_triggershells`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow_triggershells` (
  `id` char(36) NOT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `field` varchar(50) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `frame_type` varchar(15) DEFAULT NULL,
  `eval` text,
  `parent_id` char(36) NOT NULL,
  `show_past` tinyint(1) DEFAULT '0',
  `rel_module` varchar(255) DEFAULT NULL,
  `rel_module_type` varchar(10) DEFAULT NULL,
  `parameters` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-08  3:35:26
