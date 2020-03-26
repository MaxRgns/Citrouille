<?php

session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=citrouille', 'root', '');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $getId = intval($_GET['id']);
    $reqUser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_user = ?');
    $reqUser->execute(array($getId));
    $userInfo = $reqUser->fetch();
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
    <link rel="stylesheet" href="./style.css">
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
                    <li class="nav-item order-2 order-md-1"><a href="<?php echo "edit.php?id=".$_SESSION['id']."" ?>" class="nav-link" title="settings"><i class="fas fa-cog"></i></a></li>
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
                    <a class="changeAvatar" href=""><img src="//placehold.it/150" class="mx-auto img-fluid rounded-circle d-block" alt="avatar">Choisir une nouvelle photo</a>
                </div>

                <div class="col-lg-8 order-lg-2">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profil</a>
                        </li>

                    </ul>
                    <div class="tab-content py-4">
                        <div class="tab-pane active" id="profil">
                            <h5 class="mb-3"><?php echo $userInfo['nom_user'] . " " . $userInfo['prenom_user']; ?></h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>About</h6>
                                    <p>
                                        Web Designer, UI/UX Engineer
                                    </p>
                                    <h6>Hobbies</h6>
                                    <p>
                                        Indie music, skiing and hiking. I love the great outdoors.
                                    </p>
                                </div>

                                
                            </div>

                        </div>
                       
                        
                    </div>
                </div>

            </div>
            
        </div>
    </section>
</body>

</html>