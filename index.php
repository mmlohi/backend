<?php
// Alustetaan sessiomuuttuja
session_start();

// Sisällytetään tietokantayhteyden luontiin tarvittava tiedosto
require('dbconnection.php');

// Luodaan tietokantayhteys
$db = createSqliteConnection("designtuotteet.db");

// Tarkistetaan, onko käyttäjä jo kirjautunut sisään
if (isset($_SESSION['kayttajatunnus'])) {
  // Kirjautuminen on jo tapahtunut, näytetään etusivun sisältö
  ?>
  <h1>Etusivu</h1>
  <p>Tervetuloa <?php echo $_SESSION['kayttajatunnus']; ?>!</p>
  <p>Tässä näytetään tavallisille käyttäjille tarkoitettu sisältö.</p>

<p><a href='palaute.php'>Anna palautetta</a></p>
<p><a href='naytaTuotteet.php'>Näytä tuotteet</a></p>

<form action="logout.php">
  <input type="submit" value="Kirjaudu ulos">
</form>
  <?php
} else {
  // Kirjautuminen ei ole tapahtunut, näytetään sisäänkirjautumislomake
  ?>
  <form action="login.php" method="post">
    <h3>Kirjaudu</h3>
    <label for="kayttajatunnus">Käyttäjätunnus:</label><br>
    <input type="text" name="kayttajatunnus"><br>
    <label for="salasana">Salasana:</label><br>
    <input type="password" name="salasana"><br><br>
    <input type="submit" name="login" value="Kirjaudu sisään">
  </form>
  <?php


}
?>
