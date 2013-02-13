<?php include("header.php");?>
<script src="<?php echo base_url();?>assets/scripts/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		new nicEditor({iconsPath : '<?php echo base_url();?>assets/images/nicEditorIcons.gif'}).panelInstance('content');
		//new nicEditor({iconsPath : '<?php echo base_url();?>assets/images/nicEditorIcons.gif'}).panelInstance('decline_note');
	});
</script>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo $article_info['0']['topic'];?></h2>
            <div class="links"> <a href="<?php echo base_url();?>editor/approved"><?php echo _("Back to Approved");?></a>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
              
                <form class="form-horizontal" action="<?php echo base_url();?>editor/publish_article" method="POST">
                	<input type="hidden" id="article_id" value="<?php echo $article_info['0']['article_id'];?>" name="article_id" />
                	<input type="hidden" id="writer_id" value="<?php echo $article_info['0']['writer_id'];?>" name="writer_id" />
                  <div class="control-group">
                    <label class="control-label" for="inputEmail"><?php echo _("Topic Title");?></label>
                    <div class="controls">
                      <input class="input-xxlarge" type="text" id="title" name="title" placeholder="" value="<?php echo $article_info['0']['title'];?>">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="inputPassword"><?php echo _("Topic Content");?></label>
                    <div class="controls">
                      <textarea rows="5" class="input-xxlarge" id="content" name="content"><?php echo $article_info['0']['content'];?></textarea>
                    </div>
                  </div>
                  <div class="control-group">
                    <div class="controls">                     
                      <button type="submit" class="btn btn-info" id="publish" name="publish" value="publish"><i class="icon-time"></i> <?php echo _("Publish");?></button>
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