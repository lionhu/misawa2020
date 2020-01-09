TYPE=VIEW
query=select `cat`.`id` AS `id`,`cat`.`name` AS `name`,count(0) AS `catalogue_count` from (`misawa2019`.`products` `pd` left join `misawa2019`.`catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) group by `cat`.`id`,`cat`.`name`
md5=e48b81a742bf711a362c7028c7a4ecba
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select `cat`.`id` AS `id`,`cat`.`name` AS `name`,count(0) AS `catalogue_count` from (`products` `pd` left join `catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) group by `cat`.`id`,`cat`.`name`
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `cat`.`id` AS `id`,`cat`.`name` AS `name`,count(0) AS `catalogue_count` from (`misawa2019`.`products` `pd` left join `misawa2019`.`catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) group by `cat`.`id`,`cat`.`name`
