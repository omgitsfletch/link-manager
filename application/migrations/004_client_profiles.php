<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Client_profiles extends CI_Migration {

	public function up()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `profiles` (
				`profile_id` int(11) NOT NULL AUTO_INCREMENT,
				`site_id` int(11) NOT NULL,
				`name` varchar(255) NOT NULL,
				`address` varchar(255) NOT NULL,
				`phone` varchar(50) NOT NULL,
				`urls` text NOT NULL,
				PRIMARY KEY (`profile_id`),
				KEY `site_id` (`site_id`)
			) ENGINE = INNODB  DEFAULT CHARSET=utf8;
		");
		$this->db->query("
			ALTER TABLE `profiles` 
				ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `profile_notes` (
				`profile_note_id` int(11) NOT NULL AUTO_INCREMENT,
				`profile_id` int(11) NOT NULL,
				`date` date NOT NULL,
				`note` TEXT NOT NULL,
				PRIMARY KEY (`profile_note_id`),
				INDEX (`profile_id`)
			) ENGINE = INNODB  DEFAULT CHARSET=utf8;
		");
		$this->db->query("
			ALTER TABLE `profile_notes`
				ADD CONSTRAINT `profile_notes_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
	}

	public function down()
	{
		$this->db->query("
			ALTER TABLE `profile_notes`
				DROP FOREIGN KEY `profile_notes_ibfk_1`;
		");
		$this->db->query("
			ALTER TABLE `profiles`
				DROP FOREIGN KEY `profiles_ibfk_1`;
		");
		$this->dbforge->drop_table('profile_notes');
		$this->dbforge->drop_table('profiles');
	}
	
}

