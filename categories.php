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
<h3 align="center">Add Category</th>
<table align="center">
    <thead>
        <th>Parent</th>
        <th>Name</th>
        <th></th>
    </thead>
    <form action="add_cat.php" method="post">
        <tr>
            <td><select name="parent">
            <?php
                $clid = $_SESSION['CLID'];
                $query = "SELECT C1.CATNAME, C1.CATID, C1.TYPE FROM CATEGORY C1 WHERE (C1.IS_DEFAULT=1)"; 
                $query2 = "SELECT C2.CATNAME, C2.CATID, C2.TYPE FROM CATEGORY C2, HAVE H WHERE (H.CLID = '$clid' AND H.CATID = C2.CATID)";
                $res = mysql_query("(". $query . ") UNION (" . $query2 . ") ORDER BY TYPE DESC, CATID");
                while($row = mysql_fetch_assoc($res)){
                    $catname = GetFullCatname($row['CATID']);
                    if($row['TYPE'] == 'I' && $row['CATNAME'] != 'Income') $catname = "Income/" . $catname;
                    else if ($row['TYPE'] == 'E' && $row['CATNAME'] != 'Expenses') $catname = "Expenses/" . $catname;
                    echo "<option value='" . $row['CATID'] . "'>".$catname . "</option>";
                }
            ?></select></td>
            <td><input type="text" name="catname"></td>
            <td><input type="submit" value="Add Category"></td>
        </tr>
    </form>
</table>
<h3 align="center">Delete Category</th>
<table align="center">
    <thead>
        <th>Category</th>
        <th></th>
    </thead>
    <form action="delete_cat.php" method="post">
        <tr>
            <td><select name="catid">
            <?php
                $clid = $_SESSION['CLID'];
                $query = "SELECT C2.CATNAME, C2.CATID, C2.TYPE FROM CATEGORY C2, HAVE H WHERE (H.CLID = '$clid' AND H.CATID = C2.CATID AND C2.IS_DEFAULT=0) ORDER BY TYPE DESC, CATNAME";
                $res = mysql_query($query);
                while($row = mysql_fetch_assoc($res)){
                    $catname = GetFullCatname($row['CATID']);
                    if($row['TYPE'] == 'I') $catname = "Income/" . $catname;
                    else if ($row['TYPE'] == 'E') $catname = "Expenses/" . $catname;
                    echo "<option value='" . $row['CATID'] . "'>".$catname . "</option>";
                }
            ?></select></td>
            <td><input type="submit" value="Delete Category"></td>
        </tr>
    </form>
</table>
<?php
$clid = $_SESSION['CLID'];
$query = "select C.CATNAME, H.GOAL from CATEGORY C, HAVE H where C.CATID = H.CATID AND H.CLID = '$clid'";
$query2 = "select C.CATNAME, NULL from CATEGORY C where C.IS_DEFAULT = 1 AND not exists (select * from HAVE H where H.CLID = '$clid' AND C.CATID = H.CATID)";
$res = mysql_query($query . " UNION " . $query2);
?>
<?php 
$query = "SELECT * FROM CATEGORY C WHERE C.CATNAME='Income' OR C.CATNAME='Expenses';";
$res = mysql_query($query);
$income_cat = mysql_fetch_assoc($res);
$income_cat["depth"] = 0;
$expense_cat = mysql_fetch_assoc($res);
$expense_cat["depth"] = 0;
$max_depth = 0;
function GetChilds(&$cat){
    global $max_depth;
    $cat["children"] = GetChildCategories($cat['CATID']);
    if($cat["depth"] > $max_depth)
        $max_depth = $cat["depth"];
    if(!empty($cat["children"])){
        foreach($cat["children"] as &$child){
            $child["depth"] = $cat["depth"] + 1;
            GetChilds($child);
        }
    }
}
function PrintCategoryList($cat){
    echo "<ul>";
    echo "<li>";
    echo $cat['CATNAME'] . " Depth of " . $cat["depth"];
    echo "</li>";
    if(!empty($cat["children"])){
        foreach($cat["children"] as $child){
            PrintCategoryList($child);
        }
    }
    echo "</ul>";
}
GetChilds($income_cat);
GetChilds($expense_cat);


$width = 100/($max_depth+2);
$table_width = ($max_depth+2) * 100 + 150;
?>
<h3 align="center">Category List and Goals</h3>
<table width = "<?= $table_width; ?>" align="center">
<thead>
    <th width='<?= $width; ?>%'>Category</th>
    <?php 
        for($i = 0; $i < $max_depth; $i++){
            echo "<th width='" . $width . "%'></th>";
        }
    ?>
    <th width='<?= $width + 50;?>%'>Goals</th>
</thead>

<?php
function PrintCatTable($cat){
    global $max_depth;
    echo "<tr height='50px'>";
    for($i = 0; $i < $cat["depth"]; $i++){
            echo "<td></td>";
    }
    echo "<td>";
    echo $cat["CATNAME"];
    echo "</td>";
    for($i = $cat["depth"]; $i < $max_depth; $i++){
        echo "<td></td>";
    }
    echo "<td>";
    if(isset($cat["GOAL"])){
        $cat_id = $cat["CATID"];
        $clid = $_SESSION['CLID'];
		$get_amount = "select sum(AMOUNT) as spent from EXTRANS where CLID = '$clid' AND CATID=$cat_id;";
		$amount_res= mysql_query($get_amount);
        $amount_row = mysql_fetch_assoc($amount_res);
        if($amount_row['spent'] > $cat['GOAL']){
            echo "<font color='red'>";
        }
        if(!$amount_row['spent']) $amount_row['spent'] = 0;
        echo "$".number_format($amount_row['spent'], 2, '.', '');
        echo " /";
        echo " $".$cat["GOAL"];
        if($amount_row['spent'] > $cat['GOAL']){
            echo "</font>";
        }
		?>
		<form action="/delete_goal.php" method = "post"> 
		<input type="hidden" name="catid" value="<?php echo $cat["CATID"]; ?>">
		<input type="submit" value="Delete">
        </form>
		<?php
    }
	else if($cat["TYPE"] == 'E' && $cat["CATNAME"] != "Expenses") {
		?>
		<form action = "add_goal.php" method = "post">
		<input type="text" name="goal" style="width:40px;">
		<input type="hidden" name="catid" value="<?= $cat["CATID"];?>">
		<input type="submit" value="Add Goal">
		</form>
		<?php
	}
    echo "</td>";
    echo "</tr>";
    if(!empty($cat["children"])){
        foreach($cat["children"] as $child){
            PrintCatTable($child);
        }
    }
}
PrintCatTable($income_cat);
PrintCatTable($expense_cat);
?>



</table>
<?php include "footer.php";?>
