CREATE TABLE tuoteryhma (
  id INTEGER PRIMARY KEY,
  nimi TEXT NOT NULL
);

CREATE TABLE tuote (
  id INTEGER PRIMARY KEY,
  tuoteryhma_id INTEGER NOT NULL,
  nimi TEXT NOT NULL,
  hinta REAL NOT NULL,
  kuvaus TEXT,
  FOREIGN KEY (tuoteryhma_id) REFERENCES tuoteryhma(id)
);

CREATE TABLE tilaus (
  id INTEGER PRIMARY KEY,
  asiakas_id INTEGER NOT NULL,
  tilauspvm DATE NOT NULL,
  toimituspvm DATE,
  FOREIGN KEY (asiakas_id) REFERENCES asiakas(id)
);

CREATE TABLE tilausrivi (
  id INTEGER PRIMARY KEY,
  tilaus_id INTEGER NOT NULL,
  tuote_id INTEGER NOT NULL,
  maara INTEGER NOT NULL,
  hinta REAL NOT NULL,
  FOREIGN KEY (tilaus_id) REFERENCES tilaus(id),
  FOREIGN KEY (tuote_id) REFERENCES tuote(id)
);

CREATE TABLE asiakas (
  id INTEGER PRIMARY KEY,
  nimi TEXT NOT NULL,
  osoite TEXT NOT NULL,
  puhelin TEXT NOT NULL,
  email TEXT NOT NULL
);

CREATE TABLE kayttaja (
  id INTEGER PRIMARY KEY,
  nimi TEXT NOT NULL,
  kayttajatunnus TEXT NOT NULL,
  salasana TEXT NOT NULL,
  rooli TEXT NOT NULL
);

CREATE TABLE palaute (
  id INTEGER PRIMARY KEY,
  asiakas_id INTEGER NOT NULL,
  pvm DATE NOT NULL,
  teksti TEXT NOT NULL,
  FOREIGN KEY (asiakas_id) REFERENCES asiakas(id)
);
INSERT INTO asiakas (nimi, osoite, puhelin, email)
VALUES ('Minna Lohi', 'Kauppakatu 1', '045 123 4567', 'minna.lohi@esimerkki.fi');

INSERT INTO kayttaja (nimi, kayttajatunnus, salasana, rooli)
VALUES ('Minni Hiiri', 'minni', 'salasana123', 'peruskäyttäjä');

INSERT INTO kayttaja (nimi, kayttajatunnus, salasana, rooli)
VALUES ('Mikki Hiiri', 'mikki', 'salasana321', 'ylläpitäjä');

INSERT INTO palaute (asiakas_id, pvm, teksti)
VALUES (1, '2022-12-31', 'Asiakkaan esimerkkipalaute');

INSERT INTO tuoteryhma (nimi) VALUES ('Keramiikka');

INSERT INTO tuoteryhma (nimi) VALUES ('Tekstiilit');

INSERT INTO tuoteryhma (nimi) VALUES ('Huonekalut');

INSERT INTO tuoteryhma (nimi) VALUES ('Piensisustus');


INSERT INTO tuote (tuoteryhma_id, nimi, hinta, kuvaus)
VALUES (1, 'Marimekko-muki', 15.99, 'Värikäs Marimekko-muki, jossa on Unikko-kuosi.');

INSERT INTO tuote (tuoteryhma_id, nimi, hinta, kuvaus)
VALUES (1, 'Aalto-maljakko', 49.99, 'Muotoilun mestari Alvar Aallon suunnittelema Aalto-maljakko.');

INSERT INTO tuote (tuoteryhma_id, nimi, hinta, kuvaus)
VALUES (2, 'Artek-vahakangas', 29.99, 'Artek-brändin kestävä vahakangas.');

INSERT INTO tilaus (asiakas_id, tilauspvm, toimituspvm)
VALUES (1, '2022-12-31', '2023-01-02');

INSERT INTO tilausrivi (tilaus_id, tuote_id, maara, hinta)
VALUES (1, 1, 2, 15.99);

