<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goals extends CI_Controller
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
		$get_params = $this->db
			->select('links_needed,day_of_month')
			->from('goal_params')
			->where('site_id', $this->session->userdata('site_id'))
			->get();
		// Set due date as 1st if not yet defined for this site
		if ($get_params->num_rows() == 1) {
			$params = $get_params->row();
			$data['links_needed'] = $params->links_needed;
			$data['due_date'] = $params->day_of_month;

			if ($params->day_of_month % 10 == 1) {
				$data['print_due_date'] = "{$params->day_of_month}st";
			} else if ($params->day_of_month % 10 == 2) {
				$data['print_due_date'] = "{$params->day_of_month}nd";
			} else if ($params->day_of_month % 10 == 3) {
				$data['print_due_date'] = "{$params->day_of_month}rd";
			} else {
				$data['print_due_date'] = "{$params->day_of_month}th";
			}
		} else {
			$data['due_date'] = 1;
			$data['print_due_date'] = '1st';
			$data['links_needed'] = 10;
		}

		
		// Get date range for line graph
		$this_day = date('j');
		$this_month = date('n');
		$this_year = date('Y');
		$days_in_this_month = cal_days_in_month(CAL_GREGORIAN, $this_month, $this_year);

		$prev_month = ($this_month == 1) ? 12 : $this_month-1;
		$prev_year = ($this_month == 1) ? $this_year-1 : $this_year;
		$days_in_prev_month = cal_days_in_month(CAL_GREGORIAN, $prev_month, $prev_year);

		$next_month = ($this_month == 12) ? 1 : $this_month+1;
		$next_year = ($this_month == 12) ? $this_year+1 : $this_year;
		$days_in_next_month = cal_days_in_month(CAL_GREGORIAN, $next_month, $next_year);

		// We are past the deadline, set start date in this month, end date in next month
		if ($this_day > $data['due_date']) {
			// Since we are past the due date this month, we KNOW that the start date fits within the length of this month
			$start_date = date('Y-m-d', mktime(1, 1, 1, $this_month, $data['due_date']+1, $this_year));

			// If next month doesn't have enough days, use last day of the month. Otherwise use due date in next month
			if ($days_in_next_month < $data['due_date'])
				$end_date = date('Y-m-d', mktime(1, 1, 1, $next_month, $days_in_next_month, $next_year));
			else
				$end_date = date('Y-m-d', mktime(1, 1, 1, $next_month, $data['due_date'], $next_year));
		// We haven't hit due date this month, set start date in prev month, end date is this month
		} else {
			// Check if start date fits within the length of prev month, otherwise use 1st of this month
			if ($days_in_prev_month < $data['due_date']+1)
				$start_date = date('Y-m-d', mktime(1, 1, 1, $this_month, 1, $this_year));
			else
				$start_date = date('Y-m-d', mktime(1, 1, 1, $prev_month, $data['due_date']+1, $prev_year));

			// Check if end date fits within the length of this month
			if ($days_in_this_month < $data['due_date'])
				$end_date = date('Y-m-d', mktime(1, 1, 1, $this_month, $days_in_this_month, $this_year));
			else
				$end_date = date('Y-m-d', mktime(1, 1, 1, $this_month, $data['due_date'], $this_year));
		}

		
		$get_link_counts = $this->db->query(sprintf("
			SELECT
				DATEDIFF(date, '%s') AS day,
				(SELECT
					COUNT(li.link_id)
				FROM
					links li
				WHERE 
					li.date >= '%s' AND 
					li.date <= l.date) AS count
			FROM
				links l 
			WHERE
				l.date >= '%s' AND 
				l.date <= '%s'
			GROUP BY
				l.date
			ORDER BY
				l.date ASC",
			$start_date,
			$start_date,
			$start_date,
			$end_date
		));
		$link_counts_result = $get_link_counts->result();
		
		// Convert initial data to different array format
		$link_counts = array();
		foreach ($link_counts_result AS $record)
			$link_counts[$record->day] = $record->count;

		// Fill in data for missing days
		$prev_count = 0;
		for ($i = 0; $i <= max(array_keys($link_counts)); $i++) {
			if (!isset($link_counts[$i]))
				$link_counts[$i] = $prev_count;
			else
				$prev_count = $link_counts[$i];
		}
		ksort($link_counts);			
		$data['link_counts'] = $link_counts;


		// Calculate date ticks
		$start_dt = new DateTime($start_date);
		$end_dt = new DateTime($end_date);
		$interval = $start_dt->diff($end_dt);
		$diff = $interval->format('%a');
		$data['date_range'] = $diff;
		$data['date_range'] = 30;
		$date_ticks = array(date('m/d', strtotime($start_date)));
		$new_dt = $start_dt;
		for ($i = 7; $i <= $diff; $i += 7) {
			$interval = ($diff - $i >= 7) ? 7 : $diff - $i;
			$new_dt->add(new DateInterval("P{$interval}D"));
			$date_ticks[$i] = $new_dt->format('m/d');
		}
		$data['date_ticks'] = json_encode($date_ticks);

		
		$get_needed_links = $this->db
			->select('goal_link_id AS id,text,url,status')
			->from('goal_links')
			->where('site_id', $this->session->userdata('site_id'))
			->get();
		$data['needed_links'] = $get_needed_links->result();

		$data['page'] = 'goals/view';
		$data['title'] = 'View Goals';

		$this->load->view('shell', $data);
	}

	function mark_link_active($link_id = NULL)
	{
		if ($link_id) {
			$delete_link = $this->db
				->where('goal_link_id', $link_id)
				->delete('goal_links');

			if ($delete_link)
				$this->session->set_flashdata('message_success', "Link successfully marked active and removed.");
			else
				$this->session->set_flashdata('message_failure', "Could not mark link active.");
				
			redirect('goals/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No link ID in URL. Please try again.');
			redirect('goals/view');
		}
	}

	function mark_link_needed($link_id = NULL)
	{
		if ($link_id) {
			$update_link = $this->db
				->where('goal_link_id', $link_id)
				->update('goal_links', array('status' => 'Needed'));

			if ($update_link)
				$this->session->set_flashdata('message_success', "Link successfully marked needed.");
			else
				$this->session->set_flashdata('message_failure', "Could not mark link needed.");
				
			redirect('goals/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No link ID in URL. Please try again.');
			redirect('goals/view');
		}
	}

	function mark_link_requested($link_id = NULL)
	{
		if ($link_id) {
			$update_link = $this->db
				->where('goal_link_id', $link_id)
				->update('goal_links', array('status' => 'Requested'));

			if ($update_link)
				$this->session->set_flashdata('message_success', "Link successfully marked requested.");
			else
				$this->session->set_flashdata('message_failure', "Could not mark link requested.");
				
			redirect('goals/view');
		} else {
			$this->session->set_flashdata('message_notification', 'No link ID in URL. Please try again.');
			redirect('goals/view');
		}
	}

	function edit_params()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('links_needed', 'Links Needed', 'required|is_natural_no_zero|less_than[10000]');		
		$this->form_validation->set_rules('due_date', 'Due Date', 'required|is_natural_no_zero|less_than[32]');		
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		$get_due_date = $this->db
			->select('links_needed,day_of_month')
			->from('goal_params')
			->where('site_id', $this->session->userdata('site_id'))
			->get();
		$data['params'] = $get_due_date->row();

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'goals/add_edit_params';
			$data['title'] = 'Edit Goal Params';

			$this->load->view('shell', $data);
		} else {
			$insert_update_params = $this->db->query("
				INSERT INTO
					`goal_params` (site_id, links_needed, day_of_month)
				VALUES
					(?, ?, ?)
				ON DUPLICATE KEY UPDATE
					links_needed = VALUES(links_needed),
					day_of_month = VALUES(day_of_month)",
				array(
					$this->session->userdata('site_id'),
					$this->input->post('links_needed'),
					$this->input->post('due_date')
				)
			);
			
			if ($insert_update_params)
				$this->session->set_flashdata('message_success', "Goal params successfully modified.");
			else
				$this->session->set_flashdata('message_failure', "Could not modify goal params.");

			redirect('goals/view');
		}
	}

}