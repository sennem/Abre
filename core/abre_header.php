<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */

//Display correct header  
if (file_exists('configuration.php'))
{
	require_once('abre_functions.php'); 
?>
	<!doctype html>
	<html lang='en'>
		<head>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<?php 
			echo "<meta name='description' content='".sitesettings("sitedescription")."'>";
			?>
			<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
			<?php
				
			//Site title
			echo "<title>".sitesettings("sitetitle")."</title>";
			
			//Site favicon
			echo "<link rel='icon' type='image/png' href='core/images/".sitesettings("sitelogo")."'>";
	
			//Chrome icon
			echo "<meta name='mobile-web-app-capable' content='yes'>";
			echo "<link rel='icon' sizes='192x192' href='core/images/".sitesettings("sitelogo")."'>";
	
			//iOS icon
			echo "<meta name='apple-mobile-web-app-title' content='".sitesettings("sitetitle")."'>";
			echo "<link rel='apple-touch-icon' href='core/images/".sitesettings("sitelogo")."'>";
	
			//Windows icon
			echo "<meta name='msapplication-TileImage' content='core/images/".sitesettings("sitelogo")."'>";
			echo "<meta name='msapplication-TileColor' content='".sitesettings("sitecolor")."'>";
			?>
	
		    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900,100' rel='stylesheet' type='text/css'>
		    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
		    <link rel='stylesheet' href='core/css/materialize.0.97.5.min.css'>
		    <link rel='stylesheet' href='core/css/material.1.1.3.min.css'>
		    <link rel='stylesheet' href='core/css/abre.1.1.9.css'>
		    <link rel='stylesheet' href='core/css/animate.min.css'>
		    <link rel='stylesheet' href='core/css/timepicker.min.css'>
		    <link rel='stylesheet' href='modules/books/css/main.css'>
		    <link rel="stylesheet" href='modules/profile/css/calendar.css'>
	    
		    <script src='core/js/jquery-2.1.4.min.js'></script>
		    <script src='core/js/jquery-ui.min.js'></script>
		    <script src='core/js/materialize.0.97.5.min.js'></script>
		    <script src='core/js/material.1.1.3.min.js'></script>
		    <script src='core/js/routie.min.js'></script>
		    <script src='core/js/masonry-4.0.0.pkgd.min.js'></script>
		    <script src='core/js/jquery.tablesorter.min.js'></script>
		    <script src='core/js/jquery.timepicker.min.js'></script>
		    <script src='modules/profile/js/jquery-ui.multidatespicker.js'></script>
		    
		</head>
		<body>

<?php
}
else
{
?>
	<!doctype html>
	<html lang='en'>
		<head>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
			<title>Abre Installation</title>
	
		    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900,100' rel='stylesheet' type='text/css'>
		    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
		    <link rel='stylesheet' href='core/css/materialize.0.97.5.min.css'>
		    <link rel='stylesheet' href='core/css/material.1.1.3.min.css'>
		    <link rel='stylesheet' href='core/css/abre.1.1.9.css'>
	    
		    <script src='core/js/jquery-2.1.4.min.js'></script>
		    <script src='core/js/jquery-ui.min.js'></script>
		    <script src='core/js/materialize.0.97.5.min.js'></script>
			<script src='core/js/material.1.1.3.min.js'></script>
			    
		</head>
		<body>	 
<?php
}
?>
<script>
	//$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
		//options.async = false;
	//});
</script>