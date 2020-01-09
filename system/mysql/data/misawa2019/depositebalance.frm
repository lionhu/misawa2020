TYPE=VIEW
query=select `us`.`client_id` AS `id`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`misawa2019`.`depositetrades` `dt` left join `misawa2019`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2019`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `us`.`client_id` order by `us`.`client_id` desc
md5=6ce67ebc2e9f9f535a52a3eefe9a60a6
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select `us`.`client_id` AS `id`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `us`.`client_id` order by `us`.`client_id` desc
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `us`.`client_id` AS `id`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`misawa2019`.`depositetrades` `dt` left join `misawa2019`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2019`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `us`.`client_id` order by `us`.`client_id` desc
