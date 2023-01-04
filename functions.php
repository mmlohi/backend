<?php



function createSqliteConnection($filename){
    try{
        $db = new PDO("sqlite:" .$filename);
        return $db;
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    return null;
}


// Lisätään tuote tietokantaan
function lisaaTuote($tuoteryhma_id, $nimi, $hinta, $kuvaus, $db)
{
  $query = $db->prepare("INSERT INTO tuote (tuoteryhma_id,nimi, hinta,  kuvaus) VALUES (:tuoteryhma_id,:nimi, :hinta, :kuvaus)");
  $query->execute(array(':tuoteryhma_id' => $tuoteryhma_id, ':nimi' => $nimi, ':hinta' => $hinta, ':kuvaus'=> $kuvaus));
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

// Lisätään tuoteryhma tietokantaan
function lisaaTuoteryhma($nimi,$db)
{
  $query = $db->prepare("INSERT INTO tuoteryhma (nimi) VALUES (:nimi)");
  $query->execute(array(':nimi' => $nimi));
}
