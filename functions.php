<?php

require_once 'dbconnection.php';

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

function tarkistaYllapitaja($kayttajatunnus, $rooli, $db) {
    $query = $db->prepare("SELECT * FROM kayttaja WHERE kayttajatunnus = :kayttajatunnus AND rooli = :rooli");
    $query->bindParam(':kayttajatunnus', $kayttajatunnus);
    $query->bindParam(':rooli', $rooli);
    $query->execute();
    $result = $query->fetch();
    
    return $result ? true : false;
    }

function tarkistaKirjautuminen($username, $password, $db) {
    $stmt = $db->prepare("SELECT * FROM kayttaja WHERE kayttajatunnus = :username AND salasana = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
    return true;
    } else {
    return false;
    }
    }
