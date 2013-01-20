<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attributes extends CI_Controller
{
	public $plural = NULL;
	public $singular = NULL;

	function __construct()
	{
		parent::__construct();
		
		if ($this->session->userdata('logged_in') == FALSE) {
			redirect('login');
		}

		$this->plural = $this->uri->segment(1);
		switch ($this->plural) {
			case 'categories':
				$this->singular = 'category';
				break;
			case 'statuses':
				$this->singular = 'status';
				break;
			case 'types':
				$this->singular = 'type';
				break;
			case 'groups':
				$this->singular = 'group';
				break;
		}
	}

	function view()
	{
		$get_results = $this->db
			->select("{$this->singular}_id AS id,{$this->singular}")
			->from("{$this->plural}")
			->get();
		$data['results'] = $get_results->result();

		$data['page'] = 'attributes/view';
		$data['title'] = 'View ' . ucwords($this->plural);

		$this->load->view('shell', $data);
	}

	function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('data', ucwords($this->singular), 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = "attributes/add_edit";
			$data['title'] = 'Add ' . ucwords($this->singular);

			$this->load->view('shell', $data);
		} else {
			$data = array(
				"{$this->singular}" => $this->input->post('data')
			);
			$insert_query = $this->db->insert("{$this->plural}", $data);
			
			if ($insert_query)
				$this->session->set_flashdata('message_success', ucwords($this->singular) . ' successfully added.');
			else
				$this->session->set_flashdata('message_failure', "Could not add {$this->singular}.");

			redirect("{$this->plural}/view");
		}
	}

	function edit($id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('data', ucwords($this->singular), 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($id) {
			$get_query = $this->db
				->select("{$this->singular} AS data")
				->from("{$this->plural}")
				->where("{$this->singular}_id", $id)
				->get();
			$result = $get_query->row();

			if ($get_query->num_rows() == 1) {
				if ($this->form_validation->run() == FALSE) {
					$data['data'] = $result->data;
					$data['page'] = "attributes/add_edit";
					$data['title'] = 'Edit ' . ucwords($this->singular);

					$this->load->view('shell', $data);
				} else {
					$data = array("{$this->singular}" => $this->input->post('data'));
					$edit_query = $this->db
						->where("{$this->singular}_id", $id)
						->update("{$this->plural}", $data);
					
					if ($edit_query)
						$this->session->set_flashdata('message_success', 'Category successfully edited.');
					else
						$this->session->set_flashdata('message_failure', 'Could not edit category.');
						
					redirect("{$this->plural}/view");
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid category ID in URL. Please try again.');
				redirect("{$this->plural}/view");
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No category ID in URL. Please try again.');
			redirect("{$this->plural}/view");
		}
	}

	function delete($id = NULL)
	{
		if ($id) {
			$delete_query = $this->db
				->where("{$this->singular}_id", $id)
				->delete("{$this->plural}");

			if ($delete_query)
				$this->session->set_flashdata('message_success', ucwords($this->singular) . ' successfully deleted.');
			else
				$this->session->set_flashdata('message_failure', "Could not delete {$this->singular}.");
		} else {
			$this->session->set_flashdata('message_notification', "No {$this->singular} ID in URL. Please try again.");
		}

		redirect("{$this->plural}/view");
	}

	function delete_multi()
	{
		$items = $this->input->post('items');
		if (is_array($items) && count($items) > 0) {
			$ids = array();
			foreach ($items AS $id => $state)
				$ids[] = $id;

			$delete_query = $this->db
				->where_in("{$this->singular}_id", $ids)
				->delete("{$this->plural}");

			$deleted_rows = $this->db->affected_rows();
			$total_rows = count($ids);

			if ($delete_query && $deleted_rows > 0) {
				if ($deleted_rows == $total_rows)
					$this->session->set_flashdata('message_success', "All {$this->plural} successfully deleted.");
				else
					$this->session->set_flashdata('message_notification', "Only $deleted_rows of $total_rows records were successfully deleted.");
			} else {
				$this->session->set_flashdata('message_failure', "Could not delete {$this->plural}.");
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No items checked for deletion. Please try again.');
		}

		redirect("{$this->plural}/view");
	}

}