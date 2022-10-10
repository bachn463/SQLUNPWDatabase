<?php
require_once "constants.php";

class MySql {
	private $conn;
	//constructor: runs when we first start a new connection
	function __construct() {
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
		if($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		}
		$tableCreated = $this->createMessageTable();
		if(!$tableCreated) {
			return $tableCreated;
		}
	}
	
	function createMessageTable() {
		$query = 'CREATE TABLE IF NOT EXISTS messages(
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			message TEXT NOT NULL
		)';
		
		//prepared statement prevents sql injection
		$stmt = $this->conn->prepare($query);
		if(!$stmt->execute()) {
			return $stmt->error;
		}
		return true;
	}
	
	function setMessage($msg) {
		$query = "INSERT INTO messages
			(message)
			VALUES (?)";
			
		if(!($stmt = $this->conn->prepare($query))) return "prepare failed";
		if(!($stmt->bind_param("s", $msg))) return "bind failed";
		if(!$stmt->execute()) return "execute failed";
		return true;
	}
	
	function getMessages() {
		$query = "SELECT * FROM messages";
		if(!($stmt = $this->conn->prepare($query))) return "prepare failed";
		if(!$stmt->execute()) return "execute failed";
		$messageArr = array();
		//handling results returned from database
		$stmt->bind_result($id, $message);
		while ($stmt->fetch()) {
			$messageArr += array("$id" => $message);
		}
		$stmt->close();
		return $messageArr;
	}
	
	function deleteMessage($id) {
		$query = "DELETE FROM messages WHERE id = ?";
		
		if(!($stmt = $this->conn->prepare($query))) return "prepare failed";
		if(!($stmt->bind_param("i", $id))) return "bind failed";
		if(!$stmt->execute()) return "execute failed";
		return true;
	}
	
	function createUser($un, $pw) {
		$query = "INSERT INTO users
			(username, password)
			VALUES (?, ?)";
			
		$encPW = password_hash("$pw", PASSWORD_DEFAULT);
		
		if(!($stmt = $this->conn->prepare($query))) return "prepare failed";
		if(!($stmt->bind_param("ss", $un, $encPW))) return "bind failed";
		if(!$stmt->execute()) return $stmt->errno;
		return true;
	}
	
	function validateUser($un, $pw) {
		$query = "SELECT * FROM users WHERE username = ? LIMIT 1";
		
		if(!($stmt = $this->conn->prepare($query))) return "prepare failed";
		if(!($stmt->bind_param("s", $un))) return "bind failed";
		if(!$stmt->execute()) return $stmt->errno;
		$stmt->bind_result($id, $unDB, $pwDB);
		if($stmt->fetch()) {
			if(password_verify($pw, $pwDB)) {
				return true;
			} else {
				return "Incorrect Username or Password";
			}
		} else {
			return "Incorrect Username or Password";
		}
	}
}
