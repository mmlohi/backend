<?php
// Alustetaan sessiomuuttuja
session_start();

// Sisällytetään tietokantayhteyden luontiin tarvittava tiedosto
require('dbconnection.php');
require_once 'functions.php';

// Luodaan tietokantayhteys
$db = createSqliteConnection("designtuotteet.db");

if (!isset($_SESSION['kayttajatunnus'])) {
    // Kirjautuminen ei ole tapahtunut, ohjataan kirjautumissivulle
    header('Location: login.php');
    exit;
    }
    
    // Tarkistetaan, onko käyttäjä ylläpitäjä
    $rooli = 'yllapitaja';
    if (!tarkistaYllapitaja($_SESSION['kayttajatunnus'], $rooli, $db)) {
    // Käyttäjä ei ole ylläpitäjä, ohjataan takaisin kirjautumissivulle
    header('Location: login.php');
    exit;
    }
    
    // Tästä eteenpäin koodi suoritetaan vain, jos käyttäjä on kirjautunut sisään ja on ylläpitäjä
    echo "<h1>Ylläpitotoiminnot</h1>";
    echo "<p>Täällä näytetään ylläpitäjän toiminnot.</p>";
    echo "<p><a href='lisaaKayttaja.php'>Lisää käyttäjä</a></p>";
    echo "<p><a href='lisaaTuote.php'>Lisää Tuote</a></p>";
    echo "<p><a href='lisaaTuoteryhma.php'>Lisää Tuoteryhmä</a></p>";
    echo "<p><a href='luePalaute.php'>Lue Palautteet</a></p>";

    ?>
    <!-- Uloskirjautumislomake -->
    <form action="logout.php">
  <input type="submit" value="Kirjaudu ulos">
</form>

  
    
    
    
    
