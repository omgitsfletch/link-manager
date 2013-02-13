<script src="<?php echo base_url();?>assets/scripts/thickbox.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/writer_css/thickbox.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/writer_css/tipsy.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery.tipsy.js"></script>
<input type="hidden" class="numeric" id="items_per_page" name="items_per_page" value="10">
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery.pagination.js" ></script>
<link href="<?php echo base_url();?>assets/writer_css/pagination.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
<?php
		$member_assigned = 'var members_assigned = new Array();';
		$member_assigned = 'var members_assigned = '.count($asigned_articles_info).';';
		echo $member_assigned;
		
		$member_claimed = 'var members_claimed = new Array();';
		$member_claimed = 'var members_claimed = '.count($claimed_article_info).';';
		echo $member_claimed;
		
		$member_available = 'var members_available = new Array();';
		$member_available = 'var members_available = '.count($available_article_info).';';
		echo $member_available;
?>
   $(document).ready(function(){
       $('.time_left').tipsy({gravity: 'e'}); // nw | n | ne | w | e | sw | s | se

       $('.delete').click(function(){
            var conf = confirm("Are you sure you want to delete this article?");
    	    if(conf == true){
    	    	window.location = '<?php echo base_url();?>admin/delete_available/'+$(this).attr('rel');
    	    	//alert('<?php echo base_url();?>admin/delete_available/'+$(this).attr('rel'));
    	    }
       });
       $('.btn').tooltip();
       $('.pop').popover({placement: 'top'});
   });
</script>
<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/scripts/articles.js"></script> -->
<style>
	.form-horizontal .control-label{
		width: 134px;
	}
	.form-horizontal .controls{
		margin-left: 150px;
	}
</style>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
        <?php if(!empty($asigned_articles_info)){?>
        <!-- ##################### ASSIGNED ARTICLES ################################### -->
          <div class="head_wrap">
            <h2><?php echo _("Assigned");?> (<?php echo count($asigned_articles_info);?>)</h2>
            <div class="clear">&nbsp;</div>
          </div>
          <table id="assined_table" class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <!-- <th width="10%">#</th> -->
              <th width="34%"><?php echo _("Main Topic");?></th>
              <th width="15%"><?php echo _("Assigned To");?></th>
              <th width="10%"><?php echo _("Assigned On");?></th>
              <th width="10%"><?php echo _("Status");?></th>
              <th width="20%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($asigned_articles_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
              <!-- <td width="10%"><?php echo $values['article_id'];?></td> -->
              <td width="34%">
              	<a title="<?php echo $values['topic'];?>" rel="popover" class="pop" href="javascript: void(0);">
              		<?php 
              			if(strlen($values['topic']) >= 40){
	              			echo substr($values['topic'],0,40).'...';
	              		}else{
	              			echo $values['topic'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="15%"><?php echo $values['name'];?></td>
              <td width="10%"><?php $timestamp = strtotime($values['assigned_time']); echo date('D', $timestamp);?>, <?php echo date('m-d-Y',$timestamp)?></td>
              <td width="10%"><?php if($values['status']){ echo _("Accepted");}else{ echo _("Pending"); }?></td>
              <td width="20%">
                <span class="btn"><?php echo $values['due_date'];?></span>
                 <span class="btn"><?php echo $values['length'];?></span>
              </td>
            </tr>
            <?php }?>
          </table>
        	<div id="Pagination_assigned" <?php if(count($asigned_articles_info) == 0){?>style="display: none;"<?php }?>></div>
        <?php }?>
        <!-- ##################### CLAIMED ARTICLES ################################### -->
          <div class="head_wrap">
            <h2><?php echo _("Claimed");?> (<?php echo count($claimed_article_info);?>)</h2>
            <div class="clear">&nbsp;</div>
          </div>

          <?php if(!empty($claimed_article_info)){?>
          <table id="claimed_table" class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <!-- <th width="10%">#</th> -->
              <th width="34%"><?php echo _("Main Topic");?></th>
              <th width="25%"><?php echo _("Claimed By");?></th>
              <th width="10%"><?php echo _("Time Left");?></th>
              <th width="20%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($claimed_article_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
              <!-- <td width="10%"><?php echo $values['article_id'];?></td> -->
              <td width="34%">
              	<a title="<?php echo $values['topic'];?>" rel="popover" class="pop" href="javascript: void(0);">
              		<?php 
              			if(strlen($values['topic']) >= 40){
	              			echo substr($values['topic'],0,40).'...';
	              		}else{
	              			echo $values['topic'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="25%"><?php echo $values['name'];?></td>
                <?php
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
        			  //$time = round(($time_left)/3600,2);
        		?>
              <td width="10%"><?php echo $time;?></td>
              <td width="20%">
                <a href="javascript: void(0);" original-title="<?php echo $time.' left';?>" class="time_left"><span class="btn" title=""><?php echo $values['due_time'];?></span></a>
                <span class="btn"><?php echo $values['length'];?></span>
              </td>
            </tr>
            <?php }?>
          </table>
          <div id="Pagination_claimed" <?php if(count($claimed_article_info) == 0){?>style="display: none;"<?php }?>></div>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Claimed Articles");?></div>
          <?php }?>
          <!-- ##################### AVAILABLE ARTICLES ################################### -->
          
          <div class="head_wrap">
            <h2><?php echo _("Available");?> (<?php echo count($available_article_info);?>)</h2>
            <div class="links">
            	<!-- <a href="<?php echo base_url();?>admin/add"><?php echo _("Add Article");?></a> -->
            	<a href="#TB_inline?height=480&width=800&inlineId=add_article" class="thickbox"><?php echo _("Add Article");?></a>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          
          <?php if(!empty($available_article_info)){?>
          <table id="available_table" class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <!-- <th width="5%">#</th> -->
              <th width="34%"><?php echo _("Main Topic");?></th>
              <th width="35%"><?php echo _("Description");?></th>
              <th width="25%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($available_article_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-plus-sign"></i></td>
              <!-- <td width="5%"><?php echo $values['article_id'];?></td> -->
              <td width="34%">
              	<a title="<?php echo $values['topic'];?>" rel="popover" class="pop" href="javascript: void(0);">
              		<?php 
              			if(strlen($values['topic']) >= 40){
	              			echo substr($values['topic'],0,40).'...';
	              		}else{
	              			echo $values['topic'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="35%">
              	<a title="<?php echo $values['description'];?>" rel="popover" class="pop" href="javascript: void(0);">
              		<?php 
              			if(strlen($values['description']) >= 40){
	              			echo substr($values['description'],0,40).'...';
	              		}else{
	              			echo $values['description'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="25%">
                 <span class="btn"><?php echo $values['due_date'];?></span>
                 <span class="btn"><?php echo $values['length'];?></span>
                 <a href="<?php echo base_url();?>admin/available/<?php echo $values['article_id'];?>"><span class="btn" title="Edit"><i class="icon-edit"></i></span></a>
                 <a class="delete" rel="<?php echo $values['article_id'];?>" href="javascript: void(0);"><span class="btn" title="Delete"><i class="icon-remove-circle"></i></span></a>
                 <a href="#assign_article" data-toggle="modal" class="assigning_class" rel="<?php echo $values['article_id'];?>"><button type="button" class="btn" name="assign" value="assign"><?php echo _("Assign");?></button></a>
              </td> 
            </tr>
            <?php }?>
          </table>
          <div id="Pagination_available" <?php if(count($available_article_info) == 0){?>style="display: none;"<?php }?>></div>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Available Articles");?></div>
          <?php }?>
        </div>
        
                  
          <!-- ####################### Add Article Tooltip ################################# -->
        <div id="add_article" class="table_wrap" style="display: none;">
          <div class="head_wrap">
            <h2><?php echo _("Add Article");?></h2>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
              	<form action="<?php echo base_url().'admin/add';?>" method="post" class="form-horizontal" id="add_popup">
                  <div class="control-group" style="float: left;">
                    <label class="control-label" for="article_topic"><?php echo _("Article topic");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="text" value="" id="article_topic" name="article_topic" style="width: 228px;"/>
                    </div>
                  </div>
                                      	
                  <div class="control-group" style="float: left;">
                    <label class="control-label" for="length" style="width: 90px;"><?php echo _("Length");?>: </label>
                    <div class="controls" style="margin-left: 100px;">
                      <input class="input-small" type="text" value="" id="length" name="length" style="width: 36px;"/>
                    </div>
                  </div>
                  
                  <div class="control-group" style="float: left;">
                     <label class="control-label" for="due_date" style="width: 90px;"><?php echo _("Due Date")?>:</label>
                    <div class="controls" style="margin-left: 100px;">
                      <select id="due_date" name="due_date" style="width: 50px;">
                    		<option value="1">1</option>
                    		<option value="2">2</option>
                    		<option value="3">3</option>
                    		<option value="4">4</option>
                    		<option value="5">5</option>
                    		<option value="6">6</option>
                    		<option value="7">7</option>	                    		
                    	</select>
                    </div>
                  </div>
                  <div class="clear"></div>
                  
                  <div class="control-group">
                    <label class="control-label" for="description"><?php echo _("Description");?>:</label>
                    <div class="controls">
                      <textarea id="description" name="description" rows="2" class="input-xxlarge"></textarea>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="keywords"><?php echo _("Keywords");?>:<br />(<?php echo _("Comma separated");?>)</label>
                    <div class="controls">
                      <textarea id="keywords" name="keywords" rows="1" class="input-xxlarge"></textarea>
                    </div>
                  </div>
                  
                  <div class="control-group" style="float: left;">
                    <label class="control-label" for="anchor_text"><?php echo _("Anchor Text");?>:<br />(<?php echo _("Comma separated");?>)</label>
                    <div class="controls">
                      <textarea id="anchor_text" name="anchor_text" rows="1" class="input-small" style="width: 182px;"></textarea>
                    </div>
                  </div>
                  
                  <div class="control-group" style="float: left;">
                    <label class="control-label" for="urls" style="width: 141px;"><?php echo _("Urls");?>:<br />(<?php echo _("Comma separated");?>)</label>
                    <div class="controls" style="margin-left: 150px;">
                      <textarea id="urls" name="urls" rows="1" class="input-small" style="width: 182px;" ></textarea>
                    </div>
                  </div>
                  <div class="clear"></div>
                  
                  <div class="control-group" style="float: left;">
                    <label class="control-label" for="admin_note"><?php echo _("Admin Note");?>:</label>
                    <div class="controls">
                    	<textarea id="admin_note" name="admin_note" rows="2" class="input-large"></textarea>
                    </div>
                  </div>
                  
                  <div class="control-group" style="float: left;">
                     <label class="control-label" for="group" style="width: 100px;"><?php echo _("Select Group")?>:</label>
                    <div class="controls" style="margin-left: 115px;">
                      <select id="group" name="group" style="width: 100px;">
                      		<?php foreach($groups as $group){?>
                    		<option value="<?php echo $group['group_id'];?>"><?php echo $group['name'];?></option>
                    		<?php }?>
                    	</select>
                    </div>
                  </div>
                  <div class="clear"></div>
                  
                  <div class="control-group">
                    <div class="controls">
                      <input type="hidden" name="act" value="add_article" />   
                      <button type="submit" class="btn" name="submit"><i class="icon-check"></i> <?php echo _("Add This Article");?></button>
                    </div>
                  </div>
                  
                </form>
                
              </td>
            </tr>
          </table>
        </div>
        
        <!-- ###################### Assigning Article Tooltip ########################### -->
        <div id="assign_article" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php echo _("Assigning Articles")?></h3>
            </div>
            <div class="modal-body">
	        	<form action="<?php echo base_url().'admin/assign_to'?>" method="post" class="form-horizontal">
	            	<div class="control-group">
		            	<label class="control-label" for="old_password"><?php echo _("Assign To");?>: </label>
	                    <div class="controls">
	                      <select name="writer" id="writer" >
	                      	<option value="0"><?php echo _("--Select--");?></option>
	                      	<?php foreach($writers as $writer){?>
	                      	<option value="<?php echo $writer['id'];?>"><?php echo $writer['name'];?></option>
	                      	<?php }?>
	                      </select>
	                    </div>
	                </div>
	                
		            <div class="modal-footer">
		            	<input type="hidden" name="assigning_article_id" value="" id="assigning_article_id" />
	                	<button type="submit" class="btn" name="submit" value="assigned" onSubmit="return validate_assigning();"><i class="icon-check"></i> <?php echo _("Assign");?></button>
	                </div>
		        </form
	        </div>
        </div>
        <!-- ############################################################################ -->
      </div>
      <script>
      	function validation(){
          	alert(document.getElementById('article_topic').value);
          	//if($("#article_topic").val() == ''){
              //	alert('<?php echo _("Please enter article topic");?>');
              	//$("#article_topic").focus();
              	//return false;
            //}else if($("#length").val() == ''){
            	//alert('<?php echo _("Please enter length for the article");?>');
              	//$("#length").focus();
              	//return false;
            //}else if(!isNan($("#length").val())){
            	//alert('<?php echo _("Please enter integer value for the length");?>');
              	//$("#length").focus();
              	//return false;
            //}else
               // return true;*-/
            return false;
        }
      	function validate_assigning(){
          	/*if($("#writer").val() == 0){
              	alert("Please select any writer.");
              	return false;
            }else{*/
                return true;
            //}
        }
        $(document).ready(function(){
        	$('.assigning_class').click(function(){
            	$('#assigning_article_id').val($(this).attr('rel'));
           	});
        });
      </script>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
</div>