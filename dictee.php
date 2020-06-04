<?php
require 'PDOconnexion.php';

session_start();
$iMot = 0;

$req = $bdd->prepare("SELECT mot FROM mots");
$req->execute();
$listMots = $req->fetchAll(PDO::FETCH_COLUMN, 0); //récupération de la liste de mot de la bdd

srand(12345);
$shuffled = str_shuffle($listMots[$iMot]);
// $shuffled = str_shuffle($listMots[$iMot]); //mélange du mot random

$reqImgMot = $bdd->prepare("SELECT image FROM mots WHERE mot = ?"); // récup image du mot
$reqImgMot->execute(array($listMots[$iMot]));
$imgMot = $reqImgMot->fetch(PDO::FETCH_ASSOC);
$mot = "";
foreach ($imgMot as $var) {
    $mot = $var;
}


$reqSonMot = $bdd->prepare("SELECT son FROM mots WHERE mot = ?"); // récup son du mot
$reqSonMot->execute(array($listMots[$iMot]));
$sonMot = $reqSonMot->fetch(PDO::FETCH_ASSOC);
$son = "";
foreach ($sonMot as $var) {
    $son = $var;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="dictee.css">
    <script src="https://kit.fontawesome.com/e765e852d9.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script>
        function play() {
            var audio = document.getElementById("audio");
            audio.play();
        }
    </script>

    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="imageMot">
                <img class="rounded-circle" src="/imagesMot/<?php echo $mot; ?>" alt="imageMot" width=400px;>
            </div>
        </div>

        <br>

        <div class="row justify-content-center">
            <div class="sonMot">
                <button class="input-group-text" type="button" value="PLAY" onclick="play()"><i class="fas fa-volume-up"></i></button>
                <audio src="/sonsMot/<?php echo $son; ?>" id="audio"></audio>
            </div>
        </div>

        <br>
        <br>
        <div class="row justify-content-center">
            <form action="" method="POST">
                <div class="row justify-content-center">
                    <input type="text" class="input-group-text" name="finalWord" id="finalWord" disabled value="<?php if (!isset($_POST['lettre'])) {
                                                                                                                    $_SESSION['flag'] = false;
                                                                                                                    $_SESSION['lettre'] = "";
                                                                                                                } else { //value de mot à trouver
                                                                                                                    $_SESSION['lettre'] = $_SESSION['lettre'] . $_POST['lettre']; // concatenation des lettres
                                                                                                                    echo $_SESSION['lettre'];
                                                                                                                } ?>">
                </div>
<br>
                <?php
                for ($word=0; $word < 5 ; $word++) { 
                    # code...
                }
                // if ($randomWords >= 0) {
                for ($i = 0; $i < strlen($listMots[$iMot]); $i++) { //récuperation des lettres du mot
                    // for ($i = 0; $i < strlen($listMots[$randomWords]); $i++) { //récuperation des lettres du mot random
                ?>
                    <input class="btn btn-info" name="lettre" type="submit" value="<?php echo $shuffled[$i]; ?>">
                <?php
                }
                // }
                ?>

                <input class="btn btn-info" name="motValide" type="submit" value="Valider">
            </form>
        </div>
    </div>
</body>

</html>