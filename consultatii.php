<?php

  include 'conn/config.php';
  include 'include/auth_checker.php';
  include 'include/secretara_checker.php';

  if(isset($_GET['action']) && isset($_GET['id'])) {
      $id = intval($_GET['id']);
      if($_GET['action'] == "add"){
        $check = $conn->prepare("SELECT a.cpID, a.cpTipProgramare, a.cpPacient, a.cpDate, a.cpOra, a.cptimestamp, b.userFirstName, b.userLastName, b.userPhoneNumber, b.userEmail, b.userID, s.sID, s.sNume FROM cereri_programari a INNER JOIN users b ON a.cpPacient = b.userID INNER JOIN sectii s ON a.cpSectia = s.sID WHERE cpID = '$id'");
        $check->execute();
        $countlog = $check->rowCount();
        if($countlog > 0) {
          if(isset($_POST['data'])) {
            $cerere = $check->fetch();
            $data = htmlentities($_POST['data']);
            $ora = htmlentities($_POST['ora']);
            $consultatie = htmlentities($_POST['consultatie']);
            $doctor = htmlentities($_POST['doctor']);
            $asistenta = htmlentities($_POST['asistenta']);
            if(!empty($data) && !empty($ora) && !empty($consultatie) && !empty($doctor)) {
              $pozitie_pct = strpos($doctor, ".");
              $id_doctor = intval(substr($doctor, 0, $pozitie_pct));
              $id_pacient = $cerere['userID'];
              $check = $conn->prepare("SELECT cID, cDurata FROM consultatii WHERE cName = '$consultatie'");
              $check->execute();
              $countlog = $check->rowCount();
              if($countlog > 0) {
                $row = $check->fetch();
                $id_consultatie = $row['cID'];
                $durata_consultatie = $row['cDurata'];
                $check = $conn->prepare("INSERT INTO programari (pPacient, pMedic, pConsultatie, pDataProgramare, pOraProgramare, pDurata, pAsistenta) VALUES ('$id_pacient', '$id_doctor', '$id_consultatie', '$data', '$ora', '$durata_consultatie', '$asistenta')");
                $check->execute();
                $countlog = $check->rowCount();
                if($countlog > 0) {
                  $check = $conn->prepare("DELETE FROM cereri_programari WHERE cpID = '$id'");
                  $check->execute();
                  $mesaj_succes_cp = "programarea a fost facuta.";
                }
                else {
                  $mesaj_eroare_cp = "ceva nu a mers bine. Incearca mai tarziu";
                }
              }
            } 
            else {
              $mesaj_eroare_cp = "invalid input";
            }
          }
          else {
            $cerere = $check->fetch();
          }
        }
        else {
          header("location:consultatii");
          exit;
        }
      }
      elseif($_GET['action'] == "delete"){
        $check = $conn->prepare("SELECT cpID FROM cereri_programari WHERE cpID = '$id'");
        $check->execute();
        $countlog = $check->rowCount();
        if($countlog > 0) {
          $check = $conn->prepare("DELETE FROM cereri_programari WHERE cpID = '$id'");
          $check->execute();
          $countlog = $check->rowCount();
          if($countlog > 0) {
            $mesaj_succes_cp = "cererea a fost stearsa cu succes.";
          }
          else {
            $mesaj_eroare_cp = "ceva nu a mers bine. Incearca mai tarziu!";
          }
        }
        else {
          header("location:consultatii");
          exit;
        }
      }
      elseif($_GET['action'] == "cancel") {
        $check = $conn->prepare("SELECT pStatus, pID FROM programari WHERE pID = '$id'");
        $check->execute();
        $countlog = $check->rowCount();
        if($countlog > 0) {
          $row = $check->fetch();
          if($row['pStatus'] != 1) {
            header("location:consultatii");
            exit;
          }
          $check = $conn->prepare("UPDATE programari SET pStatus = '3' WHERE pID = '$id'");
          $check->execute();
          $countlog = $check->rowCount();
          if($countlog > 0) {
            $mesaj_succes_p = "programarea a fost anulata.";
          }
          else {
            $mesaj_eroare_p = "ceva nu a mers bine. Incearca mai tarziu!";
          }
        }
        else {
          header("location:consultatii");
          exit;
        }
      }
  }

  $check = $conn->prepare("SELECT a.cpID, a.cpTipProgramare, a.cpPacient, a.cpDate, a.cpOra, a.cptimestamp, b.userFirstName, b.userLastName, b.userPhoneNumber, s.sNume FROM cereri_programari a INNER JOIN users b ON a.cpPacient = b.userID INNER JOIN sectii s ON a.cpSectia = s.sID ORDER BY a.cptimestamp DESC");
  $check->execute();
  $countlog = $check->rowCount();
  if($countlog > 0) {
    $row = $check->fetch();
    while($row != NULL) {
      $cereri_programari[] = $row;
      $row = $check->fetch();
    }
  }

  $check = $conn->prepare("SELECT a.pID, a.pPacient, a.pMedic, a.pConsultatie, a.pDataProgramare, a.pOraProgramare, a.ptimestamp, a.pDurata, a.pAsistenta, a.pStatus, b.userFirstName as pacient_prenume, b.userLastName as pacient_nume, c.userFirstName as doctor_prenume, c.userLastName as doctor_nume, d.cName, d.cSectie, e.sNume FROM programari a INNER JOIN users b ON a.pPacient = b.userID INNER JOIN users c ON a.pMedic = c.userID INNER JOIN consultatii d ON a.pConsultatie = d.cID INNER JOIN sectii e ON d.cSectie = e.sID ORDER BY a.pStatus ASC, a.ptimestamp DESC");
  $check->execute();
  $countlog = $check->rowCount();
  if($countlog > 0) {
      $row = $check->fetch();
      while($row != NULL) {
          $programari[] = $row;
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

  <title>Consultatii</title>

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
          <a href="consultatii" class="nav-link active">
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
            <h1 class="m-0 text-dark">Consultatii</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">Consultatii</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php if(isset($id) && isset($_GET['action']) && $_GET['action'] == "add" && !isset($mesaj_eroare_cp) && !isset($mesaj_succes_cp)): ?>

      <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <div class="card">
              <div class="card-header border-0">
                Informatii cerere:
              </div>
              <div class="card-body">
              <p><label>Nume: <?=$cerere['userLastName']?></lavel></p>
              <p style="margin-top:-25px;"><label>Prenume: <?=$cerere['userFirstName']?></lavel></p>
              <p style="margin-top:-25px;"><label>Email: <?=$cerere['userEmail']?></lavel></p>
              <p style="margin-top:-25px;"><label>Numar telefon: <?=$cerere['userPhoneNumber']?></lavel></p>
              <br>
              <p style="margin-top:-25px;"><label>Tip programare: <?=$cerere['cpTipProgramare']?></lavel></p>
              <p style="margin-top:-25px;"><label>Sectia: <?=$cerere['sNume']?></lavel></p>
            </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card">
              <div class="card-header border-0">
                Informatii programare:
              </div>
              <div class="card-body">
              <?php 
                  if(isset($mesaj_eroare_p)) {
                    echo '<font color="red">* '. $mesaj_eroare_p. '</font>';
                  }
                  elseif(isset($mesaj_succes_p)) {
                    echo '<font color="green">* ' . $mesaj_succes_p .'</font>';
                  }
                  $sectia = $cerere['sID'];
                  $tip_consultatie = $cerere['cpTipProgramare'];
                  $check = $conn->prepare("SELECT cName FROM consultatii WHERE cSectie = '$sectia' AND cTip = '$tip_consultatie'");
                  $check->execute();
                  $countlog = $check->rowCount();
                  if($countlog > 0) {
                    $row = $check->fetch();
                    while($row != NULL) {
                      $consultatii[] = $row;
                      $row = $check->fetch();
                    }
                  }
                  $check = $conn->prepare("SELECT userID, userFirstName, userLastName FROM users WHERE userType = '2' AND userSection = '$sectia' ORDER BY userID ASC");
                  $check->execute();
                  $countlog = $check->rowCount();
                  if($countlog > 0) {
                    $row = $check->fetch();
                    while($row != NULL) {
                      $doctorii[] = $row;
                      $row = $check->fetch();
                    }
                  }
                ?>
              <form action="consultatii?action=add&id=<?=$id?>" method="post">
                  <label>Data:</label>
                  <div class="input-group mb-3">
          <input type="date" id="data" name="data" class="form-control" value="<?=$cerere['cpDate']?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-calendar"></span>
            </div>
          </div>
        </div>
        <label>Ora:</label>
                  <div class="input-group mb-3">
          <input type="text" id="ora" name="ora" class="form-control" value="<?=$cerere['cpOra']?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-calendar"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
        <label>Consultatie / interventie: </label>
        <select name="consultatie" class="form-control select2" style="width: 100%;">
                  <?php foreach($consultatii as $s): ?>
                    <option><?=$s['cName']?></option>
                  <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
        <label>Doctor: </label>
        <select name="doctor" class="form-control select2" style="width: 100%;">
                  <?php foreach($doctorii as $s): ?>
                    <option><?=$s['userID']?>. <?=$s['userLastName']?> <?=$s['userFirstName']?></option>
                  <?php endforeach; ?>
                  </select>
                </div>
                <label>Asistenta (optional):</label>
                  <div class="input-group mb-3">
          <input type="text" id="asistenta" name="asistenta" class="form-control">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-users"></span>
            </div>
          </div>
        </div>
                <div class="row">
                  <button type="submit" class="btn btn-primary btn-block">Confirma programarea!</button>
                </div>

              </form>
            </div>
          </div>
          
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <?php else: ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="card-header border-0">
                Cereri programari
              </div>
              <div class="card-body">
              <?php 
                  if(isset($mesaj_eroare_cp)) {
                    echo '<font color="red">* '. $mesaj_eroare_cp. '</font>';
                  }
                  elseif(isset($mesaj_succes_cp)) {
                    echo '<font color="green">* ' . $mesaj_succes_cp .'</font>';
                  }
                ?>
            <table id="example1" class="table table-bordered table-striped">
                  <thead>
                <tr>
                  <th>id</th>
                  <th>Nume</th>
                  <th>Prenume</th>
                  <th>Tip</th>
                  <th>Creata</th>
                  <th>Data</th>
                  <th>Ora</th>
                  <th>Sectia</th>
                  <th>Action</th>
                </tr>
                </thead>
                <?php if(isset($cereri_programari)): ?>
                <tbody>
                  <?php foreach($cereri_programari as $u): ?>
                <tr>
                  <td><?=$u['cpID']?></td>
                  <td><?=$u['userLastName']?></td>
                  <td><?=$u['userFirstName']?></td>
                  <td><?=$u['cpTipProgramare']?></td>
                  <td><?=$u['cptimestamp']?></td>
                  <td><?=$u['cpDate']?></td>
                  <td><?=$u['cpOra']?></td>
                  <td><?=$u['sNume']?></td>
                  <td><a href="consultatii?action=add&id=<?=$u['cpID']?>">Adauga</a> | <a href="consultatii?action=delete&id=<?=$u['cpID']?>"><font color="red">Sterge</font></a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <?php endif; ?>
                <tfoot>
                <tr>
                <th>id</th>
                  <th>Nume</th>
                  <th>Prenume</th>
                  <th>Tip</th>
                  <th>Creata</th>
                  <th>Data</th>
                  <th>Ora</th>
                  <th>Sectia</th>
                  <th>Action</th>
                </tr>
                </tfoot>
                </table>
                  </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card">
            <div class="card-header border-0">
                Programari
              </div>
              <div class="card-body">
              <?php 
                  if(isset($mesaj_eroare_p)) {
                    echo '<font color="red">* '. $mesaj_eroare_p. '</font>';
                  }
                  elseif(isset($mesaj_succes_p)) {
                    echo '<font color="green">* ' . $mesaj_succes_p .'</font>';
                  }
                ?>
            <table id="example2" class="table table-bordered table-striped">
                  <thead>
                <tr>
                  <th>id</th>
                  <th>Nume pacient</th>
                  <th>Nume doctor</th>
                  <th>Consultatie / Interventie</th>
                  <th>Sectia</th>
                  <th>Creata</th>
                  <th>Data</th>
                  <th>Ora</th>
                  <th>Durata</th>
                  <th>Asistenta</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <?php if(isset($programari)): ?>
                <tbody>
                  <?php foreach($programari as $u): ?>
                <tr>
                  <td><?=$u['pID']?></td>
                  <td><?=$u['pacient_prenume']?> <?=$u['pacient_nume']?></td>
                  <td><?=$u['doctor_prenume']?> <?=$u['doctor_nume']?></td>
                  <td><?=$u['cName']?></td>
                  <td><?=$u['sNume']?></td>
                  <td><?=$u['ptimestamp']?></td>
                  <td><?=$u['pDataProgramare']?></td>
                  <td><?=$u['pOraProgramare']?></td>
                  <td><?=$u['pDurata']?></td>
                  <td><?=$u['pAsistenta']?></td>
                  <td>
                    <?php
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
                    ?>

                  </td>
                  <td><?php if($u['pStatus'] == 1) { echo '<a href="consultatii?action=cancel&id='.$u['pID'].'">Anuleaza!</a>'; } ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <?php endif; ?>
                <tfoot>
                <tr>
                <th>id</th>
                  <th>Nume pacient</th>
                  <th>Nume doctor</th>
                  <th>Consultatie / Interventie</th>
                  <th>Sectia</th>
                  <th>Creata</th>
                  <th>Data</th>
                  <th>Ora</th>
                  <th>Durata</th>
                  <th>Asistenta</th>
                  <th>Status</th>
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
