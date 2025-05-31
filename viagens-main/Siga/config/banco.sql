create database viagem;
use viagem;

CREATE TABLE viagem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    destino VARCHAR(100) NOT NULL,
    data_ida DATE NOT NULL,
    data_volta DATE NOT NULL,
    motivo TEXT NOT NULL,
    documento VARCHAR(255)
);


select * from viagem;
-- script de criação do banco de dados