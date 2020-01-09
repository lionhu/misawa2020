TYPE=VIEW
query=select sum(`misawa2019`.`depositetrades`.`amount`) AS `total_pay`,sum(`misawa2019`.`depositetrades`.`sales`) AS `total_sales` from `misawa2019`.`depositetrades` where (`misawa2019`.`depositetrades`.`io` = -(1))
md5=0636df06adb6615cf703e03f28457f9e
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-11-17 13:21:19
create-version=1
source=select sum(`depositetrades`.`amount`) AS `total_pay`,sum(`depositetrades`.`sales`) AS `total_sales` from `depositetrades` where (`depositetrades`.`io` = -(1))
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select sum(`misawa2019`.`depositetrades`.`amount`) AS `total_pay`,sum(`misawa2019`.`depositetrades`.`sales`) AS `total_sales` from `misawa2019`.`depositetrades` where (`misawa2019`.`depositetrades`.`io` = -(1))
