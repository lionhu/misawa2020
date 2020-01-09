TYPE=VIEW
query=select `dt`.`id` AS `id`,`dt`.`io` AS `io`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`dt`.`po_id` AS `po_id`,`dt`.`created_at` AS `created_at`,`cl`.`id` AS `client_id`,`us`.`name` AS `username` from ((`backup`.`depositetrades` `dt` left join `backup`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `backup`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
md5=0de3cc6eb1a602215deb593080a913a8
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:04
create-version=1
source=select `dt`.`id` AS `id`,`dt`.`io` AS `io`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`dt`.`po_id` AS `po_id`,`dt`.`created_at` AS `created_at`,`cl`.`id` AS `client_id`,`us`.`name` AS `username` from ((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `dt`.`id` AS `id`,`dt`.`io` AS `io`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`dt`.`po_id` AS `po_id`,`dt`.`created_at` AS `created_at`,`cl`.`id` AS `client_id`,`us`.`name` AS `username` from ((`backup`.`depositetrades` `dt` left join `backup`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `backup`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
