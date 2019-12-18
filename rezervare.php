<?php

  include 'conn/config.php';
  include 'include/auth_checker.php';
  include 'include/pacient_checker.php';

  if(isset($_POST['data']) && isset($_POST['ora'])) {
      $date = htmlentities($_POST['data']);
      $ora = htmlentities($_POST['ora']);
      $tip_consult = htmlentities($_POST['tip_consult']);
      $sectia = htmlentities($_POST['sectia']);
      if(!empty($date) && !empty($ora) && !empty($tip_consult) && !empty($sectia)){
          $check = $conn->prepare("SELECT sID FROM sectii WHERE sNume = '$sectia'");
          $check->execute();
          $countlog = $check->rowCount();
          if($countlog > 0) {
            $idpacient = $_SESSION['userID'];
            $row = $check->fetch();
            $sectia_id = $row['sID'];
            $check = $conn->prepare("INSERT INTO cereri_programari (cpTipProgramare, cpPacient, cpDate, cpOra, cpSectia) VALUES('$tip_consult', '$idpacient', '$date', '$ora', '$sectia_id')");
            $check->execute();
            $countlog = $check->rowCount();
            if($countlog > 0) {
                $mesaj_succes = "programarea a fost facuta.";
            }
            else {
                $mesaj_eroare = "ceva nu a mers bine. Incearca mai tarziu.";
            }
          }
          else {
              $mesaj_eroare = "sectie invalida.";
          }
      }
  }
    
  $check = $conn->prepare("SELECT * FROM sectii");
  $check->execute();
  $countlog = $check->rowCount();
  if($countlog > 0) {
      $row = $check->fetch();
      while($row != NULL) {
          $sectii[] = $row;
          $row = $check->fetch();
      }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Rezerva</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
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
    <a href="index3.html" class="brand-link">
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
          <li class="nav-item">
                <a href="rezultate" class="nav-link">
                  <i class="nav-icon fas fa-history"></i>
                  <p>Vezi rezultate</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="rezervare" class="nav-link active">
                  <i class="nav-icon fas fa-calendar-alt"></i>
                  <p>Fa o rezervare</p>
                </a>
              </li>
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
            <h1 class="m-0 text-dark">Fa o rezervare</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">Rezervare</li>
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
                    Fa o rezervare
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
                    <form action="rezervare" method="post">
                    <label>Data:</label>
                    <div class="input-group mb-3">
          <input type="date" id="data" name="data" class="form-control">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-calendar-alt"></span>
            </div>
          </div>
        </div>
        <label>Ora:</label>
                    <div class="input-group mb-3">
          <input type="text" id="ora" name="ora" class="form-control" placeholder="09:00">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-calendar-alt"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
                  <label>Tip programare:</label>
                  <select name="tip_consult" class="form-control select2" style="width: 100%;">
                  <option selected="selected">consultatie</option>
                    <option>interventie</option>
                  </select>
                </div>
        <div class="form-group">
                  <label>Sectia:</label>
                  <select name="sectia" class="form-control select2" style="width: 100%;">
                  <?php foreach($sectii as $s): ?>
                    <option><?=$s['sNume']?></option>
                  <?php endforeach; ?>
                  </select>
                </div>
                <div class="row">

<button type="submit" class="btn btn-primary btn-block">Fa o rezervare!</button>
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
