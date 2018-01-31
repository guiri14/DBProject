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
<h2>Ledger</h2>
<?php
$clid = $_SESSION['CLID'];

$query = "(SELECT '' AS EXPENSE, '' AS CHECKNUM, AMOUNT AS INCOME, DATE,CATNAME, 'I' AS TYPE1,'' AS TYPE2,'' AS BUSNAME, I.TIME FROM INTRANS I, CATEGORY C1 WHERE I.CATID=C1.CATID AND I.CLID = '$clid') UNION ALL (SELECT AMOUNT AS EXPANSE,CHECKNUM,'' AS INCOME, DATE, CATNAME,'' AS TYPE1,'E' AS TYPE2,BUSNAME, E.TIME FROM EXTRANS E, CATEGORY C2 WHERE E.CATID=C2.CATID AND E.CLID = '$clid') ORDER BY DATE DESC, TIME DESC";

$res = mysql_query($query);
if(!$res){
	echo "Fail to get the data" . mysql_error();
}
?>
<table align='center'>
	<thead>
		<th>Date</th>
		<th>To</th>
		<th>Category</th>
		<th>Checking #</th>
		<th>Income</th>
		<th>Expense</th>
	</thead>
	<?php
	while($row = mysql_fetch_assoc($res)){
		echo "<tr>";
		echo "<td>" . $row['DATE'] . "</td>";
		echo "<td>" . $row['BUSNAME'] . "</td>";
		echo "<td>" . $row['CATNAME'] . "</td>";
		echo "<td>" . $row['AMOUNT'] . "</td>";
		echo "<td>" . $row['INCOME'] . "</td>";
		echo "<td>" . $row['EXPENSE'] . "</td>";


	}
	?>
</table>


<?php include "footer.php";?>
