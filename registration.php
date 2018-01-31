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
 GetDB();
 $CLID = mysql_real_escape_string($_POST['CLID']);
 $password = mysql_real_escape_string($_POST['password']);
 $FNAME = mysql_real_escape_string($_POST['fname']);
 $LNAME = mysql_real_escape_string($_POST['lname']);
 $CHECKNUM = mysql_real_escape_string($_POST['checknum']);
 $CHECKBAL = mysql_real_escape_string($_POST['checkbal']);
 $SAVENUM = mysql_real_escape_string($_POST['savenum']);
 $SAVEBAL = mysql_real_escape_string($_POST['savebal']);

	//check for proper CLID
 $matches;
 $fail = false;
 $_SESSION['flash_message'] = "";

 preg_match("/^([a-zA-Z]{3}\d{4})$/", $CLID, $matches);

 if(!$matches[1]){
    $_SESSION['flash_message'] .= "You have entered an invalid CLID! ";
    $fail = true;
}
if(!$password){
    $_SESSION['flash_message'] .= "You must have a password! ";
    $fail = true;
}
if(!$FNAME){
    $_SESSION['flash_message'] .= "You must have a first name! ";
    $fail = true;
}
if(!$LNAME){
    $_SESSION['flash_message'] .= "You must have a last name! ";
    $fail = true;
}
if(!$CHECKNUM){
    $_SESSION['flash_message'] .= "You must have a checking account! ";
    $fail = true;
}
preg_match("/^(\d+(\.\d{1,2})?)$/", $CHECKBAL, $matches);
if(!$CHECKBAL || !$matches[1]){
    $_SESSION['flash_message'] .= "You must have a correct initial checking balance! ";
    $fail = true;
}
	//insert stuff that checks for savings bal and savings num for both [not] null
if( ($SAVENUM && !$SAVEBAL) ||
    ($SAVEBAL && !$SAVENUM) ){
    $_SESSION['flash_message'] .= "You must have both a saving balance and account number or none at all! ";
$fail = true;
}
if($fail){
    header('Location: /register.php');
}
else {
	$query = "select CLID from STUDENT where CLID = '$CLID'";
	$res = mysql_query($query);
	$row = mysql_fetch_assoc($res);
	if($CLID == $row['CLID']) {
		$_SESSION['flash_message'] .= "Your CLID already has an account.";
		header('Location: /register.php');
	}
	
    if($SAVEBAL == ''){
        $SAVEBAL = NULL;
        $SAVENUM = NULL;
        $query = "insert into STUDENT(CLID, FNAME, LNAME, PASSWD, CHECKNUM, SAVENUM, CHECKBAL, SAVEBAL,SU) VALUES('$CLID','$FNAME','$LNAME','$password',$CHECKNUM,NULL,$CHECKBAL, NULL, 0)";
    }
    else{
       $query = "insert into STUDENT(CLID, FNAME, LNAME, PASSWD, CHECKNUM, SAVENUM, CHECKBAL, SAVEBAL,SU) VALUES('$CLID','$FNAME','$LNAME','$password',$CHECKNUM,$SAVENUM,$CHECKBAL, $SAVEBAL, 0)";
   }
   if(mysql_query($query)){
    $_SESSION['flash_message'] = "You have successfully registered!  Welcome aboard!";
    header('Location: /login.php');
} 
else 
    echo mysql_error();

}
	//send query and check if actually added.
CleanUpDB();
?>
