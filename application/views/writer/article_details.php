<?php include("header.php");?>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo $article_info['0']['topic'];?></h2>
            <div class="links">
            	<a href="<?php echo base_url();?>writer/available"><?php echo _('Back to Available');?></a>
                <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
              	<form action="<?php echo base_url().'writer/claim_article';?>" method="post" class="form-horizontal">
                  <div class="control-group">
                    <label class="control-label" for="article_topic"><?php echo _("Article topic");?>: </label>
                    <div class="controls">
                      <input class="input-xxlarge" type="text" value="<?php echo $article_info['0']['topic'];?>" id="article_topic" name="article_topic" />
                    </div>
                  </div>
                                      	
                  <div class="control-group">
                    <label class="control-label" for="length"><?php echo _("Length");?>: </label>
                    <div class="controls">
                      <input class="input-xxlarge" type="text" value="<?php echo $article_info['0']['length'];?>" id="length" name="length" />
                    </div>
                  </div>
                  
                  <div class="control-group">
                     <label class="control-label" for="due_date"><?php echo _("Due Date")?>:</label>
                    <div class="controls">
                      <input class="input-xxlarge" type="text" value="<?php echo $article_info['0']['due_date'];?>" id="due_dates" name="due_dates" />
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="description"><?php echo _("Description");?>:</label>
                    <div class="controls">
                      <textarea id="description" name="description" rows="3" class="input-xxlarge" > <?php echo $article_info['0']['description'];?></textarea>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="keywords"><?php echo _("Keywords");?>:</label>
                    <div class="controls">
                      <textarea id="keywords" name="keywords" rows="3" class="input-xxlarge" ><?php echo $article_info['0']['keywords'];?></textarea>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="urls"><?php echo _("Urls");?>:</label>
                    <div class="controls">
                      <textarea id="urls" name="urls" rows="3" class="input-xxlarge" ><?php echo $article_info['0']['urls'];?></textarea>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="writer_note"><?php echo _("writer Note");?>:</label>
                    <div class="controls">
                    	<textarea id="writer_note" name="writer_note" rows="3" class="input-xxlarge"><?php echo $article_info['0']['admin_notes'];?></textarea>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <div class="controls">
                      <input type="hidden" name="act" value="edit_article" />
                      <input type="hidden" name="article_id" value="<?php echo $article_info['0']['article_id'];?>" />
                      <input type="hidden" name="due_date" value="<?php echo $article_info['0']['due_date'];?>" />   
                      <button type="submit" class="btn" name="claim_button" value="claim"><i class="icon-check"></i> <?php echo _("Claim It");?></button>
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
<?php include('footer.php');?>