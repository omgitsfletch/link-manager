<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function auth()
	{
		// Attempt verification and login of user
		if ($this->input->post('username') && $this->input->post('password')) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			$login_check = $this->db->query(sprintf("
				SELECT
					`id`
				FROM
					`users`
				WHERE
					`username` = '%s' AND
					`password_hash` = MD5( CONCAT( MD5('%s'), MD5('%s') ) )",
				$username,
				$username,
				$password
			));
			
			// Successful match, log them in
			if ($login_check->num_rows() == 1) {
				$login_result = $login_check->row();
				$this->session->set_userdata('logged_in', TRUE);
				$this->session->set_userdata('user_id', $login_result->id);
				
				$get_default_site = $this->db->select('site_id AS id,name,url')
					->from('sites')
					->order_by('default','DESC')
					->limit(1)
					->get();
				$default_site = $get_default_site->row();
				$this->session->set_userdata('site_id', $default_site->id);
				$this->session->set_userdata('site_name', $default_site->name);
				$this->session->set_userdata('site_url', $default_site->url);
				
				redirect('links/view');
			} else {
				// Show user login page again
				$this->load->view('login/auth');
			}
		} else {
			// Show user login page
			$this->load->view('login/auth');
		}
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_id');
		
		redirect('login');
	}

}