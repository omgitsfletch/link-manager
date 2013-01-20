<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Groups_management extends CI_Migration {

	public function up()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `groups` (
				`group_id` int(11) NOT NULL AUTO_INCREMENT,
				`group` varchar(100) NOT NULL,
				PRIMARY KEY (`group_id`),
				UNIQUE KEY `type` (`group`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
		");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `groups_sites` (
				`group_site_id` int(11) NOT NULL AUTO_INCREMENT,
				`group_id` int(11) NOT NULL,
				`site_id` int(11) NOT NULL,
				PRIMARY KEY (`group_site_id`),
				UNIQUE KEY `group_id_2` (`group_id`,`site_id`),
				KEY `group_id` (`group_id`),
				KEY `site_id` (`site_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
		");
		$this->db->query("
			ALTER TABLE `groups_sites`
				ADD CONSTRAINT `groups_sites_ibfk_2` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON DELETE CASCADE ON UPDATE CASCADE,
				ADD CONSTRAINT `groups_sites_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
		$this->db->query("
			ALTER TABLE `users`
				ADD `group_id` int(11) DEFAULT NULL,
				ADD INDEX (`group_id`),
				ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE SET NULL ON UPDATE CASCADE;
		");
	}

	public function down()
	{
		$this->db->query("
			ALTER TABLE `users`
				DROP FOREIGN KEY `users_ibfk_1`;
		");
		$this->db->query("
			ALTER TABLE `users`
				DROP `group_id`;
		");
		$this->dbforge->drop_table('groups_sites');
		$this->dbforge->drop_table('groups');
	}
	
}