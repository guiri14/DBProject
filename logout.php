<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php 
    session_start();
    include "must_be_logged_in.php";
    $_SESSION['logged_in'] = false;
    if(!isset($_SESSION['flash_message'])){
        $_SESSION['flash_message'] = "You have been successfully logged out!";
    }
    header("Location: login.php");
?>
