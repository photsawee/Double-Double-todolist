<?php require_once('Connections/myconnect.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "homeTH.php";
  $MM_redirectLoginFailed = "loginTH.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_myconnect, $myconnect);
  
  $LoginRS__query=sprintf("SELECT UserName, Password FROM `user` WHERE UserName=%s AND Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $myconnect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>TO DO LIST</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="assets/css/main.css" />
<link rel="icon" href="image/icon/logoblack.ico" />
<link rel="stylesheet" href="assets/css/animate.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="landing">
<div id="page-wrapper">
	<header id="header" class="alt">
		<h1><a href="index.php">DD TODOLIST</a></h1>
			<nav id="nav">
				<ul>
					<li class="special">
					<a href="#menu" class="menuToggle"><span>เมนู</span></a>
						<div id="menu">
							<ul>
								<li><a href="indexTH.php">หน้าหลัก</a></li>
								<li><a href="registerTH.php">สมัครสมาชิก</a></li>
								<li><a href="loginTH.php">เข้าสู่ระบบ</a></li>
                                <li><a href="login.php">ภาษาอังกฤษ</a></li>     
                                <li><a href="#">ภาษาไทย</a></li>
                                <li><a href="https://html5up.net/">เครดิต</a><li>
							</ul>
						</div>
					</li>
				</ul>
			</nav>
	</header>
	<section id="banner">
		
        <div class="container">
		
		<div class="login-box animated fadeInUp">
			<div class="box-header">
				<h3>เข้าสู่ระบบ</h3>
			</div>
          <form ACTION="<?php echo $loginFormAction; ?>"  METHOD="POST">
			<label for="username">ชื่อผู้ใช้: </label>
            <input type="text" id="username" name="username" placeholder="UserName" required>
			<label for="password">รหัสผ่าน: </label>
            <input type="password" id="password" name="password" placeholder="Password" required>
			<button type="submit">เข้าสู่ระบบ </button>
            <button type="reset" >ล้าง </button>
            <br>
            <p style="color:#000"><a href="forgetTH.php">ลืมรหัสผ่าน?</a></p>
            <ul class="icons">
			<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
			<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
			<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
			<li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
			</ul>
            </form>
           
		</div>
	</div>
	</section>
 
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>