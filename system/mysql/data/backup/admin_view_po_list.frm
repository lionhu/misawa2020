TYPE=VIEW
query=select `vs`.`name` AS `vendor`,`ps`.`id` AS `po_id`,`cs`.`name` AS `customer`,`ps`.`cart_Qty` AS `Qty`,`ps`.`cart_R_Price` AS `R_Price`,`ps`.`cart_B_Price` AS `B_Price`,`ps`.`cart_O_Price` AS `O_Price`,`ps`.`paid_customer` AS `paid_customer`,`ps`.`paid_vendor` AS `paid_vendor`,`us`.`name` AS `user`,`ps`.`created_at` AS `created_at` from (((`backup`.`pos` `ps` left join `backup`.`vendors` `vs` on((`ps`.`vendor_id` = `vs`.`id`))) left join `backup`.`users` `us` on((`ps`.`user_id` = `us`.`id`))) left join `backup`.`customers` `cs` on((`ps`.`customer_id` = `cs`.`id`)))
md5=75e7b318f9630eb8a98cc5300d61a995
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:04
create-version=1
source=select `vs`.`name` AS `vendor`,`ps`.`id` AS `po_id`,`cs`.`name` AS `customer`,`ps`.`cart_Qty` AS `Qty`,`ps`.`cart_R_Price` AS `R_Price`,`ps`.`cart_B_Price` AS `B_Price`,`ps`.`cart_O_Price` AS `O_Price`,`ps`.`paid_customer` AS `paid_customer`,`ps`.`paid_vendor` AS `paid_vendor`,`us`.`name` AS `user`,`ps`.`created_at` AS `created_at` from (((`pos` `ps` left join `vendors` `vs` on((`ps`.`vendor_id` = `vs`.`id`))) left join `users` `us` on((`ps`.`user_id` = `us`.`id`))) left join `customers` `cs` on((`ps`.`customer_id` = `cs`.`id`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `vs`.`name` AS `vendor`,`ps`.`id` AS `po_id`,`cs`.`name` AS `customer`,`ps`.`cart_Qty` AS `Qty`,`ps`.`cart_R_Price` AS `R_Price`,`ps`.`cart_B_Price` AS `B_Price`,`ps`.`cart_O_Price` AS `O_Price`,`ps`.`paid_customer` AS `paid_customer`,`ps`.`paid_vendor` AS `paid_vendor`,`us`.`name` AS `user`,`ps`.`created_at` AS `created_at` from (((`backup`.`pos` `ps` left join `backup`.`vendors` `vs` on((`ps`.`vendor_id` = `vs`.`id`))) left join `backup`.`users` `us` on((`ps`.`user_id` = `us`.`id`))) left join `backup`.`customers` `cs` on((`ps`.`customer_id` = `cs`.`id`)))
