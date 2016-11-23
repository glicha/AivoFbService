--TEST--
RetrieveUserProfile() function - A basic test to see if it works. :)
--FILE--
<?php
require_once('../lib/nusoap.php');
$wsdl = "http://localhost:8081/AivoFbService/service.php?wsdl";
$client = new nusoap_client($wsdl,'wsdl');


$response = $client->call('RetrieveUserProfile');
var_dump($response);
?>
--EXPECT--
bool(false)