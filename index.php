<?php
/*
#
#
#############################################
#				----BeeHive----				#
#											#
#			Project Management System		#
#											#
#				Developed By 				#
#											#
#			  Goutam Chakraborty 			#
#					 &						#
#			Tirtharup Bhattacharyya			#
#											#
#############################################
#
#
*/
error_reporting(0);
@ini_set('display_errors', 0);
session_start();
require_once('class/class.helper.php');
require_once('helper/db_conn.php');
$helper=new helper();
$file=$helper->get_page_name();
if($file=='')
{
	$file='index.php';
}
if(file_exists('view/'.$file))
{
	include('view/'.$file);
}
elseif(file_exists('helper/'.$file))
{
	include('helper/'.$file);
}
?>