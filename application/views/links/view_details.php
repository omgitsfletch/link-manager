<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<?php echo css_asset('screen.css', NULL, array('media' => 'screen', 'title' => 'default')) . "\n"; ?>
</head>
<body>
<div id="content-table-inner" style="padding:0">
	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
		<tr>
			<th class="table-header-repeat line-left minwidth-1"><a href="#">Field</a></th>
			<th class="table-header-repeat line-left minwidth-1"><a href="#">Data</a></th>
		</tr>
	<?php
		$count = 0;
		foreach ($link AS $field => $data) {
			$count++;
	?>
		<tr class="<?php echo ($count % 2 == 0) ? 'alternate-row' : ''; ?>">
			<td><?php echo $field; ?>:</td>
			<td><?php echo $data; ?></td>
		</tr>
	<? } ?>
	</table>
	<div style="width: 100%; text-align:right;"><a href="javascript: self.close()" style="color:black;">Close [X]</a>&nbsp;&nbsp;&nbsp;</div>
</div>

</body>
</html>