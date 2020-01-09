TYPE=VIEW
query=select count(0) AS `po_count`,`backup`.`pos`.`vendor_id` AS `vendor_id`,sum(`backup`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`backup`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`backup`.`pos`.`cart_O_Price`) AS `total_O_price`,sum((`backup`.`pos`.`paid_vendor` * `backup`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`backup`.`pos`.`paid_customer` * `backup`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from `backup`.`pos` where (date_format(`backup`.`pos`.`created_at`,\'%Y-%m\') = date_format(now(),\'%Y-%m\')) group by `backup`.`pos`.`vendor_id`,date_format(`backup`.`pos`.`created_at`,\'%Y-%m\')
md5=a616f3ce795807f3da7fce7350e359ea
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-19 11:14:05
create-version=1
source=select count(0) AS `po_count`,`pos`.`vendor_id` AS `vendor_id`,sum(`pos`.`cart_R_Price`) AS `total_R_price`,sum(`pos`.`cart_B_Price`) AS `total_B_price`,sum(`pos`.`cart_O_Price`) AS `total_O_price`,sum((`pos`.`paid_vendor` * `pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`pos`.`paid_customer` * `pos`.`cart_B_Price`)) AS `total_paid_customer` from `pos` where (date_format(`pos`.`created_at`,\'%Y-%m\') = date_format(now(),\'%Y-%m\')) group by `pos`.`vendor_id`,date_format(`pos`.`created_at`,\'%Y-%m\')
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select count(0) AS `po_count`,`backup`.`pos`.`vendor_id` AS `vendor_id`,sum(`backup`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`backup`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`backup`.`pos`.`cart_O_Price`) AS `total_O_price`,sum((`backup`.`pos`.`paid_vendor` * `backup`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`backup`.`pos`.`paid_customer` * `backup`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from `backup`.`pos` where (date_format(`backup`.`pos`.`created_at`,\'%Y-%m\') = date_format(now(),\'%Y-%m\')) group by `backup`.`pos`.`vendor_id`,date_format(`backup`.`pos`.`created_at`,\'%Y-%m\')
