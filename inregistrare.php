<?php
session_start();
include "de-inclus.php";

if(isset($_POST['trimite'])) {
	if(isset($_POST['parola']) && trim($_POST['parola']) != '') $parola = $_POST['parola']; else $parola = 0;
	if(isset($_POST['repeta_parola']) && trim($_POST['repeta_parola']) != '') $repeta_parola = $_POST['repeta_parola']; else $repeta_parola = 0;
	if( ($parola) && ($repeta_parola) && ($parola == $repeta_parola))
	{
		$membru = new Membru();
		$membru->inregistrare($_POST);
		header("Location: logare.php");
	}
	else {
	?>
		<script>alert('Parolele nu coincid ...');</script>
	<?php
	}
 }
?>

<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Inregistrare cont</title>

<!--Styling-->
<link href='https://fonts.googleapis.com/css?family=Josefin+Slab' rel='stylesheet' type='text/css'>
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="css/antet.css" type="text/css" />
<link rel="stylesheet" href="css/inregistrare.css" type="text/css" />
<link rel="stylesheet" href="css/subsol.css" type="text/css" />

<!--Styling-->

<!--JS-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="js/jquery-1.12.3.js"></script>
<!--JS-->
<?php include_once('meta.php'); ?>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">
	<div class="loginpanel">

	<h1>Inregistrare cont</h1>

	<form method="post">

		<div class="txt">
			<input id="nume" type="text" placeholder="Nume" name="nume" />
			<label for="nume" class="entypo-user"></label>
		</div>

		<div class="txt">
			<input id="prenume" type="text" placeholder="Prenume" name="prenume" />
			<label for="prenume" class="entypo-user"></label>
		</div>

		<div class="txt">
			<input id="email" type="text" placeholder="Email" name="adresa_email" />
			<label for="email" class="entypo-mail"></label>
		</div>

		<div class="txt">
			<input id="repeta_email" type="text" placeholder="Confirma email" name="confirma_email" />
			<label for="repeta_email" class="entypo-mail"></label>
		</div>

		<div class="txt">
			<input id="user" type="text" placeholder="Nume de utilizator" name="nume_cont"/>
			<label for="user" class="entypo-user"></label>
		</div>

		<div class="txt">
			<input id="pwd" type="password" placeholder="Parola" name="parola"/>
			<label for="pwd" class="entypo-lock"></label>
		</div>

		<div class="txt">
			<input id="repeta_pwd" type="password" placeholder="Repeta parola" name="repeta_parola" />
			<label for="repeta_pwd" class="entypo-lock"></label>
		</div>

		<div class="txt container" style="margin-top: 20px;">

			<label class="radio-inline">
      			<input type="radio" name="tip" value="1" <?php if(isset($_SESSION['tip']) && $_SESSION['tip'] == 'client') echo 'checked = "checked"'; ?> style="margin-top:0;margin-left:-48px;"> 
      			<p class="pradio client">Client</p>
    		</label>

    		<label class="radio-inline">
      			<input type="radio" name="tip" value="2"  <?php if(isset($_SESSION['tip']) && $_SESSION['tip'] == 'developer') echo 'checked = "checked"'; ?> style="margin-top:0;margin-left:-48px;"> 
      			<p class="pradio developer">Developer</p>
    		</label>
		</div>

		<!--<div class="txt" align="center">
			<div id="captcha_label">Scrie caracterele pe pe care le vezi in imagine</div>
			<div class="txt" style="float:left">
				<input id="captcha_input" type="text" placeholder=""/>
				<label for="captcha_input"></label>
			</div>
			<img id="captcha" src="http://www.captchacreator.com/captcha/captchac_code_google.php" ></img>
		</div>-->

		<div class="checkbox">
		    <label>
		      <input type="checkbox" style="margin-top: 1px; width: 0%" id="termeni" checked="true"><em>Sunt de acord cu <a class="fancybox fancybox.iframe" href="termeni-conditii.php">termenii si conditiile</a> platformei Expert Independent</em>
		    </label>
		  </div>

		<div class="buttons" style="clear:both">
			<input type="submit" value="Inregistrare" name="trimite"/>
		</div>

	</form>

	</div>

	<span class="resp-info"></span>
</body>

</html>