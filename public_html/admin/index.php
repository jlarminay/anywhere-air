<html>
<head>
	<title>Admin Page</title>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<style>
	#container {
		background-color: grey;
	}
	#log {
		text-align: center;
	}
	#log input {
		width: 80%;
		padding: 10px;
		margin: 5px;
		text-align: center;
		border: 0;
	}
	</style>
</head>

<body>
	<div id="container" style="width:50%;margin:auto;border:1px solid black;">
		<form action="login.php" method="post" id="log">
			<h2>Admin Login</h2>
			<input type="text" id="user" name="user" placeholder="Username" required></input>
			<input type="password" id="pass" name="pass" placeholder="Password" required></input>
			<input type="submit"></input>
		</form>
	</div>
</body>

<footer>
</footer>
</html>