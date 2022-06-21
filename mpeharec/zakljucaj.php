<?php
	include("zaglavlje.php");
	$bp=spojiSeNaBazu();
?>
<?php
     if(!isset($_SESSION['aktivni_korisnik_tip'])) header("Location:index.php");
	if(isset($_GET['zakljucaj'])){
		$id=$_GET['zakljucaj'];
	}
	if(isset($_POST["zakljucaj"])){
		$id=$_POST["projekt"];
		$sql="UPDATE projekt SET zakljucan = 1 WHERE projekt_id=$id";
		izvrsiUpit($bp,$sql);
		header ("Location:projekti_moderator.php");
	}
?>
<h3>Zaključavanje projekta</h3>
<form method="POST" action="zakljucaj.php">
	<table border="4">
		<tbody>
			<tr>
				<td>
					<strong>Opis:</strong>
				</td>
				<td>
					<pre>Želite li zaključati projekt </pre>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="hidden" name="projekt" value="<?php echo $id;?>"/>
					<input type="submit" name="zakljucaj" value="Zaključaj"/>
				</td>
			</tr>
		</tbody>
	</table>
</form>
<?php
	zatvoriVezuNaBazu($bp);
	include("podnozje.php");
?>