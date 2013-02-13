<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function send_email($recipient, $sender, $subject, $message, $fromName = NULL )
{
	$CI =& get_instance();
	require_once("phpmailer/class.phpmailer.php");
	$mailer = new phpmailer();

	//Establish settings for phpmailer to use to send the mail

	$mailer->IsSMTP();
	$mailer->IsSendmail();
	
	$mailer->Host = 'mail.onlinebestelsysteem.net';
	$mailer->Username = 'noreply@onlinebestelsysteem.net';
	$mailer->Password = '665544';
	/*
	$mailer->Port = '587';
    */
	
	//Build the actual Email message

	$mailer->From = $sender;
	$mailer->FromName = ($fromName)?$fromName:$CI->config->item('site_admin_name');
	$mailer->Subject = ($subject)?$subject:$CI->config->item('mail_subject');
	$mailer->Body = $message;
	$mailer->WordWrap = 50;
	
	$mailer->AddAddress($recipient);
	$mailer->AddReplyTo(($sender)?$sender:$CI->config->item('reply_email'));
	
	$mailer->IsHTML(true);
	if(!$mailer->Send()){
		return false;	
	} else {
		return true;
	}

}