<?php include ("baza.php") ?>
<?php
session_start();
$aktivni_korisnik=0;
	$aktivni_korisnik_tip=-1;
	$aktivni_korisnik_id=0;		
	$ime_tip="";
if(isset($_SESSION['aktivni_korisnik'])){
		$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
		$aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
		$aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
		$aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
			}
	?>
	
<!DOCTYPE html>
<html>
    <head>
        <title>Planer arhitekture stambenih objekata</title>
        <meta name="autor" content="Mia Peharec"/>
		<meta name="datum" content="01.05.2021"/>
		<meta charset="utf-8"/>
		<link href="mpeharec.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
	<header>
	
	<p id="naslov">PLANER ARHITEKTURE STAMBENIH OBJEKATA </p>
	<div id = "a_korisnik">
	<?php if($aktivni_korisnik === 0){
		echo "<span> Neprijavljeni korisnik </span>";
	}
	else{
		echo "<span>$aktivni_korisnik_ime</span>";
	} ?>
	
	</div>
	<?php include ("navigacija.php") ?>
	</header>