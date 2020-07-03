<?php

use Auth0\SDK\API\Authentication;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/dotenv-loader.php';

$connection = 'Username-Password-Authentication';

$api = new Authentication(getenv('AUTH0_DOMAIN'), getenv('AUTH0_CLIENT_ID'));

if($argc>1)
    parse_str(implode('&',array_slice($argv, 1)), $_GET);

$email = $_GET["email"];
$password = $_GET["password"];
if($password != null) {
    $response = $api->dbconnections_signup($email, $password, $connection);
    var_dump($response);
} else {
    $client_secret = getenv('AUTH0_CLIENT_SECRET');
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://dev-jobaertest.us.auth0.com/passwordless/start",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"client_id\": \"EeudLx0nrOiUgsKOvEPKFCEhqQMmpcIL\", \"client_secret\": \"$client_secret\", \"connection\": \"email\", \"email\": \"$email\",\"send\": \"code\"}",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        var_dump($response);
    }
}



