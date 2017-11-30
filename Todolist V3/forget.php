
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
		
        <div class="container">
		
		<div class="login-box animated fadeInUp">
			<div class="box-header">
				<h3>Forget Password</h3>
			</div>
          <form  METHOD="POST" action="send.php">
			<label for="username">Username: </label>
            <input type="text" id="username" name="username" placeholder="UserName" required>
			<label for="email">E-Mail: </label>
            <input type="email" id="email" name="email" placeholder="E-mail" required>
			<button type="submit">Send </button>
            <button type="reset" >Reset </button>
            <br />
            <a href="login.php">Back</a>
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