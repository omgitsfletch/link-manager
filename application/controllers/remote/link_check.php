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
			HAVING
				(last_checked IS NULL OR
				DATEDIFF(NOW(), last_checked) >= 14)",
		));
		$links = $get_links->result();

		$results = array();
		foreach ($links AS $index => $link) {
			$site_html = get_page($link->location);

			// Fetch failed, record as error
			if ($site_html === FALSE) {
				$results[$index] = array('link_id' => $link->id, 'date' => date('Y-m-d'), 'status' => 'Error');
				$this->db->insert('link_checks', $results[$index]);
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

			// Record result to database
			$this->db->insert('link_checks', $results[$index]);

			// Add some time limit since it's network intensive cURL page fetching
			set_time_limit(15);
		}

		print '<pre>'; print_r($results);
	}

}