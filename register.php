<?php

  include 'conn/config.php';

  if(isset($_POST['nume']) && !empty($_POST['nume'])) {
    $nume = htmlentities($_POST['nume']);
    $prenume = htmlentities($_POST['prenume']);
    $email = htmlentities($_POST['email']);
    $nr_tel = htmlentities($_POST['nr_tel']);
    $pass = $pw_sare . htmlentities($_POST['pass']) . $pw_piper;
    $pass = hash("sha256", $pass);


    $query = $conn->prepare("SELECT userID FROM users WHERE userEmail = '$email'");
    $query->execute();
    $countlog = $query->rowCount();

    if($countlog > 0) {
      $mesaj_eroare = "Exista deja un cont pentru acest email.";
    }
    else {
      $query = $conn->prepare("INSERT INTO users (userFirstName, userLastName, userEmail, userPassword, userType) VALUES ('$prenume', '$nume', '$email', '$pass', '1')");
      $query->execute();
      $countlog = $query->rowCount();

      if($countlog > 0) {
        $mesaj_succes = "Contul a fost creat. Va puteti conecta acum.";
      }
      else {
        $mesaj_eroare = "Ceva nu a mers bine. Incearca mai tarziu.";
      }
    }
    

  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Creati-va un cont</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
    <p class="login-box-msg">
      <?php

        if(isset($mesaj_eroare)) {
          echo '<font color="red">' . $mesaj_eroare . '</font>';
        }
        elseif (isset($mesaj_succes)) {
          echo '<font color="green">' . $mesaj_succes . '</font>';
        }

      ?>
      
      </p>

      <form action="register" method="post">
        <div class="input-group mb-3">
          <input type="text" id="nume" name="nume" class="form-control" placeholder="Nume">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" id="prenume" name="prenume" class="form-control" placeholder="Prenume">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" id="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" id="nr_tel" name="nr_tel" class="form-control" placeholder="Numar de telefon">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="pass" name="pass" class="form-control" placeholder="Parola">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="pass_r" name="pass_r" class="form-control" placeholder="Repeta parola">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               Sunt de acord cu <a href="#">termenii si conditiile!</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <a href="index" class="text-center">Am deja un cont!</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
