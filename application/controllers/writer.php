<?php
 class Writer extends CI_Controller{
 	function __construct(){
 		parent:: __construct();
 		
 		$this->wdb = $this->load->database('writer', TRUE);
 		
 		$this->load->model('Mw_article');
 		$this->load->model('Mw_writer');
 		//$this->Mw_article->check_due_date();
 		//date_default_timezone_set('Asia/Calcutta');
 	}
 	
 	function index(){
 		
 		/*if($this->session->userdata('logged_in') && $this->session->userdata('user_id')){
 			$ziffen_user_id = $this->session->userdata('user_id');
 			$ziffen_group_id = $this->session->userdata('group_id');
 			$is_visited = $this->wdb->get_where('writers',array('ziffen_user_id'=>$ziffen_user_id, 'ziffen_group_id'=>$ziffen_group_id))->resul_array();
 			
 			if(!empty($is_visited)){// If user visited aur application earlier
 				$data=array('id'=>$is_visited[0]['id'],'role'=>'writer','global_user'=>1);
 				$this->session->set_userdata($data);
 			}else{ // If user not visited aur application earlier
 				// Inserting one row for this user
 				$insert_array = array('ziffen_user_id'=>$ziffen_user_id,'ziffen_group_id'=>$ziffen_group_id,'username'=>$this->session->userdata('username'));
 				$this->wdb->insert('writers',$insert_array);
 				$last_inserted_id = $this->wdb->insert_id();
 				$data=array('id'=>$last_inserted_id,'role'=>'writer','global_user'=>1);
 				$this->session->set_userdata($data);
 			}
 			redirect(base_url().'writer/dashboard');
 		}else{*/
 			if($this->input->cookie('role') && $this->input->cookie('id') && $this->input->cookie('username')){
 				$data=array('id'=>$this->input->cookie('id'),'username'=>$this->input->cookie('username'),'role'=>$this->input->cookie('role'));
 				$this->session->set_userdata($data);
 				/*if($this->input->cookie('role')==1){
 				 redirect('mybook/writer/'.$this->input->cookie('name'));
 				}else{
 				redirect('user/my_account/'.$this->input->cookie('name'));
 				}*/
 				redirect(base_url().'writer/dashboard');
 			
 			}
 				
 			if($this->session->userdata('id') && $this->session->userdata('role') == 'writer'){
 				redirect(base_url().'writer/dashboard');
 			}
 			$data['name'] = '';
 			$data['error'] = '';
 			if($this->input->post('submit')){
 				$this->form_validation->set_rules('username', 'Username', 'required');
 				$this->form_validation->set_rules('password', 'Password', 'required');
 					
 				if ($this->form_validation->run() == FALSE){
 				}
 				else
 				{
 					$arr=array(
 							'username'=>$this->input->post('username'),
 							'password'=>$this->input->post('password')
 					);
 					$query=$this->wdb->get_where('writers',$arr);
 					if($query->result_array()){
 			
 						$val= $query->result_array();
 			
 						if($val[0]['status']){
 							$data=array('id'=>$val[0]['id'],'username'=>$val[0]['username'],'role'=>$val[0]['role']);
 							$this->session->set_userdata($data);
 			
 							if($this->input->post('remember')){
 								$this->input->set_cookie('role',$val[0]['role'],'3600');
 								$this->input->set_cookie('name',$val[0]['username'],'3600');
 								$this->input->set_cookie('id',$val[0]['id'],'3600');
 							}
 								
 							//Updating Last Login Value
 							$this->wdb->where('id',$val[0]['id']);
 							$this->wdb->update('writers',array('last_login'=>date('Y-m-d H:i:s')));
 							//echo $this->wdb->last_query(); die();
 							if($val[0]['role']=='editor'){
 								redirect(base_url().'editor/dashboard');
 							}
 							redirect(base_url().'writer/dashboard');
 						}else{
 							$data['name'] = $val[0]['name'];
 						}
 					}else{
 						$data['error'] = _("Invalid Username or Password");
 					}
 				}
 			}
 			$this->load->view('writer/login',$data);
 		//}
 		
 	}
 	
 	function dashboard(){
 		if($this->session->userdata('id') != 0 && $this->session->userdata('role') && $this->session->userdata('role') == "writer"){
 			$todays_date = date("Y-m-d");
 			
 			$todays_submitted = $this->Mw_article->get_submitted_with_writers($this->session->userdata('id'),$todays_date);
 			$writer_infos['todays'] = count($todays_submitted);
 					
 			$yesterday = strtotime ( '-1 day' , strtotime ( $todays_date ) ) ;
 			$yesterday = date ( 'Y-m-d' , $yesterday );
 			$yesterdays_submitted = $this->Mw_article->get_submitted_with_writers($this->session->userdata('id'),$yesterday);
 			$writer_infos['yesterday'] = count($yesterdays_submitted);
 					
 			$last_7_day = strtotime ( '-7 day' , strtotime ( $todays_date ) ) ;
 			$last_7_day = date ( 'Y-m-d' , $last_7_day );
 			$last_7_day_submitted = $this->Mw_article->get_submitted_with_writers($this->session->userdata('id'),$last_7_day,'greater');
 			$writer_infos['last_7_day'] = count($last_7_day_submitted);
 					
 			$this_month = substr($todays_date,0,7);
 			$this_month_submitted = $this->Mw_article->get_submitted_with_writers($this->session->userdata('id'),$this_month);
 			$writer_infos['this_month'] = count($this_month_submitted);
 			$data['graph'] = $this->Mw_writer->get_graph();
 			$data['infos'] = $writer_infos;
 			$data['page_title'] = "Dashboard";
 			$this->load->view('writer/writer_dashboard',$data);
 		}else{
 			redirect(base_url().'writer');
 		} 			
 	} 	
 	
 	function articles(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'writer'){
 			$data['claimed_article_info'] = $this->Mw_article->get_claimed_article(array('claimed_articles.writer_id'=>$this->session->userdata('id')));
 			//echo $this->wdb->last_query(); die();
			$data['available_article_info'] = $this->Mw_article->get_added_article(array(),array('date'=>'desc'));
			//echo $this->wdb->last_query(); die();
			$data['assigned_article_info'] = $this->Mw_article->get_assigned_article(array('assigned_articles.writer_id'=>$this->session->userdata('id')));
			$data['can_claim'] = $this->Mw_article->get_can_claim();
			$data['page_title'] = "Articles";
			$this->load->view('writer/writer_articles',$data);
 		}else{
 			redirect(base_url().'writer');
 		}
 	}
 	
 	function assigned(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'writer'){
 			$data['article_info'] = $this->Mw_article->get_assigned_article(array('assigned_articles.writer_id'=>$this->session->userdata('id')));
 			$data['page_title'] = "Assigned articles";
 			$this->load->view('writer/writer_assigned',$data);
 		}else{
 			redirect(base_url().'writer');
 		}
 	}
 	
 	function claim_assigned($article_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'writer'){
 			if($article_id && is_numeric($article_id)){
 				if($this->Mw_article->claim_assigned_article($this->session->userdata('id'),$article_id)){
 					$writer = $this->Mw_writer->get_profile($this->session->userdata('id'));
 					$this->load->model('admin/Mwriters');
 					$admin = $this->Mwriters->get_admin();

 					$this->load->library('utilities');
 					$this->load->helper('phpmailer');
 					
 					$msg = '';
 					$msg .= '<html><head></head><body><h1>Dear '.$admin['0']['name'].'</h1><br />';
 					$msg .= '<p>'.$writer['0']['name'].' has claimed one of the article assigned to him</p>';
 					$msg .= '<p>Thank you.</p>';
 					$msg .= '</body></html>';
 					$mail_subject = 'Accepted Assigned Article';
 					send_email( $admin['0']['email'], $writer['0']['email'], $mail_subject, $msg);
 				}
 				redirect(base_url().'writer/articles');
 			}else{
 				redirect(base_url().'writer/articles');
 			} 			
 		}else{
 			redirect(base_url().'writer');
 		}
 	}
 	
 	function reject_assigned($article_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'writer'){
 			if($article_id && is_numeric($article_id)){
 				if($this->Mw_article->reject_assigned_article($this->session->userdata('id'),$article_id)){
 					$writer = $this->Mw_writer->get_profile($this->session->userdata('id'));
 					$this->load->model('admin/Mwriters');
 					$admin = $this->Mwriters->get_admin();
 						
 					$this->load->library('utilities');
 					$this->load->helper('phpmailer');
 					$msg = '';
 					$msg .= '<html><head></head><body><h1>Dear '.$admin['0']['name'].'</h1><br />';
 					$msg .= '<p>'.$writer['0']['name'].' has rejects one of the article assigned to him</p>';
 					$msg .= '<p>Thank you.</p>';
 					$msg .= '</body></html>';
 					$mail_subject = 'Rejected Assigned Article';
 					send_email( $admin['0']['email'], $writer['0']['email'], $mail_subject, $msg);
 				}
 				redirect(base_url().'writer/articles');
 			}else{
 				redirect(base_url().'writer/articles');
 			}
 		}else{
 			redirect(base_url().'writer');
 		}
 	}
 	
 	function testing(){
 		echo date('Y-m-d H:i:s a');
 		die(); 		
 	} 	
 	
 	function registration(){
 		
 		if($this->input->post('submit')){
 			//echo "sjau"; die();
 			$this->form_validation->set_rules('name', 'Name', 'required');
 			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[writers.username]');
 			$this->form_validation->set_rules('password', 'Password', 'required');
 			$this->form_validation->set_rules('repassword', 'Password Confirmation', 'required|matches[password]');
 			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[writers.email]');
 			$this->form_validation->set_rules('sex', 'Sex', 'required');
 			$this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
 				
 			if ($this->form_validation->run() == FALSE)
 			{
 			}
 			else
 			{
 				/*if($this->input->post('word')===$this->input->post('captcha')){*/
 					$arr=array(
 							'name'=>$this->input->post('name'),
 							'username'=>$this->input->post('username'), 							
 							'password'=>$this->input->post('password'),
 							'email'=>$this->input->post('email'),
 							'phone'=>$this->input->post('phone'),
 							'sex'=>$this->input->post('sex'),
 							'role'=>$this->input->post('role'),
 							'register_time'=>date('Y-m-d H:i:s')
 							);
 					$this->wdb->insert('writers',$arr);
 					redirect(base_url().'writer');
 				/*}else{
 					$data['error']=_("Please Re-enter the Captcha word");
 				}*/
 					
 			}
 		}
 		
 		/*$vals = array(
 				'img_path' => dirname(__FILE__).'../../assets/captcha/',
 				'img_url' => base_url('assets/captcha').'/',
 				'expiration' => 300
 		);
 		$cap = create_captcha($vals);
 		$data['capt']=$cap;*/
 		$this->load->view('writer/registration');
 	}
 	 	
 	function change_captcha(){
 		$vals = array(
 				'img_path' => '/var/www/html/training/mybook/assets/captcha/',
 				'img_url' => base_url('assets/captcha').'/',
 				'expiration' => 300
 		);
 		$cap = create_captcha($vals);
 		$arr=array('word'=>$cap['word'], 'image'=>$cap['image']);
 		echo json_encode($arr);	
 	}
 	
 	function available($article_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'writer'){
 			if($article_id && is_numeric($article_id)){
 				$data['article_info'] = $this->Mw_article->get_added_article(array('article_id'=>$article_id));
 				$data['page_title'] = "Available articles";
 				$this->load->view('writer/article_details',$data);
 			}else{
 				$data['article_info'] = $this->Mw_article->get_added_article(array(),array('date'=>'desc'));
 				$data['page_title'] = "Available articles";
 				$this->load->view('writer/writer_available',$data);
 			}
 		}
 	}
 	
 	function claimed(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'writer'){
 			$data['article_info'] = $this->Mw_article->get_claimed_article(array('claimed_articles.writer_id'=>$this->session->userdata('id')));
 			$data['page_title'] = "Claimed articles";
 			$this->load->view('writer/writer_claimed',$data);
 		}
 	}
 	
 	function declined($article_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'writer'){
 			if($article_id){
 				if(is_numeric($article_id)){
 					$params= array(
 							'submitted_articles.writer_id'=>$this->session->userdata('id'),
 							'submitted_articles.article_id'=>$article_id,
 							'submitted_articles.status'=>'declined'
 					);
 					$data['article_info'] = $this->Mw_article->get_declined_article($params);
 					$data['info_required'] = $this->Mw_article->get_added_article(array('article_id'=>$article_id,'status'=>'declined'));
 					$data['page_title'] = "Declined articles edit";
 					$this->load->view('writer/declined_edit',$data);
 				} 				
 			}else{
 				$params= array(
 						'submitted_articles.writer_id'=>$this->session->userdata('id'),
 						'submitted_articles.status'=>'declined'
 				);
 				$data['article_info'] = $this->Mw_article->get_declined_article($params);
 				$data['page_title'] = "Declined articles";
 				$this->load->view('writer/writer_decline',$data);
 			}
 		}
 	}
 	
 	function submitted(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'writer'){
			$data['article_info'] = $this->Mw_article->get_submitted_article(array('submitted_articles.writer_id'=>$this->session->userdata('id')));
			$data['page_title'] = "Submitted articles";
			$this->load->view('writer/writer_submitted',$data);
 		}
 	}
 	
 	function claim_article($article_id = null){
 		if($this->session->userdata('id') != 0 && $this->session->userdata('role') && $this->session->userdata('role') == "writer"){
 			if($article_id && is_numeric($article_id)){
 				$response = $this->Mw_article->claim_it($article_id);
 				
 				if($response){
 					redirect(base_url().'writer/articles');
 				}else{
 					redirect(base_url().'writer/dashboard');
 				}
 			}elseif($this->input->post('claim_button') == 'claim'){
 				
 				$response = $this->Mw_article->claim_it($this->input->post('article_id'));
 				
 				if($response){
 					redirect(base_url().'writer/articles');
 				}else{
 					redirect(base_url().'writer/dashboard');
 				} 				
 				
 			}else{
 				redirect(base_url().'writer/dashboard');
 			} 			
 		}else{
 			redirect(base_url().'writer');
 		} 		
 	}
 	
 	function unclaim($article_id = null){
 		if($this->session->userdata('id') != 0 && $this->session->userdata('role') && $this->session->userdata('role') == "writer"){
 			if($article_id && is_numeric($article_id)){
 				$response = $this->Mw_article->unclaim_it($article_id);
 					
 				if($response){
 					redirect(base_url().'writer/articles');
 				}else{
 					redirect(base_url().'writer/dashboard');
 				}
 					
 			}else{
 				redirect(base_url().'writer/dashboard');
 			}
 		}else{
 			redirect(base_url().'writer');
 		}
 	}
 	
 	function submit($article_id = null){
 		if($this->session->userdata('id') != 0 && $this->session->userdata('role') && $this->session->userdata('role') == "writer"){
 			if($article_id && is_numeric($article_id)){
 				if($this->input->post('submit') == "submit"){
 					$article_id = $this->input->post('article_id');
 					$content = $this->input->post('article_content');
 					$title = $this->input->post('article_title');
 					if($title && $content){
 						$missing_keywords = '';
 						$response = $this->Mw_article->get_new_articles(array('article_id'=>$article_id));
 						$words_in_content = explode(' ',$content);
 				
 						// Filtering content inside anchor tag
 						$filtered_content = array();
 						$dom = new DOMDocument();
 						$dom->loadHTML($content);
 						foreach ($dom->getElementsByTagName('a') as $a) {
 							$filtered_content[] = $a->textContent;
 						}
 							
 						$number_of_words = count($words_in_content);
 				
 						if(is_numeric($response['0']['length']) && $number_of_words >= $response['0']['length']){ // Comparing length of content
 							if($response['0']['keywords'] != ''){
 								$keywords = explode(',',$response['0']['keywords']);
 								foreach($keywords as $values){
 									/*if(in_array($values,$filtered_content)){ // Checking of keywords
 									 	
 									}else{
 									$missing_keywords .= $values.',';
 									}*/
 									if(stristr($content, $values) === FALSE) {
 										$missing_keywords .= $values.',';
 									}
 								}
 							}
 							if($missing_keywords == ''){
 								$insert_array = array(
 										'writer_id'=>$this->session->userdata('id'),
 										'article_id'=>$article_id,
 										'title'=>$title,
 										'content'=>$content,
 										'status'=>'pending',
 										'due_date'=>$this->input->post('due_date'),
 										'claimed_date'=>$this->input->post('claimed_date'),
 										'submitted_date'=>date('Y-m-d H:i:s')
 								);
 								//print_r($insert_array); die();
 								$this->Mw_article->submit_article($insert_array);
 								redirect(base_url().'writer/dashboard');
 							}else{
 								$missing_keywords = substr($missing_keywords,0,-1);
 								$data['error'] = 'These keywords are missing: '.$missing_keywords;
 								$data['title'] = $title;
 								$data['content'] = $content;
 							}
 						}else{
 							$data['error'] = 'Length is smaller than '.$response['0']['length'];
 							$data['title'] = $title;
 							$data['content'] = $content;
 						}
 					}else{
 						$data['error'] = 'Title or content is missing. Please check';
 						$data['title'] = $title;
 						$data['content'] = $content;
 					}
 				}
 				$data['article_info'] = $this->Mw_article->get_claimed_article(array('claimed_articles.writer_id'=>$this->session->userdata('id'),'claimed_articles.article_id'=>$article_id));
 				$data['info_required'] = $this->Mw_article->get_added_article(array('article_id'=>$article_id,'status'=>'claimed'));
 				$data['page_title'] = "Submitted claimed articles";
 				$this->load->view('writer/submit_article',$data);
 			}else{
 				redirect(base_url(),'writer/articles');
 			} 			
 		}else{
 			redirect(base_url().'writer');
 		} 		
 	}
 	
 	function declined_article(){
 		if($this->session->userdata('id') != 0 && $this->session->userdata('role') && $this->session->userdata('role') == "writer"){
 			if($this->input->post('submit')){
 				$article_id = $this->input->post('article_id');
 				$content = $this->input->post('article_content');
 				$title = $this->input->post('article_title');
 				if($title && $content){
 					$missing_keywords = '';
 					$response = $this->Mw_article->get_new_articles(array('article_id'=>$article_id));
 					$words_in_content = explode(' ',$content);
 				
 					// Filtering content inside anchor tag
 					$filtered_content = array();
 					$dom = new DOMDocument();
 					$dom->loadHTML($content);
 					foreach ($dom->getElementsByTagName('a') as $a) {
 						$filtered_content[] = $a->textContent;
 					}
 						
 					$number_of_words = count($words_in_content);
 				
 					if(is_numeric($response['0']['length']) && $number_of_words >= $response['0']['length']){ // Comparing length of content
 						if($response['0']['keywords'] != ''){
 							$keywords = explode(',',$response['0']['keywords']);
 							foreach($keywords as $values){
 								if(stristr($content, $values) === FALSE) {
 									$missing_keywords .= $values.',';
 								}
 							}
 						}
 						if($missing_keywords == ''){
 							$where_params = array(
 									'writer_id'=>$this->session->userdata('id'),
 									'article_id'=>$article_id
 							);
 							
 							$update_parameters = array(
					 									'title'=>$title,
	 													'content'=>$content,
	 													'status'=>'pending', 													
	 													'submitted_date'=>date('Y-m-d H:i:s')
 													 );
 							//print_r($insert_array); die();
 							$this->Mw_article->submit_declined_article($where_params,$update_parameters);
 							redirect(base_url().'writer/declined');
 						}else{
 							$missing_keywords = substr($missing_keywords,0,-1);
 							$data['error'] = 'These keywords are missing: '.$missing_keywords;
 							$data['title'] = $title;
 							$data['content'] = $content;
 						}
 					}else{
 						$data['error'] = 'Length is smaller than '.$response['0']['length'];
 						$data['title'] = $title;
 						$data['content'] = $content;
 					}
 				}else{
 					$data['error'] = 'Title or content is missing. Please check';
 					$data['title'] = $title;
 					$data['content'] = $content;
 				} 				
 			}
 			$data['article_info'] = $this->Mw_article->get_declined_article(array('submitted_articles.writer_id'=>$this->session->userdata('id'),'submitted_articles.article_id'=>$this->input->post('article_id')));
 			$data['info_required'] = $this->Mw_article->get_added_article(array('article_id'=>$this->input->post('article_id'),'status'=>'declined'));
 			$data['page_title'] = "Submitted declined articles";
 			$this->load->view('writer/writer_decline',$data);
 		}
 	}
 	
 	function profile(){
 		if($this->session->userdata('id') != 0 && $this->session->userdata('role') && $this->session->userdata('role') == "writer"){
 			if($this->input->post('submit') == 'edit'){
 				$where = array('id'=>$this->session->userdata('id'));
 				$params = array(
 								'name'=>$this->input->post('name'),
		 						'username'=>$this->input->post('username'),
		 						'email'=>$this->input->post('email'),
		 						'phone'=>$this->input->post('phone'),
		 						'sex'=>$this->input->post('sex'),
		 						'paypal_address'=>$this->input->post('paypal_address')
 							);
 				$this->Mw_writer->update($where,$params);
 			}elseif($this->input->post('submit') == 'Change'){
 				$old_password = $this->input->post('old_password');
 				$new_password = $this->input->post('new_password');
 				if($this->Mw_writer->change_password($old_password,$new_password)){
 					$data['success'] = _("Password Changed Successfully");
 				}else{
 					$data['error'] = _("Password Do Not Changed Successfully");
 				}
 			}
 			$data['writer_info'] = $this->Mw_writer->get_profile($this->session->userdata('id'));
 			$data['page_title'] = "Profile";
 			$this->load->view('writer/profile',$data);
 		}else{
 			redirect(base_url().'writer');
 		}
 	}
 	
 	function logout(){
 		//$this->session->set_userdata(array('id'=>0,'username'=>'','role'=>''));
 		$this->session->unset_userdata('id');
 		$this->session->unset_userdata('username');
 		$this->session->unset_userdata('role');
 		delete_cookie('role');
 		delete_cookie('username');
 		delete_cookie('id');
 			
 		$this->session->unset_userdata('username');
 		redirect(base_url().'writer');
 	}
 }