<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php
    if(!isset($_SESSION['logged_in']) ||
        !$_SESSION['logged_in']){
        $_SESSION['flash_message'] = "You must be logged in to access that!";
        header('Location: /login.php');
    }
?>
