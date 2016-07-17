<?php
	include "conectare.php";

	class Conversatie {

		private $id_conversatie;
		private $id_expeditor;
		private $nume_expeditor;
		private $prenume_expeditor;
		private $email_expeditor;
		private $id_destinatar;
		private $nume_destinatar;
		private $prenume_destinatar;
		private $adresa_destinatar;
		private $subiect;
		private $mesaj;
		private $data_trimitere;
		private $citit;

		function trimiteMesajProfil($id_expeditor, $nume_expeditor, $prenume_expeditor, $email_expeditor,
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
					<script>alert('Ai trimis mesajul cu succes!');</script>
					<?php
				}

			else
				{
					?>
						<script>alert('Ai trimis deja un mesaj ...');</script>
					<?php
				}
		
		}

	} //END class Conversatie()

?>