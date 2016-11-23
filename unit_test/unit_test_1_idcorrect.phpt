--TEST--
RetrieveUserProfile() function - A basic test to see if it works. :)
--FILE--
<?php
require_once('../lib/nusoap.php');
$wsdl = "http://localhost:8081/AivoFbService/service.php?wsdl";
$client = new nusoap_client($wsdl,'wsdl');

$idFacebook = '100014249712772';
$param = array('idFacebook' => $idFacebook);
$response = $client->call('RetrieveUserProfile',$param);
var_dump($response);
?>
--EXPECT--
string(63) "{"id":"100014249712772","first_name":"Mark","last_name":"Aivo"}"