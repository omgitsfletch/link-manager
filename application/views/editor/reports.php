<?php include("header.php");?>
<script src="<?php echo base_url();?>assets/scripts/bootstrap-datepicker.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/css/datepicker.css" rel="stylesheet">
<input type="hidden" class="numeric" id="items_per_page" name="items_per_page" value="10">
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery.pagination.js" ></script>
<link href="<?php echo base_url();?>assets/css/pagination.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
<?php
		$member = 'var members = new Array();';
		$member = 'var members = '.count($reports).';';
		echo $member;
?>
function getOptionsFromForm(){
    var opt = {callback: pageselectCallback};
    // Collect options from the text fields - the fields are named like their option counterparts
    $("#items_per_page").each(function(){
        opt[this.name] = this.className.match(/numeric/) ? parseInt(this.value) : this.value;
    });
    return opt;
}
function pageselectCallback(page_index, jq){
    // Get number of elements per pagionation page from form
	$('#wait').css('display','block');
    var items_per_page = $('#items_per_page').val();
    var max_elem = Math.min(items_per_page, (members -(items_per_page*(page_index))));
    var is_filter = 0;
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    if((curent_date != end_date || curent_date != start_date)){
    	is_filter = 1;
    }
    $.ajax({
		url: site_url+'editor/report_ajax',
		type:'POST',
		data:{
				submit: is_filter,
				start_date: start_date,
				end_date: end_date,
				start:page_index*items_per_page,
				limit: max_elem,
			},
		success: function(data){
				$('#report').html(data);
				$('#wait').css('display','none');
			}
	});
    // Prevent click event propagation
    return false;
}

   $(document).ready(function(){

       $('.btn').tooltip();
       $('.pop').popover();
       
       var startDate = new Date();
       startDate = '<?php echo date('Y-m-d');?>';
	   var endDate = new Date();
	   endDate = '<?php echo date('Y-m-d');?>';
		$('#start_date').datepicker()
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

		 $('#wait').css('display','block');
		 //Pagination for most rated images at top of the page
		 var optInit = getOptionsFromForm();
		 $("#Pagination").pagination(members, optInit); 

		 $('.detail_report').live('click',function(){

			 var start_date = $('#start_date').val();
		     var end_date = $('#end_date').val();
		     if((curent_date != end_date || curent_date != start_date)){
		    	window.location = '<?php echo base_url();?>editor/detail_report/'+$(this).attr('rel')+'/'+encodeURIComponent(start_date)+'/'+encodeURIComponent(end_date);
		     }else{
		    	window.location = '<?php echo base_url();?>editor/detail_report/'+$(this).attr('rel');
			 }
		 });
   });
</script>
<?php $approved = 0; $published = 0; $submitted = 0; $rejected = 0; $total_rejected=0; $timeouts=0;?>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="date_wrap" style="float: right;">
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
          <div class="clear">&nbsp;</div>
          <div class="head_wrap">
            <h2><?php echo _("Report");?></h2>
            <!-- <div class="links"> <a href="<?php echo base_url();?>editor/submitted"># <?php echo _("of Submissions");?></a>
              <div class="clear">&nbsp;</div>
            </div> -->
            <div class="clear">&nbsp;</div>
          </div>
          <table id="report" class="table table-bordered table-striped">
            <!-- <tr>
              <th width="1%">&nbsp;</th>
              <th width="20%"><?php echo _("Writer");?></th>
              <th width="10%"><?php echo _("Approved");?></th>
              <th width="10%"><?php echo _("Published");?></th>
              <th width="10%"><?php echo _("Submitted");?></th>
              <th width="10%"><?php echo _("Rejected");?></th>
              <th width="9%"><?php echo _("Total Rejections");?></th>
              <th width="8%"><?php echo _("Timeouts");?></th>
              <th width="10%"><?php echo _("Total Words(Approved)");?></th>
              <th width="15%"><?php echo _("Detail Report");?></th>
            </tr>
            <?php foreach($reports as $report){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
              <td width="20%"><a href="javascript: void(0);"><?php echo $report['name'];?></a></td>
              <td width="10%"><?php echo $report['approved'];?></td>
              <td width="10%"><?php echo $report['published'];?></td>
              <td width="10%"><?php echo $report['submitted'];?></td>
              <td width="10%"><?php echo $report['rejected'];?></td>
              <td width="9%"><?php echo $report['total_rejections'];?></td>
              <td width="8%"><?php echo $report['timeouts'];?></td>
              <td width="10%"><?php echo $report['words'];?></td>
              <td width="15%">
              	<a href="<?php echo base_url();?>editor/detail_report/<?php echo $report['id'];?>"><button type="button" class="btn" name="detail" value="detail" title="Detail Report"><?php echo _("Detail");?></button></a>
              </td>
            </tr>
            <?php $approved += $report['approved'];?>
            <?php $published += $report['published'];?>
            <?php $submitted += $report['submitted'];?>
            <?php $rejected += $report['rejected'];?>
            <?php $total_rejected += $report['total_rejections'];?>
            <?php $timeouts += $report['timeouts'];?>
            <?php }?>
            <tr class="success">
              <td width="1%"><i class="icon-hand-right"></i></td>
              <td width="20%"><b>Totals</b></td>
              <td width="10%"><b><?php echo $approved;?></b></td>
              <td width="10%"><b><?php echo $published;?></b></td>
              <td width="10%"><b><?php echo $submitted;?></b></td>
              <td width="10%"><b><?php echo $rejected;?></b></td>
              <td width="9%"><b><?php echo $total_rejected;?></b></td>
              <td width="8%"><b><?php echo $timeouts;?></b></td>
              <td width="10%"><b>&nbsp;</b></td>
              <td width="15%"><b>&nbsp;</b></td>
            </tr> -->
          </table>
          <div id="Pagination" <?php if(count($reports) == 0){?>style="display: none;"<?php }?>></div>
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
<?php include('footer.php');?>