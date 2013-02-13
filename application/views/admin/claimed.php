<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Claimed");?></h2>
            <div class="clear">&nbsp;</div>
          </div>
          <?php if(!empty($article_info)){?>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <th width="32%"><?php echo _("Main Topic");?></th>
              <th width="20%"><?php echo _("Claimed By");?></th>
              <th width="15%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($article_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
              <td width="32%"><a href="#"><?php echo $values['topic'];?></a></td>
              <td width="20%"><?php echo $values['name'];?></td>
              <!-- <td width="32%">
                <div class="progress progress-danger progress-striped active">
                  <div class="bar" style="width: 10%"></div>
                </div></td> -->
              <td width="15%">
                <span class="btn"><?php echo $values['due_time'];?></span>
                <span class="btn"><?php echo $values['length'];?></span>
              </td>
            </tr>
            <?php }?>
          </table>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Claimed Articles");?></div>
          <?php }?>
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
</div>