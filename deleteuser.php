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
        $clid = $_GET['clid'];
        $query = "delete from STUDENT where CLID = '$clid'";

        $res = mysql_query($query);
        $row = mysql_fetch_assoc($res);
        if($res){
            $_SESSION['flash_message'] = "You've successfully deleted " . $clid . "!";
        }
        header("Location: /userlist.php");
    ?>

<?php }
include "footer.php"; ?>