<?php
$res=@include("../main.inc.php");                                   // For root directory
if (! $res) $res=@include("../../main.inc.php");         // For "custom" directory
$sq = 'SELECT * FROM `llx_menu` WHERE fk_menu=0 AND menu_handler="auguria"';
$sql = $db->query($sq);

$ls = 'SELECT MAX(level) level FROM `llx_menu`';
$lsq = $db->query($ls);
$levels = $db->fetch_object($lsq)->level;

$logo = DOL_MAIN_URL_ROOT.'/viewimage.php?modulepart=mycompany&file=logos/thumbs/'.$mysoc->logo_small; 
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
		<title>Venta</title>

		<script src="js/jquery.js"></script>
        <script src="https://kit.fontawesome.com/62c4e05a29.js"></script>	
        <link rel='stylesheet'   href='css/bootstrap.min.css' type='text/css' media='all' />       
		<link rel='stylesheet'   href='css/mdb.css' type='text/css' media='all' />		
		<link rel='stylesheet'   href='css/main.css' type='text/css' media='all' />
	</head>
	<body class="fixed-sn black-skin">

<!--Double navigation-->
<header>
  <!-- Sidebar navigation -->

  <div id="slide-out" class="side-nav sn-bg-4 fixed scrollbar-ripe-malinka">
	<ul class="custom-scrollbar">
	  <!-- Logo -->
	  <li>
		<div class="logo-wrapper waves-light">
		  <a href="#"><img src="<?php print $logo ?>" class="img-fluid flex-center"></a>
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
<?php

        print "\n";
        print "<!-- Begin SearchForm -->\n";
        print '<div id="blockvmenusearch" class="blockvmenusearch">'."\n";
        print '<select type="text" class="searchselectcombo vmenusearchselectcombo" name="searchselectcombo"><option></option></select>';
        print '</div>'."\n";
        print "<!-- End SearchForm -->\n";

?>
	  </li>
	  <!--/.Search Form-->
	  <!-- Side navigation links -->
	  <li>
		<ul class="collapsible collapsible-accordion">
		<?php 
		$langs->loadLangs(array('bills', 'companies', 'compta', 'products', 'banks', 'main', 'withdrawals'));
        while($m = $db->fetch_object($sql)){
			$items = get_parent($m->mainmenu);
			$hijos = $db->num_rows($items);
			if($hijos > 0){
		  print '<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-chevron-right"></i>'.$langs->trans($m->titre).'<i';
				print 'class="fas fa-angle-down rotate-icon"></i></a>';
			    print '<div class="collapsible-body">';
			    print '<ul class="list-unstyled">';
			  while($m2 = $db->fetch_object($items)){
			   print '<li><a href="#" class="waves-effect">'.$langs->trans($m2->titre).'</a></li>';	  
			  }
			  print '</ul>';
			print '</div>';
		  print '</li>';				
			}else{
				print '<li><a href="#" class="waves-effect">'.$langs->trans($m->titre).'</a></li>';	  
				}
		}
 ?>	


		  <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-eye"></i> About<i class="fas fa-angle-down rotate-icon"></i></a>
			<div class="collapsible-body">
			  <ul class="list-unstyled">
				<li>
					<a href="#" class="waves-effect">Introduction</a>
				</li>
				<li><a href="#" class="waves-effect">Monthly meetings</a>
				</li>

				<li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-eye"></i> yhty<i class="fas fa-angle-down rotate-icon"></i></a>
			<div class="collapsible-body">
			  <ul class="list-unstyled2">
				<li>
					<a href="#" class="waves-effect">Introduction</a>
				</li>				
			  </ul>				
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
  <!-- Navbar -->
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
<?php 
$langs->loadLangs(array('bills', 'companies', 'compta', 'products', 'banks', 'main', 'withdrawals'));

while($m = $db->fetch_object($sql)){

$items = get_parent($m->rowid);
$hijos = $db->num_rows($items);
if($hijos > 0){
	print '<li class="nav-item dropdown">';
	print '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
	print $langs->trans($m->titre);
	print '</a>';
	print '<div  class="dropdown-menu" aria-labelledby="dropdown01">';
while($m2 = $db->fetch_object($items)){	
print '<a class="dropdown-item submenu" href="#">'.$langs->trans($m2->titre).'</a>';

}
  print '</div>';
  print '</li>';	
}else{
print '<li class="nav-item">';	
print '<a class="nav-link"><span class="clearfix d-none d-sm-inline-block">'.$langs->trans($m->titre).'</span></a>';
print '</li>';  	
}
}; 


function get_parent($mainmenu){
	global $db;
	$sq2 = 'SELECT * FROM `llx_menu` WHERE mainmenu="'.$mainmenu.'"';
	$sql2 = $db->query($sq2);
	return 	$sql2;
}

?>
          </ul>
        </div>
      </div>
    </nav>

  <!-- /.Navbar -->
</header>
<!--/.Double navigation-->

<!--Main layout-->
<main>

  <div class="container-fluid text-center">

	<!--Card-->
	<div class="card card-cascade wider reverse my-4 pb-5">

	  <!--Card image-->
	  <div class="view view-cascade overlay wow fadeIn">
		<img src="https://mdbootstrap.com/img/Photos/Slides/img%20(1).jpg" class="img-fluid">
		<a href="#!">
		  <div class="mask rgba-white-slight"></div>
		</a>
	  </div>
	  <!--/Card image-->

	  <!--Card content-->
	  <div class="card-body card-body-cascade text-center wow fadeIn" data-wow-delay="0.2s">
		<!--Title-->
		<h4 class="card-title"><strong>My adventure</strong></h4>
		<h5 class="blue-text"><strong>Photography</strong></h5>

		<p class="card-text">Sed ut perspiciatis unde omnis iste natus sit voluptatem accusantium doloremque
		  laudantium, totam rem aperiam.
		</p>

		<a class="btn btn-primary btn-lg">Primary button</a>
		<a class="btn btn-secondary btn-lg">Secondary button</a>
		<a class="btn btn-default btn-lg">Default button</a>

	  </div>
	  <!--/.Card content-->

	</div>
	<!--/.Card-->

  </div>

</main>
<!--/Main layout-->

<!--Footer-->
<footer class="page-footer text-center text-md-left pt-4">

  <!--Footer Links-->
  <div class="container-fluid">
	<div class="row">

	  <!--First column-->
	  <div class="col-md-3">
		<h5 class="text-uppercase font-weight-bold mb-4">Footer Content</h5>
		<p>Here you can use rows and columns here to organize your footer content.</p>
	  </div>
	  <!--/.First column-->

	  <hr class="w-100 clearfix d-md-none">

	  <!--Second column-->
	  <div class="col-md-2 mx-auto">
		<h5 class="text-uppercase font-weight-bold mb-4">Links</h5>
		<ul class="list-unstyled">
		  <li><a href="#!">Link 1</a></li>
		  <li><a href="#!">Link 2</a></li>
		  <li><a href="#!">Link 3</a></li>
		  <li><a href="#!">Link 4</a></li>
		</ul>
	  </div>
	  <!--/.Second column-->

	  <hr class="w-100 clearfix d-md-none">

	  <!--Third column-->
	  <div class="col-md-2 mx-auto">
		<h5 class="text-uppercase font-weight-bold mb-4">Links</h5>
		<ul class="list-unstyled">
		  <li><a href="#!">Link 1</a></li>
		  <li><a href="#!">Link 2</a></li>
		  <li><a href="#!">Link 3</a></li>
		  <li><a href="#!">Link 4</a></li>
		</ul>
	  </div>
	  <!--/.Third column-->

	  <hr class="w-100 clearfix d-md-none">

	  <!--Fourth column-->
	  <div class="col-md-2 mx-auto">
		<h5 class="text-uppercase font-weight-bold mb-4">Links</h5>
		<ul class="list-unstyled">
		  <li><a href="#!">Link 1</a></li>
		  <li><a href="#!">Link 2</a></li>
		  <li><a href="#!">Link 3</a></li>
		  <li><a href="#!">Link 4</a></li>
		</ul>
	  </div>
	  <!--/.Fourth column-->

	</div>
  </div>
  <!--/.Footer Links-->

  <hr>

  <!--Call to action-->
  <div class="call-to-action text-center my-4">
	<ul class="list-unstyled list-inline">
	  <li class="list-inline-item">
		<h5>Register for free</h5>
	  </li>
	  <li class="list-inline-item"><a href="" class="btn btn-primary">Sign up!</a></li>
	</ul>
  </div>
  <!--/.Call to action-->

  <hr>

 <!--Social buttons-->
<div class="social-section text-center">
  <ul class="list-unstyled list-inline">
	<li class="list-inline-item"><a class="btn-floating btn-fb"><i class="fab fa-facebook-f"> </i></a></li>
	<li class="list-inline-item"><a class="btn-floating btn-tw"><i class="fab fa-twitter"> </i></a></li>
	<li class="list-inline-item"><a class="btn-floating btn-gplus"><i class="fab fa-google-plus-g"> </i></a></li>
	<li class="list-inline-item"><a class="btn-floating btn-li"><i class="fab fa-linkedin-in"> </i></a></li>
	<li class="list-inline-item"><a class="btn-floating btn-git"><i class="fab fa-github"> </i></a></li>
  </ul>
</div>
<!--/.Social buttons-->

  <!--Copyright-->
  <div class="footer-copyright py-3 text-center">
	<div class="container-fluid">
	  © 2018 Copyright: <a href="http://www.MDBootstrap.com"> MDBootstrap.com </a>

	</div>
  </div>
  <!--/.Copyright-->

</footer>
<!--/.Footer-->

</body>
</html> 
<?php
// End of page
llxFooter();
$db->close();

?>
<script type='text/javascript' src='js/bootstrap.min.js'></script>
<script type='text/javascript' src='js/mdb.min.js'></script>
<script>
// SideNav Initialization
$(".button-collapse").sideNav();

new WOW().init();
</script>