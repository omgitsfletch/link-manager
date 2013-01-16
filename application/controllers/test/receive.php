<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receive extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->helper('file');

		$file_path = 'application/controllers/test/test.txt';
		
		$data = "==========\nNew Entry\n";
		$data .= "IP: {$_SERVER['REMOTE_ADDR']}\n";
		$data .= "\nPOST:\n";
		$data .= print_r($_POST, true);
		$data .= "\nGET:\n";
		$data .= print_r($_GET, true);

		write_file($file_path, $data);
		
		print_r($data);
	}

}