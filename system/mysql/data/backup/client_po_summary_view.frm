TYPE=VIEW
query=select `cl`.`id` AS `client_id`,`cl`.`name` AS `client_name`,count(0) AS `po_count`,sum(`backup`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`backup`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`backup`.`pos`.`cart_O_Price`) AS `total_O_price`,round((((sum(`backup`.`pos`.`cart_O_Price`) - sum(`backup`.`pos`.`cart_B_Price`)) / sum(`backup`.`pos`.`cart_B_Price`)) * 100),2) AS `salesprofit`,sum((`backup`.`pos`.`paid_vendor` * `backup`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`backup`.`pos`.`paid_customer` * `backup`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from ((`backup`.`pos` left join `backup`.`users` `user` on((`backup`.`pos`.`user_id` = `user`.`id`))) left join `backup`.`clients` `cl` on((`user`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by sum(`backup`.`pos`.`cart_B_Price`) desc
md5=1906444a0d62b378b40296bc3ae6d73b
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:04
create-version=1
source=select `cl`.`id` AS `client_id`,`cl`.`name` AS `client_name`,count(0) AS `po_count`,sum(`pos`.`cart_R_Price`) AS `total_R_price`,sum(`pos`.`cart_B_Price`) AS `total_B_price`,sum(`pos`.`cart_O_Price`) AS `total_O_price`,round((((sum(`pos`.`cart_O_Price`) - sum(`pos`.`cart_B_Price`)) / sum(`pos`.`cart_B_Price`)) * 100),2) AS `salesprofit`,sum((`pos`.`paid_vendor` * `pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`pos`.`paid_customer` * `pos`.`cart_B_Price`)) AS `total_paid_customer` from ((`pos` left join `users` `user` on((`pos`.`user_id` = `user`.`id`))) left join `clients` `cl` on((`user`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by sum(`pos`.`cart_B_Price`) desc
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `cl`.`id` AS `client_id`,`cl`.`name` AS `client_name`,count(0) AS `po_count`,sum(`backup`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`backup`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`backup`.`pos`.`cart_O_Price`) AS `total_O_price`,round((((sum(`backup`.`pos`.`cart_O_Price`) - sum(`backup`.`pos`.`cart_B_Price`)) / sum(`backup`.`pos`.`cart_B_Price`)) * 100),2) AS `salesprofit`,sum((`backup`.`pos`.`paid_vendor` * `backup`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`backup`.`pos`.`paid_customer` * `backup`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from ((`backup`.`pos` left join `backup`.`users` `user` on((`backup`.`pos`.`user_id` = `user`.`id`))) left join `backup`.`clients` `cl` on((`user`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by sum(`backup`.`pos`.`cart_B_Price`) desc
