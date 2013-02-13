<?php include("header.php");?>
<script src="<?php echo base_url();?>assets/scripts/bootstrap-datepicker.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/css/datepicker.css" rel="stylesheet">
<script type="text/javascript">
   $(document).ready(function(){
       $('.btn').tooltip();
       var startDate = new Date();
       startDate = '<?php echo date('Y-m-d');?>';
	   var endDate = new Date();
	   endDate = '<?php echo date('Y-m-d');?>';
		/*$('#start_date').datepicker()
			.on('changeDate', function(ev){
				if (ev.date.valueOf() > endDate.valueOf()){
					alert('The start date can not be greater then the end date');
				} else {
					startDate = new Date(ev.date);
					$('#startDate').text($('#startDate').data('date'));
				}
				$('#start_date').datepicker('hide');
			});
		$('#end_date').datepicker()
			.on('changeDate', function(ev){
				if (ev.date.valueOf() < startDate.valueOf()){
					alert('The end date can not be less then the start date');
				} else {
					endDate = new Date(ev.date);
					$('#end_date').text($('#end_date').data('date'));
				}
				$('#end_date').datepicker('hide');
			});
       
       $('.pop').popover();*/
   });
</script>
<?php $approved = 0; $published = 0; $submitted = 0; $rejected = 0;?>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <!-- <div class="date_wrap" style="float: right;">
          	<form action="" method="POST">
          	<div class="links" style="padding-right: 10px; float: left;">
            	<span style="color: #000;" ><?php echo _("Start Date");?></span>
            	<div class="input-append date" id="dp_start" data-date="<?php echo date("Y-m-d");?>" >
					<input class="input-small" type="text" name="start_date" id="start_date" value="<?php if(isset($s_date)){ echo $s_date; }else{ echo date("Y-m-d"); }?>" data-date-format="yyyy-mm-dd">
				</div>
            </div>
            <div class="links" style="padding-right: 10px; float: left;">
            	<span style="color: #000;" ><?php echo _("End Date");?></span>
            	<div class="input-append date" id="dp_end" data-date="<?php echo date("Y-m-d");?>">
					<input class="input-small" type="text" name="end_date" id="end_date" value="<?php if(isset($e_date)){ echo $e_date; }else{ echo date("Y-m-d"); }?>" data-date-format="yyyy-mm-dd">
				</div>		
            </div>
            <div class="links" style="padding-right: 10px; float: left;">
            	<span style="color: #000; display: block;" >&nbsp;</span>
            	<button type="submit" class="btn" id="submit" name="submit" value="filter"><i class="icon-check"></i> <?php echo _("Filter");?></button>
            </div>
            <div class="clear">&nbsp;</div>
            </form>
          </div>
          <div class="clear">&nbsp;</div> -->
          <div class="head_wrap">
            <h2><?php echo $detail_report['writer_name'];?></h2>
            <!-- <div class="links"> <a href="<?php echo base_url();?>editor/submitted"># <?php echo _("of Submissions");?></a>
              <div class="clear">&nbsp;</div>
            </div> -->
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="10%">&nbsp;</th>
              <th width="30%"><?php echo _("Article");?></th>
              <th width="30%"><?php echo _("Number of articles");?></th>
              <th width="30%"><?php echo _("Total Words(Approved)");?></th>
            </tr>
            <tr>
              <td width="10%"><i class="icon-circle-arrow-right"></i></td>
              <td width="30%"><a href="javascript: void(0);"><?php echo _('Approved');?></a></td>
              <td width="30%"><?php echo $detail_report['approved_count'];?></td>
              <td width="30%"><?php echo $detail_report['approved_words'];?></td>
            </tr>
            <tr>
              <td width="10%"><i class="icon-circle-arrow-right"></i></td>
              <td width="30%"><a href="javascript: void(0);"><?php echo _('Pending');?></a></td>
              <td width="30%"><?php echo $detail_report['submitted_count'];?></td>
              <td width="30%"><?php echo $detail_report['submitted_words'];?></td>
            </tr>
            <tr>
              <td width="10%"><i class="icon-circle-arrow-right"></i></td>
              <td width="30%"><a href="javascript: void(0);"><?php echo _('Published');?></a></td>
              <td width="30%"><?php echo $detail_report['published_count'];?></td>
              <td width="30%"><?php echo $detail_report['published_words'];?></td>
            </tr>
            <tr class="success">
              <td width="1%"><i class="icon-hand-right"></i></td>
              <td width="30%"><b><?php echo _('Submitted');?></b></td>
              <td width="30%"><b><?php echo ($detail_report['approved_count'] + $detail_report['submitted_count'] + $detail_report['published_count']);?></b></td>
              <td width="30%"><b><?php echo ($detail_report['approved_words'] + $detail_report['submitted_words'] + $detail_report['published_words']);?></b></td>
            </tr>
          </table>
          <div><?php //echo $this->pagination->create_links();?></div>
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
<?php include('footer.php');?>