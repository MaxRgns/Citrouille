<?php
session_start();
require 'PDOconnexion.php';
$reqIdMot = $bdd->prepare('SELECT id_mot FROM mots WHERE mot = ?');
$reqIdMot->execute(array(
    $_SESSION['mot']
));
$idMot = $reqIdMot->fetch(PDO::FETCH_ASSOC);
$idNewMot;

foreach ($idMot as $var) {
    $idNewMot = $var;
}

$inserList = $bdd->prepare("INSERT INTO liste (id_d, id_m) VALUES (?,?)");
$inserList->execute(array(
    $_SESSION['idDictee'],
    $idNewMot
));

$inserList = $bdd->prepare("INSERT INTO liste (id_d, id_m) VALUES (?,?)");
$inserList->execute(array(
    $_SESSION['idDictee'],
    $_SESSION['idMotExistant']
));

header('Location: ajoutMot.php');