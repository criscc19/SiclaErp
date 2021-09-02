<?php
//$res=@include("../main.inc.php");                                   // For root directory
//if (! $res) $res=@include("../../main.inc.php");                // For "custom" directory

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
		<title>Venta</title>

		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://kit.fontawesome.com/62c4e05a29.js"></script>	
        <link rel='stylesheet'   href='css/bootstrap.min.css' type='text/css' media='all' />       
		<link rel='stylesheet'   href='css/mdb.min.css' type='text/css' media='all' />		
		<link rel='stylesheet'   href='css/main.css' type='text/css' media='all' />
        <link href="teclado_virtual/css/keyboard-dark.min.css" rel="stylesheet">
	</head>
	<body class="fixed-sn black-skin">
  <!-- Main Navigation -->
  <header>
    <!--Double navigation-->
    <header>
      <!-- Sidebar navigation -->
      <div id="slide-out" class="side-nav sn-bg-4 fixed">
        <ul class="custom-scrollbar">
          <!-- Logo -->
          <li>
            <div class="logo-wrapper waves-light">
              <a href="#"><img src="https://mdbootstrap.com/img/logo/mdb-transparent.png" class="img-fluid flex-center"></a>
            </div>
          </li>
          <!--/. Logo -->
          <!--Social-->
          <li>
            <ul class="social">
              <li><a href="#" class="icons-sm fb-ic"><i class="fab fa-facebook-f"> </i></a></li>
              <li><a href="#" class="icons-sm pin-ic"><i class="fab fa-pinterest"> </i></a></li>
              <li><a href="#" class="icons-sm gplus-ic"><i class="fab fa-google-plus-g"> </i></a></li>
              <li><a href="#" class="icons-sm tw-ic"><i class="fab fa-twitter"> </i></a></li>
            </ul>
          </li>
          <!--/Social-->
          <!--Search Form-->
          <li>
            <form class="search-form" role="search">
              <div class="form-group md-form mt-0 pt-1 waves-light">
                <input type="text" class="form-control" placeholder="Search">
              </div>
            </form>
          </li>
          <!--/.Search Form-->
          <!-- Side navigation links -->
          <li>
            <ul class="collapsible collapsible-accordion">
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-chevron-right"></i> Submit blog<i
                    class="fas fa-angle-down rotate-icon"></i></a>
                <div class="collapsible-body">
                  <ul class="list-unstyled">
                    <li><a href="#" class="waves-effect">Submit listing</a>
                    </li>
                    <li><a href="#" class="waves-effect">Registration form</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-hand-pointer"></i> Instruction<i
                    class="fas fa-angle-down rotate-icon"></i></a>
                <div class="collapsible-body">
                  <ul class="list-unstyled">
                    <li><a href="#" class="waves-effect">For bloggers</a>
                    </li>
                    <li><a href="#" class="waves-effect">For authors</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-eye"></i> About<i class="fas fa-angle-down rotate-icon"></i></a>
                <div class="collapsible-body">
                  <ul class="list-unstyled">
                    <li><a href="#" class="waves-effect">Introduction</a>
                    </li>
                    <li><a href="#" class="waves-effect">Monthly meetings</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li><a class="collapsible-header waves-effect arrow-r"><i class="far fa-envelope"></i> Contact me<i class="fas fa-angle-down rotate-icon"></i></a>
                <div class="collapsible-body">
                  <ul class="list-unstyled">
                    <li><a href="#" class="waves-effect">FAQ</a>
                    </li>
                    <li><a href="#" class="waves-effect">Write a message</a>
                    </li>
                    <li><a href="#" class="waves-effect">FAQ</a>
                    </li>
                    <li><a href="#" class="waves-effect">Write a message</a>
                    </li>
                    <li><a href="#" class="waves-effect">FAQ</a>
                    </li>
                    <li><a href="#" class="waves-effect">Write a message</a>
                    </li>
                    <li><a href="#" class="waves-effect">FAQ</a>
                    </li>
                    <li><a href="#" class="waves-effect">Write a message</a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </li>
          <!--/. Side navigation links -->
        </ul>
        <div class="sidenav-bg mask-strong"></div>
      </div>
      <!--/. Sidebar navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
		<a href="#" data-activates="slide-out" class="nav-link button-collapse black-text"><span class="navbar-toggler-icon"></span></a>
        <a class="navbar-brand" href="#"><strong>Sicla</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Pricing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Opinions</a>
            </li>
          </ul>
          <ul class="navbar-nav nav-flex-icons">
            <li class="nav-item">
              <a class="nav-link"><i class="fab fa-facebook-f"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link"><i class="fab fa-twitter"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link"><i class="fab fa-instagram"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  </header>
  <!-- Main Navigation -->
</body>
</html> 
<script type='text/javascript' src='js/bootstrap.min.js'></script>
<script type='text/javascript' src='js/mdb.min.js'></script>
<script>
// SideNav Initialization
$(".button-collapse").sideNav();

new WOW().init();
</script>