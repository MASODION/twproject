<?php

  include 'conn/config.php';
  include 'include/auth_checker.php';
  include 'include/admin_checker.php';
  if(isset($_GET['action']) && isset($_GET['id']) && ($_GET['action'] == "unblock" || $_GET['action'] == "block")) {
    $id = intval($_GET['id']);
    $check = $conn->prepare("SELECT userID FROM users WHERE userID = '$id'");
    $check->execute();
    $countlog = $check->rowCount();
    if($countlog > 0) {
      if($_GET['action'] == "block") {
        $check = $conn->prepare("UPDATE users SET userAccountStatus = '0' WHERE userID = '$id'");
        $check->execute();
        $countlog = $check->rowCount();
        if($countlog > 0) {
          $mesaj_succes = "utilizatorul a fost blocat!";
        }
        else {
          $mesaj_eroare = "a aparut o eroare!";
        }
      }
      else {
        $check = $conn->prepare("UPDATE users SET userAccountStatus = '1' WHERE userID = '$id'");
        $check->execute();
        $countlog = $check->rowCount();
        if($countlog > 0) {
          $mesaj_succes = "utilizatorul a fost deblocat!";
        }
        else {
          $mesaj_eroare = "a aparut o eroare!";
        }
      }
    }
    else {
      $mesaj_eroare = "utilizatorul nu a fost gasit.";
    }
  }
  $idmeu = $_SESSION['userID'];
  $check = $conn->prepare("SELECT a.userID, a.userFirstName, a.userLastName, a.userPhoneNumber, a.userEmail, a.userType, a.userSection, a.userAccountStatus, b.typeName, c.sNume FROM users a INNER JOIN users_types b ON a.userType = b.typeID INNER JOIN sectii c ON a.userSection = c.sID WHERE userID != '$idmeu' ORDER BY b.typeLevel DESC");
      $check->execute();
        $countlog = $check->rowCount();
        if($countlog >= 1)
        {
            $row = $check->fetch();
            while($row != NULL) {
                $array[] = $row;
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

  <title>Utilizatori</title>

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
            <h1 class="m-0 text-dark">Utilizatori</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Admin</a></li>
              <li class="breadcrumb-item active">Utilizatori</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == "edit"): ?>


    <?php else: ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header border-0">
                <a href="adduser">* Adauga utilizator nou! </a>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                <tr>
                  <th class="sorting">id</th>
                  <th>Nume</th>
                  <th>Prenume</th>
                  <th>Tip utilizator</th>
                  <th>Sectia</th>
                  <th>Numar telefon</th>
                  <th>Adresa mail</th>
                  <th>Actiuni</th>
                </tr>
                </thead>
                <?php if(isset($array)): ?>
                <tbody>
                  <?php foreach($array as $u): ?>
                <tr>
                  <td><?=$u['userID']?></td>
                  <td><?=$u['userLastName']?></td>
                  <td><?=$u['userFirstName']?></td>
                  <td><?=$u['typeName']?></td>
                  <td><?=$u['sNume']?></td>
                  <td><?=$u['userPhoneNumber']?></td>
                  <td><?=$u['userEmail']?></td>
                  <td><a href="utilizatori?action=edit&id=<?=$u['userID']?>">Editeaza</a> | 
                  <?php 
                    if($u['userAccountStatus'] == 1) {
                      echo '<a href="utilizatori?action=block&id='.$u['userID'].'"><font color = "red">Blocheaza</font></a>';
                    }
                    else {
                      echo '<a href="utilizatori?action=unblock&id='.$u['userID'].'"><font color = "red">Deblocheaza</font></a>';
                    } 
                    
                  ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <?php endif; ?>
                <tfoot>
                <tr>
                  <th>id</th>
                  <th>Nume</th>
                  <th>Prenume</th>
                  <th>Tip utilizator</th>
                  <th>Sectia</th>
                  <th>Numar telefon</th>
                  <th>Adresa mail</th>
                  <th>Actiuni</th>
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
