TYPE=VIEW
query=select `cat`.`id` AS `id`,`cat`.`name` AS `name`,count(0) AS `catalogue_count` from (`misawa2020`.`products` `pd` left join `misawa2020`.`catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) group by `cat`.`id`,`cat`.`name`
md5=0df29f9d9939958c3bb87731f5c1f47f
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-27 13:16:48
create-version=1
source=select `cat`.`id` AS `id`,`cat`.`name` AS `name`,count(0) AS `catalogue_count` from (`products` `pd` left join `catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) group by `cat`.`id`,`cat`.`name`
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `cat`.`id` AS `id`,`cat`.`name` AS `name`,count(0) AS `catalogue_count` from (`misawa2020`.`products` `pd` left join `misawa2020`.`catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) group by `cat`.`id`,`cat`.`name`
