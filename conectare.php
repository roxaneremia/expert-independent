<?php
$sqli = @new mysqli('localhost','root','yMhAesaiYH','expert_independent');
if(mysqli_connect_errno()) {
	die("Eroare mysql: ".mysqli_connect_error());
}
$r = $sqli->query("SELECT * FROM membru ORDER BY id_membru", MYSQLI_STORE_RESULT) or die("Query esuat! Eroare: ".$sqli->error);
while($s = $r->fetch_assoc()) {
	//echo "M-am conectat boss!";
	//echo "{$s['nume']}<br>";
}
//$sqli->close();
?>