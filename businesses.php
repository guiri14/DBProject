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

$query = "SELECT * FROM GOTO  WHERE CLID = '$clid'";

$res = mysql_query($query);
if(!$res){
    echo "It didn't work?";
}
?>

<h2> Add a Business </h2>
<table align="center">
<thead>
    <th> Business Name</th>
    <th> </th>
</thead>
<tr>
    <form action = "resolve_business.php" method = "post">
    <td>
        <div class="center"><input type="text" name= "BUSNAME"></div>
    </td>
    <td>
        <div class="center"><input type="submit" value="Add"></div>
        <input type="hidden" name="ACTION" value="adding">
    </td>
    </form>
</tr>
</table>
<h2> </h2>

<h2> Delete a Business </h2>
<table align="center">
<thead>
    <th> Business Name</th>
    <th> </th>
</thead>
<tr>
    <form action = "resolve_business.php" method = "post">
    <td>
        <div class="center"><select name="BUSNAME">
            <?php
            $newQuery = "SELECT * FROM GOTO WHERE CLID = '$clid'";
            $newRes = mysql_query($newQuery);
            while($row = mysql_fetch_assoc($newRes)){
                $busname = htmlspecialchars($row['BUSNAME']);
                echo "<option value='" .$busname . "'>";
                echo $row['BUSNAME']; 
                echo "</option>";
            }
            ?>
        </select></div>
    </td>
    <td>
        <div class="center"><input type="submit" value="Delete"></div>
        <input type="hidden" name="ACTION" value="deleting">
    </td>
    </form>
</tr>
</table>


<h2> </h2>
<h2> Business Listing </h2>
<table align='center'>
<thead>
    <th> Business Name </th>
</thead>

<?php
while($row = mysql_fetch_assoc($res)){
    echo "<tr>";
    echo "<td>" . $row['BUSNAME'] . "</td>";
    echo "<tr>";

}
?>


</table>
<?php include "footer.php";?>

