CREATE TABLE `field_class` (
    `field_class_id` int(10) NOT NULL, 
    `type` varchar(50) NOT NULL, 
    `class_block` varchar(100) NOT NULL, 
    `class_data_source` varchar(100), 
    `class_validation` varchar(100)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ENGINE=InnoDB;

ALTER TABLE `field_class` ADD CONSTRAINT field_class_pk PRIMARY KEY (`field_class_id`); 
ALTER TABLE `field_class` CHANGE field_class_id `field_class_id` int(10) AUTO_INCREMENT;
        
CREATE TABLE `report_field` (
    `report_field_id` int(10) NOT NULL, 
    `report_id_fk` int(10) NOT NULL, 
    `name` varchar(30) NOT NULL, 
    `field_class_id_fk` int(10) NOT NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ENGINE=InnoDB;

ALTER TABLE `report_field` ADD CONSTRAINT report_field_pk PRIMARY KEY (`report_field_id`); 
ALTER TABLE `report_field` CHANGE report_field_id `report_field_id` int(10) AUTO_INCREMENT;        