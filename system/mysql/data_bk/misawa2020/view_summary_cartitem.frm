TYPE=VIEW
query=select `misawa2020`.`products`.`id` AS `id`,`misawa2020`.`products`.`name` AS `name`,count(0) AS `count`,sum(`misawa2020`.`cartitems`.`total_r_price`) AS `total_r_price`,sum(`misawa2020`.`cartitems`.`total_b_price`) AS `total_b_price` from (`misawa2020`.`cartitems` join `misawa2020`.`products` on((`misawa2020`.`cartitems`.`product_id` = `misawa2020`.`products`.`id`))) group by `misawa2020`.`products`.`id`,`misawa2020`.`products`.`name` limit 10
md5=2696aff62e886e6327b49d3a0ad9cbf1
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-18 23:33:50
create-version=1
source=SELECT\n   `products`.`id` AS `id`,\n   `products`.`name` AS `name`,count(0) AS `count`,sum(`cartitems`.`total_r_price`) AS `total_r_price`,sum(`cartitems`.`total_b_price`) AS `total_b_price`\nFROM (`cartitems` join `products` on((`cartitems`.`product_id` = `products`.`id`))) group by `products`.`id`,`products`.`name` limit 10
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `misawa2020`.`products`.`id` AS `id`,`misawa2020`.`products`.`name` AS `name`,count(0) AS `count`,sum(`misawa2020`.`cartitems`.`total_r_price`) AS `total_r_price`,sum(`misawa2020`.`cartitems`.`total_b_price`) AS `total_b_price` from (`misawa2020`.`cartitems` join `misawa2020`.`products` on((`misawa2020`.`cartitems`.`product_id` = `misawa2020`.`products`.`id`))) group by `misawa2020`.`products`.`id`,`misawa2020`.`products`.`name` limit 10
