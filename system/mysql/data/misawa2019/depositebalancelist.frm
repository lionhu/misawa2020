TYPE=VIEW
query=select `cl`.`id` AS `id`,`cl`.`name` AS `name`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`misawa2019`.`depositetrades` `dt` left join `misawa2019`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2019`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by `cl`.`id` desc
md5=bfbd0588d5c8ea5e93a9386054f67630
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select `cl`.`id` AS `id`,`cl`.`name` AS `name`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by `cl`.`id` desc
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `cl`.`id` AS `id`,`cl`.`name` AS `name`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`misawa2019`.`depositetrades` `dt` left join `misawa2019`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2019`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by `cl`.`id` desc
