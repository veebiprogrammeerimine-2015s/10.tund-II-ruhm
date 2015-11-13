<?php
	require_once("functions.php");
	require_once("InterestManager.class.php");
	
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
		
		//************
		//** OLULINE *
		//************
		exit();
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}
	
	
	// teen uue instansti class InterestManagerist
	$InterestManager = new InterestManager($mysqli);
	
	
	// aadressireal on new_interest
	if(isset($_GET["new_interest"])){
		
		// returniga tule response muutujasse $added_interest
		$added_interest = $InterestManager->addInterest($_GET["new_interest"]);
	}
	
	//rippmenüü valiku id
	if(isset($_GET["dropdownselect"])){
		// saadan valiku id ja kasutaja id
		$added_user_interest = $InterestManager->addUserInterest($_GET["dropdownselect"],$_SESSION["id_from_db"]);
	}
	
	
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h2>Lisa uus huviala</h2>
 <?php if(isset($added_interest->error)): ?>
  
	<p style="color:red;">
		<?=$added_interest->error->message;?>
	</p>
  
  <?php elseif(isset($added_interest->success)): ?>
  
	<p style="color:green;">
		<?=$added_interest->success->message;?>
	</p>
  
  <?php endif; ?>  
<form>
	<input name="new_interest">
	<input type="submit">
</form>

<h2>Minu huvialad</h2>
<form>
<?php if(isset($added_user_interest->error)): ?>
  
	<p style="color:red;">
		<?=$added_user_interest->error->message;?>
	</p>
  
  <?php elseif(isset($added_user_interest->success)): ?>
  
	<p style="color:green;">
		<?=$added_user_interest->success->message;?>
	</p>
  
  <?php endif; ?>  
	<!-- SIIA TULEB RIPPMENÜÜ -->
	<?php echo $InterestManager->createDropdown();?>
	<input type="submit">
</form>

<p><?php echo $InterestManager->getUserInterests($_SESSION["id_from_db"]);?></p>
