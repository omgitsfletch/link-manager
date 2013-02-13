<?php 
	class Mreports extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		function get_reports($start_date = null,$end_date = null,$flag = null,$start = null,$limit = null){
			$report = array();
			$filter = false;
			if($start_date && $end_date)
				$filter = true;

			if($flag){
				$this->wdb->limit($limit,$start);
			}
			
			$writers = $this->wdb->get_where('writers',array('status'=>1,'role'=>'writer'))->result_array();
			
			if(!empty($writers)){
				
				$i = 0;
				
				foreach($writers as $writer){
					// --------------------- Fetching Approved Articles -----------------------//
					if($filter){
						$this->wdb->where('approval_date >=',$start_date);
						$this->wdb->where('approval_date <=',$end_date);
					}else{
						$current_date = date("Y-m");
						$this->wdb->like('approval_date',$current_date,'after');
					}
					$this->wdb->join('approved_articles','submitted_articles.article_id = approved_articles.article_id');
					$approved = $this->wdb->get_where('submitted_articles',array('submitted_articles.writer_id'=>$writer['id'],'submitted_articles.status'=>'approved'))->result_array();
					$approved_words = 0;
					if(!empty($approved)){
						foreach($approved as $values){
							$content = $values['content'];
							$content = str_replace('  ',' ',$content);
							$words_in_content = explode(' ',$content);
							$approved_words = $approved_words + count($words_in_content);
						}
					}
					// ------------------------------------------------------------------------//
					
					// --------------------- Fetching Published Articles -----------------------//
					if($filter){
						$this->wdb->where('published_date >=',$start_date);
						$this->wdb->where('published_date <=',$end_date);
					}else{
						$current_date = date("Y-m");
						$this->wdb->like('published_date',$current_date,'after');
					}
					$this->wdb->join('published_articles','submitted_articles.article_id = published_articles.article_id');
					$published = $this->wdb->get_where('submitted_articles',array('submitted_articles.writer_id'=>$writer['id'],'submitted_articles.status'=>'published'))->result_array();
					// ------------------------------------------------------------------------//
					
					// --------------------- Fetching Submitted Articles -----------------------//
					if($filter){
						$this->wdb->where('submitted_date >=',$start_date);
						$this->wdb->where('submitted_date <=',$end_date);
					}else{
						$current_date = date("Y-m");
						$this->wdb->like('submitted_date',$current_date,'after');
					}
					$submitted = $this->wdb->get_where('submitted_articles',array('submitted_articles.writer_id'=>$writer['id'],'submitted_articles.status'=>'pending'))->result_array();
					// ------------------------------------------------------------------------//
					
					// --------------------- Fetching Declined Articles -----------------------//
					if($filter){
						$this->wdb->where('date >=',$start_date);
						$this->wdb->where('date <=',$end_date);
					}else{
						$current_date = date("Y-m");
						$this->wdb->like('date',$current_date,'after');
					}
					$this->wdb->join('declined_articles','submitted_articles.article_id = declined_articles.article_id');
					$declined = $this->wdb->get_where('submitted_articles',array('submitted_articles.writer_id'=>$writer['id'],'submitted_articles.status'=>'declined'))->result_array();
					
					// --------------------- Fetching Timeouts -----------------------//
					if($filter){
						$this->wdb->where('date >=',$start_date);
						$this->wdb->where('date <=',$end_date);
					}else{
						$current_date = date("Y-m");
						$this->wdb->like('date',$current_date,'after');
					}
					$timeouts = $this->wdb->get_where('time_outs',array('writer_id'=>$writer['id']))->result_array();
					
					$total_rejections = $this->wdb->get_where('rejections',array('writer_id'=>$writer['id']))->result_array();
					$report[$i]['id'] = $writer['id'];
					$report[$i]['name'] = $writer['name'];
					$report[$i]['timeouts'] = $writer['time_outs'];
					$report[$i]['rejections'] = $writer['rejections'];
					$report[$i]['approved'] = count($approved);
					$report[$i]['published'] = count($published);
					$report[$i]['submitted'] = count($submitted);
					$report[$i]['rejected'] = count($declined);
					$report[$i]['timeouts'] = count($timeouts);
					$report[$i]['total_rejections'] = count($total_rejections);
					$report[$i]['words'] = $approved_words;
					$i++;
				}
			}
			return $report;
		}
		
		function get_detail_report($writer_id = null,$start_date = null,$end_date = null){
			$filter = false;
			if($start_date && $end_date)
				$filter = true;
			$detail = array();
			if($writer_id && is_numeric($writer_id)){
				// --------------------- Fetching Approved Articles -----------------------//
				if($filter){
					$this->wdb->where('approval_date >=',$start_date);
					$this->wdb->where('approval_date <=',$end_date);
				}else{
					$current_date = date("Y-m");
					$this->wdb->like('approval_date',$current_date,'after');
				}
				$this->wdb->join('approved_articles','submitted_articles.article_id = approved_articles.article_id');
				$approved = $this->wdb->get_where('submitted_articles',array('submitted_articles.writer_id'=>$writer_id,'submitted_articles.status'=>'approved'))->result_array();
				$approved_words = 0;
				if(!empty($approved)){
					foreach($approved as $values){
						$content = $values['content'];
						$content = str_replace('  ',' ',$content);
						$words_in_content = explode(' ',$content);
						$approved_words = $approved_words + count($words_in_content);
					}
				}
				$detail['approved_count'] = count($approved);
				$detail['approved_words'] = $approved_words;
				// ------------------------------------------------------------------------//
					
				// --------------------- Fetching Published Articles -----------------------//
				if($filter){
					$this->wdb->where('published_date >=',$start_date);
					$this->wdb->where('published_date <=',$end_date);
				}else{
					$current_date = date("Y-m");
					$this->wdb->like('published_date',$current_date,'after');
				}
				$this->wdb->join('published_articles','submitted_articles.article_id = published_articles.article_id');
				$published = $this->wdb->get_where('submitted_articles',array('submitted_articles.writer_id'=>$writer_id,'submitted_articles.status'=>'published'))->result_array();
				$published_words = 0;
				if(!empty($published)){
					foreach($published as $values){
						$content = $values['content'];
						$content = str_replace('  ',' ',$content);
						$words_in_content = explode(' ',$content);
						$published_words = $published_words + count($words_in_content);
					}
				}
				$detail['published_count'] = count($published);
				$detail['published_words'] = $published_words;
				// ------------------------------------------------------------------------//
					
				// --------------------- Fetching Submitted Articles -----------------------//
				if($filter){
					$this->wdb->where('submitted_date >=',$start_date);
					$this->wdb->where('submitted_date <=',$end_date);
				}else{
					$current_date = date("Y-m");
					$this->wdb->like('submitted_date',$current_date,'after');
				}
				$submitted = $this->wdb->get_where('submitted_articles',array('submitted_articles.writer_id'=>$writer_id,'submitted_articles.status'=>'pending'))->result_array();
				$submitted_words = 0;
				if(!empty($submitted)){
					foreach($submitted as $values){
						$content = $values['content'];
						$content = str_replace('  ',' ',$content);
						$words_in_content = explode(' ',$content);
						$submitted_words = $submitted_words + count($words_in_content);
					}
				}
				$detail['submitted_count'] = count($submitted);
				$detail['submitted_words'] = $submitted_words;
				// ------------------------------------------------------------------------//
				
				// --------------------- Fetching Writers Information -----------------------//
				$writer_info = $this->wdb->get_where('writers',array('id'=>$writer_id))->result_array();
				$detail['writer_name'] = $writer_info['0']['name'];
				$detail['writer_id'] = $writer_id;
				// --------------------------------------------------------------------------//
					
			}
			return $detail;
		}
	}
?>