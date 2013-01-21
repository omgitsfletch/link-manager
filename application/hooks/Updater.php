<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updater
{

	function check_version()
	{
		$CI = &get_instance();

		if (!$CI->migration->current())
			show_error($CI->migration->error_string());
	}

}