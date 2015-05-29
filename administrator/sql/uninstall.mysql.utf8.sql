
DROP TABLE IF EXISTS `#__fm_history_salary`;

DROP TABLE IF EXISTS `#__fm_employee_payroll`;


DELETE FROM `#__content_types` WHERE `#__content_types`.`type_alias` = 'com_fm.config';
DELETE FROM `#__ucm_history` WHERE `#__ucm_history`.`ucm_type_id` IN (SELECT `type_id` FROM `#__content_types` WHERE `#__content_types`.`type_alias` = 'com_fm.config');
DROP TABLE IF EXISTS `#__fm_config`;

DELETE FROM `#__content_types` WHERE `#__content_types`.`type_alias` = 'com_fm.e_allowance';
DELETE FROM `#__ucm_history` WHERE `#__ucm_history`.`ucm_type_id` IN (SELECT `type_id` FROM `#__content_types` WHERE `#__content_types`.`type_alias` = 'com_fm.e_allowance');
DROP TABLE IF EXISTS `#__fm_e_allowance`;

DELETE FROM `#__content_types` WHERE `#__content_types`.`type_alias` = 'com_fm.revenuededuction';
DELETE FROM `#__ucm_history` WHERE `#__ucm_history`.`ucm_type_id` IN (SELECT `type_id` FROM `#__content_types` WHERE `#__content_types`.`type_alias` = 'com_fm.revenuededuction');
DROP TABLE IF EXISTS `#__fm_revenue_deduction`;




