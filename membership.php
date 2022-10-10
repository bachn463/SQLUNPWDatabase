<?php
require_once "sql.php";

if($_SERVER["REQUEST_METHOD"] === "POST") { 
	if(isset($_POST["username"]) && isset($_POST["password"])) {
		$sql = new MySql();
		$response = $sql->createUser($_POST["username"], $_POST["password"]);
		echo $response;
	}
}