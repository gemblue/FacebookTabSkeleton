<?php 
# import konfigurasi facebook
include_once ('config/facebook_app.php');
     
/*
| 
| If user first time authenticated the application facebook
| redirects user to baseUrl, so I checked if any code passed
| then redirect him to the application url 
|
*/

if (isset($_GET['code'])){
    header("Location: " . $fbconfig['appBaseUrl']);
    exit;
}
//~~
    
if (isset($_GET['request_ids'])){
    //user comes from invitation
    //track them if you need
}

$user = null;

try
{
	include_once "facebook.php";
}
catch(Exception $o)
{
    echo '<pre>';
    print_r($o);
    echo '</pre>';
}
    
// Create our Application instance.
$facebook = new Facebook(array(
    'appId'  => $fbconfig['appid'],
    'secret' => $fbconfig['secret'],
    'cookie' => true,
));


$signed_request = $facebook->getSignedRequest();
	
?>