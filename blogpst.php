<?php 

  include 'conn/config.php';
  include 'classes/db.php';

  if((!isset($_GET['idpost']) || empty($_GET['idpost'])) && (!isset($_GET['lang']) || empty($_GET['lang']))) {
    header('Location: /blog');
    exit;
  }

  $id = $_GET['idpost'];
  if($id < 0) {
    header("location: /blog");
    exit;
  }
  $check = $conn->prepare("SELECT * FROM blog WHERE bID = '$id'");
  $check->execute();
  $countlog = $check->rowCount();
  if($countlog >= 1) {
    $row = $check->fetch();
  }
  else {
    header("location:/blog");
    exit;
  }

  $currpg = "blog";

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta property="fb:app_id" content="{307392000174572}" />
  <meta property="fb:admins" content="{100001014945658}"/>
  <meta property="og:site_name" content="gabrielamicu"/>
  <meta property="og:url" content="https://gabrielamicu.com/blogpst/<?=$id?>"/>

  <title><?=Functions::trimitemesaj($row['bTitle'], $row['bETitle'])?></title>

  <!-- Bootstrap core CSS -->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="/css/blog-post.css" rel="stylesheet">
  <link href = "/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/index"><?=Functions::trimitemesaj("Acasa", "Home")?>
            <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
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
          <li class="nav-item active">
            <a class="nav-link" href="blog">Blog</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=Functions::trimitemesaj("Limba", "Language")?></a>
              <div class="dropdown-menu" aria-labelledby="dropdown06">
                <a class="dropdown-item" href="/<?=$currpg?>?lang=ro">RO</a>
                <a class="dropdown-item" href="/<?=$currpg?>?lang=eng">ENG</a>
              </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-12">

        <!-- Title -->
        <h1 class="mt-4"><?=Functions::trimitemesaj($row['bTitle'], $row['bETitle'])?></h1>

        <hr>

        <!-- Date/Time -->
        <p><?=Functions::trimitemesaj("Postat pe data de", "Posted on")?> <?=$row['bDate']?></p>

        <hr>

        <!-- Preview Image -->
        <img class="img-fluid rounded" src="<?=$row['bImage']?>" alt="">

        <hr>

        <!-- Post Content -->
        <?php echo Functions::trimitemesaj($row['bText'], $row['bEText']); ?>
        <hr>

        <!-- Comments Form -->
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v3.3"></script>
        
        <div class="fb-comments" data-href="https://gabrielamicu.com/blogpst/<?=$id?>" data-width="550" data-numposts="10" data-order-by="reverse_time"></div>
      </div>

      <br>
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

  <!-- Bootstrap core JavaScript -->
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
