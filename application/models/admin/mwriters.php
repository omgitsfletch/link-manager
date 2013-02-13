<?php 
	class Mwriters extends CI_Model{
		
		function __construct(){
			parent::__construct();
		}
		
		
		/* ############### GET WRITERS #######################*/
		function get_writers($page = null,$params = array(),$flag = false){	

			if(!$flag){
				if($page==null)
					$this->wdb->limit($this->item_per_page);
				else
					$this->wdb->limit($this->item_per_page,($page-1)*$this->item_per_page);
			}		
			
			if(!empty($params)){
				$this->wdb->where($params);
			}
			$this->wdb->where('role','writer');
			$this->wdb->order_by('last_login','desc');
			$this->wdb->order_by('register_time','desc');
			return $this->wdb->get('writers')->result_array();			
		}
		
		function get_admin(){
			return $this->wdb->get('admin')->result_array();
		}
		
		function get_editor_profile($id = null){
			if($id){
				return $this->wdb->get_where('writers',array('id'=>$id))->result_array();
			}
		}
		
		function get_admin_profile($id = null){
			if($id){
				return $this->wdb->get_where('admin',array('id'=>$id))->result_array();
			}
		}
		
		function change_editor_password($old_password,$new_password){
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
		
		function update_editor($where = array(), $params = array()){
			if(!empty($where) && !empty($params)){
				foreach($where as $keys=>$values){
					$this->wdb->where($keys,$values);
				}
				$this->wdb->update('writers',$params);
			}
		}
		
		function change_admin_password($old_password,$new_password){
			$is_old_paswd_correct = $this->wdb->get_where('admin',array('id'=>$this->session->userdata('id'),'password'=>$old_password))->result_array();
			if(!empty($is_old_paswd_correct)){
				$this->wdb->where('id',$this->session->userdata('id'));
				$response  = $this->wdb->update('admin',array('password'=>$new_password));
				if($response)
					return true;
				else
					return false;
			}else
				return false;
		}
		
		function update_admin($where = array(), $params = array()){
			if(!empty($where) && !empty($params)){
				foreach($where as $keys=>$values){
					$this->wdb->where($keys,$values);
				}
				$this->wdb->update('admin',$params);
			}
		}
		
	}
?>