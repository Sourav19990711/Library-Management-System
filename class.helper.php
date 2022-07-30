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
class helper
{
	public $project_url;
	private $DS='\\';
	//private $DS='/';
	public function helper()
	{
		$file=dirname(__FILE__);
		$file_arr=explode($this->DS,$file);
		$path='';
		for($i=0;$i<count($file_arr)-1;$i++)
		{
			$path.=$file_arr[$i].$this->DS;	
		}
		$helper=$path.'helper'.$this->DS;
		include($helper.'config.php');
		$this->project_url=PROJECT_URL;
	}
	public function get_page_name()
	{
		$page_url = 'http://';
		 if ($_SERVER["SERVER_PORT"] != "80")
		 	{
		  		$page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 	}
		else 
			{
		  		$page_url.= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 	}
		 $url_array=parse_url($page_url);
		 $path_array=explode('/',$url_array['path']);
		 if($path_array[count($path_array)-1]=='')
		 {
			 $path_array[count($path_array)-1]='index.php';
		}
		 return $path_array[count($path_array)-1];
	}
	public function is_logged_in()
	{
		if(isset($_SESSION['current_user']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function check_login()
	{
		if(!isset($_SESSION['current_user']))
		{
			die('<META http-equiv="refresh" content="0;URL=login.php">');
		}
		
	}
	public function get_current_user($key)
	{
		return $_SESSION['current_user'][$key];
	}
	public function get_site_url()
	{
		return $this->project_url.'/';
	} 
	public function get_template_url()
	{
		return $this->project_url.'/view/';
	} 
}
?>