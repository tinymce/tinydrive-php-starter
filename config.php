<?php
$config = array();

// Replace this with your api key from the "API Key Manager" at the tiny.cloud account page
$config["apiKey"] = "your-api-key";

// Replace woth your private key from the "JWT Key Manager" at the tiny.cloud account page
$config['privateKey'] = <<<EOD
-----BEGIN PRIVATE KEY-----
...
-----END PRIVATE KEY-----
EOD;

// This is the fake database that the login authenticates against
$config["users"] = [
  ["login" => "johndoe", "password" => "password", "name" => "John Doe"],
  ["login" => "janedoe", "password" => "password", "name" => "Jane Doe"]
];

// If this is enabled the root of Tiny Drive will be within a directory named as the user login
$config["scopeUser"] = false;
