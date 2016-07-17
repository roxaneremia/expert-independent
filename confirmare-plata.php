<?php
include "de-inclus.php";

// Database variables
$host = "localhost"; //database location
$user = "root"; //database username
$pass = "yMhAesaiYH"; //database password
$db_name = "expert_independent"; //database name

// PayPal settings
$paypal_email = 'roxana.eremia94@gmail.com';
$return_url = $URL . '/plata-acceptata.php';
$cancel_url = $URL . '/plata-refuzata.php';
$notify_url = $URL . '/confirmare-plata.php';

$item_name = 'Test Item';
$item_amount = 5.00;

function check_txnid($tnxid){
	global $link;
	return true;
	$valid_txnid = true;
	//get result set
	$sql = mysql_query("SELECT * FROM `payments` WHERE txnid = '$tnxid'", $link);
	if ($row = mysql_fetch_array($sql)) {
		$valid_txnid = false;
	}
	return $valid_txnid;
}

function check_price($price, $id){
	$valid_price = false;
	//you could use the below to check whether the correct price has been paid for the product
	
	/*
	$sql = mysql_query("SELECT amount FROM `products` WHERE id = '$id'");
	if (mysql_num_rows($sql) != 0) {
		while ($row = mysql_fetch_array($sql)) {
			$num = (float)$row['amount'];
			if($num == $price){
				$valid_price = true;
			}
		}
	}
	return $valid_price;
	*/
	return true;
}

function updatePayments($data){
	global $link;
	
	if (is_array($data)) {
		$sql = mysql_query("INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES (
				'".$data['txn_id']."' ,
				'".$data['payment_amount']."' ,
				'".$data['payment_status']."' ,
				'".$data['item_number']."' ,
				'".date("Y-m-d H:i:s")."'
				)", $link);
		return mysql_insert_id($link);
	}
}


// Check if paypal request or response
if (!isset($_POST["txn_id"]) &amp;amp;amp;&amp;amp;amp; !isset($_POST["txn_type"])){
    $querystring = '';
    
    // Firstly Append paypal account to querystring
    $querystring .= "?business=".urlencode($paypal_email)."&amp;amp;amp;";
    
    // Append amount&amp;amp;amp; currency (£) to quersytring so it cannot be edited in html
    
    //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
    $querystring .= "item_name=".urlencode($item_name)."&amp;amp;amp;";
    $querystring .= "amount=".urlencode($item_amount)."&amp;amp;amp;";
    
    //loop for posted values and append to querystring
    foreach($_POST as $key =&amp;amp;gt; $value){
        $value = urlencode(stripslashes($value));
        $querystring .= "$key=$value&amp;amp;amp;";
    }
    
    // Append paypal return addresses
    $querystring .= "return=".urlencode(stripslashes($return_url))."&amp;amp;amp;";
    $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&amp;amp;amp;";
    $querystring .= "notify_url=".urlencode($notify_url);
    
    // Append querystring with custom field
    //$querystring .= "&amp;amp;amp;custom=".USERID;
    
    // Redirect to paypal IPN
    header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
    exit();
} else {
    //Database Connection
    $link = mysql_connect($host, $user, $pass);
    mysql_select_db($db_name);
    
    // Response from Paypal

    // read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    foreach ($_POST as $key =&amp;amp;gt; $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
        $req .= "&amp;amp;amp;$key=$value";
    }
    
    // assign posted variables to local variables
    $data['item_name']          = $_POST['item_name'];
    $data['item_number']        = $_POST['item_number'];
    $data['payment_status']     = $_POST['payment_status'];
    $data['payment_amount']     = $_POST['mc_gross'];
    $data['payment_currency']   = $_POST['mc_currency'];
    $data['txn_id']             = $_POST['txn_id'];
    $data['receiver_email']     = $_POST['receiver_email'];
    $data['payer_email']        = $_POST['payer_email'];
    $data['custom']             = $_POST['custom'];
        
    // post back to PayPal system to validate
    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
    
    $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
    
    if (!$fp) {
        // HTTP ERROR
        
    } else {
        fputs($fp, $header . $req);
        while (!feof($fp)) {
            $res = fgets ($fp, 1024);
            if (strcmp($res, "VERIFIED") == 0) {
                
                // Used for debugging
                // mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));
                        
                // Validate payment (Check unique txnid &amp;amp;amp; correct price)
                $valid_txnid = check_txnid($data['txn_id']);
                $valid_price = check_price($data['payment_amount'], $data['item_number']);
                // PAYMENT VALIDATED &amp;amp;amp; VERIFIED!
                if ($valid_txnid &amp;amp;amp;&amp;amp;amp; $valid_price) {
                    
                    $orderid = updatePayments($data);
                    
                    if ($orderid) {
                        // Payment has been made &amp;amp;amp; successfully inserted into the Database
                    } else {
                        // Error inserting into DB
                        // E-mail admin or alert user
                        // mail('user@domain.com', 'PAYPAL POST - INSERT INTO DB WENT WRONG', print_r($data, true));
                    }
                } else {
                    // Payment made but data has been changed
                    // E-mail admin or alert user
                }
            
            } else if (strcmp ($res, "INVALID") == 0) {
            
                // PAYMENT INVALID &amp;amp;amp; INVESTIGATE MANUALY!
                // E-mail admin or alert user
                
                // Used for debugging
                //@mail("user@domain.com", "PAYPAL DEBUGGING", "Invalid Response
data =
&amp;amp;lt;pre&amp;amp;gt;".print_r($post, true)."&amp;amp;lt;/pre&amp;amp;gt;

");
            }
        }
    fclose ($fp);
    }
}
?>