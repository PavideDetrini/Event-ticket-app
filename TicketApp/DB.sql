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

INSERT INTO CategoriaEventi (Descrizione_Categoria)
VALUES ('Concerti'),
       ('Sport'),
       ('Teatro e Cinema');

INSERT INTO Luoghi (Città, Nome)
VALUES ('Milano', 'Teatro alla Scala'),
       ('Milano', 'Mediolanum Forum'),
       ('Milano', 'Teatro degli Arcimboldi'),
       ('Milano', 'Fabrique'),
       ('Milano', 'Alcatraz'),
       ('Milano', 'Teatro Dal Verme'),
       ('Milano', 'Circolo Magnolia'),
       ('Milano', 'Stadio San Siro'),
       ('Milano', 'Cinema Anteo'),
       ('Verona', 'Arena di Verona'),
       ('Verona', 'Stadio Marcantonio Bentegodi'),
       ('Taormina', 'Teatro Antico di Taormina'),
       ('Torino', 'Pala Alpitour'),
       ('Torino', 'Teatro Colosseo'),
       ('Torino', 'Stadio Olimpico Grande Torino'),
       ('Torino', 'Allianz Stadium'),
       ('Torino', 'Cinema Massimo'),
       ('Fiesole', 'Teatro Romano di Fiesole'),
       ('Firenze', 'Stadio Artemio Franchi'),
       ('Firenza', 'Cinema Odeon'),
       ('Siracusa', 'Teatro Greco di Siracusa'),
       ('Roma', 'Auditorium Parco della Musica'),
       ('Roma', 'Stadio Olimpico'),
       ('Roma', 'Teatro dell''Opera di Roma'),
       ('Roma', 'Villa Ada'),
       ('Roma', 'Circo Massimo'),
       ('Roma', 'Cinema Adriano'),
       ('Roma', 'Cinema Barberini'),
       ('Roma', 'Cinema Quattro Fontane'),
       ('Palermo', 'Teatro Massimo'),
       ('Palermo', 'Teatro Politeama Garibaldi'),
       ('Napoli', 'Teatro di San Carlo'),
       ('Napoli', 'Arena Flegrea'),
       ('Napoli', 'Teatro Augusteo'),
       ('Napoli', 'Palapartenope'),
       ('Napoli', 'Stadio Diego Armando Maradona'),
       ('Napoli', 'Cinema Centrale'),
       ('Bologna', 'Unipol Arena'),
       ('Bologna', 'Teatro Duse'),
       ('Bologna', 'Arena del Sole'),
       ('Bologna', 'Stadio Renato Dall''Ara'),
       ('Bologna', 'Cinema Ambasciatori'),
       ('Bergamo', 'Gewiss Stadium'),
       ('Cagliari', 'Sardegna Arena'),
       ('Empoli', 'Stadio Carlo Castellani'),
       ('Frosinone', 'Stadio Benito Stirpe'),
       ('Genova', 'Stadio Luigi Ferraris'),
       ('Lecce', 'Stadio Via del Mare'),
       ('Monza', 'Stadio Brianteo'),
       ('Salerno', 'Stadio Arechi'),
       ('Sassuolo', 'Mapei Stadium - Città del Tricolore'),
       ('Udine', 'Dacia Arena'),
       ('Brescia', 'Cinema Capitol'),
       ('Reggio Emilia', 'Cinema Ariosto');