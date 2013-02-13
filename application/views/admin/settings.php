<script src="<?php echo base_url();?>assets/scripts/thickbox.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/writer_css/thickbox.css" rel="stylesheet">
<script>
	$(document).ready(function(){
		$('.edit_grp').click(function(){
			var id = $(this).attr('rel');
			//alert('#tr'+tr_id+' > td:nth-child(2)');
			var grp_name = $('#tr_'+id+' > td:nth-child(3)').text();
			$('#grp_name').val(grp_name);
			$('#group_id').val(id); 
		});
	});
</script>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Copyscape API");?></h2>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
              	<form action="" method="post" class="form-horizontal">
              	
              	  <div class="control-group">
                    <label class="control-label" for="length"></label>
                    <div class="controls">
                    	<blockquote>
                      <p>
						 We have integrated <a href="http://www.copyscape.com/premium.php" target="_blank">Copyscape</a> so you can check for duplicate content of submitted articles with a click of a button. Just input your Copyscape Premium Username and API Key below to use this feature.  If you are new to Copyscape you can get your Premium API and find <a href="http://www.copyscape.com/apiconfigure.php" target="_blank">further information here</a>.
					  </p>
					  </blockquote>
                    </div>
                  </div>
            	
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("User Name");?>: </label>
                    <div class="controls">
                      <input class="input-xlarge" type="text" value="<?php if(!empty($copyscape_settings)){ echo $copyscape_settings['0']['copyscape_username'];}?>" id="copyscape_username" name="copyscape_username" />
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("API Key");?>: </label>
                    <div class="controls">
                      <input class="input-xlarge" type="text" value="<?php if(!empty($copyscape_settings)){ echo $copyscape_settings['0']['copyscape_api_key'];}?>" id="copyscape_api_key" name="copyscape_api_key" />
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("Amount of Credits Remaining");?>: </label>
                    <div class="controls">
                      <p class="lead">
						  <?php echo $account_balance['total'];?>
					  </p>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <div class="controls">
                      <button type="submit" class="btn" name="submit" value="edit_copyscape"><i class="icon-check"></i> <?php echo _("Update");?></button>
                    </div>
                  </div>
                  
                </form>
                
              </td>
            </tr>
          </table>
        </div>
        
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Groups");?></h2>
            <div class="links">
            	<a href="#TB_inline?height=260&width=450&inlineId=add_group" class="thickbox" ><?php echo _("Add Group");?></a>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <?php if(!empty($available_groups)){?>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <th width="10%">#</th>
              <th width="34%"><?php echo _("Name");?></th>
              <th width="15%"><?php echo _("Articles in this group");?></th>
              <th width="15%"><?php echo _("Added at");?></th>
              <th width="25%"><?php echo _("Action");?></th>
            </tr>
            <?php foreach($available_groups as $values){?>
            <tr id="tr_<?php echo $values['group_id'];?>">
              <td width="1%"><a href="javascript: void(0);"><i class="icon-plus-sign"></a></i></td>
              <td width="10%"><?php echo $values['group_id'];?></td>
              <td width="34%"><?php echo $values['name'];?></td>
              <td width="15%"><?php echo $values['article_assigned'];?></td>
              <td width="15%"><?php $timestamp = strtotime($values['date_added']); echo date('D', $timestamp);?>, <?php echo date('m-d-Y',$timestamp)?></td>
              <td width="25%">
              	 <a href="#edit_group" data-toggle="modal" rel="<?php echo $values['group_id'];?>" class="edit_grp"><button type="button" class="btn" name="edit" value="edit"><?php echo _("Edit");?></button></a>
                 <a class="delete" rel="<?php echo $values['group_id'];?>" href="javascript: void(0);"><span class="btn"><i class="icon-remove-circle"></i></span></a>
              </td> 
            </tr>
            <?php }?>
          </table>
          <div><?php echo $this->pagination->create_links();?></div>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Groups Available");?></div>
          <?php }?>
        </div>
        
        <div id="edit_group" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabels"><?php echo _("Edit Group")?></h3>
            </div>
            <div class="modal-body">
	        	<form action="" method="post" class="form-horizontal">
	            	<div class="control-group">
		            	<label class="control-label" for="grp_name"><?php echo _("Name");?>: </label>
	                    <div class="controls">
	                      <input class="input-large" type="text" value="" id="grp_name" name="grp_name"/>
	                    </div>
	                </div>
	                
		            <div class="modal-footer">
	                      <input type="hidden" name="group_id" value="" id="group_id"/>   
	                      <button type="submit" class="btn" name="submit" value="edit_grp"><i class="icon-check"></i> <?php echo _("Change");?></button>
	                </div>
		        </form
	        ></div>
        </div>
        
        <div id="add_group" class="table_wrap" style="display: none;">
        	<div class="head_wrap">
                <h3><?php echo _("Add Group")?></h3>
                <div class="clear">&nbsp;</div>
            </div>
            <table class="table table-bordered table-striped">
            <tr>
              <td>
	        	<form action="" method="post" class="form-horizontal">
	            	<div class="control-group">
		            	<label class="control-label" for="group_name" style="width: 140px;"><?php echo _("Name");?>: </label>
	                    <div class="controls" style="margin-left: 160px;">
	                      <input class="input-large" type="text" value="" id="group_name" name="group_name"/>
	                    </div>
	                </div>
	                
		            <div class="modal-footer">
	                      <button type="submit" class="btn" name="submit" value="add_grp"><i class="icon-check"></i> <?php echo _("Add");?></button>
	                </div>
		        </form>
			 </td>
            </tr>
          </table>
        </div>
        
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
</div>