TYPE=VIEW
query=select `ci`.`po_id` AS `po_id`,date_format(`po`.`updated_at`,\'%y-%m-%d\') AS `po_date`,`ve`.`id` AS `vendor_id`,`ci`.`product_id` AS `product_id`,`ci`.`qty` AS `qty`,`ci`.`r_price` AS `r_price`,`ci`.`b_price` AS `b_price`,`ci`.`o_price` AS `o_price`,`ci`.`total_r_price` AS `total_r_price`,`ci`.`total_b_price` AS `total_b_price`,`ci`.`total_o_price` AS `total_o_price` from ((`misawa2019`.`cartitems` `ci` left join `misawa2019`.`pos` `po` on((`po`.`id` = `ci`.`po_id`))) left join `misawa2019`.`vendors` `ve` on((`po`.`vendor_id` = `ve`.`id`)))
md5=5f6f8b33de460d36018c69925721f7ab
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select `ci`.`po_id` AS `po_id`,date_format(`po`.`updated_at`,\'%y-%m-%d\') AS `po_date`,`ve`.`id` AS `vendor_id`,`ci`.`product_id` AS `product_id`,`ci`.`qty` AS `qty`,`ci`.`r_price` AS `r_price`,`ci`.`b_price` AS `b_price`,`ci`.`o_price` AS `o_price`,`ci`.`total_r_price` AS `total_r_price`,`ci`.`total_b_price` AS `total_b_price`,`ci`.`total_o_price` AS `total_o_price` from ((`cartitems` `ci` left join `pos` `po` on((`po`.`id` = `ci`.`po_id`))) left join `vendors` `ve` on((`po`.`vendor_id` = `ve`.`id`)))
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `ci`.`po_id` AS `po_id`,date_format(`po`.`updated_at`,\'%y-%m-%d\') AS `po_date`,`ve`.`id` AS `vendor_id`,`ci`.`product_id` AS `product_id`,`ci`.`qty` AS `qty`,`ci`.`r_price` AS `r_price`,`ci`.`b_price` AS `b_price`,`ci`.`o_price` AS `o_price`,`ci`.`total_r_price` AS `total_r_price`,`ci`.`total_b_price` AS `total_b_price`,`ci`.`total_o_price` AS `total_o_price` from ((`misawa2019`.`cartitems` `ci` left join `misawa2019`.`pos` `po` on((`po`.`id` = `ci`.`po_id`))) left join `misawa2019`.`vendors` `ve` on((`po`.`vendor_id` = `ve`.`id`)))
