<?php
$vars['sites_dropdown'] = generate_sites_dropdown();
$vars['groups_dropdown'] = generate_groups_dropdown();

$this->load->view('header', $vars);

$vars['title'] = (isset($title)) ? $title : '';

if (isset($page))
	$this->load->view($page, $vars);

$this->load->view('footer');
?>