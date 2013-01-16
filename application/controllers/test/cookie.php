<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cookie extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$cookie = array(
			'name'   => 'ninja',
			'value'  => 'master',
			'expire' => '86500',
			'domain' => '.level209.com',
			'path'   => '/',
			'prefix' => '',
			'secure' => FALSE
		);

		//$this->input->set_cookie($cookie);
		
		echo setcookie('ninja', 'master', time()+3600, '/work', 'level209.com');
		echo setcookie('ninja', 'master', time()+3600, '/', 'level209.com');
	}

}
