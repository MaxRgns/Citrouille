	<head>
	
	<title>Dictée</title>

	<meta charset="utf-8">

<!--Ouverture du script css-->
<link rel="stylesheet" type="text/css" href="citrouille.css">
<!--Ouverture du script en JavaScript"-->
	<script type="text/Javascript" src="ecole.js">
	</script>

	<script type="text/Javascript" src="ecole.js">
	</script>
	
	</head>
	
	<body>

<div class="bienvenue">
	<?php
	
		include "config.php";
			
		// Enregistrement des informations de date dans des variables
		$jour = date('d');
		$mois = date('m');
		$annee = date('Y');

		$heure = date('H');
		$minute = date('i');
		
		//Recupération des informations de l'utilisateur
            $reqN = "SELECT * FROM `utilisateur`";
            $resultN=mysqli_query($idConnexion,$reqN);
			
			//recup des nom et prénom de l'utilisateur
            $resN=mysqli_fetch_assoc($resultN);

		// Affichage d'une phrase de bienvenue. Affichage des informations de quand le test est réalisé.
		echo 'Bonjour ' . $resN ['prenom'] . ' ' . $resN ['nom'] . ' !<br> Nous sommes le ' . $jour . '/' . $mois . '/' . $annee . ' et il est ' . $heure. ' h ' . $minute . ' . ';

	?>
</div>

<br>


<!--avatar de l'utilisateur-->
	<img class='avatar' src="avatar.png"/>


<!--<div class="infos">-->

<!--image du mot-->
<img class='image' src="vache.png"/>

<!--<input type="button" value="&#128266"  onclick="play()" align="center" img src="icone son.png">
<audio id="audio" src="massif.mp3" ></audio>
<link rel="icon" href="/icone son.png" sizes="32x32">-->

<!--son associé à l'image-->
<div class="son">
	<audio controls>
		<source src="massif.mp3" type="audio/mpeg">
		<source src="monAudio.ogg" type="audio/ogg">
	</audio>
</div>

<br> <br>

<?php 

$bo = $_POST['bou']; 

?>

<!--zone de texte-->
	<div class="mot">
	
		<input type="text" name="nom" id="texte1" value="<?php echo $bo ?>" size="48" />

		<?php
		
		$bo .= $bo;
		
		?>
		
	</div>

	
<!--Comparer deux chaines de caractères-->
<?php
//$var1 = "Bonjour";
//$var2 = "bonjour";
//if (strcmp($var1, $var2) !== 0) {
//    echo "$var1 n'est pas égal à $var2 par comparaison sensible à la casse.";
//}
?>

<!--boutons opérations-->
<div class="opérations">
	<form>
	<!--bouton effacer-->
	<input type="button" value="&#x21D0 EFFACER" value="" onclick="efface();" class="effacer">
	<!--bouton valider-->
	<input type="submit" value="&#10003 VALIDER" value="" class="valider">
	<!--bouton réinitialiser-->
	<input type="reset" value="&#9675 REINITIALISER" value="" class="réinitialiser">
	<!--bouton changer de mot-->
	<input type="submit" value="PASSER" class="passer">
	</form>
</div>                

<!--mots de la base de données 'ecole'-->
<div class="dictee">
<?PHP

//récupération et affichage des mots de la base de données 'ecole'
$sql =  'SELECT mot_libelle, mot_classe FROM dictee ORDER BY mot_classe';


foreach  ($idConnexion->query($sql) as $row) {
    $row['mot_libelle'] . "<br>";
} 

//Enregistrement des mots dans une liste '$row['mot_libelle']'
$md = $row['mot_libelle']; 
 
?>
</div>

<!--Deux sauts de ligne-->
<br><br>

<?php			
	
//Mot mélangé 
$shuffled = str_shuffle($md);

//Mot mélangé de la longueur du mot considéré
$maut=substr ($shuffled, 0);

?>


<!--Affichage des boutons-->

<form action="citrouille.php" method="POST">

<div class="lettres">
	
	<?php
	//Affichage de chacun des caractères des chaines de caractères dans des boutons séparés
	for($i = 0 ; $i < strlen($maut) ; $i++){
	?>
			<input type="submit" name="bou" value="<?php echo $maut [$i] ?>" id="bouton" class="letter">
	<?php
	}

	?>
</div>

</form>

<!--Fin de frame-->
<?php mysqli_close($idConnexion); ?>
	</body>
