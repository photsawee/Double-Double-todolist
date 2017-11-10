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
$query_todolist = "SELECT * FROM todolist";
$todolist = mysql_query($query_todolist, $myconnect) or die(mysql_error());
$row_todolist = mysql_fetch_assoc($todolist);
$totalRows_todolist = mysql_num_rows($todolist);

mysql_select_db($database_myconnect, $myconnect);
$query_user = "SELECT * FROM `user`";
$user = mysql_query($query_user, $myconnect) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);

mysql_select_db($database_myconnect, $myconnect);
$query_todolist1 = "SELECT * FROM todolist";
$todolist1 = mysql_query($query_todolist1, $myconnect) or die(mysql_error());
$row_todolist1 = mysql_fetch_assoc($todolist1);
$totalRows_todolist1 = mysql_num_rows($todolist1);

mysql_select_db($database_myconnect, $myconnect);
$query_user1 = "SELECT * FROM `user`";
$user1 = mysql_query($query_user1, $myconnect) or die(mysql_error());
$row_user1 = mysql_fetch_assoc($user1);
$totalRows_user1 = mysql_num_rows($user1);

mysql_select_db($database_myconnect, $myconnect);
$query_tag = "SELECT * FROM teg";
$tag = mysql_query($query_tag, $myconnect) or die(mysql_error());
$row_tag = mysql_fetch_assoc($tag);
$totalRows_tag = mysql_num_rows($tag);

mysql_select_db($database_myconnect, $myconnect);
$query_tag1 = "SELECT * FROM teg";
$tag1 = mysql_query($query_tag1, $myconnect) or die(mysql_error());
$row_tag1 = mysql_fetch_assoc($tag1);
$totalRows_tag1 = mysql_num_rows($tag1);

mysql_select_db($database_myconnect, $myconnect);
$query_tag2 = "SELECT * FROM teg";
$tag2 = mysql_query($query_tag2, $myconnect) or die(mysql_error());
$row_tag2 = mysql_fetch_assoc($tag2);
$totalRows_tag2 = mysql_num_rows($tag2);
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
   <style>
body {font-family: "Lato", sans-serif;}

/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>
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
        <li><a href="showalllist.php">ภาษาอังกฤษ</a></li>
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
        <li><a href="<?php echo $logoutAction ?>" ><span class="glyphicon glyphicon-log-in"></span> ออกจากระบบ</a></li>
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
    <h1>รายการทั้งหมด</h1>
    <hr>
       <div class="tab">
  			<button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">แสดงบางส่วน</button>
  			<button class="tablinks" onclick="openCity(event, 'Paris')">แสดงทั้งหมด</button>
		</div>
		<div id="London" class="tabcontent">
 <?php do { ?>
<?php if($_SESSION['MM_Username']==$row_user['UserName']){?>
    
    <div class="table-responsive">         
  <table class="table">
    <thead>
      <tr>
        <tr>
            <td>รายการ</td>
            <td>วันที่</td>
            <td>รายละเอียด</td>
            <td>สถานะ</td>
            <td>ตัวเลือก</td>
            <td>อื่นๆ</td>
  		</tr>
      </tr>
    </thead>
    <tbody>
     
      <?php do { ?><?php if($row_todolist['User_idUser']==$row_user['idUser']){ ?> 
     <?php if($row_todolist['Status']=="pending"){?>
    <tr>
      
      <td><?php echo $row_todolist['name']; ?></td>
      <td><?php echo $row_todolist['date']; ?></td>
      <td><textarea cols="25" rows="2" disabled><?php echo $row_todolist['decription']; ?></textarea></td>
      <td>รอดำเนินการ</td>
      
      <td><a href="EditTH.php?id=<?php echo $row_todolist['idToDoList']; ?>">แก้ไข</a> |  <a href="deleteTH.php?id=<?php echo $row_todolist['idToDoList']; ?>" onClick="remove()">ลบ</a></td>
      <td><label type="button" data-toggle="collapse" data-target="#<?php echo $row_todolist['idToDoList']; ?>">รายละเอียดต่างๆ</label><div id="<?php echo $row_todolist['idToDoList']; ?>" class="collapse">
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
    <div id="Paris" class="tabcontent">
    <?php do { ?>
<?php if($_SESSION['MM_Username']==$row_user1['UserName']){?>
    
    <div class="table-responsive">         
  <table class="table">
    <thead>
      <tr>
        <tr>
            <td>รายการ</td>
            <td>วันที่</td>
            <td>รายละเอียด</td>
            <td>สถานะ</td>
            <td>ตัวเลือก</td>
            <td>อื่นๆ</td>
  		</tr>
      </tr>
    </thead>
    <tbody>
     
      <?php do { ?><?php if($row_todolist1['User_idUser']==$row_user1['idUser']){ ?> 
     <?php if($row_todolist1['Status']=="pending"){?>
    <tr>
      
      <td><?php echo $row_todolist1['name']; ?></td>
      <td><?php echo $row_todolist1['date']; ?></td>
      <td><textarea cols="25" rows="2" disabled><?php echo $row_todolist1['decription']; ?></textarea></td>
      <td>รอดำเนินการ</td>
      <td><a href="EditTH.php?id=<?php echo $row_todolist1['idToDoList']; ?>">แก้ไข</a> |  <a href="deleteTH.php?id=<?php echo $row_todolist1['idToDoList']; ?>" onClick="remove()">ลบ</a></td>
      <td><label type="button" data-toggle="collapse" data-target="#<?php echo $row_todolist1['idToDoList']; ?>1">รายละเอียดต่างๆ</label><div id="<?php echo $row_todolist1['idToDoList']; ?>1" class="collapse">
      หมวดหมู่ :
      <?php if($row_todolist1['category']=="Workplace") {?>
      งานที่ทำงาน<br>
      <?php }else if($row_todolist1['category']=="Work at home"){?>
      งานที่บ้าน<br>
      <?php } else if($row_todolist1['category']=="Meeting") {?>
      งานชุมนุม<br>
      <?php }else{?>
      ชมรมที่ไปเข้าร่วม<br>
      <?php }?>
      ความสำคัญ :
      <?php if($row_todolist1['priority']==3){?>
      มีความสำคัญมาก<br>
      <?php } else if($row_todolist1['priority']==2){?>
      มีความสำคัญปานกลาง<br>
      <?php }else{?>
      มีความสำคัญน้อย<br>
      <?php }?>
      </div></td>
    </tr>
    <?php }else{?>
	<tr>
      
      <td><?php echo $row_todolist1['name']; ?></td>
      <td><?php echo $row_todolist1['date']; ?></td>
      <td><textarea cols="25" rows="2" disabled><?php echo $row_todolist1['decription']; ?></textarea></td>
      <td>เสร็จสมบูรณ์</td>
      <td><a href="deleteTH.php?id=<?php echo $row_todolist1['idToDoList']; ?>" onClick="remove()">ลบ</a></td>
      <td><label type="button" data-toggle="collapse" data-target="#<?php echo $row_todolist1['idToDoList']; ?>2">รายละเอียดต่างๆ</label><div id="<?php echo $row_todolist1['idToDoList']; ?>2" class="collapse">
      หมวดหมู่ :
      <?php if($row_todolist1['category']=="Workplace") {?>
      งานที่ทำงาน<br>
      <?php }else if($row_todolist1['category']=="Work at home"){?>
      งานที่บ้าน<br>
      <?php } else if($row_todolist1['category']=="Meeting") {?>
      งานชุมนุม<br>
      <?php }else{?>
      ชมรมที่ไปเข้าร่วม<br>
      <?php }?>
      ความสำคัญ :
      <?php if($row_todolist1['priority']==3){?>
      มีความสำคัญมาก<br>
      <?php } else if($row_todolist1['priority']==2){?>
      มีความสำคัญปานกลาง<br>
      <?php }else{?>
      มีความสำคัญน้อย<br>
      <?php }?>
 
      </div></td>
    </tr>
	<?php }}?>
    <?php } while ($row_todolist1 = mysql_fetch_assoc($todolist1)); ?>
    
    
     
    
    
    </tbody>
  </table>
  </div>
    <?php } ?>       
	<?php } while ($row_user1 = mysql_fetch_assoc($user1)); ?>
    </div>
    </div>
  </div>
</div>
<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
</body>
</html>
<?php
mysql_free_result($todolist);

mysql_free_result($user);

mysql_free_result($todolist1);

mysql_free_result($user1);

mysql_free_result($tag);

mysql_free_result($tag1);

mysql_free_result($tag2);
?>
