CREATE DATABASE currencydb;

CREATE TABLE currency (
    id int NOT NULL AUTO_INCREMENT UNIQUE,
    name varchar(255) NOT NULL,
    code varchar(3) NOT NULL,
    middleRate decimal(8, 4) NOT NULL,
    date date NOT NULL,
    PRIMARY KEY (id)
);