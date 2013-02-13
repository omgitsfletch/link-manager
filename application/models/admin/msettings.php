<?php 
	class Msettings extends CI_Model{
		
		function __construct(){
			parent::__construct();
		}
		
		function get_copyscape_settings(){
			return $this->wdb->get('site_settings')->result_array();
		}
		
		function get_group_settings($is_paginate = false, $page = null){
			
			if($is_paginate){
				if($page==null)
					$this->wdb->limit(10);
				else
					$this->wdb->limit(10,($page-1)*10);
			}
			$this->wdb->order_by('date_added','DESC');
			return $this->wdb->get('groups_articles')->result_array();
		}
		
		function update_copyscape_settings($update_array){
			if(!empty($update_array)){
				$this->wdb->update('site_settings',$update_array);
				return true;
			}
		}
		
		function add_group($insert_array){
			if(!empty($insert_array)){
				$this->wdb->insert('groups_articles',$insert_array);
				return true;
			}
		}
		
		function update_group($group_id,$group_name){
			if($group_id && $group_name){
				$this->wdb->where('group_id',$group_id);
				$this->wdb->update('groups_articles',array('name'=>$group_name));
			}
		}
		
		function get_graph(){
			$graph = array();
			for($i = 0; $i < 10 ; $i++){
				$date = date("Y-m-d",strtotime("-".$i." day"));
				$timestamp = strtotime($date);
				$this->wdb->like('submitted_date',$date,'after');
				$this->wdb->where('status !=','declined');
				$submitted = $this->wdb->get('submitted_articles')->result_array();
				$total_count = count($submitted);
				$graph[$i]['date'] = date('D', $timestamp)." ".date('d-m',$timestamp);
				$graph[$i]['count'] = $total_count;
			}
			return $graph;
		}
	}
?>