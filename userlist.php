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
    if($_SESSION['SU'] == 1) {?>

<?php
$query = "SELECT * FROM STUDENT";

$res = mysql_query($query);
if(!$res){
    echo "It didn't work?";
}
?>
<table align='center'>
<thead>
    <th> CLID </th>
    <th> Name </th>
    <th> Password </th>
    <th> Checking Acc #</th>
    <th> Checking Balance</th>
    <th> Savings Acc #</th>
    <th> Savings Balance</th>
    <th> SUDO </th>
	<th></th>
    <th></th>
</thead>

<?php
while($row = mysql_fetch_assoc($res)){
    echo "<tr>";
    echo "<td><a href=/log_in_as.php?clid=" . $row['CLID'] . ">" . $row['CLID'] . "</td>";
    echo "<td>" . $row['FNAME'] . " " . $row['LNAME'] . "</td>";
    echo "<td>" . $row['PASSWD'] . "</td>";
    echo "<td>" . $row['CHECKNUM'] . "</td>";
    echo "<td>" . $row['CHECKBAL'] . "</td>";
    echo "<td>" . $row['SAVENUM'] . "</td>";
    echo "<td>" . $row['SAVEBAL'] . "</td>";
    echo "<td>" . $row['SU'] . "</td>";
	echo "<td><a href=/deleteuser.php?clid=" . $row['CLID'] . ">" . "DELETE" . "</td>";
    echo "<td><a href=/profile_of.php?clid=" . $row['CLID'] . ">" . "Profile" . "</td>";
    echo "</tr>";

}
?>
</table>
<?php }
include "footer.php"; ?>
