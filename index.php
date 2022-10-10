<?php
/* 	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL); */
	
	session_start();
	
	if($_SESSION["status"] != "authorized") header("location: login.php");
	
	require_once "sql.php";
	$sql = new MySql();
	
	$messages = $sql->getMessages();
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
		
		<title>SQL</title>
		<style>
			body {
				margin: 10px;
			}
			.del-but {
				display: inline-block;
				margin-right: 5px;
				background-color: red;
				color: white;
			}
			p {
				display: inline-block;
				margin-right: 5px;
			}
		</style>	
	</head>
	<body>
		<a href="login.php?status=loggedout">Log Out</a>
		<h1>Messages</h1>
		<form>
			<input id="message" type="text">
			<input type="submit">
		</form>
		
		<div id="messageBoard">
			<?php
				foreach($messages as $key => $value) {
					echo "<button data-index='$key' class='del-but' id='$key'>X</button><p>" . $value . "</p><br>";
				}
			?>
		</div>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="scripts.js"></script>
		
		<script>
			/*
			$.ajax ({
				type:'',
				url: '',
				data: {},
				success: function(response) {
					console.log(response);
				},
				error: function(error) {
					alert('error communicating with the server');
				}
			});
			*/
			
			$("form").on("submit", function(e){
				var msg = $("#message").val();
				$("#message").val("");
				
				$.ajax ({
					type:'POST',
					url: 'backend.php',
					data: {"message":msg},
					success: function(response) {
						console.log(response);
						$("#messageBoard").html($("#messageBoard").html() +response + "<br>");
					},
					error: function(error) {
						alert('error communicating with the server');
					}
				});
			});
			
			$(".del-but").on("click", function(e) {
				var delId = $(e.target).attr('id');
				
				$.ajax ({
					type:'POST',
					url: 'backend.php',
					data: {"deleteId" : delId},
					success: function(response) {
						console.log(response);
						location.reload();
					},
					error: function(error) {
						alert('error communicating with the server');
					}
				});
			});
		</script>
	</body>
</html>