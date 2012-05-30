# upgrade from db schema 1

# administrator constant is now 3
UPDATE `tbl_members` SET memberPrivileges = 3 WHERE memberPrivileges = 2;

# members groups table
CREATE TABLE `tbl_members_groups` (
`groupID` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`groupName` VARCHAR( 50 ) NULL DEFAULT NULL
) ENGINE = INNODB;

# @todo insert new audit trail types!!!!!!!!