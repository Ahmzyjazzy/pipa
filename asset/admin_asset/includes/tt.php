<?php
if(isset($_POST['lod'])){
lod();	
}

function lod(){
$url = "http://localhost/shopcart/";
echo "
	<link id='bs-css' href='".base_url()."'asset/admin_asset/css/bootstrap-classic.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/bootstrap-responsive.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/charisma-app.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/jquery-ui-1.8.21.custom.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/fullcalendar.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='".base_url()."'asset/admin_asset/css/chosen.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/uniform.default.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/colorbox.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/jquery.cleditor.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/jquery.noty.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/noty_theme_default.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/elfinder.min.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/elfinder.theme.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/opa-icons.css' rel='stylesheet'>
	<link href='".base_url()."'asset/admin_asset/css/uploadify.css' rel='stylesheet'>
";
}
?>