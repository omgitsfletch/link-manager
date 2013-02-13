<script src="<?php echo base_url();?>assets/scripts/thickbox.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/writer_css/thickbox.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/scripts/bootstrap-datepicker.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/writer_css/datepicker.css" rel="stylesheet">
<script type="text/javascript">
   $(document).ready(function(){
       $('.btn').tooltip();
       $('#dp').datepicker();
       $('#dp').datepicker();
       $('.pop').popover();
   });
</script>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Approved");?></h2>
            <div class="links"> <a href="#filter" data-toggle="modal"><?php echo _("Filter");?>:</a><p class="text-info" style="float: left; margin-left:10px;"><?php echo $filter_by;?></p>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <?php if(!empty($article_info)){?>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>              
              <th width="20%"><?php echo _("Article Topic");?></th>
              <th width="20%"><?php echo _("Article Title");?></th>
              <th width="19%"><?php echo _("Submitted By");?></th>
              <th width="10%"><?php echo _("Date");?></th>
              <th width="30%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($article_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>              
              <td width="20%">
              	<a href="javascript: void(0);" title="<?php echo $values['topic'];?>" rel="popover" class="pop">
              		<?php 
              			if(strlen($values['topic']) >= 40){
	              			echo substr($values['topic'],0,40).'...';
	              		}else{
	              			echo $values['topic'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="20%">
              	<a href="javascript: void(0);" title="<?php echo $values['title'];?>" rel="popover" class="pop">
              		<?php 
              			if(strlen($values['title']) >= 40){
	              			echo substr($values['title'],0,40).'...';
	              		}else{
	              			echo $values['title'];
	              		}
		            ?>
		         </a>
              </td>
              <td width="19%"><?php echo $values['name']?></td>
              <td width="10%"><?php $timestamp = strtotime($values['approval_date']); echo date('D', $timestamp);?>, <?php echo date('m-d-Y',$timestamp)?></td>
              <td width="30%">
                 <span class="btn"><?php echo $values['due_date'];?></span>
                 <span class="btn"><?php echo $values['length'];?></span>
                 <a href="<?php echo base_url();?>admin/approved/<?php echo $values['writer_id'];?>/<?php echo $values['article_id'];?>"><span class="btn" title="<?php echo _("Edit");?>"><i class="icon-edit"></i></span></a>
                 <a href="#TB_inline?height=300&width=550&inlineId=content_<?php echo $values['article_id'];?>" class="thickbox"><span class="btn"><?php echo _("view");?></span></a>
                 <div id="content_<?php echo $values['article_id'];?>" style="display: none;">
		         	<div style="text-align: center"><u><?php echo $values['title'];?></u></div>
		         	<div><?php echo $values['content'];?></div>
		        </div>
                 <a href="<?php echo base_url();?>admin/export_approved/<?php echo $values['article_id'];?>"><span class="btn" title="<?php echo _("Export this article on a word file");?>"><?php echo _("Export");?></span></a>
              </td> 
            </tr>
            <?php }?>
          </table>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Approved Articles");?></div>
          <?php }?>
        </div>
      </div>
      
       <!-- ###################### Filter Tooltip ########################### -->
        <div id="filter" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php echo _("Filter By")?></h3>
            </div>
            <div class="modal-body">
	        	<form action="" method="post" class="form-horizontal">
	        		<!-- ################ FILTER BY GROUPS ########################## -->
	            	<div class="control-group">
	            		<label class="radio">
							<input type="radio" name="filter_options" id="by_groups" value="Group"><?php echo _("Filte By Groups");?>
						</label>
	                    <div class="controls">
	                      <select name="group" id="group" >
	                      	<option value="0"><?php echo _("--Select--");?></option>
	                      	<?php foreach($groups as $group){?>
                    		<option value="<?php echo $group['group_id'];?>" ><?php echo $group['name'];?></option>
                    		<?php }?>
	                      </select>
	                    </div>
	                </div>
	                <!-- ################ FILTER BY AUTHOR ########################## -->
	                <div class="control-group">
	            		<label class="radio">
							<input type="radio" name="filter_options" id="by_author" value="Writer"><?php echo _("Filte By Writer");?>
						</label>
	                    <div class="controls">
	                      <select name="writer" id="writer" >
	                      	<option value="0"><?php echo _("--Select--");?></option>
	                      	<?php foreach($writers as $writer){?>
                    		<option value="<?php echo $writer['id'];?>" ><?php echo $writer['name'];?></option>
                    		<?php }?>
	                      </select>
	                    </div>
	                </div>
	                <!-- ################ FILTER BY DATE ########################## -->
	                <div class="control-group">
	            		<label class="radio">
							<input type="radio" name="filter_options" id="by_date" value="Date"><?php echo _("Filte By Date");?>
						</label>
	                    <div class="controls">
	                      <div class="input-append date" id="dp" data-date="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd">
							<input class="input-large" type="text" name="date" value="<?php echo date("Y-m-d");?>" readonly>
							<span class="add-on"><i class="icon-calendar"></i></span>
						  </div>
	                    </div>
	                </div>
	                
	                <!-- ################ FILTER BY ALL ########################## -->
	                <div class="control-group">
	            		<label class="radio">
							<input type="radio" name="filter_options" id="by_all" value="All" checked><?php echo _("All");?>
						</label>
	                </div>
	                
		            <div class="modal-footer">
		            	<input type="hidden" name="assigning_article_id" value="" id="assigning_article_id" />
	                	<button type="submit" class="btn" name="submit" value="assigned" onSubmit="return validate_assigning();"><i class="icon-check"></i> <?php echo _("Done");?></button>
	                </div>
		        </form
	        </div>
        </div>
        <!-- ############################################################################ -->
        
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
</div>