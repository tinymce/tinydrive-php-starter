<?php
  require('./config.php');

  session_start();
  $error = "";

  if (isset($_POST["username"]) && isset($_POST["password"])) {
    $loggedInUser = null;

    foreach ($config["users"] as $user) {
      if ($user["username"] === $_POST["username"] && $user["password"] === $_POST["password"]) {
        $loggedInUser = $user;
        break;
      }
    }

    if ($loggedInUser) {
      $_SESSION["user"] = $loggedInUser;
      header('location: editor.php');
      die();
    } else {
      $error = "Incorrect username or password.";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <div class="container vh-100 d-flex justify-content-center align-items-center">
    <form method="post" action="index.php">
      <?php if ($error !== "") { ?>
        <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
      <?php } ?>

      <h1 class="h3 mb-3">Login</h1>
      <p>Login with the user/passwords available in the <code>config.php</code> file</p>

      <div class="form-group">
        <label for="username" class="font-weight-bold">User</label>
        <input type="text" class="form-control" id="username" name="username" value="johndoe">
      </div>

      <div class="form-group">
        <label for="password" class="font-weight-bold">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="password">
      </div>

      <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Login">
      </div>
    </form>
  </div>
</body>
</html>
