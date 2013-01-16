<html>
<head>
	<?php echo css_asset('screen.css', NULL, array('media' => 'screen', 'title' => 'default')) . "\n"; ?>
</head>
<body>
<div id="content-table-inner">
<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
	<tr>
		<th valign="top">Link Location:</th>
		<td><?php echo (isset($link->location) ? $link->location : ''); ?></td>
	</tr>
	<tr>
		<th valign="top">Anchor Text:</th>
		<td><?php echo (isset($link->text) ? $link->text : $this->session->userdata('site_url')); ?></td>
	</tr>
	<tr>
		<th valign="top">URL:</th>
		<td><?php echo (isset($link->url) ? $link->url : ''); ?></td>
	</tr>
	<tr>
		<th valign="top">Date:</th>
		<td><?php echo (isset($link->date) ? $link->date : date('Y-m-d')); ?></td>
	</tr>
	<tr>
		<th valign="top">Status:</th>
		<td>
<?php
if (is_array($statuses) && count($statuses) > 0) {
	foreach ($statuses AS $status) {
		if ((isset($link->status_id)) && ($link->status_id == $status->status_id))
			echo $status->status;
	}
} else {
echo '** No statuses found! **';
}
?>
		</td>
	</tr>
	<tr>
		<th valign="top">Type:</th>
		<td>
<?php
if (is_array($types) && count($types) > 0) {
	foreach ($types AS $type) {
		if ((isset($link->type_id)) && ($link->type_id == $type->type_id))
			echo $type->type;
	}
} else {
echo '** No types found! **';
}
?>
		</td>
	</tr>
	<tr>
		<th valign="top">Contact E-mail:</th>
		<td><?php echo (isset($link->contact_email) ? $link->contact_email : ''); ?></td>
	</tr>
	<tr>
		<th valign="top">Contact Name:</th>
		<td><?php echo (isset($link->contact_name) ? $link->contact_name : ''); ?></td>
	</tr>
	<tr>
		<th valign="top">Category:</th>
		<td>
<?php
if (is_array($categories) && count($categories) > 0) {
	foreach ($categories AS $category) {
		if ((isset($link->category_id)) && ($link->category_id == $category->category_id))
			echo $category->category;
	}
} else {
echo '** No categories found! **';
}
?>
		</td>
	</tr>
	<tr>
		<th valign="top">Notes:</th>
		<td><?php echo (isset($link->notes) ? $link->notes : ''); ?></td>
	</tr>
</table>
</div>
</body>
</html>