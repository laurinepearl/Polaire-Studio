<!DOCTYPE html>

<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	include("php/requete_index.php");

	$pdo = getPDO();

	function commentaire ($pdo, $id)
	{
		$resultat = $pdo->query("SELECT * FROM `commentaire` WHERE `id_utilisateur` = '$id' ");
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

    $id = $_SESSION["identification"]["id_utilisateur"];
	$commentaires = commentaire($pdo, $id);


	//boucle pour créer des commentaires à l'infini
	$html = "";
	$moyenne = 0;
	$nbrecomment = count($commentaires);
	foreach($commentaires as $commentaire)
	{
		$moyenne = $moyenne + $commentaire["note"];
		$html.='<div>
		<hr>

		<h4>'.prenom ($pdo, $id).'</h4>

		<ul>
			' . etoiles($commentaire["note"]) . '
 		</ul>

		<p>'.$commentaire ["commentaire"].'</p>

		<div class="date">
			<span class="mois">'.$commentaire ["mois"].'</span>
			<span>'.$commentaire ["annee"].'</span>
		</div>

		<img id="profile" src="php/upload/'.$commentaire ["id_commentaire"].'.jpg" alt="" />

	</div>';

	}

	$moyenne = $moyenne / count($commentaires);
?>


<html lang="fr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="scss/profil/profil_utilisateur.css" />
		<link rel="stylesheet" href="scss/reset.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"/>

		<script src="https://kit.fontawesome.com/b2ac465a5f.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>

        <script src="js/script.js" defer></script>
		<script src="js/profil.js" defer></script>

		<title>Polaire Studio</title>
	</head>
	<body>

    <header class="header">
			<?php
				include("header.php");
			?>
		</header>

	<div class="container">

    <div class="identite">
        <h2> Bonjour</h2>
        <h3><?php echo(ucfirst($_SESSION["identification"]["prenom"])); ?></h3>
    </div>

    <div class="container-onglets">

        <div class="onglets">
            <i class="fa-solid fa-calendar-days"></i> Rendez-vous
        </div>

        <div class="onglets">
            <i class="fa-solid fa-comment"></i> Vos Commentaires

        </div>

        <form id="" action="php/deconnexion.php" method="POST">

        <?php
				if (isset($_GET["erreur"]))
				{
					echo($_SESSION["erreur"]);
				}
		?>

        <div class="deconnexion">
            <i class="fa-solid fa-power-off"></i>
            <input name="deconnexion" type="submit" onclick="if(!confirm('Voulez-vous vraiment vous déconnecter ?')) return false;" value="Déconnexion" />
            </div>
        </form>

    </div>

    <div class="container-body">
		<div class="illus">
			<img src="images/humaans.png" alt="" />
			<p> Cliquez sur un des onglets</p>
		</div>

        <div class="contenu rdv">
            <h3>Rendez-vous</h3>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur perspiciatis alias quod,
            dolores eum illum doloremque assumenda odio architecto, dolorum vitae nobis, quo deleniti ipsum.</p>
        </div>

        <div class="contenu com">
            <h3>Vos commentaires</h3>

            <section class="cinquieme">

			<article>
				<h3> Polaire Studio</h3>

				<span></span>

				<div class ="moyenne">
                    <span>
                        <?php
                            echo (floor($moyenne));
                        ?>
                    </span>
					<ul>
						<?php
							echo(etoiles ($moyenne));
						?>
					</ul>

					<p>
						<?php
							echo($nbrecomment);
						?>
					</p>

                    <span>
                        avis
                    </span>
				</div>

				<div>
					<?php
					echo($html);
					?>
				</div>

			</article>
		</section>
        </div>


        </div>
    </div>
</div>
	</body>
</html>