<?php
require('dbconnection.php');//yhdistetty haku

$db = createSqliteConnection("designtuotteet.db");

$sql ="SELECT * FROM tuoteryhma"; //Haetaan kaikki tuoteryhmät
$statement = $db->prepare($sql);
$statement->execute();

$firstTuoteryhma = $statement-> fetch(PDO::FETCH_ASSOC);
$id=$firstTuoteryhma['id'];
$nimi=$firstTuoteryhma['id'];

//Haetaan tuotenimet 
$sql ="SELECT nimi FROM tuote WHERE id =" .$id; 
$statement = $db->prepare($sql);
$statement->execute();

//tulostaa tuotenimet ensimmäisestä tuoteryhmästä

$tuotenimet= $statement->fetchAll(PDO::FETCH_COLUMN,0);

echo "<h2>".$nimi."</h2>";

foreach ($tuotenimet as $tuotenimi){
    echo $tuotenimi."<br>";
}
