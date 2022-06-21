<?php include("zaglavlje.php"); ?>

	
      <?php

		function Video($video){
	
		if(strpos($video,"youtube")>0){ 
			$youtubevideo="https://www.youtube.com/embed/videouid";
			$poz=strpos($video,"=");
			$video_id = substr($video,$poz+1,strlen($video));
			$video=str_replace("videouid",$video_id,$youtubevideo); 
			echo "<iframe width=\"100\" height=\"80\" src=\"$video\"></iframe>";
		}


		if(substr($video,-3)=="mp4"){
			echo "<video width='100' height='80' controls>";
			echo "<source src='$video' type='video/mp4'>";
			echo "<source src='$video' type='video/webm'>";
			echo "</video>";
		}
        }
	if(isset($_GET["projektid"]) || isset($_GET["dodajstavke"]) || isset($_GET["uredistavke"])){
		
		$projektid=$_GET["projektid"];
		
		$sql="SELECT
			p.naziv,
			p.opis AS 'opisprojekt',
			p.projekt_id,
			p.zakljucan,
			sp.kategorija_id,
			sp.opis AS 'opisstavka',
			sp.slika,
			sp.video,
			kt.naziv,
			kt.obavezna
			FROM projekt p 
			left JOIN stavke_projekta sp
			ON sp.projekt_id = p.projekt_id
			left join kategorija kt
			on kt.kategorija_id = sp.kategorija_id
			WHERE p.projekt_id =".$projektid;
		$bp=spojiSeNaBazu();
		$izvrsi=izvrsiUpit($bp, $sql);
		$stavkesql="select * from stavke_projekta where projekt_id=".$projektid;
		$izvrsist=izvrsiUpit($bp, $stavkesql);
		echo "<table border='1'";
		echo "<thead><tr>";
		echo "<th>Naziv</th>";
		echo "<th>Opis</th>";
		echo "<th>Obavezna</th>";
		echo "<th>Slika</th>";
		echo "<th>Video</th>";
		
		echo "</tr></thead>";
		echo "<tbody>";
        $count=0;
		while(list($projektnaziv,$projektopis,$projektidd,$pzakljucan,$stavkakategorijaid,$stavkaopis,$slika,$video,$stavkanaziv,$obavezna)=mysqli_fetch_array($izvrsi)){
		$count++;
		if($count==1){
			echo "<br><label class='ispis'>Naziv projekta:</label> ".$projektnaziv;
			echo "<br><label class='ispis'>Opis projekta:</label> ".$projektopis;
			echo "<hr/>";
			echo "<h3>Stavke projekta</h3>";
			$_SESSION["zakljucan"]=$pzakljucan;
		}
		
		if($obavezna==1){
			$obavezna="da";
		}
		else
		{
			$obavezna="ne";
		}
		
		
		if(mysqli_num_rows($izvrsist)!=0){	
		    echo "<tr>";
			echo "<td>$stavkanaziv</td>";
			echo "<td>$stavkaopis</td>";
			echo "<td>$obavezna</td>";
			echo "<td><figure><img src='$slika' width='100px' height='80px'></figure></td>";
		    echo "<td>";
			if($video != '')
			{
					Video($video);

			}
			echo "</td>";
			echo "<td>";
			if(($aktivni_korisnik_tip == 1 || $aktivni_korisnik_tip==0) && $_SESSION['zakljucan']==0){
			echo"	<a href='nova_stavka.php?uredistavke=1&projektid=$projektidd&kategorijaid=$stavkakategorijaid#uredi'>Uredi</a>";
			echo "</td>";
			echo "<td>";
				echo "<a href='nova_stavka.php?dodajstavke=1&projektid=$projektidd&kategorijaid=$stavkakategorijaid'>Dodaj</a>";
		
		    echo "</td>";
			}
			echo "</tr>";
			
		}
		
		else
		{
			echo "<h4>Trenutno nema stavki za projekt</h4>";
			if(($aktivni_korisnik_tip == 1 || $aktivni_korisnik_tip==0) && $_SESSION['zakljucan']==0){
				echo "<a href='nova_stavka.php?dodajstavke=1&projektid=$projektidd&kategorijaid=$stavkakategorijaid'>Dodaj stavku</a>";
		}
		}
		
			}
			echo "</tbody>";
			echo "</table>";
				
			
	}
		
			

	?>	

<?php include("podnozje.php"); ?>