<?php
require('dbconnection.php');

$db = createSqliteConnection("designtuotteet.db");

$sql ="SELECT * FROM tuote"; //Haetaan kaikki 

$statement = $db->prepare($sql);

// Suoritetaan SQL-lause ja tarkistetaan, onnistuiko se
if ($statement->execute()) {
  // Haetaan kaikki tuotteet taulusta
  $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

  foreach ($rows as $row){
      echo "ID: " . $row['id']. "<br>";
      echo "Nimi: " . $row['nimi']. "<br>";
      echo "Hinta: " . $row['hinta']. "<br>";
      echo "Kuvaus: " . $row['kuvaus']. "<br>";
      echo "<br>";
  }
} else {
  // Virheenkäsittely: ilmoitetaan käyttäjälle, että tuotteiden hakeminen ei onnistunut
  echo "Tuotteiden hakeminen ei onnistunut.";
}
