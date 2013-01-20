<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sites extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		
		if ($this->session->userdata('logged_in') == FALSE) {
			redirect('login');
		}
	}

	function view()
	{	
		$get_sites = $this->db
			->select('site_id AS id,name,url,default')
			->from('sites')
			->order_by('default', 'DESC')
			->get();
		$data['sites'] = $get_sites->result();

		$data['page'] = 'sites/view';
		$data['title'] = 'View Sites';
		$data['title2'] = 'Links - Customizable Options';

		$this->load->view('shell', $data);
	}

	function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');
		$this->form_validation->set_rules('url', 'URL', 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'sites/add_edit';
			$data['title'] = 'Add Site';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'name' => $this->input->post('name'),
				'url' => $this->input->post('url'),
				'default' => 0
			);
			$insert_site = $this->db->insert('sites', $data);
			
			if ($insert_site)
				$this->session->set_flashdata('message_success', "Site successfully added.");
			else
				$this->session->set_flashdata('message_failure', "Could not add site.");

			redirect('sites/view');
		}
	}

	function edit($id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');
		$this->form_validation->set_rules('url', 'URL', 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($id) {
			$get_site = $this->db
				->select('name,url')
				->from('sites')
				->where('site_id', $id)
				->get();
			$result = $get_site->row();

			if ($get_site->num_rows() == 1) {
				if ($this->form_validation->run() == FALSE) {
					$data['vars']['name'] = $result->name;
					$data['vars']['url'] = $result->url;
					$data['page'] = 'sites/add_edit';
					$data['title'] = 'Edit Site';

					$this->load->view('shell', $data);
				} else {
					$data = array(
						'name' => $this->input->post('name'),
						'url' => $this->input->post('url'),
					);
					$edit_site = $this->db
						->where('site_id', $id)
						->update('sites', $data);
					
					if ($edit_site)
						$this->session->set_flashdata('message_success', 'Site successfully edited.');
					else
						$this->session->set_flashdata('message_failure', 'Could not edit site.');
						
					redirect('sites/view');
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid site ID in URL. Please try again.');
				redirect('sites/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No site ID in URL. Please try again.');
			redirect('sites/view');
		}
	}

	function delete($id = NULL)
	{
		if ($id) {
			$delete_site = $this->db
				->where('site_id', $id)
				->delete('sites');

			if ($delete_site) {
				$this->session->set_flashdata('message_success', 'Site successfully deleted.');

				// Set new default site if default site was deleted
				$get_default_site = $this->db
					->select('site_id')
					->from('sites')
					->where('default', 1)
					->get();
				if ($get_default_site->num_rows() == 0) {
					$this->db
						->order_by('site_id', 'ASC')
						->limit(1)
						->update('sites', array('default' => 1));

					$this->session->set_flashdata('message_notification', 'Default site deleted. New default site selected.');
				}

				// Set new active site if current active site was deleted
				if ($id == $this->session->userdata('site_id')) {
					$get_default_site = $this->db->select('site_id AS id,name,url')
						->from('sites')
						->order_by('default','DESC')
						->limit(1)
						->get();
					$default_site = $get_default_site->row();
					$this->session->set_userdata('site_id', $default_site->id);
					$this->session->set_userdata('site_name', $default_site->name);
					$this->session->set_userdata('site_url', $default_site->url);

					$this->session->set_flashdata('message_notification', 'Active site deleted. New active site selected.');
				}
			} else {
				$this->session->set_flashdata('message_failure', 'Could not delete site.');
			}
	
			redirect('sites/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No site ID in URL. Please try again.');
			redirect('sites/view');
		}
	}

	function make_default($id = NULL)
	{
		if ($id) {
			$this->db->trans_start();
			$this->db
				->where('site_id !=', $id)
				->update('sites', array('default' => 0));
			$this->db
				->where('site_id', $id)
				->update('sites', array('default' => 1));
			$this->db->trans_complete();

			if ($this->db->trans_status() === TRUE)
				$this->session->set_flashdata('message_success', 'Site default successfully changed.');
			else
				$this->session->set_flashdata('message_failure', 'Could not change default site.');
				
			redirect('sites/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No site ID in URL. Please try again.');
			redirect('sites/view');
		}
	}
	
	function switch_site($id = NULL)
	{
		if ($id ) {
			$switch_site = $this->db
				->select('site_id AS id,name,url')
				->where('site_id', $id)
				->from('sites')
				->get();

			if ($switch_site->num_rows() == 1) {
				$site_data = $switch_site->row();
				$this->session->set_userdata('site_id', $site_data->id);
				$this->session->set_userdata('site_name', $site_data->name);
				$this->session->set_userdata('site_url', $site_data->url);

				$this->session->set_flashdata('message_success', 'Current site successfully changed.');
			} else
				$this->session->set_flashdata('message_failure', 'Invalid site id. Please try again.');
				
			redirect('links/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No site ID in URL. Please try again.');
			redirect('sites/view');
		}
	}

}