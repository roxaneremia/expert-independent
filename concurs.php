<?php
include "conectare.php";

class Concurs {
	private $id_inregistrare;
	private $id_membru;
	private $id_serviciu;
	private $buget_propus;
	private $tip_membru;
	private $solutie;
	private $data_creare;
	private $data_modificare;
	private $nr_stele;
	private $suma_castigata;
	private $opinie_client;


	//PENTRU AFISARE BUTON DE OFERTARE/PRETUL OFERTAT DE UN DESIGNER
	function ofertareConcurs($id_membru,$id_job,$titlu) {

		global $sqli;

		$query = "SELECT buget_propus FROM inregistrare_concurs WHERE id_membru='".$id_membru."' AND id_serviciu='".$id_job."' ";
		$result = mysqli_query($sqli,$query);	
		$count = @mysqli_num_rows($result);  
		$row = mysqli_fetch_array($result);  

		if($count == 0) 
			{ echo '<a class="fancybox fancybox.iframe" href="liciteaza-pret.php?id_job='.$id_job.'&titlu='.$titlu.'">Oferteaza</a>'; return 0; }
		else 
			{ echo $row['buget_propus'].' LEI'; return 1; }

	} //END function ofertareConcurs


	//UN DESIGNER OFERTEAZA UN JOB PROASPAT POSTAT
	function ofertareLicitatie($id_membru,$id_job,$buget_propus) {

		global $sqli;

		//header("Location: inscriere.php");

		if(mysqli_query($sqli,
				"INSERT INTO inregistrare_concurs VALUES 
			('','".$id_membru."',
				'".$id_job."',
				'".$buget_propus."','',NOW(),NOW(),'','','')"))
			{
				?>
				<script>alert('Te-ai inregistrat cu succes la concurs!');</script>
				<?php
			}

			else
				{
					?>
						<script>alert('Eroare de inregistrare ...');</script>
					<?php
				}	
			

	}//END function ofertareLicitatie


	//NOMINALIZARE CASTIGATOR DE 5 STELE
	function nominalizareConcurs($id_membru,$id_serviciu, $nr_stele) {

		global $sqli;

		$sql_update = "UPDATE inregistrare_concurs SET numar_stele = '".$nr_stele."' 

		WHERE id_membru = '".$id_membru."' AND `id_serviciu` = '".$id_serviciu."' ";

    	mysqli_query($sqli,$sql_update) or die(mysqli_error());

	}// END function nominalizareConcurs

	//UPDATE LA PRETUL FINAL IN FUNCTIE DE LICITATIE SI DECIZIA CLIENTULUI
	function licitatiePret($id_job,$pret_final) {

		global $sqli;

		$sql_update1 = "UPDATE postare_serviciu SET pret_final = '".$pret_final."'
						WHERE id_serviciu = '".$id_job."' ";
		mysqli_query($sqli,$sql_update1) or die(mysqli_error());

		?> <script>alert("Ai ales pretul final!")</script>
		<?php
	}

	function notificare($id_expeditor, $nume_expeditor, $prenume_expeditor, $email_expeditor,
				$id_destinatar, $nume_destinatar, $prenume_destinatar, $adresa_destinatar, $subiect, $mesaj) {

			global $sqli;

		    
			if(mysqli_query($sqli,
			   "INSERT INTO conversatie VALUES 
			   ('','".$id_expeditor."',
					'".$nume_expeditor."',
					'".$prenume_expeditor."',
					'".$email_expeditor."',
					'".$id_destinatar."',
					'".$nume_destinatar."',
					'".$prenume_destinatar."',
					'".$adresa_destinatar."',
					'".$subiect."', '".$mesaj."',
					 NOW(),'0','1')"))
			
				{
					?>
					<?php
				}

			else
				{
					?>
						<script>alert('A fost deja trimis deja un mesaj ...');</script>
					<?php
				}
		
		}

	
}

?>