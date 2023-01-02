<?php

session_start();
require('dbconnection.php');
require_once 'functions.php';

$db = createSqliteConnection("designtuotteet.db");


// Tarkistetaan onko lomakkeen lähetyspainike painettu
if (isset($_POST['lisaa_tuoteryhma'])) {

  // Sanitoidaan käyttäjän syöttämät tiedot
  $nimi = filter_input(INPUT_POST, 'tuoteryhma_nimi', FILTER_SANITIZE_SPECIAL_CHARS);

  // Tarkistetaan, että tarvittava tieto on syötetty
  if (!empty($nimi)) {
    
    // Lisätään tuoteryhmä tietokantaan
    try {
      lisaaTuoteryhma($nimi,$db);
      echo "Tuoteryhmä lisätty onnistuneesti!";

    } catch (PDOException $e) {
      echo "Virhe tuoteryhmää lisättäessä: " . $e->getMessage();
    }
  } else {
    echo "Anna tuoteryhmälle nimi.";
  }
}
// Lisätään tuoteryhma tietokantaan
function lisaaTuoteryhma($nimi,$db)
{
  $query = $db->prepare("INSERT INTO tuoteryhma (nimi) VALUES (:nimi)");
  $query->execute(array(':nimi' => $nimi));
}
?>
<!-- Tuoteryhmän lisäyslomake -->
<form action="" method="post">
  <label for="tuoteryhma_nimi">Tuoteryhmän nimi:</label><br>
  <input type="text" name="tuoteryhma_nimi"><br><br>
  <input type="submit" name="lisaa_tuoteryhma" value="Lisää tuoteryhmä">
</form>