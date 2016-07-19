<head>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">


    <!--css-->
      <link rel="stylesheet" href="css/meniu-profil.css" type="text/css">
    <!--css-->

    <!--js-->
      <script src="js/meniu-profil.js"></script>
    <!--js-->

</head>
<body>
<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="197" style="margin-bottom:0">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="<?php echo URL; ?>">Expert Independent</a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">

        <ul class="nav navbar-nav">
          <li><a href="<?php echo URL; ?>/">Cauta un job</a></li>
          <?php if(isset($_SESSION['nume_cont'])) { ?>
             <li><a href="<?php echo URL; ?>/posteaza-job.php">Posteaza un job</a></li>
          <?php } else { ?>
             <li><a href="<?php echo URL; ?>/posteaza-job.php?u=posteaza-job">Posteaza un job</a></li>
          <?php }  ?>

          <li><a href="<?php echo URL; ?>/despre-noi.php">Cum functioneaza?</a></li>
          
          <?php
		  if($_SESSION['id_membru']==ID_PLATFORMA)
		  {
		  ?>
          <li><a href="<?php echo URL; ?>/statistici.php" style="color:yellow; font-weight:bold;">Statistici</a></li>
          <?php } ?>
          
        </ul>

      <?php
        if(isset($_SESSION['nume_cont'])) {
        echo '<div id="myNav" class="overlay">

        <!-- Button to close the overlay navigation -->
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <!-- Overlay content -->
        <div class="overlay-content">
          <a href="editare_profil.php">Editare profil</a>
          <a href="servicii_postate.php">Servicii postate de mine</a>
          <a href="concursurile_mele.php">Concursurile mele</a>
          <a href="tranzactii.php">Tranzactii</a>
          <a href="mesagerie.php">Mesagerie</a>
        </div>

      </div>

        <ul class="nav navbar-nav navbar-right">
          <li class="contul_meu"  style="padding-top: 5%">
          <span onclick="openNav()""><a id="btn_cont" href="#" style="color: #818181; padding-top: 2%"><span class="glyphicon glyphicon-user" style="padding-right: 5px;"></span>Contul meu ('.$_SESSION['prenume']." ".$_SESSION['nume'].')</a></span></li>
          <li class="logout">
          <a href="'.URL.'/deconectare.php?buton_iesire=ok" id="buton_iesire"><span class="glyphicon glyphicon-off" style="padding-right: 5px"></span>Iesiti din cont</a>
          </li>
        </ul>';
          }
          else { 
        ?>
       <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="<?php echo URL; ?>/logare.php?u=servicii_postate">
              <span class="glyphicon glyphicon-log-in"></span> Logare
            </a>
          </li>
          <li><a href="<?php echo URL; ?>/inregistrare.php"><span class="glyphicon glyphicon-edit"></span> Inregistrare</a></li>
        </ul>
        <?php  } ?>  

      </div>
    </div>
  </div>
</nav>
</body>


    