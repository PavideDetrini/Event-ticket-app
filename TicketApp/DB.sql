DROP DATABASE eventi;

CREATE DATABASE IF NOT EXISTS eventi;
USE eventi;

CREATE TABLE CategoriaEventi
(
    ID_Categoria          INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Descrizione_Categoria VARCHAR(20) NOT NULL
);

CREATE TABLE Luoghi
(
    ID_Luogo INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Città    VARCHAR(255) NOT NULL,
    Nome     VARCHAR(255) NOT NULL
);

CREATE TABLE Utenti
(
    ID_Utente INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Username  VARCHAR(255) NOT NULL UNIQUE,
    Password  VARCHAR(255) NOT NULL,
    Nome      VARCHAR(255) NOT NULL,
    Cognome   VARCHAR(255) NOT NULL,
    Email     VARCHAR(255) NOT NULL
);

CREATE TABLE Eventi
(
    ID_Evento    INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Descrizione  VARCHAR(255) NOT NULL,
    Data         DATETIME     NOT NULL,
    Prezzo       DOUBLE       NOT NULL CHECK (Prezzo > 0),
    Numero_Posti INTEGER      NOT NULL CHECK (Numero_Posti > 0),
    Categoria    INTEGER UNSIGNED,
    Luogo        INTEGER UNSIGNED,
    FOREIGN KEY (Categoria) REFERENCES CategoriaEventi (ID_Categoria)
        ON UPDATE CASCADE,
    FOREIGN KEY (Luogo) REFERENCES Luoghi (ID_Luogo)
        ON UPDATE CASCADE
);

CREATE TABLE Biglietti
(
    ID_Biglietto INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Utente       INT(11) UNSIGNED,
    Evento       INT(11) UNSIGNED,
    FOREIGN KEY (Utente) REFERENCES Utenti (ID_Utente),
    FOREIGN KEY (Evento) REFERENCES Eventi (ID_Evento)
);