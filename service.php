<?php
//API v0.1
require_once('lib/nusoap.php');
$ns = "http://localhost:8081/AivoFbService/";
$server = new soap_server();
$server->configureWSDL('RetrieveUserProfile',$ns);
$server->wsdl->schemaTargetNamespace=$ns;
$server->register('RetrieveUserProfile',array('idFacebook' => 'xsd:string'),array('return' => 'xsd:string'),$ns);

function RetrieveUserProfile($idFacebook){

    require_once __DIR__ . '/vendor/facebook/graph-sdk/src/Facebook/autoload.php';

    $fb = new Facebook\Facebook([
      'app_id' => '1769203340010211',
      'app_secret' => 'c37d122a6723f341c4020607795798ad',
      'default_graph_version' => 'v2.8',
      ]);

    //User Token válido aproximadamente hasta el 20/01/2017
    $accessToken = "EAAZAJFMCd4uMBAIYiR2ZCJZAJ3D2H7p1ZAI3t44fitS53bLZBbklyWowfL1uTLjqlCYVeOZChacOhJSdDIp6DK0ZCx49i3QfAtglX3j5q2G72a8dFGxUscTZBDtcditlEHzZCFzb8zAgJbZCaOP3Uz7pS3Te8RQkO9GYoZD";

    //Parametro de entrada - ID Facebook - Ejemplos de ID:
    //Dario: 1438839601
    //Gabriel: 699139498
    //Xavier: 790562439
    //$idFacebook = htmlspecialchars($_GET["id"]);

    //Función para cargar la información del token de acceso
    $_SESSION['facebook_access_token'] = (string) $accessToken;
    // OAuth 2.0
    $oAuth2Client = $fb->getOAuth2Client();
    // Exchanges a short-lived access token for a long-lived one
    $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
    $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
    // setting default access token to be used in script
    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

    //Se invoca la información relacionada al Facebbok Id
    try {
            $profile_request = $fb->get('/'.$idFacebook.'?fields=id,first_name,last_name');
            $profile = $profile_request->getGraphNode()->asJson();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            // session_destroy();
            exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
    }

    return($profile);
}
if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);
?>

 