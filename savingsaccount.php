<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php include "header.php";
    include "must_be_logged_in.php";?>
<?php
$clid = $_SESSION['CLID'];
$query = "SELECT SAVENUM, SAVEBAL FROM STUDENT WHERE CLID = '$clid'"; 
$res = mysql_query($query);
if(!res){
    echo "It didn't work?";
}   
?>
<table align="center">

</table>

<h2> Savings </h2>
<table align="center">
<thead>
    <th> Account Number </th>
    <th> Amount </th>
</thead>
<?php
while($row = mysql_fetch_assoc($res)){
    echo "<tr>";
    echo "<td>" . $row['SAVENUM'] . "</td>";
    echo "<td>" . $row['SAVEBAL'] . "</td>";
    echo "<tr>";
}
?>
<thead>
    <th>Transfer</th>
    <td></td>
</thead>
<form action = "updatesavings.php" method = "post">
<td><input type="text" name = "AMOUNT"></td>
<td><input type="submit" value="Transfer To Checking"></td>
<input type="hidden" name="ACTION" value="toChecking">
</form>
</table>

<?php
$newQuery = "SELECT CHECKNUM, CHECKBAL FROM STUDENT WHERE CLID = '$clid'";
$newRes = mysql_query($newQuery);
?>
<h2> </h2>
<h2> Checking </h2>
<table align="center">
<thead>
    <th> Account Number </th>
    <th> Amount </th>
</thead>
<?php
while($row = mysql_fetch_assoc($newRes)){
    echo "<tr>";
    echo "<td>" .$row['CHECKNUM'] . "</td>";
    echo "<td>" . $row['CHECKBAL'] . "</td>";
    echo "<tr>";
} ?>
<thead>
    <th>Transfer</th>
    <td></td>
</thead>
<form action = "updatesavings.php" method = "post">
<tr>
<td><input type="text" name="AMOUNT"></td>
<td><input type="submit" value="Transfer To Savings"></td>
<input type="hidden" name="ACTION" value="toSavings">
</td>
</form>
</table>

<?php
    include "footer.php";
?>
