<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
require './config.php';

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
  "sub" => $_SESSION["user"]["login"],

  // Full name of user
  "name" => $_SESSION["user"]["name"],

  // 10 minutes expiration
  "exp" => time() + 60 * 10
);

// Scopes the path to a specific user directory
if (isset($config["scopeUser"]) && $config["scopeUser"]) {
  $payload["https://claims.tiny.cloud/drive/root"] = "/" . $_SESSION["user"]["login"];
}

try {
  $token = JWT::encode($payload, $config["privateKey"], 'RS256');
  http_response_code(200);
  header('Content-Type: application/json');
  echo json_encode(array("token" => $token));
} catch (Exception $e) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo $e->getMessage();
}
?>