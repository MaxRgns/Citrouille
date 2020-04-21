<?php
try{
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=citrouille', 'root', '');
} catch(PDOException $e){
    $e = "Erreur SQL";
}
?>