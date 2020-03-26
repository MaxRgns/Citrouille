<?php

session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=citrouille', 'root', '');

if (isset($_SESSION['id'])) {
    $reqUser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_user = ?');
    $reqUser->execute(array($_SESSION['id']));
    $user = $reqUser->fetch();

    if (isset($_POST['newPseudo']) && !empty($_POST['newPseudo']) && $_POST['newPseudo'] != $user['pseudo']) {
        $newPseudo = htmlspecialchars($_POST['newPseudo']);
        $insertPseudo = $bdd->prepare("UPDATE utilisateurs SET pseudo = '?' WHERE id_user = ?");
        $insertPseudo->execute(array($newPseudo, $_SESSION['id']));
        header('Location: profil_user.php?id=' . $_SESSION['id']);
    }

?>


    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/e765e852d9.js" crossorigin="anonymous"></script>

        <title>Document</title>
    </head>

    <body>
        <div class="container">
            <div class="tab-pane" id="edit">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
                    <div class="container">
                        <a class="navbar-brand" href="#">Brand</a>
                        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                            &#9776;
                        </button>
                        <div class="collapse navbar-collapse" id="exCollapsingNavbar">
                            <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
                                <li class="nav-item order-2 order-md-1"><a href="<?php echo "profil_user.php?id=" . $_SESSION['id'] . "" ?>" class="nav-link" title="settings"><i class="fas fa-cog"></i></a></li>
                                <li class="dropdown order-1">
                                    <form action="logout.php">
                                        <button name="logout" type="submit" class="btn btn-primary">Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <br><br><br><br>
                <h2>Edition du profil</h2>
                <br><br>
                <form metod="POST">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Prénom</label>
                        <div class="col-lg-9">
                            <input class="form-control" name="newPrenom" type="text" value="<?php echo $user['prenom_user'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Nom</label>
                        <div class="col-lg-9">
                            <input class="form-control" name="newNom" type="text" value="<?php echo $user['nom_user'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Email</label>
                        <div class="col-lg-9">
                            <input class="form-control" name="newMail" type="email" value="<?php echo $user['mail_user'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Pseudo</label>
                        <div class="col-lg-9">
                            <input class="form-control" name="newPseudo" type="text" value="<?php echo $user['pseudo'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Password</label>
                        <div class="col-lg-9">
                            <input class="form-control" name="newMdp" type="password" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                        <div class="col-lg-9">
                            <input class="form-control" name="newMdpConf" type="password" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label"></label>
                        <div class="col-lg-9">
                            <input type="reset" class="btn btn-secondary" value="Cancel">
                            <input name="save" type="submit" class="btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>

<?php
} else {
    header('Location: login.php');
}

?>

    </html>