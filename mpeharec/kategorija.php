<?php
	include("zaglavlje.php");
?>
<?php
$bp=spojiSeNaBazu();
$greska="";
	if(isset($_POST['submit'])){
		foreach($_POST as $key => $value)if(strlen($value)==0)$greska="Sva polja za unos su obavezna";
		if(empty($greska)){
			$id=$_POST['novi'];
			$naziv=$_POST['naziv'];
			$opis=$_POST['opis'];
			if(isset($_POST['obavezna'])){
			$obavezna= "1";
			}
			else{
				$obavezna= "0";
			};
			if($id==0){
				$sql="INSERT INTO kategorija
					(naziv, opis, obavezna)
					VALUES
					('$naziv','$opis','$obavezna');
				";
			}
			else{
				$sql="UPDATE kategorija SET naziv='$naziv', opis='$opis', obavezna='$obavezna' WHERE kategorija_id = ".$id;
			}
			izvrsiUpit($bp,$sql);
			header("Location:kategorije.php");
		}
	}
	if(isset($_GET['kategorija'])){
		$id=$_GET['kategorija'];
		$sql = "SELECT * FROM kategorija WHERE kategorija_id=".$id;
		$rs=izvrsiUpit($bp,$sql);
		list($id,$naziv,$opis,$obavezna)=mysqli_fetch_array($rs);
	}
	else{
		$naziv = "";
		$opis = "";
		$obavezna = 0;
	}
		if(isset($_POST['reset']))header("Location:kategorija.php");
?>
<form method="POST" action="<?php if(isset($_GET['kategorija']))echo "kategorija.php?kategorija=$id";else echo "kategorija.php";?>">
	<table>
		<caption>
			<?php
				if(isset($_GET['kategorija']))echo "Uredi kategoriju";
				else echo "Dodaj novu kategoriju";
			?>
		</caption>
		<tbody>
			<tr>
				<td colspan="2">
					<input type="hidden" name="novi" value="<?php if(!empty($id))echo $id;else echo 0;?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<label class="greska"><?php if($greska!="")echo $greska; ?></label>
				</td>
			</tr>
			<tr>
				<td class="lijevi">
					<label for="naziv"><strong>Naziv kategorije:</strong></label>
				</td>
				<td>
					<input type="text" name="naziv" id="naziv" size="120" maxlength="100"
						placeholder="Naziv kategorije"
						value="<?php if(!isset($_POST['naziv']))echo $naziv; else echo $_POST['naziv'];?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="opis"><strong>Opis:</strong></label>
				</td>
				<td>
					<input type="text" name="opis" id="opis" size="120" maxlength="100"
						value="<?php if(!isset($_POST['opis']))echo $opis; else echo $_POST['opis'];?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="obavezna"><strong>Obavezna kategorija:</strong></label>
				</td>
				<td>
					<input type="checkbox" name="obavezna" id="obavezna" <?php if($obavezna==1) echo " checked"; ?> > 
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<?php
						if(isset($id)&&$aktivni_korisnik_id==$id||!empty($id))echo '<input type="submit" name="submit" value="Pošalji"/>';
						else echo '<input type="submit" name="reset" value="Izbriši"/><input type="submit" name="submit" value="Pošalji"/>';
					?>
				</td>
			</tr>
		</tbody>
	</table>
</form>
    

<?php
zatvoriVezuNaBazu($bp);
	include("podnozje.php");
?>