<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php
    session_start();
    include "db.php";
    GetDB();
    $parent = mysql_real_escape_string($_POST['parent']);
    $catname = mysql_real_escape_string($_POST['catname']);
    $parent = intval($parent);
    $query = "SELECT * FROM CATEGORY WHERE PCAT=$parent AND CATNAME='$catname';";
    $res = mysql_query($query);
    $row = mysql_fetch_assoc($res);
    $type;
    if(!$row){
        echo "Got into the insert";
        $query = "SELECT TYPE FROM CATEGORY WHERE CATID=$parent;";
        $res = mysql_query($query);
        $row = mysql_fetch_assoc($res);
        $type = $row['TYPE'];
        $query = "INSERT INTO CATEGORY VALUES('$catname', NULL, $parent, 0, '$type');";
        $res = mysql_query($query);
    }
    $query = "SELECT * FROM CATEGORY WHERE CATNAME = '$catname' AND PCAT = $parent AND IS_DEFAULT=0;";
    $res = mysql_query($query);
    $row = mysql_fetch_assoc($res);
    $clid = $_SESSION['CLID'];
    $catid = $row['CATID'];
    $query = "SELECT * FROM HAVE WHERE CLID = '$clid' AND CATID = $catid;";
    $res = mysql_query($query);
    $row = mysql_fetch_assoc($res);
    if(!$row){
        $query = "INSERT INTO HAVE VALUES('$clid', $catid, NULL);";
        mysql_query($query);
        $_SESSION['flash_message'] .= "You've successfully added the category! ";
    } else {
        $_SESSION['flash_message'] .= "That category already exists!";
    }
    header("Location: /categories.php");


    CleanUpDB();

    exit;
?>
