<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <?php if(!empty($writer_info)){?>
            <h2><?php echo _("Edit Writer");?></h2>
            <?php }else{?>
            <h2><?php echo _("Add Writer");?></h2>
            <?php }?>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
              	<form action="" method="post" class="form-horizontal">
                  <div class="control-group">
                    <label class="control-label" for="article_topic"><?php echo _("Name");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="text" value="<?php if(form_error('name')){echo set_value('name');}elseif(!empty($writer_info)){ echo $writer_info['0']['name'];}?>" id="name" name="name" <?php if(form_error('name')){echo 'class="error"';}?>/>
                      <?php echo form_error('name');?>
                    </div>
                  </div>
                                      	
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("User Name");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="text" value="<?php if(form_error('username')){echo set_value('username');}elseif(!empty($writer_info)){ echo $writer_info['0']['username'];}?>" id="username" name="username" <?php if(form_error('username')){echo 'class="error"';}?>/>
                        <?php echo form_error('username');?>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("Password");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="password" value="<?php if(!empty($writer_info)){ echo $writer_info['0']['password'];}?>" id="password" name="password" <?php if(form_error('password')){echo 'class="error"';}?>/>
                        <?php echo form_error('password');?>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("Retype Password");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="password" value="" id="repassword" name="repassword" <?php if(form_error('repassword')){echo 'class="error"';}?>/>
                        <?php echo form_error('repassword');?>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("Email");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="text" value="<?php if(form_error('email')){echo set_value('email');}elseif(!empty($writer_info)){ echo $writer_info['0']['email'];}?>" id="email" name="email" <?php if(form_error('email')){echo 'class="error"';}?>/>
                        <?php echo form_error('email');?>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("Phone");?>: </label>
                    <div class="controls">
                      <input class="input-large" type="text" value="<?php if(form_error('phone')){echo set_value('phone');}elseif(!empty($writer_info)){ echo $writer_info['0']['phone'];}?>" id="phone" name="phone" <?php if(form_error('phone')){echo 'class="error"';}?>/>
                        <?php echo form_error('phone');?>
                    </div>
                  </div>
                  
                  <div class="control-group">
                     <label class="control-label" for="due_date"><?php echo _("Sex")?>:</label>
                    <div class="controls">
                      <select id="sex" name="sex">
                    		<option value="male" <?php if(!empty($writer_info) && $writer_info['0']['sex'] == 'male'){?>selected="selected"<?php }?> ><?php echo _("Male");?></option>
                    		<option value="female" <?php if(!empty($writer_info) && $writer_info['0']['sex'] == 'female'){?>selected="selected"<?php }?> ><?php echo _("Female");?></option>
                    	</select>
                    </div>
                  </div>
                  
                  <div class="control-group">
                     <label class="control-label" for="due_date"><?php echo _("Role")?>:</label>
                    <div class="controls">
                      <select id="role" name="role">
                    		<option value="writer" <?php if(!empty($writer_info) && $writer_info['0']['role'] == 'writer'){?>selected="selected"<?php }?> ><?php echo _("Writer");?></option>
                    		<option value="editor" <?php if(!empty($writer_info) && $writer_info['0']['role'] == 'editor'){?>selected="selected"<?php }?> ><?php echo _("Editor");?></option>
                    	</select>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <div class="controls">
                      <?php if(!empty($writer_info)){?>
                      <input type="hidden" name="act" value="edit_article" />
                      <input type="hidden" name="article_id" value="<?php echo $writer_info['0']['id'];?>" />   
                      <button type="submit" class="btn" name="submit" value="edit"><i class="icon-check"></i> <?php echo _("Edit");?></button>
                      <?php }else{?>
                      <button type="submit" class="btn" name="submit" value="add"><i class="icon-check"></i> <?php echo _("Add");?></button>
                      <?php }?>
                    </div>
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