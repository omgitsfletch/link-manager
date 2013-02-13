<script src="<?php echo base_url();?>assets/scripts/thickbox.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/css/thickbox.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/scripts/bootstrap-datepicker.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/css/datepicker.css" rel="stylesheet">
<script type="text/javascript">
   $(document).ready(function(){
       $('.btn').tooltip();
       $('#dp').datepicker();
       $('#dp').datepicker();
       $('.pop').popover();
   });
</script>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Approved");?></h2>
            <!-- <div class="links"> <a href="#filter" data-toggle="modal"><?php echo _("Filter");?>:</a><p class="text-info" style="float: left; margin-left:10px;"><?php echo $filter_by;?></p>
              <div class="clear">&nbsp;</div>
            </div> -->
            <div class="clear">&nbsp;</div>
          </div>
          <?php if(!empty($rejected_articles_info)){?>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>              
              <th width="20%"><?php echo _("Article Topic");?></th>
              <th width="20%"><?php echo _("Article Title");?></th>
              <th width="19%"><?php echo _("Submitted By");?></th>
              <th width="10%"><?php echo _("Date");?></th>
              <th width="30%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
            </tr>
            <?php foreach($rejected_articles_info as $values){?>
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
              	<a href="javascript: void(0);" title="<?php echo $values['title'];?>" rel="popover" class="pop">
              		<?php 
              			if(strlen($values['title']) >= 40){
	              			echo substr($values['title'],0,40).'...';
	              		}else{
	              			echo $values['title'];
	              		}
		            ?>
		         </a>
              </td>
              <td width="19%"><?php echo $values['name']?></td>
              <td width="10%"><?php $timestamp = strtotime($values['date']); echo date('D', $timestamp);?>, <?php echo date('m-d-Y',$timestamp)?></td>
              <td width="30%">
                 <span class="btn"><?php echo $values['due_date'];?></span>
                 <span class="btn"><?php echo $values['length'];?></span>
                 <a href="#TB_inline?height=300&width=550&inlineId=content_<?php echo $values['article_id'];?>" class="thickbox"><span class="btn"><?php echo _("view");?></span></a>
                 <div id="content_<?php echo $values['article_id'];?>" style="display: none;">
		         	<div style="text-align: center"><h3><?php echo $values['title'];?></h3></div>
		         	<div><?php echo $values['content'];?></div>
		        </div>
              </td> 
            </tr>
            <?php }?>
          </table>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Rejected Articles");?></div>
          <?php }?>
        </div>
      </div>
      
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
</div>