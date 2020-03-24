<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=citrouille', 'root', '');

if (isset($_POST['formIns'])) {

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $emailConf = htmlspecialchars($_POST['emailConf']);
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    $mdpConf = password_hash($_POST['mdpConf'], PASSWORD_BCRYPT);

    if ($email == $emailConf) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $reqMail = $bdd->prepare("SELECT * FROM utilisateurs WHERE mail_user = '?'");
            $reqMail->execute(array($email));
            $mailExist = $reqMail->rowCount();

            if ($mailExist == 0) {
                if (password_verify($_POST["mdp"], $mdpConf)) {
                    $insertUser = $bdd->prepare('INSERT INTO utilisateurs(prenom_user, nom_user, mail_user, password_user) VALUES("?","?", "?", "?")');
                    $insertUser->execute(array($prenom, $nom, $email, $mdp));
                    $creationValid = "Votre compte a bien été créé !";
                } else {
                    $erreurMdp = "Vos mots de passes ne correspondent pas !";
                }
            } else {
                $erreurEmailExist = "Adresse mail déjà utilisée.";
            }
        } else {
            $erreurMail = "Vos emails ne correspondent pas !";
        }
    }
}

?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>

    <?php
    if (isset($creationValid)) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php
            echo $creationValid;
            ?>
        </div>
    <?php
    }
    ?>
    <div class="container">

        <form method="POST" action="">


            <div class="col-7 col-md-2 col-lg-2 mx-auto">
                <h3>Inscription</h3>
            </div>
            <br>
            <div class=" col-8 col-lg-4 mx-auto form-group">
                <input type="text" class="form-control" name="nom" id="exampleInputNom1" placeholder="Votre nom" value="<?php if (isset($nom)) {
                                                                                                                            echo $nom;
                                                                                                                        } ?>" required>
            </div>

            <div class="col-8 col-lg-4 mx-auto form-group">
                <input type="text" class="form-control" name="prenom" id="exampleInputPrenom1" placeholder="Votre prénom" value="<?php if (isset($prenom)) {
                                                                                                                                        echo $prenom;
                                                                                                                                    } ?>" required>
            </div>

            <div class="col-8 col-lg-4 mx-auto form-group">
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre email" value="<?php if (isset($email)) {
                                                                                                                                                                echo $email;
                                                                                                                                                            } ?>" required>
            </div>

            <div class="col-8 col-lg-4 mx-auto form-group">
                <input type="email" class="form-control" name="emailConf" id="exampleInputConfEmail2" aria-describedby="emailHelp" placeholder="Confirmation email" value="<?php if (isset($emailConf)) {
                                                                                                                                                                                echo $emailConf;
                                                                                                                                                                            } ?>" required>

                <?php
                if (isset($erreurMail)) {
                ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php
                        echo $erreurMail;
                        ?>
                    </div>
                <?php
                }
                ?>

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

            <div class="col-8 col-lg-4 mx-auto form-group">
                <input type="password" class="form-control" name="mdp" id="exampleInputPassword1" placeholder="Votre mot de passe" required>
            </div>

            <div class="col-8 col-lg-4 mx-auto form-group">
                <input type="password" class="form-control" name="mdpConf" id="exampleInputPasswordConf" placeholder="Ressaisir le mot de passe" required>

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

            <div class="col-5 col-lg-1 mx-auto">
                <button name="formIns" type="submit" class="btn btn-primary">S'inscrire</button>
            </div>

        </form>


    </div>

</body>

</html>