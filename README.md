/*

CREATE TABLE `dengue` (
    `id` int(11) NOT NULL AUTO_INCREMENT, 
    `username` varchar(50) NOT NULL, 
    `lng` decimal(10,7) NOT NULL, `
    lat` decimal(10,7) NOT NULL, 
    `datetime_created` DATETIME DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (`id`) 
);

dengue.dengue
+------------------+---------------+------+-----+-------------------+----------------+
| Field            | Type          | Null | Key | Default           | Extra          |
+------------------+---------------+------+-----+-------------------+----------------+
| id               | int(11)       | NO   | PRI | NULL              | auto_increment |
| username         | varchar(50)   | NO   |     | NULL              |                |
| lng              | decimal(10,7) | NO   |     | NULL              |                |
| lat              | decimal(10,7) | NO   |     | NULL              |                |
| datetime_created | datetime      | YES  |     | CURRENT_TIMESTAMP |                |
+------------------+---------------+------+-----+-------------------+----------------+
*/