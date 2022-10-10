<?php
	session_start();
	require_once "sql.php";
	
	if(isset($_GET["status"]) && $_GET["status"] == "loggedout") {
		if(isset($_SESSION["status"])) {
			unset($_SESSION["status"]);
			if(isset($_COOKIE[session_name()])) setcookie(session_name(), time() - 1000);
			session_destroy();
			$message = "User Successfully Logged Out";
		}
	}
	
	if(isset($_GET["newUser"])) {
		$message = "New Account Successfully Created";
	}
	
	if($_POST && !empty($_POST['username']) && !empty($_POST['password'])) {
		$sql = new MySql();
		$response = $sql->validateUser($_POST['username'], $_POST['password']);
		if($response === true) {
			$_SESSION["status"] = "authorized";
			header("location: index.php");
		} else{
			$warning = $response;
		}
	}
?>

<!doctype html>
<html lang="en">
	 <head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
		<!-- project stylesheet link -->
		<link href="styles.css" rel="stylesheet">
		
		<title>Log-In</title>
		<style>
			#submit {
				width: 100px;
				color: white;
			}
			#warning {
				color: white;
				display: inline-block;
			}
		</style>	
	</head>
	<body>
		<div class="container mt-3">
			<p class="bg-success text-light" style="display:inline-block;"><?php if(isset($message)) echo $message; ?></p>
			<h1>Log-In</h1>
			<form method="POST" action="">
				<div class="mb-3">
					<label for="username" class="form-label">Username</label>
					<input type="text" class="form-control" id="username" name="username">
				</div>
				
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control" id="password" name="password">
				</div>
				
				<div class="mb-3">
					<input type="submit" class="form-control bg-primary" id="submit">
				</div>
			</form>
			<div class="mb-3">
					<button class="form-control bg-primary text-light" id="create" style="display:inline-block; width: 12%;" onclick="location.href = 'newuser.php?';">Create Account</button>
			</div>
			<p id="warning" class="bg-danger"><?php if(isset($warning)) echo $warning; ?></p>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="scripts.js"></script>
		
		<script>
			
		</script>
	</body>
</html>