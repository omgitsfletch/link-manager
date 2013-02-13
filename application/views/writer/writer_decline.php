<?php include("header.php");?>
<script>
	$(document).ready(function(){
		$('.pop').popover();
	});
</script>
<style>
	.progress{
		width: 200px;
	}
	
</style>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Declined");?></h2>
            <div class="clear">&nbsp;</div>
          </div>
          <?php if(!empty($article_info)){?>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <th width="20%"><?php echo _("Main Topic");?></th>
              <th width="20%"><?php echo _("Admin Note");?></th>
              <th width="15%"><?php echo _("Declined On");?></th>
              <th width="25%"><?php echo _('Time Left');?></th>
              <th width="15%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($article_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
              <td width="20%">
              	<a href="javascript: void(0);" title="<?php echo $values['topic'];?>" rel="popover" class="pop">
              		<?php 
              			if(strlen($values['topic']) >= 40){
	              			echo substr($values['topic'],0,40).'...';
	              		}else{
	              			echo $values['topic'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="20%">
              	<a href="javascript: void(0);" title="<?php echo $values['decline_note'];?>" rel="popover" class="pop">
              		<?php 
              			if(strlen($values['decline_note']) >= 40){
	              			echo substr($values['decline_note'],0,40).'...';
	              		}else{
	              			echo $values['decline_note'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="15%"><?php $decline_time = strtotime($values['declined_date']); echo date("m-d-Y H:i:s",$decline_time);?></td>
              <td width="25%">
                <?php 
                	  $due_time = date('Y-m-d H:i:s', strtotime($values['declined_date']. ' + '.$values['due_date'].' days'));
    				  // convert to unix timestamps
        			  $current_Time=strtotime(date('Y-m-d H:i:s'));
        			  $lastTime=strtotime($due_time);
        							
        			  $total_time = $lastTime - strtotime($values['declined_date']);   	
        			  $time_left = $lastTime - $current_Time;				
        		?>
                <div class="progress progress-danger progress-striped active" style="float: right;">
                  <div class="bar" style="margin-left: <?php echo (100-(($time_left/$total_time)*100));?>%; width:100%"></div>
                </div>
                <div style="padding-right: 4px;float: left;">
                <?php
                	if((int)($time_left/(60*60*24)) > 0)
                		echo '<span style="color:red">'.(int)($time_left/(60*60*24)).' days left</span>';
	                elseif((int)($time_left/(60*60)) > 0)
	                	echo '<span style="color:red">'.(int)($time_left/(60*60)).' hours left</span>';
	                elseif((int)($time_left/60) > 0)
	                	echo '<span style="color:red">'.(int)($time_left/60).' minutes left</span>';
	                else
                		echo '<span style="color:red">'.(int)($time_left).' seconds left</span>';
                ?>
                <div class="clear" ></div>
              </td>
              <td width="15%">
                <span class="btn"><?php echo $values['due_date'];?></span>
                <span class="btn"><?php echo $values['length'];?></span>
                <a href="<?php echo base_url();?>writer/declined/<?php echo $values['article_id'];?>"><button type="button" class="btn" name="submit" value="view"><i class="icon-check"></i> <?php echo _("View");?></button></a>
              </td>
            </tr>
            <?php }?>
          </table>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Declined Articles");?></div>
          <?php }?>    
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
<?php include('footer.php');?>