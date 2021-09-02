<?php
include("../../main.inc.php");
if($_POST['action'] == 'update_icon'){

 $sq = "UPDATE `llx_menu` SET `icon` = '".$_POST['icon']."' WHERE `llx_menu`.`rowid` = ".$_POST['id']."";
 $res = $db->query($sq);
 echo $res;   
}

?>