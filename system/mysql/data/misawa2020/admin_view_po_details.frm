TYPE=VIEW
query=select `cis`.`po_id` AS `po_id`,`ps`.`vendor_id` AS `vendor_id`,`ps`.`created_at` AS `created_at`,`cis`.`product_id` AS `product_id`,`cis`.`qty` AS `qty`,`cis`.`total_r_price` AS `total_r_price`,`cis`.`total_b_price` AS `total_b_price`,`cis`.`total_o_price` AS `total_o_price`,`pd`.`name` AS `name`,`pd`.`name_jp` AS `name_jp`,`pd`.`manufactory` AS `manufactory`,`cis`.`r_price` AS `r_price`,`cis`.`b_price` AS `b_price`,`cis`.`o_price` AS `o_price`,`cat`.`name` AS `catalogue`,`subcat`.`name` AS `subcatalogue` from ((`misawa2020`.`pos` `ps` left join ((`misawa2020`.`cartitems` `cis` left join `misawa2020`.`products` `pd` on((`cis`.`product_id` = `pd`.`id`))) left join `misawa2020`.`catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) on((`ps`.`id` = `cis`.`po_id`))) left join `misawa2020`.`subcatalogues` `subcat` on((`pd`.`subcatalogue_id` = `subcat`.`id`)))
md5=2200d2ea35f471962d95793adf5eb840
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-27 13:16:48
create-version=1
source=select `cis`.`po_id` AS `po_id`,`ps`.`vendor_id` AS `vendor_id`,`ps`.`created_at` AS `created_at`,`cis`.`product_id` AS `product_id`,`cis`.`qty` AS `qty`,`cis`.`total_r_price` AS `total_r_price`,`cis`.`total_b_price` AS `total_b_price`,`cis`.`total_o_price` AS `total_o_price`,`pd`.`name` AS `name`,`pd`.`name_jp` AS `name_jp`,`pd`.`manufactory` AS `manufactory`,`cis`.`r_price` AS `r_price`,`cis`.`b_price` AS `b_price`,`cis`.`o_price` AS `o_price`,`cat`.`name` AS `catalogue`,`subcat`.`name` AS `subcatalogue` from ((`pos` `ps` left join ((`cartitems` `cis` left join `products` `pd` on((`cis`.`product_id` = `pd`.`id`))) left join `catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) on((`ps`.`id` = `cis`.`po_id`))) left join `subcatalogues` `subcat` on((`pd`.`subcatalogue_id` = `subcat`.`id`)))
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `cis`.`po_id` AS `po_id`,`ps`.`vendor_id` AS `vendor_id`,`ps`.`created_at` AS `created_at`,`cis`.`product_id` AS `product_id`,`cis`.`qty` AS `qty`,`cis`.`total_r_price` AS `total_r_price`,`cis`.`total_b_price` AS `total_b_price`,`cis`.`total_o_price` AS `total_o_price`,`pd`.`name` AS `name`,`pd`.`name_jp` AS `name_jp`,`pd`.`manufactory` AS `manufactory`,`cis`.`r_price` AS `r_price`,`cis`.`b_price` AS `b_price`,`cis`.`o_price` AS `o_price`,`cat`.`name` AS `catalogue`,`subcat`.`name` AS `subcatalogue` from ((`misawa2020`.`pos` `ps` left join ((`misawa2020`.`cartitems` `cis` left join `misawa2020`.`products` `pd` on((`cis`.`product_id` = `pd`.`id`))) left join `misawa2020`.`catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) on((`ps`.`id` = `cis`.`po_id`))) left join `misawa2020`.`subcatalogues` `subcat` on((`pd`.`subcatalogue_id` = `subcat`.`id`)))
