<html>
	<head>
		<script type='text/javascript' src="http://code.jquery.com/jquery-1.7.2.js"></script>
		<script src="<?php echo base_url();?>assets/scripts/nicEdit.js" type="text/javascript"></script>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
				new nicEditor({iconsPath : '<?php echo base_url();?>assets/images/nicEditorIcons.gif'}).panelInstance('article_content');
			});
		</script>

		<style>			
			.error{
				border:1px solid;
				border-color:red;
			}
			.article_info{
				color: red;
			}
			
			.heading{
				font-sixe: 15px;
				font-weight: bold;
			}
		</style>
	</head>
	<body>
	
		<div id="wrapper">
			<div class="add_link">
				<a href="<?php echo base_url().'writer/logout'?>"><?php echo _("Logout");?></a><br />
				<a href="<?php echo base_url().'writer/dashboard'?>"><?php echo _("Home");?></a>
			</div>
	        <div class="main_content">
	        	<div id="decline_note">
	        		<fieldset>
		        		<span class="heading"><?php echo _("Admin Note");?>:</span><br />
		        		<span><?php echo $declined_article_info['0']['decline_note'];?></span>
	        		</fieldset>
	        	</div>
				
				<div class="error"><?php if(isset($error)){ echo $error;}?></div>
					        	
	        	<form action='' method="POST" >
	        		<fieldset>  
            			<label for="article_title">Article Title: </label>
                    	<input type="text" value="<?php if(isset($title)){ echo $title;}else{ echo $declined_article_info['0']['title']; }?>" id="article_title" name="article_title" /> <br />                       
                                            	
                    	<label for="article_content">Admin Note:</label>	                    	
                    	<textarea id="article_content" name="article_content" rows="10" cols="120" <?php if(isset($content)){echo 'class="error"';}?>><?php if(isset($content)){ echo $content;}else{ echo $declined_article_info['0']['content']; }?></textarea>
                    	                    	
                    	<input type='hidden' value='<?php echo $declined_article_info['0']['article_id'];?>' name='article_id' id='article_id' />
                    	<input type='hidden' value='<?php echo $declined_article_info['0']['due_time'];?>' name='due_date' id='due_date' />
                    	<input type='hidden' value='<?php echo $declined_article_info['0']['claimed_time'];?>' name='claimed_date' id='claimed_date' />
            			<input type="submit" value="Submit" tabindex="2" name="submit" class="newAccountButton" />                    	
                    </fieldset>
	        	</form>
	        	
	        	<div id="required_info">	        		  
            		<label>Minimum length required: <span class='article_info'><?php echo $info_required['0']['length'];?></span></label><br />
            		<label>Keywords required: <span class='article_info'><?php echo $info_required['0']['keywords'];?></span></label><br />
            		<label>Urls required: <span class='article_info'><?php echo $info_required['0']['urls'];?></span></label>            		
	        	</div>
	        </div>
	        <?php //echo @$result;?><br >
	        <?php //echo @$result1;?>
		</div>					
	</body>
</html>