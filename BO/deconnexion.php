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
unset($_SESSION['login']);
// unset($_SESSION['pwd']);
// unset($_SESSION['backoff']);
header("Location: ../index.php");

?>
</body>
</html>