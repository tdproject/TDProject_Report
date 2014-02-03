--
-- Refactoring table report_field_class
--
RENAME TABLE `field_class` TO `report_field_class` ;

ALTER TABLE `report_field_class` CHANGE `field_class_id` `report_field_class_id` INT( 10 ) NOT NULL AUTO_INCREMENT;

--
-- Refactoring table report_field
--
ALTER TABLE `report_field` CHANGE `field_class_id_fk` `report_field_class_id_fk` INT( 10 ) NOT NULL;

ALTER TABLE `report_field` ADD INDEX `report_field_idx_01` (`report_id_fk`);

ALTER TABLE `report_field` ADD CONSTRAINT report_field_fk_01 FOREIGN KEY (`report_id_fk`) REFERENCES `report` (`report_id`) ON DELETE CASCADE;
        
ALTER TABLE `report_field` ADD CONSTRAINT report_field_fk_02 FOREIGN KEY (`report_field_class_id_fk`) REFERENCES `report_field_class` (`report_field_class_id`) ON DELETE CASCADE;
        

--
-- Insert additional localization for printing reports
--
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES
('en_US', 'title.renderReport.view', 'print report'),
('de_DE', 'title.renderReport.view', 'Bericht drucken'),
('en_US', 'page.content.tabs.reports.field.user', 'user'),
('de_DE', 'page.content.tabs.reports.field.user', 'Mitarbeiter');
