<?php 
	class Mw_article extends CI_Model{
		
		function __construct(){
			parent::__construct();
			
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
		
	    /* ############### GET CLAIMED ARTICLES #######################*/
		function get_claimed_article($params = array()){
			$this->wdb->select('claimed_articles.*');
			//$this->wdb->select('writers.name');
			$this->wdb->select('articles.topic,articles.length,articles.description');
			//$this->wdb->join('writers','claimed_articles.writer_id = writers.id');
			$this->wdb->join('articles','claimed_articles.article_id = articles.article_id');
			if(!empty($params)){
				$this->wdb->where($params);
			}
			$this->wdb->order_by('claimed_time','desc');
			return $this->wdb->get('claimed_articles')->result_array();
		}
		
		/* ############### GET ASSIGNED ARTICLES #######################*/
		function get_assigned_article($params = array()){
			$this->wdb->select('articles.*');
			//$this->wdb->select('writers.name');
			$this->wdb->select('assigned_articles.assigned_time');
			//$this->wdb->join('writers','claimed_articles.writer_id = writers.id');
			$this->wdb->join('articles','assigned_articles.article_id = articles.article_id');
			if(!empty($params)){
				$this->wdb->where($params);
			}
			$this->wdb->order_by('assigned_time','desc');
			return $this->wdb->get('assigned_articles')->result_array();
		}
		
		/* ############### GET SUBMITTED ARTICLES #######################*/
		function get_submitted_article($params = array()){
			$this->wdb->select('submitted_articles.*');
			//$this->wdb->select('writers.name');
			$this->wdb->select('articles.topic,articles.length');
			//$this->wdb->join('writers','submitted_articles.writer_id = writers.id');
			$this->wdb->join('articles','submitted_articles.article_id = articles.article_id');
			if(!empty($params)){
				$this->wdb->where($params);
			}
			$this->wdb->order_by('submitted_date','desc');
			return $this->wdb->get('submitted_articles')->result_array();
		}
		
		
		function get_new_articles($params = array()){
			if(!empty($params)){
				$this->wdb->where($params);
			}else{
				$this->wdb->where('status','new');
			}
			return $this->wdb->get('articles')->result_array();
		}
		
		function get_submitted_articles($params = array()){
			if(!empty($params)){
				$this->wdb->where($params);
			}
			return $this->wdb->get('submitted_articles')->result_array();
		}
		
		function claim_it($article_id){
			/*if(!empty($insert_array)){
				//print_r($insert_array); die();
				// Updating Status of article
				$this->wdb->where('article_id',$insert_array['article_id']);
				$this->wdb->update('articles',array('status'=>'claimed')) or die(mysql_error());
				
				// Inserting in claimed article queue
				$this->wdb->insert('claimed_articles',$insert_array) or die(mysql_error());
				return true;
			}*/
			if($article_id && is_numeric($article_id)){
				$article_data = $this->wdb->get_where('articles',array('article_id'=>$article_id,'status'=>'new'))->result_array();
				$insert_array = array(
										'writer_id'=>$this->session->userdata('id'),
										'article_id'=>$article_id,
										'claimed_time'=>date("Y-m-d H:i:s"),
										'due_time'=>$article_data['0']['due_date']
									);
				if($this->wdb->insert('claimed_articles',$insert_array)){
					// Updating Status of article
					$this->wdb->where('article_id',$article_id);
					if($this->wdb->update('articles',array('status'=>'claimed'))){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}			
			}else{
				return false;
			}
		}
		
		function unclaim_it($article_id){
			if($article_id && is_numeric($article_id)){
				if($this->wdb->delete('claimed_articles',array('article_id'=>$article_id,'writer_id'=>$this->session->userdata('id')))){
					// Updating Status of article
					$this->wdb->where('article_id',$article_id);
					if($this->wdb->update('articles',array('status'=>'new'))){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		function submit_article($insert_array = array()){
			if(!empty($insert_array)){				
				// Updating Status of article
				$this->wdb->where('article_id',$insert_array['article_id']);
				$this->wdb->update('articles',array('status'=>'submitted'));
		
				// Deleting from claimed article queue				
				$this->wdb->delete('claimed_articles',array('article_id'=>$insert_array['article_id'],'writer_id'=>$this->session->userdata('id')));
				
				// Inserting in submitted article queue
				$this->wdb->insert('submitted_articles',$insert_array);
			}
		}
		
		/* ############### GET DECLINED ARTICLES #######################*/
		function get_declined_article($params = array()){
			if(!empty($params)){
				$this->wdb->select('submitted_articles.* , declined_articles.decline_note,declined_articles.date as declined_date,articles.topic,articles.due_date,articles.length');
				$this->wdb->join('declined_articles','submitted_articles.article_id = declined_articles.article_id');
				$this->wdb->join('articles','submitted_articles.article_id = articles.article_id');
				$this->wdb->where('declined_articles.status','pending');
				return $this->wdb->get_where('submitted_articles',$params)->result_array();
			}
		}
		
		function submit_declined_article($where_params,$update_params){
			if(!empty($where_params) && !empty($update_params)){
				
				// Updating added article queue
				$this->wdb->where('article_id',$where_params['article_id']);
				$this->wdb->update('articles',array('status'=>'submitted'));
				
				// Updating Submitted article queue
				foreach($where_params as $key=>$value){
					$this->wdb->where($key,$value);
				}
				$this->wdb->update('submitted_articles',$update_params);
				
				// Updating Declined queue
				$this->wdb->where('article_id',$where_params['article_id']);
				$this->wdb->where('writer_id',$this->session->userdata('id'));
				$this->wdb->delete('declined_articles');
				
				// Updating rejection queue
				$where_array = array(
										'writer_id' => $this->session->userdata('id'),
										'article_id' =>$where_params['article_id']
									);
				$date_for_rejection = $this->wdb->get_where('rejections',$where_array)->result_array();
				$date = $date_for_rejection['0']['date'];
				$this->wdb->where('article_id',$where_params['article_id']);
				$this->wdb->where('writer_id',$this->session->userdata('id'));
				$this->wdb->where('date',$date);
				$this->wdb->update('rejections',array('status'=>'submitted','date'=>date('Y-m-d H:i:s')));
			}
		}
		
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
			return $this->wdb->get('submitted_articles')->result_array();
		}
		
		function claim_assigned_article($writer_id = null, $article_id = null){
			if($writer_id && $article_id && is_numeric($writer_id) && is_numeric($article_id)){
				$article_data = $this->wdb->get_where('articles',array('article_id'=>$article_id,'status'=>'assigned_0'))->result_array();
				$insert_array = array(
						'writer_id'=>$writer_id,
						'article_id'=>$article_id,
						'claimed_time'=>date("Y-m-d H:i:s"),
						'due_time'=>$article_data['0']['due_date']
				);
				if($this->wdb->insert('claimed_articles',$insert_array)){
					
					//Deleting from assigned queue
					$this->wdb->delete('assigned_articles',array('writer_id'=>$writer_id,'article_id'=>$article_id));
					
					// Updating Status of article
					$this->wdb->where('article_id',$article_id);
					if($this->wdb->update('articles',array('status'=>'claimed'))){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				
			}
		}
		
		function reject_assigned_article($writer_id = null, $article_id = null){
			if($writer_id && $article_id && is_numeric($writer_id) && is_numeric($article_id)){
				//Deleting from assigned queue
				$this->wdb->delete('assigned_articles',array('writer_id'=>$writer_id,'article_id'=>$article_id));
					
				// Updating Status of article
				$this->wdb->where('article_id',$article_id);
				if($this->wdb->update('articles',array('status'=>'new'))){
					return true;
				}else{
					return false;
				}
			}else{
		
			}
		}
		
		function get_can_claim(){
			$writer_id = $this->session->userdata('id');
			if($writer_id){
				$writer_info = $this->wdb->get_where('writers',array('id'=>$writer_id))->result_array();
				if(!empty($writer_info)){
					$claimed_info = $this->wdb->get_where('claimed_articles',array('writer_id'=>$writer_id))->result_array();
					if(!empty($claimed_info)){
						$max_claimable = $writer_info['0']['max_claimable'];
						$claimed_yet = count($claimed_info);
						if($claimed_yet < $max_claimable){
							return true;
						}else{
							return false;
						} 
					}else{
						return true;
					}
				}else{
					return false;
				}			
			}else{
				return false;
			}
		}
		
	}
?>