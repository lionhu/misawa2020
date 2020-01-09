TYPE=VIEW
query=select `us`.`client_id` AS `id`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`misawa2020`.`depositetrades` `dt` left join `misawa2020`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2020`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `us`.`client_id` order by `us`.`client_id` desc
md5=d4ed72162fb7101d733564a8926e1ae5
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-27 13:16:48
create-version=1
source=select `us`.`client_id` AS `id`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `us`.`client_id` order by `us`.`client_id` desc
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `us`.`client_id` AS `id`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`misawa2020`.`depositetrades` `dt` left join `misawa2020`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `misawa2020`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `us`.`client_id` order by `us`.`client_id` desc
