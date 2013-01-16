<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statuses extends CI_Controller
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
		$get_statuses = $this->db
			->select('status_id AS id,status')
			->from('statuses')
			->get();
		$data['statuses'] = $get_statuses->result();

		$data['page'] = 'statuses/view';
		$data['title'] = 'View Statuses';

		$this->load->view('shell', $data);
	}

	function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('status', 'Status', 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'statuses/add_edit';
			$data['title'] = 'Add Status';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'status' => $this->input->post('status')
			);
			$insert_status = $this->db->insert('statuses', $data);
			
			if ($insert_status)
				$this->session->set_flashdata('message_success', "Status successfully added.");
			else
				$this->session->set_flashdata('message_failure', "Could not add status.");

			redirect('statuses/view');
		}
	}

	function edit($id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('status', 'Status', 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($id) {
			$get_status = $this->db
				->select('status')
				->from('statuses')
				->where('status_id', $id)
				->get();
			$result = $get_status->row();

			if ($get_status->num_rows() == 1) {
				if ($this->form_validation->run() == FALSE) {
					$data['status'] = $result->status;
					$data['page'] = 'statuses/add_edit';
					$data['title'] = 'Edit Status';

					$this->load->view('shell', $data);
				} else {
					$data = array('status' => $this->input->post('status'));
					$edit_status = $this->db
						->where('status_id', $id)
						->update('statuses', $data);
					
					if ($edit_status)
						$this->session->set_flashdata('message_success', 'Status successfully edited.');
					else
						$this->session->set_flashdata('message_failure', 'Could not edit status.');
						
					redirect('statuses/view');
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid status ID in URL. Please try again.');
				redirect('statuses/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No status ID in URL. Please try again.');
			redirect('statuses/view');
		}
	}

	function delete($id = NULL)
	{
		if ($id) {
			$delete_status = $this->db
				->where('status_id', $id)
				->delete('statuses');

			if ($delete_status)
				$this->session->set_flashdata('message_success', "Status successfully deleted.");
			else
				$this->session->set_flashdata('message_failure', "Could not delete status.");
				
			redirect('statuses/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No status ID in URL. Please try again.');
			redirect('statuses/view');
		}
	}

	function delete_multi()
	{
		$items = $this->input->post('items');
		if (is_array($items) && count($items) > 0) {
			$ids = array();
			foreach ($items AS $id => $state)
				$ids[] = $id;

			$delete_statuses = $this->db
				->where_in('status_id', $ids)
				->delete('statuses');

			$deleted_rows = $this->db->affected_rows();
			$total_rows = count($ids);

			if ($delete_statuses && $deleted_rows > 0) {
				if ($deleted_rows == $total_rows)
					$this->session->set_flashdata('message_success', 'All statuses successfully deleted.');
				else
					$this->session->set_flashdata('message_notification', "Only $deleted_rows of $total_rows records were successfully deleted.");
			} else {
				$this->session->set_flashdata('message_failure', 'Could not delete statuses.');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No items checked for deletion. Please try again.');
		}

		redirect('statuses/view');
	}

}