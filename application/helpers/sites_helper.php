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

function generate_sites_dropdown($select_attribs = array('class' => 'styledselect', 'id' => 'site_switcher'))
{
	$CI =& get_instance();

	$get_sites = $CI->db
		->select('site_id AS id,name,url')
		->from('sites')
		->order_by('name','ASC')
		->get();
	$sites = $get_sites->result();

	$attribs = array();
	if (is_array($select_attribs) && count($select_attribs) > 0) {
		foreach ($select_attribs AS $attribute => $value)
			$attribs[] = "{$attribute}=\"{$value}\"";
	}
	$attribs_str = implode($attribs, ' ');

	$dropdown = "<select name=\"site_id\" {$attribs_str}>\n";
	foreach ($sites AS $site) {
		$site_url = preg_replace('#(https://|http://)(.*)#', '$2', $site->url);
		$selected = ($CI->session->userdata('site_id') == $site->id) ? 'selected="selected"' : '';
		$dropdown .= "\t<option value=\"{$site->id}\" {$selected}>{$site->name} ({$site_url})</option>\n";
	}
	$dropdown .= "</select>\n";

	return $dropdown;
}

?>