TYPE=VIEW
query=select `bp`.`product_id` AS `bp.product_id`,count(0) AS `browse_count` from `misawa2020`.`browseproducts` `bp` group by `bp`.`product_id` order by count(0) desc limit 20
md5=4cdb26a0197286cab52bfc7072ba3a9e
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-27 13:16:48
create-version=1
source=select `bp`.`product_id` AS `bp.product_id`,count(0) AS `browse_count` from `browseproducts` `bp` group by `bp`.`product_id` order by count(0) desc limit 20
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `bp`.`product_id` AS `bp.product_id`,count(0) AS `browse_count` from `misawa2020`.`browseproducts` `bp` group by `bp`.`product_id` order by count(0) desc limit 20