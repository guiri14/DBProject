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
if($_SESSION['SU']==1) {?>
<h3 align="center">List of Business Associations<h3>
<?php

$query = "SELECT BUSNAME, CATNAME, COUNT(*) FROM ((SELECT CLID, BUSNAME, '' AS CATNAME FROM (SELECT * FROM GOTO G WHERE NOT EXISTS (SELECT CLID, BUSNAME FROM EXTRANS E WHERE G.BUSNAME = E.BUSNAME AND G.CLID = E.BUSNAME))AS T) UNION (SELECT CLID, BUSNAME, CATNAME FROM EXTRANS E1, CATEGORY C1 WHERE E1.CATID = C1.CATID)) AS T GROUP BY BUSNAME, CATNAME";


$res = mysql_query($query);
if(!$res){
	echo "It didn't work";
}

?>
<table align ='center'>
	<thead>
		<th>Business Institution</th>
		<th>Category</th>
		<th>Number of Users</th>
	</thead>

	<?php
	while($row = mysql_fetch_assoc($res)){
		echo "<tr>";
		echo "<td>".$row['BUSNAME']."</td>";
		echo "<td>".$row['CATNAME']."</td>";
		echo "<td style='text-align:center;'>".$row['COUNT(*)']."</td>";
			
	}
	?>

</table>

<?php }
include "footer.php";?>
