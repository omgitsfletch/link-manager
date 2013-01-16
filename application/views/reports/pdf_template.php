<html>
<head>
	<style>
	@page {
		size: 8.5in 11in portrait;
		odd-header-name: _blank;
		even-header-name: _blank;
		odd-footer-name: _blank;
		even-footer-name: _blank;
		margin-left: 1in;
		margin-right: 1in;
	}
	@page default {
		size: 8.5in 11in portrait;
		odd-header-name: html_header;
		odd-footer-name: html_footer;
		even-header-name: html_header;
		even-footer-name: html_footer;
		margin-left: 1in;
		margin-right: 1in;
	}

	div.cover {
		padding-top: 4in;
		page-break-before: none;
		page-break-after: none;
	}
	div.summary {
		page: default;
		page-break-after: right;
	}
	div.links {
		page: default;
	}
	
	h1 {
		line-height: 20pt;
		font-size: 12pt;
		font-family: Arial;
		text-align: center;
		background-color: #000;
		color: #FFF;
	}
	.header {
		font-size: 18pt;
		font-family: Arial;
		font-weight: bold;
		text-align: center;
	}
	.sub_header {
		font-size: 10pt;
		font-family: Arial;
		text-align: center;
	}
	table#links { border-collapse: collapse; }
	table#links td { border: 1px solid black; }
	</style>
</head>
<body>

<htmlpageheader name="header" style="display:none">
<table width="100%" style="vertical-align: top;font-family:Arial">
	<tr>
		<td width="33%"><span style="font-size:12pt;">SEO Services</span></td>
		<td width="34%" align="center">&nbsp;</td>
		<td width="33%" style="text-align: right;"><span style="font-size:18pt;"><?php echo $site; ?></span></td>
	</tr>
</table>
</htmlpageheader>

<htmlpagefooter name="footer" style="display:none">
<table width="100%" style="font-family:Arial;font-size:10pt;">
	<tr>
		<td align="center">links.ziffen.com<br/>Page {PAGENO} of {nb}</td>
	</tr>
</table>
</htmlpagefooter>

<div class="cover">
	<span style="font-size:28pt;font-family:Arial;font-weight:bold;">Internet Marketing Report</span><br/>
	<span style="font-size:18pt;font-family:Arial;font-weight:bold;">SEO Services</span>
</div>

<div class="summary">
	<h1>Report Summary</h1>
	<p style="font-size:10pt;font-family:Arial;"><?php echo nl2br($summary); ?></p>
</div>

<div class="links">
	<h1>Link Detail Report</h1>
	<p class="header">Link Detail for <?php echo $site; ?></p>
	<p class="sub_header"><?php echo $start_date; ?> - <?php echo $end_date; ?></p>

	<!--<p class="header">Active Links</p>!-->
	<table width="100%" cellpadding="0" cellspacing="0" id="links">
		<tr>
			<td style="background-color:#000000;color:#FFFFFF">Link</td>
			<td style="background-color:#000000;color:#FFFFFF">Link Text</td>
		</tr>
<?php foreach ($links AS $link): ?>
		<tr>
			<td><?php echo $link->url; ?></td>
			<td><?php echo $link->text; ?></td>
		</tr>
<?php endforeach; ?>
	</table>
</div>

</body>
</html>