CREATE TABLE IF NOT EXISTS `#__fm_config` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`social_insurance_employee` FLOAT NOT NULL DEFAULT '0' ,
`social_insurance_support` FLOAT NOT NULL DEFAULT '0' ,
`medical_insurance_employee` FLOAT NOT NULL DEFAULT '0' ,
`medical_insurance_support` FLOAT NOT NULL  DEFAULT '0',
`unemployment_insurance_employee` FLOAT NOT NULL DEFAULT '0' ,
`unemployment_insurance_support` FLOAT NOT NULL  DEFAULT '0',
`union_employee` FLOAT NOT NULL DEFAULT '0' ,
`union_support` FLOAT NOT NULL  DEFAULT '0',
`allowance_x` FLOAT NOT NULL DEFAULT '0',
`allowance_y` FLOAT NOT NULL  DEFAULT '0',
`allowance_z` FLOAT NOT NULL DEFAULT '0' ,
`other_allowance` FLOAT NOT NULL DEFAULT '0' ,
`cost_water` FLOAT NOT NULL DEFAULT '0',
`electricity_1` FLOAT NOT NULL DEFAULT '0',
`electricity_2` FLOAT NOT NULL DEFAULT '0',
`electricity_3` FLOAT NOT NULL DEFAULT '0',
`electricity_4` FLOAT NOT NULL DEFAULT '0',
`electricity_5` FLOAT NOT NULL DEFAULT '0',
`electricity_6` FLOAT NOT NULL DEFAULT '0',
`allowance_36` FLOAT NOT NULL DEFAULT '0',
`base_pay` FLOAT NOT NULL DEFAULT '0',
`extra_income` FLOAT NOT NULL DEFAULT '0',
`time_update` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS `#__fm_revenue_deduction` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`employee_guid` VARCHAR(255)  NOT NULL  ,
`pay_electricity` FLOAT NOT NULL DEFAULT '0',
`water_charges` FLOAT NOT NULL DEFAULT '0',
`rent` FLOAT NOT NULL DEFAULT '0',
`detain_type` VARCHAR(255)  NOT NULL DEFAULT '1' ,
`detain` FLOAT NOT NULL DEFAULT '0',
`time_update` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS `#__fm_e_allowance` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`employee_guid` VARCHAR(255)  NOT NULL ,
`fe_allowances` DOUBLE NOT NULL DEFAULT '0' ,
`option_allowance` VARCHAR(255)  NOT NULL DEFAULT '1',
`earn_salary` DOUBLE NOT NULL NOT NULL DEFAULT '100',
`option_study` VARCHAR(255)  NOT NULL DEFAULT '3' ,
`option_break` VARCHAR(255)  NOT NULL DEFAULT '1' ,
`allowance_other` DOUBLE NOT NULL DEFAULT '0' ,
`info_allowance` DOUBLE NOT NULL DEFAULT '0' ,
`info_payroll` DOUBLE NOT NULL DEFAULT '0' ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;





CREATE TABLE IF NOT EXISTS `#__fm_employee_payroll` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`employee_guid` VARCHAR(255)  NOT NULL ,
`department_guid` VARCHAR(255)  NOT NULL ,
`payroll` FLOAT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS `#__fm_history_salary` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`workmonth` VARCHAR(255)  NOT NULL ,
`workyear` VARCHAR(255)  NOT NULL ,
`salary` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS `#__fm_date_config` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`date_payroll` INT(11)  NOT NULL ,
`checkout_time_payroll` DATE NULL DEFAULT '0000-00-00',
`date_salary` INT(11)  NOT NULL ,
`checkout_time_salary` DATE NOT NULL DEFAULT '0000-00-00',
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

/** Create History **/

/** Support Content history 
	- Config
**/
INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`) 
SELECT 'Config', 'com_fm.config', '{"special": {"dbtable": "#__fm_config","key": "id","type": "Config","prefix":"FmTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}}', '', '{"common": {"core_content_item_id":"id","core_title":"title","core_state":"state","core_alias":"alias","core_created_time":"created","core_modified_time":"modified","core_body":"introtext", "core_hits":"hits","core_publish_up":"publish_up","core_publish_down":"publish_down","core_access":"access", "core_params":"attribs", "core_featured":"featured", "core_metadata":"metadata", "core_language":"language", "core_images":"images", "core_urls":"urls", "core_version":"version", "core_ordering":"ordering", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"catid", "core_xreference":"xreference", "asset_id":"asset_id"},"special":{"guid":"guid","social_insurance_employee":"social_insurance_employee","social_insurance_support":"social_insurance_support"}}', 'FmHelperRoute::getConfigRoute', '{"formFile":"administrator\\/components\\/com_hrm\\/models\\/forms\\/config.xml", "hideFields": ["asset_id","checked_out","checked_out_time"], "ignoreChanges": [ "checked_out", "checked_out_time"],"convertToInt": [], "displayLookup": [{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'
FROM DUAL
WHERE NOT EXISTS (SELECT `type_alias` FROM `#__content_types` WHERE `type_alias`='com_fm.config');


/** Support Content history 
	- E_allowance
**/
INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`) 
SELECT 'E_allowance', 'com_fm.e_allowance', '{"special": {"dbtable": "#__fm_e_allowance","key": "id","type": "E_allowance","prefix":"FmTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}}', '', '{"common": {"core_content_item_id":"id","core_title":"title","core_state":"state","core_alias":"alias","core_created_time":"created","core_modified_time":"modified","core_body":"introtext", "core_hits":"hits","core_publish_up":"publish_up","core_publish_down":"publish_down","core_access":"access", "core_params":"attribs", "core_featured":"featured", "core_metadata":"metadata", "core_language":"language", "core_images":"images", "core_urls":"urls", "core_version":"version", "core_ordering":"ordering", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"catid", "core_xreference":"xreference", "asset_id":"asset_id"},"special":{"guid":"guid","employee_guid":"employee_guid"}}', 'FmHelperRoute::getE_allowanceRoute', '{"formFile":"administrator\\/components\\/com_hrm\\/models\\/forms\\/e_allowance.xml", "hideFields": ["asset_id","checked_out","checked_out_time"], "ignoreChanges": [ "checked_out", "checked_out_time"],"convertToInt": [], "displayLookup": [{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"employee_guid","targetTable":"#__hrm_employee","targetColumn":"guid","displayColumn":"fullname"}]}'
FROM DUAL
WHERE NOT EXISTS (SELECT `type_alias` FROM `#__content_types` WHERE `type_alias`='com_fm.e_allowance');


/** Support Content history 
	- E_allowance
**/
INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`) 
SELECT 'Revenuededuction', 'com_fm.revenuededuction', '{"special": {"dbtable": "#__fm_revenue_deduction","key": "id","type": "Revenuededuction","prefix":"FmTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}}', '', '{"common": {"core_content_item_id":"id","core_title":"title","core_state":"state","core_alias":"alias","core_created_time":"created","core_modified_time":"modified","core_body":"introtext", "core_hits":"hits","core_publish_up":"publish_up","core_publish_down":"publish_down","core_access":"access", "core_params":"attribs", "core_featured":"featured", "core_metadata":"metadata", "core_language":"language", "core_images":"images", "core_urls":"urls", "core_version":"version", "core_ordering":"ordering", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"catid", "core_xreference":"xreference", "asset_id":"asset_id"},"special":{"guid":"guid","employee_guid":"employee_guid"}}', 'FmHelperRoute::getRevenuedeductionRoute', '{"formFile":"administrator\\/components\\/com_hrm\\/models\\/forms\\/revenuededuction.xml", "hideFields": ["asset_id","checked_out","checked_out_time"], "ignoreChanges": [ "checked_out", "checked_out_time"],"convertToInt": [], "displayLookup": [{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"employee_guid","targetTable":"#__hrm_employee","targetColumn":"guid","displayColumn":"fullname"}]}'
FROM DUAL
WHERE NOT EXISTS (SELECT `type_alias` FROM `#__content_types` WHERE `type_alias`='com_fm.revenuededuction');

/**
Insert config
**/

INSERT INTO `#__fm_config` (`id`, `asset_id`, `ordering`, `state`, `checked_out`, `checked_out_time`, `created_by`, `guid`, `social_insurance_employee`, `social_insurance_support`, `medical_insurance_employee`, `medical_insurance_support`, `unemployment_insurance_employee`, `unemployment_insurance_support`, `union_employee`, `union_support`, `allowance_x`, `allowance_y`, `allowance_z`, `other_allowance`, `cost_water`, `electricity_1`, `electricity_2`, `electricity_3`, `electricity_4`, `electricity_5`, `electricity_6`, `allowance_36`, `base_pay`, `extra_income`, `time_update`) VALUES
(1, 462, 1, 1, 0, '0000-00-00 00:00:00', 266, 'D1870316-14F1-404E-9754-297870292DBE', 8, 18, 1.5, 3, 1, 1, 1, 1, 25, 45, 20, 12, 6000, 2000, 2000, 2000, 2000, 2000, 2000, 500000, 1150000, 50, '0000-00-00 00:00:00');


/**
Insert date_config
**/
INSERT INTO `y4x1k_fm_date_config` (`id`, `date_payroll`, `checkout_time_payroll`, `date_salary`, `checkout_time_salary`) VALUES
(1, 25, DATE_FORMAT(NOW(),'%Y-%m-25'), 26, DATE_FORMAT(NOW(),'%Y-%m-26'));






