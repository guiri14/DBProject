<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php include "header.php"; ?>
Log in please:
<form action = "/authenticate.php" method="post">
    CLID:<br/>
    <input type="text" name="CLID"><br/>
    Password:<br/>
    <input type="password" name="password"><br/>
    <input type="submit" value="Login!">
</form>
<?php include "footer.php"; ?>
