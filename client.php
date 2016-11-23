<?php

require_once('lib/nusoap.php');
$wsdl = "http://localhost:8081/AivoFbService/service.php?wsdl";
$client = new nusoap_client($wsdl,'wsdl');
if (isset($_GET["id"])){
    $idFacebook = htmlspecialchars($_GET["id"]);
    $param = array('idFacebook' => $idFacebook);
    $response = $client->call('RetrieveUserProfile',$param);
    if (strlen(trim($response)) == 0){
        print_r("No se pudo recuperar información con el Id suministrado.");
    }else{
        print_r($response);
        }
} else {
    print_r("Debe ingresar el Id del usuario de Facebook que desea recuperar. Ej: /client.php?id=xxx");
}
?>