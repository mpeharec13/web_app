<?php
		if(isset($_SESSION['aktivni_korisnik']))		
		session_destroy();	
		
		header("Location: index.php");

?>