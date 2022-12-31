<?php

// Tämä koodi on harjoituskoodia ja keskeneräistä... tästä olisi hyvä jatkaa ylläpito-osiota

// Tarkistetaan onko käyttäjä kirjautunut ylläpito-osiossa
if (isset($_SESSION['username']))

    // Tuoteryhmän lisäyslomakkeen lähetystiedot
    if (isset($_POST['lisaa_tuoteryhma'])) {
        $tuoteryhma_nimi = $_POST['tuoteryhma_nimi'];

        // Lisätään tuoteryhmä tietokantaan
        lisaaTuoteryhma($tuoteryhma_nimi, $db);
    }

// Tuoteryhmän poistolomakkeen lähetystiedot
if (isset($_POST['poista_tuoteryhma'])) {
    $tuoteryhma_id = $_POST['tuoteryhma_id'];

    // Poistetaan tuoteryhmä tietokannasta
    poistaTuoteryhma($tuoteryhma_id, $db);
}

// Tuoteryhmän päivityslomakkeen lähetystiedot
if (isset($_POST['update_category'])) {
    $tuoteryhma_id = $_POST['tuoteryhma_id'];
    $tuoteryhma_nimi = $_POST['tuoteryhma_nimi'];

    // Päivitetään tuoteryhmä tietokantaan
    paivitaTuoteryhma($tuoteryhma_id, $tuoteryhma_nimi, $db);
}
// Tuotteen lisäyslomakkeen lähetystiedot
if (isset($_POST['lisaa_tuote'])) {
    $tuote_nimi = $_POST['tuote_nimi'];
    $tuote_hinta = $_POST['tuote_hinta'];
    $tuote_tuoteryhma = $_POST['tuote_tuoteryhma'];

    // Lisätään tuote tietokantaan
    lisaaTuote($tuote_nimi, $tuote_hinta, $tuote_tuoteryhma, $db_conn);
}

// Lisätään tuoteryhmä tietokantaan
function lisaaTuoteryhma($nimi, $db_conn)
{
    $query = $db_conn->prepare("INSERT INTO tuoteryhma (nimi) VALUES (:nimi)");
    $query->execute(array(':nimi' => $nimi));
}

// Poistetaan tuoteryhmä tietokannasta
function poistaTuoteryhma($id, $db_conn)
{
    $query = $db_conn->prepare("DELETE FROM tuoteryhma WHERE id = :id");
    $query->execute(array(':id' => $id));
}

// Päivitetään tuoteryhmä tietokannassa
function paivitaTuoteryhma($id, $nimi, $db_conn)
{
    $query = $db_conn->prepare("UPDATE tuoteryhma SET nimi = :nimi WHERE id = :id");
    $query->execute(array(':id' => $id, ':nimi' => $nimi));
}

// Poistetaan tuote tietokannasta
function poistaTuote($id, $db_conn)
{
    $query = $db_conn->prepare("DELETE FROM tuote WHERE id = :id");
    $query->execute(array(':id' => $id));
}

// Päivitetään tuote tietokannassa
function paivitaTuote($id, $nimi, $hinta, $tuoteryhma, $db_conn)
{
    $query = $db_conn->prepare("UPDATE tuote SET nimi = :nimi, hinta = :hinta, tuoteryhma = :tuoteryhma WHERE id = :id");
    $query->execute(array(':id' => $id, ':nimi' => $nimi, ':hinta' => $hinta, ':tuoteryhma' => $tuoteryhma));
}
