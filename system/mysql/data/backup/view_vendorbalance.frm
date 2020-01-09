TYPE=VIEW
query=select `vendor`.`id` AS `id`,`vendor`.`name` AS `name`,count(0) AS `count`,sum(`backup`.`pos`.`cart_Qty`) AS `Qty`,sum(`backup`.`pos`.`cart_R_Price`) AS `R_Price`,sum(`backup`.`pos`.`cart_B_Price`) AS `B_Price`,sum(`backup`.`pos`.`cart_O_Price`) AS `O_Price` from (`backup`.`pos` left join `backup`.`users` `vendor` on((`backup`.`pos`.`vendor_id` = `vendor`.`id`)))
md5=8ec9b0bb506b28cc6467f18193d6adb9
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:05
create-version=1
source=select `vendor`.`id` AS `id`,`vendor`.`name` AS `name`,count(0) AS `count`,sum(`pos`.`cart_Qty`) AS `Qty`,sum(`pos`.`cart_R_Price`) AS `R_Price`,sum(`pos`.`cart_B_Price`) AS `B_Price`,sum(`pos`.`cart_O_Price`) AS `O_Price` from (`pos` left join `users` `vendor` on((`pos`.`vendor_id` = `vendor`.`id`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `vendor`.`id` AS `id`,`vendor`.`name` AS `name`,count(0) AS `count`,sum(`backup`.`pos`.`cart_Qty`) AS `Qty`,sum(`backup`.`pos`.`cart_R_Price`) AS `R_Price`,sum(`backup`.`pos`.`cart_B_Price`) AS `B_Price`,sum(`backup`.`pos`.`cart_O_Price`) AS `O_Price` from (`backup`.`pos` left join `backup`.`users` `vendor` on((`backup`.`pos`.`vendor_id` = `vendor`.`id`)))
