<?php
session_start();
include "de-inclus.php";

  if(isset($_POST['buton_logare'])) {
  //echo '<pre>'; print_r($_SESSION); echo '</pre>';  die();
  if(isset($_SESSION['u']) && trim($_SESSION['u'])!='') { $su = $_SESSION['u']; }  else { $su = 'profil'; $_SESSION['u']='profil'; }
  if(isset($_SESSION['q'])) $sq = $_SESSION['q']; else $sq = '';
  $membruLogare = new Membru();
  $membruLogare->logare($_POST, $su.".php",$sq);
  //echo '<pre>'; print_r($_GET); echo '</pre>';
}

?>


<html>

<head>

    <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logare utilizator</title>

    <!--Styling-->
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>
    <link href='https://fonts.googleapis.com/css?family=Josefin+Slab' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/logare.css" type="text/css" />
    <!--Styling-->

</head>


<body>
  <div class="loginpanel">
  
  <h1>Logare</h1>
  <form method="post">

    <div class="txt">
      <input id="user" type="text" placeholder="Email" name="adresa_email" />
      <label for="user" class="entypo-user"></label>
    </div>

    <div class="txt">
      <input name="parola" id="pwd" type="password" placeholder="Parola" />
      <label for="pwd" class="entypo-lock"></label>
    </div>
      <div class="buttons">
        <input type="submit" value="Autentificare" name="buton_logare" />
        <span>
          <a href="<?php echo URL; ?>/inregistrare.php" class="entypo-user-add register">Inregistrare</a>
        </span>
      </div>

  </form>
  </div>
</body>
</html>