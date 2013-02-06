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

	function view()
	{
		$get_links = $this->db
			->select('l.link_id AS id,l.url,l.text,t.type,s.status,c.category,l.date,l.location')
			->from('links l')
			->join('types t', 't.type_id = l.type_id', 'left outer')
			->join('statuses s', 's.status_id = l.status_id', 'left outer')
			->join('categories c', 'c.category_id = l.category_id', 'left outer')
			->where('l.site_id', $this->session->userdata('site_id'))
			->order_by('l.date', 'DESC')
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
			->select('l.link_id AS id,l.location,l.contact_name,l.contact_email,c.category,t.type,l.price,p.period')
			->from('links l')
			->join('types t', 't.type_id = l.type_id', 'left outer')
			->join('statuses s', 's.status_id = l.status_id', 'left outer')
			->join('categories c', 'c.category_id = l.category_id', 'left outer')
			->join('price_periods p', 'p.period_id = l.price_period', 'left outer')
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

		$this->form_validation->set_rules('location', 'Location', 'required|max_length[100]');
		$this->form_validation->set_rules('text', 'Text', 'required|max_length[100]');
		$this->form_validation->set_rules('url', 'URL', 'required|max_length[100]');
		$this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
		$this->form_validation->set_rules('status_id', 'Status', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('type_id', 'Type', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('notes', 'Notes', 'max_length[255]');

		$this->form_validation->set_rules('contact_email', 'Contact E-mail', 'valid_email|max_length[100]');
		$this->form_validation->set_rules('contact_name', 'Contact Name', 'max_length[100]');
		$this->form_validation->set_rules('category_id', 'Category', '');
		$this->form_validation->set_rules('contact_by', 'Contact By', 'valid_email|max_length[100]');
		$this->form_validation->set_rules('price', 'Price', 'is_natural|less_than[10000]');
		$this->form_validation->set_rules('price_period', 'Pricing Period', '');

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
			
			$get_periods = $this->db
				->select('period_id,period')
				->from('price_periods')
				->order_by('period_id', 'ASC')
				->get();
			$periods = $get_periods->result();

			$data['types'] = $types;
			$data['statuses'] = $statuses;
			$data['categories'] = $categories;
			$data['periods'] = $periods;

			$data['page'] = 'links/add_edit';
			$data['title'] = 'Add Link';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'location' => $this->input->post('location'),
				'text' => $this->input->post('text'),
				'url' => $this->input->post('url'),
				'date' => $this->input->post('date'),
				'status_id' => $this->input->post('status_id'),
				'type_id' => $this->input->post('type_id'),
				'notes' => $this->input->post('notes'),
				'contact_email' => $this->input->post('contact_email'),
				'contact_name' => $this->input->post('contact_name'),
				'category_id' => ($this->input->post('category_id')) ? $this->input->post('category_id') : NULL,
				'contact_by' => $this->input->post('contact_by'),
				'price' => ($this->input->post('price')) ? $this->input->post('price') : NULL,
				'price_period' => ($this->input->post('price_period')) ? $this->input->post('price_period') : NULL,
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

		$this->form_validation->set_rules('location', 'Location', 'required|max_length[100]');
		$this->form_validation->set_rules('text', 'Text', 'required|max_length[100]');
		$this->form_validation->set_rules('url', 'URL', 'required|max_length[100]');
		$this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
		$this->form_validation->set_rules('status_id', 'Status', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('type_id', 'Type', 'required|is_natural_no_zero');
		$this->form_validation->set_rules('notes', 'Notes', 'max_length[255]');

		$this->form_validation->set_rules('contact_email', 'Contact E-mail', 'valid_email|max_length[100]');
		$this->form_validation->set_rules('contact_name', 'Contact Name', 'max_length[100]');
		$this->form_validation->set_rules('category_id', 'Category', '');
		$this->form_validation->set_rules('contact_by', 'Contact By', 'valid_email|max_length[100]');
		$this->form_validation->set_rules('price', 'Price', 'is_natural|less_than[10000]');
		$this->form_validation->set_rules('price_period', 'Pricing Period', '');

		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($id) {
			$get_link = $this->db
				->select('url,text,type_id,status_id,category_id,contact_by,contact_email,contact_name,price,price_period,date,location,notes')
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
					
					$get_periods = $this->db
						->select('period_id,period')
						->from('price_periods')
						->order_by('period_id', 'ASC')
						->get();
					$periods = $get_periods->result();

					$data['types'] = $types;
					$data['statuses'] = $statuses;
					$data['categories'] = $categories;
					$data['periods'] = $periods;

					$data['page'] = 'links/add_edit';
					$data['title'] = 'Edit Link';

					$this->load->view('shell', $data);
				} else {
					$data = array(
						'location' => $this->input->post('location'),
						'text' => $this->input->post('text'),
						'url' => $this->input->post('url'),
						'date' => $this->input->post('date'),
						'status_id' => $this->input->post('status_id'),
						'type_id' => $this->input->post('type_id'),
						'notes' => $this->input->post('notes'),
						'contact_email' => $this->input->post('contact_email'),
						'contact_name' => $this->input->post('contact_name'),
						'category_id' => ($this->input->post('category_id')) ? $this->input->post('category_id') : NULL,
						'contact_by' => $this->input->post('contact_by'),
						'price' => ($this->input->post('price')) ? $this->input->post('price') : NULL,
						'price_period' => ($this->input->post('price_period')) ? $this->input->post('price_period') : NULL,
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

	function download_to_file($filename = NULL, $data = NULL)
	{
		if ($filename && $data) {
			$this->load->helper('download');

			$data = urldecode(base64_decode($data));
	
			force_download($filename, $data);
		}
	}

	function monitor()
	{
		$get_links = $this->db->query(sprintf("
			SELECT
				l.link_id AS id,
				l.url,
				l.text,
				l.location,
				(SELECT lc1.date FROM link_checks lc1 WHERE lc1.link_id = l.link_id ORDER BY lc1.date DESC LIMIT 1) AS date,
				(SELECT lc2.status FROM link_checks lc2 WHERE lc2.link_id = l.link_id ORDER BY lc2.date DESC LIMIT 1) AS status,
				(SELECT lc3.nofollow FROM link_checks lc3 WHERE lc3.link_id = l.link_id ORDER BY lc3.date DESC LIMIT 1) AS nofollow
			FROM
				links l
			WHERE
				l.site_id = %d
			ORDER BY
				l.date DESC",
			$this->session->userdata('site_id')
		));
		$data['links'] = $get_links->result();

		$data['page'] = 'links/monitor';
		$data['title'] = 'Link Monitoring';

		$this->load->view('shell', $data);
	}

	function valid_date($date)
	{
		$date_parts = explode('-', $date);
		
		// Must be valid date format consisting of three parts separated by hyphens
		if (!is_array($date_parts) || count($date_parts) != 3) {
			$this->form_validation->set_message('valid_date', 'The %s field must be in YYYY-MM-DD format.');
			return FALSE;
		}

		// Check that all date parts are numeric
		if (!is_numeric($date_parts[0]) || !is_numeric($date_parts[1]) || !is_numeric($date_parts[2])) {
			$this->form_validation->set_message('valid_date', 'The %s field must be in YYYY-MM-DD format.');
			return FALSE;
		}

		// Check proper length of all date parts
		if (strlen($date_parts[0]) != 4 || strlen($date_parts[1]) != 2 || strlen($date_parts[2]) != 2) {
			$this->form_validation->set_message('valid_date', 'The %s field must be in YYYY-MM-DD format.');
			return FALSE;
		}

		// Check that the date is valid on Gregorian calendar
		if (!checkdate($date_parts[1], $date_parts[2], $date_parts[0])) {
			$this->form_validation->set_message('valid_date', 'The %s field does not seem to be a valid Gregorian date.');
			return FALSE;
		}

		return TRUE;
	}

}