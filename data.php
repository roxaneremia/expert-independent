<?php
	
	function dataCorecta($date_now) {

		$date_now = date('Y-M-d h:i:s');
		$date_now = strtotime($date_now);
		$date_new = strtotime("+7 day", $date_now);
	    $date_new = date('Y-M-d h:i:s', $date_new);

	    return $date_new;
	}

?>