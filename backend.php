<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "sql.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {
	if(isset($_POST["message"]) && $_POST["message"] != "") {
		$sql = new MySql();
		$result = $sql->setMessage($_POST["message"]);
		if($result === true) {
			echo $_POST["message"]; //if saved, return back to user to write on page
		} else {
			echo $result; //if there was an error
		}
	}
	if(isset($_POST["deleteId"])) {
		$sql = new MySql();
		$sql->deleteMessage($_POST["deleteId"]);
		echo true;
	}
}