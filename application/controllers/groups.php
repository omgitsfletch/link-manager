<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller
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
		$get_results = $this->db
			->select("group_id AS id,group")
			->from('groups')
			->get();
		$data['results'] = $get_results->result();

		$data['page'] = 'groups/view';
		$data['title'] = 'View Groups';

		$this->load->view('shell', $data);
	}

	function add()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('data', 'Group', 'required|max_length[100]');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');
		
		// Build array for multiselect for group members
		$site_query = $this->db
			->select('s.site_id, s.name, s.url')
			->from('sites s')
			->get();
		$sites = $site_query->result();

		if ($this->form_validation->run() == FALSE) {
			$data['sites'] = $sites;
			$data['page'] = "groups/add_edit";
			$data['title'] = 'Add Group';

			$this->load->view('shell', $data);
		} else {
			$data = array(
				'group' => $this->input->post('data')
			);
			
			$this->db->trans_start();

			// Add group
			$this->db->insert('groups', $data);
			$id = $this->db->insert_id();
				
			// Get new members from POST array, add to linker table
			$sites = $this->input->post('sites');
			if (is_array($sites) && count($sites) > 0) {
				foreach ($sites AS $site) {
					if ($site > 0)
						$this->db->insert('groups_sites', array('group_id' => $id, 'site_id' => $site));
				}
			}

			$this->db->trans_complete();
			
			if ($this->db->trans_status() === TRUE)
				$this->session->set_flashdata('message_success', 'Group successfully added.');
			else
				$this->session->set_flashdata('message_failure', 'Could not add group.');

			redirect('groups/view');
		}
	}

	function edit($id = NULL)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('data', 'Group', 'required|max_length[100]');
		$this->form_validation->set_rules('members', 'Group Members', '');
		$this->form_validation->set_error_delimiters('<div class="error-left"></div><div class="error-inner">','</div>');

		if ($id) {
			$group_query = $this->db
				->select('group AS data')
				->from('groups')
				->where('group_id', $id)
				->get();
			$group_result = $group_query->row();

			// Build array for multiselect for group members
			$site_query = $this->db
				->select('s.site_id, s.name, s.url, gs.group_site_id AS gs_id')
				->from('sites s')
				->join('groups_sites gs', "gs.site_id = s.site_id AND gs.group_id = {$id}", 'left outer')
				->get();
			$sites = $site_query->result();

			if ($group_query->num_rows() == 1) {
				if ($this->form_validation->run() == FALSE) {
					$data['data'] = $group_result->data;
					$data['sites'] = $sites;
					$data['page'] = 'groups/add_edit';
					$data['title'] = 'Edit Group';

					$this->load->view('shell', $data);
				} else {
					$data = array('group' => $this->input->post('data'));
					
					$this->db->trans_start();

					// Edit group name
					$this->db
						->where('group_id', $id)
						->update('groups', $data);

					// Delete existing sites tied to this group, to re-add new members
					$this->db
						->where('group_id', $id)
						->delete('groups_sites');
						
					// Get new members from POST array, add to linker table
					$sites = $this->input->post('sites');
					if (is_array($sites) && count($sites) > 0) {
						foreach ($sites AS $site) {
							if ($site > 0)
								$this->db->insert('groups_sites', array('group_id' => $id, 'site_id' => $site));
						}
					}

					$this->db->trans_complete();
					
					if ($this->db->trans_status() === TRUE)
						$this->session->set_flashdata('message_success', 'Category successfully edited.');
					else
						$this->session->set_flashdata('message_failure', 'Could not edit category.');
						
					redirect("groups/view");
				}
			} else {
				$this->session->set_flashdata('message_notification', 'Invalid category ID in URL. Please try again.');
				redirect("groups/view");
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No category ID in URL. Please try again.');
			redirect("groups/view");
		}
	}

	function delete($id = NULL)
	{
		if ($id) {
			$delete_query = $this->db
				->where('group_id', $id)
				->delete('groups');

			if ($delete_query)
				$this->session->set_flashdata('message_success', 'Group successfully deleted.');
			else
				$this->session->set_flashdata('message_failure', 'Could not delete group.');
		} else {
			$this->session->set_flashdata('message_notification', 'No group ID in URL. Please try again.');
		}

		redirect('groups/view');
	}

	function delete_multi()
	{
		$items = $this->input->post('items');
		if (is_array($items) && count($items) > 0) {
			$ids = array();
			foreach ($items AS $id => $state)
				$ids[] = $id;

			$delete_query = $this->db
				->where_in('group_id', $ids)
				->delete('groups');

			$deleted_rows = $this->db->affected_rows();
			$total_rows = count($ids);

			if ($delete_query && $deleted_rows > 0) {
				if ($deleted_rows == $total_rows)
					$this->session->set_flashdata('message_success', 'All groups successfully deleted.');
				else
					$this->session->set_flashdata('message_notification', "Only $deleted_rows of $total_rows records were successfully deleted.");
			} else {
				$this->session->set_flashdata('message_failure', 'Could not delete groups.');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No items checked for deletion. Please try again.');
		}

		redirect('groups/view');
	}

	function switch_group($id = NULL)
	{
		if ($id ) {
			// Don't switch to group if no sites exist under it
			$get_site_count = $this->db
				->select('site_id')
				->from('groups_sites')
				->where('group_id', $id)
				->get();
			if ($get_site_count->num_rows() > 0) {		
				$data = array('group_id' => $id);
				$switch_group = $this->db
					->where('id', $this->session->userdata('user_id'))
					->update('users', $data);

				if ($switch_group) {
					$this->session->set_userdata('group_id', $id);

					$this->session->set_flashdata('message_success', 'Current group successfully changed.');
				} else
					$this->session->set_flashdata('message_failure', 'Invalid group id. Please try again.');
					
				redirect('links/view');
			} else {
				$this->session->set_flashdata('message_failure', 'No sites in group. Add sites to group to switch to that group.');
				redirect('sites/view');
			}
		} else {
			$this->session->set_flashdata('message_notification', 'No group ID in URL. Please try again.');
			redirect('sites/view');
		}
	}

}