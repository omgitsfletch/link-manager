<?php include("header.php");?>
<script type="application/javascript" src="<?php echo base_url();?>assets/scripts/awesomechart.js"> </script>
<script>
	<?php
		$graph_lable = 'var g_lable = new Array();';
		$graph_value = 'var g_value = new Array();';
		$counter = 0;
		foreach($graph as $values){
			$graph_lable .= 'g_lable['.$counter.'] = ["'.$values['date'].'"];';
			$graph_value .= 'g_value['.$counter.'] = ['.$values['count'].'];';
			$counter++;
		}
		echo $graph_lable;
		echo $graph_value;
	?>
	$(document).ready(function(){
		$('.num_of_items').dropdown()
		$("#num_of_items").change(function(){
			$.post('<?php echo base_url().'editor/change_per_page'?>',{page: $(this).val()},function(response){
					if(response){
						window.location = '<?php echo base_url()?>editor/dashboard';
					}
				});
		});
		var chart1 = new AwesomeChart('chartCanvas1');
	    chart1.title = "Submitted Article in last 10 days";
	    chart1.data = g_value;
	    chart1.labels = g_lable;
	    chart1.colors = ['#006CFF', '#FF6600', '#34A038', '#945D59', '#93BBF4', '#F493B8'];
	    chart1.randomColors = true;
	    chart1.animate = true;
	    chart1.animationFrames = 70;
	    chart1.draw();
	});
	
</script>
<style>
        
            .charts_container{
                /*width: 900px;*/
                height: 300px;
                margin: 10px auto;
            }
            
            .chart_container_centered{
                text-align: center;
                /*width: 900px;*/
                height: 420px;
                margin: 10px auto;
            }
            
            .chart_container{
                width: 100%;
                height: 300px;
                margin: 0px 25px;
            }
            
</style>
<?php $today = 0; $yesterday = 0; $last_7_day = 0; $this_month = 0;?>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
      	<div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Overview");?></h2>
            <!-- <div class="links"> <a href="#">Per Day</a> <a href="#">Per Words</a>
              <div class="clear">&nbsp;</div>
            </div> -->
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
              	<div class="charts_container">
		            <div class="chart_container">
		            
		                <canvas id="chartCanvas1" width='1240px' height='300px'>
		                    <?php echo _("Your web-browser does not support the HTML 5 canvas element.");?>
		                </canvas>
		                
		            </div>
		        </div>
              </td>
            </tr>
          </table>
        </div>
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Writer Summary");?></h2>
            <div class="links"> <a href="<?php echo base_url();?>editor/submitted"># <?php echo _("of Submissions");?></a>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="links" style="padding-right: 10px;">
            	<span style="color: #F2F2F2;" ># <?php echo _("of items per page");?></span>
            	<select id="num_of_items" name="num_of_items" class="num_of_items">
            		<option value="1" <?php if($item_per_page == 1){?>selected="selected"<?php }?> >1</option>
            		<option value="2" <?php if($item_per_page == 2){?>selected="selected"<?php }?> >2</option>
            		<option value="5" <?php if($item_per_page == 5){?>selected="selected"<?php }?> >5</option>
            		<option value="10" <?php if($item_per_page == 10){?>selected="selected"<?php }?>>10</option>
            		<option value="15" <?php if($item_per_page == 15){?>selected="selected"<?php }?>>15</option>
            		<option value="20" <?php if($item_per_page == 20){?>selected="selected"<?php }?>>20</option>
            	</select>		
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <th width="24%"><?php echo _("Writer");?></th>
              <th width="15%"><?php echo _("Today");?></th>
              <th width="15%"><?php echo _("Yesterday");?></th>
              <th width="15%"><?php echo _("Last 7d");?></th>
              <th width="15%"><?php echo _("Month");?></th>
              <th width="15%"><?php echo _("Last Login");?></th>
            </tr>
            <?php foreach($infos as $values){?>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
              <td width="24%"><a href="javascript: void(0);"><?php echo $values['name'];?></a></td>
              <td width="15%"><?php echo $values['todays'];?></td>
              <td width="15%"><?php echo $values['yesterday'];?></td>
              <td width="15%"><?php echo $values['last_7_day'];?></td>
              <td width="15%"><?php echo $values['this_month'];?></td>
              <td width="15%">
              	<?php
					  if($values['last_login'] != "0000-00-00 00:00:00"){
              		  	$login_time = strtotime($values['last_login']);
						$current_Time = strtotime(date('Y-m-d H:i:s'));
						//echo $values['last_login'].'<br />'.date('Y-m-d H:i:s').'<br />';
						//echo $login_time.'--'.$current_Time;
						$time_diff = $current_Time - $login_time;
						//$hours = abs(floor(($time_left)/3600));
						if((int)($time_diff/(60*60*24)) > 0)
							echo (int)($time_diff/(60*60*24)).' days ago';
						elseif((int)($time_diff/(60*60)) > 0)
							echo (int)($time_diff/(60*60)).' hours ago';
						elseif((int)($time_diff/60) > 0)
							echo (int)($time_diff/60).' minutes ago';
						else
							echo (int)($time_diff).' seconds ago';
              		  }
              		  else{
              			echo 'Not logged in yet';
              		  }               							
              	?>
              </td>
            </tr>
            <?php $today += $values['todays'];?>
            <?php $yesterday += $values['yesterday'];?>
            <?php $last_7_day += $values['last_7_day'];?>
            <?php $this_month += $values['this_month'];?>
            <?php }?>
            <tr class="success">
              <td width="1%"><i class="icon-hand-right"></i></td>
              <td width="24%"><b>Totals</b></td>
              <td width="15%"><b><?php echo $today;?></b></td>
              <td width="15%"><b><?php echo $yesterday;?></b></td>
              <td width="15%"><b><?php echo $last_7_day;?></b></td>
              <td width="15%"><b><?php echo $this_month;?></b></td>
              <td width="15%"><b>&nbsp;</b></td>
            </tr>
          </table>
          <div><?php echo $this->pagination->create_links();?></div>
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
<?php include('footer.php');?>