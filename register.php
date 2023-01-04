<?php

session_start();
require('functions.php');

$db = createSqliteConnection("designtuotteet.db");

// Tarkistetaan, onko rekisteröintilomakkeen lähetyspainike painettu
if (isset($_POST['kayttaja'])) {
    // Sanitoidaan käyttäjän syöttämät tiedot
    $nimi = filter_input(INPUT_POST, 'nimi', FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $password_confirm = filter_input(INPUT_POST, 'password_confirm', FILTER_SANITIZE_SPECIAL_CHARS);
    $rooli = filter_input(INPUT_POST, 'rooli', FILTER_SANITIZE_SPECIAL_CHARS);

    // Tarkistetaan, että kaikki tarvittavat tiedot on syötetty
    if (!empty($nimi) && !empty($username) && !empty($password) && !empty($password_confirm) && !empty($rooli)) {
        // Tarkistetaan, ovatko salasanat samat
        if ($password !== $password_confirm) {
            // Salasanat eivät ole samat, ilmoitetaan käyttäjälle
            echo "Vahvistettu salasana ei täsmää alkuperäiseen salasanaan. Yritä uudelleen";
        } else {
            // Tarkistetaan, onko käyttäjätunnus jo käytössä
            $query = $db->prepare("SELECT * FROM kayttaja WHERE kayttajatunnus = :username");
            $query->bindParam(':username', $username);
            $query->execute();
            $result = $query->fetch();

            if ($result) {
                // Käyttäjätunnus on jo käytössä
                echo "Valitettavasti käyttäjätunnus on jo käytössä. Valitse toinen käyttäjätunnus.";
            } else {
                // Suoritetaan salasanan hashaus
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Lisätään uusi käyttäjä tietokantaan
$query = $db->prepare("INSERT INTO kayttaja (nimi,kayttajatunnus, salasana, rooli) VALUES (:nimi, :kayttajatunnus, :salasana, :rooli)");
$query->bindParam(':nimi', $nimi);
$query->bindParam(':kayttajatunnus', $username);
$query->bindParam(':salasana', $hashed_password);
$query->bindParam(':rooli', $rooli);

try {
    $query->execute();
} catch (PDOException $e) {
    echo "Virhe lisättäessä käyttäjää: " . $e->getMessage();
}

// Kirjataan uusi käyttäjä sisään
$_SESSION['kayttajatunnus'] = $username;
header('Location: login.php');
}
}
}

}
?>

<form action="register.php" method="post">
<h3>Käyttäjän rekisteröityminen</h3>
    <label for="nimi">Nimi:</label><br>
    <input type="text" name="nimi"><br>
    <label for="kayttajatunnus">Käyttäjätunnus:</label><br>
    <input type="text" name="username"><br>
    <label for="salasana">Salasana:</label><br>
    <input type="password" name="password"><br>
    <label for="password_confirm">Vahvista salasana:</label><br>
    <input type="password" name="password_confirm"><br>
    <label for="rooli">rooli:</label><br>
    <input type="rooli" name="rooli"><br>
    <input type="submit" name="kayttaja" value="Rekisteröidy">
</form>