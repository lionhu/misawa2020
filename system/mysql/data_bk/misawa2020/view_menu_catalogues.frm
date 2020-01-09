TYPE=VIEW
query=select `cat`.`id` AS `id`,count(0) AS `count`,`cat`.`name` AS `name` from ((`misawa2020`.`products` `pd` left join `misawa2020`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) left join `misawa2020`.`catalogues` `cat` on((`sub`.`catalogue_id` = `cat`.`id`))) where (`pd`.`active` = 1) group by `cat`.`id`,`cat`.`name`
md5=42672bb092dac2cd9908d4541f6878e5
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-18 23:33:50
create-version=1
source=SELECT\n   `cat`.`id` AS `id`,count(0) AS `count`,\n   `cat`.`name` AS `name`\nFROM ((`products` `pd` left join `subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) left join `catalogues` `cat` on((`sub`.`catalogue_id` = `cat`.`id`))) where (`pd`.`active` = 1) group by `cat`.`id`,`cat`.`name`
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `cat`.`id` AS `id`,count(0) AS `count`,`cat`.`name` AS `name` from ((`misawa2020`.`products` `pd` left join `misawa2020`.`subcatalogues` `sub` on((`pd`.`subcatalogue_id` = `sub`.`id`))) left join `misawa2020`.`catalogues` `cat` on((`sub`.`catalogue_id` = `cat`.`id`))) where (`pd`.`active` = 1) group by `cat`.`id`,`cat`.`name`
