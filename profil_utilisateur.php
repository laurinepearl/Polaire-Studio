<!DOCTYPE html>

<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

	if (empty($_SESSION["identification"]["id_utilisateur"]))
    {
        echo("Vous n'êtes pas connecté.");
        exit();
    }

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

		<h4>'.prenom ($pdo, $id).'</h4>

		<ul>
			' . etoiles($commentaire["note"]) . '
 		</ul>

		<p>'.$commentaire ["commentaire"].'</p>

		<div class="date">
			<span class="mois">'.$commentaire ["mois"].'</span>
			<span>'.$commentaire ["annee"].'</span>
		</div>

		<img id="profile" src="php/upload/commentaires/'.$commentaire ["id_commentaire"].'.jpg" alt="" />

	</div>';

	}

	if ($nbrecomment > 0) {
	$moyenne = $moyenne / $nbrecomment;
	} else {
		$moyenne = 0;
	}


	$html5 = "";

	if (file_exists("php/upload/idees/$id/"))
	{
		$photos = scandir("php/upload/idees/$id/");

		foreach ($photos as $photo)
		{
			if ($photo == ".." or $photo == "." or $photo == ".DS_Store")
				continue;

			$html5 .= "<div class='column'><img src='php/upload/idees/$id/" . $photo . "' alt=''></img></div>";
		}
	}
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
		<script>
			const email_value = "<?php echo($_SESSION["identification"]["email"]); ?>";
		</script>

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
            <i class="fa-solid fa-calendar-days"></i> <span> Rendez-vous </span>
        </div>

        <div class="onglets">
            <i class="fa-solid fa-comment"></i> <span> Vos Commentaires </span>
        </div>

		<div class="onglets">
			<i class="fa-regular fa-lightbulb"></i> <span> Vos Idées </span>
        </div>


        <form id="" action="php/suppression.php" method="POST">
            <div class="suppression" onclick="if(!confirm('Voulez-vous vraiment supprimer ce compte ?')) return false; else this.parentNode.submit()">
                <i class="fa-solid fa-trash-can"></i>
                <input name="suppression" type="submit"  value="Supprimer" />
            </div>
        </form>

        <form id="" action="php/deconnexion.php" method="POST">

        <?php
				if (isset($_GET["erreur"]))
				{
					echo($_SESSION["erreur"]);
				}
		?>

			<div class="deconnexion" onclick="if(!confirm('Voulez-vous vraiment vous déconnecter ?')) return false; else this.parentNode.submit()">
           	 	<i class="fa-solid fa-power-off"></i>
            	<input name="deconnexion" type="submit"  value="Déconnexion" />
            </div>
        </form>

    </div>

    <div class="container-body">
		<div class="illus">
			<img src="images/humaans2.png" alt="" />
			<p> Cliquez sur l'un des onglets</p>
		</div>

        <div class="contenu rdv">
            <h3>Rendez-vous</h3>
			<article class="recap">   
                <h4>Prochain Rendez-vous</h4>

                <?php 
				    $query = $pdo->prepare("SELECT * FROM `rendez_vous` WHERE id_utilisateur = ?;");
                    $query->execute([$_SESSION["identification"]["id_utilisateur"]]);

                    $rendezvous = $query->fetchAll();

                    foreach ($rendezvous as $value) {
                        echo('
                            <div class="recap_entier"> 
                                <h4>Polaire Studio</h4>
                                
                                <p>15 Avenue de la République - Nice, salon de tatouage. </p>

                                <div class="client"> 
                                    <h4>' . $value["prenom"] . '<br />' . $value["email"] . '<br />' . $value["phone"] . '</h4>
                                    <p>' . $value["horaires"] . '</p> 
                                </div>
                            </div>
                        ');
                    }
                ?>
            </article> 
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

		<div class="contenu idee">
           	<h3>Vos Idées</h3>

			<form class="idees" enctype="multipart/form-data" action="php/vosidees.php" method="POST">
				<input type="hidden" name="origine" value="<?= $_SERVER['PHP_SELF'] ?>" />	
				<input id="idee" name="realisations[]" type="file"  multiple /> 
				<button type="submit" name="submit"> Publier </button>
			</form>

			<section id="galerie">
				<article class="row">
					<?php echo($html5); ?>
				</article>
			</section>
        </div>

     </div>
   </div>
</div>
	</body>
</html>