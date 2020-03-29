	<head>
	
	<title>Accueil</title>

	<meta charset="utf-8">
<!--Ouverture du script en JavaScript"-->
<script type="text/Javascript" src="citrouille.js">
</script>

<!--Ouverture du script css-->
<link rel="stylesheet" type="text/css" href="citrouille.css">

	</head>
	
	<body>

<!--récupérer la date-->

<div class="bienvenue">
	<?php

		// Enregistrement des informations de date dans des variables
		$jour = date('d');
		$mois = date('m');
		$annee = date('Y');

		$heure = date('H');
		$minute = date('i');

		// Maintenant on peut afficher ce qu'on a recueilli
		echo 'Bonjour !<br> Nous sommes le ' . $jour . '/' . $mois . '/' . $annee . ' et il est ' . $heure. ' h ' . $minute;

	?>
</div>

<br><br><br><br>


<!--avatar de l'utilisateur-->
	<img class='avatar'
	src="avatar.png"
	/>


<div class="infos">
	<!--Informations de l'utilisateur-->
	<table border>
		<tr>
			<td align="center">
		Utilisateur
			</td>
		</tr>
		<tr>
			<td>
	<ol>
		<li>Prénom :</li>
		<li>Nom :</li>
		<li>Classe :</li>
		<li>Votre score :</li>
	<ol>
			</td>
		</tr>
	</table>
</div>

<!--image du mot-->
<img class='image' src="vache.png" 
/>

<!--<input type="button" value="&#128266"  onclick="play()" align="center" img src="icone son.png">
<audio id="audio" src="massif.mp3" ></audio>
<link rel="icon" href="/icone son.png" sizes="32x32">-->

<!--son-->
<div class="son">
	<audio controls>
		<source src="massif.mp3" type="audio/mpeg">
		<source src="monAudio.ogg" type="audio/ogg">
	</audio>
</div>

<br>

<!--zone de texte-->
<div class="mot">
	<input type="text" name="nom" id="texte1" value="" size="48" />
</div>



<!--boutons opérations-->
<div class="opérations">
	<form>
	<!--bouton effacer-->
	<input type="button" value="&#x21D0 EFFACER" onclick="efface();" class="effacer">
	<!--bouton valider-->
	<input type="submit" value="&#10003 VALIDER" class="valider">
	<!--bouton réinitialiser-->
	<input type="reset" value="&#9675 REINITIALISER" class="réinitialiser">
	</form>
</div>
	</form>
</div>

<!-- boutons pour les lettres -->
<div class="lettres">
	<form action="citrouille.php" method="get" target="citrouille.php_self"> 
		<input type="button" value="A" id="bouton" onclick="valenter()" class="letter">
		<input type="button" value="Z" id="" onclick="afficher()" class="letter">
		<input type="button" value="E" id="" onclick="afficher()" class="letter">
		<input type="button" value="R" id="" onclick="afficher()" class="letter">
		<input type="button" value="T" id="" onclick="afficher()" class="letter">
		<input type="button" value="Y" id="" onclick="afficher()" class="letter">
	</form>
</div>



<?php
function genererChaineAleatoire($longueur = 10)
{
 return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($longueur/strlen($x)) )),1,$longueur);
}
//Utilisation de la fonction
echo genererChaineAleatoire();
echo genererChaineAleatoire(20);
?>



<!--Traitement des chaînes de caractères-->

<!--strlen : longueur d'une chaîne-->
<?php
//$phrase = 'Bonjour tout le monde ! Je suis une phrase !';
//$longueur = strlen($phrase);
  
//echo . $longueur . '<br />' . ;
?>


<!--function efface()
{
document.forms['nom_de_ton_form'].elements['nom_de_la_zone'].value=document.forms['nom_de_ton_form'].elements['nom_de_la_zone'].value.replace(/^(.*).$/,"$1")
}-->



	</body>
