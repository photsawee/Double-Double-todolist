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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO `user` (UserName, Password, EMail) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['email'], "text"));

  mysql_select_db($database_myconnect, $myconnect);
  $Result1 = mysql_query($insertSQL, $myconnect);
   
	if(isset($Result1)){
		$insertGoTo = "loginTH.php";
		header(sprintf("Location: %s", $insertGoTo));
	}else{
		
  $insertGoTo = "registerTH.php";
  if (isset($_SERVER['QUERY_STRING'])) {
	  
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}}
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
                                <li><a href="register.php">ภาษาอังกฤษ</a></li>     
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
				<h3>สมัครสมาชิก</h3>
                
			</div>
            
          <form method="POST" action="<?php echo $editFormAction; ?>"  name="form">
			<label for="username">ชื่อผู้ใช้: </label>
            <input type="text" id="username" name="username" placeholder="Username" required>
			<label for="password">รหัสผ่าน: </label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <label for="E-Mail">E-Mail: </label>
            <input type="email" id="email" name="email" placeholder="E-Mail" required>
			<button type="submit">สมัครสมาชิก</button>
            <button type="reset" >ล้าง</button>
            <ul class="icons">
			<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
			<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
			<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
			<li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
			</ul>
            <input type="hidden" name="MM_insert" value="form">
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