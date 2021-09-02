<?php
/* Copyright (C) 2004-2017 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    htdocs/modulebuilder/template/admin/setup.php
 * \ingroup mastermenu
 * \brief   mastermenu setup page.
 */

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) { $i--; $j--; }
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) $res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) $res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
// Try main.inc.php using relative path
if (!$res && file_exists("../../main.inc.php")) $res = @include "../../main.inc.php";
if (!$res && file_exists("../../../main.inc.php")) $res = @include "../../../main.inc.php";
if (!$res) die("Include of main fails");

global $langs, $user;

// Libraries
require_once DOL_DOCUMENT_ROOT."/core/lib/admin.lib.php";
require_once '../lib/mastermenu.lib.php';
//require_once "../class/myclass.class.php";

// Translations
$langs->loadLangs(array(
	"mastermenu@mastermenu",
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
// Access control
if (!$user->admin) accessforbidden();

// Parameters
$action = GETPOST('action', 'alpha');
$backtopage = GETPOST('backtopage', 'alpha');

if($action=='update'){
$items = json_encode($_POST['active']);
$res = dolibarr_set_const($db,"MASTER_MENU_ACTIVE",$items,'chaine',0,'',$conf->entity);	

}

if($action=='update_left'){
$items = json_encode($_POST['active2']);
$res = dolibarr_set_const($db,"MASTER_MENU_ACTIVE_LEFT",$items,'chaine',0,'',$conf->entity);	

}

$menuactive = json_decode($conf->global->MASTER_MENU_ACTIVE);

$menuactive_left = json_decode($conf->global->MASTER_MENU_ACTIVE_LEFT);

/*
 * Actions
 */

if ((float) DOL_VERSION >= 6)
{
	include DOL_DOCUMENT_ROOT.'/core/actions_setmoduleoptions.inc.php';
}



/*
 * View
 */

$page_name = "mastermenuSetup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="'.($backtopage ? $backtopage : DOL_URL_ROOT.'/admin/modules.php?restore_lastsearch_values=1').'">'.$langs->trans("BackToModuleList").'</a>';

print load_fiche_titre($langs->trans($page_name), $linkback, 'object_mastermenu@mastermenu');

// Configuration header
$head = mastermenuAdminPrepareHead();
dol_fiche_head($head, 'settings', '', -1, "mastermenu@mastermenu");

// Setup page goes here
echo '<span class="opacitymedium">'.$langs->trans("mastermenuSetupPage").'</span><br><br>';


print '<h1>Entradas del menu superior</h1>';
	print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
	print '<input type="hidden" name="token" value="'.newToken().'">';
	print '<input type="hidden" name="action" value="update">';

	print '<table class="noborder centpercent">';
	print '<tr class="liste_titre">
	<td class="titlefield">'.$langs->trans("MenuName").'</td>
	<td>'.$langs->trans("Url").'</td>
	<td>'.$langs->trans("icon").'</td>
	<td>
	<div class="form-check">
	<input style="opacity: 0 !important;pointer-events: none !important;" name="activo" value="" type="checkbox" class="form-check-input" id="active">
	<label class="form-check-label" for="active">'.$langs->trans("activeTop").'</label>
	 </div>
	</td>	
	</tr>';
	$sq = 'SELECT * FROM `llx_menu` WHERE fk_menu=0 AND menu_handler="mastermenu"';
	$sql = $db->query($sq);	
		  while($m = $db->fetch_object($sql)){
	print '<tr>';	
	print '<td>'.$langs->trans($m->titre).'</td>';
	print '<td>'.$m->url.'</td>';
	print '<td class="td_icon" contenteditable="true" data-id="'.$m->rowid.'">'.$m->icon.'</td>';
	print '<td>

	<!-- Material checked -->
<div class="form-check">';
if(in_array($m->rowid, $menuactive)){$act = 'checked';}else{$act = '';}
  print '<input style="opacity: 0 !important;pointer-events: none !important;" name="active[]" value="'.$m->rowid.'" type="checkbox" class="form-check-input active" id="active_'.$m->rowid.'" '.$act.'>';
  print '<label class="form-check-label" for="active_'.$m->rowid.'">Activo</label>
</div>
</td>';
print '</tr>';  
		  }
	print '<tr class="liste_titre">';
	print '<td colspan="4" align="center">'.$langs->trans("Modulos adicionales").'</td>';
	print '</tr>'; 
	
	$sq = 'SELECT * FROM `llx_menu` WHERE fk_menu=0 AND menu_handler="all"';
	$sql = $db->query($sq);	
		  while($m = $db->fetch_object($sql)){
	print '<tr>';	
	print '<td>'.$langs->trans($m->titre).'</td>';
	print '<td>'.$m->url.'</td>';
	print '<td class="td_icon" contenteditable="true" data-id="'.$m->rowid.'">'.$m->icon.'</td>';

	print '<td>

	<!-- Material checked -->
<div class="form-check">';
if(in_array($m->rowid, $menuactive)){$act = 'checked';}else{$act = '';}
  print '<input style="opacity: 0 !important;pointer-events: none !important;" name="active[]" value="'.$m->rowid.'" type="checkbox" class="form-check-input active" id="active_'.$m->rowid.'" '.$act.'>';  print '<label class="form-check-label" for="active_'.$m->rowid.'">Activo</label>
</div>
	</td>';
	print '</tr>';  
		  }	



		print '</table>';

		print '<div class="tabsAction">';
		print '<center><input class="button" type="submit" value="'.$langs->trans("Modify").'"></center>';
		print '</div>';
	print '</form>';
	print '<br>';



	print '<h1>Entradas del menu Izquierdo</h1>';
	print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
	print '<input type="hidden" name="token" value="'.newToken().'">';
	print '<input type="hidden" name="action" value="update_left">';

	print '<table class="noborder centpercent">';
	print '<tr class="liste_titre">
	<td class="titlefield">'.$langs->trans("MenuName").'</td>
	<td>'.$langs->trans("Url").'</td>
	<td>'.$langs->trans("icon").'</td>
	<td>
	<div class="form-check">
	<input style="opacity: 0 !important;pointer-events: none !important;" name="activo2" value="" type="checkbox" class="form-check-input" id="active2">
	<label class="form-check-label" for="active2">'.$langs->trans("activeLeft").'</label>
	 </div>
	</td>	
	</tr>';
	$sq = 'SELECT * FROM `llx_menu` WHERE fk_menu=0 AND menu_handler="mastermenu"';
	$sql = $db->query($sq);	
		  while($m = $db->fetch_object($sql)){
	print '<tr>';	
	print '<td>'.$langs->trans($m->titre).'</td>';
	print '<td>'.$m->url.'</td>';
	print '<td class="td_icon" contenteditable="true" data-id="'.$m->rowid.'">'.$m->icon.'</td>';
	print '<td>

	<!-- Material checked -->
<div class="form-check">';
if(in_array($m->rowid, $menuactive_left)){$act = 'checked';}else{$act = '';}
  print '<input style="opacity: 0 !important;pointer-events: none !important;" name="active2[]" value="'.$m->rowid.'" type="checkbox" class="form-check-input active2" id="active2_'.$m->rowid.'" '.$act.'>';
  print '<label class="form-check-label" for="active2_'.$m->rowid.'">Activo</label>
</div>
</td>';
print '</tr>';  
		  }
	print '<tr class="liste_titre">';
	print '<td colspan="4" align="center">'.$langs->trans("Modulos adicionales").'</td>';
	print '</tr>'; 
	
	$sq = 'SELECT * FROM `llx_menu` WHERE fk_menu=0 AND menu_handler="all"';
	$sql = $db->query($sq);	
		  while($m = $db->fetch_object($sql)){
	print '<tr>';	
	print '<td>'.$langs->trans($m->titre).'</td>';
	print '<td>'.$m->url.'</td>';
	print '<td class="td_icon" contenteditable="true" data-id="'.$m->rowid.'">'.$m->icon.'</td>';

	print '<td>

	<!-- Material checked -->
<div class="form-check">';
if(in_array($m->rowid, $menuactive_left)){$act = 'checked';}else{$act = '';}
  print '<input style="opacity: 0 !important;pointer-events: none !important;" name="active2[]" value="'.$m->rowid.'" type="checkbox" class="form-check-input active2" id="active2_'.$m->rowid.'" '.$act.'>';  print '<label class="form-check-label" for="active2_'.$m->rowid.'">Activo</label>
</div>
	</td>';
	print '</tr>';  
		  }	



		print '</table>';

		print '<div class="tabsAction">';
		print '<center><input class="button" type="submit" value="'.$langs->trans("Modify").'"></center>';
		print '</div>';
	print '</form>';
	print '<br>';


// Page end
dol_fiche_end();

llxFooter();
$db->close();
?>
<script>
$('#active'). click(function(){
if($(this). is(":checked")){
$( ".active" ).each(function( index ) {
  $(this).prop('checked', true)
});
}else{
$( ".active" ).each(function( index ) {
  $(this).prop('checked', false)
});	
}
})

$('#active2'). click(function(){
if($(this). is(":checked")){
$( ".active2" ).each(function( index ) {
  $(this).prop('checked', true)
});
}else{
$( ".active2" ).each(function( index ) {
  $(this).prop('checked', false)
});	
}
})

$('.td_icon').blur(function(){
id= $(this).attr('data-id');
icon= $(this).text();
 //envio por ajax
 $.ajax({
  type: "POST",
  url: "../ajax/update_icon.php",
  data: {
    icon:icon,
    id:id,
    action:'update_icon'
  },
  dataType: "json",
  success: function(resp) {
if(resp > 0){
	$.jnotify("Icono actualizado.");
}
  }
  
  })	
});

  //envio por ajax	
</script>