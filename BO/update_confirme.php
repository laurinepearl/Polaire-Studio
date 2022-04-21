<?php
include "include/_session.php";
include "include/_connexion.php";
$stylesheet="css/portfolio.css";
?>
<!DOCTYPE html>
<html lang="fr">
<?php
include "include/head.php";
?>
<body>
<?php
include "veriflogin.php";
?>
			<?php //Doit être intégré dans un fichier EstClePrimaire.php à inclure si besoin 
				function EstClePrimaire($nom_champ) 
				{
					return strpos($nom_champ, "id_")===0;
				}
				// Récupération des informations
				$table_selectionnee = $_POST['table'];
				$id                = $_POST['id'];
				$cle_primaire      = '';
				$set               = [];
			?>

			<?php
				// On contrôle l'action demandée
				switch ($_POST['action']) {
					case 'insert':
						// Préparation des variables
						$colonnes = [];
						$values   = [];
						$columns_req = $bdd->query("SHOW COLUMNS FROM `$table_selectionnee`");
					    $lignes_columns = $columns_req->fetchAll();
					    foreach($lignes_columns as $column) {	// On ne compte pas les clés primaines
							if( !estClePrimaire($column['Field']) ) {
								$colonne = $column['Field']; // Le nom de la colonne
								$colonnes[] = "`$colonne`";
								$value = $_POST[ $colonne ]; // La valeur qui se trouve dans POST
								// Si la colonne n'est pas de type int...
								if( !strpos($column['Type'], 'int')) {
									// on les prend en convertissant le texte en code HTML (&...;)
									$value = htmlentities($value);
									$values[] = "\"$value\"";
								}
								else {
									// Sinon, on ne prend pas en compte les guillemets
									$values[] = $value;
								}
							}
						}
						// Exécution de la modification
						$colonnes = implode(',', $colonnes);
						$values = implode(',', $values);
						$insert_sql = $bdd->query("INSERT INTO `$table_selectionnee`($colonnes) VALUES($values)");
						echo "Ajout effectué.<br />";
						break;
					case 'update':
						// Récupération du nom de la clé primaire
						$columns_req = $bdd->query("SHOW COLUMNS FROM `$table_selectionnee`");
					    $lignes_columns = $columns_req->fetchAll();
					    foreach($lignes_columns as $column) {	// Si c'est une clé primaire, on la récupère
							if( estClePrimaire($column['Field']) )
								$cle_primaire = $column['Field'];
							// Sinon, on prépare pour modifier
							else {
								$colonne = $column['Field']; // Le nom de la colonne
								$value = $_POST[ $colonne ]; // La valeur qui se trouve dans POST

								// Si la colonne n'est pas de type int...
								if( !strpos($column['Type'], 'int') ) {
									// on les prend en convertissant le texte en code HTML (&...;)
									$value = htmlentities($value);
									$set[] = "`$colonne`=\"$value\"";
								}
								else {
									// Sinon, on ne prend pas en compte les guillemets
									$set[] = "`$colonne`=$value";
								}
							}
						}
						// Exécution de la modification
						$set = implode(',', $set);
						$insert_sql = $bdd->query("UPDATE `$table_selectionnee` SET $set WHERE `$cle_primaire`=$id");
						echo "Modifications effectuées.<br />";
						break;
					case 'delete':
						// Récupération de la clé primaire
						$columns_req = $bdd->query("SHOW COLUMNS FROM `$table_selectionnee`");
					    $lignes_columns = $columns_req->fetchAll();
					    foreach($lignes_columns as $column) {	// Si c'est une clé primaire, on la récupère
							if( estClePrimaire($column['Field']) )
								$cle_primaire = $column['Field'];
						}
						// Execution de la suppression
						$insert_sql = $bdd->query("DELETE FROM `$table_selectionnee` WHERE `$cle_primaire`=$id");
						echo "Suppression effectuée.<br />";
						break;		
					default: break;
				}

				?>	
				<form action="editable.php" method="POST">
					<input type="submit" name="valider" VALUE="<?php echo $table_selectionnee; ?>" />
				</form>

</body>
</html>