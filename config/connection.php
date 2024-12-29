<?php 


function connection(){
    try {
        $conect = new PDO("mysql:host=localhost;dbname=ajax_card", "root", "");
        return $conect;
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
}