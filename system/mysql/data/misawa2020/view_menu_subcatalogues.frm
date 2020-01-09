TYPE=VIEW
query=select `sub`.`id` AS `id`,`sub`.`name` AS `name`,count(0) AS `count`,`sub`.`catalogue_id` AS `catalogue_id` from (`misawa2020`.`products` `pd` left join `misawa2020`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) where (`pd`.`active` = 1) group by `sub`.`id`,`sub`.`name`,`sub`.`catalogue_id`
md5=1fe6655051aa42e7479c892ce1e3d436
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-27 13:16:48
create-version=1
source=select `sub`.`id` AS `id`,`sub`.`name` AS `name`,count(0) AS `count`,`sub`.`catalogue_id` AS `catalogue_id` from (`products` `pd` left join `subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) where (`pd`.`active` = 1) group by `sub`.`id`,`sub`.`name`,`sub`.`catalogue_id`
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `sub`.`id` AS `id`,`sub`.`name` AS `name`,count(0) AS `count`,`sub`.`catalogue_id` AS `catalogue_id` from (`misawa2020`.`products` `pd` left join `misawa2020`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) where (`pd`.`active` = 1) group by `sub`.`id`,`sub`.`name`,`sub`.`catalogue_id`
