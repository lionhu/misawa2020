TYPE=VIEW
query=select date_format(`a`.`created_at`,\'%Y%m\') AS `Ym`,count(0) AS `当月`,(select count(0) from `misawa2019`.`pos` where (date_format(`a`.`created_at`,\'%Y%m\') = date_format((`misawa2019`.`pos`.`created_at` + interval 1 month),\'%Y%m\'))) AS `上月` from `misawa2019`.`pos` `a` group by date_format(`a`.`created_at`,\'%Y%m\')
md5=25a5a6b5d92782ebe80199b077bb9948
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select date_format(`a`.`created_at`,\'%Y%m\') AS `Ym`,count(0) AS `当月`,(select count(0) from `pos` where (date_format(`a`.`created_at`,\'%Y%m\') = date_format((`pos`.`created_at` + interval 1 month),\'%Y%m\'))) AS `上月` from `pos` `a` group by date_format(`a`.`created_at`,\'%Y%m\')
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select date_format(`a`.`created_at`,\'%Y%m\') AS `Ym`,count(0) AS `当月`,(select count(0) from `misawa2019`.`pos` where (date_format(`a`.`created_at`,\'%Y%m\') = date_format((`misawa2019`.`pos`.`created_at` + interval 1 month),\'%Y%m\'))) AS `上月` from `misawa2019`.`pos` `a` group by date_format(`a`.`created_at`,\'%Y%m\')
