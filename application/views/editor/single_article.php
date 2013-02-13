<html>
	<head>
		<?php if($current_page_is == 'submitted'){?>
		<script type='text/javascript' src="http://code.jquery.com/jquery-1.7.2.js"></script>
		<script src="<?php echo base_url();?>assets/scripts/nicEdit.js" type="text/javascript"></script>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
				new nicEditor({iconsPath : '<?php echo base_url();?>assets/images/nicEditorIcons.gif'}).panelInstance('decline_note');
			});
		</script>
		<?php }?>
		<style>
			.heading{
				font-size: 15px;
				font-weight: bold;
			}
			.article_info{
				padding: 10px;
			}
		</style>
	</head>
	<body>
	
		<div id="wrapper">
			<div class="add_link">
				<a href="<?php echo base_url().'editor/dashboard';?>"><?php echo _("Back to Dashboard");?></a><br />
				<a href="<?php echo base_url().'editor/logout';?>"><?php echo _("Logout");?></a>
			</div>
	        <div class="main_content">
	        	<div id="submitted_articles">
	        		<?php if(!empty($article_info)):?>
	        		<div id="writer_name" class="article_info" >
						<span class="heading"><?php echo _("Writer Name");?>:</span>
						<span>	<?php
	        						$writer_name = $this->db->get_where('writers',array('id'=>$article_info['0']['writer_id']))->result_array();	        						 
	        						echo $writer_name['0']['name'];
	        					?>
	        			</span>
					</div>
					
					<div id="article_title" class="article_info">
						<span class="heading"><?php echo _("Article Title");?>:</span>
						<span><?php echo $article_info['0']['title'];?></span>
					</div>
					
					<div class="article_info">
						<span class="heading"><?php echo _("Content");?>:</span>
						<fieldset><?php echo $article_info['0']['content'];?></fieldset>
					</div>
					<?php if($current_page_is == 'submitted'){?>				
					<div class="article_info">
						<form action="<?php echo base_url().'editor/approve_article'?>" method="POST">
							<input type='hidden' value='<?php echo $article_info['0']['article_id'];?>' id='article_id' name='article_id' />
        					<input type='hidden' value='<?php echo $article_info['0']['writer_id'];?>' id='writer_id' name='writer_id' />
							<input type="submit" name="approve" id="approve" value="<?php echo _("Approve");?>" />
						</form> 
					</div>
					<div align="center" class="article_info"><?php echo _("OR");?></div>
					<div class="article_info">
						<form action="<?php echo base_url().'editor/decline_article'?>" method="POST">
							<input type='hidden' value='<?php echo $article_info['0']['article_id'];?>' id='article_id' name='article_id' />
        					<input type='hidden' value='<?php echo $article_info['0']['writer_id'];?>' id='writer_id' name='writer_id' />
        					<textarea id="decline_note" name="decline_note" rows="10" cols="120" ></textarea>
							<input type="submit" name="approve" id="approve" value="<?php echo _("Decline");?>" />
						</form> 
					</div>
					<?php }?>
					
					<?php if($current_page_is == 'approved'){?>
					<div class="article_info">
					<form action="<?php echo base_url().'editor/publish_article'?>" method="POST">
						<input type='hidden' value='<?php echo $article_info['0']['article_id'];?>' id='article_id' name='article_id' />
        					<input type='hidden' value='<?php echo $article_info['0']['writer_id'];?>' id='writer_id' name='writer_id' />
						<input type="submit" name="publish" id="publish" value="<?php echo _("Publish It");?>" />
					</form> 
					</div>
					<?php }?>
					
	        		<?php else :?>
	        		<div align="center"><?php echo _("No Articles found.");?></div>
	        		<?php endif;?>
	        	</div>
	        </div>   	
		</div>					
	</body>
</html>