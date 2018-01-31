<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php
    include "header.php";
	include "must_be_logged_in.php";
   
	$amount = mysql_real_escape_string($_POST['goal']);
	$matches; 
	preg_match("/^(\d+(\.\d{1,2})?)$/", $amount, $matches);
	if(!$amount || !$matches[1]){
        $_SESSION['flash_message'] = "You must enter a correct amount! ";
        $fail = true;
    }
	
	$clid = $_SESSION['CLID'];
	$catid = mysql_real_escape_string($_POST['catid']);
	$query = "insert into HAVE values ('$clid','$catid',$amount) ON DUPLICATE KEY UPDATE GOAL=$amount;";
	$res = mysql_query($query);
	
	echo mysql_error();
	if($res){
		$_SESSION['flash_message'] = "Successfully update your goal!";
	}
	
	header('Location: categories.php');
	include "footer.php";
?>
