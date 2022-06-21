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

if($_SESSION["zakljucan"]==0 && ($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0)){
				
				if(isset($_GET["uredistavke"])){
					$update=1;
					$prid=$_GET["projektid"];
					$katid=$_GET["kategorijaid"];
					$sql="select opis, slika, video from stavke_projekta where projekt_id=".$prid." and kategorija_id = ".$katid;
					$bp=spojiSeNaBazu();
					$izvrsi=izvrsiUpit($bp, $sql);
					list($opiskat,$slikakat,$videokat)=mysqli_fetch_array($izvrsi);
				
				}
				else
				{
					$update=0;
					$katid=0;
					$opiskat="";
					$slikakat="";
					$videokat="";
				}
				
				echo "<hr/>";
				echo "<h4>Stavke:</h4>";
				echo "<a id='uredi'>";
				?>
				<form name="novastavka" id="novastavka" action="nova_stavka.php" method="POST" >
				<input type="hidden" name="projektid" id="projektid" value="<?php echo $projektid; ?>">	
				<input type="hidden" name="update" id="update" value="<?php echo $update; ?>">	
				<table border="1">
				<tr>
				<td>Kategorija:</td>
				<td>
				<select name="kategorija" id="kategorija">
				<?php
				$bp=spojiSeNaBazu();
				$sql="select kategorija_id, naziv, obavezna from kategorija";
				if(isset($_GET["dodajstavke"])){
				$sql.="	where kategorija_id not in (select kategorija_id from stavke_projekta where projekt_id = $projektid)";
				}
				$izvrsikat=izvrsiUpit($bp, $sql);
				while(list($id,$naziv,$obavezna)=mysqli_fetch_array($izvrsikat)){
					echo "<option value='$id'";
					if($id==$katid) {
						echo " selected";
					}
					echo ">$naziv";
					if($obavezna==1){
						echo " - obavezna";
					}
					else
					{
						echo " - neobavezna";
					}
					echo "</option>";
				}
				?>
				</select>
				</td>
				</tr>
				<tr>
				<td>Opis</td><td><textarea name="opis" id="opis" required="required"><?php echo $opiskat; ?></textarea></td>
				</tr>
				<tr>
				<td>Slika</td>
				<td>
				<?php
				if($slikakat!=""){
					echo "<br><img src='$slikakat' width='160px' height='160px'>";
				}
				?>
				<input type="text" name="slika" id="slika" required="required" value="<?php echo $slikakat; ?>" size="35">
				</td>
				</tr>
				<tr>
				<td>URL video</td>
				<td>
				<?php
				if($videokat!=""){
					Video($videokat);
				}
				?>
				<input type="text" name="video" id="video"  value="<?php echo $videokat; ?>" size="35">
				</td>
				</tr>
				<tr>
				<td colspan="2"><input type="submit" name="NovaStavka" id="NovaStavka" value="<?php echo "Pošalji"; ?>"></td>
				</tr>
				</table>
				</form>
				<?php
		
			}
	
	}
	
	if(isset($_POST["NovaStavka"])){
		
		$update=$_POST["update"];
		$projektid=$_POST["projektid"];
		$kategorija=$_POST["kategorija"];
		$opis=$_POST["opis"];
		$slika=$_POST["slika"];
		$video=$_POST["video"];
		
		if($update==0){
			$sql="insert into stavke_projekta (projekt_id,kategorija_id,opis,slika,video) values ('$projektid','$kategorija','$opis','$slika','$video')";
		}
		else
		{
			$sql="update stavke_projekta set opis='$opis', slika='$slika', video='$video' where projekt_id=".$projektid." and kategorija_id=".$kategorija;
		}
		$bp=spojiSeNaBazu();
		$izvrsi = izvrsiUpit($bp, $sql);
		
		header("Location: projekti_moderator.php");
	}
	?>
	<?php include("podnozje.php"); ?>