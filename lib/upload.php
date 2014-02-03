<?php
 
 require_once('client.php');
 
 session_start();
 if ($HTTP_SESSION_VARS["username"] == '')
 {
 	header("Location: index.php");
     	exit();
 }
 
 $result = ws_put();

if (get_class($result) == 'SOAP_Fault')
 {
 	
 	$errorMessage = $result->getFault()->faultstring;
 	echo htmlspecialchars( $errorMessage );
 }
 else
 {
 	echo "<pre>";
		echo htmlspecialchars( $result );
		echo "</pre>";
 }
?>