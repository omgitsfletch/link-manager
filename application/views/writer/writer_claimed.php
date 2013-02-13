<?php include("header.php");?>
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
              <th width="20%"><?php echo _("Main Topic");?></th>
              <th width="20%"><?php echo _("Description");?></th>
              <th width="20%"><?php echo _("Claimed On");?></th>
              <th width="20%"><?php echo _('Time Left');?></th>
              <th width="15%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($article_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
              <td width="20%"><a href="#"><?php echo $values['topic'];?></a></td>
              <td width="20%"><?php echo $values['description'];?></td>
              <td width="20%"><?php echo $values['claimed_time'];?></td>
              <td width="20%">
                <?php $date2 = date('Y-m-d h:i:s', strtotime($values['claimed_time']. ' + '.$values['due_time'].' days'));
        							//echo $date2;
        							// convert to unix timestamps
        							$firstTime=strtotime(date('Y-m-d h:i:s'));
        							$lastTime=strtotime($date2);
        							
        							$total_time = $lastTime - strtotime($values['claimed_time']);   						
        							// perform subtraction to get the difference (in seconds) between times
        							$timeDiff=$lastTime-$firstTime;
        		?>
                <div class="progress progress-danger progress-striped active">
                  <div class="bar" style="margin-left: <?php echo (100-(($timeDiff/$total_time)*100));?>%; width:100%"></div>
                </div>
              </td>
              <td width="15%">
                <span class="btn"><?php echo $values['due_time'];?></span>
                <span class="btn"><?php echo $values['length'];?></span>
                <form action="<?php echo base_url();?>writer/submit" method="POST">
                <input type="hidden" value="<?php echo $values['article_id'];?>" id="article_id" name="article_id" />
                <button type="submit" class="btn" name="submit" value="done"><i class="icon-check"></i> <?php echo _("SUBMIT");?></button>
                </form>
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
<?php include('footer.php');?>