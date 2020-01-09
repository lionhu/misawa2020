TYPE=VIEW
query=select `dt`.`id` AS `id`,`dt`.`created_at` AS `date`,`dt`.`po_id` AS `po_id`,`ps`.`vendor_id` AS `vendor_id`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`us`.`id` AS `user_id`,`us`.`name` AS `user_name`,`cs`.`name` AS `customer_name`,`cl`.`id` AS `client_id`,`cl`.`name` AS `client_name` from ((((`backup`.`depositetrades` `dt` left join `backup`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `backup`.`pos` `ps` on((`ps`.`id` = `dt`.`po_id`))) left join `backup`.`customers` `cs` on((`ps`.`customer_id` = `cs`.`id`))) left join `backup`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
md5=d99248a85089b935907fad62bb172b1b
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:04
create-version=1
source=select `dt`.`id` AS `id`,`dt`.`created_at` AS `date`,`dt`.`po_id` AS `po_id`,`ps`.`vendor_id` AS `vendor_id`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`us`.`id` AS `user_id`,`us`.`name` AS `user_name`,`cs`.`name` AS `customer_name`,`cl`.`id` AS `client_id`,`cl`.`name` AS `client_name` from ((((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `pos` `ps` on((`ps`.`id` = `dt`.`po_id`))) left join `customers` `cs` on((`ps`.`customer_id` = `cs`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `dt`.`id` AS `id`,`dt`.`created_at` AS `date`,`dt`.`po_id` AS `po_id`,`ps`.`vendor_id` AS `vendor_id`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`us`.`id` AS `user_id`,`us`.`name` AS `user_name`,`cs`.`name` AS `customer_name`,`cl`.`id` AS `client_id`,`cl`.`name` AS `client_name` from ((((`backup`.`depositetrades` `dt` left join `backup`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `backup`.`pos` `ps` on((`ps`.`id` = `dt`.`po_id`))) left join `backup`.`customers` `cs` on((`ps`.`customer_id` = `cs`.`id`))) left join `backup`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
