<?php

    include 'conn/config.php';

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      header("location:home");
    }

    if(isset($_POST['email']) && isset($_POST['pass'])) {
        $email = htmlentities($_POST['email']);
        $pass = $pw_sare . htmlentities($_POST['pass']) . $pw_piper;
        $pass = hash("sha256", $pass);


        $query = $conn->prepare("SELECT a.userID, a.userFirstName, a.userLastName, a.userEmail, a.userPhoneNumber, a.userType, a.userAccountStatus, b.typeName, b.typeLevel, c.sNume FROM users a INNER JOIN users_types b ON a.userType = b.typeID INNER JOIN sectii c ON a.userSection = c.sID WHERE a.userEmail = '$email' AND a.userPassword = '$pass'");
        $query->execute();
        $countlog = $query->rowCount();
        if($countlog > 0) {
          $row = $query->fetch();
          if($row['userAccountStatus'] <= 0) {
            $mesaj_eroare = "Contul tau este blocat.";
          }
          else {
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['userFirstName'] = $row['userFirstName'];
            $_SESSION['userLastName'] = $row['userLastName'];
            $_SESSION['userEmail'] = $row['userEmail'];
            $_SESSION['userPhoneNumber'] = $row['userPhoneNumber'];
            $_SESSION['userTypeID'] = $row['userType'];
            $_SESSION['userType'] = $row['typeName'];
            $_SESSION['userLevel'] = $row['typeLevel'];
            $_SESSION['userSection'] = $row['sNume'];
            $_SESSION['logged_in'] = true;
            $mesaj_succes = "Te-ai connectat cu succes. Vei fi redirectionat in 3 secunde.";
          }
        }
        else {
            $mesaj_eroare = "Email sau parola gresita.";
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Conecteaza-te</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8;height: 50px;position: down"><a href="index"> <b>Meden</b>Gen</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">
      <?php

        if(isset($mesaj_eroare)) {
          echo '<font color="red">' . $mesaj_eroare . '</font>';
        }
        elseif (isset($mesaj_succes)) {
          echo '<font color="green">' . $mesaj_succes . '</font>';
          echo '<meta http-equiv="refresh" content="3;url=home">';
        }

      ?>
      
      </p>

      <form action="index" method="post">
        <div class="input-group mb-3">
          <input type="email" id="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="pass" name="pass" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          <p class="mb-1">
          </p>
          <p class="mb-0">
            <a href="register" class="text-center">Creeaza un cont nou!</a>
          </p>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
