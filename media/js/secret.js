// "Character" CLASS -->
function Character(nom, picture, position, zedIndex) {
	this.nom = nom;
	this.position = position;
	this.picture = picture;
	this.zedIndex = zedIndex;

	// create and display the character into the HTML page
	$("<span id=\"" + nom + "\" class=\"character\"></span>").appendTo("#characters");
	this.displayCharacter();
}

Character.prototype = {
	moveToPosition : function() {
		// TODO
	},
	millAround : function() {
		// TODO
	},
	getToPosition : function(e) {
		if ($("#" + this.nom).is(":animated")) {
			this.position.x = $(this).css.left;
			this.position.y = $(this).css.top;
			this.refreshPosition;
			$("#" + this.nom).stop(true, true);
			console.log("animating");
		}

		$("#" + this.nom)
		.animate({
			left: e.clientX - 13,
			top: e.clientY - 13
		});

		this.position.x = e.clientX - 13;
		this.position.y = e.clientY - 13;
		// this.refreshPosition();
	},
	teleportToClickPosition : function(e) {
		this.position.x = e.clientX - 13;
		this.position.y = e.clientY - 13;
		this.refreshPosition();
	},

	refreshImage : function() {
		$("#" + this.nom).css("background-image", this.picture);
	},
	refreshPosition : function() {
		$("#" + this.nom).css({left: this.position.x, top: this.position.y});
	},
	refreshZIndex : function() {
		$("#" + this.nom).css("zIndex", this.zedIndex);
	},
	displayCharacter : function() {
		this.refreshImage();
		this.refreshPosition();
		this.refreshZIndex();
	}
};
// <-- "Character" CLASS

// "Coordinates" CLASS -->
function Coordinates(character, bg_color, position, rotation) {
	this.character = character;
	this.bg_color = bg_color;
	this.position = position || { x:"0", y:"0" };
	this.rotation = rotation || "rotate(0deg)";

	this.nom = "coordinates_" + character.nom,

	// create and display the coordinates into the HTML page
	$("<span id=\"" + this.nom + "\" class=\"coordinates\"></span>").appendTo("#coordinates");
	this.displayCoord();
}

Coordinates.prototype = {
	turnText : function(e) {
		var characterX = this.character.position.x + 13,
				clickX = e.clientX,
			characterY = this.character.position.y + 13,
				clickY = e.clientY;
			
		switch (true) {
		case ((clickX < characterX)
				&& (clickY < characterY)) :
			this.rotation = "rotate(-30deg)";
			break;

		case ((clickX > characterX)
				&& (clickY < characterY)) :
			this.rotation = "rotate(30deg)";
			break;

		case ((clickX < characterX)
				 && (clickY > characterY)) :
			this.rotation = "rotate(-150deg)";
			break;

		case ((clickX > characterX)
				&& (clickY > characterY)) :
			this.rotation = "rotate(150deg)";
			break;
		}
		this.refreshRotation();
	},
	actualizeCoord : function(e) {
		this.actualizeText();
		this.turnText(e);
	},

	refreshColor : function() {
		$("#" + this.nom).css("backgroundColor", this.bg_color);
	},
	refreshPosition : function() {
		$("#" + this.nom).css({ left: this.position.x, top: this.position.y });
	},
	refreshRotation : function() {
		$("#" + this.nom).css("transform", this.rotation);
	},
	actualizeText : function() {
		$("#" + this.nom).text("left : " + (this.character.position.x + 13) + " - top : " + (this.character.position.y + 13));
	},
	displayCoord : function() {
		this.refreshColor();
		this.refreshPosition();
		this.refreshRotation();

		this.actualizeText();
	}
};
// <-- "Coordinates" CLASS


// "Case" CLASS -->
function Case(position) {
	this.position = position || { x:"0", y:"0" };
	
	this.nom = "case" + this.position.x + "" + this.position.y;

	// create and display the case into the HTML page
	$("<span id=\"" + this.nom + "\" class=\"cases\"></span>").appendTo("#cases");
	this.displayCase();
}

Case.prototype = {
	displayCase : function() {
		$("#" + this.nom).css({ left: this.position.x, top: this.position.y });
	}
};
// <-- "Case" CLASS


// "Grille" CLASS -->
function Grille() {
	
}

Grille.prototype = {
	
};
// <-- "Grille" CLASS


// Main
var character  = new Character("character", "url(media/images/page4/cercle2b.png)", { x:300, y:200 }, 3),
	character2 = new Character("character2","url(media/images/page4/cercle1b.png)", { x:780, y:150 }, 2),
	character3 = new Character("character3", "url(media/images/page4/cercle3b.png)",  { x:13, y:13 }, 1),

	case1 = new Case();

	coords  = new Coordinates(character, "rgb(237, 28, 36)",  { x:1024, y:300 }),
	coords2 = new Coordinates(character2, "rgb(0, 162, 232)", { x:1024, y:150 }),
	coords3 = new Coordinates(character3, "rgb(34, 177, 76)", { x:1024, y:450 });

$(document).ready(function() {
	// var leftClicking = false;

	$("body").mousedown(function(e) {
		if (e.which == 1) {
			$(this).css("cursor", "default");
			// leftClicking = true;

			coords2.actualizeCoord(e);
			character2.getToPosition(e);
		}
	});
	// .mouseup(function() {
	// 	leftClicking = false;
	// });
	//
	// $("body").mousemove(function(e) {
	// 	if (leftClicking) {
	// 		coords.actualizeCoord(e);
	// 		character.getToPosition(e);
	// 	}
	// });
});