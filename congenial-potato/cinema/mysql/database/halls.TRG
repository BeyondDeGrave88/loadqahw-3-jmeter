TYPE=TRIGGERS
triggers='CREATE DEFINER=`admin`@`%` TRIGGER `updateSales_updateHall` BEFORE UPDATE ON `halls` FOR EACH ROW if (NEW.`hall_config` <> OLD.`hall_config`) then\nDELETE FROM `sales` WHERE `sale_hallid`=OLD.`hall_id`;\nend if' 'CREATE DEFINER=`admin`@`%` TRIGGER `updateSeances_deleteHall` BEFORE DELETE ON `halls` FOR EACH ROW DELETE FROM `seances` WHERE `seance_hallid`=OLD.`hall_id`' 'CREATE DEFINER=`admin`@`%` TRIGGER `updateSales_deleteHall` AFTER DELETE ON `halls` FOR EACH ROW DELETE FROM `sales` WHERE `sale_hallid`=OLD.`hall_id`'
sql_modes=1411383296 1411383296 1411383296
definers='admin@%' 'admin@%' 'admin@%'
client_cs_names='utf8mb4' 'utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci' 'utf8mb4_general_ci'
db_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci' 'utf8mb4_general_ci'
created=163074733304 163074733307 163074733302
