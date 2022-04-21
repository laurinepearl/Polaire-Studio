<?php

include "include/_session.php";
include "include/_connexion.php";
$stylesheet="css/back_office.css";
?>
<!DOCTYPE html>
<html lang="fr">
	<link rel="stylesheet" href="../scss/reset.css">
<?php
include "include/head.php";
?>
<body>
<?php
include "veriflogin.php";
?>

<section id="bo">

<h2>Back Office</h2>

<form method="POST" action="editable.php">
<?php

	$tables_req = $bdd->query("SHOW TABLES;");
	$lignes_tables = $tables_req->fetchAll();
	$retour_ligne = 0;
	foreach($lignes_tables as $ligne) {
			$retour_ligne++;
			if($retour_ligne%3==0)
				echo "<br/>\n";
			echo "\t<input type='submit' name='valider' value='".$ligne[0]."' style='height:100px;'>"."\n";
	}
?>
</form>
<section id="deco">
<form method="POST" action="deconnexion.php">
<input type='submit' name='Deco' value='Déconnexion' class="deconnexion" />
</section>
</form>
</section>
</body>
</html>
