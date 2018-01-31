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
        $query = "SELECT * FROM STUDENT WHERE CLID = '$clid';";

        $res = mysql_query($query);
        $row = mysql_fetch_assoc($res);
        if($res){
            $_SESSION['CLID'] = $clid;
            $_SESSION['FNAME'] = $row['FNAME'];
            $_SESSION['LNAME'] = $row['LNAME'];
            $_SESSION['flash_message'] = "You've successfully logged in as the user " . $_SESSION['FNAME'] . " " . $_SESSION['LNAME'] . "!";

        }
        header("Location: /index.php");
    ?>

<?php }
include "footer.php"; ?>
