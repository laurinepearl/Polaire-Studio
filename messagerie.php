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


	if (isset($_SESSION["identification"]["id_utilisateur"]))
	{
		$id = $_SESSION["identification"]["id_utilisateur"];
		$messages = message($pdo, $id);

		$html2 = "";
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
	}
?>



<?php if (isset($_SESSION['identification'])) : ?>
		<section class="sixieme">
			<article>
				<div>
					<button type="button" class="fleche"><i class="fa-solid fa-arrow-left"></i></button>
					<h3> Polaire Studio </h3>
				</div>

				<div>
					<?php
						echo($html2);

					?>
				</div>

				<form class="envoie" enctype="multipart/form-data" action="php/messagerie_action.php" method="POST">
					<textarea name="message"  placeholder= "Ecrivez votre message..." ></textarea>

					<?php if (isset($_POST["origine"])) : ?>
						<input type="hidden" name="origine" value="<?= $_POST["origine"] ?>" />
					<?php else : ?>
						<input type="hidden" name="origine" value="<?= $_SERVER['PHP_SELF'] ?>" />
					<?php endif; ?>

					<label>
						<i class="fa-solid fa-plus" style="font-size: 24px; border: 1px solid black; padding: 16px 10px 16px 10px; "></i>
						<input name="userfile3" type="file" style=" display: none; visibility: none;">
					</label>

					<button type="submit" class="comment_m"> <i class="fa-solid fa-location-arrow"></i> </button>
				</form>
			</article>
		</section>

	<?php if ( $_SESSION["identification"]["role"] == 'client') : ?>
		<button type="button" id="messagerie">
			<i class="fa-solid fa-comment-dots"></i>
			<span class="badge"></span>
		</button>
	<?php endif; ?>
<?php endif; ?>