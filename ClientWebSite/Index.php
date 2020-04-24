<?php
session_start();
require_once('database.php');

if (isset($_SESSION['session_id'])) {
    header('Location:home.php');
    exit;
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';


    if (empty($username) || empty($password)) {
        $msg = 'Inserisci username e password %s';
    } else {
        $query = "
            SELECT username, password
            FROM users
            WHERE username = :username
        ";
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();

        $user = $check->fetch(PDO::FETCH_ASSOC);

        if (!$user || password_verify($password, $user['password']) === false) {
            $msg = 'Credenziali utente errate %s';
            echo '<div class="alert alert-warning" role="alert">
             Credenziali utente errate
             </div>';
              header("Refresh:0");
        } else {
            session_regenerate_id();
            $_SESSION['session_id'] = session_id();
            $_SESSION['session_user'] = $user['username'];

            header('Location:home.php');
            exit;
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" >
<link rel="stylesheet" href="master.css">
<title>Login</title>
</head>

<!-- login Section -->
<div id="login">
      <div class="container">
          <div id="login-row" class="row justify-content-center align-items-center">
              <div id="login-column" class="col-md-6 col-md-offset-3" >
                  <div id="login-box" class="col-md-12">
                      <form id="login-form" class="form" action="Index.php" method="post">
                          <h3 class="text-center text-info">Login</h3>
                          <div class="form-group">
                              <label for="username" class="text-info">Username:</label><br>
                            </div>
                                <input type="text" name="username" id="username" placeholder="username" class="form-control" required>
                          <div class="form-group">
                              <label for="password" class="text-info">Password:</label><br>
                              <input type="text" name="password" id="password" class="form-control" placeholder="password" required>
                        </div>
                          <div class="form-group">
                              <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                              <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                          </div>
                          <div id="register-link" class="text-right">
                              <a href="register.php" class="text-info">Register here</a>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
        </div>
      </div>

<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</body>
</html>
