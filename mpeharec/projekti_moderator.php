<?php
	include("zaglavlje.php");
?>
<?php
function ObavezneKategorije(){
	    $bp=spojiSeNaBazu();
		$sql="select * from kategorija where obavezna = 1";
		$ok = izvrsiUpit($bp, $sql);
		return mysqli_num_rows($ok);
		}
		function ObavezneKategorijeProjekt($projektid){
	    $bp=spojiSeNaBazu();
		$sql="SELECT
			p.projekt_id,
			p.naziv,
			kt.kategorija_id,
			kt.naziv,
			kt.obavezna,
			sp.opis
			FROM projekt p 
			left JOIN stavke_projekta sp
			ON sp.projekt_id = p.projekt_id
			INNER JOIN kategorija kt
			ON kt.kategorija_id = sp.kategorija_id
			WHERE p.projekt_id = ".$projektid." AND kt.obavezna = 1";
		$okp = izvrsiUpit($bp, $sql);
		return mysqli_num_rows($okp);
        }
$sql = "SELECT p.projekt_id, p.datum_vrijeme_kreiranja, p.naziv, p.opis, p.zakljucan,
CONCAT(vod.ime,' ',vod.prezime) AS 'Moderator',
CONCAT(kor.ime,' ',kor.prezime) AS 'Korisnik'
FROM projekt p INNER JOIN korisnik vod ON p.moderator_id = vod.korisnik_id
INNER JOIN korisnik kor ON p.korisnik_id = kor.korisnik_id WHERE p.moderator_id = ".$aktivni_korisnik_id;	

	$bp=spojiSeNaBazu();
	$izvrsi=izvrsiUpit($bp, $sql);
	echo "<table border='2'";
	echo "<thead>";
	echo "<tr>";
	echo "<th>ID Projekta</th>";
	echo "<th>Naziv</th>";
	echo "<th>Opis</th>";
	echo "<th>Datum kreiranja</th>";
	echo "<th>Zahtjev kreirao</th>";
	echo "<th>Zaključan</th>";
	echo "<th>Prihvaćen</th>";
	echo "</tr>";
	echo "</thead>";
	
	echo "<tbody>";
	while(list($projektid,$datumkreiranja,$naziv, $opis, $zakljucan,$moderator,$korisnik)=mysqli_fetch_row($izvrsi)){
		if(ObavezneKategorije()==ObavezneKategorijeProjekt($projektid)){
			$zakljucaj=" ( <a href='zakljucaj.php?zakljucaj=$projektid'>Zaključaj</a> )";
		}
		else
		{
			$zakljucaj="";
		}
		if($naziv=="" && $opis==""){
			$prihvacen = "ne";
			$prihvati = " ( <a href='novi_projekt.php?prihvatiplan=$projektid&korisnik=$korisnik'>Prihvati</a> )";
		}
		else
		{
			$prihvacen = "da";
			if($zakljucan==0){
				$prihvati = " ( <a href='stavke_projekta.php?projektid=$projektid&dodajstavke=1'>Dodaj stavke</a> )";
			}
			else
			{
				$prihvati="";
			}
		}
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
		echo "<td>$korisnik</td>";
		echo "<td>$projektzakljucan";
		if($zakljucan=="1"){
			echo " ( <a href='stavke_projekta.php?projektid=$projektid'>Stavke</a> )";
		}
		else
		{
			echo $zakljucaj;
		}
		echo "</td>";
		echo "<td>$prihvacen $prihvati</td>";
	echo "</tr>";
	}
   echo "</tbody>";
   echo "</table>";
	
	echo "<p><a href='projekti_korisnik.php'>Popis mojih zahtjeva</a></p>";
	echo "<p><a href='novi_projekt.php?noviplan=1'>Novi zahtjev za projektni plan</a></p>";
	
	
?>
<?php
	include("podnozje.php");
?>