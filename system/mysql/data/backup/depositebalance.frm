TYPE=VIEW
query=select `us`.`client_id` AS `id`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`backup`.`depositetrades` `dt` left join `backup`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `backup`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `us`.`client_id` order by `us`.`client_id` desc
md5=b1411682b5a79520057203e28ed6dc61
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:04
create-version=1
source=select `us`.`client_id` AS `id`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`depositetrades` `dt` left join `users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `us`.`client_id` order by `us`.`client_id` desc
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `us`.`client_id` AS `id`,sum((`dt`.`io` * `dt`.`amount`)) AS `amount` from ((`backup`.`depositetrades` `dt` left join `backup`.`users` `us` on((`dt`.`user_id` = `us`.`id`))) left join `backup`.`clients` `cl` on((`us`.`client_id` = `cl`.`id`))) group by `us`.`client_id` order by `us`.`client_id` desc
