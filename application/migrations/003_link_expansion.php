<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Link_expansion extends CI_Migration {

	public function up()
	{
		$this->db->query("
			CREATE TABLE `price_periods` (
				`period_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				`period` VARCHAR( 100 ) NOT NULL,
				UNIQUE (`period`)
			) ENGINE = INNODB  DEFAULT CHARSET=utf8;
		");
		$this->db->query("
			INSERT INTO `price_periods`
				(`period_id`,`period`)
			VALUES 
				(1,'Once'),
				(2,'Monthly'),
				(3,'Quarterly'),
				(4,'6 Months'),
				(5,'Yearly');
		");
		$this->db->query("
			ALTER TABLE `links`
				ADD `contact_by` VARCHAR( 100 ) NOT NULL AFTER `category_id`,
				ADD `price` INT( 4 ) NULL AFTER `contact_name`,
				ADD `price_period` INT( 11 ) NULL AFTER `price`,
				ADD INDEX (`price_period`),
				ADD CONSTRAINT `links_foreign_period` FOREIGN KEY (`price_period`) REFERENCES `price_periods` (`period_id`) ON DELETE SET NULL ON UPDATE CASCADE ;
		");
	}

	public function down()
	{
		$this->db->query("
			ALTER TABLE `links`
				DROP FOREIGN KEY `links_foreign_period`;
		");
		$this->db->query("
			ALTER TABLE `links`
				DROP `contact_by`,
				DROP `price`,
				DROP `price_period`;
		");
		$this->dbforge->drop_table('price_periods');
	}
	
}

