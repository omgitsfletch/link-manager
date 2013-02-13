

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Master_links extends CI_Migration {

	public function up()
	{
		$this->db->query("
			ALTER TABLE `links`
				ADD `master_link` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `site_id`,
				CHANGE `url` `url` varchar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
				CHANGE `text` `text` varchar( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
				CHANGE `contact_by` `contact_by` varchar( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
				CHANGE `date` `date` date NULL DEFAULT '0000-00-00',
				CHANGE `notes` `notes` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '';
		");
	}

	public function down()
	{
		$this->db->query("
			ALTER TABLE `links`
				DROP `master_link`,
				CHANGE `url` `url` varchar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				CHANGE `text` `text` varchar( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				CHANGE `contact_by` `contact_by` varchar( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				CHANGE `date` `date` date NOT NULL,
				CHANGE `notes` `notes` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
		");
	}
	
}

