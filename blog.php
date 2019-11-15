<?php

  include 'conn/config.php';
  include 'classes/db.php';

  $currpg = "blog";

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

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <?php if(isset($_GET['lang']) && !empty($_GET['lang'])): ?>
    <meta http-equiv="refresh" content="0;url=<?=$currpg?>" />
  <?php endif;?>
  <title>Blog</title>

  <link rel="stylesheet" href="assets/css/atlantis.min.css">
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-home.css" rel="stylesheet">

  <link href = "/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body style="background-image: url('img/light-blue-gradient-ui-gradient.jpg');background-repeat: no-repeat;background-position: center;background-size: cover;">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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

      <!-- Blog Entries Column -->
      <div class="col-md-12">	

<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
  <br>
      <center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Adauga postari noi
  </button></center>
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Postare</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form action="blog" method="post">
            <p>Titlu (RO)</p>
          	<p><input type="text"></input></p>
            <p>Continunt (RO)</p>
            <p><textarea rows="4" cols="50"></textarea></p>
            <p>Titlu (ENG)</p>
          	<p><input type="text"></input></p>
            <p>Continunt (ENG)</p>
            <p><textarea rows="4" cols="50"></textarea></p>
            <p>Link poza (imgur)</p>
          	<p><input type="text"></input></p>
            <button type="button" class="btn btn-success" id="alert_demo_3_3"> Adauga</button>	
          </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

  <br>
  <?php endif; ?>

        <?php if(Functions::getBlogPosts($conn) != null): ?>

        <?php $blog = Functions::getBlogPosts($conn); ?>

        <?php foreach($blog as $b): ?>


        <!-- Blog Post -->
        <div class="card mb-4">
          <img class="card-img-top" src="<?=$b['bImage']?>" alt="Card image cap" width="750" height="350">
          <div class="card-body">
            <h2 class="card-title"><font color="#11C7FD"><?=Functions::trimitemesaj($b['bTitle'], $b['bETitle'])?></font></h2>
            <p class="text-muted"><?=Functions::trimitemesaj(substr($b['bText'], 0, 180), substr($b['bEText'], 0, 180))?> <a href = "blogpst/<?=$b['bID']?>"> ... </a> </p>
            <a href="blogpst/<?=$b['bID']?>" class="btn btn-primary"><?=Functions::trimitemesaj("Citeste mai mult", "Read more")?> &rarr;</a>
          </div>
          <div class="card-footer text-muted">
          <?=Functions::trimitemesaj("Postat pe data de", "Posted on")?> <?=$b['bDate']?>
          </div>
        </div>

        <?php endforeach; ?>
        <?php endif; ?>

        <!-- Pagination -->
        <ul class="pagination justify-content-center mb-4">
          <li class="page-item">
            <a class="page-link" href="#">&larr; <?=Functions::trimitemesaj("Vechi", "Older")?></a>
          </li>
          <li class="page-item disabled">
            <a class="page-link" href="#"><?=Functions::trimitemesaj("Noi", "Newer")?> &rarr;</a>
          </li>
        </ul>

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

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <script>
		//== Class definition
		var SweetAlert2Demo = function() {

			//== Demos
			var initDemos = function() {
				//== Sweetalert Demo 1
				$('#alert_demo_1').click(function(e) {
					swal('Good job!', {
						buttons: {        			
							confirm: {
								className : 'btn btn-success'
							}
						},
					});
				});

				//== Sweetalert Demo 2
				$('#alert_demo_2').click(function(e) {
					swal("Here's the title!", "...and here's the text!", {
						buttons: {        			
							confirm: {
								className : 'btn btn-success'
							}
						},
					});
				});

				//== Sweetalert Demo 3
				$('#alert_demo_3_1').click(function(e) {
					swal("Good job!", "You clicked the button!", {
						icon : "warning",
						buttons: {        			
							confirm: {
								className : 'btn btn-warning'
							}
						},
					});
				});

				$('#alert_demo_3_2').click(function(e) {
					swal("Good job!", "You clicked the button!", {
						icon : "error",
						buttons: {        			
							confirm: {
								className : 'btn btn-danger'
							}
						},
					});
				});

				$('#alert_demo_3_3').click(function(e) {
					swal("Gata!", "Postarea a fost adaugata cu succes", {
						icon : "success",
						buttons: {        			
							confirm: {
								className : 'btn btn-success'
							}
						},
					}).then(function() {
    window.location = "blog";
});;
				});

				$('#alert_demo_3_4').click(function(e) {
					swal("Good job!", "You clicked the button!", {
						icon : "info",
						buttons: {        			
							confirm: {
								className : 'btn btn-info'
							}
						},
					});
				});

				//== Sweetalert Demo 4
				$('#alert_demo_4').click(function(e) {
					swal({
						title: "Good job!",
						text: "You clicked the button!",
						icon: "success",
						buttons: {
							confirm: {
								text: "Confirm Me",
								value: true,
								visible: true,
								className: "btn btn-success",
								closeModal: true
							}
						}
					});
				});

				$('#alert_demo_5').click(function(e){
					swal({
						title: 'Input Something',
						html: '<br><input class="form-control" placeholder="Input Something" id="input-field">',
						content: {
							element: "input",
							attributes: {
								placeholder: "Input Something",
								type: "text",
								id: "input-field",
								className: "form-control"
							},
						},
						buttons: {
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							},        			
							confirm: {
								className : 'btn btn-success'
							}
						},
					}).then(
					function() {
						swal("", "You entered : " + $('#input-field').val(), "success");
					}
					);
				});

				$('#alert_demo_6').click(function(e) {
					swal("This modal will disappear soon!", {
						buttons: false,
						timer: 3000,
					});
				});

				$('#alert_demo_7').click(function(e) {
					swal({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						type: 'warning',
						buttons:{
							confirm: {
								text : 'Yes, delete it!',
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							}
						}
					}).then((Delete) => {
						if (Delete) {
							swal({
								title: 'Deleted!',
								text: 'Your file has been deleted.',
								type: 'success',
								buttons : {
									confirm: {
										className : 'btn btn-success'
									}
								}
							});
						} else {
							swal.close();
						}
					});
				});

				$('#alert_demo_8').click(function(e) {
					swal({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						type: 'warning',
						buttons:{
							cancel: {
								visible: true,
								text : 'No, cancel!',
								className: 'btn btn-danger'
							},        			
							confirm: {
								text : 'Yes, delete it!',
								className : 'btn btn-success'
							}
						}
					}).then((willDelete) => {
						if (willDelete) {
							swal("Poof! Your imaginary file has been deleted!", {
								icon: "success",
								buttons : {
									confirm : {
										className: 'btn btn-success'
									}
								}
							});
						} else {
							swal("Your imaginary file is safe!", {
								buttons : {
									confirm : {
										className: 'btn btn-success'
									}
								}
							});
						}
					});
				})

			};

			return {
				//== Init
				init: function() {
					initDemos();
				},
			};
		}();

		//== Class Initialization
		jQuery(document).ready(function() {
			SweetAlert2Demo.init();
		});
	</script>

</body>

</html>

<!--<?=Functions::trimitemesaj("", "")?>-->