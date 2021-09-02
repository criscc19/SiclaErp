<?php
/* Copyright (C) 2007      Patrick Raguin       <patrick.raguin@gmail.com>
 * Copyright (C) 2009      Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2008-2013 Laurent Destailleur  <eldy@users.sourceforge.net>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *	\file       htdocs/core/menus/standard/auguria_menu.php
 *	\brief      Menu auguria manager
 */


/**
 *	Class to manage menu Auguria
 */
class MenuManager
{
	/**
     * @var DoliDB Database handler.
     */
    public $db;

    public $type_user;								// Put 0 for internal users, 1 for external users
    public $atarget="";                            // To store default target to use onto links
    public $name="auguria";

    public $menu_array;
    public $menu_array_after;

    public $tabMenu;


    /**
     *  Constructor
     *
	 *  @param	DoliDB		$db     	Database handler
     *  @param	int			$type_user	Type of user
     */
    public function __construct($db, $type_user)
    {
    	$this->type_user=$type_user;
    	$this->db=$db;
    }


   	/**
   	 * Load this->tabMenu
   	 *
   	 * @param	string	$forcemainmenu		To force mainmenu to load
   	 * @param	string	$forceleftmenu		To force leftmenu to load
   	 * @return	void
   	 */
   	public function loadMenu($forcemainmenu = '', $forceleftmenu = '')
   	{
    	global $conf, $user, $langs;

   		// On sauve en session le menu principal choisi
    	if (isset($_GET["mainmenu"])) $_SESSION["mainmenu"]=$_GET["mainmenu"];
    	if (isset($_GET["idmenu"]))   $_SESSION["idmenu"]=$_GET["idmenu"];

    	// Read mainmenu and leftmenu that define which menu to show
    	if (isset($_GET["mainmenu"]))
    	{
    		// On sauve en session le menu principal choisi
    		$mainmenu=$_GET["mainmenu"];
    		$_SESSION["mainmenu"]=$mainmenu;
    		$_SESSION["leftmenuopened"]="";
    	}
    	else
    	{
    		// On va le chercher en session si non defini par le lien
    		$mainmenu=isset($_SESSION["mainmenu"])?$_SESSION["mainmenu"]:'';
    	}
		if (! empty($forcemainmenu)) $mainmenu=$forcemainmenu;

    	if (isset($_GET["leftmenu"]))
    	{
    		// On sauve en session le menu principal choisi
    		$leftmenu=$_GET["leftmenu"];
    		$_SESSION["leftmenu"]=$leftmenu;

    		if ($_SESSION["leftmenuopened"]==$leftmenu)	// To collapse
    		{
    			//$leftmenu="";
    			$_SESSION["leftmenuopened"]="";
    		}
    		else
    		{
    			$_SESSION["leftmenuopened"]=$leftmenu;
    		}
    	} else {
    		// On va le chercher en session si non defini par le lien
    		$leftmenu=isset($_SESSION["leftmenu"])?$_SESSION["leftmenu"]:'';
    	}
    	if (! empty($forceleftmenu)) $leftmenu=$forceleftmenu;

    	require_once DOL_DOCUMENT_ROOT.'/core/class/menubase.class.php';
    	$tabMenu=array();
    	$menuArbo = new Menubase($this->db, 'auguria');
    	$menuArbo->menuLoad($mainmenu, $leftmenu, $this->type_user, 'auguria', $tabMenu);
    	$this->tabMenu=$tabMenu;
    	//var_dump($tabMenu);

    	//if ($forcemainmenu == 'all') { var_dump($this->tabMenu); exit; }
   	}

	   function get_parent($mainmenu,$menu_handler='mastermenu'){
		global $db;
		$sq2 = 'SELECT * FROM `llx_menu` WHERE mainmenu="'.$mainmenu.'" AND menu_handler="'.$menu_handler.'"';
		$sql2 = $db->query($sq2);
		return 	$sql2;
	  }	   

    /**
     *  Show menu
     *  Menu defined in sql tables were stored into $this->tabMenu BEFORE this is called.
     *
     *	@param	string	$mode		    'top', 'topnb', 'left', 'jmobile' (used to get full xml ul/li menu)
     *  @param	array	$moredata		An array with more data to output
     *  @return int                     0 or nb of top menu entries if $mode = 'topnb'
	 */
	public function showmenu($mode, $moredata = null)
	{

		global $db,$conf,$user,$mysoc,$langs;

		//niveles del menu no lo utilize
		$ls = 'SELECT MAX(level) level FROM `llx_menu`';
		$lsq = $db->query($ls);
		$levels = $db->fetch_object($lsq)->level;
		//logo de la empresa
		$logo = DOL_MAIN_URL_ROOT.'/viewimage.php?modulepart=mycompany&file=logos/thumbs/'.$mysoc->logo_small; 
		$menuactive = json_decode($conf->global->MASTER_MENU_ACTIVE);
		$menuactive_left = json_decode($conf->global->MASTER_MENU_ACTIVE_LEFT);

		print '<!-- Sidebar navigation -->';

		print '<div id="slide-out" class="side-nav fixed scrollbar-ripe-malinka" style="background-color: rgb('.$conf->global->THEME_ELDY_TOPMENU_BACK1.') !important;">
		  <ul class="custom-scrollbar">
			<!-- Logo -->
			<li>
			  <div class="logo-wrapper waves-light">
				<a href="#"><img src="'.$logo.'" class="img-fluid flex-center"></a>
			  </div>
			</li>
			<!--/. Logo -->
			<!--Social-->
			<li>
			  <ul class="">
				<li><a href="#" class="icons-sm fb-ic fa-2x" style="color:#FFF !important"><i class="fas fa-globe"></i> Sicla Versión '.DOL_VERSION.'</a></li>
			  </ul>
			</li>
			<!--/Social-->
			<!--Search Form-->
			<li>';
		
			  print "\n";
			  print "<!-- Begin SearchForm -->\n";
			  print '<div id="blockvmenusearch" class="form-control blockvmenusearch" style="width:100%">'."\n";
			  print '<select type="text" class="searchselectcombo vmenusearchselectcombo" name="searchselectcombo"><option></option></select>';
			  print '</div>'."\n";
			  print "<!-- End SearchForm -->\n";
		
			print '</li>
			<!--/.Search Form-->';

			print '<!-- Side navigation links -->
			<li>
			  <ul class="collapsible collapsible-accordion">';
		
			  $langs->loadLangs(array(
				  'bills',
				  'categories', 
				  'companies', 
				  'compta', 
				  'products', 
				  'banks', 
				  'main', 
				  'withdrawals',
				  'users',
				  'ldap', 
				  'loan', 				  
				  'admin',
				  'projects',				   
				  'hrm', 
				  'holiday',
				  'trips',	
				  'members',					  			   				  
				  'stocks',
				  'orders',
				  'commercial'
				));
					//menu principal
		$sq = 'SELECT * FROM `llx_menu` WHERE fk_menu=0 AND menu_handler="mastermenu"';
		$sql = $db->query($sq);	
			  while($m = $db->fetch_object($sql)){
				  $items = $this->get_parent($m->mainmenu);
				  $hijos = $db->num_rows($items);
				  if($m->enabled !=''){
					$enabled = eval("return (".$m->enabled.");");	
					}else{
					$enabled	= true;
					}
			
					if($m->perms !=''){
					$perms = eval("return (".$m->perms.");");	
					}else{
					$perms	= true;
					}
					
                  if($enabled && $perms && in_array($m->rowid,$menuactive_left)){
				  if($hijos > 0){
				  print '<li><a class="collapsible-header waves-effect arrow-r">'.$m->icon.' '.$langs->trans($m->titre).'';
					  print '<i class="fas fa-angle-down rotate-icon"></i></a>';
					  print '<div class="collapsible-body">';
					  print '<ul class="list-unstyled">';
					  
					while($m2 = $db->fetch_object($items)){
						$pos = strpos($m2->enabled,'==');
                        if($pos === false){
						$leftmenu2='';
						}else{
						$ex = explode('"',$m2->enabled);
						$leftmenu2=$ex[1];						
						}

						if($user->admin && $leftmenu2 !=''){
						if($leftmenu2=='admintools' || $leftmenu2=='users' || $leftmenu2=='setup'){
						$enabled2 = true;
						}else{
						$enabled2 = false;                        
						}
						}else{
							if($m2->enabled !=''){
								$enabled2 = eval("return (".$m2->enabled.");");	
								}else{
								$enabled2	= false;
								}						
						}

					
							if($m2->perms !=''){
							$perms2 = eval("return (".$m2->perms.");");	
							}else{
							$perms2	= true;
							}
							if($enabled2 && $perms2){
					       print '<li><a href="'.DOL_URL_ROOT.$m2->url.'" class="waves-effect">'.$langs->trans($m2->titre).'</a></li>';	  								
								}

					}
					print '</ul>';
				  print '</div>';
				print '</li>';				
				  }else{
					  print '<li><a href="'.DOL_URL_ROOT.$m2->url.'" class="waves-effect">'.$langs->trans($m->titre).'</a></li>';	  
					  }
					}

			  }
		     print '<li><a href="#" class="nav-link waves-effect"><hr style="border-color:#ccc"></a></li>';
//MENUS DE MODULOS
$sq3 = 'SELECT * FROM `llx_menu` WHERE fk_menu=0 AND menu_handler="all"';

$sql3 = $db->query($sq3);	
	  while($m3 = $db->fetch_object($sql3)){
		  $items3 = $this->get_parent($m3->mainmenu,'all');
		  $hijos3 = $db->num_rows($items3);
		  if($m3->enabled !=''){
			$enabled3 = eval("return (".$m3->enabled.");");	
			}else{
			$enabled3	= true;
			}
	
			if($m3->perms !=''){
			$perms3 = eval("return (".$m3->perms.");");	
			}else{
			$perms3	= true;
			}
		  if($enabled3 && $perms3 && in_array($m3->rowid,$menuactive_left)){
		  if($hijos3 > 0){
			print '<li><a class="collapsible-header waves-effect arrow-r">'.$m3->icon.' '.$langs->trans($m3->titre).'';
			print '<i class="fas fa-angle-down rotate-icon"></i></a>';
			print '<div class="collapsible-body">';
			print '<ul class="list-unstyled">';
		  while($m4 = $db->fetch_object($items3)){
			$pos = strpos($m4->enabled,'==');
			if($pos === false){
			$leftmenu2='';
			}else{
			$ex = explode('"',$m4->enabled);
			$leftmenu2=$ex[1];						
			}

			if($user->admin && $leftmenu2 !=''){
			if($leftmenu2=='admintools' || $leftmenu2=='users' || $leftmenu2=='setup'){
			$enabled4 = true;
			}else{
			$enabled4 = false;                        
			}
			}else{
				if($m4->enabled !=''){
					$enabled4 = eval("return (".$m4->enabled.");");	
					}else{
					$enabled4	= false;
					}						
			}

		
				if($m4->perms !=''){
				$perms4 = eval("return (".$m4->perms.");");	
				}else{
				$perms4	= true;
				}
				  if($enabled4 && $perms4){
				 print '<li><a href="'.DOL_URL_ROOT.$m4->url.'" class="waves-effect">'.$langs->trans($m4->titre).'</a></li>';	  								
				  }	

		  }
		  print '</ul>';
		print '</div>';
	  print '</li>';				
		}else{
			print '<li><a href="'.DOL_URL_ROOT.$m3->url.'" class="waves-effect">'.$langs->trans($m3->titre).'</a></li>';	  
			}
		  }		 
	  }				
//FIN MENU MODULOS	
	  print '<!--/. Side navigation links -->
		  </ul>
		  <div class="sidenav-bg mask-strong"></div>
		</div>
		<!--/. Sidebar navigation -->
		<!-- Navbar -->
		<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb('.$conf->global->THEME_ELDY_TOPMENU_BACK1.') !important;">
			<div class="container">
			  <a href="#" data-activates="slide-out" class="nav-link button-collapse black-text"><span class="navbar-toggler-icon"></span></a>';
			  print '<a class="navbar-brand" href="#">';
			  			  //loginn usuario 
							print '<script>';
							print '$( document ).ready(function() {';
								print '$("input[type='; print "'text'";print ']").addClass("form-control");';	
								print '$("select").addClass("form-control");			
								$(".butAction").addClass("btn btn-info");
								$(".butActionDelete").addClass("btn btn-warning");
								$(".butActionRefused").addClass("btn btn-primary");
								$(".button").addClass("btn btn-info");

								$(".butAction").removeClass("butAction");
								$(".butActionDelete").removeClass("butActionDelete");
								$(".butActionRefused").removeClass("butActionRefused");
								$(".button").removeClass("button");									

							});

							$(".login_block").remove();
							if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
								
								}else{
							alto = $(window).height()-100;
								$(".sbmenu_1").attr("style","height:"+alto+"px;background-color: rgb('.$conf->global->THEME_ELDY_TOPMENU_BACK1.') !important;");									
								}

							</script>';
			  
					  print '<div class="login_block2 usedropdown">'."\n";
			  
					  print top_menu_user();
			  
			  
					  print "</div>\n"; // end div class="login_block"
			  
							//loginn usuario 	
			  print '</a>';
			  print '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			  </button>
			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav navbar-right">';
			  print '<li>';

			  print '</li>';

			//menu principal
			$sq = 'SELECT * FROM `llx_menu` WHERE fk_menu=0 AND menu_handler="mastermenu"';
			$sql = $db->query($sq);	
		while($m = $db->fetch_object($sql)){
		
		$items = $this->get_parent($m->mainmenu);
		$hijos = $db->num_rows($items);

		if($m->enabled !=''){
		$enabled = eval("return (".$m->enabled.");");	
		}else{
		$enabled	= true;
		}

		if($m->perms !=''){
		$perms = eval("return (".$m->perms.");");	
		}else{
		$perms	= true;
		}
		

		
if($enabled && $perms && in_array($m->rowid,$menuactive)){
		if($hijos > 0){
		  print '<li class="nav-item dropdown classfortooltip" title="'.$langs->trans($m->titre).'">';
		  print '<a class="nav-link dropdown-toggle fa-1x" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
		  print $m->icon;
		  print '</a>';
		  print '<div class="dropdown-menu sbmenu_1 scrollbar-ripe-malinka" aria-labelledby="dropdown01" >';
		while($m2 = $db->fetch_object($items)){	
			$pos = strpos($m2->enabled,'==');
			if($pos === false){
			$leftmenu2='';
			}else{
			$ex = explode('"',$m2->enabled);
			$leftmenu2=$ex[1];						
			}

			if($user->admin && $leftmenu2 !=''){
			if($leftmenu2=='admintools' || $leftmenu2=='users' || $leftmenu2=='setup'){
			$enabled2 = true;
			}else{
			$enabled2 = false;                        
			}
			}else{
				if($m2->enabled !=''){
					$enabled2 = eval("return (".$m2->enabled.");");	
					}else{
					$enabled2	= false;
					}						
			}

		
				if($m2->perms !=''){
				$perms2 = eval("return (".$m2->perms.");");	
				}else{
				$perms2	= true;
				}
				if($enabled2 && $perms2){
		print '<a class="submenu" href="'.DOL_URL_ROOT.$m2->url.'">'.$langs->trans($m2->titre).'</a>';
				}
		}
		print '</div>';
		print '</li>';	
		}else{
		print '<li class="nav-item">';	
		print '<a class="nav-link" href="'.DOL_URL_ROOT.$m->url.'"><span class="clearfix d-none d-sm-inline-block">'.$langs->trans($m->titre).'</span></a>';
		print '</li>';  	
		}
		}; 
		print '</li>'; 	
}		

//MENUS DE MODULOS
$sq3 = 'SELECT * FROM `llx_menu` WHERE fk_menu=0 AND menu_handler="all"';

$sql3 = $db->query($sq3);	
	  while($m3 = $db->fetch_object($sql3)){
		  $items3 = $this->get_parent($m3->mainmenu,'all');
		  $hijos3 = $db->num_rows($items3);
		  if($m3->enabled !=''){
			$enabled3 = eval("return (".$m3->enabled.");");	
			}else{
			$enabled3	= true;
			}
	
			if($m3->perms !=''){
			$perms3 = eval("return (".$m3->perms.");");	
			}else{
			$perms3	= true;
			}
		  if($enabled3 && $perms3 && in_array($m3->rowid,$menuactive)){
			if($m3->icon==''){$titre = $langs->trans($m3->titre);}else{$titre = $m3->icon;}   
		  if($hijos3 > 0){			
			print '<li class="nav-item dropdown classfortooltip" title="'.$langs->trans($m3->titre).'"><a  class="nav-link dropdown-toggle fa-1x" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$titre.'';
			print '</a>';
			print '<div class="dropdown-menu sbmenu_1 scrollbar-ripe-malinka" aria-labelledby="dropdown01" >';
		  while($m4 = $db->fetch_object($items3)){
			$pos = strpos($m4->enabled,'==');
			if($pos === false){
			$leftmenu2='';
			}else{
			$ex = explode('"',$m4->enabled);
			$leftmenu2=$ex[1];						
			}

			if($user->admin && $leftmenu2 !=''){
			if($leftmenu2=='admintools' || $leftmenu2=='users' || $leftmenu2=='setup'){
			$enabled4 = true;
			}else{
			$enabled4 = false;                        
			}
			}else{
				if($m4->enabled !=''){
					$enabled4 = eval("return (".$m4->enabled.");");	
					}else{
					$enabled4	= false;
					}						
			}

		
				if($m4->perms !=''){
				$perms4 = eval("return (".$m4->perms.");");	
				}else{
				$perms4	= true;
				}
				  if($enabled4 && $perms4){
					
					print '<a class="submenu" href="'.DOL_URL_ROOT.$m4->url.'">'.$langs->trans($m4->titre).'</a>';
							  }	

		  }

		print '</div>';
	  print '</li>';				
		}else{
			print '<li class="nav-item">';	
			print '<a class="nav-link" href="'.DOL_URL_ROOT.$m3->url.'"><span class="clearfix d-none d-sm-inline-block">'.$titre.'</span></a>';
			print '</li>'; 	  
			}
		  }		 
	  }		
//FIN MENU MODULOS
				print '</ul>';
				
			  print '</div>';
		  
			print '</div>';
			
		  print '</nav>
		
		<!-- /.Navbar -->
		</header>
		<!--/.Double navigation-->';


        //print 'xx'.$mode;
        return 0;
    }
}
