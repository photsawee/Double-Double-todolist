
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
								<li><a href="index.php">หน้าหลัก</a></li>
								<li><a href="register.php">สมัครสมาชิก</a></li>
								<li><a href="login.php">เข้าสู่ระบบ</a></li>
                                <li><a href="forget.php">ภาษาอังกฤษ</a></li>     
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
				<h3>ลืมรหัสผ่าน</h3>
			</div>
          <form  METHOD="POST" action="sendTH.php">
			<label for="username">ชื่อผู้ใช้: </label>
            <input type="text" id="username" name="username" placeholder="UserName" required>
			<label for="email">E-Mail: </label>
            <input type="email" id="email" name="email" placeholder="E-mail" required>
			<button type="submit">ส่ง </button>
            <button type="reset" >ล้าง </button>
            <br />
            <a href="login.php">กลับ</a>
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