TYPE=VIEW
query=select `cat`.`id` AS `id`,`cat`.`name` AS `name`,count(0) AS `catalogue_count` from (`backup`.`products` `pd` left join `backup`.`catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) group by `cat`.`id`,`cat`.`name`
md5=b4017e9b59ab113438d6987818c79bda
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:04
create-version=1
source=select `cat`.`id` AS `id`,`cat`.`name` AS `name`,count(0) AS `catalogue_count` from (`products` `pd` left join `catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) group by `cat`.`id`,`cat`.`name`
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select `cat`.`id` AS `id`,`cat`.`name` AS `name`,count(0) AS `catalogue_count` from (`backup`.`products` `pd` left join `backup`.`catalogues` `cat` on((`pd`.`catalogue_id` = `cat`.`id`))) group by `cat`.`id`,`cat`.`name`
