<?php
 class Cron extends CI_Controller{
 	function __construct(){
 		parent:: __construct();
 		$this->wdb = $this->load->database('writer', TRUE);
 	}
 	
 	function index(){
 		
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
 		
 					// Inserting In Time Out Queue
 					$insert_array = array(
 											'writer_id'=> $values['writer_id'],
 											'article_id'=> $values['article_id'],
 											'date' => date('Y-m-d H:i:s')
 										);
 					$this->wdb->insert('time_outs',$insert_array);
 					
 					// Deleting from claimed article queue
 					$this->wdb->delete('claimed_articles',array('article_id'=>$values['article_id']));
 					
 					//Updating number of timeouts for this user
 					$this->wdb->where('id',$values['writer_id']);
 					$this->wdb->set('time_outs','time_outs+1',false);
 					$this->wdb->update('writers');
 				}
 			}
 		}
 		
 		$this->wdb->select('declined_articles.*');
 		$this->wdb->select('submitted_articles.claimed_date,submitted_articles.due_date');
 		$this->wdb->join('submitted_articles','submitted_articles.article_id = declined_articles.article_id');
 		$this->wdb->where('submitted_articles.status','declined');
 		$this->wdb->where('declined_articles.status','pending');
 		$declined_articles = $this->wdb->get('declined_articles')->result_array();
 		if(!empty($declined_articles)){
 			foreach($declined_articles as $key=>$values){
 				
 				$claimed_time = strtotime($values['declined_date']);
 				$due_time = date('Y-m-d H:i:s', strtotime($values['declined_date']. ' + '.$values['due_date'].' days'));
 				// convert to unix timestamps
 				$current_Time=strtotime(date('Y-m-d H:i:s'));
 				$lastTime=strtotime($due_time);
 		
 				$total_time = $lastTime - $claimed_time;
 				$time_left = $lastTime - $current_Time;
 				if($time_left <= 0){
 					$this->wdb->where('article_id',$values['article_id']);
 					$this->wdb->update('articles',array('status'=>'new'));
 						
 					// updating declined article queue
 					$this->wdb->where('declined_articles.article_id',$values['article_id']);
 					$this->wdb->where('declined_articles.status','pending');
 					$this->wdb->delete('declined_articles');
 					
 					$insert_array = array(
 							'writer_id'=> $values['writer_id'],
 							'article_id'=> $values['article_id'],
 							'date' => date('Y-m-d H:i:s')
 					);
 					$this->wdb->insert('time_outs',$insert_array);
 					
 					$insert_array['status'] = 'timeout';
 					$this->wdb->insert('rejections',$insert_array);
 					
 					// Deleting from submitted article queue
 					$this->wdb->delete('submitted_articles',array('article_id'=>$values['article_id']));
 		
 					//Updating number of timeouts for this user
 					$this->wdb->where('id',$values['writer_id']);
 					$this->wdb->set('time_outs','time_outs+1',false);
 					$this->wdb->update('writers');
 				}
 			}
 		}
 	}
 	
 }