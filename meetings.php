<?php

  include 'conn/config.php';
  include 'classes/db.php';

  $currpg = "meetings";

  if(isset($_GET['lang']) && !empty($_GET['lang'])) {
    $id = $_GET['lang'];
    if($id == "eng") {
      $_SESSION['lang'] = "eng";
    }
    else $_SESSION['lang'] = "ro";
  }

  if(isset($_POST['nume']) && isset($_POST['prenume']) && isset($_POST['email']) && isset($_POST['nr_tel']) && isset($_POST['date']) && isset($_GET['type'])) {
    $type = $_GET['type'];
    $date = htmlentities($_POST['date']);
    $date = format($date, 'd/m/Y H:i:s');
    $nume = htmlentities($_POST['nume']);
    $prenume = htmlentities($_POST['prenume']);
    $email = htmlentities($_POST['email']);
    $nr_tel = htmlentities($_POST['nr_tel']); 

    $check = $conn->prepare("INSERT INTO meetings (nume, prenume, email, nr_tel, date, type) VALUES ('$nume', '$prenume', '$email', '$nr_tel', '$date', '$type') ");
    $check->execute();

    //mail

    switch($_GET['type']) {
      case 1:
        $nume_sedinta = 'Regresii in viata curenta, vieti anterioare';
        break;
      case 2:
        $nume_sedinta = 'Regresie in viata dintre vieti';
        break;
      case 3:
        $nume_sedinta = 'Regresie by proxy';
        break;
      case 4:
        $nume_sedinta = 'Hipnoza eriksoniana';
        break;
      case 5:
        $nume_sedinta = 'Dezvoltare personala';
        break;
      case 6:
        $nume_sedinta = 'Sedinta la distanta';
        break;
    }

    $to = 'liviumarian56@gmail.com';
    $subject = 'Sedinte individuale';
    $message = $nume . ' ' . $prenume. ' vrea sa cumpere o sedinta individuala de tipul \'' . $nume_sedinta . '\', pe data de ' . $date . '.\n';
    $message = $message . '\n\nDate contact:\n';
    $message = $message . 'Email: ' . $email . '\n';
    $message = $message . 'Numar telefon: ' . $nr_tel . '\n';
    mail($to, $subject, $message);

  }
  elseif (isset($_GET['type'])) {
    echo '<head><meta http-equiv=\"refresh\" content=\"0;url=' . $currpg . '\"/></head>';
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <?php if(isset($_GET['lang']) && !empty($_GET['lang'])): ?>
    <meta http-equiv="refresh" content="0;url=<?=$currpg?>" />
  <?php endif;?>
  <title><?=Functions::trimitemesaj("Sedinte individuale", "Individual meetings")?></title>

  <link rel="stylesheet" href="assets/css/atlantis.min.css">
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href = "/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-home.css" rel="stylesheet">

    <style>
    
        p.small {
            line-height: 1.1;
        }
        
        p.small2 {
            line-height: 0.2;
        }
        
        .btn-test {
            margin-bottom: 5px;    
        }
        
        p.big {
            line-height: 1.8;
        }
        
        ul.small {
            line-height: 1.1;    
            
        }
        
        a.linkumeu:link {
            color: red;
        }

        /* visited link */
        a.linkumeu:visited {
            color: green;
        }

        /* mouse over link */
        a.linkumeu:hover {
            color: hotpink;
        }

        /* selected link */
        a.linkumeu:active {
            color: blue;
        }
        
        .baramea {
            
            background:transparent;
        }
        
    </style>

</head>

<body style="background-image: url('img/background.jpg');background-repeat: no-repeat;background-position: center;background-size: cover;">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top baramea">
    <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index"><?=Functions::trimitemesaj("Acasa", "Home")?>
            <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about"><?=Functions::trimitemesaj("Despre", "About")?></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="meetings"><?=Functions::trimitemesaj("Sedinte individuale", "Individual meetings")?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="online"><?=Functions::trimitemesaj("Programe on-line", "On-line programs")?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="events"><?=Functions::trimitemesaj("Seminarii si evenimente", "Seminars and events")?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="blog">Blog</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=Functions::trimitemesaj("Limba", "Language")?></a>
              <div class="dropdown-menu" aria-labelledby="dropdown06">
                <a class="dropdown-item" href="<?=$currpg?>?lang=ro">RO</a>
                <a class="dropdown-item" href="<?=$currpg?>?lang=eng">ENG</a>
              </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">
        <div class="col-md-12 col-md-offset-4">
        <div class="card">
                  <div class="card-body">
                  <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal"><b><font color="#11C7FD">Regresii in viata curenta, vieti anterioare</font></b></h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title"><b><font color="#11C7FD">xxx RON</font></b> <small class="text-muted"><b><font color="#11C7FD">/ sedinta</font></b></small></h1>
            <ul style="text-align:left">
              <li>Durata unei sedinte este de 2 - 3 ore.</li>
              <li>In functie de complexitatea aspectelor pe care lucram, pot fi necesare mai multe sedinte.</li>
              <li>De regula sedintele se programeaza la o distanta de 10 zile - 2 saptamani.</li>
            </ul>
          </div>
          <div class="card-footer">
              <button type="button" class="btn btn-lg btn-block btn-primary" data-toggle="modal" data-target="#regresievc"><?=Functions::trimitemesaj("Cumpara!", "Buy it!")?></button>
          </div>
        </div>
                <!-- The Modal -->
<div class="modal fade" id="regresievc">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"><?=Functions::trimitemesaj("Rezerva pachet \"Regresii in viata curenta, vieti anterioare\"", "Book pachet \"Regressions in your current life, in your past lifes\"")?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form action="meetings?type=1" method="post">
          	<p><input type="text" name="nume" placeholder="<?=Functions::trimitemesaj("Nume", "First name")?>"></input></p>
            <p><input type="text" name="prenume" placeholder="<?=Functions::trimitemesaj("Prenume", "Last name")?>"></input></p>
            <p><input type="text" name="email" placeholder="<?=Functions::trimitemesaj("Email", "Email")?>"></input></p>
            <p><input type="text" name="nr_tel" placeholder="<?=Functions::trimitemesaj("Numar de telefon", "Phone number")?>"></input></p>
            <p><?=Functions::trimitemesaj("Data cand doriti sa veniti la cabinet:", "Date when you'll arrive at the cabinet:")?></p>
            <p><input type="date" name="date"></input></p>
            <input type="submit" class="form-submit" value="<?=Functions::trimitemesaj("Rezerva!", "Book it!")?>"></input>	
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal"><b><font color="#11C7FD">Regresie in viata dintre vieti</font></b></h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title"><b><font color="#11C7FD">xxx RON</font></b> <small class="text-muted"><b><font color="#11C7FD">/ sedinta</font></b></small></h1>
            <ul style="text-align:left">
              <li>Durata unei sedinte este de 4 ore.</li>
              <li>Pentru acest tip de regresie, este necesar ca beneficiarul sa fi facut anterior minimum o sedinta de regresie in vieti anterioare.</li>
              <li>Este un tip special de regresie, in care vizitam perioada dintre doua reincarnari, acolo unde sufletul isi revizuieste misiunea vietii curente, lectia cu care a venit, familia de suflete si contractele cu acestia, etc.</li>
            </ul>
          </div>
          <div class="card-footer">
              <button type="button" class="btn btn-lg btn-block btn-primary" data-toggle="modal" data-target="#regresievv"><?=Functions::trimitemesaj("Cumpara!", "Buy it!")?></button>
          </div>
        </div>
                <!-- The Modal -->
<div class="modal fade" id="regresievv">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Cumpara pachet "Regresie in viata dintre vieti"</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form action="meetings?type=2" method="post">
          	<p><input type="text" name="nume" placeholder="<?=Functions::trimitemesaj("Nume", "First name")?>"></input></p>
            <p><input type="text" name="prenume" placeholder="<?=Functions::trimitemesaj("Prenume", "Last name")?>"></input></p>
            <p><input type="text" name="email" placeholder="<?=Functions::trimitemesaj("Email", "Email")?>"></input></p>
            <p><input type="text" name="nr_tel" placeholder="<?=Functions::trimitemesaj("Numar de telefon", "Phone number")?>"></input></p>
            <p><?=Functions::trimitemesaj("Data cand doriti sa veniti la cabinet:", "Date when you'll arrive at the cabinet:")?></p>
            <p><input type="date" name="date"></input></p>
            <input type="submit" class="form-submit" value="<?=Functions::trimitemesaj("Rezerva!", "Book it!")?>"></input>	
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal"><b><font color="#11C7FD">Regresie by proxy</font></b></h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title"><b><font color="#11C7FD">xxx RON</font></b> <small class="text-muted"><b><font color="#11C7FD">/ sedinta</font></b></small></h1>
            <ul style="text-align:left">
              <li>Durata unei sedinte este de 2 ore.</li>
              <li>Terapeutul lucreaza cu un "imputernicit" al beneficiarului, in general o ruda de gradul 1, acesta sustinand regresia in numele beneficiarului.</li>
              <li>Este un tip special de sedinta in care se lucreaza cu beneficiarul la distanta.</li>
              <li>Se foloseste in cazul copiilor foarte mici sau persoanelor care se afla in incapacitatea de a sustine procesul terapeutic (grav bolnave, aflate in coma, boli terminale, etc).</li>
            </ul>
          </div>
          <div class="card-footer">
              <button type="button" class="btn btn-lg btn-block btn-primary" data-toggle="modal" data-target="#regresiep"><?=Functions::trimitemesaj("Cumpara!", "Buy it!")?></button>
          </div>
        </div>
                <!-- The Modal -->
<div class="modal fade" id="regresiep">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Cumpara pachet "Regresie by proxy"</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form action="meetings?type=3" method="post">
          	<p><input type="text" name="nume" placeholder="<?=Functions::trimitemesaj("Nume", "First name")?>"></input></p>
            <p><input type="text" name="prenume" placeholder="<?=Functions::trimitemesaj("Prenume", "Last name")?>"></input></p>
            <p><input type="text" name="email" placeholder="<?=Functions::trimitemesaj("Email", "Email")?>"></input></p>
            <p><input type="text" name="nr_tel" placeholder="<?=Functions::trimitemesaj("Numar de telefon", "Phone number")?>"></input></p>
            <p><?=Functions::trimitemesaj("Data cand doriti sa veniti la cabinet:", "Date when you'll arrive at the cabinet:")?></p>
            <p><input type="date" name="date"></input></p>
            <input type="submit" class="form-submit" value="<?=Functions::trimitemesaj("Rezerva!", "Book it!")?>"></input>	
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  </div>
        <div class="card-deck mb-3 text-center">

        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal"><b><font color="#11C7FD"><?=Functions::trimitemesaj("Hipnoza eriksoniana","Ericksonian hypnosis")?></font></b></h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title"><b><font color="#11C7FD">xxx RON</font></b> <small class="text-muted"><b><font color="#11C7FD">/ <?=Functions::trimitemesaj("sedinta", "meeting")?></font></b></small></h1>
            <ul style="text-align:left">
              <li><?=Functions::trimitemesaj("Durata unei sedinte este de o ora.", "Duration of this type of meeting is 1 hour.")?></li>
              <li><?=Functions::trimitemesaj("Se recomanda 5-6 sedinte pentru fiecare aspect adresat.", "It's recomanded 5-6 meetings for every aspect mentioned.")?></li>
              <li><?=Functions::trimitemesaj("In general, sedintele se programeaza cu frecventa saptamanala.", "In general, there's one meeting every week.")?></li>
            </ul>
            </div>
            <div class="card-footer">
              <button type="button" class="btn btn-lg btn-block btn-primary" data-toggle="modal" data-target="#eriksoniana"><?=Functions::trimitemesaj("Cumpara!", "Buy it!")?></button>
          </div>
        </div>
        <!-- The Modal -->
<div class="modal fade" id="eriksoniana">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"><?=Functions::trimitemesaj("Cumpara pachet \"Hipnoza Eriksoniana\"", "Buy this package.")?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form action="meetings?type=4" method="post">
          	<p><input type="text" name="nume" placeholder="<?=Functions::trimitemesaj("Nume", "First name")?>"></input></p>
            <p><input type="text" name="prenume" placeholder="<?=Functions::trimitemesaj("Prenume", "Last name")?>"></input></p>
            <p><input type="text" name="email" placeholder="<?=Functions::trimitemesaj("Email", "Email")?>"></input></p>
            <p><input type="text" name="nr_tel" placeholder="<?=Functions::trimitemesaj("Numar de telefon", "Phone number")?>"></input></p>
            <p><?=Functions::trimitemesaj("Data cand doriti sa veniti la cabinet:", "Date when you'll arrive at the cabinet:")?></p>
            <p><input type="date" name="date"></input></p>
            <input type="submit" class="form-submit" value="<?=Functions::trimitemesaj("Rezerva!", "Book it!")?>"></input>	
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal"><?=Functions::trimitemesaj("Inchide", "Close")?></button>
        </div>
        
      </div>
    </div>
  </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal"><b><font color="#11C7FD"><?=Functions::trimitemesaj("Dezvoltare personala", "Personal development")?></font></b></h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title"><b><font color="#11C7FD">xxx RON</font></b> <small class="text-muted"><b><font color="#11C7FD">/ sedinta</font></b></small></h1>
            <ul class="list-unstyled mt-3 mb-4">
            </ul>
          </div>
          <div class="card-footer">
              <button type="button" class="btn btn-lg btn-block btn-primary"data-toggle="modal" data-target="#dezvoltarep"><?=Functions::trimitemesaj("Cumpara!", "Buy it!")?></button>
          </div>
        </div>
<!-- The Modal -->
<div class="modal fade" id="dezvoltarep">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Cumpara pachet "Dezvoltare personala"</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form action="meetings?type=5" method="post">
          	<p><input type="text" name="nume" placeholder="<?=Functions::trimitemesaj("Nume", "First name")?>"></input></p>
            <p><input type="text" name="prenume" placeholder="<?=Functions::trimitemesaj("Prenume", "Last name")?>"></input></p>
            <p><input type="text" name="email" placeholder="<?=Functions::trimitemesaj("Email", "Email")?>"></input></p>
            <p><input type="text" name="nr_tel" placeholder="<?=Functions::trimitemesaj("Numar de telefon", "Phone number")?>"></input></p>
            <p><?=Functions::trimitemesaj("Data cand doriti sa veniti la cabinet:", "Date when you'll arrive at the cabinet:")?></p>
            <p><input type="date" name="date"></input></p>
            <input type="submit" class="form-submit" value="<?=Functions::trimitemesaj("Rezerva!", "Book it!")?>"></input>	
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal"><b><font color="#11C7FD">Sedinta la distanta</font></b></h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title"><b><font color="#11C7FD">xxx RON</font></b> <small class="text-muted"><b><font color="#11C7FD">/ sedinta</font></b></small></h1>
            <ul style="text-align:left">
              <li>Pentru oricare dintre tipurile de sedinte, cu exceptia celei de regresie in viata dintre vieti, poate fi programata la distanta, prin intermediul Skype / Zoom.</li>
              <li>Pentru confirmarea programarii, este necesara plata sedintei in avans.</li>
            </ul>
          </div>
          <div class="card-footer">
              <button type="button" class="btn btn-lg btn-block btn-primary" data-toggle="modal" data-target="#sdistanta"><?=Functions::trimitemesaj("Cumpara!", "Buy it!")?></button>
          </div>
        </div>
        <!-- The Modal -->
<div class="modal fade" id="sdistanta">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Cumpara pachet "Sedinta la distanta"</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form action="meetings?type=6" method="post">
          	<p><input type="text" name="nume" placeholder="<?=Functions::trimitemesaj("Nume", "First name")?>"></input></p>
            <p><input type="text" name="prenume" placeholder="<?=Functions::trimitemesaj("Prenume", "Last name")?>"></input></p>
            <p><input type="text" name="email" placeholder="<?=Functions::trimitemesaj("Email", "Email")?>"></input></p>
            <p><input type="text" name="nr_tel" placeholder="<?=Functions::trimitemesaj("Numar de telefon", "Phone number")?>"></input></p>
            <p><?=Functions::trimitemesaj("Data cand doriti sa veniti la cabinet:", "Date when you'll arrive at the cabinet:")?></p>
            <p><input type="date" name="date"></input></p>
            <input type="submit" class="form-submit" value="<?=Functions::trimitemesaj("Rezerva!", "Book it!")?>"></input>	
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
        
        </div>
      </div>
        </div>
        </div>
        </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-3 bg-dark">
    <div class="container">
          <div class="row">
          <div class="col-md-6 mt-md-0 mt-3">
            <h6 class="text-uppercase"><font color="white"><i class="fa fa-thumb-tack"></i> Contact</font></h6>
            <p style="margin:0px"><a href ="#" style="color:grey;"><font size="3px"><i class="fa fa-map-marker"> Str x, nr 13</font></a></i></p>  
            <p style="margin:0px"><a href ="#" style="color:grey;"><font size="3px"><i class="fa fa-envelope-o"> gabriela.micu@gmail.com</font></a></i></p>  
            <p style="margin:0px"><a href ="#" style="color:grey;"><font size="3px"><i class="fa fa-phone"> 0721 220 933</font></a></i></p>  
            
          </div>
            <hr class="clearfix w-100 d-md-none pb-3">
            <div class="col-md-3 mb-md-0 mb-3">
            <h6 class="text-uppercase"><font color="white"><i class="fa fa-user"></i> Social Media</font></h6>
            <p style="margin:0px"><a href ="https://www.facebook.com/regresii.timisoara/" style="color:whiteblue;"><font size="3px"><i class="fa fa-facebook-square"> Hipnoza Regresiva in Timisoara</font></a></i></p>  
            <p style="margin:0px"><a href ="#" style="color:pink;"><font size="3px"><i class="fa fa-instagram"> Instagram</font></a></i></p>  
            
            </div>
            <hr class="clearfix w-100 d-md-none pb-3">
            <div class="col-md-3 mb-md-0 mb-3">
            <h6 class="text-uppercase"><font color="white"><i class="fa fa-info"></i> FAQ </font></h6>
            <p style="margin:0px"><a href ="#" style="color:grey;"><font size="3px"><i class="fa fa-angle-right"> Politica de confidentialitate</font></a></i></p>  
            <p style="margin:0px"><a href ="#" style="color:grey;"><font size="3px"><i class="fa fa-angle-right"> Politica utilizare cookie-uri</font></a></i></p>  
            
            </div>
      </div>
      </div>
    <div class="container">
    <!--<p class="m-0 text-center text-white">Copyright &copy; <a href =""> Masodion </a> 2019.</p>-->
    </div>
    <!-- /.container -->
  </footer>


<script async src="https://static.addtoany.com/menu/page.js"></script>
<script type="text/javascript">
        $(function () {
            $('#datetimepicker9').datetimepicker({
                viewMode: 'years'
            });
        });
    </script>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


</body>

</html>

<!--<?=Functions::trimitemesaj("", "")?>-->