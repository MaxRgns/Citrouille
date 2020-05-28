<?php
session_start();
require 'PDOconnexion.php';

if (isset($_POST['nomClasse']) && !empty($_POST['nomClasse']) && isset($_POST['csvUpload'])) {
    $insertClasse = $bdd->prepare("INSERT INTO `classe` (`nom_classe`) VALUES (?)");
    $insertClasse->execute(array($_POST['nomClasse']));

    $idClasse = $bdd->prepare("SELECT id_classe FROM classe WHERE nom_classe = ?");
    $idClasse->execute(array($_POST['nomClasse']));
    $id = $idClasse->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['csvUpload'])) {
        if (!empty($_FILES['csv']['name'])) {
            $extCsv = explode(".", $_FILES['csv']['name']);
            if ($extCsv[1] == 'csv') {
                $fileCsv = fopen($_FILES['csv']['tmp_name'], 'r');
                while ($data = fgetcsv($fileCsv)) {
                    $item1 = $data[0];
                    $item2 = $data[1];
                    $item3 = $data[2];
                    $pseudoEleve = $item1 . " " . $item2;
                    $passwordEleve = password_hash(strtolower($data[1]), PASSWORD_DEFAULT);
                    $avatarEleve = "";
                    $insertClasse = $bdd->prepare("INSERT INTO `utilisateurs` (`id_user`,`prenom_user`, `nom_user`, `mail_user`,`password_user`,`user_admin`, `pseudo`, `avatar`, `id_classe_eleve`) VALUES (NULL,?, ?, ?, ?, 0, ?, ?, ?)");
                    $insertClasse->execute(array($item1, $item2, $item3, $passwordEleve, $pseudoEleve, $avatarEleve, $id['id_classe']));
                }
                fclose($fileCsv);
                echo "import done.\n";
            } else {
                echo "probleme import.";
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e765e852d9.js" crossorigin="anonymous"></script>
    <title>Document</title>
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
    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col-4">
                    <input name="nomClasse" type="text" class="form-control" placeholder="Nom de la classe">
                </div>
                <div class="input-group col-5">
                    <div class="custom-file">
                        <input name="csv" type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Choisir un fichier élève (.csv)</label>
                        <?php if (isset($_FILES['csvUpload'])) {
                            echo $_FILES['csv']['name'];
                        } ?>
                    </div>
                    <div class="input-group-append">
                        <button name="csvUpload" class="btn btn-outline-secondary" type="submit">Envoyer</button>
                    </div>
                </div>
            </div>
        </form>

        <?php

        //récupération des élèves de la classes

        $reqInfoEleve = $bdd->prepare("SELECT prenom_user, nom_user, mail_user FROM utilisateurs INNER JOIN classe WHERE utilisateurs.id_classe_eleve = classe.id_classe");
        $reqInfoEleve->execute();
        $infoEleve = $reqInfoEleve->fetchAll();

        ?>

        <br><br>
        <caption><?php echo $_POST['nomClasse']; ?></caption>
        <div class="container">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($infoEleve as $info) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $i++;  ?></th>
                            <td><?php echo $info[0]; ?></td>
                            <td><?php echo $info[1]; ?></td>
                            <td><?php echo $info[2]; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <a href="mailto:<?php foreach ($infoEleve as $info) {
                                   echo $info[2].";";
                                } ?>
                                ?subject=Première connexion à Citrouille
                                   &body=Lien de la connexion : http://localhost/Citrouille/login.php"> 
                    <button class="btn btn-primary">Envoyer un e-mail de connexion.</button></a>
            </div>
        </div>


        <script>
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        </script>
    </div>
</body>

</html>