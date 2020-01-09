TYPE=VIEW
query=select `vendor`.`id` AS `id`,`vendor`.`name` AS `name`,count(0) AS `count`,sum(`misawa2019`.`pos`.`cart_Qty`) AS `Qty`,sum(`misawa2019`.`pos`.`cart_R_Price`) AS `R_Price`,sum(`misawa2019`.`pos`.`cart_B_Price`) AS `B_Price`,sum(`misawa2019`.`pos`.`cart_O_Price`) AS `O_Price` from (`misawa2019`.`pos` left join `misawa2019`.`users` `vendor` on((`misawa2019`.`pos`.`vendor_id` = `vendor`.`id`)))
md5=15ab24be462b41438c8ebf8f831a75e1
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select `vendor`.`id` AS `id`,`vendor`.`name` AS `name`,count(0) AS `count`,sum(`pos`.`cart_Qty`) AS `Qty`,sum(`pos`.`cart_R_Price`) AS `R_Price`,sum(`pos`.`cart_B_Price`) AS `B_Price`,sum(`pos`.`cart_O_Price`) AS `O_Price` from (`pos` left join `users` `vendor` on((`pos`.`vendor_id` = `vendor`.`id`)))
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `vendor`.`id` AS `id`,`vendor`.`name` AS `name`,count(0) AS `count`,sum(`misawa2019`.`pos`.`cart_Qty`) AS `Qty`,sum(`misawa2019`.`pos`.`cart_R_Price`) AS `R_Price`,sum(`misawa2019`.`pos`.`cart_B_Price`) AS `B_Price`,sum(`misawa2019`.`pos`.`cart_O_Price`) AS `O_Price` from (`misawa2019`.`pos` left join `misawa2019`.`users` `vendor` on((`misawa2019`.`pos`.`vendor_id` = `vendor`.`id`)))
