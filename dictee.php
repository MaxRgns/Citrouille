<?php
require 'PDOconnexion.php';

session_start();
// $_SESSION['score'] = 0;
// $_SESSION['index'] = 0;

if (!isset($_SESSION['listMots'])) {
    $req = $bdd->prepare("SELECT mot FROM mots");
    $req->execute();
    $listMots = $req->fetchAll(PDO::FETCH_COLUMN, 0); //récupération de la liste de mot de la bdd
    $_SESSION['listMots'] = $listMots;
}

if (!isset($_SESSION['index'])) {
    $_SESSION['index'] = 0;
}

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

srand(12345);
$shuffled = str_shuffle($_SESSION['listMots'][$_SESSION['index']]);

// récup image du mot
$reqImgMot = $bdd->prepare("SELECT image FROM mots WHERE mot = ?");
$reqImgMot->execute(array($_SESSION['listMots'][$_SESSION['index']]));
$imgMot = $reqImgMot->fetch(PDO::FETCH_ASSOC);
$img = "";
foreach ($imgMot as $var) {
    $img = $var;
}

// récup son du mot
$reqSonMot = $bdd->prepare("SELECT son FROM mots WHERE mot = ?");
$reqSonMot->execute(array($_SESSION['listMots'][$_SESSION['index']]));
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
                <img class="rounded-circle" src="/imagesMot/<?php echo $img; ?>" alt="imageMot" width=400px;>
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
            <form action="nextWord.php?indexMot=<?php echo $_SESSION['index'];?>" method="POST">
                <div class="row justify-content-center">
                    <input type="hidden" name="indexMot" value="<?php echo $_SESSION['index']?>">
                    <input type="text" class="input-group-text" name="finalWord" id="finalWord" value="<?php if (!isset($_POST['lettre'])) {
                                                                                                            $_SESSION['lettre'] = "";
                                                                                                        } else { //value du mot à trouver
                                                                                                            $_SESSION['lettre'] = $_SESSION['lettre'] . $_POST['lettre']; // concatenation des lettres
                                                                                                            echo $_SESSION['lettre'];
                                                                                                        } ?>">
                    <input class="btn btn-warning" name="resetWord" type="submit" value="Annuler">
                    <?php
                    if (isset($_POST['resetWord'])) {
                        $_SESSION['lettre'] = "";
                    }
                    ?>
                </div>
                <br>
                <?php
                $taille = strlen($_SESSION['listMots'][$_SESSION['index']]);
                for ($i = 0; $i < $taille; $i++) { //récuperation des lettres du mot
                ?>
                    <input class="btn btn-info" name="lettre" type="submit" value="<?php echo $shuffled[$i]; ?>">
                <?php
                }
                ?>
                <input class="btn btn-info" name="motValide" type="submit" value="Valider">

            </form>
        </div>
        <p>Votre score est de : <?php echo $_SESSION['score']; ?></p>
    </div>
</body>

</html>