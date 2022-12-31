<?php

// Alustetaan sessiomuuttuja
session_start();

require('dbconnection.php');

$db = createSqliteConnection("designtuotteet.db");

// Sisäänkirjautumislomakkeen lähetystiedot
if (isset($_POST['login'])) {
  $username = $_POST['kayttajatunnus'];
  $password = $_POST['salasana'];

  try {
    // Haetaan tietokannasta käyttäjän salasana hashausmerkkijonon perusteella
    $query = $db->prepare("SELECT salasana FROM kayttaja WHERE kayttajatunnus = :username");
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $hashed_password = $query->fetchColumn();

    // Tarkistetaan, onko annettu salasana oikea
    if (password_verify($password, $hashed_password)) {
      // Käyttäjätunnus ja salasana ovat oikein
      $_SESSION['kayttajatunnus'] = $username;
      header('Location: yllapito.php');
      exit;
    } else {
      // Käyttäjätunnus tai salasana on väärä
      echo "Väärä käyttäjätunnus tai salasana.";
    }
  } catch (PDOException $e) {
    // Virhe tapahtui tietokantakyselyssä
    echo "Virhe: " . $e->getMessage();
  }
  // Uloskirjautumislomakkeen lähetystiedot
  if (isset($_POST['logout'])) {
    // Poistetaan kirjautumistieto sessiomuuttujasta
    unset($_SESSION['kayttajatunnus']);
  }


  // Ylläpito-sivulle pääsy
  if (isset($_SESSION['username']) && tarkistaYllapitaja($_SESSION['username'], $db_conn)) {
    // Näytetään linkki ylläpito-sivulle
    echo "<a href='yllapito.php'>Ylläpito</a>";
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