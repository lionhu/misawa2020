TYPE=VIEW
query=select `vendor`.`id` AS `id`,`vendor`.`name` AS `name`,count(0) AS `count`,sum(`misawa2020`.`pos`.`cart_Qty`) AS `Qty`,sum(`misawa2020`.`pos`.`cart_R_Price`) AS `R_Price`,sum(`misawa2020`.`pos`.`cart_B_Price`) AS `B_Price`,sum(`misawa2020`.`pos`.`cart_O_Price`) AS `O_Price` from (`misawa2020`.`pos` left join `misawa2020`.`users` `vendor` on((`misawa2020`.`pos`.`vendor_id` = `vendor`.`id`)))
md5=0b8bfb794b408abd30617373add857d7
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-18 23:33:50
create-version=1
source=SELECT\n   `vendor`.`id` AS `id`,\n   `vendor`.`name` AS `name`,count(0) AS `count`,sum(`pos`.`cart_Qty`) AS `Qty`,sum(`pos`.`cart_R_Price`) AS `R_Price`,sum(`pos`.`cart_B_Price`) AS `B_Price`,sum(`pos`.`cart_O_Price`) AS `O_Price`\nFROM (`pos` left join `users` `vendor` on((`pos`.`vendor_id` = `vendor`.`id`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `vendor`.`id` AS `id`,`vendor`.`name` AS `name`,count(0) AS `count`,sum(`misawa2020`.`pos`.`cart_Qty`) AS `Qty`,sum(`misawa2020`.`pos`.`cart_R_Price`) AS `R_Price`,sum(`misawa2020`.`pos`.`cart_B_Price`) AS `B_Price`,sum(`misawa2020`.`pos`.`cart_O_Price`) AS `O_Price` from (`misawa2020`.`pos` left join `misawa2020`.`users` `vendor` on((`misawa2020`.`pos`.`vendor_id` = `vendor`.`id`)))
