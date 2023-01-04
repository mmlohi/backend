<?php

session_start();
require('functions.php');

$db = createSqliteConnection("designtuotteet.db");

// Tarkistetaan, onko käyttäjä jo kirjautunut sisään
if (isset($_SESSION['kayttajatunnus'])) {
}

// Tarkistetaan, onko sisäänkirjautumislomaketta lähetetty
if (isset($_POST['login'])) {
    // Sanitoidaan käyttäjän syöttämät tiedot
    $username = filter_input(INPUT_POST, 'kayttajatunnus', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'salasana', FILTER_SANITIZE_SPECIAL_CHARS);

    // Tarkistetaan, että kaikki tarvittavat tiedot on syötetty
    if (!empty($username) && !empty($password)) {
        $query = $db->prepare("SELECT * FROM kayttaja WHERE kayttajatunnus=:username");
        $query->bindParam(':username', $username);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        try {
            // Tarkistetaan, onko käyttäjätunnus ja salasana oikein
            if (password_verify($password, $user['salasana'])) {
                $_SESSION['kayttajatunnus'] = $username;
                if ($user['rooli'] == "yllapitaja") {
                    $_SESSION['yllapitaja'] = true;
                } else {
                    $_SESSION['yllapitaja'] = false;
                }
                // Ohjataan ylläpitäjä ylläpito-sivulle
                header('Location: yllapito.php');
                exit;
            } else {
                // Ohjataan tavallinen käyttäjä etusivulle
                header('Location: index.php');
                exit;
            }
        } catch (PDOException $e) {
           
            echo "Virhe tietokantaan yhdistämisessä: " . $e->getMessage();
        }
    } else {
        echo "Syötä käyttäjätunnus ja salasana.";
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
<form action="logout.php">
  <input type="submit" value="Kirjaudu ulos">
</form>