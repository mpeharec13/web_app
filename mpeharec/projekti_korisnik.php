<?php include("zaglavlje.php"); ?>
<h1>Moji projekti</h1>
<?php
	$bp=spojiSeNaBazu();
	$sql = "SELECT p.projekt_id, p.datum_vrijeme_kreiranja, p.naziv, p.opis, p.zakljucan,
CONCAT(vod.ime,' ',vod.prezime) AS 'Moderator',
CONCAT(kor.ime,' ',kor.prezime) AS 'Korisnik'FROM projekt p 
INNER JOIN korisnik vod ON p.moderator_id = vod.korisnik_id
INNER JOIN korisnik kor ON p.korisnik_id = kor.korisnik_id WHERE kor.korisnik_id = ".$aktivni_korisnik_id;		
	
	$izvrsi=izvrsiUpit($bp, $sql);
	echo "<table border='2'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>ID Projekta</th>";
	echo "<th>Naziv</th>";
	echo "<th>Opis</th>";
	echo "<th>Datum kreiranja</th>";
	echo "<th>Moderator</th>";
	echo "<th>Zaključan</th>";
	echo "</tr>";
	echo "</thead>";
	
	echo "<tbody>";
	while(list($projektid,$datumkreiranja,$naziv, $opis, $zakljucan,$moderator,$korisnik)=mysqli_fetch_row($izvrsi)){
		$datumkreiranja = date("d.m.Y H:i:s",strtotime($datumkreiranja));
		if($zakljucan=="0"){
			$projektzakljucan="ne";
		}
		else
		{
			$projektzakljucan="da";
		}
		echo "<tr>";
		echo "<td>$projektid</td>";
		echo "<td>$naziv</td>";
		echo "<td>$opis</td>";
		echo "<td>$datumkreiranja</td>";
		echo "<td>$moderator</td>";
		echo "<td>$projektzakljucan";
		if($zakljucan=="1"){
			echo " ( <a href='stavke_projekta.php?projektid=$projektid'>Stavke</a>)";
		}
		echo "</td>";
	echo "</tr>";
	}
   
   echo "</tbody>";
   echo "</table>";
	
	echo "<p><a href='novi_projekt.php?noviplan=1'>Novi zahtjev za projektni plan</a></p>";
?>

<?php Include("podnozje.php") ?>