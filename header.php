<a href="index.php?lang=<?php echo($lang); ?>" class="logo">
	<img src="images/logo/logo_h.svg" alt="">
</a>

<a href="index.php?lang=<?php echo($lang); ?>" >
	<img class="logo2" src="images/logo/logo_2emeformat.svg">
</a>

<nav class="navbar">
	<ul class="navbar__link">
		<li><a href="apropos.php?lang=<?php echo($lang); ?>"><?php echo $aboutus [$lang]; ?></a></li>
		<li><a href="tatouages.php?lang=<?php echo($lang); ?>"><?php echo $tattoo [$lang]; ?></a></li>
		<li><a href="rendezvous.php?lang=<?php echo($lang); ?>"><?php echo $rdv [$lang]; ?></a></li>
		<li><a href="contact.php?lang=<?php echo($lang); ?>"><?php echo $contact [$lang]; ?></a></li>
	</ul>
</nav>

<!-- lors de la connexion cela permet d'afficher le dashboard du client concerné -->
<div class="icons">
	<?php if ( !isset($_SESSION['identification'])) : ?>
		<button class="btn" id="displayform">
			<i class="fa-solid fa-user"></i>
		</button>
	<!-- avec "role" la bdd vérifie si la personne connecté est un tatoueur ou un client
	mais lors de l'inscription le "role" est définis par défaut en "client"
	pour le définir en "tatoueur" il faut le faire manuellement dans la base de donnée -->
	<?php else : ?>
		<?php if ( $_SESSION["identification"]["role"] == 'client') : ?>
			<a class="btn" href="profil_utilisateur.php">
				<i class="fa-solid fa-user"></i>
			</a>
		<?php else : ?>
			<a class="btn" href="profil_tatoueur.php">
				<i class="fa-solid fa-user"></i>
				<span class="badge"></span>
			</a>
		<?php endif; ?>
	<?php endif; ?>

	<ul>
		<li id="lg"> langues
			<ul class="deux">
				<li class="francais"><a class="" href="?lang=fr">fr</a> </li>
				<li class="anglais"><a class="" href="?lang=en">en</a> </li>
			</ul>
		</li>
	</ul>

	<div class="fas fa-bars" id="menu-btn"></div>
</div>