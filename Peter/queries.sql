CREATE TABLE ` d6_crud_login`.`user` (`id` INT NOT NULL AUTO_INCREMENT , `first_Name` VARCHAR(255) NOT NULL , `last_Name` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , `date_of_birth` DATE NOT NULL , `email` VARCHAR(255) NOT NULL , `picture` VARCHAR(255) NULL DEFAULT NULL , `status` VARCHAR(4) NOT NULL DEFAULT 'user' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE ` d6_crud_login`.`hotel` (`hotel_id` INT NOT NULL AUTO_INCREMENT , `hotel_name` VARCHAR(255) NOT NULL , `hotel_email` VARCHAR(255) NOT NULL , `hotel_website` VARCHAR(255) NOT NULL , PRIMARY KEY (`hotel_id`)) ENGINE = InnoDB;
CREATE TABLE ` d6_crud_login`.`booking` (`booking_id` INT NOT NULL AUTO_INCREMENT , `fk_userid` INT NULL , PRIMARY KEY (`booking_id`)) ENGINE = InnoDB;
ALTER TABLE booking ADD CONSTRAINT fk_userid FOREIGN KEY(fk_userid) REFERENCES user(id); 