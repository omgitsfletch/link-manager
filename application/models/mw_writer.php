<?php 
	class Mw_writer extends CI_Model{
		
		function __construct(){
			parent::__construct();
			
		}
		
		/* ############### GET WRITER INFO #######################*/
		function get_profile($writer_id = null){
			if($writer_id){
				return $this->wdb->get_where('writers',array('id'=>$writer_id))->result_array();
			}
		}
		
		function update($where = array(), $params = array()){
			if(!empty($where) && !empty($params)){
				foreach($where as $keys=>$values){
					$this->wdb->where($keys,$values);
				}
				$this->wdb->update('writers',$params);
			}
		}
		
		function change_password($old_password,$new_password){
			$is_old_paswd_correct = $this->wdb->get_where('writers',array('id'=>$this->session->userdata('id'),'password'=>$old_password))->result_array();
			if(!empty($is_old_paswd_correct)){
				$this->wdb->where('id',$this->session->userdata('id'));
				$response  = $this->wdb->update('writers',array('password'=>$new_password));
				if($response)
					return true;
				else 
					return false;
			}else
				return false;
		}
		
		function get_graph(){
			$graph = array();
			for($i = 0; $i < 10 ; $i++){
				$date = date("Y-m-d",strtotime("-".$i." day"));
				$timestamp = strtotime($date);
				$this->wdb->where('status !=','declined');
				$this->wdb->like('submitted_date',$date,'after');
				$submitted = $this->wdb->get_where('submitted_articles',array('writer_id'=>$this->session->userdata('id')))->result_array();
				$total_count = count($submitted);
				$graph[$i]['date'] = date('D', $timestamp)." ".date('d-m',$timestamp);
				$graph[$i]['count'] = $total_count;
			}
			return $graph;
		}
		
	}
?>