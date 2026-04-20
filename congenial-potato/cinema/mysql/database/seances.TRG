TYPE=TRIGGERS
triggers='CREATE DEFINER=`admin`@`%` TRIGGER `update_sales_seance` BEFORE DELETE ON `seances` FOR EACH ROW DELETE FROM `sales` WHERE `sale_seanceid`=OLD.`seance_id`'
sql_modes=1411383296
definers='admin@%'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='utf8mb4_general_ci'
created=163074736594
