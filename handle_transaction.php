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
    $clid = $_SESSION['CLID'];
    $page_name = mysql_real_escape_string($_POST['page_name']);
    $type = mysql_real_escape_string($_POST['type']);
    $amount = mysql_real_escape_string($_POST['amount']);
    $category_id = mysql_real_escape_string($_POST['category']);
    $busname = mysql_real_escape_string($_POST['busname']);
    $date = mysql_real_escape_string($_POST['date']);
	$checknum = mysql_real_escape_string($_POST['checknum']);
    $correct_date = ValidateDate($date);
    $_SESSION['flash_message'] = ""; 
    $fail = false;
    if(!$type ){
        $_SESSION['flash_message'] .= "Something went wrong! ";
        $fail = true;
    } 
    if(!$correct_date){
        $_SESSION['flash_message'] .= "You have entered an invalid date! ";
        $fail = true;
    }
    $matches; 
    preg_match("/^(\d+(\.\d{1,2})?)$/", $amount, $matches);
    if(!$amount || !$matches[1]){
        Debug($matches);
        $_SESSION['flash_message'] .= "You must enter a correct amount! ";
        $fail = true;
    }
    
    if($type == "expense"){
        preg_match("/^(\d*)$/", $checknum, $matches);
        if($checknum && !$matches[1]){
            $_SESSION['flash_message'] .= "You must enter a correct checking number! ";
            $fail = true;
        }
    }

    if(!$category_id){ 
        $_SESSION['flash_message'] .= "You must select a category! ";
        $fail = true;
    }

    if($type == "income"){
    } else if($type == "expense"){
        if(!$busname) {
            $fail = true;
            $_SESSION['flash_message'] .= "Something went wrong! ";
        }
    }else {
        $_SESSION['flash_message'] .= "Something went wrong! ";
        $fail = true;
    }
    
    if(!$fail){
        $clid = $_SESSION['CLID'];
        if($type == "income"){
            $query = "insert into INTRANS VALUES(NOW(), '$date', '$clid', $category_id, $amount)";
            $res = mysql_query($query);
            if($res){
                $query = "update STUDENT S SET S.CHECKBAL = S.CHECKBAL + $amount WHERE S.CLID = '$clid';";
                mysql_query($query);
                $_SESSION['flash_message'] .= "Successfully added transaction! ";
            } else {
                $_SESSION['flash_message'] .= "Failed to add transaction! ";
            }
        }
        else if($type == "expense"){
			if($amount > $_SESSION['CHECKBAL']){
				$_SESSION['flash_message'] .= "Insufficient Funds.";
				header('location: expense.php');
			}
			else{
                if($checknum) $checknum = "'" . $checknum . "'";
                else $checknum = "NULL";
				$query = "insert into EXTRANS VALUES(NOW(), '$date', '$clid', '$busname', $category_id, $checknum, $amount)";
				$res = mysql_query($query);
				if($res){
					$query = "update STUDENT S SET S.CHECKBAL = S.CHECKBAL - $amount WHERE S.CLID = '$clid';";
					mysql_query($query);
					$_SESSION['flash_message'] .= "Successfully added transaction! ";
					$query = "select GOAL from HAVE where CLID = '$clid' AND CATID = $category_id";
					$query2 = "select sum(AMOUNT) from EXTRANS where CLID = '$clid' AND CATID = $category_id group by CLID";
					$res1 = mysql_query($query);
					$res2 = mysql_query($query2);
					$row1 = mysql_fetch_assoc($res1);
					$row2 = mysql_fetch_assoc($res2);
					$goal = $row1['GOAL'];
					$actual = $row2['sum(AMOUNT)'];
					if($actual > $goal && $goal){
						$str = "
						<b><mark> You have exceeded your goal! </b></mark>";
						$_SESSION['flash_message'] .= $str;
					}
				}
				else {
					$_SESSION['flash_message'] .= "Failed to add transaction! ";
				}
			}

        }
    }

    header('Location: ' . $page_name);
    CleanUpDB();

    exit;
?>
