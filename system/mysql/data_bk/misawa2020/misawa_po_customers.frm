TYPE=VIEW
query=select `po`.`id` AS `id`,date_format(`po`.`updated_at`,\'%Y-%m-%d\') AS `po_date`,`cu`.`name` AS `name`,`cu`.`postcode` AS `zipcode`,`cu`.`address1` AS `address_1`,`cu`.`address2` AS `address_2`,`cu`.`phone` AS `phone`,`cu`.`email` AS `email` from (`misawa2020`.`pos` `po` left join `misawa2020`.`customers` `cu` on((`po`.`customer_id` = `cu`.`id`))) where (`po`.`vendor_id` = 2)
md5=e208a8c74367eae2e330b027590b75bf
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-18 23:33:50
create-version=1
source=SELECT\n   `po`.`id` AS `id`,date_format(`po`.`updated_at`,\'%Y-%m-%d\') AS `po_date`,\n   `cu`.`name` AS `name`,\n   `cu`.`postcode` AS `zipcode`,\n   `cu`.`address1` AS `address_1`,\n   `cu`.`address2` AS `address_2`,\n   `cu`.`phone` AS `phone`,\n   `cu`.`email` AS `email`\nFROM (`pos` `po` left join `customers` `cu` on((`po`.`customer_id` = `cu`.`id`))) where (`po`.`vendor_id` = 2)
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `po`.`id` AS `id`,date_format(`po`.`updated_at`,\'%Y-%m-%d\') AS `po_date`,`cu`.`name` AS `name`,`cu`.`postcode` AS `zipcode`,`cu`.`address1` AS `address_1`,`cu`.`address2` AS `address_2`,`cu`.`phone` AS `phone`,`cu`.`email` AS `email` from (`misawa2020`.`pos` `po` left join `misawa2020`.`customers` `cu` on((`po`.`customer_id` = `cu`.`id`))) where (`po`.`vendor_id` = 2)
