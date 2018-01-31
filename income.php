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
<h2>Income Transactions</h2>	
<?php
$clid = $_SESSION['CLID'];
?>
<table align="center">
    <thead>
        <th>Date (YYYY-MM-DD)</th>
        <th>Category</th>
        <th>Amount</th>
        <th></th>
    </thead>
    <form action="handle_transaction.php" method="post">
        <input type="hidden" name="type" value="income">
        <input type="hidden" name="page_name" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <tr>
            <td><input type="text" name="date"></td>
            <td><select name="category">
            <?php
                $clid = $_SESSION['CLID'];
                $query = "SELECT C1.CATNAME, C1.CATID FROM CATEGORY C1 WHERE (C1.TYPE = 'I' AND C1.IS_DEFAULT=1 AND C1.CATNAME != 'Income')"; 
                $query2 = "SELECT C2.CATNAME, C2.CATID FROM CATEGORY C2, HAVE H WHERE (H.CLID = '$clid' AND H.CATID = C2.CATID AND C2.TYPE='I')";
                $res = mysql_query($query . " UNION " . $query2);
                while($row = mysql_fetch_assoc($res)){
                    $catname = GetFullCatname($row['CATID']);
                    if($row['CATNAME'] != "Income")
                        echo "<option value='" . $row['CATID'] . "'>".$catname . "</option>";
                }
            ?></select></td>
            <td><input type="text" name="amount"></td>
            <td><input type="submit" value="Add Transaction"></td>
        </tr>
    </form>
</table>
</br>
<table align="center">
<thead>
    <th> Date </th>
    <th> Category </th>
    <th> Amount </th>
	<th></th>
</thead>

<?php
$query = "SELECT * from INTRANS I, CATEGORY C where '$clid' = I.CLID AND I.CATID = C.CATID ORDER BY I.DATE DESC, I.TIME DESC;";

$res = mysql_query($query);
while($row = mysql_fetch_assoc($res)){
    echo "<tr>";
    echo "<td>" . $row['DATE'] . "</td>";
    echo "<td>" . $row['CATNAME'] . "</td>";
    echo "<td>" . $row['AMOUNT'] . "</td>";
    echo "<td>" ?> 
	<form action = "/delete.php" method ="post">
	<input type="hidden" name="time" value="<?php echo $row['TIME']; ?>">
	<input type="hidden" name="transactiontype" value="income">
	<input type="submit" value="Delete">
	</form>
	<?php
	echo "</td>";
    echo "</tr>";
}
?>
</table>
<?php include "footer.php";?>
