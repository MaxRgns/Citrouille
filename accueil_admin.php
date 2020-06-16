<?php
require 'PDOconnexion.php';
session_start();
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
    <title>Gestion des classes</title>
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
                    <li class="nav-item order-3 order-md-1"><a href="<?php echo "profil_user.php?id=" . $_SESSION['id'] . "" ?>" class="nav-link" title="Profil"><i class="fas fa-user-circle"></i></a></li>
                    <li class="nav-item order-2 order-md-1"><a href="<?php echo "edit.php?id=" . $_SESSION['id'] . "" ?>" class="nav-link" title="Edition"><i class="fas fa-cog"></i></a></li>
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
        <div class="row">
            <a href="newClasse.php"><button type="submit" class="btn btn-dark">Ajouter une nouvelle classe</button></a>
            <a href="newDictee.php"><button type="submit" class="btn btn-dark">Ajouter une nouvelle dictée</button></a>
        </div>
    </div>

</body>

</html>