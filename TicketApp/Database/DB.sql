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
    Immagine                 VARCHAR(1000),
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

INSERT INTO Eventi (Descrizione, Data, Prezzo, Numero_Posti, Numero_Posti_Disponibili, Categoria, Luogo,Immagine)
VALUES ('Concerto degli Imagine Dragons', '2024-05-10 19:00:00', 45.00, 800, 800, 1, 6,'https://c4.wallpaperflare.com/wallpaper/93/241/103/imagine-dragons-wallpaper-preview.jpg'),
       ('Partita di Serie A: Milan vs Juventus', '2024-05-12 18:00:00', 40.00, 40000, 40000, 2, 7,'https://napolimagazine.blob.core.windows.net/locandine/0/mila%20juv.png'),
       ('Proiezione del film "La Dolce Vita"', '2024-06-05 18:30:00', 15.00, 250, 250, 3, 8,'https://cdn.britannica.com/23/90623-050-8F88AABA/Marcello-Mastroianni-Anita-Ekberg-Federico-Fellini-La.jpg'),
       ('Concerto di Jovanotti', '2024-06-20 20:00:00', 50.00, 1200, 1200, 1, 11,'https://www.ticketone.it/obj/media/IT-eventim/galery/kuenstler/j/jova_2021_barletta.jpg'),
       ('Torneo di Tennis Amatoriale', '2024-07-25 10:00:00', 10.00, 100, 100, 2, 41,'https://storage.ilbiellese.it/media/photologue/2023/10/31/photos/cache/tennis-i-primi-risultati-del-5-torneo-internazionale-citta_V4wjUpk_v3_large_libera.webp'),
       ('Spettacolo teatrale "La Serva Padrona"', '2024-05-15 21:00:00', 25.00, 600, 600, 3, 1,'https://www.pierachilledolfini.it/wp-content/uploads/2018/08/servapadrona-800x500.jpg'),
       ('Partita di Rugby: Italia vs Inghilterra', '2024-06-20 18:00:00', 35.00, 60000, 60000, 2, 25,'https://www.ilpost.it/wp-content/uploads/2019/03/inghilterra-italia-sei-nazioni-tv-680x340.png'),
       ('Partita di Basket: Olimpia Milano vs Virtus Bologna', '2024-08-15 20:30:00', 25.00, 15000, 15000, 2, 10,'https://images.daznservices.com/di/library/DAZN_News/57/18/olimpia-milano-virtus-bologna_6qkqjmfv2wfl1ww3mttqdkjtp.jpg'),
       ('Concerto Jazz al tramonto', '2024-08-20 18:00:00', 20.00, 300, 300, 1, 3,'https://www.passionesicilia.it/wp-content/uploads/2020/02/Sicilia-Jazz-Festival.jpg'),
       ('Opera all\'aperto: La Traviata', '2024-08-10 21:00:00', 30.00, 1000, 1000, 3, 5,'https://cdn-imgix.headout.com/media/images/00a57d9289bf5fa945749c75fada76f8-23867-London-LaTraviata-01.jpg'),
       ('Partita di Calcio: AS Roma vs Lazio', '2024-08-15 20:00:00', 40.00, 70000, 70000, 2, 25,'https://siulp.it/wp-content/risorse/2024/04/Roma-Lazio.png'),
       ('Festival del Cinema Internazionale', '2024-08-20 14:00:00', 15.00, 2000, 2000, 3, 2,'https://secondotempo.cattolicanews.it/news-venezia80_seo.jpg'),
       ('Concerto di Vasco Rossi', '2024-08-10 21:30:00', 50.00, 1500, 1500, 1, 13,'https://blog.ticketmaster.it/wp-content/uploads/2022/11/Vasco-Rossi-02.jpg'),
       ('Partita di Tennis: Finale Internazionale', '2024-08-15 15:00:00', 30.00, 5000, 5000, 2, 41,'https://img.olympics.com/images/image/private/t_s_16_9_g_auto/t_s_w960/f_auto/primary/s7szr6txhhotvuai20hp'),
       ('Concerto Sinfonico all\'aperto', '2024-08-10 20:00:00', 25.00, 800, 800, 1, 20,'https://citynews-trevisotoday.stgy.ovh/~media/horizontal-mid/9279677243566/concerto-6-luglio-2019-3.jpg'),
       ('Partita di Pallacanestro: Pallacanestro Varese vs Pallacanestro Milano', '2024-09-10 19:30:00', 20.00, 5000, 5000, 2, 10,'https://images.daznservices.com/di/library/DAZN_News/bd/3e/diretta-basket-varese-milano-dazn-streaming_kpetdkd5hwqi10auyt3qywc9u.png'),
       ('Concerto di Jazz Fusion', '2024-09-15 21:00:00', 30.00, 400, 400, 1, 3,'https://citynews-ravennatoday.stgy.ovh/~media/original-hi/8991369477598/rodney-holmes.jpeg'),
       ('Festival Internazionale del Film', '2024-09-05 14:00:00', 15.00, 2000, 2000, 3, 2,'https://www.rai.it/resizegd/-x540/dl/img/2019/01/29/1548767704355_festival-di-berlino.jpg'),
       ('Partita di Rugby: Italia vs Francia', '2024-09-10 17:00:00', 35.00, 60000, 60000, 2, 25,'https://www.ilpost.it/wp-content/uploads/2019/03/italia-francia-rugby.png'),
       ('Partita di Calcio: SSC Napoli vs AS Roma', '2024-09-10 20:00:00', 45.00, 60000, 60000, 2, 39,'https://napolipiu.com/wp-content/uploads/2023/01/napoli-roma-dazn.png'),
       ('Concerto di Laura Pausini', '2024-09-15 20:00:00', 50.00, 1500, 1500, 1, 13,'https://www.sorrisi.com/wp-content/uploads/2023/07/LPausini_VBettojaVBE_7900-886x494.jpg'),
       ('Partita di Calcio: Bologna vs Udinese', '2024-09-10 18:00:00', 25.00, 8000, 8000, 2, 45,'https://www.sportpress24.com/wp-content/uploads/2023/12/Udinese-Bologna.png'),
       ('Concerto Rock', '2024-09-15 19:30:00', 35.00, 700, 700, 1, 42,'https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
       ('Concerto di Adele', '2024-09-20 20:00:00', 60.00, 1500, 1500, 1, 7,'https://thesoundcheck.it/wp-content/uploads/2024/02/adele.jpg'),
       ('Spettacolo teatrale "La grande commedia italiana"', '2024-09-25 18:00:00', 30.00, 800, 800, 3, 33,'https://www.cinemagazine.org/wp-content/uploads/2019/12/alberto-sordi-foto.jpg'),
       ('Concerto di Laura Pausini', '2024-09-27 21:00:00', 50.00, 3000, 3000, 1, 28,'https://www.sorrisi.com/wp-content/uploads/2023/07/LPausini_VBettojaVBE_7900-886x494.jpg'),
       ('Partita di Calcio: SSC Napoli vs Frosinone Calcio', '2024-09-30 20:45:00', 40.00, 60000, 60000, 2, 39,'https://www.stadiosport.it/wp-content/uploads/2024/04/napoli_frosinone.png'),
       ('Musical "Il Fantasma dell\'Opera"', '2024-10-02 19:30:00', 35.00, 1200, 1200, 3, 38,'https://media.tacdn.com/media/attractions-splice-spp-674x446/06/70/fb/a7.jpg');