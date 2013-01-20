<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		
		if ($this->session->userdata('logged_in') == FALSE) {
			redirect('login');
		}
	}

	function view($sort = 'date', $dir = 1)
	{
		$query_dir = ($dir == 1) ? 'DESC' : 'ASC';
		
		$data['sort'] = $sort;
		$data['dir'] = $dir;

		$get_links = $this->db
			->select('l.link_id AS id,l.url,l.text,t.type,s.status,c.category,l.date,l.location')
			->from('links l')
			->join('types t', 't.type_id = l.type_id', 'left outer')
			->join('statuses s', 's.status_id = l.status_id', 'left outer')
			->join('categories c', 'c.category_id = l.category_id', 'left outer')
			->where('l.site_id', $this->session->userdata('site_id'))
			->order_by($sort, $query_dir)
			->get();
		$data['links'] = $get_links->result();

		$view_details_attribs = array(
			'width'      => '500',
			'height'     => '600',
			'scrollbars' => 'no',
			'status'     => 'no',
			'location'   => 'no',	
			'resizable'  => 'yes',
			'screenx'    => '700',
			'screeny'    => '300'
		);
		$data['view_details_attribs'] = $view_details_attribs;

		$data['page'] = 'links/view';
		$data['title'] = 'View Links';

		$this->load->view('shell', $data);
	}

	function master_list($category_id = NULL)
	{
		// Find a category to use if one wasn't passed in the URL
		if (!$category_id)
			redirect('links/master_list/all');

		$data['current_category_id'] = $category_id;

		// Build category dropdown values
		$data['categories'] = array('all' => 'All');
		$get_categories = $this->db
			->select('category_id,category')
			->from('categories')
			->order_by('category', 'ASC')
			->get();
		if ($get_categories->num_rows() > 0) {
			$get_categories_result = $get_categories->result();
			foreach ($get_categories_result AS $category)
				$data['categories'][$category->category_id] = $category->category;
		}

		$get_links = $this->db
			->select('l.link_id AS id,l.location,l.contact_name,l.contact_email,c.category,t.type')
			->from('links l')
			->join('types t', 't.type_id = l.type_id', 'left outer')
			->join('statuses s', 's.status_id = l.status_id', 'left outer')
			->join('categories c', 'c.category_id = l.category_id', 'left outer')
			->order_by('l.date', 'DESC');
		if (is_numeric($category_id))
			$get_links = $this->db->where('l.category_id', $category_id)->get();
		else
			$get_links = $this->db->get();

		$data['links'] = $get_links->result();

		$data['page'] = 'links/master_list';
		$data['title'] = 'Master List';

		$this->load->view('shell', $data);
	}

	function view_details($id = NULL)
	{
		if ($id) {
			$get_link = $this->db
				->select("location AS 'Link Location',text AS 'Anchor Text',url AS 'URL',date AS 'Date',status AS 'Status',type AS 'Type',contact_email AS 'Contact E-mail',contact_name AS 'Contact Name',category AS 'Category',notes AS 'Notes'")
				->from('links')
				->join('statuses', 'statuses.status_id = links.status_id', 'left outer')
				->join('types', 'types.type_id = links.type_id', 'left outer')
				->join('categories', 'categories.category_id = links.category_id', 'left outer')
				->where('link_id', $id)
				->get();
			$data['link'] = $get_link->row();
			$data['link']->Notes = nl2br($data['link']->Notes);

			if ($get_link->num_rows() == 1) {
				$data['title'] = 'View Details';

				$this->load->view('links/view_details', $data);
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid link ID in URL. Please try again.');
				redirect('links/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No link ID in URL. Please try again.');
			redirect('links/view');
		}
	}

	function add($id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('url', 'URL', 'required|max_length[100]');
		$this->form_validation->set_rules('text', 'Text', 'required|max_length[100]');
		$this->form_validation->set_rules('contact_email', 'Contact E-mail', 'required|max_length[100]');
		$this->form_validation->set_rules('contact_name', 'Contact Name', 'required|max_length[100]');
		$this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
		$this->form_validation->set_rules('location', 'Location', 'required|max_length[100]');
		$this->form_validation->set_rules('type_id', 'Type', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('status_id', 'Status', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('category_id', 'Category', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('notes', 'Notes', 'max_length[255]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		// If ID filled, copy was hit, pre-fill everything but Anchor Text
		if ($id) {
			$get_link = $this->db
				->select('url,type_id,status_id,category_id,contact_email,contact_name,date,location,notes')
				->from('links')
				->where('link_id', $id)
				->get();
			$data['link'] = $get_link->row();
		}

		if ($this->form_validation->run() == FALSE) {
			$get_types = $this->db
				->select('type_id,type')
				->from('types')
				->order_by('type', 'ASC')
				->get();
			$types = $get_types->result();

			$get_statuses = $this->db
				->select('status_id,status')
				->from('statuses')
				->order_by('status', 'ASC')
				->get();
			$statuses = $get_statuses->result();

			$get_categories = $this->db
				->select('category_id,category')
				->from('categories')
				->order_by('category', 'ASC')
				->get();
			$categories = $get_categories->result();

			$data['types'] = $types;
			$data['statuses'] = $statuses;
			$data['categories'] = $categories;

			$data['page'] = 'links/add_edit';
			$data['title'] = 'Add Link';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'url' => $this->input->post('url'),
				'text' => $this->input->post('text'),
				'contact_email' => $this->input->post('contact_email'),
				'contact_name' => $this->input->post('contact_name'),
				'date' => $this->input->post('date'),
				'location' => $this->input->post('location'),
				'type_id' => $this->input->post('type_id'),
				'status_id' => $this->input->post('status_id'),
				'category_id' => $this->input->post('category_id'),
				'notes' => $this->input->post('notes'),
				'site_id' => $this->session->userdata('site_id')
			);
			$insert_link = $this->db->insert('links', $data);
			
			if ($insert_link)
				$this->session->set_flashdata('message_success', "Link successfully added.");
			else
				$this->session->set_flashdata('message_failure', "Could not add link.");

			redirect('links/view');
		}
	}

	function edit($id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('url', 'URL', 'required|max_length[100]');
		$this->form_validation->set_rules('text', 'Text', 'required|max_length[100]');
		$this->form_validation->set_rules('contact_email', 'Contact E-mail', 'required|max_length[100]');
		$this->form_validation->set_rules('contact_name', 'Contact Name', 'required|max_length[100]');
		$this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
		$this->form_validation->set_rules('location', 'Location', 'required|max_length[100]');
		$this->form_validation->set_rules('type_id', 'Type', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('status_id', 'Status', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('category_id', 'Category', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('notes', 'Notes', 'max_length[255]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($id) {
			$get_link = $this->db
				->select('url,text,type_id,status_id,category_id,contact_email,contact_name,date,location,notes')
				->from('links')
				->where('link_id', $id)
				->get();
			$data['link'] = $get_link->row();

			if ($get_link->num_rows() == 1) {
				if ($this->form_validation->run() == FALSE) {
					$get_types = $this->db
						->select('type_id,type')
						->from('types')
						->order_by('type', 'ASC')
						->get();
					$types = $get_types->result();

					$get_statuses = $this->db
						->select('status_id,status')
						->from('statuses')
						->order_by('status', 'ASC')
						->get();
					$statuses = $get_statuses->result();

					$get_categories = $this->db
						->select('category_id,category')
						->from('categories')
						->order_by('category', 'ASC')
						->get();
					$categories = $get_categories->result();

					$data['types'] = $types;
					$data['statuses'] = $statuses;
					$data['categories'] = $categories;

					$data['page'] = 'links/add_edit';
					$data['title'] = 'Edit Link';

					$this->load->view('shell', $data);
				} else {
					$data = array(
						'url' => $this->input->post('url'),
						'text' => $this->input->post('text'),
						'type_id' => $this->input->post('type_id'),
						'status_id' => $this->input->post('status_id'),
						'category_id' => $this->input->post('category_id'),
						'contact_email' => $this->input->post('contact_email'),
						'contact_name' => $this->input->post('contact_name'),
						'date' => $this->input->post('date'),
						'location' => $this->input->post('location'),
						'notes' => $this->input->post('notes')
					);
					$edit_link = $this->db
						->where('link_id', $id)
						->update('links', $data);
					
					if ($edit_link)
						$this->session->set_flashdata('message_success', 'Link successfully edited.');
					else
						$this->session->set_flashdata('message_failure', 'Could not edit link.');
						
					redirect('links/view');
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid link ID in URL. Please try again.');
				redirect('links/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No link ID in URL. Please try again.');
			redirect('links/view');
		}
	}

	function delete($id = NULL)
	{
		if ($id) {
			$delete_link = $this->db
				->where('link_id', $id)
				->delete('links');

			if ($delete_link)
				$this->session->set_flashdata('message_success', "Link successfully deleted.");
			else
				$this->session->set_flashdata('message_failure', "Could not delete link.");
				
			redirect('links/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No link ID in URL. Please try again.');
			redirect('links/view');
		}
	}

	function delete_multi()
	{
		$items = $this->input->post('items');
		if (is_array($items) && count($items) > 0) {
			$ids = array();
			foreach ($items AS $id => $state)
				$ids[] = $id;

			$delete_links = $this->db
				->where_in('link_id', $ids)
				->delete('links');

			$deleted_rows = $this->db->affected_rows();
			$total_rows = count($ids);

			if ($delete_links && $deleted_rows > 0) {
				if ($deleted_rows == $total_rows)
					$this->session->set_flashdata('message_success', 'All links successfully deleted.');
				else
					$this->session->set_flashdata('message_notification', "Only $deleted_rows of $total_rows records were successfully deleted.");
			} else {
				$this->session->set_flashdata('message_failure', 'Could not delete links.');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No items checked for deletion. Please try again.');
		}

		redirect('links/view');
	}

}