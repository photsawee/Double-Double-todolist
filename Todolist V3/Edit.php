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
	
  $logoutGoTo = "index.php";
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

$MM_restrictGoTo = "index.php";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE todolist SET name=%s, `date`=%s, decription=%s, Status=%s, category=%s, priority=%s, User_idUser=%s WHERE idToDoList=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['decription'], "text"),
                       GetSQLValueString($_POST['Status'], "text"),
                       GetSQLValueString($_POST['category'], "text"),
                       GetSQLValueString($_POST['priority'], "text"),
                       GetSQLValueString($_POST['User_idUser'], "int"),
                       GetSQLValueString($_POST['idToDoList'], "int"));

  mysql_select_db($database_myconnect, $myconnect);
  $Result1 = mysql_query($updateSQL, $myconnect) or die(mysql_error());

  $updateGoTo = "showalllist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_todolist = "-1";
if (isset($_GET['id'])) {
  $colname_todolist = $_GET['id'];
}
mysql_select_db($database_myconnect, $myconnect);
$query_todolist = sprintf("SELECT * FROM todolist WHERE idToDoList = %s", GetSQLValueString($colname_todolist, "int"));
$todolist = mysql_query($query_todolist, $myconnect) or die(mysql_error());
$row_todolist = mysql_fetch_assoc($todolist);
$totalRows_todolist = mysql_num_rows($todolist);

mysql_select_db($database_myconnect, $myconnect);
$query_user = "SELECT * FROM `user`";
$user = mysql_query($query_user, $myconnect) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);
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
  <link rel="stylesheet" href="assets/css/m.css" />
  <script src="assets/js/remove.js" ></script>
  <script src="assets/js/date.js"></script>
  
</head>
<body background="image/bg/1821-9.jpg">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="home.php">TO DO LIST</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="add.php">Add Task</a></li>
        <li><a href="#">English LANGUAGE</a></li>
        <li><a href="showalllistTH.php">THAI LANGUAGE</a></li>
        <form class="navbar-form navbar-left" action="search.php" method="post">
        
      <div class="input-group">
        <input type="text" name="word" class="form-control" placeholder="Search">
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </div>
      </div>
    </form>
      </ul>
      <ul class="nav navbar-nav navbar-right">
         <li><a href="<?php echo $logoutAction ?>"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav" style="background:none">
    	<img class="img-rounded" alt="Cinque Terre" src="image/Home/to_do_list_logo.png" style="width:50%" />
       	<br><br><br><br><br><br>
    	<a href="showalllist.php"><p style="color:#FFF;font-size:24px">All List</p></a>
      	<a href="showlistpending.php"><p style="color:#FFF;font-size:24px">List Pending</p></a>
      	<a href="showlistcomplete.php"><p style="color:#FFF;font-size:24px">List Completed</p></a>
    </div>
    <div class="col-sm-8 text-left"> 
    <h1 style="color:#FFF">Edit Task</h1>
    <hr>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onSubmit="return fndate()">
    	<div class="row">
    	<div class="col-sm-4">
    	<label for="text"  style="color:#FFF;font-size:20px" > List Name :</label>
      	<input class="form-control" type="text" name="name" value="<?php echo htmlentities($row_todolist['name'], ENT_COMPAT, 'utf-8'); ?>" size="32">
        </div></div><br>
      	<div class="row">
    <div class="col-sm-4">
    <label for="text"  style="color:#FFF;font-size:20px" >  Due Date &nbsp;:</label>
    	<input class="form-control" type="date" name="date" id="date" value="<?php echo htmlentities($row_todolist['date'], ENT_COMPAT, 'utf-8'); ?>" size="32">
        <input type="date" name="date1" id="date1" value="<?php echo date('Y-m-d');?>" hidden="hidden"></div></div><br>
        <div class="row">
    <div class="col-sm-4">
    <label for="text"  style="color:#FFF;font-size:20px" >Description</label><br>
        <textarea class="form-control" name="decription" id="decription" rows="10" cols="50"><?php echo htmlentities($row_todolist['decription'], ENT_COMPAT, 'utf-8'); ?></textarea></div></div><br>
        <div class="row">
    <div class="col-sm-4">
    <label for="text"  style="color:#FFF;font-size:20px" >Category :</label>
    <select class="form-control" name="category" id="category">
    <option value="Workplace" selected>Workplace</option>
    <option value="Work at home">Work at home</option>
    <option value="meeting">Meeting</option>
    <option value="Clubs to attend">Clubs to attend</option>
    </select>
    </div>
    </div>
    <br >
    <div class="row">
    <div class="col-sm-4">
    <label for="text"  style="color:#FFF;font-size:20px" >Priority :</label>
    <select class="form-control" name="priority" id="priority">
    <option value="3" selected>Very important</option>
    <option value="2">Moderately important</option>
    <option value="1">Less important</option>
    </select>
    <br >
    </div>
    </div>
    <div class="row">
    <div class="col-sm-4">
    <label for="text"  style="color:#FFF;font-size:20px" >Status   :</label>

        <select class="form-control" name="Status" id="Status">
          <option value="pending" selected="selected">Pending</option>
          <option value="done">Completed</option>
          </select>
          </div>
          </div>
          <br>
          <input type="text" name="User_idUser" value="<?php echo htmlentities($row_todolist['User_idUser'], ENT_COMPAT, 'utf-8'); ?>" size="32" hidden="hidden"><br>
          <input class="btn btn-default" type="submit" value="Edit Task" onClick="edit()">
      <input type="hidden" name="MM_update" value="form1">
      <input type="hidden" name="idToDoList" value="<?php echo $row_todolist['idToDoList']; ?>">
    </form>
    <p>&nbsp;</p>
    </div>
  </div>
</div>


  

</body>
</html>
<?php
mysql_free_result($todolist);

mysql_free_result($user);
?>
