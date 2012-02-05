# upgrade from db schema 1

# administrator constant is now 3
UPDATE `tbl_members` SET memberPrivileges = 3 WHERE memberPrivileges = 2;