<?php include("header.php");?>
<script>
	$(document).ready(function(){
		$('.delete').click(function(){
			var result = confirm("Do you really want to Reject this article ?");
			if(result){
				var article_id = $(this).attr('rel');
				window.location = '<?php echo base_url()?>writer/reject_assigned/'+article_id;
			}
		});
		$('.pop').popover();
	});
</script>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Assigned");?>&nbsp;(<?php echo count($article_info);?>)</h2>
            <div class="links"> <a href="#"></a> <a href="#"></a>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <?php if(!empty($article_info)){?>          
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>              
              <th width="30%"><?php echo _("Article Topic");?></th>
              <th width="20%"><?php echo _("Article Description");?></th>
              <th width="10%"><?php echo _("Assigned At");?></th>
              <th width="20%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
              <th width="20%"><?php echo _("Action");?></th>
            </tr>
            <?php foreach($article_info as $values){?>
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
          <?php }else{?>
          <div class="no_info"><?php echo _("No Assigned Articles");?></div>
          <?php }?>          
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
<?php include('footer.php');?>