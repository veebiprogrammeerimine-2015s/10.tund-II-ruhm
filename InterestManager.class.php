<?php
class InterestManager {
	
	//InterestManager.class.php
	private $connection;
	
	// kui �tlen new siis siin saad k�tte sulgudest
	function __construct($mysqli){
		
		// selle klassi muutuja
		$this->connection = $mysqli;
		
	}
	
	function addInterest($new_interest){
		
		// 1) kontrollite kas selline huviala on olemas (tabel interests)
		
		// 2) kui ei ole siis lisate juurde
		
		// kui v�tate aluseks createUser funktsiooni siis tuleb muuta seal ainult 4 rida. 
		
	}
	
	
} ?>