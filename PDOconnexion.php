<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=citrouille', 'root', '');
} catch(PDOException $e){
    $e = "Erreur SQL";
}
?>