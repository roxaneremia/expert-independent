<?php
	include "conectare.php";

class Membru {

	private $id_membru;
	private $nume_cont;
	private $adresa_email;
	private $parola;
	private $nume;
	private $prenume;
	private $gen;
	private $fotografie_profil;
	private $tip_membru;
	private $status_membru;
	private $data_creare;
	private $data_actualizare;
	private $venit;

	function inregistrare($date_inregistrare) {

	 	global $sqli;

		$query = "SELECT 'adresa_email' FROM 'membru' WHERE 'adresa_email'='".$date_inregistrare['adresa_email']."' ";
		$result = mysqli_query($sqli,$query);
		
		$count = @mysqli_num_rows($result); // if email not found then register
		
		if($count == 0){
			if(mysqli_query($sqli,
				"INSERT INTO membru VALUES 
			('','".$date_inregistrare["nume_cont"]."',
				'".$date_inregistrare["adresa_email"]."',
				'".md5($date_inregistrare["parola"])."',
				'".$date_inregistrare["nume"]."',
				'".$date_inregistrare["prenume"]."',
				'','',
				'".$date_inregistrare["tip"]."',
				'',NOW(),NOW(),'')"))
			{
				?>
				<script>alert('Te-ai inregistrat cu succes!');</script>
				<?php
			}

			else
				{
					?>
						<script>alert('Eroare de inregistrare ...');</script>
					<?php
				}		
			}
		else
			{
				?>
					<script>alert('Email-ul exista deja in baza de date ...');</script>
				<?php
			}
	} //END function inregistrare()

	function logare($date_logare,$url = "servicii_postate.php", $cuvant = '') {

		global $sqli;
		
		$res = mysqli_query($sqli,"SELECT id_membru, nume_cont, parola, nume, prenume, tip_membru, venit FROM membru WHERE adresa_email = '".$date_logare['adresa_email']."' ");
		$row = mysqli_fetch_array($res);
		$count = mysqli_num_rows($res); 
		if($count == 1 && $row['parola'] == md5($date_logare['parola'])) {

			$_SESSION['id_membru'] = $row['id_membru'];
			$_SESSION['nume_cont'] = $row['nume_cont'];
			$_SESSION['nume'] = $row['nume'];
			$_SESSION['prenume'] = $row['prenume'];
			$_SESSION['tip_membru'] = $row['tip_membru'];
			$_SESSION['venit'] = $row['venit'];
			$_SESSION['adresa_email'] = $row['adresa_email'];

			

			if($cuvant != '') $url.="?q=".$cuvant;
			header("Location: ".$url."");

		} //end if count ==1
		else
		  {
		    ?>
		        <script>alert('Eroare nume de cont/parola!');</script>
		        <?php
		  }//end else if count

	} //END function logare()

	function afisareProfil($id_membru) {

		global $sqli;

		$sql = "SELECT * FROM   membru
	    WHERE  id_membru = '".$id_membru."'";

	    $result = mysqli_query($sqli,$sql);

	    $row = mysqli_fetch_array($result);

		return($row);

		} //END function afisareProfil()


	function editareProfil($date_editare,$fotografie) {

		global $sqli;
		$sql_update = "UPDATE `membru` SET
	     `nume` = '".$date_editare['nume']."', 
	     `prenume` = '".$date_editare['prenume']."', 
	     `nume_cont` = '".$date_editare['nume_cont']."',
	     `gen` = '".$date_editare['gen']."',
	     `fotografie_profil` = '".$fotografie."',
	     `data_actualizare` = NOW() 
	     WHERE `membru`.`id_membru` = '".$_SESSION['id_membru']."'";

	     $sql_update2 = "UPDATE `membru` SET
	     `nume` = '".$date_editare['nume']."', 
	     `prenume` = '".$date_editare['prenume']."', 
	     `nume_cont` = '".$date_editare['nume_cont']."',
	     `gen` = '".$date_editare['gen']."',
	     `data_actualizare` = NOW() 
	     WHERE `membru`.`id_membru` = '".$_SESSION['id_membru']."'";


		if($fotografie=='') {

		    mysqli_query($sqli,$sql_update2) or die(mysqli_error($sqli));

		} 
		else {

		    mysqli_query($sqli,$sql_update) or die(mysqli_error($sqli));

		} 

    } //END function editareProfil()

    function modificareParola($parola) {

    	global $sqli;
    	//die($parola);
    	$sql_update3 = "UPDATE membru SET
    	parola = '".$parola."'
    	WHERE `membru`.`id_membru` = '".$_SESSION['id_membru']."' ";
    	//die($sql_update3);
    	mysqli_query($sqli,$sql_update3) or die(mysqli_error($sqli));

    }

    function autentificare($u = "profil.php", $q = '') {

		global $sqli;
		
		if(isset($_SESSION['id_membru']) && 
			isset($_SESSION['nume_cont']) &&
			isset($_SESSION['nume']) &&
			isset($_SESSION['prenume'])) {	
				return $_SESSION['nume_cont'];
			}
		else {
			$_SESSION['u'] = $u;
			$_SESSION['q'] = $q;
			//echo '<pre>AAA '; print_r($_SESSION); echo '</pre>'; die();
			return 0;
		}
			


	} //END function autentificare()


} // END class Membru

?>