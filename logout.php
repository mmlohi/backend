<?php
session_start();

// Tuhotaan sessiomuuttuja, joka sisältää kirjautumistiedot
unset($_SESSION['kayttajatunnus']);

// Ohjataan käyttäjä takaisin etusivulle
header('Location: index.php');
exit;
?>