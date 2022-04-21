<!DOCTYPE html>

<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();
	include("php/requete_index.php");

    $pdo = getPDO();

    function clients ($pdo)
    {
        $resultat = $pdo->query("SELECT `id_utilisateur` FROM `connexion`; ");
		$resultat = $resultat->fetchAll();

		return $resultat;
    }

	function message ($pdo, $id)
	{
		$resultat = $pdo->query("SELECT * FROM `messagerie` WHERE `id_utilisateur` = '$id' OR `id_cible` = '$id' ORDER BY `id_message` ASC;");
		$resultat = $resultat->fetchAll();

		return $resultat;
	}

	function prenom2 ($pdo, $id)
	{
		$resultat = $pdo->query("SELECT `prenom` FROM `connexion` WHERE `id_utilisateur` = '$id' ");
		$resultat = $resultat->fetch();

		return $resultat["prenom"];
	}

	function role ($pdo, $id)
	{
		$resultat = $pdo->query("SELECT `role` FROM `connexion` WHERE `id_utilisateur` = '$id' ");
		$resultat = $resultat->fetch();

		return $resultat["role"];
	}

    $id = $_SESSION["identification"]["id_utilisateur"];
    $html3 = "";
    $clients = clients($pdo);

    foreach($clients as $client)
    {
        // On saute la création du message pour l'utilisateur connecté.
        if ($client["id_utilisateur"] == $id)
        {
            continue;
        }

        $messages = message($pdo, $client["id_utilisateur"]);

        // Si l'utilisateur du site n'a aucun message de créé.
        if (count($messages) == 0)
        {
            continue;
        }

        // Si l'utilisateur est un tatoueur.
        $role = role($pdo, $client ["id_utilisateur"]);

        if ($role == "tatoueur")
        {
            continue;
        }

        $html2 = "";

        foreach ($messages as $message)
        {
            $role = role($pdo, $message ["id_utilisateur"]);

            if ($role == 'tatoueur')
            {
                $html2.='
                    <div class="desti1">
                        <h4>'.prenom2 ($pdo, $message ["id_utilisateur"]).' </h4>
                        <p class="message tattoo">  '.$message ["message"].'</p>
                    </div>';
            }
            else
            {
                $html2.='
                    <div class="desti2">
                        <h4> '.prenom2 ($pdo, $message ["id_utilisateur"]).'</h4>
                        <p class="message client"> '.$message ["message"].'</p>
                    </div>';
            }
        }

       $html3.=' <section class="sixieme">
			<article>
				<div>
					<h3> Polaire Studio </h3>
				</div>

				<div>' . $html2 . '</div>

				<form class="envoie" action="php/messagerie_action.php" method="POST">
					<textarea name="message" placeholder= "Ecrivez votre message..." required></textarea>
					<input type="hidden" name="origine" value=' . $_SERVER['PHP_SELF'] .' />
                    <input type="hidden" name="cible" value=' . $client["id_utilisateur"] .' />
					<button type="submit" class="comment_m"> <i class="fa-solid fa-location-arrow"></i> </button>
				</form>
			</article>
		</section>';
     }
?>



<html lang="fr">
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="scss/profil/profil_tatoueur.css" />
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
            <i class="fa-solid fa-comment"></i> Messagerie
        </div>

        <div class="onglets">
            <i class="fa-solid fa-user-pen"></i>Créer mon profil
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

        <div class="contenu messagerie">


        <h3>Messagerie</h3>

        <div><?php echo ($html3); ?></div>

        </div>

        <div class="contenu prl">
            <h3>Mon profil</h3>

            <form enctype="multipart/form-data" action="php/profil.php" method="POST">
            <p> Changer la couleur de fond </p>
            <input type="color" name="background" id="background"/>

                <div>
                    <p> Votre photo de profil </p>
                    <input type="file" id="userfile1" name="userfile1">
                </div>

                <div>
                    <p> Prénom </p>
                    <input type="text" name="prenom" class="champs" id="register_prenom" autocomplete="false" placeholder="prénom..." />
                    <input type="color" name="text_color" id="text_color"/>

                    <ul>
                        <li>
                            <input type="radio" id="Poppins" name="font" value="Poppins">
                            <label for="">Poppins</label>
                        </li>
                        <li>
                            <input type="radio" id="Nothing" name="font" value="Nothing You Could Do">
                            <label for="">Nothing You Could Do</label>
                        </li>
                        <li>
                            <input type="radio" id="Bebas" name="font" value="Bebas Neue">
                            <label for="">Bebas Neue</label>
                        </li>
                        <li>
                            <input type="radio" id="Shadows" name="font" value="Shadows Into Light">
                            <label for="">Shadows Into Light</label>
                        </li>
                    </ul>

                </div>


                <div>
                    <p> Style </p>
                    <input type="text" name="style" class="champs" id="register_style" autocomplete="false" placeholder="style de votre univers..." />
                    <input type="color" name="button_color" id="button"/>
                </div>

                <div class="reseaux">
                    <p> Réseaux sociaux </p>

                    <div>
                        <input type="text" name="reseau1" class="champs" id="register_style" placeholder="..." />
                        <i class="fa-brands fa-instagram"></i>
                    </div>

                    <div>
                        <input type="text" name="reseau2" class="champs" id="register_style" placeholder="..." />
                        <i class="fa-brands fa-facebook"></i>
                    </div>
                </div>

                <div>
                    <p> Vos réalisations </p>
                    <input type="file" id="userfile2" name="realisations[]" multiple>
                </div>

                <div class="publier">
                    <button type="submit" name="submit">Publier</button>
                </div>
            </form>
        </div>



        </div>
    </div>
</div>
	</body>
</html>