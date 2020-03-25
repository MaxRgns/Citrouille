<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    $idConnexion = mysqli_connect("localhost", "root", "");

    mysqli_select_db($idConnexion, "citrouille");
    $req = "SELECT * FROM utilisateurs";
    $res = mysqli_query($idConnexion, $req);

    while ($row = $res->fetch_assoc()) {
        
        if ($row['user_admin'] == 0) {
            echo "<br>" . $row['nom_user'] . "<br>";
        }
    }

    ?>


</body>

</html>