<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="header">
		<h2>Register</h2>
	</div>

	<form method="post" action="register.php">
		<!-- display validation errors here -->
	
		<div class="input-group">
			<label>Username</label>
			<input type="text" name="Username" value="">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="text" name="Email" value="">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="Password1">
		</div>
		<div class="input-group">
			<label>Confirm Password</label>
			<input type="password" name="Password2">
		</div>
		<div class="input-group">
			<button type="submit" name="register" class="btn">Register</button>
		</div>
		<p>
			Already a member?<a href="login.php">Sign in</a>
		</p>
	</form>

</body>
</html>