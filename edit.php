<?php
session_start();

require 'PDOconnexion.php'; //connexion à la bdd

if (isset($_SESSION['id'])) {   //Condition 
    $reqUser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_user = ?');
    $reqUser->execute(array($_SESSION['id']));
    $user = $reqUser->fetch();

    if (isset($_POST['newNom']) && !empty($_POST['newNom']) && $_POST['newNom'] != $user['nom_user']) {
        $newNom = htmlspecialchars($_POST['newNom']);
        $insertNom = $bdd->prepare("UPDATE utilisateurs SET nom_user = ? WHERE id_user = ?");
        $insertNom->execute(array($newNom, $_SESSION['id']));
        header('Location: profil_user.php?id=' . $_SESSION['id']);

        if (isset($_POST['newPrenom']) && !empty($_POST['newPrenom']) && $_POST['newPrenom'] != $user['prenom_user']) {
            $newPrenom = htmlspecialchars($_POST['newPrenom']);
            $insertPrenom = $bdd->prepare("UPDATE utilisateurs SET prenom_user = ? WHERE id_user = ?");
            $insertPrenom->execute(array($newPrenom, $_SESSION['id']));
            header('Location: profil_user.php?id=' . $_SESSION['id']);


            if (isset($_POST['save'])) {

                if (filter_var($_POST['newMail'], FILTER_VALIDATE_EMAIL)) {

                    if (isset($_POST['newMail']) && !empty($_POST['newMail']) && $_POST['newMail'] != $user['mail_user']) {
                        $newMail = ($_POST['newMail']);
                        $reqMail = $bdd->prepare("SELECT * FROM utilisateurs WHERE mail_user = ?"); //on recherche si le mail existe déjà
                        $reqMail->execute(array($newMail));
                        $mailExist = $reqMail->rowCount();
                        if ($mailExist == 0) {
                            $insertMail = $bdd->prepare("UPDATE utilisateurs SET mail_user = ? WHERE id_user = ?");
                            $insertMail->execute(array($newMail, $_SESSION['id']));
                            header('Location: profil_user.php?id=' . $_SESSION['id']);
                        } else {
                            $erreurEmailExist = "Adresse mail déjà utilisée";
                        }
                    }
                }
            }

            if (isset($_POST['newPseudo']) && isset($_POST['save'])) {
                $newPseudo = htmlspecialchars($_POST['newPseudo']);

                $reqPseudo = $bdd->prepare("SELECT * FROM utilisateurs WHERE pseudo = ?");  //on recherche si le pseudo existe déjà
                $reqPseudo->execute(array($newPseudo));
                $pseudoExist = $reqPseudo->rowCount();

                if ($pseudoExist == 0) {

                    if (isset($_POST['newPseudo']) && !empty($_POST['newPseudo'])) {
                        $insertPseudo = $bdd->prepare("UPDATE utilisateurs SET pseudo = ? WHERE id_user = ?");
                        $insertPseudo->execute(array($newPseudo, $_SESSION['id']));
                        header('Location: profil_user.php?id=' . $_SESSION['id']);
                    }
                } else {
                    $erreurPseudoExist = "Pseudo déjà utilisé";
                }
            }

            if (isset($_POST['newMdp']) && !empty($_POST['newMdp']) && $_POST['newMdpConf'] && !empty($_POST['newMdpConf'])) {
                $newMdpHashes = password_hash($_POST['newMdp'], PASSWORD_DEFAULT);

                if ($_POST['newMdp'] == $_POST['newMdpConf']) {
                    $insertNewMdp = $bdd->prepare("UPDATE utilisateurs SET password_user = ? WHERE id_user = ?");
                    $insertNewMdp->execute(array($newMdpHashes, $_SESSION['id']));
                    header('Location: profil_user.php?id=' . $_SESSION['id']);
                } else {
                    $erreurMdp = "Les mots de passes de correspondent pas.";
                }
            }
        }
    }

?>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/e765e852d9.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">

        <title>Document</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
            <div class="container">
                <?php
                if ($_SESSION['admin'] == 1) {
                ?>
                    <a class="navbar-brand" href="accueil_admin.php">Citrouille</a>
                <?php
                } else {
                ?>
                    <a class="navbar-brand" href="accueil_user.php">Citrouille</a>
                <?php
                }

                ?>
                <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                </button>
                <div class="collapse navbar-collapse" id="exCollapsingNavbar">
                    <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
                        <li class="nav-item order-3 order-md-1"><a href="<?php echo "profil_user.php?id=" . $_SESSION['id'] . "" ?>" class="nav-link" title="Profil"><i class="fas fa-user-circle"></i></a></li>
                        <li class="nav-item order-2 order-md-1"><a href="<?php echo "edit.php?id=" . $_SESSION['id']; ?>" class="nav-link" title="Edition"><i class="fas fa-cog"></i></a></li>
                        <li class="dropdown order-1">
                            <form action="logout.php">
                                <button name="logout" type="submit" class="btn btn-primary">Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <br><br><br><br><br>

        <div class="container">
            <div class="row justify-content-center">
                <h2>Edition du profil</h2>
            </div>

            <br>
        </div>

        <div class="container">

            <form method="POST" enctype="multipart/form-data">


                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Pseudo</label>
                    <div class="col-lg-9">
                        <input class="form-control" name="newPseudo" type="text" value="<?php echo $user['pseudo']; ?>">
                        <?php
                        if (isset($erreurPseudoExist)) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?php
                                echo $erreurPseudoExist;
                                ?>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                    <div class="col-lg-9">
                        <input class="form-control" name="newMail" type="email" value="<?php echo $user['mail_user']; ?>">
                        <?php
                        if (isset($erreurEmailExist)) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?php
                                echo $erreurEmailExist;
                                ?>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Mot de passe</label>
                    <div class="col-lg-9">
                        <input class="form-control" name="newMdp" type="password" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Confirmation du mot de passe</label>
                    <div class="col-lg-9">
                        <input class="form-control" name="newMdpConf" type="password" value="">
                        <?php
                        if (isset($erreurMdp)) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?php
                                echo $erreurMdp;
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-9">
                        <button name="save" type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </form>

        </div>
    </body>

    </html>
<?php
} else {
    header('Location: login.php');
}
?>