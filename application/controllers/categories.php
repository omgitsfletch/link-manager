<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller
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
		$get_categories = $this->db
			->select('category_id AS id,category')
			->from('categories')
			->get();
		$data['categories'] = $get_categories->result();

		$data['page'] = 'categories/view';
		$data['title'] = 'View Categories';

		$this->load->view('shell', $data);
	}

	function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('category', 'Category', 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'categories/add_edit';
			$data['title'] = 'Add Category';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'category' => $this->input->post('category')
			);
			$insert_category = $this->db->insert('categories', $data);
			
			if ($insert_category)
				$this->session->set_flashdata('message_success', 'Category successfully added.');
			else
				$this->session->set_flashdata('message_failure', 'Could not add category.');

			redirect('categories/view');
		}
	}

	function edit($id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('category', 'Category', 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($id) {
			$get_category = $this->db
				->select('category')
				->from('categories')
				->where('category_id', $id)
				->get();
			$result = $get_category->row();

			if ($get_category->num_rows() == 1) {
				if ($this->form_validation->run() == FALSE) {
					$data['category'] = $result->category;
					$data['page'] = 'categories/add_edit';
					$data['title'] = 'Edit Category';

					$this->load->view('shell', $data);
				} else {
					$data = array('category' => $this->input->post('category'));
					$edit_category = $this->db
						->where('category_id', $id)
						->update('categories', $data);
					
					if ($edit_category)
						$this->session->set_flashdata('message_success', 'Category successfully edited.');
					else
						$this->session->set_flashdata('message_failure', 'Could not edit category.');
						
					redirect('categories/view');
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid category ID in URL. Please try again.');
				redirect('categories/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No category ID in URL. Please try again.');
			redirect('categories/view');
		}
	}

	function delete($id = NULL)
	{
		if ($id) {
			$delete_category = $this->db
				->where('category_id', $id)
				->delete('categories');

			if ($delete_category)
				$this->session->set_flashdata('message_success', 'Category successfully deleted.');
			else
				$this->session->set_flashdata('message_failure', 'Could not delete category.');
		} else {
			$this->session->set_flashdata('message_notification', 'No category ID in URL. Please try again.');
		}

		redirect('categories/view');
	}

	function delete_multi()
	{
		$items = $this->input->post('items');
		if (is_array($items) && count($items) > 0) {
			$ids = array();
			foreach ($items AS $id => $state)
				$ids[] = $id;

			$delete_categories = $this->db
				->where_in('category_id', $ids)
				->delete('categories');

			$deleted_rows = $this->db->affected_rows();
			$total_rows = count($ids);

			if ($delete_categories && $deleted_rows > 0) {
				if ($deleted_rows == $total_rows)
					$this->session->set_flashdata('message_success', 'All categories successfully deleted.');
				else
					$this->session->set_flashdata('message_notification', "Only $deleted_rows of $total_rows records were successfully deleted.");
			} else {
				$this->session->set_flashdata('message_failure', 'Could not delete categories.');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No items checked for deletion. Please try again.');
		}

		redirect('categories/view');
	}

}