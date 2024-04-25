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
    Email     VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE Eventi
(
    ID_Evento                INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Descrizione              VARCHAR(255) NOT NULL,
    Data                     DATETIME     NOT NULL,
    Prezzo                   DOUBLE       NOT NULL CHECK (Prezzo > 0),
    Numero_Posti             INTEGER      NOT NULL CHECK (Numero_Posti >= 0),
    Numero_Posti_Disponibili INTEGER      NOT NULL CHECK (Numero_Posti_Disponibili >= 0),
    Categoria                INTEGER UNSIGNED,
    Luogo                    INTEGER UNSIGNED,
    FOREIGN KEY (Categoria) REFERENCES CategoriaEventi (ID_Categoria)
        ON UPDATE CASCADE,
    FOREIGN KEY (Luogo) REFERENCES Luoghi (ID_Luogo)
        ON UPDATE CASCADE,
    CONSTRAINT check_posti_disponibili CHECK (Numero_Posti_Disponibili <= Numero_Posti)
);

CREATE TABLE Biglietti
(
    ID_Biglietto INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Utente       INT(11) UNSIGNED,
    Evento       INT(11) UNSIGNED,
    FOREIGN KEY (Utente) REFERENCES Utenti (ID_Utente),
    FOREIGN KEY (Evento) REFERENCES Eventi (ID_Evento)
);

CREATE TABLE Supporto
(
    ID        INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Nome      VARCHAR(255) NOT NULL,
    Cognome   VARCHAR(255) NOT NULL,
    Email     VARCHAR(255) NOT NULL,
    Messaggio VARCHAR(255) NOT NULL,
    Utente    INT(11) UNSIGNED,
    FOREIGN KEY (Utente) REFERENCES Utenti (ID_Utente)
);

INSERT INTO CategoriaEventi (Descrizione_Categoria)
VALUES ('Concerti'),
       ('Sport'),
       ('Teatro e Cinema');

INSERT INTO Luoghi (Città, Nome)
VALUES ('Milano', 'Teatro alla Scala'),
       ('Milano', 'Teatro degli Arcimboldi'),
       ('Milano', 'Fabrique'),
       ('Milano', 'Alcatraz'),
       ('Milano', 'Teatro Dal Verme'),
       ('Milano', 'Circolo Magnolia'),
       ('Milano', 'Stadio San Siro'),
       ('Milano', 'Cinema Anteo'),
       ('Milano', 'Tennis Club Milano'),
       ('Assago', 'Mediolanum Forum'),
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
       ('Firenze', 'Tennis Club Firenze'),
       ('Siracusa', 'Teatro Greco di Siracusa'),
       ('Roma', 'Auditorium Parco della Musica'),
       ('Roma', 'Stadio Olimpico'),
       ('Roma', 'Teatro dell''Opera di Roma'),
       ('Roma', 'Villa Ada'),
       ('Roma', 'Circo Massimo'),
       ('Roma', 'Cinema Adriano'),
       ('Roma', 'Cinema Barberini'),
       ('Roma', 'Cinema Quattro Fontane'),
       ('Roma', 'Foro Italico'),
       ('Palermo', 'Teatro Massimo'),
       ('Palermo', 'Teatro Politeama Garibaldi'),
       ('Napoli', 'Teatro di San Carlo'),
       ('Napoli', 'Arena Flegrea'),
       ('Napoli', 'Teatro Augusteo'),
       ('Napoli', 'Palapartenope'),
       ('Napoli', 'Stadio Diego Armando Maradona'),
       ('Napoli', 'Cinema Centrale'),
       ('Napoli', 'Circolo Tennis Napoli'),
       ('Bologna', 'Unipol Arena'),
       ('Bologna', 'Teatro Duse'),
       ('Bologna', 'Arena del Sole'),
       ('Bologna', 'Stadio Renato Dall''Ara'),
       ('Bologna', 'Cinema Ambasciatori'),
       ('Bologna', 'Tennis Club Bologna'),
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

INSERT INTO Eventi (Descrizione, Data, Prezzo, Numero_Posti, Numero_Posti_Disponibili, Categoria, Luogo)
VALUES ('Concerto degli Imagine Dragons', '2024-05-10 19:00:00', 45.00, 800, 800, 1, 6),
       ('Partita di Serie A: Milan vs Juventus', '2024-05-12 18:00:00', 40.00, 40000, 40000, 2, 7),
       ('Proiezione del film "La Dolce Vita"', '2024-06-05 18:30:00', 15.00, 250, 250, 3, 8),
       ('Concerto di Jovanotti', '2024-06-20 20:00:00', 50.00, 1200, 1200, 1, 11),
       ('Torneo di Tennis Amatoriale', '2024-07-25 10:00:00', 10.00, 100, 100, 2, 41),
       ('Spettacolo teatrale "La Serva Padrona"', '2024-05-15 21:00:00', 25.00, 600, 600, 3, 1),
       ('Partita di Rugby: Italia vs Inghilterra', '2024-06-20 18:00:00', 35.00, 60000, 60000, 2, 25),
       ('Partita di Basket: Olimpia Milano vs Virtus Bologna', '2024-08-15 20:30:00', 25.00, 15000, 15000, 2, 10),
       ('Concerto Jazz al tramonto', '2024-08-20 18:00:00', 20.00, 300, 300, 1, 3),
       ('Opera all\'aperto: La Traviata', '2024-08-10 21:00:00', 30.00, 1000, 1000, 3, 5),
       ('Partita di Calcio: AS Roma vs Lazio', '2024-08-15 20:00:00', 40.00, 70000, 70000, 2, 25),
       ('Festival del Cinema Internazionale', '2024-08-20 14:00:00', 15.00, 2000, 2000, 3, 2),
       ('Concerto di Vasco Rossi', '2024-08-10 21:30:00', 50.00, 1500, 1500, 1, 13),
       ('Partita di Tennis: Finale Internazionale', '2024-08-15 15:00:00', 30.00, 5000, 5000, 2, 41),
       ('Concerto Sinfonico all\'aperto', '2024-08-10 20:00:00', 25.00, 800, 800, 1, 20),
       ('Partita di Pallacanestro: Pallacanestro Varese vs Pallacanestro Milano', '2024-09-10 19:30:00', 20.00, 5000, 5000, 2, 10),
       ('Concerto di Jazz Fusion', '2024-09-15 21:00:00', 30.00, 400, 400, 1, 3),
       ('Festival Internazionale del Film', '2024-09-05 14:00:00', 15.00, 2000, 2000, 3, 2),
       ('Partita di Rugby: Italia vs Francia', '2024-09-10 17:00:00', 35.00, 60000, 60000, 2, 25),
       ('Partita di Calcio: SSC Napoli vs AS Roma', '2024-09-10 20:00:00', 45.00, 60000, 60000, 2, 39),
       ('Concerto di Laura Pausini', '2024-09-15 20:00:00', 50.00, 1500, 1500, 1, 13),
       ('Partita di Calcio: Italia vs Russia', '2024-09-10 18:00:00', 25.00, 8000, 8000, 2, 50),
       ('Concerto Rock', '2024-09-15 19:30:00', 35.00, 700, 700, 1, 42),
       ('Concerto di Adele', '2024-09-20 20:00:00', 60.00, 1500, 1500, 1, 7),
       ('Spettacolo teatrale "La grande commedia italiana"', '2024-09-25 18:00:00', 30.00, 800, 800, 3, 33),
       ('Concerto di Laura Pausini', '2024-09-27 21:00:00', 50.00, 3000, 3000, 1, 28),
       ('Partita di Calcio: SSC Napoli vs Frosinone Calcio', '2024-09-30 20:45:00', 40.00, 60000, 60000, 2, 39),
       ('Musical "Il Fantasma dell\'Opera"', '2024-10-02 19:30:00', 35.00, 1200, 1200, 3, 38);