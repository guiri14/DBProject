<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php include "header.php"; ?>
<h1>Sign Up</h1>
<form action = "registration.php" method = "post">
    CLID:<br/>
    <input type="text" name="CLID"><br/>
    Password:<br/>
    <input type="password" name="password"><br/>
    First Name:<br/>
    <input type="text" name="fname"><br/>
    Last Name:<br/>
    <input type="text" name="lname"><br/>
    Checking Account Number:<br/>
    <input type="text" name="checknum"><br/>
    Checking Account Balance:<br/>
    <input type="text" name="checkbal"><br/>
    Savings Account Number (Optional):<br/>
    <input type="text" name="savenum"><br/>
    Savings Account Balance (Optional):<br/>
    <input type="text" name="savebal"><br/>
    <input type="submit" value="Register!">
</form>
 <?php include "footer.php"; ?>
