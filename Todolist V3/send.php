
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
					<a href="#menu" class="menuToggle"><span>Menu</span></a>
						<div id="menu">
							<ul>
								<li><a href="index.php">Home</a></li>
								<li><a href="register.php">Sign Up</a></li>
								<li><a href="login.php">Log In</a></li>
                                <li><a href="">English-Language</a></li>     
                                <li><a href="forgetTH.php">Thai-Language</a></li>
                                <li><a href="https://html5up.net/">Credit</a><li>
							</ul>
						</div>
					</li>
				</ul>
			</nav>
	</header>
  	<section id="banner">
		<?php
			mysql_connect("localhost","u947295015_bank","b0857115660");
			mysql_select_db("u947295015_todo");
			$strSQL = "SELECT * FROM user WHERE UserName = '".trim($_POST['username'])."'
			AND EMail = '".trim($_POST['email'])."' ";
			$objQuery = mysql_query($strSQL);
			$objResult = mysql_fetch_array($objQuery);
			if(!$objResult)
			{
				echo "Not Found Username or Email!";
				?><p><a href="forget.php">Forget</a></p><?php
			}
			else
			{
				echo "Your password send successful.<br>Send to mail : ".$objResult["EMail"];
				?><p><a href="login.php">Login</a></p>
				<?php    
				$strTo = $objResult["EMail"];
				$strSubject = "Your Account information username and password.";
				$strHeader = "Content-type: text/html; charset=UTF-8\n";
				$strHeader .= "From: ddtodolist60@gmail.com\nReply-To: ddtodolist60@gmail.com";
				$strMessage = "";
				$strMessage .= "Username : ".$objResult["UserName"]."<br>";
				$strMessage .= "Password : ".$objResult["Password"]."<br>";
				$strMessage .= "=================================<br>";
				$strMessage .= "ddtodolist.com<br>";
				$flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);
			}
			mysql_close();
		?>
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