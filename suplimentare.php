<?php

class Suplimentare {

	function confirmareServiciu($id_serviciu,$id_serviciu_suplimentar,$specificatii) {

		global $sqli;

			if(mysqli_query($sqli,
				"INSERT INTO confirmare_servicii_suplimentare VALUES 
			('','".$id_serviciu."',
				'".$id_serviciu_suplimentar."',
				'".$specificatii."')"))
			{
				?>
				<script>alert('Cerere inregistrata!');</script>
				<?php
			}

			else
				{
					?>
						<script>alert('Eroare de inregistrare ...');</script>
					<?php
				}		
			
	} //END function confirmareServiciu()

	function confirmareServicii($id_serviciu,$id_serviciu_suplimentar1,$id_serviciu_suplimentar2,$specificatii) {

		global $sqli;

			if(mysqli_query($sqli,
				"INSERT INTO confirmare_servicii_suplimentare VALUES 
			('','".$id_serviciu."',
				'".$id_serviciu_suplimentar1."',
				'".$id_serviciu_suplimentar2."',
				'".$specificatii."')"))
			{
				?>
				<script>alert('Cerere inregistrata!');</script>
				<?php
			}

			else
				{
					?>
						<script>alert('Eroare de inregistrare ...');</script>
					<?php
				}		
			
	} //END function confirmareServiciu()

}

?>