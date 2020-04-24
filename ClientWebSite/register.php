<?php
require_once('database.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    //     $username,
    //     FILTER_VALIDATE_REGEXP, [
    //         "options" => [
    //             "regexp" => "/^[a-z\d_]{3,20}$/i"
    //         ]
    //     ]
    // );
    // $pwdLenght = mb_strlen($password);

  //   echo $password;
  // echo  $username;
    if (empty($username) || empty($password)) {

      //  $msg = 'Compila tutti i campi %s';
        echo '<div class="alert alert-warning" role="alert">
        ci sono dei campi vuoti
         </div>';
       }

     // } elseif (false === $isUsernameValid) {
    //     $msg = 'Lo username non è valido. Sono ammessi solamente caratteri
    //             alfanumerici e l\'underscore. Lunghezza minina 3 caratteri.
    //             Lunghezza massima 20 caratteri';
    // } elseif ($pwdLenght < 8 || $pwdLenght > 20) {
    //     $msg = 'Lunghezza minima password 8 caratteri.
    //             Lunghezza massima 20 caratteri';
      else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $query = "
            SELECT id
            FROM users
            WHERE username = :username
        ";

        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();

        $user = $check->fetchAll(PDO::FETCH_ASSOC);

        if (count($user) > 0) {
          echo '<div class="alert alert-warning" role="alert">
          utente gia registrato
           </div>';
           header("Refresh:0");
        } else {
            $query = "
                INSERT INTO users
                VALUES (0, :username, :password)
            ";

            $check = $pdo->prepare($query);
            $check->bindParam(':username', $username, PDO::PARAM_STR);
            $check->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $check->execute();

            if ($check->rowCount() > 0) {
              echo '<div class="alert alert-warning" role="alert">
              Registrazione eseguita con successo
               </div>';
               header("Refresh:0; url=Index.php");
              //  $msg = 'Registrazione eseguita con successo';
            } else {
                $msg = 'Problemi con l\'inserimento dei dati %s';
            }
        }
    }

  // printf('  <a style="margin-top:9px; margin-right : 3px; float:right; " href="Index.php">Torna alla home </a>');
}?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" >
  <link rel="stylesheet" href="master.css">
<title>register</title>
</head>
    <body>
      <div id="login">
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6 col-md-offset-3" >
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="register.php" method="post">
                                <h3 class="text-center text-info">Register</h3>
                                <div class="form-group">
                                    <label for="username" class="text-info">Username:</label><br>
                                  </div>
                                      <input type="text" name="username" id="username" placeholder="username" class="form-control" required>
                                <div class="form-group">
                                    <label for="password" class="text-info">Password:</label><br>
                                    <input type="text" name="password" id="password" class="form-control" placeholder="password" required>
                              </div>
                                <div class="form-group">
                                  <br>
                                    <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                                    <a style="margin-top:9px; float:right; " href="Index.php">Torna alla home </a>
                                  </form>
                                </div>
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
