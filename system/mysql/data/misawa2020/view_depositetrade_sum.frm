TYPE=VIEW
query=select sum(`misawa2020`.`depositetrades`.`amount`) AS `total_pay`,sum(`misawa2020`.`depositetrades`.`sales`) AS `total_sales` from `misawa2020`.`depositetrades` where (`misawa2020`.`depositetrades`.`io` = -(1))
md5=bff0a97ac812bd9abccfdb92cbfb520b
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-27 13:16:48
create-version=1
source=select sum(`depositetrades`.`amount`) AS `total_pay`,sum(`depositetrades`.`sales`) AS `total_sales` from `depositetrades` where (`depositetrades`.`io` = -(1))
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select sum(`misawa2020`.`depositetrades`.`amount`) AS `total_pay`,sum(`misawa2020`.`depositetrades`.`sales`) AS `total_sales` from `misawa2020`.`depositetrades` where (`misawa2020`.`depositetrades`.`io` = -(1))
