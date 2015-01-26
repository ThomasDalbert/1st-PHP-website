

    <div class="container">
      <div class="row">
      	<div id="accueil_contenu1" class="col-lg-5">
      		<span id="accueil_contenu1Conteneur">
			<?php
				foreach ($identifiantMessages as $id)
				{
					echo "<div> <span class=\"accueil_auteurEtHeureMessage\">".
					SPDO::getInstance()->query($sql->auteurMessages($id['0']))['0']['0']. " [".
					SPDO::getInstance()->query($sql->heureMessages($id['0']))['0']['0']. "] : </span>";
					echo "<span class=\"accueil_contenuMessage\">".
					SPDO::getInstance()->query($sql->contenuMessages($id['0']))['0']['0']. "</span> </div>";
				}
			?>
			</span>
		</div>
		<div id="accueil_contenu2" class="col-lg-push-1 col-lg-5">
			<form action="">
				<?php
					if (!isset($_SESSION['identifiant']))
					{
				?>
					<span id="accueil_conteneurA">
						<label class="accueil_label" for="identifiant">Nom utilisateur : </label>
						<input id="accueil_nomUtilisateur" type="text" class="form-control" name="identifiant">
					</span>
				<?php
					}
					else
					{
				?>
					<span id="accueil_conteneurB">
						<a id="accueil_deconnexion">Changer de nom (<?php echo $_SESSION['identifiant'];?>)</a>
						<br/><br/>
					</span>
				<?php
					}
				?>
				<label class="accueil_label" for="identifiant">Message gentil : </label>
				<textarea id="accueil_contenuMessage" rows="4" class="form-control" type="textarea"></textarea>
				<button id="accueil_submit" onclick="return false;" class="btn btn-lg btn-primary btn-block">Envoyer</button>
			</form>
		</div>
      </div>
    </div>
