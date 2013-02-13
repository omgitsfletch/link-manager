<?php 
	class Marticle extends CI_Model{
		
		function __construct(){
			parent::__construct();
		}
		
		/* ############### GET ASSIGNED ARTICLES #######################*/
		function get_assigned_article($params = array(),$is_paginate = 0,$start = null,$limit = null){
			$this->wdb->select('assigned_articles.*');
			$this->wdb->select('writers.name');
			$this->wdb->select('articles.topic,articles.length,articles.due_date');
			$this->wdb->join('writers','assigned_articles.writer_id = writers.id');
			$this->wdb->join('articles','assigned_articles.article_id = articles.article_id');
			if(!empty($params)){
				$this->wdb->where($params);
			}
			if($is_paginate)
				$this->wdb->limit($limit,$start);
			$this->wdb->order_by('assigned_time','desc');
			return $this->wdb->get('assigned_articles')->result_array();
		}
		
		/* ############### GET SUBMITTED ARTICLES #######################*/
		function get_submitted_article($params = array(),$page=null,$filter_by = null,$filter_value = null){	
			$this->wdb->select('submitted_articles.*');
			$this->wdb->select('writers.name');
			$this->wdb->select('articles.topic,articles.length');
			$this->wdb->join('writers','submitted_articles.writer_id = writers.id');
			$this->wdb->join('articles','submitted_articles.article_id = articles.article_id');
			if(!empty($params)){
				$this->wdb->where($params);
			}
			if($filter_by && $filter_by == 'Group'){
				$this->wdb->where('articles.group_id',$filter_value);
			}elseif($filter_by && $filter_by == 'Writer'){
				$this->wdb->where('writer_id',$filter_value);
			}elseif($filter_by && $filter_by == 'Date'){
				$this->wdb->like('submitted_date',$filter_value,'after');
			}elseif($filter_by && $filter_by == 'All'){
			
			}
			$this->wdb->order_by('submitted_date','desc');
			if($page==null)
				$this->wdb->limit($this->item_per_page);
			else
				$this->wdb->limit($this->item_per_page,$page-1);
			return $this->wdb->get('submitted_articles')->result_array();			
		}
		
		/* ############### GET CLAIMED ARTICLES #######################*/
		function get_claimed_article($params = array(),$is_paginate = 0,$start = null,$limit = null){
			$this->wdb->select('claimed_articles.*');
			$this->wdb->select('writers.name');
			$this->wdb->select('articles.topic,articles.length');
			$this->wdb->join('writers','claimed_articles.writer_id = writers.id');
			$this->wdb->join('articles','claimed_articles.article_id = articles.article_id');
			if(!empty($params)){
				$this->wdb->where($params);
			}
			if($is_paginate)
				$this->wdb->limit($limit,$start);
			$this->wdb->order_by('claimed_time','desc');
			return $this->wdb->get('claimed_articles')->result_array();
		}
		
		/* ############### GET APPROVED ARTICLES #######################*/
		function get_approved_article($params = array(),$filter_by = null,$filter_value = null){
			$this->wdb->select('approved_articles.*');
			$this->wdb->select('writers.name');
			$this->wdb->select('submitted_articles.title,submitted_articles.content');
			$this->wdb->select('articles.topic,articles.length,articles.due_date');
			$this->wdb->join('writers','approved_articles.writer_id = writers.id');
			$this->wdb->join('articles','approved_articles.article_id = articles.article_id');
			$this->wdb->join('submitted_articles','approved_articles.article_id = submitted_articles.article_id');
			if(!empty($params)){
				$this->wdb->where($params);
			}
			if($filter_by && $filter_by == 'Group'){
				$this->wdb->where('articles.group_id',$filter_value);
			}elseif($filter_by && $filter_by == 'Writer'){
				$this->wdb->where('published_articles.writer_id',$filter_value);
			}elseif($filter_by && $filter_by == 'Date'){
				$this->wdb->like('approved_date',$filter_value,'after');
			}elseif($filter_by && $filter_by == 'All'){
					
			}
			$this->wdb->order_by('approval_date','desc');
			return $this->wdb->get('approved_articles')->result_array();
		}
		
		/* ############### GET PUBLISHED ARTICLES #######################*/
		function get_published_article($params = array(),$filter_by = null,$filter_value = null){
			$this->wdb->select('published_articles.*');
			$this->wdb->select('writers.name');
			$this->wdb->select('submitted_articles.title,submitted_articles.content');
			$this->wdb->select('articles.topic,articles.length,articles.due_date');
			$this->wdb->join('writers','published_articles.writer_id = writers.id');
			$this->wdb->join('articles','published_articles.article_id = articles.article_id');
			$this->wdb->join('submitted_articles','published_articles.article_id = submitted_articles.article_id');
			if(!empty($params)){
				$this->wdb->where($params);
			}
			if($filter_by && $filter_by == 'Group'){
				$this->wdb->where('articles.group_id',$filter_value);
			}elseif($filter_by && $filter_by == 'Writer'){
				$this->wdb->where('published_articles.writer_id',$filter_value);
			}elseif($filter_by && $filter_by == 'Date'){
				$this->wdb->like('published_date',$filter_value,'after');
			}elseif($filter_by && $filter_by == 'All'){
					
			}
			$this->wdb->order_by('published_date','desc');
			return $this->wdb->get('published_articles')->result_array();
		}
		
		/* ############### GET PUBLISHED ARTICLES #######################*/
		function get_rejected_articles($params = array(),$filter_by = null,$filter_value = null){
			$this->wdb->select('declined_articles.*');
			$this->wdb->select('writers.name');
			$this->wdb->select('submitted_articles.title,submitted_articles.content');
			$this->wdb->select('articles.topic,articles.length,articles.due_date');
			$this->wdb->join('writers','declined_articles.writer_id = writers.id');
			$this->wdb->join('articles','declined_articles.article_id = articles.article_id');
			$this->wdb->join('submitted_articles','declined_articles.article_id = submitted_articles.article_id');
			if(!empty($params)){
				$this->wdb->where($params);
			}
			if($filter_by && $filter_by == 'Group'){
				$this->wdb->where('articles.group_id',$filter_value);
			}elseif($filter_by && $filter_by == 'Writer'){
				$this->wdb->where('declined_articles.writer_id',$filter_value);
			}elseif($filter_by && $filter_by == 'Date'){
				$this->wdb->like('date',$filter_value,'after');
			}elseif($filter_by && $filter_by == 'All'){
					
			}
			$this->wdb->order_by('date','desc');
			return $this->wdb->get('declined_articles')->result_array();
		}
		
		/* ############### GET NEWLY AVAILABLE ARTICLES #######################*/
		function get_added_article($params = array(), $order_by = array(), $limit = null, $offset = null){
			if(!empty($params)){
				$this->wdb->where($params);
			}else{
				$this->wdb->where('status','new');
			}
			if(!empty($order_by)){
				foreach($order_by as $k=>$v){
					$this->wdb->order_by($k,$v);
				}
			}
			if($limit && $offset){
				$this->wdb->limit($limit,$offset);
			}
			elseif($limit){
				$this->wdb->limit($limit);
			}				
			return $this->wdb->get('articles')->result_array();
		}
		
		/* ############### REJECTING GIVEN SUBMITTED ARTICLES #######################*/
		function decline_this($inserting_array){
			if(!empty($inserting_array)){
				// Updating Status of added article
				$this->wdb->where('article_id',$inserting_array['article_id']);
				$this->wdb->update('articles',array('status'=>'declined'));
				
				// Updating Status of submitted article
				$this->wdb->where('article_id',$inserting_array['article_id']);
				$this->wdb->where('writer_id',$inserting_array['writer_id']);
				$this->wdb->update('submitted_articles',array('status'=>'declined'));
				
				//Updating Rejection count for this user
				$this->wdb->where('id',$inserting_array['writer_id']);
				$this->wdb->set('rejections','rejections+1',false);
				$this->wdb->update('writers');
				
				$this->wdb->insert('declined_articles',$inserting_array);
				
				$rejection_array = array(
											'writer_id' => $inserting_array['writer_id'],
											'article_id' => $inserting_array['article_id'],
											'status' => 'pending',
											'date' => date('Y-m-d H:i:s')
										);
				$this->wdb->insert('rejections',$rejection_array);
				return true;
			}
		}
		
		/* ############### APPROVING GIVEN SUBMITTED ARTICLES #######################*/
		function approve_this($approve_array){
			if(!empty($approve_array)){
				// Updating Status of added article
				$this->wdb->where('article_id',$approve_array['article_id']);
				$this->wdb->update('articles',array('status'=>'approved'));
		
				// Updating Status of submitted article
				$this->wdb->where('article_id',$approve_array['article_id']);
				$this->wdb->where('writer_id',$approve_array['writer_id']);
				$this->wdb->update('submitted_articles',array('status'=>'approved'));
		
				$this->wdb->insert('approved_articles',$approve_array);
				return true;
			}
		}
		
		/* ############### PUBLISHING GIVEN SUBMITTED ARTICLES #######################*/
		function publish_this($publish_array){
			if(!empty($publish_array)){
				// Updating Status of added article
				$this->wdb->where('article_id',$publish_array['article_id']);
				$this->wdb->update('articles',array('status'=>'published'));
		
				// Updating Status of submitted article
				$this->wdb->where('article_id',$publish_array['article_id']);
				$this->wdb->where('writer_id',$publish_array['writer_id']);
				$this->wdb->update('submitted_articles',array('status'=>'published'));
		
				$this->wdb->insert('published_articles',$publish_array);
				return true;
			}
		}
		
		/* ############### EDITING GIVEN SUBMITTED ARTICLES #######################*/
		function edit_this($edit_array,$where_array){
			if(!empty($edit_array) && !empty($where_array)){
				// Updating Status of added article
				foreach($where_array as $key=>$value){
					$this->wdb->where($key,$value);
				}
				
				$this->wdb->update('submitted_articles',$edit_array);
		
				return true;
			}
		}
		
		function get_submitted_with_writers($writer_id = null, $date = null, $filter_criteria = null){
			//$this->wdb->join('submitted_articles','submitted_articles.writer_id = writers.id');
			if($writer_id){
				$this->wdb->where('writer_id',$writer_id);
			}
			if($date && $filter_criteria == null){
				$this->wdb->like('submitted_articles.submitted_date',$date, 'after');
				//$this->wdb->where('submitted_articles.submitted_date',$date);
			}elseif($date && $filter_criteria){
				$this->wdb->where('submitted_articles.submitted_date >',$date);
			}else{
				$this->wdb->group_by('submitted_articles.writer_id');
			}
			$this->wdb->where('submitted_articles.status !=','declined');
			return $this->wdb->get('submitted_articles')->result_array();
		}
		
		/* ############### CHECKING FOR DUE DATE #######################*/		
		function check_due_date(){
				
			$claimed_articles = $this->wdb->get('claimed_articles')->result_array();
			if(!empty($claimed_articles)){
				foreach($claimed_articles as $key=>$values){
					  $claimed_time = strtotime($values['claimed_time']);
              		  $due_time = date('Y-m-d H:i:s', strtotime($values['claimed_time']. ' + '.$values['due_time'].' days'));
    				  // convert to unix timestamps
        			  $current_Time=strtotime(date('Y-m-d H:i:s'));
        			  $lastTime=strtotime($due_time);
        							
        			  $total_time = $lastTime - $claimed_time;   	
        			  $time_left = $lastTime - $current_Time;
					if($time_left <= 0){
						$this->wdb->where('article_id',$values['article_id']);
						$this->wdb->update('articles',array('status'=>'new'));
		
						// Deleting from claimed article queue
						$this->wdb->delete('claimed_articles',array('article_id'=>$values['article_id']));
					}
				}
			}
				
		}
		
		function get_item_per_page(){
			$data = $this->wdb->get('site_settings')->result_array();
			return $data['0']['item_per_page'];
		}
		
		function assign_it($insert_array){
			if(!empty($insert_array)){
				// Updating Avaialable Articles
				$this->wdb->where('article_id',$insert_array['article_id']);
				$this->wdb->update('articles',array('status'=>'assigned_0'));
				
				// Inserting into assigned article queue
				if($this->wdb->insert('assigned_articles',$insert_array)){
					return true;
				}else{
					$this->wdb->where('article_id',$insert_array['article_id']);
					$this->wdb->update('articles',array('status'=>'new'));
					return false;
				}
			}else{
				return false;
			}
		}
		
	}
?>