TYPE=VIEW
query=select `vs`.`name` AS `vendor`,`ps`.`id` AS `po_id`,`cs`.`name` AS `customer`,`ps`.`cart_Qty` AS `Qty`,`ps`.`cart_R_Price` AS `R_Price`,`ps`.`cart_B_Price` AS `B_Price`,`ps`.`cart_O_Price` AS `O_Price`,`ps`.`paid_customer` AS `paid_customer`,`ps`.`paid_vendor` AS `paid_vendor`,`us`.`name` AS `user`,`ps`.`created_at` AS `created_at` from (((`misawa2020`.`pos` `ps` left join `misawa2020`.`vendors` `vs` on((`ps`.`vendor_id` = `vs`.`id`))) left join `misawa2020`.`users` `us` on((`ps`.`user_id` = `us`.`id`))) left join `misawa2020`.`customers` `cs` on((`ps`.`customer_id` = `cs`.`id`)))
md5=f96330b93c9378fa585eafbf0f3716e2
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-18 23:33:50
create-version=1
source=SELECT\n   `vs`.`name` AS `vendor`,\n   `ps`.`id` AS `po_id`,\n   `cs`.`name` AS `customer`,\n   `ps`.`cart_Qty` AS `Qty`,\n   `ps`.`cart_R_Price` AS `R_Price`,\n   `ps`.`cart_B_Price` AS `B_Price`,\n   `ps`.`cart_O_Price` AS `O_Price`,\n   `ps`.`paid_customer` AS `paid_customer`,\n   `ps`.`paid_vendor` AS `paid_vendor`,\n   `us`.`name` AS `user`,\n   `ps`.`created_at` AS `created_at`\nFROM (((`pos` `ps` left join `vendors` `vs` on((`ps`.`vendor_id` = `vs`.`id`))) left join `users` `us` on((`ps`.`user_id` = `us`.`id`))) left join `customers` `cs` on((`ps`.`customer_id` = `cs`.`id`)))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `vs`.`name` AS `vendor`,`ps`.`id` AS `po_id`,`cs`.`name` AS `customer`,`ps`.`cart_Qty` AS `Qty`,`ps`.`cart_R_Price` AS `R_Price`,`ps`.`cart_B_Price` AS `B_Price`,`ps`.`cart_O_Price` AS `O_Price`,`ps`.`paid_customer` AS `paid_customer`,`ps`.`paid_vendor` AS `paid_vendor`,`us`.`name` AS `user`,`ps`.`created_at` AS `created_at` from (((`misawa2020`.`pos` `ps` left join `misawa2020`.`vendors` `vs` on((`ps`.`vendor_id` = `vs`.`id`))) left join `misawa2020`.`users` `us` on((`ps`.`user_id` = `us`.`id`))) left join `misawa2020`.`customers` `cs` on((`ps`.`customer_id` = `cs`.`id`)))
