ALTER TABLE `report_field` 
    ADD `parameter_name` VARCHAR(255) NOT NULL DEFAULT '',
    ADD `report_field_class_type` VARCHAR(50) NOT NULL DEFAULT '';
    
ALTER TABLE `report_field_class` 
    ADD `class_converter` VARCHAR(100) NOT NULL DEFAULT '';

DELETE FROM `report_field_class`;
DELETE FROM `report_field`;
DELETE FROM `report`;

INSERT INTO `report_field_class` (`report_field_class_id`, `type`, `class_block`, `class_data_source`, `class_validation`, `class_converter`) VALUES
(3, 'projectSelector', 'TDProject_Report_Block_Widget_Element_GenericSelector', 'TDProject_Report_Model_Widget_ProjectSelectorSource', NULL, 'TDProject_Report_Model_Widget_Converter_Integer'),
(6, 'userSelector', 'TDProject_Report_Block_Widget_Element_GenericSelector', 'TDProject_Report_Model_Widget_UserSelectorSource', NULL, 'TDProject_Report_Model_Widget_Converter_Integer'),
(5, 'datePicker', 'TDProject_Report_Block_Widget_Element_DatePicker', NULL, NULL, 'TDProject_Report_Model_Widget_Converter_DateToMilliseconds'),
(4, 'booleanSelector', 'TDProject_Report_Block_Widget_Element_GenericSelector', 'TDProject_Report_Model_Widget_BooleanSelectorSource', NULL, 'TDProject_Report_Model_Widget_Converter_Integer');

INSERT INTO `report` (`report_id`, `name`, `description`, `unit`) VALUES
(7, 'Projektzeiten, Gesamt', 'Übersicht über alle Zeiten eines Projektes, abrechenbar und nicht abrechenbare', '/reports/tdproject/project_task_1'),
(9, 'Mitarbeiterzeiten, Einzelauflistung', 'Einzelaufstellung der Zeiten eines Mitarbeiters.', '/reports/tdproject/employee_time_single'),
(6, 'Projektzeiten', 'Übersicht über alle Zeiten eines Projektes.', '/reports/tdproject/project_task'),
(8, 'Mitarbeiterzeiten', 'Auflistung der Mitarbeiterzeiten.', '/reports/tdproject/employee_time');

INSERT INTO `report_field` (`report_field_id`, `report_id_fk`, `name`, `report_field_class_type`, `report_field_class_id_fk`, `parameter_name`) VALUES
(7, 6, 'from', 'datePicker', 5, 'FROM_DATE'),
(9, 6, 'billable', 'booleanSelector', 4, 'BILLABLE'),
(10, 6, 'projectId', 'projectSelector', 3, 'PROJECT_ID'),
(18, 9, 'until', 'datePicker', 5, 'TO_DATE'),
(15, 8, 'until', 'datePicker', 5, 'TO_DATE'),
(17, 9, 'from', 'datePicker', 5, 'FROM_DATE'),
(16, 9, 'userId', 'userSelector', 6, 'USER_ID'),
(12, 7, 'until', 'datePicker', 5, 'TO_DATE'),
(14, 8, 'from', 'datePicker', 5, 'FROM_DATE'),
(11, 7, 'from', 'datePicker', 5, 'FROM_DATE'),
(13, 7, 'project', 'projectSelector', 3, 'PROJECT_ID'),
(8, 6, 'until', 'datePicker', 5, 'TO_DATE');

CREATE TABLE `report_rendered` (
	`report_rendered_id` int(10) NOT NULL, 
	`report_id_fk` int(10) NOT NULL, 
	`user_id_fk` int(10) NOT NULL, 
	`username` varchar(45) NOT NULL, 
	`filename` varchar(255) NOT NULL,
	`format` enum('pdf','html') NOT NULL,
	`created_at` int(10) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ENGINE=MyISAM;

ALTER TABLE `report_rendered` ADD CONSTRAINT report_rendered_pk PRIMARY KEY (`report_rendered_id`); 
ALTER TABLE `report_rendered` CHANGE report_rendered_id `report_rendered_id` int(10) AUTO_INCREMENT;
    
CREATE INDEX report_rendered_idx_01 ON `report_rendered` (`report_id_fk`);
CREATE INDEX report_rendered_idx_02 ON `report_rendered` (`user_id_fk`);

ALTER TABLE `report_rendered` ADD CONSTRAINT report_rendered_fk_01 FOREIGN KEY (`report_id_fk`) REFERENCES `report` (`repoort_id`) ON DELETE CASCADE;
ALTER TABLE `report_rendered` ADD CONSTRAINT report_rendered_fk_02 FOREIGN KEY (`user_id_fk`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.report', 'Report');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.report.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.billable', 'Billable');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.project', 'Project');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.to_date', 'Until');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields', 'Report Fields');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.header.row.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.header.row.classConverter', 'Converter');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.header.row.actions', 'Actions');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.reportFieldId', 'ID');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportField', 'Report Field');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportField.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportField.parameterName', 'Parameter Name (JasperServer)');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.toolbar.back', 'Back');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.header.row.reportFieldClass', 'Type');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.reportFieldClass', 'Type');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.header.row.reportFieldClassType', 'Type');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.reportFieldClassType', 'Type');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.taskIdFk', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.taskId', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.print', 'Print');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.toolbar.print', 'Print Report');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.tabs.reports', 'Report');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.tabs.reports.report', 'Report');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.tabs.reports.report.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.tabs.reports.report.description', 'Description');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.tabs.reports.field', 'Field');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.tabs.reports.field.until', 'Until');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.from', 'From');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.taskId', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.print.print', 'Print');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.printTab', 'Print');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.toolbar.printReportButton', 'Print Report');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.header.row.reportRenderedId', 'ID');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.header.row.format', 'Format');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.header.row.actions', 'Actions');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.footer.row.reportRenderedId', 'ID');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.footer.row.format', 'Format');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.printReports', 'Input Fields');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.toolbar.printReport', 'widget.button.printReport');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.report.unit', 'Unit');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.report.description', 'Description');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field', 'Field');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.from', 'From');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.until', 'Until');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.from_date', 'From');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.projectId', 'Project');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reports.field.userId', 'User');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.header.row.reportFieldId', 'ID');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.header.row.parameterName', 'Parameter Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.parameterName', 'Parameter Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.classConverter', 'Converter');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.actions', 'Actions');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.toolbar.createReportField', 'New Report Field');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportField.classConverter', 'Converter Class');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportField.reportFieldClassIdFk', 'Field Type');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.toolbar.saveReportField', 'Save Report Field');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.toolbar.new', 'New');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.toolbar.save', 'Save');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.printReports.billable', 'billable');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.printReports.projectId', 'Project');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.printReports.taskId', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.toolbar.delete', 'Delete');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.toolbar.printReport', 'Print Report');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.tabs.reports.report.unit', 'Unit');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.tabs.reports.field.from', 'From');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.tabs.reports.field.taskId', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.until', 'Until');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'page.content.tabs.printTab.printFieldset', 'Print');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.billable', 'Billable');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.projectId', 'Project');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.header.row.username', 'Username');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.header.row.createdAt', 'Created At');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.footer.row.username', 'Username');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.footer.row.createdAt', 'Created At');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.reportRenderedGrid.footer.row.actions', 'Actions');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.printReports.from', 'From');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('en_US', 'content.printReports.until', 'Until');

INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.report', 'Report');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.report.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.billable', 'Abrechenbar');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.project', 'Projekt');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.to_date', 'Bis');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields', 'Berichtsfelder');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.header.row.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.header.row.classConverter', 'Konverter Klasse');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.header.row.actions', 'Actions');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.reportFieldId', 'ID');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportField', 'Report Field');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportField.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportField.parameterName', 'Parameter Name (JasperServer)');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.toolbar.back', 'Zurück');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.header.row.reportFieldClass', 'Typ');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.reportFieldClass', 'Typ');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.header.row.reportFieldClassType', 'Typ');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.reportFieldClassType', 'Typ');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.taskIdFk', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.taskId', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.print', 'Drucken');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.toolbar.print', 'Bericht Drucken');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.tabs.reports', 'Bericht');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.tabs.reports.report', 'Bericht');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.tabs.reports.report.name', 'Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.tabs.reports.report.description', 'Beschreibung');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.tabs.reports.field', 'Feld');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.tabs.reports.field.until', 'Bis');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.from', 'Von');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.taskId', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.print.print', 'Drucken');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.printTab', 'Drucken');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.toolbar.printReportButton', 'Bericht Drucken');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.header.row.reportRenderedId', 'ID');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.header.row.format', 'Format');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.header.row.actions', 'Actions');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.footer.row.reportRenderedId', 'ID');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.footer.row.format', 'Format');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.printReports', 'Berichtsfelder');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.toolbar.printReport', 'Drucken');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.report.unit', 'Unit');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.report.description', 'Beschreibung');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field', 'Feld');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.from', 'Von');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.until', 'Bis');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.from_date', 'Von');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.projectId', 'Projekt');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reports.field.userId', 'Benutzer');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.header.row.reportFieldId', 'ID');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.header.row.parameterName', 'Parameter Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.parameterName', 'Parameter Name');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.classConverter', 'Konverter Klasse');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.reportFields.reportFieldGrid.footer.row.actions', 'Actions');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.toolbar.createReportField', 'Neues Berichtsfeld');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportField.classConverter', 'Konverter Klasse');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportField.reportFieldClassIdFk', 'Typ');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.toolbar.saveReportField', 'Berichtsfeld Speichern');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.toolbar.new', 'Neu');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.toolbar.save', 'Speichern');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.printReports.billable', 'Abrechenbar');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.printReports.projectId', 'Projekt');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.printReports.taskId', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.toolbar.delete', 'Löschen');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.toolbar.printReport', 'Bericht Drucken');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.tabs.reports.report.unit', 'Unit');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.tabs.reports.field.from', 'Von');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.tabs.reports.field.taskId', 'Task');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.until', 'Bis');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'page.content.tabs.printTab.printFieldset', 'Print');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.billable', 'Abrechenbar');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.projectId', 'Projekt');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.header.row.username', 'Benutzername');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.header.row.createdAt', 'Erstellt am');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.footer.row.username', 'Benutzername');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.footer.row.createdAt', 'Erstellt am');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.reportRenderedGrid.footer.row.actions', 'Actions');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.printReports.from', 'Von');
INSERT INTO `resource` (`resource_locale`, `key`, `message`) VALUES ('de_DE', 'content.printReports.until', 'Bis');