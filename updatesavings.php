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
include "db.php";
include "must_be_logged_in.php";

GetDB();

$clid = $_SESSION['CLID'];
$amount = mysql_real_escape_string($_POST['AMOUNT']);
$action = mysql_real_escape_string($_POST['ACTION']);
$_SESSION['flash_message'] = "";

$savingsQuery = "SELECT SAVEBAL FROM STUDENT WHERE CLID = '$clid'";
$checkingQuery = "SELECT CHECKBAL FROM STUDENT WHERE CLID = '$clid'";



if($action == "toSavings"){

    $checkRes = mysql_query($checkingQuery);
    $row = mysql_fetch_assoc($checkRes);
    $checkBal = $row['CHECKBAL'];

    if($amount <= $checkBal){
    
	$query = "UPDATE STUDENT SET CHECKBAL = (CHECKBAL - $amount) WHERE CLID = '$clid'";
	mysql_query($query);

	$query = "UPDATE STUDENT SET SAVEBAL = (SAVEBAL + $amount) WHERE CLID = '$clid'";

	mysql_query($query);

	$query = "INSERT INTO EXTRANS VALUES (NOW(), CURDATE(),'$clid', 'Transfer to savings', 33, NULL, '$amount')";

	mysql_query($query);
    
	$_SESSION['flash_message'] = "Successfully transferred $" . $amount . " to savings!";
	
    }
    else{
	$_SESSION['flash_message'] = "Sorry, insufficient funds!"; 
    }   

}else{
    if($action == "toChecking"){

	$saveRes= mysql_query($savingsQuery);
	$row = mysql_fetch_assoc($saveRes);
	$saveBal = $row['SAVEBAL'];

	if($amount <= $saveBal){
	
	    $query = "UPDATE STUDENT SET SAVEBAL = (SAVEBAL - $amount) WHERE CLID = '$clid'";
	    mysql_query($query);
	    Debug($query);

	    $query = "UPDATE STUDENT SET CHECKBAL = (CHECKBAL + $amount) WHERE CLID = '$clid'";

	    mysql_query($query);

	    $query = "INSERT INTO INTRANS VALUES(NOW(), CURDATE(), '$clid', 1, '$amount')";

	    mysql_query($query);
	
	    $_SESSION['flash_message'] = "Successfully transferred $" . $amount . " to checking!";
	    
	}
	else{
	    $_SESSION['flash_message'] = "Sorry, insufficient funds!"; 
	}
    }	
}

header("Location: /savingsaccount.php");
CleanUpDB();

exit;

?>
