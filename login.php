<?php

// Alustetaan sessiomuuttuja
session_start();

require('dbconnection.php');
require('functions.php');

$db = createSqliteConnection("designtuotteet.db");

// Tarkistetaan, onko käyttäjä jo kirjautunut sisään
if (isset($_SESSION['kayttajatunnus'])) {
  // Käyttäjä on jo kirjautunut sisään

  if (tarkistaYllapitaja($_SESSION['kayttajatunnus'], $db)) {
    // Käyttäjä on ylläpitäjä, näytetään ylläpito-sivu

  } else {
    // Käyttäjä ei ole ylläpitäjä, näytetään viesti
    echo "Sinulla ei ole pääsyä ylläpito-sivulle.";
  }
  // Tarkistetaan, onko sisäänkirjautumislomaketta lähetetty
  if (isset($_POST['login'])) {

    // Sanitoidaan käyttäjän syöttämät tiedot
    $username = filter_input(INPUT_POST, 'kayttajatunnus', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'salasana', FILTER_SANITIZE_SPECIAL_CHARS);

    // Tarkistetaan, että kaikki tarvittavat tiedot on syötetty
    if (!empty($username) && !empty($password)) {

      try {
        // Tarkistetaan, onko käyttäjätunnus ja salasana oikein
        if (tarkistaKirjautuminen($username, $password, $db)) {
          // Kirjautuminen onnistui

          // Asetetaan kirjautumistieto sessiomuuttujaan
          $_SESSION['kayttajatunnus'] = $username;
          // Ohjataan käyttäjä ylläpito-sivulle

        }
      } catch (PDOException $e) {
        // Virheenkäsittely
      }
    } else {
      echo "Syötä käyttäjätunnus ja salasana.";
    }
  }
  // Uloskirjautumislomakkeen lähetystiedot
  if (isset($_POST['logout'])) {
    // Poistetaan kirjautumistieto sessiomuuttujasta
    unset($_SESSION['kayttajatunnus']);
  }
}
?>

<!-- Sisäänkirjautumislomake -->
<form action="" method="post">
  <h3>Kirjaudu</h3>
  <label for="kayttajatunnus">Käyttäjätunnus:</label><br>
  <input type="text" name="kayttajatunnus"><br>
  <label for="salasana">Salasana:</label><br>
  <input type="password" name="salasana"><br><br>
  <input type="submit" name="login" value="Kirjaudu sisään">
</form>

<!-- Uloskirjautumislomake -->
<form action="" method="post">
  <input type="submit" name="logout" value="Kirjaudu ulos">
</form>