<?php
  require('./config.php');

  session_start();
  $error = "";

  if (isset($_POST["username"]) && isset($_POST["password"])) {
    foreach ($config["users"] as $user) {
      if ($user["username"] === $_POST["username"] && $user["password"] === $_POST["password"]) {
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
    <link rel="stylesheet" href="assets/css/app.css">
  </head>
<body>
<form method="post" action="/">
  <?php if ($error !== "") { ?>
    <div><?php echo $error; ?></div>
  <?php } ?>

  <p>Login with the user/passwords available in the config.php file</p>

  <div>
    <label for="username">User:</label>
    <input type="text" id="username" name="username" value="johndoe">
  </div>

  <div>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" value="password">
  </div>

  <input type="submit" value="login">
</form>
</body>
</html>
