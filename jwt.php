<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
require './config.php';

function fatalError($message) {
  http_response_code(500);
  header('Content-Type: application/json');
  die(json_encode(array("message" => "JWT auth failed: " . $message)));
}

if (!extension_loaded('openssl')) {
  fatalError('You need to enable the openssl extension in your php.ini.');
}

session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if (!isset($_SESSION["user"])) {
  http_response_code(403);
  echo "Could not produce a jwt token since the user is not logged in.";
  die();
}

$payload = array(
  // Unique user id string
  "sub" => $_SESSION["user"]["username"],

  // Full name of user
  "name" => $_SESSION["user"]["fullname"],

  // 10 minutes expiration
  "exp" => time() + 60 * 10
);

// When this is set the user will only be able to manage and see files in the specified root
// directory. This makes it possible to have a dedicated home directory for each user.
if (isset($config["scopeUser"]) && $config["scopeUser"]) {
  $payload["https://claims.tiny.cloud/drive/root"] = "/" . $_SESSION["user"]["username"];
}

try {
  $privateKey = file_get_contents(__DIR__ . '/' . $config["privateKeyFile"]);
  $token = @JWT::encode($payload, $privateKey, 'RS256');
  http_response_code(200);
  header('Content-Type: application/json');
  echo json_encode(array("token" => $token));
} catch (Exception $e) {
  fatalError($e->getMessage());
}

?>