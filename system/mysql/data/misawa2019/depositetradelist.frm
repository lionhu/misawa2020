TYPE=VIEW
query=select `dt`.`id` AS `id`,`dt`.`io` AS `io`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`dt`.`po_id` AS `po_id`,`dt`.`created_at` AS `created_at`,`cl`.`id` AS `client_id`,`us`.`name` AS `username` from ((`misawa2019`.`depositetrades` `dt` left join `misawa2019`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2019`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
md5=963b6670235b82a1fca16bf9a55727ad
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select `dt`.`id` AS `id`,`dt`.`io` AS `io`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`dt`.`po_id` AS `po_id`,`dt`.`created_at` AS `created_at`,`cl`.`id` AS `client_id`,`us`.`name` AS `username` from ((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `dt`.`id` AS `id`,`dt`.`io` AS `io`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`dt`.`po_id` AS `po_id`,`dt`.`created_at` AS `created_at`,`cl`.`id` AS `client_id`,`us`.`name` AS `username` from ((`misawa2019`.`depositetrades` `dt` left join `misawa2019`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2019`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
