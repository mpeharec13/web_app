<?php
	include("zaglavlje.php");
?>
<h2>Projekti</h2>
 <h3>Pretraga</h3>
	<form name="pretraga" id="pretraga" action="projekti.php" method="GET">
	<table border='1'>
	<tr><td>Korisnik (odabrati):</td><td>
					<select name="korisnik" id="korisnik">
					<option value="odb">Korisnik:</option>
					<?php
					$bp=spojiSeNaBazu();
					$sql = "SELECT ime , prezime FROM korisnik ";
					$izvrsi = izvrsiUpit($bp, $sql);
					while(list($ime,$prezime)=mysqli_fetch_row($izvrsi)){
						echo "<option value='$ime'>$ime $prezime</option>";
					}
					?>					
					</select>
					</td>
	<td>Datum vrijeme od:</td><td><input type="text" name="DatumVrijemeOd" id="DatumVrijemeOd"></td>
	<td>Datum vrijeme do:</td><td><input type="text" name="DatumVrijemeDo" id="DatumVrijemeDo"></td>
	<td colspan="2"><input type="submit" name="PretragaZahtjeva" id="PretragaZahtjeva" value="Pretraži"></td>
	<td colspan="2">
	</td></tr>
	</table>
	</form>
      <?php
	
	$sql = "SELECT
CONCAT(m.ime,' ',m.prezime) AS 'Moderator',
COUNT(p.projekt_id) AS 'BrojZahtjeva'
FROM projekt p
INNER JOIN korisnik m
ON p.moderator_id = m.korisnik_id
INNER JOIN korisnik k
ON p.korisnik_id = k.korisnik_id";
if(isset($_GET["PretragaZahtjeva"])){
	$datumod=$_GET["DatumVrijemeOd"];
	$datumdo=$_GET["DatumVrijemeDo"];
	$korisnik=$_GET["korisnik"];
		if(!empty($datumod) && !empty($datumdo) && !empty($korisnik)){
			$datumod=date("Y-m-d H:i:s",strtotime($datumod));
			$datumdo=date("Y-m-d H:i:s",strtotime($datumdo));
			$sql .= " WHERE p.datum_vrijeme_kreiranja BETWEEN '$datumod' AND '$datumdo' and (k.ime like '%$korisnik%' or k.prezime like '%$korisnik%')";
		}

}
$sql .= " GROUP BY m.korisnik_id";
	
$bp=spojiSeNaBazu();
	$izvrsi=izvrsiUpit($bp, $sql);	 

	echo "<h4>Broj zahtjeva po moderatoru";
	echo "</h4>";
	echo "<table border='1'";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Moderator</th>";
	echo "<th>Broj zahtjeva</th>";
	echo "</thead>";
	
	echo "<tbody>";
	while(list($moderator,$brojzahtjeva)=mysqli_fetch_row($izvrsi)){
		echo "<tr>";
		echo "<td>$moderator</td>";
		echo "<td>$brojzahtjeva</td>";
	echo "</tr>";
	}
   echo "</tbody>";
   echo "</table>";
  
  if (isset($_GET['PretragaZahtjeva'])){ 
    echo "<h3>Rezultat pretrage</h3>";

   $sql = "SELECT
p.projekt_id,
p.datum_vrijeme_kreiranja,
p.naziv,
p.opis,
p.zakljucan,
CONCAT(vod.ime,' ',vod.prezime) AS 'Moderator',
CONCAT(kor.ime,' ',kor.prezime) AS 'Korisnik'
FROM projekt p
INNER JOIN korisnik vod
ON p.moderator_id = vod.korisnik_id
INNER JOIN korisnik kor
ON p.korisnik_id = kor.korisnik_id";
if(isset($_GET["PretragaZahtjeva"])){
	$datumod=$_GET["DatumVrijemeOd"];
	$datumdo=$_GET["DatumVrijemeDo"];
	$korisnik=$_GET["korisnik"];
		if(!empty($datumod) && !empty($datumdo) && !empty($korisnik)){
			$datumod=date("Y-m-d H:i:s",strtotime($datumod));
			$datumdo=date("Y-m-d H:i:s",strtotime($datumdo));
			$sql .= " WHERE p.datum_vrijeme_kreiranja BETWEEN '$datumod' AND '$datumdo' and (kor.ime like '%$korisnik%' or kor.prezime like '%$korisnik%')";
		}

}
   $bp=spojiSeNaBazu();
$sql .= " ORDER BY vod.korisnik_id";		
	$izvrsi=izvrsiUpit($bp, $sql);	 

	echo "<table border='1'";
	echo "<thead>";
	echo "<tr>";
	echo "<th>ID Projekta</th>";
	echo "<th>Naziv</th>";
	echo "<th>Opis</th>";
	echo "<th>Datum kreiranja</th>";
	echo "<th>Moderator</th>";
	echo "<th>Korisnik</th>";
	echo "</tr>";
	echo "</thead>";
	
	echo "<tbody>";
	while(list($projektid,$datumkreiranja,$naziv, $opis, $zakljucan,$moderator,$korisnik)=mysqli_fetch_row($izvrsi)){
		$datumkreiranja = date("d.m.Y H:i:s",strtotime($datumkreiranja));
		echo "<tr>";
		echo "<td>$projektid</td>";
		echo "<td>$naziv</td>";
		echo "<td>$opis</td>";
		echo "<td>$datumkreiranja</td>";
		echo "<td>$moderator</td>";
		echo "<td>$korisnik</td>";
	echo "</tr>";
	}
   echo "</tbody>";
   echo "</table>";
   
  }
    
   else {
   
   $bp=spojiSeNaBazu();
$sql = "SELECT
p.projekt_id,
p.datum_vrijeme_kreiranja,
p.naziv,
p.opis,
p.zakljucan,
CONCAT(vod.ime,' ',vod.prezime) AS 'Moderator',
CONCAT(kor.ime,' ',kor.prezime) AS 'Korisnik'
FROM projekt p
INNER JOIN korisnik vod
ON p.moderator_id = vod.korisnik_id
INNER JOIN korisnik kor
ON p.korisnik_id = kor.korisnik_id";		
	$izvrsi=izvrsiUpit($bp, $sql);
	echo "<h2>Popis projekata</h2>";
	echo "<table border='1'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>ID Projekta</th>";
	echo "<th>Naziv</th>";
	echo "<th>Opis</th>";
	echo "<th>Datum kreiranja</th>";
	echo "<th>Moderator</th>";
	echo "<th>Korisnik</th>";
	echo "<th>Zaključan</th>";
	echo "<th>Prihvaćen</th>";
	echo "</tr>";
	echo "</thead>";
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
		echo "<td>$moderator</td>";
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
			echo "</td>";
			echo "</tr>";
   echo "</tbody>";
   echo "</table>";
   
  
   }
	
	echo "<p><a href='projekti_korisnik.php'>Popis mojih zahtjeva</a></p>";
	echo "<p><a href='novi_projekt.php?noviplan=1'>Novi zahtjev za projektni plan</a></p>";
	zatvoriVezuNaBazu($bp);
?>
<?php
	include("podnozje.php");
?>