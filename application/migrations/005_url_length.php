<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Url_length extends CI_Migration {

	public function up()
	{
		$this->db->query("
			ALTER TABLE `links`
				CHANGE `url` `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
		");
		$this->db->query("
			ALTER TABLE `sites` 
				CHANGE `url` `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
		");
	}

	public function down()
	{
		$this->db->query("
			ALTER TABLE `links`
				CHANGE `url` `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
		");
		$this->db->query("
			ALTER TABLE `sites` 
				CHANGE `url` `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
		");
	}
	
}