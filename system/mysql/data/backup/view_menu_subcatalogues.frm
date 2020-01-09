TYPE=VIEW
query=select `sub`.`id` AS `id`,`sub`.`name` AS `name`,count(0) AS `count`,`sub`.`catalogue_id` AS `catalogue_id` from (`backup`.`products` `pd` left join `backup`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) where (`pd`.`active` = 1) group by `sub`.`id`,`sub`.`name`,`sub`.`catalogue_id`
md5=b1073a94fceb66e31faf9d67cb9959d1
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:05
create-version=1
source=select `sub`.`id` AS `id`,`sub`.`name` AS `name`,count(0) AS `count`,`sub`.`catalogue_id` AS `catalogue_id` from (`products` `pd` left join `subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) where (`pd`.`active` = 1) group by `sub`.`id`,`sub`.`name`,`sub`.`catalogue_id`
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `sub`.`id` AS `id`,`sub`.`name` AS `name`,count(0) AS `count`,`sub`.`catalogue_id` AS `catalogue_id` from (`backup`.`products` `pd` left join `backup`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) where (`pd`.`active` = 1) group by `sub`.`id`,`sub`.`name`,`sub`.`catalogue_id`
