TYPE=VIEW
query=select `backup`.`products`.`id` AS `id`,`backup`.`products`.`name` AS `name`,count(0) AS `count`,sum(`backup`.`cartitems`.`total_r_price`) AS `total_r_price`,sum(`backup`.`cartitems`.`total_b_price`) AS `total_b_price` from (`backup`.`cartitems` join `backup`.`products` on((`backup`.`cartitems`.`product_id` = `backup`.`products`.`id`))) group by `backup`.`products`.`id`,`backup`.`products`.`name` limit 10
md5=bd57809062bdfde8928c6e4e07f1a1f0
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:05
create-version=1
source=select `products`.`id` AS `id`,`products`.`name` AS `name`,count(0) AS `count`,sum(`cartitems`.`total_r_price`) AS `total_r_price`,sum(`cartitems`.`total_b_price`) AS `total_b_price` from (`cartitems` join `products` on((`cartitems`.`product_id` = `products`.`id`))) group by `products`.`id`,`products`.`name` limit 10
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `backup`.`products`.`id` AS `id`,`backup`.`products`.`name` AS `name`,count(0) AS `count`,sum(`backup`.`cartitems`.`total_r_price`) AS `total_r_price`,sum(`backup`.`cartitems`.`total_b_price`) AS `total_b_price` from (`backup`.`cartitems` join `backup`.`products` on((`backup`.`cartitems`.`product_id` = `backup`.`products`.`id`))) group by `backup`.`products`.`id`,`backup`.`products`.`name` limit 10
