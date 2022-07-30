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
class emailer
{
	private $mailer;	
	public function emailer()
	{
		require('PHPMailerAutoload.php');
		$this->mailer=new PHPMailer(); 
	}
	public function send($to_array,$subject,$body)
	{
		$this->mailer->isSMTP(); 
		$this->mailer->Host = 'smtp.bethebee.in';
		$this->mailer->SMTPAuth = true; 
		$this->mailer->Username = 'web@bethebee.in'; 
		$this->mailer->Password = 'eu@yZtLBm3';  
		$this->mailer->SMTPSecure = 'tls';     
		$this->mailer->Port = 25;
		
		$this->mailer->From = 'web@bethebee.in';
		$this->mailer->FromName = 'BeeHive';
		for($i=0;$i<count($to_array);$i++)
		{
			$this->mailer->addAddress($to_array[$i]['email'],$to_array[$i]['name']);
		}
		$this->mailer->addReplyTo('web@bethebee.in', 'BeeHive');
		//$this->mailer->addCC('cc@example.com');
		//$this->mailer->addBCC('bcc@example.com');
		$this->mailer->WordWrap = 50;
		//$this->mailer->addAttachment('/var/tmp/file.tar.gz');
		//$this->mailer->addAttachment('/tmp/image.jpg', 'new.jpg');
		$this->mailer->isHTML(true);
		$this->mailer->Subject = $subject;
		$this->mailer->Body    = $body;
		$this->mailer->AltBody = 'This is the body in plain text for non-HTML mail clients';
		if($this->mailer->send())
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}	
}
?>