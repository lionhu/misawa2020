TYPE=VIEW
query=select `dt`.`id` AS `id`,`dt`.`io` AS `io`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`dt`.`po_id` AS `po_id`,`dt`.`created_at` AS `created_at`,`cl`.`id` AS `client_id`,`us`.`name` AS `username` from ((`misawa2020`.`depositetrades` `dt` left join `misawa2020`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2020`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
md5=1062f0a5068df4ed3003225f1f91abf4
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-18 23:33:50
create-version=1
source=SELECT\n   `dt`.`id` AS `id`,\n   `dt`.`io` AS `io`,\n   `dt`.`amount` AS `amount`,\n   `dt`.`sales` AS `sales`,\n   `dt`.`po_id` AS `po_id`,\n   `dt`.`created_at` AS `created_at`,\n   `cl`.`id` AS `client_id`,\n   `us`.`name` AS `username`\nFROM ((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `dt`.`id` AS `id`,`dt`.`io` AS `io`,`dt`.`amount` AS `amount`,`dt`.`sales` AS `sales`,`dt`.`po_id` AS `po_id`,`dt`.`created_at` AS `created_at`,`cl`.`id` AS `client_id`,`us`.`name` AS `username` from ((`misawa2020`.`depositetrades` `dt` left join `misawa2020`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2020`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`)))