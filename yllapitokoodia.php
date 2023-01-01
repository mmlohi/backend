<?php

// Tämä koodi on harjoituskoodia ja keskeneräistä... tästä olisi hyvä jatkaa lisäämällä toimintoja ylläpito-osioon


// Poistetaan tuoteryhmä tietokannasta
function poistaTuoteryhma($id, $db_conn)
{
    $query = $db_conn->prepare("DELETE FROM tuoteryhma WHERE id = :id");
    $query->execute(array(':id' => $id));
}

// Poistetaan tuote tietokannasta
function poistaTuote($id, $db_conn)
{
    $query = $db_conn->prepare("DELETE FROM tuote WHERE id = :id");
    $query->execute(array(':id' => $id));
}

