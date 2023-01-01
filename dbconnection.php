<?php

function createSqliteConnection($filename){
    try{
        $db = new PDO("sqlite:" .$filename);
        return $db;
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    return null;
}

