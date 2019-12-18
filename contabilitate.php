<?php

  include 'conn/config.php';
  include 'include/auth_checker.php';
  include 'include/secretara_checker.php';
  
  $check = $conn->prepare("SELECT userID, userFirstName, userLastName FROM users WHERE userType = '2'");
  $check->execute();
  $countlog = $check->rowCount();
  if($countlog > 0) {
      $row = $check->fetch();
      while($row != NULL) {
          $doctori[] = $row;
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

  <title>Contabilitate</title>

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
          <a href="consultatii" class="nav-link">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Consultatii
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="contabilitate" class="nav-link active">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Contabilitate
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
            <h1 class="m-0 text-dark">Contabilitate</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">Contabilitate</li>
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
                Contabilitate
              </div>
              <div class="card-body">
                <form action="gen_cont" method="post">
                <label>Doctor: </label>
                <div class="form-group">
                <select name="doctor" class="form-control select2" style="width: 100%;">
                    <option></option>
                  <?php foreach($doctori as $d): ?>
                    <option><?=$d['userID']?>. <?=$d['userFirstName']?> <?=$d['userLastName']?></option>
                  <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                <label>Perioada: </label>
                <select id="perioada" name="perioada" class="form-control select2" style="width: 100%;">
                    <option></option>
                    <option value="lunara">lunara</option>
                    <option value="anuala">anuala</option>
                  </select>
                </div>
                <label>Valoare: </label>
                <div class="form-group">
                <select id="an" name="an" class="form-control select2" style="width: 100%;">
                    <option></option>
                    <option value="2019">2019</option>
                  </select>
                  <select id="luna" name="luna" class="form-control select2" style="width: 100%;">
                    <option></option>
                    <option value="1.ianuarie">ianuarie</option>
                    <option value="2.februarie">februarie</option>
                    <option value="3.martie">martie</option>
                    <option value="4.aprilie">aprilie</option>
                    <option value="5.mai">mai</option>
                    <option value="6.iunie">iunie</option>
                    <option value="7.iulie">iulie</option>
                    <option value="8.august">august</option>
                    <option value="9.septembrie">septembrie</option>
                    <option value="10.octombrie">octombrie</option>
                    <option value="11.noiembrie">noiembrie</option>
                    <option value="12.decembrie">decembrie</option>
                  </select>
                </div>
                <div class="row">
                  <button type="submit" class="btn btn-primary btn-block">Genereaza!</button>
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
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
    });
    $('#an').hide();
    $('#luna').hide();
    $(function() {
    $("#perioada").on("change",function() {
        var period = this.value;
        if (period=="") return; // please select - possibly you want something else here
        switch(period){
            case 'lunara': 
                $('#an').hide();
                $('#luna').show();
                break;
            case 'anuala':
                $('#luna').hide();
                $('#an').show();
                break;
            default:
                $('#an').hide();
                $('#luna').hide();
        }
    }); 
});
  });
</script>
</body>
</html>
