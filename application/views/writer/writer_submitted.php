<?php include("header.php");?><script>
	$(document).ready(function(){
		$('.pop').popover();
	});
</script>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Submitted");?></h2>
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
              <th width="20%"><?php echo _("Article Title");?></th>
              <th width="10%"><?php echo _("Date");?></th>
              <th width="20%"><?php echo _("Due Day");?> / <?php echo _("Length");?></th>
              <th width="20%"><?php echo _("Status");?></th>
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
              <td width="10%"><?php $timestamp = strtotime($values['submitted_date']); echo date('D', $timestamp);?>, <?php echo date('d-m-Y',$timestamp)?></td>
              <td width="20%">
                 <span class="btn"><?php echo $values['due_date'];?></span>
                 <span class="btn"><?php echo $values['length'];?></span>
              </td> 
              <td width="19%"><?php echo $values['status'];?></td>
            </tr>
            <?php }?>
          </table>
          <?php }else{?>
          <div class="no_info"><?php echo _("No Submitted Articles");?></div>
          <?php }?>          
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
<?php include('footer.php');?>