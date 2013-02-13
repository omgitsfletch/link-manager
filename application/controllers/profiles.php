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

		$get_tasks = $this->db
			->select('profile_task_id AS id,due_date,status,note')
			->from('profile_tasks')
			->where('site_id', $this->session->userdata('site_id'))
			->order_by('due_date','asc')
			->get();

		$get_notes = $this->db
			->select('profile_note_id AS id,date,note')
			->from('profile_notes')
			->where('site_id', $this->session->userdata('site_id'))
			->order_by('date','asc')
			->get();
					
		$data['profiles'] = $get_profiles->result();
		$data['tasks'] = $get_tasks->result();
		$data['notes'] = $get_notes->result();

		$data['page'] = 'profiles/view';
		$data['title'] = 'View Client Details';
		$data['title2'] = 'View Client Notes';

		$this->load->view('shell', $data);
	}

	function add_profile()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'required|max_length[255]');
		$this->form_validation->set_rules('address', 'Address', 'max_length[255]');
		$this->form_validation->set_rules('phone', 'Phone', 'max_length[100]');
		$this->form_validation->set_rules('urls', 'URL(s)', 'max_length[4096]');

		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'profiles/add_edit_profile';
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

	function edit_profile($id = NULL)
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
					$data['page'] = 'profiles/add_edit_profile';
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

	function delete_profile($id = NULL)
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

	function delete_profile_multi()
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

	function add_note()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
		$this->form_validation->set_rules('note', 'Note', 'required|max_length[4096]');

		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'profiles/add_edit_note';
			$data['title'] = 'Add Client Note';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'date' => $this->input->post('date'),
				'note' => $this->input->post('note'),
				'site_id' => $this->session->userdata('site_id')
			);
			$insert_note = $this->db->insert('profile_notes', $data);
			
			if ($insert_note)
				$this->session->set_flashdata('message_success', "Client note successfully added.");
			else
				$this->session->set_flashdata('message_failure', "Could not add client note.");

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
				->select('date,note')
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

					redirect('profiles/view');
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

	function delete_note($note_id = NULL)
	{
		if ($note_id) {
			$delete_note = $this->db
				->where('profile_note_id', $note_id)
				->delete('profile_notes');

			if ($delete_note)
				$this->session->set_flashdata('message_success', "Client note successfully deleted.");
			else
				$this->session->set_flashdata('message_failure', "Could not delete client note.");
				
			redirect("profiles/view");
		} else {
			$this->session->set_flashdata('message_notification', 'No note ID in URL. Please try again.');
			redirect("profiles/view");
		}
	}

	function add_task()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('due_date', 'Due Date', 'required|callback_valid_date');
		$this->form_validation->set_rules('note', 'Note', 'required|max_length[4096]');

		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'profiles/add_edit_task';
			$data['title'] = 'Add Client Task';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'due_date' => $this->input->post('due_date'),
				'note' => $this->input->post('note'),
				'site_id' => $this->session->userdata('site_id')
			);
			$insert_task = $this->db->insert('profile_tasks', $data);
			
			if ($insert_task)
				$this->session->set_flashdata('message_success', 'Client task successfully added.');
			else
				$this->session->set_flashdata('message_failure', 'Could not add client task.');

			redirect('profiles/view');
		}
	}

	function edit_task($task_id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('due_date', 'Due Date', 'required|callback_valid_date');
		$this->form_validation->set_rules('note', 'note', 'required|max_length[4096]');

		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($task_id) {
			$get_task = $this->db
				->select('due_date,note')
				->from('profile_tasks')
				->where('profile_task_id', $task_id)
				->get();

			if ($get_task->num_rows() == 1) {
				$task_data = $get_task->row();
				$data['task'] = $task_data;

				if ($this->form_validation->run() == FALSE) {
					$data['page'] = 'profiles/add_edit_task';
					$data['title'] = 'Edit Client task';

					$this->load->view('shell', $data);
				} else {
					$data = array(
						'due_date' => $this->input->post('due_date'),
						'note' => $this->input->post('note')
					);
					$edit_task = $this->db
						->where('profile_task_id', $task_id)
						->update('profile_tasks', $data);
					
					if ($edit_task)
						$this->session->set_flashdata('message_success', "Client task successfully edited.");
					else
						$this->session->set_flashdata('message_failure', "Could not edit client task.");

					redirect('profiles/view');
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid task ID in URL. Please try again.');
				redirect('profiles/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No task ID in URL. Please try again.');
			redirect('profiles/view');
		}
	}

	function delete_task($task_id = NULL)
	{
		if ($task_id) {
			$delete_task = $this->db
				->where('profile_task_id', $task_id)
				->delete('profile_tasks');

			if ($delete_task)
				$this->session->set_flashdata('message_success', "Client task successfully deleted.");
			else
				$this->session->set_flashdata('message_failure', "Could not delete client task.");
				
			redirect("profiles/view");
		} else {
			$this->session->set_flashdata('message_notification', 'No task ID in URL. Please try again.');
			redirect("profiles/view");
		}
	}

	function mark_not_started($task_id = NULL)
	{
		if ($task_id) {
			$update_task = $this->db
				->where('profile_task_id', $task_id)
				->update('profile_tasks', array('status' => 'Not Started'));

			if ($update_task)
				$this->session->set_flashdata('message_success', "Task successfully marked as not started.");
			else
				$this->session->set_flashdata('message_failure', "Could not mark task not started.");
				
			redirect('profiles/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No task ID in URL. Please try again.');
			redirect('profiles/view');
		}
	}

	function mark_pending($task_id = NULL)
	{
		if ($task_id) {
			$update_task = $this->db
				->where('profile_task_id', $task_id)
				->update('profile_tasks', array('status' => 'Pending'));

			if ($update_task)
				$this->session->set_flashdata('message_success', "Task successfully marked as pending.");
			else
				$this->session->set_flashdata('message_failure', "Could not mark task pending.");
				
			redirect('profiles/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No task ID in URL. Please try again.');
			redirect('profiles/view');
		}	
	}

	function mark_completed($task_id = NULL)
	{
		if ($task_id) {
			$update_task = $this->db
				->where('profile_task_id', $task_id)
				->update('profile_tasks', array('status' => 'Completed'));

			if ($update_task)
				$this->session->set_flashdata('message_success', "Task successfully marked as completed.");
			else
				$this->session->set_flashdata('message_failure', "Could not mark task completed.");
				
			redirect('profiles/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No task ID in URL. Please try again.');
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