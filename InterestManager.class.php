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
	
	function createDropdown(){
		
		$html = '';
		// ''
		$html .= '<select name="dropdownselect">';

		$stmt = $this->connection->prepare("SELECT id, name FROM interests");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		
		//iga rea kohta teen midagi
		while($stmt->fetch()){
			$html .= '<option value="'.$id.'">'.$name.'</option>';
		}
		
		$stmt->close();
		
		//$html .= '<option value="2" selected>Teisipäev</option>';

		$html .= '</select>';

		
		return $html;
		
	}
	
	function addUserInterest($new_interest_id, $user_id){
		
		//$new_interest aadressirealt tulnud muutuja
		
		$response = new StdClass();

		//kas selline huviala on selllel kasutajal juba olemas?
		$stmt = $this->connection->prepare("SELECT id FROM user_interests WHERE user_id = ? AND interests_id = ?");
		$stmt->bind_param("ii", $user_id, $new_interest_id);
		$stmt->execute();
		if($stmt->fetch()){
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline huviala juba olemas!";
			$response->error = $error;
			return $response;
		}
		$stmt->close();
	
		$stmt = $this->connection->prepare("INSERT INTO user_interests (user_id, interests_id) VALUES (?,?)");
		$stmt->bind_param("ii", $user_id, $new_interest_id);
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
	
	
	function getUserInterests($user_id){
		
		$html = '';
		
		$stmt = $this->connection->prepare("
			SELECT interests.name FROM user_interests
			INNER JOIN interests ON 
			user_interests.interests_id = interests.id
			WHERE user_interests.user_id = ?
		");
		//echo $user_id;
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($name);
		$stmt->execute();
		
		while($stmt->fetch()){
			$html .= $name." ";
		}
		
		$stmt->close();
		
		return $html;
		
	}
	
	
} ?>