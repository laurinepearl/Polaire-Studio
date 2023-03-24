<?php

	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	if (!isset($_SESSION))
	{
		session_start();
	}

	include("php/requete_index.php");

    $pdo = getPDO();


    function clients ($pdo)
    {
        $resultat = $pdo->query ('SELECT `id_utilisateur` FROM `messagerie` GROUP BY `id_utilisateur` ORDER BY MAX(`id_message`)
        DESC');
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
	function getTatoueur ($pdo, $id)
	{
		$resultat = $pdo->query("SELECT * FROM `profil_tatoueur` WHERE `id_utilisateur` = '$id' ");
		$resultat = $resultat->fetch();

		return $resultat;
	}

	function sendimage($id)
	{
		$files = scandir("php/upload/messages/");

		foreach ($files as $file)
		{
			if (strpos($file, "$id.") !== false)
			{
				return "php/upload/messages/$file";
			}
		}

		return "";
	}

    $id = $_SESSION["identification"]["id_utilisateur"];
    $html3 = "";
    $clients = clients($pdo);

    if ($_SESSION["identification"] && $_SESSION["identification"]["role"] == "tatoueur") {
        $tatoueur = getTatoueur($pdo, $id);
    }

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
// FONCTIONNALITÉ : messagerie
       	foreach ($messages as $message)
        {
            $role = role($pdo, $message ["id_utilisateur"]);

			if ($role == 'tatoueur') {
                $html2.='<div class="desti1">';
			} else {
				$html2.='<div class="desti2">';
            }

			$html2 .= '<h4>'.prenom2 ($pdo, $message ["id_utilisateur"]).' </h4>';
			$image = sendimage($message ["id_message"]);

			if ($image == "") {
				$html2 .= '
					<p class="message tattoo">  '.$message ["message"].'</p>
				';
			} else {
				if ($message ["message"] == "") {

					$html2 .= '
						<img src="' . sendimage($message ["id_message"]) . '" alt="" style="width: 150px;height: 180px;">
					';
				} else {

					$html2 .= '
						<p class="message tattoo">  '.$message ["message"].'</p>
						<img src="' . sendimage($message ["id_message"]) . '" alt="" style="width: 150px;height: 180px;">
					';
				}
			}

			$html2 .= '</div>';
        }

       $html3.=' <section class="sixieme">
			<article>
				<div>
					<h3 class="prenom">' . ucfirst(prenom2 ($pdo, $client ["id_utilisateur"])) . '</h3>
				</div>

				<div>' . $html2 . '</div>

				<form class="envoie" enctype="multipart/form-data" action="php/messagerie_action.php" method="POST">
					<textarea name="message" placeholder= "Ecrivez votre message..."></textarea>

					<input type="hidden" name="origine" value="' . ($_POST["origine"] ?? $_SERVER['PHP_SELF']) . '" />
                    <input type="hidden" name="cible" value="' . $client["id_utilisateur"] .'" />

                    <label>
						<i class="fa-solid fa-plus" style="font-size: 24px; border: 1px solid black; padding: 16px 10px 16px 10px; "></i>
						<input name="userfile3" type="file" style=" display: none; visibility: none;" />
					</label>

					<button type="submit" class="comment_m"> <i class="fa-solid fa-location-arrow"></i> </button>
				</form>
			</article>
		</section>';
     }

	 echo($html3);
?>
