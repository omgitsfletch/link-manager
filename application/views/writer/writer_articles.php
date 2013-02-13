<?php include("header.php");?>
<script src="<?php echo base_url();?>assets/scripts/thickbox.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/writer_css/thickbox.css" rel="stylesheet">
<script>
	$(document).ready(function(){
		$('.tool').tooltip();
		$('.pop').popover();
		$('.pop-up').popover({placement: 'top'});

		/*$(".thickboxed").click(function(){
			//alert("shyam");
			tb_show("Submit", "<?php echo base_url();?>writer/submit/"+$('#article_id').val()+"height=400&width=600", "true");
		});*/
	});
</script>
<style>
	.progress{
		width: 200px;
	}
	
	form{
		margin: 5px 0px 0px 0px;
	}
</style>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
        <?php if(!empty($assigned_article_info)){?>
        <!-- ##################### ASSIGNED ARTICLES ################################### -->
         <div class="head_wrap">
            <h2><?php echo _("Assigned");?>&nbsp;(<?php echo count($assigned_article_info);?>)</h2>
            <div class="links"> <a href="#"></a> <a href="#"></a>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>              
              <th width="30%"><?php echo _("Main Topic");?></th>
              <th width="20%"><?php echo _("Description");?></th>
              <th width="10%"><?php echo _("Assigned At");?></th>
              <th width="20%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
              <th width="20%"><?php echo _("Action");?></th>
            </tr>
            <?php foreach($assigned_article_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>              
              <td width="30%">
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
              	<a title="<?php echo $values['description'];?>" rel="popover" class="pop-up" href="javascript: void(0);">
              		<?php 
              			if(strlen($values['description']) >= 40){
	              			echo substr($values['description'],0,40).'...';
	              		}else{
	              			echo $values['description'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="10%"><?php $timestamp = strtotime($values['assigned_time']); echo date('D', $timestamp);?>, <?php echo date('d-m-Y',$timestamp)?></td>
              <td width="20%">
                 <span class="btn"><?php echo $values['due_date'];?></span>
                 <span class="btn"><?php echo $values['length'];?></span>
              </td> 
              <td width="19%">
              	<a href="<?php echo base_url();?>writer/claim_assigned/<?php echo $values['article_id'];?>"><span class="btn"><i class="icon-check"></i><?php echo _("Claim");?></span></a>
                <a class="delete" rel="<?php echo $values['article_id'];?>" href="javascript: void(0);"><span class="btn"><i class="icon-remove-circle"></i><?php echo _("Reject");?></span></a>
              </td>
            </tr>
            <?php }?>
          </table>
          <?php }?>
          
        <!-- ##################### CLAIMED ARTICLES ################################### -->
          <div class="head_wrap">
            <h2><?php echo _("Claimed");?>&nbsp;(<?php echo count($claimed_article_info);?>)</h2>
            <div class="clear">&nbsp;</div>
          </div>
          <?php if(!empty($claimed_article_info)){?>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <th width="19%"><?php echo _("Main Topic");?></th>
              <th width="20%"><?php echo _("Description");?></th>
              <th width="12%"><?php echo _("Claimed On");?></th>
              <th width="25%"><?php echo _('Time Left');?></th>
              <th width="23%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($claimed_article_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
              <td width="19%">
              	<a href="javascript: void(0);" title="<?php echo $values['topic'];?>" rel="popover" class="pop">
              		<?php 
              			if(strlen($values['topic']) >= 20){
	              			echo substr($values['topic'],0,20).'...';
	              		}else{
	              			echo $values['topic'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="20%">
              	<a title="<?php echo $values['description'];?>" rel="popover" class="pop" href="javascript: void(0);">
              		<?php 
              			if(strlen($values['description']) >= 20){
	              			echo substr($values['description'],0,20).'...';
	              		}else{
	              			echo $values['description'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="12%"><?php $claimed_time = strtotime($values['claimed_time']); echo date("m-d-Y H:i:s",$claimed_time);?></td>
              <td width="25%">
                <?php $due_time = date('Y-m-d H:i:s', strtotime($values['claimed_time']. ' + '.$values['due_time'].' days'));
    				  // convert to unix timestamps
        			  $current_Time=strtotime(date('Y-m-d H:i:s'));
        			  $lastTime=strtotime($due_time);
        							
        			  $total_time = $lastTime - $claimed_time;   	
        			  $time_left = $lastTime - $current_Time;				
        		?>
                <div class="progress progress-danger progress-striped active" style="float: right;">
                  <div class="bar" style="margin-left: <?php echo (int)(100-(($time_left/$total_time)*100));?>%; width:100%"></div>
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
                	<?php //echo _("Due Date is:");?> <span style="color:red;"><?php //echo date("m-d-Y",$lastTime);?></span><br />
                	<?php //echo _("Due time is:");?> <span style="color:red;"><?php //echo date("H:i:s",$lastTime);?></span>
                </div>
                <div class="clear" ></div>
              </td>
              <td width="23%">
                <span class="btn"><?php echo $values['due_time'];?></span>
                <span class="btn"><?php echo $values['length'];?></span>
                <input type="hidden" value="<?php echo $values['article_id'];?>" id="article_id" name="article_id" />
                <a href="<?php echo base_url();?>writer/submit/<?php echo $values['article_id'];?>"><button type="button" class="btn" name="submit" value="done"><?php echo _("SUBMIT");?></button></a>
                <a href="<?php echo base_url();?>writer/unclaim/<?php echo $values['article_id'];?>"><span class="btn"><?php echo _("Unclaim");?></span></a>
              </td>
            </tr>
            <?php }?>
          </table>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Claimed Articles");?></div>
          <?php }?>
          
          <!-- ##################### AVAILABLE ARTICLES ################################### -->
          
          <div class="head_wrap">
            <h2><?php echo _("Available");?>&nbsp;(<?php echo count($available_article_info);?>)</h2>
            <div class="clear">&nbsp;</div>
          </div>
          <?php if(!empty($available_article_info)){?>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <!-- <th width="10%">#</th> -->
              <th width="34%"><?php echo _("Main Topic");?></th>
              <th width="35%"><?php echo _("Description");?></th>
              <th width="20%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($available_article_info as $values){?>
            <tr>
              <td width="1%"><i class="icon-plus-sign"></i></td>
              <!-- <td width="10%"><?php echo $values['article_id'];?></td> -->
              <td width="34%">
              	<a href="javascript: void(0);" title="<?php echo $values['topic'];?>" rel="popover" class="pop-up">
              		<?php 
              			if(strlen($values['topic']) >= 40){
	              			echo substr($values['topic'],0,40).'...';
	              		}else{
	              			echo $values['topic'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="35%">
              	<a title="<?php echo $values['description'];?>" rel="popover" class="pop-up" href="javascript: void(0);">
              		<?php 
              			if(strlen($values['description']) >= 40){
	              			echo substr($values['description'],0,40).'...';
	              		}else{
	              			echo $values['description'];
	              		}
		            ?>
              	</a>
              </td>
              <td width="20%">
                 <span class="btn"><?php echo $values['due_date'];?></span>
                 <span class="btn"><?php echo $values['length'];?></span>
                 <a <?php if(!$can_claim){?> href="javascript: void(0);" class="pop-up" rel="popover" title="<?php echo _("Submit claimed article to claim another");?>"<?php }else{?>href="<?php echo base_url();?>writer/claim_article/<?php echo $values['article_id'];?>"<?php }?> ><button type="submit" class="btn" id="claim_button" name="claim_button" value="claim" <?php if(!$can_claim){?>disabled<?php }?> ><i class="icon-check"></i> <?php echo _("Claim");?></button></a>
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
<?php include('footer.php');?>