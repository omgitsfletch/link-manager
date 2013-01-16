<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Types extends CI_Controller
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
		$get_types = $this->db
			->select('type_id AS id,type')
			->from('types')
			->get();
		$data['types'] = $get_types->result();

		$data['page'] = 'types/view';
		$data['title'] = 'View Types';

		$this->load->view('shell', $data);
	}

	function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('type', 'Type', 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'types/add_edit';
			$data['title'] = 'Add Type';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'type' => $this->input->post('type')
			);
			$insert_type = $this->db->insert('types', $data);
			
			if ($insert_type)
				$this->session->set_flashdata('message_success', "Type successfully added.");
			else
				$this->session->set_flashdata('message_failure', "Could not add type.");

			redirect('types/view');
		}
	}

	function edit($id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('type', 'Type', 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($id) {
			$get_type = $this->db
				->select('type')
				->from('types')
				->where('type_id', $id)
				->get();
			$result = $get_type->row();

			if ($get_type->num_rows() == 1) {
				if ($this->form_validation->run() == FALSE) {
					$data['type'] = $result->type;
					$data['page'] = 'types/add_edit';
					$data['title'] = 'Edit Type';

					$this->load->view('shell', $data);
				} else {
					$data = array('type' => $this->input->post('type'));
					$edit_type = $this->db
						->where('type_id', $id)
						->update('types', $data);
					
					if ($edit_type)
						$this->session->set_flashdata('message_success', 'Type successfully edited.');
					else
						$this->session->set_flashdata('message_failure', 'Could not edit type.');
						
					redirect('types/view');
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid type ID in URL. Please try again.');
				redirect('types/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No type ID in URL. Please try again.');
			redirect('types/view');
		}
	}

	function delete($id = NULL)
	{
		if ($id) {
			$delete_type = $this->db
				->where('type_id', $id)
				->delete('types');

			if ($delete_type)
				$this->session->set_flashdata('message_success', "Type successfully deleted.");
			else
				$this->session->set_flashdata('message_failure', "Could not delete type.");
				
			redirect('types/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No type ID in URL. Please try again.');
			redirect('types/view');
		}
	}

	function delete_multi()
	{
		$items = $this->input->post('items');
		if (is_array($items) && count($items) > 0) {
			$ids = array();
			foreach ($items AS $id => $state)
				$ids[] = $id;

			$delete_types = $this->db
				->where_in('type_id', $ids)
				->delete('types');

			$deleted_rows = $this->db->affected_rows();
			$total_rows = count($ids);

			if ($delete_types && $deleted_rows > 0) {
				if ($deleted_rows == $total_rows)
					$this->session->set_flashdata('message_success', 'All types successfully deleted.');
				else
					$this->session->set_flashdata('message_notification', "Only $deleted_rows of $total_rows records were successfully deleted.");
			} else {
				$this->session->set_flashdata('message_failure', 'Could not delete types.');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No items checked for deletion. Please try again.');
		}

		redirect('types/view');
	}

}