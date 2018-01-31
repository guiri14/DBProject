<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php include "must_be_logged_in.php";
	include "db.php";
    session_start();
	GetDB();
    $time = mysql_real_escape_string($_POST['time']);
    $type = mysql_real_escape_string($_POST['transactiontype']);
	
	$clid = $_SESSION['CLID'];
	if($type == "expense"){
		$query = "select AMOUNT from EXTRANS where TIME = '$time'";
	}
	if($type == "income"){
		$query = "select AMOUNT from INTRANS where TIME = '$time'";
	}
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res);
	$amount = $row['AMOUNT'];
	
	if($type == "expense"){
    $query = "delete from EXTRANS where TIME = '$time'";
	}
	if($type == "income"){
    $query = "delete from INTRANS where TIME = '$time'";
	}
    $res = mysql_query($query);


    if($res){
		if($type == "expense"){
		$_SESSION['flash_message'] = "Successfully deleted expense!";
		$query = "update STUDENT set CHECKBAL = CHECKBAL + '$amount' where CLID = '$clid'";
		$res = mysql_query($query);
		header('location: expense.php');
		}
		if($type == "income"){
		$_SESSION['flash_message'] = "Successfully deleted income!";
		$query = "update STUDENT set CHECKBAL = CHECKBAL - '$amount' where CLID = '$clid'";
		$res = mysql_query($query);
		header('location: income.php');
		}
	}
	else {
		$_SESSION['flash_message'] = "Could not delete.";
	}
    CleanUpDB();

    exit;
?>
