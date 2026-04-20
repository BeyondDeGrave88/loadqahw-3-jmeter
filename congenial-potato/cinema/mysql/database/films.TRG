TYPE=TRIGGERS
triggers='CREATE DEFINER=`admin`@`%` TRIGGER `update_seances_film` BEFORE DELETE ON `films` FOR EACH ROW DELETE FROM `seances` WHERE `seance_filmid`=OLD.`film_id`'
sql_modes=1411383296
definers='admin@%'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='utf8mb4_general_ci'
created=163074227729
