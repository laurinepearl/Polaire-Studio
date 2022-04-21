<?php

ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

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

	if (isset($_SESSION["identification"]["id_utilisateur"]))
	{
		$id = $_SESSION["identification"]["id_utilisateur"];
		$messages = message($pdo, $id);

		$html2 = "";
		foreach($messages as $message)
		{
			$role = role ($pdo, $message ["id_utilisateur"]);
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

				<form class="envoie" action="php/messagerie_action.php" method="POST">
					<textarea name="message"  placeholder= "Ecrivez votre message..." required ></textarea>
					<input type="hidden" name="origine" value="<?= $_SERVER['PHP_SELF'] ?>" />
					<button type="submit" class="comment_m"> <i class="fa-solid fa-location-arrow"></i> </button>
				</form>
			</article>
		</section>

	<button type="button" id="messagerie">
		<i class="fa-solid fa-comment-dots"></i>
	</button>
<?php endif; ?>