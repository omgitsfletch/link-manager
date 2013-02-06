<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_check extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function check_links()
	{
		// Include DOM parser library
		$this->load->helper('curl');
	
		$get_links = $this->db->query(sprintf("
			SELECT
				l.link_id AS id,
				l.url,
				l.text,
				l.location,
				(SELECT lc.date FROM link_checks lc WHERE lc.link_id = l.link_id ORDER BY date DESC LIMIT 1) AS last_checked
			FROM
				links l
			WHERE
				l.site_id = %d
			HAVING
				(last_checked IS NULL OR
				DATEDIFF(NOW(), last_checked) >= 14)",
			$this->session->userdata('site_id')
		));
		$links = $get_links->result();

		$results = array();
		foreach ($links AS $index => $link) {
			$site_html = get_page($link->location);

			// Fetch failed, record as error
			if ($site_html === FALSE) {
				$results[$index] = array('link_id' => $link->id, 'date' => date('Y-m-d'), 'status' => 'Error');
				continue;
			}

			// Attempt to find link in site
			$results[$index] = array('link_id' => $link->id, 'date' => date('Y-m-d'), 'status' => 'Error');

			$match_found = preg_match("$<a(.*)href=\"{$link->url}\"(.*)>(.*)</a>$", $site_html, $matches);
			if ($match_found) {
				if (isset($matches[3]) && $matches[3] == $link->text)
					$results[$index]['status'] = 'Found';
				
				if (strpos($matches[2], 'nofollow') !== FALSE || strpos($matches[1], 'nofollow') !== FALSE)
					$results[$index]['nofollow'] = TRUE;
				else
					$results[$index]['nofollow'] = FALSE;
			}

			set_time_limit(15);
		}
		
		foreach ($results AS $link_id => $check_data) {
			$this->db->insert('link_checks', $check_data);
		}

		print '<pre>'; print_r($results);
	}

}