<script src="<?php echo base_url();?>assets/scripts/thickbox.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/writer_css/thickbox.css" rel="stylesheet">
<!-- <script src="<?php echo base_url();?>assets/scripts/nicEdit.js" type="text/javascript"></script> -->
<script type="text/javascript" src="<?php echo base_url()?>assets/scripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	/*bkLib.onDomLoaded(function() {
		new nicEditor({iconsPath : '<?php echo base_url();?>assets/images/nicEditorIcons.gif'}).panelInstance('content');
		//new nicEditor({iconsPath : '<?php echo base_url();?>assets/images/nicEditorIcons.gif'}).panelInstance('decline_note');
	});*/
	$(document).ready(function(){
		$("#cancel").live('click',function(){
			//alert("jasdk");
			$("#TB_window").fadeOut();
			tb_remove();
		});
	});

	function checking_text(article_id){
		$('#loading_div').css('display','block');
		$.ajax({
			url: '<?php echo base_url();?>admin/checking_text/'+article_id,
			type:'POST',
			//dataType:'json',
			data:{'article_id':article_id},
			success:function(data){
				
				$('#copyscape_result').html(data);
				$('#copyscape_table').css('display','block');
				$('#loading_div').css('display','none');
			}
		});
	}

	
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "content",
		theme : "advanced",
		plugins : "autolink,pagebreak,style,table,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,print,visualchars,wordcount,advlist",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,undo,redo,|,link,unlink|,insertdate,inserttime,preview,|,forecolor,backcolor",
		//theme_advanced_buttons3 : "emotions,iespell,media,advhr,|,print,|,ltr,rtl",
		//theme_advanced_buttons4 : "visualchars,nonbreaking,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		//content_css : "writer_css/content.css",

		// Drop lists for link/image/media/template dialogs
		/*template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",*/

		// Style formats
		/*style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],*/

		/*formats : {
			alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'left'},
			aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'center'},
			alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'right'},
			alignfull : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
			bold : {inline : 'span', 'classes' : 'bold'},
			italic : {inline : 'span', 'classes' : 'italic'},
			underline : {inline : 'span', 'classes' : 'underline', exact : true},
			strikethrough : {inline : 'del'}
		},*/

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});

	function trigger_editor(){
		/*tinyMCE.init({
			// General options
			mode : "exact",
			elements : "decline_note",
			theme : "advanced",
			plugins : "autolink,pagebreak,style,table,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,print,visualchars,wordcount,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,undo,redo,|,link,unlink|,insertdate,inserttime,preview,|,forecolor,backcolor",
			//theme_advanced_buttons3 : "emotions,iespell,media,advhr,|,print,|,ltr,rtl",
			//theme_advanced_buttons4 : "visualchars,nonbreaking,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			template_replace_values : {
				username : "xyz",
				staffid : "991241"
			}
		});*/
	}
	
</script>
<style>
	#TB_window .nicEdit-main{
		height: 100px;
	}
	#loading_div{
		display: none;
		background: url('<?php echo base_url();?>assets/images/transparent_bg.png') repeat;
	    height: 100%;
	    left: 0;
	    position: fixed;
	    top: 0;
	    width: 100%;
	    z-index: 100;	
	}
	
	.inside_load{
		  margin: 0 auto;
    	padding-top: 200px;
    	width: 141px;
	}
</style>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo $article_info['0']['topic'];?></h2>
            <div class="links"> <a href="<?php echo base_url();?>admin/submitted"><?php echo _("Back to submitted");?></a>
              <div class="clear">&nbsp;</div>
            </div>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
              
                <form class="form-horizontal" action="" method="POST">
                	<input type="hidden" id="article_id" value="<?php echo $article_info['0']['article_id'];?>" name="article_id" />
                	<input type="hidden" id="writer_id" value="<?php echo $article_info['0']['writer_id'];?>" name="writer_id" />
                  <div class="control-group">
                    <label class="control-label" for="inputEmail"><?php echo _("Topic Title");?></label>
                    <div class="controls">
                      <input class="input-xxlarge" type="text" id="title" name="title" placeholder="" value="<?php echo $article_info['0']['title'];?>">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="inputPassword"><?php echo _("Topic Content");?></label>
                    <div class="controls">
                      <textarea rows="5" class="input-xxlarge" id="content" name="content"><?php echo $article_info['0']['content'];?></textarea>
                      <span id="html_view" style="display: none;"><?php echo $article_info['0']['content'];?></span>
                    </div>
                    <div class="controls">
                      <a href="javascript:;" onmousedown="tinyMCE.get('content').hide();"><button type="button" class="btn" id="button_for_html" name="button_for_html" value=""><i class="icon-time"></i> <?php echo _("HTML View");?></button></a>
                      <a href="javascript:;" onmousedown="tinyMCE.get('content').show();"><button type="button" class="btn" id="button_for_editor" name="button_for_editor" value=""><i class="icon-time"></i> <?php echo _("Editor View");?></button></a>
                    </div>
                  </div>
                  <div class="control-group">
                    <div class="controls">                     
                      <button type="submit" class="btn" id="approve" name="approve" value="approve"><i class="icon-check"></i> <?php echo _("Approve");?></button>
                      <button type="submit" class="btn" id="publish" name="publish" value="publish"><i class="icon-edit"></i> <?php echo _("Publish");?></button>
                      <button type="submit" class="btn" id="edit" name="edit" value="edit"><i class="icon-edit"></i> <?php echo _("Save");?></button>
                      <a href="#TB_inline?height=300&width=550&inlineId=reject_popup&modal=true" class="thickbox"><button type="submit" class="btn" id="reject" name="reject" value="reject" onClick="trigger_editor();"><i class="icon-ban-circle"></i> <?php echo _("Reject")?></button></a>
                      <button type="button" class="btn" id="copyscape" name="copyscape" value="copyscape" onclick="checking_text(<?php echo $article_info['0']['article_id'];?>);"><i class="icon-time"></i> <?php echo _("Copyscape");?></button>
                      <a href="#TB_inline?height=300&width=550&inlineId=content_<?php echo $article_info['0']['article_id'];?>" class="thickbox"><span class="btn"><?php echo _("Preview");?></span></a>
                    </div>
                  </div>
                </form>
                
               </td>
            </tr>
          </table>
          
          <table id="copyscape_table" class="table table-bordered table-striped" style="display: none;">
            <tr id="copyscape_result">
              
            </tr>
          </table>
        </div>
		<!-- ################## Popup ############################### -->        
        <div id="reject_popup" style="display: none;">
	        <form class="" action="" method="POST">
	        	<input type="hidden" id="article_id" value="<?php echo $article_info['0']['article_id'];?>" name="article_id" />
                <input type="hidden" id="writer_id" value="<?php echo $article_info['0']['writer_id'];?>" name="writer_id" />
	        	<div class="control-group">
	            	<label class="control-label" for="inputPassword"><?php echo _("Rejection Note");?></label>
	                <div class="controls">
	                	<textarea rows="7" style="min-height: 100px !important;" class="input-xxlarge" id="decline_note" name="decline_note"></textarea>
	                </div>
	            </div>
	                  
	            <div class="control-group">
	            	<div class="controls">                  
	                      <button type="submit" class="btn" id="reject" name="reject" value="reject"><i class="icon-check"></i> <?php echo _("Reject It")?></button>
	                      <button type="button" class="btn" id="cancel" name="cancel" value="cancel"><i class="icon-ban-circle"></i> <?php echo _("Not Now");?></button>
	                </div>
	            </div>
	        </form>
        </div>
        <div id="content_<?php echo $article_info['0']['article_id'];?>" style="display: none;">
         	<div style="text-align: center"><h3><?php echo $article_info['0']['title'];?></h3></div>
         	<div><?php echo $article_info['0']['content'];?></div>
        </div>
        <!-- ######################################################## -->
        <div id="loading_div">
        	<div class="inside_load">
         		<img src="<?php echo base_url();?>assets/images/processing.gif" alt="Please Wait..." />
         	</div>
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
</div>