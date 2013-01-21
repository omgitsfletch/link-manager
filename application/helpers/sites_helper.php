<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Sites Helper
*
* @package		CodeIgniter
* @subpackage	Helpers
* @category		Helpers
* @author       Jason Fletcher < jfletch@gmail.com >
*/

// ------------------------------------------------------------------------

/**
  * General Asset Helper
  *
  * Loads sites list for use in header dropdown without need to load explicitly in every controller
  *
  * @access		public
  * @param		none
  * @return		array    List of sites in array($site_id => $site_name) structure
  */

function generate_sites_dropdown($select_attribs = array('class' => 'styledselect_form_1', 'id' => 'select_site_switcher'))
{
	$CI =& get_instance();

	$get_sites = $CI->db
		->select('s.site_id AS id,s.name,s.url')
		->from('sites s')
		
		->order_by('name','ASC');
		
	if (is_numeric($CI->session->userdata('group_id'))) {
		$get_sites = $CI->db
			->join('groups_sites gs', 'gs.site_id = s.site_id')
			->where('gs.group_id', $CI->session->userdata('group_id'))
			->get();
	} else {
		$get_sites = $CI->db
			->get();
	}

	$sites = $get_sites->result();

	$attribs = array();
	if (is_array($select_attribs) && count($select_attribs) > 0) {
		foreach ($select_attribs AS $attribute => $value)
			$attribs[] = "{$attribute}=\"{$value}\"";
	}
	$attribs_str = implode($attribs, ' ');

	$dropdown = "<select name=\"site_id\" {$attribs_str}>\n";
	if (count($sites) > 0) {
		foreach ($sites AS $site) {
			$site_url = preg_replace('#(https://|http://)(.*)#', '$2', $site->url);
			$selected = ($CI->session->userdata('site_id') == $site->id) ? 'selected="selected"' : '';
			$dropdown .= "\t<option value=\"{$site->id}\" {$selected}>{$site->name} ({$site_url})</option>\n";
		}
	} else {
		$dropdown .= "\t<option value=\"0\">Create a site!</option>\n";
	}
	$dropdown .= "</select>\n";

	return $dropdown;
}

function generate_groups_dropdown($select_attribs = array('class' => 'styledselect_form_1', 'id' => 'select_group_switcher'))
{
	$CI =& get_instance();

	$get_groups = $CI->db
		->select('g.group_id,g.group,COUNT(gs.site_id) AS cnt')
		->from('groups g')
		->join('groups_sites gs', 'gs.group_id = g.group_id', 'left outer')
		->order_by('group','ASC')
		->group_by('g.group_id')
		->get();
	$groups = $get_groups->result();

	$attribs = array();
	if (is_array($select_attribs) && count($select_attribs) > 0) {
		foreach ($select_attribs AS $attribute => $value)
			$attribs[] = "{$attribute}=\"{$value}\"";
	}
	$attribs_str = implode($attribs, ' ');

	$dropdown = "<select name=\"group_id\" {$attribs_str}>\n";
	if (count($groups) > 0) {
			$dropdown .= "\t<option value=\"0\">All</option>\n";

		foreach ($groups AS $group) {
			$selected = ($CI->session->userdata('group_id') == $group->group_id) ? 'selected="selected"' : '';
			$dropdown .= "\t<option value=\"{$group->group_id}\" {$selected}>{$group->group} ({$group->cnt})</option>\n";
		}
	} else {
		$dropdown .= "\t<option value=\"0\">Create a group!</option>\n";
	}
	$dropdown .= "</select>\n";

	return $dropdown;
}

?>