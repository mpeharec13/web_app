<?php
	include("zaglavlje.php");
?>
 
 <?php
	
	if(isset($_GET["noviplan"])){
		
		?>
		<h3>Novi projekt</h3>
			<table border= "3">
			<form name="projektniplan" id="projektniplan" action="novi_projekt.php" method="POST" >			
			<tr>
					 <td>
					<label for="moderator"><strong>Moderator:</strong></label>
					</td>
					<td>
					<select name="moderator" id="moderator">
					<option value="odb">Odaberite:</option>
					<?php
					$bp=spojiSeNaBazu();
					$sql = "SELECT korisnik_id, concat(ime,' ',prezime) FROM korisnik WHERE tip_id < 2";
					if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0){
						$sql .= " and korisnik_id <> ".$aktivni_korisnik_id;
					}
					$izvrsi = izvrsiUpit($bp, $sql);
					while(list($idmod,$nazivmod)=mysqli_fetch_row($izvrsi)){
						echo "<option value='$idmod'>$nazivmod</option>";
					}
					?>					
					</select>
					</td>
				
			<td colspan="2"><input type="submit" name="ProjektniPlan" id="ProjektniPlan" value="Pošalji plan">
			</td>
			</tr>
			</table>
			</form>
	
	<?php	
		
	}
	
	if(isset($_POST["ProjektniPlan"])){
		
		$moderator=$_POST["moderator"];
		$bp=spojiSeNaBazu();
		$sql="insert into projekt (korisnik_id,moderator_id,datum_vrijeme_kreiranja,zakljucan) values ('$aktivni_korisnik_id','$moderator',now(),0)";
		$izvrsi = izvrsiUpit($bp, $sql);
		
		header("Location: projekti_korisnik.php");
	}
	if(isset($_GET["prihvatiplan"])){
		
		$projektid=$_GET["prihvatiplan"];
		$korisnik=$_GET["korisnik"];
		?>
		<h2>Prihvati plana</h2>
			<table border="1">
			<form name="prihvatiplan" id="prihvatiplan" action="novi_projekt.php" method="POST"  >
			<input type="hidden" name="projektid" id="projektid" value="<?php echo $projektid; ?>">	
			<tr>
			<td>Korisnik</td>
			<td>			
			<?php echo "<strong>$korisnik</strong>"; ?></td>
			</tr>
			<tr>			
			<tr>
			<td>Naziv</td>
			<td>			
			<input type="text" name="naziv" id="naziv" required="required">
			</tr>	
			<tr>
			<td>Opis</td><td><textarea name="opis" id="opis" cols="25" rows="11" required="required"></textarea></td>
			</tr>
			<tr>
			<td colspan="2"><input type="submit" name="PrihvatiPlan" id="PrihvatiPlan" value="Prihvati plan">
			</td>
			</tr>
			</table>
			</form>
	
	<?php	
	}
	if(isset($_POST["PrihvatiPlan"])){
		
		$projektid=$_POST["projektid"];
		$naziv=$_POST["naziv"];
		$opis=$_POST["opis"];
		$bp=spojiSeNaBazu();
		$sql="update projekt set naziv='$naziv', opis='$opis' where projekt_id=".$projektid;
		$izvrsi = izvrsiUpit($bp, $sql);
		
		header("Location:projekti_moderator.php");
	}
	

	?>	
   
<?php require("podnozje.php"); ?>