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
	$clid = $_SESSION['CLID'];
	?>
	<h2>Expense Transactions</h2>	
    <table align='center' width="600px">
    <thead>
        <th>Date(YYYY-MM-DD)</th>
        <th>Business Name</th>
        <th>Category</th>
        <th>Amount</th>
		<th>Check # (optional)</th>
        <th></th>
    </thead>
    <tr>
        <form action = "handle_transaction.php" method = "post">
        <input type="hidden" name="page_name" value=<?php echo $_SERVER['REQUEST_URI']; ?>>
        <input type="hidden" name="type" value="expense">
        <td><input style="width:100px;" type="text" name="date"></td>
        <td><select name="busname">
        <?php
            $query = "select BUSNAME from GOTO where CLID = '$clid'";
            $res = mysql_query($query);
            while($row = mysql_fetch_assoc($res)){
                $busname = htmlspecialchars($row['BUSNAME']);
                echo "<option value=\"" . $busname . "\">".$row['BUSNAME'] . "</option>";
            }
            ?>
        </select></td>
        <td><select name="category">
        <?php
            $clid = $_SESSION['CLID'];
            $query = "SELECT C1.CATID, C1.CATNAME, C1.TYPE, C1.PCAT FROM CATEGORY C1 WHERE (C1.TYPE = 'E' AND C1.IS_DEFAULT=1 AND C1.CATNAME != 'EXPENSES') UNION SELECT C2.CATID, C2.CATNAME, C2.TYPE, C2.PCAT FROM CATEGORY C2, HAVE H WHERE (C2.TYPE='E' AND H.CATID=C2.CATID AND H.CLID = '$clid' AND C2.IS_DEFAULT=0) ORDER BY PCAT, CATNAME;"; 
            $res = mysql_query($query);
            while($row = mysql_fetch_assoc($res)){
                if($row['CATNAME'] != "Miscellaneous Expense" && $row['CATNAME'] != "Transfer to savings"){
                    $cat_name = GetFullCatname($row['CATID']);
                    echo "<option value='" . $row['CATID'] . "'>".$cat_name. "</option>";
                } else if($row['CATNAME'] == "Miscellaneous Expense"){
                echo "<option value='". $row['CATID'] ."' selected='selected'>Miscellaneous Expense</option>";
                }

            }
        ?>
        </select></td>
        <td><input style="width:75px;" type="text" name="amount"></td>
		<td><input style="width:75px;" type="text" name="checknum"></td>
        <td><input type="submit" value="Add Expense"></td>
        </form>
    </tr>
</table>
<?php
$clid = $_SESSION['CLID'];
$query = "SELECT * from EXTRANS E, CATEGORY C where '$clid' = E.CLID AND E.CATID = C.CATID ORDER BY E.DATE DESC, E.TIME DESC;";

$res = mysql_query($query);
if(!$res){
	echo "It don't work?";
}
?>
<table align='center'>
<thead>
    <th> Date </th>
	<th> Business Name </th>
    <th> Category </th>
	<th> Check Number </th>
    <th> Amount </th>
	<th></th>
</thead>
<h2> </h2>
<?php
while($row = mysql_fetch_assoc($res)){
    $busname = htmlspecialchars($row['BUSNAME']);
    echo "<tr>";
    echo "<td>" . $row['DATE'] . "</td>";
	echo "<td>" . $row['BUSNAME'] . "</td>";
    echo "<td>" . $row['CATNAME'] . "</td>";
    echo "<td>" . $row['CHECKNUM'] . "</td>";
    echo "<td>" . $row['AMOUNT'] . "</td>";
    echo "<td>";
    if($row['CATNAME'] != "Transfer to savings"){ 
    ?> 
	<form action = "/delete.php" method ="post">
	<input type="hidden" name="time" value="<?php echo $row['TIME']; ?>">
	<input type="hidden" name="transactiontype" value="expense">
	<input type="submit" value="Delete">
	</form>
	<?php
    }
	echo "</td>";
    echo "</tr>";
}
?>
</table>
<?php include "footer.php";?>
