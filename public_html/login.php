<?php
require "../library/template.php";
$conn = start();
?>
<html>
<head>
	<title>Anywhere Air</title>
	<link rel="icon" type="image/ico" href="images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/blackrose_regular_macroman/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="fonts/nautilus/stylesheet.css" />
	
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="js.cookie/jquery.cookie.js"></script>
	<script src="js/cookie.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/login.css" />
	<script src="js/login.js"></script>
	
	<script>

	</script>
	
</head>

<body>

	<div id="wall"></div>

	<div id="full">
	
		<?php
		header_print($conn);	
		?>
		
		<br/>	
		
		<div id="container" class="clearfix">
			
			<div id="content">
				<p>You can login here or create an account!</p>
			</div>
			
			<hr>
			<br/>
			
			<div id="login">
				<form action="php/login" method="post">
					<p>Login</p>
					<input type="text" name="user" placeholder="Username" required></input>
					<input type="password" name="pass" placeholder="Password" required></input>
					<button type="submit">Login <i class="fa fa-user"></i></button>
				</form>
			</div>
			
			<div id="spacer">
			</div>
			
			<div id="register">
				<form action="php/register" method="post">
					<p>Register</p>
					<input type="text" name="user" placeholder="Username" required></input>
					<input id="org_pass" type="password" name="org_pass" placeholder="Password" required></input>
					<input id="re_pass" type="password" name="re_pass" placeholder="Re-Type Password" required></input>
					<input type="email" name="email" placeholder="Email" required></input>
					<button type="submit">Register <i class="fa fa-user-plus"></i></button>
				</form>
			</div>
		</div>
	</div>
</body>

<footer>
	<?php
	footer_print($conn);	
	?>
</footer>
</html>