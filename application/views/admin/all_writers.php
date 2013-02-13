<link href="<?php echo base_url();?>assets/writer_css/tipsy.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery.tipsy.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
       //$('.time_left').tipsy({gravity: 'e'}); // nw | n | ne | w | e | sw | s | se
       $('.btn').tooltip();
       $('.tooltips').tooltip({placement: 'right'});
       $('.update').click(function(){
           var input_id = $(this).attr('rel');
           var value = $("#ppw_"+input_id).val();
           var max_claimable = $("#max_c_"+input_id).val();
           var status = $("#status_"+input_id).val();
           window.location = '<?php echo base_url();?>admin/update_writer/'+input_id+'/'+value+'/'+max_claimable+'/'+status;
       });

       $('.delete').click(function(){
           var conf = confirm("Are you sure you want to delete this writer?");
	   	    if(conf == true){
	   	    	window.location = '<?php echo base_url();?>admin/delete_writers/'+$(this).attr('rel');
	   	    	//alert('<?php echo base_url();?>admin/delete_available/'+$(this).attr('rel'));
	   	    }
      });

       $('.tooltips').click(function(){
           var writer_id = $(this).attr('rel');
           $('#admin_note').val($('#am_'+writer_id).val());
           $('#writer_id').val(writer_id);
       });
   });
</script>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
        <?php if(!empty($active_writers)){?>
        <!-- ##################### ACTIVE WRITERS ################################### -->
          <div class="head_wrap">
            <h2><?php echo _("ACTIVE WRITERS");?></h2>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">#</th>
              <th width="20%"><?php echo _("Name");?></th>
              <th width="20%"><?php echo _("Email");?></th>
              <th width="15%"><?php echo _("Phone");?></th>
              <th width="10%"><?php echo _("Price/Word");?></th>
              <th width="9%"><?php echo _("Max. Claimable");?></th>
              <th width="10%"><?php echo _("Status");?></th>
              <th width="15%"><?php echo _("Action");?></th>
            </tr>
            <?php foreach($active_writers as $values){?>
            <tr>
              <td width="1%"><?php echo $values['id'];?></td>
              <td width="20%"><a href="#note" data-toggle="modal" rel="<?php echo $values['id'];?>" class="tooltips" title="<?php echo $values['admin_note'];?>"><?php echo $values['name'];?></a></td>
              <td width="20%"><?php echo $values['email'];?></td>
              <td width="15%"><?php echo $values['phone'];?></td>
              <td width="10%">
              	<input type="text" class="input-small" value="<?php echo $values['price_per_word'];?>" id="ppw_<?php echo $values['id'];?>" name="ppw_<?php echo $values['id'];?>"/>
              </td>
              <td width="9%">
              	<input type="text" class="input-small" value="<?php echo $values['max_claimable'];?>" id="max_c_<?php echo $values['id'];?>" name="max_c_<?php echo $values['id'];?>"/>
              </td>
              <td width="10%">
              	<select id="status_<?php echo $values['id'];?>" name="status" class="input-small">
              		<option value="0" <?php if($values['status'] == 0){?>selected="selected"<?php }?> ><?php echo _("Inactive");?></option>
              		<option value="1" <?php if($values['status'] == 1){?>selected="selected"<?php }?>><?php echo _("Active");?></option>
              	</select>
              </td>
              <td width="15%">
              	<input type="hidden" name="am_<?php echo $values['id'];?>" id="am_<?php echo $values['id'];?>" value="<?php echo $values['admin_note'];?>" />
                <a href="javascript: void(0);" rel="<?php echo $values['id'];?>" class="update" ><span class="btn" title="<?php echo _("Update User");?>"><?php echo _("Update");?></span></a>              	
                <a href="javascript: void(0);" rel="<?php echo $values['id'];?>" class="delete"><span class="btn" title="<?php echo _("Delete User");?>"><i class="icon-remove-circle"></i></span></a>
              </td>
            </tr>
            <?php }?>
          </table>
          <!-- <div><?php echo $this->pagination->create_links();?></div> -->
          <?php }?>
          
          <?php if(!empty($inactive_writers)){?>
         <!-- ##################### INACTIVE WRITERS ################################### -->
          <div class="head_wrap">
            <h2><?php echo _("INACTIVE WRITERS");?></h2>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">#</th>
              <th width="20%"><?php echo _("Name");?></th>
              <th width="20%"><?php echo _("Email");?></th>
              <th width="15%"><?php echo _("Phone");?></th>
              <th width="10%"><?php echo _("Price/Word");?></th>
              <th width="9%"><?php echo _("Max. Claimable");?></th>
              <th width="10%"><?php echo _("Status");?></th>
              <th width="15%"><?php echo _("Action");?></th>
            </tr>
            <?php foreach($inactive_writers as $values){?>
            <tr>
              <td width="1%"><?php echo $values['id'];?></td>
              <td width="20%"><a href="#note" data-toggle="modal" rel="<?php echo $values['id'];?>" class="tooltips" title="<?php echo $values['admin_note'];?>"><?php echo $values['name'];?></a></td>
              <td width="20%"><?php echo $values['email'];?></td>
              <td width="15%"><?php echo $values['phone'];?></td>
              <td width="10%">
              	<input type="text" class="input-small" value="<?php echo $values['price_per_word'];?>" id="ppw_<?php echo $values['id'];?>" name="ppw_<?php echo $values['id'];?>"/>
              </td>
              <td width="9%">
              	<input type="text" class="input-small" value="<?php echo $values['max_claimable'];?>" id="max_c_<?php echo $values['id'];?>" name="max_c_<?php echo $values['id'];?>"/>
              </td>
              <td width="10%">
              	<select id="status_<?php echo $values['id'];?>" name="status" class="input-small">
              		<option value="0" <?php if($values['status'] == 0){?>selected="selected"<?php }?> ><?php echo _("Inactive");?></option>
              		<option value="1" <?php if($values['status'] == 1){?>selected="selected"<?php }?>><?php echo _("Active");?></option>
              	</select>
              </td>
              <td width="15%">
              	<input type="hidden" name="am_<?php echo $values['id'];?>" id="am_<?php echo $values['id'];?>" value="<?php echo $values['admin_note'];?>" />
                <a href="javascript: void(0);" rel="<?php echo $values['id'];?>" class="update" ><span class="btn" title="<?php echo _("Update User");?>"><?php echo _("Update");?></span></a>              	
                <a href="javascript: void(0);" rel="<?php echo $values['id'];?>" class="delete"><span class="btn" title="<?php echo _("Delete User");?>"><i class="icon-remove-circle"></i></span></a>
              </td>
            </tr>
            <?php }?>
          </table>
          <!-- <div><?php echo $this->pagination->create_links();?></div> -->
          <?php }?>
        </div>
      </div>
      
      <!-- ###################### Admin note Tooltip ########################### -->
        <div id="note" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php echo _("Admin Note")?></h3>
            </div>
            <div class="modal-body">
	        	<form action="" method="post" class="form-horizontal">
	            	<div class="control-group">
	                    <div class="controls">
	                      <textarea id="admin_note" name="admin_note" rows="3" class="input-xlarge"></textarea>
	                    </div>
	                </div>
	                
		            <div class="modal-footer">
		            	<input type="hidden" name="writer_id" value="" id="writer_id" />
	                	<button type="submit" class="btn" name="submit" value="update" onSubmit=""><i class="icon-check"></i> <?php echo _("Update");?></button>
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