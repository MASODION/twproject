<?php

  include 'conn/config.php';
  include 'include/auth_checker.php';
  include 'include/medic_specialist_checker.php';
  if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $check = $conn->prepare("SELECT a.pID,a.pPacient,a.pMedic,a.pConsultatie,a.pDataProgramare,a.pOraProgramare,a.ptimestamp,a.pDurata,a.pAsistenta,a.pStatus,b.userFirstName,b.userLastName,b.userEmail,b.userPhoneNumber,c.cName,c.cPret,c.cDurata,c.cTip FROM programari a INNER JOIN users b ON a.pPacient=b.userID INNER JOIN consultatii c ON a.pConsultatie = c.cID WHERE a.pID = '$id'");
    $check->execute();
    $countlog = $check->rowCount();
    if($countlog > 0)  {
      $programarea = $check->fetch();
      if($programarea['pStatus'] != 1) {
        header("location:programari");
        exit;
      }
      if(isset($_GET['action']) && $_GET['action'] == "finalizeaza") {
        if(isset($_POST['diagnostic'])) {
          $diagnostic = htmlentities($_POST['diagnostic']);
          $medicatie = htmlentities($_POST['medicamente']);
          $pret = $programarea['cPret'];
          $check = $conn->prepare("INSERT INTO rezultate (rProgramare, rResult, rMedicatie, rPret) VALUES ('$id', '$diagnostic', '$medicatie', '$pret')");
          $check->execute();
          $countlog = $check->rowCount();
          if($countlog > 0) {
            $check = $conn->prepare("UPDATE programari SET pStatus = '2' WHERE pID = '$id'");
            $check->execute();
            $check = $conn->prepare("INSERT INTO financiar_log (fProgramareID, fPret) VALUES ('$id', '$pret')");
            $check->execute();
            $mesaj_succes = "programarea a fost finalizata cu succes.";
          }
          else {
            $mesaj_eroare = "ceva nu a mers bine. Incearca mai tarziu!";
          }
        }
      }
    }
    else {
      header("location:programari");
      exit;
    }
  }
  $medic_id = $_SESSION['userID'];
  $check = $conn->prepare("SELECT a.pID,a.pPacient,a.pMedic,a.pConsultatie,a.pDataProgramare,a.pOraProgramare,a.ptimestamp,a.pDurata,a.pAsistenta,a.pStatus,b.userFirstName,b.userLastName,cName FROM programari a INNER JOIN users b ON a.pPacient=b.userID INNER JOIN consultatii c ON a.pConsultatie = c.cID WHERE a.pMedic = '$medic_id' AND c.cTip = 'consultatie' ORDER BY a.pDataProgramare");
    $check->execute();
    $countlog = $check->rowCount();
    if($countlog > 0) {
      $row=$check->fetch();
      while($row!=null){
        $array[]=$row;
        $row=$check->fetch();
      }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Programari</title>

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
    <a href="index" class="brand-link">
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
          <?php if($_SESSION['userLevel'] == 2): ?>
          <li class="nav-item">
          <a href="programari" class="nav-link active">
              <i class="nav-icon fa fa-male"></i>
              <p>
                Programari
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
            <h1 class="m-0 text-dark">Programari</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">Programari</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php if(isset($_GET['action']) && $_GET['action'] == "finalizeaza" && isset($id) && !isset($mesaj_eroare) && !isset($mesaj_succes)): ?>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-6">
              <div class="card">
                <div class="card-header border-0">
                  Informatii programare:
                </div>
                <div class="card-body">
                <p><label>Nume: <?=$programarea['userLastName']?></lavel></p>
                <p style="margin-top:-25px;"><label>Prenume: <?=$programarea['userFirstName']?></lavel></p>
                <p style="margin-top:-25px;"><label>Email: <?=$programarea['userEmail']?></lavel></p>
                <p style="margin-top:-25px;"><label>Numar telefon: <?=$programarea['userPhoneNumber']?></lavel></p>
                <br>
                <p style="margin-top:-25px;"><label>Data: <?=$programarea['pDataProgramare']?></lavel></p>
                <p style="margin-top:-25px;"><label>Ora: <?=$programarea['pOraProgramare']?></lavel></p>
                <br>
                <p style="margin-top:-25px;"><label>Consultatie: <?=$programarea['cName']?></lavel></p>
                <p style="margin-top:-25px;"><label>Pret: <?=$programarea['cPret']?> lei</lavel></p>
                <p style="margin-top:-25px;"><label>Durata: <?=$programarea['cDurata']?></lavel></p>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card">
                <div class="card-header border-0">
                  Finalizeaza programarea:
                </div>
                <div class="card-body">
                  <form action="programari?action=finalizeaza&id=<?=$id?>" method="post">
                  <label>Diagnostic:</label>
                  <div class="input-group mb-3">
          <input type="text" id="diagnostic" name="diagnostic" class="form-control">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-file-medical"></span>
            </div>
          </div>
        </div>
        <label>Medicamente:</label>
        <div class="input-group mb-3">
          <input type="text" id="medicamente" name="medicamente" class="form-control">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-file-medical"></span>
            </div>
          </div>
        </div>

                  <div class="row">
                  <button type="submit" class="btn btn-primary btn-block">Finalizeaza programarea!</button>
                </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
            <div class="col-12">
            <div class="card">
            <div class="card-header border-0">
            Programari
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
                <!-- a.pTipProgramare,a.pDataProgramare,a.pOraProgramare,a.ptimestamp,a.pDurata,a.pAsistenta,b.userFirstName,b.UserLastname -->
                  <th>id</th>
                  <th>Nume</th>
                  <th>Prenume</th>
                  <th>Tip programare</th>
                  <th>Data programare</th>
                  <th>Ora programare</th>
                  <th>Durata programare</th>
                  <th>Timestamp</th>
                  <th>Asistenta</th>
                  <th>Status</th>
                  <th>Actiuni</th>
                </tr>
                </thead>
                <?php if(isset($array)): ?>
                <tbody>
                  <?php foreach($array as $u): ?>
                <tr>
                  <td><?=$u['pID']?>
                  <td><?=$u['userLastName']?></td>
                  <td><?=$u['userFirstName']?></td>
                  <td><?=$u['cName']?></td>
                  <td><?=$u['pDataProgramare']?></td>
                  <td><?=$u['pOraProgramare']?></td>
                  <td><?=$u['pDurata']?></td>
                  <td><?=$u['ptimestamp']?></td>
                  <td><?=$u['pAsistenta']?></td>
                  <td><?php
                        switch ($u['pStatus']) {
                            case 1:
                                echo '<font color="orange">creata</font>';
                                break;
                            case 2:
                                echo '<font color="green">finalizata</font>';
                                break;
                            case 3:
                                echo '<font color="red">anulata</font>';
                                break;
                            default:
                                echo '';
                                break;
                        }
                    ?></td>
                  <td>
                  <?php
                    if($u['pStatus'] == 1) {
                      echo '<a href="programari?action=finalizeaza&id='.$u['pID'].'">Finalizeaza!</a>';
                    }
                  ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                <th>id</th>
                  <th>Nume</th>
                  <th>Prenume</th>
                  <th>Tip programare</th>
                  <th>Data programare</th>
                  <th>Ora programare</th>
                  <th>Durata programare</th>
                  <th>Timestamp</th>
                  <th>Asistenta</th>
                  <th>Status</th>
                  <th>Actiuni</th>
                </tr>
                </tfoot>
                </table>
                <?php endif; ?>
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
      "autoWidth": true,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>
