<div id="nav">
<a href="index.php" >Početna</a>
<a href="kategorije.php" >Kategorije</a>
	  
	  <?php
	  switch($aktivni_korisnik_tip){
		  
		  case 0:
		  ?>
		  <a href="korisnici.php" >Korisnici</a>
		  <a href="projekti.php" >Projekti</a>
		  <?php
		  break;
		  case 1:
		  ?>
		  <a href="projekti_moderator.php" >Projekti</a>
		  <?php
		  break;
		  case 2:
		  ?>
		  <a href="projekti_korisnik.php">Projekti</a>
		  <?php
	  break;}
	  ?>
	  <?php 
	  if ($aktivni_korisnik === 0){
		  ?>
	  <a href="prijava.php" >Prijava</a>
	  <?php } 
	  else {
		  ?>
		  <a href="prijava.php?logout=1" >Odjava</a>
		  <?php	  }  ?>
    