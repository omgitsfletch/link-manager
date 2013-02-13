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
                /*height: 420px;*/
                margin: 10px auto;
            }
            
            .chart_container{
                width: 100%;
                height: 300px;
                margin: 0px;
            }
            
</style>
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
		            	<div class="chart_container_centered" >
		                <canvas id="chartCanvas1" width='1200px' height='300px' style="max-width: 100%;">
		                    <?php echo _("Your web-browser does not support the HTML 5 canvas element.");?>
		                </canvas>
		                </div>
		            </div>
		        </div>
              </td>
            </tr>
          </table>
        </div>
        
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo _("Your Summary");?></h2>
            <div class="links"> <a href="#"># <?php echo _("of Submissions");?></a>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th width="1%">&nbsp;</th>
              <!-- <th width="39%"><?php echo _("Writer");?></th> -->
              <th width="15%"><?php echo _("Today");?></th>
              <th width="15%"><?php echo _("Yesterday");?></th>
              <th width="15%"><?php echo _("Last 7d");?></th>
              <th width="15%"><?php echo _("Month");?></th>
            </tr>
            <tr>
              <td width="1%"><i class="icon-circle-arrow-right"></i></td>
              <td width="15%"><?php echo $infos['todays'];?></td>
              <td width="15%"><?php echo $infos['yesterday'];?></td>
              <td width="15%"><?php echo $infos['last_7_day'];?></td>
              <td width="15%"><?php echo $infos['this_month'];?></td>
            </tr>
          </table>
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
<?php include('footer.php');?>