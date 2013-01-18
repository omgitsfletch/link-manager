<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Initial_setup extends CI_Migration {

	public function up()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `users` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`username` varchar(50) NOT NULL,
				`password_hash` char(32) NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `username` (`username`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
		");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `sites` (
				`site_id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,
				`url` varchar(100) NOT NULL,
				`default` tinyint(1) NOT NULL DEFAULT '0',
				PRIMARY KEY (`site_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
		");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `links` (
				`link_id` int(11) NOT NULL AUTO_INCREMENT,
				`site_id` int(11) NOT NULL,
				`url` varchar(100) NOT NULL,
				`text` varchar(100) NOT NULL,
				`type_id` int(11) DEFAULT NULL,
				`status_id` int(11) DEFAULT NULL,
				`category_id` int(11) DEFAULT NULL,
				`contact_email` varchar(100) NOT NULL,
				`contact_name` varchar(100) NOT NULL,
				`date` date NOT NULL,
				`location` varchar(100) NOT NULL,
				`notes` tinytext NOT NULL,
				PRIMARY KEY (`link_id`),
				KEY `status_id` (`status_id`),
				KEY `category_id` (`category_id`),
				KEY `site_id` (`site_id`),
				KEY `type_id` (`type_id`),
				KEY `contact_email` (`contact_email`),
				KEY `contact_name` (`contact_name`),
				KEY `location` (`location`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
		");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `categories` (
				`category_id` int(11) NOT NULL AUTO_INCREMENT,
				`category` varchar(100) NOT NULL,
				PRIMARY KEY (`category_id`),
				UNIQUE KEY `category` (`category`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
		");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `statuses` (
				`status_id` int(11) NOT NULL AUTO_INCREMENT,
				`status` varchar(100) NOT NULL,
				PRIMARY KEY (`status_id`),
				UNIQUE KEY `status` (`status`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
		");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `types` (
				`type_id` int(11) NOT NULL AUTO_INCREMENT,
				`type` varchar(100) NOT NULL,
				PRIMARY KEY (`type_id`),
				UNIQUE KEY `type` (`type`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
		");
		$this->db->query("
			ALTER TABLE `links`
				ADD CONSTRAINT `links_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `types` (`type_id`) ON DELETE SET NULL ON UPDATE CASCADE,
				ADD CONSTRAINT `links_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`status_id`) ON DELETE SET NULL ON UPDATE CASCADE,
				ADD CONSTRAINT `links_ibfk_4` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
				ADD CONSTRAINT `links_ibfk_5` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON DELETE CASCADE ON UPDATE CASCADE;
		");
	

		// $this->db->query("
			// INSERT INTO `categories` (`category_id`, `category`) VALUES
				// (1, 'Computers'),
				// (2, 'Movies'),
				// (3, 'Music'),
				// (4, 'Video Games');
		// ");
		// $this->db->query("
			// INSERT INTO `statuses` (`status_id`, `status`) VALUES
				// (1, 'Active'),
				// (2, 'Inactive');
		// ");
		// $this->db->query("
			// INSERT INTO `types` (`type_id`, `type`) VALUES
				// (1, 'Cool'),
				// (2, 'Hilarious'),
				// (3, 'Lame'),
				// (4, 'test');
		// ");
		$this->db->query("
			INSERT INTO `sites` (`site_id`, `name`, `url`, `default`) VALUES
				(1, 'Default', 'www.default.com', 1)
		");
		// $this->db->query("
			// INSERT INTO `links` (`link_id`, `site_id`, `url`, `text`, `type_id`, `status_id`, `category_id`, `contact_email`, `contact_name`, `date`, `location`, `notes`) VALUES
				// (1, 1, 'http://www.a.com', 'oyfg', 1, 1, 1, 'jfletch@gmail.com', 'Jason Fletcher', '2012-04-27', 'asdasdas', ''),
				// (2, 1, 'http://www.f.com', 'qweqed', 1, 2, 2, 'jfletch@gmail.com', 'Jason Fletcher', '2012-03-28', 'asdasdas', 'asdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdadasdad'),
				// (3, 1, 'http://www.c.com', 'vbhfg', 1, 2, 2, 'jfletch@gmail.com', 'John Smith', '2012-01-27', 'asdasdas', ''),
				// (4, 1, 'http://www.b.com', 'rwerw', 1, 1, 3, 'jfletch@gmail.com', 'John Smith', '2012-07-04', 'asdasdas', ''),
				// (5, 1, 'http://www.q.com', 'vbxcv', 1, 1, 1, 'jfletch@gmail.com', 'John Smith', '2012-07-22', 'asdasdas', ''),
				// (6, 1, 'http://www.z.com', 'tert', 2, 2, 2, 'jfletch@gmail.com', 'John Smith', '1912-07-27', 'asdasdas', ''),
				// (7, 1, 'http://www.v.com', 'asda', 3, 1, 1, 'jfletch@gmail.com', 'John Smith', '2013-07-27', 'asdasdas', ''),
				// (8, 1, 'http://www.u.com', 'bha', 4, 2, 4, 'jfletch@gmail.com', 'John Smith', '2011-07-27', 'asdasdas', '');
		// ");
		$this->db->query("
			INSERT INTO `users` (`id`, `username`, `password_hash`) VALUES
				(1, 'admin', '397bc74869cae58efb31dffa0287c892');
		");
	}

	public function down()
	{
		$this->dbforge->drop_table('categories');
		$this->dbforge->drop_table('types');
		$this->dbforge->drop_table('statuses');
		$this->dbforge->drop_table('links');
		$this->dbforge->drop_table('sites');
		$this->dbforge->drop_table('users');
	}
	
}