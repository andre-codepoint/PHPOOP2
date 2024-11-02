DROP TABLE IF EXISTS `language`, `currency`, `currency_rate`, `customer`, `customer_telegram_auth`, `customer_auth`;
DROP TABLE IF EXISTS `account`, `account_inner_transaction`, `account_outer_transaction`;

CREATE TABLE IF NOT EXISTS `language`(
`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`code` CHAR(2) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `currency`(
`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`is_show` tinyint(1) NOT NULL DEFAULT 0,
`is_use` tinyint(1) NOT NULL DEFAULT 0,
`code` CHAR(3) NOT NULL,
`ccy` INT(11) NOT NULL,
`symbol` CHAR(1) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `currency_rate`(
`currency_base_id` INT(11),
`currency_quota_id` INT(11),
`rate` DECIMAL(63, 2)
)ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `customer`(
`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`firstname` VARCHAR(50) NOT NULL,
`lastname` VARCHAR(50) NOT NULL,
`username` VARCHAR(50) NOT NULL,
`chat_id` VARCHAR(50) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `customer_auth`(
`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`customer_id` INT(11) NOT NULL,
`date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`token` CHAR(50),
`date_expires` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `account`(
`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`customer_id` INT(11) NOT NULL,
`balance` DECIMAL(63, 2) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `account_inner_transaction`(
`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
`customer_id` INT(11) NOT NULL,
`whom_customer_id` INT(11) NOT NULL,
`is_crediting_funds` TINYINT(1) NOT NULL,
`amount` DECIMAL(63, 2) NOT NULL,
`balance_after` DECIMAL(63, 2) NOT NULL,
`balance_before` DECIMAL(63, 2) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `account_outer_transaction`(
`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
`customer_id` INT(11) NOT NULL,
`amount` DECIMAL(63, 2) NOT NULL,
`balance_after` DECIMAL(63, 2) NOT NULL,
`balance_before` DECIMAL(63, 2) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
