TYPE=VIEW
query=select date_format(`a`.`created_at`,\'%Y%m\') AS `Ym`,count(0) AS `当月`,(select count(0) from `misawa2020`.`pos` where (date_format(`a`.`created_at`,\'%Y%m\') = date_format((`misawa2020`.`pos`.`created_at` + interval 1 month),\'%Y%m\'))) AS `上月` from `misawa2020`.`pos` `a` group by date_format(`a`.`created_at`,\'%Y%m\')
md5=fd0dfe2efbd4b20bf7aa9d7c600606b0
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-27 13:16:48
create-version=1
source=select date_format(`a`.`created_at`,\'%Y%m\') AS `Ym`,count(0) AS `当月`,(select count(0) from `pos` where (date_format(`a`.`created_at`,\'%Y%m\') = date_format((`pos`.`created_at` + interval 1 month),\'%Y%m\'))) AS `上月` from `pos` `a` group by date_format(`a`.`created_at`,\'%Y%m\')
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select date_format(`a`.`created_at`,\'%Y%m\') AS `Ym`,count(0) AS `当月`,(select count(0) from `misawa2020`.`pos` where (date_format(`a`.`created_at`,\'%Y%m\') = date_format((`misawa2020`.`pos`.`created_at` + interval 1 month),\'%Y%m\'))) AS `上月` from `misawa2020`.`pos` `a` group by date_format(`a`.`created_at`,\'%Y%m\')
