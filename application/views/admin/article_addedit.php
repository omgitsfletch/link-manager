<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <?php if(!empty($article_info)){?>
            <h2><?php echo _("Edit Article");?></h2>
            <?php }else{?>
            <h2><?php echo _("Add Article");?></h2>
            <?php }?>
            <!-- <div class="links"> <a href="#">Per Day</a> <a href="#">Per Words</a> -->
            <div class="links">
            	<a href="<?php echo base_url();?>admin/articles"><?php echo _('Back to Articles');?></a>
                <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
              	<form action="<?php echo base_url().'admin/add';?>" method="post" class="form-horizontal">
                  <div class="control-group">
                    <label class="control-label" for="article_topic"><?php echo _("Article topic");?>: </label>
                    <div class="controls">
                      <input class="input-xxlarge" type="text" value="<?php if(form_error('article_topic')){echo set_value('article_topic');}elseif(!empty($article_info)){ echo $article_info['0']['topic'];}?>" id="article_topic" name="article_topic" <?php if(form_error('article_topic')){echo 'class="error"';}?>/>
                      <?php echo form_error('article_topic');?>
                    </div>
                  </div>
                                      	
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("Length");?>: </label>
                    <div class="controls">
                      <input class="input-xxlarge" type="text" value="<?php if(form_error('length')){echo set_value('length');}elseif(!empty($article_info)){ echo $article_info['0']['length'];}?>" id="length" name="length" <?php if(form_error('length')){echo 'class="error"';}?>/>
                        <?php echo form_error('length');?>
                    </div>
                  </div>
                  
                  <div class="control-group">
                     <label class="control-label" for="due_date"><?php echo _("Due Date")?>:</label>
                    <div class="controls">
                      <select id="due_date" name="due_date">
                    		<option value="1" <?php if(!empty($article_info) && $article_info['0']['due_date'] == 1){?>selected="selected"<?php }?> >1</option>
                    		<option value="2" <?php if(!empty($article_info) && $article_info['0']['due_date'] == 2){?>selected="selected"<?php }?> >2</option>
                    		<option value="3" <?php if(!empty($article_info) && $article_info['0']['due_date'] == 3){?>selected="selected"<?php }?> >3</option>
                    		<option value="4" <?php if(!empty($article_info) && $article_info['0']['due_date'] == 4){?>selected="selected"<?php }?> >4</option>
                    		<option value="5" <?php if(!empty($article_info) && $article_info['0']['due_date'] == 5){?>selected="selected"<?php }?> >5</option>
                    		<option value="6" <?php if(!empty($article_info) && $article_info['0']['due_date'] == 6){?>selected="selected"<?php }?> >6</option>
                    		<option value="7" <?php if(!empty($article_info) && $article_info['0']['due_date'] == 7){?>selected="selected"<?php }?> >7</option>	                    		
                    	</select>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="description"><?php echo _("Description");?>:</label>
                    <div class="controls">
                      <textarea id="description" name="description" rows="3" class="input-xxlarge" <?php if(form_error('description')){echo 'class="error"';}?>><?php if(!empty($article_info)){echo $article_info['0']['description']; }?></textarea>
                      <?php echo form_error('description');?><br />
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="keywords"><?php echo _("Keywords");?>:<br />(<?php echo _("Comma separated");?>)</label>
                    <div class="controls">
                      <textarea id="keywords" name="keywords" rows="3" class="input-xxlarge" <?php if(form_error('keywords')){echo 'class="error"';}?>><?php if(!empty($article_info)){echo $article_info['0']['keywords']; }?></textarea>
                      <?php echo form_error('keywords');?><br />
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="urls"><?php echo _("Urls");?>:<br />(<?php echo _("Comma separated");?>)</label>
                    <div class="controls">
                      <textarea id="urls" name="urls" rows="3" class="input-xxlarge" <?php if(form_error('urls')){echo 'class="error"';}?>><?php if(!empty($article_info)){echo $article_info['0']['urls']; }?></textarea>
                      <p><?php echo form_error('urls');?></p>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="admin_note"><?php echo _("Admin Note");?>:</label>
                    <div class="controls">
                    	<textarea id="admin_note" name="admin_note" rows="3" class="input-xxlarge" <?php if(form_error('admin_note')){echo 'class="error"';}?>><?php if(!empty($article_info)){echo $article_info['0']['admin_notes']; }?></textarea>
                    </div>
                  </div>
                  
                  <div class="control-group">
                     <label class="control-label" for="group"><?php echo _("Group")?>:</label>
                    <div class="controls">
                      <select id="group" name="group">
                      		<?php foreach($groups as $group){?>
                    		<option value="<?php echo $group['group_id'];?>" <?php if(!empty($article_info) && $article_info['0']['group_id'] == $group['group_id']){?>selected="selected"<?php }?> ><?php echo $group['name'];?></option>
                    		<?php }?>
                    	</select>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <div class="controls">
                      <?php if(!empty($article_info)){?>
                      <input type="hidden" name="act" value="edit_article" />
                      <input type="hidden" name="article_id" value="<?php echo $article_info['0']['article_id'];?>" />   
                      <button type="submit" class="btn" name="submit"><i class="icon-check"></i> <?php echo _("Edit");?></button>
                      <?php }else{?>
                      <input type="hidden" name="act" value="add_article" />   
                      <button type="submit" class="btn" name="submit"><i class="icon-check"></i> <?php echo _("Add This Article");?></button>
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