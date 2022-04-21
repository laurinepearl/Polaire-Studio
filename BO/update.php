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
			<?php
				function EstClePrimaire($nom_champ) 
				{
					return strpos($nom_champ, "id_")===0;
				}	
				// Récupération des informations
				$table_selectionnee = $_POST['table'];
				$id                = $_POST['id'];
				$cle_primaire      = '';
			?>
			<form action="update_confirme.php" method="POST" >
				<input type="hidden" name="table" value="<?php echo $table_selectionnee; ?>" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<?php
// S'il s'agit d'un ajout (insert)
				if( isset($_POST['insert']) ) {
					echo "\t<input type=\"hidden\" name=\"action\" value=\"insert\" />";
					// Récupération des colonnes
					$columns_req = $bdd->query("SHOW COLUMNS FROM $table_selectionnee");
					$lignes_columns = $columns_req->fetchAll();
					echo "\n\t\t\t<table>";
					foreach($lignes_columns as $column) {
						// On n'affiche pas les clés primaires
						if( !estClePrimaire($column['Field']) ) {
							echo "\n\t\t\t\t\t<tr>";
							echo "\n\t\t\t\t\t\t<th>{$column['Field']}</th>";
							echo "\n\t\t\t\t\t\t<td> <input type=\"text\" name=\"{$column['Field']}\" /> </td>";
							echo "\n\t\t\t\t\t</tr>";
						}		
					}
					// Fermeture du tableau
					echo "\n\t\t\t\t</table>";
				}
// S'il s'agit d'une modifitcation (update)
				else if( isset($_POST['update']) ) {
					echo "<input type=\"hidden\" name=\"action\" value=\"update\" />";
					// Récupération du nom de la clé primaire
					$columns_req = $bdd->query("SHOW COLUMNS FROM $table_selectionnee");
					$lignes_columns = $columns_req->fetchAll();
					foreach($lignes_columns as $column) {
						if( estClePrimaire($column['Field']) )
							$cle_primaire = $column['Field'];
					}
					// Récupération de la ligne concernée
					$laligne_req = $bdd->query("SELECT * FROM `$table_selectionnee` WHERE `$cle_primaire`=$id");
					$leschamps = $laligne_req->fetchAll(PDO::FETCH_ASSOC);
					// Pour chaque colonne
					echo "<table>";
					foreach ($leschamps[0] as $champ => $value) {
						echo "\t<tr>";
						echo "\t\t<td>$champ</td>";
						// Si ce n'est pas une clé primaire, ce n'est pas éditable
						if( estClePrimaire($champ))
							echo "\t\t<td>$value</td>";
						else
							echo "\t\t<td> <input type=\"text\" name=\"$champ\" value=\"$value\" /> </td>";
						echo "\t</tr>";
					}
					echo "</table>";
				}
// S'il s'agit d'une suppression (delete)
				else if( isset($_POST['delete']) ) {
					echo "<input type=\"hidden\" name=\"action\" value=\"delete\" />";
					echo "<p>Voulez-vous vraiment supprimer cette ligne ?</p>";
				}
				// Sinon, erreur de demande ???!!!
				else {
					echo "Erreur: la demande n'existe pas.";
				}
			?>
				<input type="submit" value="Valider" />
			</form>
			<a href="choixtable.php">&lt;&lt; Retour au choix de la table</a>
</body>
</html>