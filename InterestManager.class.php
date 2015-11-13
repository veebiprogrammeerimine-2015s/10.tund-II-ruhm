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
		
		// 1) kontrollite kas selline huviala on olemas (tabel interests)
		
		// 2) kui ei ole siis lisate juurde
		
	}
	
	
} ?>