TYPE=VIEW
query=select `cat`.`id` AS `id`,count(0) AS `count`,`cat`.`name` AS `name` from ((`misawa2019`.`products` `pd` left join `misawa2019`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) left join `misawa2019`.`catalogues` `cat` on((`sub`.`catalogue_id` = `cat`.`id`))) where (`pd`.`active` = 1) group by `cat`.`id`,`cat`.`name`
md5=75efb32ebd4580a2a9ccecf14f463e01
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select `cat`.`id` AS `id`,count(0) AS `count`,`cat`.`name` AS `name` from ((`products` `pd` left join `subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) left join `catalogues` `cat` on((`sub`.`catalogue_id` = `cat`.`id`))) where (`pd`.`active` = 1) group by `cat`.`id`,`cat`.`name`
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `cat`.`id` AS `id`,count(0) AS `count`,`cat`.`name` AS `name` from ((`misawa2019`.`products` `pd` left join `misawa2019`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) left join `misawa2019`.`catalogues` `cat` on((`sub`.`catalogue_id` = `cat`.`id`))) where (`pd`.`active` = 1) group by `cat`.`id`,`cat`.`name`
