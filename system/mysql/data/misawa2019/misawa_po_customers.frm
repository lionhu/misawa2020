TYPE=VIEW
query=select `po`.`id` AS `id`,date_format(`po`.`updated_at`,\'%Y-%m-%d\') AS `po_date`,`cu`.`name` AS `name`,`cu`.`postcode` AS `zipcode`,`cu`.`address1` AS `address_1`,`cu`.`address2` AS `address_2`,`cu`.`phone` AS `phone`,`cu`.`email` AS `email` from (`misawa2019`.`pos` `po` left join `misawa2019`.`customers` `cu` on((`po`.`customer_id` = `cu`.`id`))) where (`po`.`vendor_id` = 2)
md5=508a733532adaccfb45075556789aea8
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select `po`.`id` AS `id`,date_format(`po`.`updated_at`,\'%Y-%m-%d\') AS `po_date`,`cu`.`name` AS `name`,`cu`.`postcode` AS `zipcode`,`cu`.`address1` AS `address_1`,`cu`.`address2` AS `address_2`,`cu`.`phone` AS `phone`,`cu`.`email` AS `email` from (`pos` `po` left join `customers` `cu` on((`po`.`customer_id` = `cu`.`id`))) where (`po`.`vendor_id` = 2)
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `po`.`id` AS `id`,date_format(`po`.`updated_at`,\'%Y-%m-%d\') AS `po_date`,`cu`.`name` AS `name`,`cu`.`postcode` AS `zipcode`,`cu`.`address1` AS `address_1`,`cu`.`address2` AS `address_2`,`cu`.`phone` AS `phone`,`cu`.`email` AS `email` from (`misawa2019`.`pos` `po` left join `misawa2019`.`customers` `cu` on((`po`.`customer_id` = `cu`.`id`))) where (`po`.`vendor_id` = 2)
