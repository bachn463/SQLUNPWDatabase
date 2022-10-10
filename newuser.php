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
		
		<title>Create Account</title>
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
			<h1>Sign Up</h1>
			<form>
				<div class="mb-3">
					<label for="username" class="form-label">Choose Username</label>
					<input type="text" class="form-control" id="username" name="username">
				</div>
				
				<div class="mb-3">
					<label for="password" class="form-label">Choose Password</label>
					<input type="password" class="form-control" id="password" name="password">
				</div>
				
				<div class="mb-3">
					<label for="verify" class="form-label">Verify the New Password</label>
					<input type="password" class="form-control" id="verify" name="verify">
				</div>
				
				<div class="mb-3">
					<input type="submit" class="form-control bg-primary" id="submit">
				</div>
			</form>
			<p id="warning" class="bg-danger"></p>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="scripts.js"></script>
		
		<script>
			$("form").on("submit", function(e) {
				e.preventDefault();
				var un = $("#username").val();
				var pw = $("#password").val();
				var pw2 = $("#verify").val();
				
				console.log(un);
				console.log(pw);
				console.log(pw2);
				
				if(pw != pw2) {
					$("#verify").val("");
					$("#warning").text("Passwords Do Not Match. Please Try Again.");
				} else if(un == "") {
					$("#warning").text("Username Field is Empty. Please Try Again.");
				} else {
					$("#warning").text("");
					$.ajax ({
						type:'POST',
						url: 'membership.php',
						data: {'username':un, 'password':pw},
						success: function(response) {
							console.log(response);
							if(response == true) {
								window.location.href = "login.php?newUser=true";
							} else if(response == 1062) {
								$("#warning").text("Username Already Exists. Please Try Again.");
							}
						},
						error: function(error) {
							alert('error communicating with the server');
						}
					});
				}
			});
		</script>
	</body>
</html>