<?php

// Alustetaan sessiomuuttuja
session_start();

require('dbconnection.php');
require('functions.php');

$db = createSqliteConnection("designtuotteet.db");

// Tarkistetaan, onko käyttäjä jo kirjautunut sisään
if (isset($_SESSION['kayttajatunnus'])) {
  // Kirjautuminen on jo tapahtunut, joten ohjataan käyttäjä ylläpito-sivulle
  header('Location: yllapito.php');
  exit;
} else {
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
          echo "kirjautuminen onnistui";

          // Asetetaan kirjautumistieto sessiomuuttujaan
          $_SESSION['kayttajatunnus'] = $username;
          // Ohjataan käyttäjä ylläpito-sivulle tai etusivulle sen mukaan, onko käyttäjä ylläpitäjä vai ei
          if (tarkistaYllapitaja($username, $rooli, $db)) {
            header('Location: yllapito.php');
          } else {
            header('Location: index.php');
          }
          exit;
        } else {
          // Kirjautuminen epäonnistui, ilmoitetaan käyttäjälle
          echo "Väärä käyttäjätunnus tai salasana.";
        }
      } catch (PDOException $e) {
        // Virheenkäsittely
      }
    } else {
      echo "Syötä käyttäjätunnus ja salasana.";
    }
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

<?php
