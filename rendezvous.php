<!DOCTYPE html>

<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/requete_index.php");

	$pdo = getPDO();
?>

<html lang="fr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="scss/rdv/rendezvous.css" />
		<link rel="stylesheet" href="scss/reset.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"/>

		<script src="https://kit.fontawesome.com/b2ac465a5f.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>

		<script src="js/script.js" defer></script>
		<script src="js/rdv.js" defer></script>

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
			<h1> <?php echo $rdv [$lang]; ?></h1>

			<p>
				<?php echo $contenu3 [$lang]; ?>
			</p>
		</section>
		<?php if (!isset($_SESSION['identification'])) : ?>
			<img src="images/humaans.png" alt="" />
		<?php endif; ?>

		<!-- Calendrier -->
		<?php if (isset($_SESSION['identification'])) : ?>
		<section class="deuxieme">
			<!-- <iframe src="https://koalendar.com/e/polaire-studio" width="100%" height="800px" name="iframe1" id="iframe1"></iframe> -->
				<!-- <form class="" action="" method="POST">
					<label>
						Veuillez saisir une date :
						<input type="date" name="">
					</label>

					<p><button>Envoyer</button></p>
				</form> -->
		<article class="gauche">
				<div class="container">
					<div class="tog">
       					 <div class="calendar-assets">
            				<h1 id="currentDate"></h1>
            					<div class="field">
                					<label for="date">Recherche une date</label>
                					<form class="form-input" id="date-search" onsubmit="return setDate(this)">
                    				<input type="date" class="text-field" name="date" id="date" required>
                   				 	<button type="submit" class="btn btn-small" title="Rechercher"><i class="fas fa-search"></i></button>
                					</form>
            			</div>
        			</div>
        <div class="calendar" id="table">
            <div class="hea">
                <div class="month" id="month-header">

                </div>
                <div class="buttons">
                    <button class="icon" onclick="prevMonth()" title="Mois précédent"><i class="fas fa-chevron-left"></i></button>
					<button class="btn" onclick="resetDate()" title="Jour actuel"><i class="fas fa-calendar-day"></i></button>
                    <button class="icon" onclick="nextMonth()" title=" Mois suivant"><i class="fas fa-chevron-right "></i></button>
                </div>
            </div>
        </div>
	  </div>
    </div>
	</article>

	<article class="droite">
		<p class="pasdedate">Aucune disponibilité pour cette date.</p>

		<?php
			$profils = $pdo->query("SELECT `prenom`, `id_utilisateur`, `id_profil` FROM `profil_tatoueur`;")->fetchAll();
			
			function findAvatar($id)
			{
				$files = scandir("php/upload/$id/");

				foreach ($files as $file)
				{
					if (strpos($file, "profil") !== false)
					{
						return "php/upload/$id/$file";
					}
				}

				return "";
			}

			function getHoraires($pdo, $id_utilisateur) {
				$query = $pdo->prepare("SELECT * FROM `horaires` WHERE id_utilisateur = ?;");
				$query->execute([$id_utilisateur]);

				return $query->fetch();
			}

			function getRendezVous($pdo) {
				return $pdo->query("SELECT * FROM `rendez_vous`;")->fetchAll();
			}

			function creerHoraire($pdo, $id_utilisateur) {
				$horaires = getHoraires($pdo, $id_utilisateur);
				$rendezvous = getRendezVous($pdo);

				$html = "<script>const rendezvous = " . json_encode($rendezvous) . "</script>";
				$date = $horaires["debut_horaire"];

				if ($date + 1209600 < time()) {
					// dépassement
					$html = '
						<button type="submit" class="heure">10h - 11h</button>
						<button type="submit" class="heure">11h - 12h</button>
						<button type="submit" class="heure">14h - 15h</button>
						<button type="submit" class="heure">15h - 16h</button>
						<button type="submit" class="heure">16h - 17h</button>
						<button type="submit" class="heure">17h - 18h</button>
						<button type="submit" class="heure">18h - 19h</button>
					';
				} else {
					// pas de dépassement
					$creneaux = json_decode($horaires["creneaux"]);

					if (is_array($creneaux)) {
						if (is_numeric(array_search("1", $creneaux)))
							$html .= "<button type='submit' class='heure'>10h - 11h</button>";
						
						if (is_numeric(array_search("2", $creneaux)))
							$html .= "<button type='submit' class='heure'>11h - 12h</button>";
						
						if (is_numeric(array_search("3", $creneaux)))
							$html .= "<button type='submit' class='heure'>14h - 15h</button>";
						
						if (is_numeric(array_search("4", $creneaux)))
							$html .= "<button type='submit' class='heure'>15h - 16h</button>";
						
						if (is_numeric(array_search("5", $creneaux)))
							$html .= "<button type='submit' class='heure'>16h - 17h</button>";
						
						if (is_numeric(array_search("6", $creneaux)))
							$html .= "<button type='submit' class='heure'>17h - 18h</button>";
						
						if (is_numeric(array_search("7", $creneaux)))
							$html .= "<button type='submit' class='heure'>18h - 19h</button>";
					}
				}

				return $html;
			}

			foreach ($profils as $profil) {
				echo('
					<div class=" total">
						<div class="identite">
							<img src="' . findAvatar($profil["id_profil"]) . '" alt="" />

							<div class="infos">
								<h2>' . $profil["prenom"] . '</h2>
								<h3> Tatoueuse </h3>
								<p> Mon talent et ma sensibilité sont là pour sublimer vos tatouages. </p>
							</div>
						</div>

						<div class="horaire" data-id="' . $profil["id_utilisateur"] . '">
							' . creerHoraire($pdo, $profil["id_utilisateur"]) . '
						</div>
					</div>
				');
			}

			if (isset($_GET["message"]) && $_GET["message"] == "1")
			{
				echo("<div class='snackbar'>Votre rendez-vous a bien été pris en compte.</div>\n");
			}
		?>
	</article>

	



				<?php else : ?>

				<p>Connectez-vous pour pouvoir prendre rendez-vous. <a class="form_co" href=""> Connectez-vous </a> </p>
			<?php endif; ?>
		</section>

		<section class="troisieme">
			<article class="social">
				<a class="btn" href="https://www.instagram.com/laurinepearl_/" target="_blank">
					<i class="fa-brands fa-instagram"></i>
				</a>

				<a class="btn" href="https://www.pinterest.fr/laurineferreira29/_saved/" target="_blank">
					<i class="fa-brands fa-pinterest"></i>
				</a>

				<a class="btn" href="https://www.facebook.com/laurine.ferreira.543" target="_blank">
					<i class="fa-brands fa-facebook"></i>
				</a>
			</article>
		</section>

		<?php
				include("messagerie.php");
		?>

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