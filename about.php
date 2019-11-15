<?php

  include 'conn/config.php';
  include 'classes/db.php';

  $currpg = "about";

  if(isset($_GET['lang']) && !empty($_GET['lang'])) {
    $id = $_GET['lang'];
    if($id == "eng") {
      $_SESSION['lang'] = "eng";
    }
    else $_SESSION['lang'] = "ro";
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
  <title><?=Functions::trimitemesaj("Despre", "About")?></title>

  <link rel="stylesheet" href="assets/css/atlantis.min.css">
  <link href = "/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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

        /* sel`ec`ted link */
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
          <li class="nav-item active">
            <a class="nav-link" href="about"><?=Functions::trimitemesaj("Despre", "About")?></a>
          </li>
          <li class="nav-item">
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
<center>Aici o sa fie un banner de tip reclama</center>
</div>
</div>
</div>
          <div class="col-md-8 col-md-offset-4">

              <div class="card">
                  <div class="card-body">
                      <h4><b><font color="#0044b3">Gabriela Micu</font></b></h4>
                        <p class="text-muted small"><font style="font-family:Times New Roman;font-size:18px">Numele meu este Gabriela Micu. Am lucrat timp de 18 ani in corporatii, in domeniul resurselor umane. Mi-a placut jobul, in marea majoritate a timpului, si mi-au placut mult oamenii cu care m-am intalnit. Pe vremea aceea nu credeam ca voi ajunge vreodata sa fac si altceva.
                        Insa stisi cum se intampla cateodata sa dai peste ceva, o informatie, o carte, o poza care simti ca te atrage inexplicabil?... Asa am patit si eu. M-am dus de curiozitate la un seminar despre regresii in vieti anterioare, in anul 2016, iar subiectul s-a transformat, incet- incet, intr-o pasiune. O pasiune care m-a convins sa las deoparte corporatiile.
                        Am urmat apoi o certificare in <b>hipnoza eriksoniana</b>, dupa care o certificare in terapia prin regresie. Sunt membru <b>EARTH</b> (European Association for Regression Therapy) si membru fondator al <b>AHTR</b> - Asociatia de Hipnoza si Terapie prin Regresie.
                        Lucrez cu clientii din anul 2016 si ma simt onorata ca pot sa asist la minunatele calatorii de descoperire personala ale fiecaruia dintre ei.</font></p>
                      <br><br>
                      <h4><b><font color="#0044b3">Ce este hipnoza si ce poate adresa?</font></b></h4>
                      <p class="text-muted small"><font style="font-family:Times New Roman;font-size:18px"><b>Hipnoza regresiva</b> este o abordare terapeutica, cu ajutorul careia putem accesa informatii inaccesibile mintii constiente, in scopul constientizarii si integrarii lor. In acest proces hipnoza functioneaza ca o "poarta de intrare" catre anumite amintiri sau imagini aduse de inconstient, asigurand totodata starea necesara de concentrare interioara pe durata sedintei.</font></p>
                      <p class="text-muted small"><font style="font-family:Times New Roman;font-size:18px"><b>Regresia</b> este o calatorie in trecut: cel al vietii actuale, perioada intra-uterina sau chiar vietile anterioare (pentru cei care cred in acest concept). Procesul functioneaza insa in egala masura si pentru cei care nu cred in reincarnare, inconstientul aducand la suprafata imagini sau povesti cu rol de vindecare.
                      Iata cateva dintre aspectele care pot fi adresate cu ajutorul hipnozei regresive:
                      <ul class="text-muted small">
                      <li>probleme emotionale care ne coplesesc sau ne consuma: frica, manie, rusine, vina, tristete, etc;</li>
                      <li>gestionarea emotiilor legate de pierderea persoanelor dragi;</li>
                      <li>anxietate sau atacuri de panica;</li>
                      <li>ganduri perturbatoare;</li>
                      <li>cosmaruri repetitive;</li>
                      <li>probleme pe care le avem in relatiile cu ceilalti, acasa sau in viata profesionala;</li>
                      <li>fobii sau obsesii;</li>
                      <li>dificultati in gestionarea stresului;</li>
                      <li>simptome fizice inexplicabile, verificate medical, insa fara diagnostic clar.</li>
                      
                      </ul>
                      </font></p>
                    </div>
                </div>
        
          </div>
          <div class="col-md-4 col-md-offset-3">


              <div class="card">
                  <div class="card-body">
                      <center>
                          <p class="text-muted small2"><font color="#0044b3" style="font-size:18px"><?=Functions::trimitemesaj("Linkuri utile:", "Utile links:")?></font></p>
                    <!--<a href="https://www.earth-association.org/"><button class="btn btn-info btn-test">Earth association</button></a>
                    <a href="https://www.regressionacademy.com/"><button class="btn btn-info">Regression Academy</button></a></p></center>-->
                    <a href="https://www.earth-association.org/" class="linkumeu">earth-association.org</a>
                    <a href="https://www.regressionacademy.com/" class="linkumeu">regressionacademy.com</a></p></center>
                    
                    
                  </div>
              </div>

          </div>

      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <<footer class="py-3 bg-dark">
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

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


</body>

</html>

<!--<?=Functions::trimitemesaj("", "")?>-->