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
$query =  "SELECT * FROM EXTRANS E, CATEGORY C WHERE E.CLID = '$clid' AND E.CHECKNUM != 'NULL'AND E.CATID  = C.CATID ORDER BY DATE DESC";
$res = mysql_query($query);
if(!res){
    echo "It didn't work";
}
?>

<h2> Checks Issued </h2>

<table align='center'>
<thead>
    <th> Date </th>
    <th> Check Number </th>
    <th> Amount </th>
    <th> Business </th>
    <th> Category </th>
</thead>

<?php

while($row = mysql_fetch_assoc($res)){
    $busname = htmlspecialchars($row['BUSNAME']);
    echo "<tr>";
    echo "<td>" . $row['DATE'] . "</td>";
    echo "<td>" . $row['CHECKNUM'] . "</td>";
    echo "<td>" . $row['AMOUNT'] . "</td>";
    echo "<td>" . $row['BUSNAME'] . "</td>";
    echo "<td>" . $row['CATNAME'] . "</td>";
    echo"</tr>"; 
}
?>

</table>
<?php include "footer.php";?>

