<?php
session_start();

if(isset($_GET['buton_iesire']) && trim($_GET['buton_iesire'])=='ok')
{
	session_destroy();
	unset($_SESSION['id_membru']);
	unset($_SESSION['nume_cont']);
	unset($_SESSION['nume']);
	unset($_SESSION['prenume']);
	unset($_SESSION['tip_membru']);
	header("Location: index.php");
}
?>