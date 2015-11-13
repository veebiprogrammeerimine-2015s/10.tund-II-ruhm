<?php
class InterestManager {
	
	//InterestManager.class.php
	private $connection;
	
	// kui ütlen new siis siin saad kätte sulgudest
	function __construct($mysqli){
		
		// selle klassi muutuja
		$this->connection = $mysqli;
		
	}
	
	function addInterest($new_interest){
		
		//$new_interest aadressirealt tulnud muutuja
		
		$response = new StdClass();

		//kas selline huviala on juba olemas?
		$stmt = $this->connection->prepare("SELECT id FROM interests WHERE name = ?");
		$stmt->bind_param("s", $new_interest);
		$stmt->execute();
		if($stmt->fetch()){
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline huviala juba olemas!";
			$response->error = $error;
			return $response;
		}
		$stmt->close();
	
		$stmt = $this->connection->prepare("INSERT INTO interests (name) VALUES (?)");
		$stmt->bind_param("s", $new_interest);
		if($stmt->execute()){
			$success = new StdClass();
			$success->message = "Huviala edukalt salvestatud";
			$response->success = $success;
		}else{
			$error = new StdClass();
			$error->id =1;
			$error->message = "Midagi läks katki!";
			$response->error = $error;
		}
		
		$stmt->close();
		
		return $response;
		
	}
	
	
} ?>