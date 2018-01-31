<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php include "header.php";
    include "must_be_logged_in.php";
    if($_SESSION['SU'] == 1) {
        echo "Sudo dash!</br>";

        echo "<a href='userlist.php'>User List</a>";
        echo"</br>";

        echo "<a href='buslist.php'>Business Institution List</a>";
    ?>

<?php }
include "footer.php"; ?>
