<style>
	.alert{
		font-size: 16px;
    	text-align: center;
	}
</style>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Profile");?></h2>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
              	<form action="" method="post" class="form-horizontal">
              	<?php if(@$error){?>
              	  <div class="alert alert-error">
                      <?php echo @$error;?>
                  </div>
                 <?php }?>
                 <?php if(@$success){?>
              	  <div class="alert alert-success">
                      <?php echo @$success;?>
                  </div>
                 <?php }?>  
                  <div class="control-group">
                    <label class="control-label" for="article_topic"><?php echo _("Name");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="text" value="<?php echo $writer_info['0']['name'];?>" id="name" name="name"/>
                    </div>
                  </div>
                                      	
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("User Name");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="text" value="<?php echo $writer_info['0']['username'];?>" id="username" name="username"/>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("Email");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="text" value="<?php echo $writer_info['0']['email'];?>" id="email" name="email" />
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <div class="controls">
                      <input type="hidden" name="act" value="edit_article" />
                      <input type="hidden" name="article_id" value="<?php echo $writer_info['0']['id'];?>" />   
                      <button type="submit" class="btn" name="submit" value="edit"><i class="icon-check"></i> <?php echo _("Save");?></button>
                      <a href="#change_pswd" data-toggle="modal"><button type="button" class="btn" name="edit_password" value="edit_password"><?php echo _("Change Password");?></button></a>
                    </div>
                  </div>
                  
                </form>
                
              </td>
            </tr>
          </table>
        </div>
        
        <div id="change_pswd" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php echo _("Change Password")?></h3>
            </div>
            <div class="modal-body">
	        	<form action="" method="post" class="form-horizontal">
	            	<div class="control-group">
		            	<label class="control-label" for="old_password"><?php echo _("Old-Password");?>: </label>
	                    <div class="controls">
	                      <input class="input-large" type="password" value="" id="old_password" name="old_password"/>
	                    </div>
	                </div>
	                
	                <div class="control-group">
	                    <label class="control-label" for="new_password"><?php echo _("New-Password");?>: </label>
	                    <div class="controls">
	                      <input class="input-large" type="password" value="" id="new_password" name="new_password"/>
	                    </div>
	                </div>
	                  
		            <div class="modal-footer">
	                      <input type="hidden" name="article_id" value="<?php echo $writer_info['0']['id'];?>" />   
	                      <button type="submit" class="btn" name="submit" value="Change"><i class="icon-check"></i> <?php echo _("Change");?></button>
	                </div>
		        </form
	        ></div>
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
</div>