<!DOCTYPE html>

<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	session_start();

    include("php/requete_index.php");

    if (empty($_SESSION["identification"]["id_utilisateur"]))
    {
        echo("Vous n'êtes pas connecté.");
        exit();
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

     <?php
     if (isset($_GET["message"]))
     {
         echo("<div class='snackbar'>Votre profil a bien été créé</div>\n");
     }

     if (isset($_GET["erreur"]))
     {
         echo($_SESSION["erreur"]);
     }
 ?>


	<div class="container">

    <div class="identite">
        <h2> Bonjour</h2>
        <h3><?php echo(ucfirst($_SESSION["identification"]["prenom"])); ?></h3>
    </div>

    <div class="container-onglets">
        <div class="onglets">
            <i class="fa-solid fa-calendar-days"></i>  <span> Rendez-vous </span>
        </div>

        <div class="onglets">
            <i class="fa-solid fa-comment"></i> <span> Messagerie </span>
            <span class="badge"></span>

        </div>

        <div class="onglets">
            <i class="fa-solid fa-user-pen"></i>

            <?php
                if (isset($_SESSION["identification"]) && $_SESSION["identification"]["role"] == "tatoueur") {
                        echo "<span> Mon profil </span>";
                    }
                else {
                        echo "<span> Créer mon profil </span>";
                    }
            ?>
            </span>
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

            <div class="horaire">
                <?php
                    $query = $pdo->prepare    ("SELECT * FROM `horaires` WHERE `id_utilisateur`= ?");
                    $query->execute([$_SESSION["identification"]["id_utilisateur"]]);

                    $horaires = $query->fetch();
                    $date = $horaires["debut_horaire"] + 1209600;

                    if (is_array($horaires) && $date > time()) {
                        $date = date("j/m/Y", $date);
                        $creneaux = json_decode($horaires["creneaux"]);
                    }
                ?>
                
                <h4>Horaires <?php if (is_string($date)) echo("(Jusqu'au $date)"); ?></h4>

                <form action="php/horaires.php" method="POST">
                    <input type="checkbox" class="btn btn-small" name="heure[]" value="1" <?php if (isset($creneaux) && is_numeric(array_search("1", $creneaux))) echo("checked") ?> />10h - 11h
                    <input type="checkbox" class="btn btn-small" name="heure[]" value="2" <?php if (isset($creneaux) && is_numeric(array_search("2", $creneaux))) echo("checked") ?> />11h - 12h
                    <input type="checkbox" class="btn btn-small" name="heure[]" value="3" <?php if (isset($creneaux) && is_numeric(array_search("3", $creneaux))) echo("checked") ?> />14h - 15h
                    <input type="checkbox" class="btn btn-small" name="heure[]" value="4" <?php if (isset($creneaux) && is_numeric(array_search("4", $creneaux))) echo("checked") ?> />15h - 16h
                    <input type="checkbox" class="btn btn-small" name="heure[]" value="5" <?php if (isset($creneaux) && is_numeric(array_search("5", $creneaux))) echo("checked") ?> />16h - 17h
                    <input type="checkbox" class="btn btn-small" name="heure[]" value="6" <?php if (isset($creneaux) && is_numeric(array_search("6", $creneaux))) echo("checked") ?> />17h - 18h
                    <input type="checkbox" class="btn btn-small" name="heure[]" value="7" <?php if (isset($creneaux) && is_numeric(array_search("7", $creneaux))) echo("checked") ?> />18h - 19h
                
                    <input type="submit" id="valider" value="Valider les horaires" />
                </form>                
            </div>

             <article class="recap">   
                <h4>Prochain Rendez-vous</h4>

                <?php 
				    $query = $pdo->prepare("SELECT * FROM `rendez_vous` WHERE id_tatoueur = ?;");
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

        <div class="contenu messagerie">

        <h3>Messagerie</h3>

        <input type="search" placeholder="Écrivez un prénom..." />

        <div>
            <?php
				include("dashboard.php");
	    	?>
        </div>

        </div>

        <div class="contenu prl">
            <h3>Mon profil</h3>


<!-- FONCTIONNALITÉ : Création du profil -->
            <form enctype="multipart/form-data" action="php/profil.php" method="POST">
            <p> Changer le style de la bordure </p>
            <ul class = "borde">
                        <li>
                            <input type="radio" id="pointe" name="border" value="point" <?php if(isset($tatoueur["border"]) && $tatoueur["border"] == "point"){ echo "checked";} ?>>
                            <label for="">bordure rectangulaire</label>
                        </li>

                        <li>
                            <input type="radio" id="rond" name="border" value="ron" <?php if(isset($tatoueur["border"]) && $tatoueur["border"] == "ron"){ echo "checked";} ?> >
                            <label for="">bordure arrondis</label>
                        </li>
            </ul>

            <p> Changer la couleur de fond </p>
            <input type="color" name="background" id="background" <?php if(isset($tatoueur['background_color'])){ echo "value='". $tatoueur['background_color'] ."'";} ?>/>

                <div>
                    <p> Votre photo de profil </p>
                    <input type="file" id="userfile1" name="userfile1">
                </div>

                <div>
                    <p> Prénom </p>
                    <input type="text" name="prenom" class="champs" id="register_prenom" autocomplete="false" placeholder="prénom..." <?php if(isset($tatoueur['prenom'])){ echo "value='". $tatoueur['prenom'] ."'";} ?>/>
                    <input type="color" name="text_color" id="text_color" <?php if(isset($tatoueur['couleur'])){ echo "value='". $tatoueur['couleur'] ."'";} ?>/>

                    <ul>
                        <li>
                            <input type="radio" id="Poppins" name="font" value="Poppins" <?php if(isset($tatoueur["font"]) && $tatoueur["font"] == "Poppins"){ echo "checked";} ?>>
                            <label for="">Poppins</label>
                        </li>
                        <li>
                            <input type="radio" id="Nothing" name="font" value="Nothing You Could Do" <?php if(isset($tatoueur["font"]) && $tatoueur["font"] == "Nothing You Could Do"){ echo "checked";} ?>>
                            <label for="">Nothing You Could Do</label>
                        </li>
                        <li>
                            <input type="radio" id="Bebas" name="font" value="Bebas Neue" <?php if(isset($tatoueur["font"]) && $tatoueur["font"] == "Bebas Neue"){ echo "checked";} ?>>
                            <label for="">Bebas Neue</label>
                        </li>
                        <li>
                            <input type="radio" id="Shadows" name="font" value="Shadows Into Light" <?php if(isset($tatoueur["font"]) && $tatoueur["font"] == "Shadows Into Light"){ echo "checked";} ?>>
                            <label for="">Shadows Into Light</label>
                        </li>
                    </ul>

                </div>

                <div>
                    <p> Style </p>

                    <ul>
                        <li>
                            <input type="checkbox" id="Japonais" name="style[]" value="Japonais" <?php if(isset($tatoueur["style"]) && strpos($tatoueur["style"], "Japonais") !== false){ echo "checked";} ?>>
                            <label for="">Japonais</label>
                        </li>
                        <li>
                            <input type="checkbox" id="Animé" name="style[]" value="Animé" <?php if(isset($tatoueur["style"]) && strpos($tatoueur["style"], "Animé") !== false){ echo "checked";} ?>>
                            <label for="">Animé</label>
                        </li>
                        <li>
                            <input type="checkbox" id="OldSchool" name="style[]" value="OldSchool" <?php if(isset($tatoueur["style"]) && strpos($tatoueur["style"], "OldSchool") !== false){ echo "checked";} ?>>
                            <label for="">Old school</label>
                        </li>
                    </ul>
                </div>

                <div>
                    <p>Couleur</p>

                    <ul>
                        <li>
                            <input type="checkbox" id="Couleurs" name="couleur[]" value="Couleurs" <?php if(isset($tatoueur["style_couleur"]) && strpos($tatoueur["style_couleur"], "Couleurs") !== false){ echo "checked";} ?>>
                            <label for="">Couleurs</label>
                        </li>
                        <li>
                            <input type="checkbox" id="NoirEtBlanc" name="couleur[]" value="NoirEtBlanc" <?php if(isset($tatoueur["style_couleur"]) && strpos($tatoueur["style_couleur"], "NoirEtBlanc") !== false){ echo "checked";} ?>>
                            <label for="">Noir et Blanc</label>
                        </li>
                    </ul>
                </div>
       
                <div>
                    <p>Taille</p>

                    <ul>
                        <li>
                            <input type="checkbox" id="Petit" name="taille[]" value="Petit" <?php if(isset($tatoueur["style_taille"]) && strpos($tatoueur["style_taille"], "Petit") !== false){ echo "checked";} ?>>
                            <label for="">Petit (10 - 20cm)</label>
                        </li>
                        <li>
                            <input type="checkbox" id="Moyen" name="taille[]" value="Moyen" <?php if(isset($tatoueur["style_taille"]) && strpos($tatoueur["style_taille"], "Moyen") !== false){ echo "checked";} ?>>
                            <label for="">Moyen (20 - 30cm)</label>
                        </li>
                        <li>
                            <input type="checkbox" id="Grand" name="taille[]" value="Grand" <?php if(isset($tatoueur["style_taille"]) && strpos($tatoueur["style_taille"], "Grand") !== false){ echo "checked";} ?>>
                            <label for="">Grand (30 - 40cm)</label>
                        </li>
                        <li>
                            <input type="checkbox" id="Plus" name="taille[]" value="Plus" <?php if(isset($tatoueur["style_taille"]) &&strpos($tatoueur["style_taille"], "Plus") !== false){ echo "checked";} ?>>
                            <label for="">Plus (40cm - et plus)</label>
                        </li>
                    </ul>
                </div>

                <div class="reseaux">
                    <p> Réseaux sociaux </p>

                    <div>
                        <input type="text" name="reseau1" class="champs" id="register_style" placeholder="..." <?php if(isset($tatoueur["reseau1"])){ echo "value='". $tatoueur['reseau1'] ."'";} ?>/>
                        <i class="fa-brands fa-instagram"></i>
                    </div>

                    <div>
                        <input type="text" name="reseau2" class="champs" id="register_style" placeholder="..." <?php if(isset($tatoueur["reseau2"])){ echo "value='". $tatoueur['reseau2'] ."'";} ?>/>
                        <i class="fa-brands fa-facebook"></i>
                    </div>
                </div>

                <div>
                    <p> Vos réalisations </p>
                    <input type="file" id="userfile2" name="realisations[]" multiple>
                    <input type="color" name="button_color" id="button" <?php if(isset($tatoueur['button_color'])){ echo "value='". $tatoueur['button_color'] ."'";} ?>/>
                </div>

                <div class="publier">
               <?php
                if ($_SESSION["identification"] && $_SESSION["identification"]["role"] == "tatoueur" && isset($tatoueur['id_profil'])) {
                        echo "<input type='hidden' name='id_utilisateur' value='$id'><input type='hidden' name='id_profil' value='".$tatoueur['id_profil']."'>";
                    }
                ?>
                    <button type="submit" name="submit">
                <?php
                if (is_array($tatoueur ?? "") && $_SESSION["identification"] && $_SESSION["identification"]["role"] == "tatoueur") {
                        echo "Mettre à jour";
                    }
                else {
                        echo "Publier";
                    }
                ?>
                </button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
	</body>
</html>