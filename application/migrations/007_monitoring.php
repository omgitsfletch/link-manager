<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Monitoring extends CI_Migration {

	public function up()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `link_checks` (
				`check_id` int(11) NOT NULL AUTO_INCREMENT,
				`link_id` int(11) NOT NULL,
				`date` date NOT NULL,
				`status` enum('Found','Missing','Error') NOT NULL,
				`nofollow` tinyint(1) unsigned NOT NULL DEFAULT '0',
				PRIMARY KEY (`check_id`),
				KEY (`link_id`),
				KEY (`status`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
		$this->db->query("
			ALTER TABLE `link_checks`
				ADD CONSTRAINT `link_checks_ibfk_1` FOREIGN KEY (`link_id`) REFERENCES `links` (`link_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
	}

	public function down()
	{
		$this->db->query("
			ALTER TABLE `link_checks`
				DROP FOREIGN KEY `link_checks_ibfk_1`;
		");
		$this->dbforge->drop_table('link_checks');
	}
	
}

