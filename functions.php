<?php

function openSQLite()
{
    $filename = filter_input(INPUT_POST, 'filename', FILTER_SANITIZE_SPECIAL_CHARS);
    $db = new PDO("sqlite:$filename");
}

function selectAsJson(object $db, string $sql): array
{
    $query = $db->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    header('HTTP/1.1 200 OK');
    return $results;
}


function returnError(PDOException $pdoex): void
{
    header('HTTP/1.1 500 Internal Server Error');
    $error = [
        'error' => $pdoex->getMessage(),
    ];
    echo json_encode($error);
    exit();
}


function tarkistaYllapitaja($username, $db_conn)
{
    // Tarkistetaan, onko käyttäjä ylläpitäjä
    $query = $db_conn->prepare("SELECT * FROM kayttaja WHERE kayttajatunnus = :username AND rooli = 'ylläpitäjä'");
    $query->bindParam(':kayttajatunnus', $username);
    $query->execute();
    $result = $query->fetch();

    if ($result) {
        // Käyttäjä on ylläpitäjä
        return true;
    } else {
        // Käyttäjä ei ole ylläpitäjä
        return false;
    }
}

function tarkistaKirjautuminen($username, $password, $db)
{
    // Tarkistetaan, onko käyttäjätunnus ja salasana oikein
    $query = $db->prepare("SELECT * FROM kayttaja WHERE kayttajatunnus = :username AND salasana = :password");
    $query->bindParam(':username', $username);
    $query->bindParam(':salasana', $password);
    $query->execute();
    $result = $query->fetch();

    // Palautetaan true, jos käyttäjätunnus ja salasana ovat oikein, muuten false
    return $result ? true : false;
}
