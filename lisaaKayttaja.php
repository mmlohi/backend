<?php

// Sisällytetään tietokantayhteyden luontiin tarvittavat tiedostot
require_once 'dbconnection.php';

// Tarkistetaan onko käyttäjä kirjautunut ylläpito-osiossa
if (isset($_SESSION['username'])) {

    // Tarkistetaan, onko lomake lähetetty
    if (isset($_POST['submit'])) {


        // Sanitoidaan lomakkeen kentissä syötetyt arvot
        $nimi = filter_input(INPUT_POST, 'nimi', FILTER_SANITIZE_SPECIAL_CHARS);
        $kayttajatunnus = filter_input(INPUT_POST, 'kayttajatunnus', FILTER_SANITIZE_SPECIAL_CHARS);
        $salasana = filter_input(INPUT_POST, 'salasana', FILTER_SANITIZE_SPECIAL_CHARS);
        $rooli = filter_input(INPUT_POST, 'rooli', FILTER_SANITIZE_SPECIAL_CHARS);


        // Lisätään sanitoidut parametrit SQL-lauseelle
        $query->bindParam(':nimi', $nimi);
        $query->bindParam(':kayttajatunnus', $kayttajatunnus);
        $query->bindParam(':salasana', $salasana);
        $query->bindParam(':rooli', $rooli);

        // Suoritetaan SQL-lause ja lisätään uusi käyttäjä tietokantaan

        try {
            // Suoritetaan SQL-lause ja lisätään uusi käyttäjä tietokantaan
            $query->execute();

            $query = $db->prepare("INSERT INTO kayttaja (nimi,kayttajatunnus, salasana, rooli) VALUES (:nimi, :kayttajatunnus, :salasana, :rooli)");
            // Ilmoitetaan käyttäjälle, että lisäys onnistui
            echo "Käyttäjä lisättiin onnistuneesti.";
        } catch (PDOException $e) {
            // Virheen sattuessa ilmoitetaan siitä käyttäjälle
            echo "Virhe käyttäjän lisäämisessä: " . $e->getMessage();
        }

        // Ilmoitetaan käyttäjälle, että lisäys onnistui
        echo "Käyttäjä lisättiin onnistuneesti.";
    }
}
?>

<!-- Lisää käyttäjä -lomake -->
<form action="lisaaKayttaja.php" method="post">
    <label for="nimi">Nimi</label><br>
    <input type="text" name="nimi"><br>
    <label for="kayttajatunnus">Käyttäjätunnus:</label><br>
    <input type="text" name="kayttajatunnus"><br>
    <label for="salasana">Salasana:</label><br>
    <input type="password" name="salasana"><br>
    <label for="rooli">Rooli:</label><br>
    <select name="rooli">
        <option value="käyttäjä">Käyttäjä</option>
        <option value="ylläpitäjä">Ylläpitäjä</option>
    </select><br>
    <input type="submit" value="Lisää käyttäjä">
</form>