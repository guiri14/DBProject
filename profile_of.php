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
if($_SESSION['SU'] == 1) {
    $clid = $_GET['clid'];
    $query = "SELECT * FROM STUDENT WHERE CLID = '$clid';";

    $res = mysql_query($query);
    $row = mysql_fetch_assoc($res);
    if($res){
        $_SESSION['CLID'] = $clid;
        $_SESSION['FNAME'] = $row['FNAME'];
        $_SESSION['LNAME'] = $row['LNAME'];
    }
    ?>
	<a href="/userlist.php">&#60;&#60;&#60; return</a>
	<h2 align="center">User details</h2>
    <table align = "center">
    <thead>
        <th>Attribute</th>
        <th>Value</th>
    </thead>
    <?php
	    $clid = $_SESSION['CLID'];	
		$query = "select * from STUDENT where CLID = '$clid'";
		$res = mysql_query($query);
        $row=mysql_fetch_assoc($res);
		echo "<tr><td>CLID</td><td>" . $row['CLID'] . "</td></tr>";
		echo "<tr><td>FIRST NAME</td><td>" . $row['FNAME'] . "</td></tr>";
		echo "<tr><td>LAST NAME</td><td>" . $row['LNAME'] . "</td></tr>";
		echo "<tr><td>PASSWORD</td><td>" . $row['PASSWD'] . "</td></tr>";
		echo "<tr><td>CHECKING ACCOUNT NUMBER</td><td>" . $row['CHECKNUM'] . "</td></tr>";
		if($row['SAVENUM']) echo "<tr><td>SAVINGS ACCOUNT NUMBER</td><td>" . $row['SAVENUM'] . "</td></tr>";
		echo "<tr><td>CHECKING ACCOUNT BALANCE</td><td>" . $row['CHECKBAL'] . "</td></tr>";
		if($row['SAVEBAL']) echo "<tr><td>SAVINGS ACCOUNT BALANCE</td><td>" . $row['SAVEBAL'] . "</td></tr>";
		if($row['SU']) echo "<tr><td>IS SUPER USER</td><td></td></tr>";
	
    $query = "(SELECT '' AS EXPENSE, '' AS CHECKNUM, AMOUNT AS INCOME, DATE,CATNAME, 'I' AS TYPE1,'' AS TYPE2,'' AS BUSNAME FROM INTRANS I, CATEGORY C1 WHERE I.CATID=C1.CATID AND I.CLID = '$clid') UNION ALL (SELECT AMOUNT AS EXPANSE,CHECKNUM,'' AS INCOME, DATE, CATNAME,'' AS TYPE1,'E' AS TYPE2,BUSNAME FROM EXTRANS E, CATEGORY C2 WHERE E.CATID=C2.CATID AND E.CLID = '$clid') ORDER BY DATE DESC";

    $res = mysql_query($query);
    if(!$res){
        echo "Fail to get the data" . mysql_error();
    }
    ?>
    </table>
    <h3 align="center">Activity</h3>
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
    <?php
    $query = "SELECT T.CATNAME,T.TOTAL, T.CLID, V.GOAL FROM (SELECT CLID, CATNAME, SUM(AMOUNT) AS TOTAL FROM EXTRANS E, CATEGORY C WHERE E.CLID='$clid'AND E.CATID =C.CATID  GROUP BY E.CATID, CLID) AS T, (SELECT C1.CATNAME, H1.GOAL FROM CATEGORY C1, HAVE H1 WHERE H1.CATID = C1.CATID AND H1.CLID = '$clid' AND H1.GOAL IS NOT NULL) AS V WHERE V.CATNAME = T.CATNAME";
    $res = mysql_query($query);
    ?>
    <h3 align="center">Category</h3>
    <table align ='center'>
        <thead>
            <th>Category</th>
            <th>Goal</th>
            <th>Actual</th>
            <th></th>
        </thead>
        <?php 
        while ($row=mysql_fetch_assoc($res)) {
            # code...
            echo "<tr>";
            echo "<td>" . $row['CATNAME'] . "</td>";
            echo "<td>" . $row['GOAL'] . "</td>";
            echo "<td>" . $row['TOTAL'] . "</td>";   
            if($row['GOAL']<$row['TOTAL'] && $row['GOAL'])
                echo "<td>" . "Goal exceeded" . "</td>";
        }
        $query = "SELECT CLID, CATNAME, SUM(AMOUNT) AS TOTAL FROM EXTRANS E, CATEGORY C WHERE E.CLID='$clid'AND E.CATID =C.CATID  GROUP BY E.CATID, CLID;";
        ?>

    </table>

    <?php } ?>
	<h3 align="center">Businesses that they go to</h3>
    <table align ='center'>
        <thead>
            <th>Business Name</th>
        </thead>
        <?php 
		$query = "select B.BUSNAME from GOTO G, BUSINESS B where G.CLID = '$clid' AND G.BUSNAME = B.BUSNAME order by B.BUSNAME DESC";
		$res = mysql_query($query);
        while ($row=mysql_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>" . $row['BUSNAME'] . "</td>";
			echo "</tr>";
        }	
    include "footer.php"; ?>
