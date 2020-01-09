TYPE=VIEW
query=select `cat`.`id` AS `id`,count(0) AS `count`,`cat`.`name` AS `name` from ((`backup`.`products` `pd` left join `backup`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) left join `backup`.`catalogues` `cat` on((`sub`.`catalogue_id` = `cat`.`id`))) where (`pd`.`active` = 1) group by `cat`.`id`,`cat`.`name`
md5=1699148daf96ee79078714b3f446646d
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:05
create-version=1
source=select `cat`.`id` AS `id`,count(0) AS `count`,`cat`.`name` AS `name` from ((`products` `pd` left join `subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) left join `catalogues` `cat` on((`sub`.`catalogue_id` = `cat`.`id`))) where (`pd`.`active` = 1) group by `cat`.`id`,`cat`.`name`
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `cat`.`id` AS `id`,count(0) AS `count`,`cat`.`name` AS `name` from ((`backup`.`products` `pd` left join `backup`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) left join `backup`.`catalogues` `cat` on((`sub`.`catalogue_id` = `cat`.`id`))) where (`pd`.`active` = 1) group by `cat`.`id`,`cat`.`name`
