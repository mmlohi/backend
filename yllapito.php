<?php
// Alustetaan sessiomuuttuja
session_start();

require_once 'dbconnection.php';
require_once 'functions.php';

// Yhdistetään tietokantaan
$db = new PDO("sqlite:designtuotteet.db");

// Tarkistetaan, onko käyttäjä jo kirjautunut sisään
if (isset($_SESSION['kayttajatunnus'])) {
  // Käyttäjä on jo kirjautunut sisään

  // Tarkistetaan, onko käyttäjä ylläpitäjä
  if (tarkistaYllapitaja($_SESSION['kayttajatunnus'], $db)) {
    // Käyttäjä on ylläpitäjä, näytetään ylläpito-sivu
    include 'yllapito.php';
  } else {
    // Käyttäjä ei ole ylläpitäjä, näytetään viesti
    echo "Sinulla ei ole pääsyä ylläpito-sivulle.";
  }
}

// Sisäänkirjautumislomakkeen lähetystiedot
if (isset($_POST['login'])) {
  // Sanitoidaan käyttäjän syöttämät tiedot
  $username = filter_input(INPUT_POST, 'kayttajatunnus', FILTER_SANITIZE_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'salasana', FILTER_SANITIZE_SPECIAL_CHARS);

  // Tarkistetaan, että kaikki tarvittavat tiedot on syötetty
  if (!empty($username) && !empty($password)) {
    try {
      // Tarkistetaan, onko käyttäjätunnus ja salasana oikein
      if (tarkistaKirjautuminen($username, $password, $db)) {
        // Asetetaan kirjautumistieto sessiomuuttujaan
        $_SESSION['kayttajatunnus'] = $username;
        
        if (isset($_SESSION['kayttajatunnus'])) {
          // Käyttäjä on kirjautunut sisään, näytetään ylläpitotoiminnot
          
        } else {
          // Käyttäjä ei ole kirjautunut sisään, näytetään sisäänkirjautumislomake
      
        }
      } else {
        // Käyttäjätunnus tai salasana on  on väärin
        echo "Väärä käyttäjätunnus tai salasana.";
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

?>
<!-- Sisäänkirjautumislomake -->
<form action="" method="post">
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


// Tarkistetaan, onko käyttäjä ylläpitäjä
$query = $db->prepare("SELECT rooli FROM kayttaja WHERE kayttajatunnus = :username AND salasana = :password");
$query->bindParam(':username', $username, PDO::PARAM_STR);
$query->bindParam(':password', $password, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch();


if ($result !== false && $result['rooli'] == 'ylläpitäjä') {
    // Käyttäjä on ylläpitäjä, näytetään ylläpitotoiminnot
    echo "<h1>Ylläpitotoiminnot</h1>";
    echo "<p>Täällä näytetään ylläpitäjän toiminnot.</p>";
    echo "<p><a href='lisaaKayttaja.php'>Lisää käyttäjä</a></p>";
    //echo "<p><a href='muokkaaKayttajaa.php'>Muokkaa käyttäjää</a></p>";
    //echo "<p><a href='poistaKayttaja.php'>Poista käyttäjä</a></p>";
    echo "<p><a href='lisaaTuote.php'>Lisää Tuote</a></p>";
    echo "<p><a href='lisaaTuoteryhma.php'>Lisää Tuoteryhmä</a></p>";
    echo "<p><a href='luePalaute.php'>Lue Palautteet</a></p>";
    } else 
    // Käyttäjä ei ole ylläpitäjä, näytetään normaalit toiminnot
    echo "Et ole ylläpitäjä.";
    echo "<p><a href='palaute.php'>Anna palautetta</a></p>";
    echo "<p><a href='naytaTuotteet.php'>Näytä tuotteet</a></p>";



 
