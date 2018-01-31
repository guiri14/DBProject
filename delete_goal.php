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
    $query = "update HAVE set GOAL = NULL where CLID = '$clid' AND CATID = $catid";
    $res = mysql_query($query);
    $row = mysql_fetch_assoc($res);
    if($res){
        $_SESSION['flash_message'] .= "You've successfully deleted the goal!";
    header("Location: /categories.php");
    ?>

<?php }
include "footer.php"; ?>
