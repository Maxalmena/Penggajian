<?php include('server.php'); 
		
		// if user is not logged in, they cannot acces this page
		// if (empty($_SESSION['Username'])) {
		// 	header("location: login.php");
		// }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>

	<nav class="nav-main">
		<div class="btn-toggle-nav" onclick="toggleNav()"></div>
		<p>dri-Gent</p>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="#">Profile</a>
				<!-- <ul>
					<li><a href="#">Digital Art</a></li>
					<li><a href="#">Video Production</a></li>
					<li><a href="#">Web Development</a></li>
				</ul> -->
			</li>
			<li><a href="#">About Me</a></li>
			<li><a href="login.php">Login</a></li>
		</ul>
	</nav>

	<aside class="nav-sidebar">
		<ul>
			<li><span>Welcome</span></li>
			<li><a href="#">Notification</a></li>
			<li><a href="#">Payment</a></li>
			<li><a href="#">Point</a></li>
			<li><a href="#">Buy</a></li>
			<li><a href="#">Setting</a></li>
		</ul>
	</aside>
</body>
<script src="home.js">

</script>
</html>