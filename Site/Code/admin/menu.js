//au chargement de la page, on appelle la fonction montre()
window.onload=montre;
 
//affichage du menu déroulant et placement de ce dernier
function montre(id,affiche){
	var d = document.getElementById(id);
	//si on quitte un élément du menu
	if (d && !affiche) {
		d.style.display='none'; //on l'efface
		var c=d.parentNode; //son parent
		if (c.parentNode.parentNode.parentNode.tagName!='DIV'){  //si c'est un sous-menu, on rend à son parent les couleurs d'origine
			c.firstChild.style.color='#39f';
			c.firstChild.style.background='#fff';
		}
	}
	//sinon si on se mets sur un élément du menu
	else if (d && affiche){ 
		d.style.display='block'; //on l'affiche
		var c=d.parentNode; //son parent
		if (c.parentNode.parentNode.parentNode.tagName!='DIV'){ //si c'est un sous-menu, on donne à son parent les couleurs de survol
			c.firstChild.style.color='#fff';
			c.firstChild.style.background='#39f';
		}
	}
}