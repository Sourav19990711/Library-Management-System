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
class webservice
{
	private $da;
	private $mailer;
	public function webservice()
	{
		//blank constructor
		require_once('class.data_access.php');
		require_once('class.emailer.php');
		$this->da=new data_access();
		$this->mailer=new emailer();
	}
	public function call($str_xml)
	{
		$req_xml_obj=new SimpleXMLElement($str_xml);
		$action=$req_xml_obj->root->action;
		$sp_name=$req_xml_obj->root->sp_name;
		$return_array=array();
		switch ($action)
		{
			case "select":
							$result=$this->da->execute_sp($sp_name,$str_xml);
							$return_array['status']=$result[0][0][1];
							for($i=1;$i<count($result);$i++)
							{
								if(is_array($result[$i]) && count($result[$i]) > 0)
								{
									$return_array['datatable_'.$i]=$result[$i];
								}
							}
							return $return_array;
    				break;
					
			case "select_notification":
							$result=$this->da->execute_sp($sp_name,$str_xml);
							$return_array['status']=$result[0][0][1];
							
							$strMessegeTitle = 'Superbroker';
							$strMessegeText = '';
							
							for($i=1;$i<count($result);$i++)
							{
								if(is_array($result[$i]) && count($result[$i]) > 0)
								{
									$dtNotification=$result[$i];
									for($iNotificationRowCount=0;$iNotificationRowCount<count($dtNotification);$iNotificationRowCount++)
									{
										$strMessegeText = $dtNotification[$iNotificationRowCount]['notification_msg'];
										$this->send_notification($dtNotification[$iNotificationRowCount]['user_mobile_id'],$strMessegeTitle,$strMessegeText,'custom');
									}
								}
							}
							
							return $return_array;
    				break;	
					
			case "login":
							$result=$this->da->execute_sp($sp_name,$str_xml);
							$return_array['status']=$result[0][0][1];
							for($i=1;$i<count($result);$i++)
							{
								if(is_array($result[$i]) && count($result[$i]) > 0)
								{
									$return_array['datatable_'.$i]=$result[$i];
								}
							}
							if($return_array['status']==1)
							{
								$_SESSION['current_user']=$return_array['datatable_1'][0];
								//$_SESSION['current_user_permissions']=$return_array['datatable_2'];
							}
							
							return $return_array;
    				break;		
					
			case "insert":
							$result=$this->da->execute_sp($sp_name,$str_xml);
							$return_array['status']=$result[0][0][1];
							for($i=1;$i<count($result);$i++)
							{
								if(is_array($result[$i]) && count($result[$i]) > 0)
								{
									$return_array['datatable_'.$i]=$result[$i];
								}
							}
							return $return_array;
    				break;
					
    case "insert_project":
							$result=$this->da->execute_sp($sp_name,$str_xml);
							$return_array['status']=$result[0][0][1];
							$iNotificationCount=$result[2][0][0];
							
							$strMessegeTitle = '';
							$strMessegeText = '';
							if($sp_name=='insert_properties')
							{
								$strMessegeTitle = 'Superbroker - Requirement matching';
								$strMessegeText = 'One property matches with your requirement';
							}
							else if($sp_name=='insert_requirements')
							{
								$strMessegeTitle = 'Superbroker - Property matching';
								$strMessegeText = 'One requirement matches with your property';
							}
							
							if(intval($iNotificationCount)>0)
							{
								for($i=3;$i<count($result);$i++)
								{
									if(is_array($result[$i]) && count($result[$i]) > 0)
									{
										if($i==3)
										{
											$dtNotification=$result[$i];
											for($iNotificationRowCount=0;$iNotificationRowCount<count($dtNotification);$iNotificationRowCount++)
											{
												$this->send_notification($dtNotification[$iNotificationRowCount]['user_mobile_id'],$strMessegeTitle,$strMessegeText,'auto_matching');
											}
										}
										//$return_array['datatable_'.$i]=$result[$i];
									}
								}		
							}
							for($i=1;$i<count($result);$i++)
							{
								if(is_array($result[$i]) && count($result[$i]) > 0)
								{
									$return_array['datatable_'.$i]=$result[$i];
								}
							}
							return $return_array;
    				break;		
						
			case "update":
							$result=$this->da->execute_sp($sp_name,$str_xml);
							$return_array['status']=$result[0][0][1];
							for($i=1;$i<count($result);$i++)
							{
								if(is_array($result[$i]) && count($result[$i]) > 0)
								{
									$return_array['datatable_'.$i]=$result[$i];
								}
							}
							return $return_array;
    				break;
					
    case "update_project":
							$result=$this->da->execute_sp($sp_name,$str_xml);
							$return_array['status']=$result[0][0][1];
							$iNotificationCount=$result[2][0][0];
							
							$strMessegeTitle = '';
							$strMessegeText = '';
							if($sp_name=='update_properties')
							{
								$strMessegeTitle = 'Superbroker - Requirement matching';
								$strMessegeText = 'One property matches with your requirement';
							}
							else if($sp_name=='update_requirements')
							{
								$strMessegeTitle = 'Superbroker - Property matching';
								$strMessegeText = 'One requirement matches with your property';
							}
							
							if(intval($iNotificationCount)>0)
							{
								for($i=3;$i<count($result);$i++)
								{
									if(is_array($result[$i]) && count($result[$i]) > 0)
									{
										if($i==3)
										{
											$dtNotification=$result[$i];
											for($iNotificationRowCount=0;$iNotificationRowCount<count($dtNotification);$iNotificationRowCount++)
											{
												$this->send_notification($dtNotification[$iNotificationRowCount]['user_mobile_id'],$strMessegeTitle, $strMessegeText,'auto_matching');
											}
										}
										//$return_array['datatable_'.$i]=$result[$i];
									}
								}		
							}
							for($i=1;$i<count($result);$i++)
							{
								if(is_array($result[$i]) && count($result[$i]) > 0)
								{
									$return_array['datatable_'.$i]=$result[$i];
								}
							}
							return $return_array;
    				break;	
					
			case "delete":
							$result=$this->da->execute_sp($sp_name,$str_xml);
							$return_array['status']=$result[0][0][1];
							for($i=1;$i<count($result);$i++)
							{
								if(is_array($result[$i]) && count($result[$i]) > 0)
								{
									$return_array['datatable_'.$i]=$result[$i];
								}
							}
							return $return_array;
    				break;
					
			case "paging":
							$session_list_name=$req_xml_obj->root->session_list_name;
							$current_page_number=$req_xml_obj->root->current_page_number;
							$item_per_page=$req_xml_obj->root->item_per_page;
							if(isset($_SESSION[''.$session_list_name.'']) && $current_page_number!=1)
							{
								$return_array['status']=1;
								$return_array['current_page']=$current_page_number;
								$start=($current_page_number-1)*$item_per_page;
								$end=($current_page_number*$item_per_page);
								if($end > count($_SESSION[''.$session_list_name.'']))
								{
									$end = count($_SESSION[''.$session_list_name.'']);
								}
								$return_array['total_pages']=ceil(count($_SESSION[''.$session_list_name.''])/$item_per_page);
								$count=0;
								for($i=$start;$i<$end;$i++)
								{
									$return_array['datatable_1'][$count]=$_SESSION[''.$session_list_name.''][$i];
									$count++;
								}
								$pagination_html='<ul class="pagination">';
								for($p=0;$p<$return_array['total_pages'];$p++)
								{
									if(($p+1)==$return_array['current_page'])
									{
										$pagination_html.='<li class="pagination_item"><span><strong>'.($p+1).'</strong></span></li>';
									}
									else
									{
										$pagination_html.='<li class="pagination_item"><a href="javascript:void(0)" page="'.($p+1).'">'.($p+1).'</a></li>';
									}
								}
								$pagination_html.='</ul>';
								$return_array['pagination_html']=$pagination_html;
							}
							else
							{
								$result=$this->da->execute_sp($sp_name,$str_xml);
								$return_array['status']=$result[0][0][1];
								for($i=1;$i<count($result);$i++)
								{
									if(is_array($result[$i]) && count($result[$i]) > 0)
									{
										$return_array['datatable_'.$i]=$result[$i];
									}
								}
								
								$_SESSION[''.$session_list_name.'']=$return_array['datatable_1'];
								$return_array['current_page']=1;
								
								if(count($_SESSION[''.$session_list_name.'']) > 0 && count($_SESSION[''.$session_list_name.'']) < $item_per_page)
								{
									$item_per_page=count($_SESSION[''.$session_list_name.'']);
								}
								$return_array['datatable_1']='';
								$return_array['total_pages']=ceil(count($_SESSION[''.$session_list_name.''])/$item_per_page);
								for($i=0;$i<$item_per_page;$i++)
								{
									$return_array['datatable_1'][$i]=$_SESSION[''.$session_list_name.''][$i];
								}
								$pagination_html='<ul class="pagination">';
								for($p=0;$p<$return_array['total_pages'];$p++)
								{
									if(($p+1)==$return_array['current_page'])
									{
										$pagination_html.='<li class="pagination_item"><span><strong>'.($p+1).'</strong></span></li>';
									}
									else
									{
										$pagination_html.='<li class="pagination_item"><a href="javascript:void(0)" page="'.($p+1).'">'.($p+1).'</a></li>';
									}
								}
								$pagination_html.='</ul>';
								$return_array['pagination_html']=$pagination_html;		
							}
							return $return_array;
							
    				break;
					
			case "email" :
							
							$mail_arr=$this->xml_to_array($str_xml);
							$to_arr=array();
							for($i=0;$i<count($mail_arr['root']['param_list']['mail_to']['name']);$i++)
								{
									if(is_array($mail_arr['root']['param_list']['mail_to']['name']))
										{
											$to_arr[$i]['name']=$mail_arr['root']['param_list']['mail_to']['name'][$i];
											$to_arr[$i]['email']=$mail_arr['root']['param_list']['mail_to']['email'][$i];
										}
										else
										{
											$to_arr[$i]['name']=$mail_arr['root']['param_list']['mail_to']['name'];
											$to_arr[$i]['email']=$mail_arr['root']['param_list']['mail_to']['email'];
										}
								}
							$return_array['status']=1;
							return $return_array;	
					break;	
			default:
            		return;								
		}
	}
	private function xml_to_array($string)
	{
		$xml   = simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
		$array = json_decode(json_encode($xml), TRUE);
		return $array;
	}
	private function send_notification($user_mob_unique_id,$strMessegeTitle,$strMessegeText,$bNotificationType)
	{
		error_log("Notification called", 0);
		
		// define( 'API_ACCESS_KEY', 'AIzaSyA3JE5KKGI7t3gLgPMDmVwKaeghp4pfdOA' );
		$API_ACCESS_KEY = 'AIzaSyA3JE5KKGI7t3gLgPMDmVwKaeghp4pfdOA';
		$registrationIds = array($user_mob_unique_id);
		
		// prep the bundle
		$msg = array
		(
			'message' 	=> $strMessegeText, // 'here is a message. message',
			'title'		=> $strMessegeTitle, // 'This is a title. title',
			'subtitle'	=> $bNotificationType, // 'This is a subtitle. subtitle',
			'tickerText'	=> $strMessegeText, // 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon'
		);
		
		
		
		$fields = array
		(
			'registration_ids' 	=> $registrationIds,
			'data'			=> $msg
		);
		 
		$headers = array
		(
			'Authorization: key=' . $API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = curl_init();
		//curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
	}
}
?>