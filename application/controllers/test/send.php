<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$url = 'http://level209.com/work/srweb.php';
		$fields = array(
            'ilike' => 'turtles',
        );

		$fields_string = '';
		foreach($fields as $key => $value) {
			$fields_string .= $key.'='.$value.'&';
		}
		rtrim($fields_string, '&');

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);

		curl_close($ch);
		
		print_r($result);
	}

}