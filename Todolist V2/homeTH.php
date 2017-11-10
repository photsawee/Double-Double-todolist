<?php require_once('Connections/myconnect.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "indexTH.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "indexTH.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_todolist = 10;
$pageNum_todolist = 0;
if (isset($_GET['pageNum_todolist'])) {
  $pageNum_todolist = $_GET['pageNum_todolist'];
}
$startRow_todolist = $pageNum_todolist * $maxRows_todolist;

mysql_select_db($database_myconnect, $myconnect);
$query_todolist = "SELECT * FROM todolist";
$query_limit_todolist = sprintf("%s LIMIT %d, %d", $query_todolist, $startRow_todolist, $maxRows_todolist);
$todolist = mysql_query($query_limit_todolist, $myconnect) or die(mysql_error());
$row_todolist = mysql_fetch_assoc($todolist);

if (isset($_GET['totalRows_todolist'])) {
  $totalRows_todolist = $_GET['totalRows_todolist'];
} else {
  $all_todolist = mysql_query($query_todolist);
  $totalRows_todolist = mysql_num_rows($all_todolist);
}
$totalPages_todolist = ceil($totalRows_todolist/$maxRows_todolist)-1;

$maxRows_user = 10;
$pageNum_user = 0;
if (isset($_GET['pageNum_user'])) {
  $pageNum_user = $_GET['pageNum_user'];
}
$startRow_user = $pageNum_user * $maxRows_user;

mysql_select_db($database_myconnect, $myconnect);
$query_user = "SELECT * FROM `user`";
$query_limit_user = sprintf("%s LIMIT %d, %d", $query_user, $startRow_user, $maxRows_user);
$user = mysql_query($query_limit_user, $myconnect) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);

if (isset($_GET['totalRows_user'])) {
  $totalRows_user = $_GET['totalRows_user'];
} else {
  $all_user = mysql_query($query_user);
  $totalRows_user = mysql_num_rows($all_user);
}
$totalPages_user = ceil($totalRows_user/$maxRows_user)-1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>TO DO LIST</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="image/icon/logoblack.ico" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="assets/js/remove.js" ></script>
  <link rel="stylesheet" href="assets/css/m.css" />
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="homeTH.php">TO DO LIST</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="addTH.php">เพิ่มงาน</a></li>
        <li><a href="home.php">ภาษาอังกฤษ</a></li>
        <li><a href="#">ภาษาไทย</a></li>
        <form class="navbar-form navbar-left" action="searchTH.php" method="post">
        
      <div class="input-group">
        <input type="text" name="word" class="form-control" placeholder="ค้นหา">
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </div>
      </div>
    </form>
      </ul>
      <ul class="nav navbar-nav navbar-right">
     
        <li><a href="<?php echo $logoutAction ?>"><span class="glyphicon glyphicon-log-in"></span> ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
    	<img src="image/Home/to_do_list_logo.png" style="width:50%" />
        <hr>
    	<p><a href="showalllistTH.php">รายการทั้งหมด</a></p>
      	<p><a href="showlistpendingTH.php">รายการที่รอดำเนินการ</a></p>
      	<p><a href="showlistcompleteTH.php">รายการที่เสร็จสมบูรณ์</a></p>
    </div>
    <div class="col-sm-8 text-left"> 
    <h1>ยินดีต้อนรับ</h1>
    <hr>
    <p style="font-size:20px">วิธีใช้งาน<br></p><p style="font-size:18px">ท่านสามารถเพิ่มงานได้ที่ เพิ่มงาน<br>ท่านสามารถตรวจสอบรายการทั้งหมดได้ที่ รายการทั้งหมด<br>ท่านสามารถตรวจสอบรายการที่รอดำเนินงานได้ที่ รายการที่รอดำเนินการ<br>ท่านสามารถตรวจสอบรายการที่ทำงานสำเร็จแล้วได้ที่ รายการที่เสร็จสมบูรณ์<br>ท่านสามารถค้นหางานได้ที่ การค้นหา</p>
    </div>

  </div>
</div>

</body>
</html>
<?php
mysql_free_result($todolist);

mysql_free_result($user);
?>
