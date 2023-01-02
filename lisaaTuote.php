<?php

session_start();
require('dbconnection.php');
require_once 'functions.php';

$db = createSqliteConnection("designtuotteet.db");


// Tarkistetaan onko lomakkeen lähetyspainike painettu
if (isset($_POST['lisaa_tuote'])) {

  // Sanitoidaan käyttäjän syöttämät tiedot
  $tuoteryhma_id = filter_input(INPUT_POST, 'tuote_tuoteryhma_id', FILTER_SANITIZE_NUMBER_INT);
  $nimi = filter_input(INPUT_POST, 'tuote_nimi', FILTER_SANITIZE_SPECIAL_CHARS);
  $hinta = filter_input(INPUT_POST, 'tuote_hinta', FILTER_SANITIZE_NUMBER_INT);
  $kuvaus = filter_input(INPUT_POST, 'tuote_kuvaus', FILTER_SANITIZE_SPECIAL_CHARS);

  // Tarkistetaan, että kaikki tarvittavat tiedot on syötetty
  if (!empty($tuoteryhma_id)&& !empty($nimi) && !empty($hinta)&& !empty($kuvaus)) {
    try {
      lisaaTuote($tuoteryhma_id, $nimi, $hinta, $kuvaus,$db );
      echo "Tuote lisätty onnistuneesti!";
    } catch (PDOException $e) {
      echo "Virhe tuotetta lisättäessä: " . $e->getMessage();
    }
  }
}

// Lisätään tuote tietokantaan
function lisaaTuote($tuoteryhma_id, $nimi, $hinta, $kuvaus, $db)
{
  $query = $db->prepare("INSERT INTO tuote (tuoteryhma_id,nimi, hinta,  kuvaus) VALUES (:tuoteryhma_id,:nimi, :hinta, :kuvaus)");
  $query->execute(array(':tuoteryhma_id' => $tuoteryhma_id, ':nimi' => $nimi, ':hinta' => $hinta, ':kuvaus'=> $kuvaus));
}

?>

<!-- Tuotteen lisäyslomake -->
<form action="" method="post">
  <h3>Lisää tuote:</h3>
<label for="tuote_tuoteryhma_id">Tuoteryhmä:</label><br>
<select name="tuote_tuoteryhma_id">
    <option value="1">Keramiikka</option>
    <option value="2">Tekstiilit</option>
    <option value="3">Huonekalut</option>
    <option value="4">Piensisustus</option>
    <option value="5">Taide</option>    
  </select><br>
  <label for="tuote_nimi">Tuotteen nimi:</label><br>
  <input type="text" name="tuote_nimi"><br>
  <label for="tuote_hinta">Tuotteen hinta:</label><br>
  <input type="text" name="tuote_hinta"><br>
  <label for="tuote_kuvaus">Kuvaus:</label><br>
  <input type="textarea" name="tuote_kuvaus"><br><br>
  <input type="submit" name="lisaa_tuote" value="Lisää tuote">