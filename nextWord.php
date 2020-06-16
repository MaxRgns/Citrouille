<?php
require 'PDOconnexion.php';
session_start();

$_SESSION['finDictee'];

if ($_POST['finalWord'] == $_SESSION['listMots'][$_SESSION['index']]) {
    $_SESSION['score'] = $_SESSION['score'] + 1;
}

$_SESSION['index'] = $_POST['indexMot'] + 1;
echo $_SESSION['index'];
if ($_SESSION['index'] < count($_SESSION['listMots'])) {

    header("Location:dictee.php?index=" . $_SESSION['index']);
} else {

    $_SESSION['finDictee'] = "Vous avez terminé la dictée avec un score de : " . $_SESSION['score'] . "/" . count($_SESSION['listMots']);
    $_SESSION['index'] = 0;
    $_SESSION['score'] = 0;
    header("Location:accueil_user.php?id=" . $_SESSION['id']);
}
