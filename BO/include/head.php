	<head>
		<!-- Si on le souhaite, on peut préciser dans index.php le titre souhaité ou encore le jeu de caractères et plein d'autres choses, comme les fichiers JS par exemple -->
		<meta  charset="<?php if(isset($charset)) echo $charset; else echo "utf-8";?>" />
		<?php if(isset($stylesheet)) echo "<link rel='stylesheet' href='$stylesheet' />\n";?>
		<title><?php if(isset($title)) echo $title; else echo "Modèle Portfolio";?></title>
		<link href="https://fonts.googleapis.com/css?family=Carter+One|Sigmar+One&display=swap" rel="stylesheet">
	</head>
