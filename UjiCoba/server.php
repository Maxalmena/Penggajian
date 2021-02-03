<?php
	session_start();

	$Username ="";
	$Email = "";
	$Error = array();
	// connect to the database
	$db = mysqli_connect('localhost', 'root', '', 'registration');

	// if the register button is clicked
	if (isset($_POST['register'])) {
		$Username = mysqli_real_escape_string($db, $_POST['Username']);
		$Email = mysqli_real_escape_string($db, $_POST['Email']);
		$Password1 = mysqli_real_escape_string($db, $_POST['Password1']);
		$Password2 = mysqli_real_escape_string($db, $_POST['Password2']);

		// ensure that form fields are filled properly
		if (empty($Username)) {
			array_push($Error, "Username is required");
		}
		if (empty($Email)) {
			array_push($Error, "Email is required");
		}
		if (empty($Password1)) {
			array_push($Error, "Password is required");
		}
		if ($Password1 != $Password2) {
			array_push($Error, "The two passwords do not match");
		}

		// if there are no errors, save the user database
		if (count($Error) == 0){
			$Password = md5($Password1); // encrypt password before storing in database (security)
			$sql = "INSERT INTO users (Username, Email, Password)
						VALUES ('$Username', '$Email', '$Password')";
			mysqli_query($db, $sql);
			$_SESSION['Username'] = $Username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php'); // redirect to home page
		}
	}

	// log user in from login page
	if(isset($_POST['login'])) {
		$Username = mysqli_real_escape_string($db, $_POST['Username']);
		$Password = mysqli_real_escape_string($db, $_POST['Password']);

		// ensure that form fields are filled properly
		if (empty($Username)) {
			array_push($Error, "Username is required");
		}
		if (empty($Password)) {
			array_push($Error, "Password is required");
		}

		if (count($Error) == 0 ) {
			$Password = md5($Password); // encrypt password before comparing with that from database
			$Query = "SELECT * FROM users WHERE Username = '$Username' AND Password = '$Password'";
			$Result = mysqli_query($db, $Query);
			if (mysqli_num_rows($Result) == 1) {
				// log in user
				$_SESSION['Username'] = $Username;
				$_SESSION['success'] = "You are now logged in";
				header('location: home.php'); // redirect to home page
			}else{
				array_push($Error, "Wrong Username/Password cobination");
			}
		}
	}

	//logout
	if(isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['Username']);
		header('location: index.php');
	}
?>