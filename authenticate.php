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
    $CLID = mysql_real_escape_string($_POST['CLID']);
    $password = mysql_real_escape_string($_POST['password']);

    $query = "SELECT CLID, PASSWD, FNAME, LNAME, SU FROM STUDENT WHERE CLID = '" . $CLID . "';";

    $res = mysql_query($query);

    $row = mysql_fetch_assoc($res);
    if($row &&
        $row['CLID'] == $CLID &&
        $row['PASSWD'] == $password){
        $_SESSION['logged_in'] = true;
        $_SESSION['CLID'] = $CLID;
        $_SESSION['FNAME'] = $row['FNAME'];
        $_SESSION['LNAME'] = $row['LNAME'];
        $_SESSION['SU'] = $row['SU'];
        if($_SESSION['SU'] == 1){
            $_SESSION['SU_CLID'] = $CLID;
            $_SESSION['SU_FNAME'] = $row['FNAME'];
            $_SESSION['SU_LNAME'] = $row['LNAME'];
        }
        $_SESSION['flash_message'] = "You've been successfully authenticated!";
        header('Location: index.php');
    } else {
        $_SESSION['flash_message'] = "You've entered an invalid CLID or password!";
        header('Location: login.php');
    }
    CleanUpDB();

    exit;
?>
