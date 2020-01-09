TYPE=VIEW
query=select `cl`.`id` AS `id`,`cl`.`name` AS `name`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`misawa2020`.`depositetrades` `dt` left join `misawa2020`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2020`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by `cl`.`id` desc
md5=5527d07250811f3ec501ee9e60bf2754
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-27 13:16:48
create-version=1
source=select `cl`.`id` AS `id`,`cl`.`name` AS `name`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by `cl`.`id` desc
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `cl`.`id` AS `id`,`cl`.`name` AS `name`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`misawa2020`.`depositetrades` `dt` left join `misawa2020`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2020`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by `cl`.`id` desc
