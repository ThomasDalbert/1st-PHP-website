<style type="text/css">

	body { 
		background: url("../../media/images/SirSinge.png") left fixed no-repeat ;
		background-size : 100% 100%;
		}
	#conteneur {
			width: 600px;
			height: 420px;
			border: 5px ridge grey;
			position : absolute;
			top : 25%;
			right : 50px;
			background: #FFF;
			text-align: center;
			}
	h1 {
			text-align: center;
	}


</style>

<script type="text/javascript">

var NBR_LIGNES = 5;
var NBR_BRIQUES_PAR_LIGNE = 12;
var BRIQUE_WIDTH = 48;
var BRIQUE_HEIGHT = 15;
var ESPACE_BRIQUE = 2;
var BARRE_JEU_WIDTH = 80;
var BARRE_JEU_HEIGHT = 10;
var ZONE_JEU_WIDTH = 600;
var ZONE_JEU_HEIGHT = 400;
var PXL_DEPLA = 12;
var COULEUR_BALLE = "#FFBF00";
var COULEUR_BRIQUES = "#01DFD7";
var COULEUR_BRIQUE_MAGIQUE = "rgb("+Math.floor(Math.random()*256)+","+Math.floor(Math.random()*256)+","+Math.floor(Math.random()*256)+")";
var DIMENSION_BALLE = 8;
var VITESSE_BALLE = 2;
var COULEUR_BARRE = "#333333";
var nbBriques = 0;
var briqueCasse = 0;

var tabBriques;
var barreX;
var barreY;
var context;
var lootX;
var lootY;
var balleX = 250;
var balleY = 200;
var dirBalleX = 1;
var dirBalleY = -1;
var boucleJeu;
var aGagne = 0;
var limiteBriques = (ESPACE_BRIQUE+BRIQUE_HEIGHT)*NBR_LIGNES;
var loot = 0;
var feu = 0;
var mitraille = 0;
var tir = 0;
var tirX;
var tirY;
var pos = 1;
var cooldown = 0;
var mur = 0;

var COULEUR_TIR = "#4B088A";

var ligneX2;
var ligneY2;




window.addEventListener('load', function()
{
	var elem = document.getElementById('canvasElem');
	if (!elem || !elem.getContext)
		{return;}

	context = elem.getContext('2d');
	if (!context)
		{return;}



	ZONE_JEU_WIDTH = elem.width;
	ZONE_JEU_HEIGHT = elem.height;
	barreX = (ZONE_JEU_WIDTH/2) - (BARRE_JEU_WIDTH/2);
	barreY = (ZONE_JEU_HEIGHT - BARRE_JEU_HEIGHT);



	creerBriques(context, NBR_LIGNES, NBR_BRIQUES_PAR_LIGNE, BRIQUE_WIDTH, BRIQUE_HEIGHT, ESPACE_BRIQUE);

	boucleJeu = setInterval(refreshGame, 10);

	window.document.onkeydown = checkDepla;


	//context.fillStyle = "pink";
	//context.fillRect(barreX, barreY, BARRE_JEU_WIDTH, BARRE_JEU_HEIGHT);

}, false);

function looter(x, y)
{
		if(loot == 0)
		{
			lootX = x;
			lootY = y;

		}

		loot = 1;
	
}

function missile(x, y)
{
	if(tir == 0)
	{
		tirX = x;
		tirY = y;
		if (pos == 1) pos = 2;
		else if (pos ==2 ) pos = 1;
	}
	tir = 1;
}

function refreshGame()
{

	if (nbBriques <= briqueCasse) aGagne = 1;

	clearContexte(context, 0, ZONE_JEU_WIDTH, 0, ZONE_JEU_HEIGHT);

	for (var i=0; i < tabBriques.length; i++)
	{
		context.fillStyle = COULEUR_BRIQUE_MAGIQUE;



		
		for (var j=0; j < tabBriques[i].length; j++)
		{
			if (tabBriques[i][j] == 1){
				context.fillRect((j*(BRIQUE_WIDTH+ESPACE_BRIQUE)), (i*(BRIQUE_HEIGHT+ESPACE_BRIQUE)), BRIQUE_WIDTH, BRIQUE_HEIGHT);
					
			}
		}
	}

	

	if (aGagne) gagne();

	if (mur == 1)
	{
		context.fillStyle = "#58FAF4";
		context.fillRect(0, (ZONE_JEU_HEIGHT-5), ZONE_JEU_WIDTH, 5);
	}


	context.fillStyle = COULEUR_BARRE;
	context.fillRect(barreX, barreY, BARRE_JEU_WIDTH, BARRE_JEU_HEIGHT);


context.fillStyle = COULEUR_BALLE;
context.beginPath();
context.arc(balleX, balleY, DIMENSION_BALLE, 0, Math.PI*2, true);
context.closePath();
context.fill();



	if(loot == 1)
	{
		context.fillStyle = "rgb("+Math.floor(Math.random()*256)+","+Math.floor(Math.random()*256)+","+Math.floor(Math.random()*256)+")";
		context.fillRect(lootX, lootY, 10, 10);
	}
	
	

if ( (lootY + 1) > ZONE_JEU_HEIGHT) loot = 0;
else if ( ((lootY + 1) > (ZONE_JEU_HEIGHT - BARRE_JEU_HEIGHT)) && (lootX >= barreX) && (lootX <= barreX+ BARRE_JEU_WIDTH) )
{
	if (loot == 1)
	bonus();
	loot = 0;
}

 lootY += 1;

 if(tir == 1)
 {
		context.fillStyle = COULEUR_TIR;
		context.fillRect(tirX, tirY, 5, 20);
	}


if ( (balleX + dirBalleX * VITESSE_BALLE) > ZONE_JEU_WIDTH) dirBalleX = -1;
else if ((balleX + dirBalleX * VITESSE_BALLE) < 0) dirBalleX = 1;
if ( (balleY + dirBalleY * VITESSE_BALLE) > ZONE_JEU_HEIGHT){
	if (mur == 1)
		{
			dirBalleY = -1;
			mur = 0;
		}
	else perdu();
}
else if ( (balleY + dirBalleY * VITESSE_BALLE) < 0) dirBalleY = 1;
else if ( ((balleY + dirBalleY * VITESSE_BALLE) > (ZONE_JEU_HEIGHT - BARRE_JEU_HEIGHT)) && ((balleX + dirBalleX * VITESSE_BALLE) >= barreX) && ((balleX + dirBalleX * VITESSE_BALLE) <= (barreX + BARRE_JEU_WIDTH)))
		{
			dirBalleY = -1;
			dirBalleX = 2*(balleX-(barreX + BARRE_JEU_WIDTH/2))/BARRE_JEU_WIDTH;
		}


if ( balleY <= limiteBriques)
{
	var ligneY = Math.floor(balleY/(BRIQUE_HEIGHT+ESPACE_BRIQUE));
	var ligneX = Math.floor(balleX/(BRIQUE_WIDTH+ESPACE_BRIQUE));
	if ( tabBriques[ligneY][ligneX] == 1)
	{
		briqueCasse ++;
		tabBriques[ligneY][ligneX] = 0;
		if (feu == 0){
		dirBalleY = 1;
	}
		looter(balleX, balleY);
	}
}

if ( tirY < 0 ){ 
	tir = 0;
}

if (tirY <= limiteBriques && tir == 1) 
{
	ligneY2 = Math.floor(tirY/(BRIQUE_HEIGHT+ESPACE_BRIQUE));
	ligneX2 = Math.floor(tirX/(BRIQUE_WIDTH+ESPACE_BRIQUE));

	if ( tabBriques[ligneY2] && tabBriques[ligneY2][ligneX2] == 1)
	{
		briqueCasse ++;
		tabBriques[ligneY2][ligneX2] = 0;
		tir = 0;
		
	}
	
		
}

if (tir == 1) tirY -= 3;

if (feu == 1)
{
	if (cooldown == 800){
		feu = 0;
		cooldown = 0;
		COULEUR_BALLE = "#FFBF00";
	}

	cooldown ++;

}

balleX += dirBalleX * VITESSE_BALLE;
balleY += dirBalleY * VITESSE_BALLE; 

}

function bonus()
{
	power = Math.floor(Math.random()*5)+1;

	if (power == 1) BARRE_JEU_WIDTH += 25;
	else if (power == 2) DIMENSION_BALLE += 4;
	else if (power == 3) {
		COULEUR_BALLE = "#FF4000";
		feu = 1
	}
	else if (power == 4) {
		if (mitraille == 1){
			COULEUR_BARRE = "#4B088A";
			mitraille = 2;
			COULEUR_TIR = "#64FE2E";
				}
		else if (mitraille == 0) {
			COULEUR_BARRE = "#FF0000";
			mitraille = 1;
		}
	}
	else if (power == 5){
		mur = 1;
	}
}
	



function perdu()
{
	clearInterval(boucleJeu);
	alert("PERDU GROS NAZE!");
}

function gagne()
{
	clearInterval(boucleJeu);
	alert("Gagné !");
}


function checkDepla(e)
{
	if (e.keyCode == 39) {
		if ( (barreX+PXL_DEPLA+BARRE_JEU_WIDTH) <= (ZONE_JEU_WIDTH + 20) ) barreX += PXL_DEPLA;
	}
	else if (e.keyCode == 37) {
		if ( ((barreX-PXL_DEPLA)) >= -20 )
			{
				barreX -= PXL_DEPLA;
				
			}
		}
	else if (e.keyCode == 32 && mitraille == 1) {
		missile((barreX+BARRE_JEU_WIDTH/2), (barreY - 10));
	}
	else if (e.keyCode == 32 && mitraille == 2) {
		if (pos == 1) missile (barreX, (barreY - 10));
		else if (pos == 2) missile ((barreX+BARRE_JEU_WIDTH-5), (barreY - 10));
	}
	
	
}

// !

function clearContexte(ctx, startwidth, ctxwidth, startheight, ctxheight)
{
	ctx.clearRect(startwidth, startheight, ctxwidth, ctxheight);
}

function nb_aleatoire(nb)
{
nombre= Math.floor(Math.random() * nb)+1;
} 


function creerBriques(ctx, nbrLignes, nbrParLigne, largeur, hauteur, espace)
{
	tabBriques = new Array(nbrLignes);


	nbBriques = 0;
	for (var i=0; i < nbrLignes; i++)
	{
		tabBriques[i] = new Array(nbrParLigne);
		
		ctx.fillStyle = COULEUR_BRIQUE_MAGIQUE;

		for (var j=0; j < nbrParLigne; j++)
		{	
			
			
			ctx.fillRect((j*(largeur+espace)), (i*(hauteur+espace)), largeur, hauteur);

			tabBriques[i][j] = 1;
			nbBriques++;
		}
	}

	return 1;
}

</script>

	

	<h1 style="color:white;">Casse briqu<span style="color:black;">e gentil</span></h1>
	<br/>
	<br/>
	<a href="index.php?page=casse_brique" style="color:white; font-size:24px">Recommencer</a>
	<br/><br/><br/><br/><br/><br/><br/>
	<div id="conteneur">
		<canvas id="canvasElem" width="600" height="400">
			l'affichaj bug manifestement
		</canvas>
	</div>

