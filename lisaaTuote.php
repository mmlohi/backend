<?php

session_start();
require('dbconnection.php');
require_once 'functions.php';

$db = createSqliteConnection("designtuotteet.db");


// Tarkistetaan onko lomakkeen lähetyspainike painettu
if (isset($_POST['lisaa_tuote'])) {

  // Sanitoidaan käyttäjän syöttämät tiedot
  $nimi = filter_input(INPUT_POST, 'tuote_nimi', FILTER_UNSAFE_RAW);
  $hinta = filter_input(INPUT_POST, 'tuote_hinta', FILTER_SANITIZE_NUMBER_INT);
  $tuoteryhma_id = filter_input(INPUT_POST, 'tuote_tuoteryhma_id', FILTER_SANITIZE_NUMBER_INT);
  $kuvaus = filter_input(INPUT_POST, 'tuote_hinta', FILTER_UNSAFE_RAW);

  // Tarkistetaan, että kaikki tarvittavat tiedot on syötetty
  if (!empty($nimi) && !empty($hinta) && !empty($tuoteryhma_id)&& !empty($kuvaus)) {
    try {
      lisaaTuote($nimi, $hinta, $tuoteryhma_id, $kuvaus,$db );
      echo "Tuote lisätty onnistuneesti!";
    } catch (PDOException $e) {
      echo "Virhe tuotetta lisättäessä: " . $e->getMessage();
    }
  }
}

// Lisätään tuote tietokantaan
function lisaaTuote($nimi, $hinta, $tuoteryhma_id,$kuvaus, $db)
{
  $query = $db->prepare("INSERT INTO tuote (nimi, hinta, tuoteryhma_id, kuvaus) VALUES (:nimi, :hinta, :tuoteryhma_id, :kuvaus)");
  $query->execute(array(':nimi' => $nimi, ':hinta' => $hinta, ':tuoteryhma_id' => $tuoteryhma_id, ':kuvaus'=> $kuvaus));
}

?>

<!-- Tuotteen lisäyslomake -->
<form action="" method="post">
  <label for="tuote_nimi">Tuotteen nimi:</label><br>
  <input type="text" name="tuote_nimi"><br>
  <label for="tuote_hinta">Tuotteen hinta:</label><br>
  <input type="text" name="tuote_hinta"><br>
  <label for="tuote_tuoteryhma_id">Tuoteryhmä:</label><br>
  <select name="tuote_tuoteryhma_id">
    <option value="1">Keramiikka</option>
    <option value="2">Tekstiilit</option>
    <option value="3">Huonekalut</option>
    <option value="4">Piensisustus</option>
    <option value="5">Taide</option>    
  </select><br>
  <label for="tuote_kuvaus">Kuvaus:</label><br>
  <input type="textarea" name="tuote_kuvaus"><br><br>
  <input type="submit" name="lisaa_tuote" value="Lisää tuote">