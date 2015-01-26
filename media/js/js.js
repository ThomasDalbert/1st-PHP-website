/* ------------------------ header ------------------------ */
$(".navbar-toggle").click(function(event) 
{
	$(".navbar-collapse").toggle('in');
});

$("#header_lien1").hover(function() {
	$(this).text("Chien sympa");
}).mouseout(function() {
	$(this).text("Chat sympa");
});

/* ------------------------ accueil ------------------------ */
$(function()
{
	var tempsEntre2Messages = 0;
	$("#accueil_contenu1, #accueil_contenu2").draggable();
	window.setInterval(function(){rafraichirMessages()}, 5000);

	// connexion
	$("#accueil_contenu2").on("click", "#accueil_submit", function()
	{
		// si le pseudo entré est - 1. non vide
		// 						  - 2. pas trop long
		if (typeof $("#accueil_nomUtilisateur").val() !== "undefined"
			&& $("#accueil_nomUtilisateur").val().length < 31)
			$.ajax({
				url: 'index.php?page=ajax',
				async: false,
				dataType: "html",
				data: { identifiant: $("#accueil_nomUtilisateur").val() },
				success: function(data)
				{
					$("#accueil_conteneurA").replaceWith(data);
				}
			});
	});

	// déconnexion
	$("#accueil_contenu2").on("click", "#accueil_deconnexion", function()
	{
		$.get(
			'index.php?page=ajax',
			{ deconnexion: "" },
			function(data)
			{
				$("#accueil_conteneurB").replaceWith(data);
			}
		);
	});

	// post de message
	$("#accueil_contenu2").on("click", "#accueil_submit", function()
	{
		// si le message - 1. a été posté suffisamment tard après le dernier
		//				 - 2. n'est pas nul
		//				 - 3. n'est pas trop long
		if (tempsEntre2Messages == 0
			&& $.trim($("#accueil_contenuMessage").val()) !== ""
			&& $("#accueil_contenuMessage").val().length < 251)
		{
			tempsEntre2Messages = 2;

			$.get(
				'index.php?page=ajax',
				{ message: $("#accueil_contenuMessage").val() },
				function(data)
				{
					$("#accueil_contenu1").html(data);
					$("#accueil_contenuMessage").val("");
				}
			);

			// oblige l'utilisateur à attendre "tempsEntre2Messages" secondes avant de pouvoir reposter
			console.log("Vous pourrez poster votre prochain message dans " + tempsEntre2Messages + "s...");
			var refreshInterval = window.setInterval(function() {
				if (tempsEntre2Messages == 0)
					window.clearInterval(refreshInterval);
				else {
					tempsEntre2Messages--;
					console.log("Vous pourrez poster votre prochain message dans " + tempsEntre2Messages + "s...");
				}
			}, 1000);
		}
	});
});

function rafraichirMessages() {
	$("#accueil_contenu1").load("index.php?page=accueil #accueil_contenu1Conteneur");
}

$(function() 
{
	var liste = [
	    "Abde kun",
	    "Anglezi",
	    "Arbre",
	    "Axelou J.Sercan",
	    "BendoubleD", 
	    "Bennasus",
	    "Bensalade",
	    "Bitaud Chan",
	    "bobyiii",
	    "bobyiiion",
	    "Bubu",
	    "Ching",
	    "Citron",
	    "Erkan",
	    "Fiflexx",
	    "Fiflon",
	    "Inspecteur CTI",
	    "Kébab",
	    "Guillaume Brault",
	    "JAD",
	    "J'aime la bite =)",
	    "Jean-Arbre",
	    "Jean-Aymeric Diet",
	    "Jean-Citron",
	    "Jean-Erkan",
	    "Jean-JAD",
	    "Jean-Lapin",
	    "Jean-Raskar",
	    "Jean-Singe",
	    "Jokkers",
	    "Jokkerz",
	    "Labna",
	    "M CHING",
	    "M SINJ",
	    "Pipiche",
	    "Raskar",
	    "Raskarkapak",
	    "Raskarpakatakfoekg",
	    "Sadourby",
	    "Sadourby Chan",
	    "Soudybar",
	    "Sydoubar",
	    "Saïmiri",
	    "Singe",
	    "Sinj",
	    "Turc",
	    "Ulbin",
	    "Walban",
	    "westlose"
	];

	$("#accueil_contenu2").on("click", "#accueil_nomUtilisateur", function()
	{
		$("#accueil_nomUtilisateur").autocomplete({
			source : liste
		});
	});
});

/* ------------------------ jeuquicassetout ------------------------ */
$("#jeuquicassetout_dagame").on("click", "#jeuquicassetout_submit", function()
{
	$.get(
		'index.php?page=ajax',
		{ identifiant2: $("#jeuquicassetout_nomUtilisateur").val() },
		function(data)
		{
			$("#jeuquicassetout_dagame").replaceWith(data);
		}
	);
});


/* ------------------------------ 4 ------------------------------ */


/* ----------------------- Google Analytics ----------------------- */
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-57968138-1', 'auto');
ga('require', 'displayfeatures');
ga('send', 'pageview');
ga('require', 'displayfeatures');