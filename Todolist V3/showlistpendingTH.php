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

mysql_select_db($database_myconnect, $myconnect);
$query_todolist = "SELECT * FROM todolist ORDER BY priority DESC";
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
   <script src="assets/js/remove.js" ></script>
  <link rel="stylesheet" href="assets/css/m.css" />
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
      <a class="navbar-brand" href="homeTH.php">TO DO LIST</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="addTH.php">เพิ่มงาน</a></li>
        <li><a href="showlistpending.php">ภาษาอังกฤษ</a></li>
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
    <div class="col-sm-2 sidenav" style="background:none">
    	<img class="img-rounded" alt="Cinque Terre" src="image/Home/to_do_list_logo.png" style="width:50%" />
       	<br><br><br><br><br><br>
    	<a href="showalllistTH.php"><p style="color:#FFF;font-size:24px">รายการทั้งหมด</p></a>
      	<a href="showlistpendingTH.php"><p style="color:#FFF;font-size:24px">รายการที่รอดำเนินการ</p></a>
      	<a href="showlistcompleteTH.php"><p style="color:#FFF;font-size:24px">รายการที่เสร็จสมบูรณ์</p></a>
    </div>
    <div class="col-sm-8 text-left"> 
    <h1 style="color:#FFF">รายการที่รอดำเนินการ</h1>
    <hr>
     <?php do { ?>
<?php if($_SESSION['MM_Username']==$row_user['UserName']){?>
    
    <div class="table-responsive" style="background-color:#CCC">         
  <table class="table" >
    <thead>
      <tr>
        <tr>
        	<td><label for="text" style="color:#000;font-size:18px">รายการ</label></td>
            <td><label for="text" style="color:#000;font-size:18px">วันที่</label></td>
            <td><label for="text" style="color:#000;font-size:18px">รายละเอียด</label></td>
            <td><label for="text" style="color:#000;font-size:18px">สถานะ</label></td>
            <td><label for="text" style="color:#000;font-size:18px">ตัวเลือก</label></td>
            <td><label for="text" style="color:#000;font-size:18px">อื่นๆ</label></td>
  		</tr>
      </tr>
    </thead>
    <tbody>
     
      <?php do { ?><?php if($row_todolist['User_idUser']==$row_user['idUser']){ ?> 
     <?php if($row_todolist['Status']=="pending"){?>
    <tr>
      
      <td><label for="text" style="color:#000;font-size:14px"><?php echo $row_todolist['name']; ?></label></td>
      <td><label for="text" style="color:#000;font-size:14px"><?php echo $row_todolist['date']; ?></label></td>
      <td><textarea class="form-control" cols="25" rows="2" disabled style="color:#000;font-size:14px"><?php echo $row_todolist['decription']; ?></textarea></td>
      <td><label for="text" style="color:#000;font-size:14px">รอดำเนินการ</label></td>
      <td><a href="EditTH.php?id=<?php echo $row_todolist['idToDoList']; ?>"><label for="text" style="color:#000;font-size:14px">แก้ไข  <span class="glyphicon glyphicon-cog"></span></label></a> <label for="text" style="color:#000;font-size:14px">|</label>  <a href="deleteTH.php?id=<?php echo $row_todolist['idToDoList']; ?>" onClick="remove()"><label for="text" style="color:#000;font-size:14px">ลบ <span class="glyphicon glyphicon-trash"></span></label></a></td>
      <td><label for="text" style="color:#000;font-size:14px" type="button" data-toggle="collapse" data-target="#<?php echo $row_todolist['idToDoList']; ?>1">รายละเอียดต่างๆ</label><div id="<?php echo $row_todolist['idToDoList']; ?>1" class="collapse">
     <label for="text" style="color:#000;font-size:14px">
      หมวดหมู่ :
      <?php if($row_todolist['category']=="Workplace") {?>
      งานที่ทำงาน<br>
      <?php }else if($row_todolist['category']=="Work at home"){?>
      งานที่บ้าน<br>
      <?php } else if($row_todolist['category']=="Meeting") {?>
      งานชุมนุม<br>
      <?php }else{?>
      ชมรมที่ไปเข้าร่วม<br>
      <?php }?>
      ความสำคัญ :
      <?php if($row_todolist['priority']==3){?>
      มีความสำคัญมาก<br>
      <?php } else if($row_todolist['priority']==2){?>
      มีความสำคัญปานกลาง<br>
      <?php }else{?>
      มีความสำคัญน้อย<br>
      <?php }?>
      </label>
      </div></td>
    </tr>

	<?php }}?>
    <?php } while ($row_todolist = mysql_fetch_assoc($todolist)); ?>
    
    
     
    
    
    </tbody>
  </table>
  </div>
    <?php } ?>       
	<?php } while ($row_user = mysql_fetch_assoc($user)); ?>
    </div>
  </div>
</div>

</body>
</html>
<?php
mysql_free_result($todolist);

mysql_free_result($user);
?>
