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
    $clid = $_SESSION['CLID'];
	$catid = $_POST['catid'];
    $query = "SELECT * FROM CATEGORY C, HAVE H WHERE C.CATID=H.CATID AND C.PCAT=$catid;";
    $res = mysql_query($query);
    $row = mysql_fetch_assoc($res);
    if($row) {
        $_SESSION['flash_message'] = "You cannot delete a category that has sub-categories!";
    } else {
        $query = "SELECT * FROM CATEGORY WHERE CATNAME='Miscellaneous Expense';";
        $res = mysql_query($query);
        $row = mysql_fetch_assoc($res);
        $misc_exp_id = $row['CATID'];

        $query = "UPDATE EXTRANS SET CATID=$misc_exp_id WHERE CLID='$clid' AND CATID = $catid;";
        $res = mysql_query($query);

        $query = "SELECT * FROM CATEGORY WHERE CATNAME='Miscellaneous Income';";
        $res = mysql_query($query);
        $row = mysql_fetch_assoc($res);
        $misc_inc_id = $row['CATID'];

        $query = "UPDATE INTRANS SET CATID=$misc_inc_id WHERE CLID='$clid' AND CATID = $catid;";
        $res = mysql_query($query);

        $query = "delete from HAVE where CLID = '$clid' AND CATID = $catid;";
        $res = mysql_query($query);
        $row = mysql_fetch_assoc($res);
        if($res){
            $_SESSION['flash_message'] = "You've successfully deleted the category! Any associated transactions have been moved to Miscellaneous.";
        }
    }
    header("Location: /categories.php");
    ?>

<?php 
include "footer.php"; ?>
