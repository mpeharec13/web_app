<?php
	include("zaglavlje.php");
?>
<?php

$bp=spojiSeNaBazu();
$sql = "select * from kategorija";
$rs = izvrsiUpit ($bp, $sql);

function UkupnoProjekataPoKategoriji($kategorijaid){
	$bp=spojiSeNaBazu();
	$sql1="SELECT k.kategorija_id, sp.kategorija_id, p.projekt_id
FROM kategorija k INNER JOIN stavke_projekta sp
ON k.kategorija_id = sp.kategorija_id INNER JOIN projekt p
ON sp.projekt_id = p.projekt_id WHERE k.kategorija_id = ".$kategorijaid;

$projekata_po_kategoriji = izvrsiUpit($bp, $sql1);

return mysqli_num_rows($projekata_po_kategoriji);
	
}

echo "<table border='1'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Naziv Kategorije</th>";
	echo "<th>Opis</th>";
	echo "<th>Ukupno projekata</th>";
		if($aktivni_korisnik_tip==0){
			echo "<th>Obavezna</th>";
			echo "<th>Uredi</th>";
		}
		echo "</tr>";
	echo "</thead>";
	
	echo "<tbody>";
	
	while(list($kategorijaid,$naziv, $opis, $obavezna)=mysqli_fetch_row($rs)){
		
		echo "<tr>";
		echo "<td>$naziv</td>";
		echo "<td>$opis</td>";
		$ukupnoprojekata = UkupnoProjekataPoKategoriji($kategorijaid);
		echo "<td>$ukupnoprojekata</td>";
		if($obavezna==1){
			$obavezna="da";
		}
		else
		{
			$obavezna="ne";
		}
		$uredi="<a href='kategorija.php?kategorija=$kategorijaid''>Uredi</a>";
		if($aktivni_korisnik_tip==0){
			echo "<td>$obavezna</td>";
			echo "<td>$uredi</td>";
		}
	echo "</tr>";
	}
	echo "</tbody>";
   echo "</table>";
	echo "<div>";
	if($aktivni_korisnik_tip==0){ 
	echo "<a href=\"kategorija.php?nova=1\">Dodaj novu kategoriju</a>";
	}
	echo "</div>";
	zatvoriVezuNaBazu($bp);
?>
<?php

	include("podnozje.php");
?>