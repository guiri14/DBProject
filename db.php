<?php
/*

Authors: Connor Stanford, Joseph Fontenot, Hoang Pham, Hung Le
CLIDs: cxs0290, jdf7386, hhp6148, hql0510
Date: 4/24/16
Certification: We certify that this code was completely done by the authors.

*/
?>

<?php
$user = 'root';
$pass = 'database';
$db_name = 'sftd';
$db;
function ValidateDate($date){
    $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
}
function Debug($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}
function GetDB(){
    global $user;
    global $pass;
    global $db;
    global $db_name;
    $db = mysql_connect('localhost', $user, $pass);
    if(!$db){
        die('Could not connect: ' . mysql_error());
    }
    $db_selected = mysql_select_db($db_name, $db);
    if(!$db_selected){
        die('Could not use database: ' . mysql_error());
    }
}
function CleanUpDB(){
    global $db;
    mysql_close($db); 
}
function IsLoggedIn(){
    $logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
    return $logged_in;
}
function GetFullCatname($catid){
    $query = "SELECT C.CATID, C.CATNAME, C.PCAT FROM CATEGORY C WHERE C.CATID = $catid;";
    $res = mysql_query($query);
    $original = mysql_fetch_assoc($res);
    $fullname = $original['CATNAME'];
    $cur_cat = $original;
    while($cur_cat['PCAT'] != NULL){
        $pcat = $cur_cat['PCAT'];
        $query = "SELECT C.CATID, C.CATNAME, C.PCAT FROM CATEGORY C WHERE C.CATID = $pcat;";
        $res = mysql_query($query);
        $cur_cat = mysql_fetch_assoc($res);
        if($cur_cat["CATNAME"] != "Income" && $cur_cat["CATNAME"] != "Expenses")
            $fullname = $cur_cat["CATNAME"] . "/" . $fullname;
    }
    return $fullname;
}
function GetChildCategories($id){
    $children = array();
    $clid = $_SESSION['CLID'];
    $query = "(SELECT C.CATID, C.CATNAME, C.PCAT, C.TYPE, NULL as GOAL FROM CATEGORY C WHERE C.PCAT=$id AND C.IS_DEFAULT = 1 AND NOT EXISTS (SELECT * FROM CATEGORY C2, HAVE H WHERE C2.CATID=C.CATID AND H.CATID = C2.CATID))";
    $query2 = "(SELECT C.CATID, C.CATNAME, C.PCAT, C.TYPE, H.GOAL FROM CATEGORY C, HAVE H WHERE C.PCAT=$id AND (H.CATID = C.CATID AND H.CLID = '$clid' ))";
    $res = mysql_query($query . " UNION " . $query2 . " ORDER BY CATNAME;");

    while($row = mysql_fetch_assoc($res)){
        array_push($children, $row);
    }

    return $children;
}
?>
