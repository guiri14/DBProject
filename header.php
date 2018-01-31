<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php include "db.php"; 
    session_start();
    GetDB();
    if($_SERVER['REQUEST_URI'] == '/sudo.php' && $_SESSION['SU'] == 1) {
        if($_SESSION['CLID'] != $_SESSION['SU_CLID']){
            $_SESSION['flash_message'] = "You've logged out " . $_SESSION['FNAME'] . " " . $_SESSION['LNAME'] . "!";
            $_SESSION['CLID'] = $_SESSION['SU_CLID'];
            $_SESSION['FNAME'] = $_SESSION['SU_FNAME'];
            $_SESSION['LNAME'] = $_SESSION['SU_LNAME']; 
        }
    }
?>
<html>
<head>
<?php 
$title = $_SERVER['SCRIPT_NAME'];
$matches;
preg_match("/^\/(.+)\.php/", $title, $matches);
$title = ucfirst($matches[1]);
echo "<title>SFTD - " . $title . "</title>";
?>
<link rel="stylesheet" type="text/css" href="assets/default.css">
</head>
<body>
<div id="wrapper">
    <h1 align="center">
    Student Financial Tracker Database
    </h1>
    <?php
    if(IsLoggedIn()){
		$clid = $_SESSION['CLID'];
		$query = "SELECT * FROM STUDENT WHERE CLID = '$clid'";
        $res = mysql_query($query);
        $row = mysql_fetch_assoc($res);
        echo "<h3 align=\"center\">";
        echo $_SESSION['FNAME'] . " " . $_SESSION['LNAME'] . " - " . $_SESSION['CLID'];
        echo "</h3>";
	    echo "<div id='checking'>";	
        echo "<h3 align=\"left\">";
		echo "Checking Account</br># ";
        echo $row['CHECKNUM'];

        echo "</br>$ ";
        echo $row['CHECKBAL'];
        $_SESSION['CHECKBAL'] = $row['CHECKBAL'];
        echo "</h3></div>";
		
        if($row['SAVENUM'] != NULL) {
            $hasSavings = true;
            echo "<div id='saving'><h3 align=\"right\">";
            echo "Saving Account</br># ";
            echo $row['SAVENUM'];
            echo "</br>$ ";
            echo $row['SAVEBAL'];
            echo "</h3></div>";
        }
    }
    ?>
    <div style="clear:both;"></div>
    <div id="left-col">
        <ul>
            <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){ ?>
                <?php
                    if($_SESSION['SU'] == 1){
                    ?>
                    <li><a href="/sudo.php">Super User Dash</a></li>
                    <?php
                    }
                ?>
                <li><a href="/index.php">Summary</a></li>
                <li><a href="/ledger.php">Ledger</a></li>
                <li><a href="/businesses.php">Businesses</a></li>
                <li><a href="/categories.php">Categories</a></li>
                <li><a href="/income.php">Income Transactions</a></li>
                <li><a href="/expense.php">Expense Transactions</a></li>
                <li><a href="/checks.php">Checks Issued</a></li>
                <?php if($hasSavings == true){ ?>
                <li><a href="/savingsaccount.php">Savings Account</a></li> <?php } ?>
                    <li><a href="/logout.php">Log Out</a></li>
                <?php } else { ?> 
                    <li><a href="/login.php">Login</a></li>
                    <li><a href="/register.php">Register</a></li>
                <?php } ?>
        </ul>
    </div>
    <div id="content">
    <?php
        if(isset($_SESSION['flash_message'])){
            echo "<p>";
            echo $_SESSION['flash_message'];
            echo "</p>";
            unset($_SESSION['flash_message']);
        }
    ?>
