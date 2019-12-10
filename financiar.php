<?php

  include 'conn/config.php';
  include 'include/auth_checker.php';
  include 'include/admin_checker.php';

  if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $check = $conn->prepare("SELECT cID, cPret FROM consultatii WHERE cID = '$id'");
    $check->execute();
    $countlog = $check->rowCount();
    if($countlog <= 0) {
      header("location:financiar");
      exit;
    }
    else {
      if(isset($_POST['pret'])) {
        $pret = intval(htmlentities($_POST['pret']));
        if($pret <= 0) {
          $mesaj_eroare = "pretul este incorect scz frt.";
        }
        else {
          $check = $conn->prepare("UPDATE consultatii SET cPret = '$pret' WHERE cID = '$id'");
          $check->execute();
          $countlog = $check->rowCount();
          if($countlog > 0) {
            $mesaj_succes = "pretul a fost schimbat.";
          }
          else {
            $mesaj_eroare = "ceva nu a mers bine. Incearca mai tarziu!";
          }
        }
      }
      else {
        $row = $check->fetch();
        $pret = $row['cPret'];
      }
    }
  }
  


  $check = $conn->prepare("SELECT a.cID, a.cName, a.cSectie, a.cPret, a.cTip, s.sNume FROM consultatii a INNER JOIN sectii s ON a.cSectie = s.sID ORDER BY s.sNume ASC");
  $check->execute();
  $countlog = $check->rowCount();
  if($countlog > 0) {
    $row = $check->fetch();
    while($row != NULL) {
      $consultatii[] = $row;
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

  <title>Financiar</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
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
          <a href="financiar" class="nav-link active">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Financiar
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="utilizatori" class="nav-link">
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
            <h1 class="m-0 text-dark">Financiar</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">Financiar</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php if(isset($id)): ?>
      <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="card-header border-0">
                Editeaza pretul consultatiei / intervetiei id-ul <?=$id?>
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
              <form action="financiar?id=<?=$id?>" method="post">
              <label>Pret:</label>
              <div class="input-group mb-3">
          <input type="text" id="pret" name="pret" class="form-control" value="<?=$pret?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-money-bill"></span>
            </div>
          </div>
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
    <?php else: ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="card-header border-0">
                Editeaza preturi
              </div>
              <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                  <thead>
                <tr>
                  <th>id</th>
                  <th>Nume</th>
                  <th>Sectie</th>
                  <th>Pret</th>
                  <th>Tip</th>
                  <th>Action</th>
                </tr>
                </thead>
                <?php if(isset($consultatii)): ?>
                <tbody>
                  <?php foreach($consultatii as $u): ?>
                <tr>
                  <td><?=$u['cID']?></td>
                  <td><?=$u['cName']?></td>
                  <td><?=$u['sNume']?></td>
                  <td><?=$u['cPret']?> lei</td>
                  <td><?=$u['cTip']?></td>
                  <td><a href="financiar?id=<?=$u['cID']?>">Editeaza</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <?php endif; ?>
                <tfoot>
                <tr>
                <th>id</th>
                  <th>Nume</th>
                  <th>Sectie</th>
                  <th>Pret</th>
                  <th>Tip</th>
                  <th>Action</th>
                </tr>
                </tfoot>
                </table>
                  </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <?php endif; ?>
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
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>
