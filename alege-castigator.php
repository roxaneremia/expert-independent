<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

  include "de-inclus.php";
  //echo '<pre>'; print_r($_POST); echo '</pre>'; //die();
   $notifica = new Concurs(); 
   global $sqli;
  
  if(isset($_POST['alege-solutie'])) {



   // obtinem pretul proiectului
    $query_pret_final = "SELECT pret_final FROM postare_serviciu WHERE id_serviciu = '".$_GET['id_job']."' ";
    $result_pret_final = mysqli_query($sqli,$query_pret_final);
    $row_pret_final = mysqli_fetch_array($result_pret_final);
    // Pretul final al jobului
	$row_pret_final['pret_final'];
   // terminam obtinere pret proiect

    if(isset($_POST['optcheck'])) $castigatori=$_POST['optcheck']; else $castigatori='';
  	if(isset($_POST['numar_stele'])) $stele_acordate=$_POST['numar_stele']; else $stele_acordate='';
  	$stele=0;
	
	$este_castigator=0; 
	
	if(isset($_POST['optcheck']) && isset($_POST['numar_stele']))
	{
	for($k=0;$k<count($castigatori);$k++)
	 {
		//echo $castigatori[$k].' - ';
		if($stele_acordate[$castigatori[$k]]==5) 
		    {  
		       $_id_membru_castigator=$castigatori[$k];
			   if( ($este_castigator) && ($stele_acordate[$castigatori[$k]]==5) )  { $este_castigator++; }
			   else { $este_castigator=1; }
			  
		    }
		 else { $stele+=$stele_acordate[$castigatori[$k]]; }
	 }
	 
	}
	 
	 if($este_castigator==1)  // exista castigatori
	   {  $total_stele_suplimentare=$stele; 
	     // impartire suma la stele aditionale
	     
		 $castig_plaftorma = round(0.1 * $row_pret_final['pret_final'], 2);
		 $castig_designeri = $row_pret_final['pret_final'] - $castig_plaftorma;
		 
		if(!$total_stele_suplimentare) // castigator unic
		 {
			$castig_designer=$castig_designeri;
	   tranzactie($_id_membru_castigator, $_GET['id_job'], $castig_designer, 'Castigator concurs'.$_GET['titlu'].' ');
     tranzactie(ID_PLATFORMA, $_GET['id_job'], -$castig_designer, 'Castigator concurs'.$_GET['titlu'].' ');
			mysqli_query($sqli,"UPDATE postare_serviciu SET data_modificare=NOW(), status_serviciu='3' WHERE id_serviciu=".$_GET['id_job']." ");
			//mysqli_query($sqli,"UPDATE membru SET data_actualizare=NOW(), venit=venit-".$castig_designer." WHERE id_membru=".ID_PLATFORMA." ");

           //update inregistrare_concurs
          mysqli_query($sqli,"UPDATE inregistrare_concurs SET data_modificare=NOW(), suma_castigata= '".$castig_designer."' , numar_stele = '5'
        WHERE id_membru= '".$_id_membru_castigator."' AND id_serviciu = '".$_GET['id_job']."' ");

	        $query_notifica = "SELECT *, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa FROM inregistrare_concurs 
               RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru WHERE inregistrare_concurs.id_serviciu='".$_GET['id_job']."' ";
           $result_notifica = mysqli_query($sqli,$query_notifica);
           while($row_notifica = mysqli_fetch_array($result_notifica))
           {
             $notifica->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'],$_SESSION['adresa_email'],
                    $row_notifica['id_membru'], $row_notifica['clientn'], $row_notifica['clientp'], $row_notifica['adresa'], 'CASTIGATOR DESEMNAT', 'Vezi cine a castigat concursul '.$_GET['titlu'].'!');
           }
		  echo '<h2>Ai ales castigator la concurs</h2>';
		 } // castigator unic
		 
		else // mai multi castigatori
		{
			$castig_designer=round(0.7 * $row_pret_final['pret_final'], 2);
			$pret_stea= round(0.2 * $row_pret_final['pret_final'] / $total_stele_suplimentare, 2);
			
			// castigator principal
			tranzactie($_id_membru_castigator, $_GET['id_job'], $castig_designer, 'Castigator concurs'.$_GET['titlu'].' ');
      tranzactie(ID_PLATFORMA, $_GET['id_job'], -$castig_designer, 'Castigator concurs'.$_GET['titlu'].' ');

			//mysqli_query($sqli,"UPDATE membru SET data_actualizare=NOW(), venit=venit-".$castig_designer." WHERE id_membru=".ID_PLATFORMA." ");
	        $query_notifica = "SELECT *, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa FROM inregistrare_concurs 
               RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru WHERE inregistrare_concurs.id_serviciu='".$_GET['id_job']."' ";
           $result_notifica = mysqli_query($sqli,$query_notifica);
           while($row_notifica = mysqli_fetch_array($result_notifica))
           {
             $notifica->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'],$_SESSION['adresa_email'],
                    $row_notifica['id_membru'], $row_notifica['clientn'], $row_notifica['clientp'], $row_notifica['adresa'], 'CASTIGATOR DESEMNAT', 'Vezi cine a castigat concursul '.$_GET['titlu'].'!');
           }
          //update inregistrare_concurs
          mysqli_query($sqli,"UPDATE inregistrare_concurs SET data_modificare=NOW(), suma_castigata= '".$castig_designer."' , numar_stele = '5'
        WHERE id_membru= '".$_id_membru_castigator."' AND id_serviciu = '".$_GET['id_job']."' ");
		   // castoigator principal
		   
		   // -----------------------
		   
		   // castigatori secundari
		   
		   for($z=0;$z<count($castigatori);$z++)
	        {
		      if( ($stele_acordate[$castigatori[$z]]!=5) && (($stele_acordate[$castigatori[$z]]!=0)) )
			   {
				  $castig_secundar=round($stele_acordate[$castigatori[$z]] * $pret_stea, 2);
			    tranzactie($castigatori[$z], $_GET['id_job'], $castig_secundar , 'Castigator secundar concurs'.$_GET['titlu'].'  - '.$stele_acordate[$castigatori[$z]].' stele primite!');
				  //mysqli_query($sqli,"UPDATE membru SET data_actualizare=NOW(), venit=venit-".$castig_secundar." WHERE id_membru=".ID_PLATFORMA." ");
          tranzactie(ID_PLATFORMA, $_GET['id_job'], -$castig_secundar , 'Castigator secundar concurs'.$_GET['titlu'].'  - '.$stele_acordate[$castigatori[$z]].' stele primite!');
          //update inregistrari_concurs
          mysqli_query($sqli,"UPDATE inregistrare_concurs SET data_modificare=NOW(), suma_castigata= '".$castig_secundar."' , numar_stele = '".$stele_acordate[$castigatori[$z]]."'
          WHERE id_membru=".$castigatori[$z]." AND id_serviciu = '".$_GET['id_job']."' ");
			   }
		   
			}
		   // castigatori secundari
		   
		   mysqli_query($sqli,"UPDATE postare_serviciu SET data_modificare=NOW(), status_serviciu='3' WHERE id_serviciu=".$_GET['id_job']." ");

			echo '<h2>Ai ales castigatori la concurs</h2>';
		}// mai multi castigatori
		 
	   
	   } // exista castigatori
	   
	   elseif($este_castigator>1) { echo 'Au fost desemnati mai multi castigatori (concurenti care au primit 5 stele). Alegeti din nou!'; }
	     
		 // cazul in care alege sa nu fie niciun castoigator din doua motive: a) nu sunt inscrisi; b) nu e multumit de rezultate
		 elseif(isset($_POST['concurs_incheiat_fara_castiogatori'])) 
		   { 
		     echo 'Nu a fost desemnat niciun castigator. Ati primit in cont 90% din valoarea proiectului. Va multumim!';  
			 $retur_plaftorma = round(0.1 * $row_pret_final['pret_final'], 2);
			 $retur_client = $row_pret_final['pret_final'] - $retur_plaftorma;
			 //mysqli_query($sqli,"UPDATE membru SET data_actualizare=NOW(), venit=venit-".$retur_client." WHERE id_membru=".ID_PLATFORMA." ");
			 tranzactie($_SESSION['id_membru'], $_GET['id_job'], $retur_client, 'Returnare plata postare proiect');
			 tranzactie(ID_PLATFORMA, $_GET['id_job'], -$retur_client, 'Returnare plata postare proiect');

       mysqli_query($sqli,"UPDATE postare_serviciu SET data_modificare=NOW(), status_serviciu='3' WHERE id_serviciu=".$_GET['id_job']." ");
			 
			 $query_notifica = "SELECT *, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa FROM inregistrare_concurs 
              RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru WHERE inregistrare_concurs.id_serviciu='".$_GET['id_job']."' ";

             $result_notifica = mysqli_query($sqli,$query_notifica);
             while($row_notifica = mysqli_fetch_array($result_notifica))
             {
              $notifica->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'],$_SESSION['adresa_email'],
                    $row_notifica['id_membru'], $row_notifica['clientn'], $row_notifica['clientp'], $row_notifica['adresa'], 'FINALIZARE PROIECT', 'Proiectul '.$_GET['titlu'].' sa finalizat fara desemnarea unui castigator!');
            }
			 
		   }
	       
		   
		   else{ echo 'Nu a fost desemnat niciun castigator (concurent care sa primeasca 5 stele). Alegeti din nou!';  }


die();

      $query_notifica = "SELECT *, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa FROM inregistrare_concurs 
      RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru WHERE inregistrare_concurs.id_serviciu='".$_GET['id_job']."' ";

      $result_notifica = mysqli_query($sqli,$query_notifica);
      while($row_notifica = mysqli_fetch_array($result_notifica))
      {
        $notifica = new Concurs(); 
        $notifica->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'],$row1['adresa_email'],
                    $row_notifica['id_membru'], $row_notifica['clientn'], $row_notifica['clientp'], $row_notifica['adresa'], 'ALEGERE CASTIGATOR', 'Vezi cine a castigat concursul '.$_GET['titlu'].'!');
      }
     
      $optiuni = $_POST['optcheck'];
      $stele = $_POST['numar_stele'];
      if(empty($optiuni)) 
      {
        echo "Nu ai ales nicio optiune.";
      } 
      else
      {
        $n = count($optiuni);
     
        //echo("Ai selectat $n optiuni: ");

         $concurs =  new Concurs();

         global $sqli;
          
         $sql_update = "UPDATE postare_serviciu SET status_serviciu = '3', data_modificare = NOW()

         WHERE id_serviciu = '".$_GET['id_job']."' AND id_membru = '".$_SESSION['id_membru']."'";

         mysqli_query($sqli,$sql_update) or die(mysqli_error());


        for($i=0; $i < $n; $i++)
        {
          //echo 'nr stele:'.$_POST['numar_stele'].'gata nr stele';
          $concurs->nominalizareConcurs($optiuni[$i],$_GET['id_job'], $stele[$i]);

          //Calcul suma castigata
          $sql_final = "SELECT * FROM postare_serviciu
          WHERE  id_serviciu = '".$_GET['id_job']."'";

          $result_final = mysqli_query($sqli,$sql_final);

          $row_final = mysqli_fetch_array($result_final);
          
          $valoare_platforma = 0.1*$row_final['pret_final'];
          //se ia din contul platformei
          tranzactie('14',$_GET['id_job'],-$valoare_platforma,"comision platforma");
          //se vireaza in contul platformei
          tranzactie('14',$_GET['id_job'],$valoare_platforma,"comision platforma");

          if($i <1) 
          {
            //DACA ESTE CASTIGATOR UNIC
            if($stele[$i] == 5) {

              $valoare_premiu = 0.9*$row_final['pret_final'];
              //se ia din contul platformei
              tranzactie('14',$_GET['id_job'],-$valoare_premiu,"plata castigator principal");
              //se vireaza in contul platformei
              tranzactie($optiuni[$i],$_GET['id_job'],$valoare_premiu,"plata castigator principal");

            }

          }
          else 
          {

            if($stele[$i] == 5) {
              $valoare_premiu_principal = 0.7*$row_final['pret_final'];
              tranzactie('14',$_GET['id_job'],-$valoare_premiu_principal,"plata castigator principal");
              //se vireaza in contul platformei
              tranzactie($optiuni[$i],$_GET['id_job'],$valoare_premiu_principal,"plata castigator principal");
            }
            else
            {
              //mai sunt 20 de stele
              $valoare_premii_secundare = 0.2*$row_final['pret_final'];
            }

          }
 
          //echo $optiuni[$i] . " ";

          $sql_update1 = "UPDATE inregistrare_concurs SET data_modificare = NOW(), numar_stele = '".$stele[$i]."',

          WHERE id_serviciu = '".$_GET['id_job']."' AND id_membru = '".$optiuni[$i]."'";

          mysqli_query($sqli,$sql_update1) or die(mysqli_error());
          //echo($_POST['numar_stele']);
        }

      }
      //  die($optiuni);
      header('Location: servicii-suplimentare.php?id_job='.$_GET['id_job']);
  }

  else
  {
    ?>
      <!--<script>alert("Nu ai putut sa realizezi licitatie");</script>-->
    <?php
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Expert Independent</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--css-->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/index.css" type="text/css" />
  <!-css-->

  <!--js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--js-->

</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

<em><h2 style="text-align:center;"> Solutii propuse pentru serviciul - <b><?php echo $_GET['titlu']; ?></b></h2></em>

<p style="text-align: center; font-size: 16px; text-transform: italic;"> Designerul ce primeste 5 stele va fi desemnat drept castigator principal.</p> 
<p style="text-align: center; font-size: 16px; text-transform: italic; margin-bottom: 5%">El este unicul concurent ce primeste 5 stele! </p>

<!--action="servicii-suplimentare.php?titlu=<?php //echo $_GET['titlu'];?>&id_job=<?php //echo $_GET['id_job'];?>"-->
    <form role="form" method="post" action="alege-castigator.php?id_job=<?php echo $_GET['id_job']; ?>&titlu=<?php echo $_GET['titlu']; ?>">
    
    <?php
    global $sqli;

    $query1 = "SELECT * FROM membru WHERE id_membru = '".$_SESSION['id_membru']."' ";

    $result1 = mysqli_query($sqli,$query1);

    $row1 = mysqli_fetch_assoc($result1);

    $c=0;

    $query = "SELECT *, inregistrare_concurs.id_membru as id_membru, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa
               FROM  inregistrare_concurs 
              RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru where inregistrare_concurs.id_serviciu='".$_GET['id_job']."'
            "; 
    $result = mysqli_query($sqli,$query);
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;?>
      <?php if($row['solutie'] != '') {
	      echo '<label style="margin-left:20%;"><input type="checkbox" name="optcheck[]" value="'.$row['id_membru'].'">'.' '.$row['clientp'].' '.$row['clientn'].' - <a href="imagine.php?img='.$row['solutie'].'"><img src="img/'.$row['solutie'].'" style="width: 30px;height: 30px; padding: 3px; border-radius: 3px; border: 1px solid #ccc;"/></a></label>';

        echo '<select style="margin-left: 3%" name="numar_stele['.$row['id_membru'].']" value='.$row['numar_stele'].'>
                <option value="0">Alege numar stele</option>
                <option value="5">5 stele</option>
                <option value="4">4 stele</option>
                <option value="3">3 stele</option>
                <option value="2">2 stele</option>
                <option value="1">1 stea</option>
              </select>';
        //echo '<input type="hidden" value='.$row[''].'>' 
 
 
        echo '<button class="large-btn ofera-feedback" onclick="window.open(\'opinie.php?membru_id='.$row['id_membru'].'&concurs_id='.$row['id_serviciu'].'&titlu='.$_GET['titlu'].'\',\'_self\')" type="button" name="ofera-feedback" style="float:right; margin-right: 15%">Ofera feedback</button><br/>';
	  }
	  	  
  }

  echo ' <br><br>
		<label style="margin-left:20%; color:#FF0000"><input type="checkbox" name="concurs_incheiat_fara_castiogatori" value="1"> Inchei concursul fara a desemna un castigator (Primesc in contul meu 90% din suma platita). </label>
				
		';
       
        $count = @mysqli_num_rows($result);

        if($count == 0)
        {
          //echo '<p style="text-align: center;">Ne pare rau, nu exista solutii pentru acest serviciu!</p>';

        }
        else
        {

          echo '<button class="large-btn" type="submit" style="margin-left: 50%; margin-top: 3%" name="alege-solutie">Alege solutie</button>';

        }

   ?>
       <div class="clear:both"></div>

    </form>

</body>

</html>
