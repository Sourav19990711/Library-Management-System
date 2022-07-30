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
#			  Goutam Chakraborty (owner)	#
#					 &						#
#			Tirtharup Bhattacharyya	(slave)	#
#											#
#############################################
#
#
*/

class data_access
{
/* variables */
private $con;
private $con_pdo;
private $db_name;
private $db_user;
private $db_password;
private $db_host;
private $DS='\\';
//private $DS='/';
/* variables */
/* constructor */
public function data_access()
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
	$this->db_name=DB_NAME;
	$this->db_user=DB_USER;
	$this->db_password=DB_password;
	$this->db_host=DB_HOST;
}
/* constructor */
/* private functions */
private function open_connection()
{
	$this->con=mysql_connect($this->db_host,$this->db_user,$this->db_password);
	if(!$this->con)
	{
		die(mysql_error());
	}
	mysql_select_db(DB_NAME);
}
private function close_connection()
{
	if($this->con)
	{
		mysql_close($this->con);
	}
}
private function open_connection_pdo()
{
	$con_string="mysql:host=".$this->db_host.";dbname=".$this->db_name;
	$this->con_pdo=new PDO($con_string,$this->db_user, $this->db_password);
	if(!$this->con_pdo)
	{
		die(mysql_error());
	}
}
private function close_connection_pdo()
{
	$this->con_pdo=null;
}
/* private functions */
/* public functions */

#---------------------------------for SP------------------ 
#--select	
public function execute_sp($sp_name,$in_param_xml)
{
	try {
			//opens php pdo connection
			$result=array();
			$count=0;
			$this->open_connection_pdo();
			
			$sql = 'CALL '.$sp_name.'(:in_param_xml)';
			$stmt = $this->con_pdo->prepare($sql);
			$stmt->bindParam(':in_param_xml', $in_param_xml, PDO::PARAM_STR);
			$stmt->execute();
			$results = array();
			do
			{
    			$results []= $stmt->fetchAll();
			} while ($stmt->nextRowset());
	}
	catch (PDOException $pe)
	{
		die("Error occurred:" . $pe->getMessage());
	}
	$stmt->closeCursor();
	unset($stmt);
	$this->close_connection_pdo();
	return $results;
}
#--select
#---------------------------------for SP ends-------------
#---------------------------------for SQL-----------------
#--select
public function execute_select($sql)
{
	$this->open_connection();
	$result=mysql_query($sql,$this->con);
	$return=array();
	$count=0;
	while($row=mysql_fetch_array($result))
	{
		foreach($row as $key=>$val)
			{
				$return[$count][$key]=$val;
			}
		$count++;	
	}
	$this->close_connection();
	return $return;
}
#--select
#--query
public function execute_query($sql)
{
	$this->open_connection();
	$result=mysql_query($sql,$this->con);
	$return=false;
	if($result)
	{
		$return=true;
	}
	$this->close_connection();
	return $return;
}
#--query
#---------------------------------for SQL ends------------
/* public functions */
	
}
?>