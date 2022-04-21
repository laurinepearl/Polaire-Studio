<!DOCTYPE html>

<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/requete_index.php");

	$pdo = getPDO();

	function commentaire ($pdo)
	{
		$resultat = $pdo->query("SELECT * FROM `commentaire`");
		$resultat = $resultat->fetchAll();

		return $resultat;
	}

	function prenom ($pdo, $id)
	{
		$resultat = $pdo->query("SELECT `prenom` FROM `connexion` WHERE `id_utilisateur` = '$id' ");
		$resultat = $resultat->fetch();

		return $resultat["prenom"];
	}

	// Génération des étoiles.
	function etoiles($nombre): string
	{
		$html = "";

		for ($indice = 1; $indice <= 5; $indice++)
		{
			$class = $indice <= $nombre ? "fa-solid" : "fa-regular"; // L'étoile est active ?

			$html .= "<li><i class=\"$class fa-star\"></i></li>";
		}

		return $html;
	}

	function findAvatar($id)
	{
		$files = scandir("php/upload/");

		foreach ($files as $file)
		{
			if (strpos($file, "$id.") !== false)
			{
				return "php/upload/$file";
			}
		}

		return "";
	}

	$commentaires = commentaire($pdo);

	//boucle pour créer des commentaires à l'infini
	$html = "";
	$moyenne = 0;
	$nbrecomment = count($commentaires);
	foreach($commentaires as $commentaire)
	{
		$moyenne = $moyenne + $commentaire["note"];
		$html.='<div>
		<hr>

		<h4>'.prenom ($pdo, $commentaire ["id_utilisateur"]).'</h4>

		<ul>
			' . etoiles($commentaire["note"]) . '
 		</ul>

		<p>'.$commentaire ["commentaire"].'</p>

		<div class="date">
			<span class="mois">'.$commentaire ["mois"].'</span>
			<span>'.$commentaire ["annee"].'</span>
		</div>

		<img src="' . findAvatar($commentaire ["id_commentaire"]) . '" alt="">

	</div>';

	}

	$moyenne = $moyenne / count($commentaires);
?>

<html lang="fr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="scss/apropos/apropos.css" />
		<link rel="stylesheet" href="scss/reset.css">

		<script src="https://kit.fontawesome.com/b2ac465a5f.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>

		<script src="js/script.js" defer></script>
		<script src="js/apropos.js" defer></script>

		<title>Polaire Studio</title>
	</head>
	<body>
		<header class="header">
			<?php
				include("header.php");
			?>
		</header>

		<section id="co">
			<?php
				include("connexion.php");

			?>
		</section>

		<section class="premiere">
			<h1> <?php echo $aboutus [$lang]; ?></h1>

			<article>
				<h2><?php echo $approche [$lang]; ?></h2>
				<p><?php echo $contenu4 [$lang]; ?></p>
			</article>

			<article>
				<h2><?php echo $reflexion [$lang]; ?></h2>
				<p><?php echo $contenu5 [$lang]; ?></p>
			</article>
		</section>

		<section class="deuxieme">
			<h2> <?php echo $salon [$lang]; ?> </h2>

			<article>
				<img class="myImg" src="images/salon3.jpg" alt="">
				<img class="myImg" src="images/tattooshop.jpg" alt="">
				<img class="myImg" src="images/salon2.jpg" alt="">
			</article>

			<article>
				<img class="myImg" src="images/salon4.jpg" alt="">
				<img class="myImg" src="images/salon.jpg" alt="">
				<img class="myImg" src="images/encre.jpg" alt="">
			</article>

			<div id="myModal" class="modal">

				<span class="close">&times;</span>

				<img class="modal-content" id="img01">

				<div id="caption"></div>
			</div>
		</section>

		<section class="cinquieme">
			<h2>Commentaires de nos Clients</h2>

			<article>
				<h3> Polaire Studio</h3>

				<button type="submit" class="comment_d"> Donner un avis </button>
				<button type="submit" class="comment_m"><i class="fa-solid fa-comment-dots"></i> </button>

				<span></span>

				<div class ="moyenne">
					<ul>
						<li><?php echo(floor($moyenne)); ?>
						<?php
							echo(etoiles ($moyenne));
						?>
					</ul>
					<p>
						<?php
							echo($nbrecomment) . " avis";
						?>
					</p>
				</div>

				<div>
					<?php
					echo($html);
					?>
				</div>

			</article>
		</section>



<?php
				if (isset($_GET["message"]))
				{
					echo("<div class='snackbar'>Votre commentaire a été posté.</div>\n");
				}

				if (isset($_GET["erreur"]))
				{
					echo($_SESSION["erreur"]);
				}
			?>

		<section class="quatrieme">
			<h2>Commentaires de nos Clients</h2>
			<?php if (isset($_SESSION['identification'])) : ?>
			<article>
			<button type="button" class="fleche"><i class="fa-solid fa-arrow-left"></i></button>
				<h3>Polaire Studio</h3>

				<form class="comment" enctype="multipart/form-data" action="php/commentaire.php" method="POST">
					<h4><?php echo(ucfirst($_SESSION["identification"]["prenom"])); ?></h4>

					<select name="etoile" id="etoile">
						<option value="1">1 étoile</option>
						<option value="2">2 étoiles</option>
						<option value="3">3 étoiles</option>
						<option value="4">4 étoiles</option>
						<option value="5">5 étoiles</option>
					</select>


					<textarea name="commentaire" placeholder= "Partager votre expérience concernant ce lieu" required> </textarea>

					<br>

					<fieldset class="">
						<legend class="">Date de la visite</legend>

						<select name="mois" class="visite" aria-label="Month">
							<option value="Janvier">Janvier</option>
							<option value="Février">Février</option>
							<option value="Mars">Mars</option>
							<option value="Avril">Avril</option>
							<option value="Mai">Mai</option>
							<option value="Juin">Juin</option>
							<option value="Juillet">Juillet</option>
							<option value="Août">Août</option>
							<option value="Septembre">Septembre</option>
							<option value="Octobre">Octobre</option>
							<option value="Novembre">Novembre</option>
							<option value="Décembre">Décembre</option>
						</select>

						<label for="" class="">
							<span class=""></span>
						</label>
					</fieldset>

					<fieldset class="">
						<select name="annee"class="visite" aria-label="Année">
							<option value="2000">2000</option>
							<option value="2001">2001</option>
							<option value="2002">2002</option>
							<option value="2003">2003</option>
							<option value="2004">2004</option>
							<option value="2005">2005</option>
							<option value="2006">2006</option>
							<option value="2007">2007</option>
							<option value="2008">2008</option>
							<option value="2009">2009</option>
							<option value="2010">2010</option>
							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
							<option value="2015">2015</option>
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
							<option value="2021">2021</option>
							<option value="2022" selected=>2022</option>
						</select>

						<label for="" class="">
							<span class=""></span>
						</label>
					</fieldset>

					<input id="idfile" name="userfile" type="file"/>

					<input type="hidden" name="id_utilisateur" value="<?php echo $_SESSION['identification']['id_utilisateur']; ?>">
					<button type="button">Annuler</button>
					<button type="submit">Publier </button>
				</form>
			</article>

			<?php else : ?>
				<p>Connectez-vous pour pouvoir laisser un commentaire. <a class="form_co" href=""> Connectez-vous </a> </p>
			<?php endif; ?>
		</section>



		<?php
				include("messagerie.php");

		?>

		<section class="troisieme">
			<article class="social">
				<a class="btn" href="https://www.instagram.com/laurinepearl_/">
					<i class="fa-brands fa-instagram"></i>
				</a>

				<a class="btn" href="https://www.pinterest.fr/laurineferreira29/_saved/">
					<i class="fa-brands fa-pinterest"></i>
				</a>

				<a class="btn" href="https://www.facebook.com/laurine.ferreira.543">
					<i class="fa-brands fa-facebook"></i>
				</a>
			</article>
		</section>




		<a id="remonter" href="#" >
			<i class="fas fa-chevron-up"></i>
		</a>

		<footer>
			<?php
				include("footer.php");
			?>
		</footer>
	</body>
</html>