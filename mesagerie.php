<?php
session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>';

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
  <link rel="stylesheet" href="css/mesagerie.css" type="text/css" />  

  <!-css-->

  <!--js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--js-->

  <!-- AUTOCOMPLETE -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
  $(function() {
    var availableTags = [
        <?php
            $c=0;

            global $sqli;

            $query = "SELECT nume, prenume, id_membru, adresa_email FROM membru"; 

            $result = mysqli_query($sqli,$query);

            while($row = mysqli_fetch_assoc($result)) {
              echo '"'; echo $row['nume']; echo ' '; echo $row['prenume'];  echo ":"; echo $row['id_membru'];
              echo ":"; echo $row['adresa_email'];  echo '"'; echo ',';
              $c++;           
            }
      ?> "Dragos"];

      $( ".destinatar" ).autocomplete({
          source: availableTags
        });

      });

  </script>

  <?php

    if(isset($_POST['trimite_mesaj'])) {
      $email = explode(":",$_POST['destinatar']);
      //echo $email[1];

      global $sqli;

      //Info DESTINATAR
      $query1 = "SELECT nume, prenume, id_membru, adresa_email FROM membru
                  WHERE id_membru = '".$email[1]."'";

      $result1 = mysqli_query($sqli,$query1);
      $row1 = mysqli_fetch_array($result1);

      //Info EXPEDITOR

      $query2 = "SELECT nume, prenume, id_membru, adresa_email FROM membru
                  WHERE id_membru = '".$_SESSION['id_membru']."'";

      $result2 = mysqli_query($sqli,$query2);
      $row2 = mysqli_fetch_array($result2);

      $conversatie = new Conversatie();
      $conversatie->trimiteMesajProfil($row2['id_membru'],$row2['nume'],$row2['prenume'],$row2['adresa_email'],
                                        $row1['id_membru'],$row1['nume'],$row1['prenume'],$row1['adresa_email'],
                                        $_POST['subiect'],$_POST['mesaj']);


    }
  ?>
  
</head>

  <!-- AUTOCOMPLETE -->

<body data-spy="scroll" data-target=".navbar" data-offset="50">

<?php include "antet.php"; ?>   

<nav class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
    </div>
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active mesaj_nou"><a href="#">Trimite un mesaj nou<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-pencil"></span></a></li>
        <li class="mesaje_primite">
          <a href="#">Mesaje primite<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-in"></span></a>
        </li>          
        <li class="mesaje_trimise"><a href="#">Mesaje trimise<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a></li>        
        <li class="mesaje_sterse"><a href="#">Mesaje sterse<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-folder-close"></span></a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- scrie un mesaj nou-->
<div class="scrie_mesaj_nou" style="display:none">

  <em><h2 style="text-align:center">Trimite un mesaj nou</h2></em>

  <form method="post" action="#" style="width: 60%; margin-left:20%">

  <div class="form-group">
    <label for="destinatar">Destinatar:</label>
    <input type="text" class="form-control destinatar" id="destinatar" name="destinatar">
  </div>

  <div class="form-group">
    <label for="subiect">Subiect:</label>
    <input type="text" class="form-control" id="subiect" name="subiect">
  </div>

  <div class="form-group">
    <label for="mesaj">Mesajul tau:</label>
    <textarea class="form-control" rows="5" id="mesaj" name="mesaj"></textarea>
  </div>

  <button type="submit" name="trimite_mesaj" value="ok" class="btn btn-default btn-submit" style="float:left; margin-top: 5%; margin-left: 5%">Trimite</button>

  </form>

  <br><br><br><br>

</div>
<!-- scrie un mesaj nou -->

<!-- mesaje primite -->

<div class="lista_mesaje_primite" style="display:none">
<em><h2 style="text-align:center; margin-bottom: 2%"> Mesaje primite</h2></em>
<?php 
    
    if(isset($_POST['sterge'])) {
      global $sqli;
      $sql_update = "UPDATE conversatie SET status = '0' WHERE id_destinatar = '".$_POST['id_membru_destinatar']."' ";
      mysqli_query($sqli,$sql_update) or die(mysqli_error($sqli));
    }

?>
<form method="post">
<table id="tabel_joburi" class="display" cellspacing="0" width="75%" style="margin-left:10%;">
        <thead>
            <tr>
                <th style="text-align:center">Nr. crt.</th>
                <th style="text-align:center">Expeditor</th>
                <th style="text-align:center">Subiect</th>
                <th style="text-align:center">Mesaj</th>
                <th style="text-align:center">Data trimitere</th>
                <th style="text-align:center">Vazut</th>
                <th style="text-align:center;">Sterge</th>
            </tr>
        </thead>
        <!--<tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>-->
        <tbody>
           

<?php
    $c=0;
    global $sqli;
    $query = "SELECT * FROM conversatie WHERE id_destinatar = '".$_SESSION['id_membru']."' AND status = '1'"; 

    $result = mysqli_query($sqli,$query);
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;?>

                 <tr>
                    
                    <td style="text-align:center"><?php echo $c; ?></td>
                    <td style="text-align:center"><a href="#"><?php echo $row["nume_expeditor"]; echo " ";echo $row["prenume_expeditor"]; ?></a></td>
                    <td style="text-align:center"><?php echo $row["subiect"]; ?></td>
                    <td style="text-align:center"><?php echo $row["mesaj"]; ?></td>
                    <td style="text-align:center"><?php

                    echo date('d-m-Y, H:i',strtotime($row["data_trimitere"]));


                    ?></td>
                    <td style="text-align:center"><?php 

                    $status;

                    if($row["citit"] == 0)
                      $status = "Necitit";

                    if($row["citit"] == 1)
                      $status = "Citit";
                    echo $status;

                    ?></td>
                    <td>
                      <button type="submit" name="sterge" class="sterge" style="margin-left: 20%">Sterge</button>
                      <input type="hidden" value="<?php echo $_SESSION['id_membru']; ?>" name="id_membru_destinatar"/>
                    </td>
                 </tr> 
    
            <?php

          }?>
            
        </tbody>
    </table>   
    </form> 
    </div>

    <!-- mesaje primite -->

    <!-- mesaje trimise -->

    <div class="lista_mesaje_trimise" style="display:none">
    <em><h2 style="text-align:center; margin-bottom: 2%">Mesaje trimise</h2></em>
  <?php 
      
      if(isset($_POST['sterge1'])) {
        global $sqli;
        $sql_update1 = "UPDATE conversatie SET status = '0' WHERE id_destinatar = '".$_POST['id_membru_destinatar1']."' ";
        mysqli_query($sqli,$sql_update1) or die(mysqli_error($sqli));
      }

  ?>
    <form method="post">
    <table id="tabel_joburi" class="display" cellspacing="0" width="75%" style="margin-left:10%;">
        <thead>
            <tr>
                <th style="text-align:center">Nr. crt.</th>
                <th style="text-align:center">Destinatar</th>
                <th style="text-align:center">Subiect</th>
                <th style="text-align:center">Mesaj</th>
                <th style="text-align:center">Data trimitere</th>
                <th style="text-align:center">Vazut</th>
                <th style="text-align:center">Sterge</th>
            </tr>
        </thead>
        <!--<tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>-->
        <tbody>
           

<?php
    $c=0;
    global $sqli;
    $query = "SELECT * FROM conversatie WHERE id_expeditor = '".$_SESSION['id_membru']."' AND status = '1' "; 

    $result = mysqli_query($sqli,$query);
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;?>

                 <tr>
                    
                    <td style="text-align:center"><?php echo $c; ?></td>
                    <td style="text-align:center"><a href="#"><?php echo $row["nume_destinatar"]; echo " ";echo $row["prenume_destinatar"]; ?></a></td>
                    <td style="text-align:center"><?php echo $row["subiect"]; ?></td>
                    <td style="text-align:center"><?php echo $row["mesaj"]; ?></td>
                    <td style="text-align:center"><?php

                    echo date('d-m-Y, H:i',strtotime($row["data_trimitere"]));


                    ?></td>
                    <td style="text-align:center"><?php 

                      $status;

                    if($row["citit"] == 0)
                      $status = "Necitit";

                    if($row["citit"] == 1)
                      $status = "Citit";
                    echo $status;

                    ?></td>
                    <td>
                      <button type="submit" name="sterge1" class="sterge" style="margin-left: 20%">Sterge</button>
                      <input type="hidden" name="id_membru_destinatar1" value="<?php echo $row['id_destinatar']; ?>"/>
                    </td>
                 </tr> 
    
            <?php
          } ?>
            
        </tbody>
    </table> 
    </form>   
    </div>

    <!-- mesaje trimise -->

    <!-- mesaje sterse -->

    <div class="lista_mesaje_sterse" style="display:none">
    <em><h2 style="text-align:center; margin-bottom: 2%">Mesaje sterse</h2></em>
    <table id="tabel_joburi" class="display" cellspacing="0" width="75%" style="margin-left:10%;">
        <thead>
            <tr>
                <th style="text-align:center">Nr. crt.</th>
                <th style="text-align:center">Destinatar</th>
                <th style="text-align:center">Subiect</th>
                <th style="text-align:center">Mesaj</th>
                <th style="text-align:center">Data trimitere</th>
                <th style="text-align:center">Vazut</th>
                <th style="text-align:center">Sterge</th>
            </tr>
        </thead>
        <!--<tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>-->
        <tbody>
           

<?php
    $c=0;
    global $sqli;
    $query = "SELECT * FROM conversatie WHERE id_expeditor = '".$_SESSION['id_membru']."' AND status = '0' OR id_destinatar = '".$_SESSION['id_membru']."' AND status = '0' "; 

    $result = mysqli_query($sqli,$query);
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;?>

                 <tr>
                    
                    <td style="text-align:center"><?php echo $c; ?></td>
                    <td style="text-align:center"><a href="#"><?php echo $row["nume_destinatar"]; echo " ";echo $row["prenume_destinatar"]; ?></a></td>
                    <td style="text-align:center"><?php echo $row["subiect"]; ?></td>
                    <td style="text-align:center"><?php echo $row["mesaj"]; ?></td>
                    <td style="text-align:center"><?php

                    echo date('d-m-Y, H:i',strtotime($row["data_trimitere"]));


                    ?></td>
                    <td style="text-align:center"><?php 

                      $status;

                    if($row["citit"] == 0)
                      $status = "Necitit";

                    if($row["citit"] == 1)
                      $status = "Citit";
                    echo $status;

                    ?></td>
                    <td>
                      <button type="submit" name="sterge" class="sterge" style="margin-left: 20%">Sterge</button>
                    </td>
                 </tr> 
    
            <?php
          } ?>
            
        </tbody>
    </table>    
    </div>

    <!-- mesaje sterse -->

<?php include "subsol.php";?>

<script>
  $(document).ready(function() {


    $('.mesaj_nou').click(function() {

      $('.scrie_mesaj_nou').show();
      $('.mesaj_nou').addClass('active');
      $('.lista_mesaje_primite').hide();
      $('.mesaje_primite').removeClass('active');
      $('.lista_mesaje_trimise').hide(); 
      $('.mesaje_trimise').removeClass('active');
      $('.lista_mesaje_sterse').hide();
      $('.mesaje_sterse').removeClass('active');

    });

    $('.mesaje_primite').click(function() {

      $('.lista_mesaje_primite').show();
      $('.mesaje_primite').addClass('active');
      $('.lista_mesaje_trimise').hide();
      $('.mesaje_trimise').removeClass('active');
      $('.scrie_mesaj_nou').hide();
      $('.mesaj_nou').removeClass('active');
      $('.lista_mesaje_sterse').hide();
      $('.mesaje_sterse').removeClass('active');

    });

    $('.mesaje_trimise').click(function() {

      $('.lista_mesaje_primite').hide();
      $('.mesaje_primite').removeClass('active');
      $('.lista_mesaje_trimise').show();
      $('.mesaje_trimise').addClass('active');
      $('.scrie_mesaj_nou').hide();
      $('.mesaj_nou').removeClass('active');
      $('.lista_mesaje_sterse').hide();
      $('.mesaje_sterse').removeClass('active');

    });

    $('.mesaje_sterse').click(function(){

      $('.lista_mesaje_primite').hide();
      $('.mesaje_primite').removeClass('active');
      $('.lista_mesaje_trimise').hide();
      $('.mesaje_trimise').removeClass('active');
      $('.scrie_mesaj_nou').hide();
      $('.mesaj_nou').removeClass('active');
      $('.lista_mesaje_sterse').show();
      $('.mesaje_sterse').addClass('active');

    });

} );

</script>

</body>

</html>