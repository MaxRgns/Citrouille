<?php
require 'PDOconnexion.php';

session_start();
    $req = $bdd->prepare("SELECT mot FROM mots");
    $req->execute();
    $listMots = $req->fetchAll(PDO::FETCH_COLUMN, 0); //récupération de la liste de mot de la bdd

var_dump($listMots);

// $countWords = $req->rowCount(); //count de toutes les row de la bdd mot
// $randomWords = rand(0, ($countWords)-1); //sort une row random
// echo $randomWords;

srand(12345);
$shuffled = str_shuffle($listMots[0]);
// $shuffled = str_shuffle($listMots[$randomWords]); //mélange du mot random
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <br>
    <input type="text" name="finalWord" id="finalWord" disabled value="<?php if (!isset($_POST['lettre'])) {
                                                                            $_SESSION['flag'] = false;
                                                                            $_SESSION['lettre'] = "";
                                                                        } else { //value de mot à trouver
                                                                            $_SESSION['lettre'] = $_SESSION['lettre'] . $_POST['lettre']; // concatenation des lettres
                                                                            echo $_SESSION['lettre'];
                                                                        } ?>">
    <br>
    <form action="" method="POST">
        <?php
        // if ($randomWords >= 0) {
        for ($i = 0; $i < strlen($listMots[0]); $i++) { //récuperation des lettres du mot
            // for ($i = 0; $i < strlen($listMots[$randomWords]); $i++) { //récuperation des lettres du mot random
        ?>
            <input class="btn" name="lettre<?php $i ?>" type="submit" value="<?php echo $shuffled[$i]; ?>">
        <?php
        }
        // }
        ?>
        <input name="motValide" type="submit" value="Valider">
    </form>
</body>
<?php


?>

</html>