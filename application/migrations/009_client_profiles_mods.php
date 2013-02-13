<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Client_profiles_mods extends CI_Migration {

	public function up()
	{
		$this->db->query("
			ALTER TABLE `profile_notes`
				DROP FOREIGN KEY `profile_notes_ibfk_1`,
				CHANGE `profile_id` `site_id` int(11) NOT NULL;
		");
		$this->db->query("
			ALTER TABLE `profile_notes`
				ADD CONSTRAINT `profile_notes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `profile_tasks` (
				`profile_task_id` int(11) NOT NULL AUTO_INCREMENT,
				`site_id` int(11) NOT NULL,
				`due_date` date NOT NULL,
				`status` enum('Not Started','Pending','Completed') NOT NULL DEFAULT 'Not Started',
				`note` text NOT NULL,
				PRIMARY KEY (`profile_task_id`),
				INDEX (`site_id`),
				INDEX (`status`)
			) ENGINE = INNODB  DEFAULT CHARSET=utf8;
		");
		$this->db->query("
			ALTER TABLE `profile_tasks`
				ADD CONSTRAINT `profile_tasks_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
	}

	public function down()
	{
		$this->db->query("
			ALTER TABLE `profile_notes`
				DROP FOREIGN KEY `profile_notes_ibfk_1`,
				CHANGE `site_id` `profile_id` int(11) NOT NULL;
		");
		$this->db->query("
			ALTER TABLE `profile_notes`
				ADD CONSTRAINT `profile_notes_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`profile_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
		$this->db->query("
			ALTER TABLE `profile_tasks`
				DROP FOREIGN KEY `profile_tasks_ibfk_1`;
		");
		$this->dbforge->drop_table('profile_tasks');
	}
	
}

