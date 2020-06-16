<?php
session_start();

require 'PDOconnexion.php';

$reqIdDictee = $bdd->prepare("SELECT id_dictee FROM dictee where nom_dictee = ?");
$reqIdDictee->execute(array($_SESSION['nomDictee']));
$idDictee = $reqIdDictee->fetch(PDO::FETCH_ASSOC);
$_SESSION['idDictee'];

foreach ($idDictee as $var) {
    $_SESSION['idDictee'] = $var;
}

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
                    //on recherche si le mot existe déjà
                    $reqMotExist = $bdd->prepare("SELECT mot FROM mots WHERE mot = ?");
                    $reqMotExist->execute(array($_POST['mot']));
                    $motExist = $reqMotExist->rowCount();
                    //s'il existe
                    if ($motExist == 0) {
                        $_SESSION['mot'] = $_POST['mot'];
                        $insertMot = $bdd->prepare('INSERT INTO `mots`(`mot`, `image`, `son`) VALUES (?,?,?)');
                        $insertMot->execute(array(
                            $_SESSION['mot'],
                            $newImgName,
                            $newSonName
                        ));
                        header('Location: selectMot.php');
                        $uploadSuccess = "Le mot a bien été ajouté.";
                    } else {
                        $erreurMotExist = "Mot déjà existant dans la base.";
                    }
                } else {
                    $erreurVolum = "fichier trop volumineux.";
                }
            } else {
                $erreurUpload = "erreur upload.";
            }
        } else {
            $erreurExt = "extension incorrecte.";
        }
    }
}

$reqMots = $bdd->prepare('SELECT id_mot, mot FROM mots ORDER BY mot');
$reqMots->execute();
$mots = $reqMots->fetchAll();

if (isset($_POST['idMotExistant'])) {
    $_SESSION['idMotExistant'] = $_POST['idMotExistant'];
    header('Location: selectMot.php?mot=' . $_SESSION['mot']);
}

if (isset($_POST['submit'])) {
    header('Location: ajoutDictee.php');
}
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
    <link rel="stylesheet" href="style.css">
    <title>Ajout de mot</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
        <div class="container">
            <a class="navbar-brand" href="#">Citrouille</a>
            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                &#9776;
            </button>
            <div class="collapse navbar-collapse" id="exCollapsingNavbar">
                <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
                    <li class="nav-item order-3 order-md-1"><a href="<?php echo "profil_user.php?id=" . $_SESSION['id'] . "" ?>" class="nav-link" title="settings"><i class="fas fa-user-circle"></i></a></li>
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
    <div class="container">
        <br><br><br>
        <div class="row justify-content-center">
            <h3>Ajouter un mot pour la dictée : <?php echo $_SESSION['nomDictee']; ?></h3>

        </div>
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
        <br>
    </div>

    <div class="container">

        <div class="row justify-content-center">

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="formGroupExampleInput"></label>
                    <input type="text" name="mot" class="form-control" id="formGroupExampleInput" placeholder="Votre mot...">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Image : (jpg, png, gif, jpeg)</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Importer</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choisir une image</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Son : (mp3)</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Importer</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="son" class="custom-file-input" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choisir un son</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <input type="submit" class="btn btn-primary" name="submit" value="Ajouter">
                </div>
            </form>

        </div>
        <br>
        <div class="row justify-content-center">
            <h3>Ou, choississez en un déjà existant...</h3>
        </div>
        <br>
        <div class="row justify-content-center">
            <form method="POST">
                <div class="input-group">
                    <select name="idMotExistant" class="custom-select" id="inputGroupSelect04">
                        <?php
                        $motsExistant;

                        foreach ($mots as $var) {
                            $motExistant = $var;
                        ?>
                            <option value="<?php echo $var[0] ?>"><?php echo $var[1] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="input-group-append">
                        <input class="btn btn-outline-secondary" type="submit" value="Envoyer">
                    </div>
                    <a href="ajoutDictee.php"><button type='button' class="btn btn-outline-primary">Ajouter la dictée</button></a>
                </div>
            </form>

        </div>
        <br>
        <br><br>

        <?php
        $reqMotTable = $bdd->prepare('SELECT mot FROM mots  INNER JOIN liste  ON mots.id_mot = liste.id_m   INNER JOIN dictee   ON liste.id_d = dictee.id_dictee   WHERE id_dictee =?;');
        $reqMotTable->execute(array(
            $_SESSION['idDictee']
        ));
        $motTable = $reqMotTable->fetchAll();
        ?>
        <div class="row justify-content-center ">
            <table class="table" style="width:250px;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mots Ajoutés</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($motTable as $mot) {
                    ?>
                        <tr style="width:auto;">
                            <th scope="row"><?php echo $i++;  ?></th>
                            <td><?php echo $mot[0]; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

</html>