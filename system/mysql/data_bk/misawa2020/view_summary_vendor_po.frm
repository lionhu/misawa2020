TYPE=VIEW
query=select count(0) AS `po_count`,`misawa2020`.`pos`.`vendor_id` AS `vendor_id`,sum(`misawa2020`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`misawa2020`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`misawa2020`.`pos`.`cart_O_Price`) AS `total_O_price`,sum((`misawa2020`.`pos`.`paid_vendor` * `misawa2020`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`misawa2020`.`pos`.`paid_customer` * `misawa2020`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from `misawa2020`.`pos` group by `misawa2020`.`pos`.`vendor_id`
md5=5fb3c3bb1b8d65308292ff47562e50f0
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=2019-10-18 23:33:50
create-version=1
source=SELECT\n   count(0) AS `po_count`,\n   `pos`.`vendor_id` AS `vendor_id`,sum(`pos`.`cart_R_Price`) AS `total_R_price`,sum(`pos`.`cart_B_Price`) AS `total_B_price`,sum(`pos`.`cart_O_Price`) AS `total_O_price`,sum((`pos`.`paid_vendor` * `pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`pos`.`paid_customer` * `pos`.`cart_B_Price`)) AS `total_paid_customer`\nFROM `pos` group by `pos`.`vendor_id`
client_cs_name=utf8
connection_cl_name=utf8_general_ci
view_body_utf8=select count(0) AS `po_count`,`misawa2020`.`pos`.`vendor_id` AS `vendor_id`,sum(`misawa2020`.`pos`.`cart_R_Price`) AS `total_R_price`,sum(`misawa2020`.`pos`.`cart_B_Price`) AS `total_B_price`,sum(`misawa2020`.`pos`.`cart_O_Price`) AS `total_O_price`,sum((`misawa2020`.`pos`.`paid_vendor` * `misawa2020`.`pos`.`cart_R_Price`)) AS `total_paid_vendor`,sum((`misawa2020`.`pos`.`paid_customer` * `misawa2020`.`pos`.`cart_B_Price`)) AS `total_paid_customer` from `misawa2020`.`pos` group by `misawa2020`.`pos`.`vendor_id`
