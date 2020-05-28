<?php
session_start();

require 'PDOconnexion.php';

if (isset($_POST['submit'])) {
    if (!empty($_FILES['image']) && !empty($_FILES['son'])) {
        //-----upload image----
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imgSize = $_FILES['image']['size'];

        $imageExt = explode('.', $imageName);
        $imageExtLowercase = strtolower(end($imageExt));

        $allowedImg = array('jpg', 'png', 'gif', 'jpeg');

        //----upload son --------
        $sonName = $_FILES['son']['name'];
        $sonTmpName = $_FILES['son']['tmp_name'];
        $sonSize = $_FILES['son']['size'];
        $sonName = $_FILES['son']['name'];

        $sonExt = explode('.', $sonName);
        $sonExtLowercase = strtolower(end($sonExt));
        $allowedSon = array('mp3');

        //verification pour upload les fichiers
        if (in_array($imageExtLowercase, $allowedImg) && in_array($sonExtLowercase, $allowedSon)) {
            if ($_FILES['image']['error'] === 0 && $_FILES['son']['error'] === 0) {
                if ($imgSize < 1000000 && $sonSize < 1000000) {
                    //création des fichiers images
                    $newImgName = $_POST['mot'] . "." . $imageExtLowercase;
                    $imageDest = 'imagesMot/' . $newImgName;
                    move_uploaded_file($imageTmpName, $imageDest);
                    //création des fichiers audios
                    $newSonName = $_POST['mot'] . "." . $sonExtLowercase;
                    $sonDest = 'sonsMot/' . $newSonName;
                    move_uploaded_file($sonTmpName, $sonDest);

                    $reqMotExist = $bdd->prepare("SELECT mot FROM mots WHERE mot = ?");  //on recherche si le mot existe déjà
                    $reqMotExist->execute(array(isset($_POST['mot'])));
                    $motExist = $reqMotExist->rowCount();


                    if ($motExist == 0) {
                        $insertMot = $bdd->prepare('INSERT INTO `mots`(`mot`, `image`, `son`) VALUES (?,?,?)');
                        $insertMot->execute(array(
                            $_POST['mot'],
                            $newImgName,
                            $newSonName
                        ));
                        $uploadSuccess = "Le mot a bien été ajouté.";
                    } else {
                        $erreurMotExist = "Mot déjà existant dans la base";
                       
                    }
                } else {
                    $erreurVolum = "fichier trop volumineux";
                }
            } else {
                $erreurUpload = "erreur upload";
            }
        } else {
            $erreurExt = "extension incorrecte";
        }
    }
}
// if (isset($_POST['submit'])) { //condition qu'on ai envoyé le form
//     //condition que tous les champs soit remplis
//     if (isset($_POST['mot']) && !empty($_POST['mot']) && isset($_POST['image']) && !empty($_POST['image']) && isset($_POST['son']) && !empty($_POST['son'])) {
//         $ajoutMot = $bdd->prepare("INSERT INTO `mots` (`mot`, `image`, `son`) VALUES (?, ?, ?)");
//         $ajoutMot->execute(array($_POST['mot'], $_POST['image'], $_POST['son']));
//     } else echo 'Les champs ne sont pas remplis.';
// }



?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e765e852d9.js" crossorigin="anonymous"></script>
    <title>Ajout de mot</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
        <div class="container">
            <a class="navbar-brand" href="#">Brand</a>
            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                &#9776;
            </button>
            <div class="collapse navbar-collapse" id="exCollapsingNavbar">
                <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
                    <li class="nav-item order-3 order-md-1"><a href="<?php echo "profil_user.php?id=" . $_SESSION['id'] . "" ?>" class="nav-link" title="settings"><i class="fas fa-cog"></i></a></li>
                    <li class="nav-item order-2 order-md-1"><a href="<?php echo "edit.php?id=" . $_SESSION['id'] . "" ?>" class="nav-link" title="settings"><i class="fas fa-cog"></i></a></li>
                    <li class="dropdown order-1">
                        <form action="logout.php">
                            <button name="logout" type="submit" class="btn btn-primary">Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br><br><br>


    <?php //mot déjà existant
    if (isset($erreurMotExist)) {
    ?>
        <div class="alert alert-warning" role="alert">
            <?php echo $erreurMotExist; ?>
        </div>
    <?php
    }
    ?>

    <?php //volume fichier non respecté
    if (isset($erreurVolum)) {
    ?>
        <div class="alert alert-warning" role="alert">
            <?php echo $erreurVolum; ?>
        </div>
    <?php
    }
    ?>

    <?php // upload réussi
    if (isset($uploadSuccess)) {
    ?>
        <div class="alert alert-success" role="alert">
            <?php echo $uploadSuccess; ?>
        </div>
    <?php
    }
    ?>

    <?php // erreur d'upload
    if (isset($erreurUpload)) {
    ?>
        <div class="alert alert-warning" role="alert">
            <?php echo $erreurUpload; ?>
        </div>
    <?php
    }
    ?>

    <?php //erreur d'extension
    if (isset($erreurExt)) {
    ?>
        <div class="alert alert-warning" role="alert">
            <?php echo $erreurExt; ?>
        </div>
    <?php
    }
    ?>

    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="mot" id="mot" placeholder="Votre mot">
            <div class="form-group">
                <label for="exampleFormControlFile1">Image :</label>
                <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Son :</label>
                <input type="file" name="son" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Envoyer">
        </form>
    </div>

</body>

</html>