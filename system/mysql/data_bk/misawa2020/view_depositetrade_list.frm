TYPE=VIEW
query=select `dt`.`id` AS `id`,`dt`.`created_at` AS `date`,`dt`.`po_id` AS `po_id`,`ps`.`vendor_id` AS `vendor_id`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`us`.`id` AS `user_id`,`us`.`name` AS `user_name`,`cs`.`name` AS `customer_name`,`cl`.`id` AS `client_id`,`cl`.`name` AS `client_name` from ((((`misawa2020`.`depositetrades` `dt` left join `misawa2020`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2020`.`pos` `ps` on((`ps`.`id` = `dt`.`po_id`))) left join `misawa2020`.`customers` `cs` on((`ps`.`customer_id` = `cs`.`id`))) left join `misawa2020`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
md5=b35f11e4d0e9365c3ad9fd37a23f9bde
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-18 23:33:50
create-version=1
source=SELECT\n   `dt`.`id` AS `id`,\n   `dt`.`created_at` AS `date`,\n   `dt`.`po_id` AS `po_id`,\n   `ps`.`vendor_id` AS `vendor_id`,\n   `dt`.`amount` AS `amount`,\n   `dt`.`sales` AS `sales`,\n   `us`.`id` AS `user_id`,\n   `us`.`name` AS `user_name`,\n   `cs`.`name` AS `customer_name`,\n   `cl`.`id` AS `client_id`,\n   `cl`.`name` AS `client_name`\nFROM ((((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `pos` `ps` on((`ps`.`id` = `dt`.`po_id`))) left join `customers` `cs` on((`ps`.`customer_id` = `cs`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `dt`.`id` AS `id`,`dt`.`created_at` AS `date`,`dt`.`po_id` AS `po_id`,`ps`.`vendor_id` AS `vendor_id`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`us`.`id` AS `user_id`,`us`.`name` AS `user_name`,`cs`.`name` AS `customer_name`,`cl`.`id` AS `client_id`,`cl`.`name` AS `client_name` from ((((`misawa2020`.`depositetrades` `dt` left join `misawa2020`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2020`.`pos` `ps` on((`ps`.`id` = `dt`.`po_id`))) left join `misawa2020`.`customers` `cs` on((`ps`.`customer_id` = `cs`.`id`))) left join `misawa2020`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
