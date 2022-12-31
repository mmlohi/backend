<?php

function createSqliteConnection(){
    try{
        $db = new PDO("sqlite:designtuotteet.db");
        return $db;
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    return null;
}

