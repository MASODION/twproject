<?php

  include 'conn/config.php';
  include 'include/auth_checker.php';
  include 'include/admin_checker.php';

  if(isset($_POST['nume']) && !empty($_POST['nume'])) {
    $nume = htmlentities($_POST['nume']);
    $prenume = htmlentities($_POST['prenume']);
    $email = htmlentities($_POST['email']);
    $nr_tel = htmlentities($_POST['nr_tel']);
    $pass = $pw_sare . htmlentities($_POST['pass']) . $pw_piper;
    $pass = hash("sha256", $pass);
    $tip_cont = $_POST['tip_cont'];


    $query = $conn->prepare("SELECT userID FROM users WHERE userEmail = '$email'");
    $query->execute();
    $countlog = $query->rowCount();

    if($countlog > 0) {
      $mesaj_eroare = "exista deja un cont cu acest email.";
    }
    else {

      $check = $conn->prepare("SELECT typeID FROM users_types WHERE typeName = '$tip_cont'");
      $check->execute();
      $countlog = $check->rowCount();
      if($countlog > 0) {
        $row = $check->fetch();
        $type_id = $row['typeID'];
        $query = $conn->prepare("INSERT INTO users (userFirstName, userLastName, userEmail, userPassword, userPhoneNumber, userType, userSection) VALUES ('$prenume', '$nume', '$email', '$pass', '$nr_tel', '$type_id', '0')");
        $query->execute();
        $countlog = $query->rowCount();

        if($countlog > 0) {
          $mesaj_succes = "contul a fost creat.";
        }
        else {
          $mesaj_eroare = "ceva nu a mers bine. Incearca mai tarziu.";
        }
      }
      else {
        $mesaj_eroare = "tipul de cont nu exista.";
      }
    }
    

  }



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Adauga utilizator</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>
          <?=$_SESSION['userFirstName']?> <?=$_SESSION['userLastName']?>
          <i class="fas fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Informatii:</span>
          <?php if($_SESSION['userTypeID'] == 2): ?>
          <center><p>Grad: <?=$_SESSION['userType']?></p>
          <p style="margin-bottom:13px;">Sectie: <?=$_SESSION['userSection']?></p></center>
          <?php else: ?>
          <center><p style="margin-bottom:13px;">Grad: <?=$_SESSION['userType']?></p>
          <?php endif; ?>
          <p> </p>
          <div class="dropdown-divider"></div>
          <a href="logout" class="dropdown-item dropdown-footer">Log out</a>
        </div>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><b>Meden</b>Gen</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php if($_SESSION['userLevel'] == 1): ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Pacient
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/layout/top-nav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vezi rezultate</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/boxed.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fa o rezervare</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif;?>
          <?php if($_SESSION['userLevel'] == 2): ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Medic Specialist
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/layout/top-nav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vezi rezultate</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/boxed.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fa o rezervare</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif;?>
          <?php if($_SESSION['userLevel'] == 3): ?>
          <li class="nav-item">
          <a href="consultatii" class="nav-link">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Consultatii
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="contabilitate" class="nav-link">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Contabilitate
              </p>
            </a>
          </li>
          <?php endif;?>
          <?php if($_SESSION['userLevel'] == 4): ?>
          <li class="nav-item">
          <a href="financiar" class="nav-link">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Financiar
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="utilizatori" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Utilizatori
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="rapoarte" class="nav-link">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Rapoarte
              </p>
            </a>
          </li>
          <?php endif;?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Adauga utilizator</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Admin</a></li>
              <li class="breadcrumb-item"><a href="utilizatori">Utilizatori</a></li>
              <li class="breadcrumb-item active">Adauga utilizator</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <div class="card">
              <div class="card-header border-0">
                Adauga un utilizator nou
              </div>
              <div class="card-body">
                <?php 
                  if(isset($mesaj_eroare)) {
                    echo '<font color="red">* '. $mesaj_eroare. '</font>';
                  }
                  elseif(isset($mesaj_succes)) {
                    echo '<font color="green">* ' . $mesaj_succes .'</font>';
                  }
                ?>
                <form action="adduser" method="post">
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
        <div class="form-group">
                  <label>Tip cont:</label>
                  <select name="tip_cont" class="form-control select2" style="width: 100%;">
                    <option selected="selected">Secretara</option>
                    <option>Administrator</option>
                    <option>Medic specialist</option>
                  </select>
                </div>
        <div class="row">

            <button type="submit" class="btn btn-primary btn-block">Register</button>
          <!-- /.col -->
        </div>
                </form>
              </div>
          </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard3.js"></script>
</body>
</html>
