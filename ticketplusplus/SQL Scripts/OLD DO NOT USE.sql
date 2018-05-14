CREATE DATABASE ticketplusplus;

CREATE TABLE ticketplusplus.users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password CHAR(128) NOT NULL,
    salt CHAR(128) NOT NULL, 
	role VARCHAR(30) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE ticketplusplus.login_attempts (
    user_id INT(11) NOT NULL,
    time VARCHAR(30) NOT NULL
) ENGINE=InnoDB;

INSERT INTO ticketplusplus.users VALUES(1, 'Admin', 'admin@ticketplusplus.de',
'bffb9458952cda19dfa56f4b2fed240448d5a9410f3956977bfd9d7e48b56406d307f6395d56a286d34d30070aeffcc6068881162b9e7252b9ccfe32407b7171',
'918ef7c1c76a3d7c44c6a48ed766e30aa63e2f15ed423beb27d70380abb969e4b0e311aac6348c653bcc637951e482faf137516d329dc0101a5b73b5807f1cd6', 'Administrator');