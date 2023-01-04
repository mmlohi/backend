<?php

$filename = "designtuotteet.db";
$db = new PDO("sqlite:$filename");

// Luodaan palautelomake, jossa asiakas voi antaa palautetta
echo "<form action='palaute.php' method='post'>";
echo "<label for='asiakas_id'>Asiakas ID:</label><br>";
echo "<input type='text' name='asiakas_id'><br>";
echo "<label for='pvm'>Pvm:</label><br>";
echo "<input type='text' name='pvm'><br>";
echo "<label for='teksti'>Palaute:</label><br>";
echo "<textarea name='teksti' rows='4' cols='50'></textarea><br>";
echo "<input type='submit' name='lähetä' value='Lähetä'>";
echo "</form>";

// Tarkistetaan, onko lomake lähetetty
if (isset($_POST['lähetä'])) {
  // Haetaan lomakkeen kentissä syötetyt arvot
  $asiakas_id = filter_var($_POST['asiakas_id'], FILTER_SANITIZE_NUMBER_INT);
  $pvm = filter_var($_POST['pvm'], FILTER_UNSAFE_RAW );
  $teksti = filter_var($_POST['teksti'], FILTER_UNSAFE_RAW );

  try {
    $query = $db->prepare("INSERT INTO palaute (asiakas_id, pvm, teksti) VALUES (:asiakas_id, :pvm, :teksti)");
    $query->execute(array(':asiakas_id' => $asiakas_id, ':pvm' => $pvm, ':teksti' => $teksti));
    echo "Palaute lähetetty onnistuneesti!";
   //Virheenkäsittely
  } catch (PDOException $e) {
    echo "Virhe lisättäessä palaute tietokantaan: " . $e->getMessage();
  }
}

?>