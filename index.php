<?php
  require('./config.php');

  session_start();
  $error = "";

  if (isset($_POST["login"]) && isset($_POST["password"])) {
    foreach ($config["users"] as $user) {
      if ($user["login"] === $_POST["login"] && $user["password"] === $_POST["password"]) {
        $_SESSION["user"] = $user;
        header('location: /editor.php');
        die();
      }
    }

    if (!isset($_SESSION["user"])) {
      $error = "Incorrect username or password.";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="/css/app.css">
  </head>
<body>
<form method="post" action="/">
  <?php if ($error !== "") { ?>
    <div><?php echo $error; ?></div>
  <?php } ?>

  <p>Login with the user/passwords available in the config.php file</p>

  <div>
    <label for="login">User:</label>
    <input type="text" id="login" name="login" value="johndoe">
  </div>

  <div>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" value="password">
  </div>

  <input type="submit" value="Login">
</form>
</body>
</html>
