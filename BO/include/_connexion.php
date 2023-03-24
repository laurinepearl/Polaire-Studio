<?php

try {   /* Utilisation du module PDO (Php Data Objects)
	   cf. openclassrooms.com/courses/concevez-votre-site-web-avec-php-et-mysql/lire-des-donnees-2 qui propose sous forme objet (une classe) un ensemble complet
	   de méthodes de manipulation des BdD et de leurs tables
	   A changer :
	      - le nom de la BDD : écrit sur le format portfolio2019-2020_xxx où xxx correspond à votre nom
	      - le passwd : vide '' pour Windows et 'root' pour OSX
	*/
    $bdd = new PDO('mysql:host=localhost;dbname=projet_ferreira;charset=utf8', 'root', '');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>