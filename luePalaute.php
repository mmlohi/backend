<?php

require('dbconnection.php');

$db = createSqliteConnection("designtuotteet.db");

try {
    // Valmistellaan ja suoritetaan SQL-lause, jolla haetaan kaikki palautteet tietokannasta
    $sql=("SELECT * FROM palaute");
  
    $statement = $db->prepare($sql);
  
    $statement->execute();
  
    // Tulostetaan palautteet
  
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($rows as $row) {
      echo  $row['asiakas_id'] . "<br>";
      echo  $row['pvm'] . "<br>";
      echo  $row['teksti'] . "<br><br>";
    }
  } catch (PDOException $e) {
    echo "Virhe: " . $e->getMessage();
  }

  
  
  

