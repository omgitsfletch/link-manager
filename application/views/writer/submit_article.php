<?php include("header.php");?>
<!-- <script src="<?php echo base_url();?>assets/scripts/nicEdit.js" type="text/javascript"></script> -->
<script type="text/javascript" src="<?php echo base_url()?>assets/scripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var nEdit = '';
	});
	/*bkLib.onDomLoaded(function() {
		nEdit = new nicEditor({iconsPath : '<?php echo base_url();?>assets/images/nicEditorIcons.gif'}).panelInstance('article_content');
		//new nicEditor({iconsPath : '<?php echo base_url();?>assets/images/nicEditorIcons.gif'}).panelInstance('decline_note');
	});

	function addnEdit() {
		//$("#html").removeClass("btn-success");
		//$("#editor").addClass("btn-success");
		nEdit = new nicEditor({iconsPath : '<?php echo base_url();?>assets/images/nicEditorIcons.gif'}).panelInstance('article_content');
	}
	function removenEdit() {
		//$("#editor").removeClass("btn-success");
		//$("#html").addClass("btn-success");
		nEdit.removeInstance('article_content');
	}*/
	tinyMCE.init({
		// General options
		mode : "textareas",
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
</script>
<div id="main" class="container-fluid" >
    <div class="row-fluid">
      <div class="span12">
        <div class="table_wrap">
          <div class="head_wrap">
            <h2><?php echo $article_info['0']['topic'];?></h2>
            <div class="clear">&nbsp;</div>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <td>
                <?php if(isset($error)){?>
              	<div class="control-group">
                    <label class="control-label" for="inputPassword"><?php echo _("Errors");?>: <span style="color:red;"><?php echo $error;?></span></label>
                </div>
                <?php }?>              
                <form class="form-horizontal" action="" method="POST">
                	<input type="hidden" id="article_id" value="<?php echo $article_info['0']['article_id'];?>" name="article_id" />
                	<input type="hidden" id="writer_id" value="<?php echo $article_info['0']['writer_id'];?>" name="writer_id" />
                	<input type="hidden" id="due_date" value="<?php echo $article_info['0']['due_time'];?>" name="due_date" />
                	<input type="hidden" id="claimed_date" value="<?php echo $article_info['0']['claimed_time'];?>" name="claimed_date" />
                  <div class="control-group">
                    <label class="control-label" for="inputEmail"><?php echo _("Topic Title");?></label>
                    <div class="controls">
                      <input class="input-xxlarge" type="text" id="article_title" name="article_title" placeholder="" value="<?php if(isset($title)){ echo $title;}?>">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="inputPassword"><?php echo _("Topic Content");?></label>
                    <div class="controls">
                      <textarea rows="10" class="input-xxlarge" id="article_content" name="article_content"><?php if(isset($content)){ echo $content;}?></textarea>
                    </div>
                    <div class="controls">
                      <a href="javascript:;" onmousedown="tinyMCE.get('article_content').show();"><span id="editor" class="btn"><?php echo _("Editor view");?></span></a>
					  <a href="javascript:;" onmousedown="tinyMCE.get('article_content').hide();"><span id="html" class="btn "><?php echo _("HTML View");?></span></a>
                    </div>
                  </div>
                  <div class="control-group">
                    <div class="controls">                     
                      <button type="submit" class="btn" id="submit" name="submit" value="submit"><i class="icon-check"></i> <?php echo _("Submit");?></button>
                    </div>
                  </div>
                </form>
                
                  <div class="control-group">
                    <label class="control-label" for="inputPassword"><?php echo _("Information Required");?><span style="color:red;">*</span></label>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="inputPassword"><?php echo _("Minimum Length");?>: <span style="color:red;"><?php if($info_required['0']['length'] && is_numeric($info_required['0']['length'])){ echo $info_required['0']['length'];}else{ echo "--";}?></span></label>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="inputPassword"><?php echo _("Keywords");?>: <span style="color:red;"><?php if($info_required['0']['keywords'] != ''){ echo $info_required['0']['keywords'];}else{ echo "--";}?></span></label>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="inputPassword"><?php echo _("Urls");?>&nbsp;(<?php echo _("optional");?>): <span style="color:red;"><?php echo $info_required['0']['urls'];?></span></label>
                  </div>
               </td>
            </tr>
          </table>
        </div>
      </div>
      <!--/row-->
      <!--/span-->
    </div>
    <!--/row-->
<?php include('footer.php');?>