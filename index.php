<?php

session_start();
require('functions.php');

$db = createSqliteConnection("designtuotteet.db");

// Tarkistetaan, onko käyttäjä jo kirjautunut sisään
if (isset($_SESSION['kayttajatunnus'])) {
  // Käyttäjä on jo kirjautunut, näytetään etusivu
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
  //  Ei kirjautumista, näytetään sisäänkirjautumislomake
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
