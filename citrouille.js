var player="";


var alpha="abcdefghijklmnopqrstuvwxyz".split("");
var rnd_ltt=alpha[Math.floor(Math.random()*26)];




function valenter(){
        var surface = document.getElementById("surface");
        var surf = surface.value;
        alert(surf);
}



function afficher(){
		var saisie=document.getElementById("bouton").value;
		document.getElementById("texte1").value=saisie;
}

	/*Boucle if else pour tous les cas de figure (Vous vous êtes trompé !, Vous avez trouvé ! par rapport à motRandom*/
	if(mot!=motRandom){
		window.alert("Vous vous êtes trompé ! Ne vous découragez pas !");
		}
	else{
		window.confirm("Bravo. Vous avez trouvé ! ");
		window.location.reload(true);
	}
} 

