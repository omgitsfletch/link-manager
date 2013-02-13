<?php
 class Admin extends CI_Controller{
 	function __construct(){
 		parent:: __construct();
 		//$this->config->load('site_settings');
 		$this->wdb = $this->load->database('writer', TRUE);
 		
 		$this->load->library('pagination');
 		
 		$this->load->model('admin/Marticle');
 		$this->load->model('admin/Mwriters');
 		$this->load->model('admin/Msettings');
 		
 		$this->item_per_page = $this->Marticle->get_item_per_page();
 		//$this->Marticle->check_due_date();
 		if($this->session->userdata('logged_in') && $this->session->userdata('user_id') ){
 			$ziffen_user_id = $this->session->userdata('user_id');
 			$ziffen_group_id = $this->session->userdata('group_id');
 			$data=array('id'=>$ziffen_user_id,'role'=>'admin');
 			$this->session->set_userdata($data);
 		}
 	}
 	
 	function index(){
 		
 		if($this->session->userdata('id') && $this->session->userdata('role') == "admin"){
 			redirect(base_url().'admin/articles');
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function summary($page = null){
 		
 		if($this->session->userdata('id') && $this->session->userdata('role') == "admin"){
 			
 			$writers = $this->wdb->get_where('writers',array('role'=>'writer'))->result_array();
 			//echo count($writers); die();
 			$config['base_url']=base_url().'admin/summary';
 			$config['total_rows']=count($writers);
 			$config['per_page']=$this->item_per_page;
 			$config['first_link']="First";
 			$config['first_link_open']="<div>";
 			$config['first_link_close']="</div>";
 			$config['use_page_numbers'] = TRUE;
 			
 			$this->pagination->initialize($config);
 			//echo $this->pagination->create_links();
 				
 			$writers = $this->Mwriters->get_writers($page);
 			$writer_infos = array();
 			
 			if(!empty($writers)){
 				$todays_date = date("Y-m-d");
 				$i = 0;
 				foreach($writers as $values){
 					$writer_infos[$i]['id'] = $values['id'];
 					$writer_infos[$i]['name'] = $values['name'];
 					$writer_infos[$i]['last_login'] = $values['last_login'];
 					
 					$todays_submitted = $this->Marticle->get_submitted_with_writers($values['id'],$todays_date);
 					$writer_infos[$i]['todays'] = count($todays_submitted);
 					
 					$yesterday = strtotime ( '-1 day' , strtotime ( $todays_date ) ) ;
 					$yesterday = date ( 'Y-m-d' , $yesterday );
 					$yesterdays_submitted = $this->Marticle->get_submitted_with_writers($values['id'],$yesterday);
 					$writer_infos[$i]['yesterday'] = count($yesterdays_submitted);
 					
 					$last_7_day = strtotime ( '-7 day' , strtotime ( $todays_date ) ) ;
 					$last_7_day = date ( 'Y-m-d' , $last_7_day );
 					$last_7_day_submitted = $this->Marticle->get_submitted_with_writers($values['id'],$last_7_day,'greater');
 					$writer_infos[$i]['last_7_day'] = count($last_7_day_submitted);
 					
 					$this_month = substr($todays_date,0,7);
 					$this_month_submitted = $this->Marticle->get_submitted_with_writers($values['id'],$this_month);
 					$writer_infos[$i]['this_month'] = count($this_month_submitted);
 					
 					$i++;
 				}
 			}
 			$data['graph'] = $this->Msettings->get_graph();			
 			$data['infos'] = $writer_infos;
 			$data['item_per_page'] = $this->item_per_page;
 			//$this->load->view('admin/summary',$data);
 			
 			$data['page'] = 'admin/dashboard';
 			$data['title'] = 'Summary';
 			
 			$this->load->view('shell', $data);
 			
 		}else{
 			redirect(base_url());
 		}
 		
 	}
 	
 	function articles(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$data['groups'] = $this->Msettings->get_group_settings();
 			$data['writers'] = $this->Mwriters->get_writers();
 			$data['asigned_articles_info'] = $this->Marticle->get_assigned_article();
	 		$data['claimed_article_info'] = $this->Marticle->get_claimed_article();
	 		$data['available_article_info'] = $this->Marticle->get_added_article(array(),array('date'=>'desc'));
	 		//$this->load->view('admin/articles',$data);
	 		
	 		$data['page'] = 'admin/articles';
	 		$data['title'] = 'Articles';
	 		
	 		$this->load->view('shell', $data);
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function ajax_assigned(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$start = $this->input->post('start');
 			$limit = $this->input->post('limit');
 			$asigned_articles_info = $this->Marticle->get_assigned_article(array(),1,$start,$limit);
 			$new_html = '';
 			$new_html .= '<tr>
 			<th width="1%">&nbsp;</th>
 			<th width="10%">#</th>
 			<th width="34%">'._("Main Topic").'</th>
 			              <th width="15%">'._("Assigned To").'</th>
 			              <th width="10%">'._("Assigned On").'</th>
 			              <th width="10%">'._("Status").'</th>
 			              <th width="20%">'._("Due Day").' / '._("Length").'</th>
 			            </tr>';
 			
 			foreach($asigned_articles_info as $values){
 				$new_html .= '<tr>
 			              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
 			              <td width="10%">'.$values['article_id'].'</td>
 			              <td width="34%">
 			              	<a title="'.$values['topic'].'" rel="popover" class="pop" href="javascript: void(0);">';
       			if(strlen($values['topic']) >= 40){
           			$new_html .= substr($values['topic'],0,40).'...';
           		}else{
           			$new_html .= $values['topic'];
           		}
 			    $new_html .= '</a>
 			              </td>
 			              <td width="15%">'.$values['name'].'</td><td width="10%">';
 			    $timestamp = strtotime($values['assigned_time']);
 			    $new_html .= date('D', $timestamp).', '.date('m-d-Y',$timestamp).'</td>';
 			    $new_html .= '<td width="10%">';
 			    if($values['status']){
 			    	$new_html .=_("Accepted");
 			    }else{
 			    	$new_html .=_("Pending");
 			    }

 			    $new_html .='</td>
 			              <td width="20%">
 			                <span class="btn">'.$values['due_date'].'</span>
 			                 <span class="btn">'.$values['length'].'</span>
 			              </td>
 			            </tr>';
 			    echo $new_html;
 			}
 		}else{
 			echo _("You are Not Logged In");
 		}
 	}
 	
 	function ajax_claimed(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$start = $this->input->post('start');
 			$limit = $this->input->post('limit');
 			$claimed_article_info = $this->Marticle->get_claimed_article(array(),1,$start,$limit);
 			$new_html = '';
 			$new_html .= '<tr>
              <th width="1%">&nbsp;</th>
              <th width="10%">#</th>
              <th width="34%">'._("Main Topic").'</th>
              <th width="25%">'._("Claimed By").'</th>
              <th width="10%">'._("Time Left").'</th>
              <th width="20%">'._("Due Day").' / '._("Length").'</th>
            </tr>';
 	
 			foreach($claimed_article_info as $values){
 				$new_html .= '<tr>
 			              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
 			              <td width="10%">'.$values['article_id'].'</td>
 			              <td width="34%">
 			              	<a title="'.$values['topic'].'" rel="popover" class="pop" href="javascript: void(0);">';
 				if(strlen($values['topic']) >= 40){
 					$new_html .= substr($values['topic'],0,40).'...';
 				}else{
 					$new_html .= $values['topic'];
 				}
 				$new_html .= '</a></td><td width="25%">'.$values['name'].'</td>';
 				$claimed_time = strtotime($values['claimed_time']);
              		  $due_time = date('Y-m-d H:i:s', strtotime($values['claimed_time']. ' + '.$values['due_time'].' days'));
    				  // convert to unix timestamps
        			  $current_Time=strtotime(date('Y-m-d H:i:s'));
        			  $lastTime=strtotime($due_time);
        							
        			  $total_time = $lastTime - $claimed_time;   	
        			  $time_left = $lastTime - $current_Time;				
        			  //$hours = abs(floor(($time_left)/3600));
        			  $time = 0;
        			  if((int)($time_left/(60*60*24)) > 0)
        			  	$time = (int)($time_left/(60*60*24)).' days';
        			  elseif((int)($time_left/(60*60)) > 0)
        			  	$time = (int)($time_left/(60*60)).' hours';
        			  elseif((int)($time_left/60) > 0)
        			  	$time = (int)($time_left/60).' minutes';
        			  else
        			  	$time = (int)($time_left).' seconds';
 	
 				$new_html .='<td width="10%">'.$time.'</td>
              <td width="20%">
                <a href="javascript: void(0);" original-title="'.$time.' left" class="time_left"><span class="btn" title="">'.$values['due_time'].'</span></a>
                <span class="btn">'.$values['length'].'</span>
              </td>
            </tr>';
 			}
 			echo $new_html;
 		}else{
 			echo _("You are Not Logged In");
 		}
 	}
 	
 	function assign_to(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$insert_array['writer_id'] = $this->input->post('writer');
 			$insert_array['article_id'] = $this->input->post('assigning_article_id');
 			$insert_array['status'] = 0;
 			$insert_array['assigned_time'] = date("Y-m-d H:i:s");
 			if($this->Marticle->assign_it($insert_array)){
 				$writer = $this->Mwriters->get_writers(null,array('id'=>$insert_array['writer_id']),true);
 				$admin = $this->Mwriters->get_admin();
 				$this->load->library('utilities');
 				$this->load->helper('phpmailer');
 				
				$msg = '';
				$msg .= '<html><head></head><body><h1>Dear '.$writer['0']['name'].'</h1><br />';
				$msg .= '<p>You have have a new article to write assigned by admin</p>';
				$msg .= '<p>Click <a href="'.base_url().'">here</a> to login and see details.</p>';
				$msg .= '<p>Thank you.</p>';
				$msg .= '</body></html>';
				$mail_subject = 'New Article Assigned';
				//$mail_body = $this->utilities->parseMailText( $msg, $client );
				
				send_email( $writer['0']['email'], $admin['0']['email'], $mail_subject, $msg);

 			}
 			redirect(base_url().'admin/articles');
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function available($article_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($article_id && is_numeric($article_id)){
 				$data['groups'] = $this->Msettings->get_group_settings();
 				$data['article_info'] = $this->Marticle->get_added_article(array('article_id'=>$article_id));
 				//$this->load->view('admin/article_addedit',$data);
 				$data['page'] = 'admin/article_addedit';
 				$data['title'] = 'Available articles';
 				
 				$this->load->view('shell', $data);
 			}else{
 				$data['article_info'] = $this->Marticle->get_added_article(array(),array('date'=>'desc'));
 				$this->load->view('admin/available',$data);
 				
 			} 			
 		}
 	}
 	
 	function claimed($article_id = null, $writer_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			//$data['current_page_is'] = 'submitted';
 			if($article_id && $writer_id){
 				$data['article_info'] = $this->Marticle->get_article(array('article_id'=>$article_id,'status'=>'pending','writer_id'=>$writer_id));
 				$this->load->view('admin/single_article',$data);
 			}else{
 				$data['article_info'] = $this->Marticle->get_claimed_article();
 				//$this->load->view('admin/claimed',$data);
 				$data['page'] = 'admin/claimed';
 				$data['title'] = 'Claimed articles';
 					
 				$this->load->view('shell', $data);
 			}
 		}
 	}
 	
 	function published(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$data['groups'] = $this->Msettings->get_group_settings();
 			$data['writers'] = $this->Mwriters->get_writers();
 			$filter_by= 'All';
 			$filter_value = '';
 			if($this->input->post('filter_options') == 'Group'){
 				$filter_by= 'Group';
 				$filter_value = $this->input->post('group');
 			}elseif($this->input->post('filter_options') == 'Writer'){
 				$filter_by= 'Writer';
 				$filter_value = $this->input->post('writer');
 			}elseif($this->input->post('filter_options') == 'Date'){
 				$filter_by= 'Date';
 				$filter_value = $this->input->post('date');
 			}elseif($this->input->post('filter_options') == 'All'){
 					
 			}
 			$data['filter_by'] = $filter_by;
 			$data['article_info'] = $this->Marticle->get_published_article(array(),$filter_by,$filter_value);
 			//$this->load->view('admin/published',$data);
 			$data['page'] = 'admin/published';
 			$data['title'] = 'Published articles';
 			
 			$this->load->view('shell', $data);
 		}
 	}
 	
 	function approved($writer_id = null, $article_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($article_id && $writer_id && is_numeric($article_id) && is_numeric($writer_id)){
 				$data['article_info'] = $this->Marticle->get_approved_article(array('approved_articles.article_id'=>$article_id,'approved_articles.writer_id'=>$writer_id));
 				$this->load->view('admin/edit_approved',$data);
 			}else{
 				$data['groups'] = $this->Msettings->get_group_settings();
 				$data['writers'] = $this->Mwriters->get_writers();
 				$filter_by= 'All';
 				$filter_value = '';
 				if($this->input->post('filter_options') == 'Group'){
 					$filter_by= 'Group';
 					$filter_value = $this->input->post('group');
 				}elseif($this->input->post('filter_options') == 'Writer'){
 					$filter_by= 'Writer';
 					$filter_value = $this->input->post('writer');
 				}elseif($this->input->post('filter_options') == 'Date'){
 					$filter_by= 'Date';
 					$filter_value = $this->input->post('date');
 				}elseif($this->input->post('filter_options') == 'All'){
 						
 				}
 				$data['filter_by'] = $filter_by;
 				$data['article_info'] = $this->Marticle->get_approved_article(array(),$filter_by,$filter_value);
 				//$this->load->view('admin/approved',$data);
 				$data['page'] = 'admin/approved';
 				$data['title'] = 'Approved articles';
 				
 				$this->load->view('shell', $data);
 			}
 		}
 	}
 	
 	function submitted($page = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$submitted_articles = $this->wdb->get_where('submitted_articles',array('status'=>'pending'))->result_array();
 			//echo count($writers); die();
 			$config['base_url']=base_url().'admin/submitted';
 			$config['total_rows']=count($submitted_articles);
 			$config['per_page']=$this->item_per_page;
 			$config['first_link']="First";
 			$config['first_link_open']="<div>";
 			$config['first_link_close']="</div>";
 			$config['use_page_numbers'] = TRUE;
 			
 			$this->pagination->initialize($config);
 			
 			$data['groups'] = $this->Msettings->get_group_settings();
 			$data['writers'] = $this->Mwriters->get_writers();
 			$filter_by= 'All';
 			$filter_value = '';
 			if($this->input->post('filter_options') == 'Group'){
 				$filter_by= 'Group';
 				$filter_value = $this->input->post('group');
 			}elseif($this->input->post('filter_options') == 'Writer'){
 				$filter_by= 'Writer';
 				$filter_value = $this->input->post('writer');
 			}elseif($this->input->post('filter_options') == 'Date'){
 				$filter_by= 'Date';
 				$filter_value = $this->input->post('date');
 			}elseif($this->input->post('filter_options') == 'All'){
 				
 			}
 			$data['filter_by'] = $filter_by; 
			$data['article_info'] = $this->Marticle->get_submitted_article(array('submitted_articles.status'=>'pending'),$page,$filter_by,$filter_value);
			//$this->load->view('admin/submitted',$data);
			$data['page'] = 'admin/submitted';
			$data['title'] = 'Submitted articles';
				
			$this->load->view('shell', $data);
 		}
 	}
 	
 	function submit($temp = null,$writer_id = null,$article_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($article_id == null)
 				$article_id = $this->input->post('article_id');
 			if($writer_id == null)
 				$writer_id = $this->input->post('writer_id');

 			if($this->input->post('reject')){
 				//print_r($this->input->post()); die();
	 			$decline_note = $this->input->post('decline_note');
	 			if($article_id && $writer_id && $decline_note){
	 				$declined_array = array(
						 						'article_id' => $article_id,
						 						'writer_id' => $writer_id,
						 						'decline_note' => $decline_note,
						 						'date' => date("Y-m-d h:i:s")
	 										);
	 				$this->Marticle->decline_this($declined_array);
	 				redirect(base_url().'admin/submitted');
	 			}else{
	 				redirect(base_url().'admin/summary');
	 			} 			
 			}elseif($this->input->post('approve')){
	 			if($article_id && $writer_id){
	 				$approve_array = array(
	 						'article_id' => $article_id,
	 						'writer_id' => $writer_id,
	 						'approval_date' => date("Y-m-d h:i:s")
	 				);
	 				$this->Marticle->approve_this($approve_array);
	 				redirect(base_url().'admin/submitted');
	 			}else{
	 				redirect(base_url().'admin/summary');
	 			}
 			}elseif($this->input->post('publish')){
	 			if($article_id && $writer_id){
	 				$published_array = array(
	 						'article_id' => $article_id,
	 						'writer_id' => $writer_id,
	 						'published_date' => date("Y-m-d h:i:s")
	 				);
	 				$this->Marticle->publish_this($published_array);
	 				redirect(base_url().'admin/submitted');
	 			}else{
	 				redirect(base_url().'admin/summary');
	 			}
 			}elseif($this->input->post('edit')){
	 			if($article_id && $writer_id){
	 				$edit_array = array(
	 						'title' => $this->input->post('title'),
	 						'content' => $this->input->post('content'),
	 				);
	 				$where_array = array(
	 						'article_id' => $article_id,
	 						'writer_id' => $writer_id,	 						
	 				);

	 				$this->Marticle->edit_this($edit_array,$where_array);
	 				redirect(base_url().'admin/submitted');
	 			}else{
	 				redirect(base_url().'admin/summary');
	 			}
 			}else{
 				if($article_id && $writer_id && is_numeric($article_id) && is_numeric($writer_id)){
 					$data['article_info'] = $this->Marticle->get_submitted_article(array('submitted_articles.article_id'=>$article_id,'submitted_articles.status'=>'pending','submitted_articles.writer_id'=>$writer_id));
 					//$this->load->view('admin/edit_submitted',$data);
 					$data['page'] = 'admin/edit_submitted';
 					$data['title'] = 'Edit submitted articles';
 					
 					$this->load->view('shell', $data);
 				}
 			}
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function add(){
 		
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($this->input->post('act') == 'add_article'){
 				/*$this->form_validation->set_rules('username', 'Username', 'required');
 				 $this->form_validation->set_rules('password', 'Password', 'required');
 				$this->form_validation->set_rules('repassword', 'Password Confirmation', 'required|matches[password]');
 				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
 				$this->form_validation->set_rules('age', 'Age', 'required|greater_than[18]');
 					
 				if ($this->form_validation->run() == FALSE)
 				{
 				}
 				else
 				{*/
 				//if($this->input->post('word')===$this->input->post('captcha')){
 				$arr=array(
 						'topic'=>$this->input->post('article_topic'),
 						'length'=>$this->input->post('length'),
 						'due_date'=>$this->input->post('due_date'),
 						'description'=>$this->input->post('description'),
 						'keywords'=>$this->input->post('keywords'),
 						'anchor_text'=>$this->input->post('anchor_text'),
 						'urls'=>$this->input->post('urls'),
 						'admin_notes'=>$this->input->post('admin_note'),
 						'date'=>date('Y-m-d H:i:s'),
 						'group_id'=>$this->input->post('group'),
 						'status'=>'new'
 				);
 				//print_r($arr); die();
 				$this->wdb->insert('articles',$arr);
 				redirect(base_url().'admin/articles');
 				/*}else{
 				 $data['error']=_("Please Re-enter the Captcha word");
 				}
 			
 				}*/
 			}elseif($this->input->post('act') == 'edit_article'){
 				$arr=array(
 						'topic'=>$this->input->post('article_topic'),
 						'length'=>$this->input->post('length'),
 						'due_date'=>$this->input->post('due_date'),
 						'description'=>$this->input->post('description'),
 						'keywords'=>$this->input->post('keywords'),
 						'anchor_text'=>$this->input->post('anchor_text'),
 						'urls'=>$this->input->post('urls'),
 						'admin_notes'=>$this->input->post('admin_note'),
 						'group_id'=>$this->input->post('group')
 				);
 				$this->wdb->where('article_id',$this->input->post('article_id'));
 				$this->wdb->update('articles',$arr);
 				redirect(base_url().'admin/articles');
 			}
 			
 			//$this->load->view('admin/article_addedit'); 
 			$data['page'] = 'admin/article_addedit';
 			$data['title'] = 'Add edit available articles';
 			
 			$this->load->view('shell', $data);
 		}else{
 			redirect(base_url());
 		} 		
 	}
 	
 	function delete_available($article_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($article_id && is_numeric($article_id)){
 				$this->wdb->delete('articles',array('article_id'=>$article_id));
 				$this->wdb->delete('assigned_articles',array('article_id'=>$article_id));
 				$this->wdb->delete('claimed_articles',array('article_id'=>$article_id));
 				$this->wdb->delete('submitted_articles',array('article_id'=>$article_id));
 				$this->wdb->delete('published_articles',array('article_id'=>$article_id));
 				$this->wdb->delete('approved_articles',array('article_id'=>$article_id));
 				$this->wdb->delete('declined_articles',array('article_id'=>$article_id));
 				redirect(base_url().'admin/articles');
 				/*$data['page'] = 'admin/articles';
 				$data['title'] = 'Article\'s Park';
 				
 				$this->load->view('shell', $data);*/
 			}
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function decline_article(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$article_id = $this->input->post('article_id');
 			$writer_id = $this->input->post('writer_id');
 			$decline_note = $this->input->post('decline_note');
 			if($article_id && $writer_id && $decline_note){
 				$declined_array = array(
					 						'article_id' => $article_id,
					 						'writer_id' => $writer_id,
					 						'decline_note' => $decline_note,
					 						'date' => date("Y-m-d h:i:s"),
 											'status' => 'pending'
 										);
 				$this->Marticle->decline_this($declined_array);
 				redirect(base_url().'admin/summary');
 			}else{
 				redirect(base_url().'admin/summary');
 			} 			
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function approve_article(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$article_id = $this->input->post('article_id');
 			$writer_id = $this->input->post('writer_id');
 			if($article_id && $writer_id){
 				$approve_array = array(
 						'article_id' => $article_id,
 						'writer_id' => $writer_id,
 						'approval_date' => date("Y-m-d h:i:s")
 				);
 				$this->Marticle->approve_this($approve_array);
 				redirect(base_url().'admin/summary');
 			}else{
 				redirect(base_url().'admin/summary');
 			}
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function publish_article(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$article_id = $this->input->post('article_id');
 			$writer_id = $this->input->post('writer_id');
 			if($article_id && $writer_id){
 				$published_array = array(
 						'article_id' => $article_id,
 						'writer_id' => $writer_id,
 						'published_date' => date("Y-m-d h:i:s")
 				);
 				$this->Marticle->publish_this($published_array);
 				redirect(base_url().'admin/approved');
 			}else{
 				redirect(base_url().'admin/summary');
 			}
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function addWriter(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($this->input->post('submit')){
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
 					redirect(base_url().'admin/summary');
	 			}
	 		}
	 		
	 		//$this->load->view('admin/add_writer');
	 		$data['page'] = 'admin/add_writer';
	 		$data['title'] = 'Add Writers';
	 			
	 		$this->load->view('shell', $data);
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function writers($page = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($this->input->post('submit') == 'update'){
 				$this->wdb->where('id',$this->input->post('writer_id'));
 				$this->wdb->update('writers',array('admin_note'=>$this->input->post('admin_note')));
 				redirect(base_url().'admin/writers');
 			}
 			/*$writers = $this->Mwriters->get_writers('','',true);
 			
 			$config['base_url']=base_url().'admin/writers';
 			$config['total_rows']=count($writers);
 			$config['per_page']=$this->item_per_page;
 			$config['first_link']="First";
 			$config['first_link_open']="<div>";
 			$config['first_link_close']="</div>";
 			$config['use_page_numbers'] = TRUE;
 			
 			$this->pagination->initialize($config);*/
 			
 			$data['active_writers'] = $this->Mwriters->get_writers('',array('status'=>1),true);
 			$data['inactive_writers'] = $this->Mwriters->get_writers('',array('status'=>0),true);
 			//$this->load->view('admin/all_writers',$data);
 			$data['page'] = 'admin/all_writers';
 			$data['title'] = 'Writers';
 				
 			$this->load->view('shell', $data);
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function delete_writers($writer_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($writer_id && is_numeric($writer_id)){
 				$this->wdb->delete('writers',array('id'=>$writer_id));
 				redirect(base_url().'admin/writers');
 			}
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function change_per_page(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($this->input->post('page')){
 				$this->wdb->update('site_settings',array('item_per_page'=>$this->input->post('page'))) or die(mysql_error());
 				echo true;
 			}
 		}else{
 			echo false;
 		}
 	}
 	
 	function update_writer($writer_id = null, $value = null, $max_claimable = null, $status = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($writer_id && is_numeric($writer_id)){
 				$this->wdb->where('id',$writer_id);
 				$this->wdb->update('writers',array('price_per_word'=>$value,'max_claimable'=>$max_claimable,'status'=>$status));
 				redirect(base_url().'admin/writers');
 			}
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function settings($page = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($this->input->post('submit') == 'edit_copyscape'){
 				$update_array = array(
 										'copyscape_username'=>$this->input->post('copyscape_username'),
 										'copyscape_api_key'=>$this->input->post('copyscape_api_key')
 									);
 				$this->Msettings->update_copyscape_settings($update_array);
 			}elseif($this->input->post('submit') == 'add_grp'){
 				$insert_array = array(
 						'name'=>$this->input->post('group_name'),
 						'article_assigned'=>0,
 						'date_added'=>date('Y-m-d H:i:s')
 				);
 				$this->Msettings->add_group($insert_array);
 			}elseif($this->input->post('submit') == 'edit_grp'){
 				$group_name = $this->input->post('grp_name');
 				$group_id = $this->input->post('group_id');
 				if($group_id && is_numeric($group_id)){
 					$this->Msettings->update_group($group_id,$group_name);
 				} 				
 			}
 			$data['copyscape_settings'] = $copyscape =  $this->Msettings->get_copyscape_settings();
 			$available_groups = $this->Msettings->get_group_settings();
 			$config['base_url']=base_url().'admin/settings';
 			$config['total_rows']=count($available_groups);
 			$config['per_page']=10;
 			$config['first_link']="First";
 			$config['first_link_open']="<div>";
 			$config['first_link_close']="</div>";
 			$config['use_page_numbers'] = TRUE;
 			
 			$this->pagination->initialize($config);
 			
 			$data['available_groups'] = $this->Msettings->get_group_settings(true,$page);
 			
 			$balance = 0;
 			$this->load->helper('copyscape_premium_api');
 			
 			//$url = "http://www.copyscape.com/api?u=".$copyscape['0']['copyscape_username']."&k=".$copyscape['0']['copyscape_api_key']."&o=balance&f=xml";
 			/*echo $url.'<br />'; 
 			
 			$balance_curl = curl_init();
 			curl_setopt($balance_curl, CURLOPT_URL, $url);
 			curl_setopt($balance_curl, CURLOPT_TIMEOUT, 60);
 			//curl_setopt($balance_curl, CURLOPT_HEADER, TRUE);
 			curl_setopt($balance_curl, CURLOPT_RETURNTRANSFER, true);
 			$balance=curl_exec($balance_curl);
 			
 			if(curl_errno($balance_curl)) //error from the URL
 			
 			{
 			
 				echo 'Curl Error: ' . curl_error($balance_curl);
 			
 			}
 			
 			curl_close($balance_curl);
 			//$balance = curl_exec($balance_curl);*/
 			
 			$data['account_balance'] = copyscape_api_check_balance();
 			//$this->load->view('admin/settings',$data);
 			$data['page'] = 'admin/settings';
 			$data['title'] = 'Settings';
 				
 			$this->load->view('shell', $data);
 			
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function export_approved($article_id = null){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			if($article_id && is_numeric($article_id)){
 				$data = $this->Marticle->get_approved_article(array('approved_articles.article_id'=>$article_id));
 				
 				$doc_text = "<h1>".$data['0']['title']."</h1>";
 				$doc_text .= "<p>".$data['0']['content']."</p>";
 				header("Content-type: application/vnd.ms-word");
 				header("Content-Disposition: attachment;Filename=article_".$data['0']['article_id'].".doc");
 				//readfile($file_path);
 				echo $doc_text;
 			}else{
 				redirect(base_url().'admin/approved');
 			}
 		}else{
 			redirect(base_url());
 		}	
 	}
 	
 	function profile(){
 		if($this->session->userdata('id') != 0 && $this->session->userdata('role') && $this->session->userdata('role') == "admin"){
 			if($this->input->post('submit') == 'edit'){
 				$where = array('id'=>$this->session->userdata('id'));
 				$params = array(
 						'name'=>$this->input->post('name'),
 						'username'=>$this->input->post('username'),
 						'email'=>$this->input->post('email'),
 						'phone'=>$this->input->post('phone'),
 						'sex'=>$this->input->post('sex')
 				);
 				$this->Mwriters->update_admin($where,$params);
 			}elseif($this->input->post('submit') == 'Change'){
 				$old_password = $this->input->post('old_password');
 				$new_password = $this->input->post('new_password');
 				if($this->Mwriters->change_admin_password($old_password,$new_password)){
 					$data['success'] = _("Password Changed Successfully");
 				}else{
 					$data['error'] = _("Password Do Not Changed Successfully");
 				}
 			}
 			$data['writer_info'] = $this->Mwriters->get_admin_profile($this->session->userdata('id'));
 			//$this->load->view('admin/profile',$data);
 			$data['page'] = 'admin/profile';
 			$data['title'] = 'Profile';
 				
 			$this->load->view('shell', $data);
 			
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function reports(){
 		if($this->session->userdata('id') != 0 && $this->session->userdata('role') && $this->session->userdata('role') == "admin"){
 			$this->load->model('admin/Mreports');
 			$data['reports'] = array();
 			if($this->input->post('submit') == 'filter'){
 				$start_date = $this->input->post('start_date');
 				$end_date = $this->input->post('end_date');
 				if(strtotime($start_date) <= strtotime($end_date)){
 					$start_time = strtotime($start_date);
 					//$end_time = strtotime($end_date);
 					$data['s_date'] = $start_date;
 					$data['e_date'] = $end_date;
 					$data['reports'] = $this->Mreports->get_reports(date('Y-m-d H:i:s',$start_time),date('Y-m-d H:i:s',strtotime($end_date.' + 1 days')));
 				}else{
 					$data['reports'] = $this->Mreports->get_reports();
 				}
 			}else{
 				$data['reports'] = $this->Mreports->get_reports();
 			} 			
 			//$this->load->view('admin/reports',$data);
 			$data['page'] = 'admin/reports';
 			$data['title'] = 'Article\'s Report';
 				
 			$this->load->view('shell', $data);
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function report_ajax(){
 		$this->load->model('admin/Mreports');
 		$reports = array();
 		$start = $this->input->post('start');
 		$limit = $this->input->post('limit');
 		if($this->input->post('submit') == 1){
 			$start_date = $this->input->post('start_date');
 			$end_date = $this->input->post('end_date');
 			if(strtotime($start_date) <= strtotime($end_date)){
 				$start_time = strtotime($start_date);
 				//$end_time = strtotime($end_date);
 				//$data['s_date'] = $start_date;
 				//$data['e_date'] = $end_date;
 				$reports = $this->Mreports->get_reports(date('Y-m-d H:i:s',$start_time),date('Y-m-d H:i:s',strtotime($end_date.' + 1 days')),true,$start,$limit);
 			}else{
 				$reports = $this->Mreports->get_reports();
 			}
 		}else{
 			$reports = $this->Mreports->get_reports('','',true,$start,$limit);
 		}

 		$approved = 0;
 		$published = 0;
 		$submitted = 0;
 		$rejected = 0;
 		$total_rejected = 0;
 		$timeouts = 0;
 		
 		$new_html = '';
 		$new_html .= '<tr>
 							  <th width="1%">&nbsp;</th>
 							  <th width="20%">'._("Writer").'</th>
 		 		              <th width="10%">'._("Approved").'</th>
 		 		              <th width="10%">'._("Published").'</th>
 		 		              <th width="10%">'._("Submitted").'</th>
 		 		              <th width="10%">'._("Rejected").'</th>
 		 		              <th width="9%">'. _("Total Rejections").'</th>
 		 		              <th width="8%">'._("Timeouts").'</th>
 		 		              <th width="10%">'._("Total Words(Approved)").'</th>
 		 		              <th width="15%">'._("Detail Report").'</th>
 		 		            </tr>';
 		foreach($reports as $report){
 		$new_html .= '<tr>
 		 		              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
 		 		              <td width="20%"><a href="javascript: void(0);">'.$report['name'].'</a></td>
 		 		              <td width="10%">'.$report['approved'].'</td>
 		 		              <td width="10%">'.$report['published'].'</td>
 		 		              <td width="10%">'.$report['submitted'].'</td>
 		 		              <td width="10%">'.$report['rejected'].'</td>
 		 		              <td width="9%">'.$report['total_rejections'].'</td>
 		 		              <td width="8%">'.$report['timeouts'].'</td>
 		 		              <td width="10%">'.$report['words'].'</td>
 		 		              <td width="15%">
 		 		              	<a href="javascript: void(0);" class="detail_report" rel="'.$report['id'].'"><button type="button" class="btn" name="detail" value="detail" title="Detail Report">'._("Detail").'</button></a>
 		 		              </td>
 		 		            </tr>';
 			$approved += $report['approved'];
 		 	$published += $report['published'];
 		 	$submitted += $report['submitted'];
 		 	$rejected += $report['rejected'];
 		 	$total_rejected += $report['total_rejections'];
			$timeouts += $report['timeouts'];
 		 		 		            
 		}
 		$new_html .= '<tr class="success">
 		 		              <td width="1%"><i class="icon-hand-right"></i></td>
 		 		              <td width="20%"><b>Totals</b></td>
 		 		              <td width="10%"><b>'.$approved.'</b></td>
 		 		              <td width="10%"><b>'.$published.'</b></td>
 		 		              <td width="10%"><b>'.$submitted.'</b></td>
 		 		              <td width="10%"><b>'.$rejected.'</b></td>
 		 		              <td width="9%"><b>'.$total_rejected.'</b></td>
 		 		              <td width="8%"><b>'.$timeouts.'</b></td>
 		 		              <td width="10%"><b>&nbsp;</b></td>
 		 		              <td width="15%"><b>&nbsp;</b></td>
 		 		            </tr>';
 		echo $new_html; 		            
 	}
 	
 	function detail_report($writer_id = null, $start_date = null, $end_date = null){
 		if($this->session->userdata('id') != 0 && $this->session->userdata('role') && $this->session->userdata('role') == "admin"){
 			if($writer_id && is_numeric($writer_id)){
 				$this->load->model('admin/Mreports');
 				if($start_date && $end_date && strtotime($start_date) <= strtotime($end_date)){
 					$start_time = strtotime($start_date);
 					$data['detail_report'] = $this->Mreports->get_detail_report($writer_id,date('Y-m-d H:i:s',$start_time),date('Y-m-d H:i:s',strtotime($end_date.' + 1 days')));
 				}else{
 					$data['detail_report'] = $this->Mreports->get_detail_report($writer_id);
 				}
 				//$this->load->view('admin/detail_report',$data);
 				$data['page'] = 'admin/detail_report';
 				$data['title'] = 'Detail report';
 					
 				$this->load->view('shell', $data);
 			}else{
 				redirect(base_url().'admin/reports');
 			}
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function checking_text($article_id){
 		//$response = array('error'=>1,'message'=>_("Article Id Missing"),'data'=>'');
 		if($article_id && is_numeric($article_id)){
 			$this->wdb->select('content');
 			$content = $this->wdb->get_where('submitted_articles',array('article_id'=>$article_id))->result_array();
 			if(!empty($content)){
 				$this->load->helper('copyscape_premium_api');
 				$data = copyscape_api_text_search_internet($content['0']['content'],'UTF-8');
 				//print_r($data); die();
 				/*$data = array(
 							'query_words'=>'',
 							'count' => '',
 							'result'=> array('htmlsnippet'=>'<font color=\"#777777\">... <\/font><font color=\"#000000\">View&gt;Normal&lt;\/w:View&gt; &lt;w:Zoom&gt;0&lt;\/w:Zoom&gt; &lt;w:TrackMoves \/&gt; &lt;w:TrackFormatting \/&gt; &lt;w:PunctuationKerning \/&gt; &lt;w:ValidateAgainstSchemas \/&gt; &lt;w:SaveIfXMLInvalid <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">IgnoreMixedContent&gt;false&lt;\/w:IgnoreMixedContent&gt; &lt;w:AlwaysShowPlaceholderText&gt;false&lt;\/w:AlwaysShowPlaceholderText&gt; &lt;w:DoNotPromoteQF \/&gt; &lt;w:LidThemeOther&gt;EN-US&lt;\/w:LidThemeOther&gt; &lt;w:LidThemeAsian&gt;X-NONE&lt;\/w:LidThemeAsian <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LidThemeComplexScript&gt; &lt;w:Compatibility&gt; &lt;w:BreakWrappedTables \/&gt; &lt;w:SnapToGridInCell \/&gt; &lt;w:WrapTextWithPunct \/&gt; &lt;w:<\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">UseAsianBreakRules \/&gt; &lt;w:DontGrowAutofit \/&gt; &lt;w:SplitPgBreakAndParaMark \/&gt; &lt;w:EnableOpenTypeKerning \/&gt; &lt;w:DontFlipMirrorIndents \/&gt; &lt;w <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">intLim m:val="subSup" \/&gt; &lt;m:naryLim m:val="undOvr" \/&gt; &lt;\/m:mathPr&gt;&lt;\/w:WordDocument&gt; &lt;\/xml&gt;&lt;![<\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">endif]--&gt;&lt;!--[if gte mso 9]&gt;&lt;xml&gt; &lt;w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true" DefSemiHidden <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">true" DefQFormat="false" DefPriority="99" LatentStyleCount="267"&gt; &lt;w:LsdException Locked="<\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">false" Priority="0" SemiHidden="false" UnhideWhenUsed="false" QFormat="true <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="35" QFormat="true" Name="caption" \/&gt; &lt;w:LsdException Locked="false" Priority="10 <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="<\/font><font color=\"#777777\">1" <\/font><font color=\"#000000\">Name="Default Paragraph Font" \/&gt; &lt;w:LsdException Locked="false" Priority="11" SemiHidden="false <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="71" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Shading" \/&gt; &lt;w:LsdException Locked="false" Priority="72" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful List" \/&gt; &lt;w: <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="73" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Grid" \/&gt; &lt;w:LsdException Locked="false <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" UnhideWhenUsed="false" Name="Revision" \/&gt; &lt;w: <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="34" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="List Paragraph" \/&gt; &lt;w:LsdException Locked="false <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="19" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Subtle Emphasis" \/&gt; &lt;w:LsdException Locked="false <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">Priority="21" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Intense Emphasis" \/&gt; &lt;w:LsdException Locked="false" Priority="<\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">31" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Subtle Reference" \/&gt; &lt;w:LsdException Locked="false" Priority="32 <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="39" QFormat="true" Name="TOC Heading" \/&gt; &lt;\/w:LatentStyles&gt; &lt;\/xml&gt;&lt;![endif]--&gt;&lt;!--[if gte mso 10]&gt; &lt;<\/font><font color=\"#777777\">mce:style <\/font>"','minwordsmatched' => '275')
 						);
 				$response = array('error'=>0,'message'=>'','data'=>'Number of website Found');*/
 				//echo '<font color=\"#777777\">... <\/font><font color=\"#000000\">View&gt;Normal&lt;\/w:View&gt; &lt;w:Zoom&gt;0&lt;\/w:Zoom&gt; &lt;w:TrackMoves \/&gt; &lt;w:TrackFormatting \/&gt; &lt;w:PunctuationKerning \/&gt; &lt;w:ValidateAgainstSchemas \/&gt; &lt;w:SaveIfXMLInvalid <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">IgnoreMixedContent&gt;false&lt;\/w:IgnoreMixedContent&gt; &lt;w:AlwaysShowPlaceholderText&gt;false&lt;\/w:AlwaysShowPlaceholderText&gt; &lt;w:DoNotPromoteQF \/&gt; &lt;w:LidThemeOther&gt;EN-US&lt;\/w:LidThemeOther&gt; &lt;w:LidThemeAsian&gt;X-NONE&lt;\/w:LidThemeAsian <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LidThemeComplexScript&gt; &lt;w:Compatibility&gt; &lt;w:BreakWrappedTables \/&gt; &lt;w:SnapToGridInCell \/&gt; &lt;w:WrapTextWithPunct \/&gt; &lt;w:<\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">UseAsianBreakRules \/&gt; &lt;w:DontGrowAutofit \/&gt; &lt;w:SplitPgBreakAndParaMark \/&gt; &lt;w:EnableOpenTypeKerning \/&gt; &lt;w:DontFlipMirrorIndents \/&gt; &lt;w <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">intLim m:val="subSup" \/&gt; &lt;m:naryLim m:val="undOvr" \/&gt; &lt;\/m:mathPr&gt;&lt;\/w:WordDocument&gt; &lt;\/xml&gt;&lt;![<\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">endif]--&gt;&lt;!--[if gte mso 9]&gt;&lt;xml&gt; &lt;w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true" DefSemiHidden <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">true" DefQFormat="false" DefPriority="99" LatentStyleCount="267"&gt; &lt;w:LsdException Locked="<\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">false" Priority="0" SemiHidden="false" UnhideWhenUsed="false" QFormat="true <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="35" QFormat="true" Name="caption" \/&gt; &lt;w:LsdException Locked="false" Priority="10 <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="<\/font><font color=\"#777777\">1" <\/font><font color=\"#000000\">Name="Default Paragraph Font" \/&gt; &lt;w:LsdException Locked="false" Priority="11" SemiHidden="false <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="71" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Shading" \/&gt; &lt;w:LsdException Locked="false" Priority="72" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful List" \/&gt; &lt;w: <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="73" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Grid" \/&gt; &lt;w:LsdException Locked="false <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" UnhideWhenUsed="false" Name="Revision" \/&gt; &lt;w: <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="34" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="List Paragraph" \/&gt; &lt;w:LsdException Locked="false <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="19" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Subtle Emphasis" \/&gt; &lt;w:LsdException Locked="false <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">Priority="21" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Intense Emphasis" \/&gt; &lt;w:LsdException Locked="false" Priority="<\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">31" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Subtle Reference" \/&gt; &lt;w:LsdException Locked="false" Priority="32 <\/font><font color=\"#777777\">... <\/font><font color=\"#000000\">LsdException Locked="false" Priority="39" QFormat="true" Name="TOC Heading" \/&gt; &lt;\/w:LatentStyles&gt; &lt;\/xml&gt;&lt;![endif]--&gt;&lt;!--[if gte mso 10]&gt; &lt;<\/font><font color=\"#777777\">mce:style <\/font>';
 				//exit;
 				$response = '<td><div class="control-group"><label class="control-label" for="inputEmail">'._("Result").':</label><div class="controls" id="copyscape_result"></div></div></td>';
 				$response .= '<td><div class="control-group">';
 				$response .= '<label class="control-label" for="inputEmail">'._("Total word queried").'</label>';
 				$response .= '<div class="controls">';
 				$response .= '<p class="lead">'.$data['querywords'].'</p>';
 				$response .= '</div></div></td>';
 				
 				$response .= '<td><div class="control-group">';
 				$response .= '<label class="control-label" for="inputEmail">'._("Total Website Found").'</label>';
 				$response .= '<div class="controls">';
 				$response .= '<p class="lead">'.$data['count'].'</p>';
 				$response .= '</div></div></td>';
 				if(!empty($data['result'])){
 					$response .= '<td><table border=0 cellspacing=\"2px\" class="table table-bordered table-striped" >';
 					$response .= '<tr><th>Website</th><th>Title</th><th>Minimum words matched</th></tr>';
 					$response .= '<tbody>';
 					$count = 0;
 					foreach($data['result'] as $values){
 						if($count < 10){
 							$response .= '<tr><td><a href=\"'.$values['url'].'\" target=\"_blank\">'.$values['url'].'</a></td><td>'.$values['title'].'</td><td>'.$values['minwordsmatched'].'</td></tr>';
 						}else{
 							break;
 						}
 						$count++;
 					} 					
 					$response .= '</tbody></table></td>';
 				}
 				echo $response;
 				exit;
 			}else{
 				echo _("Article Not Found");
 				exit;
 			}
 		}else{
 			echo _("Article Id Wrong");
 			exit;
 		}
 	}
 	
 	function rejected(){
 		if($this->session->userdata('id') && $this->session->userdata('role') == 'admin'){
 			$data['rejected_articles_info'] = $this->Marticle->get_rejected_articles(array('submitted_articles.status'=>'declined'));
 			//$this->load->view('admin/rejected_articles',$data);
 			$data['page'] = 'admin/rejected_articles';
 			$data['title'] = 'Rejected articles';
 			
 			$this->load->view('shell', $data);
 		}else{
 			redirect(base_url());
 		}
 	}
 	
 	function logout(){
 		$this->session->set_userdata(array('id'=>0,'username'=>'','role'=>''));
 		$this->session->unset_userdata('id');
 		$this->session->unset_userdata('role');
 		$this->session->unset_userdata('logged_in');
 		$this->session->unset_userdata('user_id');
 		$this->session->unset_userdata('username');
 		//delete_cookie('name');
 		redirect(base_url());
 	}
 	
 	function testing(){
 		echo date('Y-m-d H:i:s').'<br />';
 		echo date('Y-m-d h:i:s');
 		//$array = Array ( ['querywords'] => 2566 ['count'] => 68 ['result'] => Array ( ['0'] => Array ( ['index'] => 1 ['url'] => 'http://lyncwidget.codeplex.com/' ['title'] => 'Lync Presence & Chat Widget - Home [textsnippet] => ... View>Normal</w:View> <w:Zoom>0</w:Zoom> <w:TrackMoves /> <w:TrackFormatting /> <w:PunctuationKerning /> <w:ValidateAgainstSchemas /> <w:SaveIfXMLInvalid ... IgnoreMixedContent>false</w:IgnoreMixedContent> <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText> <w:DoNotPromoteQF /> <w:LidThemeOther>EN-US</w:LidThemeOther> <w:LidThemeAsian>X-NONE</w:LidThemeAsian ... LidThemeComplexScript> <w:Compatibility> <w:BreakWrappedTables /> <w:SnapToGridInCell /> <w:WrapTextWithPunct /> <w:... UseAsianBreakRules /> <w:DontGrowAutofit /> <w:SplitPgBreakAndParaMark /> <w:EnableOpenTypeKerning /> <w:DontFlipMirrorIndents /> <w ... intLim m:val="subSup" /> <m:naryLim m:val="undOvr" /> </m:mathPr></w:WordDocument> </xml><![... endif]--><!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true" DefSemiHidden ... true" DefQFormat="false" DefPriority="99" LatentStyleCount="267"> <w:LsdException Locked="... false" Priority="0" SemiHidden="false" UnhideWhenUsed="false" QFormat="true ... LsdException Locked="false" Priority="35" QFormat="true" Name="caption" /> <w:LsdException Locked="false" Priority="10 ... LsdException Locked="false" Priority="1" Name="Default Paragraph Font" /> <w:LsdException Locked="false" Priority="11" SemiHidden="false ... LsdException Locked="false" Priority="71" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Shading" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful List" /> <w: ... LsdException Locked="false" Priority="73" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Grid" /> <w:LsdException Locked="false ... LsdException Locked="false" UnhideWhenUsed="false" Name="Revision" /> <w: ... LsdException Locked="false" Priority="34" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="List Paragraph" /> <w:LsdException Locked="false ... LsdException Locked="false" Priority="19" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Subtle Emphasis" /> <w:LsdException Locked="false ... Priority="21" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Intense Emphasis" /> <w:LsdException Locked="false" Priority="... 31" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Subtle Reference" /> <w:LsdException Locked="false" Priority="32 ... LsdException Locked="false" Priority="39" QFormat="true" Name="TOC Heading" /> </w:LatentStyles> </xml><![endif]--><!--[if gte mso 10]> <mce:style' ['htmlsnippet'] => '... View&gt;Normal&lt;/w:View&gt; &lt;w:Zoom&gt;0&lt;/w:Zoom&gt; &lt;w:TrackMoves /&gt; &lt;w:TrackFormatting /&gt; &lt;w:PunctuationKerning /&gt; &lt;w:ValidateAgainstSchemas /&gt; &lt;w:SaveIfXMLInvalid ... IgnoreMixedContent&gt;false&lt;/w:IgnoreMixedContent&gt; &lt;w:AlwaysShowPlaceholderText&gt;false&lt;/w:AlwaysShowPlaceholderText&gt; &lt;w:DoNotPromoteQF /&gt; &lt;w:LidThemeOther&gt;EN-US&lt;/w:LidThemeOther&gt; &lt;w:LidThemeAsian&gt;X-NONE&lt;/w:LidThemeAsian ... LidThemeComplexScript&gt; &lt;w:Compatibility&gt; &lt;w:BreakWrappedTables /&gt; &lt;w:SnapToGridInCell /&gt; &lt;w:WrapTextWithPunct /&gt; &lt;w:... UseAsianBreakRules /&gt; &lt;w:DontGrowAutofit /&gt; &lt;w:SplitPgBreakAndParaMark /&gt; &lt;w:EnableOpenTypeKerning /&gt; &lt;w:DontFlipMirrorIndents /&gt; &lt;w ... intLim m:val="subSup" /&gt; &lt;m:naryLim m:val="undOvr" /&gt; &lt;/m:mathPr&gt;&lt;/w:WordDocument&gt; &lt;/xml&gt;&lt;![... endif]--&gt;&lt;!--[if gte mso 9]&gt;&lt;xml&gt; &lt;w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true" DefSemiHidden ... true" DefQFormat="false" DefPriority="99" LatentStyleCount="267"&gt; &lt;w:LsdException Locked="... false" Priority="0" SemiHidden="false" UnhideWhenUsed="false" QFormat="true ... LsdException Locked="false" Priority="35" QFormat="true" Name="caption" /&gt; &lt;w:LsdException Locked="false" Priority="10 ... LsdException Locked="false" Priority="1" Name="Default Paragraph Font" /&gt; &lt;w:LsdException Locked="false" Priority="11" SemiHidden="false ... LsdException Locked="false" Priority="71" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Shading" /&gt; &lt;w:LsdException Locked="false" Priority="72" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful List" /&gt; &lt;w: ... LsdException Locked="false" Priority="73" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Grid" /&gt; &lt;w:LsdException Locked="false ... LsdException Locked="false" UnhideWhenUsed="false" Name="Revision" /&gt; &lt;w: ... LsdException Locked="false" Priority="34" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="List Paragraph" /&gt; &lt;w:LsdException Locked="false ... LsdException Locked="false" Priority="19" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Subtle Emphasis" /&gt; &lt;w:LsdException Locked="false ... Priority="21" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Intense Emphasis" /&gt; &lt;w:LsdException Locked="false" Priority="... 31" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Subtle Reference" /&gt; &lt;w:LsdException Locked="false" Priority="32 ... LsdException Locked="false" Priority="39" QFormat="true" Name="TOC Heading" /&gt; &lt;/w:LatentStyles&gt; &lt;/xml&gt;&lt;![endif]--&gt;&lt;!--[if gte mso 10]&gt; &lt;mce:style [minwordsmatched] => 275 ) [1] => Array ( [index] => 2 [url] => http://www.nikonusa.com/en/Nikon-Products/Camera-Lenses/CloseUp-Macro/index.page [title] => Macro Lens | Macro Photography Lenses| Close-up Lens| Nikon [textsnippet] => ... BreakWrappedTables /> <w:SnapToGridInCell /> <w:WrapTextWithPunct /> <w:UseAsianBreakRules /> <w:DontGrowAutofit /> <w ... WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true" DefSemiHidden ... LsdException Locked="false" Priority="9" SemiHidden="false" UnhideWhenUsed="false" QFormat="true ... LsdException Locked="false" Priority="1" Name="Default Paragraph Font" /> <w:LsdException Locked="false" Priority="11" SemiHidden="false ... LsdException Locked="false" Priority="71" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Shading" /> <w:LsdException Locked="false" Priority="72" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful List" /> <w: ... LsdException Locked="false" Priority="34" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="List Paragraph" /> <w:LsdException Locked="false" Priority="29 ... LsdException Locked="false" Priority="19" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Subtle Emphasis" /> <w:LsdException Locked ... false" Priority="21" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="Intense Emphasis" /> <w:LsdException Locked="false" Priority="31" SemiHidden="false ... LsdException Locked="false" Priority="39" QFormat="true" Name="TOC Heading" /> </w:LatentStyles> </xml><![endif]--><!--[if gte mso 10]> <mce:style [htmlsnippet] => ... BreakWrappedTables /&gt; &lt;w:SnapToGridInCell /&gt; &lt;w:WrapTextWithPunct /&gt; &lt;w:UseAsianBreakRules /&gt; &lt;w:DontGrowAutofit /&gt; &lt;w ... WordDocument&gt; &lt;/xml&gt;&lt;![endif]--&gt;&lt;!--[if gte mso 9]&gt;&lt;xml&gt; &lt;w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="true" DefSemiHidden ... LsdException Locked="false" Priority="9" SemiHidden="false" UnhideWhenUsed="false" QFormat="true ... LsdException Locked="false" Priority="1" Name="Default Paragraph Font" /&gt; &lt;w:LsdException Locked="false" Priority="11" SemiHidden="false ... LsdException Locked="false" Priority="71" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful Shading" /&gt; &lt;w:LsdException Locked="false" Priority="72" SemiHidden="false" UnhideWhenUsed="false" Name="Colorful List" /&gt; &lt;w: ... LsdException Locked="false" Priority="34" SemiHidden="false" UnhideWhenUsed="false" QFormat="true" Name="List Paragraph" /&gt; &lt;w:LsdException Locked="false" Priority="29 ... LsdException Locked="false" Priority="19
 		//print_r($array);
 		die();
 	}
 		
}