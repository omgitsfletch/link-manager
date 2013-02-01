<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Goals extends CI_Migration {

	public function up()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `goal_params` (
				`site_id` int(11) NOT NULL,
				`links_needed` int(4) unsigned NOT NULL,
				`day_of_month` TINYINT NOT NULL,
				PRIMARY KEY (`site_id`)
			) ENGINE = INNODB  DEFAULT CHARSET=utf8;
		");
		$this->db->query("
			ALTER TABLE `goal_params`
				ADD CONSTRAINT `goal_params_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `goal_links` (
				`goal_link_id` int(11) NOT NULL AUTO_INCREMENT,
				`site_id` int(11) NOT NULL,
				`text` varchar(100) NOT NULL,
				`url` varchar(255) NOT NULL,
				`status` ENUM('Needed','Requested') NOT NULL DEFAULT 'Needed',
				PRIMARY KEY (`goal_link_id`),
				INDEX (`site_id`),
				INDEX (`status`)
			) ENGINE = INNODB  DEFAULT CHARSET=utf8;
		");
		$this->db->query("
			ALTER TABLE `goal_links`
				ADD CONSTRAINT `goal_links_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
	}

	public function down()
	{
		$this->db->query("
			ALTER TABLE `goal_links`
				DROP FOREIGN KEY `goal_links_ibfk_1`;
		");
		$this->db->query("
			ALTER TABLE `goal_params`
				DROP FOREIGN KEY `goal_params_ibfk_1`;
		");
		$this->dbforge->drop_table('goal_links');
		$this->dbforge->drop_table('goal_params');
	}
	
}

