
CREATE TABLE `subscribers` (
    `id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
    `phone` VARCHAR( 20 ) NOT NULL ,
    `status` INT( 1 ) NOT NULL ,
    PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;