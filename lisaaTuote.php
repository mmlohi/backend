<?php

$filename = "designtuotteet.db";
$db = new PDO("sqlite:$filename");

// Tarkistetaan onko käyttäjä kirjautunut ylläpito-osiossa
if (isset($_SESSION['username'])) {

// Tarkistetaan onko lomakkeen lähetyspainike painettu
if (isset($_POST['lisaa_tuote'])) {

  // Sanitoidaan käyttäjän syöttämät tiedot
  $nimi = filter_input(INPUT_POST, 'tuote_nimi', FILTER_UNSAFE_RAW);
  $hinta = filter_input(INPUT_POST, 'tuote_hinta', FILTER_SANITIZE_NUMBER_INT);
  $tuoteryhma_id = filter_input(INPUT_POST, 'tuote_tuoteryhma_id', FILTER_SANITIZE_NUMBER_INT);

  // Tarkistetaan, että kaikki tarvittavat tiedot on syötetty
  if (!empty($nimi) && !empty($hinta) && !empty($tuoteryhma_id)) {
    try {
      lisaaTuote($nimi, $hinta, $tuoteryhma_id, $db);
      echo "Tuote lisätty onnistuneesti!";
    } catch (PDOException $e) {
      echo "Virhe tuotetta lisättäessä: " . $e->getMessage();
    }
  }
}

// Lisätään tuote tietokantaan
function lisaaTuote($nimi, $hinta, $tuoteryhma_id, $db)
{
  $query = $db->prepare("INSERT INTO tuote (nimi, hinta, tuoteryhma_id) VALUES (:nimi, :hinta, :tuoteryhma_id)");
  $query->execute(array(':nimi' => $nimi, ':hinta' => $hinta, ':tuoteryhma_id' => $tuoteryhma_id));
}
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
  </select><br><br>
  <input type="submit" name="lisaa_tuote" value="Lisää tuote">