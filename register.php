<?php
require('dbconnection.php');

$db = createSqliteConnection("designtuotteet.db");
// Alustetaan sessiomuuttuja
session_start();

// Rekisteröintilomakkeen lähetystiedot
if (isset($_POST['kayttaja'])) {
    $nimi = $_POST['nimi'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $password_confirm = $_POST['salasana_vahvistus'];
    $rooli = $_POST['rooli'];

    // Tarkistetaan, onko käyttäjätunnus jo käytössä
    $query = $db->prepare("SELECT * FROM kayttaja WHERE kayttajatunnus = :username");
    $query->bindParam(':username', $username);
    $query->execute();
    $result = $query->fetch();

   
    if ($result) {
        // Käyttäjätunnus on jo käytössä
        echo "Valitettavasti käyttäjätunnus on jo käytössä. Valitse toinen käyttäjätunnus.";
    } else {
        // Tarkistetaan, ovatko salasanat samat

        if (password_verify($_POST['password'], $hashed_password_from_database)) {
            // Salasana on oikea
        } else {
            // Salasana on väärä
        }


            // Lisätään uusi käyttäjä tietokantaan
        $query = $db->prepare("INSERT INTO kayttaja (nimi, kayttajatunnus, salasana, rooli) VALUES (:nimi, :kayttajatunnus, :salasana, :rooli)");
        $query->bindParam(':nimi', $nimi, PDO::PARAM_STR);
        $query->bindParam(':kayttajatunnus', $username, PDO::PARAM_STR);
        $query->bindParam(':salasana', $password,  PDO::PARAM_STR);
        $query->bindParam(':rooli', $rooli,  PDO::PARAM_STR);

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

        ?>

<form action="register.php" method="post">
    <label for="nimi">Nimi:</label><br>
    <input type="text" name="nimi"><br>
    <label for="kayttajatunnus">Käyttäjätunnus:</label><br>
    <input type="text" name="username"><br>
    <label for="salasana">Salasana:</label><br>
    <input type="password" name="password"><br>
    <label for="salasana_vahvistus">Vahvista salasana:</label><br>
    <input type="salasana" name="salasana_vahvistus"><br>
    <label for="rooli">rooli:</label><br>
    <input type="rooli" name="rooli"><br>
    <input type="submit" name="kayttaja" value="Rekisteröidy">
</form>
