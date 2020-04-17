	<head>
	
	<title>Ajout de mots</title>

	<meta charset="utf-8" />
	
	</head>
	
	
	<style type="text/css">
	{
		text-align: center;
	}
	</style>
	
	
	<body>
	

<!--formulaire d'ajout de mots-->
<form action="" method="post">
    <p>
        <label for="id_dictee">id_dictee</label> :  <input type="text" name="id_dictee" id="id_dictee" /><br />
		<label for="mot_libelle">mot_libelle</label> : <input type="text" name="mot_libelle" id="mot_libelle" /><br />
		<label for="categorie">categorie</label> :  <input type="text" name="categorie" id="categorie" /><br />
		<label for="image">image</label> : <input type="text" name="image" id="image" /><br />
		<label for="son">son</label> :  <input type="text" name="son" id="son" /><br />
		<label for="difficulte(s)">difficulte(s)</label> : <input type="text" name="difficulte(s)" id="difficulte(s)" /><br />
		<label for="mot_classe">mot_classe</label> : <input type="text" name="mot_classe" id="mot_classe" /><br />
		
        <input type="submit" value="Envoyer" />
	</p>
</form>

<?php
	
	//Connexion à la base de données en PDO
	require'PDOConnexion.php';
	
//Requête SQL	
$req = $bdd->prepare('INSERT INTO mot(id_dictee, mot_libelle, categorie, image, son, difficulte(s), mot_classe) 
						VALUES(?, ?, ?, ?, ?, ?, ?)');

//Exécution de la requête
$req->execute(array($_POST['id_dictee'], $_POST['mot_libelle'], $_POST['categorie'], $_POST['image'], $_POST['son'],
						$_POST['difficulte(s)'], $_POST['mot_classe']
	));

	?>
	
	
	
	
	</body>