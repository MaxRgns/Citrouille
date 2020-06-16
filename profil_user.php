<?php

session_start();

require 'PDOconnexion.php';

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $getId = intval($_GET['id']);
    $reqUser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_user = ?');
    $reqUser->execute(array($getId));
    $userInfo = $reqUser->fetch();
    
}

if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
    $tailleMax =  2097152;
    $extValide = array('jpg', 'jpeg', 'gif', 'png');
    if ($_FILES['avatar']['size'] <= $tailleMax) {
        $extUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
        if (in_array($extUpload, $extValide)) {
            $pwd = "./users/avatar/" . $_SESSION['id'] . "." . $extUpload;
            $resPwd = move_uploaded_file($_FILES['avatar']['tmp_name'], $pwd);
            if ($resPwd) {
                $updateAvatar = $bdd->prepare('UPDATE utilisateurs SET avatar = :avatar WHERE id_user = :id');
                $updateAvatar->execute(array(
                    'avatar' => $_SESSION['id'] . "." . $extUpload,
                    'id' => $_SESSION['id']
                ));
                header('Location: profil_user.php?id=' . $_SESSION['id']);
            } else {
                $erreurPwd = "L'importation a échoué.";
            }
        } else {
            $erreurFormat = "Mauvais format d'image (.JPG , .PNG, .JPEG, .GIF).";
        }
    } else {
        $erreurAvatar = "Votre photo de profil ne doit pas dépasser 2MO.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/e765e852d9.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" role="navigation">
        <div class="container">
            <a class="navbar-brand" href="<?php echo "accueil_user.php?id=".$_SESSION['id']; ?>">Citrouille</a>
            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
                &#9776;
            </button>
            <div class="collapse navbar-collapse" id="exCollapsingNavbar">
                <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
                    <li class="nav-item order-3 order-md-1"><a href="<?php echo "profil_user.php?id=" . $_SESSION['id'] . "" ?>" class="nav-link" title="profil"><i class="fas fa-user-circle"></i></a></li>
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
    <section>
        <div class="container">
            <div class="row my-2">

                <div class="col-lg-4 order-lg-1 text-center">
                    <?php
                    if (!empty($userInfo['avatar'])) {
                    ?>
                        <img src="users/avatar/<?php echo $userInfo['avatar']; ?>" width="150" class="mx-auto img-fluid rounded-circle d-block" alt="avatar">
                    <?php
                    } else {
                        ?>
                        <img src="users/avatar/defaultAvatar.png" width="150" class="mx-auto img-fluid rounded-circle d-block" alt="avatar">

                        <?php
                    }
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-lg-4 order-lg-1 text-center ">
                            <div class="changeAvatar">
                                <label for="changeAvatar">
                                    <?php
                                    if (isset($erreurPwd)) {
                                    ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <?php
                                            echo $erreurPwd;
                                            ?>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (isset($erreurFormat)) {
                                    ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <?php
                                            echo $erreurFormat;
                                            ?>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (isset($erreurAvatar)) {
                                    ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <?php
                                            echo $erreurAvatar;
                                            ?>
                                        </div>

                                    <?php
                                    }
                                    ?>


                                    <?php
                                    if (!empty($user['avatar'])) {
                                    ?>
                                        <img src="users/avatar/<?php echo $user['avatar']; ?>" width="150" class="mx-auto img-fluid rounded-circle d-block" alt="avatar">
                                    <?php
                                    }
                                    ?>

                                    Changer de photo de profil
                                </label>

                                <input type="file" name="avatar" id="changeAvatar">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-8 order-lg-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">

                            <a data-target="#profile" data-toggle="tab" class="nav-link active">Profil</a>
                        </li>

                    </ul>
                    <div class="tab-content py-4">
                        <div class="tab-pane active" id="profil">
                            <h5 class="mb-3"><?php echo $userInfo['nom_user'] . " " . $userInfo['prenom_user']; ?></h5>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</body>

</html>