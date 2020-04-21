<?php

require 'PDOconnexion.php';
if (isset($_POST['submit'])) { //condition qu'on ai envoyé le form
    //condition que tous les champs soit remplis
    if (isset($_POST['mot']) && !empty($_POST['mot']) && isset($_POST['image']) && !empty($_POST['image']) && isset($_POST['son']) && !empty($_POST['son'])) {
        $ajoutMot = $bdd->prepare("INSERT INTO `mots` (`mot`, `image`, `son`) VALUES (?, ?, ?)");
        $ajoutMot->execute(array($_POST['mot'], $_POST['image'], $_POST['son']));
    } else echo 'Les champs ne sont pas remplis.';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <form action="" method="post">
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