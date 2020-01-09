TYPE=VIEW
query=select `cl`.`id` AS `client_id`,`cl`.`name` AS `client_name`,count(0) AS `po_count`,sum(`misawa2020`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`misawa2020`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`misawa2020`.`pos`.`cart_O_Price`) AS `total_O_price`,round((((sum(`misawa2020`.`pos`.`cart_O_Price`) - sum(`misawa2020`.`pos`.`cart_B_Price`)) / sum(`misawa2020`.`pos`.`cart_B_Price`)) * 100),2) AS `salesprofit`,sum((`misawa2020`.`pos`.`paid_vendor` * `misawa2020`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`misawa2020`.`pos`.`paid_customer` * `misawa2020`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from ((`misawa2020`.`pos` left join `misawa2020`.`users` `user` on((`misawa2020`.`pos`.`user_id` = `user`.`id`))) left join `misawa2020`.`clients` `cl` on((`user`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by sum(`misawa2020`.`pos`.`cart_B_Price`) desc
md5=e3f14d1bb8768e339f9282c0cfe3d041
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-18 23:33:50
create-version=1
source=SELECT\n   `cl`.`id` AS `client_id`,\n   `cl`.`name` AS `client_name`,count(0) AS `po_count`,sum(`pos`.`cart_R_Price`) AS `total_R_price`,sum(`pos`.`cart_B_Price`) AS `total_B_price`,sum(`pos`.`cart_O_Price`) AS `total_O_price`,round((((sum(`pos`.`cart_O_Price`) - sum(`pos`.`cart_B_Price`)) / sum(`pos`.`cart_B_Price`)) * 100),2) AS `salesprofit`,sum((`pos`.`paid_vendor` * `pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`pos`.`paid_customer` * `pos`.`cart_B_Price`)) AS `total_paid_customer`\nFROM ((`pos` left join `users` `user` on((`pos`.`user_id` = `user`.`id`))) left join `clients` `cl` on((`user`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by sum(`pos`.`cart_B_Price`) desc
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `cl`.`id` AS `client_id`,`cl`.`name` AS `client_name`,count(0) AS `po_count`,sum(`misawa2020`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`misawa2020`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`misawa2020`.`pos`.`cart_O_Price`) AS `total_O_price`,round((((sum(`misawa2020`.`pos`.`cart_O_Price`) - sum(`misawa2020`.`pos`.`cart_B_Price`)) / sum(`misawa2020`.`pos`.`cart_B_Price`)) * 100),2) AS `salesprofit`,sum((`misawa2020`.`pos`.`paid_vendor` * `misawa2020`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`misawa2020`.`pos`.`paid_customer` * `misawa2020`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from ((`misawa2020`.`pos` left join `misawa2020`.`users` `user` on((`misawa2020`.`pos`.`user_id` = `user`.`id`))) left join `misawa2020`.`clients` `cl` on((`user`.`client_id` = `cl`.`id`))) group by `cl`.`id`,`cl`.`name` order by sum(`misawa2020`.`pos`.`cart_B_Price`) desc
