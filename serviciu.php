<?php
include "conectare.php";

class Serviciu {
		private $id_membru;
		private $titlu;
		private $descriere;
		private $pret_initial;
		private $data_postarii;
		private $termen_limita;
		private $link_descarcare;
		private $schita;
		private $interval_stabilire_pret;
		private $pret_final;
		private $data_modificare;
		private $status_serviciu;

		function posteazaServiciu($date_serviciu,$id_membru,$date_new,$termen_limita, $zile_licitatie) {

		global $sqli;
		//die($date_new);
		//$query = "SELECT 'titlu' FROM 'postare_serviciu' WHERE 'titlu'='".$date_serviciu['titlu']."' ";
		//$result = mysqli_query($sqli,$query);
		
		//$count = @mysqli_num_rows($result); // daca titlul nu exista deja in baza de date, atunci insereaza

			$query_pret_initial = "INSERT INTO postare_serviciu VALUES 
					('','".$id_membru."',
						'".$date_serviciu["titlu"]."',
						'".$date_serviciu["descriere"]."',
						'".$date_serviciu["pret_initial"]."',
						NOW(),'".$termen_limita."',
						'".$date_serviciu["link_descarcare"]."',
						'".$date_serviciu["schita"]."',
						'".$date_new."', '',
						 NOW(),'0')";

			$query_pret_final = "INSERT INTO postare_serviciu VALUES 
					('','".$id_membru."',
						'".$date_serviciu["titlu"]."',
						'".$date_serviciu["descriere"]."',
						'".$date_serviciu["pret_initial"]."',
						NOW(),'".$termen_limita."',
						'".$date_serviciu["link_descarcare"]."',
						'".$date_serviciu["schita"]."',
						'".$date_new."', 
						'".$date_serviciu["pret_initial"]."',
						 NOW(),'1')";
			
			if($zile_licitatie != 0) 
			{
				if(mysqli_query($sqli, $query_pret_initial))
					{?>

						<script>alert('Serviciu postat...');</script>

					<?php
					}//final if
				else 
					{?>
							<script>alert('Eroare postare serviciu...');</script>
						<?php
					}//final else
			}//final if

			else
			{
				if(mysqli_query($sqli, $query_pret_final))
					{?>

						<script>alert('Serviciu postat...');</script>

					<?php
					} //final if
				else 
					{?>
							<script>alert('Eroare postare serviciu...');</script>
						<?php
					} //final else
			}//final else
			$id_serviciu_tranzactie = mysqli_insert_id($sqli);
			return $id_serviciu_tranzactie;
		

	} //END function posteazaServiciu()

	function afiseazaServiciu($id_serviciu) {

		global $sqli;

		$query = "SELECT * FROM postare_serviciu  WHERE id_serviciu= '".$id_serviciu."' ";
		$result = mysqli_query($sqli,$query);
		$row   = mysqli_fetch_assoc($result);
		//die($query);

		$query_member = "SELECT nume_cont FROM membru  WHERE id_membru= '".$row['id_membru']."' ";
		$result_member = mysqli_query($sqli,$query_member);
		$row_member = mysqli_fetch_assoc($result_member);

		$row['nume'] = $row_member['nume_cont'];

		return $row;
        
	 }//END function afiseazaServiciu()

	 /*function numeClientServiciu($id_membru) {
	 	global $sqli;

		$query = "SELECT * FROM postare_serviciu  WHERE id_serviciu= '".$id_serviciu."' ";
		$result = mysqli_query($sqli,$query);
		$row   = mysqli_fetch_assoc($result);
		//die($query);

		$query_member = "SELECT nume_cont FROM membru  WHERE id_membru= '".$row['id_membru']."' ";
		$result_member = mysqli_query($sqli,$query_member);
		$row_member = mysqli_fetch_assoc($result_member);

		$row['nume'] = $row_member['nume_cont'];

		return $row['id_membru'];
        
	 }*/

}

?>

