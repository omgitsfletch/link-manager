<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends CI_Controller
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
		$get_profiles = $this->db
			->select('p.profile_id AS id,p.name,p.address,p.phone,p.urls')
			->from('profiles p')
			->where('p.site_id', $this->session->userdata('site_id'))
			->order_by('p.profile_id', 'asc')
			->get();
		$data['profiles'] = $get_profiles->result();

		$data['page'] = 'profiles/view';
		$data['title'] = 'View Client Profiles';

		$this->load->view('shell', $data);
	}

	function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required|max_length[255]');
		$this->form_validation->set_rules('address', 'Address', 'max_length[255]');
		$this->form_validation->set_rules('phone', 'Phone', 'max_length[100]');
		$this->form_validation->set_rules('urls', 'URL(s)', 'max_length[4096]');

		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'profiles/add_edit';
			$data['title'] = 'Add Client Profile';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone'),
				'urls' => $this->input->post('urls'),
				'site_id' => $this->session->userdata('site_id')
			);
			$insert_profile = $this->db->insert('profiles', $data);
			
			if ($insert_profile)
				$this->session->set_flashdata('message_success', "Client profile successfully added.");
			else
				$this->session->set_flashdata('message_failure', "Could not add client profile.");

			redirect('profiles/view');
		}
	}

	function edit($id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required|max_length[255]');
		$this->form_validation->set_rules('address', 'Address', 'max_length[255]');
		$this->form_validation->set_rules('phone', 'Phone', 'max_length[100]');
		$this->form_validation->set_rules('urls', 'URL(s)', 'max_length[4096]');

		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($id) {
			$get_profile = $this->db
				->select('name,address,phone,urls')
				->from('profiles')
				->where('profile_id', $id)
				->get();
			$data['profile'] = $get_profile->row();

			if ($get_profile->num_rows() == 1) {
				if ($this->form_validation->run() == FALSE) {
					$data['page'] = 'profiles/add_edit';
					$data['title'] = 'Edit Client Profile';

					$this->load->view('shell', $data);
				} else {
					$data = array(
						'name' => $this->input->post('name'),
						'address' => $this->input->post('address'),
						'phone' => $this->input->post('phone'),
						'urls' => $this->input->post('urls'),
						'site_id' => $this->session->userdata('site_id')
					);
					$edit_profile = $this->db
						->where('profile_id', $id)
						->update('profiles', $data);
					
					if ($edit_profile)
						$this->session->set_flashdata('message_success', 'Client profile successfully edited.');
					else
						$this->session->set_flashdata('message_failure', 'Could not edit client profile.');
						
					redirect('profiles/view');
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid profile ID in URL. Please try again.');
				redirect('profiles/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No profile ID in URL. Please try again.');
			redirect('profiles/view');
		}
	}

	function delete($id = NULL)
	{
		if ($id) {
			$delete_profile = $this->db
				->where('profile_id', $id)
				->delete('profiles');

			if ($delete_profile)
				$this->session->set_flashdata('message_success', "Client profile successfully deleted.");
			else
				$this->session->set_flashdata('message_failure', "Could not delete client profile.");
				
			redirect('profiles/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No profile ID in URL. Please try again.');
			redirect('profiles/view');
		}
	}

	function delete_multi()
	{
		$items = $this->input->post('items');
		if (is_array($items) && count($items) > 0) {
			$ids = array();
			foreach ($items AS $id => $state)
				$ids[] = $id;

			$delete_profiles = $this->db
				->where_in('profile_id', $ids)
				->delete('profiles');

			$deleted_rows = $this->db->affected_rows();
			$total_rows = count($ids);

			if ($delete_profiles && $deleted_rows > 0) {
				if ($deleted_rows == $total_rows)
					$this->session->set_flashdata('message_success', 'All client profiles successfully deleted.');
				else
					$this->session->set_flashdata('message_notification', "Only $deleted_rows of $total_rows records were successfully deleted.");
			} else {
				$this->session->set_flashdata('message_failure', 'Could not delete client profiles.');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No items checked for deletion. Please try again.');
		}

		redirect('profiles/view');
	}

	function view_notes($profile_id = NULL)
	{
		if ($profile_id) {
			$get_profile = $this->db
				->select('profile_id AS id,name,address,phone,urls')
				->from('profiles')
				->where('profile_id', $profile_id)
				->get();

			if ($get_profile->num_rows() == 1) {
				$get_notes = $this->db
					->select('profile_note_id AS id,date,note')
					->from('profile_notes')
					->where('profile_id', $profile_id)
					->order_by('date','desc')
					->get();
					
				$data['profile'] = $get_profile->row();
				$data['notes'] = $get_notes->result();

				$data['page'] = 'profiles/view_notes';
				$data['title'] = 'View Client Details';
				$data['title2'] = 'View Client Notes';

				$this->load->view('shell', $data);
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid profile ID in URL. Please try again.');
				redirect('profiles/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No profile ID in URL. Please try again.');
			redirect('profiles/view');
		}
	}

	function add_note($profile_id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
		$this->form_validation->set_rules('note', 'Note', 'required|max_length[4096]');

		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($profile_id) {
			$check_valid_profile = $this->db
				->select('profile_id')
				->from('profiles')
				->where('profile_id', $profile_id)
				->get();

			if ($check_valid_profile->num_rows() == 1) {
				if ($this->form_validation->run() == FALSE) {
					$data['page'] = 'profiles/add_edit_note';
					$data['title'] = 'Add Client Note';

					$this->load->view('shell', $data);
				} else {
					$data = array(
						'date' => $this->input->post('date'),
						'note' => $this->input->post('note'),
						'profile_id' => $profile_id
					);
					$insert_note = $this->db->insert('profile_notes', $data);
					
					if ($insert_note)
						$this->session->set_flashdata('message_success', "Client note successfully added.");
					else
						$this->session->set_flashdata('message_failure', "Could not add client note.");

					redirect("profiles/view_notes/{$profile_id}");
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid profile ID in URL. Please try again.');
				redirect('profiles/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No profile ID in URL. Please try again.');
			redirect('profiles/view');
		}
	}

	function edit_note($note_id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
		$this->form_validation->set_rules('note', 'Note', 'required|max_length[4096]');

		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($note_id) {
			$get_note = $this->db
				->select('profile_id,date,note')
				->from('profile_notes')
				->where('profile_note_id', $note_id)
				->get();

			if ($get_note->num_rows() == 1) {
				$note_data = $get_note->row();
				$data['note'] = $note_data;

				if ($this->form_validation->run() == FALSE) {
					$data['page'] = 'profiles/add_edit_note';
					$data['title'] = 'Edit Client Note';

					$this->load->view('shell', $data);
				} else {
					$data = array(
						'date' => $this->input->post('date'),
						'note' => $this->input->post('note')
					);
					$edit_note = $this->db
						->where('profile_note_id', $note_id)
						->update('profile_notes', $data);
					
					if ($edit_note)
						$this->session->set_flashdata('message_success', "Client note successfully edited.");
					else
						$this->session->set_flashdata('message_failure', "Could not edit client note.");

					redirect("profiles/view_notes/{$note_data->profile_id}");
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid note ID in URL. Please try again.');
				redirect('profiles/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No note ID in URL. Please try again.');
			redirect('profiles/view');
		}
	}

	function delete_note($profile_id = NULL, $note_id = NULL)
	{
		if ($profile_id) {
			if ($note_id) {
				$delete_note = $this->db
					->where('profile_note_id', $note_id)
					->delete('profile_notes');

				if ($delete_note)
					$this->session->set_flashdata('message_success', "Client note successfully deleted.");
				else
					$this->session->set_flashdata('message_failure', "Could not delete client note.");
					
				redirect("profiles/view_notes/{$profile_id}");
			} else {
				$this->session->set_flashdata('message_notification', 'No note ID in URL. Please try again.');
				redirect("profiles/view_notes/{$profile_id}");
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No profile ID in URL. Please try again.');
			redirect('profiles/view');
		}
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