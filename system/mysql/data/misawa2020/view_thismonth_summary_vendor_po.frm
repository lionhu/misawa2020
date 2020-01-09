TYPE=VIEW
query=select count(0) AS `po_count`,`misawa2020`.`pos`.`vendor_id` AS `vendor_id`,sum(`misawa2020`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`misawa2020`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`misawa2020`.`pos`.`cart_O_Price`) AS `total_O_price`,sum((`misawa2020`.`pos`.`paid_vendor` * `misawa2020`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`misawa2020`.`pos`.`paid_customer` * `misawa2020`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from `misawa2020`.`pos` where (date_format(`misawa2020`.`pos`.`created_at`,\'%Y-%m\') = date_format(now(),\'%Y-%m\')) group by `misawa2020`.`pos`.`vendor_id`,date_format(`misawa2020`.`pos`.`created_at`,\'%Y-%m\')
md5=ec7942b07d88711bd865cc83afa83698
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-27 13:16:48
create-version=1
source=select count(0) AS `po_count`,`pos`.`vendor_id` AS `vendor_id`,sum(`pos`.`cart_R_Price`) AS `total_R_price`,sum(`pos`.`cart_B_Price`) AS `total_B_price`,sum(`pos`.`cart_O_Price`) AS `total_O_price`,sum((`pos`.`paid_vendor` * `pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`pos`.`paid_customer` * `pos`.`cart_B_Price`)) AS `total_paid_customer` from `pos` where (date_format(`pos`.`created_at`,\'%Y-%m\') = date_format(now(),\'%Y-%m\')) group by `pos`.`vendor_id`,date_format(`pos`.`created_at`,\'%Y-%m\')
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select count(0) AS `po_count`,`misawa2020`.`pos`.`vendor_id` AS `vendor_id`,sum(`misawa2020`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`misawa2020`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`misawa2020`.`pos`.`cart_O_Price`) AS `total_O_price`,sum((`misawa2020`.`pos`.`paid_vendor` * `misawa2020`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`misawa2020`.`pos`.`paid_customer` * `misawa2020`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from `misawa2020`.`pos` where (date_format(`misawa2020`.`pos`.`created_at`,\'%Y-%m\') = date_format(now(),\'%Y-%m\')) group by `misawa2020`.`pos`.`vendor_id`,date_format(`misawa2020`.`pos`.`created_at`,\'%Y-%m\')
