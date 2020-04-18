CREATE DATABASE currencydb;

CREATE TABLE currency (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    currencyID varchar(6) NOT NULL,
    numCode int NOT NULL,
    currencyCode varchar(3) NOT NULL,
    name varchar(255) NOT NULL,
    value decimal(8, 4) NOT NULL,
    date date NOT NULL,
    PRIMARY KEY (id)
);