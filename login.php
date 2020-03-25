<?php

try {
  $bdd = new PDO('mysql:host=127.0.0.1;dbname=citrouille', 'root', '');

  if (isset($_POST['formConnexion'])) {

    $pseudoConnect = htmlspecialchars($_POST['pseudoConnect']);
    $mdpConnect = $_POST['mdpConnect'];
    echo $mdpConnect;



    if (!empty($pseudoConnect) && !empty($mdpConnect)) {

      $reqUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE pseudo = ? AND password_user = ?");

      $reqUser->execute(
        array($pseudoConnect, $mdpConnect)
      );
      // $passworVerify[] = password_verify($mdpConnect, $reqUser['password_user']);
      echo $reqUser['password_user'];
      $userExist = $reqUser->rowCount();

      


      // if ($userExist && password_verify($mdpConnect, $reqUser['password_user'])) {
      //   $_SESSION[""];
      // } else {
      //   $erreurLogin = "Mauvais email ou mot de passe";
      // }
    }
  }
} catch (PDOException $e) {
  $message = $e->getMessage();
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

  <link rel="stylesheet" href="./style.css">
  <title>Document</title>
</head>

<body>

  <div class="container">

    <form method="POST" action="">

      <div class="row justify-content-center">
        <div class="col-5">
          <br>
          <h3>Connexion</h3>
          <br>
        </div>
        <br>
      </div>

      <?php
      if (isset($erreurLogin)) {
      ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

          <?php
          echo $erreurLogin;
          ?>

        </div>

      <?php
      }
      ?>

      <div class="row">
        <div class="col-8 mx-auto form-group">
          <input type="text" class="form-control" name="pseudoConnect" id="exampleInputPseudo" placeholder="Pseudo" required>
        </div>
      </div>

      <div class="row">
        <div class="col-8 mx-auto form-group">
          <input type="password" class="form-control" name="mdpConnect" id="exampleInputPassword" placeholder="Mot de passe" required>

        </div>
      </div>

      <div class="row">
        <div class="col-4 mx-auto">
          <button name="formConnexion" type="submit" class="btn btn-primary">Se connecter</button>
        </div>
      </div>
    </form>

  </div>

</body>

</html>