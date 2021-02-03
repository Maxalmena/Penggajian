<?php 

include('server.php'); 

session_start();
$connect = mysqli_connect("localhost", "root", "", "test");
		
		//if user is not logged in, they cannot acces this page
		if (empty($_SESSION['Username'])) {
			header("location: index.php");
		}
?>



<!-- <!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Home Page</h2>
	</div>

	<div class="content">
		<?php if (isset($_SESSION['success'])): ?>
		<div class="error success">
			<h3>
				<?php
					echo $_SESSION['success'];
					unset($_SESSION['success']);
				?>
			</h3>
		</div>
		<?php endif ?>

		<?php if (isset($_SESSION["Username"])): ?>
			<p>Welcome <strong><?php echo $_SESSION['Username']; ?></strong></p>
			<p><a href="index.php?logout='1'" style="color: red;">Logout</a></p>
		<?php endif ?>

	</div>

</body>
</html> -->


<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
	<?php
				$query = "SELECT count(*) as jumlah from tbl_product";
				$result = mysqli_query($connect, $query);
				$row = mysqli_fetch_array($result)		
		?>
	<nav class="nav-main">
		<div class="btn-toggle-nav" onclick="toggleNav()"></div>
		<p>dri-Gent</p>
		<ul>
			<li><a href="home.php">Home</a></li>
			<li><a href="#">Profile</a>
				<ul>
					<li><a href="#">Edit Profile</a></li>
					<li><a href="#">Terms & Conditions</a></li>
				</ul>
			</li>
			<li><a href="#">About Me</a></li>
			<li><a href="index.php?logout='1'" style="color: red;">Logout</a></li>
		</ul>
	</nav>

	<aside class="nav-sidebar">
		
		<ul>			
			<?php if (isset($_SESSION["Username"])): ?>
				<li><span><?php echo $_SESSION['Username']; ?></span></li>
			<?php endif ?>
			<li><a href="#">Notification</a></li>
			<li><a href="#">Payment</a></li>
			<li><a href="#">Point</a></li>
			<li> <a href="buy.php">Buy <span class="label label-default">  <?php echo $row['jumlah']; ?></span></a> </li>
			<li><a href="#">Setting</a></li>

		</ul>
	</aside>
</body>
<script src="home.js">

</script>
</html>