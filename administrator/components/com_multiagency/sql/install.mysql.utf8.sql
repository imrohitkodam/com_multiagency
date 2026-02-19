CREATE TABLE IF NOT EXISTS `#__tjmultiagency_multiagency` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`country_id` TEXT NOT NULL ,
`address` TEXT NOT NULL ,
`phone_no` TEXT NOT NULL ,
`email`  VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
)ENGINE=INNODB DEFAULT COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `#__tjmultiagency_licences` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`multiagency_id` INT(11)  NOT NULL ,
`course_id` TEXT NOT NULL ,
`total_seats` INT(11)  NOT NULL ,
`used_seats` INT(11)  NOT NULL ,
`start_date` DATETIME NOT NULL ,
`end_date` DATETIME NOT NULL ,
`comment` TEXT NOT NULL ,
PRIMARY KEY (`id`)
)ENGINE=INNODB DEFAULT COLLATE=utf8mb4_unicode_ci;
