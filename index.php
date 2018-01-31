<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php include "header.php";
?>
<?php
if(!IsLoggedIn()){
    ?>
    <h1>Welcome!</h1>
    <p>
        Try registering by clicking the "Register" button on the Nav-Bar on the left.
    </p>
    <?php
}
if(IsLoggedIn()){
	$clid = $_SESSION['CLID'];
	?>
    <h2 align="center">Summary Report</h2>
	<h3 align="center">Broken Goals</h3>
	<table align="center">
		<thead>
			<th> Category </th>
			<th> Actual </th>
			<th> Goal </th>
		</thead>
		<?php
		$query = "select CATID, sum(AMOUNT) from EXTRANS where CLID = '$clid' group by CATID";
		$res = mysql_query($query);
		$query2 = "select CATID, GOAL from HAVE where CLID = '$clid'";
		$res2 = mysql_query($query2);
		
		while($row = mysql_fetch_assoc($res)){
			$row2 = mysql_fetch_assoc($res2);
			$actual = $row['sum(AMOUNT)'];
			$goal = $row2['GOAL'];
			$catid = $row['CATID'];
			if($actual > $goal && $goal) {
				$query3 = "select CATNAME from CATEGORY where CATID = '$catid'";
				$res3 = mysql_query($query3);
				$row3 = mysql_fetch_assoc($res3);
				$catname = $row3['CATNAME'];
				echo "<tr>";
				echo "<td>" . $catname . "</td>";
				echo "<td>" . $actual . "</td>";
				echo "<td>" . $goal . "</td>";
				echo "</tr>";
			}
			echo "<tr>";
		}
		?>
		
	</table>
	<h3 align="center">Expenses</h3>
	<table align="center">
		<thead>
			<th> Date </th>
			<th> Business Name </th>
			<th> Category </th>
			<th> Check Number </th>
			<th> Amount </th>
		</thead>
		<?php
		$query = "SELECT * from EXTRANS E, CATEGORY C where '$clid' = E.CLID AND E.CATID = C.CATID ORDER BY E.DATE DESC LIMIT 5;";
		$res = mysql_query($query);

		while($row = mysql_fetch_assoc($res)){
			$busname = htmlspecialchars($row['BUSNAME']);
			echo "<tr>";
			echo "<td>" . $row['DATE'] . "</td>";
			echo "<td>" . $row['BUSNAME'] . "</td>";
			echo "<td>" . $row['CATNAME'] . "</td>";
			echo "<td>" . $row['CHECKNUM'] . "</td>";
			echo "<td>" . $row['AMOUNT'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";


	?>
	<h3 align="center">Income </h3>
	<table align="center">
		<thead>
			<th> Date </th>
			<th> Category </th>
			<th> Amount </th>
		</thead>

		<?php
		$query = "SELECT * from INTRANS I, CATEGORY C where '$clid' = I.CLID AND I.CATID = C.CATID ORDER BY I.DATE DESC LIMIT 5;";

		$res = mysql_query($query);
		while($row = mysql_fetch_assoc($res)){
			echo "<tr>";
			echo "<td>" . $row['DATE'] . "</td>";
			echo "<td>" . $row['CATNAME'] . "</td>";
			echo "<td>" . $row['AMOUNT'] . "</td>";
			echo "</tr>";
		}
		?>
	</table>
<?php } ?>
<?php include "footer.php";?>
