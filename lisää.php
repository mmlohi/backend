<?php
require('functions.php');

$db = createSqliteConnection("designtuotteet.db");

// lisätty uusi tuoteryhmä
$command = "INSERT INTO tuoteryhma (nimi) VALUES ('Valaisimet')";

$db->exec($command);

$id = $db->lastInsertId();

//edellisen id:n perusteella lisätty tuoteryhmään uusi tuote

$command = "INSERT INTO tuote (tuoteryhma_id, nimi, hinta, kuvaus)
VALUES (7, 'Lokki-valaisin', 199.99, 'Tämä tuote on valmistettu kotimaisesta designista inspiraationsa saaneena.')";

$db->exec($command); 

//asiakastauluun lisätty uusi asiakas

$command = "INSERT INTO asiakas (nimi, osoite, puhelin, email)
VALUES ('Joose Lohi', 'Rallikatu 1', '044 234 5678', 'joose.lohi@esimerkki.fi')";

$db->exec($command);


