<?php
  if(isset($_GET['u'])) $u = $_GET['u']; else $u = '';
  if(isset($_GET['q'])) $q = $_GET['q']; else $q = '';
  $membruCauta = new Membru();
  
  if(!$membruCauta->autentificare($u,$q)) {
    header("Location: logare.php");
  }

?>