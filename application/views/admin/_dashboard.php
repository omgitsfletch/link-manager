<html>
	<head>
		<script type='text/javascript' src="http://code.jquery.com/jquery-1.7.2.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".link").click(function(){
					var div_id = $(this).attr("rel");
					//alert(div_id);
					$("#menu ul li").each(function(index) {
						$("#menu ul li:nth-child("+(index+1)+")").removeClass("active");
					});
					$(".main_content").each(function(index) {
						//$(this).css("display","none");
						//$(".main_content div:nth-child("+(index+1)+")").css("display","none");
						//alert($(this).attr('id'));
						$("#waiting_articles").css("display","none");
						$("#approved_articles").css("display","none");
						$("#published_articles").css("display","none");
						$("#declined_articles").css("display","none");
					});
					$(this).parent().addClass("active");
					$("#"+div_id).css("display","block");		
				});				
			});
		</script>
		<style>
			
			.error{
				border:1px solid;
				border-color:red;
			}
		</style>
	</head>
	<body>
	
		<div id="wrapper">
			<div class="add_link">
				<a href="#add_form">Add New Article</a>
				<a href="<?php echo base_url().'admin/logout';?>"><?php echo _("Logout");?></a>
			</div>
			<div id="menu">         
	          <ul>
	             <li id="li-1" class="active"><a href="javascript: void(0);" class="link" rel="waiting_articles"><?php echo _("Waiting");?></a></li>
	             <li id="li-2" ><a href="javascript: void(0);" class="link" rel="approved_articles"><?php echo _("Approved");?></a></li>
	             <li id="li-3" ><a href="javascript: void(0);" class="link" rel="published_articles"><?php echo _("Published");?></a></li>
	             <li id="li-4" ><a href="javascript: void(0);" class="link" rel="declined_articles"><?php echo _("Declined");?></a></li>	             
	          </ul>           
	          <div class="clear"></div>
	        </div>
	        <div class="main_content">
	        	<div id="waiting_articles">
	        		<?php if(!empty($waiting_articles)):?>
	        		<form>
	        			<table border="1px">
	        				<thead>
	        				<tr>
	        					<td><?php echo _("Article Id");?></td>
	        					<td><?php echo _("Writer Name");?></td>
	        					<td><?php echo _("Title");?></td>
	        					<td><?php echo _("Submitted Date");?></td>
	        					<td><?php echo _("Action");?></td>
	        				</tr>
	        				</thead>
	        				<tbody>
	        				<?php foreach($waiting_articles as $values):?>
	        				<tr>
	        					<td><?php echo $values['article_id'];?></td>
	        					<?php
	        						$writer_name = $this->db->get_where('writers',array('id'=>$values['writer_id']))->result_array();	        						 
	        					?>
	        					<td><?php echo $writer_name['0']['name'];?></td>
	        					<td><?php echo $values['title'];?></td>
	        					<td><?php echo $values['submitted_date'];?></td>
	        					<td>
	        						<a href="<?php echo base_url().'admin/submitted_article/'.$values['article_id'].'/'.$values['writer_id'];?>"><?php echo _("View");?></a>
	        						<a href="#"><?php echo _("Approve");?></a>
	        						<a href="#"><?php echo _("Delete");?></a>
	        					</td>
	        				</tr>
	        				<?php endforeach;?>
	        				</tbody>
	        			</table>
	        		</form>
	        		<?php else :?>
	        		<div align="center"><?php echo _("No Articles are waiting for approval");?></div>
	        		<?php endif;?>
	        	</div>
	        	
	        	<div id="approved_articles" style="display: none;">
	        		<?php if(!empty($approved_articles)):?>
	        		 <form>
	        			<table border="1">
	        				<thead>
	        				<tr>
	        					<td><?php echo _("Article Id");?></td>
	        					<td><?php echo _("Writer Name");?></td>
	        					<td><?php echo _("Title");?></td>
	        					<td><?php echo _("Submitted Date");?></td>
	        					<td><?php echo _("Action");?></td>
	        				</tr>
	        				</thead>
	        				<tbody>
	        				<?php foreach($approved_articles as $values):?>
	        				<tr>
	        					<td><?php echo $values['article_id'];?></td>
	        					<?php
	        						$writer_name = $this->db->get_where('writers',array('id'=>$values['writer_id']))->result_array();	        						 
	        					?>
	        					<td><?php echo $writer_name['0']['name'];?></td>
	        					<td><?php echo $values['title'];?></td>
	        					<td><?php echo $values['submitted_date'];?></td>
	        					<td><a href="<?php echo base_url().'admin/approved_article/'.$values['article_id'].'/'.$values['writer_id'];?>"><?php echo _("View");?></td>
	        				</tr>
	        				<?php endforeach;?>
	        				</tbody>
	        			</table>
	        		</form>
	        		<?php else :?>
	        		<div align="center"><?php echo _("No approved Articles");?></div>
	        		<?php endif;?>
	        	</div>
	        	
	        	<div id="published_articles" style="display: none;">
	        		<?php if(!empty($published_articles)):?>
	        		<form>
	        			<table border="1">
	        				<thead>
	        				<tr>
	        					<td><?php echo _("Article Id");?></td>
	        					<td><?php echo _("Writer Name");?></td>
	        					<td><?php echo _("Title");?></td>
	        					<td><?php echo _("Submitted Date");?></td>
	        					<td><?php echo _("Action");?></td>
	        				</tr>
	        				</thead>
	        				<tbody>
	        				<?php foreach($published_articles as $values):?>
	        				<tr>
	        					<td><?php echo $values['article_id'];?></td>
	        					<?php
	        						$writer_name = $this->db->get_where('writers',array('id'=>$values['writer_id']))->result_array();	        						 
	        					?>
	        					<td><?php echo $writer_name['0']['name'];?></td>
	        					<td><?php echo $values['title'];?></td>
	        					<td><?php echo $values['submitted_date'];?></td>
	        					<td><a href="<?php echo base_url().'admin/approved_article/'.$values['article_id'].'/'.$values['writer_id'];?>"><?php echo _("View");?></a><ahref="<?php echo base_url().'admin/delete/published/'.$values['article_id'].'/'.$values['writer_id'];?>"><?php echo _("Delete");?></a></td>
	        				</tr>
	        				<?php endforeach;?>
	        				</tbody>
	        			</table>
	        		</form>
	        		<?php else :?>
	        		<div align="center"><?php echo _("No Published Articles");?></div>
	        		<?php endif;?>
	        	</div>
	        	
	        	<div id="declined_articles" style="display: none;">
	        		<?php if(!empty($decline_articles)):?>
	        		<form>
	        			<table border="1">
	        				<thead>
	        				<tr>
	        					<td><?php echo _("Article Id");?></td>
	        					<td><?php echo _("Writer Name");?></td>
	        					<td><?php echo _("Title");?></td>
	        					<td><?php echo _("Submitted Date");?></td>
	        					<td><?php echo _("Action");?></td>
	        				</tr>
	        				</thead>
	        				<tbody>
	        				<?php foreach($decline_articles as $values):?>
	        				<tr>
	        					<td><?php echo $values['article_id'];?></td>
	        					<?php
	        						$writer_name = $this->db->get_where('writers',array('id'=>$values['writer_id']))->result_array();	        						 
	        					?>
	        					<td><?php echo $writer_name['0']['name'];?></td>
	        					<td><?php echo $values['title'];?></td>
	        					<td><?php echo $values['submitted_date'];?></td>
	        					<td><a href="#"><?php echo _("View");?></a><a href="#"><?php echo _("Delete");?></a></td>
	        				</tr>
	        				<?php endforeach;?>
	        				</tbody>
	        			</table>
	        		</form>
	        		<?php else :?>
	        		<div align="center"><?php echo _("No Declined Articles");?></div>
	        		<?php endif;?>
	        	</div>
	        	
	        </div>
	        
	        <div id="added_article">
	        	<h4><?php echo _("Articles Yet To Written");?></h4>
	        	<?php if(!empty($added_articles)):?>
	        		<form>
	        			<table cellpading="5" cellspacing="5" border="1">
	        				<thead>
	        				<tr>
	        					<td><b><?php echo _("Article Topic");?></b></td>
	        					<td><b><?php echo _("Length");?></b></td>
	        					<td><b><?php echo _("Due Date (In days)");?></b></td>
	        					<td><b><?php echo _("Description");?></b></td>
	        					<td><b><?php echo _("Keywords");?></b></td>
	        					<td><b><?php echo _("urls");?></b></td>
	        					<td><b><?php echo _("Admin Notes");?></b></td>	        					
	        					<td><b><?php echo _("Submitted Date");?></b></td>
	        					<td><b><?php echo _("Action");?></b></td>
	        				</tr>
	        				</thead>
	        				<?php foreach($added_articles as $values):?>
	        				<tbody>
	        				<tr>
	        					<td><?php echo $values['topic'];?></td>
	        					<td><?php echo $values['length'];?></td>
	        					<td><?php echo $values['due_date'];?></td>
	        					<td><?php echo $values['description'];?></td>
	        					<td><?php echo $values['keywords'];?></td>
	        					<td><?php echo $values['urls'];?></td>
	        					<td><?php echo $values['admin_notes'];?></td>	        					
	        					<td><?php echo $values['date'];?></td>	        					
	        					<td><a href="#"><?php echo _("View");?></a><a href="#"><?php echo _("Delete");?></a></td>
	        				</tr>
	        				</tbody>
	        				<?php endforeach;?>
	        			</table>
	        		</form>
	        		<?php else :?>
	        		<div align="center"><?php echo _("No New Articles Yet To Be Written");?></div>
	        		<?php endif;?>
	        </div>
	        
	        <div id="add_form">
	        	<h4>Add New Article</h4>
					<?php //echo validation_errors(); ?>
					<?php if(isset($error)){
								$class='class="error"';
								$mess=$error;				
							}
					?>
					<form action="<?php echo base_url().'admin/add_article';?>" method="post">
	            		<fieldset>  
	            			<label for="article_topic">Article topic: </label>
	                    	<input type="text" value="<?php echo set_value('article_topic');?>" id="article_topic" name="article_topic" <?php if(form_error('article_topic')){echo 'class="error"';}?>/>
	                        <?php echo form_error('article_topic');?><br />
	                             
	                    	<label for="length">Length: </label>
	                    	<input type="text" value="<?php echo set_value('length');?>" id="length" name="length" <?php if(form_error('length')){echo 'class="error"';}?>/>
	                        <?php echo form_error('length');?><br /> 
	                                      
	                    	<label for="due_date">Due Date:</label>
	                    	<!-- <input type="password" value="<?php echo set_value('password');?>" id="password" name="password" <?php if(form_error('password')){echo 'class="error"';}?>/> -->
	                    	<select id="due_date" name="due_date">
	                    		<option value="1">1</option>
	                    		<option value="2">2</option>
	                    		<option value="3">3</option>
	                    		<option value="4">4</option>
	                    		<option value="5">5</option>
	                    		<option value="6">6</option>
	                    		<option value="7">7</option>	                    		
	                    	</select>
	 						<?php echo form_error('due_date');?><br />
	 						
	 						<label for="description">Description:</label>
	                    	<textarea id="description" name="description" rows="5" cols="50" <?php if(form_error('description')){echo 'class="error"';}?>></textarea>
	                    	<?php echo form_error('description');?><br />
	                    	
	                    	<label for="keywords">Keywords:</label>
	                    	<textarea id="keywords" name="keywords" rows="5" cols="50" <?php if(form_error('keywords')){echo 'class="error"';}?>></textarea>
	                    	<?php echo form_error('keywords');?><br /> 
	                    	
	                    	<label for="urls">Urls:</label>
	                    	<textarea id="urls" name="urls" rows="5" cols="50" <?php if(form_error('urls')){echo 'class="error"';}?>></textarea>
	                    	<p><?php echo form_error('urls');?></p>
	                    	
	                    	<label for="admin_note">Admin Note:</label>	                    	
	                    	<textarea id="admin_note" name="admin_note" rows="5" cols="50" <?php if(form_error('admin_note')){echo 'class="error"';}?>></textarea>
	                    	
	            			<input type="submit" value="Add This Article" tabindex="8" name="submit" class="newAccountButton" />
	                    	</p>
	                    </fieldset>
	            	</form>	        	
	        </div>
		</div>					
	</body>
</html>