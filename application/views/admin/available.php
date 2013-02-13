<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Available");?></h2>
            <div class="links"> <a href="<?php echo base_url();?>admin/add"><?php echo _("Add Article");?></a>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <?php if(!empty($article_info)){?>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <th width="10%">#</th>
              <th width="34%"><?php echo _("Main Topic");?></th>
              <th width="35%"><?php echo _("Description");?></th>
              <th width="20%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($article_info as $values){?>
            <tr>
              <td width="1%"><a href="<?php echo base_url();?>admin/add"><i class="icon-plus-sign"></a></i></td>
              <td width="10%"><?php echo $values['article_id'];?></td>
              <td width="34%"><a href="<?php echo base_url();?>admin/available/<?php echo $values['article_id'];?>"><?php echo $values['topic'];?></a></td>
              <td width="35%"><?php echo $values['description'];?></td>
              <td width="20%">
                 <span class="btn"><?php echo $values['due_date'];?></span>
                 <span class="btn"><?php echo $values['length'];?></span>
                 <span><a href="<?php echo base_url();?>admin/available/<?php echo $values['article_id'];?>"><i class="icon-edit"></i></a></span>
                 <span><a href="<?php echo base_url();?>admin/delete_available/<?php echo $values['article_id'];?>"><i class="icon-remove-circle"></i></a></span>
              </td> 
            </tr>
            <?php }?>
          </table>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Available Articles");?></div>
          <?php }?>
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
</div>