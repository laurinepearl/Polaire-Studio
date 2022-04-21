<?php
    session_start();
    header("Location: ../index.php?message=2");
    session_destroy();


    exit();
?>