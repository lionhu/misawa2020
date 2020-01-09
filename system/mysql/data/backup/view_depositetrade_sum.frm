TYPE=VIEW
query=select sum(`backup`.`depositetrades`.`amount`) AS `total_pay`,sum(`backup`.`depositetrades`.`sales`) AS `total_sales` from `backup`.`depositetrades` where (`backup`.`depositetrades`.`io` = -(1))
md5=e275a8648e693d38031f6c8be1e217f1
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:05
create-version=1
source=select sum(`depositetrades`.`amount`) AS `total_pay`,sum(`depositetrades`.`sales`) AS `total_sales` from `depositetrades` where (`depositetrades`.`io` = -(1))
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select sum(`backup`.`depositetrades`.`amount`) AS `total_pay`,sum(`backup`.`depositetrades`.`sales`) AS `total_sales` from `backup`.`depositetrades` where (`backup`.`depositetrades`.`io` = -(1))
