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

    $busname = mysql_real_escape_string($_POST['BUSNAME']);
    $action =  mysql_real_escape_string($_POST['ACTION']);
    

    $_SESSION['flash_message'] = "";
    $fail = false;

    if(!$busname){
        $_SESSION['flash_message'] .= "You must enter a business name!";
        $fail = true;
    }

    if($fail){
        header("Location: /businesses.php");
    }

    if(!$fail){
        $clid = $_SESSION['CLID'];
        $newQuery = "";
	if($action == "adding"){
	    $busQuery = "SELECT COUNT(*) as c FROM BUSINESS WHERE BUSNAME = '$busname')";
	    $busRes = mysql_query($busQuery);
	    $row = mysql_fetch_assoc($busRes);
	    if($row['c'] == 0){
		$busQuery = "INSERT INTO BUSINESS VALUES('$busname')";
		mysql_query($busQuery);
	    }
	    $addQuery = "INSERT INTO GOTO VALUES ('$clid', '$busname')";
	    $res = mysql_query($addQuery);
            $validBusiness = mysql_affected_rows();
	    
	    if($validBusiness != -1){
		if($res) $_SESSION['flash_message'] = "Successfully added the business!";
	    }
	    else{
		$_SESSION['flash_message'] = "Sorry, that business already exists!";
	    }	
        }
	else if($action == "deleting"){
	    $checkExQuery = "SELECT COUNT(*) as c FROM EXTRANS WHERE BUSNAME = '$busname' AND CLID = '$clid'";
	    $res = mysql_query($checkExQuery);
	    $row = mysql_fetch_assoc($res);

	    if($row['c'] != 0){
		$_SESSION['flash_message'] = "Sorry, you cannot delete " . $busname . " because you recorded an expense transaction with this business!";
	    }
	    else{
		$newQuery = "DELETE FROM GOTO WHERE CLID = '$clid' AND BUSNAME = '$busname'";
		$res = mysql_query($newQuery);
		$_SESSION['flash_message'] = "Successfully removed the business!";
	    }
	}

        header("Location: /businesses.php");
    } 
    CleanUpDB();

    exit;
?>
