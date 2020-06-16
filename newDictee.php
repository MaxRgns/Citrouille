<?php
require 'PDOconnexion.php';
session_start();

if (isset($_POST['nomDictee'])) {
    $reqCreate = $bdd->prepare('INSERT INTO `dictee`(`nom_dictee`) VALUES (?)');
    $reqCreate->execute(array($_POST['nomDictee']));
    $_SESSION['nomDictee'] = $_POST['nomDictee'];
    header('Location:ajoutMot.php');
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle dictée</title>
</head>

<body>
    <br><br>
    <div class="container">
        <div class="row justify-content-center">
            <form method="POST" action="">
                <div class="form-group">
                    <input type="text" name="nomDictee" class="form-control" placeholder="Nom de la dictée.." required>
                </div>
                <input type="submit"  class="btn btn-primary" value="Ajouter une dictée">
            </form>
        </div>
    </div>
</body>

</html>